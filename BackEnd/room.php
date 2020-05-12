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
        // header("Location: events.php");
        header('Location: javascript://history.go(-1)');
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
    // header("Location: events.php");
    header('Location: javascript://history.go(-1)');
}

?>


<div class="container" id="fix-top">

    <div class="container">
        <ul class="nav nav-tabs nav-justified">
            <li class="active">
                <a data-toggle="tab" href="#question-tab">Câu hỏi</a>
            </li>
            <li>
                <a data-toggle="tab" href="#poll-tab">Bầu chọn</a>
            </li>
        </ul>
    </div>

    <!-- Tab content -->
    <div class="tab-content">
        <!-- Question tab -->
        <div id="question-tab" class="tab-pane fade in active">
            <section>
                <div class="container">
                    <div class="row">
                        <div class="tourz-search-10">
                            <h2>Hãy đặt câu hỏi cho sự kiện</h2>
                            <h2>Mã sự kiện: <span><?php echo $event_code ?></span>
                                <i class="fa fa-qrcode" data-toggle="modal" data-target="#qr-link-modal"></i>
                            </h2>
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
                                <p class="text-center"><i class="fa fa-spinner fa-2x fa-spin" aria-hidden="true"></i></p>
                            </div>
                            
                            <div class="modal-footer">    
                                <div class="col-md-12 col-12">
                                    <input type="hidden" id="question-id">
                                    <textarea rows="4" type="text" class="form-control" id="reply-content" placeholder="Nhập câu trả lời của bạn" aria-describedby="basic-addon2" maxlength="300"></textarea>
                                    <div class="text-muted pull-left">
                                        <span id="count-char">0</span> <span>/ 300</span>
                                    </div>
                                    <button class="btn btn-success" id="btn-send-reply" type="button">Trả lời</button>
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
                            <h2>Hãy tham gia bầu chọn</h2>
                            <h2>Mã sự kiện: <span><?php echo $event_code ?></span>
                                <i class="fa fa-qrcode" data-toggle="modal" data-target="#qr-link-modal"></i>
                            </h2>
                            <h4><?php echo $event_name ?></h4>
                            <input type="hidden" id="user-id" value="<?php echo $account_id ?>">
                            <input type="hidden" id="user-fullname" value="<?php echo $account_name ?>">
                            <input type="hidden" id="event-id" value="<?php echo $event_id ?>">
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
                        <h3 class="text-center"><i class="fa fa-spinner fa-spin"></i></h3>
                    </div>
                </div>
            </section>
        </div>
    </div>

    <div id="qr-link-modal" class="modal fade" role="dialog">
        <div class="modal-dialog">
        <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"> Quét mã để tham gia đặt câu hỏi & bầu chọn</h4>
                </div>
                <div class="modal-body text-center">
                    <!-- <button type="button" class="close" data-dismiss="modal">&times;</button> -->
                    <img width="100%" src="https://chart.googleapis.com/chart?chs=500x500&cht=qr&chl=http://localhost/event/room.php?id=<?php echo $event_id ?>&choe=UTF-8">      
                </div>
                <!-- <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                </div> -->
            </div>
        </div>
    </div>


    
</div>




