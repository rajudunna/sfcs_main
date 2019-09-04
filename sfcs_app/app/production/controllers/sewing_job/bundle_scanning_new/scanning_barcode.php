<?php
$module = $_POST['Module'];
$op_code=$_POST['operation_code'];
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
    border-radius: 4px;
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
</style>
<div class="panel panel-primary" id="scanned_barcode" ng-app="scanning_interface_new">
    <div class="panel-heading">Bundle Scanning</div>
    <div class="panel-body" style="background-color: darkslategray;" ng-controller="scancode_ctrl">
       <table border=0;> 
       <tr>
        <td><label>Style : </label><br/><br/><label>Color : </label></td>
        <td> <input type="text" style="max-width: 150px;" class="form-control" name="style"><br/><br/>
       <input type="text" style="max-width: 150px;" class="form-control" name="color"></td>
       <td style="width: 10 5px;"></td>
        <td><div class="container" style="width: 570px;">
        <div class="panel panel-basic">
         <div class="panel-heading">
                <div class="row">
                <div class="col-sm-3 col-md-3 col-xs-3">Barcode: </div>
                <div class="col-sm-3 col-md-3 col-xs-3">Action: </div>
                <div class="col-sm-3 col-md-3 col-xs-3">Tx Mode: </div>
                <div class="col-sm-3 col-md-3 col-xs-3">Tot Qty: </div>
                </div>
                </div>
                <div class="panel-body"> 
                <div class="row">
                <div class="col-sm-4 col-md-4 col-xs-4"><center>Scanned Status</center></div>
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
        <td><input type="text" style="max-width: 250px;"  class="form-control" ng-model="barcode_value" id="barcode_value" placeholder="scan barcode here" autofocus></td>
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
            <label for="radioscrap" style="background-color: #f31c06;">Scrap</label>
            <input type="radio" id="radiorework" name="trans_mode" ng-model='trans_mode' ng-value='"rework"'>
            <label for="radiorework" style="background-color: #557520f2;">Rework</label>
            <input type="radio" id="radiogudscrap" name="trans_mode" ng-model='trans_mode' ng-value='"gudscrap"'>
            <label for="radiogudscrap" style="background-color: #a5980df5;">Good&Scrap</label> 
            </div>
        </td>
        <td style="width: 10 5px;"></td>
        <td><div class="container" style="width: 570px;">
        <div class="panel panel-basic">
         <div class="panel-heading">
                <div class="row">
                <div class="col-sm-3 col-md-3 col-xs-3">PO: </div>
                <div class="col-sm-3 col-md-3 col-xs-3"></div>
                <div class="col-sm-3 col-md-3 col-xs-3"></div>
                <div class="col-sm-3 col-md-3 col-xs-3">Size:</div>
                <div class="panel-body">  </div>
                <div class="row"> </div>
                <div class="col-sm-3 col-md-3 col-xs-3" > Z feature: </div>
                <div class="col-sm-3 col-md-3 col-xs-3"></div>
                <div class="col-sm-3 col-md-3 col-xs-3"></div>
                <div class="col-sm-3 col-md-3 col-xs-3">Schedule:</div>
                <div class="panel-body">  </div>
                <div class="row"> </div>
                <div class="col-sm-6 col-md-6 col-xs-6">Color : </div>
                </div>
                 </div>
         </div>
         </td>
        </tr>
        </br></br></br>
        <tr>
        <td><span>Action :</span></td>
        <td style="width: 323px;">
        <div>
        <button type="button" style="height: 80px;width: 76px;."  class="btn btn-info"  ng-click="barcode_submit('add');">Add</button>
        <button type="button" style="height: 80px;" class="btn btn-info" ng-click="barcode_submit('reverse');">Reverse</button>
        <button type="button" style="height: 80px;width: 76px;" class="btn btn-info">Reset</button>
        </div>
        </td>
        <td style="width: 125px;"></td>
        <td><div class="container" style="width: 570px;">
        <div class="panel panel-basic">
         <div class="panel-heading">
                <div class="row">
                <div class="col-sm-3 col-md-3 col-xs-3">Factory : </div>
                <div class="panel-heading"></div>
                <div class="row"></div>
                <div class="panel-heading"></div>
                <div class="row"></div>
                <div class="panel-heading"></div>
                <div class="row"></div>
                <div class="col-sm-8 col-md-8 col-xs-8">Size:</div>
                <button type="button" style="height: 60px;width:100px;" class="btn btn-info">Reset</button>
                <div class="col-sm-8 col-md-8 col-xs-8">Operation :</div>
                <div class="col-sm-3  ">Count</div>
                </div>
            </div>
        </td>
        </tr>
        <tr>
        <td><label> Scrap Reason: </label></td>
        <td><input type="text" style="max-width: 250px;"  class="form-control" name="Scrap Reason"></td>
        <td></td>
        <td></td>
        </tr>
        </table>  
    </div>
</div>

<script src="<?= getFullURLLevel($_GET['r'],'common/js/new_scan_barcode.js',3,'R') ?>"></script>

 

