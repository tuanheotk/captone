<?php
$title = 'Quản lý tài khoản';
include('header.php');
if (!isset($account_role) || $account_role != 4) {
    header('Location: index.php');
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
                        <li>
                            <a href="manage-account.php"><i class="fa fa-users" aria-hidden="true"></i> Quản lý tài khoản</a>
                        </li>
                        <li>
                            <a href="manage-faculty.php"><i class="fa fa-th-large" aria-hidden="true"></i> Quản lý tài khoa</a>
                        </li>
                    </ul>
                </div>
            </div>
			<!--CENTER SECTION-->
			<div class="db-2">
				<div class="db-2-com db-2-main">
					<h4>Danh sách tài khoản</h4>
					<div class="db-2-main-com db-2-main-com-table">
						<table class="table table-hover" id="event-table">
							<thead>
								<tr>
									<th>#</th>
                                    <th>Mã tài khoản</th>
									<th>Họ tên</th>
									<th>Email</th>
                                    <th>Khoa</th>
                                    <th>Cấp bậc</th>
                                    <th>Loại tài khoản</th>
                                    <th>Trạng thái</th>
									<th>Thao tác</th>
								</tr>
							</thead>
							<tbody>
                                <?php 
                                require("database-config.php");
                                $sql = "SELECT a.*, f.name AS faculty_name FROM account a, faculty f WHERE a.faculty_id = f.faculty_id AND a.role < 4";
                                $result = mysqli_query($conn, $sql);
                                $count = 0;
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $count++;
                                    $id = $row["id"];
                                    $code = $row["code"];
                                    if ($row["code"] == "") {
                                        $code = "Không có";
                                    } else {
                                        $code = $row["code"];
                                    }
                                    
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
                                        // case 3:
                                        //     $role = 'Người điểm danh';
                                        //     break;
                                        case 4:
                                            $role = 'Quản trị viên';
                                            break;
                                    }

                                    switch ($row["status"]) {
                                        case 0:
                                            $status = 'Vô hiệu hóa';
                                            $colorStt = 'event-reject';
                                            break;
                                        case 1:
                                            $status = 'Đang sử dụng';
                                            $colorStt = 'event-accept';
                                            break;
                                    }

                                    if ($row["code"] == "") {
                                        $type = "Bên Ngoài";
                                        $colorType = 'event-wait';
                                    } else {
                                        $type = "Văn Lang";
                                        $colorType = 'event-reject';
                                    }
                                    
                                    

                                    ?>
                                    <tr id="<?php echo $id ?>">
                                        <td><?php echo $count ?></td>
                                        <td class="event-name"><?php echo $code ?></td>
                                        <td><?php echo $name ?></td>
                                        <td><?php echo $email ?></td>
                                        <td><?php echo $faculty ?></td>
                                        <td><?php echo $role ?></td>
                                        <td><span class="event-status <?php echo $colorType ?>"><?php echo $type ?></span></td>
                                        <td><span class="event-status <?php echo $colorStt ?>"><?php echo $status ?></span></td>
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


</script>