<?php

return "
ALTER TABLE study_leads 
ADD COLUMN IF NOT EXISTS user_id INT NULL,
ADD CONSTRAINT fk_leads_user FOREIGN KEY (user_id) REFERENCES study_users(id) ON DELETE CASCADE;
";
