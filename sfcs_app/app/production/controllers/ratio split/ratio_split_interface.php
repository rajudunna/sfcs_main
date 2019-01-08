<?php
    $get_url = getFullURLLevel($_GET['r'],'ratio_split_get_details.php','R');
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
                    <input name='docket' type='text' class='form-control integer' onchange='load_details(this)'>
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
            </div>
        </div>
    </div>
</div>



<script>
    var count = 0;
    var a_plies = 0;
    function load_shades(t){
        $('#shades_table').html('');
        var shades = Number(t.value);
        count = shades; 
        $('#shades_table').append("<tr class='danger'><td>Shade</td><td>Plies</td></tr>");
        while(shades-- > 0){
            $('#shades_table').append("<tr>\
            <td><input id='shade_"+shades+"' type='text' class='form-control required shades'></td>\
            <td><input id='plies_"+shades+"' type='text' class='form-control integer plies required'></td>\
            </tr>");
        }
        $('#shades_table').append("<tr><td colspan=2>\
        <input name='submit' type='submit' class='btn btn-warning btn-sm' value='Submit' onclick='submit_data()'></td>\
        </tr>");
    }

    function submit_data(){
        $('.shades').each(function(s){
            console.log(s.value);
        });

    }

    function load_details(t){
        clear_data();
        var doc = Number(t.value);
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

                if(data.found == '0')
                    return swal('Sewing Jobs Do Not Exist for the Docket',doc,'error');

                a_plies = data.plies;  
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
        $('#details_block').hide();
        $('#d_doc_no').html('');
        $('#d_org_plies').html('');
    }
</script>
