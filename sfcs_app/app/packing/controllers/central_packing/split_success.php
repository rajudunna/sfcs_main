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
	$schedule=$_POST['schedule'];
	$style=$_POST['style'];
	$cartonno=$_POST['cartonno'];
	$packmethod=$_POST['pack_method'];
    $seq_no=$_POST['seqno'];
	
	$maxcartno="SELECT MAX(carton_no) AS cartno FROM $bai_pro3.`pac_stat_log` WHERE schedule='$schedule' AND pack_method='$packmethod'";
	$maxcartrslt=mysqli_query($link,$maxcartno);
	if($row=mysqli_fetch_array($maxcartrslt))
	{
		$maxcartonno=$row['cartno'];
	}
	$newcartno=$maxcartonno+1;

    // $getlastrec="SELECT input_job_no FROM $bai_pro3.pac_stat_log_input_job WHERE input_job_no_random = '$input_job_no_random' and input_job_no = '$input_job_no' ORDER BY tid DESC LIMIT 0,1"; 

    // $res_last_rec=mysqli_query($link,$getlastrec);
    // if($row=mysqli_fetch_array($res_last_rec))
    // { 
       // $finalinputjobno=$row['input_job_no']; 
    // }

    // if($finalinputjobno=='')
    // {
        // $ninput_job_no=$input_job_no.'.1'; 
        // $ninput_job_no_random=$input_job_no_random.'.1';
    // }
    // else
    // {                     
        // $befdec=$finalinputjobno;
        // $finalval=explode('.',$befdec);
        // $aftdec=$finalval[1];

        // $incrementno=$aftdec+1;

        // $ninput_job_no=$input_job_no.'.'.$incrementno; 
        // $ninput_job_no_random=$input_job_no_random.'.'.$incrementno;
    // }

    for ($ii=0; $ii <sizeof($tids); $ii++)
    { 
        $tid=$tids[$ii]; 
        $qty=$qtys[$ii]; 
    
        $sql="SELECT * FROM $bai_pro3.pac_stat_log where tid = '$tid' and carton_no='$cartonno'"; 
        // echo $sql.'<br>';
        $result=mysqli_query($link, $sql) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"])); 

        if($row=mysqli_fetch_array($result))
        { 
            $doc_no=$row['doc_no']; 
            $size_code=$row['size_code'];
			$cartonno=$row['carton_no'];
			$cartonmode=$row['carton_mode'];	
            $carton_act_qty=$row['carton_act_qty']; 
            $status=$row['status']; 
            $doc_no_ref=$row['doc_no_ref'];
			$container=$row['container']; 	
            $input_job_no=$row['input_job_number']; 
            $input_job_random=$row['input_job_random']; 
			$ordertid=$row['order_tid']; 
            $color=$row['color']; 
            $size_tit=$row['size_tit']; 
            $seq_no=$row['seq_no']; 
			$pacseqno=$row['pac_seq_no']; 
			
			$newdoc_no_ref=$schedule."-".$pacseqno."-".$newcartno;	
		
            $url_s = getFullURLLevel($_GET['r'],'split_jobs.php',0,'N');

            // $sqlx="SELECT order_del_no FROM $bai_pro3.packing_summary_input where tid='$tid'"; 
            // $resultx=mysqli_query($link, $sqlx) or exit("Sql Error4".mysqli_error($GLOBALS["___mysqli_ston"])); 
            // if($rowx=mysqli_fetch_array($resultx))
            // { 
                // $schedule=$rowx['order_del_no']; 
            // }

            $query_check = "SELECT status FROM $bai_pro3.`pac_stat_log` WHERE tid='$tid'";
            $res_query_check=mysqli_query($link,$query_check);
            while($result = mysqli_fetch_array($res_query_check))
            {
                $status = $result['status'];
            }
			
            if ($status!='DONE' || $status!='') 
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
                        $sql2="UPDATE $bai_pro3.pac_stat_log SET doc_no_ref='$newdoc_no_ref',carton_no=='$newcartno' WHERE tid='$tid'"; 
                        // echo $sql2.'<br>';
                        mysqli_query($link, $sql2) or exit("Sql Error3".mysqli_error($GLOBALS["___mysqli_ston"]));
                    }
                    else
                    {
                        $nqty=$carton_act_qty-$qty;
                        if($nqty>0)
                        {
                            $sql1="INSERT into $bai_pro3.pac_stat_log(doc_no,size_code,carton_no,carton_mode,carton_act_qty,status,doc_no_ref,container,disp_carton_no,disp_id,audit_status,scan_date,scan_user,input_job_random,input_job_number,order_tid,module,style,schedule,color,size_tit,seq_no,pack_method,pac_seq_no) VALUES ('$doc_no','$size_code','$newcartno','$cartonmode','$qty','$status','".$newdoc_no_ref."','1','','','','','','$input_job_random','$input_job_no','$ordertid','','$style','$schedule','$color','$size_tit','$seq_no','$packmethod','$pacseqno')";
                            // echo $sql1.'<br>';
							// die();
                            mysqli_query($link, $sql1) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"])); 
                         
                            $sql2="UPDATE $bai_pro3.pac_stat_log SET carton_act_qty='$nqty' WHERE tid='$tid'";
                            // echo $sql2.'<br>'; 
                            mysqli_query($link, $sql2) or exit("Sql Error3".mysqli_error($GLOBALS["___mysqli_ston"]));
                        }
                    }                        
                }
            }
            else 
            {
                echo "<script>sweetAlert('Warning','For Sewing Job $input_job_no, Scanning is Performed.So, you cannot split the Sewing Job Anymore.','warning');</script>";
            }       
                   
        }
    }
    echo "<script>sweetAlert('Success','Successfully Splitted your job.','success');</script>";
    echo "<script> 
                    setTimeout('Redirect()',3000); 
                    function Redirect() {  
                        location.href = '$url_s&schedule=$schedule&cartonno=$cartonno&style=$style&packmethod=$packmethod'; 
                    }
                </script>"; 
?> 
</div></div>
</body> 