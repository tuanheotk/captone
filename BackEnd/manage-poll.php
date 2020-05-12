<?php
$title = 'Quản lý bầu chọn';
include('header.php');
/*s*/
?>
    <section>
        <audio>
            <source src="audio/beep.wav" type="audio/wav">
        </audio>
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
                            <a href="my-events.php"><i class="fa fa-check" aria-hidden="true"></i> Sự kiện đã đăng ký tham gia</a>
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
                    <h4>Danh sách người tham dự</h4>
                    
                    <div class="db-2-main-com">
                      <section class="container">
                          <!-- Ask -->
                          <div class="row">
                            <div class="col-md-6">
                              <div class="col-md-8">
                                <p>Danh sách</p>
                              </div>
                              <div class="col-md-4">
                                <a href="#" class=" btn btn-success" data-toggle="modal" data-target="#create-poll-modal" title="Xóa sự kiện">Tạo cuộc bầu chọn</a>
                              </div>
                              
                            </div>

                            <div class="col-md-6">
                              <div class="col-md-8">
                                <p>Kết Quả</p>
                              </div>
                              <div class="col-md-4">
                                <h5>Các bạn hihi</h5>
                              </div>
                          </div>
                        </section>


                        <section class="container-full">
                          <!-- Ask -->
                          <div class="col-md-6">
                            <div class="card w-75">
                                <div class="card-body askquestion">
                                  <h5 class="card-title">Các bạn hihi</h5>
                                  <p class="card-text">Chỉ chọn một</p>
                                  <p class="card-text"><small class="text-muted">Số người bầu: 20 người</small></p>

                                  <button type="button" class="btn btn-warning"><i class="fa fa-pencil" aria-hidden="true"></i></button>
                                  <button type="button" class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></button>
                                </div>
                              </div>
                            
                          </div>
                          <!-- Ask -->
                          <div class="col-md-6">
                            <p>alo</p>
                            <div class="progress">
                              <div class="progress-bar" role="progressbar" style="width: 15%;" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100">15%</div>
                            </div>
                            <p>alo</p>
                            <div class="progress">
                              <div class="progress-bar" role="progressbar" style="width: 25%;" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100">25%</div>
                            </div>
                            <p>alo</p>
                            <div class="progress">
                              <div class="progress-bar" role="progressbar" style="width: 45%;" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100">45%</div>
                            </div>
                            <p>alo</p>
                            <div class="progress">
                              <div class="progress-bar" role="progressbar" style="width: 15%;" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100">15%</div>
                            </div>
                          </div>
                        </section>  
                    </div>
                </div>
            </div>
        
            
            <!-- Reply Event Modal -->
            <div id="create-poll-modal" class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <!-- Modal content-->
                    <form method="POST" action="<?php  $_SERVER["PHP_SELF"] ?>">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h5>Tạo cuộc bầu chọn mới</h5>
                            </div>
                            <div class="modal-body modal-poll">
                                  <div class="col-md-12">
                                    <input type="text" class="form-control" placeholder="Bạn muốn khảo sát điều gì?"  aria-describedby="basic-addon2">
                                  </div>
                                    <div class="col-md-10">
                                      <input type="text" class="form-control" placeholder="Bạn muốn khảo sát điều gì?"  aria-describedby="basic-addon2">
                                    </div>
                                    <div class="col-md-2">
                                      <a href="#" class="delete-event btn waves-effect waves-light btn-sm btn-danger" data-toggle="modal" data-target="#delete-modal" title="Xóa sự kiện"><i class="fa fa-trash-o" ></i></a>
                                    </div>
                                    <div class="col-md-2">
                                      <button class="btn btn-success btn-block"><i class="fa fa-plus"></i></button>
                                    </div>
                                    <div class="col-md-12">
                                      <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="customSwitches">
                                        <label class="custom-control-label" for="customSwitches">Cho phép người tham dự chọn nhiều lựa chọn</label>
                                      </div>
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" type="number" name="" value="2">
                                    </div>
                            </div>
                            
                            <div class="modal-footer">    
                                  <div class="col-md-12">
                                    <div class="col-md-8">
                                    </div>
                                    <div class="col-md-4">
                                      <button class="btn btn-success btn-block"><i class="fa fa-plus"> Tạo</i></button>
                                    </div>
                                  </div>
                            </div>   
                                  
                                
                            
                        </div>
                    </form>
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
    <script type="text/javascript" src="vendor/ckeditor5/ckeditor.js"></script>
    <!-- CKEditor -->
</body>

</html>