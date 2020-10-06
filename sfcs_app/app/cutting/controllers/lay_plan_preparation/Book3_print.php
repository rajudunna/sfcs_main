<?php ini_set('error_reporting', E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED);
include('../../../../common/config/config.php');
include('../../../../common/config/functions.php');
include('../../../../common/config/functions_v2.php');
include('../../../../common/config/functions_dashboard.php');	
$doc_num=$_GET['doc_id'];
$print_status=$_GET['print_status'];
$plant_code = $_GET['plant_code'];
$username = $_GET['username'];
$sql22="select jm_docket_line_id from $pps.jm_docket_lines where docket_line_number='$doc_num' and plant_code='$plant_code'";
	    $jm_cut_job_result1=mysqli_query($link, $sql22) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row12=mysqli_fetch_array($jm_cut_job_result1))
		{
			$doc_id= $sql_row12['jm_docket_line_id'];

		}




if($doc_num!="" && $plant_code!=''){
	//this is function to get style,color,and cutjob
	$result_jmdockets=getJmDockets($doc_num,$plant_code);
	$style =$result_jmdockets['style'];
	$fg_color =$result_jmdockets['fg_color'];
	$plies =$result_jmdockets['plies'];
	$jm_cut_job_id =$result_jmdockets['jm_cut_job_id'];
	$ratio_comp_group_id =$result_jmdockets['ratio_comp_group_id'];
	$length =$result_jmdockets['length'];
	$purwidth =$result_jmdockets['width'];
	$efficiency =$result_jmdockets['efficiency'];
	$marker_version =$result_jmdockets['marker_version'];
	$marker_type_name =$result_jmdockets['marker_type_name'];
	$pattern_version =$result_jmdockets['pattern_version'];
	$perimeter =$result_jmdockets['perimeter'];
	$remark1 =$result_jmdockets['remark1'];
	$remark2 =$result_jmdockets['remark2'];
	$remark3 =$result_jmdockets['remark3'];
	$remark4 =$result_jmdockets['remark4'];
	$created_at =$result_jmdockets['created_at'];
	$material_required_qty=$plies*$length;
}else{
	echo "Plese verify Docket No & Plant code";exit;
}
//to get component po_num and ratio id from
$qry_jm_cut_job="SELECT ratio_id,po_number,cut_number FROM $pps.jm_cut_job WHERE jm_cut_job_id='$jm_cut_job_id' AND plant_code='".$plant_code."'";
$jm_cut_job_result=mysqli_query($link_new, $qry_jm_cut_job) or exit("Sql Errorat_jm_cut_job".mysqli_error($GLOBALS["___mysqli_ston"]));
$jm_cut_job_num=mysqli_num_rows($jm_cut_job_result);
if($jm_cut_job_num>0){
	while($sql_row1=mysqli_fetch_array($jm_cut_job_result))
	{
		$ratio_id = $sql_row1['ratio_id'];
		$po_number=$sql_row1['po_number'];
		$cut_number=$sql_row1['cut_number'];
	}
}
//this is function to get schedule
if($po_number!=" " & $plant_code!=' '){
	$result_mp_mo_qty=getMpMoQty($po_number,$plant_code);
	$schedule =$result_mp_mo_qty['schedule'];
}else{
	echo "Plese verify po number & Plant code";exit;
}

//this is a function to get component group id and ratio id
if($ratio_comp_group_id!=' '){
	$result_ratio_component_group=getRatioComponentGroup($ratio_comp_group_id,$plant_code);
	$category =$result_ratio_component_group['fabric_category'];
	$compo_no =$result_ratio_component_group['material_item_code'];
	$master_po_details_id =$result_ratio_component_group['master_po_details_id'];
}else{
	echo "Plese verify Ratio component group id";exit;
}
//this is a function to get descrip and rm color from mp_fabric
if($compo_no!='' && $master_po_details_id!=''){
	$result_mp_fabric=getMpFabric($compo_no,$master_po_details_id,$plant_code);
	$fab_des =$result_mp_fabric['rm_description'];
	$rm_color =$result_mp_fabric['rm_color'];
	$consumption =$result_mp_fabric['consumption'];
	$wastage =$result_mp_fabric['wastage'];


}else{
	echo "Plese verify component No & Po details id";exit;
}

//this is function to get sizes ratio based on ratio id
if($ratio_id!=' ' && $plant_code!=''){
	$result_size_ratios=getSizeRatios($ratio_id,$plant_code);
	$size_tit =$result_size_ratios['size_tit'];
	$ratioof =$result_size_ratios['ratioof'];
}else{
	echo "Plese verify ratio id & Plant details";exit;
}
	//$category=$sql_row['category'];
	$gmtway=$sql_row['gmtway'];
	//$fab_des=$sql_row['fab_des'];
	$body_yy=$sql_row['catyy'];
	$waist_yy=$sql_row['Waist_yy'];
	$leg_yy=$sql_row['Leg_yy'];
	//$purwidth=$sql_row['purwidth'];
	//$compo_no=$sql_row['compo_no'];
	$strip_match=$sql_row['strip_match'];
	$gusset_sep=$sql_row['gusset_sep'];
	$patt_ver=$sql_row['patt_ver'];
	$col_des=$sql_row['col_des'];
?>

<?php

	
	$doc_num = "'" . str_replace(',',"','",$doc_num) . "'";
	$sql="select min(roll_width) as width from $wms.fabric_cad_allocation where doc_no in ($doc_num) and doc_type=\"normal\" and plant_code='".$plant_code."'";
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error10".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row1x=mysqli_fetch_array($sql_result))
	{
		$system_width=round($sql_row1x['width'],2);
	}
	$sql1="select min(roll_width) as width from $wms.fabric_cad_allocation where doc_no in ($doc_num) and doc_type=\"normal\" and plant_code='".$plant_code."'";
//echo $sql;
	$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error10".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row1x1=mysqli_fetch_array($sql_result1))
	{
		$print_status=$sql_row1x1['print_status'];
	}
	$actwidth=$system_width;
?>
<html xmlns:o="urn:schemas-microsoft-com:office:office"
xmlns:x="urn:schemas-microsoft-com:office:excel"
xmlns="http://www.w3.org/TR/REC-html40">

<head>
<title>DOCKET VIEW</title>
<meta http-equiv=Content-Type content="text/html; charset=windows-1252">
<meta name=ProgId content=Excel.Sheet>
<meta name=Generator content="Microsoft Excel 14">
<link rel=File-List href="DOCKET_NEW_files/filelist.xml">
<style id="DOCKET_NEW_4118_Styles">
<!--table
	{mso-displayed-decimal-separator:"\.";
	mso-displayed-thousand-separator:"\,";}
