<?php include('../'.getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));	?>
<?php include('../'.getFullURLLevel($_GET['r'],'common/php/functions.php',2,'R'));	?>

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
	$color=$sql_row['order_col_des']; //color
	$division=$sql_row['order_div'];
	$delivery=$sql_row['order_del_no']; //Schedule
	$schedule=$sql_row['order_del_no'];
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

	$order_total=$o_xs+$o_s+$o_m+$o_l+$o_xl+$o_xxl+$o_xxxl+$o_s_s06+$o_s_s08+$o_s_s10+$o_s_s12+$o_s_s14+$o_s_s16+$o_s_s18+$o_s_s20+$o_s_s22+$o_s_s24+$o_s_s26+$o_s_s28+$o_s_s30;
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
		echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = \"error.php\"; }</script>";
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

$sql="select ims_mod_no from $bai_pro3.ims_log where ims_cid=$cat_ref and ims_date=(select min(ims_date) from $bai_pro3.ims_log where ims_cid=$cat_ref)";
mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row=mysqli_fetch_array($sql_result))
{
	$module=$sql_row['ims_mod_no'];
}


?>


<html xmlns:o="urn:schemas-microsoft-com:office:office"
xmlns:x="urn:schemas-microsoft-com:office:excel"
xmlns="http://www.w3.org/TR/REC-html40">

<head>
<title>Packing List</title>
<meta http-equiv=Content-Type content="text/html; charset=windows-1252">
<meta name=ProgId content=Excel.Sheet>
<meta name=Generator content="Microsoft Excel 12">
<style id="Book3_19400_Styles">

@media print {
   thead {display: table-header-group;}
}

<!--table
	{mso-displayed-decimal-separator:"\.";
	mso-displayed-thousand-separator:"\,";}
	
	.new
	{
		font-family:Calibri, sans-serif;
		font-size:12.0pt;
		border-collapse:collapse;
		border:1px solid black;
		white-space:nowrap;
	}
	

.xl6319400
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:windowtext;
	font-size:12.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:general;
	vertical-align:middle;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl6419400
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:windowtext;
	font-size:12.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:general;
	vertical-align:bottom;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl6519400
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:windowtext;
	font-size:12.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:general;
	vertical-align:middle;
	background:white;
	mso-pattern:black none;
	white-space:nowrap;}
.xl6619400
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:12.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:general;
	vertical-align:bottom;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl6719400
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:12.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl6819400
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:windowtext;
	font-size:16.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl6919400
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:windowtext;
	font-size:11.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:right;
	vertical-align:middle;
	/* border:.5pt solid windowtext;*/
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl7019400
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:windowtext;
	font-size:11.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
	
	.xl7019400_new
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:windowtext;
	font-size:11.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-bottom:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
	
.xl7119400
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:windowtext;
	font-size:11.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl7219400
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:windowtext;
	font-size:11.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:general;
	vertical-align:bottom;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl7319400
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:windowtext;
	font-size:11.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	background:white;
	mso-pattern:black none;
	white-space:nowrap;}
.xl7419400
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:windowtext;
	font-size:11.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:right;
	vertical-align:middle;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl7519400
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:windowtext;
	font-size:11.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:.5pt solid windowtext;
	border-right:.5pt solid windowtext;
	border-bottom:.5pt solid windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl7619400
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:windowtext;
	font-size:11.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl7719400
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:11.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:none;
	border-right:.5pt solid windowtext;
	border-bottom:none;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl7819400
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:11.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl7919400
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:11.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl8019400
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:11.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
	
	.xl8019400_new
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:11.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;
	line-height:2px;}
	
.xl8119400
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:11.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:.5pt solid windowtext;
	border-right:none;
	border-bottom:.5pt solid windowtext;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl8219400
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:11.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:none;
	border-right:none;
	border-bottom:1.0pt solid windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl8319400
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:11.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:.5pt solid windowtext;
	border-right:none;
	border-bottom:1.0pt solid windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl8419400
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:11.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl8519400
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:11.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:.5pt solid windowtext;
	border-right:none;
	border-bottom:none;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl8619400
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:11.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:none;
	border-right:none;
	border-bottom:1.0pt solid windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
	.xl8619400_new
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:0.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:none;
	border-right:none;
	border-bottom:1px solid windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl8719400
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:windowtext;
	font-size:11.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:right;
	vertical-align:bottom;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl8819400
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:11.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:none;
	border-right:none;
	border-bottom:.5pt solid windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl8919400
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:windowtext;
	font-size:11.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:bottom;
	border-top:none;
	border-right:none;
	border-bottom:.5pt solid windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
-->
</style>
</head>

<body>
<!--[if !excel]>&nbsp;&nbsp;<![endif]-->
<!--The following information was generated by Microsoft Office Excel's Publish
as Web Page wizard.-->
<!--If the same item is republished from Excel, all information between the DIV
tags will be replaced.-->
<!----------------------------->
<!--START OF OUTPUT FROM EXCEL PUBLISH AS WEB PAGE WIZARD -->
<!----------------------------->

<div id="Book3_19400" align=center x:publishsource="Excel">

