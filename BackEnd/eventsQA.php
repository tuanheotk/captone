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
					<h2>Cấu Hình<span> sự kiện</span></h2>
					<div class="title-line">
						<div class="tl-1"></div>
						<div class="tl-2"></div>
						<div class="tl-3"></div>
					</div>
					<p>Hãy đến với trường đại học Văn Lang để tận hưởng những giây phút vui vẻ nhất!</p>
				</div>
				<div class="row">

					<div class="col-md-6">

						<div class="db-2-com db-2-main">
							<h4 style="background-color: white; color: black;">Moderator</h4>
		                    <div class="db-2-main-com db2-form-pay db2-form-com">
		                        <form class="col s12" method="POST" enctype="multipart/form-data">
		                            <div class="row">
		                                <div class="input-field col s12">

		                                    <input type="text" class="validates" id="name" name="name" title="Họ & Tên" value="<?php echo $account_name ?>" readonly="" >
		                                    <label for="name"></label>
		                                </div>

		                                <?php
		                                if ($account_code != '') {
		                                ?>
		                                <div class="input-field col s12">
		                                    <input type="text" class="validates" id="code" name="code" title="Mã số sinh viên" value="<?php echo $account_code ?>" readonly>
		                                    <label for="code"></label>
		                                </div>

		                                <?php
		                                }
		                                ?>


		                                <div class="input-field col s12">
		                                    <input type="text" class="validates" id="email" name="email" title="Email" value="<?php echo $account_email ?>" readonly>
		                                    <label for="email"></label>
		                                </div>
		                                <div class="input-field col s12">
		                                    <input type="text" class="validates" id="faculty" name="faculty" title="Khoa" value="<?php echo $account_faculty_name ?>" readonly>
		                                    <label for="faculty"></label>
		                                </div>
		                            </div>
		                        </form>
		                    </div>
                		</div>
					</div>
					<div class="col-md-6">
						<div class="db-2-com db-2-main">
							<h4>Live</h4>
		                    <div class="db-2-main-com db2-form-pay db2-form-com">
		                        <form class="col s12" method="POST" enctype="multipart/form-data">
		                            <div class="row">
		                                <div class="input-field col s12">

		                                    <input type="text" class="validates" id="name" name="name" title="Họ & Tên" value="<?php echo $account_name ?>" readonly="" >
		                                    <label for="name"></label>
		                                </div>

		                                <?php
		                                if ($account_code != '') {
		                                ?>
		                                <div class="input-field col s12">
		                                    <input type="text" class="validates" id="code" name="code" title="Mã số sinh viên" value="<?php echo $account_code ?>" readonly>
		                                    <label for="code"></label>
		                                </div>

		                                <?php
		                                }
		                                ?>


		                                <div class="input-field col s12">
		                                    <input type="text" class="validates" id="email" name="email" title="Email" value="<?php echo $account_email ?>" readonly>
		                                    <label for="email"></label>
		                                </div>
		                                <div class="input-field col s12">
		                                    <input type="text" class="validates" id="faculty" name="faculty" title="Khoa" value="<?php echo $account_faculty_name ?>" readonly>
		                                    <label for="faculty"></label>
		                                </div>
		                            </div>
		                        </form>
		                    </div>
                		</div>
					</div>
					
				</div>
                <!--END TITLE & DESCRIPTION -->
			</div>
		</div>
	</section>
	<?php
include('footer.php');
?>