<?php
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',4,'R')); 
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/functions_v2.php',4,'R')); 

//list($domain,$username) = split('[\]',$_SERVER['AUTH_USER'],2);
//$username_list=explode('\\',$_SERVER['REMOTE_USER']);
//$username=strtolower($username_list[1]);
// $username="sfcsproject1";
// echo $username;

// $authorized=array("sfcsproject1");
// $super_user=array("sfcsproject1");
$has_perm=haspermission($_GET['r']);
$hour=date("H.i");

	if(in_array($authorized,$has_perm))
	{
		
		//New Implementation to restrict as per time lines to update Planning Board 20111211
		$hour=date("H.i");
		
		//if(($hour>=7.45 and $hour<=10.00) or ($hour>=15.15 and $hour<=16.45)) //OLD
		//GOOD ONE if(($hour>=7.45 and $hour<=10.45) or ($hour>=12.30 and $hour<=14.00) or ($hour>=16.00 and $hour<=17.30))
		//if(($hour>=7.15 and $hour<=9.45) or ($hour>=15.15 and $hour<=17.15))
		// if(($hour>=06.00 and $hour<=09.00) or ($hour>=14.00 and $hour<=19.00))
		// {
			
		// }
		// else
		// {
			// $url=getFullURLLevel($_GET['r'],'time_out.php',1,'N');
			// header("Location:$url&msg=1");
		// }
	}
	else
	{
		$url=getFullURLLevel($_GET['r'],'/common/config/restricted.php',4,'N');
	   header("Location:$url");
	}
	


// $criteria="where left(order_style_no,1) in (".$global_style_codes.")";
/*if(!(in_array($authorized,$has_perm)))
{
	//exploding the users list into buyer level
	include("style_allocation.php");
	
	for($i=0;$i<sizeof($styles_names);$i++)
	{
		$style_users=$style_auth[$i];
		$style_users_ex=explode(",",$style_users);
		if(in_array($username,$style_users_ex))
		{
			$criteria_styles[]=$styles_list[$i];
		}
	}
	var_dump($criteria_styles);
	die();

	//$criteria=" where left(order_style_no,1) in (".$global_style_codes.") and  left(order_style_no,1) in (".implode(",",$criteria_styles).")";
	
}
*/

?>

<!-- <META HTTP-EQUIV="refresh" content="900; URL=pps_dashboard.php"> -->
<style>
body
{
	font-family: Trebuchet MS;
}
</style>
<script>

function firstbox()
{
	var url1 = '<?= getFullUrl($_GET['r'],'cut_jobs_loading.php','N'); ?>';
	window.location.href =url1+"&style="+document.test.style.value;
	// window.location.href ="cut_jobs_loading.php?style="+document.test.style.value
}

function secondbox()
{
	var url2 = '<?= getFullUrl($_GET['r'],'cut_jobs_loading.php','N'); ?>';
	window.location.href =url2+"&style="+document.test.style.value+"&schedule="+document.test.schedule.value;
	// window.location.href ="cut_jobs_loading.php?style="+document.test.style.value+"&schedule="+document.test.schedule.value
}
function thirdbox()
{
	var url3 = '<?= getFullUrl($_GET['r'],'cut_jobs_loading.php','N'); ?>';
	window.location.href =url3+"&style="+document.test.style.value+"&schedule="+document.test.schedule.value+"&color="+document.test.color.value;
	// window.location.href ="cut_jobs_loading.php?style="+document.test.style.value+"&schedule="+document.test.schedule.value+"&color="+document.test.color.value
}

function fourthbox()
{
	var url4 = '<?= getFullUrl($_GET['r'],'cut_jobs_loading.php','N'); ?>';
	window.location.href =url4+"&style="+document.test.style.value+"&schedule="+document.test.schedule.value+"&color="+document.test.color.value+"&mpo="+document.test.mpo.value;
}

function fifthbox()
{
	var url5 = '<?= getFullUrl($_GET['r'],'cut_jobs_loading.php','N'); ?>';
	window.location.href =url5+"&style="+document.test.style.value+"&schedule="+document.test.schedule.value+"&color="+document.test.color.value+"&mpo="+document.test.mpo.value+"&sub_po="+document.test.sub_po.value;
}

