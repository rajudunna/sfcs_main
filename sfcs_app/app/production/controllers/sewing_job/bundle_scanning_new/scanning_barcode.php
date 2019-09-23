<?php
    include(getFullURLLevel($_GET['r'],'common/config/config.php',5,'R'));
    include(getFullURLLevel($_GET['r'],'common/config/functions.php',5,'R'));
    $module = $_POST['Module'];
    $shift = $_POST['shift'];
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
    padding: 5px 15px;
    font-family: sans-serif, Arial;
    font-size: 16px;
    border: 0px solid #444;
    border-radius: 14px;
    width: auto !important;
}
 

.radio-toolbar label:hover,.radio-toolbar label:focus,.radio-toolbar label:active {
  padding: 15px 15px !important;
  cursor : pointer;
}
.radio-toolbar input[type="radio"]:checked + label 
{
  padding: 15px 15px !important;
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
.radio-toolbar1 input[type="radio"]:checked + label 
{
  padding: 15px 15px !important;
}
.radio-toolbar1 label
{
    color: whitesmoke;
    display: inline-block;
    background-color: #ddd;
    padding: 5px 15px !important;
    font-family: sans-serif, Arial;
    font-size: 16px;
    border: 0px solid #444;
    border-radius: 14px;
   
}

.radio-toolbar1 input[type="radio"] {
  opacity: 0;
  position: fixed;
  width: 0;
}
.ng-binding{
  max-height: 90px;
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
  padding: 15px 20px;
}

.radio-toolbar1 input[type="radio"]:focus + label {
    border: 2px dashed #444;
}

.radio-toolbar1 input[type="radio"]:checked + label {
    background-color: #bfb;
    border-color: #d81414;
}
.btn-group-sm>.btn, .btn-sm {
    padding: px 21px;
    font-size: 12px;
    line-height: 1.1;
    text-align: left;
}
.form-control {
    display: block;
    width: 100%;
    height: 32px;
}
#txmode{
  padding-left:4px;
}
#txmode:hover,#time:hover{
  border-color:unset;
  border:1px solid #169F85;
  background: #26B99A;
  cursor: auto;
}
#timered:hover{ 
  border-color:#d43f3a;
  background-color: #d9534f;
  border:1px solid #d43f3a;
  cursor: auto;
}
#timeyellow:hover{ 
  border-color:#eea236;
  background-color: #f0ad4e;
  border:1px solid #eea236;
  cursor: auto;
}

#loading-image{
  position:fixed;
  top:0px;
  right:0px;
  width:100%;
  height:100%;
  background-color:black;
  /* background-image:url('ajax-loader.gif'); */
  background-repeat:no-repeat;
  background-position:center;
  z-index:10000000;
  opacity: 0.4;
  filter: alpha(opacity=40); /* For IE8 and earlier */
}
</style>
<div class="ajax-loader" id="loading-image" style="display: none">
    <center><img src='<?= getFullURLLevel($_GET['r'],'ajax-loader.gif',0,'R'); ?>' class="img-responsive" style="padding-top: 250px"/></center>
