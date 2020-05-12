<?php
require('database-config.php');
$sql_get_code = "SELECT code FROM event";
$result_get_code = mysqli_query($conn, $sql_get_code);


$code_array = array();

if (mysqli_num_rows($result_get_code) == 0) {
	$code = generate_code();
} else {
	while ($row_code = mysqli_fetch_assoc($result_get_code)) {
		array_push($code_array, $row_code['code']);
	}

	do {
		$code = generate_code();
		if (in_array($code, $code_array)) {
			$duplicate = true;
		} else {
			$duplicate = false;
		}
		
	} while ($duplicate == true);
}

echo 'code: '.$code;

function generate_code()
{
	$arr = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L',
				'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X',
				'Y', 'Z', '0', '1', '2', '3', '4', '5', '6', '7', '8', '9');
	$c1 = $arr[rand(0,35)];
	$c2 = $arr[rand(0,35)];
	$c3 = $arr[rand(0,35)];
	$c4 = $arr[rand(0,35)];

	$rand_code = $c1.''.$c2.''.$c3.''.$c4;
	return $rand_code;
}
?>