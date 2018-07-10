

<?php include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));?>
<?php include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'/common/config/functions.php',4,'R'));?>
<?php

  function m3_job_exists_check($doc_no,$operation1,$joins_checkbox)
  {
	  include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));
	  //echo $operation1;
	   
    $sql="select sfcs_doc_no from $m3_bulk_ops_rep_db.m3_sfcs_tran_log where sfcs_doc_no='".$doc_no."' and m3_op_des='".$operation1."'";
	//echo $sql;
    $sql_result=mysqli_query($link, $sql) or exit("Sql Error1.6".mysqli_error($GLOBALS["___mysqli_ston"]));
    if(mysqli_num_rows($sql_result)==0 && $joins_checkbox==2)
	{
		$sql1="SELECT GROUP_CONCAT(doc_no SEPARATOR ',') AS doc_no FROM $bai_pro3.plandoc_stat_log WHERE org_doc_no='$doc_no'";
		$sql_result1=mysqli_query($link, $sql1) or exit("error while getting original doc nos");
		while($sql_row=mysqli_fetch_array($sql_result1))
		{
			$original_docs=$sql_row['doc_no'];
		}
		$sql="select sfcs_doc_no from $m3_bulk_ops_rep_db.m3_sfcs_tran_log where sfcs_doc_no IN (".$original_docs.") and m3_op_des='$operation1'";
		$sql_result11=mysqli_query($link, $sql) or exit("Sql Error1.9".mysqli_error($GLOBALS["___mysqli_ston"]));
		return mysqli_num_rows($sql_result11);
	}
	else 
	{
		return mysqli_num_rows($sql_result);
	}
	// return mysqli_num_rows($sql_result);
  }

?>


<?php

if(isset($_POST['confirm']))
{
	$style=$_POST['style'];
	$schedule=$_POST['schedule'];
	$color=$_POST['color'];
  $joins_checkbox=$_POST['joins_checkbox'];
  $check_db=$_POST['check_db'];
	$key_db=$_POST['key_db'];
	$doc_no=$_POST['doc_no'];
	$size_db=$_POST['size_db'];
	$qty_db=$_POST['qty_db'];
	$job_no=$_POST['job_no'];
	
	// var_dump($check_db);
	// echo 'check bd: '.$check_db;
	if (empty($check_db))
	{
		echo "<script>sweetAlert('Error','Please Select atleast one check box','error')</script>";
	} else {
		for($i=0;$i<sizeof($doc_no);$i++)
		{
			if($check_db[$i]>0)
			{
				//echo $key_db[$i];
				$key=$key_db[$i];
			}
			
			if($doc_no[$i]==$key)
			{				
				if($joins_checkbox==2)
				{
          $color = array();
				  $original_docs = array();
					$joins_check_query = "SELECT pc.doc_no, db.order_col_des 
					FROM $bai_pro3.plandoc_stat_log pc
					LEFT JOIN $bai_pro3.bai_orders_db_confirm db ON pc.order_tid=db.order_tid 
					WHERE pc.org_doc_no='$key'";
					// $joins_check_query = "select doc_no from plandoc_stat_log where org_doc_no='$key'";
					// echo '<br>'.$joins_check_query;
					$Oiginal_doc_result=mysqli_query($link, $joins_check_query) or exit("Error while getting original Doc No's");
					while($sql_row=mysqli_fetch_array($Oiginal_doc_result))
					{
						$color[]=$sql_row['order_col_des'];
						$original_docs[]=$sql_row['doc_no'];
					}
					// var_dump($original_docs);
					for($i=0; $i<sizeof($original_docs); $i++)
					{
						$sql="select sfcs_doc_no from $m3_bulk_ops_rep_db.m3_sfcs_tran_log where sfcs_doc_no='$original_docs[$i]' and m3_op_des='LAY' and sfcs_size='".$size_db[$i]."' and sfcs_job_no='".$job_no[$i]."'";
						// echo '<br>m3_tran_log= '.$sql;
						$sql_result=mysqli_query($link, $sql) or exit("Sql Error1.1".mysqli_error($GLOBALS["___mysqli_ston"]));
						if(mysqli_num_rows($sql_result)==0)
						{
							$sql="INSERT INTO $m3_bulk_ops_rep_db.m3_sfcs_tran_log (sfcs_date,sfcs_style,sfcs_schedule,sfcs_color,sfcs_size,sfcs_doc_no,sfcs_qty,sfcs_log_user,m3_op_des,sfcs_tid_ref,sfcs_mod_no,sfcs_shift,sfcs_job_no,sfcs_status,m3_op_code) values 
							(NOW(),'$style','$schedule','$color[$i]','".$size_db[$i]."',$original_docs[$i],".$qty_db[$i].",USER(),'LAY',$original_docs[$i],0,'','".$job_no[$i]."',0,10)";
							// echo '<br>M3_tran_log Query= '.$sql;
							mysqli_query($link, $sql) or exit("Sql Error1.2".mysqli_error($GLOBALS["___mysqli_ston"]));
						}
					}
				}
				else
				{
					//echo $size_db[$i]."-".$qty_db[$i]."-".$job_no[$i]."<br/>";
					$sql="select sfcs_doc_no from $m3_bulk_ops_rep_db.m3_sfcs_tran_log where sfcs_doc_no='$key' and m3_op_des='LAY' and sfcs_size='".$size_db[$i]."' and sfcs_job_no='".$job_no[$i]."'";
					// echo '<br>select from me_tran_log= '.$sql;
					$sql_result=mysqli_query($link, $sql) or exit("Sql Error1.3".mysqli_error($GLOBALS["___mysqli_ston"]));
					
					if(mysqli_num_rows($sql_result)==0)
					{
						$sql="INSERT INTO $m3_bulk_ops_rep_db.m3_sfcs_tran_log (sfcs_date,sfcs_style,sfcs_schedule,sfcs_color,sfcs_size,sfcs_doc_no,sfcs_qty,sfcs_log_user,m3_op_des,sfcs_tid_ref,sfcs_mod_no,sfcs_shift,sfcs_job_no,sfcs_status,m3_op_code) values (NOW(),'$style','$schedule','$color','".$size_db[$i]."',$key,".$qty_db[$i].",USER(),'LAY',$key,0,'','".$job_no[$i]."',0,10)";
						// echo '<br>M3_tran_log Query= '.$sql;
						mysqli_query($link, $sql) or exit("Sql Error1.4".mysqli_error($GLOBALS["___mysqli_ston"]));
					}
				}
			}
		}
	}
}

?>

<?php

if(!isset($_REQUEST['order_tid']))
{
	$sql="select distinct order_tid,cat_ref from $bai_pro3.order_cat_doc_mix where order_del_no=\"".$_REQUEST['schedule']."\" and order_col_des='".$_REQUEST['color']."' and category in ($in_categories)";
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error9".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		$order_tid=$sql_row['order_tid'];
		$cat_ref=$sql_row['cat_ref'];
	}
}
else
{
	$order_tid=$_REQUEST['order_tid'];
	$cat_ref=$_REQUEST['cat_ref'];
}

$sizes_db=array("XS","S","M","L","XL","XXL","XXXL",'s01','s02','s03','s04','s05','s06','s07','s08','s09','s10','s11','s12','s13','s14','s15','s16','s17','s18','s19','s20','s21','s22','s23','s24','s25','s26','s27','s28','s29','s30','s31','s32','s33','s34','s35','s36','s37','s38','s39','s40','s41','s42','s43','s44','s45','s46','s47','s48','s49','s50');

?>

<?php

//Sample docket remarks updation
$sql="select * from $bai_pro3.bai_orders_db_remarks where order_tid='$order_tid'";
$sql_result=mysqli_query($link, $sql) or exit("Sql Error8".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row=mysqli_fetch_array($sql_result))
{
  $remarks_x=$sql_row['remarks'];
  
}

$sql="select order_embl_a,order_embl_b,order_embl_c,order_embl_d,order_embl_e,order_embl_f from $bai_pro3.bai_orders_db_confirm where order_tid='$order_tid'";
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
$emb_stat=$emb_a+$emb_b+$emb_c+$emb_d;
//Sample docket remarks updation

$sql="select * from $bai_pro3.bai_orders_db_confirm where order_tid='$order_tid'  AND order_joins<4";
$sql_result=mysqli_query($link, $sql) or exit("Sql Error6".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row=mysqli_fetch_array($sql_result))
{
    $order_joins=$sql_row['order_joins'];
}
// echo 'Order Joins= '.$order_joins.' for Order Tid ='.$order_tid.'';
if ($order_joins=='1') {
    $joins_checkbox=1;
} else if ($order_joins=='2') {
    $joins_checkbox=2;
} else {
    $joins_checkbox=0;
}
$sql_num_confirm=mysqli_num_rows($sql_result);

if($sql_num_confirm>0)
{
	$sql="select * from $bai_pro3.bai_orders_db_confirm where order_tid='$order_tid'";
}
else
{
	$sql="select * from $bai_pro3.bai_orders_db where order_tid='$order_tid'";
}
// mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_result=mysqli_query($link, $sql) or exit("Sql Error5".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_num_=mysqli_num_rows($sql_result);
while($sql_row=mysqli_fetch_array($sql_result))
{
	$style=$sql_row['order_style_no']; //Style
	$color=$sql_row['order_col_des']; //color
	$division=$sql_row['order_div'];
	$delivery=$sql_row['order_del_no']; //Schedule
	$pono=$sql_row['order_po_no']; //po
	$color_code=$sql_row['color_code']; //Color Code
	$orderno=$sql_row['order_no']; 
	  $o_xs=$sql_row['order_s_xs'];
	  $o_s=$sql_row['order_s_s'];
	  $o_m=$sql_row['order_s_m'];
	  $o_l=$sql_row['order_s_l'];
	  $o_xl=$sql_row['order_s_xl'];
	  $o_xxl=$sql_row['order_s_xxl'];
	  $o_xxxl=$sql_row['order_s_xxxl'];
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

	
	//$order_total=$o_xs+$o_s+$o_m+$o_l+$o_xl+$o_xxl+$o_xxxl+$o_s06+$o_s08+$o_s10+$o_s12+$o_s14+$o_s16+$o_s18+$o_s20+$o_s22+$o_s24+$o_s26+$o_s28+$o_s30;
	$order_total = $o_xs+$o_s+$o_m+$o_l+$o_xl+$o_xxl+$o_xxxl+$o_s01+$o_s02+$o_s03+$o_s04+$o_s05+$o_s06+$o_s07+$o_s08+$o_s09+$o_s10+$o_s11+$o_s12+$o_s13+$o_s14+$o_s15+$o_s16+$o_s17+$o_s18+$o_s19+$o_s20+$o_s21+$o_s22+$o_s23+$o_s24+$o_s25+$o_s26+$o_s27+$o_s28+$o_s29+$o_s30+$o_s31+$o_s32+$o_s33+$o_s34+$o_s35+$o_s36+$o_s37+$o_s38+$o_s39+$o_s40+$o_s41+$o_s42+$o_s43+$o_s44+$o_s45+$o_s46+$o_s47+$o_s48+$o_s49+$o_s50;



	
	
	$order_amend=$sql_row['order_no'];
	
	$order_date=$sql_row['order_date'];
	$order_joins=$sql_row['order_joins'];
	$order_no=$sql_row['order_no'];
	
	if($order_no==1)
	{
		$old_xs=$sql_row['old_order_s_xs'];
		$old_s=$sql_row['old_order_s_s'];
		$old_m=$sql_row['old_order_s_m'];
		$old_l=$sql_row['old_order_s_l'];
		$old_xl=$sql_row['old_order_s_xl'];
		$old_xxl=$sql_row['old_order_s_xxl'];
		$old_xxxl=$sql_row['old_order_s_xxxl'];
		
		$old_s01=$sql_row['old_order_s_s01'];
		$old_s02=$sql_row['old_order_s_s02'];
		$old_s03=$sql_row['old_order_s_s03'];
		$old_s04=$sql_row['old_order_s_s04'];
		$old_s05=$sql_row['old_order_s_s05'];
		$old_s06=$sql_row['old_order_s_s06'];
		$old_s07=$sql_row['old_order_s_s07'];
		$old_s08=$sql_row['old_order_s_s08'];
		$old_s09=$sql_row['old_order_s_s09'];
		$old_s10=$sql_row['old_order_s_s10'];
		$old_s11=$sql_row['old_order_s_s11'];
		$old_s12=$sql_row['old_order_s_s12'];
		$old_s13=$sql_row['old_order_s_s13'];
		$old_s14=$sql_row['old_order_s_s14'];
		$old_s15=$sql_row['old_order_s_s15'];
		$old_s16=$sql_row['old_order_s_s16'];
		$old_s17=$sql_row['old_order_s_s17'];
		$old_s18=$sql_row['old_order_s_s18'];
		$old_s19=$sql_row['old_order_s_s19'];
		$old_s20=$sql_row['old_order_s_s20'];
		$old_s21=$sql_row['old_order_s_s21'];
		$old_s22=$sql_row['old_order_s_s22'];
		$old_s23=$sql_row['old_order_s_s23'];
		$old_s24=$sql_row['old_order_s_s24'];
		$old_s25=$sql_row['old_order_s_s25'];
		$old_s26=$sql_row['old_order_s_s26'];
		$old_s27=$sql_row['old_order_s_s27'];
		$old_s28=$sql_row['old_order_s_s28'];
		$old_s29=$sql_row['old_order_s_s29'];
		$old_s30=$sql_row['old_order_s_s30'];
		$old_s31=$sql_row['old_order_s_s31'];
		$old_s32=$sql_row['old_order_s_s32'];
		$old_s33=$sql_row['old_order_s_s33'];
		$old_s34=$sql_row['old_order_s_s34'];
		$old_s35=$sql_row['old_order_s_s35'];
		$old_s36=$sql_row['old_order_s_s36'];
		$old_s37=$sql_row['old_order_s_s37'];
		$old_s38=$sql_row['old_order_s_s38'];
		$old_s39=$sql_row['old_order_s_s39'];
		$old_s40=$sql_row['old_order_s_s40'];
		$old_s41=$sql_row['old_order_s_s41'];
		$old_s42=$sql_row['old_order_s_s42'];
		$old_s43=$sql_row['old_order_s_s43'];
		$old_s44=$sql_row['old_order_s_s44'];
		$old_s45=$sql_row['old_order_s_s45'];
		$old_s46=$sql_row['old_order_s_s46'];
		$old_s47=$sql_row['old_order_s_s47'];
		$old_s48=$sql_row['old_order_s_s48'];
		$old_s49=$sql_row['old_order_s_s49'];
		$old_s50=$sql_row['old_order_s_s50'];
    
		
		$old_order_total=$old_xs+$old_s+$old_m+$old_l+$old_xl+$old_xxl+$old_xxxl+$old_s01+$old_s02+$old_s03+$old_s04+$old_s05+$old_s06+$old_s07+$old_s08+$old_s09+$old_s10+$old_s11+$old_s12+$old_s13+$old_s14+$old_s15+$old_s16+$old_s17+$old_s18+$old_s19+$old_s20+$old_s21+$old_s22+$old_s23+$old_s24+$old_s25+$old_s26+$old_s27+$old_s28+$old_s29+$old_s30+$old_s31+$old_s32+$old_s33+$old_s34+$old_s35+$old_s36+$old_s37+$old_s38+$old_s39+$old_s40+$old_s41+$old_s42+$old_s43+$old_s44+$old_s45+$old_s46+$old_s47+$old_s48+$old_s49+$old_s50;
	}
	else
	{
		$old_xs=$sql_row['order_s_xs'];
		$old_s=$sql_row['order_s_s'];
		$old_m=$sql_row['order_s_m'];
		$old_l=$sql_row['order_s_l'];
		$old_xl=$sql_row['order_s_xl'];
		$old_xxl=$sql_row['order_s_xxl'];
		$old_xxxl=$sql_row['order_s_xxxl'];
		
		$old_s01=$sql_row['order_s_s01'];
		$old_s02=$sql_row['order_s_s02'];
		$old_s03=$sql_row['order_s_s03'];
		$old_s04=$sql_row['order_s_s04'];
		$old_s05=$sql_row['order_s_s05'];
		$old_s06=$sql_row['order_s_s06'];
		$old_s07=$sql_row['order_s_s07'];
		$old_s08=$sql_row['order_s_s08'];
		$old_s09=$sql_row['order_s_s09'];
		$old_s10=$sql_row['order_s_s10'];
		$old_s11=$sql_row['order_s_s11'];
		$old_s12=$sql_row['order_s_s12'];
		$old_s13=$sql_row['order_s_s13'];
		$old_s14=$sql_row['order_s_s14'];
		$old_s15=$sql_row['order_s_s15'];
		$old_s16=$sql_row['order_s_s16'];
		$old_s17=$sql_row['order_s_s17'];
		$old_s18=$sql_row['order_s_s18'];
		$old_s19=$sql_row['order_s_s19'];
		$old_s20=$sql_row['order_s_s20'];
		$old_s21=$sql_row['order_s_s21'];
		$old_s22=$sql_row['order_s_s22'];
		$old_s23=$sql_row['order_s_s23'];
		$old_s24=$sql_row['order_s_s24'];
		$old_s25=$sql_row['order_s_s25'];
		$old_s26=$sql_row['order_s_s26'];
		$old_s27=$sql_row['order_s_s27'];
		$old_s28=$sql_row['order_s_s28'];
		$old_s29=$sql_row['order_s_s29'];
		$old_s30=$sql_row['order_s_s30'];
		$old_s31=$sql_row['order_s_s31'];
		$old_s32=$sql_row['order_s_s32'];
		$old_s33=$sql_row['order_s_s33'];
		$old_s34=$sql_row['order_s_s34'];
		$old_s35=$sql_row['order_s_s35'];
		$old_s36=$sql_row['order_s_s36'];
		$old_s37=$sql_row['order_s_s37'];
		$old_s38=$sql_row['order_s_s38'];
		$old_s39=$sql_row['order_s_s39'];
		$old_s40=$sql_row['order_s_s40'];
		$old_s41=$sql_row['order_s_s41'];
		$old_s42=$sql_row['order_s_s42'];
		$old_s43=$sql_row['order_s_s43'];
		$old_s44=$sql_row['order_s_s44'];
		$old_s45=$sql_row['order_s_s45'];
		$old_s46=$sql_row['order_s_s46'];
		$old_s47=$sql_row['order_s_s47'];
		$old_s48=$sql_row['order_s_s48'];
		$old_s49=$sql_row['order_s_s49'];
		$old_s50=$sql_row['order_s_s50'];
		
			
		$old_order_total=$old_xs+$old_s+$old_m+$old_l+$old_xl+$old_xxl+$old_xxxl+$old_s01+$old_s02+$old_s03+$old_s04+$old_s05+$old_s06+$old_s07+$old_s08+$old_s09+$old_s10+$old_s11+$old_s12+$old_s13+$old_s14+$old_s15+$old_s16+$old_s17+$old_s18+$old_s19+$old_s20+$old_s21+$old_s22+$old_s23+$old_s24+$old_s25+$old_s26+$old_s27+$old_s28+$old_s29+$old_s30+$old_s31+$old_s32+$old_s33+$old_s34+$old_s35+$old_s36+$old_s37+$old_s38+$old_s39+$old_s40+$old_s41+$old_s42+$old_s43+$old_s44+$old_s45+$old_s46+$old_s47+$old_s48+$old_s49+$old_s50;
	}
}

