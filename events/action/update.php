<?php
session_start();

require '../../common/database.php';
require '../../common/auth.php';

// ログインしていないならログイン画面へ
if ( !isLogin() ) {
	header('Location: ../../login/');
}

$user_id = getLoginUserId();
$user_name = getLoginUserName();
$event_id = $_POST['event_id'];

$edit_title = $_POST['title'];
$edit_content = $_POST['content'];
var_dump($_POST, $edit_content);

$database_handler = getDatabaseConnection();

// トランザクション開始
$database_handler->beginTransaction();
try {
    $stmt = $database_handler->prepare("UPDATE events SET title = :title, content = :content, updated_at = NOW() WHERE id = :event_id AND user_id = :user_id");
    
    // プリペアードステートメントを使うとサニタイズ処理は不要となる
    $stmt->bindParam(':title', $edit_title);
    $stmt->bindParam(':content', $edit_content);
    $stmt->bindParam(':event_id', $event_id);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();

    // コミット
    $res = $database_handler->commit();

} catch(Exception $e) {
    // エラーが起きたらロールバック
    $database_handler->rollBack();
    echo $e->getMessage();
    exit;
}

if ( $res ) {
    $succes_message = '更新成功';
} else {
    $error_message = '更新失敗';
}
// プリペアードステートメントを削除
$stmt = null;

// データベースの接続を閉じる
$database_handler = null;

header('Location: ../../events');
exit;
?>