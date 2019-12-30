<?php 
session_start();
header("Content-Type:application/json");
require "database-config.php";

$action = $_POST["action"];

if ($action == "add") {
	
	
} else if ($action == "edit") {
	// update info by admin
	$accountID = $_POST["account-id"];
    $name = $_POST["name"];
	$role = $_POST["role"];
	$faculty = $_POST["faculty"];
	$status = $_POST["status"];


	$sql = "UPDATE account set name = '".$name."', role = ".$role.", faculty_id = ".$faculty.", status =".$status." WHERE id = ".$accountID;
	$result = mysqli_query($conn, $sql);

    if($result){
        $data["result"] = true;
    }else{
        $data["result"] = false;
        $data["error"] = "Error: ".mysqli_error($conn);
    }

} else if ($action == "require-info") {
	// update require info by user
	$email = $_POST["email"];
    $name = $_POST["name"];
	$faculty = $_POST["faculty"];

	$sql = "UPDATE account set name = '".$name."', faculty_id = '".$faculty."' WHERE email = '".$_SESSION["user_email"]."'";
	$result = mysqli_query($conn, $sql);

    if($result){
        $data["result"] = true;
    }else{
        $data["result"] = false;
        $data["error"] = "Error: ".mysqli_error($conn);
    }
}
mysqli_close($conn);
echo json_encode($data);
?>