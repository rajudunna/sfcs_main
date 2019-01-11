<script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">
<?php
// echo $_POST['table_name'];
$tid =$_POST['reason_tid'];
$rejec_code=$_POST['reason_code'];
$rejec_des =$_POST['reason_desc'];
$status = $_POST['status'];

//echo $color_code;

 //echo $seq_no;die();
// $servername = "192.168.0.110:3326";
// $username = "baiall";
// $password = "baiall";
// $dbname = "bai_rm_pj1";
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config.php');
$conn=$link; 

// // Create connection
// $conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection

if (empty($rejec_code) || empty($rejec_des)  ) 
{
	$url=getFullURL($_GET['r'],'save_mrn_req_reasons.php','N');
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
		

}else{ 
	
	if($tid>0){
		//update
		$sql = "update $bai_rm_pj2.mrn_reason_db set reason_code='$rejec_code',reason_desc='$rejec_des',status='$status' where reason_tid=$tid";
		//echo $sql;exit;
		if (mysqli_query($conn, $sql)) {
			$url=getFullURL($_GET['r'],'save_mrn_req_reasons.php','N');
			
			// echo "Record updated successfully";
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
	}else{
		
		$count_qry= "select * from $bai_rm_pj2.mrn_reason_db where reason_code = '$rejec_code' and (reason_desc = '$rejec_des' )"; 
		// echo $count_qry;
		$count = mysqli_num_rows(mysqli_query($conn, $count_qry));
		if($count > 0){
			// echo $count;die();
			$url=getFullURL($_GET['r'],'save_mrn_req_reasons.php','N');


		echo "<script>setTimeout(function () { 
			swal({
			  title: 'MRN Request Reason Already Existed!',
			  text: 'Message!',
			  type: 'warning',
			  confirmButtonText: 'OK'
			},
			function(isConfirm){
			  if (isConfirm) {
				window.location.href = \"$url\";
			  }
			}); }, 100);</script>";
			// $error_msg = 1;
			// echo "<script>alert('Enter data correctly.')</script>";
		}
		else{
			$sql = "INSERT INTO $bai_rm_pj2.mrn_reason_db(reason_code, reason_desc,status) VALUES('$rejec_code','$rejec_des','$status')";
			if (mysqli_query($conn, $sql)) {
				$url=getFullURL($_GET['r'],'save_mrn_req_reasons.php','N');


		echo"<script>setTimeout(function () { 
			swal({
			  title: 'Record inserted successfully',
			  text: 'Message!',
			  type: 'success',
			  confirmButtonText: 'OK'
			},
			function(isConfirm){
			  if (isConfirm) {
				window.location.href = \"$url\";
			  }
			}); }, 100);</script>";
				// echo "New record created successfully";
			}
			else {
				echo "Error: " . $sql . "<br>" . mysqli_error($conn);
			}
		}
		//insert 
	}
}

$url1 = getFullURL($_GET['r'],'save_mrn_req_reasons.php','N');


mysqli_close($conn);
// header("location: $url1");
exit;
// echo "<script>alert('Enter data correctly.')</script>";
?>