<!--

Ticket #: 252392-Kirang/2014-02-07
This amendement was done based on the confirmation to issue excess (1%) material depending on the savings.

Ticket #784780-kirang/2014-03-28
Chnaged the Data type from int to decimal for Capturing Actual Width in points mananer 
//Binding Consumption / YY Calculation //20151016-KIRANG-Imported Binding inclusive concept.

-->

<?php ini_set('error_reporting', E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED); ?>
<?php 
	include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config.php');
	include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/functions.php');
?>   
<?php
	for ($i=0; $i < sizeof($sizes_array); $i++)
	{
		$temp[]='$size'.$sizes_code[$i];
		$temp1[]='$sql_row["title_size_'.$sizes_array[$i].'"]';
		//echo $temp[$i].'='.$temp1[$i];
	}
	
$order_tid=$_GET['order_tid'];
$cat_ref=$_GET['cat_ref'];
$doc_id=$_GET['doc_id'];

$cat_title=$_GET['cat_title'];
$cut_no=$_GET['cut_no'];
$clubbing=$_GET['clubbing'];

// echo $order_tid;

$cut_table=array("0","T1","T1","T2","T2","T3","T3","T4","T4","T5","T5","T6","T6","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","T7","T7","T8","T8","T9","T9","T10","T10","T11","T11","T12","T12","","","","","","","","","","","","","","");

$color_codes=array();
$fab_codes=array();
$met_req=array();
$plies=array();
$qty=array();
$docs=array();
$cc_code=array();
$sch_color=array();//Schedule Color
$mk_files=array();



$sql="select * from $bai_pro3.bai_orders_db_confirm where order_tid=\"$order_tid\"";
// echo $sql;
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));

// var_dump($sql_result);
while($sql_row=mysqli_fetch_array($sql_result))
{
	$order_del_no=$sql_row['order_del_no'];
	$flag=$sql_row['title_flag'];
	for($i=0;$i<sizeof($sizes_array);$i++)
	{
		if($sql_row["title_size_".$sizes_array[$i].""]<>'')
		{
			$sizes_tit[]=$sql_row["title_size_".$sizes_array[$i].""];
		}
	}
}

$sql="select *,fn_savings_per_cal(DATE,cat_ref,order_del_no,order_col_des) as savings from $bai_pro3.order_cat_doc_mk_mix where clubbing=$clubbing and pcutno=$cut_no and category=\"$cat_title\" and order_del_no=$order_del_no and clubbing>0";
// echo $sql;
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row=mysqli_fetch_array($sql_result))
{
	$style=current(explode(" ",$sql_row['order_tid']));
	$schedule=$sql_row['order_del_no'];
	//$color_codes[]=$sql_row['order_col_des'];
	$color_codes[]=$sql_row['col_des'];
	$sch_color[]=$sql_row['order_col_des'];
	$fab_codes[]=trim($sql_row['compo_no'])."-".trim($sql_row['fab_des']);
	$gmtway=$sql_row['gmtway'];
	//Extra 1% added to avoid cad saving manual mrn claims.
	$mklength=$sql_row['mklength'];
	//if(substr($style,0,1)=="M") 
	$savings=$sql_row['savings'];
{ $extra=round((($sql_row['material_req'])*$savings),2); } 
	$met_req[]=$sql_row['material_req']+$extra;
	$plies[]=$sql_row['p_plies'];
	$docs[]=$sql_row['doc_no'];
	$cc_code[]=$sql_row['color_code'];
	$date=$sql_row['date'];
	$plan_module=$sql_row['plan_module'];
	$remarks=$sql_row['remarks'];
	$mk_files[]=$sql_row['mk_file'];
		
	for($i=0;$i<sizeof($sizes_tit);$i++)
	{
		$qty[]=$sql_row["p_".$sizes_array[$i].""];
	}	
	
	$mk_ref=$sql_row['mk_ref'];
	$allocate_ref=$sql_row['allocate_ref'];

}

$sql="select * from $bai_pro3.cat_stat_log where tid=$cat_ref";
mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_num_check=mysqli_num_rows($sql_result);
while($sql_row=mysqli_fetch_array($sql_result))
{
	$category=$sql_row['category'];
	$gmtway=$sql_row['gmtway'];
	$fab_des=$sql_row['fab_des'];
	$body_yy=$sql_row['catyy'];
	$waist_yy=$sql_row['waist_yy'];
	$leg_yy=$sql_row['leg_yy'];
	$purwidth=$sql_row['purwidth'];
	$compo_no=$sql_row['compo_no'];
	$strip_match=$sql_row['strip_match'];
	$gusset_sep=$sql_row['gusset_sep'];
	$patt_ver=$sql_row['patt_ver'];
	$col_des=$sql_row['col_des'];
}
//binding consumption
	if($category=='Body' || $category=='Front')
	{
		$sql2="select COALESCE(binding_con,0) as \"binding_con\" from $bai_pro3.bai_orders_db_remarks where order_tid=\"$order_tid\"";
		//echo $sql2;
		$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error bind".mysqli_error($GLOBALS["___mysqli_ston"]));
		$rows=mysqli_num_rows($sql_result2);
		if($rows > 0)
		{
			while($sql_row2=mysqli_fetch_array($sql_result2))
			{
				$binding_con = $sql_row2['binding_con'];
			}
		}
	}
	//echo 'binding '.$binding_con;

//cuttable wastage
	$sql="select cuttable_wastage from $bai_pro3.cuttable_stat_log where order_tid=\"$order_tid\" and cat_id=$cat_ref";
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error cuttable wastage".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_num_check=mysqli_num_rows($sql_result);
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		$cuttable_wastage = $sql_row['cuttable_wastage'];
	}
	//echo '  wastage '.$cuttable_wastage;
//ratio total ($a_ratio_tot variable)
	$sql="select * from $bai_pro3.plandoc_stat_log where order_tid=\"$order_tid\" and cat_ref=$cat_ref and doc_no=$doc_id";
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error total ratio".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_num_check=mysqli_num_rows($sql_result);
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		$mk_ref=$sql_row['mk_ref'];
		for($s=0;$s<sizeof($sizes_code);$s++)
		{
			//if($sql_row["a_s".$sizes_code[$s].""]>0)
			//{
			$a_s[$sizes_code[$s]]=$sql_row["a_s".$sizes_code[$s].""];
			//}
		}
			$a_s01=$sql_row['a_s01'];
			$a_s02=$sql_row['a_s02'];
			$a_s03=$sql_row['a_s03'];
			$a_s04=$sql_row['a_s04'];
			$a_s05=$sql_row['a_s05'];
			$a_s06=$sql_row['a_s06'];
			$a_s07=$sql_row['a_s07'];
			$a_s08=$sql_row['a_s08'];
			$a_s09=$sql_row['a_s09'];
			$a_s10=$sql_row['a_s10'];
			$a_s11=$sql_row['a_s11'];
			$a_s12=$sql_row['a_s12'];
			$a_s13=$sql_row['a_s13'];
			$a_s14=$sql_row['a_s14'];
			$a_s15=$sql_row['a_s15'];
			$a_s16=$sql_row['a_s16'];
			$a_s17=$sql_row['a_s17'];
			$a_s18=$sql_row['a_s18'];
			$a_s19=$sql_row['a_s19'];
			$a_s20=$sql_row['a_s20'];
			$a_s21=$sql_row['a_s21'];
			$a_s22=$sql_row['a_s22'];
			$a_s23=$sql_row['a_s23'];
			$a_s24=$sql_row['a_s24'];
			$a_s25=$sql_row['a_s25'];
			$a_s26=$sql_row['a_s26'];
			$a_s27=$sql_row['a_s27'];
			$a_s28=$sql_row['a_s28'];
			$a_s29=$sql_row['a_s29'];
			$a_s30=$sql_row['a_s30'];
			$a_s31=$sql_row['a_s31'];
			$a_s32=$sql_row['a_s32'];
			$a_s33=$sql_row['a_s33'];
			$a_s34=$sql_row['a_s34'];
			$a_s35=$sql_row['a_s35'];
			$a_s36=$sql_row['a_s36'];
			$a_s37=$sql_row['a_s37'];
			$a_s38=$sql_row['a_s38'];
			$a_s39=$sql_row['a_s39'];
			$a_s40=$sql_row['a_s40'];
			$a_s41=$sql_row['a_s41'];
			$a_s42=$sql_row['a_s42'];
			$a_s43=$sql_row['a_s43'];
			$a_s44=$sql_row['a_s44'];
			$a_s45=$sql_row['a_s45'];
			$a_s46=$sql_row['a_s46'];
			$a_s47=$sql_row['a_s47'];
			$a_s48=$sql_row['a_s48'];
			$a_s49=$sql_row['a_s49'];
			$a_s50=$sql_row['a_s50'];

			$a_ratio_tot=$a_s01+$a_s02+$a_s03+$a_s04+$a_s05+$a_s06+$a_s07+$a_s08+$a_s09+$a_s10+$a_s11+$a_s12+$a_s13+$a_s14+
						 $a_s15+$a_s16+$a_s17+$a_s18+$a_s19+$a_s20+$a_s21+$a_s22+$a_s23+$a_s24+$a_s25+$a_s26+$a_s27+$a_s28+$a_s29+
						 $a_s30+$a_s31+$a_s32+$a_s33+$a_s34+$a_s35+$a_s36+$a_s37+$a_s38+$a_s39+$a_s40+$a_s41+$a_s42+$a_s43+$a_s44+
						 $a_s45+$a_s46+$a_s47+$a_s48+$a_s49+$a_s50;
	}
	$sql2="select * from $bai_pro3.maker_stat_log where tid=$mk_ref";
