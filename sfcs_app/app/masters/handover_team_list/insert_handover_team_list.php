
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
$plantcode=$_SESSION['plantCode'];
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
$sqlnewchange="ALTER TABLE $pps.tbl_fg_crt_handover_team_list ADD COLUMN plant_code VARCHAR(150) NULL AFTER status, ADD COLUMN created_at TIMESTAMP NULL AFTER plant_code, ADD COLUMN created_user VARCHAR(120) NULL AFTER created_at, ADD COLUMN updated_at DATETIME NULL AFTER created_user, ADD COLUMN updated_user VARCHAR(120) NULL AFTER updated_at, ADD COLUMN version_flag INT(11) NULL AFTER updated_user";  
$sql_resultnewchange=mysqli_query($link, $sqlnewchange) or exit("Sql Error2--".mysqli_error($GLOBALS["___mysqli_ston"]));

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
		$sql = "update $pps.tbl_fg_crt_handover_team_list set emp_id='$emp_id',emp_call_name='$emp_call_name',
		emp_status='$emp_status',updated_user='$username',updated_at='".date('Y-m-d')."' where plant_code='$plantcode' team_id=$team_id";
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
		
		$count_qry= "select emp_id from $pps.tbl_fg_crt_handover_team_list where plant_code='$plantcode' and  emp_id = '$emp_id' "; 
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
			$sql = "INSERT INTO $pps.tbl_fg_crt_handover_team_list (emp_id, emp_call_name,selected_user, emp_status,plant_code,created_user,created_at)
			 VALUES('$emp_id','$emp_call_name','$selected_user','$emp_status','$plantcode','$username','".date('Y-m-d')."')";
		
			 
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