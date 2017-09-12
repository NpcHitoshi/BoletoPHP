<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';
session_start();
$mail = new PHPMailer(true);
try {
    //Server settings
    $mail->SMTPDebug = 2;                                 // Enable verbose debug output
    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = 'smtp.live.com';  // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = 'contato@microvil.com.br';          // SMTP username
    $mail->Password = 'microvil0102';                     // SMTP password
    $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 587;                                    // TCP port to connect to
    //Recipients
    $mail->setFrom('contato@microvil.com.br', 'Microvil Tecnologia em Automação');
    $mail->addAddress($_SESSION["email"]);    // Add a recipient
    //Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = $_SESSION["assunto"];
    $mail->Body = $_SESSION["mensagem"];

    $mail->send();
    echo 'Mensagem enviada com sucesso';
    unset($_SESSION["assunto"]);
    unset($_SESSION["mensagem"]);
    unset($_SESSION["email"]);
    header("Location: http://" . $_SERVER["HTTP_HOST"] . $_SESSION["redirecionamento"]);
    exit();
} catch (Exception $e) {
    echo 'Message could not be sent.';
    echo 'Mailer Error: ' . $mail->ErrorInfo;
}