<?php include('footer.php') ?>
<script type="text/javascript" src="js/string.js"></script>
<script type="text/javascript">

    //------------------------------------------------------------------------------------------------//

    // Change tilte when change tab
    $('a[href^="#question-tab"]').click(function(){
        document.title = 'Đặt câu hỏi - EventBox Văn Lang';

        set_cookie('tab', 'question-tab', 1);
    })
    $('a[href^="#poll-tab"]').click(function(){
        document.title = 'Bầu chọn - EventBox Văn Lang';
        
        set_cookie('tab', 'poll-tab', 1);
    })


    var selected_tab = get_cookie('tab');

    if (selected_tab == 'poll-tab') {
        $('a[href^="#poll-tab"]').click();
    }


    // Prepare text
    vi_arr = string_vi.split(',');
    en_arr = string_en.split(',');
    obscene_arr = string_obscene.split(',');

    function set_cookie(cname, cvalue, exdays) {
        var d = new Date();
        d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
        var expires = "expires="+d.toUTCString();
        document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
    }

    function get_cookie(cname) {
        var name = cname + "=";
        var ca = document.cookie.split(';');
        for(var i = 0; i < ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0) == ' ') {
                c = c.substring(1);
            }

            if (c.indexOf(name) == 0) {
                return c.substring(name.length, c.length);
            }
        }
        return "";
    }


    var event_id = $('#event-id').val();
    var user_id = $('#user-id').val();

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
        var question_content = $('#select-search5').val().trim().replace(/  +/g, ' ');


        if (question_content.replace(/\s+/g, ' ').trim().length < 10) {
            alert('Nội dung câu hỏi tối thiểu 10 ký tự');
            $('#select-search5').focus();
            return false;
        }


        var check_question = check_question_content(question_content);
        if (check_question.valid == false) {
            alert(check_question.error);
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

    // Function check question content
    function check_question_content(content) {
        // content = content.toLowerCase().trim();
        // content = content.replace(/  +/g, ' ');

        // content = (content.replace(/[0123456789?,.:;"`~!@#$%^&*()\-_+={}\[\]><|\/\\\']+/g,'')).toLowerCase();
        content = content.toLowerCase();

        var input_text_arr = content.split(/\s+/);
        // console.log(input_text_arr);

        var correct_word = 0;
        var valid = true;

        var no_obscene_word = true;
        var enough_correct_word = true;
        var no_length_word = true;
        var no_duplicate = true;

        var error = null;
        var obscene_used = new Array();

        for (var i = 0; i < input_text_arr.length; i++) {
            if (vi_arr.includes(input_text_arr[i]) || en_arr.includes(input_text_arr[i])) {
                correct_word++;
            }
            if (obscene_arr.includes(input_text_arr[i])) {
                no_obscene_word = false;
                obscene_used.push(input_text_arr[i]);
            }
            if (input_text_arr[i].length > 6) {
                no_length_word = false;
                error = 'Vui lòng dùng từ hợp lý hơn';
            }
        }

        if (correct_word/ input_text_arr.length <= 0.7) {
            enough_correct_word = false;
            error = 'Vui lòng dùng từ hợp lý hơn';
        }

        let find_duplicate = arr => arr.filter((item, index) => arr.indexOf(item) != index)
        // console.log(find_duplicate(input_text_arr)) // All duplicates

        const unique = (value, index, self) => {
          return self.indexOf(value) === index
        }
        
        if (find_duplicate(input_text_arr).length/ input_text_arr.length > 0.5 || find_duplicate(input_text_arr).length > 5) {
            no_duplicate = false;
            error = 'Không dùng quá nhiều từ: '+find_duplicate(input_text_arr).filter(unique).join(', ');
        }



        if (!no_obscene_word) {
            const unique_obscene_used = obscene_used.filter(unique);

            if (unique_obscene_used.length > 1) {
                error = 'Vui lòng không dùng các từ: ' + unique_obscene_used.join(', ');
            } else {
                error = 'Vui lòng không dùng từ: ' + unique_obscene_used.join(', ');
            }
        }

        if (!enough_correct_word || !no_obscene_word || !no_duplicate || !no_length_word) valid = false;


        var result = {valid: valid, error: error, obscene_used: obscene_used};
        return result;
    }

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
            }
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


        var check_question = check_question_content(reply_content);
        if (check_question.valid == false) {
            alert(check_question.error);
            return false;
        }



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


    //------------------------------------------------------------------------------------------------//
    //Pusher
    var pusher2 = new Pusher('71289e96793d3248d6ec', {
        cluster: 'ap1',
        forceTLS: true
    });


    get_published_poll();

    var event_id = $('#event-id').val();
    var user_id = $('#user-id').val();

    // Change value when click checkbox
    $('body').on('click', 'input[type=checkbox]', function() {
        $(this).val(this.checked ? 1 : 0);
    })


    // Realtime published poll
    var channel_poll = pusher2.subscribe('vote-page-'+event_id);
    channel_poll.bind('refresh-published-poll', function() {
        // Load published poll
        get_published_poll();
    });



    // Disable button send vote when over choice
    $('body').on('click', '.form-check-input', function() {
        var send_button = $(this).parents('.poll-card').find('.btn-send-vote');
        var max_choice = parseInt($(this).parents('.poll-card').find('.poll-max-choice').val());
        var current_choice = $(this).parents('.poll-card').find('.list-option').find(':input[value="1"]').length;
        
        var over_choice_text = $(this).parents('.poll-card').find('.over-choice');


        if (current_choice > max_choice) {
            over_choice_text.show();
            send_button.prop('disabled', true);
        } else {
            over_choice_text.hide();
            send_button.prop('disabled', false);
        }
    })


    // Send vote
    $('body').on('click', '.btn-send-vote', function() {
        var poll_id = $(this).parent('.poll-card').find('.poll-id').val();
        var max_choice = $(this).parent('.poll-card').find('.poll-max-choice').val();

        var current_choice = $(this).parent('.poll-card').find('.list-option').find(':input[value="1"]').length;
        var over_choice_text = $(this).parent('.poll-card').find('.over-choice');

        // Check max_choice again
        if (current_choice > max_choice) {
            over_choice_text.show();
            $(this).prop('disabled', true);
            return false;
        } else if (current_choice == 0) {
            alert('Vui lòng chọn 1 lựa chọn');
            return false;
        } else {

            // Remove class editing
            $(this).parent('.poll-card').parent('div').removeClass('editing-poll');

            // Add loading
            $(this).html('<i class="fa fa-spinner fa-spin"></i>');
            
            // Get list selected option id
            list_selected_option_id = new Array();
            $.each($(this).parent('.poll-card').find('.list-option').find('.one-option'), function() {
                if ($(this).find('.form-check-input').val() == 1) list_selected_option_id.push($(this).find('.form-check-input').attr('id'));
            })
            
            $.ajax({
                url: 'process-poll.php',
                method: 'POST',
                data: {'action': 'vote-poll', 'user-id': user_id, 'poll-id': poll_id, 'list-option': list_selected_option_id}
            }).done(function(data){
                if (data.result) {
                    refresh_published_poll();

                    // Refresh result poll manage page
                    refresh_result_poll(poll_id);
                    get_all_poll();
                } else {
                    get_published_poll();
                }
            })
        }

    })


    // Click edit vote
    $('body').on('click', '.btn-edit-vote', function() {
        // Add class editing
        $(this).parent('.poll-card').parent('div').addClass('editing-poll');

        // Show text max choice
        $(this).parent('.poll-card').find('.card-text').show();

        var div_list_option = $(this).parent('.poll-card').find('.list-option');
        // console.log(div_list_option);

        // $(this).parent('.poll-card').find('.list-option')
        var rows = '';
        $.each(div_list_option.find('.one-option'), function() {
            var option_id = $(this).attr('id');
            var option_content = $(this).find('.option-content').text();
            var option_voted = ($(this).find('.option-voted').val() == 1) ? true : false;

            if (option_voted) {
                rows+= '<div class="form-check form-check-inline one-option">';
                rows+= '<input class="form-check-input" type="checkbox" id="'+option_id+'" value="1" checked>';
                rows+= '<label class="form-check-label" for="'+option_id+'">'+option_content+'</label>';
                rows+= '</div>';
            } else {
                rows+= '<div class="form-check form-check-inline one-option">';
                rows+= '<input class="form-check-input" type="checkbox" id="'+option_id+'" value="0">';
                rows+= '<label class="form-check-label" for="'+option_id+'">'+option_content+'</label>';
                rows+= '</div>';
            }
        })

        // Change checkbox for user select
        div_list_option.html(rows);

        // Change button to send
        $(this).text('Gửi');
        $(this).attr('title', 'Gửi bầu chọn');
        $(this).removeClass('btn-success').removeClass('btn-edit-vote').addClass('btn-info').addClass('btn-send-vote');

        // Show over choice text and disabled button
        var max_choice = $(this).parent('.poll-card').find('.poll-max-choice').val();
        var current_choice = $(this).parent('.poll-card').find('.list-option').find(':input[value="1"]').length;
        if (current_choice > max_choice) {
            $(this).prop('disabled', true);
            $(this).parent('.poll-card').find('.over-choice').show();
        }
    })


    function get_published_poll(){
        // Get poll id selecting
        var poll_id_selecting = new Array();
        $('#list-poll .editing-poll .list-option').each(function() {
            if ($(this).find(':input[value="1"]').length > 0) poll_id_selecting.push($(this).parent('.poll-card').find('.poll-id').val());
        })


        // Get option id selecting
        var option_id_selecting = new Array();
        $('#list-poll .form-check-input').each(function() {
            if (this.checked) option_id_selecting.push($(this).attr('id'));
        })
        // console.log(option_id_selecting)


        var event_id = $('#event-id').val();
        var user_id = $('#user-id').val();

        $.ajax({
            url: 'process-poll.php',
            method: 'POST',
            data: {'action': 'get-published-poll', 'event-id': event_id, 'user-id': user_id}
        }).done(function(data){
            // console.log(data);
            if (data.result) {
                var rows = '';
                $.each(data.poll, function(index, p) {

                    var poll_id = p.id;
                    var title = p.title;
                    var max_choice = p.max_choice;
                    var votes = p.votes;
                    var total_vote = p.total_vote;
                    var poll_voted = p.voted;

                    if (poll_voted) {
                        rows+= '<div class="card w-75 poll-voted">';
                        rows+= '<div class="card-body poll-card">';
                        rows+= '<input type="hidden" class="poll-id" value="'+poll_id+'">';
                        rows+= '<input type="hidden" class="poll-max-choice" value="'+max_choice+'">';
                        rows+= '<h6>';
                        rows+= '<span class="card-title poll-title">'+title+'</span>';
                        rows+= '<span class="pull-right num-votes" title="Số người đã bầu chọn">'+votes+' <i class="fa fa-user"></i></span>';
                        rows+= '</h6>';
                        rows+= '<hr>';
                        rows+= '<p class="card-text" hidden><small class="text-muted">Số câu trả lời được phép chọn: '+max_choice+'</small></p>';
                        rows+= '<div class="list-option">';

                        $.each(data.list_option, function(index, o) {
                            var option_id = o.id;
                            var option_content = o.content;
                            var option_voted = o.voted;

                            var percent = o.total_vote*100/total_vote;
                            percent =  Math.round(percent * 100) / 100;
                            if (total_vote == 0) percent = 0;


                            if (poll_id == o.poll_id) {
                                if (option_voted) {
                                    rows+= '<div class="form-check form-check-inline one-option" id="'+o.id+'">';
                                    rows+= '<input type="hidden" class="option-voted" value="1">'
                                    rows+= '<p class="option-content">'+option_content+'</p>';
                                    rows+= '<div class="progress">';
                                    rows+= '<div class="progress-bar progress-bar-striped actives progress-bar-danger" role="progressbar" style="width: '+percent+'%;" aria-valuenow="'+percent+'" aria-valuemin="0" aria-valuemax="100">'+percent+'%</div>';
                                    rows+= '</div>';
                                    rows+= '</div>';
                                } else {
                                    rows+= '<div class="form-check form-check-inline one-option" id="'+o.id+'">';
                                    rows+= '<input type="hidden" class="option-voted" value="0">'
                                    rows+= '<p class="option-content">'+option_content+'</p>';
                                    rows+= '<div class="progress">';
                                    rows+= '<div class="progress-bar progress-bar-striped actives progress-bar-grey" role="progressbar" style="width: '+percent+'%;" aria-valuenow="'+percent+'" aria-valuemin="0" aria-valuemax="100">'+percent+'%</div>';
                                    rows+= '</div>';
                                    rows+= '</div>';

                                }
                            }


                        })


                        rows+= '</div>';
                        rows+= '<h6 class="text-danger over-choice" hidden>Bạn đã chọn nhiều hơn mức cho phép</h6>';
                        rows+= '<button type="button" class="btn btn-success btn-edit-vote" title="Sửa bầu chọn">Sửa bầu chọn</button>';
                        rows+= '</div>';
                        rows+= '</div>';
                    } else {

                        rows+= '<div class="card w-75 poll-no-vote">';
                        rows+= '<div class="card-body poll-card">';
                        rows+= '<input type="hidden" class="poll-id" value="'+poll_id+'">';
                        rows+= '<input type="hidden" class="poll-max-choice" value="'+max_choice+'">';
                        rows+= '<h6>';
                        rows+= '<span class="card-title poll-title">'+title+'</span>';
                        rows+= '<span class="pull-right num-votes" title="Số người đã bầu chọn">'+votes+' <i class="fa fa-user"></i></span>';
                        rows+= '</h6>';
                        rows+= '<hr>';
                        rows+= '<p class="card-text"><small class="text-muted">Số câu trả lời được phép chọn: '+max_choice+'</small></p>';
                        rows+= '<div class="list-option">';

                        $.each(data.list_option, function(index, o) {

                            var option_id = o.id;
                            var option_content = o.content;

                            if (poll_id == o.poll_id) {
                                rows+= '<div class="form-check form-check-inline one-option">';
                                rows+= '<input class="form-check-input" type="checkbox" id="'+option_id+'" value="0">';
                                rows+= '<label class="form-check-label" for="'+option_id+'">'+option_content+'</label>';
                                rows+= '</div>';
                            }

                        })


                        rows+= '</div>';
                        rows+= '<h6 class="text-danger over-choice" hidden>Bạn đã chọn nhiều hơn mức cho phép</h6>';
                        rows+= '<button type="button" class="btn btn-info btn-send-vote" title="Gửi bầu chọn">Gửi</button>';
                        rows+= '</div>';
                        rows+= '</div>';
                    }
                })
            } else {
                rows = '<h3 class="text-center">Chưa có bầu chọn</h3>';
            }
            $('#list-poll').html(rows);

            // write_published_poll(data);

            // 
            for (var i = 0; i < poll_id_selecting.length; i++) {
                id = poll_id_selecting[i];

                // Show text max choice
                $('.poll-id[value="'+id+'"]').parent('.poll-card').find('.card-text').show();
                
                // Add class editing
                $('.poll-id[value="'+id+'"]').parent('.poll-card').parent('div').addClass('editing-poll');

                // Button
                $('.poll-id[value="'+id+'"]').parent('.poll-card').find('button').removeClass('btn-success').removeClass('btn-edit-vote').addClass('btn-info').addClass('btn-send-vote').text('Gửi');

                div_list_option = $('.poll-id[value="'+id+'"]').parent('.poll-card').find('.list-option');


                var rows = '';
                $.each(div_list_option.find('.one-option'), function() {
                    var option_id = $(this).attr('id');
                    var option_content = $(this).find('.option-content').text();
                    var option_voted = ($(this).find('.option-voted').val() == 1) ? true : false;

                    rows+= '<div class="form-check form-check-inline one-option">';
                    rows+= '<input class="form-check-input" type="checkbox" id="'+option_id+'" value="0">';
                    rows+= '<label class="form-check-label" for="'+option_id+'">'+option_content+'</label>';
                    rows+= '</div>';
                })
                div_list_option.html(rows);

            }


            // Recheck option be selected
            for (var i = 0; i < option_id_selecting.length; i++) {
                id = option_id_selecting[i];
                $('#'+id).prop('checked', true).val(1);
            }

            // Disable send button for each poll over choice
            $('#list-poll .poll-card').each(function() {
                // var poll_id = $(this).find('.poll-id').val();
                var voted = ($(this).parent('div').hasClass('poll-voted')) ? true : false;
                var editing = ($(this).parent('div').hasClass('editing-poll')) ? true : false;
                var max_choice = $(this).find('.poll-max-choice').val();
                var current_choice = $(this).find('.list-option').find(':input[value="1"]').length;
                var over_choice_text = $(this).find('.over-choice');
                var button_send_vote = $(this).find('.btn-send-vote');

                if (current_choice > max_choice) {
                    if (!voted || editing) over_choice_text.show();
                    button_send_vote.prop('disabled', true);
                } else {
                    over_choice_text.hide();
                    button_send_vote.prop('disabled', false);
                }
            })




        }).fail(function(jqXHR, statusText, errorThrown){
              console.log("Fail:"+ jqXHR.responseText);
              console.log(errorThrown);
        })
    }


    function get_all_poll() {
        $.ajax({
            url: 'process-poll.php',
            method: 'POST',
            data: {'action': 'get-all-poll', 'event-id': event_id}
        })
    }

    function refresh_published_poll() {
        var event_id = $('#event-id').val();
        $.ajax({
            url: 'process-poll.php',
            method: 'POST',
            data: {'action': 'refresh-published-poll', 'event-id': event_id}
        })
    }

    function refresh_result_poll(poll_id) {
        $.ajax({
            url: 'process-poll.php',
            method: 'POST',
            data: {'action': 'refresh-result-poll', 'poll-id': poll_id}
        })
    }



</script>
    
</body>

</html>