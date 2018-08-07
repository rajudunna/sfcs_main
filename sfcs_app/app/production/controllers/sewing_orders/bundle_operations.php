<!--- Developed by Srinivas Y --->
<!DOCTYPE html>
<html>
<head>
	<title>Operations Mapping</title>
 <meta http-equiv="X-UA-Compatible" content="IE=edge,Chrome=1" />
	<!-- Latest compiled and minified CSS -->
<script type="text/javascript" src="js/jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="js/datetimepicker_css.js"></script>
<link rel="stylesheet" href="cssjs/bootstrap.min.css">
<link rel="stylesheet" href="cssjs/select2.min.css">
<link rel="stylesheet" href="cssjs/font-awesome.min.css">
<script type="text/javascript" src="cssjs/jquery.min.js"></script>
<script type="text/javascript" src="cssjs/select2.min.js"></script>
<script src="cssjs/bootstrap.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
<?php
include("dbconf.php");
$has_permission=haspermission($_GET['r']);
error_reporting (0);
$servername = $host_adr;
$username = $host_adr_un;
$password = $host_adr_pw;
$dbname = $database;

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}else{
	//echo "Connection Success";
}
$qry_get_product_style = "SELECT id,style FROM tbl_style_ops_master group by style";
//echo $qry_get_product_style;
$result = $conn->query($qry_get_product_style);
$qry_get_operation_name = "SELECT id,operation_name,default_operation,operation_code FROM tbl_orders_ops_ref";
//echo $qry_get_product_style;
$result_oper = $conn->query($qry_get_operation_name);
?>
<!-- 
	Code: Removed mandatory (*) for M3 SMV while adding operation
	Database: Removed NOT NULL option for the table 'tbl_style_ops_master'
	by Theja on 06-02-2018
-->
<div class='container'>
	<div class="panel panel-primary">
		<div class="panel-heading"><strong>Operations Mapping</strong></div>
		<div class="panel-body">
			<div class="row">
				<div class="form-group col-md-3">
					<label for="style">Select Style<span data-toggle="tooltip" data-placement="top" title="It's Mandatory field"><font color='red'>*</font></span></label>		      
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
					<label for="title">Select Color:<span data-toggle="tooltip" data-placement="top" title="It's Mandatory field"><font color='red'>*</font></span></label>
					<select name="color" class="form-control" id='color' style="style">
					<option value=''>Select Color</option>
					</select>
				</div>
			</div>
			<hr>
			
		<div id ="dynamic_table1">
		</div>
<?php
$qry_get_operation_name = "SELECT id,operation_name,default_operation,operation_code FROM tbl_orders_ops_ref where default_operation !=  'Yes'";
//echo $qry_get_product_style;
$result_oper = $conn->query($qry_get_operation_name);
$qry_get_suppliers = "SELECT id,supplier_name from tbl_suppliers_master group by supplier_name";
//echo $qry_get_product_style;
$result_oper1 = $conn->query($qry_get_suppliers);
$qry_get_suppliers = "SELECT id,supplier_name from tbl_suppliers_master group by supplier_name";
//echo $qry_get_product_style;
$result_oper2 = $conn->query($qry_get_suppliers);

