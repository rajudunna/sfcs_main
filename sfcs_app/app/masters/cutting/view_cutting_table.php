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

	$sql = "SELECT * FROM bai_pro3.`tbl_cutting_table`";
	$result = $conn->query($sql);
	$sno =1;
	if ($result->num_rows > 0) {
		echo "<table id='tbl_cutting_table' class='table'><tr><th>S.No</th><th>Table Name</th><th>Status</th><th> Edit / Delete </th></tr>";
		// output data of each row
		while($row = $result->fetch_assoc()) {
			$rowid=$row["tbl_id"];
			$tbl_name=$row["tbl_name"];
			$status=$row["status"];
			echo "<tr><td>".$sno++."</td><td>".$row["tbl_name"]." </td><td>".$row["status"]."</td><td><a href='/index.php?r=L3NmY3NfYXBwL2FwcC9tYXN0ZXJzL2N1dHRpbmcvY3V0dGluZ190YWJsZV9hZGQucGhw&rowid=$rowid&tbl_name=$tbl_name&status=$status' class='editor_edit'>Edit</a> / <a href='/index.php?r=L3NmY3NfYXBwL2FwcC9tYXN0ZXJzL2N1dHRpbmcvZGVsZXRlX2N1dHRpbmdfdGFibGUucGhw&rowid=$rowid&tbl_name=$tbl_name&status=$status' class='editor_remove'>Delete</a></td></tr>";
		}
		echo "</table>";
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