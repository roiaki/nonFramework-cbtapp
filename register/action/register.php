<?php
    require '../../common/database.php';

    $user_name = $_POST['user_name'];
    $user_email = $_POST['user_email'];
    $user_password = $_POST['user_password'];

    $database_handler = getDatabaseConnection();
    try {
        $sql = $database_handler->prepare("INSERT INTO users(name, email, password) VALUES (:name, :email, :password)");
        
        $password = password_hash($user_password, PASSWORD_DEFAULT);

        $sql->bindParam(':name', htmlspecialchars($user_name));
        $sql->bindParam(':email', $user_email);
        $sql->bindParam(':password', $password);
var_dump($sql);
        $sql->execute();

    } catch (Throwable $e) {
        echo $e->getMessage();
        exit;
    }

    header('Location: ../../events');
?>