$join_xs=0;
$join_s=0;
$join_schedule="";
$join_check=0;

if($order_joins!="0")
{
	$sql="select * from $bai_pro3.bai_orders_db where order_tid='$order_joins'";
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error55".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		$join_xs=$sql_row['order_s_xs'];
		$join_s=$sql_row['order_s_s'];
		$join_schedule=$sql_row['order_del_no'].chr($sql_row['color_code']);
	}
	$join_check=1;
}
	
//$sql="select * from cat_stat_log where order_tid='$order_tid' and tid'cat_ref";
$sql="select * from $bai_pro3.cat_stat_log where tid='$cat_ref'";
//echo $old_order_total;
$sql_result=mysqli_query($link, $sql) or exit("Sql Error66".mysqli_error($GLOBALS["___mysqli_ston"]));
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


$sql="select * from $bai_pro3.cuttable_stat_log where cat_id='$cid' and order_tid='$order_tid'";
$sql_result=mysqli_query($link, $sql) or exit("Sql Error77".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row=mysqli_fetch_array($sql_result))
{
	$excess=$sql_row['cuttable_percent'];
}

//EMB Status
//$sql="select SUBSTRING_INDEX(color_size,\"/\",1) as \"graphic\",po_no from bai_emb_db where gmt_style=\"$style\" and schedule=\"$delivery\" and gmt_color=\"%$color%\" and mo_type=\"MO\"";
$sql="select SUBSTRING_INDEX(color_size,\"/\",1) as \"graphic\",po_no from $bai_pro3.bai_emb_db where gmt_style=\"$style\" and schedule=\"$delivery\" and mo_type=\"MO\"";
//echo $sql;
$sql_result=mysqli_query($link, $sql) or exit("Sql Error88".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row=mysqli_fetch_array($sql_result))
{
	$graphic_no=$sql_row['graphic'];
	$pono=$sql_row['po_no'];
}
//EMB Status

$sql="select sum(allocate_xs*plies) as \"cuttable_s_xs\", sum(allocate_s*plies) as \"cuttable_s_s\", sum(allocate_m*plies) as \"cuttable_s_m\", sum(allocate_l*plies) as \"cuttable_s_l\", sum(allocate_xl*plies) as \"cuttable_s_xl\", sum(allocate_xxl*plies) as \"cuttable_s_xxl\", sum(allocate_xxxl*plies) as \"cuttable_s_xxxl\", sum(allocate_s06*plies) as 'cuttable_s_s06',sum(allocate_s08*plies) as 'cuttable_s_s08',sum(allocate_s10*plies) as 'cuttable_s_s10',sum(allocate_s12*plies) as 'cuttable_s_s12',sum(allocate_s14*plies) as 'cuttable_s_s14',sum(allocate_s16*plies) as 'cuttable_s_s16',sum(allocate_s18*plies) as 'cuttable_s_s18',sum(allocate_s20*plies) as 'cuttable_s_s20',sum(allocate_s22*plies) as 'cuttable_s_s22',sum(allocate_s24*plies) as 'cuttable_s_s24',sum(allocate_s26*plies) as 'cuttable_s_s26',sum(allocate_s28*plies) as 'cuttable_s_s28',sum(allocate_s30*plies) as 'cuttable_s_s30' from $bai_pro3.allocate_stat_log where order_tid='$order_tid' and cat_ref='$cat_ref'";
// mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_result=mysqli_query($link, $sql) or exit("Sql Error99".mysqli_error($GLOBALS["___mysqli_ston"]));
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
	
	$c_s01=$sql_row['cuttable_s_s01'];
	  $c_s02=$sql_row['cuttable_s_s02'];
	  $c_s03=$sql_row['cuttable_s_s03'];
	  $c_s04=$sql_row['cuttable_s_s04'];
	  $c_s05=$sql_row['cuttable_s_s05'];
	  $c_s06=$sql_row['cuttable_s_s06'];
	  $c_s07=$sql_row['cuttable_s_s07'];
	  $c_s08=$sql_row['cuttable_s_s08'];
	  $c_s09=$sql_row['cuttable_s_s09'];
	  $c_s10=$sql_row['cuttable_s_s10'];
	  $c_s11=$sql_row['cuttable_s_s11'];
	  $c_s12=$sql_row['cuttable_s_s12'];
	  $c_s13=$sql_row['cuttable_s_s13'];
	  $c_s14=$sql_row['cuttable_s_s14'];
	  $c_s15=$sql_row['cuttable_s_s15'];
	  $c_s16=$sql_row['cuttable_s_s16'];
	  $c_s17=$sql_row['cuttable_s_s17'];
	  $c_s18=$sql_row['cuttable_s_s18'];
	  $c_s19=$sql_row['cuttable_s_s19'];
	  $c_s20=$sql_row['cuttable_s_s20'];
	  $c_s21=$sql_row['cuttable_s_s21'];
	  $c_s22=$sql_row['cuttable_s_s22'];
	  $c_s23=$sql_row['cuttable_s_s23'];
	  $c_s24=$sql_row['cuttable_s_s24'];
	  $c_s25=$sql_row['cuttable_s_s25'];
	  $c_s26=$sql_row['cuttable_s_s26'];
	  $c_s27=$sql_row['cuttable_s_s27'];
	  $c_s28=$sql_row['cuttable_s_s28'];
	  $c_s29=$sql_row['cuttable_s_s29'];
	  $c_s30=$sql_row['cuttable_s_s30'];
	  $c_s31=$sql_row['cuttable_s_s31'];
	  $c_s32=$sql_row['cuttable_s_s32'];
	  $c_s33=$sql_row['cuttable_s_s33'];
	  $c_s34=$sql_row['cuttable_s_s34'];
	  $c_s35=$sql_row['cuttable_s_s35'];
	  $c_s36=$sql_row['cuttable_s_s36'];
	  $c_s37=$sql_row['cuttable_s_s37'];
	  $c_s38=$sql_row['cuttable_s_s38'];
	  $c_s39=$sql_row['cuttable_s_s39'];
	  $c_s40=$sql_row['cuttable_s_s40'];
	  $c_s41=$sql_row['cuttable_s_s41'];
	  $c_s42=$sql_row['cuttable_s_s42'];
	  $c_s43=$sql_row['cuttable_s_s43'];
	  $c_s44=$sql_row['cuttable_s_s44'];
	  $c_s45=$sql_row['cuttable_s_s45'];
	  $c_s46=$sql_row['cuttable_s_s46'];
	  $c_s47=$sql_row['cuttable_s_s47'];
	  $c_s48=$sql_row['cuttable_s_s48'];
	  $c_s49=$sql_row['cuttable_s_s49'];
	  $c_s50=$sql_row['cuttable_s_s50'];
  
	
	$cuttable_total=$c_xs+$c_s+$c_m+$c_l+$c_xl+$c_xxl+$c_xxxl+$c_s01+$c_s02+$c_s03+$c_s04+$c_s05+$c_s06+$c_s07+$c_s08+$c_s09+$c_s10+$c_s11+$c_s12+$c_s13+$c_s14+$c_s15+$c_s16+$c_s17+$c_s18+$c_s19+$c_s20+$c_s21+$c_s22+$c_s23+$c_s24+$c_s25+$c_s26+$c_s27+$c_s28+$c_s29+$c_s30+$c_s31+$c_s32+$c_s33+$c_s34+$c_s35+$c_s36+$c_s37+$c_s38+$c_s39+$c_s40+$c_s41+$c_s42+$c_s43+$c_s44+$c_s45+$c_s46+$c_s47+$c_s48+$c_s49+$c_s50;
}

/* NEW 2010-05-22 */
	
	$newyy=0;
	$new_order_qty=0;
	$sql2="select * from $bai_pro3.maker_stat_log where order_tid='$order_tid' and cat_ref='$cat_ref'  and allocate_ref>0";
	// mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error100".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row2=mysqli_fetch_array($sql_result2))
	{
		$mk_new_length=$sql_row2['mklength'];
		$new_allocate_ref=$sql_row2['allocate_ref'];
		
		$sql22="select * from $bai_pro3.allocate_stat_log where tid='$new_allocate_ref'";
		// mysqli_query($link, $sql22) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		$sql_result22=mysqli_query($link, $sql22) or exit("Sql Error101".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row22=mysqli_fetch_array($sql_result22))
		{
			$new_plies=$sql_row22['plies'];
		}
		$newyy=$newyy+($mk_new_length*$new_plies);
	}
	
	
	$sql="select * from $bai_pro3.bai_orders_db_confirm where order_tid='$order_tid'";
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error102".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_num_confirm=mysqli_num_rows($sql_result);

	if($sql_num_confirm>0)
	{
		$sql2="select (order_s_xs+order_s_s+order_s_m+order_s_l+order_s_xl+order_s_xxl+order_s_xxxl+order_s_s01+order_s_s02+order_s_s03+order_s_s04+order_s_s05+order_s_s06+order_s_s07+order_s_s08+order_s_s09+order_s_s10+order_s_s11+order_s_s12+order_s_s13+order_s_s14+order_s_s15+order_s_s16+order_s_s17+order_s_s18+order_s_s19+order_s_s20+order_s_s21+order_s_s22+order_s_s23+order_s_s24+order_s_s25+order_s_s26+order_s_s27+order_s_s28+order_s_s29+order_s_s30+order_s_s31+order_s_s32+order_s_s33+order_s_s34+order_s_s35+order_s_s36+order_s_s37+order_s_s38+order_s_s39+order_s_s40+order_s_s41+order_s_s42+order_s_s43+order_s_s44+order_s_s45+order_s_s46+order_s_s47+order_s_s48+order_s_s49+order_s_s50) as \"sum\" from $bai_pro3.bai_orders_db_confirm where order_tid='$order_tid'";
	}
	else
	{
		$sql2="select (order_s_xs+order_s_s+order_s_m+order_s_l+order_s_xl+order_s_xxl+order_s_xxxl+order_s_s01+order_s_s02+order_s_s03+order_s_s04+order_s_s05+order_s_s06+order_s_s07+order_s_s08+order_s_s09+order_s_s10+order_s_s11+order_s_s12+order_s_s13+order_s_s14+order_s_s15+order_s_s16+order_s_s17+order_s_s18+order_s_s19+order_s_s20+order_s_s21+order_s_s22+order_s_s23+order_s_s24+order_s_s25+order_s_s26+order_s_s27+order_s_s28+order_s_s29+order_s_s30+order_s_s31+order_s_s32+order_s_s33+order_s_s34+order_s_s35+order_s_s36+order_s_s37+order_s_s38+order_s_s39+order_s_s40+order_s_s41+order_s_s42+order_s_s43+order_s_s44+order_s_s45+order_s_s46+order_s_s47+order_s_s48+order_s_s49+order_s_s50) as \"sum\" from $bai_pro3.bai_orders_db where order_tid='$order_tid'";
	}
	
  //echo $sql2;
	// mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error103".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row2=mysqli_fetch_array($sql_result2))
	{
		$new_order_qty=$sql_row2['sum'];
	}
	
	//$newyy2=$newyy/$new_order_qty;
	//if added 1% to order_qty
	if($order_no==1)
	{
    if($old_order_total > 0){
      $newyy2=$newyy/$old_order_total;
    }
	
	}
	else
	{
    if(!empty($newyy)){
      if(!empty($new_order_qty)){
        if($new_order_qty > 0){
          $newyy2=$newyy/$new_order_qty;
        }
      }
    }
    
  }
  
  if(!empty($newyy2)){
    $savings_new=round((($body_yy-$newyy2)/$body_yy)*100,0);
  }
	
	//echo "<td>".$savings_new."%</td>";
	/* NEW 2010-05-22 */

?>

<html xmlns:v="urn:schemas-microsoft-com:vml"
xmlns:o="urn:schemas-microsoft-com:office:office"
xmlns:x="urn:schemas-microsoft-com:office:excel"
xmlns="http://www.w3.org/TR/REC-html40">


<div class="panel panel-primary">
<div class="panel-heading"><b>M3 Lay Reporting interface</b></div>
<div class="panel-body">
<div class="table-responsive">

<meta http-equiv=Content-Type content="text/html; charset=windows-1252">
<meta name=ProgId content=Excel.Sheet>
<meta name=Generator content="Microsoft Excel 12">

<link rel=File-List href="<?= getFullURL($_GET['r'],'../../common/images/filelist.xml','R');?>">

