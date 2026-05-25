<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Панель Партнера (SMM) | Kettik Study</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background: #f8fafc; }
        .glass-card { background: white; border-radius: 16px; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03); border: 1px solid #f1f5f9; padding: 24px; }
        .status-badge { padding: 4px 10px; border-radius: 20px; font-size: 12px; font-weight: 600; text-transform: uppercase; }
        .status-new { background: #e0e7ff; color: #4338ca; }
        .status-hot { background: #fef08a; color: #a16207; }
        .status-cold { background: #e2e8f0; color: #475569; }
        .status-converted { background: #dcfce3; color: #16a34a; }
        .status-enrolled { background: #dcfce3; color: #16a34a; border: 1px solid #22c55e; }
    </style>
</head>
<body class="text-gray-800">

<div class="max-w-5xl mx-auto p-6 mt-8">
    <header class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Панель Партнера</h1>
            <p class="text-gray-500 mt-1">Отслеживайте свои приглашения и конверсии</p>
        </div>
        <a href="<?= BASE_URL ?>/logout" class="text-red-500 font-medium hover:underline">Выйти</a>
    </header>

    <div class="glass-card mb-8">
        <h2 class="text-lg font-semibold mb-2">Ваша реферальная ссылка</h2>
        <p class="text-sm text-gray-500 mb-4">Скопируйте эту ссылку и отправляйте потенциальным клиентам. Все, кто зарегистрируются по ней, будут закреплены за вами.</p>
        
        <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
            <input type="text" readonly id="ref-link" value="<?= (isset($_SERVER['HTTPS']) ? 'https://' : 'http://') . $_SERVER['HTTP_HOST'] . BASE_URL ?>/register?ref=<?= htmlspecialchars($affiliateCode) ?>" 
                   class="flex-1 w-full p-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-700 font-mono text-sm sm:text-base focus:outline-none text-center sm:text-left truncate">
            <button onclick="copyLink()" class="w-full sm:w-auto px-6 py-3 bg-[#0052FF] text-white font-semibold rounded-xl hover:bg-blue-700 transition flex-shrink-0 whitespace-nowrap">Скопировать</button>
        </div>
    </div>

    <div class="glass-card">
        <h2 class="text-lg font-semibold mb-6">Ваши лиды (<?= count($referrals) ?>)</h2>
        
        <?php if(empty($referrals)): ?>
            <div class="text-center py-10 text-gray-400">
                У вас пока нет приглашенных студентов.<br>Начните делиться ссылкой!
            </div>
        <?php else: ?>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="text-sm text-gray-500 border-b border-gray-100">
                            <th class="pb-3 font-medium">Имя студента</th>
                            <th class="pb-3 font-medium">Дата регистрации</th>
                            <th class="pb-3 font-medium">Статус лида</th>
                            <th class="pb-3 font-medium">Оплата (Enrolled)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($referrals as $ref): ?>
                            <?php 
                                $status = strtolower($ref['lead_status'] ?? 'new');
                                $statusClass = 'status-new';
                                if($status === 'hot') $statusClass = 'status-hot';
                                if($status === 'cold') $statusClass = 'status-cold';
                                if($status === 'converted') $statusClass = 'status-converted';
                            ?>
                            <tr class="border-b border-gray-50 last:border-0">
                                <td class="py-4 font-medium"><?= htmlspecialchars($ref['full_name']) ?></td>
                                <td class="py-4 text-sm text-gray-500"><?= date('d.m.Y H:i', strtotime($ref['created_at'])) ?></td>
                                <td class="py-4">
                                    <span class="status-badge <?= $statusClass ?>"><?= htmlspecialchars($ref['lead_status'] ?? 'NEW') ?></span>
                                </td>
                                <td class="py-4">
                                    <?php if($ref['enrolled_role'] === 'enrolled'): ?>
                                        <span class="status-badge status-enrolled">Оплачен договор</span>
                                    <?php else: ?>
                                        <span class="text-gray-400 text-sm">В процессе</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
function copyLink() {
    const input = document.getElementById('ref-link');
    input.select();
    input.setSelectionRange(0, 99999);
    navigator.clipboard.writeText(input.value).then(() => {
        alert("Ссылка скопирована!");
    });
}
</script>
</body>
</html>
