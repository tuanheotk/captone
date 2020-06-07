<?php
session_start();
header("Content-Type:application/json");
require "database-config.php";

include "vendor/PHPMailer/src/PHPMailer.php";
include "vendor/PHPMailer/src/Exception.php";
include "vendor/PHPMailer/src/OAuth.php";
include "vendor/PHPMailer/src/POP3.php";
include "vendor/PHPMailer/src/SMTP.php";

include "vendor/qrcode/qrlib.php";
 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$action = $_POST["action"];

if ($action == "get-mod-list-cfg-event") {
	$event_id = $_POST["event-id"];
	// $email_host = $_POST["email-host"];
	$sql = "SELECT id, event_id, email FROM moderator WHERE email != '".$_SESSION["user_email"]."' AND event_id = ".$event_id;
	$result = mysqli_query($conn, $sql);
	if(!$result){
		$data["result"] = false;
	}else{
		if (mysqli_num_rows($result) > 0) {
		    while($row = mysqli_fetch_assoc($result)) {
		       $json[] = $row;
		    }
		    $data["moderator"] = $json;
		    $data["result"] = true;
		}else{
			$data["result"] = false;
			$data["messages"] = "0 mod";
		}
	}
}
if ($action == "add-mod-cfg-event") {
	$event_id = $_POST["event-id"];
	$email_mod = $_POST["email-mod"];
	$sql = "INSERT INTO moderator (event_id, email) VALUES (".$event_id.", '".$email_mod."')";
	$result = mysqli_query($conn, $sql);
	if($result){
		$data["result"] = true;
	}else{
		$data["result"] = false;
	}
}
if ($action == "delete-mod-cfg-event") {
	$id_table_mod = $_POST["id-table-mod"];
	$sql = "DELETE FROM moderator WHERE id = ".$id_table_mod;
	$result = mysqli_query($conn, $sql);
	if($result){
		$data["result"] = true;
	}else{
		$data["result"] = false;
	}
}

