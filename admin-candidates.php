<?php
session_start();
require_once('common/components.php');
require_once 'config/website_info.php';
require_once 'utils/get-candidates.php';
require_once 'utils/connection.php';
require_once 'utils/auth.php';
require_once 'utils/helpers.php';

checkInactivity();

$pos_selected = "";
$response = "";
$candidateId = -1;

if (isset($_SESSION['user_type']) && $_SESSION['user_type'] !== "admin") {
    header('location: index.php');
}

if (isset($_GET['pos'])) {
    $pos_selected = $_GET['pos'];
}

if (isset($_POST['submit']) && isset($_POST['candidate-id'])) {
    // Check Anti-CSRF token
    checkToken($_REQUEST['user_token'], $_SESSION['session_token'], 'admin-candidates.php');

    $candidateId = filter_var($_POST['candidate-id'], FILTER_SANITIZE_NUMBER_INT);

    if ($_POST['submit'] === "delete") {
        $response = "delete"; // to show the delete modal
    } else if ($_POST['submit'] === "edit") {
        $response = "edit"; // to show the edit modal
    }
}

if (isset($_POST['add'])) {
    // Check Anti-CSRF token
    checkToken($_REQUEST['user_token'], $_SESSION['session_token'], 'admin-candidates.php');

    //TODO VALIDATE/SANITIZE
    $conn = Connect();
    $first_name = $conn->escape_string($_POST['first-name']);
    $last_name = $conn->escape_string($_POST['last-name']);
    $position = $conn->escape_string($_POST['position']);
    $section = $conn->escape_string($_POST['section']);
    $description = $conn->escape_string($_POST['description']);
    $image_dir = "images/";
    $image = $conn->escape_string($_POST['image']);
    $image_path = $image_dir . $image;

    $query = "INSERT INTO candidates(id,last_name,first_name,position,section,description,image_path) values(?,?,?,?,?,?,?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('issssss', $id, $last_name, $first_name, $position, $section, $description, $image_path);
    $stmt->execute();
    $conn->close();
    header('location: admin-candidates.php');
}

if (isset($_POST['delete']) && isset($_POST['candidate-id'])) {
    // Check Anti-CSRF token
    checkToken($_REQUEST['user_token'], $_SESSION['session_token'], 'admin-candidates.php');

    $candidateId = filter_var($_POST['candidate-id'], FILTER_SANITIZE_NUMBER_INT);

    $conn = Connect();
    $query = "DELETE FROM candidates where id=?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $candidateId);
    $stmt->execute();
    $conn->close();
    header('location: admin-candidates.php');
}

