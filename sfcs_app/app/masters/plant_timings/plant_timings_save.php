<script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">
<?php

$dr_id=$_POST['dr_id'];
$code=$_POST['time_value'];
$day_part=$_POST['day_part'];
$start1 = $_POST['time_display']; 
$end1   = $_POST['time_display1'];
$tval = $_POST['time_value'];						
$start = explode(':',$start1);
$end = explode(':',$end1);	
$sh = $start[0];
$sm = $start[1];
$eh = $end[0];
$em = $end[1];	
	if($day_part=='PM')	{
									$sh=$sh+12;
									$eh=$eh+12;
								}

								if($sh >=24)	{
									$sh=$sh-24;
								}
								if($eh >=24){
									$eh=$eh-24;
								}
										
								if($em==0){
									$em=59;
								}else{
									$em=$em-1;
								$eh=$eh-1;
								}
								// $end_time = "$eh:30:00";
								// if($sm == 0){
								// 	$start_time = ($sh+2).':29:59';
								// 	if($sh >=23)	{
										$start_time = "$sh:"."$sm:"."00";
										$end_time = "$sh:"."$em:"."59";

								// 	}
								// 	$start_time = ($sh+2).':29:59';
								// }else{
								// 	$start_time = "$sh:".($sm+2).":59";
								// }


include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config.php');
$conn=$link;


	if (empty($code) || empty($start_time) || empty($end_time) ||  empty($day_part) ) 
{
	$url=getFullURL($_GET['r'],'plant_timings_add.php','N');
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
}
else
{
		if($dr_id>0)
		{
			//update
			$sql = "update $bai_pro3.tbl_plant_timings set time_value='$code',
			start_time='$start_time',end_time='$end_time',day_part='$day_part',time_display='$start1-$end1' where time_id=$dr_id";
				if (mysqli_query($conn, $sql)) {
					$url=getFullURL($_GET['r'],'plant_timings_add.php','N');
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
		}else
		{
				$query1="select * from $bai_pro3.tbl_plant_timings where time_value='$code' and (time_display='$department' or day_part='$day_part')";
				$sql_result1=mysqli_query($conn, $query1);
				
				if(mysqli_num_rows($sql_result1)>0){
						$url=getFullURL($_GET['r'],'plant_timings_add.php','N');
						echo"<script>setTimeout(function () { 
							swal({
								title: 'Plant Timings already exists',
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
								$start1 = $_POST['time_display']; 
								$end1   = $_POST['time_display1'];
								$tval = $_POST['time_value'];						
								$start = explode(':',$start1);
								$end = explode(':',$end1);								
								$sh = $start[0];
								$sm = $start[1];
								$eh = $end[0];
								$em = $end[1];	
								if($day_part=='PM')	{
									$sh=$sh+12;
									$eh=$eh+12;
								}

								if($sh >=24)	{
									$sh=$sh-24;
								}
								if($eh >=24){
									$eh=$eh-24;
								}
								
								if($em==0){
									$em=59;
								}else{
									$em=$em-1;
								$eh=$eh-1;
								}
								// $end_time = "$eh:30:00";
								// if($sm == 0){
								// 	$start_time = ($sh+2).':29:59';
								// 	if($sh >=23)	{
										$start_time = "$sh:"."$sm:"."00";
										$end_time = "$sh:"."$em:"."59";

								// 	}
								// 	$start_time = ($sh+2).':29:59';
								// }else{
								// 	$start_time = "$sh:".($sm+2).":59";
								// }
								$sql = "INSERT INTO $bai_pro3.tbl_plant_timings (time_value,time_display,start_time,end_time,day_part)
								VALUES ('$tval','$start1-$end1','$start_time','$end_time','$day_part')";

								if (mysqli_query($conn, $sql)) 
								{
									$url=getFullURL($_GET['r'],'plant_timings_add.php','N');
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
								} 
								else 
								{
										echo "Error: " . $sql . "<br>" . mysqli_error($conn);
								}
					}
			}
	}

$url1 = getFullURL($_GET['r'],'plant_timings_add.php','N');


mysqli_close($conn);
//header('location: index.php?r=L3NmY3NfYXBwL2FwcC9tYXN0ZXJzL2Rvd250aW1lcmVhc29uL2Rvd25fdGltZV9yZWFzb25fYWRkLnBocA==');
exit;
?>