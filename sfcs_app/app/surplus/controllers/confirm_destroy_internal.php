<?php

	include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
	// include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/user_acl_v1.php',3,'R'));
	include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/group_def.php',3,'R'));
	$Page_Id = 'SFCS_0403';
	// $view_access=user_acl("SFCS_0172",$username,1,$group_id_sfcs);
	$has_permission=haspermission($_GET['r']);

	if(in_array($authorized,$has_permission))
	{
		
	}
	else
	{
		header($_GET['r'],'restricted.php','N');
	}
?>

<script language="javascript" type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/TableFilter_EN/actb.js',3,'R'); ?>"></script><!-- External script -->
<script type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/TableFilter_EN/tablefilter.js',3,'R'); ?>"></script>

<script>

function enable_button()
{
	var checkedStatus = document.getElementById("enable").checked;
	
	if(checkedStatus===true)
	{
		document.getElementById("add").disabled=false;
	}
	else
	{
		document.getElementById("add").disabled=true;
		
	}
}

</script>



<div class='panel panel-primary'>
	<div class='panel-heading'>
		<b>Confirm Destroy (Internal)</b>
	</div>
	<div class='panel-body'>
		<form name="filter" method="post" action="?r=<?= $_GET['r'] ?>">
		<div class="row">
		<div class='col-sm-3'>
			<label for='schlist'>Schedule</label>
			<input class='form-control integer swal' type="text" value="" size="90" id="schedule" name="schlist" />
		</div>
		<div class='col-sm-3'>
			<br>
			<input type="checkbox" name="showall" value="1">(Y/N)Show all schedules.
		</div>
			<input type="submit" name="schsbt" value="Filter" class='btn btn-success' style="margin-top:22px;">
		</div>
		
		</form>
		<hr>

			<?php

			if(isset($_POST['confirm']))
			{
				$schedule=array_unique($_POST['sch_list']);

				for($i=0;$i<sizeof($schedule);$i++)
				{
						//To store the reserve locations cartons in remarks column in bai_qms_db details before destory not confirmation
						$sql="update bai_qms_db set remarks=location_id where qms_schedule='".$schedule[$i]."' and location_id<>'INTDESTROY' and qms_tran_type=13";
						// echo "</br>Update Remarks :".$sql."</br>";
						mysqli_query($link, $sql) or exit("Sql Error:$sql".mysqli_error($GLOBALS["___mysqli_ston"]));
						
						$sql="update bai_qms_db set location_id='INTDESTROY' where qms_schedule='".$schedule[$i]."' and location_id<>'INTDESTROY' and qms_tran_type=13";
						//echo "</br>Location Update : ".$sql."</br>";
						mysqli_query($link, $sql) or exit("Sql Error:$sql".mysqli_error($GLOBALS["___mysqli_ston"]));
						// echo "</br>==========</br>";
				}

				echo "<script>sweetAlert('Successfully Updated ','','success')</script>";
			}

			?>

			<?php


			if(isset($_POST['schsbt']))
			{
				$schlist = $_POST['schlist'];
				$showall = $_POST['showall'];
				$row_count = 0;
				$addfilter ="qms_schedule in ($schlist) and ";
				if($showall=="1")
				{
					$addfilter="";
				}

				if(strlen($schlist)>0 or $showall=="1")
				{

					//Serial number and Post variable index key
					$x=0;
					?>
					<form name="update" method="post" action="?r=<?= $_GET['r'] ?>">
						<?php
					$sql="
					select SUM(IF((qms_tran_type= 13 and location_id<>'INTDESTROY'),qms_qty,0)) as qms_qty,qms_style,qms_schedule,qms_color,qms_size,group_concat(qms_tid) as qms_tid, group_concat(concat(location_id,'-',qms_qty,' PCS<br/>')) as existing_location from ".$bai_pro3.".bai_qms_db where $addfilter location_id<>'INTDESTROY' and location_id<>'PAST_DATA' and qms_tran_type in (13) GROUP BY qms_tid order by qms_schedule,qms_color,qms_size
					";
					$sql_result=mysqli_query($link, $sql) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));

					echo '<input type="checkbox" name="enable" id="enable" onclick="enable_button()">
							Enable
						<input type="submit" name="confirm" class="btn btn-success" value="Confirm Destroy" id="add" disabled="true" onclick="enable_button()">
						<br><br>';

					$table="<div class='table-responsive' style='overflow:scroll;max-height:700px' id='table'><table class='table table-bordered' id='table1'>";
							$table.="<thead>";
							$table.="<tr class='warning'>";
							$table.='<th>SNo</th>';
							$table.="<th>Style</th>";
							$table.="<th>Schedule</th>";
							$table.="<th>Color</th>";
							$table.="<th>Size</th>";
							$table.="<th>Available Quantity</th>";
							$table.="<th>Existing Locations</th>";
							$table.="</tr>";
							$table.="</thead><tbody>";
							echo $table;

					while($sql_row=mysqli_fetch_array($sql_result))
					{
							if($sql_row['qms_qty']>0)
							{
								$row_count++;
								$table="<tr class='foo' id='rowchk$x'>";
								$table.="<td>".($x+1)."</td>";
								$table.="<td>".$sql_row['qms_style']."</td>";
								$table.="<td>".$sql_row['qms_schedule']."</td>";
								$table.="<td>".$sql_row['qms_color']."</td>";
								$table.="<td>".$sql_row['qms_size']."</td>";
								$table.="<td>".$sql_row['qms_qty']."</td>";
								$table.="<td>".$sql_row['existing_location']."</td>";
								$table.="</tr>";
								echo $table;
							}	
					}
					if($row_count>0){	
							echo '<tr><td colspan=5>Total Quantity:</td><td id="table1Tot1" style="background-color:#FFFFCC; color:red;"></td></tr>';
						$table='</tbody></table></div>';
					 echo $table;
					}
										// echo '<input type="checkbox" name="enable" id="enable" onclick="enable_button()">Enable<input type="submit" name="confirm" value="Confirm Destroy" id="add" disabled="true" onclick="enable_button()">';
			if($row_count == 0){
				echo '<script>sweetAlert("No Data found for the Entered Schedule/s","","warning");</script>';
			}
		}
	}
			

			?>
		</form>
	</div>
</div>

<script language="javascript" type="text/javascript">
	$('#reset_table1').addClass('btn btn-warning');
	var fnsFilters = {
		rows_counter: true,
		sort_select: true,
		btn_reset: true,
		alternate_rows: true,
		btn_reset_text: "Clear",
		col_operation: { 
							id: ["table1Tot1"],
							col: [5],  
							operation: ["sum"],
							 decimal_precision: [1],
							write_method: ["innerHTML"] 
						},
		rows_always_visible: [grabTag(grabEBI('table1'),"tr").length]	
	}
	setFilterGrid("table1",fnsFilters);

	$(document).ready(function(){
		$('#reset_table1').addClass('btn btn-warning btn-xs');
	});
	
</script>




