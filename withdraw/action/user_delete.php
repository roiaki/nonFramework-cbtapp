<?php
session_start();
require '../../common/database.php';

$user_email = $_SESSION['user']['email'];
var_dump($_SESSION['user']['email']);
var_dump($_SESSION);

// 退会処理
$database_handler = getDatabaseConnection();

$stmt = $database_handler->prepare('DELETE FROM users WHERE email = :user_email');
$stmt->bindParam(':user_email', $user_email);
$stmt->execute();

session_destroy();

header('Location: ../../login/');
exit;