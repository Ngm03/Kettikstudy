<?php

return "
-- 1. Обновляем ENUM для роли в study_users, чтобы добавить 'manager'
ALTER TABLE study_users MODIFY COLUMN role ENUM('admin', 'manager', 'student') DEFAULT 'student';

-- 2. Добавляем manager_id в таблицу study_users, чтобы привязывать студента к менеджеру
-- Проверяем, существует ли колонка, чтобы миграция была идемпотентной
SET @dbname = DATABASE();
SET @tablename = 'study_users';
SET @columnname = 'manager_id';
SET @preparedStatement = (SELECT IF(
  (
    SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
    WHERE
      (table_name = @tablename)
      AND (table_schema = @dbname)
      AND (column_name = @columnname)
  ) > 0,
  'SELECT 1',
  'ALTER TABLE study_users ADD COLUMN manager_id INT NULL DEFAULT NULL AFTER id;'
));
PREPARE alterIfNotExists FROM @preparedStatement;
EXECUTE alterIfNotExists;
DEALLOCATE PREPARE alterIfNotExists;

-- 3. Добавляем manager_id в таблицу study_leads, чтобы закреплять заявку за менеджером
SET @tablename = 'study_leads';
SET @columnname = 'manager_id';
SET @preparedStatement = (SELECT IF(
  (
    SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
    WHERE
      (table_name = @tablename)
      AND (table_schema = @dbname)
      AND (column_name = @columnname)
  ) > 0,
  'SELECT 1',
  'ALTER TABLE study_leads ADD COLUMN manager_id INT NULL DEFAULT NULL AFTER id;'
));
PREPARE alterIfNotExists FROM @preparedStatement;
EXECUTE alterIfNotExists;
DEALLOCATE PREPARE alterIfNotExists;
";
