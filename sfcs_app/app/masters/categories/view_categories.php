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

	$sql = "SELECT * FROM $bai_pro3.`tbl_category`";
	$result = $conn->query($sql);
	$sno = 1;
	$url=getFullURL($_GET['r'],'add_categories.php','N');
	$url1=getFullURL($_GET['r'],'delete_categories.php','N');
	if ($result->num_rows > 0) {
		echo "<table id='downtime_reason' class='table'><thead><tr><th>S.No</th><th>Category Name</th><th>Status</th><th>Category Selection</th><th> Edit / Delete </th></tr></thead><tbody>";
		// output data of each row
		while($row = $result->fetch_assoc()) {
			$rowid=$row["id"];
			$cat_name=$row["cat_name"];
			$status=$row["status"];
			if($status == 1){
				$cat_status = "Active";
			}else{
				$cat_status = "In-Active";
			}
			$cat_selection=$row["cat_selection"];
			
			echo "<tr><td>".$sno++."</td><td>".$row["cat_name"]."</td><td>".$cat_status." </td><td>".$row["cat_selection"]."</td><td><a href='$url&rowid=$rowid&cat_name=$cat_name&status=$status&cat_selection=$cat_selection' class='btn btn-warning btn-xs editor_edit'>Edit</a> / <a href='$url1&rowid1=$rowid' class='btn btn-danger btn-xs editor_remove' onclick='return confirm_delete(event,this);'>Delete</a></td></tr>";
		}

		echo "</tbody></table>";
	} else {
		echo "0 results";
	}
	$conn->close();
	?>
<!-- /index.php?r=L3NmY3NfYXBwL2FwcC9tYXN0ZXJzL2NhdGVnb3JpZXMvYWRkX2NhdGVnb3JpZXMucGhw -->

<script>
$(document).ready(function() {
    $('#downtime_reason').DataTable();
	
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