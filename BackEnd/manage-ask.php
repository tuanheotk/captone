<?php
$title = 'Trang chủ';
include('header.php');
?>
    <section>
            <div class="container">
                <div class="row">
                    <div class="tourz-search-10">
                        <h1>Cuộc họp livestream về dịch corona: <span>AD49</span></h1>
                        <form class="tourz-search-form">
                            <div class="input-field">
                            </div>
                            <div class="input-field">
                                <input type="text" id="select-search" class="autocomplete">
                                <label for="select-search" class="search-hotel-type">#123</label>
                            </div>
                            <div class="input-field">
                                <input type="submit" value="Gửi câu hỏi" class="waves-effect waves-light tourz-sear-btn"> 
                            </div>
                        </form>
                    </div>
                </div>
            </div>
    </section>


    <section class="container">
      <!-- Ask -->
      <div class="row">
        <div class="col-md-6">
          <div class="col-md-8">
            <p>Duyệt câu hỏi</p>
          </div>
          <div class="col-md-4">
            <div class="custom-control custom-switch">
              <input type="checkbox" class="custom-control-input" id="customSwitches">
              <label class="custom-control-label" for="customSwitches">Chế độ Moderator</label>
            </div>
          </div>
          
        </div>
        <div class="col-md-6">
          
        </div>
      </div>
    </section>

    <section class="container">
      <!-- Ask -->
      <div class="row">
        <div class=" col-md-6 manage-askquestion-border overflow-auto">
          <div class="card w-75">
            <div class="card-body askquestion">
              <h5 class="card-title">T160614</h5>
              <p class="card-text">Tại sao covid nhà trường không cho nghỉ mà bắt làm đồ án quài đm?</p>
              <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
              <button type="button" class="btn btn-success"><i class="fa fa-check" aria-hidden="true"></i></button>
              <button type="button" class="btn btn-danger"><i class="fa fa-times" aria-hidden="true"></i></button>
            </div>
          </div>

          <div class="card w-75">
            <div class="card-body askquestion">
              <h5 class="card-title">T160614</h5>
              <p class="card-text">Truong lol bat lam do an quai</p>
              <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
              <button type="button" class="btn btn-success"><i class="fa fa-check" aria-hidden="true"></i></button>
              <button type="button" class="btn btn-danger"><i class="fa fa-times" aria-hidden="true"></i></button>
            </div>
          </div>
          
        </div>

      <!-- Ask -->
        <div class=" col-md-6 manage-askquestion-border overflow-auto">
          <div class="card w-75">
            <div class="card-body askquestion">
              <h5 class="card-title">T160614</h5>
              <p class="card-text">Tại sao covid nhà trường không cho nghỉ mà bắt làm đồ án quài đm?</p>
              <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
              <button type="button" class="btn btn-info">1 <i class="fa fa-thumbs-up" aria-hidden="true"></i></button>
              <a href="#" class="btn btn-success" data-toggle="modal" data-target="#reply-modal" title="Trả lời"><i class="fa fa-reply" ></i></a>

              <button type="button" class="btn btn-info"><i class="fa fa-thumb-tack" aria-hidden="true"></i></button>
            </div>
          </div>

          <div class="card w-75">
            <div class="card-body askquestion">
              <h5 class="card-title">T162302</h5>
              <p class="card-text">Tại sao covid nhà trường không cho nghỉ mà bắt làm đồ án quài đm?</p>
              <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
              <button type="button" class="btn btn-warning">0 <i class="fa fa-thumbs-o-up" aria-hidden="true"></i></button>
              <a href="#" class="btn btn-success" data-toggle="modal" data-target="#reply-modal" title="Trả lời"><i class="fa fa-reply" ></i></a>
              
              <button type="button" class="btn btn-light"><i class="fa fa-thumb-tack" aria-hidden="true"></i></button>
            </div>
          </div>
          <div class="card w-75">
            <div class="card-body askquestion">
              <h5 class="card-title">Stranger 3211</h5>
              <p class="card-text">Tại sao covid nhà trường không cho nghỉ mà bắt làm đồ án quài đm?</p>
              <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
            </div>
          </div>
          <div class="card w-75">
            <div class="card-body askquestion">
              <h5 class="card-title">Stranger 3570</h5>
              <p class="card-text">Tại sao covid nhà trường không cho nghỉ mà bắt làm đồ án quài đm?</p>
              <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- Reply Event Modal -->
            <div id="reply-modal" class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <!-- Modal content-->
                    <form id="delete-product-form" method="POST" action="<?php  $_SERVER["PHP_SELF"] ?>">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title"> Trả lời câu hỏi</h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <div class="card-body askquestion">
                                      <h5 class="card-title">T160614</h5>
                                      <p class="card-text">Tại sao covid nhà trường không cho nghỉ mà bắt làm đồ án quài đm?</p>
                                      <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
                                    </div>
                            </div>
                            <div class="modal-body">
                                 <div class="card w-75">
                                    <div class="card-body askquestion">
                                      <h5 class="card-title">Tú</h5>
                                      <p class="card-text">Bú cu không em?</p>
                                      <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
                                    </div>
                                  </div>
                                  <div class="card w-75">
                                    <div class="card-body askquestion">
                                      <h5 class="card-title">Thầy Duy Cáp Ton</h5>
                                      <p class="card-text">Bú Cu thầy đi thầy cho nghỉ học</p>
                                      <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
                                    </div>
                                  </div>       
                            </div>
                            
                            <div class="modal-footer">    
                                  <div class="col-md-10">
                                    <input type="text" class="form-control" placeholder="Trả lời" aria-label="Recipient's username" aria-describedby="basic-addon2">
                                    
                                  </div>
                                  <div class="col-md-2">
                                    <div class="input-group-append">
                                      <button class="btn btn-success" type="button">Button</button>
                                    </div>
                                    
                                  </div>
                             </div>   
                                  
                                
                            
                        </div>
                    </form>
                </div>              
            </div>
    
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