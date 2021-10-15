<?php
session_start();

require '../common/database.php';
require '../common/auth.php';
//var_dump($_SESSION);
//exit();

// ログインしていないならログイン画面へ
if (!isLogin()) {
  header('Location: ../../login/');
}

$user_id = getLoginUserId();
$user_name = getLoginUserName();

$event_id = $_GET['event_id'];
var_dump($_GET);
//exit;
$database_handler = getDatabaseConnection();
$stmt = $database_handler->prepare("SELECT * FROM events WHERE user_id = :user_id AND id = :event_id");

$stmt->bindParam(':event_id', $event_id);
$stmt->bindParam(':user_id', $user_id);

$stmt->execute();

$event = $stmt->fetch(PDO::FETCH_ASSOC);
$event_title = $event['title'];
$event_content = $event['content'];

// 作成ボタンを押した段階でテーブルに一旦データを仮格納する
$stmt = $database_handler
    ->prepare(
      "INSERT INTO 
        threecolumns 
        (user_id, event_id, title, content) 
      VALUES 
        (:user_id, :event_id, :title, :content)"
    );
//var_dump($stmt);
$stmt->bindParam(':user_id', $user_id);
$stmt->bindParam(':event_id', $event_id);
$stmt->bindParam(':title', $event_title);
$stmt->bindParam(':content', $event_content);
//var_dump($stmt);

$stmt->execute();
//var_dump($stmt);
//exit;
$threecol_id = $database_handler->lastInsertId();

$htmltitle = "3コラム新規作成";
include('../common/head.php');

// ロジックとビューの分離
include 'views/create_view.php';
?>
