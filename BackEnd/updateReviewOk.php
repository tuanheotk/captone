<?php 
header("Content-Type:application/json");
require 'database-config.php';
 
if($_SERVER["REQUEST_METHOD"] == "POST"){
       
       
    echo "string";
 if(isset($_POST["id"])){
         
         $id=$_POST["id"];
       
        $sql = "UPDATE event SET status = 3 where id=".$id;
        $result = mysqli_query($conn, $sql);
        if($result){
            $data_update["result"] = true;
         $data_update["message"] =  "Update event successfully";
         // echo header("location: index.php");
         // die();
        }else{
            $data_update["result"] = false;
         $data_update["message"] =  "Can not update event. Error: ".mysqli_error($conn);
        }
    }else{
     $data_update["result"] = false;
        $data_update["message"] = "Invalid event information";
    }
    echo json_encode($data_update);

}
header("Location: review-event.php");
 ?>