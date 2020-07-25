
<script src="/sfcs_app/common/js/jquery-2.1.3.min.js"></script>
  <script src="/sfcs_app/common/js/sweetalert-dev.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">
<?php
// var_dump($_POST);die();
// if(isset($_REQUEST['tid'])){
// 	//echo "Row id".$_REQUEST['supplier_code'];
// 	$tbl_id =$_GET['tbl_id'];
// 	$emp_id =$_GET['emp_id'];
// 	$emp_name=$_GET['emp_name'];
// }
// echo $_POST['table_name'];
$plantcode=$_SESSION['plantCode'];
$username=$_SESSION['userName'];
$tbl_id=$_POST['tbl_id'];
// echo $tbl_id;
$emp_id =$_POST['emp_id'];
// echo $tbl_name;die();
$emp_name =$_POST['emp_name'];
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config.php');
$conn=$link;

$sqlnewchange="ALTER TABLE mdm.tbl_leader_name ADD COLUMN plant_code VARCHAR(150) NULL AFTER status, 
ADD COLUMN created_at TIMESTAMP NULL AFTER plant_code, ADD COLUMN created_user VARCHAR(120) NULL AFTER created_at, ADD COLUMN updated_at DATETIME NULL AFTER created_user, ADD COLUMN updated_user VARCHAR(120) NULL AFTER updated_at,
 ADD COLUMN version_flag INT(11) NULL AFTER updated_user"; 
  
$sql_resultnewchange=mysqli_query($link, $sqlnewchange) or exit("Sql Error2--".mysqli_error($GLOBALS["___mysqli_ston"]));

// echo 
if (empty($emp_id) || empty($emp_name)) {
	$url=getFullURL($_GET['r'],'cutting_table_add.php','N');
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
	if($tbl_id>0){
		$query = "SELECT emp_id  from $mdm.tbl_leader_name where plant_code='$plantcode' and  emp_id='$emp_id' and id != $tbl_id ";
		$sql_result=mysqli_query($conn, $query);
		if(mysqli_num_rows($sql_result)>0){
			$url=getFullURL($_GET['r'],'cutting_table_add.php','N');
			echo"<script>setTimeout(function () { 
				swal({
					title: 'Employee Id Already Existed!',
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
			$sql = "UPDATE $mdm.tbl_leader_name set emp_id='$emp_id',emp_name='$emp_name',updated_user='$username',updated_at='".date('Y-m-d')."' where plant_code='$plantcode' and id = $tbl_id";
			// echo $sql;die();
			if (mysqli_query($conn, $sql)) {
				$url=getFullURL($_GET['r'],'cutting_table_add.php','N');
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
	}else{
		$query = "SELECT emp_id from $mdm.tbl_leader_name where plant_code='$plantcode' and emp_id='$emp_id'";
		$sql_result=mysqli_query($conn, $query);
		if(mysqli_num_rows($sql_result)>0){
			$url=getFullURL($_GET['r'],'cutting_table_add.php','N');
			echo"<script>setTimeout(function () { 
				swal({
					title: 'Employee Id Already Existed!',
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
			$sql = "INSERT INTO $mdm.tbl_leader_name (emp_id,emp_name,plant_code,created_user,created_at)VALUES ('$emp_id','$emp_name','$plantcode','$username','".date('Y-m-d')."')";
			if (mysqli_query($conn, $sql)) {
				$url=getFullURL($_GET['r'],'cutting_table_add.php','N');
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
			} else {
				echo "Error: " . $sql . "<br>" . mysqli_error($conn);
			}
		}	
	}
}
mysqli_close($conn);
//header('location: index.php?r=L3NmY3NfYXBwL2FwcC9tYXN0ZXJzL2N1dHRpbmcvY3V0dGluZ190YWJsZV9hZGQucGhw');
exit;
?>
