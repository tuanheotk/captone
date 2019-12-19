<?php 
    require "header.php";
 ?>
		
	<!--====== BANNER ==========-->

    <?php 
        require 'database-config.php';
    
        if(isset($_GET["id"])){
        $event_id=$_GET["id"];
        }else{
            $mahd=0;
        }
        $result=mysqli_query($conn,"select * from event where id = ".$event_id);

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
						<li class="dl1"><a data-toggle="modal" data-target="#CommentModal" class="cancel_button" >Lịch sử duyệt</a></li>
                        <li class="" ><a class="addmod_button" data-toggle="modal" data-target="#reviewerModal">Thêm Reviewer</a></li>
                        <li class="dl3"><a class="accept_button" data-toggle="modal" data-target="#exampleModal">Duyệt</a></li>
                        <li class="dl4"><a data-toggle="modal" data-target="#exampleModal1" class="cancel_button" >Từ chối</a> </li>
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
							<li>Số lượng vé: <?php echo $resultevent["ticket_number"] ?></li>
						
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
					<div class="tour_right head_right tour_help tour-ri-com">
						<h3>Liên hệ hỗ trợ</h3>
						<div class="tour_help_1">
							<h4 class="tour_help_1_call">Thầy Hoà</h4>
							<h4><i class="fa fa-phone" aria-hidden="true"></i> 0933.999.000</h4> </div>
					</div>
					<!--====== PUPULAR TOUR PACKAGES ==========-->
					
				</div>
			</div>
		</div>
	</section>
   
	<!--====== TIPS BEFORE TRAVEL ==========-->
	
	<!--====== FOOTER 2 ==========-->
	<section>
		<div class="rows">
			<div class="footer">
				<div class="container">
					<div class="foot-sec2">
						<div>
							<div class="row">
								<div class="col-sm-3 foot-spec foot-com">
									<h4><span>Holiday</span> Tour & Travels</h4>
									<p>World's leading tour and travels Booking website,Over 30,000 packages worldwide.</p>
								</div>
								<div class="col-sm-3 foot-spec foot-com">
									<h4><span>Address</span> & Contact Info</h4>
									<p>28800 Orchard Lake Road, Suite 180 Farmington Hills, U.S.A. Landmark : Next To Airport</p>
									<p> <span class="strong">Phone: </span> <span class="highlighted">+101-1231-1231</span> </p>
								</div>
								<div class="col-sm-3 col-md-3 foot-spec foot-com">
									<h4><span>SUPPORT</span> & HELP</h4>
									<ul class="two-columns">
										<li> <a href="#">About Us</a> </li>
										<li> <a href="#">FAQ</a> </li>
										<li> <a href="#">Feedbacks</a> </li>
										<li> <a href="#">Blog </a> </li>
										<li> <a href="#">Use Cases</a> </li>
										<li> <a href="#">Advertise us</a> </li>
										<li> <a href="#">Discount</a> </li>
										<li> <a href="#">Vacations</a> </li>
										<li> <a href="#">Branding Offers </a> </li>
										<li> <a href="#">Contact Us</a> </li>
									</ul>
								</div>
								<div class="col-sm-3 foot-social foot-spec foot-com">
									<h4><span>Follow</span> with us</h4>
									<p>Join the thousands of other There are many variations of passages of Lorem Ipsum available</p>
									<ul>
										<li><a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a> </li>
										<li><a href="#"><i class="fa fa-google-plus" aria-hidden="true"></i></a> </li>
										<li><a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a> </li>
										<li><a href="#"><i class="fa fa-linkedin" aria-hidden="true"></i></a> </li>
										<li><a href="#"><i class="fa fa-youtube" aria-hidden="true"></i></a> </li>
									</ul>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!--====== FOOTER - COPYRIGHT ==========-->
	<section>
		<div class="rows copy">
			<div class="container">
				<p>Copyrights © 2017 Company Name. All Rights Reserved</p>
			</div>
		</div>
	</section>
	<section>
		<div class="icon-float">
			<ul>
				<li><a href="#" class="sh">1k <br> Share</a> </li>
				<li><a href="#" class="fb1"><i class="fa fa-facebook" aria-hidden="true"></i></a> </li>
				<li><a href="#" class="gp1"><i class="fa fa-google-plus" aria-hidden="true"></i></a> </li>
				<li><a href="#" class="tw1"><i class="fa fa-twitter" aria-hidden="true"></i></a> </li>
				<li><a href="#" class="li1"><i class="fa fa-linkedin" aria-hidden="true"></i></a> </li>
				<li><a href="#" class="wa1"><i class="fa fa-whatsapp" aria-hidden="true"></i></a> </li>
				<li><a href="#" class="sh1"><i class="fa fa-envelope-o" aria-hidden="true"></i></a> </li>
			</ul>
		</div>
	</section>



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
      <form action="updateEventReview.php" method="post">
      <div class="modal-body">
        <input type="text" id="reason" style="width: 450px; height: 40px;" name="comment" cols="40" rows="3" placeholder="Nhập lí do từ chối"></textarea>
        <input type="hidden" name="id" value="<?php echo $resultevent['id']; ?>">
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-danger">Từ chối</button>
      </div>
  </form>
    </div>
  </div>
