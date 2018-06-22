<?php 

//Ticket #419256 - KiranG 2013-05-06 : Rework, Rejection, Surplus columns are added to this sheet. Also global level enable and disable option given to show total cut quantity on review sheet (for total input reporting to module).

//CR# 221 - KiranG / 20141105: Revised calculation on Embellishment values.

//CR# 436 - kirang/ Task:Need to show carton level details as per the Kanban requirement and no. of bundles in each carton qty of each size.
function isNumber($c) {
    return preg_match('/[0-9]/', $c);
}

function check_style($string)
{
	$check=0;
	for ($index=0;$index<strlen($string);$index++) {
    	if(isNumber($string[$index]))
		{
			$nums .= $string[$index];
		}
     	else    
		{
			$chars .= $string[$index];
			$check=$check+1;
			if($check==2)
			{
				break;
			}
		}
       		
			
	}
	//echo "Chars: -$chars-<br>Nums: -$nums-";
	return $nums;
}

//include("../dbconf.php"); 
//$input_excess_cut_as_full_input=0;
?>
<?php include("../../../../common/php/functions.php"); 
include("../../../../common/config/config.php"); 
?>

<?php
$order_tid=$_GET['order_tid'];
$user="Admin";
$doc_no=$_GET['doc_no'];
$cut_no=$_GET['cut_no'];



$sql1="select * from $bai_pro3.cat_stat_log where order_tid=\"$order_tid\" and category in ($in_categories) and purwidth>0";
//echo $sql1."<br>";
mysqli_query($link, $sql1) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row1=mysqli_fetch_array($sql_result1))
{
	$CID=$sql_row1['tid'];
}

//echo "cid =".$CID;
//NEW

$sqlc="SELECT cuttable_percent as cutper from $bai_pro3.cuttable_stat_log where cat_id=$CID";
$sql_resultc=mysqli_query($link, $sqlc) or exit("Sql Error4".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_rowc=mysqli_fetch_array($sql_resultc))
{
	$cut_per=$sql_rowc['cutper'];
}
$sql="select sum(allocate_xs*plies) as \"cuttable_s_xs\", sum(allocate_s*plies) as \"cuttable_s_s\", sum(allocate_m*plies) as \"cuttable_s_m\", sum(allocate_l*plies) as \"cuttable_s_l\", sum(allocate_xl*plies) as \"cuttable_s_xl\", sum(allocate_xxl*plies) as \"cuttable_s_xxl\", sum(allocate_xxxl*plies) as \"cuttable_s_xxxl\" from $bai_pro3.allocate_stat_log where order_tid=\"$order_tid\" and cat_ref=$CID";
//echo $sql."<br>";
mysqli_query($link, $sql) or exit("Sql Error3".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_result=mysqli_query($link, $sql) or exit("Sql Error4".mysqli_error($GLOBALS["___mysqli_ston"]));
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
$sql_result=mysqli_query($link, $sql) or exit("Sql Error5".mysqli_error($GLOBALS["___mysqli_ston"]));
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
$sql_result=mysqli_query($link, $sql) or exit("Sql Error6".mysqli_error($GLOBALS["___mysqli_ston"]));
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
	
	$total_ord=$sql_row["old_order_s_xs"]+$sql_row["old_order_s_s"]+$sql_row["old_order_s_m"]+$sql_row["old_order_s_l"]+$sql_row["old_order_s_xl"]+$sql_row["old_order_s_xxl"]+$sql_row["old_order_s_xxxl"]+$sql_row["old_order_s_s01"]+$sql_row["old_order_s_s02"]+$sql_row["old_order_s_s03"]+$sql_row["old_order_s_s04"]+$sql_row["old_order_s_s05"]+$sql_row["old_order_s_s06"]+$sql_row["old_order_s_s07"]+$sql_row["old_order_s_s08"]+$sql_row["old_order_s_s09"]+$sql_row["old_order_s_s10"]+$sql_row["old_order_s_s11"]+$sql_row["old_order_s_s12"]+$sql_row["old_order_s_s13"]+$sql_row["old_order_s_s14"]+$sql_row["old_order_s_s15"]+$sql_row["old_order_s_s16"]+$sql_row["old_order_s_s17"]+$sql_row["old_order_s_s18"]+$sql_row["old_order_s_s19"]+$sql_row["old_order_s_s20"]+$sql_row["old_order_s_s21"]+$sql_row["old_order_s_s22"]+$sql_row["old_order_s_s23"]+$sql_row["old_order_s_s24"]+$sql_row["old_order_s_s25"]+$sql_row["old_order_s_s26"]+$sql_row["old_order_s_s27"]+$sql_row["old_order_s_s28"]+$sql_row["old_order_s_s29"]+$sql_row["old_order_s_s30"]+$sql_row["old_order_s_s31"]+$sql_row["old_order_s_s32"]+$sql_row["old_order_s_s33"]+$sql_row["old_order_s_s34"]+$sql_row["old_order_s_s35"]+$sql_row["old_order_s_s36"]+$sql_row["old_order_s_s37"]+$sql_row["old_order_s_s38"]+$sql_row["old_order_s_s39"]+$sql_row["old_order_s_s40"]+$sql_row["old_order_s_s41"]+$sql_row["old_order_s_s42"]+$sql_row["old_order_s_s43"]+$sql_row["old_order_s_s44"]+$sql_row["old_order_s_s45"]+$sql_row["old_order_s_s46"]+$sql_row["old_order_s_s47"]+$sql_row["old_order_s_s48"]+$sql_row["old_order_s_s49"]+$sql_row["old_order_s_s50"];
	
	$total_qty_ord=$sql_row["order_s_xs"]+$sql_row["order_s_s"]+$sql_row["order_s_m"]+$sql_row["order_s_l"]+$sql_row["order_s_xl"]+$sql_row["order_s_xxl"]+$sql_row["order_s_xxxl"]+$sql_row["order_s_s01"]+$sql_row["order_s_s02"]+$sql_row["order_s_s03"]+$sql_row["order_s_s04"]+$sql_row["order_s_s05"]+$sql_row["order_s_s06"]+$sql_row["order_s_s07"]+$sql_row["order_s_s08"]+$sql_row["order_s_s09"]+$sql_row["order_s_s10"]+$sql_row["order_s_s11"]+$sql_row["order_s_s12"]+$sql_row["order_s_s13"]+$sql_row["order_s_s14"]+$sql_row["order_s_s15"]+$sql_row["order_s_s16"]+$sql_row["order_s_s17"]+$sql_row["order_s_s18"]+$sql_row["order_s_s19"]+$sql_row["order_s_s20"]+$sql_row["order_s_s21"]+$sql_row["order_s_s22"]+$sql_row["order_s_s23"]+$sql_row["order_s_s24"]+$sql_row["order_s_s25"]+$sql_row["order_s_s26"]+$sql_row["order_s_s27"]+$sql_row["order_s_s28"]+$sql_row["order_s_s29"]+$sql_row["order_s_s30"]+$sql_row["order_s_s31"]+$sql_row["order_s_s32"]+$sql_row["order_s_s33"]+$sql_row["order_s_s34"]+$sql_row["order_s_s35"]+$sql_row["order_s_s36"]+$sql_row["order_s_s37"]+$sql_row["order_s_s38"]+$sql_row["order_s_s39"]+$sql_row["order_s_s40"]+$sql_row["order_s_s41"]+$sql_row["order_s_s42"]+$sql_row["order_s_s43"]+$sql_row["order_s_s44"]+$sql_row["order_s_s45"]+$sql_row["order_s_s46"]+$sql_row["order_s_s47"]+$sql_row["order_s_s48"]+$sql_row["order_s_s49"]+$sql_row["order_s_s50"];
	
	$extra_ship_ord=round(($total_qty_ord-$total_ord)*100/$total_ord,0);
	
	$order_date=$sql_row["order_date"];
}

//changed code for emblishment.Taken emblishment from bai_orders_db_confirm.

