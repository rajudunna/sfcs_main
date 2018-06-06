<?php include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));?>
<?php include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'/common/php/functions.php',4,'R')); ?>
<?php

$order_qtys=array();

		

$sql="select * from $bai_pro3.bai_orders_db_confirm where order_tid=\"$tran_order_tid\"";
mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_num_check=mysqli_num_rows($sql_result);
while($sql_row=mysqli_fetch_array($sql_result))
{
	$tran_order_tid=$sql_row['order_tid'];
	$order_date=$sql_row['order_date'];
	$order_div=$sql_row['order_div'];
	$order_po=$sql_row['order_po_no'];
	$color_code=$sql_row['color_code'];
	
	
	$order_qtys[]=$sql_row['order_s_xs'];
	$order_qtys[]=$sql_row['order_s_s'];
	$order_qtys[]=$sql_row['order_s_m'];
	$order_qtys[]=$sql_row['order_s_l'];
	$order_qtys[]=$sql_row['order_s_xl'];
	$order_qtys[]=$sql_row['order_s_xxl'];
	$order_qtys[]=$sql_row['order_s_xxxl'];
	$order_qtys[]=$sql_row1['order_s_s01'];
	$order_qtys[]=$sql_row1['order_s_s02'];
	$order_qtys[]=$sql_row1['order_s_s03'];
	$order_qtys[]=$sql_row1['order_s_s04'];
	$order_qtys[]=$sql_row1['order_s_s05'];
	$order_qtys[]=$sql_row1['order_s_s06'];
	$order_qtys[]=$sql_row1['order_s_s07'];
	$order_qtys[]=$sql_row1['order_s_s08'];
	$order_qtys[]=$sql_row1['order_s_s09'];
	$order_qtys[]=$sql_row1['order_s_s10'];
	$order_qtys[]=$sql_row1['order_s_s11'];
	$order_qtys[]=$sql_row1['order_s_s12'];
	$order_qtys[]=$sql_row1['order_s_s13'];
	$order_qtys[]=$sql_row1['order_s_s14'];
	$order_qtys[]=$sql_row1['order_s_s15'];
	$order_qtys[]=$sql_row1['order_s_s16'];
	$order_qtys[]=$sql_row1['order_s_s17'];
	$order_qtys[]=$sql_row1['order_s_s18'];
	$order_qtys[]=$sql_row1['order_s_s19'];
	$order_qtys[]=$sql_row1['order_s_s20'];
	$order_qtys[]=$sql_row1['order_s_s21'];
	$order_qtys[]=$sql_row1['order_s_s22'];
	$order_qtys[]=$sql_row1['order_s_s23'];
	$order_qtys[]=$sql_row1['order_s_s24'];
	$order_qtys[]=$sql_row1['order_s_s25'];
	$order_qtys[]=$sql_row1['order_s_s26'];
	$order_qtys[]=$sql_row1['order_s_s27'];
	$order_qtys[]=$sql_row1['order_s_s28'];
	$order_qtys[]=$sql_row1['order_s_s29'];
	$order_qtys[]=$sql_row1['order_s_s30'];
	$order_qtys[]=$sql_row1['order_s_s31'];
	$order_qtys[]=$sql_row1['order_s_s32'];
	$order_qtys[]=$sql_row1['order_s_s33'];
	$order_qtys[]=$sql_row1['order_s_s34'];
	$order_qtys[]=$sql_row1['order_s_s35'];
	$order_qtys[]=$sql_row1['order_s_s36'];
	$order_qtys[]=$sql_row1['order_s_s37'];
	$order_qtys[]=$sql_row1['order_s_s38'];
	$order_qtys[]=$sql_row1['order_s_s39'];
	$order_qtys[]=$sql_row1['order_s_s40'];
	$order_qtys[]=$sql_row1['order_s_s41'];
	$order_qtys[]=$sql_row1['order_s_s42'];
	$order_qtys[]=$sql_row1['order_s_s43'];
	$order_qtys[]=$sql_row1['order_s_s44'];
	$order_qtys[]=$sql_row1['order_s_s45'];
	$order_qtys[]=$sql_row1['order_s_s46'];
	$order_qtys[]=$sql_row1['order_s_s47'];
	$order_qtys[]=$sql_row1['order_s_s48'];
	$order_qtys[]=$sql_row1['order_s_s49'];
	$order_qtys[]=$sql_row1['order_s_s50'];

	
	$o_s_xs=$sql_row['order_s_xs'];
	$o_s_s=$sql_row['order_s_s'];
	$o_s_m=$sql_row['order_s_m'];
	$o_s_l=$sql_row['order_s_l'];
	$o_s_xl=$sql_row['order_s_xl'];
	$o_s_xxl=$sql_row['order_s_xxl'];
	$o_s_xxxl=$sql_row['order_s_xxxl'];
	$o_total=($o_s_xs+$o_s_s+$o_s_m+$o_s_l+$o_s_xl+$o_s_xxl+$o_s_xxxl);
	$size01 = $sql_row['title_size_s01'];
$size02 = $sql_row['title_size_s02'];
$size03 = $sql_row['title_size_s03'];
$size04 = $sql_row['title_size_s04'];
$size05 = $sql_row['title_size_s05'];
$size06 = $sql_row['title_size_s06'];
$size07 = $sql_row['title_size_s07'];
$size08 = $sql_row['title_size_s08'];
$size09 = $sql_row['title_size_s09'];
$size10 = $sql_row['title_size_s10'];
$size11 = $sql_row['title_size_s11'];
$size12 = $sql_row['title_size_s12'];
$size13 = $sql_row['title_size_s13'];
$size14 = $sql_row['title_size_s14'];
$size15 = $sql_row['title_size_s15'];
$size16 = $sql_row['title_size_s16'];
$size17 = $sql_row['title_size_s17'];
$size18 = $sql_row['title_size_s18'];
$size19 = $sql_row['title_size_s19'];
$size20 = $sql_row['title_size_s20'];
$size21 = $sql_row['title_size_s21'];
$size22 = $sql_row['title_size_s22'];
$size23 = $sql_row['title_size_s23'];
$size24 = $sql_row['title_size_s24'];
$size25 = $sql_row['title_size_s25'];
$size26 = $sql_row['title_size_s26'];
$size27 = $sql_row['title_size_s27'];
$size28 = $sql_row['title_size_s28'];
$size29 = $sql_row['title_size_s29'];
$size30 = $sql_row['title_size_s30'];
$size31 = $sql_row['title_size_s31'];
$size32 = $sql_row['title_size_s32'];
$size33 = $sql_row['title_size_s33'];
$size34 = $sql_row['title_size_s34'];
$size35 = $sql_row['title_size_s35'];
$size36 = $sql_row['title_size_s36'];
$size37 = $sql_row['title_size_s37'];
$size38 = $sql_row['title_size_s38'];
$size39 = $sql_row['title_size_s39'];
$size40 = $sql_row['title_size_s40'];
$size41 = $sql_row['title_size_s41'];
$size42 = $sql_row['title_size_s42'];
$size43 = $sql_row['title_size_s43'];
$size44 = $sql_row['title_size_s44'];
$size45 = $sql_row['title_size_s45'];
$size46 = $sql_row['title_size_s46'];
$size47 = $sql_row['title_size_s47'];
$size48 = $sql_row['title_size_s48'];
$size49 = $sql_row['title_size_s49'];
$size50 = $sql_row['title_size_s50'];

	$flag = $sql_row['title_flag'];
	if($flag == 0)
	{
		$size01 = '01';
$size02 = '02';
$size03 = '03';
$size04 = '04';
$size05 = '05';
$size06 = '06';
$size07 = '07';
$size08 = '08';
$size09 = '09';
$size10 = '10';
$size11 = '11';
$size12 = '12';
$size13 = '13';
$size14 = '14';
$size15 = '15';
$size16 = '16';
$size17 = '17';
$size18 = '18';
$size19 = '19';
$size20 = '20';
$size21 = '21';
$size22 = '22';
$size23 = '23';
$size24 = '24';
$size25 = '25';
$size26 = '26';
$size27 = '27';
$size28 = '28';
$size29 = '29';
$size30 = '30';
$size31 = '31';
$size32 = '32';
$size33 = '33';
$size34 = '34';
$size35 = '35';
$size36 = '36';
$size37 = '37';
$size38 = '38';
$size39 = '39';
$size40 = '40';
$size41 = '41';
$size42 = '42';
$size43 = '43';
$size44 = '44';
$size45 = '45';
$size46 = '46';
$size47 = '47';
$size48 = '48';
$size49 = '49';
$size50 = '50';

	}
}
$sizes_db=array("xs","s","m","l","xl","xxl","xxxl","$size01","$size02","$size03","$size04","$size05","$size06","$size07","$size08","$size09","$size10","$size11","$size12","$size13","$size14","$size15","$size16","$size17","$size18","$size19","$size20","$size21","$size22","$size23","$size24","$size25","$size26","$size27","$size28","$size29","$size30","$size31","$size32","$size33","$size34","$size35","$size36","$size37","$size38","$size39","$size40","$size41","$size42","$size43","$size44","$size45","$size46","$size47","$size48","$size49","$size50");
echo "<div class=\"table-responsive\"><table class=\"table table-bordered\">";


