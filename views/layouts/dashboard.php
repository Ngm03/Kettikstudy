<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Личный кабинет - Kettik Study</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/dashboard.css?v=<?= time() ?>">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/chat.css">
    <meta name="csrf-token" content="<?= \App\Core\Csrf::token() ?>">
    <script>window.BASE_URL = '<?= BASE_URL ?>';</script>
    <script src="<?= BASE_URL ?>/assets/js/csrf.js"></script>
</head>
<body>

    <div class="dashboard-container">
    <button id="sidebar-toggle" style="position:fixed; top:1rem; left:1rem; z-index:101; display:none; background:white; border:1px solid #e5e7eb; padding:8px; border-radius:6px; cursor:pointer;">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" /></svg>
    </button>
    
    <div class="sidebar-overlay" id="sidebar-overlay"></div>

    <div class="dashboard-wrapper">
        <aside class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <a href="<?= BASE_URL ?>/" class="brand">
                    <div class="brand-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" /></svg>
                    </div>
                    Kettik Study
                </a>
            </div>

            <nav class="nav-scroll">
                <div class="nav-group">
                    <a href="<?= BASE_URL ?>/" class="nav-link">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" /></svg>
                        <?= __('home') ?>
                    </a>
                    <a href="<?= BASE_URL ?>/dashboard" class="nav-link <?php echo $page === 'home' ? 'active' : ''; ?>">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" /></svg>
                        <?= __('overview') ?>
                    </a>
                    <a href="<?= BASE_URL ?>/dashboard/documents" class="nav-link <?php echo $page === 'documents' ? 'active' : ''; ?>">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                        <?= __('documents') ?>
                    </a>
                    <a href="<?= BASE_URL ?>/dashboard/profile" class="nav-link <?php echo $page === 'profile' ? 'active' : ''; ?>">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                        <?= __('profile') ?>
                    </a>
                    <?php 
                        $isEnrolled = false;
                        $currentUserId = $_SESSION['user_id'] ?? null;
                        
                        if (!$currentUserId && isset($_COOKIE['auth_token'])) {
                            $authService = new \App\Services\AuthService();
                            $decoded = $authService->validateToken($_COOKIE['auth_token']);
                            if ($decoded && isset($decoded['sub'])) {
                                $currentUserId = $decoded['sub'];
                            }
                        }

                        if ($currentUserId) {
                            $db = \App\Core\Database::getInstance()->getConnection();
                            $stmt = $db->prepare("SELECT role, enrolled_role FROM study_users WHERE id = ?");
                            $stmt->execute([$currentUserId]);
                            $user = $stmt->fetch();
                            if ($user && ($user['enrolled_role'] === 'enrolled' || $user['role'] === 'admin')) {
                                $isEnrolled = true;
                            }
                            if ($user && $user['role'] === 'admin') {
                                $isAdmin = true;
                            }
                            if ($user && $user['role'] === 'manager') {
                                $isManager = true;
                            }
                        }
                    ?>
                    <?php if (isset($isAdmin) && $isAdmin): ?>
                        <div style="margin: 8px 16px; height: 1px; background: #e5e7eb;"></div>
                        <a href="<?= BASE_URL ?>/admin" class="nav-link" style="color: #ef4444; font-weight: 600;">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                            Панель Админа
                        </a>
                        <div style="margin: 8px 16px; height: 1px; background: #e5e7eb;"></div>
                    <?php endif; ?>
                    <?php if (isset($isManager) && $isManager): ?>
                        <div style="margin: 8px 16px; height: 1px; background: #e5e7eb;"></div>
                        <a href="<?= BASE_URL ?>/manager" class="nav-link" style="color: #3b82f6; font-weight: 600;">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                            Панель Менеджера
                        </a>
                        <div style="margin: 8px 16px; height: 1px; background: #e5e7eb;"></div>
                    <?php endif; ?>
                    <?php if ($isEnrolled): ?>
                        <!-- CHAT: приватный чат с менеджером (общий/городской чаты заморожены) -->
                        <a href="<?= BASE_URL ?>/dashboard/community" class="nav-link <?php echo $page === 'community' ? 'active' : ''; ?>">
                           <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" /></svg>
                           Чат с менеджером
                        </a>
                        <!-- prices/schedule/tasks заморожены до поступления -->
                    <?php endif; ?>
                </div>
            </nav>
            <div style="padding: 0 1rem; margin-bottom: 1rem;">
                <button onclick="switchLang('<?= \App\Helpers\I18n::getLocale() === 'ru' ? 'kk' : 'ru' ?>')" style="width: 100%; display:flex; align-items:center; justify-content:center; background:var(--bg-body); border:1px solid var(--border); border-radius:8px; padding:8px 12px; font-weight:600; cursor:pointer; font-size:13px; color:var(--text-main); transition:all 0.2s;" onmouseover="this.style.borderColor='var(--primary)'; this.style.color='var(--primary)';" onmouseout="this.style.borderColor='var(--border)'; this.style.color='var(--text-main)';">
                    <?= \App\Helpers\I18n::getLocale() === 'ru' ? 'Қазақша' : 'Русский' ?>
                </button>
            </div>

            <div class="user-profile">
                <div class="avatar-circle" id="sidebar-avatar">?</div>
                <div class="user-details">
                    <h4 id="sidebar-name"><?= __('loading') ?></h4>
                    <span onclick="logout()"><?= __('logout') ?></span>
                </div>
            </div>
        </aside>

        <main class="main-content">
            <div class="content-wrapper">
            <?php
                if(file_exists(__DIR__ . '/../dashboard/' . $page . '.php')) {
                    require __DIR__ . '/../dashboard/' . $page . '.php';
                } else {
                    echo '<div style="padding:20px;">Страница не найдена</div>';
                }
            ?>
            </div>
        </main>
    </div>

    <?php include __DIR__ . '/../chat/widget.php'; ?>
    <script src="<?= BASE_URL ?>/assets/js/chat.js"></script>

    <script>
        fetch('<?= BASE_URL ?>/api/auth/me')
            .then(res => {
                if (!res.ok) {
                    res.text().then(msg => {
                        console.error('Auth Check Failed (API):', res.status, msg);
                        document.getElementById('sidebar-name').textContent = 'Ошибка загрузки';
                    });
                    throw new Error('API Auth Failed');
                }
                return res.json();
            })
            .then(data => {
                if (data.user) {
                    const name = data.user.full_name;
                    document.getElementById('sidebar-name').textContent = name;
                    document.getElementById('sidebar-avatar').textContent = name.charAt(0).toUpperCase();
                }
            })
            .catch(err => {
                console.error('Auth Check Error:', err);
            });

        function logout() {
            fetch('<?= BASE_URL ?>/api/auth/logout', { method: 'POST' })
                .then(() => window.location.href = '<?= BASE_URL ?>/login');
        }

        function switchLang(lang) {
            fetch('<?= BASE_URL ?>/api/set-lang', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ lang: lang })
            }).then(() => window.location.reload());
        }

        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebar-overlay');
        const toggleBtn = document.getElementById('sidebar-toggle');

        function handleResize() {
            if (window.innerWidth < 768) {
                toggleBtn.style.display = 'block';
            } else {
                toggleBtn.style.display = 'none';
                sidebar.classList.remove('open');
                overlay.classList.remove('active');
            }
        }

        toggleBtn.onclick = () => {
            sidebar.classList.toggle('open');
            overlay.classList.add('active'); // Use add/remove for overlay to ensure sync
            if (!sidebar.classList.contains('open')) overlay.classList.remove('active');
        };

        overlay.onclick = () => {
            sidebar.classList.remove('open');
            overlay.classList.remove('active');
        };

        window.addEventListener('resize', handleResize);
        handleResize(); // Init check
    </script>
</body>
</html>
