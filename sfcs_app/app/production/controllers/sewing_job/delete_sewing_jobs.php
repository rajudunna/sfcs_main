<?php
    include(getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));
    include(getFullURLLevel($_GET['r'],'common/config/functions.php',4,'R'));
    include(getFullURLLevel($_GET['r'],'common/config/mo_filling.php',4,'R'));
    $has_permission=haspermission($_GET['r']);
    $application = 'IPS'; 
?> 
<script type="text/javascript"> 
    function enableButton()  
    { 
        if(document.getElementById('option').checked) 
        { 
            document.getElementById('submit').disabled=''; 
        }  
        else  
        { 
            document.getElementById('submit').disabled='true'; 
        } 
    } 

    function button_disable() 
    { 
        document.getElementById('process_message').style.visibility="visible"; 
        document.getElementById('submit').style.disabled='true'; 
    } 

    function validateQty(event)  
    {
        event = (event) ? event : window.event; 
        var charCode = (event.which) ? event.which : event.keyCode; 
        if (charCode > 31 && (charCode < 48 || charCode > 57)) { 
            return false; 
        } 
        return true; 
    }

    function confirm_delete(e,t)
    {
        e.preventDefault();
        var v = sweetAlert({
            title: "Are you sure to Delete this Sewing Job?",
            icon: "warning",
            buttons: true,
            dangerMode: true,
            buttons: ["No, Cancel It!", "Yes, I am Sure!"],
        }).then(function(isConfirm){
            if (isConfirm) {
                window.location = $(t).attr('href');
                return true;
            } else {
                sweetAlert("Request Cancelled",'','error');
                return false;
            }
        });
    }

</script> 
<style type="text/css">
    table, th, td {
        text-align: center;
    }
</style>
<div class="panel panel-primary"> 
    <div class="panel-heading"><strong>Delete Sewing Jobs</strong></div> 
    <div class="panel-body">
