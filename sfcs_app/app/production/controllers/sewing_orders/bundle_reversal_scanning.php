<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta http-equiv="X-UA-Compatible" content="IE=9; IE=8; IE=7; IE=6; IE=5; IE=EDGE" />
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
            <span class="pull-right">(<span style="color:red;">*</span>) fields are mandatory</span>			
			<div class="panel panel-primary"> 
            	<div class="panel-heading"><strong>Scan a Bundle -- Reversal operation</strong></div>
                <div class="panel-body">
                    <form action="apicalls.php" method="POST" id="panelform">
                        <div class="form-group col-md-2">
                            <label>Bundle Number:<span style="color:red">*</span></label>
                        	<input type="text" name="bundlenumber"  id="bundlenumber" class="form-control" required placeholder="Scan the bundle..."/>
                        </div>
                        <div class="form-group col-md-4" id="opr">
                            <label>Operation:(Original Qty : <span id="original_qty"></span> , Send Qty : <span id="sen_qty"></span>, Rec Qty : <span id="rec_qty"></span>)<span style="color:red">*</span></label>
                            <select class="form-control select2" required name="operation" id="operation" style="width:100%;">
                        		<option value="">Select Operation</option>
                        	</select>
                            <input type="hidden"  name="send_qty" id="send_qty" class="form-control" required />
                            <input type="hidden"  name="operationid" id="operationid" class="form-control" required />
                            <input type="hidden"  name="recd_qty" id="recd_qty" class="form-control" required />
                        </div>
                        <!-- <div class="form-group col-md-4">
                        	<label>Shift:<span style="color:red">*</span></label>
                        	<select class="form-control shift" required name="shift" id="shift" style="width:100%;">
                        		<option value="">Select Shift</option>
                        		<option value="A">A</option>
                        		<option value="B">B</option>
                        	</select>
                        </div>
                        <div class="form-group" id="gd">
                        	<div class="col-md-4">
                        		<label>Good:<span style="color:red">*</span></label>
                            	<input type="number" name="good" required min=0 id="good" class="form-control"/>
                        	</div>
                        	<div class="col-md-4" id="bd">
                        		 <label>Rejected:</label>
                            	<input type="number" name="bad"  min=0 id="bad" class="form-control"/>
                        	</div>
                        	<div class="col-md-4" id="mis">
                        		<label>Missing:</label>
                        		<input type="number" name="missing" min=0 id="missing" class="form-control"/>
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
                        </div>-->
                        <div class="form-group col-md-3">
	                        <input type="hidden" name="submit" value="submit"/><br/>
	                        <button type="submit" class="btn btn-primary" id="submit">Un-Scan</button>
	                    </div>
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
$(document).ready(function() {
	var res = [];
	$('#operation').select2();
    $('#loading-image').hide();
    $("#bundlenumber").change(function(){
    	$('#loading-image').show();
    	var bundlenumber = $("#bundlenumber").val();
    	if(bundlenumber != ''){
		    var pattern = /^[0-9]*-[0-9]*$/g;
		    var result = bundlenumber.match(pattern);
		    if(result){
		    	var val = result[0].substr(result[0].indexOf("-") + 1);
		    	if(val){
		    		$.ajax({
					    type: "get",
					    url: "apicalls.php?bundlenumber="+bundlenumber,
					    dataType: "json",
					    success: function (data) {	
					   	 	$('#loading-image').hide();
					    	if(data.length>0){
					    		res = data;
					    		$.each(data, function(key,value) {
									$('select[name="operation"]').append('<option value="'+ value['operation_id'] +'">'+value['operation_name']+'</option>');
								});		    					
					    	}
		    								    			              
					    }				    
					});	
				}else{
					alert("Please scan valid Bundle number");
		    		$("#bundlenumber").val("");
		    		$('#loading-image').hide();
				}		    	
		    }else{
		    	alert("Please scan valid Bundle number");
		    	$("#bundlenumber").val("");
		    	$('#loading-image').hide();
		    }
    	}    		
    });
	
	$("#operation").change(function(){
		var bundlenumber = $("#bundlenumber").val();
    	var operation_id = $("#operation").val();

    	$.ajax({
		    type: "get",
		    url: "apicalls.php?bundlenumber1="+bundlenumber+"&operation="+operation_id,
		    dataType: "json",
		    success: function (data) {
		   	 	$('#loading-image').hide();
		   	 	if(data['status'] == 0){
		   	 		for(var i=0;i<res.length;i++){
			    		if(operation_id == res[i]['operation_id']){
			    			$("#operationid").val(res[i]['operation_id']);				    		
				    		$("#good").val(res[i]['send_qty']);
				    		$("#send_qty").val(res[i]['send_qty']);
				    		$("#recd_qty").val(res[i]['recevied_qty']);
				    		$("#sen_qty").html(res[i]['send_qty']);
				    		$("#rec_qty").html(res[i]['recevied_qty']);
				    		$("#original_qty").html(res[i]['original_qty']);
			    		}
			    	}
		   	 	}else{
		   	 		alert(data['status']);
		   	 		$("#operation").empty().append('<option value="">Select Operation</option>').val('').trigger('change');
		   	 	}
		   	 	    			              
		    }				    
		});	
    });

});
</script>
