<?php
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config_ajax.php');
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/functions.php');
$doc_no=$_GET['doc_no'];
$style=$_GET['style'];
$schedule=$_GET['schedule'];
$color=$_GET['color'];
$mpo=$_GET['mpo'];
$ponum=$_GET['ponum'];
$cut_number_get=$_GET['cut_number'];
$plant_code=$_GET['plant_code'];

//getting cut number based on po number
$get_cut_number_qry="SELECT cut_number,jm_cut_job_id FROM $pps.`jm_cut_job` WHERE po_number='$ponum' AND plant_code='$plant_code'";
$get_cut_number_qry_result=mysqli_query($link, $get_cut_number_qry) or exit("Sql Error while getting cutno".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row_cut=mysqli_fetch_array($get_cut_number_qry_result))
{
	$cut_number=$sql_row_cut['cut_number'];
	$jm_cut_job_id=$sql_row_cut['jm_cut_job_id'];
	
	//getting docket id
	$get_docid_qry="SELECT jm_docket_id FROM $pps.`jm_dockets` WHERE plant_code='$plant_code' AND jm_cut_job_id='$jm_cut_job_id'";
	$get_docid_qry_result=mysqli_query($link, $get_docid_qry) or exit("Sql Error while getting docket id".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row_docid=mysqli_fetch_array($get_docid_qry_result))
	{
		$jm_docket_id=$sql_row_docid['jm_docket_id'];
		
		//getting jm docket line id
		$get_docline_qry="SELECT jm_docket_line_id FROM $pps.`jm_docket_lines` WHERE plant_code='$plant_code' AND jm_docket_id='$jm_docket_id'";
		$get_docline_qry_result=mysqli_query($link, $get_docline_qry) or exit("Sql Error while getting doclineid".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row_doclineid=mysqli_fetch_array($get_docline_qry_result))
		{
			$jm_docket_line_id=$sql_row_doclineid['jm_docket_line_id'];
			
			//getting details from jm_docket_cg_bundle
			$get_det_qry="SELECT size FROM $pps.`jm_docket_cg_bundle` WHERE plant_code='$plant_code' AND jm_docket_line_id='$jm_docket_line_id'";
			$get_det_qry_result=mysqli_query($link, $get_det_qry) or exit("Sql Error while getting details".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row_det=mysqli_fetch_array($get_det_qry_result))
			{
				$sizesarr[]=$sql_row_det['size'];
			}
		}
	}
}

$get_doclinenum_qry="SELECT jm_docket_line_id FROM $pps.`jm_docket_lines` WHERE docket_line_number='$doc_no' AND plant_code='$plant_code'";
$get_doclinenum_qry_result=mysqli_query($link, $get_doclinenum_qry) or exit("Sql Error while getting cutno".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row_jmline=mysqli_fetch_array($get_doclinenum_qry_result))
{
	$jm_docket_line_id=$sql_row_jmline['jm_docket_line_id'];
	
	$get_bundle_no="SELECT dcgb_number FROM $pps.`jm_docket_cg_bundle` WHERE jm_docket_line_id='$jm_docket_line_id' AND plant_code='$plant_code'";
	$get_bundle_no_result=mysqli_query($link, $get_bundle_no) or exit("Sql Error while getting cutno".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row_bunno=mysqli_fetch_array($get_bundle_no_result))
	{
		$bundle_no[] = $sql_row_bunno['dcgb_number'];
	}
}

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
	.xl654118
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:"Trebuchet MS", sans-serif;
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
	width: 60;
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
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:9.0pt;
	font-weight:400;
	width: 120;
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
	/* .xl73305b
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
	border:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;} */
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
  <td colspan=3 class=xl68305><?php echo $style;?></td>
  <td colspan=2 class=xl69305>Cut Number:</td>
  <td colspan=2 class=xl68305><?php echo $cut_number_get;?></td>
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

<?php
$temp = 0;
$temp_len1 = 0;
$temp_len = 0;
$divide=10;

