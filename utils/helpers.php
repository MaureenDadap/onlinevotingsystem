<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require_once 'connection.php';
require_once 'config/website_info.php';
require 'vendor/PHPMailer/src/Exception.php';
require 'vendor/PHPMailer/src/PHPMailer.php';
require 'vendor/PHPMailer/src/SMTP.php';

function escapeString(string $input)
{
    if ($input != null)
        echo htmlspecialchars($input, ENT_QUOTES, 'UTF-8');
}

function generateMd5Hash(): string
{
    return md5(rand(0, 1000));
}

function sendActivationEmail(string $email, string $activation_code): void
{
    // create the activation link
    $activation_link = APP_URL . "/verify.php?email=$email&activation_code=$activation_code";

    // set email subject & body
    $email_template = './common/email-template.html';
    $subject = 'Please activate your E-lections account';
    $message = file_get_contents($email_template);
    $message = str_replace('%activation-link%', $activation_link, $message);

    //Create an instance; passing `true` enables exceptions
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = SENDER_EMAIL_ADDRESS;
        $mail->Password   = SENDER_EMAIL_PASSWORD;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port       = 465;

        //Recipients
        $mail->setFrom(SENDER_EMAIL_ADDRESS, WEBSITE_NAME);
        $mail->addAddress($email);
        $mail->addReplyTo(SENDER_EMAIL_ADDRESS, WEBSITE_NAME);

        //Content
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $message;

        $mail->send();
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}

// Token functions --
function checkToken($user_token, $session_token, $returnURL)
{  # Validate the given (CSRF) token
    if ($user_token !== $session_token || !isset($session_token)) {
        echo 'CSRF token is incorrect';
        header('location: ' . $returnURL);
    }
}

function generateSessionToken()
{  # Generate a brand new (CSRF) token
    if (isset($_SESSION['session_token'])) {
        destroySessionToken();
    }
    $_SESSION['session_token'] = md5(uniqid());
}

function destroySessionToken()
{  # Destroy any session with the name 'session_token'
    unset($_SESSION['session_token']);
}

// -- END (Token functions)
