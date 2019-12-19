<?php
$title = 'Danh sách tham dự';
include('header.php');
?>
	<!--DASHBOARD-->
	<section>
		<div class="db">
			<!--LEFT SECTION-->
			<div class="db-l">
                <div class="db-l-1">
                    <ul>
                        <li><img src="images/db-profile.jpg" alt="" />
                        </li>
                        
                    </ul>
                </div>
                <div class="db-l-2">
                    <ul>
                        <li>
                            <a href="my-events.php"><i class="fa fa-calendar" aria-hidden="true"></i> Sự kiện của tôi</a>
                        </li>
                        
                        <!-- <li>
                            <a href="my-events.php"><i class="fa fa-hourglass-end" aria-hidden="true"></i> Sự kiện đang chờ</a>
                        </li> -->
                        <li>
                            <a href="my-events.php"><i class="fa fa-check" aria-hidden="true"></i> Sự kiện đã đăng ký tham gia</a>
                        </li>
                        <li>
                            <a href="my-events.php"><i class="fa fa-hourglass-end" aria-hidden="true"></i> Sự kiện cần duyệt</a>
                        </li>
                        
                        
                    </ul>
                </div>
            </div>
			<!--CENTER SECTION-->
			<div class="db-2">
				<div class="db-2-com db-2-main">
					<h4>Danh sách người tham dự</h4>
                    
					<div class="db-2-main-com db-2-main-com-table">
						<table class="table table-hover" id="attendee-table">
							<thead>
								<tr>
									<th>#</th>
									<th>Email người tham dự</th>
									<th>Trạng thái</th>
								</tr>
							</thead>
							<tbody>
                                <?php 
                                require("database-config.php");
                                $eventID = $_GET["id"];
                                $sqlAttendee = "SELECT email FROM `attendee` WHERE event_id = ".$eventID;
                                $resultAtt = mysqli_query($conn, $sqlAttendee);
                                if (mysqli_num_rows($resultAtt) > 0) {
                                    $count = 0;
                                    while ($rowAtt = mysqli_fetch_assoc($resultAtt)) {
                                        $email = $rowAtt["email"];
                                        $count++;

                                        ?>
                                        <tr>
                                            <td><?php echo $count ?></td>
                                            <td><?php echo $email ?></td>
                                            <td><span class="db-not-done">Chưa điểm danh</span></td>
                                        </tr>

                                        <?php
                                    }
                                } else {
                                    ?>
                                    <tr>
                                        <td class="text-center" colspan="3">Chưa có người tham dự</td>
                                    </tr>

                                    <?php
                                }
                                ?>
                                
                                    <!-- <tr>
                                        <td>1</td>
                                        <td>Bui Trung Tuan</td>
                                        <td><span class="db-done">đã quét</span></td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>Nguyen Huu Kha</td>
                                        <td><span class="db-not-done">chưa quét</span></td>
                                    </tr> -->

                                                               
							</tbody>
						</table>
					</div>
				</div>
			</div>

           <!-- Modal -->
            <div class="modal fade" id="delete-event-modal" tabindex="-1" role="dialog" aria-labelledby="delete-event-modalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="delete-event-modalLabel">Xác nhận</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    Bạn có muốn xoá người tham dự khỏi sự kiện này?
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-info" data-dismiss="modal">Hủy</button>
                    <button type="button" class="btn btn-danger">Xoá</button>&nbsp; &nbsp;
                  </div>
                </div>
              </div>
            </div>           
			<!--RIGHT SECTION-->
            <div class="db-3">
                <h4>Thông tin sự kiện</h4>
                <ul>
                    <li>

                        <a href="#!"> <img src="images/icon/dbr1.jpg" alt="" />
                            <?php 
                            $sqlInfo = "SELECT * FROM event WHERE id = ".$eventID;
                            $resultInfo = mysqli_query($conn, $sqlInfo);
                            $rowInfo = mysqli_fetch_assoc($resultInfo);
                             ?>
                            <h5><?php echo $rowInfo["title"] ?></h5>
                            <p><i class="fa fa-map-marker"></i> <?php echo $rowInfo["place"] ?></p>
                            <p><i class="fa fa-hourglass-start"></i> <?php echo date("H:i - d/m/Y", strtotime($rowInfo["start_date"])) ?></p>
                            <p><i class="fa fa-hourglass-end"></i> <?php echo date("H:i - d/m/Y", strtotime($rowInfo["end_date"])) ?></p>
                            <!-- <p><i class="fa fa-phone"></i> 12356987</p> -->
                            
                        </a>
                    </li>
                    
                    
                </ul>
            </div>
		</div>
	</section>
	<!--END DASHBOARD-->
<?php

include('footer.php');
?>

<script type="text/javascript">
    $(document).ready( function (){
        $('#attendee-table').DataTable({
            responsive: false,
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
</script>