if ($action == "add") {
	$account_id = $_POST["account-id"];
	$title = mysqli_real_escape_string($conn, $_POST["name"]);
	$category = $_POST["category"];
	$faculty = $_POST["faculty"];
	// $moderator = $_POST["moderator"];
	$ticketNumber = $_POST["ticket-number"];
	$place = mysqli_real_escape_string($conn, $_POST["place"]);
	$startTime = $_POST["start-time"];
	$endTime = $_POST["end-time"];
	$shortDesc = mysqli_real_escape_string($conn, $_POST["short-desc"]);
	$description = mysqli_real_escape_string($conn, $_POST["description"]);
	$status = $_POST["status"];

    $target_dir = "images/upload/";
    if (!file_exists($_FILES["cover-image"]["tmp_name"])) {
        $target_file = "images/palacebg.jpg";
    } else{
        $target_file = $target_dir.date("YmdHis").basename($_FILES["cover-image"]["name"]);
    }

	// Check image type
	$image_type = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
	$is_image = true;
	
	if($image_type != "jpg" && $image_type != "png" && $image_type != "jpeg" && $image_type != "gif" ) {
		$is_image = false;
	}


    function generate_code()
	{
		$arr = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L',
					'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X',
					'Y', 'Z', '0', '1', '2', '3', '4', '5', '6', '7', '8', '9');
		$c1 = $arr[rand(0,35)];
		$c2 = $arr[rand(0,35)];
		$c3 = $arr[rand(0,35)];
		$c4 = $arr[rand(0,35)];

		$rand_code = $c1.''.$c2.''.$c3.''.$c4;
		return $rand_code;
	}

	$sql_get_code = "SELECT code FROM event WHERE status != 5";
	$result_get_code = mysqli_query($conn, $sql_get_code);

	$code_array = array();

	if (mysqli_num_rows($result_get_code) == 0) {
		$code = generate_code();
	} else {
		while ($row_code = mysqli_fetch_assoc($result_get_code)) {
			array_push($code_array, $row_code['code']);
		}
		
		do {
			$code = generate_code();
			if (in_array($code, $code_array)) {
				$duplicate = true;
			} else {
				$duplicate = false;
			}
			
		} while ($duplicate == true);
	}
	

	// Insert event
	$sqlInsertEvent = "INSERT INTO event(title, account_id, code, place, ticket_number, start_date, end_date, short_desc, description, faculty_id, category_id, status, avatar) VALUES('".$title."', '".$account_id."', '".$code."', '".$place."', ".$ticketNumber." ,'".$startTime."' , '".$endTime."', '".$shortDesc."', '".$description."', ".$faculty.", ".$category.", ".$status.", '".$target_file."')";


	// $resultInsertEvent = mysqli_query($conn, $sqlInsertEvent);
	// $resultInsertEvent = true;

	// $getMaxID = mysqli_query($conn, "SELECT MAX(id) from event");
	// if (mysqli_num_rows($getMaxID) == 0) {
	// 	$event_id = 1;
	// } else {
	// 	$row = mysqli_fetch_assoc($getMaxID);
	// 	$event_id = $row["MAX(id)"];
	// }

    // $sqlInsertMod = "INSERT INTO moderator(email, event_id) VALUES('".$_SESSION["user_email"]."', ".$event_id.")";
    // $resultInsertMod = mysqli_query($conn, $sqlInsertMod);
    // $resultInsertMod = true;

    if ($is_image) {
    	$resultInsertEvent = mysqli_query($conn, $sqlInsertEvent);
	    if($resultInsertEvent){
	    	move_uploaded_file($_FILES["cover-image"]["tmp_name"], $target_file);
	    	$data["result"] = true;
	    }else{
	        $data["result"] = false;
	        $data["error"] = "Error: ".mysqli_error($conn);
			$data["message"] = "Có lỗi xảy ra. Vui lòng thử lại";
	    }
	} else {
		$data["result"] = false;
		$data["message"] = "Xin lỗi, chỉ cho phép hình ảnh có định dạng là: JPG, JPEG, PNG và GIF";
	}
	
} else if ($action == "edit") {

	$eventID = $_POST["id"];
    $title = mysqli_real_escape_string($conn, $_POST["name"]);
	$category = $_POST["category"];
	$faculty = $_POST["faculty"];
	// $moderator = $_POST["moderator"];
	$ticketNumber = $_POST["ticket-number"];
	$place = mysqli_real_escape_string($conn, $_POST["place"]);
	$startTime = $_POST["start-time"];
	$endTime = $_POST["end-time"];
	$shortDesc = mysqli_real_escape_string($conn, $_POST["short-desc"]);
	$description = mysqli_real_escape_string($conn, $_POST["description"]);
	$status = $_POST["status"];

	$target_dir = "images/upload/";
    if (!file_exists($_FILES["cover-image"]["tmp_name"])) {
        $target_file = $_POST["current-image"];
    } else{
    	// Delete old image
    	unlink($_POST["current-image"]);
        $target_file = $target_dir.date("YmdHis").basename($_FILES["cover-image"]["name"]);
    }
	// Check image type
	$image_type = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
	$is_image = true;
	
	if($image_type != "jpg" && $image_type != "png" && $image_type != "jpeg" && $image_type != "gif" ) {
		$is_image = false;
	}

    if ($status == 4) {
		$sqlUpdateEvent = "UPDATE event SET title = '".$title."', category_id = '".$category."', place = '".$place."', ticket_number = '".$ticketNumber."', start_date = '".$startTime."', end_date = '".$endTime."', short_desc = '".$shortDesc."', description = '".$description."', faculty_id = '".$faculty."', status ='".$status."', avatar = '".$target_file."', public_at = NOW() WHERE id = ".$eventID;
    } else {
    	$sqlUpdateEvent = "UPDATE event SET title = '".$title."', category_id = '".$category."', place = '".$place."', ticket_number = '".$ticketNumber."', start_date = '".$startTime."', end_date = '".$endTime."', short_desc = '".$shortDesc."', description = '".$description."', faculty_id = '".$faculty."', status ='".$status."', avatar = '".$target_file."', last_modified = NOW() WHERE id = ".$eventID;
    }
    
    if ($is_image) {
		$updateEvent = mysqli_query($conn, $sqlUpdateEvent);
		// $updateEvent = true;


	    // $sqlupdateMod = "UPDATE moderator SET account_id = '".$moderator."' WHERE status = 0 AND event_id =". $eventID;
	    // $updateMod = mysqli_query($conn, $sqlupdateMod);
	    // $updateMod = true;

	    if($updateEvent){
	    	move_uploaded_file($_FILES["cover-image"]["tmp_name"], $target_file);
	        $data["result"] = true;
	    }else{
	        $data["result"] = false;
	        $data["error"] = "Error: ".mysqli_error($conn);
	        $data["message"] = "Có lỗi xảy ra. Vui lòng thử lại";
	    }
    } else {
		$data["result"] = false;
		$data["message"] = "Xin lỗi, chỉ cho phép hình ảnh có định dạng là: JPG, JPEG, PNG và GIF";
    }

} else if ($action == "delete") {
	$even_id = $_POST["id"];
	$user_id = $_POST["uid"];

	$sql_check_owner = "SELECT id FROM event WHERE id = $even_id AND account_id = $user_id";
	$result_check_owner = mysqli_query($conn, $sql_check_owner);

	if (mysqli_num_rows($result_check_owner) > 0) {
		$sql_delete_event = "UPDATE event SET status = 5 WHERE id = ".$even_id;
		$result_delete_event = mysqli_query($conn, $sql_delete_event);
		if($result_delete_event){
			$data["result"]=true;
		}else{
			$data["result"]=false;
		}
	} else {
		$data["result"]=false;
	}
} else if ($action == "setting") {
	$event_id = $_POST["id"];
	
	// $make_question = $_POST["make-question"];
	// $reply_question = $_POST["reply-question"];

	if (isset($_POST["make-question"])) {
		$make_question = 1;
	} else {
		$make_question = 0;
	}

	if (isset($_POST["reply-question"])) {
		$reply_question = 1;
	} else {
		$reply_question = 0;
	}


	$sql = "UPDATE event SET user_make_question = ".$make_question.", user_reply_question = ".$reply_question." WHERE id = ".$event_id;
	$result = mysqli_query($conn, $sql);

	if ($result) {
		$data["result"] = true;
	} else {
		$data["result"] = false;
	}
	
} else if ($action == "checkin") {
	$event_id = $_POST["event-id"];
	$ticket_code = $_POST["ticket-code"];

	$sqlCheckStatus = "SELECT status FROM attendee WHERE ticket_code = '".$ticket_code."' AND event_id = ".$event_id;
	$resultCheckStatus = mysqli_query($conn, $sqlCheckStatus);
	
	if (mysqli_num_rows($resultCheckStatus) > 0) {
		$row = mysqli_fetch_assoc($resultCheckStatus);

		$status = $row["status"];

		if ($status == 0) {
			$sqlCheckIn = "UPDATE attendee SET status = 1 WHERE status = 0 AND ticket_code = '".$ticket_code."' AND event_id = ".$event_id;
			$resultCheckIn = mysqli_query($conn, $sqlCheckIn);
			$data["result"] = true;
			$data["message"] = "Điểm danh thành công";
		} else if ($status == 1) {
			$data["result"] = false;
			$data["message"] = "Vé này đã được điểm danh";
		} else if ($status == 2) {
			$data["result"] = false;
			$data["message"] = "Vé của bạn chưa được duyệt nên không thể điểm danh";
		}
	} else {
		$data["result"] = false;
		$data["message"] = "Vé không hợp lệ";
	}
} else if ($action == "checkin-no-ticket") {
	$event_id = $_POST["event-id"];
	$email = $_POST["attendee-email"];

	// $email = $attendee_code."@vanlanguni.vn";

	$sql_check_registered = "SELECT id FROM attendee WHERE email = '$email' AND event_id = $event_id";
	$result_check_registered = mysqli_query($conn, $sql_check_registered);

	if (mysqli_num_rows($result_check_registered) > 0) {
		// Update status for registered attendee
		$sql_update_status = "UPDATE attendee SET status = 1 WHERE email = '$email' AND event_id = $event_id";
		$result_update_status = mysqli_query($conn, $sql_update_status);
		
		if ($result_update_status) {
			$data["result"] = true;
			$data["message"] = "Điểm danh thành công";
		} else {
			$data["result"] = false;
		}
		
	} else {
		// Insert new attendee
		$sql_insert_new_attendee = "INSERT INTO attendee (email, event_id, status) VALUES ('$email', $event_id, 1)";
		$result_insert_new_attendee = mysqli_query($conn, $sql_insert_new_attendee);

		if ($result_insert_new_attendee) {
			$data["result"] = true;
			$data["message"] = "Điểm danh thành công";
		} else {
			$data["result"] = false;
		}
	}	
} else if ($action == "import-email") {
	if(file_exists($_FILES["excel"]["tmp_name"])){
		$file_name = basename($_FILES["excel"]["name"]);
		$extension = strtolower(pathinfo($file_name,PATHINFO_EXTENSION));
		$allowed_extension = array("xls", "xlsx", "csv"); //allowed extension
		if(in_array($extension, $allowed_extension)) {
			$file = $_FILES["excel"]["tmp_name"];
			require('vendor/PHPExcel/PHPExcel.php');
			$objPHPExcel = PHPExcel_IOFactory::load($file);



			// change post
			$event_id = $_POST['event-id'];

			// $sent_email = 0;

			$invalid_email_array = array();
			$duplicate_email_array = array();
			$registered_email_array = array();
			$new_email_array = array();

			$sql_get_event_info = "SELECT title, start_date, place FROM event WHERE id = $event_id";
			$result_event_info = mysqli_query($conn, $sql_get_event_info);
			$row_event_info = mysqli_fetch_assoc($result_event_info);

			$event_title = $row_event_info['title'];
			$event_time = date("H:i - d/m/Y", strtotime($row_event_info["start_date"]));;
			$event_place = $row_event_info['place'];


			foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
				$highestRow = $worksheet->getHighestRow();

				for($row=1; $row<=$highestRow; $row++) {
					$email = mysqli_real_escape_string($conn, $worksheet->getCellByColumnAndRow(0, $row)->getValue());
					$ticket_code = md5(uniqid(rand(), true));

					$sql_search = "SELECT id, ticket_code, status FROM attendee WHERE email = '$email' AND event_id = $event_id";
					$result_search = mysqli_query($conn, $sql_search);

					if (mysqli_num_rows($result_search) > 0) {
						$row_search = mysqli_fetch_assoc($result_search);
						$id_tbl_attendee = $row_search['id'];
						$ticket_code = $row_search['ticket_code'];
						$status = $row_search['status'];

						if ($status == 2) {
							// Send mail
							if (send_mail($email, $ticket_code, 'old')) {
								mysqli_query($conn, "UPDATE attendee SET status = 0 WHERE id = $id_tbl_attendee");
								// array_push($registered_email_array, 'Dòng '.$row.': '.$email);
								array_push($registered_email_array, $email);
							}
						} else {
							// array_push($duplicate_email_array, 'Dòng '.$row.': '.$email);
							array_push($duplicate_email_array, $email);
						}
					} else {
					  $sql_insert = "INSERT INTO attendee (email, event_id, ticket_code, status) VALUES ('$email', $event_id, '$ticket_code', 0)";
					    if (send_mail($email, $ticket_code, 'new')) mysqli_query($conn, $sql_insert);
					}

				}
			}

			$data['result'] = true;
			$data['file-name'] = $file_name;
			$data['new-email'] = $new_email_array;
			$data['duplicate-email'] = $duplicate_email_array;
			$data['registered-email'] = $registered_email_array;
			$data['invalid-email'] = $invalid_email_array;
		} else {
			$data['result'] = false;
			$data['message'] = 'Chỉ cho phép file có định dạng: .xls, .xlsx, .csv';
		}
	} else {
		$data['result'] = false;
		$data['message'] = 'Vui lòng chọn file excel';
	}
}

