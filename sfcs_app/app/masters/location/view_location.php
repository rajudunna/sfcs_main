	<?php
	$servername = "192.168.0.110:3326";
	$username = "baiall";
	$password = "baiall";
	$dbname = "bai_pro2";

	// Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);
	// Check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	} 

	$sql = "SELECT * FROM bai_pro2.`downtime_reason`";
	$result = $conn->query($sql);

	if ($result->num_rows > 0) {
		echo "<table id='downtime_reason' class='table'><tr><th>S.No</th><th>Location Name</th><th>Capacity</th><th>Filled Quantity</th><th>Status</th><th> Edit / Delete </th></tr>";
		// output data of each row
		while($row = $result->fetch_assoc()) {
			$rowid=$row["id"];
			$dept_name=$row["rdept"];
			$reason=$row["reason"];
			echo "<tr><td>".$row["loc_name"]."</td><td>".$row["capacity"]." </td><td>".$row["filled_qty"]."</td><td>".$row["status"]."</td><td><a href='/index.php?r=XHNmY3NfYXBwXGFwcFxtYXN0ZXJzXGxvY2F0aW9uXGxvY2F0aW9uX2FkZC5waHA=&rowid=$rowid&dept_name=$dept_name&reason=$reason' class='editor_edit'>Edit</a> / <a href='' class='editor_remove'>Delete</a></td></tr>";
		}
		echo "</table>";
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