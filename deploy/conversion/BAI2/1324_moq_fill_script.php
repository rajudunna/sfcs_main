<?php
echo Script Started<br/>;
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config.php');
$missing_schedules  = [554751=>19,554753=>5,561434=>43,561438=>44,561450=>42,561452=>41];
$schedules  = array(536711,554754,554755,554760,554762,554764,556672,558407,561441,561446,561882,564865,564866,564869,564870,564873,564875,564878,564880,564882,567947,567953,567969,56798);

$delete_query = "DELETE from bai_pro3.mo_operation_quantites WHERE mo_no IN (
4528071,4528072,4528073,4528074,4528077,4528078,4535256,4535257,4535260,4535261,4535264,4535265,4535268,4535269,4535270,4535271,4535272,4535273) AND op_code IN (100,130,900) ";
$result = mysqli_query($link,$delete_query);

foreach($missing_schedules as $schedule=>$sref_id){
	insertMOQuantitiesSewing($schedule,$sref_id);
}

//for 100 operation all the recevied_qty = send_qty
$update_100 = "UPDATE bai_pro3.mo_operation_quantites set good_quantity = bundle_quantity WHERE mo_no IN (				4528071,4528072,4528073,4528074,4528077,4528078,4535256,4535257,4535260,4535261,4535264,4535265,4535268,4535269,4535270,4535271,4535272,4535273) AND op_code = 100";
mysqli_query($link,$update_100);			  

$bcd_data_query = "SELECT bundle_number,recevied_qty,rejected_qty,operation_id from brandix_bts.bundle_creation_data where schedule IN (554753,554751,561434,561438,561450,561452) and operation_id IN (900,130)";
$bcd_result = mysqli_query($link,$bcd_data_query);
while($row = mysqli_fetch_array($bcd_result)){
	$bundle_no = $row['bundle_number'];
	$qty = $row['recevied_qty'];
	$rejqty = $row['rejected_qty'];
	$op_code = $row['operation_id'];
	//updateM3Transactions($bundle_no,$op_code,$qty);
	$update_qry = "update $bai_pro3.mo_operation_quantites set good_quantity = $qty,rejected_qty=$rejqty where ref_no= $bundle_no and op_code= $op_code";
	$ims_pro_qty_updating = mysqli_query($link,$update_qry) or exit("While updating mo_operation_quantites".mysqli_error($GLOBALS["___mysqli_ston"]));
	
}

