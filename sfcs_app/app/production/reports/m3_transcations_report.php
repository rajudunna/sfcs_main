<?php
    /* ================================================
        Report : M3 Transcations Report
        By : Chandu
        Created at : 17-09-2018
        Updated at : 21-12-2018
        Input : date and transcation status
        Output : 
                -->Display the report with following field: Style, Schedule, Color, Size, Mo Number, Operation Code, Workstation Id, Quantity
                -->Download Excel 
        update v0.1: query changes and new fields added
        update v0.2: changes based on 1048
        update v0.3: add Module Number, Rejection Reason based on 1270
        update v0.4: added api type column based on 1298
    ================================================== */
    include($_SERVER['DOCUMENT_ROOT'].'/template/dbconf.php');
    if(!isset($_GET['excel'])){
        echo "<script>
            function redirectf(){
                var tdate = $('#tdate').val();
                var fdate = $('#fdate').val(); 
                var schedule = $('#schedule').val();
                var ts = $('#ts').val();
                if((tdate!='' && fdate!='') || schedule!=''){
                    window.open('".base64_decode($_GET['r']) ."?tdate='+tdate+'&ts='+ts+'&excel=true&fdate='+fdate+'&schedule='+schedule, '_blank');
                }else{
                    swal('please select dates or schedule.');
                }
            }
        </script>";
?>
    <style type="text/css">
        table, th, td {
            text-align: center;
        }
    </style>
    <script language="javascript" type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/TableFilter_EN/actb.js',3,'R'); ?>"></script>
    <script language="javascript" type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/TableFilter_EN/tablefilter.js',3,'R'); ?>"></script>
    <div class='panel panel-primary'>
        <div class='panel-heading'>
            <h3 class='panel-title'>M3 Transactions Report</h3>
        </div>
        <div class='panel-body'>
        <div class='row'>
            <form class='col-sm-11'>
                <input type='hidden' name='r' value='<?= $_GET['r'] ?>'>
                <div class='col-sm-12'>
                    <div class='col-sm-2'>
                        <label>Schedule</label><br/>
                        <input class='form-control' type='text' id='schedule' name='schedule' value="<?= $_GET['schedule'] ?>"/>
                    </div>
                    <div class="form-group col-sm-3">
                        <label>From Date</label><br/>
                        <input data-toggle='datepicker' placeholder="YYYY-MM-DD" type="text" class="form-control" id='fdate' name='fdate' value="<?= $_GET['fdate'] ?? '' ?>" required>
                    </div>
                    <div class="form-group col-sm-3">
                        <label>To Date</label><br/>
                        <input data-toggle='datepicker' placeholder="YYYY-MM-DD" type="text" class="form-control" id='tdate' name='tdate' value="<?= $_GET['tdate'] ?? '' ?>" required>
                    </div>
                    <?php
                        $sql="SELECT DISTINCT `response_status` as response_status FROM bai_pro3.m3_transactions WHERE response_status !=''";	
                        $sql_result=mysqli_query($link_ui, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
                    ?>
                    <div class="form-group col-sm-2">
                        <label>Transcation Status</label><br/>
                        <select class="form-control" name='ts' id='ts'>
                            <option value=''>All</option>
                            <?php
                            while($sql_row=mysqli_fetch_array($sql_result))
                            {
                                if($sql_row['response_status'] == $_GET['ts'])
                                {
                                    echo "<option value=\"".$sql_row['response_status']."\" selected>".$sql_row['response_status']."</option>";
                                }
                                else
                                {
                                    echo "<option value=\"".$sql_row['response_status']."\">".$sql_row['response_status']."</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class='col-sm-1'>
                        <br/>
                        <button type="submit" class="btn btn-success"><i class="fas fa-search"></i> Filter</button>
                    </div>
                    <div class='col-sm-1'>
                        <br/>
                        <a href="index.php?r=<?= $_GET['r'] ?>" class="btn btn-warning"><i class="fas fa-times"></i> Clear</a>
                    </div>
                </div>
            </form>
            <div class='col-sm-1'><br/><button id='excel' onclick='redirectf()' class="btn btn-primary"><i class="fas fa-download"></i> CSV</button></div>
            </div>
<?php }
    if(isset($_GET['tdate'])){
        if(($_GET['tdate'] && $_GET['fdate']) || $_GET['schedule']){
            $resp_stat[] = $_GET['ts'] ? 'response_status="'.$_GET["ts"].'"' : '';
            $resp_stat[] = $_GET['schedule'] ? 'schedule="'.$_GET["schedule"].'"' : '';
            $resp_stat[] = ($_GET['tdate'] && $_GET['fdate']) ? 'DATE(m3_transactions.date_time) between  "'.$_GET["fdate"].'" and "'.$_GET["tdate"].'"' : '';
            $ar_nw = array_filter($resp_stat);
            $qry_m3_trans = "SELECT style,schedule,color,size,m3_transactions.date_time as dt,m3_transactions.mo_no,op_code,quantity,response_status,m3_transactions.id,m3_transactions.log_user,m3_transactions.ref_no,m3_transactions.reason,m3_transactions.module_no,m3_transactions.api_type,m3_transactions.workstation_id,m3_trail_count,m3_ops_code
            FROM bai_pro3.`m3_transactions`  
            LEFT JOIN bai_pro3.`mo_details` ON m3_transactions.mo_no=mo_details.mo_no WHERE ".implode(' and ',$ar_nw);
            $result_m3_trans = mysqli_query($link_ui, $qry_m3_trans);
            $ary_res = mysqli_fetch_all($result_m3_trans,MYSQLI_ASSOC);
            if(count($ary_res)>0){
                if(isset($_GET['excel']) && $_GET['excel']){
                    header("Content-Type: application/xls");
                    header("Content-Disposition: attachment; filename= M3 Transcation Report.xls ");
                }else{
                    echo "<div class='table-responsive' style='height:500px;overflow-y: scroll;'>";
                }
?>
                <br/>
                <table class="<?= $_GET['excel'] ?? "table table-bordered" ?>" id='table2'>
                    <thead><tr class="info"><th>ID</th><th>Date</th><th>Style</th><th>Schedule</th><th>Color</th><th>Size</th><th>Mo Number</th><th>Job Number</th><th>Module</th><th>SFCS Operation Code</th><th>M3 Operation Code</th><th>Operation Name</th><th>Workstation Id</th><th>Rejection Reason</th><th>User</th><th>Quantity</th><th>Status</th><th>API Type</th>
                    <th>Failed Count</th></tr>
                    </thead>
                    
<?php
                $i=1;
                foreach($ary_res as $res){
                    $get_op_name = mysqli_fetch_array(mysqli_query($link_ui, "SELECT * FROM brandix_bts.`tbl_orders_ops_ref` WHERE operation_code='".$res['op_code']."'"));
                    $reason = $res['response_status'];
                    
                    if ($res['api_type'] == 'fg') {
                        $api_type = '<span class="badge progress-bar-warning">FG</span>';
                    } else if ($res['api_type'] == 'opn') {
                        $api_type = '<span class="badge progress-bar-info">Operation</span>';
                    } else {
                        $api_type = '<span class="badge progress-bar-danger">No API Type Available for this Record</span>';
                    }
                    
                    if($reason=='fail'){
                        $ndr = mysqli_fetch_array(mysqli_query($link_ui, "SELECT * FROM brandix_bts.`transactions_log` WHERE transaction_id=".$res['id']." order by sno desc limit 1"))['response_message'] ?? 'fail with no reason.';
                        $reason = '<label class="label label-danger">'.$ndr."</label>";
                    }else{
                        $reason = "<label class='label label-success'>".$reason."</label>";
                    }
                    $job = mysqli_fetch_array(mysqli_query($link_ui, "SELECT distinct `bundle_creation_data`.input_job_no FROM bai_pro3.`mo_operation_quantites` LEFT JOIN brandix_bts.`bundle_creation_data` ON mo_operation_quantites.ref_no=bundle_creation_data.bundle_number AND mo_operation_quantites.op_code=bundle_creation_data.operation_id WHERE mo_operation_quantites.id=".$res['ref_no']." and mo_operation_quantites.op_code=".$res['op_code']));

?>
                    <tr>
                        <td><?= $res['id'] ?></td>
                        <td><?= $res['dt'] ?></td>
                        <td><?= $res['style'] ?></td>
                        <td><?= $res['schedule'] ?></td>
                        <td><?= $res['color'] ?></td>
                        <td><?= $res['size'] ?></td>
                        <td><?= $res['mo_no'] ?></td>
                        <td><?= $job['input_job_no'] ?></td>
                        <td><?= $res['module_no'] ?></td>
                        <td><?= $res['op_code'] ?></td>
					    <td><?= $res['m3_ops_code'] ?></td>
                        <td><?= $get_op_name['operation_name'] ?></td>
                        <td><?= $res['workstation_id'] ?></td>
                        <td><?= $res['reason'] ?></td>
                        <td><?= $res['log_user'] ?></td>
                        <td><?= $res['quantity'] ?></td>
                        <td><?= $reason ?></td>
                        <td><?= $api_type ?></td>
                        <td><?= $res['m3_trail_count'] ?></td>
                    </tr>
<?php           }      ?>
                    
                </table>
<?php
            }else{
                echo (isset($_GET['excel']) && $_GET['excel']) ? "<script>alert('No Data Found.');</script>" : "<div class='alert alert-warning'><i class='fas fa-exclamation-triangle'></i> No Data Found.</div>";
            }
        }else{
            echo "<h4 class='alert alert-danger'><i class='fas fa-calendar-alt'></i> Please give proper schedule (or) From and To dates.</h4>";
        }
    }   
    if(!isset($_GET['excel'])){ ?> 
        </div>        
        </div>
    </div>
    <?php 
    echo "<script>
    var table6_Props =  {
        rows_counter: true,
        btn_reset: true,
        btn_reset_text: 'Clear',
        loader: true,
        loader_text: 'Filtering data...'
    };
setFilterGrid( 'table2',table6_Props );
$('#reset_table2').addClass('btn btn-warning');
$('#reset_table2').addClass('btn btn-warning btn-xs');
    </script>";
    } 
    
    ?>


