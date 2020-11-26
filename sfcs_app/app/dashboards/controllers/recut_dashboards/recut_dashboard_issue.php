<?php
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config_ajax.php');
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/mo_filling.php');
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/functions.php');
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/bundle_filling.php');
// error_reporting(E_ALL);
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/functions_dashboard.php');
include 'sewing_barcode_generation.php';
$get_url1 = getFullURLLevel($_GET['r'],'marker_update_popup.php',0,'R');

?>
<?php
if(isset($_POST['formSubmit']))
{

    $cat=$_POST['cat'];
    $mklen=$_POST['mklen'];
    $plies=$_POST['plies'];
    $order_tid=$_POST['order_tid'];
    $style=$_POST['style'];
    $schedule=$_POST['schedule'];
    $color=$_POST['color'];
    $module=$_POST['module'];
    $cat_name=$_POST['cat_name'];
    $doc_nos=$_POST['doc_no_ref'];
    // $size = $_POST['size'];
    $ratioval =$_POST['ratioval'];
    $codes='2';
    $docket_no = '';
    $qry_cut_qty_check_qry = "SELECT * FROM $bai_pro3.recut_v2 WHERE doc_no = '$doc_nos' ";
    $result_qry_cut_qty_check_qry = $link->query($qry_cut_qty_check_qry);
    while($row = $result_qry_cut_qty_check_qry->fetch_assoc()) 
    {
        for ($i=0; $i < sizeof($sizes_array); $i++)
        { 
            if ($row['a_'.$sizes_array[$i]] > 0)
            {
                $cut_done_qty[$sizes_array[$i]] = $row['a_'.$sizes_array[$i]] * $row['a_plies'];
                $size[] = $sizes_array[$i];
                // $ratioval[$sizes_array[$i]][] = $row['a_'.$sizes_array[$i]];
            }
        }
    }
    $query="SELECT* FROM $bai_pro3.`cuttable_stat_log` WHERE order_tid='$order_tid'";
    $sql_result111=mysqli_query($link, $query) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    while($sql_row111=mysqli_fetch_array($sql_result111))
    {
        $tid=$sql_row111['tid'];
    }
    $qry_to_get = "SELECT * FROM  `$bai_pro3`.`cat_stat_log` WHERE  order_tid = \"$order_tid\" and category = '$cat_name'";
    $res_qry_to_get = $link->query($qry_to_get);
    while($row_cat_ref = $res_qry_to_get->fetch_assoc()) 
    {
        $cat_ref =$row_cat_ref['tid'];
        $patt_ver = $row_cat_ref['patt_ver'];
    }
    
    $sql1="insert into $bai_pro3.maker_stat_log(date,cat_ref,order_tid,mklength,mk_ver) values (\"".date("Y-m-d")."\",".$cat_ref.",\"$order_tid\",".$mklen.",'".$patt_ver."')";
    mysqli_query($link, $sql1) or exit("Sql Error3".mysqli_error($GLOBALS["___mysqli_ston"]));
    $ilastid=((is_null($___mysqli_res = mysqli_insert_id($link))) ? false : $___mysqli_res);
    $sql1="update $bai_pro3.recut_v2 set fabric_status='0',p_plies=".$plies.",a_plies=".$plies.",mk_ref=$ilastid where doc_no=".$doc_nos;
    mysqli_query($link, $sql1) or exit("Sql Error45".mysqli_error($GLOBALS["___mysqli_ston"]));
    $sql1="update $bai_pro3.plandoc_stat_log set p_plies=".$plies.",a_plies=".$plies.",mk_ref=$ilastid where doc_no=".$doc_nos;
    mysqli_query($link, $sql1) or exit("Sql Error45".mysqli_error($GLOBALS["___mysqli_ston"]));

    //retreaving actual quantity to recut
    
    for($j=0;$j<sizeof($size);$j++)
    {
        $qty_act = array_sum($ratioval[$size[$j]])*$plies;
        $buffer_qty[$size[$j]] = $qty_act - $cut_done_qty[$size[$j]] ;
        $qty_ind_ratio  =  array_sum($ratioval[$size[$j]]);
        $a_string = 'a_'.$size[$j];
        $p_string = 'p_'.$size[$j];
        $sql="insert into $bai_pro3.bai_qms_db (qms_style,qms_schedule,qms_color,log_date,qms_size,qms_qty,qms_tran_type,remarks) values (\"$style\",\"$schedule\",\"$color\",\"".date("Y-m-d")."\",\"".str_replace("a_","",$size[$j])."\",".($qty_act).",9,\"$module-".$doc_nos."\")";
        $sql_result=mysqli_query($link, $sql) or exit("Sql Error5".mysqli_error($GLOBALS["___mysqli_ston"]));
        $update_qry = "update  $bai_pro3.recut_v2 set $a_string=$qty_ind_ratio,$p_string=$qty_ind_ratio where doc_no = $doc_nos";
        mysqli_query($link, $update_qry) or exit("while updating into recut v2".mysqli_error($GLOBALS["___mysqli_ston"]));
        $update_qry_plan = "update  $bai_pro3.plandoc_stat_log set $a_string=$qty_ind_ratio,$p_string=$qty_ind_ratio where doc_no = $doc_nos";
        mysqli_query($link, $update_qry_plan) or exit("while updating into recut v2".mysqli_error($GLOBALS["___mysqli_ston"]));
    }
    $i=1;
    $sql="insert into $bai_pro3.recut_track(doc_no,username,sys_name,log_time,level,status) values(\"".$doc_nos."\",\"".$username."\",\"".$hostname[0]."\",\"".date("Y-m-d H:i:s")."\",\"".$codes."\",\"".$status."\")";
    mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    $url = '?r='.$_GET['r'];
    //update plan cut bundle
        $plan_cut = plan_cut_bundle($doc_nos);
    echo "<script>sweetAlert('Successfully Markers updated','','success');window.location = '".$url."'</script>";
}
if(isset($_POST['formIssue']))
{
    $issueval = $_POST['issueval'];
    $bcd_id = $_POST['bcd_id'];
     $newIds = [];
    foreach($bcd_id as $cat => $bcdIds) {
        foreach($bcdIds as $id) {
            $newIds[] = $id;
        }
    }
    $doc_no_ref = $_POST['doc_no_ref'];
    $job_no = $_POST['job_no'];
    $size = $_POST['size'];
    // var_dump($_POST);
    // die();
    // $job_list = implode(",",$job_no);
    $job_list = "'" . implode("','", $job_no) . "'";
    // $get_schedule="SELECT distinct(SCHEDULE),input_job_no FROM $bai_pro3.pac_stat_log_input_job WHERE input_job_no_random in (".$job_list.")";
    // $get_schedule_result=mysqli_query($link, $get_schedule)  or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
    // while($row = mysqli_fetch_array($get_schedule_result))
    // {
    //     $schedule = $row['SCHEDULE'];
    //     $input_job_no = $row['input_job_no'];
    // }
    // $job_deactivated="SELECT count(*) FROM $bai_pro3.job_deactive_log WHERE input_job_no_random in (".$job_list.") and remove_type='3'";
    // //echo $job_deactivated;
    // $job_deactivated_result=mysqli_query($link, $job_deactivated)  or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
    // if(mysqli_num_rows($job_deactivated_result) > 0){
    //     $job_deactivated = 0;
    // } else {
    //     $job_deactivated = 1;
    // }
    $job_deactivated="SELECT * FROM $bai_pro3.job_deactive_log WHERE input_job_no_random in (".$job_list.") and remove_type='3'";
    // echo $job_deactivated;die();
    $job_deactivated_result=mysqli_query($link, $job_deactivated)  or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
    if(mysqli_num_rows($job_deactivated_result) == 0){
        $job_deactivated_status = 1;
    } else {
        $job_deactivated_status = 0;
    }
    
    if($job_deactivated_status == 0)
    {
    
        $get_recut_status="select max(status) as recut_status from $bai_pro3.recut_v2_child_issue_track where recut_id=".$doc_no_ref."";
        $get_recut_result=mysqli_query($link, $get_recut_status)  or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
        while($recut_row = mysqli_fetch_array($get_recut_result))
        {
            if($recut_row['recut_status']!='')
            {
                $issue_status=$recut_row['recut_status']+1;
            }
            else
            {
                $issue_status=1;
            }       
        }
        //To check whether rejection is swing category
        $category=["sewing"];
        $get_operation_id = "SELECT DISTINCT(operation_id) as operation_id FROM `$brandix_bts`.`bundle_creation_data` WHERE id IN (".implode(',',$newIds).") ORDER BY barcode_sequence";
        $get_operation_id_res = $link->query($get_operation_id);
        while($row_ops = $get_operation_id_res->fetch_assoc()) 
        {
            $operation_id[] = $row_ops['operation_id'];
        }
        $operations = implode(",",$operation_id);
        $checking_qry = "SELECT DISTINCT(category) as category FROM `$brandix_bts`.`tbl_orders_ops_ref` WHERE operation_code in ($operations)";
        // echo $checking_qry."<br>";
        $result_checking_qry = $link->query($checking_qry);
        while($row_cat = $result_checking_qry->fetch_assoc()) 
        {
            $emb_cut_check_flag = 0;
            $category_act = $row_cat['category'];
            // var_dump($category_act,"category_act<br>");
            // var_dump($category,"category<br>");
            if($category_act=='sewing'){
                 $emb_cut_check_flag = 1;
            }

                
            // if(in_array($category_act,$category))
            // {
            //     $emb_cut_check_flag = 1;
            // }
            // echo $emb_cut_check_flag."------emb_cut_check_flag<br>";

            if($emb_cut_check_flag == 1)
            {
                // echo "sewing<br>";
                foreach($issueval[$category_act] as $key=>$value)
                {
                    //retreaving remaining_qty from recut_v2_child
                    $act_id = $bcd_id[$category_act][$key];
                    $recut_allowing_qty = $issueval[$category_act][$key];
                    $retreaving_bcd_data = "SELECT * FROM `$brandix_bts`.`bundle_creation_data` WHERE id IN ($act_id) ORDER BY barcode_sequence";
                    $retreaving_bcd_data_res = $link->query($retreaving_bcd_data);
                    while($row_bcd = $retreaving_bcd_data_res->fetch_assoc()) 
                    {
                        $bcd_individual = $row_bcd['bundle_number'];
                        $bundle_number = $row_bcd['id'];
                        $operation_id = $row_bcd['operation_id'];
                        $retreaving_rej_qty = "SELECT * FROM `$bai_pro3`.`recut_v2_child` where bcd_id = $bundle_number and parent_id = '$doc_no_ref'";
                        // echo $retreaving_rej_qty;
                        $retreaving_rej_qty_res = $link->query($retreaving_rej_qty);
                        while($child_details = $retreaving_rej_qty_res->fetch_assoc()) 
                        {
                            $actual_allowing_to_recut = $child_details['recut_reported_qty']-$child_details['issued_qty'];
                        }
                        if($actual_allowing_to_recut < $recut_allowing_qty)
                        {
                            $to_add = $actual_allowing_to_recut;
                            $recut_allowing_qty = $recut_allowing_qty - $actual_allowing_to_recut;
                        }
                        else
                        {
                            $to_add = $recut_allowing_qty;
                            $recut_allowing_qty = 0;
                        }
                        
                        if($to_add > 0)
                        {
                            //updating recut_v2_child
                            $update_recut_v2_child = "update $bai_pro3.recut_v2_child set issued_qty = issued_qty+$to_add where bcd_id = $bundle_number and parent_id = $doc_no_ref";
                            mysqli_query($link, $update_recut_v2_child) or exit("update_recut_v2_child".mysqli_error($GLOBALS["___mysqli_ston"]));

                            $insert_query_track= "INSERT INTO $bai_pro3.`recut_v2_child_issue_track` (`recut_id`, `bcd_id`, `issued_qty`, `status`) VALUES ( $doc_no_ref, $bundle_number, $to_add, $issue_status)"; 
                            mysqli_query($link, $insert_query_track) or exit("Inserting_recut_v2_issue_track_table_track".mysqli_error($GLOBALS["___mysqli_ston"]));
                            
                            //updating rejection_log_child
                                $updating_rejection_log_child = "update $bai_pro3.rejection_log_child set issued_qty=issued_qty+$to_add where bcd_id = $bundle_number";
                            mysqli_query($link, $updating_rejection_log_child) or exit("updating_rejection_log_child".mysqli_error($GLOBALS["___mysqli_ston"]));

                        }
                    }
                }
                $plan_cut_bundle_qry = "SELECT * FROM $bai_pro3.plan_cut_bundle WHERE doc_no=$doc_no_ref";
                //  var_dump($plan_cut_bundle_qry,"plan_cut_bundle_qry<br>");
                $plan_cut_bundle_res = mysqli_query($link, $plan_cut_bundle_qry) or exit("Sql Error : plan_cut_bundle_qry".mysqli_error($GLOBALS["___mysqli_ston"]));
                if(mysqli_num_rows($plan_cut_bundle_res)>0) 
                {
                    // var_dump($job_no,"job_no<br>");
                    
                    foreach($job_no as $key=>$array) 
                    {
                        // var_dump($array,"array<br>");

                        $doc_no = $doc_no_ref;
                        // var_dump($size,"size<br>");

                        foreach($size as $category=>$size_array) {
                            if($category===$category_act) {
                                // var_dump($size_array,"size_array<br>");


                                $size_new = $size_array[$key];
                                $job_new = $array;
                                $plan_jobcount = $issueval[$category][$key];

                                // var_dump($size_new,"size_new<br>");
                                // var_dump($job_new,"job_new<br>");
                                // var_dump($plan_jobcount,"plan_jobcount<br>");

                                    
                                $get_schedule = "SELECT order_del_no AS SCHEDULE,acutno FROM `bai_pro3`.`plan_doc_summ` WHERE doc_no = '$doc_no'";
                                // var_dump($get_schedule,"get_schedule<br>");

                                $get_schedule_res = mysqli_query($link, $get_schedule) or exit("Sql Error : get_schedule".mysqli_error($GLOBALS["___mysqli_ston"]));
                                while($row = $get_schedule_res->fetch_assoc()) 
                                {
                                    $schedule = $row['SCHEDULE'];
                                    $cut = $row['acutno'];
                                }
                                
                                $pre_send_qty_qry = "select input_job_no,max(carton_act_qty) as bundle_qty from $bai_pro3.pac_stat_log_input_job where input_job_no_random = '$job_new' and size_code= '$size_new'";
                                // var_dump($pre_send_qty_qry,"pre_send_qty_qry<br>");

                                $result_pre_send_qty = $link->query($pre_send_qty_qry);
                                while($row = $result_pre_send_qty->fetch_assoc()) 
                                {
                                    $plan_bundleqty = $row['bundle_qty'];
                                    $job = $row['input_job_no'];
                                }
                                // var_dump($plan_bundleqty,"plan_bundleqty<br>");
                                // var_dump($job,"job<br>");

                                
                                if($plan_jobcount > 0) {

                                    //  var_dump($doc_no_ref,"doc_no_ref<br>");
                                    //  var_dump($plan_jobcount,"plan_jobcount<br>");
                                    //  var_dump($plan_bundleqty,"plan_bundleqty<br>");
                                    //  var_dump($job,"job<br>");
                                    //  var_dump($job_new,"job_new<br>");
                                    //  var_dump($schedule,"schedule<br>");
                                    //  var_dump($size_new,"size_new<br>");
                                    $plan_logical_bundles_rejection = plan_logical_bundles_recut($doc_no_ref,$plan_jobcount,$plan_bundleqty,$job,$job_new,$schedule,$size_new);
                                }
                            }
                        }
    
                    }
                    
                } else {
                    // $issue_to_sewing = issue_to_sewing($job_no,$size[$category_act],$issueval[$category_act],$doc_no_ref,$bcd_id[$category_act]);
                }
            }
            else
            {
                // echo "emb<br>";

                foreach($issueval[$category_act] as $key=>$value)
                {
                    //retreaving remaining_qty from recut_v2_child
                    $act_id = $bcd_id[$category_act][$key];
                    $recut_allowing_qty = $issueval[$category_act][$key];
                    // var_dump($recut_allowing_qty);
                    $retreaving_bcd_data = "SELECT * FROM `$brandix_bts`.`bundle_creation_data` WHERE id IN ($act_id) ORDER BY barcode_sequence";
                    // echo $retreaving_bcd_data;
                    $retreaving_bcd_data_res = $link->query($retreaving_bcd_data);
                    while($row_bcd = $retreaving_bcd_data_res->fetch_assoc()) 
                    {
                        $bcd_individual = $row_bcd['bundle_number'];
                        $bundle_number = $row_bcd['id'];
                        $operation_id = $row_bcd['operation_id'];
                        $retreaving_rej_qty = "SELECT * FROM `$bai_pro3`.`recut_v2_child` where bcd_id = $bundle_number and parent_id = '$doc_no_ref'";
                        // echo $retreaving_rej_qty;
                        $retreaving_rej_qty_res = $link->query($retreaving_rej_qty);
                        while($child_details = $retreaving_rej_qty_res->fetch_assoc()) 
                        {
                            $actual_allowing_to_recut = $child_details['recut_reported_qty']-$child_details['issued_qty'];
                        }
                        if($actual_allowing_to_recut < $recut_allowing_qty)
                        {
                            $to_add = $actual_allowing_to_recut;
                            $recut_allowing_qty = $recut_allowing_qty - $actual_allowing_to_recut;
                        }
                        else
                        {
                            $to_add = $recut_allowing_qty;
                            $recut_allowing_qty = 0;
                        }
                        
                        if($to_add > 0)
                        {
                            //updating recut_v2_child
                            $update_recut_v2_child = "update $bai_pro3.recut_v2_child set issued_qty = issued_qty+$to_add where bcd_id = $bundle_number and parent_id = $doc_no_ref";
                            mysqli_query($link, $update_recut_v2_child) or exit("update_recut_v2_child".mysqli_error($GLOBALS["___mysqli_ston"]));
        
                            $insert_query_track= "INSERT INTO $bai_pro3.`recut_v2_child_issue_track` (`recut_id`, `bcd_id`, `issued_qty`, `status`) VALUES ( $doc_no_ref, $bundle_number, $to_add, $issue_status)"; 
                            mysqli_query($link, $insert_query_track) or exit("Inserting_recut_v2_issue_track_table_track".mysqli_error($GLOBALS["___mysqli_ston"]));
                            
                            //updating rejection_log_child
                                $updating_rejection_log_child = "update $bai_pro3.rejection_log_child set issued_qty=issued_qty+$to_add where bcd_id = $bundle_number";
                            mysqli_query($link, $updating_rejection_log_child) or exit("updating_rejection_log_child".mysqli_error($GLOBALS["___mysqli_ston"]));
                            $issued_to_module = issued_to_module($bundle_number,$to_add,2);
        
                        }
                    }
                }
                
                $plan_cut_bundle_qry = "SELECT * FROM $bai_pro3.plan_cut_bundle WHERE doc_no=$doc_no_ref";
                // echo  $plan_cut_bundle_qry."<br>";
                $plan_cut_bundle_res = mysqli_query($link, $plan_cut_bundle_qry) or exit("Sql Error : plan_cut_bundle_qry".mysqli_error($GLOBALS["___mysqli_ston"]));
                if(mysqli_num_rows($plan_cut_bundle_res)>0) 
                {
                    $doc_no = $doc_no_ref;
                    $temp=0;
                    // var_dump($size,"size<br>");
                    foreach($size as $category=>$size_array) {
                        if($category===$category_act){
                                // var_dump($category,"category<br>");
                                // var_dump($size_array,"size_array<br>");

                                foreach($size_array as $key2=>$value2){
                                // var_dump($value2,"value2<br>");

                                $size_new = $size_array[$key2];
                                // var_dump($size_new,"size_new<br>");

                                $plan_jobcount = $issueval[$category][$key2];
                                // var_dump($plan_jobcount,"plan_jobcount<br>");

                                //considering same bundle max qty
                                $plan_bundleqty = $issueval[$category][$key2];
                                // var_dump($plan_bundleqty,"plan_bundleqty<br>");
    
                                if($plan_jobcount > 0) {
                                
                                    $get_schedule = "SELECT order_del_no AS SCHEDULE,acutno FROM `bai_pro3`.`plan_doc_summ` WHERE doc_no = '$doc_no'";
                                    // var_dump($get_schedule,"get_schedule<br>");
                                    $get_schedule_res = mysqli_query($link, $get_schedule) or exit("Sql Error : get_schedule".mysqli_error($GLOBALS["___mysqli_ston"]));
                                    while($row = $get_schedule_res->fetch_assoc()) 
                                    {
                                        $schedule = $row['SCHEDULE'];
                                        $cut = $row['acutno'];
                                    }
                                    
                                    // $pre_send_qty_qry = "select input_job_no,max(carton_act_qty) as bundle_qty from $bai_pro3.pac_stat_log_input_job where input_job_no_random = '$job_new' and size_code= '$size_new'";
                                    // $result_pre_send_qty = $link->query($pre_send_qty_qry);
                                    // while($row = $result_pre_send_qty->fetch_assoc()) 
                                    // {
                                    //     $plan_bundleqty = $row['bundle_qty'];
                                    // }
                                        
                                    //get input job number for each schedule
                                    if($temp==0){
                                        $old_jobs_count_qry = "SELECT MAX(CAST(input_job_no AS DECIMAL))+1 as result FROM $bai_pro3.pac_stat_log_input_job WHERE schedule='".$schedule."'";
                                        // var_dump($old_jobs_count_qry,"old_jobs_count_qry<br>");
                                        $old_jobs_count_res = mysqli_query($link, $old_jobs_count_qry) or exit("Issue while Selecting SPB".mysqli_error($GLOBALS["___mysqli_ston"]));
                                        if(mysqli_num_rows($old_jobs_count_res)>0)
                                        {
                                            while($max_oldqty_jobcount = mysqli_fetch_array($old_jobs_count_res))
                                            {
                                                if($max_oldqty_jobcount['result'] > 0) 
                                                {
                                                    $job=$max_oldqty_jobcount['result'];
                                                } 
                                                else 
                                                {
                                                    $job=1;
                                                }
                                            }
                                        } 
                                        else 
                                        {
                                            $job=1;
                                        }
                                    }
                                    
                                    $job_new=$schedule.date("ymd").$job;
                                        // var_dump($doc_no_ref,"doc_no_ref<br>");
                                        // var_dump($plan_jobcount,"plan_jobcount<br>");
                                        // var_dump($plan_bundleqty,"plan_bundleqty<br>");
                                        // var_dump($job,"job<br>");
                                        // var_dump($job_new,"job_new<br>");
                                        // var_dump($schedule,"schedule<br>");
                                        // var_dump($size_new,"size_new<br>");
                                    
                                    $plan_logical_bundles_rejection = plan_logical_bundles_recut($doc_no_ref,$plan_jobcount,$plan_bundleqty,$job,$job_new,$schedule,$size_new);
                                    $temp=1;
                                    
                                }
                            }
                        }
                    }

                }
            }
            
        }
        // die();
    
        $url = '?r='.$_GET['r'];
        echo "<script>sweetAlert('Successfully Issued','','success');window.location = '".$url."'</script>";
    }
    else 
    {
        $url = '?r='.$_GET['r'];
        echo "<script>sweetAlert('Sewing Job is Deactivated! ','Issue To Module is unsuccessfull','Error');window.location = '".$url."'</script>";  
    }
}
function issued_to_module($bcd_id,$qty,$ref)
{
    include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config_ajax.php');
    $op_code = '15';
    $bcd_colum_ref = "replace_in";
    if($ref == 2)
    {
        $bcd_colum_ref = "recut_in";
    }
    $op_code = '15';
    $bcd_qry = "select style,mapped_color,docket_number,assigned_module,input_job_no_random_ref,operation_id,bundle_number,size_id from $brandix_bts.bundle_creation_data where id = $bcd_id";
    $result_bcd_qry = $link->query($bcd_qry);
    while($row = $result_bcd_qry->fetch_assoc()) 
    {
        $style = $row['style'];
        $mapped_color = $row['mapped_color'];
        $docket_no = $row['docket_number'];
        $input_job_no_random_ref = $row['input_job_no_random_ref'];
        $ops_code = $row['operation_id'];
        $bundle_number = $row['bundle_number'];
        $size_id = $row['size_id'];
    }
    //updating cps log and bts
    $update_qry_cps = "update $bai_pro3.cps_log set remaining_qty = remaining_qty+$qty where doc_no = $docket_no and operation_code = 15 and size_code ='$size_id'";
    mysqli_query($link, $update_qry_cps) or exit("update_qry_cps".mysqli_error($GLOBALS["___mysqli_ston"]));
    // if($bcd_colum_ref=='recut_in'){
    //     $update_qry_bcd = "update $brandix_bts.bundle_creation_data set $bcd_colum_ref=$bcd_colum_ref+0 where docket_number = $docket_no and size_id = '$size_id' and operation_id = 15";
    // }else{
    // }
    $update_qry_bcd = "update $brandix_bts.bundle_creation_data set $bcd_colum_ref=$bcd_colum_ref+$qty where docket_number = $docket_no and size_id = '$size_id' and operation_id = 15";
     mysqli_query($link, $update_qry_bcd) or exit("update_qry_bcd".mysqli_error($GLOBALS["___mysqli_ston"]));
     //validate parellel operations for updating recut_in
     $qry_prellel_ops="select COUNT(*) as cnt from $brandix_bts.tbl_style_ops_master where style='$style' and color='$mapped_color' and ops_dependency>0 and operation_code=15";
     $result_qry_prellel_ops = $link->query($qry_prellel_ops);
    while($row_ops = $result_qry_prellel_ops->fetch_assoc()) 
    {
       $parellel_ops_cnt = $row_ops['cnt'];
    }

    if($parellel_ops_cnt>0){
        
        //retreaving emblishment operations from operatoin master
        $ops_master_qry = "select operation_code from $brandix_bts.tbl_orders_ops_ref where category in ('Send PF')";
    }else{

        //retreaving emblishment operations from operatoin master
		
        // $ops_seq_check = "select id,ops_sequence,operation_order from $brandix_bts.tbl_style_ops_master where style='$style' and color = '$mapped_color' and operation_code=$op_code";
        // $result_ops_seq_check = $link->query($ops_seq_check);
        // if($result_ops_seq_check->num_rows > 0)
        // {
            // while($row = $result_ops_seq_check->fetch_assoc()) 
            // {
                // $ops_seq = $row['ops_sequence'];
                // $seq_id = $row['id'];
                // $ops_order = $row['operation_order'];
            // }
        // }
        // $ops_master_qry = "select operation_code from $brandix_bts.tbl_style_ops_master where style='$style' and color = '$mapped_color' and ops_sequence = '$ops_seq'  AND CAST(operation_order AS CHAR) > '$ops_order' and operation_code not in (10,200) ORDER BY operation_order ASC LIMIT 1"; 
		$ops_master_qry = "SELECT tor.operation_code FROM brandix_bts.tbl_orders_ops_ref AS tor LEFT JOIN `brandix_bts`.`tbl_style_ops_master` AS tosm ON tor.operation_code=tosm.operation_code WHERE category = 'Send PF' AND style='$style' AND color='$mapped_color' ORDER BY CAST(tosm.operation_order AS CHAR) LIMIT 1"; 

    }
   // echo $ops_master_qry;
    $result_ops_master_qry = $link->query($ops_master_qry);
    while($row_ops = $result_ops_master_qry->fetch_assoc()) 
    {
       $emb_ops[] = $row_ops['operation_code'];
    }
    $qry_ops_mapping = "select operation_code from $brandix_bts.tbl_style_ops_master where style='$style' and color='$mapped_color' and  operation_code in (".implode(',',$emb_ops).")";
    // echo $qry_ops_mapping;
    // die();
    $result_qry_ops_mapping = $link->query($qry_ops_mapping);
    if(mysqli_num_rows($result_qry_ops_mapping) > 0)
    {
        while($row_emb = $result_qry_ops_mapping->fetch_assoc()) 
        {
            $emb_input_ops_code = $row_emb['operation_code'];
            //updating bcd for emblishment in operation 
            // if($bcd_colum_ref=='recut_in'){
            //     $update_bcd_for_emb_qry = "update $brandix_bts.bundle_creation_data set $bcd_colum_ref = $bcd_colum_ref + 0 where docket_number = $docket_no and operation_id = $emb_input_ops_code and size_id = '$size_id'";
            // }else {
            // }
            $update_bcd_for_emb_qry = "update $brandix_bts.bundle_creation_data set $bcd_colum_ref = $bcd_colum_ref + $qty where docket_number = $docket_no and operation_id = $emb_input_ops_code and size_id = '$size_id'";
            mysqli_query($link, $update_bcd_for_emb_qry) or exit("update_bcd_for_emb_qry".mysqli_error($GLOBALS["___mysqli_ston"]));

            //updating embellishment_plan_dashboard
            $update_plan_dashboard_qry = "UPDATE `$bai_pro3`.`embellishment_plan_dashboard` SET orginal_qty = orginal_qty+$qty WHERE doc_no = $docket_no AND send_op_code = $emb_input_ops_code";
            // echo $update_plan_dashboard_qry;
            mysqli_query($link, $update_plan_dashboard_qry) or exit("update_plan_dashboard_qry".mysqli_error($GLOBALS["___mysqli_ston"]));
        }
    }
    // else
    // {
        $emb_cut_check_flag = 0;
        //checking the ips having that input job or not
        $category=['cutting','Send PF','Receive PF'];
        $checking_qry = "SELECT category FROM `$brandix_bts`.`tbl_orders_ops_ref` WHERE operation_code = $ops_code";
        // echo $checking_qry;
        $result_checking_qry = $link->query($checking_qry);
        while($row_cat = $result_checking_qry->fetch_assoc()) 
        {
            $category_act = $row_cat['category'];
        }
        if(in_array($category_act,$category))
        {
            $emb_cut_check_flag = 1;
        }
        if($emb_cut_check_flag == 0)
        {
            $checking_qry_plan_dashboard = "SELECT * FROM `$bai_pro3`.`plan_dashboard_input` WHERE input_job_no_random_ref = '$input_job_no_random_ref'";
            $result_checking_qry_plan_dashboard = $link->query($checking_qry_plan_dashboard);
            if(mysqli_num_rows($result_checking_qry_plan_dashboard) == 0)
            {   
                $insert_qry_ips = "INSERT INTO `$bai_pro3`.`plan_dashboard_input` 
                SELECT * FROM `$bai_pro3`.`plan_dashboard_input_backup`
                WHERE input_job_no_random_ref = '$input_job_no_random_ref' order by input_trims_status desc limit 1";
                mysqli_query($link, $insert_qry_ips) or exit("insert_qry_ips".mysqli_error($GLOBALS["___mysqli_ston"]));
            }            
            $qry_ops_mapping_after = "SELECT of.operation_code FROM `$brandix_bts`.`tbl_style_ops_master` tm 
            LEFT JOIN brandix_bts.`tbl_orders_ops_ref` of ON of.`operation_code`=tm.`operation_code`
            WHERE tm.`style` ='$style' AND tm.`color` = '$mapped_color'
            AND category = 'sewing' AND display_operations='yes' and of.operation_code>1 ORDER BY operation_order*1 LIMIT 1";
            $result_qry_ops_mapping_after = $link->query($qry_ops_mapping_after);
            if(mysqli_num_rows($result_qry_ops_mapping_after) > 0)
            {
                while($ops_post = $result_qry_ops_mapping_after->fetch_assoc()) 
                {
                    $input_ops_code = $ops_post['operation_code'];
                }
            }
            else
            {
                $input_ops_code=echo_title("$brandix_bts.tbl_ims_ops","operation_code","appilication",'IPS',$link); 
                if($input_ops_code == 'Auto'){
					$get_ips_op = get_ips_operation_code($link,$style,$mapped_color);
					$input_ops_code=$get_ips_op['operation_code'];
				} 
            }    
            // if($bcd_colum_ref=='recut_in'){
            //     $update_qry_bcd_input = "update $brandix_bts.bundle_creation_data set $bcd_colum_ref=$bcd_colum_ref+0 where bundle_number = $bundle_number and operation_id = $input_ops_code";
            // } else {
            // }
            $update_qry_bcd_input = "update $brandix_bts.bundle_creation_data set $bcd_colum_ref=$bcd_colum_ref+$qty where bundle_number = $bundle_number and operation_id = $input_ops_code";
            mysqli_query($link, $update_qry_bcd_input) or exit("update_qry_bcd".mysqli_error($GLOBALS["___mysqli_ston"]));            
        }   
    return;
}
$shifts_array = ["IssueToModule","AlreadyIssued","WaitingForApproval","UpdateMarkers","ReportPending"];
$drp_down = '<div class="row"><div class="col-md-3"><label>Status Filter:</label>
<select class="form-control rm"  name="status" id="rm" style="width:100%;" onchange="myFunction()" required>';
for ($i=0; $i <= 4; $i++) 
{
    $drp_down .= '<option value='.$shifts_array[$i].'>'.$shifts_array[$i].'</option>';
}
$drp_down .= "</select></div>";
$drp_down = "<div class='row'><div class='col-md-3'><label>Schedule Filter:</label>
              <input class='form-control integer' placeholder='Enter Schedule here' onchange='myfunctionsearch()' id='schedule_id'></input></div></div>";
