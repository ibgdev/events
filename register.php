<?php
session_start();
if (isset($_SESSION["user_id"])) {
    header("Location: index.php");
    exit();
}
require "./services/config.php";

$error = "";
$success = "";


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    try {
        $dsn = "mysql:host=$HOST;dbname=$DB_NAME;charset=utf8";
        $mysqlclient = new PDO($dsn, $USER, $PASSWD, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

        $name = $_POST['name'];
        $phone = $_POST['phone'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];

        if ($password !== $confirm_password) {
            $error = "Passwords do not match!";
        }else{
            $SQLquery = "SELECT * FROM users WHERE email = :email";
            $RS = $mysqlclient->prepare($SQLquery);
            $RS->execute(["email" => $email]);

            if ($RS->rowCount() > 0) {
                $error = "An account with that email already exists!";
            }else{
                $insert = "INSERT INTO users(full_name, email, password, phone) VALUE(:full_name, :email, :password, :phone)";
                $insert_rs = $mysqlclient->prepare($insert);
                $insert_rs->execute([
                    "full_name" => $name,
                    "email" => $email,
                    "password" => $password,
                    "phone" => $phone
                ]);
                $success = "Registration successful! You can now log in.";
            }
        }
    } catch (PDOException $e) {
        $error = "Connection failed: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="./styles/registerstyle.css">
    <link rel="stylesheet" href="./styles/navstyle.css">
</head>

<body>
    <nav>
        <?php include('./pages/navbar.php'); ?>
    </nav>
    <main>
        <section class="register-section">
            <div class="register-logo">
                <img src="./imgs/logodark.png" alt="Logo" class="logo-image">
            </div>
            <div class="register-form-container">
                <h2>Create an Account</h2>
                
                <?php if (!empty($success)): ?>
                    <p class="success-message"><?php echo htmlspecialchars($success); ?></p>
                <?php endif; ?>

                <?php if (!empty($error)): ?>
                    <p class="error-message"><?php echo htmlspecialchars($error); ?></p>
                <?php endif; ?>
                
                <form action="" method="POST" class="register-form">
                    <label for="name">Full Name</label>
                    <input type="text" name="name" placeholder="Your full name" required>

                    <label for="email">Email</label>
                    <input type="email" name="email" placeholder="Your email" required>

                    <label for="phone">Phone</label>
                    <input type="tel" name="phone" placeholder="Your phone" required>

                    <label for="password">Password</label>
                    <input type="password" name="password" placeholder="************" required>

                    <label for="confirm_password">Confirm Password</label>
                    <input type="password" name="confirm_password" placeholder="************" required>

                    <button type="submit" class="register-button">Sign Up</button>
                    <a href="./login.php" class="already">Already have an account ?</a>
                </form>
            </div>
        </section>
    </main>
</body>

</html>
