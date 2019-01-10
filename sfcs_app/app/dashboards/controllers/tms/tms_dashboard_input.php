
<?php
$double_modules=array();
?>

<?php
set_time_limit(200000);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php

	echo '<META HTTP-EQUIV="refresh" content="120">';	
?>

<?php echo '<link href="'."http://".$_SERVER['HTTP_HOST']."/sfcs/styles/sfcs_styles.css".'" rel="stylesheet" type="text/css" />'; ?>

<?php
$rbac_username=getrbac_user()['uname'];

?>

<script>

function redirect_priority()
{
	y=document.getElementById('view_div').value;
	a=document.getElementById('view_priority').value;
	window.location = "<?= getFullURL($_GET['r'],'tms_dashboard_input.php','N')?>&view=2&view_div="+encodeURIComponent(y)+"&view_priority="+a;
}
function redirect_view()
{
	y=document.getElementById('view_div').value;
	a=document.getElementById('view_priority').value;
	window.location = "<?= getFullURL($_GET['r'],'tms_dashboard_input.php','N')?>&view=2&view_div="+encodeURIComponent(y)+"&view_priority="+a;
}

function redirect_dash()
{
	y=document.getElementById('view_div').value;
	a=document.getElementById('view_priority').value;
	window.location = "<?= getFullURL($_GET['r'],'tms_dashboard_input.php','N')?>&view=2&view_div="+encodeURIComponent(y)+"&view_priority="+a;
}


</script>



<script>
function blink_new(x)
{
	$("div[id='SJ"+x+"']").each(function() {
	
	$(this).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100);
	}); 
}

function blink_new3(x)
{
	$("div[id='S"+x+"']").each(function() {
	
	$(this).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100);
	}); 
}


function blink_new1(x)
{
	
	obj="#"+x;
	
	if ( $(obj).length ) 
	{
		$(obj).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100);
	}
}

function blink_new_priority(x)
{
	var temp=x.split(",");
	
	for(i=0;i<x.length;i++)
	{
		blink_new1(temp[i]);
	}
}

</script>


<style>
body
{
	background-color:#eeeeee;
	color: #000000;
	font-family: Trebuchet MS;
}
a {text-decoration: none;}

table
{
	border-collapse:collapse;
}
.new td
{
	border: 1px solid red;
	white-space:nowrap;
	border-collapse:collapse;
}

.new th
{
	border: 1px solid red;
	white-space:nowrap;
	border-collapse:collapse;
}

.bottom th,td
{
	 border-bottom: 1px solid #000000; 
	padding-bottom: 5px;
	padding-top: 5px;
}


