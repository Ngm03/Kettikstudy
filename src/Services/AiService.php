<?php

namespace App\Services;

class AiService
{
    private KnowledgeBaseService $knowledgeBaseService;
    private array $providers;

    public function __construct()
    {
        $this->knowledgeBaseService = new KnowledgeBaseService();

        $this->providers = [
            [
                'name' => 'Groq-1',
                'type' => 'groq',
                'url'  => 'https://api.groq.com/openai/v1/chat/completions',
                'key'  => $_ENV['GROQ_API_KEY_1'] ?? $_ENV['GROQ_API_KEY'] ?? '',
                'model'=> 'llama-3.3-70b-versatile',
                'json_mode' => true,
            ],
            [
                'name' => 'Groq-2',
                'type' => 'groq',
                'url'  => 'https://api.groq.com/openai/v1/chat/completions',
                'key'  => $_ENV['GROQ_API_KEY_2'] ?? '',
                'model'=> 'llama-3.3-70b-versatile',
                'json_mode' => true,
            ],
            [
                'name' => 'Gemini',
                'type' => 'gemini',
                'url'  => 'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent',
                'key'  => $_ENV['GEMINI_API_KEY'] ?? '',
                'model'=> 'gemini-2.0-flash',
                'json_mode' => true,
            ],
            [
                'name' => 'OpenRouter-Nemotron',
                'type' => 'groq',
                'url'  => 'https://openrouter.ai/api/v1/chat/completions',
                'key'  => $_ENV['OPENROUTER_API_KEY'] ?? '',
                'model'=> 'nvidia/nemotron-3-nano-30b-a3b:free',
                'json_mode' => true,
            ],
        ];
    }

