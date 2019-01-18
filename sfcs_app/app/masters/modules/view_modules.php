<script src="/sfcs_app/common/js/jquery-1.11.1.min.js"></script>
<link href="/sfcs_app/common/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />  
<script src="/sfcs_app/common/js/jquery.dataTables.min.js"></script>
	<?php
	
	// Check connection
	include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config.php');
	$conn=$link;
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	} 

	$sql = "SELECT * FROM $bai_pro3.`module_master`";
	$result = $conn->query($sql);
	$sno = 1;
	$url=getFullURL($_GET['r'],'add_module.php','N');
	$url1=getFullURL($_GET['r'],'delete_module.php','N');
	if ($result->num_rows > 0) {
		echo "<div style='overflow-x:auto;'><table id='module_master' class='table'>
		<thead>
		<tr>
		<th>S.No</th>
		<th>Module Name</th>
		<th>Section Name</th>
		<th>Block Priorities</th>		
		<th>Module Description</th>		
		<th>Mapped Cut Table</th>
        <th>Module Color</th>
        <th>Module Label</th>
		<th>Status</th>
		<th> Edit / Delete </th>
		</tr>
		</thead>
		<tbody>";
		// output data of each row
		$section_display_name='';
		while($row = $result->fetch_assoc()) {
			$rowid=$row["id"];
			$module_name=$row["module_name"];
			$status=$row["status"];
			$section=$row["section"];
			$sql1 = "SELECT * FROM $bai_pro3.`sections_master` where sec_name=$section";
			// echo $sql1;
			$result1 = $conn->query($sql1);
			while($row1 = $result1->fetch_assoc()) {
				$section_display_name=$row1["section_display_name"];
			}
			// if($section_display_name==''){
			// 	$section_display_name=$row1["section"];
			// }
            $color= urlencode($row["color"]);
            $label=$row["label"];
			$module_description=$row["module_description"];
			$mapped_cut_table=$row["mapped_cut_table"];
			$block_priorities=$row["block_priorities"];
			if ($mapped_cut_table == '' or $mapped_cut_table == NULL)
			{
				$mapped_cut_table = ' - ';
			}
			
			echo "<tr>
			<td>".$sno++."</td>
			<td>".$row["module_name"]."</td>
			<td>".$row["section"]."</td>
			<td>".$row["block_priorities"]."</td>
            <td>".$row["module_description"]."</td>
            <td>".$mapped_cut_table."</td>
            <td>".$row["color"]."</td>
            <td>".$row["label"]."</td>
			<td>".$section_display_name."</td>
			<td>".$block_priorities."</td>
			<td>".$row["module_description"]."</td>
			<td>".$mapped_cut_table."</td>
			<td>".$row["status"]." </td>
			<td><a href='$url&rowid=$rowid&module_name=$module_name&section=$section&status=$status&module_description=$module_description&block_priorities=$block_priorities&mapped_cut_table=$mapped_cut_table&module_color=$color&module_label=$label' class='btn btn-warning btn-xs editor_edit'>Edit</a> / <a href='$url1&rowid1=$rowid&module_name=$module_name&section=$section' class='btn btn-danger btn-xs editor_remove' onclick='return confirm_delete(event,this);'>Delete</a></td>
			</tr>";
		}

		echo "</tbody></table></div>";
	} else {
		echo "0 results";
	}
	$conn->close();
	?>
<!-- /index.php?r=L3NmY3NfYXBwL2FwcC9tYXN0ZXJzL2NhdGVnb3JpZXMvYWRkX2NhdGVnb3JpZXMucGhw -->

<script>
$(document).ready(function() {
    $('#module_master').DataTable();
} );
function confirm_delete(e,t)
    {
        e.preventDefault();
        var v = sweetAlert({
        title: "Are you sure to Delete the Record?",
        icon: "warning",
        buttons: true,
        dangerMode: true,
        buttons: ["No, Cancel It!", "Yes, I am Sure!"],
        }).then(function(isConfirm){
        if (isConfirm) {
        window.location = $(t).attr('href');
        return true;
        } else {
        sweetAlert("Request Cancelled",'','error');
        return false;
        }
        });
    }
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
