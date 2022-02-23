<?php
session_start();
require_once('common/components.php');
include('common/website_info.php');
?>

<!DOCTYPE html>
<html lang="en">
<?= head("Home"); ?>

<body class="landing">
    <?= navbar("") ?>
    <div class="hero">
        <div class="container py-5">
            <div class="row justify-content-center align-items-center">
                <div class="col-md">
                    <h1 class="">We bring the student council elections closer to you.</h1>
                    <p class="lead">Available to you even in you own home.
                        <br>Smooth. Efficient. Secure.
                    </p>
                </div>
                <div class="col-md text-center">
                    <img src="images/sammy-34.png" alt="hero image">
                </div>
            </div>
            <div class="row justify-content-center mb-5 text-center">
                <div class="col-8 shadow-lg py-5 mb-5 bg-white">
                    <h2>The student council election is <strong><span class="text-success">ongoing</span></strong></h2>
                    <h5>Open from February 15, 2022 - February 16, 2022</h5>
                    <a href="candidates-list.php" class="my-4 btn btn-lg btn-outline-secondary">View Candidates</a>
                    <a href="voting.php" class="my-4 btn btn-lg btn-default">Vote Here</a>
                </div>
            </div>
        </div>
    </div>
    <?= footer() ?>

    <script src="js/bootstrap.bundle.js"></script>
</body>

</html>