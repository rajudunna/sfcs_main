<?php 
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R')); 
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/functions_v2.php',3,'R'));
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/enums.php',3,'R')); 
$plant_code=$_SESSION['plantCode'];     
    $current_week = getFullURL($_GET['r'],'current_week.html','R');
    $pre_week     = getFullURL($_GET['r'],'previous_week.html','R');
?>

<script>
var url = "<?= getFullURL($_GET['r'],'cut_to_ship2.php','N'); ?>";
function firstbox()
{
    window.location.href = url+"&style="+document.input.style.value;
}

function secondbox()
{
    window.location.href =url+"&style="+document.input.style.value+"&schedule="+document.input.schedule.value
}

function thirdbox()
{
    window.location.href =url+"&style="+document.input.style.value+"&schedule="+document.input.schedule.value+"&color="+document.input.color.value
}

function fourthbox()
{
    window.location.href =url+"&style="+document.input.style.value+"&schedule="+document.input.schedule.value+"&color="+document.input.color.value+"&mpo="+document.input.mpo.value;
}

function fifthbox()
{
    window.location.href =url+"&style="+document.test.style.value+"&schedule="+document.test.schedule.value+"&color="+document.test.color.value+"&mpo="+document.test.mpo.value+"&sub_po="+document.test.sub_po.value;
}
</script>

<div class="panel panel-primary">
<div class="panel-heading">Cut to Ship Analysis Report</div>
<div class="panel-body">
<form name="input" method="post" action="<?php getFullURL($_GET['r'],'cut_to_ship2.php','R'); ?>">
<strong><a class="btn btn-info btn-xs" href="<?php echo $current_week; ?>" target="_blank">Current Week</a></strong> | <strong> <a class="btn btn-info btn-xs"  href="<?php echo $pre_week;?>" target="_blank">Previous Week</a> </strong>

<?php
if(isset($_POST['filter2']))
{
    $get_style=$_POST['style'];
    $get_schedule=$_POST['schedule']; 
    $get_color=$_POST['color'];
    $get_mpo=$_POST['mpo'];
    $get_sub_po=$POST['sub_po'];
}
else
{
    $get_style=$_GET['style'];
    $get_schedule=$_GET['schedule']; 
    $get_color=$_GET['color'];
    $get_mpo=$_GET['mpo'];
    $get_sub_po=$_GET['sub_po'];
}
?>
<?php
    /*function to get style from getdata_mp_color_detail
    @params : $plantcode
    @returns: $style
    */

    if($plant_code!=''){
        $result_mp_color_details=getMpColorDetail($plant_code);
        $style=$result_mp_color_details['style'];
    }
    echo "<div class='row'>"; 
    echo "<div class='col-sm-3'><label>Select Style: </label><select style='min-width:100%' name=\"style\" onchange=\"firstbox();\" class='form-control' required>"; 
    echo "<option value=\"\" selected>NIL</option>";
    foreach ($style as $style_value) {
        if(str_replace(" ","",$style_value)==str_replace(" ","",$get_style)) 
        { 
            echo '<option value=\''.$style_value.'\' selected>'.$style_value.'</option>'; 
        } 
        else 
        { 
            echo '<option value=\''.$style_value.'\'>'.$style_value.'</option>'; 
        }
    } 
    echo "</select></div>";
?>

<?php

/*function to get schedule from getdata_bulk_schedules
@params : plantcode,style
@returns: schedule
*/
if($get_style!=''&& $plant_code!=''){
    $result_bulk_schedules=getBulkSchedules($get_style,$plant_code);
    $bulk_schedule=$result_bulk_schedules['bulk_schedule'];
}  
echo "<div class='col-sm-3'><label>Select Schedule: </label><select style='min-width:100%' name=\"schedule\" onchange=\"secondbox();\" class='form-control' required>";  
echo "<option value=\"\" selected>NIL</option>";
foreach ($bulk_schedule as $bulk_schedule_value) {
    if(str_replace(" ","",$bulk_schedule_value)==str_replace(" ","",$get_schedule)) 
    { 
        echo '<option value=\''.$bulk_schedule_value.'\' selected>'.$bulk_schedule_value.'</option>'; 
    } 
    else 
    { 
        echo '<option value=\''.$bulk_schedule_value.'\'>'.$bulk_schedule_value.'</option>'; 
    }
} 
echo "</select></div>";