//echo $sql2;
mysqli_query($link,$sql2) or exit("Sql Error".mysql_error());
$sql_result2=mysqli_query($link,$sql2) or exit("Sql Error".mysql_error());

while($sql_row2=mysqli_fetch_array($sql_result2))
{
	$mklength=$sql_row2['mklength'];
	$mk_remarks=$sql_row2['remarks'];
}
	//echo ' total '.$a_ratio_tot;
//echo implode(",",$docs);

//$sql="select min(roll_width) as width from bai_rm_pj1.fabric_cad_allocation where doc_no=".$doc_id." and doc_type=\"normal\"";

$idocs = "'" . implode ( "', '", $docs ) . "'";


$sql="select min(roll_width) as width from $bai_rm_pj1.fabric_cad_allocation where doc_no in ($idocs) and doc_type=\"normal\"";
 // echo $sql;
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row1x=mysqli_fetch_array($sql_result))
	{
		$system_width=round($sql_row1x['width'],2);
	}
	$actwidth=$system_width;

$sql22="select * from $bai_pro3.marker_ref_matrix where cat_ref=\"".$cat_ref."\" and allocate_ref=\"$allocate_ref\" and marker_width=$system_width";
//echo $sql22;
$sql_result22=mysqli_query($link, $sql22) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row22=mysqli_fetch_array($sql_result22))
{
	$actwidth=$sql_row22['marker_width'];
	$act_mk_length=$sql_row22['marker_length'];
}

$sql22="select * from $bai_pro3.marker_ref_matrix where  cat_ref=\"".$cat_ref."\" and allocate_ref=\"$allocate_ref\" and marker_width=\"$purwidth\"";
$sql_result22=mysqli_query($link, $sql22) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row22=mysqli_fetch_array($sql_result22))
{
	$purlength=$sql_row22['marker_length'];
}
if(mysqli_num_rows($sql_result22)==0)
{
	$purlength=$mklength;
}
?>



<html xmlns:o="urn:schemas-microsoft-com:office:office"
xmlns:x="urn:schemas-microsoft-com:office:excel"
xmlns="http://www.w3.org/TR/REC-html40">

<head>
<meta http-equiv=Content-Type content="text/html; charset=windows-1252">
<meta name=ProgId content=Excel.Sheet>
<meta name=Generator content="Microsoft Excel 14">
<link rel=File-List href="doc_designs_files/filelist.xml">
<style id="doc_designs_17319_Styles">
<!--table
	{mso-displayed-decimal-separator:"\.";
	mso-displayed-thousand-separator:"\,";}
.xl1517319
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
.xl6417319
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
.xl6517319
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
.xl6617319
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
.xl6717319
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
.xl6817319
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
.xl6917319
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
.xl7017319
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
	white-space:nowrap;}
.xl7117319
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
.xl7217319
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
.xl7317319
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
.xl7417319
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
.xl7517319
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
.xl7617319
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
.xl7717319
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
.xl7817319
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
.xl7917319
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
.xl8017319
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
.xl8117319
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
.xl8217319
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
.xl8217319x
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
	text-align:left;
	vertical-align:top;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl8317319
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
	border-right:none;
	border-bottom:.5pt solid windowtext;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl8417319
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
	border-right:none;
	border-bottom:.5pt solid windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl8517319
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
	border-top:none;
	border-right:none;
	border-bottom:.5pt solid windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl8617319
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
	border-right:none;
	border-bottom:.5pt solid windowtext;
	border-left:.5pt solid windowtext;
	background:silver;
	mso-pattern:black none;
	white-space:nowrap;}
.xl8717319
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
	border-right:none;
	border-bottom:.5pt solid windowtext;
	border-left:none;
	background:silver;
	mso-pattern:black none;
	white-space:nowrap;}
.xl8817319
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
	background:silver;
	mso-pattern:black none;
	white-space:nowrap;}
.xl8917319
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
.xl9017319
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
.xl9117319
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
	text-align:left;
	vertical-align:top;
	border-top:.5pt solid windowtext;
	border-right:none;
	border-bottom:none;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl9217319
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
	border-top:.5pt solid windowtext;
	border-right:none;
	border-bottom:none;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl9317319
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
	border-top:.5pt solid windowtext;
	border-right:.5pt solid windowtext;
	border-bottom:none;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl9417319
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
	border-top:none;
	border-right:none;
	border-bottom:.5pt solid windowtext;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl9517319
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
	border-top:none;
	border-right:.5pt solid windowtext;
	border-bottom:.5pt solid windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl9617319
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
.xl9717319
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
	border-bottom:.5pt solid windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl9817319
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
	border-bottom:none;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:normal;}
.xl9917319
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
.xl10017319
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
	border-top:.5pt solid black;
	border-right:.5pt solid windowtext;
	border-bottom:none;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:normal;}
.xl10117319
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
.xl10217319
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
.xl10317319
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
.xl10417319
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
.xl10517319
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
.xl10617319
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
.xl10717319
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
.xl10817319
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
.xl10917319
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
.xl11017319
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
.xl11117319
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
	white-space:normal;}
.xl11217319
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
	text-align:general;
	vertical-align:middle;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl11317319
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
.xl11417319
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
	text-align:general;
	vertical-align:bottom;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl11517319
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
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl11617319
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
	text-align:general;
	vertical-align:bottom;
	border-top:none;
	border-right:none;
	border-bottom:.5pt solid windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl11717319
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
	white-space:normal;}
-->
body{
	zoom:95%;
}

</style>

<style type="text/css">
@page
{
	size: landscape;
	margin: 0cm;
}
</style>

<style>