    public function getResponse(array $messages, array $context = [], string $lang = 'ru'): array
    {
        $settings = (new \App\Models\Setting())->getAll();
        $botName = $settings['ai_bot_name'] ?? 'Абай';
        $companyName = $settings['site_title'] ?? 'Kettik Study';
        $kb = $this->knowledgeBaseService->getContext();

        $knownInfo = [];
        $contextStr = "";
        if (!empty($context)) {
            $contextStr = "\n[ИЗВЕСТНЫЕ ФАКТЫ - НЕ СПРАШИВАЙ ЭТО]:\n";

            if (!empty($context['name']) && stripos($context['name'], $botName) === false) {
                $contextStr .= "- Имя клиента: {$context['name']}\n";
                $knownInfo[] = 'ИМЯ';
            }
            if (!empty($context['details']['program_of_interest'])) {
                $contextStr .= "- Интерес: {$context['details']['program_of_interest']}\n";
                $knownInfo[] = 'ТИП ОБУЧЕНИЯ';
            } elseif (!empty($context['program_of_interest'])) {
                $contextStr .= "- Интерес: {$context['program_of_interest']}\n";
                $knownInfo[] = 'ТИП ОБУЧЕНИЯ';
            }
            if (!empty($context['language_level'])) {
                $contextStr .= "- Уровень языка: {$context['language_level']}\n";
                $knownInfo[] = 'ЯЗЫК';
            }
            if (!empty($context['budget'])) {
                $contextStr .= "- Бюджет: {$context['budget']}\n";
                $knownInfo[] = 'БЮДЖЕТ';
            }
        }
        $knownList = implode(', ', $knownInfo);

        if (!empty($context)) {
            if (!empty($context['details']['city'])) {
                $contextStr .= "- Город: {$context['details']['city']}\n";
                $knownInfo[] = 'ГОРОД';
            }
            if (!empty($context['details']['specialty'])) {
                $contextStr .= "- Специальность: {$context['details']['specialty']}\n";
                $knownInfo[] = 'СПЕЦИАЛЬНОСТЬ';
            }
        }
        $knownList = implode(', ', $knownInfo);

        $languageInstruction = ($lang === 'kk') ? 'КАЗАХСКОМ ЯЗЫКЕ (Қазақша)' : 'РУССКОМ ЯЗЫКЕ';

        $systemPrompt = <<<PROMPT
Ты — {$botName}, дружелюбный и энергичный консультант {$companyName}. ВАЖНО: ТЫ ОБЯЗАН ОТВЕЧАТЬ ТОЛЬКО НА {$languageInstruction}. 

ТВОЯ РОЛЬ И ЦЕЛЬ:
Ты — {$botName}, экспертный образовательный консультант в компании {$companyName} (роль Квалификатора/Диагноста). 
Твоя главная цель — быстро провести первичную диагностику: задать 1-2 важных вопроса, и как только они будут получены, запросить номер телефона для менеджера.

ПРАВИЛА ОБЩЕНИЯ И "POSITIVE DEFLECTION":
1. **Профессионализм и эмпатия**: Общайся как опытный эксперт. Будь вежливым и помогающим. 
2. **Диагност**: Если клиент спрашивает про поступление, не вываливай всю информацию сразу. Сначала задай 1-2 уточняющих вопроса. Приоритетные вопросы: "В какую страну планируете поступать?" и "Какой у вас средний балл (GPA)?".
3. **Консультация ПЕРЕД вопросом**: Если клиент задает вопрос, СНАЧАЛА дай развернутый ответ. Только ПОСЛЕ ответа задай свой вопрос для продвижения по воронке.
4. **Один вопрос за раз**: Никогда не задавай два вопроса в одном сообщении.
5. **Запрос телефона после Диагноза**: Как только ты собрал базовые данные (страна, балл или тип обучения), сразу скажи: "Отлично! У меня есть подборка университетов под ваши критерии. Чтобы я передал ваши данные личному менеджеру для расчета стоимости, напишите ваш номер телефона."

🚫 СТРОГИЕ ПРАВИЛА — НАРУШАТЬ ЗАПРЕЩЕНО:
- НИКОГДА не выдумывай названия городов, вузов, колледжей или специальностей, которых нет в БАЗЕ ЗНАНИЙ ниже.
- НИКОГДА не выдумывай цены. Если пользователь спрашивает про цены, стоимость или скидки, СТРОГО отвечай: "Точные расчеты может предоставить только живой менеджер. Пожалуйста, напишите ваш номер телефона, и мы пришлем вам расчет."
- Если клиент дал телефон, обязательно сохрани его в поле "phone". ИСПОЛЬЗУЙ ТОЛЬКО ИНФОРМАЦИЮ ИЗ БАЗЫ ЗНАНИЙ.

БАЗА ЗНАНИЙ {$companyName}:
{$kb}
КОНЕЦ БАЗЫ ЗНАНИЙ.

ТВОЕ СОСТОЯНИЕ (что мы уже узнали о клиенте):
[{$knownList}]
{$contextStr}

АЛГОРИТМ КОНСУЛЬТАЦИИ (Диагност):
1. СПРОСИ УТОЧНЯЮЩИЕ ДАННЫЕ (если их еще нет): В какую страну (Польша или другая) планируете и какой средний балл?
2. ТИП ОБУЧЕНИЯ: Колледж (бесплатно, после 9-11 класса) или ВУЗ.
3. ЗАПРОСИ ТЕЛЕФОН: Как только клиент ответил на вопросы из п.1, предложи передать данные менеджеру и попроси номер.
ИТОГ И ПЕРЕДАЧА МЕНЕДЖЕРУ:
Когда у клиента нет вопросов и мы узнали основное (Имя, Тип, Язык, Бюджет/Бесплатно, Специальность, Город) — подведи красивый итог в виде списка и поставь "ready_for_manager": true.

Пример финального сообщения:
"Спасибо за ответы, [Имя]! Вот предварительный расклад:
🎓 Выбрано: [Тип] / [Специальность]
📍 Город: [Город]
💰 Бюджет: [Бюджет]

Я передам эту информацию нашему старшему специалисту, он свяжется с вами в WhatsApp для детального подбора и оформления документов. Нажмите кнопку ниже!"

ФОРМАТ ОТВЕТА (СТРОГИЙ JSON):
{
  "reply": "Твой естественный, экспертный ответ с переносами строк (\n) СТРОГО на {$languageInstruction}.",
  "data": {
    "name": "Имя или null",
    "phone": "Телефон клиента или null",
    "program_of_interest": "ВУЗ или Колледж или null",
    "language_level": "Polish / English / Zero или null",
    "budget": "Сохраняй ТОЧНО как написал клиент (например: '1 млн тенге') или null",
    "specialty": "Специальность из базы или null",
    "city": "Город из базы или null",
    "ready_for_manager": false // ставь true ТОЛЬКО если собраны все данные ИЛИ клиент сам просит связать с менеджером
  }
}

ПРИМЕЧАНИЕ ПО DATA:
- В массиве "data" всегда возвращай ВСЕ накопленные значения. Если значение неизвестно, передавай null или пустую строку. Не стирай то, что уже известно (см. раздел ТВОЕ СОСТОЯНИЕ).
PROMPT;

        if (empty($messages) || $messages[0]['role'] !== 'system') {
            array_unshift($messages, ['role' => 'system', 'content' => $systemPrompt]);
        } else {
            $messages[0]['content'] = $systemPrompt;
        }

        if (count($messages) > 5) {
            $sysMsg = $messages[0];
            $recent = array_slice($messages, -4);
            $messages = array_merge([$sysMsg], $recent);
        }

        foreach ($this->providers as $provider) {
            $result = null;

            if ($provider['type'] === 'groq') {
                $result = $this->callGroq($provider, $messages);
            } elseif ($provider['type'] === 'gemini') {
                $result = $this->callGemini($provider, $messages);
            }

            if ($result !== null) {
                error_log("AI: SUCCESS via {$provider['name']}");
                return $result;
            }

            error_log("AI: FAIL {$provider['name']}, trying next...");
        }

        return [
            'reply' => "Извините, все серверы сейчас перегружены. Попробуйте через 5 минут.",
            'data'  => []
        ];
    }

