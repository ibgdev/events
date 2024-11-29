<?php
session_start();
require_once "./services/connect.php";

if (isset($_SESSION["user_id"])) {
    header("Location: index.php");
    exit();
}

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'];
    
    $SQLquery = "SELECT * FROM users WHERE email = :email";
    $res = $mysqlclient->prepare($SQLquery);
    $res->execute(["email" => $email]);
    
    if ($res->rowCount() > 0) {
        $user = $res->fetch(PDO::FETCH_ASSOC);
    
        if ($password == $user["password"]) {
            $_SESSION["user_id"] = $user["id"];
            $_SESSION["email"] = $user["email"];
            $_SESSION["org"] = $user["org"];
            $_SESSION["name"] = $user["full_name"];
            $_SESSION["phone"] = $user["phone"];
    
            if ($user["id"] == 1) {
                header("Location: ./admin/dashboard.php");
                exit();
            } else {
                header("Location: ./events.php");
                exit();
            }
        } else {
            $error = "email or password incorrect! Please try again.";
        }
    } else {
        $error = "email or password incorrect ! Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="./styles/loginstyle.css">
    <link rel="shortcut icon" href="imgs/logo.png" type="image/x-icon">
</head>

<body>
    <nav>
        <?php include('./pages/navbar.php'); ?>
    </nav>
    <main>
        <section class="login-section">
            <div class="login-logo">
                <img src="./imgs/logodark.png" alt="Logo" class="logo-image">
            </div>
            <div class="login-form-container">
                <h2>Login</h2>
                
                <?php if (!empty($error)): ?>
                    <p class="error-message"><?php echo $error; ?></p>
                <?php endif; ?>

                <form action="" method="POST" class="login-form">
                    <label for="email">Email</label>
                    <input type="email" name="email" placeholder="Your email"
                        value="<?php echo htmlspecialchars($email ?? ''); ?>" required>

                    <label for="password">Password</label>
                    <input type="password" name="password" placeholder="************" required>

                    <button type="submit" class="login-button">Login</button>
                    <a href="./register.php" class="already">Don't have an account?</a>
                </form>
            </div>
        </section>
    </main>
</body>

</html>