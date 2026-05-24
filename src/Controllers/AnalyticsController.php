<?php

namespace App\Controllers;

use App\Core\Database;
use App\Services\AuthService;

class AnalyticsController
{
    private $db;
    private $authService;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
        $this->authService = new AuthService();
    }

    private function checkAdmin()
    {
        if (!$this->authService->check()) {
            http_response_code(401);
            echo json_encode(['error' => 'Unauthorized']);
            exit;
        }
        $user = $this->authService->user();
        $roleStr = strtolower($user['role'] ?? '');
        if (!str_contains($roleStr, 'admin')) {
            http_response_code(403);
            echo json_encode(['error' => 'Forbidden']);
            exit;
        }
    }

    public function trackVisit()
    {
        $sessionId = $_COOKIE['study_session'] ?? null;
        if (!$sessionId) {
            $sessionId = bin2hex(random_bytes(32));
            setcookie('study_session', $sessionId, time() + (86400 * 30), '/');
        }

        $ip = $_SERVER['REMOTE_ADDR'];
        $ua = $_SERVER['HTTP_USER_AGENT'] ?? '';
        
        $deviceType = 'desktop';
        if (preg_match('/(android|webos|iphone|ipad|ipod|blackberry|windows phone)/i', $ua)) {
            $deviceType = 'mobile';
        } elseif (preg_match('/(tablet|ipad|playbook)|(android(?!.*mobile))/i', $ua)) {
            $deviceType = 'tablet';
        }

        $utmSource = $_GET['utm_source'] ?? null;
        $utmMedium = $_GET['utm_medium'] ?? null;
        $utmCampaign = $_GET['utm_campaign'] ?? null;
        $referrer = $_SERVER['HTTP_REFERER'] ?? null;

        if ($referrer && strpos($referrer, $_SERVER['HTTP_HOST']) !== false) {
            $referrer = null;
        }

        $stmt = $this->db->prepare("SELECT id, page_views FROM study_visitors WHERE session_id = ?");
        $stmt->execute([$sessionId]);
        $visitor = $stmt->fetch();

        if ($visitor) {
            $sql = "UPDATE study_visitors SET page_views = page_views + 1, last_visit = NOW()";
            $params = [];
            
            if ($utmSource) {
                $sql .= ", utm_source = ?, utm_medium = ?, utm_campaign = ?";
                $params[] = $utmSource;
                $params[] = $utmMedium;
                $params[] = $utmCampaign;
            }
            if ($referrer) {
                $sql .= ", referrer = ?";
                $params[] = $referrer;
            }
            
            $sql .= " WHERE id = ?";
            $params[] = $visitor['id'];
            
            $update = $this->db->prepare($sql);
            $update->execute($params);
        } else {
            $insert = $this->db->prepare("
                INSERT INTO study_visitors 
                (session_id, ip_address, user_agent, device_type, utm_source, utm_medium, utm_campaign, referrer) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)
            ");
            $insert->execute([$sessionId, $ip, $ua, $deviceType, $utmSource, $utmMedium, $utmCampaign, $referrer]);
        }
    }

    public function getDashboardStats()
    {
        $this->checkAdmin();
        header('Content-Type: application/json');

        try {
            // 1. Общее количество студентов (роль student)
            $stmt = $this->db->query("SELECT COUNT(*) as count FROM study_users WHERE role = 'student'");
            $totalStudents = $stmt->fetch()['count'];

            // 2. Новые лиды за последние 30 дней (текущие 30 дней vs предыдущие 30 дней)
            $stmt = $this->db->query("SELECT COUNT(*) as count FROM study_leads WHERE created_at >= NOW() - INTERVAL 30 DAY");
            $leadsActive = $stmt->fetch()['count'];

            $stmt = $this->db->query("SELECT COUNT(*) as count FROM study_leads WHERE created_at >= NOW() - INTERVAL 60 DAY AND created_at < NOW() - INTERVAL 30 DAY");
            $leadsActiveYesterday = $stmt->fetch()['count'];

            // 3. Количество "горячих" лидов (score >= 70)
            $stmt = $this->db->query("SELECT COUNT(*) as count FROM study_leads WHERE score >= 70");
            $hotLeads = $stmt->fetch()['count'];

            $stmt = $this->db->query("SELECT COUNT(*) as count FROM study_leads WHERE score >= 70 AND created_at < NOW() - INTERVAL 30 DAY");
            $hotLeadsYesterday = $stmt->fetch()['count'];

            // 4. Поступившие студенты (enrolled)
            $stmt = $this->db->query("SELECT COUNT(*) as count FROM study_users WHERE role = 'student' AND enrolled_role = 'enrolled'");
            $enrolledCount = $stmt->fetch()['count'];

            // 5. Общее количество лидов для расчета конверсии
            $stmt = $this->db->query("SELECT COUNT(*) as count FROM study_leads");
            $totalLeads = $stmt->fetch()['count'];

            $conversionRate = $totalLeads > 0 ? round(($enrolledCount / $totalLeads) * 100, 1) : 0;

            // 6. Распределение по статусам воронки (Pipeline Funnel)
            $stmt = $this->db->query("
                SELECT status, COUNT(*) as count 
                FROM study_leads 
                GROUP BY status 
                ORDER BY count DESC
            ");
            $pipelineFunnel = $stmt->fetchAll(\PDO::FETCH_ASSOC);

            // 7. Нагрузка менеджеров (Manager Workload)
            $stmt = $this->db->query("
                SELECT u.full_name as manager_name, COUNT(s.id) as count 
                FROM study_users s 
                JOIN study_users u ON s.manager_id = u.id 
                WHERE s.role = 'student' 
                GROUP BY s.manager_id 
                ORDER BY count DESC
                LIMIT 6
            ");
            $managerWorkload = $stmt->fetchAll(\PDO::FETCH_ASSOC);

            // 8. Топ направлений / стран обучения (из study_user_details или study_leads)
            $stmt = $this->db->query("
                SELECT COALESCE(desired_country, 'Не указано') as direction, COUNT(*) as count 
                FROM study_user_details 
                WHERE desired_country IS NOT NULL AND desired_country != ''
                GROUP BY desired_country 
                ORDER BY count DESC 
                LIMIT 5
            ");
            $topDirections = $stmt->fetchAll(\PDO::FETCH_ASSOC);

            if (empty($topDirections)) {
                // Фолбек на study_leads, если детали пусты
                $stmt = $this->db->query("
                    SELECT 'Польша' as direction, COUNT(*) as count 
                    FROM study_leads 
                    LIMIT 1
                ");
                $topDirections = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            }

            // 9. Последние 10 регистраций студентов
            $stmt = $this->db->query("
                SELECT u.id, u.full_name, u.email, u.phone, u.created_at, 
                       COALESCE(l.status, 'new') as lead_status, 
                       COALESCE(l.score, 0) as lead_score,
                       (SELECT full_name FROM study_users WHERE id = u.manager_id) as manager_name
                FROM study_users u
                LEFT JOIN study_leads l ON l.user_id = u.id
                WHERE u.role = 'student'
                ORDER BY u.created_at DESC
                LIMIT 10
            ");
            $recentRegistrations = $stmt->fetchAll(\PDO::FETCH_ASSOC);

            echo json_encode([
                'success' => true,
                'today' => [
                    'visitors' => $totalStudents, // перемапим под виджет: всего студентов
                    'leads' => $leadsActive,      // активные лиды за 30 дней
                    'qualified' => $hotLeads,    // горячие лиды всего
                    'conversion' => $conversionRate // конверсия поступивших
                ],
                'yesterday' => [
                    'visitors' => $totalStudents,
                    'leads' => $leadsActiveYesterday,
                    'qualified' => $hotLeadsYesterday
                ],
                'pipeline_funnel' => $pipelineFunnel,
                'manager_workload' => $managerWorkload,
                'top_directions' => $topDirections,
                'recent_registrations' => $recentRegistrations
            ]);

        } catch (\Exception $e) {
            error_log('Analytics error: ' . $e->getMessage() . "\n" . $e->getTraceAsString());
            http_response_code(500);
            echo json_encode(['success' => false, 'error' => 'Internal server error']);
        }
    }
}
