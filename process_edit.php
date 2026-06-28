<?php
session_start();
require 'db_config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['user_id'])) {
    
    $item_id = $_POST['item_id'];
    $user_id = $_SESSION['user_id'];
    
    $item_name = trim($_POST['item_name']);
    $category = $_POST['category'];
    $quantity = trim($_POST['quantity']);
    $item_condition = $_POST['item_condition'];
    $description = trim($_POST['description']);
    $contact_phone = trim($_POST['contact_phone']);

    try {
        $sql = "UPDATE items SET 
                item_name = ?, 
                category = ?, 
                quantity = ?, 
                item_condition = ?, 
                description = ?, 
                contact_phone = ? 
                WHERE id = ? AND user_id = ? AND status = 'pending'";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$item_name, $category, $quantity, $item_condition, $description, $contact_phone, $item_id, $user_id]);

        header("Location: dashboard.php?update=success");
        exit();
    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }
}