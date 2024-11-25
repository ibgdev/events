<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    session_destroy();
    header("Location: ../login.php");
    exit();
}

if (isset($_GET['logout']) && $_GET['logout'] === 'true') {
    session_destroy();
    header("Location: ../index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logout</title>
    <script type="text/javascript">
        let confirmLogout = confirm("Are you sure you want to log out?");
        if (confirmLogout) {
            window.location.href = "<?php echo $_SERVER['PHP_SELF']; ?>?logout=true";
        } else {
            window.location.href = "/admin/dashboard.php";
        }
    </script>
</head>

<body>
</body>

</html>
