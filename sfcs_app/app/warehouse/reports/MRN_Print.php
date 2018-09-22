<!--

kirang / 2015-12-18 / Service Request#13345467 // Need MRN Duplicate Print Option 

-->
<?php
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
$mrn_id=$_GET["tid"];
//Print Status
if($_GET["print_status"]==1)
{
	$print_status="Duplicate";
}
else
{
	$print_status="Orginal";
}

$sql="select * from $bai_rm_pj2.mrn_track where tid=$mrn_id";
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row=mysqli_fetch_array($sql_result))
{
$tid=$sql_row["tid"];
$style=$sql_row["style"];
$schedule=$sql_row["schedule"];
$color=$sql_row["color"];	
$color_explode=explode("^",$color);
$section=$sql_row["section"];	
$item_code=$sql_row["item_code"];
$item_desc=$sql_row["item_desc"];
$product=$sql_row["product"];
$reason=$sql_row["reason_code"];
$sql1="select reason_desc as res from $bai_rm_pj2.mrn_reason_db where reason_tid=$reason";
$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row1=mysqli_fetch_array($sql_result1))
{
		$reason=$sql_row1["res"];
}
$requestref=$sql_row["rand_track_id"];
$requestedby=$sql_row["req_user"];
$approvedby=$sql_row["app_by"];
$issuedby=$sql_row["issued_by"];
$requestedqty=$sql_row["req_qty"];
$approvedqty=$sql_row["avail_qty"];
$issuedqty=$sql_row["issued_qty"];
$remarks=$sql_row["remarks"];
}
$sql112="select co_no from $bai_pro3.bai_orders_db_confirm where order_del_no=\"$schedule\" and order_col_des=\"$color\"";
$sql_result112=mysqli_query($link, $sql112) or exit("Sql Error1".$sql112."".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row112=mysqli_fetch_array($sql_result112))
{
	$co_no=$sql_row112['co_no'];
}
$sql="select group_concat(lable_id) as lbl from $bai_rm_pj2.mrn_out_allocation where mrn_tid=$mrn_id";
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row=mysqli_fetch_array($sql_result))
{
	$lable_ids=$sql_row["lable_id"];
	
}
?>


<meta http-equiv=Content-Type content="text/html; charset=windows-1252">
<meta name=ProgId content=Excel.Sheet>
<meta name=Generator content="Microsoft Excel 15">
<link rel=File-List href="Book1_files/filelist.xml">
<script src="jquery-1.3.2.js"></script>
<script src="jquery-barcode-2.0.1.js"></script>
<style id="Book1_14212_Styles"><!--table
	{mso-displayed-decimal-separator:"\.";
	mso-displayed-thousand-separator:"\,";}
