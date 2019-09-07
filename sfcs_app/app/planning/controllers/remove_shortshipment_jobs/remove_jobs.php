<?php
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));
?>
<?php include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/menu_content.php',4,'R'))
?>

<?php echo '<link href="'."http://".$_SERVER['HTTP_HOST']."/sfcs/styles/sfcs_styles.css".'" rel="stylesheet" type="text/css" />'; 
    $username = getrbac_user()['uname'];
	$style=$_GET['style'];
	$schedule=$_GET['schedule']; 
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
            // if($insert_qry_result) {

                //To remove Jobs in IPS and TMS
                $remove_docs=array();
                $sqlx="select distinct input_job_no_random_ref as job_numbers from $bai_pro3.plan_dash_doc_summ_input where order_style_no = '$style' and order_del_no = '$schedule'";
                $sql_resultx=mysqli_query($link, $sqlx) or exit("Sql Error11".mysqli_error($GLOBALS["___mysqli_ston"]));
                while($sql_rowx=mysqli_fetch_array($sql_resultx))
                {
                    $remove_docs[]="'".$sql_rowx['job_numbers']."'";
                }
                if(sizeof($remove_docs)>0)
                {
                    $remarks = array();
                    $backup_ips_query="INSERT IGNORE INTO $bai_pro3.plan_dashboard_input_backup SELECT * FROM $bai_pro3.`plan_dashboard_input` WHERE input_job_no_random_ref in (".implode(",",$remove_docs).")";
                    $backup_ips_query_result = mysqli_query($link, $backup_ips_query) or exit("Sql Error12".mysqli_error($GLOBALS["___mysqli_ston"]));
                    $update_ips_qry = "update $bai_pro3.`plan_dashboard_input_backup` set shipment_remove_status = '$status' where input_job_no_random_ref in (".implode(",",$remove_docs).")";
                    $update_ips_qry_result = mysqli_query($link, $update_ips_qry) or exit("Sql Error13".mysqli_error($GLOBALS["___mysqli_ston"]));
                    $del_ips_sqlx="delete from $bai_pro3.plan_dashboard_input where input_job_no_random_ref in (".implode(",",$remove_docs).")";
                    $del_ips_sqlx_result = mysqli_query($link, $del_ips_sqlx) or exit("Sql Error14".mysqli_error($GLOBALS["___mysqli_ston"]));
                    if($backup_ips_query_result && $update_ips_qry_result && $del_ips_sqlx_result) {
                        $remarks[]="'IPS','TMS',";
                    }
                }

                //To remove Jobs in IMS
                $remove_ims_jobs=array();
                $ims_sqlx="select distinct input_job_rand_no_ref as ims_job from $bai_pro3.ims_log where ims_style = '$style' and ims_schedule = '$schedule'";
                $ims_sqlx_res=mysqli_query($link, $ims_sqlx) or exit("Sql Error15".mysqli_error($GLOBALS["___mysqli_ston"]));
                while($sql_ims_rowx=mysqli_fetch_array($ims_sqlx_res))
                {
                    $remove_ims_jobs[]="'".$sql_ims_rowx['ims_job']."'";
                }
                
                if(sizeof($remove_ims_jobs) >0) {
                    $backup_ims_query="INSERT IGNORE INTO $bai_pro3.ims_log_backup SELECT * FROM $bai_pro3.`ims_log` WHERE input_job_rand_no_ref in (".implode(",",$remove_ims_jobs).")";
                    mysqli_query($link, $backup_ims_query) or exit("Sql Error16".mysqli_error($GLOBALS["___mysqli_ston"]));
                    $update_ims_qry = "update $bai_pro3.`ims_log_backup` set shipment_remove_status = '$status' where input_job_rand_no_ref in (".implode(",",$remove_ims_jobs).")";
                    $update_ims_qry_res =mysqli_query($link, $update_ims_qry) or exit("Sql Error17".mysqli_error($GLOBALS["___mysqli_ston"]));
                    $del_ims_sqlx = "delete from $bai_pro3.ims_log where input_job_rand_no_ref in (".implode(",",$remove_ims_jobs).")";
                    $del_ims_sqlx_res =mysqli_query($link, $del_ims_sqlx) or exit("Sql Error18".mysqli_error($GLOBALS["___mysqli_ston"]));
                    if($update_ims_qry_res && $del_ims_sqlx_res) {
                        $remarks[]="'IMS',";
                    }
                }

                //To remove Jobs in Cut Table Dashboard
              
                $cut_table_query="select distinct doc_no as doc_nos from $bai_pro3.plan_doc_summ where order_style_no = '$style' and order_del_no = '$schedule'";
                $cut_table_query_resultx=mysqli_query($link, $cut_table_query) or exit("Sql Error11".mysqli_error($GLOBALS["___mysqli_ston"]));
                while($cut_table_rowx=mysqli_fetch_array($cut_table_query_resultx))
                { 
                    $cut_table_update="UPDATE `bai_pro3`.`cutting_table_plan` SET short_shipment_status=".$status." WHERE doc_no =".$cut_table_rowx['doc_nos'];
                    $cut_table_update_resultx=mysqli_query($link, $cut_table_update) or exit("Sql Error11".mysqli_error($GLOBALS["___mysqli_ston"]));
                    if($cut_table_update_resultx) {
                        $remarks[]="'Cut Table',";
                    }
                }

                //To remove Jobs in Rejection Dashboard-(ims,cutt(2),Rejection)
              
                $rej_table_query="select * from $bai_pro3.rejections_log where style = '$style' and schedule = '$schedule'";
                $rej_table_query_resultx=mysqli_query($link, $rej_table_query) or exit("Sql Error11".mysqli_error($GLOBALS["___mysqli_ston"]));
                $rej_table_rowx=mysqli_num_rows($rej_table_query_resultx);
                if($rej_table_rowx>0)
                { 
                    $rej_table_update="UPDATE `bai_pro3`.`rejections_log` SET short_shipment_status=".$status." WHERE style = '$style' and schedule = '$schedule'";
                    $rej_table_update_result=mysqli_query($link, $rej_table_update) or exit("Sql Error11".mysqli_error($GLOBALS["___mysqli_ston"]));
                    if($rej_table_update_result) {
                        $remarks[]="'Cut Table',";
                    }
                }

                //to remove jobs in Recut Dashboard
                $recut_table_query="select distinct doc_no as doc_nos from $bai_pro3.plan_doc_summ where order_style_no = '$style' and order_del_no = '$schedule'";
                $recut_table_query_resultx=mysqli_query($link, $recut_table_query) or exit("Sql Error11".mysqli_error($GLOBALS["___mysqli_ston"]));
                while($recut_table_rowx=mysqli_fetch_array($recut_table_query_resultx))
                { 
                    $recut_table_update="UPDATE `bai_pro3`.`recut_v2` SET short_shipment_status=".$status." WHERE doc_no =".$recut_table_rowx['doc_nos'];
                    $recut_table_update_resultx=mysqli_query($link, $recut_table_update) or exit("Sql Error11".mysqli_error($GLOBALS["___mysqli_ston"]));
                    if($recut_table_update_resultx) {
                        $remarks[]="'Recut',";
                    }
                }


                echo "<script>swal('Short Shipment Job Successfully Removed.','','success');</script>";
            // }
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