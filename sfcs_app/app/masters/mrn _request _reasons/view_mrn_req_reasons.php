	<?php
	// $alert_msg = $_REQUEST['error_msg'];
	// if($alert_msg){
	// 	echo "<script>swal('Enter data correctly.')</script>";
	// }
	include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));

	$sql = "SELECT * FROM bai_rm_pj2.`mrn_reason_db` order by reason_tid";
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	$norows = mysqli_num_rows($sql_result);
	if ($norows > 0) {
		echo "<table id='tbl_packing_method' class='table'><thead><tr><th>S.No</th><th>Reason code</th><th>Reason Description</th><th>Status</th><th> Edit / Delete </th></tr></thead><tbody>";
		// output data of each row
		while($row=mysqli_fetch_array($sql_result)) {
			$rej_code=$row["reason_code"];
			$tid=$row["reason_tid"];
			$rej_desc=$row["reason_desc"];
			$status = $row['status'];
			if($status == 0) 
			{
				$cat_status = "Active";
			}else{
				$cat_status = "In-Active";
			}
			
			$edit_url = getFullURL($_GET['r'],'save_mrn_req_reasons.php','N');
			$delete_url = getFullURL($_GET['r'],'delete_mrn_req_reasons.php','N');
			echo "<tr><td>".++$start."</td><td>".$row["reason_code"]." </td><td>".$row["reason_desc"]."</td><td>".$cat_status."</td><td><a href='$edit_url&reason_tid=$tid&reason_code=$rej_code&reason_desc=$rej_desc&status=$cat_status' class='btn btn-warning btn-xs editor_edit'>Edit</a> / 
			<a href='$delete_url&reason_tid=$tid&reason_code=$rej_code&reason_desc=$rej_desc&status=$cat_status' class='btn btn-danger btn-xs editor_remove'>Delete</a></td></tr>";
		}
		echo "</tbody></table>";
	} else {
		echo "0 results";
	}
	// echo "<script>swal('Enter data correctly.')</script>";
	?>


<script>
$(document).ready(function() {
    $('#tbl_packing_method').DataTable();
} );
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