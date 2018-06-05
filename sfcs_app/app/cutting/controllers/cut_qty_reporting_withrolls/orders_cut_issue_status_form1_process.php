<?php 
include($_SERVER['DOCUMENT_ROOT'].getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));
include($_SERVER['DOCUMENT_ROOT'].getFullURLLevel($_GET['r'],'common/config/functions.php',4,'R')); 

//KiranG - 2015-09-02 : passing link as parameter in update_m3_or function to avoid missing user name.
?>
<style>
.cell {
    width: 100px;
    height: 40px; 
    margin-left: 5%; 
    margin-top: 3%; 
    background-color: lightgreen;        
}
</style>

<?php

	//function to update M3 Bulk OR
	function update_m3_or($doc_no,$plies,$operation,$old_plies,$link)
	{
		global $m3_bulk_ops_rep_db;
		$size_code_db=array('xs','s','m','l','xl','xxl','xxxl','s01','s02','s03','s04','s05','s06','s07','s08','s09','s10','s11','s12','s13','s14','s15','s16','s17','s18','s19','s20','s21','s22','s23','s24','s25','s26','s27','s28','s29','s30','s31','s32','s33','s34','s35','s36','s37','s38','s39','s40','s41','s42','s43','s44','s45','s46','s47','s48','s49','s50');
		
		$size_qty=array();
		
		$sql="select * from $bai_pro3.order_cat_doc_mix where doc_no=\"$doc_no\" and category in ('Body','Front')"; //20110911
	
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

		if($other_docs>0 and $dcheck==0)
		{
			
			for($i=0;$i<sizeof($size_code_db);$i++)
			{				
				
				//validation to report previous operation. //kirang 2015-10-14
				$sql111="select sfcs_tid from $m3_bulk_ops_rep_db.m3_sfcs_tran_log where sfcs_style='$style' and sfcs_schedule='$schedule' and sfcs_color='$color' and sfcs_size='".$size_code_db[$i]."' and sfcs_doc_no='$doc_no' and m3_op_des='LAY' and sfcs_status<>90";
				$sql_result1112=mysqli_query($link, $sql111) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				
				
				//Validation to avoid duplicates
				$sql111="select sfcs_tid from $m3_bulk_ops_rep_db.m3_sfcs_tran_log where sfcs_style='$style' and sfcs_schedule='$schedule' and sfcs_color='$color' and sfcs_size='".$size_code_db[$i]."' and sfcs_doc_no='$doc_no' and sfcs_qty=".$size_qty[$i]." and sfcs_log_user=USER() and LEFT(sfcs_log_time,13)='".date("Y-m-d H")."' and m3_op_des='$operation' and sfcs_status<>90";
				$sql_result111=mysqli_query($link, $sql111) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				
				//validation to report previous operation. //kirang 2015-10-14
				//if($size_qty[$i]>0 and mysql_num_rows($sql_result111)==0 and mysql_num_rows($sql_result1112)>0)
				if($size_qty[$i]>0 and mysqli_num_rows($sql_result111)==0)
				{
					//Changed the way of executing queries.
					//$sql1="INSERT INTO m3_bulk_ops_rep_db.m3_sfcs_tran_log (sfcs_date,sfcs_style,sfcs_schedule,sfcs_color,sfcs_size,sfcs_doc_no,sfcs_qty,sfcs_log_user,m3_op_des,sfcs_tid_ref,sfcs_mod_no,sfcs_shift,sfcs_job_no) values (NOW(),'$style','$schedule','$color','".$size_code_db[$i]."',$doc_no,".$size_qty[$i].",USER(),'$operation',$doc_no,0,'','$job')"; 
				
					//echo $sql."<br/>";
					//mysql_query($sql1,$link) or exit("Sql Error6$sql1".mysql_error());
					
					$query_array[]="(NOW(),'$style','$schedule','$color','".$size_code_db[$i]."',$doc_no,".$size_qty[$i].",USER(),'$operation',$doc_no,0,'','$job',15)";
					// $query_array1[]="(NOW(),'$style','$schedule','$color','".$size_code_db[$i]."',$doc_no,".$size_qty[$i].",USER(),'LAY',$doc_no,0,'','$job',10)";
					
					if($check==0)
					{
						$check=1;
					}
				}
			}
		}
		
		
		
			//KiranG - 20160128 changed the sequence of the below query from prior to after passing the m3 bulk operation log.
			//$sql1="update bai_pro3.plandoc_stat_log set act_cut_status=\"DONE\", a_plies=".($plies+$old_plies)." where doc_no=$doc_no";
			//echo $sql1;
			//mysql_query($sql1,$link) or exit("Sql Error3$sql1".mysql_error());
			
		
		
		//if(($check==1 OR $other_docs==0) and mysql_affected_rows($link)>0)
		// echo '<script>alert("came till into m3_tran_log")</script>';
		if($check==1 OR $other_docs==0)
		{
			// echo '<script>alert("into if condition ")</script>';
			for($j=0;$j<sizeof($query_array);$j++)
			{
				// echo '<script>alert("into for loop ")</script>';
				// $sql11="INSERT INTO m3_bulk_ops_rep_db.m3_sfcs_tran_log (sfcs_date,sfcs_style,sfcs_schedule,sfcs_color,sfcs_size,sfcs_doc_no,sfcs_qty,sfcs_log_user,m3_op_des,sfcs_tid_ref,sfcs_mod_no,sfcs_shift,sfcs_job_no,m3_op_code) values ".$query_array1[$j]; 
				
					//echo $sql."<br/>";
				// mysqli_query($link, $sql11) or exit("Sql Error6$sql11".mysqli_error($GLOBALS["___mysqli_ston"]));
				
				$sql1="INSERT INTO $m3_bulk_ops_rep_db.m3_sfcs_tran_log (sfcs_date,sfcs_style,sfcs_schedule,sfcs_color,sfcs_size,sfcs_doc_no,sfcs_qty,sfcs_log_user,m3_op_des,sfcs_tid_ref,sfcs_mod_no,sfcs_shift,sfcs_job_no,m3_op_code) values ".$query_array[$j]; 
				
					//echo $sql."<br/>";
				mysqli_query($link, $sql1) or exit("Sql Error6.1$sql1".mysqli_error($GLOBALS["___mysqli_ston"]));
				// echo '<script>alert("inserted into m3_tran_log")</script>';
			}
			return "TRUE";
		}
		else
		{
			// echo '<script>alert("NOT inserted into m3_tran_log")</script>';
			return "FALSE";
		}
	}

?>

