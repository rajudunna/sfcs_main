
<?php include('../'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));	?>
<?php include('../'.getFullURLLevel($_GET['r'],'common/php/header_scripts.php',1,'R')); ?>

<div class="panel panel-primary">
	<div class="panel-heading">Sewing out Reporting List</div>
	<div class="panel-body">
		<?php
			$schedule = $_GET['schedule'];
			$sql="SELECT order_style_no FROM $bai_pro3.bai_orders_db_confirm WHERE order_del_no='$schedule'";
			$result = mysqli_query($link, $sql) or exit("Problem... in connecting".mysqli_error($GLOBALS["___mysqli_ston"]));
			$row = mysqli_fetch_array($result);
			$style = $row['order_style_no'];
		?>
		<div class="row">
			<div class="col-md-3">
				<label>Style : </label>&nbsp;&nbsp;<?php echo $style; ?>
			</div>
			<div class="col-md-3">
				<label>Schedule : </label>&nbsp;&nbsp;<?php echo $schedule; ?>
			</div>
		</div>
		<hr>
		<table class="table table-bordered">
			<tr><th>Job Number</th><th>Color</th><th>Size</th><th>Module</th><th>Total Quantity</th><th>Action</th></tr>
			<?php   
				$sql1="SELECT tid,input_job_number,size,color,SUM(qty) AS tqty,qty,module FROM $bai_pro3.pac_sawing_out 
					   where schedule='$schedule' GROUP BY input_job_number,size,color  ORDER BY input_job_number*1 ASC";
				$sql_result=mysqli_query($link, $sql1) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
					while($rows=mysqli_fetch_array($sql_result)){
					//echo $rows['input_job_number'].' '.$rows['color'].' '.$rows['size'].' '.$rows['tqty'].'<br>';
					$input_job_no=$rows['input_job_number'];
					$tid=$rows['tid'];
					$module=$rows['module'];
					$color=$rows['color'];
					$size=$rows['size'];
					$qty=$rows['qty'];
			?>
			<tr><td>
				<?php 
					$url = getFullURLLevel($_GET['r'],"reports/pdfs/sawing_out_labels_v1.php",1,'R');
					echo "<a href=\"$url?tid=$tid&job_no=$input_job_no&schedule=$schedule\" target=\"_blank\" class=\"btn btn-warning btn-sm\" onclick=\"return popitup("."'"."$url?tid=$tid&job_no=$input_job_no&schedule=$schedule"."'".")\"><i class='fa fa-print'></i>&nbsp;&nbsp;J0".$input_job_no."</a><br/>";		
				?>
				</td>
				<td><?php echo $rows['color'];  ?></td>
				<td><?php echo $rows['size'];   ?></td>
				<td><?php echo $rows['module']; ?></td>
				<td><?php echo $rows['tqty'];   ?></td>
				<td>
				<?php 
					$url = getFullURLLevel($_GET['r'],"reports/pdfs/sawing_out_labels.php",1,'R');
					$url = $url."?tid=$tid&job_no=$input_job_no&schedule=$schedule&color=$color&size=$size";
					echo "<a href=\"$url\" class=\"btn btn-warning btn-sm\" target=\"_blank\" onclick=\"return popitup('$url')\">
						  <i class='fa fa-print'></i>&nbsp;&nbsp;Print Labels </a><br/>";	
				?>
				</td>
			</tr>
			<?php
			}
		?>
		</table>
	</div>
</div>
