<?php
session_start();
require "../services/config.php";

if (!isset($_SESSION["user_id"]) || $_SESSION["user_id"] != 1) {
    header("Location: ../index.php");
    exit();
}

$error = '';
$users = [];
$message = isset($_GET['message']) ? htmlspecialchars($_GET['message'], ENT_QUOTES, 'UTF-8') : '';
$text = isset($_GET['text']) ? htmlspecialchars($_GET['text'], ENT_QUOTES, 'UTF-8') : '';

try {
    $dsn = "mysql:host=$HOST;dbname=$DB_NAME;charset=utf8";
    $mysqlclient = new PDO($dsn, $USER, $PASSWD, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

    // Fetch all users
    $SQLquery = "SELECT * FROM users";
    $RS = $mysqlclient->prepare($SQLquery);
    $RS->execute();
    $users = $RS->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $error = "Connection failed: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Users</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="theme.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="../imgs/logo.png" type="image/x-icon">
</head>

<body class="dark-theme">
    <?php include "sidebar.php"; ?>
    <div class="content">
        <h1>User Management</h1>

        <?php if (isset($_GET['message'])): ?>
            <div class="success-message">
                <?php echo $_GET['message']; ?>
            </div>
        <?php endif; ?>

        <?php if ($error): ?>
            <div class="error-message">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>

        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>Password</th>
                    <th>Organizer?</th>
                    <th>Phone</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?php echo $user['id']; ?></td>
                        <td><?php echo $user['full_name']; ?></td>
                        <td><?php echo $user['email']; ?></td>
                        <td><?php echo $user['password']; ?></td>
                        <td><?php echo ($user['org'] == 1) ? "Yes" : "No"; ?></td>
                        <td><?php echo $user['phone']; ?></td>
                        <td>
                            <?php if($user['org'] == 0): ?>
                                <a href="../services/setorg.php?id=<?php echo $user['id']; ?>"><button class="edit">Set Organizer</button></a>
                                <?php else :?>
                                    <a href="../services/delorg.php?id=<?php echo $user['id']; ?>"><button class="edit2">Remove Org</button></a>
                            <?php endif;?>
                            <a href="../services/deleteuser.php?id=<?php echo $user['id']; ?>"><button class="delete">Delete</button></a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
<script src="script.js"></script>
</html>
