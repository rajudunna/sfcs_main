<?php 
    include(getFullURLLevel($_GET['r'],'common/config/config.php',5,'R'));
    include(getFullURLLevel($_GET['r'],'common/config/functions.php',5,'R'));
	$shift = $_POST['shift'];
	$op_code=$_POST['operation_code'];
	$gate_id=$_POST['gate_id'];	
	if($gate_id=='')
	{
		$gate_id=0;
	}
	//echo $gate_id."--".$op_code."--".$shift."<br>";
    // $has_permission=haspermission($_GET['r']);
    // if (in_array($override_sewing_limitation,$has_permission))
    // {
        $value = 'authorized';
    // } 
    // else
    // {
    //     $value = 'not_authorized';
    // }
	$url1 = getFullURLLEVEL($_GET['r'],'gatepass_summery_detail.php',2,'N');
	
	
 //To Get Emblishment Operations
	$category =['Send PF','Receive PF'];
	$get_operations = "select operation_code from $brandix_bts.tbl_orders_ops_ref where category IN ('".implode("','",$category)."')";
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
#loading-image{
  position:fixed;
  top:0px;
  right:0px;
  width:100%;
  height:100%;
  background-color:#666;
  /* background-image:url('ajax-loader.gif'); */
  background-repeat:no-repeat;
  background-position:center;
  z-index:10000000;
  opacity: 0.4;
  filter: alpha(opacity=40); /* For IE8 and earlier */
}
th,td{
    color: black;
}
</style>
<div class="ajax-loader" id="loading-image" style="display: none">
    <center><img src='<?= getFullURLLevel($_GET['r'],'ajax-loader.gif',0,'R'); ?>' class="img-responsive" style="padding-top: 250px"/></center>
</div>
<div class="panel panel-primary " id="scanBarcode" ng-app="scanning_interface" ng-cloak>
    <?php if($op_code)
    {?>
        <div class="panel-heading" >Bundle Barcode Scanning Without Operation</div>
    <?php }else
    {?>
       <div class="panel-heading" >Emblishment Scanning</div>
	   <span style="color: red;font-size: 22px;"><b>Note:If you have rejections Please enter rejected quantity before scan the barcode</b></span>
    <?php }?>
    <div class="panel-body"  ng-controller="scanctrl">
        <div class="row jumbotron " ng-init="shift='<?= $shift ?>'">
	
            <div class="col-md-5">
			    <?php if($op_code)
				{?>
					<div class="col-padding" ng-init="op_code='<?= $op_code ?>'">
				<?php }else
				{?>
					<div class="col-padding">
				<?php }?>
				<div class="col-md-3" data-toggle="modal" data-target=".bs-example-modal-lg">
					Rej Qty:<input type="text" id="rej_id" class="form-control" ng-model="rej_id" ng-init="rej_id ='0'" readonly>
				</div>
				<div class="col-md-9">				
                    Barcode:<input type="text" id="barcode_scan" class="form-control input-lg" ng-model="barcode" ng-keypress="scanned($event)" placeholder="scan here" autofocus>
				</div>
					<input type="hidden" id="pass_id" ng-model="pass_id" ng-init="pass_id='<?= $gate_id; ?>'">
					<input type="hidden" id="rej_data" ng-model="rej_data">
                    <input type="hidden" id="has_permission" ng-model="has_permission" ng-init="has_permission='<?= htmlspecialchars(json_encode($has_permission)) ?>'">
                    <input type="hidden" id="user_permission" ng-model="user_permission" ng-init="user_permission='<?= $value; ?>'">
                    <input type="hidden" class="form-control" ng-model="url" ng-init="url='/<?= getFullURLLevel($_GET['r'],'emb_get_barcode_details_new.php',0,'R') ?>'">
					<?php
					if($gate_id>0)
					{
						?>
						<div class="col-sm-2 form-group" style="padding-top:20px;">
						<form method ='POST' id='frm1' action='<?php echo $url ?>'>
						<?php
							echo "<a class='btn btn-warning' href='$url1&gatepassid=".$gate_id."&status=2' >Finish</a>";
						?>
						</form>
						</div> 
						<br>					
						<?php
					}
					?>					
                </div>
            </div>
			
            <div class="vline"></div>
            <div class="col-md-5 pull-right">
                <div class="col-padding table-responsive" >
                    <table class="table table-bordered bgcolortable" ng-show="showtable == true">
                        <thead>
                            <tr>
                                <th width="30%">Last Scan</th>
                                <th width="30%" >{{last_barcode}}</th>
                            </tr>
                            <tr>
                                <th width="30%">Status</th>
                                <td width="30%">{{last_barcode_status}}</td>
                            </tr>
                            <tr>
                                <th width="30%">Status Remarks</th>
                                <th width="30%">{{last_barcode_status_remarks}}</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
        <hr>
        <div class="col-md-12 table-responsive" style="height: 280px" ng-show="showscanlist== true">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>S.no</th>
                        <th>Doc No</th>
                        <th>Operation Code</th>
                        <th>Bundle Number</th>
                        <th>Style</th>
                        <th>Schedule</th>
                        <th>Color</th>
                        <th>Size</th>
                        <th>Reported Good Qty</th>
						<th>Reject Qty</th>
                        <th>Remarks</th>
                    </tr>
                </thead>
                <tbody>
                    <tr ng-repeat="bar_code_details in scanned_barcode_details | orderBy:'date_n':true">
                        <td ng-hide="true">{{scanned_barcode_details.length-1}}</td>
						<td>{{$index+1}}</td>
                        <td>{{bar_code_details.data.bundle_no}}</td>
                        <td>{{bar_code_details.data.op_no}}</td>
                        <td>{{bar_code_details.data.bunno}}</td>
                        <td>{{bar_code_details.data.style}}</td>
                        <td>{{bar_code_details.data.schedule}}</td>
                        <td>{{bar_code_details.data.color_dis}}</td>
                        <td>{{bar_code_details.data.size}}</td>
                        <td>{{bar_code_details.data.reported_qty}}</td>
                        <td>{{bar_code_details.data.rejected_qty}}</td>
                        <td>All partial/full qty updated as good qty. </td>
                    </tr>
                </tbody>
            </table>
        </div>
		
		<div class="modal fade bs-example-modal-lg"  id="myModal" focus-group focus-group-head="loop" focus-group-tail="loop" focus-stacktabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
              <div class="modal-dialog">
              <div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close"  id = "cancel" data-dismiss="modal" onclick='neglecting_function()'>&times;</button>
					    	<div class="form-group" id="rej">
					        	<input type="hidden" value="" id="reject_reasons_count">
                      	<div class="panel panel-primary"> 
				                  	<div class="panel-heading"><strong>Rejection Reasons</strong></div>				            	
				                       <div class="panel-body" style="color: black;">
						                     	<div class="form-group col-md-4" id="res">
			                                 <label>No of Reasons : </label>
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
<script src="<?= getFullURLLevel($_GET['r'],'common/js/emb_scan_barcode.js',3,'R') ?>"></script>
<script>
function gatepass_page(i)
{
	//window.location = $url&?gatepassid=".$gate_id.""; 
}
</script>
