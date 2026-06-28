<?php
session_start();
require 'db_config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $type = $_POST['account_type']; // 'user', 'association', or 'admin'

    try {
        // 1. Determine which table to check
        if ($type === 'admin') {
            $table = 'admins';
        } elseif ($type === 'association') {
            $table = 'associations';
        } else {
            $table = 'users';
        }
        
        // 2. Fetch the user
        $sql = "SELECT * FROM $table WHERE email = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        // 3. Verify Password
        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $type;
            
            // Handle display names based on table columns
            if ($type === 'admin') {
                // Admins usually have a 'username' or just 'Admin'
                $_SESSION['display_name'] = $user['username'] ?? "Administrator"; 
            } elseif ($type === 'association') {
                // Associations use 'assoc_name'
                $_SESSION['display_name'] = $user['assoc_name'];
            } else {
                // Regular users use first and last name
                $_SESSION['display_name'] = $user['first_name'] . " " . $user['last_name'];
            }

            // 4. Multi-Level Redirect
            switch($type) {
                case 'admin':
                    header("Location: admin_panel.php");
                    break;
                case 'association':
                    header("Location: association_dashboard.php");
                    break;
                case 'user':
                default:
                    header("Location: dashboard.php");
                    break;
            }
            exit();
            
        } else {
            // Wrong password or email
            header("Location: login.html?error=1");
            exit();
        }

    } catch (PDOException $e) {
        // This will tell you if the table name is wrong or a column is missing
        die("Database Error: " . $e->getMessage());
    }
}