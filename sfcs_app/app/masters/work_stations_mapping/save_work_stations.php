<script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">
<?php
$id=$_REQUEST['id'];
$work_station_id=$_REQUEST['work_station_id'];
$operation_code =$_REQUEST['operation_code'];
$module_name =$_REQUEST['module_name'];
$datetime =$_REQUEST['datetimepicker11'];
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config.php');
$conn=$link;
// echo 





if (empty($module_name)||empty($work_station_id)||empty($operation_code)) {
	$url=getFullURL($_GET['r'],'add_work_station.php','N');
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
	
	
		 $query="select module from $bai_pro3.work_stations_mapping where operation_code='$operation_code' and module='$module_name'";
		$sql_result=mysqli_query($conn, $query);
		if(mysqli_num_rows($sql_result)>0){
		$url=getFullURL($_GET['r'],'add_work_station.php','N');


		echo"<script>setTimeout(function () { 
			swal({
			  title: 'Module Already Existed For This Operation',
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
        else{
		//insert 
		$sql = "INSERT INTO $bai_pro3.`work_stations_mapping` (date_time,operation_code,module,work_station_id)
			VALUES ('$datetime','$operation_code','$module_name','$work_station_id')";

		if (mysqli_query($conn, $sql)) {
			$url=getFullURL($_GET['r'],'add_work_station.php','N');
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

mysqli_close($conn);
//header('location: index.php?r=L3NmY3NfYXBwL2FwcC9tYXN0ZXJzL2N1dHRpbmcvY3V0dGluZ190YWJsZV9hZGQucGhw');
exit;


?>