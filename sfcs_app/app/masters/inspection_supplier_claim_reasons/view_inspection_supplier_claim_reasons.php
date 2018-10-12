	<?php
	// $alert_msg = $_REQUEST['error_msg'];
	// if($alert_msg){
	// 	echo "<script>swal('Enter data correctly.')</script>";
	// }
	include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));

	$sql = "SELECT * FROM bai_rm_pj1.inspection_complaint_reasons";
	//echo $sql;
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	$norows = mysqli_num_rows($sql_result);
	$sno = 1; 

	if ($norows > 0) {
		echo "<table id='tbl_packing_method' class='table'><thead><tr><th>S.No</th><th>Complaint Reason</th><th>Complaint Classification</th><th>Complaint Category</th><th>Status</th><th> Edit / Delete </th></tr></thead><tbody>";
	
		while($row=mysqli_fetch_array($sql_result)) {
			$complaint_reason=$row["complaint_reason"];
			$tid=$row["sno"];
			$complaint_clasification=$row["Complaint_clasification"];
			$complaint_category=$row["complaint_category"];			
			$status = $row['status'];
			if($status == 0) 
			{
				$cat_status = "Active";
			}else{ 
				$cat_status = "In-Active";
			}
			 
			
			$edit_url = getFullURL($_GET['r'],'save_inspection_supplier_claim_reasons.php','N');
			//echo hii;
			$delete_url = getFullURL($_GET['r'],'delete_inspection_supplier_claim_reasons.php','N');
			echo "<tr><td>".$sno++."</td><td>".$row["complaint_reason"]." </td><td>".$row["Complaint_clasification"]."</td><td>".$row["complaint_category"]."</td><td>".$cat_status."</td>
			<td><a href='$edit_url&tid=$tid&complaint_reason=$complaint_reason&complaint_clasification=$complaint_clasification&complaint_category=$complaint_category&status=$cat_status' class='btn btn-warning btn-xs editor_edit'>Edit</a> / 
			<a href='$delete_url&tid=$tid&complaint_reason=$complaint_reason&complaint_clasification=$complaint_clasification&complaint_category=$complaint_category&status=$cat_status' class='btn btn-danger btn-xs' onclick='return confirm_delete(event,this);'>Delete</a></td></tr>";
		}
		echo "</tbody></table>";
	} else {
		echo "0 results";
	}
	
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