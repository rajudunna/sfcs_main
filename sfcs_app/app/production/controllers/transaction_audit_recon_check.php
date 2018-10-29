<?php

//CR#619 // 2015-04-27 // kirang // Need to add sample input and sample out fields in the report

//Service Request #86585653 // 2015-12-31 // kirang // Revised the Sample Input Calculation Formula. Sample Input = IMS_QTY FROM IMS_LOG+IMS_LOG_BACKUP, Sample Output = IMS_QTY IMS_LOG_BACKUP; 

// Date: 28-06-2016/ SR#76708309 /Bug: Showing sql error for ENP module, Added qutations for variable $sql_row['ims_mod_no'] at line# 109

//08-09-2016/SR#18628309/Removed $sample_in_qty from missing garment calculation as per mail at 30/08/2016 3:57 PM (subject:IMS removed)

//27-10-2016/SR#76898083/ calculating shipment sample and samples in noraml input column in reconciliation
?>
<?php

function quality_qty($schedule,$color,$tran_type,$size,$link,$module)
{
	$size=str_replace("a_","",$size);
	if($module!=0 or $module!='')
	{
		$sql="SELECT qms_color,qms_tran_type,CONCAT('a_',qms_size) AS qms_size,SUBSTRING_INDEX(remarks,'-',1) AS module,SUM(qms_qty) AS qty FROM $bai_pro3.bai_qms_db WHERE qms_schedule='.$schedule.' and qms_color='.$color.' and qms_tran_type IN ('.$tran_type.') and qms_size='.$size.' and SUBSTRING_INDEX(remarks,'-',1)='.$module.' GROUP BY qms_tran_type,qms_size,SUBSTRING_INDEX(remarks,'-',1)";
	mysqli_query($link,$sql) or exit("Sql Error1".mysqli_error());
	}
	else
	{
		$sql="SELECT qms_color,qms_tran_type,CONCAT('a_',qms_size) AS qms_size,SUBSTRING_INDEX(remarks,'-',1) AS module,SUM(qms_qty) AS qty FROM $bai_pro3.bai_qms_db WHERE qms_schedule='.$schedule.' and qms_color='.$color.' and qms_tran_type IN ('.$tran_type.') and qms_size='.$size.' GROUP BY qms_tran_type,qms_size";
	mysqli_query($link,$sql) or exit("Sql Error2".mysqli_error());
	}
	
	$sql_result=mysqli_query($link,$sql) or exit("Sql Error3".mysqli_error());
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		return $sql_row['qty'];
	}
}

/*
function quality_qty_sample($schedule,$color,$tran_type,$size,$link,$module)
{
	$size=str_replace("a_","",$size);
	
	if($module!=0)
	{
		$sql='SELECT qms_color,qms_tran_type,CONCAT("a_",qms_size) AS qms_size,SUBSTRING_INDEX(remarks,"-",1) AS module,SUM(qms_qty) AS qty FROM bai_pro3.bai_qms_db WHERE qms_schedule='.$schedule.' and qms_color="'.$color.'" and qms_tran_type IN ('.$tran_type.') and qms_size="'.$size.'" and SUBSTRING_INDEX(SUBSTRING_INDEX(remarks,"-",-2),"-",1)='.$module.' GROUP BY qms_tran_type,qms_size,SUBSTRING_INDEX(remarks,"-",1)';
	mysql_query($sql,$link) or exit("Sql Error".mysql_error());
	}
	else
	{
		$sql='SELECT qms_color,qms_tran_type,CONCAT("a_",qms_size) AS qms_size,SUBSTRING_INDEX(remarks,"-",1) AS module,SUM(qms_qty) AS qty FROM bai_pro3.bai_qms_db WHERE qms_schedule='.$schedule.' and qms_color="'.$color.'" and qms_tran_type IN ('.$tran_type.') and qms_size="'.$size.'" GROUP BY qms_tran_type,qms_size';
	mysql_query($sql,$link) or exit("Sql Error".mysql_error());
	}
	$sql_result=mysql_query($sql,$link) or exit("Sql Error".mysql_error());
	while($sql_row=mysql_fetch_array($sql_result))
	{
		return $sql_row['qty'];
	}
}
*/
?>


