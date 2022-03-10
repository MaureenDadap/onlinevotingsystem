<?php
require_once 'utils/connection.php';
require_once 'utils/get-election-times.php';

function countVotes()
{
    //TODO catch possible errors
    $totalVotes = 0;
    $startDate = getStartDate();
    $endDate = getEndDate();

    $conn = Connect();

    $query = "SELECT COUNT(*) as total FROM votes WHERE datetime BETWEEN ? AND ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('ss', $startDate, $endDate);

    $stmt->execute();

    $result = $stmt->get_result();
    if ($result && $result->num_rows > 0) {
        while ($data = $result->fetch_assoc()) {
            $totalVotes = $data['total'];
        }
    }

    $conn->close();

    return $totalVotes;
}

function checkIfVoted($user_id, $startDate, $endDate)
{
    $conn = Connect();
    $userVotes = 0;
    $query = "SELECT COUNT(*) as total FROM votes WHERE user_id =? AND datetime BETWEEN ? AND ?";

    $stmt = $conn->prepare($query);
    $stmt->bind_param('iss', $user_id, $startDate, $endDate);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result && $result->num_rows > 0) {
        while ($data = $result->fetch_assoc()) {
            $userVotes = $data['total'];
        }
    }

    $conn->close();

    return $userVotes;
}

function insertVote($user_id, $candidate_id, $position)
{
    $conn = Connect();
    $query = 'INSERT INTO votes(user_id, candidate_id, position) VALUES(?,?,?)';

    $stmt = $conn->prepare($query);
    $stmt->bind_param('iis', $user_id, $candidate_id, $position);
    $stmt->execute();
    $conn->close();
}
