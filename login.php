<?php
session_start();
require_once('utils/signin.php');
require_once('common/components.php');
include('common/website_info.php');
?>

<!DOCTYPE html>
<html lang="en">
<?= head("Login"); ?>

<body>
    <?= navbar("") ?>
    <main>
        <div class="container">
            <div class="text-center">
                <h2>Welcome to <span><?= $website_name ?></span></h2>
                <p>Cast your votes or manage students by logging in.</p>
            </div>
            <div class="row mt-5 justify-content-center align-items-center">
                <div class="col-md-6 col-lg-4">
                    <img src="images/sammy-logget-out.png" alt="art" class="w-100">
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="card">
                        <div class="card-header">Log in to my account</div>
                        <div class="card-body">
                            <form action="" method="POST">
                                <label for="username" class="form-label">Username</label>
                                <div class="input-group mb-2">
                                    <span class="input-group-text bi-person-fill"></span>
                                    <input type="text" class="form-control" id="username" name="username" required>
                                </div>
                                <label for="password" class="form-label">Password</label>
                                <div class="input-group mb-5">
                                    <span class="input-group-text bi-lock-fill"></span>
                                    <input type="password" class="form-control" id="password" name="password" required>
                                </div>
                                <button type="submit" name="submit" class="btn btn-lg btn-default w-100 mb-4">Log In</button>
                                <?php
                                if (isset($_POST['submit'])) {
                                    if (!empty($_POST['username']) && !empty($_POST['password'])) {
                                        logIn();
                                    }
                                } ?>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <?= footer() ?>
    <script src="js/bootstrap.bundle.js"></script>
</body>

</html>