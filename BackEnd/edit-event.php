<?php
$title = 'Sửa sự kiện';
include('header.php');
if (isset($_GET["id"])) {
    $event_id = $_GET["id"];
    // $sqlCheckAuthor = "SELECT id FROM event WHERE id = ".$event_id." AND status != 5 AND account_id = '".$account_id."'";
    $sqlCheckAuthor = "SELECT id FROM event WHERE status != 5 AND id = ".$event_id." AND account_id = ".$account_id." UNION SELECT e.id FROM event e, moderator m WHERE e.status !=5 AND e.id = m.event_id AND m.event_id = ".$event_id." AND m.email = '".$account_email."'";
    $resultCheckAuthor = mysqli_query($conn, $sqlCheckAuthor);

    if (mysqli_num_rows($resultCheckAuthor) > 0) {
        $sql = "SELECT * FROM event WHERE id = ".$event_id;
        $result = mysqli_query($conn, $sql);
        while ($row = mysqli_fetch_assoc($result)) {
            $name = $row["title"];
            $category = $row["category_id"];
            $faculty = $row["faculty_id"];
            $numTicket = $row["ticket_number"];
            $place = $row["place"];
            // $startTime = $row["start_date"];
            $startTime = date("Y/m/d H:i", strtotime($row["start_date"]));
            // $endTime = $row["end_date"];
            $endTime = date("Y/m/d H:i", strtotime($row["end_date"]));
            $shortDesc = $row["short_desc"];
            $description = $row["description"];
            $status = $row["status"];
            $avatar = $row["avatar"];
        }
    } else {
        header("Location: my-events.php");
        // header('Location: javascript://history.go(-1)');
    }
} else {
    header("Location: my-events.php");
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

                    

                    <h4>Thông tin sự kiện</h4>
                    <div class="db-2-main-com db2-form-pay db2-form-com">
                        <form class="col s12" id="edit-event-form" method="POST" enctype="multipart/form-data">
                            <div class="row">
                                <div class="input-field col s12">
                                    <input type="hidden" id="event-id" name="id" value="<?php echo $event_id ?>">
                                    <input type="text" class="validate" id="event-name" name="name" value="<?php echo htmlspecialchars($name) ?>" maxlength="100" title="Tên sự kiện" required>
                                    <label for="event-name">Tên sự kiện</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s12 fix-select">
                                    <select name="category" id="category">
                                        <option selected disabled>Vui lòng chọn danh mục...</option>
                                        <?php
                                        $sql = "SELECT * FROM category";
                                        $result = mysqli_query($conn, $sql);
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            if ($category == $row["id"]) {
                                                # code...
                                                echo '<option value="'.$row["id"].'" selected>'.$row["name"].'</option>';
                                            } else {
                                                echo '<option value="'.$row["id"].'">'.$row["name"].'</option>';
                                                # code...
                                            }
                                            
                                        }
                                        ?>

                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s12 fix-select">
                                    <select name="faculty" id="faculty">
                                        <option selected disabled>Vui lòng chọn khoa...</option>
                                        <?php
                                        $sql = "SELECT * FROM faculty WHERE status = 1";
                                        $result = mysqli_query($conn, $sql);
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            if ($faculty == $row["faculty_id"]) {
                                                # code...
                                                echo '<option value="'.$row["faculty_id"].'" selected>'.$row["name"].'</option>';
                                            } else {
                                                echo '<option value="'.$row["faculty_id"].'">'.$row["name"].'</option>';
                                                # code...
                                            }
                                            
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="input-field col s12">
                                    <input type="number" class="validate" id="ticket-number" name="ticket-number" value="<?php echo $numTicket ?>" title="Số lượng vé" min="0" max="1000000000" required="">
                                    <label>Số lượng vé</label>
                                </div>

                                <div class="input-field col s12">
                                    <input id="place" type="text" name="place" value="<?php echo $place ?>" class="validate" maxlength="100" title="Địa điểm" required>
                                    <label for="place">Địa điểm</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s12 m6">
                                    <input type="text" class="validate" id="start-time" name="start-time" value="<?php echo $startTime ?>"  title="Thời gian bắt đầu" required="">
                                    <label>Thời gian bắt đầu</label>
                                </div>
                                <div class="input-field col s12 m6">
                                    <input type="text" class="validate" id="end-time" name="end-time" value="<?php echo $endTime ?>" title="Thời gian kết thúc" required="">
                                    <label>Thời gian kết thúc</label>
                                </div>
                            </div>
                            
                            <div class="row db-file-upload">
                                <div class="file-field input-field">
                                    <div class="db-up-btn"> <span>File</span>
                                        <input type="file" id="cover-image" name="cover-image" accept=".jpg, .jpeg, .png, .gif">
                                        <input type="hidden" name="current-image" id="current-image-link" value="<?php echo $avatar ?>">
                                    </div>
                                    <div class="file-path-wrapper">
                                        <input class="file-path validate" type="text" placeholder="Chọn để thay đổi hình ảnh"> </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="input-field col s12">
                                    <img src="<?php echo $avatar ?>" id="image-preview">
                                </div>
                            </div>

                            <div class="row">
                                <div class="input-field col s12">
                                    <input type="text" class="validate" id="short-desc" name="short-desc" value="<?php echo $shortDesc ?>" maxlength="100"  title="Mô tả ngắn" required="">
                                    <label>Mô tả ngắn</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s12">
                                    <!-- <input type="text" class="validate" id="description" name="description"> -->
                                    <textarea class="validate" id="description" name="description" ><?php echo $description; ?></textarea>
                                </div>
                            </div>

                            <div class="row">
                                <input type="hidden" id="event-status" name="status">
                                <input type="hidden" name="action" value="edit">

                                <div class="input-field col s12 m12">
                                    <a href="#" class="full-btn btn btn-info waves-light waves-effect" data-toggle="modal" data-target="#history-modal">Lịch sử duyệt</a>
                                </div>

                                <?php
                                if ($status == 3) {
                                ?>
                                <div class="input-field col s12 m12">
                                    <button type="submit" id="public-btn" class="full-btn btn btn-primary waves-light waves-effect"><i class="fa fa-globe" aria-hidden="true"></i> Đăng sự kiện</button>
                                </div>
                                <?php
                                }
                                 ?>

                                <div class="input-field col s12 m4">
                                    <button type="submit" id="submit-btn" class="full-btn btn btn-success waves-light waves-effect"><i class="fa fa-paper-plane" aria-hidden="true"></i> Gửi sự kiện</button>
                                </div>
                                <div class="input-field col s12 m4">
                                    <button type="submit" id="save-btn" class="full-btn btn btn-warning waves-light waves-effect"><i class="fa fa-floppy-o" aria-hidden="true"></i> Lưu Nháp</button>
                                </div>
                                <div class="input-field col s12 m4">
                                    <a href="my-events.php" class="full-btn btn btn-danger waves-light waves-effect"><i class="fa fa-times" aria-hidden="true"></i> Huỷ</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- History comment -->
            <div id="history-modal" class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <!-- Modal content-->
                    <form id="delete-product-form" method="POST" action="<?php  $_SERVER["PHP_SELF"] ?>">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title"> Lịch sử duyệt</h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <div class="modal-body">
                            <table class="reponsive-table">
                                <thead>
                                    <tr>
                                        <th>Người từ chối</th>
                                        <th>Thời gian</th>
                                        <th>Lí do</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $resultComment = mysqli_query($conn, "SELECT name , comment, day_comment FROM review_comment r, account a WHERE event_id = ".$event_id." AND r.account_id = a.id");
                                    if (mysqli_num_rows($resultComment) > 0) {
                                        while ($rowComment = mysqli_fetch_assoc($resultComment)) {
                                            ?>
                                            <tr>
                                                <td><?php echo $rowComment["name"] ?></td>
                                                <td><?php echo date("H:i - d/m/Y", strtotime($rowComment["day_comment"])) ?></td>
                                                <td><?php echo $rowComment["comment"] ?></td>
                                            </tr>
                                            <?php
                                        }
                                    } else {
                                        ?>
                                        <tr>
                                            <td class="text-center" colspan="3">Bài đăng của bạn chưa có lịch sử bình luận</td>
                                        </tr>
                                        <?php

                                    }
                                    ?>
                                    
                                </tbody>
                                
                            </table>             
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-info" data-dismiss="modal">Đóng</button>
                            </div>
                        </div>
                    </form>
                </div>              
            </div>
            <!-- End History comment -->

            <!--RIGHT SECTION-->
        </div>
    </section>
    <!--END DASHBOARD-->


    <!--====== FOOTER 2 ==========-->
    <section>
        <div class="rows">
            <div class="footer">
                <div class="container">
                    <div class="foot-sec2">
                        <div>
                            <div class="row footernoop">
                                <div class="col-sm-3 foot-spec foot-com">
                                    <div class="wed-logo2">
                                        <a href="/event"><img src="images/preloader.png" alt="" />
                                        </a>
                                    </div>
                                </div>
                                <div class="col-sm-3 foot-spec foot-com">
                                    <h4>Địa chỉ</h4>
                                    <p><a style="color: #fff" href="https://goo.gl/maps/2CcxCxTxQXPDDYwW8" target="_blank"><i class="fa fa-home" aria-hidden="true"></i> Trụ sở: <br>45 Nguyễn Khắc Nhu, P.Cô Giang, Q.1, Hồ Chí Minh.</a></p>
                                    <p><a style="color: #fff" href="https://goo.gl/maps/H4RCpcajjiNjpjZ8A" target="_blank"><i class="fa fa-home" aria-hidden="true"></i> Cơ sở 2: <br> 233A Phan Văn Trị, P.11, Q.Bình Thạnh, Hồ Chí Minh.</a></p>
                                    <p><a style="color: #fff" href="https://goo.gl/maps/UdzN3SB64pcwUyGGA" target="_blank"><i class="fa fa-home" aria-hidden="true"></i> Cơ sơ 3: <br> 80/68 Dương Quảng Hàm, P.5, Q.Gò Vấp, Hồ Chí Minh. <br> 69/68 Đặng Thùy Trâm, P.13, Q.Bình Thạnh, Hồ Chí Minh.</a></p>
                                </div>
                                <div class="col-sm-3 col-md-3 foot-spec foot-com">
                                    <h4>Điện thoại</h4>
                                    <p"><a style="color: #fff" href="tel:02871099218,3310"><i class="fa fa-phone" aria-hidden="true"></i> 028 7109 9218 (Ext: 3310)</a></p>
                                    <p><a style="color: #fff" href="tel:02871099218,3311"><i class="fa fa-phone" aria-hidden="true"></i> 028 7109 9218 (Ext: 3311)</a></p>
                                    <p><a style="color: #fff" href="mailto:sukien.vanlanguni.edu.vn"><i class="fa fa-envelope-o" aria-hidden="true"></i> sukien.vanlanguni.edu.vn</a></p>
                                </div>
                                <div class="col-sm-3 foot-social foot-spec foot-com">
                                    <h4>Theo dõi chúng tôi</h4>
                                    
                                    <ul>
                                        <li><a href="https://www.facebook.com/truongdaihocvanlang/" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                                        <li><a href="https://www.youtube.com/user/truongdhvanlang" target="_blank"><i class="fa fa-youtube-play" aria-hidden="true"></i></a></li>
                                        <li><a href="https://www.instagram.com/vanlanguniversity/?r=nametag" target="_blank"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
                                        <li><a href="https://twitter.com/universityvan?lang=en" target="_blank"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--========= Scripts ===========-->
    <script src="js/jquery-latest.min.js"></script>
    <script src="js/bootstrap.js"></script>
    <script src="js/wow.min.js"></script>
    <script src="js/materialize.min.js"></script>
    <script src="js/custom.js"></script>
    <script src="js/bootstrap-datepicker.js"></script>
    <script src="js/bootstrap-datetimepicker.js"></script>
    

    <!-- Datatables -->
    <script type="text/javascript" src="vendor/DataTables/datatables.min.js"></script>
    <!-- CKEditor -->
    <script type="text/javascript" src="vendor/ckeditor5/ckeditor.js"></script>
    <!-- Pusher -->
    <script type="text/javascript" src="vendor/Pusher/pusher.min.js"></script>
