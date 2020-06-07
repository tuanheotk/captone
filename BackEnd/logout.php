<?php
session_start();
if (isset($_SESSION['user_email'])) {
	// Logout
	unset($_SESSION["user_email"]);
	unset($_SESSION["user_code"]);
	unset($_SESSION["access_token"]);

	session_unset();
	session_destroy();

	// header("Location: https://login.microsoftonline.com/common/oauth2/logout");
	header("Location: /event");
} else {
	header("Location: /event");
	// header('Location: javascript://history.go(-1)');
}
?>