?>

<?php
/*function to get color from get_bulk_colors
@params : plantcode,schedule
@returns: color
*/
if($get_schedule!='' && $plant_code!=''){
    $result_bulk_colors=getBulkColors($get_schedule,$plant_code);
    $bulk_color=$result_bulk_colors['color_bulk'];
}
echo "<div class='col-sm-3'><label>Select Color: </label>";  
echo "<select style='min-width:100%' name=\"color\" onchange=\"thirdbox();\" class='form-control' >
        <option value=\"NIL\" selected>NIL</option>";
            foreach ($bulk_color as $bulk_color_value) {
                if(str_replace(" ","",$bulk_color_value)==str_replace(" ","",$get_color)) 
                { 
                    echo '<option value=\''.$bulk_color_value.'\' selected>'.$bulk_color_value.'</option>'; 
                } 
                else 
                { 
                    echo '<option value=\''.$bulk_color_value.'\'>'.$bulk_color_value.'</option>'; 
                }
            } 
echo "</select></div>";
?>
<?php
    /*function to get mpo from getdata_MPOs
    @params : plantcode,schedule,color
    @returns: mpo
    */
    if($get_schedule!='' && $get_color!='' && $plant_code!=''){
        $result_bulk_MPO=getMpos($get_schedule,$get_color,$plant_code);
        $master_po_description=$result_bulk_MPO['master_po_description'];
    }
    echo "<div class='col-sm-3'><label>Select Master PO: </label>";  
    echo "<select style='min-width:100%' name=\"mpo\" onchange=\"fourthbox();\" class='form-control' >
            <option value=\"NIL\" selected>NIL</option>";
                foreach ($master_po_description as $key=>$master_po_description_val) {
                    if(str_replace(" ","",$master_po_description_val)==str_replace(" ","",$get_mpo)) 
                    { 
                        echo '<option value=\''.$master_po_description_val.'\' selected>'.$key.'</option>'; 
                    } 
                    else 
                    { 
                        echo '<option value=\''.$master_po_description_val.'\'>'.$key.'</option>'; 
                    }
                } 
    echo "</select></div>";
    /*function to get subpo from getdata_bulk_subPO
        @params : plantcode,mpo
        @returns: subpo
        */
        if($get_mpo!='' && $plant_code!=''){
            $result_bulk_subPO=getBulkSubPo($get_mpo,$plant_code);
            $sub_po_description=$result_bulk_subPO['sub_po_description'];
        }
        echo "<div class='col-sm-3'><label>Select Sub PO: </label>";  
        echo "<select style='min-width:100%' name=\"sub_po\" onchange=\"fifthbox();\" class='form-control' >
                <option value=\"NIL\" selected>NIL</option>";
                    foreach ($sub_po_description as $key=>$sub_po_description_val) {
                        if(str_replace(" ","",$sub_po_description_val)==str_replace(" ","",$get_sub_po)) 
                        { 
                            echo '<option value=\''.$sub_po_description_val.'\' selected>'.$key.'</option>'; 
                        } 
                        else 
                        { 
                            echo '<option value=\''.$sub_po_description_val.'\'>'.$key.'</option>'; 
                        }
                    } 
        echo "</select></div>";

