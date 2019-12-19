<?php 
header("Content-Type:application/json");
require "database-config.php";

$action = $_POST["action"];

if ($action == "get-category-for-dropdown") {
	$sql = "SELECT * FROM category";
	$result = mysqli_query($conn, $sql);
	if(!$result){
		$data["result"] = false;
	}else{
		if (mysqli_num_rows($result) > 0) {
		    while($row = mysqli_fetch_assoc($result)) {
		       $json[] = $row;
		    }
		    $data["category"] = $json;
		    $data["result"] = true;
		}else{
			$data["result"] = false;
			$data["messages"] = "0 category";
		}
	}
}

if ($action == "get-faculty-for-dropdown") {
	$sql = "SELECT * FROM faculty WHERE status = 1";
	$result = mysqli_query($conn, $sql);
	if(!$result){
		$data["result"] = false;
	}else{
		if (mysqli_num_rows($result) > 0) {
		    while($row = mysqli_fetch_assoc($result)) {
		       $json[] = $row;
		    }
		    $data["faculty"] = $json;
		    $data["result"] = true;
		}else{
			$data["result"] = false;
			$data["messages"] = "0 faculty";
		}
	}

}

if ($action == "add") {

	$title = $_POST["name"];
	$category = $_POST["category"];
	$faculty = $_POST["faculty"];
	$moderator = $_POST["moderator"];
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
    move_uploaded_file($_FILES["cover-image"]["tmp_name"], $target_file);


	$sqlInsertEvent = "INSERT INTO event(title, ticket_number, start_date, end_date, short_desc, description, faculty_id, category_id, status, avatar) VALUES('".$title."', ".$ticketNumber." ,'".$startTime."' , '".$endTime."', '".$shortDesc."', '".$description."', ".$faculty.", ".$category.", ".$status.", '".$target_file."')";
	$insertEvent = mysqli_query($conn, $sqlInsertEvent);
	// $insertEvent = true;

	$getMaxID = mysqli_query($conn, "SELECT MAX(id) from event");
    if (mysqli_num_rows($getMaxID) == 0) {
    	$event_id = 1;
    } else {
    	$row = mysqli_fetch_assoc($getMaxID);
    	$event_id = $row["MAX(id)"];
    }

    $sqlInsertMod = "INSERT INTO moderator(account_id, event_id) VALUES(".$moderator.", ".$event_id.")";
    $insertMod = mysqli_query($conn, $sqlInsertMod);
    // $insertMod = true;

    if($insertEvent && $insertEvent){
        $data["result"] = true;
        $data["description"] = $description;
    }else{
        $data["result"] = false;
        $data["error"] = "Error: ".mysqli_error($conn);
        $data["sql"] = $sqlInsertEvent;
    }
	
} else if ($action == "edit") {

	$eventID = $_POST["id"];
    $title = $_POST["name"];
	$category = $_POST["category"];
	$faculty = $_POST["faculty"];
	$moderator = $_POST["moderator"];
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


	$sqlUpdateEvent = "UPDATE event SET title = '".$title."', category_id = '".$category."', place = '".$place."', ticket_number = '".$ticketNumber."', start_date = '".$startTime."', end_date = '".$endTime."', short_desc = '".$shortDesc."', description = '".$description."', faculty_id = '".$faculty."', status ='".$status."', avatar = '".$target_file."' WHERE id = ".$eventID;
	$updateEvent = mysqli_query($conn, $sqlUpdateEvent);
	// $updateEvent = true;


    $sqlupdateMod = "UPDATE moderator SET account_id = '".$moderator."' WHERE status = 0 AND event_id =". $eventID;
    $updateMod = mysqli_query($conn, $sqlupdateMod);
    // $updateMod = true;

    if($updateEvent && $updateMod){
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

}

mysqli_close($conn);
echo json_encode($data);
?>