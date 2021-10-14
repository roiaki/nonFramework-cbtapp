<?php
session_start();

require '../../common/database.php';
//require '../../common/updateCheckbox.php';
require '../../common/auth.php';

// ログインしていないならログイン画面へ
if ( !isLogin() ) {
	header('Location: ../../login/');
}

// 関数
// 
//function getHabitId() {

//}

$user_id = getLoginUserId();
$user_name = getLoginUserName();

$threecol_id = $_POST['threecol_id'];

$edit_title = $_POST['title'];
$edit_content = $_POST['content'];
$edit_emotion_name = $_POST['emotion_name'];
$edit_emotion_strength = $_POST['emotion_strength'];
$edit_thinking = $_POST['thinking'];

$edit_title = $_POST['title'];

$created_at = date('Y-m-d H:i:s');
$updated_at = date('Y-m-d H:i:s');
var_dump($created_at);

var_dump($_POST, $edit_content);
var_dump($_POST['habit'][0]);
//exit;

$database_handler = getDatabaseConnection();

// トランザクション開始
$database_handler->beginTransaction();

try {
    // 3コラムupdate処理
    $stmt = $database_handler
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
    $stmt->bindParam(':title', $edit_title);
    $stmt->bindParam(':content', $edit_content);
    $stmt->bindParam(':emotion_name', $edit_emotion_name);
    $stmt->bindParam(':emotion_strength', $edit_emotion_strength);
    $stmt->bindParam(':thinking', $edit_thinking);

    $stmt->bindParam(':threecol_id', $threecol_id);
    $stmt->bindParam(':user_id', $user_id);

    $stmt->execute();

    // 中間テーブル更新処理
    // 一度該当データを全部消してチェックがあるものは　insert する
    $stmt2 = $database_handler
        ->prepare(
            "DELETE
            FROM 
              habit_threecolumn 
            WHERE 
              threecol_id = :threecol_id"
        );
    
    $stmt2->bindParam(':threecol_id', $threecol_id);
    $stmt2->execute();

    $sql = "INSERT INTO 
              habit_threecolumn 
              (threecol_id, 
              habit_id, 
              updated_at, 
              created_at) 
            VALUES 
              (:threecol_id, 
              :habit_id, 
              :created_at, 
              :updated_at)";

    if ( isset($_POST['habit'][0]) ) {

        $stmt2 = $database_handler
            ->prepare($sql);

            $habit_id = 1;
            $stmt2->bindParam(":habit_id", $habit_id);
            $stmt2->bindParam(":threecol_id", $threecol_id);
            $stmt2->bindParam(":created_at", $created_at);
            $stmt2->bindParam(":updated_at", $updated_at);
        
            $stmt2->execute();
    }

    if ( isset($_POST['habit'][1]) ) {

        $stmt2 = $database_handler
            ->prepare($sql);

            $habit_id = 2;
            $stmt2->bindParam(":habit_id", $habit_id);
            $stmt2->bindParam(":threecol_id", $threecol_id);
            $stmt2->bindParam(":created_at", $created_at);
            $stmt2->bindParam(":updated_at", $created_at);
        
            $stmt2->execute();
    }

    if ( isset($_POST['habit'][2]) ) {

        $stmt2 = $database_handler
            ->prepare($sql);

            $habit_id = 3;
            $stmt2->bindParam(":habit_id", $habit_id);
            $stmt2->bindParam(":threecol_id", $threecol_id);
            $stmt2->bindParam(":created_at", $created_at);
            $stmt2->bindParam(":updated_at", $created_at);
        
            $stmt2->execute();
    }

    if ( isset($_POST['habit'][3]) ) {

        $stmt2 = $database_handler
            ->prepare($sql);

            $habit_id = 4;
            $stmt2->bindParam(":habit_id", $habit_id);
            $stmt2->bindParam(":threecol_id", $threecol_id);
            $stmt2->bindParam(":created_at", $created_at);
            $stmt2->bindParam(":updated_at", $created_at);
        
            $stmt2->execute();
    }

    if ( isset($_POST['habit'][4]) ) {

        $stmt2 = $database_handler
            ->prepare($sql);

            $habit_id = 5;
            $stmt2->bindParam(":habit_id", $habit_id);
            $stmt2->bindParam(":threecol_id", $threecol_id);
            $stmt2->bindParam(":created_at", $created_at);
            $stmt2->bindParam(":updated_at", $created_at);
        
            $stmt2->execute();
    }

    if ( isset($_POST['habit'][5]) ) {

        $stmt2 = $database_handler
            ->prepare($sql);

            $habit_id = 6;
            $stmt2->bindParam(":habit_id", $habit_id);
            $stmt2->bindParam(":threecol_id", $threecol_id);
            $stmt2->bindParam(":created_at", $created_at);
            $stmt2->bindParam(":updated_at", $created_at);
        
            $stmt2->execute();
    }

    if ( isset($_POST['habit'][6]) ) {

        $stmt2 = $database_handler
            ->prepare($sql);

            $habit_id = 7;
            $stmt2->bindParam(":habit_id", $habit_id);
            $stmt2->bindParam(":threecol_id", $threecol_id);
            $stmt2->bindParam(":created_at", $created_at);
            $stmt2->bindParam(":updated_at", $created_at);
        
            $stmt2->execute();
    }

    // ここまで中間テーブル更新処理

    // 中間テーブル更新処理　アイディア２
    // 中間テーブルとpostされたデータを照らし合わせる
    // post 有り　中間テーブル 有り -> 何も処理なし
    // post 有り　中間テーブル 無し -> insert
    // post 無し　中間テーブル 有り -> delete
    // post 無し　中間テーブル 無し -> 処理なし


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
$stmt2 = null;

// データベースの接続を閉じる
$database_handler = null;

header('Location: ../../threecolumns');
exit;
?>