<?php
include($_SERVER['DOCUMENT_ROOT']."/sfcs_app/common/config/config.php");
//$style=$_POST['style'];
$mini_order_ref=$_GET['min_ref'];
$mini_order_num=$_GET['min_num'];
//$mini_order_ref=843;
//$mini_order_num=15;
$style = $_GET['style'];
$schedule = $_GET['sch'];

$sql="select * from $brandix_bts.tbl_min_ord_ref where id='".$mini_order_ref."'";
$sql_result=mysqli_query($link, $sql) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row=mysqli_fetch_array($sql_result))
{
	$style_id=$sql_row['ref_product_style'];
	$sch_id=$sql_row['ref_crt_schedule'];
}

$c_block = echo_title("$bai_pro3.bai_orders_db_confirm","zfeature","order_del_no",$schedule,$link);
$doc_no = echo_title("$brandix_bts.tbl_miniorder_data","docket_number","mini_order_num=$mini_order_num and mini_order_ref",$mini_order_ref,$link);
$buyer_div = echo_title("$bai_pro3.bai_orders_db_confirm","order_div","order_del_no",$schedule,$link);
$quantity = echo_title("$brandix_bts.tbl_miniorder_data","sum(quantity)","mini_order_num=".$mini_order_num." and mini_order_ref",$mini_order_ref,$link);
$location = echo_title("$bai_pro3.act_cut_status","bundle_loc","doc_no",$doc_no,$link);

?>

<html xmlns:o="urn:schemas-microsoft-com:office:office"
xmlns:x="urn:schemas-microsoft-com:office:excel"
xmlns="http://www.w3.org/TR/REC-html40">

<head>
<meta http-equiv=Content-Type content="text/html; charset=windows-1252">
<meta name=ProgId content=Excel.Sheet>
<meta name=Generator content="Microsoft Excel 15">
<link rel=File-List href="check_list_v5_files/filelist.xml">
<style id="Book1_9295_Styles">
<!--table
	{mso-displayed-decimal-separator:"\.";
	mso-displayed-thousand-separator:"\,";}
.xl159295
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
.xl639295
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
.xl649295
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:20.0pt;
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
.xl659295
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
.xl669295
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
.xl679295
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
.xl689295
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
	border-top:.5pt solid windowtext;
	border-right:none;
	border-bottom:.5pt solid windowtext;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl699295
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
	border-top:.5pt solid windowtext;
	border-right:none;
	border-bottom:.5pt solid windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl709295
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
	border-top:.5pt solid windowtext;
	border-right:.5pt solid windowtext;
	border-bottom:.5pt solid windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl719295
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
	vertical-align:top;
	border-top:.5pt solid windowtext;
	border-right:none;
	border-bottom:.5pt solid windowtext;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl729295
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
	vertical-align:top;
	border-top:.5pt solid windowtext;
	border-right:.5pt solid windowtext;
	border-bottom:.5pt solid windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
-->
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
<!--[if !excel]>&nbsp;&nbsp;<![endif]-->
<!--The following information was generated by Microsoft Excel's Publish as Web
Page wizard.-->
<!--If the same item is republished from Excel, all information between the DIV
tags will be replaced.-->
<!----------------------------->
<!--START OF OUTPUT FROM EXCEL PUBLISH AS WEB PAGE WIZARD -->
<!----------------------------->

<div id="Book1_9295" align=center x:publishsource="Excel">

