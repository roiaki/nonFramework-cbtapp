<?php

// 入力チェック
function emptyCheck($check_value) {
    if( empty(trim($check_value)) ) {
        $status = "NG";
    } else {
        $status = "OK";
    }
    return $status;
}

// 4文字以上チェック
function minSize($check_value) {
    if (mb_strlen($check_value) < 4) {
        $status = "NG";
    } else {
        $status = "OK";
    } 
    return $status;
}

// 255文字未満チェック
function maxSize($check_value) {
    if (255 < mb_strlen($check_value)) {
        $status = "NG";
    } else {
        $status = "OK";
    } 
    return $status;
}

// メールアドレスか
function emailCheck($check_value) {
    if (filter_var($check_value, FILTER_VALIDATE_EMAIL) == false) {
        $status = "NG";
    } else {
        $status = "OK";
    } 
    return $status;
}

// メールアドレスが重複していなかチェック
function emailDuplicationCheck($check_value) {
    $database_handler = getDatabaseConnection();
    
    $stmt = $database_handler->prepare('SELECT id FROM users WHERE email = :user_email');
    $stmt->bindParam(':user_email', $check_value);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        $status = "NG";
    } else {
        $status = "OK";
    }
    return $status;
}