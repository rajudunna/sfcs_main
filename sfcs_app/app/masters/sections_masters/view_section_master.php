<script src="/sfcs_app/common/js/jquery-1.11.1.min.js"></script>
<link href="/sfcs_app/common/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />  
<script src="/sfcs_app/common/js/jquery.dataTables.min.js"></script>
	<?php
	
	include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config.php');
	$conn=$link;
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	} 

	$sql = "SELECT * FROM $bai_pro3.`sections_master`";
	$result = $conn->query($sql);
	$sno = 1;
	$url=getFullURL($_GET['r'],'add_section_master.php','N');
	$url1=getFullURL($_GET['r'],'delete_section_master.php','N');
	if ($result->num_rows > 0) {
		echo "<table id='section_master' class='table'>
		<thead>
		<tr>
		<th>S.No</th>
		<th>Section Name</th>
		<th>IMS Priority Boxs</th>
		<th> Edit </th>
		</tr>
		</thead>
		<tbody>";
		// output data of each row
		while($row = $result->fetch_assoc()) {
			$rowid=$row["sec_id"];
			$sec_name=$row["sec_name"];
			$ims_priority_boxs=$row["ims_priority_boxs"];
			
			echo "<tr>
			<td>".$sno++."</td>
			<td>".$row["sec_name"]."</td>
			<td>".$row["ims_priority_boxs"]."</td>
			<td><a href='$url&rowid=$rowid&sec_name=$sec_name&ims_priority_boxs=$ims_priority_boxs' class='btn btn-warning btn-xs editor_edit'>Edit</a></td>
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
    $('#section_master').DataTable();
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