<?php
session_start();
require_once('common/components.php');
require_once 'utils/helpers-votes.php';
require_once 'utils/get-voters.php';
require_once 'utils/get-election-times.php';
require_once 'utils/auth.php';

checkInactivity();

if (isset($_SESSION['user_type']) && $_SESSION['user_type'] !== "student") {
    header('location: index.php');
}

if (isset($_SESSION['id']))
    $user_id = $_SESSION['id'];

$fullName = "";
$studentID = "";
$email = "";
$program = "";

$userData = getVoterByID($user_id);
if ($userData && $userData->num_rows>0) {
    while ($data = $userData->fetch_assoc()) {
        $fullName = $data['first_name'].' '.$data['last_name'];
        $studentID = $data['student_id'];
        $email = $data['email'];
        $program = $data['program'];
    }
}

?>


<!DOCTYPE html>
<html lang="en">
<?= head("Student Profile"); ?>

<body>
    <?= navbar("profile") ?>
    <header class="results py-3">
        <div class="container">
            <div class="row justify-content-center align-items-center">
                <div class="col-md-3">
                    <img src="images/sammy-small-house-with-bushes.png" alt="img" class="p-3 w-75">
                </div>
                <div class="col-md-4">
                    <h1>Student Profile</h1>
                </div>
            </div>
        </div>
    </header>
    <main>
        <div class="container">
            <div class="row">
                <h2><span class="bi-person-circle"></span> Hi, <?php escapeString($_SESSION['username']) ?></h2>

                <h5 class="mt-4"><span class="bi-info-square"></span> Your Information</h5>
                <hr>
                <p class="mb-2"><b>Full Name: </b><?php escapeString($fullName)?></p>
                <p class="mb-2"><b>Student ID: </b><?php escapeString($studentID)?></p>
                <p class="mb-2"><b>Email: </b><span><?php escapeString($email)?></span></p>
                <p class="mb-2"><b>Program: </b><span><?php escapeString($program)?></span></p>

                <h5 class="mt-4"><span class="bi-receipt-cutoff"></span> Vote Receipt</h5>
                <hr>
                <?php
                if (checkIfVoted($user_id, getStartDate(), getEndDate()) !== 0) : ?>
                    <table class="table table-striped">
                        <thead>

                            <tr>
                                <th>Position</th>
                                <th>Name</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $result = getVotesByUserID($user_id, getStartDate(), getEndDate());
                            $ballotId = "";
                            if (getVotesByUserID($user_id, getStartDate(), getEndDate()) && getVotesByUserID($user_id, getStartDate(), getEndDate())->num_rows > 0) :
                                while ($data = $result->fetch_assoc()) :
                                    $ballotId = $data['ballot_id']; ?>
                                    <tr>
                                        <td><?php escapeString($data['position']) ?></td>
                                        <td>
                                            <?php escapeString($data['first_name'] . ' ' . $data['last_name']) ?>
                                        </td>
                                    </tr>
                                <?php endwhile ?>
                                <tr>
                                    <th colspan="2">Ballot ID: <?php escapeString($ballotId) ?></th>
                                </tr>
                            <?php endif ?>

                        </tbody>
                    </table>
                <?php else : ?>
                    <h6 class="py-5 mx-auto">You haven't voted yet for the current election duration.</h6>
                <?php endif ?>
            </div>
        </div>
    </main>

    <?php include 'common/footer.php'; ?>
    <script src="js/bootstrap.bundle.js"></script>
</body>

</html>