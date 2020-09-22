<?php
    include(getFullURLLevel($_GET['r'],'common/config/config.php',5,'R'));
    include(getFullURLLevel($_GET['r'],'common/config/functions.php',5,'R'));
    include(getFullURLLevel($_GET['r'],'common/config/server_urls.php',5,'R'));
    $op_code=$_POST['operation_code'];
    $module = $_POST['Module'];
    $workstation_desc = $_POST['workstation_code'];
    $from_module = $_POST['assigned_module'];
    $schedule = $_POST['schedule'];
    $plantcode=$_POST['plant_code'];
	$username=$_POST['username'];
    $original_qty = $_POST['original_qty'];
    $ops_code = explode("-",$op_code)[1];
?>

<style>
#loading-image{
  position:fixed;
  top:0px;
  right:0px;
  width:100%;
  height:100%;
  background-color:#666;
  /* background-image:url('ajax-loader.gif'); */
  background-repeat:no-repeat;
  background-position:center;
  z-index:10000000;
  opacity: 0.4;
  filter: alpha(opacity=40); /* For IE8 and earlier */
}
th,td{
    color: black;
}
</style>
<div class="ajax-loader" id="loading-image" style="display: none">
    <center><img src='<?= getFullURLLevel($_GET['r'],'ajax-loader.gif',0,'R'); ?>' class="img-responsive" style="padding-top: 250px"/></center>
</div>

<div class="panel panel-primary " id="scanBarcode">
<div class="panel-heading" >Bundle Transfer Barcode Scanning</div>
    <div class="panel-body">
        <div class="row jumbotron "> 
            <div class="col-md-5">
                <div class="col-padding">
                        <div class="row">
                            <!-- <div class="col-md-12">
                            <h4><label>Operation Name : </label> <?php echo $op_code;?></h4>                    
                            </div> -->
                            <div class="col-md-12">
                            <h4><label>Module Name : </label>  <?php echo $workstation_desc;?></h4>
                            </div>
                        </div>
                        <br/>
                    <!-- <input type="hidden" id="operation_id" class="form-control input-lg" name="operation_id" value="<?php echo $op_code;?>"> -->
                    <input type="hidden" id="module" class="form-control input-lg" name="module" value="<?php echo $module;?>">
                    <input type="hidden" id="plant_code" name="plant_code" value='<?= $plantcode; ?>'>
                    <input type="text" id="barcode" class="form-control input-lg" name="barcode" placeholder="scan here" autofocus>
                    <br>                    
                                        
                </div>
            </div>
            <div class="col-md-5">
                <div id ="dynamic_table2">
                </div>
            </div>
        </div>
        <div id ="dynamic_table1">
                </div>
    </div>  
</div>

<script>
$(document).ready(function() 
{
    $('#barcode').focus();
    $('#loading-image').hide();
    $("#barcode").keypress(function()
    {
        $('#dynamic_table1').html('');
        $('#loading-image').show();
        
        var barcode = $('#barcode').val();
        // var operation_id = $('#operation_id').val();
        var plant_code = $('#plant_code').val();
        var tomodule = $('#module').val();
        var bundet;
        const data={
                        "bundleNumber": [barcode],
                        "plantCode": plant_code,
                        "resourceId": tomodule,
                        "createdUser": '<?= $username ?>'
                    }
        $.ajax({
            type: "POST",
            url: "<?php echo $PPS_SERVER_IP?>/jobs-generation/transferBundlesToWorkStation",
            data: data,
            success: function (res) {            
                //console.log(res.data);
                if(res.status)
                {
                    bundet=res.data;
                    tableConstruction(res,barcode,tomodule);
                }
                else
                {
                    swal('',res.internalMessage,'error');
                }                       
                $('#loading-image').hide();
            },
            error: function(res){
                swal('Error in getting data');
                $('#loading-image').hide();
            }
        });
    }); 
});

function tableConstruction(res,barcode,tomodule){
    s_no = 0;
    if(res)
    {
        $('#dynamic_table1').html('');
        // for(var i=0;i<bundet.length;i++)
        // {
			// if(bundet.data[i].fromModule!='' || bundet.data[i].fromModule!=null)
			// {
				var hidden_class='';
				if(i==0)
				{
					var markup = "<div class='container'><div class='row'><div id='no-more-tables'><table class = 'col-sm-12 table-bordered table-striped table-condensed cf' id='dynamic_table'><thead class='cf'><tr><th>S.No</th><th>Bundle Number</th><th>To Module</th><th>Remarks</th></tr></thead><tbody>";
					$("#dynamic_table1").append(markup);
				}
				s_no++;
				
				var markup1 = "<tr class="+hidden_class+"><td data-title='S.No'>"+s_no+"</td><td data-title='bundlenumber'>"+barcode+"</td><td data-title='status'>"+tomodule+"</td><td data-title='internalMessage'>"+res.internalMessage+"</td></tr>";
				$("#dynamic_table").append(markup1);
				$("#dynamic_table").hide();
				
				// $('#dynamic_table2').html('');
				// var dynamic2="<table class = 'col-sm-12 table-bordered table-striped table-condensed cf' id='dynamic_table2'><thead class='cf'><tr><td>Bundle Number</td><td>"+barcode+"</td></tr><tr><td>Operation</td><td>"+bundet.data[i].operation+"</td></tr><tr><td>Status</td><td>"+bundet.status+"</td></tr></thead><tbody>";
				// $("#dynamic_table2").append(dynamic2);
				// $("#dynamic_table2").show();
			// }
			// else
			// {
				// $('#dynamic_table2').html('');
				// var dynamic2="<table class = 'col-sm-12 table-bordered table-striped table-condensed cf' id='dynamic_table2'><thead class='cf'><tr><td>Bundle Number</td><td>"+bundet.data[i].bundleNumber+"</td></tr><tr><td>Operation</td><td>"+bundet.data[i].operation+"</td></tr><tr><td>Status</td><td>"+bundet.status+"</td></tr></thead><tbody>";
				// $("#dynamic_table2").append(dynamic2);
				// $("#dynamic_table2").show();
			// }
        // }
    }
    var markup99 = "</tbody></table></div></div></div>";
    $("#dynamic_table").append(markup99);
    $("#dynamic_table").show();
    $('#barcode').val('');
    $('#loading-image').hide();
	
    swal('Success','Successfully Transfered','success');
    
}

</script>
<style>
.hidden_class,hidden_class_for_remarks{
    display:none;
}

</style>