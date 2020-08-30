<?php
	include(getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));
	include(getFullURLLevel($_GET['r'],'common/config/functions.php',4,'R'));
	include(getFullURLLevel($_GET['r'],'common/config/header_scripts.php',2,'R'));
	include(getFullURLLevel($_GET['r'],'common/config/menu_content.php',2,'R')); 
	$has_permission=haspermission($_GET['r']);
?> 

<body> 
<div class="panel panel-primary">
<!-- <div class="panel-heading">Sewing Job Split</div> -->
<div class="panel-body">

<?php
	$username_list=explode('\\',$_SERVER['REMOTE_USER']); 
	$username=strtolower($username_list[1]); 
	$schedule=$_POST['schedule']; 
	$tids=$_POST['tid']; 
	$qtys=$_POST['qty']; 
	$input_job_no_random=$_POST['input_job_no_random']; 
	$input_job_no=$_POST['input_job_no'];
	$ninput_job_no_random = '';
	//temp values to insert to mo_quantites table    
	// $temp_input_job_no_random = $input_job_no_random;
	// $temp_input_job_no = $input_job_no;

	// echo "ij = $input_job_no<br>ij_rand = $input_job_no_random<br>";
	$CAT = 'sewing';
	//sewing cat opcodes
	$sewing_op_codes = "SELECT group_concat(operation_code) as op_codes FROM $brandix_bts.tbl_orders_ops_ref WHERE category = '$CAT'";
	$row = mysqli_fetch_array(mysqli_query($link,$sewing_op_codes));
	{
	    $op_codes = $row['op_codes'];
	}

	$getlastrec="SELECT input_job_no FROM $bai_pro3.packing_summary_input WHERE status = '$input_job_no' and order_del_no='$schedule' group by input_job_no"; 
	// echo $getlastrec;die();
	$res_last_rec=mysqli_query($link,$getlastrec);
	if(mysqli_num_rows($res_last_rec) > 0)
	{
		$check_max=array();
		while($row=mysqli_fetch_array($res_last_rec))
		{
			$check_max[]=$row['input_job_no'];		
		}
		$befdec=max($check_max);
		if ($befdec == '' || $befdec == null)
		{
			$incrementno=1;
		}
		else
		{
			$finalval=explode('.',$befdec);
			if (count($finalval) > 1)
			{
				$incrementno=end($finalval)+1;
			}
			else
			{
				$incrementno = 1;
			}
		}
	}
	else
	{
		$incrementno = 1;
	}
	$ninput_job_no=$input_job_no.'.'.str_pad($incrementno,2,"0",STR_PAD_LEFT); 
	$ninput_job_no_random=$input_job_no_random.'.'.str_pad($incrementno,2,"0",STR_PAD_LEFT);

	// echo "<br>new_ij = $ninput_job_no<br>new_ij_rand = $ninput_job_no_random";
	// die();
	for ($ii=0; $ii <sizeof($tids); $ii++)
	{ 
		$tid=$tids[$ii]; 
		$qty=$qtys[$ii]; 
		$inserted_tid = 0;

		$sql="SELECT * FROM $bai_pro3.pac_stat_log_input_job where tid = '$tid'"; 
		// echo $sql.'<br>';
		$result=mysqli_query($link, $sql) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"])); 

		if($row=mysqli_fetch_array($result))
		{ 
			$doc_no=$row['doc_no']; 
			$type_of_sewing=$row['type_of_sewing']; 
			$size_code=$row['size_code']; 
			$carton_act_qty=$row['carton_act_qty']; 
			$status=$row['status']; 
			$doc_no_ref=$row['doc_no_ref']; 
			$input_job_no=$row['input_job_no']; 
			$input_job_no_random=$row['input_job_no_random']; 
			$destination=$row['destination']; 
			$packing_mode=$row['packing_mode']; 
			$old_size=$row['old_size']; 
			$jobs_array[] = $input_job_no_random;
			$sref_id=$row['sref_id']; 
			$pac_seq_no=$row['pac_seq_no']; 
			$plan_cut_bundle_id=$row['plan_cut_bundle_id']; 
			$style=$row['style']; 
			$color=$row['color']; 
			$schedule=$row['schedule']; 
			$max_barcode= echo_title("$bai_pro3.pac_stat_log_input_job","MAX(barcode_sequence)+1","input_job_no_random",$input_job_no_random,$link);
			if ($max_barcode > 1)
			{
				$bundle_seq = $max_barcode;
				$barcode="SPB-".$doc_no."-".$input_job_no."-".$bundle_seq."";
			}
			
			
			$quantity = 1; //assigning some value to set default value
			$query_check = "SELECT * FROM $brandix_bts.`bundle_creation_data_temp` WHERE input_job_no_random_ref='$input_job_no_random'";
			$res_query_check=mysqli_query($link,$query_check);
			if(mysqli_num_rows($res_query_check) > 0)
			{
				$query_qty_check = "SELECT sum(recevied_qty) as rec,sum(rejected_qty) as rej FROM $brandix_bts.`bundle_creation_data_temp` WHERE input_job_no_random_ref='$input_job_no_random'";
				$res_query_qty_check=mysqli_query($link,$query_qty_check);
				while($qty_res = mysqli_fetch_array($res_query_qty_check))
				{
					$rec_qty = $qty_res['rec'];
					$rej_qty = $qty_res['rej'];
					$quantity = $rec_qty + $rej_qty ;
				}
			}
			if (mysqli_num_rows($res_query_check) == 0 || $quantity == 0) 
			{
				if ($qty == 0) 
				{
					echo "<script>sweetAlert('Splitting Quantity cannot be zero','','warning')</script>"; 
				}
				else 
				{
					if ($carton_act_qty == $qty) 
					{
						// echo "<script>alert('into if condition');</script>";
						$sql2="UPDATE $bai_pro3.pac_stat_log_input_job SET input_job_no_random='$ninput_job_no_random',input_job_no='$ninput_job_no', status='$input_job_no' WHERE tid='$tid'"; 
						// echo $sql2.'<br>';
						mysqli_query($link, $sql2) or exit("Sql Error3".mysqli_error($GLOBALS["___mysqli_ston"]));

						$bcd_update="UPDATE $brandix_bts.bundle_creation_data SET input_job_no_random_ref='$ninput_job_no_random',input_job_no='$ninput_job_no' WHERE bundle_number='$tid' and operation_id in ($op_codes)";
                        mysqli_query($link, $bcd_update) or exit("Sql Error3".mysqli_error($GLOBALS["___mysqli_ston"]));
					}
					else
					{
						$nqty=$carton_act_qty-$qty;
						if($nqty>0)
						{
							$sql1="INSERT into $bai_pro3.pac_stat_log_input_job(doc_no,size_code,carton_act_qty,status,doc_no_ref,input_job_no,input_job_no_random,destination,packing_mode,old_size,type_of_sewing,pac_seq_no,sref_id,plan_cut_bundle_id,tran_user,style,color,schedule,tran_ts,barcode_sequence,barcode) VALUES ('$doc_no','$size_code',$qty,'$input_job_no','".$doc_no_ref."','".$ninput_job_no."','".$ninput_job_no_random."','$destination',$packing_mode,'$old_size',$type_of_sewing,$pac_seq_no,$sref_id,'".$plan_cut_bundle_id."','".$username."','".$style."','".$color."','".$schedule."','".date('Y-m-d H:i:s')."','".$bundle_seq."','".$barcode."')";
							// echo $sql1.'<br>';
							mysqli_query($link, $sql1) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"])); 
							$inserted_tid = mysqli_insert_id($link);

							$bcds = "Select operation_id,sfcs_smv,cut_number from $brandix_bts.bundle_creation_data where bundle_number = $tid group by operation_id";
							// echo $bcds;
							$bcds_result = mysqli_query($link,$bcds); 
							$operation_codes = array();
							while($row_bcd = mysqli_fetch_array($bcds_result)){
								$cut_number = $row_bcd['cut_number'];
								$operation_codes[] = $row_bcd['operation_id'];
								$smv[$operation_codes] = $row_bcd['sfcs_smv'];
							}
							// var_dump($operation_codes);
							// die();
							foreach($operation_codes as $index => $op_code)
							{
								$send_qty = 0;
								if($index == 0) {
									$send_qty = $qty;
								}
								//Plan Logical Bundle Trn
								$b_query = "INSERT  INTO $brandix_bts.bundle_creation_data(`style`,`schedule`,`color`,`size_id`,`size_title`,`sfcs_smv`,`bundle_number`,`original_qty`,`send_qty`,`recevied_qty`,`rejected_qty`,`left_over`,`operation_id`,`docket_number`, `scanned_date`, `scanned_user`, `cut_number`, `input_job_no`,`input_job_no_random_ref`, `shift`, `assigned_module`, `remarks`, `mapped_color`,`barcode_sequence`,`barcode_number`) VALUES ('".$style."','". $schedule."','".$color."','". $old_size."','".$size_code."','". $smv[$op_code]."',".$inserted_tid.",".$qty.",".$send_qty.",0,0,0,".$op_code.",'".$doc_no."','".date('Y-m-d H:i:s')."', '".$username."','".$cut_number."','".$ninput_job_no."','".$ninput_job_no_random."','','','Normal','".$color."',".$bundle_seq.",'".$barcode."')";
								mysqli_query($link, $b_query) or exit("Issue in inserting BCD".mysqli_error($GLOBALS["___mysqli_ston"]));
							}
							// $barcode='';
							// $bundle_seq++;

							$sql2="UPDATE $bai_pro3.pac_stat_log_input_job SET carton_act_qty='$nqty' WHERE tid='$tid'";
							// echo $sql2.'<br>'; 
							mysqli_query($link, $sql2) or exit("Sql Error3".mysqli_error($GLOBALS["___mysqli_ston"]));
						}
					}
					
					//-------------------------------------MO FILLING LOGIC -------------------------------------------------
					if($carton_act_qty == $qty) 
					{        
						//Updating the same record with new input job no
						/*
							$update_mo = "Update  $bai_pro3.mo_operation_quantites set input_job_no='$ninput_job_no',
										input_job_random='$ninput_job_no_random' where bundle_no = '$tid' ";
							$update_result = mysqli_query($link,$update_mo);//or exit('An error While Updating MO Quantities');
							if(mysqli_num_rows($update_result) > 0)
								continue;
						*/
					}else
					{
						//Updating existing bundle 
						/*
						$update_mo = "Update  $bai_pro3.mo_operation_quantites set input_job_no='$temp_input_job_no',
									  input_job_random='$temp_input_job_no_random',bundle_quantity='$nqty'
									  where bundle_no = '$tid' and input_job_random = '$temp_input_job_no_random' 
									  and input_job_no = '$temp_input_job_no'";
									  */
						
					    if($nqty>0)
						{
							$update_orig_bcd = "Update $brandix_bts.bundle_creation_data set original_qty='$nqty' where bundle_number = $tid "; 
							$update_orig_bcd_result = mysqli_query($link,$update_orig_bcd) or exit('An error While Updating BCD');  

							$get_send_bcd = "Select * 
							from $brandix_bts.bundle_creation_data where bundle_number = $tid and send_qty>0";
							$get_send_bcd_result = mysqli_query($link,$get_send_bcd); 
							while($row = mysqli_fetch_array($get_send_bcd_result)){
								$update_bcd = "Update $brandix_bts.bundle_creation_data set send_qty='$nqty'
								where bundle_number = $tid "; 
								$update_bcd_result = mysqli_query($link,$update_bcd) or exit('An error While Updating BCD'); 
							}


							$sql_orders_ops = "SELECT * FROM brandix_bts.tbl_orders_ops_ref WHERE category='sewing'";
			
							$sql_orders_ops_rslt = mysqli_query($link,$sql_orders_ops); 
							while($row_orders_ops = mysqli_fetch_array($sql_orders_ops_rslt))
							{
								$ops_code_sew[]=$row_orders_ops['operation_code'];
							}
							$ops_sew=implode(",",$ops_code_sew);
							$update_mo = "Update $bai_pro3.mo_operation_quantites set bundle_quantity='$nqty' where ref_no = $tid and op_code in($ops_sew)"; 
										// ref_no='$inserted_tid'             
							$update_result = mysqli_query($link,$update_mo) or exit('An error While Updating MO Quantities');        
							//getting mo_no,op_desc from mo_operation_quantities
							$mos = "Select mo_no,op_code,op_desc from $bai_pro3.mo_operation_quantites where ref_no = $tid and op_code in($ops_sew) group by op_desc";
							$mos_result = mysqli_query($link,$mos); 
							while($row = mysqli_fetch_array($mos_result)){
								$mo_no = $row['mo_no'];
								$ops[$row['op_code']] = $row['op_desc'];
							}
							//Inserting the new bundle quantity
							foreach(array_unique($ops) as $op_code=>$op_desc){
								$insert_mo = "Insert into $bai_pro3.mo_operation_quantites
											(date_time,mo_no,ref_no,bundle_quantity,op_code,op_desc) values 
											('".date('Y-m-d H:i:s')."','$mo_no',$inserted_tid,$qty,$op_code,'$op_desc')";          
								mysqli_query($link,$insert_mo) or exit("Problem while inserting to mo quantities");            
							}
							unset($ops);
						}	
					}
					//------------------------------------MO Filling Logic Ends----------------------------------------------
				}
			}
			else 
			{
				echo "<script>sweetAlert('Warning','For Sewing Job $input_job_no, Scanning is Performed.So, you cannot split the Sewing Job Anymore.','error');</script>";
			}
			
		}
	}
	$url = getFullURLLevel($_GET['r'],'split_jobs.php','0','N');
	$jobs_array = array_unique($jobs_array);
	foreach($jobs_array as $job){
		$updated = update_barcode_sequences($job);
	}
	$updated = update_barcode_sequences($ninput_job_no_random);
	echo "<script>sweetAlert('Success','Successfully Splitted your job.','success');</script>";
	echo "<script> 
					setTimeout('Redirect()',500); 
					function Redirect() {  
						location.href = '$url&sch=$schedule&job=$input_job_no&rand_no=$input_job_no_random'; 
					}
				</script>"; 
