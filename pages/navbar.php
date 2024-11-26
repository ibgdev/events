<link rel="stylesheet" href="./styles/navstyle.css">
<header>
    <img class="logo" src="../imgs/logo.png" alt="GDSC Logo">
    <nav>
        <ul class="nav__links">
            <li><a href="../index.php">Home</a></li>
            <li><a href="../events.php">Events</a></li>
            <li><a href="mailto:ibrahimghorbali605@gmail.com">Contact</a></li>
            <?php
            
            if (isset($_SESSION["user_id"])) {
                if ($_SESSION["org"] == 1) {
                    echo '<li><a href="../admin/dashboard.php">Dashbord</a></li>';
                }
                echo '<li class="profile"><a href="../profile.php"><button><svg xmlns="http://www.w3.org/2000/svg" height="19px" viewBox="0 0 24 24" width="19px" fill="#e8eaed" style="padding-top: 4px;"><path d="M12 12c2.2 0 4-1.8 4-4s-1.8-4-4-4-4 1.8-4 4 1.8 4 4 4zM12 13c-3.3 0-6 2.7-6 6v1h12v-1c0-3.3-2.7-6-6-6z"/></svg>' . $_SESSION["name"] .'</button></a>
                    <ul class="dropdown">
                        <li><a href="../services/logout.php"><button>Logout <svg xmlns="http://www.w3.org/2000/svg" height="16px" viewBox="0 -960 960 960" width="16px" fill="#e8eaed"><path d="M200-120q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h280v80H200v560h280v80H200Zm440-160-55-58 102-102H360v-80h327L585-622l55-58 200 200-200 200Z"/></svg></button></a></li>
                    </ul>
                </li>';
            } else {
                echo '<li><a href="../login.php">Login</a></li>';
                echo '<a class="cta" href="../register.php"><button>Register</button></a>';
            }
            ?>
        </ul>
    </nav>
</header>