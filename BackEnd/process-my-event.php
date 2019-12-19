<?php 
header("Content-Type:application/json");
require "database-config.php";

$action = $_POST["action"];
$action = $_POST["action"];

if ($action == "get-category-for-dropdown") {
	$sql = "SELECT * from category";
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

} else if ($action == "add") {


    $result = mysqli_query($conn, $sql);
    if($result){
        $data["result"] = true;
    }else{
        $data["result"] = false;
    }
	
} else if ($action == "edit") {


    $result = mysqli_query($conn, $sql);
    if($result){
        $data["result"] = true;
    }else{
        $data["result"] = false;
    }

} else if ($action == "delete") {
	

	if($result){
		$data["result"]=true;
	}else{
		$data["result"]=false;
	}

} else {
	$id = $_POST["id"];

	$sql = "DELETE FROM debt WHERE id IN (".$id.")";
	$result = mysqli_query($conn, $sql);
	$data["result"] = true;
}

mysqli_close($conn);
echo json_encode($data);
?>