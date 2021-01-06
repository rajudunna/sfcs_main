	<?php
	// $alert_msg = $_REQUEST['error_msg'];
	// if($alert_msg){
	// 	echo "<script>swal('Enter data correctly.')</script>";
	// }
	include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
	$plant_code=$_SESSION['plantCode'];
	// $plant_code='N02';
	$username=$_SESSION['userName'];

	$sql = "SELECT emp_id,team_id,emp_call_name,selected_user,emp_status FROM $pms.tbl_fg_crt_handover_team_list where plant_code='$plant_code' order by team_id desc";
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	$norows = mysqli_num_rows($sql_result);
	$sno = 1; 
	if ($norows > 0) {
		echo "<div class='table-responsive'><table id='tbl_packing_method' class='table'><thead><tr><th>S.No</th><th>Employee Id</th><th>Employee Name</th><th>Selected User</th><th>Status</th><th> Edit / Delete </th></tr></thead><tbody>";
		// output data of each row
		while($row=mysqli_fetch_array($sql_result)) {
			$emp_id=$row["emp_id"];
			$team_id=$row["team_id"];
			$emp_call_name=$row["emp_call_name"];
			$selected_user=$row["selected_user"];
						
			$emp_status = $row['emp_status'];
			if($emp_status == 0) 
			{
				$cat_status = "Active";
			}else{
				$cat_status = "In-Active";
			}
			 
			
			$edit_url = getFullURL($_GET['r'],'save_handover_team_list.php','N');
			$delete_url = getFullURL($_GET['r'],'delete_handover_team_list.php','N');
			echo "<tr><td style='text-align:right;'>".$sno++."</td><td style='text-align:right;'>".$row["emp_id"]." </td><td style='text-align:left;'>".$row["emp_call_name"]."</td><td style='text-align:left;'>".$row["selected_user"]."</td><td style='text-align:left;'>".$cat_status."</td>
			<td><a href='$edit_url&team_id=$team_id&emp_id=$emp_id&emp_call_name=$emp_call_name&emp_status=$cat_status' class='btn btn-warning btn-xs editor_edit'>Edit</a> / 
			<a href='$delete_url&team_id=$team_id&emp_id=$emp_id&emp_call_name=$emp_call_name&selected_user=$selected_user&lastup=$lastup&emp_status=$cat_status' class='btn btn-danger btn-xs' onclick='return confirm_delete(event,this);'>Delete</a></td></tr>";
		}
		echo "</tbody></table></div>";
	} else {
		echo "0 results";
	}
	// echo "<script>swal('Enter data correctly.')</script>";
	?>


<script>
$(document).ready(function() {
    $('#tbl_packing_method').DataTable();
} );

function confirm_delete(e,t)
    {
        e.preventDefault();
        var v = sweetAlert({
        title: "Are you sure to Delete the Record?",
        icon: "warning",
        buttons: true,
        dangerMode: true,
        buttons: ["No, Cancel It!", "Yes, I am Sure!"],
        }).then(function(isConfirm){
        if (isConfirm) {
        window.location = $(t).attr('href');
        return true;
        } else {
        sweetAlert("Request Cancelled",'','error');
        return false;
        }
        });
    }
</script>
<style>
table th
{
	border: 1px solid grey;
	text-align: center;
    background-color: #003366;
	color: WHITE;
	white-space:nowrap; 
	padding-left: 5px;
	padding-right: 5px;
}
table{
	white-space:nowrap; 
	border-collapse:collapse;
	font-size:12px;
	background-color: white;
}
table tr
{
	border: 1px solid grey;
	text-align: right;
	white-space:nowrap; 
}

table td
{
	border: 1px solid grey;
	text-align: center;
	white-space:nowrap;
	color:black;
}
</style>