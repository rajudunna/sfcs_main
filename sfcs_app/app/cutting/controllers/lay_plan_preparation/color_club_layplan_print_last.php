<?php include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config.php') ?>
<?php include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/functions.php') ?>
<?php ini_set('error_reporting', E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED); ?>

<?php
$order_tid=$_GET['order_tid'];

$cat_ref=$_GET['cat_ref'];
$cat_title=$_GET['cat_title'];
$clubbing=$_GET['clubbing'];

$sql="select * from $bai_pro3.bai_orders_db_confirm where order_tid=\"$order_tid\"";
$sql_result=mysqli_query($link, $sql) or exit("Sql Error2".mysqli_error());
while($sql_row=mysqli_fetch_array($sql_result))
{
	$style=$sql_row['order_style_no'];
	$schedule=$sql_row['order_del_no'];
	$date=$sql_row['order_date'];
    
	for($i=0;$i<sizeof($sizes_array);$i++)
	{
		if($sql_row["title_size_".$sizes_array[$i].""]<>'')
		{	
			$sizes[]=$sql_row["title_size_".$sizes_array[$i].""];
			//$qty[]=$sql_row["order_s_".$sizes_array[$i].""];
		}
	}
	$flag = $sql_row['title_flag'];
	
	//$old_order_total=array_sum($qty);
}

$color_codes=array();
$fab_codes=array();
$cc_code=array();
$cat_db=array();
$sch_color=array(); // Schedule Color
$sch_tids=array(); // Schedule Color

$sql="select order_tid, order_col_des, compo_no, fab_des, gmtway, color_code, cat_ref,col_des,group_concat(DISTINCT pcutno order by pcutno) as pcut,group_concat(DISTINCT pcutno order by pcutno desc) as pcut1 from $bai_pro3.order_cat_doc_mk_mix where clubbing=$clubbing and order_del_no=\"$schedule\" and category=\"$cat_title\" group by order_tid ";
//echo $sql."<br>";
$sql_result=mysqli_query($link, $sql) or exit("Sql Error4".mysqli_error());
while($sql_row=mysqli_fetch_array($sql_result))
{
	$cutno_tmp=$sql_row['pcut'];
	$cutno_tmp1=$sql_row['pcut1'];
	$color_codes[]=$sql_row['col_des'];
	$fab_codes[]=trim($sql_row['compo_no'])."-".trim($sql_row['fab_des']);
	$gmtway=$sql_row['gmtway'];
	$cc_code[]=$sql_row['color_code'];
	$cat_db[]=$sql_row['cat_ref'];
	$sch_color[]=$sql_row['order_col_des'];
	$sch_tids[]=$sql_row['order_tid'];
}
$sql323="select max(excess_cut_qty) as excess from $bai_pro3.excess_cuts_log where schedule_no='".$schedule."' and color in ('".implode("','",$sch_color)."')";
// echo $sql323."<br>";
$sql_result232=mysqli_query($link, $sql323) or exit("Sql Error4".mysqli_error());
if(mysqli_num_rows($sql_result232)>0)
{
	while($sql_row232=mysqli_fetch_array($sql_result232))
	{	
		$exess_remove=$sql_row232['excess'];
	}
}
else
{
	$exess_remove=1;
}	
$qtys = array();
$sql = "select * from $bai_pro3.bai_orders_db_confirm where order_del_no='$schedule' and order_col_des in ('".implode("','",$sch_color)."')";
$result = mysqli_query($link, $sql) or exit("Sql Error2.1".mysqli_error());
$old_order_tot = array();
while($sql_row = mysqli_fetch_array($result))
{	
	for($c=0;$c<sizeof($sizes);$c++)
	{
		//if($sql_row['title_size_'.$sizes_array[$c]]<>'')
		//{	
			$qtys[$sql_row['order_tid']][$sizes_array[$c]] = $sql_row["order_s_".$sizes_array[$c].""];
			$old_order_tot[$sql_row['order_tid']]+=$sql_row["order_s_".$sizes_array[$c].""];
		//}		
	}
}

$cut_alloc=array();
$sql="select order_tid,sum(allocate_s01*plies) as \"cuttable_s_s01\",sum(allocate_s02*plies) as \"cuttable_s_s02\",sum(allocate_s03*plies) as \"cuttable_s_s03\",sum(allocate_s04*plies) as \"cuttable_s_s04\",sum(allocate_s05*plies) as \"cuttable_s_s05\",sum(allocate_s06*plies) as \"cuttable_s_s06\",sum(allocate_s07*plies) as \"cuttable_s_s07\",sum(allocate_s08*plies) as \"cuttable_s_s08\",sum(allocate_s09*plies) as \"cuttable_s_s09\",sum(allocate_s10*plies) as \"cuttable_s_s10\",sum(allocate_s11*plies) as \"cuttable_s_s11\",sum(allocate_s12*plies) as \"cuttable_s_s12\",sum(allocate_s13*plies) as \"cuttable_s_s13\",sum(allocate_s14*plies) as \"cuttable_s_s14\",sum(allocate_s15*plies) as \"cuttable_s_s15\",sum(allocate_s16*plies) as \"cuttable_s_s16\",sum(allocate_s17*plies) as \"cuttable_s_s17\",sum(allocate_s18*plies) as \"cuttable_s_s18\",sum(allocate_s19*plies) as \"cuttable_s_s19\",sum(allocate_s20*plies) as \"cuttable_s_s20\",sum(allocate_s21*plies) as \"cuttable_s_s21\",sum(allocate_s22*plies) as \"cuttable_s_s22\",sum(allocate_s23*plies) as \"cuttable_s_s23\",sum(allocate_s24*plies) as \"cuttable_s_s24\",sum(allocate_s25*plies) as \"cuttable_s_s25\",sum(allocate_s26*plies) as \"cuttable_s_s26\",sum(allocate_s27*plies) as \"cuttable_s_s27\",sum(allocate_s28*plies) as \"cuttable_s_s28\",sum(allocate_s29*plies) as \"cuttable_s_s29\",sum(allocate_s30*plies) as \"cuttable_s_s30\",sum(allocate_s31*plies) as \"cuttable_s_s31\",sum(allocate_s32*plies) as \"cuttable_s_s32\",sum(allocate_s33*plies) as \"cuttable_s_s33\",sum(allocate_s34*plies) as \"cuttable_s_s34\",sum(allocate_s35*plies) as \"cuttable_s_s35\",sum(allocate_s36*plies) as \"cuttable_s_s36\",sum(allocate_s37*plies) as \"cuttable_s_s37\",sum(allocate_s38*plies) as \"cuttable_s_s38\",sum(allocate_s39*plies) as \"cuttable_s_s39\",sum(allocate_s40*plies) as \"cuttable_s_s40\",sum(allocate_s41*plies) as \"cuttable_s_s41\",sum(allocate_s42*plies) as \"cuttable_s_s42\",sum(allocate_s43*plies) as \"cuttable_s_s43\",sum(allocate_s44*plies) as \"cuttable_s_s44\",sum(allocate_s45*plies) as \"cuttable_s_s45\",sum(allocate_s46*plies) as \"cuttable_s_s46\",sum(allocate_s47*plies) as \"cuttable_s_s47\",sum(allocate_s48*plies) as \"cuttable_s_s48\",sum(allocate_s49*plies) as \"cuttable_s_s49\",sum(allocate_s50*plies) as \"cuttable_s_s50\"
from $bai_pro3.allocate_stat_log where order_tid in ('".implode("','",$sch_tids)."') and cat_ref in (".implode(",",$cat_db).") group by order_tid";
$sql_result=mysqli_query($link, $sql) or exit("Sql Error3".mysqli_error());

while($sql_row=mysqli_fetch_array($sql_result))
{
    for($i=0;$i<sizeof($sizes);$i++)
	{
		$cut_alloc[$sql_row['order_tid']][$sizes_array[$i]]=$sql_row["cuttable_s_".$sizes_array[$i].""];
	}
}

//For all other parameters
	
