<?php
require_once 'connection.php';

function logIn()
{
    // Define $username and $password
    $username = $_POST['username'];
    $password = $_POST['password'];
    $user_type = 0;
    $conn = Connect();

    // SQL query to fetch information of registerd users and finds user match.
    $query = 'SELECT username, password, is_admin FROM users WHERE username=? AND password=? LIMIT 1';

    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $stmt->bind_result($username, $password, $user_type);
    $stmt->store_result();

    if ($stmt->fetch()) {
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
