<?php

return "
CREATE TABLE IF NOT EXISTS study_leads (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255),
    phone VARCHAR(50),
    email VARCHAR(255),
    budget DECIMAL(10, 2),
    gpa DECIMAL(3, 2),
    language_level VARCHAR(10),
    status ENUM('new', 'hot', 'cold', 'converted') DEFAULT 'new',
    score INT DEFAULT 0,
    chat_history JSON,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=INNODB;
";
