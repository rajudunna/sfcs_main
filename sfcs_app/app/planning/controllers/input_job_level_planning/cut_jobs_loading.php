<?php
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',4,'R')); 
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/functions_dashboard.php',4,'R'));

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
	window.location.href =url1+"&style="+window.btoa(unescape(encodeURIComponent(document.test.style.value)));
	// window.location.href ="cut_jobs_loading.php?style="+document.test.style.value
}

function secondbox()
{
	var url2 = '<?= getFullUrl($_GET['r'],'cut_jobs_loading.php','N'); ?>';
	window.location.href =url2+"&style="+window.btoa(unescape(encodeURIComponent(document.test.style.value)))+"&schedule="+document.test.schedule.value;
	// window.location.href ="cut_jobs_loading.php?style="+document.test.style.value+"&schedule="+document.test.schedule.value
}
function thirdbox()
{ 
	var url3 = '<?= getFullUrl($_GET['r'],'cut_jobs_loading.php','N'); ?>';
	window.location.href =url3+"&style="+window.btoa(unescape(encodeURIComponent(document.test.style.value)))+"&schedule="+document.test.schedule.value+"&color="+window.btoa(unescape(encodeURIComponent(document.test.color.value)));
	// window.location.href ="cut_jobs_loading.php?style="+document.test.style.value+"&schedule="+document.test.schedule.value+"&color="+document.test.color.value
}
function fourthbox()
{
	var url4 = '<?= getFullUrl($_GET['r'],'cut_jobs_loading.php','N'); ?>';
	window.location.href =url4+"&style="+window.btoa(unescape(encodeURIComponent(document.test.style.value)))+"&schedule="+document.test.schedule.value+"&color="+window.btoa(unescape(encodeURIComponent(document.test.color.value)))+"&cutno="+document.test.cutno.value;
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
$style=style_decode($_GET['style']);
$schedule=$_GET['schedule']; 
$color=color_decode($_GET['color']);
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

/**/
echo "Select Style: <select name=\"style\" class=\"form-control\" onchange=\"firstbox();\" id='style'>";

//$sql="select distinct order_style_no from bai_orders_db where order_tid in (select order_tid from plandoc_stat_log)";
//if(isset($_SESSION['SESS_MEMBER_ID']) || (trim($_SESSION['SESS_MEMBER_ID']) != '')) 
//{
	$sql="select distinct order_style_no from $bai_pro3.plan_doc_summ order by order_style_no";	
	echo $sql;
//}
// mysqli_query($link, $sql) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_result=mysqli_query($link, $sql) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_num_check=mysqli_num_rows($sql_result);

echo "<option value=\"NIL\" selected>NIL</option>";
while($sql_row=mysqli_fetch_array($sql_result))
{

if(str_replace(" ","",$sql_row['order_style_no'])==str_replace(" ","",$style))
{
	echo "<option value=\"".$sql_row['order_style_no']."\" selected>".$sql_row['order_style_no']."</option>";
}
else
{
	echo "<option value=\"".$sql_row['order_style_no']."\">".$sql_row['order_style_no']."</option>";
}

}

echo "</select>";

?>

<?php
$sql="select distinct order_del_no from $bai_pro3.plan_doc_summ where order_style_no=\"$style\" order by order_del_no*1";	
echo "Select Schedule: <select name=\"schedule\" class=\"form-control\" onchange=\"secondbox();\" id='schedule'>";
// mysqli_query($link, $sql) or exit("Sql Error3".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_result=mysqli_query($link, $sql) or exit("Sql Error4".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_num_check=mysqli_num_rows($sql_result);

echo "<option value=\"NIL\" selected>NIL</option>";
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
//For color Clubbing

}


echo "</select>";


?>

<?php

$sql="select distinct order_col_des from $bai_pro3.plan_doc_summ where order_del_no=\"$schedule\" order by order_col_des";	
echo "Select Color: <select name=\"color\" class=\"form-control\" onchange=\"thirdbox();\" id='color'>";

