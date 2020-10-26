
<style>
@media print {
    @page { margin: 0; }
@page narrow {size: 9in 11in}
@page rotated {size: portrait;}
DIV {page: narrow}
TABLE {page: rotated}
#non-printable { display: none; }
#printable { display: block; }
#logo { display: block; }
body { zoom:72%;}
#ad{ display:none;}
#leftbar{ display:none;}
#CUT_PLAN_NEW_13019{ width:57%; margin-left:20px;}
}

</style>
<?php
include('../../../common/config/config.php');
// $plant_code = $_SESSION['plantCode'];
// $username = $_SESSION['userName'];
$inpsect_id=$_GET['parent_id'];
$plant_code=$_GET['plant_code'];
$username=$_GET['username'];
$get_details21 = "select * from $wms.`inspection_population` where parent_id=".$inpsect_id." and plant_code='".$plant_code."'";
$details_result21 = mysqli_query($link, $get_details21) or exit("get_details Error1" . mysqli_error($GLOBALS["___mysqli_ston"]));
$tot_rolls_data=mysqli_num_rows($details_result21);

$get_inspection_population_info = "select store_in_tid,inspected_per,inspected_qty,width_s,width_m,width_e,actual_height,actual_repeat_height,skw,bow,ver,gsm,comment,marker_type,inspection_status from $wms.`roll_inspection_child` where parent_id=".$inpsect_id." and plant_code='".$plant_code."'";
$info_result = mysqli_query($link, $get_inspection_population_info) or exit("get_details Error2" . mysqli_error($GLOBALS["___mysqli_ston"]));
while ($row22 = mysqli_fetch_array($info_result)) 
{
	$inspected_per[$row22['store_in_tid']] = $row22['inspected_per'];
	$inspected_qty[$row22['store_in_tid']] = $row22['inspected_qty'];
	$width_s[$row22['store_in_tid']] = $row22['width_s'];
	$width_m[$row22['store_in_tid']] = $row22['width_m'];
	$width_e[$row22['store_in_tid']] = $row22['width_e'];
    $actual_height[$row22['store_in_tid']] = $row22['actual_height'];
	$actual_repeat_height[$row22['store_in_tid']] = $row22['actual_repeat_height'];
	$skw[$row22['store_in_tid']] = $row22['skw'];
	$bow[$row22['store_in_tid']] = $row22['bow'];
	$ver[$row22['store_in_tid']] = $row22['ver'];
	$gsm[$row22['store_in_tid']] = $row22['gsm'];
	$comment[$row22['store_in_tid']] = $row22['comment'];
	$marker_type[$row22['store_in_tid']] = $row22['marker_type'];
	$inspection_status[$row22['store_in_tid']] = $row22['inspection_status'];
	$tot_ids[]=	$row22['store_in_tid'];
}

$get_details = "select supplier_invoice,store_in_id,supplier_batch,supplier_po,item_code,item_desc,item_name,rm_color,sfcs_roll_no,supplier_roll_no,lot_no,rec_qty,lot_no,status from $wms.`inspection_population` where store_in_id in (".implode(",",$tot_ids).") and plant_code='".$plant_code."'";
//echo $get_details;
$details_result = mysqli_query($link, $get_details) or exit("get_details Error1" . mysqli_error($GLOBALS["___mysqli_ston"]));
while ($row1 = mysqli_fetch_array($details_result))
{
	$invoice = $row1['supplier_invoice'];
	$batch[$row1['store_in_id']] = $row1['supplier_batch'];
	$po = $row1['supplier_po'];
	$item_code = $row1['item_code'];
	$item_desc = $row1['item_desc'];
	$item_name = $row1['item_name'];
	$color = $row1['rm_color'];
	$sfcs_roll[$row1['store_in_id']] = $row1['sfcs_roll_no'];
	$supp_roll[$row1['store_in_id']] = $row1['supplier_roll_no'];
	$lot_no = $row1['lot_no'];
	$invoice_qty[$row1['store_in_id']] = $row1['rec_qty'];	
	$store_in_id = $row1['store_in_id'];
	$lots_no[] = $row1['lot_no'];	
	if($row1['status']==1)
	{
		$status='Pending';
	}
	elseif($row1['status']==2)
	{
		$status='In Progress';
	}

}



$get_details1 = "select fab_composition,s_width,repeat_len,s_weight,lab_testing,tolerence,supplier,remarks from $wms.`main_population_tbl` where id=$inpsect_id and plant_code='".$plant_code."'";
$details_result1 = mysqli_query($link, $get_details1) or exit("get_details Error3" . mysqli_error($GLOBALS["___mysqli_ston"]));
while ($row111 = mysqli_fetch_array($details_result1)) 
{
	$fabric_composition = $row111['fab_composition'];
	$spec_width = $row111['s_width'];	
	$repeat_length = $row111['repeat_len'];
	$spec_weight = $row111['s_weight'];
	$lab_testing = $row111['lab_testing'];
	$tolerance = $row111['tolerence'];
	$po_no = $row111['supplier'];
	$remarks = $row111['remarks'];
}
 $lot_ref = implode(",",$lots_no);
 $get_details12 = "select style_no,supplier,po_no,rm_color,inv_no,item_desc,buyer,rec_no from $wms.`sticker_report` where lot_no in ("."'".str_replace(",","','",$lot_ref)."'".") and plant_code='".$plant_code."'";
//echo $get_details12;
$details_result12 = mysqli_query($link, $get_details12) or exit("get_details Error3" . mysqli_error($GLOBALS["___mysqli_ston"]));
while ($row1112 = mysqli_fetch_array($details_result12)) 
{
	$style = $row1112['style_no'];
	$supplier = $row1112['supplier'];
	$grn_no = $row1112['po_no'];
	$color = $row1112['rm_color'];
	$invoice_no = $row1112['inv_no'];
	$fab_qua = $row1112['item_desc'];	
	$buyer = $row1112['buyer'];
	$grn_no = $row1112['rec_no'];
}
$tot_points=0;
$cnt=0;
$get_inspection_population_info12 = "select insp_child_id,selected_point,SUM(points) AS tot from $wms.`four_points_table` where insp_child_id in (".implode(",",$tot_ids).") and plant_code='".$plant_code."' group by insp_child_id,selected_point";
$info_result12 = mysqli_query($link, $get_inspection_population_info12) or exit("get_details Error2" . mysqli_error($GLOBALS["___mysqli_ston"]));
if(mysqli_num_rows($info_result12)>0)
{
	while ($row2212 = mysqli_fetch_array($info_result12)) 
	{
		$cnt=$row2212['tot']/$row2212['selected_point'];
		$ins_child_count[$row2212['insp_child_id']][$row2212['selected_point']] = $cnt;
		$ins_child[$row2212['insp_child_id']][$row2212['selected_point']] = $row2212['tot'];
		$tot_points=$row2212['tot']+$tot_points;
	}
}

