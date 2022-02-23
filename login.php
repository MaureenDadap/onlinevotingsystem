<?php
session_start();
require_once('utils/connection.php');
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
            <h2 class="text-center">Welcome to <span><?= $website_name ?></span></h2>
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
                                        // Define $username and $password
                                        $username = $_POST['username'];
                                        $password = $_POST['password'];
                                        $conn = Connect();

                                        // SQL query to fetch information of registerd users and finds user match.
                                        $query = "SELECT username, password FROM users WHERE username=? AND password=? LIMIT 1";

                                        $stmt = $conn->prepare($query);
                                        $stmt->bind_param("ss", $username, $password);
                                        $stmt->execute();
                                        $stmt->bind_result($username, $password);
                                        $stmt->store_result();

                                        if ($stmt->fetch()) {
                                            $_SESSION['user_type'] = 'student'; // Initializing Session
                                            header("location: index.php"); // Redirecting To Other Page
                                        } else {
                                            echo '
                                            <div class="alert alert-danger" role="alert">
                                            Invalid user!
                                            </div>';
                                        }
                                        mysqli_close($conn); // Closing Connection
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