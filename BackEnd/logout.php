<?php
session_start();
// Logout
unset($_SESSION["user_email"]);
unset($_SESSION["user_code"]);
unset($_SESSION["access_token"]);

session_unset();
session_destroy();

// header("Location: https://login.microsoftonline.com/common/oauth2/logout");
header("Location: index.php");
?>