<!--
Changes Log:

2014-03-18 / kirang/ Ticket #716563 : Add the chandrasekharka,venkataramak in $authorized Array 

2016-09-09 / kirang / Service Request#98739857 : FCA Status Not Turned After FCA    

-->
<?php
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'], "common/config/config.php", 3, "R"));
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'], "common/config/user_acl_v1.php", 3, "R"));
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'], "common/config/group_def.php", 3, "R"));
$view_access=user_acl("SFCS_0038",$username,1,$group_id_sfcs);
$authorized=user_acl("SFCS_0038",$username,7,$group_id_sfcs);
$fca_authorized=user_acl("SFCS_0038",$username,50,$group_id_sfcs);
$fg_authorized=user_acl("SFCS_0038",$username,51,$group_id_sfcs);
$spc_users=user_acl("SFCS_0038",$username,68,$group_id_sfcs);
set_time_limit(6000000);
$permission = haspermission($_GET['r']);
?>
<title>Weekly Delivery Dashboard - Packing</title>

<!-- <script type="text/javascript" src="datetimepicker_css.js"></script> -->
<script language="javascript" type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/tablefilter_en/table_filter.js', 3, 'R');?>"></script>
<style type="text/css" media="screen">

/*====================================================
	- HTML Table Filter stylesheet
=====================================================*/


/*====================================================
	- General html elements
=====================================================*/
/* body{ 
	margin:15px; padding:15px; border:0px solid #666;
	font-family:Arial, Helvetica, sans-serif; font-size:12px; 
}
a {
	margin:0px; padding:0px;
}
caption{ margin:10px 0 0 5px; padding:10px; text-align:left; }
pre{ font-size:13px; margin:5px; padding:5px; background-color:#f4f4f4; border:1px solid #ccc;  }
.mytable1{
	font-size:12px;
}
th{ background-color:#29759c; color:#FFF; padding:2px; border:1px solid #ccc; }
td{ padding:1px; border-bottom:1px solid #ccc; border-right:1px solid #ccc; white-space:nowrap;} */
</style>


<script>

function dodisable()
{
enableButton();
document.getElementById('process_message').style.visibility="hidden";
}


function enableButton() 
{
	if(document.getElementById('option').checked)
	{
		document.getElementById('submitx').disabled='';
	} 
	else 
	{
		document.getElementById('submitx').disabled='true';
	}
}

function button_disable()
{
	document.getElementById('process_message').style.visibility="visible";
	document.getElementById('option').style.visibility="hidden";
	document.getElementById('submitx').style.visibility="hidden";
}
</script>
<script language="javascript" type="text/javascript">
<!--
function popitup(url) 
{
	newwindow=window.open(url,'name','height=1000,width=650');
	if (window.focus) {newwindow.focus()}
	return false;
}
</script>

<!-- <?php echo '<link href="'."http://".$_SERVER['HTTP_HOST']."/styles/sfcs_styles.css".'" rel="stylesheet" type="text/css" />'; ?> -->

<body onload="dodisable();">
<?php

if(isset($_POST['division']))
{
	$division=$_POST['division'];
}
else
{
	$division="All";
}
?>

<div class="panel panel-primary">
	<div class="panel-heading">Next Week Delivery Status Report</h3></div>
	<div class="panel-body">
<?php

$weeknumber = date("W")+1; 
$date=date("Y-m-d",mktime(0, 0, 0, date("m")  , date("d")+7, date("Y")));
$ts = strtotime($date);

$year = date('o', $ts);
$week = date('W', $ts);

for($i = 1; $i <= 7; $i++) {
    $ts = strtotime($year.'W'.$week.$i);
	$dates[]=date("Y-m-d l", $ts);
    //print date("Y-m-d l", $ts) . "<br>";
}

$start_date=min($dates);
$end_date=max($dates);
$url = getFullURL($_GET['r'],'current_week_V2.php','N');
$current_week = getFullURL($_GET['r'],'current_week_V2.php','N');
$next_week = getFullURL($_GET['r'],'next_week_V2.php','N');
$summary =  getFullURL($_GET['r'],'summary_v2.php','R');
$pre_week = getFullURL($_GET['r'],'Previous_week_V2.php','N');
?>
<form method="post" name="input" action="<?php echo $url;?>">
<center><a href="summary_v2.php&weekno=<?php echo $weeknumber; ?>" onclick="return popitup('<?php echo $summary;?>?weekno=<?php echo $weeknumber; ?>')">Summary</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="<?php echo $pre_week;?>">Previous Week</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="<?php echo $current_week; ?>">Current Week</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="<?php echo $next_week;?>">Next Week</a>&nbsp;&nbsp;|&nbsp;&nbsp; </center>
<div class='row'>
	<div class='col-md-4'>
				
				<?php 
					// $sqly="select distinct(buyer_div) from plan_modules";
					$sqly = "SELECT GROUP_CONCAT(buyer_name) as buyer_name,buyer_code AS buyer_div FROM $bai_pro2.buyer_codes GROUP BY BUYER_CODE ORDER BY buyer_code";
					$sql_resulty=mysqli_query($link, $sqly) or exit("Sql Error 2".mysqli_error($GLOBALS["___mysqli_ston"]));
				?>
				<label> Buyer Division : </label>
				<select name="division" id="division" class="form-control" onchange="redirect_view()">
					<option value=\"ALL\" selected >ALL</option>
					<?php
						while($sql_rowy=mysqli_fetch_array($sql_resulty))
						{
							$buyer_div=$sql_rowy['buyer_div'];
							$buyer_name=$sql_rowy['buyer_name'];
							// echo $_GET["division"];
							if($_GET["division"] == $buyer_name) 
							{
								echo "<option value=\"".$buyer_name."\" selected>".$buyer_div."</option>";  
							} 
							else 
							{
								echo "<option value=\"".$buyer_name."\" >".$buyer_div."</option>"; 
							}
						}
						echo '</select>';
						
						if($_GET["division"]!='ALL' && $_GET["division"]!='')
						{
							//echo "Buyer=".urldecode($_GET["view_div"])."<br>";
							$buyer_division=urldecode($_GET["division"]);
							//echo '"'.str_replace(",",'","',$buyer_division).'"'."<br>";
							$buyer_division_ref='"'.str_replace(",",'","',$buyer_division).'"';
							$order_div_ref="and order_div in (".$buyer_division_ref.")";
						}
						else 
						{
							 $order_div_ref='';
						} ?>
	</div>

						<?php
						//echo '<input type="checkbox" name="option"  id="option" onclick="javascript:enableButton();">Enable &nbsp&nbsp';
						echo "<input type=\"submit\" name=\"submitx\" value=\"Show\" style='margin-top:22px;' class='btn btn-primary' onclick=\"javascript:button_disable();\">";
						?>

</div>

<?php
// '<div id="process_message"><h4><font color="red">Please wait while updating data!!!</font></h4></div>';
?>
</form>


<?php

