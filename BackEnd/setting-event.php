<?php
$title = 'Cài đặt sự kiện';
include('header.php');
if (isset($_GET["id"])) {
    $event_id = $_GET["id"];
    // $sqlCheckAuthor = "SELECT id FROM event WHERE id = ".$event_id." AND account_id = '".$account_id."'";
    if ($account_role == 4) {
        $sqlCheckAuthor = "SELECT id FROM event WHERE status != 5 AND id = $event_id";
    } else {
        $sqlCheckAuthor = "SELECT id FROM event WHERE status != 5 AND id = ".$event_id." AND account_id = ".$account_id." UNION SELECT e.id FROM event e, moderator m WHERE e.status !=5 AND e.id = m.event_id AND m.event_id = ".$event_id." AND m.email = '".$account_email."'";
    }
    
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
        // header('Location: javascript://history.go(-1)');
    }
} else {
    header("Location: my-events.php");
    // header('Location: javascript://history.go(-1)');
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
                        <?php
                        if (isset($account_role) && $account_role == 4) {
                        ?>
                        <li>
                            <a href="all-events.php"><i class="fa fa-calendar-check-o" aria-hidden="true"></i> Tất cả sự kiện</a>
                        </li>
                        <?php
                        }
                        ?>
                        <li>
                            <a href="my-events.php"><i class="fa fa-calendar" aria-hidden="true"></i> Sự kiện của tôi</a>
                        </li>

                        <?php
                        if (isset($is_mod) && $is_mod) {
                        ?>
                        <li>
                            <a href="my-support-events.php"><i class="fa fa-handshake-o" aria-hidden="true"></i> Sự kiện hỗ trợ</a>
                        </li>
                        <?php
                        }
                        ?>

                        <li>
                            <a href="my-registered-events.php"><i class="fa fa-check" aria-hidden="true"></i> Sự kiện đã đăng ký tham gia</a>
                        </li>

                        <?php 
                        if (isset($account_role) && $account_role == 2 || isset($account_role) && $account_role == 4) {
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
                                    <a href="#" class="full-btn btn btn-info waves-light waves-effect" data-toggle="modal" data-target="#moderator-modal"><i class="fa fa-plus-circle" aria-hidden="true"></i> Thêm người hỗ trợ</a>
                                </div>
                                <div class="input-field col s12 m6">
                                    <button type="submit" id="submit-btn" class="full-btn btn btn-success waves-light waves-effect"><i class="fa fa-check" aria-hidden="true"></i> Lưu</button>
                                </div>
                                <div class="input-field col s12 m6">
                                    <button type="button" onclick="window.history.back()" class="full-btn btn btn-danger waves-light waves-effect"><i class="fa fa-times" aria-hidden="true"></i> Huỷ</button>
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
                    <form id="add-moderator-form" method="POST" action="<?php  $_SERVER["PHP_SELF"] ?>">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title"> Thêm người hỗ trợ</h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="input-field col s12 m9">
                                        <!-- <input type="email" class="validate" id="email-mod" placeholder="Email người hỗ trợ" title="Email người hỗ trợ" maxlength="50" required="" style="height: 36px; padding-left: 10px;"> -->

                                        <input type="email" class="form-control" id="email-mod" placeholder="Email người hỗ trợ" title="Email người hỗ trợ" maxlength="50" required="">


                                    </div>
                                    <div class="input-field col s12 m3">
                                        <input type="hidden" id="event-id" name="event-id" value="<?php echo $event_id ?>">
                                        <button type="submit" class="full-btn btn btn-primary waves-light waves-effect" id="btn-add-moderator">Thêm</button>
                                    </div>
                                </div>
                                <hr>

                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Email</th>
                                            <th>Xóa</th>
                                        </tr>

                                    </thead>
                                    <tbody id="moderator-list">
                                        <?php
                                        $sqlGetMod = "SELECT * FROM moderator WHERE email != '".$account_email."' AND event_id = ".$event_id;
                                        $resultMod = mysqli_query($conn, $sqlGetMod);
                                        $count = 0;

                                        if (mysqli_num_rows($resultMod) > 0) {
                                            while ($rowMod = mysqli_fetch_assoc($resultMod)) {
                                                $count++;
                                                $id_table_mod = $rowMod["id"];
                                                $email_mod = $rowMod["email"];


                                        ?>
                                        <tr id="<?php echo $id_table_mod ?>">
                                            <td><?php echo $count ?></td>
                                            <td class="mod-email"><?php echo $email_mod ?></td>
                                            <td><button type="button" class="btn btn-danger btn-sm delete-moderator" title="Xoá người hỗ trợ"><i class="fa fa-trash-o"></i></button></td>
                                        </tr>

                                        <?php
                                            }
                                        } else {
                                        ?>
                                        <tr>
                                            <td colspan="3" class="text-center">Chưa có người hỗ trợ</td>
                                        </tr>

                                        <?php
                                        }
                                        ?>

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
                window.history.back();
            }else {
                console.log(data.error);
                console.log(data.sql)
            }
        }).fail(function(jqXHR, statusText, errorThrown){
            console.log("Fail:"+ jqXHR.responseText);
            console.log(errorThrown);
        })
    })


    $('#add-moderator-form').submit(function (e) {
        e.preventDefault();
        var email_mod = $('#email-mod').val();
        $.ajax({
            method: 'POST',
            dataType: 'json',
            url: 'process-my-event.php',
            data: {'action' : 'add-mod-cfg-event', 'event-id' : event_id, 'email-mod': email_mod},
        }).done(function(data){
            if(data.result){
                $('#email-mod').val('');
                getModList();
            } else {
                alert(data.message)
            }
        }).fail(function(jqXHR, statusText, errorThrown){
            console.log("Fail:"+ jqXHR.responseText);
            console.log(errorThrown);
        }).always(function(){
            // do something
        })
    })


    $('tbody#moderator-list').on('click', '.delete-moderator', function(e) {
        e.preventDefault();
        var id_table_mod = $(this).parents('tr').attr('id');
        var mod_email = $(this).parents('tr').find('.mod-email').text();

        var q = confirm('Bạn có muốn xóa người hỗ trợ: ' + mod_email);

        if (q) {
            $.ajax({
                method: 'POST',
                dataType: 'json',
                url: 'process-my-event.php',
                data: {'action' : 'delete-mod-cfg-event', 'id-table-mod' : id_table_mod},
            }).done(function(data){
                if(data.result){
                    getModList();
                }
            }).fail(function(jqXHR, statusText, errorThrown){
                console.log("Fail:"+ jqXHR.responseText);
                console.log(errorThrown);
            }).always(function(){
                // do something
            })
        }

    });

    var event_id = $('#event-id').val();

    // getModList(event_id, email_host);

    function getModList(){
        $.ajax({
            method: 'POST',
            dataType: 'json',
            url: 'process-my-event.php',
            data: {'action' : 'get-mod-list-cfg-event', 'event-id' : event_id},
        }).done(function(data){
            if(data.result){
                var rows = '';
                $.each(data.moderator, function(index, mod){
                    var count = index + 1;
                    rows += '<tr id="'+mod.id+'">';
                    rows += '<td>'+count+'</td>';
                    rows += '<td class="mod-email">'+mod.email+'</td>';
                    rows += '<td><button type="button" class="btn btn-danger btn-sm delete-moderator" title="Xoá người hỗ trợ"><i class="fa fa-trash-o"></i></button></td>';
                    rows += '</tr>';
                })
            }else {
                rows = '<tr><td colspan="3" class="text-center">Chưa có người hỗ trợ</td></tr>';
            }
            $("tbody#moderator-list").html(rows);
        }).fail(function(jqXHR, statusText, errorThrown){
            console.log("Fail:"+ jqXHR.responseText);
            console.log(errorThrown);
        }).always(function(){
            // do something
        })
    }
</script>