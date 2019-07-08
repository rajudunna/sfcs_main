<!--
Core Module:In this interface we can get module wise plan details for fabric issuing priority.

Description: We can allocate fabric based on the plan priority.

Changes Log:
-->

<?php
set_time_limit(2000);
include("../../../../common/config/config.php");
include("../../../../common/config/functions.php");
error_reporting(0);
$section_no=$_GET['section_no'];
?>

<html>
<head>

<title>Board Update</title>

<link rel="stylesheet" type="text/css" href= "../../common/css/page_style.css" />
<style>
body
{
	font-family: Century Gothic;
	font-size: 14px;
}
table{
	font-size:10px;
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
  background-color: #339900;
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
  background-color: #339900;
  
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
</head>

<body>
<h2><font color="blue">Input Job Plan Details</font></h2>
<?php
echo "<div id=\"msg\"><center><br/><br/><br/><h1><font color=\"blue\">Please wait while preparing dashboard...</font></h1></center></div>";
ob_end_flush();
flush();
usleep(1);
$sqlx1="SELECT section_display_name FROM $bai_pro3.sections_master WHERE sec_name=$section_no";
$sql_resultx1=mysqli_query($link, $sqlx1) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_rowx1=mysqli_fetch_array($sql_resultx1))
{
	$section_display_name=$sql_rowx1['section_display_name'];
}
echo "<table>";
echo "<tr><th style='background-color:red;' colspan=10 >Production Plan for $section_display_name</th><th style='background-color:red;' colspan=20 style='text-align:left;'>Date : ".date("Y-m-d H:i")."</th></tr>";
echo "<tr><th>Mod#</th><th>Legend</th><th>Priority 1</th><th>Remarks</th><th>Priority 2</th><th>Remarks</th><th>Priority 3</th><th>Remarks</th><th>Priority 4</th><th>Remarks</th><th>Priority 5</th><th>Remarks</th><th>Priority 6</th><th>Remarks</th><th>Priority 7</th><th>Remarks</th><th>Priority 8</th><th>Remarks</th><th>Priority 9</th><th>Remarks</th><th>Priority 10</th><th>Remarks</th><th>Priority 11</th><th>Remarks</th><th>Priority 12</th><th>Remarks</th><th>Priority 13</th><th>Remarks</th><th>Priority 14</th><th>Remarks</th></tr>";

