<?php
$weekOffset = (int)($_GET['week'] ?? 0);
$weekStart = new DateTime();
$weekStart->modify('this week monday');
if ($weekOffset !== 0) {
    $weekStart->modify("$weekOffset week");
}
$weekEnd = clone $weekStart;
$weekEnd->modify('+6 days');
$currentUser = $user ?? [];
$cityId = $currentUser['city_id'] ?? null;
$isAdmin = ($currentUser['role'] ?? '') === 'admin';

$scheduleItems = [];
try {
    $db = \App\Core\Database::getInstance()->getConnection();
    try { $db->exec("CREATE TABLE IF NOT EXISTS study_schedule (
        id INT AUTO_INCREMENT PRIMARY KEY,
        city_id INT NULL,
        title VARCHAR(200) NOT NULL,
        subject VARCHAR(100) NULL,
        location VARCHAR(150) NULL,
        starts_at DATETIME NOT NULL,
        ends_at DATETIME NOT NULL,
        color VARCHAR(20) DEFAULT 'blue',
        created_by INT NULL,
        created_at DATETIME DEFAULT NOW()
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4"); } catch(Exception $e) {}

    $condCity = ($isAdmin || !$cityId) ? '' : 'AND (city_id = :cid OR city_id IS NULL)';
    $dayStart = $weekStart->format('Y-m-d 00:00:00');
    $dayEnd = $weekEnd->format('Y-m-d 23:59:59');
    $sql = "SELECT * FROM study_schedule WHERE starts_at >= :ds AND starts_at <= :de $condCity ORDER BY starts_at ASC";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':ds', $dayStart);
    $stmt->bindValue(':de', $dayEnd);
    if (!$isAdmin && $cityId) $stmt->bindValue(':cid', $cityId);
    $stmt->execute();
    $scheduleItems = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch(Exception $e) {}

$byDay = [];
foreach ($scheduleItems as $item) {
    $day = (new DateTime($item['starts_at']))->format('Y-m-d');
    $byDay[$day][] = $item;
}

$days = [];
$d = clone $weekStart;
for ($i = 0; $i < 7; $i++) {
    $days[] = clone $d;
    $d->modify('+1 day');
}
$dayNames = ['Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб', 'Вс'];
$monthNames = ['', 'января', 'февраля', 'марта', 'апреля', 'мая', 'июня', 'июля', 'августа', 'сентября', 'октября', 'ноября', 'декабря'];
?>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<style>
:root {
    --blue: #0052FF;
    --text: #1e293b;
    --muted: #64748b;
    --border: #e2e8f0;
    --bg: #f8fafc;
}
body { background: var(--bg); font-family: 'Inter', sans-serif; color: var(--text); }

.schedule-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 24px;
}
.schedule-header h1 { font-size: 1.7rem; font-weight: 800; margin: 0; }
.week-nav { display: flex; align-items: center; gap: 12px; }
.week-nav a, .week-nav span {
    padding: 8px 14px;
    border: 1px solid var(--border);
    border-radius: 8px;
    font-size: 13px;
    font-weight: 600;
    color: var(--muted);
    text-decoration: none;
    background: white;
    transition: all 0.2s;
}
.week-nav a:hover { background: var(--blue); color: white; border-color: var(--blue); }
.week-range { color: var(--text); font-weight: 600; border: none; }

.schedule-grid {
    display: grid;
    grid-template-columns: repeat(7, 1fr);
    gap: 12px;
}

.day-col {
    background: white;
    border-radius: 16px;
    border: 1px solid var(--border);
    overflow: hidden;
    min-height: 240px;
}

.day-header {
    padding: 12px;
    text-align: center;
    background: #f1f5f9;
    border-bottom: 1px solid var(--border);
}
.day-header .day-name {
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    color: var(--muted);
    letter-spacing: 0.5px;
}
.day-header .day-num {
    font-size: 1.4rem;
    font-weight: 800;
    color: var(--text);
    line-height: 1.2;
}
.day-header.today {
    background: var(--blue);
}
.day-header.today .day-name, .day-header.today .day-num { color: white; }

.day-events { padding: 8px; display: flex; flex-direction: column; gap: 6px; }

.event-card {
    border-radius: 10px;
    padding: 8px 10px;
    font-size: 12px;
    cursor: pointer;
    transition: transform 0.15s;
    border-left: 3px solid transparent;
}
.event-card:hover { transform: scale(1.02); }
.event-card.blue { background: #eff6ff; border-color: #2563eb; }
.event-card.green { background: #f0fdf4; border-color: #16a34a; }
.event-card.orange { background: #fff7ed; border-color: #ea580c; }
.event-card.purple { background: #f5f3ff; border-color: #7c3aed; }
.event-card.red { background: #fef2f2; border-color: #dc2626; }

.event-title { font-weight: 700; color: var(--text); margin-bottom: 2px; }
.event-time { color: var(--muted); font-size: 11px; }
.event-location { color: var(--muted); font-size: 11px; margin-top:2px; }

.no-events { padding: 20px; text-align: center; color: #cbd5e1; font-size: 12px; }

<?php if ($isAdmin): ?>
.add-event-btn {
    display: inline-flex; align-items: center; gap: 8px;
    padding: 10px 20px;
    background: var(--blue); color: white;
    border: none; border-radius: 10px;
    font-size: 14px; font-weight: 600;
    cursor: pointer; text-decoration: none;
    box-shadow: 0 4px 12px rgba(0,82,255,0.2);
    transition: all 0.2s;
}
.add-event-btn:hover { background: #003fcc; transform: translateY(-1px); }
<?php endif; ?>

@media (max-width: 900px) {
    .schedule-grid { grid-template-columns: repeat(3, 1fr); }
}
@media (max-width: 600px) {
    .schedule-grid { grid-template-columns: repeat(2, 1fr); }
    .schedule-header { flex-direction: column; align-items: flex-start; gap: 12px; }
}
</style>

<div class="schedule-header">
    <div>
        <h1>📅 Расписание</h1>
        <p style="color:var(--muted); margin:4px 0 0; font-size:0.95rem;">Расписание занятий и событий</p>
    </div>
    <div style="display:flex; align-items:center; gap:12px; flex-wrap:wrap;">
        <?php if ($isAdmin): ?>
        <button onclick="document.getElementById('addEventModal').style.display='flex'" class="add-event-btn">
            + Добавить событие
        </button>
        <?php endif; ?>
        <div class="week-nav">
            <a href="?page=schedule&week=<?= $weekOffset - 1 ?>">← Пред.</a>
            <span class="week-range">
                <?= $weekStart->format('j') ?> – <?= $weekEnd->format('j') ?>
                <?= $monthNames[(int)$weekEnd->format('n')] ?>
                <?= $weekEnd->format('Y') ?>
            </span>
            <a href="?page=schedule&week=<?= $weekOffset + 1 ?>">След. →</a>
        </div>
    </div>
</div>

<div class="schedule-grid">
<?php $today = (new DateTime())->format('Y-m-d'); ?>
<?php foreach ($days as $i => $day): ?>
    <?php
    $dayKey = $day->format('Y-m-d');
    $isToday = $dayKey === $today;
    $events = $byDay[$dayKey] ?? [];
    ?>
    <div class="day-col">
        <div class="day-header <?= $isToday ? 'today' : '' ?>">
            <div class="day-name"><?= $dayNames[$i] ?></div>
            <div class="day-num"><?= $day->format('j') ?></div>
        </div>
        <div class="day-events">
            <?php if (empty($events)): ?>
            <div class="no-events">—</div>
            <?php else: ?>
            <?php foreach ($events as $event): ?>
            <div class="event-card <?= htmlspecialchars($event['color']) ?>">
                <div class="event-title"><?= htmlspecialchars($event['title']) ?></div>
                <div class="event-time">
                    <?= date('H:i', strtotime($event['starts_at'])) ?> – <?= date('H:i', strtotime($event['ends_at'])) ?>
                </div>
                <?php if (!empty($event['location'])): ?>
                <div class="event-location">📍 <?= htmlspecialchars($event['location']) ?></div>
                <?php endif; ?>
            </div>
            <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
<?php endforeach; ?>
</div>

<?php if ($isAdmin): ?>
<div id="addEventModal" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.4); backdrop-filter:blur(4px); z-index:999; align-items:center; justify-content:center; padding:20px;">
    <div style="background:white; border-radius:20px; padding:32px; width:100%; max-width:480px; box-shadow:0 20px 40px rgba(0,0,0,0.15);">
        <h3 style="margin:0 0 20px; font-size:1.3rem;">Добавить событие</h3>
        <form id="addEventForm" onsubmit="saveEvent(event)" style="display:flex; flex-direction:column; gap:14px;">
            <input name="title" placeholder="Название занятия / события" required style="border:1px solid #e2e8f0; border-radius:10px; padding:10px 14px; font-size:14px;">
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px;">
                <div>
                    <label style="font-size:12px; font-weight:600; color:#64748b; display:block; margin-bottom:4px;">Начало</label>
                    <input type="datetime-local" name="starts_at" required style="border:1px solid #e2e8f0; border-radius:10px; padding:10px 14px; font-size:14px; width:100%;">
                </div>
                <div>
                    <label style="font-size:12px; font-weight:600; color:#64748b; display:block; margin-bottom:4px;">Конец</label>
                    <input type="datetime-local" name="ends_at" required style="border:1px solid #e2e8f0; border-radius:10px; padding:10px 14px; font-size:14px; width:100%;">
                </div>
            </div>
            <input name="location" placeholder="Место (адрес / ссылка, необязательно)" style="border:1px solid #e2e8f0; border-radius:10px; padding:10px 14px; font-size:14px;">
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px;">
                <div>
                    <label style="font-size:12px; font-weight:600; color:#64748b; display:block; margin-bottom:4px;">Цвет</label>
                    <select name="color" style="border:1px solid #e2e8f0; border-radius:10px; padding:10px 14px; font-size:14px; width:100%;">
                        <option value="blue">Синий</option>
                        <option value="green">Зелёный</option>
                        <option value="orange">Оранжевый</option>
                        <option value="purple">Фиолетовый</option>
                        <option value="red">Красный</option>
                    </select>
                </div>
                <div>
                    <label style="font-size:12px; font-weight:600; color:#64748b; display:block; margin-bottom:4px;">Город</label>
                    <select name="city_id" style="border:1px solid #e2e8f0; border-radius:10px; padding:10px 14px; font-size:14px; width:100%;">
                        <option value="">Все города</option>
                        <?php
                        try {
                            $cities = $db->query("SELECT id, name_ru FROM study_cities ORDER BY name_ru")->fetchAll(PDO::FETCH_ASSOC);
                            foreach ($cities as $city) {
                                echo "<option value=\"{$city['id']}\">" . htmlspecialchars($city['name_ru']) . "</option>";
                            }
                        } catch(Exception $e) {}
                        ?>
                    </select>
                </div>
            </div>
            <div style="display:flex; justify-content:flex-end; gap:10px; margin-top:8px;">
                <button type="button" onclick="document.getElementById('addEventModal').style.display='none'" style="background:transparent; border:1px solid #e2e8f0; padding:10px 20px; border-radius:10px; cursor:pointer; font-weight:600; color:#64748b;">Отмена</button>
                <button type="submit" style="background:#0052FF; color:white; border:none; padding:10px 20px; border-radius:10px; cursor:pointer; font-weight:600; box-shadow:0 4px 12px rgba(0,82,255,0.2);">Сохранить</button>
            </div>
        </form>
        <div id="saveEventError" style="display:none; color:#ef4444; margin-top:8px; font-size:13px;"></div>
    </div>
</div>
<script>
async function saveEvent(e) {
    e.preventDefault();
    const form = e.target;
    const data = Object.fromEntries(new FormData(form).entries());
    const resp = await fetch('<?= BASE_URL ?>/api/schedule', {
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify(data)
    });
    const json = await resp.json();
    if (json.success) {
        document.getElementById('addEventModal').style.display = 'none';
        form.reset();
        window.location.reload();
    } else {
        document.getElementById('saveEventError').textContent = json.error || 'Ошибка сохранения';
        document.getElementById('saveEventError').style.display = 'block';
    }
}
</script>
<?php endif; ?>