.xl154118
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
.xl664118
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
.xl674118
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
	text-align:center;
	vertical-align:bottom;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl684118
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
	text-align:center;
	vertical-align:bottom;
	border:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl694118
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:"Trebuchet MS", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:bottom;
	border:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl704118
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
	text-align:center;
	vertical-align:bottom;
	border-top:.5pt solid windowtext;
	border-right:.5pt solid windowtext;
	border-bottom:.5pt solid windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl714118
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:"Trebuchet MS", sans-serif;
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
.xl724118
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
	text-align:center;
	vertical-align:bottom;
	border-top:none;
	border-right:.5pt solid windowtext;
	border-bottom:.5pt solid windowtext;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl734118
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	/* font-weight:700; */
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
.xl744118
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
	text-align:center;
	vertical-align:bottom;
	border-top:none;
	border-right:.5pt solid windowtext;
	border-bottom:.5pt solid windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl754118
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:700;
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
.xl764118
	{padding-top:2px;
	padding-right:2px;
	padding-left:2px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:"Trebuchet MS", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:left;
	vertical-align:top;
	border-top:.5pt solid windowtext;
	border-right:.5pt solid windowtext;
	border-bottom:none;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl774118
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
	text-align:center;
	vertical-align:bottom;
	border-top:.5pt solid windowtext;
	border-right:.5pt solid windowtext;
	border-bottom:none;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
	
.xl7742018
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
	text-align:center;
	vertical-align:bottom;
	border-top:.5pt solid windowtext;
	border-right:.5pt solid windowtext;
	border-bottom:none;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;}	
	
.xl784118
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
	border:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl794118
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
	border-top:.5pt solid windowtext;
	border-right:.5pt solid windowtext;
	border-bottom:.5pt solid windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl804118
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
	border-top:none;
	border-right:.5pt solid windowtext;
	border-bottom:.5pt solid windowtext;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl814118
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
	border-top:none;
	border-right:.5pt solid windowtext;
	border-bottom:.5pt solid windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl824118
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
	mso-number-format:Fixed;
	text-align:left;
	vertical-align:middle;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl834118
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
	vertical-align:middle;
	border-top:none;
	border-right:.5pt solid windowtext;
	border-bottom:.5pt solid windowtext;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl844118
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:"Trebuchet MS", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:bottom;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl854118
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
	mso-number-format:Fixed;
	text-align:left;
	vertical-align:middle;
	border-top:none;
	border-right:.5pt solid windowtext;
	border-bottom:.5pt solid windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl864118
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
	border-top:none;
	border-right:none;
	border-bottom:.5pt solid windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl874118
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
	border-top:none;
	border-right:.5pt solid windowtext;
	border-bottom:.5pt solid windowtext;
	border-left:.5pt solid windowtext;
	background:silver;
	mso-pattern:black none;
	white-space:nowrap;}
.xl884118
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
	border-top:none;
	border-right:.5pt solid windowtext;
	border-bottom:.5pt solid windowtext;
	border-left:none;
	background:silver;
	mso-pattern:black none;
	white-space:nowrap;}
.xl894118
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
	border-top:.5pt solid windowtext;
	border-right:none;
	border-bottom:.5pt solid windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl904118
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
	text-align:right;
	vertical-align:bottom;
	border-top:none;
	border-right:none;
	border-bottom:none;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
	.xl904118x
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
	text-align:right;
	vertical-align:bottom;
	border-top:none;
	border-right:none;
	border-bottom:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl914118
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
	text-align:right;
	vertical-align:bottom;
	border-top:.5pt solid windowtext;
	border-right:none;
	border-bottom:none;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl924118
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
	text-align:right;
	vertical-align:bottom;
	border-top:.5pt solid windowtext;
	border-right:none;
	border-bottom:none;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl934118
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
	text-align:right;
	vertical-align:bottom;
	border-top:none;
	border-right:none;
	border-bottom:.5pt solid windowtext;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl944118
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:"Trebuchet MS", sans-serif;
	mso-font-charset:0;
	mso-number-format:"Short Date";
	text-align:left;
	vertical-align:bottom;
	border-top:.5pt solid windowtext;
	border-right:.5pt solid windowtext;
	border-bottom:none;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl954118
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:"Trebuchet MS", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:left;
	vertical-align:bottom;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl964118
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:windowtext;
	font-size:8.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:"Trebuchet MS", sans-serif;
	mso-font-charset:0;
	mso-number-format:"Short Date";
	text-align:left;
	vertical-align:bottom;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl974118
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:"Trebuchet MS", sans-serif;
	mso-font-charset:0;
	mso-number-format:0;
	text-align:left;
	vertical-align:bottom;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl984118
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
	border-top:.5pt solid windowtext;
	border-right:none;
	border-bottom:none;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl994118
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
	border-top:.5pt solid windowtext;
	border-right:.5pt solid windowtext;
	border-bottom:none;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl1004118
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
	border-top:none;
	border-right:.5pt solid windowtext;
	border-bottom:none;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl1014118
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:windowtext;
	font-size:14.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:underline;
	text-underline-style:single;
	font-family:"Trebuchet MS", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:general;
	vertical-align:bottom;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl1024118
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:windowtext;
	font-size:12.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:"Trebuchet MS", sans-serif;
	mso-font-charset:0;
	mso-number-format:"\@";
	text-align:center;
	vertical-align:bottom;
	border-top:.5pt solid windowtext;
	border-right:none;
	border-bottom:.5pt solid windowtext;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl1034118
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:windowtext;
	font-size:12.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:"Trebuchet MS", sans-serif;
	mso-font-charset:0;
	mso-number-format:"\@";
	text-align:center;
	vertical-align:bottom;
	border-top:.5pt solid windowtext;
	border-right:none;
	border-bottom:.5pt solid windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl1044118
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:windowtext;
	font-size:12.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:"Trebuchet MS", sans-serif;
	mso-font-charset:0;
	mso-number-format:"\@";
	text-align:center;
	vertical-align:bottom;
	border-top:.5pt solid windowtext;
	border-right:.5pt solid windowtext;
	border-bottom:.5pt solid windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl1054118
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
	text-align:center;
	vertical-align:bottom;
	border:.5pt solid windowtext;
	background:silver;
	mso-pattern:black none;
	white-space:nowrap;}
.xl1064118
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
	text-align:center;
	vertical-align:middle;
	border:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl1074118
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
	text-align:right;
	vertical-align:bottom;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl1084118
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
	text-align:right;
	vertical-align:bottom;
	border-top:none;
	border-right:none;
	border-bottom:.5pt solid windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl1094118
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:"Trebuchet MS", sans-serif;
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
.xl1104118
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:"Trebuchet MS", sans-serif;
	mso-font-charset:0;
	mso-number-format:"dd\/mmm";
	text-align:left;
	vertical-align:bottom;
	border-top:none;
	border-right:none;
	border-bottom:.5pt solid windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl1114118
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:"Trebuchet MS", sans-serif;
	mso-font-charset:0;
	mso-number-format:"dd\/mmm";
	text-align:left;
	vertical-align:bottom;
	border-top:none;
	border-right:.5pt solid windowtext;
	border-bottom:.5pt solid windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl1124118
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	/* font-weight:700; */
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:bottom;
	border-top:.5pt solid black;
	border-right:.5pt solid windowtext;
	border-bottom:none;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:normal;}
.xl1134118
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:"Trebuchet MS", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:bottom;
	border-top:none;
	border-right:.5pt solid windowtext;
	border-bottom:.5pt solid black;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:normal;}
.xl1144118
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
	text-align:center;
	vertical-align:bottom;
	border-top:.5pt solid windowtext;
	border-right:.5pt solid windowtext;
	border-bottom:none;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:normal;}
.xl1154118
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
	text-align:center;
	vertical-align:bottom;
	border-top:none;
	border-right:.5pt solid windowtext;
	border-bottom:.5pt solid black;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:normal;}
