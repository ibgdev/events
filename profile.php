<?php
session_start();
require "./services/config.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

// Initialize variables
$updateSuccess = false;
$errorMessage = "";

// Handle profile update form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['name'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $userId = $_SESSION["user_id"];

    try {
        // Connect to the database
        $dsn = "mysql:host=$HOST;dbname=$DB_NAME;charset=utf8";
        $mysqlclient = new PDO($dsn, $USER, $PASSWD, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

        // Update user details
        $updateQuery = "UPDATE users SET full_name = :name, email = :email, phone = :phone WHERE id = :userId";
        $stmt = $mysqlclient->prepare($updateQuery);
        $stmt->execute([
            ':name' => $name,
            ':email' => $email,
            ':phone' => $phone,
            ':userId' => $userId,
        ]);

        // Update session data
        $_SESSION["name"] = $name;
        $_SESSION["email"] = $email;
        $_SESSION["phone"] = $phone;

        $updateSuccess = true;
    } catch (PDOException $e) {
        $errorMessage = "Failed to update profile: " . $e->getMessage();
    }
}

// Handle password update form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['current_password'])) {
    $currentPassword = $_POST['current_password'];
    $newPassword = $_POST['new_password'];
    $confirmPassword = $_POST['confirm_password'];
    $userId = $_SESSION["user_id"];

    // Validate the new password
    if ($newPassword !== $confirmPassword) {
        $errorMessage = "New password and confirmation password do not match.";
    } else {
        try {
            // Connect to the database
            $dsn = "mysql:host=$HOST;dbname=$DB_NAME;charset=utf8";
            $mysqlclient = new PDO($dsn, $USER, $PASSWD, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

            // Get the current password from the database
            $query = "SELECT password FROM users WHERE id = :userId";
            $stmt = $mysqlclient->prepare($query);
            $stmt->execute([':userId' => $userId]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && $currentPassword === $user['password']) {
                // Update password in the database without hashing (not secure in real-world applications)
                $updatePasswordQuery = "UPDATE users SET password = :password WHERE id = :userId";
                $stmt = $mysqlclient->prepare($updatePasswordQuery);
                $stmt->execute([
                    ':password' => $newPassword,
                    ':userId' => $userId,
                ]);

                $updateSuccess = true;
            } else {
                $errorMessage = "Current password is incorrect.";
            }
        } catch (PDOException $e) {
            $errorMessage = "Failed to update password: " . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $_SESSION["name"]; ?> - Profile</title>
    <link rel="stylesheet" href="./styles/profilestyle.css">
    <link rel="shortcut icon" href="imgs/logo.png" type="image/x-icon">
</head>

<body>
    <?php include "./pages/navbar.php"; ?>

    <main class="profile-container">
        <section class="profile-hero">
            <h1>Welcome, <?php echo $_SESSION["name"]; ?>!</h1>
            <p>Manage your profile and settings with ease.</p>
        </section>

        <section class="profile-card">
            <div class="profile-details">
                <h2>Profile Information</h2>
                <p><strong>Name:</strong> <?php echo $_SESSION["name"]; ?></p>
                <p><strong>Email:</strong> <?php echo $_SESSION["email"]; ?></p>
                <p><strong>Phone:</strong> <?php echo $_SESSION["phone"]; ?></p>
            </div>
            <div class="profile-actions">
                <a href="./services/logout.php" class="mc-button logout-btn">Logout</a>
            </div>
        </section>

        <section class="edit-profile-section">
            <?php if ($updateSuccess): ?>
                <p class="success-message">Profile updated successfully!</p>
            <?php elseif ($errorMessage): ?>
                <p class="error-message"><?php echo htmlspecialchars($errorMessage); ?></p>
            <?php endif; ?>

            <form action="" method="POST" onsubmit="return confirmUpdate()">
                <h2>Edit Profile</h2>
                <label for="name"><strong>Name: </strong></label>
                <input type="text" name="name" value="<?php echo htmlspecialchars($_SESSION["name"]); ?>" required>

                <label for="email"><strong>Email: </strong></label>
                <input type="email" name="email" value="<?php echo htmlspecialchars($_SESSION["email"]); ?>" required>

                <label for="phone"><strong>Phone: </strong></label>
                <input type="text" name="phone" value="<?php echo htmlspecialchars($_SESSION["phone"]); ?>" required>

                <input type="submit" value="Update">
            </form>

            <script>
                function confirmUpdate() {
                    return confirm("Are you sure you want to update your profile?");
                }
            </script>

        </section>


        <section class="change-password">
            <h2>Change Password</h2>
            <form action="" method="POST" class="password-form" onsubmit="return confirmPasswordChange()">
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

            <script>
                function confirmPasswordChange() {
                    return confirm("Are you sure you want to change your password?");
                }
            </script>
        </section>
    </main>
</body>

</html>
