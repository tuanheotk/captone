<?php
$title = 'QL bầu chọn';
include('header.php');
/*if (isset($_GET["id"])) {
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
}*/
?>
    <!--DASHBOARD-->
    <section>
        <div class="db">
            <!--LEFT SECTION-->
            <div class="db-l db-2-com">
                
                <h4>Thông tin cá nhân</h4>
                <div class="db-l-2 info-fix-top">
                    <ul>
                        <li>
                            <p>Bui Trung Tuan</p>
                            <p><i class="fa fa-envelope"></i> Tuanheotk@gmail.com</p>
                            <p><i class="fa fa-th-large"></i> CNTT</p>

                            
                        </li>
                        
                    </ul>
                </div>
                


                <div class="db-l-2">
                    <ul>
                        <li>
                            <a href="my-events.php"><i class="fa fa-calendar" aria-hidden="true"></i> Sự kiện của tôi</a>
                        </li>
                        <li>
                            <a href="my-registered-events.php"><i class="fa fa-check" aria-hidden="true"></i> Sự kiện đã đăng ký tham gia</a>
                        </li>

                        

                        <li>
                            <a href="review-event.php"><i class="fa fa-hourglass-end" aria-hidden="true"></i> Duyệt sự kiện</a>
                        </li>
                        
                    </ul>
                </div>
            </div>
            <!--CENTER SECTION-->
            <div class="db-2">
                <div class="db-2-com db-2-main">
                    <h4>Quản lý bình chọn của sự kiện: Ai là người giỏi nhất trong việc chống corona?</h4>
                    <input type="hidden" id="event-id" value="<?php echo $event_id ?>">
                    <input type="hidden" id="user-id" value="<?php echo $account_id ?>">
                    <input type="hidden" id="user-fullname" value="<?php echo $account_name ?>">
                    
                    <div class="db-2-main-com" id="fix-padding-bottom">
                        

                        <section class="container-full">
                            <div class="row" id="fix-margin">

                                <!-- List poll -->
                                <div class=" col-md-6 fix-lr-padding">
                                    <h4 class="text-center bg-danger" id="num-pending" data-toggle="modal" data-target="#create-poll-modal">Tạo danh sách bầu chọn <i class="fa fa-plus"></i></h4>

                                    <div class="col-md-12 askquestion-border" id="">
                                        

                                        <div class="card w-75">
                                            <div class="card-body askquestion">

                                                <input type="hidden" class="question-id" value="">

                                                <h5 class="card-title">Các bạn muốn ăn gì ngày hôm nay?</h5>
                                                <p class="card-text">Chỉ chọn một</p>
                                                <p class="card-text"><small class="text-muted">Số người bầu: 20 người</small></p>
                                                <a href="#" class="custom-btn custom-edit btn-edit-question" data-toggle="modal" data-target="#edit-poll-modal" title="Sửa câu hỏi"><i class="fa fa-pencil" ></i></a>
                                                <button type="button" data-toggle="modal" data-target="#delete-modal" title="Xoá bầu chọn" class="custom-btn custom-del btn-deny-question"><i class="fa fa-times" aria-hidden="true"></i></button>
                                                <button type="button" class="custom-btn" title="Ẩn bầu chọn"><i class="fa fa-eye-slash" aria-hidden="true"></i></button>
                                                <button type="button" class="custom-btn" title="Hiển thị bầu chọn"><i class="fa fa-eye" aria-hidden="true"></i></button>
                                            </div>
                                        </div>

                                        
                                        
                                    </div>

                                </div>
                                <!-- End list pending question -->

                                <!-- List published question -->
                                <div class=" col-md-6 fix-lr-padding">
                                    <h4 class="text-center bg-danger" id="num-published">Kết quả</h4>

                                    <div class="col-md-12 askquestion-border" id="">
                                        
                                        

                                        <div class="card w-75">
                                            <div class="card-body poll-card">
                                                <h5 class="card-title">Các bạn muốn ăn gì ngày hôm nay? </h5>

                                                <p>Cơm</p>
                                                <div class="progress">
                                                  <div class="progress-bar" role="progressbar" style="width: 15%;" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100">15%</div>
                                                </div>
                                                <p>Mì xào</p>
                                                <div class="progress">
                                                  <div class="progress-bar" role="progressbar" style="width: 25%;" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100">25%</div>
                                                </div>
                                                <p>Hải sản</p>
                                                <div class="progress">
                                                  <div class="progress-bar" role="progressbar" style="width: 45%;" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100">45%</div>
                                                </div>
                                                <p>Tôm hùm</p>
                                                <div class="progress">
                                                  <div class="progress-bar" role="progressbar" style="width: 15%;" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100">15%</div>
                                                </div>
                                            </div>
                                        </div>

                                        
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
                    <form method="POST" action="<?php  $_SERVER["PHP_SELF"] ?>">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h5>Tạo cuộc bầu chọn mới</h5>
                            </div>

                            <div class="modal-body modal-poll container-fluid">
                                <div class="col-md-12">
                                    <div class="input-field">
                                        <input type="text" name="" class="form-control" id="poll-title" placeholder="Bạn muốn khảo sát điều gì" maxlength="200">
                                    </div>
                                </div>
                                

                                <div id="list-option">

                                    <div class="col-md-12 one-option" id="option-1">
                                        <div class="input-group">
                                            <input type="text" class="form-control poll-option-text" placeholder="Lựa chọn" maxlength="100">
                                            <div class="input-group-btn">
                                                <button class="btn btn-danger btn-delete-option" type="button"><i class="fa fa-times"></i></button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12 one-option" id="option-2">
                                        <div class="input-group">
                                            <input type="text" class="form-control poll-option-text" placeholder="Lựa chọn" maxlength="100">
                                            <div class="input-group-btn">
                                                <button class="btn btn-danger btn-delete-option" type="button"><i class="fa fa-times"></i></button>
                                            </div>
                                        </div>
                                    </div>                                
                                    
                                </div>
                                <div id="list-option">

                                    <div class="col-md-12 one-option" id="option-1">
                                        <div class="input-group">
                                            <input type="text" class="form-control poll-option-text" placeholder="Lựa chọn" maxlength="100">
                                            <div class="input-group-btn">
                                                <button class="btn btn-danger btn-delete-option" type="button"><i class="fa fa-times"></i></button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12 one-option" id="option-2">
                                        <div class="input-group">
                                            <input type="text" class="form-control poll-option-text" placeholder="Lựa chọn" maxlength="100">
                                            <div class="input-group-btn">
                                                <button class="btn btn-danger btn-delete-option" type="button"><i class="fa fa-times"></i></button>
                                            </div>
                                        </div>
                                    </div>                                
                                    
                                </div>
                                <div id="list-option">

                                    <div class="col-md-12 one-option" id="option-1">
                                        <div class="input-group">
                                            <input type="text" class="form-control poll-option-text" placeholder="Lựa chọn" maxlength="100">
                                            <div class="input-group-btn">
                                                <button class="btn btn-danger btn-delete-option" type="button"><i class="fa fa-times"></i></button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12 one-option" id="option-2">
                                        <div class="input-group">
                                            <input type="text" class="form-control poll-option-text" placeholder="Lựa chọn" maxlength="100">
                                            <div class="input-group-btn">
                                                <button class="btn btn-danger btn-delete-option" type="button"><i class="fa fa-times"></i></button>
                                            </div>
                                        </div>
                                    </div>                                
                                    
                                </div>
                                <div id="list-option">

                                    <div class="col-md-12 one-option" id="option-1">
                                        <div class="input-group">
                                            <input type="text" class="form-control poll-option-text" placeholder="Lựa chọn" maxlength="100">
                                            <div class="input-group-btn">
                                                <button class="btn btn-danger btn-delete-option" type="button"><i class="fa fa-times"></i></button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12 one-option" id="option-2">
                                        <div class="input-group">
                                            <input type="text" class="form-control poll-option-text" placeholder="Lựa chọn" maxlength="100">
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
                                        <label class="custom-control-label" for="allow-multi-choice">Cho phép người tham dự chọn nhiều lựa chọn</label>
                                    </div>
                                </div>

                                <div class="col-md-2 col-sm-2">
                                    <input type="number" class="form-control hidden" name="" id="max-choice" value="2" min="2" max="2" title="Số lựa chọn tối đa">
                                </div>
                            </div>
                            
                            <div class="modal-footer">
                                <button type="button" class="btn btn-success" data-dismiss="modal">Tạo</button>
                            </div>  
                        </div>
                    </form>
                </div>             
            </div>


            <!-- Edit Poll Modal -->
            <div id="edit-poll-modal" class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <!-- Modal content-->
                    <form method="POST" action="<?php  $_SERVER["PHP_SELF"] ?>">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h5>Sửa cuộc bầu chọn</h5>
                            </div>

                            <div class="modal-body modal-poll container-fluid">
                                <div class="col-md-12">
                                    <div class="input-field">
                                        <input type="text" name="" class="form-control" placeholder="Bạn muốn khảo sát điều gì">
                                    </div>
                                </div>
                                

                                <div id="list-option-update">
                                    <div class="col-md-12">
                                        <div class="input-group">
                                            <input type="text" class="form-control" placeholder="Lựa chọn" maxlength="30">
                                            <div class="input-group-btn">
                                                <button class="btn btn-danger" type="button">
                                                    <i class="fa fa-times"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="input-group">
                                            <input type="text" class="form-control" placeholder="Lựa chọn" maxlength="30">
                                            <div class="input-group-btn">
                                                <button class="btn btn-danger" type="button">
                                                    <i class="fa fa-times"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="input-group">
                                            <input type="text" class="form-control" placeholder="Lựa chọn" maxlength="30">
                                            <div class="input-group-btn">
                                                <button class="btn btn-danger" type="button">
                                                    <i class="fa fa-times"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>                                    
                                    
                                </div>

                                <div class="col-md-12">
                                    <button class="btn btn-success" type="button">Thêm lựa chọn</button>
                                </div>

                                <div class="col-md-12">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="customSwitches">
                                        <label class="custom-control-label" for="customSwitches">Cho phép người tham dự chọn nhiều lựa chọn</label>
                                    </div>
                                </div>

                                <div class="col-md-2 col-sm-2">
                                    <input type="number" class="form-control" name="" value="2" min="2">
                                </div>
                            </div>
                            
                            <div class="modal-footer">
                                <button type="button" class="btn btn-success" data-dismiss="modal">Lưu</button>
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
                                <h4 class="modal-title"> Xoá bình chọn</h4>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" name="id" id="did">
                                <input type="hidden" name="dname" id="dname">
                                <p>Bạn có muốn xóa bình chọn: <strong id="event-will-delete"></strong> ?</p>             
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Hủy</button>
                                <button type="button" class="btn btn-danger" id="delete-event-btn">Xóa</button>
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
    // var pusher = new Pusher('51111816fa8714dbec22', {
    //     cluster: 'ap1',
    //     forceTLS: true
    //     // encrypted: true
    // });

    // Change
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
            var row = '';
            row += '<div class="col-md-12 one-option" id="option-'+option_id+'">';
            row += '<div class="input-group">';
            row += '<input type="text" class="form-control poll-option-text" placeholder="Lựa chọn" maxlength="100">';
            row += '<div class="input-group-btn">';
            row += '<button class="btn btn-danger btn-delete-option" type="button"><i class="fa fa-times"></i></button>';
            row += '</div>';
            row += '</div>';
            row += '</div>';

            $('#list-option').append(row);
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

</script>