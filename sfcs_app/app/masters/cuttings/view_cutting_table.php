<script src="<?= getFullURLLevel($_GET['r'],'common/js/jquery-2.1.3.min.js',3,'R'); ?>"></script>
  <script src="<?= getFullURLLevel($_GET['r'],'common/js/sweetalert-dev.js',3,'R'); ?>"></script>
  <link rel="stylesheet" href="<?= getFullURLLevel($_GET['r'],'common/css/sweetalert.css',3,'R'); ?>">
<?php
	// $servername = "192.168.0.110:3326";
	// $username = "baiall";
	// $password = "baiall";
	// $dbname = "bai_pro3";
	include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config.php');
	$plant_code=$_SESSION['plantCode'];
	$username=$_SESSION['userName'];
	// $plant_code='N02';
	$conn=$link;

	// Create connection
	// $conn = new mysqli($servername, $username, $password, $dbname);
	// Check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	} 

	$sql = "SELECT id,emp_id,emp_name FROM $pms.tbl_leader_name where plant_code='$plant_code' order by id desc";
	$result = $conn->query($sql);

	$sno =1;
	$url=getFullURL($_GET['r'],'cutting_table_add.php','N');
	$url1=getFullURL($_GET['r'],'delete_cutting_table.php','N');
	if ($result->num_rows > 0) {
		
		echo "<div class='row col-sm-12 table-responsive'><table id='tbl_cutting_table' class='table'><thead><tr><th>S.No</th><th>Employee Id</th><th>Employee Name</th><th> Edit / Delete </th></tr></thead><tbody>";
		// output data of each row
		while($row = $result->fetch_assoc()) {
			$tid=$row["id"];
			$emp_id=$row["emp_id"];
			$emp_name=$row["emp_name"];
			
			echo "<tr><td>".$sno++."</td><td>".$row["emp_id"]." </td><td>".$row["emp_name"]."</td>
					  <td>
					    <a href='$url&tid=$tid&emp_id=$emp_id&emp_name=$emp_name' class='btn btn-warning btn-xs editor_edit readonly'>Edit</a> /
					 	<a href='$url1&tid=$tid' class='btn btn-danger btn-xs' onclick='return confirm_delete(event,this);'>Delete</a>
					 </td>
				 </tr>";
		}
		echo "</tbody></table></div>";
	} else {
		echo "0 results";
	}
	$conn->close();
	?>


<script>
$(document).ready(function() {
    $('#tbl_cutting_table').DataTable();
} );

function confirm_delete(e,t)
    {
        e.preventDefault();
        // var v = swal({
        // title: "Are you sure to Delete the Record?",
        // icon: "warning",
        // buttons: true,
        // dangerMode: true,
        // buttons: ["No, Cancel It!", "Yes, I am Sure!"],
        // }, function(isConfirm){
        // if (isConfirm) {
        // window.location = $(t).attr('href');
        // return true;
        // } else {
        // sweetAlert("Request Cancelled",'','error');
        // return false;
        // }
        // });

		swal({
					title: "Are you sure?",
					text: "Do You Want To Delete the Record?",
					type: "warning",
					showCancelButton: true,
					confirmButtonColor: "#DD6B55",
					confirmButtonText: "Yes, I Want To Delete",
					cancelButtonText: "No, Cancel!",
					closeOnConfirm: false,
					closeOnCancel: false 
					}, 
				 function(isConfirm){ 
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