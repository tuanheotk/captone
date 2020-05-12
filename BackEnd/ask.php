<?php
$title = 'Đặt câu hỏi';
include('header.php');
if (isset($_GET["id"])) {
    $event_id = $_GET["id"];

    $sql_get_event_info = "SELECT title, code FROM event WHERE status = 4 AND id = ".$event_id;
    $result_event_info = mysqli_query($conn, $sql_get_event_info);

    if (mysqli_num_rows($result_event_info) > 0) {
        $row_event_info = mysqli_fetch_assoc($result_event_info);
        $event_name = $row_event_info["title"];
        $event_code = $row_event_info["code"];
    } else {
        header("Location: events.php");
    }


    // set name for user not login
    if (!isset($_SESSION["guest_id"]) && !isset($account_id)) {
        $rand = rand(10000, 99999);
        $_SESSION["guest_name"] = 'Người Lạ '. $rand;
        $_SESSION["guest_id"] = 'guest_'. $rand;
    }
    if (!isset($account_id)) {
        $account_name = $_SESSION["guest_name"];
        $account_id = $_SESSION["guest_id"];
    }

} else {
    header("Location: events.php");
}

?>


<div class="container" id="fix-top">

    <ul class="nav nav-tabs nav-justifieds">
        <li class="active">
            <a data-toggle="tab" href="#question-tab">Câu hỏi</a>
        </li>
        <li>
            <a data-toggle="tab" href="#poll-tab">Bầu chọn</a>
        </li>
    </ul>

    <!-- Tab content -->
    <div class="tab-content">
        <!-- Question tab -->
        <div id="question-tab" class="tab-pane fade in active">
            <section>
                <div class="container">
                    <div class="row">
                        <div class="tourz-search-10">
                            <h2>Hãy đặt câu hỏi cho sự kiện</h2>
                            <h2>Mã sự kiện: <span><?php echo $event_code ?></span></h2>
                            <h4><?php echo $event_name ?></h4>
                            <!-- <h2><?php echo $account_name ?></h2>
                            <h2><?php echo $account_id ?></h2> -->
                            
                            <form class="tourz-search-form">
                                <div class="input-field">
                                </div>
                                <div class="input-field">
                                    <textarea id="select-search5" class="autocomplete" placeholder="Nhập câu hỏi của bạn" maxlength="300" required></textarea> 
                                    <!-- <label for="select-search" class="search-hotel-type">Nhập câu hỏi của bạn</label> -->
                                </div>
                                <div class="input-field">
                                    <input type="hidden" id="user-id" value="<?php echo $account_id ?>">
                                    <input type="hidden" id="user-fullname" value="<?php echo $account_name ?>">
                                    <input type="hidden" id="event-id" value="<?php echo $event_id ?>">
                                    <input type="button" value="Gửi câu hỏi" class="waves-effect waves-light tourz-sear-btn" id="btn-send-question"> 
                                </div>
                            </form>
                            
                        </div>
                    </div>
                </div>
            </section>

            <section>
                <div class="container">

                    <!-- List question -->
                    <div class="card w-75" id="list-question">
                        <?php
                        // $sql_get_all_question = "SELECT * FROM question WHERE status = 1 AND event_id = $event_id ORDER BY pinned DESC, id DESC";
                        $sql_get_all_question = "SELECT T1.*, T1.num_like, T2.num_reply
                                                FROM
                                                (SELECT q.*, COUNT(r.user_id) AS num_like FROM question q LEFT JOIN reaction r ON q.id = r.question_id WHERE q.status = 1 AND q.event_id = $event_id GROUP BY q.id ORDER BY q.pinned DESC, q.id DESC) T1
                                                JOIN
                                                ( SELECT q.*, COUNT(a.user_id) AS num_reply FROM question q LEFT JOIN answer a ON q.id = a.question_id GROUP BY q.id) T2
                                                ON T1.id = T2.id";
                        $result_question = mysqli_query($conn, $sql_get_all_question);

                        if (mysqli_num_rows($result_question) > 0) {
                            while ($row_question = mysqli_fetch_assoc($result_question)) {
                                // in câu hỏi
                                $question_id = $row_question["id"];
                                $fullname = $row_question["user_fullname"];
                                $question_content = $row_question["content"];
                                $num_like = ($row_question["num_like"] > 0) ? $row_question["num_like"] : '';
                                $num_reply = $row_question["num_reply"];
                                $time = date("H:i - d/m/Y", strtotime($row_question["create_at"]));
                        ?>

                        <div class="card w-75">   
                            <div class="card-body askquestion">
                                <input type="hidden" class="question-id" value="<?php echo $question_id ?>">
                                <h5 class="card-title user-fullname"><?php echo $fullname ?></h5>
                                <p class="card-text question-content"><?php echo $question_content ?></p>
                                <p class="card-text question-time"><small class="text-muted"><?php echo $time ?></small></p>

                                <?php
                                $sql_check_user_liked = "SELECT user_id FROM reaction WHERE event_id = $event_id AND user_id = '$account_id' AND question_id = $question_id";
                                $result_user_liked = mysqli_query($conn, $sql_check_user_liked);
                                if (mysqli_num_rows($result_user_liked) > 0) {
                                    echo '<button type="button" class="custom-btn custom-liked btn-unlike-question" title="Bỏ yêu thích">'.$num_like.' <i class="fa fa-heart"></i></button>';
                                } else {
                                    echo '<button type="button" class="custom-btn custom-like btn-like-question" title="Yêu thích">'.$num_like.' <i class="fa fa-heart-o"></i></button>';
                                }
                                ?>

                                <a href="#" type="button" class="custom-btn custom-reply btn-reply-question" data-toggle="modal" data-target="#reply-question-modal" title="Trả lời"><?php echo $num_reply ?> <i class="fa fa-reply"></i></a>


                                <!-- <button type="button" class="btn btn-info btn-like-question" title="Yêu thích"><?php if ($num_like > 0) echo $num_like ?> <i class="fa fa-heart" aria-hidden="true"></i></button>
                                <a href="#" class="btn btn-success btn-reply-question" data-toggle="modal" data-target="#reply-question-modal" title="Trả lời"><i class="fa fa-reply" ></i></a> -->
                            </div>
                        </div>
                        <?php

                            }
                        } else {
                            echo '<div class="card w-75">
                                    <h3 class="text-center">Chưa có câu hỏi</h3>
                                </div>';
                        }
                        ?>
                    </div>
                </div>
            </section>

            <!-- Reply question modal-->
            <div id="reply-question-modal" class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <!-- Modal content-->
                    <form id="" method="POST" action="<?php  $_SERVER["PHP_SELF"] ?>">
                        <div class="modal-content modalask">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title"> Trả lời câu hỏi</h4>
                                <div class="card-body askquestion">
                                      <h5 class="card-title" id="asker-name"></h5>
                                      <p class="card-text" id="question-content"></p>
                                      <p class="card-text"><small class="text-muted" id="question-time"></small></p>
                                    </div>
                            </div>
                            <div class="modal-body" id="list-answer">
                                <!-- <div class="card w-75">
                                    <div class="card-body askquestion">
                                        <h5 class="card-title">Person 1</h5>
                                        <p class="card-text">Content</p>
                                        <p class="card-text"><small class="text-muted">12:34 - 20/02/2020</small></p>
                                    </div>
                                </div> -->
                                <p class="text-center"><i class="fa fa-spinner fa-2x fa-spin" aria-hidden="true"></i></p>
                            </div>
                            
                            <div class="modal-footer">    
                                <div class="col-md-12 col-12">
                                    <textarea rows="4" type="text" class="form-control" id="reply-content" placeholder="Nhập câu trả lời của bạn" aria-describedby="basic-addon2" maxlength="300"></textarea>
                                    <div class="text-muted" style="float: left;">
                                        <span id="count-char">0</span> <span>/ 300</span>
                                    </div>
                                    <button class="btn btn-success" style="margin: 0;" id="btn-send-reply" type="button">Trả lời</button>
                                </div>
                               
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>


        <!-- Poll tab -->
        <div id="poll-tab" class="tab-pane fade">
            <section>
                <div class="container">
                    <div class="row">
                        <div class="tourz-search-10">
                            <h2>Hãy bình chọn cho sự kiện</h2>
                            <h2>Mã sự kiện: <span>CG45</span></h2>
                            <h4>Tên sự kiện: Các bạn nghỉ dịch để làm gì</h4>
                            <!-- <h2><?php echo $account_name ?></h2>
                            <h2><?php echo $account_id ?></h2> -->
                            
                            
                        </div>
                    </div>
                </div>
            </section>

            <section>
                <div class="container">

                    <!-- List poll -->
                    <div class="card w-75" id="list-poll">
                        

                        <div class="card w-75">   
                            <div class="card-body poll-card">
                                <input type="hidden" class="poll-id" value="">
                                <h6>
                                    <span class="card-title poll-title">Các bạn thích ăn gì trong ngày nghỉ dịch?</span>
                                    <span class="pull-right num-attendee" title="Số người đã bầu chọn">50 <i class="fa fa-user"></i></span>
                                </h6>
                                <hr>

                                <p class="card-text question-time"><small class="text-muted">Số câu trả lời được phép chọn: 2</small></p>
                                <div class="form-check form-check-inline">
                                  <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="option2">
                                  <label class="form-check-label" for="inlineCheckbox1">Tôm hùm</label>
                                </div>
                                <div class="form-check form-check-inline">
                                  <input class="form-check-input" type="checkbox" id="inlineCheckbox2" value="option2">
                                  <label class="form-check-label" for="inlineCheckbox2">Thịt bò</label>
                                </div>
                                <div class="form-check form-check-inline">
                                  <input class="form-check-input" type="checkbox" id="inlineCheckbox3" value="option2">
                                  <label class="form-check-label" for="inlineCheckbox3">Mì Hải sản</label>
                                </div>
                                <button type="button" class="btn btn-info" title="Gửi">Gửi</button>
                            </div>
                        </div>

                        <div class="card w-75">   
                            <div class="card-body poll-card">
                                <input type="hidden" class="question-id" value="">

                                <h6>
                                    <span class="card-title poll-title">Các bạn thích ăn gì trong ngày nghỉ dịch?</span>
                                    <span class="pull-right num-attendee" title="Số người đã bầu chọn">50 <i class="fa fa-user"></i></span>
                                </h6>
                                <hr>
                                <!-- <p class="card-text question-time"><small class="text-muted">Số câu trả lời được phép chọn: 2</small></p> -->
                                <div class="form-check form-check-inline">
                                    <p>Tôm hùm</p>
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-striped active progress-bar-danger" role="progressbar" style="width: 15%;" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100">15%</div>
                                    </div>
                                </div>
                                <div class="form-check form-check-inline">
                                    <p>Thịt bò</p>
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-striped active progress-bar-grey" role="progressbar" style="width: 35%;" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100">35%</div>
                                    </div>
                                </div>
                                <div class="form-check form-check-inline">
                                    <p>Mì hải sản</p>
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-striped active progress-bar-danger" role="progressbar" style="width: 50%;" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100">50%</div>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-success" title="Sửa">Sửa bầu chọn</button>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </section>

        </div>
    </div>
    
