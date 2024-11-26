<?php
session_start();
require "./services/config.php";
$error = '';
$events = [];



try {
    $dsn = "mysql:host=$HOST;dbname=$DB_NAME;charset=utf8";
    $mysqlclient = new PDO($dsn, $USER, $PASSWD, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

    $SQLquery = "SELECT events.*, users.full_name AS organisateur
                FROM events
        JOIN users ON events.organiser_id = users.id
        ORDER BY date asc";
    $RS = $mysqlclient->prepare($SQLquery);
    $RS->execute();

    $events = $RS->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    $error = "Connection failed: " . $e->getMessage();
}
if (sizeof($events) >= 3) {
    $up = 3;
}else{
    $up = sizeof($events);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Reservation</title>
    <link rel="stylesheet" href="./styles/indexstyle.css">
    <link rel="shortcut icon" href="imgs/logo.png" type="image/x-icon">
</head>

<body>
    <nav>
        <?php include(__DIR__.'/pages/navbar.php'); ?>
    </nav>
    <!-- Main Content -->
    <section class="intro">
        <h1>Welcome to Our Event Reservation Website</h1>
        <p>Book your tickets for exciting upcoming events.</p>
        <a href="events.php" class="mc-button">Start Booking</a>
        
    </section>

    <!-- Upcoming Events -->
    <h1 class="up">Upcoming Events</h1>
    <section class="events">
        <?php if (!empty($events)): ?>
            <?php for ($i = 0; $i < $up; $i++): ?>
                <div class="event-card">
                    <img src="<?php echo $events[$i]['img']; ?>" alt="Event Image">
                    <div class="event-card-content">
                        <h3><?php echo $events[$i]['title']; ?></h3>
                        <p><?php echo $events[$i]['description']; ?></p><br>
                        <p><strong>Type : </strong> <?php echo $events[$i]['type']; ?></p>
                        <p><strong>Organized by : </strong> <?php echo $events[$i]['organisateur']; ?></p>
                        <p><strong>Date : </strong> <?php echo date("F j, Y", strtotime($events[$i]['date'])); ?></p>
                        <p><strong>Location : </strong> <?php echo $events[$i]['location']; ?></p>
                        <p><strong>Available Places : </strong> <?php echo $events[$i]['places_dispo']; ?></p>
                        <a href="#">Reserve now</a>
                    </div>
                </div>
            <?php endfor; ?>
        <?php else: ?>
            <p>No events available at the moment. Please check back later.</p>
        <?php endif; ?>
    </section>
    <?php include('./pages/footer.php'); ?>
</body>

</html>