$qtys=array();
$sql="select * from $bai_pro3.recut_v2 where order_tid=\"$tran_order_tid\" order by remarks";
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));

if(mysqli_num_rows($sql_result) > 0){
	echo "<thead><tr>";
	echo "<th class=\"column-title\"><center>Docket ID</center></th>";
	echo "<th class=\"column-title\"><center>Recut Job #</center></th>";
	echo "<th class=\"column-title\"><center>Category</center></th>";
	
	for($i=0;$i<sizeof($order_qtys);$i++)
	{
		if($order_qtys[$i]>0)
		{
			echo "<th class=\"column-title\"><center>".$sizes_db[$i]."</th>";
		}
	}
	
	echo "<th class=\"column-title\"><center>Total Qty</center></th>";
	echo "<th class=\"column-title\"><center>Module</center></th>";
	echo "<th class=\"column-title\"><center>Cut Status</center></th>";
	
	echo "<th class=\"column-title\"><center>Input Status</center></th>";
	echo "</tr></thead>";
}else{
	echo "<h5 style='color:#ff0000;text-align:center'>No data Found</h5>";
}


while($sql_row=mysqli_fetch_array($sql_result))
{
	$qtys=array();
	$module=$sql_row['plan_module'];
	if($sql_row['act_cut_status']=="DONE")
	{
		$qtys[]=$sql_row['a_xs']*$sql_row['a_plies'];
		$qtys[]=$sql_row['a_s']*$sql_row['a_plies'];
		$qtys[]=$sql_row['a_m']*$sql_row['a_plies'];
		$qtys[]=$sql_row['a_l']*$sql_row['a_plies'];
		$qtys[]=$sql_row['a_xl']*$sql_row['a_plies'];
		$qtys[]=$sql_row['a_xxl']*$sql_row['a_plies'];
		$qtys[]=$sql_row['a_xxxl']*$sql_row['a_plies'];
		$qtys[]=$sql_row['a_s01']*$sql_row['a_plies'];
		$qtys[]=$sql_row['a_s02']*$sql_row['a_plies'];
		$qtys[]=$sql_row['a_s03']*$sql_row['a_plies'];
		$qtys[]=$sql_row['a_s04']*$sql_row['a_plies'];
		$qtys[]=$sql_row['a_s05']*$sql_row['a_plies'];
		$qtys[]=$sql_row['a_s06']*$sql_row['a_plies'];
		$qtys[]=$sql_row['a_s07']*$sql_row['a_plies'];
		$qtys[]=$sql_row['a_s08']*$sql_row['a_plies'];
		$qtys[]=$sql_row['a_s09']*$sql_row['a_plies'];
		$qtys[]=$sql_row['a_s10']*$sql_row['a_plies'];
		$qtys[]=$sql_row['a_s11']*$sql_row['a_plies'];
		$qtys[]=$sql_row['a_s12']*$sql_row['a_plies'];
		$qtys[]=$sql_row['a_s13']*$sql_row['a_plies'];
		$qtys[]=$sql_row['a_s14']*$sql_row['a_plies'];
		$qtys[]=$sql_row['a_s15']*$sql_row['a_plies'];
		$qtys[]=$sql_row['a_s16']*$sql_row['a_plies'];
		$qtys[]=$sql_row['a_s17']*$sql_row['a_plies'];
		$qtys[]=$sql_row['a_s18']*$sql_row['a_plies'];
		$qtys[]=$sql_row['a_s19']*$sql_row['a_plies'];
		$qtys[]=$sql_row['a_s20']*$sql_row['a_plies'];
		$qtys[]=$sql_row['a_s21']*$sql_row['a_plies'];
		$qtys[]=$sql_row['a_s22']*$sql_row['a_plies'];
		$qtys[]=$sql_row['a_s23']*$sql_row['a_plies'];
		$qtys[]=$sql_row['a_s24']*$sql_row['a_plies'];
		$qtys[]=$sql_row['a_s25']*$sql_row['a_plies'];
		$qtys[]=$sql_row['a_s26']*$sql_row['a_plies'];
		$qtys[]=$sql_row['a_s27']*$sql_row['a_plies'];
		$qtys[]=$sql_row['a_s28']*$sql_row['a_plies'];
		$qtys[]=$sql_row['a_s29']*$sql_row['a_plies'];
		$qtys[]=$sql_row['a_s30']*$sql_row['a_plies'];
		$qtys[]=$sql_row['a_s31']*$sql_row['a_plies'];
		$qtys[]=$sql_row['a_s32']*$sql_row['a_plies'];
		$qtys[]=$sql_row['a_s33']*$sql_row['a_plies'];
		$qtys[]=$sql_row['a_s34']*$sql_row['a_plies'];
		$qtys[]=$sql_row['a_s35']*$sql_row['a_plies'];
		$qtys[]=$sql_row['a_s36']*$sql_row['a_plies'];
		$qtys[]=$sql_row['a_s37']*$sql_row['a_plies'];
		$qtys[]=$sql_row['a_s38']*$sql_row['a_plies'];
		$qtys[]=$sql_row['a_s39']*$sql_row['a_plies'];
		$qtys[]=$sql_row['a_s40']*$sql_row['a_plies'];
		$qtys[]=$sql_row['a_s41']*$sql_row['a_plies'];
		$qtys[]=$sql_row['a_s42']*$sql_row['a_plies'];
		$qtys[]=$sql_row['a_s43']*$sql_row['a_plies'];
		$qtys[]=$sql_row['a_s44']*$sql_row['a_plies'];
		$qtys[]=$sql_row['a_s45']*$sql_row['a_plies'];
		$qtys[]=$sql_row['a_s46']*$sql_row['a_plies'];
		$qtys[]=$sql_row['a_s47']*$sql_row['a_plies'];
		$qtys[]=$sql_row['a_s48']*$sql_row['a_plies'];
		$qtys[]=$sql_row['a_s49']*$sql_row['a_plies'];
		$qtys[]=$sql_row['a_s50']*$sql_row['a_plies'];

	}
	else
	{
		$qtys[]=$sql_row['p_xs'];
		$qtys[]=$sql_row['p_s'];
		$qtys[]=$sql_row['p_m'];
		$qtys[]=$sql_row['p_l'];
		$qtys[]=$sql_row['p_xl'];
		$qtys[]=$sql_row['p_xxl'];
		$qtys[]=$sql_row['p_xxxl'];
		$qtys[]=$sql_row['p_s01'];
		$qtys[]=$sql_row['p_s02'];
		$qtys[]=$sql_row['p_s03'];
		$qtys[]=$sql_row['p_s04'];
		$qtys[]=$sql_row['p_s05'];
		$qtys[]=$sql_row['p_s06'];
		$qtys[]=$sql_row['p_s07'];
		$qtys[]=$sql_row['p_s08'];
		$qtys[]=$sql_row['p_s09'];
		$qtys[]=$sql_row['p_s10'];
		$qtys[]=$sql_row['p_s11'];
		$qtys[]=$sql_row['p_s12'];
		$qtys[]=$sql_row['p_s13'];
		$qtys[]=$sql_row['p_s14'];
		$qtys[]=$sql_row['p_s15'];
		$qtys[]=$sql_row['p_s16'];
		$qtys[]=$sql_row['p_s17'];
		$qtys[]=$sql_row['p_s18'];
		$qtys[]=$sql_row['p_s19'];
		$qtys[]=$sql_row['p_s20'];
		$qtys[]=$sql_row['p_s21'];
		$qtys[]=$sql_row['p_s22'];
		$qtys[]=$sql_row['p_s23'];
		$qtys[]=$sql_row['p_s24'];
		$qtys[]=$sql_row['p_s25'];
		$qtys[]=$sql_row['p_s26'];
		$qtys[]=$sql_row['p_s27'];
		$qtys[]=$sql_row['p_s28'];
		$qtys[]=$sql_row['p_s29'];
		$qtys[]=$sql_row['p_s30'];
		$qtys[]=$sql_row['p_s31'];
		$qtys[]=$sql_row['p_s32'];
		$qtys[]=$sql_row['p_s33'];
		$qtys[]=$sql_row['p_s34'];
		$qtys[]=$sql_row['p_s35'];
		$qtys[]=$sql_row['p_s36'];
		$qtys[]=$sql_row['p_s37'];
		$qtys[]=$sql_row['p_s38'];
		$qtys[]=$sql_row['p_s39'];
		$qtys[]=$sql_row['p_s40'];
		$qtys[]=$sql_row['p_s41'];
		$qtys[]=$sql_row['p_s42'];
		$qtys[]=$sql_row['p_s43'];
		$qtys[]=$sql_row['p_s44'];
		$qtys[]=$sql_row['p_s45'];
		$qtys[]=$sql_row['p_s46'];
		$qtys[]=$sql_row['p_s47'];
		$qtys[]=$sql_row['p_s48'];
		$qtys[]=$sql_row['p_s49'];
		$qtys[]=$sql_row['p_s50'];

	}
	
	$doc_no=$sql_row['doc_no'];
	$cut_no=$sql_row['acutno'];
	
	$path="Book3_print_recut.php"; 
	
	if(substr($sql_row['order_tid'],0,1)!="P" || substr($sql_row['order_tid'],0,1)!="K" || substr($sql_row['order_tid'],0,1)!="L" || substr($sql_row['order_tid'],0,1)!="O" )
	{
		if($o_total>0)
		{
			$path="Book3_print_recut.php";  // For M&S Men Briefs
		}
		else
		{
			$path="Book3_print_recut1.php"; // FOR M&S Ladies Briefs
		}
		
	}
	
	else
	{
		if(substr($sql_row['order_tid'],0,1)=="Y")
		{
			$path="Book3_print_recut1.php"; // FOR M&S Ladies Briefs	
		}
		
	}

	if($sql_row['plan_module']=="TOP")
	{
		$type=1; //for Samplese
	}
	else
	{
		$type=2; // For normal recut
	}
	
	echo "<td class=\"  \"><center><button class=\"btn btn-info btn-xs\" href=\"$path?order_tid=".$sql_row['order_tid']."&cat_ref=".$sql_row['cat_ref']."&doc_id=".$sql_row['doc_no']."&type=$type\"  onclick=\"return popitup("."'"."$path?order_tid=".$sql_row['order_tid']."&cat_ref=".$sql_row['cat_ref']."&doc_id=".$sql_row['doc_no']."&type=$type"."')\">"."R".leading_zeros($doc_no,8)."</button></center></td>";
	echo "<td class=\"  \"><center>"."R".leading_zeros($cut_no,3)."</center></td>";
	echo "<td class=\"  \"><center>".$sql_row['remarks']."</center></td>";
	for($i=0;$i<sizeof($orde_qtys);$i++)
	{
		if($order_qtys[$i]>0)
		{
			echo "<td class=\"  \"><center>".$qtys[$i]."</center></td>";
		}
	}
	echo "<td class=\"  \"><center>".array_sum($qtys)."</center></td>";
	echo "<td class=\"  \"><center>".$module."</center></td>";
	echo "<td class=\"  \"><center>".$sql_row['act_cut_status']."</center></td>";
	if($sql_row['cut_inp_temp']==1)
	{
		echo "<td class=\"  \"><center>DONE</center></td>";
	}
	else
	{
		echo "<td class=\"  \"><center></center></td>";
	}
	
	echo "</tr>";
	
}
	echo "</table></div>";

?>