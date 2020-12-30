
<?php 
 //$selected_user = getrbac_user()['uname']; 
?>
<script src="<?= getFullURLLevel($_GET['r'],'common/js/jquery-2.1.3.min.js',3,'R'); ?>"></script>
  <script src="<?= getFullURLLevel($_GET['r'],'common/js/sweetalert-dev.js',3,'R'); ?>"></script>
  <link rel="stylesheet" href="<?= getFullURLLevel($_GET['r'],'common/css/sweetalert.css',3,'R'); ?>">
<?php
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config.php');
// echo $_POST['table_name'];
$team_id =$_POST['team_id'];
$emp_id=$_POST['emp_id'];
$emp_call_name =$_POST['emp_call_name'];
//$selected_user = $_POST['selected_user'];
//$lastup = $_POST['lastup'];
$emp_status = $_POST['emp_status'];
$plant_code=$_SESSION['plantCode'];
$username=$_SESSION['userName'];

//echo $color_code;

 //echo $seq_no;die();
// $servername = "192.168.0.110:3326";
// $username = "baiall";
// $password = "baiall";
// $dbname = "bai_rm_pj1";
$conn=$link;

// // Create connection
// $conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection

if (strlen(trim($emp_id)) == 0 || strlen(trim($emp_call_name)) == 0 ) 
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
		$sql = "update $pms.tbl_fg_crt_handover_team_list set emp_id='$emp_id',emp_call_name='$emp_call_name',emp_status='$emp_status',updated_user='$username',updated_at=NOW() where team_id=$team_id and plant_code='$plant_code'";
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
		
		$count_qry= "select emp_id from $pms.tbl_fg_crt_handover_team_list where emp_id = '$emp_id' and plant_code='$plant_code'"; 
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
			$sql = "INSERT INTO $pms.tbl_fg_crt_handover_team_list (emp_id, emp_call_name,selected_user, emp_status,plant_code,created_user,updated_user,updated_at) VALUES('$emp_id','$emp_call_name','$username','$emp_status','$plant_code','$username','".$username."',NOW())";
		
			 
			if (mysqli_query($conn, $sql)) {
				$url=getFullURL($_GET['r'],'save_handover_team_list.php','N');


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

$url1 = getFullURL($_GET['r'],'save_handover_team_list.php','N');


mysqli_close($conn);
// header("location: $url1");
exit;
// echo "<script>alert('Enter data correctly.')</script>";
?>