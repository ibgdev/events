<?php
session_start();
require "../services/config.php";
require_once "../services/connect.php";

if (!isset($_SESSION["user_id"]) || $_SESSION["org"] != 1) {
    header("Location: ../index.php");
    exit();
}

$reservations = [];
$error = '';
if ($_SESSION['user_id'] !== 1) {
    $SQLquery = "SELECT reservations.id, events.title AS event_title, events.date AS event_date, 
    events.location, users.full_name AS organiser, reservations.num_places,
    reservations.reservation_date, users.full_name AS reserved_by
    FROM reservations
    JOIN events ON reservations.event_id = events.id
JOIN users ON reservations.user_id = users.id
    WHERE users.full_name = '{$_SESSION['name']}'
ORDER BY reservations.id ASC";
} else {
    $SQLquery = "SELECT reservations.id, events.title AS event_title, events.date AS event_date, 
    events.location, users.full_name AS organiser, reservations.num_places,
    reservations.reservation_date, users.full_name AS reserved_by
FROM reservations
JOIN events ON reservations.event_id = events.id
JOIN users ON reservations.user_id = users.id
ORDER BY reservations.id ASC";
}

$stmt = $mysqlclient->prepare($SQLquery);
$stmt->execute();
$reservations = $stmt->fetchAll(PDO::FETCH_ASSOC);

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

        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Event Title</th>
                    <th>Date</th>
                    <th>Location</th>
                    <th>Organized by</th>
                    <th>User Reserved</th>
                    <th>Seats Reserved</th>
                    <th>Reservation Date</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($reservations)): ?>
                    <?php foreach ($reservations as $reservation): ?>
                        <tr>
                            <td><?php echo $reservation['id']; ?></td>
                            <td><?php echo $reservation['event_title']; ?></td>
                            <td><?php echo date("F j, Y", strtotime($reservation['event_date'])); ?></td>
                            <td><?php echo $reservation['location']; ?></td>
                            <td><?php echo $reservation['organiser']; ?></td>
                            <td><?php echo $reservation['reserved_by']; ?></td> <!-- Displaying the reserved user -->
                            <td><?php echo $reservation['num_places']; ?></td>
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