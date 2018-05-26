<?php 
//Ticket #419256 - KiranG 2013-05-06 : Rework, Rejection, Surplus columns are added to this sheet. Also global level enable and disable option given to show total cut quantity on review sheet (for total input reporting to module).
?>
<?php include("../../../../common/php/functions.php"); 
include("../../../../common/config/config.php"); 
?>

<?php
$order_tid=$_GET['order_tid'];
$user="Admin";
$doc_no=$_GET['doc_no'];
$cut_no=$_GET['cut_no'];

$sql1="select * from $bai_pro3.cat_stat_log where order_tid=\"$order_tid\" and category in (\"Body\",\"Front\") and purwidth>0";
mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row1=mysqli_fetch_array($sql_result1))
{
	$CID=$sql_row1['tid'];
}

//NEW

$sqlc="SELECT cuttable_percent as cutper from $bai_pro3.cuttable_stat_log where cat_id=$CID";
$sql_resultc=mysqli_query($link, $sqlc) or exit("Sql Error4".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_rowc=mysqli_fetch_array($sql_resultc))
{
	$cut_per=$sql_rowc['cutper'];
}

$sql="select sum(allocate_xs*plies) as \"cuttable_s_xs\", sum(allocate_s*plies) as \"cuttable_s_s\", sum(allocate_m*plies) as \"cuttable_s_m\", sum(allocate_l*plies) as \"cuttable_s_l\", sum(allocate_xl*plies) as \"cuttable_s_xl\", sum(allocate_xxl*plies) as \"cuttable_s_xxl\", sum(allocate_xxxl*plies) as \"cuttable_s_xxxl\" from $bai_pro3.allocate_stat_log where order_tid=\"$order_tid\" and cat_ref=$CID";
mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_num_=mysqli_num_rows($sql_result);
while($sql_row=mysqli_fetch_array($sql_result))
{
	$c_xs=$sql_row['cuttable_s_xs'];
	$c_s=$sql_row['cuttable_s_s'];
	$c_m=$sql_row['cuttable_s_m'];
	$c_l=$sql_row['cuttable_s_l'];
	$c_xl=$sql_row['cuttable_s_xl'];
	$c_xxl=$sql_row['cuttable_s_xxl'];
	$c_xxxl=$sql_row['cuttable_s_xxxl'];
}

$sql="select * from $bai_pro3.bai_orders_db_confirm where order_tid=\"$order_tid\"";
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_num_confirm=mysqli_num_rows($sql_result);

if($sql_num_confirm>0)
{
	$sql="select * from $bai_pro3.bai_orders_db_confirm where order_tid=\"$order_tid\"";
}
else
{
	$sql="select * from $bai_pro3.bai_orders_db where order_tid=\"$order_tid\"";
}
mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_num_=mysqli_num_rows($sql_result);
while($sql_row=mysqli_fetch_array($sql_result))
{
	
	$o_xs=$sql_row['order_s_xs'];
	$o_s=$sql_row['order_s_s'];
	$o_m=$sql_row['order_s_m'];
	$o_l=$sql_row['order_s_l'];
	$o_xl=$sql_row['order_s_xl'];
	$o_xxl=$sql_row['order_s_xxl'];
	$o_xxxl=$sql_row['order_s_xxxl'];
	
	
	$total_ord=$sql_row["old_order_s_xs"]+$sql_row["old_order_s_s"]+$sql_row["old_order_s_m"]+$sql_row["old_order_s_l"]+$sql_row["old_order_s_xl"]+$sql_row["old_order_s_xxl"]+$sql_row["old_order_s_xxxl"]+$sql_row["old_order_s_s06"]+$sql_row["old_order_s_s08"]+$sql_row["old_order_s_s10"]+$sql_row["old_order_s_s12"]+$sql_row["old_order_s_s14"]+$sql_row["old_order_s_s16"]+$sql_row["old_order_s_s18"]+$sql_row["old_order_s_s20"]+$sql_row["old_order_s_s22"]+$sql_row["old_order_s_s24"]+$sql_row["old_order_s_s26"]+$sql_row["old_order_s_s28"]+$sql_row["old_order_s_s30"];
	
	$total_qty_ord=$sql_row["order_s_xs"]+$sql_row["order_s_s"]+$sql_row["order_s_m"]+$sql_row["order_s_l"]+$sql_row["order_s_xl"]+$sql_row["order_s_xxl"]+$sql_row["order_s_xxxl"]+$sql_row["order_s_s06"]+$sql_row["order_s_s08"]+$sql_row["order_s_s10"]+$sql_row["order_s_s12"]+$sql_row["order_s_s14"]+$sql_row["order_s_s16"]+$sql_row["order_s_s18"]+$sql_row["order_s_s20"]+$sql_row["order_s_s22"]+$sql_row["order_s_s24"]+$sql_row["order_s_s26"]+$sql_row["order_s_s28"]+$sql_row["order_s_s30"];
	
	$extra_ship_ord=round(($total_qty_ord-$total_ord)*100/$total_ord,0);
	
	$order_date=$sql_row["order_date"];
}

?>
<?php  
 
 
 	$a_xs_tot=0;
	$a_s_tot=0;
	$a_m_tot=0;
	$a_l_tot=0;
	$a_xl_tot=0;
	$a_xxl_tot=0;
	$a_xxxl_tot=0;
	$plies_tot=0;
	
$sql="select * from $bai_pro3.plandoc_stat_log where order_tid=\"$order_tid\" and cat_ref=$CID and remarks=\"Pilot\" order by acutno";
mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_num_=mysqli_num_rows($sql_result);
while($sql_row=mysqli_fetch_array($sql_result))
{
	$a_xs=$sql_row['a_xs'];
	$a_s=$sql_row['a_s'];
	$a_m=$sql_row['a_m'];
	$a_l=$sql_row['a_l'];
	$a_xl=$sql_row['a_xl'];
	$a_xxl=$sql_row['a_xxl'];
	$a_xxxl=$sql_row['a_xxxl'];
	$cutno=$sql_row['acutno'];
	$plies=$sql_row['p_plies'];
	$docketno=$sql_row['doc_no'];
	$docketdate=$sql_row['date'];
	$mk_ref=$sql_row['mk_ref'];
	
	$a_xs_tot=$a_xs_tot+($a_xs*$plies);
	$a_s_tot=$a_s_tot+($a_s*$plies);
	$a_m_tot=$a_m_tot+($a_m*$plies);
	$a_l_tot=$a_l_tot+($a_l*$plies);
	$a_xl_tot=$a_xl_tot+($a_xl*$plies);
	$a_xxl_tot=$a_xxl_tot+($a_xxl*$plies);
	$a_xxxl_tot=$a_xxxl_tot+($a_xxxl*$plies);
	$plies_tot=$plies_tot+$plies;

 }
 
 
 	$a_xs_tot=0;
	$a_s_tot=0;
	$a_m_tot=0;
	$a_l_tot=0;
	$a_xl_tot=0;
	$a_xxl_tot=0;
	$a_xxxl_tot=0;
	$plies_tot=0;
	
	$ex_xs=0;
	$ex_s=0;
	$ex_m=0;
	$ex_l=0;
	$ex_xl=0;
	$ex_xxl=0;
	$ex_xxxl=0;
	
