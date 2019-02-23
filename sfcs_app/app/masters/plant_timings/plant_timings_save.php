<script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">
<?php

$dr_id=$_POST['dr_id'];
$code=$_POST['time_value'];
$day_part=$_POST['day_part'];
$start1 = $_POST['start_time']; 
$end1   = $_POST['end_time'];
$tval = $_POST['time_value'];						
$start = explode(':',$start1);
$end = explode(':',$end1);	
$sh = $start[0];
$sm = $start[1];
$eh = $end[0];
$eh_dummy = $eh;
$em = $end[1];	


if($em==0){
	$em=59;
	$eh -= 1;
}else{
	$em=$em-1;
}
$start_time = "$sh:"."$sm:"."00";
$end_time   = "$eh:"."$em:"."59";
							
										


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
			start_time='$start_time',end_time='$end_time',day_part='$day_part',time_display='$sh-$eh_dummy' where time_id=$dr_id";
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
				// $query1="select * from $bai_pro3.tbl_plant_timings where time_value='$code' and (time_display='$department' or day_part='$day_part')";
				$query1 = "SELECT * from $bai_pro3.tbl_plant_timings where time_value='$code' ";
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
								
						$sql = "INSERT INTO $bai_pro3.tbl_plant_timings (time_value,time_display,start_time,end_time,day_part)
						VALUES ('$tval','$sh-$eh_dummy','$start_time','$end_time','$day_part')";

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