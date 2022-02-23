<?php
session_start();
require_once('common/components.php');
include('common/website_info.php');
?>

<!DOCTYPE html>
<html lang="en">
<?= head("Voting Ballot"); ?>

<body>
    <?= navbar("voting"); ?>
    <main></main>
    <?= footer() ?>
    <script src="js/bootstrap.bundle.js"></script>
    <script>
        window.onbeforeunload = function() {
            return 'Are you sure? Your work will be lost. ';
        };

        // window.addEventListener('beforeunload', function(e) {
        //     // Cancel the event
        //     e.preventDefault();
        //     // Chrome requires returnValue to be set
        //     e.returnValue = '';
        // });
    </script>
</body>

</html>