<table border=0 cellpadding=0 cellspacing=0 width=1210 class=xl6619400
 style='border-collapse:collapse;table-layout:fixed;width:903pt'>
 <col class=xl6619400 width=74 style='mso-width-source:userset;mso-width-alt:
 2706;width:56pt'>
 <col class=xl6619400 width=47 span=19 style='mso-width-source:userset;
 mso-width-alt:1718;width:35pt'>
 <col class=xl6619400 width=51 style='mso-width-source:userset;mso-width-alt:
 1865;width:38pt'>
 <col class=xl6619400 width=64 style='width:48pt'>
 <col class=xl6619400 width=64 span=2 style='width:48pt'>
 <thead>
 <tr class=xl6419400 height=22 style='mso-height-source:userset;height:16.5pt'>
  <td colspan=21 height=22 class=xl6819400 width=1018 style='height:16.5pt;
  width:759pt'>FG CHECK List</td>
  <td class=xl6319400 width=64 style='width:48pt'></td>
  <td class=xl6319400 width=64 style='width:48pt'></td>
  <td class=xl6319400 width=64 style='width:48pt'></td>
 </tr>
 <tr class=xl6419400 height=13 style='mso-height-source:userset;height:9.75pt'>
  <td height=13 class=xl6319400 style='height:9.75pt'></td>
  <td class=xl6319400></td>
  <td class=xl6519400>&nbsp;</td>
  <td class=xl6519400>&nbsp;</td>
  <td class=xl6319400></td>
  <td class=xl6319400></td>
  <td class=xl6419400></td>
  <td class=xl6419400></td>
  <td class=xl6419400></td>
  <td class=xl6419400></td>
  <td class=xl6319400></td>
  <td class=xl6319400></td>
  <td class=xl6419400></td>
  <td class=xl6419400></td>
  <td class=xl6419400></td>
  <td class=xl6419400></td>
  <td class=xl6319400></td>
  <td class=xl6319400></td>
  <td class=xl6319400></td>
  <td class=xl6319400></td>
  <td class=xl6419400></td>
  <td class=xl6419400></td>
  <td class=xl6419400></td>
  <td class=xl6419400></td>
 </tr>
 <tr class=xl7219400 height=22 style='mso-height-source:userset;height:16.5pt'>
  <td height=22 class=xl6919400 style='height:16.5pt'>Style :</td>
  <td colspan=4 class=xl7019400_new style='border-left:none'><?php echo trim($style); ?></td>
  <td class=xl7119400></td>
  <td colspan=3 class=xl6919400>Buyer Division :</td>
  <td colspan=4 class=xl7019400_new style='border-left:none'><?php echo trim($division); ?></td>
  <td class=xl7119400></td>
  <td class=xl7119400></td>
  <td colspan=3 class=xl6919400>Customer Order :</td>
  <td colspan=3 class=xl7019400_new style='border-left:none'><?php echo trim($cust_ord); ?></td>
  <td class=xl7219400></td>
  <td class=xl7219400></td>
  <td class=xl7219400></td>
 </tr>
 <tr class=xl7219400 height=22 style='mso-height-source:userset;height:16.5pt'>
  <td height=22 class=xl6919400 style='height:16.5pt;border-top:none'>Sch No :</td>
  <td colspan=4 class=xl7019400_new style='border-left:none'><?php echo trim($delivery); ?></td>
  <td class=xl7119400></td>
  <td colspan=3 class=xl6919400>MPO :</td>
  <td colspan=4 class=xl7019400_new style='border-left:none'><?php echo trim($mpo); ?></td>
  <td class=xl7119400></td>
  <td class=xl7119400></td>
  <td colspan=3 class=xl6919400>Packing Method :</td>
  <td colspan=3 class=xl7019400_new style='border-left:none'><?php echo trim($packing_method); ?></td>
  <td class=xl7219400></td>
  <td class=xl7219400></td>
  <td class=xl7219400></td>
 </tr>
 <tr class=xl7219400 height=22 style='mso-height-source:userset;height:16.5pt'>
  <td height=22 class=xl6919400 style='height:16.5pt;border-top:none'>Color :</td>
  <td colspan=12 class=xl7019400_new style='border-left:none'><?php echo trim($color); ?></td>
  <td class=xl7119400></td>
  <td class=xl7119400></td>
  <td colspan=3 class=xl6919400>CPO :</td>
  <td colspan=3 class=xl7019400_new style='border-left:none'><?php echo trim($cpo); ?></td>
  <td class=xl7219400></td>
  <td class=xl7219400></td>
  <td class=xl7219400></td>
 </tr>
 <tr class=xl7219400 height=22 style='mso-height-source:userset;height:16.5pt'>
  <td height=22 class=xl7119400 style='height:16.5pt'></td>
  <td class=xl7119400></td>
  <td class=xl7319400>&nbsp;</td>
  <td class=xl7319400>&nbsp;</td>
  <td class=xl7119400></td>
  <td class=xl7119400></td>
  <td class=xl7119400></td>
  <td class=xl7119400></td>
  <td class=xl7119400></td>
  <td class=xl7119400></td>
  <td class=xl7119400></td>
  <td class=xl7119400></td>
  <td class=xl7119400></td>
  <td class=xl7119400></td>
  <td class=xl7119400></td>
  <td class=xl7119400></td>
  <td class=xl7119400></td>
  <td class=xl7119400></td>
  <td class=xl7119400></td>
  <td class=xl7119400></td>
  <td class=xl7119400></td>
  <td class=xl7219400></td>
  <td class=xl7219400></td>
  <td class=xl7219400></td>
 </tr>
 <tr class=xl7219400 height=21 style='mso-height-source:userset;height:15.75pt'>
  <td height=21 class=xl7419400 style='height:15.75pt'>Size:</td>
  
  <!-- <td class=xl7019400>&nbsp;</td>
  <td class=xl7519400>&nbsp;</td>
  <td class=xl7019400 style='border-left:none'>&nbsp;</td>
  <td class=xl7019400 style='border-left:none'>&nbsp;</td>
  <td class=xl7019400 style='border-left:none'>&nbsp;</td>
  <td class=xl7019400 style='border-left:none'>&nbsp;</td>
  <td class=xl7019400 style='border-left:none'>&nbsp;</td>
  <td class=xl7019400 style='border-left:none'>&nbsp;</td>
  <td class=xl7019400 style='border-left:none'>&nbsp;</td>
  <td class=xl7019400 style='border-left:none'>&nbsp;</td>
  <td class=xl7019400 style='border-left:none'>&nbsp;</td>
  <td class=xl7019400 style='border-left:none'>&nbsp;</td>
  <td class=xl7019400 style='border-left:none'>&nbsp;</td> -->
  
  
  <?php
  
  $count=0;
  for($i=0;$i<sizeof($order_qtys);$i++)
  {
  	if($order_qtys[$i]>0)
	{
		echo "<td class=xl7019400>".$size_titles[$i]."</td>";
		$count++;
	}
  }
  for($i=0;$i<13-$count-1;$i++)
  {
  	echo "<td class=xl7019400>&nbsp;</td>";
  }
  echo "<td class=xl7019400>Total</td>";
  ?>
  
  <td class=xl7419400>Sec.:</td>
  <td class=xl7019400>&nbsp;</td>
  <td class=xl7019400 style='border-left:none'>&nbsp;</td>
  <td class=xl7019400 style='border-left:none'>&nbsp;</td>
  <td class=xl7019400 style='border-left:none'>&nbsp;</td>
  <td class=xl7019400 style='border-left:none'>&nbsp;</td>
  <td class=xl7019400 style='border-left:none'>&nbsp;</td>
  <td class=xl7219400></td>
  <td class=xl7219400></td>
  <td class=xl7219400></td>
 </tr>
 <tr class=xl7219400 height=21 style='mso-height-source:userset;height:15.75pt'>
  <td height=21 class=xl7419400 style='height:15.75pt'>Qty:</td>
  
  <!-- <td class=xl7019400 style='border-top:none'>&nbsp;</td>
  <td class=xl7519400 style='border-top:none'>&nbsp;</td>
  <td class=xl7019400 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl7019400 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl7019400 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl7019400 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl7019400 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl7019400 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl7019400 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl7019400 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl7019400 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl7019400 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl7019400 style='border-top:none;border-left:none'>&nbsp;</td> -->
  
  <?php
  
  $count=0;
  for($i=0;$i<sizeof($order_qtys);$i++)
  {
  	if($order_qtys[$i]>0)
	{
		echo "<td class=xl7019400>".$order_qtys[$i]."</td>";
		$count++;
	}
  }
  for($i=0;$i<13-$count-1;$i++)
  {
  	echo "<td class=xl7019400>&nbsp;</td>";
  }
  echo "<td class=xl7019400>$order_total</td>";
  
  ?>
  
  
  <td class=xl7419400>Mod.:</td>
  <td class=xl7019400 style='border-top:none'><?php echo $module; ?></td>
  <td class=xl7019400 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl7019400 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl7019400 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl7019400 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl7019400 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl7219400></td>
  <td class=xl7219400></td>
  <td class=xl7219400></td>
 </tr>
 <tr class=xl7219400 height=21 style='mso-height-source:userset;height:15.75pt'>
  <td height=21 class=xl7419400 style='height:15.75pt'>Std. Qty:</td>
  
  <!-- <td class=xl7019400 style='border-top:none'>&nbsp;</td>
  <td class=xl7519400 style='border-top:none'>&nbsp;</td>
  <td class=xl7019400 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl7019400 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl7019400 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl7019400 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl7019400 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl7019400 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl7019400 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl7019400 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl7019400 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl7019400 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl7019400 style='border-top:none;border-left:none'>&nbsp;</td> -->
  
  <?php
  
  $count=0;
  for($i=0;$i<sizeof($order_qtys);$i++)
  {
  	if($order_qtys[$i]>0)
	{
		echo "<td class=xl7019400>".$carton_qtys[$i]."</td>";
		$count++;
	}
  }
  for($i=0;$i<13-$count;$i++)
  {
  	echo "<td class=xl7019400>&nbsp;</td>";
  }
  
  ?>
  
  <td class=xl7119400></td>
  <td class=xl7219400></td>
  <td class=xl7219400></td>
  <td class=xl7219400></td>
  <td class=xl7219400></td>
  <td class=xl7219400></td>
  <td class=xl7219400></td>
  <td class=xl7219400></td>
  <td class=xl7219400></td>
  <td class=xl7219400></td>
 </tr>
 <tr class=xl7219400 height=21 style='mso-height-source:userset;height:15.75pt'>
  <td height=21 class=xl7619400 style='height:15.75pt'></td>
  <td class=xl7119400></td>
  <td class=xl7119400></td>
  <td class=xl7119400></td>
  <td class=xl7119400></td>
  <td class=xl7119400></td>
  <td class=xl7119400></td>
  <td class=xl7119400></td>
  <td class=xl7119400></td>
  <td class=xl7119400></td>
  <td class=xl7119400></td>
  <td class=xl7119400></td>
  <td class=xl7119400></td>
  <td class=xl7119400></td>
  <td class=xl7119400></td>
  <td class=xl7219400></td>
  <td class=xl7219400></td>
  <td class=xl7219400></td>
  <td class=xl7219400></td>
  <td class=xl7219400></td>
  <td class=xl7219400></td>
  <td class=xl7219400></td>
  <td class=xl7219400></td>
  <td class=xl7219400></td>
 </tr>
 <tr class=xl6553519400 height=20 style='height:15.0pt'>
  <td height=20 class=xl7719400 style='height:15.0pt'>Size</td>
  <td class=xl7819400 style='border-left:none'>Ctn#</td>
  <td class=xl7819400 style='border-left:none'>Job</td>
  <td class=xl7819400 style='border-left:none'>Qty</td>
  <td class=xl7819400 style='border-left:none' colspan=2>Label ID</td>
  <td class=xl7819400>Ctn#</td>
  <td class=xl7819400 style='border-left:none'>Job</td>
  <td class=xl7819400 style='border-left:none'>Qty</td>
  <td class=xl7819400 style='border-left:none' colspan=2>Label ID</td>
  <td class=xl7819400>Ctn#</td>
  <td class=xl7819400 style='border-left:none'>Job</td>
  <td class=xl8119400 style='border-left:none'>Qty</td>
  <td class=xl7819400 style='border-left:none' colspan=2>Label ID</td>
  <td class=xl7819400>Ctn#</td>
  <td class=xl7819400 style='border-left:none'>Job</td>
  <td class=xl7819400 style='border-left:none'>Qty</td>
  <td class=xl7819400 style='border-left:none' colspan=2>Label ID</td>
  <td class=xl6553519400></td>
  <td class=xl6553519400></td>
  <td class=xl6553519400></td>
 </tr>
 <tr class=xl6553519400 height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl8219400 style='height:15.0pt'>&nbsp;</td>
  <td class=xl8319400 style='border-top:none'>&nbsp;</td>
  <td class=xl8319400 style='border-top:none'>&nbsp;</td>
  <td class=xl8319400 style='border-top:none'>&nbsp;</td>
  <td class=xl8319400 style='border-top:none'>&nbsp;</td>
  <td class=xl8219400>&nbsp;</td>
  <td class=xl8319400 style='border-top:none'>&nbsp;</td>
  <td class=xl8319400 style='border-top:none'>&nbsp;</td>
  <td class=xl8319400 style='border-top:none'>&nbsp;</td>
  <td class=xl8319400 style='border-top:none'>&nbsp;</td>
  <td class=xl8219400>&nbsp;</td>
  <td class=xl8319400 style='border-top:none'>&nbsp;</td>
  <td class=xl8319400 style='border-top:none'>&nbsp;</td>
  <td class=xl8319400 style='border-top:none'>&nbsp;</td>
  <td class=xl8219400>&nbsp;</td>
  <td class=xl8219400>&nbsp;</td>
  <td class=xl8219400>&nbsp;</td>
  <td class=xl8219400>&nbsp;</td>
  <td class=xl8219400>&nbsp;</td>
  <td class=xl8219400>&nbsp;</td>
  <td class=xl8219400>&nbsp;</td>
  <td class=xl6553519400></td>
  <td class=xl6553519400></td>
  <td class=xl6553519400></td>
 </tr>
 <tr class=xl6553519400 height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl7919400 style='height:15.0pt'></td>
  <td class=xl7919400></td>
  <td class=xl7919400></td>
  <td class=xl7919400></td>
  <td class=xl7919400></td>
  <td class=xl7919400></td>
  <td class=xl7919400></td>
  <td class=xl7919400></td>
  <td class=xl7919400></td>
  <td class=xl7919400></td>
  <td class=xl7919400></td>
  <td class=xl7919400></td>
  <td class=xl7919400></td>
  <td class=xl7919400></td>
  <td class=xl7919400></td>
  <td class=xl7919400></td>
  <td class=xl7919400></td>
  <td class=xl7919400></td>
  <td class=xl7919400></td>
  <td class=xl7919400></td>
  <td class=xl7919400></td>
  <td class=xl6553519400></td>
  <td class=xl6553519400></td>
  <td class=xl6553519400></td>
 </tr>
 </thead>

