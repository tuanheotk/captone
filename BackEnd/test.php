<?php  
 require 'database-config.php';
    $sum_att_sql = "select count(id) as sum_att from attendee where event_id=27";
        $resultSumAtt = mysqli_query($conn,$sum_att_sql);
        $row_sum_att=mysqli_fetch_assoc($resultSumAtt);
        $sum_att=$row_sum_att["sum_att"];
        echo $sum_att;
         if($sum_att==1){ //Sold Out
            header("Location:soldout.php");}
?>