<?php
// remove index.php
if ($_SERVER['REQUEST_URI'] == '/event/index.php') {
  header('Location: /event');
}

$title = 'Trang chủ';
include('header.php');

$sqlFeature = "SELECT e.id, e.title, e.avatar, e.start_date, e.place, COUNT(a.event_id) AS total FROM event e LEFT JOIN attendee a ON e.id = a.event_id WHERE e.status = 4 GROUP BY e.id ORDER BY total DESC, e.public_at DESC LIMIT 6";

$sqlAcademic = "SELECT e.id, e.title, e.avatar, c.name FROM event e, category c WHERE e.category_id = c.id AND c.id = 1 AND e.status = 4 ORDER BY e.public_at DESC";
$sqlCulture = "SELECT e.id, e.title, e.avatar, c.name FROM event e, category c WHERE e.category_id = c.id AND c.id = 2 AND e.status = 4 ORDER BY e.public_at DESC";
$sqlSport = "SELECT e.id, e.title, e.avatar, c.name FROM event e, category c WHERE e.category_id = c.id AND c.id = 3 AND e.status = 4 ORDER BY e.public_at DESC";

$sqlRecommend = "SELECT id, title, avatar FROM event WHERE id IN ((SELECT MAX(id) FROM event WHERE status = 4 GROUP BY faculty_id))";

$resultFeature = mysqli_query($conn, $sqlFeature);
$resultAcademic = mysqli_query($conn, $sqlAcademic);
$resultCulture = mysqli_query($conn, $sqlCulture);
$resultSport = mysqli_query($conn, $sqlSport);
$resultRecommend = mysqli_query($conn, $sqlRecommend);