?>
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close"  id = "cancel" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Manual Operation</h4>
        </div>
        <div class="modal-body">
				<input type="hidden" name="rowIndex" id="rowIndex">
				<input type="hidden" name="rowId" id="rowId">
				<input type="hidden" name="chaged_id" id="chaged_id">
				<input type="hidden" name="changed_value" id="changed_value">
				<input type="hidden" name="actual_value" id="actual_value">
				<input type="hidden" name="deletable_id" id="deletable_id">
				<input type="hidden" name="row_index_del" id="row_index_del">
				<input type="hidden" name="manual_id" id="manual_id">
				<input type="hidden" name="editable_id" id="editable_id">
				<input type="hidden" name="operation_name_id" id="operation_name_id">
				<input type="hidden" name="operation_name_seq" id="operation_name_seq">
				<input type="hidden" name="operation_name_comp" id="operation_name_comp">
				<label for="style">Operation Name <span data-toggle="tooltip" data-placement="top" title="It's Mandatory field"><font color='red'>*</font></span></label>		      
						<select class="form-control" id="oper_name" name="style" >
							<option value='0'>Select Operation Name</option>
							<?php				    	
								if ($result_oper->num_rows > 0) {
									while($row = $result_oper->fetch_assoc()) {
									$row_value = $row['operation_name']."(".$row['operation_code'].")";
										echo "<option value='".$row['id']."'>".$row_value."</option>";
									}
								} else {
									echo "<option value=''>No Data Found..</option>";
								}
							?>
						</select>
						<label for="inputsm" hidden='true'>Is M3 Operation? <span data-toggle="tooltip" data-placement="top" title="It's Mandatory field"><font color='red'>*</font></span></label>
						<input type="hidden" id="oper_def1" type="text">
						<label for="inputsm" hidden='true'>Operation Code <span data-toggle="tooltip" data-placement="top" title="It's Mandatory field"><font color='red'>*</font></span></label>
						<input type="hidden" id="oper_code1" type="text" hidden='true'>
						<label for="inputsm">M3 SMV <span data-toggle="tooltip" data-placement="top" title="It's Mandatory field">
						<!-- <font color='red'>*</font></span> -->
						</label>
						<input class="form-control input-sm" id="m3_smv1" type="text" value='0'>
						<label for="title" id='m3_smv_label'>Select M3-SMV: <span data-toggle="tooltip" data-placement="top" title="It's Mandatory field"><font color='red'>*</font></span></label>
						<select name="m3_smv" class="form-control" id='m3_smv' style="style">
						<option value='0'>Select M3-SMV</option>
						</select>
						<label for="style">Embellishment Supplier</label>		      
						<select class="form-control" id="supplier2" name="supplier" >
							<option value='0'>Select Supplier</option>
							<?php				    	
								if ($result_oper1->num_rows > 0) {
									while($row = $result_oper1->fetch_assoc()) {
									//$row_value = $row['operation_name']."(".$row['operation_code'].")";
										echo "<option value='".$row['id']."'>".$row['supplier_name']."</option>";
									}
								} else {
									echo "<option value=''>No Data Found..</option>";
								}
							?>
						</select><br>
			<label>Barcode <span data-toggle="tooltip" data-placement="top" title="It's Mandatory field"><font color='red'>*</font></span></label>
			<label class="radio-inline"><input type="radio" name="optradio2" value ="Yes" id='optradio2' onclick="autooperseq1()">Yes</label>
			<label class="radio-inline"><input type="radio" name="optradio2" value = "No" id= 'optradio2' onclick="autooperseq()">No</label><br><br>
			<label>Operation sequence <span data-toggle="tooltip" data-placement="top" title="It's Mandatory field"><font color='red'>*</font></span></label>
			<input class="form-control input-sm" id="oper_seq2" type="text">
			<label>Dependency Operation</label>
			<input class="form-control input-sm" id="oper_depe2" type="text">
			<label>Component <span data-toggle="tooltip" data-placement="top" title="It's Mandatory field"><font color='red'>*</font></label>
			<input class="form-control input-sm" id="component2" type="text">
			<br>
			<button class="btn btn-primary btn-sm" id='add-row1'>Add Manual Operation </button>
		</div>
    </div>
      
    </div>
 </div>
 <div class="modal fade" id="myModal1" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title"><center>Are You Sure To Delete???</center></h4>
        </div>
        <div class="modal-body">
			<div class="row">
				<div class="col-md-4" id="yes">
					<center><button class="btn btn-danger btn-lg" id='yes'>Yes</button></center>
				</div>
				<div class="col-md-4" hidden="true" id='m3_opss'>
					<select name="m3_ops" class="form-control" id='m3_ops' style="style">
						<option value='0'>Select M3-SMV</option>
					</select>
				</div>
				<div class="col-md-4" id = "no">
					<center><button class="btn btn-primary btn-lg" id='No' data-dismiss="modal">No</button></center>
				</div>
				<div class="col-md-4" id = "proceed" hidden="true">
					<center><button class="btn btn-primary btn-lg" id='proceed'>Proceed</button></center>
				</div>
			</div>
			
		</div>
    </div>
      
    </div>
 </div>
 <div class="modal fade" id="myModal2" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title"><center>Operations Update For The Operation <div id='operation_name_edit'></div></center></h4>
		   <button type="button" class="close"  id = "cancel" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
			<label for="style">Embellishment Supplier</label>		      
						<select class="form-control" id="supplier" name="supplier" >
							<option value='0'>Select Supplier</option>
							<?php				    	
								if ($result_oper2->num_rows > 0) {
									while($row = $result_oper2->fetch_assoc()) {
									//$row_value = $row['operation_name']."(".$row['operation_code'].")";
										echo "<option value='".$row['id']."'>".$row['supplier_name']."</option>";
									}
								} else {
									echo "<option value=''>No Data Found..</option>";
								}
							?>
						</select><br>
			<label>Barcode <span data-toggle="tooltip" data-placement="top" title="It's Mandatory field"><font color='red'>*</font></span></label>
			<label class="radio-inline"><input type="radio" name="optradio" value ="Yes" id='Yes' onclick="autooperseq1()">Yes</label>
			<label class="radio-inline"><input type="radio" name="optradio" value = "No" id= 'None' onclick="autooperseq()">No</label><br><br>
			<label>Operation sequence <span data-toggle="tooltip" data-placement="top" title="It's Mandatory field"><font color='red'>*</font></span></label>
			<input class="form-control input-sm" id="oper_seq1" type="text">
			<label>Dependency Operation</label>
			<input class="form-control input-sm" id="oper_depe1" type="text">
			<label>Component <span data-toggle="tooltip" data-placement="top" title="It's Mandatory field"><font color='red'>*</font></label>
			<input class="form-control input-sm" id="component1" type="text">
			<br>
			<button class="btn btn-primary btn-sm" id="edit">Update</button>
		</div>
    </div>
      
    </div>
 </div>