echo $drp_down;
?>
</br></br>
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog" style="width: 80%;">
        <div class="modal-content">
            <div class="modal-header">Recut Detailed View
                <button type="button" class="btn btn-danger" value="Close" id = "cancel" data-dismiss="modal" style="float: right;">Close</button>
            </div>
            <div class="modal-body" id='main-content'>
                <div class="ajax-loader" class="loading-image" style="margin-left: 45%;margin-top: 35px;border-radius: -80px;width: 88px;display:none;">
                                <img src='<?= getFullURLLevel($_GET['r'],'ajax-loader.gif',0,'R'); ?>' class="img-responsive" />
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="myModal1" role="dialog">
    <div class="modal-dialog" style="width: 80%;  height: 100%;">
        <div class="modal-content">
            <div class="modal-header">Markers Update Form
                <button type="button" class="btn btn-danger" value="Close" id = "cancel" data-dismiss="modal" style="float: right;">Close</button>
            </div>
            <div class="modal-body">
                <form action="index.php?r=<?php echo $_GET['r']?>" name= "smartform" method="post" id="smartform" onsubmit='return validationfunction();'>
                    <div id='pre'>
                        <div class='panel-body' id="dynamic_table_panel">
                            <div class="ajax-loader" class="loading-image" style="margin-left: 45%;margin-top: 35px;border-radius: -80px;width: 88px;display:none;">
                                <img src='<?= getFullURLLevel($_GET['r'],'ajax-loader.gif',0,'R'); ?>' class="img-responsive" />
                            </div>  
                                <div id ="dynamic_table1"></div>
                        </div>
                        <p style='color:red;'>Note:The excess quantity will create as excess sewing job for respective style,schedule and color.</p>
                        <div class="pull-right"><input type="submit" id='markers' class="btn btn-primary" value="Submit" name="formSubmit"></div>
                    </div>
                </form>
                <div id='post'>
                        <div class='panel-body'>    
                             <b style='color:red'>Please wait while Updating Markers!!!</b>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="myModal2" role="dialog">
    <div class="modal-dialog" style="width: 80%;  height: 100%;">
        <div class="modal-content">
            <div class="modal-header">Issuing to Module Form
                <button type="button" class="btn btn-danger" value="Close" id = "cancel" data-dismiss="modal" style="float: right;">Close</button>
            </div>
            <div class="modal-body">
                <form action="index.php?r=<?php echo $_GET['r']?>" name= "smartform" method="post" id="smartform" onsubmit='return validationfunctionissue();'>
                    <div id='pre_pre'>
                        <div class='panel-body' id="dynamic_table_panel">
                            <div class="ajax-loader" class="loading-image" style="margin-left: 45%;margin-top: 35px;border-radius: -80px;width: 88px;display:none;">
                                <img src='<?= getFullURLLevel($_GET['r'],'ajax-loader.gif',0,'R'); ?>' class="img-responsive" />
                            </div>  
                                <div id ="dynamic_table2"></div>
                        </div>
                        <div class="pull-right"><input type="submit" class="btn btn-primary" value="Submit" name="formIssue"></div>
                    </div>
                    <div id='post_post'>
                        <div class='panel-body'>    
                             <b style='color:red'>Please wait while Issuing To Module!!!</b>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class='row'>
    <div class='panel panel-primary'>
        <div class='panel-heading'>
            <b>ReCut Dashboard</b>
        </div>
        <div class='panel-body'>
            <?php
           $main_table = "<table class = 'col-sm-12 table-bordered table-striped table-condensed' id='myTable'><thead><th>S.No</th><th>Recut Docket Number</th><th>Style</th><th>Schedule</th><th>Color</th><th>Category</th><th>Rejected quantity</th><th>Recut Raised Quantity</th><th>Recut Reported Quantity</th><th>Issued Quantity</th><th>Remaining Quantity</th><th>View</th><th>Issue</th>
            </thead>";
           
            $s_no = 1;
            // $blocks_query  = "SELECT SUM(rejected_qty)as rejected_qty,parent_id as doc_no,SUM(recut_qty)as recut_qty,SUM(recut_reported_qty) as recut_reported_qty,SUM(issued_qty)as issued_qty,r.`mk_ref`,b.`order_style_no` AS style,b.`order_col_des` AS color,b.`order_del_no` as schedule,fabric_status
            // FROM `$bai_pro3`.`recut_v2_child` rc 
            // LEFT JOIN $bai_pro3.`recut_v2` r ON r.doc_no = rc.`parent_id`
            // LEFT JOIN $bai_pro3.`bai_orders_db` b ON b.order_tid = r.`order_tid`
            // WHERE remarks in ($in_categories)
            // GROUP BY parent_id having (recut_qty-issued_qty)>0";
            $blocks_query  = "SELECT SUM(rejected_qty)as rejected_qty,parent_id as doc_no,SUM(recut_qty)as recut_qty,SUM(recut_reported_qty) as recut_reported_qty,SUM(issued_qty)as issued_qty,r.`mk_ref`,b.`order_style_no` AS style,b.`order_col_des` AS color,b.`order_del_no` as schedule,fabric_status,remarks as category
            FROM `$bai_pro3`.`recut_v2_child` rc 
            LEFT JOIN $bai_pro3.`recut_v2` r ON r.doc_no = rc.`parent_id`
            LEFT JOIN $bai_pro3.`bai_orders_db` b ON b.order_tid = r.`order_tid`
            WHERE r.short_shipment_status=0
            GROUP BY parent_id having (recut_qty-issued_qty)>0";
            // echo $blocks_query;
            $blocks_result = mysqli_query($link,$blocks_query) or exit('Rejections Log Data Retreival Error');
            if($blocks_result->num_rows > 0)
            {
                while($row = mysqli_fetch_array($blocks_result))
                {
                    $id = $row['doc_no'];
                ?>
                    <div class="modal fade" id="rejections_modal<?= $id;?>" role="dialog">
                    <div class="modal-dialog" style="width: 80%;  height: 100%;">
                        <div class="modal-content">
                            <div class="modal-header">Change Marker Length
                                <button type="button" class="btn btn-danger" value="Close" id = "cancel" data-dismiss="modal" style="float: right;">Close</button>
                            </div>
                            <div class="modal-body">
                                <div class='panel panel-primary'>
                                    <div class='panel-heading'>
                                        Marker Length Details
                                    </div>
                                    <div class='panel-body'>
                                    <div class='col-sm-12'>
                                            <table class='table table-bordered rejections_table' id='mark_len_table<?=$id?>'>
                                            <thead>
                                                <tr class='.bg-dark'><th></th><th>Marker Type</th><th>Marker Version</th><th>Shrinkage Group</th><th>Width</th><th>Marker Length</th><th>Marker Name</th><th>Pattern Name</th><th>Marker Eff.</th><th>Perimeters</th><th>Remarks 1</th><th>Remarks 2</th><th>Remarks 3</th><th>Remarks 4</th><th>Control</th></tr>
                                            </thead>
                                                <tbody id='rejections_table_body<?=$id?>'>
                                                <?php 
                                                    
                                                    $doc_no = $id;									
                                                    $sql11x132="select allocate_ref,mk_ref_id,mk_ref from $bai_pro3.plandoc_stat_log where doc_no=".$doc_no.";";
                                                    $sql_result11x112=mysqli_query($link, $sql11x132) or die("Error16 = ".mysqli_error($GLOBALS["___mysqli_ston"]));
                                                    $rows=0;
                                                    
                                                    while($row111x2=mysqli_fetch_array($sql_result11x112)) 
                                                    {
                                                        $mk_ref_id=$row111x2['mk_ref_id'];
                                                        $sql_marker_details = "select * from $bai_pro3.maker_details where parent_id='".$row111x2['allocate_ref']."'";
                                                        $sql_marker_details_result=mysqli_query($link, $sql_marker_details) or die("Error17 = ".mysqli_error($GLOBALS["___mysqli_ston"]));
                                                        $values_rows=mysqli_num_rows($sql_marker_details_result);
                                                        echo "<input type='hidden' name='rows_val' id='rows_val' value='$values_rows' >";
                                                        while($sql_marker_details_res=mysqli_fetch_array($sql_marker_details_result))
                                                        {   
                                                            // var_dump($sql_marker_details_res[id]);
                                                            // var_dump($mk_ref_id);
                                                            $rows++;
                                                            if($sql_marker_details_res[id] == $mk_ref_id)
                                                            {
                                                                echo "<input type='hidden' name='first_val' id='first_val".$doc_no."' value='$mk_ref_id' >";
                                                                echo "<input type='hidden' name='all_ref' id='all_ref".$doc_no."' value=".$row111x2['allocate_ref']." >";
                                                                echo "<input type='hidden' name='mk_ref' id='mk_ref".$doc_no."' value=".$row111x2['mk_ref']." >";
                                                                echo "<input type='hidden' name='doc_no' id='doc_no' value='$doc_no' >";
                                                                echo "<tr><td style='display:none;' class='checked_value' id='checked$sql_marker_details_res[0]'>yes</td>
                                                                <td style='display:none;'  id='id'>$sql_marker_details_res[id]</td>
                                                                <td style='display:none;'  id='doc_no'>$doc_no</td>
                                                                <td style='display:none;'  id='all_ref".$doc_no."'>".$row111x2['allocate_ref']."</td>
                                                                <td style='display:none;'  id='mk_ref".$doc_no."'>".$row111x2['mk_ref']."</td>
                                                                <td><input type='radio' name='selected_len$doc_no' value='".$sql_marker_details_res[0]."' onchange = valid_button($sql_marker_details_res[0]) id='check$sql_marker_details_res[0]' CHECKED></td>
                                                                
                                                                <td>$sql_marker_details_res[marker_type]</td><td>$sql_marker_details_res[marker_version]</td><td>$sql_marker_details_res[shrinkage_group]</td><td>$sql_marker_details_res[width]</td><td>$sql_marker_details_res[marker_length]</td><td>$sql_marker_details_res[marker_name]</td><td>$sql_marker_details_res[pattern_name]</td><td>$sql_marker_details_res[marker_eff]</td><td>$sql_marker_details_res[perimeters]</td><td>$sql_marker_details_res[remarks1]</td><td>$sql_marker_details_res[remarks2]</td><td>$sql_marker_details_res[remarks3]</td><td>$sql_marker_details_res[remarks4]</td><td style='display:none;'>1</td>	
                                                                <td>Can't Delete</td>
                                                                </tr>";
                                                            }
                                                            else
                                                            {
                                                                echo "<input type='hidden' name='first_val' id='first_val".$doc_no."' value='$mk_ref_id' >";
                                                                echo "<input type='hidden' name='all_ref' id='all_ref".$doc_no."' value=".$row111x2['allocate_ref']." >";
                                                                echo "<input type='hidden' name='mk_ref' id='mk_ref".$doc_no."' value=".$row111x2['mk_ref']." >";
                                                                echo "<input type='hidden' name='doc_no' id='doc_no' value='$doc_no' >";
                                                                echo "<tr><td style='display:none;' class='checked_value' id='checked$sql_marker_details_res[id]'>no</td>
                                                                <td style='display:none;'  id='id'>$sql_marker_details_res[id]</td>
                                                                <td style='display:none;'  id='doc_no'>$doc_no</td>
                                                                <td style='display:none;'  id='all_ref".$doc_no."'>".$row111x2['allocate_ref']."</td>
                                                                <td style='display:none;'  id='mk_ref".$doc_no."'>".$row111x2['mk_ref']."</td>
                                                                <td><input type='radio' name='selected_len$doc_no' value='".$sql_marker_details_res[0]."' onchange = valid_button($sql_marker_details_res[id]) id='check$sql_marker_details_res[0]'></td>
                                                                
                                                                <td>$sql_marker_details_res[marker_type]</td><td>$sql_marker_details_res[marker_version]</td><td>$sql_marker_details_res[shrinkage_group]</td><td>$sql_marker_details_res[width]</td><td>$sql_marker_details_res[marker_length]</td><td>$sql_marker_details_res[marker_name]</td><td>$sql_marker_details_res[pattern_name]</td><td>$sql_marker_details_res[marker_eff]</td><td>$sql_marker_details_res[perimeters]</td><td>$sql_marker_details_res[remarks1]</td><td>$sql_marker_details_res[remarks2]</td><td>$sql_marker_details_res[remarks3]</td><td>$sql_marker_details_res[remarks4]</td><td style='display:none;'>1</td><td>Can't Delete</td></tr>";
                                                            }												
                                                        }										
                                                    }
                                                    ?>
                                                </tbody>

                                                <tbody id='rejections_table'>
                                                
                                                <tr>
                                                    <td></td>
                                                    <?php
                                                    echo "<input type='hidden' name='doc_no_new' id='doc_no_new' value='$id' >";
                                                    ?>
                                                    <td><input class="form-control alpha"  type="text" name="in_mktype" id="mk_type<?=$doc_no ?>"></td>
                                                    <td><input class="form-control alpha"  type="text" name= "in_mkver" id= "mk_ver<?=$doc_no ?>" onchange="validate_data(<?=$doc_no ?>, this)"></td>
                                                    <td><input class="form-control alpha"  type="text" name= "in_skgrp" id= "sk_grp<?=$doc_no ?>" onchange="validate_data(<?=$doc_no ?>, this)"></td>
                                                    <td><input class="form-control float"  type="text" name= "in_width" id= "width<?=$doc_no ?>" onchange="validate_data(<?=$doc_no ?>, this)"></td>
                                                    <td><input class="form-control float"  type="text" name= "in_mklen" id= "mk_len<?=$doc_no ?>" onchange="validate_data(<?=$doc_no ?>, this)"></td>
                                                    <td><input class="form-control alpha"  type="text" name= "in_mkname" id="mk_name<?=$doc_no ?>" onchange="marker_validation(<?=$doc_no ?>, this)"    ></td>
                                                    <td><input class="form-control alpha"  type="text" name= "in_ptrname" id="ptr_name<?=$doc_no ?>"></td>
                                                    <td><input class="form-control float"  type="text" name= "in_mkeff" id= "mk_eff<?=$doc_no ?>"></td>
                                                    <td><input class="form-control alpha"  type="text" name= "in_permts" id= "permts<?=$doc_no ?>"></td>
                                                    <td><input class="form-control alpha"  type="text" name= "in_rmks1" id= "rmks1<?=$doc_no ?>"></td>
                                                    <td><input class="form-control alpha"  type="text" name= "in_rmks2" id= "rmks2<?=$doc_no ?>"></td>
                                                    <td><input class="form-control alpha"  type="text" name= "in_rmks3" id= "rmks3<?=$doc_no ?>"></td>
                                                    <td><input class="form-control alpha"  type="text" name= "in_rmks4" id= "rmks4<?=$doc_no ?>"></td>
                                                    <td></td>
                                                    </tr>  
                                                </tbody>
                                            </table>
                                                <input type='button' class='btn btn-danger pull-right' value='clear' name='clear_rejection' id='clear_rejection' onclick='clear_row(<?=$doc_no ?>)'>
                                                <?php 
                                                    echo "<input type='button' class='btn btn-warning pull-right' value='Add' name='add_mklen' onclick = 'add_Newmklen(".$doc_no.")' id='add_marker_length'>";
                                                ?>
                                    <br>
                                    <?php
                                    echo "<input type='button' class='btn btn-success pull-left' value='Submit' name='submit' onclick=submit_mklen(".$doc_no.")  id='submit_length'>";
                                    ?>

                                    </div>

                                </div>
                                </div>
                                    
                                
                            </div>

                        </div>
                    </div>
                </div>
                <?php
                    
                    //chekcing this docket planned or not
                    $dock_checking_flag = 0;
                    $checking_docket_planned_qry = "SELECT * FROM `$bai_pro3`.`cutting_table_plan` WHERE doc_no = $id";
                    $result_checking_docket_planned_qry = $link->query($checking_docket_planned_qry);
                    if($result_checking_docket_planned_qry->num_rows > 0)
                    {
                        $dock_checking_flag = 1;
                    }
                    $rem_qty = $row['recut_reported_qty'] - $row['issued_qty'];

                    if($row['fabric_status'] == '98' && $row['mk_ref'] == '0')
                    {
                        $sql11x132112="select allocate_ref,mk_ref_id from $bai_pro3.plandoc_stat_log where doc_no=".$id.";";
                        $sql_result11x1121=mysqli_query($link, $sql11x132112) or die("Error14 = ".mysqli_error($GLOBALS["___mysqli_ston"]));
                        while($row111x21=mysqli_fetch_array($sql_result11x1121)) 
                        {				//$rows=0;
                            if($row111x21['mk_ref_id']>0)
                            {
                                $button_html = "<button type='button' style='border-color: #f4d142;border-width: 4px;' class='btn btn-danger' onclick='test(".$id.")'>Markers Rejected</button>";
                            } else {

                                $button_html = "<button type='button' style='border-color: #f4d142;border-width: 4px;' class='btn btn-danger' onclick='editmarkers(".$id.")'>Markers Rejected</button>";
                            }
                        }
                        $html_hiding = "MarkersRejected";
                    }
                    else if($row['mk_ref'] == '0')
                    {
                        $button_html = "<button type='button'class='btn btn-danger' onclick='editmarkers(".$id.")'>Update Markers</button>";
                        $html_hiding = "UpdateMarkers";
                    }
                    else if($row['fabric_status'] == '0')
                    {
                        $button_html = "Markers updated and Waiting for Approval";
                        $html_hiding = "WaitingForApproval";
                    }
                    else if($row['fabric_status'] == '99' && $dock_checking_flag == 0)
                    {
                        $button_html = "<b style='color:blue;'>Approved and Planning Pending!!!</b>";
                        $html_hiding = "Planning Pending";
                    }
                    else if($row['recut_reported_qty'] <= 0)
                    {
                        $button_html = "<b style='color:red;'>Report Pending!!!</b>";
                        $html_hiding = "ReportPending";
                    }
                    else if($rem_qty == 0)
                    {
                        $button_html = "<b style='color:red;'>Already issued</b>";
                        $html_hiding = "AlreadyIssued";
                    }
                    else
                    {
                        $button_html = "<button type='button'class='btn btn-danger' onclick='issuemodule(".$id.")'>Issue To Module</button>";
                      
                        $html_hiding = "IssueToModule";
                    }
					if($html_hiding == "ReportPending" || $html_hiding == "Planning Pending")
					{
						if(strtolower($row['category'])=='body' or strtolower($row['front']))
						{
							$main_table.= "<tr><td>$s_no</td>";
							$main_table.= "<td>".$row['doc_no']."</td>";
							$main_table.= "<td>".$row['style']."</td>";
							$main_table.= "<td>".$row['schedule']."</td>";
							$main_table.= "<td>".$row['color']."</td>";
							$main_table.= "<td>".$row['category']."</td>";
							$main_table.= "<td>".$row['rejected_qty']."</td>";
							$main_table.= "<td>".$row['recut_qty']."</td>";
							$main_table.= "<td>".$row['recut_reported_qty']."</td>";
							$main_table.= "<td>".$row['issued_qty']."</td>";
							$main_table.= "<td>".$rem_qty."</td>";
							$main_table.= "<td><button type='button'class='btn btn-primary' onclick='viewrecutdetails(".$id.")'>View</button></td>";
							$main_table.= "<td style='display:none'>$html_hiding</td>"; 
							$main_table.= "<td>$button_html</td>"; 
							$main_table.= "</tr>";
							$s_no++;
						}
					}
					else
					{
						$main_table.= "<tr><td>$s_no</td>";
						$main_table.= "<td>".$row['doc_no']."</td>";
						$main_table.= "<td>".$row['style']."</td>";
						$main_table.= "<td>".$row['schedule']."</td>";
						$main_table.= "<td>".$row['color']."</td>";
						$main_table.= "<td>".$row['category']."</td>";
						$main_table.= "<td>".$row['rejected_qty']."</td>";
						$main_table.= "<td>".$row['recut_qty']."</td>";
						$main_table.= "<td>".$row['recut_reported_qty']."</td>";
						$main_table.= "<td>".$row['issued_qty']."</td>";
						$main_table.= "<td>".$rem_qty."</td>";
						$main_table.= "<td><button type='button'class='btn btn-primary' onclick='viewrecutdetails(".$id.")'>View</button></td>";
						$main_table.= "<td style='display:none'>$html_hiding</td>"; 
						$main_table.= "<td>$button_html</td>"; 
						$main_table.= "</tr>";
						$s_no++;
					}
                }

            }
            else
            {
                $main_table.= "<tr><td colspan='12' style='color:red;text-align: center;'><b>No Details Found!!!</b></td></tr>";
            }
            $main_table.= "</table>";
            echo $main_table;
            ?>
             <div id='myTable1'>
                <b style='color:red'>No Records Found</b>
             </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() 
{
    $('#myTable1').hide();
    $('#post').hide();
    $('#post_post').hide();
    // myFunction();
});
function viewrecutdetails(id)
{
    var function_text = "<?php echo getFullURL($_GET['r'],'functions_recut.php','R'); ?>";
    $('.loading-image').show();
    $('#myModal').modal('toggle');
    $.ajax({

            type: "POST",
            url: function_text+"?recut_doc_id="+id,
            //dataType: "json",
            success: function (response) 
            {
                document.getElementById('main-content').innerHTML = response;
                $('.loading-image').hide();
            }

    });

}
function editmarkers(id)
{
    var function_text = "<?php echo getFullURL($_GET['r'],'functions_recut.php','R'); ?>";
    $('#myModal1').modal('toggle');
    $('.loading-image').show();
    document.getElementById('dynamic_table1').innerHTML = '';
    document.getElementById('dynamic_table2').innerHTML = '';
    $.ajax({

            type: "POST",
            url: function_text+"?markers_update_doc_id="+id,
            //dataType: "json",
            success: function (response) 
            {
                document.getElementById('dynamic_table1').innerHTML = response;
                $('.loading-image').hide();
            }

    });

}

