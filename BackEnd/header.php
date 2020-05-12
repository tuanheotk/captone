<?php 
session_start();
if (isset($_SESSION['last_active']) && (time() - $_SESSION['last_active'] > 7200)) {
    session_unset();
    // session_destroy();
}
$_SESSION['last_active'] = time();

require('database-config.php');
if (isset($_SESSION['user_email'])) {
    $sqlUserInfo = "SELECT a.id, a.name, a.email, a.code, a.role, a.faculty_id, a.status, f.name AS faculty_name FROM account a, faculty f WHERE a.faculty_id = f.faculty_id AND email = '".$_SESSION['user_email']."'";
    $resultUserInfo = mysqli_query($conn, $sqlUserInfo);
    $rowInfo = mysqli_fetch_assoc($resultUserInfo);
    $account_id = $rowInfo['id'];
    $account_name = $rowInfo['name'];
    $account_email = $rowInfo['email'];
    $account_code = $rowInfo['code'];
    $account_role = $rowInfo['role'];
    $account_faculty_id = $rowInfo['faculty_id'];
    $account_faculty_name = $rowInfo['faculty_name'];
    $account_status = $rowInfo['status'];

    // disabled
    if ($account_status == 0) {
        if ($_SERVER['REQUEST_URI'] != '/event/block.php') {
            header("Location: block.php");
        }
    } else
    // check require info
    if ($account_faculty_id == -1 || $account_name == "") {
        if ($_SERVER['REQUEST_URI'] != '/event/update-info.php') {
            header("Location: update-info.php");
        }
    }
}
ob_start();

 ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title><?php echo $title ?> - EventBox Văn Lang</title>
    <!--== META TAGS ==-->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <!-- FAV ICON -->
    <link rel="shortcut icon" href="images/fav.ico">
    <!-- GOOGLE FONTS -->
    <link href="https://fonts.googleapis.com/css?family=Poppins%7CQuicksand:400,500,700" rel="stylesheet">
    <!-- FONT-AWESOME ICON CSS -->
    <link rel="stylesheet" href="css/font-awesome.min.css">

    <!--== ALL CSS FILES ==-->
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/materialize.css">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/mob.css">
    <link rel="stylesheet" href="css/animate.css">
    <link rel="stylesheet" href="css/bootstrap-datepicker.css">
    <link rel="stylesheet" href="css/bootstrap-datetimepicker.css">

    <!-- Datatables -->  
    <link href="vendor/DataTables/datatables.min.css" rel="stylesheet" type="text/css">
    
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
	<script src="js/html5shiv.js"></script>
	<script src="js/respond.min.js"></script>
	<![endif]-->
    
</head>

