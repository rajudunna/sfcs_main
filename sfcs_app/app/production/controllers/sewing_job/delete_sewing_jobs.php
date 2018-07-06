<?php
    include(getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));
    $has_permission=haspermission($_GET['r']);
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
        //alert("Test2"); 
        // var key = window.event ? event.keyCode : event.which; 
        // if (event.keyCode == 8 || event.keyCode == 37 || event.keyCode == 39)  
        // { 
        //     return true; 
        // } 
        // else if ( key < 48 || key > 57 ) { 
        //     return false; 
        // } 
        // else  
        // { 
        //     return true; 
        // } 
        event = (event) ? event : window.event; 
        var charCode = (event.which) ? event.which : event.keyCode; 
        if (charCode > 31 && (charCode < 48 || charCode > 57)) { 
            return false; 
        } 
        return true; 
    }; 
</script> 

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

        $validation_query="SELECT * FROM $bai_pro3.act_cut_status WHERE doc_no IN (SELECT doc_no FROM $bai_pro3.plandoc_stat_log WHERE order_tid LIKE '%".$schedule."%')"; 
        // echo $validation_query; 
        $sql_result=mysqli_query($link, $validation_query) or exit("Error while getting validation data"); 
        $count= mysqli_num_rows($sql_result); 
        // echo "<br>Count==".$count; 
         
        if ($count>0) { 
            echo "<br><div class='alert alert-danger'>Cutting is Already Performed<br><br>You Cannot Delete the Schedule</div>"; 
        } else {
            $tid_ref=array(); 
            $doc_no_ref=array(); 
            $input_job_no_random_ref=array(); 
            $sql="select tid AS tid,doc_no AS doc_no,input_job_no_random from $bai_pro3.packing_summary_input where order_del_no='$schedule'"; 
            // echo $sql."<br>"; 
            $sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
            while($sql_row=mysqli_fetch_array($sql_result)) 
            { 
                $tid_ref[]=$sql_row['tid']; 
                $doc_no_ref[]=$sql_row['doc_no']; 
                $input_job_no_random_ref[]=$sql_row["input_job_no_random"]; 
            } 
            $doc_no_ref[]=0; 
            $tid_ref[]=0; 
            $input_job_no_random_ref[]=0; 
             
            $tid=implode(",",array_unique($tid_ref)); 
            $doc_no=implode(",",array_unique($doc_no_ref));     
            $input_job_no_random=implode(",",array_unique($input_job_no_random_ref)); 
            //echo $doc_no; 
             
            $sql5="select id from $brandix_bts.tbl_orders_master where product_schedule='$schedule'"; 
            $sql_result5=mysqli_query($link, $sql5) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"])); 
            while($sql_row5=mysqli_fetch_array($sql_result5)) 
            { 
                $sch_ref=$sql_row5["id"]; 
            } 
            //echo $sch_ref."-".$sql5."<br>"; 
             
            $sql5="select id from $brandix_bts.tbl_min_ord_ref where ref_crt_schedule='$sch_ref'"; 
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
                $sql5="select id from $brandix_bts.tbl_carton_ref where ref_order_num='$sch_ref'"; 
                //echo $sql5."</br>"; 
                //mysql_query($sql5,$link) or exit("Sql Error".mysql_error()); 
                $sql_result5=mysqli_query($link, $sql5) or exit("Sql Error test".mysqli_error($GLOBALS["___mysqli_ston"])); 
                //echo "count ".mysql_num_rows($sql_result5)."</br>"; 
                if(mysqli_num_rows($sql_result5)>0){ 
                    while($sql_row5=mysqli_fetch_array($sql_result5)) 
                    { 
                        $crt_ref=$sql_row5["id"]; 
                    } 
                    $sql2="delete from $brandix_bts.tbl_carton_size_ref where parent_id in (".$crt_ref.")"; 
                    //echo $crt_ref."-".$sql2."<br>"; 
                    mysqli_query($link, $sql2) or exit("Sql Error5".mysqli_error($GLOBALS["___mysqli_ston"])); 
                } 
                 
                 
                // $sql5="update $bai_pro3.bai_orders_db_confirm set bts_status=0 where order_del_no='$schedule'"; 
                // //echo $sql5."<br>"; 
                // mysqli_query($link, $sql5) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"])); 
                 
                // $sql51="select * from $brandix_bts.tbl_orders_master where product_schedule='$sch_ref'"; 
                // //echo $sql51."<br>"; 
                // $sql_result51=mysqli_query($link, $sql51)or exit("Sql Error51".mysqli_error($GLOBALS["___mysqli_ston"])); 
                // if(mysqli_num_rows($sql_result51) > 0) 
                // { 
                //     $sql5="delete from $brandix_bts.tbl_orders_master where product_schedule=$sch_ref"; 
                //     //echo $sql5."<br>"; 
                //     mysqli_query($link, $sql5) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"])); 
                // } 
                 

                // $sql7="update $bai_pro3.bai_orders_db_confirm set bts_status=0 where order_del_no='$sch_ref'"; 
                // //echo $sql7."<br>"; 
                // mysqli_query($link, $sql7) or exit("Sql Error3".mysqli_error($GLOBALS["___mysqli_ston"])); 
                 
                // $sql71="delete FROM $brandix_bts.tbl_cut_size_master WHERE parent_id IN (SELECT id FROM $brandix_bts.tbl_cut_master WHERE doc_num in (".$doc_no."))"; 
                // //echo $sql71."<br>"; 
                // mysqli_query($link, $sql71) or exit("Sql Error31".$sql71.mysqli_error($GLOBALS["___mysqli_ston"])); 
                 
                // $sql21="select * from $brandix_bts.tbl_carton_ref where ref_order_num in ('$sch_ref')"; 
                // //echo $sql21."<br>"; 
                // $sql_result21=mysqli_query($link, $sql21)or exit("Sql Error21".mysqli_error($GLOBALS["___mysqli_ston"])); 
                // if(mysqli_num_rows($sql_result21) > 0) 
                // { 
                    $sql2="delete from $brandix_bts.tbl_carton_ref where ref_order_num in (".$sch_ref.")"; 
                    //echo $sql2."<br>"; 
                    mysqli_query($link, $sql2) or exit("Sql Error4".mysqli_error($GLOBALS["___mysqli_ston"])); 
                // } 
                 

                // $sql2="delete from $brandix_bts.tbl_min_ord_ref where ref_crt_schedule in ('$sch_ref')"; 
                // //echo $sql2."<br>"; 
                // mysqli_query($link, $sql2) or exit("Sql Error6".mysqli_error($GLOBALS["___mysqli_ston"])); 
                $sql2="delete from $brandix_bts.tbl_miniorder_data where mini_order_ref='".$mini_order_ref."'"; 
                // echo $sql2."<br>"; 
                mysqli_query($link, $sql2) or exit("Sql Error7".mysqli_error($GLOBALS["___mysqli_ston"])); 
                 
                // // $sql2="delete from $brandix_bts.tbl_orders_sizes_master where "; 
                // $sql2="DELETE FROM $brandix_bts.`tbl_orders_sizes_master` WHERE parent_id IN (SELECT id FROM $brandix_bts.`tbl_orders_master` WHERE product_schedule='$schedule')"; 
                // // echo $sql2."<br>"; 
                // mysqli_query($link, $sql2) or exit("Sql Error7.1".mysqli_error($GLOBALS["___mysqli_ston"])); 
                 
                // $sql3="delete from $brandix_bts.tbl_cut_master where product_schedule='$schedule'"; 
                // //echo $sql3."<br>"; 
                // mysqli_query($link, $sql3) or exit("Sql Error8".mysqli_error($GLOBALS["___mysqli_ston"])); 
                 
                // get data from pac stat log to delete data from plan dashboard and plan dashboard input 
                $pac_stat_qry="select concat(group_concat(doc_no),0) as doc_no,concat(group_concat(input_job_no_random),0) as input_job_no_random from $bai_pro3.pac_stat_log_input_job where tid in($tid)"; 
                //echo $pac_stat_qry."</br>"; 
                $pac_stat_result=mysqli_query($link, $pac_stat_qry) or exit("Sql Error pac_stat_qry".mysqli_error($GLOBALS["___mysqli_ston"])); 
                while($pac_stat_res=mysqli_fetch_array($pac_stat_result)) 
                { 
                    $doc_no=$pac_stat_res["doc_no"]; 
                    $input_job_no_random=$pac_stat_res["input_job_no_random"]; 
                } 
                // echo "doc_no".$doc_no.'<br>'; 
                // echo "input_job_no_random".$input_job_no_random.'<br>'; 
                $delete_plan_dashbrd_qry="DELETE FROM $bai_pro3.plan_dashboard WHERE doc_no in($doc_no)"; 
                // echo $delete_plan_dashboard_qry."<br>"; 
                mysqli_query($link, $delete_plan_dashbrd_qry) or exit("Sql Error delete_plan_dashbrd_qry"); 
                 
                $delete_plan_input_qry="DELETE FROM $bai_pro3.plan_dashboard_input WHERE input_job_no_random_ref like  \"".$schedule."%\""; 
                // echo $delete_plan_input_qry."<br>"; 
                mysqli_query($link, $delete_plan_input_qry) or exit("Sql Error delete_plan_input_qry".mysqli_error($GLOBALS["___mysqli_ston"])); 
                 
                //$sql3="delete from pac_stat_log_input_job where tid in (".$tid.")"; 
                $sql3="DELETE FROM $bai_pro3.pac_stat_log_input_job WHERE input_job_no_random like  \"".$schedule."%\""; 
                // echo $sql3."<br>"; 
                mysqli_query($link, $sql3) or exit("Sql Error91".mysqli_error($GLOBALS["___mysqli_ston"])); 
                
                $insert_log="INSERT INTO $bai_pro3.inputjob_delete_log (user_name,date_time,reason,SCHEDULE) VALUES (USER(),now(),'$reason','$schedule')"; 
                // echo $insert_log."</br>"; 
                mysqli_query($link, $insert_log) or exit("Sql Error insert_log".mysqli_error($GLOBALS["___mysqli_ston"])); 

                // $sql3="DELETE FROM $bai_pro3.pac_stat_log_input_job WHERE doc_no IN (SELECT doc_no FROM $bai_pro3.plandoc_stat_log WHERE order_tid LIKE \"%".$schedule."%\")"; 
                // $sql3="DELETE FROM $bai_pro3.pac_stat_log_input_job WHERE input_job_no_random like  \"".$schedule."%\""; 
                // echo $sql3."<br>"; 
                // mysqli_query($link, $sql3) or exit("Sql Error9".mysqli_error($GLOBALS["___mysqli_ston"])); 
                 
                // echo "<br><div class='alert alert-success'>Jobs Successfully Deleted</div>"; 
    			echo "<script>sweetAlert('Jobs Successfully Deleted','','success')</script>";
            } 
            else 
            { 
                // echo "<br><div class='alert alert-danger'>Please Generate Sewing Jobs Before Deleting!!</div>"; 
    			echo "<script>sweetAlert('Please Generate Sewing Jobs Before Deleting!!','','error')</script>";
            } 
            echo "</div></div>"; 
        } 
    } 

?> 
</div> 
</div>