<script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">
<?php
$id=$_REQUEST['id'];
$module=$_REQUEST['module'];
$description =$_REQUEST['description'];
$status =$_REQUEST['table_status'];
$sections =$_REQUEST['sections'];
$module_color =$_REQUEST['module_color'];
$module_label =$_REQUEST['module_label'];
$datetime =$_REQUEST['datetimepicker11'];
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config.php');
$conn=$link;
// echo 





if (empty($module)||empty($sections)) {
	$url=getFullURL($_GET['r'],'add_module.php','N');
	echo"<script>setTimeout(function () { 
		swal({
		  title: 'Please Fill Module and Section',
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
		
		$sql = "update $bai_pro3.module_master set module_name='$module',date_time='$datetime',module_description='$description', section='$sections',status='$modulestatus',color='$module_color', label='$module_label' where id=$id";
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
		$sql = "INSERT INTO $bai_pro3.module_master (module_name,date_time,module_description,status,section,color,label)
			VALUES ('$module','$datetime','$description','$modulestatus','$sections','$module_color','$module_label')";
        
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
		
		 $sql = "INSERT INTO $bai_pro3.plan_modules (module_id,section_id)
			VALUES ('$module','$sections')";

		if (mysqli_query($conn, $sql)) {
			
		} else {
			echo "Error: " . $sql . "<br>" . mysqli_error($conn);
		} 


     }
	}

	$query3="SELECT sec_head FROM bai_pro3.`sections_db` WHERE sec_head='$sections'";
	$result4= mysqli_query($conn, $query3);
    $row = mysqli_fetch_assoc($result4);
	if($row>0){
	

       $sections_query1="SELECT GROUP_CONCAT(module_id)as module_concat FROM bai_pro3.`plan_modules` WHERE section_id='$sections'";
	   $result5= mysqli_query($conn, $sections_query1);
      $row = mysqli_fetch_assoc($result5);
      $total_modules1=$row['module_concat'];
       $sql6 = "update $bai_pro3.sections_db set sec_id='$sections',sec_head='$sections',sec_mods='$total_modules1' where sec_head='$sections'";
			
		if (mysqli_query($conn, $sql6)) {
		} else {
			echo "Error: " . $sql . "<br>" . mysqli_error($conn);
		}
	}else{
	
	       $sections_query="SELECT GROUP_CONCAT(module_id)as module_concat FROM bai_pro3.`plan_modules` WHERE section_id='$sections'";
	   $result3 = mysqli_query($conn, $sections_query);
      $row = mysqli_fetch_assoc($result3);
      $total_modules=$row['module_concat'];
	  echo $total_modules;
       $sql1 = "INSERT INTO $bai_pro3.sections_db (sec_id,sec_head,sec_mods)
			VALUES ('$sections','$sections','$total_modules,$module')";
		if (mysqli_query($conn, $sql1)) {
			
		} else {
			echo "Error: " . $sql . "<br>" . mysqli_error($conn);
		}
	}
		
	
}

mysqli_close($conn);
//header('location: index.php?r=L3NmY3NfYXBwL2FwcC9tYXN0ZXJzL2N1dHRpbmcvY3V0dGluZ190YWJsZV9hZGQucGhw');
exit;


?>
