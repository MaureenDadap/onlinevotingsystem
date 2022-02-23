<?php
session_start();
require_once('common/components.php');
include('common/website_info.php');
?>

<!DOCTYPE html>
<html lang="en">
<?= head("Admin Dashboard"); ?>

<body>
    <?= navbar("dashboard"); ?>
    <main></main>
    <?=footer()?>  
    <script src="js/bootstrap.bundle.js"></script>
</body>
</html>