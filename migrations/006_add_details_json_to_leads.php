<?php

return "
ALTER TABLE study_leads 
ADD COLUMN details JSON NULL COMMENT 'Flexible storage for extra attributes like SAT, IELTS, University, etc.' AFTER language_level;
";
