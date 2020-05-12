<?php
$title = 'Danh sách người tham dự';
include('header.php');
if (isset($_GET["id"])) {
    $event_id = $_GET["id"];
    // $sqlCheckAuthor = "SELECT id FROM event WHERE id = ".$event_id." AND account_id = '".$account_id."'";
    $sqlCheckAuthor = "SELECT id FROM event WHERE status != 5 AND id = ".$event_id." AND account_id = ".$account_id." UNION SELECT e.id FROM event e, moderator m WHERE e.status !=5 AND e.id = m.event_id AND m.event_id = ".$event_id." AND m.email = '".$account_email."'";
    $resultCheckAuthor = mysqli_query($conn, $sqlCheckAuthor);

    if (mysqli_num_rows($resultCheckAuthor) == 0) {
        header("Location: my-events.php");
    }
} else {
    header("Location: my-events.php");
}
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
                            <a href="my-registered-events.php"><i class="fa fa-check" aria-hidden="true"></i> Sự kiện đã đăng ký tham gia</a>
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
                    <div style="margin: 10px 15px;">
                        <?php
                        require("database-config.php");
                        $eventID = $_GET["id"];
                        $sqlInfo = "SELECT * FROM event WHERE id = ".$eventID;
                        $resultInfo = mysqli_query($conn, $sqlInfo);
                        $rowInfo = mysqli_fetch_assoc($resultInfo);

                        $sql_get_count = "SELECT
                        (SELECT COUNT(id) FROM attendee WHERE event_id = $event_id AND ticket_code != '') AS num_registered,
                        (SELECT COUNT(id) FROM attendee WHERE event_id = $event_id AND ticket_code != '' AND status = 1) AS num_joined,
                        (SELECT COUNT(id) FROM attendee WHERE event_id = $event_id AND ticket_code = '' AND status = 1) AS num_guest
                        FROM DUAL";

                        $result_get_count = mysqli_query($conn, $sql_get_count);
                        $row_count = mysqli_fetch_assoc($result_get_count);

                        $num_registered = $row_count["num_registered"];
                        $num_joined = $row_count["num_joined"];
                        $num_guest = $row_count["num_guest"];


                        ?>
                        <h5>Sự kiện: <?php echo $rowInfo["title"] ?></h5>
                        <!-- <p><i class="fa fa-map-marker"></i> <?php echo $rowInfo["place"] ?></p>
                        <p><i class="fa fa-hourglass-start"></i> <?php echo date("H:i - d/m/Y", strtotime($rowInfo["start_date"])) ?></p>
                        <p><i class="fa fa-hourglass-end"></i> <?php echo date("H:i - d/m/Y", strtotime($rowInfo["end_date"])) ?></p> -->

                        <h5>Số người đăng ký: <?php echo $num_registered ?></h5>
                        <h5>Số người tham dự: <?php echo $num_joined ?></h5>
                        <h5>Số người tham dự phát sinh: <?php echo $num_guest ?></h5>
                        
                    </div>
                    <a href="#" data-toggle="modal" data-target="#check-in-modal" class="btn btn-success waves-effect waves-light" style="margin: 10px 15px;">Điểm danh</a>

                    <div class="db-2-main-com db-2-main-com-table">
                        <table class="table table-hover" id="attendee-table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Tên người tham dự</th>
                                    <th>Email</th>
                                    <th>Mã tài khoản</th>
                                    <th>Loại tài khoản</th>
                                    <th>Trạng thái</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                require("database-config.php");
                                $eventID = $_GET["id"];
                                // $sqlAttendee = "SELECT ac.name, ac.code, at.id, at.email, at.status FROM attendee AS at, account AS ac WHERE at.email = ac.email AND event_id = ".$eventID;
                                $sqlAttendee = "SELECT ac.name, ac.code, at.id, at.email, at.ticket_code, at.status FROM attendee AS at LEFT JOIN account AS ac ON at.email = ac.email WHERE event_id = ".$eventID." ORDER BY at.id";
                                $resultAtt = mysqli_query($conn, $sqlAttendee);
                                if (mysqli_num_rows($resultAtt) > 0) {
                                    $count = 0;
                                    while ($rowAtt = mysqli_fetch_assoc($resultAtt)) {
                                        $count++;
                                        $id = $rowAtt["id"];
                                        $name = $rowAtt["name"];
                                        $email = $rowAtt["email"];
                                        $code = $rowAtt["code"];
                                        $ticket = $rowAtt["ticket_code"];

                                        if ($rowAtt["code"] == "") {
                                            if ((strstr($email, "@") == "@vanlanguni.vn")) {
                                                $code = strstr($email, "@", true);
                                                $type = "Văn Lang";
                                                $colorType = "event-reject";
                                            } else {
                                                $code = "######";
                                                $type = "Bên Ngoài";
                                                $colorType = 'event-wait';
                                            }

                                        } else {
                                            $code = $rowAtt["code"];
                                            $type = "Văn Lang";
                                            $colorType = 'event-reject';
                                        }

                                        switch ($rowAtt["status"]) {
                                            case 0:
                                                $status = "Chưa điểm danh";
                                                $colorStatus = "event-reject";
                                                $modal = "";
                                                break;
                                            case 1:
                                                $status = "Đã điểm danh";
                                                $colorStatus = "event-accept";
                                                $modal = "";

                                                if ($ticket == "") $status = "Đã điểm danh (phát sinh)";

                                                break;
                                            case 2:
                                                $status = "Chờ duyệt vé";
                                                $colorStatus = "event-wait";
                                                $modal = 'data-toggle="modal" data-target="#send-ticket-modal"';
                                                break;
                                        }
                                        

                                        ?>
                                        <tr id="<?php echo $id ?>">
                                            <td><?php echo $count ?></td>
                                            <td class="attendee-name"><?php echo $name ?></td>
                                            <td class="attendee-email"><?php echo $email ?></td>
                                            <td><?php echo $code ?></td>
                                            <td><span class="event-status <?php echo $colorType ?>"><?php echo $type ?></span></td>
                                            <!-- <td><span class="event-status <?php echo $colorStatus ?>"<?php $modal ?>><?php echo $status ?></span></td> -->
                                            <td><span class="event-status <?php echo $colorStatus ?> send-ticket" <?php echo $modal ?> ><?php echo $status ?></span></td>
                                        </tr>

                                        <?php
                                    }
                                } else {
                                    ?>
                                    <tr>
                                        <td class="text-center" colspan="6">Chưa có người tham dự</td>
                                    </tr>

                                    <?php
                                }
                                ?>
                                
                                    <!-- <tr>
                                        <td>1</td>
                                        <td>Bui Trung Tuan</td>
                                        <td><span class="db-done">đã quét</span></td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>Nguyen Huu Kha</td>
                                        <td><span class="db-not-done">chưa quét</span></td>
                                    </tr> -->

                                                               
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        
            <!--RIGHT SECTION-->
            
            <!-- Send Ticket -->
            <div id="send-ticket-modal" class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <!-- Modal content-->
                    <form id="" method="POST" action="<?php  $_SERVER["PHP_SELF"] ?>">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Duyệt vé</h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" id="id-table-attendee">
                                <input type="hidden" name="dname" id="dname">
                                <p>Bạn có muốn gửi vé tham dự sự kiện cho: <strong id="attendee-info"></strong> ?</p>             
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Hủy</button>
                                <button type="button" class="btn btn-success" data-dismiss="modal" id="btn-send-ticket">Gửi vé</button>
                            </div>
                        </div>
                    </form>
                </div>              
            </div>
            <!-- End Send Ticket -->

             <!-- Check in -->
            <div id="check-in-modal" class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title"> Điểm danh</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                            <ul class="nav nav-tabs nav-justified">
                                <li class="active">
                                    <a data-toggle="tab" href="#ticket-checkin">Có vé</a>
                                </li>
                                <li>
                                    <a data-toggle="tab" href="#no-ticket-checkin">Không có vé</a>
                                </li>
                            </ul>

                            <div class="tab-content">
                                <div id="ticket-checkin" class="tab-pane fade in active">
                                    <div class="input-field col s12 m3 text-center">
                                        <input type="hidden" id="event-id" value="<?php echo $event_id ?>">
                                        <p class="text-danger" id="no-internet" hidden>Không có kết nối internet không thể điểm danh</p>
                                        <div id="loadingMessage">🎥 Vui lòng cho phép truy cập camera</div>

        								<canvas id="canvas" hidden></canvas>
                                        <p class="text-danger" id="error-checkin"></p>
        								<div id="output" hidden>

        									<!-- <div id="outputMessage">No QR code detected.</div> -->

        									<!-- <div hidden><b>Data:</b> <span id="outputData"></span></div> -->

        								</div>
                                    </div>

                                </div>
                                <div id="no-ticket-checkin" class="tab-pane fade">
                                    <form id="checkin-no-ticket-form">
                                        <div class="row">
                                            <div class="input-field col s12 m9">
                                                <input type="email" class="form-control" name=" attendee-email" id="attendee-email" placeholder="Email người tham dự" title="Email người tham dự" required maxlength="40">
                                                <!-- <input type="text" name="attendee-code" id="attendee-code" placeholder="Mã sinh viên" title="Mã sinh viên" maxlength="50" required="" maxlength="20" style="height: 36px; padding-left: 10px;"> -->
                                            </div>
                                            <div class="input-field col s12 m3">
                                                <input type="hidden" name="action" value="checkin-no-ticket">
                                                <input type="hidden" name="event-id" value="<?php echo $event_id ?>">
                                                <button type="submit" class="full-btn btn btn-success waves-light waves-effect">Điểm danh</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                        </div>
                    </div>
                </div>              
            </div>
            <!-- End check in -->


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


    // $('#attendee-code').on('keydown keyup', function(e) {
    //     if (e.keyCode == 32) {
    //         return false;
    //     }
    // })

    // Check in no ticket
    $('#checkin-no-ticket-form').submit(function(e) {
        e.preventDefault();


        // if ($('#attendee-code').val().replace(/\s+/g, ' ').trim().length < 6) {
        //     alert('Mã sinh viên tối thiểu 6 kí tự');
        //     $('#attendee-code').focus();
        //     return false;
        // }

        var checkin_form = document.querySelector('#checkin-no-ticket-form');

        $.ajax({
            url: 'process-my-event.php',
            method: 'POST',
            dataType: 'json',
            processData: false,
            contentType: false,
            data: new FormData(checkin_form)

        }).done(function(data){
            if (data.result) {
                alert(data.message);
                $('#attendee-email').val('');
            }
        }).fail(function(jqXHR, statusText, errorThrown){
            console.log("Fail:"+ jqXHR.responseText);
            console.log(errorThrown);
        })
    })


</script>