function test(doc_no){
	
	$("#rejections_modal"+doc_no).modal('toggle');
	
}
function valid_button(row_num)
{
	$('.checked_value').text('no');
	$('#checked'+row_num).text('yes');
}
function compareArrays(arr1, arr2){

	arr1 = $.trim(arr1);
	arr2 = $.trim(arr2);

	if(arr1.toString() == arr2.toString()){
		return true;
	}else{
		return false;
	}
}

function marker_validation(id_name, cur_element) 
{
	if($("#mk_name"+id_name).val() != ''){
	var array = [];
	var CurData=[];
	$('#mark_len_table'+id_name+' tr').has('td').each(function() {
		var arrayItem = [];
		$('td', $(this)).each(function(index, item) {
			arrayItem[index] = $(item).text();
		});
		array.push(arrayItem);
	});
	CurData = [$("#mk_name"+id_name).val()];
		var table = $('#mark_len_table'+id_name);
		var tr_length= table.find('tr').length;
		for($i=0; $i<tr_length - 1; $i++)
		{
			rowData = [array[$i][11]];
            
			if(compareArrays(CurData, rowData)){
				swal('Marker Name Already exists','Please Check.','warning');
				$("#"+cur_element.id).val('');
				return true;
			}
		}
	}
}

function validate_data(id_name, cur_element) 
{
	// console.log(id_name);
	
	if($("#mk_ver"+id_name).val() != '' && $("#sk_grp"+id_name).val() != '' && $("#width"+id_name).val() != '' && $("#mk_len"+id_name).val()){
	var array = [];
	var CurData=[];
	// console.log($('#mark_len_table'+id_name+' tr'));
	$('#mark_len_table'+id_name+' tr').has('td').each(function() {
		var arrayItem = [];
		$('td', $(this)).each(function(index, item) {
			// console.log($(item).text());
			// console.log($(item).val());
			arrayItem[index] = $(item).text();
		});
		array.push(arrayItem);
	});
	CurData = [$("#mk_ver"+id_name).val(), $("#sk_grp"+id_name).val(), $("#width"+id_name).val(), Math.round($("#mk_len"+id_name).val())];
		var table = $('#mark_len_table'+id_name);
		var tr_length= table.find('tr').length;
	

		for($i=0; $i<tr_length - 1; $i++)
		{
			rowData = [array[$i][7], array[$i][8], array[$i][9], Math.round(array[$i][10])];
			console.log(CurData);
			console.log(rowData);
			// if(compareArrays(CurData, rowData)){
			// 	swal('Marker Name Must be Unique','','error');
			// 	$("#"+cur_element.id).val('');
			// 	return true;
			// }
			if(compareArrays(CurData, rowData)){
				swal('Using Same combinations...','Please Check.','warning');
				$("#"+cur_element.id).val('');
				return true;
			}
		}

	}
	// else {
	// 	sweetAlert('Marker Type/Marker Version/Shrinkage Group/Width/Marker Length are mandatory','','warning');
	// }
}
function add_Newmklen(doc_no)
{	
	var mk_type = $('#mk_type'+doc_no).val();
	var mk_ver = $('#mk_ver'+doc_no).val();
	var sk_grp = $('#sk_grp'+doc_no).val();
	var width = $('#width'+doc_no).val();
	var mk_len = $('#mk_len'+doc_no).val();
	var mk_name = $('#mk_name'+doc_no).val();
	var ptr_name = $('#ptr_name'+doc_no).val();
	var mk_eff = $('#mk_eff'+doc_no).val();
	var permts = $('#permts'+doc_no).val();
	var rmks1 = $('#rmks1'+doc_no).val();
	var rmks2 = $('#rmks2'+doc_no).val();
	var rmks3 = $('#rmks3'+doc_no).val();
	var rmks4 = $('#rmks4'+doc_no).val();
	var values_rows1 = $('#first_val').val();
	var all_refs = $('#all_ref'+doc_no).val();
	var doc_nos = doc_no;
	var doc_no_new = doc_no;
	// alert(doc_nos);
	// $('#doc_no_new').val(doc_nos);
	var mk_refs = $('#mk_ref'+doc_no).val();
	var rows_valu = parseInt($('#rows_val').val())+1;
	//alert(values_rows1)
	//$('#rows_val').val(rows_valu);
	$('.checked_value').text('no');
	//$('#checked'+values_rows1).text('no');
	
	

	if(mk_ver == ''){
		sweetAlert('Please enter valid Marker Version','','warning');
		return false;
	}
	// if(mk_eff == ''){
	// 	sweetAlert('Please enter valid Marker Eff','','warning');
	// 	return false;
	// }
	if(mk_len <=0)
	{
		sweetAlert('Please enter valid Marker Length','','warning');
		return false;
	}
	if(width <=0){
		sweetAlert('Please enter valid Marker Width','','warning');
		return false;
	}
	if(mk_len == ''|| mk_len <=0){
		sweetAlert('Please enter valid Marker Length','','warning');
		return false;
	}
	if(mk_eff == '')
	{
		mk_eff = 0;
	}
	if(mk_eff>100){
		sweetAlert('Please enter valid Marker Efficiency','','warning');
		return false;
	}
	if(mk_ver <=0 || mk_ver ==''){
		sweetAlert('Please enter valid Marker Version','','warning');
		return false;
	}
	var table_body = $("#rejections_table_body"+doc_no);
	var new_row = "<tr id='unique_d_"+doc_no+"_r_"+rows_valu+"'><td style='display:none;' class='checked_value' id='checked"+values_rows1+"'>yes</td><td style='display:none;' id='id'>"+rows_valu+"</td><td style='display:none;' id='doc_no' >"+doc_no_new+"</td><td style='display:none;'  id='all_ref'>"+all_refs+"</td><td style='display:none;'  id='mk_ref'>"+mk_refs+"</td><td><input type='radio' name='selected_len"+doc_no+"' value="+rows_valu+" id='check"+rows_valu+"' onchange = valid_button("+rows_valu+") CHECKED></td><td>"+mk_type+"</td><td>"+mk_ver+"</td><td>"+sk_grp+"</td><td>"+width+"</td><td>"+mk_len+"</td><td>"+mk_name+"</td><td>"+ptr_name+"</td><td>"+permts+"</td><td>"+mk_eff+"</td><td>"+rmks1+"</td><td>"+rmks2+"</td><td>"+rmks3+"</td><td>"+rmks4+"</td><td style='display:none;'>0</td><td><input type='button' style='display : block' class='btn btn-sm btn-danger' id=delete_row"+rows_valu+" onclick=delete_row("+rows_valu+","+doc_no+") value='Delete'></td></tr>";
	
	// $('#delete_row'+rows_valu).on('click',function(){
	// alert(rows_valu);
      	
    // });

	$("#rejections_table_body"+doc_no).append(new_row);
	$('#mk_type'+doc_no).val(' ');
	$('#mk_ver'+doc_no).val(' ');
	$('#sk_grp'+doc_no).val(' ');
	$('#width'+doc_no).val(' ');
	$('#mk_len'+doc_no).val(' ');
	$('#mk_name'+doc_no).val(' ');
	$('#ptr_name'+doc_no).val(' ');
	$('#mk_eff'+doc_no).val(' ');
	$('#permts'+doc_no).val(' ');
	$('#rmks1'+doc_no).val(' ');
	$('#rmks2'+doc_no).val(' ');
	$('#rmks3'+doc_no).val(' ');
	$('#rmks4'+doc_no).val(' ');
}