.xl1164118
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:"Trebuchet MS", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:right;
	vertical-align:bottom;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl1174118
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:"Trebuchet MS", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:right;
	vertical-align:bottom;
	border-top:none;
	border-right:.5pt solid windowtext;
	border-bottom:none;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl1184118
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	/* font-weight:700; */
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
.xl1194118
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:"Trebuchet MS", sans-serif;
	mso-font-charset:0;
	mso-number-format:0;
	text-align:left;
	vertical-align:bottom;
	border-top:none;
	border-right:none;
	border-bottom:.5pt solid windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl1204118
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:"Trebuchet MS", sans-serif;
	mso-font-charset:0;
	mso-number-format:0;
	text-align:left;
	vertical-align:bottom;
	border-top:none;
	border-right:.5pt solid windowtext;
	border-bottom:.5pt solid windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl1214118
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:"Trebuchet MS", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:left;
	vertical-align:bottom;
	border-top:.5pt solid windowtext;
	border-right:none;
	border-bottom:none;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl1224118
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:windowtext;
	font-size:14.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:underline;
	text-underline-style:single;
	font-family:"Trebuchet MS", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:bottom;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl1234118
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:"Trebuchet MS", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl1244118
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:"Trebuchet MS", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:1.0pt solid windowtext;
	border-right:none;
	border-bottom:none;
	border-left:1.0pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl1254118
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:"Trebuchet MS", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:1.0pt solid windowtext;
	border-right:none;
	border-bottom:none;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl1264118
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:"Trebuchet MS", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:1.0pt solid windowtext;
	border-right:1.0pt solid windowtext;
	border-bottom:none;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl1274118
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:"Trebuchet MS", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:none;
	border-right:none;
	border-bottom:none;
	border-left:1.0pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl1284118
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:"Trebuchet MS", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:none;
	border-right:1.0pt solid windowtext;
	border-bottom:none;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl1294118
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:"Trebuchet MS", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:none;
	border-right:none;
	border-bottom:1.0pt solid windowtext;
	border-left:1.0pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl1304118
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:"Trebuchet MS", sans-serif;
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
.xl1314118
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:"Trebuchet MS", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	border-top:none;
	border-right:1.0pt solid windowtext;
	border-bottom:1.0pt solid windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
-->
body{
	zoom:82%;
}

</style>

<style type="text/css">
@page
{
	size: potrait;
	margin: 0cm;
}
</style>

<style>

