<?php
	$title = "Bị khóa";
	include 'header.php';
	if ($account_status != 0 || !isset($_SESSION["user_email"])) {
		header('Location: index.php');
	}
?>
    <!--END HEADER SECTION-->
	
	
	<!--====== PLACES ==========-->
	<section>
		<div class="tr-register">
			<div class="tr-regi-form v2-search-form">
				<h4><span>Thông báo</span></h4>
				<hr>
				<p>Tài khoản của bạn đã bị khóa</p>
				<p>Liên hệ quản trị viên để được hổ trợ</p>
				<br>
				<a href="logout.php" class="btn btn-danger">Đăng xuất</a>
						
			</div>

		</div>
	</section>
	<?php
include('footer.php');
?>