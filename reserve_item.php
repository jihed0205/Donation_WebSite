<?php
session_start();
require 'db_config.php';

if (isset($_GET['id']) && isset($_SESSION['user_id'])) {
    $item_id = $_GET['id'];
    $asso_id = $_SESSION['user_id'];

    try {
        // Only reserve if it's currently 'approved'
        $sql = "UPDATE items SET status = 'reserved', reserved_by = ? WHERE id = ? AND status = 'approved'";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$asso_id, $item_id]);

        header("Location: browse_donations.php?reserved=success");
        exit();
    } catch (PDOException $e) {
        die("Reservation failed.");
    }
}