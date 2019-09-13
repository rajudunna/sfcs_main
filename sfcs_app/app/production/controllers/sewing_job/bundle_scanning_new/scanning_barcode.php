<?php
    include(getFullURLLevel($_GET['r'],'common/config/config.php',5,'R'));
    include(getFullURLLevel($_GET['r'],'common/config/functions.php',5,'R'));
    $module = $_POST['Module'];
    $op_code=$_POST['operation_code'];
    //To Get Sewing Operations
	$category = 'sewing';
	$get_operations = "select operation_code from $brandix_bts.tbl_orders_ops_ref where category='$category'";
	//echo $get_operations;
	$operations_result_out=mysqli_query($link, $get_operations)or exit("get_operations_error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row_out=mysqli_fetch_array($operations_result_out))
	{
		$sewing_operations[]=$sql_row_out['operation_code'];
	}

	//echo $operation_code;
	if(in_array($operation_code,$sewing_operations))
	{
	$form = "'G','P'";
	}else
	{
		$form = "'P'";
	}
$qery_rejection_resons = "select * from $bai_pro3.bai_qms_rejection_reason where form_type in ($form)";
$result_rejections = $link->query($qery_rejection_resons);
?>
<style>
.radio-toolbar {
  margin: 10px;
}

.radio-toolbar input[type="radio"] {
  opacity: 0;
  position: fixed;
  width: 0;
}

.radio-toolbar label {
    color: whitesmoke;
    display: inline-block;
    background-color: #ddd;
    padding: 18px 13px;
    font-family: sans-serif, Arial;
    font-size: 16px;
    border: 2px solid #444;
    border-radius: 14px;
}

.radio-toolbar label:hover {
  background-color: #dfd;
}

.radio-toolbar input[type="radio"]:focus + label {
    border: 2px dashed #444;
}

.radio-toolbar input[type="radio"]:checked + label {
    background-color: #bfb;
    border-color: #4c4;
}

.radio-toolbar1 {
  margin: 10px;
}

.radio-toolbar1 input[type="radio"] {
  opacity: 0;
  position: fixed;
  width: 0;
}

.radio-toolbar1 label {
    color: whitesmoke;
    display: inline-block;
    background-color: #ddd;
    padding: 18px 13px;
    font-family: sans-serif, Arial;
    font-size: 16px;
    border: 2px solid #444;
    border-radius: 14px;
}

.radio-toolbar1 label:hover {
  background-color: #dfd;
}

.radio-toolbar1 input[type="radio"]:focus + label {
    border: 2px dashed #444;
}

.radio-toolbar1 input[type="radio"]:checked + label {
    background-color: #bfb;
    border-color: #d81414;
}
</style>
<div class="panel panel-primary" id="scanned_barcode" ng-app="scanning_interface_new">
    <div class="panel-heading">Bundle Scanning</div>
    <div class="panel-body" style="background-color: darkslategray;" ng-controller="scancode_ctrl">
       <table border=0;> 
       <tr>
        <td><label>Style : </label><br/><br/><label>Color : </label></td>
        <td><input type="text" style="max-width: 150px;" class="form-control" name="style" ng-model="style" ng-readonly="true"><br/><br/>
       <input type="text" style="max-width: 150px;" class="form-control" name="color" ng-model="color" ng-readonly="true"></td>
       <td style="width: 10 5px;"></td>
        <td><div class="container" style="width: 570px;">
        <div class="panel panel-basic">
         <div class="panel-heading">
                <div class="row">
                <div class="col-sm-3 col-md-3 col-xs-3">Barcode: {{barcode_value}}</div>
                <div class="col-sm-3 col-md-3 col-xs-3">Action: {{action_mode | uppercase }}</div>
                <div class="col-sm-3 col-md-3 col-xs-3">Tx Mode: {{trans_mode | uppercase }}</div>
                <div class="col-sm-3 col-md-3 col-xs-3">Tot Qty: <input type="text"  style="max-width: 70px;" class="form-control" ng-model="changed_rej" name="changed_rej" id="changed_rej" ng-readonly="true"></div>
                </div>
                </div>
                <div class="panel-body"> 
                <div class="row">
                <div class="col-sm-4 col-md-4 col-xs-4">Scanned Status:  {{scanned_status}}</div>
                <div class="col-sm-8 col-md-8 col-xs-8 table-responsive">
                
                <table class="table ">
    <thead>
      <tr >
      <div colspan="4"><center>Scanned Count</center></div>
      </tr>
    </thead>
    <tbody>
      <tr>
      <div>
        <div class="col-sm-3">previous hr: </div>
        <div class="btn btn-sm btn-success">00</div>
        <div class="btn btn-sm btn-danger"> 00</div>
        <div class="btn btn-sm btn-warning">00</div>
      <div>
      </tr>
      <tr>
      <div>
        <div class="col-sm-3">current hr:</div>
        <div class="btn btn-sm btn-success">00</div>
        <div class="btn btn-sm btn-danger"> 00</div>
        <div class="btn btn-sm btn-warning">00</div>
      </tr>
      </div>
    </tbody>
  </table>
                
                </div>
                </div>
                </div>
                </div>
            </div>
        </td>
        </tr>
        <td><label>Bar code :</label></td>
        <td><input type="text" style="max-width: 250px;"  class="form-control" ng-model="barcode_value" ng-keypress="scanned($event)" id="barcode_value" onkeyup="validateQty(event,this);" placeholder="scan barcode here" autofocus></td>
        <input type="hidden" id="module" ng-model="module" ng-init="module='<?= $module; ?>'">
        <input type="hidden" id="op_code" ng-model="op_code" ng-init="op_code='<?= $op_code; ?>'">
        <input type="hidden" ng-model="url" ng-init="url='/<?= getFullURLLevel($_GET['r'],'get_newbarcode_details.php',0,'R') ?>'"> 
        <tr>
        <td><label>Tx Mode:</label></td>
        <td>
            <div class="radio-toolbar" ng-init="trans_mode='good'">
            <input type="radio" id="radiogood" name="trans_mode" ng-model='trans_mode' ng-value='"good"'>
            <label for="radiogood" style="background-color: #256325;">Good</label>
            <input type="radio" id="radioscrap" name="trans_mode" ng-model='trans_mode' ng-value='"scrap"'>
            <label for="radioscrap" style="background-color: #f31c06;" class="btn btn-primary" data-toggle="modal" focus-element="autofocus" data-target=".bs-example-modal-lg">Scrap</label>
            <input type="radio" id="radiorework" name="trans_mode" ng-model='trans_mode' ng-value='"rework"'>
            <label for="radiorework" style="background-color: #714f1b;">Rework</label>
            
            <!--<input type="radio" id="radiogudscrap" name="trans_mode" ng-model='trans_mode' ng-value='"gudscrap"'>
            <label for="radiogudscrap" style="background-color: #a5980df5;" class="btn btn-primary" data-toggle="modal" focus-element="autofocus" data-target=".bs-example-modal-lg">Good&Scrap</label>--> 
            </div>
        </td>
        <td style="width: 10 5px;"></td>
        <td><div class="container" style="width: 570px;">
        <div class="panel panel-basic">
         <div class="panel-heading">
                <div class="row">
                <div class="col-sm-3 col-md-3 col-xs-3">PO: {{vpo}}</div>
                <div class="col-sm-3 col-md-3 col-xs-3"></div>
                <div class="col-sm-3 col-md-3 col-xs-3"></div>
                <div class="col-sm-3 col-md-3 col-xs-3">Size: {{size_title}}</div>
                <div class="panel-body">  </div>
                <div class="row"> </div>
                <div class="col-sm-3 col-md-3 col-xs-3" > Z feature: {{zfeature}}</div>
                <div class="col-sm-3 col-md-3 col-xs-3"></div>
                <div class="col-sm-3 col-md-3 col-xs-3"></div>
                <div class="col-sm-3 col-md-3 col-xs-3">Schedule: {{schedule}}</div>
                <div class="panel-body">  </div>
                <div class="row"> </div>
                <div class="col-sm-6 col-md-6 col-xs-6">Color : {{color}}</div>
                </div>
                 </div>
         </div>
         </td>
        </tr>
        </br></br></br>
        <tr>
        <td><span>Action :</span></td>
        <td style="width: 323px;">
            <div class="radio-toolbar1" ng-init="action_mode='add'">
                <input type="radio" id="radioadd" name="action_mode" ng-model='action_mode' ng-value='"add"'>
                <label for="radioadd" style="background-color: #2396c5;">Add</label>
                <input type="radio" id="radioreverse" name="action_mode" ng-model='action_mode' ng-value='"reverse"'>
                <label for="radioreverse" style="background-color: #2396c5;">Reverse</label>
            </div>
            <!--<div>
            <button type="button" style="height: 80px;width: 76px;."  class="btn btn-info"  ng-click="barcode_submit('add');">Add</button>
            <button type="button" style="height: 80px;" class="btn btn-info" ng-click="barcode_submit('reverse');">Reverse</button>
            <button type="button" style="height: 80px;width: 76px;" class="btn btn-info">Reset</button>
            </div>-->
        </td>
        <td style="width: 125px;"></td>
        <td><div class="container" style="width: 570px;">
        <div class="panel panel-basic">
         <div class="panel-heading">
                <div class="row">
                <div class="col-sm-3 col-md-3 col-xs-3">Factory : {{global_facility_code}}</div>
                <div class="panel-heading"></div>
                <div class="row"></div>
                <div class="panel-heading"></div>
                <div class="row"></div>
                <div class="panel-heading"></div>
                <div class="row"></div>
                <div class="col-sm-8 col-md-8 col-xs-8">Team: {{module}}</div>
                <button type="button" style="height: 60px;width:100px;" class="btn btn-info">Reset</button>
                <div class="col-sm-8 col-md-8 col-xs-8">Operation :{{operation_name}}</div>
                <div class="col-sm-3  ">Count</div>
                </div>
            </div>
        </td>
        </tr>
        <!--<tr>
        <td><label> Scrap Reason: </label></td>
        <td><input type="text" style="max-width: 250px;"  class="form-control" name="Scrap Reason"></td>
        <td></td>
        <td></td>
        </tr>-->
        </table>
        <!-- Large modal -->
        <div class="modal fade bs-example-modal-lg"  id="myModal" focus-group focus-group-head="loop" focus-group-tail="loop" focus-stacktabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
              <div class="modal-dialog">
              <div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close"  id = "cancel" data-dismiss="modal" onclick='neglecting_function()'>&times;</button>
						<div class="form-group" id="rej">
						<input type="hidden" value="" id="reject_reasons_count">
                        	<div class="panel panel-primary"> 
				            	<div class="panel-heading"><strong>Rejection Reasons</strong></div>				            	
				                <div class="panel-body">
						           	<div class="form-group col-md-4" id="res">
			                            <label>No of Reasons:</label>
					                	<input type="text" onkeyup="validateQty1(event,this);" name="no_reason" min=0 id="reason" class="form-control"  onchange="validating_with_qty()" onfocus='if($(this).val() == 0){$(this).val(``)}' onfocusout='if($(this).val() > 0){}else{$(this).val(0)}' placeholder="Enter no of reasons"/>
					                </div>
		                            <table class="table table-bordered" id='reson_dynamic_table' width="100" style="height: 50px; overflow-y: scroll;">
		                            	<thead>
		                            		<tr>
		                            			<th style="width: 7%;">S.No</th>	                            			
		                            			<th>Reason</th>
		                            			<th style="width: 20%;">Quantity</th>
		                            		</tr>
		                            	</thead>
		                            	<tbody id="tablebody">
										</tbody>
											<tr id='repeat_tr' hidden='true'>
												<td>
												<select id="reason_drop" class="form-control" id="style" name="reason[]">
													<option value=''>Select Reason</option>
													<?php				    	
														if ($result_rejections->num_rows > 0) {
															while($row = $result_rejections->fetch_assoc()) {
																echo "<option value='".$row['sno']."'>".$row['form_type']."-".$row['reason_desc']."</option>";
															}
														} else {
															echo "<option value=''>No Data Found..</option>";
														}
													?>
												</select>
												</td>
												<td><input type='text' class='form-control input-sm' id='quantity'  name='quantity[]' onkeyup='validateQty1(event,this);' onchange='validating_cumulative(event,this)'></td>
											</tr>
		                            </table>
		                        </div>
								 <div class="panel-footer" hidden='true' id='footer'>
									<input type = 'button' id="rejec_reasons" class='btn btn-primary' value='Ok..Proceed' name='Save'>
								 </div>
                            </div>
                        </div>
						</div>
						<div class="modal-body">
						</div>
					</div>
                </div>
              </div>
        </div>  
    </div>
</div>

<script src="<?= getFullURLLevel($_GET['r'],'common/js/new_scan_barcode.js',3,'R') ?>"></script>

 

