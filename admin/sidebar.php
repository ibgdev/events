<div class="sidebar">
    <div class="logo">
        <a href="dashboard.php"><img src="../imgs/logo.png" alt=""></a>
    </div>
    <ul>
        <li><a href="events.php"
                class="<?php echo (basename($_SERVER['PHP_SELF']) == 'events.php') ? 'active' : ''; ?>"><i
                    class="fas fa-calendar-alt"></i> Events</a></li>
        <li><a href="reservations.php"
                class="<?php echo (basename($_SERVER['PHP_SELF']) == 'reservations.php') ? 'active' : ''; ?>"><i
                    class="fas fa-book"></i> Reservations</a></li>
        <?php if ($_SESSION["user_id"] == 1): ?>
            <li><a href="users.php"
                    class="<?php echo (basename($_SERVER['PHP_SELF']) == 'users.php') ? 'active' : ''; ?>"><i
                        class="fas fa-users"></i> Users</a></li>
        <?php endif; ?>
        <li><a href="../index.php"><i class="fas fa-home"></i> Main website</a></li>
        <li><a href="../services/logout.php" class="logout"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
    </ul>

    <label class="switch">
        <input type="checkbox" id="themeSwitch">
        <span class="slider round">
            <i class="fas fa-sun day-icon"></i>
            <i class="fas fa-moon night-icon"></i>
        </span>
    </label>
</div>
<script src="scrip.js"></script>
