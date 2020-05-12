<?php
$title = 'Quản lý câu hỏi';
include('header.php');
/*if (isset($_GET["id"])) {
    $event_id = $_GET["id"];
    $sqlCheckAuthor = "SELECT id FROM event WHERE id = ".$event_id." AND account_id = '".$account_id."'";
    $resultCheckAuthor = mysqli_query($conn, $sqlCheckAuthor);

    if (mysqli_num_rows($resultCheckAuthor) == 0) {
        header("Location: my-events.php");
    }
} else {
    header("Location: my-events.php");
}*/
?>
<style>
	#canvas {
		width: 80%;
		margin: 0 auto;
		border: 10px double #f79259;
		/*filter: brightness(1.4) grayscale(1) contrast(1.8);*/
	}

    #error-checkin {
        margin-bottom: 0;
        height: 20px;
    }

</style>
    <!--DASHBOARD-->
    <section>
        <audio>
            <source src="audio/beep.wav" type="audio/wav">
        </audio>
        <div class="db">
            <!--LEFT SECTION-->
            <div class="db-l db-2-com">
                <?php
                if (isset($_SESSION["user_email"])) {
                ?>
                <h4>Thông tin cá nhân</h4>
                <div class="db-l-2 info-fix-top">
                    <ul>
                        <li>
                            <p><?php echo $account_name ?></p>
                            <p><i class="fa fa-envelope"></i> <?php echo $account_email ?></p>
                            <p><i class="fa fa-th-large"></i> <?php echo $account_faculty_name ?></p>

                            
                        </li>
                        
                    </ul>
                </div>
                <?php
                }
                ?>


                <div class="db-l-2 <?php if (!isset($_SESSION['user_email'])) echo 'info-fix-top';?>">
                    <ul>
                        <li>
                            <a href="my-events.php"><i class="fa fa-calendar" aria-hidden="true"></i> Sự kiện của tôi</a>
                        </li>
                        <li>
                            <a href="my-events.php"><i class="fa fa-check" aria-hidden="true"></i> Sự kiện đã đăng ký tham gia</a>
                        </li>

                        <?php 
                        if (isset($account_role) && $account_role == 2) {
                        ?>

                        <li>
                            <a href="review-event.php"><i class="fa fa-hourglass-end" aria-hidden="true"></i> Duyệt sự kiện</a>
                        </li>
                        <?php
                        }
                        ?>
                    </ul>
                </div>
            </div>
            <!--CENTER SECTION-->
            <div class="db-2">
                <div class="db-2-com db-2-main">
                    <h4>Danh sách người tham dự</h4>
                    
                    <div class="db-2-main-com">
                      <section class="container">
                          <!-- Ask -->
                          <div class="row">
                            <div class="col-md-6">
                              <div class="col-md-8">
                                <p>Duyệt câu hỏi</p>
                              </div>
                              <div class="col-md-4">
                                <div class="custom-control custom-switch">
                                  <input type="checkbox" class="custom-control-input" id="customSwitches">
                                  <label class="custom-control-label" for="customSwitches">Chế độ Moderator</label>
                                </div>
                              </div>
                              
                            </div>
                            <div class="col-md-6">
                              
                            </div>
                          </div>
                        </section>

                        <section class="container-full">
                          <!-- Ask -->
                          <div class="row">
                            <div class=" col-md-6 manage-askquestion-border overflow-auto">
                              <div class="card w-75">
                                <div class="card-body askquestion">
                                  <h5 class="card-title">T160614</h5>
                                  <p class="card-text">Tại sao covid nhà trường không cho nghỉ mà bắt làm đồ án quài đm?</p>
                                  <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
                                  <button type="button" class="btn btn-warning"><i class="fa fa-pencil" aria-hidden="true"></i></button>
                                  <button type="button" class="btn btn-success"><i class="fa fa-check" aria-hidden="true"></i></button>

                                  <button type="button" class="btn btn-danger"><i class="fa fa-times" aria-hidden="true"></i></button>
                                </div>
                              </div>

                              <div class="card w-75">
                                <div class="card-body askquestion">
                                  <h5 class="card-title">T160614</h5>
                                  <p class="card-text">Truong lol bat lam do an quai</p>
                                  <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
                                  <button type="button" class="btn btn-success"><i class="fa fa-check" aria-hidden="true"></i></button>
                                  <button type="button" class="btn btn-danger"><i class="fa fa-times" aria-hidden="true"></i></button>
                                </div>
                              </div>
                              
                            </div>

                          <!-- Ask -->
                            <div class=" col-md-6 manage-askquestion-border overflow-auto">
                              <div class="card w-75">
                                <div class="card-body askquestion">
                                  <h5 class="card-title">T160614</h5>
                                  <p class="card-text">Tại sao covid nhà trường không cho nghỉ mà bắt làm đồ án quài đm?</p>
                                  <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
                                  <button type="button" class="btn btn-info">1 <i class="fa fa-heart" aria-hidden="true"></i></button>
                                  <a href="#" class="btn btn-success" data-toggle="modal" data-target="#reply-modal" title="Trả lời"><i class="fa fa-reply" ></i></a>

                                  <button type="button" class="btn btn-info"><i class="fa fa-thumb-tack" aria-hidden="true"></i></button>
                                </div>
                              </div>

                              <div class="card w-75">
                                <div class="card-body askquestion">
                                  <h5 class="card-title">T162302</h5>
                                  <p class="card-text">Tại sao covid nhà trường không cho nghỉ mà bắt làm đồ án quài đm?</p>
                                  <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
                                  <button type="button" class="btn btn-warning">0 <i class="fa fa-heart-o" aria-hidden="true"></i></button>
                                  <a href="#" class="btn btn-success" data-toggle="modal" data-target="#reply-modal" title="Trả lời"><i class="fa fa-reply" ></i></a>
                                  
                                  <button type="button" class="btn btn-light"><i class="fa fa-thumb-tack" aria-hidden="true"></i></button>
                                </div>
                              </div>
                              <div class="card w-75">
                                <div class="card-body askquestion">
                                  <h5 class="card-title">Stranger 3211</h5>
                                  <p class="card-text">Tại sao covid nhà trường không cho nghỉ mà bắt làm đồ án quài đm?</p>
                                  <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
                                </div>
                              </div>
                              <div class="card w-75">
                                <div class="card-body askquestion">
                                  <h5 class="card-title">Stranger 3570</h5>
                                  <p class="card-text">Tại sao covid nhà trường không cho nghỉ mà bắt làm đồ án quài đm?</p>
                                  <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
                                </div>
                              </div>
                            </div>
                          </div>
                        </section>  
                    </div>
                </div>
            </div>
        
            
            
            <!-- End Send Ticket -->

             <!-- Check in -->
            <!-- Reply Event Modal -->
            <div id="reply-modal" class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <!-- Modal content-->
                    <form id="delete-product-form" method="POST" action="<?php  $_SERVER["PHP_SELF"] ?>">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title"> Trả lời câu hỏi</h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <div class="card-body askquestion">
                                      <h5 class="card-title">T160614</h5>
                                      <p class="card-text">Tại sao covid nhà trường không cho nghỉ mà bắt làm đồ án quài đm?</p>
                                      <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
                                    </div>
                            </div>
                            <div class="modal-body">
                                 <div class="card w-75">
                                    <div class="card-body askquestion">
                                      <h5 class="card-title">Tú</h5>
                                      <p class="card-text">không em?</p>
                                      <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
                                    </div>
                                  </div>
                                  <div class="card w-75">
                                    <div class="card-body askquestion">
                                      <h5 class="card-title">Thầy Duy Cáp Ton</h5>
                                      <p class="card-text">thầy cho nghỉ học</p>
                                      <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
                                    </div>
                                  </div>       
                            </div>
                            
                            <div class="modal-footer">    
                                  <div class="col-md-10">
                                    <input type="text" class="form-control" placeholder="Trả lời" aria-label="Recipient's username" aria-describedby="basic-addon2">
                                    
                                  </div>
                                  <div class="col-md-2">
                                    <div class="input-group-append">
                                      <button class="btn btn-success" type="button">Button</button>
                                    </div>
                                    
                                  </div>
                             </div>   
                                  
                                
                            
                        </div>
                    </form>
                </div>              
            </div>
    </section>
    <!--END DASHBOARD-->