</div>
<body class="nav-md" style="color: #f6faff;">
<div class="panel panel-primary" id="scanned_barcode" ng-app="scanning_interface_new">
    <div class="panel-heading">Bundle Scanning</div>
    <div class="panel-body" style="background-color: black;" ng-controller="scancode_ctrl">
       <table border=0;> 
       <tr>
        <td><label>Style : </label><br/><br/><label>Color : </label></td>
        <td style="padding: 0px 0px 0px 23px;"><input type="text" style="max-width: 150px;" class="form-control" name="style" ng-model="style" ng-readonly="true"><br/><br/>
       <input type="text" style="max-width: 150px;" class="form-control" name="color" ng-model="color" ng-readonly="true"></td>
       <td style="width: 10 5px;"></td>
        <td><div class="container" style="width: 570px;">
        <div class="panel panel-basic" style="background-color: #2e2d2c;border: 1px solid;border-radius: 15px;">
         <div class="panel-heading">
                <div class="row">
                <div class="btn btn-sm btn-success"  id="txmode" style="width: 160px;padding: 6px 0px 6px 0px;" >Barcode: {{barcode_value}}</div>
                <div class="btn btn-sm btn-success" id="txmode" style="width: 107px;">Action: {{action_mode | uppercase }}</div>
                <div class="btn btn-sm btn-success" id="txmode" style="width: 118px;">Tx Mode: {{trans_mode | uppercase }}</div>
                <div class="btn btn-sm btn-success" id="txmode">Bundle Qty: <input type="text"  style="max-width: 50px;" class="form-control" ng-model="bundle_qty" name="bundle_qty" id="bundle_qty" ng-readonly="true"></div>
                </div>
                </div>
                <div class="panel-body"> 
                <div class="row">
                <div class="col-sm-4 col-md-4 col-xs-4"><center><b>Scanned Status </b></center></br><div class="ng-binding"  style="border: 1px solid;border-radius: 15px;padding: 9px;background-color:{{color_cod}}; height:90px"> {{scanned_status}}</div></div>
                <div class="col-sm-8 col-md-8 col-xs-8 table-responsive" style="font-size: 13px;">
                
                <table class="table">
    <thead>
      <tr >
      <div colspan="4"><center><b>Scanned Count</b></center></br></div>
      </tr>
    </thead>
    <tbody >
     <tr>
     <div>
        <div class="col-sm-3" style="padding: 3px 15px 3px 66px;width:44%">previous hr: </div>
        <div id="time" class="btn btn-sm btn-success" style="width:50px;">00</div>
        <div id="timered" class="btn btn-sm btn-danger" style="width:50px;"> 00</div>
        <div id="timeyellow" class="btn btn-sm btn-warning" style="width:50px;">00</div>
      <div>
      </tr>
      <tr>
      <div>
        <div class="col-sm-3" style="padding: 3px 15px 3px 66px;width:44%">current hr:</div>
        <div id="time" class="btn btn-sm btn-success" style="width:50px;">00</div>
        <div id="timered" class="btn btn-sm btn-danger" style="width:50px;"> 00</div>
        <div id="timeyellow" class="btn btn-sm btn-warning" style="width:50px;">00</div>
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
        <td width="90"><label>Bar code :</label></td>
        <td style="padding: 0px 0px 0px 23px;"><input type="text" style="max-width: 275px;"  class="form-control" ng-model="barcode_value" ng-keypress="scanned($event)" id="barcode_value" onkeyup="validateQty(event,this);" placeholder="scan barcode here" autofocus></td>
        <input type="hidden" id="module" ng-model="module" ng-init="module='<?= $module; ?>'">
        <input type="hidden" id="shift" ng-model="shift" ng-init="shift='<?= $shift; ?>'">
        <input type="hidden" id="op_code" ng-model="op_code" ng-init="op_code='<?= $op_code; ?>'">
        <input type="hidden" id="changed_rej" name="changed_rej">
        <input type="hidden" id="rej_data" ng-model="rej_data">
        <input type="hidden" ng-model="url" ng-init="url='/<?= getFullURLLevel($_GET['r'],'get_newbarcode_details.php',0,'R') ?>'">
        </tr>
        <tr>
        <td><label>Tx Mode:</label></td>
        <td>
            <div class="radio-toolbar" ng-init="trans_mode='good'" style="width: 300px;padding: 8px 6px 8px 17px;
            background-color: #2e2d2c;border-radius: 20px">
            <input type="radio" id="radiogood" name="trans_mode" ng-model='trans_mode' ng-value='"good"'>
            <label for="radiogood" style="border: 2px solid;border-color: #9d9a9a;background-color: #45b645;width:90px;">Good</label> &nbsp;
            <input type="radio" id="radioscrap" name="trans_mode" ng-model='trans_mode' ng-value='"scrap"'>
            <label for="radioscrap" style="border: 2px solid;border-color: #9d9a9a;background-color: #f31c06;width:90px;" class="btn btn-primary" data-toggle="modal" focus-element="autofocus" data-target=".bs-example-modal-lg">Scrap</label>
            <input type="radio" id="radiorework" name="trans_mode" ng-model='trans_mode' ng-value='"rework"'>
            <label for="radiorework" style="border: 2px solid;border-color: #7979a5;background-color: #714f1b;width:90px;">Rework</label>
            
            <!--<input type="radio" id="radiogudscrap" name="trans_mode" ng-model='trans_mode' ng-value='"gudscrap"'>
            <label for="radiogudscrap" style="background-color: #a5980df5;" class="btn btn-primary" data-toggle="modal" focus-element="autofocus" data-target=".bs-example-modal-lg">Good&Scrap</label>--> 
            </div>
        </td>
        <td style="width: 10 5px;"></td>
        <td><div class="container" style="width: 570px;">
        <div class="panel panel-basic" style="border: 1px solid;border-radius: 11px;">
         <div class="panel-heading" style="font-size: large;background-color: #2e2d2c;border: 1px solid;border-radius: 11px;">
                <div class="row">
                <div class="col-sm-6 col-md-6 col-xs-6">PO: {{vpo}}</div>
                <div class="col-sm-6 col-md-6 col-xs-6">Size: {{size_title}}</div>
                <div class="panel-body">  </div>
                <div class="row"> </div>
                <div class="col-sm-6 col-md-6 col-xs-6" > Z feature: {{zfeature}}</div>
                <div class="col-sm-6 col-md-6 col-xs-6">Schedule: {{schedule}}</div>
                 </div>
         </div>
         </td>
        </tr>
        </br></br></br>
        <tr>
        <td><span><label>Action :</label></span></td>
        <td>
            <div class="radio-toolbar1" ng-init="action_mode='add'"style="width: 220px;padding: 10px 18px 4px 25px;
            background-color: #2e2d2c;border-radius: 20px;">
                <input type="radio" id="radioadd" name="action_mode" ng-model='action_mode' ng-value='"add"'>
                <label for="radioadd" style="border: 2px solid;border-color: #7979a5;background-color: #2396c5;width: 80px;" class="btn btn-info"  ng-click="barcode_submit('add');" >Add</label>
                <input type="radio" id="radioreverse" name="action_mode" ng-model='action_mode' ng-value='"reverse"'>
                <label for="radioreverse" style="border: 2px solid;border-color: #7979a5;background-color: #2355c5;width: 80px;padding-left: 7px !important;" class="btn btn-info"  ng-click="barcode_submit('reverse');">Reverse</label>
            </div>
            <!--<div>
            <button type="button" style="height: 80px;width: 76px;."  class="btn btn-info"  ng-click="barcode_submit('add');">Add</button>
            <button type="button" style="height: 80px;" class="btn btn-info" ng-click="barcode_submit('reverse');">Reverse</button>
            <button type="button" style="height: 80px;width: 76px;" class="btn btn-info">Reset</button>
            </div>-->
        </td>
        <td style="width: 125px;"></td>
        <td><div class="container" style="width: 570px;">
        <div class="panel panel-basic" style="border: 1px solid;border-radius: 15px;">
         <div class="panel-heading" style="font-size: large;background-color: #2e2d2c;border: 1px solid;border-radius: 15px;">
                <div class="row">
                <div class="col-sm-9 col-md-9 col-xs-9">Factory : {{global_facility_code}}</div>
                <!-- <div class="panel-heading"></div>
                <div class="row"></div> -->
                <div class="panel-heading"></div>
                <div class="row"></div>
                <div class="panel-heading"></div>
                <div class="row"></div>
                <div class="col-sm-7 col-md-7 col-xs-7">Team: {{module}}</div>
                <button type="button" style="height: 35px;width:70px;" class="btn btn-info">Reset</button>
                <div class="col-sm-7 col-md-7 col-xs-7">Operation :{{operation_name}}</div>
                <div class="col-sm-5  ">Count</div>
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

 

