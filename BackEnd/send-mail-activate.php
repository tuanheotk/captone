<?php
include "vendor/PHPMailer/src/PHPMailer.php";
include "vendor/PHPMailer/src/Exception.php";
include "vendor/PHPMailer/src/OAuth.php";
include "vendor/PHPMailer/src/POP3.php";
include "vendor/PHPMailer/src/SMTP.php";
 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// $user_fullname = 'Họ Và Tên';
// $user_email = 'koxod33706@promail9.net';
// $user_pass = 'pass12345';
// $verify_code = md5(uniqid('', true));

$mail = new PHPMailer(true);                              // Passing `true` enables exceptions
try {
    //Server settings
    $mail->SMTPDebug = 0;                                 // Enable verbose debug output
    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = 'eventbox.vanlang@gmail.com';                 // SMTP username
    $mail->Password = 'Pass1230.';                           // SMTP password
    $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 587;                                    // TCP port to connect to
 
    //Recipients
    $mail->CharSet = 'UTF-8';
    $mail->setFrom('eventbox.vanlang@gmail.com', 'EventBox - Văn Lang');
    // $mail->addAddress('kiyof44715@fxmail.ws', 'Joe User');     // Add a recipient
    $mail->addAddress($user_email);               // Name is optional
    // $mail->addReplyTo('info@example.com', 'Information');
    // $mail->addCC('cc@example.com');
    // $mail->addBCC('bcc@example.com');
 
    //Attachments
    // $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
    // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
 
    //Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = 'Kích hoạt tài khoản - EventBox Văn Lang';
    $mail->Body    = 'Xin chào '.$user_fullname.'! <br>
    Chào mừng bạn đến với <b>EventBox Văn Lang</b><br><br>
    <em>Thông tin đăng nhập của bạn:</em><br>
    Email: '.$user_email.'<br>
    Mật khẩu: '.$user_pass.'<br><br>
    Chỉ còn bước cuối cùng là có thể tham gia cùng chúng tôi. Vui lòng bấm vào <a href="http://localhost/event/activate.php?code='.$verify_code.'">đây</a> để kích hoạt tài khoản của bạn.';
    $mail->AltBody = '';
 
    $mail->send();
    // echo 'Message has been sent';
} catch (Exception $e) {
    echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
}

?>