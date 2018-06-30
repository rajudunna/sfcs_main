<script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">
<?php
// echo $_POST['table_name'];
$emp_id=$_REQUEST['emp_id'];
$row_id=$_REQUEST['c_id'];
// echo $row_id;die();
$emp_name=$_REQUEST['emp_name'];

// echo $status;die();
// $servername = "192.168.0.110:3326";
// $username = "baiall";
// $password = "baiall";
// $dbname = "bai_pro3";
// include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config.php');
$conn=$link;
// Create connection
// $conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
// if (!$conn) {
//     die("Connection failed: " . mysqli_connect_error());
// }

if (empty($emp_id)  || empty($emp_name)) 
{
    // echo "Please fill values";
    $url=getFullURL($_GET['r'],'create_leader_names.php','N');
    //echo $url;
    //echo "Record updated successfully";
    echo"<script>setTimeout(function () { 
        swal({
          title: 'Please fill values',
          text: 'Message!',
          type: 'error',
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
	if($row_id>0)
	{
		//update
		$sql = "update tbl_leader_name set emp_id='$emp_id',emp_name='$emp_name' where id=$row_id";
		
		if (mysqli_query($conn, $sql)) {
			$url=getFullURL($_GET['r'],'create_leader_names.php','N');
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

						$url=getFullURL($_GET['r'],'create_leader_names.php','N');


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
					
							$sql = "INSERT INTO tbl_leader_name (emp_id,emp_name)
							VALUES ('$emp_id','$emp_name')";

							if (mysqli_query($conn, $sql)) 
							{
								$url=getFullURL($_GET['r'],'create_leader_names.php','N');
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
//header('location: index.php?r=L3NmY3NfYXBwL2FwcC9tYXN0ZXJzL2NhdGVnb3JpZXMvYWRkX2NhdGVnb3JpZXMucGhw');
exit;
?>
