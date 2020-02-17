<?php
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/functions.php',4,'R'));

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
                echo "<div class='col-sm-2'><label>Module<span style='color:red;'> *</span></label>
                <select class='form-control' name=\"module\" id=\"module\" onchange=\"secondbox();\" id='module' required>";
                $sql="select distinct ims_mod_no from $bai_pro3.ims_log union select distinct ims_mod_no from $bai_pro3.ims_log_backup";	
                $sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
                $sql_num_check=mysqli_num_rows($sql_result);
                echo "<option value='' selected disabled>Select Module</option>";
                while($sql_row=mysqli_fetch_array($sql_result))
                {
                    if(str_replace(" ","",$sql_row['ims_mod_no'])==str_replace(" ","",$module)){
                            echo "<option value=\"".$sql_row['ims_mod_no']."\" selected>".$sql_row['ims_mod_no']."</option>";
                        }
                    else{
                        echo "<option value=\"".$sql_row['ims_mod_no']."\">".$sql_row['ims_mod_no']."</option>";
                    }
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

    $application2='IPS';

    $scanning_query12="select operation_code from $brandix_bts.tbl_ims_ops where appilication='$application2'";
    $scanning_result12=mysqli_query($link, $scanning_query12)or exit("scanning_error".mysqli_error($GLOBALS["___mysqli_ston"]));
    while($sql_row123=mysqli_fetch_array($scanning_result12))
    {
        $operation_in_code=$sql_row123['operation_code'];
    }
    $application='IMS_OUT';

    $scanning_query="select operation_code from $brandix_bts.tbl_ims_ops where appilication='$application'";
    $scanning_result=mysqli_query($link, $scanning_query)or exit("scanning_error".mysqli_error($GLOBALS["___mysqli_ston"]));
    while($sql_row=mysqli_fetch_array($scanning_result))
    {
      $operation_out_code=$sql_row['operation_code'];
    }

    if($module){
        $get_module_data = "SELECT * FROM $bai_pro3.`ims_log` where ims_mod_no = '$module' and ims_status<>'DONE' GROUP BY input_job_rand_no_ref UNION ALL SELECT * FROM $bai_pro3.`ims_log_backup` where ims_mod_no = '$module' and ims_status<>'DONE' GROUP BY input_job_rand_no_ref ORDER BY input_job_rand_no_ref,ims_date ";
        $get_module_data_result=mysqli_query($link, $get_module_data) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
        $norows = mysqli_num_rows($get_module_data_result);

        $sno = 1;

        if ($norows > 0) {
            ?>
            <div class='col-sm-12' style='max-height:600px;overflow-y:scroll'>
            <form name='list' method='post' action="<?php echo getFullURLLevel($_GET['r'],'sewing_job_list.php','0','N'); ?>">
            <?php
            // echo "<div class='pull-right'><input type='hidden' name='module' value=$module>
            // <input type='submit' class='btn btn-success btn-sm' name='Save' value='Save' >
            // </div>";
            echo "<br/><table id='deactive_sewing_job' class='table table-responsive'>";
            echo "<thead><tr><th>S.<br/>No</th><th>Input Date</th><th>Style</th><th>Schedule</th><th>Color</th><th>Module</th><th>Sewing<br/>Job No</th><th>Job Qty</th><th>Output</th><th>Rejected</th><th>WIP</th><th>Remarks</th><th width='20%'>Status</th></tr></thead><tbody>";
            while($row=mysqli_fetch_array($get_module_data_result)) {
                $ims_date = $row["ims_date"];
                $style = $row['ims_style'];
                $schedule = $row['ims_schedule'];
                $color = $row['ims_color'];
                $input_job_no = $row['input_job_no_ref'];
                $ims_remarks = $row['ims_remarks'];
                $ims_size = $row['ims_size'];
                $short_shipment_status = $row['short_shipment_status'];
                $sizes_explode=array();
                $sizes_explode=explode(",",$ims_size);
                // echo $sizes_explode;
                $sizes_implode1="'".implode("','",$sizes_explode)."'"; 
                // echo  $sizes_implode1;

                // $temp = strchr($sizes_implode1,"a_");
                // echo $temp;

                // $input_qty=0;
                // $output_qty=0;
                $ip_op_qty="SELECT sum(if(operation_id = $operation_in_code,recevied_qty,0)) as input,sum(if(operation_id = $operation_out_code,recevied_qty,0)) as output,SUM(IF(operation_id = $operation_out_code,rejected_qty,0)) AS rejected FROM $brandix_bts.bundle_creation_data WHERE input_job_no = $input_job_no and schedule=$schedule";
                // echo $ip_op_qty;
                $ip_op_qty_res=mysqli_query($link, $ip_op_qty) or exit("Sql Error12".mysqli_error($GLOBALS["___mysqli_ston"]));
                while($sql_row_ip_op=mysqli_fetch_array($ip_op_qty_res))
                {
                    $input_qty = $sql_row_ip_op['input'];
                    $output_qty = $sql_row_ip_op['output'];
                    $rejected_qty = $sql_row_ip_op['rejected'];
                    $wip=$input_qty-$output_qty;
                }
                // $ims_tool="SELECT SUM(ims_qty) AS Input,SUM(ims_pro_qty) AS Output from bai_pro3.ims_log where  input_job_no_ref='$input_job_no' and ims_mod_no='$module' ";
                // $sql_result1=mysqli_query($link, $ims_tool) or exit("Sql Errorims_tool".mysqli_error($GLOBALS["___mysqli_ston"]));
                // while($sql_row1=mysqli_fetch_array($sql_result1))
                // {
                // $input_qty1=$sql_row1['Input'];      // input qty
                // $output_qty1=$sql_row1['Output'];      // output qty
                // }


                // $ims_tool1="SELECT SUM(ims_qty) AS Input,SUM(ims_pro_qty) AS Output from bai_pro3.ims_log_backup where  input_job_no_ref='$input_job_no' and ims_mod_no='$module' ";
                // $sql_result2=mysqli_query($link, $ims_tool1) or exit("Sql Errorims_tool".mysqli_error($GLOBALS["___mysqli_ston"]));
                // while($sql_row2=mysqli_fetch_array($sql_result2))
                // {
                // $input_qty2=$sql_row2['Input'];      // input qty
                // $output_qty2=$sql_row2['Output'];      // output qty
                // }
				
                // $input_qty=$input_qty1+$input_qty2;      // input qty
                // $output_qty=$output_qty1+$output_qty2;
                // $wip=$input_qty-$output_qty;
                // $rejected_qty=0;
                // $rejected_qry="select COALESCE(SUM(IF(qms_tran_type=3,qms_qty,0)),0) AS rejected from $bai_pro3.bai_qms_db where  qms_schedule='".$schedule."' and qms_color in (".$color.") and qms_size in ($sizes_implode1) and input_job_no='".$input_job_no."' and qms_style='".$style."' and operation_id=$operation_in_code and SUBSTRING_INDEX(remarks,'-',1) = '$module' and qms_remarks in ('".$ims_remarks."')";
                // // echo $rejected_qry;
                // $rejected_qry_result =mysqli_query($link, $rejected_qry) ;
                // while($sql_row33=mysqli_fetch_array($rejected_qry_result))
                // {
                //     $rejected_qty=$sql_row33['rejected']; 
                // } 

               
                $qry="select prefix from $brandix_bts.tbl_sewing_job_prefix where prefix_name='$ims_remarks'";
                $res=mysqli_query($link, $qry)or exit("scanning_error".mysqli_error($GLOBALS["___mysqli_ston"]));
                while($sql_row123=mysqli_fetch_array($res))
                {
                    $sewing_prefi=$sql_row123['prefix'];
                }

                $display = $sewing_prefi.leading_zeros($input_job_no,3);

                echo "<tr>";
                echo "<input type='hidden' name='ims_date[]' value=$ims_date>";
                echo "<input type='hidden' name='style[]' value=$style>";
                echo "<input type='hidden' name='schedule[]' value=$schedule>";
                echo "<input type='hidden' name='color[]' value=$color>";
                echo "<input type='hidden' name='input_job_no[]' value=$input_job_no>";
                echo "<input type='hidden' name='input_qty[]' value=$input_qty>";
                echo "<input type='hidden' name='output_qty[]' value=$output_qty>";
                echo "<input type='hidden' name='rejected_qty[]' value=$rejected_qty>";
                echo "<input type='hidden' name='ims_remarks[]' value=$ims_remarks>";
                echo "<input type='hidden' name='wip[]' value=$wip>";
                echo "<input type='hidden' name='sizes_implode1[]' value=$sizes_implode1>";
                echo "<td>".$sno++."</td><td>".$ims_date." </td><td>".$style."</td><td>".$schedule."</td><td>".$color."</td><td>".$module."</td><td>".leading_zeros($display,1)."</td><td>".$input_qty."</td><td>".$output_qty."</td><td>".$rejected_qty."</td><td>".$wip."</td><td>".$ims_remarks."</td>";

                $short_shipment_query = "SELECT * FROM $bai_pro3.`short_shipment_job_track` where schedule = '$schedule' and (remove_type in ('1','2'))";
                $short_shipment_query_result=mysqli_query($link, $short_shipment_query) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
                while($row=mysqli_fetch_array($short_shipment_query_result))
                {
                    $remove_type = $row['remove_type'];
                    
                }

                $job_deacive = "SELECT * FROM $bai_pro3.`job_deactive_log` where schedule = '$schedule' and input_job_no='$input_job_no' and remove_type = '3'";
                $job_deacive_result=mysqli_query($link, $job_deacive) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
                while($row=mysqli_fetch_array($job_deacive_result))
                {
                    $remove_type = $row['remove_type'];
                }
                if($remove_type == '1'){
                    $edit_url = getFullURLLevel($_GET['r'],'remove_shortshipment_jobs/remove_jobs.php',1,'N');
                    echo "<td>Short Shipment Done Temporarly <br/><span><a href='$edit_url&schedule=$schedule' class='btn btn-warning btn-xs editor_edit glyphicon glyphicon-retweet' onclick='return confirm_reverse(event,this);'> REVERSE </a></span></td>";
                }
                else if($remove_type == '2'){
                    echo "<td>Short Shipment Done Permanently<br/><label class='label label-sm label-danger'>Can't Reverse</label></td>"; 
                }
                // else if($remove_type == '3'){
                //     $reverse_url = getFullURL($_GET['r'],'sewing_job_list.php','N');
                //     echo "<td>Sewing Job Deactivated <br/><span><a href='$reverse_url&schedule=$schedule&input_job_no=$input_job_no' class='btn btn-warning btn-xs editor_edit glyphicon glyphicon-retweet' onclick='return confirm_reverse(event,this);'> REVERSE </a></span></td>";
                //     $remove_type=0;
                // }
                 else {
                    // echo $short_shipment_status;
                    if($short_shipment_status==3){
                        $selected1 = 'selected';
                    } else {
                        $selected = 'selected';
                    }

                    echo '<td><select id="remove_type" class="form-control" data-role="select" selected="selected" name="remove_type[]"  data-parsley-errors-container="#errId3" required><option value="0" '.$selected.'>Active</option><option value="3" '.$selected1.'>Hold</option></select></td>';
                    $selected1='';
                    $selected='';
                }
                unset($remove_type);
                echo "</tr>";

            }
            echo "</tbody>";
            echo "<thead><tr><td colspan='12' align='right'></td><td>
            <input type='submit' class='btn btn-success btn-sm pull-right' name='Save' value='Save' ></td>
            </tr></thead>";
            echo "</table></form>";
        } else {
            echo "<br/><table class='table table-responsive'><tr class='label label-sm label-danger'><td><center>No Data Found</center></td></tr></table>";
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