foreach($width_s as $key=>$val ) 
{
    $min[] = min($width_s[$key],$width_m[$key],$width_e[$key]);
}
  $minVal = $min[0];
  foreach($min as $key => $val) 
  {
  	if($minVal > $val) {
  		$minVal = $val;
  	}
  }
  $inch_value=round($minVal/(2.54),2);
	
?>


<html xmlns:o="urn:schemas-microsoft-com:office:office"
xmlns:x="urn:schemas-microsoft-com:office:excel"
xmlns="http://www.w3.org/TR/REC-html40">

<head>
<meta http-equiv=Content-Type content="text/html; charset=windows-1252">
<meta name=ProgId content=Excel.Sheet>
<meta name=Generator content="Microsoft Excel 15">
<link rel=File-List href="4_point_inspection_report_files/filelist.xml">
<style id="digital_report_19758_Styles">
<!--table
	{mso-displayed-decimal-separator:"\.";
	mso-displayed-thousand-separator:"\,";}
.font019758
	{color:black;
	font-size:11.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;}
.font519758
	{color:black;
	font-size:11.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:underline;
	text-underline-style:single;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;}
.xl1519758
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
.xl6319758
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
	border-top:none;
	border-right:none;
	border-bottom:.5pt solid windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl6419758
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
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl6519758
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:11.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:underline;
	text-underline-style:single;
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
.xl6619758
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:11.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:"Arial Black", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:bottom;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl6719758
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:11.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:"Arial Black", sans-serif;
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
.xl6819758
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
.xl6919758
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
	border-top:.5pt solid windowtext;
	border-right:none;
	border-bottom:none;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl7019758
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
.xl7119758
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
.xl7219758
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
.xl7319758
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
.xl7419758
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
.xl7519758
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
	border-bottom:none;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl7619758
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
	border-top:none;
	border-right:none;
	border-bottom:.5pt solid windowtext;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl7719758
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
	border-bottom:.5pt solid windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl7819758
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
	border-top:.5pt solid windowtext;
	border-right:none;
	border-bottom:none;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl7919758
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
	border-top:none;
	border-right:none;
	border-bottom:none;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl8019758
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
	border-top:none;
	border-right:none;
	border-bottom:.5pt solid windowtext;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl8119758
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
	border-top:none;
	border-right:none;
	border-bottom:.5pt solid windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl8219758
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
	border-top:.5pt solid windowtext;
	border-right:none;
	border-bottom:.5pt solid windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl8319758
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
	border-bottom:none;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl8419758
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
	border-top:none;
	border-right:.5pt solid windowtext;
	border-bottom:.5pt solid windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl8519758
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
	border-bottom:none;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:normal;}
.xl8619758
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
	border-top:none;
	border-right:.5pt solid windowtext;
	border-bottom:.5pt solid windowtext;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:normal;}
.xl8719758
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
	white-space:normal;}
.xl8819758
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
	white-space:normal;}
.xl8919758
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
.xl9019758
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
	border-top:.5pt solid windowtext;
	border-right:none;
	border-bottom:.5pt solid windowtext;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl9119758
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
	border-top:.5pt solid windowtext;
	border-right:.5pt solid windowtext;
	border-bottom:.5pt solid windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl9219758
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
	mso-number-format:Fixed;
	text-align:left;
	vertical-align:top;
	border:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl9319758
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
	white-space:normal;}
.xl9419758
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
	mso-number-format:Fixed;
	text-align:left;
	vertical-align:top;
	border-top:.5pt solid windowtext;
	border-right:none;
	border-bottom:.5pt solid windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl9519758
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
	text-align:general;
	vertical-align:bottom;
	border-top:none;
	border-right:none;
	border-bottom:.5pt solid windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl9619758
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
	border-bottom:none;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl9719758
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
.xl9819758
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
	border-right:.5pt solid windowtext;
	border-bottom:none;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl9919758
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
.xl10019758
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
	border-right:.5pt solid windowtext;
	border-bottom:.5pt solid windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl10119758
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
	vertical-align:middle;
	border-top:.5pt solid windowtext;
	border-right:none;
	border-bottom:none;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl10219758
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
	vertical-align:middle;
	border-top:.5pt solid windowtext;
	border-right:none;
	border-bottom:none;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl10319758
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
	vertical-align:middle;
	border-top:.5pt solid windowtext;
	border-right:.5pt solid windowtext;
	border-bottom:none;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl10419758
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
	vertical-align:middle;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl10519758
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
	vertical-align:middle;
	border-top:none;
	border-right:.5pt solid windowtext;
	border-bottom:none;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl10619758
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
	vertical-align:middle;
	border-top:none;
	border-right:none;
	border-bottom:.5pt solid windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl10719758
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
	white-space:normal;}
.xl10819758
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
	white-space:normal;}
.xl10919758
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
	border-bottom:none;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:normal;}
.xl11019758
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
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:normal;}
.xl11119758
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
	vertical-align:middle;
	border-top:.5pt solid windowtext;
	border-right:none;
	border-bottom:.5pt solid windowtext;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl11219758
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
	vertical-align:middle;
	border-top:.5pt solid windowtext;
	border-right:none;
	border-bottom:.5pt solid windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl11319758
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
	vertical-align:middle;
	border-top:.5pt solid windowtext;
	border-right:.5pt solid windowtext;
	border-bottom:.5pt solid windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl11419758
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
	vertical-align:middle;
	border:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl11519758
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
	vertical-align:top;
	border-top:.5pt solid windowtext;
	border-right:none;
	border-bottom:.5pt solid windowtext;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl11619758
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
	vertical-align:top;
	border-top:.5pt solid windowtext;
	border-right:none;
	border-bottom:.5pt solid windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl11719758
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


<div id="digital_report_19758" align=center x:publishsource="Excel">

