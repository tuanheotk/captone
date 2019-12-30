<?php  
  $title = "Bị khóa";
  include 'header.php';
  if ($account_status != 0 || !isset($_SESSION["user_email"])) {
  	header('Location: index.php');
  }
?>
	<h2>
		tài khoản bạn bị khóa
	</h2>
	<a href="logout.php">Đăng xuất</a>
	
<?php  
  include 'footer.php';
?>