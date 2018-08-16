<!--- Developed by Srinivas Y --->
<?php
include(getFullURLLevel($_GET['r'],'/common/config/config.php',5,'R'));
$has_permission=haspermission($_GET['r']);
$qry_get_operation_name = "SELECT id,operation_name,default_operation,operation_code FROM $brandix_bts.tbl_orders_ops_ref";
$result_oper = $link->query($qry_get_operation_name);
?>
<!-- 
	Code: Removed mandatory (*) for M3 SMV while adding operation
	Database: Removed NOT NULL option for the table 'tbl_style_ops_master'
	by Theja on 06-02-2018
-->
<head><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"></head>
<div class='container'>
	<div class="panel panel-primary">
		<div class="panel-heading"><strong>Default Operation Flow</strong></div>
		<div class="panel-body">
            <div id ="dynamic_table1">
                <table class = 'table table-striped' id='dynamic_table'><thead><tr><th>Operation Code</th><th>Operation Name</th><th>Operation Group</th><th>Report To ERP</th><th>Barcode</th><th>Next Operations</th><th>Component</th><th></th><th style='text-align:center;'>Controls</th><th><button type='button' id='deletable' class='btn btn-primary btn-sm' onclick='value_edition(this,0);'><i class='fa fa-plus' aria-hidden='true'></i></button></th></tr></thead>
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
                            <label for="inputsm" hidden='true'>Report To ERP <span data-toggle="tooltip" data-placement="top" title="It's Mandatory field"><font color='red'>*</font></span></label>
                            <input type="hidden" id="oper_def1" type="text">
                            <label for="inputsm" hidden='true'>Operation Code <span data-toggle="tooltip" data-placement="top" title="It's Mandatory field"><font color='red'>*</font></span></label></br>
                            <input type="hidden" id="oper_code1" type="text" hidden='true'>
                    </br>
					<label>Barcode <span data-toggle="tooltip" data-placement="top" title="It's Mandatory field"><font color='red'>*</font></span></label>
					<label class="radio-inline"><input type="radio" name="optradio2" value ="Yes" id='optradio2' onclick="autooperseq1()">Yes</label>
					<label class="radio-inline"><input type="radio" name="optradio2" value = "No" id= 'optradio2' onclick="autooperseq()">No</label><br><br>
					<label>Operation Group</label>
					<input class="form-control input-sm integer" id="oper_seq2" type="text" onchange='verify_num_seq1(this)' value = '0'>
					<label>Next Operation</label>
					<input class="form-control input-sm integer" id="oper_depe2" type="text">
					<label>Component</label>
					<input class="form-control input-sm" id="component2" type="text">
					<label></label><br/>
					<button class="btn btn-primary btn-sm" hidden='true' id='add-row1'>Add Operation </button>
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
				<div class="col-md-4" id = "proceed" >
					<center><button class="btn btn-primary btn-lg" id='proceed'>Proceed</button></center>
				</div>
				<div class="col-md-4" id = "no">
					<center><button class="btn btn-primary btn-lg" id='No' data-dismiss="modal">No</button></center>
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
		<label style='display:none;'>Operation Code <span data-toggle="tooltip" data-placement="top" title="It's Mandatory field"><font color='red'>*</font></span></label>
		<div hidden='true'>
		<input class="form-control input-sm integer" id="ops_code1" type="text">
		</br>
		</div>
			<label>Barcode <span data-toggle="tooltip" data-placement="top" title="It's Mandatory field"><font color='red'>*</font></span></label>
			<label class="radio-inline"><input type="radio" name="optradio" value ="Yes" id='Yes' onclick="autooperseq1()">Yes</label>
			<label class="radio-inline"><input type="radio" name="optradio" value = "No" id= 'None' onclick="autooperseq()">No</label><br><br>
			<label>Operation Group </label>
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
var function_file = "<?php echo getFullURL($_GET['r'],'functions_default_ops_flow.php','R'); ?>";

