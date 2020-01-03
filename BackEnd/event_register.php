<?php 
// header("Content-Type:application/json");
include  "vendor/PHPMailer/src/PHPMailer.php";
include  "vendor/PHPMailer/src/Exception.php";
include  "vendor/PHPMailer/src/OAuth.php";
include  "vendor/PHPMailer/src/POP3.php";
include  "vendor/PHPMailer/src/SMTP.php";
 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'database-config.php';
 session_start();
if($_SERVER["REQUEST_METHOD"] == "POST"){
       
       
    
 if(isset($_POST["id"])){
        $ticket_code = md5(uniqid(rand(), true));
        // echo $ticket_code;
        $id=$_POST["id"];
        $email=$_POST["email"];  
        $title=$_POST["title"];
        $place=$_POST["place"];
        $photo=$_POST["photo"];
        $mailcheck= $_POST["mail_check"];
        $sum_ticket=["sum_ticket"];
        $check_reg_sql = "select id from attendee where email= '".$email."' and event_id=".$id;
        $resultCheck = mysqli_query($conn,$check_reg_sql);
        $count_reg=mysqli_num_rows($resultCheck);

        $sum_att_sql = "select count(id) as sum_att from attendee where event_id=".$id;
        $resultSumAtt = mysqli_query($conn,$sum_att_sql);
        $row_sum_att=mysqli_fetch_assoc($resultSumAtt);
        $sum_att=$row_sum_att["sum_att"];
        if($count_reg!=0){
               header("Location: event_done.php");
        }else if($sum_att==$sum_ticket){ //Sold Out
            header("Location:soldout.php");
        }else{


        
        

             $time= date ("H:i d/m/Y", strtotime($_POST["start_date"]));
        $check_ticket_sql = "select email from attendee a, event e where a.event_id = e.id and a.event_id = $id and e.status=4 and ticket_code = '".$ticket_code."'";
        $result = mysqli_query($conn,$check_ticket_sql);
        $count=mysqli_num_rows($result);
        
        while($count!=0){
        $check_ticket_sql = "select email from attendee a, event e where a.event_id = e.id and a.event_id = $id and e.status=4 and ticket_code = '".$ticket_code."'";
        $result = mysqli_query($conn,$check_ticket_sql);
        $count=mysqli_num_rows($result);
        // echo $count;
         }
         // echo $ticket_code;

         if($mailcheck==0)
        {   
             $add_ticket_sql = "INSERT into attendee (email, event_id, status, ticket_code) VALUES ('".$email."', ".$id.", 2,'". $ticket_code."') ";
             $result_add = mysqli_query($conn,$add_ticket_sql);
            header("Location: wait_accept.php");
           
        }else{
             $add_ticket_sql = "INSERT into attendee (email, event_id, status, ticket_code) VALUES ('".$email."', ".$id.", 0,'". $ticket_code."') ";
         $result_add = mysqli_query($conn,$add_ticket_sql);

    
    //set it to writable location, a place for temp generated PNG files
    $PNG_TEMP_DIR = dirname(_FILE_).DIRECTORY_SEPARATOR.'temp'.DIRECTORY_SEPARATOR;
    
    //html PNG location prefix
    $PNG_WEB_DIR = 'temp/';

    include "vendor/qrcode/qrlib.php";    
    
    //ofcourse we need rights to create temp dir
    if (!file_exists($PNG_TEMP_DIR))
        mkdir($PNG_TEMP_DIR);
    
    
    $filename = $PNG_TEMP_DIR.'test.png';
    
    //processing form input
    //remember to sanitize user input in real-life solution !!!
    $errorCorrectionLevel = 'H';
    // 

    $matrixPointSize = 10;
    // if (isset($_REQUEST['size']))
    //     $matrixPointSize = min(max((int)$_REQUEST['size'], 1), 10);


    if (isset($_REQUEST['data'])) { 
    
        //it's very important!
        if (trim($_REQUEST['data']) == '')
            die('data cannot be empty! <a href="?">back</a>');
            
        // user data
        $filename = $PNG_TEMP_DIR.'test'.md5($_REQUEST['data'].'|'.$errorCorrectionLevel.'|'.$matrixPointSize).'.png';
        QRcode::png($_REQUEST['data'], $filename, $errorCorrectionLevel, $matrixPointSize, 2);    
        
    } else {    
    
        //default data
       
        QRcode::png($ticket_code, $filename, $errorCorrectionLevel, $matrixPointSize, 2);    
        
    }    
        
    //display generated file
    // echo '<img src="'.$PNG_WEB_DIR.basename($filename).'" /><hr/>';  
    
    $mail = new PHPMailer(true);                              // Passing true enables exceptions
try {
    //Server settings
    $phpmailer->SMTPDebug=0;                              // Enable verbose debug output
    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
     $mail->Username = 'eventbox.vanlang@gmail.com';                 // SMTP username
    $mail->Password = 'Pass1230.';               // SMTP username
    $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, ssl also accepted
    $mail->Port = 587;       
    $mail->CharSet = 'UTF-8';                          // TCP port to connect to
 
    //Recipients
     
    $mail->setFrom('EventBox.Vanlang@gmail.com', 'Event '.$title);
    $mail->addAddress($email);     // nlangAdd a recipient
    // $mail->addAddress('ellen@example.com');               // Name is optional
    // $mail->addReplyTo('info@example.com', 'Information');
    // $mail->addCC('cc@example.com');
    // $mail->addBCC('bcc@example.com');
 
    //Attachments
    // $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
    $mail->addAttachment($PNG_WEB_DIR.basename($filename), 'ticket.jpg');    // Optional name
    $content = "<b>Thân gửi bạn!</b><br>
    Vé mời của bạn đã được đính kèm trong email này. Xin vui lòng mang vé tới sự kiện để được điểm danh<br>
    Cảm ơn bạn đã đăng ký tham gia sự kiện!
        -----------------------------------------
        <br>
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
                          
    ";
    // $content += "<table>";
    // $content +=       "                 <thead>";
    // $content +=       "                             <tr>";
    //    $content +=       "                               <th>ID</th>";
    //    $content +=       "                               <th>Tên sự kiện</th>";
    //     $content +=       "                              <th>Thời gian</th>";
    //     $content +=       "                              <th>Địa điểm</th>";
    //                          $content +=       "         <th>Trạng thái</th>";
    //        $content +=       "                           <th>Xét duyệt</th>";
                                   
    //         $content +=       "                      </tr>";
    //          $content +=       "                 </thead>";
    //            $content +=       "               <tbody>";
    //             $content +=       "              </tbody>";
    //      $content +=       " </table>";
    //Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = 'Vé tham dự sự kiện ['.$title.']';
    $mail->Body    = $content;
   
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
    

 
    $mail->send();
   
    header("Location: event_reg_result.php");
} catch (Exception $e) {
    echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
}
        }
        }

        
      

       

}
}


 ?>