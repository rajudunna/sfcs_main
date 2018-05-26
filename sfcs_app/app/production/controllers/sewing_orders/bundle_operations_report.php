<!DOCTYPE html>
<html>
<head><center><font size="6" color="red">Bundle Operations Report</font></center>
 <meta http-equiv="X-UA-Compatible" content="IE=edge,Chrome=1" />
	<!-- Latest compiled and minified CSS

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"> -->
	<script type="text/javascript" src="js/jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="js/datetimepicker_css.js"></script>
<link rel="stylesheet" type="text/css" href="js/style.css">
<link rel="stylesheet" href="cssjs/bootstrap.min.css">
<link rel="stylesheet" href="cssjs/select2.min.css">
<link rel="stylesheet" href="cssjs/font-awesome.min.css">
<script type="text/javascript" src="cssjs/jquery.min.js"></script>
<script type="text/javascript" src="cssjs/select2.min.js"></script>
<script src="cssjs/bootstrap.min.js"></script>
</head>
</br>
<body>
<?php
	    include("..".getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));
	

// error_reporting (0);
// include('dbconf1.php');

// // Create connection
// $conn = new mysqli($servername, $username, $password, $dbname);
// // Check connection
// if ($link->connect_error) {
// 	die("Connection failed: " . $link->connect_error);
// }else{
// 	//echo "Connection Success";
// }
$qry_get_product_style = "SELECT id,style FROM $brandix_bts.bundle_creation_data group by style";
//echo $qry_get_product_style;
$result = $link->query($qry_get_product_style);
$qry_get_operation_name = "SELECT id,operation_name,default_operation,operation_code FROM $brandix_bts.tbl_orders_ops_ref";
//echo $qry_get_product_style;
$result_oper = $link->query($qry_get_operation_name);
?>
<div class='container'>
			<div class="row">
				<div class="form-group col-md-3">
					<label for="style">Select Style</label>		      
					<select class="form-control" id="pro_style" name="style">
						<option value=''>Select Style No</option>
						<?php				    	
							if ($result->num_rows > 0) {
								while($row = $result->fetch_assoc()) {
									echo "<option value='".$row['id']."'>".$row['style']."</option>";
								}
							} else {
								echo "<option value=''>No Data Found..</option>";
							}
						?>
					</select>
				</div>	
				
				<div class="form-group col-md-3">
					<label for="title">Select Schedule:</label>
					<select name="schedule" class="form-control" id='schedule' style="style">
					<option value=''>Select Schedule</option>
					</select>
				</div>
				<div class="form-group col-md-3">
					<label for="title">Select Color:</label>
					<select name="color" class="form-control" id='color' style="style">
					<option value=''>Select Color</option>
					</select>
				</div>
				<div class="form-group col-md-3">
					<label for="title">Select Bundle Number:</label>
					<select name="bundle" class="form-control" id='bundle' style="style">
					<option value=''>Select Bundle Number</option>
					</select>
				</div>
			</div>
			
			<hr>
			<div class="form-group col-md-3" style="margin-left: 490px;">
					<label for="bunno">Bundle Number:</label>
					<input type="text" class="form-control" id="bunno" name="bunno" readonly="true" style="height: 100px;width: 200px;text-align:  center;font-size: 60px;color: mediumseagreen;">
			</div>

		<table id ="dynamic_table1" class="table table-hover table-striped">
			<tbody>
				<thead>
					<th>Bundle Numbers</th>
					<th>Operations</th>
					<th>Quantity</th>
				</thead>
			</tbody>
		</table>

		
		


	<div class="ajax-loader" id="loading-image" style="margin-left: 486px;margin-top: 35px;border-radius: -80px;width: 88px;">
		<img src='<?= getFullURLLevel($_GET['r'],'ajax-loader.gif',0,'R'); ?>' class="img-responsive" />
	</div>
	</body>
</html>

