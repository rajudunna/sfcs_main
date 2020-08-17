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
			$quantity = 1;
			$query_check = "SELECT * FROM $brandix_bts.`bundle_creation_data_temp` WHERE input_job_no_random_ref='$input_job_no_random'";
			$res_query_check=mysqli_query($link,$query_check);
			$query_qty_check = "SELECT sum(recevied_qty) as rec,sum(rejected_qty) as rej FROM $brandix_bts.`bundle_creation_data_temp` WHERE input_job_no_random_ref='$input_job_no_random'";
			$res_query_qty_check=mysqli_query($link,$query_qty_check);
			while($qty_res = mysqli_fetch_array($res_query_qty_check))
			{
				$rec_qty = $qty_res['rec'];
				$rej_qty = $qty_res['rej'];
				$quantity = $rec_qty + $rej_qty ;
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
					}
					else
					{
						$nqty=$carton_act_qty-$qty;
						if($nqty>0)
						{
							$sql1="INSERT into $bai_pro3.pac_stat_log_input_job(doc_no,size_code,carton_act_qty,status,doc_no_ref,input_job_no,input_job_no_random,destination,packing_mode,old_size,type_of_sewing,pac_seq_no,sref_id) VALUES ('$doc_no','$size_code',$qty,'$input_job_no','".$doc_no_ref."','".$ninput_job_no."','".$ninput_job_no_random."','$destination',$packing_mode,'$old_size',$type_of_sewing,$pac_seq_no,$sref_id)";
							// echo $sql1.'<br>';
							mysqli_query($link, $sql1) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"])); 
							$inserted_tid = mysqli_insert_id($link);
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
					}else{
						//Updating existing bundle 
						/*
						$update_mo = "Update  $bai_pro3.mo_operation_quantites set input_job_no='$temp_input_job_no',
									  input_job_random='$temp_input_job_no_random',bundle_quantity='$nqty'
									  where bundle_no = '$tid' and input_job_random = '$temp_input_job_no_random' 
									  and input_job_no = '$temp_input_job_no'";
									  */
						$update_mo = "Update  $bai_pro3.mo_operation_quantites set bundle_quantity='$nqty'
									  where ref_no = $tid "; 
									// ref_no='$inserted_tid'             
						$update_result = mysqli_query($link,$update_mo) or exit('An error While Updating MO Quantities');        
				
						//getting mo_no,op_desc from mo_operation_quantities
						$mos = "Select mo_no,op_desc,op_code 
								from $bai_pro3.mo_operation_quantites where ref_no = $tid  
								group by op_desc";
		
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
    $query = "select tid from $bai_pro3.pac_stat_log_input_job 
             where input_job_no_random = '$input_job_random' order by tid DESC";
    $result = mysqli_query($link,$query);
    while($row = mysqli_fetch_array($result)){
        $tids[] = $row['tid'];
	}
	// $tid = explode(',',$tids);
	$counter = sizeof($tids);
	foreach($tids as $id){
		$update_query = "Update $bai_pro3.pac_stat_log_input_job set barcode_sequence = $counter where tid='$id'";
		mysqli_query($link,$update_query) or exit('Unable to update');
		$counter--;
	}
	return true;
}  

?>