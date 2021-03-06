<?php
session_start();
require_once('common/components.php');
include('config/website_info.php');
require_once 'utils/auth.php';

$response = "";

if (isset($_GET['email']) && !empty($_GET['email']) and isset($_GET['activation_code']) && !empty($_GET['activation_code'])) {    
    $email = filter_var($_GET['email'], FILTER_SANITIZE_EMAIL); // Set email variable
    $hash = filter_var($_GET['activation_code'], FILTER_SANITIZE_FULL_SPECIAL_CHARS); // Set hash variable

    $user = findUnverifiedUser($hash, $email);
    // if user exists and activate the user successfully
    if ($user && activateUser($user['id'])) {
        $response = "verified";
    } else {
        $response = "invalid";
    }
} else {
    header('location: index.php');
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
                        <a href="login.php" class="btn btn-default">Proceed to Log In</a>
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
                        <h5>You have either already been verified or you entered an invalid verification code.</h5>
                        <h6>Re-check your verification link or try registering again.</h6>
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