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
$threecol_id = $_POST['threecol_id'];

$user_id = getLoginUserId();
$event_id = $_POST['event_id'];

$clean['title'] = htmlspecialchars($_POST['title'], ENT_QUOTES, 'UTF-8');
$clean['content'] = htmlspecialchars($_POST['content'], ENT_QUOTES, 'UTF-8');
$clean['emotion_name'] = htmlspecialchars($_POST['emotion_name'], ENT_QUOTES, 'UTF-8');
$emotion_strenght = $_POST['emotion_strength'];
$clean['thinking'] = htmlspecialchars($_POST['thinking'], ENT_QUOTES, 'UTF-8');

$created_at = date("Y-m-d H:i:s");
$updated_at = date("Y-m-d H:i:s");

$database_handler = getDatabaseConnection();

// トランザクション開始
$database_handler->beginTransaction();

try {
    $stmt = $database_handler->prepare(
        "UPDATE threecolumns 
        SET 
          user_id = :user_id, 
          event_id = :event_id, 
          title = :title, 
          content = :content, 
          emotion_name = :emotion_name,
          emotion_strength = :emotion_strength, 
          thinking = :thinking, 
          created_at = NOW(), 
          updated_at = NOW() 
        WHERE
          id = :threecol_id 
        AND 
          user_id = :user_id"
    );

    $stmt->bindParam(":user_id", $user_id);
    $stmt->bindParam(":event_id", $event_id);
    $stmt->bindParam(":title", $clean['title']);
    $stmt->bindParam(":content", $clean['content']);
    $stmt->bindParam(":emotion_name", $clean['emotion_name']);
    $stmt->bindParam(":emotion_strength", $emotion_strenght);
    $stmt->bindParam(":thinking", $clean['thinking']);

    $stmt->bindParam(":threecol_id", $threecol_id);

    $stmt->execute();


    // 課題　冗長をなくす
    if (isset($_POST['habit'][0])) {
        $stmt2 = $database_handler->prepare(
            "INSERT INTO 
              habit_threecolumn 
              (threecol_id, habit_id, updated_at, created_at) 
            VALUES 
              (:threecol_id, :habit_id, :created_at, :updated_at)"
        );
        $habit_id = 1;
        $stmt2->bindParam(":habit_id", $habit_id);
        $stmt2->bindParam(":threecol_id", $threecol_id);
        $stmt2->bindParam(":created_at", $created_at);
        $stmt2->bindParam(":updated_at", $created_at);

        $stmt2->execute();
    }

    if (isset($_POST['habit'][1])) {
        $stmt2 = $database_handler->prepare(
            "INSERT INTO 
              habit_threecolumn 
              (threecol_id, habit_id, updated_at, created_at) 
            VALUES 
              (:threecol_id, :habit_id, :created_at, :updated_at)"
        );

        $habit_id = 2;
        $stmt2->bindParam(":habit_id", $habit_id);
        $stmt2->bindParam(":threecol_id", $threecol_id);
        $stmt2->bindParam(":created_at", $created_at);
        $stmt2->bindParam(":updated_at", $created_at);

        $stmt2->execute();
    }

    if (isset($_POST['habit'][2])) {
        $stmt2 = $database_handler->prepare(
            "INSERT INTO 
              habit_threecolumn 
              (threecol_id, habit_id, updated_at, created_at) 
            VALUES 
              (:threecol_id, :habit_id, :created_at, :updated_at)"
        );
        $habit_id = 3;
        $stmt2->bindParam(":habit_id", $habit_id);
        $stmt2->bindParam(":threecol_id", $threecol_id);
        $stmt2->bindParam(":created_at", $created_at);
        $stmt2->bindParam(":updated_at", $created_at);

        $stmt2->execute();
    }

    if (isset($_POST['habit'][3])) {

        $stmt2 = $database_handler->prepare(
            "INSERT INTO 
              habit_threecolumn 
              (threecol_id, habit_id, updated_at, created_at) 
            VALUES 
              (:threecol_id, :habit_id, :created_at, :updated_at)"
        );

        $habit_id = 4;
        $stmt2->bindParam(":habit_id", $habit_id);
        $stmt2->bindParam(":threecol_id", $threecol_id);
        $stmt2->bindParam(":created_at", $created_at);
        $stmt2->bindParam(":updated_at", $created_at);

        $stmt2->execute();
    }

    if (isset($_POST['habit'][4])) {
        $stmt2 = $database_handler->prepare(
            "INSERT INTO 
              habit_threecolumn 
              (threecol_id, habit_id, updated_at, created_at) 
            VALUES 
              (:threecol_id, :habit_id, :created_at, :updated_at)"
        );
        $habit_id = 5;
        $stmt2->bindParam(":habit_id", $habit_id);
        $stmt2->bindParam(":threecol_id", $threecol_id);
        $stmt2->bindParam(":created_at", $created_at);
        $stmt2->bindParam(":updated_at", $created_at);

        $stmt2->execute();
    }

    if (isset($_POST['habit'][5])) {
        $stmt2 = $database_handler->prepare(
            "INSERT INTO
              habit_threecolumn 
			  (threecol_id, habit_id, updated_at, created_at) 
            VALUES 
              (:threecol_id, :habit_id, :created_at, :updated_at)"
        );
        $habit_id = 6;
        $stmt2->bindParam(":habit_id", $habit_id);
        $stmt2->bindParam(":threecol_id", $threecol_id);
        $stmt2->bindParam(":created_at", $created_at);
        $stmt2->bindParam(":updated_at", $created_at);

        $stmt2->execute();
    }

    if (isset($_POST['habit'][6])) {
        $stmt2 = $database_handler->prepare(
            "INSERT INTO 
              habit_threecolumn 
              (threecol_id, habit_id, updated_at, created_at) 
            VALUES 
              (:threecol_id, :habit_id, :created_at, :updated_at)"
        );
        $habit_id = 7;
        $stmt2->bindParam(":habit_id", $habit_id);
        $stmt2->bindParam(":threecol_id", $threecol_id);
        $stmt2->bindParam(":created_at", $created_at);
        $stmt2->bindParam(":updated_at", $created_at);

        $stmt2->execute();
    }

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

header('Location: ../../threecolumns');
exit;
