<?php
$title = 'Sửa thông tin tài khoản';
include('header.php');

if (isset($_GET["id"]) && $account_role == 4) {
    $accountID = $_GET["id"];
    $sqlCheckExist = "SELECT id FROM account WHERE id = ".$accountID;
    $resultCheckExist = mysqli_query($conn, $sqlCheckExist);

    if (mysqli_num_rows($resultCheckExist) > 0) {
        $sql = "SELECT * FROM account WHERE id = ".$accountID;
        $result = mysqli_query($conn, $sql);
        while ($row = mysqli_fetch_assoc($result)) {
            $code = $row["code"];
            $name = $row["name"];
            $faculty_id = $row["faculty_id"];
            $email = $row["email"];
            $role = $row["role"];
            $status = $row["status"];
        }
    } else {
        header("Location: manage-account.php");
    }
    

} else {
    header("Location: manage-account.php");
}
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
                    <h4>Thông tin tài khoản</h4>
                    <div class="db-2-main-com db2-form-pay db2-form-com">
                        <form class="col s12" id="edit-account-form" method="POST" enctype="multipart/form-data">
                            <div class="row">
                                <div class="input-field col s12">
                                    <input type="text" class="validate" id="name" name="name" value="<?php echo $name ?>" required="">
                                    <label for="name">Họ tên</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s12">
                                    <input type="text" class="validate" id="email" name="email" value="<?php echo $email ?>" disabled="">
                                    <label for="email">Email</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s12">
                                    <?php 
                                    if ($code != "") {
                                    ?>
                                    <input type="text" class="validate" id="code" name="code" value="<?php echo $code ?>" disabled="">
                                    <label for="code">Mã tài khoản</label>

                                    <?php
                                    }
                                    ?>

                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s12 fix-select">
                                    <select name="faculty" id="faculty">
                                        <option selected disabled>Vui lòng chọn khoa...</option>
                                        <?php 
                                        require("database-config.php");
                                        $sql = "SELECT * FROM faculty WHERE status = 1";
                                        $result = mysqli_query($conn, $sql);
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            if ($faculty_id == $row["faculty_id"]) {
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
                                <div class="input-field col s12 fix-select">
                                    <select name="role" id="role">
                                        <option selected disabled>Vui lòng chọn loại tài khoản</option>

                                        <?php 
                                        $sqlRole = mysqli_query($conn, "SELECT role FROM account WHERE id =".$accountID);
                                        $resultRole = mysqli_fetch_assoc($sqlRole);
                                        $roleID = $resultRole["role"];

                                        $arrayRole = array(array(1,"Thành viên"), array(2,"Người kiểm duyệt"));

                                        for ($i=0; $i < count($arrayRole); $i++) { 
                                            if ($arrayRole[$i][0] == $roleID) {
                                                echo '<option value="'.$arrayRole[$i][0].'" selected>'.$arrayRole[$i][1].'</option>';
                                            } else {
                                                echo '<option value="'.$arrayRole[$i][0].'">'.$arrayRole[$i][1].'</option>';
                                            }
                                            
                                        }

                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="input-field col s12">
                                    <select name="status" id="status">
                                        <?php 
                                        $sqlStatus = mysqli_query($conn, "SELECT status FROM account WHERE id =".$accountID);
                                        $resultStatus = mysqli_fetch_assoc($sqlStatus);
                                        $status = $resultStatus["status"];

                                        $arrStt = array(array(0,"Vô hiệu hoá"), array(1,"Đang hoạt động"));

                                        for ($i=0; $i < count($arrStt); $i++) { 
                                            if ($arrStt[$i][0] == $status) {
                                                echo '<option value="'.$arrStt[$i][0].'" selected>'.$arrStt[$i][1].'</option>';
                                            } else {
                                                echo '<option value="'.$arrStt[$i][0].'">'.$arrStt[$i][1].'</option>';
                                            }
                                            
                                        }

                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div class="row">

                                <div class="input-field col s12 m6">
                                    <input type="hidden" id="account-id" name="account-id" value="<?php echo $accountID ?>">
                                    <input type="hidden" name="action" value="edit">
                                    <button type="submit" class="full-btn btn btn-success waves-light waves-effect"><i class="fa fa-check" aria-hidden="true"></i> Lưu</button>
                                </div>
                                <div class="input-field col s12 m6">
                                    <a href="manage-account.php" class="full-btn btn btn-danger waves-light waves-effect"><i class="fa fa-times" aria-hidden="true"></i> Huỷ</a>
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
                        <a href="my-profile.php"> <img src="images/icon/dbr1.jpg" alt="" />
                            <h5><?php echo $account_name ?></h5>
                            <p><i class="fa fa-envelope"></i> <?php echo $account_email ?></p>
                            <p><i class="fa fa-th-large"></i> <?php echo $account_faculty_name ?></p>
                            
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

    // dont alow special character
    $('#name').on('keydown keyup', function(){
        $(this).val($(this).val().replace(/[@#$%^&*()><|\/]+/g,''));
    })


    $('#edit-account-form').submit(function(e){
        e.preventDefault();
        var name = $('#name').val();
        var faculty = $('#faculty').val();
        var role = $('#role').val();

        if (name.replace(/\s+/g, ' ').trim().length < 6) {
            alert('Họ tên tối thiểu 5 ký tự');
            $('#event-name').focus();
            return false;
        }

        if (faculty == null) {
            alert('Vui lòng chọn khoa');
            $('#category').focus();
            return false;
        }
        if (role == null) {
            alert('Vui lòng chọn loại tài khoản');
            return false;
        }

        
        var accountForm = document.querySelector("#edit-account-form");

        $.ajax({
            url: 'process-manage-account.php',
            method: 'POST',
            dataType: 'json',
            processData: false,
            contentType: false,
            data: new FormData(accountForm)

        }).done(function(data){
            console.log(data);
            if(data.result){
                window.location = 'manage-account.php';
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