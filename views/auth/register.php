<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Регистрация - Kettik Study</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/style.css"> 
    <meta name="csrf-token" content="<?= \App\Core\Csrf::token() ?>">
    <script>window.BASE_URL = '<?= BASE_URL ?>';</script>
    <script src="<?= BASE_URL ?>/assets/js/csrf.js"></script>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            display: flex;
            background: #f0f4ff;
        }

        .auth-side {
            display: none;
            width: 50%;
            background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 50%, #1e40af 100%);
            position: relative;
            overflow: hidden;
        }
        .auth-side::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image: radial-gradient(circle at 1px 1px, rgba(255,255,255,0.06) 1px, transparent 0);
            background-size: 24px 24px;
        }
        .auth-side-content {
            position: relative;
            z-index: 1;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 4rem;
            color: white;
        }
        .auth-side-content h2 {
            font-size: 2.25rem;
            font-weight: 700;
            line-height: 1.2;
            margin-bottom: 1rem;
        }
        .auth-side-content p {
            font-size: 1rem;
            color: rgba(255,255,255,0.7);
            line-height: 1.6;
            max-width: 400px;
        }
        .auth-side .decor-circle {
            position: absolute;
            border-radius: 50%;
            border: 1px solid rgba(255,255,255,0.08);
        }
        .auth-side .decor-circle:nth-child(1) { width: 300px; height: 300px; top: -80px; right: -60px; }
        .auth-side .decor-circle:nth-child(2) { width: 200px; height: 200px; bottom: -40px; left: -40px; }
        .auth-side .decor-circle:nth-child(3) { width: 150px; height: 150px; bottom: 20%; right: 10%; border-color: rgba(255,255,255,0.04); }

        .side-stats {
            display: flex;
            gap: 1rem;
            margin-top: 2rem;
        }
        .stat-badge {
            padding: 0.6rem 1rem;
            background: rgba(255,255,255,0.1);
            border-radius: 10px;
            border: 1px solid rgba(255,255,255,0.12);
        }
        .stat-badge strong {
            display: block;
            font-size: 1.25rem;
            font-weight: 700;
        }
        .stat-badge span {
            font-size: 0.75rem;
            color: rgba(255,255,255,0.6);
        }

        .auth-main {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }
        .auth-card {
            width: 100%;
            max-width: 420px;
        }
        .auth-logo {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 2.5rem;
            text-decoration: none;
        }
        .auth-logo img {
            height: 44px;
            width: auto;
        }
        .auth-logo span {
            font-size: 1.25rem;
            font-weight: 700;
            color: #1e3a8a;
            letter-spacing: -0.02em;
        }
        .auth-title {
            font-size: 1.75rem;
            font-weight: 700;
            color: #111827;
            margin-bottom: 0.25rem;
        }
        .auth-subtitle {
            font-size: 0.9rem;
            color: #6b7280;
            margin-bottom: 2rem;
        }

        .field {
            margin-bottom: 1.25rem;
        }
        .field label {
            display: block;
            font-size: 0.8rem;
            font-weight: 600;
            color: #374151;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 0.5rem;
        }
        .field input {
            width: 100%;
            padding: 0.8rem 1rem;
            border: 2px solid #e5e7eb;
            border-radius: 10px;
            font-size: 0.95rem;
            font-family: 'Inter', sans-serif;
            color: #111827;
            background: #fff;
            transition: border-color 0.2s, box-shadow 0.2s;
        }
        .field input::placeholder {
            color: #9ca3af;
        }
        .field input:focus {
            outline: none;
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        .btn-register {
            width: 100%;
            padding: 0.85rem;
            background: #2563eb;
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 0.95rem;
            font-weight: 600;
            font-family: 'Inter', sans-serif;
            cursor: pointer;
            transition: background-color 0.2s, transform 0.1s;
            margin-top: 0.5rem;
        }
        .btn-register:hover {
            background: #1d4ed8;
        }
        .btn-register:active {
            transform: scale(0.99);
        }

        .auth-footer {
            text-align: center;
            margin-top: 1.75rem;
            font-size: 0.875rem;
            color: #6b7280;
        }
        .auth-footer a {
            color: #2563eb;
            text-decoration: none;
            font-weight: 600;
        }
        .auth-footer a:hover {
            text-decoration: underline;
        }

        .error-message {
            background: #fef2f2;
            color: #dc2626;
            font-size: 0.85rem;
            padding: 0.75rem 1rem;
            border-radius: 8px;
            margin-bottom: 1rem;
            text-align: center;
            display: none;
            border: 1px solid #fecaca;
        }

        @media (min-width: 1024px) {
            .auth-side { display: block; }
        }
    </style>
</head>
<body>
    <div class="auth-side">
        <div class="decor-circle"></div>
        <div class="decor-circle"></div>
        <div class="decor-circle"></div>
        <div class="auth-side-content">
            <h2>Начните свой путь<br>к образованию</h2>
            <p>Создайте аккаунт, чтобы отслеживать процесс поступления и получать персональные рекомендации от AI-помощника.</p>
            <div class="side-stats">
                <div class="stat-badge">
                    <strong>30+</strong>
                    <span>ВУЗов</span>
                </div>
                <div class="stat-badge">
                    <strong>1000+</strong>
                    <span>студентов</span>
                </div>
                <div class="stat-badge">
                    <strong>7+</strong>
                    <span>лет</span>
                </div>
            </div>
        </div>
    </div>

    <div class="auth-main">
        <div class="auth-card">
            <a href="<?= BASE_URL ?>/" class="auth-logo">
                <img src="<?= BASE_URL ?>/assets/img/logo.png" alt="Kettik Study">
                <span>Kettik Study</span>
            </a>

            <h1 class="auth-title">Создать аккаунт</h1>
            <p class="auth-subtitle">Начните свой путь к поступлению</p>

            <div id="error-msg" class="error-message"></div>

            <form id="register-form">
                <div class="field">
                    <label for="full_name">ФИО</label>
                    <input type="text" id="full_name" required placeholder="Иванов Иван">
                </div>
                <div class="field">
                    <label for="email">Email</label>
                    <input type="email" id="email" required placeholder="name@company.com">
                </div>
                <div class="field">
                    <label for="password">Пароль</label>
                    <input type="password" id="password" required placeholder="Минимум 6 символов">
                </div>
                <button type="submit" class="btn-register">Зарегистрироваться</button>
            </form>

            <div class="auth-footer">
                Уже есть аккаунт? <a href="<?= BASE_URL ?>/login">Войти</a>
            </div>
        </div>
    </div>

    <script src="<?= BASE_URL ?>/assets/js/auth.js"></script>
</body>
</html>
