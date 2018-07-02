	<?php
	// $servername = "192.168.0.110:3326";
	// $username = "baiall";
	// $password = "baiall";
	// $dbname = "bai_pro3";
<<<<<<< HEAD
	include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config.php');
	$conn = $link;
	
=======
>>>>>>> UAT2

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
<<<<<<< HEAD
			$url = getFullURLLevel($_GET['r'],'add_categories.php',0,'N');
			$url_delete = getFullURLLevel($_GET['r'],'delete_categories.php',0,'N');
			echo "<tr><td>".$sno++."</td><td>".$row["cat_name"]."</td><td>".$cat_status." </td><td>".$row["cat_selection"]."</td><td><a href='$url&rowid=$rowid&cat_name=$cat_name&status=$status&cat_selection=$cat_selection' class='editor_edit'>Edit</a> / <a href='$url_delete&rowid=$rowid' class='editor_remove'>Delete</a></td></tr>";
=======
			
			echo "<tr><td>".$sno++."</td><td>".$row["cat_name"]."</td><td>".$cat_status." </td><td>".$row["cat_selection"]."</td><td><a href='$url&rowid=$rowid&cat_name=$cat_name&status=$status&cat_selection=$cat_selection' class='btn btn-warning btn-xs editor_edit'>Edit</a> / <a href='$url1&rowid1=$rowid' class='btn btn-danger btn-xs editor_remove'>Delete</a></td></tr>";
>>>>>>> UAT2
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