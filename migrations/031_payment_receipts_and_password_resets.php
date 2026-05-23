<?php

/**
 * Миграция: Payment Receipts + Password Resets
 *
 * study_payment_receipts — чеки об оплате, загружаемые студентами.
 * study_password_resets  — токены для сброса пароля.
 */
return [

    // -------------------------------------------------------------------------
    // 1. Чеки оплаты
    // -------------------------------------------------------------------------
    "CREATE TABLE IF NOT EXISTS study_payment_receipts (
        id               INT          AUTO_INCREMENT PRIMARY KEY,
        user_id          INT          NOT NULL,
        contract_id      INT          NULL,
        file_path        VARCHAR(500) NOT NULL,
        original_name    VARCHAR(255) NOT NULL,
        amount           DECIMAL(12,2) NULL COMMENT 'Сумма, указанная студентом',
        currency         VARCHAR(10)  NOT NULL DEFAULT 'KZT',
        comment          TEXT         NULL COMMENT 'Комментарий студента к платежу',
        status           ENUM('pending','approved','rejected') NOT NULL DEFAULT 'pending',
        rejection_reason TEXT         NULL,
        uploaded_at      TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP,
        reviewed_at      TIMESTAMP    NULL,
        reviewed_by      INT          NULL COMMENT 'ID менеджера/админа, кто проверил',
        FOREIGN KEY (user_id) REFERENCES study_users(id) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci",

    // -------------------------------------------------------------------------
    // 2. Связь чека с договором (добавляем поле к contracts, если ещё нет)
    // -------------------------------------------------------------------------
    "ALTER TABLE study_contracts
        ADD COLUMN IF NOT EXISTS receipt_id INT NULL COMMENT 'Последний одобренный чек'",

    // -------------------------------------------------------------------------
    // 3. Токены сброса пароля
    // -------------------------------------------------------------------------
    "CREATE TABLE IF NOT EXISTS study_password_resets (
        id         INT          AUTO_INCREMENT PRIMARY KEY,
        email      VARCHAR(255) NOT NULL,
        token      VARCHAR(64)  NOT NULL UNIQUE,
        expires_at TIMESTAMP    NOT NULL,
        used       TINYINT(1)   NOT NULL DEFAULT 0,
        created_at TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP,
        INDEX idx_token (token),
        INDEX idx_email (email)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci",

];
