<?php

function emptyCheck($check_value) {
    if( empty(trim($check_value)) ) {
        $status = "empty";
    } else {
        $status = "OK";
    }
    return $status;
}

function minSize($check_value) {
    if (mb_strlen($check_value) < 4) {
        $status = "NG";
    } else {
        $status = "OK";
    } 
    return $status;
}

function maxSize($check_value) {
    if (255 < mb_strlen($check_value)) {
        $status = "NG";
    } else {
        $status = "OK";
    } 
    return $status;
}

function emailCheck($check_value) {
    if (filter_var($check_value, FILTER_VALIDATE_EMAIL) == false) {
        $status = "NG";
    } else {
        $status = "OK";
    } 
    return $status;
}

function emailDuplicationCheck($check_value) {
    $database_handler = getDatabaseConnection();
    
    $sql = $database_handler->prepare('SELECT id FROM users WHERE email = :user_email');
    $sql->bindParam(':user_email', $check_value);
    $sql->execute();

    $result = $sql->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        $status = "duplicated_NG";
    } else {
        $status = "duplicated_OK";
    }
    return $status;
}