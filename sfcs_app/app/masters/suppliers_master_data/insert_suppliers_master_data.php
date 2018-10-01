<script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">
<?php
// echo $_POST['table_name'];
$tid =$_REQUEST['tid'];
$product_code =$_POST['product_code'];
$supplier_code =$_POST['supplier_code'];
$complaint_no =$_POST['complaint_no'];
$supplier_m3_code =$_POST['supplier_m3_code'];
$color_code =$_POST['color_code'];
//echo $color_code;
$seq_no=$_POST['seq_no'];
 //echo $seq_no;die();
// $servername = "192.168.0.110:3326";
// $username = "baiall";
// $password = "baiall";
// $dbname = "bai_rm_pj1";
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config.php');
$conn=$link;

// // Create connection
// $conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (empty($product_code) || empty($supplier_code) || empty($complaint_no) || empty($supplier_m3_code) || empty($color_code)) 
{
	$url=getFullURL($_GET['r'],'save_suppliers_master_data.php','N');
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
	if($tid>0){
		//update
		$sql = "update $bai_rm_pj1.inspection_supplier_db set product_code='$product_code',supplier_code='$supplier_code',complaint_no='$complaint_no',supplier_m3_code='$supplier_m3_code',color_code='$color_code',seq_no='$seq_no' where tid=$tid";
		//echo $sql;exit;
		if (mysqli_query($conn, $sql)) {
			$url=getFullURL($_GET['r'],'save_suppliers_master_data.php','N');
			
			// echo "Record updated successfully";
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
		
		$count_qry= "select * from $bai_rm_pj1.inspection_supplier_db where product_code = '$product_code' and (supplier_code = '$supplier_code' or supplier_m3_code = '$supplier_m3_code')"; 
		// echo $count_qry;
		$count = mysqli_num_rows(mysqli_query($conn, $count_qry));
		if($count > 0){
			// echo $count;die();
			$url=getFullURL($_GET['r'],'save_suppliers-master_data.php','N');


		echo "<script>setTimeout(function () { 
			swal({
			  title: 'inspection supplier Already Existed!',
			  text: 'Message!',
			  type: 'warning',
			  confirmButtonText: 'OK'
			},
			function(isConfirm){
			  if (isConfirm) {
				window.location.href = \"$url\";
			  }
			}); }, 100);</script>";
			// $error_msg = 1;
			// echo "<script>alert('Enter data correctly.')</script>";
		}
		else{
			$sql = "INSERT INTO $bai_rm_pj1.inspection_supplier_db(product_code, supplier_code,complaint_no,supplier_m3_code,color_code,seq_no) VALUES('$product_code','$supplier_code','$complaint_no','$supplier_m3_code','$color_code','$seq_no')";
			if (mysqli_query($conn, $sql)) {
				$url=getFullURL($_GET['r'],'save_suppliers_master_data.php','N');


		echo"<script>setTimeout(function () { 
			swal({
			  title: 'record inserted successfully ',
			  text: 'Message!',
			  type: 'warning',
			  confirmButtonText: 'OK'
			},
			function(isConfirm){
			  if (isConfirm) {
				window.location.href = \"$url\";
			  }
			}); }, 100);</script>";
				// echo "New record created successfully";
			}
			else {
				echo "Error: " . $sql . "<br>" . mysqli_error($conn);
			}
		}
		//insert 
	}
}

$url1 = getFullURL($_GET['r'],'save_suppliers_master_data.php','N');


mysqli_close($conn);
// header("location: $url1");
exit;
// echo "<script>alert('Enter data correctly.')</script>";
?>