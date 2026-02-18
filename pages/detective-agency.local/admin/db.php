<?php
// admin/db.php
declare(strict_types=1);

$DB_HOST = 'localhost';
$DB_NAME = 'adrasteia';
$DB_USER = 'root';
$DB_PASS = 'Kate 3645618abc';

$pdo = new PDO(
    "mysql:host={$DB_HOST};dbname={$DB_NAME};charset=utf8mb4",
    $DB_USER,
    $DB_PASS,
    [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]
);



