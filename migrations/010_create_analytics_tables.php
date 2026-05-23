<?php

return "
-- Visitor tracking table
CREATE TABLE IF NOT EXISTS study_visitors (
    id INT AUTO_INCREMENT PRIMARY KEY,
    session_id VARCHAR(64) UNIQUE NOT NULL,
    ip_address VARCHAR(45),
    user_agent TEXT,
    device_type ENUM('mobile', 'tablet', 'desktop') DEFAULT 'desktop',
    first_visit TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    last_visit TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    page_views INT DEFAULT 1,
    utm_source VARCHAR(100),
    utm_medium VARCHAR(100),
    utm_campaign VARCHAR(100),
    referrer TEXT,
    INDEX idx_session (session_id),
    INDEX idx_first_visit (first_visit)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Daily analytics aggregation
CREATE TABLE IF NOT EXISTS study_analytics_daily (
    id INT AUTO_INCREMENT PRIMARY KEY,
    date DATE UNIQUE NOT NULL,
    total_visitors INT DEFAULT 0,
    new_visitors INT DEFAULT 0,
    total_leads INT DEFAULT 0,
    qualified_leads INT DEFAULT 0,
    conversion_rate DECIMAL(5,2) DEFAULT 0.00,
    top_direction VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_date (date)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
";
