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

	$sql = "SELECT * FROM bai_pro3.`tbl_leader_name`";
	$result = $conn->query($sql);
	$sno = 1;
	$url=getFullURL($_GET['r'],'create_leader_names.php','N');
	$url1=getFullURL($_GET['r'],'delete_leader_names.php','N');
	if ($result->num_rows > 0) {
		echo "<table id='downtime_reason' class='table table-bordered '><thead><tr class='info'><th>S.No</th><th>Employee Id </th><th>Employee Name</th><th> Edit / Delete </th></tr></thead><tbody>";
		// output data of each row
		while($row = $result->fetch_assoc()) {
			$rowid=$row["id"];
			$emp_id=$row["emp_id"];
			$emp_name=$row["emp_name"];
			
			
			echo "<tr><td>".$sno++."</td><td>".$row["emp_id"]."</td><td>".$row["emp_name"]."</td><td><a href='$url&rowid=$rowid&emp_id=$emp_id&emp_name=$emp_name' class='editor_edit btn btn-warning btn-xs'>Edit</a> / <a href='$url1&rowid1=$rowid' class='editor_remove btn btn-danger btn-xs'>Delete</a></td></tr>";
		}

		echo "</tbody></table>";
	} else {
		echo "0 results";
	}
	$conn->close();
	?>


<script>
$(document).ready(function() {
    $('#downtime_reason').DataTable();
} );
</script>