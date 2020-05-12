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
                    <h4>Thống kê (<?php echo shortTitle($event_name) ?>)</h4>
                    <input type="hidden" id="event-id" value="<?php echo $event_id ?>">
                    <input type="hidden" id="user-id" value="<?php echo $account_id ?>">
                    <input type="hidden" id="user-fullname" value="<?php echo $account_name ?>">
                    
                    <div class="db-2-main-com" id="fix-padding">
                        

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
                                                <h5 class="card-title">Tổng số người bầu chọn: <span class="card-title" id="statistic-votes">0</span></h5>
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
                </div>
            </div>
            

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


    </section>
    <!--END DASHBOARD-->
<?php

include('footer.php');
?>
<script type="text/javascript">
    var event_id = $('#event-id').val();

    $('#btn-export-question').click(function() {
        window.frames['question'].location = 'test.php?id='+event_id;
    })

</script>