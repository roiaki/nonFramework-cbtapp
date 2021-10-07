<?php

if ( !isset($_SESSION) ) {
    session_start();
}

// ログインしているかチェック
function isLogin() {
    if ( isset($_SESSION['user']) ) {
        return true;
    }
    return false;
}

// ログインユーザーID表示
function getLoginUserId() {
    if ( isset($_SESSION['user']) ) {
        $id = $_SESSION['user']['id'];
        return $id;
    }
    return null;
}

// ログインユーザーの名前表示
function getLoginUserName() {
    if ( isset($_SESSION['user']) ) {
        $name = $_SESSION['user']['name'];
        return $name;
    }
    return "";
}
