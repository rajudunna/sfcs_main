	<?php
	
	include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
	
	

	$sql = "SELECT * FROM brandix_bts.tbl_sewing_job_prefix";
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	$norows = mysqli_num_rows($sql_result);
	$sno = 1;

		if ($norows > 0) {
		echo "<table id='downtime_reason' class='table'><thead><tr><th>S.No</th><th>Prefix Name</th><th>Prefix</th><th>Type Of Prefix</th><th>Back Ground Color</th><th> Edit / Delete </th></tr></thead><tbody>";
		// output data of each row
		while($row=mysqli_fetch_array($sql_result)) {
			$rowid=$row["id"];
			$code=$row["prefix_name"];
			$department=$row["prefix"];
			$reason=$row["type_of_sewing"];
			$type=$row["bg_color"];


			$url=getFullURL($_GET['r'],'sewing_jobs_prefix_add.php','N');
			$url1=getFullURL($_GET['r'],'delete_sewing_jobs_prefix.php','N');
			$color = $row["bg_color"];
			echo "<tr><td>".$sno++."</td><td>".$row["prefix_name"]."</td><td>".$row["prefix"]." </td><td>".$row["type_of_sewing"]."</td>
			<td><span style='border:1px solid black;width:100px;height:40px;background:$color'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></td>
			<td><a href='$url&id=$rowid&prefix_name=$code&prefix=$department&type_of_sewing=$reason&bg_color=$color' class='btn btn-warning btn-xs editor_edit'>Edit</a> / 
			<a href='$url1&id=$rowid&prefix_name=$code&prefix=$department&type_of_sewing=$reason&bg_color=$type'class='btn btn-danger btn-xs editor_remove'>Delete</a></td></tr>";
		}
		echo "</tbody></table>";
	} else {
		echo "0 results";
	}
	?>

<script>
$(document).ready(function() {
    $('#downtime_reason').DataTable();
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