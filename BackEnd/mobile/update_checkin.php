<?php 
	require "database-config.php";

	$ticket_code = $_POST["ticket_code"];
	$event_id = $_POST["event_id"];
	$count = 0;
		$query = "UPDATE attendee SET status=1 WHERE ticket_code='".$ticket_code."' and event_id='".$event_id."' and status!=1";
		$data = mysqli_query($conn, $query);
		if($data){
		
			if(mysqli_affected_rows($conn)==0){
				echo "fail";
			}else{
					echo "success";
				}
		}else{
				echo "fail";
			}

 ?>

