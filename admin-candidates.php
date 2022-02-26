<?php
session_start();
require_once('common/components.php');
include('common/website_info.php');
?>

<!DOCTYPE html>
<html lang="en">
<?= head("Admin Dashboard: Candidates"); ?>

<body>
    <div class="row">
        <div class="col-lg-3">
            <?=sidebar("candidate")?>
        </div>
        <div class="col-lg-9">
            <main class="admin">
                <h1>Content Here</h1>
            </main>
        </div>
    </div>

    <?= footer() ?>
    <script src="js/bootstrap.bundle.js"></script>
</body>

</html>