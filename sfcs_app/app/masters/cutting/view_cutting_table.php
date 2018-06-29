<?php
	// $servername = "192.168.0.110:3326";
	// $username = "baiall";
	// $password = "baiall";
	// $dbname = "bai_pro3";
	include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config.php');
	$conn=$link;

	// Create connection
	// $conn = new mysqli($servername, $username, $password, $dbname);
	// Check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	} 

	$sql = "SELECT * FROM $bai_pro3.`tbl_cutting_table`";
	$result = $conn->query($sql);
	$sno =1;
	$url=getFullURL($_GET['r'],'cutting_table_add.php','N');
	$url1=getFullURL($_GET['r'],'delete_cutting_table.php','N');
	if ($result->num_rows > 0) {
		echo "<form name ='delete'>";
		echo "<table id='tbl_cutting_table' class='table'><thead><tr><th>S.No</th><th>Table Name</th><th>Status</th><th> Edit / Delete </th></tr></thead><tbody>";
		// output data of each row
		while($row = $result->fetch_assoc()) {
			$rowid=$row["tbl_id"];
			$tbl_name=$row["tbl_name"];
			$status=$row["status"];
			echo "<tr><td>".$sno++."</td><td>".$row["tbl_name"]." </td><td>".$row["status"]."</td><td><a href='$url&rowid=$rowid&tbl_name=$tbl_name&status=$status' class='btn btn-warning btn-xs editor_edit'>Edit</a> / <a href='$url1&rowid=$rowid' class='btn btn-danger btn-xs editor_remove'>Delete</a></td></tr>";
		}
		echo "</tbody></table>";
	} else {
		echo "0 results";
	}
	$conn->close();
	?>


<script>
$(document).ready(function() {
    $('#tbl_cutting_table').DataTable();
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