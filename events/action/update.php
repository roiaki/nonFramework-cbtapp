<?php
session_start();

require '../../common/database.php';
require '../../common/auth.php';
require '../../common/validation.php';

// ログインしていないならログイン画面へ
if ( !isLogin() ) {
	header('Location: ../../login/');
}

$user_id = getLoginUserId();
$user_name = getLoginUserName();
$event_id = $_POST['event_id'];
var_dump($_POST);
//exit;
// サニタイズ処理
$clean['edit_title'] = htmlspecialchars( $_POST['title'], ENT_QUOTES, 'UTF-8');
$clean['edit_content'] = htmlspecialchars( $_POST['content'], ENT_QUOTES, 'UTF-8');

$errorCount = 0;
// バリデーション処理
if (emptyCheck($clean['edit_title']) == "NG") {
    $_SESSION['error_title']['empty'] = "タイトル入力必須です";
    $errorCount += 1;
}

if (emptyCheck($clean['edit_content']) == "NG") {
    $_SESSION['error_content']['empty'] = "内容入力必須です";
    $errorCount += 1;
}

// バリデーションエラーがあったら同じ画面へ
if ($errorCount > 0) { 
    $_SESSION['event_id'] = $event_id;
    $_SESSION['title'] = $clean['edit_title'];
    $_SESSION['content'] = $clean['edit_content'];
    header('Location: ../../events/edit.php');
    exit;
}

var_dump($_POST, $edit_content);

$database_handler = getDatabaseConnection();

// トランザクション開始
$database_handler->beginTransaction();
try {
    $sql = "UPDATE 
              events 
            SET 
              title = :title, 
              content = :content, 
              updated_at = NOW() 
            WHERE 
              id = :event_id 
            AND 
              user_id = :user_id";

    $stmt = $database_handler->prepare($sql);
    
    // プリペアードステートメントを使うとサニタイズ処理は不要となる
    $stmt->bindParam(':title', $clean['edit_title']);
    $stmt->bindParam(':content', $clean['edit_content']);
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