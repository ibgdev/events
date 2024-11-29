<?php
session_start();
require "../services/config.php";

if (!isset($_SESSION["user_id"])) {
    session_destroy();
    header("Location: ../login.php");
    exit();
}

if (isset($_GET['delete']) && $_GET['delete'] === 'true' && isset($_GET['id'])) {
    try {
        $dsn = "mysql:host=$HOST;dbname=$DB_NAME;charset=utf8";
        $mysqlclient = new PDO($dsn, $USER, $PASSWD, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

        if ($_GET["id"] != 1) {
            $query = "DELETE FROM users WHERE id = :id";
            $res = $mysqlclient->prepare($query);
            $res->execute([
                "id" => $_GET['id']
            ]);

            header("Location: /admin/users.php?message=User deleted successfully");
            exit();
        } else {
            header("Location: /admin/users.php?message=Cannot delete the admin user");
            exit();
        }
    } catch (PDOException $e) {
        error_log("Database error: " . $e->getMessage());
        header("Location: /admin/users.php?message=An error occurred");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete User</title>
    <script type="text/javascript">
        document.addEventListener("DOMContentLoaded", function () {
            const userId = "<?php echo isset($_GET['id']) ? htmlspecialchars($_GET['id'], ENT_QUOTES, 'UTF-8') : ''; ?>";

            if (userId) {
                const confirmDelete = confirm("Are you sure you want to delete this user?");
                if (confirmDelete) {
                    window.location.href = "<?php echo htmlspecialchars($_SERVER['PHP_SELF'], ENT_QUOTES, 'UTF-8'); ?>?delete=true&id=" + userId;
                } else {
                    window.location.href = "/admin/users.php";
                }
            } else {
                window.location.href = "/admin/users.php";
            }
        });
    </script>
</head>

<body>
</body>

</html>