<?php

 /*<!-- Example -->
 
 <tr class=xl6553519400 height=20 style='height:15.0pt'>
  <td height=20 class=xl8019400 style='height:15.0pt'>XS</td>
  <td class=xl8419400>&nbsp;</td>
  <td class=xl8419400 style='border-left:none'>&nbsp;</td>
  <td class=xl8419400 style='border-left:none'>&nbsp;</td>
  <td class=xl8419400 style='border-left:none'>&nbsp;</td>
  <td class=xl7919400></td>
  <td class=xl8419400>&nbsp;</td>
  <td class=xl8419400 style='border-left:none'>&nbsp;</td>
  <td class=xl8419400 style='border-left:none'>&nbsp;</td>
  <td class=xl8419400 style='border-left:none'>&nbsp;</td>
  <td class=xl7919400></td>
  <td class=xl8419400>&nbsp;</td>
  <td class=xl8419400 style='border-left:none'>&nbsp;</td>
  <td class=xl8419400 style='border-left:none'>&nbsp;</td>
  <td class=xl8419400 style='border-left:none'>&nbsp;</td>
  <td class=xl7919400></td>
  <td class=xl8419400>&nbsp;</td>
  <td class=xl8419400 style='border-left:none'>&nbsp;</td>
  <td class=xl8419400 style='border-left:none'>&nbsp;</td>
  <td class=xl8419400 style='border-left:none'>&nbsp;</td>
  <td class=xl7919400></td>
  <td class=xl6553519400></td>
  <td class=xl6553519400></td>
  <td class=xl6553519400></td>
 </tr>
 
 
 <tr class=xl6553519400 height=8 style='mso-height-source:userset;height:6.0pt'>
  <td height=8 class=xl8019400 style='height:6.0pt'></td>
  <td class=xl8519400 style='border-top:none'>&nbsp;</td>
  <td class=xl8519400 style='border-top:none'>&nbsp;</td>
  <td class=xl8519400 style='border-top:none'>&nbsp;</td>
  <td class=xl8519400 style='border-top:none'>&nbsp;</td>
  <td class=xl7919400></td>
  <td class=xl8519400 style='border-top:none'>&nbsp;</td>
  <td class=xl8519400 style='border-top:none'>&nbsp;</td>
  <td class=xl8519400 style='border-top:none'>&nbsp;</td>
  <td class=xl8519400 style='border-top:none'>&nbsp;</td>
  <td class=xl7919400></td>
  <td class=xl8519400 style='border-top:none'>&nbsp;</td>
  <td class=xl8519400 style='border-top:none'>&nbsp;</td>
  <td class=xl8519400 style='border-top:none'>&nbsp;</td>
  <td class=xl8519400 style='border-top:none'>&nbsp;</td>
  <td class=xl7919400></td>
  <td class=xl8519400 style='border-top:none'>&nbsp;</td>
  <td class=xl8519400 style='border-top:none'>&nbsp;</td>
  <td class=xl8519400 style='border-top:none'>&nbsp;</td>
  <td class=xl8519400 style='border-top:none'>&nbsp;</td>
  <td class=xl7919400></td>
  <td class=xl6553519400></td>
  <td class=xl6553519400></td>
  <td class=xl6553519400></td>
 </tr>
 
  <!-- Example -->
 
 
  <!-- Example - Break -->
  
 <tr class=xl6553519400 height=21 style='height:15.75pt'>
  <td height=21 class=xl8619400 style='height:15.75pt'>&nbsp;</td>
  <td class=xl8219400>&nbsp;</td>
  <td class=xl8219400>&nbsp;</td>
  <td class=xl8219400>&nbsp;</td>
  <td class=xl8219400>&nbsp;</td>
  <td class=xl8219400>&nbsp;</td>
  <td class=xl8219400>&nbsp;</td>
  <td class=xl8219400>&nbsp;</td>
  <td class=xl8219400>&nbsp;</td>
  <td class=xl8219400>&nbsp;</td>
  <td class=xl8219400>&nbsp;</td>
  <td class=xl8219400>&nbsp;</td>
  <td class=xl8219400>&nbsp;</td>
  <td class=xl8219400>&nbsp;</td>
  <td class=xl8219400>&nbsp;</td>
  <td class=xl8219400>&nbsp;</td>
  <td class=xl8219400>&nbsp;</td>
  <td class=xl8219400>&nbsp;</td>
  <td class=xl8219400>&nbsp;</td>
  <td class=xl8219400>&nbsp;</td>
  <td class=xl8219400>&nbsp;</td>
  <td class=xl6553519400></td>
  <td class=xl6553519400></td>
  <td class=xl6553519400></td>
 </tr>
 
 
 <!-- Example - Break-->
 --> */
 ?>
 
 <?php
 
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
	
	for($i=0;$i<sizeof($order_qtys);$i++)
  	{	
		if($order_qtys[$i]>0)
		{
			
			$carton_nodes=array();
			$x=1;
			$sql="select * from $bai_pro3.pac_stat_log where doc_no in (".implode(",",$docs_db).") and size_code=\"".strtolower($size_titles[$i])."\" order by doc_no, carton_mode desc";
			//echo $sql;
			mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row=mysqli_fetch_array($sql_result))
			{
				$doc_no=$sql_row['doc_no'];
				$carton_act_qty=$sql_row['carton_act_qty'];
				$status=$sql_row['status'];
				$tid=$sql_row['tid'];
				$bgcolor="RED";
				if($status=="DONE")
				{
					$bgcolor="GREEN";
				}
				if($bgcolor=="RED")
				{
					$sql1="select * from $bai_pro3.pac_stat_log_partial where carton_id=$tid";
					mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
					$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
					$count_check=mysqli_num_rows($sql_result1);
					if($count_check>0)
					{
						$bgcolor="YELLOW";
					}
				}
				
				$carton_nodes[]=$x."-".chr($color_code).leading_zeros($cutno_db[array_search($doc_no,$docs_db)],3)."-".$carton_act_qty."-".$bgcolor."-".$tid;
				$x++;
			}
			
			$cycle=0;
			for($j=0;$j<sizeof($carton_nodes);$j+=4)
			{
				  echo "<tr class=xl6553519400 height=20 style='height:15.0pt'>";
				 if($cycle==0)
				 {
				 	echo " <td height=20 class=xl8019400 style='height:15.0pt'>".$size_titles[$i]."</td>";
				 }
				 else
				 {
				 	echo " <td height=20 class=xl8019400 style='height:15.0pt'></td>";
				 }
 				
				  for($m=$j;$m<$j+4;$m++)
				  {
					  $node_detail=array();
					  $node_detail=explode("-",$carton_nodes[$m]);
					  if($node_detail[2]>0)
					  {
					  	  /*echo "<td class=xl8419400 bgcolor=".$node_detail[3].">".$node_detail[0]."</td>
						  <td class=xl8419400 style='border-left:none'>".$node_detail[1]."</td>
						  <td class=xl8419400 style='border-left:none'>".$node_detail[2]."</td>
						  <td class=xl8419400 style='border-left:none'>&nbsp;</td>
						  <td class=xl7919400></td>"; */
						  
						  echo "<td class=xl8419400 bgcolor=".$node_detail[3].">".$node_detail[0]."</td>
						  <td class=xl8419400 style='border-left:none'>".$node_detail[1]."</td>
						  <td class=xl8419400 style='border-left:none'>".$node_detail[2]."</td>
						  <td class=xl8419400 style='border-left:none' colspan=2>".$node_detail[4]."</td>";
					  }
					  else
					  {
					  	  echo "<td class=xl8419400_new></td>
						  <td class=xl8419400_new style='border-left:none'></td>
						  <td class=xl8419400_new style='border-left:none'></td>
						  <td class=xl8419400_new style='border-left:none'>&nbsp;</td>
						  <td class=xl7919400_new></td>";
					  }
				  }
				  echo "<td class=xl6553519400></td>
  					<td class=xl6553519400></td>
  					<td class=xl6553519400></td>
 					</tr>";
					$cycle++;
			}
			echo "<tr class=xl6553519400 height=21 style='height:15.75pt'>
			  <td height=21 class=xl8619400 style='height:15.75pt'>&nbsp;</td>
			  <td class=xl8219400>&nbsp;</td>
			  <td class=xl8219400>&nbsp;</td>
			  <td class=xl8219400>&nbsp;</td>
			  <td class=xl8219400>&nbsp;</td>
			  <td class=xl8219400>&nbsp;</td>
			  <td class=xl8219400>&nbsp;</td>
			  <td class=xl8219400>&nbsp;</td>
			  <td class=xl8219400>&nbsp;</td>
			  <td class=xl8219400>&nbsp;</td>
			  <td class=xl8219400>&nbsp;</td>
			  <td class=xl8219400>&nbsp;</td>
			  <td class=xl8219400>&nbsp;</td>
			  <td class=xl8219400>&nbsp;</td>
			  <td class=xl8219400>&nbsp;</td>
			  <td class=xl8219400>&nbsp;</td>
			  <td class=xl8219400>&nbsp;</td>
			  <td class=xl8219400>&nbsp;</td>
			  <td class=xl8219400>&nbsp;</td>
			  <td class=xl8219400>&nbsp;</td>
			  <td class=xl8219400>&nbsp;</td>
			  <td class=xl6553519400></td>
			  <td class=xl6553519400></td>
			  <td class=xl6553519400></td>
			 </tr><tr class=xl6553519400 height=20 style='height:15.75pt'>
			  <td height=20 class=xl8019400 style='height:15.75pt'></td>
			  <td class=xl7919400></td>
			  <td class=xl7919400></td>
			  <td class=xl7919400></td>
			  <td class=xl7919400></td>
			  <td class=xl7919400></td>
			  <td class=xl7919400></td>
			  <td class=xl7919400></td>
			  <td class=xl7919400></td>
			  <td class=xl7919400></td>
			  <td class=xl7919400></td>
			  <td class=xl7919400></td>
			  <td class=xl7919400></td>
			  <td class=xl7919400></td>
			  <td class=xl7919400></td>
			  <td class=xl7919400></td>
			  <td class=xl7919400></td>
			  <td class=xl7919400></td>
			  <td class=xl7919400></td>
			  <td class=xl7919400></td>
			  <td class=xl7919400></td>
			  <td class=xl6553519400></td>
			  <td class=xl6553519400></td>
			  <td class=xl6553519400></td>
			 </tr>";
			
 			/* echo "<tr class=xl6553519400 height=21 style='height:1.75pt'>
			  <td height=21 class=xl8619400 style='height:1.75pt'>&nbsp;</td>
			  <td class=xl8219400>&nbsp;</td>
			  <td class=xl8219400>&nbsp;</td>
			  <td class=xl8219400>&nbsp;</td>
			  <td class=xl8219400>&nbsp;</td>
			  <td class=xl8219400>&nbsp;</td>
			  <td class=xl8219400>&nbsp;</td>
			  <td class=xl8219400>&nbsp;</td>
			  <td class=xl8219400>&nbsp;</td>
			  <td class=xl8219400>&nbsp;</td>
			  <td class=xl8219400>&nbsp;</td>
			  <td class=xl8219400>&nbsp;</td>
			  <td class=xl8219400>&nbsp;</td>
			  <td class=xl8219400>&nbsp;</td>
			  <td class=xl8219400>&nbsp;</td>
			  <td class=xl8219400>&nbsp;</td>
			  <td class=xl8219400>&nbsp;</td>
			  <td class=xl8219400>&nbsp;</td>
			  <td class=xl8219400>&nbsp;</td>
			  <td class=xl8219400>&nbsp;</td>
			  <td class=xl8219400>&nbsp;</td>
			  <td class=xl6553519400></td>
			  <td class=xl6553519400></td>
			  <td class=xl6553519400></td>
			 </tr>";
			echo " <tr class=xl6553519400 height=20 style='height:6.0pt'>
			  <td height=20 class=xl8019400 style='height:6.0pt'></td>
			  <td class=xl7919400></td>
			  <td class=xl7919400></td>
			  <td class=xl7919400></td>
			  <td class=xl7919400></td>
			  <td class=xl7919400></td>
			  <td class=xl7919400></td>
			  <td class=xl7919400></td>
			  <td class=xl7919400></td>
			  <td class=xl7919400></td>
			  <td class=xl7919400></td>
			  <td class=xl7919400></td>
			  <td class=xl7919400></td>
			  <td class=xl7919400></td>
			  <td class=xl7919400></td>
			  <td class=xl7919400></td>
			  <td class=xl7919400></td>
			  <td class=xl7919400></td>
			  <td class=xl7919400></td>
			  <td class=xl7919400></td>
			  <td class=xl7919400></td>
			  <td class=xl6553519400></td>
			  <td class=xl6553519400></td>
			  <td class=xl6553519400></td>
			 </tr>"; */
		}
	}
	 
 ?>
 
 <?php
 /*
 <tr class=xl6553519400 height=20 style='height:15.0pt'>
  <td height=20 class=xl8019400 style='height:15.0pt'></td>
  <td class=xl7919400></td>
  <td class=xl7919400></td>
  <td class=xl7919400></td>
  <td class=xl7919400></td>
  <td class=xl7919400></td>
  <td class=xl7919400></td>
  <td class=xl7919400></td>
  <td class=xl7919400></td>
  <td class=xl7919400></td>
  <td class=xl7919400></td>
  <td class=xl7919400></td>
  <td class=xl7919400></td>
  <td class=xl7919400></td>
  <td class=xl7919400></td>
  <td class=xl7919400></td>
  <td class=xl7919400></td>
  <td class=xl7919400></td>
  <td class=xl7919400></td>
  <td class=xl7919400></td>
  <td class=xl7919400></td>
  <td class=xl6553519400></td>
  <td class=xl6553519400></td>
  <td class=xl6553519400></td>
 </tr> */
 
 ?>
 <!-- <tr class=xl6553519400 height=20 style='height:15.0pt'>
  <td height=20 class=xl7919400 style='height:15.0pt'></td>
  <td class=xl7919400></td>
  <td class=xl7919400></td>
  <td class=xl7919400></td>
  <td class=xl7919400></td>
  <td class=xl7919400></td>
  <td class=xl7919400></td>
  <td class=xl7919400></td>
  <td class=xl7919400></td>
  <td class=xl7919400></td>
  <td class=xl7919400></td>
  <td class=xl7919400></td>
  <td class=xl7919400></td>
  <td class=xl7919400></td>
  <td class=xl7919400></td>
  <td class=xl7919400></td>
  <td class=xl7919400></td>
  <td class=xl7919400></td>
  <td class=xl7919400></td>
  <td class=xl7919400></td>
  <td class=xl7919400></td>
  <td class=xl6553519400></td>
  <td class=xl6553519400></td>
  <td class=xl6553519400></td>
 </tr>
 <tr class=xl6553519400 height=20 style='height:15.0pt'>
  <td colspan=2 height=20 class=xl8719400 style='height:15.0pt'>Prepared By :</td>
  <td colspan=4 class=xl8819400>&nbsp;</td>
  <td class=xl7219400></td>
  <td colspan=3 class=xl8719400>Order Completed By :</td>
  <td colspan=4 class=xl8819400>&nbsp;</td>
  <td class=xl7919400></td>
  <td colspan=2 class=xl8719400>Approved By :</td>
  <td colspan=4 class=xl8919400>&nbsp;</td>
  <td class=xl6553519400></td>
  <td class=xl6553519400></td>
  <td class=xl6553519400></td>
 </tr> -->
 <tr class=xl6553519400 height=20 style='height:15.0pt'>
  <td height=20 class=xl7919400 style='height:15.0pt'></td>
  <td class=xl7919400></td>
  <td class=xl7919400></td>
  <td class=xl7919400></td>
  <td class=xl7919400></td>
  <td class=xl7919400></td>
  <td class=xl7919400></td>
  <td class=xl7919400></td>
  <td class=xl7919400></td>
  <td class=xl7919400></td>
  <td class=xl7919400></td>
  <td class=xl7919400></td>
  <td class=xl7919400></td>
  <td class=xl7919400></td>
  <td class=xl7919400></td>
  <td class=xl7919400></td>
  <td class=xl7919400></td>
  <td class=xl7919400></td>
  <td class=xl7919400></td>
  <td class=xl7919400></td>
  <td class=xl7919400></td>
  <td class=xl6553519400></td>
  <td class=xl6553519400></td>
  <td class=xl6553519400></td>
 </tr>
 
  <tr class=xl6553519400 style='height:auto'>
  <td class=xl7919400 style='height: auto; width:400px;' colspan=21>