.fontn a { display: block; height: 20px; padding: 5px; background-color:blue; text-decoration:none; color: #000000; font-family: Arial; font-size:12px; } 

.fontn a:hover { display: block; height: 20px; padding: 5px; background-color:green; font-family: Arial; font-size:12px;}

.fontnn a { color: #000000; font-family: Arial; font-size:12px; } 



a{
	text-decoration:none;
	color: #000000;
}

.gloss-pink{
	background : #FF7FFF;
	color : #000;
	width:20px;
  height:20px;
	font-weight : bold;
  display:block;
	text-align : center;
  float: left;
  margin: 2px;
	border: 1px solid black;
}

.white {
  width:20px;
  height:20px;
  background-color: #ffffff;
  display:block;
  float: left;
  margin: 2px;
  border: 1px solid black;
}

.white a {
  display:block;
  float: left;
  width:100%;
  height:100%;
  text-decoration:none;
}

.white a:hover {
  text-decoration:none;
  background-color: #ffffff;
}


.red {
  width:20px;
  height:20px;
  background-color: #ff0000;
  display:block;
  float: left;
  margin: 2px;
border: 1px solid black;
}

.red a {
  display:block;
  float: left;
  width:100%;
  height:100%;
  text-decoration:none;
}

.red a:hover {
  text-decoration:none;
  background-color: #ff0000;
}

.green {
  width:20px;
  height:20px;
  background-color: #00ff00;
  display:block;
  float: left;
  margin: 2px;
border: 1px solid black;
}

.green a {
  display:block;
  float: left;
  width:100%;
  height:100%;
  text-decoration:none;
}

.green a:hover {
  text-decoration:none;
  background-color: #00ff00;
}

.lgreen {
  width:20px;
  height:20px;
  background-color: #00ff00;
  display:block;
  float: left;
  margin: 2px;
border: 1px solid black;
 
 }

.lgreen a {
  display:block;
  float: left;
  width:100%;
  height:100%;
  text-decoration:none;
 
}

.lgreen a:hover {
  text-decoration:none;
  background-color: #00ff00;
  
}

.yellow {
  width:20px;
  height:20px;
  background-color: #ffff00;
  display:block;
  float: left;
  margin: 2px;
border: 1px solid black;
}

.yellow a {
  display:block;
  float: left;
  width:100%;
  height:100%;
  text-decoration:none;
}

.yellow a:hover {
  text-decoration:none;
  background-color: #ffff00;
}


.pink {
  width:20px;
  height:20px;
  background-color: #ff00ff;
  display:block;
  float: left;
  margin: 2px;
border: 1px solid black;
}

.pink a {
  display:block;
  float: left;
  width:100%;
  height:100%;
  text-decoration:none;
}

.pink a:hover {
  text-decoration:none;
  background-color: #ff00ff;
}

.orange {
  width:20px;
  height:20px;
  background-color: #991144;
  display:block;
  float: left;
  margin: 2px;
border: 1px solid black;
}

.orange a {
  display:block;
  float: left;
  width:100%;
  height:100%;
  text-decoration:none;
}

.orange a:hover {
  text-decoration:none;
  background-color: #991144;
}

.blue {
  width:20px;
  height:20px;
  background-color: #15a5f2;
  display:block;
  float: left;
  margin: 2px;
border: 1px solid black;
}

.blue a {
  display:block;
  float: left;
  width:100%;
  height:100%;
  text-decoration:none;
}

.blue a:hover {
  text-decoration:none;
  background-color: #15a5f2;
}


.yash {
  width:20px;
  height:20px;
  background-color: #999999;
  display:block;
  float: left;
  margin: 2px;
border: 1px solid black;
}

.yash a {
  display:block;
  float: left;
  width:100%;
  height:100%;
  text-decoration:none;
}

.yash a:hover {
  text-decoration:none;
  background-color: #999999;
}

.black {
  width:20px;
  height:20px;
  background-color: black;
  display:block;
  float: left;
  margin: 2px;
border: 1px solid black;
}

.brown {
  width:20px;
  height:20px;
  background-color: #333333;
  display:block;
  float: left;
  margin: 2px;
border: 1px solid black;
}

.black a {
  display:block;
  float: left;
  width:100%;
  height:100%;
  text-decoration:none;
}
.black a:hover {
  text-decoration:none;
  background-color: black;
}

</style>

<SCRIPT>
// <!--
function doBlink() {
	var blink = document.all.tags("BLINK")
	for (var i=0; i<blink.length; i++)
		blink[i].style.visibility = blink[i].style.visibility == "" ? "hidden" : "" 
}

function startBlink() {
	if (document.all)
		setInterval("doBlink()",1000)
}
window.onload = startBlink;

// -->
</SCRIPT>

</head>

<body>
<?php 
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config.php');
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/functions.php');
$has_permission=haspermission($_GET['r']);


$sql="DROP TABLE IF EXISTS $temp_pool_db.plan_doc_summ_input_tms_$rbac_username";
//echo $sql."<br/>";
mysqli_query($link, $sql) or exit("Sql Error17".mysqli_error($GLOBALS["___mysqli_ston"]));

$sql="CREATE TABLE $temp_pool_db.plan_doc_summ_input_tms_$rbac_username ENGINE = MYISAM SELECT MIN(st_status) AS st_status,order_style_no,input_job_no_random,GROUP_CONCAT(DISTINCT order_del_no) AS order_del_no,GROUP_CONCAT(DISTINCT input_job_no) AS input_job_no,GROUP_CONCAT(DISTINCT doc_no) AS doc_no FROM $bai_pro3.plan_doc_summ_input GROUP BY input_job_no_random";
mysqli_query($link, $sql) or exit("Sql Error16".mysqli_error($GLOBALS["___mysqli_ston"]));
?>
<div class="panel panel-primary">
<div class="panel-heading"><strong>Sewing Trims Status Dashboard</strong></div>
<div class="panel-body">
	<div class="form-inline">
		<div class="form-group">
			<?php
				echo 'Sewing Job Track: <input type="text" class="form-control integer" onkeyup="blink_new(this.value)" size="10">&nbsp;&nbsp;';
			?>
		</div>
		<div class="form-group">
			<?php
				echo 'Schedule Track: <input type="text" class="form-control integer" onkeyup="blink_new3(this.value)" size="10"> &nbsp;&nbsp;';
			?>
		</div>
<div class="form-group">		
<?php
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));
// Ticket #424781 Disply buyer division from the database level plan_module table
echo '&nbsp;&nbsp;Buyer Division :
<select name="view_div" id="view_div" class="form-control" onchange="redirect_view()">';
echo "<option value=\"ALL\" selected >ALL</option>";
// $sqly="select distinct(buyer_div) from plan_modules";
$sqly="SELECT GROUP_CONCAT(buyer_name) as buyer_name,buyer_code AS buyer_div FROM $bai_pro2.buyer_codes GROUP BY BUYER_CODE ORDER BY buyer_code";
//echo $sqly."<br>";