<?php
//echo "<div>";

echo "<div class=\"panel panel-primary\"><div class=\"panel-heading\"<h2>Production Reconciliation</h2></div>";
echo "<table id=\"tablex1\" border=1 class='table table-bordered'>";
echo "<tr>
<th>Color</th>
<th>Size</th>
<th>Module</th>
<th>Input</th>
<th>Recut Input</th>
<th>Replaced</th>
<th>Transfer</th>
<th>Output</th>
<th>Rejections</th>
<th>Out of Ratio</th>
<th>Sample Input</th>
<th>Sample Output</th>
<th>Missing</th>
</tr>";



$in_modules=array();
$sizes_db=array("a_xs","a_s","a_m","a_l","a_xl","a_xxl","a_xxxl","a_s06","a_s08","a_s10","a_s12","a_s14","a_s16","a_s18","a_s20","a_s22","a_s24","a_s26","a_s28","a_s30");

$sql="select ims_style,ims_color,ims_mod_no,ims_size,sum(ims_qty) as ims_qty,sum(ims_pro_qty) as ims_pro_qty from (select ims_style,ims_mod_no,ims_size,ims_qty,ims_pro_qty,ims_color from $bai_pro3.ims_log where ims_mod_no>0 and ims_schedule=$schedule and ims_remarks not in ('SAMPLE','SHIPMENT_SAMPLE')
UNION ALL
select ims_style,ims_mod_no,ims_size,ims_qty,ims_pro_qty,ims_color from $bai_pro3.ims_log_backup where ims_mod_no>0  and ims_schedule=$schedule and ims_remarks not in ('SAMPLE','SHIPMENT_SAMPLE')
UNION ALL
SELECT sfcs_style,sfcs_mod_no,CONCAT('a_',sfcs_size),0,0,sfcs_color FROM $m3_bulk_ops_rep_db.`m3_sfcs_tran_log` WHERE sfcs_schedule=$schedule AND m3_op_des IN ('SIN','SOT')

) t group by ims_color,ims_size,ims_mod_no order by ims_mod_no,ims_size
";
mysqli_query($link,$sql) or exit("Sql Error4".mysqli_error());
$sql_result=mysqli_query($link,$sql) or exit("Sql Error5".mysqli_error());
 $count=mysqli_num_rows($sql_result); 
