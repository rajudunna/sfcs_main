<head>
<script src="/sfcs_app/common/js/jquery-ui.js"></script>
</head>
<?php 
    include(getFullURLLevel($_GET['r'],'common/config/config.php',5,'R'));
	include(getFullURLLevel($_GET['r'],'common/config/functions.php',5,'R'));
	include(getFullURLLevel($_GET['r'],'common/config/server_urls.php',5,'R'));
	$shift = $_POST['shift'];
	$op_code=$_POST['operation_code'];
	$gate_id=$_POST['gate_id'];	
	$plantcode=$_SESSION['plantCode'];
	$username=$_SESSION['userName'];
	
	if($gate_id=='')
	{
		$gate_id=0;
	}
	$has_permission=haspermission($_GET['r']);
    if (in_array($override_sewing_limitation,$has_permission))
    {
        $value = 'authorized';
    } 
    else
    {
        $value = 'not_authorized';
    }
	$url1 = getFullURLLEVEL($_GET['r'],'gatepass_summery_detail.php',2,'N');
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
	<?php if($op_code)
    {?>
        <div class="panel-heading" >Bundle Barcode Scanning Without Operation</div>
    <?php }else
    {?>
       <div class="panel-heading" >Bundle Barcode Scanning</div>
    <?php }?>
	<div class="panel-body">
		<div class="row jumbotron ">
			<div class="col-md-5">
				 <?php if($op_code)
				{?>
					<div class="col-padding">
					<input type="hidden" id="operation_id" name="operation_id" value='<?= $op_code; ?>'>
				<?php }else
				{?>
					<div class="col-padding">
				<?php }?>
                    <input type="text" id="barcode" class="form-control input-lg" name="barcode" placeholder="scan here" autofocus>
					<input type="hidden" id="pass_id" name="pass_id" value='<?= $gate_id; ?>'>
					<input type="hidden" id="plant_code" name="plant_code" value='<?= $plantcode; ?>'">
					
					<?php
					if($gate_id>0)
					{
						?>
						<div class="col-sm-2 form-group" style="padding-top:20px;">
						<form method ='POST' id='frm1' action='<?php echo $url ?>'>
						<?php
							echo "<a class='btn btn-warning' href='$url1&gatepassid=".$gate_id."&status=2' >Finish</a>";
						?>
						</form>
						</div> 
						<br>					
						<?php
					}
					?>
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
		var operation_id = $('#operation_id').val();
		if(operation_id!=undefined)
		{
			var operation_id = $('#operation_id').val();
		}
		else
		{
			var res = barcode.split('-');
			var operation_id = res[1];
		}
		var plant_code = $('#plant_code').val();
        var bundet;
		const data={
						"barcode": barcode,
						"plantCode": plant_code,
						"operationCode": operation_id,
						"createdUser": <?= $username ?>,
						"shift": <?=shift ?>,
						"reportAsFullGood": true
				    }
			$.ajax({
				type: "POST",
				url: "<?php echo $PTS_SERVER_IP?>/fg-reporting/reportSemiGmtOrGmtBarcode",
				data: data,
				success: function (res) {            
					//console.log(res.data);
					if(res.status)
					{
						bundet=res.data
						tableConstruction(bundet);
						swal(res.internalMessage);
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
	});
		
	
});

function tableConstruction(bundet){
    console.log(bundet);
	s_no = 0;
    if(bundet)
    {
		$('#dynamic_table1').html('');
		for(var i=0;i<bundet.data.length;i++)
        {
			var hidden_class='';
			if(i==0)
            {
                var markup = "<div class='container'><div class='row'><div id='no-more-tables'><table class = 'col-sm-12 table-bordered table-striped table-condensed cf' id='dynamic_table'><thead class='cf'><tr><th>S.No</th><th>Bundle Number</th><th>Operation Code</th><th>Style</th><th>Color</th><th>Size</th><th>Reported Good Qty</th><th>Remarks</th></tr></thead><tbody>";
                $("#dynamic_table1").append(markup);
            }
            s_no++;
			
			var markup1 = "<tr class="+hidden_class+"><td data-title='S.No'>"+s_no+"</td><td data-title='bundlenumber'>"+bundet.data[i].bundleNumber+"</td><td data-title='operation'>"+bundet.data[i].operation+"</td><td data-title='style'>"+bundet.data[i].style+"</td><td data-title='fgColor'>"+bundet.data[i].fgColor+"</td><td data-title='size'>"+bundet.data[i].size+"</td><td data-title='goodQty'>"+bundet.data[i].goodQty+"</td><td data-title='internalMessage'>"+bundet.internalMessage+"</td></tr>";
            $("#dynamic_table").append(markup1);
            $("#dynamic_table").hide();
			
			$('#dynamic_table2').html('');
			var dynamic2="<table class = 'col-sm-12 table-bordered table-striped table-condensed cf' id='dynamic_table2'><thead class='cf'><tr><td>Bundle Number</td><td>"+bundet.data[i].bundleNumber+"</td></tr><tr><td>Operation</td><td>"+bundet.data[i].operation+"</td></tr><tr><td>Status</td><td>"+bundet.status+"</td></tr></thead><tbody>";
			$("#dynamic_table2").append(dynamic2);
			$("#dynamic_table2").show();
		}
	}
	var markup99 = "</tbody></table></div></div></div>";
    $("#dynamic_table").append(markup99);
    $("#dynamic_table").show();
    $('#barcode').val();
    $('#loading-image').hide();
	
	
}
</script>

<style>
.hidden_class,hidden_class_for_remarks{
	display:none;
}

</style>