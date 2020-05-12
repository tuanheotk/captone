<?php
$title = 'Bầu chọn';
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
                <h2>Hãy đặt câu hỏi cho sự kiện</h2>
                <h2>Mã sự kiện: <span><?php echo $event_code ?></span></h2>
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
            

            <div class="card w-75">   
                <div class="card-body poll-card">
                    <input type="hidden" class="poll-id" value="">
                    <input type="hidden" class="poll-max-choice" value="">
                    <h6>
                        <span class="card-title">Các bạn thích ăn gì trong ngày nghỉ dịch?</span>
                        <span class="pull-right" title="Số người đã bầu chọn">50 <i class="fa fa-user"></i></span>
                    </h6>
                    <hr>

                    <p class="card-text"><small class="text-muted">Số câu trả lời được phép chọn: 2</small></p>

                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="">
                        <label class="form-check-label" for="inlineCheckbox1">Tôm hùm</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" id="inlineCheckbox2" value="">
                        <label class="form-check-label" for="inlineCheckbox2">Thịt bò</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" id="inlineCheckbox3" value="">
                        <label class="form-check-label" for="inlineCheckbox3">Mì Hải sản</label>
                    </div>
                    <button type="button" class="btn btn-info" title="Gửi">Gửi</button>
                </div>
            </div>


            <div class="card w-75">   
                <div class="card-body poll-card">
                    <input type="hidden" class="poll-id" value="">
                    <input type="hidden" class="poll-max-choice" value="">

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


