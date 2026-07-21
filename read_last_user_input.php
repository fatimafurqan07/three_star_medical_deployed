<?php
$logPath = 'C:\\Users\\xenium\\.gemini\\antigravity-ide\\brain\\8aba9f75-ee51-4650-8346-d9698f08ef7e\\.system_generated\\logs\\transcript.jsonl';
if (!file_exists($logPath)) {
    die("Log file not found.\n");
}

$lines = file($logPath);
$lastLine = end($lines);
$data = json_decode($lastLine, true);
if ($data) {
    echo "Last log line step: " . ($data['step_index'] ?? '') . " | type: " . ($data['type'] ?? '') . "\n";
    $content = $data['content'] ?? '';
    echo "Content length: " . strlen($content) . " bytes\n";
    if (strpos($content, 'truncated') !== false) {
        echo "Contains 'truncated'\n";
    } else {
        echo "SUCCESS: No 'truncated'!\n";
    }
    file_put_contents('c:\\xampp-new-latest\\htdocs\\threestar-old\\full_pasted_products.txt', $content);
    echo "Saved to full_pasted_products.txt\n";
} else {
    echo "Failed to decode last log line.\n";
}
