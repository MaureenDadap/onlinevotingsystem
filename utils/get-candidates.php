<?php
require_once 'connection.php';
require_once 'get-election-times.php';

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

function getCandidateByID(int $candidateId)
{
    //TODO VALIDATE/SANITIZE
    $conn = Connect();

    $query = "SELECT * FROM candidates WHERE id=?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $candidateId);

    $stmt->execute();
    $result = $stmt->get_result();

    $conn->close();

    return $result;
}

function getCandidatesVotes($position, int $limit = 0)
{
    //TODO VALIDATE/SANITIZE
    $conn = Connect();
    $startDate = getStartDate();
    $endDate = getEndDate();

    // if ($id == null) {
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
    // } else { //gets by id
    //     $query = "SELECT a.*, count(*) as VOTES FROM candidates a JOIN votes b ON a.id = b.candidate_id WHERE a.id=? AND b.datetime BETWEEN ? AND ? ORDER BY VOTES DESC LIMIT 1";
    //     $stmt = $conn->prepare($query);
    //     $stmt->bind_param('iss', $id, $startDate, $endDate);
    // }

    $stmt->execute();
    $result = $stmt->get_result();

    $conn->close();

    return $result;
}
