<?php
session_start();
require "../services/config.php";

if (!isset($_SESSION["user_id"]) || $_SESSION["org"] != 1) {
    header("Location: ../index.php");
    exit();
}

$error = '';
$events = [];
$succ = '';

try {
    $dsn = "mysql:host=$HOST;dbname=$DB_NAME;charset=utf8";
    $mysqlclient = new PDO($dsn, $USER, $PASSWD, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    if ($_SESSION['user_id'] !== 1) {
        $SQLquery = "SELECT events.*, users.full_name AS organisateur
        FROM events
        JOIN users ON events.organiser_id = users.id
        WHERE users.full_name = '{$_SESSION['name']}'
        ORDER BY date ASC";
    } else {
        $SQLquery = "SELECT events.*, users.full_name AS organisateur
        FROM events
        JOIN users ON events.organiser_id = users.id
        ORDER BY date ASC";
    }


    $RS = $mysqlclient->prepare($SQLquery);
    $RS->execute();
    $events = $RS->fetchAll(PDO::FETCH_ASSOC);

    if ($_SERVER['REQUEST_METHOD'] === "POST") {

        $title = $_POST['title'];
        $type = $_POST['type'];
        $description = $_POST['description'];
        $date = $_POST['date'];
        $location = $_POST['location'];
        $places_dispo = $_POST['places_dispo'];
        $img = $_POST['img'];

        $query = "INSERT INTO events (title, type, description, date, location, places_dispo, organiser_id, img) 
        VALUES (:title, :type, :description, :date, :location, :places_dispo, {$_SESSION['user_id']}, :img)";
        $res = $mysqlclient->prepare($query);
        if (
            $res->execute([
                "title" => $title,
                "type" => $type,
                "description" => $description,
                "date" => $date,
                "location" => $location,
                "places_dispo" => $places_dispo,
                "img" => $img
            ])
        ) {
            $succ = "Event added succefuly";
            $RS->execute();
            $events = $RS->fetchAll(PDO::FETCH_ASSOC);
        } else {
            $error = "Failed to add the event.";
        }
    }
} catch (PDOException $e) {
    $error = "Connection failed: " . $e->getMessage();
}

if (isset($_GET['message'])) {
    $succ = $_GET['message'];
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Events</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="theme.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="../imgs/logo.png" type="image/x-icon">
</head>

<body class="dark-theme">
    <?php include "sidebar.php"; ?>
    <div class="content">
        <h1>Events Management</h1>

        <?php if ($_SESSION['user_id'] !== 1): ?>
            <div class="add-event-form">
                <?php if (!empty($succ)): ?>
                    <p class="success-message"><?php echo $succ; ?></p>
                <?php endif; ?>
                <?php if (!empty($error)): ?>
                    <p class="error-message"><?php echo $error; ?></p>
                <?php endif; ?>
                <form method="POST">
                    <h2 style="text-align: center;">Add Event</h2>
                    <label for="title">Event Title:</label>
                    <input type="text" name="title" required>

                    <label for="type">Event Type:</label>
                    <input type="text" name="type" required>

                    <label for="description">Description:</label>
                    <input id="description" name="description" required>

                    <label for="date">Event Date:</label>
                    <input type="date" name="date" required>

                    <label for="location">Location:</label>
                    <input type="text" name="location" required>

                    <label for="places_dispo">Places Available:</label>
                    <input type="number" name="places_dispo" required>


                    <label for="img">Image URL:</label>
                    <input type="text" name="img">

                    <button type="submit">Add Event</button>
                </form>
            </div>
        <?php endif; ?>
        <?php if (!empty($succ)): ?>
            <p class="success-message"><?php echo $succ; ?></p>
        <?php endif; ?>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Event Title</th>
                    <th>Date</th>
                    <th>Location</th>
                    <th>Seats</th>
                    <th>Organized by</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($events)): ?>
                    <?php foreach ($events as $event): ?>
                        <tr>
                            <td><?php echo $event['id']; ?></td>
                            <td><?php echo $event['title']; ?></td>
                            <td><?php echo date("F j, Y", strtotime($event['date'])); ?></td>
                            <td><?php echo $event['location']; ?></td>
                            <td><?php echo $event['places_dispo']; ?></td>
                            <td><?php echo $event['organisateur']; ?></td>
                            <td>
                                <a href="../services/edit.php?id=<?php echo $event['id'] ?>"><button
                                    class="edit">Edit</button></a>
                                <a href="../services/delete.php?id=<?php echo $event['id'] ?>"><button
                                        class="delete">Delete</button></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" style="text-align:center;">No Events found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

    </div>
</body>
<script src="scrip.js"></script>

</html>