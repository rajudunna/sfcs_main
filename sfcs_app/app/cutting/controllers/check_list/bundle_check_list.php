<?php
    include(getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));
	include(getFullURLLevel($_GET['r'],'common/config/functions.php',4,'R'));
	include(getFullURLLevel($_GET['r'],'common/config/functions_v2.php',4,'R'));
	include(getFullURL($_GET['r'],'bundle_check_list_function.php','R'));
	$has_permission=haspermission($_GET['r']);
	$plantcode=$_SESSION['plantCode'];
	// $plantcode='Q01';
	$username=$_SESSION['userName'];

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
<input type="hidden" name="plant_code" id='plant_code' value="<?php echo $plantcode;?>">
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
					//function to get style from mp_color_details
					if($plantcode!=''){
						$result_mp_color_details=getMpColorDetail($plantcode);
						$bulk_style=$result_mp_color_details['style'];
					}
					echo "<select name=\"style\" id=\"style\" class='form-control' onchange=\"firstbox();\" required >";
					
					echo "<option value=\"\" selected>Select Style</option>";
					foreach ($bulk_style as $style_value) {
						if(str_replace(" ","",$style_value)==str_replace(" ","",$style)) 
						{ 
							echo '<option value=\''.$style_value.'\' selected>'.$style_value.'</option>'; 
						} 
						else 
						{ 
							echo '<option value=\''.$style_value.'\'>'.$style_value.'</option>'; 
						}
					} 
					echo "</select>";
				?>

				&nbsp;<label>Schedule:</label>
				<?php
					// Schedule
					echo "<select class='form-control' name=\"schedule\" id=\"schedule\" required >";
					//qry to get schedules form mp_mo_qty based on master_po_details_id 
					if($style!=''&& $plantcode!=''){
						$result_bulk_schedules=getBulkSchedules($style,$plantcode);
						$bulk_schedule=$result_bulk_schedules['bulk_schedule'];
					} 
					echo "<option value=\"\" selected>Select Schedule</option>";
					foreach ($bulk_schedule as $bulk_schedule_value) {
						if(str_replace(" ","",$bulk_schedule_value)==str_replace(" ","",$schedule)) 
						{ 
							echo '<option value=\''.$bulk_schedule_value.'\' selected>'.$bulk_schedule_value.'</option>'; 
						} 
						else 
						{ 
							echo '<option value=\''.$bulk_schedule_value.'\'>'.$bulk_schedule_value.'</option>'; 
						}
					} 
					echo "</select>";
				?>
				
				&nbsp;&nbsp;
				<input type="submit" name="submit" id="submit" class="btn btn-success" value="Submit">
			</form>
			<div class="col-md-12"><br/>
			<?php
				if(isset($_POST['style']))
				{
					$style=$_POST['style'];
					$schedule=$_POST['schedule'];
					$list_details=getCheckList($style,$schedule,$plantcode);
					echo $list_details;
				}
			?>
		</div>
	</div>
</div>
<script>
$(document).ready(function() 
{
	var function_text = "<?php echo getFullURL($_GET['r'],'bundle_check_list_function.php','R'); ?>";
	var schedule = $('#schedule').val();
	var plant_code = $('#plant_code').val();
	var inputObj = [schedule,plant_code];
	$('#submit').on('click', function(){
		$.ajax({
            type: "POST",
            url: function_text+'getCheckList',
			data: inputObj,
            success: function(response) 
            {
			}
		});
	});
});
</script>