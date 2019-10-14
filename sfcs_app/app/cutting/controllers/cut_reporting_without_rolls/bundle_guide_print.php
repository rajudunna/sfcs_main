<?php
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config_ajax.php');
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/functions.php');
$doc_no=$_GET['doc_no'];
$bundle_no=array();
$getdetails2="SELECT size,bundle_no FROM $bai_pro3.docket_number_info where doc_no=".$doc_no." group by bundle_no order by id";
$getdetailsresult = mysqli_query($link,$getdetails2);
while($sql_row=mysqli_fetch_array($getdetailsresult))
{
	//echo $sql_row['bundle_no'];
	$size[] = $sql_row['size'];				
	$bundle_no[] = $sql_row['bundle_no'];				
	// $shade_bun[] = $sql_row['shade_bundle'];				
	// $bundle_start[$sql_row['bundle_no']] = $sql_row['bundle_start'];				
	// $bundle_end[$sql_row['bundle_no']] = $sql_row['bundle_end'];				
	// $qty[$sql_row['bundle_no']] = $sql_row['qty'];				
	// $shade[$sql_row['bundle_no']] = 'Shade';				
}

$getdetails1="SELECT compo_no,order_col_des,order_del_no,color_code,acutno FROM $bai_pro3.order_cat_doc_mk_mix  where doc_no=".$doc_no;
$getdetailsresult1 = mysqli_query($link,$getdetails1);
while($sql_row1=mysqli_fetch_array($getdetailsresult1))
{
	$compo_no = $sql_row1['compo_no'];
	$schedule = $sql_row1['order_del_no'];
	$color = $sql_row1['order_col_des'];
	$cut_no= chr($sql_row1['color_code']).leading_zeros($sql_row1['acutno'],3);	
}

$sql="select order_style_no from $bai_pro3.bai_orders_db_confirm where order_del_no='".$schedule."'";
$sql_result=mysqli_query($link, $sql) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row=mysqli_fetch_array($sql_result))
{	
	$style_no= $sql_row['order_style_no'];	
}

$docketdetials="select * from $bai_pro3.docket_roll_info where docket=".$doc_no." order by shade";
$docketdetials_result=mysqli_query($link, $docketdetials) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));


$sql="select * from $bai_pro3.bai_orders_db_confirm  where order_style_no='".$style_no."' and order_del_no='".$schedule."' and order_col_des='".$color."'";
mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_num_check=mysqli_num_rows($sql_result);
while($sql_row=mysqli_fetch_array($sql_result))
{
	$orde_tid=$sql_row['order_tid'];
	for($s=0;$s<sizeof($sizes_code);$s++)
	{
		if($sql_row["title_size_s".$sizes_code[$s].""]<>'')
		{
			$s_tit[$sizes_code[$s]]=$sql_row["title_size_s".$sizes_code[$s].""];
			$s_code[]=$sizes_code[$s];
		}	
	}
}


   
$sql="select * from $bai_pro3.order_cat_doc_mk_mix where order_tid='".$orde_tid."' and category in ($in_categories) and doc_no=$doc_no";
mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_result1=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
// $sql_num_check=mysqli_num_rows($sql_result);

$totalplies="select sum(reporting_plies) as totalplies from $bai_pro3.docket_roll_info where docket=$doc_no";
mysqli_query($link, $totalplies) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$totalpliesresult=mysqli_query($link, $totalplies) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$totalpliesresult=mysqli_fetch_array($totalpliesresult);
?>


<html xmlns:o="urn:schemas-microsoft-com:office:office"
xmlns:x="urn:schemas-microsoft-com:office:excel"
xmlns="http://www.w3.org/TR/REC-html40">

<head>
<meta http-equiv=Content-Type content="text/html; charset=windows-1252">
<meta name=ProgId content=Excel.Sheet>
<meta name=Generator content="Microsoft Excel 15">
<link rel=File-List href="bundle_guide_test1_files/filelist.xml">
<style id="bundle_guide_305_Styles">
<!--table
	{mso-displayed-decimal-separator:"\.";
	mso-displayed-thousand-separator:"\,";}
