<?php
session_start();
require_once('common/components.php');
require_once 'utils/connection.php';
include('common/website_info.php');

if (isset($_POST['submit'])) {
    $conn = Connect();

    $username = $conn->real_escape_string($_POST['username']);
    $email = $conn->real_escape_string($_POST['email']);
    $password = $conn->real_escape_string($_POST['password']);

    $query = "INSERT into admins(username,email,password) VALUES('" . $username . "','" . $email . "','" . $password . "')";
    $success = $conn->query($query);

    if (!$success) {
        $error = ("Couldnt enter data: " . $conn->error);
    } else {
        $response = "success";
    }

    $conn->close();
}


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
                <h3>Welcome to <span><?= $website_name ?></span></h3>
                <p>Get started by creating your account.</p>
            </header>
            <div class="row justify-content-center">
                <div class="col-lg-4">
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
                                <div class="input-group mb-5">
                                    <span class="input-group-text bi-lock-fill"></span>
                                    <input type="password" class="form-control" id="password" name="password" required>
                                </div>

                                <button type="submit" name="submit" class="btn btn-lg btn-primary w-100">Sign Up</button>
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