<table border=0 cellpadding=0 cellspacing=0 width=1298 style='border-collapse:
 collapse;table-layout:fixed;width:977pt'>
 <col width=55 style='mso-width-source:userset;mso-width-alt:1962;width:41pt'>
 <col width=78 style='mso-width-source:userset;mso-width-alt:2787;width:59pt'>
 <col width=64 style='width:48pt'>
 <col width=57 style='mso-width-source:userset;mso-width-alt:2019;width:43pt'>
 <col width=64 span=2 style='mso-width-source:userset;mso-width-alt:2275;
 width:48pt'>
 <col width=51 style='mso-width-source:userset;mso-width-alt:1820;width:38pt'>
 <col width=59 style='mso-width-source:userset;mso-width-alt:2104;width:44pt'>
 <col width=58 style='mso-width-source:userset;mso-width-alt:2076;width:44pt'>
 <col width=29 style='mso-width-source:userset;mso-width-alt:1024;width:22pt'>
 <col width=25 style='mso-width-source:userset;mso-width-alt:881;width:19pt'>
 <col width=29 style='mso-width-source:userset;mso-width-alt:1024;width:22pt'>
 <col width=26 style='mso-width-source:userset;mso-width-alt:910;width:19pt'>
 <col width=53 style='mso-width-source:userset;mso-width-alt:1877;width:40pt'>
 <col width=49 style='mso-width-source:userset;mso-width-alt:1735;width:37pt'>
 <col width=86 style='mso-width-source:userset;mso-width-alt:3072;width:65pt'>
 <col width=102 style='mso-width-source:userset;mso-width-alt:3640;width:77pt'>
 <col width=78 style='mso-width-source:userset;mso-width-alt:2787;width:59pt'>
 <col width=64 style='width:48pt'>
 <col width=69 style='mso-width-source:userset;mso-width-alt:2446;width:52pt'>
 <col width=74 style='mso-width-source:userset;mso-width-alt:2645;width:56pt'>
 <col width=64 style='width:48pt'>
 <tr height=18 style='mso-height-source:userset;height:13.8pt'>
  <td height=18 class=xl1519758 width=55 style='height:13.8pt;width:41pt'></td>
  <td class=xl1519758 width=78 style='width:59pt'></td>
  <td class=xl1519758 width=64 style='width:48pt'></td>
  <td class=xl1519758 width=57 style='width:43pt'></td>
  <td class=xl1519758 width=64 style='width:48pt'></td>
  <td class=xl1519758 width=64 style='width:48pt'></td>
  <td class=xl1519758 width=51 style='width:38pt'></td>
  <td class=xl1519758 width=59 style='width:44pt'></td>
  <td class=xl1519758 width=58 style='width:44pt'></td>
  <td class=xl1519758 width=29 style='width:22pt'></td>
  <td class=xl1519758 width=25 style='width:19pt'></td>
  <td class=xl1519758 width=29 style='width:22pt'></td>
  <td class=xl1519758 width=26 style='width:19pt'></td>
  <td class=xl1519758 width=53 style='width:40pt'></td>
  <td class=xl1519758 width=49 style='width:37pt'></td>
  <td class=xl1519758 width=86 style='width:65pt'></td>
  <td class=xl1519758 width=102 style='width:77pt'></td>
  <td class=xl1519758 width=78 style='width:59pt'></td>
  <td class=xl1519758 width=64 style='width:48pt'></td>
  <td class=xl1519758 width=69 style='width:52pt'></td>
  <td class=xl1519758 width=74 style='width:56pt'></td>
  <td class=xl1519758 width=64 style='width:48pt'></td>
 </tr>
 <tr height=18 style='mso-height-source:userset;height:13.8pt'>
  <td height=18 class=xl1519758 style='height:13.8pt'></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
 </tr>
 <tr height=18 style='mso-height-source:userset;height:13.8pt'>
  <td height=18 class=xl1519758 style='height:13.8pt'></td>
  <td colspan=12 class=xl6419758><?php echo $plant_head;?></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td colspan=2 class=xl7019758 style='border-right:.5pt solid black'><?php echo $inpsect_id;?></td>
  <td class=xl1519758></td>
 </tr>
 <tr height=19 style='height:14.4pt'>
  <td height=19 class=xl1519758 style='height:14.4pt'></td>
  <td colspan=11 class=xl6419758>Fabric Inspection Division</td>
  <td class=xl6419758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
 <!--  <td colspan=4 rowspan=2 class=xl6619758 style='border-bottom:.5pt solid black'>UN
  AUTHIORIZED COPY</td> -->
  <td colspan=4 rowspan=2 class=xl6619758 style='border-bottom:.5pt solid black'></td>
  <td class=xl1519758></td>
 </tr>
 <tr height=19 style='height:14.4pt'>
  <td height=19 class=xl1519758 style='height:14.4pt'></td>
  <td colspan=11 class=xl6519758>Material Inpsection Report</td>
  <td class=xl6419758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
 </tr>
 <tr height=19 style='height:14.4pt'>
  <td height=19 class=xl1519758 style='height:14.4pt'></td>
  <td class=xl7219758 style='border-top:none'>Date time</td>
  <td colspan=3 class=xl6919758>- <?php echo date("Y-m-d H:i:sa"); ?></td>
  <td class=xl6919758 style='border-top:none'>&nbsp;</td>
  <td class=xl6919758 style='border-top:none'>&nbsp;</td>
  <td class=xl6919758 colspan=2>Fabric Quality</td>
  <td class=xl8219758 style='font-size:9pt; border-top:none'>- <?php echo $fab_qua;?></td>
  <td class=xl8219758 style='border-top:none'>&nbsp;</td>
  <td class=xl8219758 style='border-top:none'>&nbsp;</td>
  <td class=xl8219758>&nbsp;</td>
  <td class=xl8219758>&nbsp;</td>
  <td class=xl6919758>&nbsp;</td>
  <td class=xl7219758>&nbsp;</td>
  <td class=xl7219758>&nbsp;</td>
  <td class=xl7219758 style='border-top:none'>&nbsp;</td>
  <td class=xl7219758 style='border-top:none'>&nbsp;</td>
  <td class=xl7219758 style='border-top:none'>&nbsp;</td>
  <td class=xl7219758 style='border-top:none'>&nbsp;</td>
  <td class=xl1519758></td>
 </tr>
 <tr height=19 style='height:14.4pt'>
  <td height=19 class=xl1519758 style='height:14.4pt'></td>
  <td class=xl1519758>OTT Date</td>
  <td colspan=3 class=xl6919758>- <?php echo ""; ?></td>
  <td class=xl6419758></td>
  <td class=xl6419758></td>
  <td class=xl6419758 colspan=2>Composition</td>
  <td class=xl8219758 style='font-size:9pt; border-top:none'>- <?php echo $fabric_composition;?></td>
  <td class=xl8219758 style='border-top:none'>&nbsp;</td>
  <td class=xl8219758 style='border-top:none'>&nbsp;</td>
  <td class=xl8219758 style='border-top:none'>&nbsp;</td>
  <td class=xl8219758 style='border-top:none'>&nbsp;</td>
  <td class=xl1519758></td>
  <td colspan=3 class=xl7319758>Spec Details</td>
  <td colspan=3 class=xl7119758>Inspection Summary</td>
  <td class=xl1519758></td>
 </tr>
 <tr height=19 style='height:14.4pt'>
  <td height=19 class=xl1519758 style='height:14.4pt'></td>
  <td class=xl1519758>Style No</td>
  <td colspan=3 class=xl6919758>- <?php echo $style;?></td>
  <td class=xl6419758></td>
  <td class=xl6419758></td>
  <td class=xl6419758>Supplier</td>
  <td class=xl6419758></td>
  <!-- <td class=xl8219758 style='border-top:none'>- <?php echo wordwrap($supplier,30,"<br>\n",TRUE);?></td> -->
  <td class=xl8219758 style='font-size:9pt;border-top:none' id='supplier_name'>- <?php echo substr($supplier,0,28);?></td>
  <td class=xl8219758 style='border-top:none'>&nbsp;</td>
  <td class=xl8219758 style='border-top:none'>&nbsp;</td> 
  <td class=xl8219758 style='border-top:none'>&nbsp;</td>
  <td class=xl8219758 style='border-top:none'>&nbsp;</td>
  <td class=xl1519758></td>
  <td colspan=2 class=xl7819758>Spec.Width(cm)</td>
  <td class=xl7719758 style='border-top:none;text-align:center;'><?php echo $spec_width;?></td>
  <td colspan=2 class=xl7919758 style='border-left:none'>Checked</td>
  <td class=xl7719758 style='border-top:none'></td>
  <td class=xl1519758></td>
 </tr>
 <tr height=19 style='height:14.4pt'>
  <td height=19 class=xl1519758 style='height:14.4pt'></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl6419758>Buyer</td>
  <td class=xl6419758></td>
  <td class=xl8219758 style='font-size:9pt;border-top:none'>- <?php echo substr($buyer,0,23)?></td>
  <td class=xl8219758 style='border-top:none'>&nbsp;</td>
  <td class=xl8219758 style='border-top:none'>&nbsp;</td>
  <td class=xl8219758 style='border-top:none'>&nbsp;</td>
  <td class=xl8219758 style='border-top:none'>&nbsp;</td>
  <td class=xl6419758></td>
  <td colspan=2 class=xl7919758>Spec weight(cm)</td>
  <td class=xl7719758 style='border-top:none;text-align:center;'><?php echo $spec_weight;?></td>
  <td colspan=2 class=xl7919758 style='border-left:none'>No of Rolls</td>
  <td class=xl7719758 style='border-top:none;text-align:center;'><?php echo $tot_rolls_data;?></td>
  <td class=xl1519758></td>
 </tr>
 <tr height=19 style='height:14.4pt'>
  <td height=19 class=xl1519758 style='height:14.4pt'></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td colspan=2 class=xl7919758>Actual Weight(g/sqm)</td>
  <td class=xl7719758 style='border-top:none;text-align:center;'><?php 
      for($i=0;$i<sizeof($tot_ids);$i++)
      {
		 $actual_height[$tot_ids[$i]];  
	  }
	   //$act_height=min($actual_height);
	   $act_height=implode(",",array_unique($actual_height));
	   $act_height1=substr($act_height,0,15);
	   echo $act_height1;
	  ?>
	  	
  </td>
  <td colspan=2 class=xl7919758 style='border-left:none'>Rolls inspected</td>
  <td class=xl7719758 style='border-top:none;text-align:center;'><?php echo sizeof($tot_ids);?></td>
  <td class=xl1519758></td>
 </tr>
 <tr height=19 style='height:14.4pt'>
  <td height=19 class=xl1519758 style='height:14.4pt'></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td colspan=7 class=xl1519758></td>
  <!-- <td colspan=7 class=xl7019758 style='border-right:.5pt solid black'>Batch
  Details</td> -->
  <td class=xl1519758></td>
  <td colspan=2 class=xl7919758>Repeat length</td>
  <td class=xl7719758 style='border-top:none;text-align:center;'><?php echo $repeat_length;?></td>
  <td colspan=2 class=xl7919758 style='border-left:none'>Average Points</td>
  <td class=xl7719758 style='border-top:none;text-align:center;'><?php 
 $tot_qty = 0;
  $rate=0;
 for($i=0;$i<sizeof($tot_ids);$i++)
 {
	
	$tot_qty += $invoice_qty[$tot_ids[$i]];
 }
 if($fab_uom == "meters"){
	$tot_qty = round($tot_qty*1.09361,2);
 }
  $rate = round(($tot_points/$tot_qty)*(36/$inch_value)*100,2);
  echo "".$rate;