$("#clear").click(function(){
    window.location.href="/material_approval.php";
});
$(document).ready(function(){
	$('#loading-image').hide();
	//s$('#oper_name').select2();
	params = 'GetData';
    $.ajax
    ({
            type: "POST",
            url:function_file+"?r=getdata&params="+params,
            data: {params: $('#params').val()},
            success: function(response)
            {
               // $("#dynamic_table1").html(" ");
                $('#loading-image').hide();
                console.log(response);
                if(response != 100)
                {
                    var data = jQuery.parseJSON(response);
                    console.log(data.length);
                    <?php
                        if(in_array($update,$has_permission))
                        {	?>
                            //markup+="<button type='button' class='btn btn-info btn-sm particular' id='particular' hidden='true'>Add Manual Operation</i></button>";
                            <?php	
                        } 
                    ?>
                   // markup+="</tr></thead>";
                   // $("#dynamic_table1").append(markup);
                    for(var i=0;i<data.length;i++)
                    {
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
						<?php
							if(in_array($delete,$has_permission))
							{	?>
								var deleting_html = "<td><button type='button' id='deletable' class='btn btn-danger btn-sm'  onclick='default_oper("+data[i].main_id+",this)'><i class='fa fa-trash-o' aria-hidden='true'></i></button></td>";
								<?php
							} 
						?>
                            
                        
                        // if(data[i]['operation_code'] == 10 || data[i]['operation_code'] == 15|| data[i]['operation_code'] == 200)
                        // {
                        //     var editing_class = 'none';
                        // }
                        // else
                        // {
                        //     var editing_class = '';
                        // }
                        var markup1 = "<tr><td class='none' id="+data[i].main_id+"operation_id>"+data[i]['operation_id']+"</td><td id="+data[i].main_id+"ops_code>"+data[i]['operation_code']+"</td><td class='none' id="+data[i].main_id+"ops_order>"+data[i]['operation_order']+"</td><td id="+data[i].main_id+"operation_name>"+data[i]['ops_name']+"</td><td id="+data[i].main_id+"seq>"+data[i].ops_sequence+"</td><td>"+data[i]['default_operration']+"</td></td><td id="+data[i].main_id+"barcode>"+data[i].barcode+"</td><td id="+data[i].main_id+"dep>"+data[i].ops_dependency+"</td><td id="+data[i].main_id+"comp>"+data[i].component+"</td>";
                        <?php
                            if(in_array($edit,$has_permission))
                            {	?>
                                markup1 +="<td><button type='button' class='btn btn-info btn-sm particular' id='particularedit'  onclick='myfunctionedit(this,"+data[i].main_id+")'><i class='fa fa-pencil-square-o' aria-hidden='true'></i></button></td>";
                                <?php	
                            } 
                        ?>
                        var adding_html	= "<td><button type='button' id='deletable' class='btn btn-primary btn-sm' onclick='value_edition(this,"+data[i].main_id+");'><i class='fa fa-plus' aria-hidden='true'></i></button></td>";
                        markup1+= deleting_html+ adding_html+"</tr>";
                        s_no++;
                            $("#dynamic_table").append(markup1);
                    }
                    var markup2 = "</tbody></table>";
                        $("#dynamic_table").append(markup2);
                }
                else
                {
                   // var markup1 = "<b style='color:red;'>Sorry!!! No Operations found.</b>";
                       // $("#dynamic_table1").append(markup1);
                }
                document.getElementById('component1').readOnly=false;
                document.getElementById('component2').readOnly=false;
            }	
        
    });
	$("#oper_name").change(function()
	{
			//var url = "getdata()";
			var oper_name= $('#oper_name').val();
			var seq = $('#oper_seq2').val();
			if(seq == '')
			{
				seq = 100;
			}
			//var schedule_name = $('#schedule option:selected').text();
			var oper_name =[oper_name,seq];
            console.log(oper_name);
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
			var oper_name_id = $('#oper_name').val();
			var oper_name = $('#oper_name option:selected').text();
			var oper_def = $('#oper_def1').val();
			var oper_def1 = "'"+oper_def+"'";
			var barcode = $("input:radio[name=optradio2]:checked").val();
			var barcode1 =  "'"+barcode+"'";
			var oper_seq = $('#oper_seq2').val();
			var oper_dep = $('#oper_depe2').val();
            var s = $('#oper_code1').val();
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
		    var pre_ops_order = Number($('#rowId').val());
			var first_ops_order = Number($('#first_ops_id').val());
			//var pre_ops_order = 10.111;
			console.log(first_ops_order);
            if(first_ops_order == 0)
            {
                var pre_ops_order_string = "'"+pre_ops_order+"'";
                pre_ops_order_string = pre_ops_order_string.slice(1, -1);
				console.log(pre_ops_order);
                if(isInteger(pre_ops_order))
                {
					console.log("is integer working");
                    var actual_ops_order = Number(pre_ops_order) + Number(0.1)
                }
                else
                {
                    Number.prototype.countDecimals = function () {
                        if(Math.floor(this.valueOf()) === this.valueOf()) return 0;
                        return this.toString().split(".")[1].length || 0; 
                    }
                    var no_of_decimals = pre_ops_order.countDecimals();
                    console.log(pre_ops_order_string);
                    pre_ops_order_string += '1';
                    var actual_ops_order = Number(pre_ops_order_string);
                }
            }
            else
            {
                var actual_ops_order = pre_ops_order;
			}
			//alert(vactual_ops_order);
			var saving_data = [oper_name_id,s,actual_ops_order,oper_def1,oper_seq,oper_dep,component1,barcode1];
			//console.log(saving_data);
			  $.ajax
				({
						type: "POST",
						url:function_file+"?r=getdata&saving="+saving_data,
						data: {saving: $('#saving').val()},
						success: function(response)
						{
							//console.log(response);
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
								var markup = "<tr><td class='none' id="+response+"operation_id>"+oper_name_id+"</td><td class='none' id="+response+"ops_order>"+actual_ops_order+"</td><td id="+response+"ops_code>"+s+"</td><td id="+response+"operation_name>"+oper_name+"</td><td id="+response+"seq>"+oper_seq+"</td><td>"+oper_def+"</td><td id="+response+"barcode>"+barcode+"</td><td id="+response+"dep>"+oper_dep+"</td><td id="+response+"comp>"+component+"</td><td><button type='button' class='btn btn-info btn-sm particular' id='particularedit'  onclick='myfunctionedit(this,"+response+")'><i class='fa fa-pencil-square-o' aria-hidden='true'></i></button></td><td><button type='button' class='btn btn-danger btn-sm'  onclick='default_oper("+response+",this)'><i class='fa fa-trash-o' aria-hidden='true'></i></button></td><td><button type='button' id='deletable' class='btn btn-primary btn-sm' onclick='value_edition(this,"+response+");'><i class='fa fa-plus' aria-hidden='true'></i></button></td></tr>";
								//$('#dynamic_table').append(markup);	
								var row = $("#rowIndex").val();
                                if(row != 0 && first_ops_order == 0)
                                {
                                    $('#dynamic_table > tbody > tr').eq(row-1).after(markup);
                                }
                                else
                                {
									//$('#dynamic_table > tbody > tr').eq(0-1).after(markup);
									$("#dynamic_table").prepend(markup);
                                }
								$('#myModal').modal('toggle');
								$('#myModal').find('input:text').val('');
								$("#oper_name").val(0);
								document.getElementById('component1').readOnly=false;
								document.getElementById('component2').readOnly=false;
								//location.reload(true);
								//alert("Operation Successfully Inserted");
							}
						}
					
				});	
		}
		//$("input:radio[name=optradio2]:checked").val('No') ;
		//$('#oper_seq2').val(0);			
	  });
	  function isInteger(value) {
        if ((undefined === value) || (null === value)) {
        return false;
        }
        return value % 1 == 0;
        }
	
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
	var barcode = $("input:radio[name=optradio]:checked").val();
	var barcode_text = "'"+barcode+"'";
	var oper_seq = $('#oper_seq1').val();
	var oper_dep = $('#oper_depe1').val();
	var component = $('#component1').val();
	var ops_code1 = $('#ops_code1').val();
	console.log(ops_code1);
	var component1 = "'"+component+"'";
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
	if($('component1').val() == '')
	{
		// sweetAlert("Please Enter Component Name","","warning");
		// flag= 0;
	}
	if(flag == 1)
	{
		editable_data = [id,barcode_text,oper_seq,oper_dep,component1,ops_code1];
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
						// if(supplier == 'Select Supplier')
						// {
						// 	supplier = '';
						// }
						//$("#"+id+"supplier").html(supplier);
						//alert(supplier_id);
						//$("#"+id+"supplier_id").html(supplier_id);
						$("#"+id+"seq").html(oper_seq);
						$("#"+id+"dep").html(oper_dep);
						$("#"+id+"comp").html(component);
						$("#"+id+"ops_code").html(ops_code1);
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
	var seq_params = [seq,oper_name];
    console.log(seq_params);
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
	var seq_params = [seq,oper_name];
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
		var seq_params = [seq];
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
	var del_row_id = $('#row_index_del').val();
	flag = 0;
	var deletable_val = $('#deletable_id').val();
	//var editable_val = $('#deletable_id').val();
	//smv = document.getElementById(editable_val+"smv").innerText;
	// console.log(s)
	var parameters = [deletable_val];
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
function value_edition(btn,id_of_main)
{	
    if(id_of_main != 0)
    {
        var table = document.getElementById("dynamic_table1");
        var row = btn.parentNode.parentNode;
        var ind = row.rowIndex;
		console.log(ind);
        var value_ind = id_of_main+"ops_order";
        console.log(value_ind);
        var ind_value_ops_order = document.getElementById(value_ind).innerText;
        console.log(ind_value_ops_order);
        document.getElementById('rowIndex').value = ind;
        document.getElementById('rowId').value = ind_value_ops_order;
		document.getElementById('first_ops_id').value = 0;
        $('#myModal').modal('toggle');
    }
    else
    {
		var first_ops_check = 0;
		var table = document.getElementById("dynamic_table1");
        var row = btn.parentNode.parentNode;
        var ind = row.rowIndex;
		console.log(ind);
		$.ajax
		({
				type: "POST",
				url:function_file+"?r=getdata&first_ops_check="+first_ops_check,
				data: {paramefirst_ops_checkters: $('#first_ops_check').val()},
				success: function(response)
				{
					document.getElementById('rowIndex').value = 0;
					document.getElementById('rowId').value = 1;
					document.getElementById('first_ops_id').value = response;
					$('#myModal').modal('toggle');

				}
		});
    }
}
function default_oper(value,btn)
{
	myvalue = btn;
	console.log(myvalue);
	var dep = value+"ops_code";
	console.log(dep);
	$('#myModal1').modal('toggle');
	document.getElementById("deletable_id").value = value;
	document.getElementById("row_index_del").value = btn;	
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
				else
				{
					console.log(id);
					document.getElementById('editable_id').value = id;
					actual_barcode = id+"barcode";
					seq = id+"seq";
					dep = id+"dep";
					comp=id+"comp";
					//sup_id = id+"supplier_id";
					oper_id = id+"operation_name";
					oper_act_id = id+"operation_id";
					ops_code = id+"ops_code";
					oper_act_id = document.getElementById(oper_act_id).innerText;
					//var barcode = "#"+actual_barcode;
					barcode = document.getElementById(actual_barcode).innerText;
					seqence = document.getElementById(seq).innerText;
					dep = document.getElementById(dep).innerText;
					comp = document.getElementById(comp).innerText;
					//sup_id = document.getElementById(sup_id).innerText;
					oper_na = document.getElementById(oper_id).innerText;
					oper_code = document.getElementById(ops_code).innerText;
					document.getElementById('oper_seq1').value = seqence;
					document.getElementById('operation_name_id').value = oper_act_id;
					document.getElementById('operation_name_seq').value = seqence;
					document.getElementById('operation_name_comp').value = comp;
					document.getElementById('ops_code1').value = oper_code;
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
					//alert(sup_id);
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
	document.getElementById('oper_seq2').value = '';
	document.getElementById('oper_seq1').value = '';
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