<?php
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R')); 

//list($domain,$username) = split('[\]',$_SERVER['AUTH_USER'],2);
//$username_list=explode('\\',$_SERVER['REMOTE_USER']);
//$username=strtolower($username_list[1]);
$username="sfcsproject1";
//echo $username;

$authorized=array("sfcsproject1");
$super_user=array("sfcsproject1");
$hour=date("H.i");

	if(in_array(strtolower($username),$super_user))
	{
	
	}
	else if(in_array(strtolower($username),$authorized))
	{
		
		//New Implementation to restrict as per time lines to update Planning Board 20111211
		$hour=date("H.i");
		
		//if(($hour>=7.45 and $hour<=10.00) or ($hour>=15.15 and $hour<=16.45)) //OLD
		//GOOD ONE if(($hour>=7.45 and $hour<=10.45) or ($hour>=12.30 and $hour<=14.00) or ($hour>=16.00 and $hour<=17.30))
		//if(($hour>=7.15 and $hour<=9.45) or ($hour>=15.15 and $hour<=17.15))
		if(($hour>=06.00 and $hour<=09.00) or ($hour>=14.00 and $hour<=19.00))
		{
			
		}
		else
		{
			header("Location:time_out.php?msg=1");
		}
	}
	else
	{
	   header("Location:restrict.php");
	}
	


