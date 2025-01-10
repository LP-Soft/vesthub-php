<?php
require "include_path/phpmailer/src/PHPMailer.php";
require "include_path/phpmailer/src/SMTP.php";
require "include_path/phpmailer/src/Exception.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

function sendEmail($toAddress, $toName, $subject, $body) {
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->SMTPDebug = SMTP::DEBUG_OFF;                      // Disable verbose debug output
        $mail->isSMTP();                                         // Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                    // SMTP server
        $mail->SMTPAuth   = true;                                // Enable SMTP authentication
        $mail->Username   = 'mehmetalibaransevvalsafak@gmail.com';  // SMTP username
        $mail->Password   = 'nvfa onid lrof sjur';                  // SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;      // Enable TLS encryption
        $mail->Port       = 587;                                 // TCP port to connect to
        $mail->CharSet = 'UTF-8';
        
        // Recipients
        $mail->setFrom('mehmetalibaransevvalsafak@gmail.com', 'VestHub');
        $mail->addAddress($toAddress, $toName);

        // Content
        $mail->isHTML(true);                                     // Set email format to HTML
        $mail->Subject = $subject;
        $mail->Body    = $body;
        $mail->AltBody = strip_tags($body);

        $mail->send();
        //echo 'Message has been sent';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
?>
