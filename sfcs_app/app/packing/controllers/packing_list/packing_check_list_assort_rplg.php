<?php include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));	?>
<?php include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/php/functions.php',2,'R'));	?>


<?php
$order_tid=$_GET['order_tid'];
$cat_ref=$_GET['cat_ref'];
$carton_id=$_GET['carton_id'];
$style=$_GET['style'];
$schedule=$_GET['schedule'];
?>

<?php
$sql="select * from $bai_pro3.bai_orders_db_confirm where order_style_no=\"$style\" and order_del_no=$schedule";
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_num_confirm=mysqli_num_rows($sql_result);

if($sql_num_confirm>0)
{
	$sql="select * from $bai_pro3.bai_orders_db_confirm where order_style_no=\"$style\" and order_del_no=$schedule";
}
else
{
	$sql="select * from $bai_pro3.bai_orders_db where order_style_no=\"$style\" and order_del_no=$schedule";
}
//echo "query =".$sql."<br>";
mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_num_=mysqli_num_rows($sql_result);
while($sql_row=mysqli_fetch_array($sql_result))
{
	$style=$sql_row['order_style_no']; //Style
	$color.=$sql_row['order_col_des']."/"; //color
	$division=$sql_row['order_div'];
	$delivery=$sql_row['order_del_no']; //Schedule
	$pono=$sql_row['order_po_no']; //po
	$color_code.=chr($sql_row['color_code']); //Color Code
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
				$size01="01";
				$size02="02";
				$size03="03";
				$size04="04";
				$size05="05";
				$size06="06";
				$size07="07";
				$size08="08";
				$size09="09";
				$size10="10";
				$size11="11";
				$size12="12";
				$size13="13";
				$size14="14";
				$size15="15";
				$size16="16";
				$size17="17";
				$size18="18";
				$size19="19";
				$size20="20";
				$size21="21";
				$size22="22";
				$size23="23";
				$size24="24";
				$size25="25";
				$size26="26";
				$size27="27";
				$size28="28";
				$size29="29";
				$size30="30";
				$size31="31";
				$size32="32";
				$size33="33";
				$size34="34";
				$size35="35";
				$size36="36";
				$size37="37";
				$size38="38";
				$size39="39";
				$size40="40";
				$size41="41";
				$size42="42";
				$size43="43";
				$size44="44";
				$size45="45";
				$size46="46";
				$size47="47";
				$size48="48";
				$size49="49";
				$size50="50";

			}

	$order_total=$o_xs+$o_s+$o_m+$o_l+$o_xl+$o_xxl+$o_xxxl+$o_s_s01+$o_s_s02+$o_s_s03+$o_s_s04+$o_s_s05+$o_s_s06+$o_s_s07+$o_s_s08+$o_s_s09+$o_s_s10+$o_s_s11+$o_s_s12+$o_s_s13+$o_s_s14+$o_s_s15+$o_s_s16+$o_s_s17+$o_s_s18+$o_s_s19+$o_s_s20+$o_s_s21+$o_s_s22+$o_s_s23+$o_s_s24+$o_s_s25+$o_s_s26+$o_s_s27+$o_s_s28+$o_s_s29+$o_s_s30+$o_s_s31+$o_s_s32+$o_s_s33+$o_s_s34+$o_s_s35+$o_s_s36+$o_s_s37+$o_s_s38+$o_s_s39+$o_s_s40+$o_s_s41+$o_s_s42+$o_s_s43+$o_s_s44+$o_s_s45+$o_s_s46+$o_s_s47+$o_s_s48+$o_s_s49+$o_s_s50;
	$order_date=$sql_row['order_date'];
	$order_joins=$sql_row['order_joins'];
	$packing_method=$sql_row['packing_method'];
	$carton_id=$sql_row['carton_id'];
}

