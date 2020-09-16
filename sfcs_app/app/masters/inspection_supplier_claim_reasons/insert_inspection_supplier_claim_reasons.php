<script src="<?= getFullURLLevel($_GET['r'],'common/js/jquery-2.1.3.min.js',3,'R'); ?>"></script>
  <script src="<?= getFullURLLevel($_GET['r'],'common/js/sweetalert-dev.js',3,'R'); ?>"></script>
  <link rel="stylesheet" href="<?= getFullURLLevel($_GET['r'],'common/css/sweetalert.css',3,'R'); ?>">
<?php

$tid =$_POST['tid']; 
$complaint_reason=$_POST['complaint_reason'];
$complaint_clasification =$_POST['complaint_clasification'];
$complaint_category = $_POST['complaint_category'];
$status = $_POST['status'];
$plant_code=$_SESSION['plantCode'];
$username=$_SESSION['userName']; 
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

if (strlen(trim($complaint_reason)) == 0 || strlen(trim($complaint_clasification)) == 0 || strlen(trim($complaint_category)) == 0) 
{
	$url=getFullURL($_GET['r'],'save_inspection_supplier_claim_reasons.php','N');
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
		$sql = "update $mdm.inspection_complaint_reasons set complaint_reason='$complaint_reason',complaint_clasification='$complaint_clasification',complaint_category='$complaint_category',status='$status',updated_user= '$username',updated_at=NOW() where tid =$tid";
		//echo 	$sql;
		if (mysqli_query($conn, $sql)) {
			$url=getFullURL($_GET['r'],'save_inspection_supplier_claim_reasons.php','N');
			
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
		
		$count_qry= "select * from $mdm.inspection_complaint_reasons where complaint_reason = '$complaint_reason' and (complaint_clasification = '$complaint_clasification' or complaint_category = '$complaint_category' )"; 
		// echo $count_qry;
		$count = mysqli_num_rows(mysqli_query($conn, $count_qry));
		if($count > 0){
			// echo $count;die();
			$url=getFullURL($_GET['r'],'save_inspection_supplier_claim_reasons.php','N');


		echo "<script>setTimeout(function () { 
			swal({
			  title: ' Reason Already Existed!',
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
			$sql = "INSERT INTO $mdm.inspection_complaint_reasons(complaint_reason, complaint_clasification,complaint_category, status,created_user,updated_user,updated_at) VALUES('$complaint_reason','$complaint_clasification','$complaint_category','$status','$username','".$username."',NOW())";
			if (mysqli_query($conn, $sql)) {
				$url=getFullURL($_GET['r'],'save_inspection_supplier_claim_reasons.php','N');


		echo"<script>setTimeout(function () { 
			swal({ 
			  title: 'New Record Created successfully',
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

$url1 = getFullURL($_GET['r'],'save_inspection_supplier_claim_reasons.php','N');


mysqli_close($conn);
// header("location: $url1");
exit;
// echo "<script>alert('Enter data correctly.')</script>";
?>