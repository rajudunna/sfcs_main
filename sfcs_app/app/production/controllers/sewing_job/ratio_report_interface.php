<?php
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',4,'R')); 
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/functions_v2.php',4,'R')); 
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/enums.php',4,'R')); 
$plant_code = $_SESSION['plantCode'];
$username =  $_SESSION['userName'];

?>
<style>
body
{
	font-family: Trebuchet MS;
}
</style>
<script>

function firstbox()
{
	var url1 = '<?= getFullUrl($_GET['r'],'ratio_report_interface.php','N'); ?>';
	window.location.href =url1+"&style="+document.test.style.value;
}

function secondbox()
{
	var url2 = '<?= getFullUrl($_GET['r'],'ratio_report_interface.php','N'); ?>';
	window.location.href =url2+"&style="+document.test.style.value+"&schedule="+document.test.schedule.value;
}
function thirdbox()
{
	var url3 = '<?= getFullUrl($_GET['r'],'ratio_report_interface.php','N'); ?>';
	window.location.href =url3+"&style="+document.test.style.value+"&schedule="+document.test.schedule.value+"&color="+document.test.color.value;
}

function fourthbox()
{
	var url4 = '<?= getFullUrl($_GET['r'],'ratio_report_interface.php','N'); ?>';
	window.location.href =url4+"&style="+document.test.style.value+"&schedule="+document.test.schedule.value+"&color="+document.test.color.value+"&mpo="+document.test.mpo.value;
}

function fifthbox()
{
	var url5 = '<?= getFullUrl($_GET['r'],'ratio_report_interface.php','N'); ?>';
	window.location.href =url5+"&style="+document.test.style.value+"&schedule="+document.test.schedule.value+"&color="+document.test.color.value+"&mpo="+document.test.mpo.value+"&sub_po="+document.test.sub_po.value;
}

$(document).ready(function() {
	$('#schedule').on('mouseup',function(e){
		style = $('#style').val();
		if(style === 'NIL'){
			sweetAlert('Please Select Style','','warning');
		}
	});
	

	
	$('#cutno').on('mouseup',function(e){
		style = $('#style').val();
		schedule = $('#schedule').val();
		if(style === 'NIL' && schedule === 'NIL'){
			sweetAlert('Please Select Style and Schedule','','warning');
		}
		else if(style === 'NIL'){
			sweetAlert('Please Select Style','','warning');
		}
		else if(schedule === 'NIL'){
			sweetAlert('Please Select Schedule','','warning');
		}
	});

	$('#sub').on('click',function(e){
		style = $('#style').val();
		schedule = $('#schedule').val();
		color = $('#color').val();
		cutno = $('#cutno').val();
		if(style === 'NIL' && schedule === 'NIL' && color === 'NIL' && cutno === 'NIL'){
			sweetAlert('Please Select Style, Schedule, Color and CutNo','','warning');
		}
		else if(style === 'NIL' && schedule === 'NIL'){
			sweetAlert('Please Select Style and Schedule','','warning');
		}
		else if(schedule === 'NIL' && cutno === 'NIL'){
			sweetAlert('Please Select Schedule and CutNo','','warning');
		}
		else if(style === 'NIL' && cutno === 'NIL'){
			sweetAlert('Please Select Style and CutNo','','warning');
		}
		else if(style === 'NIL'){
			sweetAlert('Please Select Style','','warning');
		}
		else if(schedule === 'NIL'){
			sweetAlert('Please Select Schedule','','warning');
		}
		else if(color === 'NIL'){
			e.preventDefault();
			sweetAlert('Please Select Color','','warning');
		}
		else if(cutno === 'NIL'){
			e.preventDefault();
			sweetAlert('Please Select CutNo','','warning');
		}
	});
});
</script>

<!-- <link href="style.css" rel="stylesheet" type="text/css" /> -->
<?php 
// echo '<link href="'."http://".$_SERVER['HTTP_HOST']."/styles/sfcs_styles.css".'" rel="stylesheet" type="text/css" />'; ?>
<!-- <link rel="stylesheet" href="styles/bootstrap.min.css"> -->
</head>

<body>

<?php 
include(getFullURLLevel($_GET['r'],'common/config/functions.php',4,'R'));?>
<?php
$get_style=$_GET['style']; 
$get_schedule=$_GET['schedule'];  
$get_color=$_GET['color']; 
$get_mpo=$_GET['mpo']; 
$get_sub_po=$_GET['sub_po'];
//echo $style.$schedule.$color;
?>
<div class="panel panel-primary">
<div class="panel-heading"><strong>Sewing Ratio Sheet Report</strong></div>
<div class="panel-body">
<div class="form-inline">
<div class="form-group">
<!--<div id="page_heading"><span style="float: left"><h3>Input Planning Panel</h3></span><span style="float: right"><b>?</b>&nbsp;</span></div>-->
<form name="test" action="index-no-navi.php?r=<?=  $_GET['r']; ?>" method="post">
<?php

	/*function to get style from getdata_mp_color_detail
	@params : $plantcode
	@returns: $style
	*/

	if($plant_code!=''){
		$result_mp_color_details=getMpColorDetail($plant_code);
		$style=$result_mp_color_details['style'];
	}
	echo "<div class='row'>"; 
	echo "<div class='col-sm-3'><label>Select Style: </label><select style='min-width:100%' name=\"style\" onchange=\"firstbox();\" class='form-control' required>"; 
	echo "<option value=\"\" selected>NIL</option>";
	foreach ($style as $style_value) {
		if(str_replace(" ","",$style_value)==str_replace(" ","",$get_style)) 
	    { 
	        echo '<option value=\''.$style_value.'\' selected>'.$style_value.'</option>'; 
	    } 
	    else 
	    { 
	        echo '<option value=\''.$style_value.'\'>'.$style_value.'</option>'; 
	    }
	} 
	echo "</select></div>";

