<?php

namespace App\Controllers;

use App\Services\AiService;
use App\Core\Database;
use App\Core\RateLimiter;

class ChatController
{
    private AiService $aiService;

    public function __construct()
    {
        $this->aiService = new AiService();
    }

    public function send()
    {
        ini_set('display_errors', 0);
        error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);

        header('Content-Type: application/json');
        RateLimiter::enforce('chat_send', 30, 60);

        try {
            $authService = new \App\Services\AuthService();
            $headers = getallheaders();
            $authHeader = $headers['Authorization'] ?? '';
            $token = str_replace('Bearer ', '', $authHeader);
            
            if (!$token && isset($_COOKIE['auth_token'])) {
                $token = $_COOKIE['auth_token'];
            }

            $tokenData = null;
            if ($token) {
                try {
                    $tokenData = $authService->validateToken($token);
                } catch (\Exception $e) {
                }
            }

            if (!$tokenData) {
                // Anonymous user
                $userId = null;
                $user = null;
            } else {
                $userId = $tokenData['sub'];
                $db = Database::getInstance()->getConnection();
                $stmt = $db->prepare("SELECT id, full_name, email, phone FROM study_users WHERE id = ?");
                $stmt->execute([$userId]);
                $user = $stmt->fetch(\PDO::FETCH_ASSOC);
            }

            $input = json_decode(file_get_contents('php://input'), true);
            $message = $input['message'] ?? '';
            $history = $input['history'] ?? [];
            $sessionId = $input['session_id'] ?? null;

            if (empty($message)) {
                echo json_encode(['error' => 'Message is required']);
                return;
            }

            $formattedHistory = [];
            foreach ($history as $msg) {
                $formattedHistory[] = [
                    'role' => $msg['sender'] === 'user' ? 'user' : 'assistant',
                    'content' => $msg['text']
                ];
            }
            
            $formattedHistory[] = ['role' => 'user', 'content' => $message];

            if ($userId) {
                $existingLead = $this->getLeadByUser($userId); 
            } else {
                $existingLead = $this->getLeadBySession($sessionId);
            }
            
            $context = [];
            if ($existingLead) {
                $details = json_decode($existingLead['details'] ?? '{}', true);
                $context = [
                    'name' => $existingLead['name'] ?? 'Гость',
                    'phone' => $existingLead['phone'],
                    'budget' => $existingLead['budget'],
                    'gpa' => $existingLead['gpa'],
                    'language_level' => $existingLead['language_level'],
                    'details' => $details,
                    'program_of_interest' => $details['program_of_interest'] ?? null,
                    'selected_university' => $details['university'] ?? $details['desired_university'] ?? null
                ];
            } else {
                $context = [
                    'name' => $user ? $user['full_name'] : 'Гость',
                    'phone' => $user ? $user['phone'] : null, 
                    'email' => $user ? $user['email'] : null
                ];
            }

            $userProfile = null;
            if ($userId) {
                $profileStmt = $db->prepare("
                    SELECT ud.*, su.name as university_name 
                    FROM study_user_details ud 
                    LEFT JOIN study_universities su ON ud.desired_university_id = su.id 
                    WHERE ud.user_id = ?
                ");
                $profileStmt->execute([$userId]);
                $userProfile = $profileStmt->fetch(\PDO::FETCH_ASSOC);
            }

            $profileFilled = false;
            $programSelected = false;
            if ($userProfile) {
                $profileFilled = !empty($userProfile['passport_number']) && !empty($userProfile['iin']);
                $programSelected = !empty($userProfile['desired_country']) && !empty($userProfile['desired_university_id']);
                if ($userProfile['university_name']) {
                    $context['selected_university'] = $userProfile['university_name'];
                }
                if ($userProfile['desired_country']) {
                    $context['selected_country'] = $userProfile['desired_country'];
                }
                if ($userProfile['desired_program']) {
                    $context['selected_program'] = $userProfile['desired_program'];
                }
            }
            $context['profile_filled'] = $profileFilled;
            $context['program_selected'] = $programSelected;

            $managerModel = new \App\Models\Manager();
            $activeManager = $managerModel->getRandomActive();
            if ($activeManager) {
                $context['manager_phone'] = $activeManager['phone'];
                $context['manager_name'] = $activeManager['name'];
            }

            $lang = $_GET['lang'] ?? $_COOKIE['lang'] ?? 'ru';
            if (!in_array($lang, ['ru', 'kk'])) {
                $lang = 'ru';
            }

            $aiResult = $this->aiService->getResponse($formattedHistory, $context, $lang);
            
            $aiResponseText = $aiResult['reply'];
            $aiData = $aiResult['data'];

            if (substr_count($aiResponseText, "\n") < 2) {
                $aiResponseText = preg_replace('/([.!?])\s+([А-ЯA-Z🎯📋📍💼💰✨🎓])/u', "$1\n\n$2", $aiResponseText);
            }

            $formattedHistory[] = ['role' => 'assistant', 'content' => $aiResponseText];
            
            if (empty($aiData)) {
                $aiData = $this->extractDataFromText($aiResponseText);
            }
            if (!empty($aiData)) {
                $this->saveLead($aiData, $formattedHistory, $userId, $sessionId);
            }

            $aiResponse = $aiResponseText;

            $managerButton = null;
            $managerPhrases = ['связаться с менеджером', 'свяжитесь с менеджером', 'контакт менеджера', 'нажми кнопку ниже'];
            $foundPhrase = false;
            foreach ($managerPhrases as $phrase) {
                if (mb_stripos($aiResponse, $phrase) !== false) {
                    $foundPhrase = true;
                    break;
                }
            }
            $shouldContactManager = !empty($aiData['ready_for_manager']) 
                || strpos($aiResponse, '[CONTACT_MANAGER]') !== false
                || $foundPhrase;
            
            if ($shouldContactManager) {
                $aiResponse = str_replace('[CONTACT_MANAGER]', '', $aiResponse);
                $aiResponse = trim($aiResponse);

                $managerModel = new \App\Models\Manager();
                $manager = $managerModel->getRandomActive();
                
                if ($manager) {
                    $lead = $userId ? $this->getLeadByUser($userId) : $this->getLeadBySession($sessionId);
                    
                    $parts = [];
                    
                    $studentName = $lead['name'] ?? $user['full_name'] ?? 'Студент';
                    $parts[] = "Здравствуйте!";
                    $parts[] = "Меня зовут {$studentName}.";
                    $parts[] = "Я обратился(-лась) через сайт Kettik Study и хочу начать оформление.";
                    if (isset($userProfile) && $userProfile && !empty($userProfile['university_name'])) {
                        $parts[] = "Выбранный ВУЗ: {$userProfile['university_name']}.";
                    }
                    $parts[] = "";
                    $parts[] = "--- Мои данные ---";
                    
                    if (!empty($user['phone'])) $parts[] = "Телефон: {$user['phone']}";
                    if (!empty($user['email'])) $parts[] = "Email: {$user['email']}";
                    
                    if ($lead) {
                        if (!empty($lead['budget'])) {
                            $parts[] = "Бюджет: {$lead['budget']}";
                        }
                        if (!empty($lead['gpa']) && $lead['gpa'] > 0) {
                            $parts[] = "GPA (средний балл): {$lead['gpa']}";
                        }
                        if (!empty($lead['language_level'])) {
                            $parts[] = "Уровень языка: {$lead['language_level']}";
                        }
                        
                        $details = json_decode($lead['details'] ?? '{}', true);
                        if (!empty($details)) {
                            $detailLabels = [
                                'desired_university' => 'Желаемый ВУЗ',
                                'desired_degree' => 'Степень',
                                'program_of_interest' => 'Направление',
                                'field' => 'Специальность',
                                'country' => 'Страна обучения',
                                'ielts_score' => 'IELTS',
                                'toefl_score' => 'TOEFL',
                                'sat_score' => 'SAT',
                                'certificates' => 'Сертификаты',
                            ];
                            
                            foreach ($details as $key => $val) {
                                if (empty($val)) continue;
                                if (strtolower($key) === 'gpa') continue;
                                $label = $detailLabels[$key] ?? ucfirst(str_replace('_', ' ', $key));
                                if (is_array($val)) $val = implode(', ', $val);
                                $parts[] = "{$label}: {$val}";
                            }
                        }
                    }
                    
                    $parts[] = "";
                    $parts[] = "Буду рад(-а) узнать подробнее. Жду ответа!";
                    
                    $whatsappMessage = implode("\n", $parts);
                    $phone = preg_replace('/[^\d]/', '', $manager['phone']);
                    $whatsappUrl = "https://wa.me/{$phone}?text=" . rawurlencode($whatsappMessage);
                    
                    $managerButton = [
                        'manager_name' => $manager['name'],
                        'whatsapp_url' => $whatsappUrl,
                    ];
                }
            }

            $responseData = ['response' => $aiResponse];
            if ($managerButton) {
                $responseData['manager_button'] = $managerButton;
            }
            
            echo json_encode($responseData);

        } catch (\Throwable $e) {
            error_log('ChatController error: ' . $e->getMessage());
            http_response_code(500);
            echo json_encode(['error' => 'Internal server error']);
        }
    }

