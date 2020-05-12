<?php
$title = 'Sự kiện của tôi';
include('header.php');
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
					<h4>Danh sách sự kiện của tôi</h4>
                    <?php 
                    if (isset($_SESSION["user_email"])) {
                        ?>
                    <a href="add-event.php" class="btn btn-success waves-effect waves-light" style="margin: 10px 15px;">Thêm sự kiện</a>
                        <?php
                    }
                     ?>
					<div class="db-2-main-com db-2-main-com-table">
                    <?php 
                    if (isset($_SESSION["user_email"])) {
                        ?>
                        <!-- show -->
                        <table class="table table-hover" id="event-table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Tên sự kiện</th>
                                    <th>Mã sự kiện</th>
                                    <th>Thời gian bắt đầu</th>
                                    <th>Trạng thái</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // $sql = "SELECT e.*, a.email FROM event e, account a WHERE e.status < 5 AND e.account_id = a.id AND a.email = '".$_SESSION["user_email"]."'";

                                $sql = "SELECT e.* FROM event e, account a WHERE e.status < 5 AND e.account_id = a.id AND a.email = '".$account_email."' UNION SELECT e.* FROM event e, moderator m WHERE e.status < 5 AND e.id = m.event_id AND m.email = '".$account_email."'";

                                $result = mysqli_query($conn, $sql);
                                $count = 0;

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

                                if (mysqli_num_rows($result) > 0) {
                                    # code...
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        $count++;
                                        $id = $row["id"];
                                        $name = $row["title"];
                                        $code = $row["code"];
                                        $start = date("H:i - d/m/Y", strtotime($row["start_date"]));
                                        // $end = date("H:i m-d-Y", strtotime($row["end_date"]));
                                        switch ($row["status"]) {
                                            case 0:
                                                $status = 'Đã lưu';
                                                $color = 'event-draft';
                                                break;
                                            case 1:
                                                $status = 'Chờ duyệt';
                                                $color = 'event-wait';
                                                break;
                                            case 2:
                                                $status = 'Bị từ chối';
                                                $color = 'event-reject';
                                                break;
                                            case 3:
                                                $status = 'Đã duyệt';
                                                $color = 'event-accept';
                                                break;
                                            case 4:
                                                $status = 'Đã công khai';
                                                $color = 'event-public';
                                                break;
                                        }
                                
                                    ?>
                                    <tr id="<?php echo $id ?>">
                                        <td><?php echo $count ?></td>
                                        <td class="event-name"><?php echo shortTitle($name) ?></td>
                                        <td class="event-code"><?php echo $code ?></td>
                                        <td><?php echo $start ?></td>
                                        <td><span class="event-status <?php echo $color ?>"><?php echo $status ?></span></td>
                                        <td>
                                            <a href="attendee.php?id=<?php echo $id ?>" class="btn waves-effect waves-light btn-sm btn-info" title="Danh sách người tham dự"><i class="fa fa-users"></i></a>
                                            <a href="edit-event.php?id=<?php echo $id ?>" class="btn waves-effect waves-light btn-sm btn-success" title="Sửa sự kiện"><i class="fa fa-pencil"></i></a>
                                            <a href="setting-event.php?id=<?php echo $id ?>" class="btn waves-effect waves-light btn-sm btn-warning" title="Cấu hình sự kiện"><i class="fa fa-cog"></i></a>
                                            <a href="manage-question.php?id=<?php echo $id ?>" class="btn waves-effect waves-light btn-sm btn-primary" title="Quản lý câu hỏi"><i class="fa fa-question"></i></a>
                                            <a href="#" class="delete-event btn waves-effect waves-light btn-sm btn-danger" data-toggle="modal" data-target="#delete-modal" title="Xóa sự kiện"><i class="fa fa-trash-o" ></i></a>
                                        </td>
                                    </tr>

                                <?php
                                    }
                                }
                                 else {
                                    ?>
                                    <tr>
                                        <td colspan="6" class="text-center">Bạn chưa có sự kiện</td>
                                    </tr>
                                    <?php
                                }
                                 ?>                                
                            </tbody>
                        </table>
                        <?php
                    } else {
                        ?>
                        <!-- Dang nhap -->
                        <p>Vui lòng <a href="login.php">Đăng nhập</a></p>
                        <?php
                    }
                    
                     ?>

						
					</div>
				</div>
			</div>

            <!-- Delete Event Event -->
            <div id="delete-modal" class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <!-- Modal content-->
                    <form id="delete-product-form" method="POST" action="<?php  $_SERVER["PHP_SELF"] ?>">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title"> Xóa sự kiện</h4>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" name="id" id="did">
                                <input type="hidden" name="dname" id="dname">
                                <p>Bạn có muốn xóa sự kiện: <strong id="event-will-delete"></strong> ?</p>             
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Hủy</button>
                                <button type="button" class="btn btn-danger" id="delete-event-btn">Xóa</button>
                            </div>
                        </div>
                    </form>
                </div>              
            </div>
            <!-- End Delete Event -->
		</div>
	</section>
	<!--END DASHBOARD-->
<?php

include('footer.php');
?>

<script type="text/javascript">
    $(document).ready( function (){
        $('#event-table').DataTable({
            responsive: true,
            language: {
                "sProcessing":   "Đang xử lý...",
                "sLengthMenu":   "Xem _MENU_ mục",
                "sZeroRecords":  "Không có kết quả",
                "sInfo":         "Đang xem _START_ đến _END_ trong tổng số _TOTAL_ mục",
                "sInfoEmpty":    "Đang xem 0 đến 0 trong tổng số 0 mục",
                "sInfoFiltered": "(được lọc từ _MAX_ mục)",
                "sInfoPostFix":  "",
                "sSearch":       "",
                "searchPlaceholder": "Tìm kiếm sự kiện",
                "sUrl":          "",
                "oPaginate": {
                    "sFirst":    "Đầu",
                    "sPrevious": "«",
                    "sNext":     "»",
                    "sLast":     "Cuối"
                }
            },
            "lengthMenu": [[10, 20, 50, -1], [10, 20, 50, "Tất cả"]]
        });
    });

    $('tbody').on('click', '.delete-event', function(){
        var id = $(this).parents('tr').attr('id');
        if (id == undefined) var id = $(this).parents('tr').prev().attr('id');
        var name = $(this).parents('tr').find('.event-name').text();
        if (name == '') var name = $(this).parents('tr').prev().find('.event-name').text();

        $('#did').val(id);
        $('#event-will-delete').html(name);
    })

    $('#delete-event-btn').click(function(){
        var id = $('#did').val();
        $.ajax({
            url: 'process-my-event.php',
            method: 'POST',
            dataType: 'json',
            data: {'action': 'delete', 'id': id}
        }).done(function(data){
            if(data.result){
                alert('Sự kiện đã được xóa');
                location.reload();
            }
        })
    })

</script>