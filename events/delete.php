<?php
session_start();

require '../common/database.php';
require '../common/auth.php';

//var_dump($_SESSION);
//exit();

// ログインしてないならログイン画面へ
if ( !isLogin() ) {
	header('Location: ../../login/');
    exit;
}

$user_id = getLoginUserId();
$user_name = getLoginUserName();
$event_id = $_GET['event_id'];

var_dump($event_id);
var_dump($user_id);
//exit;
$database_handler = getDatabaseConnection();

// トランザクション開始
$database_handler->beginTransaction();
try {
    $sql = $database_handler->prepare("DELETE FROM events WHERE id = :event_id");
    //var_dump($sql);
    // プリペアードステートメントを使うとサニタイズ処理は不要となる   
    $sql->bindParam(':event_id', $event_id);
    //$sql->bindParam(':user_id', $user_id);
    $sql->execute();

    // コミット
    $res = $database_handler->commit();
    //var_dump($res);
    //exit;
} catch(Exception $e) {
    echo $e->getMessage();
    exit;
    // エラーが起きたらロールバック
    $database_handler->rollBack();
}

if ( $res ) {
    $succes_message = '削除成功';
} else {
    $error_message = '削除失敗';
}
// プリペアードステートメントを削除
$sql = null;

// データベースの接続を閉じる
$database_handler = null;

header('Location: ../events');
exit;
?>