</div>
</div>
	<div class="ajax-loader" id="loading-image" style="margin-left: 486px;margin-top: 35px;border-radius: -80px;width: 88px;">
		<img src='ajax-loader.gif' class="img-responsive" />
	</div>
	</body>
</html>

<script type="text/javascript">
$("#clear").click(function(){
    var ajax_url ="/material_approval.php";Ajaxify(ajax_url);

});
$(document).ready(function(){
	$('#loading-image').hide();
	$("#oper_name").change(function()
	{
			//var url = "getdata()";
			var oper_name= $('#oper_name').val();
			var color_name = $('#color option:selected').text();
			var style_name = $('#pro_style option:selected').text();
			var seq = $('#oper_seq2').val();
			if(seq == '')
			{
				seq = 100;
			}
			//var schedule_name = $('#schedule option:selected').text();
			var oper_name =[oper_name,color_name,style_name,seq];
			$.ajax
			({
					type: "POST",
					url:"functions.php?r=getdata&oper_name="+oper_name,
					data: {oper_name: $('#oper_name').val()},
					success: function(response)
					{
						console.log(response);
						if(response == 1)
						{
							alert('Operation Already In List.');
							$("#oper_name").val(0);
							$("#oper_code1").val('');
							$("#oper_def1").val('');
						}
						else
						{
							var data = jQuery.parseJSON(response);
							var oper_code = data["operation_code"];
							$("#oper_code1").val(oper_code);
							$("#oper_def1").val(data["default_operation"]);
						}
						
					}
				
			});
	});

	$("#color").change(function()
	{
		$("#dynamic_table1").html(" ");
		$('#loading-image').show();
		var color_name = $('#color option:selected').text();
		var style_name = $('#pro_style option:selected').text();
		$('#m3_smv').empty();
		$('select[name="m3_smv"]').append('<option value="0">Select M3_SMV</option>');
		$('#m3_ops').empty();
		$('select[name="m3_ops"]').append('<option value="0">Select M3_SMV</option>');
		//var schedule_name = $('#schedule option:selected').text();
		var params =[color_name,style_name];
			$.ajax
			({
					type: "POST",
					url:"functions.php?r=getdata&params="+params,
					data: {params: $('#params').val()},
					success: function(response)
					{
						$("#dynamic_table1").html(" ");
						$('#loading-image').hide();
						console.log(response);
						var data = jQuery.parseJSON(response);
						console.log(data.length);
						if(data.length >0)
						{
							var markup = "<table class = 'table table-striped' id='dynamic_table'><tbody><thead><tr><th>Operation Code</th><th class='none'>Style</th><th class='none'>Color</th><th>Operation Name</th><th>Operation Sequence</th><th>Is M3 Operation?</th><th>M3_SMV</th><th>Barcode</th><th>Embellishment Supplier</th><th>Dependency Operations</th><th>Component</th><th>Controls</th><th><button type='button' class='btn btn-info btn-sm particular' id='particular' data-toggle='modal' data-target='#myModal'><i class='fa fa-plus-square' aria-hidden='true'></i></button></th></tr></thead><tbody>";
							$("#dynamic_table1").append(markup);
							for(var i=0;i<data.length;i++)
							{
								if(data[i].supplier_name == null)
								{
									data[i].supplier_name = '';
								}
								if(data[i].ops_sequence == null)
								{
									data[i].ops_sequence = '';
								}
								if(data[i].ops_dependency == null)
								{
									data[i].ops_dependency = '';
								}
								if(data[i].component == null)
								{
									data[i].component = '';
								}
								if(data[i].ops_dependency == 0)
								{
									data[i].ops_dependency = '';
								}
								
								var deleting = data[i].from_m3_check;
								if(deleting == 1)
								{
									var deleting_html = "<td><button type='button' class='btn btn-danger btn-sm'><i class='fa fa-ban' aria-hidden='true'></i></button></td>";
								}
								else
								{
									var deleting_html = "<td><button type='button' id='deletable' class='btn btn-danger btn-sm' data-toggle='modal' data-target='#myModal1' onclick='default_oper("+data[i].main_id+",this)'><i class='fa fa-trash-o' aria-hidden='true'></i></button></td>";
								}
								var markup1 = "<tr><td class='none' id="+data[i].main_id+"operation_id>"+data[i]['operation_id']+"</td><td>"+data[i]['operation_code']+"</td><td class='none'>"+style_name+"</td><td class='none'>"+data[i]['color']+"</td><td id="+data[i].main_id+"operation_name>"+data[i]['ops_name']+"</td><td id="+data[i].main_id+"seq>"+data[i].ops_sequence+"</td><td>"+data[i]['default_operration']+"</td></td><td id="+data[i].main_id+"smv>"+data[i]['smv']+"</td><td id="+data[i].main_id+"barcode>"+data[i].barcode+"</td><td id="+data[i].main_id+"supplier_id hidden='true'>"+data[i].emb_supplier+"</td><td id="+data[i].main_id+"supplier>"+data[i].supplier_name+"</td><td id="+data[i].main_id+"dep>"+data[i].ops_dependency+"</td><td id="+data[i].main_id+"comp>"+data[i].component+"</td><td><button type='button' class='btn btn-info btn-sm particular' id='particularedit' data-toggle='modal' data-target='#myModal2' onclick='myfunctionedit(this,"+data[i].main_id+")'><i class='fa fa-pencil-square-o' aria-hidden='true'></i></button></td>"+deleting_html+"</tr>";
								s_no++;
								 $("#dynamic_table").append(markup1);
							}
							var markup2 = "</tbody></table>";
							 $("#dynamic_table").append(markup2);
						}
						else
						{
							var markup1 = "Sorry!!! No data found.";
							 $("#dynamic_table").append(markup1);
						}
						document.getElementById('component1').readOnly=false;
						document.getElementById('component2').readOnly=false;
					}	
				
			});
		var params_smv =[color_name,style_name];
			$.ajax
			({
					type: "POST",
					url:"functions.php?r=getdata&params_smv="+params_smv,
					 dataType: 'Json',
					data: {params: $('#m3_smv').val()},
					success: function(response)
					{
						var count = 0;
						$.each(response, function(key, value) {
						count++;
						});
						//alert(count);
						if(count == 1)
						{
							$.each(response, function(key, value) 
							{
								//alert(key);
								$("#chaged_id").val(key);
								$('#m3_smv').hide();
								$('#m3_smv_label').hide();
								$('select[name="m3_ops"]').append('<option value="'+ key +'">'+ value +'</option>');
								//$('select[name="m3_smv"]').append('<option value="'+ key +'">'+ value +'</option>');
							});
							
						}
						else
						{
							$.each(response, function(key, value) 
							{
						
								//$("#chaged_id").val(key);
								$('#m3_smv').show();
								$('#m3_smv_label').show();
								$('select[name="m3_ops"]').append('<option value="'+ key +'">'+ value +'</option>');
								$('select[name="m3_smv"]').append('<option value="'+ key +'">'+ value +'</option>');
							});
							
						}
							
							
						
						//alert($("#chaged_id").val());
					}	
				
			});
		
	});

	$("#pro_style").change(function()
	{
		$("#dynamic_table1").html(" ");
		$('#schedule').empty();
		$('select[name="schedule"]').append('<option value="Select Schedule">Select Schedule</option>');
		$('#color').empty();
		$('select[name="color"]').append('<option value="Select Color">Select Color</option>');
		//$("#dynamic_table1").html(" ");
		$('#m3_smv').empty();
		$('select[name="m3_smv"]').append('<option value="0">Select M3_SMV</option>');
		$('#m3_ops').empty();
		$('select[name="m3_ops"]').append('<option value="0">Select M3_SMV</option>');
		$('#loading-image').show();
		var pro_style_schedule = $('#pro_style option:selected').text();
		
		$.ajax
			({
					type: "GET",
					url:"functions.php?r=getdata&pro_style_schedule="+pro_style_schedule,
					 dataType: 'Json',
					data: {pro_style_schedule: $('#pro_style_schedule').val()},
					success: function(response)
					{
						$('#loading-image').hide();
						//alert(response);
						$.each(response, function(key, value) {
						$('select[name="color"]').append('<option value="'+ key +'">'+ value +'</option>');
						});
						
					},
					error: function(error)
					{
						console.log(error);
					}
					
			});
		
	});
	var s_no = 1;
	
	  $("#add-row1").click(function(){
		var flag = 1;
		if($("#oper_name").val() == 0)
		{
			alert("Please Select Operation Name.");
			flag = 0;
		}
		if($("input:radio[name=optradio2]:checked").val() == undefined)
		{
			alert("Please Enter Barcode Yes/No.");
			flag = 0;
		}
		if($('#oper_seq2').val() == '')
		{
			alert("Plsease Enter Operation Sequence");
			flag = 0;
		}
		if($('#component2').val() == '')
		{
			alert("Plsease Enter Component Name.");
			flag = 0;
		}
		if(flag == 1)
		{
			var style_id = $('#pro_style').val();
			var pro_style_name = $('#pro_style option:selected').text();
			var oper_name_id = $('#oper_name').val();
			var oper_name = $('#oper_name option:selected').text();
			var oper_def = $('#oper_def1').val();
			var style = $('#style option:selected').text();
			var color = $('#color option:selected').text();
			var m3_smv =$('#m3_smv1').val();
			var oper_def1 = "'"+oper_def+"'";
			var color1 = "'"+color+"'";
			var style1 = "'"+pro_style_name+"'";
			var barcode = $("input:radio[name=optradio2]:checked").val();
			var barcode1 =  "'"+barcode+"'";
			var supplier = $('#supplier2 option:selected').text();
			var supplier_id = $('#supplier2').val();
			var oper_seq = $('#oper_seq2').val();
			var oper_dep = $('#oper_depe2').val();
			if(oper_dep == '')
			{
				oper_dep = 0;
			}
			//alert(oper_dep);
			var component = $('#component2').val();
			var component1 =  "'"+component+"'";
			var s = $('#oper_code1').val();
			var saving_data = [style_id,oper_name_id,s,0,m3_smv,m3_smv,s,oper_def1,s,style1,color1,2,barcode1,supplier_id,oper_seq,oper_dep,component1];
			//console.log(saving_data);
			  $.ajax
				({
						type: "POST",
						url:"functions.php?r=getdata&saving="+saving_data,
						data: {saving: $('#saving').val()},
						success: function(response)
						{
							//console.log(response);
							if(response == 'None')
							{
								alert("Please eneter valid dependency Operation.");
							}
							else if(response == '')
							{
								alert("Operation  Not Inserted.");	
							}
							else
							{
								
								if(supplier == 'Select Supplier')
								{
									supplier = '';
								}
								var markup = "<tr><td class='none' id="+response+"operation_id>"+oper_name_id+"</td><td>"+s+"</td><td class='none'>"+pro_style_name+"</td><td class='none'>"+color+"</td><td id="+response+"operation_name>"+oper_name+"</td><td id="+response+"seq>"+oper_seq+"</td><td>"+oper_def+"</td><td>"+m3_smv+"</td><td id="+response+"barcode>"+barcode+"</td><td id="+response+"supplier_id hidden='true'>"+supplier_id+"</td><td id="+response+"supplier>"+supplier+"</td><td id="+response+"dep>"+oper_dep+"</td><td id="+response+"comp>"+component+"</td><td><button type='button' class='btn btn-info btn-sm particular' id='particularedit' data-toggle='modal' data-target='#myModal2' onclick='myfunctionedit(this,"+response+")'><i class='fa fa-pencil-square-o' aria-hidden='true'></i></button></td><td><button type='button' class='btn btn-danger btn-sm' data-toggle='modal' data-target='#myModal1' onclick='default_oper("+response+",this)'><i class='fa fa-trash-o' aria-hidden='true'></i></button></td></tr>";
								$('#dynamic_table').append(markup);	
								var changed_id = $("#chaged_id").val();
								var changed_value = $("#actual_value").val();
							  if(changed_value == '')
							  {
								  changed_value = Number($("#"+changed_id+"smv").html()) - Number($('#m3_smv1').val());
								  //alert($('#m3_smv1').val());
								  $("#"+changed_id+"smv").html(changed_value);
							  }
								  var saving_changes = [changed_id,changed_value];
									$.ajax
									({
											type: "POST",
											url:"functions.php?r=getdata&saving_changes="+saving_changes,
											data: {saving_changes: $('#saving_changes').val()},
											success: function(response)
											{
												
											}
										
									});
								$('#myModal').modal('toggle');
								$('#myModal').find('input:text').val('');
								$('#m3_smv1').val(0);
								$("#oper_name").val(0);
								$("#supplier2").val(0);
								$("#m3_smv").val(0);
								document.getElementById('component1').readOnly=false;
								document.getElementById('component2').readOnly=false;
								//alert("Operation Successfully Inserted");
							}
						}
					
				});	
		}
		  
	  });
	 $("#m3_smv").change(function()
	{
		if($("#m3_smv1").val() == '')
		{
			alert("Please enter SMV.");
			$("#m3_smv").val(0);
		}
		else
		{
			var changed_id = $("#chaged_id").val();
			if(changed_id == '')
			{
				var id = $("#m3_smv").val();
				$("#chaged_id").val(id);
				var smv_value_new = $("#m3_smv1").val();
				var old_smv = $("#"+id+"smv").html();
				$("#changed_value").val(old_smv);
				var actual_smv = Number(old_smv) - Number(smv_value_new);
				alert(actual_smv);
				$("#"+id+"smv").html(actual_smv);
				$("#actual_value").val(actual_smv);
			}
			else
			{
				var actual_value = $("#changed_value").val();
				var actual_id = $("#chaged_id").val();
				//alert(actual_id);
				$("#"+actual_id+"smv").html(actual_value);
				var id = $("#m3_smv").val();
				$("#chaged_id").val(id);
				var smv_value_new = $("#m3_smv1").val();
				var old_smv = $("#"+id+"smv").html();
				$("#changed_value").val(old_smv);
				var actual_smv = Number(old_smv) - Number(smv_value_new);
				$("#"+id+"smv").html(actual_smv);
				$("#actual_value").val(actual_smv);
			}
		}
		
	});
});
$("#cancel").click(function()
{
	var id = $("#chaged_id").val();
	if(id != '')
	{
		if($("#changed_value").val() != '')
		{
			var value = $("#changed_value").val();
			$("#"+id+"").html(value);
		}
	}
});

