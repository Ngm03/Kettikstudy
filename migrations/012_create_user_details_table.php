<?php

return "CREATE TABLE IF NOT EXISTS study_user_details (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    passport_number VARCHAR(50) NULL,
    passport_issue_date DATE NULL,
    passport_expiry_date DATE NULL,
    passport_authority VARCHAR(255) NULL,
    iin VARCHAR(20) NULL,
    birth_date DATE NULL,
    birth_place VARCHAR(255) NULL,
    address_registration TEXT NULL,
    address_residential TEXT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES study_users(id) ON DELETE CASCADE
)";
