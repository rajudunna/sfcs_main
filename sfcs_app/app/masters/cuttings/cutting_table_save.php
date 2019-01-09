
<script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>
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
$tbl_id=$_POST['tbl_id'];
// echo $tbl_id;
$emp_id =$_POST['emp_id'];
// echo $tbl_name;die();
$emp_name =$_POST['emp_name'];


include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config.php');
$conn=$link;
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
	// echo "Please fill values";
}else{
	
	if($tbl_id>0){
		
		//update
		
		$sql = "update $bai_pro3.tbl_leader_name set emp_id='$emp_id',emp_name='$emp_name' where id=$tbl_id";
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
	}else{
		
		$query="select emp_id from $bai_pro3.tbl_leader_name where emp_id='$emp_id'  ";
		$sql_result=mysqli_query($conn, $query);
		if(mysqli_num_rows($sql_result)>0){
		$url=getFullURL($_GET['r'],'cutting_table_add.php','N');


		echo"<script>setTimeout(function () { 
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

		}else{

		//insert 
		$sql = "INSERT INTO $bai_pro3.tbl_leader_name (emp_id,emp_name)
			VALUES ('$emp_id','$emp_name')";
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