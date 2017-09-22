<?php

//Import PHPMailer classes into the global namespace
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';
session_start();
if (($_SESSION["usuario"]) == null) {
    header("Location: http://" . $_SERVER["HTTP_HOST"] . "/BoletoPHP/GerenciadorBoleto/index.php");
}
$mail = new PHPMailer(true);
$mail->CharSet = 'UTF-8';

try {
    //Server settings
    $mail->SMTPDebug = 2;                                 // Enable verbose debug output
    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = 'mx1.hostinger.com.br';  // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = 'vilson@microvil.com.br';                 // SMTP username
    $mail->Password = 'microvil0102';                           // SMTP password
    $mail->SMTPSecure = 'tls';                          // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 587;                                    // TCP port to connect to
    //Recipients
    $mail->setFrom('vilson@microvil.com.br', 'Microvil Tecnologia em Automação');
    $mail->addAddress($_SESSION["email"]);     // Add a recipient
    
    //Attachments
    if (($_SESSION["anexo"])) {
        $mail->addAttachment('boleto/attachments/boleto.pdf'); // Add attachments
    }

    //Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = $_SESSION["assunto"];
    $mail->Body = $_SESSION["mensagem"];

    $mail->send();
    if (($_SESSION["anexo"])) {
        unlink("boleto/attachments/boleto.pdf");
    }
    unset($_SESSION["anexo"]);
    unset($_SESSION["email"]);
    unset($_SESSION["assunto"]);
    unset($_SESSION["mensagem"]);
    if($_SESSION["flag_header"]){
        unset($_SESSION["flag_header"]);
        header("Location: http://" . $_SERVER["HTTP_HOST"] . $_SESSION["redirecionamento"]);
        exit();   
    }
} catch (Exception $e) {
    echo 'Não foi possível enviar mensagem. ';
    echo 'Mailer Error: ' . $mail->ErrorInfo;
}