<?php
include 'website_info.php';
?>
<ul class="nav nav-pills flex-column px-2 py-4 sidebar">
    <li class="nav-item brand">
        <a class="nav-link" href="index.php">
            <img src="images/logo.png" alt="logo">
            <span><?= $website_name; ?></span>
        </a>
    </li>
    <hr>
    <li class="nav-item">
        <a class="nav-link <?php if ($page === 'dashboard') echo ' active'; ?>" href="admin-dashboard.php">
            <span class="bi-speedometer"></span> Admin Dashboard</a>
    </li>
    <li class="nav-item">
        <a class="nav-link <?php if ($page === 'party') echo ' active'; ?>" href="admin-partylist.php">
            <span class="bi-list"></span> Partylists</a>
    </li>
    <li class="nav-item">
        <a class="nav-link <?php if ($page === 'candidate') echo ' active'; ?>" href="admin-candidates.php">
            <span class="bi-person"></span> Candidates</a>
    </li>
    <li class="nav-item">
        <a class="nav-link <?php if ($page === 'settings') echo ' active'; ?>" href="admin-election-settings.php">
            <span class="bi-gear"></span> Election Settings</a>
    </li>
    <hr>
    <a href="utils/logout.php" class="btn btn-outline-danger mx-4">Log Out</a>
</ul>';