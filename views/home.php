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
    <title>Kettik Study - Высшее образование в Польше | Поступление 2026</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <meta name="csrf-token" content="<?= \App\Core\Csrf::token() ?>">
    <script>window.BASE_URL = '<?= BASE_URL ?>';</script>
    <script src="<?= BASE_URL ?>/assets/js/csrf.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Outfit', 'sans-serif'],
                    },
                    colors: {
                        primary: '#2563EB',
                        secondary: '#1E40AF',
                        accent: '#F59E0B',
                        dark: '#0F172A',
                    },
                    animation: {
                        'float': 'float 6s ease-in-out infinite',
                        'pulse-slow': 'pulse 4s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                    },
                    keyframes: {
                        float: {
                            '0%, 100%': { transform: 'translateY(0)' },
                            '50%': { transform: 'translateY(-20px)' },
                        }
                    }
                }
            }
        }
    </script>
    <style>
        .glass-nav {
            background: rgba(255, 255, 255, 0.92);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
        }
        .glass-nav.scrolled {
            background: rgba(255, 255, 255, 0.97);
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.08);
        }
        .nav-link {
            position: relative;
            font-weight: 500;
            color: #475569;
            transition: color 0.3s;
        }
        .nav-link::after {
            content: '';
            position: absolute;
            bottom: -4px;
            left: 50%;
            width: 0;
            height: 2px;
            background: linear-gradient(90deg, #2563EB, #7C3AED);
            border-radius: 2px;
            transition: all 0.3s ease;
            transform: translateX(-50%);
        }
        .nav-link:hover { color: #2563EB; }
        .nav-link:hover::after { width: 100%; }
        
        .mobile-overlay {
            background: rgba(15, 23, 42, 0.6);
            backdrop-filter: blur(4px);
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }
        .mobile-overlay.active {
            opacity: 1;
            visibility: visible;
        }
        .mobile-menu {
            transform: translateX(100%);
            transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .mobile-menu.active {
            transform: translateX(0);
        }

        .hero-section {
            position: relative;
            overflow: hidden;
            min-height: 100vh;
        }
        .hero-bg-photo {
            position: absolute;
            inset: 0;
            background-image: url('https://images.unsplash.com/photo-1541339907198-e08756dedf3f?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80');
            background-size: cover;
            background-position: center 30%;
            z-index: 0;
        }
        .hero-gradient-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(
                135deg,
                rgba(15, 3, 45, 0.92) 0%,
                rgba(30, 10, 80, 0.88) 20%,
                rgba(20, 40, 120, 0.85) 40%,
                rgba(10, 60, 130, 0.82) 60%,
                rgba(5, 80, 120, 0.85) 80%,
                rgba(0, 60, 90, 0.90) 100%
            );
            z-index: 1;
        }
        .hero-mesh {
            position: absolute;
            inset: 0;
            z-index: 2;
            background:
                radial-gradient(ellipse 600px 400px at 15% 30%, rgba(139, 92, 246, 0.25) 0%, transparent 70%),
                radial-gradient(ellipse 500px 500px at 85% 20%, rgba(59, 130, 246, 0.2) 0%, transparent 70%),
                radial-gradient(ellipse 400px 300px at 70% 80%, rgba(6, 182, 212, 0.18) 0%, transparent 70%),
                radial-gradient(ellipse 300px 300px at 30% 85%, rgba(168, 85, 247, 0.15) 0%, transparent 70%);
        }

        @keyframes gradient-shift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        .hero-gradient-text {
            background: linear-gradient(90deg, #CBD5E1, #93C5FD, #E2E8F0, #BFDBFE, #94A3B8, #CBD5E1);
            background-size: 300% 100%;
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
            animation: gradient-shift 8s ease infinite;
        }
        
        @keyframes float-up {
            0% { transform: translateY(100vh) scale(0); opacity: 0; }
            10% { opacity: 1; }
            90% { opacity: 1; }
            100% { transform: translateY(-10vh) scale(1); opacity: 0; }
        }
        .hero-particles {
            position: absolute;
            inset: 0;
            z-index: 2;
            overflow: hidden;
        }
        .hero-particles span {
            position: absolute;
            width: 3px;
            height: 3px;
            background: rgba(255,255,255,0.15);
            border-radius: 50%;
            animation: float-up linear infinite;
        }
        
        .stat-card {
            position: relative;
            transition: all 0.4s ease;
        }
        .stat-card::before {
            content: '';
            position: absolute;
            inset: -1px;
            border-radius: 16px;
            background: linear-gradient(135deg, rgba(59,130,246,0.3), rgba(124,58,237,0.3));
            opacity: 0;
            transition: opacity 0.4s ease;
            z-index: -1;
        }
        .stat-card:hover::before { opacity: 1; }
        .stat-card:hover { transform: translateY(-4px); }

        .glass-card {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.5);
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.1);
        }
        .text-gradient {
            background: linear-gradient(135deg, #60A5FA 0%, #A78BFA 100%);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .logo-container {
            background: #ffffff;
            padding: 6px 12px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
            border: 1px solid rgba(0,0,0,0.04);
            transition: all 0.3s ease;
        }
        .logo-container:hover {
            box-shadow: 0 6px 20px rgba(37,99,235,0.15);
            border-color: rgba(37,99,235,0.1);
        }
        
        .btn-shine {
            position: relative;
            overflow: hidden;
        }
        .btn-shine::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
            transition: left 0.6s ease;
        }
        .btn-shine:hover::before {
            left: 100%;
        }
    </style>
</head>
<body class="font-sans text-gray-800 antialiased bg-gray-50 overflow-x-hidden">

    <nav class="fixed w-full z-50 glass-nav transition-all duration-500" id="navbar">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <a href="#" class="flex items-center gap-3 group" data-aos="fade-down">
                    <div class="logo-container">
                        <img src="<?= BASE_URL ?>/assets/img/logo.PNG" alt="Kettik Study" class="h-10 w-auto">
                    </div>
                    <div class="hidden sm:flex flex-col">
                        <span class="text-xl font-extrabold bg-clip-text text-transparent bg-gradient-to-r from-blue-600 to-indigo-600 leading-tight">Kettik Study</span>
                        <span class="text-[10px] font-medium text-gray-400 tracking-widest uppercase"><?= __('education_without_barriers') ?></span>
                    </div>
                </a>

                <div class="hidden lg:flex items-center gap-1" data-aos="fade-down" data-aos-delay="100">
                    <a href="#services" class="nav-link px-4 py-2"><?= __('services') ?></a>
                    <a href="#why-poland" class="nav-link px-4 py-2"><?= __('why_poland') ?></a>
                    <a href="#process" class="nav-link px-4 py-2"><?= __('process') ?></a>
                    <a href="#universities" class="nav-link px-4 py-2"><?= __('universities') ?></a>
                    <a href="#faq" class="nav-link px-4 py-2"><?= __('faq') ?></a>
                </div>

                <div class="hidden lg:flex items-center gap-3" data-aos="fade-down" data-aos-delay="200">
                    <?php if ($currentUser): ?>
                        <a href="<?= BASE_URL ?>/dashboard" class="btn-shine px-6 py-2.5 rounded-xl bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold shadow-lg shadow-blue-500/25 hover:shadow-blue-500/40 hover:-translate-y-0.5 transition-all duration-300">
                            <?= __('cabinet') ?>
                        </a>
                    <?php else: ?>
                        <a href="<?= BASE_URL ?>/login" class="px-5 py-2.5 rounded-xl text-gray-600 font-semibold hover:text-blue-600 hover:bg-blue-50 transition-all duration-300">
                            <?= __('login') ?>
                        </a>
                        <a href="<?= BASE_URL ?>/register" class="btn-shine px-6 py-2.5 rounded-xl bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold shadow-lg shadow-blue-500/25 hover:shadow-blue-500/40 hover:-translate-y-0.5 transition-all duration-300">
                            <?= __('apply') ?>
                        </a>
                    <?php endif; ?>
                </div>

                <button class="lg:hidden relative w-10 h-10 rounded-xl bg-gray-100 flex items-center justify-center hover:bg-blue-50 transition" id="mobile-menu-btn" onclick="toggleMobileMenu()">
                    <svg class="w-5 h-5 text-gray-700" id="menu-icon-open" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                    <svg class="w-5 h-5 text-gray-700 hidden" id="menu-icon-close" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
        </div>
    </nav>

    <div class="fixed inset-0 z-40 mobile-overlay" id="mobile-overlay" onclick="toggleMobileMenu()"></div>
    
    <div class="fixed top-0 right-0 w-80 max-w-[85vw] h-full z-50 bg-white shadow-2xl mobile-menu" id="mobile-menu">
        <div class="flex flex-col h-full">
            <div class="flex items-center justify-between p-6 border-b border-gray-100">
                <span class="text-lg font-bold text-gray-900"><?= __('menu') ?></span>
                <button class="w-10 h-10 rounded-xl bg-gray-100 flex items-center justify-center hover:bg-red-50 transition" onclick="toggleMobileMenu()">
                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            
            <div class="flex-1 overflow-y-auto p-6">
                <div class="space-y-1">
                    <a href="#services" onclick="toggleMobileMenu()" class="flex items-center gap-3 px-4 py-3.5 rounded-xl text-gray-700 font-medium hover:bg-blue-50 hover:text-blue-600 transition">
                        <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                        <?= __('services') ?>
                    </a>
                    <a href="#why-poland" onclick="toggleMobileMenu()" class="flex items-center gap-3 px-4 py-3.5 rounded-xl text-gray-700 font-medium hover:bg-blue-50 hover:text-blue-600 transition">
                        <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064"></path></svg>
                        <?= __('why_poland') ?>
                    </a>
                    <a href="#process" onclick="toggleMobileMenu()" class="flex items-center gap-3 px-4 py-3.5 rounded-xl text-gray-700 font-medium hover:bg-blue-50 hover:text-blue-600 transition">
                        <svg class="w-5 h-5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                        <?= __('process') ?>
                    </a>
                    <a href="#universities" onclick="toggleMobileMenu()" class="flex items-center gap-3 px-4 py-3.5 rounded-xl text-gray-700 font-medium hover:bg-blue-50 hover:text-blue-600 transition">
                        <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path></svg>
                        <?= __('universities') ?>
                    </a>
                    <a href="#faq" onclick="toggleMobileMenu()" class="flex items-center gap-3 px-4 py-3.5 rounded-xl text-gray-700 font-medium hover:bg-blue-50 hover:text-blue-600 transition">
                        <svg class="w-5 h-5 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <?= __('faq') ?>
                    </a>
                </div>
                
                <div class="mt-8 p-4 rounded-2xl bg-gradient-to-br from-blue-50 to-indigo-50 border border-blue-100">
                    <p class="text-xs font-bold text-blue-600 uppercase tracking-wider mb-3"><?= __('contact_us') ?></p>
                    <a href="https://wa.me/48506304046" class="flex items-center gap-2 text-sm text-gray-700 mb-2 hover:text-green-600 transition">
                        <svg class="w-4 h-4 text-green-500" fill="currentColor" viewBox="0 0 16 16"><path d="M13.601 2.326A7.854 7.854 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.9 7.9 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.898 7.898 0 0 0 13.6 2.326z"/></svg>
                        +48 506 304 046
                    </a>
                    <a href="mailto:kettikstudy@gmail.com" class="flex items-center gap-2 text-sm text-gray-700 hover:text-blue-600 transition">
                        <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        kettikstudy@gmail.com
                    </a>
                </div>
            </div>
            
            <div class="p-6 border-t border-gray-100 space-y-3">
                <?php if ($currentUser): ?>
                    <a href="<?= BASE_URL ?>/dashboard" class="block w-full text-center px-6 py-3.5 rounded-xl bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold shadow-lg shadow-blue-500/25 hover:shadow-blue-500/40 transition">
                        <?= __('cabinet') ?>
                    </a>
                <?php else: ?>
                    <a href="<?= BASE_URL ?>/register" class="block w-full text-center px-6 py-3.5 rounded-xl bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold shadow-lg shadow-blue-500/25 hover:shadow-blue-500/40 transition">
                        <?= __('apply') ?>
                    </a>
                    <a href="<?= BASE_URL ?>/login" class="block w-full text-center px-6 py-3.5 rounded-xl bg-gray-100 text-gray-700 font-semibold hover:bg-gray-200 transition">
                        <?= __('login_to_cabinet') ?>
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script>
    function toggleMobileMenu() {
        const menu = document.getElementById('mobile-menu');
        const overlay = document.getElementById('mobile-overlay');
        const iconOpen = document.getElementById('menu-icon-open');
        const iconClose = document.getElementById('menu-icon-close');
        const isActive = menu.classList.contains('active');
        
        menu.classList.toggle('active');
        overlay.classList.toggle('active');
        iconOpen.classList.toggle('hidden');
        iconClose.classList.toggle('hidden');
        document.body.style.overflow = isActive ? '' : 'hidden';
    }
    </script>

    
    <section class="relative pt-32 pb-20 lg:pt-48 lg:pb-32 bg-gray-50 overflow-hidden">
        <!-- ������������ ������� ����� -->
        <div class="absolute top-0 right-0 -mr-20 -mt-20 w-96 h-96 rounded-full bg-blue-100 opacity-50 blur-3xl"></div>
        <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-80 h-80 rounded-full bg-indigo-100 opacity-50 blur-3xl"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                
                <!-- ������� -->
                <div class="text-center lg:text-left" data-aos="fade-up" data-aos-duration="1000">
                    <div class="inline-flex items-center px-4 py-2 rounded-full bg-blue-50 border border-blue-100 text-blue-700 text-sm font-bold mb-6 tracking-wide">
                        ?? <?= __("hero_badge_text") ?? "����� �� 2026/2027 ������� ��� ������" ?>
                    </div>
                    
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-gray-900 leading-tight mb-6 tracking-tight">
                        <?= __("hero_title_1") ?><br>
                        <span class="text-blue-600"><?= __("hero_title_2") ?></span>
                    </h1>
                    
                    <p class="text-lg md:text-xl text-gray-500 mb-10 max-w-2xl mx-auto lg:mx-0 leading-relaxed">
                        <?= __("hero_subtitle_1") ?>
                        <span class="text-gray-900 font-semibold"><?= __("hero_subtitle_2") ?></span>
                    </p>
                    
                    <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start mb-8">
                        <button onclick="document.querySelector('#chat-toggle-btn').click()" class="px-8 py-4 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold text-lg shadow-xl shadow-blue-500/30 transition duration-200 flex items-center justify-center gap-2">
                            <?= __("choose_uni_ai") ?>
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </button>
                        <a href="https://wa.me/<?= $whatsappClean ?? '48506304046' ?>" target="_blank" class="px-8 py-4 rounded-xl bg-white border-2 border-gray-200 text-gray-700 hover:border-gray-300 hover:bg-gray-50 font-bold text-lg transition duration-200 flex items-center justify-center gap-2 shadow-sm">
                            <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347"/></svg>
                            WhatsApp
                        </a>
                    </div>
                    
                    <div class="flex flex-wrap justify-center lg:justify-start gap-6 text-sm text-gray-500 font-medium">
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                            <span><?= __("free_consultation") ?></span>
                        </div>
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                            <span><?= __("contract_guarantee") ?></span>
                        </div>
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                            <span><?= __("students_enrolled") ?></span>
                        </div>
                    </div>
                </div>

                <!-- �������� -->
                <div class="relative hidden lg:block" data-aos="fade-left" data-aos-duration="1000">
                    <div class="absolute inset-0 bg-blue-600 translate-x-4 translate-y-4 rounded-2xl opacity-10"></div>
                    <img src="https://images.unsplash.com/photo-1523050854058-8df90110c9f1?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="��������" class="relative z-10 rounded-2xl shadow-2xl object-cover w-full h-[450px]">
                </div>
            </div>
        </div>
    </section>
            <div class="w-full mt-24" id="stats-banner" data-aos="fade-up" data-aos-delay="300">
                <div class="max-w-5xl mx-auto">
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <div class="stat-card bg-white/[0.05] backdrop-blur-xl rounded-2xl p-7 text-center border border-white/[0.08] shadow-xl">
                            <div class="text-4xl md:text-5xl font-black text-white mb-2 counter" data-target="8" data-suffix="+">0</div>
                            <div class="text-cyan-300/70 text-xs font-semibold uppercase tracking-[0.2em]"><?= __('years_experience') ?></div>
                        </div>
                        <div class="stat-card bg-white/[0.05] backdrop-blur-xl rounded-2xl p-7 text-center border border-white/[0.08] shadow-xl">
                            <div class="text-4xl md:text-5xl font-black text-white mb-2 counter" data-target="700" data-suffix="+">0</div>
                            <div class="text-cyan-300/70 text-xs font-semibold uppercase tracking-[0.2em]"><?= __('students') ?></div>
                        </div>
                        <div class="stat-card bg-white/[0.05] backdrop-blur-xl rounded-2xl p-7 text-center border border-white/[0.08] shadow-xl">
                            <div class="text-4xl md:text-5xl font-black text-white mb-2">100%</div>
                            <div class="text-cyan-300/70 text-xs font-semibold uppercase tracking-[0.2em]"><?= __('admission') ?></div>
                        </div>
                        <div class="stat-card bg-white/[0.05] backdrop-blur-xl rounded-2xl p-7 text-center border border-white/[0.08] shadow-xl">
                            <div class="text-4xl md:text-5xl font-black text-white mb-2">24/7</div>
                            <div class="text-cyan-300/70 text-xs font-semibold uppercase tracking-[0.2em]"><?= __('support') ?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="absolute bottom-0 left-0 right-0 z-10">
            <svg viewBox="0 0 1440 120" fill="none" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none" class="w-full h-20 md:h-28">
                <path d="M0 60C240 20 480 100 720 60C960 20 1200 80 1440 50V120H0V60Z" fill="#F9FAFB"/>
            </svg>
        </div>
    </section>



    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const counters = document.querySelectorAll('.counter');
            
            const animateCounters = () => {
                counters.forEach(counter => {
                    const target = +counter.getAttribute('data-target');
                    const suffix = counter.getAttribute('data-suffix') || '+';
                    const count = +counter.innerText;
                    const increment = target / 100; // Speed

                    if (count < target) {
                        counter.innerText = Math.ceil(count + increment);
                        setTimeout(animateCounters, 20);
                    } else {
                        counter.innerText = target + suffix;
                    }
                });
            };

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        animateCounters();
                        observer.unobserve(entry.target);
                    }
                });
            });

            const statsSection = document.getElementById('stats-banner');
            if(statsSection) observer.observe(statsSection);
        });
    </script>

        <section id="services" class="py-24 bg-white border-b border-gray-100 relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16" data-aos="fade-up">
                <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-blue-50 border border-blue-100 text-blue-600 text-sm font-semibold mb-6">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    <?= __('full_support') ?>
                </div>
                <h2 class="text-4xl md:text-5xl font-extrabold text-gray-900 mb-5"><?= __('our_services') ?></h2>
                <p class="text-lg text-gray-500 max-w-2xl mx-auto"><?= __('services_subtitle') ?></p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
                
                <div class="group relative bg-white rounded-3xl p-8 md:p-10 border border-gray-100 shadow-sm hover:shadow-xl hover:border-blue-100 transition-all duration-400 overflow-hidden" data-aos="fade-up" data-aos-delay="0">
                    <div class="relative">
                        <div class="flex items-start justify-between mb-6">
                            <div class="w-14 h-14 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center group-hover:bg-blue-600 group-hover:text-white transition-colors duration-300">
                                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                            </div>
                            <span class="inline-flex items-center px-3 py-1 rounded-full bg-emerald-50 text-emerald-700 text-xs font-bold border border-emerald-100"><?= __('free') ?></span>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-3"><?= __('colleges_poland') ?></h3>
                        <p class="text-gray-500 mb-6 leading-relaxed"><?= __('colleges_desc') ?></p>
                        <div class="grid grid-cols-2 gap-3 mb-6">
                            <div class="flex items-center gap-2 text-sm text-gray-600">
                                <svg class="w-4 h-4 text-blue-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                <?= __('specialty_selection') ?>
                            </div>
                            <div class="flex items-center gap-2 text-sm text-gray-600">
                                <svg class="w-4 h-4 text-blue-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                <?= __('document_submission') ?>
                            </div>
                            <div class="flex items-center gap-2 text-sm text-gray-600">
                                <svg class="w-4 h-4 text-blue-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                <?= __('guardianship') ?>
                            </div>
                            <div class="flex items-center gap-2 text-sm text-gray-600">
                                <svg class="w-4 h-4 text-blue-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                <?= __('visa_help') ?>
                            </div>
                        </div>
                        <div class="flex items-center gap-3 text-xs text-gray-400">
                            <span class="px-2.5 py-1 rounded-lg bg-gray-50 border border-gray-100 font-medium"><?= __('years_5') ?></span>
                            <span class="px-2.5 py-1 rounded-lg bg-gray-50 border border-gray-100 font-medium"><?= __('specialties_16') ?></span>
                            <span class="px-2.5 py-1 rounded-lg bg-gray-50 border border-gray-100 font-medium"><?= __('in_polish') ?></span>
                        </div>
                    </div>
                </div>

                <div class="group relative bg-white rounded-3xl p-8 md:p-10 border border-gray-100 shadow-sm hover:shadow-xl hover:border-indigo-100 transition-all duration-400 overflow-hidden" data-aos="fade-up" data-aos-delay="100">
                    <div class="relative">
                        <div class="flex items-start justify-between mb-6">
                            <div class="w-14 h-14 bg-indigo-50 text-indigo-600 rounded-2xl flex items-center justify-center group-hover:bg-indigo-600 group-hover:text-white transition-colors duration-300">
                                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222"></path></svg>
                            </div>
                            <span class="inline-flex items-center px-3 py-1 rounded-full bg-indigo-50 text-indigo-700 text-xs font-bold border border-indigo-100"><?= __('from_1mln') ?></span>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-3"><?= __('bachelor') ?></h3>
                        <p class="text-gray-500 mb-6 leading-relaxed"><?= __('bachelor_desc') ?></p>
                        <div class="grid grid-cols-2 gap-3 mb-6">
                            <div class="flex items-center gap-2 text-sm text-gray-600">
                                <svg class="w-4 h-4 text-indigo-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                <?= __('individual_selection') ?>
                            </div>
                            <div class="flex items-center gap-2 text-sm text-gray-600">
                                <svg class="w-4 h-4 text-indigo-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                <?= __('visa_help') ?>
                            </div>
                            <div class="flex items-center gap-2 text-sm text-gray-600">
                                <svg class="w-4 h-4 text-indigo-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                <?= __('interview_prep') ?>
                            </div>
                            <div class="flex items-center gap-2 text-sm text-gray-600">
                                <svg class="w-4 h-4 text-indigo-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                <?= __('stipend_up_to_600k') ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-8">
                
                <div class="group bg-white rounded-2xl p-7 border border-gray-100 shadow-sm hover:shadow-xl hover:border-purple-100 transition-all duration-400" data-aos="fade-up" data-aos-delay="150">
                    <div class="w-12 h-12 bg-purple-50 text-purple-600 rounded-xl flex items-center justify-center mb-5 group-hover:bg-purple-600 group-hover:text-white transition-colors duration-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2"><?= __('master_mba') ?></h3>
                    <p class="text-gray-500 text-sm mb-4"><?= __('master_desc') ?></p>
                    <ul class="space-y-2 text-xs text-gray-600">
                        <li class="flex items-center gap-2"><svg class="w-4 h-4 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> <?= __('diploma_nostrification') ?></li>
                        <li class="flex items-center gap-2"><svg class="w-4 h-4 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> <?= __('apostille_translation') ?></li>
                        <li class="flex items-center gap-2"><svg class="w-4 h-4 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> <?= __('ielts_b2') ?></li>
                    </ul>
                </div>

                <div class="group bg-white rounded-2xl p-7 border border-gray-100 shadow-sm hover:shadow-xl hover:border-red-100 transition-all duration-400" data-aos="fade-up" data-aos-delay="200">
                    <div class="w-12 h-12 bg-red-50 text-red-600 rounded-xl flex items-center justify-center mb-5 group-hover:bg-red-600 group-hover:text-white transition-colors duration-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2"><?= __('visas_docs') ?></h3>
                    <p class="text-gray-500 text-sm mb-4"><?= __('visas_desc') ?></p>
                    <ul class="space-y-2 text-xs text-gray-600">
                        <li class="flex items-center gap-2"><svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> <?= __('visa_form') ?></li>
                        <li class="flex items-center gap-2"><svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> <?= __('insurance_30k') ?></li>
                        <li class="flex items-center gap-2"><svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> <?= __('days_14_process') ?></li>
                    </ul>
                </div>

                <div class="group bg-white rounded-2xl p-7 border border-gray-100 shadow-sm hover:shadow-xl hover:border-amber-100 transition-all duration-400" data-aos="fade-up" data-aos-delay="250">
                    <div class="w-12 h-12 bg-amber-50 text-amber-600 rounded-xl flex items-center justify-center mb-5 group-hover:bg-amber-600 group-hover:text-white transition-colors duration-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"></path></svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2"><?= __('foundation') ?></h3>
                    <p class="text-gray-500 text-sm mb-4"><?= __('foundation_desc') ?></p>
                    <ul class="space-y-2 text-xs text-gray-600">
                        <li class="flex items-center gap-2"><svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> <?= __('offline_at_uni') ?></li>
                        <li class="flex items-center gap-2"><svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> <?= __('cert_b1_b2') ?></li>
                        <li class="flex items-center gap-2"><svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> <?= __('months_9') ?></li>
                    </ul>
                </div>

                <div class="group bg-white rounded-2xl p-7 border border-gray-100 shadow-sm hover:shadow-xl hover:border-orange-100 transition-all duration-400" data-aos="fade-up" data-aos-delay="300">
                    <div class="w-12 h-12 bg-orange-50 text-orange-600 rounded-xl flex items-center justify-center mb-5 group-hover:bg-orange-600 group-hover:text-white transition-colors duration-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2"><?= __('summer_courses') ?></h3>
                    <p class="text-gray-500 text-sm mb-4"><?= __('summer_desc') ?></p>
                    <ul class="space-y-2 text-xs text-gray-600">
                        <li class="flex items-center gap-2"><svg class="w-4 h-4 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> <?= __('language_practice') ?></li>
                        <li class="flex items-center gap-2"><svg class="w-4 h-4 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> <?= __('europe_tours') ?></li>
                    </ul>
                </div>

                <div class="group bg-white rounded-2xl p-7 border border-gray-100 shadow-sm hover:shadow-xl hover:border-teal-100 transition-all duration-400" data-aos="fade-up" data-aos-delay="350">
                    <div class="w-12 h-12 bg-teal-50 text-teal-600 rounded-xl flex items-center justify-center mb-5 group-hover:bg-teal-600 group-hover:text-white transition-colors duration-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path></svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2"><?= __('career_guidance') ?></h3>
                    <p class="text-gray-500 text-sm mb-4"><?= __('career_desc') ?></p>
                    <ul class="space-y-2 text-xs text-gray-600">
                        <li class="flex items-center gap-2"><svg class="w-4 h-4 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> <?= __('aptitude_test') ?></li>
                        <li class="flex items-center gap-2"><svg class="w-4 h-4 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> <?= __('individual_coaching') ?></li>
                    </ul>
                </div>

                <div class="group bg-white rounded-2xl p-7 border border-gray-100 shadow-sm hover:shadow-xl hover:border-violet-100 transition-all duration-400" data-aos="fade-up" data-aos-delay="400">
                    <div class="w-12 h-12 bg-violet-50 text-violet-600 rounded-xl flex items-center justify-center mb-5 group-hover:bg-violet-600 group-hover:text-white transition-colors duration-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2"><?= __('camps') ?></h3>
                    <p class="text-gray-500 text-sm mb-4"><?= __('camps_desc') ?></p>
                    <ul class="space-y-2 text-xs text-gray-600">
                        <li class="flex items-center gap-2"><svg class="w-4 h-4 text-violet-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> <?= __('campus_tours') ?></li>
                        <li class="flex items-center gap-2"><svg class="w-4 h-4 text-violet-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> <?= __('live_country_experience') ?></li>
                    </ul>
                </div>
            </div>

            <div class="text-center mt-14" data-aos="fade-up" data-aos-delay="200">
                <p class="text-gray-500 mb-5"><?= __('dont_know_what_fits') ?></p>
                <button onclick="document.querySelector('#chat-toggle-btn').click()" class="inline-flex items-center gap-2 px-8 py-4 rounded-2xl bg-gray-900 text-white font-semibold hover:bg-gray-800 transition-all duration-300 shadow-lg shadow-gray-900/20 hover:-translate-y-0.5">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path></svg>
                    <?= __('ai_helps_choose') ?>
                </button>
            </div>
        </div>
    </section>


    <section id="why-poland" class="py-24 bg-white relative overflow-hidden">
        <div class="absolute top-20 right-0 w-[500px] h-[500px] bg-gradient-to-bl from-blue-50/80 to-transparent rounded-full translate-x-1/3"></div>
        <div class="absolute bottom-0 left-0 w-[400px] h-[400px] bg-gradient-to-tr from-indigo-50/60 to-transparent rounded-full -translate-x-1/4 translate-y-1/4"></div>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center mb-16" data-aos="fade-up">
                <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-indigo-50 border border-indigo-100 text-indigo-600 text-sm font-semibold mb-6">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <?= __('poland_advantages') ?>
                </div>
                <h2 class="text-4xl md:text-5xl font-extrabold text-gray-900 mb-5"><?= __('why_study_poland') ?></h2>
                <p class="text-lg text-gray-500 max-w-2xl mx-auto"><?= __('quality_education_affordable') ?></p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5" data-aos="fade-right">
                    <div class="group bg-gradient-to-br from-emerald-50 to-white rounded-2xl p-6 border border-emerald-100/60 hover:shadow-lg hover:shadow-emerald-100/50 transition-all duration-400">
                        <div class="w-11 h-11 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-xl flex items-center justify-center mb-4 shadow-md shadow-emerald-500/20">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <h4 class="font-bold text-gray-900 mb-1.5"><?= __('free_education') ?></h4>
                        <p class="text-gray-500 text-sm leading-relaxed"><?= __('free_education_desc') ?></p>
                    </div>

                    <div class="group bg-gradient-to-br from-blue-50 to-white rounded-2xl p-6 border border-blue-100/60 hover:shadow-lg hover:shadow-blue-100/50 transition-all duration-400">
                        <div class="w-11 h-11 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center mb-4 shadow-md shadow-blue-500/20">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222"></path></svg>
                        </div>
                        <h4 class="font-bold text-gray-900 mb-1.5"><?= __('stipends') ?></h4>
                        <p class="text-gray-500 text-sm leading-relaxed"><?= __('stipends_desc') ?></p>
                    </div>

                    <div class="group bg-gradient-to-br from-amber-50 to-white rounded-2xl p-6 border border-amber-100/60 hover:shadow-lg hover:shadow-amber-100/50 transition-all duration-400">
                        <div class="w-11 h-11 bg-gradient-to-br from-amber-500 to-amber-600 rounded-xl flex items-center justify-center mb-4 shadow-md shadow-amber-500/20">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        </div>
                        <h4 class="font-bold text-gray-900 mb-1.5"><?= __('work_residence') ?></h4>
                        <p class="text-gray-500 text-sm leading-relaxed"><?= __('work_residence_desc') ?></p>
                    </div>

                    <div class="group bg-gradient-to-br from-indigo-50 to-white rounded-2xl p-6 border border-indigo-100/60 hover:shadow-lg hover:shadow-indigo-100/50 transition-all duration-400">
                        <div class="w-11 h-11 bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-xl flex items-center justify-center mb-4 shadow-md shadow-indigo-500/20">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                        </div>
                        <h4 class="font-bold text-gray-900 mb-1.5"><?= __('schengen_zone') ?></h4>
                        <p class="text-gray-500 text-sm leading-relaxed"><?= __('schengen_desc') ?></p>
                    </div>

                    <div class="group bg-gradient-to-br from-teal-50 to-white rounded-2xl p-6 border border-teal-100/60 hover:shadow-lg hover:shadow-teal-100/50 transition-all duration-400">
                        <div class="w-11 h-11 bg-gradient-to-br from-teal-500 to-teal-600 rounded-xl flex items-center justify-center mb-4 shadow-md shadow-teal-500/20">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                        </div>
                        <h4 class="font-bold text-gray-900 mb-1.5"><?= __('safety') ?></h4>
                        <p class="text-gray-500 text-sm leading-relaxed"><?= __('safety_desc') ?></p>
                    </div>

                    <div class="group bg-gradient-to-br from-purple-50 to-white rounded-2xl p-6 border border-purple-100/60 hover:shadow-lg hover:shadow-purple-100/50 transition-all duration-400">
                        <div class="w-11 h-11 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl flex items-center justify-center mb-4 shadow-md shadow-purple-500/20">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path></svg>
                        </div>
                        <h4 class="font-bold text-gray-900 mb-1.5">Диплом ЕС</h4>
                        <p class="text-gray-500 text-sm leading-relaxed">Признан в ЕС и мире. Стоимость в 2-3 раза ниже Западной Европы</p>
                    </div>
                </div>

                <div class="relative" data-aos="fade-left">
                    <div class="relative rounded-3xl overflow-hidden shadow-2xl">
                        <img src="https://images.unsplash.com/photo-1523240795612-9a054b0db644?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Студенты в Польше" class="w-full h-[520px] object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-gray-900/80 via-gray-900/20 to-transparent"></div>
                        
                        <div class="absolute bottom-0 left-0 right-0 p-8">
                            <div class="grid grid-cols-3 gap-4">
                                <div class="text-center">
                                    <div class="text-3xl font-black text-white">400+</div>
                                    <div class="text-xs text-gray-300 font-medium uppercase tracking-wider mt-1">Специальностей</div>
                                </div>
                                <div class="text-center border-x border-white/20">
                                    <div class="text-3xl font-black text-white">EN/PL</div>
                                    <div class="text-xs text-gray-300 font-medium uppercase tracking-wider mt-1">Языки</div>
                                </div>
                                <div class="text-center">
                                    <div class="text-3xl font-black text-white">3-5</div>
                                    <div class="text-xs text-gray-300 font-medium uppercase tracking-wider mt-1">Лет обучения</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="absolute -bottom-6 -left-6 bg-white rounded-2xl p-5 shadow-xl border border-gray-100 max-w-[220px]" data-aos="fade-up" data-aos-delay="300">
                        <div class="flex items-center gap-3 mb-2">
                            <div class="w-9 h-9 bg-emerald-50 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                            </div>
                            <span class="text-sm font-bold text-gray-900">Стоимость жизни</span>
                        </div>
                        <p class="text-xs text-gray-500 leading-relaxed">Общежитие: 100–400K ₸/мес<br>Питание: 70–150K ₸/мес</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-16 relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-r from-gray-900 via-indigo-950 to-gray-900"></div>
        <div class="absolute inset-0" style="background-image: radial-gradient(rgba(99,102,241,0.15) 1px, transparent 1px); background-size: 30px 30px;"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 flex flex-col md:flex-row items-center justify-between gap-8">
            <div class="md:w-2/3">
                <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/10 backdrop-blur-md mb-5 text-sm font-semibold text-indigo-300 border border-white/10">
                    <span class="relative flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-indigo-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-indigo-400"></span>
                    </span>
                    <?= __('campaign_2026') ?>
                </div>
                <h2 class="text-3xl md:text-4xl font-extrabold text-white mb-4"><?= __('start_journey') ?></h2>
                <p class="text-indigo-200/80 text-lg max-w-2xl"><?= __('journey_desc') ?></p>
            </div>
            <div class="md:w-1/3 text-center md:text-right flex flex-col gap-3">
                <button onclick="document.querySelector('#chat-toggle-btn').click()" class="inline-flex items-center justify-center gap-2 px-8 py-4 bg-white text-gray-900 font-bold rounded-2xl text-lg shadow-xl shadow-white/10 hover:shadow-white/20 hover:-translate-y-1 transition duration-300">
                    <?= __('apply_now') ?>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                </button>
                <a href="https://wa.me/48506304046" target="_blank" class="inline-flex items-center justify-center gap-2 px-6 py-3 rounded-2xl bg-white/10 border border-white/10 text-white text-sm font-medium hover:bg-white/15 transition">
                    <svg class="w-4 h-4 text-green-400" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                    <?= __('or_whatsapp') ?>
                </a>
            </div>
        </div>
    </section>

    <section id="about" class="py-24 bg-white relative overflow-hidden">
        <div class="absolute top-0 left-0 w-[400px] h-[400px] bg-gradient-to-br from-blue-50/50 to-transparent rounded-full -translate-x-1/3 -translate-y-1/4"></div>
        <div class="absolute bottom-0 right-0 w-[500px] h-[500px] bg-gradient-to-tl from-indigo-50/40 to-transparent rounded-full translate-x-1/4 translate-y-1/4"></div>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                
                <div data-aos="fade-right">
                    <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-blue-50 border border-blue-100 text-blue-600 text-sm font-semibold mb-6">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <?= __('about_company') ?>
                    </div>
                    <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-5 leading-tight"><?= __('about_title') ?></h2>
                    <p class="text-gray-500 text-lg mb-5 leading-relaxed">
                        <?= __('about_desc_1') ?>
                    </p>
                    <p class="text-gray-500 mb-8 leading-relaxed">
                        <?= __('about_desc_2') ?>
                    </p>

                    <div class="grid grid-cols-4 gap-4 mb-8">
                        <div class="text-center p-3 rounded-xl bg-gray-50 border border-gray-100">
                            <div class="text-2xl font-black text-gray-900">8+</div>
                            <div class="text-[11px] text-gray-400 font-medium mt-0.5"><?= __('years_experience') ?></div>
                        </div>
                        <div class="text-center p-3 rounded-xl bg-gray-50 border border-gray-100">
                            <div class="text-2xl font-black text-gray-900">700+</div>
                            <div class="text-[11px] text-gray-400 font-medium mt-0.5"><?= __('students_count') ?></div>
                        </div>
                        <div class="text-center p-3 rounded-xl bg-gray-50 border border-gray-100">
                            <div class="text-2xl font-black text-gray-900">100%</div>
                            <div class="text-[11px] text-gray-400 font-medium mt-0.5"><?= __('admission_rate') ?></div>
                        </div>
                        <div class="text-center p-3 rounded-xl bg-gray-50 border border-gray-100">
                            <div class="text-2xl font-black text-gray-900">24/7</div>
                            <div class="text-[11px] text-gray-400 font-medium mt-0.5"><?= __('support_24_7') ?></div>
                        </div>
                    </div>

                    <div class="flex flex-wrap gap-3">
                        <button onclick="document.querySelector('#process').scrollIntoView({behavior: 'smooth'})" class="inline-flex items-center gap-2 px-7 py-3 rounded-xl bg-gray-900 text-white font-semibold hover:bg-gray-800 transition shadow-lg shadow-gray-900/15 hover:-translate-y-0.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                            <?= __('how_we_work') ?>
                        </button>
                        <button onclick="document.querySelector('#universities').scrollIntoView({behavior: 'smooth'})" class="inline-flex items-center gap-2 px-7 py-3 rounded-xl bg-gray-100 text-gray-700 font-semibold hover:bg-gray-200 transition">
                            <?= __('view_universities') ?>
                        </button>
                    </div>
                </div>

                <div class="relative" data-aos="fade-left">
                    <div class="relative rounded-3xl overflow-hidden shadow-2xl">
                        <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Команда Kettik Study" class="w-full h-[480px] object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-gray-900/70 via-transparent to-transparent"></div>
                        
                        <div class="absolute bottom-0 left-0 right-0 p-7">
                            <div class="flex items-center gap-4">
                                <div class="flex -space-x-2">
                                    <div class="w-9 h-9 rounded-full bg-gradient-to-br from-blue-400 to-blue-600 border-2 border-white flex items-center justify-center text-white text-xs font-bold">K</div>
                                    <div class="w-9 h-9 rounded-full bg-gradient-to-br from-purple-400 to-purple-600 border-2 border-white flex items-center justify-center text-white text-xs font-bold">S</div>
                                    <div class="w-9 h-9 rounded-full bg-gradient-to-br from-teal-400 to-teal-600 border-2 border-white flex items-center justify-center text-white text-xs font-bold">+</div>
                                </div>
                                <div>
                                    <p class="text-white text-sm font-semibold"><?= __('team_name') ?></p>
                                    <p class="text-gray-300 text-xs"><?= __('team_location') ?></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="absolute -top-5 -right-5 bg-white rounded-2xl p-4 shadow-xl border border-gray-100 hidden md:block" data-aos="fade-down" data-aos-delay="300">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-blue-50 rounded-xl flex items-center justify-center">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-gray-900"><?= __('office_atyrau') ?></p>
                                <p class="text-[10px] text-gray-400"><?= __('office_address') ?></p>
                            </div>
                        </div>
                    </div>

                    <div class="absolute -bottom-5 -left-5 bg-white rounded-2xl p-4 shadow-xl border border-gray-100 hidden md:block" data-aos="fade-up" data-aos-delay="400">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-green-50 rounded-xl flex items-center justify-center">
                                <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-gray-900"><?= __('free_consult') ?></p>
                                <p class="text-[10px] text-gray-400">+48 506 304 046</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>



    <section id="process" class="py-24 relative overflow-hidden" style="background: linear-gradient(135deg, #f8fafc 0%, #eef2ff 50%, #f8fafc 100%);">
        <div class="absolute inset-0 opacity-40" style="background-image: radial-gradient(circle at 1px 1px, rgba(99,102,241,0.07) 1px, transparent 0); background-size: 32px 32px;"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center mb-20" data-aos="fade-up">
                <span class="inline-block px-4 py-1.5 rounded-full bg-blue-100 text-blue-700 text-sm font-semibold mb-4"><?= __('process_subtitle') ?></span>
                <h2 class="text-4xl md:text-5xl font-extrabold text-gray-900"><?= __('process_title') ?></h2>
                <p class="text-gray-500 mt-4 text-lg max-w-2xl mx-auto"><?= __('process_desc') ?></p>
            </div>

            <div class="relative">
                <div class="hidden lg:block absolute left-1/2 top-0 bottom-0 w-0.5 -translate-x-1/2">
                    <div class="w-full h-full bg-gradient-to-b from-blue-300 via-indigo-300 via-purple-300 to-emerald-300 rounded-full"></div>
                </div>

                <div class="relative lg:grid lg:grid-cols-2 lg:gap-16 mb-12 lg:mb-16" data-aos="fade-up">
                    <div class="hidden lg:flex absolute left-1/2 top-8 -translate-x-1/2 z-20">
                        <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center text-white font-bold text-sm shadow-lg shadow-blue-500/30 ring-4 ring-white">01</div>
                    </div>
                    
                    <div class="lg:text-right lg:pr-8">
                        <div class="flex items-center gap-3 mb-3 lg:justify-end">
                            <div class="lg:hidden w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center text-white font-bold text-xs shadow-lg">01</div>
                            <span class="px-3 py-1 bg-blue-100 text-blue-700 text-xs font-semibold rounded-full"><?= __('phase_1_steps') ?></span>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-2"><?= __('phase_1_title') ?></h3>
                        <p class="text-gray-500 text-sm mb-4"><?= __('phase_1_desc') ?></p>
                    </div>
                    
                    <div class="lg:pl-8 mt-4 lg:mt-0">
                        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-xl hover:border-blue-200 transition-all duration-300 space-y-4">
                            <div class="flex items-start gap-3">
                                <div class="w-7 h-7 bg-blue-50 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5">
                                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                                </div>
                                <div>
                                    <h4 class="text-sm font-semibold text-gray-900"><?= __('step_1_title') ?></h4>
                                    <p class="text-xs text-gray-500 mt-0.5"><?= __('step_1_desc') ?></p>
                                </div>
                            </div>
                            <div class="flex items-start gap-3">
                                <div class="w-7 h-7 bg-blue-50 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5">
                                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                </div>
                                <div>
                                    <h4 class="text-sm font-semibold text-gray-900"><?= __('step_2_title') ?></h4>
                                    <p class="text-xs text-gray-500 mt-0.5"><?= __('step_2_desc') ?></p>
                                </div>
                            </div>
                            <div class="flex items-start gap-3">
                                <div class="w-7 h-7 bg-blue-50 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5">
                                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </div>
                                <div>
                                    <h4 class="text-sm font-semibold text-gray-900"><?= __('step_3_title') ?></h4>
                                    <p class="text-xs text-gray-500 mt-0.5"><?= __('step_3_desc') ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="relative lg:grid lg:grid-cols-2 lg:gap-16 mb-12 lg:mb-16" data-aos="fade-up" data-aos-delay="100">
                    <div class="hidden lg:flex absolute left-1/2 top-8 -translate-x-1/2 z-20">
                        <div class="w-12 h-12 bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-full flex items-center justify-center text-white font-bold text-sm shadow-lg shadow-indigo-500/30 ring-4 ring-white">02</div>
                    </div>
                    
                    <div class="lg:pr-8 order-2 lg:order-1 mt-4 lg:mt-0">
                        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-xl hover:border-indigo-200 transition-all duration-300 space-y-4">
                            <div class="flex items-start gap-3">
                                <div class="w-7 h-7 bg-indigo-50 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5">
                                    <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                </div>
                                <div>
                                    <h4 class="text-sm font-semibold text-gray-900"><?= __('step_4_title') ?></h4>
                                    <p class="text-xs text-gray-500 mt-0.5"><?= __('step_4_desc') ?></p>
                                </div>
                            </div>
                            <div class="flex items-start gap-3">
                                <div class="w-7 h-7 bg-indigo-50 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5">
                                    <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                                </div>
                                <div>
                                    <h4 class="text-sm font-semibold text-gray-900"><?= __('step_5_title') ?></h4>
                                    <p class="text-xs text-gray-500 mt-0.5"><?= __('step_5_desc') ?></p>
                                </div>
                            </div>
                            <div class="flex items-start gap-3">
                                <div class="w-7 h-7 bg-indigo-50 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5">
                                    <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                </div>
                                <div>
                                    <h4 class="text-sm font-semibold text-gray-900"><?= __('step_6_title') ?></h4>
                                    <p class="text-xs text-gray-500 mt-0.5"><?= __('step_6_desc') ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="lg:pl-8 order-1 lg:order-2">
                        <div class="flex items-center gap-3 mb-3">
                            <div class="lg:hidden w-10 h-10 bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-full flex items-center justify-center text-white font-bold text-xs shadow-lg">02</div>
                            <span class="px-3 py-1 bg-indigo-100 text-indigo-700 text-xs font-semibold rounded-full"><?= __('phase_2_steps') ?></span>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-2"><?= __('phase_2_title') ?></h3>
                        <p class="text-gray-500 text-sm mb-4"><?= __('phase_2_desc') ?></p>
                    </div>
                </div>

                <div class="relative lg:grid lg:grid-cols-2 lg:gap-16 mb-12 lg:mb-16" data-aos="fade-up" data-aos-delay="200">
                    <div class="hidden lg:flex absolute left-1/2 top-8 -translate-x-1/2 z-20">
                        <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-purple-600 rounded-full flex items-center justify-center text-white font-bold text-sm shadow-lg shadow-purple-500/30 ring-4 ring-white">03</div>
                    </div>
                    
                    <div class="lg:text-right lg:pr-8">
                        <div class="flex items-center gap-3 mb-3 lg:justify-end">
                            <div class="lg:hidden w-10 h-10 bg-gradient-to-br from-purple-500 to-purple-600 rounded-full flex items-center justify-center text-white font-bold text-xs shadow-lg">03</div>
                            <span class="px-3 py-1 bg-purple-100 text-purple-700 text-xs font-semibold rounded-full"><?= __('phase_3_steps') ?></span>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-2"><?= __('phase_3_title') ?></h3>
                        <p class="text-gray-500 text-sm mb-4"><?= __('phase_3_desc') ?></p>
                    </div>
                    
                    <div class="lg:pl-8 mt-4 lg:mt-0">
                        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-xl hover:border-purple-200 transition-all duration-300 space-y-4">
                            <div class="flex items-start gap-3">
                                <div class="w-7 h-7 bg-purple-50 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5">
                                    <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path></svg>
                                </div>
                                <div>
                                    <h4 class="text-sm font-semibold text-gray-900"><?= __('step_7_title') ?></h4>
                                    <p class="text-xs text-gray-500 mt-0.5"><?= __('step_7_desc') ?></p>
                                </div>
                            </div>
                            <div class="flex items-start gap-3">
                                <div class="w-7 h-7 bg-purple-50 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5">
                                    <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                                </div>
                                <div>
                                    <h4 class="text-sm font-semibold text-gray-900"><?= __('step_8_title') ?></h4>
                                    <p class="text-xs text-gray-500 mt-0.5"><?= __('step_8_desc') ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="relative lg:grid lg:grid-cols-2 lg:gap-16" data-aos="fade-up" data-aos-delay="300">
                    <div class="hidden lg:flex absolute left-1/2 top-8 -translate-x-1/2 z-20">
                        <div class="w-12 h-12 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-full flex items-center justify-center text-white font-bold text-sm shadow-lg shadow-emerald-500/30 ring-4 ring-white">04</div>
                    </div>
                    
                    <div class="lg:pr-8 order-2 lg:order-1 mt-4 lg:mt-0">
                        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-xl hover:border-emerald-200 transition-all duration-300 space-y-4">
                            <div class="flex items-start gap-3">
                                <div class="w-7 h-7 bg-emerald-50 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5">
                                    <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                                </div>
                                <div>
                                    <h4 class="text-sm font-semibold text-gray-900"><?= __('step_9_title') ?></h4>
                                    <p class="text-xs text-gray-500 mt-0.5"><?= __('step_9_desc') ?></p>
                                </div>
                            </div>
                            <div class="flex items-start gap-3 pt-3 border-t border-gray-50">
                                <div class="w-7 h-7 bg-emerald-50 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5">
                                    <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                                </div>
                                <div>
                                    <h4 class="text-sm font-semibold text-gray-900"><?= __('curator_on_site') ?></h4>
                                    <p class="text-xs text-gray-500 mt-0.5"><?= __('curator_desc') ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="lg:pl-8 order-1 lg:order-2">
                        <div class="flex items-center gap-3 mb-3">
                            <div class="lg:hidden w-10 h-10 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-full flex items-center justify-center text-white font-bold text-xs shadow-lg">04</div>
                            <span class="px-3 py-1 bg-emerald-100 text-emerald-700 text-xs font-semibold rounded-full"><?= __('phase_4_steps') ?></span>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-2"><?= __('phase_4_title') ?></h3>
                        <p class="text-gray-500 text-sm mb-4"><?= __('phase_4_desc') ?></p>
                    </div>
                </div>
            </div>

            <div class="text-center mt-16" data-aos="fade-up">
                <a href="https://wa.me/48506304046" target="_blank" class="inline-flex items-center gap-3 px-8 py-4 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold rounded-2xl hover:from-blue-500 hover:to-indigo-500 transition-all shadow-lg shadow-blue-500/20 hover:shadow-blue-500/30 hover:-translate-y-0.5">
                    <?= __('start_free_consult') ?>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                </a>
                <p class="text-gray-400 text-sm mt-3"><?= __('reply_in_10_min') ?></p>
            </div>
        </div>
    </section>

    <section id="universities" class="py-24 bg-gray-50 overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-16 text-center" data-aos="fade-up">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4"><?= __('unis_title') ?></h2>
            <p class="text-gray-500"><?= __('unis_subtitle') ?></p>
        </div>

        <div class="relative w-full overflow-hidden">
            <div class="absolute inset-y-0 left-0 w-32 bg-gradient-to-r from-gray-50 to-transparent z-10 pointer-events-none"></div>
            <div class="absolute inset-y-0 right-0 w-32 bg-gradient-to-l from-gray-50 to-transparent z-10 pointer-events-none"></div>
            
            <?php 
                $uniCount = !empty($universities) ? count($universities) : 0;
                $duration = max(10, $uniCount * 5);
            ?>

            <?php if ($uniCount > 1): ?>
            <div class="flex hover:pause" style="animation: marquee <?= $duration ?>s linear infinite;">
                <div class="flex gap-8 px-4">
                    <?php foreach ($universities as $uni): ?>
                    <div class="w-64 h-32 bg-white rounded-2xl shadow-sm border border-gray-100 flex items-center justify-center p-6 group hover:border-blue-500 transition duration-300 flex-shrink-0">
                        <img src="<?= BASE_URL . $uni['logo_path'] ?>" alt="<?= htmlspecialchars($uni['name']) ?>" class="max-h-16 max-w-full object-contain filter grayscale group-hover:grayscale-0 transition duration-300">
                    </div>
                    <?php endforeach; ?>
                </div>

                <div class="flex gap-8 px-4">
                    <?php foreach ($universities as $uni): ?>
                    <div class="w-64 h-32 bg-white rounded-2xl shadow-sm border border-gray-100 flex items-center justify-center p-6 group hover:border-blue-500 transition duration-300 flex-shrink-0">
                        <img src="<?= BASE_URL . $uni['logo_path'] ?>" alt="<?= htmlspecialchars($uni['name']) ?>" class="max-h-16 max-w-full object-contain filter grayscale group-hover:grayscale-0 transition duration-300">
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php elseif ($uniCount === 1): ?>
            <div class="flex justify-center">
                <div class="w-64 h-32 bg-white rounded-2xl shadow-sm border border-gray-100 flex items-center justify-center p-6 group hover:border-blue-500 transition duration-300">
                    <img src="<?= BASE_URL . $universities[0]['logo_path'] ?>" alt="<?= htmlspecialchars($universities[0]['name']) ?>" class="max-h-16 max-w-full object-contain filter grayscale group-hover:grayscale-0 transition duration-300">
                </div>
            </div>
            <?php else: ?>
            <div class="flex justify-center">
                <div class="w-64 h-32 bg-white rounded-2xl shadow-sm border border-gray-100 flex items-center justify-center p-6">
                    <span class="text-gray-400"><?= __('unis_coming_soon') ?></span>
                </div>
            </div>
            <?php endif; ?>

            <div class="mt-12 text-center" data-aos="fade-up">
                 <button onclick="document.querySelector('#chat-toggle-btn').click()" class="inline-flex items-center justify-center px-8 py-4 border border-transparent text-lg font-bold rounded-full text-white bg-primary hover:bg-blue-700 md:text-xl transition shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                    <?= __('pick_uni_with_ai') ?>
                    <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                </button>
            </div>
        </div>
        
        <style>
        @keyframes marquee {
            0% { transform: translateX(0); }
            100% { transform: translateX(-50%); }
        }
        .hover\:pause:hover {
            animation-play-state: paused;
        }
        </style>
    </section>

    <section id="faq" class="py-24 bg-white">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-14" data-aos="fade-up">
                <span class="inline-block px-4 py-1.5 rounded-full bg-blue-50 text-blue-600 text-sm font-semibold mb-4"><?= __('faq_help_badge') ?></span>
                <h2 class="text-4xl font-bold text-gray-900"><?= __('faq_title') ?></h2>
                <p class="text-gray-500 mt-3 text-lg"><?= __('faq_subtitle') ?></p>
            </div>
            
            <div class="space-y-3" id="faq-list">
                <div class="faq-card border border-gray-200 rounded-xl bg-white transition-all duration-300 hover:border-blue-200 hover:shadow-sm" data-aos="fade-up">
                    <button class="w-full flex items-center justify-between p-5 text-left focus:outline-none" onclick="toggleSimpleFaq(this)">
                        <span class="font-semibold text-gray-800 text-[15px] pr-4"><?= __('faq_1_q') ?></span>
                        <svg class="faq-arrow w-5 h-5 text-gray-400 flex-shrink-0 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div class="faq-answer max-h-0 overflow-hidden transition-all duration-400 ease-in-out">
                        <div class="px-5 pb-5 text-gray-600 leading-relaxed text-sm border-t border-gray-100 pt-3">
                            <?= __('faq_1_a') ?>
                        </div>
                    </div>
                </div>

                <div class="faq-card border border-gray-200 rounded-xl bg-white transition-all duration-300 hover:border-blue-200 hover:shadow-sm" data-aos="fade-up" data-aos-delay="50">
                    <button class="w-full flex items-center justify-between p-5 text-left focus:outline-none" onclick="toggleSimpleFaq(this)">
                        <span class="font-semibold text-gray-800 text-[15px] pr-4"><?= __('faq_2_q') ?></span>
                        <svg class="faq-arrow w-5 h-5 text-gray-400 flex-shrink-0 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div class="faq-answer max-h-0 overflow-hidden transition-all duration-400 ease-in-out">
                        <div class="px-5 pb-5 text-gray-600 leading-relaxed text-sm border-t border-gray-100 pt-3">
                            <?= __('faq_2_a') ?>
                        </div>
                    </div>
                </div>

                <div class="faq-card border border-gray-200 rounded-xl bg-white transition-all duration-300 hover:border-blue-200 hover:shadow-sm" data-aos="fade-up" data-aos-delay="100">
                    <button class="w-full flex items-center justify-between p-5 text-left focus:outline-none" onclick="toggleSimpleFaq(this)">
                        <span class="font-semibold text-gray-800 text-[15px] pr-4"><?= __('faq_3_q') ?></span>
                        <svg class="faq-arrow w-5 h-5 text-gray-400 flex-shrink-0 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div class="faq-answer max-h-0 overflow-hidden transition-all duration-400 ease-in-out">
                        <div class="px-5 pb-5 text-gray-600 leading-relaxed text-sm border-t border-gray-100 pt-3">
                            <?= __('faq_3_a') ?>
                        </div>
                    </div>
                </div>

                <div class="faq-card border border-gray-200 rounded-xl bg-white transition-all duration-300 hover:border-blue-200 hover:shadow-sm" data-aos="fade-up" data-aos-delay="150">
                    <button class="w-full flex items-center justify-between p-5 text-left focus:outline-none" onclick="toggleSimpleFaq(this)">
                        <span class="font-semibold text-gray-800 text-[15px] pr-4"><?= __('faq_4_q') ?></span>
                        <svg class="faq-arrow w-5 h-5 text-gray-400 flex-shrink-0 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div class="faq-answer max-h-0 overflow-hidden transition-all duration-400 ease-in-out">
                        <div class="px-5 pb-5 text-gray-600 leading-relaxed text-sm border-t border-gray-100 pt-3">
                            <?= __('faq_4_a') ?>
                        </div>
                    </div>
                </div>

                <div class="faq-card border border-gray-200 rounded-xl bg-white transition-all duration-300 hover:border-blue-200 hover:shadow-sm" data-aos="fade-up" data-aos-delay="200">
                    <button class="w-full flex items-center justify-between p-5 text-left focus:outline-none" onclick="toggleSimpleFaq(this)">
                        <span class="font-semibold text-gray-800 text-[15px] pr-4"><?= __('faq_5_q') ?></span>
                        <svg class="faq-arrow w-5 h-5 text-gray-400 flex-shrink-0 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div class="faq-answer max-h-0 overflow-hidden transition-all duration-400 ease-in-out">
                        <div class="px-5 pb-5 text-gray-600 leading-relaxed text-sm border-t border-gray-100 pt-3">
                            <?= __('faq_5_a') ?>
                        </div>
                    </div>
                </div>

                <div class="faq-card border border-gray-200 rounded-xl bg-white transition-all duration-300 hover:border-blue-200 hover:shadow-sm" data-aos="fade-up" data-aos-delay="250">
                    <button class="w-full flex items-center justify-between p-5 text-left focus:outline-none" onclick="toggleSimpleFaq(this)">
                        <span class="font-semibold text-gray-800 text-[15px] pr-4"><?= __('faq_6_q') ?></span>
                        <svg class="faq-arrow w-5 h-5 text-gray-400 flex-shrink-0 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div class="faq-answer max-h-0 overflow-hidden transition-all duration-400 ease-in-out">
                        <div class="px-5 pb-5 text-gray-600 leading-relaxed text-sm border-t border-gray-100 pt-3">
                            <?= __('faq_6_a') ?>
                        </div>
                    </div>
                </div>

                <div class="faq-card border border-gray-200 rounded-xl bg-white transition-all duration-300 hover:border-blue-200 hover:shadow-sm" data-aos="fade-up" data-aos-delay="300">
                    <button class="w-full flex items-center justify-between p-5 text-left focus:outline-none" onclick="toggleSimpleFaq(this)">
                        <span class="font-semibold text-gray-800 text-[15px] pr-4"><?= __('faq_7_q') ?></span>
                        <svg class="faq-arrow w-5 h-5 text-gray-400 flex-shrink-0 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div class="faq-answer max-h-0 overflow-hidden transition-all duration-400 ease-in-out">
                        <div class="px-5 pb-5 text-gray-600 leading-relaxed text-sm border-t border-gray-100 pt-3">
                            <?= __('faq_7_a') ?>
                        </div>
                    </div>
                </div>

                <div class="faq-card border border-gray-200 rounded-xl bg-white transition-all duration-300 hover:border-blue-200 hover:shadow-sm" data-aos="fade-up" data-aos-delay="350">
                    <button class="w-full flex items-center justify-between p-5 text-left focus:outline-none" onclick="toggleSimpleFaq(this)">
                        <span class="font-semibold text-gray-800 text-[15px] pr-4"><?= __('faq_8_q') ?></span>
                        <svg class="faq-arrow w-5 h-5 text-gray-400 flex-shrink-0 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div class="faq-answer max-h-0 overflow-hidden transition-all duration-400 ease-in-out">
                        <div class="px-5 pb-5 text-gray-600 leading-relaxed text-sm border-t border-gray-100 pt-3">
                            <?= __('faq_8_a') ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center mt-10" data-aos="fade-up">
                <p class="text-gray-500 text-sm mb-3"><?= __('didnt_find_answer') ?></p>
                <button onclick="document.getElementById('chat-toggle')?.click()" class="inline-flex items-center gap-2 px-5 py-2.5 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition-colors text-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                    <?= __('ask_ai') ?>
                </button>
            </div>
        </div>

        <script>
            function toggleSimpleFaq(btn) {
                const card = btn.closest('.faq-card');
                const answer = card.querySelector('.faq-answer');
                const arrow = btn.querySelector('.faq-arrow');
                const isOpen = card.classList.contains('open');

                document.querySelectorAll('#faq-list .faq-card').forEach(c => {
                    c.classList.remove('open');
                    c.querySelector('.faq-answer').style.maxHeight = null;
                    c.querySelector('.faq-arrow').style.transform = '';
                    c.style.borderColor = '';
                });

                if (!isOpen) {
                    card.classList.add('open');
                    answer.style.maxHeight = answer.scrollHeight + 'px';
                    arrow.style.transform = 'rotate(180deg)';
                    card.style.borderColor = '#bfdbfe';
                }
            }
        </script>
    </section>

    <footer class="bg-dark text-gray-400 pt-20 pb-8 relative overflow-hidden">
        <div class="absolute -top-24 -left-24 w-96 h-96 bg-blue-900/20 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-24 -right-24 w-96 h-96 bg-purple-900/20 rounded-full blur-3xl"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 mb-16">

                <div class="lg:col-span-1">
                    <a href="#" class="flex items-center gap-3 mb-6 group">
                        <div class="bg-white rounded-xl p-2 shadow-sm group-hover:shadow-md transition-shadow">
                            <img src="<?= BASE_URL ?>/assets/img/logo.PNG" alt="<?= htmlspecialchars($companyName) ?>" class="h-10 w-auto">
                        </div>
                        <span class="text-xl font-bold text-white"><?= htmlspecialchars($companyName) ?></span>
                    </a>
                    <p class="text-sm leading-relaxed text-gray-400 mb-6"><?= __('eu_diploma_sub') ?></p>
                    
                    <div class="flex gap-3">
                        <?php if ($instagram && $instagram !== '#'): ?>
                        <a href="https://instagram.com/<?= str_replace(['@', 'https://instagram.com/'], '', $instagram) ?>" target="_blank" class="w-10 h-10 rounded-xl bg-white/5 border border-white/10 flex items-center justify-center hover:bg-gradient-to-tr hover:from-yellow-400 hover:via-red-500 hover:to-purple-500 hover:border-transparent transition-all text-gray-400 hover:text-white" aria-label="Instagram">
                             <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                        </a>
                        <?php endif; ?>
                        
                        <?php if ($youtube && $youtube !== '#'): ?>
                        <a href="<?= $youtube ?>" target="_blank" class="w-10 h-10 rounded-xl bg-white/5 border border-white/10 flex items-center justify-center hover:bg-red-600 hover:border-transparent transition-all text-gray-400 hover:text-white" aria-label="YouTube">
                             <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                        </a>
                        <?php endif; ?>

                        <a href="https://wa.me/<?= $whatsappClean ?>" target="_blank" class="w-10 h-10 rounded-xl bg-white/5 border border-white/10 flex items-center justify-center hover:bg-green-600 hover:border-transparent transition-all text-gray-400 hover:text-white" aria-label="WhatsApp">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 16 16"><path d="M13.601 2.326A7.854 7.854 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.9 7.9 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.898 7.898 0 0 0 13.6 2.326zM7.994 14.521a6.573 6.573 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.557 6.557 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592zm3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.729.729 0 0 0-.529.247c-.182.198-.691.677-.691 1.654 0 .977.71 1.916.81 2.049.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232z"/></svg>
                        </a>
                    </div>
                </div>

                <div>
                     <h4 class="text-white font-bold mb-6 text-sm uppercase tracking-wider">Меню</h4>
                     <ul class="space-y-3 text-sm">
                         <li><a href="#" class="hover:text-white transition flex items-center gap-2 group"><span class="w-1.5 h-1.5 bg-blue-500 rounded-full opacity-0 group-hover:opacity-100 transition"></span><?= __('menu_main') ?></a></li>
                         <li><a href="#services" class="hover:text-white transition flex items-center gap-2 group"><span class="w-1.5 h-1.5 bg-blue-500 rounded-full opacity-0 group-hover:opacity-100 transition"></span><?= __('menu_services') ?></a></li>
                         <li><a href="#universities" class="hover:text-white transition flex items-center gap-2 group"><span class="w-1.5 h-1.5 bg-blue-500 rounded-full opacity-0 group-hover:opacity-100 transition"></span><?= __('menu_unis') ?></a></li>
                         <li><a href="#process" class="hover:text-white transition flex items-center gap-2 group"><span class="w-1.5 h-1.5 bg-blue-500 rounded-full opacity-0 group-hover:opacity-100 transition"></span><?= __('menu_process') ?></a></li>
                         <li><a href="#faq" class="hover:text-white transition flex items-center gap-2 group"><span class="w-1.5 h-1.5 bg-blue-500 rounded-full opacity-0 group-hover:opacity-100 transition"></span><?= __('menu_faq') ?></a></li>
                     </ul>
                </div>

                <div>
                    <h4 class="text-white font-bold mb-6 text-sm uppercase tracking-wider"><?= __('contacts') ?></h4>
                    <ul class="space-y-4 text-sm">
                        <?php 
                        $addresses = array_filter(explode("\n", $address));
                        foreach ($addresses as $addr_line): 
                        ?>
                        <li class="flex items-start gap-3 p-3 rounded-xl hover:bg-white/5 transition">
                            <div class="w-8 h-8 rounded-lg bg-blue-500/10 flex items-center justify-center flex-shrink-0 mt-0.5">
                                <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            </div>
                            <span class="text-gray-300 leading-relaxed"><?= htmlspecialchars(trim($addr_line)) ?></span>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </div>

                <div>
                    <h4 class="text-white font-bold mb-6 text-sm uppercase tracking-wider"><?= __('get_in_touch') ?></h4>
                    <div class="space-y-3 text-sm">
                        <div class="flex items-center gap-3 p-3 rounded-xl hover:bg-white/5 transition">
                            <div class="w-8 h-8 rounded-lg bg-blue-500/10 flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                            </div>
                            <div class="flex flex-col gap-1">
                                <a href="tel:<?= preg_replace('/[^0-9\+]/', '', $companyPhone) ?>" class="text-gray-300 hover:text-white transition"><?= $companyPhone ?></a>
                                <?php if ($companyWhatsapp && $companyWhatsapp !== $companyPhone): ?>
                                    <a href="https://wa.me/<?= $whatsappClean ?>" class="text-gray-300 hover:text-white transition">WhatsApp: <?= $companyWhatsapp ?></a>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="flex items-center gap-3 p-3 rounded-xl hover:bg-white/5 transition">
                            <div class="w-8 h-8 rounded-lg bg-blue-500/10 flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            </div>
                            <a href="mailto:<?= $email ?>" class="text-blue-400 hover:text-blue-300 transition font-medium"><?= $email ?></a>
                        </div>
                    </div>
                </div>

            </div>

            <div class="border-t border-white/10 pt-8 flex flex-col md:flex-row justify-between items-center gap-4">
                <p class="text-sm text-gray-500"><?= __('all_rights_reserved') ?></p>
                <div class="flex gap-6 text-xs text-gray-500">
                    <a href="#" class="hover:text-white transition"><?= __('privacy_policy') ?></a>
                    <a href="#" class="hover:text-white transition"><?= __('offer') ?></a>
                </div>
            </div>
        </div>
    </footer>

    <?php include __DIR__ . '/chat/widget.php'; ?>
    <script src="<?= BASE_URL ?>/assets/js/chat.js"></script>

    <script>
        AOS.init({
            once: true,
            duration: 800,
            offset: 100,
        });

        window.addEventListener('scroll', () => {
            const navbar = document.getElementById('navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });
    </script>
</body>
</html>