if($input_excess_cut_as_full_input==1)
{
	//To identify the first cut no.	
	$sql="select min(acutno) as firstcut from $bai_pro3.plandoc_stat_log where order_tid=\"$order_tid\" and cat_ref=$CID and remarks=\"Normal\"";
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row=mysqli_fetch_array($sql_result))
	{	
		$first_cut=$sql_row['firstcut'];
	}
}
	
	
$sql="select * from $bai_pro3.plandoc_stat_log where order_tid=\"$order_tid\" and cat_ref=$CID and remarks=\"Normal\" order by acutno";
mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_num_=mysqli_num_rows($sql_result);
while($sql_row=mysqli_fetch_array($sql_result))
{
	$a_xs=$sql_row['a_xs'];
	$a_s=$sql_row['a_s'];
	$a_m=$sql_row['a_m'];
	$a_l=$sql_row['a_l'];
	$a_xl=$sql_row['a_xl'];
	$a_xxl=$sql_row['a_xxl'];
	$a_xxxl=$sql_row['a_xxxl'];
	$cutno=$sql_row['acutno'];
	$plies=$sql_row['p_plies'];
	$docketno=$sql_row['doc_no'];
	$docketdate=$sql_row['date'];
	$mk_ref=$sql_row['mk_ref'];
	
	$a_xs_tot=$a_xs_tot+($a_xs*$plies);
	$a_s_tot=$a_s_tot+($a_s*$plies);
	$a_m_tot=$a_m_tot+($a_m*$plies);
	$a_l_tot=$a_l_tot+($a_l*$plies);
	$a_xl_tot=$a_xl_tot+($a_xl*$plies);
	$a_xxl_tot=$a_xxl_tot+($a_xxl*$plies);
	$a_xxxl_tot=$a_xxxl_tot+($a_xxxl*$plies);
	$plies_tot=$plies_tot+$plies;
	
	if($cutno==$first_cut)
	{
	
	$ex_xs=($c_xs-$o_xs);
	$ex_s=($c_s-$o_s);
	$ex_m=($c_m-$o_m);
	$ex_l=($c_l-$o_l);
	$ex_xl=($c_xl-$o_xl);
	$ex_xxl=($c_xxl-$o_xxl);
	$ex_xxxl=($c_xxxl-$o_xxxl);
	
	
	
	
	
	
	
	

	
  
  
  $temp_sum=0;
 if(($a_xs*$plies)<$ex_xs){ if($cutno==$cut_no) {$a_xs_n=0;} $ex_xs=$ex_xs-($a_xs*$plies);} else { if($cutno==$cut_no) {$a_xs_n=($a_xs*$plies)-$ex_xs; }$temp_sum=$temp_sum+($a_xs*$plies)-$ex_xs; $ex_xs=0; }

 if(($a_s*$plies)<$ex_s){ if($cutno==$cut_no){ $a_s_n=0;} $ex_s=$ex_s-($a_s*$plies);} else {if($cutno==$cut_no) {$a_s_n= ($a_s*$plies)-$ex_s;} $temp_sum=$temp_sum+($a_s*$plies)-$ex_s; $ex_s=0; } 
 
 if(($a_m*$plies)<$ex_m){ if($cutno==$cut_no) {$a_m_n=0;} $ex_m=$ex_m-($a_m*$plies);} else { if($cutno==$cut_no) {$a_m_n= ($a_m*$plies)-$ex_m; }$temp_sum=$temp_sum+($a_m*$plies)-$ex_m; $ex_m=0; } 
 
 if(($a_l*$plies)<$ex_l){ if($cutno==$cut_no) {$a_l_n=0;} $ex_l=$ex_l-($a_l*$plies);} else { if($cutno==$cut_no) {$a_l_n= ($a_l*$plies)-$ex_l;} $temp_sum=$temp_sum+($a_l*$plies)-$ex_l; $ex_l=0; } 
 
 if(($a_xl*$plies)<$ex_xl){ if($cutno==$cut_no) {$a_xl_n=0;} $ex_xl=$ex_xl-($a_xl*$plies);} else { if($cutno==$cut_no) { $a_xl_n= ($a_xl*$plies)-$ex_xl; } $temp_sum=$temp_sum+($a_xl*$plies)-$ex_xl; $ex_xl=0; }

 if(($a_xxl*$plies)<$ex_xxl){ if($cutno==$cut_no) {$a_xxl_n=0; }$ex_xxl=$ex_xxl-($a_xxl*$plies);} else {if($cutno==$cut_no) {$a_xxl_n= ($a_xxl*$plies)-$ex_xxl; } $temp_sum=$temp_sum+($a_xxl*$plies)-$ex_xxl; $ex_xxl=0; }

 if(($a_xxxl*$plies)<$ex_xxxl){ if($cutno==$cut_no) {$a_xxxl_n=0;} $ex_xxxl=$ex_xxxl-($a_xxxl*$plies);} else { if($cutno==$cut_no) {$a_xxxl_n= ($a_xxxl*$plies)-$ex_xxxl; } $temp_sum=$temp_sum+($a_xxxl*$plies)-$ex_xxxl; $ex_xxxl=0; }
  if($cutno==$cut_no) {$temp_sum_n= $temp_sum; }
  
 
 }
	else
	{
		
		//First cut will be excempted and total input can be reported to module, based on the global value.
		if($input_excess_cut_as_full_input==0)
		{
			//To identify the first cut no.	
			$sqlxy="select min(acutno) as firstcut from $bai_pro3.plandoc_stat_log where order_tid=\"$order_tid\" and cat_ref=$CID and remarks=\"Normal\"";
			$sql_resultxy=mysqli_query($link, $sqlxy) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_rowxy=mysqli_fetch_array($sql_resultxy))
			{	
				$first_cut_new=$sql_rowxy['firstcut'];
			}
			
			if(($emb_a+$emb_b+$emb_c+$emb_d)>0 and $cutno==$first_cut_new) // Embllishment - Only Garment Form
			{
				$ex_xs=round(($c_xs-$o_xs)/2);
				$ex_s=round(($c_s-$o_s)/2);
				$ex_m=round(($c_m-$o_m)/2);
				$ex_l=round(($c_l-$o_l)/2);
				$ex_xl=round(($c_xl-$o_xl)/2);
				$ex_xxl=round(($c_xxl-$o_xxl)/2);
		    	$ex_xxxl=round(($c_xxxl-$o_xxxl)/2);
			}
			
		}
	
 
  $temp_sum=0;
 if(($a_xs*$plies)<$ex_xs){ if($cutno==$cut_no) {$a_xs_n=0;} $ex_xs=$ex_xs-($a_xs*$plies);} else { if($cutno==$cut_no) {$a_xs_n=($a_xs*$plies)-$ex_xs; }$temp_sum=$temp_sum+($a_xs*$plies)-$ex_xs; $ex_xs=0; }

 if(($a_s*$plies)<$ex_s){ if($cutno==$cut_no){ $a_s_n=0;} $ex_s=$ex_s-($a_s*$plies);} else {if($cutno==$cut_no) {$a_s_n= ($a_s*$plies)-$ex_s;} $temp_sum=$temp_sum+($a_s*$plies)-$ex_s; $ex_s=0; } 
 
 if(($a_m*$plies)<$ex_m){ if($cutno==$cut_no) {$a_m_n=0;} $ex_m=$ex_m-($a_m*$plies);} else { if($cutno==$cut_no) {$a_m_n= ($a_m*$plies)-$ex_m; }$temp_sum=$temp_sum+($a_m*$plies)-$ex_m; $ex_m=0; } 
 
 if(($a_l*$plies)<$ex_l){ if($cutno==$cut_no) {$a_l_n=0;} $ex_l=$ex_l-($a_l*$plies);} else { if($cutno==$cut_no) {$a_l_n= ($a_l*$plies)-$ex_l;} $temp_sum=$temp_sum+($a_l*$plies)-$ex_l; $ex_l=0; } 
 
 if(($a_xl*$plies)<$ex_xl){ if($cutno==$cut_no) {$a_xl_n=0;} $ex_xl=$ex_xl-($a_xl*$plies);} else { if($cutno==$cut_no) { $a_xl_n= ($a_xl*$plies)-$ex_xl; } $temp_sum=$temp_sum+($a_xl*$plies)-$ex_xl; $ex_xl=0; }

 if(($a_xxl*$plies)<$ex_xxl){ if($cutno==$cut_no) {$a_xxl_n=0; }$ex_xxl=$ex_xxl-($a_xxl*$plies);} else {if($cutno==$cut_no) {$a_xxl_n= ($a_xxl*$plies)-$ex_xxl; } $temp_sum=$temp_sum+($a_xxl*$plies)-$ex_xxl; $ex_xxl=0; }

 if(($a_xxxl*$plies)<$ex_xxxl){ if($cutno==$cut_no) {$a_xxxl_n=0;} $ex_xxxl=$ex_xxxl-($a_xxxl*$plies);} else { if($cutno==$cut_no) {$a_xxxl_n= ($a_xxxl*$plies)-$ex_xxxl; } $temp_sum=$temp_sum+($a_xxxl*$plies)-$ex_xxxl; $ex_xxxl=0; }
  if($cutno==$cut_no) {$temp_sum_n= $temp_sum; }
  
 
 }
 }
 ?>
 
 <?php
