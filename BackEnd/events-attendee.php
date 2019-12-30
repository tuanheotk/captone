<?php
$title = 'Sự kiện của tôi';
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
					<h4>Danh sách sự kiện</h4>
                    
					<div class="db-2-main-com db-2-main-com-table">
						<table class="table table-hover" id="event-table">
							<thead>
								<tr>
									<th>#</th>
									<th>Mã sự kiện</th>
									<th>Tên người tham dự</th>
									<th>Trạng thái</th>
									<th>Thao tác</th>
								</tr>
							</thead>
							<tbody>
                                
                                    <tr>
                                        <td>1</td>
                                        <td>ABC</td>
                                        <td>Bui Trung Tuan</td>
                                        <td><span class="db-done">đã quét</span></td>
                                        <td>
                                            
                                            
                                            <a href="#" class="btn waves-effect waves-light btn-sm btn-danger"  data-toggle="modal" data-target="#delete-event-modal"><i class="fa fa-trash-o" ></i></a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>ABC</td>
                                        <td>Nguyen Huu Kha</td>
                                        <td><span class="db-not-done">chưa quét</span></td>
                                        <td>
                                            
                                            
                                            <a href="#" class="btn waves-effect waves-light btn-sm btn-danger"  data-toggle="modal" data-target="#delete-event-modal"><i class="fa fa-trash-o" ></i></a>
                                        </td>
                                    </tr>

                                                               
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
                            <h5>AI Block Chain Khởi cmn Nghiệp</h5>
                            <p><i class="fa fa-map-marker"></i> Toà nhà Trinh Công sơn</p>
                            <p><i class="fa fa-hourglass-start"></i> 8:00 - 12/12/2020</p>
                            <p><i class="fa fa-hourglass-end"></i> 17:00 - 12/12/2020</p>
                            <p><i class="fa fa-phone"></i> 12356987</p>
                            
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
</script>