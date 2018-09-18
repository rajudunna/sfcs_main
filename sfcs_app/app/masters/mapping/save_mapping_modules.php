<script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">
<?php
$id=$_REQUEST['id'];
$section=$_REQUEST['section'];
$chkl =$_REQUEST['chkl'];
$datetime =$_REQUEST['datetimepicker11'];
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config.php');
$conn=$link;
// echo 





if (empty($chkl)||$section=='') {
	$url=getFullURL($_GET['r'],'add_mapping_module.php','N');
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
	if($chkl>0){
		
		foreach($_POST['chkl'] as $index => $val){
		$sql = "SELECT module_name FROM $bai_pro3.module_master where id='$val'";	
	    $result = $conn->query($sql);
		if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			$module_name[]=$row["module_name"];	
			
		}
$module=implode(",", $module_name);
	
		}
		}
		
		
		
		
		$sql1 = "update $bai_pro3.sections_db set sec_mods='$module' where sec_id=$section";
		if (mysqli_query($conn, $sql1)) {

			$url=getFullURL($_GET['r'],'add_mapping_module.php','N');
			//echo $url;
			//echo "Record updated successfully";
			//echo"<script>setTimeout(function () { 
				//swal({
				  //title: 'Record updated successfully',
				  //text: 'Message!',
				  //type: 'success',
				  //confirmButtonText: 'OK'
				//},
				//function(isConfirm){
				  //if (isConfirm) {
					//window.location.href = \"$url\";
				  //}
				//}); }, 100);</script>";
				

		} else {
			echo "Error: " . $sql . "<br>" . mysqli_error($conn);
		}
	
		
		$query="select module_id from $bai_pro3.mappings_master where section_id='$section'";
		$sql_result=mysqli_query($conn, $query);
		if(mysqli_num_rows($sql_result)>0){
		$url=getFullURL($_GET['r'],'add_mapping_module.php','N');


		echo"<script>setTimeout(function () { 
			swal({
			  title: 'Module Already Existed for this Section!',
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
		foreach($_POST['chkl'] as $index => $val){
		$sql = "INSERT INTO $bai_pro3.mappings_master (module_id,section_id,date_time)
			VALUES ('$val','$section','$datetime')";

		if (mysqli_query($conn, $sql)) {
			$url=getFullURL($_GET['r'],'add_mapping_module.php','N');
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
}

mysqli_close($conn);
//header('location: index.php?r=L3NmY3NfYXBwL2FwcC9tYXN0ZXJzL2N1dHRpbmcvY3V0dGluZ190YWJsZV9hZGQucGhw');
exit;


?>