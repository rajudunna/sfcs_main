<?php
    /* ================================================
        Report : M3 Transcations Report
        By : Chandu
        Created at : 17-09-2018
        Updated at : 06-10-2018
        Input : date and transcation status
        Output : 
                -->Display the report with following field: Style, Schedule, Color, Size, Mo Number, Operation Code, Workstation Id, Quantity
                -->Download Excel 
        update : query changes and new fields added
    ================================================== */
    include($_SERVER['DOCUMENT_ROOT'].'/template/dbconf.php');
    if(!isset($_GET['excel'])){
        echo "<script>
            function redirectf(){
                var date = $('#tdate').val(); 
                var ts = $('#ts').val();
                if(date!=''){
                    window.open('".base64_decode($_GET['r']) ."?tdate='+date+'&ts='+ts+'&excel=true', '_blank');
                }else{
                    swal('please select date.');
                }
            }
        </script>";
?>
    <div class='panel panel-primary'>
        <div class='panel-heading'>
            <h3 class='panel-title'>M3 Transcation Report</h3>
        </div>
        <div class='panel-body'>
        <div class='row'>
            <form class='col-sm-10'>
                <input type='hidden' name='r' value='<?= $_GET['r'] ?>'>
                <div class="form-group col-sm-4">
                    <label>Date</label><br/>
                    <input data-toggle='datepicker' placeholder="YYYY-MM-DD" type="text" class="form-control" id='tdate' name='tdate' value="<?= $_GET['tdate'] ?? '' ?>" required>
                </div>
                <div class="form-group col-sm-4">
                    <label>Transcation Status</label><br/>
                    <select class="form-control" name='ts' id='ts'>
                        <option value=''>All</option>
                        <option value='pass' <?= $_GET['ts']=='pass' ? 'selected' : '' ?>>Pass</option>
                        <option value='fail' <?= $_GET['ts']=='fail' ? 'selected' : '' ?>>Fail</option>
                    </select>
                </div>
                <div class='col-sm-4'>
                <br/>
                <button type="submit" class="btn btn-success"><i class="fas fa-search"></i> Filter</button>
                <a href="index.php?r=<?= $_GET['r'] ?>" class="btn btn-warning"><i class="fas fa-times"></i> Clear</a>
                </div>
            </form>
            <div class='col-sm-2'><br/><button id='excel' onclick='redirectf()' class="btn btn-primary"><i class="fas fa-download"></i> Excel Download</button></div>
            </div>
<?php }
    if(isset($_GET['tdate'])){
        if($_GET['tdate']){
            $resp_stat = $_GET['ts'] ? 'AND response_status="'.$_GET["ts"].'"' : '';
            
            $qry_m3_trans = "SELECT *
            FROM bai_pro3.`m3_transactions`  
            LEFT JOIN bai_pro3.`mo_details` ON m3_transactions.mo_no=mo_details.mo_no WHERE DATE(m3_transactions.date_time)='".$_GET['tdate']."' $resp_stat";
            //echo $qry_m3_trans;
            $result_m3_trans = mysqli_query($link_ui, $qry_m3_trans);
            $ary_res = mysqli_fetch_all($result_m3_trans,MYSQLI_ASSOC);
            if(count($ary_res)>0){
                if(isset($_GET['excel']) && $_GET['excel']){
                    header("Content-Type: application/xls");
                    header("Content-Disposition: attachment; filename= M3 Transcation Report.xls ");
                }
?>
                <table class=<?= $_GET['excel'] ?? "table" ?>>
                    <tr><thead><th>#</th><th>Time</th><th>Style</th><th>Schedule</th><th>Color</th><th>Size</th><th>Mo Number</th><th>Operation Code</th><th>Operation Name</th><th>Workstation Id</th><th>Quantity</th><th>Status</th></thead></tr>
                    <tbody>
<?php
                $i=1;
                foreach($ary_res as $res){
                    $get_op_name = mysqli_fetch_array(mysqli_query($link_ui, "SELECT * FROM brandix_bts.`tbl_orders_ops_ref` WHERE operation_code='".$res['op_code']."'"));

?>
                    <tr>
                        <td><?= $i++ ?></td>
                        <td><?= date('H:i',strtotime($res['date_time'])) ?></td>
                        <td><?= $res['style'] ?></td>
                        <td><?= $res['schedule'] ?></td>
                        <td><?= $res['color'] ?></td>
                        <td><?= $res['size'] ?></td>
                        <td><?= $res['mo_no'] ?></td>
                        <td><?= $res['op_code'] ?></td>
                        <td><?= $get_op_name['operation_name'] ?></td>
                        <td><?= $res['workstation_id'] ?></td>
                        <td><?= $res['quantity'] ?></td>
                        <td><?= $res['response_status'] ?></td>
                    </tr>
<?php           }      ?>
                    </tbody>
                </table>
<?php
            }else{
                echo (isset($_GET['excel']) && $_GET['excel']) ? "<script>alert('No Data Found.');</script>" : "<div class='alert alert-warning'><i class='fas fa-exclamation-triangle'></i> No Data Found.</div>";
            }
        }else{
            echo "<div class='alert alert-danger'><i class='fas fa-calendar-alt'></i> Please select correct date.</div>";
        }
    }   
    if(!isset($_GET['excel'])){ ?>         
        </div>
    </div>
    <?php } ?>