$("#edit").click(function()
{
	var flag = 1;
	var id = $('#editable_id').val();
	//var barcode = $('#optradio').val();
	var barcode = $("input:radio[name=optradio]:checked").val();
	var barcode_text = "'"+barcode+"'";
	var supplier = $('#supplier option:selected').text();
	var supplier_id = $('#supplier').val();
	var oper_seq = $('#oper_seq1').val();
	var oper_dep = $('#oper_depe1').val();
	var component = $('#component1').val();
	var style = $('#pro_style option:selected').text();
	var color = $('#color option:selected').text();
	var component1 = "'"+component+"'";
	var color = "'"+color+"'";
	var style = "'"+style+"'";
	if(oper_seq == '')
	{
		alert("Please Enter Operation Sequence");
		flag = 0;
	}
	if($("input:radio[name=optradio]:checked").val() == undefined)
	{
		alert("Please Enter Barcode Yes/No.");
		flag = 0;
	}
	if($('component1').val() == '')
	{
		alert("Please Enter Component Name");
		flag= 0;
	}
	if(flag == 1)
	{
		editable_data = [id,barcode_text,supplier_id,oper_seq,oper_dep,component1,style,color];
	$.ajax
		({
			
				type: "POST",
				url:"functions.php?r=getdata&editable_data="+editable_data,
				data: {editable_data: $('#editable_data').val()},
				success: function(response)
				{
					if(response == 1)
					{
						//alert("Updated Successfully");
						$('#myModal2').modal('toggle');
						$('#myModal2').find('input:text').val('');
						$('#supplier').val(0);
						$("#"+id+"barcode").html(barcode);
						if(supplier == 'Select Supplier')
						{
							supplier = '';
						}
						$("#"+id+"supplier").html(supplier);
						//alert(supplier_id);
						$("#"+id+"supplier_id").html(supplier_id);
						$("#"+id+"seq").html(oper_seq);
						$("#"+id+"dep").html(oper_dep);
						$("#"+id+"comp").html(component);
					}
					else if(response == 0)
					{
						alert("Operation Not Updated");
					}
					else
					{
						alert("Plsease Enter Valid dependency operation.");
						$('#oper_depe1').val('');
					}
			
					
				}
			
		});
		
	}
	
	
});

