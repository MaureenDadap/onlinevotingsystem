<?php
session_start();
require_once('common/components.php');
include('common/website_info.php');
?>

<!DOCTYPE html>
<html lang="en">
<?= head("Admin Dashboard: Candidates"); ?>

<body class="admin">
    <div class="admin row">
        <div class="col-lg-3">
            <?= sidebar("candidate") ?>
        </div>
        <div class="col-lg-9">
            <main class="admin">
                <div class="container">
                    <h1>Election Candidates</h1>
                </div>
            </main>
        </div>
    </div>
    <script src="js/bootstrap.bundle.js"></script>
</body>

</html>