@media print {
@page narrow {size: 11in 9in}
@page rotated {size: potrait}
DIV {page: narrow}
TABLE {page: rotated}
#non-printable { display: none; }
#printable { display: block; }
#logo { display: block; }
body { zoom:95%;}
#ad{ display:none;}
#leftbar{ display:none;}
#Book2_14270{ width:95%;}
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

<script src='../../common/js/jquery-1.3.2.js'></script>
<script src='../../common/js/jquery-barcode-2.0.1.js'></script>

</head>

<body onload="printp();">
<!--[if !excel]>&nbsp;&nbsp;<![endif]-->
<!--The following information was generated by Microsoft Excel's Publish as Web
Page wizard.-->
<!--If the same item is republished from Excel, all information between the DIV
tags will be replaced.-->
<!----------------------------->
<!--START OF OUTPUT FROM EXCEL PUBLISH AS WEB PAGE WIZARD -->
<!----------------------------->

<div id="doc_designs_17319" align=center x:publishsource="Excel">

<table border=0 cellpadding=0 cellspacing=0 width=1800 style='border-collapse:
 collapse;table-layout:fixed;width:1300pt'>
 <col width=20 style='mso-width-source:userset;mso-width-alt:800;width:15pt'>
 <col width=64 span=16 style='width:48pt'>
 <col width=19 style='mso-width-source:userset;mso-width-alt:800;width:14pt'>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl1517319 width=20 style='height:15.0pt;width:15pt'><a
  name="RANGE!A1:R64"></a></td>
  <td class=xl1517319 width=64 style='width:48pt'></td>
  <td class=xl1517319 width=64 style='width:48pt'></td>
  <td class=xl1517319 width=64 style='width:48pt'></td>
  <td class=xl1517319 width=64 style='width:48pt'></td>
  <td class=xl1517319 width=64 style='width:48pt'></td>
  <td class=xl1517319 width=64 style='width:48pt'></td>
  <td class=xl1517319 width=64 style='width:48pt'></td>
  <td class=xl1517319 width=64 style='width:48pt'></td>
  <td class=xl1517319 width=64 style='width:48pt'></td>
  <td class=xl1517319 width=64 style='width:48pt'></td>
  <td class=xl1517319 width=64 style='width:48pt'></td>
  <td class=xl1517319 width=64 style='width:48pt'></td>
  <td class=xl1517319 width=64 style='width:48pt'></td>
  <td class=xl1517319 width=64 style='width:48pt'></td>
  <td class=xl1517319 width=64 style='width:48pt'></td>
  <td class=xl1517319 width=64 style='width:48pt'></td>
  <td class=xl1517319 width=19 style='width:14pt'></td>
 </tr>
 <tr height=25 style='height:18.75pt'>
  <td height=25 class=xl6417319 style='height:18.75pt'></td>
  <td colspan=6 rowspan=3 class=xl8217319x valign="top" align="left"><img src='../../common/images/BAI_Logo.jpg' width="120" height="60"></td>
  <td class=xl6417319></td>
  <td class=xl6417319></td>
  <!-- <td colspan=3 class=xl6617319>Cutting Docket</td> -->
  <td></td>
  <td class=xl6617319></td>
  <td class=xl6417319></td>
  <td colspan=3 class=xl7617319>Cutting Department</td>
  <td class=xl6417319></td>
 </tr>
 <tr height=21 style='height:15.75pt'>
  <td height=21 class=xl6417319 style='height:15.75pt'></td>
 
  <td colspan=3 class=xl6617319 height="25pt"><u>Cutting Docket</u></td>
  
  <td class=xl6417319></td>
  <td class=xl6417319></td>
  <td colspan=3 class=xl7617319></td>
  <td class=xl6417319></td>
 </tr>
 <tr height=21 style='height:15.75pt'>
  <td height=21 class=xl6417319 style='height:15.75pt'></td>
  <td class=xl6417319></td>
  <td class=xl6417319></td>
  <td class=xl6417319></td>
  <td class=xl6417319></td>
  <td class=xl6417319></td>
  <td class=xl6417319></td>
  <td class=xl6417319></td>
  <td class=xl6417319></td>
  <td class=xl6417319></td>
  <td class=xl6417319></td>
  <td class=xl6417319></td>
 </tr>
 <tr height=21 style='height:15.75pt'>
  <td height=21 class=xl6417319 style='height:15.75pt'></td>
  <td class=xl8217319></td>
  <td class=xl8217319></td>
  <td class=xl8217319></td>
  <td class=xl8217319></td>
  <td class=xl8217319></td>
  <td class=xl8217319></td>
  <td class=xl6417319></td>
  <td class=xl6417319></td>
  <td class=xl6417319></td>
  <td class=xl6417319></td>
  <td class=xl6417319></td>
  <td class=xl6417319></td>
  <td class=xl6417319></td>
  <td class=xl6417319></td>
  <td class=xl6417319></td>
  <td class=xl6417319></td>
  <td class=xl6417319></td>
 </tr>
 <tr height=21 style='height:15.75pt'>
  <td height=21 class=xl6417319 style='height:15.75pt'></td>
  <td class=xl6717319>&nbsp;</td>
  <td class=xl6717319>&nbsp;</td>
  <td class=xl6717319>&nbsp;</td>
  <td class=xl6717319>&nbsp;</td>
  <td class=xl6717319>&nbsp;</td>
  <td class=xl6717319>&nbsp;</td>
  <td class=xl6417319></td>
  <td class=xl6717319>&nbsp;</td>
  <td class=xl6717319>&nbsp;</td>
  <td class=xl6717319>&nbsp;</td>
  <td class=xl6717319>&nbsp;</td>
  <td class=xl6717319>&nbsp;</td>
  <td class=xl6717319>&nbsp;</td>
  <td class=xl6717319>&nbsp;</td>
  <td class=xl6717319>&nbsp;</td>
  <td class=xl6717319>&nbsp;</td>
  <td class=xl6417319></td>
 </tr>
 <tr class=xl1517319 height=21 style='height:15.75pt'>
  <td height=21 class=xl6417319 style='height:15.75pt'></td>
  <td class=xl6817319>Cut No :</td>
  <td colspan=2 class=xl9617319><?php if($remarks=="Normal") { echo leading_zeros($cut_no, 3); } else {if($remarks=="Pilot") { echo "Pilot";}}?></td>
  <td colspan=2 class=xl6817319>Date:</td>
  <td colspan=2 class=xl9617319><?php  echo $date; ?></td>
  <td class=xl1517319></td>
  <td colspan=2 class=xl6817319>Category :</td>
  <td colspan=7 class=xl9617319><?php echo $cat_title; ?></td>
  <td class=xl1517319></td>
 </tr>
 <tr class=xl1517319 height=21 style='height:15.75pt'>
  <td height=21 class=xl6417319 style='height:15.75pt'></td>
  <td class=xl6817319>Style No :</td>
  <td colspan=2 class=xl9617319><?php echo $style; ?></td>
  <td colspan=2 class=xl6817319>Module:</td>
  <td colspan=2 class=xl9617319><?php echo $plan_module; echo " (".$cut_table[$plan_module].")"; ?></td>
  <td class=xl1517319></td>
  <td colspan=2 class=xl11317319>Mk Name :</td>
  <td colspan=7 class=xl9617319><?php echo $mk_remarks; ?></td>
  <td class=xl6417319></td>
 </tr>
 <tr class=xl1517319 height=21 style='height:15.75pt'>
  <td height=21 class=xl6417319 style='height:15.75pt'></td>
  <td class=xl6817319>Sch No :</td>
  <td colspan=2 class=xl9617319><?php echo $schedule; ?></td>
  <td colspan=2 class=xl6817319>PO:</td>
  <td colspan=2 class=xl9617319></td>
  <td class=xl1517319></td>
  <td colspan=2 class=xl6817319>Fab Direction :</td>
  <td colspan=7 class=xl11517319><?php if($gmtway=="Y") { echo "One Gmt One Way"; } else  { echo "All Gmt One Way"; }?></td>
  <td class=xl11417319></td>
 </tr>
 
<!-- 
 <tr class=xl1517319 height=21 style='height:15.75pt'>
  <td height=21 class=xl6417319 style='height:15.75pt'></td>
  <td class=xl6817319>Color :</td>
  <td colspan=5 class=xl9617319>xxxx</td>
  <td class=xl1517319></td>
  <td colspan=2 class=xl6817319>Fab Code/ Desc :</td>
  <td colspan=7 class=xl9617319>xxxx</td>
  <td class=xl6417319></td>
 </tr>
 -->
 <?php
 echo "<tr class=xl1517319 height=21 style='height:15.75pt'>
  <td height=21 class=xl6417319 style='height:15.75pt'></td>
  <td class=xl6817319>Color :</td>
  <td colspan=2 class=xl9617319>".$sch_color[0]." / ".$color_codes[0]."</td>
  <td colspan=2 class=xl6817319>Consumptions:</td>
  <td  class=xl9617319'>$body_yy</td>
  <td class=xl1517319></td>
  <td colspan=2 class=xl6817319>Fab Code/ Desc :</td>
  <td colspan=7 class=xl9617319>".$fab_codes[0]."</td>
  <td class=xl6417319></td>
 </tr>";
 for($i=1;$i<sizeof($color_codes);$i++)
 {
 	echo "<tr class=xl1517319 height=21 style='height:15.75pt'>
  <td height=21 class=xl6417319 style='height:15.75pt'></td>
  <td class=xl6817319>Color :</td>
  <td colspan=5 class=xl9617319>".$sch_color[$i]." / ".$color_codes[$i]."</td>
  <td class=xl1517319></td>
  <td colspan=2 class=xl6817319>Fab Code/ Desc :</td>
  <td colspan=7 class=xl9617319>".$fab_codes[$i]."</td>
  <td class=xl6417319></td>
 </tr>";
 }
 
 
 ?>
 <tr class=xl1517319 height=21 style='height:15.75pt'>
  <td height=21 class=xl6417319 style='height:15.75pt'></td>
  <td class=xl6917319>&nbsp;</td>
  <td class=xl11617319>&nbsp;</td>
  <td class=xl11617319>&nbsp;</td>
  <td class=xl11617319>&nbsp;</td>
  <td class=xl11617319>&nbsp;</td>
  <td class=xl11617319>&nbsp;</td>
  <td class=xl1517319></td>
  <td class=xl9717319>&nbsp;</td>
  <td class=xl9717319>&nbsp;</td>
  <td class=xl9717319>&nbsp;</td>
  <td class=xl9717319>&nbsp;</td>
  <td class=xl9717319>&nbsp;</td>
  <td class=xl9717319>&nbsp;</td>
  <td class=xl9717319>&nbsp;</td>
  <td class=xl9717319>&nbsp;</td>
  <td class=xl9717319>&nbsp;</td>
  <td class=xl6417319></td>
 </tr>
 <tr class=xl1517319 height=21 style='height:15.75pt'>
  <td height=21 class=xl6417319 style='height:15.75pt'></td>
  <td class=xl6817319></td>
  <td class=xl10517319></td>
  <td class=xl10517319></td>
  <td class=xl10517319></td>
  <td class=xl10517319></td>
  <td class=xl10517319></td>
  <td class=xl1517319></td>
  <td class=xl1517319></td>
  <td class=xl1517319></td>
  <td class=xl1517319></td>
  <td class=xl1517319></td>
  <td class=xl1517319></td>
  <td class=xl1517319></td>
  <td class=xl1517319></td>
  <td class=xl1517319></td>
  <td class=xl1517319></td>
  <td class=xl6417319></td>
 </tr>
 <tr height=21 style='height:15.75pt'>
  <td height=21 class=xl6417319 style='height:15.75pt'></td>
  <td colspan=16 rowspan=5 class=xl8217319>
  
  <?php
  $style_css="style='font-size:12px; border:.5pt solid black; padding-left: 10px; padding-right:10px; border-collapse: collapse;'";
  echo "<table style='font-size:12px; border:.5pt solid black; border-collapse: collapse;' align=left>";
  
  echo "<tr>";
  
  echo "<th $style_css>Barcode</th>";
  echo "<th $style_css>Color</th>";
  echo "<th $style_css>Job</th>";
  echo "<th $style_css>Doc.ID</th>";
  
  for($i=0;$i<sizeof($sizes_tit);$i++)
  {
  	// if($qty[$i]>0)
	{
		echo "<th $style_css>".$sizes_tit[$i]."</th>";
	}
  }
  $fab_uom = 'Yds';//hardcoded
  echo "<th $style_css>Plies</th>";
  echo "<th $style_css>$fab_uom</th>";
  echo "</tr>";
  
  for($j=0;$j<sizeof($color_codes);$j++)
  {
  	echo "<tr>";
	echo "<td $style_css>".'<div id="bcTarget'.$j.'" style="width:auto;"></div><script>$("#bcTarget'.$j.'").barcode("D'.$docs[$j].'", "code39",{barWidth:2,barHeight:15,moduleSize:5,fontSize:0});</script>'."</td>";
	  echo "<td $style_css>".$color_codes[$j]."</td>";
	  echo "<td $style_css>".chr($cc_code[$j]).leading_zeros($cut_no, 3)."</td>";
	  echo "<td $style_css>".$docs[$j]."</td>";
	  
	  for($i=0;$i<sizeof($sizes_tit);$i++)
	  {
	  	// if($qty[$i]>0)
		{
			echo "<td $style_css>".$qty[$i]."</td>";
		}
	  }
	  echo "<td $style_css>".$plies[$j]."</td>";
	  echo "<td $style_css>".$met_req[$j]."</td>";
	  echo "</tr>";
  }
  
   echo "<tr>";
  
  echo "<th $style_css colspan=4>Total</th>";
  //echo "<th>Color</th>";
  //echo "<th>Job</th>";
  //echo "<th>Doc.ID</th>";
   for($i=0;$i<sizeof($sizes_tit);$i++)
  {
  	// if($qty[$i]>0)
	// {
		echo "<th $style_css>".($qty[$i]*array_sum($plies))."</th>";
	//}
  }
  echo "<th $style_css>".((array_sum($qty)/sizeof($color_codes))*array_sum($plies))."</th>";
  echo "<th $style_css>".array_sum($met_req)."</th>";
  echo "</tr>";
  
  echo "</table>";
  
  
  ?>
  
  </td>
  <td class=xl6417319></td>
 </tr>
 <tr height=21 style='height:15.75pt'>
  <td height=21 class=xl6417319 style='height:15.75pt'></td>
  <td class=xl6417319></td>
 </tr>
 <tr height=21 style='height:15.75pt'>
  <td height=21 class=xl6417319 style='height:15.75pt'></td>
  <td class=xl6417319></td>
 </tr>
 <tr height=21 style='height:15.75pt'>
  <td height=21 class=xl6417319 style='height:15.75pt'></td>
  <td class=xl6417319></td>
 </tr>
 <tr height=21 style='height:15.75pt'>
  <td height=21 class=xl6417319 style='height:15.75pt'></td>
  <td class=xl6417319></td>
 </tr>
 <tr height=21 style='height:15.75pt'>
  <td height=21 class=xl6417319 style='height:15.75pt'></td>
  <td class=xl6417319></td>
 </tr>
 <tr height=21 style='height:15.75pt'>
  <td height=21 class=xl6417319 style='height:15.75pt'></td>
  <td class=xl6417319></td>
 </tr>
 <tr height=21 style='height:15.75pt'>
  <td height=21 class=xl6417319 style='height:15.75pt'></td>
  <td class=xl6417319></td>
  <td class=xl6417319></td>
  <td class=xl6417319></td>
  <td class=xl6417319></td>
  <td class=xl6417319></td>
  <td class=xl6417319></td>
  <td class=xl6417319></td>
  <td class=xl6417319></td>
  <td class=xl6417319></td>
  <td class=xl6417319></td>
  <td class=xl6417319></td>
  <td class=xl6417319></td>
  <td class=xl6417319></td>
  <td class=xl6417319></td>
  <td class=xl6417319></td>
  <td class=xl6417319></td>
  <td class=xl6417319></td>
 </tr>
 <tr height=22 style='height:16.5pt'>
  <td height=22 class=xl6417319 style='height:16.5pt'></td>
  <td class=xl6417319></td>
  <td class=xl6417319></td>
  <td class=xl6417319></td>
  <td class=xl6417319></td>
  <td class=xl6417319></td>
  <td class=xl6417319></td>
  <td class=xl6417319></td>
  <td class=xl6417319></td>
  <td class=xl6417319></td>
  <td class=xl6417319></td>
  <td class=xl6417319></td>
  <td class=xl6417319></td>
  <td class=xl6417319></td>
  <td class=xl6417319></td>
  <td class=xl6417319></td>
  <td class=xl6417319></td>
  <td class=xl6417319></td>
 </tr>

 <tr height=21 style='height:15.75pt'>
  <td height=21 class=xl8217319 style='height:15.75pt'></td>
  <td rowspan=2 class=xl7017319 style='border-bottom:.5pt solid black'>Rpt No</td>
  <td rowspan=2 class=xl8917319 width=64 style='border-bottom:.5pt solid black; width:48pt'>Pattern Version</td>
  <td rowspan=2 class=xl8917319 width=64 style='border-bottom:.5pt solid black;  width:48pt'>No of Plies</td>
  <td rowspan=2 class=xl8917319 width=64 style='border-bottom:.5pt solid black;
  width:48pt'>Pur Width</td>
  <td rowspan=2 class=xl8917319 width=64 style='border-bottom:.5pt solid black; width:48pt'>Marker Length</td>
  <td rowspan=2 class=xl8917319 width=64 style='border-bottom:.5pt solid black;
  width:48pt'>Req. Qty (<?php echo $fab_uom; ?>)</td>
  <td rowspan=2 class=xl8917319 width=64 style='border-bottom:.5pt solid black;
  width:48pt'>Act. Width</td>
  <td rowspan=2 class=xl8917319 width=64 style='border-bottom:.5pt solid black;
  width:48pt'>Cutting Wastage %</td>
  <td rowspan=2 colspan=2 class='xl8917319 autox'width=80 style='border-bottom:.5pt solid black;
  width:60px'>Binding Consumption</td>
  <td rowspan=2   colspan=2 class='xl8917319 autox' width=80 style='border-bottom:.5pt solid black;
  width:70px'>Fab. Requirement for lay/ Yds</td>
  <td rowspan=2  colspan=2 class='autox xl8917319' width=80 style='border-bottom:.5pt solid black;
  width:70px'>Fab. Requirement for Binding/ Yds</td>
  <td rowspan=2  colspan=2 class='autox xl8917319' width=80 style='border-bottom:.5pt solid black;
  width:60px'>Total Fab. Requirement/ Yds</td>
  <td rowspan=2 colspan=2  class=xl8917319 width=64 style='border-bottom:.5pt solid black;
  width:auto'>Marker Length</td>
  <td rowspan=2 class=xl8917319 width=64 style='border-bottom:.5pt solid black;
  width:48pt'>Act. Req Qty (<?php echo $fab_uom; ?>)</td>
  <td rowspan=2 class=xl8917319 width=64 style='border-bottom:.5pt solid black;
  width:48pt'>Issued Qty (<?php echo $fab_uom; ?>)</td>
  <td rowspan=2 class=xl8917319 width=64 style='border-bottom:.5pt solid black;
  width:48pt'>Return Qty (<?php echo $fab_uom; ?>)</td>
  <td class=xl11717319 width=64 style='width:48pt'></td>
  <td class=xl8217319></td>
  <td colspan=3 rowspan=4 class=xl10117319 style='border-right:1.0pt solid black;
  border-bottom:1.0pt solid black'>Fabric Swatch</td>
  <td class=xl8217319></td>
 </tr>
 <tr height=21 style='height:15.75pt'>
  <td height=21 class=xl8217319 style='height:15.75pt'></td>
  <td class=xl11717319 width=64 style='width:48pt'></td>
  <td class=xl8217319></td>
  <td class=xl8217319></td>
 </tr>
 <tr height=21 style='height:15.75pt'>
  <td height=21 class=xl6417319 style='height:15.75pt'></td>
  <td rowspan=2 class=xl9817319 width=64 style='border-bottom:.5pt solid black;
  border-top:none;width:48pt'>&nbsp;</td>
  <td rowspan=2 class=xl9817319 width=64 style='border-bottom:.5pt solid black;
  border-top:none;width:48pt'><?php echo $patt_ver; ?></td>
  <td rowspan=2 class=xl10017319 width=64 style='border-bottom:.5pt solid black;
  border-top:none;width:48pt'><?php echo array_sum($plies); ?></td>
  <td rowspan=2 class=xl10017319 width=64 style='border-bottom:.5pt solid black;
  border-top:none;width:48pt'><?php echo $purwidth; ?></td>
  <td rowspan=2 class=xl9817319 width=64 style='border-bottom:.5pt solid black;
  border-top:none;width:48pt'><?php echo $purlength; ?></td>
  <td rowspan=2 class=xl10017319 width=64 style='border-bottom:.5pt solid black;
  border-top:none;width:48pt'><?php //if(substr($style,0,1)=="M") 
  	//Extra 1% added to avoid cad saving manual mrn claims.
	{ $extra=round((($purlength*array_sum($plies))*$savings),2); }  
	echo (($purlength*array_sum($plies))+$extra);  ?></td>
  <td rowspan=2 class=xl10017319 width=64 style='border-bottom:.5pt solid black;
  border-top:none;width:48pt'><?php echo $actwidth; ?></td>
  <td rowspan=2 class=xl8917319 width=64 style='border-bottom:.5pt solid black;
  width:48pt'><?php echo $cuttable_wastage*100;?></td>
  <td rowspan=2 colspan=2 class=xl8917319 width=64 style='border-bottom:.5pt solid black;
  width:48pt'><?php echo $binding_con; ?></td>
  <td rowspan=2 colspan=2  class=xl8917319 width=64 style='border-bottom:.5pt solid black;
  width:48pt'><?php $fab_lay = (float)$purlength*(1+(float)$cuttable_wastage)*(int)$plies; echo round($fab_lay,2); ?></td>
  <td rowspan=2 colspan=2  class=xl8917319 width=64 style='border-bottom:.5pt solid black;
  width:48pt'><?php $fab_bind = (float)$binding_con*(int)$plies*(float)$a_ratio_tot; echo round($fab_bind,2); ?></td>
  <td rowspan=2 colspan=2  class=xl8917319 width=64 style='border-bottom:.5pt solid black;
  width:48pt'><?php echo round($fab_bind+$fab_lay,2); ?></td>
  <td rowspan=2 colspan=2  class=xl10017319 width=64 style='border-bottom:.5pt solid black;
  border-top:none;width:48pt'><?php echo $act_mk_length; ?></td>
  <td rowspan=2 class=xl10017319 width=64 style='border-bottom:.5pt solid black;
  border-top:none;width:48pt'><?php if($act_mk_length>0) {echo array_sum($met_req); } ?></td>
  <td rowspan=2 class=xl10017319 width=64 style='border-bottom:.5pt solid black;
  border-top:none;width:48pt'>&nbsp;</td>
  <td rowspan=2 class=xl10017319 width=64 style='border-bottom:.5pt solid black;
  border-top:none;width:48pt'>&nbsp;</td>
  <td class=xl11117319 width=64 style='width:48pt'></td>
  <td class=xl6417319></td>
  <td class=xl6417319></td>
 </tr>
 <tr height=22 style='height:16.5pt'>
  <td height=22 class=xl6417319 style='height:16.5pt'></td>
  <td class=xl11117319 width=64 style='width:48pt'></td>
  <td class=xl6417319></td>
  <td class=xl6417319></td>
 </tr>
 <tr >
  <td class=xl6417319 ></td>
  <td class=xl11117319 width=64 style='width:48pt'></td>
  <td class=xl11117319 width=64 style='width:48pt'></td>
  <td class=xl11117319 width=64 style='width:48pt'></td>
  <td class=xl11117319 width=64 style='width:48pt'></td>
  <td class=xl11117319 width=64 style='width:48pt'></td>
  <td class=xl11117319 width=64 style='width:48pt'></td>
  <td class=xl11117319 width=64 style='width:48pt'></td>
  <td class=xl11117319 width=64 style='width:48pt'></td>
  <td class=xl11117319 width=64 style='width:48pt'></td>
  <td class=xl11117319 width=64 style='width:48pt'></td>
  <td class=xl11117319 width=64 style='width:48pt'></td>
  <td class=xl11117319 width=64 style='width:48pt'></td>
  <td class=xl6417319></td>
  <td class=xl11217319></td>
  <td class=xl11217319></td>
  <td class=xl11217319></td>
  <td class=xl6417319></td>
 </tr>
 <tr>
  <td class=xl6417319></td>
  <td colspan=16 rowspan=7 class=xl8217319>
  
  <?php
  $roll_det=array();
$width_det=array();
$leng_det=array();
$batch_det=array();
$shade_det=array();
$locan_det=array();
$lot_det=array();
$roll_id=array();
$ctex_len=array();
$tkt_len=array();
$ctex_width=array();
$tkt_width=array();

$idocs_1 = "'" . implode ( "', '", $docs ) . "'";

$sql="select distinct * from $bai_rm_pj1.docket_ref where doc_no in ($idocs_1) and doc_type='normal'  group by roll_id";
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row=mysqli_fetch_array($sql_result))
{

$roll_det[]=$sql_row['ref2'];
$width_det[]=round($sql_row['roll_width'],2);
$leng_det[]=$sql_row['allocated_qty'];
$batch_det[]=trim($sql_row['batch_no']);
$shade_det[]=$sql_row['ref4']."-".$sql_row['inv_no'];
$locan_det[]=$sql_row['ref1'];
$lot_det[]=$sql_row['lot_no'];
$roll_id[]=$sql_row['roll_id'];
$ctex_len[]=$sql_row['ref5'];
$tkt_len[]=$sql_row['qty_rec'];
$ctex_width[]=$sql_row['ref3'];
$tkt_width[]=$sql_row['ref6'];
} 