$('#oper_seq1').change(function()
{
	var seq = $('#oper_seq1').val();
	var pro_style_name = $('#pro_style option:selected').text();
	var color = $('#color option:selected').text();
	var oper_name=$('#operation_name_id').val();
	var seq_params = [seq,pro_style_name,color,oper_name];
	if(seq){
		$.ajax
			({
				
					type: "POST",
					url:"functions.php?r=getdata&seq_params1="+seq_params,
					data: {},
					success: function(response)
					{
							//alert(response);
							if(response == 0)
							{
								alert("The Operation Already exists for this sequence.");
								$('#oper_seq1').val(document.getElementById('operation_name_seq').value);
								$('#component1').val(document.getElementById('operation_name_comp').value);
								document.getElementById('component1').readOnly=true;
							}
							else if(response == 1)
							{
								document.getElementById('component1').readOnly=false;
								$('#component1').val('');
								//document.getElementById('component1').readOnly=true;
							}
							else
							{
								$('#component1').val(response);
								document.getElementById('component1').readOnly=true;
							}
					}
			});
		}else{
			$('#component1').val('');
		}
	
});
$('#oper_seq2').change(function()
{
	var seq = $('#oper_seq2').val();
	var pro_style_name = $('#pro_style option:selected').text();
	var color = $('#color option:selected').text();
	var oper_name= $('#oper_name').val();
	var seq_params = [seq,pro_style_name,color,oper_name];
	if(seq){
		$.ajax
			({
				
					type: "POST",
					url:"functions.php?r=getdata&seq_params="+seq_params,
					data: {},
					success: function(response)
					{
							var temp = new Array();
							temp = response.split(",");
							console.log(temp.length);
							if(temp.length > 1)
							{
								response_validate = temp[1];
							}
							if(response == 0)
							{
								$('#component2').val('');
								document.getElementById('component2').readOnly=false;
							}
							else
							{
								if(response_validate == 1)
								{
									alert("Operation Name Already in list for this sequence.");
									$('#oper_name').val(0);
									$("#oper_code1").val('');
									$("#oper_def1").val('');
									$('#component2').val(temp[0]);
									document.getElementById('component2').readOnly=true;
								}
								else
								{
									$('#component2').val(temp[0]);
									document.getElementById('component2').readOnly=true;
								}
							
							}
							
					}
			});
		}else{
			$('#component2').val('');
		}
	
});
// $('#oper_depe2').change(function()
// {
	// var flag = 1;
	// var seq = $('#oper_seq2').val();
	// if(seq == '')
	// {
		// alert("Plsease Enter Operation Sequence First");
		// $('#oper_depe2').val('');
		// flag = 0;
	// }
	// if(flag == 1)
	// {
		// var pro_style_name = $('#pro_style option:selected').text();
		// var color = $('#color option:selected').text();
		// var seq_params = [seq,pro_style_name,color]
		// $.ajax
			// ({
				
					// type: "POST",
					// url:"functions.php?r=getdata&dep_validate="+seq_params,
					// data: {},
					// success: function(response)
					// {
							// if(response != 0)
							// {
								//alert(seq);
								// if(seq != 0)
								// {
									// alert("You are already allocated dependency operation for this sequence");
									// $('#oper_depe2').val('');
								// }
								
							// }
					// }
			// });
		
	// }
