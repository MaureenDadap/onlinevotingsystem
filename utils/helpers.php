<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require_once 'connection.php';
require_once 'config/website_info.php';
require 'vendor/PHPMailer/src/Exception.php';
require 'vendor/PHPMailer/src/PHPMailer.php';
require 'vendor/PHPMailer/src/SMTP.php';

function generate_activation_code(): string
{
    return md5(rand(0, 1000));
}

function send_activation_email(string $email, string $activation_code): void
{
    // create the activation link
    $activation_link = APP_URL . "/verify.php?email=$email&activation_code=$activation_code";

    // set email subject & body
    $subject = 'Please activate your E-lections account';
    $message = <<<MESSAGE
            Hi,
            Please click the following link to activate your account:
            $activation_link
            MESSAGE;

    //Create an instance; passing `true` enables exceptions
    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->SMTPDebug = SMTP::DEBUG_SERVER;
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
