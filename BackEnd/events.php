<?php
$title = 'Sự kiện';
include('header.php');
?>
    <!--END HEADER SECTION-->
	
	
	<!--====== PLACES ==========-->
	<section>
		<div class="rows inn-page-bg com-colo">
			<div class="container inn-page-con-bg tb-space pad-bot-redu" id="inner-page-title">
				<!-- TITLE & DESCRIPTION -->

				<div class="spe-title col-md-12">
					<h2>Sự kiện <span>Đang diễn ra</span></h2>
					<div class="title-line">
						<div class="tl-1"></div>
						<div class="tl-2"></div>
						<div class="tl-3"></div>
					</div>
					<p>Hãy đến với trường đại học Văn Lang để tận hưởng những giây phút vui vẻ nhất!</p>
				</div>
				<div>
					<?php
					require('database-config.php');
					$sql = "SELECT * FROM event where status=4 ORDER BY public_at DESC";
					 $result=mysqli_query($conn,$sql);
						 while($resultevent=mysqli_fetch_assoc($result)){

						?>

						<div>
						<div class='col-md-6 wow slideInUp'>
		                <a href="event-detail.php?id=<?php echo $resultevent['id'] ?>">
		                    <div class='tour-mig-like-com'>
		                              <div class='tour-mig-lc-img'> <img src="<?php echo $resultevent["avatar"] ?>" alt=''> </div>
		                              <div class='tour-mig-lc-con'>
		                                <h5><?php echo $resultevent["title"] ?></h5>
		                                 <p><span><?php echo date("H:i - d/m/Y", strtotime($resultevent["start_date"])); ?></span><?php echo $resultevent["place"] ?></p>
		                             </div>
		                           </div>
		                     </a>
		                 </div>
						</div>
					
						<?php
						}
					?>
					
				</div>
                <!--END TITLE & DESCRIPTION -->
			</div>
		</div>
	</section>
	<?php
include('footer.php');
?>