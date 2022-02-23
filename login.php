<?php
session_start();
require_once('utils/connection.php');
require_once('common/components.php');
include('common/website_info.php');

if (isset($_POST['submit'])) {
    if (!empty($_POST['username']) && !empty($_POST['password'])) {
        // Define $username and $password
        $username = $_POST['username'];
        $password = $_POST['password'];
        $conn = Connect();

        // SQL query to fetch information of registerd users and finds user match.
        $query = "SELECT username, password FROM students WHERE username=? AND password=? LIMIT 1";

        $stmt = $conn->prepare($query);
        $stmt->bind_param("ss", $username, $password);
        $stmt->execute();
        $stmt->bind_result($username, $password);
        $stmt->store_result();

        if ($stmt->fetch()) {
            $_SESSION['user_type'] = 'student'; // Initializing Session
            header("location: index.php"); // Redirecting To Other Page
        } else {
            echo "Username or Password is invalid";
        }
        mysqli_close($conn); // Closing Connection
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<?= head("Login"); ?>

<body>
    <?= navbar("") ?>
    <main>
        <div class="container">
            <header class="text-center mb-5">
                <h1>Welcome to <span><?= $website_name ?></span></h1>
            </header>
            <div class="row justify-content-center">
                <div class="col-md-4">
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
                                <button type="submit" name="submit" class="btn btn-lg btn-primary w-100">Log In</button>
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