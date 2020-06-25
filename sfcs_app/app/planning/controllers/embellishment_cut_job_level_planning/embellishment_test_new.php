
<?php
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/functions.php',4,'R')); 
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/functions_v2.php',4,'R'));
?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Plan Dashboard</title>
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
<form name="test" action="index.php?r=<?php echo $_GET['r'];  ?>" method="post"> 
<?php
	//function to get style from mp_color_details
	if($plantcode!=''){
		$result_mp_color_details=getMpColorDetail($plantcode);
		$style=$result_mp_color_details['style'];
	}
    echo "<div class='row'>"; 
	echo "<div class='col-sm-3'><label>Select Style: </label><select name=\"style\" onchange=\"firstbox();\" class='form-control' required>"; 
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
	if($get_style!=''&& $plantcode!=''){
		$result_bulk_schedules=getBulkSchedules($get_style,$plantcode);
		$bulk_schedule=$result_bulk_schedules['bulk_schedule'];
	}  
	echo "<div class='col-sm-3'><label>Select Schedule: </label><select name=\"schedule\" onchange=\"secondbox();\" class='form-control' required>";  
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
	if($get_schedule!='' && $plantcode!=''){
		$result_bulk_colors=getBulkColors($get_schedule,$plantcode);
		$bulk_color=$result_bulk_colors['color_bulk'];
	}
	echo "<div class='col-sm-3'><label>Select Color: </label>";  
	echo "<select name=\"color\" onchange=\"thirdbox();\" class='form-control' >
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
	if($get_schedule!='' && $get_color!='' && $plantcode!=''){
		$result_bulk_MPO=getMpos($get_schedule,$get_color,$plantcode);
		$master_po_description=$result_bulk_MPO['master_po_description'];
	}
	echo "<div class='col-sm-3'><label>Select Master PO: </label>";  
	echo "<select name=\"mpo\" onchange=\"forthbox();\" class='form-control' >
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
	if($get_mpo!='' && $plantcode!=''){
		$result_bulk_subPO=getBulkSubPo($get_mpo,$plantcode);
		$sub_po_description=$result_bulk_subPO['sub_po_description'];
	}
	echo "<div class='col-sm-3'><label>Select Sub PO: </label>";  
	echo "<select name=\"sub_po\" onchange=\"fifthbox();\" class='form-control' >
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
$tasktype='EMBJOB';
//Function to get status from getJobsStatus based on subpo,tasktype,plantcode 
$result_get_task_status=getJobsStatus($get_sub_po,$tasktype,$plantcode);
$status=$result_get_task_status['task_status'];

if($status=='OPEN')
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
