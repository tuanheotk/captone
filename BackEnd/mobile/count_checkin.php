<?php 
	require "database-config.php";

	$event_id = $_POST["event_id"];

	class Event{
		function Event($id, $total){
			$this->id = $id;
			$this->total = $total;
		}
	}

	
		$arrayEvent = array();
		$query = "SELECT count(id) as total FROM attendee WHERE event_id = ".$event_id." and status=2";
		$data = mysqli_query($conn, $query);
		if($data){
			while($row = mysqli_fetch_assoc($data)){
				array_push($arrayEvent, new Event($event_id, $row['total']));
				$total = $row['total'];
			}
			if(count($arrayEvent) > 0){
				echo $total;
			}else{
				echo "fail";
			}
		}

 ?>

