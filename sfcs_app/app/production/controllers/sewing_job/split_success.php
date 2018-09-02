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
    $input_job_no_random=$_POST['input_job_no_random']; 
    $input_job_no=$_POST['input_job_no'];

    //temp values to insert to mo_quantites table    
    $temp_input_job_no_random = $input_job_no_random;
    $temp_input_job_no = $input_job_no;
   
    $getlastrec="SELECT input_job_no FROM $bai_pro3.pac_stat_log_input_job WHERE input_job_no_random = '$input_job_no_random' and input_job_no = '$input_job_no' ORDER BY tid DESC LIMIT 0,1"; 
    // echo $getlastrec;die();
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
        // $finalval=$finalinputjobno-$aftdec;
        $finalval=explode('.',$befdec);
        $aftdec=$finalval[1];

        $incrementno=$aftdec+1;

        $ninput_job_no=$input_job_no.'.'.$incrementno; 
        $ninput_job_no_random=$input_job_no_random.'.'.$incrementno;
    }

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
                else 
                {
                    
                    if ($carton_act_qty == $qty) 
                    {
                        // echo "<script>alert('into if condition');</script>";
                        $sql2="UPDATE $bai_pro3.pac_stat_log_input_job SET input_job_no_random='$ninput_job_no_random',input_job_no='$ninput_job_no' WHERE tid='$tid'"; 
                        // echo $sql2.'<br>';
                        mysqli_query($link, $sql2) or exit("Sql Error3".mysqli_error($GLOBALS["___mysqli_ston"]));
                    }
                    else
                    {
                        $nqty=$carton_act_qty-$qty;
                        if($nqty>0)
                        {
                            $sql1="INSERT into $bai_pro3.pac_stat_log_input_job(doc_no,size_code,carton_act_qty,status,doc_no_ref,input_job_no,input_job_no_random,destination,packing_mode,old_size,type_of_sewing) VALUES ('$doc_no','$size_code','$qty','$status','".$doc_no_ref."','".$ninput_job_no."','".$ninput_job_no_random."','$destination','$packing_mode','$old_size','$type_of_sewing')";
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
                        $update_mo = "Update  $bai_pro3.mo_operation_quantites set input_job_no='$ninput_job_no',
                                      input_job_random='$ninput_job_no_random' where bundle_no = '$tid' ";
                        $update_result = mysqli_query($link,$update_mo);//or exit('An error While Updating MO Quantities');
                        if(mysqli_num_rows($update_result) > 0)
                            continue;
                    }else{
                        //Updating existing bundle 
                        $update_mo = "Update  $bai_pro3.mo_operation_quantites set input_job_no='$temp_input_job_no',
                                      input_job_random='$temp_input_job_no_random',bundle_quantity='$nqty'
                                      where bundle_no = '$tid' and input_job_random = '$temp_input_job_no_random' 
                                      and input_job_no = '$temp_input_job_no'";
                        $update_result = mysqli_query($link,$update_mo);//or exit('An error While Updating MO Quantities');        
                
                        //getting mo_no,op_desc from mo_operation_quantities
                        $mos = "Select mo_no,op_desc 
                                from $bai_pro3.mo_operation_quantites where bundle_no = '$tid' 
                                and input_job_random = '$temp_input_job_no_random' and input_job_no = '$temp_input_job_no' 
                                group by op_desc";
                        $mos_result = mysqli_query($link,$mos); 
                        while($row = mysqli_fetch_array($mos_result)){
                            $mo_no = $row['mon_no'];
                            $ops[$row['op_code']] = $row['op_desc'];
                        }
                        //Inserting the new bundle quantity
                        foreach(array_unique($ops) as $op_code=>$op_desc){
                            $insert_mo = "Insert into $bai_pro3.mo_operation_quantites
                                        ('mo_no','doc_no','bundle_no','bundle_quantity','op_code','op_desc','input_job_no',
                                        'input_job_random','size_id') values 
                                        ($mo_no,$doc_no,$inserted_tid,$qty,$op_code,$op_desc,$ninput_job_no,$ninput_job_no_random,
                                         $old_size)";
                            mysqli_query($link,$insert_mo);            
                        }
                        unset($ops);
                    }
                    //------------------------------------MO Filling Logic Ends----------------------------------------------
                }
            }
            else 
            {
                echo "<script>sweetAlert('Warning','For Sewing Job $input_job_no, Scanning is Performed.So, you cannot split the Sewing Job Anymore.','success');</script>";
            }       
                   
        }
    }
    echo "<script>sweetAlert('Success','Successfully Splitted your job.','success');</script>";
    echo "<script> 
                    setTimeout('Redirect()',3000); 
                    function Redirect() {  
                        location.href = '$url_s&sch=$schedule&job=$input_job_no'; 
                    }
                </script>"; 
?> 
</div></div>
</body> 