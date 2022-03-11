<?php
require_once 'connection.php';

function getStartDate()
{
    //TODO catch possible errors
    $startTime = '';
    $conn = Connect();
    $query = "SELECT datetime_start FROM election_settings ORDER BY id DESC LIMIT 1";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    //$stmt->bind_result($startTime);

    $result = $stmt->get_result();
    if ($result && $result->num_rows > 0) {
        while ($data = $result->fetch_assoc()) {
            $startTime = $data['datetime_start'];
        }
    }

    $conn->close();

    return $startTime;
}

function getEndDate()
{
    //TODO catch possible errors
    $endTime = '';
    $conn = Connect();
    $query = "SELECT datetime_end FROM election_settings ORDER BY id DESC LIMIT 1";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result && $result->num_rows > 0) {
        while ($data = $result->fetch_assoc()) {
            $endTime = $data['datetime_end'];
        }
    }

    $conn->close();

    return $endTime;
}
