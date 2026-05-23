# KETTIK STUDY — МАСТЕР-ПЛАН

**Миссия:** Образование без границ. Помогаем студентам из РК и СНГ поступать в Польшу (с 2018).
**Контакты:** +48 506 304 046 (WhatsApp)
**Офис:** Атырау, мкрн. Авангард, ТЦ Коктем, 1 этаж, 19 офис.

---

## Реальное состояние проекта (актуально на 2026-05)

Система находится в стадии **активного рефакторинга MVP → Production-ready**.
Функциональность полностью реализована, ведётся устранение технического долга.

---

## Архитектура

**Backend:** PHP 8.1, кастомный MVC (без фреймворка)
**Frontend:** Vanilla HTML/CSS/JS + PHP-шаблоны (views/)
**База данных:** MySQL (PDO)
**Аутентификация:** Кастомный JWT (HMAC-SHA256), хранится в HttpOnly Cookie `auth_token`
**Авторизация:** Middleware-слой (`src/Middleware/`) — с версии 2.0

---

## Структура проекта

```
public/          # Front Controller (index.php) + статика
src/
  Controllers/   # HTTP-контроллеры (тонкие, только парсинг запроса/ответ)
  Core/          # Router, Database (Singleton PDO), Csrf, RateLimiter, Migrator
  Middleware/    # AuthMiddleware, RoleMiddleware
  Models/        # Manager, Setting, University, UserDetails
  Services/      # Бизнес-логика
    Chat/        # ChatRoomService, MessageService, FileAttachmentService, AiBotService
    AuthService, AiService, PdfService, Logger, StudentStageService, ...
  Helpers/       # I18n (локализация ru/kk)
views/           # PHP-шаблоны (admin/, auth/, chat/, dashboard/, manager/)
migrations/      # PHP-миграции (только .php, .sql-дампы запрещены в .gitignore)
config/          # Конфигурационные файлы
lang/            # Переводы (ru, kk)
```

---

## Роли пользователей

| Роль      | Описание                                              |
|-----------|-------------------------------------------------------|
| `admin`   | Полный доступ: студенты, лиды, документы, настройки   |
| `manager` | Лиды, студенты своего портфеля, приватные чаты        |
| `student` | Личный кабинет, загрузка документов, чат, профиль     |

**Enrolled-статус студента:** `enrolled_role = 'enrolled'` ИЛИ `study_contracts.status = 'paid'`
→ Даёт доступ к community-чату.

---

## Таблицы БД (реальная схема)

| Таблица                    | Назначение                                        |
|----------------------------|---------------------------------------------------|
| `study_users`              | Все пользователи (admin/manager/student)          |
| `study_leads`              | Лиды/заявки (воронка продаж)                      |
| `study_documents`          | Загруженные документы студентов                   |
| `study_contracts`          | Договоры (status: draft/sent/signed/paid)         |
| `study_notifications`      | Уведомления (type: broadcast/system)              |
| `study_broadcasts`         | История массовых рассылок                         |
| `study_chat_rooms`         | Комнаты чата (type: general/broadcast/city/private)|
| `study_chat_messages`      | Сообщения чата                                    |
| `study_chat_reactions`     | Эмодзи-реакции на сообщения                       |
| `study_chat_read_status`   | Отметки прочтения (last_read_at)                  |
| `study_cities`             | Города (Польша), привязка к студентам             |
| `study_communities`        | Сообщества студентов по городам                   |
| `study_universities`       | Университеты/колледжи                             |
| `study_managers`           | Профили менеджеров (active/inactive)              |
| `study_settings`           | Настройки системы (key-value)                     |
| `study_admin_logs`         | Лог действий администраторов                      |
| `study_user_details`       | Детали профиля студента (программа, GPA, страна)  |
| `study_prices`             | Прайс-листы                                       |
| `study_push_subscriptions` | Подписки на Web Push уведомления                  |
| `study_analytics_*`        | Таблицы аналитики (события, сессии)               |

---

## Ключевые сервисы

| Сервис                  | Что делает                                                              |
|-------------------------|-------------------------------------------------------------------------|
| `AuthService`           | Генерация/валидация JWT токенов (HMAC-SHA256). JWT_SECRET обязателен.   |
| `AiService`             | AI-консультант (fallback: Groq → Gemini → OpenRouter). JSON-режим.      |
| `PdfService`            | Генерация PDF-анкет студентов (TCPDF)                                   |
| `PushController`        | Web Push уведомления (minishlink/web-push)                              |
| `Logger`                | Аудит-лог действий администраторов                                      |
| `StudentStageService`   | Расчёт стадии студента в воронке                                        |
| `Chat/ChatRoomService`  | Управление комнатами чата                                               |
| `Chat/MessageService`   | Отправка, редактирование, удаление, поиск сообщений                     |
| `Chat/FileAttachmentService` | Загрузка файлов (проверка MIME-типа через finfo)                  |
| `Chat/AiBotService`     | AI-бот "Абай" в чате (триггер: @bot, @kettik, /ask)                     |

---

## Зависимости (composer.json)

- `vlucas/phpdotenv` ^5.5 — загрузка .env
- `firebase/php-jwt` ^7.0 — (установлен, не используется — кандидат на замену AuthService)
- `tecnickcom/tcpdf` ^6.10 — PDF генерация
- `minishlink/web-push` ^10.0 — Push уведомления

---

## Текущий статус: Устранение технического долга

**Что сделано:**
- [x] Удалены SQL-дампы из репозитория
- [x] Закрыта дыра JWT (убран fallback на md5)
- [x] Обновлён .gitignore (запрет на SQL-дампы)
- [x] Внедрён Middleware-слой (AuthMiddleware, RoleMiddleware)
- [x] Расщеплён CommunityChatController → Chat-сервисы

**Следующие приоритеты:**
- Внедрение тестов (PHPUnit)
- Переход с HTTP-polling на Server-Sent Events или WebSocket для чата
- Замена кастомного JWT на firebase/php-jwt (уже в зависимостях)
