<?php
session_start();
require_once('common/components.php');
include('common/website_info.php');
require_once 'utils/connection.php';

function logIn()
{
    // Define $username and $password
    $username = $_POST['username'];
    $password = $_POST['password'];
    $user_type = 0;
    $id = -1;
    $conn = Connect();

    // SQL query to fetch information of registerd users and finds user match.
    $query = 'SELECT id, username, password, is_admin FROM users WHERE username=? AND password=? LIMIT 1';

    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $stmt->bind_result($id, $username, $password, $user_type);
    $stmt->store_result();

    if ($stmt->fetch()) {
        $_SESSION['user_id'] = $id;

        if ($user_type == 0)
            $_SESSION['user_type'] = 'student';
        else
            $_SESSION['user_type'] = 'admin';

        header("location: index.php");
    } else {
        echo '
    <div class="alert alert-danger" role="alert">
    Invalid user!
    </div>';
    }

    $conn->close();
}
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
                                <div class="input-group mb-4">
                                    <span class="input-group-text bi-lock-fill"></span>
                                    <input type="password" class="form-control" id="password" name="password" required>
                                </div>
                                <button type="submit" name="submit" class="btn btn-lg btn-default w-100 mb-4">Log In</button>
                                <?php
                                if (isset($_POST['submit'])) {
                                    logIn();
                                } ?>
                            </form>
                            <p class="text-center">Don't have an account? <br> <a href="student-signup.php">Register as Student</a> or <a href="admin-signup.php">Register as Admin</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <?php include 'common/footer.php';?>
    <script src="js/bootstrap.bundle.js"></script>
</body>

</html>