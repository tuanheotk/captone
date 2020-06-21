<?php
session_start();
header("Content-Type:application/json");
require "database-config.php";

$action = $_POST["action"];

if ($action == "load") {
	$sql = "SELECT * FROM cover ORDER BY id DESC";
	$result = mysqli_query($conn, $sql);
	if ($result) {
		if (mysqli_num_rows($result) > 0) {
			while ($row = mysqli_fetch_assoc($result)) {
				$cover[] = $row;
			}

			$data['result'] = true;
			$data['cover'] = $cover;
		} else {
			$data['result'] = false;
			$data['message'] = 'Chưa có ảnh';
		}
	} else {
		$data['result'] = false;
	}
	
}else if ($action == "add") {
	$target_dir = "images/cover/";
    if (file_exists($_FILES["cover-image"]["tmp_name"])) {
        $target_file = $target_dir.date("YmdHis").basename($_FILES["cover-image"]["name"]);
        $extension = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
		$allowed_extension = array('jpg', 'jpeg', 'png');

		if (in_array($extension, $allowed_extension)) {
			$sql_insert_image = "INSERT INTO cover (link) VALUES ('$target_file')";
			$result_insert_image = mysqli_query($conn, $sql_insert_image);
			if ($result_insert_image) {
				move_uploaded_file($_FILES["cover-image"]["tmp_name"], $target_file);
	    		$data['result'] = true;
			} else {
	    		$data['result'] = true;
	    		$data['message'] = 'Có lỗi xảy ra. Vui lòng thử lại!';
			}
		} else {
			$data['result'] = false;
			$data['message'] = 'Xin lỗi chỉ cho phép định dạng: JPG, JPEG, PNG';
		}
    } else{
    	$data['result'] = false;
    	$data['message'] = 'Vui lòng chọn ảnh';
    }
	
} else if ($action == "delete") {
	$id = $_POST['id'];
	$img = $_POST['src'];
	$sql_delete = "DELETE FROM cover WHERE id = $id";
	$result_delete = mysqli_query($conn, $sql_delete);
	if ($result_delete) {
		unlink($img);
		$data['result'] = true;
	} else {
		$data['result'] = false;
	}
	

} else if ($action == "select") {
	$id = $_POST['id'];
	$sql_update_old = "UPDATE cover SET selected = 0";
	$result_update_old = mysqli_query($conn, $sql_update_old);

	$sql_select = "UPDATE cover SET selected = 1 WHERE id = $id";
	$result_select = mysqli_query($conn, $sql_select);
	if ($result_select) {
		$data['result'] = true;
	} else {
		$data['result'] = false;
	}
} else if ($action == "reset") {
	$sql_update = "UPDATE cover SET selected = 0";
	$result_update =  mysqli_query($conn ,$sql_update);

	if ($result_update) {
		$data['result'] = true;
	} else {
		$data['result'] = false;
	}
	
}

mysqli_close($conn);
echo json_encode($data);
?>