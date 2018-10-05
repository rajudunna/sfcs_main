	<?php
	// $alert_msg = $_REQUEST['error_msg'];
	// if($alert_msg){
	// 	echo "<script>swal('Enter data correctly.')</script>";
	// }
	include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));

	$sql = "SELECT * FROM bai_rm_pj1.`inspection_supplier_db`";
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	$norows = mysqli_num_rows($sql_result);
	$sno = 1;

	
	if ($norows > 0) {
		echo "<table id='tbl_packing_method' class='table'><thead><tr><th>S.No</th><th>Product Code</th><th>Supplier Code</th><th>Complaint No </th><th>Supplier M3 Code</th><th>Color Code</th><th>Sequence No</th><th> Edit / Delete </th></tr></thead><tbody>";
		// output data of each row
		while($row=mysqli_fetch_array($sql_result)) {
			$product_code=$row["product_code"];
			$tid=$row["tid"];
			$supplier_code=$row["supplier_code"];
			$complaint_no=$row["complaint_no"];
			$supplier_m3_code=$row["supplier_m3_code"];
			$color_code=$row["color_code"];
			$color_code = str_replace("#"," ",$row["color_code"]);
			$seq_no=$row["seq_no"];
			$edit_url = getFullURL($_GET['r'],'save_suppliers_master_data.php','N');
			$delete_url = getFullURL($_GET['r'],'delete_suppliers_master_data.php','N');
			echo "<tr><td>".$sno++."</td><td>".$row["product_code"]." </td><td>".$row["supplier_code"]."</td><td>".$row["complaint_no"]."</td><td>".$row["supplier_m3_code"]."</td><td>".$row["color_code"]."</td><td>".$row["seq_no"]."</td><td><a href='$edit_url&tid=$tid&product_code=$product_code&supplier_code=$supplier_code&complaint_no=$complaint_no&supplier_m3_code=$supplier_m3_code&color_code=$color_code&seq_no=$seq_no' class='btn btn-warning btn-xs editor_edit'>Edit</a> / 
			<a href='$delete_url&tid=$tid&product_code=$product_code&supplier_code=$supplier_code&complaint_no=$complaint_no&supplier_m3_code=$supplier_m3_code&color_code=$color_code&seq_no=$seq_no' class='btn btn-danger btn-xs' onclick='return confirm_delete(event,this);'>Delete</a></td></tr>";
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