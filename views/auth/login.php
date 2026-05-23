<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Вход - Kettik Study</title>
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

        .btn-login {
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
        .btn-login:hover {
            background: #1d4ed8;
        }
        .btn-login:active {
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

        .divider {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin: 1.5rem 0;
            color: #9ca3af;
            font-size: 0.8rem;
        }
        .divider::before, .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: #e5e7eb;
        }

        .forgot-link {
            float: right;
            font-size: 0.8rem;
            color: #2563eb;
            text-decoration: none;
            text-transform: none;
            letter-spacing: normal;
        }
        .forgot-link:hover {
            text-decoration: underline;
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
            <h2>Добро пожаловать<br>в Kettik Study</h2>
            <p>Ваш надёжный партнёр на пути к европейскому образованию. Войдите в личный кабинет для отслеживания процесса поступления.</p>
        </div>
    </div>

    <div class="auth-main">
        <div class="auth-card">
            <a href="<?= BASE_URL ?>/" class="auth-logo">
                <img src="<?= BASE_URL ?>/assets/img/logo.PNG" alt="Kettik Study">
                <span>Kettik Study</span>
            </a>

            <h1 class="auth-title" id="form-title">Вход в кабинет</h1>
            <p class="auth-subtitle" id="form-subtitle">Введите свои данные для входа</p>

            <div id="error-msg" class="error-message"></div>
            <div id="success-msg" class="error-message" style="background: #f0fdf4; color: #166534; border-color: #bbf7d0;"></div>

            <!-- Login Form -->
            <form id="login-form">
                <div class="field">
                    <label for="email">Email</label>
                    <input type="email" id="email" required placeholder="name@company.com">
                </div>
                <div class="field">
                    <label for="password">
                        Пароль
                        <a href="#" class="forgot-link" onclick="toggleForm('forgot'); return false;">Забыли пароль?</a>
                    </label>
                    <input type="password" id="password" required placeholder="••••••••">
                </div>
                <button type="submit" class="btn-login">Войти</button>
                <div class="auth-footer">
                    Нет аккаунта? <a href="<?= BASE_URL ?>/register">Зарегистрироваться</a>
                </div>
            </form>

            <!-- Forgot Password Form -->
            <form id="forgot-form" style="display: none;" onsubmit="handleForgot(event)">
                <div class="field">
                    <label for="forgot-email">Email для восстановления</label>
                    <input type="email" id="forgot-email" required placeholder="name@company.com">
                </div>
                <button type="submit" class="btn-login">Отправить ссылку</button>
                <div class="auth-footer">
                    <a href="#" onclick="toggleForm('login'); return false;">Вернуться ко входу</a>
                </div>
            </form>

            <!-- Reset Password Form -->
            <form id="reset-form" style="display: none;" onsubmit="handleReset(event)">
                <input type="hidden" id="reset-token">
                <div class="field">
                    <label for="new-password">Новый пароль</label>
                    <input type="password" id="new-password" required placeholder="Минимум 6 символов" minlength="6">
                </div>
                <button type="submit" class="btn-login">Сохранить пароль</button>
                <div class="auth-footer">
                    <a href="#" onclick="toggleForm('login'); return false;">Вернуться ко входу</a>
                </div>
            </form>

        </div>
    </div>

    <script src="<?= BASE_URL ?>/assets/js/auth.js"></script>
    <script>
        // Check for reset token in URL
        const urlParams = new URLSearchParams(window.location.search);
        const resetToken = urlParams.get('reset_token');

        if (resetToken) {
            document.getElementById('reset-token').value = resetToken;
            toggleForm('reset');
        }

        function toggleForm(formType) {
            document.getElementById('login-form').style.display = 'none';
            document.getElementById('forgot-form').style.display = 'none';
            document.getElementById('reset-form').style.display = 'none';
            
            document.getElementById('error-msg').style.display = 'none';
            document.getElementById('success-msg').style.display = 'none';

            const title = document.getElementById('form-title');
            const subtitle = document.getElementById('form-subtitle');

            if (formType === 'forgot') {
                document.getElementById('forgot-form').style.display = 'block';
                title.textContent = 'Восстановление';
                subtitle.textContent = 'Укажите email для получения ссылки';
            } else if (formType === 'reset') {
                document.getElementById('reset-form').style.display = 'block';
                title.textContent = 'Новый пароль';
                subtitle.textContent = 'Придумайте надежный пароль';
            } else {
                document.getElementById('login-form').style.display = 'block';
                title.textContent = 'Вход в кабинет';
                subtitle.textContent = 'Введите свои данные для входа';
            }
        }

        function handleForgot(e) {
            e.preventDefault();
            const email = document.getElementById('forgot-email').value;
            const btn = e.target.querySelector('button');
            btn.disabled = true;
            btn.textContent = 'Отправка...';

            fetch(window.BASE_URL + '/api/auth/forgot-password', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ email })
            }).then(r => r.json()).then(data => {
                btn.disabled = false;
                btn.textContent = 'Отправить ссылку';
                if (data.success) {
                    const msg = document.getElementById('success-msg');
                    // MVP Hack: Show token directly for testing
                    if (data.debug_token) {
                        msg.innerHTML = `Ссылка отправлена!<br><br><b style="color:red">MVP TEST LINK:</b><br><a href="?reset_token=${data.debug_token}">Нажми сюда чтобы сбросить пароль</a>`;
                    } else {
                        msg.textContent = data.message;
                    }
                    msg.style.display = 'block';
                    document.getElementById('error-msg').style.display = 'none';
                } else {
                    const err = document.getElementById('error-msg');
                    err.textContent = data.error;
                    err.style.display = 'block';
                    document.getElementById('success-msg').style.display = 'none';
                }
            });
        }

        function handleReset(e) {
            e.preventDefault();
            const token = document.getElementById('reset-token').value;
            const password = document.getElementById('new-password').value;
            const btn = e.target.querySelector('button');
            btn.disabled = true;
            btn.textContent = 'Сохранение...';

            fetch(window.BASE_URL + '/api/auth/reset-password', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ token, password })
            }).then(r => r.json()).then(data => {
                btn.disabled = false;
                btn.textContent = 'Сохранить пароль';
                if (data.success) {
                    alert('Пароль успешно изменен! Теперь вы можете войти.');
                    window.location.href = window.BASE_URL + '/login';
                } else {
                    const err = document.getElementById('error-msg');
                    err.textContent = data.error;
                    err.style.display = 'block';
                }
            });
        }
    </script>
</body>
</html>
