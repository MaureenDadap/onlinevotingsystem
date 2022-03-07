<?php
session_start();
require_once('common/components.php');
require_once 'config/website_info.php';
require_once 'utils/get-candidates.php';

require_once 'utils/connection.php';

$pos_selected = "";
$response = "";

if (isset($_SESSION['user_type']) && $_SESSION['user_type'] !== "admin") {
    header('location: index.php');
}

if (isset($_GET['pos'])) {
    //TODO VALIDATE/SANITIZE
    $pos_selected = $_GET['pos'];
}

if (isset($_POST['submit']) && isset($_POST['candidate-id'])) {
    //TODO VALIDATE/SANITIZE
    $id = $_POST['candidate-id'];

    if ($_POST['submit'] == "delete") {
        $response = "delete";
    } else if ($_POST['submit'] == "edit") {
        $response = "edit";
    }
}

function getCandidate($candidateId)
{
    //TODO VALIDATE/SANITIZE
    $conn = Connect();

    $query = "SELECT * FROM candidates WHERE id=?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $candidateId);

    $stmt = $conn->prepare($query);
    $stmt->execute();
    $result = $stmt->get_result();

    $conn->close();

    return $result;
}

?>

<!DOCTYPE html>
<html lang="en">
<?= head("Admin Dashboard: Candidates"); ?>

<body class="admin">
    <!-- ======= Add Candidate Modal ======= -->
    <div class="modal fade" id="add-candidate" tabindex="-1" data-bs-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Candidate</h5>
                </div>
                <form action="" method="POST">
                    <div class="modal-body">
                        <div class="row mb-3">
                            <label class="col-form-label">Name:</label>
                            <div class="col">
                                <input type="text" name="first-name" class="form-control" placeholder="First name" required>
                            </div>
                            <div class="col">
                                <input type="text" name="last-name" class="form-control" placeholder="Last name" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="col-form-label">Section:</label>
                            <input type="text" name="section" class="form-control" placeholder="Section" required>
                        </div>
                        <div class="mb-3">
                            <label class="col-form-label">Position:</label>
                            <select class="form-select" name="position" required>
                                <option value="President">President</option>
                                <option value="Vice President">Vice President</option>
                                <option value="Secretary">Secretary</option>
                                <option value="Treasurer">Treasurer</option>
                                <option value="Representative 1">1st Year Representative</option>
                                <option value="Representative 2">2nd Year Representative</option>
                                <option value="Representative 3">3rd Year Representative</option>
                                <option value="Representative 4">4th Year Representative</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="col-form-label">Description:</label>
                            <textarea class="form-control" name="description" rows="3" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="col-form-label">Picture:</label>
                            <input class="form-control" type="file" name="image" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" name="submit" value="add-candidate" class="btn btn-default">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End Add Candidate Modal -->

    <!-- ======= Edit Candidate Modal ======= -->
    <div class="modal fade" id="edit-candidate" tabindex="-1" data-bs-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Candidate Details</h5>
                </div>
                <form action="" method="POST">
                    <div class="modal-body">
                        <div class="row mb-3">
                            <span class="visually-hidden" id="hidden-id"></span>

                            <label class="col-form-label">Name:</label>
                            <div class="col">
                                <input type="text" name="first-name" class="firstname form-control" placeholder="First Name" required>
                            </div>
                            <div class="col">
                                <input type="text" name="last-name" class="form-control" placeholder="Last name" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="col-form-label">Section:</label>
                            <input type="text" name="section" class="form-control" placeholder="Section" required>
                        </div>
                        <div class="mb-3">
                            <label class="col-form-label">Position:</label>
                            <select class="form-select" name="position" required>
                                <option value="President">President</option>
                                <option value="Vice President">Vice President</option>
                                <option value="Secretary">Secretary</option>
                                <option value="Treasurer">Treasurer</option>
                                <option value="Representative 1">1st Year Representative</option>
                                <option value="Representative 2">2nd Year Representative</option>
                                <option value="Representative 3">3rd Year Representative</option>
                                <option value="Representative 4">4th Year Representative</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="col-form-label">Description:</label>
                            <textarea class="form-control" name="description" rows="3" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="col-form-label">Picture:</label>
                            <input class="form-control" type="file" name="image" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" name="submit" value="add-candidate" class="btn btn-default">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End Edit Candidate Modal -->

    <!-- ======= Delete Candidate Modal ======= -->
    <div class="modal fade" id="delete-candidate" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Delete Candidate</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this candidate?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger">Delete</button>
                </div>
            </div>
        </div>
    </div>
    <!-- End Delete Candidate Modal -->

    <div class="row">
        <div class="col-xl-2 col-lg-3 col-md-4">
            <?= sidebar("candidate") ?>
        </div>
        <div class="col-xl-10 col-lg-9 col-md-8">
            <main class="admin">
                <div class="container">
                    <h1>Election Candidates</h1>
                    <hr>
                    <button id="new-candidate-btn" class="btn btn-default" data-bs-toggle="modal" data-bs-target="#add-candidate">
                        <span class="bi-plus-lg"></span> Add New Candidate</button>

                    <div class="admin card mt-3">
                        <form action="" class="d-flex align-items-center mb-4">
                            <span class="me-3">Filter by position: </span>
                            <div>
                                <select class="form-select" name="position" onchange="window.location = 'admin-candidates.php?pos=' + this.value">
                                    <option value="">All</option>
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
                        <?php
                        if (getCandidates($pos_selected) != false && getCandidates($pos_selected)->num_rows > 0) : ?>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">Picture</th>
                                        <th scope="col">Last Name</th>
                                        <th scope="col">First Name</th>
                                        <th scope="col">Position</th>
                                        <th scope="col">Section</th>
                                        <th scope="col">Description</th>
                                        <th scope="col">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $result = getCandidates($pos_selected);
                                    while ($data = $result->fetch_assoc()) : ?>
                                        <form action="" method="POST">
                                            <tr>
                                                <input type="hidden" name="candidate-id" value="<?php echo $data['id']; ?>">
                                                <td><img src="<?php echo $data['image_path'] ?>" alt="" class="rounded"></td>
                                                <td><?php echo $data['last_name'] ?></td>
                                                <td><?php echo $data['first_name'] ?></td>
                                                <td><?php echo $data['position'] ?></td>
                                                <td><?php echo $data['section'] ?></td>
                                                <td><?php echo $data['description'] ?></td>
                                                <td>
                                                    <button class="btn btn-default" type="submit" name="submit" value="edit"><span class="bi-pencil-fill"></span></button>
                                                    <button class="btn btn-danger" type="submit" name="submit" value="delete"><span class="bi-trash-fill"></span></button>
                                                </td>
                                            </tr>
                                        </form>
                                    <?php endwhile ?>
                                </tbody>
                            </table>
                        <?php else : ?>
                            <h5 class="py-5 mx-auto">No candidates in the database.</h5>
                        <?php endif ?>
                    </div>
                </div>
            </main>
        </div>
    </div>
    <script src="js/bootstrap.bundle.js"></script>
    <script src="js/jquery-3.6.0.min.js"></script>
    <script>
        var response = "<?php echo $response ?>";
        var editModal = new bootstrap.Modal($('#edit-candidate'));
        var deleteModal = new bootstrap.Modal($('#delete-candidate'));
        if (response == "edit") {
            editModal.show();
        } else if (response == "delete") {
            deleteModal.show();
        }
    </script>
</body>

</html>