<?php
//FOR Carton (Mixed and Full Allocaiton)
$temp_doc_ref=array();
$max_size_qty=0;
$max_size_code="";
$count=0;
$max_carton_qty=0; //20110602
$sql="select * from (select packing_summary.*, sum(carton_act_qty) as \"carton_qty\" from $bai_pro3.packing_summary where order_style_no=\"$style\" and order_del_no=\"$schedule\" and container is null group by doc_no_ref) as t order by carton_qty ASC";
//echo $sql;
mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row=mysqli_fetch_array($sql_result))
{
	$carton_qty=$sql_row['carton_qty'];
	if(in_array($carton_qty,$carton_qtys))
	{
		$temp_doc_ref[]=$sql_row['doc_no_ref'];
	}
	else
	{
		/* if($carton_qty>$max_size_qty)
		{
			$max_size_qty=$carton_qty;
			$max_size_code=strtoupper($sql_row['size_code']);
		} */
		
		if($carton_qtys[array_search(strtoupper($sql_row['size_code']),$size_titles)]>$max_carton_qty)
		{
			$max_size_code=strtoupper($sql_row['size_code']);
			$max_carton_qty=$carton_qtys[array_search($max_size_code,$size_titles)];
			
		}

		$count++;
	}
}

if(sizeof($temp_doc_ref)>0)
{
	$sql="update $bai_pro3.pac_stat_log set container=1 where doc_no_ref in (\"".implode('","',$temp_doc_ref)."\")";
	//echo $sql;
	mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
}

