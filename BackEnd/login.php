<?php
$title = 'Đăng nhập';
include('header.php');
?>

		
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
				<p><a href="forgot-pass.html">Quên mật khẩu?</a> | <a href="register.html">Chưa có tài khoản?</a></p>
				</p>
				<div class="soc-login">
					<h5>Đăng nhập bằng tài khoản khác</h5>
					<ul>
						<li><a href="#"><i class="fa fa-windows"></i> Microsoft</a> </li>
						<!-- <button type="button" class="waves-effect waves-light btn-large full-btn"><i class="fa fa-windows"></i> Microsoft</button> -->
					</ul>
				</div>
			</div>
		</div>
	</section>
	<!--END DASHBOARD-->
<?php
include('footer.php');
?>	

<?php 
	$myclient_id = "db6950e9-dd30-48f0-ba9d-6d250724b04b";
	$myredirect_uri = "http://localhost/event/myredirect.php";
	$myscopes = "wl.basic,wl.emails wl.signin,wl.offline_access ";
	//coding to redirect to the Microsoft application just created.
	header("Location: " . "https://login.live.com/oauth20_authorize.srf?client_id=" . $myclient_id . "&scope=" . $myscopes . "&response_type=token&redirect_uri=" . $myredirect_uri);
 ?>