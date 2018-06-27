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

	$sql = "SELECT * FROM $bai_pro3.`sections_db`";
	$result = $conn->query($sql);

	if ($result->num_rows > 0) {
		echo "<div class='table-responsive'><table id='tbl_packing_method' class='table'><tr><th>S.No</th><th>Section</th><th>Section Modules</th><th>IMS Priority Boxes</th><th> Edit / Delete </th></tr>";
		// output data of each row
		while($row = $result->fetch_assoc()) {
			$rowid=$row["sec_id"];
			$sec_head=$row["sec_head"];
			$sec_mods=$row["sec_mods"];
			$ims_priority_boxes=$row["ims_priority_boxes"];
			
			echo "<tr><td>".$row["sec_id"]."</td><td>".$row["sec_head"]." </td><td>".$row["sec_mods"]."</td><td>".$row["ims_priority_boxes"]."</td><td><a href='/index.php?r=L3NmY3NfYXBwL2FwcC9tYXN0ZXJzL3NlY3Rpb25zL2FkZF9zZWN0aW9uLnBocA==&rowid=$rowid&sec_head=$sec_head&sec_mods=$sec_mods&ims_priority_boxes=$ims_priority_boxes' class='editor_edit'>Edit</a> / 
			<a href='/index.php?r=L3NmY3NfYXBwL2FwcC9tYXN0ZXJzL3NlY3Rpb25zL2RlbGV0ZS5waHA=&rowid=$rowid&sec_head=$sec_head&sec_mods=$sec_mods&ims_priority_boxes=$ims_priority_boxes' class='editor_remove'>Delete</a></td></tr>";
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