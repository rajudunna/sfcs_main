<?php
	// $servername = "192.168.0.110:3326";
	// $username = "baiall";
	// $password = "baiall";
	// $dbname = "bai_pro3";

	// Create connection
	// $conn = new mysqli($servername, $username, $password, $dbname);
	// Check connection
	//
	include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config.php');
	$conn=$link;
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	} 

    $sql = "SELECT * FROM $brandix_bts.`ops_short_cuts`";
    // echo $sql;
	$result = $conn->query($sql);
	$sno = 1;
	$url=getFullURL($_GET['r'],'create_short_key_code.php','N');
	$url1=getFullURL($_GET['r'],'delete_short_key_code.php','N');
	if ($result->num_rows > 0) {
		echo "<table id='downtime_reason' class='table table-bordered '><thead><tr ><th>S.No</th><th>Short Key Code</th><th>Controls</th></thead><tbody>";
		// output data of each row
		while($row = $result->fetch_assoc()) {
			$rowid=$row["id"];
			$short_key_code=$row["short_key_code"];
			echo "<tr><td>".$sno++."</td><td>".$row["short_key_code"]."</td><td><a href='$url&rowid=$rowid&short_key_code=$short_key_code' class='editor_edit btn btn-warning btn-xs'>Edit</a><a href='$url1&rowid1=$rowid' class='confirm-submit editor_remove btn btn-danger btn-xs' id='del' onclick='return confirm_delete(event,this);'>Delete</a></td></tr>";
		}

		echo "</tbody></table>";
	} else {
		echo "<b style='color:red;'>Sorry!!! No Records Found...</b>";
	}
	$conn->close();
	?>


<script>
$(document).ready(function() {
    $('#downtime_reason').DataTable();
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