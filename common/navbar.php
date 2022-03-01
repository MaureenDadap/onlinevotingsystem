<?php
include("website_info.php");
?>

<nav class="navbar navbar-expand-lg" role="navigation">
    <div class="container">
        <a href="index.php" class="navbar-brand d-flex align-items-center">
            <img src="images/logo.png" alt="logo" class="d-inline-block align-top">
            <span><?= $website_name; ?></span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#myNavbar" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"><i class="bi-list"></i></span>
        </button>

        <div class="collapse navbar-collapse" id="myNavbar">
            <?php
            if (isset($_SESSION['user_type'])) {
                if ($_SESSION['user_type'] === 'admin') { //if admin 
            ?>
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a href="admin-dashboard.php" class="nav-link <?php if ($page === " dashboard") echo ' active' ?>">
                                <span class="bi-speedometer"></span> Admin Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a href="utils/logout.php" class="btn btn-danger">Log out</a>
                        </li>
                    </ul>
                <?php } else if ($_SESSION['user_type'] === 'student') { //if student
                ?>
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item"><a href="candidates-list.php" class="nav-link <?php if ($page === "candidates") echo ' active' ?>">
                                <span class="bi-people-fill"></span> Candidates</a></li>
                        <li class="nav-item"><a href="voting.php" class="nav-link <?php if ($page === "voting") echo ' active' ?>">
                                <span class="bi-clipboard-check-fill"></span> Voting Ballot
                            </a></li>
                        <li class="nav-item">
                            <a href="utils/logout.php" class="btn btn-danger">Log out</a>
                        </li>
                    </ul>
                <?php }
            } else { ?>
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Sign Up
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="admin-signup.php">Admin Sign Up</a></li>
                            <li><a class="dropdown-item" href="student-signup.php">Student Sign Up</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="login.php" class="btn btn-default">Login</a>
                    </li>
                </ul> <?php } ?>
        </div>
    </div>
</nav>