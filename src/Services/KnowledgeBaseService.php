<?php

namespace App\Services;

class KnowledgeBaseService
{
    private string $filePath;

    public function __construct() {
        $this->filePath = dirname(__DIR__, 2) . '/tz_ai_bot_light.txt';
    }

    public function getContext(): string {
        if (!file_exists($this->filePath)) {
            return "";
        }

        $content = file_get_contents($this->filePath);

        if ($content === false) {
            return "";
        }

        return $content;
    }
}
