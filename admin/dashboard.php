<?php
session_start();
require "../services/config.php";

if (!isset($_SESSION["user_id"]) || $_SESSION["org"] != 1) {
    header("Location: ../index.php");
    exit();
}

try {
    $dsn = "mysql:host=$HOST;dbname=$DB_NAME;charset=utf8";
    $mysqlclient = new PDO($dsn, $USER, $PASSWD, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    $SQLquery_events = "SELECT * FROM events";
    $res_events = $mysqlclient->prepare($SQLquery_events);
    $res_events->execute();

    $SQLquery_reservations = "SELECT * FROM reservations";
    $res_reservations = $mysqlclient->prepare($SQLquery_reservations);
    $res_reservations->execute();

    $SQLquery_users = "SELECT * FROM users";
    $res_users = $mysqlclient->prepare($SQLquery_users);
    $res_users->execute();

} catch (PDOException $e) {
    $error = "Connection failed: " . $e->getMessage();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="theme.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>


<body class="dark-theme">
    <?php include 'sidebar.php'; ?>

    <div class="content">
        <header>
            <div class="header-left">
                <h1>Admin Dashboard</h1>
            </div>

        </header>

        <div class="dashboard-cards">
            <div class="card">
                <h3>Total Events</h3>
                <p><?php echo $res_events->rowCount() ?></p>
            </div>
            <div class="card">
                <h3>Active Users</h3>
                <p><?php echo $res_users->rowCount() ?></p>
            </div>
            <div class="card">
                <h3>Pending Reservations</h3>
                <p><?php echo $res_reservations->rowCount() ?></p>
            </div>
        </div>

        <div class="section">
            <h2>Manage Your Sections</h2>
            <p>Select a section from the sidebar to manage events, reservations, or users.</p>
        </div>
    </div>
    <script src="scrip.js"></script>
</body>

</html>