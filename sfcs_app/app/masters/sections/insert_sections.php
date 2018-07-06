<script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">
<?php
$sec_id=$_REQUEST['sec_id'];
$sec_head =$_REQUEST['sec_head'];
$sec_mods =$_REQUEST['sec_mods'];
$ims_priority_boxes=$_REQUEST['ims_priority_boxes'];

// $servername = "192.168.0.110:3326";
// $username = "baiall";
// $password = "baiall";
// $dbname = "bai_pro3";

// Create connection
// $conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
// if (!$conn) {
//     die("Connection failed: " . mysqli_connect_error());
// }
// include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config.php');
$conn=$link;
if (empty($sec_head) || empty($sec_mods)|| empty($ims_priority_boxes)) {
	$url=getFullURL($_GET['r'],'add_section.php','N');
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
}else{
	if($sec_id>0){
		
		//update
		$sql = "update $bai_pro3.sections_db set sec_head='$sec_head',sec_mods='$sec_mods',ims_priority_boxes='$ims_priority_boxes' where sec_id=$sec_id";
		//echo $sql;
		if (mysqli_query($conn, $sql)) {
			$url=getFullURL($_GET['r'],'add_section.php','N');
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




		$query1="select sec_head from $bai_pro3.sections_db where sec_head='$sec_head'";
		$sql_result1=mysqli_query($conn, $query1);
		
		
		if(mysqli_num_rows($sql_result1)>0){
			$url=getFullURL($_GET['r'],'add_section.php','N');
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




		}
		
		
		
		
		
		
		else{
		//insert 
		$sql = "INSERT INTO $bai_pro3.sections_db (sec_head,sec_mods,ims_priority_boxes)
VALUES ('$sec_head','$sec_mods','$ims_priority_boxes')";
		if (mysqli_query($conn, $sql)) {
			$url=getFullURL($_GET['r'],'add_section.php','N');
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
//header('location: index.php?r=L3NmY3NfYXBwL2FwcC9tYXN0ZXJzL3NlY3Rpb25zL2FkZF9zZWN0aW9uLnBocA==');
exit;
?>