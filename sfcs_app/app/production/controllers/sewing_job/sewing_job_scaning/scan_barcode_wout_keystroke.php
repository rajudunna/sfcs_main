<?php
    include(getFullURLLevel($_GET['r'],'common/config/config.php',5,'R'));
	include(getFullURLLevel($_GET['r'],'common/config/functions.php',5,'R'));
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
</style>
<div class="ajax-loader" id="loading-image" style="display: none">
    <center><img src='<?= getFullURLLevel($_GET['r'],'ajax-loader.gif',0,'R'); ?>' class="img-responsive" style="padding-top: 250px"/></center>
</div>
<div class="panel panel-primary " id="scanBarcode" ng-app="scanning_interface" ng-cloak>
    <div class="panel-heading">Bundle Barcode Scanning</div>
    <div class="panel-body"  ng-controller="scanctrl">
        <div class="row jumbotron ">

            <div class="col-md-5">
                <div class="col-padding" >
                    <input type="text" id="barcode_scan" class="form-control input-lg" ng-model="barcode" ng-keypress="scanned($event)" placeholder="scan here" autofocus>
                    <input type="hidden" class="form-control" ng-model="url" ng-init="url='/<?= getFullURLLevel($_GET['r'],'get_barcode_details_new.php',0,'R') ?>'">
                </div>
            </div>
            <div class="vline"></div>
            <div class="col-md-5 pull-right">
                <div class="col-padding table-responsive" >
                    <table class="table table-bordered" ng-show="showtable == true">
                        <thead>
                            <tr>
                                <th width="30%">Last Scan</th>
                                <td width="30%" bgcolor="white">{{last_barcode}}</td>
                            </tr>
                            <tr>
                                <th width="30%">Status</th>
                                <td width="30%" bgcolor="white">{{last_barcode_status}}</td>
                            </tr>
                            <tr>
                                <th width="30%">Status Remarks</th>
                                <td width="30%" bgcolor="white">{{last_barcode_status_remarks}}</td>
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
                    <tr ng-repeat="bar_code_details in scanned_barcode_details track by $index">
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
