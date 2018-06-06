<?php

//CR#619 // 2015-04-27 // kirang // Need to add sample input and sample out fields in the report

//Service Request #86585653 // 2015-12-31 // kirang // Revised the Sample Input Calculation Formula. Sample Input = IMS_QTY FROM IMS_LOG+IMS_LOG_BACKUP, Sample Output = IMS_QTY IMS_LOG_BACKUP; 

// Date: 28-06-2016/ SR#76708309 /Bug: Showing sql error for ENP module, Added qutations for variable $sql_row['ims_mod_no'] at line# 109

//08-09-2016/SR#18628309/Removed $sample_in_qty from missing garment calculation as per mail at 30/08/2016 3:57 PM (subject:IMS removed)

//27-10-2016/SR#76898083/ calculating shipment sample and samples in noraml input column in reconciliation
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/ims_size.php',3,'R'));
?>
<?php

function quality_qty($schedule,$color,$tran_type,$size,$link,$module)
{
	$size=str_replace("a_","",$size);
	
	if($module!=0 or $module!='')
	{
		$sql="SELECT qms_color,qms_tran_type,CONCAT("a_",qms_size) AS qms_size,SUBSTRING_INDEX(remarks,"-",1) AS module,SUM(qms_qty) AS qty FROM $bai_pro3.bai_qms_db WHERE qms_schedule='.$schedule.' and qms_color="'.$color.'" and qms_tran_type IN ('.$tran_type.') and qms_size="'.$size.'" and SUBSTRING_INDEX(remarks,"-",1)="'.$module.'" GROUP BY qms_tran_type,qms_size,SUBSTRING_INDEX(remarks,"-",1)";
	mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	}
	else
	{
		$sql="SELECT qms_color,qms_tran_type,CONCAT("a_",qms_size) AS qms_size,SUBSTRING_INDEX(remarks,"-",1) AS module,SUM(qms_qty) AS qty FROM $bai_pro3.bai_qms_db WHERE qms_schedule='.$schedule.' and qms_color="'.$color.'" and qms_tran_type IN ('.$tran_type.') and qms_size="'.$size.'" GROUP BY qms_tran_type,qms_size";
	mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	}
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
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
		$sql='SELECT qms_color,qms_tran_type,CONCAT("a_",qms_size) AS qms_size,SUBSTRING_INDEX(remarks,"-",1) AS module,SUM(qms_qty) AS qty FROM $bai_pro3.bai_qms_db WHERE qms_schedule='.$schedule.' and qms_color="'.$color.'" and qms_tran_type IN ('.$tran_type.') and qms_size="'.$size.'" and SUBSTRING_INDEX(SUBSTRING_INDEX(remarks,"-",-2),"-",1)='.$module.' GROUP BY qms_tran_type,qms_size,SUBSTRING_INDEX(remarks,"-",1)';
	mysql_query($sql,$link) or exit("Sql Error".mysql_error());
	}
	else
	{
		$sql='SELECT qms_color,qms_tran_type,CONCAT("a_",qms_size) AS qms_size,SUBSTRING_INDEX(remarks,"-",1) AS module,SUM(qms_qty) AS qty FROM $bai_pro3.bai_qms_db WHERE qms_schedule='.$schedule.' and qms_color="'.$color.'" and qms_tran_type IN ('.$tran_type.') and qms_size="'.$size.'" GROUP BY qms_tran_type,qms_size';
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
echo "<h2>Production Reconciliation</h2>";
echo "<table id=\"tablex1\" border=1 class=\"mytable\">";
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
$sizes_db=array("a_xs","a_s","a_m","a_l","a_xl","a_xxl","a_xxxl","a_s01","a_s02","a_s03","a_s04","a_s05","a_s06","a_s07","a_s08","a_s09","a_s10","a_s11","a_s12","a_s13","a_s14","a_s15","a_s16","a_s17","a_s18","a_s19","a_s20","a_s21","a_s22","a_s23","a_s24","a_s25","a_s26","a_s27","a_s28","a_s29","a_s30","a_s31","a_s32","a_s33","a_s34","a_s35","a_s36","a_s37","a_s38","a_s39","a_s40","a_s41","a_s42","a_s43","a_s44","a_s45","a_s46","a_s47","a_s48","a_s49","a_s50");

$sql="select ims_style,ims_color,ims_mod_no,ims_size,sum(ims_qty) as ims_qty,sum(ims_pro_qty) as ims_pro_qty from (select ims_style,ims_mod_no,ims_size,ims_qty,ims_pro_qty,ims_color from $bai_pro3.ims_log where ims_mod_no>0 and ims_schedule=$schedule and ims_remarks not in ('SAMPLE','SHIPMENT_SAMPLE') UNION ALL select ims_style,ims_mod_no,ims_size,ims_qty,ims_pro_qty,ims_color from $bai_pro3.ims_log_backup where ims_mod_no>0  and ims_schedule=$schedule and ims_remarks not in ('SAMPLE','SHIPMENT_SAMPLE') UNION ALL SELECT sfcs_style,sfcs_mod_no,CONCAT('a_',sfcs_size),0,0,sfcs_color FROM $m3_bulk_ops_rep_db.`m3_sfcs_tran_log` WHERE sfcs_schedule=$schedule AND m3_op_des IN ('SIN','SOT')) t group by ims_color,ims_size,ims_mod_no order by ims_mod_no,ims_size";
//echo $sql;
mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row=mysqli_fetch_array($sql_result))
{
	
		echo "<tr>";

			$in_modules[]=$sql_row['ims_mod_no'];
			$recut_qty_db=array();
			$recut_req_db=array();
			
			unset($recut_qty_db);
			unset($recut_req_db);
			
			
			
			
			
			$sql1="select coalesce(sum(a_xs*a_plies),0) as \"a_xs\", coalesce(sum(a_s*a_plies),0) as \"a_s\", coalesce(sum(a_m*a_plies),0) as \"a_m\", coalesce(sum(a_l*a_plies),0) as \"a_l\", coalesce(sum(a_xl*a_plies),0) as \"a_xl\", coalesce(sum(a_xxl*a_plies),0) as \"a_xxl\", coalesce(sum(a_xxxl*a_plies),0) as \"a_xxxl\", coalesce(sum(a_s01*a_plies),0) as \"a_s01\", coalesce(sum(a_s02*a_plies),0) as \"a_s02\", coalesce(sum(a_s03*a_plies),0) as \"a_s03\", coalesce(sum(a_s04*a_plies),0) as \"a_s04\", coalesce(sum(a_s05*a_plies),0) as \"a_s05\", coalesce(sum(a_s06*a_plies),0) as \"a_s06\", coalesce(sum(a_s07*a_plies),0) as \"a_s07\", coalesce(sum(a_s08*a_plies),0) as \"a_s08\", coalesce(sum(a_s09*a_plies),0) as \"a_s09\", coalesce(sum(a_s10*a_plies),0) as \"a_s10\", coalesce(sum(a_s11*a_plies),0) as \"a_s11\", coalesce(sum(a_s12*a_plies),0) as \"a_s12\", coalesce(sum(a_s13*a_plies),0) as \"a_s13\", coalesce(sum(a_s14*a_plies),0) as \"a_s14\", coalesce(sum(a_s15*a_plies),0) as \"a_s15\", coalesce(sum(a_s16*a_plies),0) as \"a_s16\", coalesce(sum(a_s17*a_plies),0) as \"a_s17\", coalesce(sum(a_s18*a_plies),0) as \"a_s18\", coalesce(sum(a_s19*a_plies),0) as \"a_s19\", coalesce(sum(a_s20*a_plies),0) as \"a_s20\", coalesce(sum(a_s21*a_plies),0) as \"a_s21\", coalesce(sum(a_s22*a_plies),0) as \"a_s22\", coalesce(sum(a_s23*a_plies),0) as \"a_s23\", coalesce(sum(a_s24*a_plies),0) as \"a_s24\", coalesce(sum(a_s25*a_plies),0) as \"a_s25\", coalesce(sum(a_s26*a_plies),0) as \"a_s26\", coalesce(sum(a_s27*a_plies),0) as \"a_s27\", coalesce(sum(a_s28*a_plies),0) as \"a_s28\", coalesce(sum(a_s29*a_plies),0) as \"a_s29\", coalesce(sum(a_s30*a_plies),0) as \"a_s30\", coalesce(sum(a_s31*a_plies),0) as \"a_s31\", coalesce(sum(a_s32*a_plies),0) as \"a_s32\", coalesce(sum(a_s33*a_plies),0) as \"a_s33\", coalesce(sum(a_s34*a_plies),0) as \"a_s34\", coalesce(sum(a_s35*a_plies),0) as \"a_s35\", coalesce(sum(a_s36*a_plies),0) as \"a_s36\", coalesce(sum(a_s37*a_plies),0) as \"a_s37\", coalesce(sum(a_s38*a_plies),0) as \"a_s38\", coalesce(sum(a_s39*a_plies),0) as \"a_s39\", coalesce(sum(a_s40*a_plies),0) as \"a_s40\", coalesce(sum(a_s41*a_plies),0) as \"a_s41\", coalesce(sum(a_s42*a_plies),0) as \"a_s42\", coalesce(sum(a_s43*a_plies),0) as \"a_s43\", coalesce(sum(a_s44*a_plies),0) as \"a_s44\", coalesce(sum(a_s45*a_plies),0) as \"a_s45\", coalesce(sum(a_s46*a_plies),0) as \"a_s46\", coalesce(sum(a_s47*a_plies),0) as \"a_s47\", coalesce(sum(a_s48*a_plies),0) as \"a_s48\", coalesce(sum(a_s49*a_plies),0) as \"a_s49\", coalesce(sum(a_s50*a_plies),0) as \"a_s50\",coalesce(sum(p_xs),0) as \"p_xs\", coalesce(sum(p_s),0) as \"p_s\", coalesce(sum(p_m),0) as \"p_m\", coalesce(sum(p_l),0) as \"p_l\", coalesce(sum(p_xl),0) as \"p_xl\", coalesce(sum(p_xxl),0) as \"p_xxl\", coalesce(sum(p_xxxl),0) as \"p_xxxl\", coalesce(sum(p_s01),0) as \"p_s01\", coalesce(sum(p_s02),0) as \"p_s02\", coalesce(sum(p_s03),0) as \"p_s03\", coalesce(sum(p_s04),0) as \"p_s04\", coalesce(sum(p_s05),0) as \"p_s05\", coalesce(sum(p_s06),0) as \"p_s06\", coalesce(sum(p_s07),0) as \"p_s07\", coalesce(sum(p_s08),0) as \"p_s08\", coalesce(sum(p_s09),0) as \"p_s09\", coalesce(sum(p_s10),0) as \"p_s10\", coalesce(sum(p_s11),0) as \"p_s11\", coalesce(sum(p_s12),0) as \"p_s12\", coalesce(sum(p_s13),0) as \"p_s13\", coalesce(sum(p_s14),0) as \"p_s14\", coalesce(sum(p_s15),0) as \"p_s15\", coalesce(sum(p_s16),0) as \"p_s16\", coalesce(sum(p_s17),0) as \"p_s17\", coalesce(sum(p_s18),0) as \"p_s18\", coalesce(sum(p_s19),0) as \"p_s19\", coalesce(sum(p_s20),0) as \"p_s20\", coalesce(sum(p_s21),0) as \"p_s21\", coalesce(sum(p_s22),0) as \"p_s22\", coalesce(sum(p_s23),0) as \"p_s23\", coalesce(sum(p_s24),0) as \"p_s24\", coalesce(sum(p_s25),0) as \"p_s25\", coalesce(sum(p_s26),0) as \"p_s26\", coalesce(sum(p_s27),0) as \"p_s27\", coalesce(sum(p_s28),0) as \"p_s28\", coalesce(sum(p_s29),0) as \"p_s29\", coalesce(sum(p_s30),0) as \"p_s30\", coalesce(sum(p_s31),0) as \"p_s31\", coalesce(sum(p_s32),0) as \"p_s32\", coalesce(sum(p_s33),0) as \"p_s33\", coalesce(sum(p_s34),0) as \"p_s34\", coalesce(sum(p_s35),0) as \"p_s35\", coalesce(sum(p_s36),0) as \"p_s36\", coalesce(sum(p_s37),0) as \"p_s37\", coalesce(sum(p_s38),0) as \"p_s38\", coalesce(sum(p_s39),0) as \"p_s39\", coalesce(sum(p_s40),0) as \"p_s40\", coalesce(sum(p_s41),0) as \"p_s41\", coalesce(sum(p_s42),0) as \"p_s42\", coalesce(sum(p_s43),0) as \"p_s43\", coalesce(sum(p_s44),0) as \"p_s44\", coalesce(sum(p_s45),0) as \"p_s45\", coalesce(sum(p_s46),0) as \"p_s46\", coalesce(sum(p_s47),0) as \"p_s47\", coalesce(sum(p_s48),0) as \"p_s48\", coalesce(sum(p_s49),0) as \"p_s49\", coalesce(sum(p_s50),0) as \"p_s50\" from $bai_pro3.recut_v2_summary where order_tid=(select order_tid from $bai_pro3.bai_orders_db_confirm where order_style_no='".$sql_row['ims_style']."' and order_del_no='".$schedule."' and order_col_des='".$sql_row['ims_color']."') and cut_inp_temp=1 and plan_module='".$sql_row['ims_mod_no']."'";
			
			//echo "<br/>".$sql1;
			$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error12".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row2=mysqli_fetch_array($sql_result1))
			{
				$recut_qty_db[]=$sql_row2['a_xs'];
				$recut_qty_db[]=$sql_row2['a_s'];
				$recut_qty_db[]=$sql_row2['a_m'];
				$recut_qty_db[]=$sql_row2['a_l'];
				$recut_qty_db[]=$sql_row2['a_xl'];
				$recut_qty_db[]=$sql_row2['a_xxl'];
				$recut_qty_db[]=$sql_row2['a_xxxl'];
				$recut_qty_db[]=$sql_row2['a_s01'];
$recut_qty_db[]=$sql_row2['a_s02'];
$recut_qty_db[]=$sql_row2['a_s03'];
$recut_qty_db[]=$sql_row2['a_s04'];
$recut_qty_db[]=$sql_row2['a_s05'];
$recut_qty_db[]=$sql_row2['a_s06'];
$recut_qty_db[]=$sql_row2['a_s07'];
$recut_qty_db[]=$sql_row2['a_s08'];
$recut_qty_db[]=$sql_row2['a_s09'];
$recut_qty_db[]=$sql_row2['a_s10'];
$recut_qty_db[]=$sql_row2['a_s11'];
$recut_qty_db[]=$sql_row2['a_s12'];
$recut_qty_db[]=$sql_row2['a_s13'];
$recut_qty_db[]=$sql_row2['a_s14'];
$recut_qty_db[]=$sql_row2['a_s15'];
$recut_qty_db[]=$sql_row2['a_s16'];
$recut_qty_db[]=$sql_row2['a_s17'];
$recut_qty_db[]=$sql_row2['a_s18'];
$recut_qty_db[]=$sql_row2['a_s19'];
$recut_qty_db[]=$sql_row2['a_s20'];
$recut_qty_db[]=$sql_row2['a_s21'];
$recut_qty_db[]=$sql_row2['a_s22'];
$recut_qty_db[]=$sql_row2['a_s23'];
$recut_qty_db[]=$sql_row2['a_s24'];
$recut_qty_db[]=$sql_row2['a_s25'];
$recut_qty_db[]=$sql_row2['a_s26'];
$recut_qty_db[]=$sql_row2['a_s27'];
$recut_qty_db[]=$sql_row2['a_s28'];
$recut_qty_db[]=$sql_row2['a_s29'];
$recut_qty_db[]=$sql_row2['a_s30'];
$recut_qty_db[]=$sql_row2['a_s31'];
$recut_qty_db[]=$sql_row2['a_s32'];
$recut_qty_db[]=$sql_row2['a_s33'];
$recut_qty_db[]=$sql_row2['a_s34'];
$recut_qty_db[]=$sql_row2['a_s35'];
$recut_qty_db[]=$sql_row2['a_s36'];
$recut_qty_db[]=$sql_row2['a_s37'];
$recut_qty_db[]=$sql_row2['a_s38'];
$recut_qty_db[]=$sql_row2['a_s39'];
$recut_qty_db[]=$sql_row2['a_s40'];
$recut_qty_db[]=$sql_row2['a_s41'];
$recut_qty_db[]=$sql_row2['a_s42'];
$recut_qty_db[]=$sql_row2['a_s43'];
$recut_qty_db[]=$sql_row2['a_s44'];
$recut_qty_db[]=$sql_row2['a_s45'];
$recut_qty_db[]=$sql_row2['a_s46'];
$recut_qty_db[]=$sql_row2['a_s47'];
$recut_qty_db[]=$sql_row2['a_s48'];
$recut_qty_db[]=$sql_row2['a_s49'];
$recut_qty_db[]=$sql_row2['a_s50'];

				
				$recut_req_db[]=$sql_row2['p_xs'];
				$recut_req_db[]=$sql_row2['p_s'];
				$recut_req_db[]=$sql_row2['p_m'];
				$recut_req_db[]=$sql_row2['p_l'];
				$recut_req_db[]=$sql_row2['p_xl'];
				$recut_req_db[]=$sql_row2['p_xxl'];
				$recut_req_db[]=$sql_row2['p_xxxl'];
				$recut_req_db[]=$sql_row2['p_s01'];
				$recut_req_db[]=$sql_row2['p_s02'];
				$recut_req_db[]=$sql_row2['p_s03'];
				$recut_req_db[]=$sql_row2['p_s04'];
				$recut_req_db[]=$sql_row2['p_s05'];
				$recut_req_db[]=$sql_row2['p_s06'];
				$recut_req_db[]=$sql_row2['p_s07'];
				$recut_req_db[]=$sql_row2['p_s08'];
				$recut_req_db[]=$sql_row2['p_s09'];
				$recut_req_db[]=$sql_row2['p_s10'];
				$recut_req_db[]=$sql_row2['p_s11'];
				$recut_req_db[]=$sql_row2['p_s12'];
				$recut_req_db[]=$sql_row2['p_s13'];
				$recut_req_db[]=$sql_row2['p_s14'];
				$recut_req_db[]=$sql_row2['p_s15'];
				$recut_req_db[]=$sql_row2['p_s16'];
				$recut_req_db[]=$sql_row2['p_s17'];
				$recut_req_db[]=$sql_row2['p_s18'];
				$recut_req_db[]=$sql_row2['p_s19'];
				$recut_req_db[]=$sql_row2['p_s20'];
				$recut_req_db[]=$sql_row2['p_s21'];
				$recut_req_db[]=$sql_row2['p_s22'];
				$recut_req_db[]=$sql_row2['p_s23'];
				$recut_req_db[]=$sql_row2['p_s24'];
				$recut_req_db[]=$sql_row2['p_s25'];
				$recut_req_db[]=$sql_row2['p_s26'];
				$recut_req_db[]=$sql_row2['p_s27'];
				$recut_req_db[]=$sql_row2['p_s28'];
				$recut_req_db[]=$sql_row2['p_s29'];
				$recut_req_db[]=$sql_row2['p_s30'];
				$recut_req_db[]=$sql_row2['p_s31'];
				$recut_req_db[]=$sql_row2['p_s32'];
				$recut_req_db[]=$sql_row2['p_s33'];
				$recut_req_db[]=$sql_row2['p_s34'];
				$recut_req_db[]=$sql_row2['p_s35'];
				$recut_req_db[]=$sql_row2['p_s36'];
				$recut_req_db[]=$sql_row2['p_s37'];
				$recut_req_db[]=$sql_row2['p_s38'];
				$recut_req_db[]=$sql_row2['p_s39'];
				$recut_req_db[]=$sql_row2['p_s40'];
				$recut_req_db[]=$sql_row2['p_s41'];
				$recut_req_db[]=$sql_row2['p_s42'];
				$recut_req_db[]=$sql_row2['p_s43'];
				$recut_req_db[]=$sql_row2['p_s44'];
				$recut_req_db[]=$sql_row2['p_s45'];
				$recut_req_db[]=$sql_row2['p_s46'];
				$recut_req_db[]=$sql_row2['p_s47'];
				$recut_req_db[]=$sql_row2['p_s48'];
				$recut_req_db[]=$sql_row2['p_s49'];
				$recut_req_db[]=$sql_row2['p_s50'];

			}
		
		
		$replaced=quality_qty($schedule,$sql_row['ims_color'],2,$sql_row['ims_size'],$link,$sql_row["ims_mod_no"]);
		$transfer=quality_qty($schedule,$sql_row['ims_color'],11,$sql_row['ims_size'],$link,$sql_row["ims_mod_no"]);
		$rejections=quality_qty($schedule,$sql_row['ims_color'],3,$sql_row['ims_size'],$link,$sql_row["ims_mod_no"]);
		$outofratio=quality_qty($schedule,$sql_row['ims_color'],5,$sql_row['ims_size'],$link,$sql_row["ims_mod_no"]);
		//$sample=quality_qty_sample($schedule,$sql_row['ims_color'],4,$sql_row['ims_size'],$link,$sql_row["ims_mod_no"]);
		
		//CR#619 // 2015-04-27 // kirang // Need to add sample input and sample out fields in the report
		
		$sample_in_qty=0;
		$sql_sample_in="select SUM(ims_qty) as in_qty from $bai_pro3.ims_log where ims_schedule=\"".$schedule."\" and ims_size=\"".$sql_row['ims_size']."\" and ims_color=\"".$sql_row['ims_color']."\" and ims_mod_no=\"".$sql_row["ims_mod_no"]."\" and ims_remarks in ('SAMPLE','SHIPMENT_SAMPLE')";
		$sql_result12_in=mysqli_query($link, $sql_sample_in) or exit("Sql Error12=".$sql_sample."-".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row12_in=mysqli_fetch_array($sql_result12_in))
		{
			$sample_in_qty=$sql_row12_in["in_qty"];
		}
		
		$sample_out_qty=0;
		$sql_sample="select SUM(ims_qty) as out_qty from $bai_pro3.ims_log_backup where ims_schedule=\"".$schedule."\" and ims_size=\"".$sql_row['ims_size']."\" and ims_color=\"".$sql_row['ims_color']."\" and ims_mod_no=\"".$sql_row["ims_mod_no"]."\" and ims_remarks in ('SAMPLE','SHIPMENT_SAMPLE')";
		$sql_result12=mysqli_query($link, $sql_sample) or exit("Sql Error12=".$sql_sample."-".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row12=mysqli_fetch_array($sql_result12))
		{
			$sample_out_qty=$sql_row12["out_qty"];
		}
		
		$sql_sample="select sum(bac_qty) as sout from $bai_pro.bai_log_buf where delivery=$schedule and color='".$sql_row['ims_color']."' and bac_no=\"".$sql_row["ims_mod_no"]."\" and size_".str_replace('a_','',$sql_row['ims_size']).">0";
		$sql_result12=mysqli_query($link, $sql_sample) or exit("Sql Error12=".$sql_sample."-".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row12=mysqli_fetch_array($sql_result12))
		{
			$output=$sql_row12["sout"];
		}
		
		$size_value=ims_sizes('',$schedule,$sql_row['ims_style'],$sql_row['ims_color'],strtoupper(substr($sql_row['ims_size'],2)),$link);
		//echo "<td>$tid</td>";
		echo "<td>".$sql_row["ims_color"]."</td>";
		echo "<td>".$size_value."</td>";
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

?>

<script language="javascript" type="text/javascript">
//<![CDATA[

var fnsFilters = {
	
	rows_counter: true,
	sort_select: true,
		on_change: true,
		display_all_text: " [ Show all ] ",
		loader_text: "Filtering data...",  
	loader: true,
	col_0: "select", 
	col_1: "select", 
	col_2: "select",
	loader_text: "Filtering data...",
	btn_reset: true,
		alternate_rows: true,
		btn_reset_text: "Clear",
	col_operation: { 
						id: ["tablex1Tot1","tablex1Tot2","tablex1Tot3","tablex1Tot4","tablex1Tot5","tablex1Tot6","tablex1Tot7","tablex1Tot8","tablex1Tot9","tablex1Tot10"],
						 col: [3,4,5,6,7,8,9,10,11,12],  
						operation: ["sum","sum","sum","sum","sum","sum","sum","sum","sum","sum"],
						 decimal_precision: [1,1,1,1,1,1,1,1,1,1],
						write_method: ["innerHTML","innerHTML","innerHTML","innerHTML","innerHTML","innerHTML","innerHTML","innerHTML","innerHTML","innerHTML"] 
					},
	rows_always_visible: [grabTag(grabEBI('tablex1'),"tr").length]
							
	
		
	};
	
	 setFilterGrid("tablex1",fnsFilters);
//]]>
</script>