?></td>
  <td class=xl1519758></td>
 </tr>
 <tr height=19 style='height:14.4pt'>
  <td height=19 class=xl1519758 style='height:14.4pt'></td>
  <td colspan=2 class=xl6419758>Colour</td>
  <td colspan=4 class=xl6319758><?php echo $color;?></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td colspan=2 class=xl7919758>Act.Rpt.Length</td>
  <td class=xl7719758 style='border-top:none;text-align:center;'><?php
      for($i=0;$i<sizeof($tot_ids);$i++)
      {
		$actual_repeat_height[$tot_ids[$i]];  
	  }
	  $act_length=implode(",",array_unique($actual_repeat_height));
	  $act_length1=substr($act_length,0,15);
	   echo $act_length1;	 
	  ?>
  </td>
  <td colspan=2 class=xl7919758 style='border-left:none'>Length Shortage</td>
  <td class=xl7719758 style='border-top:none;text-align:center;'></td>
  <td class=xl1519758></td>
 </tr>
 <tr height=19 style='height:14.4pt'>
  <td height=19 class=xl1519758 style='height:14.4pt'></td>
  <td colspan=2 class=xl6419758>GRN Number</td>
  <td colspan=4 class=xl6319758><?php echo $grn_no?></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td colspan=2 class=xl8019758>&nbsp;</td>
  <td class=xl7719758 style='border-top:none'></td></td>
  <td colspan=2 class=xl8019758 style='border-left:none'>Lab Testing</td>
  <td class=xl7719758 style='border-top:none;text-align:center;'><?php echo $lab_testing;?></td>
  <td class=xl1519758></td>
 </tr>
 <tr height=19 style='height:14.4pt'>
  <td height=19 class=xl1519758 style='height:14.4pt'></td>
  <td colspan=2 class=xl6419758>Invoice Number</td>
  <td colspan=4 class=xl6319758><?php echo $invoice_no;?></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
 </tr>
 <tr height=19 style='height:14.4pt'>
  <td height=19 class=xl1519758 style='height:14.4pt'></td>
  <td colspan=2 class=xl6419758>Item Code</td>
  <td colspan=4 class=xl6319758><?php echo $item_code;?></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
 </tr>
  <tr height=19 style='height:14.4pt'>
  <td height=19 class=xl1519758 style='height:14.4pt'></td>
  <td colspan=2 class=xl6419758>Item Description</td>
  <td colspan=4 class=xl6319758><?php echo $item_desc;?></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
 </tr>
  <tr height=19 style='height:14.4pt'>
  <td height=19 class=xl1519758 style='height:14.4pt'></td>
  <td colspan=2 class=xl6419758>Item Name</td>
  <td colspan=4 class=xl6319758><?php echo $item_name;?></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
 </tr>
