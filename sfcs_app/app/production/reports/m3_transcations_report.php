
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
	$plantcode=$_SESSION['plantCode'];
	$username=$_SESSION['userName'];	
    include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config_ajax.php');
    include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/enums.php');
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
                    <div class="form-group col-sm-2">
                        <label>Transcation Status</label><br/>
                        <select class="form-control" name='ts' id='ts'>
                            <option value=''>All</option>
                            <option value=<?=M3TransStatusEnum::PASS?> <?= $_GET['ts']== M3TransStatusEnum::PASS? 'selected' : '' ?>>Pass</option>
                            <option value=<?=M3TransStatusEnum::FAIL?> <?= $_GET['ts']== M3TransStatusEnum::FAIL ? 'selected' : '' ?>>Fail</option>
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
            $resp_stat[] = $_GET['ts'] ? 'm3_transaction.status="'.$_GET["ts"].'"' : '';
            $resp_stat[] = ($_GET['tdate'] && $_GET['fdate']) ? 'm3_transaction.created_at between  "'.$_GET["fdate"].' 00:00:00" and "'.$_GET["tdate"].' 23:59:59"' : '';            
            $schedule_filter = $_GET['schedule'] ? 'transaction_log.schedule="'.$_GET["schedule"].'"' : '';
            $ar_nw = array_filter($resp_stat); 
            $result_arry = [];
            
            $qry_m3_trans = "SELECT m3_transaction.created_at,m3_transaction.mo_number,
            m3_transaction.ext_operation,m3_transaction.quantity,m3_transaction.status,m3_transaction.m3_transaction_id,m3_transaction.m3_fail_trans_id,m3_transaction.created_user,m3_transaction.reason_code,m3_transaction.workstation_ext_code,m3_transaction.api_type,m3_transaction.api_fail_count
            FROM $pts.`m3_transaction` WHERE ".implode(' and ',$ar_nw);
            $result_m3_trans = mysqli_query($link, $qry_m3_trans);
            $ary_res = mysqli_fetch_all($result_m3_trans,MYSQLI_ASSOC);
            if(count($ary_res)>0){
                foreach($ary_res as $res){
                    $qry_fg_m3_trans = "SELECT fg_m3_transaction.operation,fg_m3_transaction.workstation_id,fg_m3_transaction.job_ref, fg_m3_transaction.sub_po FROM $pts.`fg_m3_transaction` WHERE m3_transaction_id ='".$res['m3_transaction_id']."' limit 0,1";
                    $result_fg_m3_trans = mysqli_query($link, $qry_fg_m3_trans);
                    $ary__fg_m3_res = mysqli_fetch_assoc($result_fg_m3_trans);
                    $sch_filter = '';
                    if($_GET['schedule']) {
                        $sch_filter = 'transaction_log.schedule="'.$_GET["schedule"].'" and sub_po ="'.$ary__fg_m3_res['sub_po'].'"';
                    } else {
                        $sch_filter = 'sub_po ="'.$ary__fg_m3_res['sub_po'].'"';
                    }
                    $qry_trans_log = "SELECT transaction_log.style,transaction_log.schedule,transaction_log.color,transaction_log.size FROM $pts.`transaction_log` WHERE $sch_filter limit 0,1";
                    $result_trans_log = mysqli_query($link, $qry_trans_log);
                    $ary__trans_res = mysqli_fetch_assoc($result_trans_log);  
                    if($ary__trans_res) {
                        $output_arry = ['m3_transaction_id' => $res['m3_transaction_id'],
                            'dt' => date("Y-m-d H:i:s", strtotime($res['created_at'])),
                            'mo_number' => $res['mo_number'],
                            'ext_operation' => $res['ext_operation'],
                            'quantity' => $res['quantity'],
                            'status' => $res['status'],
                            'm3_fail_trans_id' => $res['m3_fail_trans_id'],
                            'created_user' => $res['created_user'],
                            'reason_code' => $res['reason_code'],
                            'reason_code' => $res['reason_code'],
                            'workstation_ext_code' => $res['workstation_ext_code'],
                            'api_type' => $res['api_type'],
                            'api_fail_count' => $res['api_fail_count'],
                            'operation' => $ary__fg_m3_res['operation'],
                            'workstation_id' => $ary__fg_m3_res['workstation_id'],
                            'job_ref' => $ary__fg_m3_res['job_ref'],
                            'style' => $ary__trans_res['style'],
                            'schedule' => $ary__trans_res['schedule'],
                            'color' => $ary__trans_res['color'],
                            'size' => $ary__trans_res['size']
                        ];
                        array_push($result_arry,$output_arry);     
                    }               
                }
            } else {
                echo (isset($_GET['excel']) && $_GET['excel']) ? "<script>alert('No Data Found.');</script>" : "<div class='alert alert-warning'><i class='fas fa-exclamation-triangle'></i> No Data Found.</div>";
            }
            if(count($result_arry)>0){
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
                foreach($result_arry as $res){
                    $reason ='';
                    $get_op_name = mysqli_fetch_array(mysqli_query($link, "SELECT operation_name FROM $mdm.`operations` WHERE operation_code=".$res['operation']));
                    $get_module_name = mysqli_fetch_array(mysqli_query($link, "SELECT workstation_code FROM $pms.`workstation` WHERE workstation_id='".$res['workstation_id']."'"));
                    $reason = $res['status'];                 
                    if ($res['api_type'] == ApiTypeEnum::FG) {
                        $api_type = '<span class="badge progress-bar-warning">FG</span>';
                    } else if ($res['api_type'] == ApiTypeEnum::OPN) {
                        $api_type = '<span class="badge progress-bar-info">Operation</span>';
                    } else {
                        $api_type = '<span class="badge progress-bar-danger">No API Type Available for this Record</span>';
                    }
                    
                    if($reason==M3TransStatusEnum::FAIL){
                        $ndr = mysqli_fetch_array(mysqli_query($link, "SELECT response_message FROM $pts.`m3_fail_transaction` WHERE plant_code='$plantcode' and m3_fail_trans_id='".$res['m3_fail_trans_id']."'"))['response_message'] ?? 'fail with no reason.';
                        $reason = '<label class="label label-danger">'.$ndr."</label>";
                    }else{
                        $reason = "<label class='label label-success'>".$reason."</label>";
                    }

?>
                    <tr>
                        <td><?= $i++?></td>
                        <td><?= $res['dt'] ?></td>
                        <td><?= $res['style'] ?></td>
                        <td><?= $res['schedule'] ?></td>
                        <td><?= $res['color'] ?></td>
                        <td><?= $res['size'] ?></td>
                        <td><?= $res['mo_number'] ?></td>
                        <td><?= $res['job_ref'] ?></td>
                        <td><?= $get_module_name['workstation_code'] ?></td>
                        <td><?= $res['operation'] ?></td>
					    <td><?= $res['ext_operation'] ?></td>
                        <td><?= $get_op_name['operation_name'] ?></td>
                        <td><?= $res['workstation_ext_code'] ?></td>
                        <td><?= $res['status'] ?></td>
                        <td><?= $res['created_user'] ?></td>
                        <td><?= $res['quantity'] ?></td>
                        <td><?= $reason ?></td>
                        <td><?= $api_type ?></td>
                        <td><?= $res['api_fail_count'] ?></td>
                    </tr>
<?php          }      ?>
                    
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
