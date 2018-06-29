<script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">
<?php
// echo $_POST['table_name'];

$pack_method_name =$_REQUEST['pack_method_name'];
$status =$_REQUEST['packing_status'];
$pack_id=$_REQUEST['pack_id'];
// echo $status;die();

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
if (empty($pack_method_name) || empty($status)) {
	echo "Please fill values";
}else{
	if($pack_id>0)
	{
		//update
		$sql = "update $bai_pro3.pack_methods set pack_method_name='$pack_method_name',status='$status' where pack_id=$pack_id";
		//echo $sql;
		if (mysqli_query($conn, $sql)) {
			$url=getFullURL($_GET['r'],'add_packing_method.php','N');
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

		$query="select pack_method_name from $bai_pro3.pack_methods where pack_method_name='$pack_method_name'";
		$sql_result=mysqli_query($conn, $query);
		if(mysqli_num_rows($sql_result)>0){
		$url=getFullURL($_GET['r'],'add_packing_method.php','N');


		echo"<script>setTimeout(function () { 
			swal({
			  title: 'Packing Method Already Existed!',
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
		$sql = "INSERT INTO $bai_pro3.pack_methods (pack_method_name, status) VALUES ('$pack_method_name','$status')";
		if (mysqli_query($conn, $sql)) {
			$url=getFullURL($_GET['r'],'add_packing_method.php','N');
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
//header('location: index.php?r=L3NmY3NfYXBwL2FwcC9tYXN0ZXJzL3BhY2tfbWV0aG9kcy9hZGRfcGFja2luZ19tZXRob2QucGhw');
exit;
?>