?>

    <!--HEADER SECTION-->
    <section>
        <div class="tourz-search">
            <div class="container">
                <div class="row">
                    <div class="tourz-search-1">
                        <h1>Nhập mã sự kiện</h1>
                        
                        <form class="tourz-search-form" id="join-room-form">
                            <div class="input-field">
                                <input type="text" id="select-city" class="autocomplete">
                                <label for="select-city">Enter class</label>
                            </div>
                            <div class="input-field">
                                <input type="text" id="event-code" class="autocomplete" required maxlength="4">
                                <label for="event-code" class="search-hotel-type">A1B2</label>
                            </div>
                            <div class="input-field">
                                <input type="submit" value="Tham gia" class="waves-effect waves-light tourz-sear-btn"> 
                            </div>
                        </form>
                        
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--END HEADER SECTION-->
    
    <!--====== Noi Bat ==========-->
    <section>
        <div class="rows pad-bot-redu tb-space">
            <div class="container">
                <!-- TITLE & DESCRIPTION -->
                <div class="spe-title">
                    <h2>Sự kiện <span>nổi bật</span> </h2>
                    <div class="title-line">
                        <div class="tl-1"></div>
                        <div class="tl-2"></div>
                        <div class="tl-3"></div>
                    </div>
                    <p>Hãy đến và tham gia với chúng tôi!!</p>
                </div>
                <!-- CITY -->

                <?php
                while ($rowFeature = mysqli_fetch_assoc($resultFeature)) {
                  $feature_event_id = $rowFeature["id"];
                  $feature_event_name = $rowFeature["title"];
                  $feature_event_avatar = $rowFeature["avatar"];
                  $feature_event_place = $rowFeature["place"];
                  $feature_event_start =  date("H:i - d/m/Y", strtotime($rowFeature["start_date"]));

                  ?>
                  <div class="col-md-6 wow slideInUp">
                      <a href="event-detail.php?id=<?php echo $feature_event_id ?>">
                          <div class="tour-mig-like-com">
                              <div class="tour-mig-lc-img"> <img src="<?php echo $feature_event_avatar ?>" alt=""> </div>
                              <div class="tour-mig-lc-con">
                                  <h5><?php echo $feature_event_name ?></h5>
                                  <p><span><?php echo $feature_event_start ?></span><?php echo $feature_event_place ?></p>
                              </div>
                          </div>
                      </a>
                  </div>

                <?php
                }
                ?>


                
            </div>

        </div>

    </section>

     

    <!--Danh Muc-->

    <section id="section-category">
        <div class="rows pad-bot-redu tb-space">
            <div class="container">
                <!-- TITLE & DESCRIPTION -->
                <div class="spe-title">
                    <h2>Danh mục <span>sự kiện</span></h2>
                    <div class="title-line">
                        <div class="tl-1"></div>
                        <div class="tl-2"></div>
                        <div class="tl-3"></div>
                    </div>
                    <p>Hãy đến với trường đại học Văn Lang để tận hưởng những giây phút vui vẻ nhất!</p>
                </div>
                <div class="col-md-4 wow slideInUp">
                	<div id="myCarousel1" class="carousel slide" data-ride="carousel">
                		<!-- Wrapper for slides -->
                    <h3 class="text-center category-title">Học thuật</h3>
                		<div class="carousel-inner category-fix-img">

	                    <?php
	                    if (mysqli_num_rows($resultAcademic) > 0) {
	                    	$count = 0;
	                    	while ($rowAcademic = mysqli_fetch_assoc($resultAcademic)) {
		                      	$count++;
		                        $academic_event_id = $rowAcademic["id"];
		                        $academic_event_name = $rowAcademic["title"];
		                        $academic_event_avatar = $rowAcademic["avatar"];
		                        $academic_category_name = $rowAcademic["name"];
	                    ?>
	                    	<div class="item <?php if ($count == 1) {echo 'active';} ?>">
		                       <!--  <a href="event-detail.php?id=<?php echo $academic_event_id ?>">
  		                        	<img src="<?php echo $academic_event_avatar ?>" alt="Văn Lang" style="width:100%;">
  		                        	<div class="carousel-caption">
  		                        		<h3><?php echo $academic_category_name ?></h3>
  		                            <p><?php echo $academic_event_name ?></p>
  			                        </div>
  			                    </a> -->
                            <a href="event-detail.php?id=<?php echo $academic_event_id ?>">
                                <div class="tour-mig-like-com">
                                    <div class="tour-mig-lc-img"> <img src="<?php echo $academic_event_avatar ?>" alt=""> </div>
                                    <div class="tour-mig-lc-con">
                                        <p class="text-center"><?php echo $academic_event_name ?></p>
                                    </div>
                                </div>
                            </a>
			                </div>

		                    <?php
		                      }
		                    } else {
		                    ?>
		                    <div class="item active">
		                    	<div class="tour-mig-like-com">
                            <div class="tour-mig-lc-img"> <img src="images/listing/home.jpg" alt=""> </div>
                            <div class="tour-mig-lc-con">
                                <p class="text-center">Chưa có sự kiện</p>
                            </div>
                          </div>
			                </div>
		                    <?php
		                    }
		                    ?>
		                </div>
		                <!-- Left and right controls -->
		                <a class="left carousel-control" href="#myCarousel1" data-slide="prev">
		                	<span class="icon-prev"></span>
		                    <span class="sr-only">Previous</span>
		                </a>
		                <a class="right carousel-control" href="#myCarousel1" data-slide="next">
		                    <span class="icon-next"></span>
		                    <span class="sr-only">Next</span>
		                </a>
		            </div>
		        </div>


		        <div class="col-md-4 wow slideInUp">
                    <div id="myCarousel2" class="carousel slide" data-ride="carousel">
                    	<!-- Wrapper for slides -->
                      <h3 class="text-center category-title">Văn hóa</h3>
                    	<div class="carousel-inner category-fix-img">

	                    <?php
	                    if (mysqli_num_rows($resultCulture) > 0) {
	                    	$count = 0;
	                    	while ($rowCulture = mysqli_fetch_assoc($resultCulture)) {
		                        $count++;
		                        $culture_event_id = $rowCulture["id"];
		                        $culture_event_name = $rowCulture["title"];
		                        $culture_event_avatar = $rowCulture["avatar"];
		                        $culture_category_name = $rowCulture["name"];
	                    ?>
	                    	<div class="item <?php if ($count == 1) {echo 'active';} ?>">
		                        <!-- <a href="event-detail.php?id=<?php echo $culture_event_id ?>">
  		                        	<img src="<?php echo $culture_event_avatar ?>" alt="Văn Lang" style="width:100%;">
  		                        	<div class="carousel-caption">
  		                        		<h3><?php echo $culture_category_name ?></h3>
  		                            <p><?php echo $culture_event_name ?></p>
  			                        </div>
  			                    </a> -->

                            <a href="event-detail.php?id=<?php echo $culture_event_id ?>">
                                <div class="tour-mig-like-com">
                                    <div class="tour-mig-lc-img"> <img src="<?php echo $culture_event_avatar ?>" alt=""> </div>
                                    <div class="tour-mig-lc-con">
                                        <p class="text-center"><?php echo $culture_event_name ?></p>
                                    </div>
                                </div>
                            </a>
			                </div>

		                    <?php
		                      }
		                    } else {
		                    ?>
		                    <div class="item active">
		                    	<div class="tour-mig-like-com">
                            <div class="tour-mig-lc-img"> <img src="images/listing/home.jpg" alt=""> </div>
                            <div class="tour-mig-lc-con">
                                <p class="text-center">Chưa có sự kiện</p>
                            </div>
                          </div>
			                </div>
		                    <?php
		                    }
		                    ?>
		                </div>

                      <!-- Left and right controls -->
                      <a class="left carousel-control" href="#myCarousel2" data-slide="prev">
                        <span class="icon-prev"></span>
                        <span class="sr-only">Previous</span>
                      </a>
                      <a class="right carousel-control" href="#myCarousel2" data-slide="next">
                        <span class="icon-next"></span>
                        <span class="sr-only">Next</span>
                      </a>
                    </div>
              </div>

              <div class="col-md-4 wow slideInUp">
                    <div id="myCarousel3" class="carousel slide" data-ride="carousel">
                    	<!-- Wrapper for slides -->
                      <h3 class="text-center category-title">Thể thao</h3>
                    	<div class="carousel-inner category-fix-img">

	                    <?php
	                    if (mysqli_num_rows($resultSport) > 0) {
	                    	$count = 0;
	                    	while ($rowSport = mysqli_fetch_assoc($resultSport)) {
	                    		$count++;
          								$sport_event_id = $rowSport["id"];
          								$sport_event_name = $rowSport["title"];
          								$sport_event_avatar = $rowSport["avatar"];
          								$sport_category_name = $rowSport["name"];
	                    ?>
	                    	<div class="item <?php if ($count == 1) {echo 'active';} ?>">
		                        <!-- <a href="event-detail.php?id=<?php echo $sport_event_id ?>">
                              <div class="img-gradient">
                                
		                        	 <img src="<?php echo $sport_event_avatar ?>" alt="Văn Lang" style="width:100%;">
                              </div>
		                        	<div class="carousel-caption">
		                        		<h3><?php echo $sport_category_name ?></h3>
		                            <p><?php echo $sport_event_name ?></p>
			                        </div>
			                    </a> -->

                          <a href="event-detail.php?id=<?php echo $sport_event_id ?>">
                              <div class="tour-mig-like-com">
                                  <div class="tour-mig-lc-img"> <img src="<?php echo $sport_event_avatar ?>" alt=""> </div>
                                  <div class="tour-mig-lc-con">
                                      <p class="text-center"><?php echo $sport_event_name ?></p>
                                  </div>
                              </div>
                          </a>


			                </div>

		                    <?php
		                      }
		                    } else {
		                    ?>
		                    <div class="item active">
		                    	<div class="tour-mig-like-com">
                            <div class="tour-mig-lc-img"> <img src="images/listing/home.jpg" alt=""> </div>
                            <div class="tour-mig-lc-con">
                                <p class="text-center">Chưa có sự kiện</p>
                            </div>
                          </div>
			                </div>
		                    <?php
		                    }
		                    ?>
		                </div>
                      <!-- Left and right controls -->
                      <a class="left carousel-control" href="#myCarousel3" data-slide="prev">
                        <span class="icon-prev"></span>
                        <span class="sr-only">Previous</span>
                      </a>
                      <a class="right carousel-control" href="#myCarousel3" data-slide="next">
                        <span class="icon-next"></span>
                        <span class="sr-only">Next</span>
                      </a>
                    </div>
              </div>
            </div>
        </div>
    </section>

