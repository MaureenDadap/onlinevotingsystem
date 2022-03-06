<?php
require_once 'connection.php';

function adminSignUp()
{
    //TODO SANITIZE AND VALIDATE
    $conn = Connect();

    $username = $conn->escape_string($_POST['username']);
    $email = $conn->escape_string($_POST['email']);
    $password = $conn->escape_string($_POST['password']);
    $password2 = $conn->escape_string($_POST['password2']);
    $is_admin = 1;

    if ($password != $password2)
        echo '<div class="alert alert-danger" role="alert">
        Pasword does not match.
        </div>';
    else {
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
    $password2 = $conn->escape_string($_POST['password2']);

    if ($password != $password2)
        echo '<div class="alert alert-danger" role="alert">
        Pasword does not match.
        </div>';
    else {
        $query = 'INSERT INTO users(username, email, password, program) VALUES(?,?,?,?)';

        $stmt = $conn->prepare($query);
        $stmt->bind_param('ssss', $username, $email, $password, $program);
        $stmt->execute();
        $conn->close();
        header('location: login.php');
    }
}

function is_user_active($user)
{
    return $user['email_authenticated'] === 1;
}

function logIn()
{
    //TODO VALIDATE AND SANITIZE
    // Define $username and $password
    $username = $_POST['username'];
    $password = $_POST['password'];
    $user_type = 0;
    $id = -1;
    $conn = Connect();

    // SQL query to fetch information of registerd users and finds user match.
    $query = 'SELECT id, username, password, is_admin FROM users WHERE username=? AND password=? LIMIT 1';

    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $stmt->bind_result($id, $username, $password, $user_type);
    $stmt->store_result();

    if ($stmt->fetch()) {
        $_SESSION['id'] = $id;

        if ($user_type == 0)
            $_SESSION['user_type'] = 'student';
        else
            $_SESSION['user_type'] = 'admin';

        header("location: index.php");
    } else {
        echo '
    <div class="alert alert-danger" role="alert">
    Invalid user!
    </div>';
    }

    $conn->close();
}
