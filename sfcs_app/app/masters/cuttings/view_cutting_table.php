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

	$sql = "SELECT * FROM $bai_pro3.tbl_leader_name";
	$result = $conn->query($sql);
	$sno =1;
	$url=getFullURL($_GET['r'],'cutting_table_add.php','N');
	$url1=getFullURL($_GET['r'],'delete_cutting_table.php','N');
	if ($result->num_rows > 0) {
		
		echo "<table id='tbl_cutting_table' class='table'><thead><tr><th>S.No</th><th>Employee Id</th><th>Employee Name</th><th> Edit / Delete </th></tr></thead><tbody>";
		// output data of each row
		while($row = $result->fetch_assoc()) {
			$tid=$row["tid"];
			$emp_id=$row["emp_id"];
			$emp_name=$row["emp_name"];
			
			echo "<tr><td>".$sno++."</td><td>".$row["emp_id"]." </td><td>".$row["emp_name"]."</td>
					  <td>
					    <a href='$url&tid=$tid&emp_id=$emp_id&emp_name=$emp_name' class='btn btn-warning btn-xs editor_edit'>Edit</a> /
					 	<a href='$url1&tid=$tid' class='btn btn-danger btn-xs editor_remove'>Delete</a>
					 </td>
				 </tr>";
		}
		echo "</tbody></table>";
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