$sql="select * from $bai_pro3.carton_qty_chart where id=$carton_id";
//echo $sql;
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
$size_titles_qry=array("XS","S","M","L","XL","XXL","XXXL","s01","s02","s03","s04","s05","s06","s07","s08","s09","s10","s11","s12","s13","s14","s15","s16","s17","s18"
,"s19","s20","s21","s22","s23","s24","s25","s26","s27","s28","s29","s30","s31","s32","s33","s34","s35","s36","s37","s38","s39","s40","s41","s42","s43","s44","s45","s46"
,"s47","s48","s49","s50");
$order_qtys=array($o_xs,$o_s,$o_m,$o_l,$o_xl,$o_xxl,$o_xxxl,$o_s_s01,$o_s_s02,$o_s_s03,$o_s_s04,$o_s_s05,$o_s_s06,$o_s_s07,$o_s_s08,$o_s_s09,$o_s_s10,$o_s_s11,$o_s_s12,$o_s_s13,$o_s_s14,$o_s_s15,$o_s_s16,$o_s_s17,$o_s_s18,$o_s_s19,$o_s_s20,$o_s_s21,$o_s_s22,$o_s_s23,$o_s_s24,$o_s_s25,$o_s_s26,$o_s_s27,$o_s_s28,$o_s_s29
,$o_s_s30,$o_s_s31,$o_s_s32,$o_s_s33,$o_s_s34,$o_s_s35,$o_s_s36,$o_s_s37,$o_s_s38,$o_s_s39,$o_s_s40,$o_s_s41,$o_s_s42,$o_s_s43,$o_s_s44,$o_s_s45,$o_s_s46,$o_s_s47
,$o_s_s48,$o_s_s49,$o_s_s50);
$carton_qtys=array($carton_xs,$carton_s,$carton_m,$carton_l,$carton_xl,$carton_xxl,$carton_xxxl,$carton_s01,$carton_s02,$carton_s03,$carton_s04,$carton_s05,$carton_s06,$carton_s07,$carton_s08,$carton_s09,$carton_s10,$carton_s11,$carton_s12,$carton_s13,$carton_s14,$carton_s15,$carton_s16,$carton_s17,$carton_s18,$carton_s19,$carton_s20,$carton_s21,$carton_s22,$carton_s23,$carton_s24,$carton_s25,$carton_s26,$carton_s27,$carton_s28,$carton_s29,$carton_s30,$carton_s31,$carton_s32,$carton_s33,$carton_s34,$carton_s35,$carton_s36,$carton_s37,$carton_s38,$carton_s39,$carton_s40,$carton_s41,$carton_s42,$carton_s43,$carton_s44,$carton_s45,$carton_s46,$carton_s47,$carton_s48,$carton_s49,$carton_s50);

//ERROR CHECK POINT

