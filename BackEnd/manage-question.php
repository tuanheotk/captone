<?php
$title = 'Quản lý câu hỏi';
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
                    <h4>Quản lý câu hỏi (<?php echo shortTitle($event_name) ?>)</h4>
                    <input type="hidden" id="event-id" value="<?php echo $event_id ?>">
                    <input type="hidden" id="user-id" value="<?php echo $account_id ?>">
                    <input type="hidden" id="user-fullname" value="<?php echo $account_name ?>">
                    
                    <div class="db-2-main-com" id="fix-padding">
                        <div class="containers">
                            <ul class="nav nav-tabs nav-justified">
                            <li class="active">
                                <a data-toggle="tab" href="#question">Câu hỏi</a>
                            </li>
                            <li>
                                <a data-toggle="tab" href="#poll">Bầu chọn</a>
                            </li>
                            <li>
                                <a data-toggle="tab" href="#statistic">Thống kê</a>
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
                            <div id="statistic" class="tab-pane fade">
                                <h3>Thống kê</h3>
                                <p>Giao diện của thống kê</p>
                            </div>
                        </div>
                            
                        </div>

                        <section class="container">
                            <!-- Ask -->
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="col-md-12">
                                        <div class="custom-control custom-switch" id="check-question-status">
                                            <?php
                                            if ($check_question == 1) {
                                                echo '<input type="checkbox" class="custom-control-input" id="check-question" checked>';
                                            } else {
                                                echo '<input type="checkbox" class="custom-control-input" id="check-question">';
                                            }
                                            
                                            ?>
                                            <label class="custom-control-label" for="check-question">Duyệt câu hỏi</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">


                                    <div class="col-md-12">
                                        <div class="custom-control custom-switch" id="user-make-question-status">
                                            <?php
                                            if ($user_make_question == 1) {
                                                echo '<input type="checkbox" class="custom-control-input" id="user-make-question" checked>';
                                            } else {
                                                echo '<input type="checkbox" class="custom-control-input" id="user-make-question">';
                                            }
                                            
                                            ?>
                                            <label class="custom-control-label" for="user-make-question">Người tham dự đặt câu hỏi</label>
                                        </div>
                                    </div>


                                </div>

                                <div class="col-md-4">


                                    <div class="col-md-12">
                                        <div class="custom-control custom-switch" id="user-reply-question-status">
                                            <?php
                                            if ($user_reply_question == 1) {
                                                echo '<input type="checkbox" class="custom-control-input" id="user-reply-question" checked>';
                                            } else {
                                                echo '<input type="checkbox" class="custom-control-input" id="user-reply-question">';
                                            }
                                            
                                            ?>
                                            <label class="custom-control-label" for="user-reply-question">Người tham dự trả lời câu hỏi</label>
                                        </div>
                                    </div>


                                </div>



                            </div>
                        </section>

                        <section class="container-full">
                            <div class="row" id="fix-margin">

                                <!-- List pending question -->
                                <div class=" col-md-6 fix-lr-padding">
                                    <h4 class="text-center bg-danger" id="num-pending">Câu hỏi chờ duyệt</h4>

                                    <div class="col-md-12 askquestion-border" id="list-pending-question">
                                        <?php
                                        $sql_get_pending_question = "SELECT * FROM question WHERE status = 0 AND event_id = $event_id ORDER BY id DESC";
                                        $result_pending_question = mysqli_query($conn, $sql_get_pending_question);

                                        if (mysqli_num_rows($result_pending_question) > 0) {
                                            while ($row_pending_question = mysqli_fetch_assoc($result_pending_question)) {
                                                $fullname = $row_pending_question["user_fullname"];
                                                $question_id = $row_pending_question["id"];
                                                $question_content = $row_pending_question["content"];
                                                $time = date("H:i - d/m/Y", strtotime($row_pending_question["create_at"]));

                                        ?>

                                        <div class="card w-75">
                                            <div class="card-body askquestion">

                                                <input type="hidden" class="question-id" value="<?php echo $question_id ?>">

                                                <h5 class="card-title"><?php echo $fullname ?></h5>
                                                <p class="card-text question-content"><?php echo $question_content ?></p>
                                                <p class="card-text"><small class="text-muted"><?php echo $time ?></small></p>
                                                <a href="#" class="custom-btn custom-edit btn-edit-question" data-toggle="modal" data-target="#edit-question-modal" title="Sửa câu hỏi"><i class="fa fa-pencil"></i></a>
                                                <button type="button" title="Chấp nhận câu hỏi" class="custom-btn custom-reply btn-accept-question"><i class="fa fa-check" aria-hidden="true"></i></button>
                                                <button type="button" title="Từ chối câu hỏi" class="custom-btn custom-del btn-deny-question"><i class="fa fa-times" aria-hidden="true"></i></button>
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
                                <!-- End list pending question -->

                                <!-- List published question -->
                                <div class=" col-md-6 fix-lr-padding">
                                    <h4 class="text-center bg-danger" id="num-published">Câu hỏi đã công khai</h4>

                                    <div class="col-md-12 askquestion-border" id="list-published-question">
                                        
                                        <?php
                                        $sql_get_published_question = "SELECT q.*, COUNT(r.user_id) AS num_like FROM question q LEFT JOIN reaction r ON q.id = r.question_id WHERE q.status = 1 AND q.event_id = $event_id GROUP BY q.id ORDER BY q.pinned DESC, q.id DESC";
                                        $result_published_question = mysqli_query($conn, $sql_get_published_question);

                                        if (mysqli_num_rows($result_published_question) > 0) {
                                            while ($row_pending_question = mysqli_fetch_assoc($result_published_question)) {
                                                $fullname = $row_pending_question["user_fullname"];
                                                $question_id = $row_pending_question["id"];
                                                $question_content = $row_pending_question["content"];
                                                $pinned = $row_pending_question["pinned"];
                                                $num_like = ($row_pending_question["num_like"] > 0) ? $row_pending_question["num_like"] : '';
                                                $time = date("H:i - d/m/Y", strtotime($row_pending_question["create_at"]));

                                        ?>

                                        <div class="card w-75">
                                            <div class="card-body askquestion">
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

                                                
                                                <a href="#" type="button" class="custom-btn custom-reply btn-reply-question" data-toggle="modal" data-target="#reply-question-modal" title="Trả lời"> <i class="fa fa-reply"></i></a>

                                                <?php

                                                if ($pinned == 0) {
                                                    echo '<button type="button" title="Ghim câu hỏi" class="custom-btn custom-pin btn-pin-question" value ="0"><i class="fa fa-check-circle-o" aria-hidden="true"></i></button>';
                                                } else {
                                                    echo '<button type="button" title="Bỏ ghim câu hỏi" class="custom-btn custom-pinned btn-pin-question" value ="1"><i class="fa fa-check-circle" aria-hidden="true"></i></button>';
                                                }
                                                

                                                ?>
                                                <input type="hidden" class="question-id" value="<?php echo $question_id ?>">
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
                                <!-- End list published quesion -->
                            </div>
                        </section>  
                    </div>
                </div>
            </div>
            

            <div id="edit-question-modal" class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title"> Chỉnh sửa câu hỏi</h4>
                        </div>
                        <div class="modal-body">
                            <!-- <input type="text" class="form-control" id="tb-edit-question" maxlength="300"> -->
                            <textarea rows="3" class="form-control" id="tb-edit-question"></textarea>

                            <input type="hidden" id="question-id-update">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-success" data-dismiss="modal" id="btn-update-question">Lưu</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Hủy</button>
                        </div>
                    </div>               
                </div>
                
            </div>

            
        
            <!-- Reply Question Modal -->
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
                                <div class="col-md-10 col-10">
                                    <textarea rows="4" type="text" class="form-control" id="reply-content" placeholder="Nhập câu trả lời của bạn" aria-describedby="basic-addon2" maxlength="300"></textarea>
                                    <div class="text-muted">
                                        <span id="count-char">0</span> <span>/ 300</span>
                                    </div>
                                </div>
                                <div class="col-md-2 col-2">
                                    <div class="input-group-append">
                                        <input type="hidden" id="question-id">
                                        <button class="btn btn-success " id="btn-send-reply" type="button">Trả lời</button>
                                    </div>
                                </div>
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
    get_published_question();


    var event_id = $('#event-id').val();

    // Pusher
    var pusher = new Pusher('51111816fa8714dbec22', {
        cluster: 'ap1',
        forceTLS: true
        // encrypted: true
    });


    // Realtime get pending question
    var channel = pusher.subscribe('manage-ask-'+event_id);
    channel.bind('pending-question', function(data) {
        // console.log(data);
        
        // Load list pending question realtime
        var count_question = 0;
        if (data.result) {
            var rows = '';
            count_question = data.questions.length;
            $.each(data.questions, function(index, q) {
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
        $('#num-pending').text('Câu hỏi chờ duyệt (' + count_question + ')');
    })


    // Realtime get published question
    var channel2 = pusher.subscribe('ask-page-'+event_id);
    channel2.bind('published-question', function(data) {
        // console.log(data);
        // Load list published question
        var user_id = $('#user-id').val();

        var count_question = 0;
        var count_like = 0;
        var count_reply = 0;
        if (data.result) {
            var rows = '';
            count_question = data.questions.length;
            count_like = data.liked.length;
            $.each(data.questions, function(index, q) {
                count_reply += parseInt(q.num_reply);
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

                rows+= '<a href="#" class="custom-btn custom-reply btn-reply-question" data-toggle="modal" data-target="#reply-question-modal" title="Trả lời">'+q.num_reply+' <i class="fa fa-reply" ></i></a> ';


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
        $('#num-published').text('Câu hỏi đã công khai (' + count_question + ')');

        // Set for statistic
        $('#statistic-question').text(count_question);
        $('#statistic-reply').text(count_reply);
        $('#statistic-like').text(count_like);
    })


    // Realtime check question status
    // var channel3 = pusher.subscribe('manage-ask');
    channel.bind('check-question-status', function(status) {
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
    // var channel4 = pusher.subscribe('manage-ask');
    channel.bind('user-make-question-status', function(status) {
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
    // var channel5 = pusher.subscribe('manage-ask');
    channel.bind('user-reply-question-status', function(status) {
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
            var count_question = 0;
            if (data.result) {
                var rows = '';
                count_question = data.questions.length;
                $.each(data.questions, function(index, q) {
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
            $('#num-pending').text('Câu hỏi chờ duyệt (' + count_question + ')');
        })
    }

    // Function load published question
    function get_published_question(){
        var event_id = $('#event-id').val();
        var user_id = $('#user-id').val();
        $.ajax({
            url: 'process-question.php',
            method: 'POST',
            data: {'action': 'get-published-question', 'event-id': event_id}
        }).done(function(data) {
            var count_question = 0;
            var count_like = 0;
            var count_reply = 0;
            if (data.result) {
                var rows = '';
                count_question = data.questions.length;
                count_like = data.liked.length;
                $.each(data.questions, function(index, q) {
                    count_reply += parseInt(q.num_reply);
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

                    rows+= '<a href="#" class="custom-btn custom-reply btn-reply-question" data-toggle="modal" data-target="#reply-question-modal" title="Trả lời">'+q.num_reply+' <i class="fa fa-reply" ></i></a> ';


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
            $('#num-published').text('Câu hỏi đã công khai (' + count_question + ')');

            // Set for statistic
            $('#statistic-question').text(count_question);
            $('#statistic-reply').text(count_reply);
            $('#statistic-like').text(count_like);
        }).fail(function(jqXHR, statusText, errorThrown){
              console.log("Fail:"+ jqXHR.responseText);
              console.log(errorThrown);
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


    // Click edit question
    $('body').on('click', '.btn-edit-question', function(){
        var question_content = $(this).parent('div').find('.question-content').text();
        var question_id = $(this).parent('div').find('.question-id').val();
        $('#tb-edit-question').val(question_content);
        $('#question-id-update').val(question_id);

    })

    $('#btn-update-question').click(function(){
        var question_id = $('#question-id-update').val();
        var question_content = $('#tb-edit-question').val();

        if (question_content.replace(/\s+/g, ' ').trim().length < 10) {
            alert('Nội dung câu hỏi tối thiểu 10 ký tự');
            $('#tb-edit-question').focus();
            return false;
        }

        $.ajax({
            url: 'process-question.php',
            method: 'POST',
            data: {'action': 'mod-edit-question','question-id': question_id, 'question-content': question_content}
        }).done(function(data) {
            get_pending_question();
        })
    })

    // Click accept question
    $('body').on('click', '.btn-accept-question', function(){
        var question_id = $(this).parent('div').find('.question-id').val();
        
        // Add loading
        $(this).html('<i class="fa fa-spinner fa-spin"></i>');

        $.ajax({
            url: 'process-question.php',
            method: 'POST',
            data: {'action': 'mod-accept-question', 'question-id': question_id}
        }).done(function(data){
            get_pending_question();
            get_published_question();
        })
    })

    // Click deny question
    $('body').on('click', '.btn-deny-question', function(){
        var question_id = $(this).parent('div').find('.question-id').val();
        
        // Add loading
        $(this).html('<i class="fa fa-spinner fa-spin"></i>');

        $.ajax({
            url: 'process-question.php',
            method: 'POST',
            data: {'action': 'mod-deny-question', 'question-id': question_id}
        }).done(function(data){
            get_pending_question();
            // get_published_question();
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

    // Change pin question
    $('body').on('click', '.btn-pin-question', function(){
        var question_id = $(this).parent('div').find('.question-id').val();
        new_pin_status = ($(this).val() == 0) ? 1 : 0;

        // Add loading
        $(this).html('<i class="fa fa-spinner fa-spin"></i>');

        $.ajax({
            url: 'process-question.php',
            method: 'POST',
            data: {'action': 'mod-pin-question', 'question-id': question_id, 'new-pin-status': new_pin_status}
        }).done(function(data){
            // alert(data.message);
            get_published_question();
        })
    })




    // Change check question
    $('body').on('click', '#check-question', function(){
        var event_id = $('#event-id').val();
        $(this).val(this.checked ? 1 : 0);

        var status = $(this).val();

        $.ajax({
            url: 'process-question.php',
            method: 'POST',
            data: {'action': 'change-check-question', 'event-id': event_id, 'check-question-status': status}
        }).done(function(data){
            // alert(data.message);
        })
    })




    // Change user make question
    $('body').on('click', '#user-make-question', function(){
        var event_id = $('#event-id').val();
        $(this).val(this.checked ? 1 : 0);

        var status = $(this).val();

        $.ajax({
            url: 'process-question.php',
            method: 'POST',
            data: {'action': 'change-user-make-question', 'event-id': event_id, 'user-make-question-status': status}
        }).done(function(data){
            // alert(data.message);
        })
    })


    

    // Change user reply question
    $('body').on('click', '#user-reply-question', function(){
        var event_id = $('#event-id').val();
        $(this).val(this.checked ? 1 : 0);

        var status = $(this).val();

        $.ajax({
            url: 'process-question.php',
            method: 'POST',
            data: {'action': 'change-user-reply-question', 'event-id': event_id, 'user-reply-question-status': status}
        }).done(function(data){
            // alert(data.message);
        })
    })    



    

</script>