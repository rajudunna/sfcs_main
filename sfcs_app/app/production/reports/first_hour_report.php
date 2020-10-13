<?php 
    include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
$plant_code=$_SESSION['plantCode'];
?>
	<title>First Hour Output</title>
	<style>
		#ad{
			padding-top:220px;
			padding-left:10px;
		}
		
		body
		{
			font-size:12px;
		}
		
		.report tr
		{
			border: 1px solid black;
			text-align: right;
			white-space:nowrap; 
		}
		
		.report td
		{
			border: 1px solid black;
			text-align: right;
			white-space:nowrap; 
		}
		
		.report th
		{
			border: 1px solid black;
			text-align: center;
		    background-color: BLUE;
			color: WHITE;
			white-space:nowrap; 
			padding-left: 5px;
			padding-right: 5px;
			font-size: 14px;
		}
		
		.report {
			white-space:nowrap; 
			border-collapse:collapse;
			font-size:12px;
		}

	</style>

<!---<div id="page_heading"><span style="float:"><h3>First Hour Production Report</h3></span><span style="float: right"><b>?</b>&nbsp;</span></div>--->
<div class="panel panel-primary">
<div class="panel-heading">First Hour Production Report</div>
<div class="panel-body">

<form name="test" method="post" action="<?php echo getURL(getBASE($_GET['r'])['path'])['url']; ?>">
<div class='col-md-3 col-sm-3 col-xs-12'>
From Date: <input type="text" data-toggle="datepicker" name="fdate" id="dat1" size="8" class="form-control" value="<?php  if(isset($_POST['fdate'])) { echo $_POST['fdate']; } else { echo date("Y-m-d"); } ?>" onclick="displayCalendar(document.test.fdate,'yyyy-mm-dd',this)">
</div>
<div class='col-md-3 col-sm-3 col-xs-12'> 
 To Date: <input type="text" data-toggle="datepicker" name="tdate" id="dat2"size="8" class="form-control" value="<?php  if(isset($_POST['tdate'])) { echo $_POST['tdate']; } else { echo date("Y-m-d"); } ?>" onclick="displayCalendar(document.test.tdate,'yyyy-mm-dd',this)">
</div>
<!--<input type="submit" name="submit" value="Show">-->

<?php

echo "<input type=\"submit\" value=\"Show\" name=\"submit\" id=\"submit\" onclick =\"return verify_date()\" style=\"margin-top: 17px;\" class=\"btn btn-success\" onclick=\"document.getElementById('submit').style.display='none'; document.getElementById('msg1').style.display='';\"/>";

?>
</form>


<?php