<!--[if !mso]>
<style>
v\:* {behavior:url(#default#VML);}
o\:* {behavior:url(#default#VML);}
x\:* {behavior:url(#default#VML);}
.shape {behavior:url(#default#VML);}
</style>
<![endif]-->

<style id="Book1_29570_Styles">
table
	{mso-displayed-decimal-separator:"\.";
	mso-displayed-thousand-separator:"\,";}
.xl7029570
	{padding:0px;
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
.xl7129570
	{padding:0px;
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
.xl7229570
	{padding:0px;
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
.xl7329570
	{padding:0px;
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
.xl7429570
	{padding:0px;
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
	white-space:nowrap;}
.xl7529570
	{padding:0px;
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
.xl7629570
	{padding:0px;
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
.xl7729570
	{padding:0px;
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
.xl7829570
	{padding:0px;
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
.xl7929570
	{padding:0px;
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
.xl8029570
	{padding:0px;
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
.xl8129570
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:8.0pt;
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
.xl8229570
	{padding:0px;
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
.xl8329570
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:8.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:"Trebuchet MS", sans-serif;
	mso-font-charset:0;
	mso-number-format:General;
	text-align:general;
	vertical-align:bottom;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:normal;}
.xl8429570
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:Arial, sans-serif;
	mso-font-charset:0;
	mso-number-format:0;
	text-align:general;
	vertical-align:bottom;
	border:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl8529570
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:"Trebuchet MS", sans-serif;
	mso-font-charset:0;
	mso-number-format:0;
	text-align:general;
	vertical-align:bottom;
	border:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl8629570
	{padding:0px;
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
	border:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl8729570
	{padding:0px;
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
.xl8829570
	{padding:0px;
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
.xl8929570
	{padding:0px;
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
	border:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl9029570
	{padding:0px;
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
.xl9129570
	{padding:0px;
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
	white-space:nowrap;}
.xl9229570
	{padding:0px;
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
	border-right:none;
	border-bottom:.5pt solid windowtext;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl9329570
	{padding:0px;
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
	border-right:none;
	border-bottom:.5pt solid windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl9429570
	{padding:0px;
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
.xl9529570
	{padding:0px;
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
	border:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl9629570
	{padding:0px;
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
	background:white;
	mso-pattern:black none;
	white-space:nowrap;}
.xl9729570
	{padding:0px;
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
	border-bottom:.5pt solid windowtext;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl9829570
	{padding:0px;
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
.xl9929570
	{padding:0px;
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
.xl10029570
	{padding:0px;
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
	background:white;
	mso-pattern:black none;
	white-space:nowrap;}
.xl10129570
	{padding:0px;
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
.xl10229570
	{padding:0px;
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
	background:white;
	mso-pattern:black none;
	white-space:nowrap;}
.xl10329570
	{padding:0px;
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
	border-bottom:.5pt hairline windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl10429570
	{padding:0px;
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
	border-bottom:2.0pt double windowtext;
	border-left:.5pt solid windowtext;
	background:white;
	mso-pattern:black none;
	white-space:nowrap;}
.xl10529570
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:"Trebuchet MS", sans-serif;
	mso-font-charset:0;
	mso-number-format:0;
	text-align:center;
	vertical-align:bottom;
	border:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl10629570
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:700;
	font-style:normal;
	text-decoration:none;
	font-family:"Trebuchet MS", sans-serif;
	mso-font-charset:0;
	mso-number-format:"\#\,\#\#0";
	text-align:general;
	vertical-align:bottom;
	border:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl10729570
	{padding:0px;
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
	background:white;
	mso-pattern:black none;
	white-space:nowrap;}
.xl10829570
	{padding:0px;
	mso-ignore:padding;
	color:windowtext;
	font-size:10.0pt;
	font-weight:400;
	font-style:normal;
	text-decoration:none;
	font-family:"Trebuchet MS", sans-serif;
	mso-font-charset:0;
	mso-number-format:0%;
	text-align:center;
	vertical-align:bottom;
	border-top:none;
	border-right:none;
	border-bottom:2.0pt double windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}
.xl10929570
	{padding:0px;
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
.xl11029570
	{padding:0px;
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
.xl11129570
	{padding:0px;
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
	border-bottom:.5pt solid windowtext;
	border-left:.5pt solid windowtext;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:normal;}
.xl11229570
	{padding:0px;
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
	
	.xl8414270
	{padding:0px;
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
	.xl9214270
	{padding:0px;
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
	
	background:white;
	mso-pattern:black none;
	white-space:nowrap;}
	.xl9214270x
	{padding:0px;
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
	border-top:.8pt solid windowtext;
	border-right:.5pt solid windowtext;
	border-bottom:.5pt solid windowtext;
	border-left:.5pt solid windowtext;
	background:white;
	mso-pattern:black none;
	white-space:nowrap;}
.xl7214270
	{padding:0px;
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
.xl9214270
	{padding:0px;
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
	background:white;
	mso-pattern:black none;
	white-space:nowrap;}
.xl8914270
	{padding:0px;
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
	border-bottom:.5pt hairline windowtext;
	border-left:none;
	mso-background-source:auto;
	mso-pattern:auto;
	white-space:nowrap;}

body{
	/* zoom:75%; */
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
body { zoom:75%;}
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



<script language="JavaScript">
<!--

//Disable right mouse click Script
//By Maximus (maximus@nsimail.com) w/ mods by DynamicDrive
//For full source code, visit http://www.dynamicdrive.com

var message="Function Disabled!";

///////////////////////////////////
function clickIE4(){
if (event.button==2){
alert(message);
return false;
}
}

function clickNS4(e){
if (document.layers||document.getElementById&&!document.all){
if (e.which==2||e.which==3){
alert(message);
return false;
}
}
}

if (document.layers){
document.captureEvents(Event.MOUSEDOWN);
document.onmousedown=clickNS4;
}
else if (document.all&&!document.getElementById){
document.onmousedown=clickIE4;
}

document.oncontextmenu=new Function("alert(message);return false")

// --> 
</script>

<!--[if !excel]>&nbsp;&nbsp;<![endif]-->
<!--The following information was generated by Microsoft Office Excel's Publish
as Web Page wizard.-->
<!--If the same item is republished from Excel, all information between the DIV
tags will be replaced.-->
<!----------------------------->
<!--START OF OUTPUT FROM EXCEL PUBLISH AS WEB PAGE WIZARD -->
<!----------------------------->

<div id="Book1_29570" align=center x:publishsource="Excel">

<table border=0 cellpadding=0 cellspacing=0 width=5102 class=xl7029570
 style='border-collapse:collapse;table-layout:fixed;width:3829pt'>
 <col class=xl7029570 width=13 style='mso-width-source:userset;mso-width-alt:
 475;width:10pt'>
 <col class=xl7529570 width=70 style='mso-width-source:userset;mso-width-alt:
 2560;width:53pt'>
 <col class=xl7529570 width=53 span=7 style='mso-width-source:userset;
 mso-width-alt:1938;width:40pt'>
 <col class=xl7529570 width=52 span=3 style='mso-width-source:userset;
 mso-width-alt:1901;width:39pt'>
 <col class=xl7529570 width=51 span=2 style='mso-width-source:userset;
 mso-width-alt:1865;width:38pt'>
 <col class=xl7529570 width=61 style='mso-width-source:userset;mso-width-alt:
 2230;width:46pt'>
 <col class=xl7529570 width=67 style='mso-width-source:userset;mso-width-alt:
 2450;width:50pt'>
 <col class=xl7529570 width=51 style='mso-width-source:userset;mso-width-alt:
 1865;width:38pt'>
 <col class=xl7529570 width=48 style='mso-width-source:userset;mso-width-alt:
 1755;width:36pt'>
 <col class=xl7529570 width=58 style='mso-width-source:userset;mso-width-alt:
 2121;width:44pt'>
 <col class=xl7529570 width=48 style='mso-width-source:userset;mso-width-alt:
 1755;width:36pt'>
 <col class=xl7529570 width=59 style='mso-width-source:userset;mso-width-alt:
 2157;width:44pt'>
 <col class=xl7529570 width=64 style='mso-width-source:userset;mso-width-alt:
 2340;width:48pt'>
 <col class=xl7529570 width=48 style='mso-width-source:userset;mso-width-alt:
 1755;width:36pt'>
 <col class=xl7029570 width=48 span=2 style='mso-width-source:userset;
 mso-width-alt:1755;width:36pt'>
 <col class=xl7029570 width=45 span=2 style='mso-width-source:userset;
 mso-width-alt:1645;width:34pt'>
 <col class=xl7029570 width=51 style='mso-width-source:userset;mso-width-alt:
 1865;width:38pt'>
 <col class=xl7029570 width=20 style='mso-width-source:userset;mso-width-alt:
 731;width:15pt'>
 <col class=xl7029570 width=45 style='mso-width-source:userset;mso-width-alt:
 1645;width:34pt'>
 <col class=xl7029570 width=64 span=56 style='width:48pt'>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl7029570 width=13 style='height:15.0pt;width:10pt'></td>
  <td class=xl7529570 width=70 style='width:53pt'></td>
  <td class=xl7529570 width=53 style='width:40pt'></td>
  <td class=xl7529570 width=53 style='width:40pt'></td>
  <td class=xl7529570 width=53 style='width:40pt'></td>
  <td class=xl7529570 width=53 style='width:40pt'></td>
  <td class=xl7529570 width=53 style='width:40pt'></td>
  <td class=xl7529570 width=53 style='width:40pt'></td>
  <td class=xl7529570 width=53 style='width:40pt'></td>
  <td class=xl7529570 width=52 style='width:39pt'></td>
  <td class=xl7529570 width=52 style='width:39pt'></td>
  <td class=xl7529570 width=52 style='width:39pt'></td>
  <td class=xl7529570 width=51 style='width:38pt'></td>
  <td class=xl7529570 width=51 style='width:38pt'></td>
  <td class=xl7529570 width=61 style='width:46pt'></td>
  <td class=xl7529570 width=67 style='width:50pt'></td>
  <td class=xl7529570 width=51 style='width:38pt'></td>
  <td class=xl7529570 width=48 style='width:36pt'></td>
  <td class=xl7529570 width=58 style='width:44pt'></td>
  <td class=xl7529570 width=48 style='width:36pt'></td>
  <td class=xl7529570 width=59 style='width:44pt'></td>
  <td class=xl7529570 width=64 style='width:48pt'></td>
  <td class=xl7529570 width=48 style='width:36pt'></td>
  <td class=xl7029570 width=48 style='width:36pt'></td>
  <td class=xl7029570 width=48 style='width:36pt'></td>
  <td class=xl7029570 width=45 style='width:34pt'></td>
  <td class=xl7029570 width=45 style='width:34pt'></td>
  <td class=xl7029570 width=51 style='width:38pt'></td>
  <td class=xl7029570 width=20 style='width:15pt'></td>
  <td class=xl7029570 width=45 style='width:34pt'></td>
  <td class=xl7029570 width=64 style='width:48pt'></td>
  <td class=xl7029570 width=64 style='width:48pt'></td>
  <td class=xl7029570 width=64 style='width:48pt'></td>
  <td class=xl7029570 width=64 style='width:48pt'></td>
  <td class=xl7029570 width=64 style='width:48pt'></td>
  <td class=xl7029570 width=64 style='width:48pt'></td>
  <td class=xl7029570 width=64 style='width:48pt'></td>
  <td class=xl7029570 width=64 style='width:48pt'></td>
  <td class=xl7029570 width=64 style='width:48pt'></td>
  <td class=xl7029570 width=64 style='width:48pt'></td>
  <td class=xl7029570 width=64 style='width:48pt'></td>
  <td class=xl7029570 width=64 style='width:48pt'></td>
  <td class=xl7029570 width=64 style='width:48pt'></td>
  <td class=xl7029570 width=64 style='width:48pt'></td>
  <td class=xl7029570 width=64 style='width:48pt'></td>
  <td class=xl7029570 width=64 style='width:48pt'></td>
  <td class=xl7029570 width=64 style='width:48pt'></td>
  <td class=xl7029570 width=64 style='width:48pt'></td>
  <td class=xl7029570 width=64 style='width:48pt'></td>
  <td class=xl7029570 width=64 style='width:48pt'></td>
  <td class=xl7029570 width=64 style='width:48pt'></td>
  <td class=xl7029570 width=64 style='width:48pt'></td>
  <td class=xl7029570 width=64 style='width:48pt'></td>
  <td class=xl7029570 width=64 style='width:48pt'></td>
  <td class=xl7029570 width=64 style='width:48pt'></td>
  <td class=xl7029570 width=64 style='width:48pt'></td>
  <td class=xl7029570 width=64 style='width:48pt'></td>
  <td class=xl7029570 width=64 style='width:48pt'></td>
  <td class=xl7029570 width=64 style='width:48pt'></td>
  <td class=xl7029570 width=64 style='width:48pt'></td>
  <td class=xl7029570 width=64 style='width:48pt'></td>
  <td class=xl7029570 width=64 style='width:48pt'></td>
  <td class=xl7029570 width=64 style='width:48pt'></td>
  <td class=xl7029570 width=64 style='width:48pt'></td>
  <td class=xl7029570 width=64 style='width:48pt'></td>
  <td class=xl7029570 width=64 style='width:48pt'></td>
  <td class=xl7029570 width=64 style='width:48pt'></td>
  <td class=xl7029570 width=64 style='width:48pt'></td>
  <td class=xl7029570 width=64 style='width:48pt'></td>
  <td class=xl7029570 width=64 style='width:48pt'></td>
  <td class=xl7029570 width=64 style='width:48pt'></td>
  <td class=xl7029570 width=64 style='width:48pt'></td>
  <td class=xl7029570 width=64 style='width:48pt'></td>
  <td class=xl7029570 width=64 style='width:48pt'></td>
  <td class=xl7029570 width=64 style='width:48pt'></td>
  <td class=xl7029570 width=64 style='width:48pt'></td>
  <td class=xl7029570 width=64 style='width:48pt'></td>
  <td class=xl7029570 width=64 style='width:48pt'></td>
  <td class=xl7029570 width=64 style='width:48pt'></td>
  <td class=xl7029570 width=64 style='width:48pt'></td>
  <td class=xl7029570 width=64 style='width:48pt'></td>
  <td class=xl7029570 width=64 style='width:48pt'></td>
  <td class=xl7029570 width=64 style='width:48pt'></td>
  <td class=xl7029570 width=64 style='width:48pt'></td>
  <td class=xl7029570 width=64 style='width:48pt'></td>
  <td class=xl7029570 width=64 style='width:48pt'></td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl7029570 style='height:15.0pt'></td>
  <td colspan=8 rowspan=3 height=60 class=xl7029570 width=441 style='mso-ignore:
  colspan-rowspan;height:45.0pt;width:333pt'><!--[if gte vml 1]><v:shapetype
   id="_x0000_t75" coordsize="21600,21600" o:spt="75" o:preferrelative="t"
   path="m@4@5l@4@11@9@11@9@5xe" filled="f" stroked="f">
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
  </v:shapetype><v:shape id="Text_x0020_Box_x0020_1" o:spid="_x0000_s1037"
   type="#_x0000_t75" style='position:absolute;margin-left:42.75pt;
   margin-top:18pt;width:277.5pt;height:23.25pt;z-index:1;visibility:visible'
   o:gfxdata="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
ZXYueG1sUEsFBgAAAAAEAAQA9QAAANwGAAAAAA==
">
   <v:imagedata src="Book1_files/BEK_image1.png" o:title="BEK"/>
   <o:lock v:ext="edit" aspectratio="f"/>
   <x:ClientData ObjectType="Pict">
    <x:SizeWithCells/>
    <x:CF>Bitmap</x:CF>
    <x:AutoPict/>
   </x:ClientData>
  </v:shape><v:shape id="Picture_x0020_2" o:spid="_x0000_s1038" type="#_x0000_t75"
   alt="LOGO" style='position:absolute;margin-left:11.25pt;margin-top:6pt;
   width:33pt;height:36.75pt;z-index:2;visibility:visible' o:gfxdata="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
SkZJRgABAQEAYABgAAD/2wBDAAgGBgcGBQgHBwcJCQgKDBQNDAsLDBkSEw8UHRofHh0aHBwgJC4n
ICIsIxwcKDcpLDAxNDQ0Hyc5PTgyPC4zNDL/2wBDAQkJCQwLDBgNDRgyIRwhMjIyMjIyMjIyMjIy
MjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjL/wAARCABCADMDASIAAhEBAxEB
/8QAHwAAAQUBAQEBAQEAAAAAAAAAAAECAwQFBgcICQoL/8QAtRAAAgEDAwIEAwUFBAQAAAF9AQID
AAQRBRIhMUEGE1FhByJxFDKBkaEII0KxwRVS0fAkM2JyggkKFhcYGRolJicoKSo0NTY3ODk6Q0RF
RkdISUpTVFVWV1hZWmNkZWZnaGlqc3R1dnd4eXqDhIWGh4iJipKTlJWWl5iZmqKjpKWmp6ipqrKz
tLW2t7i5usLDxMXGx8jJytLT1NXW19jZ2uHi4+Tl5ufo6erx8vP09fb3+Pn6/8QAHwEAAwEBAQEB
AQEBAQAAAAAAAAECAwQFBgcICQoL/8QAtREAAgECBAQDBAcFBAQAAQJ3AAECAxEEBSExBhJBUQdh
cRMiMoEIFEKRobHBCSMzUvAVYnLRChYkNOEl8RcYGRomJygpKjU2Nzg5OkNERUZHSElKU1RVVldY
WVpjZGVmZ2hpanN0dXZ3eHl6goOEhYaHiImKkpOUlZaXmJmaoqOkpaanqKmqsrO0tba3uLm6wsPE
xcbHyMnK0tPU1dbX2Nna4uPk5ebn6Onq8vP09fb3+Pn6/9oADAMBAAIRAxEAPwD3+iiigDnvF3iF
tA0xGgVGup22RB+i4GSxHfHH4kV5Vd6pqF/KZLu+uJnJz80hwPoBwPwArtfidG2dLm/gHmofYnaR
/I/lXn9efiJPnt0Psslw9KOGjUS9531+djp/DfjG+0y8ihvbl57BmCv5zbmjB/iDHnA9OmOletV8
/bWf5FUszcBR1JPQV73aRPDZwRSvvkSNVZv7xAwTW2Gk2mmedn+Hp05QqQVm73+VtSaiiiuo+eCq
N7rGm6cwS8vreByMhXkAOPp1rL8Z61LouhF7c7bi4cQxv/cyCS35A/iRXkBJZmdmLMxyzE5JPqT3
rnq1+R2R7WW5T9ah7ScrR/M7Lx34hsdWNraWEnnLCxkeUfdyRgAevf8AT3xiaJ4a1LXizWkarChw
00pITPoMZJP0FZFe0eEzCfCmmeRjb5Chsf3/AOP/AMezWEF7abcj2MXU/szCxhRV9bXf3mX4e8C2
2kXSXt1P9quU5QbdqIfUDqT7/pXW0UV2xgoqyPlK+Iq4ifPVd2FFFFUYHK+P9NlvvDwmhBZ7STzm
UdSmCG/LOfwNeUZr6BrnL/wPod/OZvIe3djlvs77Qfw6fkK5q1BzfNE97K82hhqfsqq06NHkOcd6
09I8Q6nogcWNwFjc5aNxuQn1x2P0r1Ow8JaHp3MVhHI5GC8/7w/+PdPwrm/H3h20g09NTsrVIXjc
LMIl2qUPAJA7g4GffnpWLoTguZM9KGb4bFVFQlDR97fkcpeeKdcvmzLqUyD+7C3lgf8AfOP1rT8P
+N7/AE+7jj1G4a5smOHMpy8Y/vBupA7g1ytKsbyssUal5HIVVH8RPAH51kqk073PSqYLDzp+zcEl
6H0BRUNrCbezghZy7RxqhY/xEDGaK9Q/PnvoTUUUUCIrm4jtLWa5mbbFChkc4zhQMmvObz4jTXEz
xpplu9iwKtFOSWdT6kcDPpg/jXoGp2S6lpd1ZM20TxMm7GdpI4P4GvIpvCevQXf2Y6bNI5OA8eCh
993QD64rmryqK3Ke5k9HCVFJ12rra7tobtr4LsvEFquo6RfPbQSMQbeaPeYiDyuQw/DPbHNdHoPg
ix0adbqWVru6T7jsu1U9wvPPuSau+FNGl0PQ0tZ2BnZ2kk2nIBPYfQAfjmturp0opKTWphjMxryl
KlCo3C7S8167v9QooorY8oKKKKACiiigAooooAKKKKAP/9lQSwECLQAUAAYACAAAACEA9L5jXQ4B
AAAaAgAAEwAAAAAAAAAAAAAAAAAAAAAAW0NvbnRlbnRfVHlwZXNdLnhtbFBLAQItABQABgAIAAAA
IQAIwxik1AAAAJMBAAALAAAAAAAAAAAAAAAAAD8BAABfcmVscy8ucmVsc1BLAQItABQABgAIAAAA
IQDG2Z1vRQIAAC0GAAASAAAAAAAAAAAAAAAAADwCAABkcnMvcGljdHVyZXhtbC54bWxQSwECLQAU
AAYACAAAACEAWGCzG7oAAAAiAQAAHQAAAAAAAAAAAAAAAACxBAAAZHJzL19yZWxzL3BpY3R1cmV4
bWwueG1sLnJlbHNQSwECLQAUAAYACAAAACEALkkMcBQBAACIAQAADwAAAAAAAAAAAAAAAACmBQAA
ZHJzL2Rvd25yZXYueG1sUEsBAi0ACgAAAAAAAAAhADhzEd/zBQAA8wUAABUAAAAAAAAAAAAAAAAA
5wYAAGRycy9tZWRpYS9pbWFnZTEuanBlZ1BLBQYAAAAABgAGAIUBAAANDQAAAAA=
">
   <v:imagedata src="Book1_files/BEK_image1.png" o:title="BEK"/>
   <x:ClientData ObjectType="Pict">
    <x:SizeWithCells/>
    <x:CF>Bitmap</x:CF>
    <x:AutoPict/>
   </x:ClientData>
  </v:shape><![endif]--><span style='mso-ignore:vglayout'>
  <table cellpadding=0 cellspacing=0>
   <tr>
    <td width=15 height=8></td>
   </tr>
   <tr>
    <td></td>
    <td><img width=412 height=49 title="<?php echo $plant_name; ?>" src="<?= getFullURL($_GET['r'],'../../common/images/BEK_image1.png','R');?>"
    alt=LOGO v:shapes="Text_x0020_Box_x0020_1 Picture_x0020_2"></td>
    <td width=14></td>
   </tr>
   <tr>
    <td height=3></td>
   </tr>
  </table>
  </span><![endif]><!--[if !mso & vml]><span style='width:330.75pt;height:45.0pt'></span><![endif]--></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7129570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl7029570 style='height:15.0pt'></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td colspan=6 class=xl7229570>Cutting Department | LID: <?php echo $cid; ?> </td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7129570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl7029570 style='height:15.0pt'></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7129570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
 </tr>
 <tr height=9 style='mso-height-source:userset;height:6.75pt'>
  <td height=9 class=xl7029570 style='height:6.75pt'></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7129570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
 </tr>
 <tr height=33 style='mso-height-source:userset;height:24.75pt'>
  <td height=33 class=xl7029570 style='height:24.75pt'></td>
  <td colspan=27 class=xl7329570>M3 Bulk Operation Reporting - Laying</td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7129570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl7029570 style='height:15.0pt'></td>
  <td class=xl7129570>Style :</td>
  <td colspan=3 class=xl7429570><?php echo $style; ?></td>
  <td class=xl7529570></td>
  <td colspan=3 class=xl7129570>Graphic # :</td>
  <td colspan=12 class=xl7429570><?php echo $graphic_no; ?></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td colspan=2 class=xl7629570>Date :</td>
  <td colspan=3 class=xl7429570><?php echo $order_date; ?></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7129570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl7029570 style='height:15.0pt'></td>
  <td class=xl7129570>Sch No :</td>
  <td colspan=3 class=xl7429570><?php echo $delivery.chr($color_code); ?></td>
  <td class=xl7529570></td>
  <td colspan=3 class=xl7129570>Fab Description :</td>
  <td colspan=12 class=xl7729570><?php echo $fab_des; ?></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td colspan=2 class=xl7129570>PO :</td>
  <td colspan=3 class=xl7429570><?php echo $pono; ?></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7129570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl7029570 style='height:15.0pt'></td>
  <td class=xl7129570>Color :</td>
  <td colspan=3 class=xl7429570><?php echo $color; ?></td>
  <td class=xl7529570></td>
  <td colspan=3 class=xl7129570>Fab Code:</td>
  <td colspan=12 class=xl7729570><?php echo $compo_no; ?></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td colspan=2 class=xl7129570>Assortment:</td>
  <td colspan=3 class=xl7729570>&nbsp;</td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7129570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
 </tr>
 <?php
 /*
 <tr height=11 style='mso-height-source:userset;height:8.25pt'>
  <td height=11 class=xl7029570 style='height:8.25pt'></td>
  <td class=xl7129570></td>
  <td class=xl7529570></td>
  <td class=xl7529570></td>
  <td class=xl7529570></td>
  <td class=xl7529570></td>
  <td class=xl7129570></td>
  <td class=xl7129570></td>
  <td class=xl7129570></td>
  <td class=xl7529570></td>
  <td class=xl7529570></td>
  <td class=xl7529570></td>
  <td class=xl7529570></td>
  <td class=xl7529570></td>
  <td class=xl7529570></td>
  <td class=xl7529570></td>
  <td class=xl7529570></td>
  <td class=xl7529570></td>
  <td class=xl7529570></td>
  <td class=xl7529570></td>
  <td class=xl7529570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7129570></td>
  <td class=xl7129570></td>
  <td class=xl7529570></td>
  <td class=xl7529570></td>
  <td class=xl7529570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7129570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
 </tr>
 <tr height=20 style='height:15.0pt'>
  <td height=20 style='height:15.0pt' align=left valign=top><!--[if gte vml 1]><v:shape
   id="Rounded_x0020_Rectangle_x0020_3" o:spid="_x0000_s1039" type="#_x0000_t75"
   style='position:absolute;margin-left:4.5pt;margin-top:8.25pt;width:383.25pt;
   height:130.5pt;z-index:3;visibility:visible;mso-wrap-style:square;
   v-text-anchor:top' o:gfxdata="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
AAQA9QAAAFsGAAAAAA==
" o:insetmode="auto">
   <v:imagedata src="Book1_files/Book1_29570_image004.png" o:title=""/>
   <o:lock v:ext="edit" aspectratio="f"/>
   <x:ClientData ObjectType="Pict">
    <x:SizeWithCells/>
    <x:CF>Bitmap</x:CF>
    <x:AutoPict/>
   </x:ClientData>
  </v:shape><![endif]--><![if !vml]><span style='mso-ignore:vglayout;
  position:absolute;z-index:3;margin-left:6px;margin-top:11px;width:511px;
  height:174px'><img width=511 height=174
  src="Book1_files/Book1_29570_image005.png" v:shapes="Rounded_x0020_Rectangle_x0020_3"></span><![endif]><span
  style='mso-ignore:vglayout2'>
  <table cellpadding=0 cellspacing=0>
   <tr>
    <td height=20 class=xl7029570 width=13 style='height:15.0pt;width:10pt'></td>
   </tr>
  </table>
  </span></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td align=left valign=top><!--[if gte vml 1]><v:shape id="Rounded_x0020_Rectangle_x0020_4"
   o:spid="_x0000_s1040" type="#_x0000_t75" style='position:absolute;
   margin-left:26.25pt;margin-top:6pt;width:156.75pt;height:70.5pt;z-index:4;
   visibility:visible;mso-wrap-style:square;v-text-anchor:top' o:gfxdata="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
" o:insetmode="auto">
   <v:imagedata src="Book1_files/Book1_29570_image006.png" o:title=""/>
   <o:lock v:ext="edit" aspectratio="f"/>
   <x:ClientData ObjectType="Pict">
    <x:SizeWithCells/>
    <x:CF>Bitmap</x:CF>
    <x:AutoPict/>
   </x:ClientData>
  </v:shape><![endif]--><![if !vml]><span style='mso-ignore:vglayout;
  position:absolute;z-index:4;margin-left:35px;margin-top:8px;width:209px;
  height:94px'><img width=209 height=94
  src="Book1_files/Book1_29570_image007.png" v:shapes="Rounded_x0020_Rectangle_x0020_4"></span><![endif]><span
  style='mso-ignore:vglayout2'>
  <table cellpadding=0 cellspacing=0>
   <tr>
    <td height=20 class=xl7529570 width=51 style='height:15.0pt;width:38pt'></td>
   </tr>
  </table>
  </span></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td align=left valign=top><!--[if gte vml 1]><v:shape id="Rounded_x0020_Rectangle_x0020_6"
   o:spid="_x0000_s1042" type="#_x0000_t75" style='position:absolute;
   margin-left:9pt;margin-top:6pt;width:172.5pt;height:70.5pt;z-index:6;
   visibility:visible;mso-wrap-style:square;v-text-anchor:top' o:gfxdata="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
LnhtbFBLBQYAAAAABAAEAPUAAABoBgAAAAA=
" o:insetmode="auto">
   <v:imagedata src="Book1_files/Book1_29570_image008.png" o:title=""/>
   <o:lock v:ext="edit" aspectratio="f"/>
   <x:ClientData ObjectType="Pict">
    <x:SizeWithCells/>
    <x:CF>Bitmap</x:CF>
    <x:AutoPict/>
   </x:ClientData>
  </v:shape><![endif]--><![if !vml]><span style='mso-ignore:vglayout;
  position:absolute;z-index:6;margin-left:12px;margin-top:8px;width:230px;
  height:94px'><img width=230 height=94
  src="Book1_files/Book1_29570_image009.png" v:shapes="Rounded_x0020_Rectangle_x0020_6"></span><![endif]><span
  style='mso-ignore:vglayout2'>
  <table cellpadding=0 cellspacing=0>
   <tr>
    <td height=20 class=xl7029570 width=58 style='height:15.0pt;width:44pt'></td>
   </tr>
  </table>
  </span></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td align=left valign=top><!--[if gte vml 1]><v:shape id="Rounded_x0020_Rectangle_x0020_5"
   o:spid="_x0000_s1041" type="#_x0000_t75" style='position:absolute;
   margin-left:33pt;margin-top:9pt;width:153pt;height:85.5pt;z-index:5;
   visibility:visible;mso-wrap-style:square;v-text-anchor:top' o:gfxdata="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
" o:insetmode="auto">
   <v:imagedata src="Book1_files/Book1_29570_image010.png" o:title=""/>
   <o:lock v:ext="edit" aspectratio="f"/>
   <x:ClientData ObjectType="Pict">
    <x:SizeWithCells/>
    <x:CF>Bitmap</x:CF>
    <x:AutoPict/>
   </x:ClientData>
  </v:shape><![endif]--><![if !vml]><span style='mso-ignore:vglayout;
  position:absolute;z-index:5;margin-left:44px;margin-top:12px;width:204px;
  height:114px'><img width=204 height=114
  src="Book1_files/Book1_29570_image011.png" v:shapes="Rounded_x0020_Rectangle_x0020_5"></span><![endif]><span
  style='mso-ignore:vglayout2'>
  <table cellpadding=0 cellspacing=0>
   <tr>
    <td height=20 class=xl7029570 width=48 style='height:15.0pt;width:36pt'></td>
   </tr>
  </table>
  </span></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7129570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
 </tr>
 <tr class=xl7529570 height=23 style='mso-height-source:userset;height:17.25pt'>
  <td height=23 class=xl7529570 style='height:17.25pt'></td>
  <td class=xl7529570></td>
  <td class=xl7829570>XS(1)</td>
  <td class=xl7829570 style='border-left:none'>S(2)</td>
  <td class=xl7829570 style='border-left:none'>M(3)</td>
  <td class=xl7829570 style='border-left:none'>L(4)</td>
  <td class=xl7829570 style='border-left:none'>XL(5)</td>
  <td class=xl7829570 style='border-left:none'>XXL</td>
  <td class=xl7829570 style='border-left:none'>XXS</td>
  <td class=xl7829570 style='border-left:none'>Total</td>
  <td class=xl7529570></td>
  <td class=xl7529570></td>
  <td class=xl7529570></td>
  <td class=xl7029570></td>
  <td class=xl7529570></td>
  <td class=xl7829570><?php echo $category; ?></td>
  <td class=xl7529570></td>
  <td class=xl7529570></td>
  <td colspan=3 class=xl7929570 style='border-right:.5pt solid black'>Savings %</td>
  <td class=xl7829570 style='border-left:none'><?php echo $savings_new; ?>%</td>
  <td class=xl7529570></td>
  <td class=xl7529570></td>
  <td colspan=3 class=xl7929570 style='border-right:.5pt solid black'>One Gmt
  One Way</td>
  <td class=xl8129570 style='border-left:none'><?php echo $gmtway; ?></td>
  <td class=xl8229570></td>
  <td class=xl7529570></td>
  <td class=xl7529570></td>
  <td class=xl7129570></td>
  <td class=xl7529570></td>
  <td class=xl7529570><span style='mso-spacerun:yes'>��</span></td>
  <td class=xl7529570></td>
  <td class=xl7529570></td>
  <td class=xl7529570></td>
  <td class=xl7529570></td>
  <td class=xl7529570></td>
  <td class=xl7529570></td>
  <td class=xl7529570></td>
  <td class=xl7529570></td>
  <td class=xl7529570></td>
  <td class=xl7529570></td>
  <td class=xl7529570></td>
  <td class=xl7529570></td>
  <td class=xl7529570></td>
  <td class=xl7529570></td>
  <td class=xl7529570></td>
  <td class=xl7529570></td>
  <td class=xl7529570></td>
  <td class=xl7529570></td>
  <td class=xl7529570></td>
  <td class=xl7529570></td>
  <td class=xl7529570></td>
  <td class=xl7529570></td>
  <td class=xl7529570></td>
  <td class=xl7529570></td>
  <td class=xl7529570></td>
  <td class=xl7529570></td>
  <td class=xl7529570></td>
  <td class=xl7529570></td>
  <td class=xl7529570></td>
  <td class=xl7529570></td>
  <td class=xl7529570></td>
  <td class=xl7529570></td>
  <td class=xl7529570></td>
  <td class=xl7529570></td>
  <td class=xl7529570></td>
  <td class=xl7529570></td>
  <td class=xl7529570></td>
  <td class=xl7529570></td>
  <td class=xl7529570></td>
  <td class=xl7529570></td>
  <td class=xl7529570></td>
  <td class=xl7529570></td>
  <td class=xl7529570></td>
  <td class=xl7529570></td>
  <td class=xl7529570></td>
  <td class=xl7529570></td>
  <td class=xl7529570></td>
  <td class=xl7529570></td>
  <td class=xl7529570></td>
  <td class=xl7529570></td>
  <td class=xl7529570></td>
  <td class=xl7529570></td>
 </tr>
 <tr height=21 style='mso-height-source:userset;height:15.75pt'>
  <td height=21 class=xl7029570 style='height:15.75pt'></td>
  <td class=xl8329570 width=70 style='width:53pt'>Order Qty<span
  style='mso-spacerun:yes'>�</span></td>
  <?php
  if($order_amend==1)
  {
  	echo "<td class=xl8429570 style='border-top:none'>$old_xs</td>
  <td class=xl8429570 style='border-top:none;border-left:none'>$old_s</td>
  <td class=xl8429570 style='border-top:none;border-left:none'>$old_m</td>
  <td class=xl8429570 style='border-top:none;border-left:none'>$old_l</td>
  <td class=xl8429570 style='border-top:none;border-left:none'>$old_xl</td>
  <td class=xl8429570 style='border-top:none;border-left:none'>$old_xxl</td>
  <td class=xl8429570 style='border-top:none;border-left:none'>$old_xxxl</td>
  <td class=xl8429570 style='border-top:none;border-left:none'>$old_order_total</td>";
  }
  else
  {
  	echo "<td class=xl8429570 style='border-top:none'>$o_xs</td>
  <td class=xl8429570 style='border-top:none;border-left:none'>$o_s</td>
  <td class=xl8429570 style='border-top:none;border-left:none'>$o_m</td>
  <td class=xl8429570 style='border-top:none;border-left:none'>$o_l</td>
  <td class=xl8429570 style='border-top:none;border-left:none'>$o_xl</td>
  <td class=xl8429570 style='border-top:none;border-left:none'>$o_xxl</td>
  <td class=xl8429570 style='border-top:none;border-left:none'>$o_xxxl</td>
  <td class=xl8429570 style='border-top:none;border-left:none'>$order_total</td>";
  }
  
  ?>
  <td class=xl7029570></td>
  <td class=xl7529570></td>
  <td colspan=3 class=xl7929570 style='border-right:.5pt solid black'>Consumption</td>
  <td class=xl8129570 style='border-top:none;border-left:none'><?php echo $body_yy; ?></td>
  <td class=xl7529570></td>
  <td class=xl7529570></td>
  <td colspan=3 class=xl7929570 style='border-right:.5pt solid black'>CAD
  Consumption</td>
  <td class=xl8129570 style='border-top:none;border-left:none'><?php echo round($newyy2,4); ?></td>
  <td class=xl7029570></td>
  <td class=xl7529570></td>
  <td colspan=3 class=xl7929570 style='border-right:.5pt solid black'>Strip
  Matching</td>
  <td class=xl8129570 style='border-top:none;border-left:none'><?php echo $strip_match; ?></td>
  <td class=xl7529570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7129570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
 </tr>
 <tr height=21 style='mso-height-source:userset;height:15.75pt'>
  <td height=21 class=xl7029570 style='height:15.75pt'></td>
  <?php
  if($order_amend==1)
  {
  	echo "<td class=xl8329570 width=70 style='width:53pt'>Extra Ship</td>
	<td class=xl8429570 style='border-top:none'>$o_xs</td>
  <td class=xl8429570 style='border-top:none;border-left:none'>$o_s</td>
  <td class=xl8429570 style='border-top:none;border-left:none'>$o_m</td>
  <td class=xl8429570 style='border-top:none;border-left:none'>$o_l</td>
  <td class=xl8429570 style='border-top:none;border-left:none'>$o_xl</td>
  <td class=xl8429570 style='border-top:none;border-left:none'>$o_xxl</td>
  <td class=xl8429570 style='border-top:none;border-left:none'>$o_xxxl</td>
  <td class=xl8429570 style='border-top:none;border-left:none'>$order_total</td>";
  }
  else
  {
  	echo "<td class=xl8329570 width=70 style='width:53pt'>($excess%)</td>
  <td class=xl8529570 style='border-top:none'>$c_xs</td>
  <td class=xl8429570 style='border-top:none;border-left:none'>$c_s</td>
  <td class=xl8429570 style='border-top:none;border-left:none'>$c_m</td>
  <td class=xl8429570 style='border-top:none;border-left:none'>$c_l</td>
  <td class=xl8429570 style='border-top:none;border-left:none'>$c_xl</td>
  <td class=xl8429570 style='border-top:none;border-left:none'>$c_xxl</td>
  <td class=xl8429570 style='border-top:none;border-left:none'>$c_xxxl</td>
  <td class=xl8429570 style='border-top:none;border-left:none'>$cuttable_total</td>";
  }
  
  ?>
  <td class=xl7029570></td>
  <td class=xl7529570></td>
  <td colspan=3 class=xl7929570 style='border-right:.5pt solid black'>Material
  Allowed</td>
  <td class=xl8629570 style='border-top:none;border-left:none'><?php echo round(($old_order_total*$body_yy),0); ?></td>
  <td class=xl7529570></td>
  <td class=xl7529570></td>
  <td colspan=3 class=xl7929570 style='border-right:.5pt solid black'>Used
  Yards</td>
  <td class=xl8629570 style='border-top:none;border-left:none'><?php echo round($newyy,0); ?></td>
  <td class=xl7029570></td>
  <td class=xl7529570></td>
  <td colspan=3 class=xl7929570 style='border-right:.5pt solid black'>Gusset
  Sep</td>
  <td class=xl8629570 style='border-top:none;border-left:none'><?php echo $gusset_sep; ?></td>
  <td class=xl8729570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7129570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
 </tr>
  <?php //$excess=round(($cuttable_total/$order_total)*100,0)-100; ?>
 <tr height=20 style='height:15.0pt'>
  <td height=20 class=xl7029570 style='height:15.0pt'></td>
  <td class=xl8329570 width=70 style='width:53pt'>(<?php echo "Excess ".$excess; ?>%)</td>
  <td class=xl8529570 style='border-top:none'><?php echo ($c_xs-$o_xs-$join_xs); ?></td>
  <td class=xl8429570 style='border-top:none;border-left:none'><?php echo ($c_s-$o_s-$join_s); ?></td>
  <td class=xl8429570 style='border-top:none;border-left:none'><?php echo ($c_m-$o_m); ?></td>
  <td class=xl8429570 style='border-top:none;border-left:none'><?php echo ($c_l-$o_l); ?></td>
  <td class=xl8429570 style='border-top:none;border-left:none'><?php echo ($c_xl-$o_xl); ?></td>
  <td class=xl8429570 style='border-top:none;border-left:none'><?php echo ($c_xxl-$o_xxl); ?></td>
  <td class=xl8429570 style='border-top:none;border-left:none'><?php echo ($c_xxxl-$o_xxxl); ?></td>
  <td class=xl8429570 style='border-top:none;border-left:none'><?php echo ($cuttable_total-$order_total) ?></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7529570></td>
  <td class=xl7529570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7529570></td>
  <td colspan=3 class=xl7929570 style='border-right:.5pt solid black'>Pattern
  Version</td>
  <td class=xl8629570 style='border-top:none;border-left:none'><?php echo $patt_ver; ?></td>
  <td class=xl7529570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7129570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
 </tr>
 <tr height=12 style='mso-height-source:userset;height:9.0pt'>
  <td height=12 class=xl7029570 style='height:9.0pt'></td>
  <td class=xl8329570 width=70 style='width:53pt'></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7529570></td>
  <td class=xl7529570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7529570></td>
  <td class=xl7529570></td>
  <td class=xl7529570></td>
  <td class=xl8229570></td>
  <td class=xl8229570></td>
  <td class=xl7529570></td>
  <td class=xl7529570></td>
  <td class=xl7529570></td>
  <td class=xl7529570></td>
  <td class=xl7529570></td>
  <td class=xl7529570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7129570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
 </tr>
 <tr height=20 style='mso-height-source:userset;height:15.0pt;'>
  <td height=20 class=xl7029570 style='height:15.0pt'></td>
  <td class=xl8829570 width=70 style='width:53pt'>Floorsets</td>
 <?php
  if($join_check==1)
  {
  	echo "<td class=xl8929570>$join_xs</td>";
  	echo "<td class=xl8929570 style='border-left:none'>$join_s</td>";
  	echo "<td class=xl8929570 style='border-left:none'>SCH#</td>";
 	echo "<td class=xl8929570 style='border-left:none'>$join_schedule</td>";
  }
  else
  {
  	echo "<td class=xl8929570>&nbsp;</td>";
  	echo "<td class=xl8929570 style='border-left:none'>&nbsp;</td>";
  	echo "<td class=xl8929570 style='border-left:none'>&nbsp;</td>";
 	echo "<td class=xl8929570 style='border-left:none'>&nbsp;</td>";
  }
  
  ?>
  <td class=xl8929570 style='border-left:none'>&nbsp;</td>
  <td class=xl8929570 style='border-left:none'>&nbsp;</td>
  <td class=xl8929570 style='border-left:none'>&nbsp;</td>
  <td class=xl8929570 style='border-left:none'>&nbsp;</td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7529570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl8229570></td>
  <td class=xl8229570></td>
  <td class=xl8229570></td>
  <td class=xl8229570></td>
  <td class=xl8229570></td>
  <td class=xl7529570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7529570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7129570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
 </tr>
 <tr height=10 style='mso-height-source:userset;height:7.5pt'>
  <td height=10 class=xl7029570 style='height:7.5pt'></td>
  <td class=xl8829570 width=70 style='width:53pt'></td>
  <td class=xl9029570></td>
  <td class=xl9029570></td>
  <td class=xl9029570></td>
  <td class=xl9029570></td>
  <td class=xl9029570></td>
  <td class=xl9029570></td>
  <td class=xl9029570></td>
  <td class=xl9029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7529570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl8229570></td>
  <td class=xl8229570></td>
  <td class=xl8229570></td>
  <td class=xl8229570></td>
  <td class=xl8229570></td>
  <td class=xl7529570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7529570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7129570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
 </tr>
 <tr height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl7029570 style='height:15.0pt'></td>
  <td class=xl8829570 width=70 style='width:53pt'>Carton</td>
  <td class=xl8929570></td>
  <td class=xl8929570 style='border-left:none'></td>
  <td class=xl8929570 style='border-left:none'></td>
  <td class=xl8929570 style='border-left:none'></td>
  <td class=xl8929570 style='border-left:none'></td>
  <td class=xl8929570 style='border-left:none'></td>
  <td class=xl8929570 style='border-left:none'></td>
  <td class=xl8929570 style='border-left:none'></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7529570></td>
  
  <!-- <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl8229570></td>
  <td class=xl8229570></td>
  <td class=xl8229570></td>
  <td class=xl8229570></td>
  <td class=xl8229570></td>
  <td class=xl7529570></td> -->
   <?php
  if(strlen($remarks_x)>0)
  {
  	echo "<td class=xl7029570 colspan=10 align=left><strong>Remarks: $remarks_x</strong></td>";
  }
  else
  {
  	echo "<td class=xl7029570 colspan=10 align=left></td>";
  }
  
  ?>

 <?php
  if(($emb_a+$emb_b+$emb_c+$emb_d+$emb_e+$emb_f)>0)
  {
  	$emb_stat=0;
	$emb_title="";
	if($emb_a>0 or $emb_b>0)
	{
		$emb_title="Panel Form";
		$emb_stat=1;
	}
	if($emb_c>0 or $emb_d>0)
	{
		$emb_title="Semi Garment Form";
		$emb_stat=1;
	}
	if($emb_e>0 or $emb_f>0)
	{
		$emb_title="Garment Form";
		//$emb_stat=2;
	}
	
	echo "<td class=xl7029570 colspan=4 align=left><strong>EMB: $emb_title</strong></td>";
  }
  else
  {
  	echo "<td class=xl7029570 colspan=4 align=left></td>";
  }
  
  ?>  
  <!-- <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td> -->
  <td class=xl7529570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7129570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
 </tr>
 <tr height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl7029570 style='height:15.0pt'></td>
  <td class=xl8829570 width=70 style='width:53pt'></td>
  <td class=xl9029570></td>
  <td class=xl9029570></td>
  <td class=xl9029570></td>
  <td class=xl9029570></td>
  <td class=xl9029570></td>
  <td class=xl9029570></td>
  <td class=xl9029570></td>
  <td class=xl9029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7529570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl8229570></td>
  <td class=xl8229570></td>
  <td class=xl8229570></td>
  <td class=xl8229570></td>
  <td class=xl8229570></td>
  <td class=xl7529570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7529570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7129570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
  <td class=xl7029570></td>
 </tr>
*/

?>
<tr class=xl7529570 height=25 style='height:35.0pt'></tr>
 <tr class=xl7529570 height=20 style='mso-height-source:userset;height:15.0pt'>
  <td height=20 class=xl7529570 style='height:15.0pt'></td>
  <td rowspan=2 class=xl9129570 colspan='2' style='border-bottom:.5pt solid black'>Job #</td>
  <td rowspan=2 class=xl9129570 colspan='2' style='border-bottom:.5pt solid black'>Size</td>
  <td rowspan=2 class=xl9129570 colspan='2' style='border-bottom:.5pt solid black'>Quantity</td>
  <td rowspan=2 class=xl9129570 colspan='2' style='border-bottom:.5pt solid black'>Docket #</td>
  <td rowspan=2 class=xl9129570 style='border-bottom:.5pt solid black' colspan='2'>Select</td>
  
 
 </tr>
 <tr class=xl7529570 height=25 style='height:35.0pt'>
  
 </tr>
 <?php  
 
 	
	$ex_xs=0;
	$ex_s=0;
	$ex_m=0;
	$ex_l=0;
	$ex_xl=0;
	$ex_xxl=0;
	$ex_xxxl=0;
	$ex_s01=0;
	$ex_s02=0;
	$ex_s03=0;
	$ex_s04=0;
	$ex_s05=0;
	$ex_s06=0;
	$ex_s07=0;
	$ex_s08=0;
	$ex_s09=0;
	$ex_s10=0;
	$ex_s11=0;
	$ex_s12=0;
	$ex_s13=0;
	$ex_s14=0;
	$ex_s15=0;
	$ex_s16=0;
	$ex_s17=0;
	$ex_s18=0;
	$ex_s19=0;
	$ex_s20=0;
	$ex_s21=0;
	$ex_s22=0;
	$ex_s23=0;
	$ex_s24=0;
	$ex_s25=0;
	$ex_s26=0;
	$ex_s27=0;
	$ex_s28=0;
	$ex_s29=0;
	$ex_s30=0;
	$ex_s31=0;
	$ex_s32=0;
	$ex_s33=0;
	$ex_s34=0;
	$ex_s35=0;
	$ex_s36=0;
	$ex_s37=0;
	$ex_s38=0;
	$ex_s39=0;
	$ex_s40=0;
	$ex_s41=0;
	$ex_s42=0;
	$ex_s43=0;
	$ex_s44=0;
	$ex_s45=0;
	$ex_s46=0;
	$ex_s47=0;
	$ex_s48=0;
	$ex_s49=0;
	$ex_s50=0;

	
	$ex_xs=($c_xs-$o_xs-$join_xs);
	$ex_s=($c_s-$o_s-$join_s);
	$ex_m=($c_m-$o_m);
	$ex_l=($c_l-$o_l);
	$ex_xl=($c_xl-$o_xl);
	$ex_xxl=($c_xxl-$o_xxl);
	$ex_xxxl=($c_xxxl-$o_xxxl);
	
$ex_s01=($c_s01-$o_s01);
  $ex_s02=($c_s02-$o_s02);
  $ex_s03=($c_s03-$o_s03);
  $ex_s04=($c_s04-$o_s04);
  $ex_s05=($c_s05-$o_s05);
  $ex_s06=($c_s06-$o_s06);
  $ex_s07=($c_s07-$o_s07);
  $ex_s08=($c_s08-$o_s08);
  $ex_s09=($c_s09-$o_s09);
  $ex_s10=($c_s10-$o_s10);
  $ex_s11=($c_s11-$o_s11);
  $ex_s12=($c_s12-$o_s12);
  $ex_s13=($c_s13-$o_s13);
  $ex_s14=($c_s14-$o_s14);
  $ex_s15=($c_s15-$o_s15);
  $ex_s16=($c_s16-$o_s16);
  $ex_s17=($c_s17-$o_s17);
  $ex_s18=($c_s18-$o_s18);
  $ex_s19=($c_s19-$o_s19);
  $ex_s20=($c_s20-$o_s20);
  $ex_s21=($c_s21-$o_s21);
  $ex_s22=($c_s22-$o_s22);
  $ex_s23=($c_s23-$o_s23);
  $ex_s24=($c_s24-$o_s24);
  $ex_s25=($c_s25-$o_s25);
  $ex_s26=($c_s26-$o_s26);
  $ex_s27=($c_s27-$o_s27);
  $ex_s28=($c_s28-$o_s28);
  $ex_s29=($c_s29-$o_s29);
  $ex_s30=($c_s30-$o_s30);
  $ex_s31=($c_s31-$o_s31);
  $ex_s32=($c_s32-$o_s32);
  $ex_s33=($c_s33-$o_s33);
  $ex_s34=($c_s34-$o_s34);
  $ex_s35=($c_s35-$o_s35);
  $ex_s36=($c_s36-$o_s36);
  $ex_s37=($c_s37-$o_s37);
  $ex_s38=($c_s38-$o_s38);
  $ex_s39=($c_s39-$o_s39);
  $ex_s40=($c_s40-$o_s40);
  $ex_s41=($c_s41-$o_s41);
  $ex_s42=($c_s42-$o_s42);
  $ex_s43=($c_s43-$o_s43);
  $ex_s44=($c_s44-$o_s44);
  $ex_s45=($c_s45-$o_s45);
  $ex_s46=($c_s46-$o_s46);
  $ex_s47=($c_s47-$o_s47);
  $ex_s48=($c_s48-$o_s48);
  $ex_s49=($c_s49-$o_s49);
  $ex_s50=($c_s50-$o_s50);
  
	
	$qty_db_ex=array(((int)($ex_xs)),((int)($ex_s)),((int)($ex_m)),((int)($ex_l)),((int)($ex_xl)),((int)($ex_xxl)),((int)($ex_xxxl)),((int)($ex_s01)),((int)($ex_s02)),((int)($ex_s03)),((int)($ex_s04)),((int)($ex_s05)),((int)($ex_s06)),((int)($ex_s07)),((int)($ex_s08)),((int)($ex_s09)),((int)($ex_s10)),((int)($ex_s11)),((int)($ex_s12)),((int)($ex_s13)),((int)($ex_s14)),((int)($ex_s15)),((int)($ex_s16)),((int)($ex_s17)),((int)($ex_s18)),((int)($ex_s19)),((int)($ex_s20)),((int)($ex_s21)),((int)($ex_s22)),((int)($ex_s23)),((int)($ex_s24)),((int)($ex_s25)),((int)($ex_s26)),((int)($ex_s27)),((int)($ex_s28)),((int)($ex_s29)),((int)($ex_s30)),((int)($ex_s31)),((int)($ex_s32)),((int)($ex_s33)),((int)($ex_s34)),((int)($ex_s35)),((int)($ex_s36)),((int)($ex_s37)),((int)($ex_s38)),((int)($ex_s39)),((int)($ex_s40)),((int)($ex_s41)),((int)($ex_s42)),((int)($ex_s43)),((int)($ex_s44)),((int)($ex_s45)),((int)($ex_s46)),((int)($ex_s47)),((int)($ex_s48)),((int)($ex_s49)),((int)($ex_s50)));
			
	if($emb_stat>0)
	{
		$qty_db_emb=array(((int)($ex_xs/2)),((int)($ex_s/2)),((int)($ex_m/2)),((int)($ex_l/2)),((int)($ex_xl/2)),((int)($ex_xxl/2)),((int)($ex_xxxl/2)),((int)($ex_s01/2)),((int)($ex_s02/2)),((int)($ex_s03/2)),((int)($ex_s04/2)),((int)($ex_s05/2)),((int)($ex_s06/2)),((int)($ex_s07/2)),((int)($ex_s08/2)),((int)($ex_s09/2)),((int)($ex_s10/2)),((int)($ex_s11/2)),((int)($ex_s12/2)),((int)($ex_s13/2)),((int)($ex_s14/2)),((int)($ex_s15/2)),((int)($ex_s16/2)),((int)($ex_s17/2)),((int)($ex_s18/2)),((int)($ex_s19/2)),((int)($ex_s20/2)),((int)($ex_s21/2)),((int)($ex_s22/2)),((int)($ex_s23/2)),((int)($ex_s24/2)),((int)($ex_s25/2)),((int)($ex_s26/2)),((int)($ex_s27/2)),((int)($ex_s28/2)),((int)($ex_s29/2)),((int)($ex_s30/2)),((int)($ex_s31/2)),((int)($ex_s32/2)),((int)($ex_s33/2)),((int)($ex_s34/2)),((int)($ex_s35/2)),((int)($ex_s36/2)),((int)($ex_s37/2)),((int)($ex_s38/2)),((int)($ex_s39/2)),((int)($ex_s40/2)),((int)($ex_s41/2)),((int)($ex_s42/2)),((int)($ex_s43/2)),((int)($ex_s44/2)),((int)($ex_s45/2)),((int)($ex_s46/2)),((int)($ex_s47/2)),((int)($ex_s48/2)),((int)($ex_s49/2)),((int)($ex_s50/2)));
		
		
		if($input_excess_cut_as_full_input==0) //1-No, 0-Yes 
		{
			$qty_db_zero=array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);
		}
		else
		{
			//$qty_db_zero=array((((int)($ex_xs))-((int)($ex_xs/2))),(((int)($ex_s))-((int)($ex_s/2))),(((int)($ex_m))-((int)($ex_m/2))),(((int)($ex_l))-((int)($ex_l/2))),(((int)($ex_xl))-((int)($ex_xl/2))),(((int)($ex_xxl))-((int)($ex_xxl/2))),(((int)($ex_xxxl))-((int)($ex_xxxl/2))),(((int)($ex_s06))-((int)($ex_s06/2))),(((int)($ex_s08))-((int)($ex_s08/2))),(((int)($ex_s10))-((int)($ex_s10/2))),(((int)($ex_s12))-((int)($ex_s12/2))),(((int)($ex_s14))-((int)($ex_s14/2))),(((int)($ex_s16))-((int)($ex_s16/2))),(((int)($ex_s18))-((int)($ex_s18/2))),(((int)($ex_s20))-((int)($ex_s20/2))),(((int)($ex_s22))-((int)($ex_s22/2))),(((int)($ex_s24))-((int)($ex_s24/2))),(((int)($ex_s26))-((int)($ex_s26/2))),(((int)($ex_s28))-((int)($ex_s28/2))),(((int)($ex_s30))-((int)($ex_s30/2))));
      $qty_db_zero=array((((int)($ex_xs))-((int)($ex_xs/2))),(((int)($ex_s))-((int)($ex_s/2))),(((int)($ex_m))-((int)($ex_m/2))),(((int)($ex_l))-((int)($ex_l/2))),(((int)($ex_xl))-((int)($ex_xl/2))),(((int)($ex_xxl))-((int)($ex_xxl/2))),(((int)($ex_xxxl))-((int)($ex_xxxl/2))),(((int)($ex_s01))-((int)($ex_s01/2))),(((int)($ex_s02))-((int)($ex_s02/2))),(((int)($ex_s03))-((int)($ex_s03/2))),(((int)($ex_s04))-((int)($ex_s04/2))),(((int)($ex_s05))-((int)($ex_s05/2))),(((int)($ex_s06))-((int)($ex_s06/2))),(((int)($ex_s07))-((int)($ex_s07/2))),(((int)($ex_s08))-((int)($ex_s08/2))),(((int)($ex_s09))-((int)($ex_s09/2))),(((int)($ex_s10))-((int)($ex_s10/2))),(((int)($ex_s11))-((int)($ex_s11/2))),(((int)($ex_s12))-((int)($ex_s12/2))),(((int)($ex_s13))-((int)($ex_s13/2))),(((int)($ex_s14))-((int)($ex_s14/2))),(((int)($ex_s15))-((int)($ex_s15/2))),(((int)($ex_s16))-((int)($ex_s16/2))),(((int)($ex_s17))-((int)($ex_s17/2))),(((int)($ex_s18))-((int)($ex_s18/2))),(((int)($ex_s19))-((int)($ex_s19/2))),(((int)($ex_s20))-((int)($ex_s20/2))),(((int)($ex_s21))-((int)($ex_s21/2))),(((int)($ex_s22))-((int)($ex_s22/2))),(((int)($ex_s23))-((int)($ex_s23/2))),(((int)($ex_s24))-((int)($ex_s24/2))),(((int)($ex_s25))-((int)($ex_s25/2))),(((int)($ex_s26))-((int)($ex_s26/2))),(((int)($ex_s27))-((int)($ex_s27/2))),(((int)($ex_s28))-((int)($ex_s28/2))),(((int)($ex_s29))-((int)($ex_s29/2))),(((int)($ex_s30))-((int)($ex_s30/2))),(((int)($ex_s31))-((int)($ex_s31/2))),(((int)($ex_s32))-((int)($ex_s32/2))),(((int)($ex_s33))-((int)($ex_s33/2))),(((int)($ex_s34))-((int)($ex_s34/2))),(((int)($ex_s35))-((int)($ex_s35/2))),(((int)($ex_s36))-((int)($ex_s36/2))),(((int)($ex_s37))-((int)($ex_s37/2))),(((int)($ex_s38))-((int)($ex_s38/2))),(((int)($ex_s39))-((int)($ex_s39/2))),(((int)($ex_s40))-((int)($ex_s40/2))),(((int)($ex_s41))-((int)($ex_s41/2))),(((int)($ex_s42))-((int)($ex_s42/2))),(((int)($ex_s43))-((int)($ex_s43/2))),(((int)($ex_s44))-((int)($ex_s44/2))),(((int)($ex_s45))-((int)($ex_s45/2))),(((int)($ex_s46))-((int)($ex_s46/2))),(((int)($ex_s47))-((int)($ex_s47/2))),(((int)($ex_s48))-((int)($ex_s48/2))),(((int)($ex_s49))-((int)($ex_s49/2))),(((int)($ex_s50))-((int)($ex_s50/2))));
    }
		
	}
	else
	{
		$qty_db_emb=array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);
		
		if($input_excess_cut_as_full_input==0) //1-No, 0-Yes 
		{
			$qty_db_zero=array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);
		}
		else
		{
      $qty_db_ex=array(((int)($ex_xs)),((int)($ex_s)),((int)($ex_m)),((int)($ex_l)),((int)($ex_xl)),((int)($ex_xxl)),((int)($ex_xxxl)),((int)($ex_s01)),((int)($ex_s02)),((int)($ex_s03)),((int)($ex_s04)),((int)($ex_s05)),((int)($ex_s06)),((int)($ex_s07)),((int)($ex_s08)),((int)($ex_s09)),((int)($ex_s10)),((int)($ex_s11)),((int)($ex_s12)),((int)($ex_s13)),((int)($ex_s14)),((int)($ex_s15)),((int)($ex_s16)),((int)($ex_s17)),((int)($ex_s18)),((int)($ex_s19)),((int)($ex_s20)),((int)($ex_s21)),((int)($ex_s22)),((int)($ex_s23)),((int)($ex_s24)),((int)($ex_s25)),((int)($ex_s26)),((int)($ex_s27)),((int)($ex_s28)),((int)($ex_s29)),((int)($ex_s30)),((int)($ex_s31)),((int)($ex_s32)),((int)($ex_s33)),((int)($ex_s34)),((int)($ex_s35)),((int)($ex_s36)),((int)($ex_s37)),((int)($ex_s38)),((int)($ex_s39)),((int)($ex_s40)),((int)($ex_s41)),((int)($ex_s42)),((int)($ex_s43)),((int)($ex_s44)),((int)($ex_s45)),((int)($ex_s46)),((int)($ex_s47)),((int)($ex_s48)),((int)($ex_s49)),((int)($ex_s50)));
			//$qty_db_zero=array(((int)($ex_xs)),((int)($ex_s)),((int)($ex_m)),((int)($ex_l)),((int)($ex_xl)),((int)($ex_xxl)),((int)($ex_xxxl)),((int)($ex_s06)),((int)($ex_s08)),((int)($ex_s10)),((int)($ex_s12)),((int)($ex_s14)),((int)($ex_s16)),((int)($ex_s18)),((int)($ex_s20)),((int)($ex_s22)),((int)($ex_s24)),((int)($ex_s26)),((int)($ex_s28)),((int)($ex_s30)));
		}
	}
	

 	//Form Values //Form Elements
 	echo "<form name=\"input\" method=\"post\" action='#'>";
 	echo "<input type=\"hidden\" name=\"style\" value=\"$style\">";
 	echo "<input type=\"hidden\" name=\"color\" value=\"$color\">";
 	echo "<input type=\"hidden\" name=\"schedule\" value=\"$delivery\">";
 	echo "<input type=\"hidden\" name=\"joins_checkbox\" value=\"$joins_checkbox\">";
 	echo "<input type=\"hidden\" name=\"order_tid\" value='$order_tid'>";
 	echo "<input type=\"hidden\" name=\"cat_ref\" value=\"$cat_ref\">";
 	
 	$t=0;
 	$colspan=" colspan='2'";
	
$sql="select * from $bai_pro3.plandoc_stat_log where order_tid = '$order_tid' and cat_ref='$cat_ref' and remarks=\"Pilot\" order by acutno";
//echo $sql;
// mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_result=mysqli_query($link, $sql) or exit("Sql Error104".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_num_=mysqli_num_rows($sql_result);
while($sql_row=mysqli_fetch_array($sql_result))
{	
	
    $a_xs_tot=0;
    $a_s_tot=0;
    $a_m_tot=0;
    $a_l_tot=0;
    $a_xl_tot=0;
    $a_xxl_tot=0;
    $a_xxxl_tot=0;
    $plies_tot=0;
    $a_s01_tot=0;
    $a_s02_tot=0;
    $a_s03_tot=0;
    $a_s04_tot=0;
    $a_s05_tot=0;
    $a_s06_tot=0;
    $a_s07_tot=0;
    $a_s08_tot=0;
    $a_s09_tot=0;
    $a_s10_tot=0;
    $a_s11_tot=0;
    $a_s12_tot=0;
    $a_s13_tot=0;
    $a_s14_tot=0;
    $a_s15_tot=0;
    $a_s16_tot=0;
    $a_s17_tot=0;
    $a_s18_tot=0;
    $a_s19_tot=0;
    $a_s20_tot=0;
    $a_s21_tot=0;
    $a_s22_tot=0;
    $a_s23_tot=0;
    $a_s24_tot=0;
    $a_s25_tot=0;
    $a_s26_tot=0;
    $a_s27_tot=0;
    $a_s28_tot=0;
    $a_s29_tot=0;
    $a_s30_tot=0;
    $a_s31_tot=0;
    $a_s32_tot=0;
    $a_s33_tot=0;
    $a_s34_tot=0;
    $a_s35_tot=0;
    $a_s36_tot=0;
    $a_s37_tot=0;
    $a_s38_tot=0;
    $a_s39_tot=0;
    $a_s40_tot=0;
    $a_s41_tot=0;
    $a_s42_tot=0;
    $a_s43_tot=0;
    $a_s44_tot=0;
    $a_s45_tot=0;
    $a_s46_tot=0;
    $a_s47_tot=0;
    $a_s48_tot=0;
    $a_s49_tot=0;
    $a_s50_tot=0;
  
	  $plies_tot=0;
	
	
    $a_xs=$sql_row['p_xs'];
    $a_s=$sql_row['p_s'];
    $a_m=$sql_row['p_m'];
    $a_l=$sql_row['p_l'];
    $a_xl=$sql_row['p_xl'];
    $a_xxl=$sql_row['p_xxl'];
    $a_xxxl=$sql_row['p_xxxl'];
    $a_s01=$sql_row['p_s01'];
    $a_s02=$sql_row['p_s02'];
    $a_s03=$sql_row['p_s03'];
    $a_s04=$sql_row['p_s04'];
    $a_s05=$sql_row['p_s05'];
    $a_s06=$sql_row['p_s06'];
    $a_s07=$sql_row['p_s07'];
    $a_s08=$sql_row['p_s08'];
    $a_s09=$sql_row['p_s09'];
    $a_s10=$sql_row['p_s10'];
    $a_s11=$sql_row['p_s11'];
    $a_s12=$sql_row['p_s12'];
    $a_s13=$sql_row['p_s13'];
    $a_s14=$sql_row['p_s14'];
    $a_s15=$sql_row['p_s15'];
    $a_s16=$sql_row['p_s16'];
    $a_s17=$sql_row['p_s17'];
    $a_s18=$sql_row['p_s18'];
    $a_s19=$sql_row['p_s19'];
    $a_s20=$sql_row['p_s20'];
    $a_s21=$sql_row['p_s21'];
    $a_s22=$sql_row['p_s22'];
    $a_s23=$sql_row['p_s23'];
    $a_s24=$sql_row['p_s24'];
    $a_s25=$sql_row['p_s25'];
    $a_s26=$sql_row['p_s26'];
    $a_s27=$sql_row['p_s27'];
    $a_s28=$sql_row['p_s28'];
    $a_s29=$sql_row['p_s29'];
    $a_s30=$sql_row['p_s30'];
    $a_s31=$sql_row['p_s31'];
    $a_s32=$sql_row['p_s32'];
    $a_s33=$sql_row['p_s33'];
    $a_s34=$sql_row['p_s34'];
    $a_s35=$sql_row['p_s35'];
    $a_s36=$sql_row['p_s36'];
    $a_s37=$sql_row['p_s37'];
    $a_s38=$sql_row['p_s38'];
    $a_s39=$sql_row['p_s39'];
    $a_s40=$sql_row['p_s40'];
    $a_s41=$sql_row['p_s41'];
    $a_s42=$sql_row['p_s42'];
    $a_s43=$sql_row['p_s43'];
    $a_s44=$sql_row['p_s44'];
    $a_s45=$sql_row['p_s45'];
    $a_s46=$sql_row['p_s46'];
    $a_s47=$sql_row['p_s47'];
    $a_s48=$sql_row['p_s48'];
    $a_s49=$sql_row['p_s49'];
    $a_s50=$sql_row['p_s50'];
    
	
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
	$a_s01_tot=$a_s01_tot+($a_s01*$plies);
	$a_s02_tot=$a_s02_tot+($a_s02*$plies);
	$a_s03_tot=$a_s03_tot+($a_s03*$plies);
	$a_s04_tot=$a_s04_tot+($a_s04*$plies);
	$a_s05_tot=$a_s05_tot+($a_s05*$plies);
	$a_s06_tot=$a_s06_tot+($a_s06*$plies);
	$a_s07_tot=$a_s07_tot+($a_s07*$plies);
	$a_s08_tot=$a_s08_tot+($a_s08*$plies);
	$a_s09_tot=$a_s09_tot+($a_s09*$plies);
	$a_s10_tot=$a_s10_tot+($a_s10*$plies);
	$a_s11_tot=$a_s11_tot+($a_s11*$plies);
	$a_s12_tot=$a_s12_tot+($a_s12*$plies);
	$a_s13_tot=$a_s13_tot+($a_s13*$plies);
	$a_s14_tot=$a_s14_tot+($a_s14*$plies);
	$a_s15_tot=$a_s15_tot+($a_s15*$plies);
	$a_s16_tot=$a_s16_tot+($a_s16*$plies);
	$a_s17_tot=$a_s17_tot+($a_s17*$plies);
	$a_s18_tot=$a_s18_tot+($a_s18*$plies);
	$a_s19_tot=$a_s19_tot+($a_s19*$plies);
	$a_s20_tot=$a_s20_tot+($a_s20*$plies);
	$a_s21_tot=$a_s21_tot+($a_s21*$plies);
	$a_s22_tot=$a_s22_tot+($a_s22*$plies);
	$a_s23_tot=$a_s23_tot+($a_s23*$plies);
	$a_s24_tot=$a_s24_tot+($a_s24*$plies);
	$a_s25_tot=$a_s25_tot+($a_s25*$plies);
	$a_s26_tot=$a_s26_tot+($a_s26*$plies);
	$a_s27_tot=$a_s27_tot+($a_s27*$plies);
	$a_s28_tot=$a_s28_tot+($a_s28*$plies);
	$a_s29_tot=$a_s29_tot+($a_s29*$plies);
	$a_s30_tot=$a_s30_tot+($a_s30*$plies);
	$a_s31_tot=$a_s31_tot+($a_s31*$plies);
	$a_s32_tot=$a_s32_tot+($a_s32*$plies);
	$a_s33_tot=$a_s33_tot+($a_s33*$plies);
	$a_s34_tot=$a_s34_tot+($a_s34*$plies);
	$a_s35_tot=$a_s35_tot+($a_s35*$plies);
	$a_s36_tot=$a_s36_tot+($a_s36*$plies);
	$a_s37_tot=$a_s37_tot+($a_s37*$plies);
	$a_s38_tot=$a_s38_tot+($a_s38*$plies);
	$a_s39_tot=$a_s39_tot+($a_s39*$plies);
	$a_s40_tot=$a_s40_tot+($a_s40*$plies);
	$a_s41_tot=$a_s41_tot+($a_s41*$plies);
	$a_s42_tot=$a_s42_tot+($a_s42*$plies);
	$a_s43_tot=$a_s43_tot+($a_s43*$plies);
	$a_s44_tot=$a_s44_tot+($a_s44*$plies);
	$a_s45_tot=$a_s45_tot+($a_s45*$plies);
	$a_s46_tot=$a_s46_tot+($a_s46*$plies);
	$a_s47_tot=$a_s47_tot+($a_s47*$plies);
	$a_s48_tot=$a_s48_tot+($a_s48*$plies);
	$a_s49_tot=$a_s49_tot+($a_s49*$plies);
	$a_s50_tot=$a_s50_tot+($a_s50*$plies);

	$plies_tot=$plies_tot+$plies;
	
	//$qty_db=array($a_xs_tot,$a_s_tot,$a_m_tot,$a_l_tot,$a_xl_tot,$a_xxl_tot,$a_xxxl_tot,$a_s06_tot,$a_s08_tot,$a_s10_tot,$a_s12_tot,$a_s14_tot,$a_s16_tot,$a_s18_tot,$a_s20_tot,$a_s22_tot,$a_s24_tot,$a_s26_tot,$a_s28_tot,$a_s30_tot);
    $qty_db=array($a_xs_tot,$a_s_tot,$a_m_tot,$a_l_tot,$a_xl_tot,$a_xxl_tot,$a_xxxl_tot,$a_s01_tot,$a_s02_tot,$a_s03_tot,$a_s04_tot,$a_s05_tot,$a_s06_tot,$a_s07_tot,$a_s08_tot,$a_s09_tot,$a_s10_tot,$a_s11_tot,$a_s12_tot,$a_s13_tot,$a_s14_tot,$a_s15_tot,$a_s16_tot,$a_s17_tot,$a_s18_tot,$a_s19_tot,$a_s20_tot,$a_s21_tot,$a_s22_tot,$a_s23_tot,$a_s24_tot,$a_s25_tot,$a_s26_tot,$a_s27_tot,$a_s28_tot,$a_s29_tot,$a_s30_tot,$a_s31_tot,$a_s32_tot,$a_s33_tot,$a_s34_tot,$a_s35_tot,$a_s36_tot,$a_s37_tot,$a_s38_tot,$a_s39_tot,$a_s40_tot,$a_s41_tot,$a_s42_tot,$a_s43_tot,$a_s44_tot,$a_s45_tot,$a_s46_tot,$a_s47_tot,$a_s48_tot,$a_s49_tot,$a_s50_tot);
			$repeat=0; //Repeat //Form Elements
		 for($m=0;$m<sizeof($qty_db);$m++)
		 {
		 	$check=0;
		 	if($qty_db[$m]>0)
			{

			 echo "<tr class=xl7214270 height=20 style='height:15.0pt; '>";
			  echo "<td height=20 class=xl7214270 style='height:15.0pt'></td>";

			  	  echo "<td class=xl9214270 colspan='2' style='border-top:none'>Pilot($cutno)</td>";
			
				// echo $order_tid;
				// echo $sizes_db[$m];
				//echo "functoin result".ims_sizes($order_tid,'','','',$sizes_db[$m],$link);
			 echo "<td class=xl9214270 colspan='2' style='border-top:none;border-left:none'>".ims_sizes($order_tid,'','','',$sizes_db[$m],$link)."</td>";
			   echo "<td class=xl9214270 colspan='2' style='border-top:none;border-left:none'>".$qty_db[$m]."</td>";
			  echo "<td class=xl9214270 colspan='2' style='border-top:none;border-left:none'>$docketno</td>";
			  echo "<td class=xl9214270 colspan='2' style='border-top:none;border-left:none' $colspan>";
			  	
			  	//Form Elements
			  	if($repeat==0 and m3_job_exists_check($docketno,'LAY',$joins_checkbox)==0)
			  	{
                    if ($joins_checkbox==1) {
                        echo "<font color=\"red\">Splitting Pending</font>";
                    } else {
                         echo "<input type=\"checkbox\" name=\"check_db[$t]\" value=\"1\"><font color=\"red\">Pending</font>";
                    }
					// echo "<input type=\"checkbox\" name=\"check_db[$t]\" value=\"1\"><font color=\"red\">1Pending</font>";
					echo "<input type=\"hidden\" name=\"key_db[$t]\" value=\"$docketno\">";
					$repeat=1;
				}
				else if($repeat==0  and m3_job_exists_check($docketno,'LAY',$joins_checkbox)>0)
				{
				   echo "Reporting Done";
				}
			  	echo "<input type=\"hidden\" name=\"doc_no[$t]\" value=\"$docketno\">";
			  	echo "<input type=\"hidden\" name=\"size_db[$t]\" value=\"".$sizes_db[$m]."\">";
			  	echo "<input type=\"hidden\" name=\"qty_db[$t]\" value=\"".$qty_db[$m]."\">";
			  	echo "<input type=\"hidden\" name=\"job_no[$t]\" value=\"Pilot($cutno)\">";
			  	
			  	$t++;
			  	//Form Elements
			  				  	
			  echo "</td>";
			 
			 
			 
			 echo "</tr>";
		 	}
		 }
 }
 
 
  
$sql="select * from $bai_pro3.plandoc_stat_log where order_tid='$order_tid' and cat_ref='$cat_ref' and remarks=\"Normal\" order by acutno";
// mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_result=mysqli_query($link, $sql) or exit("Sql Error105".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_num_=mysqli_num_rows($sql_result);
while($sql_row=mysqli_fetch_array($sql_result))
{

  $a_xs_tot=0;
  $a_s_tot=0;
  $a_m_tot=0;
  $a_l_tot=0;
  $a_xl_tot=0;
  $a_xxl_tot=0;
  $a_xxxl_tot=0;
  $plies_tot=0;
  $a_s01_tot=0;
  $a_s02_tot=0;
  $a_s03_tot=0;
  $a_s04_tot=0;
  $a_s05_tot=0;
  $a_s06_tot=0;
  $a_s07_tot=0;
  $a_s08_tot=0;
  $a_s09_tot=0;
  $a_s10_tot=0;
  $a_s11_tot=0;
  $a_s12_tot=0;
  $a_s13_tot=0;
  $a_s14_tot=0;
  $a_s15_tot=0;
  $a_s16_tot=0;
  $a_s17_tot=0;
  $a_s18_tot=0;
  $a_s19_tot=0;
  $a_s20_tot=0;
  $a_s21_tot=0;
  $a_s22_tot=0;
  $a_s23_tot=0;
  $a_s24_tot=0;
  $a_s25_tot=0;
  $a_s26_tot=0;
  $a_s27_tot=0;
  $a_s28_tot=0;
  $a_s29_tot=0;
  $a_s30_tot=0;
  $a_s31_tot=0;
  $a_s32_tot=0;
  $a_s33_tot=0;
  $a_s34_tot=0;
  $a_s35_tot=0;
  $a_s36_tot=0;
  $a_s37_tot=0;
  $a_s38_tot=0;
  $a_s39_tot=0;
  $a_s40_tot=0;
  $a_s41_tot=0;
  $a_s42_tot=0;
  $a_s43_tot=0;
  $a_s44_tot=0;
  $a_s45_tot=0;
  $a_s46_tot=0;
  $a_s47_tot=0;
  $a_s48_tot=0;
  $a_s49_tot=0;
  $a_s50_tot=0;

  $plies_tot=0;


  $a_xs=$sql_row['p_xs'];
  $a_s=$sql_row['p_s'];
  $a_m=$sql_row['p_m'];
  $a_l=$sql_row['p_l'];
  $a_xl=$sql_row['p_xl'];
  $a_xxl=$sql_row['p_xxl'];
  $a_xxxl=$sql_row['p_xxxl'];
  $a_s01=$sql_row['p_s01'];
  $a_s02=$sql_row['p_s02'];
  $a_s03=$sql_row['p_s03'];
  $a_s04=$sql_row['p_s04'];
  $a_s05=$sql_row['p_s05'];
  $a_s06=$sql_row['p_s06'];
  $a_s07=$sql_row['p_s07'];
  $a_s08=$sql_row['p_s08'];
  $a_s09=$sql_row['p_s09'];
  $a_s10=$sql_row['p_s10'];
  $a_s11=$sql_row['p_s11'];
  $a_s12=$sql_row['p_s12'];
  $a_s13=$sql_row['p_s13'];
  $a_s14=$sql_row['p_s14'];
  $a_s15=$sql_row['p_s15'];
  $a_s16=$sql_row['p_s16'];
  $a_s17=$sql_row['p_s17'];
  $a_s18=$sql_row['p_s18'];
  $a_s19=$sql_row['p_s19'];
  $a_s20=$sql_row['p_s20'];
  $a_s21=$sql_row['p_s21'];
  $a_s22=$sql_row['p_s22'];
  $a_s23=$sql_row['p_s23'];
  $a_s24=$sql_row['p_s24'];
  $a_s25=$sql_row['p_s25'];
  $a_s26=$sql_row['p_s26'];
  $a_s27=$sql_row['p_s27'];
  $a_s28=$sql_row['p_s28'];
  $a_s29=$sql_row['p_s29'];
  $a_s30=$sql_row['p_s30'];
  $a_s31=$sql_row['p_s31'];
  $a_s32=$sql_row['p_s32'];
  $a_s33=$sql_row['p_s33'];
  $a_s34=$sql_row['p_s34'];
  $a_s35=$sql_row['p_s35'];
  $a_s36=$sql_row['p_s36'];
  $a_s37=$sql_row['p_s37'];
  $a_s38=$sql_row['p_s38'];
  $a_s39=$sql_row['p_s39'];
  $a_s40=$sql_row['p_s40'];
  $a_s41=$sql_row['p_s41'];
  $a_s42=$sql_row['p_s42'];
  $a_s43=$sql_row['p_s43'];
  $a_s44=$sql_row['p_s44'];
  $a_s45=$sql_row['p_s45'];
  $a_s46=$sql_row['p_s46'];
  $a_s47=$sql_row['p_s47'];
  $a_s48=$sql_row['p_s48'];
  $a_s49=$sql_row['p_s49'];
  $a_s50=$sql_row['p_s50'];
	
		
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
$a_s01_tot=$a_s01_tot+($a_s01*$plies);
$a_s02_tot=$a_s02_tot+($a_s02*$plies);
$a_s03_tot=$a_s03_tot+($a_s03*$plies);
$a_s04_tot=$a_s04_tot+($a_s04*$plies);
$a_s05_tot=$a_s05_tot+($a_s05*$plies);
$a_s06_tot=$a_s06_tot+($a_s06*$plies);
$a_s07_tot=$a_s07_tot+($a_s07*$plies);
$a_s08_tot=$a_s08_tot+($a_s08*$plies);
$a_s09_tot=$a_s09_tot+($a_s09*$plies);
$a_s10_tot=$a_s10_tot+($a_s10*$plies);
$a_s11_tot=$a_s11_tot+($a_s11*$plies);
$a_s12_tot=$a_s12_tot+($a_s12*$plies);
$a_s13_tot=$a_s13_tot+($a_s13*$plies);
$a_s14_tot=$a_s14_tot+($a_s14*$plies);
$a_s15_tot=$a_s15_tot+($a_s15*$plies);
$a_s16_tot=$a_s16_tot+($a_s16*$plies);
$a_s17_tot=$a_s17_tot+($a_s17*$plies);
$a_s18_tot=$a_s18_tot+($a_s18*$plies);
$a_s19_tot=$a_s19_tot+($a_s19*$plies);
$a_s20_tot=$a_s20_tot+($a_s20*$plies);
$a_s21_tot=$a_s21_tot+($a_s21*$plies);
$a_s22_tot=$a_s22_tot+($a_s22*$plies);
$a_s23_tot=$a_s23_tot+($a_s23*$plies);
$a_s24_tot=$a_s24_tot+($a_s24*$plies);
$a_s25_tot=$a_s25_tot+($a_s25*$plies);
$a_s26_tot=$a_s26_tot+($a_s26*$plies);
$a_s27_tot=$a_s27_tot+($a_s27*$plies);
$a_s28_tot=$a_s28_tot+($a_s28*$plies);
$a_s29_tot=$a_s29_tot+($a_s29*$plies);
$a_s30_tot=$a_s30_tot+($a_s30*$plies);
$a_s31_tot=$a_s31_tot+($a_s31*$plies);
$a_s32_tot=$a_s32_tot+($a_s32*$plies);
$a_s33_tot=$a_s33_tot+($a_s33*$plies);
$a_s34_tot=$a_s34_tot+($a_s34*$plies);
$a_s35_tot=$a_s35_tot+($a_s35*$plies);
$a_s36_tot=$a_s36_tot+($a_s36*$plies);
$a_s37_tot=$a_s37_tot+($a_s37*$plies);
$a_s38_tot=$a_s38_tot+($a_s38*$plies);
$a_s39_tot=$a_s39_tot+($a_s39*$plies);
$a_s40_tot=$a_s40_tot+($a_s40*$plies);
$a_s41_tot=$a_s41_tot+($a_s41*$plies);
$a_s42_tot=$a_s42_tot+($a_s42*$plies);
$a_s43_tot=$a_s43_tot+($a_s43*$plies);
$a_s44_tot=$a_s44_tot+($a_s44*$plies);
$a_s45_tot=$a_s45_tot+($a_s45*$plies);
$a_s46_tot=$a_s46_tot+($a_s46*$plies);
$a_s47_tot=$a_s47_tot+($a_s47*$plies);
$a_s48_tot=$a_s48_tot+($a_s48*$plies);
$a_s49_tot=$a_s49_tot+($a_s49*$plies);
$a_s50_tot=$a_s50_tot+($a_s50*$plies);

	$plies_tot=$plies_tot+$plies;
	
	unset($qty_db);
	//$qty_db=array($a_xs_tot,$a_s_tot,$a_m_tot,$a_l_tot,$a_xl_tot,$a_xxl_tot,$a_xxxl_tot,$a_s06_tot,$a_s08_tot,$a_s10_tot,$a_s12_tot,$a_s14_tot,$a_s16_tot,$a_s18_tot,$a_s20_tot,$a_s22_tot,$a_s24_tot,$a_s26_tot,$a_s28_tot,$a_s30_tot);
  $qty_db=array($a_xs_tot,$a_s_tot,$a_m_tot,$a_l_tot,$a_xl_tot,$a_xxl_tot,$a_xxxl_tot,$a_s01_tot,$a_s02_tot,$a_s03_tot,$a_s04_tot,$a_s05_tot,$a_s06_tot,$a_s07_tot,$a_s08_tot,$a_s09_tot,$a_s10_tot,$a_s11_tot,$a_s12_tot,$a_s13_tot,$a_s14_tot,$a_s15_tot,$a_s16_tot,$a_s17_tot,$a_s18_tot,$a_s19_tot,$a_s20_tot,$a_s21_tot,$a_s22_tot,$a_s23_tot,$a_s24_tot,$a_s25_tot,$a_s26_tot,$a_s27_tot,$a_s28_tot,$a_s29_tot,$a_s30_tot,$a_s31_tot,$a_s32_tot,$a_s33_tot,$a_s34_tot,$a_s35_tot,$a_s36_tot,$a_s37_tot,$a_s38_tot,$a_s39_tot,$a_s40_tot,$a_s41_tot,$a_s42_tot,$a_s43_tot,$a_s44_tot,$a_s45_tot,$a_s46_tot,$a_s47_tot,$a_s48_tot,$a_s49_tot,$a_s50_tot);
  $check=0;
 		$repeat=0; //Repeat //Form Elements	
		 for($m=0;$m<sizeof($qty_db);$m++)
		 {
		 	$check=0;
		 	if($qty_db[$m]>0)
			{

			
			  
			  //To Show Sub Embellishemnt
			  $qty_show=0;
			  $qty_sub_show=0;
			  if($qty_db_emb[$m]>0)
			  {
			  	$check=1;
			  	if($qty_db_emb[$m]>$qty_db[$m])
			  	{
					$qty_show=0;
					$qty_sub_show=$qty_db[$m];
					$qty_db_emb[$m]=$qty_db_emb[$m]-$qty_db[$m];
					$qty_db[$m]=0;

				}
				else
				{
					if($qty_db_zero[$m]>0)
					{
						$qty_show=0;
					}
					else
					{
						$qty_show=$qty_db[$m]-$qty_db_emb[$m];
					}
					$qty_sub_show=$qty_db_emb[$m];
					
					//KK1116 $qty_db[$m]=0;
					$qty_db[$m]=$qty_db[$m]-$qty_db_emb[$m];
					$qty_db_emb[$m]=0;

				}
				
				if($qty_sub_show>0)
				{
					 echo "<tr class=xl7214270 height=20 style='height:15.0pt; '>";
					  echo "<td height=20 class=xl7214270 style='height:15.0pt'></td>";
					 
					  	  echo "<td class=xl9214270 colspan='2' style='border-top:none'>EMB</td>";
						
					echo "<td class=xl9214270 colspan='2' style='border-top:none;border-left:none'>".ims_sizes($order_tid,'','','',$sizes_db[$m],$link)."</td>";
					 echo "<td class=xl9214270 colspan='2' style='border-top:none;border-left:none'>$qty_sub_show</td>";
					   
					  echo "<td class=xl9214270 colspan='2' style='border-top:none;border-left:none'>$docketno</td>";
					 echo "<td class=xl9214270 colspan='2' style='border-top:none;border-left:none' $colspan>";
			  	
					  	//Form Elements
					  	if($repeat==0  and m3_job_exists_check($docketno,'LAY',$joins_checkbox)==0 )
					  	{
                            if ($joins_checkbox==1) {
                                echo "<font color=\"red\">Splitting Pending</font>";
                            } else {
                                 echo "<input type=\"checkbox\" name=\"check_db[$t]\" value=\"1\"><font color=\"red\">Pending</font>";
                            }
							// echo "<input type=\"checkbox\" name=\"check_db[$t]\" value=\"1\"><font color=\"red\">2Pending</font>";
							echo "<input type=\"hidden\" name=\"key_db[$t]\" value=\"$docketno\">";
							$repeat=1;
						}
						else if($repeat==0  and m3_job_exists_check($docketno,'LAY',$joins_checkbox)>0)
						{
						   echo "Reporting Done";
						}
					  	echo "<input type=\"hidden\" name=\"doc_no[$t]\" value=\"$docketno\">";
					  	echo "<input type=\"hidden\" name=\"size_db[$t]\" value=\"".$sizes_db[$m]."\">";
					  	echo "<input type=\"hidden\" name=\"qty_db[$t]\" value=\"".$qty_sub_show."\">";
					  	echo "<input type=\"hidden\" name=\"job_no[$t]\" value=\"EMB\">";
					  	
					  	$t++;
					  	//Form Elements
					  				  	
					  echo "</td>";
					  
					 
					 
					 echo "</tr>";
					  
				}
				
				if($qty_show>0)
				{
					 echo "<tr class=xl7214270 height=20 style='height:15.0pt; '>";
					  echo "<td height=20 class=xl7214270 style='height:15.0pt'></td>";
					 
					  	  echo "<td class=xl9214270 colspan='2' style='border-top:none'>".chr($color_code).leading_zeros($cutno,3)."</td>";
						
					echo "<td class=xl9214270 colspan='2' style='border-top:none;border-left:none'>".ims_sizes($order_tid,'','','',$sizes_db[$m],$link)."</td>";
					 echo "<td class=xl9214270 colspan='2' style='border-top:none;border-left:none'>$qty_show</td>";
					   
					  echo "<td class=xl9214270 colspan='2' style='border-top:none;border-left:none'>$docketno</td>";
					  echo "<td class=xl9214270 colspan='2' style='border-top:none;border-left:none' $colspan>";
			  	
					  	//Form Elements
					  	if($repeat==0  and m3_job_exists_check($docketno,'LAY',$joins_checkbox)==0)
					  	{
                            if ($joins_checkbox==1) {
                                echo "<font color=\"red\">Splitting Pending</font>";
                            } else {
                                 echo "<input type=\"checkbox\" name=\"check_db[$t]\" value=\"1\"><font color=\"red\">Pending</font>";
                            }
							// echo "<input type=\"checkbox\" name=\"check_db[$t]\" value=\"1\"><font color=\"red\">3Pending</font>";
							echo "<input type=\"hidden\" name=\"key_db[$t]\" value=\"$docketno\">";
							$repeat=1;
						}
						else if($repeat==0  and m3_job_exists_check($docketno,'LAY',$joins_checkbox)>0)
						{
						   echo "Reporting Done";
						}
					  	echo "<input type=\"hidden\" name=\"doc_no[$t]\" value=\"$docketno\">";
					  	echo "<input type=\"hidden\" name=\"size_db[$t]\" value=\"".$sizes_db[$m]."\">";
					  	echo "<input type=\"hidden\" name=\"qty_db[$t]\" value=\"".$qty_show."\">";
					  	echo "<input type=\"hidden\" name=\"job_no[$t]\" value=\"".chr($color_code).leading_zeros($cutno,3)."\">";
					  	
					  	$t++;
					  	//Form Elements
					  				  	
					  echo "</td>";
					  
					 
					 
					 echo "</tr>";
					  
				}			
			  }
			  
			  
			  //To Show Excess
			  $qty_show=0;
			  $qty_sub_show=0;
			  if($qty_db_zero[$m]>0)
			  {
			  	$check=1;
			  	if($qty_db_zero[$m]>$qty_db[$m])
			  	{
					$qty_show=0;
					$qty_sub_show=$qty_db[$m];
					$qty_db_zero[$m]=$qty_db_zero[$m]-$qty_db[$m];
					$qty_db[$m]=0;
				}
				else
				{
					$qty_show=$qty_db[$m]-$qty_db_zero[$m];
					$qty_sub_show=$qty_db_zero[$m];
					$qty_db_zero[$m]=0;
					$qty_db[$m]=0;
				}	
				
				if($qty_sub_show>0)
				{
					 echo "<tr class=xl7214270 height=20 style='height:15.0pt; '>";
					  echo "<td height=20 class=xl7214270 style='height:15.0pt'></td>";
					
					  	  echo "<td class=xl9214270 colspan='2' style='border-top:none'>".chr($color_code)."000</td>";
						
					echo "<td class=xl9214270 colspan='2' style='border-top:none;border-left:none'>".ims_sizes($order_tid,'','','',$sizes_db[$m],$link)."</td>";
					 echo "<td class=xl9214270 colspan='2' style='border-top:none;border-left:none'>$qty_sub_show</td>";
					   
					  echo "<td class=xl9214270 colspan='2' style='border-top:none;border-left:none'>$docketno</td>";
					 echo "<td class=xl9214270 colspan='2' style='border-top:none;border-left:none' $colspan>";
			  	
					  	//Form Elements
					  	if($repeat==0  and m3_job_exists_check($docketno,'LAY',$joins_checkbox)==0)
					  	{
                            if ($joins_checkbox==1) {
                                echo "<font color=\"red\">Splitting Pending</font>";
                            } else {
                                 echo "<input type=\"checkbox\" name=\"check_db[$t]\" value=\"1\"><font color=\"red\">Pending</font>";
                            }
							// echo "<input type=\"checkbox\" name=\"check_db[$t]\" value=\"1\"><font color=\"red\">4Pending</font>";
							echo "<input type=\"hidden\" name=\"key_db[$t]\" value=\"$docketno\">";
							$repeat=1;
						}
						else if($repeat==0  and m3_job_exists_check($docketno,'LAY',$joins_checkbox)>0)
						{
						   echo "Reporting Done";
						}
					  	echo "<input type=\"hidden\" name=\"doc_no[$t]\" value=\"$docketno\">";
					  	echo "<input type=\"hidden\" name=\"size_db[$t]\" value=\"".$sizes_db[$m]."\">";
					  	echo "<input type=\"hidden\" name=\"qty_db[$t]\" value=\"".$qty_sub_show."\">";
					  	echo "<input type=\"hidden\" name=\"job_no[$t]\" value=\"".chr($color_code)."000\">";
					  	
					  	$t++;
					  	//Form Elements
					  				  	
					  echo "</td>";
					 
					 
					 
					 echo "</tr>";
					  
				}
				if($qty_show>0)
				{
					 echo "<tr class=xl7214270 height=20 style='height:15.0pt; '>";
					  echo "<td height=20 class=xl7214270 style='height:15.0pt'></td>";
					 
					  	  echo "<td class=xl9214270 colspan='2' style='border-top:none'>".chr($color_code).leading_zeros($cutno,3)."</td>";
						  
					echo "<td class=xl9214270 colspan='2' style='border-top:none;border-left:none'>".ims_sizes($order_tid,'','','',$sizes_db[$m],$link)."</td>";
					echo "<td class=xl9214270 colspan='2' style='border-top:none;border-left:none'>$qty_show</td>";
					   
					  echo "<td class=xl9214270 colspan='2' style='border-top:none;border-left:none'>$docketno</td>";
					  echo "<td class=xl9214270 colspan='2' style='border-top:none;border-left:none' $colspan>";
			  	
					  	//Form Elements
					  	if($repeat==0  and m3_job_exists_check($docketno,'LAY',$joins_checkbox)==0)
					  	{
                            if ($joins_checkbox==1) {
                                echo "<font color=\"red\">Splitting Pending</font>";
                            } else {
                                 echo "<input type=\"checkbox\" name=\"check_db[$t]\" value=\"1\"><font color=\"red\">Pending</font>";
                            }
							// echo "<input type=\"checkbox\" name=\"check_db[$t]\" value=\"1\"><font color=\"red\">5Pending</font>";
							echo "<input type=\"hidden\" name=\"key_db[$t]\" value=\"$docketno\">";
							$repeat=1;
						}
						else if($repeat==0  and m3_job_exists_check($docketno,'LAY',$joins_checkbox)>0)
						{
						   echo "Reporting Done";
						}
					  	echo "<input type=\"hidden\" name=\"doc_no[$t]\" value=\"$docketno\">";
					  	echo "<input type=\"hidden\" name=\"size_db[$t]\" value=\"".$sizes_db[$m]."\">";
					  	echo "<input type=\"hidden\" name=\"qty_db[$t]\" value=\"".$qty_show."\">";
					  	echo "<input type=\"hidden\" name=\"job_no[$t]\" value=\"".chr($color_code).leading_zeros($cutno,3)."\">";
					  	
					  	$t++;
					  	//Form Elements
					  				  	
					  echo "</td>";
					  
					  
					 
					 echo "</tr>";
					  
				}			
			  }
			  
			 
			 	if($qty_db[$m]>0 and $check==0)
				{
					 echo "<tr class=xl7214270 height=20 style='height:15.0pt; '>";
					  echo "<td height=20 class=xl7214270 style='height:15.0pt'></td>";
					
					  	  echo "<td class=xl9214270 colspan='2' style='border-top:none'>".chr($color_code).leading_zeros($cutno,3)."</td>";
						
					echo "<td class=xl9214270 colspan='2' style='border-top:none;border-left:none'>".ims_sizes($order_tid,'','','',$sizes_db[$m],$link)."</td>";
					 echo "<td class=xl9214270 colspan='2' style='border-top:none;border-left:none'>".$qty_db[$m]."</td>";
					   
					  echo "<td class=xl9214270 colspan='2' style='border-top:none;border-left:none'>$docketno</td>";
					  echo "<td class=xl9214270 colspan='2' style='border-top:none;border-left:none' $colspan>";
			  	
					  	//Form Elements
					  	if($repeat==0  and m3_job_exists_check($docketno,'LAY',$joins_checkbox)==0)
					  	{
                            if ($joins_checkbox==1) {
                                echo "<font color=\"red\">Splitting Pending</font>";
                            } else {
                                 echo "<input type=\"checkbox\" name=\"check_db[$t]\" value=\"1\"><font color=\"red\">Pending</font>";
                            }
							// echo "<input type=\"checkbox\" name=\"check_db[$t]\" value=\"1\"><font color=\"red\">6Pending</font>";
							echo "<input type=\"hidden\" name=\"key_db[$t]\" value=\"$docketno\">";
							$repeat=1;
						}
						else if($repeat==0  and m3_job_exists_check($docketno,'LAY',$joins_checkbox)>0)
						{
						   echo "Reporting Done";
						}
					  	echo "<input type=\"hidden\" name=\"doc_no[$t]\" value=\"$docketno\">";
					  	echo "<input type=\"hidden\" name=\"size_db[$t]\" value=\"".$sizes_db[$m]."\">";
					  	echo "<input type=\"hidden\" name=\"qty_db[$t]\" value=\"".$qty_db[$m]."\">";
					  	echo "<input type=\"hidden\" name=\"job_no[$t]\" value=\"".chr($color_code).leading_zeros($cutno,3)."\">";
					  	
					  	$t++;
					  	//Form Elements
					  				  	
					  echo "</td>";
					  
					 
					 
					 echo "</tr>";
					  
				}
		 	}
		 }
 }
 
 

//Recut
$sql="select * from $bai_pro3.recut_v2 where order_tid='$order_tid' and cat_ref='$cat_ref'
 and mk_ref>0 order by acutno";
// mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_result=mysqli_query($link, $sql) or exit("Sql Error106".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_num_=mysqli_num_rows($sql_result);
while($sql_row=mysqli_fetch_array($sql_result))
{
$a_xs_tot=0;
$a_s_tot=0;
$a_m_tot=0;
$a_l_tot=0;
$a_xl_tot=0;
$a_xxl_tot=0;
$a_xxxl_tot=0;
$plies_tot=0;
$a_s01_tot=0;
$a_s02_tot=0;
$a_s03_tot=0;
$a_s04_tot=0;
$a_s05_tot=0;
$a_s06_tot=0;
$a_s07_tot=0;
$a_s08_tot=0;
$a_s09_tot=0;
$a_s10_tot=0;
$a_s11_tot=0;
$a_s12_tot=0;
$a_s13_tot=0;
$a_s14_tot=0;
$a_s15_tot=0;
$a_s16_tot=0;
$a_s17_tot=0;
$a_s18_tot=0;
$a_s19_tot=0;
$a_s20_tot=0;
$a_s21_tot=0;
$a_s22_tot=0;
$a_s23_tot=0;
$a_s24_tot=0;
$a_s25_tot=0;
$a_s26_tot=0;
$a_s27_tot=0;
$a_s28_tot=0;
$a_s29_tot=0;
$a_s30_tot=0;
$a_s31_tot=0;
$a_s32_tot=0;
$a_s33_tot=0;
$a_s34_tot=0;
$a_s35_tot=0;
$a_s36_tot=0;
$a_s37_tot=0;
$a_s38_tot=0;
$a_s39_tot=0;
$a_s40_tot=0;
$a_s41_tot=0;
$a_s42_tot=0;
$a_s43_tot=0;
$a_s44_tot=0;
$a_s45_tot=0;
$a_s46_tot=0;
$a_s47_tot=0;
$a_s48_tot=0;
$a_s49_tot=0;
$a_s50_tot=0;

  $plies_tot=0;
  
$a_xs=$sql_row['a_xs'];
$a_s=$sql_row['a_s'];
$a_m=$sql_row['a_m'];
$a_l=$sql_row['a_l'];
$a_xl=$sql_row['a_xl'];
$a_xxl=$sql_row['a_xxl'];
$a_xxxl=$sql_row['a_xxxl'];
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
$a_s01_tot=$a_s01_tot+($a_s01*$plies);
$a_s02_tot=$a_s02_tot+($a_s02*$plies);
$a_s03_tot=$a_s03_tot+($a_s03*$plies);
$a_s04_tot=$a_s04_tot+($a_s04*$plies);
$a_s05_tot=$a_s05_tot+($a_s05*$plies);
$a_s06_tot=$a_s06_tot+($a_s06*$plies);
$a_s07_tot=$a_s07_tot+($a_s07*$plies);
$a_s08_tot=$a_s08_tot+($a_s08*$plies);
$a_s09_tot=$a_s09_tot+($a_s09*$plies);
$a_s10_tot=$a_s10_tot+($a_s10*$plies);
$a_s11_tot=$a_s11_tot+($a_s11*$plies);
$a_s12_tot=$a_s12_tot+($a_s12*$plies);
$a_s13_tot=$a_s13_tot+($a_s13*$plies);
$a_s14_tot=$a_s14_tot+($a_s14*$plies);
$a_s15_tot=$a_s15_tot+($a_s15*$plies);
$a_s16_tot=$a_s16_tot+($a_s16*$plies);
$a_s17_tot=$a_s17_tot+($a_s17*$plies);
$a_s18_tot=$a_s18_tot+($a_s18*$plies);
$a_s19_tot=$a_s19_tot+($a_s19*$plies);
$a_s20_tot=$a_s20_tot+($a_s20*$plies);
$a_s21_tot=$a_s21_tot+($a_s21*$plies);
$a_s22_tot=$a_s22_tot+($a_s22*$plies);
$a_s23_tot=$a_s23_tot+($a_s23*$plies);
$a_s24_tot=$a_s24_tot+($a_s24*$plies);
$a_s25_tot=$a_s25_tot+($a_s25*$plies);
$a_s26_tot=$a_s26_tot+($a_s26*$plies);
$a_s27_tot=$a_s27_tot+($a_s27*$plies);
$a_s28_tot=$a_s28_tot+($a_s28*$plies);
$a_s29_tot=$a_s29_tot+($a_s29*$plies);
$a_s30_tot=$a_s30_tot+($a_s30*$plies);
$a_s31_tot=$a_s31_tot+($a_s31*$plies);
$a_s32_tot=$a_s32_tot+($a_s32*$plies);
$a_s33_tot=$a_s33_tot+($a_s33*$plies);
$a_s34_tot=$a_s34_tot+($a_s34*$plies);
$a_s35_tot=$a_s35_tot+($a_s35*$plies);
$a_s36_tot=$a_s36_tot+($a_s36*$plies);
$a_s37_tot=$a_s37_tot+($a_s37*$plies);
$a_s38_tot=$a_s38_tot+($a_s38*$plies);
$a_s39_tot=$a_s39_tot+($a_s39*$plies);
$a_s40_tot=$a_s40_tot+($a_s40*$plies);
$a_s41_tot=$a_s41_tot+($a_s41*$plies);
$a_s42_tot=$a_s42_tot+($a_s42*$plies);
$a_s43_tot=$a_s43_tot+($a_s43*$plies);
$a_s44_tot=$a_s44_tot+($a_s44*$plies);
$a_s45_tot=$a_s45_tot+($a_s45*$plies);
$a_s46_tot=$a_s46_tot+($a_s46*$plies);
$a_s47_tot=$a_s47_tot+($a_s47*$plies);
$a_s48_tot=$a_s48_tot+($a_s48*$plies);
$a_s49_tot=$a_s49_tot+($a_s49*$plies);
$a_s50_tot=$a_s50_tot+($a_s50*$plies);

	$plies_tot=$plies_tot+$plies;
	
	unset($qty_db);
//	$qty_db=array($a_xs_tot,$a_s_tot,$a_m_tot,$a_l_tot,$a_xl_tot,$a_xxl_tot,$a_xxxl_tot,$a_s06_tot,$a_s08_tot,$a_s10_tot,$a_s12_tot,$a_s14_tot,$a_s16_tot,$a_s18_tot,$a_s20_tot,$a_s22_tot,$a_s24_tot,$a_s26_tot,$a_s28_tot,$a_s30_tot);
$qty_db=array($a_xs_tot,$a_s_tot,$a_m_tot,$a_l_tot,$a_xl_tot,$a_xxl_tot,$a_xxxl_tot,$a_s01_tot,$a_s02_tot,$a_s03_tot,$a_s04_tot,$a_s05_tot,$a_s06_tot,$a_s07_tot,$a_s08_tot,$a_s09_tot,$a_s10_tot,$a_s11_tot,$a_s12_tot,$a_s13_tot,$a_s14_tot,$a_s15_tot,$a_s16_tot,$a_s17_tot,$a_s18_tot,$a_s19_tot,$a_s20_tot,$a_s21_tot,$a_s22_tot,$a_s23_tot,$a_s24_tot,$a_s25_tot,$a_s26_tot,$a_s27_tot,$a_s28_tot,$a_s29_tot,$a_s30_tot,$a_s31_tot,$a_s32_tot,$a_s33_tot,$a_s34_tot,$a_s35_tot,$a_s36_tot,$a_s37_tot,$a_s38_tot,$a_s39_tot,$a_s40_tot,$a_s41_tot,$a_s42_tot,$a_s43_tot,$a_s44_tot,$a_s45_tot,$a_s46_tot,$a_s47_tot,$a_s48_tot,$a_s49_tot,$a_s50_tot); 
$check=0;
 			$repeat=0; //Repeat //Form Elements
		 for($m=0;$m<sizeof($qty_db);$m++)
		 {
		 	
		 	$check=0;			 
		 	if($qty_db[$m]>0)
			{
					 echo "<tr class=xl7214270 height=20 style='height:15.0pt; '>";
					  echo "<td height=20 class=xl7214270 style='height:15.0pt'></td>";
					
					  	  echo "<td class=xl9214270 colspan='2' style='border-top:none'>R".leading_zeros($cutno,3).(is_numeric($sql_row['plan_module'])?'':"(".$sql_row['plan_module'].")")."</td>";
						
					echo "<td class=xl9214270 colspan='2' style='border-top:none;border-left:none'>".ims_sizes($order_tid,'','','',$sizes_db[$m],$link)."</td>";
					 echo "<td class=xl9214270 colspan='2' style='border-top:none;border-left:none'>".$qty_db[$m]."</td>";
					   
					  echo "<td class=xl9214270 colspan='2' style='border-top:none;border-left:none'>$docketno</td>";
					  echo "<td class=xl9214270 colspan='2' style='border-top:none;border-left:none' $colspan>";
			  	
					  	//Form Elements
					  	if($repeat==0  and m3_job_exists_check($docketno,'LAY',$joins_checkbox)==0)
					  	{
                            if ($joins_checkbox==1) {
                                echo "<font color=\"red\">Splitting Pending</font>";
                            } else {
                                 echo "<input type=\"checkbox\" name=\"check_db[$t]\" value=\"1\"><font color=\"red\">Pending</font>";
                            }
							// echo "<input type=\"checkbox\" name=\"check_db[$t]\" value=\"1\"><font color=\"red\">7Pending</font>";
							echo "<input type=\"hidden\" name=\"key_db[$t]\" value=\"$docketno\">";
							$repeat=1;
						}
						else if($repeat==0  and m3_job_exists_check($docketno,'LAY',$joins_checkbox)>0)
						{
						   echo "Reporting Done";
						}
					  	echo "<input type=\"hidden\" name=\"doc_no[$t]\" value=\"$docketno\">";
					  	echo "<input type=\"hidden\" name=\"size_db[$t]\" value=\"".$sizes_db[$m]."\">";
					  	echo "<input type=\"hidden\" name=\"qty_db[$t]\" value=\"".$qty_db[$m]."\">";
					  	echo "<input type=\"hidden\" name=\"job_no[$t]\" value=\"R".leading_zeros($cutno,3).(is_numeric($sql_row['plan_module'])?'':"(".$sql_row['plan_module'].")")."\">";
					  	
					  	$t++;
					  	//Form Elements
					  				  	
					  echo "</td>";
					  
					 
					 
					 echo "</tr>";
					  
				}
	 	
		 }
 }
 	
	

 ?>


 
</table>

</div><br>
<input type="submit" name="confirm" value="Confirm" id="add" class="btn btn-success" onclick="document.getElementById('add').style.display='none'; document.getElementById('msg').style.display='';">
</form>
<div class="alert alert-danger" role='alert' id="msg" style="display:none;text-align:center;">Please wait while updating data...</div>
</div></div>
</div>
</div>
<!----------------------------->
<!--END OF OUTPUT FROM EXCEL PUBLISH AS WEB PAGE WIZARD-->
<!----------------------------->