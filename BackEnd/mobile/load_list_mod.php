<?php 
	require "database-config.php";

	$event_id = $_GET['event_id'];

	class Event{
		function Event($name, $faculty, $email, $avatar){
			$this->name = $name;
			$this->faculty = $faculty;
			$this->email = $email;
			$this->avatar = $avatar;
		}
	}

	
		$arrayEvent = array();
		$query = "SELECT name, faculty_id, a.email, avatar from account a, moderator m where a.email = m.email and m.event_id = ".$event_id;
		$data = mysqli_query($conn, $query);
		if($data){
			while($row = mysqli_fetch_assoc($data)){
				array_push($arrayEvent, new Event($row['name'], $row['faculty_id'], $row['email'], $row['avatar']));
			}
			if(count($arrayEvent) > 0){
				echo json_encode($arrayEvent);
			}else{
				echo "fail";
			}
		}

 ?>

