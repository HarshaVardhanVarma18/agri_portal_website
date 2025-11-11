<?php
// Start session
session_start();

// Connect to MySQL database
try {
    $pdo = new PDO("mysql:host=localhost;dbname=agri_portal;charset=utf8", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database Connection Failed: " . $e->getMessage());
}

// Simple function to escape HTML
function e($value) {
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}
?>
