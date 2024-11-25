<?php
require "config.php";
$dns = "mysql:host=$HOST;dbname=$DB_NAME;chatset=utf-8";
try{
    $mysqlclient = new PDO($dns,$USER,$PASSWD,[PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

    if ($mysqlclient) {
        echo "Connected to the $db database successfully!";
    }
}
catch(PDOException $e){
    echo $e->getMessage();
}