if(substr($style,0,1)=="O" or substr($style,0,1)=="K")
{
	$x=2;
	$sql="select packing_summary.*, sum(carton_act_qty) as \"carton_qty\" from $bai_pro3.packing_summary where order_style_no=\"$style\" and order_del_no=\"$schedule\" and container is null group by doc_no_ref";
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		$sql1="update $bai_pro3.pac_stat_log set container=$x where doc_no_ref=\"".$sql_row['doc_no_ref']."\"";
		mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		$x++;
	}
}
else
{
	//$max_carton_qty=$carton_qtys[array_search($max_size_code,$size_titles)];
	//echo $count."<br/>";;
	//echo $max_carton_qty;
	
	$container=2;
	if($count>0)
	{
		//echo $max_size_code."<br/>"	;
		do
		{
			$temp=$max_carton_qty;
			$temp_doc_ref=array();
			$completed=array();
			$completed[]="0";
			
			//to take max carton qty size as part of mixed carton
			$true=0;
			//to take max carton qty size as part of mixed carton
			
			do
			{
				if($true==0)
				{
					$sql="select * from (select packing_summary.*, sum(carton_act_qty) as \"carton_qty\" from $bai_pro3.packing_summary where order_style_no=\"$style\" and order_del_no=\"$schedule\" and container is null and doc_no_ref not in (\"".implode('","',$completed)."\") group by doc_no_ref) as t where carton_qty<=$temp and size_code=\"$max_size_code\" order by carton_qty ASC limit 1";
					//echo "1.  ".$sql."<br/>";
					$true=1;
				}
				else
				{
					$sql="select * from (select packing_summary.*, sum(carton_act_qty) as \"carton_qty\" from $bai_pro3.packing_summary where order_style_no=\"$style\" and order_del_no=\"$schedule\" and container is null and doc_no_ref not in (\"".implode('","',$completed)."\") group by doc_no_ref) as t where carton_qty<=$temp order by carton_qty ASC limit 1";
					//echo "2.  ".$sql."<br/>";
				}
				
	//echo $sql;
				mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				$check=mysqli_num_rows($sql_result);
				
				while($sql_row=mysqli_fetch_array($sql_result))
				{
					$x=$sql_row['carton_qty'];
					$y=$sql_row['doc_no_ref'];
				}
				
				if($check>0)
				{
					$temp-=$x;
					$count--;
					$temp_doc_ref[]=$y;
					$completed[]=$y;
				}
				else
				{
					$temp=0;
				}
				
			}while($temp>0 and $count>0);
			
			if(sizeof($temp_doc_ref)>0)
			{
				$sql="update $bai_pro3.pac_stat_log set container=$container where doc_no_ref in (\"".implode('","',$temp_doc_ref)."\")";
				//echo $sql."<br/>";
				mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				$container++;
			}
			
			//NEW 20110325 - Error correction on new carton after partical findings
			$max_qty_check=0;
			$max_carton_qty=0; //20110601
			$max_size_code="";
			$sql="select packing_summary.size_code as \"size_code\", sum(carton_act_qty) as \"carton_qty\" from 
				$bai_pro3.packing_summary where order_style_no=\"$style\" and order_del_no=\"$schedule\" and container is null group by doc_no_ref";
			//echo $sql."<br/>";
			mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row=mysqli_fetch_array($sql_result))
			{
				/*if($sql_row['carton_qty']>$max_qty_check)
				{
					$max_size_code=$sql_row['size_code'];
					$max_qty_check=$sql_row['carton_qty'];
				}*/
				
				
				
				if($carton_qtys[array_search(strtoupper($sql_row['size_code']),$size_titles)]>$max_carton_qty)
				{
					$max_size_code=strtoupper($sql_row['size_code']);
					$max_carton_qty=$carton_qtys[array_search($max_size_code,$size_titles)];
				}
			}
			//echo $max_size_code."<br/>";
			//$max_carton_qty=$carton_qtys[array_search(strtoupper($max_size_code),$size_titles)];
			//NEW 20110325 - Error correction on new carton after partical findings
			
		}while($count>0);
	}
}


