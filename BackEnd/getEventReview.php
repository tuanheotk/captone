<?php 
header("Content-Type:application/json");
require "database-config.php";

	$sql = "SELECT id, title, start_date, place from event where status = 1 order by id desc";



$result = mysqli_query($conn, $sql);
// $sql2 = "SELECT id,name from category";
// $result = mysqli_query($conn, $sql2);
if(!$result){
	$data["message"] ="Can't query data".mysqli_error($conn) ;
	// $data["message"] ="Can't query data".mysqli_error($conn) ;
	$data["result"] = false;
}else{
	if (mysqli_num_rows($result) > 0) {
	    while($row = mysqli_fetch_assoc($result)) {
	       $json[] = $row;
	    }
	    $data["events"] = $json;
	    // $data["category"] = $json;
	    $data["result"] = true;

	}else{
		$data["message"] ="0 product" ;
		$data["result"] = false;
	}
}
mysqli_close($conn);
echo json_encode($data);
?>