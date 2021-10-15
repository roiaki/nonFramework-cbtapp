<?php
session_start();

require '../../common/database.php';
require '../../common/auth.php';
require '../../common/validation.php';

// ログインしていないならログイン画面へ
if ( !isLogin() ) {
    header('Location: ../../login/');
}

$htmltitle = "";
$clean['title'] = htmlspecialchars( $_POST['title'], ENT_QUOTES, 'UTF-8');
$clean['content'] = htmlspecialchars( $_POST['content'], ENT_QUOTES, 'UTF-8');

// バリデーション　課題　共通化
if (emptyCheck($clean['title']) == "NG") {
    $_SESSION['error_title']['empty'] = "タイトル入力必須です";
}

if (emptyCheck($clean['content']) == "NG") {
    $_SESSION['error_content']['empty'] = "内容入力必須です";
}

// バリデーションエラーがあったら同じ画面へ
if ($_SESSION['error_title'] || $_SESSION['error_content']) { 
    header('Location: ../../events/create.php');
    exit;
}

$content = $_POST['content'];
$created_at = date("Y-m-d H:i:s");
$updated_at = date("Y-m-d H:i:s");
var_dump($created_at);
var_dump($_POST); 
//exit;

$user_id = getLoginUserId();
$user_name = getLoginUserName();


$database_handler = getDatabaseConnection();

// トランザクション開始
$database_handler->beginTransaction();

try {
    $stmt = $database_handler->prepare("INSERT INTO events (user_id, title, content, updated_at, created_at) VALUES(:user_id, :title, :content, :created_at, :updated_at)");
    $stmt->bindParam(":user_id", $user_id);
    $stmt->bindParam(":title", $clean['title']);
    $stmt->bindParam(":content", $clean['content']);
    $stmt->bindParam(":created_at", $created_at);
    $stmt->bindParam(":updated_at", $created_at);
    $stmt->execute();

    // コミット
    $res = $database_handler->commit();

} catch(Exception $e) {
    // エラーが起きたらロールバック
    $database_handler->rollBack();
}

if ( $res ) {
    $succes_message = '保存成功';
} else {
    $error_message['database'] = '保存に失敗しました';
}
//var_dump($res);
//var_dump($succes_message);
//exit;
// プリペアードステートメントを削除
$stmt = null;

// データベースの接続を閉じる
$database_handler = null;

header('Location: ../../events');
exit;
