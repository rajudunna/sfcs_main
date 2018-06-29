	<?php
	// $servername = "192.168.0.110:3326";
	// $username = "baiall";
	// $password = "baiall";
	// $dbname = "bai_pro2";

	// Create connection
	// $conn = new mysqli($servername, $username, $password, $dbname);
	// Check connection
	include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config.php');
	$conn=$link;
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	} 

	$sql = "SELECT * FROM $bai_pro3.bai_qms_location_db";
	$result = $conn->query($sql);
	$sno = 1;
	$url=getFullURL($_GET['r'],'qms_location_add.php','N');
	$url1=getFullURL($_GET['r'],'qms_location_delete.php','N');
	if ($result->num_rows > 0) {
		echo "<table id='qms_locate' class='table'><thead><tr><th>S.No</th><th>Location</th><th>Capacity</th><th>Quantity</th><th>Location Type</th><th>Sequence</th><th> Edit / Delete </th></tr></thead><tbody>";
		// output data of each row
		while($row = $result->fetch_assoc()) 
		{
	        $qms_location_id=$_REQUEST['qms_location_id'];
			$qms_location=$_REQUEST['qms_location'];
			$qms_location_cap=$_REQUEST['qms_location_cap'];
			$qms_cur_qty = $_REQUEST['qms_cur_qty'];
			$active_status = $_REQUEST['active_status'];
			$location_type = $_REQUEST['location_type'];
			$order_by=$_REQUEST['order_by'];

			echo "<tr><td>".$sno++."</td><td>".$row["qms_location"]."</td><td>".$row["qms_location_cap"]." </td><td>".$row["qms_cur_qty"]."</td><td>".$row["active_status"]."</td><td>".$row["location_type"]." </td><td>".$row["order_by"]."</td><td><a href='$url==&rowid=$qms_location_id&qms_location=$qms_location&qms_location_cap=$qms_location_cap&qms_cur_qty=$qms_cur_qty&active_status=$active_status&location_type=$location_type&order_by=$order_by' class='editor_edit'>Edit</a> / <a href='$url1&rowid=$qms_location_id&qms_location=$qms_location&qms_location_cap=$qms_location_cap&qms_cur_qty=$qms_cur_qty&active_status=$active_status&location_type=$location_type&order_by=$order_by' class='editor_remove'>Delete</a></td></tr>";
		}
		echo "</tbody></table>";
	} else {
		echo "0 results";
	}
	$conn->close();
	?>


<script>
$(document).ready(function() {
    $('#qms_locate').DataTable();
} );
</script>