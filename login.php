<?php
session_start();
require_once('common/components.php');
include('config/website_info.php');
require_once 'utils/auth.php';
require_once 'utils/helpers.php';

if (isset($_SESSION['username']))
    header('location: index.php');

$response = "";
if (isset($_POST['submit']))
    $response = logIn($response);

// Anti-CSRF
generateSessionToken();
?>

<!DOCTYPE html>
<html lang="en">
<?= head("Login"); ?>

<body>
    <?= navbar("") ?>
    <main>
        <div class="container">
            <div class="text-center">
                <h2>Welcome to <span><?= WEBSITE_NAME ?></span></h2>
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
                                <div class="input-group mb-4">
                                    <span class="input-group-text bi-lock-fill"></span>
                                    <input type="password" class="form-control" id="password" name="password" required>
                                </div>
                                <?php
                                if ($response === "wrong credentials") : ?>
                                    <div class="alert alert-danger" role="alert">
                                        Invalid User!
                                    </div>
                                <?php
                                endif;
                                if ($response === "not authenticated") : ?>
                                    <div class="alert alert-danger" role="alert">
                                        You must be authenticated in order to log in!
                                    </div>
                                <?php endif; ?>
                                <button type="submit" name="submit" class="btn btn-lg btn-default w-100 mb-2">Log In</button>
                            </form>
                            <p class="text-center">Don't have an account? <br> <a href="student-signup.php">Register as Student</a> or <a href="admin-signup.php">Register as Admin</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <?php include 'common/footer.php'; ?>
    <script src="js/bootstrap.bundle.js"></script>
</body>

</html>