//NEW

$sql="select * from $bai_pro3.review_print_track where ref_tid=\"$order_tid\"";
mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$printed_count=mysqli_num_rows($sql_result);
$printed_count=$printed_count;
if($printed_count==0)
{
	$printed_count=1;
}
else
{
	$printed_count=$printed_count+1;
}

$sql="select * from $bai_pro3.review_print_track";
mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$doc_count=mysqli_num_rows($sql_result);
if($doc_count==0)
{
	$doc_count=1;
}
else
{
	$doc_count=$doc_count+1;
}


$sql="insert into review_print_track (ref_tid, log_user) values (\"$order_tid\",\"$user\")";
mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));

$sql1="select * from $bai_pro3.bai_orders_db where order_tid=\"$order_tid\"";
mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row1=mysqli_fetch_array($sql_result1))
{
	$style=$sql_row1['order_style_no'];
	$schedule=$sql_row1['order_del_no'];	
	$color=$sql_row1['order_col_des'];
	$cutid=chr($sql_row1['color_code']); 
}


?>
<html xmlns:o="urn:schemas-microsoft-com:office:office"
xmlns:x="urn:schemas-microsoft-com:office:excel"
xmlns="http://www.w3.org/TR/REC-html40">

<head>
<meta http-equiv=Content-Type content="text/html; charset=windows-1252">
<meta name=ProgId content=Excel.Sheet>
<meta name=Generator content="Microsoft Excel 14">
<link rel=File-List href="review_files/filelist.xml">
<style id="Book1_666_Styles">
<!--table
	{mso-displayed-decimal-separator:"\.";
	mso-displayed-thousand-separator:"\,";}
.xl15666
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
.xl63666
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
.xl64666
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:8.0pt;
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
.xl65666
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
	border-bottom:.5pt hairline windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl66666
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
.xl67666
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:9.0pt;
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
.xl68666
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:9.0pt;
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
.xl69666
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
.xl70666
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
	border-bottom:.5pt solid windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl71666
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
.xl72666
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
	border-bottom:.5pt solid windowtext;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl73666
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:9.0pt;
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
.xl74666
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:9.0pt;
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
.xl75666
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:9.0pt;
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
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl76666
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:9.0pt;
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
.xl77666
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:9.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:bottom;
	border-top:1.0pt solid windowtext;
	border-right:.5pt solid windowtext;
	border-bottom:.5pt solid windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl78666
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:9.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:bottom;
	border-top:1.0pt solid windowtext;
	border-right:none;
	border-bottom:.5pt solid windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl79666
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:9.0pt;
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
	border-bottom:1.0pt solid windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl80666
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:9.0pt;
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
	border-bottom:1.0pt solid windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl81666
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:9.0pt;
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
	border-left:1.0pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl82666
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
.xl83666
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
	border-bottom:.5pt solid windowtext;
	border-left:1.0pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl84666
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
	border-right:1.0pt solid windowtext;
	border-bottom:.5pt solid windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl85666
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
	border-right:1.0pt solid windowtext;
	border-bottom:.5pt solid windowtext;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl86666
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:9.0pt;
	font-weight:700;
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
	border-left:1.0pt solid windowtext;
	background:#D8D8D8;
	mso-pattern:black none;
	white-space:nowrap;}
.xl87666
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
	border-bottom:.5pt solid windowtext;
	border-left:none;
	background:#D8D8D8;
	mso-pattern:black none;
	white-space:nowrap;}
.xl88666
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
	background:#D8D8D8;
	mso-pattern:black none;
	white-space:nowrap;}
.xl89666
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
	border-bottom:.5pt solid windowtext;
	border-left:1.0pt solid windowtext;
	background:#D8D8D8;
	mso-pattern:black none;
	white-space:nowrap;}
.xl90666
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
	border-right:1.0pt solid windowtext;
	border-bottom:.5pt solid windowtext;
	border-left:none;
	background:#D8D8D8;
	mso-pattern:black none;
	white-space:nowrap;}
.xl91666
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
	border-right:1.0pt solid windowtext;
	border-bottom:.5pt solid windowtext;
	border-left:.5pt solid windowtext;
	background:#D8D8D8;
	mso-pattern:black none;
	white-space:nowrap;}
.xl92666
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:9.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:general;
	vertical-align:bottom;
	border-top:none;
	border-right:.5pt solid windowtext;
	border-bottom:1.0pt solid windowtext;
	border-left:1.0pt solid windowtext;
	background:#BFBFBF;
	mso-pattern:black none;
	white-space:nowrap;}
.xl93666
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
	border-bottom:1.0pt solid windowtext;
	border-left:none;
	background:#BFBFBF;
	mso-pattern:black none;
	white-space:nowrap;}
.xl94666
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
	border-bottom:1.0pt solid windowtext;
	border-left:none;
	background:#BFBFBF;
	mso-pattern:black none;
	white-space:nowrap;}
.xl95666
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
	border-bottom:1.0pt solid windowtext;
	border-left:1.0pt solid windowtext;
	background:#BFBFBF;
	mso-pattern:black none;
	white-space:nowrap;}
.xl96666
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
	border-right:1.0pt solid windowtext;
	border-bottom:1.0pt solid windowtext;
	border-left:none;
	background:#BFBFBF;
	mso-pattern:black none;
	white-space:nowrap;}
.xl97666
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
	border-right:1.0pt solid windowtext;
	border-bottom:1.0pt solid windowtext;
	border-left:.5pt solid windowtext;
	background:#BFBFBF;
	mso-pattern:black none;
	white-space:nowrap;}
