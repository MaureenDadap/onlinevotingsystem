<?php
session_start();
require_once('common/components.php');
include('common/website_info.php');
?>

<!DOCTYPE html>
<html lang="en">
<?= head("Candidates List"); ?>

<body>
    <?= navbar("candidates"); ?>
    <header class="results py-3">
        <div class="container">
            <div class="row justify-content-center align-items-center">
                <div class="col-md-3">
                    <img src="images/sammy-25.png" alt="img" class="w-100">
                </div>
                <div class="col-md-3">
                    <h1>Candidates List</h1>
                </div>
            </div>
        </div>
    </header>
    <main>
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-6 ">
                    <div class="card p-4">
                        <h4>One Partylist</h4>
                        <span><strong>President: </strong>Jane Doe</span>
                        <span><strong>Vice President: </strong>Jane Doe</span>
                        <span><strong>Secretary: </strong>Jane Doe</span>
                        <span><strong>Treasurer: </strong>Jane Doe</span>
                        <strong>Representatives: </strong>
                        <ul>
                            <li>Jane Doe</li>
                            <li>Jane Doe</li>
                            <li>Jane Doe</li>
                            <li>Jane Doe</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <?= footer() ?>
    <script src="js/bootstrap.bundle.js"></script>
</body>

</html>