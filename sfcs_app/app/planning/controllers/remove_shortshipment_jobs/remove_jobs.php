<?php
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/functions.php',4,'R'));
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/functions_dashboard.php',4,'R'));

$mail_status=0;
$username = getrbac_user()['uname'];
$style=style_decode($_GET['style']);
$schedule=$_GET['schedule']; 
    
?>

<div class = "panel panel-primary">
<div class = "panel-heading">Remove Short Shipment Jobs</div>
<div class = "panel-body">
    <form name="test" action="<?php echo getFullURLLevel($_GET['r'],'remove_jobs.php','0','N'); ?>" method="post">
    <div class="row">
    <?php
        $sql="select distinct order_style_no from $bai_pro3.bai_orders_db";	
        $sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
        $sql_num_check=mysqli_num_rows($sql_result);
        echo "<div class=\"col-sm-2\"><label>Style <span style='color:red;'> *</span></label><select class='form-control' name=\"style\"  id=\"style\" onchange=\"firstbox();\" id='style' required>";
        echo "<option value='' disabled selected>Select Style</option>";
        while($sql_row=mysqli_fetch_array($sql_result))
        {
            if(str_replace(" ","",$sql_row['order_style_no'])==str_replace(" ","",$style))
            {
                echo "<option value=\"".$sql_row['order_style_no']."\" selected>".$sql_row['order_style_no']."</option>";
            }
            else
            {
                echo "<option value=\"".$sql_row['order_style_no']."\">".$sql_row['order_style_no']."</option>";
            }
        }
        echo "</select>
            </div>";
    ?>
    <?php
        echo "<div class='col-sm-2'><label>Schedule<span style='color:red;'> *</span></label>
        <select class='form-control' name=\"schedule\" id=\"schedule\" onchange=\"secondbox();\" id='schedule' required>";
        $sql="select distinct order_del_no from $bai_pro3.bai_orders_db where order_style_no=\"$style\"";	
        $sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
        $sql_num_check=mysqli_num_rows($sql_result);
        echo "<option value='' disabled selected>Select Schedule</option>";
        while($sql_row=mysqli_fetch_array($sql_result))
        {
            if(str_replace(" ","",$sql_row['order_del_no'])==str_replace(" ","",$schedule)){
                    echo "<option value=\"".$sql_row['order_del_no']."\" selected>".$sql_row['order_del_no']."</option>";
                }
            else{
                echo "<option value=\"".$sql_row['order_del_no']."\">".$sql_row['order_del_no']."</option>";
            }
        }
        echo "</select>
        </div>";
    ?>
    <div class='col-sm-2'><label>Type<span style="color:red;"> *</span></label> 
        <select id="remove_type" class="form-control" data-role="select" selected="selected" name="remove_type"  data-parsley-errors-container="#errId3" required>
            <?php
                echo '<option value="" disabled selected>Select Type</option>';
                echo '<option value="1">Temporary</option>';
                echo '<option value="2">Permanent</option>';
            ?>
        </select>
    </div>
    <div class="col-md-3">
        <label class="control-label control-label-left col-sm-4" for="reason">Reason<span style="color:red;"> *</span></label><br/>
        <textarea id="reason" type="text" class="form-control k-textbox" data-role="text" placeholder="Enter Reason" name="reason" data-parsley-errors-container="#errId4" required></textarea><span id="errId4" class="error"></span>
    </div><br/>
    <div class="col-md-2">
        <input class="btn btn-primary" type="submit" value="Submit" name="submit">
    </div></div>
</form>


