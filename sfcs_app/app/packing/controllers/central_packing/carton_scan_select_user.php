<?php 
	include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));
	
	if ($_GET['operation_id']) {
		$operation_id = $_GET['operation_id'];
		$shift = $_GET['shift'];
	} else {
		$operation_id = 200;
		$shift = 'G';
	}
	$pack_method='';
	$packing_team='';
	$select_pack_method='No';				
?>
<script language="javascript" type="text/javascript">
	
	var url2 = '<?= getFullURL($_GET['r'],'carton_scan_decentral_packing.php','R'); ?>';
	function go_to_scan()
	{
		emp_id=document.getElementById('emp_id').value;
		team_id=document.getElementById('team_id').value;
		operation_id=document.getElementById('operation_id').value;
		shift=document.getElementById('shift').value;
		pack_method=document.getElementById('pack_method').value;
		pack_team=document.getElementById('pack_team').value;
		window.open(url2+'?emp_id='+emp_id+'&team_id='+team_id+'&operation_id='+operation_id+'&shift='+shift+'&pack_team='+pack_team+'&pack_method='+pack_method,'','width=1000,height=500');
	}
</script>
<style>
	th,td
	{
		text-align:center;
	}
</style>

<div class="panel panel-primary">
	<div class="panel-heading">Handover person Selection Screen</div>
	<div class="panel-body">
		<?php
			if(isset($_GET['select']))
			{
				$team_id=$_GET['team_id'];
				$shift=$_GET['shift'];
				$emp_id=$_GET['emp_id'];
				$operation_id=$_GET['operation_id'];
				$sql_schedule="update bai_pro3.tbl_fg_crt_handover_team_list set selected_user=USER(), lastup='".date("Y-m-d H:i:s")."' where team_id=$team_id and emp_id='$emp_id'";
				// echo $sql_schedule;
				mysqli_query($link, $sql_schedule) or exit("Sql Error_schedule".mysqli_error($GLOBALS["___mysqli_ston"]));
				if($select_pack_method=='Yes')
				{					
					//echo "<table class='table table-bordered'><tr>";
					echo "<form name=\"pac_method\" action=\"#\" method=\"post\" class='form-inline'>
					<table class='table table-bordered'><tr><td><label>Select Pack Method: </label></td><td colspan =2>
					<input type=\"hidden\" id=\"team_id\" name=\"team_id\" value=\"$team_id\">
					<input type=\"hidden\" id=\"shift\" name=\"shift\" value=\"$shift\">
					<input type=\"hidden\" id=\"emp_id\" name=\"emp_id\" value=\"$emp_id\">
					<input type=\"hidden\" id=\"operation_id\" name=\"operation_id\" value=\"$operation_id\">";
					echo "<select  name=\"pack_method\" id=\"pack_method\" class='form-control' onchange=\"firstbox();\" >";
					$sql="select * from $brandix_bts.packing_method_master where status='Active'";
					$sql_result=mysqli_query($link, $sql) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
					while($sql_row=mysqli_fetch_array($sql_result))
					{
						if(str_replace(" ","",$sql_row['packing_method_code'])==str_replace(" ","",$pack_method))
						{
							echo "<option value=\"".$sql_row['packing_method_code']."\" selected>".$sql_row['packing_method_code']." - ".$sql_row['packing_description']."</option>";
						}
						else
						{
							echo "<option value=\"".$sql_row['packing_method_code']."\">".$sql_row['packing_method_code']." - ".$sql_row['packing_description']."</option>";
						}
					}
					echo "</select></td><td><label>Select Packing Team:</label></td><td>";
					// Schedule
					echo "<select class='form-control' name=\"pack_team\" id=\"pack_team\" >";
					$sql="select * from $brandix_bts.packing_team_master where status='Active'";
					$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
					while($sql_row=mysqli_fetch_array($sql_result))
					{
						if(str_replace(" ","",$sql_row['packing_team'])==str_replace(" ","",$pack_team))
						{
							echo "<option value=\"".$sql_row['packing_team']."\" selected>".$sql_row['packing_team']."</option>";
						}
						else
						{
							echo "<option value=\"".$sql_row['packing_team']."\">".$sql_row['packing_team']."</option>";
						}
					}
					echo "</select></td><td><input type='submit' name='submit' id='submit' class='btn btn-success' value='Click to Move' onclick= 'go_to_scan();'></td></tr></table>";
					?>
					&nbsp;&nbsp;
					</form>
					<br><br>
					<?php					
						
				}
				else
				{	
					$url = getFullURL($_GET['r'],'carton_scan_decentral_packing.php','R');
					echo "<script language=\"javascript\" type=\"text/javascript\">
							window.open('$url?emp_id=$emp_id&team_id=$team_id&pack_method=0&pack_team=0','','width=1000,height=500');
					</script>";
				}
			}
			else
			{
				echo "<div class='col-md-12 table-responsive' style='max-height:900px;overflow-y:scroll;'>
						<h3><label class='label label-info'>Select an User to Start Scanning:</label></h3>
						<table class='table table-bordered'>
						<tr><th>Employee ID</th><th>Call Name</th><th>Control</th></tr>";
						$sql_schedule="select * from bai_pro3.tbl_fg_crt_handover_team_list where emp_status=0 order by 1*emp_id";
						$sql_result_schedule=mysqli_query($link, $sql_schedule) or exit("Sql Error_schedule$sql_schedule".mysqli_error($GLOBALS["___mysqli_ston"]));
						while($sql_row_schedule=mysqli_fetch_array($sql_result_schedule))
						{
							$url = getFullURL($_GET['r'],'carton_scan_select_user.php','N');
							echo "<tr>
							<td>".$sql_row_schedule['emp_id']."</td>
							<td>".$sql_row_schedule['emp_call_name']."</td>
							<td><a href=\"$url&select=1&shift=".$shift."&operation_id=".$operation_id."&team_id=".$sql_row_schedule['team_id']."&emp_id=".$sql_row_schedule['emp_id']."&random=".date("YmdHis").rand(0,99999)."\" class='btn btn-info btn-sm'>Select</a>
							</td>
							</tr>";
						}
				echo "</table>
			</div>";
			}
		?>
	</div>
</div>
