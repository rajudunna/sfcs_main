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

	$sql = "SELECT * FROM $bai_pro2.`downtime_reason`";
	$result = $conn->query($sql);
	$sno = 1;
	$url=getFullURL($_GET['r'],'down_time_reason_add.php','N');
	$url1=getFullURL($_GET['r'],'delete_down_time_reason.php','N');
	if ($result->num_rows > 0) {
		echo "<table id='downtime_reason' class='table'><thead><tr><th>S.No</th><th>Code</th><th>Department</th><th>Reason</th><th> Edit / Delete </th></tr></thead><tbody>";
		// output data of each row
		while($row = $result->fetch_assoc()) {
			$rowid=$row["id"];
			$code=$row["code"];
			$department=$row["rdept"];
			$reason=$row["reason"];
			echo "<tr><td>".$sno++."</td><td>".$row["code"]."</td><td>".$row["rdept"]." </td><td>".$row["reason"]."</td><td><a href='$url==&rowid=$rowid&code=$code&department=$department&reason=$reason' class='editor_edit'>Edit</a> / <a href='$url1&rowid=$rowid&code=$code&department=$department&reason=$reason' class='editor_remove'>Delete</a></td></tr>";
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