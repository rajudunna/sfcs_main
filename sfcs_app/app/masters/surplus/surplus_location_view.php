<?php
	// $servername = "192.168.0.110:3326";
	// $username = "baiall";
	// $password = "baiall";
	// $dbname = "bai_pro2";

	// Create connection
	// $conn = new mysqli($servername, $username, $password, $dbname);
	// Check connection
	include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config.php');
	$conn=$link;
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	} 

	$sql = "SELECT * FROM $pms.bai_qms_location_db";
	$result = $conn->query($sql);
	$sno = 1;
	$url=getFullURL($_GET['r'],'surplus_table.php','N');
	$url1=getFullURL($_GET['r'],'surplus_location_delete.php','N');
	if ($result->num_rows > 0) {
		echo "<table id='qms_locate' class='table'><thead><tr><th>S.No</th><th>Location Id</th><th>Location</th><th>Capacity</th><th>Quantity</th><th>Status</th><th> Edit / Delete </th></tr></thead><tbody>";
		// output data of each row
		while($row = $result->fetch_assoc()) 
		{
	        $q_id = $row['q_id'];
	        $q_location_type = $row['location_type'];
			$qms_location_id=$row['qms_location_id'];
			$qms_location=$row['qms_location'];
			$qms_location_cap=$row['qms_location_cap'];
			$qms_cur_qty = $row['qms_cur_qty'];
			$active_status = $row['active_status'];
			if($active_status == 0)
			{
				$cat_status = "Active";
			}else{
				$cat_status = "In-Active";
			}
			echo "<tr><td>".$sno++."</td><td>".$row["qms_location_id"]."</td><td>".$row["qms_location"]."</td><td>".$row["qms_location_cap"]." </td><td>".$row["qms_cur_qty"]."</td><td>".$cat_status."</td>
			<td><a href='$url&rowid=$q_id&qms_location_id=$qms_location_id&qms_location=$qms_location&qms_location_cap=$qms_location_cap&qms_cur_qty=$qms_cur_qty&active_status=$cat_status&q_location_type=$q_location_type' class='btn btn-warning btn-xs editor_edit'>Edit</a> /
			 <a href='$url1&rowid=$q_id&qms_location_id=$qms_location_id&qms_location=$qms_location&qms_location_cap=$qms_location_cap&qms_cur_qty=$qms_cur_qty&active_status=$cat_status&q_location_type=$q_location_type' class='btn btn-danger btn-xs' onclick='return confirm_delete(event,this);'>Delete</a></td></tr>";
		}
		echo "</tbody></table>";
	} else {
		echo "0 results";
	}
	$conn->close();
	?>


<script>
$(document).ready(function() {
    $('#qms_locate').DataTable();
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