echo "<table style='font-size:16px; border:.5pt solid black; border-collapse: collapse; float:left;'>";
echo "<tr><td style='font-size:14px; border:.5pt solid black; border-collapse: collapse;'> Roll No</td>
<td style='font-size:12px; border:.5pt solid black; border-collapse: collapse;'> Lot No</td>
<td style='font-size:14px; border:.5pt solid black; border-collapse: collapse;'>Label ID</td>
<td style='font-size:14px; border:.5pt solid black; border-collapse: collapse;'> Width</td>
<td style='font-size:14px; border:.5pt solid black; border-collapse: collapse;'>Allocated Length</td>
<td style='font-size:14px; border:.5pt solid black; border-collapse: collapse;'> Batch</td>
<td style='font-size:14px; border:.5pt solid black; border-collapse: collapse;'> Shade</td>
<td style='font-size:14px; border:.5pt solid black; border-collapse: collapse;'> Location</td>
<td style='font-size:14px; border:.5pt solid black; border-collapse: collapse;'> Location</td>
<td style='font-size:14px; border:.5pt solid black; border-collapse: collapse;'> C-Tex Length</td>
<td style='font-size:12px; border:.5pt solid black; border-collapse: collapse;'> Ticket Length</td>
<td style='font-size:14px; border:.5pt solid black; border-collapse: collapse;'> Length Variation</td>
<td style='font-size:14px; border:.5pt solid black; border-collapse: collapse;'> C-Tex Width</td>
<td style='font-size:12px; border:.5pt solid black; border-collapse: collapse;'> Ticket Width</td>
<td style='font-size:14px; border:.5pt solid black; border-collapse: collapse;'> Width Variation</td><tr/>";
for($i=0;$i<sizeof($roll_det);$i++){
	echo "<tr>
		<td style='font-size:14px; border:.5pt solid black; border-collapse: collapse;'>".$roll_det[$i]."</td>
		<td style='font-size:12px; border:.5pt solid black; border-collapse: collapse;'>".$lot_det[$i]."</td>
		<td style='font-size:14px; border:.5pt solid black; border-collapse: collapse;'>".$roll_id[$i]."</td>
		<td style='font-size:14px; border:.5pt solid black; border-collapse: collapse;'>".$width_det[$i]."</td>
		<td style='font-size:14px; border:.5pt solid black; border-collapse: collapse;'>".$leng_det[$i]."</td>
		<td style='font-size:14px; border:.5pt solid black; border-collapse: collapse;'>".$batch_det[$i]."</td>
		<td style='font-size:14px; border:.5pt solid black; border-collapse: collapse;'>".$shade_det[$i]."</td>
		<td style='font-size:14px; border:.5pt solid black; border-collapse: collapse;'>".$locan_det[$i]."</td>
		<td style='font-size:14px; border:.5pt solid black; border-collapse: collapse;'>".$ctex_len[$i]."</td>
		<td style='font-size:12px; border:.5pt solid black; border-collapse: collapse;'>".$tkt_len[$i]."</td>
		<td style='font-size:14px; border:.5pt solid black; border-collapse: collapse;'>".round(($ctex_len[$i]-$tkt_len[$i]),2)."</td>
		<td style='font-size:14px; border:.5pt solid black; border-collapse: collapse;'>".$ctex_width[$i]."</td>
		<td style='font-size:12px; border:.5pt solid black; border-collapse: collapse;'>".$tkt_width[$i]."</td>
		<td style='font-size:14px; border:.5pt solid black; border-collapse: collapse;'>".round(($ctex_width[$i]-$tkt_width[$i]),2)."</td>
		<td style='font-size:14px; border:.5pt solid black; border-collapse: collapse;'>".round(($ctex_width[$i]-$tkt_width[$i]),2)."</td>		

		</tr>";
}
echo "</table>";	

