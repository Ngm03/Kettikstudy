<?php

return "CREATE TABLE IF NOT EXISTS study_contracts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    type VARCHAR(50) DEFAULT 'consulting',
    status ENUM('pending', 'generated', 'signed', 'paid', 'cancelled') DEFAULT 'pending',
    pdf_path VARCHAR(255) NULL,
    amount DECIMAL(10, 2) DEFAULT 0.00,
    currency VARCHAR(3) DEFAULT 'KZT',
    signed_at DATETIME NULL,
    ip_address VARCHAR(45) NULL,
    sms_code VARCHAR(10) NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES study_users(id) ON DELETE CASCADE
)";
