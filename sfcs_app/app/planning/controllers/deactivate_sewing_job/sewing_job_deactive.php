<?php
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/functions.php',4,'R'));
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/functions_dashboard.php',4,'R'));
include($_SERVER['DOCUMENT_ROOT']."/sfcs_app/common/config/functions_v2.php");
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/enums.php',4,'R')); 
$plant_code = $_SESSION['plantCode'];
$username = $_SESSION['userName'];

$mail_status=0;
$username = getrbac_user()['uname'];
if($_GET['module']){
    $module = $_GET['module'];
} else if($_POST['module']) {
    $module = $_POST['module'];
}
?>

<div class = "panel panel-primary">
<div class = "panel-heading">Deactivate Sewing Jobs</div>
<div class = "panel-body">
    <form name="main" action="<?php echo getFullURLLevel($_GET['r'],'sewing_job_deactive.php','0','N'); ?>" method="post">
        <div class="row">
            <?php
            $department='SEWING';
            /** Getting work stations based on department wise
            * @param:department,plantcode
            * @return:workstation
            **/
            $result_worksation_id=getWorkstations($department,$plant_code);
            $workstations=$result_worksation_id['workstation'];


            echo "<div class='col-sm-2'><label>Module<span style='color:red;'> *</span></label>
            <select class='form-control' name=\"module\" id=\"module\" onchange=\"secondbox();\" id='module' required>";
            foreach($workstations as $work_id=>$work_des)
            {
                echo "<option value='".$work_id."'>".$work_des."</option>";
            }
            echo "</select>
            </div>";
            ?>
            <div class="col-md-2"><br/>
                <input class="btn btn-primary" type="submit" value="Submit" name="submit">
            </div>
        </div>
    </form>


