document.addEventListener('DOMContentLoaded', () => {
    const loginForm = document.getElementById('login-form');
    const registerForm = document.getElementById('register-form');
    const errorMsg = document.getElementById('error-msg');

    function showError(message) {
        errorMsg.textContent = message;
        errorMsg.style.display = 'block';
    }

    if (loginForm) {
        loginForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;

            try {
                const response = await fetch(`${window.BASE_URL}/api/auth/login`, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ email, password })
                });

                const text = await response.text();
                try {
                    const data = JSON.parse(text);
                    if (response.ok) {
                        if (data.user.role === 'admin') {
                            window.location.href = `${window.BASE_URL}/admin/dashboard`;
                        } else if (data.user.role === 'manager') {
                            window.location.href = `${window.BASE_URL}/manager`;
                        } else if (data.user.role === 'affiliate') {
                            window.location.href = `${window.BASE_URL}/affiliate`;
                        } else {
                            window.location.href = `${window.BASE_URL}/dashboard`;
                        }
                    } else {
                        showError(data.error || 'Ошибка входа');
                    }
                } catch (e) {
                    console.error('Server Error:', text);
                    showError('Ошибка сервера (см. консоль)');
                }
            } catch (error) {
                showError('Ошибка соединения');
            }
        });
    }

    if (registerForm) {
        registerForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const full_name = document.getElementById('full_name').value;
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;

            try {
                const response = await fetch(`${window.BASE_URL}/api/auth/register`, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ full_name, email, password })
                });

                const text = await response.text();
                try {
                    const data = JSON.parse(text);
                    if (response.ok) {
                        alert('Регистрация успешна! Теперь войдите.');
                        window.location.href = `${window.BASE_URL}/login`;
                    } else {
                        showError(data.error || 'Ошибка регистрации');
                    }
                } catch (e) {
                    console.error('Server Error:', text);
                    showError('Ошибка сервера (см. консоль)');
                }
            } catch (error) {
                showError('Ошибка соединения');
            }
        });
    }

});
