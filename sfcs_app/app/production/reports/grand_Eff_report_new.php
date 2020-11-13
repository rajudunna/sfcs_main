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


				     
	
	//Renmoved the where clause for section 
	$decimal_factor=2;
	$sql2="select section,shift,sum(plan_out) as plan_out,sum(act_out) as act_out,sum(plan_sth) as plan_sth,sum(act_sth) as act_sth,sum(act_clh) as act_clh from $pts.grand_rep where plant_code='$plantcode' and date between '".$sdate."' and '".$edate."' group by section,shift";
	$sql_result2=mysqli_query($link, $sql2) or exit("Error While fetching information from Grand Rep".mysqli_error($GLOBALS["___mysqli_ston"])); 
	if(mysqli_num_rows($sql_result2)>0)
	{
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
			     
		
		while($sql_row2=mysqli_fetch_array($sql_result2)) 
		{ 
			$section=$sql_row2['section']; 
			$shift=$sql_row2['shift']; 
			$plan_sth=round($sql_row2["plan_sth"],$decimal_factor);
			$act_sth=round($sql_row2["act_out"],$decimal_factor);
			$plan_out=round($sql_row2["plan_sth"],$decimal_factor);
			$act_out=round($sql_row2["act_sth"],$decimal_factor);
			$act_clh=round($sql_row2["act_clh"],$decimal_factor);
			echo "<tr>"; 
			echo "<td rowspan=$rowspan>$section</td>"; 
			echo "<td>$shift</td>"; 
			if($act_clh=='0.00')
			{
				$act_eff=0;
			}
			else
			{
				$act_eff=round(($act_sth/$act_clh)*100,$decimal_factor);
			}
			
			
			
			echo "<td>".round($planned_eff,$decimal_factor)."%</td>"; 
			echo "<td>".$act_eff."%</td>"; 
			echo "<td>".round($plan_sth,$decimal_factor)."</td>"; 
			echo "<td>".round($act_sth,$decimal_factor)."</td>"; 
			echo "<td>".round($plan_out,$decimal_factor)."</td>"; 
			echo "<td>".round($act_out,$decimal_factor)."</td>"; 
			echo "</tr>"; 				
		}
	}
	else
	{		
		echo "<br><br><div class='alert alert-danger'><b>No records found for selected criteria!</b></div>";
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