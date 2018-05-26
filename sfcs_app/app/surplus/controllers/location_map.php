<?php
	include('../'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
	include('../'.getFullURLLevel($_GET['r'],'common/config/user_acl_v1.php',3,'R'));
	include('../'.getFullURLLevel($_GET['r'],'common/config/group_def.php',3,'R'));
?>

<script type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/tablefilter.js',3,'R'); ?>"></script>

<div class="panel panel-primary">
	<div class="panel-heading">Location MAP</div>
	<div class="panel-body">
		<div class="col-sm-12" style='overflow-x:auto;overflow-y:auto;max-height:600px;'>
			<?php
				include("surplus_auto_correct_function.php");

				$table="<table class='table table-bordered table-stripped' id='table1'>";
				$table.="<thead>";
				$table.="<tr class='success'>";
				$table.='<th><center>S.NO</center></th>';
				$table.='<th><center>Location ID</center></th>';
				$table.="<th><center>Description</center></th>";
				$table.="<th><center>Capacity</center></th>";
				$table.="<th><center>Filled</center></th>";
				$table.="<th><center>Balance</center></th>";
				$table.="</tr>";
				$table.="</thead><tbody>";
				echo $table;
				$i=1;

				$sql="select * from $bai_pro3.bai_qms_location_db where location_type in (0,1) and active_status=0 order by qms_cur_qty desc,order_by desc";
				$sql_result=mysqli_query($link, $sql) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
				if(mysqli_num_rows($sql_result)>0){
					while($sql_row=mysqli_fetch_array($sql_result))
					{
						
						$table="<tr><td ><center>".$i."</center></td><td><center><a class='btn btn-info btn-xs' href='".getFullURL($_GET['r'],'location_update.php','N')."&location=".$sql_row['qms_location_id']."'>".$sql_row['qms_location_id']."</a></center></td>";
						$table.="<td><center>".$sql_row['qms_location']."</center></td>";
						$table.="<td><center>".$sql_row['qms_location_cap']."</center></td>";
						surplus_auto_correct($sql_row['qms_location_id'],$link);
						$table.="<td><center>".$sql_row['qms_cur_qty']."</center></td>";
						$table.="<td><center>".($sql_row['qms_location_cap']-$sql_row['qms_cur_qty'])."</center></td>";
						
						$table.="</tr>";
						
						echo $table;
						$i++;
					}
					echo '<tr><td colspan=4>Total Filled Quantity:</td><td id="table1Tot1" style="background-color:#FFFFCC; color:red;"></td></tr>';
					$table='</tbody></table>';
					echo $table;
					echo "</br>";
				}
				else {
					$table="<tr><td colspan=6><div class='alert alert-danger' style='text-align:center'><strong>No Data</strong> Found!</div></td></tr>";
					echo $table;
					$table='</tbody></table>';
					echo $table;
				}
			?>
		</div>
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
							col: [4],  
							operation: ["sum"],
							decimal_precision: [1],
							write_method: ["innerHTML"] 
						},
		rows_always_visible: [grabTag(grabEBI('table1'),"tr").length]	
	};
	 setFilterGrid("table1",fnsFilters);

	$(document).ready(function(){
		$('#reset_table1').addClass('btn btn-warning btn-xs');
	});
</script>

<style>
#reset_table1{
	width : 80px;
	color : #fff;
	margin : 10px;
}
</style>






