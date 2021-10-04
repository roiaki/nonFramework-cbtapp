<?php
    session_start();
    require '../../common/database.php';
    require '../../common/validation.php';

    $user_name = $_POST['user_name'];
    $user_email = $_POST['user_email'];
    $user_password = $_POST['user_password'];

    $_SESSION['errors'] = "入力必須です";
    //var_dump($_SESSION['errors']);
    //exit;

    if (emptyCheck($user_name) == "empty") {
        $_SESSION['name_error'][] = "入力必須です";
    }
 
    if (emptyCheck($user_email) == "empty") {
        $_SESSION['email_error'][]= "入力必須です";       
    }
    
    if (emptyCheck($user_password) == "empty") {
        $_SESSION['password_error'][] = "入力必須です";
    }

    if (emailCheck($user_email) == "NG") {
        $_SESSION['email_error'][] = "メール形式でお願いします";
    }
    var_dump($_SESSION['email']);
    /*
    foreach ((array)$_SESSION['email'] as $err) {
        var_dump($err);
    };
    exit;
*/
    if (minSize($user_password) == "NG") {
        $_SESSION['password']['min'] = "4文字以上でお願いします。";
    }

    if (maxSize($user_password) == "NG") {
        $_SESSION['password']['min'] = "255文字未満でお願いします。";
    }

    if (emailDuplicationCheck($user_email) == "duplicated_NG") {
        $_SESSION['email']['duplicate'] = "既に登録されているメールアドレスです。";
    }

/*
var_dump($_SESSION['user_name_status']['empty']);
var_dump($_SESSION['user_email_status']['min']);
var_dump($_SESSION['user_email_status']['duplicated']);
exit;
*/

    //var_dump($_SESSION['user_name']['empty']);
    //exit;

    if ($_SESSION['email_error']) {
        $post = 
        header('Location: ../../register');
        exit;
    }

    $database_handler = getDatabaseConnection();
    
    try {
        $sql = $database_handler->prepare("INSERT INTO users(name, email, password) VALUES (:name, :email, :password)");

//var_dump($sgl);
//exit;

        $password = password_hash($user_password, PASSWORD_DEFAULT);

        $sql->bindParam(':name', htmlspecialchars($user_name));
        $sql->bindParam(':email', $user_email);
        $sql->bindParam(':password', $password);

        $sql->execute();

        // ユーザー情報をセッションへ格納
        $_SESSION['user'] = [
            'name' => $user_name,
            'id' => $database_handler->lastInsertId() // ???
        ];

    } catch (Throwable $e) {
        echo $e->getMessage();
        exit;
    }

    header('Location: ../../events');
?>