echo "<div class='col-md-3'><input type=\"submit\" value=\"Show\" class='btn btn-primary' name=\"filter2\" id= \"filter2\" onclick=\"document.getElementById('filter2').style.display='none'; document.getElementById('msg').style.display='';\" style='margin-top:22px;'>";
?>
</div>
</div>
</form>
<br/>
<div class="alert alert-info" role="alert" id="msg" style="display:none;">Please Wait.. While Processing The Data..</div>
<?php
if(isset($_POST['filter']) or isset($_POST['filter2']))
{
    $style=$_POST['style'];
    $schedule=$_POST['schedule']; 
    $color=$_POST['color'];
    $mpo=$_POST['mpo'];
    $sub_po=$POST['sub_po'];
    if ($style=='NIL' or $schedule=='NIL' or $color=='NIL' or $mpo=='NIL') {
        echo '<div class="alert alert-danger">
              <strong>Warning!</strong> Please Provide All Details
            </div>';
    } else {
        echo "<hr>";
        echo "<div class='table-responsive'><table class='table table-bordered'>";
        echo "<tr>
        <th>Division</th>
        <th>FG Status</th>
        <th>Ex-Factory</th>
        <th>Style</th>
        <th>Schedule</th>
        <th>Color</th>
        <th>Section</th>
        <th>Size</th>
        <th>Total Order <br/>Quantity</th>
        <th>Total Cut <br/>Quantity</th>
        <th>Total Input <br/>Quantity</th>
		<th>Total Sewing Out <br/>Quantity</th>
		<th>Total FG <br/>Quantity</th>";
        //echo "<th>Total FG <br/>Quantity</th><th>Total FCA <br/>Quantity</th><th>Total MCA <br/>Quantity</th><th>Total Shipped <br/>Quantity</th>";   
        echo "
        <th>Rejected <br/>Quantity</th>
        <th>Sample <br/>Quantity</th>
        <th class=\"total\" style='background-color:#29759C;color:white;'>Sewing <br/>Missing</th>
        <th class=\"total\" style='background-color:#29759C;color:white;'>Cutting <br/>Missing</th>
            </tr>";
        //get_buyer_division
        $Qry_get_buyer_division="SELECT buyer_desc,planned_delivery_date FROM $oms.oms_mo_details WHERE schedule='$schedule' AND plant_code='$plant_code' AND is_active=1";
        $result1 = $link->query($Qry_get_buyer_division);
        while($row1 = $result1->fetch_assoc())
        {
           $buyer_desc=$row1['buyer_desc'];
           $exfactory_date=$row1['planned_delivery_date'];
        }
        $status=''; 
        //To get Total order qty
        $sql2="SELECT mo_quantity AS quantity FROM $oms.`oms_mo_details` WHERE schedule='$schedule' AND plant_code='$plant_code' AND is_active=1";
        $sql_result2=mysqli_query($link, $sql2) or die("Error".$sql2.mysqli_error($GLOBALS["___mysqli_ston"]));
        while($row2=mysqli_fetch_array($sql_result2))
        {
            $total_order_qty=$row2['quantity'];
        } 
        //get jm_jg_header_id
        $job_group_type=TaskTypeEnum::PLANNEDSEWINGJOB;
        $Qry_get_header_id="SELECT jm_jg_header_id FROM $pps.jm_jg_header LEFT JOIN $pps.jm_job_header on jm_job_header.jm_job_header_id = jm_jg_header.jm_job_header WHERE master_po_number='$mpo' AND po_number='$sub_po' AND jm_jg_header.job_group_type='$job_group_type' AND jm_job_header.plant_code='$plant_code' AND jm_job_header.is_active=1";
        $result2 = $link->query($Qry_get_header_id);
        while($row2 = $result2->fetch_assoc())
        {
          $jm_jg_header_id=$row2['jm_jg_header_id'];
        }
        //Get task_job_ids
        $Qry_get_task_jobid="SELECT task_jobs_id FROM $tms.task_jobs WHERE task_job_reference='$jm_jg_header_id' AND plant_code='$plant_code' AND is_active=1";
        $result3 = $link->query($Qry_get_task_jobid);
        while($row3 = $result3->fetch_assoc())
        {
          $task_jobs_id=$row3['task_jobs_id'];
        }
        //To get cutting operation
        $category=OperationCategory::CUTTING;
        $Qry_get_cut_ops="SELECT operation_code FROM $pms.`operation_mapping` WHERE operation_name='$category' AND plant_code='$plant_code' AND is_active=1";
        $result4 = $link->query($Qry_get_cut_ops);
        while($row4 = $result4->fetch_assoc())
        {
           $cut_operation=$row4['operation_code'];
		}
		$pack_operation='200';
        /**
         * getting min and max operations
         */
        $qrytoGetMinOperation="SELECT operation_code FROM $tms.`task_job_transaction` WHERE task_jobs_id='".$task_jobs_id."' AND plant_code='$plant_code' AND is_active=1 ORDER BY operation_seq ASC LIMIT 0,1";
        $minOperationResult = mysqli_query($link_new,$qrytoGetMinOperation) or exit('Problem in getting operations data for job');
        if(mysqli_num_rows($minOperationResult)>0){
            while($minOperationResultRow = mysqli_fetch_array($minOperationResult)){
                $minOperation=$minOperationResultRow['operation_code'];
            }
        }
        
        /**
         * getting min and max operations
         */
        $qrytoGetMaxOperation="SELECT operation_code FROM $tms.`task_job_transaction` WHERE task_jobs_id='".$task_jobs_id."' AND plant_code='$plant_code' AND is_active=1 ORDER BY operation_seq DESC LIMIT 0,1";
        $maxOperationResult = mysqli_query($link_new,$qrytoGetMaxOperation) or exit('Problem in getting operations data for job');
        if(mysqli_num_rows($maxOperationResult)>0){
            while($maxOperationResultRow = mysqli_fetch_array($maxOperationResult)){
                $maxOperation=$maxOperationResultRow['operation_code'];
            }
        }
        die();
        //get style and color operations
        $get_details="SELECT style,schedule,color,size,resource_id,sum(if(operation_id=".$minOperation.",good_quantity,0)) as input_quantity,sum(if(operation_id=".$maxOperation.",good_quantity,0)) as output_quantity,sum(if(operation_id=".$cut_operation.",good_quantity,0)) as cut_quantity,sum(if(operation_id=".$pack_operation.",good_quantity,0)) as fg_quantity,sum(rejected_quantity) as rejected_qty FROM $pts.transaction_log WHERE style='$style' AND schedule='$schedule' AND color='$color' AND plant_code='$plant_code' AND is_active=1 GROUP BY size";
        $result5 = $link->query($get_details);
        while($row5 = $result5->fetch_assoc())
        {
            $sizes=$row5['$row5'];
            $input_quantity=$row5['input_quantity'];
            $output_quantity=$row5['output_quantity'];
			$cut_quantity=$row5['cut_quantity'];
			$fg_quantity=$row5['fg_quantity'];
			$rejected_qty=$row5['rejected_qty'];
			
			if($cut_quantity ==0)
			{
				$status='RM';
			} else if($cut_quantity !=0)
			{
				$status='CUT';
			} else if($input_quantity > 0 || $output_quantity > 0)
			{
                $status='SEWING';
			} else if($fg_quantity > 0)
			{
				$status='FG';
			}
              
            echo "<tr>";
            echo "<td>".$buyer_desc."</td>";
            echo "<td>".$status."</td>";
            echo "<td>".$exfactory_date."</td>";
            // echo "<td><a href=\"pop_report.php?style=$style&schedule=$schedule&color=$color\" onclick=\"Popup=window.open('pop_report.php?style=$style&schedule=$schedule&color=$color"."','Popup','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes, width=920,height=400, top=23'); if (window.focus) {Popup.focus()} return false;\">".$sql_row['style']."</a></td>";
            echo "<td>".$style."</td>";
            echo "<td>".$schedule."</td>";
            echo "<td>".$color."</td>";
            echo "<td></td>";
            echo "<td>".$sizes."</td>";
            echo "<td>".$total_order_qty."</td>";
            echo "<td>".$cut_quantity."</td>";
            echo "<td>".$input_quantity."</td>";
            echo "<td>".$output_quantity."</td>";
			echo "<td>".$rejected_qty."</td>";
			echo "<td>".$fg_quantity."</td>";
            echo "<td>0</td>";
            echo "<td>0</td>";
            echo "<td>0</td>";
            echo "</tr>";
            
        }   
        echo "</table></div>";
    }
}


?>

</div>
</div>
<style>
th{
    background-color:#29759C;
    color:#FFF;
}

</style>