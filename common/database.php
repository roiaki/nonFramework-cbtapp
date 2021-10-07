<?php

function getDatabaseConnection()
{
    try {
        $option = array(
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::MYSQL_ATTR_MULTI_STATEMENTS => false,
        );
        $database_handler = new PDO('mysql:host=localhost;dbname=laravel_cbtapp;charset=utf8', 'root', '', $option);
    } catch (PDOException $e) {
        echo "DB接続に失敗しました";
        echo $e->getMessage();
        exit;
    }
    return $database_handler;
}
