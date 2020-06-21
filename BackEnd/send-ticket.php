<?php
include "vendor/PHPMailer/src/PHPMailer.php";
include "vendor/PHPMailer/src/Exception.php";
include "vendor/PHPMailer/src/OAuth.php";
include "vendor/PHPMailer/src/POP3.php";
include "vendor/PHPMailer/src/SMTP.php";

include "vendor/qrcode/qrlib.php";
 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if (isset($_POST["id-table-attendee"])) {
    
    require('database-config.php');
    $id = $_POST['id-table-attendee'];

    $sqlGetInfo = "SELECT at.email, at.ticket_code, e.id, e.title, e.start_date, e.place FROM attendee at, event e WHERE at.event_id = e.id AND at.id = ".$id;
    $sqlUpdate = "UPDATE attendee SET status = 0 WHERE id = ".$id;

    $resultInfo = mysqli_query($conn, $sqlGetInfo);
    if ($resultInfo) {
        $rowInfo = mysqli_fetch_assoc($resultInfo);

        $ticket_code = $rowInfo["ticket_code"];
        $attendee_email = $rowInfo["email"];

        $event_id = $rowInfo["id"];
        $title = $rowInfo["title"];
        $time = date("H:i - d/m/Y", strtotime($rowInfo["start_date"]));
        $place = $rowInfo["place"];

        // setup qr code
        $PNG_TEMP_DIR = dirname(__FILE__).DIRECTORY_SEPARATOR.'temp'.DIRECTORY_SEPARATOR;
        $PNG_WEB_DIR = 'temp/';
        if (!file_exists($PNG_TEMP_DIR))
            mkdir($PNG_TEMP_DIR);
        $filename = $PNG_TEMP_DIR.'test.png';
        $errorCorrectionLevel = 'H';
        $matrixPointSize = 10;
        
        if (isset($ticket_code)) {
            //it's very important!
            if (trim($ticket_code) == '')
                die('data cannot be empty! <a href="?">back</a>');
                
            // user data
            $filename = $PNG_TEMP_DIR.'test'.$ticket_code.'.png';
            QRcode::png($ticket_code, $filename, $errorCorrectionLevel, $matrixPointSize, 2);    
            
        } else {    
        
            //default data
           
            QRcode::png($ticket_code, $filename, $errorCorrectionLevel, $matrixPointSize, 2);    
            
        }    


        $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
        try {
            //Server settings
            $mail->SMTPDebug = 0;                                 // Enable verbose debug output
            $mail->isSMTP();                                      // Set mailer to use SMTP
            $mail->Host = 'smtp.office365.com';  // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                               // Enable SMTP authentication
            $mail->Username = 'sukien@vanlanguni.edu.vn';                 // SMTP username
            $mail->Password = 'Vanlang2020';                           // SMTP password
            $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
            $mail->Port = 587;                                    // TCP port to connect to
         
            //Recipients
            $mail->CharSet = 'UTF-8';
            $mail->setFrom('sukien@vanlanguni.edu.vn', 'EventBox - Văn Lang');
            // $mail->addAddress('kiyof44715@fxmail.ws', 'Joe User');     // Add a recipient
            $mail->addAddress($attendee_email);               // Name is optional
            // $mail->addReplyTo('info@example.com', 'Information');
            // $mail->addCC('cc@example.com');
            // $mail->addBCC('bcc@example.com');
         
            //Attachments
            // $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
            // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
         
            //Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = 'Vé mời tham dự sự kiện - EventBox Văn Lang';
            $content ="<b>Thân gửi bạn!</b><br>
            Vé mời của bạn đã được đính kèm trong email này. Xin vui lòng mang vé tới sự kiện để được điểm danh.<br>
            Phòng trường hợp nơi diễn ra sự kiện không có kết nối internet, bạn có thể tải vé về trước để việc điểm danh được thực hiện nhanh chóng.<br>
            Cảm ơn bạn đã đăng ký tham gia sự kiện!
            <hr>
            <table>
                <tr>
                    <td><b>Sự kiện:</b></td>
                    <td>".$title."</td>
                </tr>
                    <tr>
                    <td><b>Thời gian:</b></td>
                    <td>".$time."</td>
                </tr>
                <tr>
                    <td><b>Địa điểm:</b></td>
                    <td>".$place."</td>
                </tr>
            </table>
            <a href='https://sukien.vanlanguni.edu.vn/event-detail.php?id=$event_id' target='_blank'>Chi tiết sự kiện</a>
            <hr>
            <p>Vui lòng không trả lời email này</p>";

            $mail->addAttachment($PNG_WEB_DIR.basename($filename), 'ticket.jpg');      
            $mail->Body    = $content;
            $mail->AltBody = '';
         
            $mail->send();
            // echo 'Message has been sent';

            $resultUpdate = mysqli_query($conn, $sqlUpdate);
            $data['result'] = true;
        } catch (Exception $e) {
            $data['result'] = false;
            $data["error"] =  $mail->ErrorInfo;
            $data['message'] = 'Có lỗi xảy ra. Vui lòng thử lại!';
        }
    } else {
        $data['result'] = false;
        $data['message'] = 'Có lỗi xảy ra. Vui lòng thử lại!';
    }
    

}


mysqli_close($conn);
echo json_encode($data);
?>