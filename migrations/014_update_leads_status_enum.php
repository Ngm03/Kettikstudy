<?php

return "ALTER TABLE study_leads MODIFY COLUMN status ENUM('new', 'hot', 'cold', 'converted', 'urgent', 'processing') DEFAULT 'new';";
