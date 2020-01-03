<?php
$title = 'Quản lý khoa';
include('header.php');
if (!isset($account_role) || $account_role != 4) {
    header('Location: index.php');
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
                            <a href="manage-account.php"><i class="fa fa-th-large" aria-hidden="true"></i> Quản lý tài khoa</a>
                        </li>
                    </ul>
                </div>
            </div>
			<!--CENTER SECTION-->
			<div class="db-2">
				<div class="db-2-com db-2-main">
					<h4>Danh sách khoa</h4>
                    <a href="#" data-toggle="modal" data-target="#add-faculty-modal" class="btn btn-success waves-effect waves-light" style="margin: 10px 15px;">Thêm khoa</a>
					<div class="db-2-main-com db-2-main-com-table">
						<table class="table table-hover" id="event-table">
							<thead>
								<tr>
									<th>#</th>
                                    <th>Tên khoa</th>
									<th>Thao tác</th>
								</tr>
							</thead>
							<tbody>
                                <?php
                                $sql = "SELECT faculty_id, name FROM faculty WHERE status != 0";
                                $result = mysqli_query($conn, $sql);
                                $count = 0;
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $count++;
                                    $id = $row["faculty_id"];
                                    $name = $row["name"];

                                    ?>
                                    <tr id="<?php echo $id ?>">
                                        <td><?php echo $count ?></td>
                                        <td class="faculty-name"><?php echo $name ?></td>
                                        <td>
                                            <a href="#" class="edit-faculty btn waves-effect waves-light btn-sm btn-success" data-toggle="modal" data-target="#edit-faculty-modal" title="Sửa tên khoa"><i class="fa fa-pencil" ></i></a>
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


    <!-- Add faculty -->
    <div id="add-faculty-modal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <form id="add-faculty-form" method="POST">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title"> Thêm khoa</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="input-field col s12 m3">
                            <input type="text" class="validate" id="faculty-name" title="Tên khoa" placeholder="Nhập tên khoa" maxlength="50" required="" style="height: 36px; padding-left: 10px;">
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success" >Thêm</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Hủy</button>
                    </div>
                </div>
            </form>
        </div>              
    </div>
    <!-- End Add faculty -->

    <!-- Update name faculty -->
    <div id="edit-faculty-modal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <form id="edit-faculty-form" method="POST" action="<?php  $_SERVER["PHP_SELF"] ?>">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title"> Sửa tên khoa</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="input-field col s12 m3">
                            <input type="hidden" id="u-faculty-id">    

                            <input type="text" class="validate" id="u-faculty-name" title="Tên khoa" placeholder="Nhập tên khoa" maxlength="50" required="" style="height: 36px; padding-left: 10px;">
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success" >Lưu</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Hủy</button>
                    </div>
                </div>
            </form>
        </div>              
    </div>
    <!-- End update name faculty -->
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
                "searchPlaceholder": "Tìm kiếm khoa",
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


    $('tbody').on('click', '.edit-faculty', function(){
        var id = $(this).parents('tr').attr('id');
        if (id == undefined) var id = $(this).parents('tr').prev().attr('id');
        var name = $(this).parents('tr').find('.faculty-name').text();
        if (name == '') var name = $(this).parents('tr').prev().find('.faculty-name').text();

        $('#u-faculty-id').val(id);
        $('#u-faculty-name').val(name);
    })


    $('#faculty-name, #u-faculty-name').on('keydown keyup', function(){
        $(this).val($(this).val().replace(/[0123456789,.!@#$%^&*()_+={}\[\]><|\/\\]+/g,''));
    })

    $('#add-faculty-form').submit(function(e){
        e.preventDefault();
        faculty_name = $('#faculty-name').val();
        $.ajax({
            url: 'process-manage-faculty.php',
            method: 'POST',
            dataType: 'json',
            data: {'action': 'add', 'faculty-name': faculty_name}
        }).done(function(data){
            if(data.result){
                alert('Khoa ' + faculty_name + ' đã được thêm');
                location.reload();
            }
        }).fail(function(jqXHR, statusText, errorThrown){
            console.log("Fail:"+ jqXHR.responseText);
            console.log(errorThrown);
        })

    })


    $('#edit-faculty-form').submit(function(e){
        e.preventDefault();
        faculty_id = $('#u-faculty-id').val();
        faculty_name = $('#u-faculty-name').val();
        $.ajax({
            url: 'process-manage-faculty.php',
            method: 'POST',
            dataType: 'json',
            data: {'action': 'edit', 'faculty-id': faculty_id, 'faculty-name': faculty_name}
        }).done(function(data){
            if(data.result){
                alert('Tên khoa đã được cập nhật');
                location.reload();
            }
        }).fail(function(jqXHR, statusText, errorThrown){
            console.log("Fail:"+ jqXHR.responseText);
            console.log(errorThrown);
        })

    })

</script>