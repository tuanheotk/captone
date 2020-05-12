<?php
$title = 'Đăng ký';
include('header.php');
if (isset($_SESSION["user_email"])) {
	// header("Location: index.php");
	header('Location: javascript://history.go(-1)');
}
?>
    <!--END HEADER SECTION-->
	
	<!--DASHBOARD-->
	<section>
		<div class="tr-register">
			<div class="tr-regi-form">
				<h4>Tạo tài khoản</h4>
				<p>Miễn phí và luôn như vậy.</p>
				<form class="col s12" id="register-form">
					<div class="row">

						<div class="input-field col s12">
							<!-- <p class="alert alert-danger validate" id="error" hidden="">Lỗi</p> -->
							<div id="error"></div>
						</div>
						
						<div class="input-field col s12">
							<input type="text" class="validate" id="full-name" name="full-name" title="Họ và tên" maxlength="50" required="">
							<label>Họ & Tên</label>
						</div>
					</div>
					<div class="row">
						<div class="input-field col s12">
							<input type="email" class="validate" id="email" name="email" title="Email" maxlength="50" required="">
							<label>Email</label>
						</div>
					</div>
					<div class="row">
						<div class="input-field col s12">
							<input type="password" class="validate" id="password" name="password" title="Mật khẩu" maxlength="50" required="">
							<label>Mật khẩu</label>
						</div>
					</div>
					<div class="row">
						<div class="input-field col s12">
							<input type="password" class="validate" id="password-confirm" title="Nhập lại mật khẩu" maxlength="50" required="">
							<label>Nhập lại mật khẩu</label>
						</div>
					</div>
					<div class="row">
						<div class="input-field col s12">
							<input type="hidden" name="action" value="register">
							<button type="submit" id="btn-register" class="waves-effect waves-light btn-large full-btn">Đăng ký</button>
						</div>
					</div>
				</form>
				<p>Bạn đã là thành viên? <a href="login.php">Bấm để đăng nhập</a>
				</p>
			</div>
		</div>
	</section>
	<!--END DASHBOARD-->
	
<?php
include('footer.php');
?>

<script type="text/javascript">

	$('#full-name').on('keydown keyup', function(){
        $(this).val($(this).val().replace(/[0123456789?,.:;"`~!@#$%^&*()\-_+={}\[\]><|\/\\\']+/g,''));
    })
	$('#email').on('keydown keyup', function(){
        $(this).val($(this).val().replace(/[!#$%^&*()+={}\[\]><|\/\\]+/g,''));
    })



	$('#email').focus(function(){
		$('#error').html('').fadeOut();
		$("#email").css({'background-color' : '#FFF'});
	})

	function validateEmail(email) {
	    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
	    return re.test(String(email).toLowerCase());
	}

// kiểm tra username đã tồn tại trong form đăng ký
	$('#email').blur(function () {
		var email = $('#email').val();
		// $('#error').html('<div class="alert alert-info"><i class="fa fa-spinner fa-spin"></i> Đang kiểm tra...</div>');
		// $('#error').fadeOut(0).fadeIn(700);

		if (email != '') {

			if (validateEmail(email)) {

				if (email.includes('@vanlanguni.vn') || email.includes('@vanlanguni.edu.vn')) {

					$('#error').fadeIn(function () {
						$(this).html('<div class="alert alert-danger">Bạn có thể đăng nhập bằng email bằng Văn Lang mà không cần đăng ký</strong></div>');
						$('#email').addClass('invalid');
						$('#btn-register').attr('disabled', true);
					})

				} else {

					$.post('process-manage-account.php', {email: email, action: 'check-email'}, function (response) {
						if (response.exist) {
							$('#error').fadeIn(function () {
								$(this).html('<div class="alert alert-danger">Email <strong>'+email+'</strong> đã có người sử dụng</div>');
								$('#email').addClass('invalid');
							})
							$('#btn-register').attr('disabled', true);
						} else {
							$('#btn-register').attr('disabled', false);
						}
					})
				}
			} else {
				$('#error').fadeIn(function () {
					$(this).html('<div class="alert alert-danger">Vui lòng nhập email hợp lệ</div>');
					$('#email').addClass('invalid');
					$('#btn-register').attr('disabled', true);
				})
			}
		}

	});

	// register
	$('#register-form').on('submit', function(e){
		e.preventDefault();

		var name = $('#full-name').val();
		var email = $('#email').val();
		var pass = $('#password').val();
		var pass2 = $('#password-confirm').val();

	    if (name.replace(/\s+/g, ' ').trim().length < 6) {
            alert('Họ tên tối thiểu 5 ký tự');
            $('#full-name').focus();
            return false;
        }

        if (pass.length < 6) {
        	alert('Mật khẩu tối thiểu 6 kí tự');
        	return false;
        }

        if (pass != pass2) {
        	alert('Mật khẩu chưa trùng khớp');
        	return false;
        }

		$('#btn-register').html('<i class="fa fa-spinner fa-spin"></i> Vui lòng đợi');
        registerForm = document.querySelector('#register-form');
        
        $.ajax({
            url: 'process-manage-account.php',
            method: 'POST',
            dataType: 'json',
            processData: false,
            contentType: false,
            data: new FormData(registerForm)

        }).done(function(data){
            if(data.result){
				$('#btn-register').html('<i class="fa fa-check"></i> Thành công');
            	// alert('Bạn đã đăng ký thành công. Vui lòng kiểm tra email để kích hoạt tài khoản của bạn');
                window.location = 'registered.php';
            }else {
                console.log(data.error);
                $('#btn-register').html('Đăng ký');
            }
        }).fail(function(jqXHR, statusText, errorThrown){
            console.log("Fail:"+ jqXHR.responseText);
            console.log(errorThrown);
        })

	})
	
</script>