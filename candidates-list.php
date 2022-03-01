<?php
session_start();
require_once('common/components.php');
include('common/website_info.php');
require_once 'utils/connection.php';

function getCandidates($position)
{
    //TODO VALIDATE/SANITIZE
    $conn = Connect();
    if ($position != "") {
        $query = "SELECT * FROM candidates WHERE position=?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('s', $position);
    } else {
        $query = "SELECT * FROM candidates";
        $stmt = $conn->prepare($query);
    }

    $stmt->execute();
    $result = $stmt->get_result();

    $conn->close();

    return $result;
}
?>

<!DOCTYPE html>
<html lang="en">
<?= head("Candidates List"); ?>

<body>
    <?= navbar("candidates"); ?>
    <header class="results py-3">
        <div class="container">
            <div class="row justify-content-center align-items-center">
                <div class="col-md-3">
                    <img src="images/sammy-25.png" alt="img" class="w-100">
                </div>
                <div class="col-md-3">
                    <h1>Candidates List</h1>
                </div>
            </div>
        </div>
    </header>
    <main>
        <div class="container">
            <!-- ======= Presidents Row ======= -->
            <div class="row mb-5">
                <h3>President</h3>
                <?php
                if (getCandidates('President') && getCandidates('President')->num_rows > 0) { ?>
                    <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4 mt-4">
                        <?php
                        $result = getCandidates("President");
                        while ($data = $result->fetch_assoc()) {
                        ?>
                            <div class="card candidate p-4">
                                <img src="<?php echo $data['image_path'] ?>" class="candidate-img" alt="candidate">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo $data['first_name'] . ' ' . $data['last_name'] ?></h5>
                                    <strong><?php echo $data['section'] ?></strong>
                                    <p class="card-text"><?php echo $data['description'] ?></p>
                                </div>
                            </div>
                    </div>
                <?php  }
                    } else { ?>
                <h5 class="py-5 mx-auto">No candidates in the database.</h5>
            <?php  } ?>
            </div>
            <!-- End Presidents Row -->

            <!-- ======= Vice Presidents Row ======= -->
            <div class="row mb-5">
                <h3>Vice President</h3>
                <?php
                if (getCandidates('Vice President') && getCandidates('Vice President')->num_rows > 0) { ?>
                    <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4 mt-4">
                        <?php
                        $result = getCandidates("Vice President");
                        while ($data = $result->fetch_assoc()) {
                        ?>
                            <div class="card candidate p-4">
                                <img src="<?php echo $data['image_path'] ?>" class="candidate-img" alt="candidate">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo $data['first_name'] . ' ' . $data['last_name'] ?></h5>
                                    <strong><?php echo $data['section'] ?></strong>
                                    <p class="card-text"><?php echo $data['description'] ?></p>
                                </div>
                            </div>
                    </div>
                <?php  }
                    } else { ?>
                <h5 class="py-5 mx-auto">No candidates in the database.</h5>
            <?php  } ?>
            </div>
            <!-- End Vice Presidents Row -->

            <!-- ======= Secretaries Row ======= -->
            <div class="row mb-5">
                <h3>Secretary</h3>
                <?php
                if (getCandidates('Secretary') && getCandidates('Secretary')->num_rows > 0) { ?>
                    <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4 mt-4">
                        <?php
                        $result = getCandidates("Secretary");
                        while ($data = $result->fetch_assoc()) {
                        ?>
                            <div class="card candidate p-4">
                                <img src="<?php echo $data['image_path'] ?>" class="candidate-img" alt="candidate">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo $data['first_name'] . ' ' . $data['last_name'] ?></h5>
                                    <strong><?php echo $data['section'] ?></strong>
                                    <p class="card-text"><?php echo $data['description'] ?></p>
                                </div>
                            </div>
                    </div>
                <?php  }
                    } else { ?>
                <h5 class="py-5 mx-auto">No candidates in the database.</h5>
            <?php  } ?>
            </div>
            <!-- End Secretaries Presidents Row -->

            <!-- ======= Treasurers Row ======= -->
            <div class="row mb-5">
                <h3>Treasurer</h3>
                <?php
                if (getCandidates('Treasurer') && getCandidates('Treasurer')->num_rows > 0) { ?>
                    <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4 mt-4">
                        <?php
                        $result = getCandidates("Treasurer");
                        while ($data = $result->fetch_assoc()) {
                        ?>
                            <div class="card candidate p-4">
                                <img src="<?php echo $data['image_path'] ?>" class="candidate-img" alt="candidate">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo $data['first_name'] . ' ' . $data['last_name'] ?></h5>
                                    <strong><?php echo $data['section'] ?></strong>
                                    <p class="card-text"><?php echo $data['description'] ?></p>
                                </div>
                            </div>
                    </div>
                <?php  }
                    } else { ?>
                <h5 class="py-5 mx-auto">No candidates in the database.</h5>
            <?php  } ?>
            </div>
            <!-- End Secretaries Presidents Row -->
        </div>
    </main>
    <?php include 'common/footer.php'; ?>
    <script src="js/bootstrap.bundle.js"></script>
</body>

</html>