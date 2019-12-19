<?php
include('header.php');
?>
    <!--END HEADER SECTION-->
	
	<!--DASHBOARD-->
	<section>
		<div class="tr-register">
			<div class="tr-regi-form">
				<h4>Tạo tài khoản</h4>
				<p>Miễn phí và luôn như vậy.</p>
				<form class="col s12">
					<div class="row">
						<div class="input-field col m6 s12">
							<input type="text" class="validate">
							<label>Họ</label>
						</div>
						<div class="input-field col m6 s12">
							<input type="text" class="validate">
							<label>Tên</label>
						</div>
					</div>
					<div class="row">
						<div class="input-field col s12">
							<input type="number" class="validate">
							<label>Số điện thoại</label>
						</div>
					</div>
					<div class="row">
						<div class="input-field col s12">
							<input type="email" class="validate">
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
							<input type="password" class="validate">
							<label>Nhập lại mật khẩu</label>
						</div>
					</div>
					<div class="row">
						<div class="input-field col s12">
							<input type="submit" value="Tạo" class="waves-effect waves-light btn-large full-btn"> </div>
					</div>
				</form>
				<p>Bạn đã là thành viên? <a href="login.html">Click để đăng nhập</a>
				</p>
			</div>
		</div>
	</section>
	<!--END DASHBOARD-->
	
	<?php
include('footer.php');
?>