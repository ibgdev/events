<?php
session_start();
require "./services/config.php";

$error = '';
$events = [];

try {
    $dsn = "mysql:host=$HOST;dbname=$DB_NAME;charset=utf8";
    $mysqlclient = new PDO($dsn, $USER, $PASSWD, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

    $SQLquery = "SELECT events.*, users.full_name AS organisateur FROM events
            JOIN users ON events.organiser_id = users.id
            ORDER BY date asc";
    $RS = $mysqlclient->prepare($SQLquery);
    $RS->execute();

    $events = $RS->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    $error = "Connection failed: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Events</title>
    <link rel="shortcut icon" href="imgs/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="./styles/eventstyle.css">
</head>

<body>
    <?php include "pages/navbar.php"; ?>
    <section class="hero">
        <h1>Welcome to Our Events</h1>
        <p>Discover a variety of events tailored to your interests. Connect, learn, and grow with our community.</p>
    </section>

    <div class="search-bar">
        <?php include("./pages/searchbar.php") ?>
    </div>

    <section id="event-container" class="events">
        <?php if (!empty($events)): ?>
            <?php foreach ($events as $event): ?>
                <div class="event-card" data-title="<?php echo strtolower($event['title']); ?>" data-location="<?php echo strtolower($event['location']); ?>" data-date="<?php echo $event['date']; ?>">
                    <img src="<?php echo $event['img']; ?>" alt="Event Image">
                    <div class="event-card-content">
                        <h3><?php echo $event['title']; ?></h3>
                        <p><?php echo $event['description']; ?></p>
                        <p><strong>Type: </strong><?php echo $event['type']; ?></p>
                        <p><strong>Organized by: </strong><?php echo $event['organisateur']; ?></p>
                        <p><strong>Date: </strong><?php echo date("F j, Y", strtotime($event['date'])); ?></p>
                        <p><strong>Location: </strong><?php echo $event['location']; ?></p>
                        <p><strong>Available Places: </strong><?php echo $event['places_dispo']; ?></p>
                        <a href="reserve.php?id=<?php echo $event['id'] ?>">Reserve now</a>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No events available at the moment. Please check back later.</p>
        <?php endif; ?>
    </section>

    <?php include('./pages/footer.php'); ?>

    <script src="./scripts/search.js"></script>
</body>

</html>