<?php include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config.php');   ?>
<?php include('../../common/php/functions.php'); ?>
<?php include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/js/mpdf50/mpdf.php'); ?>
<?php ini_set('error_reporting', E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED); ?>
<?php //require_once '../../../../../common/js/mpdf50/mpdf.php'; ?>

<?php
	$order_tid=$_GET['order_tid'];
	$cat_ref=$_GET['cat_ref'];
	$carton_id=$_GET['carton_id'];
	$style=$_GET['style'];
	$schedule=$_GET['schedule'];
	$color=$_GET['color'];
?>

<?php
$sql="select * from $bai_pro3.bai_orders_db_confirm where order_style_no=\"$style\" and order_del_no=$schedule and order_col_des=\"$color\"";
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_num_confirm=mysqli_num_rows($sql_result);

if($sql_num_confirm>0)
{
	$sql="select * from $bai_pro3.bai_orders_db_confirm where order_style_no=\"$style\" and order_del_no=$schedule and order_col_des=\"$color\"";
}
else
{
	$sql="select * from $bai_pro3.bai_orders_db where order_style_no=\"$style\" and order_del_no=$schedule and order_col_des=\"$color\"";
}
mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_num_=mysqli_num_rows($sql_result);
while($sql_row=mysqli_fetch_array($sql_result))
{
	$style=$sql_row['order_style_no']; //Style
	$color=str_replace("?","",utf8_decode($sql_row['order_col_des'])); //color
	$division=$sql_row['order_div'];
	$delivery=$sql_row['order_del_no']; //Schedule
	$pono=$sql_row['order_po_no']; //po
	$color_code=$sql_row['color_code']; //Color Code
	$orderno=$sql_row['order_no']; 
	$o_xs+=$sql_row['order_s_xs'];
	$o_s+=$sql_row['order_s_s'];
	$o_m+=$sql_row['order_s_m'];
	$o_l+=$sql_row['order_s_l'];
	$o_xl+=$sql_row['order_s_xl'];
	$o_xxl+=$sql_row['order_s_xxl'];
	$o_xxxl+=$sql_row['order_s_xxxl'];
		$o_s_s01+=$sql_row['order_s_s01'];
		$o_s_s02+=$sql_row['order_s_s02'];
		$o_s_s03+=$sql_row['order_s_s03'];
		$o_s_s04+=$sql_row['order_s_s04'];
		$o_s_s05+=$sql_row['order_s_s05'];
		$o_s_s06+=$sql_row['order_s_s06'];
		$o_s_s07+=$sql_row['order_s_s07'];
		$o_s_s08+=$sql_row['order_s_s08'];
		$o_s_s09+=$sql_row['order_s_s09'];
		$o_s_s10+=$sql_row['order_s_s10'];
		$o_s_s11+=$sql_row['order_s_s11'];
		$o_s_s12+=$sql_row['order_s_s12'];
		$o_s_s13+=$sql_row['order_s_s13'];
		$o_s_s14+=$sql_row['order_s_s14'];
		$o_s_s15+=$sql_row['order_s_s15'];
		$o_s_s16+=$sql_row['order_s_s16'];
		$o_s_s17+=$sql_row['order_s_s17'];
		$o_s_s18+=$sql_row['order_s_s18'];
		$o_s_s19+=$sql_row['order_s_s19'];
		$o_s_s20+=$sql_row['order_s_s20'];
		$o_s_s21+=$sql_row['order_s_s21'];
		$o_s_s22+=$sql_row['order_s_s22'];
		$o_s_s23+=$sql_row['order_s_s23'];
		$o_s_s24+=$sql_row['order_s_s24'];
		$o_s_s25+=$sql_row['order_s_s25'];
		$o_s_s26+=$sql_row['order_s_s26'];
		$o_s_s27+=$sql_row['order_s_s27'];
		$o_s_s28+=$sql_row['order_s_s28'];
		$o_s_s29+=$sql_row['order_s_s29'];
		$o_s_s30+=$sql_row['order_s_s30'];
		$o_s_s31+=$sql_row['order_s_s31'];
		$o_s_s32+=$sql_row['order_s_s32'];
		$o_s_s33+=$sql_row['order_s_s33'];
		$o_s_s34+=$sql_row['order_s_s34'];
		$o_s_s35+=$sql_row['order_s_s35'];
		$o_s_s36+=$sql_row['order_s_s36'];
		$o_s_s37+=$sql_row['order_s_s37'];
		$o_s_s38+=$sql_row['order_s_s38'];
		$o_s_s39+=$sql_row['order_s_s39'];
		$o_s_s40+=$sql_row['order_s_s40'];
		$o_s_s41+=$sql_row['order_s_s41'];
		$o_s_s42+=$sql_row['order_s_s42'];
		$o_s_s43+=$sql_row['order_s_s43'];
		$o_s_s44+=$sql_row['order_s_s44'];
		$o_s_s45+=$sql_row['order_s_s45'];
		$o_s_s46+=$sql_row['order_s_s46'];
		$o_s_s47+=$sql_row['order_s_s47'];
		$o_s_s48+=$sql_row['order_s_s48'];
		$o_s_s49+=$sql_row['order_s_s49'];
		$o_s_s50+=$sql_row['order_s_s50'];
		
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
			
			if($flag==0)
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
	
	
	$order_total=$o_xs+$o_s+$o_m+$o_l+$o_xl+$o_xxl+$o_xxxl;
	$order_date=$sql_row['order_date'];
	$order_joins=$sql_row['order_joins'];
	$packing_method=$sql_row['packing_method'];
	$carton_id=$sql_row['carton_id'];
}

