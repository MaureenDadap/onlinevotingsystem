<?php
require_once 'utils/connection.php';
require_once 'utils/get-election-times.php';

function countVotes($position)
{
    //TODO catch possible errors
    $totalVotes = 0;
    $startDate = getStartDate();
    $endDate = getEndDate();

    $conn = Connect();
    if ($position != "") {
        $query = "SELECT COUNT(*) as total FROM votes WHERE position=? AND datetime BETWEEN ? AND ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('sss', $position, $startDate, $endDate);
    } else {
        $query = "SELECT COUNT(*) as total FROM votes WHERE datetime BETWEEN ? AND ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('ss', $startDate, $endDate);
    }

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
