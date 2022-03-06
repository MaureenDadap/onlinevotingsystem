<?php
require_once 'connection.php';
require_once 'helpers.php';

/** Checks if user name is already in use by someone in the db
 */
function checkUserNameExists($username): bool
{
    $conn = Connect();
    $query = 'SELECT username FROM users WHERE username=?';
    $stmt = $conn->prepare($query);
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result && $result->num_rows > 0) {
        return true;
        echo 'username exists';
    }
    return false;
}

function isUserActive($user)
{
    return $user['email_authenticated'] === 1;
}

function deleteUserById(int $id, int $active = 0)
{
    $conn = Connect();
    $query = 'DELETE FROM users WHERE id =? and email_authenticated=?';

    $stmt = $conn->prepare($$query);
    $stmt->bind_param('ii', $id, $active);
    return $stmt->execute();
}

function findUnverifiedUser(string $activation_code, string $email)
{
    $conn = Connect();
    $query = 'SELECT id, activation_code, activation_expiry < now() as expired FROM users WHERE email_authenticated = 0 AND email=?';
    $stmt = $conn->prepare($query);

    $stmt->bind_param('s', $email);
    $stmt->execute();

    $user = null;

    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $user = $row;
    }

    if ($user) {
        // already expired, delete the in active user with expired activation code
        if ((int)$user['expired'] === 1) {
            deleteUserById($user['id']);
            return null;
        }
        // verify the activation link
        if ($activation_code === $user['activation_code']) {
            return $user;
        }
    }

    $conn->close();
    return null;
}

function activateUser(int $user_id): bool
{
    $conn = Connect();
    $query = 'UPDATE users SET email_authenticated = 1 WHERE id=?';

    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $user_id);

    return $stmt->execute();
}

function adminSignUp(string $response)
{
    //TODO SANITIZE AND VALIDATE
    $conn = Connect();

    $username = $conn->escape_string($_POST['username']);
    $email = $conn->escape_string($_POST['email']);
    $password = $conn->escape_string($_POST['password']);
    $password2 = $conn->escape_string($_POST['password2']);
    $hash = generateMd5Hash();
    $is_admin = 1;
    $expiry = 1 * 24 * 60 * 60;
    $authExpire = date('Y-m-d H:i:s',  time() + $expiry);

    if ($password != $password2)
        $response = "password mismatch";
    else if (checkUserNameExists($username) === true)
        $response = "username exists";
    else {
        $query = 'INSERT INTO users(username, email, password, is_admin, activation_code, activation_expiry) VALUES(?,?,?,?,?,?)';
        $stmt = $conn->prepare($query);
        $stmt->bind_param('sssiss', $username, $email, $password, $is_admin, $hash, $authExpire);
        $stmt->execute();
        $conn->close();

        sendActivationEmail($email, $hash);
        $response = "success";
    }

    return $response;
}

function studentSignUp(string $response)
{
    $conn = Connect();

    //TODO VALIDATE AND SANITIZE
    $username = $conn->escape_string($_POST['username']);
    $email = $conn->escape_string($_POST['email']);
    $password = $conn->escape_string($_POST['password']);
    $program = $conn->escape_string($_POST['program']);
    $password2 = $conn->escape_string($_POST['password2']);
    $hash = generateMd5Hash();
    $expiry = 1 * 24 * 60 * 60;
    $authExpire = date('Y-m-d H:i:s',  time() + $expiry);

    if ($password != $password2)
        $response = "password mismatch";
    else if (checkUserNameExists($username) === true)
        $response = "username exists";
    else {
        $query = 'INSERT INTO users(username, email, password, program, activation_code, activation_expiry) VALUES(?,?,?,?,?,?)';
        $stmt = $conn->prepare($query);
        $stmt->bind_param('ssssss', $username, $email, $password, $program, $hash, $authExpire);
        $stmt->execute();
        $conn->close();

        sendActivationEmail($email, $hash);
        $response = "success";
    }
    return $response;
}

function logIn(string $response)
{
    //TODO VALIDATE AND SANITIZE
    // Define $username and $password
    $username = $_POST['username'];
    $password = $_POST['password'];
    $user_type = 0;
    $id = -1;
    $emailAuth = 0;
    $redirect = "";
    $conn = Connect();

    // SQL query to fetch information of registerd users and finds user match.
    $query = 'SELECT id, username, password, is_admin, email_authenticated FROM users WHERE username=? AND password=? LIMIT 1';

    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $stmt->bind_result($id, $username, $password, $user_type, $emailAuth);
    $stmt->store_result();

    if ($stmt->fetch()) {
        if ($emailAuth === 1) {
            $_SESSION['id'] = $id;
            $_SESSION['username'] = $username;

            if ($user_type == 0) {
                $_SESSION['user_type'] = 'student';
                $redirect = 'index.php';
            } else {
                $_SESSION['user_type'] = 'admin';
                $redirect = 'admin-dashboard.php';
            }
            header("location: " . $redirect);
        } else
            $response = "not authenticated";
    } else {
        $response = "wrong credentials";
    }

    $conn->close();
    return $response;
}
