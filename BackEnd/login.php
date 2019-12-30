<?php
// session_start();
$title = 'Đăng nhập';
include('header.php');


require('api-oauth.php');
require('api-outlook.php');

// $loggedIn = !is_null($_SESSION['access_token']);
$loggedIn = isset($_SESSION['access_token']);
$redirectUri = 'http://localhost/event/api-authorize.php';

if (!$loggedIn) {

	?>
	<!-- html login form -->
	<!--DASHBOARD-->
	<section>
		<div class="tr-register">
			<div class="tr-regi-form">
				<h4>Đăng nhập</h4>
				<p>Miễn phí và luôn như vậy.</p>
				<form class="col s12" action="login.php">
					<div class="row">
						<div class="input-field col s12">
							<input type="text" class="validate">
							<label>Email</label>
						</div>
					</div>
					<div class="row">
						<div class="input-field col s12">
							<input type="password" class="validate">
							<label>Mật khẩu</label>
						</div>
					</div>
					<div class="row">
						<div class="input-field col s12">
							<!-- <input type="submit" value="submit" class="waves-effect waves-light btn-large full-btn"> -->
							<button type="submit" class="waves-effect waves-light btn-large full-btn">Đăng nhập</button>
						</div>
					</div>
				</form>
				<p><a href="register.php">Chưa có tài khoản?</a></p>
				</p>
				<div class="soc-login">
					<ul>
						<li><a href="<?php echo oAuthService::getLoginUrl($redirectUri) ?>" class="waves-effect waves-light">Đăng nhập bằng email Văn Lang</a> </li>
						<!-- <button type="button" class="waves-effect waves-light btn-large full-btn"><i class="fa fa-windows"></i> Microsoft</button> -->
					</ul>
				</div>
			</div>
		</div>
	</section>

	<?php
	# code...
} else {
	header("Location: index.php");
	?>
	<p>Email: <?php echo $_SESSION['user_email']; ?></p>
	<p>MS: <?php echo $_SESSION['user_code']; ?></p>
	<a href="logout.php">Đăng xuất</a>
	<?php

}

?>

		
	<!--END DASHBOARD-->
<?php
include('footer.php');
?>