$sql_result=mysqli_query($link, $sql) or exit("Sql Error5".mysqli_error($GLOBALS["___mysqli_ston"]));
echo "<option value=\"NIL\" selected>NIL</option>";
while($sql_row=mysqli_fetch_array($sql_result))
{

if(str_replace(" ","",$sql_row['order_col_des'])==str_replace(" ","",$color))
{
	echo "<option value=\"".$sql_row['order_col_des']."\" selected>".$sql_row['order_col_des']."</option>";
}
else
{
	echo "<option value=\"".$sql_row['order_col_des']."\">".$sql_row['order_col_des']."</option>";
}
//For color Clubbing

}


echo "</select>";

?>

<?php

echo "Select CutNo: <select name=\"cutno\" class=\"form-control\" onchange=\"fourthbox();\" id='cutno'>";


$sql="select distinct pcutno as pcutno from $bai_pro3.order_cat_doc_mix where order_style_no=\"$style\" and order_del_no=\"$schedule\" and order_col_des=\"$color\" order by pcutno";	

$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
echo "<option value=\"NIL\" selected>NIL</option>";
if($color!='')
{
echo "<option value=\"All\" selected>All</option>";	
}
while($sql_row=mysqli_fetch_array($sql_result))
{

if(str_replace(" ","",$sql_row['pcutno'])==str_replace(" ","",$cutno))
{
	echo "<option value=\"".$sql_row['pcutno']."\" selected>".$sql_row['pcutno']."</option>";
}
else
{
	echo "<option value=\"".$sql_row['pcutno']."\">".$sql_row['pcutno']."</option>";
}

}


echo "</select>";
?>

<?php


$code="";
//$sql="select doc_no,color_code,acutno,act_cut_status,cat_ref from plan_doc_summ where order_style_no=\"$style\" and order_del_no=\"$schedule\" and order_col_des=\"$color\" and plan_module is NULL order by doc_no";
//$sql="select doc_no,color_code,acutno,act_cut_status,cat_ref from plan_doc_summ where order_style_no=\"$style\" and order_del_no=\"$schedule\" and order_col_des=\"$color\" and (plan_module is NULL or a_plies<>p_plies or act_cut_issue_status='') order by doc_no";

//2014-01-11 $sql="select doc_no,color_code,acutno,act_cut_status,cat_ref from plan_doc_summ where order_style_no=\"$style\" and order_del_no=\"$schedule\" and order_col_des=\"$color\" and doc_no not in (select doc_no from plan_dashboard) order by doc_no";

$sql="select doc_no,color_code,acutno,act_cut_status,cat_ref from $bai_pro3.plan_doc_summ where order_style_no=\"$style\" and order_del_no=\"$schedule\" and doc_no not in (select doc_no from plan_dashboard) and (a_plies<>p_plies or act_cut_issue_status='') order by doc_no";
//echo $sql;
// mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_num_check=mysqli_num_rows($sql_result);
//docketno-colorcode cutno-cut_status
while($sql_row=mysqli_fetch_array($sql_result))
{
	//$code.=$sql_row['doc_no']."-".chr($sql_row['color_code']).leading_zeros($sql_row['acutno'],3)."-".$sql_row['act_cut_status']."*";
	$cat_ref=$sql_row['cat_ref'];
}

$sql="select cat_ref from $bai_pro3.plan_doc_summ where order_style_no=\"$style\" and order_del_no=\"$schedule\" and order_col_des='$color' order by doc_no";
// mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_num_check=mysqli_num_rows($sql_result);
//docketno-colorcode cutno-cut_status
while($sql_row=mysqli_fetch_array($sql_result))
{
	$cat_ref=$sql_row['cat_ref'];
}

