<?php
$title = 'Quản lý tài khoản';
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
                            <a href="review-event.php"><i class="fa fa-hourglass-end" aria-hidden="true"></i> Duyệt sự kiện</a>
                        </li>
                        <li>
                            <a href="manage-account.php"><i class="fa fa-cog" aria-hidden="true"></i> Quản lý tài khoản</a>
                        </li>
                        
                        
                    </ul>
                </div>
            </div>
			<!--CENTER SECTION-->
			<div class="db-2">
				<div class="db-2-com db-2-main">
					<h4>Danh sách tài khoản</h4>
                    <a href="add-event.php" class="btn btn-success waves-effect waves-light" style="margin: 10px 15px;">Thêm tài khoản</a>
					<div class="db-2-main-com db-2-main-com-table">
						<table class="table table-hover" id="event-table">
							<thead>
								<tr>
									<th>#</th>
                                    <th>Mã số</th>
									<th>Họ tên</th>
									<th>Email</th>
                                    <th>Khoa</th>
                                    <th>Cấp bậc</th>
									<th>Thao tác</th>
								</tr>
							</thead>
							<tbody>
                                <?php 
                                require("database-config.php");
                                $sql = "SELECT a.*, f.name AS faculty_name FROM account a, faculty f WHERE a.faculty_id = f.faculty_id";
                                $result = mysqli_query($conn, $sql);
                                $count = 0;
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $count++;
                                    $id = $row["id"];
                                    $code = $row["code"];
                                    $name = $row["name"];
                                    $email = $row["email"];
                                    $faculty = $row["faculty_name"];
                                    switch ($row["role"]) {
                                        case 1:
                                            $role = 'Thành viên';
                                            break;
                                        case 2:
                                            $role = 'Người kiểm duyệt';
                                            break;
                                        case 3:
                                            $role = 'Người điểm danh';
                                            break;
                                        case 4:
                                            $role = 'Quản trị';
                                            break;
                                    }
                                    

                                    ?>
                                    <tr id="<?php echo $id ?>">
                                        <td><?php echo $count ?></td>
                                        <td class="event-name"><?php echo $code ?></td>
                                        <td><?php echo $name ?></td>
                                        <td><?php echo $email ?></td>
                                        <td><?php echo $faculty ?></td>
                                        <td><?php echo $role ?></td>
                                        <td>
                                            <a href="edit-account.php?id=<?php echo $id ?>" class="btn waves-effect waves-light btn-sm btn-success" title="Sửa tài khoản"><i class="fa fa-pencil"></i></a>
                                        </td>
                                    </tr>

                                <?php
                                }
                                 ?>                                
							</tbody>
						</table>
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
                                <h4 class="modal-title"> Xóa sự kiện</h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
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


			<!--RIGHT SECTION-->
            <div class="db-3">
                <h4>Thông tin cá nhân</h4>
                <ul>
                    <li>

                        <a href="#!"> <img src="images/icon/dbr1.jpg" alt="" />
                            <h5>Tuấn heo</h5>
                            <p><i class="fa fa-th-large"></i> Công nghệ thông tin</p>
                            <p><i class="fa fa-envelope"></i> tuanheotk@gmail.com</p>
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
                "searchPlaceholder": "Tìm kiếm tài khoản",
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
            url: 'my-event-process.php',
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