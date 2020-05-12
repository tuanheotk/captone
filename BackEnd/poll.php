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
            

            <!-- <div class="card w-75">   
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
            </div> -->

            <h3 class="text-center"><i class="fa fa-spinner fa-spin"></i></h3>
            
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
        console.log('max: ' + max_choice)
        console.log('cur: ' + current_choice)
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
                                    rows+= '<div class="progress-bar progress-bar-stripeds actives progress-bar-danger" role="progressbar" style="width: '+percent+'%;" aria-valuenow="'+percent+'" aria-valuemin="0" aria-valuemax="100">'+percent+'%</div>';
                                    rows+= '</div>';
                                    rows+= '</div>';
                                } else {
                                    rows+= '<div class="form-check form-check-inline one-option" id="'+o.id+'">';
                                    rows+= '<input type="hidden" class="option-voted" value="0">'
                                    rows+= '<p class="option-content">'+option_content+'</p>';
                                    rows+= '<div class="progress">';
                                    rows+= '<div class="progress-bar progress-bar-stripeds actives progress-bar-grey" role="progressbar" style="width: '+percent+'%;" aria-valuenow="'+percent+'" aria-valuemin="0" aria-valuemax="100">'+percent+'%</div>';
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