for($j=0;$j<sizeof(array_unique($sizesarr));$j++)
{
	if($temp == 0){
	echo "<table border=0 cellpadding=0 cellspacing=0 width=300 style='border-collapse:collapse;table-layout:fixed;'><tr style='margin-top:5pt;'>";
        echo "<td class=xl73305a style='background-color: gainsboro;'>Size</td>";
        $temp = 1;
    }
    echo  "<td class=xl73305a style='background-color: gainsboro;'>".$sizesarr[$j]."</td>";
    // if(($j+1) % $divide == 0){
        $temp_len = $j+1;
        echo "</tr>";
        echo "<tr>
            <td class=xl73305a>Quantity</td>";
        	for($i=$temp_len1;$i<$temp_len;$i++) 
			{
				$get_doclinenum_qry="SELECT jm_docket_line_id FROM $pps.`jm_docket_lines` WHERE docket_line_number='$doc_no' AND plant_code='$plant_code'";
				$get_doclinenum_qry_result=mysqli_query($link, $get_doclinenum_qry) or exit("Sql Error while getting cutno".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($sql_row_jmline=mysqli_fetch_array($get_doclinenum_qry_result))
				{
					$jm_docket_line_id=$sql_row_jmline['jm_docket_line_id'];
					
					$get_bundle_no="SELECT sum(quantity) as quantity FROM $pps.`jm_docket_cg_bundle` WHERE jm_docket_line_id='$jm_docket_line_id' AND plant_code='$plant_code' and size='".$sizesarr[$j]."'";
					$get_bundle_no_result=mysqli_query($link, $get_bundle_no) or exit("Sql Error while getting cutno".mysqli_error($GLOBALS["___mysqli_ston"]));
					while($sql_row_bunno=mysqli_fetch_array($get_bundle_no_result))
					{
						$quantity = $sql_row_bunno['quantity'];
					}
				}
                echo "<td class=xl73305a style='border-top:none;text-align:center;'>".$quantity."</td>";
			}
        echo "</tr>";
        $temp = 0;
        $temp_len1=$temp_len;
    // }
	echo "</table><br/>";
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
/* while($sql_row=mysqli_fetch_array($sql_result1))
	{
	for($s=0;$s<sizeof($s_tit);$s++)
	{
	   // $code="p_s".$sizes_code[$s];
		//echo "<th>".$s_tit[$sizes_code[$s]]."</th>";
		echo "<td class=xl75305 style='border-top:none;text-align:center;'>".$sql_row["p_s".$sizes_code[$s].""]."</td>";
	}
		echo "<td class=xl75305 style='border-top:none;text-align:center;'>".$totalpliesresult['totalplies']."</td>";
	} */
?>
</tr>
</table>
</div>
<br><br>

<br><br><br>
<div id="bundle_guide_305" align="left" x:publishsource="Excel">

<table border=0 cellpadding=0 cellspacing=0 width=902 style='border-collapse:
 collapse;table-layout:fixed;width:677pt'>
 <col width=64 span=8 style='width:48pt'>
 <col width=70 style='mso-width-source:userset;mso-width-alt:2503;width:53pt'>
 <col width=64 span=5 style='width:48pt'>

 <tr height=19 style='height:14.4pt'>
  <td height=19 class=xl15305 style='height:14.4pt'></td>
  <td colspan=3 rowspan=2 class=xl73305 style='background-color: gainsboro;'>Color</td>
  <!---<td colspan=3 rowspan=2 class=xl73305 style='background-color: gainsboro;'>Color</td>--->
  <td rowspan=2 class=xl73305 style='background-color: gainsboro;'>Size</td>
  <td rowspan=2 class=xl73305 style='background-color: gainsboro;'>Bundle No</td>
  <!---<td rowspan=2 class=xl74305 width=70 style='width:53pt;background-color: gainsboro;'>Shade Bundle No</td>
  <td rowspan=2 class=xl73305 style='background-color: gainsboro;'>Shade</td>--->
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
	$bundlestart=1;
	for($i=0;$i<sizeof($bundle_no);$i++)
	{	
		$getdetails21="SELECT dcgb_number,fg_color,size,quantity,org_db_number from $pps.jm_docket_cg_bundle where dcgb_number='".$bundle_no[$i]."' and plant_code='$plant_code'";
		$getdetailsresult1 = mysqli_query($link,$getdetails21);
		while($sql_row1=mysqli_fetch_array($getdetailsresult1))
		{	
			$bundleend=($bundlestart+$sql_row1['quantity'])-1;
			?>
			<td height=19 class=xl15305 style='height:14.4pt'></td>
			<td colspan=3 class=xl75305><?php echo $color; ?></td>
			<!---<td colspan=3 class=xl75305 style='border-left:none'><?php echo $color; ?></td>--->	
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
				<td class=xl75305 style='border-top:none;border-left:none'><?php echo $sql_row1['size']; ?></td>
				<td class=xl75305 style='border-top:none;border-left:none'><?php echo $bundle_no[$i]; ?></td>
			<?php	
			}	
			?>
			<!---<td class=xl75305 style='border-top:none;border-left:none'><?php echo $sql_row1['shade_bundle']; ?></td>			
			<td class=xl75305 style='border-top:none;border-left:none'><?php echo $sql_row1['shade']; ?></td>--->
			<td class=xl75305 style='border-top:none;border-left:none'><?php echo $bundlestart; ?></td>
			<td class=xl75305 style='border-top:none;border-left:none'><?php echo $bundleend; ?></td>
			<td class=xl75305 style='border-top:none;border-left:none'><?php echo $sql_row1['quantity']; ?></td>
			<td class=xl15305></td>
			</tr>				
			<?php
			$bundlestart=$bundleend+1;
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