// mysqli_query($link, $sqly) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_resulty=mysqli_query($link, $sqly) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_rowy=mysqli_fetch_array($sql_resulty))
{
	$buyer_div=$sql_rowy['buyer_div'];
	$buyer_name=$sql_rowy['buyer_name'];

	if(urldecode($_GET["view_div"])=="$buyer_name") 
	{
		echo "<option value=\"".$buyer_name."\" selected>".$buyer_div."</option>";  
	} 
	else 
	{
		echo "<option value=\"".$buyer_name."\" >".$buyer_div."</option>"; 
	}
}

echo '</select>';
echo '&nbsp;&nbsp;&nbsp;Priorities:<select name="view_priority" class="form-control" id="view_priority" onchange="redirect_priority()">';
if($_GET['view_priority']=="4") { echo '<option value="4" selected>4</option>'; } else { echo '<option value="4">4</option>'; }
if($_GET['view_priority']=="6") { echo '<option value="6" selected>6</option>'; } else { echo '<option value="6">6</option>'; }
if($_GET['view_priority']=="8") { echo '<option value="8" selected>8</option>'; } else { echo '<option value="8">8</option>'; }
echo '</select>';

if(isset($_GET['view_priority']))
{
	$priority_limit=$_GET['view_priority'];
}
else
{
	$priority_limit=4;
}
echo '</div>';
echo "</font>";
?>
</div>
</div>
<?php
//For blinking priorties as per the section module wips
$bindex=0;
$blink_docs=array();
$table_name="$temp_pool_db.plan_dash_doc_summ_input_".$rbac_username;
$sql="DROP TABLE IF EXISTS $table_name";
mysqli_query($link, $sql) or exit("Sql Error17".mysqli_error($GLOBALS["___mysqli_ston"]));

$sql="CREATE TABLE $table_name ENGINE = myisam SELECT * FROM $bai_pro3.plan_dash_doc_summ_input ";
mysqli_query($link, $sql) or exit("Sql Error16".mysqli_error($GLOBALS["___mysqli_ston"]));

