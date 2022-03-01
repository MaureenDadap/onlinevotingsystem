<?php
require_once 'connection.php';

function getCandidates($position)
{
    //TODO VALIDATE/SANITIZE
    $conn = Connect();
    if ($position != "") {
        $query = "SELECT * FROM candidates WHERE position=?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('s', $position);
    } else {
        $query = "SELECT * FROM candidates";
        $stmt = $conn->prepare($query);
    }

    $stmt->execute();
    $result = $stmt->get_result();

    $conn->close();

    return $result;
}