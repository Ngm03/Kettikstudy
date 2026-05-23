<?php

namespace App\Services;

use TCPDF;

class PdfService
{
    public function generateStudentApplication(array $student, array $documents, ?array $programData = null)
    {
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        $pdf->SetCreator('Kettik Study');
        $pdf->SetAuthor('Kettik Study System');
        $pdf->SetTitle('Application Form - ' . $student['full_name']);

        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);

        $pdf->AddPage();

        $pdf->SetFont('dejavusans', 'B', 20);
        $pdf->Cell(0, 15, 'Kettik Study', 0, 1, 'C');
        
        $pdf->SetFont('dejavusans', '', 12);
        $pdf->Cell(0, 10, 'Анкета абитуриента', 0, 1, 'C');
        $pdf->Ln(5);

        $pdf->SetFont('dejavusans', 'B', 14);
        $pdf->Cell(0, 10, 'Личные данные', 0, 1);
        $pdf->SetFont('dejavusans', '', 12);
        
        $html = '
        <table border="1" cellpadding="5">
            <tr>
                <td width="30%"><strong>ФИО:</strong></td>
                <td width="70%">' . $student['full_name'] . '</td>
            </tr>
            <tr>
                <td><strong>Email:</strong></td>
                <td>' . $student['email'] . '</td>
            </tr>
            <tr>
                <td><strong>Телефон:</strong></td>
                <td>' . ($student['phone'] ?? 'Не указан') . '</td>
            </tr>
            <tr>
                <td><strong>Дата регистрации:</strong></td>
                <td>' . $student['created_at'] . '</td>
            </tr>
        </table>';

        $pdf->writeHTML($html, true, false, true, false, '');

        if ($programData && (!empty($programData['desired_country']) || !empty($programData['university_name']))) {
            $pdf->Ln(5);
            $pdf->SetFont('dejavusans', 'B', 14);
            $pdf->Cell(0, 10, 'Выбранная программа', 0, 1);
            $pdf->SetFont('dejavusans', '', 12);

            $progHtml = '<table border="1" cellpadding="5">';
            if (!empty($programData['desired_country'])) {
                $progHtml .= '<tr><td width="30%"><strong>Страна:</strong></td><td width="70%">' . $programData['desired_country'] . '</td></tr>';
            }
            if (!empty($programData['university_name'])) {
                $progHtml .= '<tr><td><strong>ВУЗ:</strong></td><td>' . $programData['university_name'] . '</td></tr>';
            }
            if (!empty($programData['desired_program'])) {
                $progHtml .= '<tr><td><strong>Направление:</strong></td><td>' . $programData['desired_program'] . '</td></tr>';
            }
            $progHtml .= '</table>';
            $pdf->writeHTML($progHtml, true, false, true, false, '');
        }

        $pdf->Ln(10);

        $pdf->SetFont('dejavusans', 'B', 14);
        $pdf->Cell(0, 10, 'Прикрепленные документы', 0, 1);
        $pdf->SetFont('dejavusans', '', 12);

        $docHtml = '<table border="1" cellpadding="5">
            <tr style="background-color:#f0f0f0;">
                <th><strong>Тип</strong></th>
                <th><strong>Название файла</strong></th>
                <th><strong>Статус</strong></th>
            </tr>';

        foreach ($documents as $doc) {
            $statusColor = $doc['status'] == 'approved' ? 'green' : ($doc['status'] == 'rejected' ? 'red' : 'orange');
            $statusLabel = match($doc['status']) {
                'approved' => 'Принят',
                'rejected' => 'Отклонен',
                default => 'На проверке'
            };
            
            $typeName = match($doc['type']) {
                'passport' => 'Паспорт',
                'transcript' => 'Аттестат / Диплом',
                'certificate' => 'Сертификат',
                default => 'Другое'
            };

            $docHtml .= '<tr>
                <td>' . $typeName . '</td>
                <td>' . $doc['original_name'] . '</td>
                <td style="color:' . $statusColor . ';">' . $statusLabel . '</td>
            </tr>';
        }

        $docHtml .= '</table>';
        $pdf->writeHTML($docHtml, true, false, true, false, '');

        $pdf->Ln(20);
        $pdf->SetFont('dejavusans', 'I', 10);
        $pdf->Cell(0, 10, 'Сгенерировано автоматически системой Kettik Study', 0, 1, 'R');
        $pdf->Cell(0, 10, date('Y-m-d H:i:s'), 0, 1, 'R');

        $pdf->Output('application_' . $student['id'] . '.pdf', 'D');
    }
}
