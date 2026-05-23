<?php

return "
ALTER TABLE study_leads 
ADD COLUMN session_id VARCHAR(255) NULL AFTER id,
ADD INDEX (session_id);
";
