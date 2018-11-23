
<html>
<head>
	<script type="text/javascript" src="../<?= getFullURLLevel($_GET['r'],'common/js/table2CSV.js',3,'R') ?>" ></script>
	<title>Style WIP Report</title>
	<?php
		include($_SERVER['DOCUMENT_ROOT']."/sfcs_app/common/config/config_ajax.php");
		include($_SERVER['DOCUMENT_ROOT']."/sfcs_app/common/config/functions.php");
		$url = getFullURLLevel($_GET['r'],'style_wip.php',0,'R');
		$url1 = getFullURLLevel($_GET['r'],'style_wip_ajax.php',0,'R');
		
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
			<div class="panel-heading">Style WIP Report</div>
			<div class="panel-body">
				<div class='row'>
					<div class="form-inline col-sm-10">

						<label><font size="2">Style: </font></label>
						<select  name="style" class="form-control" id="style">
							<option value="" disabled selected>Select Style</option>
						</select>
						
						<label><font size="2">Schedule: </font></label>
						<select  name="schedule" class="form-control"  id="schedule" ">
	                     	<option value="" disabled selected>Select Schedule</option>
	                     	<option value="1">ALL</option>
						</select>

						<label><font size="2">Color: </font></label>
						<select  name="color" class="form-control"  id="color" ">
	                     	<option value="" disabled selected>Select color</option>
	                     	<option value="">ALL</option>
						</select>


						<input type="checkbox" class="checkbox" name="size"  id= "size" value="1">
			            <label class="checkbox-inline">Size</label>
	               
					<input type="button"  class="btn btn-success" value="Submit" onclick="getdata()"> 
					</div>
				</div>
				
				<div  class='panel panel-primary' id="dynamic_table1" hidden='true'>
						<div class='panel-heading'>Styles Report</div>
						<div style='overflow-y:scroll' class='panel-body' id="dynamic_table">
							
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
			url: '<?= $url ?>?style='+style,
			dataType: "json",
			success: function (response) {	
                $('select[name="schedule"]').append('<option value=all>ALL</option>'); 
                $('select[name="color"]').append('<option value=all>ALL</option>'); 
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
			url: '<?= $url ?>?style='+style+'&schedule='+schedule,
			dataType: "json",
			success: function (response) {		
				 $('select[name="color"]').append('<option value=all>ALL</option>'); 
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
	      if( $('#size').prop('checked') ){
                var size = $("#size").val();
	      }else{
	      	    var size = '';
	      }

	      if(style == null || schedule == null || color == null)
          {
	          sweetAlert('Please Select  Style,Schedule,color','','warning');
	          return false;
          }
	      $.ajax({
				type: "GET",
				url: '<?= $url1 ?>?style='+style +'&schedule='+schedule +'&color='+color +'&size='+size,
				success: function(response) 
				{
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

<script language="javascript" type="text/javascript">
  var table3Filters = {
      col_1: "select",
      sort_select: true,
      alternate_rows: true,
      loader_text: "Filtering data...",
      loader: true,
      rows_counter: true,
      display_all_text: "Display all"
    //col_width: ["15px","135px","80px","70px","80px","135px","150px","90px","40px",null];
  }
  setFilterGrid("dynamic_table1",table3Filters);
</script> 

</html>