</div>




    <?php include('footer.php') ?>
    <script type="text/javascript">

        // Change tilte when change tab
        $('a[href^="#question-tab"]').click(function(){
            document.title = 'Đặt câu hỏi - EventBox Văn Lang';
        })
        $('a[href^="#poll-tab"]').click(function(){
            document.title = 'Bầu chọn - EventBox Văn Lang';
        })

        var event_id = $('#event-id').val();

        // Pusher
        var pusher = new Pusher('51111816fa8714dbec22', {
            cluster: 'ap1',
            forceTLS: true
            // encrypted: true
        });

        var channel = pusher.subscribe('ask-page-'+event_id);
        channel.bind('published-question', function(data) {
            // console.log(data);
            // Load list published question realtime
            var user_id = $('#user-id').val();

            if (data.result) {
                var rows = '';
                $.each(data.questions, function(index, q) {
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

                    rows+= '<a href="#" class="custom-btn custom-reply btn-reply-question" data-toggle="modal" data-target="#reply-question-modal" title="Trả lời">'+q.num_reply+' <i class="fa fa-reply" ></i></a>';
                    rows+= '<input type="hidden" class="question-id" value="'+q.id+'">';
                    rows+= '</div>';
                    rows+= '</div>';
                })
            } else {
                // console.log(data.result);
                rows = '<div class="card w-75"><h3 class="text-center">chưa có câu hỏi</h3></div>';
            }

            $('#list-question').html(rows);
        })



        // User send question
        $('#btn-send-question').click(function(e){
            e.preventDefault();
            var event_id = $('#event-id').val();
            var user_id = $('#user-id').val();
            var user_fullname = $('#user-fullname').val();
            var question_content = $('#select-search5').val();

            if (question_content.replace(/\s+/g, ' ').trim().length < 10) {
                alert('Nội dung câu hỏi tối thiểu 10 ký tự');
                $('#select-search5').focus();
                return false;
            }

            $.ajax({
                url: 'process-question.php',
                method: 'POST',
                data: {'action': 'user-send-question', 'event-id': event_id, 'user-id': user_id,
                        'user-fullname': user_fullname, 'content': question_content}
            }).done(function(data){
                $('#select-search5').val('');
                if (data.result) {
                    if (data.pending) {
                        alert(data.message);
                    }
                    // reload list question
                    get_published_question();

                    // send question for mod
                    get_pending_question();
                } else {
                    alert(data.message)
                }
            }).fail(function(jqXHR, statusText, errorThrown){
                console.log("Fail:"+ jqXHR.responseText);
                console.log(errorThrown);
            })

        })

        // Like question
        $('body').on('click', '.btn-like-question', function(){
            var event_id = $('#event-id').val();
            var user_id = $('#user-id').val();
            var question_id = $(this).parent('div').find('.question-id').val();


            var current_like = $(this).text().trim();
            new_like = (current_like != '') ? parseInt(current_like) + 1 : '1';

            $(this).html(new_like+' <i class="fa fa-heart"></i></button> ').removeClass('custom-like').removeClass('btn-like-question').addClass('custom-liked').addClass('btn-unlike-question');

            $.ajax({
                url: 'process-question.php',
                method: 'POST',
                data: {'action': 'like-question', 'event-id': event_id, 'user-id': user_id, 'question-id': question_id}
            }).done(function(data){
                if (data.result) {
                    get_published_question();
                } else alert('dã tim ròi')
            })
        })

        // Unlike question
        $('body').on('click', '.btn-unlike-question', function(){
            var event_id = $('#event-id').val();
            var user_id = $('#user-id').val();
            var question_id = $(this).parent('div').find('.question-id').val();

            var current_like = $(this).text().trim();
            new_like = (current_like > 1) ? current_like - 1 : '';
            $(this).html(new_like+' <i class="fa fa-heart-o"></i></button> ').removeClass('custom-liked').removeClass('btn-unlike-question').addClass('custom-like').addClass('btn-like-question');

            $.ajax({
                url: 'process-question.php',
                method: 'POST',
                data: {'action': 'unlike-question', 'event-id': event_id, 'user-id': user_id, 'question-id': question_id}
            }).done(function(data){
                if (data.result) {
                    get_published_question();
                }
            })
        })

        // Click button reply question
        $('body').on('click', '.btn-reply-question', function(){
            var event_id = $('#event-id').val();
            var question_id = $(this).parent('div').find('.question-id').val();

            var asker_name = $(this).parent('div').find('.user-fullname').text();
            var question_content = $(this).parent('div').find('.question-content').text();
            var question_time = $(this).parent('div').find('.question-time').text();


            $('#reply-question-modal #question-id').val(question_id);
            $('#reply-question-modal #asker-name').text(asker_name);
            $('#reply-question-modal #question-content').text(question_content);
            $('#reply-question-modal #question-time').text(question_time);

            // Load list answer
            get_answer(event_id, question_id);


        })

        // Count char on textarea reply
        $('#reply-content').on('keyup keydown', function(){
            current = $(this).val().length;
            $('#count-char').text(current)
        })

        // Click button answer
        $('#btn-send-reply').click(function(){
            var event_id = $('#event-id').val();
            var question_id = $('#reply-question-modal #question-id').val();
            var user_id = $('#user-id').val();
            var user_fullname = $('#user-fullname').val();
            var reply_content = $('#reply-content').val();

            if (reply_content.replace(/\s+/g, ' ').trim().length < 5) {
                alert('Nội dung câu trả lời tối thiểu 5 ký tự');
                $('#reply-content').focus();
                return false;
            }


            // set 
            // var now = new Date();
            // var h = String(now.getHours()).padStart(2, '0');
            // var min = String(now.getMinutes()).padStart(2, '0');
            
            // var d = String(now.getDate()).padStart(2, '0');
            // var m = String(now.getMonth() + 1).padStart(2, '0');
            // var y = now.getFullYear();

            // var time = h + ":" + min + " - " + d + '/' + m + '/' + y;

            // var rows = '';
            // rows+= '<div class="card w-75">';
            // rows+= '<div class="card-body askquestion">';
            // rows+= '<h5 class="card-title">'+user_fullname+'</h5>';
            // rows+= '<p class="card-text">'+reply_content+'</p>';
            // rows+= '<p class="card-text"><small class="text-muted">'+time+'</small></p>';
            // rows+= '</div>';
            // rows+= '</div>';
            
            // $('#list-answer').append(rows);

            // // Scroll to bottom
            // $('#list-answer').scrollTop($('#list-answer')[0].scrollHeight);


            $.ajax({
                url: 'process-question.php',
                method: 'POST',
                data: {'action': 'user-reply-question', 'event-id': event_id, 'question-id': question_id,
                    'user-id': user_id, 'user-fullname': user_fullname, 'content': reply_content}
            }).done(function(data){
                if (data.result) {
                    $('#reply-content').val('');
                    $('#count-char').text(0);
                    get_answer(event_id, question_id);

                    get_published_question();

                } else {
                    alert(data.message);
                }
            })
        })



        // Function load published question
        function get_published_question(){
            var event_id = $('#event-id').val();
            var user_id = $('#user-id').val();
            $.ajax({
                url: 'process-question.php',
                method: 'POST',
                data: {'action': 'get-published-question', 'event-id': event_id}
            }).done(function(data) {
                if (data.result) {
                    var rows = '';
                    $.each(data.questions, function(index, q) {
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

                        rows+= '<a href="#" class="custom-btn custom-reply btn-reply-question" data-toggle="modal" data-target="#reply-question-modal" title="Trả lời">'+q.num_reply+' <i class="fa fa-reply" ></i></a>';
                        rows+= '<input type="hidden" class="question-id" value="'+q.id+'">';
                        rows+= '</div>';
                        rows+= '</div>';
                    })
                } else {
                    rows = '<div class="card w-75"><h3 class="text-center">chưa có câu hỏi</h3></div>';
                }

                $('#list-question').html(rows);
            }).fail(function(jqXHR, statusText, errorThrown){
                  console.log("Fail:"+ jqXHR.responseText);
                  console.log(errorThrown);
            })
        }


        
        // Function get pending question
        function get_pending_question() {
            var event_id = $('#event-id').val();
            $.ajax({
                url: 'process-question.php',
                method: 'POST',
                data: {'action': 'get-pending-question', 'event-id': event_id}
            }).done(function(data) {
            })
        }


        // Function get answer
        function get_answer(event_id, question_id) {
            $.ajax({
                url: 'process-question.php',
                method: 'POST',
                data: {'action': 'get-answer', 'event-id': event_id, 'question-id': question_id}
            }).done(function(data){
                if (data.result) {
                    var rows = '';
                    $.each(data.answer, function(index, ans) {
                        rows+= '<div class="card w-75">';
                        rows+= '<div class="card-body askquestion">';
                        rows+= '<h5 class="card-title">'+ans.user_fullname+'</h5>';
                        rows+= '<p class="card-text">'+ans.content+'</p>';
                        rows+= '<p class="card-text"><small class="text-muted">'+ans.create_at+'</small></p>';
                        rows+= '</div>';
                        rows+= '</div>';
                    })
                } else {
                    rows = '';
                }

                $('#list-answer').html(rows);

                // Scroll to bottom
                $('#list-answer').scrollTop($('#list-answer')[0].scrollHeight);
            })
        }

        // Hidden reply question modal
        $('#reply-question-modal').on('hidden.bs.modal', function(){
            $('#list-answer').html('<p class="text-center"><i class="fa fa-spinner fa-2x fa-spin" aria-hidden="true"></i></p>');
        });

        // Shown reply question modal
        $('#reply-question-modal').on('shown.bs.modal', function(){
            var event_id = $('#event-id').val();
            var question_id = $('#reply-question-modal #question-id').val();



            var channel2 = pusher.subscribe('question-event'+event_id);
            channel2.bind('list-answer'+question_id, function(data) {
                // console.log(data);
                if (data.result) {
                    var rows = '';
                    $.each(data.answer, function(index, ans) {
                        rows+= '<div class="card w-75">';
                        rows+= '<div class="card-body askquestion">';
                        rows+= '<h5 class="card-title">'+ans.user_fullname+'</h5>';
                        rows+= '<p class="card-text">'+ans.content+'</p>';
                        rows+= '<p class="card-text"><small class="text-muted">'+ans.create_at+'</small></p>';
                        rows+= '</div>';
                        rows+= '</div>';
                    })
                } else {
                    rows = '';
                }

                $('#list-answer').html(rows);

                // Scroll to bottom
                // $('#list-answer').scrollTop($('#list-answer')[0].scrollHeight);
            })
        });



    </script>
    
</body>

</html>