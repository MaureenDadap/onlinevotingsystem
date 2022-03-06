<?php
session_start();
require_once('common/components.php');
require_once 'utils/auth.php';
include('config/website_info.php');
?>

<!DOCTYPE html>
<html lang="en">
<?= head("Admin Signup"); ?>

<body>
    <?= navbar("") ?>
    <main>
        <div class="container">
            <header class="text-center mb-5">
                <h1>Hi, Admin</h1>
                <h3>Welcome to <span><?= WEBSITE_NAME ?></span></h3>
                <p>Get started by creating your account.</p>
            </header>
            <div class="row justify-content-center">
                <div class="col-md-6 col-lg-4">
                    <img src="images/sammy-35.png" alt="art" class="w-100">
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="card">
                        <div class="card-header">Create Account</div>
                        <div class="card-body">
                            <form action="" method="POST">
                                <label for="email" class="form-label">Email</label>
                                <div class="input-group mb-2">
                                    <span class="input-group-text bi-envelope-fill"></span>
                                    <input type="text" class="form-control" id="email" name="email" required>
                                </div>
                                <label for="username" class="form-label">Username</label>
                                <div class="input-group mb-2">
                                    <span class="input-group-text bi-person-fill"></span>
                                    <input type="text" class="form-control" id="username" name="username" required>
                                </div>
                                <label for="password" class="form-label">Password</label>
                                <div class="input-group mb-2">
                                    <span class="input-group-text bi-lock-fill"></span>
                                    <input type="password" class="form-control" id="password" name="password" minlength="8" required>
                                </div>
                                <p class="form-text text-muted mb-2">Password must be at least 8 characters long.</p>

                                <label for="password2" class="form-label">Re-type your password</label>
                                <div class="input-group mb-4">
                                    <span class="input-group-text bi-lock-fill"></span>
                                    <input type="password" class="form-control" id="password2" name="password2" minlength="8" required>
                                </div>
                                <?php if (isset($_POST['submit'])) :
                                    adminSignUp();
                                endif ?>
                                <button type="submit" name="submit" class="btn btn-lg btn-default w-100 mb-2">Sign Up</button>
                            </form>
                            <p class="text-center">Already have an account? <a href="login.php">Log In</a> instead.</p>
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