<?php 
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'], "common/config/config.php", 4, 'R')); 
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'], "common/config/functions.php", 4, 'R')); 
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/m3Updations.php',4,'R')); 
//API related data
$plant_code = $global_facility_code;
$company_num = $company_no;
$host= $api_hostname;
$port= $api_port_no;
$current_date = date('Y-m-d h:i:s');

//KiranG - 2015-09-02 : passing link as parameter in update_m3_or function to avoid missing user name.

$op_code = 15;
$b_op_id = 15;
?>


<?php


foreach($sizes_array as $size){
    $equating_string.= "a_$size = p_$size,";
}


//function to update M3 Bulk OR

function update_m3_or($doc_no,$plies,$operation,$old_plies,$link)
{	
	global $m3_bulk_ops_rep_db;
	global $bai_pro3;
	$size_code_db=array('xs','s','m','l','xl','xxl','xxxl','s01','s02','s03','s04','s05','s06','s07','s08','s09','s10','s11','s12','s13','s14','s15','s16','s17','s18','s19','s20','s21','s22','s23','s24','s25','s26','s27','s28','s29','s30','s31','s32','s33','s34','s35','s36','s37','s38','s39','s40','s41','s42','s43','s44','s45','s46','s47','s48','s49','s50');
	$size_qty=array();
	global $in_categories;
	$sql="select * from $bai_pro3.order_cat_doc_mix where doc_no=\"$doc_no\" and category in ($in_categories)"; //20110911

	$sql_result=mysqli_query($link, $sql) or exit("Sql Error23".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row=mysqli_fetch_array($sql_result))
	{
		$size_qty[]=$sql_row['a_xs']*$plies;
		$size_qty[]=$sql_row['a_s']*$plies;
		$size_qty[]=$sql_row['a_m']*$plies;
		$size_qty[]=$sql_row['a_l']*$plies;
		$size_qty[]=$sql_row['a_xl']*$plies;
		$size_qty[]=$sql_row['a_xxl']*$plies;
		$size_qty[]=$sql_row['a_xxxl']*$plies;
		$size_qty[]=$sql_row['a_s01']*$plies;
		$size_qty[]=$sql_row['a_s02']*$plies;
		$size_qty[]=$sql_row['a_s03']*$plies;
		$size_qty[]=$sql_row['a_s04']*$plies;
		$size_qty[]=$sql_row['a_s05']*$plies;
		$size_qty[]=$sql_row['a_s06']*$plies;
		$size_qty[]=$sql_row['a_s07']*$plies;
		$size_qty[]=$sql_row['a_s08']*$plies;
		$size_qty[]=$sql_row['a_s09']*$plies;
		$size_qty[]=$sql_row['a_s10']*$plies;
		$size_qty[]=$sql_row['a_s11']*$plies;
		$size_qty[]=$sql_row['a_s12']*$plies;
		$size_qty[]=$sql_row['a_s13']*$plies;
		$size_qty[]=$sql_row['a_s14']*$plies;
		$size_qty[]=$sql_row['a_s15']*$plies;
		$size_qty[]=$sql_row['a_s16']*$plies;
		$size_qty[]=$sql_row['a_s17']*$plies;
		$size_qty[]=$sql_row['a_s18']*$plies;
		$size_qty[]=$sql_row['a_s19']*$plies;
		$size_qty[]=$sql_row['a_s20']*$plies;
		$size_qty[]=$sql_row['a_s21']*$plies;
		$size_qty[]=$sql_row['a_s22']*$plies;
		$size_qty[]=$sql_row['a_s23']*$plies;
		$size_qty[]=$sql_row['a_s24']*$plies;
		$size_qty[]=$sql_row['a_s25']*$plies;
		$size_qty[]=$sql_row['a_s26']*$plies;
		$size_qty[]=$sql_row['a_s27']*$plies;
		$size_qty[]=$sql_row['a_s28']*$plies;
		$size_qty[]=$sql_row['a_s29']*$plies;
		$size_qty[]=$sql_row['a_s30']*$plies;
		$size_qty[]=$sql_row['a_s31']*$plies;
		$size_qty[]=$sql_row['a_s32']*$plies;
		$size_qty[]=$sql_row['a_s33']*$plies;
		$size_qty[]=$sql_row['a_s34']*$plies;
		$size_qty[]=$sql_row['a_s35']*$plies;
		$size_qty[]=$sql_row['a_s36']*$plies;
		$size_qty[]=$sql_row['a_s37']*$plies;
		$size_qty[]=$sql_row['a_s38']*$plies;
		$size_qty[]=$sql_row['a_s39']*$plies;
		$size_qty[]=$sql_row['a_s40']*$plies;
		$size_qty[]=$sql_row['a_s41']*$plies;
		$size_qty[]=$sql_row['a_s42']*$plies;
		$size_qty[]=$sql_row['a_s43']*$plies;
		$size_qty[]=$sql_row['a_s44']*$plies;
		$size_qty[]=$sql_row['a_s45']*$plies;
		$size_qty[]=$sql_row['a_s46']*$plies;
		$size_qty[]=$sql_row['a_s47']*$plies;
		$size_qty[]=$sql_row['a_s48']*$plies;
		$size_qty[]=$sql_row['a_s49']*$plies;
		$size_qty[]=$sql_row['a_s50']*$plies;
		$plan_module=$sql_row['plan_module'];
		$order_tid=$sql_row['order_tid'];
		$jobno=$sql_row['acutno'];
		
		$p_plies=$sql_row['p_plies'];
		$a_plies=$sql_row['a_plies'];
		$act_cut_status=$sql_row['act_cut_status'];
	}
	
	
	
	
		
	//double entry checkdate
	$dcheck=0;
	if($p_plies==$a_plies and strlen($act_cut_status)==0 and $p_plies==$plies)
	{
		$dcheck=0;
	}
	else
	{
		if(strlen($act_cut_status)>0 and $p_plies>=($a_plies+$plies))
		{
			$dcheck=0;
		}
		else
		{
			if($a_plies==$p_plies and strlen($act_cut_status)==0 and $plies>0 and $p_plies>$plies)
			{
				$dcheck=0;
			}
			else
			{
				$dcheck=1;
			}
			
		}
	}
	
	
	//validation to exclude non primary components (Gusset)
	$other_docs=mysqli_num_rows($sql_result);
	
	$sql111="select order_style_no,order_del_no,order_col_des,color_code from $bai_pro3.bai_orders_db where order_tid=\"$order_tid\"";
	$sql_result111=mysqli_query($link, $sql111) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row111=mysqli_fetch_array($sql_result111))
	{
		$style=$sql_row111['order_style_no'];
		$schedule=$sql_row111['order_del_no'];
		$color=$sql_row111['order_col_des'];
		$job=chr($sql_row111['color_code']).leading_zeros($jobno,3);		
	}
	
	$check=0;
	
	$query_array=array();
