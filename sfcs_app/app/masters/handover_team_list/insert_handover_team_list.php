
<?php 
 $selected_user = getrbac_user()['uname']; 
?>
<script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">
<?php
// echo $_POST['table_name'];
$team_id =$_POST['team_id'];
$emp_id=$_POST['emp_id'];
$emp_call_name =$_POST['emp_call_name'];
//$selected_user = $_POST['selected_user'];
//$lastup = $_POST['lastup'];
$emp_status = $_POST['emp_status'];

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

if (empty($emp_id) || empty($emp_call_name) ) 
{
	$url=getFullURL($_GET['r'],'save_handover_team_list.php','N');
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
	if($team_id>0){
		//update
		$sql = "update $bai_pro3.tbl_fg_crt_handover_team_list set emp_id='$emp_id',emp_call_name='$emp_call_name',emp_status='$emp_status' where team_id=$team_id";
		//echo $sql;exit;
		if (mysqli_query($conn, $sql)) {
			$url=getFullURL($_GET['r'],'save_handover_team_list.php','N');
			
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
		
		$count_qry= "select emp_id from $bai_pro3.tbl_fg_crt_handover_team_list where emp_id = '$emp_id' "; 
		// echo $count_qry;
		$count = mysqli_num_rows(mysqli_query($conn, $count_qry));
		if($count > 0){
			// echo $count;die();
			$url=getFullURL($_GET['r'],'save_handover_team_list.php','N');


		echo "<script>setTimeout(function () { 
			swal({
			  title: ' Record Already Existed!',
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
			$sql = "INSERT INTO $bai_pro3.tbl_fg_crt_handover_team_list (emp_id, emp_call_name,selected_user, emp_status) VALUES('$emp_id','$emp_call_name','$selected_user','$emp_status')";
		
			 
			if (mysqli_query($conn, $sql)) {
				$url=getFullURL($_GET['r'],'save_handover_team_list.php','N');


		echo"<script>setTimeout(function () { 
			swal({
			  title: 'New Record Created successfully',
			  text: 'Message!',
			  type: 'warning',
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

$url1 = getFullURL($_GET['r'],'save_handover_team_list.php','N');


mysqli_close($conn);
// header("location: $url1");
exit;
// echo "<script>alert('Enter data correctly.')</script>";
?>