// for($i=0;$i<sizeof($roll_det);$i++)
// {
// 	echo "<td style='font-size:14px; border:.5pt solid black; border-collapse: collapse;'>".$roll_det[$i]."</td>";
// }
// echo "</tr>";


// //2012-06-12 New implementation to get fabric detail based on invoce/batch
// echo "<tr><td style='font-size:12px; border:.5pt solid black; border-collapse: collapse;'> Lot No</td>";
// //echo "<tr><td style='font-size:14px; border:.5pt solid black; border-collapse: collapse;'>Label ID</td>";

// for($i=0;$i<sizeof($roll_det);$i++)
// {
// 	//2012-06-12 New implementation to get fabric detail based on invoce/batch
// 	echo "<td style='font-size:12px; border:.5pt solid black; border-collapse: collapse;'>".$lot_det[$i]."</td>";
// 	//echo "<td style='font-size:14px; border:.5pt solid black; border-collapse: collapse;'>".$roll_id[$i]."</td>";
// }
// echo "</tr>";

// //2012-06-12 New implementation to get fabric detail based on invoce/batch
// //echo "<tr><td style='font-size:12px; border:.5pt solid black; border-collapse: collapse;'> Lot No</td>";
// echo "<tr><td style='font-size:14px; border:.5pt solid black; border-collapse: collapse;'>Label ID</td>";

// for($i=0;$i<sizeof($roll_det);$i++)
// {
// 	//2012-06-12 New implementation to get fabric detail based on invoce/batch
// 	//echo "<td style='font-size:12px; border:.5pt solid black; border-collapse: collapse;'>".$lot_det[$i]."</td>";
// 	echo "<td style='font-size:14px; border:.5pt solid black; border-collapse: collapse;'>".$roll_id[$i]."</td>";
// }
// echo "</tr>";





// echo "<tr><td style='font-size:14px; border:.5pt solid black; border-collapse: collapse;'> Width</td>";

// for($i=0;$i<sizeof($roll_det);$i++)
// {
// 	echo "<td style='font-size:14px; border:.5pt solid black; border-collapse: collapse;'>".$width_det[$i]."</td>";
// }
// echo "</tr>";

// echo "<tr><td style='font-size:14px; border:.5pt solid black; border-collapse: collapse;'>Allocated Length</td>";

// for($i=0;$i<sizeof($roll_det);$i++)
// {
// 	echo "<td style='font-size:14px; border:.5pt solid black; border-collapse: collapse;'>".$leng_det[$i]."</td>";
// }
// echo "</tr>";

// echo "<tr><td style='font-size:14px; border:.5pt solid black; border-collapse: collapse;'> Batch</td>";

// for($i=0;$i<sizeof($roll_det);$i++)
// {
// 	echo "<td style='font-size:14px; border:.5pt solid black; border-collapse: collapse;'>".$batch_det[$i]."</td>";
// }
// echo "</tr>";

// echo "<tr><td style='font-size:14px; border:.5pt solid black; border-collapse: collapse;'> Shade</td>";

