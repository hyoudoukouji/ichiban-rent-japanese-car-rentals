<?php
$dbPath = __DIR__ . '/../database/ichiban.db';
$dbDir = dirname($dbPath);

// Create database directory if it doesn't exist
if (!file_exists($dbDir)) {
    mkdir($dbDir, 0777, true);
}

try {
    $db = new SQLite3($dbPath);
    $db->enableExceptions(true);
} catch(Exception $e) {
    echo "Connection failed: " . $e->getMessage();
    die();
}
