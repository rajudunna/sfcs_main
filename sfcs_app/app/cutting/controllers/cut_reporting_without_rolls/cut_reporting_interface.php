<?php
$plantcode=$_SESSION['plantCode'];
$username=$_SESSION['userName'];
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config_ajax.php');
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/functions_v2.php');
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/server_urls.php');
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/enums.php');


//$has_permission=haspermission($_GET['r']); 

if($fabric_validation_for_cut_report == 'yes')
    $FABRIC_VALIDATION = 1;
else
    $FABRIC_VALIDATION = 0;

//hardcode for temp purpose, rejection is removed in this screen
$operation_code = 15;
$access_report = $operation_code.'-G';
$access_reject = $operation_code.'-R';
// $access_qry=" select * from $central_administration_sfcs.rbac_permission where (permission_name = '$access_report' or permission_name = '$access_reject') and status='active'";
// $result = $link->query($access_qry);
// if($result->num_rows > 0){
//     if (in_array($$access_report,$has_permission))
//     {
//         $good_report = '';
//     }
//     else
//     {
//         $good_report = 'readonly';
//     }
//     if (in_array($$access_reject,$has_permission))
//     {
//         $reject_report = '';
//     }
//     else
//     {
//         $reject_report = 'readonly';
//     }
// } else {
//     $good_report = '';
//     $reject_report = '';
// }
$good_report = '';
$reject_report = '';
echo '<input type="hidden" name="good_report" id="good_report" value="'.$good_report.'">';
echo '<input type="hidden" name="reject_report" id="reject_report" value="'.$reject_report.'">';
if(isset($_GET['doc_no'])){
    $docket_line_id=$_GET['doc_no'];
    $get_docket_number="SELECT docket_line_number FROM $pps.jm_docket_lines WHERE jm_docket_line_id='$docket_line_id'";
    $sql_result121=mysqli_query($link, $get_docket_number) or exit("Sql Error get_docket_number".mysqli_error($GLOBALS["___mysqli_ston"]));
    while($row_doc = mysqli_fetch_array($sql_result121)){
        $doc_no = $row_doc['docket_line_number'];
    }
    // $cut_table = $_GET['module'];
    $cut_table = $_GET['module'];
    //$doc_no = $_GET['doc_no'];
    echo "<script>
        $(document).ready(function(){
            $('#doc_no').val($doc_no);
            $('#cut_table option[value=$cut_table]').attr('selected','selected');
            console.log('$cut_table');
            loadDetails($doc_no);
        });
    </script>";
    

$sql12="SELECT * from $wms.fabric_cad_allocation where doc_no = '".$doc_no."' and plant_code='$plantcode'";
$sql_result12=mysqli_query($link, $sql12) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_num_check12=mysqli_num_rows($sql_result12);
}
$cut_table_url = getFullURLLevel($_GET['r'],'dashboards/controllers/cut_table_dashboard/cut_table_dashboard_cutting.php',3,'N');
$cut_tables   = array();
$team_leaders = array();
$locations = array();
$rejection_reasons = array();


$department_type=DepartmentTypeEnum::CUTTING;
$result_worksation_id=getWorkstations($department_type,$plantcode);
$workstations=$result_worksation_id['workstation'];

$location_query="SELECT loc_name FROM $pms.locations where plant_code='$plantcode'";
$location_result=mysqli_query($link, $location_query) or exit('locations error');
while($row = mysqli_fetch_array($location_result))
{
    $locations[] = $row['loc_name'];
}

$team_leaders_query = "SELECT id,emp_name from $pms.tbl_leader_name where plant_code='$plantcode'";
$team_leaders_result = mysqli_query($link,$team_leaders_query);
while($row = mysqli_fetch_array($team_leaders_result)){
    $team_leaders[$row['id']] = $row['emp_name'];
}

$rejection_reason_query = "SELECT reason_code,reason_desc,m3_reason_code from $mdm.reasons where form_type = 'P' ";
$rejection_reason_result = mysqli_query($link,$rejection_reason_query); 
while($row = mysqli_fetch_array($rejection_reason_result)){
    $rejection_reasons[$row['reason_code'].'-'.$row['m3_reason_code']] = $row['reason_desc'];
}

?>

