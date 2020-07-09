<?php
    include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));
    include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/functions_dashboard.php',4,'R'));
    $id=$_GET['id'];
    $style=style_decode($_GET['style']);

    $schedule=$_GET['schedule'];
    $rem_type=$_GET['rem_type'];
    $username = getrbac_user()['uname'];
    $updated_date = date("Y-m-d h:i:s");

    $update_revers_qry = "update $bai_pro3.short_shipment_job_track set remove_type=0,updated_by='".$username."',updated_at='".$updated_date."' where id=".$id;
    $update_revers_qry_result = mysqli_query($link, $update_revers_qry) or exit("update error".mysqli_error($GLOBALS["___mysqli_ston"]));
    
    if($update_revers_qry_result) {
        //To Reverse jobs IPS and TMS
        $remove_docs=array();
        $remove_ref_nums=array();
        //Get Ref Numbers
        $sql_ref_nums="select distinct input_job_no_random as job_numbers from $bai_pro3.packing_summary_input where order_style_no = '$style' and order_del_no = '$schedule'";
        // echo $sql_ref_nums;die();
        $sql_ref_nums_res=mysqli_query($link, $sql_ref_nums) or exit("Sql Error121".mysqli_error($GLOBALS["___mysqli_ston"]));
        while($sql_rowx=mysqli_fetch_array($sql_ref_nums_res))
        {
            $remove_ref_nums[]="'".$sql_rowx['job_numbers']."'";
        }
        $order_tid_qry="select distinct order_tid as order_tids from $bai_pro3.bai_orders_db where order_style_no = '$style' and order_del_no = '$schedule'";
        $order_tid_res=mysqli_query($link, $order_tid_qry) or exit("Sql Error122".mysqli_error($GLOBALS["___mysqli_ston"]));
        while($sql_rowr=mysqli_fetch_array($order_tid_res))
        {
            $order_tids[]="'".$sql_rowr['order_tids']."'";
        }

        //Get Doc Numbers
        $sql_doc_nums="select distinct doc_no as doc_numbers from $bai_pro3.plandoc_stat_log where order_tid in (".implode(",",$order_tids).")";
        $sql_doc_nums_res=mysqli_query($link, $sql_doc_nums) or exit("Sql Error114".mysqli_error($GLOBALS["___mysqli_ston"]));
        while($sql_rows=mysqli_fetch_array($sql_doc_nums_res))
        {
            $remove_docs[]="'".$sql_rows['doc_numbers']."'";
        }
        if(sizeof($remove_ref_nums)>0)
        {      
            $rev_ips_chk_qry = "select distinct input_job_no_random_ref as ips_tms_jobs from $bai_pro3.plan_dashboard_input_backup where input_job_no_random_ref in (".implode(",",$remove_ref_nums).") and short_shipment_status=1";
            $rev_ips_chk_qry_res = mysqli_query($link, $rev_ips_chk_qry) or exit("Sql Error20".mysqli_error($GLOBALS["___mysqli_ston"]));
            while($rev_ips_chck_row=mysqli_fetch_array($rev_ips_chk_qry_res))
            {
                $ips_tms_jobs[]="'".$rev_ips_chck_row['ips_tms_jobs']."'";
            }
            if(sizeof($ips_tms_jobs)>0){
                $sql_check="select input_job_no_random_ref from $bai_pro3.plan_dashboard_input where input_job_no_random_ref in (".implode(",",$ips_tms_jobs).")";
                $sql_check_res=mysqli_query($link, $sql_check) or exit("Sql Error11212".mysqli_error($GLOBALS["___mysqli_ston"]));
                if(mysqli_num_rows($sql_check_res)==0)
                {
                    $reverse_ips_query="INSERT INTO $bai_pro3.plan_dashboard_input SELECT * FROM $bai_pro3.plan_dashboard_input_backup WHERE input_job_no_random_ref in (".implode(",",$ips_tms_jobs).")";
                    $backup_ips_query_result = mysqli_query($link, $reverse_ips_query) or exit("Sql Error12".mysqli_error($GLOBALS["___mysqli_ston"]));
                    $update_ips_qry = "update $bai_pro3.plan_dashboard_input set short_shipment_status = 0 where input_job_no_random_ref in (".implode(",",$ips_tms_jobs).") and short_shipment_status = 1";
                    $update_ips_qry_result = mysqli_query($link, $update_ips_qry) or exit("Sql Error13".mysqli_error($GLOBALS["___mysqli_ston"]));
                    $del_ips_bckup_sqlx="delete from $bai_pro3.plan_dashboard_input_backup where input_job_no_random_ref in (".implode(",",$ips_tms_jobs).") and short_shipment_status = 1";
                    $del_ips_bckup_sqlx_result = mysqli_query($link, $del_ips_bckup_sqlx) or exit("Sql Error14".mysqli_error($GLOBALS["___mysqli_ston"]));
                }    
                
            }
            
            //To reverse Jobs in IMS
            $rev_ims_chk_qry = "select distinct input_job_rand_no_ref as ims_jobs from $bai_pro3.ims_log_backup where input_job_rand_no_ref in (".implode(",",$remove_ref_nums).") and short_shipment_status = 1";
            $rev_ims_chk_qry_res = mysqli_query($link, $rev_ims_chk_qry) or exit("Sql Error20".mysqli_error($GLOBALS["___mysqli_ston"]));
            while($rev_ims_chck_row=mysqli_fetch_array($rev_ims_chk_qry_res))
            {
                $ims_jobs[]="'".$rev_ims_chck_row['ims_jobs']."'";
            }
            if(sizeof($ims_jobs)>0){
                $sql_check2="select input_job_rand_no_ref from $bai_pro3.ims_log where input_job_rand_no_ref in (".implode(",",$ims_jobs).")";
                $sql_check_res2=mysqli_query($link, $sql_check2) or exit("Sql Error11212".mysqli_error($GLOBALS["___mysqli_ston"]));
                if(mysqli_num_rows($sql_check_res2)==0)
                {
                    $reverse_ims_query="INSERT INTO $bai_pro3.ims_log SELECT * FROM $bai_pro3.ims_log_backup WHERE input_job_rand_no_ref in (".implode(",",$ims_jobs).")";
                    mysqli_query($link, $reverse_ims_query) or exit("Sql Error16".mysqli_error($GLOBALS["___mysqli_ston"]));
                    $update_ims_qry = "update $bai_pro3.ims_log set short_shipment_status =0 where input_job_rand_no_ref in (".implode(",",$ims_jobs).") and short_shipment_status = 1";
                    $update_ims_qry_res =mysqli_query($link, $update_ims_qry) or exit("Sql Error17".mysqli_error($GLOBALS["___mysqli_ston"]));
                    $del_ims_bckup_sqlx = "delete from $bai_pro3.ims_log_backup where input_job_rand_no_ref in (".implode(",",$ims_jobs).") and short_shipment_status = 1";
                    $del_ims_bckup_sqlx_res =mysqli_query($link, $del_ims_bckup_sqlx) or exit("Sql Error18".mysqli_error($GLOBALS["___mysqli_ston"]));
                }    
                
            }

        }
          
            
        $wip_chck_qry = "select id from $brandix_bts.bundle_creation_data where style='".$style."' and schedule='".$schedule."'and bundle_qty_status=3";
        $wip_chck_qry_res=mysqli_query($link, $wip_chck_qry) or exit("Sql Error20".mysqli_error($GLOBALS["___mysqli_ston"]));
        while($wip_chck_row=mysqli_fetch_array($wip_chck_qry_res))
        {
            $wip_jobs[]="'".$wip_chck_row['id']."'";
        }
        if(sizeof($wip_jobs)>0){
            $wip_dash_table_update="UPDATE $brandix_bts.bundle_creation_data SET bundle_qty_status=0 WHERE id in (".implode(",",$wip_jobs).") and bundle_qty_status=3";
            $wip_dash_table_update_resultx=mysqli_query($link, $wip_dash_table_update) or exit("Sql Error144".mysqli_error($GLOBALS["___mysqli_ston"]));
        }
        
        if(sizeof($remove_docs)>0)
        {
            //To Reverse docs in RMS and cwip in WPT
            $plan_doc_qry="UPDATE $bai_pro3.plandoc_stat_log SET short_shipment_status=0 WHERE doc_no in (".implode(",",$remove_docs).") and short_shipment_status = 1 ";
            $plan_doc_qry_resultx=mysqli_query($link, $plan_doc_qry) or exit("Sql Error11".mysqli_error($GLOBALS["___mysqli_ston"]));
            
            //To Reverse Jobs in Cut Table Dashboard
            $cut_chck_qry = "select distinct doc_no as cut_docs from $bai_pro3.cutting_table_plan where doc_no in (".implode(",",$remove_docs).") and short_shipment_status = 1";
            $cut_chck_qry_res=mysqli_query($link, $cut_chck_qry) or exit("Sql Error20".mysqli_error($GLOBALS["___mysqli_ston"]));
            while($cut_chck_row=mysqli_fetch_array($cut_chck_qry_res))
            {
                $cut_docs[]="'".$cut_chck_row['cut_docs']."'";
            }
                    
            if(sizeof($cut_docs)>0){
                $cut_table_update="UPDATE $bai_pro3.cutting_table_plan SET short_shipment_status=0 WHERE doc_no in (".implode(",",$cut_docs).") and short_shipment_status = 1";
                $cut_table_update_resultx=mysqli_query($link, $cut_table_update) or exit("Sql Error181".mysqli_error($GLOBALS["___mysqli_ston"]));
            }
            
            //To Reverse Jobs in Embellishment Dashboard
            $emblishment_chck_qry = "select distinct doc_no as emb_docs from $bai_pro3.embellishment_plan_dashboard where doc_no in (".implode(",",$remove_docs).") and short_shipment_status = 1";
            $emblishment_chck_qry_res=mysqli_query($link, $emblishment_chck_qry) or exit("Sql Error20".mysqli_error($GLOBALS["___mysqli_ston"]));
            while($emb_chck_row=mysqli_fetch_array($emblishment_chck_qry_res))
            {
                $emb_docs[]="'".$emb_chck_row['emb_docs']."'";
            }
            if(sizeof($emb_docs)>0){
                $emb_table_update="UPDATE $bai_pro3.embellishment_plan_dashboard SET short_shipment_status=0 WHERE doc_no in (".implode(",",$emb_docs).") and short_shipment_status = 1";
                $emb_table_update_resultx=mysqli_query($link, $emb_table_update) or exit("Sql Error191".mysqli_error($GLOBALS["___mysqli_ston"]));
            }
                
            //to Reverse jobs in Recut Dashboard
            $recut_chck_qry = "select distinct doc_no as recut_docs from $bai_pro3.recut_v2 where doc_no in (".implode(",",$remove_docs).") and short_shipment_status = 1";
            $recut_chck_qry_res=mysqli_query($link, $recut_chck_qry) or exit("Sql Error20".mysqli_error($GLOBALS["___mysqli_ston"]));
            while($recut_chck_row=mysqli_fetch_array($recut_chck_qry_res))
            {
                $recut_docs[]="'".$recut_chck_row['recut_docs']."'";
            }
            if(sizeof($recut_docs)>0){
                $recut_table_update="UPDATE $bai_pro3.recut_v2 SET short_shipment_status=0 WHERE doc_no in (".implode(",",$recut_docs).") and short_shipment_status = 1";
                $recut_table_update_resultx=mysqli_query($link, $recut_table_update) or exit("Sql Error141".mysqli_error($GLOBALS["___mysqli_ston"]));
            }
        }
                
        //To remove Jobs in Rejection Dashboard-(ims,cutt(2),Rejection)
        $rej_table_query="select * from $bai_pro3.rejections_log where style='$style' and schedule = '$schedule' and short_shipment_status=1";
        $rej_table_query_resultx=mysqli_query($link, $rej_table_query) or exit("Sql Error101".mysqli_error($GLOBALS["___mysqli_ston"]));
        $rej_table_rowx=mysqli_num_rows($rej_table_query_resultx);
        if($rej_table_rowx>0)
        { 
            $rej_table_update="UPDATE bai_pro3.rejections_log SET short_shipment_status=0 WHERE style = '$style' and schedule = '$schedule' and short_shipment_status=1";
            $rej_table_update_result=mysqli_query($link, $rej_table_update) or exit("Sql Error011".mysqli_error($GLOBALS["___mysqli_ston"]));
        }

        echo "<script>swal('Short Shipment Jobs Successfully Reversed','','success');</script>";
        $url = getFullUrlLevel($_GET['r'],'remove_jobs.php',0,'N');
        echo "<script>setTimeout(function(){
                    location.href='$url' 
                },2000);
                </script>";
        exit();
                    
    }
                    
?>