<?php

	if(isset($_POST['Update']))
	{
		$club_status=$_POST['club_status'];
		$input_date=$_POST['date'];
		$input_section=$_POST['section'];
		$input_shift=$_POST['shift'];
		$input_fab_rec=$_POST['fab_rec'];
		$input_fab_ret=$_POST['fab_ret'];
		$input_damages=$_POST['damages'];
		$input_shortages=$_POST['shortages'];
		$input_remarks=$_POST['remarks'];
		$doc_no_ref=$_POST['doc_no'];
		$input_doc_no=$_POST['doc_no'];
		$tran_order_tid=$_POST['tran_order_tid'];
		$bun_loc=$_POST['bun_loc'];
		$a_plies=$_POST["a_plies_qty"];

		$plies=$_POST['plies'];
		$old_plies=$_POST['old_plies'];
		//Roll Table Logic --Satish 21/12/2017
		$roledata = $_POST['inputdata'];
		$newratio = $_POST['newratio'];	
		
		//locations Logic -- Satish 23/11/2017

		$query = "SELECT * FROM $bai_pro3.`plandoc_stat_log` WHERE doc_no=$input_doc_no";
		$res = mysqli_query($link, $query) or exit("Sql Error at p_plies".mysqli_error($GLOBALS["___mysqli_ston"]));
		$result = mysqli_fetch_array($res);
		$p_plies = $result['p_plies'];

		$old_input_fab_rec=$_POST['old_fab_rec'];
		$old_input_fab_ret=$_POST['old_fab_ret'];
		$old_input_damages=$_POST['old_damages'];
		$old_input_shortages=$_POST['old_shortages'];
		$ret_to=$_POST['ret_to'];

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

		

		if($plies>0)
		{
			/*
			if($club_status=='1')
			{
				$doc_no_ref2=array();
				$sql2="select doc_no from bai_pro3.plandoc_stat_log where org_doc_no=\"".$doc_no_ref."\"";
				$sql_result=mysqli_query($link, $sql2) or exit("Sql Error0".mysqli_error($GLOBALS["___mysqli_ston"]));
				if(mysqli_num_rows($sql_result)>0)
				{
					while($sql_row=mysqli_fetch_array($sql_result))
					{
						$doc_no_ref2[]=$sql_row['doc_no'];
					}
				}
				else
				{
					$doc_no_ref2[]=$doc_no_ref;
				}

				$order_tid_ref=array();
				$sql3="select * from bai_pro3.plandoc_stat_log where org_doc_no=\"$doc_no_ref\""; 
				$sql_result2=mysqli_query($link, $sql3) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($sql_row2=mysqli_fetch_array($sql_result2))
				{
					$order_tid_ref[]=$sql_row2["order_tid"];
					$sql4="UPDATE `bai_pro3`.`plandoc_stat_log` SET `act_cut_status` = 'DONE' , `fabric_status` = '5' , `plan_lot_ref` = '\'STOCK\'' WHERE `doc_no` = '".$sql_row2['doc_no']."'";
					
					$sql_result3=mysqli_query($link, $sql4) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
				}	
				
					
				$sql6="UPDATE `bai_pro3`.`plandoc_stat_log` SET `act_cut_status` = 'DONE' WHERE `doc_no` = '$doc_no_ref'";
				$sql_result4=mysqli_query($link, $sql6) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
	
				for($i4=0;$i4<sizeof($doc_no_ref2);$i4++)
				{
					$sql68="select order_del_no,order_style_no,order_col_des from bai_pro3.bai_orders_db_confirm where order_tid=\"".$order_tid_ref[$i4]."\"";
					$sql_result68=mysqli_query($link, $sql68) or exit("Sql Error6".$sql6.mysqli_error($GLOBALS["___mysqli_ston"]));
					while($sql_row68=mysqli_fetch_array($sql_result68))
					{
						$order_style_no=$sql_row68["order_style_no"];
						$order_del_no=$sql_row68["order_del_no"];
						$order_col_des=$sql_row68["order_col_des"];
					}
					for($i2=0;$i2<sizeof($sizes_array);$i2++)
					{
						$sub_doc_size_qty=0;
						$sql4="select p_".$sizes_array[$i2]." as size_qty from bai_pro3.plandoc_stat_log where order_tid=\"".$order_tid_ref[$i4]."\" and doc_no='".$doc_no_ref2[$i4]."'"; 
						$sql_result4=mysqli_query($link, $sql4) or exit("Sql Error4".mysqli_error($GLOBALS["___mysqli_ston"]));
						while($sql_row4=mysqli_fetch_array($sql_result4))
						{
							$sub_doc_size_qty=$sql_row4['size_qty'];
						}
						if($sub_doc_size_qty > 0)
						{
							$sql5="insert into m3_bulk_ops_rep_db.m3_sfcs_tran_log(sfcs_date,sfcs_size,sfcs_doc_no,sfcs_style,sfcs_schedule,sfcs_color,sfcs_qty,sfcs_log_user,sfcs_status,sfcs_tid_ref,m3_op_des) values(NOW(),'".$sizes_array[$i2]."','".$doc_no_ref2[$i4]."','".$order_style_no."','".$order_del_no."','".$order_col_des."','".$sub_doc_size_qty."','".$username."',0,'".$doc_no_ref2[$i4]."','CUT')";
							mysqli_query($link, $sql5) or exit("Sql Error5".mysqli_error($GLOBALS["___mysqli_ston"]));
							
							$sql61="update bai_pro3.plandoc_stat_log set a_".$sizes_array[$i2]."=p_".$sizes_array[$i2]." where doc_no='".$doc_no_ref2[$i4]."'";
							mysqli_query($link, $sql61) or exit("Sql Error61".mysqli_error($GLOBALS["___mysqli_ston"]));
						}
					}
					$sql12="insert ignore into act_cut_status (doc_no) values ($doc_no_ref2[$i4])";
					//echo $sql12."<br>";
					mysqli_query($link, $sql12) or exit("Sql Error112".mysqli_error($GLOBALS["___mysqli_ston"]));

					
					$sql14="update act_cut_status set date=\"$input_date\", section=\"$input_section\", shift=\"$input_shift\", fab_received='0', fab_returned='0', damages='0', shortages='0', remarks='', bundle_loc=\"$bun_loc\" where doc_no='$doc_no_ref2[$i4]'";
					//echo $sql14."<br>";
					$sql_result=mysqli_query($link, $sql14) or exit("Sql Error14".mysqli_error($GLOBALS["___mysqli_ston"]));

				}
				$ret='TRUE';
			}
			else if($club_status=='2')
			{
				$doc_no_ref2=array();
				$sql2="select doc_no from bai_pro3.plandoc_stat_log where org_doc_no=\"".$doc_no_ref."\"";
				$sql_result=mysqli_query($link, $sql2) or exit("Sql Error0".mysqli_error($GLOBALS["___mysqli_ston"]));
				if(mysqli_num_rows($sql_result)>0)
				{
					while($sql_row=mysqli_fetch_array($sql_result))
					{
						$doc_no_ref2[]=$sql_row['doc_no'];
					}
				}
				else
				{
					$doc_no_ref2[]=$doc_no_ref;
				}

				$order_tid_ref=array();
				$sql3="select * from bai_pro3.plandoc_stat_log where org_doc_no=\"$doc_no_ref\""; 

				$sql_result2=mysqli_query($link, $sql3) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($sql_row2=mysqli_fetch_array($sql_result2))
				{
					$order_tid_ref[]=$sql_row2["order_tid"];
					$sql4="UPDATE `bai_pro3`.`plandoc_stat_log` SET `act_cut_status` = 'DONE' , `fabric_status` = '5' , `plan_lot_ref` = '\'STOCK\'' WHERE `doc_no` = '".$sql_row2['doc_no']."'";
					
					$sql_result3=mysqli_query($link, $sql4) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
				}	
				
					
				$sql6="UPDATE `bai_pro3`.`plandoc_stat_log` SET `act_cut_status` = 'DONE' WHERE `doc_no` = '$doc_no_ref'";
				$sql_result4=mysqli_query($link, $sql6) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
	
				for($i4=0;$i4<sizeof($doc_no_ref2);$i4++)
				{
					$sql68="select order_del_no,order_style_no,order_col_des from bai_pro3.bai_orders_db_confirm where order_tid=\"".$order_tid_ref[$i4]."\"";
					//echo $sql68."<br>";
					$sql_result68=mysqli_query($link, $sql68) or exit("Sql Error6".$sql6.mysqli_error($GLOBALS["___mysqli_ston"]));
					while($sql_row68=mysqli_fetch_array($sql_result68))
					{
						$order_style_no=$sql_row68["order_style_no"];
						$order_del_no=$sql_row68["order_del_no"];
						$order_col_des=$sql_row68["order_col_des"];
					}
					for($i2=0;$i2<sizeof($sizes_array);$i2++)
					{
						$sub_doc_size_qty=0;
						$sql4="select p_".$sizes_array[$i2]." as size_qty from bai_pro3.plandoc_stat_log where order_tid=\"".$order_tid_ref[$i4]."\" and doc_no='".$doc_no_ref2[$i4]."'"; 
						$sql_result4=mysqli_query($link, $sql4) or exit("Sql Error4".mysqli_error($GLOBALS["___mysqli_ston"]));
						while($sql_row4=mysqli_fetch_array($sql_result4))
						{
							$sub_doc_size_qty=$sql_row4['size_qty'];
							//$sub_doc_no=$sql_row4['doc_no'];
						}
						if($sub_doc_size_qty > 0)
						{
							$sql5="insert into m3_bulk_ops_rep_db.m3_sfcs_tran_log(sfcs_date,sfcs_size,sfcs_doc_no,sfcs_style,sfcs_schedule,sfcs_color,sfcs_qty,sfcs_log_user,sfcs_status,sfcs_tid_ref,m3_op_des) values(NOW(),'".$sizes_array[$i2]."','".$doc_no_ref2[$i4]."','".$order_style_no."','".$order_del_no."','".$order_col_des."','".$sub_doc_size_qty."','".$username."',0,'".$doc_no_ref2[$i4]."','CUT')";
							mysqli_query($link, $sql5) or exit("Sql Error5".mysqli_error($GLOBALS["___mysqli_ston"]));
							
							$sql61="update bai_pro3.plandoc_stat_log set a_".$sizes_array[$i2]."=p_".$sizes_array[$i2]." where doc_no='".$doc_no_ref2[$i4]."'";
							mysqli_query($link, $sql61) or exit("Sql Error61".mysqli_error($GLOBALS["___mysqli_ston"]));
						}
					}
					$sql12="insert ignore into act_cut_status (doc_no) values ($doc_no_ref2[$i4])";
					//echo $sql12."<br>";
					mysqli_query($link, $sql12) or exit("Sql Error112".mysqli_error($GLOBALS["___mysqli_ston"]));

					
					$sql14="update act_cut_status set date=\"$input_date\", section=\"$input_section\", shift=\"$input_shift\", fab_received='0', fab_returned='0', damages='0', shortages='0', remarks='', bundle_loc=\"$bun_loc\" where doc_no='$doc_no_ref2[$i4]'";
					//echo $sql14."<br>";
					$sql_result=mysqli_query($link, $sql14) or exit("Sql Error14".mysqli_error($GLOBALS["___mysqli_ston"]));

				}
				$ret='TRUE'; 
			}
			else
			{
				
			}	
			*/
			$ret=update_m3_or($input_doc_no,$plies,'CUT',$old_plies,$link);
			
			
			if($ret=="TRUE")
			{	
				//Logic for Location mapping -- Satish 23/11/2017		
				$findDocket="select * from $bai_pro3.doc_loc_mapping where doc_no=$input_doc_no";
				$docket_result=mysqli_query($link, $findDocket) or exit("Sql Error at finding docket".mysqli_error($GLOBALS["___mysqli_ston"]));
				$docket_num_check=mysqli_num_rows($docket_result);
				if($docket_num_check>0){
					$findLocation="SELECT DISTINCT doc_loc_mapping.doc_no,locations.filled_qty,locations.loc_id,locations.loc_name,locations.capacity FROM $bai_pro3.locations LEFT JOIN $bai_pro3.doc_loc_mapping ON locations.loc_id = doc_loc_mapping.loc_id WHERE filled_qty < capacity AND (doc_no=$input_doc_no OR doc_no IS NULL)";
					$location_result=mysqli_query($link, $findLocation) or exit("Sql Error at finding location".mysqli_error($GLOBALS["___mysqli_ston"]));
					$location_num_check=mysqli_num_rows($location_result);				
					if($location_num_check>0){					
						$bun_loc = "";
						$total=($_POST['total']*$plies)/$p_plies;
						$emptylocsum = "SELECT DISTINCT doc_loc_mapping.doc_no,(SUM(locations.capacity)- SUM(locations.filled_qty))AS empty_qty, SUM(locations.filled_qty) AS filled_qty FROM $bai_pro3.locations LEFT JOIN $bai_pro3.doc_loc_mapping ON locations.loc_id = doc_loc_mapping.loc_id WHERE filled_qty < capacity AND (doc_no=$input_doc_no OR doc_no IS NULL)";
						$emptylocsum_result=mysqli_query($link, $emptylocsum) or exit("Sql Error at finding empty quantites sum".mysqli_error($GLOBALS["___mysqli_ston"]));
						$emptyqtysum = mysqli_fetch_row($emptylocsum_result);
						if($total <= $emptyqtysum[1]){
							while($row = mysqli_fetch_array($location_result)){
								$loc_id = $row['loc_id'];
								$bun_loc.= $row['loc_name']."$";
								$emptyqty = $row['capacity'] - $row['filled_qty'];
								if($total <= $emptyqty){
									$bundles = $total/$plies;					
									$doc_locations="insert into $bai_pro3.doc_loc_mapping (doc_no,loc_id,pcsqty,bundlesqty,pliesqty) values ($input_doc_no,$loc_id,$total,$bundles,$plies)";
									mysqli_query($link, $doc_locations) or exit("Sql Error a inserting into doc_loc_mapping".mysqli_error($GLOBALS["___mysqli_ston"]));
									if($loc_id){
										$get_location_qty = "select filled_qty from $bai_pro3.locations where loc_id=$loc_id";			
										$row = mysqli_query($link, $get_location_qty) or exit("Sql Error at finding filled quantity".mysqli_error($GLOBALS["___mysqli_ston"]));
										$filled_result =mysqli_fetch_assoc($row);
										$filled_qty = $filled_result['filled_qty']+$total;			
										$updating_filled_qty="update $bai_pro3.locations set filled_qty=$filled_qty where loc_id=$loc_id";
										mysqli_query($link, $updating_filled_qty) or exit("Sql Error at location filled_qty updating".mysqli_error($GLOBALS["___mysqli_ston"]));
									}else{
										echo "<sccript>sweetAlert('Location is not available.Please check once','','warning');</script>";
										echo "<a class='btn btn-warning' href='".getFullURL($_GET['r'],'doc_track_panel.php','N')."'><< Go back to Cut quantity reporting screen</a>";
										die();
									}
									break;
								}else if($total > $emptyqty){
									$capacity = $emptyqty;
									$bundles = $capacity/$plies;
									$doc_locations="insert into $bai_pro3.doc_loc_mapping (doc_no,loc_id,pcsqty,bundlesqty,pliesqty) values ($input_doc_no,$loc_id,$capacity,$bundles,$plies)";
									mysqli_query($link, $doc_locations) or exit("Sql Error a inserting into doc_loc_mapping".mysqli_error($GLOBALS["___mysqli_ston"]));
									if($loc_id){
										$get_location_qty = "select filled_qty from $bai_pro3.locations where loc_id=$loc_id";			
										$row = mysqli_query($link, $get_location_qty) or exit("Sql Error at finding filled quantity".mysqli_error($GLOBALS["___mysqli_ston"]));
										$filled_result =mysqli_fetch_assoc($row);
										$filled_qty = $filled_result['filled_qty']+$capacity;			
										$updating_filled_qty="update $bai_pro3.locations set filled_qty=$filled_qty where loc_id=$loc_id";
										mysqli_query($link, $updating_filled_qty) or exit("Sql Error at location filled_qty updating".mysqli_error($GLOBALS["___mysqli_ston"]));
									}else{
										echo "<sccript>sweetAlert('Location is not available.Please check once','','warning');</script>";
										echo "<a class='btn btn-warning' href='".getFullURL($_GET['r'],'doc_track_panel.php','N')."'><< Go back to Cut quantity reporting screen</a>";
									}
									$total = $total-$capacity;
								}
							}

							$sql="insert ignore into $bai_pro3.act_cut_status (doc_no) values ($input_doc_no)";				
							mysqli_query($link, $sql) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
							
							$sql="update $bai_pro3.act_cut_status set date=\"$input_date\", section=\"$input_section\", shift=\"$input_shift\", fab_received=$input_fab_rec, fab_returned=$input_fab_ret, damages=$input_damages, shortages=$input_shortages, remarks=\"$input_remarks\", bundle_loc=concat(bundle_loc,'$','$bun_loc') where doc_no=$input_doc_no";					
							mysqli_query($link, $sql) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));				
							
							// New Ratio with same plies logic = Satish 21/12/2017
							if($newratio == "yes"){
								$tot = $p_plies - $plies;
								if($tot != 0){
									$maxcutno = "SELECT MAX(pcutno)+1 AS pcutno FROM $bai_pro3.plandoc_stat_log WHERE CONCAT(order_tid,cat_ref) IN (SELECT CONCAT(order_tid,cat_ref) FROM $bai_pro3.plandoc_stat_log WHERE doc_no = $input_doc_no)";
									$result = mysqli_query($link, $maxcutno) or exit("Sql Error a getting max pcutno & acutno".mysqli_error($GLOBALS["___mysqli_ston"]));
									$newcutno = mysqli_fetch_row($result);
									$new_plies = $p_plies - $plies; 
									$insert_newcut_2_plandocstatlog="INSERT INTO $bai_pro3.`plandoc_stat_log` (`date`, `cat_ref`, `cuttable_ref`, `allocate_ref`, `mk_ref`, `order_tid`, `pcutno`, `ratio`, `p_xs`, `p_s`, `p_m`, `p_l`, `p_xl`, `p_xxl`, `p_xxxl`, `p_plies`, `acutno`, `a_xs`, `a_s`, `a_m`, `a_l`, `a_xl`, `a_xxl`, `a_xxxl`, `a_plies`, `remarks`, `pcutdocid`, `a_s01`, `a_s02`, `a_s03`, `a_s04`, `a_s05`, `a_s06`, `a_s07`, `a_s08`, `a_s09`, `a_s10`, `a_s11`, `a_s12`, `a_s13`, `a_s14`, `a_s15`, `a_s16`, `a_s17`, `a_s18`, `a_s19`, `a_s20`, `a_s21`, `a_s22`, `a_s23`, `a_s24`, `a_s25`, `a_s26`, `a_s27`, `a_s28`, `a_s29`, `a_s30`, `a_s31`, `a_s32`, `a_s33`, `a_s34`, `a_s35`, `a_s36`, `a_s37`, `a_s38`, `a_s39`, `a_s40`, `a_s41`, `a_s42`, `a_s43`, `a_s44`, `a_s45`, `a_s46`, `a_s47`, `a_s48`, `a_s49`, `a_s50`, `p_s01`, `p_s02`, `p_s03`, `p_s04`, `p_s05`, `p_s06`, `p_s07`, `p_s08`, `p_s09`, `p_s10`, `p_s11`, `p_s12`, `p_s13`, `p_s14`, `p_s15`, `p_s16`, `p_s17`, `p_s18`, `p_s19`, `p_s20`, `p_s21`, `p_s22`, `p_s23`, `p_s24`, `p_s25`, `p_s26`, `p_s27`, `p_s28`, `p_s29`, `p_s30`, `p_s31`, `p_s32`, `p_s33`, `p_s34`, `p_s35`, `p_s36`, `p_s37`, `p_s38`, `p_s39`, `p_s40`, `p_s41`, `p_s42`, `p_s43`, `p_s44`, `p_s45`, `p_s46`, `p_s47`, `p_s48`, `p_s49`, `p_s50`, `destination`,`doc_no_ref`) SELECT NOW(), `cat_ref`, `cuttable_ref`, `allocate_ref`, `mk_ref`, `order_tid`, $newcutno[0], `ratio`, `p_xs`, `p_s`, `p_m`, `p_l`, `p_xl`, `p_xxl`, `p_xxxl`, $new_plies, $newcutno[0], `a_xs`, `a_s`, `a_m`, `a_l`, `a_xl`, `a_xxl`, `a_xxxl`, $new_plies,`remarks`, `pcutdocid`, `a_s01`, `a_s02`, `a_s03`, `a_s04`, `a_s05`, `a_s06`, `a_s07`, `a_s08`, `a_s09`, `a_s10`, `a_s11`, `a_s12`, `a_s13`, `a_s14`, `a_s15`, `a_s16`, `a_s17`, `a_s18`, `a_s19`, `a_s20`, `a_s21`, `a_s22`, `a_s23`, `a_s24`, `a_s25`, `a_s26`, `a_s27`, `a_s28`, `a_s29`, `a_s30`, `a_s31`, `a_s32`, `a_s33`, `a_s34`, `a_s35`, `a_s36`, `a_s37`, `a_s38`, `a_s39`, `a_s40`, `a_s41`, `a_s42`, `a_s43`, `a_s44`, `a_s45`, `a_s46`, `a_s47`, `a_s48`, `a_s49`, `a_s50`, `p_s01`, `p_s02`, `p_s03`, `p_s04`, `p_s05`, `p_s06`, `p_s07`, `p_s08`, `p_s09`, `p_s10`, `p_s11`, `p_s12`, `p_s13`, `p_s14`, `p_s15`, `p_s16`, `p_s17`, `p_s18`, `p_s19`, `p_s20`, `p_s21`, `p_s22`, `p_s23`, `p_s24`, `p_s25`, `p_s26`, `p_s27`, `p_s28`, `p_s29`, `p_s30`, `p_s31`, `p_s32`, `p_s33`, `p_s34`, `p_s35`, `p_s36`, `p_s37`, `p_s38`, `p_s39`, `p_s40`, `p_s41`, `p_s42`, `p_s43`, `p_s44`, `p_s45`, `p_s46`, `p_s47`, `p_s48`, `p_s49`, `p_s50`, `destination`,$input_doc_no from  $bai_pro3.plandoc_stat_log WHERE doc_no=$input_doc_no";
									mysqli_query($link, $insert_newcut_2_plandocstatlog) or exit("Sql Error a inserting into plandoc_stat_log new cut".mysqli_error($GLOBALS["___mysqli_ston"]));
								}else if($tot == 0){
									echo "<script>sweetAlert('Plies must change to create new docket with the same ratio.','Please change plies','error');</script>";
									echo "<a class='btn btn-warning' href='".getFullURL($_GET['r'],'doc_track_panel.php','N')."'><< Go back to Cut quantity reporting screen</a>";
									die();
								}
							}
							
							$sql1="update $bai_pro3.plandoc_stat_log set act_cut_status=\"DONE\", a_plies=".($plies+$old_plies).",p_plies=".($plies+$old_plies).",pcutdocid=concat(pcutdocid,'$','$bun_loc') where doc_no=$input_doc_no";					
							mysqli_query($link, $sql1) or exit("Sql Error3$sql1".mysqli_error($GLOBALS["___mysqli_ston"]));
							
							
							//Role table logic - Satish 27/12/2017
							updateRoleData($roledata,$link);
							//Anil Logic
							//UpdateActMovementStatus($input_doc_no,$link);
							echo "<script>sweetAlert('Cut Quantity Reported Successfully','','success');</script>";
							echo "<a class='btn btn-warning' href='".getFullURL($_GET['r'],'doc_track_panel.php','N')."'><< Go back to Cut quantity reporting screen</a>";
					    	//Locations display for docket after saving = Satish 21/12/2017
					    	$getLocations = "SELECT locations.loc_name,locations.capacity,locations.filled_qty FROM $bai_pro3.locations LEFT JOIN $bai_pro3.doc_loc_mapping ON doc_loc_mapping.loc_id = locations.loc_id WHERE doc_loc_mapping.doc_no = $input_doc_no group By locations.loc_name";
					    	$locations = mysqli_query($link, $getLocations) or exit("Sql Error at getting into locations for the docket".mysqli_error($GLOBALS["___mysqli_ston"]));					   		
					   		echo "<h2>Please put bundles in the below empty locations for this docket</h2>";
					   		$tableData = "";
					   		while($row = mysqli_fetch_array($locations)){
				   				if($row['filled_qty']<=$row['capacity']){		   					
				   					$tableData.="<td class='cell'>".$row['loc_name']."<br/> Capacity-(".$row['capacity'].")</td>";
				   				}				   				
				   			}
					   		echo "<table>
					   					<tbody><tr>".$tableData."</tr></tbody>
					   				</table>";
					   		die();
					    }else{

					    	echo "<script>sweetAlert('Locations are not enough to fill the required quantity..','Please process bundles to sewing in','error')</script>";
							echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",4000); function Redirect() {  location.href = '".getFullURL($_GET['r'],'doc_track_panel.php','N')."'; }</script>";
						//	echo "<a class='btn btn-warning' href='".getFullURL($_GET['r'],'doc_track_panel.php','N')."'><< Go back to Cut quantity reporting screen</a>";
					    }
					}else{
						$get_locations = "select * from $bai_pro3.locations where filled_qty = 0";
						$location_result=mysqli_query($link, $get_locations) or exit("Sql Error at finding locations".mysqli_error($GLOBALS["___mysqli_ston"]));	
						$location_num_check=mysqli_num_rows($location_result);
						if($location_num_check > 0){
							$bun_loc = "";
							$total=($_POST['total']*$plies)/$p_plies;	
							$emptylocssum = "SELECT (SUM(capacity)-SUM(filled_qty)) AS emptyqty FROM $bai_pro3.locations";
							$emptylocssum_result=mysqli_query($link, $emptylocssum) or exit("Sql Error at finding empty quantites sum".mysqli_error($GLOBALS["___mysqli_ston"]));
							$emptyqty = mysqli_fetch_row($emptylocssum_result);
							if($total <= $emptyqty[0]){				
								while($row = mysqli_fetch_array($location_result)){
									$loc_id = $row['loc_id'];
									$bun_loc.= $row['loc_name']."$";
									if($total <= $row['capacity']){
										$bundles = $total/$plies;					
										$doc_locations="insert into $bai_pro3.doc_loc_mapping (doc_no,loc_id,pcsqty,bundlesqty,pliesqty) values ($input_doc_no,$loc_id,$total,$bundles,$plies)";
										mysqli_query($link, $doc_locations) or exit("Sql Error a inserting into doc_loc_mapping".mysqli_error($GLOBALS["___mysqli_ston"]));
										if($loc_id){
											$get_location_qty = "select filled_qty from $bai_pro3.locations where loc_id=$loc_id";			
											$row = mysqli_query($link, $get_location_qty) or exit("Sql Error at finding filled quantity".mysqli_error($GLOBALS["___mysqli_ston"]));
											$filled_result =mysqli_fetch_assoc($row);
											$filled_qty = $filled_result['filled_qty']+$total;			
											$updating_filled_qty="update $bai_pro3.locations set filled_qty=$filled_qty where loc_id=$loc_id";
											mysqli_query($link, $updating_filled_qty) or exit("Sql Error at location filled_qty updating".mysqli_error($GLOBALS["___mysqli_ston"]));
										}else{
											echo "<script>sweetAlert('Location is not available Please check once','','warning');</script>";
											echo "<a class='btn btn-warning' href='".getFullURL($_GET['r'],'doc_track_panel.php','N')."'><< Go back to Cut quantity reporting screen</a>";
											die();
										}
										break;
									}else if($total > $row['capacity']){
										$capacity = $row['capacity'];
										$bundles = $capacity/$plies;
										$doc_locations="insert into $bai_pro3.doc_loc_mapping (doc_no,loc_id,pcsqty,bundlesqty,pliesqty) values ($input_doc_no,$loc_id,$capacity,$bundles,$plies)";
										mysqli_query($link, $doc_locations) or exit("Sql Error a inserting into doc_loc_mapping".mysqli_error($GLOBALS["___mysqli_ston"]));
										if($loc_id){
											$get_location_qty = "select filled_qty from $bai_pro3.locations where loc_id=$loc_id";			
											$row = mysqli_query($link, $get_location_qty) or exit("Sql Error at finding filled quantity".mysqli_error($GLOBALS["___mysqli_ston"]));
											$filled_result =mysqli_fetch_assoc($row);
											$filled_qty = $filled_result['filled_qty']+$capacity;			
											$updating_filled_qty="update $bai_pro3.locations set filled_qty=$filled_qty where loc_id=$loc_id";
											mysqli_query($link, $updating_filled_qty) or exit("Sql Error at location filled_qty updating".mysqli_error($GLOBALS["___mysqli_ston"]));
										}else{
											echo "<script>sweetAlert('Location is not available Please check once','','warning');</script>";
											echo "<a class='btn btn-warning' href='".getFullURL($_GET['r'],'doc_track_panel.php','N')."'><< Go back to Cut quantity reporting screen</a>";
											die();
										}
										$total = $total-$capacity;
									}
								}

								$sql="insert ignore into $bai_pro3.act_cut_status (doc_no) values ($input_doc_no)";				
								mysqli_query($link, $sql) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));

								$sql="update $bai_pro3.act_cut_status set date=\"$input_date\", section=\"$input_section\", shift=\"$input_shift\", fab_received=$input_fab_rec, fab_returned=$input_fab_ret, damages=$input_damages, shortages=$input_shortages, remarks=\"$input_remarks\", bundle_loc=\"$bun_loc\" where doc_no=$input_doc_no";					
								mysqli_query($link, $sql) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));					
								
								if($newratio == "yes"){
									$tot = $p_plies - $plies;
									if($tot != 0){
										$maxcutno = "SELECT MAX(pcutno)+1 AS pcutno FROM $bai_pro3.plandoc_stat_log WHERE CONCAT(order_tid,cat_ref) IN (SELECT CONCAT(order_tid,cat_ref) FROM $bai_pro3.plandoc_stat_log WHERE doc_no = $input_doc_no)";
										$result = mysqli_query($link, $maxcutno) or exit("Sql Error a getting max pcutno & acutno".mysqli_error($GLOBALS["___mysqli_ston"]));
										$newcutno = mysqli_fetch_row($result);
										$new_plies = $p_plies - $plies; 
										$insert_newcut_2_plandocstatlog="INSERT INTO $bai_pro3.`plandoc_stat_log` (`date`, `cat_ref`, `cuttable_ref`, `allocate_ref`, `mk_ref`, `order_tid`, `pcutno`, `ratio`, `p_xs`, `p_s`, `p_m`, `p_l`, `p_xl`, `p_xxl`, `p_xxxl`, `p_plies`, `acutno`, `a_xs`, `a_s`, `a_m`, `a_l`, `a_xl`, `a_xxl`, `a_xxxl`, `a_plies`, `remarks`, `pcutdocid`, `a_s01`, `a_s02`, `a_s03`, `a_s04`, `a_s05`, `a_s06`, `a_s07`, `a_s08`, `a_s09`, `a_s10`, `a_s11`, `a_s12`, `a_s13`, `a_s14`, `a_s15`, `a_s16`, `a_s17`, `a_s18`, `a_s19`, `a_s20`, `a_s21`, `a_s22`, `a_s23`, `a_s24`, `a_s25`, `a_s26`, `a_s27`, `a_s28`, `a_s29`, `a_s30`, `a_s31`, `a_s32`, `a_s33`, `a_s34`, `a_s35`, `a_s36`, `a_s37`, `a_s38`, `a_s39`, `a_s40`, `a_s41`, `a_s42`, `a_s43`, `a_s44`, `a_s45`, `a_s46`, `a_s47`, `a_s48`, `a_s49`, `a_s50`, `p_s01`, `p_s02`, `p_s03`, `p_s04`, `p_s05`, `p_s06`, `p_s07`, `p_s08`, `p_s09`, `p_s10`, `p_s11`, `p_s12`, `p_s13`, `p_s14`, `p_s15`, `p_s16`, `p_s17`, `p_s18`, `p_s19`, `p_s20`, `p_s21`, `p_s22`, `p_s23`, `p_s24`, `p_s25`, `p_s26`, `p_s27`, `p_s28`, `p_s29`, `p_s30`, `p_s31`, `p_s32`, `p_s33`, `p_s34`, `p_s35`, `p_s36`, `p_s37`, `p_s38`, `p_s39`, `p_s40`, `p_s41`, `p_s42`, `p_s43`, `p_s44`, `p_s45`, `p_s46`, `p_s47`, `p_s48`, `p_s49`, `p_s50`, `destination`,`doc_no_ref`) SELECT NOW(), `cat_ref`, `cuttable_ref`, `allocate_ref`, `mk_ref`, `order_tid`, $newcutno[0], `ratio`, `p_xs`, `p_s`, `p_m`, `p_l`, `p_xl`, `p_xxl`, `p_xxxl`, $new_plies, $newcutno[0], `a_xs`, `a_s`, `a_m`, `a_l`, `a_xl`, `a_xxl`, `a_xxxl`, $new_plies,`remarks`, `pcutdocid`, `a_s01`, `a_s02`, `a_s03`, `a_s04`, `a_s05`, `a_s06`, `a_s07`, `a_s08`, `a_s09`, `a_s10`, `a_s11`, `a_s12`, `a_s13`, `a_s14`, `a_s15`, `a_s16`, `a_s17`, `a_s18`, `a_s19`, `a_s20`, `a_s21`, `a_s22`, `a_s23`, `a_s24`, `a_s25`, `a_s26`, `a_s27`, `a_s28`, `a_s29`, `a_s30`, `a_s31`, `a_s32`, `a_s33`, `a_s34`, `a_s35`, `a_s36`, `a_s37`, `a_s38`, `a_s39`, `a_s40`, `a_s41`, `a_s42`, `a_s43`, `a_s44`, `a_s45`, `a_s46`, `a_s47`, `a_s48`, `a_s49`, `a_s50`, `p_s01`, `p_s02`, `p_s03`, `p_s04`, `p_s05`, `p_s06`, `p_s07`, `p_s08`, `p_s09`, `p_s10`, `p_s11`, `p_s12`, `p_s13`, `p_s14`, `p_s15`, `p_s16`, `p_s17`, `p_s18`, `p_s19`, `p_s20`, `p_s21`, `p_s22`, `p_s23`, `p_s24`, `p_s25`, `p_s26`, `p_s27`, `p_s28`, `p_s29`, `p_s30`, `p_s31`, `p_s32`, `p_s33`, `p_s34`, `p_s35`, `p_s36`, `p_s37`, `p_s38`, `p_s39`, `p_s40`, `p_s41`, `p_s42`, `p_s43`, `p_s44`, `p_s45`, `p_s46`, `p_s47`, `p_s48`, `p_s49`, `p_s50`, `destination`,$input_doc_no from  $bai_pro3.plandoc_stat_log WHERE doc_no=$input_doc_no";
										mysqli_query($link, $insert_newcut_2_plandocstatlog) or exit("Sql Error a inserting into plandoc_stat_log new cut".mysqli_error($GLOBALS["___mysqli_ston"]));
									}else if($tot == 0){
										echo "<script>sweetAlert('Plies must change to create new docket with the same ratio.','Please change plies','warning');
											  </script>";
											  echo "<a class='btn btn-warning' href='".getFullURL($_GET['r'],'doc_track_panel.php','N')."'><< Go back to Cut quantity reporting screen</a>";
											  die();
									}
								}

								$sql1="update $bai_pro3.plandoc_stat_log set act_cut_status=\"DONE\", a_plies=".($plies+$old_plies).",p_plies=".($plies+$old_plies).",pcutdocid=concat(pcutdocid,'$','$bun_loc') where doc_no=$input_doc_no";					
								mysqli_query($link, $sql1) or exit("Sql Error3$sql1".mysqli_error($GLOBALS["___mysqli_ston"]));							
	
								//Role table logic - Satish 27/12/2017
								updateRoleData($roledata,$link);
								//Anil Logic
								//UpdateActMovementStatus($input_doc_no,$link);
								echo "<script>sweetAlert('Cut Quantity Reported Successfully','','success');</script>";
								//echo "<h3><span style='color:green;'>Successfully Cut Quantity reported</span></h3>";
								echo "<a class='btn btn-warning' href='".getFullURL($_GET['r'],'doc_track_panel.php','N')."'><< Go back to Cut quantity reporting screen</a>";
								//Locations display for docket after saving = Satish 21/12/2017
						    	$getLocations = "SELECT locations.loc_name,locations.capacity,locations.filled_qty FROM $bai_pro3.locations LEFT JOIN $bai_pro3.doc_loc_mapping ON doc_loc_mapping.loc_id = locations.loc_id WHERE doc_loc_mapping.doc_no = $input_doc_no group By locations.loc_name";
						    	$locations = mysqli_query($link, $getLocations) or exit("Sql Error at getting into locations for the docket".mysqli_error($GLOBALS["___mysqli_ston"]));
						   		
						   		echo "<h2>Please put bundles in the below locations for this docket</h2>";
						   		$tableData = "";
						   		while($row = mysqli_fetch_array($locations)){
					   				if($row['filled_qty']<=$row['capacity']){		   					
					   					$tableData.="<td class='cell'>".$row['loc_name']."<br/> Capacity-(".$row['capacity'].")</td>";
					   				}				   				
					   			}
						   		echo "<table>
						   					<tbody><tr>".$tableData."</tr></tbody>
						   				</table>";
					    		die();
					    	}else{
								echo "<script>sweetAlert('Locations are not enough to fill the required quantity..','Please process bundles to sewing in','warning');</script>";
							//	echo "<h2><span style='color:red;'>Locations are not enough to fill the required quantity.. Please process bundles to sewing in</span></h2>";
							//	echo "<a class='btn btn-warning' href='".getFullURL($_GET['r'],'doc_track_panel.php','N')."'><< Go back to Cut quantity reporting screen</a>";
								echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",4000); function Redirect() {  location.href = '".getFullURL($_GET['r'],'doc_track_panel.php','N')."'; }</script>";	
								die();
							}
						}else{
							echo "<script>sweetAlert('All locations filled..','Please process bundles to sewing in','error');</script>";
							echo "<a class='btn btn-warning' href='".getFullURL($_GET['r'],'doc_track_panel.php','N')."'><< Go back to Cut quantity reporting screen</a>";
							die();
						}
					}				
				}else{
					$get_locations = "select * from $bai_pro3.locations where filled_qty = 0";
					$location_result=mysqli_query($link, $get_locations) or exit("Sql Error at finding locations".mysqli_error($GLOBALS["___mysqli_ston"]));
					$location_num_check=mysqli_num_rows($location_result);
					if($location_num_check >= 0){
						$bun_loc = "";
						$total=($_POST['total']*$plies)/$p_plies;
						$emptylocssum = "SELECT (SUM(capacity)-SUM(filled_qty)) AS emptyqty FROM $bai_pro3.locations";
						$emptylocssum_result=mysqli_query($link, $emptylocssum) or exit("Sql Error at finding empty quantites sum".mysqli_error($GLOBALS["___mysqli_ston"]));
						$emptyqty = mysqli_fetch_row($emptylocssum_result);
						if($total < $emptyqty[0]){
							while($row = mysqli_fetch_array($location_result)){
							$loc_id = $row['loc_id'];
							$bun_loc.= $row['loc_name']."$";
							if($total <= $row['capacity']){
								$bundles = $total/$plies;					
								$doc_locations="insert into $bai_pro3.doc_loc_mapping (doc_no,loc_id,pcsqty,bundlesqty,pliesqty) values ($input_doc_no,$loc_id,$total,$bundles,$plies)";
								mysqli_query($link, $doc_locations) or exit("Sql Error a inserting into doc_loc_mapping".mysqli_error($GLOBALS["___mysqli_ston"]));
								if($loc_id){
									$get_location_qty = "select filled_qty from $bai_pro3.locations where loc_id=$loc_id";			
									$row = mysqli_query($link, $get_location_qty) or exit("Sql Error at finding filled quantity".mysqli_error($GLOBALS["___mysqli_ston"]));
									$filled_result =mysqli_fetch_assoc($row);
									$filled_qty = $filled_result['filled_qty']+$total;			
									$updating_filled_qty="update $bai_pro3.locations set filled_qty=$filled_qty where loc_id=$loc_id";
									mysqli_query($link, $updating_filled_qty) or exit("Sql Error at location filled_qty updating".mysqli_error($GLOBALS["___mysqli_ston"]));
								}else{
								//	echo "<h3><span style='color:red;'>Location is not available Please check once</span></h3>";
									echo "<script>sweetAlert('Location is not avvailable','Please check once','error');</script>";	
									echo "<a class='btn btn-
									
									warning' href='".getFullURL($_GET['r'],'doc_track_panel.php','N')."'><< Go back to Cut quantity reporting screen</a>";
									die();
								}						
								break;
							}else if($total > $row['capacity']){
								$capacity = $row['capacity'];
								$bundles = $capacity/$plies;
								$doc_locations="insert into $bai_pro3.doc_loc_mapping (doc_no,loc_id,pcsqty,bundlesqty,pliesqty) values ($input_doc_no,$loc_id,$capacity,$bundles,$plies)";
								mysqli_query($link, $doc_locations) or exit("Sql Error a inserting into doc_loc_mapping".mysqli_error($GLOBALS["___mysqli_ston"]));
								if($loc_id){
									$get_location_qty = "select filled_qty from $bai_pro3.locations where loc_id=$loc_id";			
									$row = mysqli_query($link, $get_location_qty) or exit("Sql Error at finding filled quantity".mysqli_error($GLOBALS["___mysqli_ston"]));
									$filled_result =mysqli_fetch_assoc($row);
									$filled_qty = $filled_result['filled_qty']+$capacity;			
									$updating_filled_qty="update $bai_pro3.locations set filled_qty=$filled_qty where loc_id=$loc_id";
									mysqli_query($link, $updating_filled_qty) or exit("Sql Error at location filled_qty updating".mysqli_error($GLOBALS["___mysqli_ston"]));
								}else{
									echo "<script>sweetAlert('Location is not available','Please Check Once','error');</script>";
									echo "<a class='btn btn-warning' href='".getFullURL($_GET['r'],'doc_track_panel.php','N')."'><< Go back to Cut quantity reporting screen</a>";
									die();
								//	echo "<h3><span style='color:red;'>Location is not available Please check once</span></h3>";die();
								}
								$total = $total-$capacity;
							}
						}

							
							if($newratio == "yes"){
								$tot = $p_plies - $plies;
								if($tot != 0){
									$maxcutno = "SELECT MAX(pcutno)+1 AS pcutno FROM $bai_pro3.plandoc_stat_log WHERE CONCAT(order_tid,cat_ref) IN (SELECT CONCAT(order_tid,cat_ref) FROM $bai_pro3.plandoc_stat_log WHERE doc_no = $input_doc_no)";
									$result = mysqli_query($link, $maxcutno) or exit("Sql Error a getting max pcutno & acutno".mysqli_error($GLOBALS["___mysqli_ston"]));
									$newcutno = mysqli_fetch_row($result);
									$new_plies = $p_plies - $plies; 
									$insert_newcut_2_plandocstatlog="INSERT INTO $bai_pro3.`plandoc_stat_log` (`date`, `cat_ref`, `cuttable_ref`, `allocate_ref`, `mk_ref`, `order_tid`, `pcutno`, `ratio`, `p_xs`, `p_s`, `p_m`, `p_l`, `p_xl`, `p_xxl`, `p_xxxl`, `p_plies`, `acutno`, `a_xs`, `a_s`, `a_m`, `a_l`, `a_xl`, `a_xxl`, `a_xxxl`, `a_plies`, `remarks`, `pcutdocid`, `a_s01`, `a_s02`, `a_s03`, `a_s04`, `a_s05`, `a_s06`, `a_s07`, `a_s08`, `a_s09`, `a_s10`, `a_s11`, `a_s12`, `a_s13`, `a_s14`, `a_s15`, `a_s16`, `a_s17`, `a_s18`, `a_s19`, `a_s20`, `a_s21`, `a_s22`, `a_s23`, `a_s24`, `a_s25`, `a_s26`, `a_s27`, `a_s28`, `a_s29`, `a_s30`, `a_s31`, `a_s32`, `a_s33`, `a_s34`, `a_s35`, `a_s36`, `a_s37`, `a_s38`, `a_s39`, `a_s40`, `a_s41`, `a_s42`, `a_s43`, `a_s44`, `a_s45`, `a_s46`, `a_s47`, `a_s48`, `a_s49`, `a_s50`, `p_s01`, `p_s02`, `p_s03`, `p_s04`, `p_s05`, `p_s06`, `p_s07`, `p_s08`, `p_s09`, `p_s10`, `p_s11`, `p_s12`, `p_s13`, `p_s14`, `p_s15`, `p_s16`, `p_s17`, `p_s18`, `p_s19`, `p_s20`, `p_s21`, `p_s22`, `p_s23`, `p_s24`, `p_s25`, `p_s26`, `p_s27`, `p_s28`, `p_s29`, `p_s30`, `p_s31`, `p_s32`, `p_s33`, `p_s34`, `p_s35`, `p_s36`, `p_s37`, `p_s38`, `p_s39`, `p_s40`, `p_s41`, `p_s42`, `p_s43`, `p_s44`, `p_s45`, `p_s46`, `p_s47`, `p_s48`, `p_s49`, `p_s50`, `destination`,`doc_no_ref`) SELECT NOW(), `cat_ref`, `cuttable_ref`, `allocate_ref`, `mk_ref`, `order_tid`, $newcutno[0], `ratio`, `p_xs`, `p_s`, `p_m`, `p_l`, `p_xl`, `p_xxl`, `p_xxxl`, $new_plies, $newcutno[0], `a_xs`, `a_s`, `a_m`, `a_l`, `a_xl`, `a_xxl`, `a_xxxl`, $new_plies,`remarks`, `pcutdocid`, `a_s01`, `a_s02`, `a_s03`, `a_s04`, `a_s05`, `a_s06`, `a_s07`, `a_s08`, `a_s09`, `a_s10`, `a_s11`, `a_s12`, `a_s13`, `a_s14`, `a_s15`, `a_s16`, `a_s17`, `a_s18`, `a_s19`, `a_s20`, `a_s21`, `a_s22`, `a_s23`, `a_s24`, `a_s25`, `a_s26`, `a_s27`, `a_s28`, `a_s29`, `a_s30`, `a_s31`, `a_s32`, `a_s33`, `a_s34`, `a_s35`, `a_s36`, `a_s37`, `a_s38`, `a_s39`, `a_s40`, `a_s41`, `a_s42`, `a_s43`, `a_s44`, `a_s45`, `a_s46`, `a_s47`, `a_s48`, `a_s49`, `a_s50`, `p_s01`, `p_s02`, `p_s03`, `p_s04`, `p_s05`, `p_s06`, `p_s07`, `p_s08`, `p_s09`, `p_s10`, `p_s11`, `p_s12`, `p_s13`, `p_s14`, `p_s15`, `p_s16`, `p_s17`, `p_s18`, `p_s19`, `p_s20`, `p_s21`, `p_s22`, `p_s23`, `p_s24`, `p_s25`, `p_s26`, `p_s27`, `p_s28`, `p_s29`, `p_s30`, `p_s31`, `p_s32`, `p_s33`, `p_s34`, `p_s35`, `p_s36`, `p_s37`, `p_s38`, `p_s39`, `p_s40`, `p_s41`, `p_s42`, `p_s43`, `p_s44`, `p_s45`, `p_s46`, `p_s47`, `p_s48`, `p_s49`, `p_s50`, `destination`,$input_doc_no from  $bai_pro3.plandoc_stat_log WHERE doc_no=$input_doc_no";
									mysqli_query($link, $insert_newcut_2_plandocstatlog) or exit("Sql Error a inserting into plandoc_stat_log new cut".mysqli_error($GLOBALS["___mysqli_ston"]));
								}else if($tot == 0){
									echo "<script>sweetAlert('Plies must change to create new docket with the same ratio.',' Please change plies','warning');</script>";
									//echo "<h2><span style='color:red;'>Plies must change to create new docket with the same ratio. Please change plies</span></h2>";
									echo "<a class='btn btn-warning' href='".getFullURL($_GET['r'],'doc_track_panel.php','N')."'><< Go back to Cut quantity reporting screen</a>";
									die();
								}
							}
							

							$sql="insert ignore into $bai_pro3.act_cut_status (doc_no) values ($input_doc_no)";				
							mysqli_query($link, $sql) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));

							$sql="update $bai_pro3.act_cut_status set date=\"$input_date\", section=\"$input_section\", shift=\"$input_shift\", fab_received=$input_fab_rec, fab_returned=$input_fab_ret, damages=$input_damages, shortages=$input_shortages, remarks=\"$input_remarks\", bundle_loc=\"$bun_loc\" where doc_no=$input_doc_no";
							mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));


							$sql1="update $bai_pro3.plandoc_stat_log set act_cut_status=\"DONE\", a_plies=".($plies+$old_plies).",p_plies=".($plies+$old_plies).",pcutdocid=concat(pcutdocid,'$','$bun_loc') where doc_no=$input_doc_no";
							mysqli_query($link, $sql1) or exit("Sql Error3$sql1".mysqli_error($GLOBALS["___mysqli_ston"]));

							
							//Role table logic - Satish 27/12/2017
							updateRoleData($roledata,$link);
							//Anil Logic
							//UpdateActMovementStatus($input_doc_no,$link);
							echo "<script>sweetAlert('Cut Quantity Reported Successfully','','success');</script>";
							//echo "<h3><span style='color:green;'>Successfully Cut Quantity reported</span></h3>";
							echo "<a class='btn btn-warning'href='".getFullURL($_GET['r'],'doc_track_panel.php','N')."'><< Go back to Cut quantity reporting screen</a>";
					    	//Locations display for docket after saving = Satish 21/12/2017
					    	$getLocations = "SELECT locations.loc_name,locations.capacity,locations.filled_qty FROM $bai_pro3.locations LEFT JOIN $bai_pro3.doc_loc_mapping ON doc_loc_mapping.loc_id = locations.loc_id WHERE doc_loc_mapping.doc_no = $input_doc_no group By locations.loc_name";
					    	$locations = mysqli_query($link, $getLocations) or exit("Sql Error at getting into locations for the docket".mysqli_error($GLOBALS["___mysqli_ston"]));
					   		
					   		echo "<h2>Please put bundles in the below locations for this docket</h2>";
					   		$tableData = "";
					   		while($row = mysqli_fetch_array($locations)){
				   				if($row['filled_qty']<=$row['capacity']){		   					
				   					$tableData.="<td class='cell'>".$row['loc_name']."<br/> Capacity-(".$row['capacity'].")</td>";
				   				}				   				
				   			}
					   		echo "<table>
					   					<tbody><tr>".$tableData."</tr></tbody>
					   				</table>";
				    		die();
						}else{
							//echo "<h2><span style='color:red;'>Locations are not enough to fill the required quantity.. Please process bundles to sewing in</span></h2>";
							echo "<script>sweetAlert('Locations are not enough to fill the required quantity..','Please process bundles to sewing in','error');</script>";
							//echo "<a class='btn btn-warning' href='".getFullURL($_GET['r'],'doc_track_panel.php','N')."'><< Go back to Cut quantity reporting screen</a>";
							echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",4000); function Redirect() {  location.href = '".getFullURL($_GET['r'],'doc_track_panel.php','N')."'; }</script>";
							die();
						}
						
					}else{
						echo "<script>sweetAlert('All locations filled..','Please process bundles to sewing in','error')</script>";
						
						//echo "<h2><span style='color:red;'>All locations filled.. Please process bundles to sewing in</span></h2>";
						echo "<a class='btn btn-warning' href='".getFullURL($_GET['r'],'doc_track_panel.php','N')."'><< Go back to Cut quantity reporting screen</a>";
						die();
					}
					
				}			
			} else {
				echo "<script>sweetAlert('Problem in updating Cut Status','','error')</script>";
				echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",4000); function Redirect() {  location.href = '".getFullURL($_GET['r'],'doc_track_panel.php','N')."'; }</script>";
				//exit("Reporting was Unable to process$sql1".mysqli_error($GLOBALS["___mysqli_ston"]));
			}

		}
		else
		{
			echo "<script>sweetAlert('Failed to update..','please retry..','error');</script>";
			echo "<a class='btn btn-warning' href='".getFullURL($_GET['r'],'doc_track_panel.php','N')."'><< Go back to Cut quantity reporting screen</a>";
			die();
		}

	}


	function updateRoleData($roledata,$link){
		global $bai_rm_pj1;
		if(sizeof($roledata)>0){
			foreach ($roledata as $key => $role) {
				$updating_role_data="update $bai_rm_pj1.fabric_cad_allocation set plies='".$role['roleplies']."',nbits='".$role['nbits']."',shade='".$role['shade']."' where tran_pin=".$role['tran_pin'];
				mysqli_query($link, $updating_role_data) or exit("Sql Error at updating fabric_cad_allocation".mysqli_error($GLOBALS["___mysqli_ston"]));
			}

		}		
	}

	function UpdateActMovementStatus($input_doc_no,$link){

		$size_code_db=array('xs','s','m','l','xl','xxl','xxxl','s01','s02','s03','s04','s05','s06','s07','s08','s09','s10','s11','s12','s13','s14','s15','s16','s17','s18','s19','s20','s21','s22','s23','s24','s25','s26','s27','s28','s29','s30','s31','s32','s33','s34','s35','s36','s37','s38','s39','s40','s41','s42','s43','s44','s45','s46','s47','s48','s49','s50');
					
		$order_tid_sql = "select order_tid from $bai_pro3.plandoc_stat_log where doc_no = '$input_doc_no'";

		if(mysqli_query($link, $order_tid_sql)){

			$result = mysqli_query($link, $order_tid_sql);
			$row = mysqli_fetch_assoc($result);
			$order_tid = $row['order_tid'];
		
		    $cat_doc_sql = "select tid,category from $bai_pro3.cat_stat_log where order_tid = '$order_tid'";

			$cat_doc_result = mysqli_query($link, $cat_doc_sql);

			$plan_sql = "select GROUP_CONCAT(distinct cat_ref) as cat_ref from $bai_pro3.plandoc_stat_log where order_tid = '$order_tid' group by order_tid ";
			$plan_sql = mysqli_query($link, $plan_sql);
			$plan_sql_data = mysqli_fetch_assoc($plan_sql);
			$cat_ref_count = count(explode(",",$plan_sql_data['cat_ref']));

			if(mysqli_num_rows($cat_doc_result) == $cat_ref_count){
				if(mysqli_num_rows($cat_doc_result) == 1){
		    	
		    	while($data = mysqli_fetch_assoc($cat_doc_result))
				{
				   $plan_doc_sql = "select doc_no,p_plies,a_plies,act_cut_status,cat_ref from $bai_pro3.plandoc_stat_log where act_cut_status = 'DONE' and p_plies = a_plies and cat_ref = ".$data['tid'];

				    $plan_doc_result = mysqli_query($link, $plan_doc_sql);
				    
				    if(mysqli_num_rows($plan_doc_result) > 0){

				    	while ($result = mysqli_fetch_assoc($plan_doc_result)) {

					    	$update_sql = "update $bai_pro3.plandoc_stat_log set act_movement_status='DONE' where cat_ref =".$result['cat_ref']." and doc_no = ".$result['doc_no'];
					    	$result = mysqli_query($link, $update_sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
					    	
						}

				    }
				    
				}
			    
		    }

		   	$plan_doc_stat_sql = "select doc_no,cat_ref,tid,category from $bai_pro3.plandoc_stat_log LEFT JOIN cat_stat_log ON plandoc_stat_log.cat_ref = cat_stat_log.tid where plandoc_stat_log.order_tid = '$order_tid'";

			$plan_doc_stat_result = mysqli_query($link, $plan_doc_stat_sql);
		    if(mysqli_num_rows($plan_doc_stat_result) > 1){

		    	$front_or_body_cat = array();
		    	

		    	while($data = mysqli_fetch_assoc($plan_doc_stat_result))
				{

					for ($i=0; $i < count($size_code_db); $i++) { 

						if($data['category'] == 'Front' || $data['category'] == 'Body'){
							$front_or_body_plan_doc_sql = "select   plandoc_stat_log.order_tid,category,cat_ref,doc_no,a_plies,p_plies, p_".$size_code_db[$i]." as p_size, a_".$size_code_db[$i]." as a_size,a_plies * a_".$size_code_db[$i]." as actul_value, p_plies * p_".$size_code_db[$i]." as planed_value,a_".$size_code_db[$i].",a_".$size_code_db[$i].",p_".$size_code_db[$i]." from $bai_pro3.plandoc_stat_log LEFT JOIN $bai_pro3.cat_stat_log ON plandoc_stat_log.cat_ref = cat_stat_log.tid where act_cut_status = 'DONE' and a_plies = p_plies and cat_ref = ".$data['cat_ref']." and doc_no=".$data['doc_no'];

							$front_or_body_result = mysqli_query($link, $front_or_body_plan_doc_sql) or exit("mysql error:".mysqli_error($GLOBALS["___mysqli_ston"]));
							$front_or_body_cat[] = mysqli_fetch_assoc($front_or_body_result);

						} 
					}
				}
				
				
				if(mysqli_num_rows($cat_doc_result) > 1){
		    		$remaining_cat = array();
			    	while($data = mysqli_fetch_assoc($cat_doc_result))
					{
						if($data['category'] != 'Front' || $data['category'] != 'Body'){
							for ($i=0; $i < count($size_code_db); $i++) {

								$remaining_cat_doc_sql = "select   plandoc_stat_log.order_tid,GROUP_CONCAT(category) as categories,GROUP_CONCAT(cat_ref) as cat_refs,GROUP_CONCAT(doc_no) as doc_nos,GROUP_CONCAT(a_plies) as a_plies,GROUP_CONCAT(p_plies) as p_plies, GROUP_CONCAT(p_".$size_code_db[$i].") as p_size, GROUP_CONCAT(a_".$size_code_db[$i].") as a_size,sum(a_plies * a_".$size_code_db[$i].") as actul_value, sum(p_plies * p_".$size_code_db[$i].") as planed_value,GROUP_CONCAT(a_".$size_code_db[$i].") as a_".$size_code_db[$i].",GROUP_CONCAT(p_".$size_code_db[$i].") as p_".$size_code_db[$i]." from $bai_pro3.plandoc_stat_log LEFT JOIN $bai_pro3.cat_stat_log ON plandoc_stat_log.cat_ref = cat_stat_log.tid where act_cut_status = 'DONE' and a_plies = p_plies and cat_ref = ".$data['tid']." and category not in ('Front','Body') group by cat_ref";

									$remaining_cat_result = mysqli_query($link, $remaining_cat_doc_sql);

									$remaining_cat[] = mysqli_fetch_assoc($remaining_cat_result);
							}
						}

					}
				}

				if(count($front_or_body_cat) > 1){

					// var_dump($front_or_body_cat);
					// die();

					// Front or Body Data Removing zeros
					foreach ($front_or_body_cat as $key => $value) { 

						if ($value["actul_value"] == 0 && $value["planed_value"] == 0) { unset($front_or_body_cat[$key]); }

					}

					$front_or_body_cat_data = array_values($front_or_body_cat);

					// Getting front or body size keys
					$temp_keys_1 = array();   
				    $temp_keys_2 = array(); 
				   
				    foreach($front_or_body_cat_data as $data){
				        $temp_keys_1[] = array_keys($data);
				    }
				    
				    foreach($temp_keys_1 as $data){
				        $temp_keys_2[] = end($data);
				    }
				    
				    $front_or_body_cat_size_names = array_unique($temp_keys_2);

				    // Group Front or body Data as per sizes
				    $front_or_body_data = array();
				    
				    foreach($front_or_body_cat_size_names as $size){

				        $front_or_body_data_1 = array(); 
				        foreach($front_or_body_cat_data as $data){
				             if (array_key_exists($size, $data)) {
				                $front_or_body_data_1[] = $data;
				            }
				        }
				        if($front_or_body_data_1){
				            $front_or_body_data[] = $front_or_body_data_1;
				        }
				    }

				    // var_dump($front_or_body_data);

				    // var_dump($front_or_body_data);
				    // die(); 


					// // Get Front or Body Doc Numbers
					// $temp_fornt_or_body_doc_nos = array();
					// foreach ($front_or_body_cat_data as $key => $value) {
					// 	$temp_fornt_or_body_doc_nos[] = $value['doc_no'];
					// }

					// $fornt_or_body_doc_nos = array_unique($temp_fornt_or_body_doc_nos);

					// // Spiliting Fronts are Bodies By doc numbers
					// $temp_front_or_body_cat_data_2 = array();
					// foreach ($fornt_or_body_doc_nos as $key => $doc_no) {
					// 	$temp_front_or_body_cat_data_1 = array();
					// 	foreach ($front_or_body_cat_data as $key => $value) {
					// 	if($value['doc_no'] == $doc_no)
					// 		$temp_front_or_body_cat_data_1[] = $value;
					// 	}
					// 	if($temp_front_or_body_cat_data_1){
					// 		$temp_front_or_body_cat_data_2[] = $temp_front_or_body_cat_data_1;
					// 	}
					// }

					// $front_or_body_cat_data = $temp_front_or_body_cat_data_2;

					// var_dump($front_or_body_cat_data);
				    // die();



					// Remaining Data Removing zeros
					foreach ($remaining_cat as $key => $value) { 

						if ($value["actul_value"] == 0 && $value["planed_value"] == 0) { unset($remaining_cat[$key]); }

					}

					$remaining_cat_data = array_values($remaining_cat);

					// Remaining Data Removing sizes which are not in Front or Body Cat
					$temp_remaining_cat_data = array();
					foreach($front_or_body_cat_size_names as $size){

				        foreach ($remaining_cat_data as $value) { 

				            if (array_key_exists($size, $value)) {
				                $temp_remaining_cat_data [] = $value;
				            }
				        }    
				    }

				    $remaining_cat_data = $temp_remaining_cat_data;
 
				    // Group Remaining Data as per Front or Body sizes
				    $remaining_data = array();
				    
				    foreach($front_or_body_cat_size_names as $key2=>$size){
				        $remaining_data_1 = array(); 
				        foreach($remaining_cat_data as $key1=>$data){
				             if (array_key_exists($size, $data)) {
				                $remaining_data_1[] = $data;
				            }
				        }
				        if($remaining_data_1){
				            $remaining_data[] = $remaining_data_1;
				        }
				    }

				    // Sample Data

					// $f_array = array();
					// $x_array = array();

					// $f_array[0] = array('actul_value'=>120,'size'=>'S1','id'=>1);
					// $f_array[1] = array('actul_value'=>60,'size'=>'S1','id'=>2);
					// $f_array[2] = array('actul_value'=>60,'size'=>'S1','id'=>3);
					
					// $x_array[0] = array('actul_value'=>200,'size'=>'S1');
					// $x_array[1] = array('actul_value'=>240,'size'=>'S1');

				    // Logic For Compare Front Or Body Cat Data With Remaing Cat Data 

					// $temp_cat_movent_data = array();
					// $temp_doc_no = array();
					// $flag = true;

					// $failed_docs = array();

					// $temp_equal_main_cat = array();
					// $temp_equal_non_main_cat = array();
					// $temp_grat_main_cat = array();
					// $temp_grat_non_main_cat = array();
					// $temp_not_eqal_main_cat = array();
					// $temp_not_eqal_non_main_cat = array();
					// var_dump($front_or_body_data);

					// ini_set('xdebug.max_nesting_level', 100);

					function getMainAndNonMainSingleSizeData($main,$nonmain){

						if($main){
							$mainData = $main[0];
							$nonMainData = $nonmain[0];
							$data['mainData'] = $mainData;
							$data['nonMainData'] = $nonMainData; 
							return $data;
						}else{
							return $data = array();
						}	
					}

					$temp_front_or_body_cat_success_data_1 = array();
					$temp_front_or_body_cat_success_data_2 = array();
					$temp_front_or_body_cat_failure_data_1 = array();
					$success_docs = array();
					$failed_docs = array();
					function reursiveCompare($main,$nonmain,&$temp_front_or_body_cat_success_data_1,&$temp_front_or_body_cat_success_data_2,&$temp_front_or_body_cat_failure_data_1,&$f_array,&$success_docs,&$failed_docs){

						$front_or_body_data = $main;
						$remaining_data = $nonmain;

						$temp_count = count($nonmain[0]);
						
						if($front_or_body_data > 1 && $remaining_data > 1){

							$data = getMainAndNonMainSingleSizeData($main,$nonmain);

							$data1 = $data['mainData'];
							$data2 = $data['nonMainData'];

							if($data1 > 1 && $data2 > 1){

								foreach ($data1 as $key1 => $value1) {

									$temp1_actual_value = (string)$value1['actul_value'];

									if(count($data2) == $temp_count){

										foreach ($data2 as $key2 => $value2) {

											$temp2_actual_value = (string)$value2['actul_value'];

											if($temp1_actual_value == $temp2_actual_value){

												//echo "1";
												
												unset($data2[$key2]);
												$temp_front_or_body_cat_success_data_1[] = $value1;
												$success_docs[] = $value1['doc_no'];
												
											
											}else if($temp1_actual_value < $temp2_actual_value){

												//echo "2";
												
												$temp_act_value = $temp2_actual_value - $temp1_actual_value;
												$data2[$key2]['actul_value'] = (string)$temp_act_value;
												$temp_front_or_body_cat_success_data_2[] = $value1;
												$success_docs[] = $value1['doc_no'];
												
												
											}else{


												//echo "3";

												// var_dump($temp1_actual_value);
												// var_dump($temp2_actual_value);
												$failed_docs[] = $value1['doc_no'];
												
												$temp_front_or_body_cat_failure_data_1[] = $value1;

												foreach ( $temp_front_or_body_cat_success_data_1 as $key => $value )
												{
													
													if ( $value['doc_no'] == $value1['doc_no'] )
												    {
												        unset( $temp_front_or_body_cat_success_data_1[$key] );
												    }

												}

												foreach ( $temp_front_or_body_cat_success_data_2 as $key => $value )
												{
													
													if ( $value['doc_no'] == $value1['doc_no'] )
												    {
												        unset( $temp_front_or_body_cat_success_data_2[$key] );
												    }

												}

												foreach ( $f_array as $key3 => $value )
												{
													foreach ($value as $key4 => $value4) {

														if ( $value4['doc_no'] == $value1['doc_no'] )
													    {
													        unset( $value[$key4] );
													    }

													}

												}
												// $flag1 = false;
												break;
											}

										}
									}else{
											//echo "4";
											
											$temp_front_or_body_cat_failure_data_1[] = $value1;
											
											

											foreach ( $temp_front_or_body_cat_success_data_1 as $key => $value )
											{
												
												if ( $value['doc_no'] == $value1['doc_no'] )
											    {
											        unset( $temp_front_or_body_cat_success_data_1[$key] );
											    }

											}
											
											foreach ( $temp_front_or_body_cat_success_data_2 as $key => $value )
											{
												
												if ( $value['doc_no'] == $value1['doc_no'] )
											    {
											        unset( $temp_front_or_body_cat_success_data_2[$key] );
											    }

											}
											
											foreach ( $f_array as $key3 => $value )
											{
												foreach ($value as $key4 => $value4) {

													if ( $value4['doc_no'] == $value1['doc_no'] )
												    {
												        unset( $value[$key4] );
												    }

												}
												
											}
											// $flag1 = false;
											break;
									}
								}
							}
						}
						
						if($front_or_body_data){

							array_shift($front_or_body_data);
							array_shift($remaining_data);

							// Recalling
							reursiveCompare($front_or_body_data,$remaining_data,$temp_front_or_body_cat_success_data_1,$temp_front_or_body_cat_success_data_2,$temp_front_or_body_cat_failure_data_1,$f_array,$success_docs,$failed_docs);

						}else{

							return;
						}
						
					}

					
					$f_array = $front_or_body_data;
					$x_array = $remaining_data;

					// $f_array[0][0] = array('actul_value'=>120,'size'=>'S1','id'=>1);
					// $f_array[0][1] = array('actul_value'=>60,'size'=>'S1','id'=>2);
					// $f_array[0][2] = array('actul_value'=>60,'size'=>'S1','id'=>3);
					
					// $x_array[0][0] = array('actul_value'=>200,'size'=>'S1');
					// $x_array[0][1] = array('actul_value'=>240,'size'=>'S1');

					// Recursive Function Calling Here
					
					reursiveCompare($f_array,$x_array,$temp_front_or_body_cat_success_data_1,$temp_front_or_body_cat_success_data_2,$temp_front_or_body_cat_failure_data_1,$f_array,$success_docs,$failed_docs);
					
					// var_dump($temp_front_or_body_cat_success_data_1);
					// var_dump($temp_front_or_body_cat_success_data_2);
					
					
					$success_doc_nos = array_values(array_unique($success_docs));
					$failed_doc_nos = array_values(array_unique($failed_docs));
					foreach ($success_doc_nos as $key => $value) {
						foreach ($failed_doc_nos as $key1 => $value1) {
							if($value == $value1){
								unset( $success_doc_nos[$key] );
							}
						}
					}
					
					// $movent_data = array_map('current', $temp_cat_movent_data);

					// $temp_fornt_or_body_doc_nos_movement = array();
					// foreach ($movent_data as $key => $value) {
					// 	$temp_fornt_or_body_doc_nos_movement[] = $value['doc_no'];
					// }

					// $fornt_or_body_doc_nos_movement = array_unique($temp_fornt_or_body_doc_nos_movement);

					// // Spiliting Fronts are Bodies By doc numbers
					// $temp_front_or_body_cat_data_movement_2 = array();
					// foreach ($fornt_or_body_doc_nos_movement as $key => $doc_no) {
					// 	$temp_front_or_body_cat_data_movement_1 = array();
					// 	foreach ($movent_data as $key => $value) {
					// 	if($value['doc_no'] == $doc_no)
					// 		$temp_front_or_body_cat_data_movement_1[] = $value;
					// 	}
					// 	if($temp_front_or_body_cat_data_movement_1){
					// 		$temp_front_or_body_cat_data_movement_2[] = $temp_front_or_body_cat_data_movement_1;
					// 	}
					// }

					// $movent_data = $temp_front_or_body_cat_data_movement_2;

					// $count = 0;
					// $counter = array();
					// foreach ($movent_data as $key => $value) {
					// 	foreach($value as  $key1 => $value1){
					// 		$doc_no = $value1['doc_no'];
					// 		$count++;
					// 	}
					// 	$counter[$key]['count'] = $count;
					// 	$counter[$key]['doc_no'] = $doc_no;
					// 	$count = 0;	
					// }

					// $count1 = 0;
					// $counter1 = array();
					// foreach ($front_or_body_cat_data as $key => $value) {
					// 	foreach($value as  $key1 => $value1){
					// 		$doc_no = $value1['doc_no'];
					// 		$count1++;
					// 	}
					// 	$counter1[$key]['count'] = $count1;
					// 	$counter1[$key]['doc_no'] = $doc_no;
					// 	$count1 = 0;	
					// }
					
					// $doc_nos = array();
					// foreach ($counter1 as $key => $value) {
					// 	foreach ($counter as $key1 => $value1) {
					// 		if($value['count'] == $value1['count']){
					// 			$doc_nos[] = $value1['doc_no'];
					// 		}
					// 	}
					// }

					if(count(array_unique($success_doc_nos)) > 0){
						$doc_nos = implode(",",array_unique($success_doc_nos));
						$update_sql = "update $bai_pro3.plandoc_stat_log set act_movement_status='DONE' where doc_no IN (".$doc_nos.")";
						$result = mysqli_query($link, $update_sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
					}
					
				}
				
			}
			}
				
		}   

	}

//echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = \"orders_cut_issue_status_list.php?tran_order_tid=$tran_order_tid\"; }</script>";

//echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",1000); function Redirect() {  location.href = \"doc_track_panel.php\"; }</script>";

?>

