<?php 
session_start();
if (isset($_SESSION['last_active']) && (time() - $_SESSION['last_active'] > 7200)) {
    session_unset();
    // session_destroy();
}
$_SESSION['last_active'] = time();

require('database-config.php');
if (isset($_SESSION['user_email'])) {
    $sqlUserInfo = "SELECT a.id, a.name, a.email, a.password, a.code, a.role, a.faculty_id, a.status, f.name AS faculty_name FROM account a, faculty f WHERE a.faculty_id = f.faculty_id AND email = '".$_SESSION['user_email']."'";
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
    $account_vlu = (is_null($rowInfo['password'])) ? true : false;

    // disabled
    if ($account_status == 0) {
        if ($_SERVER['REQUEST_URI'] != '/block.php') {
            header("Location: block.php");
        }
    } else
    // check require info
    if ($account_faculty_id == -1 || $account_name == "") {
        if ($_SERVER['REQUEST_URI'] != '/update-info.php') {
            header("Location: update-info.php");
        }
    }

    $sql_check_mod = "SELECT id FROM moderator WHERE email = '$account_email'";
    $result_check_mod = mysqli_query($conn, $sql_check_mod);
    $is_mod = (mysqli_num_rows($result_check_mod) > 0) ? true : false ;
}
ob_start();

 ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php 
    if ($_SERVER['REQUEST_URI'] == '/' || $_SERVER['REQUEST_URI'] == '' || $_SERVER['REQUEST_URI'] == '/index.php') {
        echo "<title>EventBox Văn Lang</title>";
    } else {
        echo "<title>$title | EventBox Văn Lang</title>";
    }
    ?>
    <!--== META TAGS ==-->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <!-- FAV Icon -->
    <link rel="apple-touch-icon" sizes="180x180" href="images/fav/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="images/fav/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="images/fav/favicon-16x16.png">
    <link rel="manifest" href="images/fav/site.webmanifest">
    <link rel="mask-icon" href="images/fav/safari-pinned-tab.svg" color="#5bbad5">
    <link rel="shortcut icon" href="images/fav/favicon.ico">
    <meta name="apple-mobile-web-app-title" content="EventBox">
    <meta name="application-name" content="EventBox">
    <meta name="msapplication-TileColor" content="#4243dc">
    <meta name="msapplication-config" content="images/fav/browserconfig.xml">
    <meta name="theme-color" content="#ffffff">

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

    <!-- Slick -->
    <link href="vendor/slick/slick.css" rel="stylesheet" type="text/css">
    <link href="vendor/slick/slick-theme.css" rel="stylesheet" type="text/css">
    
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
                        <a href="/"><img src="images/logo.png" alt="" />
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
                                <li><a href="/">Trang chủ</a></li>
                                <li><a href="events.php">Hội nghị - Sự kiện</a></li>
                                
                            </ul>
                            
                            
                            <h4>Sự kiện của tôi</h4>
                            <ul>
                                <?php
                                if (isset($account_role) && $account_role == 4) {
                                ?>
                                <li><a href="all-events.php">Tất cả sự kiện</a></li>
                                <?php
                                }
                                ?>
                                <li><a href="my-events.php">Sự kiện của tôi</a></li>

                                <?php
                                if (isset($is_mod) && $is_mod) {
                                ?>
                                <li><a href="my-support-events.php">Sự kiện hỗ trợ</a></li>
                                <?php
                                }
                                ?>

                                <li><a href="my-registered-events.php">Sự kiện đăng ký tham gia</a></li>
                                <?php 
                                if (isset($account_role) && $account_role == 2 || isset($account_role) && $account_role == 4) {
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
                                <li><a href="manage-cover.php">Ảnh bìa</a></li>
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
                                <li><a href="http://vanlanguni.edu.vn/trang-chu/ban-do-den-van-lang" target="_blank">Trung tâm Hỗ trợ Sinh viên</a>
                                </li>
                                <li><a href="tel:02871099218">Điện thoại: 028 7109 9218 (Ext: 3310/3311)</a>
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
                            <a href="/"><img src="images/logo.png" alt="" />
                            </a>
                        </div>
                        <div class="main-menu dropdowncc">
                            <ul>
                                <li><a href="/">Trang chủ</a></li>
                                <li><a href="events.php">Hội nghị - Sự kiện</a></li>
                                
                                <?php
                                if (isset($account_role)) {
                                ?>

                                <li class="cour-menu">
                                    <a href="my-events.php" class="mm-arr">Sự kiện của tôi</a>
                                    <!-- MEGA MENU 1 -->
                                    <div class="mm-pos">
                                        <div class="cour-mm m-menu">
                                            <div class="m-menu-inn">
                                                <div class="mm1-com mm1-cour-com mm1-s12">
                                                    <ul>
                                                        <?php
                                                        if (isset($account_role) && $account_role == 4) {
                                                        ?>
                                                        <li><a href="all-events.php"> Tất cả sự kiện</a></li>
                                                        <?php
                                                        }
                                                        ?>
                                                        <li><a href="my-events.php">Sự kiện của tôi</a></li>

                                                        <?php
                                                        if (isset($is_mod) && $is_mod) {
                                                        ?>
                                                        <li><a href="my-support-events.php">Sự kiện hỗ trợ</a></li>
                                                        <?php
                                                        }
                                                        ?>
                                                        
                                                        <li><a href="my-registered-events.php">Sự kiện tham gia</a></li>
                                                        <?php
                                                        if (isset($account_role) && $account_role == 2 || isset($account_role) && $account_role == 4) {
                                                        ?>
                                                        <li><a href="review-event.php">Duyệt sự kiện</a></li>
                                                        <?php
                                                        }
                                                        ?>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <?php
                                } else {
                                ?>
                                <li><a href="my-events.php">Sự kiện của tôi</a></li>
                                <?php
                                }
                                ?>


                                <?php 
                                if (isset($account_role) && $account_role == 4) {
                                ?>
                                <li class="admi-menu">
                                    <a href="javascript:void(0)" class="mm-arr">Quản lý</a>
                                    <!-- MEGA MENU 1 -->
                                    <div class="mm-pos">
                                        <div class="admi-mm m-menu">
                                            <div class="m-menu-inn">
                                                <div class="mm1-com mm1-cour-com mm1-s12">
                                                    <!-- <h4>Quản lý</h4> -->
                                                    <ul>
                                                        <li><a href="manage-account.php">Tài Khoản</a></li>
                                                        <li><a href="manage-faculty.php">Khoa</a></li>
                                                        <li><a href="manage-cover.php">Ảnh bìa</a></li>
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