function delete_row(rows_valu,doc_no){
	
	$("#rejections_table_body"+doc_no+" tr#unique_d_"+doc_no+"_r_"+rows_valu).remove();
	var values_rows1 = $("#first_val"+doc_no+"").val();
	
	$('.checked_value').text('no');
	$('#checked'+values_rows1).text('yes');
	$('#check'+values_rows1).prop('checked', true);
}
function clear_row(doc_no)
{
	$('#mk_type'+doc_no).val(' ');
	$('#mk_ver'+doc_no).val(' ');
	$('#sk_grp'+doc_no).val(' ');
	$('#width'+doc_no).val(' ');
	$('#mk_len'+doc_no).val(' ');
	$('#mk_name'+doc_no).val(' ');
	$('#ptr_name'+doc_no).val(' ');
	$('#mk_eff'+doc_no).val(' ');
	$('#permts'+doc_no).val(' ');
	$('#rmks1'+doc_no).val(' ');
	$('#rmks2'+doc_no).val(' ');
	$('#rmks3'+doc_no).val(' ');
	$('#rmks4'+doc_no).val(' ');
}
function submit_mklen(doc_no)
{
	var tabledata = [];
	$('#mark_len_table'+doc_no+' tr').has('td').each(function() {
		var tabledataItem = [];
		$('td', $(this)).each(function(index, item) {
			
			// console.log(index,$(item));
			tabledataItem[index] = $(item).text();
			// console.log(index);
		});
		tabledata.push(tabledataItem);
		// console.log(tabledata);
	});

	var jsonString = JSON.stringify(tabledata);
    console.log(jsonString);
	$.ajax({
	type : "POST",
	url : '<?= $get_url1 ?>',
	data: {data : jsonString,doc_no:doc_no}, 
	}).success(function(response){
		//console.log(response);
		//var check_val = response.status_no;
		var data = jQuery.parseJSON(response);
		var p1 = data.status_no;
		//console.log(p1);
		
		if(p1 == 1)
		{
			swal('Success',data.status,'success');
		}
		else if(p1 == 2)
		{
			swal('Success',data.status_new,'success');
		}
		else
		{
			swal('error','Something Went Wrong Please try again..!','error');	
		}	
		//swal('Success','Marker Details Updated successfully','success');
		location.reload();	
	});
}
function issuemodule(id)
{
    var function_text = "<?php echo getFullURL($_GET['r'],'functions_recut.php','R'); ?>";
    $('#myModal2').modal('toggle');
    $('#pre_pre').show();
    $('#post_post').hide();
    $('.loading-image').show();
    document.getElementById('dynamic_table1').innerHTML = '';
    document.getElementById('dynamic_table2').innerHTML = '';
    $.ajax({

            type: "POST",
            url: function_text+"?issued_to_module_process="+id,
            //dataType: "json",
            success: function (response) 
            {
                document.getElementById('dynamic_table2').innerHTML = response;
                $('.loading-image').hide();

            }

    });
}
function validatingremaining(sno)
{
    var remaining_qty_var = sno+"rems";
    var rem_qty = Number(document.getElementById(remaining_qty_var).innerHTML);
    var issuing_qty = Number(document.getElementById(sno).value);
    if(Number(rem_qty) < Number(issuing_qty))
    {
        swal('You are Issuing More than remaining quantity.','','error');
        document.getElementById(sno).value = 0;
    }
}
function myFunction() 
{
    var input, filter, table, tr, td, i;
    input = document.getElementById("rm").value;
    filter = input.toUpperCase();
    table = document.getElementById("myTable");
    tr = table.getElementsByTagName("tr");
    var count = 0;
    if(tr.length > 1)
    {
        for (i = 1; i < tr.length; i++) 
        {
            td = tr[i].getElementsByTagName("td")[11];
            if(td) 
            {
                if(td.innerHTML.toUpperCase() == filter)
                {
                    tr[i].style.display = "";
                } 
                else 
                {
                    count++;
                    tr[i].style.display = "none";
                }
            }
        }
    }
    // if(count == 1)
    // {
    //     $('#myTable').hide();
    //     $('#myTable1').show();
    // }
    // else
    // {
    //     $('#myTable').show();
    //     $('#myTable1').hide();
    // }
}
function isintegervalidation() 
{
    var data = document.getElementById('a_plies').value;
    if(isInteger(data))
    {

    }
    else
    {  
        document.getElementById('a_plies').value = 0;
    }
}
function isInteger(value) 
{
    if ((undefined === value) || (null === value))
    {
        return false;
    }
    return value % 1 == 0;
}
function isintegervallidation(id)
{
    var data = document.getElementById(id).value;
    if(isInteger(data))
    {

    }
    else
    {  
        document.getElementById(id).value = 0;
    }
}
function validationfunction()
{
    var flag = 0;
    var value = 0;
    var check= 0;
    var mklen = document.getElementById('mklen').value;
    var a_plies =  document.getElementById('a_plies').value;
    var total_rows = document.getElementById('no_of_rows').value;
    if(mklen == '' || mklen == 0)
    {
        swal('Please enter marker length.','','error');
        flag = 1;
    }
    else if(a_plies == '' || a_plies == 0)
    {
        swal('Please enter actual plies.','','error');
        flag = 1;
    }
    else
    {
        for(var i=1; i<=total_rows;i++)
        {
            value = value + Number(document.getElementById(i).value);
            if((Number(document.getElementById(i).value)*a_plies)<Number(document.getElementById('dat_'+i).value))
            {
                check = 1;
            }
        }
        if(value == 0)
        {
            swal('Atlease one ratio should be there.','','error');
            flag = 1;
        }
        if(check == 1)
        {
            swal('(Ratio * Plies) should be equal or more than requested Quantity per size.','','error');
            flag = 1;
        }
    }
    if(flag == 0)
    {
        $('#markers').hide();
        $('#pre').hide();
        $('#post').show();
        return true;
    }
    else
    {
        return false;
    }
}
function isInteger(value) 
{
    if ((undefined === value) || (null === value))
    {
        return false;
    }
    return value % 1 == 0;
}
function setfunction()
{
    var noofrows = $('#no_of_rows').val();
    if(document.getElementById('setreset').value == 'Set')
    {
        for(var i=1; i<=Number(noofrows); i++)
        {
            var rem_var = i+'rems';
            console.log(rem_var);
            var remaining_qty = document.getElementById(rem_var).innerHTML;
            document.getElementById(i).value = remaining_qty; 
        }
    }
}
function resetfunction()
{
    var noofrows = $('#no_of_rows').val();
    for(var i=1; i<=Number(noofrows); i++)
    {
        document.getElementById(i).value = 0; 
    }
}
function validationfunctionissue()
{
    var flag = 0;
    var value = 0;
    var total_rows = document.getElementById('no_of_rows').value;
    for(var i=1; i<=total_rows;i++)
    {
        value = value + Number(document.getElementById(i).value);
    }
    if(value == 0)
    {
        swal('Atlease one size quantity should be there.','','error');
        flag = 1;
    }
    if(flag == 0)
    {
        $('#pre_pre').hide();
        $('#post_post').show();
        return true;
    }
    else
    {
        return false;
    }
}
function focus_validate(id)
{
    var data = document.getElementById(id).value;
    if(data == 0)
    {
        document.getElementById(id).value = '';
    }
}
function focus_out_validation(id)
{
    var data = document.getElementById(id).value;
    if(data == '')
    {
        document.getElementById(id).value = 0;
    }
}
function myfunctionsearch() 
{
    var input, filter, table, tr, td, i;
    input = document.getElementById("schedule_id").value;
    filter = input.toUpperCase();
    table = document.getElementById("myTable");
    tr = table.getElementsByTagName("tr");
    var count = 0;
    if(tr.length > 1)
    {
        for (i = 1; i < tr.length; i++) 
        {
            td = tr[i].getElementsByTagName("td")[3];
            if(td) 
            {
                console.log("input"+input);
                console.log(td.innerHTML.toUpperCase());
                console.log(filter);
                if(td.innerHTML.toUpperCase() == filter)
                {
                    console.log(tr[i]);
                    tr[i].style.display = "";
                } 
                else if(input != '')
                {
                    count++;
                    tr[i].style.display = "none";
                }
            }
        }
    }
    // console.log(count);
    // if(count == 0)
    // {
    //     $('#myTable').hide();
    //     $('#myTable1').show();
    // }
    // else
    // {
    //     $('#myTable').show();
    //     $('#myTable1').hide();
    // }
}
function isInt(t)
{
    if(Number(t.value) < 0 || t.value =='e' || t.value == 'E' || t.value == null)
    { 
        t.value = 0;
        return false;
    }
}
</script>
