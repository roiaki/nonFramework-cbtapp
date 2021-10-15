<?php
session_start();

require '../common/database.php';
require '../common/auth.php';
//var_dump($_SESSION);
//exit();

// ログインしてないならログイン画面へ
if (!isLogin()) {
  header('Location: ../login/');
  exit;
}



$user_id = getLoginUserId();
$user_name = getLoginUserName();

if ( isset($_GET['event_id']) ) {
  $event_id = $_GET['event_id'];
}

var_dump("SESSION");
var_dump($_SESSION);

$database_handler = getDatabaseConnection();
$stmt = $database_handler->prepare("SELECT * FROM events WHERE id = :event_id");
$stmt->bindParam(':event_id', $event_id);
$stmt->execute();

$event = [];

while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
  $event = $result;
}
//var_dump("session_event_id". $_SESSION['event_id']);

// バリデーションエラーリダイレクト時の値の受け渡し
if ( isset($_SESSION['event_id']) ) {
  $event['id'] = $_SESSION['event_id'];
  unset($_SESSION['event_id']);
}

if ( isset($_SESSION['title']) ) {
  $event['title'] = $_SESSION['title'];
  unset($_SESSION['title']);
}

if ( isset($_SESSION['content']) ) {
  $event['content'] = $_SESSION['content'];
  unset($_SESSION['content']);
}

$htmltitle = "出来事編集";
$description = "";
include('../common/head.php');

// ロジックとビューの分離
include 'views/edit_view.php';
?>

