
<?php include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));	?>
<?php include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/functions.php',3,'R'));	?>
<?php include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/php/header_scripts.php',1,'R')); ?>

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
				$sql1="SELECT tid,input_job_number,size_code,color,SUM(carton_act_qty) AS tqty,carton_act_qty,module,input_job_random FROM $bai_pro3.pac_stat_log where schedule='$schedule' GROUP BY input_job_number,size_code,color  ORDER BY input_job_number*1 ASC";
				$sql_result=mysqli_query($link, $sql1) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
					while($rows=mysqli_fetch_array($sql_result)){
					$input_job_no=$rows['input_job_number'];
					$input_job_random=$rows['input_job_random'];
					$tid=$rows['tid'];
					$module=$rows['module'];
					$color=$rows['color'];
					$size=$rows['size_code'];
					$qty=$rows['qty'];
			?>
			<tr><td>
				<?php 
					$url = getFullURLLevel($_GET['r'],"reports/pdfs/sawing_out_labels_v1.php",1,'R');
					$display_prefix1 = get_sewing_job_prefix("prefix","$brandix_bts.tbl_sewing_job_prefix","$bai_pro3.packing_summary_input",$schedule,$color,$input_job_no,$link);
					echo $display_prefix1;
					
					$sql="SELECT title_size_".$size." as size FROM $bai_pro3.bai_orders_db WHERE order_del_no=\"$schedule\" AND order_col_des=\"$color\"";
					$sql_result1=mysqli_query($link, $sql) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
					while($title_size = mysqli_fetch_array($sql_result1))
					{	
						$title_size_ref=$title_size["size"];
					}

					$ss="SELECT input_module FROM $bai_pro3.plan_dashboard_input where input_job_no_random_ref='$input_job_random'";
					$ss_result=mysqli_query($link,$ss) or exit("Sql Error3 $ss".mysqli_error($GLOBALS["___mysqli_ston"]));
	                $rs=mysqli_fetch_array($ss_result);
	
	                $ss1="SELECT ims_mod_no FROM $bai_pro3.ims_log WHERE input_job_rand_no_ref='$input_job_random'";
					$ss1_result=mysqli_query($link,$ss1) or exit("Sql Error4 $ss1".mysqli_error($GLOBALS["___mysqli_ston"]));
	                $rs1=mysqli_fetch_array($ss1_result);
					$ss11="SELECT ims_mod_no FROM $bai_pro3.ims_log_backup WHERE input_job_rand_no_ref='$random_job'";
	                $ss1_result1=mysqli_query($link,$ss11) or exit("Sql Error4 $ss11".mysqli_error($GLOBALS["___mysqli_ston"]));
	                $rs11=mysqli_fetch_array($ss1_result1);
                    if($rs){
						$module=$rs['input_module'];
						}else if(!$rs && $rs1){
						$module=$rs1['ims_mod_no'];
						}else if(!$rs1 && !$rs && $rs11){
						$module=$rs11['ims_mod_no'];
						}else if(!$rs && !$rs1 && !$rs11){
						$module='Not Processed';
						}

				?>
				</td>
				<td><?php echo $rows['color']; ?></td>
				<td><?php echo strtoupper($title_size_ref) ?></td>
				<td><?php echo $module; ?></td>
				<td><?php echo $rows['tqty'];   ?></td>
				<td>
				<?php 
					$url = getFullURLLevel($_GET['r'],"reports/pdfs/sawing_out_labels.php",1,'R');
					$url = $url."?tid=$tid&job_no=$input_job_no&schedule=$schedule&color=$color&size=$size";
					echo "<a href=\"$url\" class=\"btn btn-warning btn-sm\" target=\"_blank\" onclick=\"return popitup('$url')\">
						  <i class='fa fa-print'></i>&nbsp;&nbsp;Print Labels </a><br/>";	
				    $url = getFullURL($_GET['r'],'packing_list_print_assort.php','R');
					
				?>
				</td>
			</tr>
			<?php
			}
		?>
		
		<?php
			
			$sql="select * from $bai_pro3.bai_orders_db_confirm where $filter_joins order_style_no=\"$style\" and order_del_no=\"$schedule\"";
			$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row=mysqli_fetch_array($sql_result))
			{
				$tran_order_tid=$sql_row['order_tid'];
				$carton_id=$sql_row['carton_id'];
				$style_id=$sql_row['style_id'];
			}
			$sql="select * from $bai_pro3.cat_stat_log where order_tid=\"$tran_order_tid\" and length(category)>0";
			$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row=mysqli_fetch_array($sql_result))
			{
				$cat_ref=$sql_row['tid'];				
			}
			
			$sql="select * from $bai_pro3.carton_qty_chart where user_style=\"$style_id\" and status=0";
			$sql_result=mysqli_query($link, $sql) or exit("Sql Errorl".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row=mysqli_fetch_array($sql_result))
			{
				$carton_id_new_create=$sql_row['id'];
			}	
			$url = getFullURL($_GET['r'],'packing_list/packing_check_list_assort_input.php','R');
			echo "</div><div class='col-md-2'><a class=\"btn btn-warning btn-xs\" href=\"$url?order_tid=$tran_order_tid&cat_ref=$cat_ref&carton_id=$carton_id_new_create&style=$style&schedule=$schedule\" onclick=\"return popitup("."'"."$url?order_tid=$tran_order_tid&cat_ref=$cat_ref&carton_id=$carton_id_new_create&style=$style&schedule=$schedule"."'".")\"><i class='fa fa-print'></i>  Carton Track</a></div></div>";
			
		?>
		</table>
	</div>
</div>
