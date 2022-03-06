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
            <p>Successfully verified account. You can now login.</p>
        </main>
    <?php endif ?>
    <?php include 'common/footer.php' ?>
</body>

</html>