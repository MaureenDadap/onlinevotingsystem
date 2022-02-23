<?php
require_once('common/components.php');
include('common/website_info.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>

    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/styles.css">
</head>

<body class="landing">
    <?= navbar("") ?>

    <div class="hero">
        <div class="container py-5">
            <div class="row justify-content-center align-items-center">
                <div class="col-md ">
                    <h1 class="display-1"><?= $website_name ?></h1>
                    <p class="lead">We are bringing the student council elections closer to you. <br>
                        Smooth. Efficient. Secure.</p>
                </div>
                <div class="col-md">
                    <img src="images/undraw_voting_nvu7.svg" alt="">
                </div>
            </div>
        </div>
    </div>
    <main>
        <div class="container">
            <div class="row justify-content-center my-3 text-center">
                <div class="col-8 shadow-md py-4">
                    <h2>The student council election is ongoing</h2>
                    <p>Open from February 15, 2022 - February 16, 2022</p>
                    <a href="voting.php" class="btn btn-lg btn-primary">Go to voting form</a>
                </div>
            </div>
        </div>
    </main>

    <footer>
        <div class="container">
            <div class="row justify-content-center py-5 text-center">
                <h4 class="display-3"><?=$website_name?></h4>
                <p class="lead">We bring the elections closer to you.</p>
            </div>
        </div>
    </footer>

    <script src="js/bootstrap.bundle.js"></script>

</body>

</html>