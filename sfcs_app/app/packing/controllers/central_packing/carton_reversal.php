<!DOCTYPE html>
<html>
<head>
	<title>Carton Reversal</title>
	<?php
		include(getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));
		include(getFullURLLevel($_GET['r'],'common/config/functions.php',4,'R'));
	?>
</head>
<body>
	<div class="panel panel-primary">
		<div class="panel-heading">Carton Reversal</div>
		<div class="panel-body">
			<form class="form-inline" action="<?php $_GET['r'] ?>" method="POST">
				<label>Carton ID: </label>
				<input type="text" name="carton_id" class="form-control" id="carton_id" value="" required>
				&nbsp;&nbsp;
				<input type="submit" name="submit" id="submit" class="btn btn-success confirm-submit">
			</form>
			<?php
				if (isset($_POST['submit']))
				{
					$carton_id = $_POST['carton_id'];
					$carton_query = "SELECT * FROM $bai_pro3.pac_stat_log WHERE tid = $carton_id";
					// echo $carton_query;
					$carton_details=mysqli_query($link, $carton_query) or exit("Error while getting Carton Details");
					
					if (mysqli_num_rows($carton_details) > 0)
					{
						while($row=mysqli_fetch_array($carton_details)) 
						{
							$status = $row['status'];
						}
						if ($status == NULL || $status == '(NULL)')
						{
							echo "<script>sweetAlert('Carton Not Scanned','Reversal Not Possible','warning')</script>";
						}
						else
						{
							$update_pac_stat_log = "UPDATE $bai_pro3.pac_stat_log SET status=NULL WHERE tid = $carton_id";
							mysqli_query($link, $update_pac_stat_log) or exit("Error while updating pac_stat_log");

							$update_mo_oprns_qty = "UPDATE $bai_pro3.mo_operation_quantites SET good_quantity = 0 WHERE bundle_no = $carton_id";
							mysqli_query($link, $update_mo_oprns_qty) or exit("Error while updating mo_operations_qty");

							$update_m3_tran = "INSERT INTO bai_pro3.`m3_transactions` (date_time,mo_no,quantity,reason,remarks,log_user,tran_status_code,module_no,shift,op_code,op_des,ref_no) SELECT NOW(),mo_no,quantity*-1,'cpk_reversal',remarks,USER(),'0',module_no,shift,'200','CPK',$carton_id FROM bai_pro3.`m3_transactions` WHERE ref_no=$carton_id AND op_code=200 AND op_des='CPK';";
							// echo $update_m3_tran;
							mysqli_query($link, $update_m3_tran) or exit("Error while updating m3_transactions");
						}
					}
					else
					{
						echo "<script>sweetAlert('No Cartons available with this ID - ".$carton_id."','','warning')</script>";
					}					
				}
			?>
		</div>
	</div>
</body>
</html>