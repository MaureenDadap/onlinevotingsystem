<?php
session_start();
require_once('common/components.php');
include('common/website_info.php');
require_once 'utils/get-candidates.php';
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
                <div class="container voting">
                    <form action="" method="POST">
                        <!-- ======= Presidents Row ======= -->
                        <h3 class="text-center">President</h3>
                        <?php
                        if (getCandidates('President') && getCandidates('President')->num_rows > 0) { ?>
                            <div class="d-flex justify-content-center mb-5">
                                <?php
                                $result = getCandidates("President");
                                while ($data = $result->fetch_assoc()) {
                                ?>
                                    <div class="voting card m-3">
                                        <img src="<?php echo $data['image_path'] ?>" class="h-75 candidate-img" alt="candidate-img">
                                        <div class="form-check align-self-center m-3">
                                            <input class="form-check-input" type="radio" name="president" value="<?php echo $data['id'] ?>">
                                            <label class="form-check-label"><?php echo $data['first_name'] . ' ' . $data['last_name'] ?></label>
                                        </div>
                                    </div>
                                <?php  } ?>
                            </div> <?php } else { ?>

                            <h5 class="py-5 text-center">No candidates in the database.</h5>
                        <?php  } ?>
                        <!-- End Presidents Row -->
                        
                        <div class="d-flex justify-content-center">
                            <button type="submit" class="btn btn-default" name="submit">Submit my Vote</button>
                        </div>
                    </form>
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

    <?php include 'common/footer.php'; ?>
    <script src="js/bootstrap.bundle.js"></script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script>
        window.onbeforeunload = function() {
            return 'Are you sure? Your work will be lost. ';
        };
    </script>
</body>

</html>