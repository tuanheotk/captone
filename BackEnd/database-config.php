<?php
// database-config.php
$servername = "localhost";
$username = "root";
$password = "";
$database = "db_event";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $database);
mysqli_set_charset($conn, 'utf8');

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
// echo "Connected successfully";
 ?>