while($sql_row=mysqli_fetch_array($sql_result))
{
	
		$size1=str_replace("a_","",$sql_row['ims_size']);
		$size2=str_replace("s","",$size1);
			$in_modules[]=$sql_row['ims_mod_no'];
			$recut_qty_db=array();
			$recut_req_db=array();
			
			unset($recut_qty_db);
			unset($recut_req_db);
			
			
			
			
			
			$sql1="select coalesce(sum(a_xs*a_plies),0) as \"a_xs\", coalesce(sum(a_s*a_plies),0) as \"a_s\", coalesce(sum(a_m*a_plies),0) as \"a_m\", coalesce(sum(a_l*a_plies),0) as \"a_l\", coalesce(sum(a_xl*a_plies),0) as \"a_xl\", coalesce(sum(a_xxl*a_plies),0) as \"a_xxl\", coalesce(sum(a_xxxl*a_plies),0) as \"a_xxxl\", coalesce(sum(a_s06*a_plies),0) as \"a_s06\", coalesce(sum(a_s08*a_plies),0) as \"a_s08\", coalesce(sum(a_s10*a_plies),0) as \"a_s10\", coalesce(sum(a_s12*a_plies),0) as \"a_s12\", coalesce(sum(a_s14*a_plies),0) as \"a_s14\", coalesce(sum(a_s16*a_plies),0) as \"a_s16\", coalesce(sum(a_s18*a_plies),0) as \"a_s18\", coalesce(sum(a_s20*a_plies),0) as \"a_s20\", coalesce(sum(a_s22*a_plies),0) as \"a_s22\", coalesce(sum(a_s24*a_plies),0) as \"a_s24\", coalesce(sum(a_s26*a_plies),0) as \"a_s26\", coalesce(sum(a_s28*a_plies),0) as \"a_s28\", coalesce(sum(a_s30*a_plies),0) as \"a_s30\",coalesce(sum(p_xs),0) as \"p_xs\", coalesce(sum(p_s),0) as \"p_s\", coalesce(sum(p_m),0) as \"p_m\", coalesce(sum(p_l),0) as \"p_l\", coalesce(sum(p_xl),0) as \"p_xl\", coalesce(sum(p_xxl),0) as \"p_xxl\", coalesce(sum(p_xxxl),0) as \"p_xxxl\", coalesce(sum(p_s06),0) as \"p_s06\", coalesce(sum(p_s08),0) as \"p_s08\", coalesce(sum(p_s10),0) as \"p_s10\", coalesce(sum(p_s12),0) as \"p_s12\", coalesce(sum(p_s14),0) as \"p_s14\", coalesce(sum(p_s16),0) as \"p_s16\", coalesce(sum(p_s18),0) as \"p_s18\", coalesce(sum(p_s20),0) as \"p_s20\", coalesce(sum(p_s22),0) as \"p_s22\", coalesce(sum(p_s24),0) as \"p_s24\", coalesce(sum(p_s26),0) as \"p_s26\", coalesce(sum(p_s28),0) as \"p_s28\", coalesce(sum(p_s30),0) as \"p_s30\" from $bai_pro3.recut_v2_summary where order_tid=(select order_tid from $bai_pro3.bai_orders_db_confirm where order_style_no='".$sql_row['ims_style']."' and order_del_no='".$schedule."' and order_col_des='".$sql_row['ims_color']."') and cut_inp_temp=1 and plan_module='".$sql_row['ims_mod_no']."'";
			
			//echo "<br/>".$sql1;
			$sql_result1=mysqli_query($link,$sql1) or exit("Sql Error12".mysql_error());
			while($sql_row2=mysqli_fetch_array($sql_result1))
			{
				$recut_qty_db[]=$sql_row2['a_xs'];
				$recut_qty_db[]=$sql_row2['a_s'];
				$recut_qty_db[]=$sql_row2['a_m'];
				$recut_qty_db[]=$sql_row2['a_l'];
				$recut_qty_db[]=$sql_row2['a_xl'];
				$recut_qty_db[]=$sql_row2['a_xxl'];
				$recut_qty_db[]=$sql_row2['a_xxxl'];
				$recut_qty_db[]=$sql_row2['a_s06'];
				$recut_qty_db[]=$sql_row2['a_s08'];
				$recut_qty_db[]=$sql_row2['a_s10'];
				$recut_qty_db[]=$sql_row2['a_s12'];
				$recut_qty_db[]=$sql_row2['a_s14'];
				$recut_qty_db[]=$sql_row2['a_s16'];
				$recut_qty_db[]=$sql_row2['a_s18'];
				$recut_qty_db[]=$sql_row2['a_s20'];
				$recut_qty_db[]=$sql_row2['a_s22'];
				$recut_qty_db[]=$sql_row2['a_s24'];
				$recut_qty_db[]=$sql_row2['a_s26'];
				$recut_qty_db[]=$sql_row2['a_s28'];
				$recut_qty_db[]=$sql_row2['a_s30'];
				
				$recut_req_db[]=$sql_row2['p_xs'];
				$recut_req_db[]=$sql_row2['p_s'];
				$recut_req_db[]=$sql_row2['p_m'];
				$recut_req_db[]=$sql_row2['p_l'];
				$recut_req_db[]=$sql_row2['p_xl'];
				$recut_req_db[]=$sql_row2['p_xxl'];
				$recut_req_db[]=$sql_row2['p_xxxl'];
				$recut_req_db[]=$sql_row2['p_s06'];
				$recut_req_db[]=$sql_row2['p_s08'];
				$recut_req_db[]=$sql_row2['p_s10'];
				$recut_req_db[]=$sql_row2['p_s12'];
				$recut_req_db[]=$sql_row2['p_s14'];
				$recut_req_db[]=$sql_row2['p_s16'];
				$recut_req_db[]=$sql_row2['p_s18'];
				$recut_req_db[]=$sql_row2['p_s20'];
				$recut_req_db[]=$sql_row2['p_s22'];
				$recut_req_db[]=$sql_row2['p_s24'];
				$recut_req_db[]=$sql_row2['p_s26'];
				$recut_req_db[]=$sql_row2['p_s28'];
				$recut_req_db[]=$sql_row2['p_s30'];
			}
		
		
		$replaced=quality_qty($schedule,$sql_row['ims_color'],2,$sql_row['ims_size'],$link,$sql_row["ims_mod_no"]);
		$transfer=quality_qty($schedule,$sql_row['ims_color'],11,$sql_row['ims_size'],$link,$sql_row["ims_mod_no"]);
		$rejections=quality_qty($schedule,$sql_row['ims_color'],3,$sql_row['ims_size'],$link,$sql_row["ims_mod_no"]);
		$outofratio=quality_qty($schedule,$sql_row['ims_color'],5,$sql_row['ims_size'],$link,$sql_row["ims_mod_no"]);
		//$sample=quality_qty_sample($schedule,$sql_row['ims_color'],4,$sql_row['ims_size'],$link,$sql_row["ims_mod_no"]);
		
		//CR#619 // 2015-04-27 // kirang // Need to add sample input and sample out fields in the report
		
		$sample_in_qty=0;
		$sql_sample_in="select SUM(ims_qty) as in_qty from $bai_pro3.ims_log where ims_schedule=\"".$schedule."\" and ims_size=\"".$sql_row['ims_size']."\" and ims_color=\"".$sql_row['ims_color']."\" and ims_mod_no=\"".$sql_row["ims_mod_no"]."\" and ims_remarks in ('SAMPLE','SHIPMENT_SAMPLE')";
		$sql_result12_in=mysqli_query($link,$sql_sample_in) or exit("Sql Error12=".$sql_sample."-".mysql_error());
		while($sql_row12_in=mysqli_fetch_array($sql_result12_in))
		{
			$sample_in_qty=$sql_row12_in["in_qty"];
		}
		
		$sample_out_qty=0;
		$sql_sample="select SUM(ims_qty) as out_qty from $bai_pro3.ims_log_backup where ims_schedule=\"".$schedule."\" and ims_size=\"".$sql_row['ims_size']."\" and ims_color=\"".$sql_row['ims_color']."\" and ims_mod_no=\"".$sql_row["ims_mod_no"]."\" and ims_remarks in ('SAMPLE','SHIPMENT_SAMPLE')";
		$sql_result12=mysqli_query($link,$sql_sample) or exit("Sql Error12=".$sql_sample."-".mysqli_error());
		while($sql_row12=mysqli_fetch_array($sql_result12))
		{
			$sample_out_qty=$sql_row12["out_qty"];
		}
		
		$sql_sample="select sum(bac_qty) as sout from $bai_pro.bai_log_buf where delivery=$schedule and color='".$sql_row['ims_color']."' and bac_no=\"".$sql_row["ims_mod_no"]."\" and size_".str_replace('a_','',$sql_row['ims_size']).">0";
		$sql_result12=mysqli_query($link,$sql_sample) or exit("Sql Error12=".$sql_sample."-".mysqli_error());
		while($sql_row12=mysqli_fetch_array($sql_result12))
		{
			$output=$sql_row12["sout"];
		}
		$sql_size = "select * from $bai_pro3.bai_orders_db_confirm where order_style_no='".$sql_row['ims_style']."' and order_del_no='".$schedule."' and order_col_des='".$sql_row['ims_color']."'";
			
		$sql_size_result =mysqli_query($link,$sql_size) or exit("Sql Error123".mysqli_error());
		while($sql_row1=mysqli_fetch_array($sql_size_result)) {
		for($s=0;$s<sizeof($count);$s++)
			{
				
				if($sql_row1["title_size_s".$size2.""]<>'')
				{
					$s_tit=$sql_row1["title_size_s".$size2.""];
				}	
				//echo $sql_row1["title_size_s".$size2[$s].""];
		echo "<tr>";
				echo "<td>".$sql_row["ims_color"]."</td>";
				echo "<td>".$s_tit."</td>";
				echo "<td>".$sql_row["ims_mod_no"]."</td>";
				echo "<td>".($sql_row["ims_qty"]-$transfer)."</td>";
				echo "<td>".$recut_qty_db[array_search($sql_row["ims_size"],$sizes_db)]."</td>";
				echo "<td>".$replaced."</td>";
				echo "<td>".$transfer."</td>";
				echo "<td>".$output."</td>";
				echo "<td>".$rejections."</td>";
				echo "<td>".$outofratio."</td>";
				echo "<td>".($sample_out_qty+$sample_in_qty)."</td>";
				echo "<td>".$sample_out_qty."</td>";
				//08-09-2016/SR#18628309/Removed $sample_in_qty from missing garment output calculation and added $sample_in_qty,$sample_out_qty in input calculation as per mail at 30/08/2016 3:57 PM (subject:IMS removed)
				echo "<td>".((($sql_row["ims_qty"]-$transfer)
				+$recut_qty_db[array_search($sql_row["ims_size"],$sizes_db)]
				+$replaced
				+$transfer+$sample_out_qty+$sample_in_qty)-($output+$rejections+$outofratio+$sample_out_qty))."</td>";
						
				echo "</tr>";
			}

			

		
				}
}
echo '<tr>
		<td colspan="3" style="background-color:RED; color:white;">Total:</td>
		<td id="tablex1Tot1" style="background-color:#FFFFCC; color:red;"></td>
		<td id="tablex1Tot2" style="background-color:#FFFFCC; color:red;"></td>
		<td id="tablex1Tot3" style="background-color:#FFFFCC; color:red;"></td>
		<td id="tablex1Tot4" style="background-color:#FFFFCC; color:red;"></td>
		<td id="tablex1Tot5" style="background-color:#FFFFCC; color:red;"></td>
		<td id="tablex1Tot6" style="background-color:#FFFFCC; color:red;"></td>
		<td id="tablex1Tot7" style="background-color:#FFFFCC; color:red;"></td>
		<td id="tablex1Tot8" style="background-color:#FFFFCC; color:red;"></td>
		<td id="tablex1Tot9" style="background-color:#FFFFCC; color:red;"></td>
		<td id="tablex1Tot10" style="background-color:#FFFFCC; color:red;"></td>
	</tr>';