<body>
    <!-- Preloader -->
    <div id="preloader">
        <div id="status"></div>
    </div>
   

    <!-- MOBILE MENU -->
    <section>
        <div class="ed-mob-menu">
            <div class="ed-mob-menu-con">
                <div class="ed-mm-left">
                    <div class="wed-logo">
                        <a href="index.php"><img src="images/logo.png" alt="" />
                        </a>
                    </div>
                </div>
                <div class="ed-mm-right">
                    <div class="ed-mm-menu">
                        <a href="javascript:void(0)" class="ed-micon"><i class="fa fa-bars"></i></a>
                        <div class="ed-mm-inn">
                            <a href="javascript:void(0)" class="ed-mi-close"><i class="fa fa-times"></i></a>
                            <h4>EventBox</h4>
                            <ul>
                                <li><a href="index.php">Trang chủ</a></li>
                                <li><a href="events.php">Hội nghị - Sự kiện</a></li>
                                
                            </ul>
                            
                            
                            <h4>Sự kiện của tôi</h4>
                            <ul>
                                <li><a href="my-events.php">Sự kiện của tôi</a></li>
                                <li><a href="my-registered-events.php">Sự kiện đăng ký tham gia</a></li>
                                <?php 
                                if (isset($account_role) && $account_role == 2) {
                                ?>

                                <li><a href="review-event.php"> Duyệt sự kiện</a></li>
                                <?php
                                }
                                ?>                              
                            </ul>
                            

                            <?php 
                                if (isset($account_role) && $account_role == 4) {
                            ?>

                            <h4>Quản Lý</h4>
                            <ul>
                                <li><a href="manage-account.php">Tài khoản</a></li>
                                <li><a href="manage-faculty.php">Khoa</a></li>                              
                            </ul>

                            <?php
                                }
                            ?>
                            
                            <h4>Tài khoản</h4>
                            <ul>
                                <?php 
                                if (isset($_SESSION['user_email'])) {
                                    ?>
                                    <!-- Sign Out -->
                                    <li><a href="my-profile.php">Thông tin cá nhân</a></li>
                                    <li><a href="logout.php">Đăng xuất</a></li>
                                    <?php
                                } else {
                                    ?>
                                    <!-- HTML login -->
                                    <li><a href="login.php">Đăng nhập</a></li>
                                    <li><a href="register.php">Đăng ký</a></li>

                                    <?php
                                }
                                
                                ?>
                            </ul>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--HEADER SECTION-->
    <section>
        <!-- TOP BAR -->
        <div class="ed-top">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="ed-com-t1-left">
                            <ul>
                                <li><a href="http://vanlanguni.edu.vn/trang-chu/ban-do-den-van-lang" target="_blank">Địa chỉ: 45 Nguyễn Khắc Nhu, Phường Cô Giang, Quận 1, Hồ Chí Minh.</a>
                                </li>
                                <li><a href="tel:02838367933">Điện thoại: 028 3836 7933</a>
                                </li>
                            </ul>
                        </div>
                        <div class="ed-com-t1-right">
                            <ul>
                                <!-- <li>Tên</li> -->
                                <?php 
                                if (isset($_SESSION['user_email'])) {
                                    ?>
                                    <!-- Sign Out -->
                                    <li><a href="my-profile.php"><?php echo $account_name?></a></li>
                                    <li><a href="logout.php">Đăng xuất</a></li>
                                    <?php
                                } else {
                                    ?>
                                    <!-- HTML login -->
                                    <li><a href="login.php">Đăng nhập</a></li>
                                    <li><a href="register.php">Đăng kí</a></li>

                                    <?php
                                }
                                
                                ?>
                                
                            </ul>
                        </div>
                        <!-- <div class="ed-com-t1-social">
                            <ul>
                                
                                <li><a href="#"><i class="fa fa-google-plus" aria-hidden="true"></i></a>
                                </li>
                                <li><a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a>
                                </li>
                            </ul>
                        </div> -->
                    </div>
                </div>
            </div>
        </div>

        <!-- LOGO AND MENU SECTION -->
        <div class="top-logo" data-spy="affix" data-offset-top="250">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="wed-logo">
                            <a href="index.php"><img src="images/logo.png" alt="" />
                            </a>
                        </div>
                        <div class="main-menu dropdowncc">
                            <ul>
                                <li><a href="index.php">Trang chủ</a>
                                </li>
                                
                               
                                <li><a href="events.php">Hội nghị - Sự kiện</a></li>
                               
                                
                                <li><a href="my-events.php">Sự kiện của tôi</a>
                                </li>

                                <?php 
                                if (isset($account_role) && $account_role == 4) {
                                ?>
                                <li class="cour-menu">
                                    <a href="javascript:void(0)" class="mm-arr">Quản lý</a>
                                    <!-- MEGA MENU 1 -->
                                    <div class="mm-pos">
                                        <div class="cour-mm m-menu">
                                            <div class="m-menu-inn">
                                                <div class="mm1-com mm1-cour-com mm1-s12">
                                                    <h4>Quản lý</h4>
                                                    <ul>
                                                        <li><a href="manage-account.php">Tài Khoản</a></li>
                                                        <li><a href="manage-faculty.php">Khoa</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>

                                <?php
                                }
                                ?>



                                <?php
                                if (isset($_SESSION["user_email"])) {
                                ?>
                                <li><a href="my-profile.php">Thông tin cá nhân</a></li>
                                <?php
                                }
                                ?>

                                
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
          
    </section>
    <!--END HEADER SECTION-->