.xl15305
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
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl63305
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
	border-top:.5pt solid windowtext;
	border-right:none;
	border-bottom:none;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl64305
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
	border-top:.5pt solid windowtext;
	border-right:none;
	border-bottom:none;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl65305
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
	border-top:.5pt solid windowtext;
	border-right:.5pt solid windowtext;
	border-bottom:none;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl66305
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
	border-bottom:none;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl67305
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
	border-right:.5pt solid windowtext;
	border-bottom:none;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl68305
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
.xl69305
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
	text-align:right;
	vertical-align:bottom;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl70305
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
	text-align:right;
	vertical-align:bottom;
	border-top:none;
	border-right:none;
	border-bottom:none;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl71305
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
.xl72305
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
	border:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
	.xl73305a
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:11.0pt;
	font-weight:400;
	width: 40;
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
	.xl73305b
	{
	padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:10.0pt;
	font-weight:400;
	width: 40;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	/* border:.5pt solid windowtext; */
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl73305
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
.xl74305
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
	white-space:normal;}
.xl75305
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
	vertical-align:top;
	border:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl76305
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
	mso-number-format:"dd\/mmm";
	text-align:left;
	vertical-align:top;
	border:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
-->
</style>
</head>

<script>
function printpr()
{
	window.print();
	// var OLECMDID = 7;
	// /* OLECMDID values:
	// * 6 - print
	// * 7 - print preview
	// * 1 - open window
	// * 4 - Save As
	// */
	// var PROMPT = 1; // 2 DONTPROMPTUSER
	// var WebBrowser = '<OBJECT ID="WebBrowser1" WIDTH=0 HEIGHT=0 CLASSID="CLSID:8856F961-340A-11D0-A96B-00C04FD705A2"></OBJECT>';
	// document.body.insertAdjacentHTML('beforeEnd', WebBrowser);
	// WebBrowser1.ExecWB(OLECMDID, PROMPT);
	// WebBrowser1.outerHTML = "";
}
</script>

<body onload="printpr();">
<!--[if !excel]>&nbsp;&nbsp;<![endif]-->
<!--The following information was generated by Microsoft Excel's Publish as Web
Page wizard.-->
<!--If the same item is republished from Excel, all information between the DIV
tags will be replaced.-->
<!----------------------------->
<!--START OF OUTPUT FROM EXCEL PUBLISH AS WEB PAGE WIZARD -->
<!----------------------------->