$sql="select sum(carton_act_qty) as \"carton_act_qty\" from $bai_pro3.packing_summary where order_del_no=$delivery";
mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row=mysqli_fetch_array($sql_result))
{
	if(array_sum($order_qtys)!=$sql_row['carton_act_qty'])
	{
		echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); 
				function Redirect() {  
					location.href = \"error.php\"; 
				}</script>";
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

$sql="select ims_mod_no from $bai_pro3.ims_log where ims_cid=$cat_ref and ims_date=(select min(ims_date) 
	from $bai_pro3.ims_log where ims_cid=$cat_ref)";
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
<div id="page_heading"><span style="float: left"><h3>FG Check List</h3></span><span style="float: right"><b>?</b>&nbsp;</span></div>
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
  width:759pt'></td>
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
	$sql="select * from $bai_pro3.packing_summary where order_style_no=\"$style\" and order_del_no=$schedule";
	//echo $sql;
	mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		$docs_db[]=$sql_row['doc_no'];
		$cutno_db[]=$sql_row['acutno'];
		$remarks=$sql_row['remarks'];
	}
	
	for($i=0;$i<sizeof($order_qtys);$i++)
  	{	
		if($order_qtys[$i]>0)
		{
			
			$carton_nodes=array();
			$x=1;
			$sql="select status,min(tid) as \"tid\",doc_no,sum(carton_act_qty) as \"carton_act_qty\" from 
				$bai_pro3.pac_stat_log where doc_no in (".implode(",",$docs_db).") and size_code=\"".strtolower($size_titles_qry[$i])."\" group by doc_no_ref order by doc_no,carton_mode,carton_act_qty desc";
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
				$carton_nodes[]=$x."-".$color_code.leading_zeros($cutno_db[array_search($doc_no,$docs_db)],3)."-".$carton_act_qty."-".$bgcolor."-".$tid;
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
	/*
//FOR Carton (Mixed and Full Allocaiton)
$temp_doc_ref=array();
$max_size_qty=0;
$max_size_code="";
$count=0;
$sql="select packing_summary.*, sum(carton_act_qty) as \"carton_qty\" from packing_summary where order_style_no=\"$style\" and order_del_no=\"$schedule\" and container is null group by doc_no_ref";
//echo $sql;
mysql_query($sql,$link) or exit("Sql Error".mysql_error());
$sql_result=mysql_query($sql,$link) or exit("Sql Error".mysql_error());
while($sql_row=mysql_fetch_array($sql_result))
{
	$carton_qty=$sql_row['carton_qty'];
	
	if($carton_qty==$carton_qtys[array_search(strtoupper($sql_row['size_code']),$size_titles_qry)])
	{
		$temp_doc_ref[]=$sql_row['doc_no_ref'];
	}
	else
	{
		if($carton_qty>$max_size_qty)
		{
			$max_size_qty=$carton_qty;
			$max_size_code=strtoupper($sql_row['size_code']);
		}
		$count++;
	}
}

if(sizeof($temp_doc_ref)>0)
{
	$sql="update pac_stat_log set container=1 where doc_no_ref in (\"".implode('","',$temp_doc_ref)."\")";
	//echo $sql;
	mysql_query($sql,$link) or exit("Sql Error".mysql_error());
}

/*
$max_carton_qty=$carton_qtys[array_search($max_size_code,$size_titles)];
//echo $count."<br/>";;
//echo $max_carton_qty;

$container=2;
if($count>0)
{
	do
	{
		$temp=$max_carton_qty;
		$temp_doc_ref=array();
		$completed=array();
		$completed[]="0";
		do
		{
			$sql="select * from (select packing_summary.*, sum(carton_act_qty) as \"carton_qty\" from packing_summary where order_style_no=\"$style\" and order_del_no=\"$schedule\" and container is null and doc_no_ref not in (\"".implode('","',$completed)."\") group by doc_no_ref) as t where carton_qty<=$temp order by carton_qty DESC";
//echo $sql;
			mysql_query($sql,$link) or exit("Sql Error".mysql_error());
			$sql_result=mysql_query($sql,$link) or exit("Sql Error".mysql_error());
			$check=mysql_num_rows($sql_result);
			
			while($sql_row=mysql_fetch_array($sql_result))
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
			$sql="update pac_stat_log set container=$container where doc_no_ref in (\"".implode('","',$temp_doc_ref)."\")";
			//echo $sql;
			mysql_query($sql,$link) or exit("Sql Error".mysql_error());
			$container++;
		}
		
	}while($count>0);
}



//No partial Cartons for DIM/M&S and VSD 
$x=2;
$sql="select packing_summary.*, sum(carton_act_qty) as \"carton_qty\" from packing_summary where order_style_no=\"$style\" and order_del_no=\"$schedule\" and container is null group by doc_no_ref";
$sql_result=mysql_query($sql,$link) or exit("Sql Error".mysql_error());
while($sql_row=mysql_fetch_array($sql_result))
{
	$sql1="update pac_stat_log set container=$x where doc_no_ref=\"".$sql_row['doc_no_ref']."\"";
	mysql_query($sql1,$link) or exit("Sql Error".mysql_error());
	$x++;
}

//No partial Cartons for DIM/M&S and VSD 

/*$sql="select packing_summary.*, sum(carton_act_qty) as \"carton_qty\", group_concat(tid) as \"label_id\", count(*) as \"count\" from packing_summary where order_style_no=\"$style\" and order_del_no=\"$schedule\" group by container";
mysql_query($sql,$link) or exit("Sql Error".mysql_error());
$sql_result=mysql_query($sql,$link) or exit("Sql Error".mysql_error());
while($sql_row=mysql_fetch_array($sql_result))
{
	//echo $sql_row['container']."-".$sql_row['count']."-".$sql_row['label_id']."<br/>";
}


$temp_1=array();
$temp_1=explode("*",$remarks);
$temp_2=array();
$temp_2=explode("$",$temp_1[0]);
$assort=array_sum($temp_2);

?>


<table class="new">
	  <tr class=new><th class=new>Cartons</th><th class=new>Label IDs (ALPHA VERSION V1)</th></tr>
	  <?php
	  	$total=0;
		$sql1="select container,group_concat(tid) as \"label_id\", count(*) as \"count\" from packing_summary where order_style_no=\"$style\" and order_del_no=\"$schedule\" group by container";
		mysql_query($sql1,$link) or exit("Sql Error".mysql_error());
		$sql_result1=mysql_query($sql1,$link) or exit("Sql Error".mysql_error());
		while($sql_row1=mysql_fetch_array($sql_result1))
		{
	    	$container=$sql_row1['container'];
		$sql="select container,group_concat(label_id) as \"label_id\", count(*) as \"count\" from (select container,min(tid) as \"label_id\", count(*) as \"count\" from packing_summary where order_style_no=\"$style\" and order_del_no=\"$schedule\" and container=$container group by doc_no_ref) as t group by container";
		mysql_query($sql,$link) or exit("Sql Error".mysql_error());
		$sql_result=mysql_query($sql,$link) or exit("Sql Error".mysql_error());
		while($sql_row=mysql_fetch_array($sql_result))
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
		}
		echo "<tr class=new><th colspan=2 class=new align=left>Total Cartons: $total</th></tr>";
*/	  ?>
</table>

  
  </td>

  <td class=xl6553519400></td>
  <td class=xl6553519400></td>
  <td class=xl6553519400></td>
 </tr>

 
</table>
<?php

echo "<h3>Carton Ratio Quantities </h3>";
//$packpcs=array();
//$assort_color=array();
$sql1="SELECT * FROM $bai_pro3.ratio_input_update where schedule=\"$schedule\" ";
		//echo $sql1;
		$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error:$sql1 ".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql_num_check1=mysqli_num_rows($sql_result1);
				
		if($sql_num_check1>0)
		{
			echo "<table  border=1>";
			echo "<tr class='tblheading' style='color:white;'><th>Color</th><th>Size</th><th>Ratio Quantity</th></tr>";
			while($sql_row1=mysqli_fetch_array($sql_result1))
			{
				
				$ratio_color=$sql_row1['color'];
				$ratio_size=$sql_row1['size'];
				$ratio_qty=$sql_row1['ratio_qty'];
				
				$sql="SELECT * FROM $bai_pro3.bai_orders_db_confirm where order_del_no=$schedule";
				//echo $sql;
				$sql_result=mysqli_query($link, $sql) or exit("Sql Error:$sql ".mysqli_error($GLOBALS["___mysqli_ston"]));
				$sql_num_check=mysqli_num_rows($sql_result);
				while($sql_row=mysqli_fetch_array($sql_result))
				{
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
				}
				
					if($ratio_size=='s01'){$ratio_size=$size01;}
					if($ratio_size=='s02'){$ratio_size=$size02;}
					if($ratio_size=='s03'){$ratio_size=$size03;}
					if($ratio_size=='s04'){$ratio_size=$size04;}
					if($ratio_size=='s05'){$ratio_size=$size05;}
					if($ratio_size=='s06'){$ratio_size=$size06;}
					if($ratio_size=='s07'){$ratio_size=$size07;}
					if($ratio_size=='s08'){$ratio_size=$size08;}
					if($ratio_size=='s09'){$ratio_size=$size09;}
					if($ratio_size=='s10'){$ratio_size=$size10;}
					if($ratio_size=='s11'){$ratio_size=$size11;}
					if($ratio_size=='s12'){$ratio_size=$size12;}
					if($ratio_size=='s13'){$ratio_size=$size13;}
					if($ratio_size=='s14'){$ratio_size=$size14;}
					if($ratio_size=='s15'){$ratio_size=$size15;}
					if($ratio_size=='s16'){$ratio_size=$size16;}
					if($ratio_size=='s17'){$ratio_size=$size17;}
					if($ratio_size=='s18'){$ratio_size=$size18;}
					if($ratio_size=='s19'){$ratio_size=$size19;}
					if($ratio_size=='s20'){$ratio_size=$size20;}
					if($ratio_size=='s21'){$ratio_size=$size21;}
					if($ratio_size=='s22'){$ratio_size=$size22;}
					if($ratio_size=='s23'){$ratio_size=$size23;}
					if($ratio_size=='s24'){$ratio_size=$size24;}
					if($ratio_size=='s25'){$ratio_size=$size25;}
					if($ratio_size=='s26'){$ratio_size=$size26;}
					if($ratio_size=='s27'){$ratio_size=$size27;}
					if($ratio_size=='s28'){$ratio_size=$size28;}
					if($ratio_size=='s29'){$ratio_size=$size29;}
					if($ratio_size=='s30'){$ratio_size=$size30;}
					if($ratio_size=='s31'){$ratio_size=$size31;}
					if($ratio_size=='s32'){$ratio_size=$size32;}
					if($ratio_size=='s33'){$ratio_size=$size33;}
					if($ratio_size=='s34'){$ratio_size=$size34;}
					if($ratio_size=='s35'){$ratio_size=$size35;}
					if($ratio_size=='s36'){$ratio_size=$size36;}
					if($ratio_size=='s37'){$ratio_size=$size37;}
					if($ratio_size=='s38'){$ratio_size=$size38;}
					if($ratio_size=='s39'){$ratio_size=$size39;}
					if($ratio_size=='s40'){$ratio_size=$size40;}
					if($ratio_size=='s41'){$ratio_size=$size41;}
					if($ratio_size=='s42'){$ratio_size=$size42;}
					if($ratio_size=='s43'){$ratio_size=$size43;}
					if($ratio_size=='s44'){$ratio_size=$size44;}
					if($ratio_size=='s45'){$ratio_size=$size45;}
					if($ratio_size=='s46'){$ratio_size=$size46;}
					if($ratio_size=='s47'){$ratio_size=$size47;}
					if($ratio_size=='s48'){$ratio_size=$size48;}
					if($ratio_size=='s49'){$ratio_size=$size49;}
					if($ratio_size=='s50'){$ratio_size=$size50;}

				//$packpcs[]=$ratio_qty;
				//$assort_color[]=$ratio_color;
				
				echo "<input type=\"hidden\" name=\"packpcs[]\" value=\"$ratio_qty\">";
				echo "<tr><td>$ratio_color</td><td>$ratio_size</td><td>$ratio_qty</td></tr>";
			}
			
			echo "</table>";
		}
		
?>		
</div>




<!----------------------------->
<!--END OF OUTPUT FROM EXCEL PUBLISH AS WEB PAGE WIZARD-->
<!----------------------------->
</body>

</html>