<?php include('footer.php') ?>
<script type="text/javascript">
    //Pusher
    var pusher2 = new Pusher('71289e96793d3248d6ec', {
        cluster: 'ap1',
        forceTLS: true
    });


    get_published_poll();

    var event_id = $('#event-id').val();

    $(document).ready(function(){
        // Change checkbox
        $('input[type=checkbox]').on('click', function() {
            $(this).val(this.checked ? 1 : 0);
        })

    })


    // Realtime published poll
    var channel_poll = pusher2.subscribe('vote-page-'+event_id);
    channel_poll.bind('refresh-published-poll', function() {
        // Load published poll
        get_published_poll();
    });

    



    function get_published_poll(){

        // Check id option selected
        var option_id_selected = new Array();
        $('#list-poll .poll-no-vote .form-check-input').each(function(){
            if (this.checked) option_id_selected.push($(this).attr('id'));
        })
        // console.log(option_id_selected);

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
                                    rows+= '<div class="form-check form-check-inline">';
                                    rows+= '<p class="poll-title">'+option_content+'</p>';
                                    rows+= '<div class="progress">';
                                    rows+= '<div class="progress-bar progress-bar-stripeds actives progress-bar-danger" role="progressbar" style="width: '+percent+'%;" aria-valuenow="'+percent+'" aria-valuemin="0" aria-valuemax="100">'+percent+'%</div>';
                                    rows+= '</div>';
                                    rows+= '</div>';
                                } else {
                                    rows+= '<div class="form-check form-check-inline">';
                                    rows+= '<p class="poll-title">'+option_content+'</p>';
                                    rows+= '<div class="progress">';
                                    rows+= '<div class="progress-bar progress-bar-stripeds actives progress-bar-grey" role="progressbar" style="width: '+percent+'%;" aria-valuenow="'+percent+'" aria-valuemin="0" aria-valuemax="100">'+percent+'%</div>';
                                    rows+= '</div>';
                                    rows+= '</div>';

                                }
                            }


                        })


                        rows+= '</div>';
                        rows+= '<button type="button" class="btn btn-success" title="Sửa">Sửa bầu chọn</button>';
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
                                rows+= '<div class="form-check form-check-inline">';
                                rows+= '<input class="form-check-input" type="checkbox" id="'+option_id+'" value="0">';
                                rows+= '<label class="form-check-label" for="'+option_id+'">'+option_content+'</label>';
                                rows+= '</div>';
                            }

                        })


                        rows+= '</div>';
                        rows+= '<button type="button" class="btn btn-info" title="Gửi">Gửi</button>';
                        rows+= '</div>';
                        rows+= '</div>';
                    }
                })
            } else {
                rows = '<h3 class="text-center">Chưa có bầu chọn</h3>';
            }
            $('#list-poll').html(rows);

            // write_published_poll(data);

            for (var i = 0; i < option_id_selected.length; i++) {
                id = option_id_selected[i];
                $('#'+id).prop('checked', true).val(1);
            }

        }).fail(function(jqXHR, statusText, errorThrown){
              console.log("Fail:"+ jqXHR.responseText);
              console.log(errorThrown);
        })
    }


    // function write_published_poll(data) {
    //     if (data.result) {
    //         var rows = '';
    //         $.each(data.poll, function(index, p) {

    //             var poll_id = p.id;
    //             var title = p.title;
    //             var max_choice = p.max_choice;
    //             var votes = p.votes;
    //             var total_vote = p.total_vote;
    //             var poll_voted = p.voted;

    //             if (poll_voted) {
    //                 rows+= '<div class="card w-75 poll-voted">';
    //                 rows+= '<div class="card-body poll-card">';
    //                 rows+= '<input type="hidden" class="poll-id" value="'+poll_id+'">';
    //                 rows+= '<input type="hidden" class="poll-max-choice" value="'+max_choice+'">';
    //                 rows+= '<h6>';
    //                 rows+= '<span class="card-title poll-title">'+title+'</span>';
    //                 rows+= '<span class="pull-right num-votes" title="Số người đã bầu chọn">'+votes+' <i class="fa fa-user"></i></span>';
    //                 rows+= '</h6>';
    //                 rows+= '<hr>';
    //                 rows+= '<div class="list-option">';

    //                 $.each(data.list_option, function(index, o) {
    //                     var option_id = o.id;
    //                     var option_content = o.content;
    //                     var option_voted = o.voted;

    //                     var percent = o.total_vote*100/total_vote;
    //                     percent =  Math.round(percent * 100) / 100;
    //                     if (total_vote == 0) percent = 0;


    //                     if (poll_id == o.poll_id) {
    //                         if (option_voted) {
    //                             rows+= '<div class="form-check form-check-inline">';
    //                             rows+= '<p class="poll-title">'+option_content+'</p>';
    //                             rows+= '<div class="progress">';
    //                             rows+= '<div class="progress-bar progress-bar-stripeds actives progress-bar-danger" role="progressbar" style="width: '+percent+'%;" aria-valuenow="'+percent+'" aria-valuemin="0" aria-valuemax="100">'+percent+'%</div>';
    //                             rows+= '</div>';
    //                             rows+= '</div>';
    //                         } else {
    //                             rows+= '<div class="form-check form-check-inline">';
    //                             rows+= '<p class="poll-title">'+option_content+'</p>';
    //                             rows+= '<div class="progress">';
    //                             rows+= '<div class="progress-bar progress-bar-stripeds actives progress-bar-grey" role="progressbar" style="width: '+percent+'%;" aria-valuenow="'+percent+'" aria-valuemin="0" aria-valuemax="100">'+percent+'%</div>';
    //                             rows+= '</div>';
    //                             rows+= '</div>';

    //                         }
    //                     }


    //                 })


    //                 rows+= '</div>';
    //                 rows+= '<button type="button" class="btn btn-success" title="Sửa">Sửa bầu chọn</button>';
    //                 rows+= '</div>';
    //                 rows+= '</div>';
    //             } else {

    //                 rows+= '<div class="card w-75 poll-no-vote">';
    //                 rows+= '<div class="card-body poll-card">';
    //                 rows+= '<input type="hidden" class="poll-id" value="'+poll_id+'">';
    //                 rows+= '<input type="hidden" class="poll-max-choice" value="'+max_choice+'">';
    //                 rows+= '<h6>';
    //                 rows+= '<span class="card-title poll-title">'+title+'</span>';
    //                 rows+= '<span class="pull-right num-votes" title="Số người đã bầu chọn">'+votes+' <i class="fa fa-user"></i></span>';
    //                 rows+= '</h6>';
    //                 rows+= '<hr>';
    //                 rows+= '<p class="card-text"><small class="text-muted">Số câu trả lời được phép chọn: '+max_choice+'</small></p>';
    //                 rows+= '<div class="list-option">';

    //                 $.each(data.list_option, function(index, o) {

    //                     var option_id = o.id;
    //                     var option_content = o.content;

    //                     if (poll_id == o.poll_id) {
    //                         rows+= '<div class="form-check form-check-inline">';
    //                         rows+= '<input class="form-check-input" type="checkbox" id="'+option_id+'" value="0">';
    //                         rows+= '<label class="form-check-label" for="'+option_id+'">'+option_content+'</label>';
    //                         rows+= '</div>';
    //                     }

    //                 })


    //                 rows+= '</div>';
    //                 rows+= '<button type="button" class="btn btn-info" title="Gửi">Gửi</button>';
    //                 rows+= '</div>';
    //                 rows+= '</div>';
    //             }
    //         })
    //     } else {
    //         rows = '<h3 class="text-center">Chưa có bầu chọn</h3>';
    //     }
    //     $('#list-poll').html(rows);
    // }


</script>
    
</body>

</html>