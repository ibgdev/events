<?php
session_start();
require "../services/config.php";

if (!isset($_SESSION["user_id"]) || $_SESSION["user_id"] != 1) {
    header("Location: ./login.php");
    exit();
}

$error = '';
$events = [];
$reservations = [];
$users = [];


try {
    $dsn = "mysql:host=$HOST;dbname=$DB_NAME;charset=utf8";
    $mysqlclient = new PDO($dsn, $USER, $PASSWD, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

    // Fetch Events
    $SQLquery = "SELECT events.*, users.full_name AS organisateur
                FROM events
        JOIN users ON events.organiser_id = users.id
        ORDER BY date asc";
    $RS = $mysqlclient->prepare($SQLquery);
    $RS->execute();
    $events = $RS->fetchAll(PDO::FETCH_ASSOC);

    // Add new event
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_event'])) {
        // Collect form data
        $title = $_POST['title'];
        $type = $_POST['type'];
        $description = $_POST['description'];
        $date = $_POST['date'];
        $location = $_POST['location'];
        $seats = $_POST['seats'];
        $idO = $_POST['idO'];
        $purl = $_POST['purl'];

        $SQLquery4 = "INSERT INTO events (title, type, description, date, location, places_dispo, organiser_id, img) 
                VALUES (:title, :type, :description, :date, :location, :places_dispo, :organiser_id, :img)";

        $stmt = $mysqlclient->prepare($SQLquery4);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':type', $type);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':date', $date);
        $stmt->bindParam(':location', $location);
        $stmt->bindParam(':places_dispo', $seats);
        $stmt->bindParam(':organiser_id', $idO);
        $stmt->bindParam(':img', $purl);

        if ($stmt->execute()) {
            $SQLquery = "SELECT events.*, users.full_name AS organisateur
                    FROM events
                    JOIN users ON events.organiser_id = users.id
                    ORDER BY date asc";
            $RS = $mysqlclient->prepare($SQLquery);
            $RS->execute();
            $events = $RS->fetchAll(PDO::FETCH_ASSOC);
        } else {
            $error = "Failed to add event.";
        }
    }

    // Fetch Reservations 
    $SQLquery2 = "SELECT reservations.*, users.full_name AS customer_name, events.title AS event_title
                FROM reservations
                JOIN users ON reservations.user_id = users.id
                JOIN events ON reservations.event_id = events.id
                ORDER BY reservation_date DESC";
    $RS2 = $mysqlclient->prepare($SQLquery2);
    $RS2->execute();
    $reservations = $RS2->fetchAll(PDO::FETCH_ASSOC);

    // Fetch Users
    $SQLquery3 = "SELECT * FROM users";
    $RS3 = $mysqlclient->prepare($SQLquery3);
    $RS3->execute();
    $users = $RS3->fetchAll(PDO::FETCH_ASSOC);

    // Add new user
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_user'])) {
        $full_name = $_POST['full_name'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $phone = $_POST['phone'];

        $SQLquery5 = "INSERT INTO users (full_name, email, password, phone) 
                    VALUES (:full_name, :email, :password, :phone)";
        $stmt = $mysqlclient->prepare($SQLquery5);
        $stmt->bindParam(':full_name', $full_name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':phone', $phone);

        if ($stmt->execute()) {
            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $active_section = 'users';
        } else {
            $error = "Failed to add user.";
            $active_section = 'users';
        }
    } else {
        $active_section = 'events';
    }

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
    <link rel="shortcut icon" href="../imgs/logo.png" type="image/x-icon">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>

