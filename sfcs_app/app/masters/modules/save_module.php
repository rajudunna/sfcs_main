<script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">
<?php
$id=$_REQUEST['id'];
$module=$_REQUEST['module'];
$description =$_REQUEST['description'];
$status =$_REQUEST['table_status'];
$datetime =$_REQUEST['datetimepicker11'];
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config.php');
$conn=$link;
// echo 





if (empty($module)) {
	$url=getFullURL($_GET['r'],'add_module.php','N');
	echo"<script>setTimeout(function () { 
		swal({
		  title: 'Please Fill Module',
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
	if($status == 2)
	{
		$modulestatus = 'In-Active';
		
	}
	else
	{
		$modulestatus = 'Active';
	}
	if($id>0){
		
		//update
		
		$sql = "update $bai_pro3.module_master set module_name='$module',date_time='$datetime',module_description='$description', status='$modulestatus' where id=$id";
		// echo $sql;die();
		if (mysqli_query($conn, $sql)) {

			$url=getFullURL($_GET['r'],'add_module.php','N');
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
		
		$query="select module_name from $bai_pro3.module_master where module_name='$module'";
		$sql_result=mysqli_query($conn, $query);
		if(mysqli_num_rows($sql_result)>0){
		$url=getFullURL($_GET['r'],'add_module.php','N');


		echo"<script>setTimeout(function () { 
			swal({
			  title: 'Module Already Existed!',
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
		$sql = "INSERT INTO $bai_pro3.module_master (module_name,date_time,module_description,status)
			VALUES ('$module','$datetime','$description','$modulestatus')";

		if (mysqli_query($conn, $sql)) {
			$url=getFullURL($_GET['r'],'add_module.php','N');
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