// });
// $('#oper_depe1').change(function()
// {
	// var flag = 1;
	// var seq = $('#oper_seq1').val();
	// if(seq == '')
	// {
		// alert("Plsease Enter Operation Sequence First");
		// $('#oper_depe1').val('');
		// flag = 0;
	// }
	// var  oper_dep_value = $('#oper_depe1').val();
	// if(flag == 1)
	// {
		// var pro_style_name = $('#pro_style option:selected').text();
		// var color = $('#color option:selected').text();
		// var seq_params = [seq,pro_style_name,color]
		// $.ajax
			// ({
				
					// type: "POST",
					// url:"functions.php?r=getdata&dep_validate="+seq_params,
					// data: {},
					// success: function(response)
					// {
							// if(response != 0)
							// {
								// if(seq != 0 && oper_dep_value != '')
								// {
									// alert("You are already allocated dependency operation for this sequence");
									// $('#oper_depe1').val('');
								// }
								
							// }
					// }
			// });
	// }
	
	
	
// });

$("#yes").click(function()
{
	
	$('#m3_opss').show();
	$('#no').hide();
	$('#yes').hide();
	$('#proceed').show();
	
$('#proceed').click(function()
{
	var del_row_id = $('#row_index_del').val();
	flag = 0;
	var deletable_val = $('#m3_ops').val();
	var editable_val = $('#deletable_id').val();
	var parameters = [deletable_val,editable_val];
	if(deletable_val == 0)
	{
		alert("please select M3 Operation.");
		flag = 1;
	}
	if(flag == 0)
	{
		$.ajax
		({
			
				type: "POST",
				url:"functions.php?r=getdata&parameters="+parameters,
				data: {parameters: $('#parameters').val()},
				success: function(response)
				{
					console.log(response);
					console.log(deletable_val);
					$("#"+deletable_val+"smv").html(response);
					hidingrow(del_row_id);
					$('#myModal1').modal('toggle');
					
				}
			
		});
	}
	
});
	
});