$sql="select * from $bai_pro3.carton_qty_chart where id=$carton_id";
mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row=mysqli_fetch_array($sql_result))
{
	$carton_xs=$sql_row['xs'];
	$carton_s=$sql_row['s'];
	$carton_m=$sql_row['m'];
	$carton_l=$sql_row['l'];
	$carton_xl=$sql_row['xl'];
	$carton_xxl=$sql_row['xxl'];
	$carton_xxxl=$sql_row['xxxl'];
	
	$carton_s01=$sql_row['s01'];
	$carton_s02=$sql_row['s02'];
	$carton_s03=$sql_row['s03'];
	$carton_s04=$sql_row['s04'];
	$carton_s05=$sql_row['s05'];
	$carton_s06=$sql_row['s06'];
	$carton_s07=$sql_row['s07'];
	$carton_s08=$sql_row['s08'];
	$carton_s09=$sql_row['s09'];
	$carton_s10=$sql_row['s10'];
	$carton_s11=$sql_row['s11'];
	$carton_s12=$sql_row['s12'];
	$carton_s13=$sql_row['s13'];
	$carton_s14=$sql_row['s14'];
	$carton_s15=$sql_row['s15'];
	$carton_s16=$sql_row['s16'];
	$carton_s17=$sql_row['s17'];
	$carton_s18=$sql_row['s18'];
	$carton_s19=$sql_row['s19'];
	$carton_s20=$sql_row['s20'];
	$carton_s21=$sql_row['s21'];
	$carton_s22=$sql_row['s22'];
	$carton_s23=$sql_row['s23'];
	$carton_s24=$sql_row['s24'];
	$carton_s25=$sql_row['s25'];
	$carton_s26=$sql_row['s26'];
	$carton_s27=$sql_row['s27'];
	$carton_s28=$sql_row['s28'];
	$carton_s29=$sql_row['s29'];
	$carton_s30=$sql_row['s30'];
	$carton_s31=$sql_row['s31'];
	$carton_s32=$sql_row['s32'];
	$carton_s33=$sql_row['s33'];
	$carton_s34=$sql_row['s34'];
	$carton_s35=$sql_row['s35'];
	$carton_s36=$sql_row['s36'];
	$carton_s37=$sql_row['s37'];
	$carton_s38=$sql_row['s38'];
	$carton_s39=$sql_row['s39'];
	$carton_s40=$sql_row['s40'];
	$carton_s41=$sql_row['s41'];
	$carton_s42=$sql_row['s42'];
	$carton_s43=$sql_row['s43'];
	$carton_s44=$sql_row['s44'];
	$carton_s45=$sql_row['s45'];
	$carton_s46=$sql_row['s46'];
	$carton_s47=$sql_row['s47'];
	$carton_s48=$sql_row['s48'];
	$carton_s49=$sql_row['s49'];
	$carton_s50=$sql_row['s50'];
}

