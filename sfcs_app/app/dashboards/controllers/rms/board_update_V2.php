<!--
Core Module:In this interface we can get module wise plan details for fabric issuing priority.

Description: We can allocate fabric based on the plan priority.

Changes Log:
-->

<?php ini_set('error_reporting', E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED); ?>
<?php
set_time_limit(2000);
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config.php'); 
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/functions.php'); 
// include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',4,'R')); 
// include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/functions.php',4,'R'));
// echo $_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config.php';
// include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/functions.php',4,'R'));
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



<style>
body
{
	/* font-family: Century Gothic;
	font-size: 10px; */
}
table{
	font-size:10px;
}
</style>


<div class="panel panel-primary">
<div class="panel-heading">Board Update</div>
<div class="panel-body">


<?php

echo "<div id='msg'><center><br/><br/><br/><h1><font color='red'>Please wait while preparing dashboard...</font></h1></center></div><br>";
	
	ob_end_flush();
	flush();
	usleep(2);

echo "<div class='table-responsive'>";
echo "<table class='table table-bordered'>";
echo "<tr><th colspan=10>Production Plan for Section - $section_no</th><th colspan=20 style='text-align:left;'>Date : ".date("Y-m-d H:i")."</th></tr>";
echo "<tr><th>Mod#</th><th>Legend</th><th>Priority 1</th><th>Remarks</th><th>Priority 2</th><th>Remarks</th><th>Priority 3</th><th>Remarks</th><th>Priority 4</th><th>Remarks</th><th>Priority 5</th><th>Remarks</th><th>Priority 6</th><th>Remarks</th><th>Priority 7</th><th>Remarks</th><th>Priority 8</th><th>Remarks</th><th>Priority 9</th><th>Remarks</th><th>Priority 10</th><th>Remarks</th><th>Priority 11</th><th>Remarks</th><th>Priority 12</th><th>Remarks</th><th>Priority 13</th><th>Remarks</th><th>Priority 14</th><th>Remarks</th></tr>";

$sqlx="select * from $bai_pro3.sections_db where sec_id>0 and sec_id=$section_no";
mysqli_query($link, $sqlx) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_resultx=mysqli_query($link, $sqlx) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_rowx=mysqli_fetch_array($sql_resultx))
{
	$section=$sql_rowx['sec_id'];
	$section_head=$sql_rowx['sec_head'];
	$section_mods=$sql_rowx['sec_mods'];
	
	$mods=array();
	$mods=explode(",",$section_mods);

	for($x=0;$x<sizeof($mods);$x++)
	{
		echo "<tr>";
		echo "<td>".$mods[$x]."</td>";
		echo "<td align=\"right\">Style:<br/>Schedule:<br/>Job:<br/>Total Qty:</td>";
		$module=$mods[$x];
		
		$sql1="SELECT * FROM bai_pro3.plan_dash_doc_summ WHERE module=$module AND act_cut_status<>'DONE' GROUP BY doc_no order by priority LIMIT 14";
		// echo $sql1."<br/>";
		$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql_num_check=mysqli_num_rows($sql_result1);
		while($sql_row1=mysqli_fetch_array($sql_result1))
		{
			$cut_new=$sql_row1['act_cut_status'];
			$cut_input_new=$sql_row1['act_cut_issue_status'];
			$rm_new=strtolower(chop($sql_row1['rm_date']));
			$rm_update_new=strtolower(chop($sql_row1['rm_date']));
			$input_temp=strtolower(chop($sql_row1['cut_inp_temp']));
			$doc_no=$sql_row1['doc_no'];
			$order_tid=$sql_row1['order_tid'];
			$fabric_status=$sql_row1['fabric_status_new'];
			
			$style=$sql_row1['order_style_no'];
			$schedule=$sql_row1['order_del_no'];
			$color=$sql_row1['order_col_des'];
			$total_qty=$sql_row1['total'];
			
			$cut_no=$sql_row1['acutno'];
			$color_code=$sql_row1['color_code'];
			
			$bundle_location="";
			if(sizeof(explode("$",$sql_row1['bundle_location']))>1);
			{
				$bundle_location=end(explode("$",$sql_row1['bundle_location']));

				$sel_bundle_location = implode('-', array_slice(explode("-",$bundle_location), 1));
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
			
			switch ($fabric_status)
			{
				case "1":
				{
					$id="green";
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
					$sql_result1x1=mysqli_query($link, $sql1x1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
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
			
			
			//For Color Clubbing
			unset($club_c_code);
			$club_c_code=array();
			if($sql_row1['clubbing']>0)
			{
				$total_qty=0;
				$sql11="select order_col_des,color_code,(p_xs+p_s+p_m+p_l+p_xl+p_xxl+p_xxxl+p_s01+p_s02+p_s03+p_s04+p_s05+p_s06+p_s07+p_s08+p_s09+p_s10+p_s11+p_s12+p_s13+p_s14+p_s15+p_s16+p_s17+p_s18+p_s19+p_s20+p_s21+p_s22+p_s23+p_s24+p_s25+p_s26+p_s27+p_s28+p_s29+p_s30+p_s31+p_s32+p_s33+p_s34+p_s35+p_s36+p_s37+p_s38+p_s39+p_s40+p_s41+p_s42+p_s43+p_s44+p_s45+p_s46+p_s47+p_s48+p_s49+p_s50)*p_plies as total from $bai_pro3.order_cat_doc_mk_mix where UPPER(category) in (".$in_categories.") and order_del_no=$schedule and clubbing=".$sql_row1['clubbing']." and acutno=".$sql_row1['acutno'];
				//echo $sql11."<br/>";
				$sql_result11=mysqli_query($link, $sql11) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($sql_row11=mysqli_fetch_array($sql_result11))
				{
					$club_c_code[]=chr($sql_row11['color_code']).leading_zeros($sql_row1['acutno'],3);
					//$total_qty+=$sql_row11['total'];
					$total_qty=$sql_row11['total'];
				}
			}
			else
			{
				$club_c_code[]=chr($sql_row1['color_code']).leading_zeros($sql_row1['acutno'],3);
			}
			
			$club_c_code=array_unique($club_c_code);
			
			//Exfactory Date
			
			$ex_factory="NIP";
			$sql11="select order_date as ex_factory_date_new from $bai_pro3.bai_orders_db where order_del_no='$schedule'";
			//echo $sql11."<br/>";
			$sql_result11=mysqli_query($link, $sql11) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
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
echo "<td>".$style."<br/><strong>".$schedule."<br/>".implode(", ",$club_c_code)."</strong><br/>".$total_qty."</td><td>F.L.: $fabric_location / B.L.: </br>Col:".strtoupper($id)."</br><b>Ex-FT: $ex_factory</b><br/><b>DID: $doc_no</b></td>";

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
<script>
	document.getElementById("msg").style.display="none";		
</script>

</div>
</div>
</div>
<style type="text/css">
	body{
		font-family: century gothic;
	}
	table{
    border-collapse: collapse;
}
td {
    background-color: WHITE;
    color: BLACK;
    border: 1px solid #660000;
    padding: 1px;
    white-space: nowrap;
}
th {
	background-color: RED;
    color: WHITE;
    border: 1px solid #660000;
    padding: 10px;
    white-space: nowrap;
}
</style>