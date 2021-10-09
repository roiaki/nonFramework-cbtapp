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

var_dump($_POST);

var_dump($_POST['habit']);
//exit;

$database_handler = getDatabaseConnection();

// トランザクション開始
$database_handler->beginTransaction();

try {
    $sql = $database_handler->
        prepare(
            "UPDATE threecolumns 
             SET user_id = :user_id, 
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

//var_dump($sql);
    $sql->bindParam(":user_id", $user_id);
    $sql->bindParam(":event_id", $event_id);
    $sql->bindParam(":title", $clean['title']);
    $sql->bindParam(":content", $clean['content']);
    $sql->bindParam(":emotion_name", $clean['emotion_name']);
    $sql->bindParam(":emotion_strength", $emotion_strenght);
    $sql->bindParam(":thinking", $clean['thinking']);

    $sql->bindParam(":threecol_id", $threecol_id);
  
    $sql->execute();

    // コミット
    //$res = $database_handler->commit();

    
    $count = count($_POST['habit']);
    //var_dump($count);
    //exit;
        
        // 課題　冗長をなくす
        if(isset($_POST['habit'][0]) ) {
            $sql2 = $database_handler->
            prepare(
                "INSERT INTO 
                    habit_threecolumn 
                    (threecol_id, habit_id, updated_at, created_at) 
                VALUES 
                    (:threecol_id, :habit_id, :created_at, :updated_at)"
            );
            $habit_id = 1;
            $sql2->bindParam(":habit_id", $habit_id);
            $sql2->bindParam(":threecol_id", $threecol_id);
            $sql2->bindParam(":created_at", $created_at);
            $sql2->bindParam(":updated_at", $created_at);
    
            $sql2->execute();
        }
        if(isset($_POST['habit'][1]) ) {
            $sql2 = $database_handler->
            prepare(
                "INSERT INTO 
                    habit_threecolumn 
                    (threecol_id, habit_id, updated_at, created_at) 
                VALUES 
                    (:threecol_id, :habit_id, :created_at, :updated_at)"
            );
            $habit_id = 2;
            $sql2->bindParam(":habit_id", $habit_id);
            $sql2->bindParam(":threecol_id", $threecol_id);
            $sql2->bindParam(":created_at", $created_at);
            $sql2->bindParam(":updated_at", $created_at);
    
            $sql2->execute();
        }
        if(isset($_POST['habit'][2]) ) {
            $sql2 = $database_handler->
            prepare(
                "INSERT INTO 
                    habit_threecolumn 
                    (threecol_id, habit_id, updated_at, created_at) 
                VALUES 
                    (:threecol_id, :habit_id, :created_at, :updated_at)"
            );
            $habit_id = 3;
            $sql2->bindParam(":habit_id", $habit_id);
            $sql2->bindParam(":threecol_id", $threecol_id);
            $sql2->bindParam(":created_at", $created_at);
            $sql2->bindParam(":updated_at", $created_at);
    
            $sql2->execute();
        }
        if(isset($_POST['habit'][3]) ) {
            $sql2 = $database_handler->
            prepare(
                "INSERT INTO 
                    habit_threecolumn 
                    (threecol_id, habit_id, updated_at, created_at) 
                VALUES 
                    (:threecol_id, :habit_id, :created_at, :updated_at)"
            );
            $habit_id = 4;
            $sql2->bindParam(":habit_id", $habit_id);
            $sql2->bindParam(":threecol_id", $threecol_id);
            $sql2->bindParam(":created_at", $created_at);
            $sql2->bindParam(":updated_at", $created_at);
    
            $sql2->execute();
        }
        if(isset($_POST['habit'][4]) ) {
            $sql2 = $database_handler->
            prepare(
                "INSERT INTO 
                    habit_threecolumn 
                    (threecol_id, habit_id, updated_at, created_at) 
                VALUES 
                    (:threecol_id, :habit_id, :created_at, :updated_at)"
            );
            $habit_id = 5;
            $sql2->bindParam(":habit_id", $habit_id);
            $sql2->bindParam(":threecol_id", $threecol_id);
            $sql2->bindParam(":created_at", $created_at);
            $sql2->bindParam(":updated_at", $created_at);
    
            $sql2->execute();
        }
        if(isset($_POST['habit'][5]) ) {
            $sql2 = $database_handler->
            prepare(
                "INSERT INTO 
                    habit_threecolumn 
                    (threecol_id, habit_id, updated_at, created_at) 
                VALUES 
                    (:threecol_id, :habit_id, :created_at, :updated_at)"
            );
            $habit_id = 6;
            $sql2->bindParam(":habit_id", $habit_id);
            $sql2->bindParam(":threecol_id", $threecol_id);
            $sql2->bindParam(":created_at", $created_at);
            $sql2->bindParam(":updated_at", $created_at);
    
            $sql2->execute();
        }
        if(isset($_POST['habit'][6]) ) {
            $sql2 = $database_handler->
            prepare(
                "INSERT INTO 
                    habit_threecolumn 
                    (threecol_id, habit_id, updated_at, created_at) 
                VALUES 
                    (:threecol_id, :habit_id, :created_at, :updated_at)"
            );
            $habit_id = 7;
            $sql2->bindParam(":habit_id", $habit_id);
            $sql2->bindParam(":threecol_id", $threecol_id);
            $sql2->bindParam(":created_at", $created_at);
            $sql2->bindParam(":updated_at", $created_at);
    
            $sql2->execute();
        }       
    
    var_dump($sql2);
    //exit;
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
//var_dump($res);
//var_dump($succes_message);
//exit;
// プリペアードステートメントを削除
$sql = null;

// データベースの接続を閉じる
$database_handler = null;

header('Location: ../../threecolumns');
exit;