$size_titles=array("XS","S","M","L","XL","XXL","XXXL",$size01,$size02,$size03,$size04,$size05,$size06,$size07,$size08,$size09,$size10,$size11,$size12,$size13,$size14,$size15,$size16,$size17,$size18,$size19,$size20,$size21,$size22,$size23,$size24,$size25,$size26,$size27,$size28,$size29,$size30,$size31,$size32,$size33,$size34,$size35,$size36,$size37,$size38,$size39,$size40,$size41,$size42,$size43,$size44,$size45,$size46,$size47,$size48,$size49,$size50);
$size_titles_qry=array("XS","S","M","L","XL","XXL","XXXL","s01","s02","s03","s04","s05","s06","s07","s08","s09","s10","s11","s12","s13","s14","s15","s16","s17","s18","s19","s20","s21","s22","s23","s24","s25","s26","s27","s28","s29","s30","s31","s32","s33","s34","s35","s36","s37","s38","s39","s40","s41","s42","s43","s44","s45","s46","s47","s48","s49","s50");
$order_qtys=array($o_xs,$o_s,$o_m,$o_l,$o_xl,$o_xxl,$o_xxxl,$o_s_s01,$o_s_s02,$o_s_s03,$o_s_s04,$o_s_s05,$o_s_s06,$o_s_s07,$o_s_s08,$o_s_s09,$o_s_s10,$o_s_s11,$o_s_s12,$o_s_s13,$o_s_s14,$o_s_s15,$o_s_s16,$o_s_s17,$o_s_s18,$o_s_s19,$o_s_s20,$o_s_s21,$o_s_s22,$o_s_s23,$o_s_s24,$o_s_s25,$o_s_s26,$o_s_s27,$o_s_s28,$o_s_s29,$o_s_s30,$o_s_s31,$o_s_s32,$o_s_s33,$o_s_s34,$o_s_s35,$o_s_s36,$o_s_s37,$o_s_s38,$o_s_s39,$o_s_s40,$o_s_s41,$o_s_s42,$o_s_s43,$o_s_s44,$o_s_s45,$o_s_s46,$o_s_s47,$o_s_s48,$o_s_s49,$o_s_s50);
$carton_qtys=array($carton_xs,$carton_s,$carton_m,$carton_l,$carton_xl,$carton_xxl,$carton_xxxl,$carton_s01,$carton_s02,$carton_s03,$carton_s04,$carton_s05,$carton_s06,$carton_s07,$carton_s08,$carton_s09,$carton_s10,$carton_s11,$carton_s12,$carton_s13,$carton_s14,$carton_s15,$carton_s16,$carton_s17,$carton_s18,$carton_s19,$carton_s20,$carton_s21,$carton_s22,$carton_s23,$carton_s24,$carton_s25,$carton_s26,$carton_s27,$carton_s28,$carton_s29,$carton_s30,$carton_s31,$carton_s32,$carton_s33,$carton_s34,$carton_s35,$carton_s36,$carton_s37,$carton_s38,$carton_s39,$carton_s40,$carton_s41,$carton_s42,$carton_s43,$carton_s44,$carton_s45,$carton_s46,$carton_s47,$carton_s48,$carton_s49,$carton_s50);


//ERROR CHECK POINT

$sql="select sum(carton_act_qty) as \"carton_act_qty\" from $bai_pro3.packing_summary where order_del_no=$delivery and order_col_des=\"$color\"";
mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row=mysqli_fetch_array($sql_result))
{
	if(array_sum($order_qtys)!=$sql_row['carton_act_qty'])
	{
		$url = getFullURL($_GET['r'],'error.php','N');
		echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = \"$url\"; }</script>";
	}
}

//ERROR CHECK POINT

$sql="select * from $bai_pro2.shipment_plan_summ where ssc_code=\"$order_tid\"";
mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row=mysqli_fetch_array($sql_result))
{
	$cpo=$sql_row['CPO'];
	$mpo=$sql_row['MPO'];
	$cust_ord=$sql_row['Cust_order'];
}

?>

<?php


$html = '
<html>
<head>
<style>
body {font-family: Arial;
	font-size: 10px;
	font-weight: bold;
}

.new_td
{
	font-family: Arial;
	font-size:12px;
	font-weight: bold;
	white-space:nowrap; 
	border-collapse:collapse;
}

tr
{
	font-size: 10px;
	font-weight: bold;
	white-space:nowrap; 
	border-collapse:collapse;
}
td
{
	
	font-size: 10px;
	font-weight: bold;
	white-space:nowrap; 
	border-collapse:collapse;
	
}

