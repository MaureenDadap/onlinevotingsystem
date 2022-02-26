<?php
session_start();
require_once('common/components.php');
include('common/website_info.php');
//hellolllo
// hi
// he
?>

<!DOCTYPE html>

<html lang="en">
<?= head("Admin Dashboard: Election Settings"); ?>

<body class="admin">
    <div class="row">
        <div class="col-lg-3">
            <?= sidebar("settings") ?>
        </div>
        <div class="col-lg-9">
            <main class="admin">
                <div class="container">
                    <h1>Election Settings</h1>
                    <hr>
                </div>
            </main>
        </div>
    </div>
    <script src="js/bootstrap.bundle.js"></script>
</body>

</html>