<?php
session_start();
header("Content-Type:application/json");
require "database-config.php";

$action = $_POST["action"];

if ($action == "get-mod-list-cfg-event") {
	$event_id = $_POST["event-id"];
	$email_host = $_POST["email-host"];
	$sql = "SELECT id, event_id, email FROM moderator WHERE email != '".$email_host."' AND event_id = ".$event_id;
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
	$title = $_POST["name"];
	$category = $_POST["category"];
	$faculty = $_POST["faculty"];
	// $moderator = $_POST["moderator"];
	$ticketNumber = $_POST["ticket-number"];
	$place = $_POST["place"];
	$startTime = $_POST["start-time"];
	$endTime = $_POST["end-time"];
	$shortDesc = $_POST["short-desc"];
	$description = $_POST["description"];
	$status = $_POST["status"];

    $target_dir = "images/upload/";
    if (!file_exists($_FILES["cover-image"]["tmp_name"])) {
        $target_file = "images/palacebg.jpg";
    } else{
        $target_file = $target_dir.date("YmdHis").basename($_FILES["cover-image"]["name"]);
    }
    // move_uploaded_file($_FILES["cover-image"]["tmp_name"], $target_file);


    function generateCode()
	{
		$arr = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L'
					, 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X'
					, 'Y', 'Z', '0', '1', '2', '3', '4', '5', '6', '7', '8', '9');
		$c1 = $arr[rand(0,35)];
		$c2 = $arr[rand(0,35)];
		$c3 = $arr[rand(0,35)];
		$c4 = $arr[rand(0,35)];

		$randCode = $c1.''.$c2.''.$c3.''.$c4;
		return $randCode;
	}

	$sqlSearchCode = "SELECT code FROM event ORDER BY id DESC LIMIT 1";
	$getLastCode = mysqli_query($conn, $sqlSearchCode);
	if (mysqli_num_rows($getLastCode) == 0) {
		$code = generateCode();
	} else {
		$row = mysqli_fetch_assoc($getLastCode);
		$lastCode = $row["code"];

		do {
			$code = generateCode();
		} while ($code == $lastCode);
	}
	


	// Insert event
	$sqlInsertEvent = "INSERT INTO event(title, account_id, code, place, ticket_number, start_date, end_date, short_desc, description, faculty_id, category_id, status, avatar) VALUES('".$title."', '".$account_id."', '".$code."', '".$place."', ".$ticketNumber." ,'".$startTime."' , '".$endTime."', '".$shortDesc."', '".$description."', ".$faculty.", ".$category.", ".$status.", '".$target_file."')";
	$resultInsertEvent = mysqli_query($conn, $sqlInsertEvent);
	// $resultInsertEvent = true;

	$getMaxID = mysqli_query($conn, "SELECT MAX(id) from event");
    if (mysqli_num_rows($getMaxID) == 0) {
    	$event_id = 1;
    } else {
    	$row = mysqli_fetch_assoc($getMaxID);
    	$event_id = $row["MAX(id)"];
    }

    $sqlInsertMod = "INSERT INTO moderator(email, event_id) VALUES('".$_SESSION["user_email"]."', ".$event_id.")";
    $resultInsertMod = mysqli_query($conn, $sqlInsertMod);
    $resultInsertMod = true;

    if($resultInsertEvent){
    	move_uploaded_file($_FILES["cover-image"]["tmp_name"], $target_file);
    	$resultInsertMod = mysqli_query($conn, $sqlInsertMod);
    	if ($resultInsertMod) {
        	$data["result"] = true;
    	}
    }else{
        $data["result"] = false;
        $data["error"] = "Error: ".mysqli_error($conn);
        $data["error"] = $sqlInsertMod;
    }
	
} else if ($action == "edit") {

	$eventID = $_POST["id"];
    $title = $_POST["name"];
	$category = $_POST["category"];
	$faculty = $_POST["faculty"];
	// $moderator = $_POST["moderator"];
	$ticketNumber = $_POST["ticket-number"];
	$place = $_POST["place"];
	$startTime = $_POST["start-time"];
	$endTime = $_POST["end-time"];
	$shortDesc = $_POST["short-desc"];
	$description = $_POST["description"];
	$status = $_POST["status"];

	$target_dir = "images/upload/";
    if (!file_exists($_FILES["cover-image"]["tmp_name"])) {
        $target_file = $_POST["current-image"];
    } else{
        $target_file = $target_dir.date("YmdHis").basename($_FILES["cover-image"]["name"]);
    }
    move_uploaded_file($_FILES["cover-image"]["tmp_name"], $target_file);

    if ($status == 4) {
		$sqlUpdateEvent = "UPDATE event SET title = '".$title."', category_id = '".$category."', place = '".$place."', ticket_number = '".$ticketNumber."', start_date = '".$startTime."', end_date = '".$endTime."', short_desc = '".$shortDesc."', description = '".$description."', faculty_id = '".$faculty."', status ='".$status."', avatar = '".$target_file."', public_at = NOW() WHERE id = ".$eventID;
    } else {
    	$sqlUpdateEvent = "UPDATE event SET title = '".$title."', category_id = '".$category."', place = '".$place."', ticket_number = '".$ticketNumber."', start_date = '".$startTime."', end_date = '".$endTime."', short_desc = '".$shortDesc."', description = '".$description."', faculty_id = '".$faculty."', status ='".$status."', avatar = '".$target_file."', last_modified = NOW() WHERE id = ".$eventID;
    }
    
	$updateEvent = mysqli_query($conn, $sqlUpdateEvent);
	// $updateEvent = true;


    // $sqlupdateMod = "UPDATE moderator SET account_id = '".$moderator."' WHERE status = 0 AND event_id =". $eventID;
    // $updateMod = mysqli_query($conn, $sqlupdateMod);
    // $updateMod = true;

    if($updateEvent){
        $data["result"] = true;
    }else{
        $data["result"] = false;
        $data["error"] = "Error: ".mysqli_error($conn);
        $data["sql"] = $sqlUpdateEvent;
    }

} else if ($action == "delete") {
	$id = $_POST["id"];
	$sql = "UPDATE event SET status = 5 WHERE id = ".$id;
	$result = mysqli_query($conn, $sql);
	if($result){
		$data["result"]=true;
	}else{
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
	
}

mysqli_close($conn);
echo json_encode($data);
?>