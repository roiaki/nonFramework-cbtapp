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
$sevencolumn_id = $_GET['sevencolumn_id'];

var_dump($sevencolumn_id);
var_dump($user_id);
//exit;
$database_handler = getDatabaseConnection();

// トランザクション開始 biginTransactionを書く位置は適切か？
$database_handler->beginTransaction();
try {
    $stmt = $database_handler
        ->prepare(
            "DELETE 
            FROM 
              sevencolumns 
            WHERE 
              id = :sevencolumn_id"
        );
    //var_dump($stmt);
    // プリペアードステートメントを使うとサニタイズ処理は不要となる   
    $stmt->bindParam(':sevencolumn_id', $sevencolumn_id);
    
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
    $succes_message = '削除成功';
} else {
    $error_message = '削除失敗';
}
// プリペアードステートメントを削除
$stmt = null;

// データベースの接続を閉じる
$database_handler = null;

header('Location: ../sevencolumns');
exit;
?>

