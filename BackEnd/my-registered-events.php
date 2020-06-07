<?php
$title = 'Sự kiện đã đăng ký tham gia';
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
					<h4>Danh sách sự kiện đã đăng ký tham gia</h4>
                    
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
                                require("database-config.php");
                                $sql = "SELECT a.event_id , e.title, e.code, e.start_date, a.ticket_code, a.status FROM attendee a, event e WHERE e.status = 4 AND a.event_id = e.id AND a.email = '".$_SESSION["user_email"]."'";
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
                                    while ($row = mysqli_fetch_assoc($result)) {
                                    $count++;
                                    $event_id = $row["event_id"];
                                    $name = $row["title"];
                                    $code = $row["code"];
                                    $ticket_code = $row["ticket_code"];
                                    $start = date("H:i - d/m/Y", strtotime($row["start_date"]));
                                    $status = $row["status"];

                                    switch ($status) {
                                        case 0:
                                            $status_text = 'Chưa điểm danh';
                                            $color = 'event-reject';
                                            break;
                                        case 1:
                                            $status_text = 'Đã điểm danh';
                                            $color = 'event-accept';
                                            break;
                                        case 2:
                                            $status_text = 'Chờ duyệt vé';
                                            $color = 'event-wait';
                                            break;
                                        
                                        default:
                                            break;
                                    }
                                
                                
                                    ?>
                                    <tr id="<?php if ($status != 2) echo $ticket_code ?>">
                                        <td><?php echo $count ?></td>
                                        <td class="event-name" title="<?php echo htmlspecialchars($name) ?>"><?php echo shortTitle($name) ?></td>
                                        <td class="event-name"><?php echo $code ?></td>
                                        <td><?php echo $start ?></td>
                                        <td><span class="event-status <?php echo $color ?>"><?php echo $status_text ?></span></td>
                                        <td>
                                            <input type="hidden" class="status" value="<?php echo $status ?>">
                                            <a href="event-detail.php?id=<?php echo $event_id ?>" target="_blank" class="btn waves-effect waves-light btn-sm btn-info" title="Chi tiết sự kiện"><i class="fa fa-info-circle"></i></a>
                                            <a href="#" class="btn waves-effect waves-light btn-sm btn-success qr-code" data-toggle="modal" data-target="#qr-modal" title="Xem vé"><i class="fa fa-qrcode"></i></a>
                                        </td>
                                    </tr>

                                <?php
                                    }
                                }
                                 else {
                                    ?>
                                    <tr>
                                        <td colspan="6" class="text-center">Bạn chưa đăng ký tham gia sự kiện nào</td>
                                    </tr>
                                    <?php
                                }
                                 ?>                                
                            </tbody>
                        </table>
                        <?php
                    } else {
                        ?>
                        <!-- require login -->
                        <p>Vui lòng <a href="login.php">Đăng nhập</a></p>
                        <?php
                    }
                    
                     ?>

                        
					</div>
				</div>
			</div>

            <!-- Ticket QR -->
            <div id="qr-modal" class="modal fade" role="dialog">
                <div class="modal-dialog modal-sm">
                    <!-- Modal content-->
                    <form method="POST" action="<?php  $_SERVER["PHP_SELF"] ?>">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title"> Vé mời tham gia sự kiện</h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <div class="modal-body">
                                <img src="" id="src-qr">
                                <p id="alert-wait" hidden>Vé của bạn đang được duyệt</p>          
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                                <!-- <button type="button" id="btn-save-qr" class="btn btn-success" data-dismiss="modal">Lưu vé</button>
                                <a href="" id="link-qr" class="btn btn-success" download data-dismiss="modals">Lưu vé2</a> -->
                            </div>
                        </div>
                    </form>
                </div>              
            </div>
            <!-- END Ticket QR -->


			<!--RIGHT SECTION-->
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

    $('tbody').on('click', '.qr-code', function(){
        var ticket_code = $(this).parents('tr').attr('id');
        if (ticket_code == undefined) var ticket_code = $(this).parents('tr').prev().attr('id');

        var status = $(this).parents('tr').find('.status').val();
        if (status == '') var status = $(this).parents('tr').prev().find('.status').val();

        if (status == 2) {
            $('#alert-wait').attr('hidden', false);
        } else {
            $('#alert-wait').attr('hidden', true);
            link = 'https://chart.googleapis.com/chart?chs=250x250&cht=qr&chl='+ticket_code+'&choe=UTF-8';
            $('#src-qr').attr('src', link);
            $('#link-qr').attr('href', link);
        }

    })

    $('#qr-modal').on('hidden.bs.modal', function(){
        $('#src-qr').attr('src', '');
        $('#link-qr').attr('href', '');
    });

    $('#btn-save-qr').click(function(){
        var a = $('<a>').attr('href', link).attr('download', 'img.png').appendTo('body');
        a[0].click();
        a.remove();
    })

</script>