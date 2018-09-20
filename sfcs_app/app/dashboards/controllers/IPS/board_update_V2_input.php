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


<?php

//New Implementation to restrict as per time lines to update Planning Board 20111211
	/* $hour=date("H");
	$restricted_hours=array(7,8,9,15,16);
	if(in_array($hour,$restricted_hours))
	{
		header("Location:time_out.php?msg=2");
	} */
	
	$hour=date("H.i");
		
	//if(($hour>=7.45 and $hour<=10.00) or ($hour>=15.15 and $hour<=16.45)) //OLD
	if(($hour>=7.45 and $hour<=9.45) or ($hour>=12.30 and $hour<=14.00) or ($hour>=16.00 and $hour<=17.30))
	//if(($hour>=7.15 and $hour<=9.45) or ($hour>=15.15 and $hour<=17.15))
	{
		//header("Location:time_out.php?msg=2");
	}
	else
	{
		
	}
	
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

echo "<table>";
echo "<tr><th style='background-color:red;' colspan=10 >Production Plan for Section - $section_no</th><th style='background-color:red;' colspan=20 style='text-align:left;'>Date : ".date("Y-m-d H:i")."</th></tr>";
echo "<tr><th>Mod#</th><th>Legend</th><th>Priority 1</th><th>Remarks</th><th>Priority 2</th><th>Remarks</th><th>Priority 3</th><th>Remarks</th><th>Priority 4</th><th>Remarks</th><th>Priority 5</th><th>Remarks</th><th>Priority 6</th><th>Remarks</th><th>Priority 7</th><th>Remarks</th><th>Priority 8</th><th>Remarks</th><th>Priority 9</th><th>Remarks</th><th>Priority 10</th><th>Remarks</th><th>Priority 11</th><th>Remarks</th><th>Priority 12</th><th>Remarks</th><th>Priority 13</th><th>Remarks</th><th>Priority 14</th><th>Remarks</th></tr>";
//echo "<tr><th>Mod#</th><th>Legend</th><th>Priority 1</th><th>Remarks</th><th>Priority 2</th><th>Remarks</th><th>Priority 3</th><th>Remarks</th><th>Priority 4</th><th>Remarks</th><th>Priority 5</th><th>Remarks</th><th>Priority 6</th><th>Remarks</th><th>Priority 7</th><th></th><th>Priority 8</th><th></th><th>Priority 9</th><th></th><th>Priority 10</th><th></th><th>Priority 11</th><th></th><th>Priority 12</th><th></th><th>Priority 13</th><th></th><th>Priority 14</th><th></th></tr>";
$newtempname="plan_doc_summ_input_".$username;

$sql="DROP TABLE IF EXISTS temp_pool_db.$newtempname";
//echo $sql."<br/>";
mysqli_query($link, $sql) or exit("Sql Error17".mysqli_error($GLOBALS["___mysqli_ston"]));

//$sql="CREATE  TABLE temp_pool_db.$newtempname ENGINE = MYISAM SELECT MIN(st_status) AS st_status,order_style_no,input_job_no_random,GROUP_CONCAT(DISTINCT order_del_no) AS order_del_no,GROUP_CONCAT(DISTINCT input_job_no) AS input_job_no,GROUP_CONCAT(DISTINCT doc_no) AS doc_no FROM plan_doc_summ_input GROUP BY input_job_no_random";
$sql="CREATE  TABLE temp_pool_db.$newtempname ENGINE = myisam SELECT st_status,act_cut_status,doc_no,order_style_no,order_del_no,order_col_des,carton_act_qty AS total,input_job_no AS acutno,GROUP_CONCAT(DISTINCT CHAR(color_code)) AS color_code,input_job_no,input_job_no_random,input_job_no_random_ref FROM $bai_pro3.plan_dash_doc_summ_input GROUP BY input_job_no_random_ref ORDER BY input_priority";
if($username='ber_databasesvc'){
	//echo $sql."<br/>";
}


mysqli_query($link, $sql) or exit("Sql Error16".mysqli_error($GLOBALS["___mysqli_ston"]));

