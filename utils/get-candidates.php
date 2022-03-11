<?php
require_once 'connection.php';
require_once 'get-election-times.php';

function getCandidates($position)
{
    $conn = Connect();
    $position = $conn->escape_string($position);
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

function getCandidateByID(int $candidateId)
{
    $conn = Connect();

    $candidateId = (int) $conn->escape_string($candidateId);
    $query = "SELECT * FROM candidates WHERE id=?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $candidateId);

    $stmt->execute();
    $result = $stmt->get_result();

    $conn->close();

    return $result;
}

function getCandidatesVotes(string $position, int $limit = 0)
{
    $conn = Connect();
    $position = $conn->escape_string($position);
    $limit = (int) $conn->escape_string($limit);
    $startDate = getStartDate();
    $endDate = getEndDate();
    $query = "";

    if ($limit === 0) {  //gets everyone ranked
        $query = "SELECT a.*, count(*) as VOTES 
                    FROM candidates a JOIN votes b ON a.id = b.candidate_id 
                    WHERE a.position=? 
                    AND b.datetime BETWEEN ? AND ? 
                    GROUP BY a.id 
                    ORDER BY VOTES DESC";
    } else if ($limit === 1) { //gets top 1 from rank
        $query = "SELECT a.*, count(*) as VOTES
                    FROM candidates a JOIN votes b ON a.id = b.candidate_id 
                    WHERE a.position=? 
                    AND b.datetime BETWEEN ? AND ? 
                    GROUP BY a.id 
                    ORDER BY VOTES DESC LIMIT 1";
    }
    $stmt = $conn->prepare($query);
    $stmt->bind_param('sss', $position, $startDate, $endDate);
    $stmt->execute();
    $result = $stmt->get_result();

    $conn->close();

    return $result;
}

function countCandidates()
{
    $totalCandidates = 0;
    $result = getCandidates("");
    if ($result && $result->num_rows > 0) {
        while ($result->fetch_assoc()) {
            $totalCandidates++;
        }
    }
    return $totalCandidates;
}

function countVoters()
{
    $totalVoters = 0;
    $is_admin = 0;
    $conn = Connect();
    $query = "SELECT COUNT(*) as total FROM users WHERE is_admin=?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $is_admin);

    $stmt->execute();

    $result = $stmt->get_result();
    if ($result && $result->num_rows > 0) {
        while ($data = $result->fetch_assoc()) {
            $totalVoters = $data['total'];
        }
    }

    $conn->close();
    return $totalVoters;
}
