<?php
session_start();
require '../../common/database.php';
require '../../common/validation.php';

$user_email = $_POST['user_email'];
$user_password = $_POST['user_password'];

// バリデーション
if (emptyCheck($user_email) == "NG") {
    $_SESSION['email']['empty']= "入力必須です";       
}

if (emptyCheck($user_password) == "NG") {
    $_SESSION['password']['empty'] = "入力必須です";
}

if (emailCheck($user_email) == "NG") {
    $_SESSION['email']['form'] = "メール形式でお願いします";
}
//var_dump($_SESSION['email']);

if (minSize($user_password) == "NG") {
    $_SESSION['password']['min'] = "4文字以上でお願いします。";
}

if (maxSize($user_password) == "NG") {
    $_SESSION['password']['min'] = "255文字未満でお願いします。";
}

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
    $_SESSION['flash_message'] = "ログインしました";
    
    header('Location: ../../events/');
    exit;

} else {
    $_SESSION['errors'] = [
        'メールアドレスまたはパスワードが間違っています。'
    ];
    header('Location: ../../login/');
    exit;
}
