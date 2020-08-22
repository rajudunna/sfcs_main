<div class="panel panel-primary">
    <div class="panel-heading">Sewing Jobs Split</div>
    <div class="panel-body">
        <?php
            if(isset($_GET['sewing_job']))
            {
                $sj_number = $_GET['sewing_job'];
                $plant_code = $_GET['plant_code'];
                $schedule = $_GET['schedule'];
                $po_number = $_GET['po_number'];
                
                $link = getFullURL($_GET['r'],'input_job_split.php','N');
                echo "<input type='text' id='schedule' class='btn btn-success' value=$schedule  readonly> >> ";
                echo "<input type='text' id='po_number' class='btn btn-warning' value=$po_number  readonly> >> ";
                echo "<input type='text' id='sj_number' class='btn btn-info' value=$sj_number  readonly>";
                echo "<input type='hidden' id='plant_code' class='form-control' value=$plant_code >";
                echo "<a href='".$link."' class='btn btn-primary pull-right'> << Back</a>";
            }
        ?>
        <div id ="dynamic_table">
		</div>
    </div>
</div>

<script>
$(document).ready(function() {
    var sj = $('#sj_number').val();
    var plant_code = $('#plant_code').val();
    if(sj != ''){
        var sjObj = {sewingJobNumber:sj,plantCode:plant_code};
        var function_text = "<?php echo getFullURL($_GET['r'],'scanning_ajax.php','R'); ?>";
        $.ajax({
            type: "POST",
            url: function_text+"?sjObj="+sjObj,
            success: function(response)
            {
                var data = JSON.parse(response);
                var table_data = "<table class='table table-bordered table-striped'><thead><tr><td>Action</td><td>Style</td><td>Schedule</td><td>Color</td><td>Size</td><td>Bundle No</td><td>Total Bundle Qty</td></tr></thead><tbody>";
                for(var i=0; i< data.Outobj.bundle.length; i++){
                    table_data +="<tr><td><input type='checkbox' name='split' id='split' value='"+data.Outobj.bundle[i].bundleNo+"' class='custom'></td><td>"+data.Outobj.style+"</td><td>"+data.Outobj.SCHEDULE+"</td><td>"+data.Outobj.color+"</td><td>"+data.Outobj.bundle[i].size+"</td><td>"+data.Outobj.bundle[i].bundleNo+"</td><td>"+data.Outobj.bundle[i].qty+"</td></tr>";
                }
                table_data += '</tbody></table><input type="button" class="btn btn-primary" onclick=sendResponse() value="Split">';
                $('#dynamic_table').html(table_data);
            }
        });

    }
});

function sendResponse(){
    var sj_number = $('#sj_number').val();
    var SlectedList = new Array();
    if($('input:checkbox[name=split]:checked').length > 0){
        $('input:checkbox[name=split]:checked').each(function() 
        {
            SlectedList.push($(this).val());
        });
    } else {
        sweetAlert('Please select atleast One Bundle');
    }
    var outputObj = {sewingJobNumber:sj_number,bundleNo:SlectedList};
    console.log(outputObj);
}
</script>