$sql="select order_embl_a,order_embl_b,order_embl_c,order_embl_d,order_embl_e,order_embl_f from $bai_pro3.bai_orders_db where order_tid=\"$order_tid\"";
//$sql="select order_embl_a,order_embl_b,order_embl_c,order_embl_d,order_embl_e,order_embl_f from bai_orders_db_confirm where order_tid=\"$order_tid\"";
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error7".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		$emb_a=$sql_row['order_embl_a'];
		$emb_b=$sql_row['order_embl_b'];
		$emb_c=$sql_row['order_embl_c'];
		$emb_d=$sql_row['order_embl_d'];
		$emb_e=$sql_row['order_embl_e'];
		$emb_f=$sql_row['order_embl_f'];
	}
	if(($emb_a+$emb_b+$emb_c+$emb_d+$emb_e+$emb_f)>0)
	{
	$input_excess_cut_as_full_input=0;
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
	$add_title="";
	$p_plies=0;	
	
$sql="select * from $bai_pro3.plandoc_stat_log where order_tid=\"$order_tid\" and cat_ref=$CID and remarks=\"Pilot\" and doc_no=$doc_no order by acutno";
mysqli_query($link, $sql) or exit("Sql Error8".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_result=mysqli_query($link, $sql) or exit("Sql Erro8r".mysqli_error($GLOBALS["___mysqli_ston"]));
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
	$remarks=$sql_row['remarks'];
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
	
	$a_xs_n=$sql_row['a_xs']*$plies;
	$a_s_n=$sql_row['a_s']*$plies;
	$a_m_n=$sql_row['a_m']*$plies;
	$a_l_n=$sql_row['a_l']*$plies;
	$a_xl_n=$sql_row['a_xl']*$plies;
	$a_xxl_n=$sql_row['a_xxl']*$plies;
	$a_xxxl_n=$sql_row['a_xxxl']*$plies;
	$temp_sum_n=$a_xs_n+$a_s_n+$a_m_n+$a_l_n+$a_xl_n+$a_xxl_n+$a_xxxl_n;

	$add_title=" (Pilot)";
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
//echo "<br/>".$sql;
mysqli_query($link, $sql) or exit("Sql Error9".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_result=mysqli_query($link, $sql) or exit("Sql Error9".mysqli_error($GLOBALS["___mysqli_ston"]));
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
		
		if(($emb_a+$emb_b+$emb_c+$emb_d+$emb_e+$emb_f)>0) // Embllishment - Only Garment Form
		{
			$ex_xs=round(($c_xs-$o_xs)/2);
			$ex_s=round(($c_s-$o_s)/2);
			$ex_m=round(($c_m-$o_m)/2);
			$ex_l=round(($c_l-$o_l)/2);
			$ex_xl=round(($c_xl-$o_xl)/2);
			$ex_xxl=round(($c_xxl-$o_xxl)/2);
	    	$ex_xxxl=round(($c_xxxl-$o_xxxl)/2);
		}




  $temp_sum=0;
  if($cutno==$cut_no)
  {
  	$p_plies=$plies;
  }
   
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
			
			if(($emb_a+$emb_b+$emb_c+$emb_d+$emb_e+$emb_f)>0 and $cutno==$first_cut_new) // Embllishment - Only Garment Form
			{
				$ex_xs=(int)(($c_xs-$o_xs)/2);
				$ex_s=(int)(($c_s-$o_s)/2);
				$ex_m=(int)(($c_m-$o_m)/2);
				$ex_l=(int)(($c_l-$o_l)/2);
				$ex_xl=(int)(($c_xl-$o_xl)/2);
				$ex_xxl=(int)(($c_xxl-$o_xxl)/2);
		    	$ex_xxxl=(int)(($c_xxxl-$o_xxxl)/2);
				
			}
			
		}
 
  $temp_sum=0;
  if($cutno==$cut_no)
  {
  	  $p_plies=$plies;
  }

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
mysqli_query($link, $sql) or exit("Sql Error10".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_result=mysqli_query($link, $sql) or exit("Sql Error10".mysqli_error($GLOBALS["___mysqli_ston"]));
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
mysqli_query($link, $sql) or exit("Sql Error11".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_result=mysqli_query($link, $sql) or exit("Sql Error11".mysqli_error($GLOBALS["___mysqli_ston"]));
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

/*
echo "<br/>first letter of style".substr($style,0,1);
echo "<br/>style".$style;

echo "<br/>style".check_style($style);
*/

$first_letter_of_style=substr($style,0,1);
$style_no=check_style($style);

//echo "<br/>first_letter_of_style".$first_letter_of_style;
//echo "<br/> style_no".$style_no;

$sql_style_details="SELECT * FROM $bai_pro3.carton_qty_chart where user_style='".$style_no."' and buyer_identity='".$first_letter_of_style."'";

$sql_result_style_details=mysqli_query($link, $sql_style_details) or exit("<br/> Style details error".$sql_style_details.mysqli_error($GLOBALS["___mysqli_ston"]));

while($sql_row_style=mysqli_fetch_array($sql_result_style_details))
{
	$carton_xs=$sql_row_style['xs'];
	$carton_s=$sql_row_style['s'];
	$carton_m=$sql_row_style['m'];
	$carton_l=$sql_row_style['l'];
	$carton_xl=$sql_row_style['xl'];
	$carton_xxl=$sql_row_style['xxl'];
	$carton_xxxl=$sql_row_style['xxxl'];
	
	$carton_s01=$sql_row_style['s01'];
$carton_s02=$sql_row_style['s02'];
$carton_s03=$sql_row_style['s03'];
$carton_s04=$sql_row_style['s04'];
$carton_s05=$sql_row_style['s05'];
$carton_s06=$sql_row_style['s06'];
$carton_s07=$sql_row_style['s07'];
$carton_s08=$sql_row_style['s08'];
$carton_s09=$sql_row_style['s09'];
$carton_s10=$sql_row_style['s10'];
$carton_s11=$sql_row_style['s11'];
$carton_s12=$sql_row_style['s12'];
$carton_s13=$sql_row_style['s13'];
$carton_s14=$sql_row_style['s14'];
$carton_s15=$sql_row_style['s15'];
$carton_s16=$sql_row_style['s16'];
$carton_s17=$sql_row_style['s17'];
$carton_s18=$sql_row_style['s18'];
$carton_s19=$sql_row_style['s19'];
$carton_s20=$sql_row_style['s20'];
$carton_s21=$sql_row_style['s21'];
$carton_s22=$sql_row_style['s22'];
$carton_s23=$sql_row_style['s23'];
$carton_s24=$sql_row_style['s24'];
$carton_s25=$sql_row_style['s25'];
$carton_s26=$sql_row_style['s26'];
$carton_s27=$sql_row_style['s27'];
$carton_s28=$sql_row_style['s28'];
$carton_s29=$sql_row_style['s29'];
$carton_s30=$sql_row_style['s30'];
$carton_s31=$sql_row_style['s31'];
$carton_s32=$sql_row_style['s32'];
$carton_s33=$sql_row_style['s33'];
$carton_s34=$sql_row_style['s34'];
$carton_s35=$sql_row_style['s35'];
$carton_s36=$sql_row_style['s36'];
$carton_s37=$sql_row_style['s37'];
$carton_s38=$sql_row_style['s38'];
$carton_s39=$sql_row_style['s39'];
$carton_s40=$sql_row_style['s40'];
$carton_s41=$sql_row_style['s41'];
$carton_s42=$sql_row_style['s42'];
$carton_s43=$sql_row_style['s43'];
$carton_s44=$sql_row_style['s44'];
$carton_s45=$sql_row_style['s45'];
$carton_s46=$sql_row_style['s46'];
$carton_s47=$sql_row_style['s47'];
$carton_s48=$sql_row_style['s48'];
$carton_s49=$sql_row_style['s49'];
$carton_s50=$sql_row_style['s50'];


}


?>


<html xmlns:v="urn:schemas-microsoft-com:vml"
xmlns:o="urn:schemas-microsoft-com:office:office"
xmlns:x="urn:schemas-microsoft-com:office:excel"
xmlns="http://www.w3.org/TR/REC-html40">

<head>
<meta http-equiv=Content-Type content="text/html; charset=windows-1252">
<meta name=ProgId content=Excel.Sheet>
<meta name=Generator content="Microsoft Excel 12">
<link rel=File-List href="Print_doc3_files/filelist.xml">
<!--[if !mso]>
<style>
v\:* {behavior:url(#default#VML);}
o\:* {behavior:url(#default#VML);}
x\:* {behavior:url(#default#VML);}
.shape {behavior:url(#default#VML);}
</style>
<![endif]-->
<style id="Book7_7179_Styles">
<!--table
	{mso-displayed-decimal-separator:"\.";
	mso-displayed-thousand-separator:"\,";}
.xl157179
	{padding:0px;
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
.xl757179
	{padding:0px;
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
.xl767179
	{padding:0px;
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
.xl777179
	{padding:0px;
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
.xl787179
	{padding:0px;
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
.xl797179
	{padding:0px;
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
.xl807179
	{padding:0px;
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
.xl817179
	{padding:0px;
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
.xl827179
	{padding:0px;
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
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl837179
	{padding:0px;
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
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl847179
	{padding:0px;
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
	border-bottom:1.0pt solid windowtext;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl857179
	{padding:0px;
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
	border-bottom:1.0pt solid windowtext;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl867179
	{padding:0px;
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
.xl877179
	{padding:0px;
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
.xl887179
	{padding:0px;
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
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl897179
	{padding:0px;
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
.xl907179
	{padding:0px;
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
.xl917179
	{padding:0px;
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
	border-top:.5pt solid windowtext;
	border-right:.5pt solid windowtext;
	border-bottom:.5pt solid windowtext;
	border-left:1.0pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl927179
	{padding:0px;
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
	border-bottom:.5pt solid windowtext;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl937179
	{padding:0px;
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
	border-left:1.0pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl947179
	{padding:0px;
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
	border-right:1.0pt solid windowtext;
	border-bottom:.5pt solid windowtext;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl957179
	{padding:0px;
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
	border-top:.5pt solid windowtext;
	border-right:.5pt solid windowtext;
	border-bottom:.5pt solid windowtext;
	border-left:1.0pt solid windowtext;
	background:#D8D8D8;
	mso-pattern:black none;
	white-space:nowrap;}
.xl967179
	{padding:0px;
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
	background:#D8D8D8;
	mso-pattern:black none;
	white-space:nowrap;}
.xl977179
	{padding:0px;
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
	border-bottom:.5pt solid windowtext;
	border-left:.5pt solid windowtext;
	background:#D8D8D8;
	mso-pattern:black none;
	white-space:nowrap;}
.xl987179
	{padding:0px;
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
	border-left:1.0pt solid windowtext;
	background:#D8D8D8;
	mso-pattern:black none;
	white-space:nowrap;}
.xl997179
	{padding:0px;
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
	border-right:1.0pt solid windowtext;
	border-bottom:.5pt solid windowtext;
	border-left:.5pt solid windowtext;
	background:#D8D8D8;
	mso-pattern:black none;
	white-space:nowrap;}
.xl1007179
	{padding:0px;
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
	border-top:.5pt solid windowtext;
	border-right:.5pt solid windowtext;
	border-bottom:.5pt solid windowtext;
	border-left:1.0pt solid windowtext;
	background:#BFBFBF;
	mso-pattern:black none;
	white-space:nowrap;}
.xl1017179
	{padding:0px;
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
	background:#BFBFBF;
	mso-pattern:black none;
	white-space:nowrap;}
.xl1027179
	{padding:0px;
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
	border-bottom:.5pt solid windowtext;
	border-left:.5pt solid windowtext;
	background:#BFBFBF;
	mso-pattern:black none;
	white-space:nowrap;}
.xl1037179
	{padding:0px;
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
	border-left:1.0pt solid windowtext;
	background:#BFBFBF;
	mso-pattern:black none;
	white-space:nowrap;}
.xl1047179
	{padding:0px;
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
	border-right:1.0pt solid windowtext;
	border-bottom:.5pt solid windowtext;
	border-left:.5pt solid windowtext;
	background:#BFBFBF;
	mso-pattern:black none;
	white-space:nowrap;}
.xl1057179
	{padding:0px;
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
	border-top:.5pt solid windowtext;
	border-right:.5pt solid windowtext;
	border-bottom:1.0pt solid windowtext;
	border-left:1.0pt solid windowtext;
	background:#BFBFBF;
	mso-pattern:black none;
	white-space:nowrap;}
.xl1067179
	{padding:0px;
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
	border-bottom:1.0pt solid windowtext;
	border-left:.5pt solid windowtext;
	background:#BFBFBF;
	mso-pattern:black none;
	white-space:nowrap;}
.xl1077179
	{padding:0px;
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
	border-bottom:1.0pt solid windowtext;
	border-left:.5pt solid windowtext;
	background:#BFBFBF;
	mso-pattern:black none;
	white-space:nowrap;}
.xl1087179
	{padding:0px;
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
	border-bottom:1.0pt solid windowtext;
	border-left:1.0pt solid windowtext;
	background:#BFBFBF;
	mso-pattern:black none;
	white-space:nowrap;}
.xl1097179
	{padding:0px;
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
	border-right:1.0pt solid windowtext;
	border-bottom:1.0pt solid windowtext;
	border-left:.5pt solid windowtext;
	background:#BFBFBF;
	mso-pattern:black none;
	white-space:nowrap;}
.xl1107179
	{padding:0px;
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
.xl1117179
	{padding:0px;
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
.xl1127179
	{padding:0px;
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
.xl1137179
	{padding:0px;
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
.xl1147179
	{padding:0px;
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
.xl1157179
	{padding:0px;
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
.xl1167179
	{padding:0px;
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
.xl1177179
	{padding:0px;
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
.xl1187179
	{padding:0px;
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
	border-top:none;
	border-right:.5pt solid windowtext;
	border-bottom:none;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl1197179
	{padding:0px;
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
.xl1207179
	{padding:0px;
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
	border-left:1.0pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl1217179
	{padding:0px;
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
	border-right:.5pt solid windowtext;
	border-bottom:.5pt solid windowtext;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl1227179
	{padding:0px;
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
	border-left:1.0pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl1237179
	{padding:0px;
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
	border-bottom:1.0pt solid windowtext;
	border-left:1.0pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl1247179
	{padding:0px;
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
	border-bottom:.5pt solid windowtext;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl1257179
	{padding:0px;
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
	border-right:1.0pt solid windowtext;
	border-bottom:1.0pt solid windowtext;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl1267179
	{padding:0px;
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
	border:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl1277179
	{padding:0px;
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
.xl1287179
	{padding:0px;
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
.xl1297179
	{padding:0px;
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
	border-bottom:.5pt solid windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl1307179
	{padding:0px;
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
	border-top:1.0pt solid windowtext;
	border-right:none;
	border-bottom:.5pt solid windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl1317179
	{padding:0px;
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
body { zoom:100%;}
#ad{ display:none;}
#leftbar{ display:none;}
#Book7_7179{ width:95%;}
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
<!--The following information was generated by Microsoft Office Excel's Publish
as Web Page wizard.-->
<!--If the same item is republished from Excel, all information between the DIV
tags will be replaced.-->
<!----------------------------->
<!--START OF OUTPUT FROM EXCEL PUBLISH AS WEB PAGE WIZARD -->
<!----------------------------->

<div id="Book7_7179" align=center x:publishsource="Excel">

<table border=0 cellpadding=0 cellspacing=0 width=1046 style='border-collapse:
 collapse;table-layout:fixed;width:790pt'>
 <col width=88 style='mso-width-source:userset;mso-width-alt:3218;width:66pt'>
 <col width=55 span=12 style='mso-width-source:userset;mso-width-alt:2011;
 width:41pt'>
 <col width=43 span=6 style='mso-width-source:userset;mso-width-alt:1572;
 width:32pt'>
 <tr height=28 style='mso-height-source:userset;height:21.0pt'>
  <td height=28 width=88 style='height:21.0pt;width:66pt' align=left
  valign=top><!--[if gte vml 1]><v:shapetype id="_x0000_t75" coordsize="21600,21600"
   o:spt="75" o:preferrelative="t" path="m@4@5l@4@11@9@11@9@5xe" filled="f"
   stroked="f">
   <v:stroke joinstyle="miter"/>
   <v:formulas>
    <v:f eqn="if lineDrawn pixelLineWidth 0"/>
    <v:f eqn="sum @0 1 0"/>
    <v:f eqn="sum 0 0 @1"/>
    <v:f eqn="prod @2 1 2"/>
    <v:f eqn="prod @3 21600 pixelWidth"/>
    <v:f eqn="prod @3 21600 pixelHeight"/>
    <v:f eqn="sum @0 0 1"/>
    <v:f eqn="prod @6 1 2"/>
    <v:f eqn="prod @7 21600 pixelWidth"/>
    <v:f eqn="sum @8 21600 0"/>
    <v:f eqn="prod @7 21600 pixelHeight"/>
    <v:f eqn="sum @10 21600 0"/>
   </v:formulas>
   <v:path o:extrusionok="f" gradientshapeok="t" o:connecttype="rect"/>
   <o:lock v:ext="edit" aspectratio="t"/>
  </v:shapetype><v:shape id="Text_x0020_Box_x0020_11" o:spid="_x0000_s1025"
   type="#_x0000_t75" style='position:absolute;margin-left:39pt;margin-top:6pt;
   width:137.25pt;height:17.25pt;z-index:1;visibility:visible' o:gfxdata="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
AAAAyQYAAAAA
">
   <v:imagedata src="Print_doc3_files/Book7_7179_image001.png" o:title=""/>
   <o:lock v:ext="edit" aspectratio="f"/>
   <x:ClientData ObjectType="Pict">
    <x:SizeWithCells/>
    <x:CF>Bitmap</x:CF>
    <x:AutoPict/>
   </x:ClientData>
  </v:shape><v:shape id="Picture_x0020_12" o:spid="_x0000_s1026" type="#_x0000_t75"
   alt="LOGO" style='position:absolute;margin-left:6pt;margin-top:2.25pt;
   width:34.5pt;height:28.5pt;z-index:2;visibility:visible' o:gfxdata="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
Ew8UHRofHh0aHBwgJC4nICIsIxwcKDcpLDAxNDQ0Hyc5PTgyPC4zNDL/2wBDAQkJCQwLDBgNDRgy
IRwhMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjL/wAAR
CABCADMDASIAAhEBAxEB/8QAHwAAAQUBAQEBAQEAAAAAAAAAAAECAwQFBgcICQoL/8QAtRAAAgED
AwIEAwUFBAQAAAF9AQIDAAQRBRIhMUEGE1FhByJxFDKBkaEII0KxwRVS0fAkM2JyggkKFhcYGRol
JicoKSo0NTY3ODk6Q0RFRkdISUpTVFVWV1hZWmNkZWZnaGlqc3R1dnd4eXqDhIWGh4iJipKTlJWW
l5iZmqKjpKWmp6ipqrKztLW2t7i5usLDxMXGx8jJytLT1NXW19jZ2uHi4+Tl5ufo6erx8vP09fb3
+Pn6/8QAHwEAAwEBAQEBAQEBAQAAAAAAAAECAwQFBgcICQoL/8QAtREAAgECBAQDBAcFBAQAAQJ3
AAECAxEEBSExBhJBUQdhcRMiMoEIFEKRobHBCSMzUvAVYnLRChYkNOEl8RcYGRomJygpKjU2Nzg5
OkNERUZHSElKU1RVVldYWVpjZGVmZ2hpanN0dXZ3eHl6goOEhYaHiImKkpOUlZaXmJmaoqOkpaan
qKmqsrO0tba3uLm6wsPExcbHyMnK0tPU1dbX2Nna4uPk5ebn6Onq8vP09fb3+Pn6/9oADAMBAAIR
AxEAPwD3+iiigDnvF3iFtA0xGgVGup22RB+i4GSxHfHH4kV5Vd6pqF/KZLu+uJnJz80hwPoBwPwA
rtfidG2dLm/gHmofYnaR/I/lXn9efiJPnt0Psslw9KOGjUS9531+djp/DfjG+0y8ihvbl57BmCv5
zbmjB/iDHnA9OmOletV8/bWf5FUszcBR1JPQV73aRPDZwRSvvkSNVZv7xAwTW2Gk2mmedn+Hp05Q
qQVm73+VtSaiiiuo+eCqN7rGm6cwS8vreByMhXkAOPp1rL8Z61LouhF7c7bi4cQxv/cyCS35A/iR
XkBJZmdmLMxyzE5JPqT3rnq1+R2R7WW5T9ah7ScrR/M7Lx34hsdWNraWEnnLCxkeUfdyRgAevf8A
T3xiaJ4a1LXizWkarChw00pITPoMZJP0FZFe0eEzCfCmmeRjb5Chsf3/AOP/AMezWEF7abcj2MXU
/szCxhRV9bXf3mX4e8C22kXSXt1P9quU5QbdqIfUDqT7/pXW0UV2xgoqyPlK+Iq4ifPVd2FFFFUY
HK+P9NlvvDwmhBZ7STzmUdSmCG/LOfwNeUZr6BrnL/wPod/OZvIe3djlvs77Qfw6fkK5q1BzfNE9
7K82hhqfsqq06NHkOcd609I8Q6nogcWNwFjc5aNxuQn1x2P0r1Ow8JaHp3MVhHI5GC8/7w/+PdPw
rm/H3h20g09NTsrVIXjcLMIl2qUPAJA7g4GffnpWLoTguZM9KGb4bFVFQlDR97fkcpeeKdcvmzLq
UyD+7C3lgf8AfOP1rT8P+N7/AE+7jj1G4a5smOHMpy8Y/vBupA7g1ytKsbyssUal5HIVVH8RPAH5
1kqk073PSqYLDzp+zcEl6H0BRUNrCbezghZy7RxqhY/xEDGaK9Q/PnvoTUUUUCIrm4jtLWa5mbbF
Chkc4zhQMmvObz4jTXEzxpplu9iwKtFOSWdT6kcDPpg/jXoGp2S6lpd1ZM20TxMm7GdpI4P4GvIp
vCevQXf2Y6bNI5OA8eCh993QD64rmryqK3Ke5k9HCVFJ12rra7tobtr4LsvEFquo6RfPbQSMQbea
PeYiDyuQw/DPbHNdHoPgix0adbqWVru6T7jsu1U9wvPPuSau+FNGl0PQ0tZ2BnZ2kk2nIBPYfQAf
jmturp0opKTWphjMxrylKlCo3C7S8167v9QooorY8oKKKKACiiigAooooAKKKKAP/9lQSwECLQAU
AAYACAAAACEA9L5jXQ4BAAAaAgAAEwAAAAAAAAAAAAAAAAAAAAAAW0NvbnRlbnRfVHlwZXNdLnht
bFBLAQItABQABgAIAAAAIQAIwxik1AAAAJMBAAALAAAAAAAAAAAAAAAAAD8BAABfcmVscy8ucmVs
c1BLAQItABQABgAIAAAAIQCUKrOnHAIAAJsFAAASAAAAAAAAAAAAAAAAADwCAABkcnMvcGljdHVy
ZXhtbC54bWxQSwECLQAUAAYACAAAACEAWGCzG7oAAAAiAQAAHQAAAAAAAAAAAAAAAACIBAAAZHJz
L19yZWxzL3BpY3R1cmV4bWwueG1sLnJlbHNQSwECLQAUAAYACAAAACEAtv0xzhMBAACHAQAADwAA
AAAAAAAAAAAAAAB9BQAAZHJzL2Rvd25yZXYueG1sUEsBAi0ACgAAAAAAAAAhADhzEd/zBQAA8wUA
ABUAAAAAAAAAAAAAAAAAvQYAAGRycy9tZWRpYS9pbWFnZTEuanBlZ1BLBQYAAAAABgAGAIUBAADj
DAAAAAA=
">
   <v:imagedata src="Print_doc3_files/Book7_7179_image002.png" o:title=""/>
   <x:ClientData ObjectType="Pict">
    <x:SizeWithCells/>
    <x:CF>Bitmap</x:CF>
    <x:AutoPict/>
   </x:ClientData>
  </v:shape><![endif]--><![if !vml]><span style='mso-ignore:vglayout;
  position:absolute;z-index:1;margin-left:8px;margin-top:3px;width:227px;
  height:38px'><img width=227 height=38
  src="Print_doc3_files/Book7_7179_image003.png" alt=LOGO v:shapes="Text_x0020_Box_x0020_11 Picture_x0020_12"></span><![endif]><span
  style='mso-ignore:vglayout2'>
  <table cellpadding=0 cellspacing=0>
   <tr>
    <td height=28 class=xl157179 width=88 style='height:21.0pt;width:66pt'></td>
   </tr>
  </table>
  </span></td>
  <td class=xl157179 width=55 style='width:41pt'></td>
  <td class=xl157179 width=55 style='width:41pt'></td>
  <td class=xl157179 width=55 style='width:41pt'></td>
  <td class=xl157179 width=55 style='width:41pt'></td>
  <td class=xl157179 width=55 style='width:41pt'></td>
  <td class=xl157179 width=55 style='width:41pt'></td>
  <td class=xl157179 width=55 style='width:41pt'></td>
  <td class=xl157179 width=55 style='width:41pt'></td>
  <td class=xl157179 width=55 style='width:41pt'></td>
  <td class=xl157179 width=55 style='width:41pt'></td>
  <td class=xl157179 width=55 style='width:41pt'></td>
  <td class=xl157179 width=55 style='width:41pt'></td>
  <td class=xl157179 width=43 style='width:32pt'></td>
  <td class=xl157179 width=43 style='width:32pt'></td>
  <td class=xl757179 width=43 style='width:32pt'>Page No:</td>
  <td class=xl767179 width=43 style='width:32pt'><?php echo $printed_count ?></td>
  <td class=xl157179 width=43 style='width:32pt'></td>
  <td class=xl157179 width=43 style='width:32pt'></td>
 </tr>
 <tr height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl157179 style='height:15.0pt'></td>
  <td class=xl157179></td>
  <td class=xl157179></td>
  <td class=xl157179></td>
  <td class=xl157179></td>
  <td class=xl157179></td>
  <td class=xl157179></td>
  <td class=xl1277179>LID:</td>
  <td colspan=2 class=xl1267179><?php echo $CID; ?></td>
  <td class=xl157179></td>
  <td class=xl777179>Hour No</td>
  <td class=xl777179 style='border-left:none'>Style</td>
  <td class=xl777179 style='border-left:none'>Schdl</td>
  <td colspan=3 class=xl1147179 style='border-right:.5pt solid black;
  border-left:none'>Color</td>
  <td class=xl777179 style='border-left:none'>Job No</td>
  <td class=xl777179 style='border-left:none'>Rework</td>
 </tr>
  <tr height=20 style='height:15.0pt'>
  <td colspan=11 rowspan=2 height=40 class=xl1177179 style='border-right:.5pt solid black;
  height:30.0pt'>Production Review</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td colspan=3 class=xl1117179 style='border-right:.5pt solid black;
  border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
   <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl787179 style='height:15.0pt;border-top:none;border-left:
  none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td colspan=3 class=xl1117179 style='border-right:.5pt solid black;
  border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl157179 style='height:15.0pt'></td>
  <td class=xl157179></td>
  <td class=xl157179></td>
  <td class=xl157179></td>
  <td class=xl157179></td>
  <td class=xl157179></td>
  <td class=xl157179></td>
  <td class=xl157179></td>
  <td class=xl157179></td>
  <td class=xl157179></td>
  <td class=xl157179></td>
  <td class=xl787179 style='border-top:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td colspan=3 class=xl1117179 style='border-right:.5pt solid black;
  border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
   <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
 </tr>
 <tr class=xl807179 height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl797179 style='height:15.0pt'>Date:</td>
  <td colspan=2 class=xl1287179>&nbsp;</td>
  <td class=xl797179>Style:</td>
  <td colspan=2 class=xl1287179><?php echo $style; ?></td>
  <td class=xl797179>Color:</td>
  <td colspan=3 class=xl1287179><?php echo $color; ?></td>
  <td class=xl807179></td>
  <td class=xl817179 style='border-top:none'>&nbsp;</td>
  <td class=xl817179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl817179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td colspan=3 class=xl1117179 style='border-right:.5pt solid black;
  border-left:none'>&nbsp;</td>
  <td class=xl817179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl817179 style='border-top:none;border-left:none'>&nbsp;</td>
 </tr>
 <tr class=xl807179 height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl797179 style='height:15.0pt'>Module:</td>
  <td colspan=2 class=xl1297179>&nbsp;</td>
  <td class=xl797179>Schedule:</td>
  <td colspan=2 class=xl1297179><?php echo $schedule; ?></td>
  <td class=xl797179>Job No:</td>
  <td colspan=3 class=xl1297179><?php echo $cutid.leading_zeros($cut_no,3). $add_title; ?></td>
  <td class=xl807179></td>
  <td class=xl817179 style='border-top:none'>&nbsp;</td>
  <td class=xl817179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl817179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td colspan=3 class=xl1117179 style='border-right:.5pt solid black;
  border-left:none'>&nbsp;</td>
  <td class=xl817179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl817179 style='border-top:none;border-left:none'>&nbsp;</td>
 </tr>
 <tr class=xl807179 height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl797179 style='height:15.0pt'>Ex-Factory:</td>
  <td colspan=2 class=xl1297179><b><?php echo $order_date; ?></b></td>
  <td class=xl797179>Cut:</td>
  <td colspan=2 class=xl1297179><b><?php echo (100+$cut_per+$extra_ship_ord)."%"; ?></b></td>
  <td class=xl797179></td>
  <td colspan=3></td>
  <td class=xl807179></td>
  <td class=xl817179 style='border-top:none'></td>
  <td class=xl817179 style='border-top:none;border-left:none'></td>
  <td class=xl817179 style='border-top:none;border-left:none'></td>
  <td colspan=3 class=xl1117179 style='border-right:.5pt solid black;
  border-left:none'>&nbsp;</td>
  <td class=xl817179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl817179 style='border-top:none;border-left:none'>&nbsp;</td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl157179 style='height:15.0pt'></td>
  <td class=xl157179></td>
  <td class=xl157179></td>
  <td class=xl157179></td>
  <td class=xl157179></td>
  <td class=xl157179></td>
  <td class=xl157179></td>
  <td class=xl157179></td>
  <td class=xl157179></td>
  <td class=xl157179></td>
  <td class=xl157179></td>
  <td class=xl787179 style='border-top:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td colspan=3 class=xl1117179 style='border-right:.5pt solid black;
  border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl157179 style='height:15.0pt'></td>
  <td class=xl157179>XS</td>
  <td class=xl157179>S</td>
  <td class=xl157179>M</td>
  <td class=xl157179>L</td>
  <td class=xl157179>XL</td>
  <td class=xl157179>Total</td>
  <td class=xl157179></td>
  <td class=xl157179></td>
  <td class=xl157179></td>
  <td class=xl157179></td>
  <td class=xl787179 style='border-top:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td colspan=3 class=xl1117179 style='border-right:.5pt solid black;
  border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
   <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl807179 style='height:15.0pt'>Cut Qty</td>
  <td class=xl787179><?php echo $a_xs_n; ?></td>
  <td class=xl787179 style='border-left:none'><?php echo $a_s_n; ?></td>
  <td class=xl787179 style='border-left:none'><?php echo $a_m_n; ?></td>
  <td class=xl787179 style='border-left:none'><?php echo $a_l_n; ?></td>
  <td class=xl787179 style='border-left:none'><?php echo $a_xl_n; ?></td>
  <td class=xl787179 style='border-left:none'><?php echo $temp_sum_n; ?></td>
  <td class=xl157179 colspan="4" style="font-size:16px;">&nbsp;&nbsp;</td>
  <td class=xl787179 style='border-top:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'></td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td colspan=3 class=xl1117179 style='border-right:.5pt solid black;
  border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
 </tr>
 
 
 
 
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl807179 style='height:15.0pt'>Balance B/F</td>
  <td class=xl787179 style='border-top:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl157179 colspan=4 style="font-size:16px;">&nbsp;&nbsp;</td>
  <td class=xl787179 style='border-top:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td colspan=3 class=xl1117179 style='border-right:.5pt solid black;
  border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl807179 style='height:15.0pt'>Out Put</td>
  <td class=xl787179 style='border-top:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl157179></td>
  <td class=xl157179></td>
  <td class=xl157179></td>
  <td class=xl157179></td>
  <td class=xl787179 style='border-top:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td colspan=3 class=xl1117179 style='border-right:.5pt solid black;
  border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
 <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
 </tr>
 
  <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl807179 style='height:15.0pt'><strong>Rejection F/D</strong></td>
  <td class=xl787179 style='border-top:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl157179></td>
  <td class=xl157179></td>
  <td class=xl157179></td>
  <td class=xl157179></td>
  <td class=xl787179 style='border-top:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td colspan=3 class=xl1117179 style='border-right:.5pt solid black;
  border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
 </tr>
 
  <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl807179 style='height:15.0pt'><strong>Rejection S/D</strong></td>
  <td class=xl787179 style='border-top:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl157179></td>
  <td class=xl157179></td>
  <td class=xl157179></td>
  <td class=xl157179></td>
  <td class=xl787179 style='border-top:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td colspan=3 class=xl1117179 style='border-right:.5pt solid black;
  border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
 </tr>
 
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl807179 style='height:15.0pt'>Balance C/F</td>
  <td class=xl787179 style='border-top:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl157179></td>
  <td class=xl157179></td>
  <td class=xl157179></td>
  <td class=xl157179></td>
  <td class=xl787179 style='border-top:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td colspan=3 class=xl1117179 style='border-right:.5pt solid black;
  border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
 </tr>
 
 <tr height=11 style='mso-height-source:userset;height:8.25pt'>
  <td height=11 class=xl807179 style='height:8.25pt'></td>
  <td class=xl157179></td>
  <td class=xl157179></td>
  <td class=xl157179></td>
  <td class=xl157179></td>
  <td class=xl157179></td>
  <td class=xl157179></td>
  <td class=xl157179></td>
  <td class=xl157179></td>
  <td class=xl157179></td>
  <td class=xl157179></td>
  <td class=xl157179></td>
  <td class=xl157179></td>
  <td class=xl157179></td>
  <td class=xl157179></td>
  <td class=xl157179></td>
  <td class=xl157179></td>
  <td class=xl157179></td>
  <td class=xl157179></td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td rowspan=2 height=41 class=xl1197179 style='border-bottom:1.0pt solid black;
  height:30.75pt'>Hour<span style='mso-spacerun:yes'> </span></td>
  <td colspan=2 class=xl1217179 style='border-left:none'>XS</td>
  <td colspan=2 class=xl1217179 style='border-left:none'>S</td>
  <td colspan=2 class=xl1217179 style='border-left:none'>M</td>
  <td colspan=2 class=xl1217179 style='border-left:none'>L</td>
  <td colspan=2 class=xl1217179 style='border-left:none'>XL</td>
  <td class=xl827179 style='border-left:none'>Quality</td>
  <td class=xl837179 style='border-left:none'>Packing</td>
  <td class=xl837179>Recorder</td>
  <td rowspan=2 class=xl1227179 style='border-bottom:1.0pt solid black'>XS</td>
  <td rowspan=2 class=xl827179 style='border-bottom:1.0pt solid black'>S</td>
  <td rowspan=2 class=xl827179 style='border-bottom:1.0pt solid black'>Total</td>
  <td rowspan=2 class=xl827179 style='border-bottom:1.0pt solid black'>Rework</td>
  <td rowspan=2 class=xl1247179 style='border-bottom:1.0pt solid black'>Rejection</td>
  <td rowspan=2 class=xl1247179 style='border-bottom:1.0pt solid black'>Surplus</td>
 </tr>
 <tr height=21 style='height:15.75pt'>
  <td height=21 class=xl847179 style='height:15.75pt;border-top:none;
  border-left:none'>Out</td>
  <td class=xl847179 style='border-top:none;border-left:none'>Cum Out</td>
  <td class=xl847179 style='border-top:none;border-left:none'>Out</td>
  <td class=xl847179 style='border-top:none;border-left:none'>Cum Out</td>
  <td class=xl847179 style='border-top:none;border-left:none'>Out</td>
  <td class=xl847179 style='border-top:none;border-left:none'>Cum Out</td>
  <td class=xl847179 style='border-top:none;border-left:none'>Out</td>
  <td class=xl847179 style='border-top:none;border-left:none'>Cum Out</td>
  <td class=xl847179 style='border-top:none;border-left:none'>Out</td>
  <td class=xl847179 style='border-top:none;border-left:none'>Cum Out</td>
  <td class=xl847179 style='border-top:none;border-left:none'>Sign</td>
  <td class=xl857179 style='border-top:none;'>Sign</td>
  <td class=xl857179 style='border-top:none;'>Sign</td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl867179 style='height:15.0pt'>6 am - 7 am</td>
  <td class=xl877179 style='border-left:none'>&nbsp;</td>
  <td class=xl877179 style='border-left:none'>&nbsp;</td>
  <td class=xl877179 style='border-left:none'>&nbsp;</td>
  <td class=xl877179 style='border-left:none'>&nbsp;</td>
  <td class=xl877179 style='border-left:none'>&nbsp;</td>
  <td class=xl877179 style='border-left:none'>&nbsp;</td>
  <td class=xl877179 style='border-left:none'>&nbsp;</td>
  <td class=xl877179 style='border-left:none'>&nbsp;</td>
  <td class=xl877179 style='border-left:none'>&nbsp;</td>
  <td class=xl877179 style='border-left:none'>&nbsp;</td>
  <td class=xl877179 style='border-left:none'>&nbsp;</td>
  <td class=xl887179 style='border-left:none'>&nbsp;</td>
  
  <td class=xl897179>&nbsp;</td>
  <td class=xl877179 style='border-left:none'>&nbsp;</td>
  <td class=xl877179 style='border-left:none'>&nbsp;</td>
  <td class=xl877179 style='border-left:none'>&nbsp;</td>
  <td class=xl907179 style='border-left:none'>&nbsp;</td>
  <td class=xl907179>&nbsp;</td>
  <td class=xl907179>&nbsp;</td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl917179 style='height:15.0pt;border-top:none'>7 am - 8
  am</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl927179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl937179 style='border-top:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl947179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl947179 style='border-top:none'>&nbsp;</td>
  <td class=xl947179 style='border-top:none'>&nbsp;</td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl917179 style='height:15.0pt;border-top:none'>8 am - 9
  am</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl927179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl937179 style='border-top:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl947179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl947179 style='border-top:none'>&nbsp;</td>
  <td class=xl947179 style='border-top:none'>&nbsp;</td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl917179 style='height:15.0pt;border-top:none'>9 am - 10
  am</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl927179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl937179 style='border-top:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl947179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl947179 style='border-top:none'>&nbsp;</td>
  <td class=xl947179 style='border-top:none'>&nbsp;</td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl917179 style='height:15.0pt;border-top:none'>10 am - 11
  am</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl927179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl937179 style='border-top:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl947179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl947179 style='border-top:none'>&nbsp;</td>
  <td class=xl947179 style='border-top:none'>&nbsp;</td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl917179 style='height:15.0pt;border-top:none'>11 am - 12
  pm</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl927179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl937179 style='border-top:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl947179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl947179 style='border-top:none'>&nbsp;</td>
  <td class=xl947179 style='border-top:none'>&nbsp;</td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl917179 style='height:15.0pt;border-top:none'>12 pm - 1
  pm</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl927179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl937179 style='border-top:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl947179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl947179 style='border-top:none'>&nbsp;</td>
  <td class=xl947179 style='border-top:none'>&nbsp;</td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl917179 style='height:15.0pt;border-top:none'>1 pm - 2
  pm</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl927179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl937179 style='border-top:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl947179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl947179 style='border-top:none'>&nbsp;</td>
  <td class=xl947179 style='border-top:none'>&nbsp;</td>
 </tr>
 
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl917179 style='height:15.0pt;border-top:none'>2 pm - 3
  pm</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl927179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl937179 style='border-top:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl947179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl947179 style='border-top:none'>&nbsp;</td>
  <td class=xl947179 style='border-top:none'>&nbsp;</td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl917179 style='height:15.0pt;border-top:none'>3 pm - 4
  pm</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl927179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl937179 style='border-top:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl947179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl947179 style='border-top:none'>&nbsp;</td>
  <td class=xl947179 style='border-top:none'>&nbsp;</td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl917179 style='height:15.0pt;border-top:none'>4 pm - 5
  pm</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl927179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl937179 style='border-top:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl947179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl947179 style='border-top:none'>&nbsp;</td>
  <td class=xl947179 style='border-top:none'>&nbsp;</td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl917179 style='height:15.0pt;border-top:none'>5 pm - 6
  pm</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl927179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl937179 style='border-top:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl947179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl947179 style='border-top:none'>&nbsp;</td>
  <td class=xl947179 style='border-top:none'>&nbsp;</td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl917179 style='height:15.0pt;border-top:none'>6 pm - 7
  pm</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl927179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl937179 style='border-top:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl947179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl947179 style='border-top:none'>&nbsp;</td>
  <td class=xl947179 style='border-top:none'>&nbsp;</td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl917179 style='height:15.0pt;border-top:none'>7 pm - 8
  pm</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl927179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl937179 style='border-top:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl947179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl947179 style='border-top:none'>&nbsp;</td>
  <td class=xl947179 style='border-top:none'>&nbsp;</td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl917179 style='height:15.0pt;border-top:none'>8 pm - 9
  pm</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl927179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl937179 style='border-top:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl947179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl947179 style='border-top:none'>&nbsp;</td>
  <td class=xl947179 style='border-top:none'>&nbsp;</td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl917179 style='height:15.0pt;border-top:none'>9 pm - 10
  pm</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl927179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl937179 style='border-top:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl787179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl947179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl947179 style='border-top:none'>&nbsp;</td>
  <td class=xl947179 style='border-top:none'>&nbsp;</td>
 </tr>
 
  <tr height=21 style='height:15.75pt'>
  <td height=21 class=xl1057179 style='height:15.75pt;border-top:none'>Balance Output</td>
  <td class=xl1067179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl1067179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl1067179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl1067179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl1067179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl1067179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl1067179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl1067179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl1067179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl1067179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl1067179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl1077179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl1087179 style='border-top:none'>&nbsp;</td>
  <td class=xl1067179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl1067179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl1067179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl1097179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl1097179 style='border-top:none'>&nbsp;</td>
  <td class=xl1097179 style='border-top:none'>&nbsp;</td>
 </tr>
 
 <tr height=21 style='height:15.75pt'>
  <td height=21 class=xl1057179 style='height:15.75pt;border-top:none'>Total</td>
  <td class=xl1067179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl1067179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl1067179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl1067179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl1067179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl1067179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl1067179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl1067179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl1067179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl1067179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl1067179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl1077179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl1087179 style='border-top:none'>&nbsp;</td>
  <td class=xl1067179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl1067179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl1067179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl1097179 style='border-top:none;border-left:none'>&nbsp;</td>
  <td class=xl1097179 style='border-top:none'>&nbsp;</td>
  <td class=xl1097179 style='border-top:none'>&nbsp;</td>
 </tr>
 
 
 <![if supportMisalignedColumns]>
 <tr height=0 style='display:none'>
  <td width=88 style='width:66pt'></td>
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
  <td width=43 style='width:32pt'></td>
  <td width=43 style='width:32pt'></td>
  <td width=43 style='width:32pt'></td>
  <td width=43 style='width:32pt'></td>
  <td width=43 style='width:32pt'></td>
  <td width=43 style='width:32pt'></td>
 </tr>
 <![endif]>
 
 <tr height=20 style='height:15.0pt'>
  <td height=20 ></td>
  <td ></td>
  <td ></td>
  <td ></td>
  <td  ></td>
  <td ></td>
  <td ></td>
  <td  ></td>
   <td  ></td>
  <td ></td>
  <td ></td>
  <td  ></td>
   <td  ></td>
 </tr>

 	 </table>
 
 <table border=0 cellpadding=0 cellspacing=0 width=1046 style='border-collapse:
 collapse;table-layout:fixed;width:790pt'>
 
 <tr>
 
 	<td class=xl1057179  align='center'>Size</td>
 	<td class=xl1057179 style='border-left:none' align='center'>Cut Qty.</td>
 	<td class=xl1057179 style='border-left:none' align='center' width="90">Std. Carton Qty.</td>
 	<td class=xl1057179 style='border-left:none' align='center' width="80">No. of cartons</td>
 	
 	<?php
 	
 	$total_no_cartons=0;
	if($carton_xs>0)
 	{
  		$no_carton_xs=floor($a_xs_n/$carton_xs);
  		$bal_qty_carton_xs=$a_xs_n%$carton_xs;
  	}
   if($bal_qty_carton_xs>0)
  {
  	$no_carton_xs++;
  }
  
  $total_no_cartons=$no_carton_xs;
  
    //echo "<br/>".$no_carton_xs;
    //echo "<br/>".$total_no_cartons;
  if($carton_s>0)
 {
  $no_carton_s=floor($a_s_n/$carton_s);
  $bal_qty_carton_s=$a_s_n%$carton_s;
 }
   if($bal_qty_carton_s>0)
  {
  	$no_carton_s++;
  }
  
  if($total_no_cartons<$no_carton_s)
  {
  	$total_no_cartons=$no_carton_s;
  }
  
   // echo "<br/>".$no_carton_s;
   // echo "<br/>".$total_no_cartons;
   if($carton_m>0)
 	{
  		$no_carton_m=floor($a_m_n/$carton_m);
  		$bal_qty_carton_m=$a_m_n%$carton_m;
  	}
   if($bal_qty_carton_m>0)
  {
  	$no_carton_m++;
  }
  
  if($total_no_cartons<$no_carton_m)
  {
  	$total_no_cartons=$no_carton_m;
  }
  
   // echo "<br/>".$no_carton_m;
   // echo "<br/>".$total_no_cartons;
  if($carton_l>0)
 	{
 	 	$no_carton_l=floor($a_l_n/$carton_l);
  		$bal_qty_carton_l=$a_l_n%$carton_l;
  	}
   if($bal_qty_carton_l>0)
  {
  	$no_carton_l++;
  }
  
  if($total_no_cartons<$no_carton_l)
  {
  	$total_no_cartons=$no_carton_l;
  }
  
  //  echo "<br/>".$no_carton_l;
   // echo "<br/>".$total_no_cartons;
  if($carton_xl>0)
 	{
  	 	$no_carton_xl=floor($a_xl_n/$carton_xl);
  		$bal_qty_carton_xl=$a_xl_n%$carton_xl;
  	}
   if($bal_qty_carton_xl>0)
  {
  	$no_carton_xl++;
  }
  
  if($total_no_cartons<$no_carton_xl)
  {
  	$total_no_cartons=$no_carton_xl;
  }
  
  if($remarks=='Pilot')
  {
   $p_plies=$plies;
  }
 // echo "<br/>".$no_carton_xl;
 //   echo "<br/>".$total_no_cartons;
  
  for($col=0;$col<$total_no_cartons;$col++)
  {
 ?>	
 	<td class=xl1057179 style='border-left:none' align='center'>Qty./Bundles</td>
 	<?php
 	 }
 	?>
 	
 
 </tr>
 <?php
 if($a_xs_n>0)
 {
 ?>
 <tr>
 	<td class=xl787179 align='center'>XS</td>
 	<td class=xl787179 style='border-left:none'><?php echo $a_xs_n; ?></td>
 	<td class=xl787179 style='border-left:none'><?php echo $carton_xs;?></td>
 	
 	<?php
 	echo "<td class=xl787179 style='border-left:none'>".$no_carton_xs."</td>";
 
 if($carton_xs>0)
 {
 	$no_carton_xs=floor($a_xs_n/$carton_xs);
 	$bal_qty_carton_xs=$a_xs_n%$carton_xs;
 	
 }
 	
 	for($cnt=0;$cnt<$no_carton_xs;$cnt++)
 	{
		echo "<td class=xl787179 style='border-left:none'>".$carton_xs."/".round(($carton_xs/$p_plies),2)."</td>";
		
	}
 	
  
  if(  $bal_qty_carton_xs>0)
  {
  	echo "<td class=xl787179 style='border-left:none'>".$bal_qty_carton_xs."/".round(($bal_qty_carton_xs/$p_plies),2)."</td>";
  	$no_carton_xs++;
  	
  }
  
  if($total_no_cartons>$no_carton_xs)
  {
  	 for($col=0;$col<($total_no_cartons-$no_carton_xs);$col++)
  	 echo "<td class=xl787179 style='border-left:none'>&nbsp;</td>";
  
  }
 	
 	
 	?>
 	
 </tr>	
 	
 	<?php
 }
 
 ?>
 
 
 <?php
 if($a_s_n>0)
 {
 ?>
 <tr>
 	<td class=xl787179 align='center'>S</td>
 	<td class=xl787179 style='border-left:none'><?php echo $a_s_n; ?></td>
 	<td class=xl787179 style='border-left:none'><?php echo $carton_s;?></td>
 	<?php
 	echo "<td class=xl787179 style='border-left:none'>".$no_carton_s."</td>";
 
 if($carton_s>0)
 {
 	$no_carton_s=floor($a_s_n/$carton_s);
 	 $bal_qty_carton_s=$a_s_n%$carton_s;
 	
 }
 	
 	for($cnt=0;$cnt<$no_carton_s;$cnt++)
 	{
		echo "<td class=xl787179 style='border-left:none'>".$carton_s."/".round(($carton_s/$p_plies),2)."</td>";
	}
 	
 
  if(  $bal_qty_carton_s>0)
  {
  	echo "<td class=xl787179 style='border-left:none'>".$bal_qty_carton_s."/".round(($bal_qty_carton_s/$p_plies),2)."</td>";
  	$no_carton_s++;
  	
  }
  
   if($total_no_cartons>$no_carton_s)
  {
  	 for($col=0;$col<($total_no_cartons-$no_carton_s);$col++)
  	 echo "<td class=xl787179 style='border-left:none'>&nbsp;</td>";
  
  }
 	
 	
 	?>
 	
 </tr>	
 	
 	<?php
 }
 
 ?>
 
 <?php
 if($a_m_n>0)
 {
 ?>
 <tr>
 	<td class=xl787179 align='center'>M</td>
 	<td class=xl787179 style='border-left:none'><?php echo $a_m_n; ?></td>
 	<td class=xl787179 style='border-left:none'><?php echo $carton_m;?></td>
 	<?php
 	echo "<td class=xl787179 style='border-left:none'>".$no_carton_m."</td>";
 
 if($carton_m>0)
 {
 	$no_carton_m=floor($a_m_n/$carton_m);
 	 $bal_qty_carton_m=$a_m_n%$carton_m;
 }
 	
 	
 	for($cnt=0;$cnt<$no_carton_m;$cnt++)
 	{
		echo "<td class=xl787179 style='border-left:none'>".$carton_m."/".round(($carton_m/$p_plies),2)."</td>";
	}
 	
 
  if(  $bal_qty_carton_m>0)
  {
  	echo "<td class=xl787179 style='border-left:none'>".$bal_qty_carton_m."/".round(($bal_qty_carton_m/$p_plies),2)."</td>";
  	$no_carton_m++;
  	
  }
   if($total_no_cartons>$no_carton_m)
  {
  	 for($col=0;$col<($total_no_cartons-$no_carton_m);$col++)
  	 echo "<td class=xl787179 style='border-left:none'>&nbsp;</td>";
  
  }
 	
 	
 	?>
 	
 </tr>	
 	
 	<?php
 }
 
 ?>
 
 <?php
 if($a_l_n>0)
 {
 ?>
 <tr>
 	<td class=xl787179  align='center'>L</td>
 	<td class=xl787179 style='border-left:none'><?php echo $a_l_n; ?></td>
 	<td class=xl787179 style='border-left:none'><?php echo $carton_l;?></td>
 	<?php
 	echo "<td class=xl787179 style='border-left:none'>".$no_carton_l."</td>";
 if($carton_l>0)
 {
 	$no_carton_l=floor($a_l_n/$carton_l);
 	$bal_qty_carton_l=$a_l_n%$carton_l;
 	
 }
 	
 	
 	for($cnt=0;$cnt<$no_carton_l;$cnt++)
 	{
		echo "<td class=xl787179 style='border-left:none'>".$carton_l."/".round(($carton_l/$p_plies),2)."</td>";
	}
 	
  
  if(  $bal_qty_carton_l>0)
  {
  	echo "<td class=xl787179 style='border-left:none'>".$bal_qty_carton_l."/".round(($bal_qty_carton_l/$p_plies),2)."</td>";
  	$no_carton_l++;
  	
  }
  
  if($total_no_cartons>$no_carton_l)
  {
  	 for($col=0;$col<($total_no_cartons-$no_carton_l);$col++)
  	 echo "<td class=xl787179 style='border-left:none'>&nbsp;</td>";
  
  }
 	
 	
 	?>
 	
 </tr>	
 	
 	<?php
 }
 
 ?>
 
 <?php
 if($a_xl_n>0)
 {
 ?>
 <tr>
 	<td class=xl787179 align='center'>XL</td>
 	<td class=xl787179 style='border-left:none'><?php echo $a_xl_n; ?></td>
 	<td class=xl787179 style='border-left:none'><?php echo $carton_xl;?></td>
 	<?php
 	echo "<td class=xl787179 style='border-left:none'>".$no_carton_xl."</td>";
 if($carton_xl>0)
 {
 	$no_carton_xl=floor($a_xl_n/$carton_xl);
 	  $bal_qty_carton_xl=$a_xl_n%$carton_xl;
 	
 }
 	
 	for($cnt=0;$cnt<$no_carton_xl;$cnt++)
 	{
		echo "<td class=xl787179 style='border-left:none'>".$carton_xl."/".round(($carton_xl/$p_plies),2)."</td>";
	}
 	

  if(  $bal_qty_carton_xl>0)
  {
  	echo "<td class=xl787179 style='border-left:none'>".$bal_qty_carton_xl."/".round(($bal_qty_carton_xl/$p_plies),2)."</td>";
  	$no_carton_xl++;
  	
  }
  
  if($total_no_cartons>$no_carton_xl)
  {
  	 for($col=0;$col<($total_no_cartons-$no_carton_xl);$col++)
  	 echo "<td class=xl787179 style='border-left:none'>&nbsp;</td>";
  
  }
 	
 	
 	?>
 	
 </tr>	
 	
 	<?php
 }
 
 ?>
 
 <!--
 <tr height=20 style='height:15.0pt'>
 <td height=20 class=xl1317179 style='height:15.0pt'></td>
 
 
 
  <td class=xl1317179 colspan=2>XS</td>
  <td class=xl1317179 colspan=2>S</td>
  <td class=xl1317179 colspan=2>M</td>
  <td class=xl1317179 colspan=2>L</td>
  <td class=xl1317179 colspan=2>XL</td>
  <td class=xl157179 >&nbsp;</td>
  <td class=xl157179 >&nbsp;</td>
  <td class=xl157179 >&nbsp;</td>
  <td  class=xl157179>&nbsp;</td>
  <td class=xl157179 >&nbsp;</td>
   <td class=xl157179 >&nbsp;</td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl807179 style='height:15.0pt'>Std. Carton Qty</td>
  <td class=xl787179 colspan=2 ><?php echo $carton_xs; ?></td>
  <td class=xl787179 style='border-left:none' colspan=2><?php echo $carton_s; ?></td>
  <td class=xl787179 style='border-left:none' colspan=2><?php echo $carton_m; ?></td>
  <td class=xl787179 style='border-left:none' colspan=2 ><?php echo $carton_l; ?></td>
  <td class=xl787179 style='border-left:none'colspan=2 ><?php echo $carton_xl; ?></td>
  <td></td>
  <td></td>
  <td></td>
  <td></td>
  <td></td>
  <td></td>
  <td></td>
 </tr>

 
 <tr >
  <td  class=xl807179> Act. Carton Qty </td>
  <td class=xl787179 colspan=2>
  <?php 
  $total_no_cartons=0;
  $no_carton_xs=floor($a_xs_n/$carton_xs);
  $bal_qty_carton_xs=$a_xs_n%$carton_xs;
  
  if($no_carton_xs>0)
  {
  	//echo $carton_xs." X ".$no_carton_xs;
	
	for($i=1;$i<=$no_carton_xs;$i++)
	{
		echo $carton_xs.",";
		if($i%4==0)
		{
			echo "<br/>";
		}
	}
	
  }
  
	 if($bal_qty_carton_xs>0)
  {
  	//echo "<br/>".$bal_qty_carton_xs." X 1";
	echo $bal_qty_carton_xs;
  	$no_carton_xs++;
  }
  
  $total_no_cartons=$total_no_cartons+$no_carton_xs;
  ?>
  	</td>
	
  <td class=xl787179 style='border-left:none' colspan=2>
  <?php 
  $no_carton_s=floor($a_s_n/$carton_s);
  $bal_qty_carton_s=$a_s_n%$carton_s;
  
  if($no_carton_s>0)
  {
  	//echo $carton_s." X ".$no_carton_s;
	
	for($i=1;$i<=$no_carton_s;$i++)
	{
		echo $carton_s.",";
		if($i%4==0)
		{
			echo "<br/>";
		}
	}
	
  }
  
  if($bal_qty_carton_s>0)
  {
  	//echo "<br/>".$bal_qty_carton_s." X 1";
	echo $bal_qty_carton_s;
  	$no_carton_s++;
  }

  $total_no_cartons=$total_no_cartons+$no_carton_s;
  ?>
  
  </td>
  <td class=xl787179 style='border-left:none' colspan=2>
  
  <?php 
  $no_carton_m=floor($a_m_n/$carton_m);
  $bal_qty_carton_m=$a_m_n%$carton_m;
  
  if($no_carton_m>0)
  {
  	//echo $carton_m." X ".$no_carton_m;
	
	for($i=1;$i<=$no_carton_m;$i++)
	{
		echo $carton_m.",";
		if($i%4==0)
		{
			echo "<br/>";
		}
	}
  }
  
  if($bal_qty_carton_m>0)
  {
  	//echo "<br/>".$bal_qty_carton_m." X 1";
	echo $bal_qty_carton_m;
  	$no_carton_m++;
  }

  $total_no_cartons=$total_no_cartons+$no_carton_m;
  ?>	
  </td>
  <td class=xl787179 style='border-left:none' colspan=2>
  <?php 
  $no_carton_l=floor($a_l_n/$carton_l);
  $bal_qty_carton_l=$a_l_n%$carton_l;
  
  if($no_carton_l>0)
  {
  	//echo $carton_l." X ".$no_carton_l;
	for($i=1;$i<=$no_carton_l;$i++)
	{
		echo $carton_l.",";
		if($i%4==0)
		{
			echo "<br/>";
		}
	}
	
  }
  
  if($bal_qty_carton_l>0)
  {
  	//echo "<br/>".$bal_qty_carton_l." X 1";
	echo $bal_qty_carton_l;
  	$no_carton_l++;
  }

  $total_no_cartons=$total_no_cartons+$no_carton_l;
  ?>
  </td>
  <td class=xl787179 style='border-left:none' colspan=2>
  
  <?php 
  $no_carton_xl=floor($a_xl_n/$carton_xl);
  $bal_qty_carton_xl=$a_xl_n%$carton_xl;
  
  if($no_carton_xl>0)
  {
  	//echo $carton_xl." X ".$no_carton_xl;
	
	for($i=1;$i<=$no_carton_xl;$i++)
	{
		echo $carton_xl.",";
		if($i%4==0)
		{
			echo "<br/>";
		}
	}
	
  }
  
  if($bal_qty_carton_xl>0)
  {
  	//echo "<br/>".$bal_qty_carton_xl." X 1";
	echo $bal_qty_carton_xl;
  	$no_carton_xl++;
  }
  
  $total_no_cartons=$total_no_cartons+$no_carton_xl;
  ?>
  	
  </td>
  
  <td></td>
  <td></td>
  <td></td>
  <td></td>
  <td></td>
  <td></td>
  <td></td>

 </tr>
 
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl807179 style='height:15.0pt'>No. Of Cartons </td>
  <td class=xl787179 colspan=2 ><?php echo $no_carton_xs; ?></td>	
  <td class=xl787179 style='border-left:none' colspan=2><?php echo $no_carton_s;  ?></td>
  <td class=xl787179 style='border-left:none' colspan=2><?php echo $no_carton_m;  ?></td>
  <td class=xl787179 style='border-left:none' colspan=2><?php echo $no_carton_l;  ?></td>
  <td class=xl787179 style='border-left:none' colspan=2><?php echo $no_carton_xl; ?></td>
  
  
  <td></td>
  <td></td>
  <td></td>
  <td></td>
  <td></td>
  <td></td>
  <td></td>
 </tr>
 
 <tr height=20 style='height:15.0pt'>
  <td height=20 ></td>
  <td></td>
  <td></td>
  <td></td>
  <td></td>
  <td></td>
  <td></td>
  <td></td>
  <td></td>
  <td></td>
  <td></td>
  <td></td>
  <td></td>
 </tr>
 -->

 
 <tr height=30 style='height:25.0pt'>
  <td height=30 style='height:25.0pt;border-top:none'>&nbsp;</td>
  <td class=xl157179></td>
  <td class=xl157179></td>
  <td class=xl1307179 style='border-top:none'>&nbsp;</td>
  <td class=xl1307179 style='border-top:none'>&nbsp;</td>
  <td class=xl157179></td>
  <td class=xl157179></td>
  <td class=xl1307179 style='border-top:none'>&nbsp;</td>
   <td class=xl1307179 style='border-top:none'>&nbsp;</td>
  <td class=xl157179></td>
  <td class=xl157179></td>
  <td class=xl1307179 style='border-top:none'>&nbsp;</td>
   <td class=xl1307179 style='border-top:none'>&nbsp;</td>
 </tr>
 

 <tr class=xl807179 height=16 style='height:12.0pt'>
  
  <td height=16 class=xl1107179 style='height:12.0pt'></td>
  <td class=xl1107179></td>
  <td class=xl1107179></td>
  <td colspan=2 class=xl1317179>Section QA/Exe</td>
  <td class=xl1107179></td>
  <td class=xl1107179></td>
  <td colspan=2 class=xl1317179>Packing Sup. </td>
  <td class=xl1107179></td>
  <td class=xl1107179></td>
  <td colspan=2 class=xl1317179>Shift Exe. </td>
  <td class=xl1107179></td>
  <td class=xl1107179></td>
 </tr>
</table>

</div>



<!----------------------------->
<!--END OF OUTPUT FROM EXCEL PUBLISH AS WEB PAGE WIZARD-->
<!----------------------------->
<!-- <script type="text/javascript"> setTimeout("Redirect()",0); function Redirect() {  location.href = "transaction_log.php"; }</script> -->
</body>

</html>