</body>

</html>

<!-- <?php
    // include 'footer.php';
?> -->

<!-- <script src="js/bootstrap.js"></script>
<script src="js/materialize.min.js"></script> -->

<script type="text/javascript">
    $(document).ready( function (){
        $('#event-table').DataTable({
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

    ClassicEditor
        .create( document.querySelector( '#description' ), {
            // toolbar: [ 'heading', '|', 'bold', 'italic', 'link' ]
            placeholder: 'Chi tiết sự kiện'
        } )
        .then( editor => {
            window.editor = editor;

        } )
        .catch( err => {
            console.error( err.stack );
        } );

    // editorData = editor.getData();

    $('#submit-btn').click(function(){
        $('#event-status').val('1');
        // alert('Sự kiện đã được gửi cho người kiểm duyệt');
    })
    $('#save-btn').click(function(){
        $('#event-status').val('0');
        // alert('Đã lưu sự kiện');
    })
    $('#public-btn').click(function(){
        $('#event-status').val('4');
        // alert('Sự kiện đã được công khai');
    })


    // dont alow special character
    $('#event-name, #place, #short-desc').on('keydown keyup', function(){
        $(this).val($(this).val().replace(/[~`#$%^*{}_\[\]\\><|\/]+/g,''));
    })


    // ticket number
    $('#ticket-number').on('keydown keyup', function(){
        // don't allow start with 0
        if ($(this).val() == "0") {
            $(this).val($(this).val().replace(/[^1-9]+/g, ''));
        }

        // only number
        $(this).val($(this).val().replace(/[^0-9]+/g, ''));
    })


    // time start end
    $('#start-time, #end-time').on('keydown keyup', function(){
        $(this).val($(this).val().replace(/[^0-9 /:]+/g, ''));
    })


    $('#edit-event-form').submit(function(e){
        e.preventDefault();
        var name = $('#event-name').val();
        var category = $('#category').val();
        var faculty = $('#faculty').val();
        // var moderator = $('#moderator').val();
        var numTicket = $('#ticket-number').val();
        var place = $('#place').val();
        var startTime = $('#start-time').val();
        var endTime = $('#end-time').val();
        var shortDesc = $('#short-desc').val();
        var description = editor.getData();
        // var status = $('#event-status').val();

        if (name.replace(/\s+/g, ' ').trim().length < 10) {
            alert('Tên sự kiện tối thiểu 10 ký tự');
            $('#event-name').focus();
            return false;
        }

        if (category == null) {
            alert('Vui lòng chọn danh mục');
            $('#category').focus();
            return false;
        }
        if (faculty == null) {
            alert('Vui lòng chọn khoa');
            return false;
        }

        // if (moderator == null) {
        //     alert('Vui lòng chọn người điểm danh');
        //     return false;
        // }

        if (place.replace(/\s+/g, ' ').trim().length < 10) {
            alert('Địa chỉ tối thiểu 10 ký tự');
            $('#place').focus();
            return false;
        }

        // if ($('#cover-image').val() == '') {
        //     alert('Vui lòng chọn hình ảnh');
        //     return false;
        // }

        if (shortDesc.replace(/\s+/g, ' ').trim().length < 10) {
            alert('Mô tả ngắn tối thiểu 10 ký tự');
            $('#short-desc').focus();
            return false;
        }

        if (description.replace(/\s+/g, ' ').trim().length < 50) {
            alert('Chi tiết sự kiện tối thiểu 50 ký tự');
            $('.ck-blurred').focus()
            return false;
        }

        
        var eventForm = document.querySelector("#edit-event-form");

        $.ajax({
            url: 'process-my-event.php',
            method: 'POST',
            dataType: 'json',
            // data: {
            //     'action': 'edit',
            //     'id': eventID,
            //     'name': name,
            //     'category': category,
            //     'faculty': faculty,
            //     'moderator': moderator,
            //     'ticket-number': numTicket,
            //     'place': place,
            //     'start-time': startTime,
            //     'end-time': endTime,
            //     'short-desc': shortDesc,
            //     'description': description,
            //     'status': status
            // }
            processData: false,
            contentType: false,
            data: new FormData(eventForm)

        }).done(function(data){
            // console.log(data);
            if(data.result){
                window.location = 'my-events.php';
            }else {
                alert(data.message);
                // console.log(data.error);
                // console.log(data.sql)
            }
        }).fail(function(jqXHR, statusText, errorThrown){
            console.log("Fail:"+ jqXHR.responseText);
            console.log(errorThrown);
        })

    })

    $(function () {
        $('#start-time, #end-time').datetimepicker({
          // format: "hh:ii - dd/mm/yyyy"
          format: "yyyy/mm/dd hh:ii"
        });
    });


    var current_image_link = $('#current-image-link').val();

    function load_image(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#image-preview').attr('src',e.target.result);
            };
            reader.readAsDataURL(input. files[0]);
        }
    }

    $('#cover-image').change(function () {
        load_image(this);
        if ($(this).val() == '') $('#image-preview').attr('src', current_image_link);
    });
</script>