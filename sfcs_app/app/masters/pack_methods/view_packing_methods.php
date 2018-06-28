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
	$sql = "SELECT * FROM bai_pro3.`pack_methods`";
	$result = $conn->query($sql);

	if ($result->num_rows > 0) {
		echo "<table id='tbl_packing_method' class='table'><tr><th>S.No</th><th>Packing Method</th><th>Status</th><th> Edit / Delete </th></tr>";
		// output data of each row
		while($row = $result->fetch_assoc()) {
			$rowid=$row["pack_id"];
			$pack_method_name=$row["pack_method_name"];
			$status=$row["status"];
			if($status==1){
				$status="Active";
			}else{
				$status="In-Active";
			}
			echo "<tr><td>".$row["pack_id"]."</td><td>".$row["pack_method_name"]." </td><td>".$status."</td><td><a href='/index.php?r=L3NmY3NfYXBwL2FwcC9tYXN0ZXJzL3BhY2tfbWV0aG9kcy9hZGRfcGFja2luZ19tZXRob2QucGhw&rowid=$rowid&pack_method_name=$pack_method_name&status=$status' class='editor_edit'>Edit</a> / <a href='/index.php?r=L3NmY3NfYXBwL2FwcC9tYXN0ZXJzL3BhY2tfbWV0aG9kcy9kZWxldGVfcGFja2luZ19tZXRob2RzLnBocA==&rowid=$rowid&pack_method_name=$pack_method_name&status=$status' class='editor_remove'>Delete</a></td></tr>";
		}
		echo "</table>";
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