.xl98666
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:9.0pt;
	font-weight:700;
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
.xl99666
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:12.0pt;
	font-weight:700;
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
.xl100666
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:12.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
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
.xl101666
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:9.0pt;
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
.xl102666
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:9.0pt;
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
.xl103666
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:9.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
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
.xl104666
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:26.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:underline;
	text-underline-style:single;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:middle;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl105666
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
.xl106666
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
.xl107666
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
	border-right:.5pt solid black;
	border-bottom:.5pt solid windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl108666
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:9.0pt;
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
.xl109666
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:9.0pt;
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
	border-bottom:.5pt solid windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl110666
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:9.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:bottom;
	border-top:1.0pt solid windowtext;
	border-right:.5pt solid windowtext;
	border-bottom:none;
	border-left:1.0pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl111666
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:9.0pt;
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
	border-bottom:1.0pt solid black;
	border-left:1.0pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl112666
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
	border-top:1.0pt solid windowtext;
	border-right:none;
	border-bottom:.5pt solid windowtext;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl113666
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
	border-top:1.0pt solid windowtext;
	border-right:.5pt solid black;
	border-bottom:.5pt solid windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl114666
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
	border-top:1.0pt solid windowtext;
	border-right:none;
	border-bottom:.5pt solid windowtext;
	border-left:.5pt solid black;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl115666
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:9.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:bottom;
	border-top:1.0pt solid windowtext;
	border-right:.5pt solid windowtext;
	border-bottom:none;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl116666
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:9.0pt;
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
	border-bottom:1.0pt solid black;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl117666
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:9.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:bottom;
	border-top:1.0pt solid windowtext;
	border-right:1.0pt solid windowtext;
	border-bottom:none;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl118666
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:9.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:bottom;
	border-top:none;
	border-right:1.0pt solid windowtext;
	border-bottom:1.0pt solid black;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl119666
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:9.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:bottom;
	border-top:1.0pt solid windowtext;
	border-right:1.0pt solid windowtext;
	border-bottom:none;
	border-left:1.0pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl120666
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:9.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:bottom;
	border-top:none;
	border-right:1.0pt solid windowtext;
	border-bottom:1.0pt solid black;
	border-left:1.0pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl121666
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:9.0pt;
	font-weight:700;
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
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl122666
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
	border-right:.5pt solid windowtext;
	border-bottom:.5pt solid windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl123666
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
.xl124666
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
.xl125666
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
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl126666
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:9.0pt;
	font-weight:700;
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
	background:#D8D8D8;
	mso-pattern:black none;
	white-space:nowrap;}
.xl127666
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:9.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:general;
	vertical-align:bottom;
	border-top:none;
	border-right:.5pt solid windowtext;
	border-bottom:1.0pt solid windowtext;
	border-left:none;
	background:#BFBFBF;
	mso-pattern:black none;
	white-space:nowrap;}
