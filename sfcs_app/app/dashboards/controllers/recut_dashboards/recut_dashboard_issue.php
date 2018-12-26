<?php
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config_ajax.php');
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/mo_filling.php');
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/functions.php');
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
    // $ratioval =$_POST['ratioval'];
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
                $ratioval[$sizes_array[$i]][] = $row['a_'.$sizes_array[$i]];
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
    }
    $sql1="insert into $bai_pro3.maker_stat_log(date,cat_ref,order_tid,mklength) values (\"".date("Y-m-d")."\",".$cat_ref.",\"$order_tid\",".$mklen.")";
    mysqli_query($link, $sql1) or exit("Sql Error3".mysqli_error($GLOBALS["___mysqli_ston"]));
    $ilastid=((is_null($___mysqli_res = mysqli_insert_id($link))) ? false : $___mysqli_res);
    $sql1="update $bai_pro3.recut_v2 set p_plies=".$plies.",a_plies=".$plies.",mk_ref=$ilastid where doc_no=".$doc_nos;
    mysqli_query($link, $sql1) or exit("Sql Error45".mysqli_error($GLOBALS["___mysqli_ston"]));
    $sql1="update $bai_pro3.plandoc_stat_log set p_plies=".$plies.",a_plies=".$plies.",mk_ref=$ilastid where doc_no=".$doc_nos;
    mysqli_query($link, $sql1) or exit("Sql Error45".mysqli_error($GLOBALS["___mysqli_ston"]));

    //retreaving actual quantity to recut
    for($j=0;$j<sizeof($size);$j++)
    {
        // echo $size[$j].'</br>';
        $qty_act = array_sum($ratioval[$size[$j]])*$plies;
        $buffer_qty[$size[$j]] = $qty_act - $cut_done_qty[$size[$j]] ;
        $qty_ind_ratio  =  array_sum($ratioval[$size[$j]]);
        $a_string = 'a_'.$size[$j];
        $p_string = 'p_'.$size[$j];
        $sql="insert into $bai_pro3.bai_qms_db (qms_style,qms_schedule,qms_color,log_date,qms_size,qms_qty,qms_tran_type,remarks) values (\"$style\",\"$schedule\",\"$color\",\"".date("Y-m-d")."\",\"".str_replace("a_","",$size[$j])."\",".($qty_act).",9,\"$module-".$doc_nos."\")";
        $sql_result=mysqli_query($link, $sql) or exit("Sql Error5".mysqli_error($GLOBALS["___mysqli_ston"]));
        $update_qry = "update  $bai_pro3.recut_v2 set $a_string=$qty_ind_ratio,$p_string=$qty_ind_ratio where doc_no = $doc_nos";
        // echo $update_qry;
        mysqli_query($link, $update_qry) or exit("while updating into recut v2".mysqli_error($GLOBALS["___mysqli_ston"]));
        $update_qry_plan = "update  $bai_pro3.plandoc_stat_log set $a_string=$qty_ind_ratio,$p_string=$qty_ind_ratio where doc_no = $doc_nos";
        mysqli_query($link, $update_qry_plan) or exit("while updating into recut v2".mysqli_error($GLOBALS["___mysqli_ston"]));
    }
    $i=1;
    $retreaving_last_sewing_job_qry = "SELECT MAX(input_job_no_random)as input_job_no_random,MAX(CAST(input_job_no AS DECIMAL)) as input_job_no,destination,packing_mode,sref_id,pac_seq_no FROM `$bai_pro3`.`packing_summary_input` WHERE order_style_no = '$style' AND order_del_no = '$schedule'";
    $res_retreaving_last_sewing_job_qry = $link->query($retreaving_last_sewing_job_qry);
    while($row_sj = $res_retreaving_last_sewing_job_qry->fetch_assoc()) 
    {   
        $input_job_no = $row_sj['input_job_no'];
       // $input_job_no_random = $row_sj['input_job_no_random'];
        $destination = $row_sj['destination'];
        $packing_mode = $row_sj['packing_mode'];
        $pac_seq_no = $row_sj['pac_seq_no'];
        // $sref_id = $row_sj['sref_id'];
        $sref_id = '1';
    }
    $act_input_job_no = $input_job_no+1;
    $act_input_job_no_random=$schedule.date("ymd").$act_input_job_no;
    // var_dump($buffer_qty);    
    foreach($buffer_qty as $size => $excess_qty)
    {
        if($excess_qty > 0)
        {
            $retriving_size = "SELECT size_title FROM `$bai_pro3`.`recut_v2_child` rc 
            LEFT JOIN `$bai_pro3`.`recut_v2` r ON r.`doc_no` = rc.`parent_id`
            LEFT JOIN `$bai_pro3`.`rejection_log_child` rejc ON rejc.`bcd_id` = rc.`bcd_id`
            WHERE rc.parent_id = $doc_nos AND rejc.`size_id` = '$size'";
            // echo $retriving_size;
            // die();
            $res_retriving_size = $link->query($retriving_size);
            while($row_size = $res_retriving_size->fetch_assoc()) 
            {
                $size_title_ind = $row_size['size_title'];
            }
            //retreaving max input job and adding +1 to create new sewing job
            $insert_qry = "INSERT INTO `$bai_pro3`.`pac_stat_log_input_job` (`doc_no`,`size_code`,`carton_act_qty`,`input_job_no`,`input_job_no_random`,`destination`,`packing_mode`,`old_size`,`doc_type`,`type_of_sewing`,`sref_id`,`pac_seq_no`,`barcode_sequence`)
            VALUES ($doc_nos,'$size_title_ind',$excess_qty,$act_input_job_no,'$act_input_job_no_random','$destination',$packing_mode,'$size','R',2,$sref_id,$pac_seq_no,$i)";
            // echo $insert_qry;
            mysqli_query($link, $insert_qry) or exit("while Generating sewing job ".mysqli_error($GLOBALS["___mysqli_ston"]));
            $i++;
            //inserting into mo operation quantities
            $bundle_number=mysqli_insert_id($link);
            //retreaving rejected mos and filling the rejection 
            $sql121="SELECT MAX(mo_no)as mo_no FROM $bai_pro3.mo_details WHERE TRIM(size)='$size_title_ind' and 
                            TRIM(schedule)='".trim($schedule)."' and TRIM(color)='".trim($color)."' 
                            order by mo_no*1"; 
            $result121=mysqli_query($link, $sql121) or die("Mo Details not available.".mysqli_error($GLOBALS["___mysqli_ston"]));
            while($row1210=mysqli_fetch_array($result121)) 
            {
                $max_mo_no = $row1210['mo_no'];
            }
            //retreaving operations from operation mapping for style and color
            $operation_mapping_qry = "SELECT tm.operation_code,tr.operation_name FROM `$brandix_bts`.`tbl_style_ops_master` tm 
            LEFT JOIN `$brandix_bts`.`tbl_orders_ops_ref` tr ON tr.operation_code = tm.`operation_code`
            WHERE style = '$style' AND color = '$color'
            AND category = 'sewing'";
            $result_operation_mapping_qry=mysqli_query($link, $operation_mapping_qry) or die("Mo Details not available.".mysqli_error($GLOBALS["___mysqli_ston"]));
            while($ops_row=mysqli_fetch_array($result_operation_mapping_qry)) 
            {
                $ops = $ops_row['operation_code'];
                $ops_name = $ops_row['operation_name'];
                $mo_operations_insertion="INSERT INTO $bai_pro3.`mo_operation_quantites` (`date_time`, `mo_no`, `ref_no`, `bundle_quantity`, `op_code`, `op_desc`) VALUES ('".date("Y-m-d H:i:s")."', '".$max_mo_no."', '".$bundle_number."','".$excess_qty."', '".$ops."', '".$ops_name."')";
                // echo $mo_operations_insertion.'<br/>';
                $result1=mysqli_query($link, $mo_operations_insertion) or die("Error while mo_operations_insertion".mysqli_error($GLOBALS["___mysqli_ston"]));
            }
            //updating bcd and cps log
            $update_cps_qry = "update $bai_pro3.cps_log set cut_quantity = cut_quantity+$excess_qty where doc_no = $doc_nos  and size_code='$size'";
            // echo $update_cps_qry;
            mysqli_query($link, $update_cps_qry) or die("Error while update_cps_qry".mysqli_error($GLOBALS["___mysqli_ston"]));
            $update_bcd_qry = "update $brandix_bts.bundle_creation_data set original_qty=original_qty+$excess_qty,send_qty=send_qty+$excess_qty where docket_number = $doc_nos and size_id = '$size' and operation_id = 15";
            // echo $update_bcd_qry;
            mysqli_query($link, $update_bcd_qry) or die("Error while update_bcd_qry".mysqli_error($GLOBALS["___mysqli_ston"]));
            $update_bcd_qry = "update $brandix_bts.bundle_creation_data set original_qty=original_qty+$excess_qty where docket_number = $doc_nos and size_id = '$size' and operation_id <> 15";
            // echo $update_bcd_qry;
            mysqli_query($link, $update_bcd_qry) or die("Error while update_bcd_qry".mysqli_error($GLOBALS["___mysqli_ston"]));
        }   
    }
    $sql="insert into $bai_pro3.recut_track(doc_no,username,sys_name,log_time,level,status) values(\"".$doc_nos."\",\"".$username."\",\"".$hostname[0]."\",\"".date("Y-m-d H:i:s")."\",\"".$codes."\",\"".$status."\")";
    mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    $url = '?r='.$_GET['r'];
    echo "<script>sweetAlert('Successfully Markers updated','','success');window.location = '".$url."'</script>";
}
if(isset($_POST['formIssue']))
{
    $issueval = $_POST['issueval'];
    $bcd_id = $_POST['bcd_id'];
    $doc_no_ref = $_POST['doc_no_ref'];
    foreach($issueval as $key=>$value)
    {
        //retreaving remaining_qty from recut_v2_child
        $act_id = $bcd_id[$key];
        $recut_allowing_qty = $issueval[$key];
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
                //updating rejection_log_child
                $updating_rejection_log_child = "update $bai_pro3.rejection_log_child set issued_qty=issued_qty+$to_add where bcd_id = $bundle_number";
               mysqli_query($link, $updating_rejection_log_child) or exit("updating_rejection_log_child".mysqli_error($GLOBALS["___mysqli_ston"]));
                $issued_to_module = issued_to_module($bundle_number,$to_add,2);

            }
        }
    }
    $url = '?r='.$_GET['r'];
    echo "<script>sweetAlert('Successfully Issued','','success');window.location = '".$url."'</script>";
}
function issued_to_module($bcd_id,$qty,$ref)
{
    include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config_ajax.php');
    $bcd_colum_ref = "replace_in";
    if($ref == 2)
    {
        $bcd_colum_ref = "recut_in";
    }
    $bcd_qry = "select style,mapped_color,docket_number,assigned_module,input_job_no_random_ref,operation_id,bundle_number,size_id from $brandix_bts.bundle_creation_data where id = $bcd_id";
    // echo $bcd_qry;
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
    // echo $update_qry_cps.'</br>';
    mysqli_query($link, $update_qry_cps) or exit("update_qry_cps".mysqli_error($GLOBALS["___mysqli_ston"]));
    $update_qry_bcd = "update $brandix_bts.bundle_creation_data set $bcd_colum_ref = $bcd_colum_ref=$bcd_colum_ref+$qty where docket_number = $docket_no and operation_id = 15";
     mysqli_query($link, $update_qry_bcd) or exit("update_qry_bcd".mysqli_error($GLOBALS["___mysqli_ston"]));


    //retreaving emblishment operations from operatoin master
    $ops_master_qry = "select operation_code from $brandix_bts.tbl_orders_ops_ref where category in ('Send PF')"; 
    $result_ops_master_qry = $link->query($ops_master_qry);
    while($row_ops = $result_ops_master_qry->fetch_assoc()) 
    {
       $emb_ops[] = $row_ops['operation_code'];
    }

    $qry_ops_mapping = "select operation_code from $brandix_bts.tbl_style_ops_master where style='$style' and color='$mapped_color' and  operation_code in (".implode(',',$emb_ops).")";
    // echo $qry_ops_mapping;
    $result_qry_ops_mapping = $link->query($qry_ops_mapping);
    if(mysqli_num_rows($result_qry_ops_mapping) > 0)
    {
        while($row_emb = $result_qry_ops_mapping->fetch_assoc()) 
        {
            $emb_input_ops_code = $row_emb['operation_code'];

            //updating bcd for emblishment in operation 
            $update_bcd_for_emb_qry = "update $brandix_bts.bundle_creation_data set $bcd_colum_ref = $bcd_colum_ref + $qty where docket_number = $docket_no and operation_id = $emb_input_ops_code and size_id = '$size_id'";
            // echo $update_bcd_for_emb_qry;
            mysqli_query($link, $update_bcd_for_emb_qry) or exit("update_bcd_for_emb_qry".mysqli_error($GLOBALS["___mysqli_ston"]));

            //updating embellishment_plan_dashboard
            $update_plan_dashboard_qry = "UPDATE `$bai_pro3`.`embellishment_plan_dashboard` SET send_qty = send_qty+$qty WHERE doc_no = $docket_no AND send_op_code = $emb_input_ops_code";
            // echo $update_plan_dashboard_qry;
            mysqli_query($link, $update_plan_dashboard_qry) or exit("update_plan_dashboard_qry".mysqli_error($GLOBALS["___mysqli_ston"]));
        }
    }
    else
    {
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
                $insert_qry_ips = "INSERT IGNORE INTO `$bai_pro3`.`plan_dashboard_input` 
                SELECT * FROM `$bai_pro3`.`plan_dashboard_input_backup`
                WHERE input_job_no_random_ref = '$input_job_no_random_ref'";
                mysqli_query($link, $insert_qry_ips) or exit("insert_qry_ips".mysqli_error($GLOBALS["___mysqli_ston"]));
            }
            $input_ops_code=echo_title("$brandix_bts.tbl_ims_ops","operation_code","appilication",'IPS',$link);
            // $qry_ops_mapping_after = "SELECT of.operation_code FROM `$brandix_bts`.`tbl_style_ops_master` tm 
            // LEFT JOIN brandix_bts.`tbl_orders_ops_ref` of ON of.`operation_code`=tm.`operation_code`
            // WHERE tm.`style` ='$style' AND tm.`color` = '$mapped_color'
            // AND category = 'sewing'";
            // // echo $qry_ops_mapping_after;
            // $result_qry_ops_mapping_after = $link->query($qry_ops_mapping_after);
            // if(mysqli_num_rows($result_qry_ops_mapping_after) > 0)
            // {
            //     while($ops_post = $result_qry_ops_mapping_after->fetch_assoc()) 
            //     {
            //         $input_ops_code = $ops_post['operation_code'];
                    $update_qry_bcd_input = "update $brandix_bts.bundle_creation_data set $bcd_colum_ref=$bcd_colum_ref+$qty where bundle_number = $bundle_number and operation_id = $input_ops_code";
                    // echo $update_qry_bcd_input;
                    mysqli_query($link, $update_qry_bcd_input) or exit("update_qry_bcd".mysqli_error($GLOBALS["___mysqli_ston"]));
            //     }
            // }
        }  
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
                <button type="button" class="close"  id = "cancel" data-dismiss="modal">&times;</button>
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
                <button type="button" class="close"  id = "cancel" data-dismiss="modal">&times;</button>
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
                <button type="button" class="close"  id = "cancel" data-dismiss="modal">&times;</button>
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
           <table class = 'col-sm-12 table-bordered table-striped table-condensed' id='myTable'><thead><th>S.No</th><th>Recut Docket Number</th><th>Style</th><th>Schedule</th><th>Color</th><th>Rejected quantity</th><th>Recut Raised Quantity</th><th>Recut Reported Quantity</th><th>Issued Quantity</th><th>Remaining Quantity</th><th>View</th><th>Issue</th>
            </thead>
            <?php  
            $s_no = 1;
            $blocks_query  = "SELECT SUM(rejected_qty)as rejected_qty,parent_id as doc_no,SUM(recut_qty)as recut_qty,SUM(recut_reported_qty) as recut_reported_qty,SUM(issued_qty)as issued_qty,r.`mk_ref`,b.`style_id`AS style,b.`order_col_des` AS color,b.`order_del_no` as schedule,fabric_status
            FROM `$bai_pro3`.`recut_v2_child` rc 
            LEFT JOIN $bai_pro3.`recut_v2` r ON r.doc_no = rc.`parent_id`
            LEFT JOIN $bai_pro3.`bai_orders_db` b ON b.order_tid = r.`order_tid`
            WHERE remarks in ($in_categories)
            GROUP BY parent_id";
            // echo $blocks_query;
            $blocks_result = mysqli_query($link,$blocks_query) or exit('Rejections Log Data Retreival Error');
            if($blocks_result->num_rows > 0)
            {
                while($row = mysqli_fetch_array($blocks_result))
                {
                    $id = $row['doc_no'];
                    $rem_qty = $row['recut_reported_qty'] - $row['issued_qty'];
                    if($row['mk_ref'] == '0')
                    {
                        $button_html = "<button type='button'class='btn btn-danger' onclick='editmarkers(".$id.")'>Update Markers</button>";
                        $html_hiding = "UpdateMarkers";
                    }
                    else if($row['fabric_status'] == '0')
                    {
                        $button_html = "Markers updated and Waiting for Approval";
                        $html_hiding = "WaitingForApproval";
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
                    echo "<tr><td>$s_no</td>";
                    echo "<td>".$row['doc_no']."</td>";
                    echo "<td>".$row['style']."</td>";
                    echo "<td>".$row['schedule']."</td>";
                    echo "<td>".$row['color']."</td>";
                    echo "<td>".$row['rejected_qty']."</td>";
                    echo "<td>".$row['recut_qty']."</td>";
                    echo "<td>".$row['recut_reported_qty']."</td>";
                    echo "<td>".$row['issued_qty']."</td>";
                    echo "<td>".$rem_qty."</td>";
                    echo "<td><button type='button'class='btn btn-primary' onclick='viewrecutdetails(".$id.")'>View</button></td>";
                    echo "<td style='display:none'>$html_hiding</td>"; 
                    echo "<td>$button_html</td>"; 
                    echo "</tr>";
                    $s_no++;
                }
            }
            else
            {
                echo "<tr><td colspan='12' style='color:red;text-align: center;'><b>No Details Found!!!</b></td></tr>";
            }
            ?>
             </table>
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
        }
        if(value == 0)
        {
            swal('Atlease one ratio should be there.','','error');
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
    if(document.getElementById('setreset').innerHTML == 'Set')
    {
        for(var i=1; i<=Number(noofrows); i++)
        {
            var rem_var = i+'rems';
            console.log(rem_var);
            var remaining_qty = document.getElementById(rem_var).innerHTML;
            document.getElementById(i).value = remaining_qty; 
        }
        document.getElementById('setreset').innerHTML = 'ReSet';
    }
    else
    {
        for(var i=1; i<=Number(noofrows); i++)
        {
            document.getElementById(i).value = 0; 
        }
        document.getElementById('setreset').innerHTML = 'Set';

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
    // alert();
    if(t.value < 0 || t.value =='e' || t.value == 'E')
    { 
        return false; 
    }
}
</script>