<?php
    if(in_array($authorized,$has_permission))
    { 
        ?>          
        <form name="input" method="post" action="?r=<?php echo $_GET['r']; ?>"> 
            <div class="row"> 
                <div class="col-md-3"> 
                    <label>Enter Schedule No: </label> 
                    <input type="text" class='form-control'  onkeypress="return validateQty(event);" name="schedule" required /> 
                </div>     
                <div class="col-md-3"> 
                    <label>Reason:</label> 
                    <input type="text" class='form-control' id="reason" name="reason" required/> 
                </div> 
                    <input type="submit" class='btn btn-danger confirm-submit' style="margin-top:22px;" name="submit" id="submit" value="Delete" /> 
            </div>
        </form>
        <?php  
    }else{ 
        echo "<br><div class='alert alert-danger'>You are Not Authorized to Delete Sewing Jobs</div>";
    }
    
    if(isset($_POST['submit'])) 
    { 
        $schedule=$_POST['schedule'];
        $reason=$_POST['reason']; 
        $schedule = str_replace(' ', '', $schedule);
        $ips_op_codes=array();
        $ips_op_codes[]=0;
        // $op_code_query = "Select operation_code from $brandix_bts.tbl_ims_ops where appilication = '$application' ";
        $op_code_query="SELECT operation_code FROM $brandix_bts.tbl_orders_ops_ref WHERE category='sewing'";
                    $op_code_result = mysqli_query($link,$op_code_query);
        while($row = mysqli_fetch_array($op_code_result)){
            $ips_op_codes[] = $row['operation_code'];
        }
        $ips_op_code=implode(",",$ips_op_codes);
        $validation_query = "SELECT id from $brandix_bts.bundle_creation_data where schedule = '$schedule' and recevied_qty > 0
                    and operation_id in (".$ips_op_code.")";
        // $validation_query="SELECT * FROM $bai_pro3.act_cut_status WHERE doc_no IN (SELECT doc_no FROM $bai_pro3.plandoc_stat_log WHERE order_tid LIKE '%".$schedule."%')"; 
        // echo $validation_query; 
        $sql_result=mysqli_query($link, $validation_query) or exit("Error while getting validation data"); 
        $count= mysqli_num_rows($sql_result); 
        // echo "<br>Count==".$count; 
         
        if ($count>0) 
        { 
            echo "<br><div class='alert alert-danger'>Scanning is Already Performed<br><br>You Cannot Delete the Schedule</div>";
            exit(); 
        } 
        else 
        {  
            $sql="SELECT * FROM $bai_pro3.packing_summary_input WHERE order_del_no='$schedule' and mrn_status='1'";  
                $sql_result=mysqli_query($link, $sql) or exit("Sql Error7".mysqli_error($GLOBALS["___mysqli_ston"]));
                $rowcount1=mysqli_num_rows($sql_result);
            if($rowcount1>0)
            {
                echo "<script>sweetAlert('MRN Confirmed for this Schedule','','warning')</script>";
            }
            else
            {
                $pac_stat_input_check = echo_title("$bai_pro3.packing_summary_input","count(*)","pac_seq_no > 0 and order_del_no",$schedule,$link);
                if ($pac_stat_input_check > 0)
                {
                    $url=getFullURL($_GET['r'],'delete_sewing_jobs.php','N');

                    $get_seq_details = "SELECT DISTINCT pac_seq_no,packing_mode, order_del_no FROM bai_pro3.`packing_summary_input` WHERE order_del_no='$schedule'";
                    $details_seq=mysqli_query($link, $get_seq_details) or exit("error while fetching sequence details for this schedule"); 
                    if (mysqli_num_rows($details_seq) > 0)
                    {
                        echo "<br>
                            <div class='col-md-12 table-responsive'>
                                <table class=\"table table-bordered\">
                                    <tr class=\"info\">
                                        <th>Schedule</th>
                                        <th>Sequence</th>
                                        <th>Sewing Method</th>
                                        <th>Control</th>
                                    </tr>";
                        while($row=mysqli_fetch_array($details_seq)) 
                        {
                            $schedule1 = $row['order_del_no'];
                            $pac_seq_no = $row['pac_seq_no'];
                            $pack_method = $row['packing_mode'];

                            echo "<tr>
                                    <td>$schedule1</td>
                                    <td>$pac_seq_no</td>
                                    <td>$operation[$pack_method]</td>
                                    <td><a id='delete' class='btn btn-danger'  onclick='return confirm_delete(event,this)' href='$url&schedule=".$schedule1."&reason=$reason&seq_no=".$pac_seq_no."&option=delete'>Delete</td>
                                </tr>";
                        }
                    }
                }
                else
                {
                    $tid_ref=array(); 
                    $doc_no_ref=array(); 
                    $input_job_no_random_ref=array(); 

                    $sql5="select id from $brandix_bts.tbl_orders_master where product_schedule='$schedule'"; 
                    $sql_result5=mysqli_query($link, $sql5) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"])); 
                    while($sql_row5=mysqli_fetch_array($sql_result5)) 
                    { 
                        $sch_ref=$sql_row5["id"]; 
                    } 
                    $sql5="select id from $brandix_bts.tbl_carton_ref where ref_order_num='$sch_ref'"; 
                    $sql_result5=mysqli_query($link, $sql5) or exit("Sql Error1.5".mysqli_error($GLOBALS["___mysqli_ston"])); 
                    while($sql_row5=mysqli_fetch_array($sql_result5)) 
                    { 
                        $mini_order_ref=$sql_row5["id"]; 
                    } 
                    // echo $mini_order_ref."-".$sql5."<br>"; 
                    $sql2="select * from $brandix_bts.tbl_miniorder_data where mini_order_ref='".$mini_order_ref."'"; 
                    $result=mysqli_query($link, $sql2) or exit("Sql Error7".mysqli_error($GLOBALS["___mysqli_ston"])); 
                    $Mini_order_count=mysqli_num_rows($result); 
                    // echo "<br>".$Mini_order_count; 
                    if ($Mini_order_count>0)  
                    {
                        $packing_summary_input_check = echo_title("$bai_pro3.packing_summary_input","count(*)","order_del_no",$schedule,$link);
                        if ($packing_summary_input_check > 0)
                        {
                            $sql5="select id from $brandix_bts.tbl_carton_ref where ref_order_num='$sch_ref'"; 
                            //echo $sql5."</br>"; 
                            $sql_result5=mysqli_query($link, $sql5) or exit("Sql Error test".mysqli_error($GLOBALS["___mysqli_ston"])); 
                            if(mysqli_num_rows($sql_result5)>0)
                            { 
                                while($sql_row5=mysqli_fetch_array($sql_result5)) 
                                { 
                                    $crt_ref=$sql_row5["id"]; 
                                } 
                                $sql2="delete from $brandix_bts.tbl_carton_size_ref where parent_id in (".$crt_ref.")"; 
                                //echo $crt_ref."-".$sql2."<br>"; 
                                mysqli_query($link, $sql2) or exit("Sql Error5".mysqli_error($GLOBALS["___mysqli_ston"])); 
                            } 
                            
                            $sql2="delete from $brandix_bts.tbl_carton_ref where ref_order_num in (".$sch_ref.")"; 
                            //echo $sql2."<br>"; 
                            mysqli_query($link, $sql2) or exit("Sql Error4".mysqli_error($GLOBALS["___mysqli_ston"])); 
                            
                            $sql2="delete from $brandix_bts.tbl_miniorder_data where mini_order_ref='".$mini_order_ref."'"; 
                            // echo $sql2."<br>"; 
                            mysqli_query($link, $sql2) or exit("Sql Error7".mysqli_error($GLOBALS["___mysqli_ston"])); 

                            $sql="select tid AS tid,doc_no AS doc_no,input_job_no_random from $bai_pro3.packing_summary_input where order_del_no='$schedule'"; 
                            // echo $sql."<br>"; 
                            $sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
                            while($sql_row=mysqli_fetch_array($sql_result)) 
                            { 
                                $tid_ref[]=$sql_row['tid']; 
                                $doc_no_ref[]=$sql_row['doc_no']; 
                                $input_job_no_random_ref[]=$sql_row["input_job_no_random"]; 
                            }
                            
                            $tid=implode(",",array_unique($tid_ref)); 
                            $doc_no=implode(",",array_unique($doc_no_ref));     
                            $input_job_no_random=implode("','",array_unique($input_job_no_random_ref)); 
                            
                            $delete_plan_dashbrd_qry="DELETE FROM $bai_pro3.plan_dashboard WHERE doc_no in($doc_no)"; 
                            // echo $delete_plan_dashboard_qry."<br>"; 
                            mysqli_query($link, $delete_plan_dashbrd_qry) or exit("Sql Error delete_plan_dashbrd_qry"); 
                            
                            $delete_plan_input_qry="DELETE FROM $bai_pro3.plan_dashboard_input WHERE input_job_no_random_ref in ('$input_job_no_random')"; 
                            // echo $delete_plan_input_qry."<br>"; 
                            mysqli_query($link, $delete_plan_input_qry) or exit("Sql Error delete_plan_input_qry".mysqli_error($GLOBALS["___mysqli_ston"])); 
                            
                            $sql3="DELETE FROM $bai_pro3.`pac_stat_log_input_job` WHERE tid IN ($tid)";
                            // echo $sql3."<br>"; 
                            mysqli_query($link, $sql3) or exit("Sql Error91".mysqli_error($GLOBALS["___mysqli_ston"])); 
                            
                            $insert_log="INSERT INTO $bai_pro3.inputjob_delete_log (user_name,date_time,reason,SCHEDULE) VALUES ('$username',now(),'$reason','$schedule')"; 
                            // echo $insert_log."</br>"; 
                            mysqli_query($link, $insert_log) or exit("Sql Error insert_log".mysqli_error($GLOBALS["___mysqli_ston"])); 

                            $deleted = deleteMoQuantitiesSewing($schedule);
                            echo "<script>sweetAlert('Sewing Jobs Successfully Deleted','','success')</script>";
                        }
                    }
                    else if($mini_order_ref>0)
                    {
                        $sql2="delete from $brandix_bts.tbl_carton_size_ref where parent_id='".$crt_ref."'"; 
                        //echo $crt_ref."-".$sql2."<br>"; 
                        mysqli_query($link, $sql2) or exit("Sql Error5".mysqli_error($GLOBALS["___mysqli_ston"])); 
                        $sql2="delete from $brandix_bts.tbl_carton_ref where ref_order_num='".$sch_ref."'"; 
                        //echo $sql2."<br>"; 
                        mysqli_query($link, $sql2) or exit("Sql Error4".mysqli_error($GLOBALS["___mysqli_ston"]));

                        echo "<script>sweetAlert('Packing Ratio Successfully Deleted','','success')</script>";
                    } 
                    else 
                    { 
                        echo "<script>sweetAlert('Please Generate Sewing Jobs Before Deleting!!','','error')</script>";
                    } 
                }
            }
            echo "</div></div>"; 
        } 
    }

    if($_GET['schedule'] && $_GET['seq_no'] && ($_GET['option'] == 'delete'))
    {
        $schedule = $_GET['schedule'];
        $seqno = $_GET['seq_no'];
        $reason = $_GET['reason'];
        // echo $reason;
        $ips_op_codes=array();
        $ips_op_codes[]=0;
        // $op_code_query = "Select operation_code from $brandix_bts.tbl_ims_ops where appilication = '$application' ";
        $op_code_query="SELECT operation_code FROM $brandix_bts.tbl_orders_ops_ref WHERE category='sewing'";
                    $op_code_result = mysqli_query($link,$op_code_query);
        while($row = mysqli_fetch_array($op_code_result)){
            $ips_op_codes[] = $row['operation_code'];
        }
        $ips_op_code=implode(",",$ips_op_codes);
        $validation_query = "SELECT id from $brandix_bts.bundle_creation_data where schedule = '$schedule' and recevied_qty > 0
                    and operation_id in (".$ips_op_code.")";
        $sql_result=mysqli_query($link, $validation_query) or exit("Error while getting validation data");      
        $count= mysqli_num_rows($sql_result); 
        if($count>0) 
        { 
            echo "<br><div class='alert alert-danger'>Scanning is Already Performed<br><br>You Cannot Delete the Schedule</div>";
            exit(); 
        }             

        $tid = array(); $docket_no = array();   $input_job_no_random_array = array();
        $sql="SELECT * FROM $bai_pro3.packing_summary_input WHERE order_del_no='$schedule' and mrn_status='1'";  
        $sql_result=mysqli_query($link, $sql) or exit("Sql Error7".mysqli_error($GLOBALS["___mysqli_ston"]));
        $rowcount2=mysqli_num_rows($sql_result);
        if($rowcount2>0)
        {
            echo "<script>sweetAlert('MRN Confirmed for this Schedule','','warning')</script>";
        }
        else
        {

            $get_seq_details = "SELECT tid, doc_no, input_job_no_random FROM bai_pro3.`packing_summary_input` WHERE pac_seq_no = $seqno and order_del_no='$schedule'";
            $details_seq=mysqli_query($link, $get_seq_details) or exit("error while fetching sequence details for this schedule");
            while($row=mysqli_fetch_array($details_seq))
            {
                $tid[] = $row['tid'];
                $docket_no[] = $row['doc_no'];
                $input_job_no_random_array[] = $row['input_job_no_random'];
            }

            $get_tids = implode(',', $tid);
            $get_docs = implode(",", array_unique($docket_no));
            $get_job_random = implode("','", array_unique($input_job_no_random_array));

            if (count($tid) > 0)
            {
                $sql_to_verify_row="SELECT count(*) as res FROM $bai_pro3.`pac_stat_input` WHERE SCHEDULE=$schedule and pac_seq_no<>'$seqno' group by SCHEDULE";
                $op_code_result12 = mysqli_query($link, $sql_to_verify_row) or exit("while check pac_stat_input");
                while($row12=mysqli_fetch_array($op_code_result12)) 
                {
                    $op_codes_details  = $row12['res']; 
                }

                $sql_to_verify_row741="SELECT MAX(id) AS id FROM bai_pro3.`pac_stat_input` WHERE SCHEDULE='$schedule' AND pac_seq_no=$seqno";
                $op_code_result1256 = mysqli_query($link, $sql_to_verify_row741) or exit("while check pac_stat_input");
                while($row12236=mysqli_fetch_array($op_code_result1256)) 
                {
                    $max_id  = $row12236['id']; 
                }

                $sql_to_verify_row741="SELECT MAX(id) AS id FROM bai_pro3.`pac_stat_input` WHERE SCHEDULE='$schedule' AND id <> $max_id;";
                $op_code_result1256 = mysqli_query($link, $sql_to_verify_row741) or exit("while check pac_stat_input");
                while($row12236=mysqli_fetch_array($op_code_result1256)) 
                {
                    $max_id_b4  = $row12236['id']; 
                }

                if($op_codes_details==0)
                {
                    $delete_tbl_docket_qty="DELETE FROM $bai_pro3.`tbl_docket_qty` WHERE pac_stat_input_id IN (SELECT id FROM $bai_pro3.`pac_stat_input` WHERE SCHEDULE=$schedule)"; 
                    // echo $delete_tbl_docket_qty."<br>"; 
                    mysqli_query($link, $delete_tbl_docket_qty) or exit("while Deleting tbl_docket_qty"); 
                }
                else
                {
                    $sq_input_jobs="select doc_no,size_code,type_of_sewing,sum(carton_act_qty) as qty FROM $bai_pro3.pac_stat_log_input_job WHERE pac_seq_no=$seqno and  doc_no IN (".implode(',', array_unique($docket_no)).") group by type_of_sewing,doc_no,size_code"; 
                    // echo $sq_input_jobs."<br>"; 
                    $sql_result_job = mysqli_query($link, $sq_input_jobs) or exit("while fetching pac_stat_log_input_job"); 
                    while($row123=mysqli_fetch_array($sql_result_job)) 
                    {
                        $update_doc_qty="update $bai_pro3.`tbl_docket_qty` set fill_qty=(fill_qty-".$row123['qty'].") WHERE type='".$row123['type_of_sewing']."' and doc_no='".$row123['doc_no']."' and size='".$row123['size_code']."'";
                        mysqli_query($link, $update_doc_qty) or exit("Update in  docket_qty table");
                    }

                    $update1="update $bai_pro3.`tbl_docket_qty` set pac_stat_input_id='$max_id_b4' where pac_stat_input_id='$max_id'";
                    mysqli_query($link, $update1) or ("Sql error".mysqli_error($GLOBALS["___mysqli_ston"]));              
                }       
                
                $delete_pac_stat_input="DELETE FROM $bai_pro3.`pac_stat_input` WHERE SCHEDULE=$schedule AND pac_seq_no=$seqno"; 
                // echo $delete_pac_stat_input."<br>"; 
                mysqli_query($link, $delete_pac_stat_input) or exit("while Deleting pac_stat_input"); 

                $delete_pac_stat_log_ij="DELETE FROM $bai_pro3.pac_stat_log_input_job WHERE tid IN ($get_tids)"; 
                // echo $delete_pac_stat_log_ij."<br>"; 
                mysqli_query($link, $delete_pac_stat_log_ij) or exit("while Deleting pac_stat_log_input_job");

                $sql_check_docs="select doc_no FROM $bai_pro3.pac_stat_log_input_job WHERE doc_no in ($get_docs) group by doc_no";
                // echo $sql_check_docs."<br>"; 
                $sql_check_avail=mysqli_query($link, $sql_check_docs) or exit("select pac_stat_log_input_job => ".$sql_check_docs);
                if(mysqli_num_rows($sql_check_avail)>0)
                {
                    $temp_doc=array();
                    $final_doc=array();
                    while($row432=mysqli_fetch_array($op_code_result)) 
                    {
                        $temp_doc[]=$row432['doc_no'];                  
                    }
                    $final_doc=array_diff(array_unique($docket_no),$temp_doc);
                    
                    if (count($final_doc) > 0)
                    {
                        $delete_plan_dashbrd_qry="DELETE FROM $bai_pro3.plan_dashboard WHERE doc_no in(".implode(",",$final_doc).")"; 
                        // echo $delete_plan_dashboard_qry."<br>"; 
                        mysqli_query($link, $delete_plan_dashbrd_qry) or exit("Sql Error delete_plan_dashbrd_qry"); 
                        
                        $delete_plan_input_qry="DELETE FROM bai_pro3.`plan_dashboard_input` WHERE input_job_no_random_ref IN ('$get_job_random')"; 
                        // echo $delete_plan_input_qry."<br>"; 
                        mysqli_query($link, $delete_plan_input_qry) or exit("Sql Error delete_plan_input_qry");
                    }                    
                }
                else
                {
                    $delete_plan_dashbrd_qry="DELETE FROM $bai_pro3.plan_dashboard WHERE doc_no in($get_docs)"; 
                    // echo $delete_plan_dashboard_qry."<br>"; 
                    mysqli_query($link, $delete_plan_dashbrd_qry) or exit("Sql Error delete_plan_dashbrd_qry"); 
                    
                    $delete_plan_input_qry="DELETE FROM bai_pro3.`plan_dashboard_input` WHERE input_job_no_random_ref IN ('$get_job_random')"; 
                    // echo $delete_plan_input_qry."<br>"; 
                    mysqli_query($link, $delete_plan_input_qry) or exit("Sql Error delete_plan_input_qry");
                }          

                $insert_log="INSERT INTO $bai_pro3.inputjob_delete_log (user_name,date_time,reason,SCHEDULE) VALUES ('$username',now(),'$reason','$schedule')"; 
                // echo $insert_log."</br>"; 
                mysqli_query($link, $insert_log) or exit("Sql Error insert_log");

                // MO Deletion start
                    $sewing_cat = 'sewing';
                    $op_code_query  ="SELECT group_concat(operation_code) as codes FROM $brandix_bts.tbl_orders_ops_ref 
                                    WHERE trim(category) = '$sewing_cat' ";
                    $op_code_result = mysqli_query($link, $op_code_query) or exit("No Operations Found for Sewing");
                    while($row=mysqli_fetch_array($op_code_result)) 
                    {
                        $op_codes  = $row['codes']; 
                    }

                    $mo_query  = "SELECT GROUP_CONCAT(mo_no) as mos from $bai_pro3.mo_details where schedule = '$schedule'";
                    $mo_result = mysqli_query($link,$mo_query);
                    while($row = mysqli_fetch_array($mo_result))
                    {
                        $mos = $row['mos'];
                    }

                    $delete_query = "DELETE from $bai_pro3.mo_operation_quantites where ref_no in ($get_tids) and op_code in ($op_codes) ";
                    $delete_result = mysqli_query($link,$delete_query);
                    if($delete_result > 0)
                    {
                        echo "<script>sweetAlert('Sewing Jobs Successfully Deleted','','success')</script>";
                        echo("<script>
                                window.setTimeout(function(){
                                    window.location.href = '".getFullURLLevel($_GET['r'],'delete_sewing_jobs.php',0,'N')."';
                                }, 1500);
                            </script>");
                    }
                // MO Deletion end
            }
            else
            {
                echo "<script>sweetAlert('Please Generate Sewing Jobs for Sequence - $seqno','','error')</script>";
                echo("<script>
                        window.setTimeout(function(){
                            window.location.href = '".getFullURLLevel($_GET['r'],'delete_sewing_jobs.php',0,'N')."';
                        }, 1500);
                    </script>");
            }
        }
    }
?> 
</div> 
</div>
