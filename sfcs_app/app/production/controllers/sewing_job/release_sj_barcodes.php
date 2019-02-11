<?php
	$style = $_GET['style'];
	$schedule = $_GET['schedule'];
    $sewing_job = $_GET['sewing_job'];
    include(getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));
    include(getFullURLLevel($_GET['r'],'common/config/functions.php',4,'R'));
    $has_permission=haspermission($_GET['r']);
?>

	<script type="text/javascript">
		var url1 = '<?= getFullURL($_GET['r'],'release_sj_barcodes.php','N'); ?>';
		function firstbox()
		{
			window.location.href =url1+"&style="+document.form_name.style.value
		}

		function secondbox()
		{
			window.location.href =url1+"&style="+document.form_name.style.value+"&schedule="+document.form_name.schedule.value
		}
	</script>
<?php
	if(in_array($authorized,$has_permission))
	{ 
		?>
		<div class="panel panel-primary">
			<div class="panel-heading">Release Sewing Job Barcodes</div>
			<div class="panel-body">
				<form action="?r=<?=$_GET['r']?>" class='form-inline' name='form_name' method="POST">
					<label>Style: </label>
					<select name="style" id="style" class="form-control" required onchange="firstbox();">
						<option value="">Please Select</option>
						<?php
							$sql="select distinct order_style_no as style from $bai_pro3.packing_summary_input";
							$sql_result=mysqli_query($link, $sql) or exit("Sql Error2");
							while($sql_row=mysqli_fetch_array($sql_result))
							{
								if(str_replace(" ","",$sql_row['style'])==str_replace(" ","",$style))
								{
									echo "<option value=\"".$sql_row['style']."\" selected>".$sql_row['style']."</option>";
								}
								else
								{
									echo "<option value=\"".$sql_row['style']."\">".$sql_row['style']."</option>";
								}
							}
						?>
					</select>

					<label>Schedule: </label>
					<select name="schedule" id="schedule" class="form-control" required onchange="secondbox();">
						<option value="">Please Select</option>
						<?php
							$sql="select distinct order_del_no from $bai_pro3.packing_summary_input where order_style_no='".$style."'";
							$sql_result=mysqli_query($link, $sql) or exit("Sql Error2");
							while($sql_row=mysqli_fetch_array($sql_result))
							{
								if(str_replace(" ","",$sql_row['order_del_no'])==str_replace(" ","",$schedule))
								{
									echo "<option value=\"".$sql_row['order_del_no']."\" selected>".$sql_row['order_del_no']."</option>";
								}
								else
								{
									echo "<option value=\"".$sql_row['order_del_no']."\">".$sql_row['order_del_no']."</option>";
								}
							}
						?>
					</select>

					<label>Sewing Job: </label>
					<select name="sewing_job" id="sewing_job" class="form-control" required>
						<option value="">Please Select</option>
						<?php
							$sql="select distinct input_job_no, input_job_no_random from $bai_pro3.packing_summary_input where order_del_no='".$schedule."' order by input_job_no*1 ";
							$sql_result=mysqli_query($link, $sql) or exit("Sql Error2");
							while($sql_row=mysqli_fetch_array($sql_result))
							{
								$display1 = get_sewing_job_prefix_inp("prefix","$brandix_bts.tbl_sewing_job_prefix",$sql_row['input_job_no'],$sql_row['input_job_no_random'],$link);
								echo "<option value=\"".$sql_row['input_job_no_random']."\">".$display1."</option>";
							}
						?>
					</select>

					<input type="submit" name="release_barcodes" id="release_barcodes" value="Release" class="btn btn-success confirm-submit">
				</form>
		    </div>
		</div>
		<?php
	}
?>

	<?php
		if (isset($_POST['release_barcodes']))
		{
			$schedule = $_POST['schedule'];
			$sewing_job = $_POST['sewing_job'];

			$budndle_print_sum =echo_title("$bai_pro3.packing_summary_input","sum(bundle_print_status)","input_job_no_random",$sewing_job,$link);
			if ($budndle_print_sum == 0) {
				echo "<script>sweetAlert('Barcodes Not Printed','','error')</script>";
				echo("<script>location.href = '".getFullURLLevel($_GET['r'],'release_sj_barcodes.php',0,'N')."';</script>");
			} else {
				$update_bundle_print_status="UPDATE $bai_pro3.pac_stat_log_input_job SET bundle_print_status='0', bundle_print_time=now() WHERE input_job_no_random='".$sewing_job."'";
				mysqli_query($link, $update_bundle_print_status)  or exit("Error while updatiing bundle print status for sewing_job: ".$sewing_job);

				echo "<script>sweetAlert('Barcodes Released Successfully','','success')</script>";
				echo("<script>location.href = '".getFullURLLevel($_GET['r'],'release_sj_barcodes.php',0,'N')."';</script>");
			}
		}
	?>