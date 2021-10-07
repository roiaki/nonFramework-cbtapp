<?php
    require '../../common/database.php';
    require '../../common/auth.php';

    if (!isLogin()) {
        header('Location: ../../login/');
    }

    $htmltitle = "";

    if ( empty($_POST['title']) ) {
        $_SESSION['error_message']['title'] = "タイトルを入力してください";
        var_dump($_POST);
        var_dump($_SESSION);
        //exit;
        header('Location: ../../events/create.php');
    } else {
        $clean['title'] = htmlspecialchars( $_POST['title'], ENT_QUOTES, 'UTF-8' );
        header('Location: ../../events/create.php');
    }

    if ( empty($_POST['content']) ) {
        $_SESSION['error_message']['content'] = "内容を入力してください";
    } else {
        $clean['content'] = htmlspecialchars( $_POST['content'], ENT_QUOTES, 'UTF-8');
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
        $sql = $database_handler->prepare("INSERT INTO events (user_id, title, content, updated_at, created_at) VALUES(:user_id, :title, :content, :created_at, :updated_at)");
        $sql->bindParam(":user_id", $user_id);
        $sql->bindParam(":title", $clean['title']);
        $sql->bindParam(":content", $clean['content']);
        $sql->bindParam(":created_at", $created_at);
        $sql->bindParam(":updated_at", $created_at);
        $sql->execute();

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
    $sql = null;

    $database_handler = null;

    header('Location: ../../events');
    exit;
