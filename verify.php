<?php
session_start();
require_once('common/components.php');
include('config/website_info.php');
require_once 'utils/auth.php';

$response = "";

if (isset($_GET['email']) && !empty($_GET['email']) and isset($_GET['activation_code']) && !empty($_GET['activation_code'])) {
    // TODO VALIDATE AND SANITIZE
    $email = $_GET['email']; // Set email variable
    $hash = $_GET['activation_code']; // Set hash variable

    $user = findUnverifiedUser($hash, $email);
    // if user exists and activate the user successfully
    if ($user && activateUser($user['id'])) {
        echo 'activated';
        $response = "verified";
    } else {
        $response = "invalid";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<?= head("Verify Account") ?>

<body>
    <?= navbar("") ?>
    <?php if ($response === "verified") : ?>
        <main>
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-7">
                        <h1>You are already verified. You can now log in.</h1>
                        <a href="login.php" class="btn btn-default">Log In</a>
                    </div>
                    <div class="col-md-5">
                        <img src="images/sammy-done.png" alt="success" class="w-100">
                    </div>
                </div>
            </div>
        </main>
    <?php elseif ($response === "invalid") : ?>
        <main>
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-7">
                        <h1>Invalid Verification.</h1>
                        <h5>Re-check your verification link or try registering again.</h5>
                    </div>
                    <div class="col-md-5">
                        <img src="images/sammy-page-under-construction.png" alt="error" class="w-100">
                    </div>
                </div>
            </div>
        </main>
    <?php endif ?>
    <?php include 'common/footer.php' ?>
    <script src="js/bootstrap.bundle.js"></script>
</body>

</html>