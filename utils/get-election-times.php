<?php
function getStartDate() {
 $query = "SELECT * FROM election_settings ORDER BY id DESC LIMIT 1";
}

function getEndDate() {
    $query = "SELECT * FROM election_settings ORDER BY id DESC LIMIT 1";
}
?>