?> 
</div></div>
</body> 


<?php
function update_barcode_sequences($input_job_random){
    include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config_ajax.php');
    $CAT = 'sewing';
	//sewing cat opcodes
	$sewing_op_codes = "SELECT group_concat(operation_code) as op_codes FROM $brandix_bts.tbl_orders_ops_ref WHERE category = '$CAT'";
	$row = mysqli_fetch_array(mysqli_query($link,$sewing_op_codes));
	{
	    $op_codes = $row['op_codes'];
	}
    $query = "select tid,doc_no,input_job_no from $bai_pro3.pac_stat_log_input_job where input_job_no_random = '$input_job_random' ";
    $result = mysqli_query($link,$query);
    while($row = mysqli_fetch_array($result)){
        $id = $row['tid'];
        $doc_no = $row['doc_no'];
        $input_job_no = $row['input_job_no'];
        // $tid = explode(',',$tids);
		$counter = sizeof($tid);
		$barcode="SPB-".$doc_no."-".$input_job_no."-".$counter."";
        // foreach($tid as $id){
		$update_query = "Update $bai_pro3.pac_stat_log_input_job set barcode_sequence = $counter,barcode='".$barcode."' where tid='$id'";
		mysqli_query($link,$update_query) or exit('Unable to update');
		$update_query_bcd = "Update $brandix_bts.bundle_creation_data set barcode_sequence = $counter,barcode_number = '".$barcode."' where bundle_number='$id' and operation_id in ($op_codes)";
		mysqli_query($link,$update_query_bcd) or exit('Unable to update BCD');
		$counter--;
        // }
	}
	return true;
}  

?>