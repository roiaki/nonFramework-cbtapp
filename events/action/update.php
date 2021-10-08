<?php
session_start();

require '../../common/database.php';
require '../../common/auth.php';
//var_dump($_SESSION);
//exit();

if (!isLogin()) {
	header('Location: ../../login/');
}

$user_id = getLoginUserId();
$user_name = getLoginUserName();
$event_id = $_POST['event_id'];

$edit_title = $_POST['title'];
$edit_content = $_POST['content'];
var_dump($_POST, $edit_content);

var_dump($event_id);
var_dump($user_id);
//exit;
$database_handler = getDatabaseConnection();

// トランザクション開始
$database_handler->beginTransaction();
try {
    $sql = $database_handler->prepare("UPDATE events SET title = :title, content = :content, updated_at = NOW() WHERE id = :event_id AND user_id = :user_id");
    //var_dump($sql);
    // プリペアードステートメントを使うとサニタイズ処理は不要となる
    $sql->bindParam(':title', $edit_title);
    $sql->bindParam(':content', $edit_content);
    $sql->bindParam(':event_id', $event_id);
    $sql->bindParam(':user_id', $user_id);
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
    $succes_message = '更新成功';
} else {
    $error_message = '更新失敗';
}
// プリペアードステートメントを削除
$sql = null;

// データベースの接続を閉じる
$database_handler = null;

header('Location: ../../events');
exit;
?>