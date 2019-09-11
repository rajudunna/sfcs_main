<?php
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));
?>
<?php include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/menu_content.php',4,'R'))
?>

<?php echo '<link href="'."http://".$_SERVER['HTTP_HOST']."/sfcs/styles/sfcs_styles.css".'" rel="stylesheet" type="text/css" />'; 
    $username = getrbac_user()['uname'];
	$style=$_GET['style'];
    $schedule=$_GET['schedule']; 
    $mail = getFullURL($_GET['r'],'mail_configuration.php','R');
    
?>

<div class = "panel panel-primary">
<div class = "panel-heading">Remove Short Shipment Jobs</div>
<div class = "panel-body">
    <form name="test" action="<?php echo getFullURLLevel($_GET['r'],'remove_jobs.php','0','N'); ?>" method="post">
    <div class="row">
    
    <?php
        $sql="select distinct order_style_no from bai_orders_db";	
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
        mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
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
        <label class="control-label control-label-left col-sm-3" for="reason">Reason</label><br/>
        <textarea id="reason" type="text" class="form-control k-textbox" data-role="text" placeholder="Enter Reason" name="reason" data-parsley-errors-container="#errId1"></textarea><span id="errId1" class="error"></span>
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
    
    if($style && $schedule && $status) {

        $is_style_schedule_exists = "select * from $bai_pro3.short_shipment_job_track where style='".$style."' and schedule='".$schedule."'";
        $is_style_schedule_exists_result=mysqli_query($link, $is_style_schedule_exists) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
        if(mysqli_num_rows($is_style_schedule_exists_result) == 0) {
            $insert_qry = "insert into short_shipment_job_track(style,schedule,remove_type,remove_reason,removed_by) values('$style','$schedule','$status','$reason','$username')";
            $insert_qry_result=mysqli_query($link, $insert_qry) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
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
                //Get Doc Numbers
                $sql_doc_nums="select distinct doc_no as doc_numbers from $bai_pro3.packing_summary_input where order_style_no = '$style' and order_del_no = '$schedule'";
                $sql_doc_nums_res=mysqli_query($link, $sql_doc_nums) or exit("Sql Error11".mysqli_error($GLOBALS["___mysqli_ston"]));
                while($sql_rows=mysqli_fetch_array($sql_doc_nums_res))
                {
                    $remove_docs[]="'".$sql_rows['doc_numbers']."'";
                }



                if(sizeof($remove_ref_nums)>0)
                {
                    //To remove Jobs in IPS and TMS
                    $remarks = array();
                    $ips_chck_qry = "select * from $bai_pro3.`plan_dashboard_input` where input_job_no_random_ref in (".implode(",",$remove_ref_nums).")";
                    $ips_chck_qry_res = mysqli_query($link, $ips_chck_qry) or exit("Sql Error21".mysqli_error($GLOBALS["___mysqli_ston"]));
                    if($ips_chck_qry_res > 0){
                        $backup_ips_query="INSERT IGNORE INTO $bai_pro3.plan_dashboard_input_backup SELECT * FROM $bai_pro3.`plan_dashboard_input` WHERE input_job_no_random_ref in (".implode(",",$remove_ref_nums).")";
                        $backup_ips_query_result = mysqli_query($link, $backup_ips_query) or exit("Sql Error12".mysqli_error($GLOBALS["___mysqli_ston"]));
                        $update_ips_qry = "update $bai_pro3.`plan_dashboard_input_backup` set short_shipment_status = '$status' where input_job_no_random_ref in (".implode(",",$remove_ref_nums).")";
                        $update_ips_qry_result = mysqli_query($link, $update_ips_qry) or exit("Sql Error13".mysqli_error($GLOBALS["___mysqli_ston"]));
                        $del_ips_sqlx="delete from $bai_pro3.plan_dashboard_input where input_job_no_random_ref in (".implode(",",$remove_ref_nums).")";
                        $del_ips_sqlx_result = mysqli_query($link, $del_ips_sqlx) or exit("Sql Error14".mysqli_error($GLOBALS["___mysqli_ston"]));
                        if($backup_ips_query_result && $update_ips_qry_result && $del_ips_sqlx_result) {
                            $remarks[]="'IPS','TMS',";
                        }
                    }
                    // die();

                    //To remove Jobs in IMS
                    $ims_chck_qry = "select * from $bai_pro3.`ims_log` where input_job_rand_no_ref in (".implode(",",$remove_ref_nums).")";
                    $ims_chck_qry_res = mysqli_query($link, $ims_chck_qry) or exit("Sql Error22".mysqli_error($GLOBALS["___mysqli_ston"]));
                    if($ims_chck_qry_res > 0){
                        $backup_ims_query="INSERT IGNORE INTO $bai_pro3.ims_log_backup SELECT * FROM $bai_pro3.`ims_log` WHERE input_job_rand_no_ref in (".implode(",",$remove_ref_nums).")";
                        mysqli_query($link, $backup_ims_query) or exit("Sql Error16".mysqli_error($GLOBALS["___mysqli_ston"]));
                        $update_ims_qry = "update $bai_pro3.`ims_log_backup` set short_shipment_status = '$status' where input_job_rand_no_ref in (".implode(",",$remove_ref_nums).") and ims_status <> 'DONE'";
                        $update_ims_qry_res =mysqli_query($link, $update_ims_qry) or exit("Sql Error17".mysqli_error($GLOBALS["___mysqli_ston"]));
                        $del_ims_sqlx = "delete from $bai_pro3.ims_log where input_job_rand_no_ref in (".implode(",",$remove_ref_nums).")";
                        $del_ims_sqlx_res =mysqli_query($link, $del_ims_sqlx) or exit("Sql Error18".mysqli_error($GLOBALS["___mysqli_ston"]));
                        if($update_ims_qry_res && $del_ims_sqlx_res) {
                            $remarks[]="'IMS',";
                        }
                    }
                    // die();
                    

                    //to remove jobs in WIP Dashboard
                    if($status==1) {
                        $change_status = 3;
                    } else {
                        $change_status = 2;
                    }
                    $wip_chck_qry = "select * from $brandix_bts.`bundle_creation_data` where input_job_no_random_ref in (".implode(",",$remove_ref_nums).")";
                    $wip_chck_qry_res=mysqli_query($link, $wip_chck_qry) or exit("Sql Error20".mysqli_error($GLOBALS["___mysqli_ston"]));
                    if($wip_chck_qry_res > 0){
                        $wip_dash_table_update="UPDATE $brandix_bts.`bundle_creation_data` SET bundle_qty_status=$change_status WHERE input_job_no_random_ref in (".implode(",",$remove_ref_nums).")";
                        $wip_dash_table_update_resultx=mysqli_query($link, $wip_dash_table_update) or exit("Sql Error144".mysqli_error($GLOBALS["___mysqli_ston"]));
                        if($wip_dash_table_update_resultx) {
                            $remarks[]="'WIP',";
                        }
                    }
                }

                if(sizeof($remove_docs)>0)
                {
                    
                    //To remove Jobs in Cut Table Dashboard
                    $cut_chck_qry = "select * from $bai_pro3.`cutting_table_plan` where input_job_no_random_ref in (".implode(",",$remove_ref_nums).")";
                    $cut_chck_qry_res=mysqli_query($link, $cut_chck_qry) or exit("Sql Error20".mysqli_error($GLOBALS["___mysqli_ston"]));
                    if($cut_chck_qry_res > 0){
                        $cut_table_update="UPDATE $bai_pro3.`cutting_table_plan` SET short_shipment_status=".$status." WHERE doc_no in (".implode(",",$remove_docs).")";
                        $cut_table_update_resultx=mysqli_query($link, $cut_table_update) or exit("Sql Error11".mysqli_error($GLOBALS["___mysqli_ston"]));
                        if($cut_table_update_resultx) {
                            $remarks[]="'CUT',";
                        }
                    }

                    //To remove Jobs in Embellishment Dashboard
                    $emblishment_chck_qry = "select * from $bai_pro3.`embellishment_plan_dashboard` where input_job_no_random_ref in (".implode(",",$remove_ref_nums).")";
                    $emblishment_chck_qry_res=mysqli_query($link, $emblishment_chck_qry) or exit("Sql Error20".mysqli_error($GLOBALS["___mysqli_ston"]));
                    if($emblishment_chck_qry_res > 0){
                        $emb_table_update="UPDATE $bai_pro3.`embellishment_plan_dashboard` SET short_shipment_status=".$status." WHERE doc_no in (".implode(",",$remove_docs).")";
                        $emb_table_update_resultx=mysqli_query($link, $emb_table_update) or exit("Sql Error11".mysqli_error($GLOBALS["___mysqli_ston"]));
                        if($emb_table_update_resultx) {
                            $remarks[]="'EMB',";
                        }
                    }

                    //to remove jobs in Recut Dashboard
                    $recut_chck_qry = "select * from $bai_pro3.`recut_v2` where input_job_no_random_ref in (".implode(",",$remove_ref_nums).")";
                    $recut_chck_qry_res=mysqli_query($link, $recut_chck_qry) or exit("Sql Error20".mysqli_error($GLOBALS["___mysqli_ston"]));
                    if($recut_chck_qry_res > 0){
                        $recut_table_update="UPDATE $bai_pro3.`recut_v2` SET short_shipment_status=".$status." WHERE doc_no in (".implode(",",$remove_docs).")";
                        $recut_table_update_resultx=mysqli_query($link, $recut_table_update) or exit("Sql Error11".mysqli_error($GLOBALS["___mysqli_ston"]));
                        if($recut_table_update_resultx) {
                            $remarks[]="'Recut',";
                        }
                    }
                }
               
                //To remove Jobs in Rejection Dashboard-(ims,cutt(2),Rejection)
              
                $rej_table_query="select * from $bai_pro3.rejections_log where style = '$style' and schedule = '$schedule'";
                $rej_table_query_resultx=mysqli_query($link, $rej_table_query) or exit("Sql Error11".mysqli_error($GLOBALS["___mysqli_ston"]));
                $rej_table_rowx=mysqli_num_rows($rej_table_query_resultx);
                if($rej_table_rowx>0)
                { 
                    $rej_table_update="UPDATE $bai_pro3.`rejections_log` SET short_shipment_status=".$status." WHERE style = '$style' and schedule = '$schedule'";
                    $rej_table_update_result=mysqli_query($link, $rej_table_update) or exit("Sql Error11".mysqli_error($GLOBALS["___mysqli_ston"]));
                    if($rej_table_update_result) {
                        $remarks[]="'Rejections',";
                    }
                }

                // var_dump($remarks);
                // $update_revers_qry = "update $bai_pro3.`short_shipment_job_track` set remarks='".implode(",",$remarks)."' where id=".$id;
                // $update_revers_qry_result = mysqli_query($link, $update_revers_qry) or exit("update error".mysqli_error($GLOBALS["___mysqli_ston"]));
                echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect() {  location.href = '$mail?style=$style&schedule=$schedule'}</script>";

                echo "<script>swal('Short Shipment Job Successfully Removed.','','success');</script>";
            }
        } else {
            echo "<script>swal('Short Shipment Jobs as Already Allocated','','warning');</script>";
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
	window.location.href ="<?= 'index.php?r='.$_GET['r']; ?>&style="+document.test.style.value
}

function secondbox()
{
	var uriVal = "<?= 'index.php?r='.$_GET['r']; ?>&style="+document.test.style.value+"&schedule="+document.test.schedule.value;
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