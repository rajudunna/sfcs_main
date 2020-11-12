<?php 
	include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));
    $plant_code = $_SESSION['plantCode'];
	$username = $_SESSION['userName'];
	if ($_GET['operation_id']) {
		$operation_id = $_GET['operation_id'];
		$shift = $_GET['shift'];
	} else {
		$operation_id = 200;
		$shift = 'A';
	}
?>

<style>
	th,td
	{
		text-align:center;
	}
</style>


<div class="panel panel-primary">
	<div class="panel-heading">Carton Scanning</div>
	<div class="panel-body">
		<?php
			if(isset($_GET['select']))
			{
				if($_GET['select']==1)
				{
					$team_id=$_GET['team_id'];
					$emp_id=$_GET['emp_id'];
					$sql_schedule="update $pms.tbl_fg_crt_handover_team_list set selected_user='$username', lastup='".date("Y-m-d H:i:s")."',updated_user='$username',updated_at=NOW() where team_id=$team_id and emp_id='$emp_id' and plant_code='$plant_code'";
					// echo $sql_schedule;
					mysqli_query($link, $sql_schedule) or exit("Sql Error_schedule".mysqli_error($GLOBALS["___mysqli_ston"]));
					$url = getFullURL($_GET['r'],'carton_scan_decentral_packing.php','R');
					echo '<form id="TheForm" method="post" action="'.$url.'" target="TheWindow">
					<input type="hidden" name="emp_id" value="'.$emp_id.'" />
					<input type="hidden" name="team_id" value="'.$team_id.'" />
					<input type="hidden" name="operation_id" value="'.$operation_id.'" />
					<input type="hidden" name="shift" value="'.$shift.'" />
					<input type="hidden" name="plant_code" value="'.$plant_code.'" />
					<input type="hidden" name="username" value="'.$username.'" />
					<input type="hidden" name="authToken" value="'.$_SESSION['authToken'].'" />
					</form>
					';
					echo "<script language=\"javascript\" type=\"text/javascript\">
							document.addEventListener('DOMContentLoaded', (event) => {
								window.open('', 'TheWindow');
                                document.getElementById('TheForm').submit();
							});
					</script>";		
				}
			}

			echo "<div class='col-md-12 table-responsive' style='max-height:900px;overflow-y:scroll;'>
					<h3><label class='label label-info'>Select an User to Start Scanning:</label></h3>
					<table class='table table-bordered'>
						<tr><th>Employee ID</th><th>Call Name</th><th>Control</th></tr>";
						$sql_schedule="select emp_call_name,team_id,emp_id from $pms.tbl_fg_crt_handover_team_list where  plant_code='$plant_code' and emp_status=0 order by 1*emp_id";
						$sql_result_schedule=mysqli_query($link, $sql_schedule) or exit("Sql Error_schedule$sql_schedule".mysqli_error($GLOBALS["___mysqli_ston"]));
						while($sql_row_schedule=mysqli_fetch_array($sql_result_schedule))
						{
							$url = getFullURL($_GET['r'],'carton_scan_select_user.php','N');
							echo "<tr>
									<td>".$sql_row_schedule['emp_id']."</td>
									<td>".$sql_row_schedule['emp_call_name']."</td>
									<td><a href=\"$url&select=1&shift=".$_GET['shift']."&operation_id=".$_GET['operation_id']."&team_id=".$sql_row_schedule['team_id']."&emp_id=".$sql_row_schedule['emp_id']."&random=".date("YmdHis").rand(0,99999)."\" class='btn btn-info btn-sm'>Select</a>
									</td>
								</tr>";
						}
				echo "</table>
				</div>";
		?>
	</div>
</div>