<?php
session_start();
require_once('common/components.php');

include('common/website_info.php');


require_once 'config/website_info.php';
<<<<<<< HEAD

=======
require_once 'utils/get-election-times.php';
require_once 'utils/auth.php';

checkInactivity();
>>>>>>> 230af5e2e5b39b2500e9bf35f74eaca58a55611e

if (isset($_SESSION['user_type']) && $_SESSION['user_type'] !== "admin") {
    header('location: index.php');
}

<<<<<<< HEAD
=======
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
    //TODO VALIDATE SANITIZE
    $conn = Connect();

    $start = $_POST['start'];
    $close = $_POST['close'];

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
>>>>>>> 230af5e2e5b39b2500e9bf35f74eaca58a55611e

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
                                    <h2><?= $startDate ?></h2>
                                    <h4><?= $startTime ?></h4>
                                </div>
                                <div class="alert-danger p-3 rounded">
                                    <h6>Election End</h6>
                                    <h2><?= $endDate ?></h2>
                                    <h4><?= $endTime ?></h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class=" col admin card">
                                <form action="" method="POST">
                                    <h5>Set Election Opening</h5>
                                    <input type="datetime-local" class="date my-2" name="start" id="start" value='<?php echo $start; ?>' required>
                                    <h5 class="mt-2">Set Election Closing</h5>
                                    <input type="datetime-local" class="my-2" name="close" id="close" value='<?php echo $close; ?>' required> <br>
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