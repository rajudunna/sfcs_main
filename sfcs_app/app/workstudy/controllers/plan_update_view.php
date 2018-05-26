



<div class="panel panel-primary">
<div class="panel-heading">View Plan Efficiency</div>
<div class="panel-body">
<?php
include($_SERVER['DOCUMENT_ROOT'].getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));

?>

	<form name="test" method="post" action="<?php echo getFullURL($_GET['r'], "plan_update_view.php", "N"); ?>">
	<div class="row"><div class="col-sm-3"></div><div class="col-sm-3"><label>Select Date:</label><input type="text" data-toggle="datepicker" class="form-control" name="date" value="<?php  if(isset($_POST['date'])) {echo $_POST['date']; } else { echo date("Y-m-d"); } ?>"></div>&nbsp;&nbsp;&nbsp;<input class="btn btn-primary btn-sm" type="submit" name="filter" value="Show" style="margin-top:23px;"></div>
	
	</form><br/>
	
	<?php
	
	
	if(isset($_POST['filter']))
	{
		$date=$_POST['date'];
	echo '<hr/><div class="table-responsive"><table class="table table-bordered">
	<tr bgcolor=#d9534f><td colspan=18><strong>Plan Update Review</strong><span align=right style="margin-left:750px;"> Date: '.$date.'</span></td></tr>
	
	<tr style="background-color:#286090;color:white;"><th>Module</th>	<th>Section</th><th>Style</th><th>SMV</th><th>NOP</th><th>Team A <br/>Plan Eff</th><th>Team A <br/>Plan Pro</th>
	
	<th>Team A <br/>Plan Clock Hours</th>
	<th>Team A <br/>Plan SAH</th>
	
	<th>Team A <br/>Plan Hours</th><th>Team A <br/>Plan Couple</th><th>Team B <br/>Plan Eff</th>	<th>Team B <br/>Plan Pro</th>
	
	<th>Team B <br/>Plan Clock Hours</th>
	<th>Team B <br/>Plan SAH</th>
	
	<th>Team B <br/>Plan Hours</th><th>Team B <br/>Plan Couple</th><th>Remarks</th>
</tr>';

	$x=0;
	$sql="select * from $bai_pro.pro_plan where date=\"$date\"";
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	// $sql_count="select count(*) from bai_pro.pro_plan where date=\"$date\"";
	// $sql_result_count=mysqli_query($link, $sql_count) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	if(mysqli_num_rows($sql_result)>0)
	{
		while($sql_row=mysqli_fetch_array($sql_result))
		{
			$module=$sql_row['mod_no'];
			$shift=$sql_row['shift'];
			$plan_eff=$sql_row['plan_eff'];
			$plan_pro=$sql_row['plan_pro'];
			$remarks=$sql_row['remarks'];
			$sec_no=$sql_row['sec_no'];
			$act_hours=$sql_row['act_hours'];
			$couple=$sql_row['couple'];
			$plan_clh=$sql_row['plan_clh'];
			$plan_sah=$sql_row['plan_sah'];
			
			$sql1="select bac_style,smv,nop from $bai_pro.bai_log_buf where bac_date=\"$date\" and bac_no=$module and smv>0 and nop>0 order by bac_no";
			//echo $sql1."<br/>";		$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row1=mysqli_fetch_array($sql_result1))
			{
				$smv=$sql_row1['smv'];
				$nop=$sql_row1['nop'];
				$bac_style=$sql_row1['bac_style'];
			}
			
			$bgcolor_tag=" style=\"background-color: white\"";
			if($smv>0)
			{
				if(round(($plan_eff*$act_hours*60*$nop)/($smv*100),0)!=round($plan_pro,0))
				{
					$bgcolor_tag=" style=\"background-color: #FFFF66;\"";
				}
			}
			else
			{
				$bgcolor_tag=" style=\"background-color: #FFFF66;\"";
			}
			if($shift=="A")
			{
				echo "<tr>";
				echo '<td bgcolor=\"#99FFDD\">'.$module.'</td>';
				echo '<td bgcolor=\"#99FFDD\">'.$sec_no.'</td>';
				echo '<td bgcolor=\"#99FFDD\">'.$bac_style.'</td>';
				echo '<td bgcolor=\"#99FFDD\">'.$smv.'</td>';
				echo '<td bgcolor=\"#99FFDD\">'.$nop.'</td>';
				echo '<td bgcolor=\"#FFEEFF\">'.$plan_eff.'</td>';
				echo '<td bgcolor=\"#FFEEFF\">'.round($plan_pro,0).'</td>';
				echo '<td bgcolor=\"#FFEEFF\">'.$plan_clh.'</td>';
				echo '<td bgcolor=\"#FFEEFF\">'.$plan_sah.'</td>';
				echo '<td bgcolor=\"#FFEEFF\">'.$act_hours.'</td>';
				echo '<td bgcolor=\"#FFEEFF\">'.$couple.'</td>';
			}
			
			if($shift=="B")
			{
				echo '<td bgcolor=\"#99FF88\">'.$plan_eff.'</td>';
				echo '<td bgcolor=\"#99FF88\">'.round($plan_pro,0).'</td>';
				echo '<td bgcolor=\"#FFEEFF\">'.$plan_clh.'</td>';
				echo '<td bgcolor=\"#FFEEFF\">'.$plan_sah.'</td>';
				echo '<td bgcolor=\"#99FF88\">'.$act_hours.'</td>';
				echo '<td bgcolor=\"#99FF88\">'.$couple.'</td>';
				echo '<td bgcolor=\"#99FFDD\">'.$remarks.'</td>';
				echo "</tr>";
				$x++;
			}
		}
	}
	else {
		echo '<tr><td colspan=18 style="color:RED;"><b><center>No Data Found!</center></b></td></tr>';
	}
	echo '</table></div>';
}
?>
</div></div>
</div>

<style>
body{
	font-family: Trebuchet MS;
}

td.leftfloat
{
	text-align:left;
}
td{
	color:white;
	text-weight:bold;
}
</style>