<!--  <tr>
 <td colspan=7 class=xl7019758 style='border-right:.5pt solid black'>Batch
  Details</td>
 </tr>	
 <tr>
  <td class="xl8919758">Batch No</td>
  <td class="xl8919758">CPL</td>
  <td colspan="3" class="xl8919758">RollNo</td>
  <td colspan="2" class="xl8919758">Tot Length</td>
 </tr> -->
 <tr>
 <td class=xl1519758></td>
 <td colspan=13 class=xl7019758 style='border-right:.5pt solid black'>Batch Details</td>
 </tr>
 <tr>
  <td class=xl1519758></td>
  <td colspan="3" class="xl8919758">Batch No</td>
  <td colspan="2" class="xl8919758">Shade Group</td>
  <td colspan="2" class="xl8919758">No Of Rolls</td>
  <td colspan="4" class="xl8919758">Total Ticket Length</td>
  <td colspan="2" class="xl8919758">Width</td>
</tr>
 <?php
          $get_shade_grp="SELECT batch_no,SUM(qty_rec) AS rec,shade_grp,COUNT(*) AS rolls,MIN(ref6) as width FROM $wms.store_in LEFT JOIN $wms.sticker_report ON $wms.sticker_report.lot_no=$wms.store_in.lot_no WHERE tid IN (".implode(",",$tot_ids).") GROUP BY batch_no,shade_grp";
			   //echo $get_shade_grp;
				$shade_grp_result = mysqli_query($link, $get_shade_grp) or exit("get_shade_grp Error3" . mysqli_error($GLOBALS["___mysqli_ston"]));
				if(mysqli_num_rows($shade_grp_result)>0)
				{
					while ($row123 = mysqli_fetch_array($shade_grp_result))
					{
					  $roll_no = $row123['rolls'];	
					  $tot_length = $row123['rec'];
					  $shade = $row123['shade_grp'];
					  $tid = $row123['tid'];
					  $width = $row123['width'];
					  $batch_no = $row123['batch_no'];

					  ?>	
					  
					  <tr>
					  	<td class=xl1519758></td>
					  	<td colspan="3" class="xl8919758"><?php echo $batch_no; ?></td>
					  	<td colspan="2" class="xl8919758"><?php echo $shade; ?></td>
					  	<td colspan="2" class="xl8919758" style='text-align:right;'><?php echo $roll_no; ?></td>
					  	<td colspan="4" class="xl8919758" style='text-align:right;'><?php echo $tot_length; ?></td>
					  	<td colspan="2" class="xl8919758" style='text-align:right;'><?php echo $minVal; ?></td>
					  </tr>
					  
			    <?php	  	
					}
				}
	?>
<tr height=21 style='mso-height-source:userset;height:15.6pt'>
  <td height=21 class=xl1519758 style='height:15.6pt'></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
 </tr>
 
 
 <tr height=19 style='mso-height-source:userset;height:14.4pt'>
  <td height=19 class=xl1519758 style='height:14.4pt'></td>
  <td rowspan=2 class=xl8519758 width=78 style='border-bottom:.5pt solid black;
  width:59pt'>Roll No/ Sup</td>
  <td colspan=2 rowspan=2 class=xl7519758 style='border-right:.5pt solid black;
  border-bottom:.5pt solid black'>Batch Number</td>
  <td rowspan=2 class=xl8519758 width=64  style='border-bottom:.5pt solid black;
  width:48pt'>Ticket Length (<?php echo $fab_uom;?>)</td>
  <td rowspan=2 class=xl8519758 width=64 style='border-bottom:.5pt solid black;
  width:48pt'>Actual Length (<?php echo $fab_uom;?>)</td>
  <td colspan=3 class=xl7019758 style='border-right:.5pt solid black;
  border-left:none'>Usable Width (cm)</td>
  <td colspan=4 class=xl7019758 style='border-right:.5pt solid black;
  border-left:none'>Total Point</td>
  <td rowspan=2 class=xl8719758 width=53 style='width:40pt'>Total Points</td>
  <td rowspan=2 colspan=2 class=xl8719758 width=49 style='border-bottom:.5pt solid black;
  width:37pt'>Point Rate</td>
  <td rowspan=2 class=xl8519758 width=102 style='border-bottom:.5pt solid black;
  width:77pt'>Comments</td>
  <td rowspan=2 class=xl8519758 width=102 style='border-bottom:.5pt solid black;
  width:77pt'>Damanges</td>
  <td rowspan=2 class=xl8519758 width=78 style='border-bottom:.5pt solid black;
  width:56pt'>GSM</td>
  <td rowspan=2 class=xl8519758 width=64 style='border-bottom:.5pt solid black;
  width:56pt'>SK</td>
  <td rowspan=2 class=xl8519758 width=69 style='border-bottom:.5pt solid black;
  width:52pt'>BO</td>
  <td rowspan=2 class=xl8519758 width=74 style='border-bottom:.5pt solid black;
  width:56pt'>VE</td>
  <td class=xl1519758></td>
 </tr>
 <tr height=38 style='height:28.8pt'>
  <td height=38 class=xl1519758 style='height:28.8pt'></td>
  <td class=xl6819758 style='border-top:none;border-left:none;text-align: center;'>S</td>
  <td class=xl6819758 style='border-top:none;border-left:none;text-align: center;'>M</td>
  <td class=xl6819758 style='border-top:none;border-left:none;text-align: center;'>E</td>
  <td class=xl8819758 width=29 style='border-top:none;border-left:none;
  width:22pt;text-align: center;'>1 Pts</td>
  <td class=xl8819758 width=25 style='border-top:none;border-left:none;
  width:19pt;text-align: center;'>2 Pts</td>
  <td class=xl8819758 width=29 style='border-top:none;border-left:none;
  width:22pt;text-align: center;'>3 Pts</td>
  <td class=xl8819758 width=26 style='border-top:none;border-left:none;
  width:19pt;text-align: center;'>4 Pts</td>

  <td class=xl1519758></td>
 </tr>

