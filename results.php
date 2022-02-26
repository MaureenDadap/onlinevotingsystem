<?php
session_start();
require_once('common/components.php');
include('common/website_info.php');
?>

<!DOCTYPE html>
<html lang="en">
<?= head("Results"); ?>

<body>
    <?= navbar(""); ?>
    <header class="results py-3">
        <div class="container">
            <div class="row justify-content-center align-items-center">
                <div class="col-md-3">
                    <img src="images/sammy-marketing.png" alt="img" class="w-100">
                </div>
                <div class="col-md-4">
                    <h1>Election Results</h1>
                    <p><strong>Election duration: </strong>February 15, 2022 - February 16, 2022 <br>
                        <strong>Total Votes: </strong>500
                    </p>
                </div>
            </div>
        </div>
    </header>
    <main class="results">
        <div class="container">
            <div class="row text-center justify-content-center my-4">
               <?=resultsCandidate("President", "Jane Doe", "images/college-student-budget.jpg", "BSCS191A");?>
            </div>
            <hr>
            <div class="row text-center justify-content-center my-4">
               <?=resultsCandidate("Vice President", "Jane Doe", "images/college-student-budget.jpg", "BSCS191A");?>
            </div>
            <hr>
            <div class="row text-center justify-content-center my-4 gy-4">
               <?=resultsCandidate("Secretary", "Jane Doe", "images/college-student-budget.jpg", "BSCS191A");?>
               <?=resultsCandidate("Treasurer", "Jane Doe", "images/college-student-budget.jpg", "BSCS191A");?>
            </div>
            <hr>
            <div class="row text-center justify-content-center my-4 gy-4">
               <?=resultsCandidate("Representative", "Jane Doe", "images/college-student-budget.jpg", "BSCS191A");?>
               <?=resultsCandidate("Representative", "Jane Doe", "images/college-student-budget.jpg", "BSCS191A");?>
               <?=resultsCandidate("Representative", "Jane Doe", "images/college-student-budget.jpg", "BSCS191A");?>
               <?=resultsCandidate("Representative", "Jane Doe", "images/college-student-budget.jpg", "BSCS191A");?>
            </div>
        </div>
    </main>
    <?php include 'common/footer.php';?>
    <script src="js/bootstrap.bundle.js"></script>
</body>

</html>