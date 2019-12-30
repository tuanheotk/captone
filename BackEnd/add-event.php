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
                        
                        <!-- <li>
                            <a href="my-events.php"><i class="fa fa-hourglass-end" aria-hidden="true"></i> Sự kiện đang chờ</a>
                        </li> -->
                        <li>
                            <a href="my-events.php"><i class="fa fa-check" aria-hidden="true"></i> Sự kiện đã đăng ký tham gia</a>
                        </li>
                        
                        
                    </ul>
                </div>
            </div>
            <!--CENTER SECTION-->
            <div class="db-2">
                <div class="db-2-com db-2-main">
                    <h4>Thông tin sự kiện</h4>
                    <div class="db-2-main-com db2-form-pay db2-form-com">
                        <form class="col s12" enctype="multipart/form-data">
                            <div class="row">
                                <div class="input-field col s12">
                                    <input type="text" class="validate" id="event-name" name="event-name" required="">
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
                                            <option value="<?php echo $row['id_faculty'] ?>"><?php echo $row['name'] ?></option>
                                        <?php }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s12">
                                    <select name="moderator" id="moderator">
                                        <option selected disabled>Chọn người điểm danh</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s12">
                                    <input type="number" class="validate" id="ticket-number" name="ticket-number" required="">
                                    <label>Số lượng vé</label>
                                </div>

                                <div class="input-field col s12">
                                    <input id="list-title" type="text" value="" class="validate">
                                    <label for="list-title">Địa điểm</label>
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
                                        <input type="file">
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
                                    <input type="text" class="validate" id="description" name="description" required="">
                                    
                                    <!-- <label for="description">Chi tiết sự kiện</label> -->
                                </div>
                            </div>

                            <div class="row">
                                <div class="input-field col s12 m4">
                                    <button type="button" class="full-btn btn btn-success waves-light waves-effect"><i class="fa fa-paper-plane" aria-hidden="true"></i> Gửi sự kiện</button>
                                </div>
                                <div class="input-field col s12 m4">
                                    <button type="button" class="full-btn btn btn-warning waves-light waves-effect"><i class="fa fa-floppy-o" aria-hidden="true"></i> Lưu Nháp</button>
                                </div>
                                <div class="input-field col s12 m4">
                                    <a href="my-events.php" class="full-btn btn btn-danger waves-light waves-effect"><i class="fa fa-ban" aria-hidden="true"></i> Huỷ</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

           <!-- Delete Modal -->
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
                    Bạn có muốn xoá sự kiện abc xyz igh?
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

    // selectFaculty();
    function selectFaculty(){
        $.ajax({
            url: 'my-event-process.php',
            method: 'POST',
            dataType: 'json',
            data: {'action': 'get-faculty-for-dropdown'}
        }).done(function(data){
            console.log(data);
            if(data.result){
                var rows = '<option disabled selected>Vui lòng chọn khoa...</option>';
                $.each(data.faculty, function(index, faculty){
                    rows += '<option value="'+faculty.id_faculty+'">'+faculty.name+'</option>';
                })
            }
            $('#faculty').html(rows);
        })
    }
</script>