.xl1514212
	{padding-top:0px;
	padding-right:0px;
	padding-left:0px;
	mso-ignore:padding;
	color:#ffffff;
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
.xl6314212
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
	text-align:general;
	vertical-align:bottom;
	
	border-right:none;
	border-bottom:none;
	/*border-left:.5pt solid windowtext;*/
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl6414212
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
	text-align:general;
	vertical-align:bottom;
	border-right:none;
	border-bottom:none;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl6514212
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
	text-align:general;
	vertical-align:bottom;
	border-bottom:none;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl6614212
	{padding-top:0px;
	padding-right:0px;
	padding-left:0px;
	mso-ignore:padding;
	color:#ffffff;
	font-size:11.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:general;
	vertical-align:bottom;
	border-top:none;
	border-right:none;
	border-bottom:none;
	border-left: none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl6714212
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
	text-align:general;
	vertical-align:bottom;
	border-top:none;
	border-bottom:none;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl6814212
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
	text-align:general;
	vertical-align:bottom;
	border-top:none;
	border-right:none;
	
	
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl6914212
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
	text-align:general;
	vertical-align:bottom;
	border-top:none;
	border-right:none;
	
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl7014212
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
	text-align:general;
	vertical-align:bottom;
	border-top:none;
	
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl7114212
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
	vertical-align:bottom;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl7214212
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
	vertical-align:bottom;
	border:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl7314212
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
	text-align:left;
	vertical-align:middle;
	border:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl7414212
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
	text-align:left;
	vertical-align:bottom;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl7514212
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-family: bold;
	font-size:20.0pt;
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
.xl7614212
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
	text-align:left;
	vertical-align:bottom;
	border-top:.5pt solid windowtext;
	border-right:none;
	border-bottom:none;
	
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl7714212
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
	text-align:left;
	vertical-align:bottom;
	
	border-right:none;
	border-bottom:none;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl7814212
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
	text-align:left;
	vertical-align:bottom;
	border-top:.5pt solid windowtext;
	border-right:.5pt solid windowtext;
	border-bottom:none;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl7914212
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
	text-align:left;
	vertical-align:bottom;
	border-top:none;
	border-right:none;
	border-bottom:none;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl8014212
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
	text-align:left;
	vertical-align:bottom;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl8114212
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
	text-align:left;
	vertical-align:bottom;
	border-top:none;
	border-right:.5pt solid windowtext;
	border-bottom:none;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl8214212
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
	text-align:left;
	vertical-align:bottom;
	border-top:none;
	border-right:none;
	border-bottom:.5pt solid windowtext;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl8314212
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
	text-align:left;
	vertical-align:bottom;
	border-top:none;
	border-right:none;
	border-bottom:.5pt solid windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl8414212
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
	text-align:left;
	vertical-align:bottom;
	border-top:none;
	border-right:.5pt solid windowtext;
	border-bottom:.5pt solid windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl8514212
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
	vertical-align:bottom;
	border:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	width: auto;
	white-space:nowrap;}
.xl8614212
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
	vertical-align:bottom;
	border-top:.5pt solid windowtext;
	border-right:.5pt solid windowtext;
	border-bottom:none;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl8714212
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
	vertical-align:bottom;
	border-top:.5pt solid windowtext;
	border-right:none;
	border-bottom:.5pt solid windowtext;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl8814212
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
	vertical-align:bottom;
	border-top:.5pt solid windowtext;
	border-right:.5pt solid windowtext;
	border-bottom:.5pt solid windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl8914212
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
	vertical-align:bottom;
	border-top:none;
	border-right:.5pt solid windowtext;
	border-bottom:none;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl9014212
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
	vertical-align:bottom;
	border-top:none;
	border-right:.5pt solid windowtext;
	border-bottom:.5pt solid windowtext;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl9114212
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
.xl9214212
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
	text-align:left;
	vertical-align:top;
	border-top:.5pt solid windowtext;
	border-right:none;
	border-bottom:none;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl9314212
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
	text-align:left;
	vertical-align:top;
	border-top:.5pt solid windowtext;
	border-right:none;
	border-bottom:none;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl9414212
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
	text-align:left;
	vertical-align:top;
	border-top:.5pt solid windowtext;
	border-right:.5pt solid windowtext;
	border-bottom:none;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl9514212
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
	text-align:left;
	vertical-align:top;
	border-top:none;
	border-right:none;
	border-bottom:none;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl9614212
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
	text-align:left;
	vertical-align:top;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl9714212
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
	text-align:left;
	vertical-align:top;
	border-top:none;
	border-right:.5pt solid windowtext;
	border-bottom:none;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl9814212
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
	text-align:left;
	vertical-align:top;
	border-top:none;
	border-right:none;
	border-bottom:.5pt solid windowtext;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl9914212
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
	text-align:left;
	vertical-align:top;
	border-top:none;
	border-right:none;
	border-bottom:.5pt solid windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl10014212
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
	text-align:left;
	vertical-align:top;
	border-top:none;
	border-right:.5pt solid windowtext;
	border-bottom:.5pt solid windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl10114212
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
	text-align:left;
	vertical-align:middle;
	border-top:.5pt solid windowtext;
	border-right:none;
	border-bottom:none;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl10214212
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
	text-align:left;
	vertical-align:middle;
	border-top:.5pt solid windowtext;
	border-right:.5pt solid windowtext;
	border-bottom:none;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl10314212
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
	text-align:left;
	vertical-align:middle;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl10414212
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
	text-align:left;
	vertical-align:middle;
	border-top:none;
	border-right:.5pt solid windowtext;
	border-bottom:none;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl10514212
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
	border-top:.5pt solid windowtext;
	border-right:none;
	border-bottom:none;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl10614212
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
	border-top:.5pt solid windowtext;
	border-right:.5pt solid windowtext;
	border-bottom:none;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl10714212
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
	text-align:right;
	vertical-align:bottom;
	border-top:.5pt solid windowtext;
	border-right:none;
	border-bottom:none;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl10814212
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
	text-align:right;
	vertical-align:bottom;
	border-top:.5pt solid windowtext;
	border-right:none;
	border-bottom:none;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl10914212
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
	text-align:right;
	vertical-align:middle;
	border-top:.5pt solid windowtext;
	border-right:none;
	border-bottom:none;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl11014212
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
	text-align:right;
	vertical-align:middle;
	border-top:none;
	border-right:none;
	border-bottom:none;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl11114212
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
	text-align:right;
	vertical-align:middle;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl11214212
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
	text-align:right;
	vertical-align:middle;
	border-top:none;
	border-right:none;
	border-bottom:.5pt solid windowtext;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl11314212
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
	text-align:right;
	vertical-align:middle;
	border-top:.5pt solid windowtext;
	border-right:.5pt solid windowtext;
	border-bottom:none;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl11414212
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
	text-align:right;
	vertical-align:middle;
	border-top:none;
	border-right:.5pt solid windowtext;
	border-bottom:none;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl11514212
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
	text-align:right;
	vertical-align:middle;
	border-top:none;
	border-right:.5pt solid windowtext;
	border-bottom:.5pt solid windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl11614212
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
	text-align:left;
	vertical-align:middle;
	border-top:none;
	border-right:none;
	border-bottom:.5pt solid windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl11714212
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
	text-align:left;
	vertical-align:middle;
	border-top:none;
	border-right:.5pt solid windowtext;
	border-bottom:.5pt solid windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl11814212
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
	border-top:none;
	border-right:none;
	border-bottom:.5pt solid windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl11914212
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
	border-top:none;
	border-right:.5pt solid windowtext;
	border-bottom:.5pt solid windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl12014212
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
	text-align:right;
	vertical-align:bottom;
	border-top:none;
	border-right:none;
	border-bottom:.5pt solid windowtext;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl12114212
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
	vertical-align:middle;
	border-top:.5pt solid windowtext;
	border-right:none;
	border-bottom:none;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl12214212
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
	vertical-align:middle;
	border-top:.5pt solid windowtext;
	border-right:.5pt solid windowtext;
	border-bottom:none;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl12314212
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
	vertical-align:middle;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl12414212
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
	vertical-align:middle;
	border-top:none;
	border-right:none;
	border-bottom:.5pt solid windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl12514212
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
	vertical-align:middle;
	border-top:none;
	border-right:.5pt solid windowtext;
	border-bottom:.5pt solid windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl12614212
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
	text-align:right;
	vertical-align:bottom;
	border-top:none;
	border-right:none;
	border-bottom:.5pt solid windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
--></style>
<style type="text/css">
@page
{
	size: landscape;
	margin: 0cm;
}
</style>

<style>

@media print {
@page narrow {size: 9in 11in}
@page rotated {size: landscape}
DIV {page: narrow}
TABLE {page: rotated}
#non-printable { display: none; }
#printable { display: block; }
#logo { display: block; }
body { zoom:75%;}
#ad{ display:none;}
#leftbar{ display:none;}
#Book1_29570{ width:75%; margin-left:20px;}
}
</style>

<script>
function printpr()
{
var OLECMDID = 7;
/* OLECMDID values:
* 6 - print
* 7 - print preview
* 1 - open window
* 4 - Save As
*/
var PROMPT = 1; // 2 DONTPROMPTUSER
var WebBrowser = '<OBJECT ID="WebBrowser1" WIDTH=0 HEIGHT=0 CLASSID="CLSID:8856F961-340A-11D0-A96B-00C04FD705A2"></OBJECT>';
document.body.insertAdjacentHTML('beforeEnd', WebBrowser);
WebBrowser1.ExecWB(OLECMDID, PROMPT);
WebBrowser1.outerHTML = "";
}
</script>
</head>

<body onload="printpr();">
<div class="panel panel-primary">
<div class="panel-heading"></div>
<div class="panel-body">
<!--[if !excel]>&nbsp;&nbsp;<![endif]-->
<!--The following information was generated by Microsoft Excel's Publish as Web
Page wizard.-->
<!--If the same item is republished from Excel, all information between the DIV
tags will be replaced.-->
<!--->
<!-START OF OUTPUT FROM EXCEL PUBLISH AS WEB PAGE WIZARD -->


<div id="Book1_14212" align=center x:publishsource="Excel">

<table border=0 cellpadding=0 cellspacing=0 width=960 style='border-collapse:
 collapse;table-layout:fixed;width:720pt'>
 <col width=64 style='width:48pt'>
 <col class=xl6614212 width=64 style='width:48pt'>
 <col class=xl1514212 width=64 span=12 style='width:48pt'>
 <col class=xl6714212 width=64 style='width:48pt'>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl6314212 width=64 style='height:15.0pt;width:48pt'>&nbsp;</td>
  <td class=xl6414212 width=64 style='width:48pt'>&nbsp;</td>
  <td class=xl6414212 width=64 style='width:48pt'>&nbsp;</td>
  <td class=xl6414212 width=64 style='width:48pt'>&nbsp;</td>
  <td class=xl6414212 width=64 style='width:48pt'>&nbsp;</td>
  <td class=xl6414212 width=64 style='width:48pt'>&nbsp;</td>
  <td class=xl6414212 width=64 style='width:48pt'>&nbsp;</td>
  <td class=xl6414212 width=64 style='width:48pt'>&nbsp;</td>
  <td class=xl6414212 width=64 style='width:48pt'>&nbsp;</td>
  <td class=xl6414212 width=64 style='width:48pt'>&nbsp;</td>
  <td class=xl6414212 width=64 style='width:48pt'>&nbsp;</td>
  <td class=xl6414212 width=64 style='width:48pt'>&nbsp;</td>
  <td class=xl6414212 width=64 style='width:48pt'><?php echo $print_status; ?></td>
  <td class=xl6414212 width=64 style='width:48pt'>&nbsp;</td>
  <td class=xl6514212 width=64 style='width:48pt'>&nbsp;</td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  
  <td colspan=9 rowspan=2 class=xl7514212>Additional Material Request <Br/>Transaction Note</td>
  <td  height=20 align="right" colspan=4 class=xl6614212 style='height:75.0pt'><img src="/sfcs_app/common/images/<?= $global_facility_code ?>_Logo.JPG"></img><br/></br></td>
  <td class=xl1514212></td>
  <td class=xl1514212></td>
  <td class=xl1514212></td>
  <td class=xl1514212></td>
  <td class=xl6714212>&nbsp;</td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl6614212 style='height:15.0pt'>&nbsp;</td>
  <td class=xl1514212></td>
  <td class=xl1514212></td>
  <td class=xl1514212></td>
  <td class=xl1514212></td>
  <td class=xl1514212></td>
  <td class=xl1514212></td>
  <td class=xl1514212></td>
  <td class=xl1514212></td>
  <td class=xl6714212>&nbsp;</td>
 </tr>

 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl6614212 style='height:15.0pt'>&nbsp;</td>
  <td class=xl1514212></td>
  <td colspan=5 rowspan=2 class=xl7214212><?php echo "<div id='bcTarget$tid' style='width:auto;'></div><script>$('#bcTarget$tid').barcode('".$tid."', 'code39',{barWidth:3.5,barHeight:18,moduleSize:5,fontSize:0});</script>";?></td>
  <td class=xl1514212></td>
  <td colspan=5 rowspan=2 class=xl7314212><span
  style='mso-spacerun:yes'></span>MRN ID :<?php echo $tid; ?><span
  style='mso-spacerun:yes'></span></td>
  <td class=xl1514212></td>
  <td class=xl6714212>&nbsp;</td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl6614212 style='height:15.0pt'>&nbsp;</td>
  <td class=xl1514212></td>
  <td class=xl1514212></td>
  <td class=xl1514212></td>
  <td class=xl6714212>&nbsp;</td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl6614212 style='height:15.0pt'>&nbsp;</td>
  <td class=xl1514212></td>
  <td class=xl1514212></td>
  <td class=xl1514212></td>
  <td class=xl1514212></td>
  <td class=xl1514212></td>
  <td class=xl1514212></td>
  <td class=xl1514212></td>
  <td class=xl1514212></td>
  <td class=xl1514212></td>
  <td class=xl1514212></td>
  <td class=xl1514212></td>
  <td class=xl1514212></td>
  <td class=xl1514212></td>
  <td class=xl6714212>&nbsp;</td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl6614212 style='height:15.0pt'>&nbsp;</td>
  <td class=xl1514212></td>
  <td class=xl1514212></td>
  <td class=xl1514212></td>
  <td class=xl1514212></td>
  <td class=xl1514212></td>
  <td class=xl1514212></td>
  <td class=xl1514212></td>
  <td class=xl1514212></td>
  <td class=xl1514212></td>
  <td class=xl1514212></td>
  <td class=xl1514212></td>
  <td class=xl1514212></td>
  <td class=xl1514212></td>
  <td class=xl6714212>&nbsp;</td>
 </tr>
 <tr height=21 style='height:15.75pt'>
  <td height=21 class=xl6614212 style='height:15.75pt'>&nbsp;</td>
  <td class=xl1514212></td>
  <td colspan=2 class=xl10914212 style='border-right:.5pt solid black'>Style:</td>
  <td colspan=3 class=xl7614212 style='border-right:.5pt solid black;
  border-left:none'><?php echo $style."/C0: ".$co_no; ?></td>
  <td class=xl1514212></td>
  <td colspan=2 class=xl10914212 style='border-right:.5pt solid black'>ItemCode:</td>
  <td colspan=3 class=xl10114212 style='border-right:.5pt solid black'><?php echo $item_code; ?></td>
  <td class=xl1514212></td>
  <td class=xl6714212>&nbsp;</td>
 </tr>
 <tr height=21 style='height:15.75pt'>
  <td height=21 class=xl6614212 style='height:15.75pt'>&nbsp;</td>
  <td class=xl1514212></td>
  <td colspan=2 class=xl11014212 style='border-right:.5pt solid black'>Schedule:</td>
  <td colspan=3 class=xl7914212 style='border-right:.5pt solid black;
  border-left:none'><?php echo $schedule; ?></td>
  <td class=xl1514212></td>
  <td colspan=2 class=xl11014212 style='border-right:.5pt solid black'>Item
  Desc:</td>
  <td colspan=3 class=xl10314212 style='border-right:.5pt solid black'><?php echo $item_desc; ?></td>
  <td class=xl1514212></td>
  <td class=xl6714212>&nbsp;</td>
 </tr>
 <tr height=21 style='height:15.75pt'>
  <td height=21 class=xl6614212 style='height:15.75pt'>&nbsp;</td>
  <td class=xl1514212></td>
  <td colspan=2 class=xl11014212 style='border-right:.5pt solid black'>Color:</td>
  <td colspan=3 class=xl7914212 style='border-right:.5pt solid black;
  border-left:none'><?php echo $color_explode[0]; ?></td>
  <td class=xl1514212></td>
  <td colspan=2 class=xl11014212 style='border-right:.5pt solid black'>Product
  Code:</td>
  <td colspan=3 class=xl10314212 style='border-right:.5pt solid black'><?php echo $product; ?></td>
  <td class=xl1514212></td>
  <td class=xl6714212>&nbsp;</td>
 </tr>
 <tr height=21 style='height:15.75pt'>
  <td height=21 class=xl6614212 style='height:15.75pt'>&nbsp;</td>
  <td class=xl1514212></td>
  <td colspan=2 class=xl11014212 style='border-right:.5pt solid black'>CutNo:</td>
  <td colspan=3 class=xl7914212 style='border-right:.5pt solid black;
  border-left:none'><?php echo $color_explode[1]; ?></td>
  <td class=xl1514212></td>
  <td colspan=2 class=xl11014212 style='border-right:.5pt solid black'>Reason:</td>
  <td colspan=3 class=xl10314212 style='border-right:.5pt solid black'><?php echo $reason; ?></td>
  <td class=xl1514212></td>
  <td class=xl6714212>&nbsp;</td>
 </tr>
 <tr height=21 style='height:15.75pt'>
  <td height=21 class=xl6614212 style='height:15.75pt'>&nbsp;</td>
  <td class=xl1514212></td>
  <td colspan=2 class=xl11214212 style='border-right:.5pt solid black'>Section:</td>
  <td colspan=3 class=xl8214212 style='border-right:.5pt solid black;
  border-left:none'><?php echo $section; ?></td>
  <td class=xl1514212></td>
  <td colspan=2 class=xl11214212 style='border-right:.5pt solid black'>Request
  Ref:</td>
  <td colspan=3 class=xl11614212 style='border-right:.5pt solid black'><?php echo $requestref; ?></td>
  <td class=xl1514212></td>
  <td class=xl6714212>&nbsp;</td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl6614212 style='height:15.0pt'>&nbsp;</td>
  <td class=xl1514212></td>
  <td class=xl1514212></td>
  <td class=xl1514212></td>
  <td class=xl1514212></td>
  <td class=xl1514212></td>
  <td class=xl1514212></td>
  <td class=xl1514212></td>
  <td class=xl1514212></td>
  <td class=xl1514212></td>
  <td class=xl1514212></td>
  <td class=xl1514212></td>
  <td class=xl1514212></td>
  <td class=xl1514212></td>
  <td class=xl6714212>&nbsp;</td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl6614212 style='height:15.0pt'>&nbsp;</td>
  <td class=xl1514212></td>
  <td class=xl1514212></td>
  <td class=xl1514212></td>
  <td class=xl1514212></td>
  <td class=xl1514212></td>
  <td class=xl1514212></td>
  <td class=xl1514212></td>
  <td class=xl1514212></td>
  <td class=xl1514212></td>
  <td class=xl1514212></td>
  <td class=xl1514212></td>
  <td class=xl1514212></td>
  <td class=xl1514212></td>
  <td class=xl6714212>&nbsp;</td>
 </tr>

 <tr height=21 style='height:15.75pt'>
  <td height=21 class=xl6614212 style='height:15.75pt'>&nbsp;</td>
  <td class=xl1514212></td>
  <td colspan=2 class=xl8514212>Requested By</td>
  <td rowspan=4 class=xl8614212 style='border-bottom:.5pt solid black'>&nbsp;</td>
  <td colspan=2 class=xl8514212 style='border-left:none'>Approved By</td>
  <td rowspan=4 class=xl8614212 style='border-bottom:.5pt solid black'>&nbsp;</td>
  <td colspan=2 class=xl8514212 style='border-left:none'>Updated By</td>
  <td rowspan=4 class=xl8614212 style='border-bottom:.5pt solid black'>&nbsp;</td>
  <td colspan=2 class=xl8514212 style='border-left:none'>Issued By</td>
  <td class=xl1514212></td>
  <td class=xl6714212>&nbsp;</td>
 </tr>
 <tr height=21 style='height:15.75pt'>
  <td height=21 class=xl6614212 style='height:15.75pt'></td>
  <td class=xl1514212></td>
  <td colspan=2 class=xl8714212 style='border-right:.5pt solid black'><?php echo $requestedby; ?></td>
  <td colspan=2 class=xl8714212 style='border-right:.5pt solid black;
  border-left:none'><?php echo $approvedby; ?></td>
  <td colspan=2 class=xl8714212 style='border-right:.5pt solid black;
  border-left:none'><?php echo $approvedby; ?></td>
  <td colspan=2 class=xl8714212 style='border-right:.5pt solid black;
  border-left:none'><?php echo $issuedby; ?></td>
  <td class=xl1514212></td>
  <td class=xl6714212>&nbsp;</td>
 </tr>
 <tr height=21 style='height:15.75pt'>
  <td height=21 class=xl6614212 style='height:15.75pt'>&nbsp;</td>
  <td class=xl1514212></td>
  <td colspan=2 class=xl8714212 style='border-right:.5pt solid black'>Requested
  Qty</td>
  <td colspan=2 class=xl8714212 style='border-right:.5pt solid black;
  border-left:none'>Approved Qty</td>
  <td colspan=2 class=xl8714212 style='border-right:.5pt solid black;
  border-left:none'>Updated Qty</td>
  <td colspan=2 class=xl8714212 style='border-right:.5pt solid black;
  border-left:none'>Issued Qty</td>
  <td class=xl1514212></td>
  <td class=xl6714212>&nbsp;</td>
 </tr>
 <tr height=21 style='height:15.75pt'>
  <td height=21 class=xl6614212 style='height:15.75pt'>&nbsp;</td>
  <td class=xl1514212></td>
  <td colspan=2 class=xl8714212 style='border-right:.5pt solid black'><?php echo $requestedqty; ?></td>
  <td colspan=2 class=xl8714212 style='border-right:.5pt solid black;
  border-left:none'><?php echo $approvedqty; ?></td>
  <td colspan=2 class=xl8714212 style='border-right:.5pt solid black;
  border-left:none'><?php echo $approvedqty; ?></td>
  <td colspan=2 class=xl8714212 style='border-right:.5pt solid black;
  border-left:none'><?php echo $issuedqty; ?></td>
  <td class=xl1514212></td>
  <td class=xl6714212>&nbsp;</td>
 </tr>
 <tr height=21 style='height:15.75pt'>
  <td height=21 class=xl6614212 style='height:15.75pt'>&nbsp;</td>
  <td class=xl1514212></td>
  <td class=xl9114212></td>
  <td class=xl9114212></td>
  <td class=xl9114212></td>
  <td class=xl9114212></td>
  <td class=xl9114212></td>
  <td class=xl9114212></td>
  <td class=xl9114212></td>
  <td class=xl9114212></td>
  <td class=xl9114212></td>
  <td class=xl9114212></td>
  <td class=xl9114212></td>
  <td class=xl1514212></td>
  <td class=xl6714212>&nbsp;</td>
 </tr>
 <tr height=21 style='height:15.75pt'>
  <td height=21 class=xl6614212 style='height:15.75pt'>&nbsp;</td>
  <td class=xl1514212></td>
  <td class=xl9114212></td>
  <td class=xl9114212></td>
  <td class=xl9114212></td>
  <td class=xl9114212></td>
  <td class=xl9114212></td>
  <td class=xl9114212></td>
  <td class=xl9114212></td>
  <td class=xl9114212></td>
  <td class=xl9114212></td>
  <td class=xl9114212></td>
  <td class=xl9114212></td>
  <td class=xl1514212></td>
  <td class=xl6714212>&nbsp;</td>
 </tr>
 <?php
 	if(strlen($lable_ids)>0)
	{
?>
 <tr height=21 style='height:15.75pt'>
  <td height=21 class=xl6614212 style='height:15.75pt;width:25pt;'>&nbsp;</td>
  <td class=xl1514212></td>
  <td colspan=2 class=xl8514212>RollNo</td>
  <?php
	$sql1="select * from $bai_rm_pj1.store_in where tid in ($lable_ids)";
	$result1=mysqli_query($link, $sql1) or die("Error121=".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($row1=mysqli_fetch_array($result1))
	{
		echo "<td colspan=2 class=xl8514212>".$row1["ref2"]."</td>";
	}
  ?>
  <td class=xl1514212></td>
 </tr>

 <tr height=21 style='height:15.75pt'>
  <td height=21 class=xl6614212 style='height:15.75pt'>&nbsp;</td>
  <td class=xl1514212></td>
  <td colspan=2 class=xl8514212>LotNo</td>
  <?php
  	$sql1="select * from $bai_rm_pj1.store_in where tid in ($lable_ids)";
	$result1=mysqli_query($link, $sql1) or die("Error122=".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($row1=mysqli_fetch_array($result1))
	{
		echo "<td colspan=2 class=xl8514212 >".$row1["lot_no"]."</td>";
	}
  ?>
  <td class=xl1514212></td>
 </tr>
 <tr height=21 style='height:15.75pt'>
  <td height=21 class=xl6614212 style='height:15.75pt'>&nbsp;</td>
  <td class=xl1514212></td>
  <td colspan=2 class=xl8514212>LableId</td>
  <?php
  	$sql1="select * from $bai_rm_pj1.store_in where tid in ($lable_ids)";
	$result1=mysqli_query($link, $sql1) or die("Error123=".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($row1=mysqli_fetch_array($result1))
	{
		echo "<td colspan=2 class=xl8514212>".$row1["tid"]."</td>";
	}
  ?>
  <td class=xl1514212></td>
 </tr>
 <tr height=21 style='height:15.75pt'>
  <td height=21 class=xl6614212 style='height:15.75pt'>&nbsp;</td>
  <td class=xl1514212></td>
  <td colspan=2 class=xl8514212>Width</td>
  <?php
  	$sql1="select * from $bai_rm_pj1.store_in where tid in ($lable_ids)";
	$result1=mysqli_query($link, $sql1) or die("Error124=".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($row1=mysqli_fetch_array($result1))
	{
		if($row1["ref6"]>0)
		{
			echo "<td colspan=2 class=xl8514212>".$row1["ref6"]."</td>";
		}
		else
		{
			echo "<td colspan=2 class=xl8514212>".$row1["ref2"]."</td>";
		}
		
	}
  ?>
  <td class=xl1514212></td>
 </tr>
  <tr height=21 style='height:15.75pt'>
  <td height=21 class=xl6614212 style='height:15.75pt'>&nbsp;</td>
  <td class=xl1514212></td>
  <td colspan=2 class=xl8514212>Length</td>
  <?php
  	$sql1="select iss_qty from $bai_rm_pj2.mrn_out_allocation where lable_id in ($lable_ids) and   mrn_tid=$mrn_id";
	$result1=mysqli_query($link, $sql1) or die("Error125=".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($row1=mysqli_fetch_array($result1))
	{
		echo "<td colspan=2 class=xl8514212>".$row1["iss_qty"]."</td>";
	}
  ?>
  <td class=xl1514212></td>
 </tr>
  <tr height=21 style='height:15.75pt'>
  <td height=21 class=xl6614212 style='height:15.75pt'>&nbsp;</td>
  <td class=xl1514212></td>
  <td colspan=2 class=xl8514212>Batch</td>
  <?php
    $sql1="select * from $bai_rm_pj1.store_in where tid in ($lable_ids)";
	//echo $sql1."<br>";
	$result1=mysqli_query($link, $sql1) or die("Error126=".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($row1=mysqli_fetch_array($result1))
	{
		$sql3="select group_concat(distinct batch_no) as batch from $bai_rm_pj1.sticker_report where lot_no=\"".$row1["lot_no"]."\"";
		//echo $sql3."<br>";
		$result3=mysqli_query($link, $sql3) or die("Error127=".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($row3=mysqli_fetch_array($result3))
		{
		echo "<td colspan=2 class=xl8514212>".$row3["batch"]."</td>";
		}
	}
  ?>
  <td class=xl1514212></td>
 </tr>
  <tr height=21 style='height:15.75pt'>
  <td height=21 class=xl6614212 style='height:15.75pt'>&nbsp;</td>
  <td class=xl1514212></td>
  <td colspan=2 class=xl8514212>Shade</td>
  <?php
  	$sql1="select * from $bai_rm_pj1.store_in where tid in ($lable_ids)";
	$result1=mysqli_query($link, $sql1) or die("Error128=".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($row1=mysqli_fetch_array($result1))
	{
		echo "<td colspan=2 class=xl8514212>".$row1["ref4"]."</td>";
	}
  ?>
  <td class=xl1514212></td>
 </tr>
  <tr height=21 style='height:15.75pt'>
  <td height=21 class=xl6614212 style='height:15.75pt'>&nbsp;</td>
  <td class=xl1514212></td>
  <td colspan=2 class=xl8514212>Location</td>
   <?php
  	$sql1="select * from $bai_rm_pj1.store_in where tid in ($lable_ids)";
	$result1=mysqli_query($link, $sql1) or die("Error129=".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($row1=mysqli_fetch_array($result1))
	{
		echo "<td colspan=2 class=xl8514212>".$row1["ref1"]."</td>";
	}
  ?>
  <td class=xl1514212></td>
 </tr>
 <?php
}
?>
 <tr height=21 style='height:15.75pt'>
  
  <td class=xl1514212></td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl6614212 style='height:15.0pt'>&nbsp;</td>
  <td class=xl1514212></td>
  <td colspan=11 rowspan=3 class=xl9214212 style='border-right:.5pt solid black;
  border-bottom:.5pt solid black'>Remarks:<?php echo $remarks; ?></td>
  <td class=xl1514212></td>
  <td class=xl6714212>&nbsp;</td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl6614212 style='height:15.0pt'>&nbsp;</td>
  <td class=xl1514212></td>
  <td class=xl1514212></td>
  <td class=xl6714212>&nbsp;</td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl6614212 style='height:15.0pt'>&nbsp;</td>
  <td class=xl1514212></td>
  <td class=xl1514212></td>
  <td class=xl6714212>&nbsp;</td>
 </tr>
 
 <tr height=21 style='height:15.75pt'>
  <td height=21 class=xl6614212 style='height:15.75pt'>&nbsp;</td>
  <td class=xl1514212></td>
  <td class=xl9614212></td>
  <td class=xl9614212></td>
  <td class=xl9614212></td>
  <td class=xl9614212></td>
  <td class=xl9614212></td>
  <td class=xl9614212></td>
  <td class=xl9614212></td>
  <td class=xl9614212></td>
  <td class=xl9614212></td>
  <td class=xl9614212></td>
  <td class=xl9614212></td>
  <td class=xl1514212></td>
  <td class=xl6714212>&nbsp;</td>
 </tr>

 <tr height=21 style='height:15.75pt'>
  <td height=21 class=xl6614212 style='height:15.75pt'>&nbsp;</td>
  <td class=xl1514212></td>
  <td colspan=2 class=xl10714212 style='border-right:.5pt solid black'>Issued By:</td>
  <td class=xl10514212>&nbsp;</td>
  <td class=xl10614212>&nbsp;</td>
  <td class=xl9114212></td>
  <td class=xl9114212></td>
  <td class=xl9114212></td>
  <td colspan=2 class=xl10914212 style='border-right:.5pt solid black'><span
  style='mso-spacerun:yes'></span>Received By:</td>
  <td class=xl12114212>&nbsp;</td>
  <td class=xl12214212>&nbsp;</td>
  <td class=xl1514212></td>
  <td class=xl6714212>&nbsp;</td>
 </tr>
 <tr height=21 style='height:15.75pt'>
  <td height=21 class=xl6614212 style='height:15.75pt'>&nbsp;</td>
  <td class=xl1514212></td>
  <td colspan=2 class=xl12014212 style='border-right:.5pt solid black'><span style='mso-spacerun:yes'>
  </span>Emp No:</td>
  <td class=xl11814212>&nbsp;</td>
  <td class=xl11914212>&nbsp;</td>
  <td class=xl9114212></td>
  <td class=xl9114212></td>
  <td class=xl9114212></td>
  <td colspan=2 class=xl11214212 style='border-right:.5pt solid black'><span
  style='mso-spacerun:yes'></span>Emp No:</td>
  <td class=xl12414212>&nbsp;</td>
  <td class=xl12514212>&nbsp;</td>
  <td class=xl1514212></td>
  <td class=xl6714212>&nbsp;</td>
 </tr>
 <tr height=21 style='height:15.75pt'>
  <td height=21 class=xl6614212 style='height:15.75pt'>&nbsp;</td>
  <td class=xl1514212></td>
  <td class=xl9114212></td>
  <td class=xl9114212></td>
  <td class=xl9114212></td>
  <td class=xl9114212></td>
  <td class=xl9114212></td>
  <td class=xl9114212></td>
  <td class=xl9114212></td>
  <td colspan=2 class=xl11114212></td>
  <td class=xl12314212></td>
  <td class=xl12314212></td>
  <td class=xl1514212></td>
  <td class=xl6714212>&nbsp;</td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl6614212 style='height:15.0pt'>&nbsp;</td>
  <td class=xl1514212></td>
  <td class=xl1514212></td>
  <td class=xl1514212></td>
  <td class=xl1514212></td>
  <td class=xl1514212></td>
  <td class=xl1514212></td>
  <td class=xl1514212></td>
  <td class=xl1514212></td>
  <td class=xl1514212></td>
  <td class=xl1514212></td>
  <td class=xl1514212></td>
  <td class=xl1514212></td>
  <td class=xl1514212></td>
  <td class=xl6714212>&nbsp;</td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl6614212 style='height:15.0pt'>&nbsp;</td>
  <td class=xl1514212></td>
  <td colspan=4 class=xl7114212>____________________________</td>
  <td class=xl1514212></td>
  <td class=xl1514212></td>
  <td class=xl1514212></td>
  <td colspan=4 class=xl7114212>____________________________</td>
  <td class=xl1514212></td>
  <td class=xl6714212>&nbsp;</td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl6614212 style='height:15.0pt'>&nbsp;</td>
  <td class=xl1514212></td>
  <td colspan=4 class=xl7114212></td>
  <td class=xl1514212></td>
  <td class=xl1514212></td>
  <td class=xl1514212></td>
  <td colspan=4 class=xl7114212></td>
  <td class=xl1514212></td>
  <td class=xl6714212>&nbsp;</td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl6614212 style='height:15.0pt'>&nbsp;</td>
  <td class=xl1514212></td>
  <td colspan=4 class=xl7414212><span
  	
  style='mso-spacerun:yes'></span> Signature</td>
  <td class=xl1514212></td>
  <td class=xl1514212></td>
  <td class=xl1514212></td>

  <td colspan=4 class=xl7414212><span
  style='mso-spacerun:yes'></span>Signature</td>
  <td class=xl1514212></td>
  <td class=xl1514212></td>

  <td class=xl6714212>&nbsp;</td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl6614212 style='height:15.0pt'>&nbsp;</td>
  <td class=xl1514212></td>
  <td class=xl1514212></td>
  <td class=xl1514212></td>
  <td class=xl1514212></td>
  <td class=xl1514212></td>
  <td class=xl1514212></td>
  <td class=xl1514212></td>
  <td class=xl1514212></td>
  <td class=xl1514212></td>
  <td class=xl1514212></td>
  <td class=xl1514212></td>
  <td class=xl1514212></td>
  <td class=xl1514212></td>
  <td class=xl6714212>&nbsp;</td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl6614212 style='height:15.0pt'>&nbsp;</td>
  <td class=xl1514212></td>
  <td class=xl1514212></td>
  <td class=xl1514212></td>
  <td class=xl1514212></td>
  <td class=xl1514212></td>
  <td class=xl1514212></td>
  <td class=xl1514212></td>
  <td class=xl1514212></td>
  <td class=xl1514212></td>
  <td class=xl1514212></td>
  <td class=xl1514212></td>
  <td class=xl1514212></td>
  <td class=xl1514212></td>
  <td class=xl6714212>&nbsp;</td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl6614212 style='height:15.0pt'>&nbsp;</td>
  <td class=xl1514212></td>
  <td class=xl1514212></td>
  <td class=xl1514212></td>
  <td class=xl1514212></td>
  <td class=xl1514212></td>
  <td class=xl1514212></td>
  <td class=xl1514212></td>
  <td class=xl1514212></td>
  <td class=xl1514212></td>
  <td class=xl1514212></td>
  <td class=xl1514212></td>
  <td class=xl1514212></td>
  <td class=xl1514212></td>
  <td class=xl6714212>&nbsp;</td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl6614212 style='height:15.0pt'>&nbsp;</td>
  <td class=xl1514212></td>
  <td class=xl1514212></td>
  <td class=xl1514212></td>
  <td class=xl1514212></td>
  <td class=xl1514212></td>
  <td class=xl1514212></td>
  <td class=xl1514212></td>
  <td class=xl1514212></td>
  <td class=xl1514212></td>
  <td class=xl1514212></td>
  <td class=xl1514212></td>
  <td class=xl1514212></td>
  <td class=xl1514212></td>
  <td class=xl6714212>&nbsp;</td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl6614212 style='height:15.0pt'>&nbsp;</td>
  <td class=xl1514212></td>
  <td class=xl1514212></td>
  <td class=xl1514212></td>
  <td class=xl1514212></td>
  <td class=xl1514212></td>
  <td class=xl1514212></td>
  <td class=xl1514212></td>
  <td class=xl1514212></td>
  <td class=xl1514212></td>
  <td class=xl1514212></td>
  <td class=xl1514212></td>
  <td class=xl1514212></td>
  <td class=xl1514212></td>
  <td class=xl6714212>&nbsp;</td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl6614212 style='height:15.0pt'>&nbsp;</td>
  <td class=xl1514212></td>
  <td class=xl1514212></td>
  <td class=xl1514212></td>
  <td class=xl1514212></td>
  <td class=xl1514212></td>
  <td class=xl1514212></td>
  <td class=xl1514212></td>
  <td class=xl1514212></td>
  <td class=xl1514212></td>
  <td class=xl1514212></td>
  <td class=xl1514212></td>
  <td class=xl1514212></td>
  <td class=xl1514212></td>
  <td class=xl6714212>&nbsp;</td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl6614212 style='height:15.0pt'>&nbsp;</td>
  <td class=xl1514212></td>
  <td class=xl1514212></td>
  <td class=xl1514212></td>
  <td class=xl1514212></td>
  <td class=xl1514212></td>
  <td class=xl1514212></td>
  <td class=xl1514212></td>
  <td class=xl1514212></td>
  <td class=xl1514212></td>
  <td class=xl1514212></td>
  <td class=xl1514212></td>
  <td class=xl1514212></td>
  <td class=xl1514212></td>
  <td class=xl6714212>&nbsp;</td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl6814212 style='height:15.0pt'>&nbsp;</td>
  <td class=xl6914212>&nbsp;</td>
  <td class=xl6914212>&nbsp;</td>
  <td class=xl6914212>&nbsp;</td>
  <td class=xl6914212>&nbsp;</td>
  <td class=xl6914212>&nbsp;</td>
  <td class=xl6914212>&nbsp;</td>
  <td class=xl6914212>&nbsp;</td>
  <td class=xl6914212>&nbsp;</td>
  <td class=xl6914212>&nbsp;</td>
  <td class=xl6914212>&nbsp;</td>
  <td class=xl6914212>&nbsp;</td>
  <td class=xl6914212>&nbsp;</td>
  <td class=xl6914212>&nbsp;</td>
  <td class=xl7014212>&nbsp;</td>
 </tr>
 <![if supportMisalignedColumns]>
 <tr height=0 style='display:none'>
  <td width=64 style='width:48pt'></td>
  <td width=64 style='width:48pt'></td>
  <td width=64 style='width:48pt'></td>
  <td width=64 style='width:48pt'></td>
  <td width=64 style='width:48pt'></td>
  <td width=64 style='width:48pt'></td>
  <td width=64 style='width:48pt'></td>
  <td width=64 style='width:48pt'></td>
  <td width=64 style='width:48pt'></td>
  <td width=64 style='width:48pt'></td>
  <td width=64 style='width:48pt'></td>
  <td width=64 style='width:48pt'></td>
  <td width=64 style='width:48pt'></td>
  <td width=64 style='width:48pt'></td>
  <td width=64 style='width:48pt'></td>
 </tr>
 <![endif]>
</table>

</div>
<?php
if($_GET["print_status"]==0)
{
	$sql="update $bai_rm_pj2.mrn_track set status=8 where tid=$mrn_id";
	mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
}
?>

<!----------------------------->
<!--END OF OUTPUT FROM EXCEL PUBLISH AS WEB PAGE WIZARD-->
<!----------------------------->
</body>
</div>
</div>

</html>

