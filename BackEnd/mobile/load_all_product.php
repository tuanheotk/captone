<?php 
	require "database-config.php";


	class Event{
		function Event($name, $description, $price, $address, $avatar){
			$this->name = $name;
			$this->description = $description;
			$this->price = $price;
			$this->address = $address;
			$this->avatar = $avatar;
		}
	}

	
		$arrayEvent = array();
		$query = "SELECT * from profile";
		$data = mysqli_query($conn, $query);
		if($data){
			while($row = mysqli_fetch_assoc($data)){
				array_push($arrayEvent, new Event($row['name'], $row['description'], $row['price'], $row['address'], $row['avatar']));
			}
			if(count($arrayEvent) > 0){
				echo json_encode($arrayEvent);
			}else{
				echo "fail";
			}
		}

 ?>

