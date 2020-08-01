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
	$temp=1;
	$sql = "SELECT section_display_name,section_head AS sec_head,ims_priority_boxs,GROUP_CONCAT(`module_name` ORDER BY module_name+0 ASC) AS sec_mods,section AS sec_id FROM $bai_pro3.`module_master` LEFT JOIN $bai_pro3.sections_master ON module_master.section=sections_master.sec_name WHERE section>0 GROUP BY section ORDER BY section + 0";
	$result = $conn->query($sql);
	$url=getFullURL($_GET['r'],'add_section.php','N');
	$url1=getFullURL($_GET['r'],'delete.php','N');
	if ($result->num_rows > 0) {
		echo "<div class='table-responsive'><table id='tbl_packing_method' class='table'><thead><tr><th>S.No</th><th>Section</th><th>Section Modules</th><th>IMS Priority Boxes</th></tr></thead><tbody>";
		// output data of each row
		while($row = $result->fetch_assoc()) {
			$rowid=$row["sec_id"];
			$sec_head=$row["sec_head"];
			$sec_mods=$row["sec_mods"];
			$section_display_name=$row["section_display_name"];
			$ims_priority_boxs=$row["ims_priority_boxs"];
			if($sec_head!='Admin'){
			echo "<tr><td>".$temp."</td><td>".$row["section_display_name"]." </td><td>".$row["sec_mods"]."</td><td>".$row["ims_priority_boxs"]."</td>";
			//echo"<td><a href='$url&rowid=$rowid&sec_head=$sec_head&sec_mods=$sec_mods&ims_priority_boxes=$ims_priority_boxes' class='btn btn-warning btn-xs editor_edit'>Edit</a> / 
			//<a href='$url1&rowid=$rowid&sec_head=$sec_head&sec_mods=$sec_mods&ims_priority_boxes=$ims_priority_boxes' class='btn btn-danger btn-xs editor_remove'>Delete</a></td></tr>";
			$temp++;
			}
		}
		echo "</table></div>";
	} else {
		echo "0 results";
	}
	$conn->close();
	?>


<script>
$(document).ready(function() {
    $('#tbl_packing_method').DataTable();
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