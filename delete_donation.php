<?php
session_start();
require 'db_config.php';

if (isset($_GET['id']) && isset($_SESSION['user_id'])) {
    $item_id = $_GET['id'];
    $user_id = $_SESSION['user_id'];

    try {
        // Crucial: We verify the user owns it AND it's pending so they can't delete approved stuff via URL manipulation
        $sql = "DELETE FROM items WHERE id = ? AND user_id = ? AND status = 'pending'";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$item_id, $user_id]);

        header("Location: dashboard.php?deleted=1");
    } catch (PDOException $e) {
        die("Erreur de suppression");
    }
} else {
    header("Location: dashboard.php");
}
exit();