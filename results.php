<?php
session_start();
date_default_timezone_set('Asia/Manila');
require_once('common/components.php');
require_once 'config/website_info.php';
require_once 'utils/get-candidates.php';
require_once 'utils/get-election-times.php';
require_once 'utils/helpers-votes.php';
require_once 'utils/auth.php';

checkInactivity();

$startDate = date('M d, Y g:i A', strtotime(getStartDate()));
$endDate = date('M d, Y g:i A', strtotime(getEndDate()));
$date = date('M d, Y g:i A', time());

$totalVotes = countVotes();
?>

<!DOCTYPE html>
<html lang="en">
<?= head("Results"); ?>

<body>
    <?= navbar(""); ?>
    <?php if (($date >= $startDate) && ($date <= $endDate)) : //if election is still ongoing 
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
                <!-- ======= President Row ======= -->
                <div class="row text-center justify-content-center my-4">
                    <?php
                    if (getCandidatesVotes("President", 1) != false && getCandidatesVotes("President", 1)->num_rows > 0) :
                        $result = getCandidatesVotes("President", 1);
                        while ($data = $result->fetch_assoc()) : ?>
                            <div class="col">
                                <h4>President</h4>
                                <img class="candidate-img" alt="candidate" src="<?php escapeString($data['image_path']) ?>">
                                <h5><?php escapeString($data['first_name'] . ' ' . $data['last_name']) ?></h5>
                                <h6><?php escapeString($data['section']) ?></h6>
                                <h6 class="text-success"><?php escapeString($data['VOTES']) ?> Votes</h6>
                            </div>
                        <?php
                        endwhile;
                    else : ?>
                        <h6 class="py-5 mx-auto">No candidate for this position or insufficient votes.</h6>
                    <?php endif ?>
                </div>
                <!-- End President Row -->

                <hr>

                <!-- ======= Vice President Row ======= -->
                <div class="row text-center justify-content-center my-4">
                    <?php
                    if (getCandidatesVotes("Vice President", 1) != false && getCandidatesVotes("Vice President", 1)->num_rows > 0) :
                        $result = getCandidatesVotes("Vice President", 1);
                        while ($data = $result->fetch_assoc()) : ?>
                            <div class="col">
                                <h4>Vice President</h4>
                                <img class="candidate-img" alt="candidate" src="<?php escapeString($data['image_path']) ?>">
                                <h5><?php escapeString($data['first_name'] . ' ' . $data['last_name']) ?></h5>
                                <h6><?php escapeString($data['section']) ?></h6>
                                <h6 class="text-success"><?php escapeString($data['VOTES']) ?> Votes</h6>
                            </div>
                        <?php
                        endwhile;
                    else : ?>
                        <h6 class="py-5 mx-auto">No candidate for this position or insufficient votes.</h6>
                    <?php endif ?>
                </div>
                <!-- End Vice President Row -->

                <hr>

                <!-- ======= Secretary and Treasurer Row ======= -->
                <div class="row text-center justify-content-center my-4">
                    <?php //Secretary
                    if (getCandidatesVotes("Secretary", 1) != false && getCandidatesVotes("Secretary", 1)->num_rows > 0) :
                        $result = getCandidatesVotes("Secretary", 1);
                        while ($data = $result->fetch_assoc()) : ?>
                            <div class="col">
                                <h4>Secretary</h4>
                                <img class="candidate-img" alt="candidate" src="<?php escapeString($data['image_path']) ?>">
                                <h5><?php escapeString($data['first_name'] . ' ' . $data['last_name']) ?></h5>
                                <h6><?php escapeString($data['section']) ?></h6>
                                <h6 class="text-success"><?php escapeString($data['VOTES']) ?> Votes</h6>
                            </div>
                        <?php
                        endwhile;
                    else : ?>
                        <h6 class="py-5 mx-auto">No candidate for this position or insufficient votes.</h6>
                    <?php endif ?>

                    <?php //Treasurer
                    if (getCandidatesVotes("Treasurer", 1) != false && getCandidatesVotes("Treasurer", 1)->num_rows > 0) :
                        $result = getCandidatesVotes("Treasurer", 1);
                        while ($data = $result->fetch_assoc()) : ?>
                            <div class="col">
                                <h4>Treasurer</h4>
                                <img class="candidate-img" alt="candidate" src="<?php escapeString($data['image_path']) ?>">
                                <h5><?php escapeString($data['first_name'] . ' ' . $data['last_name']) ?></h5>
                                <h6><?php escapeString($data['section']) ?></h6>
                                <h6 class="text-success"><?php escapeString($data['VOTES']) ?> Votes</h6>
                            </div>
                        <?php
                        endwhile;
                    else : ?>
                        <h6 class="py-5 mx-auto">No candidate for this position or insufficient votes.</h6>
                    <?php endif ?>
                </div>
                <!-- End Secretary and Treasurer Row -->

                <hr>

                <!-- ======= Representatives Row ======= -->
                <div class="row text-center justify-content-center my-4">
                    <?php //Representative 1
                    if (getCandidatesVotes("Representative 1", 1) != false && getCandidatesVotes("Representative 1", 1)->num_rows > 0) :
                        $result = getCandidatesVotes("Representative 1", 1);
                        while ($data = $result->fetch_assoc()) : ?>
                            <div class="col">
                                <h5 class="red">1st Year Representative</h5>
                                <img class="candidate-img" alt="candidate" src="<?php escapeString($data['image_path']) ?>">
                                <h5><?php escapeString($data['first_name'] . ' ' . $data['last_name']) ?></h5>
                                <h6><?php escapeString($data['section']) ?></h6>
                                <h6 class="text-success"><?php escapeString($data['VOTES']) ?> Votes</h6>
                            </div>
                        <?php
                        endwhile;
                    else : ?>
                        <h6 class="py-5 mx-auto">No candidate for this position or insufficient votes.</h6>
                    <?php endif ?>

                    <?php //Representative 2
                    if (getCandidatesVotes("Representative 2", 1) != false && getCandidatesVotes("Representative 2", 1)->num_rows > 0) :
                        $result = getCandidatesVotes("Representative 2", 1);
                        while ($data = $result->fetch_assoc()) : ?>
                            <div class="col">
                                <h5 class="red">2nd Year Representative</h5>
                                <img class="candidate-img" alt="candidate" src="<?php escapeString($data['image_path']) ?>">
                                <h5><?php escapeString($data['first_name'] . ' ' . $data['last_name']) ?></h5>
                                <h6><?php escapeString($data['section']) ?></h6>
                                <h6 class="text-success"><?php escapeString($data['VOTES']) ?> Votes</h6>
                            </div>
                        <?php
                        endwhile;
                    else : ?>
                        <h6 class="py-5 mx-auto">No candidate for this position or insufficient votes.</h6>
                    <?php endif ?>

                    <?php //Representative 3
                    if (getCandidatesVotes("Representative 3", 1) != false && getCandidatesVotes("Representative 3", 1)->num_rows > 0) :
                        $result = getCandidatesVotes("Representative 3", 1);
                        while ($data = $result->fetch_assoc()) : ?>
                            <div class="col">
                                <h5 class="red">3rd Year Representative</h5>
                                <img class="candidate-img" alt="candidate" src="<?php escapeString($data['image_path']) ?>">
                                <h5><?php escapeString($data['first_name'] . ' ' . $data['last_name']) ?></h5>
                                <h6><?php escapeString($data['section']) ?></h6>
                                <h6 class="text-success"><?php escapeString($data['VOTES']) ?> Votes</h6>
                            </div>
                        <?php
                        endwhile;
                    else : ?>
                        <h6 class="py-5 mx-auto">No candidate for this position or insufficient votes.</h6>
                    <?php endif ?>

                    <?php //Representative 4
                    if (getCandidatesVotes("Representative 4", 1) != false && getCandidatesVotes("Representative 4", 1)->num_rows > 0) :
                        $result = getCandidatesVotes("Representative 4", 1);
                        while ($data = $result->fetch_assoc()) : ?>
                            <div class="col">
                                <h5 class="red">4th Year Representative</h5>
                                <img class="candidate-img" alt="candidate" src="<?php escapeString($data['image_path']) ?>">
                                <h5><?php escapeString($data['first_name'] . ' ' . $data['last_name']) ?></h5>
                                <h6><?php escapeString($data['section']) ?></h6>
                                <h6 class="text-success"><?php escapeString($data['VOTES']) ?> Votes</h6>
                            </div>
                        <?php
                        endwhile;
                    else : ?>
                        <h6 class="py-5 mx-auto">No candidate for this position or insufficient votes.</h6>
                    <?php endif ?>
                </div>
                <!-- End Representatives Row -->
            </div>
        </main>
    <?php endif ?>
    <?php include 'common/footer.php'; ?>
    <script src="js/bootstrap.bundle.js"></script>
</body>

</html>