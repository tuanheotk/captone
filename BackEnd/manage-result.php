<?php
$title = 'Quản lý câu hỏi';
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
                                <div class=" col-md-6 fix-lr-padding">
                                    <h4 class="text-center bg-danger" id="num-published">Câu hỏi <i class="fa fa-question-circle-o"></i></h4>
                                    <div class="col-md-12 askquestion-border" id="list-pending-question">
                                        <div class="card w-75">
                                            <div class="card-body askquestion">

                                                <input type="hidden" class="question-id" value="">

                                                <h5 class="card-title">Tổng số câu hỏi: 20 </h5>
                                                <h5 class="card-title">Tổng số câu trả lời: 20</h5>
                                                <h5 class="card-title">Lượt Thích: 15 </i></h5>
                                                <p class="card-text">
                                                    <button class="btn btn-success" type="button" data-toggle="modal" data-target="#export-question">
                                                        Xuất file câu hỏi <i class="fa fa-table"></i>
                                                    </button>
                                                    
                                                </p>
                                                
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class=" col-md-6 fix-lr-padding">
                                    <h4 class="text-center bg-danger" id="num-published">Cuộc bầu chọn <i class="fa fa-hand-o-left"></i></h4>
                                    <div class="col-md-12 askquestion-border" id="list-pending-question">
                                        <div class="card w-75">
                                            <div class="card-body askquestion">

                                                <input type="hidden" class="question-id" value="">
                                                <h5 class="card-title">Tổng số cuộc bầu chọn được tạo: 5 </h5>
                                                <h5 class="card-title">Tổng số người bầu: 200</h5>
                                                <h5 class="card-title">Tổng số phiếu trung bình: 40</h5>
                                                <p class="card-text">
                                                    <button class="btn btn-success" type="button" data-toggle="modal" data-target="#export-poll">
                                                        Xuất file bầu chọn <i class="fa fa-table"></i>
                                                    </button>
                                                    
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    

                                </div>
                            </div>
                        </section> 
                    </div>
                </div>
            </div>
            

            
            
            <!-- Export Question -->
            <div id="export-question" class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <!-- Modal content-->
                    <form id="export-question" method="POST" action="">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title"> Xuất file câu hỏi</h4>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" name="id" id="did">
                                <input type="hidden" name="dname" id="dname">
                                <p>Bạn có muốn xuất file câu hỏi và câu trả lời sang định dạng excel không?</p>             
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Hủy</button>
                                <button type="button" class="btn btn-success" id="delete-event-btn">Xuất</button>
                            </div>
                        </div>
                    </form>
                </div>              
            </div>
            <!-- Export Poll -->
            <div id="export-poll" class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <!-- Modal content-->
                    <form id="export-poll" method="POST" action="">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title"> Xuất file bầu chọn</h4>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" name="id" id="did">
                                <input type="hidden" name="dname" id="dname">
                                <p>Bạn có muốn xuất file bầu chọn lời sang định dạng excel không?</p>             
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Hủy</button>
                                <button type="button" class="btn btn-success" id="delete-event-btn">Xuất</button>
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

    // get_pending_question();
    // get_published_question();


    // // Pusher
    // var pusher = new Pusher('51111816fa8714dbec22', {
    //     cluster: 'ap1',
    //     forceTLS: true
    //     // encrypted: true
    // });


    // Realtime get pending question
    /*var channel = pusher.subscribe('manage-ask');
    channel.bind('pending-question', function(data) {
        // console.log(data);
        
        // Load list pending question realtime
        if (data.result) {
            var rows = '';
            var count = 0;
            $.each(data.questions, function(index, q) {
                count++;
                rows+= '<div class="card w-75">';
                rows+= '<div class="card-body askquestion">';
                rows+= '<input type="hidden" class="question-id" value="'+q.id+'">';
                rows+= '<h5 class="card-title">'+q.user_fullname+'</h5>';
                rows+= '<p class="card-text question-content">'+q.content+'</p>';
                rows+= '<p class="card-text"><small class="text-muted">'+q.create_at+'</small></p>';
                rows+= '<a href="#" class="custom-btn custom-edit btn-edit-question" data-toggle="modal" data-target="#edit-question-modal" title="Sửa câu hỏi"><i class="fa fa-pencil" ></i></a> ';
                rows+= '<button type="button" title="Chấp nhận câu hỏi" class="custom-btn custom-reply btn-accept-question"><i class="fa fa-check" aria-hidden="true"></i></button> ';
                rows+= '<button type="button" title="Từ chối câu hỏi" class="custom-btn custom-del btn-deny-question"><i class="fa fa-times" aria-hidden="true"></i></button>';
                rows+= '</div>';
                rows+= '</div>';
            })
        } else {
            // console.log(data.result);
            rows = '<div class="card w-75"><h3 class="text-center">chưa có câu hỏi</h3></div>';
        }

        $('#list-pending-question').html(rows);
        $('#num-pending').text('Câu hỏi chờ duyệt (' + count + ')');
    })*/


    // Realtime get published question
    /*var channel2 = pusher.subscribe('ask-page');
    channel2.bind('published-question', function(data) {
        // console.log(data);
        // Load list published question
        var user_id = $('#user-id').val();

        if (data.result) {
            var rows = '';
            var count = 0;
            $.each(data.questions, function(index, q) {
                count++;
                var num_like = (q.num_like > 0) ? q.num_like : '';
                var question_id = q.id;

                rows+= '<div class="card w-75">';
                rows+= '<div class="card-body askquestion">';
                rows+= '<h5 class="card-title user-fullname">'+q.user_fullname+'</h5>';
                rows+= '<p class="card-text question-content">'+q.content+'</p>';
                rows+= '<p class="card-text question-time"><small class="text-muted">'+q.create_at+'</small></p>';

                $.each(data.liked, function(index, l) {
                    if (question_id == l.question_id) {
                        if (user_id == l.user_id) {
                            liked = true;
                            return false;
                        } else {
                            liked = false;

                        }

                    } else {
                        liked = false;
                    }
                })

                if (liked) {
                    rows+= '<button type="button" class="custom-btn custom-liked btn-unlike-question" title="Bỏ yêu thích">'+num_like+' <i class="fa fa-heart" aria-hidden="true"></i></button> ';
                } else {
                    rows+= '<button type="button" class="custom-btn custom-like btn-like-question" title="Yêu thích">'+num_like+' <i class="fa fa-heart-o" aria-hidden="true"></i></button> ';
                }

                rows+= '<a href="#" class="custom-btn custom-reply btn-reply-question" data-toggle="modal" data-target="#reply-question-modal" title="Trả lời"><i class="fa fa-reply" ></i></a> ';

                if (q.pinned == 0) {
                    rows+= '<button type="button" title="Ghim câu hỏi" class="custom-btn custom-pin btn-pin-question" value ="0"><i class="fa fa-check-circle-o" aria-hidden="true"></i></button>';
                } else {
                    rows+= '<button type="button" title="Bỏ ghim câu hỏi" class="custom-btn custom-pinned btn-pin-question" value ="1"><i class="fa fa-check-circle" aria-hidden="true"></i></button>';
                }

                rows+= '<input type="hidden" class="question-id" value="'+q.id+'">';
                rows+= '</div>';
                rows+= '</div>';
            })
        } else {
            // console.log(data.result);
            rows = '<div class="card w-75"><h3 class="text-center">chưa có câu hỏi</h3></div>';
        }

        $('#list-published-question').html(rows);
        $('#num-published').text('Câu hỏi đã công khai (' + count + ')');
    })*/


    // Realtime check question status
    /*var channel3 = pusher.subscribe('manage-ask');
    channel3.bind('check-question-status', function(status) {
        var rows;
        if (status == 1) {
            rows = '<input type="checkbox" class="custom-control-input" id="check-question" checked>';
        } else {
            rows = '<input type="checkbox" class="custom-control-input" id="check-question">';
        }
        rows+= '<label class="custom-control-label" for="check-question">Duyệt câu hỏi</label>';
        $('#check-question-status').html(rows);

    })

    // Realtime user make question status
    var channel4 = pusher.subscribe('manage-ask');
    channel4.bind('user-make-question-status', function(status) {
        var rows;
        if (status == 1) {
            rows = '<input type="checkbox" class="custom-control-input" id="user-make-question" checked>';
        } else {
            rows = '<input type="checkbox" class="custom-control-input" id="user-make-question">';
        }
        rows+= '<label class="custom-control-label" for="user-make-question">Người tham dự đặt câu hỏi</label>';
        $('#user-make-question-status').html(rows);

    })

    // Realtime user reply question status
    var channel5 = pusher.subscribe('manage-ask');
    channel5.bind('user-reply-question-status', function(status) {
        var rows;
        if (status == 1) {
            rows = '<input type="checkbox" class="custom-control-input" id="user-reply-question" checked>';
        } else {
            rows = '<input type="checkbox" class="custom-control-input" id="user-reply-question">';
        }
        rows+= '<label class="custom-control-label" for="user-reply-question">Người tham dự trả lời câu hỏi</label>';
        $('#user-reply-question-status').html(rows);

    })



    // Function get pending question
    function get_pending_question() {
        var event_id = $('#event-id').val();
        $.ajax({
            url: 'process-question.php',
            method: 'POST',
            data: {'action': 'get-pending-question', 'event-id': event_id}
        }).done(function(data) {
            if (data.result) {
                var rows = '';
                var count = 0;
                $.each(data.questions, function(index, q) {
                    count++;
                    rows+= '<div class="card w-75">';
                    rows+= '<div class="card-body askquestion">';
                    rows+= '<input type="hidden" class="question-id" value="'+q.id+'">';
                    rows+= '<h5 class="card-title">'+q.user_fullname+'</h5>';
                    rows+= '<p class="card-text question-content">'+q.content+'</p>';
                    rows+= '<p class="card-text"><small class="text-muted">'+q.create_at+'</small></p>';
                    rows+= '<a href="#" class="custom-btn custom-edit btn-edit-question" data-toggle="modal" data-target="#edit-question-modal" title="Sửa câu hỏi"><i class="fa fa-pencil" ></i></a> ';
                    rows+= '<button type="button" title="Chấp nhận câu hỏi" class="custom-btn custom-reply btn-accept-question"><i class="fa fa-check" aria-hidden="true"></i></button> ';
                    rows+= '<button type="button" title="Từ chối câu hỏi" class="custom-btn custom-del btn-deny-question"><i class="fa fa-times" aria-hidden="true"></i></button>';
                    rows+= '</div>';
                    rows+= '</div>';
                })
            } else {
                // console.log(data.result);
                rows = '<div class="card w-75"><h3 class="text-center">Chưa có câu hỏi</h3></div>';
            }

            $('#list-pending-question').html(rows);
            $('#num-pending').text('Câu hỏi chờ duyệt (' + count + ')');
        })
    }*/

    // Function load published question
    /*function get_published_question(){
        var event_id = $('#event-id').val();
        var user_id = $('#user-id').val();
        $.ajax({
            url: 'process-question.php',
            method: 'POST',
            data: {'action': 'get-published-question', 'event-id': event_id}
        }).done(function(data) {
            if (data.result) {
                var rows = '';
                var count = 0;
                $.each(data.questions, function(index, q) {
                    count++;
                    var num_like = (q.num_like > 0) ? q.num_like : '';
                    var question_id = q.id;

                    rows+= '<div class="card w-75">';
                    rows+= '<div class="card-body askquestion">';
                    rows+= '<h5 class="card-title user-fullname">'+q.user_fullname+'</h5>';
                    rows+= '<p class="card-text question-content">'+q.content+'</p>';
                    rows+= '<p class="card-text question-time"><small class="text-muted">'+q.create_at+'</small></p>';

                    $.each(data.liked, function(index, l) {
                        if (question_id == l.question_id) {
                            if (user_id == l.user_id) {
                                liked = true;
                                return false;
                            } else {
                                liked = false;

                            }

                        } else {
                            liked = false;
                        }
                    })

                    if (liked) {
                        rows+= '<button type="button" class="custom-btn custom-liked btn-unlike-question" title="Bỏ yêu thích">'+num_like+' <i class="fa fa-heart" aria-hidden="true"></i></button> ';
                    } else {
                        rows+= '<button type="button" class="custom-btn custom-like btn-like-question" title="Yêu thích">'+num_like+' <i class="fa fa-heart-o" aria-hidden="true"></i></button> ';
                    }

                    rows+= '<a href="#" class="custom-btn custom-reply btn-reply-question" data-toggle="modal" data-target="#reply-question-modal" title="Trả lời"><i class="fa fa-reply" ></i></a> ';


                    if (q.pinned == 0) {
                        rows+= '<button type="button" title="Ghim câu hỏi" class="custom-btn custom-pin btn-pin-question" value ="0"><i class="fa fa-check-circle-o" aria-hidden="true"></i></button>';
                    } else {
                        rows+= '<button type="button" title="Bỏ ghim câu hỏi" class="custom-btn custom-pinned btn-pin-question" value ="1"><i class="fa fa-check-circle" aria-hidden="true"></i></button>';
                    }

                    rows+= '<input type="hidden" class="question-id" value="'+q.id+'">';
                    rows+= '</div>';
                    rows+= '</div>';
                })
            } else {
                rows = '<div class="card w-75"><h3 class="text-center">chưa có câu hỏi</h3></div>';
            }

            $('#list-published-question').html(rows);
            $('#num-published').text('Câu hỏi đã công khai (' + count + ')');
        }).fail(function(jqXHR, statusText, errorThrown){
              console.log("Fail:"+ jqXHR.responseText);
              console.log(errorThrown);
        })
    }*/

    // Click edit question
    // $('body').on('click', '.btn-edit-question', function(){
    //     var question_content = $(this).parent('div').find('.question-content').text();
    //     var question_id = $(this).parent('div').find('.question-id').val();
    //     $('#tb-edit-question').val(question_content);
    //     $('#question-id-update').val(question_id);

    // })

    // $('#btn-update-question').click(function(){
    //     var question_id = $('#question-id-update').val();
    //     var question_content = $('#tb-edit-question').val();
    //     $.ajax({
    //         url: 'process-question.php',
    //         method: 'POST',
    //         data: {'action': 'mod-edit-question','question-id': question_id, 'question-content': question_content}
    //     }).done(function(data) {
    //         get_pending_question();
    //     })
    // })

    // // Click accept question
    // $('body').on('click', '.btn-accept-question', function(){
    //     var question_id = $(this).parent('div').find('.question-id').val();
    //     $.ajax({
    //         url: 'process-question.php',
    //         method: 'POST',
    //         data: {'action': 'mod-accept-question', 'question-id': question_id}
    //     }).done(function(data){
    //         get_pending_question();
    //         get_published_question();
    //     })
    // })

    // // Click deny question
    // $('body').on('click', '.btn-deny-question', function(){
    //     var question_id = $(this).parent('div').find('.question-id').val();
    //     $.ajax({
    //         url: 'process-question.php',
    //         method: 'POST',
    //         data: {'action': 'mod-deny-question', 'question-id': question_id}
    //     }).done(function(data){
    //         get_pending_question();
    //         // get_published_question();
    //     })
    // })


    // // Like question
    // $('body').on('click', '.btn-like-question', function(){
    //     var event_id = $('#event-id').val();
    //     var user_id = $('#user-id').val();
    //     var question_id = $(this).parent('div').find('.question-id').val();


    //     var current_like = $(this).text().trim();
    //     new_like = (current_like != '') ? parseInt(current_like) + 1 : '1';

    //     $(this).html(new_like+' <i class="fa fa-heart"></i></button> ').removeClass('custom-like').removeClass('btn-like-question').addClass('custom-liked').addClass('btn-unlike-question');

    //     $.ajax({
    //         url: 'process-question.php',
    //         method: 'POST',
    //         data: {'action': 'like-question', 'event-id': event_id, 'user-id': user_id, 'question-id': question_id}
    //     }).done(function(data){
    //         if (data.result) {
    //             get_published_question();
    //         } else alert('dã tim ròi')
    //     })
    // })

    // // Unlike question
    // $('body').on('click', '.btn-unlike-question', function(){
    //     var event_id = $('#event-id').val();
    //     var user_id = $('#user-id').val();
    //     var question_id = $(this).parent('div').find('.question-id').val();

    //     var current_like = $(this).text().trim();
    //     new_like = (current_like > 1) ? current_like - 1 : '';
    //     $(this).html(new_like+' <i class="fa fa-heart-o"></i></button> ').removeClass('custom-liked').removeClass('btn-unlike-question').addClass('custom-like').addClass('btn-like-question');

    //     $.ajax({
    //         url: 'process-question.php',
    //         method: 'POST',
    //         data: {'action': 'unlike-question', 'event-id': event_id, 'user-id': user_id, 'question-id': question_id}
    //     }).done(function(data){
    //         if (data.result) {
    //             get_published_question();
    //         }
    //     })
    // })

    // // Click button reply question
    // $('body').on('click', '.btn-reply-question', function(){
    //     var asker_name = $(this).parent('div').find('.user-fullname').text();
    //     var question_content = $(this).parent('div').find('.question-content').text();
    //     var question_time = $(this).parent('div').find('.question-time').text();

    //     $('#reply-question-modal #asker-name').text(asker_name);
    //     $('#reply-question-modal #question-content').text(question_content);
    //     $('#reply-question-modal #question-time').text(question_time);
    // })

    // $('#reply-content').on('keyup keydown', function(){
    //     current = $(this).val().length;
    //     $('#current').text(current)
    // })


    // // Change pin question
    // $('body').on('click', '.btn-pin-question', function(){
    //     var question_id = $(this).parent('div').find('.question-id').val();
    //     new_pin_status = ($(this).val() == 0) ? 1 : 0 ;

    //     $.ajax({
    //         url: 'process-question.php',
    //         method: 'POST',
    //         data: {'action': 'mod-pin-question', 'question-id': question_id, 'new-pin-status': new_pin_status}
    //     }).done(function(data){
    //         // alert(data.message);
    //         get_published_question();
    //     })
    // })




    // // Change check question
    // $('body').on('click', '#check-question', function(){
    //     var event_id = $('#event-id').val();
    //     $(this).val(this.checked ? 1 : 0);

    //     var status = $(this).val();

    //     $.ajax({
    //         url: 'process-question.php',
    //         method: 'POST',
    //         data: {'action': 'change-check-question', 'event-id': event_id, 'check-question-status': status}
    //     }).done(function(data){
    //         // alert(data.message);
    //     })
    // })




    // // Change user make question
    // $('body').on('click', '#user-make-question', function(){
    //     var event_id = $('#event-id').val();
    //     $(this).val(this.checked ? 1 : 0);

    //     var status = $(this).val();

    //     $.ajax({
    //         url: 'process-question.php',
    //         method: 'POST',
    //         data: {'action': 'change-user-make-question', 'event-id': event_id, 'user-make-question-status': status}
    //     }).done(function(data){
    //         // alert(data.message);
    //     })
    // })


    

    // // Change user reply question
    // $('body').on('click', '#user-reply-question', function(){
    //     var event_id = $('#event-id').val();
    //     $(this).val(this.checked ? 1 : 0);

    //     var status = $(this).val();

    //     $.ajax({
    //         url: 'process-question.php',
    //         method: 'POST',
    //         data: {'action': 'change-user-reply-question', 'event-id': event_id, 'user-reply-question-status': status}
    //     }).done(function(data){
    //         // alert(data.message);
    //     })
    // })    



    

</script>