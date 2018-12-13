<?php
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config_ajax.php');

$get_url = getFullURLLevel($_GET['r'],'cut_rejections_data.php',0,'R');
$rej_url = getFullURLLevel($_GET['r'],'cut_rejections_save.php',0,'R');
$rejection_reasons = array();

$rejection_reason_query = "SELECT reason_code,reason_desc,m3_reason_code from $bai_pro3.bai_qms_rejection_reason 
                        where form_type = 'P' ";
$rejection_reason_result = mysqli_query($link,$rejection_reason_query); 
while($row = mysqli_fetch_array($rejection_reason_result)){
    $rejection_reasons[$row['reason_code'].'-'.$row['m3_reason_code']] = $row['reason_desc'];
}

?>


<!-- Cut Reporting Code -->
<div class='panel panel-primary cut_tab'>
    <div class='panel-heading'>
        <b>Cut Level Rejections</b>
    </div>
    <div class='panel-body'>  
        <div class='row'>       
            <div class='col-sm-6'>
                <table class='table table-bordered'>
                    <tr><td>Style</td>   <td id='d_style'></td>    </tr>
                    <tr><td>Schedule</td><td id='d_schedule'></td> </tr>
                    <tr><td>Color</td>   <td id='d_color'></td>    </tr>
                    <tr><td>Docket Type</td><td id='d_doc_type'></td></tr>
                    <tr><td>Cut No</td><td id='d_cut_no'></td></tr>
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
        <div class='row' id='hide_details_reported'>
            <div class='col-sm-12'>
            <hr> 
            <table class='table table-bordered' id='reported_table'>
                <tr class='danger'>
                    <td>Docket</td>
                    <td>Act Cut Status</td>
                    <td>Cut Issue Status</td>
                    <td>Good Pieces</td>
                    <td>Rejected Pieces</td>
                    <td>Date</td>
                    <td>Section</td>
                    <td>Module</td>
                    <td>Shift</td>
                    <td>Fab Received</td>
                    <td>Fab Returned</td>
                    <td>Fab Damages</td>
                    <td>Fab Shortages</td>
                </tr>
                <tr>
                    <td id='d_doc_no'></td>
                    <td id='d_cut_status'></td>
                    <td id='d_cut_issue_status'></td>
                    <td id='d_good_pieces'></td>
                    <td id='d_rej_pieces'></td>
                    <td id='d_date'></td>
                    <td id='d_section'></td>
                    <td id='d_module'></td>
                    <td id='d_shift'></td>
                    <td id='d_fab_rec'></td>
                    <td id='d_fab_ret'></td>
                    <td id='d_damages'></td>
                    <td id='d_shortages'></td>
                </tr>
                
            </table>
            </div>
            <hr>
        </div><br/><br/>

        <div class='row' id='size_details' style='display:none'>
            <div class='col-sm-6'>
                <table  class='table table-bordered'>
                    <thead><th>Size</th><th>Actual Qty</th><th>Eligible to Reject</th></thead>
                    <tbody id='size_details_body'></tbody>
                </table>
            </div>
            <div class='col-sm-2'>
                <label for='shift'>Shift</label>
                <select class='form-control' name='shift' id='shift'>
                    <option value='' disabled selected>Select Shift</option>
                    <option value='A'>A</option>
                    <?php
                    foreach($shifts_array as $shift){
                        echo "<option value='$shift'>$shift</option>";
                    }
                    ?>
                </select>
            </div>
            <div class='col-sm-2'>
                <label for='rejection_pieces'>Rejection Pieces</label>
               <input type='text' class='form-control integer' place-holder='Rejections' id='rejection_pieces' 
                    name='rejection_pieces' readonly><br><br>
                <input type='button' style='display : none' class='btn btn-sm btn-success' id='rejections_panel_btn' 
                    value='show rejections'>
            </div>
            <div class='col-sm-2'>  
                <label for='submit'><br/></label><br/>   
                <input type='button' class='btn btn-sm btn-success' value='Submit' id='submit'>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="rejections_modal" role="dialog">
    <div class="modal-dialog" style="width: 80%;  height: 100%;">
        <div class="modal-content">
            <div class="modal-header">Cut Pieces Rejections Form
                <button type="button" class="close"  id = "cancel" data-dismiss="modal">&times;</button>
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
                            <span class='col-sm-2'>
                                Total Rejections : 
                                <input type='button' class='btn btn-success' id='total_pieces'>
                            </span>
                            <span class='col-sm-3'>
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
                                <label for='rejection_reason'>Rejection Reason</label> 
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
                            <div class='col-sm-2'>
                                <label for='add_rejection'>&nbsp;</label><br/>
                                <input type='button' class='btn btn-warning' value='+' name='add_rejection' id='add_rejection'>
                            </div>
                            <div class='col-sm-offset-1 col-sm-2'>
                                <label for='save_rejection'>&nbsp;</label><br/>
                                <input type='button' class='btn btn-primary confirm-submit' value='Save' name='save_rejection' id='save_rejection'>&nbsp;
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
            <input type='hidden' value='' id='post_doc_no'>  
            <input type='hidden' value='' id='doc_target_type'>
            <input type='hidden' value='' id='post_schedule'>
            <input type='hidden' value='' id='post_style'>
            <input type='hidden' value='' id='post_color'>
        </div>
    </div>
