<?php
try {
    $pdo = new PDO('mysql:host=127.0.0.1;port=3306', 'root', '', [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_TIMEOUT => 5
    ]);
    echo "Dropping database...\n";
    $pdo->exec('DROP DATABASE IF EXISTS starthree123');
    echo "Creating database...\n";
    $pdo->exec('CREATE DATABASE starthree123');
    echo "Database recreated successfully!\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
