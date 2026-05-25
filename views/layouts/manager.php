<?php
$lang = $_COOKIE['lang'] ?? 'ru';
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle ?? 'Manager Panel') ?> | Kettik Study</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <meta name="csrf-token" content="<?= \App\Core\Csrf::token() ?>">
    <script>window.BASE_URL = '<?= BASE_URL ?>';</script>
    <script src="<?= BASE_URL ?>/assets/js/csrf.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        :root {
            --man-sidebar-bg: #0f172a;
            --man-sidebar-text: #94a3b8;
            --man-sidebar-hover: #1e293b;
            --man-sidebar-active: #3b82f6;
            --man-topbar-bg: #ffffff;
            --man-bg: #f8fafc;
            --man-border: #e2e8f0;
            --man-text: #1e293b;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--man-bg);
            color: var(--man-text);
            display: flex;
            height: 100vh;
            overflow: hidden;
            -webkit-font-smoothing: antialiased;
        }

        .man-sidebar {
            width: 260px;
            background: var(--man-sidebar-bg);
            color: var(--man-sidebar-text);
            display: flex;
            flex-direction: column;
            border-right: 1px solid rgba(255,255,255,0.05);
            transition: transform 0.3s ease;
            z-index: 50;
        }

        .man-brand {
            height: 70px;
            display: flex;
            align-items: center;
            padding: 0 24px;
            font-size: 1.2rem;
            font-weight: 800;
            color: #fff;
            letter-spacing: 0.5px;
            border-bottom: 1px solid rgba(255,255,255,0.05);
        }
        .man-brand span { color: var(--man-sidebar-active); margin-left: 6px; }

        .man-nav {
            flex: 1;
            padding: 24px 16px;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .man-nav-item {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 12px 18px;
            color: var(--man-sidebar-text);
            text-decoration: none;
            border-radius: 10px;
            font-size: 0.9rem;
            font-weight: 500;
            transition: all 0.2s;
        }
        .man-nav-item:hover {
            background: var(--man-sidebar-hover);
            color: #fff;
        }
        .man-nav-item.active {
            background: rgba(59, 130, 246, 0.15);
            color: var(--man-sidebar-active);
            font-weight: 600;
        }
        .man-nav-item svg { width: 20px; height: 20px; }

        .man-main {
            flex: 1;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        .man-topbar {
            height: 70px;
            background: var(--man-topbar-bg);
            border-bottom: 1px solid var(--man-border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 32px;
            z-index: 40;
        }

        .man-topbar-left { display: flex; align-items: center; gap: 16px; }
        .man-page-title { font-size: 1.15rem; font-weight: 700; color: var(--man-text); }

        .man-topbar-right { display: flex; align-items: center; gap: 20px; }
        
        .man-user-menu {
            display: flex;
            align-items: center;
            gap: 12px;
            cursor: pointer;
            padding: 6px 12px;
            border-radius: 8px;
            transition: background 0.2s;
        }
        .man-user-menu:hover { background: #f1f5f9; }
        .man-avatar {
            width: 38px; height: 38px;
            border-radius: 50%;
            background: linear-gradient(135deg, #3b82f6, #2563eb);
            color: #fff;
            display: flex; align-items: center; justify-content: center;
            font-weight: 700; font-size: 1rem;
        }
        .man-user-info { display: flex; flex-direction: column; }
        .man-user-name { font-weight: 600; font-size: 0.9rem; color: #1e293b; }
        .man-user-role { font-size: 0.75rem; color: #64748b; }

        .man-logout-btn {
            color: #ef4444; border: none; background: transparent; cursor: pointer;
            display: flex; align-items: center; justify-content: center;
            width: 36px; height: 36px; border-radius: 8px; transition: 0.2s;
        }
        .man-logout-btn:hover { background: #fee2e2; }

        .man-content {
            flex: 1;
            padding: 32px;
            overflow-y: auto;
        }

        .man-mobile-toggle { display: none; background: transparent; border: none; cursor: pointer; color: var(--man-text); }
        
        @media (max-width: 900px) {
            .man-sidebar {
                position: fixed;
                top: 0; left: 0; bottom: 0;
                transform: translateX(-100%);
            }
            .man-sidebar.open { transform: translateX(0); }
            .man-mobile-toggle { display: block; }
            .man-topbar { padding: 0 20px; }
            .man-content { padding: 20px; }
            .man-user-info { display: none; }
        }

        #man-loader {
            position: fixed; top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(255,255,255,0.8);
            backdrop-filter: blur(4px);
            z-index: 9999;
            display: flex; align-items: center; justify-content: center;
            opacity: 0; pointer-events: none; transition: 0.2s;
        }
        #man-loader.active { opacity: 1; pointer-events: all; }
        .spinner {
            width: 40px; height: 40px; border: 4px solid #e2e8f0;
            border-top-color: #3b82f6; border-radius: 50%;
            animation: spin 1s linear infinite;
        }
        @keyframes spin { to { transform: rotate(360deg); } }

    </style>
</head>
<body>

    <div id="man-loader"><div class="spinner"></div></div>

    <aside class="man-sidebar" id="sidebar">
        <div class="man-brand">
            Kettik <span>Manager</span>
        </div>
        <nav class="man-nav">
            <a href="<?= BASE_URL ?>/manager" class="man-nav-item <?= $page === 'manager_dashboard' ? 'active' : '' ?>">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                <?= __('man_nav_dash') ?>
            </a>
            <a href="<?= BASE_URL ?>/manager/leads" class="man-nav-item <?= $page === 'manager_leads' ? 'active' : '' ?>">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                <?= __('man_nav_leads') ?>
            </a>
            <a href="<?= BASE_URL ?>/manager/students" class="man-nav-item <?= $page === 'manager_students' ? 'active' : '' ?>">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                <?= __('man_nav_students') ?>
            </a>

            <div style="margin: 12px 16px; height: 1px; background: rgba(255,255,255,0.1);"></div>

            <div style="padding: 0 16px; margin-top: auto; margin-bottom: 24px;">
                <button onclick="switchLang('<?= \App\Helpers\I18n::getLocale() === 'ru' ? 'kk' : 'ru' ?>')" style="width: 100%; display:flex; align-items:center; justify-content:center; background:rgba(255,255,255,0.05); border:1px solid rgba(255,255,255,0.1); border-radius:8px; padding:10px; font-weight:500; cursor:pointer; font-size:13px; color:var(--man-sidebar-text); transition:all 0.2s;" onmouseover="this.style.background='var(--man-sidebar-hover)'; this.style.color='#fff';" onmouseout="this.style.background='rgba(255,255,255,0.05)'; this.style.color='var(--man-sidebar-text)';">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="16" height="16" style="margin-right: 8px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"/></svg>
                    <?= \App\Helpers\I18n::getLocale() === 'ru' ? 'Қазақша' : 'Русский' ?>
                </button>
            </div>
        </nav>
    </aside>

    <main class="man-main">
        <header class="man-topbar">
            <div class="man-topbar-left">
                <button class="man-mobile-toggle" onclick="document.getElementById('sidebar').classList.toggle('open')">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" width="24" height="24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>
                <h1 class="man-page-title"><?= htmlspecialchars($pageTitle ?? '') ?></h1>
            </div>
            
            <div class="man-topbar-right">
                <div class="man-user-menu" title="Перейти на главную сайта" onclick="window.location.href='<?= BASE_URL ?>/'">
                    <div class="man-avatar" id="manAvatar">М</div>
                    <div class="man-user-info">
                        <span class="man-user-name" id="manName"><?= __('man_top_manager') ?></span>
                        <span class="man-user-role"><?= __('man_role') ?></span>
                    </div>
                </div>
                
                <button class="man-logout-btn" onclick="logout()" title="<?= __('logout') ?>">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                </button>
            </div>
        </header>

        <div class="man-content">
            <?php 
                $viewPath = __DIR__ . "/../manager/{$page}.php";
                if (file_exists($viewPath)) {
                    require $viewPath;
                } else {
                    echo "<div style='color: #ef4444; font-weight: 600;'>View 'manager/{$page}.php' not found.</div>";
                }
            ?>
        </div>
    </main>

    <script>
        window.BASE_URL = "<?= BASE_URL ?>";

        function showLoader() { document.getElementById('man-loader').classList.add('active'); }
        function hideLoader() { document.getElementById('man-loader').classList.remove('active'); }

        function switchLang(lang) {
            document.cookie = "lang=" + lang + "; path=/; max-age=" + (60*60*24*30);
            window.location.reload();
        }

        fetch(`${window.BASE_URL}/api/auth/me`)
            .then(res => res.json())
            .then(data => {
                if(data.user) {
                    const name = data.user.full_name || '<?= __('man_top_manager') ?>';
                    document.getElementById('manName').textContent = name;
                    document.getElementById('manAvatar').textContent = name.charAt(0).toUpperCase();
                }
            });

        function logout() {
            showLoader();
            fetch(`${window.BASE_URL}/api/auth/logout`, { method: 'POST' })
                .then(() => window.location.href = `${window.BASE_URL}/login`)
                .catch(() => hideLoader());
        }

        document.addEventListener('click', (e) => {
            const sidebar = document.getElementById('sidebar');
            const toggle = document.querySelector('.man-mobile-toggle');
            if (window.innerWidth <= 900 && sidebar.classList.contains('open') && !sidebar.contains(e.target) && !toggle.contains(e.target)) {
                sidebar.classList.remove('open');
            }
        });
    </script>
</body>
</html>
