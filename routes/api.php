<?php

// Публичный AI-чат на лендинге (до регистрации)
$router->post('/api/chat/send', [\App\Controllers\ChatController::class, 'send']);

// Документы студента
$router->post('/api/documents/upload', [\App\Controllers\DocumentController::class, 'upload'], ['auth']);
$router->get('/api/documents/list',    [\App\Controllers\DocumentController::class, 'list'],   ['auth']);
$router->get('/api/documents/view',    [\App\Controllers\DocumentController::class, 'view'],   ['auth']);
$router->post('/api/documents/delete', [\App\Controllers\DocumentController::class, 'delete'], ['auth']);

// Чеки об оплате (Студент)
$router->post('/api/payments/upload-receipt', [\App\Controllers\PaymentController::class, 'uploadReceipt'], ['auth']);
$router->get('/api/payments/my-receipts',     [\App\Controllers\PaymentController::class, 'myReceipts'],    ['auth']);
$router->get('/api/payments/view-receipt',    [\App\Controllers\PaymentController::class, 'viewReceipt'],   ['auth']);

// Профиль студента
$router->get('/api/profile/details',     [\App\Controllers\ProfileController::class, 'getDetails'],        ['auth']);
$router->post('/api/profile/update',     [\App\Controllers\ProfileController::class, 'updateDetails'],     ['auth']);
$router->get('/api/profile/progress',    [\App\Controllers\ProfileController::class, 'getProgress'],       ['auth']);
$router->get('/api/universities/list',   [\App\Controllers\ProfileController::class, 'getUniversitiesList'], ['auth']);

// Уведомления
$router->get('/api/notifications/unread',       [\App\Controllers\NotificationController::class, 'getUnread'],    ['auth']);
$router->post('/api/notifications/mark-read',   [\App\Controllers\NotificationController::class, 'markAsRead'],  ['auth']);
$router->post('/api/notifications/mark-all-read', [\App\Controllers\NotificationController::class, 'markAllAsRead'], ['auth']);

// Push-уведомления
$router->post('/api/push/subscribe',   [\App\Controllers\PushController::class, 'subscribe'],   ['auth']);
$router->post('/api/push/unsubscribe', [\App\Controllers\PushController::class, 'unsubscribe'], ['auth']);

// Задачи и расписание
$router->post('/api/tasks',    [\App\Controllers\TaskController::class,     'handle'], ['auth']);
$router->post('/api/schedule', [\App\Controllers\ScheduleController::class, 'create'], ['auth']);

// Community
$router->get('/api/cities/list', [\App\Controllers\CityController::class, 'listCities'], ['auth']);

// Community Chat (только авторизованные; enrolled-проверка внутри контроллера)
$router->get('/api/chat/rooms',            [\App\Controllers\CommunityChatController::class, 'getRooms'],           ['auth']);
$router->get('/api/chat/messages',         [\App\Controllers\CommunityChatController::class, 'getMessages'],        ['auth']);
$router->get('/api/chat/stream',           [\App\Controllers\CommunityChatController::class, 'streamMessages'],     ['auth']);
$router->post('/api/chat/messages',        [\App\Controllers\CommunityChatController::class, 'sendMessage'],        ['auth']);
$router->post('/api/chat/messages/edit',   [\App\Controllers\CommunityChatController::class, 'editMessage'],        ['auth']);
$router->post('/api/chat/messages/delete', [\App\Controllers\CommunityChatController::class, 'deleteMessage'],      ['auth']);
$router->get('/api/chat/unread',           [\App\Controllers\CommunityChatController::class, 'getUnreadCounts'],    ['auth']);
$router->post('/api/chat/read',            [\App\Controllers\CommunityChatController::class, 'markRead'],           ['auth']);
$router->post('/api/chat/messages/react',  [\App\Controllers\CommunityChatController::class, 'reactMessage'],       ['auth']);
$router->get('/api/chat/messages/search',  [\App\Controllers\CommunityChatController::class, 'searchMessages'],     ['auth']);
$router->post('/api/chat/ping',            [\App\Controllers\CommunityChatController::class, 'ping'],               ['auth']);
$router->post('/api/chat/start-private',   [\App\Controllers\CommunityChatController::class, 'getOrCreatePrivateRoom'], ['auth']);
