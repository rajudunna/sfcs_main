<script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">
<?php
$tid =$_REQUEST['tid'];
$product_code =$_POST['product_code'];
$supplier_code =$_POST['supplier_code'];
$complaint_no =$_POST['complaint_no'];
$supplier_m3_code =$_POST['supplier_m3_code'];
$color_code =$_POST['color_code'];
$seq_no=$_POST['seq_no'];
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config.php');
$conn=$link;
if( strlen(trim($product_code))<=0 || strlen(trim($supplier_code))<=0 || strlen(trim($complaint_no))<=0 || strlen(trim($supplier_m3_code))<=0 || strlen(trim($color_code))<=0 || strlen(trim($seq_no))<=0 ) 
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
			if( strlen(trim($product_code))<=0 || strlen(trim($supplier_code))<=0 || strlen(trim($complaint_no))<=0 || strlen(trim($supplier_m3_code))<=0 || strlen(trim($color_code))<=0 || strlen(trim($seq_no))<=0 ) 
			{
				$url=getFullURL($_GET['r'],'save_suppliers_master_data.php','N');
				echo"<script>
					setTimeout(function(){ 
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
					}); }, 100);
				</script>";
			}else{
					$sql = "update $mdm.inspection_supplier_db set product_code='$product_code',supplier_code='$supplier_code',complaint_no='$complaint_no',supplier_m3_code='$supplier_m3_code',color_code='$color_code',seq_no='$seq_no' where tid=$tid";
					if(mysqli_query($conn, $sql)){
						$url=getFullURL($_GET['r'],'save_suppliers_master_data.php','N');
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
					}else{
						echo "Error: " . $sql . "<br>" . mysqli_error($conn);
					}
			}
		}else{	
			$count_qry= "select * from $mdm.inspection_supplier_db where product_code = '$product_code' and (seq_no = '$seq_no') "; 
			$count = mysqli_num_rows(mysqli_query($conn, $count_qry));
				if($count > 0){
					$url=getFullURL($_GET['r'],'save_suppliers_master_data.php','N');
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
				}
				else{
					$sql = "INSERT INTO $mdm.inspection_supplier_db(product_code, supplier_code,complaint_no,supplier_m3_code,color_code,seq_no) VALUES('$product_code','$supplier_code','$complaint_no','$supplier_m3_code','$color_code','$seq_no')";
					if (mysqli_query($conn, $sql)) {
						$url=getFullURL($_GET['r'],'save_suppliers_master_data.php','N');
						echo"<script>setTimeout(function () { 
						swal({
						title: 'record inserted successfully ',
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
					else {
						echo "Error: " . $sql . "<br>" . mysqli_error($conn);
					}
				} 
		}
}
$url1 = getFullURL($_GET['r'],'save_suppliers_master_data.php','N');
mysqli_close($conn);
exit;
?>