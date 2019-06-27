<?php 
    include(getFullURLLevel($_GET['r'],'common/config/config.php',5,'R'));
    include(getFullURLLevel($_GET['r'],'common/config/functions.php',5,'R'));
	if($_GET['shift']<>'')
	{
		$shift = $_GET['shift'];
		$op_code=$_GET['opertion'];
		$gate_id=$_GET['id'];
	}
	else
	{
		$shift = $_POST['shift'];
		$op_code=$_POST['operation_code'];
		$gate_id=0;
	}
    $has_permission=haspermission($_GET['r']);
    if (in_array($override_sewing_limitation,$has_permission))
    {
        $value = 'authorized';
    }
    else
    {
        $value = 'not_authorized';
    }
	$url = getFullURLLEVEL($_GET['r'],'gatepass_summery_detail.php',0,'N');
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
       <div class="panel-heading" >Bundle Barcode Scanning</div>
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
                    <input type="text" id="barcode_scan" class="form-control input-lg" ng-model="barcode" ng-keypress="scanned($event)" placeholder="scan here" autofocus>
					<input type="hidden" id="pass_id" ng-model="pass_id" ng-init="pass_id='<?= $gate_id; ?>'">
                    <input type="hidden" id="user_permission" ng-model="user_permission" ng-init="user_permission='<?= $value; ?>'">
                    <input type="hidden" class="form-control" ng-model="url" ng-init="url='/<?= getFullURLLevel($_GET['r'],'get_barcode_details_new.php',0,'R') ?>'">
					<?php
					if($gate_id>0)
					{
						?>
						<div class="col-sm-2 form-group" style="padding-top:20px;">
						<form method ='POST' id='frm1' action='<?php echo $url ?>'>
						<?php
						
						  echo "<input class='btn btn-warning' type=\"submit\" value=\"Finish\">";
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
                        <th>Bundle Number</th>
                        <th>Operation Code</th>
                        <th>Style</th>
                        <th>Schedule</th>
                        <th>Color</th>
                        <th>Size</th>
                        <th>Reported Good Qty</th>
                        <th>Remarks</th>
                    </tr>
                </thead>
                <tbody>
                    <tr ng-repeat="bar_code_details in scanned_barcode_details.reverse()">
                        <td>{{$index+1}}</td>
                        <td>{{bar_code_details.data.bundle_no}}</td>
                        <td>{{bar_code_details.data.op_no}}</td>
                        <td>{{bar_code_details.data.style}}</td>
                        <td>{{bar_code_details.data.schedule}}</td>
                        <td>{{bar_code_details.data.color_dis}}</td>
                        <td>{{bar_code_details.data.size}}</td>
                        <td>{{bar_code_details.data.reported_qty}}</td>
                        <td>All partial/full qty updated as good qty. </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script src="<?= getFullURLLevel($_GET['r'],'common/js/scan_barcode.js',3,'R') ?>"></script>
<script>
function gatepass_page(i)
{
	//window.location = $url&?gatepassid=".$gate_id.""; 
}
</script>
