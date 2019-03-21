
<?php
	include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config.php');
	$url=getFullURL($_GET['r'],'plant_timings_add.php','N');

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
	if($em==0 && $eh > 0){
		$em=59;
		$eh -= 1;
	}else{
		$em=$em-1;
	}
	if($sh > 0 && $sh <= 11)
		$sday_part = 'AM';
	else	
		$sday_part = 'PM';
	$sh = str_pad($sh,2,"0",STR_PAD_LEFT);
	$sm = str_pad($sm,2,"0",STR_PAD_LEFT);
	$eh = str_pad($eh,2,"0",STR_PAD_LEFT);
	$em = str_pad($em,2,"0",STR_PAD_LEFT);
	$actual_eh = str_pad($actual_eh,2,"0",STR_PAD_LEFT);

	$start_time = "$sh:"."$sm:"."00";
	$end_time   = "$eh:"."$em:"."59";
			
	if($exist_id > 0)
	{
		$flag = verify_start_time($start_time,$end_time,$sh,$sm,$eh,$em,$exist_id);
		if($flag == 1){
			$url.="&id=$exist_id&time_value=$time_value&time_display=$time_display&day_part=$day_part&start_time=$start_time&end_time=$end_time";
			echo"<script>
				swal('Time span Is Already Defined','Select Another Time span','error');
				setTimeout(function (){ window.location.href = '$url'; },3000);
			</script>";
			exit();
			
		}

		//update
		$sql = "UPDATE $bai_pro3.tbl_plant_timings set time_value='$time_value',start_time='$start_time',end_time='$end_time',
				day_part='$sday_part',time_display='$sh-$actual_eh' where time_id=$exist_id";
		if(mysqli_query($conn, $sql)) {
			echo"<script>swal('Updated Successfully','','success');setTimeout(function (){ window.location.href = '$url'; },1000);</script>";
		} else {
			echo "Error: " . $sql . "<br>" . mysqli_error($conn);
		}
	}else
	{
		$flag = verify_start_time($start_time,$end_time,$sh,$sm,$eh,$em);
		if($flag == 1){
			$url.="&time_value=$time_value&time_display=$time_display&day_part=$day_part&start_time=$start_time&end_time=$end_time";
			echo"<script>
				swal('Time span Is Already Defined','Select Another Time span','error');
				setTimeout(function (){ window.location.href = '$url'; },3000);
			</script>";
			exit();
			
		}

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
				echo"<script>swal('Inserted Successfully','','success');setTimeout(function (){ window.location.href = '$url'; },1000);</script>";
			} 
			else 
			{
				echo "Error: " . $sql . "<br>" . mysqli_error($conn);
			}
		}
	}


function verify_start_time($start_time,$end_time,$sh,$sm,$eh,$em,$id=0){
	global $link;
	global $bai_pro3;
	//verifying if the timings already exists between the incoming new timing period
	$exist_query = "SELECT * FROM tbl_plant_timings WHERE ((start_time BETWEEN '$start_time' AND '$end_time' ) 
			OR (end_time BETWEEN '$start_time' AND '$end_time')) ";
	if($id > 0)
		$exist_query.=" AND time_id<>$id";
	if(mysqli_num_rows(mysqli_query($link,$exist_query)) > 0){
		return 1;
	}else{
		//If tables start_time and end_time is not between incoming time period then checking
		//if incoming time lapse is completely between an existing time period in table
		$verify_query = "SELECT * FROM tbl_plant_timings WHERE (start_time < '$start_time') and (end_time > '$start_time')";
		if($id > 0)
			$verify_query.=" AND time_id<>$id";
		if(mysqli_num_rows(mysqli_query($link,$verify_query)) > 0)
			return 1;
	}
	
	return 0;
}	
?>