<!-- Cut Reporting Code -->
<div class='panel panel-primary cut_tab'>
    <div class='panel-heading'>
        <b>Cut Quantity Reporting Without Rolls</b>
    </div>
    <div class='panel-body'>  
        <div class='col-sm-10 user_msg'>
            <span class='notification'>NOTE : </span>
            <span id='user_msg'></span>
        </div>
        <div class='col-sm-1 pull-right'>
        
        <?php  
            // if($cut_table != '')
            //     echo "<a href='$cut_table_url' class='btn btn-xs btn-warning' > << Go Back </a>";
        ?>
        </div>
        <br/><br/>
        <div class='row'>       
            <div class='col-sm-6'>
                <table class='table table-bordered'>
                    <tr><td>Style</td>   <td id='d_style'></td>    </tr>
                    <tr><td>Schedule</td><td id='d_schedule'></td> </tr>
                    <tr><td>Color</td>   <td id='d_color'></td>    </tr>
                    <!-- <tr><td>Docket Type</td><td id='d_doc_type'></td></tr> -->
                </table>
            </div>
        </div>
        <div class='row'>
            <div class='col-sm-2'>
                <b>Enter Docket Number</b>
                <input type='text' class='form-control integer' value='' name='doc_no' id='doc_no'> 
            </div>
        </div>
        

        <!-- partial or already reported docket details -->
        <div class='row' id='hide_details_reported' style='overflow-x:scroll;display:none'>
            <div class='col-sm-12'>
            <hr> 
            <table class='table table-bordered' id='reported_table'>
                <tr class='danger'>
                    <td>Docket</td>
                    <th>Cut No</td>
                    <td>Act Cut Status</td>
                    <td>Cut Issue Status</td>
                    <td>Good Pieces</td>
                    <!-- <td>Rejected Pieces</td> -->
                    <td>Date</td>
                    <td>Section</td>
                    <td>Module</td>
                    <td>Shift</td>
                    <td>Fab Received</td>
                    <td>Fab Returned</td>
                    <td>Fab Damages</td>
                    <td>Fab joints</td>
                    <td>Fab endbits</td>
                    <td>Fab Shortages</td>
                    <td>Reporting process</td>
                </tr>
                <tr>
                    <td id='d_doc_no'></td>
                    <td id='d_cut_no'></td>
                    <td id='d_cut_status'></td>
                    <td id='d_cut_issue_status'></td>
                    <td id='d_good_pieces'></td>
                    <!-- <td id='d_rej_pieces'></td> -->
                    <td id='d_date'></td>
                    <td id='d_section'></td>
                    <td id='d_module'></td>
                    <td id='d_shift'></td>
                    <td id='d_fab_rec'></td>
                    <td id='d_fab_ret'></td>
                    <td id='d_damages'></td>
                    <td id='d_joints'></td>
                    <td id='d_endbits'></td>
                    <td id='d_shortages'></td>
                    <td id='d_reported'></td>
                </tr>
                
            </table>
            </div>
            <hr>
        </div><br/>
        <div class='row' id='hide_details_reported_roll_wise' style='overflow-x:scroll;display:none'>
            <div class='col-sm-12'>
            <hr> 
            <table class='table table-bordered' id='reported_table_roll_wise'>
            <thead>
                <tr class='danger'>
                    <td>S. No</td>
                    <td>LaySequence</td>
                    <td>Shade</td>
                    <td>Fab Received</td>
                    <td>Fab Returned</td>
                    <td>Reporting Plie</td>
                    <td>Fab Damages</td>
                    <td>Fab joints</td>
                    <td>Fab endbits</td>
                    <td>Fab Shortages</td>
                </tr>
                </thead>
            </table>
            </div>
            <hr>
        </div>
        <br/>
        <!-- This div to show the size wise ratios -->
        <div class='col-sm-12' id='hide_details_reporting_ratios' style='overflow-x:scroll;display:none'>
        </div>
        

        <div class='row' id='hide_details_reporting'>
            <div class='col-sm-2'>
                <label for='shift'>Shift <span style="color:red;">*</span></label>
                <select class='form-control' name='shift' id='shift' required>
                    <option value='' disabled selected>Select Shift</option>
                <?php
                $shift_sql="SELECT shift_code FROM $pms.shifts where plant_code = '$plantcode' and is_active=1";
                $shift_sql_res=mysqli_query($link, $shift_sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
                while($shift_row = mysqli_fetch_array($shift_sql_res))
                {
                    $shift_code=$shift_row['shift_code'];
                    echo "<option value='".$shift_code."' >".$shift_code."</option>"; 
                }
                ?>

                ?>
                </select>
            </div>
            <div class='col-sm-2'>
               <label for='cut_table'>Cutting Table <span style="color:red;">*</span></label>
               <select class='form-control' id='cut_table' required>
                    <option value='' disabled selected>Select Table</option>
                <?php
                    foreach($workstations as $id => $cut_table){
                        echo "<option value='$id'>$cut_table</option>";
                    }
                ?>
               </select>
            </div>
            <div class='col-sm-2'>
                <label for='cut_table'>Team Leader <span style="color:red;">*</span></label>
                <select class='form-control' id='team_leader' required>
                    <option value='' disabled selected>Select Leader</option>
                <?php
                    foreach($team_leaders as $id => $leader_name){
                        echo "<option value='$id'>$leader_name</option>";
                    }
                ?>
                </select>
            </div>
            <div class='col-sm-2'>
               <label for='bundle_location'>Bundle Location <span style="color:red;">*</span></label>
               <select class='form-control' id='bundle_location' required>
                    <option value='' disabled selected>Select Location</option>
                <?php
                    foreach($locations as $location){
                        echo "<option value='$location'>$location</option>";
                    }
                ?>
               </select>
            </div>
                    
            <div class='col-sm-offset-1 col-sm-2'>
                <label><br/></label>
                <div class='btn btn-sm btn-info' id='d_total_rejections' >
                </div>
            </div>

            <div class='col-sm-12'>
            <div class='table-responsive'>
            <br/><br/>    
                <table class='table table-bordered' id='reporting_table'>
                    <thead>
                        <tr class='info'>
                            <th>Docket</th>
                            <th>Quantity</th>
                            <th>Cut Status</th>
                            <th>Fab Required</th>
                            <th>Planned Plies</th>
                            <th>Reported Plies</th>
                            <th>Reporting Plies</th>
                            <th>Fabric Received</th>
                            <th>Fabric Returned</th>
                            <th>Damages</th>
                            <th>Joints</th>
                            <th>Endbits</th>
                            <th>Shortages</th>
                            <!--<th>Rejection Pieces</th>-->
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td id='r_doc_no'></td>
                            <td id='r_doc_qty'></td>
                            <td id='r_cut_status'></td>
                            <td id='r_fab_required'></td>
                            <td id='r_plan_plies'></td>
                            <td id='r_reported_plies'></td>
                            <!-- add validation for ret + rec + dam + short = c_plies -->
                            <td><input type='text' class='form-control integer' value='0' id='c_plies' onchange='calculatecutreport("c_plies")' ></td>
                            <td><input type='text' class='form-control float' value='0' id='fab_received' onchange='calculatecutreport()'></td>
                            <td><input type='text' class='form-control float' value='0' id='fab_returned' onchange='calculatecutreport()'>
                                <br><br>
                                <span id='returend_to_parent'>
                                    <select class='form-control' id='returned_to'>
                                        <option value='' disabled selected>Select</option>
                                        <option value='cut'>Cutting</option>
                                        <option value='rm'>RM</option>
                                </select>
                                </span>
                            </td>
                            <td><input type='text' class='form-control float' value='0' id='damages' onchange='calculatecutreport()'></td>
                            <td><input type='text' class='form-control float' value='0' id='joints' onchange='calculatecutreport()'></td>
                            <td><input type='text' class='form-control float' value='0' id='endbits' onchange='calculatecutreport()'></td>
                            <td><input type='text' class='form-control float' value='0' id='shortages' readonly></td>
                            <!-- nothing to do any changes in this file,bcoz of last committ merge conflicts it is not merged to UAT-->
                            <!-- <td><input type='text' class='form-control integer' place-holder='Rejections' id='rejection_pieces' name='rejection_pieces'><br><br> -->
                            <!--no changes but roll backed then hard push-->
                            
                            <!--<td><input type='button' style='display : block' class='btn btn-sm btn-danger' id='rejections_panel_btn' value='Show Rejections'>
                            </td>-->
                            <td><input type='button' class='btn btn-sm btn-success' value='Submit' id='submit'></td>
                        </tr>
                    </tbody>
                </table> 
                <input type='hidden' value='' id='p_plies'> 
                <input type='hidden' value='' id='ratio'>
                <input type='hidden' value='' id='post_doc_no'>  
                <input type='hidden' value='' id='doc_target_type'> 
                <input type='hidden' value='' id='post_schedule'>
                <input type='hidden' value='' id='post_style'>
                <input type='hidden' value='' id='post_color'>
                <input type='hidden' value='' id='fab_required'>
                <input type='hidden' value='' id='mk_length'>
                <input type='hidden' value='' id='binding_consum'>
                <input type='hidden' value='' id='seperat_dock'>


                <div class='col-sm-12'>
                    <span><b>MARK THIS AS FULLY REPORTED CUT ? &nbsp;&nbsp;</b> 
                    <input type='checkbox' value='1' id='full_reported' onchange='reportingFull(this)'> Yes</span>
              
                    <!-- <span class='pull-right showifcontain'><b>ENABLE ROLE WISE CUT REPORTING ? &nbsp;&nbsp;</b> 
                    <input type='checkbox' value='1' id='cut_report' onchange='enablecutreport(this)'> Yes</span> -->
				
                </div>

            </div>
        </div>
               <br/><br/>     
        <div class='col-sm-12' id = "enablecutreportdetails">
                    <div class="table-responsive">
                    <table class='table table-bordered' >
                    <thead>
                        <tr class='info'>
                            <th>S. No</th>
                            <th>Lay Sequence</th>
                            <th>Roll No</th>
                            <th>Shade</th>
                            <th>Width</th>
                            <th>Fabric Received Qty</th>
                            <th>Reporting Plies</th>
                            <th>Damages</th>
                            <th>Joints</th>
                            <th>End bits</th>
                            <th>Shortages</th>
                            <th>Fabric Return</th>
                            <!-- <th>Action</th> -->
                        </tr>
                    </thead>
                    <tbody id='enablerolls' >
                       
                    </tbody>
                </table>    
           </div>
        </div>
    </div>
</div>


<div class="modal fade" id="rejections_show_modal" role="dialog">
    <div class="modal-dialog" style="width: 60%;  height: 100%;">
        <div class="modal-content">
            <div class="modal-header">Size Wise Rejection Details
                <button type="button" class="close"  id = "cancel" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div id='rejections_show_table'>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="rejections_modal" role="dialog">
    <div class="modal-dialog" style="width: 80%;  height: 100%;">
        <div class="modal-content">
            <div class="modal-header">Cut Pieces Rejections Form
                <button type="button" class="btn btn-danger" value="Close" id = "cancel" data-dismiss="modal" style="float: right;">Close</button>
            </div>
            <div class="modal-body">
                <div class='panel panel-primary'>
                    <div class='panel-heading'>
                        Size Wise Rejection Panel
                    </div>
                    <div class='panel-body'>
                        <div class='col-sm-12'>
                            <span class='title'>
                                Total Rejectable Pieces Size Wise  : <span class='size-rej-pieces'></span>
                            </span>   
                            <br/> <br/>
                            <span class='col-sm-3'>
                                Total no of Pieces : 
                                <input type='button' class='btn btn-success' id='total_pieces'>
                            </span>
                            <span class='col-sm-4'>
                                Available For Rejection : 
                                <input type='button' class='btn btn-danger' id='avl_pieces'>
                            </span>  
                        </div> <br/>
                        <div class='col-sm-12'>
                        <hr>
                            <div class='col-sm-2'>
                                <label for='rejection_size'>Size</label> 
                                <select class='form-control' name='rejection_size' id='rejection_size'>
                                    <option value='' selected disabled>Please Select</option>
                                </select>
                            </div>
                            <div class='col-sm-3'>
                                <label for='rejection_size'>Rejection Reason</label> 
                                <select class='form-control' name='rejection_reason' id='rejection_reason'>
                                    <option value='' selected disabled>Please Select</option>
                                <?php 
                                    foreach($rejection_reasons as $reason_code => $reason_desc)
                                        echo "<option value='$reason_code'>$reason_desc</option>";
                                ?>
                                </select>
                            </div>
                            <div class='col-sm-2'>
                                <label for='rejection_qty'>Rejected Qty</label> 
                                <input type='text' class='form-control integer' name='rejection_qty' id='rejection_qty'>
                            </div>
                            <div class='col-sm-1'>
                                <label for='add_rejection'>&nbsp;</label><br/>
                                <input type='button' class='btn btn-warning' value='+' name='add_rejection' id='add_rejection'>
                            </div>
                            <div class='col-sm-offset-1 col-sm-3'>
                                <label for='save_rejection'>&nbsp;</label><br/>
                                <!-- <input type='button' class='btn btn-primary confirm-submit' value='Save' name='save_rejection' id='save_rejection'>&nbsp; -->
                                <input type='button' class='btn btn-danger' value='clear' name='clear_rejection' id='clear_rejection'>
                            </div>
                        </div>
                        <div class='col-sm-12'><hr/></div>
                        <div class='col-sm-offset-2 col-sm-8'>
                            <table class='table table-bordered rejections_table'>
                                <thead>
                                    <tr class='danger'>
                                        <th>Size</th><th>Reason</th><th>Quantity</th><th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id='rejections_table_body'>
                                    
                                </tbody>
                            </table>
                        </div>  

                    </div>
                </div>
                    
                
            </div>

        </div>
    </div>
</div>

<div class='col-sm-offset-4 col-sm-4'>
    <span  id='wait_loader'  style='color:#ff0000;font-size:20px;display:none'>Please Wait....</span>
</div>

<?php 
    $get_url = getFullURLLevel($_GET['r'],'cut_reporting_data.php',0,'R');
    $fabric_status = getFullURLLevel($_GET['r'],'fabric_status.php',0,'R');
    $post_url = getFullURLLevel($_GET['r'],'cut_reporting_save.php',0,'R');
    $rej_url = getFullURLLevel($_GET['r'],'cut_rejections_save.php',0,'R');
    $getenablecutreport_url = getFullURLLevel($_GET['r'],'enable_cut_report_data.php',0,'R');
    $generatedata=getFullURLLevel($_GET['r'],'create_cut_report_data.php',0,'R');
    $generatebundleguide=getFullURLLevel($_GET['r'],'generate_bundle_guide.php',0,'N');
    $generatebundleguidereport=getFullURLLevel($_GET['r'],'generate_bundle_guide_report.php',0,'N');

?>

<script>

    $('#enablecutreportdetails').hide();
    var avl_plies = 0;
    var doc_no = 0;
    var c_plies = 0;
    var fab_req = 0;
    var pieces = {};
    var pieces_actual = {};
    var dataR;
    var global_serial_id = 0;
    var total_rejected_pieces = 0;//this variable is for how many pieces he selected size and reason
    var ret = 0; //This variable is to store front end user given rejection pieces
    var rejections_post = {};
    var cumulative_size = {};
    var rejections_flag = 0;
    var ratio = 0;
    var full_reporting_flag = 0;
    var GLOBAL_CALL = 0;
    var SIZE_COUNT = 0;
    var CLEAR_FLAG = 0;
    var sql_num_check12='<?=$sql_num_check12?>';

            if(sql_num_check12>0)
            {
                $('.showifcontain').css({'display':'block'});
                
            }
       
    $('td input#creportingplies.form-control').click(function(){
    var row_index = $(this).parent().index();
    var col_index = $(this).index();
    });


    function getdetails()
    {
         $('#c_plies').attr('readonly', true);
         $('#full_reported').attr('disabled', true);
         $('#cut_report').attr('disabled', true);
         $('#fab_received').attr('readonly', true);
         $('#fab_returned').attr('readonly', true);
         $('#damages').attr('readonly', true);
         $('#joints').attr('readonly', true);
         $('#endbits').attr('readonly', true);
         //$('#shortages').attr('readonly', true);    
                doc_no = $('#doc_no').val();
                var form_data = {
                        doc_no:doc_no,
                    };    

      
                $.ajax({
                    url  : '<?= $getenablecutreport_url?>',
                    type : 'POST',
                    data : form_data
                }).done(function(res){
                    if(res=="Not Available")
                    {
                        $('.hidenotavailble').css({'display':'none'});

                        swal('Rolls Not Available','Not Available','warning');
                    }else{
                        try{
                        var res = $.parseJSON(res);
                        data=res.response_data;
                        var marklength=res.marklength;
                        var noofrolls=data.length;
                        if(res.totalreportedplie){
                            var totalreportedplie=res.totalreportedplie.totalreportedplies;
                            $('#r_reported_plies').html(totalreportedplie);
                        }
                       
                        var i;
                        var totalreportingplies=0;
                        var totalfabricreturn=0;
                        var sno=1;
                        var existed=0;
                        var notdisplay=0;
                            if(noofrolls>0){
                                for(i=0;i<noofrolls;i++)
                                {
                                    if(data[i]["existed"]==1)
                                    {
                                        if(parseInt(data[i]["allocated_qty"]/marklength)==0){
                                            existed="";
                                        }
                                        else{
                                            existed="readonly";
                                        }
                                        
                                        complted=1;
                                        notdisplay++;
                                    }
                                    else{
                                        existed="";
                                        complted=0;
                                    }

                                    if(data[i]["lay_sequence"]==null)
                                    {
                                       lay = "";
                                    }
                                    else{
                                        lay= "value ="+data[i]["lay_sequence"]+"";
                                        
                                    }
                                    if(data[i]["reporting_plies"])
                                    {
                                      
                                       roll= "value ="+data[i]["reporting_plies"]+"";
                                       damages= "value ="+data[i]["damages"]+"";
                                       joints= "value ="+data[i]["joints"]+"";
                                       endbits= "value ="+data[i]["endbits"]+"";
                                       shortages= "value ="+data[i]["shortages"]+"";
                                       fabric_return= "value ="+data[i]["fabric_return"]+"";
                                    }
                                    else{
                                        
                                       roll = "value ="+parseInt(data[i]["allocated_qty"]/marklength)+"";
                                       damages= "value =0.00";
                                       joints= "value =0.00";
                                       endbits= "value =0.00";
                                       shortages= "value =0.00";
                                       fabric_return= "value =0.00"; 
                                    }
                                    var bgcolor = data[i]["bgcolor"];
                                    row = $('<tr style="background-color:'+bgcolor+'"><td id='+i+'>'+sno+'</td><td><input type="number" id='+i+"laysequece"+'  '+lay+' class="form-control integer" '+existed+'></td><td>'+data[i]["ref2"]+'</td><td>'+data[i]["shade"]+'</td><td>'+data[i]["roll_width"]+'</td><td>'+data[i]["allocated_qty"]+'</td><td><input type="number"  onchange="calculatecutreport(\''+i+'creportingplies\');" id='+i+'creportingplies '+roll+' class="form-control float" '+existed+'></td><td><input type="number"  '+damages+'  onchange="calculatecutreport(\''+i+'cdamages\');"  id='+i+'cdamages class="form-control float" '+existed+'></td><td><input type="number"  '+joints+' onchange="calculatecutreport(\''+i+'cjoints\');" id='+i+'cjoints class="form-control float" '+existed+'></td><td><input type="number"  '+endbits+' onchange="calculatecutreport(\''+i+'cendbits\');" id='+i+'cendbits class="form-control float" '+existed+'></td><td><input type="number"  onchange="calculatecutreport(\''+i+'cshortages\');"  '+shortages+'  id='+i+'cshortages class="form-control float"  '+existed+' readonly></td><td><input type="number" onchange="calculatecutreport(\''+i+'cfabricreturn\');"  '+fabric_return+' id='+i+'cfabricreturn class="form-control float" ></td><td style="display:none;"><button style="background-color: DodgerBlue;color: white;"class="btn fa fa-trash" id="del'+i+'"></td><td style="display:none;"><input type="text"  value='+marklength+' onchange="calculatecutreport();" id="mlength" class="form-control"></td><td style="display:none;">'+data[i]["roll_id"]+'</td><td style="display:none;">'+data[i]["shade"]+'</td style="display:none;"><td style="display:none;">'+complted+'</td><td style="display:none;" id='+i+'alloc_type_id>'+data[i]["alloc_type_id"]+'</td><td style="display:none;" id='+i+'bgcolor>'+bgcolor+'</td></tr>'); //create row 
                                    totalreportingplies+=parseInt(data[i]["allocated_qty"]/marklength);
                                    $('#c_plies').val(totalreportingplies);
                                    totalfabricreturn+=marklength;
                                    $('#fab_returned').val(parseFloat(Number(totalreportingplies)).toFixed(2));
                                   
                                sno++;
                                $('#enablerolls').append(row);
                                }
                                $('#r_reported_plies').html(totalreportedplie);
                                // if(notdisplay!=noofrolls)
                                // {
                                //     row1 = $('<button onclick="generatereport()" class="btn btn-success btn-sm pull-right">Submit</button>');
                                //     $('#enablecutreportdetails').append(row1);
                                // } 
                                // else{
                                //     row1 = $('<a href="'+bundleguide+"&doc_no="+doc_no+'" class="btn btn-success btn-sm pull-right">Generate Bundle Guide</a>');
                                //     $('#enablecutreportdetails').append(row1);
                                // }                            
                                $('#enablecutreportdetails').show();
                                calculatecutreport();
                            }

                    }catch(e){
                        swal('Rolls Not Available','Data Problem or Failed','warning');
                       
                    }
                    }
                   
                
                }).fail(function(res){
                
                });
            
    }

    function enablecutreport(t)
    {
        // $('#c_plies').attr('readonly', true);
        // $('#fab_received').attr('readonly', true);
        // $('#fab_returned').attr('readonly', true);
        // $('#damages').attr('readonly', true);
        // $('#joints').attr('readonly', true);
        // $('#endbits').attr('readonly', true);
        // $('#shortages').attr('readonly', true);
        doc_no = $('#doc_no').val();
        var bundleguide ='<?=$generatebundleguide?>';
 
        $('#enablerolls').html('');
        $('#enablecutreportdetails button').html('');
        $('#enablecutreportdetails a').html('');
        $('#enablecutreportdetails a.btn').remove();
        $('#enablecutreportdetails button').remove();
        $('#enablecutreportdetails').hide();
        if(t.checked == true)
            getdetails();
        else
        {
                $('#c_plies').attr('readonly', false);
                $('#full_reported').attr('disabled', false);
                $('#cut_report').attr('disabled', false);
                $('#fab_received').attr('readonly', false);
                $('#fab_returned').attr('readonly', false);
                $('#damages').attr('readonly', false);
                $('#joints').attr('readonly', false);
                $('#endbits').attr('readonly', false);
                //$('#shortages').attr('readonly', false);
        }
            enable_report = 0;
           //$("#cut_report"). prop("checked", false);     
    }
    function checklaysequence(){
       
        var laysequnces=[];
        var alreadygiven;
        var table = $("#enablerolls");
       // var i=0;
        table.find('tr').each(function (i) {
       
        var $tds = $(this).find('td'),
            laysequence = $tds.find('#'+i+'laysequece').val();
        
            if(!(laysequence=="")){
                laysequnces.push(laysequence);
            }
        
        });
        var laysequncesArray = laysequnces.filter(function(elem, index, self) {
          alreadygiven = (index === self.indexOf(elem)); 
        if(!alreadygiven){
          
            swal('Lay Sequence','Check Lay Sequence'+elem+' already given','warning');
        }
        });
        return alreadygiven;
    }
  
//    $('table tbody').on('click','.btn',function(){
//        $(this).closest('tr').remove();
//        calculatecutreport();
//    });

    // function generatereport()
    // {
       
   
   


    // }

    function calculatecutreport(indextype)
    {
        if(indextype)
        {
            var checkifitnotavalue=$('#'+indextype).val();
                if(checkifitnotavalue==''){
                    if(indextype.indexOf('creportingplies') != -1)
                    {
                        $('#'+indextype).val('0');
                    }
                    else{

                        $('#'+indextype).val('0.00');
                    }
               
            }
        }
        var r = $("#reporting_table #r_plan_plies").text();
        var alreadyreportedplies =$("#reporting_table #r_reported_plies").text();
      
        if(alreadyreportedplies)
        {
            r=Number(r)-Number(alreadyreportedplies);
        }
        var table = $("#enablerolls");
        var sumofreporting=0;
        var sumofdamages=0;
        var sumofjoints=0;
        var sumofendbits=0;
        var sumofshortages=0;
        var sumofpile=0;
        var removesum=0;
        var fabricreturnqty=0;
        var sumoffabricreturn=0;
        var sumoffabricrecieved=0;
        var data = [];
        var makeselectedrow=0;
        var partiallyreported=0;
    
            table.find('tr').each(function (i) {

            var $tds = $(this).find('td'),
                Sno = $tds.eq(0).text(),
                laysequence = $tds.find('#'+i+'laysequece').val(),
                rollno = $tds.eq(14).text();
                shade = $tds.eq(3).text();
                width = $tds.eq(4).text();
                receivedqty = $tds.eq(5).text();
                reportingplies = $tds.find('#'+i+'creportingplies').val();
                damages = $tds.find('#'+i+'cdamages').val();
                joints =$tds.find('#'+i+'cjoints').val();
                endbits = $tds.find('#'+i+'cendbits').val();
                //shortages =$tds.find('#'+i+'cshortages').val(); commented bcoz #3111 ticket new formua for shortage
                fabricreturn=$tds.find('#'+i+'cfabricreturn').val();
                mlength=$tds.find('#mlength').val();
                fabricreturnqty=$tds.find('#'+i+'cfabricreturn').val();
                completed = $tds.eq(16).text();
            
            //#3111 ticket chnages for shortage formila changes.
            shortages = parseFloat(Number(receivedqty) - ((Number(reportingplies*mlength)) + Number(damages) + Number(joints) + Number(endbits) + Number(fabricreturn))).toFixed(2);
            $tds.find('#'+i+'cshortages').val(shortages);


            // do something with laysequence, rollno, shade
            //fabricreturnqty = parseFloat(Number(receivedqty) - ((Number(reportingplies*mlength)) + Number(endbits) + Number(shortages) + Number(damages) + Number(joints))).toFixed(2);
            //fabricreturnqty=fabricreturnqty.toFixed(2);
            
            // if(fabricreturnqty<0)
            // {
            //     $tds.find('#'+i+'cfabricreturn').val(0);
            //     swal('Please Enter Reporting Plies/Damages/End Bits/Shortages Correctly','Or Check','error');
            //     reportingplies = $tds.find('#'+i+'creportingplies').val(0);
            //     $('#'+i+'creportingplies').prop('readonly', false);
            //    // calculatecutreport();
            // }
            // else{
                //$tds.find('#'+i+'cfabricreturn').val(fabricreturnqty);
            // }
            
        if(!Number(completed)){
            sumofreporting+=parseFloat(reportingplies);
                if(reportingplies!=0)
                {
                    sumoffabricreturn+=parseFloat(fabricreturnqty);
                    sumofdamages+=parseFloat(damages);
                    $('#damages').val(Number(sumofdamages).toFixed(2));
                    sumofjoints+=parseFloat(joints);
                    $('#joints').val(Number(sumofjoints).toFixed(2));
                    sumofendbits+=parseFloat(endbits);
                    $('#endbits').val(Number(sumofendbits).toFixed(2));
                    sumofshortages+=parseFloat(shortages);
                    //alert("Rollwise :"+sumofshortages);
                    $('#shortages').val(Number(sumofshortages).toFixed(2));
                
                    sumoffabricrecieved+=parseFloat(receivedqty);
                    $('#fab_received').val(Number(sumoffabricrecieved).toFixed(2));
                }
            
                if(sumoffabricreturn<0)
                {
                    $('#fab_returned').val(0);
                }else{
                    $('#fab_returned').val(Number(sumoffabricreturn).toFixed(2));
                }
        
        }
        partiallyreported+=parseFloat(reportingplies);
            // alert(sumofreporting);
            // alert(r);
            if(sumofreporting<=r){    
                
                $('#c_plies').val(sumofreporting);
            }else{        
                // if(makeselectedrow==0)
                // {
                    
                    if(indextype)
                    {
                        swal('Please Enter Reporting Plies Correctly','Or Check','error');
                        $('#'+indextype).val(0);
                        sumofreporting=sumofreporting-parseFloat(reportingplies);
                        calculatecutreport();
                    

                    }
                    else{

                        $tds.find('#'+i+'creportingplies').val(0);
                        sumofreporting=sumofreporting-parseFloat(reportingplies);
                        calculatecutreport();
                    }
                    
                // }
                // makeselectedrow=1;
                
            }
        
            if(Number(shortages)>Number(receivedqty))
            {
            
                $('#'+indextype).val(0);
                swal('Please Enter Shortages Correctly','Or Check','error');
                calculatecutreport();
                return 0;
            }
        

            // sumofpile=parseFloat(damages)+parseFloat(joints)+parseFloat(endbits)+parseFloat(shortages)+parseFloat(fabricreturn);
            // var x=0;
        
            // if(sumofpile>reportingplies)
            // {
            
            //     if(indextype)
            //     {
            //         $('#'+indextype).val(0);
                    
            //         swal('Please Enter Plies Correctly','Or Check','error');
            //         calculatecutreport();
            //     }
                
                // removesum=parseFloat(damages);
                // if(removesum>reportingplies)
                // {
                //     x=1;
                //     $tds.find('#'+i+'cdamages').val(0);
                //     swal('Please Enter Plies Correctly','Or Check','error');
                //     calculatecutreport();
                // }
                // removesum+=parseFloat(joints);
                // if(removesum>reportingplies&&x!=1)
                // {
                //     x=1;
                //     $tds.find('#'+i+'cjoints').val(0);
                //     swal('Please Enter Plies Correctly','Or Check','error');
                //     calculatecutreport();
                // }
                // removesum+=parseFloat(endbits);
                // if(removesum>reportingplies&&x!=1)
                // {
                //     x=1;
                //     $tds.find('#'+i+'cendbits').val(0);
                //     swal('Please Enter Plies Correctly','Or Check','error');
                //     calculatecutreport();
                // }
                // removesum+=parseFloat(shortages);
                // if(removesum>reportingplies&&x!=1)
                // {
                //     x=1;
                //     $tds.find('#'+i+'cshortages').val(0);
                //     swal('Please Enter Plies Correctly','Or Check','error');
                //     calculatecutreport();
                // }
        // }    
                
        });
        //3111 CR chnages for Shortahge formula   
        if((sumofreporting<=0)&&(sumoffabricreturn<=0)){
            var c_plies = Number($('#c_plies').val());
            var fab_received = Number($('#fab_received').val());
            var fab_returned = Number($('#fab_returned').val());
            var damages = Number($('#damages').val());
            var joints = Number($('#joints').val());
            var endbits = Number($('#endbits').val());
            var tot_mlength = Number($('#mk_length').val());
            var binding_consum = Number($('#binding_consum').val());
            var seperat_dock = $('#seperat_dock').val();
            var ratio = $('#ratio').val();
            if(seperat_dock!='Yes'){ 
                var binding_consum_qty=Number(c_plies*binding_consum*ratio);
            }else{
                var binding_consum_qty=0;
            }  
                var shortag_qty = parseFloat(Number(fab_received) -(Number(c_plies*tot_mlength)+Number(damages)+Number(joints)+Number(endbits)+Number(fab_returned)+binding_consum_qty)).toFixed(2);
                $('#shortages').val(Number(shortag_qty).toFixed(2));
            
                       
        }
        
        var fret = Number($('#fab_returned').val());
        if(fret > 0)
        {
            $('#returend_to_parent').css({'display':'block'});
        } 
        else
        {
            $('#returend_to_parent').css({'display':'none'});

            //calculatecutreport();
        }

       
            
        
   

    }



    
  
    function reportingFull(t){
        if(t.checked == true)
            full_reporting_flag = $(t).val();
        else
            full_reporting_flag = 0;
        // alert(full_reporting_flag);   
    }

    $('#cut_tab').on('click',function(){
        $('.cut_tab').css({'display':'block'});
        $('.rej_tab').css({'display':'none'});
        $('#rej_tab_li').removeClass('active');
        $('#cut_tab_li').addClass('active');
    });

    $('#rej_tab').on('click',function(){
        $('.cut_tab').css({'display':'none'});
        $('.rej_tab').css({'display':'block'});
        $('#cut_tab_li').removeClass('active');
        $('#rej_tab_li').addClass('active');
    });

    $(document).ready(function(){
        if($('#reject_report').val() == 'readonly' ){
            $('#rejections_panel_btn').attr({'disabled':true});
        }
        $('.rej_tab').css({'display':'none'});
        $('#hide_details_reporting').css({'display':'none'});
        $('#hide_details_reported').css({'display':'none'});
        $('#returend_to_parent').css({'display':'none'});
    });

    $('#doc_no').on('change',function(){
        $('#enablerolls').html('');
        $('#enablecutreportdetails').hide();
        $("#cut_report"). prop("checked", false);
        $('#wait_loader').hide();
        doc_no = $('#doc_no').val();
        GLOBAL_CALL = 0;
        $('#submit').css({'display':'block'});
        $('.user_msg').css({'display':'none'});
        $('#hide_details_reported').css({'display':'none'});
        $('#hide_details_reporting').css({'display':'none'});
       
        clearAll();
        clearFormData();
       // clearRejections();
        loadDetails(doc_no);
    });


  
    $('#submit').on('click',function(){
        //var x= $('input[id="cut_report"]:checked');
        var ratiostable = $("#hide_details_reporting_ratios table");
        var rollwisestatus=false;
        // var ratios=[];
        // ratiostable.find('tr').each(function (i) {
            
        // var $tds = $(this).find('td'),
        //     M = $tds.eq(0).text();
        //     L= $tds.eq(1).text();
        //     XL= $tds.eq(2).text();
        //     ratios.push(M,L,XL);
        // });
        // var sumofreportingplie = $("#reporting_table #r_plan_plies").text();
            // var alreadyreportedplies =$("#reporting_table #r_reported_plies").text();
      
            // if(alreadyreportedplies)
            // {
            //     sumofreportingplie=Number(sumofreportingplie)-Number(alreadyreportedplies);
            // }
            var doc_no = $("#reporting_table #r_doc_no").text();
            // alert(r);
            var rollwisestatus=true;
            var table = $("#enablerolls");
            var sumofreporting=0;
            var sumofdamages=0;
            var sumofjoints=0;
            var sumofendbits=0;
            var sumofshortages=0;
            var sumoffabricreturn=0;
            var fabricreturnqty=0;
            var totalfabricreturnqty=0;
            var data = [];
            var check=0;
            var i=0;
            console.log(table+'table');
            table.find('tr').each(function (i) {

            var $tds = $(this).find('td'),
                Sno = $tds.eq(0).text(),
                laysequence = $tds.find('#'+i+'laysequece').val(),
                rollno = $tds.eq(14).text();
                shade = $tds.eq(3).text();
                width = $tds.eq(4).text();
                receivedqty = $tds.eq(5).text();
                reportingplies = $tds.find('#'+i+'creportingplies').val();
                damages = $tds.find('#'+i+'cdamages').val();
                joints =$tds.find('#'+i+'cjoints').val();
                endbits = $tds.find('#'+i+'cendbits').val();
                alloc_type_id = $tds.eq(17).text();
                bgcolor = $tds.eq(18).text();
                shortages =$tds.find('#'+i+'cshortages').val();
                fabricreturn=$tds.find('#'+i+'cfabricreturn').val();
                mlength=$tds.find('#mlength').val();
                preparedroll = $tds.eq(16).text();
            // do something with laysequence, rollno, shade
            
            fabricreturnqty = parseFloat(Number(receivedqty) - (Number(reportingplies*mlength) + Number(endbits) + Number(shortages))).toFixed(2);
            //fabricreturnqty=fabricreturnqty.toFixed(2);
            $tds.find('#'+i+'cfabricreturn').val(fabricreturnqty);

            totalfabricreturnqty+=fabricreturnqty;
            // if(sumofreporting<sumofreportingplie){ 
            //     alert(sumofreporting);
            //     alert(sumofreportingplie);
            //      if(!preparedroll)
            //      {
            //         sumofreporting+=parseFloat(reportingplies);
            //      }  
            
            //     $('#c_plies').val(sumofreporting);
            // }else{
            //     swal('Please Enter Reporting Plies Correctly','Or Check','error');
            //     return false;
                
            // }
            
            if((laysequence=='')&&!(reportingplies==0))
            {
                check=1;
                
            }

            if((laysequence)&&(reportingplies==0))
            {
                check=2;
                
            }
        
            sumofdamages+=parseFloat(damages);
            $('#damages').val(sumofdamages);
            sumofjoints+=parseFloat(joints);
            $('#joints').val(sumofjoints);
            sumofendbits+=parseFloat(endbits);
            $('#endbits').val(sumofendbits);
            sumofshortages+=parseFloat(shortages);
            //alert("For Bulk :"+sumofshortages);
            $('#shortages').val(sumofshortages);
            sumoffabricreturn+=parseFloat(fabricreturn);
            $('#fab_returned').val(sumoffabricreturn);
            
        
            if(preparedroll==0){
                if(laysequence!='')
                {
                    data.push([Sno,laysequence,rollno,shade,width,receivedqty,reportingplies,damages,joints,endbits,shortages,fabricreturn,alloc_type_id,bgcolor] );     
                }
            }
        
            });

   

    
             if(check==1)
            {
                swal('Please Enter LaySequence','Or Check LaySequence','error');
                return false;
               
            }
            else if(check==2)
            {
                swal('Please Check Reporting Plies','Not Given','error');
                return false;
            }
            else
            {
               data;
            }

            // layseqnce=checklaysequence();
            //     if(layseqnce)
            //     {
            //     }
            //     else{
            //         swal('LaySequence Problem','Please Check','error');
            //     }
        
              

        c_plies = Number($('#c_plies').val());
        var ret_to     = Number($('#fab_returned').val());
        var rec     = Number($('#fab_received').val());
        var returned_to = $('#returned_to').val();
        var damages = Number($('#damages').val());
        var joints = Number($('#joints').val());
        var endbits = Number($('#endbits').val());       
        var joints_endbits = joints +'^'+ endbits;       
        var shortages = Number($('#shortages').val());
        var bundle_location = $('#bundle_location').val();
        var shift     = $('#shift').val();
        var cut_table = $('#cut_table').val();
        var team_leader = $('#team_leader').val();
        var post_doc_no = $('#post_doc_no').val();
        var doc_target_type = $('#doc_target_type').val();
        ratio   = Number($('#ratio').val());
        var style       = $('#post_style').val();
        var schedule    = $('#post_schedule').val();
        var color       = $('#post_color').val();
        var fab_req     = Number($('#fab_required').val());
        var error_message = '';
        var user = '<?php echo $username;?>';
        var plantcode = '<?php echo $plantcode;?>';
        
        //Screen Validations
        if(c_plies == 0 && full_reporting_flag == '1'){
            //do nothing
        }else{
            if(c_plies == 0){
                swal('Please Enter Reporting Plies','Or Mark this as Fully Reported Cut','error');
                return false;
            }
            if(c_plies > avl_plies){
                swal('Warning','The Reporting Plies are more than, that are to be Reported','error');
                return false;
            }
           
            if(<?= $FABRIC_VALIDATION ?>){  
                console.log('Fabric Validation is Truned On');  
                if(rec > fab_req)
                    return swal('info','Reporting More Than Eligible Fabric','info'); 
                if(fab_req < ret_to+rec+damages+shortages){
                    swal('Warning','The Reporting Fabric must not be greater than received + fabric returned + shortages + damages','error');
                    return false;
                }
            }
        }
        
        if(shift == null || cut_table == null || team_leader == null){
            swal('warning','Please Select Shift , Cut Table , Team Leader ,Bundle Location','warning');
            return false;
        }

       
        if(ret_to > 0){
            if(returned_to == null){
                swal('Select Fabric Returned to Cutting / RM','','warning');
                return false;
            }
        }
        //Screen Validations End
        
        //Rejections Validation
        // if(ret > 0){
        //     if(total_rejected_pieces > c_plies * ratio)
        //         return swal('You are Returning More than Reporting Pieces','Please Remove some rejections','warning');
        //     else if(total_rejected_pieces < ret)
        //         return  swal('Please Fill the Rejections Completely','','warning');
        //     else
        //         rejections_flag = 1;
        // }else{
        //     if(total_rejected_pieces > ret)
        //         return swal('You are Returning more than Specified','','error');
        // }
        if(ret > 0){
            if(total_rejected_pieces > c_plies * ratio)
                return swal('You are Returning More than Reporting Pieces','Please Remove some rejections','warning');
        }else{
            if(total_rejected_pieces > ret)
                return swal('You are Rejecting more than Specified','','error');
        }
        console.log(ret+' - '+total_rejected_pieces+' -  '+full_reporting_flag);
        
        //Rejections Validation End

        var user_msg = '';
        //AJAX Call
        var terminate_flag = 0;
        console.log(form_data);
        console.log(pieces);
        console.log(cumulative_size);
        if(total_rejected_pieces > 0){
            $.each(pieces_actual,function(key,value){
                if(  Number(cumulative_size[key]) > Number(value) ){
                swal('Reporting Pieces are less than the Rejected Pieces','Delete Some Rejections','error');
                terminate_flag++;
                return false;
                }
            });
        }
        if(Number(terminate_flag) > 0)
            return false;
        
        if(total_rejected_pieces > 0)
            rejections_flag = 1;
        var form_data = {
                        doc_no:post_doc_no,createdUser:user,c_plies:c_plies,fab_returned:ret_to,
                        fab_received:rec,returned_to:returned_to,damages:damages,
                        shortages:shortages,bundle_location:bundle_location,shift:shift,joints_endbits:joints_endbits,
                        cut_table:cut_table,team_leader:team_leader,doc_target_type:doc_target_type,
                        style:style,color:color,schedule:schedule,rejections_flag:rejections_flag,rejections:rejections_post,
                        full_reporting_flag : full_reporting_flag,  
                        data:data,
                        rollwisestatus:rollwisestatus,
                        
                        //ratios:ratios
                    };    
        var reportData = new Object();
        reportData.docketNumber = $('#r_doc_no').text();
        reportData.shift = $('#shift').val();
        reportData.workStationId = $('#cut_table').val();
        reportData.plantCode = '<?php echo $plantcode;?>';
        reportData.createdUser = '<?php echo $username;?>';
        if($("#full_reported").is(':checked'))
        {
            reportData.fullyReported = true;
        }else {
            reportData.fullyReported = false;
        }
        // alert($('#full_reported').val());
        console.log($('#c_plies').val());
       
        reportData.reportedPlies = parseInt($('#c_plies').val());
        console.log(typeof reportData.reportedPlies);
        reportData.rollsInfo = [];
        var fabricAttributes = new Array();

        var fabricReceivedObject = new Object();
        fabricReceivedObject.attributeName='FABRICRECEIVED';
        fabricReceivedObject.attributeValue=$('#fab_received').val();
        fabricAttributes.push(fabricReceivedObject);

        var fabricReturnedObject = new Object();
        fabricReturnedObject.attributeName='FABRICRETURNED';
        fabricReturnedObject.attributeValue=$('#fab_returned').val();
        fabricAttributes.push(fabricReturnedObject);

        var damagesObject = new Object();
        damagesObject.attributeName='DAMAGES';
        damagesObject.attributeValue=$('#damages').val();
        fabricAttributes.push(damagesObject);

        var JointsObject = new Object();
        JointsObject.attributeName='JOINTS';
        JointsObject.attributeValue=$('#joints').val();
        fabricAttributes.push(JointsObject);

        var endbitsObject = new Object();
        endbitsObject.attributeName='END-BITS';
        endbitsObject.attributeValue=$('#endbits').val();
        fabricAttributes.push(endbitsObject);

        var shortagesObject = new Object();
        shortagesObject.attributeName='SHORTAGES';
        shortagesObject.attributeValue=$('#shortages').val();
        fabricAttributes.push(shortagesObject);
        reportData.fabricAttributes = fabricAttributes;
        console.log(reportData);
        $('#wait_loader').css({'display':'block'});


        var bearer_token;
        var getData;
        const creadentialObj = {
        grant_type: 'password',
        client_id: 'pps-back-end',
        client_secret: '1cd2fd2f-ed4d-4c74-af02-d93538fbc52a',
        username: 'bhuvan',
        password: 'bhuvan'
        }
        $.ajax({
            method: 'POST',
            url: "<?php echo $KEY_LOCK_IP?>",
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            xhrFields: { withCredentials: true },
            contentType: "application/json; charset=utf-8",
            transformRequest: function (Obj) {
                var str = [];
                for (var p in Obj)
                    str.push(encodeURIComponent(p) + "=" + encodeURIComponent(Obj[p]));
                return str.join("&");
            },
            data: creadentialObj
        }).then(function (result) {
            console.log(result);
            bearer_token = result['access_token'];
            $.ajax({
                    type: "POST",
                    url: "<?php echo $PPS_SERVER_IP?>/cut-reporting/layReporting",
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded','Authorization': 'Bearer ' +  bearer_token },
                    data:  reportData,
                    contentType: "application/json; charset=utf-8",
                    dataType: "json",
                    success: function (res) {            
                        //console.log(res.data);
                        console.log(res.status);
                        $('#wait_loader').css({'display':'none'});
                        if(res.status)
                        {
                            swal(res.internalMessage);
                            clearAll();
                            clearFormData();
                            loadDetails(post_doc_no);
                        }
                        else
                        {   
                            swal(res.internalMessage);
                            clearAll();
                            clearFormData();
                            loadDetails(post_doc_no);
                        }                       
                    },
                    error: function(res){
                        $('#wait_loader').css({'display':'none'});
                        swal('Error in getting docket');
                        clearAll();
                        clearFormData();
                        loadDetails(post_doc_no);
                    }
                    
            });
        }).fail(function (result) {
            console.log(result);
        });
        //clearRejections();
        
        //$('#wait_loader').css({'display':'none'});
        $('#enablecutreportdetails').css({'display':'none'});
        if($("#cut_report").is(':checked'))
        {
            
            $('#enablerolls').html('');
            getdetails();
        }
        $('#submit').css({'display':'none'});
        //$('#wait_loader').css({'display':'block'});
        // $.ajax({
        //     url  : '?target='+doc_target_type,
        //     type : 'POST',
        //     data : form_data
        // }).done(function(res){
        //     console.log(res);
        //     try{
        //         var data = $.parseJSON(res);
        //     }catch(e){
        //         swal('Cut Reporting Problem','Data Problem or M3 Updations Failed','warning');
        //         $('#wait_loader').css({'display':'none'});
        //         clearAll();
        //         clearFormData();
        //         clearRejections();
        //         loadDetails(post_doc_no);
        //     }
        //     if(data.concurrent == '1'){
        //         swal('Some Other user Already Reported for this Docket','Please Try now with updated one','info');
        //         loadDetails(post_doc_no);
        //         clearAll();
        //         clearFormData();
        //         clearRejections();
        //     }
            
        //     console.log(data.error_msg);
        //     if(data.error_msg)
        //         error_message = data.error_msg;

        //     if(data.saved == '1'){
        //         if(data.m3_updated == '0')
        //             user_msg = error_message+'M3 Reporting Failed for this docket.';
                
        //         if(data.pass == '1')
        //             swal('Cut Qty Reported Successfully',error_message,'success');
        //         else{
        //             swal('Cut Reporting Problem Error',error_message,'error');
        //             user_msg = 'CUT Reported with Error.Please Do not Proceed to Scanning for this docket';
        //             //swal('Cut Qty Reported Successfully','','success');
        //             //user_msg += 'Cut Reported Successfully';
        //         }
                    
        //         if(rejections_flag){
        //             if(data.rejections_response == '1')
        //                 user_msg += error_message+'Cut Reported Successfully';
        //             else if(data.rejections_response == '2')
        //                 user_msg += error_message+'Cut Reported Successfully , Rejections Saved BUT M3 Reporting Failed.';
        //             else    
        //                 user_msg += error_message+'Cut Reported Successfully BUT Rejections Reporting Failed ';    
        //         }
        //         if(user_msg.length != 0){
        //             $('#user_msg').html(user_msg);
        //             $('.user_msg').css({'display':'block'});
        //         }
        //         clearAll();
        //         clearFormData();
        //         clearRejections();
        //         loadDetails(post_doc_no);
        //         $('#wait_loader').css({'display':'none'});
        //         $('#enablecutreportdetails').css({'display':'none'});
        //         if($("#cut_report").is(':checked'))
        //         {
                    
        //             $('#enablerolls').html('');
        //             getdetails();
        //         }
                 
        //     }else{
        //         $('#wait_loader').css({'display':'none'});
        //         swal('Error Occured While Reporting','Please Report again','error');
        //     }
        // }).fail(function(res){
        //     $('#wait_loader').css({'display':'none'});
        //     swal('Error Reporting Docket','','error');
        //     clearAll();
        //     clearFormData();
        //     clearRejections();
        //     loadDetails(post_doc_no);
        //     console.log(res);
        // });


    });

    $('#fab_returned').on('change',function(){
        var fret = Number($('#fab_returned').val());
        if(fret > 0)
            $('#returend_to_parent').css({'display':'block'});
        else
            $('#returend_to_parent').css({'display':'none'});
    });

    // function load_rejections(){
    //     var size_rej_qty_string = '';
    //     doc_no = $('#doc_no').val();
    //     c_plies = Number($('#c_plies').val());
    //     ratio   = Number($('#ratio').val());
    //     ret = c_plies * ratio;
    //     $('#rejection_size').empty();
    //     $.ajax({
    //             url : '<?= $get_url ?>?rejection_docket='+doc_no
    //     }).done(function(res){
    //         SIZE_COUNT = 0;
    //         console.log(res);
    //         dataR = $.parseJSON(res);
    //         $.each(dataR.old_new_size,function(key,value){
    //             SIZE_COUNT++;
    //             pieces[key] = Number(dataR.old_size_ratio[key]) * c_plies;
    //             pieces_actual[key] =  pieces[key];
    //             size_rej_qty_string += value+' : '+pieces[key]+' &nbsp;&nbsp;'; 
    //             $('#rejection_size').append('<option value='+key+'>'+value+'</option>');
    //             if(GLOBAL_CALL == 0 || CLEAR_FLAG == 1)
    //                 rejections_post[key] = {};
    //         });
    //         GLOBAL_CALL++;
    //         $('.size-rej-pieces').html('<b>'+size_rej_qty_string+'</b>');
    //         $('#total_pieces').val(ret);
    //         $('#avl_pieces').val(ret - total_rejected_pieces);
    //     }).fail(function(){
    //         alert('fail');
    //     });
    // }

    // $('#c_plies').on('change',function(){
    //     if($(this).val > avl_plies){
    //         return swal('Reporting Plies are more than Planned Plies');
    //     }
    //     if($(this).val() > 0){
    //         $('#rejection_pieces').attr('readonly',false);
    //     }else{
    //         $('#rejection_pieces').attr('readonly',true);
    //     }

    //     //ret = Number($('#rejection_pieces').val());
    //     ret = c_plies * ratio;
    //     console.log(ret);
    //     load_rejections();
    //     return false;
    // });

    //To clear all rejection panel data
    function clearAll(){
        $('#rejection_size').empty();
        //$('#save_rejection').css({'display':'block'});
        $('#d_style').html('');
        $('#d_schedule').html('');
        $('#d_color').html('');
        $('#d_doc_type').html('');
        $('#d_cut_no').html('');
        $('#rejections_table_body').empty();
        $('#rejection_pieces').attr({'readonly':false});
        $('#c_plies').attr({'readonly':false});
        $('#cut_report').attr({'disabled':false});
        $('#rejection_pieces').val(0);
        $('#avl_pieces').val(0);
        $('#total_pieces').val(0);
        //$('#rejections_panel_btn').css({'display':'none'});
        $('#hide_details_reporting_ratios').html('');
        $('#hide_details_reporting_ratios').css({'display':'none'});
        document.getElementById('full_reported').checked = false;
    }
    //to clear all the form data 
    function clearFormData(){
        $('#c_plies').attr({'readonly':false});
        $('#cut_report').attr({'disabled':false});
        $('#c_plies').val(0);
        $('#fab_received').val(0);
        $('#damages').val(0);
        $('#fab_returned').val(0);
        $('#joints').val(0);
        $('#endbits').val(0);
        $('#shortages').val(0);
        $('#returned_to').val('');
        $('#returned_to').css({'display':'none'});
        $('#bundle_location').val('');
        $('#team_leader').val('');
        $('#cut_table').val('');
        $('#shift').val('');
        full_reporting_flag = 0;
    }

    // function clearRejections(){
    //     delete pieces;
    //     delete pieces_actual;
    //     delete rejections_post;
    //     console.log(rejections_post);
    //     global_serial_id = 0;
    //     total_rejected_pieces = 0;
    //     rejections_post = {};
    //     ret = 0; 
    //     rejections_flag = 0;
    //     $('#avl_pieces').val(0);
    //     $('#c_plies').attr({'readonly':false});
    //     $('#cut_report').attr({'disabled':false});
        
    //     $('#total_pieces').val(0);
    //     $('#rejection_size').empty();
    //     $('#rejection_pieces').val(0);
    //     //$('#rejections_panel_btn').css({'display':'none'});
    //     $('#d_total_rejections').css({'display':'none'});
    //     $('#rejections_table_body').empty();
    // }
    // //Rejection Panel Code
    // //Clearing all the rejections 
    // $('#clear_rejection').on('click',function(){
    //     if(total_rejected_pieces > 0){
    //         CLEAR_FLAG = 1;
    //         clearRejections();
    //         load_rejections();
    //         //CLEAR_FLAG = 0;
    //         $('#rejections_modal').modal('toggle');
    //     }else{
    //         swal('Nothing To Clear');
    //     }
    //     rejections_flag = 0;
    // });

    //showing the rej panel on button click
    $('#rejections_panel_btn').on('click',function(){
        $('#rejections_modal').modal('toggle');
    });

    //Loading the rejections sizes ratio data
    $('#rejection_pieces').on('change',function(){
        //Initial validation for not allowing to change rejected pieces if sizes,reasons are selected
        // if(total_rejected_pieces > 0){
        //     return swal('You Cannot Change Rejected Pieces.','Please clear all rejections first','warning');
        // }
        doc_no = $('#doc_no').val();
        c_plies = Number($('#c_plies').val());
        ret     = Number($('#rejection_pieces').val());
        ratio   = Number($('#ratio').val());
        var size_rej_qty_string = '';
        if(c_plies == 0){
            return swal('Please Enter Reporting Plies','','error');
        }
        $('#rejection_size').empty();
        if(ret > 0){
            //$('#c_plies').attr('readonly',true);
            if( ret > c_plies * ratio  )
                return swal('You are Returning more than reported Pieces','','error');
            else{
                //$('#rejections_panel').css({'display':'block'});
                //$('#rejections_panel_btn').css({'display':'block'});
                $('#rejections_modal').modal('toggle');
                $.ajax({
                    url : '<?= $get_url ?>?rejection_docket='+doc_no
                }).done(function(res){
                   console.log(res);
                    dataR = $.parseJSON(res);
                    $.each(dataR.old_new_size,function(key,value){
                        pieces[key] = Number(dataR.old_size_ratio[key]) * c_plies;
                       
                        size_rej_qty_string += value+' : '+pieces[key]+' &nbsp;&nbsp;'; 
                        $('#rejection_size').append('<option value='+key+'>'+value+'</option>');
                        rejections_post[key] = {};
                    });
                    $('.size-rej-pieces').html('<b>'+size_rej_qty_string+'</b>');
                    $('#total_pieces').val(ret);
                    $('#avl_pieces').val(ret);
                }).fail(function(){
                    alert('fail');
                });
            }
        }
        else{
            $('#c_plies').attr('readonly',false);
            $('#cut_report').attr('disabled',false);
            
        }
    });

    //action performing on adding new rejection
    $('#add_rejection').on('click',function(){
        //validating if user is adding rejections after clicking save button
        if(rejections_flag == 1)
            return swal('You Saved Rejections','Clear to change','info');
        global_serial_id++;
        var rej_qty = Number($('#rejection_qty').val());
        var size = $('#rejection_size').val();
        var reason = $('#rejection_reason').val();
        //making rejected pieces   read-only 
       
        if(size == null || reason == null)
            return swal('Select Size and Reason first','','warning');
        var size_str = dataR.old_new_size[size];
        var reason_str = $('#rejection_reason option:selected').text();
        
        if(rej_qty > 0){
            pieces[size] = pieces[size] - rej_qty;
            total_rejected_pieces = total_rejected_pieces  + rej_qty;
           
            if(total_rejected_pieces > ret){
                pieces[size] = pieces[size] + rej_qty;
                total_rejected_pieces = total_rejected_pieces - rej_qty;
                return swal('Your are returning more pieces than mentioned','','error');
            }
           
            if(pieces[size] >= 0){
                console.log('Top : '+pieces[size]+' rej '+rej_qty);
                var str = '<tr id="row_'+global_serial_id+'"><td>'+size_str+'</td><td>'+reason_str+'</td>\
                <td>'+rej_qty+'</td><td>\
                <input type="button" value="X" onclick="deleteRej(this)"\
                class="btn btn-sm btn-danger" id="'+global_serial_id+'">\
                <input type="hidden" value="'+rej_qty+'" id="rej_qty_'+global_serial_id+'">\
                <input type="hidden" value="'+reason+'" id="rej_reason'+global_serial_id+'">\
                <input type="hidden" value="'+size+'" id="size_'+global_serial_id+'"></td></tr>';
                
                $('#rejections_table_body').append(str);
                if(rejections_post[size][reason] > 0){
                    rejections_post[size][reason] = Number(rejections_post[size][reason]) + rej_qty;
                    cumulative_size[size] = Number(cumulative_size[size]) + rej_qty;
                }else{
                    rejections_post[size][reason] =  rej_qty;
                    cumulative_size[size] = rej_qty;
                }
                console.log('Top : '+total_rejected_pieces);
                $('#avl_pieces').val(ret - total_rejected_pieces);
                $('#rejection_qty').val(0);
            }else{
                swal('You are returning more than eligible for this size','','error');
                pieces[size] = pieces[size] + rej_qty;
                total_rejected_pieces = total_rejected_pieces - rej_qty;
                $('#rejection_qty').val(0);
                console.log('Bottom : '+total_rejected_pieces);
                console.log('Bottom : '+pieces[size]+' rej '+rej_qty);
                return false;
            }   
        }else{
            swal('Please Enter Rejected Quantity','','warning');
            return false;
        }
        
        if(total_rejected_pieces > 0){
            //$('#rejection_pieces').attr({'readonly':true});
            $('#d_total_rejections').css({'display':'block'});
            $('#d_total_rejections').html('<b> Total Rejections : </b>'+total_rejected_pieces);
        }
    });

    function deleteRej(t){
        //validating if user is adding rejections after clicking save button
        if(rejections_flag == 1)
            return swal('You Saved Rejections','you cannot remove now','info');
        var id = t.id;
        var size = $('#size_'+id).val();
        var reason = $('#rej_reason'+id).val(); 
        var rej_qty = Number($('#rej_qty_'+id).val());

        pieces[size] = pieces[size] + rej_qty; 
        rejections_post[size][reason] = Number(rejections_post[size][reason]) - rej_qty;
        cumulative_size[size] = Number(cumulative_size[size]) - rej_qty;
        total_rejected_pieces = total_rejected_pieces - rej_qty;
        $('#avl_pieces').val(ret - total_rejected_pieces);
        console.log('IN Function : '+pieces[size]+' rej '+rej_qty+' saved = '+total_rejected_pieces);
        console.log(rejections_post);
        $('#row_'+id).remove();
        if(total_rejected_pieces > 0){
            $('#d_total_rejections').css({'display':'block'});
            $('#d_total_rejections').html('<b> Total Rejections : </b>'+total_rejected_pieces);
        }else if(total_rejected_pieces <= 0){
            total_rejected_pieces = 0;
            $('#d_total_rejections').css({'display':'block'});
            $('#d_total_rejections').html('<b> Total Rejections : </b>'+total_rejected_pieces);
        }
        return true;
    }
    /*
    $('#save_rejection').on('click',function(){
        if(ret - total_rejected_pieces > 0)
            return swal('Please Fill Total Rejected Pieces','','error');
        else{
            rejections_flag = 1;
            swal('Ok! Saved Temporarily','','success');
            //$('#rejections_modal').modal('toggle');
            $('#save_rejection').css({'display':'none'});
        }    
    });
    */
    //Rejection Panel Code Ends
    
    
    function loadDetails(doc_no){
        const data={
                      "docketNumber": doc_no
                  }
        $('#wait_loader').css({'display':'block'});
        var bearer_token;
        var getData;
        const creadentialObj = {
        grant_type: 'password',
        client_id: 'pps-back-end',
        client_secret: '1cd2fd2f-ed4d-4c74-af02-d93538fbc52a',
        username: 'bhuvan',
        password: 'bhuvan'
        }
        $.ajax({
            url : '<?= $fabric_status ?>?doc_no='+doc_no       
            }).then(function (res) {
                var data_fabric = $.parseJSON(res);
                 console.log(res);
                if(data_fabric.fabric_status =='5')
                {
                    $.ajax({
                        method: 'POST',
                        url: "<?php echo $KEY_LOCK_IP?>",
                        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                        xhrFields: { withCredentials: true },
                        contentType: "application/json; charset=utf-8",
                        transformRequest: function (Obj) {
                            var str = [];
                            for (var p in Obj)
                                str.push(encodeURIComponent(p) + "=" + encodeURIComponent(Obj[p]));
                            return str.join("&");
                        },
                        data: creadentialObj
                    }).then(function (result) {
                        console.log(result);
                        bearer_token = result['access_token'];
                        $.ajax({
                            type: "POST",
                            url: "<?php echo $PPS_SERVER_IP?>/cut-reporting/getLayReportingDetails",
                            headers: { 'Content-Type': 'application/x-www-form-urlencoded',
                            'Authorization': 'Bearer ' +  bearer_token },
                            data: data,
                            success: function (res) {            
                                console.log(res.status);
                                if(res.status)
                                {
                                    $('#wait_loader').css({'display':'none'});
                                    getData=res.data;
                                    console.log(getData);            
                                    avl_plies = Number((getData.plannedPlies)-(getData.reportedPlies));
                                    fab_req = Number(getData.fabricRequired);
                                    if(getData.cutStatus){
                                        var actCutstatus="Done";
                                    }else{
                                        var actCutstatus="Open";
                                    }
                                    if(getData.cutStatus == 'IN-PROGRESS'){
                                        $('#hide_details_reported').css({'display':'block'});
                                        $('#hide_details_reporting').css({'display':'block'});
                                        $('#hide_details_reporting_ratios').css({'display':'block'});
                                    }else if(getData.cutStatus == 'DONE'){
                                        $('#hide_details_reported').css({'display':'block'});
                                        $('#hide_details_reporting').css({'display':'none'});
                                        $('#hide_details_reporting_ratios').css({'display':'none'});
                                    }else{
                                        $('#hide_details_reported').css({'display':'none'});
                                        $('#hide_details_reporting').css({'display':'block'});
                                        $('#hide_details_reporting_ratios').css({'display':'block'});
                                        
                                    }
                                    var size_data = "<table><b>Size Wise Ratios</b><table class='table table-bordered'><thead><tr class='danger'>";
                                    $.each(getData.sizeRatios, function( index, value ) {
                                        size_data += "<th>"+value.size+"</th>";
                                    });
                                    size_data += "</tr><tr>";
                                    var total_size_ratio = 0;
                                    $.each(getData.sizeRatios, function( index, value ) {
                                        size_data += "<th>"+value.ratio+"</th>";
                                        total_size_ratio += Number(value.ratio);
                                    });
                                    
                                    size_data += "</tr>";
                                    size_data += "<input type='hidden' name='total_size_ratio[]' value='"+total_size_ratio+"'></tr></tbody><table>";
                                    // console.log(size_data);
                                    // console.log(size_data2);
                                    $("#hide_details_reporting_ratios").append(size_data);
                                    /*if(data.partial_roll_wise == '1'){
                                        $('#hide_details_reported_roll_wise').css({'display':'block'});
                                        $rollwisestatus=true;
                                    }
                                    else if(data.cut_done_roll_wise == '1'){
                                        $('#hide_details_reported_roll_wise').css({'display':'block'});
                                        $rollwisestatus=true;
                                    }else{
                                        $('#hide_details_reported_roll_wise').css({'display':'none'});
                                        $rollwisestatus=false;
                                    }*/
                                    // console.log(getData.sizeRatios);
                                    var i;
                                    var sno=1;
                                    $('#reported_table_roll_wise tbody').html('');
                                    /*
                                    if($rollwisestatus)
                                    {
                                        if(data.rollwisedetails) 
                                        {
                                            rollwisedetialslength=data.rollwisedetails.length;
                                            rolwisedet=data.rollwisedetails;
                                            for(i=0;i<rollwisedetialslength;i++)
                                            {
                                                if(rolwisedet[i]['fabric_return']<0)
                                                {
                                                    fabreturn=rolwisedet[i]['fabric_return'];
                                                }
                                                else{
                                                    fabreturn=rolwisedet[i]['fabric_return']; 
                                                }
                                                row = $('<tr><td>'+sno+'</td><td>'+rolwisedet[i]['lay_sequence']+'</td><td>'+rolwisedet[i]['shade']+'</td><td>'+rolwisedet[i]['fabric_rec_qty']+'</td><td>'+fabreturn+'</td><td>'+rolwisedet[i]['reporting_plies']+'</td><td>'+rolwisedet[i]['damages']+'</td><td>'+rolwisedet[i]['joints']+'</td><td>'+rolwisedet[i]['endbits']+'</td><td>'+rolwisedet[i]['shortages']+'</td></tr>');
                                                $('#reported_table_roll_wise').append(row);
                                                sno++;
                                            }
                                        }

                                    }
                                    */
                                    $('.d_doc_type').css({'display':'block'});
                                    $('#d_total_rejections').css({'display':'none'});
                                    //storing doc,plies in hidden fields for post refference
                                    $('#post_doc_no').val(getData.docketNumber);
                                    $('#p_plies').val(getData.plannedPlies);
                                    var final_qty = Number(getData.quantity) * (total_size_ratio);
                                    $('#r_doc_qty').html(final_qty);
                                    $('#doc_target_type').val(getData.doc_target_type);
                                    $('#ratio').val(getData.ratio);
                                    $('#fab_required').val(getData.fabricRequired);
                                    $('#r_fab_required').html(getData.fabricRequired);

                                    //$('#mk_length').val(data.marklength);

                                    //$('#binding_consum').val(data.binding_consumption);
                                    //$('#seperat_dock').val(data.seperate_docket);


                                    //doc type
                                    
                                    $('#d_doc_type').html((getData.docketType)+' Docket');
                                    
                                    //setting size wise ratios
                                    //$('#hide_details_reporting_ratios').html(data.ratio_data);
                                    
                                    //setting values for display table    
                                    $('#d_doc_no').html(getData.docketNumber);
                                    $('#d_cut_no').html(getData.docketNumber);
                                    $('#d_cut_status').html(actCutstatus);
                                    //$('#d_cut_issue_status').html(data.fab_status);
                                    //$('#d_good_pieces').html(data.good_pieces);
                                    /*
                                    if(Number(data.rej_pieces) > 0){
                                        $('#d_rej_pieces').html(data.rej_pieces+"<br/><input type='button' class='btn btn-xs btn-info' value='info' onclick='toggleMe();'>");
                                        $('#rejections_show_table').html(data.rej_size_wise_details);
                                    }else{
                                        $('#d_rej_pieces').html(data.rej_pieces);
                                    }*/
                                    
                                    /*$('#d_date').html(data.date);
                                    $('#d_section').html(data.section);
                                    $('#d_module').html(data.module);
                                    $('#d_shift').html(data.shift);
                                    
                                    $('#d_fab_rec').html(data.fab_received);
                                    $('#d_fab_ret').html(data.fab_returned);
                                    $('#d_damages').html(data.damages);
                                    $('#d_joints').html(data.joints);
                                    $('#d_endbits').html(data.endbits);
                                    $('#d_shortages').html(data.shortages);
                                    $('#d_reported').html(data.reported);
                                    $('#r_doc_qty').html(data.doc_qty);*/

                                    //setting values for reporting table
                                    $('#r_doc_no').html(getData.docketNumber);
                                    $('#r_cut_status').html(actCutstatus);
                                    $('#r_plan_plies').html(getData.plannedPlies);
                                    $('#r_reported_plies').html(getData.reportedPlies);
                                    //setting value to style,schedule,color
                                    $('#d_style').html(getData.style);
                                    $('#d_schedule').html(getData.schedules.toString());
                                    $('#d_color').html(getData.fgColor);
                                    if($('#good_report').val() == 'readonly'){
                                        $('#c_plies').attr('readonly', true);
                                        $('#cut_report').attr('disabled', true);
                                        $('#full_reported').attr('disabled', true);
                                        // $("#c_plies").attr('readonly', 'readonly');
                                        
                                        $('#c_plies').val(0);
                                    } else {
                                        $('#c_plies').val(avl_plies);
                                        $('#c_plies').attr('readonly', false);
                                        $('#cut_report').attr('disabled', false);
                                        $('#full_reported').attr('disabled', false);

                                    }
                                    // $('#c_plies').val(avl_plies);
                                    $('#fab_received').val(fab_req);

                                    $('#post_style').val(getData.style);
                                    $('#post_schedule').val(getData.docketNumber);
                                    $('#post_color').val(getData.fgColor);

                                    //resetting the submmit button
                                    $('#submit').css({'display':'block'});
                                    //load_rejections();
                                    if(data.rollinfo>0)
                                    {
                                        $('.showifcontain').css({'display':'block'});
                                        
                                    }
                                    if(data.rollinfo1>0)
                                    {
                                        $('.showifcontain').css({'display':'none'});
                                        
                                    }

                                    var fret = Number($('#fab_returned').val());
                                    if(fret > 0)
                                    {
                                        $('#returend_to_parent').css({'display':'block'});
                                    } 
                                    else
                                    {
                                        $('#returend_to_parent').css({'display':'none'});

                                        //calculatecutreport();
                                    }
                                        // $('#c_plies').attr('readonly', false);
                                        $('#fab_received').attr('readonly', false);
                                        $('#fab_returned').attr('readonly', false);
                                        $('#damages').attr('readonly', false);
                                        $('#joints').attr('readonly', false);
                                        $('#endbits').attr('readonly', false);
                                        calculatecutreport();   

                                }
                                else
                                {
                                    $('#wait_loader').css({'display':'none'});
                                    swal(res.internalMessage);
                                }                       
                            },
                            error: function(res){
                                $('#wait_loader').css({'display':'none'});
                                swal('Error in getting docket');
                            }
                        });
                    }).fail(function (result) {
                        console.log(result);
                    }) ;
                } else
                {
                    swal('Fabric is not yet issued for this Docket');
                    return false;
                }       
                }).fail(function (result) {
                    swal('Network Error while getting Details');
                    return;
                }) ;
            
            
            console.log(bearer_token);

           console.log(getData);           
            GLOBAL_CALL = 0;        
    }

    function toggleMe(){
        $('#rejections_show_modal').modal('toggle');
    }
</script>

<style>
    .user_msg{
        background : #0055FF;
        border  : 1px solid #000;
        border-radius : 5px;
        opacity : 1;
        padding : 5px;
        display : none;
        color   : #fff;
    }
    .notification{
        color : #fff;
        font-size : 12px;
        opacity : 1;
    }

    .title{
        color : #0000ff; 
        font-size : 14px;

    }
</style>