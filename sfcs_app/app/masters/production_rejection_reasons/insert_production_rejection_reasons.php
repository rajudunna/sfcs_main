<script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">
<?php
$sno =$_REQUEST['sno'];
$reason_cat =$_POST['reason_cat'];
$reason_desc =$_POST['reason_desc'];
$reason_code =$_POST['reason_code'];
$reason_order =$_POST['reason_order'];
$form_type =$_POST['form_type'];

$m3_reason_code=$_POST['m3_reason_code'];

include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config.php');
$conn=$link;

if (empty($reason_cat) || empty($reason_desc) || empty($reason_code) || empty($reason_order) || empty($form_type) || empty($m3_reason_code) ) 
{
	$url=getFullURL($_GET['r'],'save_production_rejection_reasons.php','N');
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
		$sql = "update $bai_pro3.bai_qms_rejection_reason set reason_cat='$reason_cat',reason_desc='$reason_desc',reason_code='$reason_code',reason_order='$reason_order',form_type='$form_type',m3_reason_code='$m3_reason_code' where sno=$sno";
		//echo $sql;exit;
		if (mysqli_query($conn, $sql)) {
			$url=getFullURL($_GET['r'],'save_production_rejection_reasons.php','N');
			
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
		
		$count_qry= "select reason_code from $bai_pro3.bai_qms_rejection_reason where reason_code = '$reason_code'"; 
		// echo $count_qry;
		$count = mysqli_num_rows(mysqli_query($conn, $count_qry));
		if($count > 0){
			// echo $count;die();
			$url=getFullURL($_GET['r'],'save_production_rejection_reasons.php','N');


		echo "<script>setTimeout(function () { 
			swal({
			  title: 'Record Already Existed!',
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
			$sql = "INSERT INTO $bai_pro3.bai_qms_rejection_reason(reason_cat, reason_desc,reason_code,reason_order,form_type,m3_reason_code) VALUES('$reason_cat','$reason_desc','$reason_code','$reason_order','$form_type','$m3_reason_code')";
			if (mysqli_query($conn, $sql)) {
				$url=getFullURL($_GET['r'],'save_production_rejection_reasons.php','N');


		echo"<script>setTimeout(function () { 
			swal({
			  title: 'record inserted successfully ',
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

$url1 = getFullURL($_GET['r'],'save_production_rejection_reasons.php','N');


mysqli_close($conn);
// header("location: $url1");
exit;
// echo "<script>alert('Enter data correctly.')</script>";
?>