$sqlx="select * from $bai_pro3.sections_db where sec_id>0 and sec_id=$section_no";
if($username=='ber_databasesvc'){
	//echo $sqlx."<br/>";
}
mysqli_query($link, $sqlx) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_resultx=mysqli_query($link, $sqlx) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_rowx=mysqli_fetch_array($sql_resultx))
{
	$section=$sql_rowx['sec_id'];
	$section_head=$sql_rowx['sec_head'];
	$section_mods=$sql_rowx['sec_mods'];
	
	$mods=array();
	$mods=explode(",",$section_mods);
	// if($username=='ber_databasesvc'){
		// echo $section_mods."<br/>";
	// }
	for($x=0;$x<sizeof($mods);$x++)
	{
		echo "<tr>";
		echo "<td>".$mods[$x]."</td>";
		echo "<td align=\"right\">Style:<br/>Schedule:<br/>Sewing Job:<br/>Cut Job:<br/>Total Qty:<br/></td>";
		$module=$mods[$x];
		
		$sql1="SELECT input_job_no_random_ref,input_module,input_priority,input_trims_status,input_panel_status,track_id,input_job_no,tid,input_job_no_random,
order_tid,doc_no,acutno,act_cut_status,'' as act_cut_issue_status,a_plies,p_plies,color_code,order_style_no,order_del_no,order_col_des,ft_status,st_status,pt_status,
trim_status,category,clubbing,plan_module,cat_ref,emb_stat1,SUM(carton_act_qty) as carton_act_qty FROM $bai_pro3.plan_dash_doc_summ_input WHERE input_module=$module and (input_trims_status!=4 or input_trims_status IS NULL or input_panel_status!=2 or input_panel_status IS NULL) GROUP BY input_job_no_random_ref ORDER BY input_priority ASC LIMIT 14";
	if($username=='ber_databasesvc'){
		//echo $sql1."<br/>";
	}
		
		mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql_num_check=mysqli_num_rows($sql_result1);
		while($sql_row1=mysqli_fetch_array($sql_result1))
		{
			$cut_new=$sql_row1['act_cut_status'];
			$cut_input_new=$sql_row1['act_cut_issue_status'];
			//$rm_new=strtolower(chop($sql_row1['rm_date']));
			//$rm_update_new=strtolower(chop($sql_row1['rm_date']));
			$rm_new="111";
			$rm_update_new="222";
			$input_temp=strtolower(chop($sql_row1['cut_inp_temp']));
			$doc_no=$sql_row1['doc_no'];
			$order_tid=$sql_row1['order_tid'];
			$fabric_status=$sql_row1['fabric_status_new'];
			//$fabric_status="333";
			$input_job_no_random_ref=$sql_row1["input_job_no_random_ref"];
			$style=$sql_row1['order_style_no'];
			$schedule=$sql_row1['order_del_no'];
			$color=$sql_row1['order_col_des'];
			$total_qty=$sql_row1['carton_act_qty'];
			
			$cut_no=$sql_row1['acutno'];
			$color_code=$sql_row1['color_code'];
			$jobno=$sql_row1['input_job_no'];
			$display_prefix1 = get_sewing_job_prefix("prefix","$brandix_bts.tbl_sewing_job_prefix","$bai_pro3.packing_summary_input",$schedule,$color,$jobno,$link);
			if($display_prefix1=='J'){
				$display_prefix1='';
			}
			
			$bundle_location="";
			if(sizeof(explode("$",$sql_row1['bundle_location']))>1)
			{
				$bundle_location=end(explode("$",$sql_row1['bundle_location']));
			}
			$fabric_location="";
			if(sizeof(explode("$",$sql_row1['plan_lot_ref']))>1)
			{
				$fabric_location=end(explode("$",$sql_row1['plan_lot_ref']));
			}
			
			if($cut_new=="DONE"){ $cut_new="T";} else { $cut_new="F"; }
			if($rm_update_new==""){ $rm_update_new="F"; } else { $rm_update_new="T"; }
			if($rm_new=="0000-00-00 00:00:00" or $rm_new=="") { $rm_new="F"; } else { $rm_new="T";	}
			if($input_temp==1) { $input_temp="T";	} else { $input_temp="F"; }
			if($cut_input_new=="DONE") { $cut_input_new="T";	} else { $cut_input_new="F"; }
			
			$check_string=$cut_new.$rm_update_new.$rm_new.$input_temp.$cut_input_new;
			$rem="Nil";
			
			$sql3="select DISTINCT(SUBSTRING_INDEX(order_joins,'J',-1)) AS order_joins from $bai_pro3.packing_summary_input WHERE input_job_no_random=\"".$input_job_no_random_ref."\"";
			//echo $sql3."<br>";
			$result3=mysqli_query($link, $sql3) or exit("Sql Error7".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($row3=mysqli_fetch_array($result3))
			{
				$clubbed_schedule_ref=$row3['order_joins'];
			}
			
			$sql2="SELECT min(st_status) as st_status,order_style_no,group_concat(distinct order_del_no) as order_del_no,group_concat(distinct input_job_no) as input_job_no,group_concat(distinct doc_no) as doc_no FROM $temp_pool_db.$newtempname WHERE input_job_no_random='$input_job_no_random_ref'";	
			//$sql2="SELECT min(st_status) as st_status,order_style_no,group_concat(distinct order_del_no) as order_del_no,group_concat(distinct input_job_no) as input_job_no,group_concat(distinct doc_no) as doc_no FROM plan_doc_summ_input WHERE input_job_no_random='$input_job_no_random_ref'";	
			if($username=='ber_databasesvc'){
				//echo $sql2."<br>";
			}
			
			$result2=mysqli_query($link, $sql2) or exit("Sql Error6".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($row2=mysqli_fetch_array($result2))
			{
				$trims_status=$row2['st_status'];
				$style=$row2['order_style_no'];
				$schedule=$row2['order_del_no'];
				$input_job_no=$row2['input_job_no'];
				$doc_no_ref=$row2['doc_no'];
				$schedule_no=$row2['order_del_no'];
			}
			
			if($clubbed_schedule_ref > 0)
			{
				$schedule=$clubbed_schedule_ref;
				$sql_doc="select group_concat(doc_no) as doc_ref from $bai_pro3.plandoc_stat_log where order_tid like \"% ".$clubbed_schedule_ref."%\"";
				$result_doc=mysqli_query($link, $sql_doc) or exit("Sql Error6".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($row_doc=mysqli_fetch_array($result_doc))
				{
					$doc_no_ref=$row_doc["doc_ref"];
				}
			}
			if($fabric_status!=5)
			{
				$fabric_status=$sql_row1['ft_status'];
				
				//To get the status of join orders
				$sql11="select ft_status from $bai_pro3.bai_orders_db_confirm where order_del_no=\"$schedule\" and order_joins=2";
				$sql_result11=mysqli_query($link, $sql11) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				
				if(mysqli_num_rows($sql_result11)>0)
				{
					$sql11="select ft_status from $bai_pro3.bai_orders_db_confirm where order_joins=\"J$schedule\"";
					$sql_result11=mysqli_query($link, $sql11) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
					while($sql_row11=mysqli_fetch_array($sql_result11))
					{
						$join_ft_status=$sql_row11['ft_status'];
						if($sql_row11['ft_status']==0 or $sql_row11['ft_status']>1)
						{
							break;
						}
					}
					
					$fabric_status=$join_ft_status;
				}
				//To get the status of join orders
			}
			//NEW FSP
			$doc_no_ref_explode=explode(",",$doc_no_ref);
			
			$num_docs=sizeof($doc_no_ref_explode);
				
			switch ($fabric_status)
			{
				case "1":
				{
					$id="yellow";
					if($fab_wip>$cut_wip_control)
					{
						$id="lgreen";
						$pop_restriction=1;
					}
					
					$rem="Available";
					break;
				}
				case "0":
				{
					$id="red";
					$rem="Not Available";
					break;
				}
				case "2":
				{
					$id="red";
					$rem="In House Issue";
					break;
				}
				case "3":
				{
					$id="red";
					$rem="GRN issue";
					break;
				}
				case "4":
				{
					$id="red";
					$rem="Put Away Issue";
					break;
				}		
				case "5":
				{
					$sql1x1="select doc_ref from $bai_pro3.fabric_priorities where doc_ref=$doc_no and hour(issued_time)+minute(issued_time)>0";
					$sql_result1x1=mysqli_query($link,$sql1x1) or exit("Sql Error".mysql_error());
					if(mysqli_num_rows($sql_result1x1)>0)
					{
						$id="yellow";
					}
					else
					{
						$id="green";
					}
					break;
				}				
				default:
				{
					$id="yash";
					$rem="Not Update";
					break;
				}
			}
			
			if($cut_new=="T")
			{
				$id="blue";
			}
			$sqly="SELECT group_concat(doc_no) as doc_no,sum(carton_act_qty) as carton_qty FROM $bai_pro3.packing_summary_input WHERE input_job_no_random='".$input_job_no_random_ref."' ORDER BY acutno";
			//echo $sqly."<br>";
			$resulty=mysqli_query($link, $sqly) or die("Error=$sqly".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_rowy=mysqli_fetch_array($resulty))
			{
				$doc_no_ref_input=$sql_rowy["doc_no"];
				$carton_qty=$sql_rowy["carton_qty"];
			}
			
			$sql11x="select * from $bai_pro3.fabric_priorities where doc_ref in ('".$doc_no_ref_input."')";
			//echo $sql11x."<br>";
			$sql_result11x=mysqli_query($link, $sql11x) or exit("Sql Error9".mysqli_error($GLOBALS["___mysqli_ston"]));
			if(mysqli_num_rows($sql_result11x)==$num_docs)
			{
				$id="green";	
			} 
			
			$sql1x1="select * from $bai_pro3.fabric_priorities where doc_ref in ('".$doc_no_ref_input."') and hour(issued_time)+minute(issued_time)>0";
			//echo $sql1x1."<br>";
			$sql_result1x1=mysqli_query($link, $sql1x1) or exit("Sql Error8".mysqli_error($GLOBALS["___mysqli_ston"]));
			//if(mysql_num_rows($sql_result1x1)==$num_docs)
			//echo $sql1x1."-".mysql_num_rows($sql_result1x1)."<br>";
			if(mysqli_num_rows($sql_result1x1)>0)
			{
				$id="yellow";
			}
			
			
			$sql11x1="select * from $bai_pro3.plandoc_stat_log where doc_no in ('".$doc_no_ref_input."') and act_cut_status=\"DONE\"";
			//echo $sql11x1."<br>";
			$sql_result11x1=mysqli_query($link, $sql11x1) or exit("Sql Error10".mysqli_error($GLOBALS["___mysqli_ston"]));
			if(mysqli_num_rows($sql_result11x1)>0)
			{
				$id="blue";
			} 
			
			
			//For Color Clubbing
			$club_c_code=array();
					$sql33x1="SELECT * FROM $bai_pro3.plan_dash_doc_summ where doc_no in (".$doc_no_ref_input.") order by doc_no*1";
					$sql_result33x1=mysqli_query($link, $sql33x1) or exit("Sql Error10".mysqli_error($GLOBALS["___mysqli_ston"]));
					while($sql_row33x1=mysqli_fetch_array($sql_result33x1))
					{
						$club_c_code[]=chr($sql_row33x1['color_code']).leading_zeros($sql_row33x1['acutno'],3);
					}			
					$club_c_code=array_unique($club_c_code);
			
			
			$ex_factory="NIP";
			$sql11="select order_date as ex_factory_date_new from $bai_pro3.bai_orders_db where order_del_no='$schedule'";
			//echo $sql11."<br/>";
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
			//echo "<td>"."Style:".$style."<br/>"."Schedule:".$schedule."<br/>"."Job:".chr($color_code).leading_zeros($cut_no,3)."<br/>"."Total Qty:".$total_qty."</td><td></td>";
			//echo "<td>".$style."<br/><strong>".$schedule."<br/>J".leading_zeros($jobno,3)."</strong><br/>".$total_qty."</td><td>F.L.: $fabric_location<Br/>B.L.: $bundle_location</br>Col:".strtoupper($id)."</br></td>";
	
			if($schedule!=''){
			
			//echo "<td >".$style."<br/><strong>".$schedule."<br/>".$display_prefix1."</strong><br/>".$total_qty."<br/></td><td></td>";
			echo "<td>".$style."<br/><strong>".$schedule."<br/>".$display_prefix1."</strong><br/>".implode(", ",$club_c_code)."<br/>".$total_qty."</td><td>F.L.: $fabric_location / B.L.: $bundle_location</br>Col:".strtoupper($id)."</br><b>Ex-FT: $ex_factory</b><br/><b>DID: $doc_no</b></td>";

		
		}
			

			
		}
		
		for($i=1;$i<=14-$sql_num_check;$i++)
		{
			echo "<td></td><td></td>";
		}
		echo "</tr>";
	}
}

echo "</table>";
echo "Legend: NIP=Not in Plan; DID=Docket ID; F.L=Fabric Location; B.L=Bundle Location; Blue Background: Current Week Deliveries; Red Background: Today Ex-factory."

?>
</body>
<script>
	document.getElementById("msg").style.display="none";		
</script>
</html>
