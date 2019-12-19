<?php 
    include "header.php";
 ?>

<?php
    require "database-config.php" ;
    $sql = "SELECT id, title, start_date, place, status from event where status IN (1,2,3) order by id desc";
    $result = mysqli_query($conn, $sql);
 ?>
	
	<!--DASHBOARD-->
	<section>
		<div class="db">
			<!--LEFT SECTION-->
			<div class="db-l">
                <div class="db-l-1">
                    <ul>
                        <li><img src="images/lisa.jpg" alt="" />
                        </li>
                       

                        <!--  -->
                    </ul>
                </div>
                  <div class="db-l-2">
                    <ul>
                        <li>
                            <a href="my-events.php"><i class="fa fa-calendar" aria-hidden="true"></i> Sự kiện của tôi</a>
                        </li>
                        
                       
                        <li>
                            <a href="my-events.php"><i class="fa fa-check" aria-hidden="true"></i> Sự kiện đã đăng ký tham gia</a>
                        </li>
                         <li>
                            <a href="review-event.php"><i class="fa fa-hourglass-end" aria-hidden="true"></i> Duyệt sự kiện</a>
                        </li>
                        
                    </ul>
                </div>
            </div>
			<!--CENTER SECTION-->
			<div class="db-2">
				<div class="db-2-com db-2-main">
					<h4>Danh sách sự kiện cần Review</h4>
					<div class="db-2-main-com db-2-main-com-table">
						<table class="" id="review-table">
							<thead>
								<tr>
									<th>ID</th>
									<th>Tên sự kiện</th>
									<th>Thời gian</th>
									<th>Địa điểm</th>
                                    <th>Trạng thái</th>
									<th>Xét duyệt</th>
                                   
								</tr>
							</thead>
							<tbody id="tbodylistevent">
                                <?php while($resultreview=mysqli_fetch_assoc($result)){?>
                                    <?php
                                        $status = $resultreview["status"];

                                        switch ($status) {
                                            case 1:
                                                $status1 = "Chờ duyệt";
                                                $color = "event-wait";
                                                break;
                                            case 2:
                                                $status1 = "Đã từ chối";
                                                $color = "event-reject";
                                                break;
                                            case 3:
                                                $status1 = "Đã duyệt";
                                                $color = "event-accept";
                                                break;
                                        }
                                    ?>
                                    <tr>
                                       <td><?php echo $resultreview["id"] ?></td>
                                      <td><?php echo $resultreview["title"] ?></td>
                                       <td><?php echo date ("H:i - d/m/Y", strtotime($resultreview["start_date"])) ?></td>
                                       <td><?php echo $resultreview["place"] ?></td>
                                        <td><span class="event-status <?php echo $color ?>"><?php echo $status1 ?></span></td>
                                       <td><a href='review-event-detail.php?id=<?php echo $resultreview["id"] ?>'><span class='db-done'>Chi tiết</span></a>&nbsp;&nbsp;</td>
                                     </tr>

                                <?php } ?>

								<!-- <tr>
									<td>1</td>
									<td>Talkshow AI - Blockchain</td>
									<td>04/12/2019</td>
									<td>Hội trường Trịnh Công Sơn</td>
									<td><a href="review-event-detail.html"><span class="db-done">Chi tiết</span></a>&nbsp;&nbsp;
                                        
                                    </td>
								</tr> -->
								<!-- <tr>
                                    <td>12</td>
                                    <td>Đêm nhạc Trịnh Công Sơn</td>
                                    <td>05/12/2019</td>
                                    <td>Hội trường Trịnh Công Sơn</td>
                                    <td><a href="review-event-detail.html"><span class="db-done">Chi tiết</span></a>&nbsp;&nbsp;
                                        
                                    </td>
                                </tr>
                                <tr>
                                    <td>311</td>
                                    <td>Hội thảo khoa học thời 4.0</td>
                                    <td>11/12/2019</td>
                                    <td>Phòng 12.1</td>
                                   <td><a href="review-event-detail.html"><span class="db-done">Chi tiết</span></a>&nbsp;&nbsp;
                                        
                                    </td>
                                </tr>
                                <tr>
                                    <td>10</td>
                                    <td>Lễ trao bằng sáng chế khoa CNSH</td>
                                    <td>13/12/2019</td>
                                    <td>Phòng 7.3</td>
                                    <td><a href="review-event-detail.html"><span class="db-done">Chi tiết</span></a>&nbsp;&nbsp;
                                        
                                    </td>
                                </tr>
                                <tr>
                                    <td>12</td>
                                    <td>Ngày hội tư vấn việc làm</td>
                                    <td>24/12/2019</td>
                                    <td>Sân trường Cơ Sở 3</td>
                                    <td><a href="review-event-detail.html"><span class="db-done">Chi tiết</span></a>&nbsp;&nbsp;
                                        
                                    </td>
                                </tr>
                                <tr>
                                    <td>311</td>
                                    <td>Giới thiệu sách "Đi đu đưa đi"</td>
                                    <td>27/12/2019</td>
                                    <td>Thư viện</td>
                                    <td><a href="review-event-detail.html"><span class="db-done">Chi tiết</span></a>&nbsp;&nbsp;
                                        
                                    </td>
                                </tr> -->
							</tbody>
						</table>
					</div>
				</div>

			</div>
            <div class="db-3">
                <h4>Thông báo</h4>
                <ul>
                    <li>

                        <a href="#!"> <img src="images/icon/dbr1.jpg" alt="" />
                            <h5>Honeymoon Tailand</h5>
                            <p>Tuan Heo Accept</p>
                        </a>
                    </li>
                    <li>
                        <a href="#!"> <img src="images/icon/dbr3.jpg" alt="" />
                            <h5>Dubai</h5>
                            <p>Phan Tu Reject</p>
                        </a>
                    </li>
                    
                </ul>
            </div>

           <!-- Modal -->
                     
			

		</div>
	</section>

	<!--END DASHBOARD-->
	<!--====== TIPS BEFORE TRAVEL ==========-->
	
	<?php 
        include "footer.php"
    ?>
     <script type="text/javascript">
    $(document).ready( function (){
        $('#review-table').DataTable({
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
</script>