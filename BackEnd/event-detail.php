<?php

if (isset($_GET["id"])) {
	require("database-config.php");
	$sql = "SELECT title FROM event WHERE id = ".$_GET["id"];
	$result = mysqli_query($conn, $sql);
	$row = mysqli_fetch_assoc($result);
	$title = $row["title"];
}
    include "header.php";


    if (isset($account_email)) {
        if((strstr($account_email,"@") == "@vanlanguni.vn") || (strstr($account_email,"@") == "@vanlanguni.edu.vn") )
        {   
        	$mail_vlu=1;
           
        }else{
        	$mail_vlu=0;
        }
    }

        if(isset($_GET["id"])){
        	$event_id=$_GET["id"];
        	if(isset($account_email)){
        		$email=$account_email;
	            $check_reg_sql = "select id from attendee where email= '".$email."' and id=".$event_id;
	            $resultCheck = mysqli_query($conn,$check_reg_sql);
	            $count_reg=mysqli_num_rows($resultCheck);
	        }
        


			$sqlCheckStatus = "SELECT status FROM event WHERE id = ".$event_id;
			$resultCheckStatus = mysqli_query($conn, $sqlCheckStatus);
			$row = mysqli_fetch_assoc($resultCheckStatus);
			$statusEvent = $row['status'];

			if ($statusEvent != 4) {
			  header('Location: events.php');
			}
        }else{
            $event_id=0;
            header("Location: events.php");
        }
        $result=mysqli_query($conn,"select * from event where id = ".$event_id);
        

         $sql_count_ticket = "SELECT COUNT(a.event_id) AS total_attendee FROM event e, attendee a WHERE e.id = a.event_id AND e.id = ".$event_id." AND a.status!=2";
        $resultCount = mysqli_query($conn, $sql_count_ticket);
        $rowCount = mysqli_fetch_assoc($resultCount);
        $ticket_assign = $rowCount["total_attendee"];
    ?>
  <section>
        <?php while($resultevent=mysqli_fetch_assoc($result)){?>
    <div class="rows inner_banner inner_banner_4" style="background-image: url(<?php echo $resultevent['avatar'] ?>);">
      <div class="container">
                
        <h2><span><?php echo $resultevent["title"];   ?></span> </h2>
        
        <p></p>
      </div>
    </div>
  </section>
  <!--====== TOUR DETAILS - BOOKING ==========-->
  <section>
    <div class="rows banner_book" id="inner-page-title">
      <div class="container">
        <div class="banner_book_1">
          <ul>
        <li class="dl1"><?php echo $resultevent["place"] ?></li>
                        <li class="dl2">Vé còn lại: <?php echo ($resultevent["ticket_number"]-$ticket_assign)."/".$resultevent["ticket_number"] ?></li>
                        <li class="dl3">Thời gian: <?php echo date ("H:i d/m/Y", strtotime($resultevent["start_date"])) ?></li>
                        <?php 

        $sum_att_sql = "select count(id) as sum_att from attendee where event_id=".$event_id;
        $resultSumAtt = mysqli_query($conn,$sum_att_sql);
        $row_sum_att=mysqli_fetch_assoc($resultSumAtt);
        $sum_att=$row_sum_att["sum_att"];

                          if($sum_att==$resultevent["ticket_number"]){
                            echo " <li class=''><a class='cancel_button' disabled  >Hết vé</a> </li>";
                          }else if(isset($account_email)){
                  echo " <li class='dl4'><a data-toggle='modal' data-target='#exampleModal1' class='cancel_button' >Đăng kí</a> </li>";
                }else{
                  echo " <li class='dl4'><a data-toggle='modal' data-target='#modalLogin' class='cancel_button' >Đăng kí</a> </li>";
                }
                        ?>
                       
        </div>
      </div>
    </div>
  </section>
  <!--====== TOUR DETAILS ==========-->
  <section>
    <div class="rows inn-page-bg com-colo">
      <div class="container inn-page-con-bg tb-space">
        <div class="col-md-9">
          <!--====== TOUR TITLE ==========-->
          <!-- <div class="tour_head">
            <h2>The Best of Brazil & Argentina <span class="tour_star"><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star-half-o" aria-hidden="true"></i></span><span class="tour_rat">4.5</span></h2> </div> -->
          <!--====== TOUR DESCRIPTION ==========-->
          <div class="tour_head1">
            <h3>Nội dung sự kiện</h3>
            <p><?php echo $resultevent["description"]; ?></p>
            <!-- <p>Brazil’s view takes you through clouds of mist and the opportunity to see these 275 falls, spanning nearly two miles! Argentina’s side allows you to walk along the boardwalk network and embark on a jungle train through the forest for unforgettable views. Hear the deafening roar and admire the brilliant rainbows created by the clouds of spray, and take in the majesty of this wonder of the world. From vibrant cities to scenic beauty, this vacation to Rio de Janeiro, Iguassu Falls, and Buenos Aires will leave you with vacation memories you’ll cherish for life.</p> -->
          </div>
          <!--====== ROOMS: HOTEL BOOKING ==========-->
          
          <!--====== TOUR LOCATION ==========-->
          <!-- <div class="tour_head1 tout-map map-container">
            <h3>Location</h3>
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d6290415.157581651!2d-93.99661009218904!3d39.661150926343694!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x880b2d386f6e2619%3A0x7f15825064115956!2sIllinois%2C+USA!5e0!3m2!1sen!2sin!4v1467884030780" allowfullscreen></iframe>
          </div> -->
          
          <!--====== DURATION ==========-->
          
          <div>
            
          </div>
        </div>
        <div class="col-md-3 tour_r">
          <!--====== SPECIAL OFFERS ==========-->
          <!-- <div class="tour_right tour_offer">
            <div class="band1"><img src="images/offer.png" alt="" /> </div>
            <p>Special Offer</p>
            <h4>$500<span class="n-td">
                <span class="n-td-1">$800</span>
                </span>
              </h4> <a href="booking.html" class="link-btn">Book Now</a> </div> -->
          <!--====== TRIP INFORMATION ==========-->
                    

          <div class="tour_right tour_incl tour-ri-com">
            <h3>Thông tin sự kiện</h3>
            <ul>
                           <!--  <?php $start_date = date ('d/m/Y', strtotime($resultcomment['start']));  ?> -->
              <li>Địa điểm : <?php echo $resultevent["place"] ?></li>
              <li>Ngày bắt đầu: <?php echo date ("H:i d/m/Y", strtotime($resultevent["start_date"])) ?></li>
              <li>Vé còn : <?php echo ($resultevent["ticket_number"]-$ticket_assign)."/".$resultevent["ticket_number"] ?></li>
            
            </ul>
          </div>
          <!--====== PACKAGE SHARE ==========-->
          <div class="tour_right head_right tour_social tour-ri-com">
            <h3>Chia sẻ</h3>
            <ul>
              <li><a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a> </li>
              <li><a href="#"><i class="fa fa-google-plus" aria-hidden="true"></i></a> </li>
              <li><a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a> </li>
              <li><a href="#"><i class="fa fa-linkedin" aria-hidden="true"></i></a> </li>
              <li><a href="#"><i class="fa fa-whatsapp" aria-hidden="true"></i></a> </li>
            </ul>
          </div>
          <!--====== HELP PACKAGE ==========-->
          <!-- <div class="tour_right head_right tour_help tour-ri-com">
            <h3>Liên hệ hỗ trợ</h3>
            <div class="tour_help_1">
              <h4 class="tour_help_1_call">Thầy Hoà</h4>
              <h4><i class="fa fa-phone" aria-hidden="true"></i> 0933.999.000</h4> </div>
          </div> -->
          <!--====== PUPULAR TOUR PACKAGES ==========-->
          
        </div>
      </div>
    </div>
  </section>
   
  <!--====== TIPS BEFORE TRAVEL ==========-->
  
  <!--====== FOOTER 2 ==========-->
  <?php 
  include 'footer.php';
   ?>


    <!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Xác nhận</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="updateReviewOk.php" method="post">
      <div class="modal-body">
        Bạn chắc chắn <span style="color: green">duyệt</span> sự kiện này?
        <input type="hidden" name="id" value="<?php echo $resultevent['id']; ?>">
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Duyệt</button>
      </div>
  </form>
    </div>
  </div>
</div>

<div class="modal fade" id="exampleModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Xác nhận</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="event_register.php" method="post">
      <div class="modal-body">
        Bạn chắc chắn <span style="color: green">muốn đăng kí</span> tham gia sự kiện này?
        <input type="hidden" name="id" value="<?php echo $resultevent['id']; ?>">
           <input type="hidden" name="title" value="<?php echo $resultevent['title']; ?>">
              <input type="hidden" name="start_date" value="<?php echo $resultevent['start_date']; ?>">
                 <input type="hidden" name="place" value="<?php echo $resultevent['place']; ?>">
                  <input type="hidden" name="photo" value="<?php echo $resultevent['avatar']; ?>">
                  <input type="hidden" name="sum_ticket" value="<?php echo $resultevent['ticket_number']; ?>">
        <input type="hidden" name="email" value="<?php echo $account_email ?>">
        <input type="hidden" name="mail_check" value="<?php echo $mail_vlu ?>">
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-danger">Đăng ký</button>
      </div>
  </form>
    </div>
  </div>
</div>

<div class="modal fade" id="modalLogin" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Xác nhận</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="event_register.php" method="post">
      <div class="modal-body">
        Vui lòng <a href="login.php">đăng nhập</a> trước khi đăng ký tham gia sự kiện này! 
        <input type="hidden" name="id" value="<?php echo $resultevent['id']; ?>">
           <input type="hidden" name="title" value="<?php echo $resultevent['title']; ?>">
              <input type="hidden" name="start_date" value="<?php echo $resultevent['start_date']; ?>">
                 <input type="hidden" name="place" value="<?php echo $resultevent['place']; ?>">
                  <input type="hidden" name="photo" value="<?php echo $resultevent['avatar']; ?>">
        <input type="hidden" name="email" value="<?php echo $email ?>">
      </div>
      <div class="modal-footer">
       <button type="submit" class="btn btn-danger" data-dismiss="modal">Đóng</button>
      </div>
  </form>
    </div>
  </div>
</div>


 <?php } ?>
  <!--========= Scripts ===========-->
  <script src="js/jquery-latest.min.js"></script>
  <script src="js/bootstrap.js"></script>
  <script src="js/wow.min.js"></script>
  <script src="js/materialize.min.js"></script>
  <script src="js/custom.js"></script>
      <script src="js/script.js"></script>
</body>

</html>