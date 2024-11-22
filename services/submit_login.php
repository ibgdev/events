<?php
session_start();

require "./config.php";

try {
    $dns = "mysql:host=$HOST;dbname=$DB_NAME;chatset=utf8";
    $mysqlclient = new PDO($dns, $USER, $PASSWD, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

    $email = $_POST['email'];
    $password = $_POST['password'];

    $SQLquery = "SELECT * FROM users WHERE email = :email";
    $RS = $mysqlclient->prepare($SQLquery);
    $RS->execute([
        "email" => $email
    ]);

    if ($RS->rowCount() > 0) {
        $user = $RS->fetch(PDO::FETCH_ASSOC);

        if ($password == $user["password"]) {
            $_SESSION["user_id"] = $user["id"];
            $_SESSION["email"] = $user["email"];

            header("location : ../events.php");
            exit();
        }else{
            $_SESSION["error"] = "Incorrect password! Please try again.";
            header("Location: login.php");
            exit();
        }
    }else{
        $_SESSION["error"] = "No account found with that email. Please try again.";
        header("Location: login.php");
        exit();
    }

}catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}