.new_td2
{
	font-family: Arial;
	font-size:12px;
	font-weight: bold;
	white-space:nowrap; 
	border-collapse:collapse;
}
.new_td3
{
	font-family: Arial;
	font-size:10px;
	font-weight: bold;
	white-space:nowrap; 
	border-collapse:collapse;
}

table
{
	font-size: 10px;
	font-weight: bold;
	font-family: Arial;
	margin-left:auto;
	margin-right:auto;
	margin-top:auto;
	margin-bottom:auto;
	white-space:nowrap; 
	border-collapse:collapse;
}
@page {
font-size: 10px;
font-weight: bold;
font-family: Arial;
margin-top: 0.9mm;
margin-left: 0.9mm; 
white-space:nowrap; 
	border-collapse:collapse;
	
 
}


</style>
</head>
<body>';



	
	
	$sql="select distinct doc_no_ref from $bai_pro3.packing_summary where order_style_no=\"$style\" and order_del_no=$schedule and order_col_des=\"$color\"";
	mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	$total_cartons=mysqli_num_rows($sql_result);
	
	$x=1;
	$carton_nodes=array();
	
		for($i=0;$i<sizeof($order_qtys);$i++)
  	{	
		if($order_qtys[$i]>0)
		{
			//$sql="select * from pac_stat_log where doc_no in (".implode(",",$docs_db).") and size_code=\"".strtolower($size_titles[$i])."\" order by doc_no, carton_mode desc"; //NEW
 $sql="select remarks, min(carton_act_qty) as \"packs\", min(tid) as \"tid\", sum(carton_act_qty) as \"carton_act_qty\", doc_no, group_concat(distinct left(trim(order_col_des),7)  ORDER BY tid SEPARATOR \"+\") as \"color_title\",group_concat(trim(carton_act_qty)  ORDER BY tid SEPARATOR \" + \") as \"pcs_title\" from $bai_pro3.packing_summary where order_style_no=\"$style\" and order_del_no=$schedule and order_col_des=\"$color\" and  size_code=\"".strtolower($size_titles_qry[$i])."\" group by doc_no_ref";
//echo $sql;
			mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row=mysqli_fetch_array($sql_result))
			{
				$doc_no=$sql_row['doc_no'];
				$carton_no=$sql_row['tid'];
				$carton_act_qty=$sql_row['carton_act_qty'];
				$color_title=$sql_row['color_title'];
				//$pcs_title=strlen($sql_row['pcs_title']).$sql_row['pcs_title'];
				$pcs_title=$sql_row['pcs_title'];
				
				if(strlen($pcs_title)>12)
				{
					$pcs_title="";
				}
				
				//$packs=$carton_act_qty/array_sum();
				$temp1=array();
				$temp1=explode("*",$sql_row['remarks']);
				$temp2=array();
				$temp2=explode("$",$temp1[0]);
				$packs=$carton_act_qty/array_sum($temp2);
				$ratio=implode(":",$temp2);
				//$packs=$sql_row['packs'];
				$carton_nodes[]=$x."/".$total_cartons."$".$pcs_title."$".$carton_act_qty."$".$carton_no."$".$size_titles[$i]."$".$color_title."$".$packs."$".$ratio;
				$x++;
			}
		}
	}


			for($j=0;$j<sizeof($carton_nodes);$j++)
			{
			
					  //date:2012-04-12
					  //Added this code for showing Jobs for M&s Sticker labels
					 
					  $doc_nos=array();
					  $job_nos=array();
					  $node_detail=array();
					  $node_detail=explode("$",$carton_nodes[$j]);
					  
					  $sql2="select doc_no_ref from $bai_pro3.packing_summary where tid=\"".$node_detail[3]."\"";
					  $result2=mysqli_query($link, $sql2) or die("Error = ".mysqli_error($GLOBALS["___mysqli_ston"]));
					  while($row2=mysqli_fetch_array($result2))
					  {
					  	$doc_ref=$row2["doc_no_ref"];
					  }
					  
					  $doc_ref_size=explode(",",$doc_ref);
					  
					  for($k=0;$k<sizeof($doc_ref_size);$k++)
					  {
					  	$doc_ref_explode=explode("-",$doc_ref_size[$k]);
						$doc_nos[]=$doc_ref_explode[0];
					  }
					  
					  for($l=0;$l<sizeof($doc_nos);$l++)
					  {
					  	  $sql3="select color_code,acutno from $bai_pro3.order_cat_doc_mk_mix where doc_no=\"".$doc_nos[$l]."\" ";
						  $result3=mysqli_query($link, $sql3) or die("Error = ".mysqli_error($GLOBALS["___mysqli_ston"]));
						  while($row3=mysqli_fetch_array($result3))
						  {
						  	$color_codes=chr($row3["color_code"]);
							$cutno=$row3["acutno"];
							$job_nos[]=$color_codes."".$cutno;
						  }					  
					  }
					  
					 
					 	/*$html.= '<div><table><tr><td colspan=4 ><barcode code="'.leading_zeros($node_detail[3],8).'" type="C39"/ height="0.45" size="0.80" text="1"></td><td align="middle" class="new_td3" colspan=2>'.$node_detail[3].'</td></tr>';
$html.= '<tr><td>Style:</td><td class="new_td3">'.$style.'</td><td>Schedule:</td><td class="new_td3" colospan=5>'.$delivery.'</td></tr>';
$html.= '<tr><td colspan=6>Color:  <font size=3>'.$node_detail[5].'</font></td></tr>';
$html.= '<tr><td>Assort:</td><td colspan=5><font size=2>'.$packing_method.'  '.$node_detail[1].'('.$node_detail[7].')'.'</font></td><td align="left">Packs:</td><td>'.$node_detail[6].'</td>s</tr>';
$html.= '<tr><td colspan=2>Carton #:'.$node_detail[0].'</td><td>Size:</td><td  class="new_td2">'.$node_detail[4].'</td><td>Qty.:</td><td class="new_td2">'.$node_detail[2].'</td></tr>';*/


$html.= '<div><table><tr><td align="middle">'.$node_detail[3].'</td><td colspan=3><barcode code="'.leading_zeros($node_detail[3],8).'" type="C39"/ height="0.50" size="0.80" text="1"></td></tr>';
$html.= '<tr><td>Style:</td><td class="new_td">'.$style.'</td><td>Schedule:</td><td class="new_td3">'.$delivery.'</td></tr>';
$html.= '<tr><td colspan=4>Color:  <font size=2>'.substr($node_detail[5],0,100).'</font></td></tr>';
$html.= '<tr><td>Assort:</td><td><font size=2>'.$packing_method." ".$node_detail[1].'('.$node_detail[7].')'.'</font></td><td>Packs:</td><td>'.$node_detail[6].'</td></tr>';
$html.= '<tr><td>Jobs:</td><td><font size=2>'.implode(",",$job_nos).'</font></td><td>Size:</td><td>Qty:</td></tr>';
$html.= '<tr><td>Carton #:</td><td>'.$node_detail[0].'</td><td  class="new_td2">'.$node_detail[4].'</td><td class="new_td2">'.$node_detail[2].'</td></tr>';

$html.= '</table></div>';
				if($j<sizeof($carton_nodes)){
					$html.='<pagebreak />';
				}
	$doc_nos="";
	$job_nos="";				

			}
	


/* <table>
<tr>
<td align="center">C39</td>
<td>CODE 39 - ANSI MH10.8M-1983 - USD-3 - 3 of 9. Valid characters: [0-9 A-Z \'-\' . Space $/+%]</td>
<td class="barcodecell"><barcode code="TEC-IT" type="C39" class="barcode" /></td>
</tr>
<tr>
</table>
<pagebreak/>
<table>
<tr>
<td align="center">C39</td>
<td>CODE 39 - ANSI MH10.8M-1983 - USD-3 - 3 of 9. Valid characters: [0-9 A-Z \'-\' . Space $/+%]</td>
<td class="barcodecell"><barcode code="TEC-IT" type="C39" class="barcode" /></td>
</tr>
<tr>
</table> */

$html.='</body>
	</html>';

$sql="update $bai_pro3.bai_orders_db_confirm set carton_print_status=1 where order_del_no=$schedule";
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));

//==============================================================
//==============================================================


$mpdf = new mPDF('',array(63.5,25.0),0,'',0,0,0,0,0,0,'P'); 
$mpdf->WriteHTML($html);
$mpdf->Output(); 

exit;

?>