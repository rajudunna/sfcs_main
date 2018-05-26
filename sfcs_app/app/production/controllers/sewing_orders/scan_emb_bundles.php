<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta http-equiv="X-UA-Compatible" content="IE=11; IE=9; IE=8; IE=7; IE=6; IE=5; IE=EDGE" />
		<link rel="stylesheet" href="cssjs/bootstrap.min.css">
		<link rel="stylesheet" href="cssjs/select2.min.css">
		<style>
			#loading-image {
			  border: 16px solid #f3f3f3;
			  border-radius: 50%;
			  border-top: 16px solid #3498db;
			  width: 120px;
			  height: 120px;
			  margin-left: 40%;
			  -webkit-animation: spin 2s linear infinite; /* Safari */
			  animation: spin 2s linear infinite;
			}

			/* Safari */
			@-webkit-keyframes spin {
			  0% { -webkit-transform: rotate(0deg); }
			  100% { -webkit-transform: rotate(360deg); }
			}

			@keyframes spin {
			  0% { transform: rotate(0deg); }
			  100% { transform: rotate(360deg); }
			}
		</style>
	</head>
	<body> 
		<div class="container-fluid">			
			<div class="panel panel-info"> 
            	<div class="panel-heading">
					<div class='row'>
						<div class='col-md-1'>
							<a href='/ff/projects/Beta/bundle_track/sewing_orders/pre_bundle_scanning.php?shift=<?php echo $_GET['shift'];?>'><h4><b><u>Back</u></h4><b></a>
						</div>
						<div class='col-md-2'>
							
						</div>
						<div class='col-md-9'>
							<h4>Style:&nbsp;<?php echo $_GET['style'];?> &nbsp;&nbsp; Schedule: <?php echo $_GET['schedule'];?> &nbsp;&nbsp; Color: <?php echo $_GET['color'];?>
						</div>
					</div>
					<center style='color:red;'><h3>Operation You Are Scanning Is &nbsp;<span style='color:green;'><?php echo $_GET['operation_name'];?></span>&nbsp; On The Shift &nbsp;&nbsp;<span style='color:green;'><?php echo $_GET['shift'];?></span></h3><center>
				</div>
					
                <div class="panel-body">
           
                    <form action="apicalls1.php" method="POST" id="panelform">
						<div class='row'>
							<div class="form-group col-md-3">
								<label>Bundle Number:<span style="color:red">*</span></label>
								<input type="text" name="bundlenumber"  id="bundlenumber" class="form-control" required placeholder="Scan the bundle..."/>
							</div>
		
								<!--<input type="text" name="operation"  id="operation" class="form-control" required readonly /> -->
								<input type="hidden"  name="send_qty" id="send_qty" class="form-control" required />
								<input type="hidden"  name="operationid" id="operationid" class="form-control" value = '<?php echo $_GET['operation'] ?>' required/>
								<input type="hidden"  name="operation_id_po" id="operation_id_po" class="form-control" value = '<?php echo $_GET['operation'] ?>' required/>
								<input type="hidden"  name="style" id="style" class="form-control" value = '<?php echo $_GET['style'] ?>' required/>
								<input type="hidden"  name="schedule" id="schedule" class="form-control" value = '<?php echo $_GET['schedule'] ?>' required/>
								<input type="hidden"  name="color" id="color" class="form-control" value = '<?php echo $_GET['color'] ?>' required/>
								<input type="hidden"  name="operation_name" id="operation_name" class="form-control" value = '<?php echo $_GET['operation_name'] ?>' required/>
								<input type="hidden"  name="shift" id="shift" class="form-control" value = '<?php echo $_GET['shift'] ?>' required/>
						   
			   
							<div class="form-group" id="gd">
								<div class="col-md-3">
									<label>Good:<span style="color:red">*</span></label>
									<input type="number" name="good" required min=0 id="good" class="form-control"/>
								</div>
								<div class="col-md-3" id="bd">
									 <label>Rejected:</label>
									<input type="number" name="bad"  min=0 id="bad" class="form-control"/>
								</div>
								<div class="col-md-3" id="mis">
									<label>Missing:</label>
									<input type="number" name="missing" min=0 id="missing" class="form-control"/>
								</div>
							</div>
						</div>
                        <div class="form-group" id="rm">
                            <label>Remarks:</label>
                            <textarea type="text" name="remarks"  class="form-control"></textarea> 
                        </div>
                        <div class="form-group" id="rej">
				            <span class="pull-right"><strong>Note: For Missing panels please select (MI-Missing) in reasons dropdown</strong>		</span>
                        	<div class="panel panel-info"> 
				            	<div class="panel-heading"><strong>Rejection Reasons</strong></div>				            	
				                <div class="panel-body">
						           	<div class="form-group col-md-2" id="res">
			                            <label>No of Reasons:</label>
					                	<input type="number" name="reason" min=0 id="reason" class="form-control" placeholder="Enter no of reasons"/>
					                </div>
					                <div class="form-group col-md-8" id="panels">
			                            <label>Enter Panel No's(,):</label>
					                	<input type="text" name="panel" id="panel" class="form-control" placeholder="Enter Panel No's (,) seperated"/>
					                </div>
		                            <table class="table table-bordered" width="100" style="height: 50px; overflow-y: scroll;">
		                            	<thead>
		                            		<tr>
		                            			<th style="width: 7%;">S.No</th>
		                            			<th style="width: 16%;">Bundle No</th>		                            			
		                            			<th>Reason</th>
		                            			<th style="width: 20%;">Quantity</th>
		                            		</tr>
		                            	</thead>
		                            	<tbody id="tablebody"></tbody>
		                            </table>
		                        </div>
                            </div>
                        </div>
                        <input type="hidden" name="submit" value="submit"/>
                        <button type="submit" class="btn btn-primary" id="submit">Save</button>
                    </form>
                	<img src='cssjs/loading2.gif' id="loading-image" class="img-responsive"/>
                </div>
            </div>
        </div>		
	</body>
