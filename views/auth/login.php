<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Вход - Kettik Study</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <meta name="csrf-token" content="<?= \App\Core\Csrf::token() ?>">
    <script>window.BASE_URL = '<?= BASE_URL ?>';</script>
    <script src="<?= BASE_URL ?>/assets/js/csrf.js"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'sans-serif'] },
                    colors: { primary: '#2563eb' }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-50 flex items-center justify-center min-h-screen p-4">

    <div class="w-full max-w-md bg-white rounded-2xl shadow-xl border border-gray-100 p-8 sm:p-10">
        
        <div class="flex justify-center mb-8">
            <a href="<?= BASE_URL ?>/" class="flex items-center gap-2 decoration-transparent">
                <img src="<?= BASE_URL ?>/assets/img/logo.PNG" alt="Kettik Study" class="h-10 w-auto">
                <span class="text-xl font-bold text-blue-900 tracking-tight">Kettik Study</span>
            </a>
        </div>

        <div class="text-center mb-8">
            <h1 class="text-2xl font-bold text-gray-900 tracking-tight" id="form-title">Вход в кабинет</h1>
            <p class="text-sm text-gray-500 mt-2" id="form-subtitle">Введите свои данные для входа</p>
        </div>

        <div id="error-msg" class="bg-red-50 text-red-600 text-sm p-4 rounded-lg mb-6 border border-red-100 text-center" style="display: none;"></div>
        <div id="success-msg" class="bg-green-50 text-green-700 text-sm p-4 rounded-lg mb-6 border border-green-100 text-center" style="display: none;"></div>

        <!-- Login Form -->
        <form id="login-form">
            <div class="mb-5">
                <label for="email" class="block text-sm font-semibold text-gray-700 mb-1.5 uppercase tracking-wider">Email</label>
                <input type="email" id="email" required placeholder="name@company.com" 
                    class="w-full px-4 py-3 rounded-xl border-2 border-gray-100 focus:ring-4 focus:ring-primary/10 focus:border-primary outline-none transition bg-white text-gray-900">
            </div>
            <div class="mb-5">
                <div class="flex items-center justify-between mb-1.5">
                    <label for="password" class="block text-sm font-semibold text-gray-700 uppercase tracking-wider">Пароль</label>
                    <a href="#" class="text-sm font-medium text-primary hover:underline transition" onclick="toggleForm('forgot'); return false;">Забыли пароль?</a>
                </div>
                <input type="password" id="password" required placeholder="••••••••" 
                    class="w-full px-4 py-3 rounded-xl border-2 border-gray-100 focus:ring-4 focus:ring-primary/10 focus:border-primary outline-none transition bg-white text-gray-900">
            </div>
            <button type="submit" class="w-full py-3.5 px-4 bg-primary hover:bg-blue-700 text-white font-semibold rounded-xl shadow-lg shadow-blue-500/30 transition duration-200 mt-2">
                Войти
            </button>
            <div class="text-center text-sm text-gray-500 mt-6">
                Нет аккаунта? <a href="<?= BASE_URL ?>/register" class="font-semibold text-primary hover:underline transition">Зарегистрироваться</a>
            </div>
        </form>

        <!-- Forgot Password Form -->
        <form id="forgot-form" style="display: none;" onsubmit="handleForgot(event)">
            <div class="mb-5">
                <label for="forgot-email" class="block text-sm font-semibold text-gray-700 mb-1.5 uppercase tracking-wider">Email для восстановления</label>
                <input type="email" id="forgot-email" required placeholder="name@company.com" 
                    class="w-full px-4 py-3 rounded-xl border-2 border-gray-100 focus:ring-4 focus:ring-primary/10 focus:border-primary outline-none transition bg-white text-gray-900">
            </div>
            <button type="submit" class="w-full py-3.5 px-4 bg-primary hover:bg-blue-700 text-white font-semibold rounded-xl shadow-lg shadow-blue-500/30 transition duration-200 mt-2">
                Отправить ссылку
            </button>
            <div class="text-center text-sm mt-6">
                <a href="#" onclick="toggleForm('login'); return false;" class="font-semibold text-gray-500 hover:text-gray-900 transition">Вернуться ко входу</a>
            </div>
        </form>

        <!-- Reset Password Form -->
        <form id="reset-form" style="display: none;" onsubmit="handleReset(event)">
            <input type="hidden" id="reset-token">
            <div class="mb-5">
                <label for="new-password" class="block text-sm font-semibold text-gray-700 mb-1.5 uppercase tracking-wider">Новый пароль</label>
                <input type="password" id="new-password" required placeholder="Минимум 6 символов" minlength="6"
                    class="w-full px-4 py-3 rounded-xl border-2 border-gray-100 focus:ring-4 focus:ring-primary/10 focus:border-primary outline-none transition bg-white text-gray-900">
            </div>
            <button type="submit" class="w-full py-3.5 px-4 bg-primary hover:bg-blue-700 text-white font-semibold rounded-xl shadow-lg shadow-blue-500/30 transition duration-200 mt-2">
                Сохранить пароль
            </button>
            <div class="text-center text-sm mt-6">
                <a href="#" onclick="toggleForm('login'); return false;" class="font-semibold text-gray-500 hover:text-gray-900 transition">Вернуться ко входу</a>
            </div>
        </form>

    </div>

    <!-- ORIGINAL JS BLOCK PRESERVED EXACTLY AS BEFORE -->
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
