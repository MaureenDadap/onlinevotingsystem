<?php
session_start();
require_once('common/components.php');
include('config/website_info.php');
?>

<!DOCTYPE html>
<html lang="en">
<?= head("") ?>

<body>
    <?= navbar("") ?>
    <?php include 'common/footer.php' ?>
</body>
</html>