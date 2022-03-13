<?php
session_start();
require_once  'common/components.php';
require_once 'config/website_info.php';
require_once 'utils/get-voters.php';
require_once 'utils/auth.php';
require_once 'utils/helpers.php';

checkInactivity();

//Check if user is logged out or is not an admin
if (!isset($_SESSION['user_type']) || (isset($_SESSION['user_type']) && $_SESSION['user_type'] !== "admin")) {
    header('location: index.php');
}

$program_selected = "";
$voterID = -1;

if (isset($_GET['program'])) {
    $program_selected = $_GET['program'];
}

if (isset($_POST['submit']) && isset($_POST['voter-id'])) {
    // Check Anti-CSRF token
    checkToken($_REQUEST['user_token'], $_SESSION['session_token'], 'admin-voters.php');

    $voterID = filter_var($_POST['voter-id'], FILTER_SANITIZE_NUMBER_INT);

    if ($_POST['submit'] === "delete") {
        $response = "delete"; // to show the delete modal
    }
}

if (isset($_POST['delete']) && isset($_POST['voter-id'])) {
    // Check Anti-CSRF token
    checkToken($_REQUEST['user_token'], $_SESSION['session_token'], 'admin-voters.php');

    $voterID = filter_var($_POST['voter-id'], FILTER_SANITIZE_NUMBER_INT);

    $conn = Connect();
    $query = "DELETE FROM users where id=?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $voterID);
    $stmt->execute();
    $conn->close();
    header('location: admin-voters.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<?= head("Admin Dashboard: Voters") ?>

<body class="admin">
    <div class="row">
        <div class="col-xl-2 col-lg-3 col-md-4">
            <?= sidebar("voters") ?>
        </div>


        <!-- ======= Delete Voter Modal ======= -->
        <div class="modal fade" id="delete-voter" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Delete Voter</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <form action="" method="POST">
                        <input type="hidden" name="user_token" value="<?php escapeString($_SESSION['session_token']) ?>">
                        <input type="hidden" name="voter-id" value="<?php escapeString($voterID) ?>">
                        <div class="modal-body">
                            Are you sure you want to delete this voter?
                        </div>
                        <div class="modal-footer">
                            <button type="submit" name="delete" class="btn btn-danger">Delete</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- End Delete Voter Modal -->


        <div class="col-xl-10 col-lg-9 col-md-8">
            <main class="admin">
                <div class="container">
                    <h1>Election Voters</h1>
                    <hr>
                    <div class="admin card mt-3">
                        <form action="" class="d-flex align-items-center mb-4">
                            <span class="me-3">Filter by program: </span>
                            <div>
                                <select class="form-select" id="program" name="program" onchange="window.location = 'admin-voters.php?program=' + this.value">
                                    <option value="">All</option>
                                    <option value="BSCS" <?php if ($program_selected == "BSCS") echo 'selected="selected"' ?>>BSCS</option>
                                    <option value="BSIT" <?php if ($program_selected == "BSIT") echo 'selected="selected"' ?>>BSIT</option>
                                    <option value="BSIS" <?php if ($program_selected == "BSIS") echo 'selected="selected"' ?>>BSIS</option>
                                    <option value="BSMMA" <?php if ($program_selected == "BSMMA") echo 'selected="selected"' ?>>BSMMA</option>
                                    <option value="BSA" <?php if ($program_selected == "BSA") echo 'selected="selected"' ?>>BSA</option>
                                    <option value="BSPSYCH" <?php if ($program_selected == "BSPSYCH") echo 'selected="selected"' ?>>BSPSYCH</option>
                                    <option value="BSBA" <?php if ($program_selected == "BSBA") echo 'selected="selected"' ?>>BSBA</option>
                                    <option value="BSCE" <?php if ($program_selected == "BSCE") echo 'selected="selected"' ?>>BSCE</option>
                                </select>
                            </div>
                        </form>
                        <?php
                        $result = getVotersByProgram($program_selected);
                        if ($result && $result->num_rows > 0) : ?>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">ID</th>
                                        <th scope="col">Last Name</th>
                                        <th scope="col">First Name</th>
                                        <th scope="col">Student ID</th>
                                        <th scope="col">Program</th>
                                        <th scope="col">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    while ($data = $result->fetch_assoc()) : ?>
                                        <form action="" method="POST">
                                            <input type="hidden" name="user_token" value="<?php escapeString($_SESSION['session_token']) ?>">
                                            <tr>
                                                <input type="hidden" name="voter-id" value="<?php echo $data['id'] ?>">
                                                <td><?php escapeString($data['id']) ?></td>
                                                <td><?php escapeString($data['last_name']) ?></td>
                                                <td><?php escapeString($data['first_name']) ?></td>
                                                <td><?php escapeString($data['student_id']) ?></td>
                                                <td><?php escapeString($data['program']) ?></td>
                                                <td>
                                                    <button class="btn btn-danger" type="submit" name="submit" value="delete"><span class="bi-trash-fill"></span></button>
                                                </td>
                                            </tr>
                                        </form>
                                    <?php endwhile ?>
                                </tbody>
                            </table>
                        <?php else : ?>
                            <h5 class="py-5 mx-auto">No voters in the database.</h5>
                        <?php endif ?>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script src="js/bootstrap.bundle.js"></script>
    <script src="js/jquery-3.6.0.min.js"></script>
    <script>
        var response = "<?php escapeString($response) ?>";
        var deleteModal = new bootstrap.Modal($('#delete-voter'));
        if (response == "delete") {
            deleteModal.show();
        }
    </script>
</body>

</html>