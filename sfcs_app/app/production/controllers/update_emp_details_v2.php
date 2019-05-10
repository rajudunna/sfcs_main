<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php 
	include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
    include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/functions.php',3,'R'));
    $has_permission=haspermission($_GET['r']);
	$team=$_POST['team'];
	$date=$_POST['dat'];
	$shift_start=$_POST['shift_start'];
	$shift_end=$_POST['shift_end'];
?>
<script language="javascript" type="text/javascript" src="datetimepicker_css.js"></script>
<script type="text/javascript">

function check_hrs(){
	var shift_start=$('#shift_start').val();
	var shift_end=$('#shift_end').val();
	var team=$('#team').val();

	console.log(shift_start+'---'+shift_end);
	if(team=='' || shift_start=='' || shift_end=='' ){
		swal('Please Fill All Details','','warning');
		return false;
	}
	if(Number(shift_end) <= Number(shift_start))
	{
		swal('Please select Shift End Time more than Shift Start Time','','warning');
		$('#shift_end').val('');
		return false;
	}
	return true;
}
 </script>
<?php //include("header_scripts.php"); 
$username_list=explode('\\',$_SERVER['REMOTE_USER']);
$username=strtolower($username_list[1]);
?>

<?php echo '<link href="'."http://".$_SERVER['HTTP_HOST']."/styles/sfcs_styles.css".'" rel="stylesheet" type="text/css" />'; ?>	
</head>

<body>


