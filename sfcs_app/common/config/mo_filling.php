<?php

	function deleteMOQuantitiesCut($schedule,$color){
		include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config.php');

		$cutting_ref = "'cutting','Send PF','Receive PF'";
		$op_codes_query = "Select GROUP_CONCAT(operation_code) as op_code from $brandix_bts.tbl_orders_ops_ref where default_operation='Yes' and category in ($cutting_ref)";
		$op_codes_resut = mysqli_query($link,$op_codes_query) or exit('Problem while getting op codes');
		while($row = mysqli_fetch_array($op_codes_resut)){
			$op_codes = $row['op_code'];
		}
		$ref_nos_query = "Select group_concat(distinct(bundle_number)) as bundle_nos from $brandix_bts.bundle_creation_data 
						  where operation_id in ($op_codes) and trim(schedule)='".trim($schedule)."' 
						  and trim(color)='".trim($color)."'";
		$ref_nos_result = mysqli_query($link,$ref_nos_query) or exit('Problem in getting bundles from BCD');	
		while($row = mysqli_fetch_array($ref_nos_result)){
			$bundle_nos = $row['bundle_nos'];
		}	
		if(sizeof($bundle_nos) == 0)
			return true;

		// ----Transaction begin---
		mysqli_begin_transaction($link);
		$delete_bcd_query = "Delete from $brandix_bts.bundle_creation_data where bundle_number in ($bundle_nos)";
		$delete_bcd_data = mysqli_query($link,$delete_bcd_query) or exit('Problem While deleting Bundle cps Data');
		$delete_cps_qry = "Delete from $bai_pro3.cps_log where id in ($bundle_nos)";
		$deletedelete_cps_qry = mysqli_query($link,$delete_cps_qry) or exit('Problem While deleting Bundle Creation Data');
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
	
	function insertMOQuantitiesRecut($ref_no,$op_code,$qty){
		include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config.php');

        $details_query  = "Select style,color,schedule,size_title from $brandix_bts.bundle_creation_data 
                           where operation_id = $op_code and bundle_number = $ref_no limit 1 ";
        $details_result = mysqli_query($link,$details_query) or exit("Error while getting details from BCD ");
        while($row = mysqli_fetch_array($details_result)){
            $style    = $row['style'];
            $schedule = $row['schedule'];
			$color    = $row['color'];
			$mo_size  = $row['size_title'];
        }
        $mos = array();
		$qty = 0;
	
		//check whether that style,schedule,color exists -------------------------------------
		$mo_no_query = "SELECT mo.mo_no as mo_no,mo.mo_quantity as mo_quantity,SUM(bundle_quantity) as bundle_quantity,
						SUM(good_quantity) as good_quantity,SUM(rejected_quantity) as rejected_quantity
						FROM $bai_pro3.mo_details mo 
						LEFT JOIN $bai_pro3.mo_operation_quantites mop ON mo.mo_no = mop.mo_no  
						WHERE TRIM(size)='$mo_size' and schedule='$schedule' and TRIM(color)='$color' 
						and mop.op_code = $op_code
						group by mop.mo_no
						order by mo.mo_no*1"; 			
		$mo_no_result  = mysqli_query($link,$mo_no_query); 
		while($row = mysqli_fetch_array($mo_no_result)){
			if($row['bundle_quantity'] >= $row['good_quantity'] && $row['rejected_quantity']==0){
				$mos[$row['mo_no']] = 0;
				continue;
			}
			if($row['rejected_quantity'] == 0)
				$mos[$row['mo_no']] = $row['mo_quantity'] - $row['bundle_quantity'];
			else	
				$mos[$row['mo_no']] = $row['mo_quantity'] - $row['bundle_quantity'] + $row['rejected_quantity'];
		}

		foreach($mos as $mo_no => $rej_qty){
			$last_mo = $mo_no;
			if($rej_qty == 0)
				continue;
		
			$qty = $qty - $rej_qty;
			if( $qty >= 0){
				$insert_query = "Insert into $bai_pro3.mo_operation_quantites 
							(`date_time`, `mo_no`, `ref_no`,`bundle_quantity`, `op_code`, `op_desc`) VALUES 
							('".date('Y-m-d H:i:s')."',$mo_no,$ref_no,$rej_qty,$op_code,'recut')";
				mysqli_query($link,$insert_query) or exit('Mo Updation error 1');
			}else{
				$insert_query = "Insert into $bai_pro3.mo_operation_quantites 
							(`date_time`, `mo_no`, `ref_no`,`bundle_quantity`, `op_code`, `op_desc`) VALUES 
							('".date('Y-m-d H:i:s')."',$mo_no,$ref_no,$qty,$op_code,'recut')";
				mysqli_query($link,$insert_query) or exit('Mo Updation error 2');
				break;
			}	
		}
			
		// 	inserting excess quantity to the last mo 
		if($qty > 0){
			$insert_query = "Insert into $bai_pro3.mo_operation_quantites 
						(`date_time`, `mo_no`, `ref_no`,`bundle_quantity`,`op_code`,`op_desc`) VALUES 
						('".date('Y-m-d H:i:s')."',$last_mo,$ref_no,$qty,$op_code,'recut')";
			mysqli_query($link,$insert_query) or exit('Mo Updation error 3');	
		}
		unset($mos);
    }

	//tested
    function deleteMoQuantitiesSewing($schedule){
		include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config.php');
        $sewing_cat = 'sewing';
        $op_code_query  ="SELECT group_concat(operation_code) as codes FROM $brandix_bts.tbl_orders_ops_ref 
                          WHERE trim(category) = '$sewing_cat' ";
        $op_code_result = mysqli_query($link, $op_code_query) or exit("No Operations Found for Sewing");
        while($row=mysqli_fetch_array($op_code_result)) 
        {
            $op_codes  = $row['codes'];	
        }

        $mo_query  = "Select GROUP_CONCAT(mo_no) as mos from $bai_pro3.mo_details where schedule = $schedule";
        $mo_result = mysqli_query($link,$mo_query);
        while($row = mysqli_fetch_array($mo_result)){
            $mos = $row['mos'];
        }

        $delete_query = "Delete from $bai_pro3.mo_operation_quantites where mo_no in ($mos) and op_code in ($op_codes) ";
        $delete_result = mysqli_query($link,$delete_query);
        if($delete_result > 0){
			echo "Deleted Successfully";
            return true;
        }
        return false;
    }

	//This function is not required	
	function insertMoQuantitiesClub($orders){
		$order_tids = explode(',',$orders);
		foreach($order_tids as $order_tid){
			//getting schedule,colors for order tid
			$details_query = "Select order_del_no,order_col_des from $bai_pro3.bai_orders_db_confirm where 
							  order_tid = '$order_tid'";
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

	//tested
	function insertMOQuantitiesCut($ref_id,$op_code,$qty){
		include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config.php');

		//getting style,color,schedule,size
		$order_details = "Select style,color,schedule,size_title from $brandix_bts.bundle_creation_data 
						  where bundle_number = $ref_id and operation_id = $op_code";
		$order_result = mysqli_query($link,$order_details) or exit('Unable to get info from BCD');
		while($row = mysqli_fetch_array($order_result)){
			$style = $row['style'];
			$schedule = $row['schedule'];
			$color = $row['color'];
			$size  = $row['size_title'];
		}

		$mo_details = "SELECT * FROM $bai_pro3.mo_details WHERE TRIM(size)='$size' 
					   and TRIM(schedule)=$schedule and TRIM(color)='$color' order by mo_no";
		$mos_result = mysqli_query($link,$mo_details);		
		while($row = mysqli_fetch_array($mos_result)){
			$mos[$row['mo_no']] = $row['mo_quantity'];
		}	   
		//returning back if has no mo's at all
		if(sizeof($mos) == 0)
			return false;

		//getting the operations and op_codes  for that mo if exists
		foreach($mos as $mo=>$mo_qty){
			$mo_op_query ="SELECT OperationNumber,OperationDescription FROM $bai_pro3.schedule_oprations_master 
						   WHERE OperationNumber=$op_code and MONumber=$mo limit 1";
			$mo_ops_result = mysqli_query($link,$mo_op_query) or exit('No Operations Exists for MO '.$mo);
			while($row = mysqli_fetch_array($mo_ops_result)){
				$op_desc[$mo] = $row['OperationDescription'];
				$op_codes[$mo] = $row['OperationNumber'];
			}	
		}
		
		if(sizeof($mos) == 1){
			foreach($mos as $mo=>$mo_qty){			   
				$insert_query = "Insert into $bai_pro3.mo_operation_quantites 
								(`date_time`, `mo_no`,`ref_no`,`bundle_quantity`, `op_code`, `op_desc`)
								values ('".date('Y-m-d H:i:s')."','$mo','$ref_id','$qty','$op_code','$op_desc[$mo]')"; 
				mysqli_query($link,$insert_query) or exit("Error 0 In Inserting to MO Qtys for mo : ".$mo);	
				$qty = 0;			
			}
		}else{			
			foreach($mos as $mo=>$mo_qty){
				$last_mo = $mo;
				if($qty <= 0)
					continue;

				$filled_qty = 0;
				//getting already filled quantities 
				$filled_qty_query = "Select SUM(bundle_quantity) as filled from $bai_pro3.mo_operation_quantites where 
									 mo_no = $mo and op_code = $op_code";
				$filled_qty_result = mysqli_query($link,$filled_qty_query);	
				while($row = mysqli_fetch_array($filled_qty_result)){
					$filled_qty = $row['filled'];
				}		
				$available = $mo_qty - $filled_qty;	 

				if($available <= 0)
					continue;
				if($qty > $available && $available > 0){
					$qty = $qty-$available;
					$insert_query = "Insert into $bai_pro3.mo_operation_quantites 
									(`date_time`, `mo_no`,`ref_no`,`bundle_quantity`, `op_code`, `op_desc`)
									values 
									('".date('Y-m-d H:i:s')."','$mo','$ref_id','$available','$op_code','$op_desc[$mo]')"; 
					mysqli_query($link,$insert_query) or exit("Error 1 In Inserting to MO Qtys for mo : ".$mo);	
				}else{
					$insert_query = "Insert into $bai_pro3.mo_operation_quantites 
									(`date_time`, `mo_no`,`ref_no`,`bundle_quantity`, `op_code`, `op_desc`)
									values 
									('".date('Y-m-d H:i:s')."','$mo','$ref_id','$qty','$op_code','$op_desc[$mo]')"; 
					mysqli_query($link,$insert_query) or exit("Error 2 In Inserting to MO Qtys for mo : ".$mo);
					$qty = 0;
				}
			}
			//Updating all excess to last mo 
			if($qty > 0){
				$update_query = "Update $bai_pro3.mo_operation_quantites set bundle_quantity = bundle_quantity + $qty 
								 where mo_no = $last_mo and ref_no = $ref_id and op_code = $op_code";
				mysqli_query($link,$update_query) or exit("Error 3 In Updating excess qty to MO Qtys for mo : ".$mo);
			}
		}
	}

	//tested
	function insertMOQuantitiesSewing($schedule,$sref_id){
		$scheduless = explode("=",$schedule);
		if ($scheduless[1] == '1' || $scheduless[1] == 1 ) {
			include($_SERVER['DOCUMENT_ROOT'].'/template/dbconf.php');
			$link = $link_ui;
			$schedule = $scheduless[0];
		} else {
			include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config.php');
		}		
		
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
		$op_codes_result = mysqli_query($link,$op_codes_query) or exit('Problem in getting the op codes for sewing'.$op_codes_query);   
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
											and type_of_sewing=1 ";
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
	

    function insertMOQuantitiesPacking($schedule,$pack_ref)
    {
        include("config.php");
		global $link;
		$packing_cat = 'packing';

		$op_codes_query = "SELECT category,group_concat(operation_code) as codes FROM $brandix_bts.tbl_orders_ops_ref WHERE default_operation='Yes' and category = '$packing_cat'";
		$op_codes_result = mysqli_query($link,$op_codes_query) or exit('Problem in getting the op codes for packing');             
		while($row = mysqli_fetch_array($op_codes_result))
		{
			$op_codes = $row['codes'];
		}

		$res=2;
		$jobs_style_query1 = "Select sum(carton_act_qty) as qty from $bai_pro3.packing_summary where order_del_no = '$schedule' and seq_no = $pack_ref";
		$jobs_style_result1 = mysqli_query($link,$jobs_style_query1);
		while($row1 = mysqli_fetch_array($jobs_style_result1))
		{
			$qty1 = $row1['qty'];
		}

		if($qty1>0)
		{
			$jobs_style_query = "Select order_style_no as style from $bai_pro3.packing_summary where order_del_no = '$schedule' and seq_no = $pack_ref limit 1";
			$jobs_style_result = mysqli_query($link,$jobs_style_query);
			while($row = mysqli_fetch_array($jobs_style_result))
			{
				$style = $row['style'];
			}


			$jobs_col_query = "Select distinct(order_col_des) as color from $bai_pro3.packing_summary where order_del_no ='$schedule' and seq_no = $pack_ref";
			$jobs_col_result = mysqli_query($link,$jobs_col_query);
			while($row = mysqli_fetch_array($jobs_col_result))
			{
				$colors[] = $row['color'];
			} 

			if(sizeof($colors)>0)
			{
				foreach($colors as $col)
				{
					$jobs_sizes_query = "Select distinct(size_tit) as size from $bai_pro3.packing_summary  where order_col_des = '$col' and seq_no = $pack_ref";
					$jobs_size_result = mysqli_query($link,$jobs_sizes_query) or exit('Error Encounterd while getting sizes in MO');
					while($row = mysqli_fetch_array($jobs_size_result))
					{
						$sizes[] = $row['size'];
					}

					foreach($sizes as $size_code)
					{
						$qty = 0;
						$sql121="SELECT * FROM $bai_pro3.mo_details WHERE TRIM(size)='$size_code' and schedule=$schedule and TRIM(color)='".trim($col)."' order by mo_no*1";
						$result121=mysqli_query($link, $sql121) or die("Mo Details not available in mo_details.");
						while($row1210=mysqli_fetch_array($result121))
						{
							$mo_no[]= $row1210['mo_no'];
							$moq[]  = $row1210['mo_quantity'];
							$sql1212="SELECT OperationNumber,OperationDescription FROM $bai_pro3.schedule_oprations_master WHERE OperationNumber in ($op_codes) and MONumber=".$row1210['mo_no']." order by OperationNumber*1";
							$result1212=mysqli_query($link, $sql1212) or die("error while fetching Mo Details from schedule_oprations_master.");
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
										$sql1231="SELECT * FROM $bai_pro3.packing_summary WHERE size_tit='$size_code' and order_del_no='".$schedule."' and order_col_des='".$col."' and seq_no = $pack_ref";
										$result1231=mysqli_query($link, $sql1231) or die("Error".mysqli_error($GLOBALS["___mysqli_ston"]));
										while($row1231=mysqli_fetch_array($result1231))
										{
											$sql="INSERT INTO $bai_pro3.`mo_operation_quantites` (`date_time`, `mo_no`, `ref_no`, `bundle_quantity`, `op_code`, `op_desc`) VALUES ('".date("Y-m-d H:i:s")."', '".$mo_no[0]."', '".$row1231['tid']."','".$row1231['carton_act_qty']."', '".$ops_m_id[$mo_no[0]][$ops[$k]]."', '".$ops_m_name[$mo_no[0]][$ops[$k]]."')";
											
											$result1=mysqli_query($link, $sql) or die("Error".mysqli_error($GLOBALS["___mysqli_ston"]));
											$res=1;
										}
									}
								}
							}
							else
							{
								$bal=0;$qty_tmp=0;
								$sql1234="SELECT * FROM $bai_pro3.packing_summary WHERE size_tit='$size_code' and order_del_no='".$schedule."' and order_col_des='".$col."'  and seq_no = $pack_ref";
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
													if($ops_m_id[$mo_no[$kk]][$ops[$jj]]>0)
													{
														if($qty>0)
														{
															$sql="INSERT INTO $bai_pro3.`mo_operation_quantites` (`date_time`, `mo_no`, `ref_no`,`bundle_quantity`, `op_code`, `op_desc`)
															VALUES ('".date("Y-m-d H:i:s")."', '".$mo_no[$kk]."','".$row1234['tid']."', '".$qty."', '".$ops_m_id[$mo_no[$kk]][$ops[$jj]]."', '".$ops_m_name[$mo_no[$kk]][$ops[$jj]]."')";
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
												$sql = "Update $bai_pro3.mo_operation_quantites set bundle_quantity = bundle_quantity + $qty where mo_no =$last_mo and	ref_no=".$row1234['tid']." and op_code =".$ops_m_id[$last_mo][$ops[$l]];
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
				}
			}
			return $res;
		}
		else
		{
			return $res;
		}
	}
	
	//tested
	function doc_size_wise_bundle_insertion($doc_no_ref,$club_flag=0)
	{
		include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config.php');
		$category=['cutting','Send PF','Receive PF'];
		$operation_codes = array();
		

		foreach($category as $key => $value)
		{
			$fetching_ops_with_category = "SELECT operation_code,short_cut_code FROM brandix_bts.tbl_orders_ops_ref 
											WHERE category = '".$category[$key]."'";
			$result_fetching_ops_with_cat = mysqli_query($link,$fetching_ops_with_category) or exit("Bundles Query Error 1423");
			while($row=mysqli_fetch_array($result_fetching_ops_with_cat))
			{
				$operation_codes[] = $row['operation_code'];
				$short_key_code[] = $row['short_cut_code'];
			}
		}
		$cut_done_qty = array();

		//logic to insert into bundle_creation_data with doc,size and operation_wise
		$qry_cut_qty_check_qry = "SELECT * FROM $bai_pro3.plandoc_stat_log WHERE doc_no = $doc_no_ref ";
		$result_qry_cut_qty_check_qry = $link->query($qry_cut_qty_check_qry);
		while($row = $result_qry_cut_qty_check_qry->fetch_assoc()) 
		{
			$org_doc = $row['org_doc_no'];
			$order_tid = $row['order_tid'];
			//this block only works for filling while schedule clubbing
			if($club_flag == 1){
				for ($i=0; $i < sizeof($sizes_array); $i++)
				{ 
					if ($row['p_'.$sizes_array[$i]] > 0)
					{
						$cut_done_qty[$sizes_array[$i]] = $row['p_'.$sizes_array[$i]];
					}
				}
			}else{
				for ($i=0; $i < sizeof($sizes_array); $i++)
				{ 
					if ($row['a_'.$sizes_array[$i]] > 0)
					{
						$cut_done_qty[$sizes_array[$i]] = $row['a_'.$sizes_array[$i]] * $row['a_plies'];
					}
				}
			}
			
		}
		foreach($cut_done_qty as $key => $value)
		{
			$qty_to_fetch_size_title = "SELECT *,title_size_$key  FROM $bai_pro3.bai_orders_db_confirm WHERE order_tid ='$order_tid'";
			$res_qty_to_fetch_size_title=mysqli_query($link,$qty_to_fetch_size_title) or exit("Bundles Query Error14".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($nop_res_qty_to_fetch_size_title=mysqli_fetch_array($res_qty_to_fetch_size_title))
			{
				$size_title = $nop_res_qty_to_fetch_size_title["title_size_$key"];
				$b_style =  $nop_res_qty_to_fetch_size_title['order_style_no'];
				$b_schedule =  $nop_res_qty_to_fetch_size_title['order_del_no'];
				$b_colors =  $nop_res_qty_to_fetch_size_title['order_col_des'];
			}
			$b_size_code = $key;
			$b_sizes = $size_title;
			$sfcs_smv = 0;
			$b_tid = $doc_no_ref;
			$b_in_job_qty = $value;
			$send_qty = $value;
			$rec_qty = 0;
			$rej_qty = 0;
			$left_over_qty = 0;
			$b_doc_num = $doc_no_ref;
			$b_a_cut_no = $doc_no_ref;
			$b_inp_job_ref = $doc_no_ref;
			$b_job_no = $doc_no_ref;
			$b_shift = 'G';
			$b_module = '0';
			$b_remarks = 'Normal';
			$mapped_color = $b_colors;
			foreach($operation_codes as $index => $op_code)
			{
				if($op_code != 15)
				{
					$send_qty = 0; 
				}

				$b_cps_qty[$op_code] = "INSERT INTO $bai_pro3.cps_log(`operation_code`,`short_key_code`,`cut_quantity`,`remaining_qty`,`doc_no`,`size_code`,`size_title`) VALUES";
				$b_cps_qty[$op_code] .= '("'.$op_code.'","'. $short_key_code[$index].'","'.$b_in_job_qty.'","0","'. $b_job_no.'","'.$b_size_code.'","'. $b_sizes.'")';
				$bundle_creation_result_002 = $link->query($b_cps_qty[$op_code]);
				$last_id = mysqli_insert_id($link);
				$b_query[$op_code] = "INSERT  INTO $brandix_bts.bundle_creation_data(`style`,`schedule`,`color`,`size_id`,`size_title`,`sfcs_smv`,`bundle_number`,`original_qty`,`send_qty`,`recevied_qty`,`rejected_qty`,`left_over`,`operation_id`,`docket_number`, `scanned_date`, `cut_number`, `input_job_no`,`input_job_no_random_ref`, `shift`, `assigned_module`, `remarks`, `mapped_color`) VALUES";
				$b_query[$op_code] .= '("'.$b_style.'","'. $b_schedule.'","'.$b_colors.'","'.$b_size_code.'","'. $b_sizes.'","'. $sfcs_smv.'","'.$last_id.'","'.$b_in_job_qty.'","'.$send_qty.'","'.$rec_qty.'","'.$rej_qty.'","'.$left_over_qty.'","'. $op_code.'","'.$b_doc_num.'","'.date('Y-m-d').'","'.$b_a_cut_no.'","'.$b_inp_job_ref.'","'.$b_job_no.'","'.$b_shift.'","'.$b_module.'","'.$b_remarks.'","'.$mapped_color.'")';
				$bundle_creation_result_001 = $link->query($b_query[$op_code]);
				$inserting_mo = insertMOQuantitiesCut($last_id,$op_code,$b_in_job_qty);
				//insertion_into_cps_log 
			}
		}
		return true;
	}

	function doc_size_wise_bundle_insertion_recut($doc_no_ref)
	{
		include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config.php');

		$category=['cutting','Send PF','Receive PF'];
		$operation_codes = array();
		error_reporting(0);
		foreach($category as $key => $value)
		{
			$fetching_ops_with_cat = "SELECT operation_code,short_cut_code FROM `brandix_bts`.`tbl_orders_ops_ref` WHERE category = '$category[$key]'";
			$result_fetching_ops_with_cat=mysqli_query($link,$fetching_ops_with_cat) or exit("Bundles Query Error14".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($row=mysqli_fetch_array($result_fetching_ops_with_cat))
			{
				$operation_codes[] = $row['operation_code'];
				$short_key_code[] = $row['short_cut_code'];

			}
		}
			$cut_done_qty = array();
			//logic to insert into bundle_creation_data with doc,size and operation_wise
			$qry_cut_qty_check_qry = "SELECT * FROM $bai_pro3.recut_v2 WHERE doc_no = $doc_no_ref ";
			$result_qry_cut_qty_check_qry = $link->query($qry_cut_qty_check_qry);
			while($row = $result_qry_cut_qty_check_qry->fetch_assoc()) 
			{
				$order_tid = $row['order_tid'];
				for ($i=0; $i < sizeof($sizes_array); $i++)
				{ 
					if ($row['a_'.$sizes_array[$i]] > 0)
					{
						$cut_done_qty[$sizes_array[$i]] = $row['a_'.$sizes_array[$i]] * $row['a_plies'];
					}
				}
			}
			foreach($cut_done_qty as $key => $value)
			{
				$qty_to_fetch_size_title = "SELECT *,title_size_$key  FROM $bai_pro3.bai_orders_db_confirm WHERE order_tid ='$order_tid'";
				$res_qty_to_fetch_size_title=mysqli_query($link,$qty_to_fetch_size_title) or exit("Bundles Query Error14".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($nop_res_qty_to_fetch_size_title=mysqli_fetch_array($res_qty_to_fetch_size_title))
				{
					$size_title = $nop_res_qty_to_fetch_size_title["title_size_$key"];
					$b_style =  $nop_res_qty_to_fetch_size_title['order_style_no'];
					$b_schedule =  $nop_res_qty_to_fetch_size_title['order_del_no'];
					$b_colors =  $nop_res_qty_to_fetch_size_title['order_col_des'];
				}
				$b_size_code = $key;
				$b_sizes = $size_title;
				$sfcs_smv = 0;
				$b_tid = $doc_no_ref;
				$b_in_job_qty = $value;
				$send_qty = $value;
				$rec_qty = 0;
				$rej_qty = 0;
				$left_over_qty = 0;
				$b_doc_num = $doc_no_ref;
				$b_a_cut_no = $doc_no_ref;
				$b_inp_job_ref = $doc_no_ref;
				$b_job_no = $doc_no_ref;
				$b_shift = 'G';
				$b_module = '0';
				$b_remarks = 'Normal';
				$mapped_color = $b_colors;
				foreach($operation_codes as $index => $op_code)
				{
					if($op_code != 15)
					{
						$send_qty = 0; 
					}
					$b_cps_qty[$op_code] = "INSERT INTO $bai_pro3.cps_log(`operation_code`,`short_key_code`,`cut_quantity`,`remaining_qty`,`doc_no`,`size_code`,`size_title`,`reported_status`,`received_qty_cumulative`) VALUES";
					$b_cps_qty[$op_code] .= '("'.$op_code.'","'. $short_key_code[$index].'","'.$b_in_job_qty.'","0","'. $b_job_no.'","'.$b_size_code.'","'. $b_sizes.'","P",0)';
					$bundle_creation_result_002 = $link->query($b_cps_qty[$op_code]);
					$last_id = mysqli_insert_id($link);
					$b_query[$op_code] = "INSERT INTO $brandix_bts.bundle_creation_data(`style`,`schedule`,`color`,`size_id`,`size_title`,`sfcs_smv`,`bundle_number`,`original_qty`,`send_qty`,`recevied_qty`,`rejected_qty`,`left_over`,`operation_id`,`docket_number`, `scanned_date`, `cut_number`, `input_job_no`,`input_job_no_random_ref`, `shift`, `assigned_module`, `remarks`, `mapped_color`) VALUES";
					$b_query[$op_code] .= '("'.$b_style.'","'. $b_schedule.'","'.$b_colors.'","'.$b_size_code.'","'. $b_sizes.'","'. $sfcs_smv.'","'.$last_id.'","'.$b_in_job_qty.'","'.$send_qty.'","'.$rec_qty.'","'.$rej_qty.'","'.$left_over_qty.'","'. $op_code.'","'.$b_doc_num.'","'.date('Y-m-d').'","'.$b_a_cut_no.'","'.$b_inp_job_ref.'","'.$b_job_no.'","'.$b_shift.'","'.$b_module.'","'.$b_remarks.'","'.$mapped_color.'")';
					$bundle_creation_result_001 = $link->query($b_query[$op_code]);
					$inserting_mo = insertMOQuantitiesRecut($last_id,$op_code,$b_in_job_qty);
					//insertion_into_cps_log 
				}
			}
		return true;
	}
?>