<?php

include('footer.php');
?>
<script src="vendor/jsQR/jsQR.js"></script>
<script type="text/javascript">
    $(document).ready( function (){
        $('#attendee-table').DataTable({
            responsive: true,
            language: {
                "sProcessing":   "Đang xử lý...",
                "sLengthMenu":   "Xem _MENU_ mục",
                "sZeroRecords":  "Không có kết quả",
                "sInfo":         "Đang xem _START_ đến _END_ trong tổng số _TOTAL_ mục",
                "sInfoEmpty":    "Đang xem 0 đến 0 trong tổng số 0 mục",
                "sInfoFiltered": "(được lọc từ _MAX_ mục)",
                "sInfoPostFix":  "",
                "sSearch":       "",
                "searchPlaceholder": "Tìm kiếm người tham dự",
                "sUrl":          "",
                "oPaginate": {
                    "sFirst":    "Đầu",
                    "sPrevious": "«",
                    "sNext":     "»",
                    "sLast":     "Cuối"
                }
            },
            "lengthMenu": [[10, 20, 50, -1], [10, 20, 50, "Tất cả"]]
        });
    });

    $('tbody').on('click', '.send-ticket', function(){
        var id = $(this).parents('tr').attr('id');
        if (id == undefined) var id = $(this).parents('tr').prev().attr('id');
        var name = $(this).parents('tr').find('.attendee-name').text();
        if (name == '') var name = $(this).parents('tr').prev().find('.attendee-name').text();
        var email = $(this).parents('tr').find('.attendee-email').text();
        if (email == '') var email = $(this).parents('tr').prev().find('.attendee-email').text();

        $('#attendee-info').html(name + " (" + email +")");
        $('#id-table-attendee').val(id);
    })

    $('#btn-send-ticket').click(function(){
        var id = $('#id-table-attendee').val();
        location.reload();
        $.ajax({
            url: 'send-ticket.php',
            method: 'POST',
            dataType: 'json',
            data: {'id-table-attendee': id}
        }).done(function(data){
            if(data.result){
                alert('Gửi vé thành công');
                location.reload();
            } else {
                console.log(data.error);
            }
        }).fail(function(jqXHR, statusText, errorThrown){
            console.log("Fail:"+ jqXHR.responseText);
            console.log(errorThrown);
        })
    })


    // check in

    var sound = $('audio')[0];

    var video = document.createElement("video");
    var canvasElement = document.getElementById("canvas");
    var canvas = canvasElement.getContext("2d");
    var loadingMessage = document.getElementById("loadingMessage");
    var outputContainer = document.getElementById("output");
    // var outputMessage = document.getElementById("outputMessage");
    // var outputData = document.getElementById("outputData");

    function drawLine(begin, end, color) {
        canvas.beginPath();
        canvas.moveTo(begin.x, begin.y);
        canvas.lineTo(end.x, end.y);
        canvas.lineWidth = 8;
        canvas.strokeStyle = color;
        canvas.stroke();
    }

    // Use facingMode: environment to attemt to get the front camera on phones
    function startCheckIn(){
        navigator.mediaDevices.getUserMedia({ video: { facingMode: "environment" } }).then(function(stream) {
            video.srcObject = stream;
            video.setAttribute("playsinline", true); // required to tell iOS safari we don't want fullscreen
            video.play();
            requestAnimationFrame(tick);
        });
    }

    function stopCheckIn(e) {
        var stream = video.srcObject;
        var tracks = stream.getTracks();
        for (var i = 0; i < tracks.length; i++) {
            var track = tracks[i];
            track.stop();
        }
        video.srcObject = null;
    }

    function tick() {
        loadingMessage.innerText = "⌛ Đang tải..."
        if (video.readyState === video.HAVE_ENOUGH_DATA) {
            loadingMessage.hidden = true;
            canvasElement.hidden = false;
            outputContainer.hidden = false;

            canvasElement.height = video.videoHeight;
            canvasElement.width = video.videoWidth;
            canvas.drawImage(video, 0, 0, canvasElement.width, canvasElement.height);
            var imageData = canvas.getImageData(0, 0, canvasElement.width, canvasElement.height);
            var code = jsQR(imageData.data, imageData.width, imageData.height, {
            inversionAttempts: "dontInvert",
            });
            if (code) {
                drawLine(code.location.topLeftCorner, code.location.topRightCorner, "#FF3B58");
                drawLine(code.location.topRightCorner, code.location.bottomRightCorner, "#FF3B58");
                drawLine(code.location.bottomRightCorner, code.location.bottomLeftCorner, "#FF3B58");
                drawLine(code.location.bottomLeftCorner, code.location.topLeftCorner, "#FF3B58");

                // Show result
                // outputMessage.hidden = true;
                // outputData.parentElement.hidden = false;
                // outputData.innerText = code.data;
                // alert('Đã thấy vé');
                // console.log(code.data)

                var event_id = $('#event-id').val();

                if (window.navigator.onLine == true) {
                    $.ajax({
    		            url: 'process-my-event.php',
    		            method: 'POST',
    		            dataType: 'json',
    		            data: {'action': 'checkin','event-id': event_id, 'ticket-code': code.data}
    		        }).done(function(data){
    		            if(data.result){
                            sound.play();
    		                alert(data.message);
                            $('#error-checkin').text('');
    		            } else {
    		                // alert(data.message);
                            $('#error-checkin').text(data.message);
                            setTimeout(function(){
                                $('#error-checkin').text('');
                            }, 1500)
    		            }
    		        }).fail(function(jqXHR, statusText, errorThrown){
    		            console.log("Fail:"+ jqXHR.responseText);
    		            console.log(errorThrown);
    		        })
                }



            } else {
                // outputMessage.hidden = false;
                // outputData.parentElement.hidden = true;
                // console.log('Not Found');
            }
        }
        requestAnimationFrame(tick);
    }


    $('#check-in-modal').on('shown.bs.modal', function(){
    	startCheckIn();
	});
    $('#check-in-modal').on('hidden.bs.modal', function(){
    	stopCheckIn();
        $('#error-checkin').text('');
	});

    setInterval(function(){
        if (window.navigator.onLine == true) {
            $('#no-internet').hide();
        } else {
            $('#no-internet').show();
        }
    },1000)


</script>