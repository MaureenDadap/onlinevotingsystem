<?php
session_start();
require_once('common/components.php');
require_once 'config/website_info.php';
require_once 'utils/get-candidates.php';
require_once 'utils/auth.php';

checkInactivity();
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
                if (getCandidates('President') && getCandidates('President')->num_rows > 0) : ?>
                    <div class="row row-cols-2 row-cols-md-2 row-cols-xl-4 mt-4">
                        <?php
                        $result = getCandidates("President");
                        while ($data = $result->fetch_assoc()) :
                        ?>
                            <div class="card candidate p-4">
                                <img src="<?php escapeString($data['image_path']) ?>" class="candidate-img" alt="candidate">
                                <div class="card-body">
                                    <h5 class="card-title"><?php escapeString($data['first_name'] . ' ' . $data['last_name']) ?></h5>
                                    <strong><?php escapeString($data['section']) ?></strong>
                                    <p class="card-text"><?php escapeString($data['description']) ?></p>
                                </div>
                            </div>
                        <?php endwhile ?>
                    </div>
                <?php else : ?>
                    <h5 class="py-5 mx-auto">No candidates in the database.</h5>
                <?php endif ?>
            </div>
            <!-- End Presidents Row -->

            <!-- ======= Vice Presidents Row ======= -->
            <div class="row mb-5">
                <h3>Vice President</h3>
                <?php
                if (getCandidates('Vice President') && getCandidates('Vice President')->num_rows > 0) : ?>
                    <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4 mt-4">
                        <?php
                        $result = getCandidates("Vice President");
                        while ($data = $result->fetch_assoc()) :
                        ?>
                            <div class="card candidate p-4">
                                <img src="<?php escapeString($data['image_path']) ?>" class="candidate-img" alt="candidate">
                                <div class="card-body">
                                    <h5 class="card-title"><?php escapeString($data['first_name'] . ' ' . $data['last_name']) ?></h5>
                                    <strong><?php escapeString($data['section']) ?></strong>
                                    <p class="card-text"><?php escapeString($data['description']) ?></p>
                                </div>
                            </div>
                        <?php endwhile ?>
                    </div>
                <?php else : ?>
                    <h5 class="py-5 mx-auto">No candidates in the database.</h5>
                <?php endif ?>
            </div>
            <!-- End Vice Presidents Row -->

            <!-- ======= Secretaries Row ======= -->
            <div class="row mb-5">
                <h3>Secretary</h3>
                <?php
                if (getCandidates('Secretary') && getCandidates('Secretary')->num_rows > 0) : ?>
                    <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4 mt-4">
                        <?php
                        $result = getCandidates("Secretary");
                        while ($data = $result->fetch_assoc()) :
                        ?>
                            <div class="card candidate p-4">
                                <img src="<?php escapeString($data['image_path']) ?>" class="candidate-img" alt="candidate">
                                <div class="card-body">
                                    <h5 class="card-title"><?php escapeString($data['first_name'] . ' ' . $data['last_name']) ?></h5>
                                    <strong><?php escapeString($data['section']) ?></strong>
                                    <p class="card-text"><?php escapeString($data['description']) ?></p>
                                </div>
                            </div>
                        <?php endwhile ?>
                    </div>
                <?php else : ?>
                    <h5 class="py-5 mx-auto">No candidates in the database.</h5>
                <?php endif ?>
            </div>
            <!-- End Secretaries Row -->

            <!-- ======= Treasurers Row ======= -->
            <div class="row mb-5">
                <h3>Treasurer</h3>
                <?php
                if (getCandidates('Treasurer') && getCandidates('Treasurer')->num_rows > 0) : ?>
                    <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4 mt-4">
                        <?php
                        $result = getCandidates("Treasurer");
                        while ($data = $result->fetch_assoc()) :
                        ?>
                            <div class="card candidate p-4">
                                <img src="<?php escapeString($data['image_path']) ?>" class="candidate-img" alt="candidate">
                                <div class="card-body">
                                    <h5 class="card-title"><?php escapeString($data['first_name'] . ' ' . $data['last_name']) ?></h5>
                                    <strong><?php escapeString($data['section']) ?></strong>
                                    <p class="card-text"><?php escapeString($data['description']) ?></p>
                                </div>
                            </div>
                        <?php endwhile ?>
                    </div>
                <?php else : ?>
                    <h5 class="py-5 mx-auto">No candidates in the database.</h5>
                <?php endif ?>
            </div>
            <!-- End Treasurers Row -->

            <!-- ======= Representatives 1 Row ======= -->
            <div class="row mb-5">
                <h3>1st Year Representative</h3>
                <?php
                if (getCandidates('Representative 1') && getCandidates('Representative 1')->num_rows > 0) : ?>
                    <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4 mt-4">
                        <?php
                        $result = getCandidates("Representative 1");
                        while ($data = $result->fetch_assoc()) :
                        ?>
                            <div class="card candidate p-4">
                                <img src="<?php escapeString($data['image_path']) ?>" class="candidate-img" alt="candidate">
                                <div class="card-body">
                                    <h5 class="card-title"><?php escapeString($data['first_name'] . ' ' . $data['last_name']) ?></h5>
                                    <strong><?php escapeString($data['section']) ?></strong>
                                    <p class="card-text"><?php escapeString($data['description']) ?></p>
                                </div>
                            </div>

                        <?php endwhile ?>
                    </div>
                <?php else : ?>
                    <h5 class="py-5 mx-auto">No candidates in the database.</h5>
                <?php endif ?>
            </div>
            <!-- End Representatives 1 Row -->

            <!-- ======= Representatives 2 Row ======= -->
            <div class="row mb-5">
                <h3>2nd Year Representative</h3>
                <?php
                if (getCandidates('Representative 2') && getCandidates('Representative 2')->num_rows > 0) : ?>
                    <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4 mt-4">
                        <?php
                        $result = getCandidates("Representative 2");
                        while ($data = $result->fetch_assoc()) :
                        ?>
                            <div class="card candidate p-4">
                                <img src="<?php escapeString($data['image_path']) ?>" class="candidate-img" alt="candidate">
                                <div class="card-body">
                                    <h5 class="card-title"><?php escapeString($data['first_name'] . ' ' . $data['last_name']) ?></h5>
                                    <strong><?php escapeString($data['section']) ?></strong>
                                    <p class="card-text"><?php escapeString($data['description']) ?></p>
                                </div>
                            </div>

                        <?php endwhile ?>
                    </div>
                <?php else : ?>
                    <h5 class="py-5 mx-auto">No candidates in the database.</h5>
                <?php endif ?>
            </div>
            <!-- End Representatives 2 Row -->

            <!-- ======= Representatives 3 Row ======= -->
            <div class="row mb-5">
                <h3>3rd Year Representative</h3>
                <?php
                if (getCandidates('Representative 3') && getCandidates('Representative 3')->num_rows > 0) : ?>
                    <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4 mt-4">
                        <?php
                        $result = getCandidates("Representative 3");
                        while ($data = $result->fetch_assoc()) :
                        ?>
                            <div class="card candidate p-4">
                                <img src="<?php escapeString($data['image_path']) ?>" class="candidate-img" alt="candidate">
                                <div class="card-body">
                                    <h5 class="card-title"><?php escapeString($data['first_name'] . ' ' . $data['last_name']) ?></h5>
                                    <strong><?php escapeString($data['section']) ?></strong>
                                    <p class="card-text"><?php escapeString($data['description']) ?></p>
                                </div>
                            </div>

                        <?php endwhile ?>
                    </div>
                <?php else : ?>
                    <h5 class="py-5 mx-auto">No candidates in the database.</h5>
                <?php endif ?>
            </div>
            <!-- End Representatives 3 Row -->

            <!-- ======= Representatives 4 Row ======= -->
            <div class="row mb-5">
                <h3>4th Year Representative</h3>
                <?php
                if (getCandidates('Representative 4') && getCandidates('Representative 4')->num_rows > 0) : ?>
                    <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4 mt-4">
                        <?php
                        $result = getCandidates("Representative 4");
                        while ($data = $result->fetch_assoc()) :
                        ?>
                            <div class="card candidate p-4">
                                <img src="<?php escapeString($data['image_path']) ?>" class="candidate-img" alt="candidate">
                                <div class="card-body">
                                    <h5 class="card-title"><?php escapeString($data['first_name'] . ' ' . $data['last_name']) ?></h5>
                                    <strong><?php escapeString($data['section']) ?></strong>
                                    <p class="card-text"><?php escapeString($data['description']) ?></p>
                                </div>
                            </div>
                        <?php endwhile ?>
                    </div>
                <?php else : ?>
                    <h5 class="py-5 mx-auto">No candidates in the database.</h5>
                <?php endif ?>
            </div>
            <!-- End Representatives 4 Row -->
        </div>
    </main>
    <?php include 'common/footer.php'; ?>
    <script src="js/bootstrap.bundle.js"></script>
</body>

</html>