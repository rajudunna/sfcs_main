<?php include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config.php');   ?>
<?php include('../../common/php/functions.php'); ?>
<?php ini_set('error_reporting', E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED); ?>
<?php include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/js/mpdf50/mpdf.php'); ?>

<?php
$order_tid=$_GET['order_tid'];
$cat_ref=$_GET['cat_ref'];
$carton_id=$_GET['carton_id'];
?>

<?php
$sql="select * from $bai_pro3.bai_orders_db_confirm where order_tid=\"$order_tid\"";
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_num_confirm=mysqli_num_rows($sql_result);

if($sql_num_confirm>0)
{
	$sql="select * from $bai_pro3.bai_orders_db_confirm where order_tid=\"$order_tid\"";
}
else
{
	$sql="select * from $bai_pro3.bai_orders_db where order_tid=\"$order_tid\"";
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
	$o_xs=$sql_row['order_s_xs'];
	$o_s=$sql_row['order_s_s'];
	$o_m=$sql_row['order_s_m'];
	$o_l=$sql_row['order_s_l'];
	$o_xl=$sql_row['order_s_xl'];
	$o_xxl=$sql_row['order_s_xxl'];
	$o_xxxl=$sql_row['order_s_xxxl'];
	$o_s_s06=$sql_row['order_s_s06'];
	
		$o_s_s08=$sql_row['order_s_s08'];
		$o_s_s10=$sql_row['order_s_s10'];
		$o_s_s12=$sql_row['order_s_s12'];
		$o_s_s14=$sql_row['order_s_s14'];
		$o_s_s16=$sql_row['order_s_s16'];
		$o_s_s18=$sql_row['order_s_s18'];
		$o_s_s20=$sql_row['order_s_s20'];
		$o_s_s22=$sql_row['order_s_s22'];
		$o_s_s24=$sql_row['order_s_s24'];
		$o_s_s26=$sql_row['order_s_s26'];
		$o_s_s28=$sql_row['order_s_s28'];
		$o_s_s30=$sql_row['order_s_s30'];

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
	
	$carton_s06=$sql_row['s06'];
	$carton_s08=$sql_row['s08'];
	$carton_s10=$sql_row['s10'];
	$carton_s12=$sql_row['s12'];
	$carton_s14=$sql_row['s14'];
	$carton_s16=$sql_row['s16'];
	$carton_s18=$sql_row['s18'];
	$carton_s20=$sql_row['s20'];
	$carton_s22=$sql_row['s22'];
	$carton_s24=$sql_row['s24'];
	$carton_s26=$sql_row['s26'];
	$carton_s28=$sql_row['s28'];
	$carton_s30=$sql_row['s30'];
}

$size_titles=array("XS","S","M","L","XL","XXL","XXXL","S06","S08","S10","S12","S14","S16","S18","S20","S22","S24","S26","S28","S30");
$order_qtys=array($o_xs,$o_s,$o_m,$o_l,$o_xl,$o_xxl,$o_xxxl,$o_s_s06,$o_s_s08,$o_s_s10,$o_s_s12,$o_s_s14,$o_s_s16,$o_s_s18,$o_s_s20,$o_s_s22,$o_s_s24,$o_s_s26,$o_s_s28,$o_s_s30);
$carton_qtys=array($carton_xs,$carton_s,$carton_m,$carton_l,$carton_xl,$carton_xxl,$carton_xxxl,$carton_s06,$carton_s08,$carton_s10,$carton_s12,$carton_s14,$carton_s16,$carton_s18,$carton_s20,$carton_s22,$carton_s24,$carton_s26,$carton_s28,$carton_s30);

//ERROR CHECK POINT


$sql="select coalesce((a_xs+a_s+a_m+a_l+a_xl+a_xxl+a_xxxl)*p_plies,0) as \"pilot\" from $bai_pro3.plandoc_stat_log where order_tid=\"$order_tid\" and remarks=\"Pilot\""; //20110911
mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row=mysqli_fetch_array($sql_result))
{
	$pilot_qty=$sql_row['pilot'];
}

$pilot_qty=0; //EXCEPTION

$sql="select sum(carton_act_qty) as \"carton_act_qty\" from $bai_pro3.packing_summary where order_del_no=$delivery";
mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row=mysqli_fetch_array($sql_result))
{
	if((array_sum($order_qtys)-$pilot_qty)!=$sql_row['carton_act_qty'])
	{
		echo "<script type=\"text/javascript\"> 
				setTimeout(\"Redirect()\",0); 
				function Redirect() {  
					location.href = \"error.php\"; 
				}
			</script>";
	}
}

//ERROR CHECK POINT

$sql="select * from $bai_pro2.shipment_plan_summ where ssc_code=\"$order_tid\"";
mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row=mysqli_fetch_array($sql_result))
{
	$cpo=$sql_row['CPO'];
	$mp=str_replace("?","",utf8_decode($sql_row['MPO']));
	//$mp1=explode("/",$mp);
	//$mpo=$mp1[1];
	$cust_ord=$sql_row['Cust_order'];
	$ex_fact=$sql_row['exfact_date'];
	
	$mpo=$mp;
}

