<?php
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/functions.php',3,'R'));
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/m3Updations.php',3,'R'));
$url = getFullURLLEVEL($_GET['r'],'qms_2.php',0,'N');
$plantcode=$_SESSION['plantCode'];
$username=$_SESSION['userName'];
?>

<head>
<script type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/jquery.min.js',3,'R'); ?>"></script>

<link rel="stylesheet" type="text/css" href="<?= getFullURLLevel($_GET['r'],'common/js/jquery.autocomplete.css',1,'R'); ?>" />
<script type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/jquery.js',3,'R'); ?>"></script>
<script type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/jquery.autocomplete.js',1,'R'); ?>"></script>

<script type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/TableFilter_EN/filtergrid.css',3,'R'); ?>"></script>

<script type="text/javascript">
$(document).ready(function(){
 $("#schedule").autocomplete("autocomplete.php", {
		selectFirst: true
	});
	$("#fade1").fadeOut(3000);
});
</script>
<script language="javascript" type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/TableFilter_EN/actb.js',3,'R'); ?>"></script>
<script language="javascript" type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/TableFilter_EN/tablefilter.js',3,'R'); ?>"></script>
</head>

<br/>

<div class='panel panel-primary'>
<div class='panel-heading'>Quality Rejection Reversal Form</div>
<div class='panel-body'>
<div class='form-group'>
<div class='table-responsive'>

<form action='<?php echo $url ?>' method="POST">


<div class='col-md-3 col-sm-3 col-xs-12'>
<h5>Schedule:</h5><input name="schedule" type="text" class="form-control col-md-7 col-xs-12 float" value="<?php $_POST['schedule'];?>" id="schedule" size="20" required/>
</div>
<input type="hidden" id="plant_code" name="plant_code" value='<?= $plantcode; ?>'>
<input type="hidden" id="username" name="username" value='<?= $username; ?>'>
<div class='col-md-2 col-sm-3 col-xs-12'>
<input type="submit" value="Search" name="search" id="search" class="btn btn-success" style="margin-top: 34px;">
<input type="submit" value="Deleted Transactions" name="transactions" id="transactions" class="btn btn-info" style="margin-top: 34px;">
</div>

</form>
<div id ="dynamic_table1">
</div>
</div>
</div>
</div>
</div>
<script language="javascript" type="text/javascript">
	var table6_Props = 	{
							rows_counter: true,
							btn_reset: true,
							loader: true,
							loader_text: "Filtering data..."
						};
	setFilterGrid( "table1",table6_Props );
