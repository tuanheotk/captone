<?php 
	require "database-config.php";

	$email =  $_GET["email"];

	class Event{
		function Event($id, $account_id, $category_id, $title, $code, $place, $avatar, $ticket_number, $start_date, $end_date, $expired_date, $short_desc, $email, $status, $faculty){
			$this->id = $id;
			$this->account_id = $account_id;
			$this->category_id = $category_id;
			$this->title = $title;
			$this->code = $code;
			$this->place = $place;
			$this->avatar = $avatar;
			$this->ticket_number = $ticket_number;
			$this->start_date = $start_date;
			$this->end_date = $end_date;
			$this->expired_date = $expired_date;
			$this->short_desc = $short_desc;
			$this->email = $email;
			$this->status = $status;
			$this->faculty = $faculty;


			
		}
	}

	
		$arrayEvent = array();
		$query = "SELECT e.id, e.account_id, e.category_id, e.title, e.code, e.place, e.avatar, e.ticket_number, e.start_date, e.end_date, e.expired_date, e.short_desc, m.email, e.status, f.name from event e, moderator m, account a, faculty f where e.faculty_id = f.faculty_id and e.id = m.event_id and m.email = '".$email."' and m.email = a.email and e.status=4";
		$data = mysqli_query($conn, $query);
		if($data){
			while($row = mysqli_fetch_assoc($data)){
				array_push($arrayEvent, new Event($row['id'], $row['account_id'], $row['category_id'], $row['title'], $row['code'], $row['place'], $row['avatar'], $row['ticket_number'], date ("H:i d/m/Y", strtotime($row['start_date'])), date ("H:i d/m/Y", strtotime($row['end_date'])), $row['expired_date'], $row['short_desc'], $row['email'], $row['status'], $row['name']));
			}
		
				echo json_encode($arrayEvent);
		
		}

 ?>