function sixthbox()
{
	var url6 = '<?= getFullUrl($_GET['r'],'cut_jobs_loading.php','N'); ?>';
	window.location.href =url6+"&style="+document.test.style.value+"&schedule="+document.test.schedule.value+"&color="+document.test.color.value+"&mpo="+document.test.mpo.value+"&sub_po="+document.test.sub_po.value+"&cutno="+document.test.cutno.value;
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
$cutno=$_GET['cutno'];
//echo $style.$schedule.$color;
?>
<div class="panel panel-primary">
<div class="panel-heading"><strong>Job Level Planning</strong><a href="<?= getFullURL($_GET['r'],'input_job_seq_move.php','N');?>" class="btn btn-success btn-xs pull-right" target="_blank">Input Job Sequence Move</a></div>
<div class="panel-body">
<div class="form-inline">
<div class="form-group">
<!--<div id="page_heading"><span style="float: left"><h3>Input Planning Panel</h3></span><span style="float: right"><b>?</b>&nbsp;</span></div>-->
<form name="test" action="index.php?r=<?=  $_GET['r']; ?>" method="post">
<?php

	/*function to get style from getdata_mp_color_detail
	@params : $plantcode
	@returns: $style
	*/

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

?>

<?php
/*function to get schedule from getdata_bulk_schedules
@params : plantcode,style
@returns: schedule
*/
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


?>

<?php
/*function to get color from get_bulk_colors
@params : plantcode,schedule
@returns: color
*/
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

?>

<?php
	/*function to get mpo from getdata_MPOs
	@params : plantcode,schedule,color
	@returns: mpo
	*/
	if($get_schedule!='' && $get_color!='' && $plantcode!=''){
		$result_bulk_MPO=getMpos($get_schedule,$get_color,$plantcode);
		$master_po_description=$result_bulk_MPO['master_po_description'];
	}
	echo "<div class='col-sm-3'><label>Select Master PO: </label>";  
	echo "<select name=\"mpo\" onchange=\"fourthbox();\" class='form-control' >
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
?>

<?php

		/*function to get cutno from get_cut_details
		@params : plantcode,subpo
		@returns: cutno
		*/
	if($get_sub_po!='' && $plantcode!=''){
		$result_cutno=getCutDetails($get_sub_po,$plantcode);
		$cut_number=$result_cutno['cut_number'];
	}
	echo "<div class='col-sm-3'><label>Select Cut: </label>";  
	echo "<select name=\"cutno\" onchange=\"sixthbox();\" class='form-control' >
			<option value=\"NIL\" selected>NIL</option>";
				foreach ($cut_number as $key=>$cut_no_val) {
					if(str_replace(" ","",$cut_no_val)==str_replace(" ","",$cutno)) 
					{ 
						echo '<option value=\''.$cut_no_val.'\' selected>'.$cut_no_val.'</option>'; 
					} 
					else 
					{ 
						echo '<option value=\''.$cut_no_val.'\'>'.$cut_no_val.'</option>'; 
					}
				} 
	echo "</select></div>";
?>

<?php
$tasktype='SEWING';
	/*function to get Sewing Jobs Available from check_task_header_status
	@params : plantcode,subpo,task type
	@returns: Sewing Jobs Available status
	*/
	if($plantcode!='')
    {
    	$result_get_task_status=getJobsStatus($get_sub_po,$tasktype,$plantcode);
        $status=$result_get_task_status['task_status'];
    }
    echo "</br><div class='col-sm-3'>"; 
    if($status=='OPEN')
    {
      echo "Sewing Jobs Available:"."<font color=GREEN class='label label-success'>YES</font>"; 
      echo "<input type=\"submit\" class=\"btn btn-primary\" value=\"submit\" name=\"submit\" >";
    }
    else
    {
      echo "Sewing Jobs Available: <font color=RED size=5>No</font>"; 
    }		
	echo "</div>";

?>
</div>

</form>

<?php
if(isset($_POST['submit']) && short_shipment_status($_POST['style'],$_POST['schedule'],$link))
{
	echo "<br><br><center><h2><font color=\"green\">Please Wait...</font></h2></center>";
	$style=$_POST['style'];
	$schedule=$_POST['schedule'];
	//$module=$_POST['modules'];
	$color=$_POST['color'];
	$cutno=$_POST['cutno'];
	$mpo=$_POST['mpo'];
	$sub_po=$_POST['sub_po'];


	$color=$_POST['color'];
	//echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = \"drag_drop_input_job.php?style=$style&schedule=$schedule&code=$code\"; }</script>";
	// echo("<script>window.open('".getFullURLLevel($_GET['r'],'drag_drop_input_job.php',0,'N')."&style=$style&schedule=$schedule&code=$code');</script>");
	echo "<script>window.location = '".getFullURLLevel($_GET['r'],'drag_drop_input_job.php',0,'N')."&style=$style&schedule=$schedule&cutno=$cutno&color=$color&mpo=$mpo&sub_po=$sub_po';</script>";
	// echo "<script>window.close ();</script>";
	
	}
?> 
</div> 
</div> 
</div> 



<?php
if(isset($_GET['color']))
     echo "<script>document.getElementById('sub').disabled = false;</script>";
?>