//commented because of #759
	// if($other_docs>0 and $dcheck==0)
	// {
	// 	for($i=0;$i<sizeof($size_code_db);$i++)
	// 	{
			
			
			
	// 		//validation to report previous operation. //kirang 2015-10-14
	// 		$sql111="select sfcs_tid from $m3_bulk_ops_rep_db.m3_sfcs_tran_log where sfcs_style='$style' and sfcs_schedule='$schedule' and sfcs_color='$color' and sfcs_size='".$size_code_db[$i]."' and sfcs_doc_no='$doc_no' and m3_op_des='LAY' and sfcs_status<>90";
	// 		$sql_result1112=mysqli_query($link, $sql111) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			
			
	// 		//Validation to avoid duplicates
	// 		$sql111="select sfcs_tid from $m3_bulk_ops_rep_db.m3_sfcs_tran_log where sfcs_style='$style' and sfcs_schedule='$schedule' and sfcs_color='$color' and sfcs_size='".$size_code_db[$i]."' and sfcs_doc_no='$doc_no' and sfcs_qty=".$size_qty[$i]." and sfcs_log_user=USER() and LEFT(sfcs_log_time,13)='".date("Y-m-d H")."' and m3_op_des='$operation' and sfcs_status<>90";
	// 		$sql_result111=mysqli_query($link, $sql111) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			
	// 		//validation to report previous operation. //kirang 2015-10-14
	// 		//if($size_qty[$i]>0 and mysql_num_rows($sql_result111)==0 and mysql_num_rows($sql_result1112)>0)
	// 		if($size_qty[$i]>0 and mysqli_num_rows($sql_result111)==0)
	// 		{
	// 			//Changed the way of executing queries.
	// 			//$sql1="INSERT INTO m3_bulk_ops_rep_db.m3_sfcs_tran_log (sfcs_date,sfcs_style,sfcs_schedule,sfcs_color,sfcs_size,sfcs_doc_no,sfcs_qty,sfcs_log_user,m3_op_des,sfcs_tid_ref,sfcs_mod_no,sfcs_shift,sfcs_job_no) values (NOW(),'$style','$schedule','$color','".$size_code_db[$i]."',$doc_no,".$size_qty[$i].",USER(),'$operation',$doc_no,0,'','$job')"; 
			
	// 			//echo $sql."<br/>";
	// 			//mysql_query($sql1,$link) or exit("Sql Error6$sql1".mysql_error());
				
	// 			$query_array[]="(NOW(),'$style','$schedule','$color','".$size_code_db[$i]."',$doc_no,".$size_qty[$i].",USER(),'$operation',$doc_no,0,'','$job')";
				
	// 			if($check==0)
	// 			{
	// 				$check=1;
	// 			}
	// 		}
	// 	}
		
	
	// }
	
	
	//KiranG - 20160128 changed the sequence of the below query from prior to after passing the m3 bulk operation log.
		//$sql1="update bai_pro3.plandoc_stat_log set act_cut_status=\"DONE\", a_plies=".($plies+$old_plies)." where doc_no=$doc_no";
		//echo $sql1;
		//mysql_query($sql1,$link) or exit("Sql Error3$sql1".mysql_error());
		
	
	// commented for #759
	//if(($check==1 OR $other_docs==0) and mysql_affected_rows($link)>0)
	// if($check==1 OR $other_docs==0)
	// {
		
	// 	for($j=0;$j<sizeof($query_array);$j++)
	// 	{
	// 		$sql1="INSERT INTO $m3_bulk_ops_rep_db.m3_sfcs_tran_log (sfcs_date,sfcs_style,sfcs_schedule,sfcs_color,sfcs_size,sfcs_doc_no,sfcs_qty,sfcs_log_user,m3_op_des,sfcs_tid_ref,sfcs_mod_no,sfcs_shift,sfcs_job_no) values ".$query_array[$j]; 
			
	// 			//echo $sql."<br/>";
	// 		mysqli_query($link, $sql1) or exit("Sql Error6$sql1".mysqli_error($GLOBALS["___mysqli_ston"]));
	// 	}
		
		
		
		return "TRUE";
	// }
	// else
	// {
	// 	return "FALSE";
	// }
	
}

