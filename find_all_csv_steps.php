<?php
$logPath = 'C:\\Users\\xenium\\.gemini\\antigravity-ide\\brain\\8aba9f75-ee51-4650-8346-d9698f08ef7e\\.system_generated\\logs\\transcript.jsonl';
if (!file_exists($logPath)) {
    die("Log file not found.\n");
}

$lines = file($logPath);
echo "Total log lines: " . count($lines) . "\n";
foreach ($lines as $i => $line) {
    $data = json_decode($line, true);
    if ($data) {
        $content = $data['content'] ?? '';
        if (strpos($content, 'DENGUE IGG/IGM DEVICE') !== false) {
            echo "Step index: " . ($data['step_index'] ?? '') . " | Type: " . ($data['type'] ?? '') . " | Source: " . ($data['source'] ?? '') . " | Length: " . strlen($content) . "\n";
            // Check if it contains truncated
            if (strpos($content, 'truncated') !== false) {
                echo "  -> Contains 'truncated'\n";
            } else {
                echo "  -> SUCCESS: NO 'truncated'!\n";
            }
        }
    }
}
