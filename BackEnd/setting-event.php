<?php
$title = 'Cài đặt sự kiện';
include('header.php');
if (isset($_GET["id"])) {
    $event_id = $_GET["id"];
    $sqlCheckAuthor = "SELECT id FROM event WHERE id = ".$event_id." AND account_id = '".$account_id."'";
    $resultCheckAuthor = mysqli_query($conn, $sqlCheckAuthor);

    if (mysqli_num_rows($resultCheckAuthor) > 0) {
        $sql = "SELECT e.*, COUNT(a.event_id) AS total_attendee FROM event e, attendee a WHERE e.id = a.event_id AND e.id = ".$event_id;
        $result = mysqli_query($conn, $sql);
        while ($row = mysqli_fetch_assoc($result)) {
            $name = $row["title"];
            $numTicket = $row["ticket_number"];
            $place = $row["place"];
            // $startTime = $row["start_date"];
            $startTime = date("H:i - d/m/Y", strtotime($row["start_date"]));
            // $endTime = $row["end_date"];
            $endTime = date("H:i - d/m/Y", strtotime($row["end_date"]));
            $make_question = $row["user_make_question"];
            $reply_question = $row["user_reply_question"];
            $total_attendee = $row["total_attendee"];
        }
    } else {
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
            <div class="db-l">
                <div class="db-l-1">
                    <ul>
                        <li><img src="images/db-profile.jpg" alt="" />
                        </li>
                        
                    </ul>
                </div>
                <div class="db-l-2">
                    <ul>
                        <li>
                            <a href="my-events.php"><i class="fa fa-calendar" aria-hidden="true"></i> Sự kiện của tôi</a>
                        </li>
                        <li>
                            <a href="my-registed-events.php"><i class="fa fa-check" aria-hidden="true"></i> Sự kiện đã đăng ký tham gia</a>
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
                    <h4>Cấu hình sự kiện</h4>
                    <div class="db-2-main-com db2-form-pay db2-form-com">
                        <form class="col s12" id="setting-event-form" method="POST" enctype="multipart/form-data">

                            <div class="row">

                                <div class="input-field col s12">
                                    <!-- <input type="text" class="validate" title="Tên sự kiện" value="" readonly=""> -->
                                    <p><b>Tên sự kiện:</b> <?php echo $name ?></p>
                                </div>
                                <div class="input-field col s12 m6">
                                    <!-- <input type="text" class="validate" title="Thời gian bắt đầu" value="" readonly=""> -->
                                    <p><b>Thời gian bắt đầu:</b> <?php echo $startTime ?></p>
                                </div>
                                <div class="input-field col s12 m6">
                                    <!-- <input type="text" class="validate" title="Thời gian kết thúc" value="" readonly=""> -->
                                    <p><b>Thời gian kết thúc:</b> <?php echo $endTime ?></p>
                                </div>
                                <div class="input-field col s12">
                                    <p><b>Số người đăng ký tham dự:</b> <?php echo $total_attendee ?></p>
                                </div>
                                <div class="input-field col s12 m6">
                                    <div class="checkbox checkbox-info checkbox-circle">
                                        <?php
                                        if ($make_question == 1) {
                                            echo '<input id="make-question" name="make-question" type="checkbox" value="1" checked>';
                                        } else {
                                            echo '<input id="make-question" name="make-question" type="checkbox" value="0">';
                                        }
                                        
                                        ?>
                                        <label for="make-question"> Cho phép người tham dự đặt câu hỏi</label>
                                    </div>
                                </div>
                                <div class="input-field col s12 m6">
                                    <div class="checkbox checkbox-info checkbox-circle">
                                        <?php
                                        if ($reply_question == 1) {
                                            echo '<input id="reply-question" name="reply-question" type="checkbox" value="1" checked>';
                                        } else {
                                            echo '<input id="reply-question" name="reply-question" type="checkbox" value="0">';
                                        }
                                        
                                        ?>
                                        <label for="reply-question"> Cho phép người tham dự trả lời câu hỏi</label>
                                    </div>
                                </div>
                            </div>
                            <br> 

                            <div class="row">
                                <input type="hidden" name="id" value="<?php echo $event_id ?>">
                                <input type="hidden" name="action" value="setting">
                                <div class="input-field col s12 m12">
                                    <a href="#" class="full-btn btn btn-info waves-light waves-effect" data-toggle="modal" data-target="#moderator-modal"><i class="fa fa-plus-circle" aria-hidden="true"></i> Thêm người hổ trợ</a>
                                </div>
                                <div class="input-field col s12 m6">
                                    <button type="submit" id="submit-btn" class="full-btn btn btn-success waves-light waves-effect"><i class="fa fa-check" aria-hidden="true"></i> Lưu</button>
                                </div>
                                <div class="input-field col s12 m6">
                                    <a href="my-events.php" class="full-btn btn btn-danger waves-light waves-effect"><i class="fa fa-times" aria-hidden="true"></i> Huỷ</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Add moderator -->
            <div id="moderator-modal" class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <!-- Modal content-->
                    <form id="" method="POST" action="<?php  $_SERVER["PHP_SELF"] ?>">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title"> Thêm người hổ trợ</h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" name="event-id" id="">

                                <div class="row">
                                    <div class="input-field col s12 m9">
                                        <input type="hidden" id="event-id" name="id" value="">
                                        <input type="text" class="validate" id="moderator-email" name="name" value="" required="" style="height: 36px;">
                                    </div>
                                    <div class="input-field col s12 m3">
                                        <button type="button" class="full-btn btn btn-primary waves-light waves-effect">Thêm</button>
                                    </div>
                                </div>
                                <hr>

                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Email</th>
                                            <th>Thao tác</th>
                                        </tr>

                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>tuanheotk@gmail.com</td>
                                            <td><button type="button" class="btn btn-danger delete-moderator" id="" title="Xoá người hổ trợ"><i class="fa fa-trash-o"></i></button></td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>tuanheo2@gmail.com</td>
                                            <td><button type="button" class="btn btn-danger delete-moderator" id="" title="Xoá người hổ trợ"><i class="fa fa-trash-o"></i></button></td>
                                        </tr>
                                    </tbody>
                                </table>


                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-success" data-dismiss="modal">Đóng</button>
                            </div>
                        </div>
                    </form>
                </div>              
            </div>
            <!-- End Moderator -->

            
        </div>
    </section>
    <!--END DASHBOARD-->
<?php

include('footer.php');
?>

<script type="text/javascript">

    
    $('input[type=checkbox]').on('click', function() {
        $(this).val(this.checked ? 1 : 0);
    })


    $('#setting-event-form').submit(function(e){
        e.preventDefault();        
        var settingEventForm = document.querySelector("#setting-event-form");

        $.ajax({
            url: 'process-my-event.php',
            method: 'POST',
            dataType: 'json',
            processData: false,
            contentType: false,
            data: new FormData(settingEventForm)

        }).done(function(data){
            console.log(data);
            if(data.result){
                window.location = 'my-events.php';
            }else {
                console.log(data.error);
                console.log(data.sql)
            }
        }).fail(function(jqXHR, statusText, errorThrown){
            console.log("Fail:"+ jqXHR.responseText);
            console.log(errorThrown);
        })
    })


    $('.delete-moderator').click(function(e) {
        e.preventDefault();
        alert('Đụ má xoá r đó')
    });
</script>