    private function callGroq(array $provider, array $messages): ?array
    {
        $reqData = [
            'model'       => $provider['model'],
            'messages'    => $messages,
            'temperature' => 0.1,
        ];

        if (!empty($provider['json_mode'])) {
            $reqData['response_format'] = ['type' => 'json_object'];
        }

        $response = $this->httpPost($provider['url'], json_encode($reqData, JSON_UNESCAPED_UNICODE), [
            "Authorization: Bearer {$provider['key']}",
            "Content-Type: application/json",
        ]);

        if ($response === null) return null;

        $result = json_decode($response, true);

        if (isset($result['error'])) return null;

        $content = $result['choices'][0]['message']['content'] ?? '';

        if (empty($content) && !empty($result['choices'][0]['message']['reasoning'])) {
            $content = $result['choices'][0]['message']['reasoning'];
        }
        
        if (empty($content)) $content = '{}';
        return $this->parseJsonResponse($content);
    }

    private function callGemini(array $provider, array $messages): ?array
    {
        $systemText = '';
        $contents = [];

        foreach ($messages as $msg) {
            if ($msg['role'] === 'system') {
                $systemText = $msg['content'];
                continue;
            }
            $role = ($msg['role'] === 'assistant') ? 'model' : 'user';
            
            if (!empty($contents) && $contents[count($contents) - 1]['role'] === $role) {
                $contents[count($contents) - 1]['parts'][0]['text'] .= "\n" . $msg['content'];
            } else {
                $contents[] = [
                    'role'  => $role,
                    'parts' => [['text' => $msg['content']]],
                ];
            }
        }

        if (empty($contents) || $contents[0]['role'] !== 'user') {
            array_unshift($contents, [
                'role' => 'user',
                'parts' => [['text' => 'Привет']],
            ]);
        }

        if ($contents[count($contents) - 1]['role'] !== 'user') {
            $contents[] = [
                'role' => 'user',
                'parts' => [['text' => 'Продолжай']],
            ];
        }

        $reqData = [
            'contents'          => $contents,
            'systemInstruction' => ['parts' => [['text' => $systemText]]],
            'generationConfig'  => [
                'responseMimeType' => 'application/json',
                'temperature'      => 0.1,
            ],
        ];

        $url = $provider['url'] . '?key=' . $provider['key'];
        $response = $this->httpPost($url, json_encode($reqData, JSON_UNESCAPED_UNICODE), [
            "Content-Type: application/json",
        ]);

        if ($response === null) return null;

        $result = json_decode($response, true);

        if (isset($result['error'])) {
            error_log('GEMINI ERROR: ' . ($result['error']['message'] ?? 'unknown'));
            return null;
        }

        if (empty($result['candidates'])) {
            error_log('GEMINI: No candidates in response');
            return null;
        }

        $content = $result['candidates'][0]['content']['parts'][0]['text'] ?? '{}';
        return $this->parseJsonResponse($content);
    }

    private function parseJsonResponse(string $content): array
    {
        $original = $content;
        
        $content = preg_replace('/^```(?:json)?\s*/i', '', $content);
        $content = preg_replace('/\s*```\s*$/', '', $content);
        $content = trim($content);
        
        $parsed = json_decode($content, true);

        if (!$parsed || !isset($parsed['reply'])) {
            if (preg_match('/(\{(?:[^{}]|(?:\{(?:[^{}]|\{[^{}]*\})*\}))*"reply"\s*:(?:[^{}]|(?:\{(?:[^{}]|\{[^{}]*\})*\}))*\})/s', $content, $m)) {
                $parsed = json_decode($m[1], true);
            }
        }
        
        if (!$parsed || !isset($parsed['reply'])) {
            if (preg_match('/\{[^{}]*"reply"\s*:\s*"[^"]*"[^}]*\}/s', $content, $m)) {
                $parsed = json_decode($m[0], true);
            }
        }

        if (!$parsed || !isset($parsed['reply'])) {
            error_log('AI JSON PARSE FAIL: ' . json_last_error_msg());
        }

        if ($parsed && isset($parsed['reply'])) {
            return [
                'reply' => $parsed['reply'],
                'data'  => $parsed['data'] ?? [],
            ];
        }

        if (!empty($content) && $content !== '{}') {
            return ['reply' => $content, 'data' => []];
        }
        return ['reply' => "Повторите, пожалуйста.", 'data' => []];
    }

    private function httpPost(string $url, string $body, array $headers): ?string
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            error_log('AI CURL ERR: ' . curl_error($ch));
            curl_close($ch);
            return null;
        }

        curl_close($ch);
        return $response;
    }
}
