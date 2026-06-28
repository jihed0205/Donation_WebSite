<?php
require 'db_config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 1. Check exactly what was sent from the radio buttons/select
    // Make sure your signup.html has <select name="account_type"> or <input type="radio" name="account_type">
    $type = $_POST['account_type']; 

    // Common fields
    $email    = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $phone    = trim($_POST['phone']);
    $city     = trim($_POST['city']);
    $address  = trim($_POST['address']);

    try {
        // 2. The Logic Switch
        if ($type === 'association') {
            // DATA FOR ASSOCIATIONS TABLE
            $assoc_name = trim($_POST['assoc_name']);
            $reg_number = trim($_POST['reg_number']);
            $first_name = trim($_POST['first_name']);
            $last_name  = trim($_POST['last_name']);

            $sql = "INSERT INTO associations (assoc_name, reg_number, first_name, last_name, email, password, phone, city, address) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$assoc_name, $reg_number, $first_name, $last_name, $email, $password, $phone, $city, $address]);

        } else {
            // DATA FOR USERS TABLE (Regular Donors)
            $first_name = trim($_POST['first_name']);
            $last_name  = trim($_POST['last_name']);

            $sql = "INSERT INTO users (first_name, last_name, email, password, phone, city, address) 
                    VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$first_name, $last_name, $email, $password, $phone, $city, $address]);
        }

        header("Location: login.html?signup=success");
        exit();

    } catch (PDOException $e) {
        die("Signup Error: " . $e->getMessage());
    }
}