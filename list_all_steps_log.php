<?php
$logPath = 'C:\\Users\\xenium\\.gemini\\antigravity-ide\\brain\\8aba9f75-ee51-4650-8346-d9698f08ef7e\\.system_generated\\logs\\transcript.jsonl';
if (!file_exists($logPath)) {
    die("Log file not found.\n");
}

$lines = file($logPath);
foreach ($lines as $i => $line) {
    $data = json_decode($line, true);
    if ($data && ($data['type'] ?? '') === 'USER_INPUT') {
        echo "Line $i | step_index: " . ($data['step_index'] ?? '') . " | content length: " . strlen($data['content'] ?? '') . " | starts with: " . substr($data['content'] ?? '', 0, 100) . "\n";
    }
}
