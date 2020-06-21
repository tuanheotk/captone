<?php
    $title = "Duyệt sự kiện";
    include "header.php";
    if (!isset($account_role) || ($account_role != 2 && $account_role != 4)) {
        header("Location: my-events.php");
    }

    if ($account_role == 4) {
        $sql = "SELECT e.*, a.name as host_name, a.email, f.name AS faculty_name FROM event e, account a, faculty f WHERE e.status IN (1,2,3) AND e.account_id = a.id AND e.faculty_id = f.faculty_id ORDER BY e.last_modified DESC";
    } else {
        $sql = "SELECT e.*, a.name as host_name, a.email, f.name AS faculty_name FROM event e, account a, faculty f WHERE e.status IN (1,2,3) AND e.account_id = a.id AND e.faculty_id = f.faculty_id AND (e.faculty_id = $account_faculty_id OR e.id IN (SELECT event_id FROM reviewer WHERE email = '$account_email' AND reviewer.event_id = e.id AND e.status IN (1,2,3))) ORDER BY e.last_modified DESC";
    }
    
    $result = mysqli_query($conn, $sql);
   
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
                        <?php
                        if (isset($account_role) && $account_role == 4) {
                        ?>
                        <li>
                            <a href="all-events.php"><i class="fa fa-calendar-check-o" aria-hidden="true"></i> Tất cả sự kiện</a>
                        </li>
                        <?php
                        }
                        ?>
                        <li>
                            <a href="my-events.php"><i class="fa fa-calendar" aria-hidden="true"></i> Sự kiện của tôi</a>
                        </li>

                        <?php
                        if (isset($is_mod) && $is_mod) {
                        ?>
                        <li>
                            <a href="my-support-events.php"><i class="fa fa-handshake-o" aria-hidden="true"></i> Sự kiện hỗ trợ</a>
                        </li>
                        <?php
                        }
                        ?>
                        <li>
                            <a href="my-registered-events.php"><i class="fa fa-check" aria-hidden="true"></i> Sự kiện đã đăng ký tham gia</a>
                        </li>
                         <li>
                            <a href="review-event.php"><i class="fa fa-hourglass-end" aria-hidden="true"></i> Duyệt sự kiện</a>
                        </li>
                        
                    </ul>
                </div>
            </div>
            <!--CENTER SECTION-->
            <div class="db-2">
                <div class="db-2-com db-2-main">
                    <h4>Danh sách sự kiện cần duyệt</h4>
                    <div class="db-2-main-com db-2-main-com-table">
                        <table class="table table-hover" id="review-table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Tên sự kiện</th>
                                    <th>Thời gian</th>
                                    <th>Người đăng</th>
                                    <th>Đơn vị tổ chức</th>
                                    <th>Trạng thái</th>
                                    <th>Xét duyệt</th>
                                   
                                </tr>
                            </thead>
                            <tbody id="tbodylistevent">
                                <?php
                                // Function short title
                                function shortTitle($title)
                                {
                                    $space = 0;
                                    $end = 0;
                                    $shorted = "";
                                    $num_of_char = 10;

                                    for ($i = 0; $i < strlen($title); $i++) {
                                        if ($title[$i] == " ")
                                            $space++;
                                        if ($space == $num_of_char) {
                                            $end = $i;
                                            break;
                                        }
                                    }
                                    
                                    if ($space < $num_of_char) {
                                        return $title;
                                    } else {
                                        $shorted = substr($title, 0, $end).'...';
                                        return $shorted;
                                    }

                                }

                                $count = 0;
                                while($resultreview=mysqli_fetch_assoc($result)){?>
                                    <?php
                                    $count++;
                                        $status = $resultreview["status"];

                                        switch ($status) {
                                            case 1:
                                                $status1 = "Chờ duyệt";
                                                $color = "event-wait";
                                                break;
                                            case 2:
                                                $status1 = "Đã từ chối";
                                                $color = "event-reject";
                                                break;
                                            case 3:
                                                $status1 = "Đã duyệt";
                                                $color = "event-accept";
                                                break;
                                        }
                                    ?>
                                    <tr>
                                       <td><?php echo $count ?></td>
                                      <td title="<?php echo htmlspecialchars($resultreview["title"]) ?>"><?php echo shortTitle($resultreview["title"]) ?></td>
                                       <td><?php echo date ("H:i - d/m/Y", strtotime($resultreview["start_date"])) ?></td>
                                       <td><?php echo $resultreview["host_name"] . '('. $resultreview["email"] .')' ?></td>
                                       <td><?php echo $resultreview["faculty_name"] ?></td>
                                        <td><span class="event-status <?php echo $color ?>"><?php echo $status1 ?></span></td>
                                       <td><a href='review-event-detail.php?id=<?php echo $resultreview["id"] ?>'><span class='db-done'>Chi tiết</span></a>&nbsp;&nbsp;</td>
                                     </tr>

                                <?php } ?>

                                <!-- <tr>
                                    <td>1</td>
                                    <td>Talkshow AI - Blockchain</td>
                                    <td>04/12/2019</td>
                                    <td>Hội trường Trịnh Công Sơn</td>
                                    <td><a href="review-event-detail.html"><span class="db-done">Chi tiết</span></a>&nbsp;&nbsp;
                                        
                                    </td>
                                </tr> -->
                                <!-- <tr>
                                    <td>12</td>
                                    <td>Đêm nhạc Trịnh Công Sơn</td>
                                    <td>05/12/2019</td>
                                    <td>Hội trường Trịnh Công Sơn</td>
                                    <td><a href="review-event-detail.html"><span class="db-done">Chi tiết</span></a>&nbsp;&nbsp;
                                        
                                    </td>
                                </tr>
                                <tr>
                                    <td>311</td>
                                    <td>Hội thảo khoa học thời 4.0</td>
                                    <td>11/12/2019</td>
                                    <td>Phòng 12.1</td>
                                   <td><a href="review-event-detail.html"><span class="db-done">Chi tiết</span></a>&nbsp;&nbsp;
                                        
                                    </td>
                                </tr>
                                <tr>
                                    <td>10</td>
                                    <td>Lễ trao bằng sáng chế khoa CNSH</td>
                                    <td>13/12/2019</td>
                                    <td>Phòng 7.3</td>
                                    <td><a href="review-event-detail.html"><span class="db-done">Chi tiết</span></a>&nbsp;&nbsp;
                                        
                                    </td>
                                </tr>
                                <tr>
                                    <td>12</td>
                                    <td>Ngày hội tư vấn việc làm</td>
                                    <td>24/12/2019</td>
                                    <td>Sân trường Cơ Sở 3</td>
                                    <td><a href="review-event-detail.html"><span class="db-done">Chi tiết</span></a>&nbsp;&nbsp;
                                        
                                    </td>
                                </tr>
                                <tr>
                                    <td>311</td>
                                    <td>Giới thiệu sách "Đi đu đưa đi"</td>
                                    <td>27/12/2019</td>
                                    <td>Thư viện</td>
                                    <td><a href="review-event-detail.html"><span class="db-done">Chi tiết</span></a>&nbsp;&nbsp;
                                        
                                    </td>
                                </tr> -->
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>


           <!-- Modal -->
                     
            

        </div>
    </section>

    <!--END DASHBOARD-->
    <!--====== TIPS BEFORE TRAVEL ==========-->
    
    <?php 
        include "footer.php"
    ?>
     <script type="text/javascript">
    $(document).ready( function (){
        $.fn.dataTable.moment('HH:mm - DD/MM/YYYY');
        $('#review-table').DataTable({
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
</script>