<!--====== De Xuat ==========-->
    <section>
        <div class="rows pad-bot-redu tb-space">
            <div class="container" id="inner-page-title">
                <!-- TITLE & DESCRIPTION -->
                <div class="spe-title">
                    <h2>Sự kiện <span>đề xuất</span></h2>
                    <div class="title-line">
                        <div class="tl-1"></div>
                        <div class="tl-2"></div>
                        <div class="tl-3"></div>
                    </div>
                    <p>Các sự kiện hay cần xem</p>
                </div>
                <div class="slider-recommend rows">

                  <!-- <div class="col-md-4 col-sm-6 col-xs-12 b_packages">
                    <a href="#">
                      <div class="v_place_img">
                        <img src="images/t5.png" width="400" height="180" alt="Tour Booking" title="">
                      </div>
                      <div class="b_pack rows">
                          <div class="col-md-12 col-sm-12">
                            <h4 title="Tên sự kiện">sự kiện 1 có cái tên dài ơi là dài dài quá dài luôn</h4>
                          </div>
                      </div>
                    </a>
                  </div> -->

                  <?php
                    if (mysqli_num_rows($resultRecommend) > 0) {
                      while ($rowRecommend = mysqli_fetch_assoc($resultRecommend)) {
                        $id = $rowRecommend['id'];
                        $name = $rowRecommend['title'];
                        $image = $rowRecommend['avatar'];
                  ?>
                    <div class="col-md-4 col-sm-6 col-xs-12 b_packages">
                      <a href="event-detail.php?id=<?php echo $id ?>">
                        <div class="v_place_img">
                          <img src="<?php echo $image ?>" width="400" height="180" alt="Tour Booking" title="">
                        </div>
                        <div class="b_pack rows">
                            <div class="col-md-12 col-sm-12">
                              <h4 title="<?php echo $name ?>"><?php echo $name ?></h4>
                            </div>
                        </div>
                      </a>
                    </div>

                  <?php
                      }
                    } else {
                      # code...
                    }
                    
                  ?>


                </div>                
            </div>

        </div>

    </section>
    <!--HEADER SECTION-->
    <section class="conect">
        
            <div class="container ">                                  
                    <div class="tourz-search-1 tourz-search-2">
                        <div class="spe-title">
                            <h2>Cùng <span>Văn Lang</span> tổ chức sự kiện</h2>                   
                        </div>  
                        <div class="input-field">
                        	<a href="add-event.php" class="waves-effect waves-light tourz-sear-btn2">Tạo sự kiện</a>
                            <!-- <input type="submit" value="Tạo sự kiện" class="waves-effect waves-light tourz-sear-btn2">  -->
                        </div>
                    </div>                
            </div>        
    </section>
    <!--END HEADER SECTION-->
    
    <!--====== REQUEST A QUOTE ==========-->
    
    <!--====== REQUEST A QUOTE ==========-->
    
    <!--====== TIPS BEFORE TRAVEL ==========-->
   
    <!--====== FOOTER 1 ==========-->
  
    
