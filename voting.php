<?php
session_start();
require_once('common/components.php');
require_once 'config/website_info.php';
require_once 'utils/get-candidates.php';
require_once 'utils/get-election-times.php';
require_once 'utils/auth.php';
require_once 'utils/helpers.php';
require_once 'utils/helpers-votes.php';

checkInactivity();

if (isset($_SESSION['id']))
    $user_id = $_SESSION['id'];

$startDate = date('M d, Y g:i A', strtotime(getStartDate()));
$endDate = date('M d, Y g:i A', strtotime(getEndDate()));
$date = date('M d, Y g:i A', time());
$response = "";

if (isset($_POST['submit'])) {
    // Check Anti-CSRF token
    checkToken($_REQUEST['user_token'], $_SESSION['session_token'], 'voting.php');

    if (isset($_POST['president']))
        $presidentId = filter_var($_POST['president'], FILTER_SANITIZE_NUMBER_INT);
    if (isset($_POST['vice-president']))
        $vPresidentId = filter_var($_POST['vice-president'], FILTER_SANITIZE_NUMBER_INT);
    if (isset($_POST['secretary']))
        $secretaryId = filter_var($_POST['secretary'], FILTER_SANITIZE_NUMBER_INT);
    if (isset($_POST['treasurer']))
        $treasurerId = filter_var($_POST['treasurer'], FILTER_SANITIZE_NUMBER_INT);
    if (isset($_POST['representative-1']))
        $rep1Id = filter_var($_POST['representative-1'], FILTER_SANITIZE_NUMBER_INT);
    if (isset($_POST['representative-2']))
        $rep2Id = filter_var($_POST['representative-2'], FILTER_SANITIZE_NUMBER_INT);
    if (isset($_POST['representative-3']))
        $rep3Id = filter_var($_POST['representative-3'], FILTER_SANITIZE_NUMBER_INT);
    if (isset($_POST['representative-4']))
        $rep4Id = filter_var($_POST['representative-4'], FILTER_SANITIZE_NUMBER_INT);

    // reCAPTCHA validation
    if (isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response'])) {
        // reCAPTCHA response verification
        $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . RECAPTCHA_SECRET_KEY . '&response=' . $_POST['g-recaptcha-response']);

        // Decode JSON data
        $response = json_decode($verifyResponse);
        if ($response->success) {
            try {
                //insert president vote
                if (!empty($presidentId))
                    insertVote($user_id, $presidentId, "President");

                //insert vice president vote
                if (!empty($vPresidentId))
                    insertVote($user_id, $vPresidentId, "Vice President");

                //insert secretary vote
                if (!empty($secretaryId))
                    insertVote($user_id, $secretaryId, "Secretary");

                //insert treasurer vote
                if (!empty($treasurerId))
                    insertVote($user_id, $treasurerId, "Treasurer");

                //insert rep 1 vote
                if (!empty($rep1Id))
                    insertVote($user_id, $rep1Id, "Representative 1");

                //insert rep 2 vote
                if (!empty($rep2Id))
                    insertVote($user_id, $rep2Id, "Representative 2");

                //insert rep 3 vote
                if (!empty($rep3Id))
                    insertVote($user_id, $rep3Id, "Representative 3");

                //insert rep 4 vote
                if (!empty($rep4Id))
                    insertVote($user_id, $rep4Id, "Representative 4");
            } catch (Exception $e) {
                echo 'Something went wrong';
            }
        } else {
            $response = "captcha failed";
        }
    } else {
        $response = "unchecked";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<?= head("Voting Ballot"); ?>

<body>
    <?= navbar("voting"); ?>
    <?php
    if (isset($_SESSION['user_type'])) :
        if ($_SESSION['user_type'] === 'admin') : // if user logged in is admin 
    ?>
            <main>
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-md-7">
                            <h1>You do not have access to this page.</h1>
                            <h5>Only students can vote.</h5>
                        </div>
                        <div class="col-md-5">
                            <img src="images/sammy-17.png" alt="error" class="w-100">
                        </div>
                    </div>
                </div>
            </main>
            <?php
        elseif ($_SESSION['user_type'] === 'student' && ($date >= $startDate) && ($date <= $endDate)) : // if user logged in is a student and elections are still ongoing
            if (checkIfVoted($user_id, getStartDate(), getEndDate()) != 0) : // if user has already voted for current election duration 
            ?>
                <main>
                    <div class="container">
                        <div class="row align-items-center">
                            <div class="col-md-7">
                                <h1>You have already voted for the current election duration.</h1>
                                <a href="results.php" class="btn btn-default">View Results Instead</a>
                            </div>
                            <div class="col-md-5">
                                <img src="images/sammy-done.png" alt="error" class="w-100">
                            </div>
                        </div>
                    </div>
                </main>
            <?php else : // if user has not yet voted for current election duration
            ?>
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
                        <form action="" method="POST" id="votingForm">
                            <input type="hidden" name="user_token" value="<?php escapeString($_SESSION['session_token']) ?>">

                            <!-- ======= Presidents Row ======= -->
                            <h3 class="text-center">President</h3>
                            <?php
                            if (getCandidates('President') && getCandidates('President')->num_rows > 0) : ?>
                                <div class="d-flex justify-content-center mb-5">
                                    <?php
                                    $result = getCandidates("President");
                                    while ($data = $result->fetch_assoc()) :
                                    ?>
                                        <div class="voting card m-3">
                                            <img src="<?php escapeString($data['image_path']) ?>" class="h-75 candidate-img" alt="candidate-img">
                                            <div class="form-check align-self-center text-center m-3">
                                                <input class="form-check-input" type="radio" name="president" value="<?php escapeString($data['id']) ?>" required>
                                                <strong><label class="form-check-label"><?php escapeString($data['first_name'] . ' ' . $data['last_name']) ?></label></strong>
                                                <br>
                                                <span><?php escapeString($data['section']) ?></span>
                                            </div>
                                        </div>
                                    <?php endwhile ?>
                                </div>
                            <?php else : ?>
                                <h5 class="py-5 text-center">No candidates in the database.</h5>
                            <?php endif ?>
                            <!-- End Presidents Row -->

                            <!-- ======= Vice Presidents Row ======= -->
                            <h3 class="text-center">Vice President</h3>
                            <?php
                            if (getCandidates('Vice President') && getCandidates('Vice President')->num_rows > 0) : ?>
                                <div class="d-flex justify-content-center mb-5">
                                    <?php
                                    $result = getCandidates("Vice President");
                                    while ($data = $result->fetch_assoc()) :
                                    ?>
                                        <div class="voting card m-3">
                                            <img src="<?php escapeString($data['image_path']) ?>" class="h-75 candidate-img" alt="candidate-img">
                                            <div class="form-check align-self-center text-center m-3">
                                                <input class="form-check-input" type="radio" name="vice-president" value="<?php escapeString($data['id']) ?>" required>
                                                <strong><label class="form-check-label"><?php escapeString($data['first_name'] . ' ' . $data['last_name']) ?></label></strong>
                                                <br>
                                                <span><?php escapeString($data['section']) ?></span>
                                            </div>
                                        </div>
                                    <?php endwhile ?>
                                </div>
                            <?php else : ?>
                                <h5 class="py-5 text-center">No candidates in the database.</h5>
                            <?php endif ?>
                            <!-- End Vice Presidents Row -->

                            <!-- ======= Secretaries Row ======= -->
                            <h3 class="text-center">Secretary</h3>
                            <?php
                            if (getCandidates('Secretary') && getCandidates('Secretary')->num_rows > 0) : ?>
                                <div class="d-flex justify-content-center mb-5">
                                    <?php
                                    $result = getCandidates("Secretary");
                                    while ($data = $result->fetch_assoc()) :
                                    ?>
                                        <div class="voting card m-3">
                                            <img src="<?php escapeString($data['image_path']) ?>" class="h-75 candidate-img" alt="candidate-img">
                                            <div class="form-check align-self-center text-center m-3">
                                                <input class="form-check-input" type="radio" name="secretary" value="<?php escapeString($data['id']) ?>" required>
                                                <strong><label class="form-check-label"><?php escapeString($data['first_name'] . ' ' . $data['last_name']) ?></label></strong>
                                                <br>
                                                <span><?php escapeString($data['section']) ?></span>
                                            </div>
                                        </div>
                                    <?php endwhile ?>
                                </div>
                            <?php else : ?>
                                <h5 class="py-5 text-center">No candidates in the database.</h5>
                            <?php endif ?>
                            <!-- End Secretaries Row -->

                            <!-- ======= Treasurers Row ======= -->
                            <h3 class="text-center">Treasurer</h3>
                            <?php
                            if (getCandidates('Treasurer') && getCandidates('Treasurer')->num_rows > 0) : ?>
                                <div class="d-flex justify-content-center mb-5">
                                    <?php
                                    $result = getCandidates("Treasurer");
                                    while ($data = $result->fetch_assoc()) :
                                    ?>
                                        <div class="voting card m-3">
                                            <img src="<?php escapeString($data['image_path']) ?>" class="h-75 candidate-img" alt="candidate-img">
                                            <div class="form-check align-self-center text-center m-3">
                                                <input class="form-check-input" type="radio" name="treasurer" value="<?php escapeString($data['id']) ?>" required>
                                                <strong><label class="form-check-label"><?php escapeString($data['first_name'] . ' ' . $data['last_name']) ?></label></strong>
                                                <br>
                                                <span><?php escapeString($data['section']) ?></span>
                                            </div>
                                        </div>
                                    <?php endwhile ?>
                                </div>
                            <?php else : ?>
                                <h5 class="py-5 text-center">No candidates in the database.</h5>
                            <?php endif ?>
                            <!-- End Treasurers Row -->

                            <!-- ======= Representatives 1 Row ======= -->
                            <h3 class="text-center">1st Year Representative</h3>
                            <?php
                            if (getCandidates('Representative 1') && getCandidates('Representative 1')->num_rows > 0) : ?>
                                <div class="d-flex justify-content-center mb-5">
                                    <?php
                                    $result = getCandidates("Representative 1");
                                    while ($data = $result->fetch_assoc()) :
                                    ?>
                                        <div class="voting card m-3">
                                            <img src="<?php escapeString($data['image_path']) ?>" class="h-75 candidate-img" alt="candidate-img">
                                            <div class="form-check align-self-center text-center m-3">
                                                <input class="form-check-input" type="radio" name="representative-1" value="<?php escapeString($data['id']) ?>" required>
                                                <strong><label class="form-check-label"><?php escapeString($data['first_name'] . ' ' . $data['last_name']) ?></label></strong>
                                                <br>
                                                <span><?php escapeString($data['section']) ?></span>
                                            </div>
                                        </div>
                                    <?php endwhile ?>
                                </div>
                            <?php else : ?>
                                <h5 class="py-5 text-center">No candidates in the database.</h5>
                            <?php endif ?>
                            <!-- End Representatives 1 Row -->

                            <!-- ======= Representatives 2 Row ======= -->
                            <h3 class="text-center">2nd Year Representative</h3>
                            <?php
                            if (getCandidates('Representative 2') && getCandidates('Representative 2')->num_rows > 0) : ?>
                                <div class="d-flex justify-content-center mb-5">
                                    <?php
                                    $result = getCandidates("Representative 2");
                                    while ($data = $result->fetch_assoc()) :
                                    ?>
                                        <div class="voting card m-3">
                                            <img src="<?php escapeString($data['image_path']) ?>" class="h-75 candidate-img" alt="candidate-img">
                                            <div class="form-check align-self-center text-center m-3">
                                                <input class="form-check-input" type="radio" name="representative-2" value="<?php escapeString($data['id']) ?>" required>
                                                <strong><label class="form-check-label"><?php escapeString($data['first_name'] . ' ' . $data['last_name']) ?></label></strong>
                                                <br>
                                                <span><?php escapeString($data['section']) ?></span>
                                            </div>
                                        </div>
                                    <?php endwhile ?>
                                </div>
                            <?php else : ?>
                                <h5 class="py-5 text-center">No candidates in the database.</h5>
                            <?php endif ?>
                            <!-- End Representatives 2 Row -->

                            <!-- ======= Representatives 3 Row ======= -->
                            <h3 class="text-center">3rd Year Representative</h3>
                            <?php
                            if (getCandidates('Representative 3') && getCandidates('Representative 3')->num_rows > 0) : ?>
                                <div class="d-flex justify-content-center mb-5">
                                    <?php
                                    $result = getCandidates("Representative 3");
                                    while ($data = $result->fetch_assoc()) :
                                    ?>
                                        <div class="voting card m-3">
                                            <img src="<?php escapeString($data['image_path']) ?>" class="h-75 candidate-img" alt="candidate-img">
                                            <div class="form-check align-self-center text-center m-3">
                                                <input class="form-check-input" type="radio" name="representative-3" value="<?php escapeString($data['id']) ?>" required>
                                                <strong><label class="form-check-label"><?php escapeString($data['first_name'] . ' ' . $data['last_name']) ?></label></strong>
                                                <br>
                                                <span><?php escapeString($data['section']) ?></span>
                                            </div>
                                        </div>
                                    <?php endwhile ?>
                                </div> <?php else : ?>
                                <h5 class="py-5 text-center">No candidates in the database.</h5>
                            <?php endif ?>
                            <!-- End Representatives 3 Row -->

                            <!-- ======= Representatives 4 Row ======= -->
                            <h3 class="text-center">4th Year Representative</h3>
                            <?php
                            if (getCandidates('Representative 4') && getCandidates('Representative 4')->num_rows > 0) : ?>
                                <div class="d-flex justify-content-center mb-5">
                                    <?php
                                    $result = getCandidates("Representative 4");
                                    while ($data = $result->fetch_assoc()) :
                                    ?>
                                        <div class="voting card m-3">
                                            <img src="<?php escapeString($data['image_path']) ?>" class="h-75 candidate-img" alt="candidate-img">
                                            <div class="form-check align-self-center text-center m-3">
                                                <input class="form-check-input" type="radio" name="representative-4" value="<?php escapeString($data['id']) ?>" required>
                                                <strong><label class="form-check-label"><?php escapeString($data['first_name'] . ' ' . $data['last_name']) ?></label></strong>
                                                <br>
                                                <span><?php escapeString($data['section']) ?></span>
                                            </div>
                                        </div>
                                    <?php endwhile ?>
                                </div>
                            <?php else : ?>
                                <h5 class="py-5 text-center">No candidates in the database.</h5>
                            <?php endif ?>
                            <!-- End Representatives 4 Row -->


                            <div class="d-flex flex-column align-items-center">
                                <?php
                                if ($response === "unchecked") : ?>
                                    <div class="alert alert-danger" role="alert">
                                        Plese check on the reCAPTCHA box.
                                    </div>
                                <?php
                                elseif ($response === "captcha failed") : ?>
                                    <div class="alert alert-danger" role="alert">
                                        Robot verification failed, please try again.
                                    </div>
                                <?php endif ?>
                                <div class="g-recaptcha" data-sitekey="<?php escapeString(RECAPTCHA_CLIENT_KEY) ?>"></div>
                                <div class="mt-3">
                                    <button type="submit" class="btn btn-default" name="submit" id="formBtn">Submit my Vote</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </main>
            <?php endif;
        else : // if user logged in is a student and elections are closed
            ?>
            <main>
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-md-7">
                            <h1>Elections are closed.</h1>
                            <h5>Open from <?= $startDate ?> - <?= $endDate ?></h5>
                        </div>
                        <div class="col-md-5">
                            <img src="images/sammy-17.png" alt="error" class="w-100">
                        </div>
                    </div>
                </div>
            </main>
        <?php endif;
    else :  //if user is not logged in 
        ?>
        <main>
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-7">
                        <h1>You do not have access to this page.</h1>
                        <h5>Log in as a student to vote.</h5>
                    </div>
                    <div class="col-md-5">
                        <img src="images/sammy-17.png" alt="error" class="w-100">
                    </div>
                </div>
            </div>
        </main>
    <?php endif ?>

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