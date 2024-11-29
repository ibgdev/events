<?php
session_start();
require "../services/config.php";

if (!isset($_SESSION["user_id"]) || $_SESSION["org"] != 1) {
    header("Location: ../index.php");
    exit();
}

$reservations = [];
$error = '';

try {
    $dsn = "mysql:host=$HOST;dbname=$DB_NAME;charset=utf8";
    $mysqlclient = new PDO($dsn, $USER, $PASSWD, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

    // Fetching reservations along with event details and user info
    $SQLquery = "SELECT reservations.id, events.title AS event_title, events.date AS event_date, 
                        events.location, users.full_name AS organiser, reservations.num_places,
                        reservations.reservation_date, users.full_name AS reserved_by
                FROM reservations
                JOIN events ON reservations.event_id = events.id
                JOIN users ON reservations.user_id = users.id
                ORDER BY reservations.id ASC";
    $stmt = $mysqlclient->prepare($SQLquery);
    $stmt->execute();
    $reservations = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $error = "Connection failed: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="theme.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="../imgs/logo.png" type="image/x-icon">
    <title>Admin - Reservations</title>
</head>

<body class="dark-theme">
    <?php include "sidebar.php"; ?>

    <div class="content">
        <h1>Reservations Management</h1>

        <?php if (!empty($error)): ?>
            <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <!-- Reservations Table -->
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Event Title</th>
                    <th>Date</th>
                    <th>Location</th>
                    <th>Organized by</th>
                    <th>User Reserved</th> <!-- Added this column -->
                    <th>Seats Reserved</th>
                    <th>Reservation Date</th> <!-- Added this column -->
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($reservations)): ?>
                    <?php foreach ($reservations as $reservation): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($reservation['id']); ?></td>
                            <td><?php echo htmlspecialchars($reservation['event_title']); ?></td>
                            <td><?php echo date("F j, Y", strtotime($reservation['event_date'])); ?></td>
                            <td><?php echo htmlspecialchars($reservation['location']); ?></td>
                            <td><?php echo htmlspecialchars($reservation['organiser']); ?></td>
                            <td><?php echo htmlspecialchars($reservation['reserved_by']); ?></td> <!-- Displaying the reserved user -->
                            <td><?php echo htmlspecialchars($reservation['num_places']); ?></td>
                            <td><?php echo date("F j, Y", strtotime($reservation['reservation_date'])); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8" style="text-align:center;">No reservations found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>

<script src="scrip.js"></script>
</html>
