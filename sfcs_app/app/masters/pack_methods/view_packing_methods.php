	<?php
	// $servername = "192.168.0.110:3326";
	// $username = "baiall";
	// $password = "baiall";
	// $dbname = "bai_pro3";

	// Create connection
	// $conn = new mysqli($servername, $username, $password, $dbname);
	// Check connection
	include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config.php');
	$conn=$link;
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	} 
	$sql = "SELECT * FROM $bai_pro3.`pack_methods`";
	$result = $conn->query($sql);
	$url=getFullURL($_GET['r'],'add_packing_method.php','N');
	$url1=getFullURL($_GET['r'],'delete_packing_methods.php','N');
	if ($result->num_rows > 0) {
		echo "<table id='tbl_packing_method' class='table'><thead><tr><th>S.No</th><th>Packing Method</th><th>Status</th><th> Edit / Delete </th></tr></thead><tbody>";
		// output data of each row
		$i=0;
		while($row = $result->fetch_assoc()) {
			$i++;
			$rowid=$row["pack_id"];
			$pack_method_name=$row["pack_method_name"];
			$status=$row["status"];
			if($status==1){
				$status="Active";
			}else{
				$status="In-Active";
			}
			echo "<tr><td>".$i."</td><td>".$row["pack_method_name"]." </td><td>".$status."</td><td><a href='$url&rowid=$rowid&pack_method_name=$pack_method_name&status=$status' class='btn btn-warning btn-xs editor_edit'>Edit</a> / <a href='$url1==&rowid=$rowid&pack_method_name=$pack_method_name&status=$status' class='btn btn-danger btn-xs editor_remove' onclick='return confirm_delete(event,this);'>Delete</a></td></tr>";
		}
		echo "</tbody></table>";
	} else {
		echo "0 results";
	}
	$conn->close();
	?>


<script>
$(document).ready(function() {
    $('#tbl_packing_method').DataTable();
});
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