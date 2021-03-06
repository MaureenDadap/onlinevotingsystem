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
    }
    return false;
}

/** Checks if email is already in use by someone in the db
 */
function checkEmailExists($email): bool
{
    $conn = Connect();
    $query = 'SELECT email FROM users WHERE email=?';
    $stmt = $conn->prepare($query);
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result && $result->num_rows > 0) {
        return true;
    }
    return false;
}

function deleteUserById(int $id, int $active = 0)
{
    $conn = Connect();
    $query = 'DELETE FROM users WHERE id =? and email_authenticated=?';

    $stmt = $conn->prepare($query);
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
    $conn = Connect();

    $username = $conn->escape_string(trim($_POST['username']));
    $firstName = $conn->escape_string($_POST['first-name']);
    $lastName = $conn->escape_string($_POST['last-name']);
    $email = $conn->escape_string($_POST['email']);
    $password = $conn->escape_string($_POST['password']);
    $password2 = $conn->escape_string($_POST['password2']);
    $hashedPass = password_hash($password, PASSWORD_DEFAULT);
    $hash = generateMd5Hash(); //for activation code
    $is_admin = 1;
    $expiry = 1 * 24 * 60 * 60;
    $authExpire = date('Y-m-d H:i:s',  time() + $expiry);

    if ($password != $password2)
        $response = "password mismatch";
    else if (!preg_match("#[0-9]+#", $password) || !preg_match("#[a-zA-Z]+#", $password))
        $response = "invalid password";
    else if (checkUserNameExists($username) === true)
        $response = "username exists";
    else if (checkEmailExists($email) === true)
        $response = "email exists";
    else if (!filter_var($email, FILTER_VALIDATE_EMAIL))
        $response = "invalid email";
    else if (preg_match("/@students./", $email))
        $response = "student email";
    else {
        $query = 'INSERT INTO users(username, email, password, first_name, last_name, is_admin, activation_code, activation_expiry) VALUES(?,?,?,?,?,?,?,?)';
        $stmt = $conn->prepare($query);
        $stmt->bind_param('sssssiss', $username, $email, $hashedPass, $firstName, $lastName, $is_admin, $hash, $authExpire);
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

    $username = $conn->escape_string(trim($_POST['username']));
    $firstName = $conn->escape_string($_POST['first-name']);
    $lastName = $conn->escape_string($_POST['last-name']);
    $idYear = $conn->escape_string($_POST['id-year']);
    $idNum = $conn->escape_string($_POST['id-num']);
    $email = $conn->escape_string($_POST['email']);
    $password = $conn->escape_string($_POST['password']);
    $program = $conn->escape_string($_POST['program']);
    $password2 = $conn->escape_string($_POST['password2']);
    $hashedPass = password_hash($password, PASSWORD_DEFAULT);
    $hash = generateMd5Hash(); //for activation code
    $expiry = 1 * 24 * 60 * 60;
    $authExpire = date('Y-m-d H:i:s',  time() + $expiry);

    if ($password != $password2)
        $response = "password mismatch";
    else if (!preg_match("#[0-9]+#", $password) || !preg_match("#[a-zA-Z]+#", $password))
        $response = "invalid password";
    else if (checkUserNameExists($username) === true)
        $response = "username exists";
    else if (checkEmailExists($email) === true)
        $response = "email exists";
    else if (!filter_var($email, FILTER_VALIDATE_EMAIL))
        $response = "invalid email";
    else if (!preg_match("#[0-9]+#", $idYear) || !preg_match("#[0-9]+#", $idNum))
        $response = "invalid student-id";
    else {
        $studentID = $idYear . '-' . $idNum;
        $query = 'INSERT INTO users(username, email, password, first_name, last_name, student_id, program, activation_code, activation_expiry) VALUES(?,?,?,?,?,?,?,?,?)';
        $stmt = $conn->prepare($query);
        $stmt->bind_param('sssssssss', $username, $email, $hashedPass, $firstName, $lastName, $studentID, $program, $hash, $authExpire);
        $stmt->execute();
        $conn->close();

        sendActivationEmail($email, $hash);
        $response = "success";
    }
    return $response;
}

function logIn(string $response)
{
    $conn = Connect();
    $username = $conn->escape_string($_POST['username']);
    $password = $conn->escape_string($_POST['password']);
    $user_type = 0;
    $id = -1;
    $emailAuth = 0;
    $redirect = "";

    // SQL query to fetch information of registerd users and finds user match.
    $query = 'SELECT id, username, password, is_admin, email_authenticated FROM users WHERE username=? LIMIT 1';

    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($id, $username, $hashedPass, $user_type, $emailAuth);
    $stmt->store_result();


    if ($stmt->fetch()) { //user was found
        if (password_verify($password, $hashedPass)) { // if password input matched pw saved in db
            if ($emailAuth === 1) { //check if authenticated

                // prevent session fixation attack
                session_regenerate_id(true);

                // Anti-CSRF
                if (array_key_exists("session_token", $_SESSION)) {
                    $session_token = $_SESSION['session_token'];
                } else {
                    $session_token = "";
                }

                checkToken($_REQUEST['user_token'], $session_token, 'login.php');

                $_SESSION['id'] = $id;
                $_SESSION['username'] = $username;
                $_SESSION['last_activity'] = time();

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
    } else {
        $response = "wrong credentials";
    }

    $conn->close();
    return $response;
}

/** Checks how long user is inactive and logs out automatically if inactive for set amount of time
 */
function checkInactivity()
{
    if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > 60 * 10)) { //inactive for 10 mins
        header('location: utils/logout.php');
    } else {
        session_regenerate_id(true);
        $_SESSION['last_activity'] = time();
    }
}
