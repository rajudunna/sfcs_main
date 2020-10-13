<?php 
	include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
	$sdate=$_POST['dat1'];
	$edate=$_POST['dat2'];
	$teams=$shifts_array;
	$team_array=implode(",",$shifts_array);
	$team = "'".str_replace(",","','",$team_array)."'"; 
	$plantcode=$_SESSION['plantCode'];
	$username=$_SESSION['userName'];
?>

<div class="panel panel-primary">
	<div class="panel-heading">Grand Efficiency Summary Report</div>
	<div class="panel-body">
		<form method="POST" action="<?php echo "index-no-navi.php?r=".$_GET['r']; ?>">
			<div class="row">
				<div class="col-md-3">
					<label>Start Date:</label>
					<input id="demo1" type="text" data-toggle="datepicker" class="form-control" name="dat1" value=<?php if($sdate!="") { echo $sdate; } else { echo date("Y-m-d"); } ?>>
				</div>
				<div class="col-md-3">
					<label>End Date:</label>
					<input id="demo2" type="text" data-toggle="datepicker" class="form-control" name="dat2" value=<?php if($edate!="") { echo $edate; } else { echo date("Y-m-d"); } ?>>
				</div>
				<div class="col-md-1"><br/>
					<input type="submit" name="submit" id="submit" value="Show" onclick ="return verify_date()" class="btn btn-sm btn-success">						
				</div>
			</div>
		</form>


		<?php
if(isset($_POST['submit'])) 
{ 
	$edate=$_POST['dat2']; 
	$sdate=$_POST['dat1']; 


				     
	echo "<h3> Report for the period: $sdate to $edate </h3>"; 
		
	echo "<table id=\"info\" class='table table-bordered'>";
		echo "<tr>"; 
			echo "<th>Section</th>"; 
			echo "<th>Team</th>"; 
			echo "<th>Plan EFF</th>"; 
			echo "<th>Act EFF</th>"; 
			echo "<th>Plan STH</th>"; 
			echo "<th>Act STH</th>"; 
			echo "<th>Plan PRO</th>"; 
			echo "<th>Act PRO</th>"; 
		echo "</tr>"; 
			     
	//Renmoved the where clause for section 
	$decimal_factor=2;
	$sql2="SELECT s.section_code AS section_code,w.workstation_id AS workstation_id FROM $pms.departments d
			LEFT JOIN $pms.`workstation_type` wt ON wt.department_id=d.department_id
			LEFT JOIN $pms.`workstation` w ON w.workstation_type_id=wt.workstation_type_id
			LEFT JOIN $pms.`sections` s ON s.section_id=w.section_id
			WHERE d.department_type='SEWING' AND d.plant_code='$plantcode' and w.workstation_id<>'' GROUP BY s.section_code ORDER BY s.section_code";
	$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error78".mysqli_error($GLOBALS["___mysqli_ston"])); 
	while($sql_row2=mysqli_fetch_array($sql_result2)) 
	{ 
		$section=$sql_row2['section_code']; 
		$resource_id=$sql_row2['workstation_id']; 
				
		$check=0; 
			
		$sql_new="SELECT DISTINCT shift FROM $pts.`transaction_log` where plant_code='$plantcode' and resource_id='$resource_id' and date(created_at) between \"$sdate\" and \"$edate\""; 
		// echo $sql_new;
		$sql_result_new=mysqli_query($link, $sql_new) or exit("Sql Error77".mysqli_error($GLOBALS["___mysqli_ston"])); 
		$rowspan=mysqli_num_rows($sql_result_new); 
		while($sql_row_new=mysqli_fetch_array($sql_result_new)) 
		{ 
			$shift=$sql_row_new['shift']; 
				
			echo "<tr>"; 
			if($check==0) 
			{ 
				echo "<td rowspan=$rowspan>$section</td>"; 
				$check=1; 
			} 
			echo "<td>$shift</td>"; 
				
			$sql="SELECT SUM(planned_qty) AS planned_qty,SUM(planned_sah) AS planned_sah,SUM(planned_eff) AS planned_eff,SUM(smv) as smv FROM $pps.`monthly_production_plan` mpl
			LEFT JOIN $pps.`monthly_production_plan_upload_log` mppu ON mppu.monthly_pp_up_log_id=mpl.pp_log_id
			WHERE mppu.plant_code='$plantcode' AND date(mpl.planned_date) BETWEEN \"$sdate\" and \"$edate\""; 
			// echo $sql."<br/>"; 
			$sql_result=mysqli_query($link, $sql) or exit("Sql Error79".mysqli_error($GLOBALS["___mysqli_ston"])); 
			while($sql_row=mysqli_fetch_array($sql_result)) 
			{ 
				$plan_sth=round($sql_row["planned_sah"],$decimal_factor);
				$planned_eff=round($sql_row["planned_eff"],$decimal_factor);
				$plan_clh=round($sql_row["smv"],$decimal_factor);
				$plan_out=$sql_row['planned_qty']; 
			}

			//getting actual output
			$get_act_out_qry="select sum(quantity) as actout FROM $pts.`transaction_log` where plant_code='$plantcode' and resource_id='$resource_id' and date(created_at) between \"$sdate\" and \"$edate\"";			
			$get_act_out_qry_result=mysqli_query($link, $get_act_out_qry) or exit("Sql Error getting actout".mysqli_error($GLOBALS["___mysqli_ston"])); 
			while($sql_row_act=mysqli_fetch_array($get_act_out_qry_result)) 
			{
				$act_out=$sql_row_act['actout']; 
			}		
			
			echo "<td>".round($planned_eff,$decimal_factor)."%</td>"; 
			echo "<td>".round(($act_sth/$act_clh)*100,$decimal_factor)."%</td>"; 
			echo "<td>".round($plan_sth,$decimal_factor)."</td>"; 
			echo "<td>".round($act_sth,$decimal_factor)."</td>"; 
			echo "<td>".round($plan_out,$decimal_factor)."</td>"; 
			echo "<td>".round($act_out,$decimal_factor)."</td>"; 
			echo "</tr>"; 
		} 
			
	} 
 
									
	echo "</table>"; 
}
		?>
	</div>
</div>

<script type="text/javascript">
	function verify_date()
	{
		var val1 = $('#demo1').val();
		var val2 = $('#demo2').val();
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