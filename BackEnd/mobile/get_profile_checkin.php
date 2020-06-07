<?php 
	require "database-config.php";

	$ticket_code = $_POST["ticket_code"];

	class Profile{
		function Profile($name, $faculty, $email){
			$this->name = $name;
			$this->faculty = $faculty;
			$this->email = $email;	
		}
	}
	
		$arrayProfile = array();
		$query = "SELECT b.name, b.faculty_id, f.name as faculty, b.email FROM attendee a, account b, faculty f WHERE a.email = b.email and a.ticket_code = '".$ticket_code."' and b.faculty_id = f.faculty_id";
		$data = mysqli_query($conn, $query);
		if($data){
			while($row = mysqli_fetch_assoc($data)){
				array_push($arrayProfile, new Profile($row['name'], $row['faculty'], $row['email']));
			}
			if(count($arrayProfile) > 0){
				echo json_encode($arrayProfile);
			}else{
				echo "fail";
			}
		}else {
			echo "fail2";
		}

 ?>

