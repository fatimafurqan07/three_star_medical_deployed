<?php
$logPath = 'C:\\Users\\xenium\\.gemini\\antigravity-ide\\brain\\8aba9f75-ee51-4650-8346-d9698f08ef7e\\.system_generated\\logs\\transcript.jsonl';
if (!file_exists($logPath)) {
    die("Log file not found.\n");
}

$lines = file($logPath);
$userSteps = [];
foreach ($lines as $line) {
    $data = json_decode($line, true);
    if ($data && ($data['type'] ?? '') === 'USER_INPUT') {
        $userSteps[] = $data;
    }
}

if (count($userSteps) > 0) {
    $lastStep = end($userSteps);
    echo "LAST USER INPUT STEP INDEX: " . ($lastStep['step_index'] ?? '') . "\n";
    echo "Content length: " . strlen($lastStep['content']) . "\n";
    // Check if the word "truncated" is present in the raw content
    if (strpos($lastStep['content'], 'truncated') !== false) {
        echo "Warning: The text contains the word 'truncated'\n";
    } else {
        echo "SUCCESS: The text is NOT truncated in the log!\n";
    }
    
    // Save to a file to verify
    file_put_contents('c:\\xampp-new-latest\\htdocs\\threestar-old\\pasted_raw_products.txt', $lastStep['content']);
}
