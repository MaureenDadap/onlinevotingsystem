<?php
session_start();
require_once('common/components.php');
include('common/website_info.php');
?>

<!DOCTYPE html>
<html lang="en">
<?= head("Candidates List"); ?>

<body>
    <?= navbar("candidates"); ?>
    <main></main>
    <?=footer()?>  
    <script src="js/bootstrap.bundle.js"></script>
</body>
</html>