.xl128666
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:9.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:center;
	vertical-align:bottom;
	border-top:1.0pt solid windowtext;
	border-right:.5pt solid windowtext;
	border-bottom:none;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl129666
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:9.0pt;
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
	border-bottom:1.0pt solid black;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl130666
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
.xl131666
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:9.0pt;
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
.xl132666
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:26.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:underline;
	text-underline-style:single;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:general;
	vertical-align:middle;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl133666
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:26.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:underline;
	text-underline-style:single;
	font-family:Calibri, sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:general;
	vertical-align:middle;
	border-top:none;
	border-right:.5pt solid black;
	border-bottom:none;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl134666
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:12.0pt;
	font-weight:700;
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
.xl135666
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:9.0pt;
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
.xl136666
	{padding-top:1px;
	padding-right:1px;
	padding-left:1px;
	mso-ignore:padding;
	color:black;
	font-size:9.0pt;
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
-->
body{
	zoom:100%;
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
body { zoom:90%;}
#ad{ display:none;}
#leftbar{ display:none;}
#Book1_15271{ width:95%;}
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

<body onload="printpr();">
<!--[if !excel]>&nbsp;&nbsp;<![endif]-->
<!--The following information was generated by Microsoft Excel's Publish as Web
Page wizard.-->
<!--If the same item is republished from Excel, all information between the DIV
tags will be replaced.-->
<!----------------------------->
<!--START OF OUTPUT FROM EXCEL PUBLISH AS WEB PAGE WIZARD -->
<!----------------------------->

<div id="Book1_666" align=center x:publishsource="Excel"><!--The following information was generated by Microsoft Office Excel's Publish
as Web Page wizard.--><!--If the same item is republished from Excel, all information between the DIV
tags will be replaced.--><!-----------------------------><!--START OF OUTPUT FROM EXCEL PUBLISH AS WEB PAGE WIZARD --><!----------------------------->

<table border=0 cellpadding=0 cellspacing=0 width=1600 style='border-collapse:
 collapse;table-layout:fixed;width:1350pt'>
 <col width=5 style='mso-width-source:userset;mso-width-alt:182;width:4pt'>
 <col width=108 style='mso-width-source:userset;mso-width-alt:3949;width:81pt'>
 <col width=55 span=12 style='mso-width-source:userset;mso-width-alt:2011;
 width:41pt'>
 <col width=53 style='mso-width-source:userset;mso-width-alt:1938;width:40pt'>
 <col width=48 style='mso-width-source:userset;mso-width-alt:1755;width:36pt'>
 <col width=44 style='mso-width-source:userset;mso-width-alt:1609;width:33pt'>
 <col width=49 style='mso-width-source:userset;mso-width-alt:1792;width:37pt'>
 <col width=60 span=7 style='mso-width-source:userset;mso-width-alt:2194;
 width:45pt'>
 <col width=64 span=2 style='width:48pt'>
 <col width=23 style='mso-width-source:userset;mso-width-alt:841;width:17pt'>
 <tr height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl63666 width=5 style='height:15.0pt;width:4pt'><a
  name="RANGE!A1:AB38"></a></td>
  <td colspan=4 rowspan=3 class=xl71666 width=273 style='width:204pt'><img src="bai_logo.jpg"></td>
  <td class=xl63666 width=55 style='width:41pt'></td>
  <td class=xl63666 width=55 style='width:41pt'></td>
  <td class=xl63666 width=55 style='width:41pt'></td>
  <td class=xl63666 width=55 style='width:41pt'></td>
  <td class=xl63666 width=55 style='width:41pt'></td>
  <td class=xl63666 width=55 style='width:41pt'></td>
  <td class=xl63666 width=55 style='width:41pt'></td>
  <td class=xl63666 width=55 style='width:41pt'></td>
  <td class=xl63666 width=55 style='width:41pt'></td>
  <td class=xl63666 width=53 style='width:40pt'></td>
  <td class=xl63666 width=48 style='width:36pt'></td>
  <td class=xl63666 width=44 style='width:33pt'></td>
  <td class=xl63666 width=49 style='width:37pt'></td>
  <td class=xl63666 width=60 style='width:45pt'></td>
  <td class=xl63666 width=60 style='width:45pt'></td>
  <td class=xl63666 width=60 style='width:45pt'></td>
  <td class=xl63666 width=60 style='width:45pt'></td>
  <td class=xl63666 width=60 style='width:45pt'></td>
  <td class=xl15666 width=60 style='width:45pt'></td>
  <td class=xl15666 width=60 style='width:45pt'></td>
  <td class=xl15666 width=64 style='width:48pt'></td>
  <td class=xl15666 width=64 style='width:48pt'></td>
  <td class=xl15666 width=23 style='width:17pt'></td>
 </tr>
 <tr height=28 style='mso-height-source:userset;height:21.0pt'>
  <td height=28 class=xl63666 style='height:21.0pt'></td>
  <td class=xl63666></td>
  <td class=xl63666></td>
  <td class=xl63666></td>
  <td class=xl63666></td>
  <td class=xl63666></td>
  <td class=xl63666></td>
  <td class=xl63666></td>
  <td class=xl63666></td>
  <td class=xl63666></td>
  <td class=xl63666></td>
  <td class=xl63666></td>
  <td class=xl63666></td>
  <td class=xl63666></td>
  <td class=xl63666></td>
  <td class=xl63666></td>
  <td class=xl63666></td>
  <td class=xl64666>Page No:</td>
  <td class=xl65666><?php echo $printed_count ?></td>
  <td class=xl63666></td>
  <td class=xl63666></td>
  <td class=xl63666></td>
  <td class=xl63666></td>
  <td class=xl15666></td>
 </tr>
 <tr height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl63666 style='height:15.0pt'></td>
  <td class=xl63666></td>
  <td class=xl63666></td>
  <td class=xl63666></td>
  <td class=xl63666></td>
  <td class=xl15666></td>
  <td class=xl15666></td>
  <td class=xl15666></td>
  <td class=xl66666>LID:</td>
  <td colspan=2 class=xl99666 style='border-right:.5pt solid black'><?php echo $CID; ?></td>
  <td class=xl134666></td>
  <td class=xl63666></td>
  <td class=xl67666>Hour No</td>
  <td class=xl68666>Style</td>
  <td class=xl68666>Schdl</td>
  <td colspan=3 class=xl102666 style='border-right:.5pt solid black;border-left:
  none'>Color</td>
  <td class=xl68666>Job No</td>
  <td class=xl67666 style='border-left:none'>Rework</td>
  <td class=xl63666></td>
  <td class=xl63666></td>
  <td class=xl15666></td>
 </tr>
 <tr height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl63666 style='height:15.0pt'></td>
  <td class=xl63666></td>
  <td colspan=13 rowspan=2 class=xl104666>Production Review</td>
  <td class=xl132666></td>
  <td class=xl133666><u style='visibility:hidden;mso-ignore:visibility'>&nbsp;</u></td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td colspan=3 class=xl106666 style='border-right:.5pt solid black;border-left:
  none'>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl130666 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl63666></td>
  <td class=xl63666></td>
  <td class=xl15666></td>
 </tr>
 <tr height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl63666 style='height:15.0pt'></td>
  <td class=xl63666></td>
  <td class=xl132666></td>
  <td class=xl133666><u style='visibility:hidden;mso-ignore:visibility'>&nbsp;</u></td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td colspan=3 class=xl106666 style='border-right:.5pt solid black;border-left:
  none'>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl130666 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl63666></td>
  <td class=xl63666></td>
  <td class=xl15666></td>
 </tr>
 <tr height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl63666 style='height:15.0pt'></td>
  <td class=xl63666></td>
  <td class=xl63666></td>
  <td class=xl63666></td>
  <td class=xl63666></td>
  <td class=xl63666></td>
  <td class=xl63666></td>
  <td class=xl63666></td>
  <td class=xl63666></td>
  <td class=xl63666></td>
  <td class=xl63666></td>
  <td class=xl63666></td>
  <td class=xl63666></td>
  <td class=xl63666></td>
  <td class=xl63666></td>
  <td class=xl63666></td>
  <td class=xl63666></td>
  <td class=xl72666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td colspan=3 class=xl106666 style='border-right:.5pt solid black;border-left:
  none'>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl130666 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl63666></td>
  <td class=xl63666></td>
  <td class=xl15666></td>
 </tr>
 <tr class=xl73666 height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl73666 style='height:15.0pt'></td>
  <td class=xl73666></td>
  <td class=xl74666>Date:</td>
  <td colspan=2 class=xl108666>&nbsp;</td>
  <td class=xl74666>Style:</td>
  <td colspan=2 class=xl108666><?php echo $style; ?></td>
  <td class=xl74666>Color:</td>
  <td colspan=3 class=xl108666><?php echo $color; ?></td>
  <td class=xl135666></td>
  <td class=xl135666></td>
  <td class=xl135666></td>
  <td class=xl135666></td>
  <td class=xl73666></td>
  <td class=xl75666>&nbsp;</td>
  <td class=xl76666>&nbsp;</td>
  <td class=xl76666>&nbsp;</td>
  <td colspan=3 class=xl106666 style='border-right:.5pt solid black;border-left:
  none'>&nbsp;</td>
  <td class=xl76666>&nbsp;</td>
  <td class=xl131666 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl73666></td>
  <td class=xl73666></td>
  <td class=xl73666></td>
 </tr>
 <tr class=xl73666 height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl73666 style='height:15.0pt'></td>
  <td class=xl73666></td>
  <td class=xl74666>Module:</td>
  <td colspan=2 class=xl109666>&nbsp;</td>
  <td class=xl74666>Schedule:</td>
  <td colspan=2 class=xl109666><?php echo $schedule; ?></td>
  <td class=xl74666>Job No:</td>
  <td colspan=3 class=xl109666><?php echo $cutid.leading_zeros($cut_no,3); ?></td>
  <td class=xl135666></td>
  <td class=xl135666></td>
  <td class=xl135666></td>
  <td class=xl135666></td>
  <td class=xl73666></td>
  <td class=xl75666>&nbsp;</td>
  <td class=xl76666>&nbsp;</td>
  <td class=xl76666>&nbsp;</td>
  <td colspan=3 class=xl106666 style='border-right:.5pt solid black;border-left:
  none'>&nbsp;</td>
  <td class=xl76666>&nbsp;</td>
  <td class=xl131666 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl73666></td>
  <td class=xl73666></td>
  <td class=xl73666></td>
 </tr>
 <tr class=xl73666 height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl73666 style='height:15.0pt'></td>
  <td class=xl73666 align="right" colspan=2>Ex-Factory:</td>
  <td colspan=2 class=xl109666><b><?php echo $order_date; ?></b></td>
  <td class=xl74666>Cut:</td>
  <td colspan=2 class=xl109666><b><?php echo (100+$cut_per+$extra_ship_ord)."%"; ?></b></td>
  <td class=xl74666></td>
  <td colspan=3></td>
  <td class=xl135666></td>
  <td class=xl135666></td>
  <td class=xl135666></td>
  <td class=xl135666></td>
  <td class=xl73666></td>
  <td class=xl75666>&nbsp;</td>
  <td class=xl76666>&nbsp;</td>
  <td class=xl76666>&nbsp;</td>
  <td colspan=3 class=xl106666 style='border-right:.5pt solid black;border-left:
  none'>&nbsp;</td>
  <td class=xl76666>&nbsp;</td>
  <td class=xl131666 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl73666></td>
  <td class=xl73666></td>
  <td class=xl73666></td>
 </tr>
 <tr height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl63666 style='height:15.0pt'></td>
  <td class=xl63666></td>
  <td class=xl63666></td>
  <td class=xl63666></td>
  <td class=xl63666></td>
  <td class=xl63666></td>
  <td class=xl63666></td>
  <td class=xl63666></td>
  <td class=xl63666></td>
  <td class=xl63666></td>
  <td class=xl63666></td>
  <td class=xl63666></td>
  <td class=xl63666></td>
  <td class=xl63666></td>
  <td class=xl63666></td>
  <td class=xl63666></td>
  <td class=xl63666></td>
  <td class=xl72666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td colspan=3 class=xl106666 style='border-right:.5pt solid black;border-left:
  none'>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl130666 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl63666></td>
  <td class=xl63666></td>
  <td class=xl15666></td>
 </tr>
 <tr height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl63666 style='height:15.0pt'></td>
  <td class=xl63666></td>
  <td class=xl69666>XS</td>
  <td class=xl71666>S</td>
  <td class=xl71666>M</td>
  <td class=xl71666>L</td>
  <td class=xl71666>XL</td>
  <td class=xl71666>XXL</td>
  <td class=xl71666>XXXL</td>
  <td class=xl71666>Total</td>
  <td class=xl15666></td>
  <td class=xl15666></td>
  <td class=xl15666></td>
  <td class=xl15666></td>
  <td class=xl15666></td>
  <td class=xl15666></td>
  <td class=xl63666></td>
  <td class=xl72666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td colspan=3 class=xl106666 style='border-right:.5pt solid black;border-left:
  none'>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl130666 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl63666></td>
  <td class=xl63666></td>
  <td class=xl15666></td>
 </tr>
 <tr height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl63666 style='height:15.0pt'></td>
  <td class=xl74666>Cut Qty</td>
  <td class=xl124666><?php echo $a_xs_n; ?></td>
  <td class=xl122666><?php echo $a_s_n; ?></td>
  <td class=xl122666><?php echo $a_m_n; ?></td>
  <td class=xl122666><?php echo $a_l_n; ?></td>
  <td class=xl122666><?php echo $a_xl_n; ?></td>
  <td class=xl122666><?php echo $a_xxl_n; ?></td>
  <td class=xl122666><?php echo $a_xxxl_n; ?></td>
  <td class=xl122666><?php echo $temp_sum_n; ?></td>
  <td class=xl15666></td>
  <td class=xl15666></td>
  <td class=xl15666></td>
  <td class=xl15666></td>
  <td class=xl15666></td>
  <td class=xl15666></td>
  <td class=xl63666></td>
  <td class=xl72666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td colspan=3 class=xl106666 style='border-right:.5pt solid black;border-left:
  none'>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl130666 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl63666></td>
  <td class=xl63666></td>
  <td class=xl15666></td>
 </tr>
 <tr height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl63666 style='height:15.0pt'></td>
  <td class=xl74666>Balance B/F</td>
  <td class=xl125666>&nbsp;</td>
  <td class=xl123666>&nbsp;</td>
  <td class=xl123666>&nbsp;</td>
  <td class=xl123666>&nbsp;</td>
  <td class=xl123666>&nbsp;</td>
  <td class=xl123666>&nbsp;</td>
  <td class=xl123666>&nbsp;</td>
  <td class=xl123666>&nbsp;</td>
  <td class=xl15666></td>
  <td class=xl15666></td>
  <td class=xl15666></td>
  <td class=xl15666></td>
  <td class=xl15666></td>
  <td class=xl15666></td>
  <td class=xl63666></td>
  <td class=xl72666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td colspan=3 class=xl106666 style='border-right:.5pt solid black;border-left:
  none'>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl130666 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl63666></td>
  <td class=xl63666></td>
  <td class=xl15666></td>
 </tr>
 <tr height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl63666 style='height:15.0pt'></td>
  <td class=xl74666>Out Put</td>
  <td class=xl125666>&nbsp;</td>
  <td class=xl123666>&nbsp;</td>
  <td class=xl123666>&nbsp;</td>
  <td class=xl123666>&nbsp;</td>
  <td class=xl123666>&nbsp;</td>
  <td class=xl123666>&nbsp;</td>
  <td class=xl123666>&nbsp;</td>
  <td class=xl123666>&nbsp;</td>
  <td class=xl15666></td>
  <td class=xl15666></td>
  <td class=xl15666></td>
  <td class=xl15666></td>
  <td class=xl15666></td>
  <td class=xl15666></td>
  <td class=xl63666></td>
  <td class=xl72666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td colspan=3 class=xl106666 style='border-right:.5pt solid black;border-left:
  none'>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl130666 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl63666></td>
  <td class=xl63666></td>
  <td class=xl15666></td>
 </tr>
 <tr height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl63666 style='height:15.0pt'></td>
  <td class=xl74666>Balance C/F</td>
  <td class=xl125666>&nbsp;</td>
  <td class=xl123666>&nbsp;</td>
  <td class=xl123666>&nbsp;</td>
  <td class=xl123666>&nbsp;</td>
  <td class=xl123666>&nbsp;</td>
  <td class=xl123666>&nbsp;</td>
  <td class=xl123666>&nbsp;</td>
  <td class=xl123666>&nbsp;</td>
  <td class=xl15666></td>
  <td class=xl15666></td>
  <td class=xl15666></td>
  <td class=xl15666></td>
  <td class=xl15666></td>
  <td class=xl15666></td>
  <td class=xl63666></td>
  <td class=xl72666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td colspan=3 class=xl106666 style='border-right:.5pt solid black;border-left:
  none'>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl130666 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl63666></td>
  <td class=xl63666></td>
  <td class=xl15666></td>
 </tr>
 <tr height=11 style='mso-height-source:userset;height:8.25pt'>
  <td height=11 class=xl63666 style='height:8.25pt'></td>
  <td class=xl73666></td>
  <td class=xl63666></td>
  <td class=xl63666></td>
  <td class=xl63666></td>
  <td class=xl63666></td>
  <td class=xl63666></td>
  <td class=xl63666></td>
  <td class=xl63666></td>
  <td class=xl63666></td>
  <td class=xl63666></td>
  <td class=xl63666></td>
  <td class=xl63666></td>
  <td class=xl63666></td>
  <td class=xl63666></td>
  <td class=xl63666></td>
  <td class=xl63666></td>
  <td class=xl63666></td>
  <td class=xl63666></td>
  <td class=xl63666></td>
  <td class=xl63666></td>
  <td class=xl63666></td>
  <td class=xl63666></td>
  <td class=xl15666></td>
  <td class=xl15666></td>
  <td class=xl15666></td>
  <td class=xl15666></td>
  <td class=xl15666></td>
 </tr>
 <tr height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl63666 style='height:15.0pt'></td>
  <td rowspan=2 class=xl110666 style='border-bottom:1.0pt solid black'>Hour<span
  style='mso-spacerun:yes'> </span></td>
  <td colspan=2 class=xl112666 style='border-right:.5pt solid black;border-left:
  none'>XS</td>
  <td colspan=2 class=xl112666 style='border-right:.5pt solid black;border-left:
  none'>S</td>
  <td colspan=2 class=xl114666 style='border-right:.5pt solid black;border-left:
  none'>M</td>
  <td colspan=2 class=xl114666 style='border-right:.5pt solid black;border-left:
  none'>L</td>
  <td colspan=2 class=xl114666 style='border-right:.5pt solid black;border-left:
  none'>XL</td>
  <td colspan=2 class=xl114666 style='border-right:.5pt solid black;border-left:
  none'>XXL</td>
  <td colspan=2 class=xl114666 style='border-right:.5pt solid black;border-left:
  none'>XXXL</td>
  <td class=xl77666>Quality</td>
  <td class=xl78666>Packing</td>
  <td class=xl77666 style="border-left:1.0pt solid black">Recorder</td>
  <td rowspan=2 class=xl110666 style='border-bottom:1.0pt solid black'>XS</td>
  <td class=xl128666>&nbsp;</td>
  <td rowspan=2 class=xl115666 style='border-bottom:1.0pt solid black'>M</td>
  <td rowspan=2 class=xl115666 style='border-bottom:1.0pt solid black'>L</td>
  <td rowspan=2 class=xl115666 style='border-bottom:1.0pt solid black'>XL</td>
  <td rowspan=2 class=xl115666 style='border-bottom:1.0pt solid black'>Total</td>
  <td rowspan=2 class=xl117666 style='border-bottom:1.0pt solid black'>Rework</td>
  <td rowspan=2 class=xl119666 style='border-bottom:1.0pt solid black'>Rejection</td>
  <td rowspan=2 colspan="2" class=xl117666 style='border-bottom:1.0pt solid black'>Surplus</td>
 </tr>
 <tr height=21 style='mso-height-source:userset;height:15.75pt'>
  <td height=21 class=xl63666 style='height:15.75pt'></td>
  <td class=xl79666>Out</td>
  <td class=xl79666>Cum Out</td>
  <td class=xl79666>Out</td>
  <td class=xl79666>Cum Out</td>
  <td class=xl79666>Out</td>
  <td class=xl79666>Cum Out</td>
  <td class=xl79666>Out</td>
  <td class=xl79666>Cum Out</td>
  <td class=xl79666>Out</td>
  <td class=xl79666>Cum Out</td>
  <td class=xl79666>Out</td>
  <td class=xl79666>Cum Out</td>
  <td class=xl79666>Out</td>
  <td class=xl79666>Cum Out</td>
  <td class=xl79666>Sign</td>
  <td class=xl80666>Sign</td>
  <td class=xl80666 style="border-left:1.0pt solid black">Sign</td>
  <td class=xl129666>S</td>
  <td class=xl15666></td>
 </tr>
 <tr height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl63666 style='height:15.0pt'></td>
  <td class=xl81666>6 am - 7 am</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl82666>&nbsp;</td>
  <td class=xl83666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl84666>&nbsp;</td>
  <td class=xl85666>&nbsp;</td>
  <td class=xl85666>&nbsp;</td>
  <td class=xl85666 colspan="2">&nbsp;</td>
  <td class=xl15666></td>
 </tr>
 <tr height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl63666 style='height:15.0pt'></td>
  <td class=xl81666>7 am - 8 am</td>
  <td class=xl76666>&nbsp;</td>
  <td class=xl76666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl82666>&nbsp;</td>
  <td class=xl83666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl84666>&nbsp;</td>
  <td class=xl85666>&nbsp;</td>
  <td class=xl85666>&nbsp;</td>
   <td class=xl85666 colspan="2">&nbsp;</td>
  <td class=xl15666></td>
 </tr>
 <tr height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl63666 style='height:15.0pt'></td>
  <td class=xl81666>8 am - 9 am</td>
  <td class=xl76666>&nbsp;</td>
  <td class=xl76666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl82666>&nbsp;</td>
  <td class=xl83666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl84666>&nbsp;</td>
  <td class=xl85666>&nbsp;</td>
  <td class=xl85666>&nbsp;</td>
  <td class=xl85666 colspan="2">&nbsp;</td>
  <td class=xl15666></td>
 </tr>
 <tr height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl63666 style='height:15.0pt'></td>
  <td class=xl81666>9 am - 10 am</td>
  <td class=xl76666>&nbsp;</td>
  <td class=xl76666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl82666>&nbsp;</td>
  <td class=xl83666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl84666>&nbsp;</td>
  <td class=xl85666>&nbsp;</td>
  <td class=xl85666>&nbsp;</td>
   <td class=xl85666 colspan="2">&nbsp;</td>
  <td class=xl15666></td>
 </tr>
 <tr height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl63666 style='height:15.0pt'></td>
  <td class=xl81666>10 am - 11 am</td>
  <td class=xl76666>&nbsp;</td>
  <td class=xl76666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl82666>&nbsp;</td>
  <td class=xl83666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl84666>&nbsp;</td>
  <td class=xl85666>&nbsp;</td>
  <td class=xl85666>&nbsp;</td>
   <td class=xl85666 colspan="2">&nbsp;</td>
  <td class=xl15666></td>
 </tr>
 <tr height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl63666 style='height:15.0pt'></td>
  <td class=xl81666>11 am - 12 pm</td>
  <td class=xl76666>&nbsp;</td>
  <td class=xl76666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl82666>&nbsp;</td>
  <td class=xl83666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl84666>&nbsp;</td>
  <td class=xl85666>&nbsp;</td>
  <td class=xl85666>&nbsp;</td>
   <td class=xl85666 colspan="2">&nbsp;</td>
  <td class=xl15666></td>
 </tr>
 <tr height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl63666 style='height:15.0pt'></td>
  <td class=xl81666>12 pm - 1 pm</td>
  <td class=xl76666>&nbsp;</td>
  <td class=xl76666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl82666>&nbsp;</td>
  <td class=xl83666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl84666>&nbsp;</td>
  <td class=xl85666>&nbsp;</td>
  <td class=xl85666>&nbsp;</td>
   <td class=xl85666 colspan="2">&nbsp;</td>
  <td class=xl15666></td>
 </tr>
 <tr height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl63666 style='height:15.0pt'></td>
  <td class=xl81666>1 pm - 2 pm</td>
  <td class=xl76666>&nbsp;</td>
  <td class=xl76666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl82666>&nbsp;</td>
  <td class=xl83666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl84666>&nbsp;</td>
  <td class=xl85666>&nbsp;</td>
  <td class=xl85666>&nbsp;</td>
   <td class=xl85666 colspan="2">&nbsp;</td>
  <td class=xl15666></td>
 </tr>
 <tr height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl63666 style='height:15.0pt'></td>
  <td class=xl81666>2 pm - 3 pm</td>
  <td class=xl76666>&nbsp;</td>
  <td class=xl76666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl82666>&nbsp;</td>
  <td class=xl83666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl84666>&nbsp;</td>
  <td class=xl85666>&nbsp;</td>
  <td class=xl85666>&nbsp;</td>
   <td class=xl85666 colspan="2">&nbsp;</td>
  <td class=xl15666></td>
 </tr>
 <tr height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl63666 style='height:15.0pt'></td>
  <td class=xl81666>3 pm - 4 pm</td>
  <td class=xl76666>&nbsp;</td>
  <td class=xl76666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl82666>&nbsp;</td>
  <td class=xl83666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl84666>&nbsp;</td>
  <td class=xl85666>&nbsp;</td>
  <td class=xl85666>&nbsp;</td>
   <td class=xl85666 colspan="2">&nbsp;</td>
  <td class=xl15666></td>
 </tr>
 <tr height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl63666 style='height:15.0pt'></td>
  <td class=xl81666>4 pm - 5 pm</td>
  <td class=xl76666>&nbsp;</td>
  <td class=xl76666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl82666>&nbsp;</td>
  <td class=xl83666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl84666>&nbsp;</td>
  <td class=xl85666>&nbsp;</td>
  <td class=xl85666>&nbsp;</td>
   <td class=xl85666 colspan="2">&nbsp;</td>
  <td class=xl15666></td>
 </tr>
 <tr height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl63666 style='height:15.0pt'></td>
  <td class=xl81666>5 pm - 6 pm</td>
  <td class=xl76666>&nbsp;</td>
  <td class=xl76666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl82666>&nbsp;</td>
  <td class=xl83666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl84666>&nbsp;</td>
  <td class=xl85666>&nbsp;</td>
  <td class=xl85666>&nbsp;</td>
   <td class=xl85666 colspan="2">&nbsp;</td>
  <td class=xl15666></td>
 </tr>
 <tr height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl63666 style='height:15.0pt'></td>
  <td class=xl81666>6 pm - 7 pm</td>
  <td class=xl76666>&nbsp;</td>
  <td class=xl76666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl82666>&nbsp;</td>
  <td class=xl83666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl84666>&nbsp;</td>
  <td class=xl85666>&nbsp;</td>
  <td class=xl85666>&nbsp;</td>
   <td class=xl85666 colspan="2">&nbsp;</td>
  <td class=xl15666></td>
 </tr>
 <tr height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl63666 style='height:15.0pt'></td>
  <td class=xl81666>7 pm - 8 pm</td>
  <td class=xl76666>&nbsp;</td>
  <td class=xl76666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl82666>&nbsp;</td>
  <td class=xl83666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl84666>&nbsp;</td>
  <td class=xl85666>&nbsp;</td>
  <td class=xl85666>&nbsp;</td>
   <td class=xl85666 colspan="2">&nbsp;</td>
  <td class=xl15666></td>
 </tr>
 <tr height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl63666 style='height:15.0pt'></td>
  <td class=xl81666>8 pm - 9 pm</td>
  <td class=xl76666>&nbsp;</td>
  <td class=xl76666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl82666>&nbsp;</td>
  <td class=xl83666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl84666>&nbsp;</td>
  <td class=xl85666>&nbsp;</td>
  <td class=xl85666>&nbsp;</td>
   <td class=xl85666 colspan="2">&nbsp;</td>
  <td class=xl15666></td>
 </tr>
 <tr height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl63666 style='height:15.0pt'></td>
  <td class=xl81666>9 pm - 10 pm</td>
  <td class=xl76666>&nbsp;</td>
  <td class=xl76666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl82666>&nbsp;</td>
  <td class=xl83666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl70666>&nbsp;</td>
  <td class=xl84666>&nbsp;</td>
  <td class=xl85666>&nbsp;</td>
  <td class=xl85666>&nbsp;</td>
   <td class=xl85666 colspan="2">&nbsp;</td>
  <td class=xl15666></td>
 </tr>
 <tr height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl63666 style='height:15.0pt'></td>
  <td class=xl86666>Balance Output</td>
  <td class=xl126666>&nbsp;</td>
  <td class=xl126666>&nbsp;</td>
  <td class=xl87666>&nbsp;</td>
  <td class=xl87666>&nbsp;</td>
  <td class=xl87666>&nbsp;</td>
  <td class=xl87666>&nbsp;</td>
  <td class=xl87666>&nbsp;</td>
  <td class=xl87666>&nbsp;</td>
  <td class=xl87666>&nbsp;</td>
  <td class=xl87666>&nbsp;</td>
  <td class=xl87666>&nbsp;</td>
  <td class=xl87666>&nbsp;</td>
  <td class=xl87666>&nbsp;</td>
  <td class=xl87666>&nbsp;</td>
  <td class=xl87666>&nbsp;</td>
  <td class=xl88666>&nbsp;</td>
  <td class=xl89666>&nbsp;</td>
  <td class=xl87666>&nbsp;</td>
  <td class=xl87666>&nbsp;</td>
  <td class=xl87666>&nbsp;</td>
  <td class=xl87666>&nbsp;</td>
  <td class=xl87666>&nbsp;</td>
  <td class=xl90666>&nbsp;</td>
  <td class=xl91666>&nbsp;</td>
  <td class=xl91666>&nbsp;</td>
   <td class=xl91666 colspan="2">&nbsp;</td>
  <td class=xl15666></td>
 </tr>
 <tr height=21 style='mso-height-source:userset;height:15.75pt'>
  <td height=21 class=xl63666 style='height:15.75pt'></td>
  <td class=xl92666>Total</td>
  <td class=xl127666>&nbsp;</td>
  <td class=xl127666>&nbsp;</td>
  <td class=xl93666>&nbsp;</td>
  <td class=xl93666>&nbsp;</td>
  <td class=xl93666>&nbsp;</td>
  <td class=xl93666>&nbsp;</td>
  <td class=xl93666>&nbsp;</td>
  <td class=xl93666>&nbsp;</td>
  <td class=xl93666>&nbsp;</td>
  <td class=xl93666>&nbsp;</td>
  <td class=xl93666>&nbsp;</td>
  <td class=xl93666>&nbsp;</td>
  <td class=xl93666>&nbsp;</td>
  <td class=xl93666>&nbsp;</td>
  <td class=xl93666>&nbsp;</td>
  <td class=xl94666>&nbsp;</td>
  <td class=xl95666>&nbsp;</td>
  <td class=xl93666>&nbsp;</td>
  <td class=xl93666>&nbsp;</td>
  <td class=xl93666>&nbsp;</td>
  <td class=xl93666>&nbsp;</td>
  <td class=xl93666>&nbsp;</td>
  <td class=xl96666>&nbsp;</td>
  <td class=xl97666>&nbsp;</td>
  <td class=xl97666>&nbsp;</td>
   <td class=xl97666 colspan="2">&nbsp;</td>
  <td class=xl15666></td>
 </tr>
 <tr height=30 style='mso-height-source:userset;height:22.5pt'>
  <td height=30 class=xl63666 style='height:22.5pt'></td>
  <td class=xl63666></td>
  <td class=xl63666></td>
  <td class=xl63666></td>
  <td class=xl63666></td>
  <td class=xl63666></td>
  <td class=xl63666></td>
  <td class=xl63666></td>
  <td class=xl63666></td>
  <td class=xl82666>&nbsp;</td>
  <td class=xl82666>&nbsp;</td>
  <td class=xl63666></td>
  <td class=xl63666></td>
  <td class=xl82666>&nbsp;</td>
  <td class=xl82666>&nbsp;</td>
  <td class=xl63666></td>
  <td class=xl63666></td>
  <td class=xl63666>&nbsp;</td>
  <td class=xl63666>&nbsp;</td>
  <td class=xl63666>&nbsp;</td>
  <td class=xl63666></td>
  <td class=xl63666></td>
  <td class=xl63666></td>
  <td class=xl15666></td>
  <td class=xl15666></td>
  <td class=xl15666></td>
  <td class=xl15666></td>
  <td class=xl15666></td>
 </tr>
 <tr class=xl73666 height=16 style='mso-height-source:userset;height:12.0pt'>
  <td height=16 class=xl73666 style='height:12.0pt'></td>
  <td class=xl73666></td>
  <td colspan=2></td>
  <td class=xl98666></td>
  <td colspan=2 class=xl121666>Section QA/Exe</td>
  <td class=xl98666></td>
  <td class=xl98666></td>
  <td colspan=2 class=xl121666>Packing Sup. </td>
  <td class=xl98666></td>
  <td class=xl98666></td>
  <td colspan=2 class=xl121666>Shift Exe.</td>
  <td class=xl98666></td>
  <td class=xl98666></td>
  <td colspan=3></td>
  <td class=xl73666></td>
  <td class=xl73666></td>
  <td class=xl73666><!-----------------------------><!--END OF OUTPUT FROM EXCEL PUBLISH AS WEB PAGE WIZARD--><!-----------------------------></td>
  <td class=xl73666></td>
  <td class=xl73666></td>
  <td class=xl73666></td>
  <td class=xl73666></td>
  <td class=xl73666></td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl15666 style='height:15.0pt'></td>
  <td class=xl15666></td>
  <td class=xl15666></td>
  <td class=xl15666></td>
  <td class=xl15666></td>
  <td class=xl15666></td>
  <td class=xl15666></td>
  <td class=xl15666></td>
  <td class=xl15666></td>
  <td class=xl15666></td>
  <td class=xl15666></td>
  <td class=xl15666></td>
  <td class=xl15666></td>
  <td class=xl15666></td>
  <td class=xl15666></td>
  <td class=xl15666></td>
  <td class=xl15666></td>
  <td class=xl15666></td>
  <td class=xl15666></td>
  <td class=xl15666></td>
  <td class=xl15666></td>
  <td class=xl15666></td>
  <td class=xl15666></td>
  <td class=xl15666></td>
  <td class=xl15666></td>
  <td class=xl15666></td>
  <td class=xl136666 colspan=2>Version: 1.0</td>
 </tr>
 <![if supportMisalignedColumns]>
 <tr height=0 style='display:none'>
  <td width=5 style='width:4pt'></td>
  <td width=108 style='width:81pt'></td>
  <td width=55 style='width:41pt'></td>
  <td width=55 style='width:41pt'></td>
  <td width=55 style='width:41pt'></td>
  <td width=55 style='width:41pt'></td>
  <td width=55 style='width:41pt'></td>
  <td width=55 style='width:41pt'></td>
  <td width=55 style='width:41pt'></td>
  <td width=55 style='width:41pt'></td>
  <td width=55 style='width:41pt'></td>
  <td width=55 style='width:41pt'></td>
  <td width=55 style='width:41pt'></td>
  <td width=55 style='width:41pt'></td>
  <td width=53 style='width:40pt'></td>
  <td width=48 style='width:36pt'></td>
  <td width=44 style='width:33pt'></td>
  <td width=49 style='width:37pt'></td>
  <td width=60 style='width:45pt'></td>
  <td width=60 style='width:45pt'></td>
  <td width=60 style='width:45pt'></td>
  <td width=60 style='width:45pt'></td>
  <td width=60 style='width:45pt'></td>
  <td width=60 style='width:45pt'></td>
  <td width=60 style='width:45pt'></td>
  <td width=64 style='width:48pt'></td>
  <td width=64 style='width:48pt'></td>
  <td width=23 style='width:17pt'></td>
 </tr>
 <![endif]>
</table>

</div>


<!----------------------------->
<!--END OF OUTPUT FROM EXCEL PUBLISH AS WEB PAGE WIZARD-->
<!----------------------------->
</body>

</html>
