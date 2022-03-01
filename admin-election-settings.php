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
        <div class="col-xl-2 col-lg-3 col-md-4">
            <?= sidebar("settings") ?>
        </div>
        <div class="col-xl-10 col-lg-9 col-md-8">
            <main class="admin">
                <div class="container">
                    <h1>Election Settings</h1>
                    <hr>
                    <div class="admin card">
                        <form action="" method="POST">
                            <h5>Set Election Opening</h5>
                            <input type="datetime-local" class="date my-2">
                            <h5 class="mt-2">Set Election Closing</h5>
                            <input type="datetime-local" class="my-2"> <br>
                            <button type="submit" name="submit" class="btn btn-default mt-2">Submit</button>
                        </form>
                    </div>
                </div>
            </main>
        </div>
    </div>
    <script src="js/bootstrap.bundle.js"></script>
</body>

</html>