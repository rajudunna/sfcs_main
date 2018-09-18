	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<!-- then dataTables -->
<link href="https://cdn.datatables.net/1.10.13/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />   

<script src="https://cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js"></script>
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

	$sql = "SELECT * FROM $bai_pro3.`module_master`";
	$result = $conn->query($sql);
	$sno = 1;
	$url=getFullURL($_GET['r'],'add_module.php','N');
	$url1=getFullURL($_GET['r'],'delete_module.php','N');
	if ($result->num_rows > 0) {
		echo "<table id='module_master' class='table'>
		<thead>
		<tr>
		<th>S.No</th>
		<th>Section Name</th>
		<th>Module Name</th>
		<th>Module Description</th>
		<th>Status</th>
		<th> Edit / Delete </th>
		</tr>
		</thead>
		<tbody>";
		// output data of each row
		while($row = $result->fetch_assoc()) {
			$rowid=$row["id"];
			$module_name=$row["module_name"];
			$status=$row["status"];
			$section=$row["section"];
			$module_description=$row["module_description"];
			
			echo "<tr>
			<td>".$sno++."</td>
			<td>".$row["section"]."</td>
			<td>".$row["module_name"]."</td>
			<td>".$row["module_description"]."</td>
			<td>".$row["status"]." </td>
			<td><a href='$url&rowid=$rowid&module_name=$module_name&section=$section&status=$status&module_description=$module_description' class='btn btn-warning btn-xs editor_edit'>Edit</a> / <a href='$url1&rowid1=$rowid&&module_name=$module_name&section=$section' class='btn btn-danger btn-xs editor_remove'>Delete</a></td>
			</tr>";
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
    $('#module_master').DataTable();
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