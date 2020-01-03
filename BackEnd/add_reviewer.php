<?php 
header("Content-Type:application/json");
require 'database-config.php';

if($_SERVER["REQUEST_METHOD"] == "POST"){

	if(isset($_POST["email"]) && isset($_POST["id"])){
       
        // $product_id = $_POST["id"];
        $email = $_POST["email"];
        $id =  $_POST["id"];
        
       
        $sql1 = "INSERT INTO reviewer(event_id,account_id,email) VALUES('".$id."','0','".$email."')";

        $result = mysqli_query($conn, $sql1);
        if($result){
            $dataad["result"] = true;
        	$dataad["message"] =  "Add reviewer successfully";
            $dataad["link"] =  "s";
        	// echo header("location: index.php");
        	// die();
        }else{
            $dataad["result"] = false;
        	$dataad["message"] =  "Can not add reviewer. Error: ".mysqli_error($conn);
        }
    }else{
    	$dataad["result"] = false;
        $dataad["message"] = "Invalid reviewer information";
    }
    echo json_encode($dataad);
}
 ?>