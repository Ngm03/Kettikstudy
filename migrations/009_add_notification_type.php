<?php

return "
ALTER TABLE study_notifications 
ADD COLUMN type ENUM('document', 'lead', 'message', 'system') DEFAULT 'system' 
AFTER body;
";
