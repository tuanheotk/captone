<?php 
	require "database-config.php";

	$event_id = $_POST["event_id"];
	$email = $_POST["email"];

		$query = "INSERT INTO moderator VALUES (null, ".$event_id.", '".$email."', 0)";
		$data = mysqli_query($conn, $query);
		if($data){
			echo "success";
			
		}else{
				echo "fail";
			}

 ?>