// for($i=0;$i<sizeof($roll_det);$i++)
// {
// 	echo "<td style='font-size:14px; border:.5pt solid black; border-collapse: collapse;'>".$shade_det[$i]."</td>";
// }
// echo "</tr>";


// echo "<tr><td style='font-size:14px; border:.5pt solid black; border-collapse: collapse;'> Location</td>";

// for($i=0;$i<sizeof($roll_det);$i++)
// {
// 	echo "<td style='font-size:14px; border:.5pt solid black; border-collapse: collapse;'>".$locan_det[$i]."</td>";
// }
// echo "</tr>";

// echo "<tr><td style='font-size:14px; border:.5pt solid black; border-collapse: collapse;'> C-Tex Length</td>";

// for($i=0;$i<sizeof($roll_det);$i++)
// {
// 	echo "<td style='font-size:14px; border:.5pt solid black; border-collapse: collapse;'>".$ctex_len[$i]."</td>";
// }
// echo "</tr>";

// echo "<tr><td style='font-size:12px; border:.5pt solid black; border-collapse: collapse;'> Ticket Length</td>";

// for($i=0;$i<sizeof($roll_det);$i++)
// {
// 	echo "<td style='font-size:12px; border:.5pt solid black; border-collapse: collapse;'>".$tkt_len[$i]."</td>";
// }
// echo "</tr>";


// echo "<tr><td style='font-size:14px; border:.5pt solid black; border-collapse: collapse;'> Length Variation</td>";

// for($i=0;$i<sizeof($roll_det);$i++)
// {
// 	echo "<td style='font-size:14px; border:.5pt solid black; border-collapse: collapse;'>".round(($ctex_len[$i]-$tkt_len[$i]),2)."</td>";
// }
// echo "</tr>";

// echo "<tr><td style='font-size:14px; border:.5pt solid black; border-collapse: collapse;'> C-Tex Width</td>";

// for($i=0;$i<sizeof($roll_det);$i++)
// {
// 	echo "<td style='font-size:14px; border:.5pt solid black; border-collapse: collapse;'>".$ctex_width[$i]."</td>";
// }
// echo "</tr>";

// echo "<tr><td style='font-size:12px; border:.5pt solid black; border-collapse: collapse;'> Ticket Width</td>";

// for($i=0;$i<sizeof($roll_det);$i++)
// {
// 	echo "<td style='font-size:12px; border:.5pt solid black; border-collapse: collapse;'>".$tkt_width[$i]."</td>";
// }
// echo "</tr>";

// echo "<tr><td style='font-size:14px; border:.5pt solid black; border-collapse: collapse;'> Width Variation</td>";

// for($i=0;$i<sizeof($roll_det);$i++)
// {
// 	echo "<td style='font-size:14px; border:.5pt solid black; border-collapse: collapse;'>".round(($ctex_width[$i]-$tkt_width[$i]),2)."</td>";
// }
// echo "</tr>";

// echo "</table>";	
echo $lot_ref; echo "MK File: ".implode(", ",array_unique($mk_files));
  ?>
  </td>
  <td class=xl6417319></td>
 </tr>
 <tr height=21 style='height:15.75pt'>
  <td height=21 class=xl6417319 style='height:15.75pt'></td>
  <td class=xl6417319></td>
 </tr>
 <tr height=21 style='height:15.75pt'>
  <td height=21 class=xl6417319 style='height:15.75pt'></td>
  <td class=xl6417319></td>
 </tr>
 <tr height=21 style='height:15.75pt'>
  <td height=21 class=xl6417319 style='height:15.75pt'></td>
  <td class=xl6417319></td>
 </tr>
 <tr height=21 style='height:15.75pt'>
  <td height=21 class=xl6417319 style='height:15.75pt'></td>
  <td class=xl6417319></td>
 </tr>
 <tr height=21 style='height:15.75pt'>
  <td height=21 class=xl6417319 style='height:15.75pt'></td>
  <td class=xl6417319></td>
 </tr>
 <tr height=21 style='height:15.75pt'>
  <td height=21 class=xl6417319 style='height:15.75pt'></td>
<!-- <td class=xl824118></td>
  <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td> -->
  <td class=xl6417319></td>
 </tr>
 <tr height=21 style='height:15.75pt'>
  <td height=21 class=xl6417319 style='height:15.75pt'></td>
<!-- <td class=xl824118></td>
  <td class=xl654118></td>
  <td class=xl654118></td> 
  <td class=xl654118></td> -->
  <td class=xl6417319></td>
 </tr>
 <tr height=21 style='height:15.75pt'>
  <td height=21 class=xl6417319 style='height:15.75pt'></td>