if(isset($_POST['submit']))
{
	
	$fdate=$_POST['fdate'];
	$tdate=$_POST['tdate'];
	
	echo "<hr/><br/><div class='table-responsive'>";
	echo "<table class=\"table table-bordered\">";
	echo "<tr style='background-color:#286090;color:white;'>";
	echo "<th>Date</th>";
	echo "<th>Section</th>";
	echo "<th>Team</th>";	
	echo "<th>Module</th>";
	//echo "<th>Responsible</th>";
	echo "<th>Style</th>";
	echo "<th>Schedule</th>";
	echo "<th>SMO</th>";
	echo "<th>Plan Eff%</th>";
	echo "<th>Actual Eff%</th>";
	echo "<th>Plan Output</th>";
	echo "<th>Actual Output</th>";
	echo "<th>SAH</th>";
	echo "</tr>";
	
	
    //get last hour
    $get_end_hour="SELECT HOUR(plant_end_time) as last_time FROM $pms.plant WHERE plant_code='$plant_code' AND is_active=1";
    $sql_result123=mysqli_query($link_new, $get_end_hour) or exit("Sql Error2.1111".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($rows123=mysqli_fetch_array($sql_result123))
    {
        $last_time = $rows123['plant_end_time'];
    }
    
    $time_value_pm = $last_time - 8;
	$start_time_pm = $time_value_pm;
    $end_time_pm = $time_value_pm + 1.29;
	$sql22121="SELECT HOUR(plant_start_time) as start_time FROM $pms.plant WHERE plant_code='$plant_code' AND is_active=1"; 
	$sql_result22121=mysqli_query($link_new, $sql22121) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($rows1231=mysqli_fetch_array($sql_result22121))
	{
		$start_time_am=$rows1231['plant_start_time'];
	}
	$end_time_am= $start_time_am + 1.29;

	$sql=$get_details="SELECT GROUP_CONCAT(DISTINCT style) AS style,schedule,color,sum(good_quantity) as qty,resource_id,shift,date(created_at) as bac_date FROM $pts.transaction_log WHERE plant_code='$plant_code' AND ((TIME(created_at) BETWEEN ('".$start_time_am."') AND ('".$end_time_am."')) OR (TIME(created_at) BETWEEN ('".$start_time_pm."') AND ('".$end_time_pm."'))) AND is_active=1 GROUP BY style,schedule,color,resource_id,shift";
	$sql_result=mysqli_query($link_new, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		//To get workstation description
		$query = "select workstation_description from $pms.workstation where plant_code='$plant_code' and workstation_id = '".$sql_row['resource_id']."' AND is_active=1";
		$query_result=mysqli_query($link_new, $query) or exit("Sql Error at workstation_description".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($des_row=mysqli_fetch_array($query_result))
		{
		  $workstation_description = $des_row['workstation_description'];
		}
		
		$color=$sql_row['color'];
		$qty=$sql_row['qty'];
		
	
		//TO caliculate act hours
		$get_acthours="SELECT * FROM $pms.plant WHERE plant_code='$plant_code' AND is_active=1"; 
		$sql_get_acthours=mysqli_query($link_new, $get_acthours) or exit("Sql sql_get_acthours".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($actrows=mysqli_fetch_array($sql_get_acthours))
		{
		   $start_time=$actrows['plant_start_time'];
		   $end_time=$actrows['plant_end_time'];
		   $diff_time=$end_time-$start_time;
		   $act_hrs=$diff_time-0.5;
		}

		//To get nop,plan_eff,planned_qty
		$get_planned_details="SELECT sum(planned_qty) as plan_qty,planned_eff,capacity_factor,(capacity_factor*1) AS clh FROM $pps.`monthly_production_plan` LEFT JOIN $pps.`monthly_production_plan_upload_log` ON monthly_production_plan_upload_log.`monthly_pp_up_log_id`=monthly_production_plan.`pp_log_id` WHERE row_name='$workstation_description' AND planned_date='".$sql_row['bac_date']."' AND plant_code='$plant_code' AND is_active=1";
		$get_planned_details_result=mysqli_query($link_new, $get_planned_details) or exit("Sql Error at get_planned_details_result".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($planned_row=mysqli_fetch_array($get_planned_details_result))
		{
		   $nop=$planned_row['capacity_factor'];
		   $plan_eff=$planned_row['planned_eff'];
		   $plan_qty=$planned_row['plan_qty'];
		   $clh=$planned_row['clh'];
		}
		
		//caliculation for plan_out
		$plan_out=round($plan_qty/$act_hrs,0);
		//To get SMV
		$get_smv="SELECT smv FROM $pps.`monthly_production_plan` LEFT JOIN $pps.`monthly_production_plan_upload_log` ON monthly_production_plan_upload_log.`monthly_pp_up_log_id`=monthly_production_plan.`pp_log_id` WHERE style='".$sql_row['style']."' AND color='$color' AND plant_code='$plant_code'
		AND is_active=1";
		$query_result1=mysqli_query($link_new, $get_smv) or exit("Sql Error at workstation_description".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($smv_row=mysqli_fetch_array($query_result1))
		{
           $smv=$smv_row['smv'];
		}
		//sah caliculation
		$sah=ROUND((($qty*$smv)/60),2);
		$act_eff=round((round(($sah/$clh)*100,0)/$plan_eff)*100,2);
		if($act_eff>=100)
		{
			$color="#66FF88";
		}
		else
		{
			if($act_eff>=90 and $act_eff<100)
			{
				$color="#FFBB44";
			}
			else
			{
				$color="#FF6655";
			}
		}
		echo "<tr>";
		echo "<td>".$sql_row['bac_date']."</td>";
		echo "<td></td>";
		echo "<td>".$sql_row['shift']."</td>";	
		echo "<td>".$workstation_description."</td>";
		echo "<td>".$sql_row['style']."</td>";
		echo "<td>".$sql_row['schedule']."</td>";
		echo "<td>".$nop."</td>";
		echo "<td>$plan_eff</td>";
		echo "<td bgcolor=\"$color\" style=\"color:black;\">".round(($sah/$clh)*100,0)."</td>";
		echo "<td>".$plan_out."</td>";
		echo "<td>".$qty."</td>";
		echo "<td>".round($sah,0)."</td>";
		echo "</tr>";
	}
	echo "</table>";
	echo "</div>";
}

// echo "</table>";

?>
</div>
</div>  
<script >
function verify_date()
{
	var val1 = $('#dat1').val();
	var val2 = $('#dat2').val();
	// d1 = new Date(val1);
	// d2 = new Date(val2);
	if(val1 > val2){
		sweetAlert('Start Date Should  be less than End Date','','warning');
		return false;
	}
	else
	{
	    return true;
	}
}
</script>