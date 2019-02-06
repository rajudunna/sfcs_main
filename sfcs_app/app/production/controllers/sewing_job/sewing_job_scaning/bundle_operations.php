<!--- Developed by Srinivas Y --->
<!DOCTYPE html>
<html>
<head>
	<title>Operations Mapping</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script>
function verify_num(t){
	
	var c = /^[0-9.]+$/;
	var id = t.id;
	var qty = document.getElementById(id);
	if( !(qty.value.match(c)) ){
		sweetAlert('Please Enter Only Numbers','','warning');
		qty.value = '';
		return false;	
	}
}
</script>
</head>
<body>
<?php
//code by Srinu
// include("dbconf.php");
	// include(getFullURLLevel($_GET['r'],'common/config/config.php',5,'R'));
	// include(getFullURLLevel($_GET['r'],'common/config/functions.php',5,'R'));
	include(getFullURLLevel($_GET['r'],'/common/config/config.php',5,'R'));
	$has_permission=haspermission($_GET['r']);
	// include("../../../../../common/config/config_ajax.php");
// error_reporting (0);
$qry_get_product_style = "SELECT id,style FROM $brandix_bts.tbl_style_ops_master  where style != '' group by style";
// echo $qry_get_product_style;
$result = $link->query($qry_get_product_style);
$qry_get_operation_name = "SELECT id,operation_name,default_operation,operation_code FROM $brandix_bts.tbl_orders_ops_ref";
//echo $qry_get_product_style;
$result_oper = $link->query($qry_get_operation_name);
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
$qry_get_operation_name = "SELECT id,operation_name,default_operation,operation_code FROM $brandix_bts.tbl_orders_ops_ref";
//echo $qry_get_product_style;
$result_oper = $link->query($qry_get_operation_name);
$qry_get_suppliers = "SELECT id,supplier_name from $brandix_bts.tbl_suppliers_master group by supplier_name";
//echo $qry_get_product_style;
$result_oper1 = $link->query($qry_get_suppliers);
$qry_get_suppliers = "SELECT id,supplier_name from $brandix_bts.tbl_suppliers_master group by supplier_name";
//echo $qry_get_product_style;
$result_oper2 = $link->query($qry_get_suppliers);