// Missing 900 operation
for($i=0;$i<sizeof($schedules);$i++)
{
	$sql="select group_concat(distinct mo_no) from bai_pro3.mo_details where schedule= $schedules[$i]";
	$sql_result = mysqli_query($link,$update_qry) or exit("While updating mo_operation_quantites".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($row1 = mysqli_fetch_array($sql_result))
	{				
		$sql2="DELETE FROM bai_pro3.mo_operation_quantites WHERE mo_no IN (".$row1['mo_no'].") and op_code=900";
		mysqli_query($link,$sql2) or exit("While updating mo_operation_quantites".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		$sql21="insert ignore into bai_pro3.mo_operation_quantites (`date_time`, `mo_no`, `ref_no`, `bundle_quantity`, `op_code`, `op_desc`) select date_time,mo_no,ref_no,bundle_quantity,900,'Line Out' from bai_pro3.mo_operation_quantites where mo_no in (".$row1['mo_no'].") and op_code=100";
		mysqli_query($link,$sql21) or exit("While updating mo_operation_quantites".mysqli_error($GLOBALS["___mysqli_ston"]));	
	}
}
$bcd_data_query1 = "SELECT bundle_number,recevied_qty,rejected_qty,operation_id from brandix_bts.bundle_creation_data where schedule IN (536711,554754,554755,554760,554762,554764,556672,558407,561441,561446,561882,564865,564866,564869,564870,564873,564875,564878,564880,564882,567947,567953,567969,56798) and operation_id=900";
$bcd_result1 = mysqli_query($link,$bcd_data_query1);
while($row1 = mysqli_fetch_array($bcd_result1))
{
	$bundle_no1 = $row1['bundle_number'];
	$qty1 = $row1['recevied_qty'];
	$reqty1 = $row1['rejected_qty'];
	$op_code1 = $row1['operation_id'];
	$update_qry1 = "update $bai_pro3.mo_operation_quantites set good_quantity = $qty1,rejected_qty=$reqty1 where ref_no= $bundle_no1 and op_code= $op_code1";
	mysqli_query($link,$update_qry1) or exit("While updating mo_operation_quantites".mysqli_error($GLOBALS["___mysqli_ston"]));
	
}

function insertMOQuantitiesSewing($schedule,$sref_id){
		include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config.php');
		
		$sewing_cat = 'sewing';
		$mo_no=array();
		$moq=array();
		$ops_m_id=array();
		$ops_m_name=array();
		$size_tit=array();
		$ops=array();
		$opst=array();
		
		$op_codes_query = "SELECT category,group_concat(operation_code) as codes FROM $brandix_bts.tbl_orders_ops_ref 
						WHERE category = '$sewing_cat' group by category";
		$op_codes_result = mysqli_query($link,$op_codes_query) or exit('Problem in getting the op codes for sewing');   
		while($row = mysqli_fetch_array($op_codes_result)){
			$op_codes = $row['codes'];
		}   
		
		$op_codes_query = "SELECT operation_code,operation_name FROM $brandix_bts.tbl_orders_ops_ref 
						WHERE category = '$sewing_cat'";
		$op_codes_result = mysqli_query($link,$op_codes_query) or exit('Problem in getting the op codes for sewing');   
		while($row = mysqli_fetch_array($op_codes_result)){
			$opst[]=$row['operation_code'];
			$op_namem[]=$row['operation_name'];
		}
		
		$jobs_style_query = "Select order_style_no as style from $bai_pro3.packing_summary_input where 
							TRIM(order_del_no) = '$schedule' limit 1";
		$jobs_style_result = mysqli_query($link,$jobs_style_query);
		while($row = mysqli_fetch_array($jobs_style_result)){
			$style = $row['style'];
		}
		
		$jobs_col_query = "Select distinct(order_col_des) as color from $bai_pro3.packing_summary_input 
						where order_del_no ='$schedule' ";
		$jobs_col_result = mysqli_query($link,$jobs_col_query);
		while($row = mysqli_fetch_array($jobs_col_result)){
			$colors[] = $row['color'];
		}

		$opst = [100,130,900];
		foreach($colors as $col){
			$trimmed_color = trim($col);
			$jobs_sizes_query = "Select distinct(size_code) as size from $bai_pro3.packing_summary_input 
								where order_col_des = '$col' ";
			$jobs_size_result = mysqli_query($link,$jobs_sizes_query) or exit('Error Encounterd while getting sizes in MO');
			while($row = mysqli_fetch_array($jobs_size_result)){
				$sizes[] = $row['size'];
			}
			foreach($sizes as $size_code)
			{
				$qty = 0;
				$sql121="SELECT * FROM $bai_pro3.mo_details WHERE TRIM(size)='$size_code' and 
						TRIM(schedule)=$schedule and TRIM(color)='".trim($col)."' 
						order by mo_no*1"; 
				$result121=mysqli_query($link, $sql121) or die("Mo Details not available.".mysqli_error($GLOBALS["___mysqli_ston"]));
		
				while($row1210=mysqli_fetch_array($result121)) 
				{
					$mo_no[]= $row1210['mo_no'];
					$moq[]  = $row1210['mo_quantity'];
					$sql1212="SELECT OperationNumber,OperationDescription FROM $bai_pro3.schedule_oprations_master WHERE OperationNumber in ($op_codes) and MONumber=".$row1210['mo_no']." order by OperationNumber*1"; 
					$result1212=mysqli_query($link, $sql1212) or die("Mo Details not available.".mysqli_error($GLOBALS["___mysqli_ston"]));
					while($row1212=mysqli_fetch_array($result1212)) 
					{
						$ops_m_id[$row1210['mo_no']][$row1212['OperationNumber']]=$row1212['OperationNumber'];  
						$ops_m_name[$row1210['mo_no']][$row1212['OperationNumber']]=$row1212['OperationDescription'];
					}
				}
			
				if(sizeof($mo_no)>0)
				{
					$ops=array_unique($opst);
					if(sizeof($mo_no)==1)
					{
						$last_mo = $mo_no[0];
						for($k=0;$k<sizeof($ops);$k++)
						{
							{
								$sql1231="SELECT * FROM $bai_pro3.packing_summary_input WHERE size_code='$size_code' 
											and  sref_id = $sref_id and trim(order_col_des) = '$trimmed_color'
											and type_of_sewing > 0 ";
								$result1231=mysqli_query($link, $sql1231) or 
											die("Error".mysqli_error($GLOBALS["___mysqli_ston"])); 

								while($row1231=mysqli_fetch_array($result1231)) 
								{
									$sql="INSERT INTO $bai_pro3.`mo_operation_quantites` (`date_time`, `mo_no`, `ref_no`, `bundle_quantity`, `op_code`, `op_desc`) VALUES ('".date("Y-m-d H:i:s")."', '".$mo_no[0]."', '".$row1231['tid']."','".$row1231['carton_act_qty']."', '".$ops[$k]."', '".$op_namem[$k]."')";
									$result1=mysqli_query($link, $sql) or die("Error".mysqli_error($GLOBALS["___mysqli_ston"]));
								
								}
							}
						}
					}
					else
					{
						$bal=0;$qty_tmp=0;
						$sql1234 = "SELECT * FROM $bai_pro3.packing_summary_input WHERE size_code='$size_code' and sref_id = $sref_id
						and trim(order_col_des) = '$trimmed_color'
						and type_of_sewing=1";
						$result1234=mysqli_query($link, $sql1234) or die("Error".mysqli_error($GLOBALS["___mysqli_ston"]));

						while($row1234=mysqli_fetch_array($result1234)) 
						{
							$qty=$row1234['carton_act_qty'];
							$bundle_no = $row1234['tid'];
							for($kk=0;$kk<sizeof($mo_no);$kk++)
							{               
								$last_mo = $mo_no[sizeof($mo_no)];  
								$m_fil=0;
								$sql12345="SELECT sum(bundle_quantity) as qty FROM $bai_pro3.mo_operation_quantites WHERE mo_no=$mo_no[$kk] and op_code IN ($ops[0]) GROUP BY op_code";
								$result12345=mysqli_query($link, $sql12345) or die("Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
								while($row12345=mysqli_fetch_array($result12345)) 
								{
									$m_fil=$row12345['qty'];
								}
								if($m_fil=='' || $m_fil==0)
								{
									$m_fil=0;
								}
								$bal=$moq[$kk]-$m_fil;
		
								if($bal>0)
								{   
									if($bal>$qty)
									{   
										for($jj=0;$jj<sizeof($ops);$jj++)
										{   
											
											if($qty>0)
											{
												$sql="INSERT INTO $bai_pro3.`mo_operation_quantites` (`date_time`, `mo_no`, `ref_no`,`bundle_quantity`, `op_code`, `op_desc`) 
												VALUES ('".date("Y-m-d H:i:s")."', '".$mo_no[$kk]."','".$row1234['tid']."', '".$qty."', '".$ops[$jj]."', '".$op_namem[$jj]."')";
												$result1=mysqli_query($link, $sql) or die("Error".mysqli_error($GLOBALS["___mysqli_ston"]));
											}
										}   
										$qty=0;
										
									}
									else
									{
										for($jj=0;$jj<sizeof($ops);$jj++)
										{   
											
											if($qty>0)
											{
												$sql="INSERT INTO $bai_pro3.`mo_operation_quantites` (`date_time`, `mo_no`, `ref_no`,`bundle_quantity`, `op_code`, `op_desc`) VALUES ('".date("Y-m-d H:i:s")."', '".$mo_no[$kk]."','".$row1234['tid']."','".$bal."', '".$ops[$jj]."', '".$op_namem[$jj]."')";
												$result1=mysqli_query($link, $sql) or die("Error".mysqli_error($GLOBALS["___mysqli_ston"]));
											}
										}       
										$qty=$qty-$bal;
										$bal=0;
									}           
								}                               
							}   
							if($qty > 0){
								for($l=0;$l<sizeof($ops);$l++){    
										$sql = "Update $bai_pro3.mo_operation_quantites set 
												bundle_quantity = bundle_quantity + $qty where mo_no =$last_mo and 
												ref_no = $bundle_no and op_code =$ops[$l]";
								
										$result1=mysqli_query($link, $sql) or exit('Error Encountered');
								}
							}   
						}
						//Excess allocate to Last MO
						$qty1 = $qty;
						$bal=0;$qty_tmp=0;$qty=0;
						$sql12341="SELECT * FROM $bai_pro3.packing_summary_input WHERE size_code='$size_code' 
									and sref_id = $sref_id and trim(order_col_des) = '$trimmed_color' and type_of_sewing<>1";       
						$result12341=mysqli_query($link, $sql12341) or die("Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
						if(mysqli_num_rows($result12341)>0)
						{
							while($row12341=mysqli_fetch_array($result12341)) 
							{
								$qty=$row12341['carton_act_qty'];
								if($qty>0)
								{
									for($jjj=0;$jjj<sizeof($ops);$jjj++)
									{
										$sql="INSERT INTO $bai_pro3.`mo_operation_quantites` (`date_time`, `mo_no`,`ref_no`,  `bundle_quantity`, `op_code`, `op_desc`) 
										VALUES ('".date("Y-m-d H:i:s")."', '".$lastmo."', '".$row12341['tid']."','".$qty."', '".$ops[$jjj]."', '".$op_namem[$jjj]."')";
										$result1=mysqli_query($link, $sql) or die("Error".mysqli_error($GLOBALS["___mysqli_ston"]));        
									}                           
								}
								$qty=0;                     
							}
						}
					}
					unset($mo_no);
					unset($moq);
					unset($ops_m_id);
					unset($ops_m_name);         
					unset($ops);
				}
			}
			unset($sizes);
		}
}



?>