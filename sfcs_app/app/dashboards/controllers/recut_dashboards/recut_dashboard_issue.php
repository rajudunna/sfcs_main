<?php
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config_ajax.php');
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/mo_filling.php');
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
    $size = $_POST['size'];
    $ratioval =$_POST['ratioval'];
	$codes='2';
    $docket_no = '';
    $query="SELECT* FROM $bai_pro3.`cuttable_stat_log` WHERE order_tid='$order_tid'";
    $sql_result111=mysqli_query($link, $query) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    while($sql_row111=mysqli_fetch_array($sql_result111))
    {
        $tid=$sql_row111['tid'];
    }
    $sql1="insert into $bai_pro3.maker_stat_log(date,cat_ref,order_tid,mklength) values (\"".date("Y-m-d")."\",".$cat[$i].",\"$order_tid\",".$mklen[$i].")";
    mysqli_query($link, $sql1) or exit("Sql Error3".mysqli_error($GLOBALS["___mysqli_ston"]));
    $ilastid=((is_null($___mysqli_res = mysqli_insert_id($link))) ? false : $___mysqli_res);


    $sql1="update $bai_pro3.recut_v2 set p_plies=".$plies[$i].",a_plies=".$plies[$i].",mk_ref=$ilastid where doc_no=".$doc_nos;
    // echo $sql1;
    mysqli_query($link, $sql1) or exit("Sql Error45".mysqli_error($GLOBALS["___mysqli_ston"]));

    //retreaving actual quantity to recut
    $qry_cut_qty_check_qry = "SELECT * FROM $bai_pro3.recut_v2 WHERE doc_no = '$doc_nos' ";
	$result_qry_cut_qty_check_qry = $link->query($qry_cut_qty_check_qry);
	while($row = $result_qry_cut_qty_check_qry->fetch_assoc()) 
	{
		for ($i=0; $i < sizeof($sizes_array); $i++)
		{ 
			if ($row['a_'.$sizes_array[$i]] > 0)
			{
				$cut_done_qty[$sizes_array[$i]] = $row['a_'.$sizes_array[$i]] * $row['a_plies'];
			}
		}
	}
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
    foreach($buffer_qty as $size => $excess_qty)
    {
        if($excess_qty > 0)
        {
            $retriving_size = "SELECT size_title FROM `bai_pro3`.`recut_v2_child` rc 
            LEFT JOIN `bai_pro3`.`recut_v2` r ON r.`doc_no` = rc.`parent_id`
            LEFT JOIN `bai_pro3`.`rejection_log_child` rejc ON rejc.`bcd_id` = rc.`bcd_id`
            WHERE rc.parent_id = $doc_nos AND rejc.`size_id` = '$size'";
            // echo $retriving_size;
            // die();
            $res_retriving_size = $link->query($retriving_size);
            while($row_size = $res_retriving_size->fetch_assoc()) 
            {
                $size_title_ind = $row_size['size_title'];
            }
            //retreaving max input job and adding +1 to create new sewing job
        //  $retreaving_last_sewing_job_qry = "SELECT MAX(input_job_no_random)as input_job_no_random,input_job_no,destination,packing_mode,sref_id FROM `bai_pro3`.`packing_summary_input` WHERE order_style_no = '$style' AND order_del_no = '$schedule' AND order_col_des = '$color'";
        $retreaving_last_sewing_job_qry = "SELECT * FROM `bai_pro3`.`packing_summary_input` WHERE order_style_no = 'JJP174F8' AND order_del_no = '528110' AND order_col_des = '69-NAVY-FLANNELBOTTOM'";
            $res_retreaving_last_sewing_job_qry = $link->query($retreaving_last_sewing_job_qry);
            while($row_sj = $res_retreaving_last_sewing_job_qry->fetch_assoc()) 
            {   
                $input_job_no = $row_sj['input_job_no'];
                $input_job_no_random = $row_sj['input_job_no_random'];
                $destination = $row_sj['destination'];
                $packing_mode = $row_sj['packing_mode'];
                // $sref_id = $row_sj['sref_id'];
                $sref_id = '1';
            }
            $act_input_job_no = $input_job_no+1;
            $act_input_job_no_random = $input_job_no_random+1;
            $insert_qry = "INSERT INTO `bai_pro3`.`pac_stat_log_input_job` (`doc_no`,`size_code`,`carton_act_qty`,`input_job_no`,`input_job_no_random`,`destination`,`packing_mode`,`old_size`,`doc_type`,`type_of_sewing`,`sref_id`,`pac_seq_no`,`barcode_sequence`)
            VALUES ($doc_nos,'$size_title_ind',$excess_qty,$act_input_job_no,'$act_input_job_no_random','$destination',$packing_mode,'$size','R',2,$sref_id,0,$i)";
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
            $operation_mapping_qry = "SELECT tm.operation_code,tr.operation_name FROM `brandix_bts`.`tbl_style_ops_master` tm 
            LEFT JOIN `brandix_bts`.`tbl_orders_ops_ref` tr ON tr.operation_code = tm.`operation_code`
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

        }
    }
    $sql="insert into $bai_pro3.recut_track(doc_no,username,sys_name,log_time,level,status) values(\"".$doc_nos."\",\"".$username."\",\"".$hostname[0]."\",\"".date("Y-m-d H:i:s")."\",\"".$codes."\",\"".$status."\")";
    mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    // calling the function to insert to bundle craetion data and cps log
    $inserted = doc_size_wise_bundle_insertion($doc_nos);
    if($inserted){
    	//Inserted Successfully
    }
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
        $retreaving_bcd_data = "SELECT * FROM `brandix_bts`.`bundle_creation_data` WHERE id IN ($act_id) ORDER BY barcode_sequence";
        $retreaving_bcd_data_res = $link->query($retreaving_bcd_data);
        while($row_bcd = $retreaving_bcd_data_res->fetch_assoc()) 
        {
            $bcd_individual = $row_bcd['bundle_number'];
            $bundle_number = $row_bcd['id'];
            $operation_id = $row_bcd['operation_id'];
            $retreaving_rej_qty = "SELECT * FROM `bai_pro3`.`recut_v2_child` where bcd_id = $bundle_number and parent_id = '$doc_no_ref'";
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
                issued_to_module($bundle_number,$to_add,2);

            }
        }
    }
    // die();
    $url = '?r='.$_GET['r'];
    echo "<script>sweetAlert('Successfully Approved','','success');window.location = '".$url."'</script>";
}
function issued_to_module($bcd_id,$qty,$ref)
{
    include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config_ajax.php');
    include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/functions.php');
    $bcd_colum_ref = "replace_in";
    if($ref == 2)
    {
        $bcd_colum_ref = "recut_in";
    }
    $bcd_qry = "select style,mapped_color,docket_number,assigned_module,input_job_no_random_ref,operation_id,bundle_number from brandix_bts.bundle_creation_data where id = $bcd_id";
    $result_bcd_qry = $link->query($bcd_qry);
    while($row = $result_bcd_qry->fetch_assoc()) 
    {
        $style = $row['style'];
        $mapped_color = $row['mapped_color'];
        $docket_no = $row['docket_number'];
        $input_job_no_random_ref = $row['input_job_no_random_ref'];
        $ops_code = $row['operation_id'];
        $bundle_number = $row['bundle_number'];
    }
    //updating cps log and bts
    $update_qry_cps = "update bai_pro3.cps_log set remaining_qty = remaining_qty+$qty where doc_no = $docket_no and operation_code = 15";
    mysqli_query($link, $update_qry_cps) or exit("update_qry_cps".mysqli_error($GLOBALS["___mysqli_ston"]));
    $update_qry_bcd = "update brandix_bts.bundle_creation_data set $bcd_colum_ref = $bcd_colum_ref=$bcd_colum_ref+$qty where docket_number = $docket_no and operation_id = 15";
     mysqli_query($link, $update_qry_bcd) or exit("update_qry_bcd".mysqli_error($GLOBALS["___mysqli_ston"]));


    //retreaving emblishment operations from operatoin master
    $ops_master_qry = "select operation_code from brandix_bts.tbl_orders_ops_ref where category in ('Send PF')"; 
    $result_ops_master_qry = $link->query($ops_master_qry);
    while($row_ops = $result_ops_master_qry->fetch_assoc()) 
    {
       $emb_ops[] = $row_ops['operation_code'];
    }

    $qry_ops_mapping = "select operation_code from brandix_bts.tbl_style_ops_master where style='$style' and color='$mapped_color' and  operation_code in (".implode(',',$emb_ops).")";
    $result_qry_ops_mapping = $link->query($qry_ops_mapping);
    if(mysqli_num_rows($result_qry_ops_mapping) > 0)
    {
        while($row_emb = $result_qry_ops_mapping->fetch_assoc()) 
        {
            $emb_input_ops_code = $row_emb['operation_code'];

            //updating bcd for emblishment in operation 
            $update_bcd_for_emb_qry = "update brandix_bts.bundle_creation_data set $bcd_colum_ref = $bcd_colum_ref + $qty where docket_number = $docket_no and operation_id = $emb_input_ops_code";
            mysqli_query($link, $update_bcd_for_emb_qry) or exit("update_bcd_for_emb_qry".mysqli_error($GLOBALS["___mysqli_ston"]));

            //updating embellishment_plan_dashboard
            $update_plan_dashboard_qry = "UPDATE `bai_pro3`.`embellishment_plan_dashboard` SET send_qty = send_qty+$qty WHERE doc_no = $docket_no AND send_op_code = $emb_input_ops_code";
            mysqli_query($link, $update_plan_dashboard_qry) or exit("update_plan_dashboard_qry".mysqli_error($GLOBALS["___mysqli_ston"]));
        }
    }
    else
    {
        $emb_cut_check_flag = 0;
        //checking the ips having that input job or not
        $category=['cutting','Send PF','Receive PF'];
        $checking_qry = "SELECT category FROM `brandix_bts`.`tbl_orders_ops_ref` WHERE operation_code = $ops_code";
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
            $checking_qry_plan_dashboard = "SELECT * FROM `bai_pro3`.`plan_dashboard_input` WHERE input_job_no_random_ref = '$input_job_no_random_ref'";
            $result_checking_qry_plan_dashboard = $link->query($checking_qry_plan_dashboard);
            if(mysqli_num_rows($result_checking_qry_plan_dashboard) == 0)
            {   
                $insert_qry_ips = "INSERT IGNORE INTO `bai_pro3`.`plan_dashboard_input` 
                SELECT * FROM `bai_pro3`.`plan_dashboard_input_backup`
                WHERE input_job_no_random_ref = '$input_job_no_random_ref'";
                mysqli_query($link, $insert_qry_ips) or exit("insert_qry_ips".mysqli_error($GLOBALS["___mysqli_ston"]));
            }
            $input_ops_code=echo_title("$brandix_bts.tbl_ims_ops","operation_code","appilication",'IPS',$link);
            $update_qry_bcd_input = "update brandix_bts.bundle_creation_data set $bcd_colum_ref = $bcd_colum_ref=$bcd_colum_ref+$qty where bundle_number = $bundle_number and operation_id = $input_ops_code";
            mysqli_query($link, $update_qry_bcd_input) or exit("update_qry_bcd".mysqli_error($GLOBALS["___mysqli_ston"]));
        }   
    }
}
$shifts_array = ["IssueToModule","AlreadyIssued","WaitingForApproval","UpdateMarkers"];
$drp_down = '<div class="row"><div class="col-md-3"><label>Filter:</label>
<select class="form-control rm"  name="status" id="rm" style="width:100%;" onchange="myFunction()" required>';
for ($i=0; $i <= 3; $i++) 
{
    $drp_down .= '<option value='.$shifts_array[$i].'>'.$shifts_array[$i].'</option>';
}
$drp_down .= "</select></div></div>";
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
                <form action="index.php?r=<?php echo $_GET['r']?>" name= "smartform" method="post" id="smartform">
                    <div class='panel-body' id="dynamic_table_panel">	
                            <div id ="dynamic_table1"></div>
                    </div>
                    <p style='color:red;'>Note:The excess quantity will create as excess sewing job for respective style,schedule and color.</p>
                    <div class="pull-right"><input type="submit" class="btn btn-primary" value="Submit" name="formSubmit"></div>
                </form>
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
                <form action="index.php?r=<?php echo $_GET['r']?>" name= "smartform" method="post" id="smartform">
                    <div class='panel-body' id="dynamic_table_panel">	
                            <div id ="dynamic_table2"></div>
                    </div>
                    <div class="pull-right"><input type="submit" class="btn btn-primary" value="Submit" name="formIssue"></div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class='row'>
    <div class='panel panel-primary'>
        <div class='panel-heading'>
            <b>Re Cut Issue Dashboard - View</b>
        </div>
        <div class='panel-body'>
           <table class = 'col-sm-12 table-bordered table-striped table-condensed' id='myTable'><thead><th>S.No</th><th>Docket Number</th><th>Style</th><th>Schedule</th><th>Color</th><th>Rejected quantity</th><th>Recut Allowed Quantity</th><th>Recut Reported Quantity</th><th>Issued Quantity</th><th>Remaining Quantity</th><th>View</th><th>Issue</th>
            </thead>
            <?php  
            $s_no = 1;
            $blocks_query  = "SELECT SUM(rejected_qty)as rejected_qty,parent_id as doc_no,SUM(recut_qty)as recut_qty,SUM(recut_reported_qty) as recut_reported_qty,SUM(issued_qty)as issued_qty,r.`mk_ref`,b.`style_id`AS style,b.`order_col_des` AS color,b.`order_del_no` as schedule
            FROM `bai_pro3`.`recut_v2_child` rc 
            LEFT JOIN bai_pro3.`recut_v2` r ON r.doc_no = rc.`parent_id`
            LEFT JOIN bai_pro3.`bai_orders_db` b ON b.order_tid = r.`order_tid`
            GROUP BY parent_id";
            $blocks_result = mysqli_query($link,$blocks_query) or exit('Rejections Log Data Retreival Error');        
            while($row = mysqli_fetch_array($blocks_result))
            {
                $id = $row['doc_no'];
                $rem_qty = $row['recut_reported_qty'] - $row['issued_qty'];
                if($rem_qty == 0)
                {
                    $button_html = "<b style='color:red;'>Already issued</b>";
                    $html_hiding = "AlreadyIssued";
                }
                else if($row['mk_ref'] == '0' && $rem_qty <> 0)
                {
                    $button_html = "<button type='button'class='btn btn-danger' onclick='editmarkers(".$id.")'>Update Markers</button>";
                    $html_hiding = "UpdateMarkers";
                }
                else if($row['approval_status'] == '0')
                {
                    $button_html = "Markers updated and Waiting for Approval";
                    $html_hiding = "WaitingForApproval";
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
    myFunction();
});
function viewrecutdetails(id)
{
    var function_text = "<?php echo getFullURL($_GET['r'],'functions_recut.php','R'); ?>";
    $.ajax({

			type: "POST",
			url: function_text+"?recut_doc_id="+id,
			//dataType: "json",
			success: function (response) 
			{
                document.getElementById('main-content').innerHTML = response;
                $('#myModal').modal('toggle');
            }

    });

}
function editmarkers(id)
{
    var function_text = "<?php echo getFullURL($_GET['r'],'functions_recut.php','R'); ?>";
    $.ajax({

			type: "POST",
			url: function_text+"?markers_update_doc_id="+id,
			//dataType: "json",
			success: function (response) 
			{
                document.getElementById('dynamic_table1').innerHTML = response;
                $('#myModal1').modal('toggle');
            }

    });

}
function issuemodule(id)
{
    var function_text = "<?php echo getFullURL($_GET['r'],'functions_recut.php','R'); ?>";
    $.ajax({

			type: "POST",
			url: function_text+"?issued_to_module_process="+id,
			//dataType: "json",
			success: function (response) 
			{
                document.getElementById('dynamic_table2').innerHTML = response;
                $('#myModal2').modal('toggle');
            }

    });
}
function validatingremaining(sno)
{
    var remaining_qty_var = sno+"rem";
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
    if(count == 1)
    {
        $('#myTable').hide();
        $('#myTable1').show();
    }
    else
    {
        $('#myTable').show();
        $('#myTable1').hide();
    }
}
</script>