</html>
<script type="text/javascript" src="cssjs/jquery.min.js"></script>
<script type="text/javascript" src="cssjs/select2.min.js"></script>
<script src="cssjs/bootstrap.min.js"></script>
<script>
//alert(document.documentMode);
$(document).ready(function() {	
    $('#opr').hide();
    $('#gd').hide();
    $('#bd').hide();
    $('#mis').hide();
    $('#rm').hide();
    $('#rej').hide();
    $('#res').hide();
    $('#panels').hide();
    $('#submit').hide();
    $("#original_qty").hide();
    $('#loading-image').hide();
    $("#bundlenumber").change(function(){
    	var bundlenumber = $("#bundlenumber").val();
		var operation = $('#operation_id_po').val();
		var bundlenumber = [bundlenumber,operation];
    	if(bundlenumber[0] != ''){
		    var pattern = /^[0-9]*-[0-9]*$/g;
		    var result = bundlenumber[0].match(pattern);
		    if(result){
		    	var val = result[0].substr(result[0].indexOf("-") + 1);
		    	if(val){
		    		$.ajax({
					    type: "get",
					    url: "apicalls1.php?bundlenumber="+bundlenumber,
					    dataType: "json",
					    success: function (data) {
					    	$('#loading-image').hide();
					    	if(data['operation_id']){		
					    		var operation = data['operation_name'] +"("+ data['operation_id']+")";		
					    		$("#operation").val(operation);
					    		$("#operationid").val(data['operation_id']);				    		
					    		$("#good").val(data['send_qty']);
					    		$("#send_qty").val(data['send_qty']);
					    		$("#sen_qty").html(data['send_qty']);
					    		$("#original_qty").html(data['original_qty']);
								$("#bundlenumber").attr("readonly",true);
		    					$('#opr').show();
		    					$('#gd').show();
							    $('#bd').show();
							    $('#mis').show();
							    $('#rm').show();
							    $('#rej').show();
							    $("#original_qty").show();
							    $('#submit').show();
					    	}else if(data['status']){
					    		alert(data['status']);
					    		$("#bundlenumber").val("");
					    		$("#operation").val("");
					    		$("#operationid").val("");
					    		$("#send_qty").val("");
					    		$("#sen_qty").val("");
					    		$("#original_qty").val("");
					    		$("#good").val("");
					    		$('#opr').hide();
					    		$('#gd').hide();
							    $('#bd').hide();
							    $('#mis').hide();
							    $('#rm').hide();
							    $('#rej').hide();
							    $("#original_qty").hide();
							    $("#sen_qty").hide();
							    $('#submit').hide();
					    	}			              
					    }				    
					});	
				}else{
					alert("Please scan valid Bundle number");
		    		$("#bundlenumber").val("");
				}		    	
		    }else{
		    	alert("Please scan valid Bundle number");
		    	$("#bundlenumber").val("");
		    }
    	}    		
    });

	$("#good").change(function(){
		validateQuantity(this.id);
	});

	$("#bad").change(function(){
		var bad = $("#bad").val();
		if(bad){
			$('#res').show();			
			$('#panels').show();
			$('#reason').attr("required",true);
			$('#panel').attr("required",true);
		}else{
			$('#res').hide();
			$('#panels').hide();
			$('#reason').attr("required",false);
			$('#panel').attr("required",false);
			$("#reason").val("");			
			$("#panel").val("");
			$("#tablebody").html("");
		}
		validateQuantity(this.id);
	});

	$("#missing").change(function(){
		var missing = $("#missing").val();
		if(missing){
			$('#res').show();
			$('#panels').show();
			$('#reason').attr("required",true);			
			$('#panel').attr("required",false);
		}else{
			$('#res').hide();
			$('#panels').hide();
			$('#reason').attr("required",false);
			$('#panel').attr("required",false);
			$("#reason").val("");
			$("#panel").val("");
			$("#tablebody").html("");
		}
		validateQuantity(this.id);
	});

	$("#reason").change(function(){
		var res = $("#reason").val();
		noteRejections(res,this.id);
	});

	function validateQuantity(id){
		var good = ($("#good").val())?$("#good").val():0;
		var bad = ($("#bad").val())?$("#bad").val():0;
		var missing = ($("#missing").val())?$("#missing").val():0;
		var send_qty = $("#send_qty").val();

		var total = parseInt(good)+parseInt(bad)+parseInt(missing);
		if(total > send_qty){
			var res = "Enter quantity "+total+" is greatter than send quantity "+send_qty;
			alert(res);
			$("#"+id).val("");
			$('#res').hide();
			$('#panels').hide();
			$('#reason').attr("required",false);
			$('#panel').attr("required",false);
			$("#reason").val("");
			$("#panel").val("");
			$("#tablebody").html("");
		}
	}
	var results = [];
	function getReasons(){
		$.ajax({
			type: "get",
		    url: "apicalls1.php?reason=reason",
		    dataType: "json",
		    success: function (data) {
		    	if(data){
		    		results = data;
		    	}
		    }
		});
	}

	function noteRejections(total,id){		
		var bundlenumber = $("#bundlenumber").val();
		var bun = bundlenumber.split('-');
		$("#tablebody").html("");
		if(total >0){
			var req = true;
		}else{
			var req = false;
		}
		// var scriptHost = scriptElements[scriptElements.length-1].getAttribute("src").replace(/\/[^\/]+$/, ""); 
		for(i = 0; i < total ; i++){			
			var tr = $("<tr></tr>");
			var td1 = $("<td></td>").text( i + 1 + "");
			var td2 = $("<td></td>").text(bun[0]);
			var td3 = $("<td></td>").html("<select name='rejection["+i+"][reason]' class='form-control select2' onchange='checkReason(this.id)' required="+req+" id='rejection["+i+"][reason]' style='width:100%;'><option value=''>Select Reason</option></select>");
			var td4 = $("<td></td>").html("<input type='number' class='form-control' onchange='checkQuantity(this.id)' name='rejection["+i+"][panelno]' required="+req+" min='0' id='rejection["+i+"][panelno]'>");
			tr.append(td1, td2, td3, td4);
			$("#tablebody").append(tr);
		}
		var reasons = results;
		$('.select2').select2({
			placeholder: 'Select a Reason',
			data:reasons
		});
	}	

	getReasons();


});
function checkQuantity(id){
	var noreasons = $("#reason").val();
	var bad = $("#bad").val()?$("#bad").val():0;
	var missing = $("#missing").val()?$("#missing").val():0;
	var totqty = 0;	
	$('#submit').show();	
	$('input[id^="rejection"]').each(function() {
	    if($(this).val()){
	    	totqty = parseInt(totqty)+parseInt($(this).val());
	    }
	});	
	var rejqty = parseInt(bad)+parseInt(missing);
	if(totqty > rejqty){
		alert("Cumilative quantities are greatter/lesser than Rejected/Missing Quantity. Please try again!!!");
		$('#submit').hide();
	}

	if(totqty < rejqty){
		$('#submit').hide();
	}
}



function checkReason(id){
	var noreasons = $("#reason").val();
}

</script>
