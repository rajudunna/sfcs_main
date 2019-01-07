
<div class='col-sm-12'>
    <div class='panel panel-primary'>
        <div class='panel-heading'>
            <b>Ratio Splitting </b>
        </div>
        <div class='panel-body'>
            <div class='col-sm-12'>
                <label>Enter Docket No : </label><br/>
                <input name='docket' type='text' class='form-control integer' onchange='load_details(this)'>
                <hr/>
            </div>
            <div class='col-sm-12' id='details_block' style='display : none'>
                <div class='col-sm-4' style='font-size : 12px'>
                    <label class='label label-warning'>Docket  : </label><span id='d_doc_no'></span>
                </div>
                <div class='col-sm-4'>
                    <label class='label label-warning'>Plies  : </label><span id='d_org_plies'></span>
                </div>
            </div>
        </div>
    </div>
</div>



<script>
function load_details(t){
    clear_data();
    var doc = Number(t.value);
    if(doc > 0){
        $.ajax({
            url  : '<?= $get_url ?>?fetch=1&doc_no='+doc,
            type : 'GET',
            data : form_data
        }).done(function(res){
            var data = $.parseJSON(res);
            $('#details_block').show();
            $('#d_doc_no').html(doc);
            $('#d_org_plies').html(data.org_plies);
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

<?php



?>