/*$sql="select packing_summary.*, sum(carton_act_qty) as \"carton_qty\", group_concat(tid) as \"label_id\", count(*) as \"count\" from packing_summary where order_style_no=\"$style\" and order_del_no=\"$schedule\" group by container";
mysql_query($sql,$link) or exit("Sql Error".mysql_error());
$sql_result=mysql_query($sql,$link) or exit("Sql Error".mysql_error());
while($sql_row=mysql_fetch_array($sql_result))
{
	//echo $sql_row['container']."-".$sql_row['count']."-".$sql_row['label_id']."<br/>";
}*/
?>


<table class="new">
	  <tr class=new><th class=new>Cartons</th><th class=new>Label IDs (ALPHA VERSION V1)</th></tr>
	  <?php
	    $sql="select container,group_concat(tid) as \"label_id\", count(*) as \"count\" from $bai_pro3.packing_summary where order_style_no=\"$style\" and order_del_no=\"$schedule\" group by container";
		mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		$total=0;
		while($sql_row=mysqli_fetch_array($sql_result))
		{
			//echo "<tr><td>".$sql_row['container']."</td><td>".$sql_row['count']."</td><td>".$sql_row['label_id']."</td></tr>";
			$count=$sql_row['count'];
			if($sql_row['container']!=1)
			{
				$count=1;
			}
			$description = str_replace(",",", ",$sql_row['label_id']);
			echo '<tr class=new><td class=new>'.$count."</td><td class=new>".wordwrap($description, 145, "<br>\n")."</td></tr>";
			$total+=$count;
		}
		echo "<tr class=new><th colspan=2 class=new align=left>Total Cartons: $total</th></tr>";
	  ?>
</table>

  
  </td>

  <td class=xl6553519400></td>
  <td class=xl6553519400></td>
  <td class=xl6553519400></td>
 </tr>

</table>

</div>

<!----------------------------->
<!--END OF OUTPUT FROM EXCEL PUBLISH AS WEB PAGE WIZARD-->
<!----------------------------->
</body>

</html>



