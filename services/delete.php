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
        
        $query = "DELETE FROM events WHERE id = :id";
        $res = $mysqlclient->prepare($query);
        $res->execute([
            "id" => $_GET['id']
        ]);

        header("Location: /admin/events.php?message=Event Deleted Successfully");
        exit();
    } catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Event</title>
    <script type="text/javascript">
        const eventId = "<?php echo isset($_GET['id']) ? $_GET['id'] : ''; ?>";

        if (eventId) {
            let confirmDelete = confirm("Are you sure you want to delete this event?");
            if (confirmDelete) {
                window.location.href = "<?php echo $_SERVER['PHP_SELF']; ?>?delete=true&id=" + eventId;
            } else {
                window.location.href = "/admin/events.php";
            }
        } else {
            window.location.href = "/admin/events.php";
        }
    </script>
</head>

<body>
</body>

</html>