if(isset($_POST['submitx']) or isset($_GET['division']))
{

if(isset($_GET['division']))
{
	$division=$_GET['division'];
}
else
{
	$division=$_POST['division'];
}
// $start_date = '2017-12-06';
// $end_date = '2018-01-10';
//$pending=$_POST['pending'];
//$query1="where ex_factory_date_new between \"".trim($start_date)."\" and  \"".trim($end_date)."\" and (schedule_no!=\"NULL\" and schedule_no > 0) order by left(style,1)";
//$query="where ex_factory_date_new between \"".trim($start_date)."\" and  \"".trim($end_date)."\" and (schedule_no!=\"NULL\" and schedule_no > 0) order by left(style,1)";
$query1="where ex_factory_date_new between \"".trim($start_date)."\" and  \"".trim($end_date)."\" order by left(style,1)";
$query="where ex_factory_date_new between \"".trim($start_date)."\" and  \"".trim($end_date)."\"  order by left(style,1)";

if($division!="All")
{
	//$query="where MID(buyer_division,1, 2)=\"$division\" and ex_factory_date_new between \"".trim($start_date)."\" and  \"".trim($end_date)."\" and (schedule_no!=\"NULL\" and schedule_no > 0)   order by left(style,1)";
	$query="where buyer_division =\"$division\" and ex_factory_date_new between \"".trim($start_date)."\" and  \"".trim($end_date)."\" order by left(style,1)";
}
//echo $query;
//include("current_week_excel.php");
$sHTML_Header="<html><head><title>Out Of Ratio Report</title></head><body>";
$sHTML_Content="";
/*if($username == "amulyap" or $username=="kirang" or $username=="rajasekhark" or $username=="muralip")
{
	echo"<form action=\"current_week.php\" method=\"POST\">";
	echo"<table><tr><th>Status</th><td><select name=\"sta\">";
	echo"<option></option>";
	if($username =="muralip")
	{
		echo"<option>Offered</option>";
		//echo "<option>M3 Reported</option>";
	}
	if($username == "kirang" or $username =="amulyap" or $username=="rajasekhark")
	{
		echo"<option>Offered</option>";
		echo"<option>M3 Reported</option>";
	}
	
	echo"</select></td>";
	echo"</tr></tr><th>Schedule</th><td><input type=\"text\" name=\"dels\" value=\"\" /></td></tr></table>";	
	echo"<input type=\"submit\" name=\"submit2\" value=\"Update\" />";
	echo"</form>";	
}*/

include("header.php");

//echo $start_date."-".$end_date;

//echo "<form action=\"dashboard.php\" method=\"POST\">";
//echo "<input align=\"right\" type=\"submit\" name=\"submit\" value=\"Backup\" />";
/*$sqla="SELECT COUNT(STATUS) as cou,status as sta FROM weekly_delivery_status_finishing where ex_fact between \"".trim($start_date)."\" and  \"".trim($end_date)."\" GROUP BY status";
//echo $sql;
$resulta=mysqli_query($sqla,$link) or die("Error = ".mysqli_error());
echo "<table><tr>";
while($rowa=mysqli_fetch_array($resulta))
{	
	echo "<td bgcolor=\"$id\">".$rowa["sta"]."</td>";
	echo "<th>".$rowa["cou"]."</th>";		
}
echo "</tr></table><br/><br/><br/>";*/

$sHTML_Content.="<div class='table-responsive'><table id=\"table1\" border=\"1\" cellspacing=\"0\" cellpadding=\"1\" class=\"table table-bordered\">";
//$sHTML_Content.= "<tr><th bgcolor=\"#002060\" style=\"color:#ffffff\">Sno</th><th bgcolor=\"#002060\" style=\"color:#ffffff\">Buyer Division</th><th bgcolor=\"#002060\" style=\"color:#ffffff\">Customer Order No</th><th bgcolor=\"#002060\" style=\"color:#ffffff\">MPO</th><th bgcolor=\"#002060\" style=\"color:#ffffff\">CPO</th><th bgcolor=\"#002060\" style=\"color:#ffffff\">Style</th><th bgcolor=\"#002060\" style=\"color:#ffffff\">Schedule</th><th bgcolor=\"#002060\" style=\"color:#ffffff\">Color</th><th bgcolor=\"#002060\" style=\"color:#ffffff\">Sections</th><th bgcolor=\"#002060\" style=\"color:#ffffff\">Order<br>Quantity</th><th bgcolor=\"#002060\" style=\"color:#ffffff\">Input</th><th bgcolor=\"#002060\" style=\"color:#ffffff\">Output</th><th bgcolor=\"#002060\" style=\"color:#ffffff\">FG</th><th bgcolor=\"#002060\" style=\"color:#ffffff\">FCA</th><th bgcolor=\"#002060\" style=\"color:#ffffff\">Production Status</th><th bgcolor=\"#002060\" style=\"color:#ffffff\">EX-FactoryDate</th><th bgcolor=\"#002060\" style=\"color:#ffffff\">Planing<br>Remarks</th><th bgcolor=\"#002060\" style=\"color:#ffffff\">LogTime Of Each Status</th></tr>";

$sHTML_Content.= "<tr><th bgcolor=\"#002060\" style=\"color:#ffffff\">Sno</th><th bgcolor=\"#002060\" style=\"color:#ffffff\">Buyer Division</th><th bgcolor=\"#002060\" style=\"color:#ffffff\">Customer Order No</th><th bgcolor=\"#002060\" style=\"color:#ffffff\">MPO</th><th bgcolor=\"#002060\" style=\"color:#ffffff\">CPO</th><th bgcolor=\"#002060\" style=\"color:#ffffff\">Style</th><th bgcolor=\"#002060\" style=\"color:#ffffff\">Schedule NO</th><th bgcolor=\"#002060\" style=\"color:#ffffff\">Color</th><th bgcolor=\"#002060\" style=\"color:#ffffff\">Sections</th><th bgcolor=\"#002060\" style=\"color:#ffffff\">Order<br>Quantity</th><th bgcolor=\"#002060\" style=\"color:#ffffff\">Cut Quantity</th><th bgcolor=\"#002060\" style=\"color:#ffffff\">Input</th><th bgcolor=\"#002060\" style=\"color:#ffffff\">Output</th><th bgcolor=\"#002060\" style=\"color:#ffffff\">FG</th><th bgcolor=\"#002060\" style=\"color:#ffffff\">FCA</th>";

//echo "<th bgcolor=\"#002060\" style=\"color:#ffffff\">Production Status</th>"; 
$sHTML_Content.="<th bgcolor=\"#002060\" style=\"color:#ffffff\">Low Status</th><th bgcolor=\"#002060\" style=\"color:#ffffff\">High Status</th><th bgcolor=\"#002060\" style=\"color:#ffffff\">EX-FactoryDate</th><th bgcolor=\"#002060\" style=\"color:#ffffff\">Planing<br>Remarks</th><th bgcolor=\"#002060\" style=\"color:#ffffff\">Offered Time</th><th bgcolor=\"#002060\" style=\"color:#ffffff\">FCA Time</th><th bgcolor=\"#002060\" style=\"color:#ffffff\">Dispatch Time</th></tr>";


$x=0;
$sqly="select ref_id from $bai_pro4.week_delivery_plan_ref $query1";
//echo $sqly;
$resulty=mysqli_query($link,$sqly) or die("Error = No Details found!!!".mysqli_error());
$sql_num_check=mysqli_num_rows($resulty);
if($sql_num_check <= 0)
{
	// echo "<hr><div class='alert alert-danger' role='alert'>No Details Found!!!</div>";
	// exit();
}
else
{
	while($rowy=mysqli_fetch_array($resulty))
	{
		$ref_id_ver[]=$rowy["ref_id"];
	}
	$sqlz="delete from $bai_pro4.weekly_delivery_status_finishing where tid not in (".implode(",",$ref_id_ver).") and ex_fact between \"".trim($start_date)."\" and  \"".trim($end_date)."\"";
	mysqli_query($link,$sqlz) or die("Error = ".mysqli_error());
}
//$sql="select ref_id,ship_tid,style,color,schedule_no,buyer_division,ex_factory_date_new from week_delivery_plan_ref where ex_factory_date_new between \"".trim($start_date)."\" and \"".trim($end_date)."\" order by ex_factory_date_new ";
$sql="select ref_id,ship_tid,style,color,schedule_no,buyer_division,ex_factory_date_new from $bai_pro4.week_delivery_plan_ref $query ";
// echo $sql;
$result=mysqli_query($link,$sql) or die("Error = ".mysqli_error());
$sql_num_check_result=mysqli_num_rows($result);
if($sql_num_check_result <= 0)
{
	echo "<hr><div class='alert alert-danger' role='alert'>No Details Found!!!</div>";
	exit();
}
else
{
	while($row=mysqli_fetch_array($result))
	{
		$mods="";
		$mods1="";
		$x=$x+1;
		$ref_id=$row["ref_id"];
		$ship_tid=$row["ship_tid"];
		$style=$row["style"];
		$schedule=$row["schedule_no"];
		$color=$row["color"];
		$buyer_division=$row["buyer_division"];
		$ex_factory_date_new=$row["ex_factory_date_new"];
		$sql1="select remarks from week_delivery_plan where ref_id=\"".$ref_id."\"";
		$result1=mysqli_query($link,$sql1) or die("Error = ".mysqli_error());
		while($row1=mysqli_fetch_array($result1))
		{
			$remarks=$row1["remarks"];
		}
		
		$remarks_explode=explode("^",$remarks);
		$planing_remarks="";
		if(sizeof($remarks_explode) > 0)
		{
			$planing_remarks=$remarks_explode[0];
		}
		$id="#ffffff";
		if(strtolower($planing_remarks) == "hold")
		{
			$id="#fd0d2b";
		}
		if(strtolower($planing_remarks) == "short")
		{
			$id="#FFFF00";
		}
		if($planing_remarks == "$")
		{
			$id="#008000";
		}
		
		$sql_co="select order_no,mpo,cpo from $bai_pro3.shipment_plan where schedule_no=\"".$schedule."\" and color=\"".$color."\"";
		$result_co=mysqli_query($link,$sql_co) or die("Error =".mysqli_error());
		while($row_co=mysqli_fetch_array($result_co))
		{
			$order_no=$row_co["order_no"];
			$co=$row_co["cpo"];
			$mo=$row_co["mpo"];
		}
		
		/*$sHTML_Content .="<tr>";
		$sHTML_Content .="<td bgcolor=\"$id\"><a href=\"status_update.php?tid=$ref_id&&schedule=$schedule\" onclick=\"return popitup('status_update.php?tid=$ref_id&&schedule=$schedule')\">".$x."</a><input type=\"hidden\" name=\"rtid[]\" value=\"".$ref_id."\" /><input type=\"hidden\" name=\"tid[]\" value=\"".$ship_tid."\" /></td>";
		$sHTML_Content .="<td bgcolor=\"$id\">".$buyer_division."</td>";
		$sHTML_Content .="<td bgcolor=\"$id\">".$order_no."</td>";
		$sHTML_Content .="<td bgcolor=\"$id\">".$mo."</td>";
		$sHTML_Content .="<td bgcolor=\"$id\">".$co."</td>";
		$sHTML_Content .="<td bgcolor=\"$id\">".$style."</td>";
		$sHTML_Content .="<td bgcolor=\"$id\">".$schedule."<input type=\"hidden\" name=\"sche[]\" value=\"".$schedule."\" /></td>";
		$sHTML_Content .="<td bgcolor=\"$id\">".$color."<input type=\"hidden\" name=\"col[]\" value=\"".$color."\" /></td>";*/
		
		$table_name="bai_orders_db";
		$sqly="select * from $bai_pro3.bai_orders_db_confirm where order_style_no=\"".$style."\" and order_del_no=\"".$schedule."\" and order_col_des=\"".$color."\" order by order_div,order_del_no desc";
		$sql_resulty=mysqli_query($link,$sqly) or exit("Sql Error =".mysqli_error());
		$rows=mysqli_num_rows($sql_resulty);	
		if($rows > 0)
		{
			$table_name="bai_orders_db_confirm";
		}
		$sql="select * from $bai_pro3.$table_name where order_style_no=\"".$style."\" and order_del_no=\"".$schedule."\" and order_col_des=\"".$color."\" order by order_div,order_del_no desc";
		$sql_result=mysqli_query($link,$sql) or exit("Sql Error =".mysqli_error());
		while($sql_row=mysqli_fetch_array($sql_result))
		{
			$order_total_qty=$sql_row["order_s_xs"]+$sql_row["order_s_s"]+$sql_row["order_s_m"]+$sql_row["order_s_l"]+$sql_row["order_s_xl"]+$sql_row["order_s_xxl"]+$sql_row["order_s_xxxl"]+$sql_row["order_s_s01"]+$sql_row["order_s_s02"]+$sql_row["order_s_s03"]+$sql_row["order_s_s04"]+$sql_row["order_s_s05"]+$sql_row["order_s_s06"]+$sql_row["order_s_s07"]+$sql_row["order_s_s08"]+$sql_row["order_s_s09"]+$sql_row["order_s_s10"]+$sql_row["order_s_s11"]+$sql_row["order_s_s12"]+$sql_row["order_s_s13"]+$sql_row["order_s_s14"]+$sql_row["order_s_s15"]+$sql_row["order_s_s16"]+$sql_row["order_s_s17"]+$sql_row["order_s_s18"]+$sql_row["order_s_s19"]+$sql_row["order_s_s20"]+$sql_row["order_s_s21"]+$sql_row["order_s_s22"]+$sql_row["order_s_s23"]+$sql_row["order_s_s24"]+$sql_row["order_s_s25"]+$sql_row["order_s_s26"]+$sql_row["order_s_s27"]+$sql_row["order_s_s28"]+$sql_row["order_s_s29"]+$sql_row["order_s_s30"]+$sql_row["order_s_s31"]+$sql_row["order_s_s32"]+$sql_row["order_s_s33"]+$sql_row["order_s_s34"]+$sql_row["order_s_s35"]+$sql_row["order_s_s36"]+$sql_row["order_s_s37"]+$sql_row["order_s_s38"]+$sql_row["order_s_s39"]+$sql_row["order_s_s40"]+$sql_row["order_s_s41"]+$sql_row["order_s_s42"]+$sql_row["order_s_s43"]+$sql_row["order_s_s44"]+$sql_row["order_s_s45"]+$sql_row["order_s_s46"]+$sql_row["order_s_s47"]+$sql_row["order_s_s48"]+$sql_row["order_s_s49"]+$sql_row["order_s_s50"];
			$emb_count=$sql_row["order_embl_a"]+$sql_row["order_embl_b"]+$sql_row["order_embl_c"]+$sql_row["order_embl_d"]+$sql_row["order_embl_e"]+$sql_row["order_embl_f"]+$sql_row["order_embl_g"]+$sql_row["order_embl_h"];
		}
		
		$sql_cat="select tid from $bai_pro3.cat_stat_log where order_tid like \"% ".$schedule."".$color."%\" and category in ($in_categories)";
		//echo $sql_cat."<br>";
		$sql_result_cat=mysqli_query($link,$sql_cat) or exit("Sql Error3=".mysqli_error());
		$rows_cat=mysqli_num_rows($sql_result_cat);
		if($rows_cat > 0)
		{
			while($sql_row_cat=mysqli_fetch_array($sql_result_cat))
			{
				$cat_ref=$sql_row_cat["tid"];
			}
		}
		else
		{
			$cat_ref=0;
		}

		$sqlxs="select * from $bai_pro3.plandoc_stat_log where cat_ref=$cat_ref and order_tid like \"% ".$schedule."".$color."%\"";	
		//echo $sqlxs."<br>";
		$sql_resultxs=mysqli_query($link,$sqlxs) or exit("Sql Error =".mysqli_error());
		$rowsx2s=mysqli_num_rows($sql_resultxs);
		if($rowsx2s > 0)
		{
			$sqlx="select * from $bai_pro3.plandoc_stat_log where cat_ref=$cat_ref and order_tid like \"% ".$schedule."".$color."%\" and fabric_status=5";	
			//echo $sqlx."<br>";
			$sql_resultx=mysqli_query($link,$sqlx) or exit("Sql Error =".mysqli_error());
			$rowsx2=mysqli_num_rows($sql_resultx);
		}
		else
		{
			$rowsx2=0;
		}
		
		$sqla="SELECT SUM(p_xs+p_s+p_m+p_l+p_xl+p_xxl+p_xxxl+p_s01+p_s02+p_s03+p_s04+p_s05+p_s06+p_s07+p_s08+p_s09+p_s10+p_s11+p_s12+p_s13+p_s14+p_s15+p_s16+p_s17+p_s18+p_s19+p_s20+p_s21+p_s22+p_s23+p_s24+p_s25+p_s26+p_s27+p_s28+p_s29+p_s30+p_s31+p_s32+p_s33+p_s34+p_s35+p_s36+p_s37+p_s38+p_s39+p_s40+p_s41+p_s42+p_s43+p_s44+p_s45+p_s46+p_s47+p_s48+p_s49+p_s50)*p_plies AS doc_qty,doc_no FROM $bai_pro3.plandoc_stat_log WHERE order_tid like \"% $schedule$color%\" and cat_ref=\"$cat_ref\" and act_cut_status=\"DONE\" GROUP BY doc_no";
		//echo $sql."<br>";
		$resulta=mysqli_query($link,$sqla) or exit("Sql Error1".mysqli_error());
		while($rowa=mysqli_fetch_array($resulta))
		{
			$cut_total_qty=$cut_total_qty+$rowa["doc_qty"];
		}
		
		/*if($cut_total_qty > 0)
		{
			if($emb_count > 0)
			{
				$cut_total_qty=$cut_total_qty-(round(($cut_total_qty*2/100),0));
			}
			else
			{
				$cut_total_qty=$cut_total_qty-(round(($cut_total_qty*1/100),0));
			}
		}*/
		
		$low_status="NIL";
		$high_status="NIL";
		
		//echo $sqlxs."-".$rowsx2."<br>";
		/*while($sql_rowxx=mysqli_fetch_array($sql_resultx))
		{
			$fab5_sta=$sql_rowxx["cunt"];
		}	
		/*while($sql_row=mysqli_fetch_array($sql_result))
		{
			$cut_total_qty=$sql_row["cuttable_s_xs"]+$sql_row["cuttable_s_s"]+$sql_row["cuttable_s_m"]+$sql_row["cuttable_s_l"]+$sql_row["cuttable_s_xl"]+$sql_row["cuttable_s_xxl"]+$sql_row["cuttable_s_xxxl"]+$sql_row["cuttable_s_s06"]+$sql_row["cuttable_s_s08"]+$sql_row["cuttable_s_s10"]+$sql_row["cuttable_s_s12"]+$sql_row["cuttable_s_s14"]+$sql_row["cuttable_s_s16"]+$sql_row["cuttable_s_s18"]+$sql_row["cuttable_s_s20"]+$sql_row["cuttable_s_s22"]+$sql_row["cuttable_s_s24"]+$sql_row["cuttable_s_s26"]+$sql_row["cuttable_s_s28"]+$sql_row["cuttable_s_s30"];
		}	*/
		
		$sql2x="SELECT GROUP_CONCAT(DISTINCT bac_sec SEPARATOR '#') as mods FROM $bai_pro.bai_log_buf WHERE delivery=\"".$schedule."\" AND color=\"".$color."\" order by bac_no+0";
		$sql_result2x=mysqli_query($link,$sql2x) or exit("Sql Error =".mysqli_error());
		while($sql_row2x=mysqli_fetch_array($sql_result2x))
		{
			$mods=$sql_row2x["mods"];
		}
		
		/*$sql2x="SELECT GROUP_CONCAT(DISTINCT ims_mod_no) as mods FROM bai_pro3.ims_log_backup WHERE ims_schedule=\"".$schedule."\" AND ims_color=\"".$color."\" AND ims_mod_no > 0";	$sql_result2x=mysqli_query($sql2x,$link) or exit("Sql Error =".mysqli_error());
		while($sql_row2x=mysqli_fetch_array($sql_result2x))
		{
			$mods1=$sql_row2x["mods"];
		}*/
		
		$sql2x="select sum(ims_qty) as qty from $bai_pro3.ims_log where ims_schedule=\"".$schedule."\" and ims_color=\"".$color."\" and ims_cid=$cat_ref and ims_mod_no > 0";
		$sql_result2x=mysqli_query($link,$sql2x) or exit("Sql Error =".mysqli_error());
		while($sql_row2x=mysqli_fetch_array($sql_result2x))
		{
			$input_total_qty=$sql_row2x["qty"];
		}
		
		$sql2xx="select sum(ims_qty) as qty from $bai_pro3.ims_log_backup where ims_schedule=\"".$schedule."\" and ims_color=\"".$color."\" and ims_cid=$cat_ref and ims_mod_no > 0";
		$sql_result2xx=mysqli_query($link,$sql2xx) or exit("Sql Error =".mysqli_error());
		while($sql_row2xx=mysqli_fetch_array($sql_result2xx))
		{
			$input_total_qtyx=$sql_row2xx["qty"];
		}
		
		$sql2x1="select sum(ims_pro_qty) as qty from $bai_pro3.ims_log where ims_schedule=\"".$schedule."\" and ims_color=\"".$color."\" and ims_cid=$cat_ref and ims_mod_no > 0";
		$sql_result2x1=mysqli_query($link,$sql2x1) or exit("Sql Error =".mysqli_error());
		while($sql_row2x1=mysqli_fetch_array($sql_result2x1))
		{
			$output_total_qty=$sql_row2x1["qty"];
		}
		
		$sql2xx1="select sum(ims_pro_qty) as qty from $bai_pro3.ims_log_backup where ims_schedule=\"".$schedule."\" and ims_color=\"".$color."\" and ims_cid=$cat_ref and ims_mod_no > 0";
		$sql_result2xx1=mysqli_query($link,$sql2xx1) or exit("Sql Error =".mysqli_error());
		while($sql_row2xx1=mysqli_fetch_array($sql_result2xx1))
		{
			$output_total_qtyx=$sql_row2xx1["qty"];
		}
		
		
		$sql2xy="select sum(ims_qty) as qty from $bai_pro3.ims_log where ims_schedule=\"".$schedule."\" and ims_color=\"".$color."\" and ims_cid=$cat_ref and ims_mod_no = 0";
		$sql_result2xy=mysqli_query($link,$sql2xy) or exit("Sql Error =".mysqli_error());
		while($sql_row2xy=mysqli_fetch_array($sql_result2xy))
		{
			$zero_total_qty=$sql_row2xy["qty"];
		}
		
		$sql2xxy="select sum(ims_qty) as qty from $bai_pro3.ims_log_backup where ims_schedule=\"".$schedule."\" and ims_color=\"".$color."\" and ims_cid=$cat_ref and ims_mod_no = 0";
		$sql_result2xxy=mysqli_query($link,$sql2xxy) or exit("Sql Error =".mysqli_error());
		while($sql_row2xxy=mysqli_fetch_array($sql_result2xxy))
		{
			$zero_total_qtyx=$sql_row2xxy["qty"];
		}
		
		$cut_total_qty=$cut_total_qty-$zero_total_qty-$zero_total_qtyx;
		
		/*$sql2="select sum(bac_qty) as qty from bai_pro.bai_log_buf where delivery=\"".$schedule."\" and color=\"".$color."\"";
		$sql_result2=mysqli_query($sql2,$link) or exit("Sql Error =".mysqli_error());
		while($sql_row2=mysqli_fetch_array($sql_result2))
		{
			$output_total_qty=$sql_row2["qty"];
		}*/
		
		$sql3="select sum(carton_act_qty) as scan from $bai_pro3.packing_summary where order_del_no=\"".$schedule."\" and order_col_des=\"".$color."\" and (status=\"DONE\" or disp_id=1)";
		$sql_result3=mysqli_query($link,$sql3) or exit("Sql Error =".mysqli_error());
		while($sql_row3=mysqli_fetch_array($sql_result3))
		{
			$scan_total_qty=$sql_row3["scan"];
		}
		
		$sql4="select sum(pcs) as pcs,max(lastup) as fcatime from $bai_pro3.fca_audit_fail_db where schedule=\"".$schedule."\" and tran_type=\"1\"";
		$sql_result4=mysqli_query($link,$sql4) or exit("Sql Error =".mysqli_error());
		while($sql_row4=mysqli_fetch_array($sql_result4))
		{
			$fca_total_qty=$sql_row4["pcs"];
			$fca_time=$sql_row4["fcatime"];
		}
		
		$sql4z="select sum(pcs) as pcs from $bai_pro3.fca_audit_fail_db where schedule=\"".$schedule."\" and tran_type=\"2\"";
		$sql_result4z=mysqli_query($link,$sql4z) or exit("Sql Error =".mysqli_error());
		while($sql_row4z=mysqli_fetch_array($sql_result4z))
		{
			$fca_fail_total_qty=$sql_row4z["pcs"];
		}
		
		$sqlx="select * from $bai_pro4.weekly_delivery_status_finishing where tid=\"".$ref_id."\"";	
		$resultx=mysqli_query($link,$sqlx) or die("Error = ".mysqli_error());
		$rowsx=mysqli_num_rows($resultx);	
		while($sql_rowx=mysqli_fetch_array($resultx))
		{
			$status_rep=$sql_rowx["status"];
			$offered_status=$sql_rowx["offered_status"];
			$dispatch_status=$sql_rowx["dispatch_status"];
		}
		
		if($status_rep == "Shipped")
		{
			$sql4zx="select sum(pcs) as pcs from $bai_pro3.fca_audit_fail_db where schedule=\"".$schedule."\" and tran_type=\"1\" and date(lastup) between \"".trim($start_date)."\" and  \"".trim($end_date)."\"";
			//echo $sql4zx."<br>";
			$sql_result4zx=mysqli_query($link,$sql4zx) or exit("Sql Error =".mysqli_error());
			while($sql_row4zx=mysqli_fetch_array($sql_result4zx))
			{
				$fca_pass_total_qty=$sql_row4zx["pcs"];
				if($fca_pass_total_qty == "")
				{
					//echo $schedule."^0<br>";
				}
				else
				{
					//echo $schedule."^".$fca_pass_total_qty."<br>";
				}			
			}
			
			$sql4zy="select sum(carton_act_qty) as qty from $bai_pro3.packing_summary where order_del_no=\"".$schedule."\" and status=\"DONE\" and date(lastup) between \"".trim($start_date)."\" and  \"".trim($end_date)."\"";
			$sql_result4zy=mysqli_query($link,$sql4zy) or exit("Sql Error =".mysqli_error());
			while($sql_row4zy=mysqli_fetch_array($sql_result4zy))
			{
				$scan_qty_week=$sql_row4zy["qty"];
			}
			
			//echo $scan_qty_week."^".$fca_pass_total_qty."^".$schedule."<br>";
		}
		
		$sql4zz="select sum(pcs) as pcs from $bai_pro3.fca_audit_fail_db where schedule=\"".$schedule."\" and tran_type=\"1\" and date(lastup)=\"".date("Y-m-d")."\"";
		//echo $sql4zz."<br>";
		$sql_result4zz=mysqli_query($link,$sql4zz) or exit("Sql Error =".mysqli_error());
		while($sql_row4zz=mysqli_fetch_array($sql_result4zz))
		{
			$fca_pass_total_qty_today=$sql_row4zz["pcs"];
			if($fca_pass_total_qty_today == "")
			{
				//echo $schedule."^0<br>";
				$fca_pass_total_qty_today=0;
			}
			else
			{
				//echo $schedule."^".$fca_pass_total_qty."<br>";
				$fca_pass_total_qty_today=$fca_pass_total_qty_today;
			}			
		}

		//echo $sqlx."-".$schedule."-".$status_rep."<br>";
		
		//$sHTML_Content .="<td bgcolor=\"$id\">s=".$status_rep."</td>";		
			
		
		if($rowsx2 == 0)
		{
			$status="RM";
			if($status_rep =="FG*")
			{
				$status="FG*";
			}		
		}
		else
		{
			$status="Cutting";
			if($status_rep =="FG*")
			{
				$status="FG*";
			}
			if(($input_total_qty+$input_total_qtyx) > 0)
			{
				$status="Sewing";
				/*if($order_total_qty != ($input_total_qty+$input_total_qtyx) )
				{
					$status="Input";
				}*/
				
				/*if($cut_total_qty >= $order_total_qty && ($input_total_qty+$input_total_qtyx) > $)
				{
					
				}*/
				
				if(($output_total_qty+$output_total_qtyx) > 0)
				{
					$status="Sewing";
					if($scan_total_qty == ($output_total_qty+$output_total_qtyx) && $order_total_qty == $scan_total_qty)
					{
						$status="FG";
					}
					if($scan_total_qty == ($output_total_qty+$output_total_qtyx) && $order_total_qty != $scan_total_qty)
					{
						$status="Sewing";
					}
					
					if(($output_total_qty+$output_total_qtyx) > 0)
					{
						$status="Packing";
					}
					
					if(($output_total_qty+$output_total_qtyx) == ($order_total_qty) && ($output_total_qty+$output_total_qtyx) != $scan_total_qty)
					{
						$status="Packing";
					}
					if($scan_total_qty > 0)
					{
						$status="FG";
						//if(($output_total_qty+$output_total_qtyx) < $scan_total_qty)
						if($order_total_qty == $scan_total_qty && $scan_total_qty!= ($output_total_qty+$output_total_qtyx))
						{
							$status="FG*";						
						}
					}
					if($fca_total_qty > 0)
					{
						$status="FCA";
						if($order_total_qty > $fca_total_qty)
						{
							$status="FCA/P";
						}
						
						if($fca_fail_total_qty < 0)
						{
							$status="FCA Fail";
						}
						
						if($fca_total_qty == $order_total_qty)
						{
							$status="FCA";
						}
						
						if($status_rep == "FG*")
						{
							if($fca_pass_total_qty > 0 && $scan_qty_week > 0)
							{
								$status=="Offered";
								//echo "Hello1";
							}
						}
						
					}
					
					
				}
				if($order_total_qty == $scan_total_qty)
				{
					$status="FG";
					//if(($output_total_qty+$output_total_qtyx) < $scan_total_qty)
					if($order_total_qty == $scan_total_qty && $scan_total_qty!= ($output_total_qty+$output_total_qtyx))
					{
						$status="FG*";
					}
				}
				if($fca_fail_total_qty < 0)
				{
					$status="FCA Fail";
				}
				if($fca_total_qty > 0)
				{
					$status="FCA";
					if($order_total_qty > $fca_total_qty)
					{
						$status="FCA/P";
					}
					
					if($fca_fail_total_qty < 0)
					{
						$status="FCA Fail";
					}
					
					if($fca_total_qty == $order_total_qty)
					{
						$status="FCA";
					}
					
					if($status_rep == "FG*")
					{
						if($fca_pass_total_qty > 0 && $scan_qty_week > 0)
						{
							$status=="Offered";
							//echo "Hello2";
						}
					}			
					
				}
				
			}			
		}		
		
		if($status_rep == "Offered")
		{
			$status="Offered";
			if($fca_fail_total_qty < 0)
			{
				$status="FCA Fail";
			}
			if($fca_total_qty > 0)
			{
				$status="FCA";
							
				if($fca_pass_total_qty > 0 && $scan_qty_week > 0)
				{
					$status="Offered";
					if($fca_fail_total_qty < 0)
					{
						$status="FCA Fail";
					}
					if($fca_pass_total_qty_today > 0)
					{
						$status="FCA";
						if($order_total_qty > $fca_total_qty)
						{
							$status="FCA/P";
						}
					}
					//echo "Hello3";
				}
				//2016-09-09 / kirang / Service Request#98739857 : FCA Status Not Turned After FCA  
				if($order_total_qty > $fca_total_qty)
				{
					$status="FCA/P";
				}
				
				if($fca_fail_total_qty < 0)
				{
					$status="FCA Fail";
				}
				
				if($fca_total_qty == $order_total_qty)
				{
					$status="FCA";
				}
			}
			
			//if($)
		}
		if($status_rep == "M3 Reported")
		{
			$status="M3 Reported";
		}	
		if($status_rep == "Shipped")
		{
			$status="Shipped";
		}
		
		if($status_rep =="FG*")
		{
			$status="FG*";
			if($scan_total_qty!= ($output_total_qty+$output_total_qtyx))
			{
				$status="FG";
			}
		}
		
		if($rowsx2 == $rowsx2s && $rowsx2s > 0)
		{
			if($cut_total_qty >= $order_total_qty)
			{
				if(($cut_total_qty == ($input_total_qty+$input_total_qtyx)) && $cut_total_qty > 0)
				{
					if(($input_total_qty+$input_total_qtyx) == ($output_total_qty+$output_total_qtyx))
					{
						
						if(($output_total_qty+$output_total_qtyx)==$scan_total_qty && ($input_total_qty+$input_total_qtyx) == $cut_total_qty && ($output_total_qty+$output_total_qtyx) > 0)
						{
							
							if($scan_total_qty==$cut_total_qty)
							{
								$low_status="FG";
								if($status_rep == "Offered")
								{
									$low_status="Offered";
								}
								if($fca_total_qty > 0)
								{
									if($fca_total_qty >= $cut_total_qty)
									{
										$low_status="FCA";
										if($status_rep == "Offered")
										{
											$low_status="Offered";
										}
										if($status_rep == "M3 Reported")
										{
											$low_status="M3 Reported";
										}
										if($status_rep == "Shipped")
										{
											$low_status="Shipped";
										}
									}
									else
									{
										$low_status="FCA/P";
									}
								}
								
							}
							else
							{
								$low_status="FG";
							}
						}
						else
						{
							$low_status="Packing";
						}
					}
					else
					{
						$low_status="Sewing";
					}
				}
				else
				{
					$low_status="Cutting";
					//$low_status="Input";
				}
			}
			else
			{
				$low_status="Cutting";
			}	
		}
		else
		{
			$low_status="RM";
		}
		
		
		
		$sql4="SELECT SUM(ship_s_xs),SUM(ship_s_s),SUM(ship_s_m),SUM(ship_s_l),SUM(ship_s_xl),SUM(ship_s_xxl),SUM(ship_s_xxxl),SUM(ship_s_s01),SUM(ship_s_s02),SUM(ship_s_s03),SUM(ship_s_s04),SUM(ship_s_s05),SUM(ship_s_s06),SUM(ship_s_s07),SUM(ship_s_s08),SUM(ship_s_s09),SUM(ship_s_s10),SUM(ship_s_s11),SUM(ship_s_s12),SUM(ship_s_s13),SUM(ship_s_s14),SUM(ship_s_s15),SUM(ship_s_s16),SUM(ship_s_s17),SUM(ship_s_s18),SUM(ship_s_s19),SUM(ship_s_s20),SUM(ship_s_s21),SUM(ship_s_s22),SUM(ship_s_s23),SUM(ship_s_s24),SUM(ship_s_s25),SUM(ship_s_s26),SUM(ship_s_s27),SUM(ship_s_s28),SUM(ship_s_s29),SUM(ship_s_s30),SUM(ship_s_s31),SUM(ship_s_s32),SUM(ship_s_s33),SUM(ship_s_s34),SUM(ship_s_s35),SUM(ship_s_s36),SUM(ship_s_s37),SUM(ship_s_s38),SUM(ship_s_s39),SUM(ship_s_s40),SUM(ship_s_s41),SUM(ship_s_s42),SUM(ship_s_s43),SUM(ship_s_s44),SUM(ship_s_s45),SUM(ship_s_s46),SUM(ship_s_s47),SUM(ship_s_s48),SUM(ship_s_s49),SUM(ship_s_s50) FROM $bai_pro3.ship_stat_log WHERE ship_schedule=\"".$schedule."\" and ship_status=\"2\"";
		//echo $sql4;
		$sql_result4=mysqli_query($link,$sql4) or exit("Sql Error".mysqli_error());
		$total_rows=mysqli_num_rows($sql_result4);
		while($sql_row4=mysqli_fetch_array($sql_result4))
		{
			$ship_total=$sql_row4["SUM(ship_s_xs)"]+$sql_row4["SUM(ship_s_s)"]+$sql_row4["SUM(ship_s_m)"]+$sql_row4["SUM(ship_s_l)"]+$sql_row4["SUM(ship_s_xl)"]+$sql_row4["SUM(ship_s_xxl)"]+$sql_row4["SUM(ship_s_xxxl)"]+$sql_row4["sum(ship_s_s01)"]+$sql_row4["sum(ship_s_s02)"]+$sql_row4["sum(ship_s_s03)"]+$sql_row4["sum(ship_s_s04)"]+$sql_row4["sum(ship_s_s05)"]+$sql_row4["sum(ship_s_s06)"]+$sql_row4["sum(ship_s_s07)"]+$sql_row4["sum(ship_s_s08)"]+$sql_row4["sum(ship_s_s09)"]+$sql_row4["sum(ship_s_s10)"]+$sql_row4["sum(ship_s_s11)"]+$sql_row4["sum(ship_s_s12)"]+$sql_row4["sum(ship_s_s13)"]+$sql_row4["sum(ship_s_s14)"]+$sql_row4["sum(ship_s_s15)"]+$sql_row4["sum(ship_s_s16)"]+$sql_row4["sum(ship_s_s17)"]+$sql_row4["sum(ship_s_s18)"]+$sql_row4["sum(ship_s_s19)"]+$sql_row4["sum(ship_s_s20)"]+$sql_row4["sum(ship_s_s21)"]+$sql_row4["sum(ship_s_s22)"]+$sql_row4["sum(ship_s_s23)"]+$sql_row4["sum(ship_s_s24)"]+$sql_row4["sum(ship_s_s25)"]+$sql_row4["sum(ship_s_s26)"]+$sql_row4["sum(ship_s_s27)"]+$sql_row4["sum(ship_s_s28)"]+$sql_row4["sum(ship_s_s29)"]+$sql_row4["sum(ship_s_s30)"]+$sql_row4["sum(ship_s_s31)"]+$sql_row4["sum(ship_s_s32)"]+$sql_row4["sum(ship_s_s33)"]+$sql_row4["sum(ship_s_s34)"]+$sql_row4["sum(ship_s_s35)"]+$sql_row4["sum(ship_s_s36)"]+$sql_row4["sum(ship_s_s37)"]+$sql_row4["sum(ship_s_s38)"]+$sql_row4["sum(ship_s_s39)"]+$sql_row4["sum(ship_s_s40)"]+$sql_row4["sum(ship_s_s41)"]+$sql_row4["sum(ship_s_s42)"]+$sql_row4["sum(ship_s_s43)"]+$sql_row4["sum(ship_s_s44)"]+$sql_row4["sum(ship_s_s45)"]+$sql_row4["sum(ship_s_s46)"]+$sql_row4["sum(ship_s_s47)"]+$sql_row4["sum(ship_s_s48)"]+$sql_row4["sum(ship_s_s49)"]+$sql_row4["sum(ship_s_s50)"];
			//$message.="<td bgcolor=\"$id\">".round($ship_total,0)."</td>";
		}
		
		/*$status=$status_rep;
		
		if($status_rep == "Offered")
		{
			$status="X";
		}
		if($status_rep != "Offered")
		{
			$status="Y";
		}*/
		
		if($ship_total > 0)
		{
			if($status_rep == "M3 Reported")
			{
				$status="Shipped";
			}		
		}
		
		//$sHTML_Content .="</tr>";
		
		
		$sqlxr="select * from $bai_pro4.weekly_delivery_status_finishing where tid=\"".$ref_id."\"";
		$resultxr=mysqli_query($link,$sqlxr) or die("Error = ".mysqli_error());
		$rowsxr=mysqli_num_rows($resultxr);
		while($rowxx=mysqli_fetch_array($resultxr))
		{
			$log_time=$rowxx["log_time"];
			//echo $log_time."<br>";
			$status_u=$rowxx["status"];
		}
		
		$sqlxry="select * from $bai_pro4.weekly_delivery_status_finishing where tid=\"".$ref_id."\" and log_time like \"%FG-Released%\"";
		$resultxry=mysqli_query($link,$sqlxry) or die("Error = ".mysqli_error());
		$rowsxry=mysqli_num_rows($resultxry);
		
		if($rowsxry > 0)
		{
			$id1="#f051e9";
		}
		else
		{
			$id1=$id;
		}
		
		
		if($log_time=="")
		{
			$log_time=$status_rep."^".date("Y-m-d H:i:s");
		}
		if($rowsxr == 0)
		{
			$sql2xr="insert into $bai_pro4.weekly_delivery_status_finishing(tid,tran_tid,buyer,style,schedule,color,low_status,status,ex_fact,log_time) values(\"".$ref_id."\",\"".$ship_tid."\",\"".$buyer_division."\",\"".$style."\",\"".$schedule."\",\"".$color."\",\"".$low_status."\",\"".$status."\",\"".$ex_factory_date_new."\",\"".$status."^".date("Y-m-d H:i:s")."\")";
			//echo $sql2xr."<br>";
			mysqli_query($link,$sql2xr) or die("Error2 = ".mysqli_error());
		}
		else
		{
			if($status_u == $status)
			{		
				$sql3xr="update $bai_pro4.weekly_delivery_status_finishing set low_status=\"".$low_status."\",buyer=\"".$buyer_division."\",log_time=\"".$log_time."\",ex_fact=\"".$ex_factory_date_new."\",status=\"".$status."\" where tid=\"".$ref_id."\" ";
			}
			else
			{			
				$sql3xr="update $bai_pro4.weekly_delivery_status_finishing set low_status=\"".$low_status."\",buyer=\"".$buyer_division."\",log_time=\"$log_time&".$status."^".date("Y-m-d H:i:s")."\",ex_fact=\"".$ex_factory_date_new."\",status=\"".$status."\" where tid=\"".$ref_id."\" ";
			}
			//echo $sql3xr."<br>";
			//echo $status_u."-".$status."-".$sql3xr."<br>";
			mysqli_query($link,$sql3xr) or die("Error21 = ".mysqli_error());
		}
		
		if(in_array($authorized,$permission))
		{	
			if($status=="FCA" || $status=="FCA/P")
			{		
				$sHTML_Content .="<tr>";
				$sHTML_Content .="<td bgcolor=\"$id\"><a href=\"status_update.php?tid=$ref_id&&schedule=$schedule\" onclick=\"return popitup('status_update.php?tid=$ref_id&&schedule=$schedule')\">".$x."</a><input type=\"hidden\" name=\"rtid[]\" value=\"".$ref_id."\" /><input type=\"hidden\" name=\"tid[]\" value=\"".$ship_tid."\" /></td>";
				$sHTML_Content .="<td bgcolor=\"$id\">".$buyer_division."</td>";
				$sHTML_Content .="<td bgcolor=\"$id\">".$order_no."</td>";
				$sHTML_Content .="<td bgcolor=\"$id\">".$mo."</td>";
				$sHTML_Content .="<td bgcolor=\"$id\">".$co."</td>";
				$sHTML_Content .="<td bgcolor=\"$id\">".$style."</td>";
				$sHTML_Content .="<td bgcolor=\"$id\">".$schedule."<input type=\"hidden\" name=\"sche[]\" value=\"".$schedule."\" /></td>";
				$sHTML_Content .="<td bgcolor=\"$id\">".$color."<input type=\"hidden\" name=\"col[]\" value=\"".$color."\" /></td>";
				$sHTML_Content .="<td bgcolor=\"$id\">".$mods."</td>";	
				$sHTML_Content .="<td bgcolor=\"$id\">".$order_total_qty."</td>";	
				$sHTML_Content .="<td bgcolor=\"$id\">".$cut_total_qty."</td>";	
				$sHTML_Content .="<td bgcolor=\"$id\">".round($input_total_qty+$input_total_qtyx,0)."</td>";
				$sHTML_Content .="<td bgcolor=\"$id\">".round($output_total_qty+$output_total_qtyx,0)."</td>";
				$sHTML_Content .="<td bgcolor=\"$id\">".round($scan_total_qty,0)."</td>";
				$sHTML_Content .="<td bgcolor=\"$id\">".round($fca_total_qty,0)."</td>";
				//$sHTML_Content .="<td bgcolor=\"$id\">".$status."<input type=\"hidden\" name=\"stas[]\" value=\"".$status."\" /></td>";
				$sHTML_Content .="<td bgcolor=\"$id\">".$low_status."<input type=\"hidden\" name=\"stas[]\" value=\"".$low_status."\" /></td>";
				$sHTML_Content .="<td bgcolor=\"$id1\">".$status."<input type=\"hidden\" name=\"stas[]\" value=\"".$status."\" /></td>";
				$sHTML_Content .="<td bgcolor=\"$id\">".$ex_factory_date_new."<input type=\"hidden\" name=\"exf[]\" value=\"".$ex_factory_date_new."\" /></td>";
				$sHTML_Content .="<td bgcolor=\"$id\">".$planing_remarks."</td>";
				$sHTML_Content .="<td bgcolor=\"$id\">".$offered_status."</td>";
				$sHTML_Content .="<td bgcolor=\"$id\">".$fca_time."</td>";
				$sHTML_Content .="<td bgcolor=\"$id\">".$dispatch_status."</td>";
				//$sHTML_Content .="<td bgcolor=\"$id\">".$log_time."</td>";
				$sHTML_Content .="</tr>";
			}
		}
		else if(in_array($authorized,$permission))
		{	
			if($status=="Offered" || $status=="FCA/P" || $status=="FCA Fail")
			{
				$sHTML_Content .="<tr>";		
				$sHTML_Content .="<td bgcolor=\"$id\">$x</td>";
				$sHTML_Content .="<td bgcolor=\"$id\">".$buyer_division."</td>";
				$sHTML_Content .="<td bgcolor=\"$id\">".$order_no."</td>";
				$sHTML_Content .="<td bgcolor=\"$id\">".$mo."</td>";
				$sHTML_Content .="<td bgcolor=\"$id\">".$co."</td>";
				$sHTML_Content .="<td bgcolor=\"$id\">".$style."</td>";
				$sHTML_Content .="<td bgcolor=\"$id\">".$schedule."<input type=\"hidden\" name=\"sche[]\" value=\"".$schedule."\" /></td>";
				$sHTML_Content .="<td bgcolor=\"$id\">".$color."<input type=\"hidden\" name=\"col[]\" value=\"".$color."\" /></td>";
				$sHTML_Content .="<td bgcolor=\"$id\">".$mods."</td>";	
				$sHTML_Content .="<td bgcolor=\"$id\">".$order_total_qty."</td>";	
				$sHTML_Content .="<td bgcolor=\"$id\">".$cut_total_qty."</td>";	
				$sHTML_Content .="<td bgcolor=\"$id\">".round($input_total_qty+$input_total_qtyx,0)."</td>";
				$sHTML_Content .="<td bgcolor=\"$id\">".round($output_total_qty+$output_total_qtyx,0)."</td>";
				$sHTML_Content .="<td bgcolor=\"$id\">".round($scan_total_qty,0)."</td>";
				$sHTML_Content .="<td bgcolor=\"$id\">".round($fca_total_qty,0)."</td>";
				//$sHTML_Content .="<td bgcolor=\"$id\">".$status."<input type=\"hidden\" name=\"stas[]\" value=\"".$status."\" /></td>";
				$sHTML_Content .="<td bgcolor=\"$id\">".$low_status."<input type=\"hidden\" name=\"stas[]\" value=\"".$low_status."\" /></td>";
				$sHTML_Content .="<td bgcolor=\"$id1\">".$status."<input type=\"hidden\" name=\"stas[]\" value=\"".$status."\" /></td>";
				$sHTML_Content .="<td bgcolor=\"$id\">".$ex_factory_date_new."<input type=\"hidden\" name=\"exf[]\" value=\"".$ex_factory_date_new."\" /></td>";
				$sHTML_Content .="<td bgcolor=\"$id\">".$planing_remarks."</td>";
				$sHTML_Content .="<td bgcolor=\"$id\">".$offered_status."</td>";
				$sHTML_Content .="<td bgcolor=\"$id\">".$fca_time."</td>";
				$sHTML_Content .="<td bgcolor=\"$id\">".$dispatch_status."</td>";
				//$sHTML_Content .="<td bgcolor=\"$id\">".$log_time."</td>";
				$sHTML_Content .="</tr>";
			}
		}
		else if(in_array($authorized,$permission))
		{	
			if(($status=="FG" && ($order_total_qty==$scan_total_qty)) || $status=="FG*")
			{
				$sHTML_Content .="<tr>";
				$sHTML_Content .="<td bgcolor=\"$id\"><a href=\"status_update.php?tid=$ref_id&&schedule=$schedule\" onclick=\"return popitup('status_update.php?tid=$ref_id&&schedule=$schedule')\">".$x."</a><input type=\"hidden\" name=\"rtid[]\" value=\"".$ref_id."\" /><input type=\"hidden\" name=\"tid[]\" value=\"".$ship_tid."\" /></td>";	
				$sHTML_Content .="<td bgcolor=\"$id\">".$buyer_division."</td>";
				$sHTML_Content .="<td bgcolor=\"$id\">".$order_no."</td>";
				$sHTML_Content .="<td bgcolor=\"$id\">".$mo."</td>";
				$sHTML_Content .="<td bgcolor=\"$id\">".$co."</td>";
				$sHTML_Content .="<td bgcolor=\"$id\">".$style."</td>";
				$sHTML_Content .="<td bgcolor=\"$id\">".$schedule."<input type=\"hidden\" name=\"sche[]\" value=\"".$schedule."\" /></td>";
				$sHTML_Content .="<td bgcolor=\"$id\">".$color."<input type=\"hidden\" name=\"col[]\" value=\"".$color."\" /></td>";
				$sHTML_Content .="<td bgcolor=\"$id\">".$mods."</td>";	
				$sHTML_Content .="<td bgcolor=\"$id\">".$order_total_qty."</td>";	
				$sHTML_Content .="<td bgcolor=\"$id\">".$cut_total_qty."</td>";	
				$sHTML_Content .="<td bgcolor=\"$id\">".round($input_total_qty+$input_total_qtyx,0)."</td>";
				$sHTML_Content .="<td bgcolor=\"$id\">".round($output_total_qty+$output_total_qtyx,0)."</td>";
				$sHTML_Content .="<td bgcolor=\"$id\">".round($scan_total_qty,0)."</td>";
				$sHTML_Content .="<td bgcolor=\"$id\">".round($fca_total_qty,0)."</td>";
				//$sHTML_Content .="<td bgcolor=\"$id\">".$status."<input type=\"hidden\" name=\"stas[]\" value=\"".$status."\" /></td>";
				$sHTML_Content .="<td bgcolor=\"$id\">".$low_status."<input type=\"hidden\" name=\"stas[]\" value=\"".$low_status."\" /></td>";
				$sHTML_Content .="<td bgcolor=\"$id1\">".$status."<input type=\"hidden\" name=\"stas[]\" value=\"".$status."\" /></td>";
				$sHTML_Content .="<td bgcolor=\"$id\">".$ex_factory_date_new."<input type=\"hidden\" name=\"exf[]\" value=\"".$ex_factory_date_new."\" /></td>";
				$sHTML_Content .="<td bgcolor=\"$id\">".$planing_remarks."</td>";
				$sHTML_Content .="<td bgcolor=\"$id\">".$offered_status."</td>";
				$sHTML_Content .="<td bgcolor=\"$id\">".$fca_time."</td>";
				$sHTML_Content .="<td bgcolor=\"$id\">".$dispatch_status."</td>";
				//$sHTML_Content .="<td bgcolor=\"$id\">".$log_time."</td>";
				$sHTML_Content .="</tr>";
			}
		}
		else
		{
			$sHTML_Content .="<tr>";
			if(in_array($authorized,$permission))
			{
				$sHTML_Content .="<td bgcolor=\"$id\"><a href=\"status_update.php?tid=$ref_id&&schedule=$schedule\" onclick=\"return popitup('status_update.php?tid=$ref_id&&schedule=$schedule')\">".$x."</a><input type=\"hidden\" name=\"rtid[]\" value=\"".$ref_id."\" /><input type=\"hidden\" name=\"tid[]\" value=\"".$ship_tid."\" /></td>";
			}
			else
			{
				$sHTML_Content .="<td bgcolor=\"$id\">$x</td>";
			}
			
			$sHTML_Content .="<td bgcolor=\"$id\">".$buyer_division."</td>";
			$sHTML_Content .="<td bgcolor=\"$id\">".$order_no."</td>";
			$sHTML_Content .="<td bgcolor=\"$id\">".$mo."</td>";
			$sHTML_Content .="<td bgcolor=\"$id\">".$co."</td>";
			$sHTML_Content .="<td bgcolor=\"$id\">".$style."</td>";
			$sHTML_Content .="<td bgcolor=\"$id\">".$schedule."<input type=\"hidden\" name=\"sche[]\" value=\"".$schedule."\" /></td>";
			$sHTML_Content .="<td bgcolor=\"$id\">".$color."<input type=\"hidden\" name=\"col[]\" value=\"".$color."\" /></td>";
			$sHTML_Content .="<td bgcolor=\"$id\">".$mods."</td>";	
			$sHTML_Content .="<td bgcolor=\"$id\">".$order_total_qty."</td>";	
			$sHTML_Content .="<td bgcolor=\"$id\">".$cut_total_qty."</td>";	
			$sHTML_Content .="<td bgcolor=\"$id\">".round($input_total_qty+$input_total_qtyx,0)."</td>";
			$sHTML_Content .="<td bgcolor=\"$id\">".round($output_total_qty+$output_total_qtyx,0)."</td>";
			$sHTML_Content .="<td bgcolor=\"$id\">".round($scan_total_qty,0)."</td>";
			$sHTML_Content .="<td bgcolor=\"$id\">".round($fca_total_qty,0)."</td>";
			//$sHTML_Content .="<td bgcolor=\"$id\">".$status."<input type=\"hidden\" name=\"stas[]\" value=\"".$status."\" /></td>";
			$sHTML_Content .="<td bgcolor=\"$id\">".$low_status."<input type=\"hidden\" name=\"stas[]\" value=\"".$low_status."\" /></td>";
			$sHTML_Content .="<td bgcolor=\"$id1\">".$status."<input type=\"hidden\" name=\"stas[]\" value=\"".$status."\" /></td>";
			$sHTML_Content .="<td bgcolor=\"$id\">".$ex_factory_date_new."<input type=\"hidden\" name=\"exf[]\" value=\"".$ex_factory_date_new."\" /></td>";
			$sHTML_Content .="<td bgcolor=\"$id\">".$planing_remarks."</td>";
			$sHTML_Content .="<td bgcolor=\"$id\">".$offered_status."</td>";
			$sHTML_Content .="<td bgcolor=\"$id\">".$fca_time."</td>";
			$sHTML_Content .="<td bgcolor=\"$id\">".$dispatch_status."</td>";
			//$sHTML_Content .="<td bgcolor=\"$id\">".$log_time."</td>";
			$sHTML_Content .="</tr>";
		}
		
		$cut_total_qty=0;
	}
	$sHTML_Content .="</table></div>";
		$sHTML_Footer = "</body></html>";

		echo $sHTML_Header;
		echo $sHTML_Content;
		echo $sHTML_Footer;	
}

}
?>
</div>
</div> 


<script language="javascript" type="text/javascript">
	var table3Filters = {
	col_1: "select",
	col_2: "select",
	col_6: "select",
	col_15: "select",
	col_16: "select",
	col_17: "select",
	sort_select: true,
	display_all_text: "Display all",
	loader: true,
	loader_text: "Filtering data...",
	sort_select: true,
	exact_match: true,
	rows_counter: true,
	btn_reset: true
	}
	setFilterGrid("table1",table3Filters);
</script>
