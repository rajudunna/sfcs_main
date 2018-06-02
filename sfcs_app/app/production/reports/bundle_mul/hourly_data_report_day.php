<html>
<?php
set_time_limit(300000000);
include($_SERVER['DOCUMENT_ROOT']."/sfcs_app/common/config/config.php");
include($_SERVER['DOCUMENT_ROOT']."/sfcs_app/common/config/user_acl_v1.php");
include($_SERVER['DOCUMENT_ROOT']."/sfcs_app/common/config/functions.php");


?>
<head>
<title>Product Wise Summary Report</title>
<script type="text/javascript" src="jquery.min.js"></script>
<script language="JavaScript" src="FusionCharts.js"></script>
<script type="text/javascript" language="JavaScript" src="FusionChartsExportComponent.js"></script>
<script type="text/javascript" src="datetimepicker_css.js"></script>
<style type="text/css" media="screen">

/*====================================================
	- HTML Table Filter stylesheet
=====================================================*/
@import "TableFilter_EN/filtergrid.css";

/*====================================================
	- General html elements
=====================================================*/
body{ 
	margin:0px; padding:0px; border:0px solid #666;
	font-family:Arial, Helvetica, sans-serif; font-size:12px; 
}

caption{ margin:10px 0 0 5px; padding:10px; text-align:left; }
pre{ font-size:13px; margin:5px; padding:5px; background-color:#f4f4f4; border:1px solid #ccc;  }
.mytable1{
	font-size:12px;
}
th{ background-color:#003366; color:#FFF; padding:2px; border:1px solid #ccc; }
td{ padding:2px; border-bottom:1px solid #ccc; border-right:1px solid #ccc; white-space:nowrap;}
</style>
</head>
<body>
<?php
//$valget=$_GET["alert"];
$valget=1;
if($valget=='2')
{

$view_access=user_acl("SFCS_0248",$username,1,$group_id_sfcs); 
?>
<div id="page_heading"><span style="float: left"><h3>Day & Module Wise Performance Report</h3></span><span style="float: right"><b>?</b>&nbsp;</span></div>

<form action="hourly_data_report_day.php" method="post">
Date&nbsp;&nbsp;<input type="text" name="dat1" value="<?php  if(isset($_POST['dat1'])) { echo $_POST['dat1']; } else { echo date("Y-m-d"); } ?>" size=8 />
&nbsp;&nbsp;&nbsp;&nbsp;

Hour <select name="hour">
	<option value="6" <?php if($_POST["hour"] == 6){ echo "selected";}?>>6 AM</option>
	<option value="7" <?php if($_POST['hour'] == 7){ echo "selected";}?>>7 AM</option>
	<option value="8" <?php if($_POST['hour'] == 8){ echo "selected";}?>>8 AM</option>
	<option value="9" <?php if($_POST["hour"] == 9){ echo "selected";}?>>9 AM</option>
	<option value="10" <?php if($_POST["hour"] == 10){ echo "selected";}?>>10 AM</option>
	<option value="11" <?php if($_POST["hour"] == 11){ echo "selected";}?>>11 AM</option>
	<option value="12" <?php if($_POST["hour"] == 12){ echo "selected";}?>>12 PM</option>
	<option value="13" <?php if($_POST["hour"] == 13){ echo "selected";}?>>1 PM</option>
	<option value="14" <?php if($_POST["hour"] == 14){ echo "selected";}?>>2 PM</option>
	<option value="15" <?php if($_POST["hour"] == 15){ echo "selected";}?>>3 PM</option>
	<option value="16" <?php if($_POST["hour"] == 16){ echo "selected";}?>>4 PM</option>
	<option value="17" <?php if($_POST["hour"] == 17){ echo "selected";}?>>5 PM</option>
	<option value="18" <?php if($_POST["hour"] == 18){ echo "selected";}?>>6 PM</option>
	<option value="19" <?php if($_POST["hour"] == 19){ echo "selected";}?>>7 PM</option>
	<option value="20" <?php if($_POST["hour"] == 20){ echo "selected";}?>>8 PM</option>
	<option value="21" <?php if($_POST["hour"] == 21){ echo "selected";}?>>9 PM</option>
	
</select>
&nbsp;&nbsp;&nbsp;&nbsp;
Product <select name="product">
<?php
$sql_source="SELECT buyer_div FROM $bai_pro3.plan_modules group by buyer_div";
//echo $sql_source."<br><br>";
$result_source=mysqli_query($link, $sql_source) or die("Error=".$sql."=".mysqli_error($GLOBALS["___mysqli_ston"]));
while($row_source=mysqli_fetch_array($result_source))
{
	$buyer_name_ref[]=$row_source["buyer_div"];
}
$buyer_name_ref_implode="'".implode("','",$buyer_name_ref)."'";
echo "<option value=\"".$buyer_name_ref_implode."\">ALL</option>";
for($i=0;$i<sizeof($buyer_name_ref);$i++)
{
	echo "<option value=\"'".$buyer_name_ref[$i]."'\">".$buyer_name_ref[$i]."</option>";
}

?>
</select>
&nbsp;&nbsp;&nbsp;&nbsp;
<!--<input type="submit" name="submit" value="Show" /> -->
<?php echo "<input type=\"submit\" value=\"Show\" name=\"submit\" id=\"submit\"  onclick=\"document.getElementById('submit').style.display='none'; document.getElementById('msg1').style.display='';\"/>";
    echo "<span id=\"msg1\" style=\"display:none;\"><h5>Please Wait...!<h5></span>"; ?>
</form>

<?php
}

if(isset($_POST["submit"]))
{
	$date=$_POST["dat1"];
	$hours=$_POST["hour"];
	//echo $date."--".$hours."<br>";
	
	$sql="SELECT sum(bundle_transactions_20_repeat_quantity) as act_out FROM $brandix_bts.view_set_1 WHERE DATE(bundle_transactions_date_time)='".$date."' AND HOUR(bundle_transactions_date_time)='".$hours."' AND bundle_transactions_20_repeat_operation_id='4'";
 	$sql_result=mysqli_query($link, $sql) or exit("Sql Errordd==3".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row1=mysqli_fetch_array($sql_result))
	{
		$val=$sql_row1['act_out'];
	}
	if($val>0)
	{	
		$hour=$hours+1;
		$product=$_POST["product"];
		$a_h="06:00:00";
		$a_hs=$hour.":00:00";
		if(9<=$hours)
		{
			$sub=0.5;
		}
		else if(18<=$hours)
		{
			$sub=1;
		}
		else
		{
			$sub=0;
		}
		//echo $a_hs."--".$a_h."<br>";
		$time1 = new DateTime($a_h);
		$time2 = new DateTime($a_hs);
		$interval = $time1->diff($time2);
		$val= $interval->format('%H')-$sub;
		//echo $val;
		if(substr($hours,0,1)==0)
		{
			$hours=substr($hours,1);
		}
		if(substr($hour,0,1)==0)
		{
			$hour=substr($hour,1);
		}
		if($hours<13)
		{
			if($hours==12)
			{
				$var= $hours."-".($hour-12)." PM";
			}
			else
			{
				$var= $hours."-".$hour." AM";
			}	
		}
		else
		{
			$r=$hours-12;
			$rr=$hour-12;
			$var= $r."-".$rr." PM";
		}
		$hrs=array("6","7","8","9","10","11","12","13","14","15","16","17","18","19","20","21");	
		$hrs1=array("6-7AM","7-8AM","8-9AM","9-10AM","10-11AM","11-12PM","12-1PM","1-2PM","2-3PM","3-4PM","4-5PM","5-6PM","6-7PM","7-8PM","8-9PM","9-10PM");	
		//$hrs=array("6AM","7AM","8AM","9AM","10AM","11AM","12PM","1PM","2PM","3PM","4PM","5PM","6PM","7PM","8PM","9PM");	
		//echo"<h2>".$hours."-".$hour." Plan Vs Actual Performace</h2>";
		echo"<h2 style='background-color: MidnightBlue ;text-align: center;color:White; ' >".$var." Plan Vs Actual Performance</h2>";
		echo "<a  target=\"_blank\" href=\"hour_bundles.php?hour=$hours&dat=$date\">Click Here See the Bundles</a>";
		//echo "<h5><font color=\"red\"><b><u>Note:</u></b>Time Consider for 15 minutes of each hour.";
		echo "<table border=\"1px\"><tr><td rowspan=\"2\">";
		
		echo "<table border =1px>";
		echo "<tr><td colspan=6><h5><font color=\"red\"><b><u>Note:</u></b> Considering 15 minutes of next hour.</td></tr>";
		echo "<tr><th colspan=6>Module Level performance</th></tr>";
		echo"<tr><th>Team No</th><th>Running Style</th><th>Plan PCS</th><th>Actual PCS</th><th>Variation</th><th>Achievement%</th></tr>";
		$sql="SELECT mod_no,sec_no,ROUND((SUM(plan_pro)/15)) AS plan_prod,ROUND((SUM(plan_sah)/15)) AS plan_sah,ROUND((SUM(plan_eff)/15)) AS plan_eff FROM $bai_pro.pro_plan WHERE DATE='".$date."' GROUP BY sec_no,mod_no ORDER BY mod_no*1";
		//echo $sql."<br>";
		$plan_pro=array();$plan_sah_hr=0;
		$sql_result=mysqli_query($link, $sql) or exit("Sql Error=1".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row=mysqli_fetch_array($sql_result))
		{
			$module=$sql_row['mod_no'];
			$plan_pro[$module]=$sql_row['plan_prod'];
			//echo $module."--".$sql_row['plan_prod']."--*--".$val."<br>";
			$plan_prod_cum[$module]=round($sql_row['plan_prod']*$val);
			$plan_sah[$module]=$sql_row['plan_sah'];
			$plan_eff[$module]=$sql_row['plan_eff'];
			$plan_produ[$module]=round($sql_row['plan_prod']*$val);
		}
		//echo sizeof($plan_produ)."<br>";
		$plan_sah_hr=echo_title("$bai_pro.pro_plan","ROUND((SUM(plan_sah)/15))","DATE",$date,$link);
		$sql_source="SELECT section_id,buyer_div as buyer_id,GROUP_CONCAT(module_id order by module_id*1) as modules FROM $bai_pro3.plan_modules WHERE LENGTH(buyer_div)>0 and section_id not in (4) and buyer_div in (".$product.") group by buyer_div order by buyer_div";
		//echo $sql_source."<br>";
		$sql_result1d=mysqli_query($link, $sql_source) or exit("Sql Errordd--2".mysqli_error($GLOBALS["___mysqli_ston"]));
		$mods=array();
		$buyer_name_ref=array();$acheivement_per_fac=0;
		$section=array();$modules=array();
		while($sql_row1d=mysqli_fetch_array($sql_result1d))
		{
			$buyer_name_ref[]=$sql_row1d["buyer_id"];
			$modules[]=$sql_row1d["modules"];
		}
		if($hours=='6')
		{
			$sql1="SELECT bundle_transactions_20_repeat_act_module as module,GROUP_CONCAT(DISTINCT bundle_transactions_20_repeat_bundle_id) AS bundles,SUM(bundle_transactions_20_repeat_quantity) AS act_out FROM $brandix_bts.view_set_1 WHERE DATE(bundle_transactions_date_time)='".$date."' AND TIME(bundle_transactions_date_time) < TIME('$hour:15:00') AND bundle_transactions_20_repeat_operation_id='4' GROUP BY bundle_transactions_20_repeat_act_module*1";
		
		}
		else
		{
			$sql1="SELECT bundle_transactions_20_repeat_act_module as module,GROUP_CONCAT(DISTINCT bundle_transactions_20_repeat_bundle_id) AS bundles,SUM(bundle_transactions_20_repeat_quantity) AS act_out FROM $brandix_bts.view_set_1 WHERE DATE(bundle_transactions_date_time)='".$date."' AND TIME(bundle_transactions_date_time)>= TIME('$hours:15:00') AND TIME(bundle_transactions_date_time)< TIME('$hour:15:00') AND bundle_transactions_20_repeat_operation_id='4' GROUP BY bundle_transactions_20_repeat_act_module*1";
		}
		$sql_result1=mysqli_query($link, $sql1) or exit("Sql Errordd==3".mysqli_error($GLOBALS["___mysqli_ston"]));
		$act_out=array();
		while($sql_row1=mysqli_fetch_array($sql_result1))
		{
			$mod=$sql_row1["module"];
			$act_out[$mod]=$sql_row1["act_out"];
			//$style_id_1=echo_title_1("$brandix_bts.view_set_3","group_concat(distinct tbl_min_ord_ref_ref_product_style)","tbl_miniorder_data_bundle_number",$sql_row1["bundles"],$link);
			//$style=echo_title_1("$brandix_bts.tbl_orders_style_ref","group_concat(distinct product_style)","id",$style_id_1,$link);
			//$act_style[$mod]=$style;
			//echo $row['bundles']."--".$style_id_1."---".$style."<br>";
			//exit;
			$sql="SELECT GROUP_CONCAT(DISTINCT TRIM(style_ref.product_style) SEPARATOR ',') as style FROM tbl_miniorder_data AS tm LEFT JOIN tbl_min_ord_ref AS tr ON tm.mini_ordeR_ref=tr.id LEFT JOIN tbl_orders_style_ref AS style_ref ON tr.ref_product_style=style_Ref.id WHERE tm.bundle_number IN (".$sql_row1["bundles"].")";
			$sql_result=mysqli_query($link, $sql) or exit("Sql Errordd==4".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row=mysqli_fetch_array($sql_result))
			{
				$act_style[$mod]=$sql_row["style"];
			}
			
		}
		
		$act_sah_1=array();
		$a_sah=array();
		$a_out=array();
		$product=array();
		$sah=0;$qty=0;
		for($i=6;$i<=$hour;$i++)	
		{
			$hour_a=$i;
			$k=$i+1;
			$bundle_numbers=array();
			$sql121="SELECT bundle_transactions_20_repeat_bundle_id as bundles FROM $brandix_bts.`view_set_1` WHERE DATE(bundle_transactions_date_time)='".$date."' AND TIME(bundle_transactions_date_time) between TIME('$i:15:00') and  TIME('$k:15:00') AND bundle_transactions_20_repeat_operation_id='4' group by bundle_transactions_20_repeat_bundle_id";
			//echo $sql121."<br>";
			$sql_result121=mysqli_query($link, $sql121) or exit("Sql Errordd==6".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row121=mysqli_fetch_array($sql_result121))
			{
				$bundle_numbers[]=$sql_row121['bundles'];
			}
			if(sizeof($bundle_numbers)>0)
			{
				$sql12="SELECT $brandix_bts.tbl_orders_style_ref.product_style,$brandix_bts.tbl_orders_master.product_schedule,
				$brandix_bts.tbl_miniorder_data.color,$brandix_bts.bundle_transactions_20_repeat.bundle_id,SUM($brandix_bts.bundle_transactions_20_repeat.quantity) as qnty,
				ROUND(SUM(($brandix_bts.bundle_transactions_20_repeat.quantity * $bai_pro3.`bai_orders_db_confirm`.smv)/60),2) AS sah,$bai_pro3.`bai_orders_db_confirm`.smv AS smv FROM $brandix_bts.tbl_miniorder_data 
				LEFT JOIN $brandix_bts.bundle_transactions_20_repeat ON $brandix_bts.bundle_transactions_20_repeat.bundle_id=$brandix_bts.tbl_miniorder_data.bundle_number
				LEFT JOIN $brandix_bts.tbl_min_ord_ref ON $brandix_bts.tbl_min_ord_ref.id=$brandix_bts.tbl_miniorder_data.mini_order_ref 
				LEFT JOIN $brandix_bts.tbl_orders_master ON $brandix_bts.tbl_orders_master.id=$brandix_bts.tbl_min_ord_ref.ref_crt_schedule
				LEFT JOIN $brandix_bts.tbl_orders_style_ref ON $brandix_bts.tbl_orders_style_ref.id=$brandix_bts.tbl_min_ord_ref.ref_product_style
				LEFT JOIN $bai_pro3.bai_orders_db_confirm ON $brandix_bts.tbl_orders_style_ref.product_style=$bai_pro3.`bai_orders_db_confirm`.order_style_no 
				AND $brandix_bts.tbl_orders_master.product_schedule=$bai_pro3.bai_orders_db_confirm.order_del_no 
				AND $brandix_bts.tbl_miniorder_data.color=$bai_pro3.`bai_orders_db_confirm`.order_col_des 
				WHERE $brandix_bts.bundle_transactions_20_repeat.operation_id=4 AND $brandix_bts.tbl_miniorder_data.bundle_number
				IN (".implode(",", $bundle_numbers).") GROUP BY $brandix_bts.tbl_orders_style_ref.product_style,$brandix_bts.tbl_orders_master.product_schedule,
				$brandix_bts.tbl_miniorder_data.color";
				//echo $sql12."<br>";
				$sql_result12=mysqli_query($link, $sql12) or exit("Sql Errordd==6-1".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($sql_row12=mysqli_fetch_array($sql_result12))
				{
					$sah+=$sql_row12["sah"];
					$qty+=$sql_row12["qnty"];
				}
				//echo sizeof($bundle_numbers)."<br>";
				unset($bundle_numbers);
				//echo sizeof($bundle_numbers)."<br>";
			}
			else
			{
				$sah=0;
				$qty=0;
			}
			//echo $hour."=".$hours."=".$hour_a."<br>";
			if($hour==$hour_a)
			{
				//echo $a_sah[$hours]."-1-".$a_out[$hours]."<br>";
				$a_sah[$hours]+=$sah;
				$a_out[$hours]+=$qty;
				//echo $a_sah[$hours]."-2-".$a_out[$hours]."<br>";
			}
			else
			{
				$a_sah[$hour_a]=$sah;
				$a_out[$hour_a]=$qty;
				//echo "Test-".$sah."----".$qty."<br>";
			}
			unset($bundle_numbers);
			$sah=0;
			$qty=0;
			
		}
		
		for($x=0;$x<sizeof($hrs);$x++)
		{
			$check=$a_sah[$hrs[$x]];
			if($check>0)
			{
				//if($hrs[$x]==21)
				//{
					//$act_sah_1["Actual"][$hrs[$x]]=$a_sah['22']+$check;
				//}
				//else
				//{
					$act_sah_1["Actual"][$hrs[$x]]=$check;
				//}
			}
			else
			{
				$act_sah_1["Actual"][$hrs[$x]]=0;
			}
			if($hrs[$x]=='9' || $hrs[$x]=='18')
			{
				$act_sah_1["Plan"][$hrs[$x]]=$plan_sah_hr/2;
			}
			else
			{
				$act_sah_1["Plan"][$hrs[$x]]=$plan_sah_hr;
			}
				
		}

		
		$product=array("Plan","Actual");	
		$buyer_name_ref_implode1="'".implode("','",$product)."'";
		$hour_ref_implode="'".implode("','",$hrs1)."'";
		$message='';	
		for($j=0;$j<sizeof($product);$j++)
		{
			$var='';
			$message.= "{";
			for($jj=0;$jj<sizeof($hrs);$jj++)
			{				
				if($hrs[$jj]<$hour)
				{
				
					$var.= $act_sah_1[$product[$j]][$hrs[$jj]].",";
				}
				//$var.= $act_sah_1[$product[$j]][$hrs[$jj]].",";
			}
				$val1=substr($var,0,-1);
				$message.= "name: '".$product[$j]."',";
				$message.= "data: [".$val1."]";
			
			$var='';	
			$val1='';
			if($j<1)
			{	
				$message.= "},";		
			}
			else
			{
				$message.= "}";
			}			
			
		}
		//echo $message."<br>";
		$grond_plan=0;
		$grond_act=0;
		$grond_vari=0;
		$tot_product=0;
		$acheivement_per=array();
		$acheivement_per1=array();
		$buyer_name_ref1=array();
		for($x=0;$x<sizeof($buyer_name_ref);$x++)
		{
			$total_product_plan=0;
			$total_product_act=0;
			$total_product_vari=0;
			$mods=explode(",",$modules[$x]);
			for($i=0;$i<sizeof($mods);$i++)
			{	
				$tot_product+=$plan_produ[$mods[$i]];
				echo"<tr>";
				echo"<td>Team-".$mods[$i]."</td>";
				//echo"<td>style-".$mods[$i]."</td>";
				if($act_style[$mods[$i]]=='')
				{
					echo"<td>0</td>";
				}
				else
				{
					echo"<td>".$act_style[$mods[$i]]."</td>";
				}
				echo"<td>".$plan_pro[$mods[$i]]."</td>";
				if($act_out[$mods[$i]]=='')
				{
					echo"<td>0</td>";	
				}
				else
				{
					echo"<td>".$act_out[$mods[$i]]."</td>";
				}
				$variance=$act_out[$mods[$i]]-$plan_pro[$mods[$i]];
				echo"<td>".$variance."</td>";
				if($act_out[$mods[$i]] > 0)
				{
					if(round($act_out[$mods[$i]]*100/div_by_zero($plan_pro[$mods[$i]]),0) <= 75)
					{
						$color1="#FF0000";
					}
					else if(round($act_out[$mods[$i]]*100/div_by_zero($plan_pro[$mods[$i]]),0) >= 76 and round($act_out[$mods[$i]]*100/div_by_zero($plan_pro[$mods[$i]]),0) <= 90 )
					{
						$color1="#FFFF00";
					}
					else
					{
						$color1="#008000";
					}
				}
				else
				{
					$color1="#FF0000";
					//$acheivement_per[]=0;
				}
				echo"<td bgcolor=\"".$color1."\">".round($act_out[$mods[$i]]*100/div_by_zero($plan_pro[$mods[$i]]),0)."%</td>";
				$total_product_plan+=$plan_pro[$mods[$i]];
				$total_product_act+=$act_out[$mods[$i]];
				$total_product_vari+=$variance;
			}
			$plan_prod_buyer[$buyer_name_ref[$x]]=$tot_product;
			$tot_product=0;
			echo"<tr>";
			echo"<th colspan=2>".$buyer_name_ref[$x]."</th>";
			echo"<th>".$total_product_plan."</th>";
			echo"<th>".$total_product_act."</th>";
			echo"<th>".$total_product_vari."</th>";
			$acheivement_per[]=round($total_product_act*100/div_by_zero($total_product_plan),0);
			if($total_product_act > 0)
			{
				if(round($total_product_act*100/div_by_zero($total_product_plan),0) <= 75)
				{
					$color="#FF0000";
				}
				else if(round($total_product_act*100/div_by_zero($total_product_plan),0) >= 76 and round($total_product_act*100/div_by_zero($total_product_plan),0) <= 90 )
				{
					$color="#FFFF00";
				}
				else
				{
					$color="#008000";
				}
			}
			else
			{
				$color="#FF0000";
				//$acheivement_per[]=0;
			}
			echo"<td bgcolor=\"".$color."\">".round($total_product_act*100/div_by_zero($total_product_plan),0)."%</td>";
			$total_product_plan1[]=$total_product_plan;
			$grond_plan+=$total_product_plan;
			$total_product_act1[]=$total_product_act;
			$grond_act+=$total_product_act;
			$total_product_vari1[]=$total_product_vari;
			$grond_vari+=$total_product_vari;
			//$var1=round($grond_act*100/$grond_plan,0)."%";
			//$var1=0;
			
		}
		echo"<tr>";
		echo"<th colspan=2>Grand Total</th>";
		echo"<td>".$grond_plan."</td>";
		echo"<td>".$grond_act."</td>";
		echo"<td>".$grond_vari."</td>";
		if($grond_act > 0)
		{
			if(round($grond_act*100/div_by_zero($grond_plan),0) <= 75)
			{
				$color5="#FF0000";
			}
			else if(round($grond_act*100/div_by_zero($grond_plan),0) >= 76 and round($grond_act*100/div_by_zero($grond_plan),0) <= 90 )
			{
				$color5="#FFFF00";
			}
			else
			{
				$color5="#008000";
			}
		}
		else
		{
			$color5="#FF0000";
			//$acheivement_per[]=0;
		}
		$total_product_plan1[]=$grond_plan;
		$total_product_act1[]=$grond_act;
		$total_product_vari1[]=$grond_vari;
		echo"<td bgcolor=\"".$color5."\">".round($grond_act*100/div_by_zero($grond_plan),0)."%</td><tr>";
		//$var=round($grond_act*100/$grond_plan,0)."%";
			
		//$var=0;
		$buyer_name_ref[]="Factory";
		$acheivement_per[]=round($grond_act*100/div_by_zero($grond_plan),0);
		$buyer_name_ref_implode="'".implode("','",$buyer_name_ref)."'";
		//$buyer_name_ref_implode1="'".implode("','",$buyer_name_ref1)."'";
		$acheivement_per_implode="".implode(",",$acheivement_per)."";
		echo"</table>";
		
		echo"</td>";

		echo "<script src=\"highcharts.js\"></script>";
		echo"<script src=\"exporting.js\"></script>";

		echo"<script type=\"text/javascript\">
		$(function () {
			var chart;
			$(document).ready(function() {
				chart = new Highcharts.Chart({
					chart: {
						renderTo: 'container',
						type: 'line'
					},
					title: {
						align: 'center',
						text: 'Hourly Plan Vs Actual Factory SAH'
					},
					xAxis: {
						title: {
							text: 'Hours'
						},
						categories: [".$hour_ref_implode."]	
					},
					yAxis: {
						min: 0,
						title: {
							text: 'SAH'
						},
						stackLabels: {
							enabled: false,
							style: {
								fontWeight: 'bold',
								color: (Highcharts.theme && Highcharts.theme.textColor) || 'gray'
							}
						}
					},
					plotOptions: {
					line: {
						dataLabels: {
							enabled: true
						},
						enableMouseTracking: false
					}
				},
					exporting: {
					enabled: false
					},
					legend: {
						enabled: true,
						align: 'left',
						layout: 'horizontal',
						x: 800,
						verticalAlign: 'left',
						y: 0,
						floating: true,
						backgroundColor: (Highcharts.theme && Highcharts.theme.legendBackgroundColorSolid) || 'white',
						borderColor: '#CCC',
						borderWidth: 1,
						shadow: true
					},
				   
					plotOptions: {			
					   column: {
					   pointPadding: 0.0,
					   borderWidth: 2,
							dataLabels: {
								enabled: true
							}
						}
					},
					series: [".$message."]
				});
			});
			
		});
		</script>";
			
		echo"<script type=\"text/javascript\">
		$(function () {
			var chart;
			$(document).ready(function() {
				chart = new Highcharts.Chart({
					chart: {
						renderTo: 'container1',
						type: 'column'
					},
					title: {
						align: 'center',
						text: 'Hourly Product Wise Actual'
					},
					xAxis: {
						title: {
							text: 'Product'
						},
						categories: [".$buyer_name_ref_implode."]
					},
					yAxis: {
						min: 0,
						title: {
							text: 'Achievement%'
						},
						stackLabels: {
							enabled: false,
							style: {
								fontWeight: 'bold',
								color: (Highcharts.theme && Highcharts.theme.textColor) || 'gray'
							}
						}
					},
					exporting: {
					enabled: false
					},
					legend: {
						enabled: false,
						align: 'left',
						layout: 'horizontal',
						x: 305,
						verticalAlign: 'top',
						y: -10,
						floating: true,
						backgroundColor: (Highcharts.theme && Highcharts.theme.legendBackgroundColorSolid) || 'white',
						borderColor: '#CCC',
						borderWidth: 1,
						shadow: false
					},
				   
					plotOptions: {			
					   column: {
					   pointPadding: 0.0,
					   borderWidth: 2,
							dataLabels: {
								enabled: true
							}
						}
					},
					series: [{
						name: 'Achievement%',
						data: [".$acheivement_per_implode."]
					}]
				});
			});
			
		});
		</script>";

		echo "<td>";
		echo "<div id=\"container1\" style=\"width: 400px; height: 400px; margin: 0 auto\"></div>";

		echo "</td>";
		echo "<td>";
		$modules_cn=array();
		$sql131="select * from $bai_pro3.plan_modules where section_id in (1,2,3) order by module_id*1";
		$sql_result131=mysqli_query($link, $sql131) or exit("Sql Errordd==7".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($row131=mysqli_fetch_array($sql_result131))
		{
			$modules_cnt[]=$row131['module_id'];
		}
		$module_count=sizeof($modules_cnt);
		$total_half_mod=round($module_count/2);
		$next=$total_half_mod+1;
		echo "<table><tr><th colspan=2>Module Wise performance(Cumulative)</th></tr><tr><td>";
		echo "<table border=\"1px\">";
		echo "<tr><tr><th>Module</th><th>Plan</th><th>Actual</th><th>Var Qty</th><th>Per%</th></tr>";
		
		$sql11="SELECT bundle_transactions_20_repeat_act_module as module,SUM(bundle_transactions_20_repeat_quantity) AS quantity FROM $brandix_bts.`view_set_1` WHERE DATE(bundle_transactions_date_time)='".$date."' AND TIME(bundle_transactions_date_time)< TIME('$hour:15:00') AND bundle_transactions_20_repeat_operation_id='4' and bundle_transactions_20_repeat_act_module between 1 and $total_half_mod
		GROUP BY bundle_transactions_20_repeat_act_module ORDER BY bundle_transactions_20_repeat_act_module*1";
		$sql_result11=mysqli_query($link, $sql11) or exit("Sql Errordd==8".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($row11=mysqli_fetch_array($sql_result11))
		{
			
			$total_product_act2=$row11['quantity'];
			$module=$row11['module'];
			$total_product_plan2=$plan_prod_cum[$module];
			$vari=$total_product_act2-$plan_prod_cum[$module];
			echo "<tr>";
			echo "<td>".$module."</td>";
			echo "<td>".$total_product_plan2."</td>";
			echo "<td>".$total_product_act2."</td>";
			echo "<td>".$vari."</td>";
			if($row11['quantity'] > 0)
			{
				if(round($total_product_act2*100/div_by_zero($total_product_plan2),0) <= 75)
				{
					$color21="#FF0000";
				}
				else if(round($total_product_act2*100/div_by_zero($total_product_plan2),0) >= 76 and round($total_product_act2*100/div_by_zero($total_product_plan2),0) <= 90 )
				{
					$color21="#FFFF00";
				}
				else
				{
					$color21="#008000";
				}
			}
			else
			{
				$color21="#FF0000";
				//$acheivement_per[]=0;
			}
			
			echo "<td bgcolor=\"".$color21."\">".round($total_product_act2*100/div_by_zero($total_product_plan2),0)."%</td>";
			echo "</tr>";
			
		}
		echo "</table>";
		echo "<td>";
		echo "<table border=\"1px\">";
		echo "<tr><tr><th>Module</th><th>Plan</th><th>Actual</th><th>Var Qty</th><th>Per%</th></tr>";
		$sql18="SELECT bundle_transactions_20_repeat_act_module as module,SUM(bundle_transactions_20_repeat_quantity) AS quantity FROM $brandix_bts.`view_set_1` WHERE DATE(bundle_transactions_date_time)='".$date."' AND TIME(bundle_transactions_date_time)< TIME('$hour:15:00') AND bundle_transactions_20_repeat_operation_id='4' and bundle_transactions_20_repeat_act_module between $next and $module_count GROUP BY bundle_transactions_20_repeat_act_module ORDER BY bundle_transactions_20_repeat_act_module*1";
		$sql_result18=mysqli_query($link, $sql18) or exit("Sql Errordd==9".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($row18=mysqli_fetch_array($sql_result18))
		{
			
			$total_product_act2=$row18['quantity'];
			$module=$row18['module'];
			$total_product_plan2=$plan_prod_cum[$module];
			$vari=$total_product_act2-$plan_prod_cum[$module];
			echo "<tr>";
			echo "<td>".$module."</td>";
			echo "<td>".$total_product_plan2."</td>";
			echo "<td>".$total_product_act2."</td>";
			echo "<td>".$vari."</td>";
			if($row18['quantity'] > 0)
			{
				if(round($total_product_act2*100/div_by_zero($total_product_plan2),0) <= 75)
				{
					$color21="#FF0000";
				}
				else if(round($total_product_act2*100/div_by_zero($total_product_plan2),0) >= 76 and round($total_product_act2*100/div_by_zero($total_product_plan2),0) <= 90 )
				{
					$color21="#FFFF00";
				}
				else
				{
					$color21="#008000";
				}
			}
			else
			{
				$color21="#FF0000";
				//$acheivement_per[]=0;
			}
			
			echo "<td bgcolor=\"".$color21."\">".round($total_product_act2*100/div_by_zero($total_product_plan2),0)."%</td>";
			echo "</tr>";
			
		}
	
		echo "</table>";
		echo "</tr></table>"; 
		echo "<table border=\"1px\">";
		echo "<tr><th colspan=5>Factory Level Performance(Cumulative)</th></tr><tr><th>Product</th><th>Plan Production</th><th>Actual Production</th><th>Variance Qty</th><th>Percentage</th></tr>";
		$sql1="SELECT pm.buyer_div,SUM(vt.bundle_transactions_20_repeat_quantity) AS quantity FROM $brandix_bts.`view_set_1` AS vt 
			LEFT JOIN $bai_pro3.plan_modules AS pm ON pm.module_id=vt.bundle_transactions_20_repeat_act_module
			WHERE DATE(vt.bundle_transactions_date_time)='".$date."' AND TIME(bundle_transactions_date_time)< TIME('$hour:15:00') AND vt.bundle_transactions_20_repeat_operation_id='4' GROUP BY pm.buyer_div ORDER BY pm.buyer_div";
		$sql_result1=mysqli_query($link, $sql1) or exit("Sql Errordd==10".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($row=mysqli_fetch_array($sql_result1))
		{
			//$total_product_plan2=23000;
			//$modules=echo_title("$bai_pro3.plan_modules","count(*)","buyer_div",$$row['buyer_div'],$link);
			$total_product_act2=$row['quantity'];
			$total_product_plan2=$plan_prod_buyer[$row['buyer_div']];
			$vari=$total_product_act2-$total_product_plan2;
			echo "<tr>";
			echo "<td>".$row['buyer_div']."</td>";
			echo "<td>".$total_product_plan2."</td>";
			echo "<td>".$total_product_act2."</td>";
			echo "<td>".$vari."</td>";
			if($row['quantity'] > 0)
			{
				if(round($total_product_act2*100/div_by_zero($total_product_plan2),0) <= 75)
				{
					$color2="#FF0000";
				}
				else if(round($total_product_act2*100/div_by_zero($total_product_plan2),0) >= 76 and round($total_product_act2*100/div_by_zero($total_product_plan2),0) <= 90 )
				{
					$color2="#FFFF00";
				}
				else
				{
					$color2="#008000";
				}
			}
			else
			{
				$color2="#FF0000";
				//$acheivement_per[]=0;
			}
			
			echo "<td bgcolor=\"".$color2."\">".round($total_product_act2*100/div_by_zero($total_product_plan2),0)."%</td>";
			echo "</tr>";
			$grand_plan+=$total_product_plan2;
			$grand_act+=$total_product_act2;
			$grand_vari+=$vari;
		}
		echo"<tr><td>Factory</td><td>".$grand_plan."</td><td>".$grand_act."</td><td>".$grand_vari."</td>";
		if($grand_act > 0)
		{
			if(round($grand_act*100/div_by_zero($grand_plan),0) <= 75)
			{
				$color3="#FF0000";
			}
			else if(round($grand_act*100/div_by_zero($grand_plan),0) >= 76 and round($grand_act*100/div_by_zero($grand_plan),0) <= 90 )
			{
				$color3="#FFFF00";
			}
			else
			{
				$color3="#008000";
			}
		}
		else
		{
			$color3="#FF0000";
			//$acheivement_per[]=0;
		}
		echo "<td bgcolor=\"".$color3."\">".round($grand_act*100/div_by_zero($grand_plan),0)."%</td>";		
		echo "</tr>";
		echo "</table>";
		echo "<br><br>";
		echo "</td></tr>";
		echo "<tr><td colspan=\"3\">";
		echo "<div id=\"container\" style=\"width: 970px; height: 400px; margin: 0 auto\"></div>";
		echo "</td></tr>";
		echo "</table>";
	}
	else
	{
		echo "<h2>There is no output in the selected hour.</h2>";
	}	
}
if($valget==1)
{
	$date=date('Y-m-d');
	$time = date('Y-m-d H:i:s');
	
	$hour=date("H",strtotime($time));
	$hours=date("H",strtotime($time))-1;
	$a_h="06:00:00";
	$a_hs=$hour.":00:00";
	if(9<=$hours)
	{
		$sub=0.5;
	}
	else if(18<=$hours)
	{
		$sub=1;
	}
	else
	{
		$sub=0;
	}
	//echo $a_hs."--".$a_h."<br>";
	$time1 = new DateTime($a_h);
	$time2 = new DateTime($a_hs);
	$interval = $time1->diff($time2);
	$val= $interval->format('%H')-$sub;
	//echo $val;
	if(substr($hours,0,1)==0)
	{
		$hours=substr($hours,1);
	}
	if(substr($hour,0,1)==0)
	{
		$hour=substr($hour,1);
	}
	if($hours<13)
	{
		if($hours==12)
		{
			$var= $hours."-".($hour-12)." PM";
		}
		else
		{
			$var= $hours."-".$hour." AM";
		}	
	}
	else
	{
		$r=$hours-12;
		$rr=$hour-12;
		$var= $r."-".$rr." PM";
	}
	$hrs=array("6","7","8","9","10","11","12","13","14","15","16","17","18","19","20","21");	
	$hrs1=array("6-7AM","7-8AM","8-9AM","9-10AM","10-11AM","11-12PM","12-1PM","1-2PM","2-3PM","3-4PM","4-5PM","5-6PM","6-7PM","7-8PM","8-9PM","9-10PM");	
	//$hrs=array("6AM","7AM","8AM","9AM","10AM","11AM","12PM","1PM","2PM","3PM","4PM","5PM","6PM","7PM","8PM","9PM");	
	//echo"<h2>".$hours."-".$hour." Plan Vs Actual Performace</h2>";
	echo"<h2 style='background-color: MidnightBlue ;text-align: center;color:White; ' >".$var." Plan Vs Actual Performance</h2>";
	//echo "<h5><font color=\"red\"><b><u>Note:</u></b>Time Consider 15 minutes of each hour.";

	echo "<table border=\"1px\"><tr><td rowspan=\"2\">";
	echo "<table border =1px>";
	echo "<tr><td colspan=6><h5><font color=\"red\"><b><u>Note:</u></b> Considering 15 minutes of next hour.</td></tr>";
	echo "<tr><th colspan=6>Module Level performance</th></tr>";
	echo"<tr><th>Team No</th><th>Running Style</th><th>Plan PCS</th><th>Actual PCS</th><th>Variation</th><th>Achievement%</th></tr>";
	$sql="SELECT mod_no,sec_no,ROUND((SUM(plan_pro)/15)) AS plan_prod,ROUND((SUM(plan_sah)/15)) AS plan_sah,ROUND((SUM(plan_eff)/15)) AS plan_eff FROM $bai_pro.pro_plan WHERE DATE='".$date."' GROUP BY sec_no,mod_no ORDER BY mod_no*1";
	//echo $sql."<br>";
	$plan_pro=array();$plan_sah_hr=0;
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error=1".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		$module=$sql_row['mod_no'];
		$plan_pro[$module]=$sql_row['plan_prod'];
		//echo $module."--".$sql_row['plan_prod']."--*--".$val."<br>";
		$plan_prod_cum[$module]=round($sql_row['plan_prod']*$val);
		$plan_sah[$module]=$sql_row['plan_sah'];
		$plan_eff[$module]=$sql_row['plan_eff'];
		$plan_produ[$module]=round($sql_row['plan_prod']*$val);
	}
	//echo sizeof($plan_produ)."<br>";
	$plan_sah_hr=echo_title("$bai_pro.pro_plan","ROUND((SUM(plan_sah)/15))","DATE",$date,$link);
	$sql_source="SELECT section_id,buyer_div as buyer_id,GROUP_CONCAT(module_id order by module_id*1) as modules FROM $bai_pro3.plan_modules WHERE LENGTH(buyer_div)>0 and section_id not in (4) group by buyer_div order by buyer_div";
	//echo $sql_source."<br>";
	$sql_result1d=mysqli_query($link, $sql_source) or exit("Sql Errordd--2".mysqli_error($GLOBALS["___mysqli_ston"]));
	$mods=array();
	$buyer_name_ref=array();$acheivement_per_fac=0;
	$section=array();$modules=array();
	while($sql_row1d=mysqli_fetch_array($sql_result1d))
	{
		$buyer_name_ref[]=$sql_row1d["buyer_id"];
		$modules[]=$sql_row1d["modules"];
	}
	if($hours=='6')
	{
		$sql1="SELECT bundle_transactions_20_repeat_act_module as module,GROUP_CONCAT(DISTINCT bundle_transactions_20_repeat_bundle_id) AS bundles,SUM(bundle_transactions_20_repeat_quantity) AS act_out FROM $brandix_bts.view_set_1 WHERE DATE(bundle_transactions_date_time)='".$date."' AND TIME(bundle_transactions_date_time) < TIME('$hour:15:00') AND bundle_transactions_20_repeat_operation_id='4' GROUP BY bundle_transactions_20_repeat_act_module*1";
	
	}
	else
	{
		$sql1="SELECT bundle_transactions_20_repeat_act_module as module,GROUP_CONCAT(DISTINCT bundle_transactions_20_repeat_bundle_id) AS bundles,SUM(bundle_transactions_20_repeat_quantity) AS act_out FROM $brandix_bts.view_set_1 WHERE DATE(bundle_transactions_date_time)='".$date."' AND TIME(bundle_transactions_date_time)>= TIME('$hours:15:00') AND TIME(bundle_transactions_date_time)< TIME('$hour:15:00') AND bundle_transactions_20_repeat_operation_id='4' GROUP BY bundle_transactions_20_repeat_act_module*1";
	}
 	$sql_result1=mysqli_query($link, $sql1) or exit("Sql Errordd==3".mysqli_error($GLOBALS["___mysqli_ston"]));
	$act_out=array();
	while($sql_row1=mysqli_fetch_array($sql_result1))
	{
		$mod=$sql_row1["module"];
		$act_out[$mod]=$sql_row1["act_out"];
		$sql="SELECT GROUP_CONCAT(DISTINCT TRIM(style_ref.product_style) SEPARATOR ',') as style FROM tbl_miniorder_data AS tm LEFT JOIN tbl_min_ord_ref AS tr ON tm.mini_ordeR_ref=tr.id LEFT JOIN tbl_orders_style_ref AS style_ref ON tr.ref_product_style=style_Ref.id WHERE tm.bundle_number IN (".$sql_row1["bundles"].")";
		$sql_result=mysqli_query($link, $sql) or exit("Sql Errordd==4".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row=mysqli_fetch_array($sql_result))
		{
			$act_style[$mod]=$sql_row["style"];
		}
		
	}
	
		$act_sah_1=array();
		$a_sah=array();
		$a_out=array();
		$product=array();
		$sah=0;$qty=0;
		for($i=6;$i<=$hour;$i++)	
		{
			$hour_a=$i;
			$k=$i+1;
			$bundle_numbers=array();
			$sql121="SELECT bundle_transactions_20_repeat_bundle_id as bundles FROM $brandix_bts.`view_set_1` WHERE DATE(bundle_transactions_date_time)='".$date."' AND TIME(bundle_transactions_date_time) between TIME('$i:15:00') and  TIME('$k:15:00') AND bundle_transactions_20_repeat_operation_id='4' group by bundle_transactions_20_repeat_bundle_id";
			//echo $sql121."<br>";
			$sql_result121=mysqli_query($link, $sql121) or exit("Sql Errordd==6".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row121=mysqli_fetch_array($sql_result121))
			{
				$bundle_numbers[]=$sql_row121['bundles'];
			}
			if(sizeof($bundle_numbers)>0)
			{
				$sql12="SELECT $brandix_bts.tbl_orders_style_ref.product_style,$brandix_bts.tbl_orders_master.product_schedule,
				$brandix_bts.tbl_miniorder_data.color,$brandix_bts.bundle_transactions_20_repeat.bundle_id,SUM($brandix_bts.bundle_transactions_20_repeat.quantity) as qnty,
				ROUND(SUM(($brandix_bts.bundle_transactions_20_repeat.quantity * $bai_pro3.`bai_orders_db_confirm`.smv)/60),2) AS sah,$bai_pro3.`bai_orders_db_confirm`.smv AS smv FROM $brandix_bts.tbl_miniorder_data 
				LEFT JOIN $brandix_bts.bundle_transactions_20_repeat ON $brandix_bts.bundle_transactions_20_repeat.bundle_id=$brandix_bts.tbl_miniorder_data.bundle_number
				LEFT JOIN $brandix_bts.tbl_min_ord_ref ON $brandix_bts.tbl_min_ord_ref.id=$brandix_bts.tbl_miniorder_data.mini_order_ref 
				LEFT JOIN $brandix_bts.tbl_orders_master ON $brandix_bts.tbl_orders_master.id=$brandix_bts.tbl_min_ord_ref.ref_crt_schedule
				LEFT JOIN $brandix_bts.tbl_orders_style_ref ON $brandix_bts.tbl_orders_style_ref.id=$brandix_bts.tbl_min_ord_ref.ref_product_style
				LEFT JOIN $bai_pro3.bai_orders_db_confirm ON $brandix_bts.tbl_orders_style_ref.product_style=$bai_pro3.`bai_orders_db_confirm`.order_style_no 
				AND $brandix_bts.tbl_orders_master.product_schedule=$bai_pro3.bai_orders_db_confirm.order_del_no 
				AND $brandix_bts.tbl_miniorder_data.color=$bai_pro3.`bai_orders_db_confirm`.order_col_des 
				WHERE $brandix_bts.bundle_transactions_20_repeat.operation_id=4 AND $brandix_bts.tbl_miniorder_data.bundle_number
				IN (".implode(",", $bundle_numbers).") GROUP BY $brandix_bts.tbl_orders_style_ref.product_style,$brandix_bts.tbl_orders_master.product_schedule,
				$brandix_bts.tbl_miniorder_data.color";
				//echo $sql12."<br>";
				$sql_result12=mysqli_query($link, $sql12) or exit("Sql Errordd==6-1".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($sql_row12=mysqli_fetch_array($sql_result12))
				{
					$sah+=$sql_row12["sah"];
					$qty+=$sql_row12["qnty"];
				}
				//echo sizeof($bundle_numbers)."<br>";
				unset($bundle_numbers);
				//echo sizeof($bundle_numbers)."<br>";
			}
			else
			{
				$sah=0;
				$qty=0;
			}
			//echo $hour."=".$hours."=".$hour_a."<br>";
			if($hour==$hour_a)
			{
				//echo $a_sah[$hours]."-1-".$a_out[$hours]."<br>";
				$a_sah[$hours]+=$sah;
				$a_out[$hours]+=$qty;
				//echo $a_sah[$hours]."-2-".$a_out[$hours]."<br>";
			}
			else
			{
				$a_sah[$hour_a]=$sah;
				$a_out[$hour_a]=$qty;
				//echo "Test-".$sah."----".$qty."<br>";
			}
			unset($bundle_numbers);
			$sah=0;
			$qty=0;
			
		}
	
	for($x=0;$x<sizeof($hrs);$x++)
	{
		$check=$a_sah[$hrs[$x]];
		if($check>0)
		{
			//if($hrs[$x]==21)
			//{
				//$act_sah_1["Actual"][$hrs[$x]]=$a_sah['22']+$check;
			//}
			//else
			//{
				$act_sah_1["Actual"][$hrs[$x]]=$check;
			//}
		}
		else
		{
			$act_sah_1["Actual"][$hrs[$x]]=0;
		}
		if($hrs[$x]=='9' || $hrs[$x]=='18')
		{
			$act_sah_1["Plan"][$hrs[$x]]=$plan_sah_hr/2;
		}
		else
		{
			$act_sah_1["Plan"][$hrs[$x]]=$plan_sah_hr;
		}
			
	}

	
	$product=array("Plan","Actual");
	$buyer_name_ref_implode1="'".implode("','",$product)."'";
	$hour_ref_implode="'".implode("','",$hrs1)."'";
	$message='';	
	for($j=0;$j<sizeof($product);$j++)
	{
		$var='';
		$message.= "{";
		for($jj=0;$jj<sizeof($hrs);$jj++)
		{				
			if($hrs[$jj]<$hour)
			{
			
				$var.= $act_sah_1[$product[$j]][$hrs[$jj]].",";
			}
			//$var.= $act_sah_1[$product[$j]][$hrs[$jj]].",";
		}
			$val1=substr($var,0,-1);
			$message.= "name: '".$product[$j]."',";
			$message.= "data: [".$val1."]";
		
		$var='';	
		$val1='';
		if($j<1)
		{
			$message.= "},";		
		}
		else
		{
			$message.= "}";
		}			
		
	}
//echo $message."<br>";
	$grond_plan=0;
	$grond_act=0;
	$grond_vari=0;
	$tot_product=0;
	$acheivement_per=array();
	$acheivement_per1=array();
	$buyer_name_ref1=array();
	for($x=0;$x<sizeof($buyer_name_ref);$x++)
	{
		$total_product_plan=0;
		$total_product_act=0;
		$total_product_vari=0;
		$mods=explode(",",$modules[$x]);
		for($i=0;$i<sizeof($mods);$i++)
		{	
			$tot_product+=$plan_produ[$mods[$i]];
			echo"<tr>";
			echo"<td>Team-".$mods[$i]."</td>";
			//echo"<td>style-".$mods[$i]."</td>";
			if($act_style[$mods[$i]]=='')
			{
				echo"<td>0</td>";
			}
			else
			{
				echo"<td>".$act_style[$mods[$i]]."</td>";
			}
			echo"<td>".$plan_pro[$mods[$i]]."</td>";
			if($act_out[$mods[$i]]=='')
			{
				echo"<td>0</td>";	
			}
			else
			{
				echo"<td>".$act_out[$mods[$i]]."</td>";
			}
			$variance=$act_out[$mods[$i]]-$plan_pro[$mods[$i]];
			echo"<td>".$variance."</td>";
			if($act_out[$mods[$i]] > 0)
			{
				if(round($act_out[$mods[$i]]*100/div_by_zero($plan_pro[$mods[$i]]),0) <= 75)
				{
					$color1="#FF0000";
				}
				else if(round($act_out[$mods[$i]]*100/div_by_zero($plan_pro[$mods[$i]]),0) >= 76 and round($act_out[$mods[$i]]*100/div_by_zero($plan_pro[$mods[$i]]),0) <= 90 )
				{
					$color1="#FFFF00";
				}
				else
				{
					$color1="#008000";
				}
			}
			else
			{
				$color1="#FF0000";
				//$acheivement_per[]=0;
			}
			echo"<td bgcolor=\"".$color1."\">".round($act_out[$mods[$i]]*100/div_by_zero($plan_pro[$mods[$i]]),0)."%</td>";
			$total_product_plan+=$plan_pro[$mods[$i]];
			$total_product_act+=$act_out[$mods[$i]];
			$total_product_vari+=$variance;
		}
		$plan_prod_buyer[$buyer_name_ref[$x]]=$tot_product;
		$tot_product=0;
		echo"<tr>";
		echo"<th colspan=2>".$buyer_name_ref[$x]."</th>";
		echo"<th>".$total_product_plan."</th>";
		echo"<th>".$total_product_act."</th>";
		echo"<th>".$total_product_vari."</th>";
		$acheivement_per[]=round($total_product_act*100/div_by_zero($total_product_plan),0);
		if($total_product_act > 0)
		{
			if(round($total_product_act*100/div_by_zero($total_product_plan),0) <= 75)
			{
				$color="#FF0000";
			}
			else if(round($total_product_act*100/div_by_zero($total_product_plan),0) >= 76 and round($total_product_act*100/div_by_zero($total_product_plan),0) <= 90 )
			{
				$color="#FFFF00";
			}
			else
			{
				$color="#008000";
			}
		}
		else
		{
			$color="#FF0000";
			//$acheivement_per[]=0;
		}
		echo"<td bgcolor=\"".$color."\">".round($total_product_act*100/div_by_zero($total_product_plan),0)."%</td>";
		$total_product_plan1[]=$total_product_plan;
		$grond_plan+=$total_product_plan;
		$total_product_act1[]=$total_product_act;
		$grond_act+=$total_product_act;
		$total_product_vari1[]=$total_product_vari;
		$grond_vari+=$total_product_vari;
		//$var1=round($grond_act*100/$grond_plan,0)."%";
		//$var1=0;
			
	}
	echo"<tr>";
	echo"<th colspan=2>Grand Total</th>";
	echo"<td>".$grond_plan."</td>";
	echo"<td>".$grond_act."</td>";
	echo"<td>".$grond_vari."</td>";
	if($grond_act > 0)
	{
		if(round($grond_act*100/div_by_zero($grond_plan),0) <= 75)
		{
			$color5="#FF0000";
		}
		else if(round($grond_act*100/div_by_zero($grond_plan),0) >= 76 and round($grond_act*100/div_by_zero($grond_plan),0) <= 90 )
		{
			$color5="#FFFF00";
		}
		else
		{
			$color5="#008000";
		}
	}
	else
	{
		$color5="#FF0000";
		//$acheivement_per[]=0;
	}
	$total_product_plan1[]=$grond_plan;
	$total_product_act1[]=$grond_act;
	$total_product_vari1[]=$grond_vari;
	echo"<td bgcolor=\"".$color5."\">".round($grond_act*100/div_by_zero($grond_plan),0)."%</td><tr>";
	//$var=round($grond_act*100/$grond_plan,0)."%";
		
	//$var=0;
	$buyer_name_ref[]="Factory";
	$acheivement_per[]=round($grond_act*100/div_by_zero($grond_plan),0);
	$buyer_name_ref_implode="'".implode("','",$buyer_name_ref)."'";
	//$buyer_name_ref_implode1="'".implode("','",$buyer_name_ref1)."'";
	$acheivement_per_implode="".implode(",",$acheivement_per)."";
	//$acheivement_per_implode1="".implode(",",$acheivement_per1)."";
	
	
	//echo $buyer_name_ref_implode."-".$acheivement_per_implode."<br>";
	echo"</table>";
	
	echo"</td>";

	echo "<script src=\"highcharts.js\"></script>";
	echo"<script src=\"exporting.js\"></script>";

	echo"<script type=\"text/javascript\">
	$(function () {
		var chart;
		$(document).ready(function() {
			chart = new Highcharts.Chart({
				chart: {
					renderTo: 'container',
					type: 'line'
				},
				title: {
					align: 'center',
					text: 'Hourly Plan Vs Actual Factory SAH'
				},
				xAxis: {
					title: {
						text: 'Hours'
					},
					categories: [".$hour_ref_implode."]	
				},
				yAxis: {
					min: 0,
					title: {
						text: 'SAH'
					},
					stackLabels: {
						enabled: false,
						style: {
							fontWeight: 'bold',
							color: (Highcharts.theme && Highcharts.theme.textColor) || 'gray'
						}
					}
				},
				plotOptions: {
				line: {
					dataLabels: {
						enabled: true
					},
					enableMouseTracking: false
				}
			},
				exporting: {
				enabled: false
				},
				legend: {
					enabled: true,
					align: 'left',
					layout: 'horizontal',
					x: 800,
					verticalAlign: 'left',
					y: 0,
					floating: true,
					backgroundColor: (Highcharts.theme && Highcharts.theme.legendBackgroundColorSolid) || 'white',
					borderColor: '#CCC',
					borderWidth: 1,
					shadow: true
				},
			   
				plotOptions: {			
				   column: {
				   pointPadding: 0.0,
				   borderWidth: 2,
						dataLabels: {
							enabled: true
						}
					}
				},
				series: [".$message."]
			});
		});
		
	});
	</script>";
		
	echo"<script type=\"text/javascript\">
	$(function () {
		var chart;
		$(document).ready(function() {
			chart = new Highcharts.Chart({
				chart: {
					renderTo: 'container1',
					type: 'column'
				},
				title: {
					align: 'center',
					text: 'Hourly Product Wise Actual'
				},
				xAxis: {
					title: {
						text: 'Product'
					},
					categories: [".$buyer_name_ref_implode."]
				},
				yAxis: {
					min: 0,
					title: {
						text: 'Achievement%'
					},
					stackLabels: {
						enabled: false,
						style: {
							fontWeight: 'bold',
							color: (Highcharts.theme && Highcharts.theme.textColor) || 'gray'
						}
					}
				},
				exporting: {
				enabled: false
				},
				legend: {
					enabled: false,
					align: 'left',
					layout: 'horizontal',
					x: 305,
					verticalAlign: 'top',
					y: -10,
					floating: true,
					backgroundColor: (Highcharts.theme && Highcharts.theme.legendBackgroundColorSolid) || 'white',
					borderColor: '#CCC',
					borderWidth: 1,
					shadow: false
				},
			   
				plotOptions: {			
				   column: {
				   pointPadding: 0.0,
				   borderWidth: 2,
						dataLabels: {
							enabled: true
						}
					}
				},
				series: [{
					name: 'Achievement%',
					data: [".$acheivement_per_implode."]
				}]
			});
		});
		
	});
	</script>";

	echo "<td>";
	echo "<div id=\"container1\" style=\"width: 400px; height: 400px; margin: 0 auto\"></div>";

	echo "</td>";
	echo "<td>";
	$modules_cn=array();
	$sql131="select * from $bai_pro3.plan_modules where section_id in (1,2,3) order by module_id*1";
	$sql_result131=mysqli_query($link, $sql131) or exit("Sql Errordd==7".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($row131=mysqli_fetch_array($sql_result131))
	{
		$modules_cnt[]=$row131['module_id'];
	}
	$module_count=sizeof($modules_cnt);
	$total_half_mod=round($module_count/2);
	$next=$total_half_mod+1;
	echo "<table><tr><th colspan=2>Module Wise performance(Cumulative)</th></tr><tr><td>";
	echo "<table border=\"1px\">";
	echo "<tr><tr><th>Module</th><th>Plan</th><th>Actual</th><th>Var Qty</th><th>Per%</th></tr>";
	
	$sql11="SELECT bundle_transactions_20_repeat_act_module as module,SUM(bundle_transactions_20_repeat_quantity) AS quantity FROM $brandix_bts.`view_set_1` WHERE DATE(bundle_transactions_date_time)='".$date."' AND TIME(bundle_transactions_date_time)< TIME('$hour:15:00') AND bundle_transactions_20_repeat_operation_id='4' and bundle_transactions_20_repeat_act_module between 1 and $total_half_mod
	GROUP BY bundle_transactions_20_repeat_act_module ORDER BY bundle_transactions_20_repeat_act_module*1";
	 
	  //echo $sql11."<br>";
	 $sql_result11=mysqli_query($link, $sql11) or exit("Sql Errordd==8".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($row11=mysqli_fetch_array($sql_result11))
	{
		
		$total_product_act2=$row11['quantity'];
		$module=$row11['module'];
		$total_product_plan2=$plan_prod_cum[$module];
		$vari=$total_product_act2-$plan_prod_cum[$module];
		echo "<tr>";
		echo "<td>".$module."</td>";
		echo "<td>".$total_product_plan2."</td>";
		echo "<td>".$total_product_act2."</td>";
		echo "<td>".$vari."</td>";
		if($row11['quantity'] > 0)
		{
			if(round($total_product_act2*100/div_by_zero($total_product_plan2),0) <= 75)
			{
				$color21="#FF0000";
			}
			else if(round($total_product_act2*100/div_by_zero($total_product_plan2),0) >= 76 and round($total_product_act2*100/div_by_zero($total_product_plan2),0) <= 90 )
			{
				$color21="#FFFF00";
			}
			else
			{
				$color21="#008000";
			}
		}
		else
		{
			$color21="#FF0000";
			//$acheivement_per[]=0;
		}
		
		echo "<td bgcolor=\"".$color21."\">".round($total_product_act2*100/div_by_zero($total_product_plan2),0)."%</td>";
		echo "</tr>";
		
	}
	echo "</table>";
	echo "<td>";
	echo "<table border=\"1px\">";
	echo "<tr><tr><th>Module</th><th>Plan</th><th>Actual</th><th>Var Qty</th><th>Per%</th></tr>";
	$sql18="SELECT bundle_transactions_20_repeat_act_module as module,SUM(bundle_transactions_20_repeat_quantity) AS quantity FROM $brandix_bts.`view_set_1` WHERE DATE(bundle_transactions_date_time)='".$date."' AND TIME(bundle_transactions_date_time)< TIME('$hour:15:00') AND bundle_transactions_20_repeat_operation_id='4' and bundle_transactions_20_repeat_act_module between $next and $module_count GROUP BY bundle_transactions_20_repeat_act_module ORDER BY bundle_transactions_20_repeat_act_module*1";
	// echo $sql18."<br>";
	$sql_result18=mysqli_query($link, $sql18) or exit("Sql Errordd==9".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($row18=mysqli_fetch_array($sql_result18))
	{
		
		$total_product_act2=$row18['quantity'];
		$module=$row18['module'];
		$total_product_plan2=$plan_prod_cum[$module];
		$vari=$total_product_act2-$plan_prod_cum[$module];
		echo "<tr>";
		echo "<td>".$module."</td>";
		echo "<td>".$total_product_plan2."</td>";
		echo "<td>".$total_product_act2."</td>";
		echo "<td>".$vari."</td>";
		if($row18['quantity'] > 0)
		{
			if(round($total_product_act2*100/div_by_zero($total_product_plan2),0) <= 75)
			{
				$color21="#FF0000";
			}
			else if(round($total_product_act2*100/div_by_zero($total_product_plan2),0) >= 76 and round($total_product_act2*100/div_by_zero($total_product_plan2),0) <= 90 )
			{
				$color21="#FFFF00";
			}
			else
			{
				$color21="#008000";
			}
		}
		else
		{
			$color21="#FF0000";
			//$acheivement_per[]=0;
		}
		
		echo "<td bgcolor=\"".$color21."\">".round($total_product_act2*100/div_by_zero($total_product_plan2),0)."%</td>";
		echo "</tr>";
		
	}
	echo "</table>";
	echo "</tr></table>"; 
	echo "<table border=\"1px\">";
	echo "<tr><th colspan=5>Factory Level Performance(Cumulative)</th></tr><tr><th>Product</th><th>Plan Production</th><th>Actual Production</th><th>Variance Qty</th><th>Percentage</th></tr>";
	/*$sql1="select pm.buyer_div,sum(vt.bundle_transactions_20_repeat_quantity) as quantity FROM $brandix_bts.`view_set_snap_1_tbl` AS vt LEFT JOIN $bai_pro3.plan_modules AS pm ON pm.module_id=vt.bundle_transactions_20_repeat_act_module
	 WHERE DATE(bundle_transactions_date_time)='".$date."' and hour(bundle_transactions_date_time)<'".$hour."' AND bundle_transactions_20_repeat_operation_id='4' 
	 GROUP BY pm.buyer_div order by pm.buyer_div";*/
	$sql1="SELECT pm.buyer_div,SUM(vt.bundle_transactions_20_repeat_quantity) AS quantity FROM $brandix_bts.`view_set_1` AS vt 
		LEFT JOIN $bai_pro3.plan_modules AS pm ON pm.module_id=vt.bundle_transactions_20_repeat_act_module
		WHERE DATE(vt.bundle_transactions_date_time)='".$date."' AND TIME(bundle_transactions_date_time)< TIME('$hour:15:00') AND vt.bundle_transactions_20_repeat_operation_id='4' GROUP BY pm.buyer_div ORDER BY pm.buyer_div";

	$sql_result1=mysqli_query($link, $sql1) or exit("Sql Errordd==10".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($row=mysqli_fetch_array($sql_result1))
	{
		//$total_product_plan2=23000;
		//$modules=echo_title("$bai_pro3.plan_modules","count(*)","buyer_div",$$row['buyer_div'],$link);
		$total_product_act2=$row['quantity'];
		$total_product_plan2=$plan_prod_buyer[$row['buyer_div']];
		$vari=$total_product_act2-$total_product_plan2;
		echo "<tr>";
		echo "<td>".$row['buyer_div']."</td>";
		echo "<td>".$total_product_plan2."</td>";
		echo "<td>".$total_product_act2."</td>";
		echo "<td>".$vari."</td>";
		if($row['quantity'] > 0)
		{
			if(round($total_product_act2*100/div_by_zero($total_product_plan2),0) <= 75)
			{
				$color2="#FF0000";
			}
			else if(round($total_product_act2*100/div_by_zero($total_product_plan2),0) >= 76 and round($total_product_act2*100/div_by_zero($total_product_plan2),0) <= 90 )
			{
				$color2="#FFFF00";
			}
			else
			{
				$color2="#008000";
			}
		}
		else
		{
			$color2="#FF0000";
			//$acheivement_per[]=0;
		}
		
		echo "<td bgcolor=\"".$color2."\">".round($total_product_act2*100/div_by_zero($total_product_plan2),0)."%</td>";
		echo "</tr>";
		$grand_plan+=$total_product_plan2;
		$grand_act+=$total_product_act2;
		$grand_vari+=$vari;
	}
	echo"<tr><td>Factory</td><td>".$grand_plan."</td><td>".$grand_act."</td><td>".$grand_vari."</td>";
	if($grand_act > 0)
	{
		if(round($grand_act*100/div_by_zero($grand_plan),0) <= 75)
		{
			$color3="#FF0000";
		}
		else if(round($grand_act*100/div_by_zero($grand_plan),0) >= 76 and round($grand_act*100/div_by_zero($grand_plan),0) <= 90 )
		{
			$color3="#FFFF00";
		}
		else
		{
			$color3="#008000";
		}
	}
	else
	{
		$color3="#FF0000";
		//$acheivement_per[]=0;
	}
	echo "<td bgcolor=\"".$color3."\">".round($grand_act*100/div_by_zero($grand_plan),0)."%</td>";		
	echo "</tr>";
	echo "</table>";
	echo "<br><br>";
	
	echo "</td></tr>";
	echo "<tr><td colspan=\"3\">";
	echo "<div id=\"container\" style=\"width: 970px; height: 400px; margin: 0 auto\"></div>";
	echo "</td></tr>";
	echo "</table>";
}
?>
<body>
</html>
<style>

#table1 {
  display: inline-table;
  width: 100%;
}


div#table_div {
    width: 30%;
}
#test{
margin-left:8%;
margin-bottom:2%;
}
</style>