<div id="bundle_guide_305" align="left" x:publishsource="Excel" >
<table border=0 cellpadding=0 cellspacing=0 width=300 style='border-collapse:
 collapse;table-layout:fixed;'>
 <tr height=19 style='height:14.4pt'>
  <td height=19 class=xl15305 width=64 style='height:14.4pt;width:48pt'></td>
  <td class=xl15305 width=64 style='width:48pt'></td>
  <td class=xl15305 width=64 style='width:48pt'></td>
  <td class=xl15305 width=64 style='width:48pt'></td>
  <td class=xl15305 width=64 style='width:48pt'></td>
  <td class=xl15305 width=64 style='width:48pt'></td>
  <td class=xl15305 width=64 style='width:48pt'></td>
  <td class=xl15305 width=64 style='width:48pt'></td>
  <td class=xl15305 width=70 style='width:53pt'></td>
  <td class=xl15305 width=64 style='width:48pt'></td>
  <td class=xl15305 width=64 style='width:48pt'></td>
  <td class=xl15305 width=64 style='width:48pt'></td>
  <td class=xl15305 width=64 style='width:48pt'></td>
  <td class=xl15305 width=64 style='width:48pt'></td>
 </tr>
 <tr height=19 style='height:14.4pt'>
  <td height=19 class=xl15305 style='height:14.4pt'></td>
  <td class=xl63305>&nbsp;</td>
  <td class=xl64305>&nbsp;</td>
  <td class=xl64305>&nbsp;</td>
  <td class=xl64305>&nbsp;</td>
  <td class=xl64305>&nbsp;</td>
  <td class=xl64305>&nbsp;</td>
  <td class=xl64305>&nbsp;</td>
  <td class=xl64305>&nbsp;</td>
  <td class=xl64305>&nbsp;</td>
  <td class=xl64305>&nbsp;</td>
  <td class=xl64305>&nbsp;</td>
  <td class=xl65305>&nbsp;</td>
  <td class=xl15305></td>
 </tr>
 <tr height=19 style='height:14.4pt'>
  <td height=19 class=xl15305 style='height:14.4pt'></td>
  <td colspan=2 class=xl70305>Style:</td>
  <td colspan=3 class=xl68305><?php echo $style_no;?></td>
  <td colspan=2 class=xl69305>Cut Number:</td>
  <td colspan=2 class=xl68305><?php echo $cut_no;?></td>
  <td class=xl15305></td>
  <td class=xl15305></td>
  <td class=xl67305>&nbsp;</td>
  <td class=xl15305></td>
 </tr>
 <tr height=19 style='height:14.4pt'>
  <td height=19 class=xl15305 style='height:14.4pt'></td>
  <td colspan=2 class=xl70305>Schedule:</td>
  <td colspan=3 class=xl68305><?php echo $schedule;?></td>
  <td colspan=2 class=xl69305>Docket Number:</td>
  <td colspan=2 class=xl68305><?php echo $doc_no;?></td>
  <td class=xl15305></td>
  <td class=xl15305></td>
  <td class=xl67305>&nbsp;</td>
  <td class=xl15305></td>
 </tr>
 <tr height=12 style='mso-height-source:userset;height:9.0pt;'>
  <td  height=12 class=xl15305 style='height:9.0pt;'></td>
  <td style='border-bottom:1px solid black;' class=xl66305>&nbsp;</td>
  <td style='border-bottom:1px solid black;' class=xl15305></td>
  <td style='border-bottom:1px solid black;' class=xl15305></td>
  <td style='border-bottom:1px solid black;' class=xl15305></td>
  <td style='border-bottom:1px solid black;' class=xl15305></td>
  <td style='border-bottom:1px solid black;' class=xl15305></td>
  <td style='border-bottom:1px solid black;' class=xl15305></td>
  <td style='border-bottom:1px solid black;' class=xl15305></td>
  <td style='border-bottom:1px solid black;' class=xl15305></td>
  <td style='border-bottom:1px solid black;' class=xl15305></td>
  <td style='border-bottom:1px solid black;' class=xl15305></td>
  <td style='border-bottom:1px solid black;' class=xl67305>&nbsp;</td>
  <td class=xl15305></td>
 </tr>
</table>
</div> 
<br><br>
<div id="bundle_guide_305" align="left" x:publishsource="Excel" style="margin-left:60px;">
<table border=0 cellpadding=0 cellspacing=0 width=300 style='border-collapse:
 collapse;table-layout:fixed;'>
 <?php
 /* sizeof($s_tit) */
 $total_size = sizeof($s_tit);
 $temp = 0;
