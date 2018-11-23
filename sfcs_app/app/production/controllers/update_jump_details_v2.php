<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<script language="javascript" type="text/javascript" src="datetimepicker_css.js"></script>
<?php //include("header_scripts.php"); 
$username_list=explode('\\',$_SERVER['REMOTE_USER']);
$username=strtolower($username_list[1]);
?>

<?php echo '<link href="'."http://".$_SERVER['HTTP_HOST']."/styles/sfcs_styles.css".'" rel="stylesheet" type="text/css" />'; ?>	
</head>

<body>

<form method="POST" action="<?php echo getURL(getBASE($_GET['r'])['path'])['url']; ?>" >

<?php 
	include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
    include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/functions.php',3,'R'));
    $has_permission=haspermission($_GET['r']);
?>
<?php
$team=$_POST['team'];
$date=$_POST['dat'];
?>
<div class="panel panel-primary">
<div class="panel-heading">Jumper Attendance Update</div>
<div class="panel-body">
<div class='col-md-3 col-sm-3 col-xs-12'>
<tr><td valign="top">
Select Date: <input id="demo1" type="text" class="form-control" data-toggle="datepicker" size="10" name="dat" onclick="NewCssCal('demo1','yyyymmdd')" value=<?php if($date<>"") {echo $date; } else {echo date("Y-m-d");} ?>>
</td>
</div>
<div class='col-md-3 col-sm-3 col-xs-12'>
<td valign="top">
Select Team : <select name="team" class="select2_single form-control" required>
<option value=''>Please Select</option>
<?php 
	for ($i=0; $i < sizeof($shifts_array); $i++) {?>
		<option  <?php echo 'value="'.$shifts_array[$i].'"'; if($team==$shifts_array[$i]){ echo "selected";}   ?>><?php echo $shifts_array[$i] ?></option>
	<?php }
?>
</select>
</div>
<div class='col-md-3 col-sm-3 col-xs-12' style="margin-top: 18px;">
<input type="submit" class="btn btn-primary" name="submit" value="Submit" id="filter"/> 
</div>
</form>
</br></br></br></br>
<?php
if(isset($_POST['submit']))
{
	$shift=$_POST['team'];
	$date=$_POST['dat'];

	$sql112="Select * from $bai_pro.pro_attendance where date=\"$date\" and  shift='".$shift."' and (present >0 or absent >0) order by module*1";
	$sql_result112=mysqli_query($link, $sql112) or exit ("Sql Error: $Sql1".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_num_check112=mysqli_num_rows($sql_result112);
	if($sql_num_check112>0)
	{
		$sql1="Select * from $bai_pro.pro_attendance where date=\"$date\" and jumper>0 and shift='".$shift."'  order by module*1";
		$sql_result1=mysqli_query($link, $sql1) or exit ("Sql Error: $Sql1".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql_num_check=mysqli_num_rows($sql_result1);
		if($sql_num_check>0)
		{
			echo "<table border=1 class='table table-bordered'><tr style='background-color:#29759C; color: white;'><th>Module</th><th>Team - $shift Available Emp</th><th>Team - $shift Absent Emp</th><th>Team - $shift Jumper</th><th>Total</th></tr>";
			while($sql_row1=mysqli_fetch_array($sql_result1))
			{
			// $atten_id=$sql_row1['atten_id'];
			$date=$sql_row1['date'];
			$avail_A=$sql_row1['present'];
			$absent_A=$sql_row1['absent'];
			$jumper_A=$sql_row1['jumper'];
			$module=$sql_row1['module'];
			$k=$module-1;
			echo "<tr>
					<td>".$module."</td>
					<td>".$avail_A."</td>
					<td>".$absent_A."</td>";
					 
							if(in_array($authorized,$has_permission))
							{
								$readonly = ''; ?>
								<form method="POST" action="<?= getFullURLLevel($_GET['r'],"insert_jump_data_v2.php",0,"N") ?>" >
								<?php
									echo "<input type=\"hidden\" name=\"shift\" value=\"$shift\">";
									echo "<input type=\"hidden\" name=\"date\" value=\"$date\">";
									echo '<input type="hidden" value="'.$module.'" name="module'.$i.'">';		
							}
							else
							{
								$readonly = 'readonly';
							}
							// <td>".$jumper_A."</td>
						?>
							
							<td><input type="text" class="form-control" <?php echo $readonly; ?> style="width: 180px;" value="<?php echo $jumper_A; ?>" name="jpa<?php echo $k; ?>"></td>
							<?php
							echo "<td>".(($avail_A+$jumper_A)-$absent_A)."</td>";
				
			}
			echo "</tr> </table>";
			if(in_array($authorized,$has_permission))
			{ ?>
				<tr>
					<th colspan=5><input type="submit" class="btn btn-primary" value="Submit"> </th>
				</tr> <?php
			}	
		}
		else
		{
			echo "<table border=1 class='table table-bordered'><tr style='background-color:#29759C; color: white;'><th>Module</th><th>Team - $shift Jumper</th></tr>";
			
			for($i=0;$i<sizeof($mod_names);$i++) { ?>
			<form method="POST" action="<?= getFullURLLevel($_GET['r'],"insert_jump_data_v2.php",0,"N") ?>" >
				<tr>
					<td>
						<?php echo $mod_names[$i]."</td>";
						 ?>
						<td><input type="text" class="form-control" style="width: 180px;" value="0" name="jpa<?php echo $i; ?>"></td>
						<?php
				echo "</tr>";
				}
			echo "<input type=\"hidden\" name=\"shift\" value=\"$shift\">";
			echo "<input type=\"hidden\" name=\"date\" value=\"$date\">"; ?>
				<tr>
					<th colspan=5><input type="submit" class="btn btn-primary" value="Submit"> </th>
				</tr>
			</table>
			</form>
			<?php
		}
	}
	else
	{
	  echo "<script>swal('Still Attandance Details Not Updated For This Shift','Please Inform HR Team to Update Attandance Details For This Shift','warning');</script>";
	}
}

?>

	</div>
	</div>
</body>
</html>