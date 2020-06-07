<?php
if (isset($_GET["code"])) {
	require("database-config.php");
	$sql = "UPDATE account SET verified = 1 WHERE verify_code = '".$_GET["code"]."'";
	$result = mysqli_query($conn, $sql);
	if (mysqli_num_rows($result) > 0) {
		header("Location: activated.php");
	} else {
		header("Location: /event/");
	}
	
} else {
	header("Location: /event/");
}
?>