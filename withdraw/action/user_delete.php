<?php
session_start();
require '../../common/database.php';

$user_email = $_SESSION['user']['email'];
var_dump($_SESSION['user']['email']);
var_dump($_SESSION);

// 退会処理
$database_handler = getDatabaseConnection();

$sql = $database_handler->prepare('DELETE FROM users WHERE email = :user_email');
$sql->bindParam(':user_email', $user_email);
$sql->execute();

session_destroy();

header('Location: ../../login/');
exit;