<?php
session_start();
require_once('common/components.php');
include('common/website_info.php');
?>

<!DOCTYPE html>
<html lang="en">
<?= head("Voting Ballot"); ?>

<body>
    <?= navbar("voting"); ?>
    <header class="results py-3">
        <div class="container">
            <div class="row justify-content-center align-items-center">
                <div class="col-md-3">
                    <img src="images/sammy-25.png" alt="img" class="w-100">
                </div>
                <div class="col-md-3">
                    <h1>Voting</h1>
                </div>
            </div>
        </div>
    </header>
    <main>
        <div class="container">
            <h3>President</h3>
            <div class="row row-cols-1 row-cols-md-4 g-4">
                <div class="card w-">
                    <img src="images/college-student-budget.jpg" class="img-fluid card-img-top" alt="candidate">
                    <div class="card-body">
                        <h5 class="card-title">Jane Doe</h5>
                        <p class="card-text">I am going to make this university great again</p>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <?= footer() ?>
    <script src="js/bootstrap.bundle.js"></script>
    <script>
        window.onbeforeunload = function() {
            return 'Are you sure? Your work will be lost. ';
        };
    </script>
</body>

</html>