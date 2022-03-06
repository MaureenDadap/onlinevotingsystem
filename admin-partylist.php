<?php
session_start();
require_once('common/components.php');
include('common/website_info.php');
require_once 'utils/connection.php';

$party_selected = "";
if (isset($_GET['id'])) {
    $party_selected = $_GET['id'];
}

function getPartylists()
{
    $conn = Connect();
    $query = 'SELECT * FROM partylists';

    $stmt = $conn->prepare($query);
    $stmt->execute();
    $result = $stmt->get_result();
    $conn->close();

    return $result;
}

function getCandidates($party_selected)
{
    $conn = Connect();
    $query = "SELECT a.*, b.name FROM candidates a, partylists b WHERE a.partylist_id = b.id AND b.name =?";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $party_selected);
    $stmt->execute();
    $result = $stmt->get_result();

    $conn->close();

    return $result;
}

$partySelect = "";

if (getPartylists()->num_rows === 0) {
    $partySelect = "disabled";
}


?>

<!DOCTYPE html>
<html lang="en">
<?= head("Admin Dashboard: Partylists"); ?>

<body class="admin">
    <!-- ======= Adding New Party Modal ======= -->
    <div class="modal fade" id="new-party" tabindex="-1" data-bs-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Create New Partylist</h5>
                </div>
                <form action="utils/party-add.php" method="POST">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="col-form-label">Partylist Name:</label>
                            <input type="text" class="form-control" name="party-name" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" name="submit" value="party" class="btn btn-default">Create Partylist</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End adding new party modal -->

    <!-- ======= Editing Candidate / Position Modal ======= -->
    <div class="modal fade" id="edit-position" tabindex="-1" data-bs-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Position Candidate</h5>
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
                            <label class="col-form-label">Description:</label>
                            <textarea class="form-control" name="description" rows="3" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="col-form-label">Picture:</label>
                            <input class="form-control" type="file" id="photoInput" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" name="submit" value="party" class="btn btn-default">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End Editing Candidate / Position Modal -->

    <div class="row">
        <div class="col-xl-2 col-lg-3 col-md-4">
            <?= sidebar("party") ?>
        </div>
        <div class="col-xl-10 col-lg-9 col-md-8">
            <main class="admin">
                <div class="container">
                    <h1>Election Partylists</h1>
                    <hr>
                    <button id="new-party-btn" class="btn btn-default" data-bs-toggle="modal" data-bs-target="#new-party">
                        <span class="bi-plus-lg"></span> Create New Partylist</button>

                    <div class="admin card mt-3">
                        <form action="" class="d-flex mb-4">
                            <div>
                                <select class="form-select" id="partylist" name="partylist" onchange="window.location = 'admin-partylist.php?id=' + this.value" <?= $partySelect ?>>
                                    <option value="">Choose...</option>
                                    <?php
                                    $result = getPartylists();
                                    while ($data = $result->fetch_assoc()) :
                                        $name = $data['name'];
                                        $isSelected = "";
                                        if ($name === $party_selected)
                                            $isSelected = 'selected="selected"';
                                        echo '<option value="' . $name . '"' . $isSelected . '")>' . $name . '</option>';
                                    endwhile ?>
                                </select>
                            </div>
                        </form>
                        <?php
                        if ($party_selected != "") : ?>
                            <h3 class="me-3"><?= $party_selected ?></h3>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">Position</th>
                                        <th scope="col">Picture</th>
                                        <th scope="col">Last Name</th>
                                        <th scope="col">First Name</th>
                                        <th scope="col">Section</th>
                                        <th scope="col">Description</th>
                                        <th scope="col">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $result = getCandidates($party_selected);
                                    while ($data = $result->fetch_assoc()) :
                                    ?>

                                        <tr>
                                            <td><img src="<?php echo $data['image_path'] ?>" alt="" class="rounded"></td>
                                            <td><?php echo $data['last_name'] ?></td>
                                            <td><?php echo $data['first_name'] ?></td>
                                            <td><?php echo $data['position'] ?></td>
                                            <td><?php echo $data['section'] ?></td>
                                            <td><?php echo $data['description'] ?>.</td>
                                            <td><button class="btn btn-default" data-bs-toggle="modal" data-bs-target="#edit-position"><span class="bi-pencil-fill"></span></button></td>
                                        </tr>

                                    <?php endwhile ?>
                                </tbody>
                            </table>
                        <?php else : ?>
                            <h5 class="py-5 mx-auto">No partylist is selected.</h5>
                        <?php endif ?>
                    </div>
                </div>
            </main>
        </div>
    </div>
    <script src="js/bootstrap.bundle.js"></script>
</body>

</html>