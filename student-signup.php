<?php
session_start();
require_once('common/components.php');
include('common/website_info.php');
require_once 'utils/connection.php';

function studentSignUp()
{
    $conn = Connect();

    $username = $conn->escape_string($_POST['username']);
    $email = $conn->escape_string($_POST['email']);
    $password = $conn->escape_string($_POST['password']);
    $program = $conn->escape_string($_POST['program']);
    $password2 = $conn->escape_string($_POST['password2']);

    if ($password != $password2)
        echo '<div class="alert alert-danger" role="alert">
        Pasword does not match.
        </div>';
    else {
        $query = 'INSERT INTO users(username, email, password, program) VALUES(?,?,?,?)';

        $stmt = $conn->prepare($query);
        $stmt->bind_param('ssss', $username, $email, $password, $program);
        $stmt->execute();
        $conn->close();
        header('location: login.php');
    }
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
                                <label for="program" class="form-label">Program</label>
                                <div class="input-group mb-2">
                                    <span class="input-group-text bi-easel2-fill"></span>
                                    <select class="form-select" id="program" name="program" required>
                                        <option value="BSCS">BSCS</option>
                                        <option value="BSIT">BSIT</option>
                                        <option value="BSIS">BSIS</option>
                                        <option value="BSMMA">BSMMA</option>
                                        <option value="BSCS">BSA</option>
                                        <option value="BSIT">BSPSYCH</option>
                                        <option value="BSIS">BSBA</option>
                                        <option value="BSMMA">BSCE</option>
                                    </select>
                                </div>
                                <label for="password" class="form-label">Password</label>
                                <div class="input-group mb-2">
                                    <span class="input-group-text bi-lock-fill"></span>
                                    <input type="password" class="form-control" id="password" name="password" required>
                                </div>
                                <label for="password2" class="form-label">Re-type your password</label>
                                <div class="input-group mb-4">
                                    <span class="input-group-text bi-lock-fill"></span>
                                    <input type="password" class="form-control" id="password2" name="password2" required>
                                </div>
                                <?php
                                if (isset($_POST['submit'])) {
                                    studentSignUp();
                                }
                                ?>
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