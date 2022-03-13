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
$response = "";
$ballotID = "";

//Check if user is logged out or is not a student
if (!isset($_SESSION['user_type']) || (isset($_SESSION['user_type']) && $_SESSION['user_type'] !== "student")) {
    header('location: index.php');
}

//check if user id exists
if (isset($_SESSION['id']))
    $user_id = $_SESSION['id'];

if (isset($_POST['vote'])) {
    // Check Anti-CSRF token
    checkToken($_REQUEST['user_token'], $_SESSION['session_token'], 'voting.php');

    $ballotID = filter_var($_POST['ballot-id'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

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
                    insertVote($ballotID, $user_id, $presidentId, "President");

                //insert vice president vote
                if (!empty($vPresidentId))
                    insertVote($ballotID, $user_id, $vPresidentId, "Vice President");

                //insert secretary vote
                if (!empty($secretaryId))
                    insertVote($ballotID, $user_id, $secretaryId, "Secretary");

                //insert treasurer vote
                if (!empty($treasurerId))
                    insertVote($ballotID, $user_id, $treasurerId, "Treasurer");

                //insert rep 1 vote
                if (!empty($rep1Id))
                    insertVote($ballotID, $user_id, $rep1Id, "Representative 1");

                //insert rep 2 vote
                if (!empty($rep2Id))
                    insertVote($ballotID, $user_id, $rep2Id, "Representative 2");

                //insert rep 3 vote
                if (!empty($rep3Id))
                    insertVote($ballotID, $user_id, $rep3Id, "Representative 3");

                //insert rep 4 vote
                if (!empty($rep4Id))
                    insertVote($ballotID, $user_id, $rep4Id, "Representative 4");

                header('location:voting.php');
            } catch (Exception $e) {
                echo 'Something went wrong';
            }
        } else {
            $response = "captcha failed";
        }
    } else {
        $presidentId = $presidentId;
        $response = "unchecked";
    }
}

//expecting to see values from voting page here, if it doesnt exist
//then it must mean it was reloaded due to error
//so if both dont exist then it did not come from voting and must
//have been accessed directly by url 
if (!isset($_POST['submit']) && !isset($_POST['vote']))
    header('location: voting.php');

function printCandidates(String $position)
{
    if (isset($_POST[$position]) && getCandidateByID($_POST[$position]) && getCandidateByID($_POST[$position])->num_rows > 0) {
        $result = getCandidateByID($_POST[$position]);
        while ($data = $result->fetch_assoc()) {
            $name = $data['first_name'] . ' ' . $data['last_name'];
            escapeString($name);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<?= head("Review Votes"); ?>

<body>
    <?= navbar("voting"); ?>
    <main>
        <div class="container voting">
            <div class="row justify-content-center">
                <form action="" method="POST">
                    <input type="hidden" name="user_token" value="<?php escapeString($_SESSION['session_token']) ?>">
                    <?php if (!empty($_POST['ballot-id'])) : ?>
                        <input type="hidden" name="ballot-id" value="<?php escapeString($_POST['ballot-id']) ?>">
                    <?php endif;
                    if (!empty($_POST['president'])) : ?>
                        <input type="hidden" name="president" value="<?php escapeString($_POST['president']) ?>">
                    <?php endif;
                    if (!empty($_POST['vice-president'])) : ?>
                        <input type="hidden" name="vice-president" value="<?php escapeString($_POST['vice-president']) ?>">
                    <?php endif;
                    if (!empty($_POST['secretary'])) : ?>
                        <input type="hidden" name="secretary" value="<?php escapeString($_POST['secretary']) ?>">
                    <?php endif;
                    if (!empty($_POST['treasurer'])) : ?>
                        <input type="hidden" name="treasurer" value="<?php escapeString($_POST['treasurer']) ?>">
                    <?php endif;
                    if (!empty($_POST['representative-1'])) : ?>
                        <input type="hidden" name="representative-1" value="<?php escapeString($_POST['representative-1']) ?>">
                    <?php endif;
                    if (!empty($_POST['representative-2'])) :
                    ?>
                        <input type="hidden" name="representative-2" value="<?php escapeString($_POST['representative-2']) ?>">
                    <?php endif;
                    if (!empty($_POST['representative-3'])) : ?>
                        <input type="hidden" name="representative-3" value="<?php escapeString($_POST['representative-3']) ?>">
                    <?php endif;
                    if (!empty($_POST['representative-4'])) : ?>
                        <input type="hidden" name="representative-4" value="<?php escapeString($_POST['representative-4']) ?>">
                    <?php endif ?>

                    <h3 class="text-center">Review your votes</h3>

                    <div class="row justify-content-center">
                        <div class="col-lg-5">
                            <table class="table mt-3">
                                <thead>
                                    <tr>
                                        <th colspan="2">Ballot ID: <?php escapeString($_POST['ballot-id']) ?></th>
                                    </tr>
                                    <tr>
                                        <th>Position</th>
                                        <th>Name</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>President</td>
                                        <td>
                                            <?php printCandidates('president') ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Vice President</td>
                                        <td>
                                            <?php printCandidates('vice-president') ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Secretary</td>
                                        <td>
                                            <?php printCandidates('secretary') ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Treasurer</td>
                                        <td>
                                            <?php printCandidates('treasurer') ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>1st Year Representative</td>
                                        <td>
                                            <?php printCandidates('representative-1') ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>2nd Year Representative</td>
                                        <td>
                                            <?php printCandidates('representative-2') ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>3rd Year Representative</td>
                                        <td>
                                            <?php printCandidates('representative-3') ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>4th Year Representative</td>
                                        <td>
                                            <?php printCandidates('representative-4') ?>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="d-flex flex-column align-items-center mt-3">
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
                            <button type="submit" class="btn btn-default" name="vote" id="formBtn">Submit my Vote</button>
                        </div>
                </form>

            </div>

        </div>
    </main>


    <?php include 'common/footer.php'; ?>
    <script src="js/bootstrap.bundle.js"></script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</body>

</html>