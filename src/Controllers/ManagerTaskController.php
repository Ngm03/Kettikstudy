<?php

namespace App\Controllers;

use App\Core\Database;
use App\Services\AuthService;

class ManagerTaskController
{
    private $db;
    private $authService;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
        $this->authService = new AuthService();
    }

    private function getManagerId(): ?int
    {
        $token = $_COOKIE['auth_token'] ?? null;
        if (!$token) return null;
        
        $decoded = $this->authService->validateToken($token);
        if (!$decoded || !isset($decoded['sub'])) return null;
        
        $role = strtolower($decoded['role'] ?? '');
        if (!str_contains($role, 'manager') && !str_contains($role, 'admin')) {
            return null;
        }
        
        return (int) $decoded['sub'];
    }

    public function getDailyTasks()
    {
        header('Content-Type: application/json');
        
        $managerId = $this->getManagerId();
        if (!$managerId) {
            http_response_code(403);
            echo json_encode(['error' => 'Access Denied: Manager only']);
            return;
        }

        try {
            // Fetch all leads assigned to this manager
            $sql = "
                SELECT 
                    l.id as lead_id, l.status, l.score, l.updated_at, l.created_at, l.details,
                    u.id as student_id, u.full_name, u.email, u.phone,
                    TIMESTAMPDIFF(HOUR, l.updated_at, NOW()) as hours_since_update
                FROM study_leads l
                JOIN study_users u ON l.user_id = u.id
                WHERE l.manager_id = ? AND u.role = 'student'
            ";
            
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$managerId]);
            $leads = $stmt->fetchAll(\PDO::FETCH_ASSOC);

            $tasks = [
                'priority_1' => [], // Red (Money / Contract)
                'priority_2' => [], // Yellow (Follow-ups)
                'priority_3' => []  // Blue (New / General)
            ];

            foreach ($leads as $lead) {
                // Priority 1: Ready to pay or waiting for contract
                if (in_array($lead['status'], ['ready_to_pay', 'contract'])) {
                    $taskTitle = $lead['status'] === 'ready_to_pay' ? 'Студент готов к оплате' : 'Скинуть реквизиты / Ждет счет';
                    $tasks['priority_1'][] = array_merge($lead, ['task_title' => $taskTitle, 'action_required' => 'Отправить счет и проконтролировать оплату.']);
                    continue;
                }
                
                // Priority 1 fallback: is_urgent flag set manually
                $details = json_decode($lead['details'], true) ?: [];
                if (!empty($details['is_urgent']) && !in_array($lead['status'], ['converted', 'rejected'])) {
                    $tasks['priority_1'][] = array_merge($lead, ['task_title' => 'Срочная задача (Ручная отметка)', 'action_required' => 'Требуется срочное вмешательство.']);
                    continue;
                }

                // Priority 2: Follow-ups (Contacted and no update for > 24 hours)
                if ($lead['status'] === 'contacted' && $lead['hours_since_update'] >= 24) {
                    $tasks['priority_2'][] = array_merge($lead, ['task_title' => 'Follow-up звонок', 'action_required' => 'Думает более 24 часов. Узнать решение.']);
                    continue;
                }

                // Priority 3: New leads that haven't been processed yet
                if ($lead['status'] === 'new') {
                    $tasks['priority_3'][] = array_merge($lead, ['task_title' => 'Новая заявка', 'action_required' => 'Связаться как можно скорее.']);
                    continue;
                }
            }

            // Sort each group by latest activity or score
            $sortByUpdate = function($a, $b) {
                return strtotime($b['updated_at']) - strtotime($a['updated_at']);
            };
            
            usort($tasks['priority_1'], $sortByUpdate);
            usort($tasks['priority_2'], $sortByUpdate);
            usort($tasks['priority_3'], $sortByUpdate);

            echo json_encode([
                'success' => true, 
                'tasks' => $tasks,
                'counts' => [
                    'p1' => count($tasks['priority_1']),
                    'p2' => count($tasks['priority_2']),
                    'p3' => count($tasks['priority_3'])
                ]
            ]);
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(['success' => false, 'error' => 'Database error']);
        }
    }
}
