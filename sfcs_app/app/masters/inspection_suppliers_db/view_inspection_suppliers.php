	<?php
	$servername = "192.168.0.110:3326";
	$username = "baiall";
	$password = "baiall";
	$dbname = "bai_rm_pj1";

	// Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);
	// Check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	} 

	$sql = "SELECT * FROM bai_rm_pj1.`inspection_supplier_db`";
	$result = $conn->query($sql);

	if ($result->num_rows > 0) {
		echo "<table id='tbl_packing_method' class='table'><tr><th>S.No</th><th>Product Code</th><th>Supplier Code</th><th>Complaint No </th><th>Supplier M3 Code</th><th>Color Code</th><th>Sequence No</th><th> Edit / Delete </th></tr>";
		// output data of each row
		while($row = $result->fetch_assoc()) {
			$product_code=$row["product_code"];
			$tid=$row["tid"];
			$supplier_code=$row["supplier_code"];
			$complaint_no=$row["complaint_no"];
			$supplier_m3_code=$row["supplier_m3_code"];
			$color_code=$row["color_code"];
			$color_code = str_replace("#"," ",$row["color_code"]);
			$seq_no=$row["seq_no"];
			echo "<tr><td>".++$start."</td><td>".$row["product_code"]." </td><td>".$row["supplier_code"]."</td><td>".$row["complaint_no"]."</td><td>".$row["supplier_m3_code"]."</td><td>".$row["color_code"]."</td><td>".$row["seq_no"]."</td><td><a href='/index.php?r=L3NmY3NfYXBwL2FwcC9tYXN0ZXJzL2luc3BlY3Rpb25fc3VwcGxpZXJzX2RiL3NhdmVfaW5zcGVjdGlvbl9zdXBwbGllcnMucGhw&tid=$tid&product_code=$product_code&supplier_code=$supplier_code&complaint_no=$complaint_no&supplier_m3_code=$supplier_m3_code&color_code=$color_code&seq_no=$seq_no' class='editor_edit'>Edit</a> / 
			<a href='/index.php?r=L3NmY3NfYXBwL2FwcC9tYXN0ZXJzL2luc3BlY3Rpb25fc3VwcGxpZXJzX2RiL2RlbGV0ZV9pbnNwZWN0aW9uX3N1cHBsaWVycy5waHA=&tid=$tid&product_code=$product_code&supplier_code=$supplier_code&complaint_no=$complaint_no&supplier_m3_code=$supplier_m3_code&color_code=$color_code&seq_no=$seq_no' class='editor_remove'>Delete</a></td></tr>";
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