<?php
$title = 'Quản lý ảnh bìa';
include('header.php');
if (!isset($account_role) || $account_role != 4) {
    header('Location: /');
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
                            <a href="manage-faculty.php"><i class="fa fa-th-large" aria-hidden="true"></i> Quản lý khoa</a>
                        </li>
                        <li>
                            <a href="manage-cover.php"><i class="fa fa-picture-o" aria-hidden="true"></i> Quản lý ảnh bìa</a>
                        </li>
                    </ul>
                </div>
            </div>
			<!--CENTER SECTION-->
			<div class="db-2">
				<div class="db-2-com db-2-main">
                    <h4>Quản lý ảnh bìa</h4>
                    <a href="#" data-toggle="modal" data-target="#add-image-modal" class="btn btn-success waves-effect waves-light" style="margin: 15px 0 5px 35px;">Thêm ảnh</a>
                    <button type="button" class="btn btn-danger waves-effect waves-light" id="btn-reset-cover" style="margin: 15px 0 5px 35px;">Đặt lại mặc định</button>
					<div class="db-2-main-com db-2-main-com-table">
                        <div class="item" id="list-cover">
                            <h5 class="text-center"><i class="fa fa-spinner fa-spin"></i></h5>
                        </div>
                    </div>

				</div>
			</div>
			<!--RIGHT SECTION-->

            <!-- Add image -->
            <div id="add-image-modal" class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <!-- Modal content-->
                    <form id="add-image-form" method="POST" action="<?php  $_SERVER["PHP_SELF"] ?>">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Thêm ảnh mới</h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <div class="modal-body">
                                <input type="file" id="cover-image" name="cover-image" accept=".jpg, .jpeg, .png" required>

                                <div class="row" hidden>
                                    <div class="input-field col s12">
                                        <img src="" id="image-preview">
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <input type="hidden" name="action" value="add">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                                <button type="submit" class="btn btn-success">Tải lên</button>
                            </div>
                        </div>
                    </form>
                </div>              
            </div>
            <!-- End Add Image-->

		</div>
	</section>
	<!--END DASHBOARD-->
<?php

include('footer.php');
?>

<script type="text/javascript">

    load_all_image();

    function load_all_image () {
        $.ajax({
            url: 'process-manage-cover.php',
            method: 'POST',
            dataType: 'json',
            data: {'action': 'load'}
        }).done(function(data){
            // console.log(data);
            if(data.result){
                var rows = '';
                var check = 0;
                $.each(data.cover, function(index, img) {
                    rows+= '<div class="col-md-6 col-lg-4">';
                    rows+= '<div class="admin_change_image">';
                    if (img.selected == 1) {
                        check++;
                        rows+= '<div class="tour-mig-like-com" title="Ảnh này đang được chọn làm ảnh bìa">';
                    } else {
                        rows+= '<div class="tour-mig-like-com">';
                    }

                    rows+= '<div class=" tour-mig-lc-img">';

                    if (img.selected == 1) {
                        rows+= '<img class="selected-image" src="'+img.link+'" alt="">';
                    } else {
                        rows+= '<img src="'+img.link+'" alt="">';                        
                    }
                        
                    rows+= '</div>';
                    rows+= '</div>';
                    rows+= '<div class="middle">';

                    if (img.selected != 1) {

                        rows+= '<button type="button" value="'+img.id+'" title="Chọn làm ảnh bìa" class="custom-btn custom-reply btn-select-cover"><i class="fa fa-check" aria-hidden="true"></i></button>';
                    }

                    rows+= '<button type="button" value="'+img.id+'" title="Xoá ảnh này" class="custom-btn custom-del btn-delete-cover"><i class="fa fa-times" aria-hidden="true"></i></button>';
                    rows+= '</div>';
                    rows+= '</div>';
                    rows+= '</div>';
                })
            } else {
                rows = '<h5 class="text-center">Chưa có ảnh bìa</h5>';
            }

            $('#list-cover').html(rows);
            if (check == 0) {
                $('#btn-reset-cover').hide();
            } else {
                $('#btn-reset-cover').show();
            }
        }).fail(function(jqXHR, statusText, errorThrown){
            console.log("Fail:"+ jqXHR.responseText);
            console.log(errorThrown);
        })
    }

    // Add image
    $('#add-image-form').on('submit', function(e) {
        var btn = $(this).find('button[type="submit"]');
        btn.html('<i class="fa fa-spinner fa-spin"></i>').prop('disabled', true);
        e.preventDefault();
        var form = document.querySelector('#add-image-form');
        $.ajax({
            url: 'process-manage-cover.php',
            method: 'POST',
            dataType: 'json',
            processData: false,
            contentType: false,
            data: new FormData(form)

        }).done(function(data){
            // console.log(data);
            btn.html('Tải lên').prop('disabled', false);
            if(data.result){
                $('#add-image-form')[0].reset();
                $('#image-preview').hide();
                $('#add-image-modal').modal('hide');
                load_all_image();
            }else {
                alert(data.message);
            }
        }).fail(function(jqXHR, statusText, errorThrown){
            console.log("Fail:"+ jqXHR.responseText);
            console.log(errorThrown);
        })
    })

    // Select image
    $('body').on('click', '.btn-select-cover', function(){
        var id = $(this).val();
        var q = confirm('Bạn có muốn chọn ảnh này làm ảnh bìa ở trang chủ?');
        if (q) {
            $.ajax({
                url: 'process-manage-cover.php',
                method: 'POST',
                dataType: 'json',
                data: {'action': 'select', 'id': id}
            }).done(function(data){
                if(data.result){
                    // alert('Ảnh bìa đã được lại ảnh mặc định');
                    load_all_image();
                }else {
                    alert('Có lỗi xảy ra. Vui lòng thử lại!');
                }
            })
        }
    })

    // Delete image
    $('body').on('click', '.btn-delete-cover', function(){
        var id = $(this).val();

        // check is selecting
        var img = $(this).parents('.admin_change_image').find('img');
        var img_src = img.attr('src');
        var is_selecting = (img.hasClass('selected-image')) ? true : false;

        if (is_selecting) {
            ques = 'Ảnh này đang được chọn làm ảnh bìa. Nếu xóa, ảnh bìa sẽ được đặt lại mặc định. Bạn có chắc chắn xóa ảnh này không?';
        } else {
            ques = 'Bạn có chắc chắn xóa ảnh này không?';
        }

        var q = confirm(ques);
        if (q) {
            $.ajax({
                url: 'process-manage-cover.php',
                method: 'POST',
                dataType: 'json',
                data: {'action': 'delete', 'id': id, 'src': img_src}
            }).done(function(data){
                if(data.result){
                    load_all_image();
                    // alert('Ảnh bìa đã được lại thành mặc định');
                }else {
                    alert('Có lỗi xảy ra. Vui lòng thử lại!');
                }
            }).fail(function(jqXHR, statusText, errorThrown){
                console.log("Fail:"+ jqXHR.responseText);
                console.log(errorThrown);
            })
        }
    })

    // Reset to default cover
    $('#btn-reset-cover').click(function(){

        var q = confirm('Bạn có muốn đặt lại ảnh bìa ở trang chủ thành mặc định');

        if (q) {
            $.ajax({
                url: 'process-manage-cover.php',
                method: 'POST',
                dataType: 'json',
                data: {'action': 'reset'}
            }).done(function(data){
                if(data.result){
                    load_all_image();
                    alert('Ảnh bìa đã được lại thành mặc định');
                }else {
                    alert('Có lỗi xảy ra. Vui lòng thử lại!');
                }
            })
        }
    })


    function load_image(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#image-preview').attr('src',e.target.result).parent('div').parent('div').show();
            };
            reader.readAsDataURL(input. files[0]);
        }
    }

    $('#cover-image').change(function () {
        load_image(this);
        if ($(this).val() == '') $('#image-preview').parent('div').parent('div').hide();
    });

</script>