<?php

function getDatabaseConnection() {
    try
    {
        $database_handler = new PDO('mysql:host=localhost;dbname=laravel_cbtapp;charset=utf8', 'root', '');
    } catch (PDOException $e)
    {
        echo "DB接続に失敗しました";
        echo $e->getMessage();
        exit;
    }
    return $database_handler;
}