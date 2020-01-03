<?php
if (isset($_GET["code"])) {
	require("database-config.php");
	$sql = "UPDATE account SET verified = 1 WHERE verify_code = '".$_GET["code"]."'";
	$result = mysqli_query($conn, $sql);
	header("Location: activated.php");
} else {
	header("Location: index.php");
}
?>