$sqlx="SELECT section_display_name,section_head AS sec_head,ims_priority_boxs,GROUP_CONCAT(`module_name` ORDER BY module_name+0 ASC) AS sec_mods,section AS sec_id FROM $bai_pro3.`module_master` LEFT JOIN $bai_pro3.sections_master ON module_master.section=sections_master.sec_name GROUP BY section ORDER BY section + 0";
$sql_resultx=mysqli_query($link, $sqlx) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_rowx=mysqli_fetch_array($sql_resultx))
{
	$section=$sql_rowx['sec_id'];
	$section_head=$sql_rowx['sec_head'];
	$section_mods=$sql_rowx['sec_mods'];
	$section_display_name=$sql_rowx['section_display_name'];

	if($_GET["view_div"]!='ALL' && $_GET["view_div"]!='')
	{
		$buyer_division=urldecode($_GET["view_div"]);
		$buyer_division_ref='"'.str_replace(",",'","',$buyer_division).'"';
		$order_div_ref="and order_div in (".$buyer_division_ref.")";
	}
	else {
		 $order_div_ref='';
		 $buyer_division_ref='';
	}	
	$wip=array();
	$sql1d="SELECT module_id as modx from $bai_pro3.plan_modules where module_id in (".$section_mods.") order by module_id*1";
    if($_GET["view_div"]=="ALL" or $_GET["view_div"]=="")
    {
		$sql1d="SELECT module_id as modx from $bai_pro3.plan_modules where module_id in (".$section_mods.") order by module_id*1";
	}
	else
	{
		$sql1d="SELECT module_id as modx from $bai_pro3.plan_modules where module_id in (".$section_mods.") order by module_id*1"; 
	}
	
	$sql_num_checkd=0;
	$sql_result1d=mysqli_query($link, $sql1d) or exit("Sql Errordd".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_num_checkd=mysqli_num_rows($sql_result1d);
	if($sql_num_checkd > 0)
	{		
		$mods=array();
		while($sql_row1d=mysqli_fetch_array($sql_result1d))
		{
			$mods[]=$sql_row1d["modx"];
		}
		$url_path = getFullURLLevel($_GET['r'],'board_update_V2_input.php',0,'R');
		echo '<div style="background-color:#ffffff;color:#000000;border: 1px solid #000000; float: left; margin: 10px; padding: 10px;height:100%;" class="hide_table">';
		echo "<p>";
		echo "<table>";
		
		echo "<tr><th colspan=2><h2><a href=\"javascript:void(0)\" onclick=\"Popup=window.open('$url_path?section_no=$section"."','Popup','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes, width=880,height=400, top=23'); if (window.focus) {Popup.focus()} return false;\">$section_display_name</a></h2></th></th></tr>";
		
		//For Section level blinking
		$blink_minimum=0;
		$sql11="select ims_mod_no, sum(ims_qty-ims_pro_qty) as \"wip\" from $bai_pro3.ims_log where ims_mod_no IN (".implode(',',$mods).") GROUP BY ims_mod_no";
		$sql_result11=mysqli_query($link, $sql11) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row11=mysqli_fetch_array($sql_result11))
		{
			$wip[$sql_row11['ims_mod_no']]=$sql_row11['wip'];
		} 

		for($x=0;$x<sizeof($mods);$x++)
		{
			$module=$mods[$x];
			if(strlen($module) > 0)
			{
				if(!array_key_exists($module, $wip)){
					$wip[$module] = '';
				}
			}
			$blink_check=0;
			echo "<tr class=\"bottom\">";
			echo "<td class=\"bottom\"><strong><a href=\"javascript:void(0)\" 
			 if (window.focus) {Popup.focus()} return false;\"><font class=\"fontnn\" color=black >$module</font></a></strong></td><td>";
			$y=0;

			$show_block = calculateJobsCount($table_name,$module,$order_div_ref);
			if($show_block > 0){
				echo "<div style='float:left;'>		    
										<a href=\"../".getFullURL($_GET['r'],'issued_to_module_summary_report.php','R')."?jobno=$input_job_no&module=$module&section=$section&doc_no=$input_job_no_random_ref&isinput=0\" onclick=\"Popup=window.open('/sfcs_app/app/dashboards/controllers/tms/issued_to_module_summary_report.php?jobno=$input_job_no&module=$module&section=$section&doc_no=$input_job_no_random_ref&isinput=0','Popup','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes, width=920,height=400, top=23'); if (window.focus) {Popup.focus()} return false;\"><div  class='gloss-pink' style='float:left;'><b>$show_block</b></div></a>
											
							</div>";
			}

			$sql="SELECT * FROM $table_name WHERE (input_trims_status!=4 or input_trims_status IS NULL) and input_module=$module ".$order_div_ref." GROUP BY input_job_no_random_ref order by input_priority asc ";	
			$result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($row=mysqli_fetch_array($result))
			{
				if($y==$priority_limit)
				{
					break;
				}				
				$input_job_no_random_ref=$row["input_job_no_random_ref"];
				$input_trims_status=$row["input_trims_status"];
				$sql2="SELECT min(st_status) as st_status,order_style_no,order_del_no,input_job_no FROM $temp_pool_db.plan_doc_summ_input_tms_$rbac_username WHERE input_job_no_random='$input_job_no_random_ref'";	
				$result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($row2=mysqli_fetch_array($result2))
				{
					$trims_status=$row2['st_status'];
					$style=$row2['order_style_no'];
					$schedule=$row2['order_del_no'];
					$input_job_no=$row2['input_job_no'];
				}									
				if($input_trims_status==4)
				{
					$id="pink"; 
				}
				else if($input_trims_status == 2 or $input_trims_status == 3)
				{
					$id="blue"; 
				}
				else if($input_trims_status == 1)
				{
					$id="yellow";
				}
				else
				{
					if($trims_status=="NULL" || $trims_status=="" || $trims_status=="(NULL)")
					{
						$id="yash";
					}			
					else if($trims_status == 0 || $trims_status == 9)
					{
						$id="red";
					}			
					else if($trims_status == 1)
					{
						$id="lgreen";
					}			
					else
					{
						$id="red";
					}
				}
				$get_color = echo_title("$bai_pro3.packing_summary_input","order_col_des","order_del_no='$schedule' and input_job_no",$input_job_no,$link);
				$display_prefix1 = get_sewing_job_prefix("prefix","$brandix_bts.tbl_sewing_job_prefix","$bai_pro3.packing_summary_input",$schedule,$get_color,$input_job_no,$link);
				$title=str_pad("Style:".$style,80)."\n".str_pad("Schedule:".$schedule,80)."\n".str_pad("Job_No:".$display_prefix1,80);
				if(in_array($authorized,$has_permission))
				{
					echo "<div id=\"S$schedule\" style=\"float:left;\"><div id=\"SJ$input_job_no\" style=\"float:left;\"><div id=\"$input_job_no_random_ref\" class=\"$id\" style=\"font-size:12px; text-align:center; color:$id\" title=\"$title\" ><a href=\"../".getFullURL($_GET['r'],'trims_status_update_input.php','R')."?jobno=$input_job_no&style=$style&schedule=$schedule&module=$module&section=$section&doc_no=$input_job_no_random_ref&isinput=0\" onclick=\"Popup=window.open('/sfcs_app/app/dashboards/controllers/tms/trims_status_update_input.php?jobno=$input_job_no&style=$style&schedule=$schedule&module=$module&section=$section&doc_no=$input_job_no_random_ref&isinput=0','Popup','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes, width=920,height=400, top=23'); if (window.focus) {Popup.focus()} return false;\"><font style=\"color:black;\">$letter</font></a></div></div></div>";
				}
				else
				{
					echo "<div id=\"S$schedule\" style=\"float:left;\"><div id=\"SJ$input_job_no\" style=\"float:left;\"><div id=\"$input_job_no_random_ref\" class=\"$id\" style=\"font-size:12px; text-align:center; color:$id\" title=\"$title\" ></div></div></div>";
				}					
				$y++;			
			}
			for($j=$y+1;$j<=$priority_limit;$j++)
			{
				echo "<div id=\"$schedule\" style=\"float:left;\"><div id=\"$input_job_no_random_ref\" style=\"float:left;\"><div id=\"$input_job_no_random_ref\" class=\"white\" style=\"font-size:12px; text-align:center; color:white\"><a href='#'></a></div></div></div>";
			}
			$sqly="select buyer_div from $bai_pro3.plan_modules where module_id=$module";
			$sql_resulty=mysqli_query($link, $sqly) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_rowy=mysqli_fetch_array($sql_resulty))
			{
				$buyer_div=$sql_rowy['buyer_div'];
				
				if(substr($buyer_div,0,1)=="M")
				{
					$cut_wip_control=7000;
				}		
			}
			echo "</td>";
			echo "</tr>";
		}
		//Blinking at section level
		$bindex++;

		echo "</table>";
		echo "</p>";
		echo '</div>';
	}

}
if((in_array($authorized,$has_permission)))
	{
		echo "<script>";
		echo "blink_new_priority('".implode(",",$blink_docs)."');";
		echo "</script>";
	}
