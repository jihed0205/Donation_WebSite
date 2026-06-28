<?php
session_start();
require 'db_config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['user_id'])) {
    $stmt = $pdo->prepare("INSERT INTO job_offers (user_id, job_title, company, location, description, status) VALUES (?, ?, ?, ?, ?, 'pending')");
    $stmt->execute([
        $_SESSION['user_id'],
        $_POST['job_title'],
        $_POST['company'],
        $_POST['location'],
        $_POST['description']
    ]);
    header("Location: dashboard.php?success=job_posted");
    exit();
}
?>
