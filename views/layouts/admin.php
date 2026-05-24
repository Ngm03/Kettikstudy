<?php
if (session_status() === PHP_SESSION_NONE && !headers_sent()) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel — Kettik Study</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <meta name="csrf-token" content="<?= \App\Core\Csrf::token() ?>">
    <script>window.BASE_URL = '<?= BASE_URL ?>';</script>
    <script src="<?= BASE_URL ?>/assets/js/csrf.js?v=<?= time() ?>"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --sidebar-w: 260px;
            --sidebar-bg: #0f172a;
            --sidebar-hover: rgba(255,255,255,0.07);
            --sidebar-active: rgba(239,68,68,0.15);
            --sidebar-active-text: #f87171;
            --accent: #ef4444;
            --accent-glow: rgba(239,68,68,0.25);
            --border: #e2e8f0;
            --bg: #f8fafc;
            --surface: #ffffff;
            --text: #1e293b;
            --text-muted: #64748b;
            --transition: 0.28s cubic-bezier(0.4,0,0.2,1);
        }

        html, body { height: 100%; width: 100%; overflow-x: hidden; font-family: 'Inter', sans-serif; background: var(--bg); color: var(--text); }

        .admin-shell {
            display: flex;
            height: 100vh;
            width: 100%;
            max-width: 100vw;
            overflow: hidden;
        }

        .sidebar {
            width: var(--sidebar-w);
            background: var(--sidebar-bg);
            display: flex;
            flex-direction: column;
            flex-shrink: 0;
            height: 100vh;
            overflow: hidden;
            position: relative;
            z-index: 50;
            transition: transform var(--transition);
        }

        .sidebar::before {
            content: '';
            position: absolute;
            top: -60px; left: 50%;
            transform: translateX(-50%);
            width: 200px; height: 200px;
            background: radial-gradient(circle, rgba(239,68,68,0.18) 0%, transparent 70%);
            pointer-events: none;
        }

        .sidebar-logo {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 22px 20px 20px;
            border-bottom: 1px solid rgba(255,255,255,0.07);
            position: relative;
        }
        .sidebar-logo img {
            height: 36px;
            width: auto;
            border-radius: 8px;
            filter: brightness(1.1);
        }
        .sidebar-logo-text {
            display: flex;
            flex-direction: column;
            line-height: 1.2;
        }
        .sidebar-logo-text strong {
            font-size: 0.95rem;
            font-weight: 700;
            color: #fff;
        }
        .sidebar-logo-text span {
            font-size: 0.7rem;
            color: rgba(255,255,255,0.35);
            letter-spacing: 0.5px;
        }
        .sidebar-close-btn {
            display: none;
            margin-left: auto;
            background: none;
            border: none;
            color: rgba(255,255,255,0.4);
            cursor: pointer;
            padding: 4px;
            border-radius: 6px;
            transition: color 0.2s, background 0.2s;
        }
        .sidebar-close-btn:hover { color: #fff; background: rgba(255,255,255,0.1); }

        .sidebar-nav {
            flex: 1;
            overflow-y: auto;
            padding: 16px 12px;
            scrollbar-width: thin;
            scrollbar-color: rgba(255,255,255,0.1) transparent;
        }
        .sidebar-nav::-webkit-scrollbar { width: 4px; }
        .sidebar-nav::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.1); border-radius: 4px; }

        .nav-section-label {
            font-size: 0.67rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: rgba(255,255,255,0.25);
            padding: 0 8px 8px;
            margin-top: 16px;
        }
        .nav-section-label:first-child { margin-top: 0; }

        .nav-divider { height: 1px; background: rgba(255,255,255,0.06); margin: 10px 0; }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 12px;
            color: rgba(255,255,255,0.55);
            text-decoration: none;
            border-radius: 10px;
            transition: all 0.2s;
            font-weight: 500;
            font-size: 0.875rem;
            margin-bottom: 2px;
            position: relative;
        }
        .nav-item svg { width: 18px; height: 18px; flex-shrink: 0; }
        .nav-item:hover {
            background: var(--sidebar-hover);
            color: rgba(255,255,255,0.9);
        }
        .nav-item.active {
            background: var(--sidebar-active);
            color: var(--sidebar-active-text);
            font-weight: 600;
        }
        .nav-item.active::before {
            content: '';
            position: absolute;
            left: 0; top: 50%;
            transform: translateY(-50%);
            width: 3px; height: 20px;
            background: var(--accent);
            border-radius: 0 3px 3px 0;
        }
        .nav-item.nav-external { color: rgba(96,165,250,0.7); }
        .nav-item.nav-external:hover { color: #93c5fd; background: rgba(96,165,250,0.1); }

        .sidebar-footer {
            padding: 14px 12px;
            border-top: 1px solid rgba(255,255,255,0.07);
        }
        .sidebar-push-btn {
            width: 100%;
            display: flex;
            align-items: center;
            gap: 8px;
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 10px;
            padding: 10px 12px;
            color: rgba(255,255,255,0.6);
            font-size: 0.8rem;
            font-weight: 500;
            font-family: 'Inter', sans-serif;
            cursor: pointer;
            transition: all 0.2s;
            margin-bottom: 10px;
        }
        .sidebar-push-btn:hover { background: rgba(255,255,255,0.09); color: rgba(255,255,255,0.9); border-color: rgba(255,255,255,0.2); }
        .sidebar-push-btn svg { width: 15px; height: 15px; flex-shrink: 0; }
        .sidebar-user-card {
            display: flex;
            align-items: center;
            gap: 10px;
            background: rgba(255,255,255,0.04);
            border: 1px solid rgba(255,255,255,0.07);
            border-radius: 10px;
            padding: 10px 12px;
        }
        .user-avatar {
            width: 32px; height: 32px;
            background: linear-gradient(135deg, #ef4444, #dc2626);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-weight: 700; font-size: 0.875rem; color: #fff;
            flex-shrink: 0;
        }
        .user-name { font-size: 0.85rem; font-weight: 600; color: #ffffff; }
        .user-logout {
            font-size: 0.75rem;
            color: rgba(255,255,255,0.7);
            cursor: pointer;
            transition: color 0.15s;
            background: none; border: none; font-family: inherit; padding: 0;
        }
        .user-logout:hover { color: #f87171; }

        .sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.6);
            backdrop-filter: blur(3px);
            z-index: 40;
        }
        .sidebar-overlay.visible { display: block; }

        .main-area {
            flex: 1;
            display: flex;
            flex-direction: column;
            min-width: 0;
            min-height: 0;
            overflow: hidden;
        }

        .topbar {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 0 24px;
            height: 64px;
            background: var(--surface);
            border-bottom: 1px solid var(--border);
            flex-shrink: 0;
            box-shadow: 0 1px 3px rgba(0,0,0,0.04);
        }
        .topbar-hamburger {
            display: none;
            background: none;
            border: none;
            cursor: pointer;
            color: var(--text-muted);
            padding: 6px;
            border-radius: 8px;
            transition: background 0.2s, color 0.2s;
            flex-shrink: 0;
        }
        .topbar-hamburger:hover { background: #f1f5f9; color: var(--text); }
        .topbar-hamburger svg { width: 22px; height: 22px; display: block; }

        .topbar-title {
            flex: 1;
            min-width: 0;
        }
        .topbar-title h1 {
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--text);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .topbar-title p {
            font-size: 0.75rem;
            color: var(--text-muted);
            margin-top: 1px;
        }

        .topbar-actions {
            display: flex;
            align-items: center;
            gap: 8px;
            flex-shrink: 0;
        }

        .notif-btn {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px; height: 40px;
            background: #f8fafc;
            border: 1px solid var(--border);
            border-radius: 10px;
            cursor: pointer;
            color: var(--text-muted);
            transition: all 0.2s;
        }
        .notif-btn:hover { background: #f1f5f9; border-color: #cbd5e1; color: var(--text); }
        .notif-btn svg { width: 18px; height: 18px; }
        .notif-badge {
            position: absolute;
            top: 6px; right: 6px;
            width: 8px; height: 8px;
            background: var(--accent);
            border-radius: 50%;
            border: 1.5px solid #fff;
            display: none;
        }
        .notif-badge.visible { display: block; }

        .notif-wrapper { position: relative; }
        .notif-dropdown {
            display: none;
            position: absolute;
            top: calc(100% + 10px);
            right: 0;
            width: 360px;
            max-height: 420px;
            background: var(--surface);
            border-radius: 14px;
            box-shadow: 0 12px 40px rgba(0,0,0,0.15);
            overflow: hidden;
            border: 1px solid var(--border);
            z-index: 200;
        }
        .notif-dropdown.open { display: flex; flex-direction: column; }
        .notif-dropdown-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 14px 18px;
            border-bottom: 1px solid var(--border);
            background: #f8fafc;
            flex-shrink: 0;
        }
        .notif-dropdown-header h3 { font-size: 0.9rem; font-weight: 700; color: var(--text); }
        .notif-dropdown-header button {
            background: none; border: none; color: var(--accent); font-size: 0.8rem;
            font-weight: 600; cursor: pointer; font-family: inherit;
        }
        #notificationList { overflow-y: auto; flex: 1; }

        .page-content {
            flex: 1;
            min-height: 0;
            height: calc(100vh - 64px);
            overflow-y: auto;
            overflow-x: hidden;
            padding: 24px;
        }

        @media (max-width: 768px) {
            .sidebar {
                position: fixed;
                top: 0; left: 0; bottom: 0;
                transform: translateX(-100%);
                box-shadow: 4px 0 30px rgba(0,0,0,0.3);
            }
            .sidebar.open { transform: translateX(0); }
            .sidebar-close-btn { display: flex; align-items: center; justify-content: center; }
            .topbar-hamburger { display: flex; }
            .topbar { padding: 0 16px; }
            .page-content { padding: 16px; height: calc(100vh - 64px); }
            .notif-dropdown { width: calc(100vw - 32px); right: -16px; }
        }

        @media (min-width: 769px) {
            .main-area { margin-left: 0; }
        }
    </style>
</head>
<body>

<div class="admin-shell">

    <div id="sidebarOverlay" class="sidebar-overlay" onclick="toggleSidebar()"></div>

    <aside class="sidebar" id="sidebar">
        <div class="sidebar-logo">
            <img src="<?= BASE_URL ?>/assets/img/logo.png" alt="Kettik Study">
            <div class="sidebar-logo-text">
                <strong>Kettik Admin</strong>
                <span>Management Panel</span>
            </div>
            <button class="sidebar-close-btn" onclick="toggleSidebar()" aria-label="Закрыть">
                <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        <nav class="sidebar-nav">
            <div class="nav-section-label">Основное</div>

            <a href="<?= BASE_URL ?>/admin/dashboard" class="nav-item <?php echo $page === 'home' ? 'active' : ''; ?>">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                <?= __('students') ?>
            </a>

            <a href="<?= BASE_URL ?>/admin/analytics" class="nav-item <?php echo $page === 'analytics' ? 'active' : ''; ?>">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                <?= __('analytics') ?>
            </a>

            <div class="nav-divider"></div>
            <div class="nav-section-label">Данные</div>



            <a href="<?= BASE_URL ?>/admin/prices" class="nav-item <?php echo $page === 'prices' ? 'active' : ''; ?>">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <?= __('prices_comparison') ?>
            </a>

            <a href="<?= BASE_URL ?>/admin/documents" class="nav-item <?php echo $page === 'documents' ? 'active' : ''; ?>">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                <?= __('documents') ?>
            </a>


            <a href="<?= BASE_URL ?>/admin/universities" class="nav-item <?php echo $page === 'universities' ? 'active' : ''; ?>">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                <?= __('universities') ?>
            </a>

            <div class="nav-divider"></div>
            <div class="nav-section-label">Команда</div>

            <a href="<?= BASE_URL ?>/admin/managers" class="nav-item <?php echo $page === 'managers' ? 'active' : ''; ?>">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                <?= __('managers') ?>
            </a>



            <div class="nav-divider"></div>
            <div class="nav-section-label">Система</div>

            <a href="<?= BASE_URL ?>/admin/settings" class="nav-item <?php echo $page === 'settings' ? 'active' : ''; ?>">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                <?= __('settings') ?>
            </a>

            <a href="<?= BASE_URL ?>/admin/logs" class="nav-item <?php echo $page === 'logs' ? 'active' : ''; ?>">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <?= __('logs') ?>
            </a>

            <a href="<?= BASE_URL ?>/dashboard" target="_blank" class="nav-item nav-external" style="margin-top:6px;">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                <?= __('dashboard') ?>
            </a>
        </nav>

        <div class="sidebar-footer">
            <div class="sidebar-user-card">
                <div class="user-avatar">A</div>
                <div style="flex:1; min-width:0;">
                    <div class="user-name">Администратор</div>
                    <button class="user-logout" onclick="logout()"><?= __('logout') ?></button>
                </div>
            </div>
        </div>
    </aside>

    <div class="main-area">

        <header class="topbar">
            <button class="topbar-hamburger" onclick="toggleSidebar()" aria-label="Меню">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
            </button>

            <div class="topbar-title">
                <h1><?php
                    $titles = [
                        'home'          => __('students'),
                        'analytics'     => __('analytics'),
                        'prices'        => __('prices_comparison'),
                        'documents'     => __('documents'),
                        'universities'  => __('universities'),
                        'managers'      => __('managers'),
                        'settings'      => __('settings'),
                        'logs'          => __('logs'),
                    ];
                    echo $titles[$page] ?? 'Админ панель';
                ?></h1>
            </div>

            <div class="topbar-actions">
                <button onclick="switchLang('<?= \App\Helpers\I18n::getLocale() === 'ru' ? 'kk' : 'ru' ?>')" style="background:none; border:none; border-radius:8px; padding:6px 12px; font-weight:700; cursor:pointer; font-size:13px; color:#1e293b; margin-right: 8px; transition:background 0.2s; box-shadow: 0 1px 2px rgba(0,0,0,0.05); border: 1px solid #e2e8f0; background: #fff;" hover="this.style.background='#f8fafc'">
                    <?= \App\Helpers\I18n::getLocale() === 'ru' ? 'ҚЗ' : 'RU' ?>
                </button>

                <div class="notif-wrapper">
                    <button class="notif-btn" onclick="toggleNotificationDropdown()" aria-label="Уведомления">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                        <span class="notif-badge" id="notifBadgeDot"></span>
                    </button>
                    <div class="notif-dropdown" id="notificationDropdown">
                        <div class="notif-dropdown-header">
                            <h3>Уведомления</h3>
                            <div style="display:flex;gap:12px;align-items:center;">
                                <button id="soundToggle" onclick="toggleSound()" style="background:none;border:none;cursor:pointer;font-size:1.1rem;opacity:0.6;" title="Звук">🔔</button>
                                <button onclick="markAllAsRead()">Прочитать все</button>
                            </div>
                        </div>
                        <div id="notificationList" style="max-height:320px;overflow-y:auto;">
                            <div style="padding:40px 20px;text-align:center;color:#94a3b8;font-size:0.875rem;">Нет уведомлений</div>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <main class="page-content">
            <?php
                if(file_exists(__DIR__ . '/../admin/' . $page . '.php')) {
                    require __DIR__ . '/../admin/' . $page . '.php';
                } else {
                    echo '<div style="padding:20px;color:#64748b;">Страница не найдена</div>';
                }
            ?>
        </main>
    </div>
</div>

<script>
    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');
        sidebar.classList.toggle('open');
        overlay.classList.toggle('visible');
        document.body.style.overflow = sidebar.classList.contains('open') ? 'hidden' : '';
    }

    function switchLang(lang) {
        fetch('<?= BASE_URL ?>/api/set-lang', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ lang: lang })
        }).then(() => window.location.reload());
    }

    function toggleNotificationDropdown() {
        document.getElementById('notificationDropdown').classList.toggle('open');
    }
    document.addEventListener('click', function(e) {
        const wrapper = document.querySelector('.notif-wrapper');
        if (wrapper && !wrapper.contains(e.target)) {
            document.getElementById('notificationDropdown').classList.remove('open');
        }
    });

    function logout() {
        fetch('<?= BASE_URL ?>/api/auth/logout', { method: 'POST' })
            .then(() => window.location.href = '<?= BASE_URL ?>/login');
    }

</script>

<?php if ($page === 'analytics'): ?>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="<?= BASE_URL ?>/assets/js/analytics.js?v=<?= time() ?>"></script>
<?php endif; ?>

<script src="<?= BASE_URL ?>/assets/js/notifications.js?v=<?= time() ?>"></script>
<?php include __DIR__ . '/admin_mobile_js.php'; ?>
</body>
</html>
