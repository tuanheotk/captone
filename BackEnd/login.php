<?php
// session_start();
$title = 'Đăng nhập';
include('header.php');


require('api-oauth.php');
require('api-outlook.php');

// Check logged in
if (isset($_SESSION['user_email'])) {
	header('Location: javascript://history.go(-1)');
}


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
				<!-- <p>Miễn phí và luôn như vậy</p> -->
				<form class="col s12" id="login-form" method="POST">
					<div class="row">
						<div class="input-field col s12">
							<input type="email" class="validate" id="email" name="email" placeholder="Email" title="Email" maxlength="50" required="">
							<!-- <label>Email</label> -->
						</div>
					</div>
					<div class="row">
						<div class="input-field col s12">
							<input type="password" class="validate" id="pass" name="password" placeholder="Mật khẩu" title="Mật khẩu" maxlength="50" required="">
							<!-- <label>Mật khẩu</label> -->
						</div>
					</div>
					<div class="row">
						<div class="input-field col s12">
							<input type="hidden" name="action" value="login">
							<button type="submit" class="waves-effect waves-light btn-large full-btn" id="btn-login">Đăng nhập</button>
						</div>
					</div>
				</form>
				<p><a href="register.php">Chưa có tài khoản?</a></p>
				<div class="soc-login">
					<ul>
						<li><a href="<?php echo oAuthService::getLoginUrl($redirectUri) ?>" class="waves-effect waves-light">Đăng nhập bằng email Văn Lang</a> </li>
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

<script type="text/javascript">

	$('#email').on('keydown keyup', function(){
        $(this).val($(this).val().replace(/[!#$%^&*()+={}\[\]><|\/\\]+/g,''));
    })

	$('#email').blur(function () {
    	if ($(this).val().includes('@vanlanguni.vn') || email.includes('@vanlanguni.edu.vn')) {
    		alert('Nếu bạn có tài khoản Văn Lang. Xin vui lòng chọn "Đăng nhập bằng email Văn Lang" ở phía dưới');
    	}
	})

    $('#login-form').on('submit', function(e){
		e.preventDefault();
		var email = $('#email').val();
    	if (email.includes('@vanlanguni.vn') || email.includes('@vanlanguni.edu.vn')) {
    		alert('Nếu bạn có tài khoản Văn Lang. Xin vui lòng chọn "Đăng nhập bằng email Văn Lang" ở phía dưới');
    		return false;
    	}

		$('#btn-login').html('<i class="fa fa-spinner fa-spin"></i> Vui lòng đợi');
        loginForm = document.querySelector('#login-form');
        
        $.ajax({
            url: 'process-manage-account.php',
            method: 'POST',
            dataType: 'json',
            processData: false,
            contentType: false,
            data: new FormData(loginForm)

        }).done(function(data){
            if(data.result){
				$('#btn-login').html('<i class="fa fa-check"></i> Thành công');
                // window.location = 'index.php';
                // window.history.back();
                if (document.referrer.includes('register.php')) {
                	window.history.go(-2);
                } else {
                	window.history.go(-1);
                }
            }else {
                alert(data.message);
                $('#btn-login').html('Đăng nhập');
            }
        }).fail(function(jqXHR, statusText, errorThrown){
            console.log("Fail:"+ jqXHR.responseText);
            console.log(errorThrown);
        })

	})

</script>