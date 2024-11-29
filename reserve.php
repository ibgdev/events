<?php
session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}
require_once "./services/connect.php";

$SQLquery = "SELECT events.*, users.full_name AS Organiser FROM events
            JOIN users ON events.organiser_id = users.id
            WHERE events.id=:id";
$res = $mysqlclient->prepare($SQLquery);
$res->execute([
    "id" => $_GET['id']
]);

$event = $res->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="imgs/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="./styles/reservestyle.css">
    <title>Reservation</title>
</head>

<body>
    <?php include_once "./pages/navbar.php" ?>
    <div class="Event-container">
        <img src="<?php echo $event['img'] ?>" alt="<?php echo $event['title'] ?>" class="image-details">
        <div class="Event-details">
            <h2 class="title-details"><?php echo $event['title'] ?></h2>
            <p><?php echo $event['description'] ?></p>
            <p><strong>Type : </strong> <?php echo $event['type']; ?></p>
            <p><strong>Organized by : </strong> <?php echo $event['Organiser']; ?></p>
            <p><strong>Date : </strong> <?php echo date("F j, Y", strtotime($event['date'])); ?></p>
            <p><strong>Location : </strong> <?php echo $event['location']; ?></p>
            <p><strong>Available Places : </strong> <?php echo $event['places_dispo']; ?></p>
            <form action="./services/conf-res.php?id=<?= $_GET['id'] ?>" method="post">
                <fieldset>
                    <legend>Reservation</legend>
                    <label for="email">Name: </label><input type="text" name="name"
                        value="<?= $_SESSION['name'] ?>">
                    <label for="email">Email: </label><input type="email" name="email"
                        value="<?= $_SESSION['email'] ?>">
                    <label for="email">Number of seats: </label><input type="number" name="nbp" value="1">
                    <input type="submit" value="Confirm Reservation">
                </fieldset>
            </form>
        </div>
    </div>
    <?php include_once "./pages/footer.php" ?>
</body>


</html>