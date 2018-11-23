<!DOCTYPE html>
<html>
<head>
	<script type="text/javascript" src="../<?= getFullURLLevel($_GET['r'],'common/js/table2CSV.js',3,'R') ?>" ></script>
	
	<title>Mo Transaction Report</title>
	<?php
		include($_SERVER['DOCUMENT_ROOT']."/sfcs_app/common/config/config_ajax.php");
		include($_SERVER['DOCUMENT_ROOT']."/sfcs_app/common/config/functions.php");
		$url = getFullURLLevel($_GET['r'],'mo_transaction_ajax.php',0,'R');
        $url1 = getFullURLLevel($_GET['r'],'mo_transaction_main.php',0,'R');
		
	?>
	<link rel="stylesheet" type="text/css" href="../../common/css/bootstrap.css">
	<script src="../../common/js/jquery.min.js"></script>
	<script src="../../common/js/sweetalert.min.js"></script>
	<script>
		function focus_box()
		{
			document.getElementById("style").focus();
			document.getElementById("schedule").focus();
			document.getElementById("color").focus();
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
						<select  name="style" class="form-control" id="style" required>
							<option value="" disabled selected>Select Style</option>
						</select>
						
						<label><font size="2">Schedule: </font></label>
						<select  name="schedule" class="form-control"  id="schedule" required>
	                     	<option value="" disabled selected>Select Schedule</option>
						</select>

						<label><font size="2">Color: </font></label>
						<select  name="color" class="form-control"  id="color" required>
	                     	<option value="" disabled selected>Select color</option>
						</select>
	               
					<input type="button"  class="btn btn-success" value="Submit" name="submit" id="submit" value="1" onclick="getdata()"> 
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
			url: '<?= $url1 ?>',
			dataType: "json",
			success: function (response) {		
				console.log(response);
					$.each(response.style, function(key,value) {
						$('select[name="style"]').append('<option value="'+ value +'">'+value+'</option>');
					});
					   					
			},
			error: function(response){
				$('#loading-image').hide();	
				// alert('failure');
				// console.log(response);
				swal('Error in getting style');
			}				    
		});

    });



    $('#style').change(function(){
        $('#schedule option').remove();
        $('#color option').remove();
        var style = $(this).val();
	    $.ajax({
			type: "POST",
			url: '<?= $url1 ?>?style='+style,
			dataType: "json",
			success: function (response) {	
                $('select[name="schedule"]').append('<option value="" selected disabled>Select Schedule</option>'); 
                $('select[name="color"]').append('<option value="" selected disabled>Select Color</option>'); 
				console.log(response);
					$.each(response.schedule, function(key,value) {
							$('select[name="schedule"]').append('<option value="'+ value +'">'+value+'</option>');
					});
					   					
			},
			error: function(response){
				$('#loading-image').hide();	
				// alert('failure');
				// console.log(response);
				swal('Error in getting schedule');
			}				    
		});

    });

    $('#schedule').change(function(){
        $('#color option').remove();
        var schedule = $('#schedule').val();
        var style = $('#style').val();
	    $.ajax({
			type: "POST",
			url: '<?= $url1 ?>?style='+style+'&schedule='+schedule,
			dataType: "json",
			success: function (response) {		
				 $('select[name="color"]').append('<option value="" selected disabled>Select Color</option>'); 
				console.log(response);
					$.each(response.color, function(key,value) {
							$('select[name="color"]').append('<option value="'+ value +'">'+value+'</option>');
					});
					   					
			},
			error: function(response){
				$('#loading-image').hide();	
				// alert('failure');
				// console.log(response);
				swal('Error in getting color');
			}				    
		});

    });


      function getdata(){
	      var style = $("#style").val();
	      var schedule = $("#schedule").val();	
	      var color = $("#color").val();
	      var submit = $('#submit').val();

	      if(style == null || schedule == null || color == null)
	      {
	      	sweetAlert('Please Select  Style,Schedule and color','','warning');
	      	return false;
	      }

	      $.ajax({
				type: "GET",
				url: '<?= $url ?>?style='+style +'&schedule='+schedule +'&color='+color +'&submit='+submit,
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