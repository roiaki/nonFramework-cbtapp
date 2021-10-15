<?php
session_start();

require '../common/database.php';
require '../common/auth.php';

// ログインしていなかったらログイン画面へリダイレクト
if (!isLogin()) {
  header('Location: ../login/');
  exit;
}

$user_id = getLoginUserId();
$user_name = getLoginUserName();

//var_dump($user_id, $user_name);

$database_handler = getDatabaseConnection();
$stmt = $database_handler->prepare("SELECT * FROM events WHERE user_id = :user_id ORDER BY updated_at DESC");
$stmt->bindParam(':user_id', $user_id);
$stmt->execute();

$events = [];

while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
  array_push($events, $result);
  //var_dump($result);
}

$htmltitle = 'CBT APP';
$description = '';
include '../common/head.php';

// ロジックとビューの分離
include 'views/index_view.php';
?>