$sql="select * from $bai_pro3.cat_stat_log where order_tid=\"$order_tid\" and tid=$cat_ref";
$sql_result=mysqli_query($link, $sql) or exit("Sql Error5".mysqli_error());
$sql_num_=mysqli_num_rows($sql_result);
while($sql_row=mysqli_fetch_array($sql_result))
{
	$cid=$sql_row['tid'];
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
$purwidths = array();
for($i=0;$i<sizeof($cat_db);$i++)
{
	$sql="select * from $bai_pro3.cat_stat_log where order_tid like \"%$schedule%\" and tid=$cat_db[$i]";
	//mysqli_query($link, $sql) or exit("Sql Error5".mysqli_error());
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error5".mysqli_error());
	$sql_num_=mysqli_num_rows($sql_result);
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		
		$purwidths[]=$sql_row['purwidth'];
		
	}
}
	
	$new_order_qty=0;
	$sums = array();
	for($i=0;$i<sizeof($cat_db);$i++)
	{
		$newyy=0;
		$sql2="select mk_ref,p_plies,cat_ref,allocate_ref from $bai_pro3.plandoc_stat_log where order_tid like \"%$schedule%\" and cat_ref=\"$cat_db[$i]\"and allocate_ref>0";
		//mysqli_query($sql2,$link) or exit("Sql Error6".mysqli_error());
		$sql_result2=mysqli_query($link,$sql2) or exit("Sql Error6".mysqli_error());
		while($sql_row2=mysqli_fetch_array($sql_result2))
		{
			
			$new_plies=$sql_row2['p_plies'];
			$mk_ref=$sql_row2['mk_ref'];
			//$sql22="select mklength from maker_stat_log where tid=$mk_ref";
			$sql22="select marker_length as mklength from $bai_pro3.marker_ref_matrix where marker_width=$purwidths[$i] and cat_ref=".$sql_row2['cat_ref']." and allocate_ref=".$sql_row2['allocate_ref'];
			//mysqli_query($sql22,$link) or exit("Sql Error".mysqli_error());
			$sql_result22=mysqli_query($link,$sql22) or exit("Sql Error7".mysqli_error());
			while($sql_row22=mysqli_fetch_array($sql_result22))
			{
				$mk_new_length=$sql_row22['mklength'];
			}
			//echo $mk_new_length."*".$new_plies."</br>";
			$newyy=$newyy+($mk_new_length*$new_plies);
		}
		$sums[$i]=$newyy;
	}
	$sql="select * from $bai_pro3.bai_orders_db_confirm where order_del_no=\"$schedule\"";
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error8".mysqli_error());
	$sql_num_confirm=mysqli_num_rows($sql_result);
	
	if($sql_num_confirm>0)
	{
        $sql2="select (order_s_s01+order_s_s02+order_s_s03+order_s_s04+order_s_s05+order_s_s06+order_s_s07+order_s_s08+order_s_s09+order_s_s10+order_s_s11+order_s_s12+order_s_s13+order_s_s14+order_s_s15+order_s_s16+order_s_s17+order_s_s18+order_s_s19+order_s_s20+order_s_s21+order_s_s22+order_s_s23+order_s_s24+order_s_s25+order_s_s26+order_s_s27+order_s_s28+order_s_s29+order_s_s30+order_s_s31+order_s_s32+order_s_s33+order_s_s34+order_s_s35+order_s_s36+order_s_s37+order_s_s38+order_s_s39+order_s_s40+order_s_s41+order_s_s42+order_s_s43+order_s_s44+order_s_s45+order_s_s46+order_s_s47+order_s_s48+order_s_s49+order_s_s50) as \"sum\" from $bai_pro3.bai_orders_db_confirm where order_del_no=\"$schedule\"";
	}
	else
	{
		$sql2="select (order_s_s01+order_s_s02+order_s_s03+order_s_s04+order_s_s05+order_s_s06+order_s_s07+order_s_s08+order_s_s09+order_s_s10+order_s_s11+order_s_s12+order_s_s13+order_s_s14+order_s_s15+order_s_s16+order_s_s17+order_s_s18+order_s_s19+order_s_s20+order_s_s21+order_s_s22+order_s_s23+order_s_s24+order_s_s25+order_s_s26+order_s_s27+order_s_s28+order_s_s29+order_s_s30+order_s_s31+order_s_s32+order_s_s33+order_s_s34+order_s_s35+order_s_s36+order_s_s37+order_s_s38+order_s_s39+order_s_s40+order_s_s41+order_s_s42+order_s_s43+order_s_s44+order_s_s45+order_s_s46+order_s_s47+order_s_s48+order_s_s49+order_s_s50) as \"sum\" from $bai_pro3.bai_orders_db where order_del_no=\"$schedule\"";
	}
	$sql_result2=mysqli_query($link,$sql2) or exit("Sql Error9".mysqli_error());
	while($sql_row2=mysqli_fetch_array($sql_result2))
	{
		$new_order_qty=$sql_row2['sum'];
	}
	
	//Sample docket remarks updation
	$sql="select * from $bai_pro3.bai_orders_db_remarks where order_tid=\"$order_tid\"";
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error());
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		$remarks_x=$sql_row['remarks'];
	}

	//Binding Consumption / YY Calculation
	$sql="select COALESCE(binding_consumption,0) as \"binding_consumption\" from $bai_pro3.cat_stat_log where order_tid=\"$order_tid\" and tid=$cat_ref";
	$sql_result2=mysqli_query($link,$sql) or exit("Sql Error10".mysqli_error());
	while($sql_row2=mysqli_fetch_array($sql_result2))
	{
		$binding_con=$sql_row2['binding_consumption'];
	}
	
	$newyy+=($new_order_qty*$binding_con);
	
	//Binding Consumption / YY Calculation
	
	$newyy2=$newyy/$new_order_qty;
	$savings_new=round((($body_yy-$newyy2)/$body_yy)*100,0);

?>


<html xmlns:o="urn:schemas-microsoft-com:office:office"
xmlns:x="urn:schemas-microsoft-com:office:excel"
xmlns="http://www.w3.org/TR/REC-html40">

<head>
<meta http-equiv=Content-Type content="text/html; charset=windows-1252">
<meta name=ProgId content=Excel.Sheet>
<meta name=Generator content="Microsoft Excel 14">
<link rel=File-List href="doc_designs_files/filelist.xml">
<style id="doc_designs_32599_Styles">
<!--table
	{mso-displayed-decimal-separator:"\.";
	mso-displayed-thousand-separator:"\,";}
.xl1532599
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
.xl6432599
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
.xl6532599
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
.xl6632599
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
.xl6732599
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
.xl6832599
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
.xl6932599
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
	mso-number-format:General;
	text-align:center;
	vertical-align:bottom;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:normal;}
.xl7032599
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
	mso-number-format:"\#\,\#\#0";
	text-align:center;
	vertical-align:bottom;
	border-top:none;
	border-right:.5pt solid windowtext;
	border-bottom:.5pt solid windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl7132599
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
	mso-number-format:"\#\,\#\#0";
	text-align:center;
	vertical-align:bottom;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl7232599
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
	mso-number-format:General;
	text-align:center;
	vertical-align:bottom;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}

.xl7332599
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
	mso-number-format:General;
	text-align:left;
	vertical-align:middle;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:normal;}
.xl7432599
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
	mso-number-format:0;
	text-align:center;
	vertical-align:middle;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}

.xl7532599
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
	background:white;
	mso-pattern:black none;
	white-space:nowrap;}
.xl7632599
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
	border-bottom:.5pt solid windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl7732599
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
.xl7832599
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
	white-space:nowrap;
    }
.xl7932599
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
.xl8032599
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
.xl8132599
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
.xl8232599
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:10.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:bottom;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}

.xl8332599
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
	vertical-align:middle;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl8432599
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

.xl8532599
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
	border-right:none;
	border-bottom:.5pt solid windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	word-wrap: break-word;
	white-space: pre-wrap;
	white-space: -moz-pre-wrap;
	white-space: -pre-wrap;}
.xl8632599
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
	word-wrap: break-word;
	white-space: pre-wrap;
	white-space: -moz-pre-wrap;
	white-space: -pre-wrap;
}

.xl8732599
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
	border-right:.5pt solid black;
	border-bottom:none;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl8832599
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
	border-bottom:.5pt solid windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}

.xl8932599
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
.xl9032599
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
	border-right:.5pt solid black;
	border-bottom:.5pt solid windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}

.xl9132599
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
	border-left:.5pt solid black;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl9232599
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
	border-top:.5pt solid windowtext;
	border-right:.5pt solid windowtext;
	border-bottom:none;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:normal;}

.xl9332599
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
	border-right:.5pt solid windowtext;
	border-bottom:.5pt solid black;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:normal;}
.xl9432599
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
	border-bottom:.5pt solid windowtext;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl9532599
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
	border-right:.5pt solid black;
	border-bottom:.5pt solid windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl9632599
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
	border-bottom:.5pt solid windowtext;
	border-left:.5pt solid black;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}

.xl9732599
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
	vertical-align:top;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl9832599
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
-->

