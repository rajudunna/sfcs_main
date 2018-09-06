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
</head>

<body>
<div class="panel panel-primary">
	<div class="panel-heading">Input Job Plan Details</div><br/>
	<div class="panel-body">
		<?php
		echo "<div id=\"msg\"><center><br/><br/><br/><h1><font color=\"blue\">Please wait while preparing dashboard...</font></h1></center></div>";
		ob_end_flush();
		flush();
		usleep(1);
		
		?>
		<div class="table table-responsive">
		<table class="table table-bordered">
			<tr>
			<th colspan=10 >Production Plan for Section -<?= $section_no; ?></th>
			<th colspan=20 >Date :<?= date('Y-m-d H:i'); ?></th>
			</tr>
			<tr><th>Mod#</th><th>Legend</th><th>Priority 1</th><th>Priority 2</th><th>Priority 3</th><th>Priority 4</th><th>Priority 5</th><th>Priority 6</th><th>Priority 7</th><th>Priority 8</th><th>Priority 9</th><th>Priority 10</th><th>Priority 11</th><th>Priority 12</th><th>Priority 13</th><th>Priority 14</th></tr>

<?php
$sqlx="select * from $bai_pro3.sections_db where sec_id>0 and sec_id=$section_no";
$sql_resultx=mysqli_query($link,$sqlx) or exit("Sql Error1".mysqli_error());
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
		echo "<td align=\"right\">Style:<br/>Schedule:<br/>Job:<br/>Total Qty:<br/>Fab. Status:<br/>Trim Status:</td>";
		$module=$mods[$x];
		
		$sql1="SELECT input_job_no_random_ref,input_module,input_priority,input_trims_status,input_panel_status,track_id,input_job_no,tid,input_job_no_random,
