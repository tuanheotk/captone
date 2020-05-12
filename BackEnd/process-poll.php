<?php
session_start();
header("Content-Type:application/json");
require "database-config.php";
require('vendor/Pusher/Pusher.php');

$options = array(
    'cluster' => 'ap1',
    'useTLS' => true
    // 'encrypted' => true
);


$pusher = new Pusher(
    '71289e96793d3248d6ec',
    '4fce292aa413d07b719d',
    '980748',
    $options
);

$action = $_POST['action'];

if ($action == 'get-all-poll') {

	$event_id = $_POST['event-id'];
	$sql_get_all_poll = "SELECT p.*, COUNT(DISTINCT(user_id)) AS votes FROM poll p
	LEFT JOIN poll_option po ON p.id = po.poll_id
	LEFT JOIN poll_vote pv ON po.id = pv.option_id
	WHERE event_id = $event_id
	GROUP BY p.id ORDER BY p.id DESC";
	$result_get_all_poll = mysqli_query($conn, $sql_get_all_poll);

	if ($result_get_all_poll) {
		if (mysqli_num_rows($result_get_all_poll) > 0) {
			while ($row_poll = mysqli_fetch_assoc($result_get_all_poll)) {
				$json[] = $row_poll;
			}
			$data['result'] = true;
			$data['poll'] = $json;
		} else {
			$data['result'] = false;
		}
	} else {
		$data['result'] = false;
	}

	// Pusher
	$pusher->trigger('manage-poll-'.$event_id, 'all-poll', $data);

} else if ($action == 'add') {
	$event_id = $_POST['event-id'];
	$poll_title = mysqli_real_escape_string($conn, $_POST['poll-title']);
	$max_choice = $_POST['max-choice'];
	$list_option = $_POST['list-option'];

	$sql_insert_poll = "INSERT INTO poll (event_id, title, max_choice, status) VALUES ($event_id, '$poll_title', $max_choice, 1)";	

	$result_insert_poll = mysqli_query($conn, $sql_insert_poll);

	if ($result_insert_poll) {
		// Get max poll id
		$get_max_id = mysqli_query($conn, "SELECT MAX(id) from poll");
		if (mysqli_num_rows($get_max_id) == 0) {
			$poll_id = 1;
		} else {
			$row = mysqli_fetch_assoc($get_max_id);
			$poll_id = $row["MAX(id)"];
		}

		// Insert poll option
		foreach ($list_option as $option) {

			$option_content = mysqli_escape_string($conn, $option['content']);

			$sql_insert_poll_option = "INSERT INTO poll_option (poll_id, content) VALUES ($poll_id, '$option_content')";
			$result_insert_poll_option = mysqli_query($conn, $sql_insert_poll_option);

			if ($result_insert_poll_option) {
				$data["result"] = true;
			} else {
				$data['result'] = false;
			}
		}
	} else {
		$data['result'] = false;
	}

} else if ($action == 'edit') {
	$event_id = $_POST['event-id'];
	$poll_id = $_POST['poll-id'];
	$poll_title = mysqli_real_escape_string($conn, $_POST['poll-title']);
	$max_choice = $_POST['max-choice'];
	$list_option = $_POST['list-option'];

	$sql_update_poll_info = "UPDATE poll SET title = '$poll_title', max_choice = $max_choice WHERE id = $poll_id";
	$result_update_poll_info = mysqli_query($conn, $sql_update_poll_info);

	$sql_get_list_option= "SELECT id, content FROM poll_option WHERE poll_id = ".$poll_id;
	$result_list_option = mysqli_query($conn, $sql_get_list_option);
	while ($row_list_option = mysqli_fetch_assoc($result_list_option)) {
		$list_option_db[] = $row_list_option;
	}


	$list_id_option_db = array();
	foreach ($list_option_db as $option) {
		array_push($list_id_option_db, $option['id']);
	}

	$list_id_option_new = array();
	foreach ($list_option as $option) {
		array_push($list_id_option_new, $option['id']);
	}

	$list_id_kept = array_intersect($list_id_option_new,$list_id_option_db);
	$list_id_added = array_values(array_diff($list_id_option_new,$list_id_option_db));
	$list_id_deleted = array_values(array_diff($list_id_option_db,$list_id_option_new));

	foreach ($list_option as $option) {
		$option_id = $option['id'];
		$option_content = $option['content'];

		// Update kept id
		for ($i=0; $i < count($list_id_kept); $i++) {
			if ($option_id == $list_id_kept[$i]) {
				$sql_update_option_content = "UPDATE poll_option SET content = '$option_content' WHERE id = $option_id";
				$result_update_option_content = mysqli_query($conn, $sql_update_option_content);
				break;
			}
		}

		// Add new option
		for ($i=0; $i < count($list_id_added); $i++) {
			if ($option_id == $list_id_added[$i]) {
				$sql_insert_new_option = "INSERT INTO poll_option (poll_id, content) VALUES ($poll_id, '$option_content')";
				$result_insert_new_option = mysqli_query($conn, $sql_insert_new_option);
				break;
			}
		}
		// Delete option
		for ($i=0; $i < count($list_id_deleted); $i++) {
			if ($option_id == $list_id_deleted[$i]) {
				$sql_delete_option = "DELETE FROM poll_option WHERE id = $option_id";
				$result_delete_option = mysqli_query($conn, $sql_delete_option);

				$sql_delete_option_vote = "DELETE FROM poll_vote WHERE option_id = $option_id";
				$result_delete_option_vote = mysqli_query($conn, $sql_delete_option_vote);
				break;
			}
		}

	}

	foreach ($list_option_db as $option) {
		$option_id = $option['id'];
		$option_content = $option['content'];

		// Delete option
		for ($i=0; $i < count($list_id_deleted); $i++) {
			if ($option_id == $list_id_deleted[$i]) {
				$sql_delete_option = "DELETE FROM poll_option WHERE id = $option_id";
				$result_delete_option = mysqli_query($conn, $sql_delete_option);

				$sql_delete_option_vote = "DELETE FROM poll_vote WHERE option_id = $option_id";
				$result_delete_option_vote = mysqli_query($conn, $sql_delete_option_vote);
				break;
			}
		}

	}

	// $data['list_option_new'] = $list_option;
	// $data['list_option_db'] = $list_option_db;

	// $data['list_id_kept'] = $list_id_kept;
	// $data['list_id_added'] = $list_id_added;
	// $data['list_id_deleted'] = $list_id_deleted;

	// $data['kept'] = count($list_id_kept);
	// $data['added'] = count($list_id_added);
	// $data['deleted'] = count($list_id_deleted);

	$data['result'] = true;


} else if ($action == 'delete') {
	$poll_id = $_POST['poll-id'];

	$sql_delete_poll = "DELETE p, po, pv FROM poll p
	LEFT JOIN poll_option po
	ON p.id = po.poll_id
	LEFT JOIN poll_vote pv
	ON po.id = pv.option_id
	WHERE p.id = $poll_id";

	$result_delete_poll = mysqli_query($conn, $sql_delete_poll);

	if ($result_delete_poll) {
		$data['result'] = true;
	} else {
		$data['result'] = false;
	}


} else if ($action == 'hide') {
	$poll_id = $_POST['poll-id'];

	$sql_hide_poll = "UPDATE poll SET status = 0 WHERE id = $poll_id";

	$result_hide_poll = mysqli_query($conn, $sql_hide_poll);

	if ($result_hide_poll) {
		$data['result'] = true;
	} else {
		$data['result'] = false;
	}

} else if ($action == 'show') {
	$poll_id = $_POST['poll-id'];

	$sql_show_poll = "UPDATE poll SET status = 1 WHERE id = $poll_id";

	$result_show_poll = mysqli_query($conn, $sql_show_poll);

	if ($result_show_poll) {
		$data['result'] = true;
	} else {
		$data['result'] = false;
	}

} else if ($action == 'show-result-poll') {
	$poll_id = $_POST['poll-id'];

	$sql_get_poll_title = "SELECT title FROM poll WHERE id = $poll_id";
	$result_get_poll_title = mysqli_query($conn, $sql_get_poll_title);

	$sql_get_list_option = "SELECT po.id, po.content, COUNT(pv.option_id) AS num_vote FROM poll_option po LEFT JOIN poll_vote pv ON pv.option_id = po.id WHERE po.poll_id = $poll_id GROUP BY po.id";
	$result_list_option = mysqli_query($conn, $sql_get_list_option);


	if (mysqli_num_rows($result_get_poll_title) > 0) {
		// Get title
		$row_poll_title = mysqli_fetch_assoc($result_get_poll_title);
		$data['poll_title'] = $row_poll_title['title'];

		// Get list option
		if ($result_list_option) {
			while ($row_list_option = mysqli_fetch_assoc($result_list_option)) {
				$json[] = $row_list_option;
			}
			$data['result'] = true;
			$data['list_option'] = $json;
			
		} else {
			$data['result'] = false;
		}
	} else {
		$data['result'] = false;
	}

	// Pusher
	// $pusher->trigger('result-poll', 'poll-'.$poll_id, $data);
} else if ($action == 'refresh-result-poll') {
	$poll_id = $_POST['poll-id'];

	$data = $poll_id;

	// Pusher
	$pusher->trigger('refresh-result-poll', 'poll-'.$poll_id, $data);
} else if ($action == 'get-list-option') {
	$poll_id = $_POST["poll-id"];

	$sql_get_list_option = "SELECT id, content FROM poll_option WHERE poll_id = $poll_id";
	$result_list_option = mysqli_query($conn, $sql_get_list_option);

	if ($result_list_option) {
		while ($row_list_option = mysqli_fetch_assoc($result_list_option)) {
			$json[] = $row_list_option;
		}
		$data['result'] = true;
		$data['list_option'] = $json;
	} else {
		$data['result'] = false;
	}
} else if ($action == 'get-published-poll') {
	$event_id = $_POST['event-id'];
	$user_id = $_POST['user-id'];
	$sql_get_published_poll = "SELECT p.*, COUNT(DISTINCT(user_id)) AS votes, COUNT(pv.option_id) AS total_vote FROM poll p
	LEFT JOIN poll_option po ON p.id = po.poll_id
	LEFT JOIN poll_vote pv ON po.id = pv.option_id
	WHERE event_id = $event_id AND p.status = 1
	GROUP BY p.id ORDER BY p.id DESC";
	$result_get_published_poll = mysqli_query($conn, $sql_get_published_poll);



	// $sql_get_list_voted = "SELECT p.id AS poll_id, pv.option_id FROM poll p, poll_option po, poll_vote pv WHERE p.id = po.poll_id AND po.id = pv.option_id AND p.status = 1 AND p.event_id = $event_id AND pv.user_id = '$user_id' ORDER BY p.id DESC";

	// $sql_check_voted = "SELECT COUNT(DISTINCT(pv.user_id)) as voted FROM poll p, poll_option po, poll_vote pv WHERE p.id = po.poll_id AND po.id = pv.option_id AND p.id = $poll_id AND pv.user_id = '$user_id'";
	


	if ($result_get_published_poll) {
		if (mysqli_num_rows($result_get_published_poll) > 0) {
			while ($row_poll = mysqli_fetch_assoc($result_get_published_poll)) {
				$list_poll[] = $row_poll;

				$poll_id = $row_poll['id'];


				// Get list poll user voted
				$sql_get_poll_voted = "SELECT COUNT(DISTINCT(pv.user_id)) as voted FROM poll p, poll_option po, poll_vote pv WHERE p.id = po.poll_id AND po.id = pv.option_id AND p.id = $poll_id AND pv.user_id = '$user_id'";

				$result_poll_voted = mysqli_query($conn, $sql_get_poll_voted);
				if ($result_poll_voted) {
					$row_poll_voted = mysqli_fetch_assoc($result_poll_voted);
					$voted = ($row_poll_voted['voted'] == 1) ? true : false ;
					
					$list_poll_voted[] = $voted;
				}

				// Get total_vote for each poll
				// $sql_get_total_vote = "SELECT COUNT(pv.option_id) as total_vote FROM poll p, poll_option po, poll_vote pv WHERE p.id = po.poll_id AND po.id = pv.option_id AND p.id = $poll_id";
				// $result_total_vote = mysqli_query($conn, $sql_get_total_vote);
				// if ($result_total_vote) {
				// 	$row_total_vote = mysqli_fetch_assoc($result_total_vote);
				// 	$total_vote = $row_total_vote['total_vote'];

				// 	$list_total_vote[] = $total_vote;
				// }


			}
			// Add key voted & total_vote for list poll
			for ($i=0; $i < count($list_poll); $i++) {
				$list_poll[$i]['voted'] = $list_poll_voted[$i];
				// $list_poll[$i]['total_vote'] = $list_total_vote[$i];
			}


			$data['result'] = true;
			$data['poll'] = $list_poll;





			// Get list option
			foreach ($list_poll as $poll) {
				$poll_id = $poll['id'];
				$sql_get_list_option = "SELECT po.*, COUNT(pv.option_id) AS total_vote FROM poll_option po LEFT JOIN poll_vote pv ON po.id = pv.option_id WHERE po.poll_id = $poll_id GROUP BY po.id";
				$result_get_list_option = mysqli_query($conn, $sql_get_list_option);

				while ($row_list_option = mysqli_fetch_assoc($result_get_list_option)) {
					$list_option[] = $row_list_option;

					$option_id = $row_list_option['id'];
					
					// Get list option user voted
					$sql_get_option_voted = "SELECT COUNT(user_id) AS voted FROM poll_vote WHERE user_id = '$user_id' AND option_id = $option_id";
					$result_option_voted = mysqli_query($conn, $sql_get_option_voted);
					if ($result_option_voted) {
						$row_option_voted = mysqli_fetch_assoc($result_option_voted);
						$voted = ($row_option_voted['voted'] == 1) ? true : false ;
						
						$list_option_voted[] = $voted;
					}

					// Get total_vote for each option


				}

				// Add key voted for list option
				for ($i=0; $i < count($list_option); $i++) {
					$list_option[$i]['voted'] = $list_option_voted[$i];
				}

				$data['list_option'] = $list_option;
			}


			// Get list user voted
			// $result_get_list_voted = mysqli_query($conn, $sql_get_list_voted);
			// while ($row_list_voted = mysqli_fetch_assoc($result_get_list_voted)) {
			// 	$list_voted[] = $row_list_voted;
			// }

			// $data['list_voted'] = $list_voted;

		} else {
			$data['result'] = false;
		}
	} else {
		$data['result'] = false;
	}

	// Pusher
	$pusher->trigger('vote-page-'.$event_id, 'published-poll', $data);
} else if ($action == 'refresh-published-poll') {
	$data = $_POST['event-id'];

	// Pusher
	$pusher->trigger('vote-page-'.$data, 'refresh-published-poll', $data);
} else if ($action == 'vote-poll') {
	$user_id = $_POST['user-id'];
	$poll_id = $_POST['poll-id'];
	$list_option = $_POST['list-option'];

	$sql_get_max_choice = "SELECT max_choice FROM poll WHERE id = $poll_id";
	$result_max_choice = mysqli_query($conn, $sql_get_max_choice);
	$row_max_choice = mysqli_fetch_assoc($result_max_choice);
	$max_choice = $row_max_choice['max_choice'];

	if ($max_choice >= count($list_option)) {
		// Delele old vote option
		$sql_delete_old_vote = "DELETE pv FROM poll_vote pv LEFT JOIN poll_option po ON pv.option_id = po.id WHERE pv.user_id = '$user_id' AND po.poll_id = $poll_id";
		$result_delete_old_vote = mysqli_query($conn, $sql_delete_old_vote);



		// for ($i=0; $i < $max_choice; $i++) {
		// 	$option_id = $list_option[$i];
		// 	$sql_insert_vote = "INSERT INTO poll_vote VALUES ('$user_id', $option_id)";
		// 	$result_insert_vote = mysqli_query($conn, $sql_insert_vote);
		// }
		
		// Insert new vote option
		foreach ($list_option as $option_id) {
			$sql_insert_vote = "INSERT INTO poll_vote VALUES ('$user_id', $option_id)";
			$result_insert_vote = mysqli_query($conn, $sql_insert_vote);
		}

		if ($result_delete_old_vote && $result_insert_vote) {
			$data['result'] = true;
		} else {
			$data['result'] = false;
		}
	} else {
		$data['result'] = false;
	}
}
mysqli_close($conn);
echo json_encode($data);
?>