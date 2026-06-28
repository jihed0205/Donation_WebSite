<?php
$host = 'sql203.infinityfree.com';
$db   = 'if0_42288826_hand2hand';
$user = 'if0_42288826';
$pass = '12345Jihed';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>