order_tid,doc_no,acutno,act_cut_status,'' as act_cut_issue_status,a_plies,p_plies,color_code,order_style_no,order_del_no,order_col_des,ft_status,st_status,pt_status,
trim_status,category,clubbing,plan_module,cat_ref,emb_stat1,SUM(carton_act_qty) as carton_act_qty FROM $bai_pro3.plan_dash_doc_summ_input WHERE (input_trims_status!=4 OR input_trims_status IS NULL OR input_panel_status!=2 OR 
input_panel_status IS NULL) AND input_module=$module and order_tid is not null GROUP BY input_job_no_random_ref ORDER BY input_priority LIMIT 14";
		//echo $sql1."<br/>";
		$sql_result1=mysqli_query($link,$sql1) or exit("Sql Error2".mysqli_error());
		$sql_num_check=mysqli_num_rows($sql_result1);
		while($sql_row1=mysqli_fetch_array($sql_result1))
		{
			$input_job_no_random_ref=$sql_row1['input_job_no_random_ref'];
			$cut_new=$sql_row1['act_cut_status'];
			$cut_input_new=$sql_row1['act_cut_issue_status'];
			//$rm_new=strtolower(chop($sql_row1['rm_date']));
			//$rm_update_new=strtolower(chop($sql_row1['rm_date']));
			$rm_new="111";
			$rm_update_new="222";
			$input_temp=strtolower(chop($sql_row1['cut_inp_temp']));
			$doc_no=$sql_row1['doc_no'];
			$order_tid=$sql_row1['order_tid'];
			//$fabric_status=$sql_row1['fabric_status_new'];
			$act_cut_status=$sql_row1['act_cut_status'];
			$fabric_status="333";
			
			$style=$sql_row1['order_style_no'];
			$schedule=$sql_row1['order_del_no'];
			$color=$sql_row1['order_col_des'];
			$total_qty=$sql_row1['carton_act_qty'];
			
			$cut_no=$sql_row1['acutno'];
			$color_code=$sql_row1['color_code'];
			$display_prefix1 = get_sewing_job_prefix("prefix","$brandix_bts.tbl_sewing_job_prefix","$bai_pro3.packing_summary_input",$schedule,$color,$sql_row1['input_job_no'],$link);
			//$jobno=$sql_row1['input_job_no'];
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
			
			if($fabric_status!=5)
			{
				$fabric_status=$sql_row1['ft_status'];
				
				//To get the status of join orders
				$sql11="select ft_status from $bai_pro3.bai_orders_db_confirm where order_del_no=\"$schedule\" and order_joins=2";
				$sql_result11=mysqli_query($link,$sql11) or exit("Sql Error3".mysqli_error());
				
				if(mysqli_num_rows($sql_result11)>0)
				{
					$sql11="select ft_status from $bai_pro3.bai_orders_db_confirm where order_joins=\"J$schedule\"";
					$sql_result11=mysqli_query($link,$sql11) or exit("Sql Error4".mysqli_error());
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
			
			$sqlcheck="select * from $bai_pro3.plan_dashboard_input where input_job_no_random_ref='$input_job_no_random_ref'";
			$resultcheck=mysqli_query($link,$sqlcheck) or exit("Sql Error5".mysqli_error());
			while($row4=mysqli_fetch_array($resultcheck))
			{
				$input_trims_status=$row4['input_trims_status'];
			}
			$sql2="SELECT min(st_status) as st_status,order_style_no,group_concat(distinct order_del_no) as order_del_no,group_concat(distinct input_job_no) as input_job_no,group_concat(distinct doc_no) as doc_no FROM $bai_pro3.plan_doc_summ_input WHERE input_job_no_random='$input_job_no_random_ref'";	
			//$sql2="SELECT min(st_status) as st_status,order_style_no,group_concat(distinct order_del_no) as order_del_no,group_concat(distinct input_job_no) as input_job_no,group_concat(distinct doc_no) as doc_no FROM plan_doc_summ_input WHERE input_job_no_random='$input_job_no_random_ref'";	
			//echo $sql2."<br>";
			$result2=mysqli_query($link,$sql2) or exit("Sql Error6".mysqli_error());
			while($row2=mysqli_fetch_array($result2))
			{
				
				$trims_status=$row2['st_status'];
				$style=$row2['order_style_no'];
				$schedule=$row2['order_del_no'];
				$input_job_no=$row2['input_job_no'];
				$doc_no_ref=$row2['doc_no'];
			}

			$doc_no_ref_input = implode("','",$doc_no_ref);
			$doc_no_ref_explode=explode(",",$doc_no_ref);
			
			$num_docs=sizeof($doc_no_ref_explode);
			
			switch ($fabric_status)
			{
				case "1":
				{
					$id="L-Green";					
					$rem="Available";
					if(sizeof($num_docs) > 0)
					{
						$sql1x1="select * from $bai_pro3.fabric_priorities where doc_ref in ('$doc_no_ref_input') and hour(issued_time)+minute(issued_time)>0";
						//echo $sql1x1."<br>";
						$sql_result1x1=mysqli_query($link,$sql1x1) or exit("Sql Error7".mysqli_error());
						if(mysqli_num_rows($sql_result1x1)==$num_docs)
						{
							$id="Yellow";
						}
						else
						{
							$id="L-Green";
							//$id=$id;
						}
					}
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
					if(sizeof($num_docs) > 0)
					{
						$sql1x1="select * from $bai_pro3.fabric_priorities where doc_ref in ('$doc_no_ref_input') and hour(issued_time)+minute(issued_time)>0";
						//echo $sql1x1."<br>";
						$sql_result1x1=mysqli_query($link,$sql1x1) or exit("Sql Error9".mysqli_error());
						if(mysqli_num_rows($sql_result1x1)==$num_docs)
						{
							$id="Yellow";
						}
						else
						{
							$id="L-Green";
							//$id=$id;
						}
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
			
			$sql11x="select * from $bai_pro3.fabric_priorities where doc_ref in ('$doc_no_ref_input')";
			//echo $sql11x."<br>";
			$sql_result11x=mysqli_query($link,$sql11x) or exit("Sql Error9".mysqli_error());
			if(mysqli_num_rows($sql_result11x)==$num_docs and $id!="yellow")
			//if(mysqli_num_rows($sql_result11x) and $id!="yellow")
			{
				$id="D-Green";	
			} 
			
			$sql1x1="select * from $bai_pro3.fabric_priorities where doc_ref in ('$doc_no_ref_input') and hour(issued_time)+minute(issued_time)>0";
			//echo $sql1x1."<br>";
			$sql_result1x1=mysqli_query($link,$sql1x1) or exit("Sql Error10".mysqli_error());
			if(mysqli_num_rows($sql_result1x1)==$num_docs)
			{
				$id="Yellow";
			}
			//echo $num_docs."<br>";
			$sql11x1="select * from $bai_pro3.plandoc_stat_log where doc_no in ('$doc_no_ref_input') and act_cut_status=\"DONE\"";
			//echo $sql11x1."<br>";
			$sql_result11x1=mysqli_query($link,$sql11x1) or exit("Sql Error11".mysqli_error());
			if(mysqli_num_rows($sql_result11x1)==$num_docs and $id=="Yellow")
			{
				$id="Blue";
			} 
			
			
			//For Trims
			$trimid="Green";
			if($input_trims_status == 1)
			{
				$trimid="Yellow";
			}
			
			if($input_trims_status == 2 or $input_trims_status == 3)
			{
				$trimid="Blue"; 
			}
				
			if($input_trims_status==4)
			{
				$trimid="Pink"; //Total Trim input issued to module
				//Circle if the total panel Input is issued to module
			}
			
			//For Color Clubbing
			unset($club_c_code);
			$club_c_code=array();
			if($sql_row1['clubbing']>0)
			{
				//$total_qty=0;
				$sql11="select color_code,acutno from $bai_pro3.order_cat_doc_mk_mix where category in ($in_categories) and order_del_no=$schedule and clubbing=".$sql_row1['clubbing']." and acutno=".$sql_row1['acutno'];
				//echo $sql11."<br/>";
				$sql_result11=mysqli_query($link,$sql11) or exit("Sql Error12".mysqli_error());
				while($sql_row11=mysqli_fetch_array($sql_result11))
				{
					$club_c_code[]=chr($sql_row11['color_code']).leading_zeros($sql_row1['acutno'],3);
					//$total_qty+=$sql_row11['total'];
				}
			}
			else
			{
				$club_c_code[]=chr($sql_row1['color_code']).leading_zeros($sql_row1['acutno'],3);
			}
			
			$club_c_code=array_unique($club_c_code);
			
			//echo "<td>"."Style:".$style."<br/>"."Schedule:".$schedule."<br/>"."Job:".chr($color_code).leading_zeros($cut_no,3)."<br/>"."Total Qty:".$total_qty."</td><td></td>";
			//echo "<td>".$style."<br/><strong>".$schedule."<br/>J".leading_zeros($jobno,3)."</strong><br/>".$total_qty."</td><td>F.L.: $fabric_location<Br/>B.L.: $bundle_location</br>Col:".strtoupper($id)."</br></td>";
			echo "<td >".$style."<br/><strong>".$schedule."<br/>".$display_prefix1."</strong><br/>".$total_qty."<br>".$id."<br>".$trimid."</td>";

		}
		
		for($i=1;$i<=14-$sql_num_check;$i++)
		{
			echo "<td></td>";
		}
		echo "</tr>";
	}
}

echo "</table>";
?>
</body>
<script>
	document.getElementById("msg").style.display="none";		
</script>
</html>

<style type="text/css">
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

