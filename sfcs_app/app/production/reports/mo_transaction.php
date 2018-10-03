<!DOCTYPE html>
<html>
<head>
	<script type="text/javascript" src="../<?= getFullURLLevel($_GET['r'],'common/js/table2CSV.js',3,'R') ?>" ></script>
	<title>Mo Transaction Report</title>
	<?php
		include($_SERVER['DOCUMENT_ROOT']."/sfcs_app/common/config/config.php");
		include($_SERVER['DOCUMENT_ROOT']."/sfcs_app/common/config/functions.php");
		$url = getFullURLLevel($_GET['r'],'mo_transaction_ajax.php',0,'R');
	?>
	<link rel="stylesheet" type="text/css" href="../../common/css/bootstrap.css">
	<script src="../../common/js/jquery.min.js"></script>
	<script src="../../common/js/sweetalert.min.js"></script>
	<script>
		function focus_box()
		{
			document.getElementById("style").focus();
			document.getElementById("schedule").focus();
		}


	</script>
</head>
<body onload="focus_box()">
	<div class="container-fluid">
		<div class="panel panel-primary">
			<div class="panel-heading">Mo Transaction Report</div>
			<div class="panel-body">
				<div class='row'>
					<div class="form-inline col-sm-10">

						<label><font size="2">Style: </font></label>
						<select  name="style" class="form-control" id="style">
							<option value="">Select Style</option>
						</select>
						
						<label><font size="2">Schedule: </font></label>
						<select  name="schedule" class="form-control"  id="schedule" ">
	                     	<option value="">Select Schedule</option>
						</select>
	               
					<input type="button"  class="btn btn-success" value="Submit" onclick="getdata()"> 
					</div>
				</div>
				<br><br>
						<div style='display:none' id='excel_form'>
				<form  action="<?= getFullURLLevel($_GET['r'],'export_excel.php',0,'R'); ?>" method ="post" > 

					<input type="hidden" id="csv_text" name="csv_text" >
					<input type="submit" id="exp_exc" class="btn btn-info" value="Export to Excel">
				</form><br>
				</div>
				<div  class='panel panel-primary' id="dynamic_table1" hidden='true'>
						<div class='panel-heading'>Mo data</div>
						<div style='overflow-x:scroll' class='panel-body' id="dynamic_table">
							
						</div>
			    </div>
				</div>
				
			</div>
		</div>
	</div>
		
</body>
<script type="text/javascript">

	$(document).ready(function(){

        $.ajax({
			type: "POST",
			url: '<?= $url ?>',
			dataType: "json",
			success: function (response) {		
				console.log(response);
					$.each(response.style, function(key,value) {
							$('select[name="style"]').append('<option value="'+ value +'">'+value+'</option>');
					});
					$.each(response.schedule, function(key,value) {
							$('select[name="schedule"]').append('<option value="'+ value +'">'+value+'</option>');
					});
					// $('#operation option[value=<?= $operation_code ?>]').prop('selected', true);
					// $('#operation').prop('disabled', true);		    					
				
															  
			},
			error: function(response){
				$('#loading-image').hide();	
				// alert('failure');
				// console.log(response);
				swal('Error in getting schedule');
			}				    
		});

    });

      function getdata(){
	      var style = $("#style").val();
	      var schedule = $("#schedule").val();	
	      $.ajax({
				type: "GET",
				url: '<?= $url ?>?style='+style +'&schedule='+schedule,
				success: function(response) 
				{
					$('#excel_form').css({'display':'block'});
					console.log(response);
					$('#dynamic_table1').show();
					document.getElementById('dynamic_table').innerHTML = response;
					getexcel();
					// $('#dynamic_table').innerHTML = response ;
				}

		});
	  }
	
</script>
<script language="javascript">

function getexcel(){
 var csv_value=$('#excel_table').table2CSV({delivery:'value'});
 $("#csv_text").val(csv_value);	
}
</script>
</html>