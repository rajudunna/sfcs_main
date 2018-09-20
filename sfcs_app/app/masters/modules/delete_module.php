<script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">
<?php
$rid=$_GET['rowid1'];
$module_name=$_GET['module_name'];
$section=$_GET['section'];
// echo $rid;
// $servername = "192.168.0.110:3326";
// $username = "baiall";
// $password = "baiall";
// $dbname = "bai_pro3";

// Create connection
// $conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config.php');
$conn=$link;
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
if($rid!=''){
	$url=getFullURL($_GET['r'],'add_module.php','N');
	echo"<script>setTimeout(function () { 
		swal({
		  title: 'Are you sure?',
		  text: 'Your will not be able to recover this Record!',
		  type: 'warning',
		  confirmButtonText: 'OK'
		},
		function(isConfirm){
		  if (isConfirm) {
			window.location.href = \"$url\";
		  }
		}); }, 100);</script>";

		$plan_dashboard11="select * from $bai_pro3.plan_dashboard where module='$module_name'";
		$result11= mysqli_query($conn, $plan_dashboard11);
		$rowcount11=mysqli_num_rows($result11);


		$plan_dashboard_input12="select * from $bai_pro3.plan_dashboard_input where input_module='$module_name'";
		$result12= mysqli_query($conn, $plan_dashboard_input12);
		$rowcount12=mysqli_num_rows($result12);


		$fabric_priorities="select * from $bai_pro3.fabric_priorities where module='$module_name'";
		$fabric_priorities1= mysqli_query($conn, $fabric_priorities);
		$rowcount13=mysqli_num_rows($fabric_priorities1);
		
if($rowcount11>0 or 	$rowcount12>0 or 	$rowcount13>0){

	$url=getFullURL($_GET['r'],'add_module.php','N');
			//echo $url;
			//echo "Record updated successfully";
			echo"<script>setTimeout(function () { 
				swal({
				  title: 'Module Already in Production',
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
$delete="delete from bai_pro3.module_master where id='$rid'";
if (mysqli_query($conn, $delete)) {
			//header('location: index.php?r=L3NmY3NfYXBwL2FwcC9tYXN0ZXJzL2NhdGVnb3JpZXMvYWRkX2NhdGVnb3JpZXMucGhw');
		} else {
			echo "Error: " . $sql . "<br>" . mysqli_error($conn);
		}
		
$delete1="delete from bai_pro3.plan_modules where module_id='$module_name'";
if (mysqli_query($conn, $delete1)) {
			//header('location: index.php?r=L3NmY3NfYXBwL2FwcC9tYXN0ZXJzL2NhdGVnb3JpZXMvYWRkX2NhdGVnb3JpZXMucGhw');
		} else {
			echo "Error: " . $sql . "<br>" . mysqli_error($conn);
		}		
		
$delete2="select * from bai_pro3.plan_modules where module_id='$module_name'";
$result4= mysqli_query($conn, $delete2);
$rowcount=mysqli_num_rows($result4);
if($rowcount==0 or $rowcount==''){
 $sections_query1="SELECT GROUP_CONCAT(module_id)as module_concat FROM $bai_pro3.`plan_modules` WHERE section_id='$section'";
	   $result5= mysqli_query($conn, $sections_query1);
      $row = mysqli_fetch_assoc($result5);
      $total_modules1=$row['module_concat'];
       $delete5 = "update $bai_pro3.sections_db set sec_id='$section',sec_head='$section',sec_mods='$total_modules1' where sec_head='$section'"; 
	   if (mysqli_query($conn, $delete5)) {
			//header('location: index.php?r=L3NmY3NfYXBwL2FwcC9tYXN0ZXJzL2NhdGVnb3JpZXMvYWRkX2NhdGVnb3JpZXMucGhw');
		} else {
			echo "Error: " . $sql . "<br>" . mysqli_error($conn);
		}	
	
}
	
	}

}
?>
