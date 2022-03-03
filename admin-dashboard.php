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

function countCandidates($totalCandidates) {
    $result = getCandidates("");
    if ($result && $result->num_rows > 0) {
        while ($result->fetch_assoc()) {
            $totalCandidates++;
        }
    }
    return $totalCandidates;
}

$totalCandidates = 0;
$startDate = date('y/m/d G:i A', strtotime(getStartDate()));
$endDate = date('y/m/d G:i A', strtotime(getEndDate()));
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
                    <div class="row my-4">
                        <div class="col-lg-8">
                            <h5>Election Details</h5>
                            <div class="admin card py-5 text-center">
                                <h2><?= $startDate ?> - <?= $endDate ?></h2>
                                <h6>Election Duration</h6>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <h5>Election Candidates</h5>
                            <div class="admin card py-5 text-center">
                                <h1><?php echo countCandidates($totalCandidates); ?></h1>
                                <h6>Candidates</h6>
                            </div>
                        </div>
                    </div>
                    <div class="row my-4">
                        <h5>Election Voters</h5>
                        <div class="col">
                            <div class="admin card py-5 text-center">
                                <h1><?php echo countVoters()?></h1>
                                <h6>Voters</h6>
                            </div>
                        </div>
                        <div class="col">
                            <div class="admin card py-5 text-center">
                                <h1><?php echo countVotes("") ?></h1>
                                <h6>Total Votes</h6>
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