<?php
include('footer.php');
?>

<script type="text/javascript">
  $('.slider-recommend').slick({
    // dots: true,
    slidesToShow: 4,
    slidesToScroll: 1,
    autoplay: true,
    autoplaySpeed: 2000,
    speed: 700,

    responsive: [
    {
      breakpoint: 1366,
      settings: {
        slidesToShow: 3,
      }
    },
    {
      breakpoint: 900,
      settings: {
        arrows: false,
        dots: true,
        slidesToShow: 2,
      }
    },
    {
      breakpoint: 480,
      settings: {
        arrows: false,
        dots: true,
        slidesToShow: 1,
      }
    }
    // You can unslick at a given breakpoint now by adding:
    // settings: "unslick"
    // instead of a settings object
  ]

  })


  $('#join-room-form').submit(function(e){
    e.preventDefault();
    var code = $('#event-code').val();

    if (code.replace(/\s+/g, ' ').trim().length != 4) {
      alert('Mã sự kiện 4 ký tự');
      $('#event-code').focus();
      return false;
    }

    $.ajax({
      url: 'process-question.php',
      method: 'POST',
      data: {'action': 'join-room', 'event-code': code}
    }).done(function(data){
      if (data.result) {
        code = data.message;
        window.location.href = 'room.php?id='+code;
      } else {
        alert(data.message);
      }
    })

  })
</script>