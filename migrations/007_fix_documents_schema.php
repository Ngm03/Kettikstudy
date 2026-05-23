<?php

return "
ALTER TABLE study_documents 
ADD COLUMN IF NOT EXISTS comment TEXT AFTER status;
";
