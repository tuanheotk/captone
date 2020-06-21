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
    '51111816fa8714dbec22',
    'c61f278ab682a98e92b0',
    '966038',
    $options
);

$action = $_POST["action"];

if ($action == "get-pending-question") {

	$event_id = $_POST["event-id"];
	$sql_get_pending_question = "SELECT * FROM question WHERE status = 0 AND event_id = $event_id ORDER BY id DESC";
	$result_get_pending_question = mysqli_query($conn, $sql_get_pending_question);

	if ($result_get_pending_question) {
		if (mysqli_num_rows($result_get_pending_question) > 0) {
			while ($row_pending_question = mysqli_fetch_assoc($result_get_pending_question)) {
				$row_pending_question["create_at"] = date("H:i - d/m/Y", strtotime($row_pending_question["create_at"]));
				$json[] = $row_pending_question;
			}
			$data["result"] = true;
			$data["questions"] = $json;
		} else {
			$data["result"] = false;
		}
	} else {
		$data["result"] = false;
	}

	// Pusher
	$pusher->trigger('manage-ask-'.$event_id, 'pending-question', $data);

} else if ($action == "get-published-question") {
	$event_id = $_POST["event-id"];
	$sql_get_published_question = "SELECT T1.*, T1.num_like, T2.num_reply
                                    FROM
                                    (SELECT q.*, COUNT(r.user_id) AS num_like FROM question q LEFT JOIN reaction r ON q.id = r.question_id WHERE q.status = 1 AND q.event_id = $event_id GROUP BY q.id ORDER BY q.pinned DESC, q.id DESC) T1
                                    JOIN
                                    ( SELECT q.*, COUNT(a.user_id) AS num_reply FROM question q LEFT JOIN answer a ON q.id = a.question_id GROUP BY q.id) T2
                                    ON T1.id = T2.id";
	$result_get_published_question = mysqli_query($conn, $sql_get_published_question);

	if ($result_get_published_question) {
		if (mysqli_num_rows($result_get_published_question) > 0) {
			while ($row_published_question = mysqli_fetch_assoc($result_get_published_question)) {
				$row_published_question["create_at"] = date("H:i - d/m/Y", strtotime($row_published_question["create_at"]));
				$question_id = $row_published_question["id"];
				$json[] = $row_published_question;

				$sql_get_user_liked = "SELECT question_id ,user_id FROM reaction WHERE event_id = $event_id AND question_id = $question_id";
				$result_user_liked = mysqli_query($conn, $sql_get_user_liked);

				if (mysqli_num_rows($result_user_liked) > 0) {
					while ($row_user_like = mysqli_fetch_assoc($result_user_liked)) {
						$json_liked[] = $row_user_like;
					}
					$data["liked"] = $json_liked;
				} else {
					$data['liked'] = [];
				}
			}
			$data["result"] = true;
			$data["questions"] = $json;
		} else {
			$data["result"] = false;
		}
	} else {
		$data["result"] = false;
	}

	// Pusher
	$pusher->trigger('ask-page-'.$event_id, 'published-question', $data);

} else if ($action == "get-published-question-bak") {
	$event_id = $_POST["event-id"];
	$sql_get_published_question = "SELECT q.*, COUNT(r.user_id) AS num_like FROM question q LEFT JOIN reaction r ON q.id = r.question_id WHERE q.status = 1 AND q.event_id = $event_id GROUP BY q.id ORDER BY q.pinned DESC, q.id DESC";
	$result_get_published_question = mysqli_query($conn, $sql_get_published_question);

	if ($result_get_published_question) {
		if (mysqli_num_rows($result_get_published_question) > 0) {
			while ($row_published_question = mysqli_fetch_assoc($result_get_published_question)) {
				$row_published_question["create_at"] = date("H:i - d/m/Y", strtotime($row_published_question["create_at"]));
				$json[] = $row_published_question;
			}
			$data["result"] = true;
			$data["questions"] = $json;
		} else {
			$data["result"] = false;
		}
	} else {
		$data["result"] = false;
	}

	// Pusher
	$pusher->trigger('ask-page-'.$event_id, 'published-question', $data);

} else if ($action == "user-send-question") {
	$event_id = $_POST["event-id"];
	$user_id = $_POST["user-id"];
	$user_fullname = $_POST["user-fullname"];
	$content = mysqli_real_escape_string($conn, $_POST["content"]);

	$sql_get_status_event = "SELECT check_question, user_make_question FROM event WHERE id = $event_id";
	$result_status_event = mysqli_query($conn, $sql_get_status_event);
	$row_status_event = mysqli_fetch_assoc($result_status_event);

	$check_question = $row_status_event["check_question"];
	$user_make_question = $row_status_event["user_make_question"];

	$now = date('Y-m-d H:i:s');

	$sql_get_id_host_mod = "SELECT a.id FROM event e, account a WHERE e.account_id = a.id AND e.id = $event_id UNION SELECT a.id FROM account a, moderator m WHERE m.event_id = $event_id AND m.email = a.email";
	$result_id_host_mod = mysqli_query($conn, $sql_get_id_host_mod);
	$array_id_host_mod = array();

	while ($row_id_host_mod = mysqli_fetch_assoc($result_id_host_mod)) {
		array_push($array_id_host_mod, $row_id_host_mod['id']);
	}

	$is_host_mod = (in_array($user_id, $array_id_host_mod)) ? true : false ;

	if ($is_host_mod) {
		$sql_insert_question = "INSERT INTO question (event_id, user_id, user_fullname, content, status, create_at) VALUES ($event_id, '$user_id', '$user_fullname', '$content', 1, '$now')";
		$result_insert_question = mysqli_query($conn, $sql_insert_question);
		if ($result_insert_question) {
			$data["result"] = true;
		} else {
			$data["result"] = false;
			$data["message"] = "Có lỗi xảy ra. Vui lòng thử lại!";
		}
	} else {
		if ($user_make_question == 0) {
			// user can't make question
			$data["result"] = false;
			$data["message"] = "Quản trị viên đã tắt chức năng đặt câu hỏi";
		} else {
			// insert question
			// Status check question
			$status = ($check_question == 0) ? 1 : 0;

			$sql_insert_question = "INSERT INTO question (event_id, user_id, user_fullname, content, status, create_at) VALUES ($event_id, '$user_id', '$user_fullname', '$content', $status, '$now')";
			$result_insert_question = mysqli_query($conn, $sql_insert_question);
			// $result_insert_question = true;

			if ($result_insert_question) {
				$data["result"] = true;
				if ($status == 0) {
					$data["pending"] = true;
					$data["message"] = "Câu hỏi của bạn đang chờ duyệt";
				}
			} else {
				$data["result"] = false;
				$data["message"] = "Có lỗi xảy ra. Vui lòng thử lại!";
			}
		}
	}
} else if ($action == "mod-edit-question") {
	$question_id = $_POST["question-id"];
	$question_content = $_POST["question-content"];

	$sql_update_question = "UPDATE question SET content = '".$question_content."' WHERE id = $question_id";
	$result_update_question = mysqli_query($conn, $sql_update_question);

	if ($result_update_question) {
		$data["result"] = true;
	} else {
		$data["result"] = false;
	}
	
} else if ($action == "mod-accept-question") {
	$question_id = $_POST["question-id"];
	$sql_update_status = "UPDATE question SET status = 1 WHERE id = $question_id";
	$result_update_status = mysqli_query($conn, $sql_update_status);
	if ($result_update_status) {
		$data["result"] = true;
	} else {
		$data["result"] = false;
	}

} else if ($action == "mod-deny-question") {
	$question_id = $_POST["question-id"];
	$sql_delete_question = "DELETE FROM question WHERE id = $question_id";
	$result_delete_question = mysqli_query($conn, $sql_delete_question);
	if ($result_delete_question) {
		$data["result"] = true;
	} else {
		$data["result"] = false;
	}
} else if ($action == 'change-check-question') {
	$event_id = $_POST["event-id"];
	$check_status = $_POST["check-question-status"];

	if ($check_status == 0) {
		$data["message"] = "Đã tắt chế độ duyệt câu hỏi";
	} else {
		$data["message"] = "Đã bật chế độ duyệt câu hỏi";
	}
	
	$sql_update_check = "UPDATE event SET check_question = $check_status WHERE id = $event_id";
	$result_update_check = mysqli_query($conn, $sql_update_check);

	if ($result_update_check) {
		$data["result"] = true;
	} else {
		$data["result"] = false;
	}
	
	// Push status check question
	$pusher->trigger('manage-ask-'.$event_id, 'check-question-status', $check_status);

} else if ($action == 'change-user-make-question') {
	$event_id = $_POST["event-id"];
	$user_make_quesion_status = $_POST["user-make-question-status"];

	if ($user_make_quesion_status == 0) {
		$data["message"] = "Đã tắt người tham dự đặt câu hỏi";
	} else {
		$data["message"] = "Đã bật người tham dự đặt câu hỏi";
	}
	
	$sql_update_user_make_question = "UPDATE event SET user_make_question = $user_make_quesion_status WHERE id = $event_id";
	$result_update_user_make_question = mysqli_query($conn, $sql_update_user_make_question);

	if ($result_update_user_make_question) {
		$data["result"] = true;
	} else {
		$data["result"] = false;
	}
	
	// Push status user make question
	$pusher->trigger('manage-ask-'.$event_id, 'user-make-question-status', $user_make_quesion_status);

} else if ($action == 'change-user-reply-question') {
	$event_id = $_POST["event-id"];
	$user_reply_quesion_status = $_POST["user-reply-question-status"];

	if ($user_reply_quesion_status == 0) {
		$data["message"] = "Đã tắt người tham dự trả lời câu hỏi";
	} else {
		$data["message"] = "Đã bật người tham dự trả lời câu hỏi";
	}
	
	$sql_update_user_reply_question = "UPDATE event SET user_reply_question = $user_reply_quesion_status WHERE id = $event_id";
	$result_update_user_reply_question = mysqli_query($conn, $sql_update_user_reply_question);

	if ($result_update_user_reply_question) {
		$data["result"] = true;
	} else {
		$data["result"] = false;
	}
	
	// Push status user reply question
	$pusher->trigger('manage-ask-'.$event_id, 'user-reply-question-status', $user_reply_quesion_status);

} else if ($action == 'mod-pin-question') {
	$question_id = $_POST["question-id"];
	$pin_status = $_POST["new-pin-status"];

	if ($pin_status == 0) {
		$data["message"] = "Đã bỏ ghim câu hỏi";
	} else {
		$data["message"] = "Đã ghim câu hỏi";
	}
	
	$sql_update_pin_question_status = "UPDATE question SET pinned = $pin_status WHERE id = $question_id";
	$result_update_pin_question_status = mysqli_query($conn, $sql_update_pin_question_status);

	if ($result_update_pin_question_status) {
		$data["result"] = true;
	} else {
		$data["result"] = false;
	}

} else if ($action == 'like-question') {
	$event_id = $_POST["event-id"];
	$user_id = $_POST["user-id"];
	$question_id = $_POST["question-id"];

	$sql_check_liked = "SELECT user_id FROM reaction WHERE event_id = $event_id AND user_id = '$user_id' AND question_id = $question_id";
	$result_check_liked = mysqli_query($conn, $sql_check_liked);

	if (mysqli_num_rows($result_check_liked) == 0) {
		$sql_like = "INSERT INTO reaction (event_id, user_id, question_id) VALUES ($event_id, '$user_id', $question_id)";
		$result_like = mysqli_query($conn, $sql_like);
		if ($result_like) {
			$data["result"] = true;
		} else {
			$data["result"] = false;
		}
		
	} else {
		$data["result"] = false;
	}

} else if ($action == 'unlike-question') {
	$event_id = $_POST["event-id"];
	$user_id = $_POST["user-id"];
	$question_id = $_POST["question-id"];

	$sql_unlike = "DELETE FROM reaction WHERE event_id = $event_id AND user_id = '$user_id' AND question_id = $question_id";
	$result_unlike = mysqli_query($conn, $sql_unlike);
	if ($result_unlike) {
		$data["result"] = true;
	} else {
		$data["result"] = false;
	}

} else if ($action == 'get-answer') {
	$event_id = $_POST["event-id"];
	$question_id = $_POST["question-id"];

	$sql_get_answer = "SELECT * FROM answer WHERE event_id = $event_id AND question_id = $question_id";
	$result_get_answer = mysqli_query($conn, $sql_get_answer);

	if ($result_get_answer) {
		if (mysqli_num_rows($result_get_answer) > 0) {
			while ($row_answer = mysqli_fetch_assoc($result_get_answer)) {
				$row_answer["create_at"] = date("H:i - d/m/Y", strtotime($row_answer["create_at"]));
				$json[] = $row_answer;
			}
			$data["result"] = true;
			$data["answer"] = $json;
		} else {
			$data["result"] = false;
		}
	} else {
		$data["result"] = false;
	}
	
	// Pusher
	$pusher->trigger('question-event'.$event_id, 'list-answer'.$question_id, $data);

} else if ($action == 'user-reply-question') {
	$event_id = $_POST["event-id"];
	$question_id = $_POST["question-id"];
	$user_id = $_POST["user-id"];
	$user_fullname = $_POST["user-fullname"];
	$content = mysqli_real_escape_string($conn, $_POST["content"]);

	$sql_get_status_reply = "SELECT user_reply_question FROM event WHERE id = $event_id";
	$result_status_reply = mysqli_query($conn, $sql_get_status_reply);

	$row_status_reply = mysqli_fetch_assoc($result_status_reply);
	$user_reply_question = $row_status_reply["user_reply_question"];

	$now = date('Y-m-d H:i:s');

	$sql_get_id_host_mod = "SELECT a.id FROM event e, account a WHERE e.account_id = a.id AND e.id = $event_id UNION SELECT a.id FROM account a, moderator m WHERE m.event_id = $event_id AND m.email = a.email";
	$result_id_host_mod = mysqli_query($conn, $sql_get_id_host_mod);
	$array_id_host_mod = array();

	while ($row_id_host_mod = mysqli_fetch_assoc($result_id_host_mod)) {
		array_push($array_id_host_mod, $row_id_host_mod['id']);
	}

	$is_host_mod = (in_array($user_id, $array_id_host_mod)) ? true : false ;

	$sql_insert_answer = "INSERT INTO answer (event_id, question_id, user_id, user_fullname, content, create_at) VALUES($event_id, $question_id, '$user_id', '$user_fullname', '$content', '$now')";

	if ($user_reply_question == 0) {
		if ($is_host_mod) {
			$result_insert_answer = mysqli_query($conn, $sql_insert_answer);
			if ($result_insert_answer) {
				$data["result"] = true;
			} else {
				$data["result"] = false;
				$data["message"] = "Có lỗi xảy ra. Vui lòng thử lại!";
			}
		} else {
			$data["result"] = false;
			$data["message"] = "Quản trị viên đã tắt chức năng trả lời câu hỏi";
		}
	} else {
		$result_insert_answer = mysqli_query($conn, $sql_insert_answer);
		if ($result_insert_answer) {
			$data["result"] = true;
		} else {
			$data["result"] = false;
			$data["message"] = "Có lỗi xảy ra. Vui lòng thử lại!";
		}	
	}
} else if ($action == "join-room") {
	$event_code = $_POST["event-code"];
	$sql_search_event = "SELECT id FROM event WHERE status = 4 AND code = '$event_code'";
	$result_search_event = mysqli_query($conn, $sql_search_event);


	if (mysqli_num_rows($result_search_event) > 0) {
		$row_event = mysqli_fetch_assoc($result_search_event);
		$code = $row_event["id"];
		$data["result"] = true;
		$data["message"] = $code;
	} else {
		$data["result"] = false;
		$data["message"] = 'Mã sự kiện không tồn tại';
	}
	

}
mysqli_close($conn);
echo json_encode($data);
?>