<script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">
<?php

$q_id = $_POST['q_id'];
$q_location_type = $_POST['q_location_type'];
$qms_location_id=$_POST['qms_location_id'];
$qms_location=$_POST['qms_location'];
$qms_location_cap=$_POST['qms_location_cap'];
$qms_cur_qty = $_POST['qms_cur_qty'];
$active_status = $_POST['active_status'];

// $servername = "192.168.0.110:3326";
// $username = "baiall";
// $password = "baiall";
// $dbname = "bai_pro2";
// echo $code;
// Create connection
// $conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
// 
// include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config.php');
$conn=$link;
if (empty($qms_location) || empty($qms_location_cap) ||   empty($qms_location_id) ) 
{
	$url=getFullURL($_GET['r'],'surplus_table.php','N');
	echo"<script>setTimeout(function () { 
		swal({
		  title: 'Please Fill All Values',
		  text: 'Message!',
		  type: 'warning',
		  confirmButtonText: 'OK'
		},
		function(isConfirm){
		  if (isConfirm) {
			window.location.href = \"$url\";
		  }
		}); }, 100);</script>";
	
}
else
{
	if($q_id>0)
	{
		//update
		$sql = "update $bai_pro3.bai_qms_location_db set  qms_location='$qms_location', active_status='$active_status',qms_location_cap='$qms_location_cap',location_type='q_location_type'
		where q_id=$q_id";
		
		if (mysqli_query($conn, $sql)) {
			$url=getFullURL($_GET['r'],'surplus_table.php','N');
			//echo $url;
			//echo "Record updated successfully";
			echo"<script>setTimeout(function () { 
				swal({
				  title: 'Record updated successfully',
				  text: 'Message!',
				  type: 'success',
				  confirmButtonText: 'OK'
				},
				function(isConfirm){
				  if (isConfirm) {
					window.location.href = \"$url\";
				  }
				}); }, 100);</script>";
		} else {
			echo "Error: " . $sql . "<br>" . mysqli_error($conn);
		}
	}
	else
	{

		$query1="select qms_location_id from $bai_pro3.bai_qms_location_db where qms_location_id='$qms_location_id'";
		$sql_result1=mysqli_query($conn, $query1);
		
		
		if(mysqli_num_rows($sql_result1)>0){
			$url=getFullURL($_GET['r'],'surplus_table.php','N');
			echo"<script>setTimeout(function () { 
				swal({
				  title: 'Location Id Already Existed!',
				  text: 'Message!',
				  type: 'warning',
				  confirmButtonText: 'OK'
				},
				function(isConfirm){
				  if (isConfirm) {
					window.location.href = \"$url\";
				  }
				}); }, 100);</script>";




		}
		else
		{
			$sql = "INSERT INTO $bai_pro3.bai_qms_location_db ( qms_location_id,qms_location, qms_location_cap, qms_cur_qty, active_status,location_type )
			VALUES ('$qms_location_id', '$qms_location','$qms_location_cap','$qms_cur_qty','$active_status','$q_location_type')";

			if (mysqli_query($conn, $sql)) 
			{
				$url=getFullURL($_GET['r'],'surplus_table.php','N');
				//echo "New record created successfully";
				echo"<script>setTimeout(function () { 
					swal({
					  title: 'New record created successfully',
					  text: 'Message!',
					  type: 'success',
					  confirmButtonText: 'OK'
					},
					function(isConfirm){
					  if (isConfirm) {
						window.location.href = \"$url\";
					  }
					}); }, 100);</script>";
			} 
			else 
			{
			    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
			}

		}
	}
}

mysqli_close($conn);
//header('location: index.php?r=L3NmY3NfYXBwL2FwcC9tYXN0ZXJzL2Rvd250aW1lcmVhc29uL2Rvd25fdGltZV9yZWFzb25fYWRkLnBocA==');
exit;
?>


