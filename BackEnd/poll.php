<?php
$title = 'Đặt câu hỏi';
include('header.php');
/*if (isset($_GET["id"])) {
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
}*/

?>


<div class="container" id="fix-top">

    <ul class="nav nav-tabs nav-justifieds">
        <li class="active">
            <a data-toggle="tab" href="#question">Câu hỏi</a>
        </li>
        <li>
            <a data-toggle="tab" href="#poll">Bầu chọn</a>
        </li>
    </ul>

    <div class="tab-content">
        <div id="question" class="tab-pane fade in active">
            <h3>Câu hỏi</h3>
            <p>giao diện câu hỏi</p>
        </div>
        <div id="poll" class="tab-pane fade">
            <h3>Bầu chọn</h3>
            <p>Giao diện của bầu chọn</p>
        </div>
    </div>
    
</div>


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

        <!-- List question -->
        <div class="card w-75" id="list-question">
            

            <div class="card w-75">   
                <div class="card-body askquestion">
                    <input type="hidden" class="question-id" value="">
                    <h5 class="card-title user-fullname">Các bạn thích ăn gì trong ngày nghỉ dịch?</h5>
                    <p class="card-text question-content">Số người bầu chọn: 20 <i class="fa fa-users"></i></p>
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
                <div class="card-body askquestion">
                    <input type="hidden" class="question-id" value="">
                    <h5 class="card-title user-fullname">Các bạn thích ăn gì trong ngày nghỉ dịch?</h5>
                    <p class="card-text question-content">Số người bầu chọn: 20 <i class="fa fa-users"></i></p>
                    <p class="card-text question-time"><small class="text-muted">Số câu trả lời được phép chọn: 2</small></p>
                    <div class="form-check form-check-inline">
                        <p>Tôm hùm</p>
                        <div class="progress">
                            <div class="progress-bar" role="progressbar" style="width: 15%;" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100">15%</div>
                        </div>
                    </div>
                    <div class="form-check form-check-inline">
                        <p>Thịt bò</p>
                        <div class="progress">
                            <div class="progress-bar" role="progressbar" style="width: 35%;" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100">35%</div>
                        </div>
                    </div>
                    <div class="form-check form-check-inline">
                        <p>Mì hải sản</p>
                        <div class="progress">
                            <div class="progress-bar" role="progressbar" style="width: 50%;" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100">50%</div>
                        </div>
                    </div>
                    <button type="button" class="btn btn-warning" title="Gửi">Sửa</button>
                </div>
            </div>
            
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
                    <div class="card w-75">
                        <div class="card-body askquestion">
                            <h5 class="card-title">Person 1</h5>
                            <p class="card-text">Content</p>
                            <p class="card-text"><small class="text-muted">12:34 - 20/02/2020</small></p>
                        </div>
                    </div>
                </div>
                
                <div class="modal-footer">    
                    <div class="col-md-10 col-10">
                        <textarea rows="4" type="text" class="form-control" id="reply-content" placeholder="Nhập câu trả lời của bạn" aria-describedby="basic-addon2" maxlength="300"></textarea>
                        <div class="text-muted">
                            <span id="count-char">0</span> <span>/ 300</span>
                        </div>
                    </div>
                    <div class="col-md-2 col-2">
                        <div class="input-group-append ">
                            <input type="hidden" id="question-id">
                            <button class="btn btn-success " id="btn-send-reply" type="button">Trả lời</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

            <?php include('footer.php') ?>
    <script type="text/javascript">


        // Pusher
        var pusher = new Pusher('51111816fa8714dbec22', {
            cluster: 'ap1',
            forceTLS: true
            // encrypted: true
        });

        var channel = pusher.subscribe('ask-page');
        channel.bind('published-question', function(data) {
            // console.log(data);
            // Load list question realtime
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

                        rows+= '<a href="#" class="custom-btn custom-reply btn-reply-question" data-toggle="modal" data-target="#reply-question-modal" title="Trả lời"><i class="fa fa-reply" ></i></a>';
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



        // Send question
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

                        rows+= '<a href="#" class="custom-btn custom-reply btn-reply-question" data-toggle="modal" data-target="#reply-question-modal" title="Trả lời"><i class="fa fa-reply" ></i></a>';
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


    </script>
    
</body>

</html>