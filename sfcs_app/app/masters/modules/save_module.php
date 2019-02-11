<script src="/sfcs_app/common/js/jquery-1.11.1.min.js"></script>
<script src="/sfcs_app/common/js/sweetalert-dev.js"></script>
<link rel="stylesheet" href="/sfcs_app/common/css/sweetalert.css">
<?php
$id=$_REQUEST['id'];
$module=$_REQUEST['module'];
$block_priorities=$_REQUEST['block_priorities'];
$description =$_REQUEST['description'];
$status =$_REQUEST['table_status'];
$sections =$_REQUEST['sections'];
$sec1 =$_REQUEST['sec1'];
$module_color =$_REQUEST['module_color'];
$module_label =$_REQUEST['module_label'];
$mapped_cut_table =$_REQUEST['mapped_cut_table'];
$datetime =$_REQUEST['datetimepicker11'];
$mini_plant =$_REQUEST['mini_plant'];
if ($mini_plant == '' || $mini_plant == null)
{
	$mini_plant = 'NULL';
}
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config.php');
$username=getrbac_user()['uname'];
$conn=$link;

if (empty($module)||empty($sections)) {
	$url=getFullURL($_GET['r'],'add_module.php','N');
	echo"<script>setTimeout(function () { 
		swal({
		  title: 'Please Fill Module and Section',
		  type: 'warning',
		  confirmButtonText: 'OK'
		},
		function(isConfirm){
		  if (isConfirm) {
			window.location.href = \"$url\";
		  }
		}); }, 100);</script>";
	// echo "Please fill values";
}
else if(empty($block_priorities))
{
	$url=getFullURL($_GET['r'],'add_module.php','N');
	echo"<script>setTimeout(function () { 
		swal({
		  title: 'Please Enter Block Priorities',
		  type: 'warning',
		  confirmButtonText: 'OK'
		},
		function(isConfirm){
		  if (isConfirm) {
			window.location.href = \"$url\";
		  }
		}); }, 100);</script>";
}
else
{
	if($status == 2)
	{
		$modulestatus = 'In-Active';
		
	}
	else
	{
		$modulestatus = 'Active';
	}
	if($id>0)
	{
		//update
		
		$sql = "update $bai_pro3.module_master set module_name='$module',date_time='$datetime',mapped_cut_table='$mapped_cut_table',module_description='$description', block_priorities='$block_priorities', mini_plant_id=".$mini_plant.", section='$sections',status='$modulestatus',color='$module_color', label='$module_label' where id=$id";
		// echo $sql;die();
		if (mysqli_query($conn, $sql)) {
		} else {
			echo "Error: " . $sql . "<br>" . mysqli_error($conn);
		}
		$update_plan_modules="update $bai_pro3.plan_modules set section_id='$sections' where module_id=trim($module)";
		if (mysqli_query($conn, $update_plan_modules)) {
		}else {
			echo "Error: " . $update_plan_modules . "<br>" . mysqli_error($conn);
		}
		
		$sections_query2="SELECT GROUP_CONCAT(module_id)as module_concat FROM bai_pro3.`plan_modules` WHERE section_id='$sec1'";
		$result4 = mysqli_query($conn, $sections_query2);
		$row1 = mysqli_fetch_assoc($result4);
		$total_modules1=$row1['module_concat'];

		$sql5 = "update $bai_pro3.sections_db set sec_id='$sec1',sec_head='$sec1',sec_mods='$total_modules1' where sec_head='$sec1'";
		if (mysqli_query($conn, $sql5)) {
		}else {
			echo "Error: " . $sql5 . "<br>" . mysqli_error($conn);
		}


			// $sections_query1="SELECT GROUP_CONCAT(module_id)as module_concat FROM $bai_pro3.`plan_modules` WHERE section_id='$sections'";
			// $result3 = mysqli_query($conn, $sections_query1);
			// $row = mysqli_fetch_assoc($result3);
			// $total_modules=$row['module_concat'];




			// $sql1 = "update $bai_pro3.sections_db set sec_id='$sections',sec_head='$sections',sec_mods='$total_modules' where sec_head='$sections'";
				
		if (mysqli_query($conn, $sql5))
		{
			$url=getFullURL($_GET['r'],'add_module.php','N');
			//echo $url;
			//echo "Record updated successfully";
			echo"<script>setTimeout(function () { 
					swal({
						title: 'Record updated successfully',
						type: 'success',
						confirmButtonText: 'OK'
					},
					function(isConfirm){
						if (isConfirm) {
							window.location.href = \"$url\";
						}
					}); 
				}, 100);</script>";
		} else {
			echo "Error: " . $sql1 . "<br>" . mysqli_error($conn);
		}
	}
	else
	{
		$query="select module_name from $bai_pro3.module_master where module_name='$module'";
		$sql_result=mysqli_query($conn, $query);
		if(mysqli_num_rows($sql_result)>0)
		{
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

		}
		else
		{
 
			$plan_modules="select * from $bai_pro3.plan_modules where module_id='$module'";
			$plan_modules_result= mysqli_query($conn, $plan_modules);
			$row_count=mysqli_num_rows($plan_modules_result);
			if($row_count==0)
			{
				$sql9 = "INSERT INTO $bai_pro3.module_master (module_name,date_time,module_description,status,section,color,label,mapped_cut_table,block_priorities,mini_plant_id)
					VALUES ('$module','$datetime','$description','$modulestatus','$sections','$module_color','$module_label','$mapped_cut_table','$block_priorities',".$mini_plant.")";

				if (mysqli_query($conn, $sql9))
				{
					$url=getFullURL($_GET['r'],'add_module.php','N');
					echo"<script>setTimeout(function () { 
						swal({
						  title: 'New record created successfully',
						  type: 'success',
						  confirmButtonText: 'OK'
						},
						function(isConfirm){
						  if (isConfirm) {
							window.location.href = \"$url\";
						  }
						}); }, 100);</script>";
				}
				else
				{
					echo "Error: " .$sql9. "<br>" . mysqli_error($conn);
				} 
			
			 	$sql7 = "INSERT INTO $bai_pro3.plan_modules (module_id,section_id,power_user) VALUES ('$module','$sections','$username')";
				if (mysqli_query($conn, $sql7)) {
					
				} else {
					echo "Error: " . $sql7 . "<br>" . mysqli_error($conn);
				} 
			}
			else
			{
				$url=getFullURL($_GET['r'],'add_module.php','N');
					echo"<script>setTimeout(function () { 
						swal({
						  title: 'Module Already Existed in Plan Modules Table',
						  type: 'warning',
						  confirmButtonText: 'OK'
						},
						function(isConfirm){
						  if (isConfirm) {
							window.location.href = \"$url\";
						  }
						}); }, 100);</script>";
			}
		}
	}


	$insert_query="delete from bai_pro3.sections_db WHERE sec_head='$sections'";
	if (mysqli_query($conn, $insert_query))
	{

	} 
	else
	{
		echo "Error: " . $insert_query . "<br>" . mysqli_error($conn);
	}

	$sections_query="SELECT GROUP_CONCAT(module_id)as module_concat FROM bai_pro3.`plan_modules` WHERE section_id='$sections'";
	$result3 = mysqli_query($conn, $sections_query);
	$row = mysqli_fetch_assoc($result3);
	$total_modules=$row['module_concat'];
	$sql123 = "INSERT INTO $bai_pro3.sections_db (sec_id,sec_head,sec_mods) VALUES ('$sections','$sections','$total_modules')";
	if (mysqli_query($conn, $sql123)) {
	} else {
		echo "Error: " . $sql123 . "<br>" . mysqli_error($conn);
	}	
}

mysqli_close($conn);
//header('location: index.php?r=L3NmY3NfYXBwL2FwcC9tYXN0ZXJzL2N1dHRpbmcvY3V0dGluZ190YWJsZV9hZGQucGhw');
exit;


?>
