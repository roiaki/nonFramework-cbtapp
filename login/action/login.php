<?php
session_start();
require '../../common/database.php';
require '../../common/validation.php';

$user_email = $_POST['user_email'];
$user_password = $_POST['user_password'];

$errorCount = 0;
// バリデーションチェック
if (emptyCheck($user_email) == "NG") {
    $_SESSION['email_error']['empty']= "入力必須です";
    $errorCount += 1;   
}

if (emptyCheck($user_password) == "NG") {
    $_SESSION['password_error']['empty'] = "入力必須です";
    $errorCount += 1; 
}

if (emailCheck($user_email) == "NG") {
    $_SESSION['email_error']['form'] = "メール形式でお願いします";
    $errorCount += 1; 
}

if (minSize($user_password) == "NG") {
    $_SESSION['password_error']['min'] = "4文字以上でお願いします。";
    $errorCount += 1; 
}

if (maxSize($user_password) == "NG") {
    $_SESSION['password_error']['min'] = "255文字未満でお願いします。";
    $errorCount += 1; 
}

// バリデーションエラーがあったらリダイレクト
if ( $errorCount > 0 ) {
    $_SESSION['user_email'] = $_POST['user_email'];
    $_SESSION['user_password'] = $_POST['user_password'];
    header('Location: ../../login');
    exit;
}

// ログイン処理
$database_handler = getDatabaseConnection();

$stmt = $database_handler
    ->prepare(
        "SELECT 
          id, 
          name, 
          email, 
          password 
        FROM 
          users 
        WHERE 
          email = :user_email"
    );

$stmt->bindParam(':user_email', $user_email);
$stmt->execute();

$user = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$user) {
    $_SESSION['error_verify'] = ['メールアドレスが間違っています'];
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
    $_SESSION['error_verify'] = [
        'メールアドレスまたはパスワードが間違っています。'
    ];
    header('Location: ../../login/');
    exit;
}