<table border=0 cellpadding=0 cellspacing=0 width=926 style='border-collapse:
 collapse;table-layout:fixed;width:695pt'>
 <col width=25 style='mso-width-source:userset;mso-width-alt:914;width:19pt'>
 <col width=41 style='mso-width-source:userset;mso-width-alt:1499;width:31pt'>
 <col width=75 style='mso-width-source:userset;mso-width-alt:2742;width:56pt'>
 <col width=64 span=2 style='width:48pt'>
 <col width=60 style='mso-width-source:userset;mso-width-alt:2194;width:45pt'>
 <col width=64 style='width:48pt'>
 <col width=48 style='mso-width-source:userset;mso-width-alt:1755;width:36pt'>
 <col width=74 style='mso-width-source:userset;mso-width-alt:2706;width:56pt'>
 <col width=64 span=6 style='width:48pt'>
 <col width=27 style='mso-width-source:userset;mso-width-alt:987;width:20pt'>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl159295 width=25 style='height:15.0pt;width:19pt'></td>
  <td class=xl159295 width=41 style='width:31pt'></td>
  <td class=xl159295 width=75 style='width:56pt'></td>
  <td class=xl159295 width=64 style='width:48pt'></td>
  <td class=xl159295 width=64 style='width:48pt'></td>
  <td class=xl159295 width=60 style='width:45pt'></td>
  <td class=xl159295 width=64 style='width:48pt'></td>
  <td class=xl159295 width=48 style='width:36pt'></td>
  <td class=xl159295 width=74 style='width:56pt'></td>
  <td class=xl159295 width=64 style='width:48pt'></td>
  <td class=xl159295 width=64 style='width:48pt'></td>
  <td class=xl159295 width=64 style='width:48pt'></td>
  <td class=xl159295 width=64 style='width:48pt'></td>
  <td class=xl159295 width=64 style='width:48pt'></td>
  <td class=xl159295 width=64 style='width:48pt'></td>
  <td class=xl159295 width=27 style='width:20pt'></td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl159295 style='height:15.0pt'></td>
  <td colspan=14 rowspan=2 class=xl649295>Ticket Check List<span
  style='mso-spacerun:yes'> </span></td>
  <td class=xl159295></td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl159295 style='height:15.0pt'></td>
  <td class=xl159295></td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl159295 style='height:15.0pt'></td>
  <td class=xl159295></td>
  <td class=xl159295></td>
  <td class=xl159295></td>
  <td class=xl159295></td>
  <td class=xl159295></td>
  <td class=xl159295></td>
  <td class=xl159295></td>
  <td class=xl159295></td>
  <td class=xl159295></td>
  <td class=xl159295></td>
  <td class=xl159295></td>
  <td class=xl159295></td>
  <td class=xl159295></td>
  <td class=xl159295></td>
  <td class=xl159295></td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl159295 style='height:15.0pt'></td>
  <td colspan=2 class=xl679295>Style</td>
  <td colspan=2 class=xl659295 style='border-left:none'><?php echo $style;?></td>
  <td class=xl159295></td>
  <td colspan=2 class=xl679295>User name</td>
  <td colspan=7 class=xl659295 style='border-left:none'><?php echo strtoupper($username);?></td>
  <td class=xl159295></td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl159295 style='height:15.0pt'></td>
  <td colspan=2 class=xl679295>Schedule</td>
  <td colspan=2 class=xl659295 style='border-left:none'><?php echo $schedule;?></td>
  <td class=xl159295></td>
  <td colspan=2 class=xl679295>Date / Location</td>
  <td colspan=7 class=xl659295 style='border-left:none'><?php echo date("Y-m-d")." / ".$location ;?></td>
  <td class=xl159295></td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl159295 style='height:15.0pt'></td>
  <td colspan=2 class=xl679295>Miniorder/Docket </td>
  <td colspan=2 class=xl659295 style='border-left:none'><?php echo $mini_order_num." /  ".$doc_no;?></td>
  <td class=xl159295></td>
  <td colspan=2 class=xl719295 style='border-right:.5pt solid black'>Product
  Category</td>
  <td colspan=7 class=xl659295 style='border-left:none'><?php echo $buyer_div;?></td>
  <td class=xl159295></td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl159295 style='height:15.0pt'></td>
  <td class=xl159295></td>
  <td class=xl159295></td>
  <td class=xl159295></td>
  <td class=xl159295></td>
  <td class=xl159295></td>
  <td class=xl159295></td>
  <td class=xl159295></td>
  <td class=xl159295></td>
  <td class=xl159295></td>
  <td class=xl159295></td>
  <td class=xl159295></td>
  <td class=xl159295></td>
  <td class=xl159295></td>
  <td class=xl159295></td>
  <td class=xl159295></td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl159295 style='height:15.0pt'></td>
  <td class=xl669295>Sno</td>
  <td colspan=3 class=xl669295 style='border-left:none'>Color Code</td>
  <td class=xl669295 style='border-left:none'>Size</td>
  <td class=xl669295 style='border-left:none'>Quantity</td>
  <td class=xl669295 style='border-left:none'>Count</td>
  <td colspan=7 class=xl669295 style='border-left:none'>Bundle Numbers</td>
  <td class=xl159295></td>
 </tr>
  <?php
 $i=1;$tot_cnt=0;$tot_qty=0;
$sql2="SELECT color,size,count(*) as cnt,sum(quantity) as qty from $brandix_bts.tbl_miniorder_data where mini_order_ref='".$mini_order_ref."' and mini_order_num=".$mini_order_num." group by color,size";

