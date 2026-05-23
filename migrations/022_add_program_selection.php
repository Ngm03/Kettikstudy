<?php

return "ALTER TABLE study_user_details 
    ADD COLUMN desired_country VARCHAR(100) NULL AFTER address_residential,
    ADD COLUMN desired_university_id INT NULL AFTER desired_country,
    ADD COLUMN desired_program VARCHAR(255) NULL AFTER desired_university_id";
