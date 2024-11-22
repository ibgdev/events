<?php 
    session_start();
    if (!isset($_SESSION["user_id"])) {
        header("Location: login.php");
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $_SESSION["name"]; ?> - Profile</title>
    <link rel="stylesheet" href="../styles/profilestyle.css">
    <link rel="shortcut icon" href="imgs/logo.png" type="image/x-icon">
</head>
<body>
    <?php include "./pages/navbar.php"; ?>

    <main class="profile-container">
        <section class="profile-hero">
            <h1>Welcome, <?php echo $_SESSION["name"]; ?>!</h1>
            <p>Manage your profile and settings with ease.</p>
        </section>

        <!-- Profile Details Card -->
        <section class="profile-card">
            <div class="profile-details">
                <h2>Profile Information</h2>
                <p><strong>Name:</strong> <?php echo $_SESSION["name"]; ?></p>
                <p><strong>Email:</strong> <?php echo $_SESSION["email"]; ?></p>
                <p><strong>Phone:</strong> <?php echo $_SESSION["phone"]; ?></p>
            </div>
            <div class="profile-actions">
                <a href="" class="mc-button">Edit Profile</a>
                <a href="./services/logout.php" class="mc-button logout-btn">Logout</a>
            </div>
        </section>

        <!-- Change Password Section -->
        <section class="change-password">
            <h2>Change Password</h2>
            <form action="update-password.php" method="POST" class="password-form">
                <div class="form-group">
                    <label for="current-password">Current Password:</label>
                    <input type="password" name="current_password" placeholder="**********" required>
                </div>
                <div class="form-group">
                    <label for="new-password">New Password:</label>
                    <input type="password" name="new_password" placeholder="**********" required>
                </div>
                <div class="form-group">
                    <label for="confirm-password">Confirm New Password:</label>
                    <input type="password" name="confirm_password" placeholder="**********" required>
                </div>
                <button type="submit" class="mc-button">Update Password</button>
            </form>
        </section>
    </main>
</body>
</html>