<?php
$tot_qty_g=0;$tot_qty=0;
for($i=0;$i<sizeof($tot_ids);$i++)
{
	$tot=0;
	?> 
	 <tr class=xl6419758 height=39 style='mso-height-source:userset;height:29.4pt'>
	<td height=39 class=xl6419758 style='height:29.4pt'></td>
	<td class=xl8919758 style='border-top:none'><?php echo $sfcs_roll[$tot_ids[$i]]; ?>   /  <?php echo $supp_roll[$tot_ids[$i]]; ?></td> 
	<td colspan=2 class=xl9019758 style='border-right:.5pt solid black;border-left:none'><?php echo $batch[$tot_ids[$i]]; ?></td>
	<td class=xl9219758 style='border-top:none;border-left:none;text-align:right';><?php echo $invoice_qty[$tot_ids[$i]]; $tot_qty_g=$tot_qty_g+$invoice_qty[$tot_ids[$i]];?></td>
	<td class=xl8919758 style='border-top:none;border-left:none;text-align:right'></td>
	<td class=xl8919758 style='border-top:none;border-left:none;text-align:right'><?php echo $width_s[$tot_ids[$i]]; ?></td>
	<td class=xl8919758 style='border-top:none;border-left:none;text-align:right'><?php echo $width_m[$tot_ids[$i]]; ?></td>
	<td class=xl8919758 style='border-top:none;border-left:none;text-align:right'><?php echo $width_e[$tot_ids[$i]]; ?></td>
	<td class=xl8919758 style='border-top:none;border-left:none;text-align:right'><?php if($ins_child_count[$tot_ids[$i]][1]<>''){echo $ins_child_count[$tot_ids[$i]][1]; $tot=$tot+$ins_child[$tot_ids[$i]][1];}else{ echo "0";}?></td>
	<td class=xl8919758 style='border-top:none;border-left:none;text-align:right'><?php if($ins_child_count[$tot_ids[$i]][2]<>''){echo $ins_child_count[$tot_ids[$i]][2]; $tot=$tot+$ins_child[$tot_ids[$i]][2];}else{ echo "0";}?></td>
	<td class=xl8919758 style='border-top:none;border-left:none;text-align:right'><?php if($ins_child_count[$tot_ids[$i]][3]<>''){echo $ins_child_count[$tot_ids[$i]][3]; $tot=$tot+$ins_child[$tot_ids[$i]][3];}else{ echo "0";}?></td>
	<td class=xl8919758 style='border-top:none;border-left:none;text-align:right'><?php if($ins_child_count[$tot_ids[$i]][4]<>''){echo $ins_child_count[$tot_ids[$i]][4]; $tot=$tot+$ins_child[$tot_ids[$i]][4];}else{ echo "0";}?></td>
	<td class=xl8919758 style='border-top:none;border-left:none;text-align:right'><?php echo $tot; $tot_qty=$tot_qty+$tot;
	$rate=0;
	$qty=0;
	if($fab_uom == "meters"){
		$qty=round($invoice_qty[$tot_ids[$i]]*1.09361,2);
	}else
	{
		$qty=$invoice_qty[$tot_ids[$i]];
	}
	
	$min1 = min($width_s[$tot_ids[$i]],$width_m[$tot_ids[$i]],$width_e[$tot_ids[$i]]);
	$inch_value1=round($min1/(2.54),2);

	$rate = round(($tot/$qty)*(36/$inch_value1)*100,2); 
	
	
	?></td> 
	<td colspan=2 class=xl8919758 style='border-top:none;border-left:none;text-align:right'><?php echo $rate; ?></td>
	<td class=xl9319758 style='border-top:none;border-left:none'><?php echo $comment[$tot_ids[$i]]; ?></td>
	<?php	
	$count=0;$data='';
	$get_inspection_population_info122 = "select code,points from $wms.`four_points_table` where insp_child_id=".$tot_ids[$i]." and plant_code='".$plant_code."'";
	$info_result122 = mysqli_query($link, $get_inspection_population_info122) or exit("get_details Error2" . mysqli_error($GLOBALS["___mysqli_ston"]));
	if(mysqli_num_rows($info_result122)>0)
	{
		while($row2212 = mysqli_fetch_array($info_result122)) 
		{
			$count++;
			$data .= $row2212['code']."-".$row2212['points']."/";			
			if($count==3)
			{
				$data .= "<br>";
				$count=0;
			}
		}
	}
	else
	{
		$data='';	
	}
	?>
	<td class=xl9319758 width=102 style='border-top:none;border-left:none;width:77pt'><?php echo $data;?></td>
	<td class=xl8919758 style='border-top:none;border-left:none;text-align:right'><?php echo $gsm[$tot_ids[$i]];?></td>
	  <td class=xl8919758 style='border-top:none;border-left:none;text-align:right'><?php echo $skw[$tot_ids[$i]];?></td>
	  <td class=xl8919758 style='border-top:none;border-left:none;text-align:right'><?php echo $bow[$tot_ids[$i]];?></td>
	  <td class=xl8919758 style='border-top:none;border-left:none;text-align:right'><?php echo $ver[$tot_ids[$i]];?></td>
	  <td class=xl6419758></td>
	 </tr>
	<?php
}	 
 
 ?>

 
 <tr height=19 style='height:14.4pt'>
  <td height=19 class=xl1519758 style='height:14.4pt'></td>
  <td colspan=3 class=xl6919758>Total Inspected Quantity</td>
  <td class=xl9419758 style='border-top:none;text-align:right'><?php echo number_format($tot_qty_g,2);?></td>
  <td class=xl6419758></td>
  <td class=xl6419758></td>
  <td class=xl6419758></td>
  <td colspan=5 class=xl6919758>Actual Points</td>
  <td class=xl8219758 style='border-top:none;text-align:right'><?php echo $tot_qty;?></td>
  <td class=xl6419758></td>
  <td class=xl6419758></td>
  <td class=xl6419758></td>
  <td class=xl6419758></td>
  <td class=xl6419758></td>
  <td class=xl6419758></td>
  <td class=xl6419758></td>
  <td class=xl1519758></td>
 </tr>
 <tr height=19 style='height:14.4pt'>
  <td height=19 class=xl1519758 style='height:14.4pt'></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
 </tr>
 <tr height=19 style='height:14.4pt'>
  <td height=19 class=xl1519758 style='height:14.4pt'></td>
  <td colspan=3 class=xl8119758>Reject Reasons</td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
 </tr>
 <tr height=19 style='height:14.4pt'>
  <td height=19 class=xl1519758 style='height:14.4pt'></td>
  
  <?php
	$count1=0;$data1='';
	$get_inspection_population_info1221 = "select code,description from $wms.`four_points_table` where insp_child_id in (".implode(",",$tot_ids).") and plant_code='".$plant_code."' group by code";
	//echo $get_inspection_population_info1221."<br>";
	$info_result1221 = mysqli_query($link, $get_inspection_population_info1221) or exit("get_details Error25" . mysqli_error($GLOBALS["___mysqli_ston"]));
	if(mysqli_num_rows($info_result1221)>0)
	{
		while($row22121 = mysqli_fetch_array($info_result1221)) 
		{
			$count1++;
			$data1 .= $row22121['code']."- ".$row22121['description']." &nbsp&nbsp&nbsp&nbsp&nbsp";			
			if($count1==8)
			{
				$data1 .= "<br>";
				$count1=0;
			}
		}
	}
	else
	{
		$data1='';	
	}
  ?>
  <td colspan=20 rowspan=4 class=xl6419758 style='border-bottom:.5pt solid black'>
  <?php 
  echo $data1;
  ?>
  </td>
  <td class=xl1519758></td>
 </tr>
 <tr height=19 style='height:14.4pt'>
  <td height=19 class=xl1519758 style='height:14.4pt'></td>
  <td class=xl1519758></td>
 </tr>
 <tr height=19 style='height:14.4pt'>
  <td height=19 class=xl1519758 style='height:14.4pt'></td>
  <td class=xl1519758></td>
 </tr>
 <tr height=19 style='height:14.4pt'>
  <td height=19 class=xl1519758 style='height:14.4pt'></td>
  <td class=xl1519758></td>
 </tr>
 <tr height=19 style='height:14.4pt'>
  <td height=19 class=xl1519758 style='height:14.4pt'></td>
  <td class=xl6419758></td>
  <td class=xl6419758></td>
  <td class=xl6419758></td>
  <td class=xl6419758></td>
  <td class=xl6419758></td>
  <td class=xl6419758></td>
  <td class=xl6419758></td>
  <td class=xl6419758></td>
  <td class=xl6419758></td>
  <td class=xl6419758></td>
  <td class=xl6419758></td>
  <td class=xl6419758></td>
  <td class=xl6419758></td>
  <td class=xl6419758></td>
  <td class=xl6419758></td>
  <td class=xl6419758></td>
  <td class=xl6419758></td>
  <td class=xl6419758></td>
  <td class=xl6419758></td>
  <td class=xl6419758></td>
  <td class=xl1519758></td>
 </tr>
 <tr height=19 style='height:14.4pt'>
  <td height=19 class=xl1519758 style='height:14.4pt'></td>
  <td class=xl10119758>&nbsp;</td>
  <td class=xl10219758>&nbsp;</td>
  <td class=xl10219758>&nbsp;</td>
  <td class=xl10219758>&nbsp;</td>
  <td class=xl10219758>&nbsp;</td>
  <td class=xl10219758>&nbsp;</td>
  <td class=xl10219758>&nbsp;</td>
  <td class=xl10319758>&nbsp;</td>
  <td class=xl1519758></td>
  <td class=xl11119758 colspan=3>Accepted</td>
  <td class=xl11319758>&nbsp;</td>
  <?php
	if($fab_uom == "meters"){
		$tot_qty_g=round($tot_qty_g*1.09361,2);
	}else
	{
		$tot_qty_g;
	}
	$calclation = round(($tot_qty/$tot_qty_g)*(36/$inch_value)*100,2); 
	if($calclation<28)
	{
	  ?>
	  <td class=xl6819758 style='border-left:none;background-color: black;'>&nbsp;</td>
	  <?php
	}
	else
	{
	 ?>
		<td class=xl6819758 style='border-left:none;'>&nbsp;</td>
	<?php
	}
	?>	
  <td class=xl6419758></td>
  <td class=xl6419758></td>
  <td class=xl6419758></td>
  <td class=xl6419758>Approved</td>
  <td class=xl6419758>Rejected</td>
  <td class=xl6419758>Hold</td>
  <td class=xl1519758></td>
 </tr>
 <tr height=19 style='height:14.4pt'>
  <td height=19 class=xl1519758 style='height:14.4pt'></td>
  <td colspan=2 class=xl9619758>Actual</td>
  <td class=xl10419758></td>
  <td class=xl10419758></td>
  <td class=xl10419758></td>
  <td class=xl10419758></td>
  <td class=xl10419758></td>
  <td class=xl10519758>&nbsp;</td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl6419758></td>
  <td class=xl6419758></td>
  <td class=xl6419758>Point Rate</td>
  <td class=xl8919758>&nbsp;</td>
  <td class=xl8919758 style='border-left:none'>&nbsp;</td>
  <td class=xl8919758 style='border-left:none'>&nbsp;</td>
  <td class=xl1519758></td>
 </tr>
 
 <tr height=19 style='height:14.4pt'>
  <td height=19 class=xl1519758 style='height:14.4pt'></td>
  <td colspan=2 class=xl9619758 style='border-top:none;'> <?php echo $tot_qty;?></td>
  <td colspan=2 class=xl9719758>36&quot;</td>
  <td class=xl10419758></td>
  <td class=xl10419758></td>
  <td class=xl10419758></td>
  <td class=xl10519758>&nbsp;</td>
  <td class=xl1519758></td>
  <td class=xl11119758 colspan=3>Rejected</td>
  <td class=xl11319758>&nbsp;</td>
  <?php
  if($calclation>28)
	{
	  ?>
	  <td class=xl6819758 style='border-left:none;background-color: black;'>&nbsp;</td>
	  <?php
	}
	else
	{
	 ?>
		<td class=xl6819758 style='border-left:none;'>&nbsp;</td>
	<?php
	}
	?>	
   <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758>GSM</td>
  <td class=xl6819758 style='border-top:none'>&nbsp;</td>
  <td class=xl6819758 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl6819758 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl1519758></td>
 </tr>
 <tr height=19 style='height:14.4pt'>
  <td height=19 class=xl1519758 style='height:14.4pt'></td>
  <td colspan=2 class=xl9619758>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp ____________ &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp X</td>
  <td colspan=2 class=xl9719758>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp ____________  &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp X</font>
  
  </td>
  <td class=xl10419758 align=right>100</td>
  <td class=xl9719758>=</td>
  <td colspan=2 class=xl9719758 style='border-right:.5pt solid black'><?php echo $calclation;?></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758>SKU</td>
  <td class=xl6819758 style='border-top:none'>&nbsp;</td>
  <td class=xl6819758 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl6819758 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl1519758></td>
 </tr>
 <tr height=19 style='height:14.4pt'>
  <td height=19 class=xl1519758 style='height:14.4pt'></td>
  <td colspan=2 class=xl9619758><?php echo $tot_qty_g;?></td>
  <td colspan=2 class=xl9719758><?php echo $inch_value;?></td>
  <td class=xl10419758></td>
  <td class=xl10419758></td>
  <td class=xl10419758></td>
  <td class=xl10519758>&nbsp;</td>
  <td class=xl1519758></td>
  <td class=xl11419758 colspan=4>Hold</span></td>
  <td class=xl6819758 style='border-left:none'>&nbsp;</td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl6419758>BOW</td>
  <td class=xl6819758 style='border-top:none'>&nbsp;</td>
  <td class=xl6819758 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl6819758 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl1519758></td>
 </tr>
 <tr height=19 style='height:14.4pt'>
  <td height=19 class=xl1519758 style='height:14.4pt'></td>
  <td colspan=2 rowspan=3 class=xl10919758 width=142 style='border-bottom:.5pt solid black;
  width:107pt'>Actual Roll <br>
    Length</td>
  <td colspan=2 rowspan=3 class=xl10719758 width=121 style='border-bottom:.5pt solid black;
  width:91pt'>Actual Fabric width in Inches</td>
  <td class=xl10419758></td>
  <td class=xl10419758></td>
  <td class=xl10419758></td>
  <td class=xl10519758>&nbsp;</td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl6419758>Vertical</td>
  <td class=xl6819758 style='border-top:none'>&nbsp;</td>
  <td class=xl6819758 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl6819758 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl1519758></td>
 </tr>
 <tr height=19 style='height:14.4pt'>
  <td height=19 class=xl1519758 style='height:14.4pt'></td>
  <td class=xl10419758></td>
  <td class=xl10419758></td>
  <td colspan=2 rowspan=2 class=xl9719758 style='border-right:.5pt solid black;
  border-bottom:.5pt solid black'>Points/100Square</td>
  <td class=xl1519758></td>
  <td class=xl11519758 colspan=2>Swatch</td>
  <td class=xl11619758>&nbsp;</td>
  <td class=xl11619758>&nbsp;</td>
  <td class=xl11719758>&nbsp;</td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
 </tr>
 <tr height=19 style='height:14.4pt'>
  <td height=19 class=xl1519758 style='height:14.4pt'></td>
  <td class=xl10619758>&nbsp;</td>
  <td class=xl10619758>&nbsp;</td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
 </tr>
 <tr height=19 style='height:14.4pt'>
  <td height=19 class=xl1519758 style='height:14.4pt'></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
 </tr>
 <tr height=19 style='height:14.4pt'>
  <td height=19 class=xl1519758 style='height:14.4pt'></td>
  <td class=xl9519758>Remarks</td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
 </tr>
 <tr height=19 style='height:14.4pt'>
  <td height=19 class=xl1519758 style='height:14.4pt'></td>
  <td class=xl1519758><?php echo $remarks; ?></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
 </tr>
 <tr height=19 style='height:14.4pt'>
  <td height=19 class=xl1519758 style='height:14.4pt'></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
 </tr>
 <tr height=19 style='height:14.4pt'>
  <td height=19 class=xl1519758 style='height:14.4pt'></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
 </tr>
 <tr height=19 style='height:14.4pt'>
  <td height=19 class=xl1519758 style='height:14.4pt'></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
 </tr>
 <tr height=19 style='height:14.4pt'>
  <td height=19 class=xl1519758 style='height:14.4pt'></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
 </tr>
 <tr height=19 style='height:14.4pt'>
  <td height=19 class=xl1519758 style='height:14.4pt'></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
 </tr>
 <tr height=19 style='height:14.4pt'>
  <td height=19 class=xl1519758 style='height:14.4pt'></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
 </tr>
 <tr height=19 style='height:14.4pt'>
  <td height=19 class=xl1519758 style='height:14.4pt'></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
 </tr>
 <tr height=19 style='height:14.4pt'>
  <td height=19 class=xl1519758 style='height:14.4pt'></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
 </tr>
 <tr height=19 style='height:14.4pt'>
  <td height=19 class=xl1519758 style='height:14.4pt'></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
 </tr>
 <tr height=19 style='height:14.4pt'>
  <td height=19 class=xl1519758 style='height:14.4pt'></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
 </tr>
 <tr height=19 style='height:14.4pt'>
  <td height=19 class=xl1519758 style='height:14.4pt'></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
 </tr>
 <tr height=19 style='height:14.4pt'>
  <td height=19 class=xl1519758 style='height:14.4pt'></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
 </tr>
 <tr height=19 style='height:14.4pt'>
  <td height=19 class=xl1519758 style='height:14.4pt'></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
 </tr>
 <tr height=19 style='height:14.4pt'>
  <td height=19 class=xl1519758 style='height:14.4pt'></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
 </tr>
 <tr height=19 style='height:14.4pt'>
  <td height=19 class=xl1519758 style='height:14.4pt'></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
 </tr>
 <tr height=19 style='height:14.4pt'>
  <td height=19 class=xl1519758 style='height:14.4pt'></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
 </tr>
 <tr height=19 style='height:14.4pt'>
  <td height=19 class=xl1519758 style='height:14.4pt'></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
 </tr>
 <tr height=19 style='height:14.4pt'>
  <td height=19 class=xl1519758 style='height:14.4pt'></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
 </tr>
 <tr height=19 style='height:14.4pt'>
  <td height=19 class=xl1519758 style='height:14.4pt'></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
 </tr>
 <tr height=19 style='height:14.4pt'>
  <td height=19 class=xl1519758 style='height:14.4pt'></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
 </tr>
 <tr height=19 style='height:14.4pt'>
  <td height=19 class=xl1519758 style='height:14.4pt'></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
 </tr>
 <tr height=19 style='height:14.4pt'>
  <td height=19 class=xl1519758 style='height:14.4pt'></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
 </tr>
 <tr height=19 style='height:14.4pt'>
  <td height=19 class=xl1519758 style='height:14.4pt'></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
  <td class=xl1519758></td>
 </tr>
 <![if supportMisalignedColumns]>
 <tr height=0 style='display:none'>
  <td width=55 style='width:41pt'></td>
  <td width=78 style='width:59pt'></td>
  <td width=64 style='width:48pt'></td>
  <td width=57 style='width:43pt'></td>
  <td width=64 style='width:48pt'></td>
  <td width=64 style='width:48pt'></td>
  <td width=51 style='width:38pt'></td>
  <td width=59 style='width:44pt'></td>
  <td width=58 style='width:44pt'></td>
  <td width=29 style='width:22pt'></td>
  <td width=25 style='width:19pt'></td>
  <td width=29 style='width:22pt'></td>
  <td width=26 style='width:19pt'></td>
  <td width=53 style='width:40pt'></td>
  <td width=49 style='width:37pt'></td>
  <td width=86 style='width:65pt'></td>
  <td width=102 style='width:77pt'></td>
  <td width=78 style='width:59pt'></td>
  <td width=64 style='width:48pt'></td>
  <td width=69 style='width:52pt'></td>
  <td width=74 style='width:56pt'></td>
  <td width=64 style='width:48pt'></td>
 </tr>
 <![endif]>
</table>

</div>



</body>

</html>
<?php
$update_query = "update $wms.main_population_tbl set status=2,updated_user= '".$username."',updated_at=NOW() where id=".$inpsect_id." and plant_code='".$plant_code."'";
mysqli_query($link, $update_query) or exit("Update Error" . mysqli_error($GLOBALS["___mysqli_ston"]));
?>
<script>
window.onunload = refreshParent;
function refreshParent() {
	window.opener.location.reload();
}
</script>