?>

<?php


$html = '
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<style>
body {font-family: arial;
	font-size: 16px;
}

.new_td
{
	font-size:15px;
}

.new_td2
{
	font-size:22px;
	font-weight: bold;
}

.new_td3
{
	font-size:18px;
	font-weight: bold;
}

table
{
	margin-left:auto;
	margin-right:auto;
	margin-top:auto;
	margin-bottom:auto;
}
@page {
margin-top: 10px; 

}

</style>
</head>
<body>';



	$docs_db=array();
	$cutno_db=array();
	$sql="select * from $bai_pro3.plandoc_stat_log where cat_ref=$cat_ref order by acutno";
	//echo $sql;
	mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		$docs_db[]=$sql_row['doc_no'];
		$cutno_db[]=$sql_row['acutno'];
	}
	
	$sql="select * from $bai_pro3.pac_stat_log where doc_no in (".implode(",",$docs_db).") order by doc_no, carton_mode desc";
	mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	$total_cartons=mysqli_num_rows($sql_result);
	
	$x=1;
	$carton_nodes=array();
	
	//NEW
	$sql1="select * from $bai_pro3.plandoc_stat_log where doc_no in (".implode(",",$docs_db).") order by acutno";
//echo $sql;
	mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row1=mysqli_fetch_array($sql_result1))
	{
	//NEW
	$doc_no_new=$sql_row1['doc_no']; //NEW
	for($i=0;$i<sizeof($order_qtys);$i++)
  	{	
		if($order_qtys[$i]>0)
		{
			//$sql="select * from pac_stat_log where doc_no in (".implode(",",$docs_db).") and size_code=\"".strtolower($size_titles[$i])."\" order by doc_no, carton_mode desc"; //NEW
 $sql="select * from $bai_pro3.pac_stat_log where doc_no=$doc_no_new and size_code=\"".strtolower($size_titles[$i])."\" order by doc_no, carton_mode desc";
//echo $sql;
			mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row=mysqli_fetch_array($sql_result))
			{
				$doc_no=$sql_row['doc_no'];
				$carton_no=$sql_row['tid'];
				$carton_act_qty=$sql_row['carton_act_qty'];
				$carton_nodes[]=$x."/".$total_cartons."-".chr($color_code).leading_zeros($cutno_db[array_search($doc_no,$docs_db)],3)."-".$carton_act_qty."-".$carton_no."-".$size_titles[$i];
				$x++;
			}
		}
	}
	}//NEW

			for($j=0;$j<sizeof($carton_nodes);$j++)
			{
			
					  $node_detail=array();
					  $node_detail=explode("-",$carton_nodes[$j]);

					 
					 	$html.= '<table><tr><td><table><tr><td colspan=3><barcode code="'.leading_zeros($node_detail[3],8).'" type="C39"/ height="0.70" size="1.1" text="1"></td><td align="middle">'.$node_detail[3].'</td></tr>';
$html.= '<tr><td>Style:</td><td class="new_td">'.$style.'</td><td>Schedule:</td><td class="new_td3">'.$delivery.'</td></tr>';
$html.= '<tr><td>Color:</td><td colspan=3>'.$color.'</td></tr>';
$html.= '<tr><td> Ex-Fac:'.$ex_fact.'</td><td colspan=3 >MPO:'.$mpo.'</td></tr>';
$html.= '<tr><td>Job #:</td><td>'.$node_detail[1].'</td><td>Size:</td><td  class="new_td2">'.$node_detail[4].'</td></tr>';
$html.= '<tr><td>Carton #:</td><td>'.$node_detail[0].'</td><td>Qty.:</td><td class="new_td2">'.$node_detail[2].'</td></tr>';
$html.= '</table></td><td width="37px" text-rotate="90" align="center">'.$location_identity_normal."-".$node_detail[3].'</td></tr></table>';
				if($j<sizeof($carton_nodes)){
					$html.='<pagebreak />';
				}
					

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
</html>
';

$sql="update bai_orders_db_confirm set carton_print_status=1 where order_tid=\"$order_tid\"";
//$sql_result=mysql_query($sql,$link) or exit("Sql Error".mysql_error());



$mpdf=new mPDF('',array(101.6,50.8),0,'',0,0,0,0,0,0,'P'); 

$mpdf->WriteHTML($html);
$mpdf->Output(); 

exit;

?>