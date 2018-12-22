<?php
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config_ajax.php');
error_reporting(0);
if(isset($_POST['approve']))
{
   $order_tid=$_POST['order_tid'];
   $status=1;
   $doc_nos=$_POST['doc_no_ref'];
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
   $url = '?r='.$_GET['r'];
   if($status == 1)
   {
        echo "<script>sweetAlert('Successfully Approved','','success');window.location = '".$url."'</script>";
   }
   else
   {
    echo "<script>sweetAlert('Material Not Available to Approve','','error');window.location = '".$url."'</script>";
   }
  
}
if(isset($_POST['reject']))
{
    $doc_no = $_POST['doc_no'];
    $a_sizes = '';
    $p_sizes = '';
    $ratio = '';
    $qry_cut_qty_check_qry = "SELECT SUM(recut_qty)as recut_qty,size_id FROM bai_pro3.`recut_v2_child` WHERE parent_id = $doc_no";
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
        $update_cps_log_qry = "update bai_pro3.cps_log set cut_quantity = $act_ratio where doc_no = $doc_no and size_code = '$size_code'";
        mysqli_query($link, $update_cps_log_qry) or exit("Updating recut_v2 for rejected docket".mysqli_error($GLOBALS["___mysqli_ston"]));
        $update_bcd_qry="update brandix_bts.bundle_creation_data set original_qty = $act_ratio,send_qty=$act_ratio where docket_number = $doc_no and size_id = '$size_code' and operation_id = 15";
        mysqli_query($link, $update_bcd_qry) or exit("Updating recut_v2 for rejected docket".mysqli_error($GLOBALS["___mysqli_ston"]));
        $update_bcd_qry="update brandix_bts.bundle_creation_data set original_qty = $act_ratio where docket_number = $doc_no and size_id = '$size_code' and operation_id <> 15";
        mysqli_query($link, $update_bcd_qry) or exit("Updating recut_v2 for rejected docket".mysqli_error($GLOBALS["___mysqli_ston"]));
    }
    $update_qry = "update $bai_pro3.recut_v2 set mk_ref = '0',a_plies=1,p_plies=1 where doc_no = $doc_no";
    mysqli_query($link, $update_qry) or exit("Updating recut_v2 for rejected docket".mysqli_error($GLOBALS["___mysqli_ston"]));
    $update_qry = "update $bai_pro3.plandoc_stat_log set mk_ref = '0',a_plies=1,p_plies=1 where doc_no = $doc_no";
    mysqli_query($link, $update_qry) or exit("Updating recut_v2 for rejected docket".mysqli_error($GLOBALS["___mysqli_ston"]));
    //deleting moq
    $delete_qry_moq = "DELETE FROM bai_pro3.`mo_operation_quantites` WHERE ref_no IN (SELECT tid FROM pac_stat_log_input_job WHERE doc_no = $doc_no)";
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
$drp_down .= "<div class='col-md-3'><label>Schedule Filter:</label>
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
    <form action="index.php?r=<?php echo $_GET['r']?>" name= "approve" method="post" id="approve">
        <div class="modal-dialog" style="width: 80%;  height: 100%;">
            <div class="modal-content">
                <div class="modal-header">Markers view
                    <button type="button" class="close"  id = "cancel" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class='panel-body' id="dynamic_table_panel">
                        <div class="ajax-loader" class="loading-image" style="margin-left: 45%;margin-top: 35px;border-radius: -80px;width: 88px;display:none;">
                                    <img src='<?= getFullURLLevel($_GET['r'],'ajax-loader.gif',0,'R'); ?>' class="img-responsive" />
                        </div>
                        <div id ="dynamic_table1"></div>
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
            <table class = 'col-sm-12 table-bordered table-striped table-condensed' id='myTable'><thead><th>S.No</th><th>Docket Number</th><th>Style</th><th>Schedule</th><th>Color</th><th>Rejected quantity</th><th>Recut Quantity</th><th>Recut Reported Quantity</th><th>Eligibility to Issue Quantity</th><th>View recut</th><th>Markers view</th><th>Approve</th><th>Reject</th>
                </thead>
                <?php  
                $s_no = 1;
                $blocks_query  = "SELECT fabric_status,SUM(rejected_qty)as rejected_qty,parent_id as doc_no,SUM(recut_qty)as recut_qty,SUM(recut_reported_qty) as recut_reported_qty,SUM(issued_qty)as issued_qty,r.`mk_ref`,b.`style_id`AS style,b.`order_col_des` AS color,b.`order_del_no` as schedule
                FROM `bai_pro3`.`recut_v2_child` rc 
                LEFT JOIN bai_pro3.`recut_v2` r ON r.doc_no = rc.`parent_id`
                LEFT JOIN bai_pro3.`bai_orders_db` b ON b.order_tid = r.`order_tid`
                WHERE r.mk_ref != '0'
                GROUP BY parent_id";
                $blocks_result = mysqli_query($link,$blocks_query) or exit('Rejections Log Data Retreival Error');        
                while($row = mysqli_fetch_array($blocks_result))
                {
                    $id = $row['doc_no'];
                    echo "<input type='hidden' name='doc_no' value='$id'>";
                    if($row['fabric_status'] == '1')
                    {
                        $button_html = "<b style='color:red;'>Approved</b>";
                        $html_hiding = "Approved";
                    }
                    else
                    {
                        $button_html = "<button type='button' class='btn btn-success' onclick='viewmarkerdetails(".$id.",1)'>Approve</button>";
                        $html_hiding = "NotApproved";
                        $button_html_rej = "<button type='submit' id='rej' class='btn btn-danger confirm-submit' name='reject' >Reject</button>";
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
                    echo "<td><button type='button'class='btn btn-primary' onclick='viewrecutdetails(".$id.")'>Recut View</button></td>";
                    echo "<td><button type='button'class='btn btn-success' onclick='viewmarkerdetails(".$id.",2)'>Marker View</button></td>";
                    echo "<td style='display:none'>$html_hiding</td>"; 
                    echo "<td>$button_html</td>";
                    echo "<td>$button_html_rej</td>";
                    echo "</tr>";
                    $s_no++;
                }
                ?>
                </table>
                <div id='myTable1' style='diplay:none;'>
                    <b style='color:red'>No Records Found</b>
                </div>
            </div>
        </div>
    </form>
</div>
<script>
$(document).ready(function() 
{
    myFunction();
});
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
        $('#myTable1').hide();
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
function isInteger(value) 
{
    if ((undefined === value) || (null === value))
    {
        return false;
    }
    return value % 1 == 0;
}
</script>