// $criteria="where left(order_style_no,1) in (".$global_style_codes.")";
if(!(in_array(strtolower($username),$super_user)) or !(in_array(strtolower($username),$authorized)))
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
		cutno = $('#cutno').val();
		if(style === 'NIL' && schedule === 'NIL' && cutno === 'NIL'){
			sweetAlert('Please Select Style, Schedule and CutNo','','warning');
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
include(getFullURLLevel($_GET['r'],'common/config/functions.php',3,'R'));?>
<?php
$style=$_GET['style'];
$schedule=$_GET['schedule']; 
$color=$_GET['color'];

//echo $style.$schedule.$color;
?>
<div class="panel panel-primary">
<div class="panel-heading"><strong>Job Level Planning</strong></div>
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
	$sql="select distinct order_style_no from $bai_pro3.plan_doc_summ $criteria";	
	echo $sql;
//}
mysqli_query($link, $sql) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
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



//$sql="select distinct order_style_no from bai_orders_db where order_tid in (select distinct order_tid from plandoc_stat_log) and order_style_no=\"$style\"";
//if(isset($_SESSION['SESS_MEMBER_ID']) || (trim($_SESSION['SESS_MEMBER_ID']) != '')) 
//{
	//$sql="select distinct order_del_no from plan_doc_summ_input";	
	//$sql="select distinct order_del_no from bai_orders_db where $order_joins_in_full order by order_joins*1";
	$sql="select distinct order_del_no from $bai_pro3.plan_doc_summ where order_style_no=\"$style\"";	
//}
echo "Select Schedule: <select name=\"schedule\" class=\"form-control\" onchange=\"secondbox();\" id='schedule'>";
mysqli_query($link, $sql) or exit("Sql Error3".mysqli_error($GLOBALS["___mysqli_ston"]));
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

echo "Select CutNo: <select name=\"color\" class=\"form-control\" onchange=\"thirdbox();\" id='cutno'>";


$sql="select distinct pcutno as pcutno from $bai_pro3.order_cat_doc_mix where order_style_no=\"$style\" and order_del_no=\"$schedule\" order by pcutno";	

//For Color Clubbing
/*
if($clubbing>0)
{
	$sql="select distinct order_col_des from plan_doc_summ where order_style_no=\"$style\" and order_del_no=\"$schedule\" group by clubbing,order_col_des";		
}
*/
//echo $sql;

//}
mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_num_check=mysqli_num_rows($sql_result);

echo "<option value=\"NIL\" selected>NIL</option>";
	
while($sql_row=mysqli_fetch_array($sql_result))
{

if(str_replace(" ","",$sql_row['pcutno'])==str_replace(" ","",$color))
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
mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_num_check=mysqli_num_rows($sql_result);
//docketno-colorcode cutno-cut_status
while($sql_row=mysqli_fetch_array($sql_result))
{
	//$code.=$sql_row['doc_no']."-".chr($sql_row['color_code']).leading_zeros($sql_row['acutno'],3)."-".$sql_row['act_cut_status']."*";
	$cat_ref=$sql_row['cat_ref'];
}

$sql="select cat_ref from $bai_pro3.plan_doc_summ where order_style_no=\"$style\" and order_del_no=\"$schedule\" order by doc_no";
mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_num_check=mysqli_num_rows($sql_result);
//docketno-colorcode cutno-cut_status
while($sql_row=mysqli_fetch_array($sql_result))
{
	$cat_ref=$sql_row['cat_ref'];
}




if($sql_num_check>0)
{
	// $sql1="select group_concat(sec_mods) as mods from bai_pro3.sections_db";
	// mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	// $sql_result1=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	// while($sql_row1=mysqli_fetch_array($sql_result1))
	// {
	// 	$modules=$sql_row1["mods"];
	// }	
	// $modules_array=explode(",",$modules);
	
	// if(strlen($color)>0)
	// {
	// 	echo "Select Modules: <select name=\"modules\" class=\"form-control\" id='modules'>";
	// 	for($i1=0;$i1<sizeof($modules_array);$i1++)
	// 	{
	// 		echo "<option value=\"".$modules_array[$i1]."\">".$modules_array[$i1]."</option>";
	// 	}
	// 	echo "</select>&nbsp;&nbsp;";
	// }
	
	echo "Jobs Available  :&nbsp;&nbsp;"."<span class='label label-success'>YES</span>&nbsp;&nbsp;";
	echo "<input type=\"hidden\" name=\"code\" value=\"$code\">";
	echo "<input type=\"hidden\" name=\"cat_ref\" value=\"$cat_ref\">";
	echo "<input type=\"submit\" value=\"submit\" name=\"submit\" id='sub' disabled class='btn btn-success'>";	
}
else
{
	echo "Docket Available  :"."<span class='label label-danger'>No</span>&nbsp;&nbsp;";
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
if(isset($_POST['submit']))
{
	$style=$_POST['style'];
	$schedule=$_POST['schedule'];
	//$module=$_POST['modules'];
	$color=$_POST['color'];
	$newfiltertable="temp_pool_db.plan_doc_summ_input_v2_".$username;
	$sql="DROP TABLE IF EXISTS $newfiltertable";
	//echo $sql."<br/>";
	//mysql_query($sql,$link) or exit("Sql Error17".mysql_error()
	
	//$schedule_list=$schedule;
	
	$sql2="select * from $bai_pro3.bai_orders_db where order_joins=\"J$schedule\"";
	$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error8".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_num_check2=mysqli_num_rows($sql_result2);
	if($sql_num_check2 > 0)
	{
		$sql3="select distinct order_del_no as del from $bai_pro3.bai_orders_db where order_joins=\"J$schedule\"";
	}
	else
	{
		$sql3="select distinct order_del_no as del from $bai_pro3.bai_orders_db where order_del_no=\"$schedule\"";
	}
	
	$sql_result3=mysqli_query($link, $sql3) or exit("Sql Error8".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_num_check3=mysqli_num_rows($sql_result3);
	while($sql_row3=mysqli_fetch_array($sql_result3))
	{
		$schedule_no[]=$sql_row3["del"];
	}
	
	$schedule_list=implode(",",$schedule_no);
	
	//This is to handle schedule club deliveries
	$sql="DROP TABLE IF EXISTS $newfiltertable";
	//echo $sql."<br/>";
	mysqli_query($link, $sql) or exit("Sql Error17".mysqli_error($GLOBALS["___mysqli_ston"]));
	$application='IPS';			
	$scanning_query=" select * from $brandix_bts.tbl_ims_ops where appilication='$application'";
	// echo $scanning_query;
	$scanning_result=mysqli_query($link, $scanning_query)or exit("scanning_error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row=mysqli_fetch_array($scanning_result))
	{
		$operation_name=$sql_row['operation_name'];
		$operation_code=$sql_row['operation_code'];
	}
	//$sql="CREATE TABLE $newfiltertable ENGINE = MYISAM select order_style_no,input_job_no_random,group_concat(distinct input_job_no) as input_job_no,doc_no,group_concat(distinct char(color_code)) as color_code,group_concat(distinct acutno) as acutno,act_cut_status,input_job_input_status(input_job_no_random) as act_cut_issue_status,cat_ref,input_job_no,SUM(carton_act_qty) AS carton_qty from plan_doc_summ_input where order_del_no in ($schedule_list) and input_job_no_random not in (select input_job_no_random_ref from plan_dashboard_input) and input_job_input_status(input_job_no_random)='' group by input_job_no order by input_job_no*1";
	$sql="CREATE TABLE $newfiltertable ENGINE = MYISAM select order_style_no,input_job_no_random,group_concat(distinct input_job_no) as input_job_no,doc_no,group_concat(distinct char(color_code)) as color_code,group_concat(distinct acutno) as acutno,act_cut_status,input_job_input_status(input_job_no_random,$operation_code) as act_cut_issue_status,cat_ref,SUM(carton_act_qty) AS carton_qty from plan_doc_summ_input where order_del_no in ($schedule_list) and acutno=$color and input_job_no_random not in (select input_job_no_random_ref from plan_dashboard_input) and input_job_input_status(input_job_no_random,$operation_code)='' group by input_job_no order by input_job_no*1";
	// echo $sql."<br/>";
	mysqli_query($link, $sql) or exit("Sql Error16".mysqli_error($GLOBALS["___mysqli_ston"]));
	
	$sql="select * from $newfiltertable";
	
	mysqli_query($link, $sql) or exit("Sql Error8".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error8".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_num_check=mysqli_num_rows($sql_result);
	//docketno-colorcode cutno-cut_status
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		$display_prefix1 = get_sewing_job_prefix("prefix","$brandix_bts.tbl_sewing_job_prefix","$bai_pro3.packing_summary_input",$schedule,$color,$sql_row['input_job_no'],$link);
		$code.=$sql_row['input_job_no_random']."-".$display_prefix1."-".$sql_row['act_cut_issue_status']."-".$sql_row["carton_qty"]."-".$sql_row["doc_no"]."-A".$sql_row["acutno"]."-".$module."*";
		//echo "Doc=".$doc_no."<br>";
		$style=$sql_row['order_style_no'];
	}
	
	//echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = \"drag_drop_input_job.php?style=$style&schedule=$schedule&code=$code\"; }</script>";
	echo("<script>window.open('".getFullURLLevel($_GET['r'],'drag_drop_input_job.php',0,'N')."&style=$style&schedule=$schedule&code=$code');</script>");
	// echo "<script>window.location = 'drag_drop_input_job.php?style=$style&schedule=$schedule&code=$code&module=$module';</script>";
	echo "<script>window.close ();</script>";
	
	}
?> 
</div> 
</div> 
</div> 



<?php
if(isset($_GET['color']))
     echo "<script>document.getElementById('sub').disabled = false;</script>";
?>
