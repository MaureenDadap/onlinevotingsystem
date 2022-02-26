<?php
session_start();
require_once('common/components.php');
include('common/website_info.php');
require_once('utils/register.php');

if (isset($_POST['submit'])) {
    studentSignUp();
}
?>

<!DOCTYPE html>
<html lang="en">
<?= head("Student Signup"); ?>

<body>
    <?= navbar("") ?>
    <main>
        <div class="container">
            <header class="text-center mb-5">
                <h1>Hi, Student</h1>
                <h3>Welcome to <span><?= $website_name ?></span></h3>
                <p>Get started by creating your account.</p>
            </header>
            <div class="row justify-content-center">
                <div class="col-md-6 col-lg-4">
                    <img src="images/sammy-workflow.png" alt="art" class="w-100">
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
                                    <input type="password" class="form-control" id="password" name="password" required>
                                </div>
                                <label for="program" class="form-label">Program</label>
                                <select class="form-select mb-5" id="program" required>
                                    <option selected>BSCS</option>
                                    <option value="1">BSIT</option>
                                    <option value="2">BSIS</option>
                                    <option value="3">BMMA</option>
                                </select>
                                <button type="submit" name="submit" class="btn btn-lg btn-default w-100">Sign Up</button>
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