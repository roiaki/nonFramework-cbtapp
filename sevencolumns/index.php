<?php
session_start();

require '../common/database.php';
require '../common/auth.php';

// ログインしていなかったらログイン画面へリダイレクト
if ( !isLogin() ) {
  header('Location: ../login/');
  exit;
}

$htmltitle = 'CBT APP';
$description = '';

include('../common/head.php');

$user_id = getLoginUserId();
$user_name = getLoginUserName();

//var_dump($user_id, $user_name);

$database_handler = getDatabaseConnection();
$stmt = $database_handler->prepare("SELECT * FROM sevencolumns WHERE user_id = :user_id ORDER BY updated_at DESC");
$stmt->bindParam(':user_id', $user_id);
$stmt->execute();

$sevencolumns = [];

while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
  array_push($sevencolumns, $result);
  //var_dump($result);
}
//var_dump($sevencolumns);

// ロジックとビューの分離
include 'views/index_view.php';

?>