$temp_len1 = 0;
$temp_len = 0;
$divide=18;
/* var_dump(mysqli_fetch_array($sql_result1)); */
for($s=0;$s<$total_size;$s++)
{
    
    if($temp == 0){
        echo "<td class=xl73305a style='background-color: gainsboro;'>Size</td>";
        $temp = 1;
    }
    echo  "<td class=xl73305a style='background-color: gainsboro;'>".$s_tit[$sizes_code[$s]]."</td>";
    if(($s+1) % $divide == 0){
        $temp_len = $s+1;
        echo "</tr>";
        echo "<tr>
            <td class=xl73305a>Ratio</td>";
			while($sql_row=mysqli_fetch_array($sql_result1)){
        		for($i=$temp_len1;$i<$temp_len;$i++) {
                	echo "<td class=xl73305a class=xl75305 style='border-top:none;text-align:center;'>".$sql_row["p_s".$sizes_code[$i].""]."</td>";
				}
            }
        echo "</tr>";
        $temp = 0;
        $temp_len1=$temp_len;
    }
    if($s+1==$total_size) {
        echo "<td class=xl73305b>No Of Plies</td></tr><tr><td class=xl73305a>Ratio</td>";
		while($sql_row=mysqli_fetch_array($sql_result1)){
			for($i=$temp_len1;$i<$total_size;$i++) {
				echo "<td class=xl73305a class=xl75305 style='border-top:none;text-align:center;'>".$sql_row["p_s".$sizes_code[$i].""]."</td>";
			}
		}
        echo "<td class=xl73305b>".$totalpliesresult['totalplies']."</td></tr><br/>";
    }
}
?>
<tr>
		<?php
		/* sizeof($s_tit) */
		/* for($s=0;$s<sizeof($s_tit);$s++)
        { */
            /* echo "<td class=xl73305 style='background-color: gainsboro;'>".$s_tit[$sizes_code[$s]]."</td>"; */
			/* echo "<td class=xl73305a style='background-color: gainsboro;' >".$s."</td>"; */
            
        /* }
		echo "<td class=xl73305 style='background-color: gainsboro;'>No Of Plies</td>"; */
		?>

</tr>
<tr>
<?php 
while($sql_row=mysqli_fetch_array($sql_result1))
	{
	for($s=0;$s<sizeof($s_tit);$s++)
	{
	   // $code="p_s".$sizes_code[$s];
		//echo "<th>".$s_tit[$sizes_code[$s]]."</th>";
		echo "<td class=xl75305 style='border-top:none;text-align:center;'>".$sql_row["p_s".$sizes_code[$s].""]."</td>";
	}
		echo "<td class=xl75305 style='border-top:none;text-align:center;'>".$totalpliesresult['totalplies']."</td>";
	}
?>
</tr>
</table>
</div>
<br><br>
<div id="bundle_guide_305" align="left" x:publishsource="Excel" style="margin-left:60px;">
<table border=0 cellpadding=0 cellspacing=0 width=600 style='border-collapse:
 collapse;table-layout:fixed;'>

<tr height=19 style='height:14.4pt'>
  <td class=xl73305 style='background-color: gainsboro;'>Laysequence</td>
  <td class=xl73305 style='background-color: gainsboro;'>Shade</td>
  <td class=xl74305 width=70 style='width:53pt;background-color: gainsboro;'>Total Plies</td>
 </tr>
			<?php 
			while($docketdetials_row=mysqli_fetch_array($docketdetials_result))
			{	
				?>
			<tr height=19 style='height:14.4pt'>
			<td class=xl75305 style='border-top:none;text-align:center;'><?php echo $docketdetials_row['lay_sequence']; ?></td>			
			<td class=xl75305 style='border-top:none;text-align:center;'><?php echo $docketdetials_row['shade']; ?></td>
			<td class=xl75305 style='border-top:none;text-align:center;'><?php echo $docketdetials_row['reporting_plies']; ?></td>
			</tr>				
			<?php
		}?>
</table>
</div>
<br><br><br>
<div id="bundle_guide_305" align="left" x:publishsource="Excel">