@media print {
    @page { margin: 0; }
@page narrow {size: 9in 11in}
@page rotated {size: landscape}
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

<script>
function printpr()
{
	//window.print();
}
</script>

<script src="../../common/js/jquery-1.3.2.js"></script>
<script src="../../common/js/jquery-barcode-2.0.1.js"></script>

</head>

<body onload="printpr();">

<script language="JavaScript"> 
</script>
<div style='height:50px'><br/><br/></div>
<div id="DOCKET_NEW_4118" align=center x:publishsource="Excel">
<table border=0 cellpadding=0 cellspacing=0 style='border-collapse: collapse;width:1000px'>
 <col width=24 style='mso-width-source:userset;mso-width-alt:877;width:18pt'>
 <col class=xl654118 width=64 span=6 style='mso-width-source:userset;
 mso-width-alt:2340;width:48pt'>
 <col class=xl654118 width=67 style='mso-width-source:userset;mso-width-alt:
 2450;width:50pt'>
 <col class=xl654118 width=64 span=5 style='mso-width-source:userset;
 mso-width-alt:2340;width:48pt'>
 <col width=64 span=3 style='width:48pt'>
 <col width=21 style='mso-width-source:userset;mso-width-alt:768;width:16pt'>
 <tr height=21 style='mso-height-source:userset;height:15.75pt'>
  <td height=21 class=xl664118 width=24 style='height:15.75pt;width:18pt' colspan="8"><a
  name="RANGE!A1:Q57"></a><?php echo '<div id="bcTarget1" style="width:auto;"></div><script>$("#bcTarget1").barcode("D'.$doc_id.'", "code39",{barWidth:2,barHeight:30,moduleSize:5,fontSize:5});</script>'; ?></td>
  <td class=xl654118 width=64 style='width:48pt'></td>
  <td class=xl654118 width=64 style='width:48pt'></td>
  <td class=xl654118 width=64 style='width:48pt'></td>
  <td class=xl654118 width=64 style='width:48pt'></td>
  <td class=xl654118 width=64 style='width:48pt'></td>
  <td class=xl654118 width=64 style='width:48pt'></td>
  <td class=xl154118 width=64 style='width:48pt'></td>
  <td class=xl154118 width=64 style='width:48pt'></td>
  <td class=xl154118 width=21 style='width:16pt'></td>
 </tr>
 <tr class=xl654118 height=20 style='mso-height-source:userset;height:15.0pt'>

 </tr>

 <tr class=xl654118 height=20 style='mso-height-source:userset;height:15.0pt'>
 <td colspan=6 rowspan=3 class=xl8217319x valign="top" align="left"><img src="<?= $logo ?>" width="200" height="60"></td>
  <td height=20 class=xl654118 style='height:15.0pt'></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td colspan=2 >Cutting Department</td>
  <td class=xl654118></td>
  </tr>
 <tr class=xl654118 height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl654118 style='height:15.0pt'></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
 </tr>
 <tr class=xl654118 height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl654118 style='height:15.0pt'></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
 </tr>
 <tr class=xl654118 height=26 style='mso-height-source:userset;height:19.5pt'>
  <td height=26 class=xl654118 style='height:19.5pt'></td>
  <td class=xl654118></td>
  <td class=xl1014118></td>
  <td class=xl1014118></td>
  <td class=xl1014118></td>
  <td class=xl1014118></td>
  <td colspan=3 style='font-size:24px;font-weight:bold'>Cutting Docket</td>
  <td class=xl1014118></td>
  <td class=xl1014118></td>
  <td colspan=2 style='border-right:1px solid black;font-size:20px;font-weight:bold;text-align:right' style='border-right:.5pt solid black'>Docket
  Number</td>
  <td colspan=3 class=xl1024118 style='border-right:.5pt solid black;
  border-left:none'><?php echo $doc_num; ?></td>
  <td class=xl654118></td>
 </tr>
 <tr class=xl654118 height=23 style='mso-height-source:userset;height:17.25pt'>
  <td height=23 class=xl654118 style='height:17.25pt'></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118 colspan=3 align=center><strong><?php 
	// if($print==1)
	// {
		// if($print_status=='0000-00-00' || $print_status == "") {echo "ORIGINAL"; } else {echo "DUPLICATE";}
	// }
	// else
	// {	
		// {echo "CUTTING"; }
	// }
	if($printstatus=='Allocated')
	{
		echo "ORIGINAL";
	}
	else
	{
		echo "DUPLICATE";
	}
	?>
  <td class=xl654118></td>
 </tr>
 <tr class=xl654118 height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl654118 style='height:15.0pt'></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
 </tr>
 <tr class=xl654118 height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl654118 style='height:15.0pt'></td>
  <td class=xl914118>Cut No :</td>
  <td colspan=2 class=xl1214118>
  N/A
  <!---<?php 
  // if($remarks=="Normal") { 
	// echo chr($color_code).leading_zeros($cutno, 3); 
  // }elseif(strtolower($remarks)=="recut"){ 
	// echo "R".leading_zeros($cutno, 3);
  // }elseif($remarks=="Pilot"){ 
	// echo "Pilot";
  // }
  ?>--->
  </td>
  <td class=xl924118>Date:</td>
  <td class=xl944118><?php echo $created_at; ?></td>
  <td class=xl964118></td>
  <td colspan=2 class=xl914118>Category :</td>
  <td colspan=2 class=xl1214118>Normal</td>
  <td  colspan=2 class=xl984118></td>
  <td colspan=2 class='xl984118 right'></td>
 </tr>
 <tr class=xl654118 height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl654118 style='height:15.0pt'></td>
  <td class=xl904118>Style No :</td>
  <td colspan=2 class=xl954118 style='border-right:.5pt solid black'><?php echo $style; ?></td>
  <td class=xl904118x>Module:</td>
  <td class=xl954118>N/A</td>	
  <td class=xl904118></td>
  <td colspan=2 class=xl904118>Fab Code :</td>
  <td colspan=4 class=xl954118><?php echo $compo_no ?></td>
  <td class=xl654118></td>
  <td class='xl654118 right'></td>
 </tr>
 <tr class=xl654118 height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl654118 style='height:15.0pt'></td>
  <td class=xl904118>Sch No :</td>
  <td colspan=2 class=xl954118 style='border-right:.5pt solid black'><?php echo implode(",",$schedule); ?></td>
  <td class=xl904118x>Consumption:</td>
  <td class=xl954118><?php echo $consumption; ?></td>
  <td class=xl904118></td>
  <td colspan=2 class=xl904118>Fab Descrip :</td>
  <td colspan=6 style='padding-top : 12px;border-right:.5pt solid black'><?php echo $fab_des; ?></td>
 </tr>
 <tr class=xl654118 height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl654118 style='height:15.0pt'></td>
  <td class=xl904118>Color :</td>
  <td colspan=4 style='padding-top : 12px;border-right:.5pt solid black;font-size:18px'><?php echo $fg_color." / ".$fab_des; ?></td>
  <td class=xl954118></td>
  <td colspan=2 class=xl904118>MK Name :</td>
  <td colspan=4 class=xl954118>N/A</td>
  <td class=xl654118></td>
  <td class='xl654118 right'></td>
 </tr>
 <tr class=xl654118 height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl654118 style='height:15.0pt'></td>
  <td class=xl934118>CO :</td>
  <td colspan=4 class=xl1194118 style='border-right:.5pt solid black'><?php echo $pono; ?></td>
  <td class=xl974118></td>
  <td colspan=2 class=xl934118>Fab Direction :</td>
  <td colspan=5 class=xl1104118 >N/A</td>
  <td class='xl1104118 right'></td>
 </tr>

 <tr class=xl674118 height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl674118 style='height:15.0pt'></td>
  <td rowspan="2" colspan="11" class=xl764118 style='border-bottom:.5pt solid black;' >(Docket - Cut No):
 
  </td>
 </tr>
 
 <tr class=xl654118 height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl654118 style='height:15.0pt'></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl674118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
 </tr>

 <tr class=xl654118 height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl654118 style='height:15.0pt'></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl674118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
 </tr>
  	 <?php
		 //$fab_uom = $fab_uom;
		 $temp = 0;
		 $temp_len1 = 0;
		 $temp_len = 0;
	 ?>
	<tr class=xl654118 height=20 style='mso-height-source:userset;height:10.0pt'>
	  <td height=20 class=xl654118 style='height:10.0pt'></td>
	  <?php
		// if($flag == 1)
		// {
			
			// //number of sizes-which excludes null
			// $total_size = sizeof($size_tit);
			// //echo $total_size;
			// // $total_size = 50;
			// for($s=0;$s<$total_size;$s++)
			// {
				
			// 	if($temp == 0){
			// 		echo "<td class=xl654118>Size</td>";
			// 		$temp = 1;
			// 	}
			// 	echo  "<td class=xl694118>".$size_tit[$s]."</td>";
			// 	if(($s+1) % $divide == 0){
			// 		$temp_len = $s+1;
			// 		echo "</tr>";
			// 		echo "<tr class=xl654118 height=20 style='mso-height-source:userset;height:10.0pt'>
			// 			<td height=20 class=xl654118 style='height:10.0pt'></td>
			// 			<td class=xl654118>Ratio</td>";
			// 		for($i=$temp_len1;$i<$total_size;$i++) {
			// 				echo "<td class=xl734118>N/A</td>";
			// 			}
			// 		echo "</tr>";
			// 		echo "<tr class=xl654118 height=20 style='mso-height-source:userset;height:10.0pt'>
			// 		<td height=20 class=xl654118 style='height:10.0pt'></td>
			// 		<td class=xl654118>Quantity</td>";
			// 		for($i=0;$i<$total_size;$i++) {
			// 			echo "<td class=xl734118 >".($ratioof[$i])."</td>";
			// 		}
			// 		echo "</tr>";
			// 		echo "<tr class=xl654118 height=20 style='mso-height-source:userset;height:10.0pt'></tr><td></td>";
			// 		$temp = 0;
			// 		$temp_len1=$temp_len;
			// 	}
			// 	// echo $s.'=='.$total_size;
				
			// 		echo "<td class=xl714118>Total</td></tr><tr class=xl654118 height=20 style='mso-height-source:userset;height:10.0pt'><td height=20 class=xl654118 style='height:10.0pt'></td><td class=xl654118>Ratio</td>";
			// 		for($i=$temp_len1;$i<$total_size;$i++) {
			// 			echo "<td class=xl734118>N/A</td>";
			// 		}
			// 		echo "<td class=xl754118>N/A</td>";
			// 		echo "</tr>";
			// 		echo "<tr class=xl654118 height=20 style='mso-height-source:userset;height:10.0pt'>
			// 		<td height=20 class=xl654118 style='height:10.0pt'></td>
			// 		<td class=xl654118>Quantity</td>";
			// 		for($i=$temp_len1;$i<$total_size;$i++) {
			// 			echo "<td class=xl734118 >".($ratioof[$i]*$plies)."</td>";
			// 		}
			// 		echo "<td class=xl754118>".(array_sum($ratioof)*$plies)."</td>";
			// 		echo "</tr>";
				
			// }
		// }
	  ?>
	  </tr>
	  <tr class=xl654118 height=20 style='mso-height-source:userset;height:15.0pt'>
		<td height=20 class=xl654118 style='height:15.0pt'></td>
		<td class=xl654118></td>
		<td class=xl654118></td>
		<td class=xl654118></td>
		<td class=xl654118></td>
		<td class=xl654118></td>
		<td class=xl654118></td>
		<td class=xl654118></td>
		<td class=xl654118></td>
		<td class=xl654118></td>
		<td class=xl674118></td>
		<td class=xl654118></td>
		<td class=xl654118></td>
		<td class=xl654118></td>
		<td class=xl654118></td>
		<td class=xl654118></td>
		<td class=xl654118></td>
	</tr>
 </table>
 
 <table border=0 cellpadding=0 cellspacing=0 align='left' style='border-collapse: collapse;height:10.00pt'>
 <tr>
  <td rowspan=2 class=xl764118 style='border-bottom:1px solid black'>Rpt No</td>
  <td rowspan=2 class=xl774118  width=64 style='border-bottom:.5pt solid black;  width:48pt'>Pattern Version</td>
  <td rowspan=2 class=xl1144118 width=64 style='border-bottom:.5pt solid black;  width:70pt'>No of Plies</td>
  <td rowspan=2 class=xl1144118 width=64 style='border-bottom:.5pt solid black;  width:48pt'>Pur Width</td>
  <td rowspan=2 class=xl1144118 width=64 style='border-bottom:.5pt solid black;  width:48pt'>Lay Length</td>
  <td rowspan=2 class=xl1144118 width=64 style='border-bottom:.5pt solid black;  width:48pt'>Cutting Wastage %</td>
  <td rowspan=2 class=xl1144118 width=64 style='border-bottom:.5pt solid black;  width:48pt'>Binding Cons.</td>
  <td rowspan=2 class=xl1144118 width=64 style='border-bottom:.5pt solid black;  width:90pt'>Fab. Requirement for lay</td>
  <td rowspan=2 class=xl1144118 width=64 style='border-bottom:.5pt solid black;  width:90pt'>Fab. Requirement for Binding</td>
  <td rowspan=2 class=xl1144118 width=64 style='border-bottom:.5pt solid black;  width:48pt'>Total Fab. Requirement</td>
  <td rowspan=2 class=xl1144118 width=67 style='border-bottom:.5pt solid black;  width:70pt'>Act. Width</td>
  <td rowspan=2 class=xl1144118 width=67 style='border-bottom:.5pt solid black;  width:70pt'>Revised Marker Length</td>
  <td rowspan=2 class=xl1144118 width=64 style='border-bottom:.5pt solid black;  width:48pt'>Revised Total Fab. Requirement</td>
  <td rowspan=2 class=xl1144118 width=64 style='border-bottom:.5pt solid black;  width:48pt'>Issued Qty (<?= $fab_uom ?>)</td>
  <td rowspan=2 class=xl1144118 width=64 style='border-bottom:.5pt solid black;  width:48pt'>Return Qty (<?= $fab_uom ?>)</td>

  <td rowspan=4 colspan=10 class=xl1144118 width=64 style='border-bottom:.6pt solid black'></td>
  <td class=xl674118></td>
  <td class=xl674118></td>
  <td class=xl674118></td>
  <td class=xl674118></td>
  <td class=xl674118></td>
  <td class=xl674118></td>
 </tr>
 <tr class=xl674118 height=20 style='mso-height-source:userset;height:15.0pt'>

 </tr>
  <td rowspan=2 class=xl1184118 width=64 style='border-bottom:.5pt solid black;  border-top:none;width:48pt'>&nbsp;</td>
  <td rowspan=2 class=xl1184118 width=64 style='border-bottom:.5pt solid black;  border-top:none;width:48pt'>N/A</td>
  <td rowspan=2 class=xl1124118 width=64 style='border-bottom:.5pt solid black;  border-top:none;width:70pt'>N/A</td>
  <td rowspan=2 class=xl1124118 width=64 style='border-bottom:.5pt solid black;  border-top:none;width:48pt'><?php echo $purwidth; ?></td>
  <td rowspan=2 class=xl1184118 width=64 style='border-bottom:.5pt solid black;  border-top:none;width:48pt'>N/A</td>
  <td rowspan=2 class=xl1184118 width=64 style='border-bottom:.5pt solid black;  border-top:none;width:48pt'>N/A</td>
  <td rowspan=2 class=xl1184118 width=64 style='border-bottom:.5pt solid black;  border-top:none;width:48pt'><?php echo $consumption; ?></td>
  <td rowspan=2 class=xl1124118 width=64 style='border-bottom:.5pt solid black;  border-top:none;width:48pt'>N/A</td>
  <td rowspan=2 class=xl1124118 width=64 style='border-bottom:.5pt solid black;  border-top:none;width:48pt'><?php $fab_bind = $consumption*array_sum($ratioof); echo round($fab_bind,2).'<br/>('.$fab_uom.')'; ?></td>
  <td rowspan=2 class=xl1124118 width=64 style='border-bottom:.5pt solid black;  border-top:none;width:48pt'><?php echo round($fab_bind+$fab_lay,2).'<br/>('.$fab_uom.')'; ?></td>
  <td rowspan=2 class=xl1124118 width=67 style='border-bottom:.5pt solid black;  border-top:none;width:50pt'><?php echo $actwidth; ?></td> 
  <td rowspan=2 class=xl1124118 width=67 style='border-bottom:.5pt solid black;  border-top:none;width:50pt'><?php echo $length; ?></td>
  <td rowspan=2 class=xl1124118 width=64 style='border-bottom:.5pt solid black;  border-top:none;width:48pt'><?php if($length > 0){$fab_revised_lay = $length*(1+$wastage)*$plies; echo round($fab_revised_lay+$fab_bind,2).'<br/>('.$fab_uom.')';} else { echo "0";}?></td>
<!--<td rowspan=2 class=xl1124118 width=64 style='border-bottom:.5pt solid black;
  border-top:none;width:48pt'><?php //if(substr($style,0,1)=="M") 
{ $extra=round((($length*$plies)*$savings),2); }  echo round((($length*$plies)+$extra+$bind_con),2); //Extra 1% added to avoid cad saving manual mrn claims. ?></td>-->
  <td rowspan=2 class=xl1124118 width=64 style='border-bottom:.5pt solid black;
  border-top:none;width:48pt'>&nbsp;</td>
  <td rowspan=2 class=xl1124118 width=64 style='border-bottom:.5pt solid black;
  border-top:none;width:48pt'>&nbsp;</td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
 </tr>
 <tr class=xl654118 height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl654118 style='height:15.0pt'></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
 </tr>
 <tr class=xl654118 height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl654118 style='height:15.0pt'></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
 </tr>
 

<table>

<table border=0 cellpadding=0 cellspacing=0 align='left' style='border-collapse: collapse;width:auto'>
 <tr class=xl674118 height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl674118 style='height:15.0pt'></td>
  <td rowspan="2" colspan="11" class=xl764118 style='border-bottom:.5pt solid black;' >Inspection Comments:
  
  <?php

 $sql1="select jm_docket_line_id from $pps.jm_docket_lines where docket_line_number=$doc_num and plant_code='$plant_code'";
 $sql_result1=mysqli_query($link, $sql1) or exit("Sql Error at inspection123".mysqli_error($GLOBALS["___mysqli_ston"]));
 while($sql_row1=mysqli_fetch_array($sql_result1))
 {
	 $doc_num=$sql_row1["jm_docket_line_id"];
 }
//function to get docket 
$doc=4;
$doc_ype="normal";
if($doc_num!='' && $doc_ype!='' && $plant_code!=''){
	$result_docketinfo=getDocketInfo($doc_num,$doc_ype,$plant_code);
	$roll_det =$result_docketinfo['roll_det'];
	$width_det =$result_docketinfo['width_det'];
	$leng_det =$result_docketinfo['leng_det'];
	$batch_det =$result_docketinfo['batch_det'];
	$shade_det =$result_docketinfo['shade_det'];
	$location_det =$result_docketinfo['location_det'];
	$invoice_no =$result_docketinfo['invoice_no'];
	$locan_det =$result_docketinfo['locan_det'];
	$lot_det =$result_docketinfo['lot_det'];
	$roll_id =$result_docketinfo['roll_id'];
	$ctex_len =$result_docketinfo['ctex_len'];
	$tkt_len =$result_docketinfo['tkt_len'];
	$ctex_width =$result_docketinfo['ctex_width'];
	$tkt_width =$result_docketinfo['tkt_width'];
	$item_name =$result_docketinfo['item_name'];
}

  
  //echo ($bind_con>0)?"Binding/Rib Quantity: $bind_con YDS":"";
   if(sizeof($batch_det) > 0)
   {
	   	$rem="";
		$batchs=array();
	   	for($i=0;$i<sizeof($batch_det);$i++)
		{
			$batchs[]="'".$batch_det[$i]."'";
		}
	   
	    $batchs=array_unique($batchs);
	    $sql="select group_concat(sp_rem) as rem from $wms.inspection_db where batch_ref in (".implode(",",$batchs).")";
	    $sql_result=mysqli_query($link, $sql) or exit("Sql Error at inspection".mysqli_error($GLOBALS["___mysqli_ston"]));
	    while($sql_row=mysqli_fetch_array($sql_result))
	    {
	    	$rem=$sql_row["rem"];
	    }
	    echo $rem;
   }

?>
  </td>
  	<td class=xl654118>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
  	<td class=xl654118>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td class=xl654118 colspan="3"><u><strong>Quality Authorisation</strong></u></td>
 </tr>
<tr class=xl674118 height=20 style='mso-height-source:userset;height:15.0pt'></tr>
 <tr class=xl674118 height=20 style='mso-height-source:userset;height:15.0pt'>
 <td height=20 class=xl674118 style='height:15.0pt'></td>
 <!--<td rowspan="2" colspan="15" class=xl764118 style='border-bottom:.5pt solid black;'>-->
 <?php
 $roll_length = array();
//  $roll_det = array();
//  $sql123="SELECT ref2,ref4,SUM(allocated_qty) AS shade_lengt FROM $wms.docket_ref WHERE doc_no=\"B".$bindid."\" AND doc_type='normal' GROUP BY ref4";
//  echo  $sql123;
//  $sql_result123=mysqli_query($link, $sql123) or exit("Sql Error78".mysqli_error($GLOBALS["___mysqli_ston"]));
//  while($sql_row123=mysqli_fetch_array($sql_result123))
// {
// 	$roll_length[]=$sql_row123['ref2'];
// 	$shade_lengt[]=$sql_row123['shade_lengt'];
// 	$shade[]=$sql_row123['ref4'];
// }
 ?>
 <!--</td>-->
 </tr>
<tr class=xl674118 height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl674118 style='height:15.0pt'></td>
  <td class=xl764118 style='border-bottom:.5pt solid black;'>Shade</td>
  <td class=xl764118 colspan=3 style='border-bottom:.5pt solid black;'>Shade Wise Total Fab (<?= $fab_uom ?>)</td>
  <td class=xl764118 colspan=3 style='border-bottom:.5pt solid black;'>No of Plies from Shade</td>
  <td class=xl764118 colspan=4 style='border-bottom:.5pt solid black;'>Fabric from shade for Binding (<?= $fab_uom ?>)</td>
  <td class=xl654118>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td class=xl654118 colspan="3"><u><strong>Cutting Supervisor Authorization</strong></u></td>
</tr>

 <?php
  if(sizeof($roll_length)>0)
 {
	for($i=0;$i<sizeof($roll_length);$i++)
	{
	 ?>
		<tr class=xl654118 height=20 style='mso-height-source:userset;height:18.0pt'>
		  <td height=20 class=xl654118 style='height:18.0pt'></td>
		  <td class=xl804118 style='border-bottom:.5pt solid black;  width:48pt'><?php echo $shade[$i]; ?></td>
		  <td class=xl814118 colspan=3 style='border-bottom:.5pt solid black;  width:48pt'><?php echo round($shade_lengt[$i],2); ?></td>
		  <td class=xl814118 colspan=3 style='border-bottom:.5pt solid black;  width:48pt'>N/A</td>
		  <td class=xl804118 colspan=4><?php echo round((($shade_lengt[$i]/($purlength*(1+$cuttable_wastage)+($binding_con*$a_ratio_tot)))*$binding_con*$a_ratio_tot),2); ?></td>
		</tr>
	  <?php
	}
 }else{?> 
 	<tr class=xl654118 height=20 style='mso-height-source:userset;height:18.0pt'>
	  <td height=20 class=xl654118 style='height:18.0pt'></td>
	  <td class=xl804118 style='border-bottom:.5pt solid black;  width:48pt'>&nbsp;</td>
	  <td class=xl814118 colspan=3 style='border-bottom:.5pt solid black;  width:48pt'>&nbsp;</td>
	  <td class=xl814118 colspan=3 style='border-bottom:.5pt solid black;  width:48pt'>&nbsp;</td>
	  <td class=xl804118 colspan=4 style='border-bottom:.5pt solid black;  width:48pt'>&nbsp;</td>
	</tr>
 <?php }
 ?>
 
 
<tr class=xl674118 height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl674118 style='height:15.0pt'></td>
</tr>

<table border=0 cellpadding=0 cellspacing=0 align='left' style='border-collapse: collapse;width:auto'>
<tr class=xl674118 height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl674118 style='height:15.0pt'></td>
  <td class=xl764118>Batch</td>
  <td class='xl764118'>Fabric Name</td>
  <td class=xl764118>Lot No</td>
  
  <td class=xl764118>Shade</td>
  <td class=xl764118>Location</td>
  <td class=xl7742018>Roll</br>No</td>
  <td rowspan=2 class=xl1144118 width=64 style='border-bottom:.5pt solid black;  width:48pt'>Ticket Length</td>
  <td rowspan=2 class=xl1144118 width=64 style='border-bottom:.5pt solid black;  width:48pt'>C-tex<br/>Length</td>
  <td rowspan=2 class=xl1144118 width=64 style='border-bottom:.5pt solid black;  width:48pt'>C-tex<br/>Width</td>
  <td rowspan=2 class=xl1144118 width=64 style='border-bottom:.5pt solid black;  width:48pt'>Allocated Qty</td>
  <td class=xl774118>Plies</td>
  <td rowspan=2 class=xl1144118 width=64 style='border-bottom:.5pt solid black;  width:150pt'>Net<br/>Length</td>
  <td class=xl7742018 style="width: 108px;">Damage</td>
  <td class=xl7742018 style="width: 85px;">Joints</td>
  <td class=xl7742018 style="width: 85px;">Ends</td>

  <td colspan=2 class=xl1064118 style="width: 122px;">Shortages</td>
  <td rowspan=2 class=xl1144118 width=64 style='border-bottom:.5pt solid black;  width:48pt'>Binding Length</td>  
  <td colspan=3 rowspan=2 class=xl1064118>Comments</td>
 </tr> <tr class=xl674118 height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl674118 style='height:15.0pt'></td>
  <td class=xl724118>&nbsp;</td>
  <td class=xl744118>&nbsp;</td>
  <td class=xl744118>&nbsp;</td>

  <td class=xl744118>&nbsp;</td>
  <td class=xl744118>&nbsp;</td>
  <td class=xl744118>&nbsp;</td>
  <td class=xl744118><b>Excess</b></td>
  <td class=xl744118>&nbsp;</td>
  <td class=xl744118>&nbsp;</td>
  <td class=xl744118>&nbsp;</td>
  <td class=xl744118>+</td>
  <td class=xl744118>-</td>
  <!--<td class=xl744118>&nbsp;</td>
  <td class=xl744118>&nbsp;</td>
  <td class=xl744118>&nbsp;</td>
  <td class=xl674118></td>-->
 </tr>
 <?php
 //$count=sizeof($roll_det);
 //echo $count."<br>";
 $total='';
 
$tot_tick_len=0;
$tot_ctex_len=0;
$tot_alloc_qty=0;
$tot_bind_len=0;
 
 if(sizeof($roll_det)>0)
 {
	 for($i=0;$i<sizeof($roll_det);$i++)
	 {
	 ?>
	  <tr class=xl654118 height=30 style='mso-height-source:userset;height:30pt'>
	  <td height=20 class=xl654118 style='height:30pt'></td>
	  <td class=xl804118><?php echo $batch_det[$i]; ?></td>
	  <td class=xl804118><?php echo $item_name[$i]; ?></td>
	  <td class=xl814118 style='font-size: 100%;'><?php echo $lot_det[$i]; ?></td>
	
	  <td class=xl814118><?php echo $shade_det[$i]; ?></td>
	  <td class=xl814118><?php echo $location_det[$i]; ?></td>
	  <td class=xl814118><?php echo $roll_det[$i]; ?></td>
	  <td class=xl814118 style='text-align:right;padding-bottom:5pt;'><?php echo $tkt_len[$i]; $tot_tick_len=$tot_tick_len+$tkt_len[$i];?></td>
	  <td class=xl814118 style='text-align:right;padding-bottom:5pt;'><?php echo $ctex_len[$i]; $tot_ctex_len=$tot_ctex_len+$ctex_len[$i];?></td>
	  <td class=xl814118 style='text-align:right;padding-bottom:5pt;'><?php echo $ctex_width[$i]; ?></td>
	  <td class=xl814118 style='text-align:right;padding-bottom:5pt;'><?php echo $leng_det[$i]; $tot_alloc_qty=$tot_alloc_qty+$leng_det[$i];?></td>
	  <td class=xl814118 style='text-align:right;padding-bottom:5pt;'>&nbsp;</td>
	  <td class=xl814118 style='text-align:right;padding-bottom:5pt;'>&nbsp;</td>
	  <td class=xl814118>&nbsp;</td>
	  <td class=xl814118>&nbsp;</td>
	  <td class=xl814118>&nbsp;</td>
	  <td class=xl814118>&nbsp;</td>
	  <td class=xl814118>&nbsp;</td>
	  <td colspan=1 class=xl684118 style='text-align:right;padding-bottom:5pt;'><?php echo round(($leng_det[$i]*$binding_con*$a_ratio_tot),2); $tot_bind_len=$tot_bind_len+($leng_det[$i]*$binding_con*$a_ratio_tot);?></td>
	  <td colspan=3 class=xl684118 style='border-left:none'></td>
	  <td class=xl654118></td>
	  </tr>
	  <?php
	  		// $total=0;
	  		// $total+=$leng_det[$i];
	  		// $leng_det[$i];	
	   }
	 for($i =0; $i<16-sizeof($roll_det); $i++){
	?>
		<tr class=xl654118 height=30 style='mso-height-source:userset;height:30pt'>
	  <td height=20 class=xl654118 style='height:30pt'></td>
	  <td class=xl804118></td>
	  <td class=xl804118></td>
	  <td class=xl814118 style='font-size: 100%;'></td>
	
	  <td class=xl814118></td>
	  <td class=xl814118></td>
	  <td class=xl814118></td>
	  <td class=xl814118></td>
	  <td class=xl814118></td>
	  <td class=xl814118></td>
	  <td class=xl814118></td>
	  <td class=xl814118></td>
	  <td class=xl814118></td>
	  <td class=xl814118></td>
	  <td class=xl814118></td>
	  <td class=xl814118></td>
	  <td class=xl814118></td>
	  <td class=xl814118></td>
	  <td colspan=1 class=xl684118></td>
	  <td colspan=3 class=xl684118 style='border-left:none'></td>
	  <td class=xl654118></td>
	  </tr>
	<?php
	 }
 ?>
 			 <tr>
	<td colspan=7 class=xl684118>Total </td>
	<?php
	// for($i=0;$i<sizeof($roll_det);$i++)
	// {
		echo "<td class=xl814118 style='text-align:right;padding-bottom:5pt;'>".$tot_tick_len."</td>
			  <td class=xl814118 style='text-align:right;padding-bottom:5pt;'>".$tot_ctex_len."</td>
			  <td class=xl814118></td>
			  <td class=xl814118 style='text-align:right;padding-bottom:5pt;'>".$tot_alloc_qty."</td>
			  <td class=xl814118></td>
			  <td class=xl814118></td>
			  <td class=xl814118></td>
			  <td class=xl814118></td>
			  <td class=xl814118></td>
			  <td class=xl814118></td>
			  <td class=xl814118></td>
			  <td class=xl814118 style='text-align:right;padding-bottom:5pt;'>".$tot_bind_len."</td>
			  <td class=xl814118></td>";
	// }
	?>
	</tr>
<?php
 }
 else {
	 for($i =0; $i<16; $i++){
	?>
		<tr class=xl654118 height=30 style='mso-height-source:userset;height:30pt'>
	  <td height=20 class=xl654118 style='height:30pt'></td>
	  <td class=xl804118></td>
	  <td class=xl804118></td>
	  <td class=xl814118 style='font-size: 100%;'></td>
	  
	  <td class=xl814118></td>
	  <td class=xl814118></td>
	  <td class=xl814118></td>
	  <td class=xl814118></td>
	  <td class=xl814118></td>
	  <td class=xl814118></td>
	  <td class=xl814118></td>
	  <td class=xl814118></td>
	  <td class=xl814118></td>
	  <td class=xl814118></td>
	  <td class=xl814118></td>
	  <td class=xl814118></td>
	  <td class=xl814118></td>
	  <td class=xl814118></td>
	  <td colspan=1 class=xl684118></td>
	  <td colspan=3 class=xl684118 style='border-left:none'></td>
	  <td class=xl654118></td>
	  </tr>
	<?php
	 }
	 ?>
	 <tr>
	<td colspan=7 class=xl684118>Total </td>
	<?php
	// for($i=0;$i<sizeof($roll_det);$i++)
	// {
		echo "<td class=xl814118 style='text-align:right;padding-bottom:5pt;'>".$tot_tick_len."</td>
			  <td class=xl814118 style='text-align:right;padding-bottom:5pt;'>".$tot_ctex_len."</td>
			  <td class=xl814118></td>
			  <td class=xl814118 style='text-align:right;padding-bottom:5pt;'>".$tot_alloc_qty."</td>
			  <td class=xl814118></td>
			  <td class=xl814118></td>
			  <td class=xl814118></td>
			  <td class=xl814118></td>
			  <td class=xl814118></td>
			  <td class=xl814118></td>
			  <td class=xl814118></td>
			  <td class=xl814118 style='text-align:right;padding-bottom:5pt;'>".$tot_bind_len."</td>
			  <td class=xl814118></td>";
	// }
	?>
	</tr>
	 <?php	
 }
?>

 <tr class=xl654118 height=20 style='mso-height-source:userset;height:30pt'>
  <td height=20 class=xl654118 style='height:15.0pt'></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
 </tr>

 <tr class=xl654118 height=20 style='mso-height-source:userset;height:30pt'>
  <td height=20 class=xl654118 style='height:30pt'></td>
  <th class=xl654118></th>
  <th class=xl684118>Docket</th>
  <th class=xl704118>Marker</th>
  <th class=xl704118 style='width:100px'>Issuing</th>
  <th class=xl704118>Laying</th>
  <th class=xl704118>Cutting</th>
  <th class=xl704118>Return</th>
  <th class=xl704118>Bundling</th>
  <th class=xl704118>Dispatch</th>
  <th></th>
  <th class=xl654118>Remark 1:<td height=20 class=xl654118 style='height:15.0pt'><u><?php echo $remark1?></u></td></th>
  <th></th>
  
 </tr>
 <tr class=xl654118 height=30 style='mso-height-source:userset;height:30pt'>
  <td height=20 class=xl654118 style='height:15.0pt'></td>
  <td class=xl654118>Team</td>
  <td class=xl804118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td></td>
  <th class=xl654118>Remark 2:<td height=20 class=xl654118 style='height:15.0pt'><u><?php echo $remark2?></u></td></th>
 </tr>
 <tr class=xl654118 height=20 style='mso-height-source:userset;height:30pt'>
  <td height=20 class=xl654118 style='height:30pt'></td>
  <td class=xl654118>EMP No1</td>
  <td class=xl804118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td></td>
  <th class=xl654118>Remark 3:<td height=20 class=xl654118 style='height:15.0pt'><u><?php echo $remark3?></u></td></th>
 </tr>
 <tr class=xl654118 height=30 style='mso-height-source:userset;height:30pt'>
  <td height=20 class=xl654118 style='height:15.0pt'></td>
  <td class=xl654118>Emp No2</td>
  <td class=xl804118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td></td>
  <th class=xl654118>Remark 4:<td height=20 class=xl654118 style='height:15.0pt'><u><?php echo $remark4?></u></td></th>
 </tr>
 <tr class=xl654118 height=30 style='mso-height-source:userset;height:30pt'>
  <td height=20 class=xl654118 style='height:15.0pt'></td>
  <td class=xl654118>Emp No3</td>
  <td class=xl804118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl654118></td>
 
  <td class=xl654118>Act Con</td>
  <td class=xl894118 style='border-top:none'>&nbsp;</td>
  <td class=xl894118 style='border-top:none'>&nbsp;</td>
  <td class=xl894118 style='border-top:none'>&nbsp;</td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
 </tr>
 <tr class=xl654118 height=30 style='mso-height-source:userset;height:30pt'>
  <td height=20 class=xl654118 style='height:15.0pt'></td>
  <td class=xl654118>Date</td>
  <td class=xl804118><?php //echo date("y/m/d",strtotime($plan_log_time)); ?></td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl654118></td>
  <td class=xl654118>Saving %</td>
  <td class=xl894118 style='border-top:none'>&nbsp;</td>
  <td class=xl894118 style='border-top:none'>&nbsp;</td>
  <td class=xl894118 style='border-top:none'>&nbsp;</td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
 </tr>
 <tr class=xl654118 height=30 style='mso-height-source:userset;height:30pt'>
  <td height=20 class=xl654118 style='height:30pt'></td>
  <td class=xl654118>Time</td>
  <td class=xl804118><?php //echo date("H:i",strtotime($plan_log_time)); ?></td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl654118></td>

  <td class=xl654118>Reason</td>
  <td class=xl894118 style='border-top:none'>&nbsp;</td>
  <td class=xl894118 style='border-top:none'>&nbsp;</td>
  <td class=xl894118 style='border-top:none'>&nbsp;</td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
 </tr>
 <tr class=xl654118 height=30 style='mso-height-source:userset;height:30pt'>
  <td height=20 class=xl654118 style='height:30pt'></td>
  <td class=xl654118></td>
  <td class=xl804118><?php //echo date("H:i",strtotime($plan_log_time)); ?></td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl814118>&nbsp;</td>
  <td class=xl654118></td>

  <td class=xl654118>Approved</td>
  <td class=xl894118 style='border-top:none'>&nbsp;</td>
  <td class=xl894118 style='border-top:none'>&nbsp;</td>
  <td class=xl894118 style='border-top:none'>&nbsp;</td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
 </tr>
 <tr height=21 style='height:30pt'>
  <td height=21 class=xl154118 style='height:30pt'></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl154118></td>
  <td class=xl154118></td>
  <td class=xl154118></td>
  <td class=xl154118></td>
 </tr>
 <![if supportMisalignedColumns]>
 <tr height=0 style='display:none'>
  <td width=24 style='width:18pt'></td>
  <td width=64 style='width:48pt'></td>
  <td width=64 style='width:48pt'></td>
  <td width=64 style='width:48pt'></td>
  <td width=64 style='width:48pt'></td>
  <td width=64 style='width:48pt'></td>
  <td width=64 style='width:48pt'></td>
  <td width=67 style='width:50pt'></td>
  <td width=64 style='width:48pt'></td>
  <td width=64 style='width:48pt'></td>
  <td width=64 style='width:48pt'></td>
  <td width=64 style='width:48pt'></td>
  <td width=64 style='width:48pt'></td>
  <td width=64 style='width:48pt'></td>
  <td width=64 style='width:48pt'></td>
  <td width=64 style='width:48pt'></td>
  <td width=21 style='width:16pt'></td>
 </tr>
 <![endif]>
</table>

</div>

<!----------------------------->
<!--END OF OUTPUT FROM EXCEL PUBLISH AS WEB PAGE WIZARD-->
<!----------------------------->
</body>

</html>
<?php 

// if($print==1)
// {
	if($print_status=="0" || $print_status == "")
    {
		$sql="update $pps.requested_dockets set print_status=\"".date("Y-m-d")."\" where jm_docket_line_id='$doc_num'";
 	    // echo $sql;
	    mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	
    }
//}

//Refresh Parent Page After this Print Out 
echo"<script>
window.onunload = refreshParent;
function refreshParent() {
	window.opener.location.reload();
}
</script>"; 
?>
<style>
.xl744118,.xl694118,.xl774118,.xl684118,.xl704118,.xl724118,.xl1064118,.xl764118,.xl7742018,.xl804118,.xl674118,.xl654118,.xl1144118,.xl714118{
	font-size : 22px;
	font-weight : bold;
}
.xl754118,.xl914118,.xl694118,.xl734118,.xl734118,.xl934118,.xl1104118,.xl1194118,.xl1214118,.xl924118,.xl944118,.xl654118,.xl904118,.xl954118,.xl904118x,.xl904118,.xl1144118,.xl774118{
	font-size : 22px;
	font-weight : bold;
}
.xl804118,.xl684118,.xl764118,.xl7742018,.xl774118,.xl1064118,.xl704118,.xl654118,.xl1024118{
	font-size : 22px;
	font-weight : bold;
}
.xl664118{
	font-size : 24px;
	//font-weight : bold;
}
*{
	font-size : 20px;
}
tr{
	height : 30pt;
}
.xl734118{
	width : 50px;
}
td{
	vertical-align:top;
	height : 25pt;
}
.right{
	border-right : 1px solid black;
}
table { page-break-after:auto,page-break-inside:avoid; }
  tr    { page-break-inside:avoid; page-break-after:auto }
  td    { page-break-inside:avoid; }
  thead { display:table-header-group }
  tfoot { display:table-footer-group }
</style>

<script>
$(document).ready(function(){
	$("table tbody th, table tbody td").wrapInner("<div></div>");
});
</script>