</script>
<script type="text/javascript">
var myvalue;
function hidingrow()
{
	var table = document.getElementById("dynamic_table");
    var row = myvalue.parentNode.parentNode;
	row.parentNode.removeChild(row);
}
function default_oper(value,btn)
{
	myvalue = btn;
	console.log(myvalue);
	document.getElementById("deletable_id").value = value;
	document.getElementById("row_index_del").value = btn;
}	
function initialize(count)
{
	document.getElementById('new_rowId').value = count;
}
function myfunctionedit(val,id)
{
	//document.getElementById('component1').readOnly=true;
	console.log(id);
	document.getElementById('editable_id').value = id;
	actual_barcode = id+"barcode";
	seq = id+"seq";
	dep = id+"dep";
	comp=id+"comp";
	sup_id = id+"supplier_id";
	oper_id = id+"operation_name";
	oper_act_id = id+"operation_id";
	oper_act_id = document.getElementById(oper_act_id).innerText;
	//var barcode = "#"+actual_barcode;
	barcode = document.getElementById(actual_barcode).innerText;
	seqence = document.getElementById(seq).innerText;
	dep = document.getElementById(dep).innerText;
	comp = document.getElementById(comp).innerText;
	sup_id = document.getElementById(sup_id).innerText;
	oper_na = document.getElementById(oper_id).innerText;
	document.getElementById('oper_seq1').value = seqence;
	document.getElementById('operation_name_id').value = oper_act_id;
	document.getElementById('operation_name_seq').value = seqence;
	document.getElementById('operation_name_comp').value = comp;
	if(dep == 0)
	{
		dep = '';
	}
	document.getElementById('oper_depe1').value = dep;
	document.getElementById('component1').value = comp;
	//document.getElementById('optradio').value = 'Yes';
	if(barcode == 'Yes')
	{
		document.getElementById("Yes").checked = true;
	}
	else if(barcode == 'No')
	{
		document.getElementById("None").checked = true;
	}
	else
	{
		document.getElementById("Yes").checked = false;
		document.getElementById("None").checked = false;
	}
	//alert(sup_id);
	if(sup_id == '')
	{
		sup_id = 0;
	}
	else if (sup_id == 'null')
	{
		sup_id = 0;
	}
	else
	{
		sup_id = document.getElementById(id+"supplier_id").innerText;
	}
	document.getElementById('supplier').value = sup_id;
	document.getElementById('operation_name_edit').innerText = oper_na;
	
	
}
function autooperseq()
{
	document.getElementById('oper_seq2').value = 0;
	document.getElementById('oper_seq1').value = 0;
}
function autooperseq1()
{
	document.getElementById('oper_seq2').value = '';
	document.getElementById('oper_seq1').value = '';
}

</script>
<style>
.table
{
	text-align:center;
}
.none
{
	display:none;
}
</style>