$sql12="select * from $bai_pro3.packing_summary_input where order_style_no=\"$style\" and order_del_no=\"$schedule\" and order_col_des='$color'";
$sql_result12=mysqli_query($link, $sql12) or exit("Sql Error11".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_num_check12=mysqli_num_rows($sql_result12);

if($sql_num_check>0)
{
	if($sql_num_check12>0)
	{	
		echo "Cut Jobs Available  :&nbsp;&nbsp;"."<span class='label label-success'>YES</span>&nbsp;&nbsp;";
		echo "Sewing Jobs Available  :&nbsp;&nbsp;"."<span class='label label-success'>YES</span>&nbsp;&nbsp;";
		echo "<input type=\"hidden\" name=\"code\" value=\"$code\">";
		echo "<input type=\"hidden\" name=\"cat_ref\" value=\"$cat_ref\">";
		echo "<input type=\"submit\" value=\"Submit\" name=\"submit\" id='sub' disabled class='btn btn-success'>";
	}
	else
	{
		echo "Cut Jobs Available  :&nbsp;&nbsp;"."<span class='label label-success'>YES</span>&nbsp;&nbsp;";
		echo "Sewing Jobs Available :"."<span class='label label-danger'>No</span>&nbsp;&nbsp;";
	}
}
else
{
	echo "Cut Jobs Available:"."<span class='label label-danger'>No</span>&nbsp;&nbsp;";
	echo "Sewing Jobs Available :"."<span class='label label-danger'>No</span>&nbsp;&nbsp;";
	/*echo "<input type=\"hidden\" name=\"code\" value=\"$code\">";
	echo "<input type=\"hidden\" name=\"cat_ref\" value=\"$cat_ref\">";
	echo "<input type=\"submit\" value=\"submit\" name=\"submit\">";*/
}

?>
</div>

</form>

<?php

$floor_set_schedule=array();
$floor_set_order_tid=array();
//$sql="select group_concat(order_del_no) as order_del_no from bai_orders_db where left(order_style_no,1)=\"".substr($style,0,1)."\" and order_col_des=\"$color\"  AND (order_s_xs=9 OR order_s_s=10)";
//$sql="select group_concat(order_del_no) as order_del_no, group_concat(order_tid SEPARATOR \"','\") as order_tid from bai_orders_db where order_style_no=\"".$style."\" and order_col_des=\"$color\"  AND (order_s_xs=9 OR order_s_s=10) and order_del_no>0";

$sql="select order_del_no, order_tid from $bai_pro3.bai_orders_db where order_style_no=\"".$style."\"  AND (order_s_xs=9 OR order_s_s=10 OR order_s_s=17 OR order_s_s14=3 OR order_s_s18=3) and order_del_no>0";
//echo $sql;
$sql_result=mysqli_query($link, $sql) or exit("Sql Error10".mysqli_error($GLOBALS["___mysqli_ston"]));
$floor_set_count=mysqli_num_rows($sql_result);
while($sql_row=mysqli_fetch_array($sql_result))
{
	$floor_set_schedule[]=$sql_row['order_del_no'];
	$floor_set_order_tid[]=$sql_row['order_tid'];
}


if($floor_set_count>0)
{
	$display="";
	
	for($i=0;$i<sizeof($floor_set_schedule);$i++)
	{
		if($floor_set_schedule[$i]!=NULL)
		{
			$highlight="red";
			//$sql="select doc_no from plandoc_stat_log where order_tid like \"%$floor_set_schedule%\" and plan_module>0";
			$sql="select doc_no from $bai_pro3.plandoc_stat_log where order_tid='".$floor_set_order_tid[$i]."' and plan_module>0";
			$sql_result=mysqli_query($link, $sql) or exit("Sql Error11".mysqli_error($GLOBALS["___mysqli_ston"]));
			if(mysqli_num_rows($sql_result)>0)
			{
				$highlight="green";
			}
			$display.="<font color=$highlight>".$floor_set_schedule[$i]."</font>";
			
		}
	}
	
	echo "<h2>The following $display are Floor Sets, Please do plan accordingly.</h2>";
}

?>

<?php
if(isset($_POST['submit']) && short_shipment_status($_POST['style'],$_POST['schedule'],$link))
{
	echo "<br><br><center><h2><font color=\"green\">Please Wait...</font></h2></center>";
	$style=$_POST['style'];
	$schedule=$_POST['schedule'];
	//$module=$_POST['modules'];
	$color=$_POST['color'];
	$cutno=$_POST['cutno'];
    
    //Encoded values
    $main_style=style_encode($style);
    $main_color=color_encode($color);
 
	//$color=$_POST['color'];
	//echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = \"drag_drop_input_job.php?style=$style&schedule=$schedule&code=$code\"; }</script>";
	// echo("<script>window.open('".getFullURLLevel($_GET['r'],'drag_drop_input_job.php',0,'N')."&style=$style&schedule=$schedule&code=$code');</script>");
	echo "<script>window.location = '".getFullURLLevel($_GET['r'],'drag_drop_input_job.php',0,'N')."&style=$main_style&schedule=$schedule&cutno=$cutno&color=$main_color';</script>";
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
