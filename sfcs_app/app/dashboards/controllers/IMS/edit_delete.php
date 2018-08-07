<html lang="en">
<head>
	<title>Edit Bundle Operation</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="IE=9; IE=8; IE=7; IE=EDGE" />
	<!--<link rel="stylesheet" href="cssjs/bootstrap.min.css">
	<script src="js/jquery-3.2.1.min.js"></script>
	<script src="js/bootstrap.min.js"></script>-->
	<style>
		.pull{    
			float: right!important;
			margin-top: -7px;
		}
	</style>
	 <script>
function validateQty(event) 
{
	event = (event) ? event : window.event;
	var charCode = (event.which) ? event.which : event.keyCode;
	if (charCode > 31 && (charCode < 48 || charCode > 57)) {
		return false;
	}
	return true;
}
</script>
</head>
<?php

	include(getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));
	include(getFullURLLevel($_GET['r'],'common/config/functions.php',4,'R'));	
	
	if(isset($_GET['id']))
	{
		
		$operation_name = "";
		$operation_code = "";
		$id = $_GET['id'];
	
		$qry = "select * from $brandix_bts.tbl_ims_ops where id=".$id;
		//echo $qry;	
		$res_do_num = mysqli_query($link,$qry);
		//$row=[];
		while($res_result = mysqli_fetch_array($res_do_num))
		{
			$row[] = $res_result;
	    }


	    if(isset($_POST['submit']))
	    {

				$qry_insert1 = "update $brandix_bts.tbl_ims_ops set operation_name='$operation_name',operation_code='$operation_code' where id='$id'";
				echo $qry_insert1;
				$res_do_num1 = mysqli_query($link,$qry_insert1);
				echo "<h3 style='color:red;text-align:center;'>Please Wait!!!  While Redirecting to page !!!</h3>";
				//$sql_message = 'Operation Updated Successfully...';
				//echo '<script>$(".sql_message").html("'.$sql_message.'");$(".alert").show();</script>';
				// echo "<script>sweetAlert('Operation Updated Successfully','','success')</script>";
				$hurl = getFullURLLevel($_GET['r'],'master.php',0,'N');
				// header('location:'.$hurl);
				echo "<script type=\"text/javascript\"> 
					setTimeout(\"Redirect()\",0); 
					function Redirect() {  
						sweetAlert('Operation Updated Successfully','','success');
						location.href = '$hurl'; 
					}
				</script>";
	
     	}

 	}		
			
	
		//var_dump($row);
		?>
		
			<div class="container">
				<div class="panel panel-primary">
					<div class="panel-heading">Update Operation <?php echo "<b>".$row[0]['operation_name']."</b>"; ?>
						<a href='<?= getFullURLLevel($_GET['r'],'master.php',0,'N'); ?>' class='pull btn btn-warning'>Back</a>
					</div>
					<div class="panel-body">
						<div class="alert alert-danger" style="display:none;">
				<a href="#" class="close" data-dismiss="alert">&times;</a>
				<strong>Info! </strong><span class="sql_message"></span>
			</div>
						<div class="form-group">
							<form name="test" action="index.php" method="GET">
							
								<input type="hidden" id="r" name="r" value= "<?= $_GET['r']; ?>">
								<div>
									<b></b><input type='hidden' class='form-control' id='id' name='id' required value = <?php echo $_GET['id'] ?> />
								</div>
								<div class="row">
									<div class="col-sm-2">
										<b>Operation Name<span data-toggle="tooltip" data-placement="top" title="It's Mandatory field"><font color='red'>*</font></span></b>
										<input type="text" class="form-control" id="opn" name="opn" value= "<?php echo $row[0]['operation_name']?>" required>
									</div> 
									<div class="col-sm-2">
										<b>Operation code<span data-toggle="tooltip" data-placement="top" title="It's Mandatory field"><font color='red'>*</font></span></b><input type="number" onkeypress="return validateQty(event);"  class="form-control" id="opc" name="opc" value= "<?php echo $row[0]['operation_code']?>" required>
									</div>
									
									<div class="col-sm-2">
										<br>
									    <input type="submit" name="submit" id="submit" class="btn btn-success" value="Update">
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		<?php
		
 ?>
