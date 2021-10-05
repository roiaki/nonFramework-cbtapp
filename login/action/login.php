<?php
    session_start();
    require '../../common/database.php';
    require '../../common/validation.php';

    $user_email = $_POST['user_email'];
    $user_password = $_POST['user_password'];

    // バリデーション

    // ログイン処理
    $database_handler = getDatabaseConnection();
    
    $sql = $database_handler->prepare('SELECT id, name, email, password FROM users WHERE email = :user_email');
    $sql->bindParam(':user_email', $user_email);
    $sql->execute();

    $user = $sql->fetch(PDO::FETCH_ASSOC);
    if (!$user) {
        $_SESSION['errors'] = ['メールアドレスが間違っています'];
        header('Location: ../../login/');
        exit;
    }

    $name = $user['name'];
    $id = $user['id'];
    $email = $user['email'];

    //var_dump($email);
    //exit;

    // パスワードが正しいならば
    if ( password_verify($user_password, $user['password']) ) {
        // ユーザー情報保持
        $_SESSION['user'] = [
            'name' => $name,
            'email' => $email,
            'id' => $id
        ];

        header('Location: ../../events/');
        exit;

    } else {
        $_SESSION['errors'] = [
            'メールアドレスまたはパスワードが間違っています。'
        ];
        header('Location: ../../login/');
        exit;
    }
