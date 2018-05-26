<?php include('../'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));	?>
<?php include('../'.getFullURLLevel($_GET['r'],'common/php/header_scripts.php',1,'R') );  ?>
<?php include('../'.getFullURLLevel($_GET['r'],'common/config/user_acl_v1.php',3,'R') );  ?>
<?php include('../'.getFullURLLevel($_GET['r'],'common/config/group_def.php',3,'R') );  ?>
<?php include('../'.getFullURLLevel($_GET['r'],'session_track.php',0,'R') );    ?>
<?php 
//Date:2016-02-08/kirang/SR#64304318/Added Error mail function to the error part of sql queries 
//Date:2016-02-12/kirang/SR#64304318/Added an array to Store the result of packing pending schedules and giving this as input in creating of temp tables. which reduce the query response time and avoid sql errors.

$view_access=user_acl("SFCS_0116",$username,1,$group_id_sfcs); 
?>

<style>
	th,td{
		text-align:center;
	}
</style>


<div class="panel panel-primary">
<div class="panel-heading">Carton Check Point - Select Handover User</div>
<div class="panel-body">

<?php
if(isset($_GET['select']))
{
	if($_GET['select']==1)
	{
		$team_id=$_GET['team_id'];
		$emp_id=$_GET['emp_id'];
		$sql_schedule="update tbl_fg_crt_handover_team_list set selected_user=USER(), lastup='".date("Y-m-d H:i:s")."' where team_id=$team_id and emp_id='$emp_id'";
		// echo $sql_schedule;
		mysqli_query($link, $sql_schedule) or exit("Sql Error_schedule".mysqli_error($GLOBALS["___mysqli_ston"]));
		$url = getFullURL($_GET['r'],'packing_check_point_gateway.php','N');
		//echo $url;
		// header("Location: ".$url);
		echo '<script>
				window.location.href="'.$url.'";
		</script>';
		
	}
	else
	{
		$url = getFullURL($_GET['r'],'packing_check_point_gateway.php','N');
		//echo $sql;
		// header('Location:'.$sql);
		echo '<script>
				window.location.href="'.$url.'";
		</script>';
	}
	
}

?>


<?php
//if(strlen($current_session_user)>0 and $current_session_user!="stop")
//{
	//echo "<h2>This session is currently operating by $current_session_user, Please contact user to unlock his session.</h2>";
	
//}else
{
	echo "<div class='col-md-12 table-responsive' style='max-height:900px;overflow-y:scroll;'><table class='table table-bordered'>";
	echo "<tr><th>EMP ID</th><th>Call Name</th><th>Control</th></tr>";
	$sql_schedule="select * from tbl_fg_crt_handover_team_list where emp_status=0 order by 1*emp_id";
	$sql_result_schedule=mysqli_query($link, $sql_schedule) or exit("Sql Error_schedule$sql_schedule".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row_schedule=mysqli_fetch_array($sql_result_schedule))
	{
		$url = getFullURL($_GET['r'],'packing_check_point_handover_select.php','N');
		echo "<tr><td>".$sql_row_schedule['emp_id']."</td><td>".$sql_row_schedule['emp_call_name']."</td><td>
			<a href=\"$url&select=1&team_id=".$sql_row_schedule['team_id']."&emp_id=".$sql_row_schedule['emp_id']."&random=".date("YmdHis").rand(0,99999)."\" class='btn btn-info btn-sm'>Select</a>
		</td></tr>";
	}
	echo "</table></div>";
	
	//echo "<h4><a href=\"packing_check_point_handover_select.php?select=0\">Skip</a>   </h4>";
}
?>

</div>
</div>

