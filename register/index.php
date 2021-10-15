<?php
session_start();

require '../common/auth.php';

// ログインしていたらevents/index.phpへリダイレクト
if (isLogin()) {
  header('Location: ../events');
  exit;
}

// バリデーションエラーリダイレクトだったら前回入力した値を表示する
if ( isset($_SESSION['user_name']) ) {
  $user_name = $_SESSION['user_name'];
  unset( $_SESSION['user_name'] );
}

if ( isset($_SESSION['user_email']) ) {
  $user_email = $_SESSION['user_email'];
  unset( $_SESSION['user_email'] );
}

if ( isset($_SESSION['user_password']) ) {
  $user_password = $_SESSION['user_password'];
  unset( $_SESSION['user_password'] );
}

$htmltitle = '会員登録';
$description = '';

include('../common/head.php');

// ロジックとビューの分離
include 'views/index_view.php';

?>