</script>
<script>
$(document).ready(function() 
{
	$('#search').on('click', function(){
		$('#dynamic_table1').html('');
		var plant_code = $('#plant_code').val();
		var username = $('#username').val();
		var schedule = $('#schedule').val();
		var inputObj = {schedule:schedule, plantCode:plant_code, userName:username};
		var function_text = "<?php echo getFullURL($_GET['r'],'scanning_ajax_new.php','R'); ?>";
        $.ajax({
            type: "POST",
            url: function_text+"?inputObj="+inputObj,
            success: function(response) 
            {
                var bundet = JSON.parse(response);
                tableConstruction(bundet);
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
                var markup = "<div class='container'><div class='row'><div id='no-more-tables'><table class = 'col-sm-12 table-bordered table-striped table-condensed cf' id='dynamic_table'><thead class='cf'><tr><th>Style</th><th>Schedule</th><th>Color</th><th>Size</th><th>QMS Remarks</th><th>Rejection Type</th><th>Bundle No</th><th>Operation Id</th><th>Input Job</th><th>Date</th><th>Quantity</th><th>Control</th></tr></thead><tbody>";
                $("#dynamic_table1").append(markup);
            }
            s_no++;
			
			var markup1 = "<tr class="+hidden_class+"><td data-title='style'>"+bundet.data[i].style+"</td><td data-title='schedule'>"+bundet.data[i].schedule+"</td><td data-title='color'>"+bundet.data[i].color+"</td><td data-title='size'>"+bundet.data[i].size+"</td><td data-title='qmsRemarks'>"+bundet.data[i].qmsRemarks+"</td><td data-title='rejectionType'>"+bundet.data[i].rejectionType+"</td><td data-title='bundleNumber'>"+bundet.data[i].bundleNumber+"</td><td data-title='operationId'>"+bundet.data[i].operationId+"</td><td data-title='inputJob'>"+bundet.data[i].inputJob+"</td><td data-title='date'>"+bundet.data[i].date+"</td><td data-title='quantity'>"+bundet.data[i].quantity+"</td><td><button type='button' class='btn btn-danger btn-sm'  onclick='deletetrn("+bundet.data[i].id+","+bundet.data[i].operationId+","+bundet.data[i].inputJob+",this)'><i class='fa fa-trash-o' aria-hidden='true'>Delete</i></td></tr>";
            $("#dynamic_table").append(markup1);
            $("#dynamic_table").hide();

		}
	}
	var markup99 = "</tbody></table></div></div></div>";
    $("#dynamic_table").append(markup99);
    $("#dynamic_table").show();
    $('#schedule').val('');
	
	
}

function deletetrn(id,operation,inpjob,btn)
{
	var mainid = id; 
	var operation_id = operation; 
	var inputjobno = inpjob; 
	var inputObj = {mainId:mainid, operationCode:operation_id, inputJob:inputjobno};
	var function_text = "<?php echo getFullURL($_GET['r'],'scanning_ajax_new.php','R'); ?>";
	$.ajax({
		type: "POST",
		url: function_text+"?inputObj="+inputObj,
		success: function(response) 
		{
			var bundet = JSON.parse(response);
			var msg=bundet.status;
			swal({
			 title: "Deleted",
			 text: msg,
			 type: "success",
			 timer: 10000
			 });
		}
	});
}

$('#search').on('click', function(){
	var plant_code = $('#plant_code').val();
	$('#dynamic_table1').html('');
	var inputObj = {plantCode:plant_code};
	var function_text = "<?php echo getFullURL($_GET['r'],'scanning_ajax_new.php','R'); ?>";
	$.ajax({
		type: "POST",
		url: function_text+"?inputObj="+inputObj,
		success: function(response) 
		{
			var delbundet = JSON.parse(response);
			deleteTableConstruction(delbundet);
		}
	});
});

function deleteTableConstruction(delbundet){
	console.log(delbundet);
	s_no = 0;
    if(delbundet)
    {
		$('#dynamic_table1').html('');
		for(var i=0;i<delbundet.data.length;i++)
        {
			var hidden_class='';
			if(i==0)
            {
                var markup = "<div class='container'><div class='row'><div id='no-more-tables'><table class = 'col-sm-12 table-bordered table-striped table-condensed cf' id='dynamic_table'><thead class='cf'><tr><th>S.No</th><th>Style</th><th>Schedule</th><th>Color</th><th>Date</th><th>Size</th><th>Quantity</th></tr></thead><tbody>";
                $("#dynamic_table1").append(markup);
            }
            s_no++;
			
			var markup1 = "<tr class="+hidden_class+"><td data-title='style'>"+s_no+"</td><td data-title='style'>"+delbundet.data[i].style+"</td><td data-title='schedule'>"+delbundet.data[i].schedule+"</td><td data-title='color'>"+delbundet.data[i].color+"</td><td data-title='date'>"+delbundet.data[i].date+"</td><td data-title='size'>"+delbundet.data[i].size+"</td><td data-title='quantity'>"+delbundet.data[i].quantity+"</td></tr>";
            $("#dynamic_table").append(markup1);
            $("#dynamic_table").hide();

		}
	}
	var markup99 = "</tbody></table></div></div></div>";
    $("#dynamic_table").append(markup99);
    $("#dynamic_table").show();
}	
</script>