$sqlx="SELECT GROUP_CONCAT(`module_name` ORDER BY module_name+0 ASC) AS sec_mods FROM $bai_pro3.`module_master` where section=$section_no GROUP BY section";
$sql_resultx=mysqli_query($link, $sqlx) or exit("Sql Error3".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_rowx=mysqli_fetch_array($sql_resultx))
{
	$section_mods=$sql_rowx['sec_mods'];
	$mods=array();
	$mods=explode(",",$section_mods);
	for($x=0;$x<sizeof($mods);$x++)
	{
		echo "<tr>";
		echo "<td>".$mods[$x]."</td>";
		echo "<td align=\"right\">Style:<br/>Schedule:<br/>Sewing Job:<br/>Cut Job:<br/>Job Qty:<br/></td>";
		$module=$mods[$x];		
		$sql1="SELECT type_of_sewing,input_job_no_random_ref,input_module,input_priority,input_trims_status,input_panel_status,track_id,input_job_no,tid,input_job_no_random,order_tid,group_concat(doc_no) as doc_no,color_code,order_style_no,order_del_no,GROUP_CONCAT(DISTINCT trim(order_col_des)) AS order_col, order_col_des,ft_status,st_status,pt_status,trim_status,SUM(carton_act_qty) as carton_act_qty FROM $bai_pro3.plan_dash_doc_summ_input WHERE input_module=$module and (input_trims_status!=4 or input_trims_status IS NULL or input_panel_status!=2 or input_panel_status IS NULL) GROUP BY input_job_no_random_ref ORDER BY input_priority ASC LIMIT 14";
		$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error22".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql_num_check=mysqli_num_rows($sql_result1);
		while($sql_row1=mysqli_fetch_array($sql_result1))
		{
			$doc_no_ref=$sql_row1['doc_no'];
			$order_tid=$sql_row1['order_tid'];
			$input_job_no_random_ref=$sql_row1["input_job_no_random_ref"];
			$style=$sql_row1['order_style_no'];
			$schedule=$sql_row1['order_del_no'];
			$order_cols=$sql_row1['order_col'];
			$color=$sql_row1['order_col_des'];
			$total_qty=$sql_row1['carton_act_qty'];
			$jobno=$sql_row1['input_job_no'];
			$type_of_sewing=$sql_row1['type_of_sewing'];
			$ft_status=$sql_row1['ft_status'];
			// $bundle_location="";
			// if(sizeof(explode("$",$sql_row1['bundle_location']))>1)
			// {
				// $bundle_location=end(explode("$",$sql_row1['bundle_location']));
			// }
			// $fabric_location="";
			// if(sizeof(explode("$",$sql_row1['plan_lot_ref']))>1)
			// {
				// $fabric_location=end(explode("$",$sql_row1['plan_lot_ref']));
			// }
			$cols=explode(",",$order_cols);
			for($i=0;$i<sizeof($cols);$i++)
			{				
				$order_col .= $cols[$i]."<br>";
			}
			$sql="SELECT prefix as result FROM $brandix_bts.tbl_sewing_job_prefix WHERE type_of_sewing='$type_of_sewing'";
			$sql_result=mysqli_query($link, $sql) or exit($sql."Sql Error-echo_1<br>".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row=mysqli_fetch_array($sql_result))
			{
				$prefix = $sql_row['result'];
			}
			$display_prefix1=$prefix.leading_zeros($jobno,3);

			$sql1x1="select * from $bai_pro3.plandoc_stat_log where act_cut_status<>'DONE' and doc_no in ($doc_no_ref)";
			$sql_result1x1=mysqli_query($link, $sql1x1) or exit("Sql Error8".mysqli_error($GLOBALS["___mysqli_ston"]));
					
			if(mysqli_num_rows($sql_result1x1)>0)
			{
				$cut_status="0";
			}
			else
			{
				$cut_status="5";
			}
			
			$fabric_status="";
			$sql1x11="select * from $bai_pro3.plandoc_stat_log where fabric_status<>'5' and doc_no in ($doc_no_ref)";
			$sql_result1x11=mysqli_query($link, $sql1x11) or exit("Sql Error8".mysqli_error($GLOBALS["___mysqli_ston"]));
			if(mysqli_num_rows($sql_result1x11)>0)
			{
				$fabric_status="0";
			}
			else
			{
				$fabric_status="5";
			}
			
			$sql1x12="select * from $bai_pro3.plan_dashboard where fabric_status='1' and doc_no in ($doc_no_ref)";
			$sql_result1x12=mysqli_query($link, $sql1x12) or exit("Sql Error9".mysqli_error($GLOBALS["___mysqli_ston"]));
			if(mysqli_num_rows($sql_result1x12)>0)
			{
				$fabric_status="1";
			}
			
			$sql1x115="select * from $bai_pro3.fabric_priorities where doc_ref in ($doc_no_ref)";
			$sql_result1x115=mysqli_query($link, $sql1x115) or exit("Sql Error8".mysqli_error($GLOBALS["___mysqli_ston"]));
			if(mysqli_num_rows($sql_result1x115)>0)
			{
				if(sizeof(explode(",",$doc_no_ref))<>mysqli_num_rows($sql_result1x115))
				{
					$fabric_req="0";
				}
				else
				{
					$fabric_req="5";
				}	
			}
			else
			{
				$fabric_req="0";
			}
			if($cut_status=="5")
			{
				$id="blue";					
			}
			elseif($fabric_status=='5')
			{
				$id="yellow";					
			}
			elseif($fabric_status=='1')
			{
				$id="pink";					
			}
			elseif($fabric_req=="5")
			{
				$id="green";					
			}
			elseif($fabric_status<"5")
			{
				switch ($ft_status)
				{
					case "1":
					{
						$id="lgreen";					
						break;
					}
					case "0":
					{
						$id="red";
						break;
					}
					case "2":
					{
						$id="red";
						break;
					}
					case "3":
					{
						$id="red";
						break;
					}
					case "4":
					{
						$id="red";
						break;
					}									
					default:
					{
						$id="yash";
						break;
					}
				}
			}
			else
			{
				$id="yash";
			}
			if($id=="blue" || $id=="yellow")
			{
				$application='IPS';
				$scanning_query=" select * from $brandix_bts.tbl_ims_ops where appilication='$application'";
				$scanning_result=mysqli_query($link, $scanning_query)or exit("scanning_error".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($sql_row=mysqli_fetch_array($scanning_result))
				{
					$operation_code=$sql_row['operation_code'];
				}
				$cut_input_report_query="select sum(original_qty) as cut_qty,sum(recevied_qty+rejected_qty) as report_qty,sum(recevied_qty) as recevied_qty from brandix_bts.bundle_creation_data where input_job_no_random_ref='$input_job_no_random_ref' and operation_id='".$operation_code."'";
				$cut_input_report_result=mysqli_query($link, $cut_input_report_query)or exit("scanning_error".mysqli_error($GLOBALS["___mysqli_ston"]));

				while($sql_row=mysqli_fetch_array($cut_input_report_result))
				{
					$cut_origional_qty=$sql_row['cut_qty'];
					$report_origional_qty=$sql_row['report_qty'];
					$recevied_qty=$sql_row['recevied_qty'];									
				}
				
				if(($cut_origional_qty > $report_origional_qty) && $recevied_qty>0){
					$id='orange';
				}
			}
			//For Color Clubbing
			$club_c_code=array();
			$sql33x1="SELECT color_code,acutno FROM $bai_pro3.order_cat_doc_mk_mix where doc_no in (".$doc_no_ref.") order by doc_no*1";
			$sql_result33x1=mysqli_query($link, $sql33x1) or exit("Sql Error10".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row33x1=mysqli_fetch_array($sql_result33x1))
			{
				$club_c_code[]=chr($sql_row33x1['color_code']).leading_zeros($sql_row33x1['acutno'],3);			
			}	
			
			$club_c_code=array_unique($club_c_code);
			$ex_factory="NIP";
			$sql11="select order_date as ex_factory_date_new from $bai_pro3.bai_orders_db where order_del_no='$schedule'";
			$sql_result11=mysqli_query($link,$sql11) or exit("Sql Error".mysqli_error());
			while($sql_row11=mysqli_fetch_array($sql_result11))
			{
				$ex_factory=date("M/d",strtotime($sql_row11['ex_factory_date_new']));				
				if(date("W",strtotime($sql_row11['ex_factory_date_new']))==date("W"))
				{
					$ex_factory="<span style=\"background-color:blue; color:white;\">$ex_factory</span>";
				}
				
				if($ex_factory==date("M/d"))
				{
					$ex_factory="<span style=\"background-color:blue; color:white;\">$ex_factory</span>";
				}								
			}
			
			if($schedule!='')
			{			
				echo "<td>".$style."<br/><strong>".$schedule."<br/>".$display_prefix1."</strong><br/>".implode(", ",$club_c_code)."<br/>".$total_qty."</td><td><b>Back Col</b>:".strtoupper($id)."</br><b>Col</b>:".strtoupper($order_col)."</br><b>Ex-FT: $ex_factory</b><br/><b>DID: ".$doc_no_ref."</b></td>";
			}
			$order_col="";
		}		
		for($i=1;$i<=14-$sql_num_check;$i++)
		{
			echo "<td></td><td></td>";
		}
		echo "</tr>";
	}
}
echo "</table>";
//echo "Legend: NIP=Not in Plan; DID=Docket ID; F.L=Fabric Location; B.L=Bundle Location; Blue Background: Current Week Deliveries; Red Background: Today Ex-factory."
echo "Legend: NIP=Not in Plan; DID=Docket ID; Back Col = Box Background Color in IPS; Col= No of Colors in Sewing job;Ex-FT = Ex factory date."

?>
</body>
<script>
	document.getElementById("msg").style.display="none";		
</script>
</html>