echo "</table>";
echo"</div>";

?>

<script language="javascript" type="text/javascript">
//<![CDATA[

var fnsFilters = {
	
	 
	sort_select: true,
	on_change: true,
	// display_all_text: " [ Show all ] ",
	loader_text: "Filtering data...",  
	loader: true,
	col_0: "select", 
	col_1: "select", 
	col_2: "select",
	btn_reset: true,
	btn_reset_text: "Clear",
	alternate_rows: true,
	col_operation: { 
						id: ["tablex1Tot1","tablex1Tot2","tablex1Tot3","tablex1Tot4","tablex1Tot5","tablex1Tot6","tablex1Tot7","tablex1Tot8","tablex1Tot9","tablex1Tot10"],
						 col: [3,4,5,6,7,8,9,10,11,12],  
						operation: ["sum","sum","sum","sum","sum","sum","sum","sum","sum","sum"],
						 decimal_precision: [1,1,1,1,1,1,1,1,1,1],
						write_method: ["innerHTML","innerHTML","innerHTML","innerHTML","innerHTML","innerHTML","innerHTML","innerHTML","innerHTML","innerHTML"] 
					},
	rows_counter: true,
	rows_counter_text: "Total rows: ", 
	rows_always_visible: [grabTag(grabEBI('tablex1'),"tr").length]
							
	
		
	};
	setFilterGrid("tablex1",fnsFilters);
// ]]>
</script>
<script language="javascript" type="text/javascript">
//<![CDATA[
	setFilterGrid( "tablex1" );
//]]>
</script>

 