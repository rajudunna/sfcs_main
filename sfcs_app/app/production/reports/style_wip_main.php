
<html>
<head>
	<script type="text/javascript" src="sfcs_app/common/js/tablefilter.js" ></script>
	<script type="text/javascript" src="sfcs_app/common/js/table2CSV.js" ></script>

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
					<div class="form-inline col-sm-12">

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
					<input id="excel" type="button"  class="btn btn-success" value="Export To Excel" onclick="getCSVData()" style="display:none"> 
						<div class="ajax-loader" id="loading-image" style="margin-left: 45%;margin-top: 35px;border-radius: -80px;width: 88px; display:none">
						    <img src='<?= getFullURLLevel($_GET['r'],'ajax-loader.gif',0,'R'); ?>' class="img-responsive" />
					    </div>
					</div>
				</div>
				
				<div  class='panel panel-primary' id="dynamic_table1" hidden='true'>
						<div class='panel-heading'><b>Style Wip Report </b></div>
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
				$('#excel').hide();
				// alert('failure');
				// console.log(response);
				swal('Error in getting style');
			}				    
		});

    });



    $('#style').change(function(){
    	$('#excel').hide();
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
    	$('#excel').hide();
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
      	$('#loading-image').show();
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
                    //setFilterGrid("dynamic_table1",table3Filters);
					//getexcel();
					// $('#dynamic_table').innerHTML = response ;
					$('#loading-image').hide();
					$('#excel').show();
					// $('#noExport').hide();
				}

		});
	  }

	 

function getCSVData() {
  $('table').attr('border', '1');
  $('table').removeClass('table-bordered');
  var uri = 'data:application/vnd.ms-excel;base64,'
    , template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>'
    , base64 = function(s) { return window.btoa(unescape(encodeURIComponent(s))) }
    , format = function(s, c) { return s.replace(/{(\w+)}/g, function(m, p) { return c[p]; }) }
  
    var table = document.getElementById('dynamic_table1').innerHTML;
    // $('thead').css({"background-color": "blue"});
    var ctx = {worksheet: name || 'Style WIP Report', table : table}
    //window.location.href = uri + base64(format(template, ctx))
    var link = document.createElement("a");
    link.download = "Style WIP Report.xls";
    link.href = uri + base64(format(template, ctx));
    link.click();
    $('table').attr('border', '0');
    $('table').addClass('table-bordered');
}

	
</script>


<!-- <script language="javascript" type="text/javascript">
  var table3Filters = {
      col_1: "select",
      col_2: "select",
      sort_select: true,
      alternate_rows: true,
      loader_text: "Filtering data...",
      loader: true,
      rows_counter: true,
      display_all_text: "Display all"
    //col_width: ["15px","135px","80px","70px","80px","135px","150px","90px","40px",null];
  }
 
</script>  -->

</html>