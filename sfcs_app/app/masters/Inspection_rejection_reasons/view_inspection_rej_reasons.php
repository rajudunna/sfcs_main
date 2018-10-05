	<?php
	// $alert_msg = $_REQUEST['error_msg'];
	// if($alert_msg){
	// 	echo "<script>swal('Enter data correctly.')</script>";
	// }
	include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));

	$sql = "SELECT * FROM bai_rm_pj1.`reject_reasons`";
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	$norows = mysqli_num_rows($sql_result);
	if ($norows > 0) {
		echo "<div class='col-md-12 col-sm-12 col-xs-12' style='min-height:10px;'>";
		echo "<table id='tbl_packing_method' class='table'><thead><tr><th>S.No</th><th>Rejection code</th><th>Rejection Description</th><th> Edit / Delete </th></tr></thead><tbody>";
		// output data of each row
		while($row=mysqli_fetch_array($sql_result)) {
			$rej_code=$row["reject_code"];
			$tid=$row["tid"];
			$rej_desc=$row["reject_desc"];
			
			$edit_url = getFullURL($_GET['r'],'save_inspection_rej_reasons.php','N');
			$delete_url = getFullURL($_GET['r'],'delete_inspection_rej_reasons.php','N');
			echo "<tr><td>".++$start."</td><td>".$row["reject_code"]." </td><td>".$row["reject_desc"]."</td><td><a href='$edit_url&tid=$tid&reject_code=$rej_code&reject_desc=$rej_desc' class='btn btn-warning btn-xs editor_edit'>Edit</a> / 
			<a href='$delete_url&tid=$tid&reject_code=$rej_code&reject_desc=$rej_desc' class='btn btn-danger btn-xs' onclick='return confirm_delete(event,this);'>Delete</a></td></tr>";
		}
		echo "</tbody></table>";
	} else {
		echo "0 results";
	}
	// echo "<script>swal('Enter data correctly.')</script>";
	echo "</div>";
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