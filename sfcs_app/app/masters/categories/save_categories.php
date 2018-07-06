<script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">
<?php
// echo $_POST['table_name'];
$category_name=$_REQUEST['category_name'];
$row_id=$_REQUEST['c_id'];
// echo $row_id;die();
$category_status=$_REQUEST['category_status'];
$cat_select=$_REQUEST['cat_selection'];
<<<<<<< HEAD
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config.php');
// echo $bai_pro3;die();
=======

// echo $status;die();
>>>>>>> UAT2
// $servername = "192.168.0.110:3326";
// $username = "baiall";
// $password = "baiall";
// $dbname = "bai_pro3";
<<<<<<< HEAD

// Create connection
$conn = $link;
=======
// include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config.php');
$conn=$link;
// Create connection
// $conn = mysqli_connect($servername, $username, $password, $dbname);
>>>>>>> UAT2
// Check connection
// if (!$conn) {
//     die("Connection failed: " . mysqli_connect_error());
// }
<<<<<<< HEAD
=======

>>>>>>> UAT2
if (empty($category_name) || empty($category_status) || empty($cat_select)) 
{
	$url=getFullURL($_GET['r'],'add_categories.php','N');
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
	// echo "Please fill values";
}
else
{
	if($row_id>0)
	{
		//update
		$sql = "update tbl_category set cat_name='$category_name',status='$category_status',cat_selection='$cat_select' where id=$row_id";
		
		if (mysqli_query($conn, $sql)) {
			$url=getFullURL($_GET['r'],'add_categories.php','N');
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
		$query="select cat_name from tbl_category where cat_name='$category_name'";
		$sql_result=mysqli_query($conn, $query);
		if(mysqli_num_rows($sql_result)>0)
					{
						//echo "<script>sweetAlert('Category Already Existed','','warning');</script>";

						$url=getFullURL($_GET['r'],'add_categories.php','N');


						echo"<script>setTimeout(function () { 
							swal({
							  title: 'Category Already Existed!',
							  text: 'Message!',
							  type: 'warning',
							  confirmButtonText: 'OK'
							},
							function(isConfirm){
							  if (isConfirm) {
								window.location.href = \"$url\";
							  }
							}); }, 100);</script>";

			
						//echo "<script>window.location = 'index.php?r=L3NmY3NfYXBwL2FwcC9tYXN0ZXJzL2NhdGVnb3JpZXMvYWRkX2NhdGVnb3JpZXMucGhw'</script>";
					}else{
					
							$sql = "INSERT INTO tbl_category (cat_name, status,cat_selection)
							VALUES ('$category_name','$category_status','$cat_select')";

							if (mysqli_query($conn, $sql)) 
							{
								$url=getFullURL($_GET['r'],'add_categories.php','N');
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

mysqli_close($conn);
<<<<<<< HEAD
header('location: '.getFullURLLevel($_GET['r'],'add_categories.php',0,'N'));
exit;
?>
<!-- index.php?r=L3NmY3NfYXBwL2FwcC9tYXN0ZXJzL2NhdGVnb3JpZXMvYWRkX2NhdGVnb3JpZXMucGhw -->
=======
//header('location: index.php?r=L3NmY3NfYXBwL2FwcC9tYXN0ZXJzL2NhdGVnb3JpZXMvYWRkX2NhdGVnb3JpZXMucGhw');
exit;
?>
>>>>>>> UAT2
