<?php
session_start();
date_default_timezone_set('Asia/Manila');
require_once('common/components.php');
include_once 'config/website_info.php';
require_once 'utils/get-election-times.php';

$startDate = date('M d, Y g:i A', strtotime(getStartDate()));
$endDate = date('M d, Y g:i A', strtotime(getEndDate()));
$date = date('M d, Y', time())
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
                    <h2>The student council election is
                        <?php
                        if ($date >= $startDate || $date <= $endDate) : //if today is not between start and end of election
                            //if ($endDate < $date) :
                        ?>
                            <strong><span class="text-danger">closed</span></strong>
                        <?php else :
                        ?>
                            <strong><span class="text-success">ongoing</span></strong>
                        <?php endif ?>
                    </h2>
                    <h5>Open from <?= $startDate ?> - <?= $endDate ?></h5>
                    <a href="candidates-list.php" class="my-4 btn btn-lg btn-outline-secondary">View Candidates</a>
                    <?php
                    if ($endDate <= $date) : //if election is already done
                    ?>
                        <a href="results.php" class="my-4 btn btn-lg btn-default">View Results</a>
                    <?php elseif ($startDate >= $date) : //if election is not yet open : 
                    ?>
                        <a href="voting.php" class="my-4 btn btn-lg btn-default disabled">Vote Here</a>
                    <?php else :
                    ?>
                        <a href="voting.php" class="my-4 btn btn-lg btn-default">Vote Here</a>
                    <?php endif ?>

                </div>
            </div>
        </div>
    </div>
    <?php include 'common/footer.php'; ?>
    <script src="js/bootstrap.bundle.js"></script>
</body>

</html>