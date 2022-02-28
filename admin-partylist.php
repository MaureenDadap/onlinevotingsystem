<?php
session_start();
require_once('common/components.php');
include('common/website_info.php');
?>

<!DOCTYPE html>
<html lang="en">
<?= head("Admin Dashboard: Partylists"); ?>

<body class="admin">
    <div class="row">
        <div class="col-xl-2 col-lg-3 col-md-4">
            <?= sidebar("party") ?>
        </div>
        <div class="col-xl-10 col-lg-9 col-md-8">
            <main class="admin">
                <div class="container">
                    <h1>Election Partylists</h1>
                    <hr>
                    <form action="">
                        <label for="program" class="form-label">Program</label>
                        <select class="form-select mb-2" id="program" name="program" required>
                            <option value="BSCS">BSCS</option>
                            <option value="BSIT">BSIT</option>
                            <option value="BSIS">BSIS</option>
                            <option value="BSMMA">BSMMA</option>
                        </select>
                    </form>
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">First</th>
                                <th scope="col">Last</th>
                                <th scope="col">Handle</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row">1</th>
                                <td>Mark</td>
                                <td>Otto</td>
                                <td>@mdo</td>
                            </tr>
                            <tr>
                                <th scope="row">2</th>
                                <td>Jacob</td>
                                <td>Thornton</td>
                                <td>@fat</td>
                            </tr>
                            <tr>
                                <th scope="row">3</th>
                                <td colspan="2">Larry the Bird</td>
                                <td>@twitter</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </main>
        </div>
    </div>
    <script src="js/bootstrap.bundle.js"></script>
</body>

</html>