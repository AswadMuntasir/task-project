<?php

$dbHost = 'localhost';
$dbName = 'task_project';
$dbUser = 'root';
$dbPassword = '';

// Other database configuration options, if needed
$dbCharset = 'utf8';

// Create a PDO (PHP Data Objects) database connection
try {
    $pdo = new PDO("mysql:host=$dbHost;dbname=$dbName;charset=$dbCharset", $dbUser, $dbPassword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Handle database connection error
    die("Database Connection Error: " . $e->getMessage());
}