<?php
    include(getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));
    include(getFullURLLevel($_GET['r'],'common/config/functions.php',4,'R'));
?> 



<body> 
<div class="panel panel-primary">
<!-- <div class="panel-heading">Sewing Job Split</div> -->
<div class="panel-body">

<?php
    $username_list=explode('\\',$_SERVER['REMOTE_USER']); 
    $username=strtolower($username_list[1]); 
    $tid=$_POST['tid']; 
    $qty=$_POST['qty']; 

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

        $url_s = getFullURLLevel($_GET['r'],'split_jobs.php',0,'N');

        $sqlx="SELECT order_del_no FROM $bai_pro3.packing_summary_input where tid='$tid'"; 
        $resultx=mysqli_query($link, $sqlx) or exit("Sql Error4".mysqli_error($GLOBALS["___mysqli_ston"])); 
        if($rowx=mysqli_fetch_array($resultx))
        { 
            $schedule=$rowx['order_del_no']; 
        }

        $query_check = "SELECT COUNT(id) FROM $brandix_bts.`bundle_creation_data` WHERE input_job_no_random_ref='$input_job_no_random'";
        $res_query_check=mysqli_query($link,$query_check);
        while($result = mysqli_fetch_array($res_query_check))
        {
            $count = $result['cnt'];
        }
        if ($count=='') 
        {
            if ($qty == 0) 
            {
                echo "<script>sweetAlert('Splitting Quantity cannot be zero','','warning')</script>"; 
            }
            else if ($carton_act_qty == $qty) 
            {
                echo "<script>sweetAlert('Cannot Split Same Quantity as Original Sewing Job Quantity','','warning')</script>";
            } 
            else 
            {
                $nqty=$carton_act_qty-$qty;
                
                if($nqty>0)
                {
                    $ninput_job_no=$input_job_no.'A'; 
                    $ninput_job_no_random=$input_job_no_random.'A';
                    
                    $sql1="INSERT into $bai_pro3.pac_stat_log_input_job(doc_no,size_code,carton_act_qty,status,doc_no_ref,input_job_no,input_job_no_random,destination,packing_mode,old_size) VALUES ('$doc_no','$size_code','$qty','$status','".$doc_no_ref."','".$ninput_job_no."','".$ninput_job_no_random."','$destination','$packing_mode','$old_size')";
                    // echo $sql1;
                    mysqli_query($link, $sql1) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"])); 
                     
                    $sql2="UPDATE $bai_pro3.pac_stat_log_input_job SET carton_act_qty='$nqty' WHERE tid='$tid'"; 
                    mysqli_query($link, $sql2) or exit("Sql Error3".mysqli_error($GLOBALS["___mysqli_ston"]));
                    echo "<script>sweetAlert('Success','Successfully Splitted your job.','success');</script>";
                }
            }

        }
        else 
        {
            echo "<script>sweetAlert('Warning','For Sewing Job $input_job_no, Scanning is Performed.So, you cannot split the Sewing Job Anymore.','success');</script>";
        }
       
        echo "<script> 
                setTimeout('Redirect()',3000); 
                function Redirect() {  
                    location.href = '$url_s&sch=$schedule&job=$input_job_no'; 
                }
            </script>";          
    }
?> 
</div></div>
</body> 