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
        if ($user['role'] !== 'admin') {
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
            $stmt = $this->db->query("SELECT COUNT(*) as count FROM study_visitors WHERE DATE(last_visit) = CURDATE()");
            $visitorsToday = $stmt->fetch()['count'];

            $stmt = $this->db->query("SELECT COUNT(*) as count FROM study_visitors WHERE DATE(last_visit) = CURDATE() - INTERVAL 1 DAY");
            $visitorsYesterday = $stmt->fetch()['count'];

            $stmt = $this->db->query("SELECT COUNT(*) as count FROM study_leads WHERE DATE(created_at) = CURDATE()");
            $leadsToday = $stmt->fetch()['count'];

            $stmt = $this->db->query("SELECT COUNT(*) as count FROM study_leads WHERE DATE(created_at) = CURDATE() - INTERVAL 1 DAY");
            $leadsYesterday = $stmt->fetch()['count'];

            $stmt = $this->db->query("SELECT COUNT(*) as count FROM study_leads WHERE DATE(created_at) = CURDATE() AND score >= 70");
            $qualifiedToday = $stmt->fetch()['count'];

            $stmt = $this->db->query("SELECT COUNT(*) as count FROM study_leads WHERE DATE(created_at) = CURDATE() - INTERVAL 1 DAY AND score >= 70");
            $qualifiedYesterday = $stmt->fetch()['count'];

            $stmt = $this->db->query("
                SELECT COALESCE(utm_source, 'Direct') as source, COUNT(*) as count 
                FROM study_visitors 
                WHERE last_visit >= NOW() - INTERVAL 30 DAY 
                GROUP BY source 
                ORDER BY count DESC 
                LIMIT 8
            ");
            $trafficSources = $stmt->fetchAll(\PDO::FETCH_ASSOC);

            $stmt = $this->db->query("
                SELECT selected_country as direction, COUNT(*) as count 
                FROM study_leads 
                WHERE selected_country IS NOT NULL 
                GROUP BY selected_country 
                ORDER BY count DESC 
                LIMIT 5
            ");
            $topDirections = $stmt->fetchAll(\PDO::FETCH_ASSOC);

            $stmt = $this->db->query("
                SELECT ip_address, utm_source, device_type, created_at, page_views 
                FROM study_visitors 
                ORDER BY last_visit DESC 
                LIMIT 20
            ");
            $recentVisits = $stmt->fetchAll(\PDO::FETCH_ASSOC);


            echo json_encode([
                'success' => true,
                'today' => [
                    'visitors' => $visitorsToday,
                    'leads' => $leadsToday,
                    'qualified' => $qualifiedToday,
                    'conversion' => $visitorsToday > 0 ? round(($leadsToday / $visitorsToday) * 100, 1) : 0
                ],
                'yesterday' => [
                    'visitors' => $visitorsYesterday,
                    'leads' => $leadsYesterday,
                    'qualified' => $qualifiedYesterday
                ],
                'traffic_sources' => $trafficSources,
                'top_directions' => $topDirections,
                'recent_visits' => $recentVisits
            ]);

        } catch (\Exception $e) {
            error_log('Analytics error: ' . $e->getMessage());
            echo json_encode(['success' => false, 'error' => 'Internal server error']);
        }
    }
}