if (isset($_POST['edit']) && isset($_POST['candidate-id'])) {
    // Check Anti-CSRF token
    checkToken($_REQUEST['user_token'], $_SESSION['session_token'], 'admin-candidates.php');

    $candidateId = filter_var($_POST['candidate-id'], FILTER_SANITIZE_NUMBER_INT);
    $conn = Connect();

    //TODO VALIDATE/SANITIZE
    $first_name = $conn->escape_string($_POST['first-name']);
    $last_name = $conn->escape_string($_POST['last-name']);
    $position = $conn->escape_string($_POST['position']);
    $section = $conn->escape_string($_POST['section']);
    $description = $conn->escape_string($_POST['description']);
    $image_dir = "images/";
    $image = $conn->escape_string($_POST['image']);
    $image_path = $image_dir . $image;

    $query = "UPDATE candidates SET last_name = ?, first_name = ?, position = ?, section = ?, description = ?, image_path = ? WHERE id = ?"; //dito pag pinalitan ko yung question mark ng static number pati pag inalis yung "i" at $id sa line 91 gumagana naman siya
    $stmt = $conn->prepare($query);
    $stmt->bind_param('ssssssi', $last_name, $first_name, $position, $section, $description, $image_path, $candidateId);
    $stmt->execute();
    $conn->close();
    header('location: admin-candidates.php');
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
                    <input type="hidden" name="user_token" value="<?php escapeString($_SESSION['session_token']) ?>">
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
                        <button type="submit" name="add" class="btn btn-default">Submit</button>
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
                    <?php

                    //For the placeholder texts
                    $first_name = "First Name";
                    $last_name = "Last Name";
                    $section = "Section";
                    $position = "President";
                    $description = "Description";

                    if (getCandidateByID($candidateId) != false && getCandidateByID($candidateId)->num_rows > 0) {
                        $result = getCandidateByID($candidateId);
                        while ($data = $result->fetch_assoc()) {
                            //For the placeholder texts
                            $first_name = $data['first_name'];
                            $last_name = $data['last_name'];
                            $section = $data['section'];
                            $position = $data['position'];
                            $description = $data['description'];
                        }
                    }
                    ?>
                    <input type="hidden" name="user_token" value="<?php escapeString($_SESSION['session_token']) ?>">
                    <input type="hidden" name="candidate-id" value="<?php escapeString($candidateId) ?>">
                    <div class="modal-body">
                        <div class="row mb-3">
                            <span class="visually-hidden" id="hidden-id"></span>

                            <label class="col-form-label">Name:</label>
                            <div class="col">
                                <input type="text" name="first-name" class="firstname form-control" value="<?php echo $first_name ?>" required>
                            </div>
                            <div class="col">
                                <input type="text" name="last-name" class="form-control" value="<?php echo $last_name ?>" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="col-form-label">Section:</label>
                            <input type="text" name="section" class="form-control" value="<?php echo $section ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="col-form-label">Position:</label>
                            <select class="form-select" name="position" required>
                                <option value="President" <?php if ($position == "President") echo 'selected="selected"' ?>>President</option>
                                <option value="Vice President" <?php if ($position == "Vice President") echo 'selected="selected"' ?>>Vice President</option>
                                <option value="Secretary" <?php if ($position == "Secretary") echo 'selected="selected"' ?>>Secretary</option>
                                <option value="Treasurer" <?php if ($position == "Treasurer") echo 'selected="selected"' ?>>Treasurer</option>
                                <option value="Representative 1" <?php if ($position == "Representative 1") echo 'selected="selected"' ?>>1st Year Representative</option>
                                <option value="Representative 2" <?php if ($position == "Representative 2") echo 'selected="selected"' ?>>2nd Year Representative</option>
                                <option value="Representative 3" <?php if ($position == "Representative 3") echo 'selected="selected"' ?>>3rd Year Representative</option>
                                <option value="Representative 4" <?php if ($position == "Representative 4") echo 'selected="selected"' ?>>4th Year Representative</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="col-form-label">Description:</label>
                            <textarea class="form-control" name="description" rows="3" required><?php escapeString($description) ?></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="col-form-label">Picture:</label>
                            <input class="form-control" type="file" name="image" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" name="edit" class="btn btn-default">Submit</button>
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
                <form action="" method="POST">
                    <input type="hidden" name="user_token" value="<?php escapeString($_SESSION['session_token']) ?>">
                    <input type="hidden" name="candidate-id" value="<?php escapeString($candidateId) ?>">
                    <div class="modal-body">
                        Are you sure you want to delete this candidate?
                    </div>
                    <div class="modal-footer">
                        <button type="submit" name="delete" class="btn btn-danger">Delete</button>
                    </div>
                </form>
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
                                        <th scope="col">ID</th>
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
                                            <input type="hidden" name="user_token" value="<?php escapeString($_SESSION['session_token']) ?>">
                                            <tr>
                                                <input type="hidden" name="candidate-id" value="<?php echo $data['id'] ?>">
                                                <td><?php escapeString($data['id']) ?></td>
                                                <td><img src="<?php escapeString($data['image_path']) ?>" alt="" class="rounded"></td>
                                                <td><?php escapeString($data['last_name']) ?></td>
                                                <td><?php escapeString($data['first_name']) ?></td>
                                                <td><?php escapeString($data['position']) ?></td>
                                                <td><?php escapeString($data['section']) ?></td>
                                                <td><?php escapeString($data['description']) ?></td>
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