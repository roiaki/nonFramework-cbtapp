<?php
session_start();
require '../../common/database.php';
require '../../common/validation.php';

$user_name = $_POST['user_name'];
$user_email = $_POST['user_email'];
$user_password = $_POST['user_password'];
$created_at = date("Y-m-d H:i:s");
$updated_at = date("Y-m-d H:i:s");

// バリデーション　課題　共通化
$errorCount = 0;
if (emptyCheck($user_name) == "NG") {
    $_SESSION['name_error']['empty'] = "入力必須です";
    $errorCount += 1;
}

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

if (emailDuplicationCheck($user_email) == "NG") {
    $_SESSION['email_error']['duplicate'] = "既に登録されているメールアドレスです。";
    $errorCount += 1;
}

// バリデーションエラーがあったら同じ画面へ
if ( $errorCount > 0 ) {
    $_SESSION['user_name'] = $_POST['user_name'];
    $_SESSION['user_email'] = $_POST['user_email'];
    $_SESSION['user_password'] = $_POST['user_password'];
    header('Location: ../../register');
    exit();
}

$database_handler = getDatabaseConnection();

try {
    $stmt = $database_handler
        ->prepare(
            "INSERT INTO 
              users
              (name, 
               email, 
               password,
               created_at,
               updated_at
              ) 
            VALUES 
              (:name, 
               :email, 
               :password,
               :created_at,
               :updated_at
              )"
        );

//var_dump($sgl);
//exit;

    $password = password_hash($user_password, PASSWORD_DEFAULT);

    $stmt->bindParam(':name', htmlspecialchars($user_name));
    $stmt->bindParam(':email', $user_email);
    $stmt->bindParam(':password', $password);
    $stmt->bindParam(':created_at', $created_at);
    $stmt->bindParam(':updated_at', $updated_at);
    $stmt->execute();

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