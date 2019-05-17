<?php
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config_ajax.php');
error_reporting(0);
if(isset($_POST['approve']))
{
    // die();
   $order_tid=$_POST['order_tid'];
   $status=99;
   $doc_nos=$_POST['doc_no_ref'];
   
   //getting style and schedule 
   $qry_cut_qty_check_qry = "SELECT bd.`order_style_no`,bd.`order_col_des`,bd.`order_del_no` FROM $bai_pro3.recut_v2 rv LEFT JOIN $bai_pro3.`bai_orders_db` bd ON bd.`order_tid` = rv.`order_tid`  WHERE doc_no = $doc_nos";
   $result_qry_cut_qty_check_qry = $link->query($qry_cut_qty_check_qry);
   while($row = $result_qry_cut_qty_check_qry->fetch_assoc()) 
   {
       $style = $row['order_style_no'];
       $schedule = $row['order_del_no'];
       $color = $row['order_col_des'];

   }
    //    if($schedule != ''){
    //         $sewing_job_validation = "SELECT doc_no from $bai_pro3.packing_summary_input where order_del_no = '$schedule'";
    //         if(mysqli_num_rows(mysqli_query($link,$sewing_job_validation)) == 0){
    //                 $url = '?r='.$_GET['r'];
    //                 echo "<script>sweetAlert('Please Prepare Sewing Jobs for this Schedule','','warning');window.location = '".$url."'</script>";
    //                 exit();
    //         } 
    //     }
    
    $codes=$_POST['code_no_ref'];
    $hostname=explode(".",gethostbyaddr($_SERVER['REMOTE_ADDR']));
    $add_query=", lastup=\"".date("Y-m-d H:i:s")."\" ";
    $sql1="update $bai_pro3.recut_v2 set fabric_status=$status $add_query where doc_no = '$doc_nos'";
    mysqli_query($link, $sql1) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
    $sql2="update $bai_pro3.plandoc_stat_log set fabric_status=$status $add_query where doc_no = '$doc_nos'";
    mysqli_query($link, $sql2) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
    $sql="insert into $bai_pro3.recut_track(doc_no,username,sys_name,log_time,level,status) values(\"".$doc_nos."\",\"".$username."\",\"".$hostname[0]."\",\"".date("Y-m-d H:i:s")."\",\"".$codes."\",\"".$status."\")";
    //echo $sql;
    mysqli_query($link, $sql) or exit("Sql Error3".mysqli_error($GLOBALS["___mysqli_ston"]));

    //excess sewing job generation
    $qry_cut_qty_check_qry = "SELECT SUM(recut_qty)as recut_qty,size_id FROM $bai_pro3.`recut_v2_child` WHERE parent_id = $doc_nos group by size_id";
        $result_qry_cut_qty_check_qry = $link->query($qry_cut_qty_check_qry);
        while($row = $result_qry_cut_qty_check_qry->fetch_assoc()) 
        {
            $size_code = $row['size_id'];
            $qty_ration = $row['recut_qty'];
            $cut_done_qty[$size_code] = $qty_ration;
        }
        //retreaving buffer qty
        $qry_cut_qty_check_qry = "SELECT * FROM $bai_pro3.recut_v2 WHERE doc_no = '$doc_nos' ";
        $result_qry_cut_qty_check_qry = $link->query($qry_cut_qty_check_qry);
        while($row = $result_qry_cut_qty_check_qry->fetch_assoc()) 
        {
            for ($i=0; $i < sizeof($sizes_array); $i++)
            { 
                if ($row['a_'.$sizes_array[$i]] > 0)
                {
                    $act_qty = $row['a_'.$sizes_array[$i]] * $row['a_plies'];
                    $buffer_qty[$sizes_array[$i]] = $act_qty - $cut_done_qty[$sizes_array[$i]];
                    
                }
            }
        }
    $retreaving_last_sewing_job_qry = "SELECT MAX(input_job_no_random)as input_job_no_random,MAX(CAST(input_job_no AS DECIMAL)) as input_job_no,destination,packing_mode,sref_id,pac_seq_no FROM `$bai_pro3`.`packing_summary_input` WHERE order_style_no = '$style' AND order_del_no = '$schedule'";
        $res_retreaving_last_sewing_job_qry = $link->query($retreaving_last_sewing_job_qry);
        if($res_retreaving_last_sewing_job_qry->num_rows > 0)
        {
            while($row_sj = $res_retreaving_last_sewing_job_qry->fetch_assoc()) 
            {   
                $input_job_no = $row_sj['input_job_no'];
                // $input_job_no_random = $row_sj['input_job_no_random'];
                $destination = $row_sj['destination'];
                $packing_mode = $row_sj['packing_mode'];
                $pac_seq_no = $row_sj['pac_seq_no'];
                // $sref_id = $row_sj['sref_id'];
                $sref_id = '0';
            }
        }
        if($pac_seq_no == '' || $pac_seq_no == null)
        {
            $input_job_no = 0;
            $sql2="select group_concat(distinct trim(destination)) as dest,order_style_no as style,GROUP_CONCAT(DISTINCT order_col_des separator '<br/>') as color,order_po_no as cpo,order_date,vpo from $bai_pro3.bai_orders_db where order_del_no in (".$schedule.") and order_col_des=\"".$color."\""; 
            // echo $sql2; 
            $result2=mysqli_query($link, $sql2) or die("Error-".$sql2."-".mysqli_error($GLOBALS["___mysqli_ston"])); 
            while($sql_row2=mysqli_fetch_array($result2)) 
            { 
                //$destination=$sql_row2["dest"]; 
                $destination = $row_sj['dest'];
                $packing_mode = 0;
                $pac_seq_no = 0;
                $sref_id = '0';
            }
        }
        $act_input_job_no = $input_job_no+1;
        $act_input_job_no_random=$schedule.date("ymd").$act_input_job_no;
        $i=0;
        foreach($buffer_qty as $size => $excess_qty)
        {
            $i++;
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
            // $i++;   
        }
        $url = '?r='.$_GET['r'];
        echo "<script>sweetAlert('Successfully Approved','','success');window.location = '".$url."'</script>";
  
}
if(isset($_POST['reject']))
{
    $doc_no = $_POST['doc_no'];
    $a_sizes = '';
    $p_sizes = '';
    $ratio = '';
    $qry_cut_qty_check_qry = "SELECT SUM(recut_qty)as recut_qty,size_id FROM $bai_pro3.`recut_v2_child` WHERE parent_id = $doc_no group by size_id";
	$result_qry_cut_qty_check_qry = $link->query($qry_cut_qty_check_qry);
	while($row = $result_qry_cut_qty_check_qry->fetch_assoc()) 
	{
        $size_code = $row['size_id'];
        $act_ratio = $row['recut_qty'];
        $update_qry = "update $bai_pro3.recut_v2 set a_$size_code=$act_ratio,p_$size_code=$act_ratio where doc_no = $doc_no";
        mysqli_query($link, $update_qry) or exit("Updating recut_v2 for rejected docket".mysqli_error($GLOBALS["___mysqli_ston"]));
        $update_qry = "update $bai_pro3.plandoc_stat_log set a_$size_code=$act_ratio,p_$size_code=$act_ratio where doc_no = $doc_no";
        mysqli_query($link, $update_qry) or exit("Updating recut_v2 for rejected docket".mysqli_error($GLOBALS["___mysqli_ston"]));
        $cut_done_qty[$row['size_id']] = $act_ratio;
        $update_cps_log_qry = "update $bai_pro3.cps_log set cut_quantity = $act_ratio where doc_no = $doc_no and size_code = '$size_code'";
        mysqli_query($link, $update_cps_log_qry) or exit("Updating recut_v2 for rejected docket".mysqli_error($GLOBALS["___mysqli_ston"]));
        $update_bcd_qry="update $brandix_bts.bundle_creation_data set original_qty = $act_ratio,send_qty=$act_ratio where docket_number = $doc_no and size_id = '$size_code' and operation_id = 15";
        mysqli_query($link, $update_bcd_qry) or exit("Updating recut_v2 for rejected docket".mysqli_error($GLOBALS["___mysqli_ston"]));
        $update_bcd_qry="update $brandix_bts.bundle_creation_data set original_qty = $act_ratio where docket_number = $doc_no and size_id = '$size_code' and operation_id <> 15";
        mysqli_query($link, $update_bcd_qry) or exit("Updating recut_v2 for rejected docket".mysqli_error($GLOBALS["___mysqli_ston"]));
    }
    $update_qry = "update $bai_pro3.recut_v2 set mk_ref = '0',a_plies=1,p_plies=1 where doc_no = $doc_no";
    mysqli_query($link, $update_qry) or exit("Updating recut_v2 for rejected docket".mysqli_error($GLOBALS["___mysqli_ston"]));
    $update_qry = "update $bai_pro3.plandoc_stat_log set mk_ref = '0',a_plies=1,p_plies=1 where doc_no = $doc_no";
    mysqli_query($link, $update_qry) or exit("Updating recut_v2 for rejected docket".mysqli_error($GLOBALS["___mysqli_ston"]));
    //deleting moq
    $delete_qry_moq = "DELETE FROM $bai_pro3.`mo_operation_quantites` WHERE ref_no IN (SELECT tid FROM $bai_pro3.pac_stat_log_input_job WHERE doc_no = $doc_no)";
    mysqli_query($link, $delete_qry_moq) or exit("deleting delete_qry_moq".mysqli_error($GLOBALS["___mysqli_ston"]));
    //deleting from cps
    $delete_qry = "delete from $bai_pro3.pac_stat_log_input_job where doc_no = $doc_no";
    mysqli_query($link, $delete_qry) or exit("deleting Excess sewing jobs".mysqli_error($GLOBALS["___mysqli_ston"]));
    $url = '?r='.$_GET['r'];
    echo "<script>sweetAlert('Docket Successfully Rejected','','error');window.location = '".$url."'</script>";

}
?>
<?php
$shifts_array = ["NotApproved","Approved"];
$drp_down = '<div class="row"><div class="col-md-3"><label>Status Filter:</label>
<select class="form-control rm"  name="status" id="rm" style="width:100%;" onchange="myFunction()" required>';
for ($i=0; $i <= 1; $i++) 
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
    <form action="index.php?r=<?php echo $_GET['r']?>" name= "approve" method="post" id="approve" onsubmit='return validationfunction();'>
        <div class="modal-dialog" style="width: 80%;  height: 100%;">
            <div class="modal-content">
                <div class="modal-header">Markers view
                <button type="button" class="btn btn-danger" value="Close" id = "cancel" data-dismiss="modal" style="float: right;">Close</button>
                </div>
                <div id='pre'>
                    <div class="modal-body">
                        <div class='panel-body' id="dynamic_table_panel">
                            <div class="ajax-loader" class="loading-image" style="margin-left: 45%;margin-top: 35px;border-radius: -80px;width: 88px;display:none;">
                                        <img src='<?= getFullURLLevel($_GET['r'],'ajax-loader.gif',0,'R'); ?>' class="img-responsive" />
                            </div>
                            <div id ="dynamic_table1"></div>
                            <p style='color:red;'>Note:The excess quantity will create as excess sewing job for respective style,schedule and color.</p>
                        </div>
                    </div>
                </div>
                <div id='post' style='display:none;'>
                    <div class='panel-body'>	
                            <h2 style='color:red'>Please wait while Approving!!!</h2>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<div class='row'>
    <form action="index.php?r=<?php echo $_GET['r']?>" name= "smartform" method="post" id="smartform">
        <div class='panel panel-primary'>
            <div class='panel-heading'>
                <b>ReCut Approval Dashboard - View</b>
            </div>
            <div class='panel-body'>
            <table class = 'col-sm-12 table-bordered table-striped table-condensed' id='myTable'><thead><th>S.No</th><th>Recut Docket Number</th><th>Style</th><th>Schedule</th><th>Color</th><th>Category</th><th>Rejected quantity</th><th>Recut Quantity</th><th>Recut Reported Quantity</th><th>Eligibility to Issue Quantity</th><th>View recut</th><th>Markers view</th><th>Approve</th><th>Reject</th>
                </thead>
                <?php  
                $s_no = 1;
                $blocks_query  = "SELECT fabric_status,SUM(rejected_qty)as rejected_qty,parent_id as doc_no,SUM(recut_qty)as recut_qty,SUM(recut_reported_qty) as recut_reported_qty,SUM(issued_qty)as issued_qty,r.`mk_ref`,b.`order_style_no`AS style,b.`order_col_des` AS color,b.`order_del_no` as schedule,remarks as category
                FROM `$bai_pro3`.`recut_v2_child` rc 
                LEFT JOIN $bai_pro3.`recut_v2` r ON r.doc_no = rc.`parent_id`
                LEFT JOIN $bai_pro3.`bai_orders_db` b ON b.order_tid = r.`order_tid`
                WHERE r.mk_ref != '0' and fabric_status <> '99'
                GROUP BY parent_id";
                $blocks_result = mysqli_query($link,$blocks_query) or exit('Rejections Log Data Retreival Error');
                if($blocks_result->num_rows > 0)
                {   
                    echo "<input type='hidden' name='doc_no' id = 'doc_no_org'>"; 
                    while($row = mysqli_fetch_array($blocks_result))
                    {
                        $id = $row['doc_no'];
                        if($row['fabric_status'] == '99')
                        {
                            $button_html = "<b style='color:red;'>Approved</b>";
                            $html_hiding = "Approved";
                            $button_html_rej = "";
                        }
                        else
                        {
                            $button_html = "<button type='button' class='btn btn-success' onclick='viewmarkerdetails(".$id.",1)'>Approve</button>";
                            $html_hiding = "NotApproved";
                            $button_html_rej = "<button type='submit' id='rej$id' class='btn btn-danger confirm-submit' name='reject' onclick='submitfunction($id);'>Reject</button>";
                        }
                        echo "<tr><td>$s_no</td>";
                        echo "<td>".$row['doc_no']."</td>";
                        echo "<td>".$row['style']."</td>";
                        echo "<td>".$row['schedule']."</td>";
                        echo "<td>".$row['color']."</td>";
                        echo "<td>".$row['category']."</td>";
                        echo "<td>".$row['rejected_qty']."</td>";
                        echo "<td>".$row['recut_qty']."</td>";
                        echo "<td>".$row['recut_reported_qty']."</td>";
                        echo "<td>".$row['issued_qty']."</td>";
                        echo "<td><button type='button'class='btn btn-primary' onclick='viewrecutdetails(".$id.")'>Recut View</button></td>";
                        echo "<td><button type='button'class='btn btn-success' onclick='viewmarkerdetails(".$id.",2)'>Marker View</button></td>";
                        echo "<td style='display:none'>$html_hiding</td>"; 
                        echo "<td>$button_html</td>";
                        echo "<td>$button_html_rej</td>";
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
            </div>
        </div>
    </form>
</div>
<script>
$(document).ready(function() 
{
    // myFunction();
    $('#post').hide();
});
function validationfunction()
{
    // alert();
    $('#pre').hide();
    $('#post').show();
    return true;
}
function viewrecutdetails(id)
{
    var function_text = "<?php echo getFullURL($_GET['r'],'functions_recut.php','R'); ?>";
    $('#myModal').modal('toggle');
    $('.loading-image').show();
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
function viewmarkerdetails(id,flag)
{
    $('#myModal1').modal('toggle');
    var function_text = "<?php echo getFullURL($_GET['r'],'functions_recut.php','R'); ?>";
    var id_array = [id,flag];
    $('.loading-image').show();
    $.ajax({

			type: "POST",
			url: function_text+"?markers_view_docket="+id_array,
			//dataType: "json",
			success: function (response) 
			{
                document.getElementById('dynamic_table1').innerHTML = response;
                $('.loading-image').hide();
               
            }

    });

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
        // $('#myTable1').show();
    // }
    // else
    // {
    //     $('#myTable').show();
        //$('#myTable1').hide();
    // }
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
                console.log(td.innerHTML.toUpperCase());
                console.log(filter);
                if(td.innerHTML.toUpperCase() == filter)
                {
                    console.log(tr[i]);
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
function submitfunction(doc_no)
{
    document.getElementById('doc_no_org').value=doc_no;
}
function isInteger(value) 
{
    if ((undefined === value) || (null === value))
    {
        return false;
    }
    return value % 1 == 0;
}
</script>