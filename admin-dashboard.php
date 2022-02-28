<?php
session_start();
require_once('common/components.php');
include('common/website_info.php');
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
                        <h5>Election Candidates</h5>
                        <div class="col">
                            <div class="card py-5 text-center">
                                <h1>3</h1>
                                <h6>Partylists</h6>
                            </div>
                        </div>
                        <div class="col">
                        <div class="card py-5 text-center">
                                <h1>30</h1>
                                <h6>Candidates</h6>
                            </div>
                        </div>
                    </div>
                    <div class="row my-4">
                        <h5>Election Voters</h5>
                        <div class="col">
                            <div class="card py-5 text-center">
                                <h1>100</h1>
                                <h6>Voters</h6>
                            </div>
                        </div>
                        <div class="col">
                        <div class="card py-5 text-center">
                                <h1>67</h1>
                                <h6>Votes</h6>
                            </div>
                        </div>
                    </div>
                    <div class="row my-4">
                        <h5>Election Details</h5>
                        <div class="col">
                            <div class="card py-5 text-center">
                                <h1>February 16 - February 17</h1>
                                <h6>Election Duration</h6>
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