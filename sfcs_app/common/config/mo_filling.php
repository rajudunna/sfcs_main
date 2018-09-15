<?php
/*
    insertMOQuantitiesSewing($schedule,$sref_id)
    deleteMOQuantities($schedule,$color)
    insertMoQuantitiesClub($orders)
    insertMOQuantitiesCut($ref_id,$op_code,$qty)

*/
	include("config.php");

	function deleteMOQuantities($schedule,$color){
		global $cutting_categories;
		global $link;

		$op_codes_query = "Select GROUP_CONCAT(op_code) from $brandix_bts.tbl_orders_ops_ref where default_operation='Yes' 
						   and category in ($cutting_categories)";
		$op_codes_resut = mysqli_query($link,$op_codes_query) or exit('Problem while getting op codes');
		while($row = mysqli_fetch_array($op_codes_resut)){
			$op_codes = $row['op_code'];
		}
		$ref_nos_query = "Select distinct(bundle_no) as bundle_nos from $brandix_bts.bundle_creation_data 
						  where op_code in ($op_codes) and trim(schedule)='".trim($schedule)."' 
						  and trim(color)='".trim($color)."'";
		$ref_nos_result = mysqli_query($link,$ref_nos_query) or exit('Problem in getting bundles from BCD');	
		while($row = mysqli_fetch_array($ref_nos_result)){
			$bundle_nos = $row['bundle_nos'];
		}	
		// ----Transaction begin---
		mysqli_begin_transaction($link);
		$delete_bcd_query = "Delete from $brandix_bts.bundle_creation_data where bundle_no in ($bundle_nos)";
		$delete_bcd_data = mysqli_query($link,$delete_bcd_query) or exit('Problem While deleting Bundle Creation Data');
		if($delete_bcd_data){
			$delete_mos_query = "Delete from $bai_pro3.mo_operation_quantites where ref_no in ($bundle_nos)";
			$delete_mos_result = mysqli_query($link,$delete_mos_query) or 
								exit('Problem While deleting Mo operation Quantities');
			if($delete_mos_result){
				mysqli_commit($link);
				return true;
			}else{
				mysqli_rollback($link);
				return false;
			}					
		}else{
			mysqli_rollback($link);
			return false;
		}	
		mysqli_close($link);
		// -----Transaction End ---------
		return false;
	}

	function insertMoQuantitiesClub($orders){
		$order_tids = explode(',',$orders);
		foreach($order_tids as $order_tid){
			//getting schedule,colors for order tid
			$details_query = "Select order_del_no,order_col_des from $bai_pro3.bai_orders_db_confirm where 
							  order_tid = $order_tid";
			$details_result = mysqli_query($link,$details_query);
			while($row = mysqli_fetch_array($details_result)){
				$schedules[] = $row['order_del_no'];
				$colors[]    = $row['order_col_des'];
			}
			$schedules = implode(array_unique($schedules));
			$colors    = implode(array_unique($colors));

			//Getting bundles from BCD
			$bundles_ref_query = "Select bundle_ref from $brandix_bts.bundle_creation_data where schedule in ($schedules) 
								  and color in ($colors) ";
			$bundles_ref_result = mysqli_query($link,$bundles_ref_query);					  
		}
	}

	function insertMOQuantitiesCut($ref_id,$op_code,$qty){
		global $link;
		//getting style,color,schedule,size
		$order_details = "Select style,color,schedule from bundle_craeation_data where bundle_no = '$ref_id' LIMTI 1";
		$order_result = mysqli_query($link,$order_details) or exit('Unable to get info from BCD');
		while($row = mysqli_fetch_array($order_result)){
			$style = $row['style'];
			$schedule = $row['schedule'];
			$color = $row['color'];
			$size  = $row['size_title'];
		}

		$mo_details = "SELECT * FROM $bai_pro3.mo_details WHERE TRIM(size)='$size' and TRIM(schedule)='$schedule' 
					   and TRIM(color)='$col' order by mo_no";
		$mos_result = mysqli_query($link,$mo_details);		
		while($row = mysqli_fetch_array($mos_result)){
			$mos[$row['mo_no']] = $row['mo_quantity'];
		}	   
		//getting the operations and op_codes  for that mo if exists
		foreach($mos as $mo=>$mo_qty){
			$mo_op_query ="SELECT OperationNumber,OperationDescription FROM $bai_pro3.schedule_oprations_master 
						   WHERE OperationNumber='$op_code' and MONumber='$mo' limit 1";
			$mo_ops_result = mysqli_query($link,$mo_op_query) or exit('No Operations Exists for MO '.$mo);	
			while($row = mysqli_fetch_array()){
				$op_desc[$mo] = $row['OperationDescription'];
				$op_code[$mo] = $row['OperationNumber'];
			}	
		}

		if(sizeof($mos) == 1){
			foreach($mos as $mo=>$mo_qty){			   
				$insert_query = "Insert into $bai_pro3.mo_operation_quantites 
								(`date_time`, `mo_no`,`ref_no`,`bundle_quantity`, `op_code`, `op_desc`)
								values (".date('Y-m-d H:i:s').",'$mo','$ref_id','$qty','$op_code[$mo]','$op_desc[$mo]')"; 
				mysqli_query($link,$insert_query) or exit("Error In Inserting to MO Qtys for mo : ".$mo);				
			}
		}else{			foreach($mos as $mo=>$mo_qty){
				$last_mo = $mo;
				$filled_qty = 0;
	
				//getting already filled quantities 
				$filled_qty_query = "Select SUM(bundle_quantity) as filled from $bai_pro3.mo_operation_quantites where 
									 mo_no = $mo and op_code = $op_code";
				$filled_qty_result = mysqli_query($link,$filled_qty_query);	
				while($row = mysqli_fetch_array($filled_qty_result)){
					$filled_qty = $row['filled'];
				}				 
				$available = $mo_qty - $filled_qty;
				if($qty > $available){
					$qty = $qty-$available;
					//qty = 60 qty = 10
					$insert_query = "Insert into $bai_pro3.mo_operation_quantites 
									(`date_time`, `mo_no`,`ref_no`,`bundle_quantity`, `op_code`, `op_desc`)
									values 
									(".date('Y-m-d H:i:s').",'$mo','$ref_id','$available','$op_code[$mo]','$op_desc[$mo]')"; 
					mysqli_query($link,$insert_query) or exit("Error In Inserting to MO Qtys for mo : ".$mo);	
				}else{
					$insert_query = "Insert into $bai_pro3.mo_operation_quantites 
									(`date_time`, `mo_no`,`ref_no`,`bundle_quantity`, `op_code`, `op_desc`)
									values 
									(".date('Y-m-d H:i:s').",'$mo','$ref_id','$qty','$op_code[$mo]','$op_desc[$mo]')"; 
					mysqli_query($link,$insert_query) or exit("Error In Inserting to MO Qtys for mo : ".$mo);
					$qty = 0;
				}
			}
			//Inserting all excess to last mo 
			if($qty > 0){
				$insert_query = "Insert into $bai_pro3.mo_operation_quantites 
								(`date_time`, `mo_no`,`ref_no`,`bundle_quantity`, `op_code`, `op_desc`)
								values 
								(".date('Y-m-d H:i:s').",'$last_mo','$ref_id','$qty','$op_code[$mo]','$op_desc[$mo]')"; 
				mysqli_query($link,$insert_query) or exit("Error In Inserting excess qty to MO Qtys for mo : ".$mo);
			}
		}
	}

	function insertMOQuantitiesSewing($schedule,$sref_id){
		global $link;
		$sewing_cat = 'SEWING';
		$mo_no=array();
		$moq=array();
		$ops_m_id=array();
		$ops_m_name=array();
		$size_tit=array();
		$ops=array();
		$opst=array();
		
		$op_codes_query = "SELECT category,group_concat(operation_code) as codes FROM $brandix_bts.tbl_orders_ops_ref 
					 WHERE default_operation='Yes' and category = '$sewing_cat' group by category";
		$op_codes_result = mysqli_query($link,$op_codes_query) or exit('Problem in getting the op codes for sewing');	
		while($row = mysqli_fetch_array($op_codes_result)){
			$op_codes = $row['codes'];
		}	

		$jobs_style_query = "Select order_style_no as style from $bai_pro3.packing_summary_input where 
							TRIM(order_del_no) = '$schedule' and sref_id = '$sref_id' limit 1";
		$jobs_style_result = mysqli_query($link,$jobs_style_query);
		while($row = mysqli_fetch_array($jobs_style_result)){
			$style = $row['style'];
		}
		
		$jobs_col_query = "Select distinct(order_col_des) as color from $bai_pro3.packing_summary_input 
						where order_del_no ='$schedule' and sref_id = '$sref_id'";
		$jobs_col_result = mysqli_query($link,$jobs_col_query);
		while($row = mysqli_fetch_array($jobs_col_result)){
			$colors[] = $row['color'];
		}

		foreach($colors as $col){
			$jobs_sizes_query = "Select distinct(size_code) as size from $bai_pro3.packing_summary_input 
								where order_col_des = '$col' and sref_id='$sref_id'";
			$jobs_size_result = mysqli_query($link,$jobs_sizes_query) or exit('Error Encounterd while getting sizes in MO');
			while($row = mysqli_fetch_array($jobs_size_result)){
				$sizes[] = $row['size'];
			}
			foreach($sizes as $size_code)
			{
				$qty = 0;
				$sql121="SELECT * FROM $bai_pro3.mo_details WHERE TRIM(size)='$size_code' and 
						TRIM(schedule)='".trim($schedule)."' and TRIM(color)='".trim($col)."' 
						order by mo_no*1"; 
				$result121=mysqli_query($link, $sql121) or die("Mo Details not available.".mysqli_error($GLOBALS["___mysqli_ston"]));
				// echo $sql121;
				while($row1210=mysqli_fetch_array($result121)) 
				{
					$mo_no[]= $row1210['mo_no'];
					$moq[]  = $row1210['mo_quantity'];
					$sql1212="SELECT OperationNumber,OperationDescription FROM $bai_pro3.schedule_oprations_master WHERE OperationNumber in ($op_codes) and MONumber='".$row1210['mo_no']."' order by OperationNumber*1"; 
					$result1212=mysqli_query($link, $sql1212) or die("Mo Details not available.".mysqli_error($GLOBALS["___mysqli_ston"]));
					//echo $sql1212;
					while($row1212=mysqli_fetch_array($result1212)) 
					{
						$ops_m_id[$row1210['mo_no']][$row1212['OperationNumber']]=$row1212['OperationNumber'];	
						$ops_m_name[$row1210['mo_no']][$row1212['OperationNumber']]=$row1212['OperationDescription'];
						$opst[]=$row1212['OperationNumber'];
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
							if($ops_m_id[$mo_no[0]][$ops[$k]]>0)
							{
								$sql1231="SELECT * FROM $bai_pro3.packing_summary_input WHERE size_code='$size_code' and order_del_no='".$schedule."' and order_col_des='".$col."' and sref_id = '$sref_id' 
								and type_of_sewing='1' ";
								$result1231=mysqli_query($link, $sql1231) or 
											die("Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
								//echo $sql1231.'<br/>';
								while($row1231=mysqli_fetch_array($result1231)) 
								{
									$sql="INSERT INTO $bai_pro3.`mo_operation_quantites` (`date_time`, `mo_no`, `ref_no`, `bundle_quantity`, `op_code`, `op_desc`) VALUES ('".date("Y-m-d H:i:s")."', '".$mo_no[0]."', '".$row1231['tid']."','".$row1231['carton_act_qty']."', '".$ops_m_id[$mo_no[0]][$ops[$k]]."', '".$ops_m_name[$mo_no[0]][$ops[$k]]."')";
									//echo $sql.'<br/>';
									$result1=mysqli_query($link, $sql) or die("Error".mysqli_error($GLOBALS["___mysqli_ston"]));
								
								}
							}
						}
					}
					else
					{
						$bal=0;$qty_tmp=0;
						$sql1234="SELECT * FROM $bai_pro3.packing_summary_input WHERE size_code='$size_code' and order_del_no='".$schedule."' and order_col_des='".$col."'  and sref_id = '$sref_id' and type_of_sewing='1'";
						$result1234=mysqli_query($link, $sql1234) or die("Error".mysqli_error($GLOBALS["___mysqli_ston"]));
						//echo $sql1234.'<br/>';
						while($row1234=mysqli_fetch_array($result1234)) 
						{
							$qty=$row1234['carton_act_qty'];
							$bundle_no = $row1234['tid'];
							for($kk=0;$kk<sizeof($mo_no);$kk++)
							{				
								$last_mo = $mo_no[sizeof($mo_no)];	
								$m_fil=0;
								$sql12345="SELECT sum(bundle_quantity) as qty FROM $bai_pro3.mo_operation_quantites WHERE mo_no='".$mo_no[$kk]."' and op_code IN ($ops[0]) GROUP BY op_code";
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
											if($ops_m_id[$mo_no[$kk]][$ops[$jj]]>0)
											{
												if($qty>0)
												{
													$sql="INSERT INTO $bai_pro3.`mo_operation_quantites` (`date_time`, `mo_no`, `ref_no`,`bundle_quantity`, `op_code`, `op_desc`) 
													VALUES ('".date("Y-m-d H:i:s")."', '".$mo_no[$kk]."','".$row1234['tid']."', '".$qty."', '".$ops_m_id[$mo_no[$kk]][$ops[$jj]]."', '".$ops_m_name[$mo_no[$kk]][$ops[$jj]]."')";
													//echo 'inner -- '.$sql.'<br/>';
													$result1=mysqli_query($link, $sql) or die("Error".mysqli_error($GLOBALS["___mysqli_ston"]));
												}
											}
										}	
										$qty=0;
										
									}
									else
									{
										for($jj=0;$jj<sizeof($ops);$jj++)
										{	
											if($ops_m_id[$mo_no[$kk]][$ops[$jj]]>0)
											{
												if($qty>0)
												{
													$sql="INSERT INTO $bai_pro3.`mo_operation_quantites` (`date_time`, `mo_no`, `ref_no`,`bundle_quantity`, `op_code`, `op_desc`) VALUES ('".date("Y-m-d H:i:s")."', '".$mo_no[$kk]."','".$row1234['tid']."','".$bal."', '".$ops_m_id[$mo_no[$kk]][$ops[$jj]]."', '".$ops_m_name[$mo_no[$kk]][$ops[$jj]]."')";
													//echo ' downer -- '.$sql.'<br/>';
													$result1=mysqli_query($link, $sql) or die("Error".mysqli_error($GLOBALS["___mysqli_ston"]));
												}
											}
										}		
										$qty=$qty-$bal;
										$bal=0;
									}			
								}								
							}	
							if($qty > 0){
								for($l=0;$l<sizeof($ops);$l++){	
									if($ops_m_id[$last_mo][$ops[$l]]>0){	
										$sql = "Update $bai_pro3.mo_operation_quantites set 
												bundle_quantity = bundle_quantity + $qty where mo_no = '$last_mo' and 
												ref_no = '$bundle_no' and op_code = '".$ops_m_id[$last_mo][$ops[$l]]."'";
										$result1=mysqli_query($link, $sql) or exit('Error Encountered');
									}
								}
							}	
						}
						//Excess allocate to Last MO
						$qty1 = $qty;
						//$lastmo=echo_title("$bai_pro3.mo_details","MAX(mo_no)","TRIM(size)='$size_code' and TRIM(color)='".trim($col)."' and schedule",$schedule,$link);
						$bal=0;$qty_tmp=0;$qty=0;
						$sql12341="SELECT * FROM $bai_pro3.packing_summary_input WHERE size_code='$size_code' and order_del_no='".$schedule."' and order_col_des='".$col."' and type_of_sewing<>'1'";
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
										if($ops_m_id[$lastmo][$ops[$jjj]]<>'')
										{
											//echo "re inserted ";
											$sql="INSERT INTO $bai_pro3.`mo_operation_quantites` (`date_time`, `mo_no`,`ref_no`,  `bundle_quantity`, `op_code`, `op_desc`) 
											VALUES ('".date("Y-m-d H:i:s")."', '".$lastmo."', '".$row12341['tid']."','".$qty."', '".$ops_m_id[$lastmo][$ops[$jjj]]."', '".$ops_m_name[$lastmo][$ops[$jjj]]."')";
											$result1=mysqli_query($link, $sql) or die("Error".mysqli_error($GLOBALS["___mysqli_ston"]));
										}							
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
				//echo "<br>-----------------------------------------------------------------------<br/>";
			}
			unset($sizes);
		}
    }
    
    function insertMOQuantitiesPacking($schedule,$pack_ref)
	{
		include("config.php");
		global $link;
		$packing_cat = 'PACKING';

		$op_codes_query = "SELECT category,group_concat(operation_code) as codes FROM $brandix_bts.tbl_orders_ops_ref WHERE default_operation='Yes' and category = '$packing_cat' group by category";
		// echo $op_codes_query;
		$op_codes_result = mysqli_query($link,$op_codes_query) or exit('Problem in getting the op codes for packing');             
		while($row = mysqli_fetch_array($op_codes_result))
		{
			$op_codes = $row['codes'];
		}

		$res=2;
		$jobs_style_query1 = "Select sum(carton_act_qty) as qty from $bai_pro3.packing_summary where order_del_no = '$schedule' and seq_no = '$pack_ref'";
		$jobs_style_result1 = mysqli_query($link,$jobs_style_query1);
		while($row1 = mysqli_fetch_array($jobs_style_result1))
		{
			$qty1 = $row1['qty'];
		}

		if($qty1>0)
		{
			$jobs_style_query = "Select order_style_no as style from $bai_pro3.packing_summary where order_del_no = '$schedule' and seq_no = '$pack_ref' limit 1";
			$jobs_style_result = mysqli_query($link,$jobs_style_query);
			while($row = mysqli_fetch_array($jobs_style_result))
			{
				$style = $row['style'];
			}


			$jobs_col_query = "Select distinct(order_col_des) as color from $bai_pro3.packing_summary where order_del_no ='$schedule' and seq_no = '$pack_ref'";
			$jobs_col_result = mysqli_query($link,$jobs_col_query);
			while($row = mysqli_fetch_array($jobs_col_result))
			{
				$colors[] = $row['color'];
			} 

			if(sizeof($colors>0))
			{
				foreach($colors as $col)
				{
					$jobs_sizes_query = "Select distinct(size_tit) as size from $bai_pro3.packing_summary  where order_col_des = '$col' and seq_no = '$pack_ref'";
					$jobs_size_result = mysqli_query($link,$jobs_sizes_query) or exit('Error Encounterd while getting sizes in MO');
					while($row = mysqli_fetch_array($jobs_size_result))
					{
						$sizes[] = $row['size'];
					}

					foreach($sizes as $size_code)
					{
						$qty = 0;
						$sql121="SELECT * FROM $bai_pro3.mo_details WHERE TRIM(size)='$size_code' and schedule='".$schedule."' and TRIM(color)='".trim($col)."' order by mo_no*1";
						$result121=mysqli_query($link, $sql121) or die("Mo Details not available.");
						while($row1210=mysqli_fetch_array($result121))
						{
							$mo_no[]= $row1210['mo_no'];
							$moq[]  = $row1210['mo_quantity'];
							$sql1212="SELECT OperationNumber,OperationDescription FROM $bai_pro3.schedule_oprations_master WHERE OperationNumber in ($op_codes) and MONumber='".$row1210['mo_no']."' order by OperationNumber*1";
							$result1212=mysqli_query($link, $sql1212) or die("Mo Details not available.");
							//echo $sql1212;
							while($row1212=mysqli_fetch_array($result1212))
							{
								$ops_m_id[$row1210['mo_no']][$row1212['OperationNumber']]=$row1212['OperationNumber'];
								$ops_m_name[$row1210['mo_no']][$row1212['OperationNumber']]=$row1212['OperationDescription'];
								$opst[]=$row1212['OperationNumber'];
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
									if($ops_m_id[$mo_no[0]][$ops[$k]]>0)
									{
										$sql1231="SELECT * FROM $bai_pro3.packing_summary WHERE size_code='$size_code' and order_del_no='".$schedule."' and order_col_des='".$col."' and seq_no = '$pack_ref'";
										$result1231=mysqli_query($link, $sql1231) or die("Error".mysqli_error($GLOBALS["___mysqli_ston"]));
										//echo $sql1231.'<br/>';
										while($row1231=mysqli_fetch_array($result1231))
										{
											$sql="INSERT INTO $bai_pro3.`mo_operation_quantites` (`date_time`, `mo_no`, `ref_no`, `bundle_quantity`, `op_code`, `op_desc`) VALUES ('".date("Y-m-d H:i:s")."', '".$mo_no[0]."', '".$row1231['tid']."','".$row1231['carton_act_qty']."', '".$ops_m_id[$mo_no[0]][$ops[$k]]."', '".$ops_m_name[$mo_no[0]][$ops[$k]]."')";
											//echo $sql.'<br/>';
											$result1=mysqli_query($link, $sql) or die("Error".mysqli_error($GLOBALS["___mysqli_ston"]));
											$res=1;
										}
									}
								}
							}
							else
							{
								$bal=0;$qty_tmp=0;
								$sql1234="SELECT * FROM $bai_pro3.packing_summary WHERE size_tit='$size_code' and order_del_no='".$schedule."' and order_col_des='".$col."'  and seq_no = '$pack_ref'";
								$result1234=mysqli_query($link, $sql1234) or die("Error".mysqli_error($GLOBALS["___mysqli_ston"]));
								// echo $sql1234.'<br/>';
								while($row1234=mysqli_fetch_array($result1234))
								{
									$qty=$row1234['carton_act_qty'];
									$bundle_no = $row1234['tid'];
									for($kk=0;$kk<sizeof($mo_no);$kk++)
									{                                                     
										$last_mo = $mo_no[sizeof($mo_no)];      
										$m_fil=0;
										$sql12345="SELECT sum(bundle_quantity) as qty FROM $bai_pro3.mo_operation_quantites WHERE mo_no='".$mo_no[$kk]."' and op_code IN ($ops[0]) GROUP BY op_code";
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
													if($ops_m_id[$mo_no[$kk]][$ops[$jj]]>0)
													{
														if($qty>0)
														{
															$sql="INSERT INTO $bai_pro3.`mo_operation_quantites` (`date_time`, `mo_no`, `ref_no`,`bundle_quantity`, `op_code`, `op_desc`)
															VALUES ('".date("Y-m-d H:i:s")."', '".$mo_no[$kk]."','".$row1234['tid']."', '".$qty."', '".$ops_m_id[$mo_no[$kk]][$ops[$jj]]."', '".$ops_m_name[$mo_no[$kk]][$ops[$jj]]."')";
															//echo 'inner -- '.$sql.'<br/>';
															$result1=mysqli_query($link, $sql) or die("Error".mysqli_error($GLOBALS["___mysqli_ston"]));
															$res=1;
														}
													}
												}
												$qty=0;
											}
											else
											{
												for($jj=0;$jj<sizeof($ops);$jj++)
												{
													if($ops_m_id[$mo_no[$kk]][$ops[$jj]]>0)
													{
														if($qty>0)
														{
															$sql="INSERT INTO $bai_pro3.`mo_operation_quantites` (`date_time`, `mo_no`, `ref_no`,`bundle_quantity`, `op_code`, `op_desc`) VALUES ('".date("Y-m-d H:i:s")."', '".$mo_no[$kk]."','".$row1234['tid']."','".$bal."', '".$ops_m_id[$mo_no[$kk]][$ops[$jj]]."', '".$ops_m_name[$mo_no[$kk]][$ops[$jj]]."')";
															//echo ' downer -- '.$sql.'<br/>';
															$result1=mysqli_query($link, $sql) or die("Error".mysqli_error($GLOBALS["___mysqli_ston"]));
															$res=1;
														}
													}
												}
												$qty=$qty-$bal;
												$bal=0;
											}
										}
									}

									//Excess allocate to Last MO
									if($qty > 0)
									{
										for($l=0;$l<sizeof($ops);$l++)
										{     
											if($ops_m_id[$last_mo][$ops[$l]]>0)
											{  
												$sql = "Update $bai_pro3.mo_operation_quantites set bundle_quantity = bundle_quantity + $qty where mo_no = '$last_mo' and	ref_no='".$row1234['tid']."' and op_code = '".$ops_m_id[$last_mo][$ops[$l]]."'";
												$result1=mysqli_query($link, $sql) or exit('Error Encountered');
												$res=1;
											}
										}
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
					//unset($size_qty);
				}
			}
			return $res;
		}
		else
		{
			return $res;
		}
	}
?>