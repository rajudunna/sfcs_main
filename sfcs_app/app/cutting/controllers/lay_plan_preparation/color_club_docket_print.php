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
	
	for($s=0;$s<sizeof($sizes_code);$s++)
	{
		$o_s[$sizes_code[$s]]=$sql_row["order_s_s".$sizes_code[$s].""];
	}
	for($s=0;$s<sizeof($sizes_code);$s++)
	{
		if($sql_row["title_size_s".$sizes_code[$s].""]<>'')
		{
			$s_tit[$sizes_code[$s]]=$sql_row["title_size_s".$sizes_code[$s].""];
		}
	}	
$order_tid=$_GET['order_tid'];
if($_GET['print_status']<>'')
{
    $print=$_GET['print_status'];
}
else
{
	$print=2;
}
$sql="select * from $bai_pro3.bai_orders_db_confirm where order_tid=\"$order_tid\"";
$sql_result=mysqli_query($link, $sql) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_num_check=mysqli_num_rows($sql_result);
while($sql_row=mysqli_fetch_array($sql_result))
{
	$style=$sql_row['order_style_no']; //Style
	$color=$sql_row['order_col_des']; //color
	$division=$sql_row['order_div'];
	$delivery=$sql_row['order_del_no']; //Schedule
	$pono=$sql_row['order_po_no']; //po
	$color_code=$sql_row['color_code']; //Color Code
	$orderno=$sql_row['order_no']; 
	$o_s01=$sql_row['order_s_s01'];
	$o_s02=$sql_row['order_s_s02'];
	$o_s03=$sql_row['order_s_s03'];
	$o_s04=$sql_row['order_s_s04'];
	$o_s05=$sql_row['order_s_s05'];
	$o_s06=$sql_row['order_s_s06'];
	$o_s07=$sql_row['order_s_s07'];
	$o_s08=$sql_row['order_s_s08'];
	$o_s09=$sql_row['order_s_s09'];
	$o_s10=$sql_row['order_s_s10'];
	$o_s11=$sql_row['order_s_s11'];
	$o_s12=$sql_row['order_s_s12'];
	$o_s13=$sql_row['order_s_s13'];
	$o_s14=$sql_row['order_s_s14'];
	$o_s15=$sql_row['order_s_s15'];
	$o_s16=$sql_row['order_s_s16'];
	$o_s17=$sql_row['order_s_s17'];
	$o_s18=$sql_row['order_s_s18'];
	$o_s19=$sql_row['order_s_s19'];
	$o_s20=$sql_row['order_s_s20'];
	$o_s21=$sql_row['order_s_s21'];
	$o_s22=$sql_row['order_s_s22'];
	$o_s23=$sql_row['order_s_s23'];
	$o_s24=$sql_row['order_s_s24'];
	$o_s25=$sql_row['order_s_s25'];
	$o_s26=$sql_row['order_s_s26'];
	$o_s27=$sql_row['order_s_s27'];
	$o_s28=$sql_row['order_s_s28'];
	$o_s29=$sql_row['order_s_s29'];
	$o_s30=$sql_row['order_s_s30'];
	$o_s31=$sql_row['order_s_s31'];
	$o_s32=$sql_row['order_s_s32'];
	$o_s33=$sql_row['order_s_s33'];
	$o_s34=$sql_row['order_s_s34'];
	$o_s35=$sql_row['order_s_s35'];
	$o_s36=$sql_row['order_s_s36'];
	$o_s37=$sql_row['order_s_s37'];
	$o_s38=$sql_row['order_s_s38'];
	$o_s39=$sql_row['order_s_s39'];
	$o_s40=$sql_row['order_s_s40'];
	$o_s41=$sql_row['order_s_s41'];
	$o_s42=$sql_row['order_s_s42'];
	$o_s43=$sql_row['order_s_s43'];
	$o_s44=$sql_row['order_s_s44'];
	$o_s45=$sql_row['order_s_s45'];
	$o_s46=$sql_row['order_s_s46'];
	$o_s47=$sql_row['order_s_s47'];
	$o_s48=$sql_row['order_s_s48'];
	$o_s49=$sql_row['order_s_s49'];
	$o_s50=$sql_row['order_s_s50'];

	$order_total=$o_s01+$o_s02+$o_s03+$o_s04+$o_s05+$o_s06+$o_s07+$o_s08+$o_s09+$o_s10+$o_s11+$o_s12+$o_s13+$o_s14+$o_s15+$o_s16+$o_s17+$o_s18+$o_s19+$o_s20+$o_s21+$o_s22+$o_s23+$o_s24+$o_s25+$o_s26+$o_s27+$o_s28+$o_s29+$o_s30+$o_s31+$o_s32+$o_s33+$o_s34+$o_s35+$o_s36+$o_s37+$o_s38+$o_s39+$o_s40+$o_s41+$o_s42+$o_s43+$o_s44+$o_s45+$o_s46+$o_s47+$o_s48+$o_s49+$o_s50;

		for($s=0;$s<sizeof($sizes_code);$s++)
		{
			$o_s[$sizes_code[$s]]=$sql_row["order_s_s".$sizes_code[$s].""];
		}
		for($s=0;$s<sizeof($sizes_code);$s++)
		{
			if($sql_row["title_size_s".$sizes_code[$s].""]<>'')
			{
				$s_tit[$sizes_code[$s]]=$sql_row["title_size_s".$sizes_code[$s].""];
			}
		}	

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
$mk_length_ref=array();
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
//echo $sql;
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
	$mk_length_ref[]=$sql_row['mklength'];
	//if(substr($style,0,1)=="M") 
	$savings=$sql_row['savings'];
	$extra=round((($sql_row['material_req'])*$savings),2);
	$met_req[]=$sql_row['material_req']+$extra;
	$plies[]=$sql_row['p_plies'];
	$docs[]=$sql_row['doc_no'];
	$cc_code[]=$sql_row['color_code'];
	$date=$sql_row['date'];
	$plan_module=$sql_row['plan_module'];
	$remarks=$sql_row['remarks'];
	$mk_files[]=$sql_row['mk_file'];

	$sql1="select COALESCE(binding_consumption,0) as \"binding_consumption\" from $bai_pro3.cat_stat_log where tid=".$sql_row['cat_ref']."";
	// echo $sql1."<br>";
	$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error6".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_num_check1=mysqli_num_rows($sql_result1);
	if($sql_num_check1 > 0)
	{
		while($sql_row21=mysqli_fetch_array($sql_result1))
		{
			//echo $sql_row21['binding_consumption']."<br>";
			$binding_con1[] = $sql_row21['binding_consumption'];
		}
	}
	else
	{
		$binding_con1[]=0;
	}
		
	for($i=0;$i<sizeof($sizes_tit);$i++)
	{
		$qty[]=$sql_row["p_".$sizes_array[$i].""];
	}	
	
	$mk_ref=$sql_row['mk_ref'];
	$allocate_ref=$sql_row['allocate_ref'];

}
$idocs_2 = "'" . implode ( "', '", $docs ) . "'";
//var_dump($met_req);
$sql="select * from $bai_pro3.cat_stat_log where tid=$cat_ref";
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
	//$sql="select * from $bai_pro3.plandoc_stat_log where order_tid='$order_tid' and cat_ref=$cat_ref and  doc_no=$doc_id";
	$sql = "select * from $bai_pro3.plandoc_stat_log where order_tid=\"$order_tid\" and doc_no in ($idocs_2)";

	$sql_result=mysqli_query($link, $sql) or exit("Sql Error 2 total ratio".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_num_check=mysqli_num_rows($sql_result);
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		$mk_ref=$sql_row['mk_ref'];
		$print_status=$sql_row['print_status'];
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

	$sql_result2=mysqli_query($link,$sql2) or exit("Sql Error".mysql_error());

	while($sql_row2=mysqli_fetch_array($sql_result2))
	{
		$mklength=$sql_row2['mklength'];
		$mk_remarks=$sql_row2['remarks'];
		$patt_ver=$sql_row2['mk_ver'];
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
//echo $sql22."<bR>";
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
td,th {
	text-align:center;
}
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
	{
		padding-top:1px;
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
	white-space:nowrap;
	}
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

	.xl80173191{
		padding-top:1px;
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
		border:1px solid black;
		vertical-align:bottom;
		mso-background-source:auto;
		mso-pattern:auto;
		white-space:nowrap;
	}
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
	/* font-weight:400; */
	font-style:normal;
	text-decoration:none;
	/* font-family:Calibri, sans-serif; */
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
	/* font-weight:700; */
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
.xl10117319
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
	/* font-weight:700; */
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
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
	font-weight:bold;
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
.xl764118
	{padding-top:2px;
	padding-right:2px;
	padding-left:2px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:bold;
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
	font-weight:bold;
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
	/* font-weight:400; */
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
	font-weight:bold;
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
	font-weight:bold;
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
body { zoom:75%;}
#ad{ display:none;}
#leftbar{ display:none;}
#CUT_PLAN_NEW_13019{ width:57%; margin-left:20px;}
}
</style>

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

<script src='../../common/js/jquery-1.3.2.js'></script>
<script src='../../common/js/jquery-barcode-2.0.1.js'></script>

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
  <td colspan=6 rowspan=3 class=xl8217319x valign="top" align="left"><img src="<?= $logo ?>" width="200" height="60"></td>
  <td class=xl6417319></td>
  <td class=xl6417319></td>
  <!-- <td colspan=3 class=xl6617319>Cutting Docket</td> -->
  <table border=0 cellpadding=0 cellspacing=0 style='border-collapse: collapse;width:100%'>
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
  <td></td>
  <td class=xl6617319></td>
  <td class=xl6417319></td>
  <td class=xl6617319></td>
  <td class=xl6417319></td>
  <td class=xl6417319></td>
  <td class=xl6417319 colspan='16'></td>
  <td colspan=3 style='font-size:20px' class=xl7617319>Cutting Department</td>
  <td class=xl6417319></td>
 </tr>

 <tr height=21 style='height:15.75pt'>
  <td height=21 class=xl6417319 style='height:15.75pt'></td>
  <td class=xl6417319></td>
  <td class=xl6417319></td>
  <td class=xl6417319></td>
  <td colspan=21 class=xl6617319 height="25pt" style='text-align:center'><u>Cutting Docket</u></td> 
  <td colspan=1 class=xl7617319><strong style='font-size:16px'><?php
	if($print==1)
	{
		if($print_status=='0000-00-00' || $print_status == "") {echo "ORIGINAL"; } else {echo "DUPLICATE";}
	}
	else
	{	
		{echo "CUTTING"; }
	}
  ?></strong></td>
 </tr>
 <!-- <tr height=21 style='height:15.75pt'>
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
 </tr> -->
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
  </td>

 <tr class=xl1517319 height=21 style='height:15.75pt'>
  <td height=21 class=xl6417319 style='height:15.75pt'></td>
  <td class='xl6817319 top left'>Cut No :</td>
  <td colspan=2 class='xl9617319 top' >
  <?php if($remarks=="Normal"){ 
	  	echo leading_zeros($cut_no, 3);  
	}else if(strtolower($remarks)=="recut"){ 
		echo "Recut";
	}else if($remarks=="Pilot"){ 
		echo "Pilot";
	}
  ?></td>
  <td class='xl1517319 top'></td>
  <td colspan=2 class='xl6817319 top '>Date:</td>
  <td colspan=2 class='xl9617319 top right'><?php  echo $date; ?></td>
  <td class='xl1517319'></td>
  <td colspan=2 class='xl6817319 top left'>Category :</td>
  <td colspan=7 class='xl9617319 top'><?php echo $cat_title; ?></td>
  <td colspan=9 class='xl1517319 top right'></td>

 </tr>
 <tr>
 
 <tr class=xl1517319 height=21 style='height:15.75pt'>
  <td height=21 class=xl6417319 style='height:15.75pt'></td>
  <td class='xl6817319 left'>Style No :</td>
  <td colspan=2 class=xl9617319 style='padding-left : 5px'><?php echo $style; ?></td>
  <td class='xl1517319'></td>
  <td colspan=2 class='xl6817319'>Module:</td>
  <td colspan=2 class='xl9617319 right'><?php echo $plan_module; if($cut_table[$plan_module]) echo "(".$cut_table[$plan_module].")"; ?></td>
  <td class=xl1517319></td>
  <td colspan=2 class='xl11317319 left'>Mk Name :</td>
  <td colspan=6 class=xl9617319><?php echo $mk_remarks; ?></td>
  <td colspan=3 class='xl6817319'>Consumptions:</td>
  <td colspan=2 class='xl9617319'><?= $body_yy ?></td>
  <td colspan=5 class='xl1517319 right'></td>
 </tr>
 
 <tr class=xl1517319 height=21 style='height:15.75pt'>
  <td height=21 class=xl6417319 style='height:15.75pt'></td>
  <td class='xl6817319 left'>Sch No :</td>
  <td colspan=2 class=xl9617319><?php echo $schedule; ?></td>
  <td class='xl1517319'></td>
  <td colspan=2 class=xl6817319>PO:</td>
  <td colspan=2 class='xl9617319 right'></td>
  <td class=xl1517319></td>
  <td colspan=2 class='xl6817319 left'>Fab Direction :</td>
  <td colspan=7 class='xl11517319'><?php if($gmtway=="Y") { echo "One Gmt One Way"; } else  { echo "All Gmt One Way"; }?></td>
  <td colspan=9 class='xl1517319 right'></td>
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
  <td class='xl6817319 left'>Color :</td>
  <td colspan=7 class='xl9617319 right'>".$sch_color[0]." / ".$color_codes[0]."</td>
  <td class=xl1517319></td>
  <td colspan=2 class='xl6817319 left'>Fab Code/ Desc :</td>
  <td colspan=16 class='xl9617319 right'>".$fab_codes[0]."</td>
 </tr>";
 for($i=1;$i<sizeof($color_codes);$i++)
 {
 	echo "<tr class=xl1517319 height=21 style='height:15.75pt'>
			<td height=21 class=xl6417319 style='height:15.75pt'></td>
			<td class='xl6817319 left'>Color :</td>
			<td colspan=7 class='xl9617319 right'>".$sch_color[$i]." / ".$color_codes[$i]."</td>
			<td class=xl1517319></td>
			<td colspan=2 class='xl6817319 left'>Fab Code/ Desc :</td>
			<td colspan=16 class='xl9617319 right'>".$fab_codes[$i]."</td>
 		</tr>";
 }
 
 
 ?>
 
 <tr class=xl1517319 height=21 style='height:15.75pt'>
  <td height=21 class=xl6417319 style='height:15.75pt'></td>
  <td class='xl6917319 left'>&nbsp;</td>
  <td class=xl11617319>&nbsp;</td>
  <td class=xl11617319>&nbsp;</td>
  <td class=xl11617319>&nbsp;</td>
  <td class=xl11617319>&nbsp;</td>
  <td class='bottom'></td>
  <td class='bottom'></td>
  <td class='bottom right'>&nbsp;</td>
  <td class=''>&nbsp;</td>
  <td class='xl9717319 left'>&nbsp;</td>
  <td class='xl9717319'>&nbsp;</td>
  <td class=xl9717319>&nbsp;</td>
  <td class=xl9717319>&nbsp;</td>
  <td class=xl9717319>&nbsp;</td>
  <td class=xl9717319>&nbsp;</td>
  <td class=xl9717319>&nbsp;</td>
  <td class=xl9717319>&nbsp;</td>
  <td colspan=9 class='bottom'></td>
  <td class='xl9717319 right' ></td>
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
 </table>
 <!-- <tr height=21 style='height:15.75pt'>
  <td height=21 class=xl6417319 style='height:15.75pt'></td>
  <td colspan=27 rowspan=5 class=xl8217319> -->
  <?php
	$style_css="style='font-size:24px; font-family: Trebuchet MS, sans-serif; border:.5pt solid black; padding-left: 10px; padding-right:10px; border-collapse: collapse;'";
	echo "<table style='font-size:24px; font-family: Trebuchet MS, sans-serif; border:.5pt solid black; border-collapse: collapse;' class='width1' width=1300px>";
	echo "<tr style='mso-height-source:userset;'>";
	$sum=0;
	$divide=14;
	$divide1=$divide;
	$temp = 0;
	$fab_uom = 'Yds';
	$temp_len1=0;
	echo "<th style='border:.5pt solid black;'>Barcode</th>";
	echo "<th style='border:.5pt solid black;'>Color</th>";
	echo "<th style='border:.5pt solid black;'>Job</th>";
	echo "<th style='border:.5pt solid black;'>Doc.ID</th>";
	$total_size = sizeof($s_tit);
	// echo $total_size;
	// $total_size = 50;
	for($s=0;$s<$total_size;$s++)
	{
		echo "<th style='border:.5pt solid black;white-space:nowrap;'>".$sizes_tit[$s]."</th>";
		
		if($temp==0) {
			$divide=($divide1-4);
			$t=$s+1;
		}
		elseif($temp==1){
			$divide=$divide1;
			$t=$s+5;//starting 4 plus one
		}
		//echo $temp."--".$t."---".$divide."<br>"; 
		if(($t) % $divide == 0)
		{
			$temp_len = $s+1;
			echo "</tr><tr style='height:40px'>";
			for($i=0;$i<sizeof($color_codes);$i++) 
			{
				if($temp==0){
					echo "<td style='border:.5pt solid black;'>".'<div id="bcTarget'.$i.'" style="width:auto;"></div><script>$("#bcTarget'.$i.'").barcode("D'.$docs[$i].'", "code39",{barWidth:2,barHeight:15,moduleSize:5,fontSize:0});</script>'."</td>";
					echo "<td style='border:.5pt solid black;'>".$color_codes[$i]."</td>";
					echo "<td style='border:.5pt solid black;'>".chr($cc_code[$i]).leading_zeros($cut_no, 3)."</td>";
					echo "<td style='border:.5pt solid black;'>".$docs[$i]."</td>";
				}
				$fab_bind[$i] = (float)$binding_con1[$i]*(int)$plies[$i]*(float)$a_ratio_tot;//Caliculation for Bind/Rib
				$total_yds[$i]=$met_req[$i]+$fab_bind[$i];
				$sum+=  $total_yds[$i];
				for($j=$temp_len1;$j<$temp_len;$j++)
				{
					echo "<td style='border:.5pt solid black;'>".$qty[$j]."</td>";
				}
				echo "</tr>";
			}
			echo "<tr height=10 style='height:15.75pt'></tr></table><table style='font-size:24px;font-family: Trebuchet MS, sans-serif;border:.5pt solid black; border-collapse: collapse;' class='width1' width=1500px>";
			$temp = 1;
			$temp_len1=$temp_len;
		}
		if($temp<>1)
		{
			for($i=0;$i<sizeof($color_codes);$i++) 
			{
				$fab_bind[$i] = (float)$binding_con1[$i]*(int)$plies[$i]*(float)$a_ratio_tot;//Caliculation for Bind/Rib
				$total_yds[$i]=$met_req[$i]+$fab_bind[$i];
				$sum+=  $total_yds[$i];
			}
		}
		if($s+1==$total_size) 
		{
			$m = $s+5;
			if(($m % $divide)!= 0) 
			{
				if((($m+1) % $divide) == 0) 
				{
					
					echo "<th style='border:.5pt solid black;'>Ratio</th>";
					echo "</tr>";
					for($j=0;$j<sizeof($color_codes);$j++)
					{
						echo "<tr>";
						if($temp==0){
							echo "<td style='border:.5pt solid black;'>".'<div id="bcTarget'.$j.'" style="width:auto;"></div><script>$("#bcTarget'.$j.'").barcode("D'.$docs[$j].'", "code39",{barWidth:2,barHeight:15,moduleSize:5,fontSize:0});</script>'."</td>";
							echo "<td style='border:.5pt solid black;'>".$color_codes[$j]."</td>";
							echo "<td style='border:.5pt solid black;'>".chr($cc_code[$j]).leading_zeros($cut_no, 3)."</td>";
							echo "<td style='border:.5pt solid black;'>".$docs[$j]."</td>";
						}
						for($k=$temp_len1;$k<$total_size;$k++)
						{
							echo "<td style='border:.5pt solid black;'>".$qty[$k]."</td>";
						}
						echo "<td style='border:.5pt solid black;'>".$a_ratio_tot."</td></tr>";
					}
					echo "<tr height=10 style='height:15.75pt'></tr></table><table style='font-size:24px;font-family: Trebuchet MS, sans-serif;border:.5pt solid black; border-collapse: collapse;' class='width1'>";
					echo "<th style='border:.5pt solid black;'>Plies</th>";
					echo "<th style='border:.5pt solid black;'>Quantity </br>(Total Garments)</th>";
					echo "<th style='border:.5pt solid black;'>MK Length</th>";
					echo "<th style='border:.5pt solid black;'>$category $fab_uom</th>";
					echo "<th style='border:.5pt solid black;'>(Bind/Rib) $fab_uom</th>";
					echo "<th style='border:.5pt solid black;'>Total</th></tr>";
					for($j=0;$j<sizeof($color_codes);$j++)
					{
						echo "<tr>";
						echo "<td style='border:.5pt solid black;'>".round( $plies[$j] , 2 )."</td>";
						echo "<td style='border:.5pt solid black;'>".($a_ratio_tot)*($plies[$j])."</td>";
						echo "<td style='border:.5pt solid black;'>".round( $mk_length_ref[$j] , 2 )."</td>";
						echo "<td style='border:.5pt solid black;'>".$met_req[$j]."</td>";
						echo "<td style='border:.5pt solid black;'>".$fab_bind[$j]."</td>";
						echo "<td style='border:.5pt solid black;'>".$total_yds[$j]."</td>";
						$fab_total+=$fab_bind[$j];
						echo "</tr>";
					}
					echo "</table>";
				}
				elseif((($m+2) % $divide) == 0) 
				{
					echo "<th style='border:.5pt solid black;'>Ratio</th>";
					echo "<th style='border:.5pt solid black;'>Plies</th>";
					echo "</tr>";
					for($j=0;$j<sizeof($color_codes);$j++)
					{
						echo "<tr>";
						if($temp==0){
							echo "<td style='border:.5pt solid black;'>".'<div id="bcTarget'.$j.'" style="width:auto;"></div><script>$("#bcTarget'.$j.'").barcode("D'.$docs[$j].'", "code39",{barWidth:2,barHeight:15,moduleSize:5,fontSize:0});</script>'."</td>";
							echo "<td style='border:.5pt solid black;'>".$color_codes[$j]."</td>";
							echo "<td style='border:.5pt solid black;'>".chr($cc_code[$j]).leading_zeros($cut_no, 3)."</td>";
							echo "<td style='border:.5pt solid black;'>".$docs[$j]."</td>";
						}
						for($k=$temp_len1;$k<$total_size;$k++)
						{
							echo "<td style='border:.5pt solid black;'>".$qty[$k]."</td>";
						}
						echo "<td style='border:.5pt solid black;'>".$a_ratio_tot."</td>";
						echo "<td style='border:.5pt solid black;'>".round( $plies[$j] , 2 )."</td></tr>";
					}
					echo "<tr height=10 style='height:15.75pt'></tr></table><table style='font-size:24px;font-family: Trebuchet MS, sans-serif;border:.5pt solid black; border-collapse: collapse;'  class='width1'>";
					echo "<th style='border:.5pt solid black;'>Quantity </br>(Total Garments)</th>";
					echo "<th style='border:.5pt solid black;'>MK Length</th>";
					echo "<th style='border:.5pt solid black;'>$category $fab_uom</th>";
					echo "<th style='border:.5pt solid black;'>(Bind/Rib) $fab_uom</th>";
					echo "<th style='border:.5pt solid black;'>Total</th></tr>";
					for($j=0;$j<sizeof($color_codes);$j++)
					{
						echo "<tr>";
						echo "<td style='border:.5pt solid black;'>".($a_ratio_tot)*($plies[$j])."</td>";
						echo "<td style='border:.5pt solid black;'>".round( $mk_length_ref[$j] , 2 )."</td>";
						echo "<td style='border:.5pt solid black;'>".$met_req[$j]."</td>";
						echo "<td style='border:.5pt solid black;'>".$fab_bind[$j]."</td>";
						echo "<td style='border:.5pt solid black;'>".$total_yds[$j]."</td>";
						$fab_total+=$fab_bind[$j];
						echo "</tr>";
					}
					echo "</table>";
				}
				elseif((($m+3) % $divide) == 0) 
				{
					echo "<th style='border:.5pt solid black;'>Ratio</th>";
					echo "<th style='border:.5pt solid black;'>Plies</th>";
					echo "<th style='border:.5pt solid black;'>Quantity </br>(Total Garments)</th>";
						echo "</tr>";
						for($j=0;$j<sizeof($color_codes);$j++)
						{
							echo "<tr>";
							if($temp==0){
								echo "<td style='border:.5pt solid black;'>".'<div id="bcTarget'.$j.'" style="width:auto;"></div><script>$("#bcTarget'.$j.'").barcode("D'.$docs[$j].'", "code39",{barWidth:2,barHeight:15,moduleSize:5,fontSize:0});</script>'."</td>";
								echo "<td style='border:.5pt solid black;'>".$color_codes[$j]."</td>";
								echo "<td style='border:.5pt solid black;'>".chr($cc_code[$j]).leading_zeros($cut_no, 3)."</td>";
								echo "<td style='border:.5pt solid black;'>".$docs[$j]."</td>";
							}
							for($k=$temp_len1;$k<$total_size;$k++)
							{
								echo "<td style='border:.5pt solid black;'>".$qty[$k]."</td>";
							}
							echo "<td style='border:.5pt solid black;'>".$a_ratio_tot."</td>";
							echo "<td style='border:.5pt solid black;'>".round( $plies[$j] , 2 )."</td>";
							echo "<th style='border:.5pt solid black;'>".($a_ratio_tot)*($plies[$j])."</th></tr>";
						}
						echo "<tr height=10 style='height:15.75pt'></tr></table><table style='font-size:24px;font-family: Trebuchet MS, sans-serif;border:.5pt solid black; border-collapse: collapse;'  class='width1'>";
						echo "<th style='border:.5pt solid black;'>MK Length</th>";
						echo "<th style='border:.5pt solid black;'>$category $fab_uom</th>";
						echo "<th style='border:.5pt solid black;'>(Bind/Rib) $fab_uom</th>";
						echo "<th style='border:.5pt solid black;'>Total</th></tr>";
						for($j=0;$j<sizeof($color_codes);$j++)
						{
							echo "<tr>";
							echo "<td style='border:.5pt solid black;'>".round( $mk_length_ref[$j] , 2 )."</td>";
							echo "<td style='border:.5pt solid black;'>".$met_req[$j]."</td>";
							echo "<td style='border:.5pt solid black;'>".$fab_bind[$j]."</td>";
							echo "<td style='border:.5pt solid black;'>".$total_yds[$j]."</td>";
							$fab_total+=$fab_bind[$j];
							echo "</tr>";
						}
						echo "</table>";
				}
				elseif((($m+4) % $divide) == 0) 
				{
					echo "<th style='border:.5pt solid black;'>Ratio</th>";
					echo "<th style='border:.5pt solid black;'>Plies</th>";
					echo "<th style='border:.5pt solid black;'>Quantity </br>(Total Garments)</th>";
					echo "<th style='border:.5pt solid black;'>MK Length</th>";
						echo "</tr>";
						for($j=0;$j<sizeof($color_codes);$j++)
						{
							echo "<tr>";
							if($temp==0){
								echo "<td style='border:.5pt solid black;'>".'<div id="bcTarget'.$j.'" style="width:auto;"></div><script>$("#bcTarget'.$j.'").barcode("D'.$docs[$j].'", "code39",{barWidth:2,barHeight:15,moduleSize:5,fontSize:0});</script>'."</td>";
								echo "<td style='border:.5pt solid black;'>".$color_codes[$j]."</td>";
								echo "<td style='border:.5pt solid black;'>".chr($cc_code[$j]).leading_zeros($cut_no, 3)."</td>";
								echo "<td style='border:.5pt solid black;'>".$docs[$j]."</td>";
							}
							for($k=$temp_len1;$k<$total_size;$k++)
							{
								echo "<td style='border:.5pt solid black;'>".$qty[$k]."</td>";
							}
							echo "<td style='border:.5pt solid black;'>".$a_ratio_tot."</td>";
							echo "<td style='border:.5pt solid black;'>".round( $plies[$j] , 2 )."</td>";
							echo "<th style='border:.5pt solid black;'>".($a_ratio_tot)*($plies[$j])."</th>";
							echo "<td style='border:.5pt solid black;'>".round( $mk_length_ref[$j] , 2 )."</td></tr>";
						}
						echo "<tr height=10 style='height:15.75pt'></tr></table><table style='font-size:24px;font-family: Trebuchet MS, sans-serif;border:.5pt solid black; border-collapse: collapse;' class='width1'>";
						echo "<th style='border:.5pt solid black;'>$category $fab_uom</th>";
						echo "<th style='border:.5pt solid black;'>(Bind/Rib) $fab_uom</th>";
						echo "<th style='border:.5pt solid black;'>Total</th></tr>";
						for($j=0;$j<sizeof($color_codes);$j++)
						{
							echo "<tr>";
							echo "<td style='border:.5pt solid black;'>".$met_req[$j]."</td>";
							echo "<td style='border:.5pt solid black;'>".$fab_bind[$j]."</td>";
							echo "<td style='border:.5pt solid black;'>".$total_yds[$j]."</td>";
							$fab_total+=$fab_bind[$j];
							echo "</tr>";
						}
						echo "</table>";
				}
				elseif((($m+5) % $divide) == 0) 
				{
					echo "<th style='border:.5pt solid black;'>Ratio</th>";
					echo "<th style='border:.5pt solid black;'>Plies</th>";
					echo "<th style='border:.5pt solid black;'>Quantity </br>(Total Garments)</th>";
					echo "<th style='border:.5pt solid black;'>MK Length</th>";
					echo "<th style='border:.5pt solid black;'>$category $fab_uom</th>";
						echo "</tr>";
						for($j=0;$j<sizeof($color_codes);$j++)
						{
							echo "<tr>";
							if($temp==0){
								echo "<td style='border:.5pt solid black;'>".'<div id="bcTarget'.$j.'" style="width:auto;"></div><script>$("#bcTarget'.$j.'").barcode("D'.$docs[$j].'", "code39",{barWidth:2,barHeight:15,moduleSize:5,fontSize:0});</script>'."</td>";
								echo "<td style='border:.5pt solid black;'>".$color_codes[$j]."</td>";
								echo "<td style='border:.5pt solid black;'>".chr($cc_code[$j]).leading_zeros($cut_no, 3)."</td>";
								echo "<td style='border:.5pt solid black;'>".$docs[$j]."</td>";
							}
							for($k=$temp_len1;$k<$total_size;$k++)
							{
								echo "<td style='border:.5pt solid black;'>".$qty[$k]."</td>";
							}
							echo "<td style='border:.5pt solid black;'>".$a_ratio_tot."</td>";
							echo "<td style='border:.5pt solid black;'>".round( $plies[$j] , 2 )."</td>";
							echo "<th style='border:.5pt solid black;'>".($a_ratio_tot)*($plies[$j])."</th>";
							echo "<td style='border:.5pt solid black;'>".round( $mk_length_ref[$j] , 2 )."</td>";
							echo "<td style='border:.5pt solid black;'>".$met_req[$j]."</td></tr>";
						}
						echo "<tr height=10 style='height:15.75pt'></tr></table><table style='font-size:24px;font-family: Trebuchet MS, sans-serif;border:.5pt solid black; border-collapse: collapse;'>";
						echo "<th style='border:.5pt solid black;'>(Bind/Rib) $fab_uom</th>";
						echo "<th style='border:.5pt solid black;'>Total</th></tr>";
						for($j=0;$j<sizeof($color_codes);$j++)
						{
							echo "<tr>";
							echo "<td style='border:.5pt solid black;'>".$fab_bind[$j]."</td>";
							echo "<td style='border:.5pt solid black;'>".$total_yds[$j]."</td>";
							$fab_total+=$fab_bind[$j];
							echo "</tr>";
						}
						echo "</table>";
				}
				elseif((($m+6) % $divide) == 0) 
				{
					echo "<th style='border:.5pt solid black;'>Ratio</th>";
					echo "<th style='border:.5pt solid black;'>Plies</th>";
					echo "<th style='border:.5pt solid black;'>Quantity </br>(Total Garments)</th>";
					echo "<th style='border:.5pt solid black;'>MK Length</th>";
					echo "<th style='border:.5pt solid black;'>$category $fab_uom</th>";
					echo "<th style='border:.5pt solid black;'>(Bind/Rib) $fab_uom</th>";
						echo "</tr>";
						for($j=0;$j<sizeof($color_codes);$j++)
						{
							echo "<tr>";
							if($temp==0){
								echo "<td style='border:.5pt solid black;'>".'<div id="bcTarget'.$j.'" style="width:auto;"></div><script>$("#bcTarget'.$j.'").barcode("D'.$docs[$j].'", "code39",{barWidth:2,barHeight:15,moduleSize:5,fontSize:0});</script>'."</td>";
								echo "<td style='border:.5pt solid black;'>".$color_codes[$j]."</td>";
								echo "<td style='border:.5pt solid black;'>".chr($cc_code[$j]).leading_zeros($cut_no, 3)."</td>";
								echo "<td style='border:.5pt solid black;'>".$docs[$j]."</td>";
							}
							for($k=$temp_len1;$k<$total_size;$k++)
							{
								echo "<td style='border:.5pt solid black;'>".$qty[$k]."</td>";
							}
							echo "<td style='border:.5pt solid black;'>".$a_ratio_tot."</td>";
							echo "<td style='border:.5pt solid black;'>".round( $plies[$j] , 2 )."</td>";
							echo "<th style='border:.5pt solid black;'>".($a_ratio_tot)*($plies[$j])."</th>";
							echo "<td style='border:.5pt solid black;'>".round( $mk_length_ref[$j] , 2 )."</td>";
							echo "<td style='border:.5pt solid black;'>".$met_req[$j]."</td>";
							echo "<td style='border:.5pt solid black;'>".$fab_bind[$j]."</td></tr>";
						}
						echo "<tr height=10 style='height:15.75pt'></tr></table><table style='font-size:24px;font-family: Trebuchet MS, sans-serif;border:.5pt solid black; border-collapse: collapse;'>";
						echo "<th style='border:.5pt solid black;'>Total</th></tr>";
						for($j=0;$j<sizeof($color_codes);$j++)
						{
							echo "<tr>";
							echo "<td style='border:.5pt solid black;'>".$total_yds[$j]."</td>";
							$fab_total+=$fab_bind[$j];
							echo "</tr>";
						}
						echo "</table>";
				}
				else 
				{
					echo "<th style='border:.5pt solid black;'>Ratio</th>";
					echo "<th style='border:.5pt solid black;'>Plies</th>";
					echo "<th style='border:.5pt solid black;'>Quantity </br>(Total Garments)</th>";
					echo "<th style='border:.5pt solid black;'>MK Length</th>";
					echo "<th style='border:.5pt solid black;'>$category $fab_uom</th>";
					echo "<th style='border:.5pt solid black;'>(Bind/Rib) $fab_uom</th>";
					echo "<th style='border:.5pt solid black;'>Total</th>";
					for($j=0;$j<sizeof($color_codes);$j++)
					{
						echo "</tr>";
						if($temp==0){
							echo "<td style='border:.5pt solid black;'>".'<div id="bcTarget'.$j.'" style="width:auto;"></div><script>$("#bcTarget'.$j.'").barcode("D'.$docs[$j].'", "code39",{barWidth:2,barHeight:15,moduleSize:5,fontSize:0});</script>'."</td>";
							echo "<td style='border:.5pt solid black;'>".$color_codes[$j]."</td>";
							echo "<td style='border:.5pt solid black;'>".chr($cc_code[$j]).leading_zeros($cut_no, 3)."</td>";
							echo "<td style='border:.5pt solid black;'>".$docs[$j]."</td>";
						}
						echo "<tr style='height:40px'>";
						for($k=$temp_len1;$k<$total_size;$k++)
						{
							echo "<td style='border:.5pt solid black;'>".$qty[$k]."</td>";
						}
						echo $j.'$j';
						echo "<td style='border:.5pt solid black;'>".$a_ratio_tot."</td>";
						echo "<td style='border:.5pt solid black;'>".round( $plies[$j] , 2 )."</td>";
						echo "<th style='border:.5pt solid black;'>".($a_ratio_tot)*($plies[$j])."</th>";
						echo "<td style='border:.5pt solid black;'>".round( $mk_length_ref[$j] , 2 )."</td>";
						echo "<td style='border:.5pt solid black;'>".$met_req[$j]."</td>";
						echo "<td style='border:.5pt solid black;'>".$fab_bind[$j]."</td>";
						echo "<td style='border:.5pt solid black;'>".$total_yds[$j]."</td>";
						$fab_total+=$fab_bind[$j];
						echo "</tr>";
					}
				}
			}
			else 
			{
				echo "<th style='border:.5pt solid black;'>Ratio</th>";
				echo "<th style='border:.5pt solid black;'>Plies</th>";
				echo "<th style='border:.5pt solid black;'>Quantity </br>(Total Garments)</th>";
				echo "<th style='border:.5pt solid black;'>MK Length</th>";
				echo "<th style='border:.5pt solid black;'>$category $fab_uom</th>";
				echo "<th style='border:.5pt solid black;'>(Bind/Rib) $fab_uom</th>";
				echo "<th style='border:.5pt solid black;'>Total</th>";
				for($j=0;$j<sizeof($color_codes);$j++)
				{
					echo "</tr><tr style='height:40px'>";
					if($temp==0){
					echo "<td style='border:.5pt solid black;'>".'<div id="bcTarget'.$j.'" style="width:auto;"></div><script>$("#bcTarget'.$j.'").barcode("D'.$docs[$j].'", "code39",{barWidth:2,barHeight:15,moduleSize:5,fontSize:0});</script>'."</td>";
					echo "<td style='border:.5pt solid black;'>".$color_codes[$j]."</td>";
					echo "<td style='border:.5pt solid black;'>".chr($cc_code[$j]).leading_zeros($cut_no, 3)."</td>";
					echo "<td style='border:.5pt solid black;'>".$docs[$j]."</td>";
					}
					for($k=$temp_len1;$k<$total_size;$k++)
					{
						echo "<td style='border:.5pt solid black;'>".$qty[$k]."</td>";
					}
					//echo $j.'$j';
					echo "<td style='border:.5pt solid black;'>".$a_ratio_tot."</td>";
					echo "<td style='border:.5pt solid black;'>".round( $plies[$j] , 2 )."</td>";
					echo "<th style='border:.5pt solid black;'>".($a_ratio_tot)*($plies[$j])."</th>";
					echo "<td style='border:.5pt solid black;'>".round( $mk_length_ref[$j] , 2 )."</td>";
					echo "<td style='border:.5pt solid black;'>".$met_req[$j]."</td>";
					echo "<td style='border:.5pt solid black;'>".$fab_bind[$j]."</td>";
					echo "<td style='border:.5pt solid black;'>".$total_yds[$j]."</td>";
					$fab_total+=$fab_bind[$j];
					echo "</tr>";
				}
			}
			
		}
	}
	echo "</tr>";
	echo "</table>";
	
  ?>
  

  <table border=0 cellpadding=0 cellspacing=0 style='border-collapse: collapse;width:100%; font-family: Trebuchet MS, sans-serif;'>
  <tr height=10 style='height:5pt'>
  <td height=10 class=xl6417319 style='height:15.75pt'></td>
  <td class=xl6417319></td>
 </tr>
 <tr height=10 style='height:5pt'>
  <td height=10 class=xl6417319 style='height:5pt'></td>
  <td class=xl6417319></td>
 </tr>


 <tr height=21 style='height:10.75pt'>
  <td height=21 class=xl8217319 style='height:15.75pt'></td>
  <td rowspan=2 class=xl8917319 colspan=1 style='border-bottom:.5pt solid black; width:48pt'>Pattern<br/>Version</td>
  <td rowspan=2 class=xl8917319 width=64 style='border-bottom:.5pt solid black;  width:48pt'>No of Plies</td>
  <td rowspan=2 class=xl8917319 width=64 style='border-bottom:.5pt solid black;
  width:48pt'>Pur Width</td>
  <!--<td rowspan=2 class=xl8917319 width=64 style='border-bottom:.5pt solid black; width:48pt'>Marker Length</td>-->
  <td rowspan=2 colspan=1 class=xl8917319 width=64 style='border-bottom:.5pt solid black;'>Req. Qty <br/>(<?php echo $fab_uom; ?>)</td>
  <td rowspan=2 class=xl8917319 width=64 style='border-bottom:.5pt solid black;
  width:48pt'>Act. Width</td>
  <td rowspan=2 colspan=1 class=xl8917319 width=70 style='border-bottom:.5pt solid black;'>Cutting<br/>wastage %</td>
   <!--<td rowspan=2 colspan=1 class='xl8917319 autox'width=80 style='border-bottom:.5pt solid black;
  width:60px'>Binding<br/> Cons.</td>-->
  <td rowspan=2   colspan=2 class='xl8917319 autox' width=80 style='border-bottom:.5pt solid black;
  width:70px'>Fab. Req for lay</td>
  <td rowspan=2  colspan=2 class='autox xl8917319' width=80 style='border-bottom:.5pt solid black;
  width:70px'>Fab. Req for Binding</td>
  <td rowspan=2  colspan=2 class='autox xl8917319' style='border-bottom:.5pt solid black'>Total Fab. Req</td>
  <td rowspan=2 colspan=2  class=xl8917319 style='border-bottom:.5pt solid black;width:auto'>Marker Length<br/>(actual)</td>
  <td colspan=2 rowspan=2 class=xl8917319  style='border-bottom:.5pt solid black;'>Act. Req Qty (<?php echo $fab_uom; ?>)</td>
  <td colspan=2 rowspan=2 class=xl8917319  style='border-bottom:.5pt solid black;'>Issued Qty (<?php echo $fab_uom; ?>)</td>
  <td colspan=1 rowspan=2 class=xl8917319  style='width: 115px;border-bottom:.5pt solid black;'>Return Qty (<?php echo $fab_uom; ?>)</td>
  <td></td>
  <td colspan=4 rowspan=4 class=xl10117319 style='border-right:1.0pt solid black;
  border-bottom:1.0pt solid black'>Fabric <br/>Swatch</td>
  <td class=xl8217319></td>
 </tr>
 <tr height=21 style='height:15.75pt'>
  <td height=21 class=xl8217319 style='height:15.75pt'></td>
  <td></td>
  <td class=xl8217319></td>
 </tr>

 <tr height=21 style='height:15.75pt'>
  <td height=21 class=xl6417319 style='height:15.75pt'></td>
  <td rowspan=2 colspan=1 class=xl9817319 width=64 style='border-bottom:.5pt solid black;
  border-top:none;'><?php echo $patt_ver; ?></td>
  <td rowspan=2 class=xl10017319 width=64 style='border-bottom:.5pt solid black;
  border-top:none;width:48pt'><?php echo array_sum($plies); ?></td>
  <td rowspan=2 class=xl10017319 width=64 style='border-bottom:.5pt solid black;
  border-top:none;width:48pt'><?php echo $purwidth; ?></td>
  <td rowspan=2 class=xl9817319 width=64 style='border-bottom:.5pt solid black;
  border-top:none;width:48pt'><?php echo round(array_sum($met_req),2); ?></td>
  <td rowspan=2 colspan=1 class=xl10017319 width=64 style='border-bottom:.5pt solid black;
  border-top:none;'><?php echo $actwidth; ?></td>
  <td rowspan=2 class=xl10017319 width=64 style='border-bottom:.5pt solid black;
  border-top:none;width:48pt'><?php echo $cuttable_wastage*100; ?></td>	
  <td rowspan=2 colspan=1 class=xl10017319 width=70 style='border-bottom:.5pt solid black;'><?php  ?></td>
  <td rowspan=2 colspan=1 class=xl10017319 width=64 style='border-bottom:.5pt solid black;width:48pt'><?php echo $fab_uom; ?></td>
  <td rowspan=2 colspan=2  class=xl10017319 width=64 style='border-bottom:.5pt solid black;
  width:48pt'><?php $fab_bind = round($fab_total,2); echo round($fab_total,2);echo '<br/>('.$fab_uom.')'; ?></td>
  <td rowspan=2 colspan=2  class=xl10017319 style='border-bottom:.5pt solid black;
  width:48pt'><?php echo round($fab_bind+$fab_lay_sum+array_sum($met_req),2);echo '<br/>('.$fab_uom.')'; ?></td>
  <td rowspan=2 colspan=2  class=xl10017319 width=64 style='border-bottom:.5pt solid black;'>
  <?php echo $act_mk_length; ?></td>
  <td rowspan=2 colspan=2  class=xl10017319 style='border-bottom:.5pt solid black;
  border-top:none;'><?php echo round($fab_bind+$fab_lay_sum+array_sum($met_req),2);?></td>
  <td colspan=2  rowspan=2 class=xl10017319 width=64 style='border-bottom:.5pt solid black;
  border-top:none;'>&nbsp;</td>
  <td colspan=1  rowspan=2 class=xl10017319 width=64 style='border-bottom:.5pt solid black;
  border-top:none;'>&nbsp;</td>
  <!-- <td colspan=2  rowspan=2 class=xl10017319 width=64 style='border-bottom:.5pt solid black;
  border-top:none;'>&nbsp;</td> -->
  <td></td>
  <td class=xl6417319></td>
  <td class=xl6417319></td>
 </tr>
 <tr height=22 style='height:16.5pt'>
  <td height=22 class=xl6417319 style='height:16.5pt'></td>
  <td></td>
  <td class=xl6417319></td>
  <td class=xl6417319></td>
 </tr>
 <!-- <tr >
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
  <td class=xl6417319></td>
  <td class=xl6417319></td>
  <td class=xl6417319></td>
  <td class=xl6417319></td>
  <td class=xl6417319></td>
  <td class=xl6417319></td>
  <td class=xl6417319></td>
  <td class=xl6417319 colspan="3"><br/><br/><u><strong>Quality Authorisation</strong></u><br/><br/><br/><u><strong>Cutting Supervisor Authorization</strong></u></td>
 </tr> -->

 <tr height=21 style='height:15.75pt'>
  <td height=21 class=xl8217319 style='height:15.75pt'></td>
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
  <!-- <td class=xl8217319></td> -->
  <td class=xl8217319>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
  <td class=xl8217319>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
  <td class=xl8217319>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
  <td class=xl6417319 colspan="3"><br/><u><strong>Quality Authorisation</strong></u><br/><br/><br/><u><strong>Cutting Supervisor Authorization</strong></u></td>
 </tr>
  <tr height=21 style='height:15.75pt'>
  <td height=21 class=xl8217319 style='height:15.75pt'></td>
  </tr>
  <tr height=21 style='height:15.75pt'>
  <td height=21 class=xl821731ff9 style='height:15.75pt'></td>
  </tr>

 

 
 

 <tr style='height:10px'></tr>	
 <tr>
  <td class=xl6417319></td>
  <td colspan=27 rowspan=7 class=xl8217319>
  
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
	$item_name[] = $sql_row['item'];
} 

echo "<table border=0 cellpadding=0 cellspacing=0 align='left' style='border-collapse: collapse;width:100%'>
<tr class=xl674118 height=20 style='mso-height-source:userset;height:5.0pt'>
  <td height=20 class=xl674118 style='height:15.0pt'></td>
  <td class=xl764118 style='width: 38px;'>Batch</td>
  <td class='xl764118' style='width: 112px;'>Fabric Name</td>
  <td class=xl764118>Lot No</td>
  <td class=xl764118>Shade</td>
  <td class=xl764118>Location</td>
  <td class=xl774118>Roll </br> No</td>
  <td rowspan=2 class=xl1144118 width=64 style='border-bottom:.5pt solid black;  width:48pt'>Ticket Length</td>
  <td rowspan=2 class=xl1144118 width=64 style='border-bottom:.5pt solid black;  width:48pt'>C-tex<br/>Length</td>
  <td rowspan=2 class=xl1144118 width=64 style='border-bottom:.5pt solid black;  width:48pt'>C-tex<br/>Width</td>
  <td rowspan=2 class=xl1144118 width=64 style='border-bottom:.5pt solid black;  width:48pt'>Allocated Qty</td>
  <td class=xl774118>Plies</td>
  <td rowspan=2 class=xl1144118 width=64 style='border-bottom:.5pt solid black;  width:150pt'>Net<br/>Length</td>
  <td class=xl774118>Damage</td>
  <td class=xl774118>Joints</td>
  <td class=xl774118>Ends</td>

  <td colspan=2 class=xl1064118>Shortages</td>
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
  <td class=xl744118>Excess</td>
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
</thead>
<tbody>";
$tot_tick_len=0;
$tot_ctex_len=0;
$tot_alloc_qty=0;
$tot_bind_len=0;
if(sizeof($roll_det)>0)
 {
	for($i=0;$i<sizeof($roll_det);$i++){
		?>
		<tr class=xl654118 height=30 style='mso-height-source:userset;height:30pt'>
			<td height=20 class=xl654118 style='height:30pt'></td>
			<td class=xl804118 style='text-align:center;padding-bottom:5pt;'><?php echo $batch_det[$i]; ?></td>
			<td class=xl804118 style='text-align:center;padding-bottom:5pt;'><?php echo $item_name[$i]; ?></td>
			<td class=xl814118 style='text-align:center;padding-bottom:5pt;'><?php echo $lot_det[$i]; ?></td>
			
			<td class=xl814118 style='text-align:center;padding-bottom:5pt;'><?php echo $shade_det[$i]; ?></td>
			<td class=xl814118 style='text-align:center;padding-bottom:5pt;'><?php echo $locan_det[$i]; ?></td>
			<td class=xl814118 style='text-align:center;padding-bottom:5pt;'><?php echo $roll_det[$i]; ?></td>
			<td class=xl814118 style='text-align:right;padding-bottom:5pt;'><?php echo $tkt_len[$i]; $tot_tick_len=$tot_tick_len+$tkt_len[$i];?></td>
			<td class=xl814118 style='text-align:right;padding-bottom:5pt;'><?php echo $ctex_len[$i]; $tot_ctex_len=$tot_ctex_len+$ctex_len[$i];?></td>
			<td class=xl814118 style='text-align:right;padding-bottom:5pt;'><?php echo $ctex_width[$i]; ?></td>
			<td class=xl814118 style='text-align:right;padding-bottom:5pt;'><?php echo $leng_det[$i]; $tot_alloc_qty=$tot_alloc_qty+$leng_det[$i];?></td>
			<td class=xl814118 style='text-align:right;padding-bottom:5pt;'>&nbsp;</td>
			<td class=xl814118 style='text-align:right;padding-bottom:5pt;'>&nbsp;</td>
			<td class=xl814118 style='text-align:right;padding-bottom:5pt;'>&nbsp;</td>
			<td class=xl814118 style='text-align:right;padding-bottom:5pt;'>&nbsp;</td>
			<td class=xl814118 style='text-align:right;padding-bottom:5pt;'>&nbsp;</td>
			<td class=xl814118 style='text-align:right;padding-bottom:5pt;'>&nbsp;</td>
			<td class=xl814118 style='text-align:right;padding-bottom:5pt;'>&nbsp;</td>
			<td colspan=1 class=xl684118 style='text-align:right;padding-bottom:5pt;'><?php echo round(($ctex_width[$i]-$tkt_width[$i]),2); $tot_bind_len=$tot_bind_len+($ctex_width[$i]-$tkt_width[$i]);?></td>
			<td colspan=3 class=xl684118 style='border-left:none; text-align:center;padding-bottom:5pt;'></td>
			<td class=xl654118 style='text-align:center;padding-bottom:5pt;'></td>
		</tr>
	<?php
	}
		for($i=0;$i<16-sizeof($roll_det);$i++){
		echo "<tr class=xl654118 height=30 style='mso-height-source:userset;height:30pt'>
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
		</tr>"; 
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
	for($i=0;$i<16;$i++){
		echo "<tr class=xl654118 height=30 style='mso-height-source:userset;height:30pt'>
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
		</tr>"; 
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
echo "</tbody></table>";	
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
  <td height=21 class=xl8217319 style='height:15.75pt'></td>
  </tr>
  <tr height=21 style='height:15.75pt'>
  <td height=21 class=xl821731ff9 style='height:15.75pt'></td>
  </tr>
  </table>
  <table class=lasttable width=1200px>
 <tr height=30 style='height:15.75pt'>
 </tr>
 <tr height=30 style='height:30pt' >
  <td height=30 class=xl6417319 style='height:30pt'></td>
  <td colspan=2 ></td>
  <td colspan=2 class=xl7017319 style='border:.5pt solid black;'>Docket</td>
  <td colspan=2 class=xl8017319>Marker</td>
  <td colspan=2 class=xl8017319>Issuing</td>
  <td colspan=2 class=xl8017319>Laying</td>
  <td colspan=2 class=xl8017319>Cutting</td>
  <td colspan=2 class=xl8017319>Return</td>
  <td colspan=2 class=xl8017319>Bundling</td>
  <td colspan=3 class=xl8017319>Dispatch</td>
  <td colspan=6 ></td>
  <td colspan=2 class=xl6417319>Act Con</td>
  <td colspan=3>_____________________________________</td>
 </tr>
 <tr height=30 style='height:30pt'>
  <td height=30 class=xl6417319 style='height:30pt'></td>
  <td colspan=2 class=xl6417319>Team</td>
  <td colspan=2 class=xl7017319>&nbsp;</td>
  <td colspan=2 class=xl7517319>&nbsp;</td>
  <td colspan=2 class=xl7517319>&nbsp;</td>
  <td colspan=2 class=xl7517319>&nbsp;</td>
  <td colspan=2 class=xl7517319>&nbsp;</td>
  <td colspan=2 class=xl7517319>&nbsp;</td>
  <td colspan=2 class=xl7517319>&nbsp;</td>
  <td colspan=3 class=xl7517319>&nbsp;</td>
  <td colspan=6 ></td>
  <td colspan=2 class=xl6417319>Saving %</td>
  <td colspan=3>_____________________________________</td>
  <td colspan=2 class=xl6417319></td>
  <td colspan=2 class=xl6417319></td>
  <td colspan=2 class=xl6417319></td>
 </tr>
 <tr height=30 style='height:30pt'>
  <td height=30 class=xl6417319 style='height:30pt'></td>
  <td colspan=2 class=xl6417319>EMP No1</td>
  <td colspan=2 class=xl7017319>&nbsp;</td>
  <td colspan=2 class=xl7517319>&nbsp;</td>
  <td colspan=2 class=xl7517319>&nbsp;</td>
  <td colspan=2 class=xl7517319>&nbsp;</td>
  <td colspan=2 class=xl7517319>&nbsp;</td>
  <td colspan=2 class=xl7517319>&nbsp;</td>
  <td colspan=2 class=xl7517319>&nbsp;</td>
  <td colspan=3 class=xl7517319>&nbsp;</td>
  <td colspan=6 ></td>
  <td colspan=2 class=xl6417319>Reason</td>
  <td colspan=3>_____________________________________</td>
  <td colspan=2 class=xl6417319></td>
  <td colspan=2 class=xl6417319></td>
  <td colspan=2 class=xl6417319></td>
 </tr>
 <tr height=30 style='height:30pt'>
  <td height=30 class=xl6417319 style='height:30pt'></td>
  <td colspan=2 class=xl6417319>Emp No2</td>
  <td colspan=2 class=xl7017319>&nbsp;</td>
  <td colspan=2 class=xl7517319>&nbsp;</td>
  <td colspan=2 class=xl7517319>&nbsp;</td>
  <td colspan=2 class=xl7517319>&nbsp;</td>
  <td colspan=2 class=xl7517319>&nbsp;</td>
  <td colspan=2 class=xl7517319>&nbsp;</td>
  <td colspan=2 class=xl7517319>&nbsp;</td>
  <td colspan=3 class=xl7517319>&nbsp;</td>
  <td colspan=6 ></td>
  <td colspan=2 class=xl6417319>Approved</td>
  <td colspan=3>_____________________________________</td>
  <td colspan=2 class=xl6417319></td>
  <td colspan=2 class=xl6417319></td>
  <td colspan=2 class=xl6417319></td>
 </tr>
 <tr height=30 style='height:30pt'>
  <td height=30 class=xl6417319 style='height:30pt'></td>
  <td colspan=2 class=xl6417319>Emp No3</td>
  <td colspan=2 class=xl7017319>&nbsp;</td>
  <td colspan=2 class=xl7517319>&nbsp;</td>
  <td colspan=2 class=xl7517319>&nbsp;</td>
  <td  colspan=2 class=xl7517319>&nbsp;</td>
  <td  colspan=2 class=xl7517319>&nbsp;</td>
  <td  colspan=2 class=xl7517319>&nbsp;</td>
  <td  colspan=2 class=xl7517319>&nbsp;</td>
  <td  colspan=3 class=xl7517319>&nbsp;</td>
  <td  colspan=2 class=xl6417319></td>
  <td  colspan=2 class=xl6417319></td>
  <td  colspan=2 class=xl6417319></td>
  <td colspan=2  class=xl6417319></td>
  <td  colspan=2 class=xl6417319></td>
  <td  colspan=2 class=xl6417319></td>
  <td  colspan=2 class=xl6417319></td>
  <td  colspan=2 class=xl6417319></td>
 </tr>
 <tr height=30 style='height:30pt'>
  <td height=30 class=xl6417319 style='height:30pt'></td>
  <td  colspan=2 class=xl6417319>Date</td>
  <td  colspan=2 class=xl7017319><?php echo date("y/m-d",strtotime($plan_log_time)); ?></td>
  <td colspan=2  class=xl7517319>&nbsp;</td>
  <td  colspan=2 class=xl7517319>&nbsp;</td>
  <td  colspan=2 class=xl7517319>&nbsp;</td>
  <td  colspan=2 class=xl7517319>&nbsp;</td>
  <td  colspan=2 class=xl7517319>&nbsp;</td>
  <td  colspan=2 class=xl7517319>&nbsp;</td>
  <td  colspan=3 class=xl7517319>&nbsp;</td>
  <td  colspan=2 class=xl6417319></td>
  <td  colspan=2 class=xl6417319></td>
  <td  colspan=2 class=xl6417319></td>
  <td  colspan=2 class=xl6417319></td>
  <td  colspan=2 class=xl6417319></td>
  <td  colspan=2 class=xl6417319></td>
  <td  colspan=2 class=xl6417319></td>
  <td  colspan=2 class=xl6417319></td>
 </tr>
 <tr height=30 style='height:30pt'>
  <td height=30 class=xl6417319 style='height:30pt'></td>
  <td  colspan=2 class=xl6417319>Time</td>
  <td  colspan=2 class=xl7017319><?php echo date("H:i",strtotime($plan_log_time)); ?></td>
  <td  colspan=2 class=xl7517319>&nbsp;</td>
  <td  colspan=2 class=xl7517319>&nbsp;</td>
  <td colspan=2  class=xl7517319>&nbsp;</td>
  <td  colspan=2 class=xl7517319>&nbsp;</td>
  <td  colspan=2 class=xl7517319>&nbsp;</td>
  <td  colspan=2 class=xl7517319>&nbsp;</td>
  <td colspan=3  class=xl7517319>&nbsp;</td>
  <td  colspan=2 class=xl6417319></td>
  <td  colspan=2 class=xl6417319></td>
  <td  colspan=2 class=xl6417319></td>
  <td  colspan=2 class=xl6417319></td>
  <td  colspan=2 class=xl6417319></td>
  <td colspan=2  class=xl6417319></td>
  <td  colspan=2 class=xl6417319></td>
  <td  colspan=2 class=xl6417319></td>
 </tr>
 <tr height=30 style='height:15.75pt'>
 <td height=30 class=xl6417319 style='height:30pt'></td>
  <td  colspan=2 class=xl6417319></td>
  <!-- <td  colspan=2 style='border-top:1px solid black'></td> -->
 </tr>
</table>

</div>


<!----------------------------->
<!--END OF OUTPUT FROM EXCEL PUBLISH AS WEB PAGE WIZARD-->
<!----------------------------->
</body>

</html>

<?php
if($print==1)
{
	$idocs_2 = "'" . implode ( "', '", $docs ) . "'";
	if($print_status=="0000-00-00" || $print_status == "")
	{	
		$sql="update $bai_pro3.plandoc_stat_log set print_status=\"".date("Y-m-d")."\" where doc_no in ($idocs_2)";
		mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	}
}	
?>

<style>
.top{
	border-top : 1px solid black;
}
.left{
	border-left : 1px solid black;
}
.right{
	border-right : 1px solid black;
}
.bottom{
	border-bottom : 1px solid black;
}
.xl8917319{
	font-size:17px;
	/* font-weight:bold; */
	vertical-align : top;
}
.xl9117319,.xl10017319,.xl9817319,.xl7017319,.xl7117319,.xl8217319,.xl7317319,.xl7217319,
 .xl7917319,.xl8017319,.xl6417319,.xl8117319,.xl7417319,.xl7517319,.xl6417319,.xl9117319,.xl10117319
	{
		font-size:18px;
		/* font-weight:bold; */
		vertical-align : top;
	}
.xl9617319,.xl6817319,.xl11517319,.xl1517319
	{
		font-size:15px;
		/* font-weight:bold; */
	}
.manual_height{
	height : 30px;
}
td,th {
	/* width:auto; */
	/* font-weight:bold; */
	overflow:none;
	word-wrap: break-word;
white-space: pre-wrap;
white-space: -moz-pre-wrap;
white-space: -pre-wrap;
}
.xl74173191{
	border : 1px solid black;

}
table{
	/* text-align:left; */
	margin-left: 0px;
	margin-right: auto;
    margin-left: 0px;
}
.width1 {
	min-width:800px;
}
.xl8917319,.xl10117319,.xl6417319,.xl7017319,.xl8017319{
	font-weight: bold;

}
.xl8917319,.xl10117319,.xl9817319,.xl10017319,.xl6617319,.xl7617319,.xl9117319,.xl764118,.xl814118,.xl744118,.xl774118,.xl1144118,.xl1064118,.xl684118{
    font-size: 24px;
	/* font-weight: bold; */
}
/* table { page-break-after:auto;}
  tr    { page-break-inside:avoid; page-break-after:auto }
  td    { page-break-inside:avoid; }
  thead { display:table-header-group }
  tfoot { display:table-footer-group } */
  .lasttable{page-break-inside:avoid;}
</style>

<script>
$(document).ready(function(){
	$("table tbody th, table tbody td").wrapInner("<div></div>");
});
</script>