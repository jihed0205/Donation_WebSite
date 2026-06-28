<?php
require 'db_config.php';

// Change these to whatever you want your admin login to be
$email = 'admin@hand2hand.tn'; 
$password = 'admin123';

$hashed_password = password_hash($password, PASSWORD_BCRYPT);

try {
    $sql = "INSERT INTO admins (email, password) VALUES (?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$email, $hashed_password]);
    echo "<h2>Success!</h2> Admin account created for: " . $email;
} catch (PDOException $e) {
    echo "<h2>Error:</h2> " . $e->getMessage();
}
?>