?>
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close"  id = "cancel" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Operation</h4>
        </div>
        <div class="modal-body">
				<input type="hidden" name="rowIndex" id="rowIndex">
				<input type="hidden" name="rowId" id="rowId">
				<input type = "hidden" name = "first_ops_id" id = "first_ops_id" value = "0">
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
				<input type="hidden" name="dep_flag" id="dep_flag">
				<input type = "hidden" name = "pre_ops_code" id = "pre_ops_code">
			<div class="row">
				<div class = "col-sm-12">
						<label for="style">Operation Name <span data-toggle="tooltip" data-placement="top" title="It's Mandatory field"><font color='red'>*</font></span></label>
						</br>				
								<select id="oper_name" style="width:100%;"  class="form-control">
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
								</br></br><label for="inputsm">Report To ERP <span data-toggle="tooltip" data-placement="top" title="It's Mandatory field"><font color='red'>*</font></span></label>
								<!--<input type="hidden" id="oper_def1" type="text"> -->
								<label class="radio-inline"><input type="radio" name="reporttoerpradio" value ="Yes" id='reporttoerpradio'>Yes</label>
								<label class="radio-inline"><input type="radio" name="reporttoerpradio" value = "No" id= 'reporttoerpradio'>No</label>
								<label for="inputsm" hidden='true'>Operation Code <span data-toggle="tooltip" data-placement="top" title="It's Mandatory field"><font color='red'>*</font></span></label></br>
								<input type="hidden" id="oper_code1" type="text" hidden='true'>
								<label for="inputsm" hidden='true'>M3 SMV <span data-toggle="tooltip" data-placement="top" title="It's Mandatory field">
								<!-- <font color='red'>*</font></span> -->
								</label>
								<input class="form-control input-sm float" id="m3_smv1" type="hidden" value='0' >
								<label for="title" id='m3_smv_label' hidden='true'>Select M3-SMV: <span data-toggle="tooltip" data-placement="top" title="It's Mandatory field"><font color='red'>*</font></span></label>
								<select name="m3_smv" id='m3_smv' class='form-contro'>
								<option value='0'>Select M3-SMV</option>
								</select>
								<br/>
								<label for="style">Embellishment Supplier</label>
								</br>
								<select  id="supplier2" style="width:100%;">
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
								</select><br></br>
					<label>Barcode <span data-toggle="tooltip" data-placement="top" title="It's Mandatory field"><font color='red'>*</font></span></label>
					<label class="radio-inline"><input type="radio" name="optradio2" value ="Yes" id='optradio2' onclick="autooperseq1()">Yes</label>
					<label class="radio-inline"><input type="radio" name="optradio2" value = "No" id= 'optradio2' onclick="autooperseq()" checked>No</label><br><br>
					<label>Operation Group </label>
					<input class="form-control input-sm integer" id="oper_seq2" type="text" onchange='verify_num_seq1(this)' value='0'>
					<label>Next Operation</label>
					<input class="form-control input-sm integer" id="oper_depe2" type="text">
					<label>Component</label>
					<input class="form-control input-sm" id="component2" type="text">
					<label></label><br/>
					<button class="btn btn-primary btn-sm" hidden='true' id='add-row1'>Add Manual Operation </button>
				</div>
			</div>
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
				<!-- <div class="col-md-4" id="yes">
					<center><button class="btn btn-danger btn-lg" id='yes'>Yes</button></center>
				</div>  
				<div class="col-md-3">
					<select name="m3_ops" class="form-control" id='m3_ops' style="style" hidden='true'>
							<option value='0'>Select M3-SMV</option>
					</select>
				</div>
				-->
				<div class="col-md-3">
				</div>
				<div class="col-md-3" id = "proceed" >
					<button class="btn btn-danger btn-lg" id='proceed'>Proceed</button>
				</div>
				<div class="col-md-3" >
				<button class="btn btn-primary btn-lg" id='No' data-dismiss="modal">No</button>
				</div>
				<div class="col-md-3">
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
          <h4 class="modal-title"><center>Operations Update For The Operation <b><div id='operation_name_edit'></div></b></center></h4>
		   <button type="button" class="close"  id = "cancel" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
		<label>Operation Code <span data-toggle="tooltip" data-placement="top" title="It's Mandatory field"><font color='red'>*</font></span></label>
		<input class="form-control input-sm integer" id="ops_code1" type="text">
		</br></br><label for="inputsm">Report To ERP <span data-toggle="tooltip" data-placement="top" title="It's Mandatory field"><font color='red'>*</font></span></label>
		<!--<input type="hidden" id="oper_def1" type="text"> -->
		<label class="radio-inline"><input type="radio" name="reporttoerpradio1" value ="Yes" id='erp_Yes'>Yes</label>
		<label class="radio-inline"><input type="radio" name="reporttoerpradio1" value = "No" id= 'erp_None'>No</label>
		</br></br><label for="style">Embellishment Supplier</label>		      
					<select id="supplier" name="supplier" style="width:100%">
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
					</select></br></br>
			<label>Barcode <span data-toggle="tooltip" data-placement="top" title="It's Mandatory field"><font color='red'>*</font></span></label>
			<label class="radio-inline"><input type="radio" name="optradio" value ="Yes" id='Yes' onclick="autooperseq1()">Yes</label>
			<label class="radio-inline"><input type="radio" name="optradio" value = "No" id= 'None' onclick="autooperseq()">No</label><br><br>
			<label>Operation Group</label>
			<input class="form-control input-sm integer" id="oper_seq1" type="text"  onchange='verify_num_seq2(this)' value = '0'>
			<label>Next Operation</label>
			<input class="form-control input-sm integer" id="oper_depe1" type="text">
			<label>Component</label>
			<input class="form-control input-sm" id="component1" type="text">
			<br></br></br>
			<button class="btn btn-primary btn-sm" id="edit">Update</button>
		</div>
    </div>
      
    </div>
 </div>
</div>
</div>
	<div class="ajax-loader" id="loading-image" style="margin-left: 486px;margin-top: 35px;border-radius: -80px;width: 88px;">
		<img src='<?= getFullURLLevel($_GET['r'],'ajax-loader.gif',0,'R'); ?>' class="img-responsive" />
	</div>
	</body>
</html>
</div>
</div>
<script type="text/javascript">
var function_file = "<?php echo getFullURL($_GET['r'],'functions.php','R'); ?>";

