<?php
$title = 'Thêm sự kiện';
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
                    <h4>Thông tin sự kiện</h4>
                    <div class="db-2-main-com db2-form-pay db2-form-com">
                        <form class="col s12" id="add-event-form" method="POST" enctype="multipart/form-data">
                            <div class="row">
                                <div class="input-field col s12">
                                    <input type="text" class="validate" id="event-name" name="name" required>
                                    <label for="event-name">Tên sự kiện</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s12">
                                    <select name="category" id="category">
                                        <option selected disabled>Vui lòng chọn danh mục...</option>
                                        <?php 
                                        require("database-config.php");
                                        $sql = "SELECT * FROM category";
                                        $result = mysqli_query($conn, $sql);
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            ?>
                                            <option value="<?php echo $row['id'] ?>"><?php echo $row['name'] ?></option>
                                        <?php }
                                        ?>

                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s12">
                                    <select name="faculty" id="faculty">
                                        <option selected disabled>Vui lòng chọn khoa...</option>
                                        <?php 
                                        require("database-config.php");
                                        $sql = "SELECT * FROM faculty WHERE status = 1";
                                        $result = mysqli_query($conn, $sql);
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            ?>
                                            <option value="<?php echo $row['faculty_id'] ?>"><?php echo $row['name'] ?></option>
                                        <?php }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s12">
                                    <select name="moderator" id="moderator">
                                        <option selected disabled>Vui lòng chọn người điểm danh...</option>
                                        <?php 
                                        require("database-config.php");
                                        $sql = "SELECT id, name FROM account WHERE role = 3";
                                        $result = mysqli_query($conn, $sql);
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            ?>
                                            <option value="<?php echo $row['id'] ?>"><?php echo $row['name']?></option>
                                        <?php }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s12">
                                    <input type="number" class="validate" id="ticket-number" name="ticket-number" required="">
                                    <label>Số lượng vé</label>
                                </div>

                                <div class="input-field col s12">
                                    <input id="place" name="place" type="text" value="" class="validate" required>
                                    <label for="place">Địa điểm</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s12 m6">
                                    <input type="text" class="validate" id="start-time" name="start-time" required="">
                                    <label>Thời gian bắt đầu</label>
                                </div>
                                <div class="input-field col s12 m6">
                                    <input type="text" class="validate" id="end-time" name="end-time" required="">
                                    <label>Thời gian kết thúc</label>
                                </div>
                            </div>
                            
                            <div class="row db-file-upload">
                                <div class="file-field input-field">
                                    <div class="db-up-btn"> <span>File</span>
                                        <input type="file" id="cover-image" name="cover-image">
                                    </div>
                                    <div class="file-path-wrapper">
                                        <input class="file-path validate" type="text" placeholder="Vui lòng chọn hình ảnh"> </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="input-field col s12">
                                    <input type="text" class="validate" id="short-desc" name="short-desc" required="">
                                    <label>Mô tả ngắn</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s12">
                                    <!-- <input type="text" class="validate" id="description" name="description"> -->
                                    <textarea class="validate" id="description" name="description"></textarea>
                                </div>
                            </div>

                            <div class="row">
                                <input type="hidden" id="event-status" name="status">
                                <input type="hidden" name="action" value="add">
                                <div class="input-field col s12 m4">
                                    <button type="submit" id="submit-btn" class="full-btn btn btn-success waves-light waves-effect"><i class="fa fa-paper-plane" aria-hidden="true"></i> Gửi sự kiện</button>
                                </div>
                                <div class="input-field col s12 m4">
                                    <button type="submit" id="save-btn" class="full-btn btn btn-warning waves-light waves-effect"><i class="fa fa-floppy-o" aria-hidden="true"></i> Lưu Nháp</button>
                                </div>
                                <div class="input-field col s12 m4">
                                    <a href="my-events.php" class="full-btn btn btn-danger waves-light waves-effect"><i class="fa fa-ban" aria-hidden="true"></i> Huỷ</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>         
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
            // indentBlock: {
            //     offset: 1,
            //     unit: 'em'
            // },
            // plugins: [ Indent, IndentBlock],
            // toolbar: [ 'heading', '|', 'bold', 'italic', 'link' ],
            placeholder: 'Chi tiết sự kiện'
        } )
        .then( editor => {
            window.editor = editor;

        } )
        .catch( err => {
            console.error( err.stack );
        } );

    // editorData = editor.getData();

    // selectFaculty();
    // function selectFaculty(){
    //     $.ajax({
    //         url: 'my-event-process.php',
    //         method: 'POST',
    //         dataType: 'json',
    //         data: {'action': 'get-faculty-for-dropdown'}
    //     }).done(function(data){
    //         console.log(data);
    //         if(data.result){
    //             var rows = '<option disabled selected>Vui lòng chọn khoa...</option>';
    //             $.each(data.faculty, function(index, faculty){
    //                 rows += '<option value="'+faculty.id_faculty+'">'+faculty.name+'</option>';
    //             })
    //         }
    //         $('#faculty').html(rows);
    //     })
    // }

    $('#submit-btn').click(function(){
        $('#event-status').val('1');
        // alert('Sự kiện đã được gửi cho người kiểm duyệt');
    })
    $('#save-btn').click(function(){
        $('#event-status').val('0');
        // alert('Đã lưu sự kiện');
    })

    // dont alow special character
    $('#event-name, #place, #short-desc').on('keydown keyup', function(){
        $(this).val($(this).val().replace(/[@#$%^&*()><|\/]+/g,''));
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

    $('#add-event-form').submit(function(e){
        e.preventDefault();
        var name = $('#event-name').val();
        var category = $('#category').val();
        var faculty = $('#faculty').val();
        var moderator = $('#moderator').val();
        var numTicket = $('#ticket-number').val();
        var place = $('#place').val();
        var startTime = $('#start-time').val();
        var endTime = $('#end-time').val();
        var shortDesc = $('#short-desc').val();
        var description = editor.getData();
        // var status = $('#event-status').val();

        if (name.replace(/\s+/g, ' ').trim().length < 11) {
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
        if (moderator == null) {
            alert('Vui lòng chọn người điểm danh');
            return false;
        }

        if (place.replace(/\s+/g, ' ').trim().length < 11) {
            alert('Địa chỉ tối thiểu 10 ký tự');
            $('#place').focus();
            return false;
        }

        if ($('#cover-image').val() == '') {
            alert('Vui lòng chọn hình ảnh');
            return false;
        }

        if (shortDesc.replace(/\s+/g, ' ').trim().length < 11) {
            alert('Mô tả ngắn tối thiểu 10 ký tự');
            $('#short-desc').focus();
            return false;
        }

        var eventForm = document.querySelector("#add-event-form");
        console.log(eventForm);

        $.ajax({
            url: 'my-event-process.php',
            method: 'POST',
            dataType: 'json',
            // data: {
            //     'action': 'add',
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
            console.log(data);
            if(data.result){
                window.location = 'my-events.php';
            }else {
                console.log(data.error);
                console.log(data.sql)
            }
        }).fail(function(jqXHR, statusText, errorThrown){
            console.log("Fail:"+ jqXHR.responseText);
            console.log(errorThrown);
        })
    })
</script>