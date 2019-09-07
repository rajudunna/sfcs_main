<?php 
    include(getFullURLLevel($_GET['r'],'common/config/config.php',5,'R'));
    include(getFullURLLevel($_GET['r'],'common/config/functions.php',5,'R'));
    $op_code=$_POST['operation_code'];
    $module = $_POST['Module'];
    $ops_code = explode("-",$op_code)[1];
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
    
        <div class="panel-heading" >Bundle Transfer Barcode Scanning</div>
    <div class="panel-body"  ng-controller="scanctrl">
        <div class="row jumbotron " ng-init="module='<?= $module ?>'">
            <div class="col-md-5"  ng-init="ops_code='<?= $ops_code ?>'" >
					<div class="col-padding" ng-init="op_code='<?= $op_code ?>'">
                        <div class="row">
                            <div class="col-md-12">
                            <h4><label>Operation Name : </label><?php echo $op_code;?></h4>                    
                            </div>
                            <div class="col-md-12">
                            <h4><label>Module Name: </label>  <?php echo $module;?></h4>
                            </div>
                        </div>
                        <br/>
                    <input type="hidden" id="operation_code" class="form-control input-lg" ng-model="ops_code" >
                    <input type="hidden" id="module" class="form-control input-lg" ng-model="module" >
                    <input type="text" id="barcode_scan" class="form-control input-lg" ng-model="barcode" ng-keypress="scanned($event)" >
                    <input type="hidden" name="barcode" class="form-control" ng-model="url" ng-init="url='/<?= getFullURLLevel($_GET['r'],'get_bundle_transfer.php',0,'R') ?>'">
                    
						<div class="col-sm-2 form-group" style="padding-top:20px;">
						<form method ='POST' id='frm1' action='<?php echo $url ?>'>
						
						</form>
						</div> 
						<br>					
										
                </div>
            </div>
			
            <div class="vline"></div>
            <div class="col-md-5 pull-right">
                <div class="col-padding table-responsive" >
                    <table class="table table-bordered bgcolortable" ng-show="showtable == true">
                        <thead>
                            <tr>
                                <th width="30%">Bundle Number</th>
                                <th width="30%" >{{bundle}}</th>
                            </tr>
                            <tr>
                                <th width="30%">Operation Name</th>
                                <th width="30%" >{{op_code}}</th>
                            </tr>
                            <tr>
                                <th width="30%">Module Name</th>
                                <th width="30%" >{{module}}</th>
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
                        <th>Operation Description</th>
                        <th>Module Name</th>
                        <th>status</th>
                        <th>Remarks</th>
                    </tr>
                </thead>
                <tbody>
                    <tr ng-repeat="bar_code_details  in scanned_barcode_details">
                        <td>{{$index+1}}</td>
                        <td>{{bar_code_details.bundle}}</td>
                        <td>{{bar_code_details.operation_code}}</td>
                        <td>{{bar_code_details.module}}</td>
                        <td>{{bar_code_details.status}}</td> 
                        <td>{{bar_code_details.last_barcode_status_remarks}}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        </div>
    </div>
</div>
<script src="<?= getFullURLLevel($_GET['r'],'common/js/bundle_transfer.js',3,'R') ?>"></script>

