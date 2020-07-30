

<script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">
<?php

$dr_id=$_POST['dr_id'];
// echo $dr_id;die();
$code=$_POST['prefix_name'];
$department=$_POST['prefix'];
$reason=$_POST['type_of_sewing'];
$type=$_POST['bg_color'];
$plantcode=$_SESSION['plantCode'];
$username=$_SESSION['userName'];


include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config.php');
$conn=$link;





if (empty($code) || empty($department) || empty($reason) || empty($type) ) 
{
	$url=getFullURL($_GET['r'],'sewing_jobs_prefix_add.php','N');
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
		$sql = "update $mdm.tbl_sewing_job_prefix set prefix_name='$code',prefix='$department',type_of_sewing='$reason',bg_color='$type',updated_user='$username',updated_at='".date('Y-m-d')."' where plant_code='$plantcode' and id=$dr_id";
		
		if (mysqli_query($conn, $sql)) {
			$url=getFullURL($_GET['r'],'sewing_jobs_prefix_add.php','N');
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
	}
	else
	{



		$query1="select * from $mdm.tbl_sewing_job_prefix  where plant_code='$plantcode' and prefix_name='$code'";
		$sql_result1=mysqli_query($conn, $query1);
		
		if(mysqli_num_rows($sql_result1)>0){
			$url=getFullURL($_GET['r'],'sewing_jobs_prefix_add.php','N');
			echo"<script>setTimeout(function () { 
				swal({
				  title: 'Sewing Job Prefix Already Exists!',
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




		$sql = "INSERT INTO $mdm.tbl_sewing_job_prefix (prefix_name,prefix,type_of_sewing,bg_color,plant_code,created_user,created_at)
		VALUES ('$code','$department','$reason','$type','$plantcode','$username','".date('Y-m-d')."')";

		if (mysqli_query($conn, $sql)) 
		{
			$url=getFullURL($_GET['r'],'sewing_jobs_prefix_add.php','N');
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

$url1 = getFullURL($_GET['r'],'sewing_jobs_prefix_add.php','N');


mysqli_close($conn);
//header('location: index.php?r=L3NmY3NfYXBwL2FwcC9tYXN0ZXJzL2Rvd250aW1lcmVhc29uL2Rvd25fdGltZV9yZWFzb25fYWRkLnBocA==');
exit;
?>