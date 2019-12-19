<?php 
header("Content-Type:application/json");
require 'database-config.php';
 
if($_SERVER["REQUEST_METHOD"] == "POST"){
       
       
    echo "string";
 if(isset($_POST["id"])){
        echo "co";
         
        $id=$_POST["id"];
        $comment = $_POST["comment"];
        $sql = "UPDATE event SET status = 2 where id=".$id;
        $sqlAddComment = "INSERT INTO review_comment(event_id, account_id, comment, day_comment) VALUES(".$id.",1,'".$comment."', NOW())";
        $resultComment = mysqli_query($conn, $sqlAddComment);

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