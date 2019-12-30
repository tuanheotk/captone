<?php
session_start();
// Logout
unset($_SESSION["user_email"]);
unset($_SESSION["user_code"]);
unset($_SESSION["access_token"]);

header("Location: index.php");
?>