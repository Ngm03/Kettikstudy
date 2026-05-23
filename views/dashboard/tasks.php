<?php
$currentUser = $user ?? [];
$userId = $currentUser['id'] ?? null;
$isAdmin = ($currentUser['role'] ?? '') === 'admin';
$cityId = $currentUser['city_id'] ?? null;

$tasks = [];
try {
    $db = \App\Core\Database::getInstance()->getConnection();
    try { $db->exec("CREATE TABLE IF NOT EXISTS study_tasks (
        id INT AUTO_INCREMENT PRIMARY KEY,
        city_id INT NULL,
        title VARCHAR(255) NOT NULL,
        description TEXT NULL,
        due_date DATE NULL,
        priority ENUM('low','medium','high') DEFAULT 'medium',
        created_by INT NULL,
        created_at DATETIME DEFAULT NOW()
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4"); } catch(Exception $e) {}

    try { $db->exec("CREATE TABLE IF NOT EXISTS study_task_completions (
        id INT AUTO_INCREMENT PRIMARY KEY,
        task_id INT NOT NULL,
        user_id INT NOT NULL,
        completed_at DATETIME DEFAULT NOW(),
        UNIQUE KEY task_user (task_id, user_id)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4"); } catch(Exception $e) {}

    $condCity = ($isAdmin || !$cityId) ? '' : 'AND (t.city_id = :cid OR t.city_id IS NULL)';
    $sql = "
        SELECT t.*, 
            (SELECT COUNT(*) FROM study_task_completions tc WHERE tc.task_id = t.id AND tc.user_id = :uid) as is_done
        FROM study_tasks t
        WHERE 1=1 $condCity
        ORDER BY FIELD(t.priority, 'high', 'medium', 'low'), t.due_date ASC
    ";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':uid', $userId, PDO::PARAM_INT);
    if (!$isAdmin && $cityId) $stmt->bindValue(':cid', $cityId, PDO::PARAM_INT);
    $stmt->execute();
    $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch(Exception $e) {}
?>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<style>
:root { --blue:#0052FF; --text:#1e293b; --muted:#64748b; --border:#e2e8f0; --bg:#f8fafc; }
body { background: var(--bg); font-family: 'Inter', sans-serif; color: var(--text); }

.tasks-header { display:flex; align-items:center; justify-content:space-between; margin-bottom:24px; }
.tasks-header h1 { font-size:1.7rem; font-weight:800; margin:0; }

.tasks-grid { display:flex; flex-direction:column; gap:10px; }

.task-card {
    background: white;
    border-radius: 14px;
    border: 1px solid var(--border);
    padding: 16px 20px;
    display: flex;
    align-items: flex-start;
    gap: 14px;
    transition: box-shadow 0.2s;
    cursor: default;
}
.task-card:hover { box-shadow: 0 4px 16px rgba(0,0,0,0.06); }
.task-card.done { opacity: 0.55; }

.task-check {
    width: 22px; height: 22px;
    border-radius: 50%;
    border: 2px solid var(--border);
    flex-shrink: 0;
    cursor: pointer;
    display: flex; align-items: center; justify-content: center;
    transition: all 0.2s;
    background: white;
    margin-top: 2px;
}
.task-check.checked {
    background: #22c55e;
    border-color: #22c55e;
    color: white;
}

.task-body { flex: 1; }
.task-title {
    font-size: 15px; font-weight: 600; color: var(--text);
    margin-bottom: 4px;
}
.task-desc { font-size: 13px; color: var(--muted); margin-bottom: 8px; line-height: 1.5; }
.task-meta { display: flex; gap: 10px; align-items: center; flex-wrap: wrap; }

.task-badge {
    font-size: 11px; font-weight: 700;
    padding: 3px 8px; border-radius: 6px;
}
.badge-high { background: #fef2f2; color: #dc2626; }
.badge-medium { background: #fff7ed; color: #ea580c; }
.badge-low { background: #f0fdf4; color: #16a34a; }

.task-due { font-size: 12px; color: var(--muted); }
.task-due.overdue { color: #dc2626; font-weight: 600; }

.empty-tasks {
    text-align: center; padding: 60px 20px;
    color: var(--muted); font-size: 15px;
    background: white; border-radius: 16px; border: 1px dashed var(--border);
}
.empty-tasks .icon { font-size: 3rem; margin-bottom: 12px; }

.add-task-btn {
    display: inline-flex; align-items: center; gap: 8px;
    padding: 10px 20px;
    background: var(--blue); color: white;
    border: none; border-radius: 10px;
    font-size: 14px; font-weight: 600;
    cursor: pointer;
    box-shadow: 0 4px 12px rgba(0,82,255,0.2);
    transition: all 0.2s;
}
.add-task-btn:hover { background: #003fcc; transform: translateY(-1px); }
</style>

<div class="tasks-header">
    <div>
        <h1>✅ Задания</h1>
        <p style="color:var(--muted); margin:4px 0 0; font-size:0.95rem;">Текущие задания и контрольные точки</p>
    </div>
    <?php if ($isAdmin): ?>
    <button class="add-task-btn" onclick="document.getElementById('addTaskModal').style.display='flex'">
        + Добавить задание
    </button>
    <?php endif; ?>
</div>

<div class="tasks-grid">
<?php if (empty($tasks)): ?>
<div class="empty-tasks">
    <div class="icon">📋</div>
    <div>Заданий пока нет</div>
    <?php if ($isAdmin): ?><div style="margin-top:8px; font-size:13px;">Нажмите «Добавить задание», чтобы создать первое задание.</div><?php endif; ?>
</div>
<?php else: ?>
<?php foreach ($tasks as $task): ?>
<?php
$now = new DateTime();
$due = $task['due_date'] ? new DateTime($task['due_date']) : null;
$overdue = $due && !$task['is_done'] && $due < $now;
$priorityLabels = ['high' => 'Высокий', 'medium' => 'Средний', 'low' => 'Низкий'];
?>
<div class="task-card <?= $task['is_done'] ? 'done' : '' ?>" id="task-<?= $task['id'] ?>">
    <div class="task-check <?= $task['is_done'] ? 'checked' : '' ?>" onclick="toggleTask(<?= $task['id'] ?>, this)">
        <?php if ($task['is_done']): ?>
        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" fill="currentColor" viewBox="0 0 16 16"><path d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0z"/></svg>
        <?php endif; ?>
    </div>
    <div class="task-body">
        <div class="task-title"><?= htmlspecialchars($task['title']) ?></div>
        <?php if (!empty($task['description'])): ?>
        <div class="task-desc"><?= nl2br(htmlspecialchars($task['description'])) ?></div>
        <?php endif; ?>
        <div class="task-meta">
            <span class="task-badge badge-<?= $task['priority'] ?>"><?= $priorityLabels[$task['priority']] ?> приоритет</span>
            <?php if ($due): ?>
            <span class="task-due <?= $overdue ? 'overdue' : '' ?>">
                📅 до <?= $due->format('j M Y') ?><?= $overdue ? ' — Просрочено!' : '' ?>
            </span>
            <?php endif; ?>
        </div>
    </div>
    <?php if ($isAdmin): ?>
    <button onclick="deleteTask(<?= $task['id'] ?>)" title="Удалить" style="background:none; border:none; cursor:pointer; color:#cbd5e1; padding:4px; border-radius:6px; transition:color 0.2s;" onmouseover="this.style.color='#ef4444'" onmouseout="this.style.color='#cbd5e1'">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16"><path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/><path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/></svg>
    </button>
    <?php endif; ?>
</div>
<?php endforeach; ?>
<?php endif; ?>
</div>

<?php if ($isAdmin): ?>
<div id="addTaskModal" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.4); backdrop-filter:blur(4px); z-index:999; align-items:center; justify-content:center; padding:20px;">
    <div style="background:white; border-radius:20px; padding:32px; width:100%; max-width:480px; box-shadow:0 20px 40px rgba(0,0,0,0.15);">
        <h3 style="margin:0 0 20px; font-size:1.3rem;">Добавить задание</h3>
        <form id="addTaskForm" onsubmit="saveTask(event)" style="display:flex; flex-direction:column; gap:14px;">
            <input name="title" placeholder="Название задания" required style="border:1px solid #e2e8f0; border-radius:10px; padding:10px 14px; font-size:14px;">
            <textarea name="description" placeholder="Описание (необязательно)" rows="3" style="border:1px solid #e2e8f0; border-radius:10px; padding:10px 14px; font-size:14px; resize:none;"></textarea>
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px;">
                <div>
                    <label style="font-size:12px; font-weight:600; color:#64748b; display:block; margin-bottom:4px;">Приоритет</label>
                    <select name="priority" style="border:1px solid #e2e8f0; border-radius:10px; padding:10px 14px; font-size:14px; width:100%;">
                        <option value="high">Высокий</option>
                        <option value="medium" selected>Средний</option>
                        <option value="low">Низкий</option>
                    </select>
                </div>
                <div>
                    <label style="font-size:12px; font-weight:600; color:#64748b; display:block; margin-bottom:4px;">Срок</label>
                    <input type="date" name="due_date" style="border:1px solid #e2e8f0; border-radius:10px; padding:10px 14px; font-size:14px; width:100%;">
                </div>
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
            <div style="display:flex; justify-content:flex-end; gap:10px; margin-top:8px;">
                <button type="button" onclick="document.getElementById('addTaskModal').style.display='none'" style="background:transparent; border:1px solid #e2e8f0; padding:10px 20px; border-radius:10px; cursor:pointer; font-weight:600; color:#64748b;">Отмена</button>
                <button type="submit" style="background:#0052FF; color:white; border:none; padding:10px 20px; border-radius:10px; cursor:pointer; font-weight:600;">Сохранить</button>
            </div>
        </form>
    </div>
</div>
<script>
async function saveTask(e) {
    e.preventDefault();
    const data = Object.fromEntries(new FormData(e.target).entries());
    const resp = await fetch('<?= BASE_URL ?>/api/tasks', { method: 'POST', headers: {'Content-Type': 'application/json'}, body: JSON.stringify(data) });
    const json = await resp.json();
    if (json.success) { document.getElementById('addTaskModal').style.display='none'; window.location.reload(); }
    else alert(json.error || 'Ошибка');
}
async function deleteTask(id) {
    if (!confirm('Удалить задание?')) return;
    const resp = await fetch('<?= BASE_URL ?>/api/tasks', { method: 'POST', headers: {'Content-Type':'application/json'}, body: JSON.stringify({action:'delete', id}) });
    const json = await resp.json();
    if (json.success) document.getElementById(`task-${id}`)?.remove();
}
</script>
<?php endif; ?>

<script>
async function toggleTask(taskId, btn) {
    const isDone = btn.classList.contains('checked');
    const action = isDone ? 'uncomplete' : 'complete';
    const resp = await fetch('<?= BASE_URL ?>/api/tasks', {
        method: 'POST',
        headers: {'Content-Type':'application/json'},
        body: JSON.stringify({ action, id: taskId })
    });
    const json = await resp.json();
    if (json.success) {
        btn.classList.toggle('checked');
        btn.innerHTML = !isDone ? '<svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" fill="currentColor" viewBox="0 0 16 16"><path d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0z"/></svg>' : '';
        btn.closest('.task-card').classList.toggle('done', !isDone);
    }
}
</script>
