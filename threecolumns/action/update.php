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

$threecol_id = $_POST['threecol_id'];

$edit_title = $_POST['title'];
$edit_content = $_POST['content'];
$edit_emotion_name = $_POST['emotion_name'];
$edit_emotion_strength = $_POST['emotion_strength'];
$edit_thinking = $_POST['thinking'];

$edit_title = $_POST['title'];
var_dump($_POST, $edit_content);
//exit;

$database_handler = getDatabaseConnection();

// トランザクション開始
$database_handler->beginTransaction();
try {
    $sql = $database_handler
        ->prepare(
            "UPDATE 
              threecolumns
            SET 
              title = :title, 
              content = :content, 
              emotion_name = :emotion_name,
              emotion_strength = :emotion_strength,
              thinking = :thinking,
              updated_at = NOW() 
            WHERE 
              id = :threecol_id 
            AND 
              user_id = :user_id"
        );
    
    // プリペアードステートメントを使うとサニタイズ処理は不要となる
    $sql->bindParam(':title', $edit_title);
    $sql->bindParam(':content', $edit_content);
    $sql->bindParam(':emotion_name', $edit_emotion_name);
    $sql->bindParam(':emotion_strength', $edit_emotion_strength);
    $sql->bindParam(':thinking', $edit_thinking);

    $sql->bindParam(':threecol_id', $threecol_id);
    $sql->bindParam(':user_id', $user_id);

    $sql->execute();

    // 中間テーブル更新
    $sql2 = $database_handler
        ->prepare(
            "UPDATE
              habit_threecolumn
            SET
              "
        );

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
$sql = null;

// データベースの接続を閉じる
$database_handler = null;

header('Location: ../../threecolumns');
exit;
?>