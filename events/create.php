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

$htmltitle = "出来事新規作成";

$user_id = getLoginUserId();
$user_name = getLoginUserName();

// バリデーションエラーリダイレクト時の値の表示
if ( isset($_SESSION['title']) ) {
  $title = $_SESSION['title'];
  unset($_SESSION['title']);
}

if ( isset($_SESSION['content']) ) {
  $content = $_SESSION['content'];
  unset($_SESSION['content']);
}

$database_handler = getDatabaseConnection();

include('../common/head.php');
// ロジックとビューの分離
include 'views/create_view.php';
?>
