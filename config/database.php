<?php
// config/database.php

$host = 'localhost';         // Your DB host
$db_name = 'adey_tours';     // Your DB name
$username = 'root';  // Your DB username
$password = '';  // Your DB password

$dsn = "mysql:host=$host;dbname=$db_name;charset=utf8mb4";

$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,          // Throw exceptions on errors
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,     // Fetch assoc arrays by default
    PDO::ATTR_EMULATE_PREPARES => false,                  // Use real prepared statements
];

try {
    $pdo = new PDO($dsn, $username, $password, $options);
} catch (PDOException $e) {
    // Stop script and show error message
    die("Database connection failed: " . $e->getMessage());
}