<script type="text/javascript">
$("#clear").click(function(){
    window.location.href="/material_approval.php";
});
$(document).ready(function(){
	$('#loading-image').hide();
	$("#oper_name").change(function()
	{
			//var url = "getdata1()";
			var oper_name= $('#oper_name').val();
			$.ajax
			({
					type: "POST",
					// url:"functions.php?r=getdata1&oper_name="+oper_name,
					url:"<?= getFullURLLevel($_GET['r'],'functions.php',0,'R'); ?>?r=getdata1&oper_name="+oper_name,
					data: {oper_name: $('#oper_name').val()},
					success: function(response)
					{
						console.log(response);
						var data = jQuery.parseJSON(response);
						//console.log(data);
						var oper_code = data["operation_code"];
						$("#oper_code1").val(oper_code);
						$("#oper_def1").val(data["default_operation"]);
					}
				
			});
	});


	$("#bundle").change(function()
	{
		$('#loading-image').show();
		var color_name = $('#color option:selected').text();
		var style_name = $('#pro_style option:selected').text();
		var schedule_name = $('#schedule option:selected').text();
		var bundle_number = $('#bundle option:selected').text();
		// alert(bundle_number);
		var params1 =[color_name,style_name,schedule_name,bundle_number];
			$.ajax
			({
					type: "POST",
					url:"<?= getFullURLLevel($_GET['r'],'functions1.php',0,'R'); ?>?r=getdata1&params1="+params1,
					// url:"functions1.php?r=getdata1&params1="+params1,
					data: {params1: $('#params1').val()},
					success: function(response)
					{
						$('#loading-image').hide();
						$("#dynamic_table1 td").remove();
						var data = jQuery.parseJSON(response);
						if(data.length >0)
						{	
							// console.log(bundle_number);
							
							$('#bunno').val(bundle_number);
								for(var i=0;i<data.length;i++)
							{
								
								 // if(data[i]['bundle_number'] != id)
							 // {
								
								// var markup="<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>";
								 // $("#dynamic_table1").append(markup);
							 // }
							 // var id = data[i]['bundle_number'];	
							var markup ="<tr><td style='text-align:center;'>"+data[i]['bundle_number']+'&nbsp;&nbsp;&nbsp;&nbsp;Size:&nbsp;&nbsp;['+data[i]['size_title']+"]</td><td style='text-align:center;'>"+data[i]['operation_name']+"</td><td><b style='margin-left: 184px;'><font color='green'>SEND:&nbsp;"+data[i]['send_qty']+' </font></b><b><font color=blue> &nbsp;&nbsp;  RECEIVED:&nbsp;'+data[i]['recevied_qty']+'</font></b><b><font color=gold> &nbsp;&nbsp;  MISSING:&nbsp;'+data[i]['missing_qty']+'</font></b><b><font color=red> &nbsp;&nbsp;  REJECTED:&nbsp;'+data[i]['rejected_qty']+"</font></b></td></tr>";
							 
							 
								//s_no++;
								$("#dynamic_table1").append(markup);
								
							}	 
						}	
					}	
			});
	});
	

	$("#pro_style").change(function()
	{
		$('#loading-image').show();
		var pro_style_schedule = $('#pro_style option:selected').text();
		//alert(pro_style_schedule);
		
		$.ajax
			({
					type: "POST",
					url:"<?= getFullURLLevel($_GET['r'],'functions1.php',0,'R'); ?>?r=getdata1&pro_style_schedule="+pro_style_schedule,
					// url:"functions1.php?r=getdata1&pro_style_schedule="+pro_style_schedule,
					 dataType: 'Json',
					data: {pro_style_schedule: $('#pro_style_schedule').val()},
					success: function(response)
					{
						$('#loading-image').hide();
						//alert(response);
						$.each(response, function(key, value) {
						$('select[name="schedule"]').append('<option value="'+ key +'">'+ value +'</option>');
						});
						
					},
					error: function(error)
					{
						console.log(error);
					}
					
			});
		
	});
	$("#schedule").change(function()
	{
		$('#loading-image').show();
		var pro_schedule_color = $('#schedule option:selected').text();
		$.ajax
			({
					type: "POST",
					url:"<?= getFullURLLevel($_GET['r'],'functions1.php',0,'R'); ?>?r=getdata1&pro_schedule_color="+pro_schedule_color,
					 dataType: 'Json',
					data: {pro_schedule_color: $('#pro_schedule_color').val()},
					success: function(response)
					{
						$('#loading-image').hide();
						$.each(response, function(key, value) {
						$('select[name="color"]').append('<option value="'+ key +'">'+ value +'</option>');
						});
						
					}
			});
		
	});
	
	$("#color").change(function()
	{
		$('#loading-image').show();
		var color_name = $('#color option:selected').text();
		var style_name = $('#pro_style option:selected').text();
		var schedule_name = $('#schedule option:selected').text();
		// var params1 =[color_name,style_name,schedule_name];
		$.ajax
			({
					type: "GET",
					url:"<?= getFullURLLevel($_GET['r'],'functions1.php',0,'R'); ?>?r=getbundleno&color_name="+color_name+"&style_name="+style_name+"&schedule_name="+schedule_name,
					dataType: 'Json',
					// data: {color_name: $('#color_name').val(),style_name: $('#style_name').val(),schedule_name: $('#schedule_name').val()},
					success: function(response)
					{
						$('#loading-image').hide();
						$.each(response, function(key, value) {
							
						$('select[name="bundle"]').append('<option value="'+ key +'">'+ value +'</option>');
						});
						
					}
			});
		
	});

	var s_no = 1;
	$("#add-row").click(function(){
		
			
		  var oper_name = $('#oper_name option:selected').text();
		  var oper_code = $('#oper_code').val();
		  var oper_def = $('#oper_def').val();
		  var priority = $('#priority').val();
		  var smo = $('#smo').val();
		  var smv=$('#smv').val();
		  var m3_smv =$('#m3_smv').val();
		  var markup = "<tr><td>"+s_no+"</td><td>"+oper_name+"</td><td>"+oper_code+"</td><td>"+oper_def+"</td><td>"+priority+"</td><td>"+smo+"</td><td>"+smv+"</td><td>"+m3_smv+"</td><td><button type='button' class='btn btn-info btn-lg particular' id='particular' data-toggle='modal' data-target='#myModal' onclick='myfunction(this)'>Add Row</button></td></tr>";
		  s_no++
		 $("#dynamic_table1").append(markup);
		 
	 });
	  
	
});
// $('#smv1').change(function()
// {
	// var smv1= $('#smv1').val();
		// $.ajax
		// ({
			
				// type: "POST",
				// url:"functions.php?r=getdata1&smv1="+smv1,
                // data: {smv1: $('#smv1').val()},
                // success: function(response)
				// {
					
					
				// }
			
		// });
// });
</script>
<script type="text/javascript">
function myfunction(btn)
	{
		//alert("working");
		var table = document.getElementById("dynamic_table1");
		var row = btn.parentNode.parentNode;
		var ind = row.rowIndex;
		var row_ind = table.rows[ind];
		var Cells = row_ind.getElementsByTagName("td");
		var cell_id = Cells[1].innerText;
		document.getElementById('rowIndex').value = ind;
		document.getElementById('rowId').value = cell_id;
		
	}
	
	function initialize(count)
	{
		document.getElementById('new_rowId').value = count;
	}
</script>

<?php
function getdata1()
{
	echo "hi";
}
?>