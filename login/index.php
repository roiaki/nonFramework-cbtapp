<?php
session_start();

require '../common/auth.php'; 

// ログインしていたらevent/index.php へリダイレクト
if ( isLogin() ) {
  header('Location: ../events');
  exit;
}

$htmltitle = 'ログイン';
$description ='';

// バリデーションエラーリダイレクトだったら前回入力した値を表示する
if ( isset($_SESSION['user_email']) ) {
  $user_email = $_SESSION['user_email'];
  unset( $_SESSION['user_email'] );
}

if ( isset($_SESSION['user_password']) ) {
  $user_password = $_SESSION['user_password'];
  unset( $_SESSION['user_password'] );
}

include('../common/head.php');

// ロジックとビューの分離
include 'views/index_view.php';

?>

