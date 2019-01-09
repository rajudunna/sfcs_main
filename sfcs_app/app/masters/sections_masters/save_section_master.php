<script src="/sfcs_app/common/js/jquery-1.11.1.min.js"></script>
<script src="/sfcs_app/common/js/sweetalert-dev.js"></script>
<link rel="stylesheet" href="/sfcs_app/common/css/sweetalert.css">
<?php
$id=$_REQUEST['id'];
$section=$_REQUEST['section_name'];
$ims_priority_boxs =$_REQUEST['ims_priority'];
$section_display_name =$_REQUEST['section_display_name'];
$section_head =$_REQUEST['section_head'];
$datetime =$_REQUEST['datetimepicker11'];
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config.php');
$conn=$link;
// echo 

if (empty($section)) {
	$url=getFullURL($_GET['r'],'add_section_master.php','N');
	echo"<script>setTimeout(function () { 
		swal({
		  title: 'Please Fill Section',
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
	if($id>0){
		
		//update
		
		$sql = "update $bai_pro3.sections_master set sec_name='$section',date_time='$datetime',ims_priority_boxs='$ims_priority_boxs',section_display_name='$section_display_name',section_head='$section_head' where sec_id=$id";
		// echo $sql;die();
		if (mysqli_query($conn, $sql)) {

			$url=getFullURL($_GET['r'],'add_section_master.php','N');
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
		
		$query="select sec_name from $bai_pro3.sections_master where sec_name='$section'";
		$sql_result=mysqli_query($conn, $query);
		if(mysqli_num_rows($sql_result)>0){
		$url=getFullURL($_GET['r'],'add_section_master.php','N');


		echo"<script>setTimeout(function () { 
			swal({
			  title: 'Section Already Existed!',
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
		$sql = "INSERT INTO $bai_pro3.sections_master (date_time,sec_name,ims_priority_boxs,section_display_name,section_head)
			VALUES ('$datetime','$section','$ims_priority_boxs','$section_display_name','$section_head')";

		if (mysqli_query($conn, $sql)) {
			$url=getFullURL($_GET['r'],'add_section_master.php','N');
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