<?php
$settings = (new \App\Models\Setting())->getAll();
$companyName = $settings['company_name'] ?? 'Kettik Study';
$companyPhone = $settings['company_phone'] ?? '+7 701 631 41 21';
$companyWhatsapp = $settings['company_whatsapp'] ?? '77016314121';
$whatsappClean = preg_replace('/[^0-9]/', '', $companyWhatsapp);
$instagram = $settings['company_instagram'] ?? '@kettik.study';
$youtube = $settings['company_youtube'] ?? '#';
$address = $settings['company_address'] ?? 'Онлайн по всему Казахстану';
$email = $settings['company_email'] ?? 'info@kettik.kz';

$authService = new \App\Services\AuthService();
$currentUser = $authService->getUserFromCookie();
?>
<!DOCTYPE html>
<html lang="ru" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $companyName ?> - Высшее образование в Польше | Поступление 2026</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <meta name="csrf-token" content="<?= \App\Core\Csrf::token() ?>">
    <script>window.BASE_URL = '<?= BASE_URL ?>';</script>
    <script src="<?= BASE_URL ?>/assets/js/csrf.js"></script>
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                    colors: {
                        primary: '#2563eb',
                        secondary: '#1e3a8a',
                    }
                }
            }
        }
    </script>
</head>
<body class="font-sans text-gray-900 antialiased bg-gray-50 overflow-x-hidden flex flex-col min-h-screen">

    <!-- Navbar -->
    <nav class="fixed w-full z-50 bg-white/90 backdrop-blur-md border-b border-gray-100 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <a href="<?= BASE_URL ?>/" class="flex items-center gap-3 decoration-transparent">
                    <img src="<?= BASE_URL ?>/assets/img/logo.PNG" alt="<?= $companyName ?>" class="h-10 w-auto">
                    <span class="text-xl font-bold text-blue-900 tracking-tight hidden sm:block"><?= $companyName ?></span>
                </a>

                <div class="hidden md:flex items-center gap-8">
                    <a href="#services" class="text-sm font-semibold text-gray-600 hover:text-primary transition">Наши услуги</a>
                    <a href="#benefits" class="text-sm font-semibold text-gray-600 hover:text-primary transition">Преимущества</a>
                </div>

                <div class="flex items-center gap-4">
                    <?php if ($currentUser): ?>
                        <a href="<?= BASE_URL ?>/dashboard" class="px-5 py-2.5 rounded-xl bg-primary text-white text-sm font-semibold shadow-lg shadow-blue-500/30 hover:bg-blue-700 transition duration-200">
                            Личный кабинет
                        </a>
                    <?php else: ?>
                        <a href="<?= BASE_URL ?>/login" class="hidden md:block text-sm font-semibold text-gray-600 hover:text-primary transition">
                            Войти
                        </a>
                        <a href="<?= BASE_URL ?>/register" class="px-5 py-2.5 rounded-xl bg-primary text-white text-sm font-semibold shadow-lg shadow-blue-500/30 hover:bg-blue-700 transition duration-200">
                            Оставить заявку
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <header class="relative pt-32 pb-20 lg:pt-48 lg:pb-32 bg-gray-50 overflow-hidden">
        <!-- Abstract Background Shapes -->
        <div class="absolute top-0 right-0 -mr-20 -mt-20 w-96 h-96 rounded-full bg-blue-100 opacity-50 blur-3xl"></div>
        <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-80 h-80 rounded-full bg-indigo-100 opacity-50 blur-3xl"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <!-- Content -->
                <div class="text-center lg:text-left">
                    <div class="inline-flex items-center px-4 py-2 rounded-full bg-blue-50 border border-blue-100 text-blue-700 text-sm font-bold mb-6 tracking-wide">
                        🎓 Набор на 2026/2027 учебный год открыт
                    </div>
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-gray-900 leading-tight mb-6 tracking-tight">
                        Kettik Study — твой путь<br> к высшему образованию в <span class="text-primary">Польше</span>
                    </h1>
                    <p class="text-lg md:text-xl text-gray-500 mb-10 max-w-2xl mx-auto lg:mx-0 leading-relaxed">
                        Мы берем на себя всю бюрократию: подбор программы, сбор документов, нострификацию и получение визы. Ваша задача — просто учиться.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                        <a href="<?= BASE_URL ?>/register" class="px-8 py-4 rounded-xl bg-primary hover:bg-blue-700 text-white font-bold text-lg shadow-xl shadow-blue-500/30 transition duration-200 flex items-center justify-center gap-2">
                            Начать поступление
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </a>
                        <a href="https://wa.me/<?= $whatsappClean ?>" target="_blank" class="px-8 py-4 rounded-xl bg-white border-2 border-gray-200 text-gray-700 hover:border-gray-300 hover:bg-gray-50 font-bold text-lg transition duration-200 flex items-center justify-center gap-2">
                            <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                            Консультация
                        </a>
                    </div>
                </div>
                
                <!-- Media / Image -->
                <div class="relative hidden lg:block">
                    <div class="absolute inset-0 bg-primary translate-x-4 translate-y-4 rounded-2xl opacity-10"></div>
                    <img src="https://images.unsplash.com/photo-1523050854058-8df90110c9f1?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Студенты в кампусе" class="relative z-10 rounded-2xl shadow-2xl object-cover w-full h-[500px]">
                </div>
            </div>
        </div>
    </header>

    <!-- Services Section -->
    <section id="services" class="py-24 bg-white border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900 tracking-tight mb-4">Наши услуги</h2>
                <p class="text-lg text-gray-500">Прозрачный и понятный процесс от выбора специальности до заселения в общежитие.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Service 1 -->
                <div class="p-8 rounded-2xl bg-gray-50 hover:bg-white border border-gray-100 hover:border-blue-100 hover:shadow-xl hover:shadow-blue-500/5 transition-all duration-300">
                    <div class="w-14 h-14 bg-blue-100 text-primary rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Подбор ВУЗа и программы</h3>
                    <p class="text-gray-600 leading-relaxed mb-4">Анализируем ваши оценки, бюджет и цели. Подбираем оптимальные университеты Польши на английском или польском языках.</p>
                </div>
                
                <!-- Service 2 -->
                <div class="p-8 rounded-2xl bg-gray-50 hover:bg-white border border-gray-100 hover:border-blue-100 hover:shadow-xl hover:shadow-blue-500/5 transition-all duration-300">
                    <div class="w-14 h-14 bg-indigo-100 text-indigo-600 rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Оформление документов</h3>
                    <p class="text-gray-600 leading-relaxed mb-4">Делаем присяжные переводы, ставим апостиль, проходим процедуру нострификации аттестата без вашего участия.</p>
                </div>
                
                <!-- Service 3 -->
                <div class="p-8 rounded-2xl bg-gray-50 hover:bg-white border border-gray-100 hover:border-blue-100 hover:shadow-xl hover:shadow-blue-500/5 transition-all duration-300">
                    <div class="w-14 h-14 bg-emerald-100 text-emerald-600 rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Виза и адаптация</h3>
                    <p class="text-gray-600 leading-relaxed mb-4">Готовим пакет для посольства, бронируем общежитие, встречаем по приезде и помогаем оформить PESEL и счет в банке.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Benefits / Stats Section -->
    <section id="benefits" class="py-20 bg-primary text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center divide-x divide-white/20">
                <div class="px-4">
                    <div class="text-4xl md:text-5xl font-black mb-2">7+</div>
                    <div class="text-sm font-semibold text-blue-100 uppercase tracking-widest">Лет опыта</div>
                </div>
                <div class="px-4">
                    <div class="text-4xl md:text-5xl font-black mb-2">1000+</div>
                    <div class="text-sm font-semibold text-blue-100 uppercase tracking-widest">Студентов</div>
                </div>
                <div class="px-4">
                    <div class="text-4xl md:text-5xl font-black mb-2">100%</div>
                    <div class="text-sm font-semibold text-blue-100 uppercase tracking-widest">Зачисление</div>
                </div>
                <div class="px-4">
                    <div class="text-4xl md:text-5xl font-black mb-2">30+</div>
                    <div class="text-sm font-semibold text-blue-100 uppercase tracking-widest">ВУЗов-партнеров</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 py-12 mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-center gap-6">
                <div class="flex items-center gap-3">
                    <span class="text-xl font-bold text-white tracking-tight"><?= $companyName ?></span>
                </div>
                
                <div class="flex gap-8">
                    <a href="https://wa.me/<?= $whatsappClean ?>" target="_blank" class="text-gray-400 hover:text-white font-medium transition">WhatsApp</a>
                    <a href="<?= BASE_URL ?>/login" class="text-gray-400 hover:text-white font-medium transition">Войти в кабинет</a>
                    <a href="<?= BASE_URL ?>/register" class="text-gray-400 hover:text-white font-medium transition">Оставить заявку</a>
                </div>
            </div>
            
            <div class="mt-8 pt-8 border-t border-gray-800 text-center md:text-left text-sm text-gray-500">
                &copy; <?= date('Y') ?> <?= $companyName ?>. Все права защищены.
            </div>
        </div>
    </footer>

</body>
</html>