<!-- <td class=xl654118></td>
  <td class=xl654118></td>
  <td class=xl654118></td> 
  <td class=xl654118></td>-->
  <td class=xl6417319></td>
 </tr>
 <tr height=21 style='height:15.75pt'>
  <td height=21 class=xl6417319 style='height:15.75pt'></td>
  <td class=xl7617319></td>
 </tr>
 <tr height=21 style='height:15.75pt'>
  <td height=21 class=xl6417319 style='height:15.75pt'></td>
  <td class=xl6417319></td>
  <td class=xl6417319></td>
  <td class=xl6417319></td>
  <td class=xl6417319></td>
  <td class=xl6417319></td>
  <td class=xl6417319></td>
  <td class=xl6417319></td>
  <td class=xl6417319></td>
  <td class=xl6417319></td>
  <td class=xl6417319></td>
  <td class=xl6417319></td>
  <td class=xl6417319></td>
  <td class=xl6417319></td>
  <td class=xl6417319></td>
  <td class=xl6417319 colspan="3"><u><strong>Quality Authorisation</strong></u></td>
 </tr>
 <tr height=21 style='height:15.75pt'>
  <td height=21 class=xl8217319 style='height:15.75pt'></td>
  <td colspan=16 rowspan=2 class=xl9117319 style='border-right:.5pt solid black;
  border-bottom:.5pt solid black'>Inspection Comments:
  <?php
   if(sizeof($batch_det) > 0)
   {
   	    $rem="";
		$batchs=array();
	   	for($i=0;$i<sizeof($batch_det);$i++)
		{
			$batchs[]="'".$batch_det[$i]."'";
		}
	   
	    $batchs=array_unique($batchs);
	    $sql="select group_concat(sp_rem) as rem from $bai_rm_pj1.inspection_db where batch_ref in (".implode(",",$batchs).")";
   	    //echo $sql;
	    $sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	    while($sql_row=mysqli_fetch_array($sql_result))
	    {
	    	$rem=$sql_row["rem"];
	    }
	    echo $rem;
   }
   ?>
  </td>
  <td class=xl8217319></td>
 </tr>
  <tr height=21 style='height:15.75pt'>
  <td height=21 class=xl8217319 style='height:15.75pt'></td>
  </tr>
  <tr height=21 style='height:15.75pt'>
  <td height=21 class=xl8217319 style='height:15.75pt'></td>
  </tr>
 <tr height=21 style='height:15.75pt'>
  <td height=21 class=xl8217319 style='height:15.75pt'></td>
  <td class=xl7017319>Group</td>
  <td class=xl7117319>Roll No</td>
  <td rowspan=2 class=xl8917319 width=64 style='border-bottom:.5pt solid black;
  width:48pt'>Ticket Length</td>
  <td class=xl7117319>Plies</td>
  <td class=xl7117319>Damage</td>
  <td class=xl7117319>Joints</td>
  <td class=xl7117319>Ends</td>
  <td class=xl7117319>Shortages</td>
  <td rowspan=2 class=xl8917319 width=64 style='border-bottom:.5pt solid black;
  width:48pt'>Net Length</td>
  <td colspan=7 rowspan=2 class=xl9117319 style='border-right:.5pt solid black;
  border-bottom:.5pt solid black'>Comments</td>
  <td class=xl8217319></td>
 </tr>
 <tr height=21 style='height:15.75pt'>
  <td height=21 class=xl8217319 style='height:15.75pt'></td>
  <td class=xl7217319>&nbsp;</td>
  <td class=xl7317319>&nbsp;</td>
  <td class=xl7317319>&nbsp;</td>
  <td class=xl7317319>&nbsp;</td>
  <td class=xl7317319>&nbsp;</td>
  <td class=xl7317319>&nbsp;</td>
  <td class=xl7317319>Excess</td>
  <td class=xl8217319></td>
 </tr>
 <tr height=21 style='height:15.75pt'>
  <td height=21 class=xl6417319 style='height:15.75pt'></td>
  <td class=xl7417319>&nbsp;</td>
  <td class=xl7517319>&nbsp;</td>
  <td class=xl7517319>&nbsp;</td>
  <td class=xl7517319>&nbsp;</td>
  <td class=xl7517319>&nbsp;</td>
  <td class=xl7517319>&nbsp;</td>
  <td class=xl7517319>&nbsp;</td>
  <td class=xl7517319>&nbsp;</td>
  <td class=xl7517319>&nbsp;</td>
  <td colspan=7 class=xl8317319 style='border-right:.5pt solid black;
  border-left:none'>&nbsp;</td>
  <td class=xl6417319></td>
 </tr>
 <tr height=21 style='height:15.75pt'>
  <td height=21 class=xl6417319 style='height:15.75pt'></td>
  <td class=xl7417319>&nbsp;</td>
  <td class=xl7517319>&nbsp;</td>
  <td class=xl7517319>&nbsp;</td>
  <td class=xl7517319>&nbsp;</td>
  <td class=xl7517319>&nbsp;</td>
  <td class=xl7517319>&nbsp;</td>
  <td class=xl7517319>&nbsp;</td>
  <td class=xl7517319>&nbsp;</td>
  <td class=xl7517319>&nbsp;</td>
  <td colspan=7 class=xl8317319 style='border-right:.5pt solid black;
  border-left:none'>&nbsp;</td>
  <td class=xl6417319></td>
 </tr>
 <tr height=21 style='height:15.75pt'>
  <td height=21 class=xl6417319 style='height:15.75pt'></td>
  <td class=xl7417319>&nbsp;</td>
  <td class=xl7517319>&nbsp;</td>
  <td class=xl7517319>&nbsp;</td>
  <td class=xl7517319>&nbsp;</td>
  <td class=xl7517319>&nbsp;</td>
  <td class=xl7517319>&nbsp;</td>
  <td class=xl7517319>&nbsp;</td>
  <td class=xl7517319>&nbsp;</td>
  <td class=xl7517319>&nbsp;</td>
  <td colspan=7 class=xl8317319 style='border-right:.5pt solid black;
  border-left:none'>&nbsp;</td>
  <td class=xl6417319></td>
 </tr>
 <tr height=21 style='height:15.75pt'>
  <td height=21 class=xl6417319 style='height:15.75pt'></td>
  <td class=xl7417319>&nbsp;</td>
  <td class=xl7517319>&nbsp;</td>
  <td class=xl7517319>&nbsp;</td>
  <td class=xl7517319>&nbsp;</td>
  <td class=xl7517319>&nbsp;</td>
  <td class=xl7517319>&nbsp;</td>
  <td class=xl7517319>&nbsp;</td>
  <td class=xl7517319>&nbsp;</td>
  <td class=xl7517319>&nbsp;</td>
  <td colspan=7 class=xl8317319 style='border-right:.5pt solid black;
  border-left:none'>&nbsp;</td>
  <td class=xl6417319></td>
 </tr>
 <tr height=21 style='height:15.75pt'>
  <td height=21 class=xl6417319 style='height:15.75pt'></td>
  <td class=xl7417319>&nbsp;</td>
  <td class=xl7517319>&nbsp;</td>
  <td class=xl7517319>&nbsp;</td>
  <td class=xl7517319>&nbsp;</td>
  <td class=xl7517319>&nbsp;</td>
  <td class=xl7517319>&nbsp;</td>
  <td class=xl7517319>&nbsp;</td>
  <td class=xl7517319>&nbsp;</td>
  <td class=xl7517319>&nbsp;</td>
  <td colspan=7 class=xl8317319 style='border-right:.5pt solid black;
  border-left:none'>&nbsp;</td>
  <td class=xl6417319></td>
 </tr>
 <tr height=21 style='height:15.75pt'>
  <td height=21 class=xl6417319 style='height:15.75pt'></td>
  <td class=xl7417319>&nbsp;</td>
  <td class=xl7517319>&nbsp;</td>
  <td class=xl7517319>&nbsp;</td>
  <td class=xl7517319>&nbsp;</td>
  <td class=xl7517319>&nbsp;</td>
  <td class=xl7517319>&nbsp;</td>
  <td class=xl7517319>&nbsp;</td>
  <td class=xl7517319>&nbsp;</td>
  <td class=xl7517319>&nbsp;</td>
  <td colspan=7 class=xl8317319 style='border-right:.5pt solid black;
  border-left:none'>&nbsp;</td>
  <td class=xl6417319></td>
 </tr>
 <tr height=21 style='height:15.75pt'>
  <td height=21 class=xl6417319 style='height:15.75pt'></td>
  <td class=xl7417319>&nbsp;</td>
  <td class=xl7517319>&nbsp;</td>
  <td class=xl7517319>&nbsp;</td>
  <td class=xl7517319>&nbsp;</td>
  <td class=xl7517319>&nbsp;</td>
  <td class=xl7517319>&nbsp;</td>
  <td class=xl7517319>&nbsp;</td>
  <td class=xl7517319>&nbsp;</td>
  <td class=xl7517319>&nbsp;</td>
  <td colspan=7 class=xl8317319 style='border-right:.5pt solid black;
  border-left:none'>&nbsp;</td>
  <td class=xl6417319></td>
 </tr>
 <tr height=21 style='height:15.75pt'>
  <td height=21 class=xl6417319 style='height:15.75pt'></td>
  <td class=xl7417319>&nbsp;</td>
  <td class=xl7517319>&nbsp;</td>
  <td class=xl7517319>&nbsp;</td>
  <td class=xl7517319>&nbsp;</td>
  <td class=xl7517319>&nbsp;</td>
  <td class=xl7517319>&nbsp;</td>
  <td class=xl7517319>&nbsp;</td>
  <td class=xl7517319>&nbsp;</td>
  <td class=xl7517319>&nbsp;</td>
  <td colspan=7 class=xl8317319 style='border-right:.5pt solid black;
  border-left:none'>&nbsp;</td>
  <td class=xl6417319></td>
 </tr>
 <tr height=21 style='height:15.75pt'>
  <td height=21 class=xl6417319 style='height:15.75pt'></td>
  <td class=xl7417319>&nbsp;</td>
  <td class=xl7517319>&nbsp;</td>
  <td class=xl7517319>&nbsp;</td>
  <td class=xl7517319>&nbsp;</td>
  <td class=xl7517319>&nbsp;</td>
  <td class=xl7517319>&nbsp;</td>
  <td class=xl7517319>&nbsp;</td>
  <td class=xl7517319>&nbsp;</td>
  <td class=xl7517319>&nbsp;</td>
  <td colspan=7 class=xl8317319 style='border-right:.5pt solid black;
  border-left:none'>&nbsp;</td>
  <td class=xl6417319></td>
 </tr>
 <tr height=21 style='height:15.75pt'>
  <td height=21 class=xl6417319 style='height:15.75pt'></td>
  <td class=xl7417319>&nbsp;</td>
  <td class=xl7517319>&nbsp;</td>
  <td class=xl7517319>&nbsp;</td>
  <td class=xl7517319>&nbsp;</td>
  <td class=xl7517319>&nbsp;</td>
  <td class=xl7517319>&nbsp;</td>
  <td class=xl7517319>&nbsp;</td>
  <td class=xl7517319>&nbsp;</td>
  <td class=xl7517319>&nbsp;</td>
  <td colspan=7 class=xl8317319 style='border-right:.5pt solid black;
  border-left:none'>&nbsp;</td>
  <td class=xl6417319></td>
 </tr>
 <tr height=21 style='height:15.75pt'>
  <td height=21 class=xl6417319 style='height:15.75pt'></td>
  <td class=xl7417319>&nbsp;</td>
  <td class=xl7517319>&nbsp;</td>
  <td class=xl7517319>&nbsp;</td>
  <td class=xl7517319>&nbsp;</td>
  <td class=xl7517319>&nbsp;</td>
  <td class=xl7517319>&nbsp;</td>
  <td class=xl7517319>&nbsp;</td>
  <td class=xl7517319>&nbsp;</td>
  <td class=xl7517319>&nbsp;</td>
  <td colspan=7 class=xl8317319 style='border-right:.5pt solid black;
  border-left:none'>&nbsp;</td>
  <td class=xl6417319></td>
 </tr>
 <tr height=21 style='height:15.75pt'>
  <td height=21 class=xl6417319 style='height:15.75pt'></td>
  <td class=xl7417319>&nbsp;</td>
  <td class=xl7517319>&nbsp;</td>
  <td class=xl7517319>&nbsp;</td>
  <td class=xl7517319>&nbsp;</td>
  <td class=xl7517319>&nbsp;</td>
  <td class=xl7517319>&nbsp;</td>
  <td class=xl7517319>&nbsp;</td>
  <td class=xl7517319>&nbsp;</td>
  <td class=xl7517319>&nbsp;</td>
  <td colspan=7 class=xl8317319 style='border-right:.5pt solid black;
  border-left:none'>&nbsp;</td>
  <td class=xl6417319></td>
 </tr>
 <tr height=21 style='height:15.75pt'>
  <td height=21 class=xl6417319 style='height:15.75pt'></td>
  <td class=xl7417319>&nbsp;</td>
  <td class=xl7517319>&nbsp;</td>
  <td class=xl7517319>&nbsp;</td>
  <td class=xl7517319>&nbsp;</td>
  <td class=xl7517319>&nbsp;</td>
  <td class=xl7517319>&nbsp;</td>
  <td class=xl7517319>&nbsp;</td>
  <td class=xl7517319>&nbsp;</td>
  <td class=xl7517319>&nbsp;</td>
  <td colspan=7 class=xl8317319 style='border-right:.5pt solid black;
  border-left:none'>&nbsp;</td>
  <td class=xl6417319></td>
 </tr>
 <tr height=21 style='height:15.75pt'>
  <td height=21 class=xl6417319 style='height:15.75pt'></td>
  <td class=xl7417319>&nbsp;</td>
  <td class=xl7517319>&nbsp;</td>
  <td class=xl7517319>&nbsp;</td>
  <td class=xl7517319>&nbsp;</td>
  <td class=xl7517319>&nbsp;</td>
  <td class=xl7517319>&nbsp;</td>
  <td class=xl7517319>&nbsp;</td>
  <td class=xl7517319>&nbsp;</td>
  <td class=xl7517319>&nbsp;</td>
  <td colspan=7 class=xl8317319 style='border-right:.5pt solid black;
  border-left:none'>&nbsp;</td>
  <td class=xl6417319></td>
 </tr>
 <tr height=21 style='height:15.75pt'>
  <td height=21 class=xl6417319 style='height:15.75pt'></td>
  <td class=xl7417319>&nbsp;</td>
  <td class=xl7517319>&nbsp;</td>
  <td class=xl7517319>&nbsp;</td>
  <td class=xl7517319>&nbsp;</td>
  <td class=xl7517319>&nbsp;</td>
  <td class=xl7517319>&nbsp;</td>
  <td class=xl7517319>&nbsp;</td>
  <td class=xl7517319>&nbsp;</td>
  <td class=xl7517319>&nbsp;</td>
  <td colspan=7 class=xl8317319 style='border-right:.5pt solid black;
  border-left:none'>&nbsp;</td>
  <td class=xl6417319></td>
 </tr>
 <tr height=21 style='height:15.75pt'>
  <td height=21 class=xl6417319 style='height:15.75pt'></td>
  <td class=xl7717319>&nbsp;</td>
  <td class=xl7817319>&nbsp;</td>
  <td class=xl7817319>&nbsp;</td>
  <td class=xl7817319>&nbsp;</td>
  <td class=xl7817319>&nbsp;</td>
  <td class=xl7817319>&nbsp;</td>
  <td class=xl7817319>&nbsp;</td>
  <td class=xl7817319>&nbsp;</td>
  <td class=xl7817319>&nbsp;</td>
  <td colspan=7 class=xl8617319 style='border-right:.5pt solid black;
  border-left:none'>&nbsp;</td>
  <td class=xl6417319></td>
 </tr>
 <tr height=21 style='height:15.75pt'>
  <td height=21 class=xl6417319 style='height:15.75pt'></td>
  <td class=xl6417319></td>
  <td class=xl6417319></td>
  <td class=xl6417319></td>
  <td class=xl6417319></td>
  <td class=xl6417319></td>
  <td class=xl6417319></td>
  <td class=xl6417319></td>
  <td class=xl6417319></td>
  <td class=xl6417319></td>
  <td class=xl6417319></td>
  <td class=xl6417319></td>
  <td class=xl6417319></td>
  <td class=xl6417319></td>
  <td class=xl6417319></td>
  <td class=xl6417319></td>
  <td class=xl6417319></td>
  <td class=xl6417319></td>
 </tr>
 <tr height=21 style='height:15.75pt'>
  <td height=21 class=xl6417319 style='height:15.75pt'></td>
  <td class=xl6417319></td>
  <td class=xl7917319>Docket</td>
  <td class=xl8017319>Marker</td>
  <td class=xl8017319>Issuing</td>
  <td class=xl8017319>Laying</td>
  <td class=xl8017319>Cutting</td>
  <td class=xl8017319>Return</td>
  <td class=xl8017319>Bundling</td>
  <td class=xl8017319>Dispatch</td>
  <td class=xl6417319>Act Con</td>
  <td class=xl8117319>&nbsp;</td>
  <td class=xl8117319>&nbsp;</td>
  <td class=xl8117319>&nbsp;</td>
  <td class=xl8117319>&nbsp;</td>
  <td class=xl6417319></td>
  <td class=xl6417319></td>
  <td class=xl6417319></td>
 </tr>
 <tr height=21 style='height:15.75pt'>
  <td height=21 class=xl6417319 style='height:15.75pt'></td>
  <td class=xl6417319>Team</td>
  <td class=xl7417319>&nbsp;</td>
  <td class=xl7517319>&nbsp;</td>
  <td class=xl7517319>&nbsp;</td>
  <td class=xl7517319>&nbsp;</td>
  <td class=xl7517319>&nbsp;</td>
  <td class=xl7517319>&nbsp;</td>
  <td class=xl7517319>&nbsp;</td>
  <td class=xl7517319>&nbsp;</td>
  <td class=xl6417319>Saving %</td>
  <td class=xl8117319>&nbsp;</td>
  <td class=xl8117319>&nbsp;</td>
  <td class=xl8117319>&nbsp;</td>
  <td class=xl8117319>&nbsp;</td>
  <td class=xl6417319></td>
  <td class=xl6417319></td>
  <td class=xl6417319></td>
 </tr>
 <tr height=21 style='height:15.75pt'>
  <td height=21 class=xl6417319 style='height:15.75pt'></td>
  <td class=xl6417319>EMP No1</td>
  <td class=xl7417319>&nbsp;</td>
  <td class=xl7517319>&nbsp;</td>
  <td class=xl7517319>&nbsp;</td>
  <td class=xl7517319>&nbsp;</td>
  <td class=xl7517319>&nbsp;</td>
  <td class=xl7517319>&nbsp;</td>
  <td class=xl7517319>&nbsp;</td>
  <td class=xl7517319>&nbsp;</td>
  <td class=xl6417319>Reason</td>
  <td class=xl8117319>&nbsp;</td>
  <td class=xl8117319>&nbsp;</td>
  <td class=xl8117319>&nbsp;</td>
  <td class=xl8117319>&nbsp;</td>
  <td class=xl6417319></td>
  <td class=xl6417319></td>
  <td class=xl6417319></td>
 </tr>
 <tr height=21 style='height:15.75pt'>
  <td height=21 class=xl6417319 style='height:15.75pt'></td>
  <td class=xl6417319>Emp No2</td>
  <td class=xl7417319>&nbsp;</td>
  <td class=xl7517319>&nbsp;</td>
  <td class=xl7517319>&nbsp;</td>
  <td class=xl7517319>&nbsp;</td>
  <td class=xl7517319>&nbsp;</td>
  <td class=xl7517319>&nbsp;</td>
  <td class=xl7517319>&nbsp;</td>
  <td class=xl7517319>&nbsp;</td>
  <td class=xl6417319>Approved</td>
  <td class=xl8117319>&nbsp;</td>
  <td class=xl8117319>&nbsp;</td>
  <td class=xl8117319>&nbsp;</td>
  <td class=xl8117319>&nbsp;</td>
  <td class=xl6417319></td>
  <td class=xl6417319></td>
  <td class=xl6417319></td>
 </tr>
 <tr height=21 style='height:15.75pt'>
  <td height=21 class=xl6417319 style='height:15.75pt'></td>
  <td class=xl6417319>Emp No3</td>
  <td class=xl7417319>&nbsp;</td>
  <td class=xl7517319>&nbsp;</td>
  <td class=xl7517319>&nbsp;</td>
  <td class=xl7517319>&nbsp;</td>
  <td class=xl7517319>&nbsp;</td>
  <td class=xl7517319>&nbsp;</td>
  <td class=xl7517319>&nbsp;</td>
  <td class=xl7517319>&nbsp;</td>
  <td class=xl6417319></td>
  <td class=xl6417319></td>
  <td class=xl6417319></td>
  <td class=xl6417319></td>
  <td class=xl6417319></td>
  <td class=xl6417319></td>
  <td class=xl6417319></td>
  <td class=xl6417319></td>
 </tr>
 <tr height=21 style='height:15.75pt'>
  <td height=21 class=xl6417319 style='height:15.75pt'></td>
  <td class=xl6417319>Date</td>
  <td class=xl7417319><?php echo date("y/m-d",strtotime($plan_log_time)); ?></td>
  <td class=xl7517319>&nbsp;</td>
  <td class=xl7517319>&nbsp;</td>
  <td class=xl7517319>&nbsp;</td>
  <td class=xl7517319>&nbsp;</td>
  <td class=xl7517319>&nbsp;</td>
  <td class=xl7517319>&nbsp;</td>
  <td class=xl7517319>&nbsp;</td>
  <td class=xl6417319></td>
  <td class=xl6417319></td>
  <td class=xl6417319></td>
  <td class=xl6417319></td>
  <td class=xl6417319></td>
  <td class=xl6417319></td>
  <td class=xl6417319></td>
  <td class=xl6417319></td>
 </tr>
 <tr height=21 style='height:15.75pt'>
  <td height=21 class=xl6417319 style='height:15.75pt'></td>
  <td class=xl6417319>Time</td>
  <td class=xl7417319><?php echo date("H:i",strtotime($plan_log_time)); ?></td>
  <td class=xl7517319>&nbsp;</td>
  <td class=xl7517319>&nbsp;</td>
  <td class=xl7517319>&nbsp;</td>
  <td class=xl7517319>&nbsp;</td>
  <td class=xl7517319>&nbsp;</td>
  <td class=xl7517319>&nbsp;</td>
  <td class=xl7517319>&nbsp;</td>
  <td class=xl6417319></td>
  <td class=xl6417319></td>
  <td class=xl6417319></td>
  <td class=xl6417319></td>
  <td class=xl6417319></td>
  <td class=xl6417319></td>
  <td class=xl6417319></td>
  <td class=xl6417319></td>
 </tr>
 <tr height=21 style='height:15.75pt'>
  <td height=21 class=xl6517319 style='height:15.75pt'></td>
  <td class=xl6417319></td>
  <td class=xl6417319></td>
  <td class=xl6417319></td>
  <td class=xl6417319></td>
  <td class=xl6417319></td>
  <td class=xl6417319></td>
  <td class=xl6417319></td>
  <td class=xl6417319></td>
  <td class=xl6417319></td>
  <td class=xl6417319></td>
  <td class=xl6417319></td>
  <td class=xl6417319></td>
  <td class=xl6417319></td>
  <td class=xl6517319></td>
  <td class=xl6517319></td>
  <td class=xl6517319></td>
  <td class=xl6517319><!-----------------------------><!--END OF OUTPUT FROM EXCEL PUBLISH AS WEB PAGE WIZARD--><!-----------------------------></td>
 </tr>
 <![if supportMisalignedColumns]>
 <tr height=0 style='display:none'>
  <td width=20 style='width:15pt'></td>
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
  <td width=64 style='width:48pt'></td>
  <td width=19 style='width:14pt'></td>
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

	$idocs_2 = "'" . implode ( "', '", $docs ) . "'";

	$sql="update $bai_pro3.plandoc_stat_log set print_status=\"".date("Y-m-d")."\" where doc_no in ($idocs_2) and print_status is null";
	mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	
?>

