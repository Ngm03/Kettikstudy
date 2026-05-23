<?php

return "
CREATE TABLE IF NOT EXISTS study_documents (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    type VARCHAR(50),
    file_path VARCHAR(255) NOT NULL,
    original_name VARCHAR(255),
    status ENUM('pending', 'approved', 'rejected') DEFAULT 'pending',
    comment TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES study_users(id) ON DELETE CASCADE
) ENGINE=INNODB;
";