function send_mail($email, $ticket_code, $type) {
	global $event_title, $event_time, $event_place, $invalid_email_array, $new_email_array, $row;

	// content
	if ($type == 'old') {
		$content = "<b>Thân gửi bạn!</b><br>
		Vé mời của bạn đã được đính kèm trong email này. Xin vui lòng mang vé tới sự kiện để được điểm danh<br>
		Cảm ơn bạn đã đăng ký tham gia sự kiện!
		<br>-----------------------------------------
		<br>
		<table>
		<tr>
		<td><b>Sự kiện:</b></td>
		<td>".$event_title."</td>
		</tr>
		<tr>
		<td><b>Thời gian:</b></td>
		<td>".$event_time."</td>
		</tr>
		<tr>
		<td><b>Địa điểm:</b></td>
		<td>".$event_place."</td>
		</tr>
		</table>";

	} else if ($type == 'new') {
		$content = "<b>Thân gửi bạn!</b><br>
		Trân trọng kính mời bạn đến tham gia sự kiện. <br>
		Vé mời của bạn đã được đính kèm trong email này. Xin vui lòng mang vé tới sự kiện để được điểm danh<br>
		Rất mong sự có mặt của bạn ở sự kiện!
		<br>-----------------------------------------
		<br>
		<table>
		<tr>
		<td><b>Sự kiện:</b></td>
		<td>".$event_title."</td>
		</tr>
		<tr>
		<td><b>Thời gian:</b></td>
		<td>".$event_time."</td>
		</tr>
		<tr>
		<td><b>Địa điểm:</b></td>
		<td>".$event_place."</td>
		</tr>
		</table>";
	}

	// setup qr code
	$PNG_TEMP_DIR = dirname(__FILE__).DIRECTORY_SEPARATOR.'temp'.DIRECTORY_SEPARATOR;
	$PNG_WEB_DIR = 'temp/';
	if (!file_exists($PNG_TEMP_DIR)) mkdir($PNG_TEMP_DIR);
	$filename = $PNG_TEMP_DIR.'test.png';
	QRcode::png($ticket_code, $filename, 'H', 10, 2);


	// send mail
	$mail = new PHPMailer(true);                              // Passing `true` enables exceptions
	try {
		//Server settings
		$mail->SMTPDebug = 0;                                 // Enable verbose debug output
		$mail->isSMTP();                                      // Set mailer to use SMTP
		$mail->Host = 'smtp.office365.com';  // Specify main and backup SMTP servers
		$mail->SMTPAuth = true;                               // Enable SMTP authentication
		$mail->Username = 'sukien@vanlanguni.edu.vn';                 // SMTP username
		$mail->Password = 'Events2020';                           // SMTP password
		$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
		$mail->Port = 587;                                    // TCP port to connect to

		//Recipients
		$mail->CharSet = 'UTF-8';
		$mail->setFrom('sukien@vanlanguni.edu.vn', 'EventBox - Văn Lang');
		$mail->addAddress($email);

		//Content
		$mail->isHTML(true);                                  // Set email format to HTML
		$mail->Subject = 'Vé mời tham dự sự kiện - EventBox Văn Lang';

		$mail->addAttachment($PNG_WEB_DIR.basename($filename), 'ticket.jpg');      
		$mail->Body    = $content;
		$mail->AltBody = '';

		$mail->send();
		// echo 'Message has been sent';
		$successful_mailing = true;
		// array_push($new_email_array, 'Dòng '.$row.': '.$email);
		array_push($new_email_array, $email);
	} catch (Exception $e) {
		$successful_mailing = false;
		array_push($invalid_email_array, 'Dòng '.$row.': '.$email);
		// $data["error"] =  $mail->ErrorInfo;
		// echo $mail->ErrorInfo;
	}

	return $successful_mailing;

}


mysqli_close($conn);
echo json_encode($data);
?>