<table border=0 cellpadding=0 cellspacing=0 width=902 style='border-collapse:
 collapse;table-layout:fixed;width:677pt'>
 <col width=64 span=8 style='width:48pt'>
 <col width=70 style='mso-width-source:userset;mso-width-alt:2503;width:53pt'>
 <col width=64 span=5 style='width:48pt'>

 <tr height=19 style='height:14.4pt'>
  <td height=19 class=xl15305 style='height:14.4pt'></td>
  <td colspan=2 rowspan=2 class=xl73305 style='background-color: gainsboro;'>RM Color Code</td>
  <td colspan=3 rowspan=2 class=xl73305 style='background-color: gainsboro;'>Color</td>
  <td rowspan=2 class=xl73305 style='background-color: gainsboro;'>Size</td>
  <td rowspan=2 class=xl73305 style='background-color: gainsboro;'>Bundle No</td>
  <td rowspan=2 class=xl74305 width=70 style='width:53pt;background-color: gainsboro;'>Shade Bundle No</td>
  <td rowspan=2 class=xl73305 style='background-color: gainsboro;'>Shade</td>
  <td rowspan=2 class=xl74305 width=64 style='width:48pt;background-color: gainsboro;' >Bundle Start No</td>
  <td rowspan=2 class=xl74305 width=64 style='width:48pt;background-color: gainsboro;' >Bundle End No</td>
  <td rowspan=2 class=xl73305 style='background-color: gainsboro;'>Qty</td>
  <td class=xl15305></td>
 </tr>
 <tr height=26 style='mso-height-source:userset;height:19.2pt'>
  <td height=26 class=xl15305 style='height:19.2pt'></td>
  <td class=xl15305></td>
 </tr>
 
 <tr height=19 style='height:14.4pt'>  
	<?php
	//	var_dump($bundle_no);
	$bundle=0;
	for($i=0;$i<sizeof($bundle_no);$i++)
	{	
		$getdetails21="SELECT shade_bundle,bundle_start,bundle_end,shade,sum(qty) as qty FROM $bai_pro3.docket_number_info where doc_no=".$doc_no." and bundle_no=".$bundle_no[$i]." group by id order by id";
		$getdetailsresult1 = mysqli_query($link,$getdetails21);
		while($sql_row1=mysqli_fetch_array($getdetailsresult1))
		{			
			?>
			<td height=19 class=xl15305 style='height:14.4pt'></td>
			<td colspan=2 class=xl75305><?php echo $compo_no; ?></td>
			<td colspan=3 class=xl75305 style='border-left:none'><?php echo $color; ?></td>	
			<?php
			if($bundle==$bundle_no[$i])
			{				
			?>
				<td class=xl75305 style='border-top:none;border-left:none'></td>
				<td class=xl75305 style='border-top:none;border-left:none'></td>
			<?php		
			}
			else
			{	
			?>
				<td class=xl75305 style='border-top:none;border-left:none'><?php echo $size[$i]; ?></td>
				<td class=xl75305 style='border-top:none;border-left:none'><?php echo $bundle_no[$i]; ?></td>
			<?php	
			}	
			?>
			<td class=xl75305 style='border-top:none;border-left:none'><?php echo $sql_row1['shade_bundle']; ?></td>			
			<td class=xl75305 style='border-top:none;border-left:none'><?php echo $sql_row1['shade']; ?></td>
			<td class=xl75305 style='border-top:none;border-left:none'><?php echo $sql_row1['bundle_start']; ?></td>
			<td class=xl75305 style='border-top:none;border-left:none'><?php echo $sql_row1['bundle_end']; ?></td>
			<td class=xl75305 style='border-top:none;border-left:none'><?php echo $sql_row1['qty']; ?></td>
			<td class=xl15305></td>
			</tr>				
			<?php
			$bundle=$bundle_no[$i];
		}
	}
	?>
  
 
 <tr height=19 style='height:14.4pt'>
  <td height=19 class=xl15305 style='height:14.4pt'></td>
  <td class=xl15305></td>
  <td class=xl15305></td>
  <td class=xl15305></td>
  <td class=xl15305></td>
  <td class=xl15305></td>
  <td class=xl15305></td>
  <td class=xl15305></td>
  <td class=xl15305></td>
  <td class=xl15305></td>
  <td class=xl15305></td>
  <td class=xl15305></td>
  <td class=xl15305></td>
  <td class=xl15305></td>
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
  <td width=70 style='width:53pt'></td>
  <td width=64 style='width:48pt'></td>
  <td width=64 style='width:48pt'></td>
  <td width=64 style='width:48pt'></td>
  <td width=64 style='width:48pt'></td>
  <td width=64 style='width:48pt'></td>
 </tr>
 <![endif]>
</table>

</div>


<!----------------------------->
<!--END OF OUTPUT FROM EXCEL PUBLISH AS WEB PAGE WIZARD-->
<!----------------------------->
</body>

</html>
