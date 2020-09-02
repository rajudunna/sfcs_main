
<?php
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/functions.php',4,'R')); 
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/functions_v2.php',4,'R'));
$plant_code =  $_session['plantCode'];
$username =  $_session['userName'];
?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Embellishment Plan Dashboard</title>
<META HTTP-EQUIV="refresh" content="900; URL=pps_dashboard.php">
<style>
body
{
	font-family: Trebuchet MS;
}
</style>
<script>
var url = '<?= getFullURLLevel($_GET['r'],'embellishment_test_new.php',0,'N'); ?>';
function firstbox() 
{ 
    window.location.href =url+"&style="+document.test.style.value 
} 

function secondbox() 
{ 
    window.location.href =url+"&style="+document.test.style.value+"&schedule="+document.test.schedule.value 
} 

function thirdbox() 
{ 
    window.location.href =url+"&style="+document.test.style.value+"&schedule="+document.test.schedule.value+"&color="+document.test.color.value 
}
function forthbox() 
{ 
    window.location.href =url+"&style="+document.test.style.value+"&schedule="+document.test.schedule.value+"&color="+document.test.color.value+"&mpo="+document.test.mpo.value 
}
function fifthbox() 
{ 
    window.location.href =url+"&style="+document.test.style.value+"&schedule="+document.test.schedule.value+"&color="+document.test.color.value+"&mpo="+document.test.mpo.value+"&sub_po="+document.test.sub_po.value 
}
</script> 
<!-- <link href="style.css" rel="stylesheet" type="text/css" /> --> 

</head> 
<!-- <link href="<?= getFullURLLevel($_GET['r'],'common/css/sfcs_styles.css',4,'R'); ?>" rel="stylesheet" type="text/css" /> --> 
<body> 

<?php  

$get_style=$_GET['style']; 
$get_schedule=$_GET['schedule'];  
$get_color=$_GET['color']; 
$get_mpo=$_GET['mpo']; 
$get_sub_po=$_GET['sub_po']; 
?> 

<div class="panel panel-primary"> 
<div class="panel-heading">Embellishment Production Planning Panel</div> 
<div class="panel-body"> 
<form name="test" action="index-no-navi.php?r=<?php echo $_GET['r'];  ?>" method="post"> 
<?php
	//function to get style from mp_color_details
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
	//qry to get schedules form mp_mo_qty based on master_po_details_id 
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
	
	//function to get color form mp_mo_qty based on schedules and plant code from mp_mo_qty
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
	
	//function to get master po's from mp_mo_qty based on schedule and color
	if($get_schedule!='' && $get_color!='' && $plant_code!=''){
		$result_bulk_MPO=getMpos($get_schedule,$get_color,$plant_code);
		$master_po_description=$result_bulk_MPO['master_po_description'];
	}
	echo "<div class='col-sm-3'><label>Select Master PO: </label>";  
	echo "<select style='min-width:100%' name=\"mpo\" onchange=\"forthbox();\" class='form-control' >
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
	
	//function to get sub po's from mp_mo_qty based on master PO's
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
echo "</br><div class='col-sm-3'>";
 $tasktype = TaskTypeEnum::EMBELLISHMENTJOB;
 //Qry to fetch jm_job_header_id from jm_jobs_header
 $get_jm_job_header_id="SELECT jm_job_header_id FROM $pps.jm_job_header WHERE po_number='$get_sub_po' AND plant_code='$plant_code'";
 $jm_job_header_id_result=mysqli_query($link_new, $get_jm_job_header_id) or exit("Sql Error at get_jm_job_header_id".mysqli_error($GLOBALS["___mysqli_ston"]));
 $jm_job_header_id_result_num=mysqli_num_rows($jm_job_header_id_result);
 if($jm_job_header_id_result_num>0){
    while($jm_job_header_id_row=mysqli_fetch_array($jm_job_header_id_result))
    {
        $jm_job_header_id[]=$jm_job_header_id_row['jm_job_header_id'];
    }
 }
 //Qry to check sewing job planned or not
 $check_job_status="SELECT task_status FROM $tms.task_header WHERE task_ref in ('".implode("','" , $jm_job_header_id)."') AND plant_code='$plant_code' AND task_type='$tasktype'";
 $job_status_result=mysqli_query($link_new, $check_job_status) or exit("Sql Error at check_job_status".mysqli_error($GLOBALS["___mysqli_ston"]));    
 $job_status_num=mysqli_num_rows($job_status_result);

if($job_status_num > 0)
{
  echo "Cut Jobs Available:"."<font color=GREEN class='label label-success'>YES</font>"; 
  echo "<input type=\"submit\" class=\"btn btn-primary\" value=\"submit\" name=\"submit\" >";
}
else
{
	echo "Docket Available:"."<font color=RED size=5>No</font>";
}

echo "</div></div></form>";

?>
</body>
<?php
if(isset($_POST['submit']) && short_shipment_status($_POST['style'],$_POST['schedule'],$link))
{
	$style=$_POST['style'];
	$color=$_POST['color'];
	$schedule=$_POST['schedule'];
	$mpo=$_POST['mpo'];
	$sub_po=$_POST['sub_po'];
	
	$data_sym="$";
	

	$my_file = getFullURLLevel($_GET['r'],'embellishment_drag_drop_data.php',0,'R');

	$handle = fopen($my_file, 'w') or die('Cannot open file:  '.$my_file);

	$stringData = "<?php ".$data_sym."style_ref=\"".$style."\"; ".$data_sym."schedule_ref=\"".$schedule."\"; ".$data_sym."color_ref=\"".$color."\"; ".$data_sym."mpo=\"".$mpo."\"; ".$data_sym."sub_po=\"".$sub_po."\"; ?>";

	fwrite($handle, $stringData);
	fclose(handle);

	
	//echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = \"drag_drop.php?color=$color&style=$style&schedule=$schedule&code=$code&cat_ref=$cat_ref\"; }</script>";
	$url = getFullURLLevel($_GET['r'],'embellishment_drag_drop.php',0,'N');
	echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = \"$url\"; }</script>";
}
?>  
