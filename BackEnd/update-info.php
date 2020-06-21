<?php
$title = 'Cập nhật thông tin';
include('header.php');

if (!isset($_SESSION["user_email"]) || ($account_faculty_id != -1 && $account_name != "")) {
    header("Location: /");
    // header('Location: javascript://history.go(-1)');
}
?>
    
    <!--HEADER SECTION-->
    <section>
        <div class="v2-hom-search">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                    <div class="v2-ho-se-ri">
                        <h1>Xin vui lòng bổ sung thông tin để tiếp tục</h1>
                        <p>Để tốt hơn cho việc sử dụng, vui lòng cập nhật thông tin đầy đủ trước khi đăng kí các sự kiện!!</p>
                        
                    </div>                      
                    </div>  
                    <div class="col-md-6">
                    <div class="">
                        <form class="contact__form v2-search-form" id="update-info-form" method="post" method="POST">
                            <div class="input-field text-danger">
                                Vui lòng sử dụng thông tin chính xác nhất
                            </div>
                            <div class="row">
                                <div class="input-field col s12">
                                    <input type="text" class="validate" id="name" name="name" value="<?php echo $account_name ?>" required>
                                    <label>Họ & Tên</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s12">
                                    <input type="email" id="email" name="email" value="<?php echo $account_email ?>" readonly>
                                    <label>Email</label>
                                </div>
                            </div>
                           
                            <div class="row">
                                <div class="input-field col s12 fix-select">
                                    <select name="faculty" id="faculty">
                                        <option selected disabled>Vui lòng chọn khoa...</option>
                                        <?php
                                        if ($account_vlu) {
                                            $sql = "SELECT * FROM faculty WHERE faculty_id >= 1";
                                        } else {
                                            $sql = "SELECT * FROM faculty WHERE faculty_id >= 0";
                                        }
                                        
                                        $result = mysqli_query($conn, $sql);
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            if ($row["faculty_id"] == $account_faculty_id) {
                                        ?>
                                            <option value="<?php echo $row['faculty_id'] ?>" selected><?php echo $row['name'] ?></option>
                                        <?php
                                            } else {
                                        ?>
                                            <option value="<?php echo $row['faculty_id'] ?>"><?php echo $row['name'] ?></option>
                                        <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                                                    
                                                   
                            <div class="row">
                                <div class="input-field col s12">
                                    <input type="hidden" name="action" value="require-info">
                                    <input type="submit" value="Cập nhật" class="waves-effect waves-light tourz-sear-btn v2-ser-btn">
                                </div>
                            </div>
                        </form>
                    </div>                      
                    </div>              
                </div>
            </div>
        </div>
    </section>
    <!--END HEADER SECTION-->
<?php
include('footer.php');
?>

<script src="js/bootstrap.js"></script>
<script src="js/materialize.min.js"></script>


<script type="text/javascript">
    // dont alow special character
    $('#name').on('keydown keyup', function(){
        $(this).val($(this).val().replace(/[0123456789?,.:;"`~!@#$%^&*()\-_+={}\[\]><|\/\\\']+/g,''));
    })


    $('#update-info-form').submit(function(e){
        e.preventDefault();
        var name = $('#name').val();
        var faculty = $('#faculty').val();

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
        
        var eventForm = document.querySelector("#update-info-form");
        console.log(eventForm);

        $.ajax({
            url: 'process-manage-account.php',
            method: 'POST',
            dataType: 'json',
            processData: false,
            contentType: false,
            data: new FormData(eventForm)

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