$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row2=mysqli_fetch_array($sql_result2))
{
	$size_tie = echo_title("$brandix_bts.tbl_orders_sizes_master","size_title","order_col_des='".$sql_row2['color']."' and parent_id='".$sch_id."' and ref_size_name",$sql_row2['size'],$link);
	$tot_cnt+=$sql_row2['cnt'];
	$tot_qty+=$sql_row2['qty'];
	$rows_s=ceil($sql_row2['cnt']/6);
	
?>
 <tr height=17 style='mso-height-source:userset;height:12.75pt'>
  <td height=17 class=xl159295 style='height:12.75pt'></td>
  <td rowspan=<?php echo $rows_s;?> class=xl639295 style='border-top:none'><?php echo $i;?></td>
  <td rowspan=<?php echo $rows_s;?> colspan=3 class=xl659295 style='border-left:none'><?php echo $sql_row2['color'];?></td>
  <td rowspan=<?php echo $rows_s;?> class=xl639295 style='border-top:none;border-left:none'><?php echo $size_tie;?></td>
  <td rowspan=<?php echo $rows_s;?> class=xl639295 style='border-top:none;border-left:none'><?php echo $sql_row2['qty'];?></td>
  <td rowspan=<?php echo $rows_s;?> class=xl639295 style='border-top:none;border-left:none'><?php echo $sql_row2['cnt'];?></td>
  <td  colspan=7 class=xl689295 style='border-right:.5pt solid black;border-left:
  none'>
  <?php	
	$rows=1;$row=1;
	$sql21="SELECT * from $brandix_bts.tbl_miniorder_data where mini_order_ref='".$mini_order_ref."' and mini_order_num=".$mini_order_num." and color='".$sql_row2['color']."' and size='".$sql_row2['size']."' group by bundle_number order by bundle_number";
	//echo $sql2."<br>";
	$sql_result21=mysqli_query($link, $sql21) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row21=mysqli_fetch_array($sql_result21))
	{
		if($sql_row2['cnt']==$row)
		{
			if($rows==1)
			{
				echo ",".$sql_row21['bundle_number']."-".$sql_row21['quantity'];
			}
			else
			{
				echo $sql_row21['bundle_number']."-".$sql_row21['quantity'];
			}	
			
		}
		else if($rows==6)
		{
			$rows=0;
			echo $sql_row21['bundle_number']."-".$sql_row21['quantity'];
			echo "</td>
			<td class=xl159295></td></tr>
			<tr height=17 style='mso-height-source:userset;height:12.75pt'><td height=17 class=xl159295 style='height:12.75pt'></td>
			<td  colspan=7 class=xl689295 style='border-right:.5pt solid black;border-left:none'>";
			
			$rows++;$row++;
		}
		else
		{	
			echo $sql_row21['bundle_number']."-".$sql_row21['quantity'].",";
			$rows++;$row++;
		}
		
	}
	$i++;
	$rows_s=0;
}

 ?>
  </td>
  <td class=xl159295></td>
 </tr>
 
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl159295 style='height:15.0pt'></td>
  <td colspan=5 class=xl659295>Total Quantity</td>
  <td class=xl639295 align=right style='border-top:none;border-left:none'><?php echo $tot_qty; ?></td>
  <td class=xl639295 align=right style='border-top:none;border-left:none'><?php echo $tot_cnt; ?></td>
  <td colspan=7 class=xl689295 style='border-right:.5pt solid black;border-left:
  none'>&nbsp;</td>
  <td class=xl159295></td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl159295 style='height:15.0pt'></td>
  <td class=xl159295></td>
  <td class=xl159295></td>
  <td class=xl159295></td>
  <td class=xl159295></td>
  <td class=xl159295></td>
  <td class=xl159295></td>
  <td class=xl159295></td>
  <td class=xl159295></td>
  <td class=xl159295></td>
  <td class=xl159295></td>
  <td class=xl159295></td>
  <td class=xl159295></td>
  <td class=xl159295></td>
  <td class=xl159295></td>
  <td class=xl159295></td>
 </tr>
 <![if supportMisalignedColumns]>
 <tr height=0 style='display:none'>
  <td width=25 style='width:19pt'></td>
  <td width=41 style='width:31pt'></td>
  <td width=75 style='width:56pt'></td>
  <td width=64 style='width:48pt'></td>
  <td width=64 style='width:48pt'></td>
  <td width=60 style='width:45pt'></td>
  <td width=64 style='width:48pt'></td>
  <td width=48 style='width:36pt'></td>
  <td width=74 style='width:56pt'></td>
  <td width=64 style='width:48pt'></td>
  <td width=64 style='width:48pt'></td>
  <td width=64 style='width:48pt'></td>
  <td width=64 style='width:48pt'></td>
  <td width=64 style='width:48pt'></td>
  <td width=64 style='width:48pt'></td>
  <td width=27 style='width:20pt'></td>
 </tr>
 <![endif]>
</table>

</div>


<!----------------------------->
<!--END OF OUTPUT FROM EXCEL PUBLISH AS WEB PAGE WIZARD-->
<!----------------------------->
</body>

</html>
