<?php
    $get_url  = getFullURLLevel($_GET['r'],'ratio_split_get_details.php',0,'R');
    $post_url = getFullURLLevel($_GET['r'],'ratio_split_save.php',0,'R');
?>
<div class='col-sm-12'>
    <div class='panel panel-primary'>
        <div class='panel-heading'>
            <b>Ratio Splitting </b>
        </div>
        <div class='panel-body'>
            <div class='row'>
                <div class='col-sm-2'>
                    <label>Enter Docket No : </label>
                    <input name='docket' id='docket' type='text' class='form-control integer' onchange='load_details(this)'>
                </div>
            </div>
            <div class='row' id='details_block' style='display : none'>
            <hr/>
                <div class='col-sm-12' style='font-size : 12px'>
                    <table class='table table-bordered'> 
                        <tr class='info'><th>Style</th><th>Schedule</th><th>Color</th>
                            <th>Doc No</th><th>Actual Plies</th>
                        </tr>
                        <tr>
                            <td id='d_style'></td>
                            <td id='d_schedule'></td>
                            <td id='d_color'></td>
                            <td id='d_doc_no'></td>
                            <td id='d_plies'></td>
                        </tr>
                    </table>
                </div>
                <div class='col-sm-12'>
                    <div class='col-sm-2'>
                        <label>No of Shades</label>
                        <input name='shades' type='text' class='form-control' placeholder='shades' onchange='load_shades(this)'>
                    </div>
                </div>
                <div class='col-sm-3'>
                    <br/>
                    <table id='shades_table' class='table table-bordered'>
                    </table>
                </div>
                <div class='col-sm-offset-2 col-sm-4'>
                    <span id='loading_div'><b style='font-size : 20px;color:#ff0000'>Please Wait...</b></span>
                </div>
            </div>
        </div>
    </div>
</div>



<script>
    var count = 0;
    var a_plies = 0;
    var shades = 0;
    var e_plies = 0;
    var doc = 0;
    var schedule = '';
    function load_shades(t){
        $('#shades_table').html('');
        shades = Number(t.value);
        if(shades <= 1)
            return swal('You cannot have 1 shade','','error');
        count = shades; 
        $('#shades_table').append("<tr class='danger'><td>Shade</td><td>Plies</td></tr>");
        while(shades-- > 0){
            $('#shades_table').append("<tr>\
            <td><input id='shade_"+shades+"' name='shades[]' type='text' class='form-control required shades'></td>\
            <td><input id='plies_"+shades+"' name='plies[]' type='text' class='form-control integer plies required'></td>\
            </tr>");
        }
        $('#shades_table').append("<tr><td colspan=2>\
        <input name='submit' type='submit' class='btn btn-warning btn-sm' value='Submit' onclick='submit_data()'></td>\
        </tr>");
    }

    function checkIfArrayIsUnique(myArray) {
        var unique = myArray.filter((v, i, a) => a.indexOf(v) === i); 
        return myArray.length == unique.length;
    }

    function submit_data(){
        var no_shades = 0,no_plies = 0,duplicates = 0;
        var shades = {};
        var shades_plies = {};
        e_plies = 0;
        $('.shades').each(function(key,e){
            console.log(e.value);
            if(e.value == null || e.value == '')
                no_shades++;
            else{
                shades[key] = e.value;
                // if(checkIfArrayIsUnique(shades) == false)
                //     duplicates++; 
            }    
        });
        if(duplicates > 0){
            return swal('Shades are Duplicated','','warning');
        }
        $('.plies').each(function(key,e){
            if(e.value == null || e.value == '' || e.value == 0) 
                no_plies++;
            else{    
                e_plies = e_plies + Number(e.value); 
                shades_plies[key] = e.value;  
            } 
        });
        if(no_plies > 0 || no_shades > 0)
            return swal('Fill All the Shades and plies','','warning');
        console.log(e_plies+' - '+a_plies);
        if(e_plies != a_plies)
            return swal('Original Plies not equal to Entered Plies','','error');
        
        var post_data = {doc_no : doc,a_plies:a_plies,plies : a_plies,shades : shades,shades_plies : shades_plies,schedule:schedule};
        console.log(post_data);
        console.log(shades);    
        console.log('Fine');
        $('#loading_div').show();
        $.ajax({
            url  : '<?= $post_url ?>',
            type : 'POST',
            data : post_data,
        }).done(function(res){
            try{
                var data = $.parseJSON(res);
            }catch(e){
                return swal('Problem incurred while Fetching Details','','error');
            }
            if(data.exist == 'yes')
                return swal('Jobs Related to the schedule already Scanned','You Cannot Split the Sewing Jobs','error'); 
            if(data.save == 'success'){
                swal('Jobs Splitted Successfully','','success');
                $('#docket').val('');
                clear_data();
            }
        }).error(function(res){
            swal('Network Error','Try Again','error');
            $('#loading_div').display('none');
        });
    }

    function load_details(t){
        clear_data();
        doc = Number(t.value);
        if(doc > 0){
            $.ajax({
                url  : '<?= $get_url ?>?fetch=1&doc_no='+doc,
                type : 'GET'
            }).done(function(res){
                try{
                    var data = $.parseJSON(res);
                }catch(e){
                    return swal('Problem incurred while Fetching Details','','error');
                }
                console.log(data.found);    
                if(data.found == '0')
                    return swal('Sewing Jobs Do Not Exist for the Docket','','error');
                else if(data.can_split == '0')
                    return swal('You Cannot Split the Sewing Jobs for Docket','','error');
                else if(data.clubbed == '1')
                    return swal('You Cannot Split the Sewing Jobs for Schedule Clubbed Dockets','','error');
                else if(data.scanned == '1')
                    return swal('Jobs Related to the schedule already Scanned','You Cannot Split the Sewing Jobs','error');        
                a_plies  = data.plies;  
                schedule = data.schedule;

                $('#details_block').show();
                $('#d_style').html(data.style);
                $('#d_schedule').html(data.schedule);
                $('#d_color').html(data.color);
                $('#d_doc_no').html(doc);
                $('#d_plies').html(data.plies);
               
            }).fail(function(res){
                swal('Error Getting Docket','','error');
                t.value = '';
            });
        }
    }

    function clear_data(){
        $('#loading_div').hide();
        $('#details_block').hide();
        $('#d_doc_no').html('');
        $('#d_org_plies').html('');
        $('#shades_table').html('');
        e_plies = 0;
        a_plies = 0;
        shades  = 0;
        count   = 0;
    }
</script>
