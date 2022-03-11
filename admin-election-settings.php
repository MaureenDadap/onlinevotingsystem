<?php
session_start();
require_once('common/components.php');
require_once 'config/website_info.php';
require_once 'utils/get-election-times.php';
require_once 'utils/auth.php';
require_once 'utils/helpers.php';

checkInactivity();

if (isset($_SESSION['user_type']) && $_SESSION['user_type'] !== "admin") {
    header('location: index.php');
}

//dates currently stored in db
$startDate = date('M d, Y', strtotime(getStartDate()));
$startTime = date('g:i A', strtotime(getStartDate()));
$endDate = date('M d, Y', strtotime(getEndDate()));
$endTime = date('g:i A', strtotime(getEndDate()));

//dates that are placeholder for input fields
$start = date('Y-m-d\TH:i', strtotime(getStartDate()));
$close = date('Y-m-d\TH:i', strtotime(getEndDate()));

$response = "";

if (isset($_POST['submit'])) {
    // Check Anti-CSRF token
    checkToken($_REQUEST['user_token'], $_SESSION['session_token'], 'admin-election-settings.php');

    $conn = Connect();

    $start = preg_replace("([^0-9/:\-T])", "", $_POST['start']); //allows only 0-9 : / - , and T
    $close = preg_replace("([^0-9/:\-T])", "", $_POST['close']); //allows only 0-9 : / - , and T

    if ($close <= $start) {
        $response = "invalid date";
    } else {
        $query = 'INSERT INTO election_settings (datetime_start, datetime_end) VALUES(?,?)';
        $stmt = $conn->prepare($query);
        $stmt->bind_param('ss', $start, $close);
        $stmt->execute();
        $conn->close();
        header('location: admin-election-settings.php');
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<?= head("Admin Dashboard: Election Settings"); ?>

<body class="admin">
    <div class="row">
        <div class="col-xl-2 col-lg-3 col-md-4">
            <?= sidebar("settings") ?>
        </div>
        <div class="col-xl-10 col-lg-9 col-md-8">
            <main class="admin">
                <div class="container">
                    <h1>Election Settings</h1>
                    <hr>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="admin card text-center">
                                <div class="alert-success mb-3 p-3 rounded">
                                    <h6>Election Start</h6>
                                    <h2><?php escapeString($startDate) ?></h2>
                                    <h4><?php escapeString($startTime) ?></h4>
                                </div>
                                <div class="alert-danger p-3 rounded">
                                    <h6>Election End</h6>
                                    <h2><?php escapeString($endDate) ?></h2>
                                    <h4><?php escapeString($endTime) ?></h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class=" col admin card">
                                <form action="" method="POST">
                                    <input type="hidden" name="user_token" value="<?php escapeString($_SESSION['session_token']) ?>">
                                    <h5>Set Election Opening</h5>
                                    <input type="datetime-local" class="date my-2" name="start" id="start" value='<?php escapeString($start) ?>' required>
                                    <h5 class="mt-2">Set Election Closing</h5>
                                    <input type="datetime-local" class="my-2" name="close" id="close" value='<?php escapeString($close) ?>' required> <br>
                                    <button type="submit" name="submit" class="btn btn-default my-2">Submit</button>
                                    <?php if ($response === "invalid date") : ?>
                                        <div class="alert alert-danger" role="alert">
                                            Closing date must never be before the opening date.
                                        </div>
                                    <?php endif ?>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
    <script src="js/bootstrap.bundle.js"></script>
</body>

</html>