<!--
Service request #882040 / kirang/ 2015-01-23  :  Add New buyer T57 for Cut Plan generation
Service Request #861761 / kirang/ 2015-03-17  :  Add New buyer CK for Cut Plan generation
 
-->
<?php
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));
?>
<?php include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/menu_content.php',4,'R')); ?>

<script>

//<form name="test" action="<?php echo getURL(getBASE($_GET['r'])['path'])['url']; ?>" method="post">

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
});

</script>
<link href="style.css" rel="stylesheet" type="text/css" />
<?php echo '<link href="'."http://".$_SERVER['HTTP_HOST']."/sfcs/styles/sfcs_styles.css".'" rel="stylesheet" type="text/css" />'; ?>

<?php
	//include("menu_content.php");
	$style=$_GET['style'];
	$schedule=$_GET['schedule']; 
?>

<div class = "panel panel-primary">
<div class = "panel-heading">Remove Short Shiment Jobs</div>
<div class = "panel-body">
<form name="test" action="<?php echo getFullURLLevel($_GET['r'],'remove_jobs.php','0','N'); ?>" method="post">
<?php
include('dbconf.php');
	$sql="select distinct order_style_no from bai_orders_db";	
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_num_check=mysqli_num_rows($sql_result);
echo "<div class=\"row\"><div class=\"col-sm-3\"><label>Select Style:</label><select class='form-control' name=\"style\"  id=\"style\" onchange=\"firstbox();\" id='style'>";

echo "<option value='' disabled selected>Please Select</option>";
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
echo "  </select>
	</div>";
?>

<?php
echo "<div class='col-sm-3'><label>Select Schedule:</label> 
	  <select class='form-control' name=\"schedule\" id=\"schedule\" onchange=\"secondbox();\" id='schedule'>";

	$sql="select distinct order_del_no from $bai_pro3.bai_orders_db where order_style_no=\"$style\"";	

mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_num_check=mysqli_num_rows($sql_result);

echo "<option value='' disabled selected>Please Select</option>";
while($sql_row=mysqli_fetch_array($sql_result))
{
	if(str_replace(" ","",$sql_row['order_del_no'])==str_replace(" ","",$schedule)){
			echo "<option value=\"".$sql_row['order_del_no']."\" selected>".$sql_row['order_del_no']."</option>";
		}
	else{
		echo "<option value=\"".$sql_row['order_del_no']."\">".$sql_row['order_del_no']."</option>";
	}
}

echo "	</select>
	 </div>";
?>
<div class='col-sm-3'><label>Select Type:</label> 
    <select id="remove_type" class="form-control" data-role="select" selected="selected" name="remove_type"  data-parsley-errors-container="#errId3">
        <?php
            echo '<option value="Temporary" selected>Temporary</option>';
            echo '<option value="Permanent">Permanent</option>';
        ?>
    </select>
	  
</div>
<div class='col-sm-3'><label>Reason:</label> 
    <input id="reason" type="text" class="form-control k-textbox" data-role="text" placeholder="Enter Reason" name="reason"></div>
</div><br/>
<div>
    <input class="btn btn-primary" type="submit" value="Submit" name="submit">
</div>

</form>

<hr/>

<?php
if(isset($_POST['submit']))
{
	$style=$_POST['style'];
	$schedule=$_POST['schedule'];
	$type=$_POST['remove_type'];
    $reason=$_POST['reason'];
    if($type == 'Temporary'){
        $status = 1;
    }
    if($type == 'Permanent'){
        $status = 2;
    }
    // echo $style;die();
    //saving data
    $insert_qry = "insert into deleted_shipment_jobs(style,schedule,removing_type,reason) values('$style','$schedule','$type','$reason')";
    $insert_qry_result=mysqli_query($link, $insert_qry) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));

    //remove 
    $remove_docs=array();
    $sqlx="select distinct input_job_no_random_ref as doc_no from $bai_pro3.plan_dash_doc_summ_input where order_style_no = '$style' and order_del_no = '$schedule'";
    $sql_resultx=mysqli_query($link, $sqlx) or exit("Sql Error11".mysqli_error($GLOBALS["___mysqli_ston"]));
    // echo $sqlx;die();
    while($sql_rowx=mysqli_fetch_array($sql_resultx))
    {
        $remove_docs[]="'".$sql_rowx['doc_no']."'";
    }
    if(sizeof($remove_docs)>0)
    {
        //ips backup and delete
        $backup_ips_query="INSERT IGNORE INTO $bai_pro3.plan_dashboard_input_backup SELECT * FROM $bai_pro3.`plan_dashboard_input` WHERE input_job_no_random_ref in (".implode(",",$remove_docs).")";
        mysqli_query($link, $backup_ips_query) or exit("Sql Error11".mysqli_error($GLOBALS["___mysqli_ston"]));
        $update_ips_qry = "update $bai_pro3.`plan_dashboard_input_backup` set shipment_remove_status = '$status' where input_job_no_random_ref in (".implode(",",$remove_docs).")";
        mysqli_query($link, $update_ips_qry) or exit("Sql Error11".mysqli_error($GLOBALS["___mysqli_ston"]));
        $del_ips_sqlx="delete from $bai_pro3.plan_dashboard_input where input_job_no_random_ref in (".implode(",",$remove_docs).")";
        mysqli_query($link, $del_ips_sqlx) or exit("Sql Error11".mysqli_error($GLOBALS["___mysqli_ston"]));
        
    }
        //remove 
    $remove_ims_docs=array();
    $ims_sqlx="select distinct input_job_rand_no_ref as ims_job from $bai_pro3.ims_log where ims_style = '$style' and ims_schedule = '$schedule'";
    $ims_sqlx_res=mysqli_query($link, $ims_sqlx) or exit("Sql Error11".mysqli_error($GLOBALS["___mysqli_ston"]));
    // echo $sqlx;die();
    while($sql_ims_rowx=mysqli_fetch_array($ims_sqlx_res))
    {
        $remove_ims_jobs[]="'".$sql_ims_rowx['ims_job']."'";
    }

    //ims backup and delete
    $backup_ims_query="INSERT IGNORE INTO $bai_pro3.ims_log_backup SELECT * FROM $bai_pro3.`ims_log` WHERE input_job_rand_no_ref in (".implode(",",$remove_ims_jobs).")";
    mysqli_query($link, $backup_ims_query) or exit("Sql Error11".mysqli_error($GLOBALS["___mysqli_ston"]));
    $update_ims_qry = "update $bai_pro3.`ims_log_backup` set shipment_remove_status = '$status' where input_job_rand_no_ref in (".implode(",",$remove_ims_jobs).")";
    mysqli_query($link, $update_ims_qry) or exit("Sql Error11".mysqli_error($GLOBALS["___mysqli_ston"]));
    $del_ims_sqlx="delete from $bai_pro3.ims_log where input_job_rand_no_ref in (".implode(",",$remove_ims_jobs).")";
    mysqli_query($link, $del_ims_sqlx) or exit("Sql Error11".mysqli_error($GLOBALS["___mysqli_ston"]));
        // echo $del_sqlx;	
}
?> 
   </div>
   </div>
   </div>
   </div>
  