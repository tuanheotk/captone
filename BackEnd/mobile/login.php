<?php 
	require "database-config.php";

	$email = $_GET["email"];
	$password = $_GET["password"];

	class Event{
		function Event($email, $password){
			$this->email = $email;
			$this->password = $password;
			}
	}

	
		$arrayEvent = array();
		$query = "SELECT email, password from account where email = '".$email."' and password = '".$password."'";
		$data = mysqli_query($conn, $query);
		if($data){
			if(mysqli_num_rows($data) > 0){
				echo "success";
			}else{
				echo "fail";
			}	
		}else{
			echo "fail";
		}

 ?>

