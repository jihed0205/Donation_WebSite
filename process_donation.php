<?php
session_start();
require 'db_config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['user_id'])) {
    
    $user_id = $_SESSION['user_id'];
    $item_name = trim($_POST['item_name']);
    $category = $_POST['category'];
    $quantity = trim($_POST['quantity']);
    $item_condition = $_POST['item_condition'];
    $description = trim($_POST['description']);
    $contact_phone = trim($_POST['contact_phone']);
    
    // --- IMAGE UPLOAD LOGIC ---
    $image_name = time() . '_' . $_FILES['item_image']['name']; // Unique name
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($image_name);
    
    // Move the file from temp storage to your folder
    if (move_uploaded_file($_FILES['item_image']['tmp_name'], $target_file)) {
        // File uploaded successfully
    } else {
        $image_name = null; // Or handle error
    }

    try {
        $sql = "INSERT INTO items (user_id, item_name, category, quantity, item_condition, item_image, description, contact_phone, status) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'pending')";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$user_id, $item_name, $category, $quantity, $item_condition, $image_name, $description, $contact_phone]);

        header("Location: dashboard.php?donation=success");
        exit();

    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }
}