</div>



<script>
    var avl_plies = 0;
    var doc_no = 0;
    var c_plies = 0;
    var pieces = {};
    var dataR;
    var global_serial_id = 0;
    var total_rejected_pieces = 0;//this variable is for how many pieces he selected size and reason
    var ret = 0; //This variable is to store front end user given rejection pieces
    var rejections_post = {};
    var rejections_flag = 0;
    var avl_to_reject = 0;

    $('#doc_no').on('change',function(){
        doc_no = $('#doc_no').val();
        $('.user_msg').css({'display':'none'});
        $('#hide_details_reported').css({'display':'none'});
        clear_all();
        load_details(doc_no);
    });

    $('#submit').on('click',function(){
        var post_doc_no = $('#post_doc_no').val();
        var doc_target_type = $('#doc_target_type').val();
        var style       = $('#post_style').val();
        var schedule    = $('#post_schedule').val();
        var color       = $('#post_color').val();
        var shift       = $('#shift').val();
        //Screen Validations
        if(shift == null)
            return swal('Please Select Shift','','warning');
        if(ret <= 0)
            return swal('Please Fill Rejection Pieces','','error'); 
        //Screen Validations End

        //Rejections Validation
        if(rejections_flag == 1){
            if(total_rejected_pieces == ret){
                
            }else{
                return swal('Please Fill the Rejections Completely','','warning');
            }
        }else if(rejections_flag == 0){
            if(ret > 0)
                return swal('Please Fill Rejections','','error');
        }
        //Rejections Validation End

        var user_msg = '';
        var form_data = {
                         doc_no:post_doc_no,doc_target_type:doc_target_type,shift:shift,
                         style:style,color:color,schedule:schedule,rejections_flag:rejections_flag,rejections:rejections_post
                        };
        //AJAX Call
        console.log(form_data);
        
        $.ajax({
            url  : '<?= $rej_url ?>?target='+doc_target_type,
            type : 'POST',
            data : form_data
        }).done(function(res){
            console.log(res);
            var data = $.parseJSON(res);
            if(data.saved == '1'){
                swal('Rejections Saved Successfully','','success');
            }else if(data.saved == '2'){
                swal('Rejections Saved','M3 Reporting went wrong','warning');
            }else{
                swal('Rejections not saved','','error');
            }
            clear_all();
            load_details(post_doc_no);
        }).fail(function(res){
            swal('Error Reporting Docket','','error');
            clear_all();
            load_details(post_doc_no);
            console.log(res);
        });
    });

    function clear_all(){
        delete pieces;
        delete rejections_post;
        global_serial_id = 0;
        total_rejected_pieces = 0;
        ret = 0; 
        rejections_flag = 0;
        $('#d_style').html('');
        $('#d_schedule').html('');
        $('#d_color').html('');
        $('#d_doc_type').html('');
        $('#d_cut_no').html('');
        $('#rejection_size').html('');
        $('#rejections_table_body').empty();
        $('#size_details').hide();
        $('#size_details_body').empty();
        $('#size_wise_data').empty();
        $('#rejection_pieces').attr({'readonly':false});
        $('#rejection_pieces').val(0);
        $('#avl_pieces').val(0);
        $('#total_pieces').val(0);
        $('#rejections_panel_btn').css({'display':'none'});
    }

    $('#clear_rejection').on('click',function(){
        if(total_rejected_pieces > 0){
            clear_all();
            $('#rejections_modal').modal('toggle');
        }else{
            swal('Nothing To Clear');
        }
        rejections_flag = 0;
    });

    
    //showing the rej panel on button click
    $('#rejections_panel_btn').on('click',function(){
        $('#rejections_modal').modal('toggle');
    });

    //Loading the rejections sizes ratio data
    $('#rejection_pieces').on('change',function(){
        //Initial validation for not allowing to change rejected pieces if sizes,reasons are selected
        if(total_rejected_pieces > 0){
            return swal('You Cannot Change Rejected Pieces.','Please clear all rejections first','warning');
        }
        
        c_plies = Number($('#c_plies').val());
        ret     = Number($('#rejection_pieces').val());
        var ratio   = Number($('#ratio').val());
        var size_rej_qty_string = '';
        if(c_plies == 0){
            return swal('Please Enter Reporting Plies','','error');
        }
        
        if(ret > 0){
            if( ret > avl_to_reject ){
                $('#rejection_pieces').val(0);
                return swal('You are Returning more than Eligible to Reject','','error');
            }else{
                //$('#rejections_panel').css({'display':'block'});
                $('#rejections_panel_btn').css({'display':'block'});
                $('#rejections_modal').modal('toggle');
                $.ajax({
                    url : '<?= $get_url ?>?rejection_docket='+doc_no
                }).done(function(res){
                   console.log(res);
                    dataR = $.parseJSON(res);
                    $.each(dataR.old_new_size,function(key,value){
                        pieces[key] = Number(dataR.remaining_qty[key]);
                        size_rej_qty_string += value+' : '+pieces[key]+' &nbsp;&nbsp;'; 
                        $('#rejection_size').append('<option value='+key+'>'+value+'</option>');
                        rejections_post[key] = {};
                    });
                    $('#size_details').css({'display':'block'});
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
        }
    });

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
                <input type="button" value="X" onclick="delete_rej(this)"\
                class="btn btn-sm btn-danger" id="'+global_serial_id+'">\
                <input type="hidden" value="'+rej_qty+'" id="rej_qty_'+global_serial_id+'">\
                <input type="hidden" value="'+reason+'" id="rej_reason'+global_serial_id+'">\
                <input type="hidden" value="'+size+'" id="size_'+global_serial_id+'"></td></tr>';
                
                $('#rejections_table_body').append(str);
                if(rejections_post[size][reason] > 0)
                    rejections_post[size][reason] = Number(rejections_post[size][reason]) + rej_qty;
                else
                    rejections_post[size][reason] =  rej_qty;
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
            $('#rejection_pieces').attr({'readonly':true});
        }
    });

    function delete_rej(t){
        //validating if user is adding rejections after clicking save button
        if(rejections_flag == 1)
            return swal('You Saved Rejections','you cannot remove now','info');
        var id = t.id;
        var size = $('#size_'+id).val();
        var reason = $('#rej_reason'+id).val(); 
        var rej_qty = Number($('#rej_qty_'+id).val());

        pieces[size] = pieces[size] + rej_qty; 
        rejections_post[size][reason] = Number(rejections_post[size][reason]) - rej_qty;
        total_rejected_pieces = total_rejected_pieces - rej_qty;
        $('#avl_pieces').val(ret - total_rejected_pieces);
        console.log('IN Function : '+pieces[size]+' rej '+rej_qty+' saved = '+total_rejected_pieces);
        console.log(rejections_post);
        $('#row_'+id).remove();
        return true;
    }

    $('#save_rejection').on('click',function(){
        if(ret - total_rejected_pieces > 0)
            return swal('Please Fill Total Rejected Pieces','','error');
        else{
            rejections_flag = 1;
            swal('Ok! Saved Temporarily','','success');
            $('#rejections_modal').modal('toggle');
        }    
    });

    $(document).ready(function(){
        $('.rej_tab').css({'display':'none'});
        $('#hide_details_reported').css({'display':'none'});
    });


    function load_details(doc_no){
        $.ajax({
            url : '<?= $get_url ?>?doc_no='+doc_no
        }).done(function(res){
            var data = $.parseJSON(res);
            avl_plies = Number(data.avl_plies);
            console.log(data);
            console.log(data.avl_plies);
            if(data.child_docket == '1'){
                swal('Error','Child Docket Cannot be Reported','error');
                return false;
            }
            if(data.can_report == '0'){
                swal('Error','You Cannot Report This Docket','error');
                return false;
            }
            if(data.can_report == '2'){
                swal('Error','Fabric is not yet issued for this Docket','error');
                return false;
            }
            
            if(data.error == '1'){
                swal('Error','Docket Doesnt Exist','error');
                return false;
            }

            if(data.partial == '1'){
                $('#hide_details_reported').css({'display':'block'});
                $('#size_details').css({'display':'block'});
            }else if(data.cut_done == '1'){
                $('#hide_details_reported').css({'display':'block'});
                $('#size_details').css({'display':'block'});
            }else{
                $('#hide_details_reported').css({'display':'none'});
                swal('Cut was not Reported','Please Report Cut','error');
                //alert();
                return;
            }
            avl_to_reject = Number(data.avl_to_reject);
            $('#size_details_body').html(data.size_wise_data);
            $('.d_doc_type').css({'display':'block'});
            //storing doc,plies in hidden fields for post refference
            $('#post_doc_no').val(data.doc_no);
            $('#p_plies').val(data.p_plies);
            $('#doc_target_type').val(data.doc_target_type);
            $('#ratio').val(data.ratio);

            //doc type
            $('#d_doc_type').html(data.doc_target_type+' Docket');
            //setting values for display table    
            $('#d_doc_no').html(doc_no);
            $('#d_cut_no').html(data.acut_no);
            $('#d_cut_status').html(data.act_cut_status);
            $('#d_cut_issue_status').html(data.fab_status);
            $('#d_good_pieces').html(data.good_pieces);
            $('#d_rej_pieces').html(data.rej_pieces);
            $('#d_date').html();
            $('#d_section').html(data.section);
            $('#d_module').html(data.module);
            $('#d_shift').html(data.shift);
            $('#d_fab_rec').html(data.fab_received);
            $('#d_fab_ret').html(data.fab_returned);
            $('#d_damages').html(data.damages);
            $('#d_shortages').html(data.shortages);
            
            //setting values for reporting table
            $('#r_doc_no').html(doc_no);
            $('#r_cut_status').html(data.act_cut_status);
            $('#r_plan_plies').html(data.p_plies);
            $('#r_reported_plies').html(data.a_plies);
            
            //setting value to style,schedule,color
            $('#d_style').html(data.styles);
            $('#d_schedule').html(data.schedules);
            $('#d_color').html(data.colors);
            
            $('#post_style').val(data.styles);
            $('#post_schedule').val(data.schedules);
            $('#post_color').val(data.colors);
        }).fail(function(){
            swal('Network Error while getting Details','','error');
            return;
        });
    }
</script>



