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
} else if ($action == "check-email") {
	$email = $_POST["email"];
	$sqlCheck = "SELECT id FROM account WHERE email = '".$email."'";
	$resultCheck = mysqli_query($conn, $sqlCheck);
		// $data["message"] = $sqlCheck;
	if (mysqli_num_rows($resultCheck) > 0) {
		$data["exist"] = true;
	} else {
		$data["exist"] = false;
	}

} else if ($action == 'register') {
	$user_fullname = $_POST['full-name'];
	$user_email = $_POST['email'];
	$user_pass = $_POST['password'];
	$verify_code = md5(uniqid('', true));

	$sqlCheck = "SELECT id FROM account WHERE email = '".$user_email."'";
	$resultCheck = mysqli_query($conn, $sqlCheck);
	if (mysqli_num_rows($resultCheck) > 0) {
		$data["result"] = false;
		$data["error"] = "Email ".$user_email." đã có người sử dụng";
	} else {
		$sqlInsert = "INSERT INTO account (name, email, password, verify_code) VALUES ('".$user_fullname."', '".$user_email."', '".$user_pass."', '".$verify_code."')";

		$resultInsert = mysqli_query($conn, $sqlInsert);

		if ($resultInsert) {
			$data["result"] = true;
			require('send-mail-activate.php');
		} else {
			$data["result"] = false;
			$data["error"] = "Error: ".mysqli_error($conn);
		}
	}

} else if ($action == "login") {
	$_SESSION['last_active'] = time();
	
	$email = $_POST["email"];
	$pass = $_POST["password"];
	$sqlCheckInfo = "SELECT email, verified FROM account WHERE verify_code != '' AND email = '".$email."' AND BINARY password = '".$pass."'";

	$resultCheckInfo = mysqli_query($conn, $sqlCheckInfo);

	if(mysqli_num_rows($resultCheckInfo) > 0) {
		$rowInfo = mysqli_fetch_assoc($resultCheckInfo);

		$verified = ($rowInfo["verified"] == 1) ? true : false;

		if ($verified) {
			$data["result"] = true;
			$_SESSION["user_email"] = $rowInfo["email"];
		} else {
			$data["result"] = false;
			$data["message"] = "Tài khoản của bạn chưa được kích hoạt. Vui lòng kiểm tra email";
		}

	} else {
		$data["result"] = false;
		$data["message"] = "Thông tin đăng nhập không chính xác";
	}




}
mysqli_close($conn);
echo json_encode($data);
?>