<div class="panel panel-primary">
	<div class="panel-heading">Employee Attendance Update</div>
	<div class="panel-body">
		<form method="POST" action="<?php echo getURL(getBASE($_GET['r'])['path'])['url']; ?>" >
			<div class='col-md-3 col-sm-3 col-xs-12'>
				Select Date: <input id="demo1" type="text" class="form-control" data-toggle="datepicker" size="10" name="dat" onclick="NewCssCal('demo1','yyyymmdd')" value=<?php if($date<>"") {echo $date; } else {echo date("Y-m-d");} ?>>
			</div>
			<div class='col-md-3 col-sm-3 col-xs-12'>
				Select Team : 
				<select name="team" id="team" class="select2_single form-control" required>
					<option value=''>Please Select</option>
					<?php 
					for ($i=0; $i < sizeof($shifts_array); $i++)
					{
					?>
					<option  <?php echo 'value="'.$shifts_array[$i].'"'; if($team==$shifts_array[$i]){ echo "selected";}   ?>><?php echo $shifts_array[$i] ?></option>
					<?php 
									}
					?>
				</select>
			</div>
			<?php
			$plant_timings_array=array();
			$sql1="select DISTINCT time_value as plant_time FROM $bai_pro3.tbl_plant_timings";
			$sql_result1=mysqli_query($link, $sql1) or exit ("Sql Error: $Sql1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row1=mysqli_fetch_array($sql_result1))
			{
				$plant_timings_array[]=$sql_row1['plant_time'];
			}
			?>	
			<div class='col-md-3 col-sm-3 col-xs-12'>
				Select Shift Start Time: 
				<select name="shift_start" id="shift_start"  class="select2_single form-control" required>
					<option value=''>Please Select</option>
					<?php 
						for ($i=0; $i < sizeof($plant_timings_array); $i++)
						{
					?>
					<option  <?php echo 'value="'.$plant_timings_array[$i].'"'; if($shift_start==$plant_timings_array[$i]){ echo "selected";}   ?>><?php echo $plant_timings_array[$i] ?></option>
					<?php 
						}
					?>
				</select>
			</div>
			<div class='col-md-3 col-sm-3 col-xs-12'>
				Select Shift End Time:
				<select name="shift_end" id="shift_end" class="select2_single form-control" onchange="return check_hrs();" required>
					<option value=''>Please Select</option>
					<?php 
						for ($i=0; $i < sizeof($plant_timings_array); $i++)
						{
							?>
					<option  <?php echo 'value="'.$plant_timings_array[$i].'"'; if($shift_end==$plant_timings_array[$i]){ echo "selected";}   ?>><?php echo $plant_timings_array[$i] ?></option>
							<?php 
						}
					?>
				</select>
			</div>
			<br>
			<br>
			<div class='col-md-3 col-sm-3 col-xs-12' style='margin-top: 18px;'>
				<input type="submit" class="btn btn-primary" name="submit" onclick="return check_hrs();" value="Submit" id="filter"/> 
			</div>
		</form>
		<br>
<?php
if(isset($_POST['submit']))
{
	$shift=$_POST['team'];
	$date=$_POST['dat'];
	$shift_start_time=$_POST['shift_start'];
	$shift_end_time=$_POST['shift_end'];
	$modules_array = array();	$modules_id_array=array();
	$get_modules = "SELECT DISTINCT module_name, id FROM $bai_pro3.`module_master` where status='Active' ORDER BY module_name*1;";
	$modules_result=mysqli_query($link, $get_modules) or exit ("Error while fetching modules: $get_modules");
	if(mysqli_num_rows($modules_result) > 0)
	{
		while($module_row=mysqli_fetch_array($modules_result))
		{
			$modules_array[]=$module_row['module_name'];
			$modules_id_array[$module_row['module_name']]=$module_row['id'];
		}
		$modules = implode("','", $modules_array);
		$sql1="SELECT * FROM $bai_pro.pro_attendance WHERE DATE='$date' AND shift='$shift' AND module IN ('$modules') order by module*1";
		echo "
		<table border=1 class='table table-bordered'>
			<tr class='info'>
				<th>Module</th>
				<th>Team - $shift Available Emp</th>
				<th>Team - $shift Absent Emp</th>";
				$sql_result1=mysqli_query($link, $sql1) or exit ("Sql Error: $Sql1".mysqli_error($GLOBALS["___mysqli_ston"]));
				$sql_num_check=mysqli_num_rows($sql_result1);
				if($sql_num_check>0)
				{
					echo "<th>Total</th>
					</tr>";
					while($sql_row1=mysqli_fetch_array($sql_result1))
					{
						$atten_id=$sql_row1['atten_id'];
						$date=$sql_row1['date'];
						$avail_av=$sql_row1['present'];
						$absent_ab=$sql_row1['absent'];
						$module=$sql_row1['module'];
						$k=$modules_id_array[$module];
						echo "<tr>
								<td>".$module."</td>"; 
								if(in_array($authorized,$has_permission))
								{
									$readonly = ''; ?>
									<form method="POST" action="<?= getFullURLLevel($_GET['r'],"insert_emp_data_v2.php",0,"N") ?>" >
									<?php
										echo "<input type=\"hidden\" name=\"shift\" value=\"$shift\">";
										echo "<input type=\"hidden\" name=\"date\" value=\"$date\">";
										echo "<input type=\"hidden\" name=\"shift_start_time\" value=\"$shift_start_time\">";
										echo "<input type=\"hidden\" name=\"shift_end_time\" value=\"$shift_end_time\">";			
								}
								else
								{
									$readonly = 'readonly';
								}
							?>
								
								<td><input type="text" class="form-control" <?php echo $readonly; ?> style="width: 180px;" value="<?php echo $avail_av; ?>" name="pra<?php echo $k; ?>"></td>
								<td><input type="text" class="form-control" <?php echo $readonly; ?> style="width: 180px;" value="<?php echo $absent_ab; ?>" name="aba<?php echo $k; ?>"></td>
								<?php
								echo "<td>".($avail_av-$absent_ab)."</td>
							</tr>";
					}
					if(in_array($authorized,$has_permission))
					{ ?>
						<tr>
							<th colspan=5><input type="submit" class="btn btn-primary" value="Submit"> </th>
						</tr> <?php
					}
					echo "</table>";
				}
				else
				{
					for($i=0;$i<sizeof($modules_array);$i++) 
					{ 
						$k=$modules_id_array[$modules_array[$i]];
						?>
						<form method="POST" action="<?= getFullURLLevel($_GET['r'],"insert_emp_data_v2.php",0,"N") ?>" >
							<tr>
								<td> <?php echo $modules_array[$i]; ?> </td>
								<td><input type="text" class="form-control" style="width: 180px;" value="0" name="pra<?php echo $k; ?>"></td>
								<td><input type="text" class="form-control" style="width: 180px;"value="0" name="aba<?php echo $k; ?>"></td>
							</tr>
						<?php
					}
					echo "<input type=\"hidden\" name=\"shift\" value=\"$shift\">";
					echo "<input type=\"hidden\" name=\"date\" value=\"$date\">";
					echo "<input type=\"hidden\" name=\"shift_start_time\" value=\"$shift_start_time\">";
					echo "<input type=\"hidden\" name=\"shift_end_time\" value=\"$shift_end_time\">";
					 ?>
					
					<tr>
						<th colspan=5><input type="submit" class="btn btn-primary" value="Submit"> </th>
					</tr>
				
						</table>
					</form>
					</div>
					</div>
					<?php
				}
	}
	else
	{
		echo "No Modules Available in Modules Master";
	}
}
?>
</body>
</html>