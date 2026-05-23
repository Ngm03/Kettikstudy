<?php

namespace App\Services\Chat;

/**
 * FileAttachmentService — безопасная загрузка файлов в чат.
 *
 * Ключевое отличие от старого кода: проверка MIME-типа через finfo_file(),
 * а не только по расширению. Расширение файла можно подделать — MIME нельзя.
 */
class FileAttachmentService
{
    /**
     * Разрешённые MIME-типы и соответствующие им расширения.
     * Расширение берётся отсюда, а не от клиента.
     */
    private const ALLOWED_MIME_TYPES = [
        'image/jpeg'                                                                 => 'jpg',
        'image/png'                                                                  => 'png',
        'image/gif'                                                                  => 'gif',
        'image/webp'                                                                 => 'webp',
        'application/pdf'                                                            => 'pdf',
        'application/msword'                                                         => 'doc',
        'application/vnd.openxmlformats-officedocument.wordprocessingml.document'   => 'docx',
        'application/vnd.ms-excel'                                                   => 'xls',
        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'         => 'xlsx',
        'text/plain'                                                                 => 'txt',
        'application/zip'                                                            => 'zip',
        'application/x-rar-compressed'                                               => 'rar',
        'application/vnd.rar'                                                        => 'rar',
    ];

    /**
     * Максимальный размер файла по умолчанию (10 МБ).
     * Может быть переопределён через настройки БД.
     */
    private const DEFAULT_MAX_SIZE_BYTES = 10 * 1024 * 1024;

    private string $uploadDir;
    private string $baseUrl;
    private int $maxSizeBytes;

    /**
     * @param string $uploadDir    Абсолютный путь до папки загрузок
     * @param string $baseUrl      BASE_URL для генерации публичного URL
     * @param int    $maxSizeBytes Максимальный размер файла в байтах
     */
    public function __construct(
        string $uploadDir,
        string $baseUrl,
        int $maxSizeBytes = self::DEFAULT_MAX_SIZE_BYTES
    ) {
        $this->uploadDir    = rtrim($uploadDir, '/\\') . DIRECTORY_SEPARATOR;
        $this->baseUrl      = rtrim($baseUrl, '/');
        $this->maxSizeBytes = $maxSizeBytes;
    }

    /**
     * Загружает файл из $_FILES['attachment'] (или переданного массива).
     *
     * @param  array $file Элемент из $_FILES
     * @return string      Публичный URL загруженного файла
     *
     * @throws \InvalidArgumentException если файл не прошёл проверку
     * @throws \RuntimeException         если не удалось сохранить файл
     */
    public function upload(array $file): string
    {
        // 1. Проверка ошибки загрузки
        if ($file['error'] !== UPLOAD_ERR_OK) {
            throw new \InvalidArgumentException(
                'Upload error code: ' . $file['error']
            );
        }

        // 2. Проверка размера
        if ($file['size'] > $this->maxSizeBytes) {
            $maxMb = round($this->maxSizeBytes / 1024 / 1024, 1);
            throw new \InvalidArgumentException(
                "File too large. Maximum allowed size: {$maxMb} MB."
            );
        }

        // 3. Проверка MIME-типа через finfo (реальное содержимое файла)
        if (!function_exists('finfo_open')) {
            throw new \RuntimeException('finfo extension is not available on this server.');
        }

        $finfo    = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($finfo, $file['tmp_name']);
        finfo_close($finfo);

        if (!array_key_exists($mimeType, self::ALLOWED_MIME_TYPES)) {
            throw new \InvalidArgumentException(
                "File type '{$mimeType}' is not allowed."
            );
        }

        // 4. Создаём папку, если не существует
        if (!is_dir($this->uploadDir) && !mkdir($this->uploadDir, 0755, true)) {
            throw new \RuntimeException('Failed to create upload directory.');
        }

        // 5. Генерируем безопасное имя файла (из MIME, не из расширения клиента)
        $ext      = self::ALLOWED_MIME_TYPES[$mimeType];
        $filename = 'att_' . bin2hex(random_bytes(8)) . '.' . $ext;
        $destPath = $this->uploadDir . $filename;

        // 6. Перемещаем файл
        if (!move_uploaded_file($file['tmp_name'], $destPath)) {
            throw new \RuntimeException('Failed to move uploaded file.');
        }

        return $this->baseUrl . '/uploads/chat/' . $filename;
    }

    /**
     * Удаляет файл вложения по его публичному URL.
     * Безопасно: проверяет, что файл находится в разрешённой директории.
     */
    public function delete(string $publicUrl): void
    {
        $filename = basename($publicUrl);
        // Защита от path traversal: берём только basename
        $filePath = $this->uploadDir . $filename;

        // Проверяем, что реальный путь находится внутри uploadDir
        $realUploadDir = realpath($this->uploadDir);
        $realFilePath  = realpath($filePath);

        if ($realFilePath && $realUploadDir && str_starts_with($realFilePath, $realUploadDir)) {
            @unlink($realFilePath);
        }
    }
}
