	<?php
	// $alert_msg = $_REQUEST['error_msg'];
	// if($alert_msg){
	// 	echo "<script>swal('Enter data correctly.')</script>";
	// }
	include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));

	$sql = "SELECT * FROM bai_pro3.bai_qms_rejection_reason`";
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	$norows = mysqli_num_rows($sql_result);
	$sno = 1;

	
	if ($norows > 0) {
		echo "<table id='tbl_packing_method' class='table'><thead><tr><th>S.No</th><th>Reason Catagory</th><th>Reason Description</th><th>Reason Code</th><th>Reason Order</th><th>Form Type</th><th>M3 Reason Code</th><th> Edit / Delete </th></tr></thead><tbody>";
		// output data of each row
		while($row=mysqli_fetch_array($sql_result)) {
			$reason_cat=$row["reason_cat"];
			$sno=$row["sno"];
			$reason_desc=$row["reason_desc"];
			$reason_code=$row["reason_code"];
			$reason_order=$row["reason_order"];
			$form_type=$row["form_type"];
			$m3_reason_code=$row["m3_reason_code"];
			$edit_url = getFullURL($_GET['r'],'save_production_rejection_reasons.php','N');
			$delete_url = getFullURL($_GET['r'],'delete_production_rejection_reasons.php','N');
			echo "<tr><td>".$sno."</td><td>".$row["reason_cat"]." </td><td>".$row["reason_desc"]."</td><td>".$row["reason_code"]."</td><td>".$row["reason_order"]."</td><td>".$row["form_type"]."</td><td>".$row["m3_reason_code"]."</td><td><a href='$edit_url&sno=$sno&reason_cat=$reason_cat&reason_desc=$reason_desc&reason_code=$reason_code&reason_order=$reason_order&form_type=$form_type&m3_reason_code=$m3_reason_code' class='btn btn-warning btn-xs editor_edit'>Edit</a> / 
			<a href='$delete_url&sno=$sno&reason_cat=$reason_cat&reason_desc=$reason_desc&reason_code=$reason_code&reason_order=$reason_order&form_type=$form_type&m3_reason_code=$m3_reason_code' class='btn btn-danger btn-xs' onclick='return confirm_delete(event,this);'>Delete</a></td></tr>";
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