<body class="dark-theme">

    <!-- Sidebar -->
    <div class="sidebar">
        <div class="logo">
            <img src="../imgs/logo.png" alt="">
        </div>
        <ul>
            <li><a href="#events" class="active"><i class="fas fa-calendar-alt"></i> Events</a></li>
            <li><a href="#reservations"><i class="fas fa-book"></i> Reservations</a></li>
            <li><a href="#users"><i class="fas fa-users"></i> Users</a></li>
            <li><a href="../index.php"><i class="fas fa-home"></i> Main website</a></li>
            <li><a href="#" id="logoutButton" class="logout"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="content">

        <!-- Event section -->
        <section id="events" class="section <?php echo ($active_section == 'events') ? 'active' : ''; ?>">
            <h1>Events</h1>
            
            <!-- Add New Event Form -->
            <form method="POST" action="">
                <h2 style="text-align:center;">Add New Event</h2>
                <label for="title">Event Title</label>
                <input type="text" name="title" required>

                <label for="type">Event Type</label>
                <input type="text" name="type" required>

                <label for="description">Event description</label>
                <input type="text" name="description" required>

                <label for="date">Event Date</label>
                <input type="date" name="date" required>

                <label for="location">Location</label>
                <input type="text" name="location" required>

                <label for="seats">Seats available</label>
                <input type="text" name="seats" required>

                <label for="location">Organiser id</label>
                <input type="text" name="idO" required>

                <label for="location">Picture url</label>
                <input type="text" name="purl" required>

                <button type="submit" name="add_event">Add Event</button>
            </form>

            <!-- Show Events -->
            <table class="event-table">
                <thead>
                    <tr>
                        <th>id</th>
                        <th>Event Title</th>
                        <th>Date</th>
                        <th>Location</th>
                        <th>Organized by</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($events as $event): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($event['id']); ?></td>
                            <td><?php echo htmlspecialchars($event['title']); ?></td>
                            <td><?php echo date("F j, Y", strtotime($event['date'])); ?></td>
                            <td><?php echo htmlspecialchars($event['location']); ?></td>
                            <td><?php echo htmlspecialchars($event['organisateur']); ?></td>
                            <td><?php echo htmlspecialchars($event['places_dispo']); ?></td>
                            <td>
                                <button class="edit">Edit</button>
                                <button class="delete">Delete</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>

        <!-- Reservations  Section -->
        <section id="reservations" class="section">
            <h1>Reservation Moderation</h1>
            <table class="reservation-table">
                <thead>
                    <tr>
                        <th>id</th>
                        <th>Event Title</th>
                        <th>Customer</th>
                        <th>Seats</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($reservations as $reservation): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($reservation['id']); ?></td>
                            <td><?php echo htmlspecialchars($reservation['event_title']); ?></td>
                            <td><?php echo htmlspecialchars($reservation['customer_name']); ?></td>
                            <td><?php echo htmlspecialchars($reservation['seats']); ?></td>
                            <td><?php echo htmlspecialchars($reservation['status']); ?></td>
                            <td>
                                <button class="edit">Edit</button>
                                <button class="delete">Cancel</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>

        <!-- Users Section -->
        <section id="users" class="section <?php echo ($active_section == 'users') ? 'active' : ''; ?>">
            <h1>User Moderation</h1>

            <!-- Add New User Form -->
            <form method="POST" action="">
                <h2 style="text-align:center;">Add New User</h2>
                <label for="full_name">Full Name</label>
                <input type="text" name="full_name" required>

                <label for="email">Email</label>
                <input type="email" name="email" required>

                <label for="password">Password</label>
                <input type="password" name="password" required>

                <label for="phone">Phone</label>
                <input type="text" name="phone" required>

                <button type="submit" name="add_user">Add User</button>
            </form>

            <!-- Show all Users -->
            <table class="user-table">
                <thead>
                    <tr>
                        <th>id</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Password</th>
                        <th>Phone</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($user['id']); ?></td>
                            <td><?php echo htmlspecialchars($user['full_name']); ?></td>
                            <td><?php echo htmlspecialchars($user['email']); ?></td>
                            <td><?php echo htmlspecialchars(hash("md5", $user['password'])); ?></td>
                            <td><?php echo htmlspecialchars($user['phone']); ?></td>
                            <td>
                                <button class="edit">Edit</button>
                                <button class="delete">Deactivate</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

        </section>
    </div>
    <script src="script.js"></script>

</body>

</html>