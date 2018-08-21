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
    $tids=$_POST['tid']; 
    $qtys=$_POST['qty']; 
	for($ii=0; $ii<sizeof($tids); $ii++)
    { 
        $tid=$tids[$ii]; 
        $qty=$qtys[$ii];
		if($qty>0)
		{		
			$sql="SELECT * FROM $bai_pro3.pac_stat_log_input_job where tid='$tid'"; 
			$result=mysqli_query($link, $sql) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"])); 
			if($row=mysqli_fetch_array($result))
			{ 
				$doc_no=$row['doc_no']; 
				$size_code=$row['size_code']; 
				$carton_act_qty=$row['carton_act_qty']; 
				$status=$row['status']; 
				$doc_no_ref=$row['doc_no_ref']; 
				$input_job_no=$row['input_job_no']; 
				$input_job_no_random=$row['input_job_no_random']; 
				$destination=$row['destination']; 
				$packing_mode=$row['packing_mode']; 
				$old_size=$row['old_size']; 
				$type_of_sewing=$row['type_of_sewing']; 
				$url_s = getFullURLLevel($_GET['r'],'split_jobs.php',0,'N');
				$sqlx="SELECT order_del_no FROM $bai_pro3.packing_summary_input where tid='$tid'"; 
				$resultx=mysqli_query($link, $sqlx) or exit("Sql Error4".mysqli_error($GLOBALS["___mysqli_ston"])); 
				if($rowx=mysqli_fetch_array($resultx))
				{ 
					$schedule=$rowx['order_del_no']; 
				}
				$nqty=$carton_act_qty-$qty;
				$getlastrec="SELECT input_job_no FROM $bai_pro3.pac_stat_log_input_job WHERE input_job_no_random LIKE '%$schedule%' and input_job_no like '%$input_job_no.%' ORDER BY tid DESC LIMIT 0,1"; 
				$res_last_rec=mysqli_query($link,$getlastrec);
				if($row=mysqli_fetch_array($res_last_rec))
				{ 
				   $finalinputjobno=$row['input_job_no']; 
				}
				if($finalinputjobno=='')
				{
					$ninput_job_no=$input_job_no.'.1'; 
					$ninput_job_no_random=$input_job_no_random.'.1';
				}
				else
				{                     
					$befdec=$finalinputjobno;
					$finalval=explode('.',$befdec);
					$aftdec=$finalval[1];
    				$incrementno=$aftdec+1;
					$ninput_job_no=$input_job_no.'.'.$incrementno; 
					$ninput_job_no_random=$input_job_no_random.'.'.$incrementno;
				}
				if ($carton_act_qty == $qty) 
				{
					$sql2="UPDATE $bai_pro3.pac_stat_log_input_job SET input_job_no_random='$ninput_job_no_random',input_job_no='$ninput_job_no' WHERE tid='$tid'"; 
					mysqli_query($link, $sql2) or exit("Sql Error3".mysqli_error($GLOBALS["___mysqli_ston"]));
				} 
				else
				{ 
					$sql1="INSERT into $bai_pro3.pac_stat_log_input_job(doc_no,size_code,carton_act_qty,status,doc_no_ref,input_job_no,input_job_no_random,destination,packing_mode,old_size,type_of_sewing) VALUES ('$doc_no','$size_code','$qty','$status','".$doc_no_ref."','".$ninput_job_no."','".$ninput_job_no_random."','$destination','$packing_mode','$old_size','$type_of_sewing')";
					// echo $sql1;die();
					mysqli_query($link, $sql1) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"])); 
					$sql2="UPDATE $bai_pro3.pac_stat_log_input_job SET carton_act_qty='$nqty' WHERE tid='$tid'"; 
					mysqli_query($link, $sql2) or exit("Sql Error3".mysqli_error($GLOBALS["___mysqli_ston"]));
				}
			}
		}	
    }
    echo "<script>sweetAlert('Success','Successfully Splitted your job.','success');</script>";
    echo "<script> 
                    setTimeout('Redirect()',1000); 
                    function Redirect() {  
                        location.href = '$url_s&sch=$schedule&job=$input_job_no'; 
                    }
                </script>"; 
?> 
</div></div>
</body> 