</div>

<div class="modal fade" id="reviewerModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Xác nhận</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>

                  <div class="modal-body">
                    <form id="add-reviewer-form" method="POST" action="<?php  $_SERVER["PHP_SELF"] ?>" >
                     <input type="text" id="email_mod" style="width: 450px; height: 40px; " name="email" cols="40" rows="3" placeholder="Nhập email của moderator cần thêm"></textarea>
                     <input type="hidden" name="id" value="<?php echo $resultevent['id']; ?>">
                     <BUTTON type="button" class="btn btn-primary" id="btn-add-mod">Thêm</BUTTON>
                     
                    </form>
                    <table class="responsive-table" style="margin-top: 30px;">
                            <thead>
                                <tr>
                                    <th>Danh sách Reviewer</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody id="tbodylistreviewer">
                                
                            </tbody>
                        </table>
                  </div>
                  <div class="modal-footer">
                    <!-- <button type="button" class="btn btn-danger">Xoá</button>&nbsp; &nbsp; -->
                  </div>
                </div>
              </div>
            </div>  
<div class="modal fade modal-xl" id="CommentModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Lịch sử duyệt</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>

                  <?php 
                    $result1=mysqli_query($conn,"select name , account_id, comment, day_comment from review_comment r, account a where event_id = ".$event_id." and r.account_id = a.id ");
                  ?>
                  <div class="modal-body">
                    <table class="responsive-table" >
                            <thead>
                                <tr>
                                    <th>Ngày</th>
                                    <th>Hành động</th>
                                    <th>Lí do</th>
                                    <th>Người từ chối</th>
                                </tr>
                            </thead>
                            <tbody id="tbodylistreviewer">
                                    <?php while($resultcomment=mysqli_fetch_assoc($result1)){?>
                                            <tr>
                                                <?php 
                                                    // $day = explode(" ",$resultcomment["day_comment"]);
                                                    $date = date ("d/m/Y", strtotime($resultcomment["day_comment"]));
                                                ?>
                                                 <td><?php echo $date; ?></td>
                                                  <td><a href=''><span class='db-cancel'>Từ chối</span></a>&nbsp;&nbsp;</td>
                                                   <td><?php echo $resultcomment["comment"] ?></td>
                                                    <td><?php echo $resultcomment["name"] ?></td>
                                            <tr>
                                    <?php } ?>
                            </tbody>
                        </table>
                  </div>
                  <div class="modal-footer">
                    <!-- <button type="button" class="btn btn-danger">Xoá</button>&nbsp; &nbsp; -->
                  </div>
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