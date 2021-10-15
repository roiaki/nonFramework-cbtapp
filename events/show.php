<?php
session_start();

require '../common/database.php';
require '../common/auth.php';

// ログインしてないならログイン画面へ
if (!isLogin()) {
    header('Location: ../login/');
    exit;
}

$user_id = getLoginUserId();
$user_name = getLoginUserName();

$event_id = $_GET['event_id'];
/*
var_dump(
    "event_id = " . $event_id,
    "get['event_id'] = " . $_GET['event_id'],
    "user_id = " . $user_id,
    'user_name = ' . $user_name
);
*/

$database_handler = getDatabaseConnection();
$stmt = $database_handler->prepare("SELECT * FROM events WHERE user_id = :user_id AND id = :event_id ORDER BY updated_at DESC");

$stmt->bindParam(':user_id', $user_id);
$stmt->bindParam(':event_id', $event_id);

$stmt->execute();

$events = [];

while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
  array_push($events, $result);
}

$htmltitle = '詳細ページ';
$description = '';
include('../common/head.php');

// ロジックとビューの分離
include 'views/show_view.php'
?>

