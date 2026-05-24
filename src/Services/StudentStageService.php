<?php

namespace App\Services;

use App\Core\Database;

class StudentStageService
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    public function calculate($studentId): array
    {
        $stmt = $this->db->prepare("SELECT enrolled_role FROM study_users WHERE id = ?");
        $stmt->execute([$studentId]);
        $user = $stmt->fetch(\PDO::FETCH_ASSOC);

        if ($user && $user['enrolled_role'] === 'enrolled') {
            return ['stage' => 'paid', 'label' => 'Зачислен', 'step' => 5];
        }

        $stmt = $this->db->prepare("SELECT status FROM study_leads WHERE user_id = ? ORDER BY created_at DESC LIMIT 1");
        $stmt->execute([$studentId]);
        $lead = $stmt->fetch(\PDO::FETCH_ASSOC);

        if ($lead && $lead['status'] === 'enrolled') {
            return ['stage' => 'enrolled', 'label' => 'Зачислен', 'step' => 5];
        }

        $stmt = $this->db->prepare("SELECT status FROM study_contracts WHERE user_id = ? ORDER BY created_at DESC LIMIT 1");
        $stmt->execute([$studentId]);
        $contract = $stmt->fetch(\PDO::FETCH_ASSOC);

        if ($contract) {
            if ($contract['status'] === 'paid') {
                return ['stage' => 'paid', 'label' => 'Оплачен', 'step' => 5];
            }
            if ($contract['status'] === 'signed') {
                return ['stage' => 'contract', 'label' => 'Договор', 'step' => 4];
            }
        }

        if ($lead && $lead['status'] === 'visa') {
            return ['stage' => 'visa', 'label' => 'Виза', 'step' => 4];
        }

        $stmt = $this->db->prepare("SELECT COUNT(*) as doc_count FROM study_documents WHERE user_id = ?");
        $stmt->execute([$studentId]);
        $docCount = $stmt->fetch(\PDO::FETCH_ASSOC)['doc_count'];

        if ($docCount > 0 || ($lead && $lead['status'] === 'documents')) {
            return ['stage' => 'documents', 'label' => 'Документы', 'step' => 3];
        }

        if ($lead && in_array($lead['status'], ['qualified', 'processing', 'hot', 'urgent'])) {
            return ['stage' => 'qualified', 'label' => 'В работе', 'step' => 2];
        }

        return ['stage' => 'lead', 'label' => 'Лид', 'step' => 1];
    }
}
