<?php
session_start();
require "../services/config.php";

if (!isset($_SESSION["user_id"])) {
    session_destroy();
    header("Location: ../login.php");
    exit();
}

if (isset($_GET['id'])) {
    $eventId = $_GET['id'];

    try {
        $dsn = "mysql:host=$HOST;dbname=$DB_NAME;charset=utf8";
        $mysqlclient = new PDO($dsn, $USER, $PASSWD, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

        $query = "SELECT * FROM events WHERE id = :id";
        $res = $mysqlclient->prepare($query);
        $res->execute(['id' => $eventId]);
        $event = $res->fetch(PDO::FETCH_ASSOC);

        if (!$event) {
            header("Location: /admin/dashboard.php?error=Event not found");
            exit();
        }
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $date = $_POST['date'];
    $location = $_POST['location'];
    $picture = $_POST['img'];
    $seats = $_POST['seats'];

    try {
        $dsn = "mysql:host=$HOST;dbname=$DB_NAME;charset=utf8";
        $mysqlclient = new PDO($dsn, $USER, $PASSWD, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

        $query = "UPDATE events SET title = :name, description = :description, date = :date, location = :location, places_dispo = :seats, img = :img WHERE id = :id";
        $res = $mysqlclient->prepare($query);
        $res->execute([
            'name' => $name,
            'description' => $description,
            'date' => $date,
            'location' => $location,
            'seats' => $seats,
            'img' => $picture,
            'id' => $eventId
        ]);

        header("Location: /admin/events.php?message=Event Updated Successfully");
        exit();
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Event</title>
    <link rel="stylesheet" href="edits.css">
</head>

<body>
    <a href="../admin/events.php">Return</a>
    <h2>Edit Event</h2>
    <form action="edit.php?id=<?php echo $eventId; ?>" method="POST">
        <label for="name">Event Name</label>
        <input type="text" id="name" name="name" value="<?php echo $event['title']; ?>" required>

        <label for="description">Description</label>
        <textarea id="description" name="description" required><?php echo $event['description']; ?></textarea>

        <label for="date">Event Date</label>
        <input type="date" name="date" value="<?php echo $event['date']; ?>" required>

        <label for="location">Location</label>
        <input type="text" name="location" value="<?php echo $event['location']; ?>" required>

        <label for="seats">Available seats</label>
        <input type="text" name="seats" value="<?php echo $event['places_dispo']; ?>" required>

        <label for="image">Picture</label>
        <input type="text" name="img" value="<?php echo $event['img']; ?>" required>

        <button type="submit">Update Event</button>
    </form>

</body>

</html>