$("#clear").click(function(){
    window.location.href="/material_approval.php";
});
$(document).ready(function(){
	$('#m3_smv').hide();
	$('#loading-image').hide();
	//$('#oper_name').select2();
	$('#supplier2').select2();
	$('#supplier').select2();
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
					url:function_file+"?r=getdata&oper_name="+oper_name,
					data: {oper_name: $('#oper_name').val()},
					success: function(response)
					{
						console.log(response);
						if(response == 1)
						{
							sweetAlert('Operation Already In List.',"","warning");
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
		//var function_file = "<?php echo getFullURL($_GET['r'],'functions.php','R'); ?>";
		var params =[color_name,style_name];
			$.ajax
			({
					type: "POST",
					url:function_file+"?r=getdata&params="+params,
					data: {params: $('#params').val()},
					success: function(response)
					{
						$("#dynamic_table1").html(" ");
						$('#loading-image').hide();
						console.log(response);
						if(response != 100)
						{
							var data = jQuery.parseJSON(response);
							console.log(data.length);
							var markup = "<table class = 'table table-striped' id='dynamic_table'><thead><tr><th>Operation Code</th><th class='none'>Style</th><th class='none'>Color</th><th>Operation Name</th><th>Operation Group</th><th>Report To ERP</th><th>M3_SMV</th><th>Barcode</th><th>Embellishment Supplier</th><th>Next Operations</th><th>Component</th><th></th><th style='text-align:center;'>Controls</th><th><button type='button' id='deletable' class='btn btn-primary btn-sm' onclick='value_edition(this,0);'><i class='fa fa-plus' aria-hidden='true'></i></button></th>";
							<?php
								if(in_array($update,$has_permission))
								{	?>
									//markup+="<button type='button' class='btn btn-info btn-sm particular' id='particular' hidden='true'>Add Manual Operation</i></button>";
									<?php	
								} 
							?>
							markup+="</tr></thead>";
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

								if(data[i]['operation_code'] == 10 || data[i]['operation_code'] == 15|| data[i]['operation_code'] == 200)
								{
									var editing_class = 'none';
								}
								else
								{
									var editing_class = '';
								}
								var editing_class = '';
								var markup1 = "<tr><td class='none' id="+data[i].main_id+"operation_id>"+data[i]['operation_id']+"</td><td id="+data[i].main_id+"ops_code>"+data[i]['operation_code']+"</td><td class='none'>"+style_name+"</td><td class='none'>"+data[i]['color']+"</td><td class='none' id="+data[i].main_id+"ops_order>"+data[i]['operation_order']+"</td><td id="+data[i].main_id+"operation_name>"+data[i]['ops_name']+"</td><td id="+data[i].main_id+"seq>"+data[i].ops_sequence+"</td><td  id="+data[i].main_id+"rep_to_erp>"+data[i]['default_operration']+"</td></td><td id="+data[i].main_id+"smv>"+data[i]['smv']+"</td><td id="+data[i].main_id+"barcode>"+data[i].barcode+"</td><td id="+data[i].main_id+"supplier_id hidden='true'>"+data[i].emb_supplier+"</td><td id="+data[i].main_id+"supplier>"+data[i].supplier_name+"</td><td id="+data[i].main_id+"dep>"+data[i].ops_dependency+"</td><td id="+data[i].main_id+"comp>"+data[i].component+"</td><td>";
								<?php
									if(in_array($edit,$has_permission))
									{	?>
										markup1+="<button type='button' class='btn btn-info btn-sm particular "+editing_class+"' id='particularedit'  onclick='myfunctionedit(this,"+data[i].main_id+")'><i class='fa fa-pencil-square-o' aria-hidden='true'></i></button>";
										<?php	
									} 
								?>
								var adding_html	= "<td><button type='button' id='deletable' class='btn btn-primary btn-sm' onclick='value_edition(this,"+data[i].main_id+");'><i class='fa fa-plus' aria-hidden='true'></i></button></td>";
								var deleting_html = "<td><button type='button' id='deletable' class='btn btn-danger btn-sm'  onclick='default_oper("+data[i].main_id+",this)'><i class='fa fa-trash-o' aria-hidden='true'></i></button></td>";
								markup1+=deleting_html+adding_html+"</tr>";
								s_no++;
								 $("#dynamic_table").append(markup1);
							}
							var markup2 = "</tbody></table>";
							 $("#dynamic_table").append(markup2);
						}
						else
						{
							var markup1 = "<b style='color:red;'>Sorry!!! No Operations found.</b>";
							 $("#dynamic_table1").append(markup1);
						}
						document.getElementById('component1').readOnly=false;
						document.getElementById('component2').readOnly=false;
					}	
				
			});
		var params_smv =[color_name,style_name];
			$.ajax
			({
					type: "POST",
					url:function_file+"?r=getdata&params_smv="+params_smv,
					 dataType: 'Json',
					data: {params: $('#m3_smv').val()},
					success: function(response)
					{
						var count = 0;
						$.each(response, function(key, value) {
						count++;
						});
						console.log(count);
						//alert(count);
						if(count == 1)
						{
							console.log("count1");
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
							console.log("else");
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
		//var function_file = "<?php echo getFullURL($_GET['r'],'functions.php','R'); ?>";
		//console.log(function_file);
		$.ajax
			({
					type: "GET",
					url:function_file+"?r=getdata&pro_style_schedule="+pro_style_schedule,
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
			sweetAlert("Please Select Operation Name.","","warning");
			flag = 0;
		}
		if($("input:radio[name=optradio2]:checked").val() == undefined)
		{
			sweetAlert("Please Enter Barcode Yes/No.","","warning");
			flag = 0;
		}
		if($("input:radio[name=reporttoerpradio]:checked").val() == undefined)
		{
			sweetAlert("Please Enter Report To Erp As Yes/No.","","warning");
			flag = 0;
		}
		if($('#oper_seq2').val() == '')
		{
			sweetAlert("Please Enter Operation Group","","warning");
			flag = 0;
		}
		if($('#component2').val() == '' && $("input:radio[name=optradio2]:checked").val() == 'Yes')
		{
			//sweetAlert("Please Enter Component Name.","","warning");
			//flag = 0;
		}
		if(flag == 1)
		{
			var style_id = $('#pro_style').val();
			var pro_style_name = $('#pro_style option:selected').text();
			var oper_name_id = $('#oper_name').val();
			var oper_name = $('#oper_name option:selected').text();
			//var oper_def = $('#oper_def1').val();
			var style = $('#style option:selected').text();
			var color = $('#color option:selected').text();
			var m3_smv =$('#m3_smv1').val();
			console.log(m3_smv);
			//var oper_def1 = "'"+oper_def+"'";
			var color1 = "'"+color+"'";
			var style1 = "'"+pro_style_name+"'";
			var barcode = $("input:radio[name=optradio2]:checked").val();
			var oper_def = $("input:radio[name=reporttoerpradio]:checked").val();
			var oper_def1 = "'"+oper_def+"'";
			var barcode1 =  "'"+barcode+"'";
			var supplier = $('#supplier2 option:selected').text();
			var supplier_id = $('#supplier2').val();
			var oper_seq = $('#oper_seq2').val();
			var oper_dep = $('#oper_depe2').val();
			if(m3_smv == '')
			{
				m3_smv = 0;
			}
			if(oper_dep == '')
			{
				oper_dep = 0;
			}
			//alert(oper_dep);
			var component = $('#component2').val();
			if(component == '')
			{
				component = '';
			}
			var component1 =  "'"+component+"'";
			var s = $('#oper_code1').val();
			//logic implimentation for operation_order
			var pre_ops_order = $('#rowId').val();
			var first_ops_order = $('#first_ops_id').val();
			//var pre_ops_order = 10.111;
			if(first_ops_order == 0)
			{
				var pre_ops_order_string = "'"+pre_ops_order+"'";
				pre_ops_order_string = pre_ops_order_string.slice(1, -1);
				if(isInteger(pre_ops_order))
				{
					var actual_ops_order = Number(pre_ops_order) + Number(0.1)
				}
				else
				{
					Number.prototype.countDecimals = function () {
						if(Math.floor(this.valueOf()) === this.valueOf()) return 0;
						return this.toString().split(".")[1].length || 0; 
					}
					var no_of_decimals = Number(pre_ops_order).countDecimals();					pre_ops_order_string += '1';
					pre_ops_order_string += '1';
					var actual_ops_order = pre_ops_order_string;
				}

			}
			else
			{
				var actual_ops_order = pre_ops_order;
			}
			//console.log(pre_ops_order_string);

			var saving_data = [style_id,oper_name_id,actual_ops_order,0,m3_smv,m3_smv,s,oper_def1,s,style1,color1,2,barcode1,supplier_id,oper_seq,oper_dep,component1];
			//console.log(saving_data);
			  $.ajax
				({
						type: "POST",
						url:function_file+"?r=getdata&saving="+saving_data,
						data: {saving: $('#saving').val()},
						success: function(response)
						{
							console.log(response);
							//response = 'None';
							if(response == 'None')
							{
								sweetAlert("Please eneter valid Next Operation.","","warning");
							}
							else if(response == '')
							{
								sweetAlert("Operation  Not Inserted.","","warning");	
							}
							else
							{
								var data = jQuery.parseJSON(response);
								var response = data['last_id'];
								var changing = data['changed_ids'];
								$.each(changing, function( key, value )
								{
									var id = key+"ops_order";
									console.log(id);
									document.getElementById(id).innerHTML = value; 
								});
								//var response = data['last_id'];
								//var 
								//var response = response['last_id'];
								if(supplier == 'Select Supplier')
								{
									supplier = '';
								}
								var markup = "<tr><td class='none' id="+response+"operation_id>"+oper_name_id+"</td><td class='none' id="+response+"ops_order>"+actual_ops_order+"</td><td id="+response+"ops_code>"+s+"</td><td class='none'>"+pro_style_name+"</td><td class='none'>"+color+"</td><td id="+response+"operation_name>"+oper_name+"</td><td id="+response+"seq>"+oper_seq+"</td><td id="+response+"rep_to_erp>"+oper_def+"</td><td id="+response+"smv>"+m3_smv+"</td><td id="+response+"barcode>"+barcode+"</td><td id="+response+"supplier_id hidden='true'>"+supplier_id+"</td><td id="+response+"supplier>"+supplier+"</td><td id="+response+"dep>"+oper_dep+"</td><td id="+response+"comp>"+component+"</td><td><button type='button' class='btn btn-info btn-sm particular' id='particularedit'  onclick='myfunctionedit(this,"+response+")'><i class='fa fa-pencil-square-o' aria-hidden='true'></i></button></td><td><button type='button' class='btn btn-danger btn-sm'  onclick='default_oper("+response+",this)'><i class='fa fa-trash-o' aria-hidden='true'></i></td></button><td><button type='button' id='deletable' class='btn btn-primary btn-sm' onclick='value_edition(this,"+response+");'><i class='fa fa-plus' aria-hidden='true'></i></button></td></tr>";
								//$('#dynamic_table').append(markup);	
								var row = $("#rowIndex").val();
								//$('#dynamic_table > tbody > tr').eq(row-1).after(markup);
								if(row != 0 && first_ops_order == 0)
                                {
                                    $('#dynamic_table > tbody > tr').eq(row-1).after(markup);
                                }
                                else
                                {
									//$('#dynamic_table > tbody > tr').eq(0-1).after(markup);
									$("#dynamic_table").prepend(markup);
                                }
								var changed_id = $("#chaged_id").val();
								var changed_value = $("#actual_value").val();
								if(changed_value == '')
								{
									changed_value = Number($("#"+changed_id+"smv").html()) - Number($('#m3_smv1').val());
									//alert($('#m3_smv1').val());
									changed_value_rep = changed_value.toFixed(3)
									$("#"+changed_id+"smv").html(changed_value_rep);
								}
								  var saving_changes = [changed_id,changed_value];
									$.ajax
									({
											type: "POST",
											url:function_file+"?r=getdata&saving_changes="+saving_changes,
											data: {saving_changes: $('#saving_changes').val()},
											success: function(response)
											{
												
											}
										
									});
								$('#myModal').modal('toggle');
								//$('#myModal').find('input:text').val('');
								$('#m3_smv1').val(0);
								$("#oper_name").val(0);
								$("#supplier2").val(0);
								$("#m3_smv").val(0);
								document.getElementById('component1').readOnly=false;
								document.getElementById('component2').readOnly=false;
								//alert("Operation Successfully Inserted");
								//location.reload(true);
							}
						}
					
				});	
		}
		//$("input:radio[name=optradio2]:checked").val('No') ;
		$('#oper_seq2').val('0');
		$('#oper_depe2').val('');
		$('#component2').val('')		
	  });
	  function isInteger(value) {
    if ((undefined === value) || (null === value)) {
        return false;
    }
    return value % 1 == 0;
}
	 $("#m3_smv").change(function()
	{
		if($("#m3_smv1").val() == '')
		{
			sweetAlert("Please enter SMV.","","warning");
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
				//sw(actual_smv);
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
$('#ops_code1').change(function()
	{
		var ops_code_next = $('#ops_code1').val();
		var style = $('#pro_style option:selected').text();
		var color = $('#color option:selected').text();
		var pre_ops_code = $('#pre_ops_code').val();
		var erp_value = $("input:radio[name=reporttoerpradio1]:checked").val();
		var ops_code_next_ary = [ops_code_next,style,color,erp_value];
		$.ajax
			({
					type: "POST",
					url:function_file+"?r=getdata&ops_code_next="+ops_code_next_ary,
					data: {ops_code_next: $('#ops_code_next').val()},
					success: function(response)
					{
					console.log(response);
						if(response == 1)
						{
							sweetAlert("This Operation Code is already exists","","warning");
							$('#ops_code1').val(pre_ops_code);
						}
						if(response == 2)
						{
							sweetAlert("This Operation Code does not exists in M3","","warning");
							$('#ops_code1').val(pre_ops_code);
						}
					}

			});
	});
$("#edit").click(function()
{
	var flag = 1;
	var id = $('#editable_id').val();
	var barcode = $("input:radio[name=optradio]:checked").val();
	var barcode_text = "'"+barcode+"'";
	var report_to_erp = $("input:radio[name=reporttoerpradio1]:checked").val();
	var report_to_erp_text = "'"+report_to_erp+"'";
	var supplier = $('#supplier option:selected').text();
	var supplier_id = $('#supplier').val();
	var oper_seq = $('#oper_seq1').val();
	var oper_dep = $('#oper_depe1').val();
	var component = $('#component1').val();
	var ops_code1 = $('#ops_code1').val();
	var style = $('#pro_style option:selected').text();
	var color = $('#color option:selected').text();
	var component1 = "'"+component+"'";
	var color = "'"+color+"'";
	var style = "'"+style+"'";
	if(oper_seq == '')
	{
		sweetAlert("Please Enter Operation Group","","warning");
		flag = 0;
	}
	if($("input:radio[name=optradio]:checked").val() == undefined)
	{
		sweetAlert("Please Enter Barcode Yes/No.","","warning");
		flag = 0;
	}
	if($("input:radio[name=reporttoerpradio1]:checked").val() == undefined)
	{
		sweetAlert("Please Enter Report To ERP Yes/No.","","warning");
		flag = 0;
	}
	if($('component1').val() == '')
	{
		// sweetAlert("Please Enter Component Name","","warning");
		// flag= 0;
	}
	if(flag == 1)
	{
		editable_data = [id,barcode_text,supplier_id,oper_seq,oper_dep,component1,style,color,ops_code1,report_to_erp_text];
	$.ajax
		({
			
				type: "POST",
				url:function_file+"?r=getdata&editable_data="+editable_data,
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
						$("#"+id+"ops_code").html(ops_code1);
						$("#"+id+"rep_to_erp").html(report_to_erp);
					}
					else if(response == 0)
					{
						sweetAlert("Operation Not Updated","","warning");
					}
					else
					{
						sweetAlert("Please Enter Valid Next operation.","","warning");
						$('#oper_depe1').val('');
					}
			
					
				}
			
		});
		
	}
	
	
});

//$('#oper_seq1').change(function()
function sequence_checking_per_edit()
{
	var seq = $('#oper_seq1').val();
	var pro_style_name = $('#pro_style option:selected').text();
	var color = $('#color option:selected').text();
	var oper_name=$('#operation_name_id').val();
	var seq_params = [seq,pro_style_name,color,oper_name];
	if(seq != 0 || seq != ''){
		$.ajax
			({
				
					type: "POST",
					url:function_file+"?r=getdata&seq_params1="+seq_params,
					data: {},
					success: function(response)
					{
							console.log(response);
							//alert(response);
							if(response == 0)
							{
								sweetAlert("The Operation Already exists for this Group.","","warning");
								$('#oper_seq1').val(document.getElementById('operation_name_seq').value);
								$('#component1').val(document.getElementById('operation_name_comp').value);
								document.getElementById('component1').readOnly=true;
								$("input:radio[name=optradio]:checked").val('Yes');
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
	
}
//$('#oper_seq2').change(function()
function sequence_checking_per()
{
	var seq = $('#oper_seq2').val();
	var pro_style_name = $('#pro_style option:selected').text();
	var color = $('#color option:selected').text();
	var oper_name= $('#oper_name').val();
	var seq_params = [seq,pro_style_name,color,oper_name];
	if(seq != 0 && seq != ''){
		$.ajax
			({
				
					type: "POST",
					url:function_file+"?r=getdata&seq_params="+seq_params,
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
									sweetAlert("Operation Name Already in list for this Group.","","warning");
									$('#oper_name').val(0);
									$("#oper_code1").val('');
									$("#oper_def1").val('');
									$('#component2').val(temp[0]);
									document.getElementById('component2').readOnly=true;
									//$("input:radio[name=optradio2]:checked").val('Yes');
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
	
}
$('#oper_depe2').change(function()
{
	var flag = 1;
	var seq = $('#oper_seq2').val();
	if(seq == '')
	{
		sweetAlert("Please Enter Operation Group First","","warning");
		$('#oper_depe2').val('');
		flag = 0;
	}
	if(flag == 1)
	{
		var pro_style_name = $('#pro_style option:selected').text();
		var color = $('#color option:selected').text();
		var seq_params = [seq,pro_style_name,color]
		$.ajax
			({
				
					type: "POST",
					url:function_file+"?r=getdata&dep_validate="+seq_params,
					data: {},
					success: function(response)
					{
							if(response != 0)
							{
								//alert(seq);
								if(seq != 0)
								{
									sweetAlert("You are already allocated Next operation for this Group","","warning");
									$('#oper_depe2').val('');
								}
								
							}
					}
			});
		
	}
});
$('#oper_depe1').change(function()
{
	var seq = $('#oper_seq1').val();
	var check_flag = $('#dep_flag').val();
	if(check_flag == 'Yes' && seq != 0)
	{
		var flag = 1
		if(seq == '')
		{
			sweetAlert("Please Enter Operation Group First","","warning");
			$('#oper_depe1').val('');
			flag = 0;
		}
		var  oper_dep_value = $('#oper_depe1').val();
		if(flag == 1)
		{
			var pro_style_name = $('#pro_style option:selected').text();
			var color = $('#color option:selected').text();
			var seq_params = [seq,pro_style_name,color]
			$.ajax
				({
					
						type: "POST",
						url:function_file+"?r=getdata&dep_validate="+seq_params,
						data: {},
						success: function(response)
						{
								if(response != 0)
								{
									if(seq != 0 && oper_dep_value != '')
									{
										sweetAlert("You are already allocated Next operation for this Group","","warning");
										$('#oper_depe1').val('');
									}
									
								}
						}
				});
		}
	}
	
	
	
	
});

// $("#yes").click(function()
// {
	// var editable_val = $('#deletable_id').val();
	// smv = document.getElementById(editable_val+"smv").innerText;
	// if(smv != 0)
	// {
		// $('#m3_opss').show();
	// }
	// $('#no').hide();
	// $('#yes').hide();
	// $('#proceed').show();
// });
$('#proceed').click(function()
{
	// alert();
	var del_row_id = $('#row_index_del').val();
	flag = 0;
	// $('#m3_ops').val(0);
	var deletable_val = $('#m3_ops').val();
	var editable_val = $('#deletable_id').val();
	smv = document.getElementById(editable_val+"smv").innerText;
	// console.log(s)
	var deletable_val = 0;
	var parameters = [deletable_val,editable_val];
	var smv = 0;
	if(smv != 0)
	{
		//$('#m3_opss').show();
		if(deletable_val == 0)
		{
			sweetAlert("please select M3 Operation.","","warning");
			flag = 1;
		}
	}
	if(flag == 0)
	{
		$.ajax
		({
			
				type: "POST",
				url:function_file+"?r=getdata&parameters="+parameters,
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
	
// $('#proceed').hide();	
	
});
	

$('#m3_smv1').change(function()
{
	var m3_smv_manual_value = $('#m3_smv1').val();
	var style = $('#pro_style option:selected').text();
	var color = $('#color option:selected').text();
	var m3_smv_manual_value_ary = [m3_smv_manual_value,style,color];
	$.ajax
		({
			
				type: "POST",
				url:function_file+"?r=getdata&manual_smv_value="+m3_smv_manual_value_ary,
				data: {},
				success: function(response)
				{
					console.log(response);
					if(response == 0)
					{
						sweetAlert('Smv should less than M3-Smv.','','warning');
						$('#m3_smv1').val(0);
					}
					else
					{
						$('#m3_smv1').val(m3_smv_manual_value);
					}
				}
		});
});
function value_edition(btn,id_of_main)
{
	console.log("working");
	var style = $('#pro_style option:selected').text();
	var color = $('#color option:selected').text();
	var dependency_ops_ary = [style,color];
	$.ajax
		({
			
				type: "POST",
				url:function_file+"?r=getdataa&adding_validation="+dependency_ops_ary,
				data: {},
				success: function(response)
				{
					if(response == 1)
					{
						sweetAlert("You can't add the operation because scanning already started for this style","","warning");
					}
					else if(response == 4)
					{
						sweetAlert("You can't add the operation because because already layplan prepared for this style and color","","warning");
					}
					else if(id_of_main != 0)
					{
						var table = document.getElementById("dynamic_table1");
						var row = btn.parentNode.parentNode;
						var ind = row.rowIndex;
						var value_ind = id_of_main+"ops_order";
						console.log(value_ind);
						var ind_value_ops_order = document.getElementById(value_ind).innerText;
						console.log(ind_value_ops_order);
						document.getElementById('rowIndex').value = ind;
						document.getElementById('rowId').value = ind_value_ops_order;

						$('#myModal').modal('toggle');
					}
					else
					{
						var first_ops_check = 0;
						var table = document.getElementById("dynamic_table1");
						var row = btn.parentNode.parentNode;
						var ind = row.rowIndex;
						document.getElementById('rowIndex').value = 0;
						document.getElementById('rowId').value = 1;
						document.getElementById('first_ops_id').value = 1;
						$('#myModal').modal('toggle');
					}
				}
		});
	
}
function default_oper(value,btn)
{
	myvalue = btn;
	console.log(myvalue);
	var dep = value+"ops_code";
	console.log(dep);
	var dependency_ops = document.getElementById(dep).innerText;
	var style = $('#pro_style option:selected').text();
	var color = $('#color option:selected').text();
	var dependency_ops_ary = [dependency_ops,style,color];
	$.ajax
		({
			
				type: "POST",
				url:function_file+"?r=getdata&dependency_ops_ary="+dependency_ops_ary,
				data: {},
				success: function(response)
				{
					console.log(response);
					
					if(response == 1)
					{
						$('#myModal1').modal('toggle');
						document.getElementById("deletable_id").value = value;
						document.getElementById("row_index_del").value = btn;
						var editable_val = $('#deletable_id').val();
						smv = document.getElementById(editable_val+"smv").innerText;
						if(smv != 0)
						{
							$('#m3_opss').show();
						}	
					}
					else if(response == 3)
					{
						sweetAlert("You can't delete this operation because this operation using as Next operation.","","warning");
					}
					else if(response == 4){
						sweetAlert("You can't delete this operation because already layplan prepared for this operation.","","warning");
					}
					else
					{
						sweetAlert("You can't delete this operation because this Group already sent for scanning.","","warning");
					}
				}
		});
	
}	
</script>
<script type="text/javascript">
var myvalue;
function hidingrow()
{
	var table = document.getElementById("dynamic_table");
    var row = myvalue.parentNode.parentNode;
	row.parentNode.removeChild(row);
}

function initialize(count)
{
	document.getElementById('new_rowId').value = count;
}
function myfunctionedit(val,id)
{
	dep = id+"ops_code";
	var dependency_ops = document.getElementById(dep).innerText;
	var style = $('#pro_style option:selected').text();
	var color = $('#color option:selected').text();
	var dependency_ops_ary = [dependency_ops,style,color];
	$.ajax
		({
			type: "POST",
			url:function_file+"?r=getdata&dependency_ops_ary="+dependency_ops_ary,
			data: {},
			success: function(response)
			{
				if(response == 2)
				{
					sweetAlert("You can't Edit this operation because this operation Group already sent for scanning.","","warning");
					flag=0;
				}
				else if(response == 4){
					sweetAlert("You can't Edit this operation because already layplan prepared for this style and color.","","warning");
					flag=0;
				}
				else
				{
					console.log(id);
					document.getElementById('editable_id').value = id;
					actual_barcode = id+"barcode";
					seq = id+"seq";
					dep = id+"dep";
					comp=id+"comp";
					sup_id = id+"supplier_id";
					oper_id = id+"operation_name";
					oper_act_id = id+"operation_id";
					ops_code = id+"ops_code";
					rep_to_erp = id+"rep_to_erp";
					oper_act_id = document.getElementById(oper_act_id).innerText;
					//var barcode = "#"+actual_barcode;
					barcode = document.getElementById(actual_barcode).innerText;
					seqence = document.getElementById(seq).innerText;
					dep = document.getElementById(dep).innerText;
					comp = document.getElementById(comp).innerText;
					sup_id = document.getElementById(sup_id).innerText;
					oper_na = document.getElementById(oper_id).innerText;
					oper_code = document.getElementById(ops_code).innerText;
					actual_rep_to_erp = document.getElementById(rep_to_erp).innerText;
					document.getElementById('oper_seq1').value = seqence;
					document.getElementById('operation_name_id').value = oper_act_id;
					document.getElementById('operation_name_seq').value = seqence;
					document.getElementById('operation_name_comp').value = comp;
					document.getElementById('ops_code1').value = oper_code;
					document.getElementById('pre_ops_code').value = oper_code;
					if(seqence != '')
					{
						document.getElementById('component1').readOnly=true;
					}
					if(dep == 0)
					{
						dep = '';
						document.getElementById('dep_flag').value = 'Yes';
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
					if(actual_rep_to_erp == 'Yes')
					{
						document.getElementById("erp_Yes").checked = true;
					}
					else if(actual_rep_to_erp == 'No')
					{
						document.getElementById("erp_None").checked = true;
					}
					else
					{
						document.getElementById("erp_Yes").checked = false;
						document.getElementById("erp_None").checked = false;
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
					$('#myModal2').modal('toggle');				
				}
			}
		});
}
function autooperseq()
{
	document.getElementById('oper_seq2').value = 0;
	document.getElementById('oper_seq1').value = 0;
	document.getElementById('component2').value = '';
	document.getElementById('component1').value = '';
}
function autooperseq1()
{
	document.getElementById('oper_seq2').value = 0;
	document.getElementById('oper_seq1').value = 0;
	document.getElementById('component2').value = '';
	document.getElementById('component1').value = '';
}
function verify_num_seq2 ()
{
	// var barcode = $("input:radio[name=optradio]:checked").val();
	// var val = document.getElementById('oper_seq1').value;
	// console.log(barcode);
	// if(barcode == 'No' && val != 0 || barcode == 'undefined')
	// {
	// 	sweetAlert("Please Set Barcode As Yes","","warning");
	// 	document.getElementById('oper_seq1').value = 0;
	// }
	// else
	// {
	// 		sequence_checking_per_edit();
	// }
}
function verify_num_seq1()
{
	// var barcode = $("input:radio[name=optradio2]:checked").val();
	// console.log(barcode);
	// var val = document.getElementById('oper_seq2').value;
	// console.log(barcode);
	// if(barcode == 'No' && val != 0 || barcode == undefined)
	// {
	// 	sweetAlert("Please Set Barcode As Yes","","warning");
	// 	document.getElementById('oper_seq2').value = 0;
	// }
	// else
	// {
	// 		sequence_checking_per();
	// }
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