?>

<?php

if(isset($_POST['update']))
{

	// echo "<script>alert('into update condition')</script>";
	$club_status=$_POST['club_status'];
	$a_plies=$_POST["a_plies_qty"];
	$input_date=$_POST['date'];
	$input_section=$_POST['section'];
	$input_shift=$_POST['shift'];
	$input_fab_rec=$_POST['fab_rec'];
	$input_fab_ret=$_POST['fab_ret'];
	$input_damages=$_POST['damages'];
	$input_shortages=$_POST['shortages'];
	$input_remarks=$_POST['remarks'];
	$doc_no_ref=$_POST['doc_no'];
	$tran_order_tid=$_POST['tran_order_tid'];
	$bun_loc=$_POST['bun_loc'];
	$leader_name = $_POST['leader_name'];
	$plies=$_POST['plies'];
	$old_plies=$_POST['old_plies'];
	$old_input_fab_rec=$_POST['old_fab_rec'];
	$old_input_fab_ret=$_POST['old_fab_ret'];
	$old_input_damages=$_POST['old_damages'];
	$old_input_shortages=$_POST['old_shortages'];
	$ret_to=$_POST['ret_to'];
	$input_doc_no=$doc_no_ref;
	//echo $input_doc_no;

	// echo "<script>alert('till club status=1')</script>";
	if($club_status=='0')
	{
	
		// echo "<script>alert('into club status = 1')</script>";
		if(strlen($_POST['remarks'])>0)
		{
			$input_remarks=$_POST['remarks']."$".$input_date."^".$input_section."^".$input_shift."^".$input_fab_rec."^".$input_fab_ret."^".$input_damages."^".$input_shortages."^".$ret_to."^".$plies;
		}
		else
		{
			$input_remarks=$input_date."^".$input_section."^".$input_shift."^".$input_fab_rec."^".$input_fab_ret."^".$input_damages."^".$input_shortages."^".$ret_to."^".$plies;
		}

		$input_fab_rec+=$old_input_fab_rec;
		$input_fab_ret+=$old_input_fab_ret;
		$input_damages+=$old_input_damages;
		$input_shortages+=$old_input_shortages;

		// echo "<script>alert('till plies')</script>";
		if($plies>0)
		{
			// echo "<script>alert('till return function')</script>";
			$ret=update_m3_or($input_doc_no,$plies,'CUT',$old_plies,$link);
			//$ret='TRUE';
			if($ret=="TRUE")
			{
				// echo "<script>alert('into return function')</script>";
				$sql_check="select doc_no from $bai_pro3.act_cut_status where doc_no=$input_doc_no";
				$sql_check_res=mysqli_query($link, $sql_check) or exit("Sql Error11212".mysqli_error($GLOBALS["___mysqli_ston"]));
				if(mysqli_num_rows($sql_check_res)==0)
				{
                    $sql="insert into $bai_pro3.act_cut_status (doc_no) values ($input_doc_no)";
					//echo $sql;
					mysqli_query($link, $sql) or exit("Sql Error1 $sql".mysqli_error($GLOBALS["___mysqli_ston"]));
					//echo $sql;
				}
				
				
				$sql="update $bai_pro3.act_cut_status set date=\"$input_date\", section=\"$input_section\", shift=\"$input_shift\", fab_received=$input_fab_rec, fab_returned=$input_fab_ret, damages=$input_damages, shortages=$input_shortages, remarks=\"$input_remarks\", bundle_loc=\"$bun_loc\" ,leader_name=\"$leader_name\" where doc_no=$input_doc_no";
				//echo $sql;
				mysqli_query($link, $sql) or exit("Sql Error2  $sql".mysqli_error($GLOBALS["___mysqli_ston"]));
				//echo $sql;
				
				$sql1="update $bai_pro3.plandoc_stat_log set act_cut_status=\"DONE\", a_plies=".($plies+$old_plies).",pcutdocid=concat(pcutdocid,'$','$bun_loc') where doc_no=$input_doc_no";
				//echo $sql1;
				mysqli_query($link, $sql1) or exit("Sql Error3 $sql1".mysqli_error($GLOBALS["___mysqli_ston"]));
			}
			else
			{
				echo "<h2>Failed to update.. please retry..</h2>";
				$failed=1;
			}

		}
		//explicitly assigning to array
		$input_doc_nos = $input_doc_no;
	}
	else if($club_status=='1')
	{
		// echo "<script>alert('into club status=2')</script>";

		//Schedule clubbing
		if(strlen($_POST['remarks'])>0)
		{
			$input_remarks=$_POST['remarks']."$".$input_date."^".$input_section."^".$input_shift."^".$input_fab_rec."^".$input_fab_ret."^".$input_damages."^".$input_shortages."^".$ret_to."^".$plies;
		}
		else
		{
			$input_remarks=$input_date."^".$input_section."^".$input_shift."^".$input_fab_rec."^".$input_fab_ret."^".$input_damages."^".$input_shortages."^".$ret_to."^".$plies;
		}

		$input_fab_rec+=$old_input_fab_rec;
		$input_fab_ret+=$old_input_fab_ret;
		$input_damages+=$old_input_damages;
		$input_shortages+=$old_input_shortages;
		
		$sql_check1="select doc_no from $bai_pro3.act_cut_status where doc_no=$doc_no_ref";
		$sql_check_res1=mysqli_query($link, $sql_check1) or exit("Sql Error1121".mysqli_error($GLOBALS["___mysqli_ston"]));
		if(mysqli_num_rows($sql_check_res1)==0)
		{
			$sql="insert into $bai_pro3.act_cut_status (doc_no) values ($doc_no_ref)";
			//echo $sql."<br>";
			mysqli_query($link, $sql) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
			//echo $sql;
	    } 
		
		$sql1="update $bai_pro3.act_cut_status set date=\"$input_date\", section=\"$input_section\", shift=\"$input_shift\", fab_received='$input_fab_rec', fab_returned='$input_fab_ret', damages='$input_damages', shortages='$input_shortages', remarks=\"$input_remarks\", bundle_loc=\"$bun_loc\",leader_name=\"$leader_name\" where doc_no='$doc_no_ref'";
		//echo $sql1."<br>";
		$sql_result=mysqli_query($link, $sql1) or exit("Sql Error0".mysqli_error($GLOBALS["___mysqli_ston"]));
		// Cut qty split logic
		
		$ost=array();
		$sql212="select * from $bai_pro3.bai_orders_db_confirm where order_tid=\"".$tran_order_tid."\"";
		//echo $sql212."<br>";
		$sql_result12=mysqli_query($link, $sql212) or exit("Sql Error0".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row12=mysqli_fetch_array($sql_result12))
		{
			for($ii=0;$ii<sizeof($sizes_array);$ii++) 
			{
				//echo $sizes_array[$ii]."<br>";
				if($sql_row12["title_size_".$sizes_array[$ii].""]<>'')
				{
					$ost[$sizes_array[$ii]]=$sql_row12["title_size_".$sizes_array[$ii].""];
					//echo $sql_row12["title_size_".$sizes_array[$ii].""]."<br>";
				}
			}						
		}
			
		$sql21="select * from $bai_pro3.plandoc_stat_log where doc_no=\"".$doc_no_ref."\"";
		$sql_result1=mysqli_query($link, $sql21) or exit("Sql Error0".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row1=mysqli_fetch_array($sql_result1))
		{
			for($ii=0;$ii<sizeof($ost);$ii++) 
			{
				$availble_size[$sizes_array[$ii]]=$sql_row1["p_".$sizes_array[$ii].""]*$plies;
				//echo $sizes_array[$ii]."---".$availble_size[$sizes_array[$ii]]."<br>";
			}						
		}
		
		$order_tid_ref=array();
		$sql3="select * from $bai_pro3.plandoc_stat_log where org_doc_no=\"$doc_no_ref\""; 
		$sql_result2=mysqli_query($link, $sql3) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row2=mysqli_fetch_array($sql_result2))
		{
			//for clubbing dockets getting category
			$club_docs[$sql_row2['doc_no']] = $sql_row2['cat_ref'];
			$sql4="UPDATE $bai_pro3.plandoc_stat_log SET `act_cut_status` = 'DONE' , `fabric_status` = '5' , `plan_lot_ref` = '\'STOCK\'' WHERE `doc_no` = '".$sql_row2['doc_no']."'";
			$sql_result3=mysqli_query($link, $sql4) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
			//echo $sql4."<br>";
		}	
		
		
		$sql6="UPDATE $bai_pro3.plandoc_stat_log SET `act_cut_status` = 'DONE' WHERE `doc_no` = '$doc_no_ref'";
		$sql_result4=mysqli_query($link, $sql6) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
		//echo $sql6."<br>";
		for($i4=0;$i4<sizeof($ost);$i4++)
		{
			$doc_no_ref2=array();
			
			$sql2="select order_tid,doc_no,a_".$sizes_array[$i4]." as a_".$sizes_array[$i4].",p_".$sizes_array[$i4]." as p_".$sizes_array[$i4]." from $bai_pro3.plandoc_stat_log where org_doc_no=\"".$doc_no_ref."\" and p_".$sizes_array[$i4].">0 order by p_".$sizes_array[$i4]."*1 ASC";
			//echo $sql2."<br>";
			$sql_result=mysqli_query($link, $sql2) or exit("Sql Error0".mysqli_error($GLOBALS["___mysqli_ston"]));
			//echo $sql2."<br>";
			if(mysqli_num_rows($sql_result)>0)
			{
				
				while($sql_row=mysqli_fetch_array($sql_result))
				{
					$order_tid_ref[$sql_row['doc_no']][$sizes_array[$i4]]=$sql_row["order_tid"];
					$doc_no_ref2[]=$sql_row['doc_no'];
					$upto_report[$sql_row['doc_no']][$sizes_array[$i4]]=$sql_row["a_".$sizes_array[$i4].""];
					$need_report[$sql_row['doc_no']][$sizes_array[$i4]]=$sql_row["p_".$sizes_array[$i4].""];
				}
				$available=$availble_size[$sizes_array[$i4]];
				
				$tot_col=sizeof($order_tid_ref);
				
				if($available<$tot_col)
				{
					for($kk=1;$kk<=$available;$kk++)
					{	
						$val[$doc_no_ref2[$kk]][$sizes_array[$i4]]=1;
					}
				}
				else
				{
					$pend=$available%$tot_col;
					$tot_split=($available-$pend)/$tot_col;
					for($kk=0;$kk<sizeof($order_tid_ref);$kk++)
					{	
						if($pend>0)
						{
							$val[$doc_no_ref2[$kk]][$sizes_array[$i4]]=$tot_split+$pend;
							$pend=0;
						}
						else
						{
							$val[$doc_no_ref2[$kk]][$sizes_array[$i4]]=$tot_split;
						}
					}
				}
				$bal=0;	
				for($jj=0;$jj<sizeof($doc_no_ref2);$jj++)
				{
					$sql68="select order_del_no,order_style_no,order_col_des from $bai_pro3.bai_orders_db_confirm where order_tid=\"".$order_tid_ref[$doc_no_ref2[$jj]][$sizes_array[$i4]]."\"";
					//echo 
					$sql_result68=mysqli_query($link, $sql68) or exit("Sql Error6".$sql6.mysqli_error($GLOBALS["___mysqli_ston"]));
					while($sql_row68=mysqli_fetch_array($sql_result68))
					{
						$order_style_no=$sql_row68["order_style_no"];
						$order_del_no=$sql_row68["order_del_no"];
						$order_col_des=$sql_row68["order_col_des"];
					}
					$sub_doc_size_qty=0;
					$sub_doc_size_qty_tmp=0;
					if($bal>0)
					{
						$val[$doc_no_ref2[$jj]][$sizes_array[$i4]]+=$bal;
						$bal=0;								
					}
					//$sub_doc_size_qty=$val[$doc_no_ref2[$jj]][$sizes_array[$i4]]-$upto_report[$doc_no_ref2[$jj]][$sizes_array[$i4]];
					//echo "Split--".$val[$doc_no_ref2[$jj]][$sizes_array[$i4]]."-Require-".$need_report[$doc_no_ref2[$jj]][$sizes_array[$i4]]."-Complete-".$upto_report[$doc_no_ref2[$jj]]
					[$sizes_array[$i4]]."<br>";
					if(($val[$doc_no_ref2[$jj]][$sizes_array[$i4]])<=($need_report[$doc_no_ref2[$jj]][$sizes_array[$i4]]-$upto_report[$doc_no_ref2[$jj]]
					[$sizes_array[$i4]]))
					{								
						$sub_doc_size_qty=$val[$doc_no_ref2[$jj]][$sizes_array[$i4]];
					}
					else
					{
						$sub_doc_size_qty_tmp=$val[$doc_no_ref2[$jj]][$sizes_array[$i4]]-$upto_report[$doc_no_ref2[$jj]][$sizes_array[$i4]];
						$sub_doc_size_qty=$need_report[$doc_no_ref2[$jj]][$sizes_array[$i4]]-$upto_report[$doc_no_ref2[$jj]][$sizes_array[$i4]];
						$bal=$sub_doc_size_qty_tmp-$sub_doc_size_qty;
					//	echo "Balance--".$bal."<br>";
					}	
					//echo "Quantity--".$sub_doc_size_qty."<br>";
					if($sub_doc_size_qty > 0)
					{
						//commented for #759
						// $sql5="insert into $m3_bulk_ops_rep_db.m3_sfcs_tran_log(sfcs_date,sfcs_size,sfcs_doc_no,sfcs_style,sfcs_schedule,sfcs_color,sfcs_qty,sfcs_log_user,sfcs_status,sfcs_tid_ref,m3_op_des) values(NOW(),'".$sizes_array[$i4]."','".$doc_no_ref2[$jj]."','".$order_style_no."','".$order_del_no."','".$order_col_des."','".$sub_doc_size_qty."','".$username."',0,'".$doc_no_ref."','CUT')";
						// mysqli_query($link, $sql5) or exit("Sql Error5".mysqli_error($GLOBALS["___mysqli_ston"]));
						//echo $sql5."<br>";
						$sql61="update $bai_pro3.plandoc_stat_log set a_".$sizes_array[$i4]."='".$sub_doc_size_qty."' where doc_no='".$doc_no_ref2[$jj]."'";
						mysqli_query($link, $sql61) or exit("Sql Error61".mysqli_error($GLOBALS["___mysqli_ston"]));
						//echo $sql61."<br>";
						$upto_report[$doc_no_ref2[$jj]][$sizes_array[$i4]]+=$sub_doc_size_qty;
					}	
						
				}						
				
			}
			
		}
		for($kl=0;$kl<sizeof($doc_no_ref2);$kl++)
		{	
			$sql_check2="select doc_no from $bai_pro3.act_cut_status where doc_no=$doc_no_ref2[$kl]";
			$sql_check_res2=mysqli_query($link, $sql_check2) or exit("Sql Error112".mysqli_error($GLOBALS["___mysqli_ston"]));
			if(mysqli_num_rows($sql_check_res2)==0)
			{			
				$sql12="insert into $bai_pro3.act_cut_status (doc_no) values ($doc_no_ref2[$kl])";
				//echo $sql12."<br>";
				mysqli_query($link, $sql12) or exit("Sql Error1122".mysqli_error($GLOBALS["___mysqli_ston"]));
			}
		
			$sql14="update $bai_pro3.act_cut_status set date=\"$input_date\", section=\"$input_section\", shift=\"$input_shift\", fab_received='0', fab_returned='0', damages='0', shortages='0', remarks='', bundle_loc=\"$bun_loc\",leader_name=\"$leader_name\" where doc_no='$doc_no_ref2[$kl]'";
			//echo $sql14."<br>";
			$sql_result=mysqli_query($link, $sql14) or exit("Sql Error14".mysqli_error($GLOBALS["___mysqli_ston"]));
		}
		
		//echo "going inside loop";
		unset($input_doc_nos);
		
		foreach($club_docs as $docket=>$cat_ref){
			$cat_query = "SELECT category from $bai_pro3.cat_stat_log where tid='$cat_ref' and 
						  category in ($in_categories)";
			$cat_result = mysqli_query($link,$cat_query);
			if(mysqli_num_rows($cat_result) > 0){
				//$insert = doc_size_wise_bundle_insertion($docket);
				$input_doc_nos[] = $docket;
			}
		}
		//var_dump($input_doc_nos);
		$input_doc_nos = implode(',',$input_doc_nos);
	}else if($club_status == '2'){

		$plies_query = "SELECT p_plies from $bai_pro3.plandoc_stat_log where doc_no = '$input_doc_no' ";
		$plies_result = mysqli_query($link,$plies_query);
		while($row = mysqli_fetch_array($plies_result)){
			$p_plies = $row['p_plies'];
		}
		if(!($plies == $p_plies)){
			echo "<script type=\"text/javascript\"> 
				swal('Actual Plies should be equal to Planned Plies','Try Again','error');
				setTimeout(\"Redirect()\",1000); function Redirect() {  location.href = '".getFullURLLevel($_GET['r'],'doc_track_panel_cut.php',0,'N')."'; }</script>";
			exit();
		}


		// echo "<script>alert('into club status = 1')</script>";
		if(strlen($_POST['remarks'])>0)
		{
			$input_remarks=$_POST['remarks']."$".$input_date."^".$input_section."^".$input_shift."^".$input_fab_rec."^".$input_fab_ret."^".$input_damages."^".$input_shortages."^".$ret_to."^".$plies;
		}
		else
		{
			$input_remarks=$input_date."^".$input_section."^".$input_shift."^".$input_fab_rec."^".$input_fab_ret."^".$input_damages."^".$input_shortages."^".$ret_to."^".$plies;
		}

		$input_fab_rec+=$old_input_fab_rec;
		$input_fab_ret+=$old_input_fab_ret;
		$input_damages+=$old_input_damages;
		$input_shortages+=$old_input_shortages;
		
		// echo "<script>alert('till plies')</script>";
		if($plies>0)
		{
			// echo "<script>alert('till return function')</script>";
			// echo "<script>alert('into return function')</script>";
			$sql_check3="select doc_no from $bai_pro3.act_cut_status where doc_no=$input_doc_no";
			$sql_check_res3=mysqli_query($link, $sql_check3) or exit("Sql Error1122".mysqli_error($GLOBALS["___mysqli_ston"]));
			if(mysqli_num_rows($sql_check_res3)==0)
			{
				$sql="insert into $bai_pro3.act_cut_status (doc_no) values ($input_doc_no)";
				//echo $sql;
				mysqli_query($link, $sql) or exit("Sql Error1 $sql".mysqli_error($GLOBALS["___mysqli_ston"]));
				//echo $sql;
			}	
			
			$sql="update $bai_pro3.act_cut_status set date=\"$input_date\", section=\"$input_section\", shift=\"$input_shift\", fab_received=$input_fab_rec, fab_returned=$input_fab_ret, damages=$input_damages, shortages=$input_shortages, remarks=\"$input_remarks\", bundle_loc=\"$bun_loc\" ,leader_name=\"$leader_name\" where doc_no=$input_doc_no";
			//echo $sql;
			mysqli_query($link, $sql) or exit("Sql Error2  $sql".mysqli_error($GLOBALS["___mysqli_ston"]));
			//echo $sql;
			
			$sql1="update $bai_pro3.plandoc_stat_log set act_cut_status='DONE', a_plies=$a_plies,
				pcutdocid=concat(pcutdocid,'$','$bun_loc') where doc_no=$input_doc_no";
			//echo $sql1;
			mysqli_query($link, $sql1) or exit("Sql Error3 $sql1".mysqli_error($GLOBALS["___mysqli_ston"]));


			//getting all child dockets
			$child_docs_query = "SELECT doc_no from $bai_pro3.plandoc_stat_log psl  
						LEFT JOIN $bai_pro3.cat_stat_log csl ON csl.tid = psl.cat_ref
						where org_doc_no = '$input_doc_no' ";
			$child_docs_result = mysqli_query($link,$child_docs_query);
			while($row = mysqli_fetch_array($child_docs_result)){
				$child_docs[] = $row['doc_no'];
			}
			foreach($child_docs as $docket){
				$update_query = "UPDATE $bai_pro3.plandoc_stat_log set $equating_string act_cut_status='DONE'
								where doc_no = '$docket' ";
				$update_result = mysqli_query($link,$update_query);

                $sql_check4="select doc_no from $bai_pro3.act_cut_status where doc_no=$docket";
				$sql_check_res4=mysqli_query($link, $sql_check4) or exit("Sql Error11224".mysqli_error($GLOBALS["___mysqli_ston"]));
				if(mysqli_num_rows($sql_check_res4)==0)
				{
					$sql="insert into $bai_pro3.act_cut_status (doc_no) values ($docket)";
					mysqli_query($link, $sql) or exit("Sql Error1 $sql".mysqli_error($GLOBALS["___mysqli_ston"]));
				}
			
				$sql1="update $bai_pro3.act_cut_status set date=\"$input_date\", section=\"$input_section\", shift=\"$input_shift\", fab_received=0, fab_returned=0, damages=$input_damages, shortages=0, remarks=\"$input_remarks\", bundle_loc=\"$bun_loc\" ,leader_name=\"$leader_name\" where doc_no=$docket";
				mysqli_query($link,$sql1) or exit("Sql Error2  $sql1".mysqli_error($GLOBALS["___mysqli_ston"]));
			}
			unset($child_docs);
			//getting all child dockets fro m3 reporting
			$child_docs_query = "SELECT doc_no from $bai_pro3.plandoc_stat_log psl  
						LEFT JOIN $bai_pro3.cat_stat_log csl ON csl.tid = psl.cat_ref
						where org_doc_no = '$input_doc_no' and category IN ($in_categories)";
			$child_docs_result = mysqli_query($link,$child_docs_query);
			while($row = mysqli_fetch_array($child_docs_result)){
				$child_docs[] = $row['doc_no'];
			}
		}
		//explicitly assigning to array
		$input_doc_nos = implode(',',$child_docs);
	}

	if ($failed == 1) 
	{
		echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",1000); function Redirect() {  location.href = '".getFullURLLevel($_GET['r'],'doc_track_panel_cut.php',0,'N')."'; }</script>";
	}
	else
	{
		$go_back = 'doc_track_panel_cut';
		echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",1000); function Redirect() {  location.href = '".getFullURLLevel($_GET['r'],'trail.php',0,'N')."&doc_no_ref=$input_doc_nos&plies=$plies&go_back_to=$go_back'; }</script>";
	}
	
}

//Logic Ends Here
echo "<div class=\"alert alert-success\">
<strong>Successfully Cutting Reported.</strong>
</div>";

//echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",1000); function Redirect() {  location.href = '".getFullURLLevel($_GET['r'],'doc_track_panel_cut.php',0,'N')."'; }</script>";
?>

