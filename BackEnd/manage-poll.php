<?php
$title = 'Quản lý bầu chọn';
include('header.php');
if (isset($_GET["id"])) {
    $event_id = $_GET["id"];
    // $sqlCheckAuthor = "SELECT id, title, check_question FROM event WHERE id = ".$event_id." AND account_id = '".$account_id."'";
    $sqlCheckAuthor = "SELECT id, title, check_question, user_make_question, user_reply_question FROM event WHERE status != 5 AND id = ".$event_id." AND account_id = ".$account_id." UNION SELECT e.id, e.title, e.check_question, e.user_make_question, e.user_reply_question FROM event e, moderator m WHERE e.status !=5 AND e.id = m.event_id AND m.event_id = ".$event_id." AND m.email = '".$account_email."'";
    $resultCheckAuthor = mysqli_query($conn, $sqlCheckAuthor);

    if (mysqli_num_rows($resultCheckAuthor) != 0) {
        $row_event_info = mysqli_fetch_assoc($resultCheckAuthor);
        $event_name = $row_event_info["title"];
        $check_question = $row_event_info["check_question"];
        $user_make_question = $row_event_info["user_make_question"];
        $user_reply_question = $row_event_info["user_reply_question"];

        // Function short title
        function shortTitle($title)
        {
            $space = 0;
            $end = 0;
            $shorted = "";
            $num_of_char = 10;

            for ($i = 0; $i < strlen($title); $i++) {
                if ($title[$i] == " ")
                    $space++;
                if ($space == $num_of_char) {
                    $end = $i;
                    break;
                }
            }
            
            if ($space < $num_of_char) {
                return $title;
            } else {
                $shorted = substr($title, 0, $end).'...';
                return $shorted;
            }

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
                    <h4>Quản lý bầu chọn (<?php echo shortTitle($event_name) ?>)</h4>
                    <input type="hidden" id="event-id" value="<?php echo $event_id ?>">
                    <input type="hidden" id="user-id" value="<?php echo $account_id ?>">
                    <input type="hidden" id="user-fullname" value="<?php echo $account_name ?>">
                    
                    <div class="db-2-main-com" id="fix-padding-bottom">
                        

                        <section class="container-full">
                            <div class="row" id="fix-margin">

                                <!-- List poll -->
                                <div class=" col-md-6 fix-lr-padding">
                                    <h4 class="text-center bg-danger" id="num-pending" data-toggle="modal" data-target="#create-poll-modal">Tạo danh sách bầu chọn <i class="fa fa-plus"></i></h4>

                                    <div class="col-md-12 askquestion-border" id="list-poll">
                                        <div class="card w-75 text-center">
                                            <!-- <div class="card-body askquestion">
                                                <input type="hidden" class="question-id" value="">
                                                <h5 class="card-title">Tiêu đề</h5>
                                                <p class="card-text">Số người bầu chọn</p>
                                                <p class="card-text"><small class="text-muted">Số lựa chọn tối đa</small></p>
                                                <a href="#" class="custom-btn custom-edit btn-edit-question" data-toggle="modal" data-target="#edit-poll-modal" title="Sửa câu hỏi"><i class="fa fa-pencil" ></i></a>
                                                <button type="button" data-toggle="modal" data-target="#delete-poll-modal" title="Xoá bầu chọn" class="custom-btn custom-del btn-deny-question"><i class="fa fa-times" aria-hidden="true"></i></button>
                                                <button type="button" class="custom-btn" title="Ẩn bầu chọn"><i class="fa fa-eye-slash" aria-hidden="true"></i></button>
                                                <button type="button" class="custom-btn" title="Hiển thị bầu chọn"><i class="fa fa-eye" aria-hidden="true"></i></button>
                                            </div> -->
                                            <i class="fa fa-spinner fa-spin"></i>
                                        </div>

                                        
                                        
                                    </div>

                                </div>
                                <!-- End list poll -->

                                <!-- Result poll-->
                                <div class=" col-md-6 fix-lr-padding">
                                    <h4 class="text-center bg-danger">Kết quả</h4>

                                    <div class="col-md-12 askquestion-border" id="result-poll">
                                        <!-- <div class="card w-75">
                                            <div class="card-body poll-card">
                                                <h5 class="card-title">Tiêu đề? </h5>

                                                <p>Cơm</p>
                                                <div class="progress">
                                                  <div class="progress-bar progress-bar-striped active progress-bar-success" role="progressbar" style="width: 15%;" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100">15%</div>
                                                </div>
                                                <p>Mì xào</p>
                                                <div class="progress">
                                                  <div class="progress-bar progress-bar-striped active progress-bar-success" role="progressbar" style="width: 25%;" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100">25%</div>
                                                </div>
                                                <p>Hải sản</p>
                                                <div class="progress">
                                                  <div class="progress-bar progress-bar-striped active progress-bar-success" role="progressbar" style="width: 45%;" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100">45%</div>
                                                </div>
                                                <p>Tôm hùm</p>
                                                <div class="progress">
                                                  <div class="progress-bar progress-bar-striped active progress-bar-success" role="progressbar" style="width: 15%;" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100">15%</div>
                                                </div>
                                            </div>
                                        </div> -->
                                        <h3 class="text-center">Chọn để hiển thị</h3>
                                    </div>
                                </div>
                                <!-- End list poll -->
                            </div>
                        </section>  
                    </div>
                </div>
            </div>
            

            <!-- Create Poll Modal -->
            <div id="create-poll-modal" class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <!-- Modal content-->
                    <form method="POST" id="create-poll-form"> action="<?php  $_SERVER["PHP_SELF"] ?>">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h5>Tạo cuộc bầu chọn mới</h5>
                            </div>

                            <div class="modal-body container-fluid">
                                <div class="col-md-12">
                                    <div class="input-field">
                                        <input type="text" name="" class="form-control" id="poll-title" placeholder="Bạn muốn khảo sát điều gì" title="Tiêu đề" maxlength="200" required>
                                    </div>
                                </div>
                                

                                <div id="list-option">

                                    <div class="col-md-12 one-option" id="option-1">
                                        <div class="input-group">
                                            <input type="text" class="form-control poll-option-content" placeholder="Lựa chọn" title="Lựa chọn" maxlength="100" required>
                                            <div class="input-group-btn">
                                                <button class="btn btn-danger btn-delete-option" type="button"><i class="fa fa-times"></i></button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12 one-option" id="option-2">
                                        <div class="input-group">
                                            <input type="text" class="form-control poll-option-content" placeholder="Lựa chọn" title="Lựa chọn" maxlength="100" required>
                                            <div class="input-group-btn">
                                                <button class="btn btn-danger btn-delete-option" type="button"><i class="fa fa-times"></i></button>
                                            </div>
                                        </div>
                                    </div>                               
                                    
                                </div>

                                <div class="col-md-12">
                                    <button class="btn btn-success" type="button" id="btn-add-option">Thêm lựa chọn</button>
                                </div>

                                <div class="col-md-12">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="allow-multi-choice" value="0">
                                        <label class="custom-control-label" for="allow-multi-choice">Cho phép chọn nhiều lựa chọn</label>
                                    </div>
                                </div>

                                <div class="col-md-2 col-sm-2 col-xs-3">
                                    <input type="number" class="form-control hidden" name="" id="max-choice" value="2" min="2" max="2" title="Số lựa chọn tối đa">
                                </div>
                            </div>
                            
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-success">Tạo</button>
                            </div>  
                        </div>
                    </form>
                </div>             
            </div>


            <!-- Edit Poll Modal -->
            <div id="edit-poll-modal" class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <!-- Modal content-->
                    <form method="POST" id="edit-poll-form" action="<?php  $_SERVER["PHP_SELF"] ?>">
                        <input type="hidden" id="poll-id-update">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h5>Sửa cuộc bầu chọn</h5>
                            </div>

                            <div class="modal-body container-fluid">
                                <div class="col-md-12">
                                    <div class="input-field">
                                        <input type="text" name="" class="form-control" id="poll-title-update" placeholder="Bạn muốn khảo sát điều gì" title="Tiêu đề" maxlength="200" required>
                                    </div>
                                </div>
                                

                                <div id="list-option-update">
                                    <div class="col-md-12 one-option text-center">
                                        <!-- <div class="input-group">
                                            <input type="text" class="form-control poll-option-content" placeholder="Lựa chọn" maxlength="100" required>
                                            <div class="input-group-btn">
                                                <button class="btn btn-danger btn-delete-option-update" type="button"><i class="fa fa-times"></i></button>
                                            </div>
                                        </div> -->
                                        <i class="fa fa-spinner fa-spin"></i>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <button class="btn btn-success" type="button" id="btn-add-option-update">Thêm lựa chọn</button>
                                </div>

                                <div class="col-md-12">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="allow-multi-choice-update" value="0">
                                        <label class="custom-control-label" for="allow-multi-choice-update">Cho phép chọn nhiều lựa chọn</label>
                                    </div>
                                </div>

                                <div class="col-md-2 col-sm-2 col-xs-3">
                                    <input type="number" class="form-control hidden" name="" id="max-choice-update" value="2" min="2" max="2" title="Số lựa chọn tối đa">
                                </div>
                            </div>
                            
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-success">Lưu</button>
                            </div>  
                        </div>
                    </form>
                </div>             
            </div>
            <!-- Delete Poll -->
            <div id="delete-poll-modal" class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <!-- Modal content-->
                    <form id="delete-poll-form" method="POST" action="<?php  $_SERVER["PHP_SELF"] ?>">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title"> Xoá bầu chọn</h4>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" id="poll-delete-id">
                                <p>Bạn có muốn xóa bầu chọn: <strong id="poll-delete-name"></strong> ?</p>             
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Hủy</button>
                                <button type="submit" class="btn btn-danger">Xóa</button>
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
<script type="text/javascript">

    // // Pusher
    var pusher2 = new Pusher('71289e96793d3248d6ec', {
        cluster: 'ap1',
        forceTLS: true
    });

    // Get poll
    get_all_poll();

    var event_id = $('#event-id').val();


    // Realtime get all poll
    var channel_poll = pusher2.subscribe('manage-poll-'+event_id);
    channel_poll.bind('all-poll', function(data) {
        // console.log(data);

        var poll_selected_id = $('.poll-selected').find('.poll-id').val();
        
        // Load all poll
        if (data.result) {
            var rows = '';
            $.each(data.poll, function(index, p) {

                rows+= '<div class="card w-75">';

                if (p.status == 1) {
                    rows+= '<div class="card-body askquestion one-poll">';
                } else {
                    rows+= '<div class="card-body askquestion one-poll" title="Bầu chọn này đã bị ẩn">';
                }

                rows+= '<input type="hidden" class="poll-id" value="'+p.id+'">';
                rows+= '<input type="hidden" class="poll-max-choice" value="'+p.max_choice+'">';
                
                if (p.status == 1) {
                    rows+= '<h5 class="card-title">'+p.title+'</h5>';
                    rows+= '<p class="card-text">Số phiếu bầu: '+p.votes+'</p>';
                    rows+= '<p class="card-text"><small class="text-muted">Số lựa chọn tối đa: '+p.max_choice+'</small></p>';
                } else {
                    rows+= '<h5 class="card-title poll-blur">'+p.title+'</h5>';
                    rows+= '<p class="card-text poll-blur">Số phiếu bầu: '+p.votes+'</p>';
                    rows+= '<p class="card-text poll-blur"><small class="text-muted">Số lựa chọn tối đa: '+p.max_choice+'</small></p>';
                }

                rows+= '<button class="custom-btn custom-edit btn-edit-poll" data-toggle="modal" data-target="#edit-poll-modal" title="Sửa bầu chọn"><i class="fa fa-pencil"></i></button>';
                rows+= '<button type="button" data-toggle="modal" data-target="#delete-poll-modal" title="Xoá bầu chọn" class="custom-btn custom-del btn-delete-poll"><i class="fa fa-times" aria-hidden="true"></i></button>';

                if (p.status == 1) {
                    rows+= '<button type="button" class="custom-btn btn-hide-poll" title="Ẩn bầu chọn"><i class="fa fa-eye-slash" aria-hidden="true"></i></button>';
                } else {
                    rows+= '<button type="button" class="custom-btn custom-del btn-show-poll" title="Hiển thị bầu chọn"><i class="fa fa-eye" aria-hidden="true"></i></button>';
                }
                rows+= '</div>';                   
                rows+= '</div>';                   
            })
        } else {
            rows = '<div class="card w-75"><h3 class="text-center">chưa có bầu chọn</h3></div>';
        }
        $('#list-poll').html(rows);

        // Add selected for poll
        if (poll_selected_id != undefined) {
            $('input.poll-id[value="'+poll_selected_id+'"]').parent('div').addClass('poll-selected');
        }
    })



    // Change checkbox
    $('input[type=checkbox]').on('click', function() {
        $(this).val(this.checked ? 1 : 0);

    })

    // Change select multi choice
    $('#allow-multi-choice').click(function(){
        var value = $(this).val();

        if (value == 0) {
            $('#max-choice').addClass('hidden');
        } else {
            $('#max-choice').removeClass('hidden');
        }
    })

    // Change select multi choice update
    $('#allow-multi-choice-update').click(function(){
        var value = $(this).val();

        if (value == 0) {
            $('#max-choice-update').addClass('hidden');
        } else {
            $('#max-choice-update').removeClass('hidden');
        }
    })


    // Add option
    var option_id = 3;
    $('#btn-add-option').click(function(){
        var count = $('#list-option div.one-option').length;

        // Set max choice
        if (count == 10) {
            $('#max-choice').attr('max', count);
        }else {
            $('#max-choice').attr('max', count+1);
        }

        if (count < 10) {
            var rows = '';
            rows += '<div class="col-md-12 one-option" id="option-'+option_id+'">';
            rows += '<div class="input-group">';
            rows += '<input type="text" class="form-control poll-option-content" placeholder="Lựa chọn" title="Lựa chọn" maxlength="100" required>';
            rows += '<div class="input-group-btn">';
            rows += '<button class="btn btn-danger btn-delete-option" type="button"><i class="fa fa-times"></i></button>';
            rows += '</div>';
            rows += '</div>';
            rows += '</div>';

            $('#list-option').append(rows);
            option_id++;
        } else {
            alert('Tối đa 10 lựa chọn');
        }
    })

    // Add option for update
    // var option_id = 3;
    $('#btn-add-option-update').click(function(){
        var count = $('#list-option-update div.one-option').length;

        // Set max choice
        if (count == 10) {
            $('#max-choice-update').attr('max', count);
        }else {
            $('#max-choice-update').attr('max', count+1);
        }

        if (count < 10) {
            var rows = '';
            rows += '<div class="col-md-12 one-option" id="update-option-'+option_id+'">';
            rows += '<div class="input-group">';
            rows += '<input type="text" class="form-control poll-option-content" placeholder="Lựa chọn" title="Lựa chọn" maxlength="100" required>';
            rows += '<div class="input-group-btn">';
            rows += '<button class="btn btn-danger btn-delete-option-update" type="button"><i class="fa fa-times"></i></button>';
            rows += '</div>';
            rows += '</div>';
            rows += '</div>';

            $('#list-option-update').append(rows);
            option_id++;
        } else {
            alert('Tối đa 10 lựa chọn');
        }
    })

    // Delete option
    $('body').on('click', '.btn-delete-option', function(){
        var div_id = $(this).parent('div').parent('div').parent('div').attr('id');

        var count = $('#list-option div.one-option').length;

        if (count == 2) {
            alert('Tối thiểu 2 lựa chọn');
        } else {
            $('#list-option #'+div_id).remove();


            // set value max
            var current_max_choice = $('#max-choice').val()
            if (current_max_choice > count-1) $('#max-choice').val(count-1);

            // Set attribute max choice
            $('#max-choice').attr('max', count-1);

        }

    })


    // Delete option update
    $('body').on('click', '.btn-delete-option-update', function(){
        var div_id = $(this).parent('div').parent('div').parent('div').attr('id');

        var count = $('#list-option-update div.one-option').length;

        if (count == 2) {
            alert('Tối thiểu 2 lựa chọn');
        } else {
            $('#list-option-update #'+div_id).remove();


            // set value max update
            var current_max_choice = $('#max-choice-update').val()
            if (current_max_choice > count-1) $('#max-choice-update').val(count-1);

            // Set attribute max choice update
            $('#max-choice-update').attr('max', count-1);

        }

    })

    // Submit create poll
    $('#create-poll-form').on('submit', function(e){
        e.preventDefault();

        var event_id = $('#event-id').val();

        var poll_title = $('#poll-title').val();

        if ($('#allow-multi-choice').val() == 0) {
            var max_choice = 1;
        } else {
            var max_choice = $('#max-choice').val();
        }

        var list_option = new Array();
        $('#list-option div.one-option').each(function(){

            var option = {};
            option.content = $(this).find('.poll-option-content').val();
            list_option.push(option);
        })

        var error;

        // Check title
        if (poll_title.replace(/\s+/g, ' ').trim().length < 10) {
            alert('Tiêu đề tối thiểu 10 ký tự');
            $('#poll-title').focus();
            error = true;
            return false;
        }

        // Check list option
        $('#list-option .poll-option-content').each(function(){
            if ($(this).val().replace(/\s+/g, ' ').trim().length < 1) {
                alert('Lựa chọn tối thiểu 1 ký tự');
                $(this).focus();
                error = true;
                return false;
            }
        })

        // Check max choice

        if(max_choice < 1|| max_choice > $('#list-option div.one-option').length) {
            alert('Số lựa chọn tối đa không hợp lệ');
            error = true;
            $('#max-choice').focus();
            return false;
        }


        if (error) return false;

        // Add loading
        $(this).find('button[type="submit"]').html('<i class="fa fa-spinner fa-spin"></i>');


        $.ajax({
            url: 'process-poll.php',
            method: 'POST',
            data: {'action': 'add', 'event-id': event_id, 'poll-title': poll_title, 'max-choice': max_choice, 'list-option': list_option}
        }).done(function(data){
            if (data.result) {
                // Reset form
                $('#create-poll-form')[0].reset();
                $('#max-choice').addClass('hidden');

                var df = '<div class="col-md-12 one-option" id="option-1"><div class="input-group"><input type="text" class="form-control poll-option-content" placeholder="Lựa chọn" title="Lựa chọn" maxlength="100" required><div class="input-group-btn"><button class="btn btn-danger btn-delete-option" type="button"><i class="fa fa-times"></i></button></div></div></div>';
                df+=df;

                $('#list-option').html(df);

                $('#create-poll-modal').modal('hide');

                get_all_poll();

                refresh_published_poll()
            }
        }).fail(function(jqXHR, statusText, errorThrown){
              console.log("Fail:"+ jqXHR.responseText);
              console.log(errorThrown);
        })
    })

    // Reset modal add poll
    $('#create-poll-modal').on('hidden.bs.modal', function(){
        $(this).find('button[type="submit"]').html('Tạo');
    })


    // Select poll to view result
    $('body').on('click', '.one-poll', function(){

        // Remove class selected for other div
        $('#list-poll .one-poll').removeClass('poll-selected');
        
        // Add class selected
        $(this).addClass('poll-selected');

        // Add loading
        $('#result-poll').html('<h3 class="text-center"><i class="fa fa-spinner fa-spin"></i></h3>')

        var poll_id = $(this).find('.poll-id').val();
        // var poll_title = $(this).find('.card-title').text();

        show_result_poll(poll_id);

        // Realtime result poll
        var channel_poll_2 = pusher2.subscribe('result-poll');
        channel_poll_2.bind('poll-'+poll_id, function(data) {
            
            // Show result
            if (data.result) {
                var rows = '';
                // rows+= '<div class="col-md-12 askquestion-border">';
                rows+= '<div class="card w-75">';
                rows+= '<div class="card-body poll-card">';
                rows+= '<h5 class="card-title">'+data.poll_title+'</h5>';

                var total = 0;
                $.each(data.list_option, function(index, o) {
                    total+= parseInt(o.num_vote);
                })

                $.each(data.list_option, function(index, o) {

                    var percent = o.num_vote*100/total;
                    percent =  Math.round(percent * 100) / 100;

                    if (total == 0) percent = 0;

                    rows+= '<p>'+o.content+'</p>';
                    rows+= '<div class="progress">';
                    rows+= '<div class="progress-bar progress-bar-striped active progress-bar-success" role="progressbar" style="width: '+percent+'%;" aria-valuenow="'+percent+'" aria-valuemin="0" aria-valuemax="100">'+percent+'%</div>';
                    rows+= '</div>';
                })
                
                rows+= '</div>';
                rows+= '</div>';
                // rows+= '</div>';
            } else {
                rows = '<h3 class="text-center">Chọn để hiển thị</h3>';
            }
            $('#result-poll').html(rows);
        })
    })


    // Click edit poll
    $('body').on('click', '.btn-edit-poll', ':not(.one-poll)', function(e){
        e.stopPropagation();

        var poll_id = $(this).parent('div').find('.poll-id').val();
        var poll_title = $(this).parent('div').find('.card-title').text();
        var poll_max_choice = $(this).parent('div').find('.poll-max-choice').val();

        // Set title
        $('#poll-id-update').val(poll_id);
        $('#poll-title-update').val(poll_title);

        // Load list option
        $.ajax({
            url: 'process-poll.php',
            method: 'POST',
            data: {'action': 'get-list-option', 'poll-id': poll_id}
        }).done(function(data){
            if (data.result) {
                var rows = '';
                var num_option = 0;
                $.each(data.list_option, function(index, o) {
                    num_option++;
                    rows+= '<div class="col-md-12 one-option" id="'+o.id+'">';
                    rows+= '<div class="input-group">';
                    rows+= '<input type="text" class="form-control poll-option-content" placeholder="Lựa chọn" title="Lựa chọn" maxlength="100" required value="'+o.content+'">';
                    rows+= '<div class="input-group-btn">';
                    rows+= '<button class="btn btn-danger btn-delete-option-update" type="button"><i class="fa fa-times"></i></button>';
                    rows+= '</div>';
                    rows+= '</div>';
                    rows+= '</div>';
                })
            }

            $('#list-option-update').html(rows);

            // Set max choice
            if (poll_max_choice > 1) {
                $('#allow-multi-choice-update').val(1).prop('checked', true);
                $('#max-choice-update').val(poll_max_choice).attr('max', num_option).removeClass('hidden');
            } else {
                $('#allow-multi-choice-update').val(0).prop('checked', false);
                $('#max-choice-update').val(2).attr('max', num_option).addClass('hidden');
            }
        })
        $('#edit-poll-modal').modal();
    })

    // Sumbit edit poll
    $('#edit-poll-form').on('submit', function(e) {
        e.preventDefault();

        var event_id = $('#event-id').val();
        var poll_id = $('#poll-id-update').val();
        var poll_title = $('#poll-title-update').val();

        var poll_selected_id = $('.poll-selected').find('.poll-id').val();

        if ($('#allow-multi-choice-update').val() == 0) {
            var max_choice = 1;
        } else {
            var max_choice = $('#max-choice-update').val();
        }

        var list_option = new Array();
        $('#list-option-update div.one-option').each(function(){

            var option = {};
            option.id = $(this).attr('id');
            // option.id = $(this).find('.poll-option-id').val();
            option.content = $(this).find('.poll-option-content').val();
            list_option.push(option);
        })

        var error;

        // Check title
        if (poll_title.replace(/\s+/g, ' ').trim().length < 10) {
            alert('Tiêu đề tối thiểu 10 ký tự');
            $('#poll-title-update').focus();
            error = true;
            return false;
        }

        // Check list option
        $('#list-option-update .poll-option-content').each(function(){
            if ($(this).val().replace(/\s+/g, ' ').trim().length < 1) {
                alert('Lựa chọn tối thiểu 1 ký tự');
                $(this).focus();
                error = true;
                return false;
            }
        })

        // Check max choice

        if(max_choice < 1|| max_choice > $('#list-option-update div.one-option').length) {
            alert('Số lựa chọn tối đa không hợp lệ');
            error = true;
            $('#max-choice-update').focus();
            return false;
        }


        if (error) return false;

        // Add loading
        $(this).find('button[type="submit"]').html('<i class="fa fa-spinner fa-spin"></i>');



        $.ajax({
            url: 'process-poll.php',
            method: 'POST',
            data: {'action': 'edit', 'event-id': event_id, 'poll-id': poll_id, 'poll-title': poll_title, 'max-choice': max_choice, 'list-option': list_option}
        }).done(function(data){
            if (data.result) {
                // Reset form
                // $('#create-poll-form')[0].reset();
                // $('#max-choice').addClass('hidden');

                $('#edit-poll-modal').modal('hide');

                // Reload list
                get_all_poll();

                // Reload list poll user page
                refresh_published_poll();

                // Refresh
                // refresh_result_poll(poll_id);

                // Reload result if this poll is selected
                // if (poll_id == poll_selected_id) show_result_poll(poll_id);


            }
        }).fail(function(jqXHR, statusText, errorThrown){
              console.log("Fail:"+ jqXHR.responseText);
              console.log(errorThrown);
        })

    })

    // Reset edit poll modal
    $('#edit-poll-modal').on('hidden.bs.modal', function(){
        $('#poll-title-update').val('')
        $('#list-option-update').html('<div class="col-md-12"><i class="fa fa-spinner fa-spin"></i></div>');

        $('#allow-multi-choice-update').val(0).prop('checked', false);
        $('#max-choice-update').val(2).attr('max', 2).addClass('hidden');

        // Add loading
        $(this).find('button[type="submit"]').html('Lưu');
    })

    // Click delete poll
    $('body').on('click', '.btn-delete-poll', ':not(.one-poll)', function(e){
        e.stopPropagation();

        var poll_id = $(this).parent('div').find('.poll-id').val();
        var poll_title = $(this).parent('div').find('.card-title').text();
        // alert(poll_id)

        $('#poll-delete-id').val(poll_id);
        $('#poll-delete-name').text(poll_title);

        $('#delete-poll-modal').modal();
    })

    // Sumbit delete poll form
    $('#delete-poll-form').on('submit', function(e){
        e.preventDefault();

        var poll_id = $('#poll-delete-id').val();
        var poll_selected_id = $('.poll-selected').find('.poll-id').val();


        // Add loading
        $(this).find('button[type="submit"]').html('<i class="fa fa-spinner fa-spin"></i>');

        $.ajax({
            url: 'process-poll.php',
            method: 'POST',
            data: {'action': 'delete', 'poll-id': poll_id}
        }).done(function(data){
            if (data.result) {
                // Close modal
                $('#delete-poll-modal').modal('hide');
                // Reload list poll
                get_all_poll();

                // Reload list poll user page
                refresh_published_poll()

                // Reset view result poll
                if (poll_id == poll_selected_id) show_result_poll(poll_id);
            }
        })
    })


    // Reset modal delete poll
    $('#delete-poll-modal').on('hidden.bs.modal', function(){
        $(this).find('button[type="submit"]').html('Xoá');
    })

    // Click hide poll
    $('body').on('click', '.btn-hide-poll', ':not(.one-poll)', function(e){
        e.stopPropagation();

        // Add loading
        $(this).html('<i class="fa fa-spinner fa-spin"></i>');

        var poll_id = $(this).parent('div').find('.poll-id').val();

        $.ajax({
            url: 'process-poll.php',
            method: 'POST',
            data: {'action': 'hide', 'poll-id': poll_id}
        }).done(function(data){
            if (data.result) {
                get_all_poll();

                // Reload list poll user page
                refresh_published_poll()
            }
        })
    })

    // Show poll
    $('body').on('click', '.btn-show-poll', ':not(.one-poll)', function(e){
        e.stopPropagation();

        // Add loading
        $(this).html('<i class="fa fa-spinner fa-spin"></i>');

        var poll_id = $(this).parent('div').find('.poll-id').val();

        $.ajax({
            url: 'process-poll.php',
            method: 'POST',
            data: {'action': 'show', 'poll-id': poll_id}
        }).done(function(data){
            if (data.result) {
                get_all_poll();
                
                // Reload list poll user page
                refresh_published_poll()
            }
        })
    })



    function get_all_poll(){
        var event_id = $('#event-id').val();

        var poll_selected_id = $('.poll-selected').find('.poll-id').val();

        $.ajax({
            url: 'process-poll.php',
            method: 'POST',
            data: {'action': 'get-all-poll', 'event-id': event_id}
        }).done(function(data){
            if (data.result) {
                var rows = '';
                $.each(data.poll, function(index, p) {

                    rows+= '<div class="card w-75">';

                    if (p.status == 1) {
                        rows+= '<div class="card-body askquestion one-poll">';
                    } else {
                        rows+= '<div class="card-body askquestion one-poll" title="Bầu chọn này đã bị ẩn">';
                    }

                    rows+= '<input type="hidden" class="poll-id" value="'+p.id+'">';
                    rows+= '<input type="hidden" class="poll-max-choice" value="'+p.max_choice+'">';
                    
                    if (p.status == 1) {
                        rows+= '<h5 class="card-title">'+p.title+'</h5>';
                        rows+= '<p class="card-text">Số phiếu bầu: '+p.votes+'</p>';
                        rows+= '<p class="card-text"><small class="text-muted">Số lựa chọn tối đa: '+p.max_choice+'</small></p>';
                    } else {
                        rows+= '<h5 class="card-title poll-blur">'+p.title+'</h5>';
                        rows+= '<p class="card-text poll-blur">Số phiếu bầu: '+p.votes+'</p>';
                        rows+= '<p class="card-text poll-blur"><small class="text-muted">Số lựa chọn tối đa: '+p.max_choice+'</small></p>';
                    }

                    rows+= '<button class="custom-btn custom-edit btn-edit-poll" data-toggle="modal" data-target="#edit-poll-modal" title="Sửa bầu chọn"><i class="fa fa-pencil"></i></button>';
                    rows+= '<button type="button" data-toggle="modal" data-target="#delete-poll-modal" title="Xoá bầu chọn" class="custom-btn custom-del btn-delete-poll"><i class="fa fa-times" aria-hidden="true"></i></button>';

                    if (p.status == 1) {
                        rows+= '<button type="button" class="custom-btn btn-hide-poll" title="Ẩn bầu chọn"><i class="fa fa-eye-slash" aria-hidden="true"></i></button>';
                    } else {
                        rows+= '<button type="button" class="custom-btn custom-del btn-show-poll" title="Hiển thị bầu chọn"><i class="fa fa-eye" aria-hidden="true"></i></button>';
                    }
                    rows+= '</div>';                   
                    rows+= '</div>';                   
                })
            } else {
                rows = '<div class="card w-75"><h3 class="text-center">Chưa có bầu chọn</h3></div>';
            }
            $('#list-poll').html(rows);

            // Add selected for poll
            if (poll_selected_id != undefined) {
                $('input.poll-id[value="'+poll_selected_id+'"]').parent('div').addClass('poll-selected');
            }
        }).fail(function(jqXHR, statusText, errorThrown){
              console.log("Fail:"+ jqXHR.responseText);
              console.log(errorThrown);
        })
    }


    function show_result_poll(poll_id) {
        $.ajax({
            url: 'process-poll.php',
            method: 'POST',
            data: {'action': 'show-result-poll', 'poll-id': poll_id}
        }).done(function(data){
            if (data.result) {
                var rows = '';
                // rows+= '<div class="col-md-12 askquestion-border">';
                rows+= '<div class="card w-75">';
                rows+= '<div class="card-body poll-card">';
                rows+= '<h5 class="card-title">'+data.poll_title+'</h5>';

                var total = 0;
                $.each(data.list_option, function(index, o) {
                    total+= parseInt(o.num_vote);
                })

                $.each(data.list_option, function(index, o) {

                    var percent = o.num_vote*100/total;
                    percent =  Math.round(percent * 100) / 100;

                    if (total == 0) percent = 0;

                    rows+= '<p>'+o.content+'</p>';
                    rows+= '<div class="progress">';
                    rows+= '<div class="progress-bar progress-bar-striped active progress-bar-success" role="progressbar" style="width: '+percent+'%;" aria-valuenow="'+percent+'" aria-valuemin="0" aria-valuemax="100">'+percent+'%</div>';
                    rows+= '</div>';
                })
                
                rows+= '</div>';
                rows+= '</div>';
                // rows+= '</div>';
            } else {
                rows = '<h3 class="text-center">Chọn để hiển thị</h3>';
            }
            $('#result-poll').html(rows);

        }).fail(function(jqXHR, statusText, errorThrown){
              console.log("Fail:"+ jqXHR.responseText);
              console.log(errorThrown);
        })
    }


    function refresh_result_poll(poll_id) {
        $.ajax({
            url: 'process-poll.php',
            method: 'POST',
            data: {'action': 'refresh-result-poll', 'poll-id': poll_id}
        })
    }

    // get_published_poll()

    function refresh_published_poll() {
        var event_id = $('#event-id').val();
        $.ajax({
            url: 'process-poll.php',
            method: 'POST',
            data: {'action': 'refresh-published-poll', 'event-id': event_id}
        })
    }

</script>