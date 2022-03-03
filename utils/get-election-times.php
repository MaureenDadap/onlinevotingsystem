<?php
require_once 'connection.php';

function getStartDate()
{
    //TODO catch possible errors
    $endTime = '';
    $conn = Connect();
    $query = "SELECT datetime_start FROM election_settings ORDER BY id DESC LIMIT 1";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $stmt->bind_result($endTime);
    $stmt->store_result();

    $conn->close();

    return $endTime;
}

function getEndDate()
{
    //TODO catch possible errors
    $startTime = '';
    $conn = Connect();
    $query = "SELECT datetime_end FROM election_settings ORDER BY id DESC LIMIT 1";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $stmt->bind_result($startTime);
    $stmt->store_result();

    $conn->close();

    return $startTime;
}
