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

//var_dump('GET', $_GET);
$sevencolumn_id = $_GET['sevencolumn_id'];

//var_dump($threecol_id);
/*
var_dump(
    "event_id = " . $event_id,
    "get['event_id'] = " . $_GET['event_id'],
    "user_id = " . $user_id,
    'user_name = ' . $user_name
);
*/



try {
  $database_handler = getDatabaseConnection();
  $stmt = $database_handler
    ->prepare(
      "SELECT * FROM 
        sevencolumns
      WHERE 
        user_id = :user_id 
      AND 
        id = :sevencolumn_id 
      ORDER BY updated_at DESC"
    );

  $stmt->bindParam(':user_id', $user_id);
  $stmt->bindParam(':sevencolumn_id', $sevencolumn_id);

  $stmt->execute();

  $sevencolumn = [];

  while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $sevencolumn = $result;
  }
var_dump($sevencolumn);
  $stmt = $database_handler
      ->prepare(
          "SELECT 
            habit_id, 
            habit_name 
          FROM 
            habits 
          JOIN 
            habit_threecolumn 
          ON 
            habits.id = habit_threecolumn.habit_id 
          WHERE 
            habit_threecolumn.threecol_id = :threecolumn_id"
      );

  $stmt->bindParam(':threecolumn_id', $sevencolumn['threecol_id']);

  $stmt->execute();

  $names = [];

  while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
      array_push($names, $result);
  }
//var_dump($names);

} catch (Exception $e) {
    // エラーが起きたらロールバック
    //$database_handler->rollBack();

    echo $e->getMessage();
    exit;
}

$htmltitle = '詳細ページ';
$description = '';
include('../common/head.php');

// ロジックとビューの分離
include 'views/show_view.php';

?>
