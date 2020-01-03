<?php
$title = 'Danh sách người tham dự';
include('header.php');
if (isset($_GET["id"])) {
    $event_id = $_GET["id"];
    $sqlCheckAuthor = "SELECT id FROM event WHERE id = ".$event_id." AND account_id = '".$account_id."'";
    $resultCheckAuthor = mysqli_query($conn, $sqlCheckAuthor);

    if (mysqli_num_rows($resultCheckAuthor) == 0) {
        header("Location: my-events.php");
    }
} else {
    header("Location: my-events.php");
}
?>
    <!--DASHBOARD-->
    <section>
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
                                $sqlAttendee = "SELECT ac.name, ac.code, at.id, at.email, at.status FROM attendee AS at, account AS ac WHERE at.email = ac.email AND event_id = ".$eventID;
                                $resultAtt = mysqli_query($conn, $sqlAttendee);
                                if (mysqli_num_rows($resultAtt) > 0) {
                                    $count = 0;
                                    while ($rowAtt = mysqli_fetch_assoc($resultAtt)) {
                                        $count++;
                                        $id = $rowAtt["id"];
                                        $name = $rowAtt["name"];
                                        $email = $rowAtt["email"];
                                        $code = $rowAtt["code"];

                                        if ($rowAtt["code"] == "") {
                                            $code = "######";
                                            $type = "Bên Ngoài";
                                            $colorType = 'event-wait';
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
                                        <td class="text-center" colspan="3">Chưa có người tham dự</td>
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
            <div class="db-3">
                <h4>Thông tin sự kiện</h4>
                <ul>
                    <li>

                        <a href="#!"> <img src="images/icon/dbr1.jpg" alt="" />
                            <?php 
                            $sqlInfo = "SELECT * FROM event WHERE id = ".$eventID;
                            $resultInfo = mysqli_query($conn, $sqlInfo);
                            $rowInfo = mysqli_fetch_assoc($resultInfo);
                             ?>
                            <h5><?php echo $rowInfo["title"] ?></h5>
                            <p><i class="fa fa-map-marker"></i> <?php echo $rowInfo["place"] ?></p>
                            <p><i class="fa fa-hourglass-start"></i> <?php echo date("H:i - d/m/Y", strtotime($rowInfo["start_date"])) ?></p>
                            <p><i class="fa fa-hourglass-end"></i> <?php echo date("H:i - d/m/Y", strtotime($rowInfo["end_date"])) ?></p>
                            <!-- <p><i class="fa fa-phone"></i> 12356987</p> -->
                            
                        </a>
                    </li>
                    
                    
                </ul>
            </div>
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
        </div>
    </section>
    <!--END DASHBOARD-->
<?php

include('footer.php');
?>

<script type="text/javascript">
    $(document).ready( function (){
        $('#attendee-table').DataTable({
            responsive: false,
            language: {
                "sProcessing":   "Đang xử lý...",
                "sLengthMenu":   "Xem _MENU_ mục",
                "sZeroRecords":  "Không có kết quả",
                "sInfo":         "Đang xem _START_ đến _END_ trong tổng số _TOTAL_ mục",
                "sInfoEmpty":    "Đang xem 0 đến 0 trong tổng số 0 mục",
                "sInfoFiltered": "(được lọc từ _MAX_ mục)",
                "sInfoPostFix":  "",
                "sSearch":       "",
                "searchPlaceholder": "Tìm kiếm sự kiện",
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
</script>