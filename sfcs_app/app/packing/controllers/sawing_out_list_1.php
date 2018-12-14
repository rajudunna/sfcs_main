<?php include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));	?>
<?php include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/functions.php',3,'R'));	?>
<?php include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/php/header_scripts.php',1,'R')); ?>

<div class="panel panel-primary">
	<div class="panel-heading">Sewing out Reporting List</div>
	<div class="panel-body">
		<?php
			$schedule=$_GET['schedule'];
			$sql="SELECT order_style_no FROM bai_orders_db_confirm WHERE order_del_no='$schedule'";
			$result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			$row=mysqli_fetch_array($result);
			$style=$row['order_style_no'];
		?>
		<div class="row">
			<div class="col-md-3">
				<label>Style : </label>&nbsp;&nbsp;<?php echo $style;  ?>
			</div>
			<div class="col-md-3">
				<label>Schedule : </label>&nbsp;&nbsp;<?php echo $schedule;   ?>
			</div>
		</div>
		<hr>
		<table class="table table-bordered">
			<tr>
				<th>Job Number</th><th>Color</th>
				<th>Size</th><th>Total Quantity</th>
			</tr>
			<?php   
				$sql1="SELECT tid,input_job_no,size_code,color,SUM(carton_act_qty) AS tqty,carton_act_qty AS qty,
						remarks FROM pac_stat_log where schedule='$schedule' 
						GROUP BY input_job_no,size_code,color  ORDER BY input_job_no*1 ASC";
				$sql_result=mysqli_query($link, $sql1) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
					while($rows=mysqli_fetch_array($sql_result)){
					
						$input_job_no=$rows['input_job_no'];
						$tid=$rows['tid'];
						$color=$rows['color'];
						$size=$rows['size_code'];
						$qty=$rows['qty'];
						$remark=$rows['remarks'];
			?>
			<tr><td>
				<?php
					$display_prefix1 = get_sewing_job_prefix("prefix","$brandix_bts.tbl_sewing_job_prefix","$bai_pro3.packing_summary_input",$schedule,$color,$input_job_no,$link);
					if($remark==""){
					$url = getFullURLLevel($_GET['r'],'reports/pdfs/sawing_out_labels_v3.php',1,'R');
					echo "<a href=\"$url?tid=$tid&job_no=$input_job_no&schedule=$schedule\" target=\"_blank\" class=\"btn btn-warning btn-sm\" onclick=\"return popitup("."'"."$url?tid=$tid&job_no=$input_job_no&schedule=$schedule"."'".")\">".$display_prefix1."</a><br/>";		
					}else{
					$url = getFullURLLevel($_GET['r'],'reports/pdfs/sawing_out_labels_v3_assort.php',1,'R');
					echo "<a href=\"$url?tid=$tid&job_no=$input_job_no&schedule=$schedule\" target=\"_blank\" class=\"btn btn-warning btn-sm\" onclick=\"return popitup("."'"."$url?tid=$tid&job_no=$input_job_no&schedule=$schedule"."'".")\">".$display_prefix1."</a><br/>";		
					}	
				?>
				</td>
				<td><?php echo $rows['color'];  ?></td>
				<td><?php echo $rows['size_code'];  ?></td>
				<td><?php echo $rows['tqty'];  ?></td>
			</tr>
			<?php
					}//closing while loop
			?>
		</table>
	</div>
</div>
