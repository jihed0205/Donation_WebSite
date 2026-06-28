<?php
session_start();
require 'db_config.php';

// Only admins can trigger this script
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    die("Unauthorized");
}

$id = $_GET['id'] ?? 0;
$action = $_GET['action'] ?? '';

if ($id && ($action === 'approved' || $action === 'refused')) {
    try {
        $sql = "UPDATE items SET status = ? WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$action, $id]);
        
        header("Location: admin_panel.php?status=updated");
        exit();
    } catch (PDOException $e) {
        die("Error updating status");
    }
}