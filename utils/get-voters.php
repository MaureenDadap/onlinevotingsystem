<?php

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

function getVoterByID($user_id)
{
    $user_id = filter_var($user_id, FILTER_SANITIZE_NUMBER_INT);

    $conn = Connect();
    $query = "SELECT * FROM users WHERE id = ?";

    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $conn->close();

    return $result;
}
