<?php
require_once 'connection.php';

function getStartDate()
{
    //TODO catch possible errors
    $startTime = new DateTime();
    $conn = Connect();
    $query = "SELECT datetime_start FROM election_settings ORDER BY id DESC LIMIT 1";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $stmt->bind_result($startTime);

    $conn->close();

    return $startTime;
}

function getEndDate()
{
    //TODO catch possible errors
    $endTime = new DateTime();
    $conn = Connect();
    $query = "SELECT datetime_end FROM election_settings ORDER BY id DESC LIMIT 1";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $stmt->bind_result($endTime);

    $conn->close();

    return $endTime;
}
