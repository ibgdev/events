<?php
require_once "config.php";

try {
    $dsn = "mysql:host=$HOST;dbname=$DB_NAME;charset=utf8";
    $mysqlclient = new PDO($dsn, $USER, $PASSWD, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

} catch (PDOException $e) {
    $error = "Connection failed: " . $e->getMessage();
}