<?php
require_once 'utils/connection.php';

function adminSignUp()
{
    $conn = Connect();

    $username = $conn->escape_string($_POST['username']);
    $email = $conn->escape_string($_POST['email']);
    $password = $conn->escape_string($_POST['password']);
    $password2 = $conn->escape_string($_POST['password2']);

    if ($password != $password2)
        echo '<div class="alert alert-danger" role="alert">
        Pasword does not match.
        </div>';
    else {
        $is_admin = 1;
        $query = 'INSERT INTO users(username, email, password, is_admin) VALUES(?,?,?,?)';

        $stmt = $conn->prepare($query);
        $stmt->bind_param('sssi', $username, $email, $password, $is_admin);
        $stmt->execute();
        $conn->close();
        header('location: login.php');
    }
}


function studentSignUp()
{
    $conn = Connect();

    $username = $conn->escape_string($_POST['username']);
    $email = $conn->escape_string($_POST['email']);
    $password = $conn->escape_string($_POST['password']);
    $program = $conn->escape_string($_POST['program']);
    $query = 'INSERT INTO users(username, email, password, program) VALUES(?,?,?,?)';

    $stmt = $conn->prepare($query);
    $stmt->bind_param('ssss', $username, $email, $password, $program);
    $stmt->execute();
    $conn->close();
    header('location: login.php');
}
