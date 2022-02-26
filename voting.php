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
    <?php
    if (isset($_SESSION['user_type'])) {
        if ($_SESSION['user_type'] === 'admin') { ?>
            <main>
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col">
                            <h1>You do not have access to this page.</h1>
                            <h5>Only students can vote.</h5>
                        </div>
                        <div class="col">
                            <img src="images/sammy-17.png" alt="error" class="w-100">
                        </div>
                    </div>
                </div>
            </main>
        <?php
        } else { ?>
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
                    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                        <div class="card candidate p-4">
                            <img src="images/college-student-budget.jpg" class="candidate-img" alt="candidate">
                            <div class="card-body">
                                <h5 class="card-title">Jane Doe</h5>
                                <p class="card-text">I am going to make this university great again</p>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        <?php }
    } else { ?>
        <main>
            <div class="container">
                <div class="row align-items-center">
                    <div class="col">
                        <h1>You do not have access to this page.</h1>
                        <h5>Log in as a student to vote.</h5>
                    </div>
                    <div class="col">
                        <img src="images/sammy-17.png" alt="error" class="w-100">
                    </div>
                </div>
            </div>
        </main>
    <?php } ?>

    <?php include 'common/footer.php';?>
    <script src="js/bootstrap.bundle.js"></script>
    <script>
        window.onbeforeunload = function() {
            return 'Are you sure? Your work will be lost. ';
        };
    </script>
</body>

</html>