body{
	zoom:75%;
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
@page narrow {size: 9in 11in}
@page rotated {size: landscape}

DIV {page: narrow}
TABLE {page: rotated}
#non-printable { display: none; }
#printable { display: block; }
#logo { display: block; }
body { zoom:60%;}
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
<!--[if !excel]>&nbsp;&nbsp;<![endif]-->
<!--The following information was generated by Microsoft Excel's Publish as Web
Page wizard.-->
<!--If the same item is republished from Excel, all information between the DIV
tags will be replaced.-->
<!----------------------------->
<!--START OF OUTPUT FROM EXCEL PUBLISH AS WEB PAGE WIZARD -->
<!----------------------------->

<div id="doc_designs_32599" align=center x:publishsource="Excel">

<table border=0 cellpadding=0 cellspacing=0 width=2220 style='border-collapse:
 collapse;table-layout:fixed;width:1666pt'>
 <col width=22 style='mso-width-source:userset;mso-width-alt:804;width:17pt'>
 <col width=86 style='mso-width-source:userset;mso-width-alt:3145;width:65pt'>
 <col width=64 span=33 style='width:48pt'>
 <tr height=21 style='height:15.75pt'>
  <td height=21 class=xl1532599 width=22 style='height:15.75pt;width:17pt'><a
  name="RANGE!A1:AI41"></a></td>
  <td class=xl6432599 width=86 style='width:65pt'></td>
  <td class=xl7932599 width=64 style='width:48pt'></td>
  <td class=xl7932599 width=64 style='width:48pt'></td>
  <td class=xl7932599 width=64 style='width:48pt'></td>
  <td class=xl7932599 width=64 style='width:48pt'></td>
  <td class=xl7932599 width=64 style='width:48pt'></td>
  <td class=xl7932599 width=64 style='width:48pt'></td>
  <td class=xl7932599 width=64 style='width:48pt'></td>
  <td class=xl7932599 width=64 style='width:48pt'></td>
  <td class=xl7932599 width=64 style='width:48pt'></td>
  <td class=xl7932599 width=64 style='width:48pt'></td>
  <td class=xl7932599 width=64 style='width:48pt'></td>
  <td class=xl7932599 width=64 style='width:48pt'></td>
  <td class=xl7932599 width=64 style='width:48pt'></td>
  <td class=xl7932599 width=64 style='width:48pt'></td>
  <td class=xl7932599 width=64 style='width:48pt'></td>
  <td class=xl7932599 width=64 style='width:48pt'></td>
  <td class=xl7932599 width=64 style='width:48pt'></td>
  <td class=xl7932599 width=64 style='width:48pt'></td>
  <td class=xl7932599 width=64 style='width:48pt'></td>
  <td class=xl7932599 width=64 style='width:48pt'></td>
  <td class=xl7932599 width=64 style='width:48pt'></td>
  <td class=xl7932599 width=64 style='width:48pt'></td>
  <td class=xl6432599 width=64 style='width:48pt'></td>
  <td class=xl6432599 width=64 style='width:48pt'></td>
  <td class=xl6432599 width=64 style='width:48pt'></td>
  <td class=xl6432599 width=64 style='width:48pt'></td>
  <td class=xl6432599 width=64 style='width:48pt'></td>
  <td class=xl6432599 width=64 style='width:48pt'></td>
  <td class=xl6432599 width=64 style='width:48pt'></td>
  <td class=xl6432599 width=64 style='width:48pt'></td>
  <td class=xl6432599 width=64 style='width:48pt'></td>
  <td class=xl6432599 width=64 style='width:48pt'></td>
  <td class=xl1532599 width=64 style='width:48pt'></td>
 </tr>
 <tr height=21 style='height:15.75pt'>
  <td height=21 class=xl1532599 style='height:15.75pt'></td>
  <td class=xl6432599></td>
  <td colspan=6 rowspan=3 class=xl8217319x valign="top" align="left"><img src="/sfcs_app/common/images/<?= $global_facility_code ?>_Logo.JPG" width="200" height="60"></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl7832599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl1532599></td>
 </tr>
 <tr height=21 style='height:15.75pt'>
  <td height=21 class=xl1532599 style='height:15.75pt'></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td colspan=8 class=xl8232599>Cutting Department</td>
  <td class=xl7832599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl1532599></td>
 </tr>
 <tr height=21 style='height:15.75pt'>
  <td height=21 class=xl1532599 style='height:15.75pt'></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl7832599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl1532599></td>
 </tr>
 <tr height=21 style='height:15.75pt'>
  <td height=21 class=xl1532599 style='height:15.75pt'></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl7832599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl1532599></td>
 </tr>
 <tr height=25 style='height:18.75pt'>
  <td height=25 class=xl1532599 style='height:18.75pt'></td>
  <td class=xl6432599></td>
  <td colspan=30 class=xl8332599>Cut Distribution Plan/Production Input</td>
  <td class=xl1532599></td>
 </tr>
 <tr height=40></tr>
 <tr height=21 style='height:15.75pt'>
  <td height=21 class=xl1532599 style='height:15.75pt'></td>
  <td class=xl6432599></td>
  <td class=xl7832599>Style :</td>
  <td colspan=3 class=xl8432599><?php echo $style; ?></td>
  <td class=xl7932599></td>
  <td colspan=3 class=xl7832599>Category :</td>
  <td colspan=12 class=xl8532599><?php echo $cat_title; ?></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td colspan=2 class=xl7832599>Date :</td>
  <td colspan=3 class=xl8532599><?php echo $date; ?></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl7832599></td>
  <td class=xl6432599></td>
  <td class=xl1532599></td>
 </tr>
 <tr height=21 style='height:15.75pt'>
  <td height=21 class=xl1532599 style='height:15.75pt'></td>
  <td class=xl6432599></td>
  <td class=xl7832599>Sch No :</td>
  <td colspan=3 class=xl8832599><?php echo $schedule; ?></td>
  <td class=xl7932599></td>
  <td colspan=3 class=xl7832599>Fab Description :</td>
  <td colspan=12 class=xl8632599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td colspan=2 class=xl7832599>PO :</td>
  <td colspan=3 class=xl8632599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl7832599></td>
  <td class=xl6432599></td>
  <td class=xl1532599></td>
 </tr>
 <tr height=21 style='height:15.75pt'>
  <td height=21 class=xl1532599 style='height:15.75pt'></td>
  <td class=xl6432599></td>
  <td class=xl7832599>Color :</td>
  <!-- <td colspan=3 class=xl8632599><?php echo trim($sch_color[0])." / ".trim($color_codes[0]); ?></td>
  <td class=xl7932599></td>
  <td colspan=3 class=xl7832599>Fab Code:</td> -->
  <td colspan=6 class=xl8532599><?php echo trim($sch_color[0])." / ".trim($color_codes[0]); ?></td>
  <td colspan=1 class=xl7832599>Fab Code:</td>
  <td colspan=12 class=xl8532599><?php echo $fab_codes[0]; ?></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td colspan=2 class=xl7832599>Assortment :</td>
  <td colspan=3 class=xl8632599>&nbsp;</td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl7832599></td>
  <td class=xl6432599></td>
  <td class=xl1532599></td>
 </tr>
 
 
 <?php
 
 for($i=1;$i<sizeof($color_codes);$i++)
 {
 	echo "<tr height=21 style='height:15.75pt'>
  <td height=21 class=xl1532599 style='height:15.75pt'></td>
  <td class=xl6432599></td>
  <td class=xl7832599></td>";
  echo "<td colspan=6 class=xl8632599>".trim($sch_color[$i])." / ".trim($color_codes[$i])."</td>
  <td class=xl7832599></td>";
  echo "<td colspan=12 class=xl8632599>".$fab_codes[$i]."</td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl7832599></td>
  <td class=xl7832599></td>
  <td class=xl7932599></td>
  <td class=xl7932599></td>
  <td class=xl7932599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl7832599></td>
  <td class=xl6432599></td>
  <td class=xl1532599></td>
 </tr>";
 }
 
 
 ?>
 
 <!-- <tr height=21 style='height:15.75pt'>
  <td height=21 class=xl1532599 style='height:15.75pt'></td>
  <td class=xl6432599></td>
  <td class=xl7832599></td>
  <td colspan=3 class=xl8632599>OL 1084-wte base,Lv spot</td>
  <td class=xl7932599></td>
  <td class=xl7832599></td>
  <td class=xl7832599></td>
  <td class=xl7832599></td>
  <td colspan=12 class=xl8632599>M2402B2BF2 002</td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl7832599></td>
  <td class=xl7832599></td>
  <td class=xl7932599></td>
  <td class=xl7932599></td>
  <td class=xl7932599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl7832599></td>
  <td class=xl6432599></td>
  <td class=xl1532599></td>
 </tr> -->
 <tr height=21 style='height:15.75pt'>
  <td height=21 class=xl1532599 style='height:15.75pt'></td>
  <td class=xl6432599></td>
  <td class=xl7832599></td>
  <td class=xl7932599></td>
  <td class=xl7932599></td>
  <td class=xl7932599></td>
  <td class=xl7932599></td>
  <td class=xl7832599></td>
  <td class=xl7832599></td>
  <td class=xl7832599></td>
  <td class=xl7932599></td>
  <td class=xl7932599></td>
  <td class=xl7932599></td>
  <td class=xl7932599></td>
  <td class=xl7932599></td>
  <td class=xl7932599></td>
  <td class=xl7932599></td>
  <td class=xl7932599></td>
  <td class=xl7932599></td>
  <td class=xl7932599></td>
  <td class=xl7932599></td>
  <td class=xl7932599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl7832599></td>
  <td class=xl7832599></td>
  <td class=xl7932599></td>
  <td class=xl7932599></td>
  <td class=xl7932599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl7832599></td>
  <td class=xl6432599></td>
  <td class=xl1532599></td>
 </tr>
 <tr height=21 style='height:15.75pt'>
  <td height=21 class=xl1532599 style='height:15.75pt'></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl7932599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl7832599></td>
  <td class=xl6432599></td>
  <td class=xl1532599></td>
 </tr>
 <tr height=21 style='height:15.75pt'>
  <td height=21 class=xl1532599 style='height:15.75pt'></td>
  <td class=xl6932599 width=86 style='width:65pt'></td>
  <td colspan=15 rowspan=6 class=xl9732599>
  <?php
  
  $style_css="style='font-size:22px; border:.5pt solid black; padding-left: 10px; padding-right:10px; border-collapse: collapse;'";
  echo "<table style='font-size:22px; border:.5pt solid black; border-collapse: collapse;' align=left>";
  
  echo "<tr>";
  
  echo "<th $style_css>Color/Sizes</th>";
  $count_num=0;
   for($i=0;$i<sizeof($sizes);$i++)
   {
		//if($qty[$i]>0)
		//{
			echo "<th $style_css>".$sizes[$i]."</th>";
			$count_num++;
		//}
   }
  echo "<th $style_css>Total</th>";
  echo "</tr>";
  $sizes_count=0; //To count number of sizes
  //echo sizeof($color_codes)."<br>";
  for($j=0;$j<sizeof($sch_tids);$j++)
  {
	  	echo "<tr>";		
		echo "<th $style_css>".$sch_color[$j]."</th>";
		for($i=0;$i<sizeof($sizes);$i++)
	  	{
			echo "<th $style_css>".$qtys[$sch_tids[$j]][$sizes_array[$i]]."</th>";
			$sizes_count++;
			//}
		}
		echo "<th $style_css>".($old_order_tot[$sch_tids[$j]])."</th>";
		echo "</tr>";
  }
  
  $total_sch_count=sizeof($color_codes); //Total number of schedules
  $sizes_count=$sizes_count/$total_sch_count;  
 
  echo "</table>";
  
  ?>
  
  
  </td>
  <td colspan=3 class=xl6532599><?php echo $cat_title; ?></td>
  
  <td colspan=3 class=xl7732599 style='border-right:.5pt solid black'>Savings %</td>
  <td colspan=3 class=xl6832599><?php echo $savings_new; ?>%</td>
  
  <td colspan=3 class=xl7732599 style='border-right:.5pt solid black'>One Gmt
  One Way</td>
  <td colspan=3 class=xl8032599><?php echo $gmtway; ?></td>
  <td class=xl8132599></td>
  <td class=xl1532599></td>
 </tr>
 <tr height=21 style='height:15.75pt'>
  <td height=21 class=xl1532599 style='height:15.75pt'></td>
  <td colspan=16 class=xl7732599 style='border-right:.5pt solid black'>Consumption</td>
  <td colspan=3 class=xl6632599><?php echo $body_yy; ?></td>
  
  <td colspan=3 class=xl7732599 style='border-right:.5pt solid black'>CAD
  Consumption</td>
  
  <td colspan=3 class=xl6632599><?php echo round($newyy2,4); ?></td>
 
  <td colspan=3 class=xl7732599 style='border-right:.5pt solid black'>Strip
  Matching</td>
  <td colspan=3 class=xl6632599><?php echo $strip_match; ?></td>
  <td class=xl7932599></td>
  <td class=xl1532599></td>
 </tr>
 <tr height=21 style='height:15.75pt'>
  <td height=21 class=xl1532599 style='height:15.75pt'></td>
 
  <td colspan=16.5 class=xl7732599 style='border-right:.5pt solid black'>Material
  Allowed</td>
  <td colspan=3 class=xl7032599 >
  <?php 
  		$material = array();
  		for($i=0;$i<sizeof($old_order_tot);$i++)
  		$material[$i] = round(($old_order_tot[$i]*$body_yy),0);
		echo implode("/",$material);
	?>
			
</td>
  <td colspan=3 class=xl7732599 style='border-right:.5pt solid black'>Used
  <?php $fab_uom ?></td>
  <td colspan=3 class=xl7032599>
  <?php 
  $sum_newyy = array();
  	for($i=0;$i<sizeof($sums);$i++)
  		$sum_newyy[$i]= round($sums[$i],0); 
	echo implode("/",$sum_newyy);
	?>
		
</td>
<td colspan=3 class=xl7732599 style='border-right:.5pt solid black'>Gusset
  Sep</td>
  <td colspan=3 class=xl7032599><?php echo $gusset_sep; ?></td>
  <td class=xl7132599></td>
  <td class=xl1532599></td>
 </tr>
 <tr height=21 style='height:15.75pt'>
  <td height=21 class=xl1532599 style='height:15.75pt'></td>
  <td class=xl6932599 width=86 style='width:65pt'></td>
  <td class=xl7732599></td>
  <td class=xl7732599></td>
  <td class=xl7732599></td>
  <td class=xl7132599></td>
  <td class=xl7932599></td>
  <td class=xl7932599></td>
  <td class=xl7732599></td>
  <td class=xl7732599></td>
  <td class=xl7732599></td>
  <td colspan=3 class=xl7732599 style='border-right:.5pt solid black'>Pattern
  Version</td>
  <td colspan=3 class=xl7032599><?php echo $patt_ver; ?></td>
  <td class=xl7132599></td>
  <td class=xl1532599></td>
 </tr>
 <tr height=21 style='height:15.75pt'>
  <td height=21 class=xl1532599 style='height:15.75pt'></td>
	  <td colspan=12 class=xl7732599></td>
  
  
  <?php
//   $bind_con = 0.12;

  if(strlen($remarks_x)>0)
  {
  	echo "<td colspan=5 style='font-size:20px;border:1px solid black'><strong>Remarks : $remarks_x</strong></td>";
  }
  else
  {
  	echo "<td colspan=5></td>";
  }
    if(strlen($binding_con)>0)
    {
        echo "<td colspan=4 style='font-size:20px;border:1px solid black'><strong>Binding Consumption : $binding_con</strong></td>";
    }else{
        echo "<td colspan=5></td>";
    }
  
  ?>
  <!--<td class=xl7732599></td>
  <td class=xl7732599></td>
  <td class=xl7732599></td>
  <td class=xl7132599></td>
  <td class=xl6432599></td>
  <td class=xl7932599></td>
  <td class=xl7132599></td>
  <td class=xl7132599></td>
  <td class=xl1532599></td>-->
 </tr>
 <tr height=21 style='height:15.75pt'>
  <td height=21 class=xl1532599 style='height:15.75pt'></td>
  <td class=xl7232599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl7932599></td>
  <td class=xl7932599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl7932599></td>
  <td class=xl1532599></td>
  <td class=xl1532599></td>
  <td class=xl1532599></td>
  <td class=xl1532599></td>
  <td class=xl7932599></td>
  <td class=xl1532599></td>
 </tr>
 <tr height=21 style='height:15.75pt'>
  <td height=21 class=xl1532599 style='height:15.75pt'></td>
  <td class=xl6932599 width=86 style='width:65pt'></td>
  <td class=xl1532599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl7932599></td>
  <td class=xl7932599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl7932599></td>
  <td class=xl7932599></td>
  <td class=xl7932599></td>
  <td class=xl8132599></td>
  <td class=xl8132599></td>
  <td class=xl7932599></td>
  <td class=xl7932599></td>
  <td class=xl7932599></td>
  <td class=xl7932599></td>
  <td class=xl7932599></td>
  <td class=xl7932599></td>
  <td class=xl6432599></td>
  <td class=xl1532599></td>
 </tr>
 <tr height=21 style='height:15.75pt'>
  <td height=21 class=xl1532599 style='height:15.75pt'></td>
  <td class=xl6432599></td>
  <td class=xl7332599 width=64 style='width:48pt'></td>
  <td class=xl7432599></td>
  <td class=xl7432599></td>
  <td class=xl7432599></td>
  <td class=xl7432599></td>
  <td class=xl7432599></td>
  <td class=xl7432599></td>
  <td class=xl7432599></td>
  <td class=xl7432599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl7932599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl8132599></td>
  <td class=xl8132599></td>
  <td class=xl8132599></td>
  <td class=xl8132599></td>
  <td class=xl8132599></td>
  <td class=xl7932599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl7932599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl7832599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl1532599></td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl1532599 style='height:15.0pt'></td>
  <td colspan=33 rowspan=17 class=xl9732599>
  
  <?php
  
	$style_css="style='font-size:22px; border:.5pt solid black; padding-top: 3px; padding-bottom:3px; padding-left: 15px; padding-right:15px; border-collapse: collapse;'";
	echo "<table style='font-size:22px; border-collapse: collapse; margin-left:85px; ' align=left>";

	echo "<tr>";  
	echo "<th $style_css rowspan=2>Cut No</th>";
	echo "<th $style_css rowspan=2>LID</th>";
	echo "<th $style_css rowspan=2>Job#</th>";
	echo "<th $style_css rowspan=2>Color</th>";
	echo "<th $style_css colspan=$sizes_count>Ratio</th>";
	echo "<th $style_css rowspan=2>Plies</th>";
	echo "<th $style_css colspan=3>Verification</th>";
	echo "<th $style_css colspan=$sizes_count>Input</th>";
	echo "<th $style_css rowspan=2>Total</th>";  
	echo "</tr>";   
	echo "<tr>"; 
	for($i=0;$i<sizeof($sizes);$i++)
	{
		echo "<th $style_css>".$sizes[$i]."</th>";
	}
	echo "<th $style_css>Mod#</th>";
	echo "<th $style_css>Date</th>";
	echo "<th $style_css>Sign</th>";
	for($i=0;$i<sizeof($sizes);$i++)
	{
		echo "<th $style_css>".$sizes[$i]."</th>";
	}
	echo "</tr>";
   // Pilot 
 	$a__tot=array();
	$a_=array();
	$ex_=array();
	$a_tot[0]=0;
	$a_tot[1]=0;
	$a_tot[2]=0;
	$a_tot[3]=0;
	$a_tot[4]=0;
	$a_tot[5]=0;
	$a_tot[6]=0;
	$a_tot[7]=0;
	$a_tot[8]=0;
	$a_tot[9]=0;
	$a_tot[10]=0;
	$a_tot[11]=0;
	$a_tot[12]=0;
	$a_tot[13]=0;
	$a_tot[14]=0;
	$a_tot[15]=0;
	$a_tot[16]=0;
	$a_tot[17]=0;
	$a_tot[18]=0;
	$a_tot[19]=0;
	$a_tot[20]=0;
	$a_tot[21]=0;
	$a_tot[22]=0;
	$a_tot[23]=0;
	$a_tot[24]=0;
	$a_tot[25]=0;
	$a_tot[26]=0;
	$a_tot[27]=0;
	$a_tot[28]=0;
	$a_tot[29]=0;
	$a_tot[30]=0;
	$a_tot[31]=0;
	$a_tot[32]=0;
	$a_tot[33]=0;
	$a_tot[34]=0;
	$a_tot[35]=0;
	$a_tot[36]=0;
	$a_tot[37]=0;
	$a_tot[38]=0;
	$a_tot[39]=0;
	$a_tot[40]=0;
	$a_tot[41]=0;
	$a_tot[42]=0;
	$a_tot[43]=0;
	$a_tot[44]=0;
	$a_tot[45]=0;
	$a_tot[46]=0;
	$a_tot[47]=0;
	$a_tot[48]=0;
	$a_tot[49]=0;
	$plies_tot=0;
	$sql="select * from $bai_pro3.plandoc_stat_log where order_tid=\"$order_tid\" and cat_ref=$cat_ref and remarks=\"Pilot\" order by acutno";
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error11".mysqli_error());
	$sql_num_=mysqli_num_rows($sql_result);
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		$a_[0]=$sql_row['a_s01'];
		$a_[1]=$sql_row['a_s02'];
		$a_[2]=$sql_row['a_s03'];
		$a_[3]=$sql_row['a_s04'];
		$a_[4]=$sql_row['a_s05'];
		$a_[5]=$sql_row['a_s06'];
		$a_[6]=$sql_row['a_s07'];
		$a_[7]=$sql_row['a_s08'];
		$a_[8]=$sql_row['a_s09'];
		$a_[9]=$sql_row['a_s10'];
		$a_[10]=$sql_row['a_s11'];
		$a_[11]=$sql_row['a_s12'];
		$a_[12]=$sql_row['a_s13'];
		$a_[13]=$sql_row['a_s14'];
		$a_[14]=$sql_row['a_s15'];
		$a_[15]=$sql_row['a_s16'];
		$a_[16]=$sql_row['a_s17'];
		$a_[17]=$sql_row['a_s18'];
		$a_[18]=$sql_row['a_s19'];
		$a_[19]=$sql_row['a_s20'];
		$a_[20]=$sql_row['a_s21'];
		$a_[21]=$sql_row['a_s22'];
		$a_[22]=$sql_row['a_s23'];
		$a_[23]=$sql_row['a_s24'];
		$a_[24]=$sql_row['a_s25'];
		$a_[25]=$sql_row['a_s26'];
		$a_[26]=$sql_row['a_s27'];
		$a_[27]=$sql_row['a_s28'];
		$a_[28]=$sql_row['a_s29'];
		$a_[29]=$sql_row['a_s30'];
		$a_[30]=$sql_row['a_s31'];
		$a_[31]=$sql_row['a_s32'];
		$a_[32]=$sql_row['a_s33'];
		$a_[33]=$sql_row['a_s34'];
		$a_[34]=$sql_row['a_s35'];
		$a_[35]=$sql_row['a_s36'];
		$a_[36]=$sql_row['a_s37'];
		$a_[37]=$sql_row['a_s38'];
		$a_[38]=$sql_row['a_s39'];
		$a_[39]=$sql_row['a_s40'];
		$a_[40]=$sql_row['a_s41'];
		$a_[41]=$sql_row['a_s42'];
		$a_[42]=$sql_row['a_s43'];
		$a_[43]=$sql_row['a_s44'];
		$a_[44]=$sql_row['a_s45'];
		$a_[45]=$sql_row['a_s46'];
		$a_[46]=$sql_row['a_s47'];
		$a_[47]=$sql_row['a_s48'];
		$a_[48]=$sql_row['a_s49'];
		$a_[49]=$sql_row['a_s50'];


		$cutnos=$sql_row['acutno'];
		$plies=$sql_row['p_plies'];
		$docketno=$sql_row['doc_no'];
		$docketdate=$sql_row['date'];
		$mk_ref=$sql_row['mk_ref'];

		$a_tot[0]=$a_tot[0]+($a_[0]*$plies);
		$a_tot[1]=$a_tot[1]+($a_[1]*$plies);
		$a_tot[2]=$a_tot[2]+($a_[2]*$plies);
		$a_tot[3]=$a_tot[3]+($a_[3]*$plies);
		$a_tot[4]=$a_tot[4]+($a_[4]*$plies);
		$a_tot[5]=$a_tot[5]+($a_[5]*$plies);
		$a_tot[6]=$a_tot[6]+($a_[6]*$plies);
		$a_tot[7]=$a_tot[7]+($a_[7]*$plies);
		$a_tot[8]=$a_tot[8]+($a_[8]*$plies);
		$a_tot[9]=$a_tot[9]+($a_[9]*$plies);
		$a_tot[10]=$a_tot[10]+($a_[10]*$plies);
		$a_tot[11]=$a_tot[11]+($a_[11]*$plies);
		$a_tot[12]=$a_tot[12]+($a_[12]*$plies);
		$a_tot[13]=$a_tot[13]+($a_[13]*$plies);
		$a_tot[14]=$a_tot[14]+($a_[14]*$plies);
		$a_tot[15]=$a_tot[15]+($a_[15]*$plies);
		$a_tot[16]=$a_tot[16]+($a_[16]*$plies);
		$a_tot[17]=$a_tot[17]+($a_[17]*$plies);
		$a_tot[18]=$a_tot[18]+($a_[18]*$plies);
		$a_tot[19]=$a_tot[19]+($a_[19]*$plies);
		$a_tot[20]=$a_tot[20]+($a_[20]*$plies);
		$a_tot[21]=$a_tot[21]+($a_[21]*$plies);
		$a_tot[22]=$a_tot[22]+($a_[22]*$plies);
		$a_tot[23]=$a_tot[23]+($a_[23]*$plies);
		$a_tot[24]=$a_tot[24]+($a_[24]*$plies);
		$a_tot[25]=$a_tot[25]+($a_[25]*$plies);
		$a_tot[26]=$a_tot[26]+($a_[26]*$plies);
		$a_tot[27]=$a_tot[27]+($a_[27]*$plies);
		$a_tot[28]=$a_tot[28]+($a_[28]*$plies);
		$a_tot[29]=$a_tot[29]+($a_[29]*$plies);
		$a_tot[30]=$a_tot[30]+($a_[30]*$plies);
		$a_tot[31]=$a_tot[31]+($a_[31]*$plies);
		$a_tot[32]=$a_tot[32]+($a_[32]*$plies);
		$a_tot[33]=$a_tot[33]+($a_[33]*$plies);
		$a_tot[34]=$a_tot[34]+($a_[34]*$plies);
		$a_tot[35]=$a_tot[35]+($a_[35]*$plies);
		$a_tot[36]=$a_tot[36]+($a_[36]*$plies);
		$a_tot[37]=$a_tot[37]+($a_[37]*$plies);
		$a_tot[38]=$a_tot[38]+($a_[38]*$plies);
		$a_tot[39]=$a_tot[39]+($a_[39]*$plies);
		$a_tot[40]=$a_tot[40]+($a_[40]*$plies);
		$a_tot[41]=$a_tot[41]+($a_[41]*$plies);
		$a_tot[42]=$a_tot[42]+($a_[42]*$plies);
		$a_tot[43]=$a_tot[43]+($a_[43]*$plies);
		$a_tot[44]=$a_tot[44]+($a_[44]*$plies);
		$a_tot[45]=$a_tot[45]+($a_[45]*$plies);
		$a_tot[46]=$a_tot[46]+($a_[46]*$plies);
		$a_tot[47]=$a_tot[47]+($a_[47]*$plies);
		$a_tot[48]=$a_tot[48]+($a_[48]*$plies);
		$a_tot[49]=$a_tot[49]+($a_[49]*$plies);
		$plies_tot=$plies_tot+$plies;
		for($l=0;$l<sizeof($color_codes);$l++)
		{
			$sql_1="select * from $bai_pro3.plandoc_stat_log where cat_ref=\"".$cat_db[$l]."\" and remarks=\"Pilot\" and acutno=\"".$cutnos."\"";
			$sql_result_1=mysqli_query($sql_1,$link) or exit("Sql Error14".mysqli_error());
			$sql_num_1=mysqli_num_rows($sql_result_1);
			while($sql_row_1=mysqli_fetch_array($sql_result_1))
			{
				$plies_ref=$sql_row_1['p_plies'];
			}
			echo "<tr>
			<td $style_css>Pilot</td>
			<td $style_css>".$cat_db[$l]."</td>";
			echo "<td $style_css>Pilot</td>";
			echo "<td $style_css>".$color_codes[$l]."</td>";
			for($i=0;$i<sizeof($sizes);$i++)
			{
				echo "<td $style_css>".$a_[$i]."</td>";
			}
			echo "<td $style_css>".$plies_ref."</td>";
			echo "<td $style_css></td>";
			echo "<td $style_css></td>";
			echo "<td $style_css></td>";
			for($i=0;$i<sizeof($sizes);$i++)
			{
				echo "<td $style_css>".($a_[$i]*$plies_ref)."</td>";
			}
			echo "<td $style_css>".array_sum($a_)*$plies_ref."</td>";
			echo "</tr>";
		}
	}
	$check_status=1;
	
	$ex_tot=array();
	$ex=array();
	$a_=array();
	//var_dump($sch_tids)."<br>";
	//echo sizeof($sch_tids)."<br>";
	for($ii=0;$ii<sizeof($sch_tids);$ii++)
	{	
		//echo $sch_tids[$ii]."<br>";
		for($s=0;$s<sizeof($sizes);$s++) 
		{ 
			//echo $size[$s]."<br>";
			$ex_tot[$sch_tids[$ii]]=$ex_tot[$sch_tids[$ii]]+($cut_alloc[$sch_tids[$ii]][$sizes_array[$s]]-$qtys[$sch_tids[$ii]][$sizes_array[$s]]);
			$ex[$sch_tids[$ii]][$sizes_array[$s]]=($cut_alloc[$sch_tids[$ii]][$sizes_array[$s]]-$qtys[$sch_tids[$ii]][$sizes_array[$s]]);
		}
	}
	// Excess	
	if($check_status==1)
	{
		$check_status=0;
		for($l=0;$l<sizeof($sch_tids);$l++)
		{					
			echo "<tr>
			<td $style_css>"."0"."</td>
			<td $style_css>".$cat_db[$l]."</td>";
			echo "<td $style_css>".chr($cc_code[$l])."000"."</td>";
			echo "<td $style_css>".$sch_color[$l]."</td>";
	   		for($i=0;$i<sizeof($sizes);$i++)
			{
				echo "<td $style_css></td>";
			}	
			echo "<td $style_css></td>";
			echo "<td $style_css></td>";
			echo "<td $style_css></td>";
			echo "<td $style_css></td>";
	      	for($i=0;$i<sizeof($sizes);$i++)
			{
	  			echo "<td $style_css>".$ex[$sch_tids[$l]][$sizes_array[$i]]."</td>";
			}	  	
			echo "<td $style_css>".$ex_tot[$sch_tids[$ii]]."</td>";
			echo "</tr>";
		}	
	}
	$cutno=array();
	// $cutno=explode(",",$cutno_tmp);
	//var_dump($cutno)."<br>";
	if($exess_remove==1)
	{
		$cutno=explode(",",$cutno_tmp);
	}	
	else
	{
		$cutno=explode(",",$cutno_tmp1);
	}
	// var_dump($cutno)."<br>";
	for($ii=0;$ii<sizeof($cutno);$ii++)
	{	
		for($iii=0;$iii<sizeof($sch_tids);$iii++)
		{
			$sql="select * from $bai_pro3.plandoc_stat_log where order_tid='".$sch_tids[$iii]."' and cat_ref='".$cat_db[$iii]."' and remarks=\"Normal\" and acutno='".$cutno[$ii]."'";
			$sql_result=mysqli_query($link, $sql) or exit("Sql Error14".mysqli_error());
			while($sql_row=mysqli_fetch_array($sql_result))
			{
				$pliess[$sch_tids[$iii]][$cutno[$ii]]=$sql_row['p_plies'];
				$cutnos=$sql_row['acutno']; 
				$plies=$sql_row['p_plies']; 
				$docketno=$sql_row['doc_no']; 
				$docketdate=$sql_row['date']; 
				$mk_ref=$sql_row['mk_ref']; 
				for($kk=0;$kk<sizeof($sizes);$kk++)
				{							
					$a_[$sch_tids[$iii]][$cutno[$ii]][$sizes_array[$kk]]=$sql_row["a_".$sizes_array[$kk].""];	
					if($ex[$sch_tids[$iii]][$sizes_array[$kk]]>0)
					{
						if(($a_[$sch_tids[$iii]][$cutno[$ii]][$sizes_array[$kk]]*$plies)<$ex[$sch_tids[$iii]][$sizes_array[$kk]])
						{
							$ratio[$sch_tids[$iii]][$cutno[$ii]][$sizes_array[$kk]]=$a_[$sch_tids[$iii]][$cutno[$ii]][$sizes_array[$kk]];
							$qty[$sch_tids[$iii]][$cutno[$ii]][$sizes_array[$kk]]=0;
							$ex[$sch_tids[$iii]][$sizes_array[$kk]]=$ex[$sch_tids[$iii]][$sizes_array[$kk]]-($a_[$sch_tids[$iii]][$cutno[$ii]][$sizes_array[$kk]]*$plies);
						}
						else
						{
							$ratio[$sch_tids[$iii]][$cutno[$ii]][$sizes_array[$kk]]=$a_[$sch_tids[$iii]][$cutno[$ii]][$sizes_array[$kk]];
							$qty[$sch_tids[$iii]][$cutno[$ii]][$sizes_array[$kk]]=($a_[$sch_tids[$iii]][$cutno[$ii]][$sizes_array[$kk]]*$plies)-$ex[$sch_tids[$iii]][$sizes_array[$kk]];
							$ex[$sch_tids[$iii]][$sizes_array[$kk]]=0;
						}
					}
					else
					{
						$ratio[$sch_tids[$iii]][$cutno[$ii]][$sizes_array[$kk]]=$a_[$sch_tids[$iii]][$cutno[$ii]][$sizes_array[$kk]];
						$qty[$sch_tids[$iii]][$cutno[$ii]][$sizes_array[$kk]]=$a_[$sch_tids[$iii]][$cutno[$ii]][$sizes_array[$kk]]*$plies;
					}
				}
			}
		}	
	}
	
	// Normal
	unset($cutno);
	$cutno=explode(",",$cutno_tmp);
	for($ll=0;$ll<sizeof($cutno);$ll++)
	{			
		for($l=0;$l<sizeof($sch_tids);$l++)
		{
			echo "<tr>
			<td $style_css>".$cutno[$ll]."</td>
		    <td $style_css>".$cat_db[$l]."</td>";
			echo "<td $style_css>".chr($cc_code[$l]).leading_zeros($cutno[$ll], 3)."</td>";
			echo "<td $style_css>".$sch_color[$l]."</td>";
		   	for($i=0;$i<sizeof($sizes);$i++)
			{	
				echo "<td $style_css>".$ratio[$sch_tids[$l]][$cutno[$ll]][$sizes_array[$i]]."</td>";
			}		
		    echo "<td $style_css>".$pliess[$sch_tids[$l]][$cutno[$ll]]."</td>";
		    echo "<td $style_css></td>";
		    echo "<td $style_css></td>";
		    echo "<td $style_css></td>";		   
		    $temp_sum_ref=0;	
		    for($i=0;$i<sizeof($sizes);$i++)
		    {
				echo "<td $style_css>".$qty[$sch_tids[$l]][$cutno[$ll]][$sizes_array[$i]]."</td>";
				$temp_sum_ref=$temp_sum_ref+$qty[$sch_tids[$l]][$cutno[$ll]][$sizes_array[$i]];
			}
			   
			  //echo "<td $style_css>".$temp_sum."</td>";
			  echo "<td $style_css>".$temp_sum_ref."</td>";
			echo "</tr>";
		}
	}
	echo "<tr><td ></td><td></td>";
	echo "<td></td>";
	echo "<td></td>";
	for($i=0;$i<sizeof($sizes);$i++)
	{
		echo "<td ></td>";
	}    
	echo "<td ></td>";
    echo "<td ></td>";
	echo "<td ></td>";
	echo "<td ></td>";
	$sqls="select sum(allocate_s01*plies) as \"cuttable_s_s01\",sum(allocate_s02*plies) as \"cuttable_s_s02\",sum(allocate_s03*plies) as \"cuttable_s_s03\",sum(allocate_s04*plies) as \"cuttable_s_s04\",sum(allocate_s05*plies) as \"cuttable_s_s05\",sum(allocate_s06*plies) as \"cuttable_s_s06\",sum(allocate_s07*plies) as \"cuttable_s_s07\",sum(allocate_s08*plies) as \"cuttable_s_s08\",sum(allocate_s09*plies) as \"cuttable_s_s09\",sum(allocate_s10*plies) as \"cuttable_s_s10\",sum(allocate_s11*plies) as \"cuttable_s_s11\",sum(allocate_s12*plies) as \"cuttable_s_s12\",sum(allocate_s13*plies) as \"cuttable_s_s13\",sum(allocate_s14*plies) as \"cuttable_s_s14\",sum(allocate_s15*plies) as \"cuttable_s_s15\",sum(allocate_s16*plies) as \"cuttable_s_s16\",sum(allocate_s17*plies) as \"cuttable_s_s17\",sum(allocate_s18*plies) as \"cuttable_s_s18\",sum(allocate_s19*plies) as \"cuttable_s_s19\",sum(allocate_s20*plies) as \"cuttable_s_s20\",sum(allocate_s21*plies) as \"cuttable_s_s21\",sum(allocate_s22*plies) as \"cuttable_s_s22\",sum(allocate_s23*plies) as \"cuttable_s_s23\",sum(allocate_s24*plies) as \"cuttable_s_s24\",sum(allocate_s25*plies) as \"cuttable_s_s25\",sum(allocate_s26*plies) as \"cuttable_s_s26\",sum(allocate_s27*plies) as \"cuttable_s_s27\",sum(allocate_s28*plies) as \"cuttable_s_s28\",sum(allocate_s29*plies) as \"cuttable_s_s29\",sum(allocate_s30*plies) as \"cuttable_s_s30\",sum(allocate_s31*plies) as \"cuttable_s_s31\",sum(allocate_s32*plies) as \"cuttable_s_s32\",sum(allocate_s33*plies) as \"cuttable_s_s33\",sum(allocate_s34*plies) as \"cuttable_s_s34\",sum(allocate_s35*plies) as \"cuttable_s_s35\",sum(allocate_s36*plies) as \"cuttable_s_s36\",sum(allocate_s37*plies) as \"cuttable_s_s37\",sum(allocate_s38*plies) as \"cuttable_s_s38\",sum(allocate_s39*plies) as \"cuttable_s_s39\",sum(allocate_s40*plies) as \"cuttable_s_s40\",sum(allocate_s41*plies) as \"cuttable_s_s41\",sum(allocate_s42*plies) as \"cuttable_s_s42\",sum(allocate_s43*plies) as \"cuttable_s_s43\",sum(allocate_s44*plies) as \"cuttable_s_s44\",sum(allocate_s45*plies) as \"cuttable_s_s45\",sum(allocate_s46*plies) as \"cuttable_s_s46\",sum(allocate_s47*plies) as \"cuttable_s_s47\",sum(allocate_s48*plies) as \"cuttable_s_s48\",sum(allocate_s49*plies) as \"cuttable_s_s49\",sum(allocate_s50*plies) as \"cuttable_s_s50\" from $bai_pro3.allocate_stat_log where order_tid like \"%$schedule%\" and cat_ref in (".implode(",",$cat_db).")";
	$sql_results1=mysqli_query($link,$sqls) or exit("Sql Error3".mysqli_error());
	while($sql_row=mysqli_fetch_array($sql_results1))
	{
		for($kk=0;$kk<sizeof($sizes);$kk++)
		{
			$cs_[]=$sql_row["cuttable_s_".$sizes_array[$kk].""];
		}
	}
   	for($i=0;$i<sizeof($sizes);$i++)
	{
	  	echo "<td $style_css>".($cs_[$i])."</td>";
	}	   
	echo "<td $style_css>".(array_sum($cs_))."</td>";
	echo "</tr>";
	//% Calculation
	echo "<tr><td></td><td></td>";
	echo "<td></td>";
	echo "<td></td>";
   	for($i=0;$i<sizeof($sizes);$i++)
	{
		echo "<td ></td>";
	}
	echo "<td ></td>";
	echo "<td ></td>";
	echo "<td ></td>";
	echo "<td ></td>";
    $sqls12="select sum(order_s_s01) as  \"order_s_s01\",sum(order_s_s02) as  \"order_s_s02\",sum(order_s_s03) as  \"order_s_s03\",sum(order_s_s04) as  \"order_s_s04\",sum(order_s_s05) as  \"order_s_s05\",sum(order_s_s06) as  \"order_s_s06\",sum(order_s_s07) as  \"order_s_s07\",sum(order_s_s08) as  \"order_s_s08\",sum(order_s_s09) as  \"order_s_s09\",sum(order_s_s10) as  \"order_s_s10\",sum(order_s_s11) as  \"order_s_s11\",sum(order_s_s12) as  \"order_s_s12\",sum(order_s_s13) as  \"order_s_s13\",sum(order_s_s14) as  \"order_s_s14\",sum(order_s_s15) as  \"order_s_s15\",sum(order_s_s16) as  \"order_s_s16\",sum(order_s_s17) as  \"order_s_s17\",sum(order_s_s18) as  \"order_s_s18\",sum(order_s_s19) as  \"order_s_s19\",sum(order_s_s20) as  \"order_s_s20\",sum(order_s_s21) as  \"order_s_s21\",sum(order_s_s22) as  \"order_s_s22\",sum(order_s_s23) as  \"order_s_s23\",sum(order_s_s24) as  \"order_s_s24\",sum(order_s_s25) as  \"order_s_s25\",sum(order_s_s26) as  \"order_s_s26\",sum(order_s_s27) as  \"order_s_s27\",sum(order_s_s28) as  \"order_s_s28\",sum(order_s_s29) as  \"order_s_s29\",sum(order_s_s30) as  \"order_s_s30\",sum(order_s_s31) as  \"order_s_s31\",sum(order_s_s32) as  \"order_s_s32\",sum(order_s_s33) as  \"order_s_s33\",sum(order_s_s34) as  \"order_s_s34\",sum(order_s_s35) as  \"order_s_s35\",sum(order_s_s36) as  \"order_s_s36\",sum(order_s_s37) as  \"order_s_s37\",sum(order_s_s38) as  \"order_s_s38\",sum(order_s_s39) as  \"order_s_s39\",sum(order_s_s40) as  \"order_s_s40\",sum(order_s_s41) as  \"order_s_s41\",sum(order_s_s42) as  \"order_s_s42\",sum(order_s_s43) as  \"order_s_s43\",sum(order_s_s44) as  \"order_s_s44\",sum(order_s_s45) as  \"order_s_s45\",sum(order_s_s46) as  \"order_s_s46\",sum(order_s_s47) as  \"order_s_s47\",sum(order_s_s48) as  \"order_s_s48\",sum(order_s_s49) as  \"order_s_s49\",sum(order_s_s50) as  \"order_s_s50\"
    from $bai_pro3.bai_orders_db_confirm where order_del_no='$schedule'";
    $sql_results12=mysqli_query($link,$sqls12) or exit("Sql Error3".mysqli_error());
    $qtycs_=array();
    while($sql_rows=mysqli_fetch_array($sql_results12))
	{
		for($kk=0;$kk<sizeof($sizes);$kk++)
		{
			$qtycs_[]=$sql_rows["order_s_".$sizes_array[$kk].""];
		}
	}
	for($i=0;$i<sizeof($sizes);$i++)
	{
		echo "<td $style_css>".round((abs($cs_[$i]-$qtycs_[$i])/$qtycs_[$i]),2)."%</td>";
	}	   
	echo "<td></td>";
	echo "</tr>";
	echo "</table>";
 ?>
  
  
  
  
  </td>
  <td class=xl1532599></td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl1532599 style='height:15.0pt'></td>
  <td class=xl1532599></td>
 </tr>
 <tr height=21 style='height:15.75pt'>
  <td height=21 class=xl1532599 style='height:15.75pt'></td>
  <td class=xl1532599></td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl1532599 style='height:15.0pt'></td>
  <td class=xl1532599></td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl1532599 style='height:15.0pt'></td>
  <td class=xl1532599></td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl1532599 style='height:15.0pt'></td>
  <td class=xl1532599></td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl1532599 style='height:15.0pt'></td>
  <td class=xl1532599></td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl1532599 style='height:15.0pt'></td>
  <td class=xl1532599></td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl1532599 style='height:15.0pt'></td>
  <td class=xl1532599></td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl1532599 style='height:15.0pt'></td>
  <td class=xl1532599></td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl1532599 style='height:15.0pt'></td>
  <td class=xl1532599></td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl1532599 style='height:15.0pt'></td>
  <td class=xl1532599></td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl1532599 style='height:15.0pt'></td>
  <td class=xl1532599></td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl1532599 style='height:15.0pt'></td>
  <td class=xl1532599></td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl1532599 style='height:15.0pt'></td>
  <td class=xl1532599></td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl1532599 style='height:15.0pt'></td>
  <td class=xl1532599></td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl1532599 style='height:15.0pt'></td>
  <td class=xl1532599></td>
 </tr>
 <tr height=21 style='height:15.75pt'>
  <td height=21 class=xl1532599 style='height:15.75pt'></td>
  <td class=xl6432599></td>
  <td class=xl7932599></td>
  <td class=xl7932599></td>
  <td class=xl7932599></td>
  <td class=xl7932599></td>
  <td class=xl7932599></td>
  <td class=xl7932599></td>
  <td class=xl7932599></td>
  <td class=xl7932599></td>
  <td class=xl7932599></td>
  <td class=xl7932599></td>
  <td class=xl7932599></td>
  <td class=xl7932599></td>
  <td class=xl7932599></td>
  <td class=xl7932599></td>
  <td class=xl7932599></td>
  <td class=xl7932599></td>
  <td class=xl7932599></td>
  <td class=xl7932599></td>
  <td class=xl7932599></td>
  <td class=xl7932599></td>
  <td class=xl7932599></td>
  <td class=xl7932599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl7532599>&nbsp;</td>
  <td class=xl1532599></td>
 </tr>
 </table>
 <table border=0 cellpadding=0 cellspacing=0 width=2000 align=center style='border-collapse:collapse'>
 <tr height=21 style='height:15.75pt'>
  <td height=21 class=xl1532599 style='height:15.75pt'></td>
  <td class=xl6432599></td>
  <td rowspan=2 class=xl9232599 width=64 style='border-bottom:.5pt solid black;
  width:48pt'>Recon.</td>
  <td colspan=2 class=xl9432599 style='border-right:.5pt solid black;
  border-left:none'>Section</td>
  <td colspan=2 class=xl9632599 style='border-right:.5pt solid black;
  border-left:none'>Date Completed</td>
  <td colspan=2 class=xl9632599 style='border-right:.5pt solid black;
  border-left:none'>Fabric Recived</td>
  <td colspan=2 class=xl9632599 style='border-right:.5pt solid black;
  border-left:none'>Cut Qty</td>
  <td colspan=2 class=xl9632599 style='border-right:.5pt solid black;
  border-left:none'>Re-Cut Qty</td>
  <td colspan=2 class=xl9632599 style='border-right:.5pt solid black;
  border-left:none'>Act YY</td>
  <td class=xl7632599>CAD YY</td>
  <td colspan=2 class=xl9432599 style='border-right:.5pt solid black;
  border-left:none'>Act Saving</td>
  <td colspan=2 class=xl9632599 style='border-right:.5pt solid black;
  border-left:none'>Shortage</td>
  <td colspan=2 class=xl9632599 style='border-right:.5pt solid black;
  border-left:none'>Deficit / Surplus</td>
  <td colspan=2 class=xl9632599 style='border-right:.5pt solid black;
  border-left:none'>Reconsilation</td>
  <td class=xl7632599>Sign</td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl1532599></td>
 </tr>
 <tr height=40 style='height:30pt'>
  <td height=21 class=xl1532599 style='height:15.75pt'></td>
  <td class=xl6432599></td>
  <td colspan=2 class=xl8932599 style='border-right:.5pt solid black;
  border-left:none'>&nbsp;</td>
  <td colspan=2 class=xl9132599 style='border-right:.5pt solid black;
  border-left:none'>&nbsp;</td>
  <td colspan=2 class=xl9132599 style='border-right:.5pt solid black;
  border-left:none'>&nbsp;</td>
  <td colspan=2 class=xl9132599 style='border-right:.5pt solid black;
  border-left:none'>&nbsp;</td>
  <td colspan=2 class=xl9132599 style='border-right:.5pt solid black;
  border-left:none'>&nbsp;</td>
  <td colspan=2 class=xl9132599 style='border-right:.5pt solid black;
  border-left:none'>&nbsp;</td>
  <td class=xl6632599>&nbsp;</td>
  <td colspan=2 class=xl8932599 style='border-right:.5pt solid black;
  border-left:none'>&nbsp;</td>
  <td colspan=2 class=xl9132599 style='border-right:.5pt solid black;
  border-left:none'>&nbsp;</td>
  <td colspan=2 class=xl9132599 style='border-right:.5pt solid black;
  border-left:none'>&nbsp;</td>
  <td colspan=2 class=xl9132599 style='border-right:.5pt solid black;
  border-left:none'>&nbsp;</td>
  <td class=xl6732599>&nbsp;</td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl1532599></td>
 </tr>
 <tr height=21 style='height:15.75pt'>
  <td height=21 class=xl1532599 style='height:15.75pt'></td>
  <td class=xl6432599></td>
  <td class=xl7932599></td>
  <td class=xl7932599></td>
  <td class=xl7932599></td>
  <td class=xl7932599></td>
  <td class=xl7932599></td>
  <td class=xl7932599></td>
  <td class=xl7932599></td>
  <td class=xl7932599></td>
  <td class=xl7932599></td>
  <td class=xl7932599></td>
  <td class=xl7932599></td>
  <td class=xl7932599></td>
  <td class=xl7932599></td>
  <td class=xl7932599></td>
  <td class=xl7932599></td>
  <td class=xl7932599></td>
  <td class=xl7932599></td>
  <td class=xl7932599></td>
  <td class=xl7932599></td>
  <td class=xl7932599></td>
  <td class=xl7932599></td>
  <td class=xl7932599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl6432599></td>
  <td class=xl1532599></td>
 </tr>
 <![if supportMisalignedColumns]>
 <tr height=0 style='display:none'>
  <td width=22 style='width:17pt'></td>
  <td width=86 style='width:65pt'></td>
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
  <td width=64 style='width:48pt'></td>
 </tr>
 <![endif]>
</table>

</div>

<style>

	.xl1532599,.xl6432599,.xl6532599,.xl6632599,.xl6732599,.xl6832599,.xl6932599,.xl7032599,.xl7132599,
	.xl7232599,.xl7332599,.xl7432599,.xl7532599,.xl7632599,.xl7732599,.xl7832599,.xl7932599,.xl8032599,.xl8132599,
	.xl8232599,.xl8332599,.xl8432599,.xl8532599,.xl8632599,.xl8732599,.xl8832599,.xl8932599,.xl9032599,.xl9132599,
	.xl9232599,.xl9332599,.xl9432599,.xl9532599,.xl9632599,.xl9732599,.xl9832599{
		font-size : 22px;
	}
	*{
		font-size : 22px;
	}
	tr{
		height : 40px;
	}
</style>

<!----------------------------->
<!--END OF OUTPUT FROM EXCEL PUBLISH AS WEB PAGE WIZARD-->
<!----------------------------->
</body>

</html>