?>

<?php
/*function to get schedule from getdata_bulk_schedules
@params : plantcode,style
@returns: schedule
*/
	if($get_style!=''&& $plant_code!=''){
		$result_bulk_schedules=getBulkSchedules($get_style,$plant_code);
		$bulk_schedule=$result_bulk_schedules['bulk_schedule'];
	}  
	echo "<div class='col-sm-3'><label>Select Schedule: </label><select style='min-width:100%' name=\"schedule\" onchange=\"secondbox();\" class='form-control' required>";  
	echo "<option value=\"\" selected>NIL</option>";
	foreach ($bulk_schedule as $bulk_schedule_value) {
		if(str_replace(" ","",$bulk_schedule_value)==str_replace(" ","",$get_schedule)) 
	    { 
	        echo '<option value=\''.$bulk_schedule_value.'\' selected>'.$bulk_schedule_value.'</option>'; 
	    } 
	    else 
	    { 
	        echo '<option value=\''.$bulk_schedule_value.'\'>'.$bulk_schedule_value.'</option>'; 
	    }
	} 
	echo "</select></div>";


?>

<?php
/*function to get color from get_bulk_colors
@params : plantcode,schedule
@returns: color
*/
if($get_schedule!='' && $plant_code!=''){
		$result_bulk_colors=getBulkColors($get_schedule,$plant_code);
		$bulk_color=$result_bulk_colors['color_bulk'];
	}
	echo "<div class='col-sm-3'><label>Select Color: </label>";  
	echo "<select style='min-width:100%' name=\"color\" onchange=\"thirdbox();\" class='form-control' >
			<option value=\"NIL\" selected>NIL</option>";
				foreach ($bulk_color as $bulk_color_value) {
					if(str_replace(" ","",$bulk_color_value)==str_replace(" ","",$get_color)) 
					{ 
						echo '<option value=\''.$bulk_color_value.'\' selected>'.$bulk_color_value.'</option>'; 
					} 
					else 
					{ 
						echo '<option value=\''.$bulk_color_value.'\'>'.$bulk_color_value.'</option>'; 
					}
				} 
	echo "</select></div>";

?>

<?php
	/*function to get mpo from getdata_MPOs
	@params : plantcode,schedule,color
	@returns: mpo
	*/
	if($get_schedule!='' && $get_color!='' && $plant_code!=''){
		$result_bulk_MPO=getMpos($get_schedule,$get_color,$plant_code);
		$master_po_description=$result_bulk_MPO['master_po_description'];
	}
	echo "<div class='col-sm-3'><label>Select Master PO: </label>";  
	echo "<select style='min-width:100%' name=\"mpo\" onchange=\"fourthbox();\" class='form-control' >
			<option value=\"NIL\" selected>NIL</option>";
				foreach ($master_po_description as $key=>$master_po_description_val) {
					if(str_replace(" ","",$master_po_description_val)==str_replace(" ","",$get_mpo)) 
					{ 
						echo '<option value=\''.$master_po_description_val.'\' selected>'.$key.'</option>'; 
					} 
					else 
					{ 
						echo '<option value=\''.$master_po_description_val.'\'>'.$key.'</option>'; 
					}
				} 
	echo "</select></div>";
?>

<?php
		/*function to get subpo from getdata_bulk_subPO
		@params : plantcode,mpo
		@returns: subpo
		*/
	if($get_mpo!='' && $plant_code!=''){
		$result_bulk_subPO=getBulkSubPo($get_mpo,$plant_code);
		$sub_po_description=$result_bulk_subPO['sub_po_description'];
	}
	echo "<div class='col-sm-3'><label>Select Sub PO: </label>";  
	echo "<select style='min-width:100%' name=\"sub_po\" onchange=\"fifthbox();\" class='form-control' >
			<option value=\"NIL\" selected>NIL</option>";
				foreach ($sub_po_description as $key=>$sub_po_description_val) {
					if(str_replace(" ","",$sub_po_description_val)==str_replace(" ","",$get_sub_po)) 
					{ 
						echo '<option value=\''.$sub_po_description_val.'\' selected>'.$key.'</option>'; 
					} 
					else 
					{ 
						echo '<option value=\''.$sub_po_description_val.'\'>'.$key.'</option>'; 
					}
				} 
	echo "</select></div>";
?>

<?php

    echo "</br><div class='col-sm-6' style='margin-top: 21px;margin-bottom: 24px;'>";
    echo "<input type=\"submit\" class=\"btn btn-primary\" value=\"submit\" name=\"submit\" style='margin-left: 14px;'>";
    echo "</div>";

?>
</div>

</form>

<?php
if(isset($_POST['submit']))
{
	echo "<br><br><center><h2><font color=\"green\">Please Wait...</font></h2></center>";
	$style=$_POST['style'];
	$schedule=$_POST['schedule'];
	$color=$_POST['color'];
	$mpo=$_POST['mpo'];
	$sub_po=$_POST['sub_po'];
	echo "<script>window.location = '".getFullURLLevel($_GET['r'],'input_job_mix_ch_report.php',0,'N')."&style=$style&schedule=$schedule&color=$color&mpo=$mpo&sub_po=$sub_po';</script>";
	 
	}
?> 
</div> 
</div> 
</div> 

