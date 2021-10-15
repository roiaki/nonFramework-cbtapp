<?php
session_start();

require '../common/database.php';
require '../common/auth.php';
//var_dump($_SESSION);
//exit();

// ログインしてないならログイン画面へ
if (!isLogin()) {
    header('Location: ../login/');
    exit;
}

$htmltitle = "3コラム編集";

$user_id = getLoginUserId();
$user_name = getLoginUserName();
$threecol_id = $_GET['threecol_id'];

$database_handler = getDatabaseConnection();
try {
    $stmt = $database_handler
        ->prepare(
          "SELECT 
            * 
          FROM 
            threecolumns 
          WHERE 
            id = :threecol_id
          AND
            user_id = :user_id"
        );

    $stmt->bindParam(':threecol_id', $threecol_id);
    $stmt->bindParam(':user_id', $user_id);

    $stmt->execute();

    $threecolumn = [];  

    while ( $result = $stmt->fetch(PDO::FETCH_ASSOC) ) {
        $threecolumn = $result;
    }

    $stmt2 = $database_handler
        ->prepare(
          "SELECT            
            habit_id 
          FROM 
            habits 
          JOIN 
            habit_threecolumn 
          ON 
            habits.id = habit_threecolumn.habit_id 
          WHERE 
            habit_threecolumn.threecol_id = :threecol_id"
        );

    $stmt2->bindParam(':threecol_id', $threecol_id);

    $stmt2->execute();
    //var_dump($stmt2);

    $habit_ids = [];

    while ( $result = $stmt2->fetch(PDO::FETCH_ASSOC) ) {
        // $result が配列なので　$habit_nameを二次元配列とする
        array_push($habit_ids, $result);
    }

    if ( isset($habit_ids) ) {
        foreach ($habit_ids as $habit_id) {
            foreach ($habit_id as $key => $value) {
                $id[] = $value;
            }  
        }
    }
   
} catch (Exception $e) {
    // エラーが起きたらロールバック
    $database_handler->rollBack();
    echo $e->getMessage();
    exit;
}


include('../common/head.php');

// ロジックとビューの分離
include 'views/edit_view.php';
?>
