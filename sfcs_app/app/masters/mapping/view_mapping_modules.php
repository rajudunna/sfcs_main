	
<!-- then dataTables -->
<link href="https://cdn.datatables.net/1.10.13/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />   

<script src="https://cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js"></script>
	<?php

	include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config.php');
	$conn=$link;
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	} 

	$sql = "SELECT m.id,mo.module_name,s.sec_head FROM $bai_pro3.mappings_master m left join module_master mo on mo.id=m.module_id left join sections_db s on s.sec_id=m.section_id";
	$result = $conn->query($sql);
	$sno = 1;
	$url=getFullURL($_GET['r'],'add_mapping_module.php','N');
	$url1=getFullURL($_GET['r'],'delete_mapping_module.php','N');
	if ($result->num_rows > 0) {
		echo "<table id='module_master' class='table1'>
		<thead>
		<tr>
		<th>S.No</th>
		<th>Section</th>
		<th>Module</th>
		<th>Delete</th>
		</tr>
		</thead>
		<tbody>";
		// output data of each row
		while($row = $result->fetch_assoc()) {
			$rowid=$row["id"];
			$sec_head=$row["sec_head"];
			$module_name=$row["module_name"];
			echo "<tr>
			<td>".$sno++."</td>
			<td>".$row["sec_head"]."</td>
			<td>".$row["module_name"]."</td>
			<td><a href='$url1&rowid1=$rowid' class='btn btn-danger btn-xs editor_remove'>Delete</a></td>
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
#module_master th
{
	border: 1px solid grey;
	text-align: center;
    background-color: #003366;
	color: WHITE;
	white-space:nowrap; 
	padding-left: 5px;
	padding-right: 5px;
}
#module_master{
	white-space:nowrap; 
	border-collapse:collapse;
	font-size:12px;
	background-color: white;
}
#module_master tr
{
	border: 1px solid grey;
	text-align: right;
	white-space:nowrap; 
}

#module_master td
{
	border: 1px solid grey;
	text-align: center;
	white-space:nowrap;
	color:black;
}
</style>