    private function extractDataFromText(string $text): array
    {
        $data = [];
        
        if (preg_match('/(?:Специальность|специальность)[:\s]+([^\n,()]+)/u', $text, $m)) {
            $data['specialty'] = trim($m[1]);
        }
        if (preg_match('/(?:Город|город)[:\s]+([^\n,()]+)/u', $text, $m)) {
            $data['city'] = trim($m[1]);
        }
        if (preg_match('/(?:Бюджет|бюджет)[:\s]*~?([^\n,()]+)/u', $text, $m)) {
            $data['budget'] = trim($m[1]);
        }
        if (preg_match('/(?:Тип|Обучение)[:\s]+(ВУЗ|Колледж|бакалавриат|магистратура)/ui', $text, $m)) {
            $data['program_of_interest'] = trim($m[1]);
        }
        
        return $data;
    }

    private function saveLead(array $data, array $history, ?int $userId, ?string $sessionId = null)
    {
        $db = Database::getInstance()->getConnection();
        
        $name = $data['name'] ?? null;
        $phone = $data['phone'] ?? null;
        $budget = $data['budget'] ?? null;
        $gpa = $data['gpa'] ?? 0;
        $lang = $data['language_level'] ?? null;
        
        $newDetails = $data['details'] ?? [];
        if ($sessionId && !$userId) {
            $newDetails['session_id'] = $sessionId;
        }
        if (!empty($data['program_of_interest'])) {
            $newDetails['program_of_interest'] = $data['program_of_interest'];
        }
        if (!empty($data['specialty'])) {
            $newDetails['specialty'] = $data['specialty'];
        }
        if (!empty($data['city'])) {
            $newDetails['city'] = $data['city'];
        }
        
        $score = $data['score'] ?? 0;
        $status = $data['status'] ?? 'new';
        $jsonHistory = json_encode($history, JSON_UNESCAPED_UNICODE);

        if ($userId) {
            $stmt = $db->prepare("SELECT id, details, status FROM study_leads WHERE user_id = ?");
            $stmt->execute([$userId]);
        } else {
            $stmt = $db->prepare("SELECT id, details, status FROM study_leads WHERE JSON_UNQUOTE(JSON_EXTRACT(details, '$.session_id')) = ? LIMIT 1");
            $stmt->execute([$sessionId]);
        }
        $existingLead = $stmt->fetch(\PDO::FETCH_ASSOC);

        if ($existingLead) {
            $currentDetails = !empty($existingLead['details']) ? json_decode($existingLead['details'], true) : [];
            if (!is_array($currentDetails)) $currentDetails = [];
            
            $mergedDetails = array_merge($currentDetails, $newDetails);
            $jsonDetails = json_encode($mergedDetails, JSON_UNESCAPED_UNICODE);

            $sql = "UPDATE study_leads SET 
                    name = COALESCE(?, name), 
                    phone = COALESCE(?, phone),
                    budget = COALESCE(?, budget),
                    gpa = IF(? > 0, ?, gpa),
                    language_level = COALESCE(?, language_level),
                    details = ?,
                    score = ?,
                    status = ?,
                    chat_history = ?,
                    updated_at = NOW()
                    WHERE id = ?";
            $stmt = $db->prepare($sql);
            $stmt->execute([
                $name, $phone, 
                $budget,
                $gpa, $gpa, 
                $lang, 
                $jsonDetails,
                $score, 
                $status, 
                $jsonHistory,
                $existingLead['id']
            ]);
            
            if ($status === 'qualified' && $existingLead['status'] !== 'qualified') {
                $field = $mergedDetails['field'] ?? 'не указано';
                $country = $mergedDetails['country'] ?? 'не указано';
                \App\Controllers\NotificationController::notifyAdmins(
                    '🔥 Новый горячий лид!',
                    ($name ?? 'Студент') . " | {$field} | {$country}\nБюджет: {$budget} | Score: {$score}%",
                    '/study/public/admin/student?id=' . $userId,
                    'lead'
                );
            }
        } else {
            $jsonDetails = json_encode($newDetails, JSON_UNESCAPED_UNICODE);
            
            $managerModel = new \App\Models\Manager();
            $manager = $managerModel->getRandomActive();
            $managerId = $manager ? $manager['id'] : null;

            $sql = "INSERT INTO study_leads (
                user_id, name, phone, budget, gpa, language_level, 
                details,
                score, status, chat_history, manager_id, created_at, updated_at
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())";
            
            $stmt = $db->prepare($sql);
            $stmt->execute([
                $userId, $name, $phone, $budget, $gpa, $lang, 
                $jsonDetails,
                $score, $status, $jsonHistory, $managerId
            ]);
            
            if ($managerId && $userId) {
                $userStmt = $db->prepare("UPDATE study_users SET manager_id = ? WHERE id = ? AND manager_id IS NULL");
                $userStmt->execute([$managerId, $userId]);
            }

            if ($status === 'qualified') {
                $field = $newDetails['field'] ?? 'не указано';
                $country = $newDetails['country'] ?? 'не указано';
                \App\Controllers\NotificationController::notifyAdmins(
                    '🔥 Новый горячий лид!',
                    ($name ?? 'Студент') . " | {$field} | {$country}\nБюджет: {$budget} | Score: {$score}%",
                    '/study/public/admin/student?id=' . $userId,
                    'lead'
                );
            }
        }
    }

    private function getLeadByUser(int $userId)
    {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT * FROM study_leads WHERE user_id = ?");
        $stmt->execute([$userId]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    private function getLeadBySession(string $sessionId)
    {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT * FROM study_leads WHERE JSON_UNQUOTE(JSON_EXTRACT(details, '$.session_id')) = ? LIMIT 1");
        $stmt->execute([$sessionId]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

}
