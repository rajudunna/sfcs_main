
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
<!--<title>Extra Shipment Details Report</title>-->
<meta name="" content="">
<meta name="vs_targetSchema" content="http://schemas.microsoft.com/intellisense/ie5">

<!--<script type="text/javascript" src="<?= '..'.getFullURL($_GET['r'],'datetimepicker_css.js','R') ?>"></script>-->
<script type="text/javascript">
	function check_date()
    {
		var from_date = document.getElementById("sdate").value;
		var to_date = document.getElementById("edate").value;
		
		if(to_date < from_date){
			sweetAlert('Start date should be less than End date','','warning');
			return false;
		}
		return true;
	}</script>

<style type="text/css" media="screen">

/*====================================================
	- HTML Table Filter stylesheet
=====================================================*/
@import "<?= '../'.getFullURLLevel($_GET['r'],'common/css/TableFilter_EN/filtergrid.css',3,'R') ?>";

/*====================================================
	- General html elements
=====================================================*/
a {
	margin:0px; padding:0px;
}
caption{ margin:10px 0 0 5px; padding:10px; text-align:left; }
pre{ font-size:13px; margin:5px; padding:5px; background-color:#f4f4f4; border:1px solid #ccc;  }
.mytable1{
	font-size:12px;
}
th{ background-color:#29759C; color:#FFF; padding:2px; border:1px solid #ccc; }
td{ padding:2px; border-bottom:1px solid #ccc; border-right:1px solid #ccc; white-space:nowrap;}
</style>
<script language="javascript" type="text/javascript" src="<?= '../'.getFullURLLevel($_GET['r'],'common/js/TableFilter_EN/tablefilter.js',3,'R') ?>"></script>
<link href="<?= getFullURLLevel($_GET['r'],'common/css/sfcs_styles.css',3,'R'); ?>" rel="stylesheet" type="text/css" />
</head>
<div class='panel panel-primary'><div class='panel-heading'><h3 class='panel-title'>Extra Shipment Details Report</h3></div><div class='panel-body'>
<?php 
// include '../'.getFullURL($_GET['r'],"header1_extra_shipment_details.php",'R');?>

<?php

$dat=$_POST["dat1"];
$dat1=$_POST["dat2"];
// echo $dat.'---'.$dat1;

  echo "<form class='row' action='".getFullURL($_GET['r'],'index_data_old_new.php','N')."' method=\"post\">
			
	<div class='col-sm-3'>
	<b>Ex-factory Start Date</b><input class='form-control'  type=\"text\" data-toggle=\"datepicker\" size=\"8\" name=\"dat1\" id=\"sdate\" value=\"$dat\"/ ></div>";
	
	echo "

<div class='col-sm-3'>
<b>Ex-factory End Date&nbsp;&nbsp;	</b><input class='form-control' type=\"text\" data-toggle=\"datepicker\" size=\"8\" name=\"dat2\" id=\"edate\" value=\"$dat1\"/ ></div>";

	echo "<br/><input type=\"submit\" onclick='return check_date()' name=\"submit\" class='btn btn-success' value=\"Filter\"/>
</form>";

$addon_headings="";
$sql2="select * from $bai_pro3.sections_db where sec_id>0";
	// echo $sql2;
	$sql_result2=mysqli_query($link,$sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row2=mysqli_fetch_array($sql_result2))
	{
		$addon_headings.="<th>SEC-".$sql_row2['sec_id']."<br/>Pending PCS</th>";	
		$addon_headings.="<th>SEC-".$sql_row2['sec_id']."<br/>Lost Value</th>";	
	}

$week_del="select schedule_no,exfact_date from $bai_pro2.shipment_plan_summ where exfact_date between \"$dat\" and \"$dat1\" and style_no not like \"M%\" GROUP BY schedule_no";
// echo $week_del."<br>";
$sql_result=mysqli_query($link,$week_del) or exit("Sql Error =".mysqli_error($GLOBALS["___mysqli_ston"]));
$count_rows=mysqli_num_rows($sql_result);
if($count_rows > 0){
	echo "<br><div class='table-responsive'>";
	echo "<table  class=\"mytable1\">
	<thead>
	<tr>
	<th rowspan=2>Sno</th> 
	<th rowspan=2>Customer</th>
	<th rowspan=2>Style</th>
	<th rowspan=2>Schedule</th>
	<th rowspan=2>Color</th>
	<th colspan=2>Order Qty as per M3</th>
	<th rowspan=2>Garment Ex Fac</th>
	<th rowspan=2>Purchase width</th>
	<th colspan=2>System</th>
	<th colspan=2>Cad</th>
	<th colspan=2>Saving</th>
	<th colspan=2>Possible Qty can be ship</th>
	<th colspan=2>Shipped Qty as per AOD</th>
	<th rowspan=2>Shipped Qty as per M3</th>
	<th rowspan=2>Extra Ship Qty</th>
	<th rowspan=2>FOB Per Piece</th>
	<th rowspan=2>Total FOB <br>For Extrashipment</th>
	<th rowspan=2>Status</th>
	<th colspan=".((mysqli_num_rows($sql_result2)*2)+2).">Production Balances</th>
	<th colspan=2>Shipment Balances</th>
	</tr>
	<tr>
	<th>Size</th><th>Total Quantity</th><th>YY</th><th>Yards</th><th>YY</th><th>Yards</th><th>%</th><th>Yards</th><th>Size</th><th>Total Quantity</th><th>Size</th><th>Total Quantity</th>";
	
		
		echo "$addon_headings<th>Total Production<br/>Pendings</th>";
		echo "<th>Lost Value</th>";
		
		echo "<th>Total Shipment<br/>Pendings</th>";
		echo "<th>Lost Value</th>";
			
	echo " </tr></thead>";
	$x=0;
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		$schdules[]=$sql_row["schedule_no"];
		$ex_fac_date[]=$sql_row["exfact_date"];
		
	}


	$total_cost=0;
	// if($count_rows > 0)
	// {
		$total_sch=implode(",",$schdules);


	$week_del="select schedule_no,exfact_date from $bai_pro2.shipment_plan_summ where exfact_date between \"$dat\" and \"$dat1\" and style_no not like \"M%\" GROUP BY schedule_no";
	// echo $week_del."<br>";
	$sql_result=mysqli_query($link, $week_del) or exit("Sql Error =".mysqli_error($GLOBALS["___mysqli_ston"]));
	$count_rows=mysqli_num_rows($sql_result);
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		$schdules[]=$sql_row["schedule_no"];
		$ex_fac_date[]=$sql_row["exfact_date"];
		//$ex_fact_date[]=$sql_row["order_date"];
	}


	$sql="select * from $bai_pro3.bai_orders_db_confirm where order_del_no in ($total_sch) and order_no=\"1\" order by order_del_no";
	// echo $sql."<br>";
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error =".mysqli_error($GLOBALS["___mysqli_ston"]));
	$slnum = 1;
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		$x=$x+1; 
		if($x%2==0)
		{
			//$id="#c0c0c0";
			$id="#D0D0D0";
		}
		else
		{
			$id="#ffffff";
		}
		$s06_ord_quan=$sql_row['order_s_s06'];
		$s08_ord_quan=$sql_row['order_s_s08'];
		$s10_ord_quan=$sql_row['order_s_s10'];
		$s12_ord_quan=$sql_row['order_s_s12'];
		$s14_ord_quan=$sql_row['order_s_s14'];
		$s16_ord_quan=$sql_row['order_s_s16'];
		$s18_ord_quan=$sql_row['order_s_s18'];
		$s20_ord_quan=$sql_row['order_s_s20'];
		$s22_ord_quan=$sql_row['order_s_s22'];
		$s24_ord_quan=$sql_row['order_s_s24'];
		$s26_ord_quan=$sql_row['order_s_s26'];
		$s28_ord_quan=$sql_row['order_s_s28'];
		$s30_ord_quan=$sql_row['order_s_s30'];
		
		$sizes = array($s06_ord_quan, $s08_ord_quan, $s10_ord_quan, $s12_ord_quan, $s14_ord_quan, $s16_ord_quan, $s18_ord_quan, $s20_ord_quan, $s22_ord_quan, $s24_ord_quan, $s26_ord_quan, $s28_ord_quan, $s30_ord_quan);
		$filtered_sizes = array_filter($sizes);
		
		$old_order_quantity = array('old_order_s_s06', 'old_order_s_s08', 'old_order_s_s10', 'old_order_s_s12', 'old_order_s_s14', 'old_order_s_s16', 'old_order_s_s18', 'old_order_s_s20', 'old_order_s_s22', 'old_order_s_s24', 'old_order_s_s26', 'old_order_s_s28', 'old_order_s_s30');
		
		$title_sizes = array('title_size_s06', 'title_size_s08', 'title_size_s10', 'title_size_s12', 'title_size_s14', 'title_size_s16', 'title_size_s18', 'title_size_s20', 'title_size_s22', 'title_size_s24', 'title_size_s26', 'title_size_s28', 'title_size_s30');
		
		$ship_title_sizes = array('ship_s_s06', 'ship_s_s08', 'ship_s_s10', 'ship_s_s12', 'ship_s_s14', 'ship_s_s16', 'ship_s_s18', 'ship_s_s20', 'ship_s_s22', 'ship_s_s24', 'ship_s_s26', 'ship_s_s28', 'ship_s_s30');
		// var_dump(sizeof($filtered_sizes));
		$rowspan_for_shipqty = sizeof($filtered_sizes);
		foreach($filtered_sizes as $key001 => $value001)
		{
			
			// var_dump(sizeof($filtered_sizes));
			// echo $key001;
			//getting sizes using hardcoded array
			$title_size = $sql_row[$title_sizes[$key001]];
			
			//getting Old Order Quantity using hardcoded array
			$old_order_quan = $sql_row[$old_order_quantity[$key001]];
			
			$order_quan = $value001;
			echo "<tr style=\"background:green;\">";
			$order_tid=$sql_row["order_tid"];
			$sch=$sql_row["order_del_no"];
			echo "<td style=\"background:$id;\">$slnum</td>";
			echo "<td style=\"background:$id;\">".$sql_row["order_div"]."</td>"; 
			echo "<td style=\"background:$id;\">".$sql_row["order_style_no"]."</td>"; 
			echo "<td style=\"background:$id;\">".$sql_row["order_del_no"]."</td>";
			echo "<td style=\"background:$id;\">".$sql_row["order_col_des"]."</td>";
			echo "<td style=\"background:$id;\">".$title_size."</td>";
			echo "<td style=\"background:$id;\">".$old_order_quan."</td>";
			// $total=$sql_row["old_order_s_xs"]+$sql_row["old_order_s_s"]+$sql_row["old_order_s_m"]+$sql_row["old_order_s_l"]+$sql_row["old_order_s_xl"];
			$order_date="";
			
			//Exfactory date dispaly 	
			
			$size=sizeof($order_date)-1;
			$order_date=$ex_fac_date[array_search($sch,$schdules)];
			
			echo "<td style=\"background:$id;\">".$order_date."</td>";	
			
			// calculate system yards for schedule
			
			$sql1="select tid,purwidth,catyy from $bai_pro3.cat_stat_log where order_tid=\"$order_tid\" and category in (\"Body\",\"Front\") and mo_status=\"Y\" and purwidth > 0";
			// echo $sql1."<br>";
			$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row1=mysqli_fetch_array($sql_result1))
			{
				$cat_tid=$sql_row1["tid"];
				echo "<td style=\"background:$id;\">".round($sql_row1["purwidth"],0)."</td>";
				echo "<td style=\"background:$id;\">".round($sql_row1["catyy"],4)."</td>"; 
				$sys_yy=round($sql_row1["catyy"],4);
				$sys_yrds=$sys_yy*$total;
				echo "<td style=\"background:$id;\">".round($sys_yrds,0)."</td>";
			}
			
			
			//calculate yards for extar shipment
			// $plies="";
			// $allcate_tid="";
			$sql2="SELECT tid,plies FROM $bai_pro3.allocate_stat_log WHERE cat_ref=\"$cat_tid\" order by tid";
			// echo $sql2."<br>";
			$sql_result2=mysqli_query($link,$sql2) or exit("Sql Error=".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row2=mysqli_fetch_array($sql_result2))
			{
				$allcate_tid[]=$sql_row2["tid"];
				$plies[]=$sql_row2["plies"];
			}
			
			//Calculating marker Length
			
			// $markereff="";
			if(sizeof($allcate_tid) > 0)
			{
				$allcate_tid_implode=implode(",",$allcate_tid);
				
			}
			else
			{
				$allcate_tid_implode=0;	
			}
			
			$sql3="SELECT mklength FROM $bai_pro3.maker_stat_log WHERE allocate_ref in ($allcate_tid_implode) ORDER BY allocate_ref";
			

			$sql_result3=mysqli_query($link, $sql3) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row3=mysqli_fetch_array($sql_result3))
			{
				$markereff[]=$sql_row3["mklength"];
			}
			
			$total_cad_yrds=0;
			
			for($i=0;$i<sizeof($plies);$i++)
			{
				$total_cad_yrds=$total_cad_yrds+($plies[$i]*$markereff[$i]);
				if($total != 0)
				{
					$cad_yy=round($total_cad_yrds/$total,4);
				}
				else
				{
					$cad_yy=0;
				}
				
			}
			
			$total_cad_yrds_new=round($total_cad_yrds,0);
			echo "<td style=\"background:$id;\">".$cad_yy."</td>";
			echo "<td style=\"background:$id;\">".$total_cad_yrds_new."</td>";
			
			//savings calculation
			if($sys_yy != 0)
			{
				$savings=round(($sys_yy-$cad_yy)*100/$sys_yy,0);
			}
			else
			{
				$savings=0;
			}
			//$savings=round(($sys_yy-$cad_yy)*100/$sys_yy,0);
			echo "<td style=\"background:$id;\">".$savings."%</td>";
			$savings_yards=$sys_yrds-$total_cad_yrds_new;
			echo "<td style=\"background:$id;\">".round($savings_yards,0)."</td>";
			
			echo "<td style=\"background:$id;\">".$title_size."</td>";
			echo "<td style=\"background:$id;\">".$order_quan."</td>";
		
			
			$ext_qty=$total_qty-$total;	
			
			
			
			//shipemet details
		
			$sql4="SELECT SUM($ship_title_sizes[$key001]) as shipped_qty FROM $bai_pro3.ship_stat_log WHERE ship_schedule=\"$sch\" and ship_status=\"2\"";

			$sql_result4=mysqli_query($link, $sql4) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			$total_rows=mysqli_num_rows($sql_result4);
			while($sql_row00011 = mysqli_fetch_array($sql_result4))
			{
				$ship_qty = $sql_row00011['shipped_qty'];
			}
			echo "<td style=\"background:$id;\">".$title_size."</td>";
			echo "<td style=\"background:$id;\">".$ship_qty."</td>";

			//M3 shipment quantity
			if(($rowspan_for_shipqty-$key001) == $rowspan_for_shipqty)
			{
				$sql5="SELECT SUM(ship_qty) FROM $bai_pro2.style_status_summ WHERE sch_no=\"$sch\"";
				// echo $sql5."<br>";
				$sql_result5=mysqli_query($link, $sql5) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				$total_rows1=mysqli_num_rows($sql_result5);
				while($sql_row5=mysqli_fetch_array($sql_result5))
				{
					$m3_total=$sql_row5["SUM(ship_qty)"];
					echo "<td style=\"background:$id;\" rowspan=".$rowspan_for_shipqty.">".round($sql_row5["SUM(ship_qty)"],0)."</td>";
				}
			}
			
			echo "<td style=\"background:$id;\">".$ext_qty."</td>";
			
			$sql2="select distinct(fob_price_per_piece) from $bai_pro4.shipment_plan_ref where schedule_no=\"$sch\"";
			// echo $sql2;
			$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row2=mysqli_fetch_array($sql_result2))
			{
				$fob=$sql_row2["fob_price_per_piece"];		
			}	
			
			echo "<td style=\"background:$id;\">".$fob."$</td>";
			
			$cost=$ext_qty*$fob;
			
			$cost1[]=$ext_qty*$fob;
			
			echo "<td style=\"background:$id;\">".$cost."$</td>";
			
			$total_cost=$total_cost+$cost;
			
			if($x%2==0)
			{
				$id1="#c0c0c0";
			}
			else
			{
				$id1="#ff0000";
			}
			
			if($total_rows1 > 0)
			{
				if($m3_total == $ship_total)
				{
					$id1="#00ff00";
				}		
				else
				{
					$id1="#ff0000";
				}
			}	
			
			//dispatch status
			if($total_rows > 0)
			{
				if($total < $ship_total)
				{
					echo "<td style=\"background:$id1;\">Extra Ship</td>";
				}
				else if($total == $ship_total)
				{
					echo "<td style=\"background:$id1;\">Order Ship</td>";
				}
				
				else if($ship_total == 0)
				{
					echo "<td style=\"background:$id1;\">Yet to Ship</td>";
				}
				
				else
				{
					echo "<td style=\"background:$id1;\">Short Ship</td>";
				}
			}	
			echo $total;
			
			$prod_balances=0;
			$sql2="select * from $bai_pro3.sections_db where sec_id>0";
			//echo $sql2;
			$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row2=mysqli_fetch_array($sql_result2))
			{
				$sec_mods=$sql_row2['sec_mods'];
				
				$sql2xy="select sum(balance) as balance from (select sum((ims_qty-ims_pro_qty)) as balance from bai_pro3.ims_log where ims_schedule=\"$sch\" and ims_mod_no in ($sec_mods) and ims_remarks not in ('EXCESS','SAMPLE','EMB') union select sum((ims_qty-ims_pro_qty)) as balance from $bai_pro3.ims_log_backup where ims_schedule=\"$sch\" and ims_mod_no in ($sec_mods) and ims_remarks not in ('EXCESS','SAMPLE','EMB')) as t";
				// echo $sql2xy;
				$sql_result2xy=mysqli_query($link, $sql2xy) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($sql_row2xy=mysqli_fetch_array($sql_result2xy))
				{
					echo "<td style=\"background:$id;\">".$sql_row2xy['balance']."</td>";
					echo "<td style=\"background:$id;\">".round(($sql_row2xy['balance']*$fob),2)."$</td>";
					$prod_balances+=$sql_row2xy['balance'];
				}
					
			}	
			
			echo "<td style=\"background:$id;\">$prod_balances</td>";
			echo "<td style=\"background:$id;\">".round(($prod_balances*$fob),2)."$</td>";
			
			echo "<td style=\"background:$id;\">".($total_qty-$ship_total)."</td>";
			echo "<td style=\"background:$id;\">".round(($total_qty-$ship_total)*$fob,2)."$</td>";
			
			$slnum += 1;
		}
		
		}
	echo "<tr><td colspan=\"22\"></td><th>".$total_cost."$</th><td></td></tr>";
	echo "</table>";
}else{
	echo "<h2 class='alert alert-info' align=\"center\">Selected period Don't have any schedules to shipment</h2>";
}
?>
 
<script language="javascript" type="text/javascript">
	var table3Filters = {
	col_35: "select",
	sort_select: true,
	display_all_text: "Display all"
	}
	setFilterGrid("table1",table3Filters);
</script> 


</div></div>
</html>