<?php
if(isset($_POST['submit']) || $module)
{


    if($module){
		$tasktype=TaskTypeEnum::SEWINGJOB;
        $task_header_id=array();
        $get_task_header_id="SELECT task_header_id,task_ref FROM $tms.task_header WHERE resource_id='$module' AND task_status='PLANNED' AND task_type='$tasktype' AND plant_code='$plant_code'";
        $task_header_id_result=mysqli_query($link_new, $get_task_header_id) or exit("Sql Error at get_task_header_id".mysqli_error($GLOBALS["___mysqli_ston"]));
        while($task_header_id_row=mysqli_fetch_array($task_header_id_result))
        {
           $task_header_id[] = $task_header_id_row['task_header_id'];
        }
        $norows = mysqli_num_rows($task_header_id_result);

        $sno = 1;

        if ($norows > 0) {
            ?>
            <div class='col-sm-12' style='max-height:600px;overflow-y:scroll'>
            <form name='list' method='post' action="<?php echo getFullURLLevel($_GET['r'],'sewing_job_list.php','0','N'); ?>">
            <?php
            echo "<br/><table id='deactive_sewing_job' class='table table-responsive'>";
            echo "<thead><tr><th>S.<br/>No</th><th>Input Date</th><th>Style</th><th>Schedule</th><th>Color</th><th>Po Number</th><th>Module</th><th>Sewing<br/>Job No</th><th>Job Qty</th><th width='20%'>Status</th></tr></thead><tbody>";
            //<th>Output</th><th>Rejected</th><th>WIP</th><th>Remarks</th>
            //To get taskrefrence from task_jobs based on resourceid 
            $task_job_reference=array(); 
            $get_refrence_no="SELECT task_job_reference,created_at FROM $tms.task_jobs WHERE task_header_id IN('".implode("','" , $task_header_id)."') AND plant_code='$plant_code' AND task_type='$tasktype'";
            $get_refrence_no_result=mysqli_query($link_new, $get_refrence_no) or exit("Sql Error at refrence_no".mysqli_error($GLOBALS["___mysqli_ston"]));
            while($refrence_no_row=mysqli_fetch_array($get_refrence_no_result))
            {
              $task_job_reference[] = $refrence_no_row['task_job_reference'];
            }
            //Qry to get sewing jobs from jm_jobs_header
            $job_group_type=TaskTypeEnum::PLANNEDSEWINGJOB;
            $job_number=array();
            $ponumber=array();
            $masterponumber=array();
            $qry_toget_sewing_jobs="SELECT job_number,jm_jg_header_id,po_number,master_po_number FROM $pps.jm_jg_header WHERE job_group_type='$job_group_type' AND plant_code='$plant_code' AND jm_jg_header_id IN('".implode("','" , $task_job_reference)."')";
            $toget_sewing_jobs_result=mysqli_query($link_new, $qry_toget_taskrefrence) or exit("Sql Error at toget_task_job".mysqli_error($GLOBALS["___mysqli_ston"]));
            $toget_sewing_jobs_num=mysqli_num_rows($toget_sewing_jobs_result);
            if($toget_sewing_jobs_num>0){
                while($toget_sewing_jobs_row=mysqli_fetch_array($toget_sewing_jobs_result))
                {
                  $job_number[$toget_sewing_jobs_row['jm_jg_header_id']]=$toget_sewing_jobs_row['job_number'];
                  $ponumber[$toget_sewing_jobs_row['jm_jg_header_id']]=$toget_sewing_jobs_row['po_number'];
                  $masterponumber[$toget_sewing_jobs_row['jm_jg_header_id']]=$toget_sewing_jobs_row['master_po_number'];
                }
            }
                foreach($job_number as $key=>$value)
                {

                  //get style,color
                  $qry_mp_color_detail="SELECT style,color FROM $pps.mp_color_detail WHERE plant_code='$plantcode' and master_po_number='$masterponumber[$value]'";
                  $mp_color_detail_result=mysqli_query($link_new, $qry_mp_color_detail) or exit("Sql Error at mp_color_detail".mysqli_error($GLOBALS["___mysqli_ston"]));
                  while($mp_color_detail_row=mysqli_fetch_array($mp_color_detail_result))
                  {
                    $style=$mp_color_detail_row['style'];
                    $color=$$mp_color_detail_row['color'];
                  }
                  //To get schedules
                  $result_bulk_schedules=getBulkSchedules($style,$plant_code);
                  $bulk_schedule=$result_bulk_schedules['bulk_schedule'];
                  $schedules = implode(",",$bulk_schedule);
                  
                  //to get dockets
                  $result_dockets=getDocketDetails($ponumber[$value],$plant_code,0);
                  $docket_numbers=$result_dockets['docket_number'];
                  $dockets=implode(",",$docket_numbers);
                  //to get qty from jm job lines
                  $toget_qty_qry="SELECT sum(quantity) as qty from $pps.jm_job_bundles where jm_jg_header_id ='$key' and plant_code='$plant_code'";
                  $toget_qty_qry_result=mysqli_query($link_new, $toget_qty_qry) or exit("Sql Error at toget_style_sch".mysqli_error($GLOBALS["___mysqli_ston"]));
                  $toget_qty=mysqli_num_rows($toget_qty_qry_result);
                  if($toget_qty>0){
                     while($toget_qty_det=mysqli_fetch_array($toget_qty_qry_result))
                     {
                      $sew_qty = $toget_qty_det['qty'];
                     }
                  }
                  //get_module
                  $qry_get_module="SELECT resource_id,date(planned_date_time) as planned_date FROM $tms.task_header LEFT JOIN $tms.task_jobs ON task_header.task_header_id=task_jobs.task_header_id WHERE task_job_reference='$key'";
                  $get_module_result=mysqli_query($link_new, $qry_get_module) or exit("Sql Error at qry_get_module".mysqli_error($GLOBALS["___mysqli_ston"]));
                  while($get_module_row=mysqli_fetch_array($get_module_result))
                  {
                    $module = $get_module_row['resource_id'];
                    $planned_date = $get_module_row['planned_date'];
                  }
                  $jg_header_id=$job_number[$key];
                  $job_number=$job_number[$value];
                  $po_number=$ponumber[$value];
                  // $qry="select prefix from $pms.tbl_sewing_job_prefix where prefix_name='$ims_remarks' and plant_code='$plant_code'";
                  // $res=mysqli_query($link, $qry)or exit("scanning_error".mysqli_error($GLOBALS["___mysqli_ston"]));
                  // while($sql_row123=mysqli_fetch_array($res))
                  // {
                  //   $sewing_prefi=$sql_row123['prefix'];
                  // }
                  $input_job_no=$job_number[$value];
                  $jm_jg_header_id=$key;
                   // $display = $sewing_prefi.leading_zeros($input_job_no,3);

                    echo "<tr>";
                    echo "<input type='hidden' name='planned_date[]' value=$planned_date>";
                    echo "<input type='hidden' name='style[]' value=$style>";
                    echo "<input type='hidden' name='schedule[]' value=$schedules>";
                    echo "<input type='hidden' name='color[]' value=$color>";
                    echo "<input type='hidden' name='po_number[]' value=$po_number>";
                    echo "<input type='hidden' name='input_job_no[]' value=$input_job_no>";
                    echo "<input type='hidden' name='jm_jg_header_id[]' value=$jm_jg_header_id>";
                    echo "<input type='hidden' name='module[]' value=$module>";
                    echo "<input type='hidden' name='input_qty[]' value=$sew_qty>";
                    // echo "<input type='hidden' name='output_qty[]' value=$output_qty>";
                    // echo "<input type='hidden' name='rejected_qty[]' value=$rejected_qty>";
                    // echo "<input type='hidden' name='ims_remarks[]' value=$ims_remarks>";
                    // echo "<input type='hidden' name='wip[]' value=$wip>";
                    // echo "<input type='hidden' name='sizes_implode1[]' value=$sizes_implode1>";
                    echo "<td>".$sno++."</td><td>".$planned_date." </td><td>".$style."</td><td>".$schedules."</td><td>".$color."</td><td>".$po_number."</td><td>".$module."</td><td>".$input_job_no."</td><td>".$sew_qty."</td>";

                    $job_deacive = "SELECT * FROM $pts.`job_deactive_log` where schedule = '$schedule' and input_job_no='$input_job_no' and plant_code='$plant_code' and remove_type = '3'";
                    $job_deacive_result=mysqli_query($link, $job_deacive) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
                    while($row=mysqli_fetch_array($job_deacive_result))
                    {
                        $remove_type = $row['remove_type'];
                    }
                    if($remove_type==3){
                        $selected1 = 'selected';
                    } else {
                        $selected = 'selected';
                    }

                    echo '<td><select id="remove_type" class="form-control" data-role="select" selected="selected" name="remove_type[]"  data-parsley-errors-container="#errId3" required><option value="0" '.$selected.'>Active</option><option value="3" '.$selected1.'>Hold</option></select></td>';
                    $selected1='';
                    $selected='';
                    unset($remove_type);
                    echo "</tr>";
                }
            } else 
            {
              echo "<br/><div class='alert alert-danger'><span>No Data Found.</span></div>";
            }

    }else {
        echo "<script>swal('Please Select Module','','error');</script>";
    }
} 

            
?>
</div>
</div>
<script>
$(document).ready(function() {
    $('#deactive_sewing_job').DataTable();
} );

function confirm_reverse(e,t)
    {
        e.preventDefault();
        var v = sweetAlert({
        title: "Are you sure to Remove?",
        icon: "warning",
        buttons: true,
        dangerMode: true,
        buttons: ["No, Cancel It!", "Yes, I am Sure!"],
        }).then(function(isConfirm){
        console.log(isConfirm);
        if (isConfirm) {
            window.location = $(t).attr('href');
            return true;
        } else {
            sweetAlert("Request Cancelled",'','error');
            return false;
        }
        });
    }

</script>
<style>
table th
{
	border: 1px solid grey;
	text-align: center;
    background-color: #003366;
	color: WHITE;
	white-space:nowrap; 
	padding-left: 5px;
	padding-right: 5px;
}
table{
	white-space:nowrap; 
	border-collapse:collapse;
	font-size:12px;
	background-color: white;
}
table tr
{
	border: 1px solid grey;
	text-align: right;
	white-space:nowrap; 
}

table td
{
	border: 1px solid grey;
	text-align: center;
	white-space:nowrap;
	color:black;
}
</style>