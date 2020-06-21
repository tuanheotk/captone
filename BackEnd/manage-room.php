<?php
$title = 'Quản lý câu hỏi';
include('header.php');
if (isset($_GET["id"])) {
    $event_id = $_GET["id"];
    // $sqlCheckAuthor = "SELECT id, title, check_question FROM event WHERE id = ".$event_id." AND account_id = '".$account_id."'";
    if ($account_role == 4) {
        $sqlCheckAuthor = "SELECT id, title, check_question, user_make_question, user_reply_question FROM event WHERE status != 5 AND id = $event_id";
    } else {
        $sqlCheckAuthor = "SELECT id, title, check_question, user_make_question, user_reply_question FROM event WHERE status != 5 AND id = ".$event_id." AND account_id = ".$account_id." UNION SELECT e.id, e.title, e.check_question, e.user_make_question, e.user_reply_question FROM event e, moderator m WHERE e.status !=5 AND e.id = m.event_id AND m.event_id = ".$event_id." AND m.email = '".$account_email."'";
    }
    
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
                    <h4>Quản lý câu hỏi & bầu chọn (<?php echo shortTitle($event_name) ?>)</h4>
                    <input type="hidden" id="event-id" value="<?php echo $event_id ?>">
                    <input type="hidden" id="user-id" value="<?php echo $account_id ?>">
                    <input type="hidden" id="user-fullname" value="<?php echo $account_name ?>">
                    
                    <div class="db-2-main-com" id="fix-padding">
                        <div class="containers">
                            <ul class="nav nav-tabs nav-justified">
                            <li class="active">
                                <a data-toggle="tab" href="#question-tab">Câu hỏi</a>
                            </li>
                            <li>
                                <a data-toggle="tab" href="#poll-tab">Bầu chọn</a>
                            </li>
                            <li>
                                <a data-toggle="tab" href="#statistic-tab">Thống kê</a>
                            </li>
                        </ul>

                        <!-- Content tab -->
                        <div class="tab-content">

                            <!-- Question tab -->
                            <div id="question-tab" class="tab-pane fade in active">
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
                            <!-- End question tab -->

                            <!-- Poll tab -->
                            <div id="poll-tab" class="tab-pane fade">
                                <section class="container-full">
                                    <div class="row" id="fix-margin">

                                        <!-- List poll -->
                                        <div class=" col-md-6 fix-lr-padding">
                                            <h4 class="text-center bg-danger" id="num-pending" data-toggle="modal" data-target="#create-poll-modal">Tạo danh sách bầu chọn <i class="fa fa-plus"></i></h4>

                                            <div class="col-md-12 askquestion-border" id="list-poll">
                                                <div class="card w-75 text-center">
                                                    <i class="fa fa-spinner fa-spin"></i>
                                                </div>

                                                
                                                
                                            </div>

                                        </div>
                                        <!-- End list poll -->

                                        <!-- Result poll-->
                                        <div class=" col-md-6 fix-lr-padding">
                                            <h4 class="text-center bg-danger">Kết quả</h4>

                                            <div class="col-md-12 askquestion-border" id="result-poll">
                                                <h3 class="text-center">Chọn để hiển thị</h3>
                                            </div>
                                        </div>
                                        <!-- End list poll -->
                                    </div>
                                </section>
                            </div>
                            <!-- End polll tab -->

                            <!-- Statistic tab -->
                            <div id="statistic-tab" class="tab-pane fade">
                                <!-- <h3>Thống kê</h3>
                                <p>Giao diện của thống kê</p> -->
                                <section class="container-full">
                                    <div class="row" id="fix-margin">
                                        <div class=" col-md-6 fix-lr-padding">
                                            <h4 class="text-center bg-danger">Câu hỏi <i class="fa fa-question-circle-o"></i></h4>
                                            <div class="col-md-12 askquestion-border">
                                                <div class="card w-75">
                                                    <div class="card-body askquestion">
                                                        <h5 class="card-title">Tổng số câu hỏi: <span class="card-title" id="statistic-question">0</span> </h5>
                                                        <h5 class="card-title">Tổng số câu trả lời: <span class="card-title" id="statistic-reply">0</span></h5>
                                                        <h5 class="card-title">Lượt yêu thích: <span class="card-title" id="statistic-like">0</span> </i></h5>
                                                        <button class="btn btn-success" type="button" data-toggle="modal" data-target="#export-question-modal">
                                                            Xuất file câu hỏi <i class="fa fa-download"></i>
                                                        </button>
                                                        
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <div class=" col-md-6 fix-lr-padding">
                                            <h4 class="text-center bg-danger">Cuộc bầu chọn <i class="fa fa-hand-o-left"></i></h4>
                                            <div class="col-md-12 askquestion-border">
                                                <div class="card w-75">
                                                    <div class="card-body askquestion">
                                                        <h5 class="card-title">Tổng số cuộc bầu chọn được tạo: <span class="card-title" id="statistic-poll">0</span> </h5>
                                                        <h5 class="card-title">Số người tham gia bầu chọn: <span class="card-title" id="statistic-votes">0</span></h5>
                                                        <button class="btn btn-success" type="button" data-toggle="modal" data-target="#export-poll-modal">
                                                            Xuất file bầu chọn <i class="fa fa-download"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                            </div>
                            <!-- End statistic tab -->
                        </div>
                        <!-- End content tab -->
                            
                        </div>

                         
                    </div>
                </div>
            </div>
            
            <!-- Modal of question -->
            <!-- Edit question modal -->
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
            <!-- End modal of question -->

            <!-- Modal of poll -->
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
                                    <button class="btn btn-info" type="button" id="btn-add-option">Thêm lựa chọn</button>
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
            <!-- End modal of poll -->

            <!-- Modal of statistic -->
            <!-- Export Question Modal-->
            <div id="export-question-modal" class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title"> Xuất file câu hỏi</h4>
                        </div>
                        <div class="modal-body">
                            <p>Bạn có muốn xuất danh sách câu hỏi và câu trả lời sang định dạng excel không?</p>
                            <iframe name="question" src="" hidden></iframe>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Hủy</button>
                            <button type="button" class="btn btn-success" data-dismiss="modal" id="btn-export-question">Xuất</button>
                        </div>
                    </div>
                </div>              
            </div>

            <!-- Export Poll Modal -->
            <div id="export-poll-modal" class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title"> Xuất file bầu chọn</h4>
                        </div>
                        <div class="modal-body">
                            <p>Bạn có muốn xuất danh sách bầu chọn sang định dạng excel không?</p>
                            <iframe name="poll" src="" hidden></iframe>          
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Hủy</button>
                            <button type="button" class="btn btn-success" data-dismiss="modal" id="btn-export-poll">Xuất</button>
                        </div>
                    </div>
                </div>              
            </div>
            <!-- End modal of statistic -->


    </section>
    <!--END DASHBOARD-->
<?php

include('footer.php');
?>
<script type="text/javascript">

    // get_pending_question();
    get_published_question();


    $('a[href^="#question-tab"]').click(function(){
        document.title = 'Quản lý câu hỏi - EventBox Văn Lang';
    })

    $('a[href^="#poll-tab"]').click(function(){
        document.title = 'Quản lý bầu chọn - EventBox Văn Lang';
    })

    $('a[href^="#statistic-tab"]').click(function(){
        document.title = 'Thống kê - EventBox Văn Lang';
    })


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

                if (data.liked.length > 0) {
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
                } else {
                    liked = false;
                }

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

                    if (data.liked.length > 0) {
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
                    } else {
                        liked = false;
                    }

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

    // -------------------------------------------------------------------------------------------------//
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
        var count_poll = 0;
        var count_votes = 0;
        if (data.result) {
            var rows = '';
            count_poll = data.poll.length;
            $.each(data.poll, function(index, p) {
                count_votes += parseInt(p.votes);

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

        // Set for statistic
        $('#statistic-poll').text(count_poll);
        $('#statistic-votes').text(count_votes);
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

        if (count < 20) {
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
            alert('Tối đa 20 lựa chọn');
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


    var poll_is_selecting;
    // Select poll to view result
    $('body').on('click', '.one-poll', function(){

        // Remove class selected for other div
        $('#list-poll .one-poll').removeClass('poll-selected');
        
        // Add class selected
        $(this).addClass('poll-selected');
        var poll_selected_id = $('.poll-selected').find('.poll-id').val();

        poll_is_selecting = poll_selected_id;

        // Add loading
        $('#result-poll').html('<h3 class="text-center"><i class="fa fa-spinner fa-spin"></i></h3>');

        var poll_id = $(this).find('.poll-id').val();
        // var poll_title = $(this).find('.card-title').text();

        show_result_poll(poll_id);

        // Get result realtime
        var channel_poll_2 = pusher2.subscribe('refresh-result-poll');
        channel_poll_2.bind('poll-'+poll_id, function(data) {

            if (data == poll_is_selecting) show_result_poll(poll_id);
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

                // Reload result poll
                refresh_result_poll(poll_id);

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

                // Reload result poll
                refresh_result_poll(poll_id);

                // Reset view result poll
                // if (poll_id == poll_selected_id) show_result_poll(poll_id);
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
            var count_poll = 0;
            var count_votes = 0;
            if (data.result) {
                var rows = '';
                count_poll = data.poll.length;
                $.each(data.poll, function(index, p) {
                    count_votes += parseInt(p.votes);

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

            // Set for statistic
            $('#statistic-poll').text(count_poll);
            $('#statistic-votes').text(count_votes);
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
                    rows+= '<div class="progress-bar progress-bar-stripedd actived progress-bar-success" role="progressbar" style="width: '+percent+'%;" aria-valuenow="'+percent+'" aria-valuemin="0" aria-valuemax="100">'+percent+'%</div>';
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


    function refresh_published_poll() {
        var event_id = $('#event-id').val();
        $.ajax({
            url: 'process-poll.php',
            method: 'POST',
            data: {'action': 'refresh-published-poll', 'event-id': event_id}
        })
    }



    // -------------------------------------------------------------------------------------------------//

    $('#btn-export-question').click(function() {
        window.frames['question'].location = 'export-question.php?id='+event_id;
    })

    $('#btn-export-poll').click(function() {
        window.frames['poll'].location = 'export-poll.php?id='+event_id;
    })
    

</script>