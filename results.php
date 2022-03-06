<?php
session_start();
date_default_timezone_set('Asia/Manila');
require_once('common/components.php');
require_once 'config/website_info.php';
require_once 'utils/get-election-times.php';
require_once 'utils/get-votes.php';

$startDate = date('M d, Y g:i A', strtotime(getStartDate()));
$endDate = date('M d, Y g:i A', strtotime(getEndDate()));
$date = date('M d, Y', time());

$totalVotes = countVotes();
?>

<!DOCTYPE html>
<html lang="en">
<?= head("Results"); ?>

<body>
    <?= navbar(""); ?>
    <?php if (($date >= $startDate) || ($date <= $endDate)) : //if election is still ongoing 
    ?>
        <main>
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-7">
                        <h1>Elections are still ongoing.</h1>
                        <h5>Come back later after the election closes at <?= $endDate ?></h5>
                    </div>
                    <div class="col-md-5">
                        <img src="images/sammy-17.png" alt="error" class="w-100">
                    </div>
                </div>
            </div>
        </main>
    <?php else : //if election is already closed 
    ?>
        <header class="results py-3">
            <div class="container">
                <div class="row justify-content-center align-items-center">
                    <div class="col-md-3">
                        <img src="images/sammy-marketing.png" alt="img" class="w-100">
                    </div>
                    <div class="col-md-4">
                        <h1>Election Results</h1>
                        <p><strong>Election duration: </strong><?= $startDate ?> - <?= $endDate ?><br>
                            <strong>Total Votes: </strong><?= $totalVotes ?>
                        </p>
                    </div>
                </div>
            </div>
        </header>
        <main class="results">
            <div class="container">
                <div class="row text-center justify-content-center my-4">
                    <?= resultsCandidate("President", "Jane Doe", "images/college-student-budget.jpg", "BSCS191A"); ?>
                </div>
                <hr>
                <div class="row text-center justify-content-center my-4">
                    <?= resultsCandidate("Vice President", "Jane Doe", "images/college-student-budget.jpg", "BSCS191A"); ?>
                </div>
                <hr>
                <div class="row text-center justify-content-center my-4 gy-4">
                    <?= resultsCandidate("Secretary", "Jane Doe", "images/college-student-budget.jpg", "BSCS191A"); ?>
                    <?= resultsCandidate("Treasurer", "Jane Doe", "images/college-student-budget.jpg", "BSCS191A"); ?>
                </div>
                <hr>
                <div class="row text-center justify-content-center my-4 gy-4">
                    <?= resultsCandidate("1st Year Representative", "Jane Doe", "images/college-student-budget.jpg", "BSCS191A"); ?>
                    <?= resultsCandidate("2nd Year Representative", "Jane Doe", "images/college-student-budget.jpg", "BSCS191A"); ?>
                    <?= resultsCandidate("3rd Year Representative", "Jane Doe", "images/college-student-budget.jpg", "BSCS191A"); ?>
                    <?= resultsCandidate("4th Year Representative", "Jane Doe", "images/college-student-budget.jpg", "BSCS191A"); ?>
                </div>
            </div>
        </main>
    <?php endif ?>
    <?php include 'common/footer.php'; ?>
    <script src="js/bootstrap.bundle.js"></script>
</body>

</html>