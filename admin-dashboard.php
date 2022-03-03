<?php
session_start();
require_once('common/components.php');
include('common/website_info.php');
require_once 'utils/get-candidates.php';
require_once 'utils/connection.php';
require_once 'utils/get-election-times.php';
require_once 'utils/get-votes.php';

function countVoters()
{
    //TODO catch possible errors
    $totalVoters = 0;
    $is_admin = 0;
    $conn = Connect();
    $query = "SELECT COUNT(*) as total FROM users WHERE is_admin=?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $is_admin);

    $stmt->execute();

    $result = $stmt->get_result();
    if ($result && $result->num_rows > 0) {
        while ($data = $result->fetch_assoc()) {
            $totalVoters = $data['total'];
        }
    }

    $conn->close();
    return $totalVoters;
}

function countCandidates($totalCandidates)
{
    $result = getCandidates("");
    if ($result && $result->num_rows > 0) {
        while ($result->fetch_assoc()) {
            $totalCandidates++;
        }
    }
    return $totalCandidates;
}

$pos_selected = "";

if (isset($_GET['pos'])) {
    //TODO VALIDATE/SANITIZE
    $pos_selected = $_GET['pos'];
}

$totalCandidates = 0;
$startDate = date('M d, Y', strtotime(getStartDate()));
$startTime = date('g:i A', strtotime(getStartDate()));
$endDate = date('M d, Y', strtotime(getEndDate()));
$endTime = date('g:i A', strtotime(getEndDate()));
?>

<!DOCTYPE html>
<html lang="en">
<?= head("Admin Dashboard"); ?>

<body class="admin">
    <div class="row">
        <div class="col-xl-2 col-lg-3 col-md-4">
            <?= sidebar("dashboard") ?>
        </div>
        <div class="col-xl-10 col-lg-9 col-md-8">
            <main class="admin">
                <div class="container">
                    <h1>Admin Dashboard</h1>
                    <hr>
                    <div class="row my-4 gy-4">
                        <div class="col">
                            <h5>Election Details</h5>
                            <div class="admin card py-5 text-center flex-row justify-content-around">
                                <div>
                                    <h6 class="text-success">Election Start</h6>
                                    <h2><?= $startDate ?></h2>
                                    <h4><?= $startTime ?></h4>
                                </div>
                                <div>
                                    <h6 class="text-danger">Election End</h6>
                                    <h2><?= $endDate ?></h2>
                                    <h4><?= $endTime ?></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row my-4 gy-4">
                        <div class="col-lg-6">
                            <h5>Election Voters</h5>
                            <div class="admin card py-5 text-center flex-row justify-content-around">
                                <div>
                                    <h1><?php echo countVoters() ?></h1>
                                    <h6>Voters</h6>
                                </div>
                                <div>
                                    <h1><?php echo countVotes() ?></h1>
                                    <h6>Total Votes</h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <h5>Election Candidates</h5>
                            <div class="admin card py-5 text-center">
                                <h1><?php echo countCandidates($totalCandidates); ?></h1>
                                <h6>Candidates</h6>
                            </div>
                        </div>
                    </div>
                    <div class="row my-5">
                        <h5>Election Results</h5>
                        <div class="col">
                            <div class="admin card">
                                <form action="" class="d-flex align-items-center mb-4">
                                    <span class="me-3">Filter by position: </span>
                                    <div>
                                        <select class="form-select" name="position" onchange="window.location = 'admin-dashboard.php?pos=' + this.value">
                                            <option value="President" <?php if ($pos_selected == "President") echo 'selected="selected"' ?>>President</option>
                                            <option value="Vice President" <?php if ($pos_selected == "Vice President") echo 'selected="selected"' ?>>Vice President</option>
                                            <option value="Secretary" <?php if ($pos_selected == "Secretary") echo 'selected="selected"' ?>>Secretary</option>
                                            <option value="Treasurer" <?php if ($pos_selected == "Treasurer") echo 'selected="selected"' ?>>Treasurer</option>
                                            <option value="Representative 1" <?php if ($pos_selected == "Representative 1") echo 'selected="selected"' ?>>1st Year Representative</option>
                                            <option value="Representative 2" <?php if ($pos_selected == "Representative 2") echo 'selected="selected"' ?>>2nd Year Representative</option>
                                            <option value="Representative 3" <?php if ($pos_selected == "Representative 3") echo 'selected="selected"' ?>>3rd Year Representative</option>
                                            <option value="Representative 4" <?php if ($pos_selected == "Representative 4") echo 'selected="selected"' ?>>4th Year Representative</option>
                                        </select>
                                    </div>
                                </form>
                                <h5 class="mb-3"><strong>Ranking</strong></h5>

                                <?php
                                if ($pos_selected == "")
                                    $pos_selected = "President";

                                if (getCandidatesVotes($pos_selected, null) != false && getCandidates($pos_selected, null)->num_rows > 0) {
                                    $result = getCandidatesVotes($pos_selected, null);
                                    $rank = 1;
                                    while ($data = $result->fetch_assoc()) { ?>
                                        <div class="rounded ranking d-flex flex-row align-items-center m-2 px-5 py-3 <?php if ($rank == 1) echo 'bg-yellow';
                                                                                                                        else echo 'bg-gray' ?>">
                                            <h4 class="my-0 me-3">#<?= $rank ?></h4>
                                            <img src="<?php echo $data['image_path'] ?>" class="candidate-img my-0 me-3" alt="candidate image">
                                            <div>
                                                <h5 class=""><?php echo $data['first_name'] . ' ' . $data['last_name'] ?></h5>
                                                <strong class=""><?php echo $data['VOTES'] ?> Votes</strong>
                                            </div>
                                        </div>
                                <?php
                                        $rank++;
                                    }
                                }
                                ?>
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