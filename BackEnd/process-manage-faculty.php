<?php
session_start();
header("Content-Type:application/json");
require "database-config.php";

$action = $_POST["action"];

if ($action == "add") {
    $faculty_name = $_POST["faculty-name"];
	$sql = "INSERT INTO faculty(name) VALUES('".$faculty_name."')";
	$result = mysqli_query($conn, $sql);
	if ($result) {
		$data["result"] = true;
	} else {
		$data["result"] = false;
	}
	
} else if ($action == "edit") {
	// update info by admin
	$faculty_id = $_POST["faculty-id"];
    $faculty_name = $_POST["faculty-name"];


	$sql = "UPDATE faculty set name = '".$faculty_name."' WHERE faculty_id = ".$faculty_id;

	// if ($faculty_id != -1 && $faculty_id != 999999999) {
		$result = mysqli_query($conn, $sql);
	// }


    if($result){
        $data["result"] = true;
    }else{
        $data["result"] = false;
        $data["error"] = "Error: ".mysqli_error($conn);
    }

} else {
	$data["result"] = false;
}

mysqli_close($conn);
echo json_encode($data);
?>