<?php
//need fixing

session_start();
require_once 'connection.php';
$error = "";

function login()
{
    if (isset($_POST['submit'])) {
        if (empty($_POST['username']) || empty($_POST['password'])) {
            $error = "Username or Password is invalid";
        } else {
            // Define $username and $password
            $username = $_POST['username'];
            $password = $_POST['password'];
            require 'connection.php';
            $conn = Connect();

            // SQL query to fetch information of registerd users and finds user match.
            $query = "SELECT username, password FROM MANAGER WHERE username=? AND password=? LIMIT 1";

            $stmt = $conn->prepare($query);
            $stmt->bind_param("ss", $username, $password);
            $stmt->execute();
            $stmt->bind_result($username, $password);
            $stmt->store_result();

            if ($stmt->fetch()) {
                $_SESSION['login_user1'] = $username; // Initializing Session
                header("location: myrestaurant.php"); // Redirecting To Other Page
            } else {
                $error = "Username or Password is invalid";
            }
            mysqli_close($conn); // Closing Connection
        }
    }
}

function session($user_type)
{
    $conn = $GLOBALS['conn'];
    if (!isset($_SESSION))
        session_start();

    $user_check = $_SESSION[$user_type];

    // SQL Query To Fetch Complete Information Of User
    $query = "SELECT username FROM CUSTOMER WHERE username = '$user_check'";
    $ses_sql = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($ses_sql);
    $login_session = $row['username'];
}


function logout()
{
    if (session_destroy()) // Destroying All Sessions
    {
        header("Location: ../index.php"); // Redirecting To Home Page
    }
}
