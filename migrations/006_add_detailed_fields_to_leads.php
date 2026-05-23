<?php

return "
ALTER TABLE study_leads 
ADD COLUMN ielts_score FLOAT NULL AFTER language_level,
ADD COLUMN toefl_score INT NULL AFTER ielts_score,
ADD COLUMN desired_university VARCHAR(255) NULL AFTER budget,
ADD COLUMN desired_degree VARCHAR(50) NULL AFTER desired_university,
ADD COLUMN program_of_interest VARCHAR(255) NULL AFTER desired_degree;
";
