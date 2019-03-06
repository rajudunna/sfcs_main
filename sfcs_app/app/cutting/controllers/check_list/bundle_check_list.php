<?php
    include(getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));
    include(getFullURLLevel($_GET['r'],'common/config/functions.php',4,'R'));
	$has_permission=haspermission($_GET['r']);

	if(isset($_POST['style']))
	{
	    $style=$_POST['style'];
	    $schedule=$_POST['schedule'];
	}
	else
	{
		$style=$_GET['style'];
		$schedule=$_GET['schedule'];
	}
?>
<script type="text/javascript">
	var url1 = '<?= getFullURL($_GET['r'],'bundle_check_list.php','N'); ?>';
	function firstbox()
	{
		//alert("report");
		window.location.href =url1+"&style="+document.check_list_select.style.value
	}
</script>
<style>
	table, th, td {
		text-align: center;
	}
</style>
<div class="panel panel-primary">
	<div class="panel-heading">Check List</div>
	<div class="panel-body">
		<div class="col-md-12">
			<?php
			echo "<form name=\"check_list_select\" action=\"?r=".$_GET["r"]."\" class=\"form-inline\" method=\"post\" >";
				?>
				<label>Style:</label>
				<?php
					// Style
					echo "<select name=\"style\" id=\"style\" class='form-control' onchange=\"firstbox();\" required >";
					$sql="SELECT DISTINCT order_style_no
							FROM bai_pro3.`pac_stat_log_input_job`
							LEFT JOIN bai_pro3.`plandoc_stat_log` ON plandoc_stat_log.`doc_no` = pac_stat_log_input_job.`doc_no`
							LEFT JOIN bai_pro3.`bai_orders_db` ON plandoc_stat_log.`order_tid` = bai_orders_db.`order_tid`";
					$sql_result=mysqli_query($link, $sql) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
					$sql_num_check=mysqli_num_rows($sql_result);
					echo "<option value=\"\" selected>Select Style</option>";
					while($sql_row=mysqli_fetch_array($sql_result))
					{
						if(str_replace(" ","",$sql_row['order_style_no'])==str_replace(" ","",$style))
						{
							$selected = 'selected';							
						}
						else
						{
							$selected = '';
						}
						echo "<option value=\"".$sql_row['order_style_no']."\" $selected>".$sql_row['order_style_no']."</option>";
					}
					echo "</select>";
				?>

				&nbsp;<label>Schedule:</label>
				<?php
					// Schedule
					echo "<select class='form-control' name=\"schedule\" id=\"schedule\" required >";
					$sql="SELECT DISTINCT order_del_no
							FROM bai_pro3.`pac_stat_log_input_job`
							LEFT JOIN bai_pro3.`plandoc_stat_log` ON plandoc_stat_log.`doc_no` = pac_stat_log_input_job.`doc_no`
							LEFT JOIN bai_pro3.`bai_orders_db` ON plandoc_stat_log.`order_tid` = bai_orders_db.`order_tid`
							where order_style_no = '".$style."' ";
					$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
					$sql_num_check=mysqli_num_rows($sql_result);
					echo "<option value=\"\" selected>Select Schedule</option>";
					while($sql_row=mysqli_fetch_array($sql_result))
					{
						if(str_replace(" ","",$sql_row['order_del_no'])==str_replace(" ","",$schedule))
						{
							$selected = 'selected';							
						}
						else
						{
							$selected = '';
						}
						echo "<option value=\"".$sql_row['order_del_no']."\" $selected>".$sql_row['order_del_no']."</option>";
					}
					echo "</select>";
				?>
				&nbsp;&nbsp;
				<input type="submit" name="submit" id="submit" class="btn btn-success" value="Submit">
			</form>
			<div class="col-md-12">
			<?php
				if(isset($_POST['submit']) or ($_GET['style'] and $_GET['schedule']))
				{
					$style=$_POST['style'];
					$schedule=$_POST['schedule'];
					// echo "$style, $schedule <br>";
					$sql1="SELECT order_col_des,plandoc_stat_log.doc_no,color_code,acutno,GROUP_CONCAT(DISTINCT input_job_no order by input_job_no*1) as input_job_no,GROUP_CONCAT(DISTINCT input_job_no_random) as input_job_no_random,COUNT(*) AS bundles,SUM(carton_act_qty) AS qty 
							FROM bai_pro3.`pac_stat_log_input_job`
							LEFT JOIN bai_pro3.`plandoc_stat_log` ON plandoc_stat_log.`doc_no` = pac_stat_log_input_job.`doc_no`
							LEFT JOIN bai_pro3.`bai_orders_db` ON plandoc_stat_log.`order_tid` = bai_orders_db.`order_tid`
							WHERE order_style_no='$style' AND order_del_no='$schedule' GROUP BY doc_no";
					// echo $sql1;
					$sql_result1=mysqli_query($link, $sql1) or exit("Error while fetching details for the selected style and schedule");
					if (mysqli_num_rows($sql_result1) > 0)
					{
						$url1 = getFullURLLevel($_GET['r'],'print_bundle_check_list.php',0,'R');
						$rowcount=1;
						?>
						<br><br>
						<div class="table-responsive">
							<table class="table table-bordered">
								<thead>
									<tr class="info">
										<th>S.No</th>
										<th>Cut Number</th>
										<th>Docket</th>
										<th>Sewing Job Number</th>
										<th>Color</th>
										<th>Bundles</th>
										<th>Quantity</th>
										<th>Control</th>
									</tr>
								</thead>
								<tbody>
								<?php
								while($m=mysqli_fetch_array($sql_result1))
								{
									$display_sewing_job = array();
									$ijno = $m['input_job_no'];
									$ijnorand = $m['input_job_no_random'];
									$ij_array = explode(',', $ijno);
									$ijrand_array = explode(',', $ijnorand);
									if (count($ij_array) == count($ijrand_array))
									{
										for ($i=0; $i < count($ij_array); $i++)
										{ 
											$display_sewing_job[] = get_sewing_job_prefix_inp('prefix','brandix_bts.tbl_sewing_job_prefix',$ij_array[$i],$ijrand_array[$i],$link);
										}
										$display_final_job = implode(',', $display_sewing_job);
									}
									else
									{
										$display_final_job = $ijno;
									}
									echo "<tr>
											<td>".$rowcount."</td>
											<td>".chr($m['color_code']).leading_zeros($m['acutno'],3)."</td>
											<td>".$m['doc_no']."</td>
											<td>".$display_final_job."</td>
											<td>".$m['order_col_des']."</td>
											<td>".$m['bundles']."</td>
											<td>".$m['qty']."</td>
											<td >
												<a class='btn btn-warning' href='$url1?style=$style&schedule=$schedule&doc_no=".$m['doc_no']."'' onclick=\"return popitup2('$url1?style=$style&schedule=$schedule&doc_no=".$m['doc_no']."')\" target='_blank'><i class=\"fa fa-print\" aria-hidden=\"true\"></i>&nbsp;&nbsp;&nbsp;Print Check List</a>
											</td>
										</tr>";
									$rowcount++;
								}
								?>
								</tbody>
							</table>
						</div>
						<?php
					}
					else
					{
						echo '<br><div class="alert alert-danger">
						  <strong>No Data Found for the selected Style and Schedule</strong>
						  <br>You have already created sewing jobs based on Cut Jobs, So You should go with the same process.';
					}
				}
			?>
		</div>
	</div>
</div>