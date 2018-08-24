<script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">
<?php
// echo $_POST['table_name'];
$short_key_code=$_REQUEST['short_key_code'];
//echo 'Hlo'.$short_key_code;
$row_id=$_REQUEST['c_id'];
// echo $row_id;die();
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

if (empty($short_key_code)) 
{
    // echo "Please fill values";
    $url=getFullURL($_GET['r'],'create_short_key_code.php','N');
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
		$sql = "update $brandix_bts.ops_short_cuts set short_key_code='$short_key_code' where id=$row_id";
		
		if (mysqli_query($conn, $sql)) {
			$url=getFullURL($_GET['r'],'create_short_key_code.php','N');
			//echo $url;
			//echo "Record updated successfully";
			echo"<script>setTimeout(function () { 
				swal({
				  title: 'Key Code updated successfully',
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
		$query="select short_key_code from $brandix_bts.`ops_short_cuts` where short_key_code='$short_key_code'";
		$sql_result=mysqli_query($conn, $query);
		if(mysqli_num_rows($sql_result)>0)
					{
						//echo "<script>sweetAlert('Category Already Existed','','warning');</script>";

						$url=getFullURL($_GET['r'],'create_short_key_code.php','N');


						echo"<script>setTimeout(function () { 
							swal({
							  title: 'Key Code Already Existed!',
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
					
							$sql = "INSERT INTO $brandix_bts.ops_short_cuts (short_key_code)
							VALUES ('$short_key_code')";

							if (mysqli_query($conn, $sql)) 
							{
								$url=getFullURL($_GET['r'],'create_short_key_code.php','N');
								//echo "New record created successfully";
								echo"<script>setTimeout(function () { 
									swal({
									  title: 'Short Code created successfully',
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
