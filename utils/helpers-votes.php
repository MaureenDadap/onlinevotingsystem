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

    $query = "SELECT COUNT(*) as total FROM votes WHERE datetime BETWEEN ? AND ? GROUP BY ballot_id";
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

function checkIfVoted($user_id, $startDate, $endDate) : int 
{
    //todo validate sanitize
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

function insertVote($ballot_id, $user_id, $candidate_id, $position)
{
    $user_id = filter_var($user_id, FILTER_SANITIZE_NUMBER_INT);
    $candidate_id = filter_var($candidate_id, FILTER_SANITIZE_NUMBER_INT);
    
    $conn = Connect();
    $position = $conn->escape_string($position);
    $query = 'INSERT INTO votes(ballot_id, user_id, candidate_id, position) VALUES(?,?,?,?)';

    $stmt = $conn->prepare($query);
    $stmt->bind_param('siis', $ballot_id, $user_id, $candidate_id, $position);
    $stmt->execute();
    $conn->close();
}

function getVotesByUserID($user_id, $startDate, $endDate) {
    $user_id = filter_var($user_id, FILTER_SANITIZE_NUMBER_INT);

    $conn = Connect();
    $query = "SELECT a.ballot_id, b.last_name, b.first_name, b.position 
            FROM votes a JOIN candidates b 
            ON a.candidate_id = b.id 
            WHERE a.user_id = ?
            AND datetime BETWEEN ? AND ?";

    $stmt = $conn->prepare($query);
    $stmt->bind_param('iss', $user_id, $startDate, $endDate);
    $stmt->execute();
    $result = $stmt->get_result();
    $conn->close();

    return $result;
}