?>
<div style="clear: both;"> </div>
<?php
include('include_legends_tms.php');
?>
<br/>	
</body>
</html> 



<?php

function calculateJobsCount($table_name,$module,$order_div_ref){
	global $link;
	$ijs_query  = "SELECT GROUP_CONCAT(DISTINCT input_job_no_random_ref) as jobs FROM $table_name WHERE input_trims_status=4  
						     AND input_module=$module $order_div_ref";
	$ijs_result = mysqli_query($link,$ijs_query);
	while($row = mysqli_fetch_array($ijs_result)){
		$jobs = $row['jobs'];
	}

	if($jobs == '')
		return 0;
	else{
		$ips_jobs_query = "SELECT count(distinct pdsi.input_job_no_random) AS ips_jobs_match_count
            FROM bai_pro3.plan_dashboard_input pdi
            LEFT JOIN bai_pro3.plan_doc_summ_input pdsi ON pdsi.input_job_no_random = pdi.input_job_no_random_ref
						WHERE input_module = $module AND pdsi.input_job_no_random IN ($jobs)";
		$inps_jobs_result = mysqli_query($link,$ips_jobs_query);
		while($row = mysqli_fetch_array($inps_jobs_result)){
				$ips_jobs_count = $row['ips_jobs_match_count'];
		}			 
	}

	if($ips_jobs_count == 0 || $ips_jobs_count == '')
		return 0;
	else	
		return $ips_jobs_count;
}


?>