<?php

return "
ALTER TABLE study_users 
ADD COLUMN IF NOT EXISTS admin_notes TEXT;
";
