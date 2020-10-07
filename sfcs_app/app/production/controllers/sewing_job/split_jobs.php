
<?php
    include(getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));
    include(getFullURLLevel($_GET['r'],'common/config/functions.php',4,'R'));
    include(getFullURLLevel($_GET['r'],'common/config/server_urls.php',4,'R'));
    $plant_code = $_SESSION['plantCode'];
?> 

<div class="panel panel-primary">
    <div class="panel-heading">Sewing Jobs Split</div>
    <div class="panel-body">
        <?php
            $username=$_SESSION['userName'];
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
                echo "<a href='".$link."' class='btn btn-primary pull-right' id='goBack'> << Back</a>";
            }
        ?>
        <div class="ajax-loader" id="loading-image" style="margin-left: 45%;margin-top: 35px;border-radius: -80px;width: 88px;">
            <img src='<?= getFullURLLevel($_GET['r'],'ajax-loader.gif',0,'R'); ?>' class="img-responsive" />
        </div>
        <div id ="dynamic_table">
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
	$('#loading-image').show();
    var sj = $('#sj_number').val();
    var plant_code = $('#plant_code').val();
    if(sj != ''){
        var sjObj = {"jobNumber":sj,"plantCode":plant_code};
        var bearer_token;
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
                url: "<?php echo $PPS_SERVER_IP?>/jobs-generation/getJobBundleDetailsWithBundles",
                headers: { 'Content-Type': 'application/x-www-form-urlencoded','Authorization': 'Bearer ' +  bearer_token },
                data: sjObj,
                success: function (res) {            
                    console.log(res.data);
                    if(res.status)
                    {
                        $('#loading-image').hide();
                        var data = res.data
                        var table_data = "<table class='table table-bordered table-striped'><thead><tr><td>Action</td><td>Style</td><td>Schedule</td><td>Color</td><td>Size</td><td>Bundle No</td><td>Total Bundle Qty</td></tr></thead><tbody>";
                        for(var i=0; i< data.bundleInfo.length; i++){
                            table_data +="<tr><td><input type='checkbox' name='split' id='split' value='"+data.bundleInfo[i].bundleNo+"' class='custom'></td>\
                            <td>"+data.style+"</td><td>"+data.bundleInfo[i].schedule+"</td><td>"+data.bundleInfo[i].color+"</td>\
                            <td>"+data.bundleInfo[i].size+"</td><td>"+data.bundleInfo[i].bundleNo+"</td><td>"+data.bundleInfo[i].qty+"</td></tr>";
                        }
                        table_data += '</tbody></table><input type="button" class="btn btn-primary" onclick="sendResponse()" id="split" value="Split">';
                        $('#dynamic_table').html(table_data);
                    }
                    else
                    {
                        swal(res.internalMessage);
                    }                       
                },
                error: function(res){
                    swal('Error in getting data');
                }
            }); 
        }).fail(function (result) {
            console.log(result);
        }) ;
    }
});

function sendResponse(){
    var sj_number = $('#sj_number').val();
    var slectedList = new Array();
    if($('input:checkbox[name=split]:checked').length > 0){
		document.getElementById("split").disabled = true;
        $('input:checkbox[name=split]:checked').each(function() 
        {
            slectedList.push($(this).val());
        });
    } else {
        sweetAlert('Please select atleast One Bundle');
    }
    var outputObj = { "sewingJobNumber": sj_number, "bundleNo":slectedList, "plantCode": '<?= $plant_code ?>', "createdUser": '<?= $username ?>' };
    console.log(outputObj);
    var bearer_token;
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
            url: "<?php echo $PPS_SERVER_IP?>/jobs-generation/spllitSewingJob",
            headers: { 'Content-Type': 'application/x-www-form-urlencoded','Authorization': 'Bearer ' +  bearer_token },
            data: outputObj,
            success: function (res) {            
                $('input:checkbox[name=split]:checked').each(function() 
                {
                    $(this).prop("checked",false);
                });
                if(res.status)
                {
                    swal('',res.internalMessage, 'success');
                    document.getElementById("split").disabled = true;
                    location.reload();
                    
                    // $('#goBack').trigger("click");
                    /*
                    var data = JSON.parse(res);

                    var table_data = "<table class='table table-bordered table-striped'><thead><tr><td>Action</td><td>Style</td><td>Schedule</td><td>Color</td><td>Size</td><td>Bundle No</td><td>Total Bundle Qty</td></tr></thead><tbody>";
                    for(var i=0; i< data.Outobj.bundle.length; i++){
                        table_data +="<tr><td><input type='checkbox' name='split' id='split' value='"+data.Outobj.bundle[i].bundleNo+"' class='custom'></td><td>"+data.Outobj.style+"</td><td>"+data.Outobj.SCHEDULE+"</td><td>"+data.Outobj.color+"</td><td>"+data.Outobj.bundle[i].size+"</td><td>"+data.Outobj.bundle[i].bundleNo+"</td><td>"+data.Outobj.bundle[i].qty+"</td></tr>";
                    }
                    table_data += '</tbody></table><input type="button" class="btn btn-primary" onclick=sendResponse() value="Split">';
                    $('#dynamic_table').html(table_data);
                    */
                }
                else
                {
                    swal(res.internalMessage);
                }                       
            },
            error: function(res){
                swal('Error in getting data');
            }
        });    
    }).fail(function (result) {
        console.log(result);
    }) ;
}
</script>