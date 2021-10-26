<?php
session_start();

require '../../common/database.php';
require '../../common/auth.php';
require '../../common/validation.php';

// ログインしていないならログイン画面へ
if (!isLogin()) {
    header('Location: ../../login/');
}

$htmltitle = "";

/*
// バリデーション　課題　共通化
if (emptyCheck($clean['title']) == "NG") {
    $_SESSION['error_title']['empty'] = "タイトル入力必須です";
}

if (emptyCheck($clean['content']) == "NG") {
    $_SESSION['error_content']['empty'] = "内容入力必須です";
}
*/
// バリデーションエラーがあったら同じ画面へ
/*
if ($_SESSION['error_title'] || $_SESSION['error_content']) { 
    header('Location: ../../threecolumns/create.php');
    exit;
}
*/
/*
if ( empty($_POST['title']) ) {
    $_SESSION['error_message'] = "タイトルを入力してください";
    var_dump($_POST);
    var_dump($_SESSION);
    //exit;
    header('Location: ../../events/create.php');
    exit;
} else {
    $clean['title'] = htmlspecialchars( $_POST['title'], ENT_QUOTES, 'UTF-8' );
    header('Location: ../../events/create.php');
}
*/
/*
if ( empty($_POST['content']) ) {
    $_SESSION['error_message'] = "内容を入力してください";
    header('Location: ../../events/create.php');
    exit;

} else {
    $clean['content'] = htmlspecialchars( $_POST['content'], ENT_QUOTES, 'UTF-8');
}
*/
$sevencolumn_id = $_POST['sevencolumn_id'];
$threecolumn_id = $_POST['threecolumn_id'];
//var_dump($sevencolumn_id);
$user_id = getLoginUserId();
$event_id = $_POST['event_id'];
//var_dump($_POST);
//exit;
// htmlspecialchars 特殊文字をエンティティに変換する　ENT_QUOTES：シングルクオートとダブルクオートを共に変換します。
$clean['title'] = htmlspecialchars($_POST['title'], ENT_QUOTES, 'UTF-8');
$clean['content'] = htmlspecialchars($_POST['content'], ENT_QUOTES, 'UTF-8');
$clean['emotion_name'] = htmlspecialchars($_POST['emotion_name'], ENT_QUOTES, 'UTF-8');
$emotion_strength = $_POST['emotion_strength'];
$clean['thinking'] = htmlspecialchars($_POST['thinking'], ENT_QUOTES, 'UTF-8');
$clean['basis_thinking'] = htmlspecialchars($_POST['basis_thinking'], ENT_QUOTES, 'UTF-8');
$clean['opposite_fact'] = htmlspecialchars($_POST['opposite_fact'], ENT_QUOTES, 'UTF-8');
$clean['new_thinking'] = htmlspecialchars($_POST['new_thinking'], ENT_QUOTES, 'UTF-8');
$clean['new_emotion'] = htmlspecialchars($_POST['new_emotion'], ENT_QUOTES, 'UTF-8');

$created_at = date("Y-m-d H:i:s");
$updated_at = date("Y-m-d H:i:s");

//var_dump($clean);

$database_handler = getDatabaseConnection();

// トランザクション開始
$database_handler->beginTransaction();

try {
    $stmt = $database_handler->prepare(
        "UPDATE sevencolumns 
        SET 
          user_id = :user_id, 
          event_id = :event_id,
          threecol_id = :threecolumn_id,
          title = :title, 
          content = :content, 
          emotion_name = :emotion_name,
          emotion_strength = :emotion_strength, 
          thinking = :thinking,
          basis_thinking = :basis_thinking,
          opposite_fact = :opposite_fact,
          new_thinking = :new_thinking,
          new_emotion = :new_emotion,
          created_at = NOW(), 
          updated_at = NOW() 
        WHERE
          id = :sevencolumn_id 
        AND 
          user_id = :user_id"
    );
  
    $stmt->bindParam(":user_id", $user_id);
    $stmt->bindParam(":event_id", $event_id);
    $stmt->bindParam(":threecolumn_id", $threecolumn_id);
    $stmt->bindParam(":title", $clean['title']);
    $stmt->bindParam(":content", $clean['content']);
    $stmt->bindParam(":emotion_name", $clean['emotion_name']);
    $stmt->bindParam(":emotion_strength", $emotion_strength);
    $stmt->bindParam(":thinking", $clean['thinking']);
    $stmt->bindParam(":basis_thinking", $clean['basis_thinking']);
    $stmt->bindParam(":opposite_fact", $clean['opposite_fact']);
    $stmt->bindParam(":new_thinking", $clean['new_thinking']);
    $stmt->bindParam(":new_emotion", $clean['new_emotion']);

    $stmt->bindParam(":sevencolumn_id", $sevencolumn_id);
    

    $stmt->execute();

    // コミット
    $res = $database_handler->commit();

} catch (Exception $e) {
    // エラーが起きたらロールバック
    $database_handler->rollBack();

    echo $e->getMessage();
    exit;
}

if ($res) {
    $succes_message = '保存成功';
} else {
    $error_message['database'] = '保存に失敗しました';
}

// プリペアードステートメントを削除
$stmt = null;
$stmt2 = null;

// データベースの接続を閉じる
$database_handler = null;

header('Location: ../../sevencolumns');
exit;