<?php
if(isset($_POST['submit']))
{
	$style=$_POST['style'];
	$schedule=$_POST['schedule'];
	$status=$_POST['remove_type'];
    $reason=$_POST['reason'];
    $exists = 1;
    
    if($style && $schedule && $status) {

        $is_style_schedule_exists = "select * from $bai_pro3.short_shipment_job_track where style='".$style."' and schedule='".$schedule."' and remove_type in ('1','2')";
        $is_style_schedule_exists_result=mysqli_query($link, $is_style_schedule_exists) or exit("Sql Error11".mysqli_error($GLOBALS["___mysqli_ston"]));
        $is_jobs_deactivated = "select * from $bai_pro3.job_deactive_log where style='".$style."' and schedule='".$schedule."' and remove_type=3";
        $is_jobs_deactivated_result=mysqli_query($link, $is_jobs_deactivated) or exit("Sql Error11".mysqli_error($GLOBALS["___mysqli_ston"]));
        // $repeat = "select * from $bai_pro3.short_shipment_job_track where style='".$style."' and schedule='".$schedule."' and remove_type in ('1','2')";
        // $repeat_result=mysqli_query($link, $repeat) or exit("Sql Error12".mysqli_error($GLOBALS["___mysqli_ston"]));
        // if(mysqli_num_rows($repeat_result) > 0) {
        //     $exists = 1;
        // } else {
        //     $exists = 0;
        // }
        // echo mysqli_num_rows($is_style_schedule_exists_result);
        // echo $exists;
        if(mysqli_num_rows($is_jobs_deactivated_result) == 0){
            if(mysqli_num_rows($is_style_schedule_exists_result) == 0) {
                
                $insert_qry = "insert into $bai_pro3.short_shipment_job_track(style,schedule,remove_type,remove_reason,removed_by) values('$style','$schedule','$status','$reason','$username')";
                $insert_qry_result=mysqli_query($link, $insert_qry) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
                $short_shipment_job_track_id = mysqli_insert_id($link);
    
                if($insert_qry_result) {
                    
                    $remove_docs=array();
                    $remove_ref_nums=array();
                    //Get Ref Numbers
                    $sql_ref_nums="select distinct input_job_no_random as job_numbers from $bai_pro3.packing_summary_input where order_style_no = '$style' and order_del_no = '$schedule'";
                    $sql_ref_nums_res=mysqli_query($link, $sql_ref_nums) or exit("Sql Error11".mysqli_error($GLOBALS["___mysqli_ston"]));
                    while($sql_rowx=mysqli_fetch_array($sql_ref_nums_res))
                    {
                        $remove_ref_nums[]="'".$sql_rowx['job_numbers']."'";
                    }
    
                    $order_tid_qry="select distinct order_tid as order_tids from $bai_pro3.bai_orders_db where order_style_no = '$style' and order_del_no = '$schedule'";
                    $order_tid_res=mysqli_query($link, $order_tid_qry) or exit("Sql Error11".mysqli_error($GLOBALS["___mysqli_ston"]));
                    while($sql_rowr=mysqli_fetch_array($order_tid_res))
                    {
                        $order_tids[]="'".$sql_rowr['order_tids']."'";
                    }
    
                    //Get Doc Numbers
                    $sql_doc_nums="select distinct doc_no as doc_numbers from $bai_pro3.plandoc_stat_log where order_tid in(".implode(",",$order_tids).")";
                    $sql_doc_nums_res=mysqli_query($link, $sql_doc_nums) or exit("Sql Error11".mysqli_error($GLOBALS["___mysqli_ston"]));
                    while($sql_rows=mysqli_fetch_array($sql_doc_nums_res))
                    {
                        $remove_docs[]="'".$sql_rows['doc_numbers']."'";
                    }
    
                    $remarks = '';
                    if(sizeof($remove_ref_nums)>0)
                    {
                        //To remove Jobs in IPS and TMS
                        $ips_chck_qry = "select distinct input_job_no_random_ref as ips_tms_jobs from $bai_pro3.plan_dashboard_input where input_job_no_random_ref in (".implode(",",$remove_ref_nums).")";
                        $ips_chck_qry_res = mysqli_query($link, $ips_chck_qry) or exit("Sql Error21".mysqli_error($GLOBALS["___mysqli_ston"]));
                        while($ips_chck_row=mysqli_fetch_array($ips_chck_qry_res))
                        {
                            $ips_tms_jobs[]="'".$ips_chck_row['ips_tms_jobs']."'";
                        }
                        $ips_chck_qry1 = "select distinct input_job_no_random_ref as ips_tms_jobs from $bai_pro3.plan_dashboard_input_backup where input_job_no_random_ref in (".implode(",",$remove_ref_nums).")";
                        
                        $ips_chck_qry1_res = mysqli_query($link, $ips_chck_qry1) or exit("Sql Error21".mysqli_error($GLOBALS["___mysqli_ston"]));
                        while($ips_chck_row=mysqli_fetch_array($ips_chck_qry1_res))
                        {
                            $ips_tms_jobs1[]="'".$ips_chck_row['ips_tms_jobs']."'";
                        }
                        
                        if(sizeof($ips_tms_jobs)>0){
                            $backup_ips_query="INSERT IGNORE INTO $bai_pro3.plan_dashboard_input_backup SELECT * FROM $bai_pro3.plan_dashboard_input WHERE input_job_no_random_ref in (".implode(",",$ips_tms_jobs).")";
                            $backup_ips_query_result = mysqli_query($link, $backup_ips_query) or exit("Sql Error12".mysqli_error($GLOBALS["___mysqli_ston"]));
                            $update_ips_qry = "update $bai_pro3.plan_dashboard_input_backup set short_shipment_status = '$status' where input_job_no_random_ref in (".implode(",",$ips_tms_jobs).")";
                            $update_ips_qry_result = mysqli_query($link, $update_ips_qry) or exit("Sql Error13".mysqli_error($GLOBALS["___mysqli_ston"]));
                            $del_ips_sqlx="delete from $bai_pro3.plan_dashboard_input where input_job_no_random_ref in (".implode(",",$ips_tms_jobs).")";
                            $del_ips_sqlx_result = mysqli_query($link, $del_ips_sqlx) or exit("Sql Error14".mysqli_error($GLOBALS["___mysqli_ston"]));
                            if($backup_ips_query_result && $update_ips_qry_result && $del_ips_sqlx_result) {
                                $remarks .="IPS,TMS,";
                            }
                        } else if(sizeof($ips_tms_jobs1)>0){
                            $update_ips_qry = "update $bai_pro3.plan_dashboard_input_backup set short_shipment_status = '$status' where input_job_no_random_ref in (".implode(",",$ips_tms_jobs1).")";
                            // echo $update_ips_qry;
                            $update_ips_qry_result = mysqli_query($link, $update_ips_qry) or exit("Sql Error113".mysqli_error($GLOBALS["___mysqli_ston"]));
                        }
                        //To remove Jobs in IMS
                        $ims_chck_qry = "select distinct input_job_rand_no_ref as ims_jobs from $bai_pro3.ims_log where input_job_rand_no_ref in (".implode(",",$remove_ref_nums).")";
                        $ims_chck_qry_res = mysqli_query($link, $ims_chck_qry) or exit("Sql Error22".mysqli_error($GLOBALS["___mysqli_ston"]));
                        while($ims_chck_row=mysqli_fetch_array($ims_chck_qry_res))
                        {
                            $ims_jobs[]="'".$ims_chck_row['ims_jobs']."'";
                        }
                        if(sizeof($ims_jobs)>0){
                            $backup_ims_query="INSERT IGNORE INTO $bai_pro3.ims_log_backup SELECT * FROM $bai_pro3.ims_log WHERE input_job_rand_no_ref in (".implode(",",$ims_jobs).")";
                            mysqli_query($link, $backup_ims_query) or exit("Sql Error16".mysqli_error($GLOBALS["___mysqli_ston"]));
                            $update_ims_qry = "update $bai_pro3.ims_log_backup set short_shipment_status = '$status' where input_job_rand_no_ref in (".implode(",",$ims_jobs).") and ims_status <> 'DONE'";
                            $update_ims_qry_res =mysqli_query($link, $update_ims_qry) or exit("Sql Error17".mysqli_error($GLOBALS["___mysqli_ston"]));
                            $del_ims_sqlx = "delete from $bai_pro3.ims_log where input_job_rand_no_ref in (".implode(",",$ims_jobs).")";
                            $del_ims_sqlx_res =mysqli_query($link, $del_ims_sqlx) or exit("Sql Error18".mysqli_error($GLOBALS["___mysqli_ston"]));
                            if($update_ims_qry_res && $del_ims_sqlx_res) {
                                $remarks .="IMS,";
    
                            }
                        }
                        
                    }
    
                    //to remove jobs in WIP Dashboard
                    if($status==1) {
                        $change_status = 3;
                    } else {
                        $change_status = 2;
                    }
                    $wip_chck_qry = "select id from $brandix_bts.bundle_creation_data where style='".$style."' and schedule='".$schedule."'and bundle_qty_status=0";
                    $wip_chck_qry_res=mysqli_query($link, $wip_chck_qry) or exit("Sql Error20".mysqli_error($GLOBALS["___mysqli_ston"]));
                    while($wip_chck_row=mysqli_fetch_array($wip_chck_qry_res))
                    {
                        $wip_jobs[]="'".$wip_chck_row['id']."'";
                    }
                    if(sizeof($wip_jobs)>0){
                        $wip_dash_table_update="UPDATE $brandix_bts.bundle_creation_data SET bundle_qty_status=$change_status WHERE id in (".implode(",",$wip_jobs).")";
                        $wip_dash_table_update_resultx=mysqli_query($link, $wip_dash_table_update) or exit("Sql Error144".mysqli_error($GLOBALS["___mysqli_ston"]));
                        if($wip_dash_table_update_resultx) {
                            $remarks .="WIP,";
    
                        }
                    }
    
                    if(sizeof($remove_docs)>0)
                    {
                        //To remove Jobs in RMS, cwip inWPT
                        $plan_doc_update="UPDATE $bai_pro3.plandoc_stat_log SET short_shipment_status=".$status." WHERE doc_no in (".implode(",",$remove_docs).")";
                        $plan_doc_update_resultx=mysqli_query($link, $plan_doc_update) or exit("Sql Error11".mysqli_error($GLOBALS["___mysqli_ston"]));
                        if($plan_doc_update_resultx) {
                            $remarks .="WIP,";
                        }   
    
                        //To remove Jobs in Cut Table Dashboard
                        $cut_chck_qry = "select distinct doc_no as cut_docs from $bai_pro3.cutting_table_plan where doc_no in (".implode(",",$remove_docs).")";
                        $cut_chck_qry_res=mysqli_query($link, $cut_chck_qry) or exit("Sql Error20".mysqli_error($GLOBALS["___mysqli_ston"]));
                        while($cut_chck_row=mysqli_fetch_array($cut_chck_qry_res))
                        {
                            $cut_docs[]="'".$cut_chck_row['cut_docs']."'";
                        }
                        
                        if(sizeof($cut_docs)>0){
                            $cut_table_update="UPDATE $bai_pro3.cutting_table_plan SET short_shipment_status=".$status." WHERE doc_no in (".implode(",",$cut_docs).")";
                            $cut_table_update_resultx=mysqli_query($link, $cut_table_update) or exit("Sql Error11".mysqli_error($GLOBALS["___mysqli_ston"]));
                            if($cut_table_update_resultx) {
                                $remarks .="CUT,";
    
                            }
                        }
                                            
                        //To remove Jobs in Embellishment Dashboard
                        $emblishment_chck_qry = "select distinct doc_no as emb_docs from $bai_pro3.embellishment_plan_dashboard where doc_no in (".implode(",",$remove_docs).")";
                        $emblishment_chck_qry_res=mysqli_query($link, $emblishment_chck_qry) or exit("Sql Error20".mysqli_error($GLOBALS["___mysqli_ston"]));
                        while($emb_chck_row=mysqli_fetch_array($emblishment_chck_qry_res))
                        {
                            $emb_docs[]="'".$emb_chck_row['emb_docs']."'";
                        }
                        if(sizeof($emb_docs)>0){
                            $emb_table_update="UPDATE $bai_pro3.embellishment_plan_dashboard SET short_shipment_status=".$status." WHERE doc_no in (".implode(",",$emb_docs).")";
                            $emb_table_update_resultx=mysqli_query($link, $emb_table_update) or exit("Sql Error11".mysqli_error($GLOBALS["___mysqli_ston"]));
                            if($emb_table_update_resultx) {
                                $remarks .="EMB,";
                            }
                        }
                        
                        //to remove jobs in Recut Dashboard
                        $recut_chck_qry = "select distinct doc_no as recut_docs from $bai_pro3.recut_v2 where doc_no in (".implode(",",$remove_docs).")";
                        $recut_chck_qry_res=mysqli_query($link, $recut_chck_qry) or exit("Sql Error20".mysqli_error($GLOBALS["___mysqli_ston"]));
                        while($recut_chck_row=mysqli_fetch_array($recut_chck_qry_res))
                        {
                            $recut_docs[]="'".$recut_chck_row['recut_docs']."'";
                        }
                        if(sizeof($recut_docs)>0){
                            $recut_table_update="UPDATE $bai_pro3.recut_v2 SET short_shipment_status=".$status." WHERE doc_no in (".implode(",",$recut_docs).")";
                            $recut_table_update_resultx=mysqli_query($link, $recut_table_update) or exit("Sql Error11".mysqli_error($GLOBALS["___mysqli_ston"]));
                            if($recut_table_update_resultx) {
                                $remarks .="Recut,";
                            }
                        }
                    }
                    
                    //To remove Jobs in Rejection Dashboard-(ims,cutt(2),Rejection)
                    
                    $rej_table_query="select * from $bai_pro3.rejections_log where style = '$style' and schedule = '$schedule'";
                    // echo $rej_table_query;die();
                    $rej_table_query_resultx=mysqli_query($link, $rej_table_query) or exit("Sql Error11".mysqli_error($GLOBALS["___mysqli_ston"]));
                    $rej_table_rowx=mysqli_num_rows($rej_table_query_resultx);
                    if($rej_table_rowx>0)
                    { 
                        $rej_table_update="UPDATE $bai_pro3.rejections_log SET short_shipment_status=".$status." WHERE style = '$style' and schedule = '$schedule'";
                        $rej_table_update_result=mysqli_query($link, $rej_table_update) or exit("Sql Error11".mysqli_error($GLOBALS["___mysqli_ston"]));
                        if($rej_table_update_result) {
                            $remarks .="Rejections";
                        }
                    }
    
                    // var_dump($remarks);
                    // $short_shipment_remark=rtrim($remarks,',');
                    // $update_revers_qry = "update $bai_pro3.short_shipment_job_track set remarks='".$short_shipment_remark."' where id=".$short_shipment_job_track_id;
                    // // echo $update_revers_qry;
                    // $update_revers_qry_result = mysqli_query($link, $update_revers_qry) or exit("update error".mysqli_error($GLOBALS["___mysqli_ston"]));
    
                    include('mail_configuration.php');
            
                    if($mail_status==1){
                        echo "<script>swal('Short Shipment Done & Mail sent Successfully.','','success');</script>";
                    }else{
                        echo "<script>swal('Short Shipment Done Successfully.','','success');</script>";
                    }
                }
            } else {
                echo "<script>swal('Short Shipment Jobs as Already Allocated','','warning');</script>";
            }
        }else{
            while($row=mysqli_fetch_array($is_jobs_deactivated_result))
            {
                $remarks = $row['remarks'];
                $qry="select prefix from $brandix_bts.tbl_sewing_job_prefix where prefix_name='$remarks'";
                $res=mysqli_query($link, $qry)or exit("scanning_error".mysqli_error($GLOBALS["___mysqli_ston"]));
                while($sql_row123=mysqli_fetch_array($res))
                {
                    $sewing_prefi=$sql_row123['prefix'];
                }

                $ij_no = $sewing_prefi.leading_zeros($row['input_job_no'],3);
                $input_job_no[] = $row['module_no'].'-'.$ij_no;
            }

            foreach($input_job_no as $key=>$value){
                $input_job_no1[] = $value;
            }
            $array_list = array_unique($input_job_no1);
            $list = implode(",",$array_list);
            echo "<script>swal('Sewing Jobs * $list * For This Schedule is On Hold','Short Shipment is not Done. Please Reactivate them!','warning');</script>";
        }
    } else {
        echo "<script>swal('Enter Style Schedule and Color','','error');</script>";
    }


}
?> 
<?php
    include('view_short_shipment_jobs.php');
?>
   </div>
   </div>
   </div>
   </div>

<script>

function firstbox()
{
	window.location.href ="<?= 'index.php?r='.$_GET['r']; ?>&style="+window.btoa(unescape(encodeURIComponent(document.test.style.value)))
}

function secondbox()
{
	var uriVal = "<?= 'index.php?r='.$_GET['r']; ?>&style="+window.btoa(unescape(encodeURIComponent(document.test.style.value)))+"&schedule="+document.test.schedule.value;
	window.location.href = uriVal;
}


$(document).ready(function() {
	$('#schedule').on('click',function(e){
		var style = $('#style').val();
		if(style == null){
			sweetAlert('Please Select Style','','warning');
		}
    });
    $('#remove_type').on('click',function(e){
		var style = $('#style').val();
		var schedule = $('#schedule').val();
		if(style == null){
			sweetAlert('Please Select Style','','warning');
        }
        if(schedule == null){
			sweetAlert('Please Select Schedule','','warning');
        }
        if(style == null && schedule == null ){
			sweetAlert('Please Select Style & Schedule','','warning');
		}
	});
});

</script>
