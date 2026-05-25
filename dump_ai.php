<?php
$content = file_get_contents('src/Services/AiService.php');
file_put_contents('scratch/ai_dump.txt', substr($content, 0, 5000));
