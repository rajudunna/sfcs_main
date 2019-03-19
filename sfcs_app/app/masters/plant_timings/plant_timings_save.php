
<?php
	include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config.php');
	$conn=$link;
	//Update Record on GET
	$exist_id = (int)$_POST['id'];
	//New record on POST
	$sh = $_POST['start_hour'];
	$eh = $_POST['end_hour'];
	$sm = $_POST['start_min'];
	$em = $_POST['end_min'];
	$time_value = $_POST['time_value'];
	$sday_part = $_POST['start_m'];
	$eday_part = $_POST['start_e'];	
	$actual_eh = $eh;
	if($em==0){
		$em=59;
		$eh -= 1;
	}else{
		$em=$em-1;
	}
	$sh = str_pad($sh,2,"0",STR_PAD_LEFT);
	$sm = str_pad($sm,2,"0",STR_PAD_LEFT);
	$eh = str_pad($eh,2,"0",STR_PAD_LEFT);
	$em = str_pad($em,2,"0",STR_PAD_LEFT);
	$actual_eh = str_pad($actual_eh,2,"0",STR_PAD_LEFT);

	$start_time = "$sh:"."$sm:"."00";
	$end_time   = "$eh:"."$em:"."59";
			
	if($exist_id > 0)
	{
		//update
		$sql = "UPDATE $bai_pro3.tbl_plant_timings set time_value='$time_value',start_time='$start_time',end_time='$end_time',
				day_part='$sday_part',time_display='$sh-$actual_eh' where time_id=$exist_id";
		if(mysqli_query($conn, $sql)) {
			$url=getFullURL($_GET['r'],'plant_timings_add.php','N');
			echo"<script>swal('Updated Successfully','','success');setTimeout(function (){ window.location.href = '$url'; },1000);</script>";
		} else {
			echo "Error: " . $sql . "<br>" . mysqli_error($conn);
		}
	}else
	{
		$query1 = "SELECT * from $bai_pro3.tbl_plant_timings where time_value='$time_value' ";
		$sql_result1=mysqli_query($conn, $query1);
		if(mysqli_num_rows($sql_result1)>0){
			$url=getFullURL($_GET['r'],'plant_timings_add.php','N');
			echo"<script>swal('Time Value Already Exists','','warning');setTimeout(function (){ window.location.href = '$url'; },1000);</script>";
			
		}else{
			$sql = "INSERT INTO $bai_pro3.tbl_plant_timings (time_value,time_display,start_time,end_time,day_part)
			VALUES ('$time_value','$sh-$actual_eh','$start_time','$end_time','$sday_part')";
			if(mysqli_query($conn, $sql)) 
			{
				$url=getFullURL($_GET['r'],'plant_timings_add.php','N');
				//echo "New record created successfully";
				echo"<script>swal('Inserted Successfully','','success');setTimeout(function (){ window.location.href = '$url'; },1000);</script>";
			} 
			else 
			{
				echo "Error: " . $sql . "<br>" . mysqli_error($conn);
			}
		}
	}

$url1 = getFullURL($_GET['r'],'plant_timings_add.php','N');
mysqli_close($conn);
//header('location: index.php?r=L3NmY3NfYXBwL2FwcC9tYXN0ZXJzL2Rvd250aW1lcmVhc29uL2Rvd25fdGltZV9yZWFzb25fYWRkLnBocA==');
exit;
?>