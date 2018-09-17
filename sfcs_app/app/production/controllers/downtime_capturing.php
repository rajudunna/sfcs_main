<?php  
/*
    Purpose : Page to update down time in sewing time based on planning vs actual 
    Created By : Chandu
    Create : 04-07-2018
    Update : 31-08-2018 
    inputs : date,time,module
    output : show table with style,schedule,color details and update button for update down time.
    updates v0.1 : change the inputing to date and module. remove style schedule color in table. show actual quantity and planned quantity in single row.
    updates v0.2 : output is changes ==> present output is plan-actual ==> updated output is forcast-actual if forcast is not there plan-actual
    update v0.3 : outpt view is changed to 7-8 to 7:30-8:30 , change the database stracture, as per the stracture modify queries.
    update v0.4 : forecast value Round-up
*/


if(isset($_POST) && isset($_POST['date_y'])){
    include($_SERVER['DOCUMENT_ROOT'].'/template/dbconf.php');
    $datt = $_POST['date_y']."-".$_POST['date_m']."-".$_POST['date_d'];
    //echo $datt;die();
    $date = date('Y-m-d',strtotime($datt));
    $t = str_pad($_POST['time'],2,"0",STR_PAD_LEFT);
    $dhour_value = $t.":30:00";
    $time = $t.":30:00";
    $team = $_POST['team'];
    foreach($_POST['main_data'] as $iv){
        $reason = explode('(',$iv['reasons'])[0];
        $qty = $iv['hours'];
        $res_id = $iv['reason_id'];
        $ins_qry = "
        INSERT INTO `bai_pro2`.`hourly_downtime` 
            (
            `date`, 
            `time`, 
            `team`, 
            `dreason`, 
            `output_qty`, 
            `dhour`,
            `reason_id`
            )
            VALUES
            ( 
            '".$date."', 
            '".$time."', 
            '".$team."', 
            '".$reason."', 
            '".$qty."', 
            '".$dhour_value."',
            '".$res_id."'
            );
        ";
       // echo $ins_qry;
        $result_time = mysqli_query($link_ui, $ins_qry) or exit("Sql Error update downtime log".mysqli_error($GLOBALS["___mysqli_ston"]));
    }
    echo json_encode(['message'=>'success']);  
}else{

 include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'/common/config/user_acl_v1.php',3,'R'));
 include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'/common/config/functions.php',3,'R'));  
 include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'/common/config/config.php',3,'R'));
//========== get modules list ================
$sql_module = 'select sec_mods FROM '.$bai_pro3.'.sections_db where sec_id>0';
$result_module = mysqli_query($link, $sql_module) or exit("Sql Error - module".mysqli_error($GLOBALS["___mysqli_ston"]));
//=========== get timimgs list =======================
//$sql_time = 'select time_value,time_display,day_part  FROM '.$bai_pro3.'.tbl_plant_timings';
//$result_time = mysqli_query($link, $sql_time) or exit("Sql Error time".mysqli_error($GLOBALS["___mysqli_ston"]));
?> 
<head>
<title>Down time capturing</title>
</head>
<body>
    <div class="panel panel-primary">
        <div class='panel-heading'><h3 class='panel-title'>Downtime Capturing</h3></div>
        <div class='panel-body'>
            <form>
                <input type='hidden' name='r' value='<?= $_GET['r'] ?>'>
                <div class="form-group col-sm-3">
                    <label>Date</label><br/>
                    <input data-toggle='datepicker' placeholder="YYYY-MM-DD" type="text" class="form-control" name='mdate' value="<?= isset($_GET['mdate']) ? $_GET['mdate'] : '' ?>" required>
                </div>
                <div class="form-group col-sm-3">
                    <label>Module</label><br/>
                    <select class="form-control" name='module' required>
                        <option value=''>Module</option>
                        <?php
                            while($row=mysqli_fetch_array($result_module)){
                                $list = explode(',',$row['sec_mods']);
                                foreach($list as $pv){
                                    if(isset($_GET['module']) && $_GET['module']==$pv)
                                        echo "<option value='".$pv."' selected>".$pv."</option>";
                                    else
                                        echo "<option value='".$pv."'>".$pv."</option>";
                                }
                            }
                        ?>
                    </select>
                </div>
                <div class='col-sm-3'>
                <br/>
                <button type="submit" class="btn btn-success"><i class="fas fa-search"></i> Filter</button>
                <a href="index.php?r=<?= $_GET['r'] ?>" class="btn btn-warning"><i class="fas fa-times"></i> Clear</a>
                </div>
            </form>

<!-- Logics starts here -->
<?php

            if(isset($_GET['module']) && $_GET['module']!='' && isset($_GET['mdate']) && $_GET['mdate']!=''){
                echo "<hr/>";
                //$get_log_data = "SELECT bac_style,color,delivery,sum(bac_Qty) as bac_Qty FROM $bai_pro.bai_log WHERE DATE(bac_lastup) = '".date('Y-m-d',strtotime($_GET['mdate']))."' AND HOUR(bac_lastup) = '".$_GET['mtime']."' AND bac_no = '".$_GET['module']."' group by bac_style,delivery,color";
                //$get_log_data = "SELECT time_value,CONCAT(time_display,' ',day_part) AS HOUR,SUM(bac_Qty) AS bac_Qty FROM $bai_pro.bai_log LEFT JOIN $bai_pro3.tbl_plant_timings ON tbl_plant_timings.time_value=HOUR(bai_log.bac_lastup) WHERE DATE(bac_lastup) = '".date('Y-m-d',strtotime($_GET['mdate']))."' AND bac_no = '".$_GET['module']."' group by time_value";

                $get_log_data = "SELECT CAST(SUBSTRING_INDEX(out_time, ':', 1) AS SIGNED) AS time_value,rep_start_time,CONCAT(CAST(SUBSTRING_INDEX(out_time, ':', 1) AS SIGNED),'-',CAST(SUBSTRING_INDEX(out_time, ':', 1)+1 AS SIGNED)) AS HOUR,IF(qty>0,qty,0) AS bac_Qty  FROM bai_pro2.hout WHERE out_date='".date('Y-m-d',strtotime($_GET['mdate']))."' AND team='".$_GET['module']."'";
                //echo $get_log_data;
                $result_log_data = mysqli_query($link, $get_log_data) or exit("Sql Error log".mysqli_error($GLOBALS["___mysqli_ston"]));
                
                $get_fr_data = "SELECT sum(FLOOR(fr_qty/hours)) AS qty,avg(hours) as day_hrs FROM $bai_pro2.fr_data WHERE DATE(frdate)='".date('Y-m-d',strtotime($_GET['mdate']))."' AND team='".$_GET['module']."'";
                $result_fr_data = mysqli_query($link, $get_fr_data) or exit("Sql Error fr".mysqli_error($GLOBALS["___mysqli_ston"]));
                //echo $get_fr_data;
                if(date('Y-m-d',strtotime($_GET['mdate'])) == date('Y-m-d')){
                    $apend = " where end_time < time('".date('Y-m-d H:i:s')."')";
                }elseif(strtotime($_GET['mdate'])>strtotime(date('Y-m-d'))){
                    $apend = " where time_value = 0";
                }else{
                    $apend = '';
                }
                $get_timings = "SELECT start_time,end_time,time_value,CONCAT(time_display,' ',day_part) AS HOUR FROM $bai_pro3.tbl_plant_timings ".$apend;
                //echo $get_timings;
                $result_timings = mysqli_query($link, $get_timings) or exit("Sql Error fr".mysqli_error($GLOBALS["___mysqli_ston"]));

                $forcast_qry = "SELECT qty FROM $bai_pro3.line_forecast WHERE DATE='".date('Y-m-d',strtotime($_GET['mdate']))."' AND module='".$_GET['module']."'";
                //echo $forcast_qry;
                $forcast_res = mysqli_query($link, $forcast_qry) or exit("Sql Error fr".mysqli_error($GLOBALS["___mysqli_ston"]));
               
                $get_breaks = "SELECT id,code,reason FROM $bai_pro2.downtime_reason WHERE id IN (SELECT reason_id FROM $bai_pro2.hourly_downtime WHERE DATE = '".$_GET['mdate']."' AND reason_id IN (20,21,22))";
                $brks = '';
                
                $result_breaks = mysqli_query($link, $get_breaks) or exit("SQL Error_x:".$get_breaks);
                if(mysqli_num_rows($result_breaks) > 0)
                {
                    echo "<div class = 'label label-warning'>";
                    while($breaks = mysqli_fetch_array($result_breaks))
                    {
                        $brks .= "<strong>".$breaks['reason']."</strong>&nbsp;";
                    }
                    echo $brks."breaks has already been taken</div><br/>";
                }

                $tab = "<table class='table table-bordered'><thead><tr><th>Time</th><th>Plan</th><th>Forcast</th><th>Actual</th><th>Actions</th></tr></thead>
                <tbody>";
                $plan_qty_fetch = mysqli_fetch_array($result_fr_data);
                $plan_qty = $plan_qty_fetch['qty']>0 ? $plan_qty_fetch['qty'] : 0 ;
                $day_hrs = $plan_qty_fetch['day_hrs']>0 ? $plan_qty_fetch['day_hrs'] : 1 ;

                $forcast_qty_fetch = mysqli_fetch_array($forcast_res);
                //var_dump($forcast_qty_fetch);
                $forcast_qty = $forcast_qty_fetch['qty']>0 ? ceil($forcast_qty_fetch['qty']/$day_hrs) : 0;
                $actuals=[];
                
                while($row=mysqli_fetch_array($result_log_data)){
                    $actuals[$row['rep_start_time']] = ceil($row['bac_Qty']);
                }
                //var_dump($actuals);
                while($r=mysqli_fetch_array($result_timings)){
                    $actual_qty = isset($actuals[$r['start_time']]) ? $actuals[$r['start_time']] : 0;

                    if($actual_qty<$forcast_qty){
                        $hours = $forcast_qty - $actual_qty;
                        $hourly_down_time_qry = "SELECT * FROM $bai_pro2.hourly_downtime WHERE DATE(date) = '".$_GET['mdate']."' AND time(TIME) = time('".$r['start_time']."') AND team = '".$_GET['module']."'";
                        $hourly_down_time_res = mysqli_query($link, $hourly_down_time_qry) or exit("Sql Error hourly down time".mysqli_error($GLOBALS["___mysqli_ston"]));
                        if(mysqli_num_rows($hourly_down_time_res)==0){
                            $btn="<button class='btn btn-danger pull right' onclick='assignhour(".explode(":",$r['start_time'])[0].",".$hours.")' data-toggle='modal' data-target='#myModal'><i class='fas fa-clock'></i> Update Down Time (".$hours." Quantity)</button>";
                           //echo $hourly_down_time_qry."<br/>"; 
                        }else{
                            $btn="<div class='label label-info'>Down time updated.</div>";
                        }
                    }elseif($actual_qty<$plan_qty && $forcast_qty==0){
                        $hours = $plan_qty - $actual_qty;
                        $hourly_down_time_qry = "SELECT * FROM $bai_pro2.hourly_downtime WHERE DATE(date) = '".$_GET['mdate']."' AND time(TIME) = time('".$r['start_time']."') AND team = '".$_GET['module']."'";
                        $hourly_down_time_res = mysqli_query($link, $hourly_down_time_qry) or exit("Sql Error hourly down time".mysqli_error($GLOBALS["___mysqli_ston"]));
                        //echo $hourly_down_time_qry."<br/>" ;
                        if(mysqli_num_rows($hourly_down_time_res)==0){
                            $btn="<button class='btn btn-danger pull right' onclick='assignhour(".explode(":",$r['start_time'])[0].",".$hours.")' data-toggle='modal' data-target='#myModal'><i class='fas fa-clock'></i> Update Down Time (".$hours." Quantity)</button>";
                        }else{
                            $btn="<div class='label label-info'>Down time updated.</div>";
                        }
                    }else{
                        $btn= "<div class='label label-primary'>No Downtime.</div>";
                    }


                    $hor = $r['HOUR'];
                    $tab.="<tr><td>".$hor."</td><td>$plan_qty</td><td>".round($forcast_qty,2)."</td><td>$actual_qty</td><td>$btn</td></tr>";
                    
                }
                $tab.="</tbody>
                </table>";

                $resons_data_sql = "SELECT id,code,reason FROM $bai_pro2.downtime_reason WHERE id NOT IN (SELECT reason_id FROM $bai_pro2.hourly_downtime WHERE DATE = '".$_GET['mdate']."' AND reason_id IN (20,21,22))";

                $resons_data_result = mysqli_query($link, $resons_data_sql) or exit("Sql Error resons".mysqli_error($GLOBALS["___mysqli_ston"]));


                echo '<div id="myModal" class="modal fade" role="dialog">
                    <div class="modal-dialog modal-lg">

                        <!-- Modal content-->
                        <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Update Down Time</h4>
                        </div>
                        <div class="modal-body" id="brand" ng-app="chandu" ng-controller="downtimecontroller">';
                    //if(mysqli_num_rows($hourly_down_time_res)==0){
                        echo "Downtime Quantity : <b>{{dtimehrs}}</b>";
                    echo "<div class='col-sm-12'><div class='col-sm-4'><select ng-model='reasons' id='reson' name='reson' class='form-control'>";
                        echo "<option value=''>Select Reason</option>";
                        while($row1 = mysqli_fetch_array($resons_data_result)){
                            echo "<option value='".$row1['id']."#".$row1['code']."(".$row1['reason'].")'>".$row1['code']."(".$row1['reason'].")</option>";
                        }
                    echo "</select></div>";
                    echo "<div class='col-sm-4'><div class='col-sm-3'>Quantity</div><div class='col-sm-9'><input type='number' place-holder='Quantity' name='hours' ng-model='hours' id='hours' class='form-control'></div></div>";
                    echo "<button class='btn btn-info col-sm-1' ng-click='addData()'>Add</button> <button class='btn btn-primary col-sm-2' ng-click='sendData()' ng-show='saveinit'>Save</button></div>
                    <br/>";
                       
                        
?>
                            <div class='col-sm-12'>
                                <div class='alert alert-{{alert_class}}' ng-if='alert_info'>{{alert}}</div>
                                <table class='table'>
                                    <thead><tr><th>Reasons</th><th>Quantity</th><th>Actions</th></tr></thead>
                                    <tbody>
                                        <tr ng-repeat='data in downtimeData'>
                                            <td>{{data.reasons}}</td>
                                            <td>{{data.hours}}</td>
                                            <td><i ng-click='removeData(data.reasons)' class="fas fa-times-circle"></i></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
<?php
                        echo "<br/>";
                        // }else{
                        //     echo "<div class='alert alert-warning'>Down time updated previously.</div>";
                        // }
                        echo '</div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                            </div>

                        </div>
                    </div>';
                
                
                    echo $tab;
                
            }elseif(isset($_GET['mdate']) && $_GET['mdate']=='')
                echo "<div class='alert alert-danger'>Pleae select Date</div>";
?>
        </div>
    </div>
</body>

<script>
var app = angular.module('chandu', []);
app.controller('downtimecontroller', function($scope, $http) {
    $scope.reasons = "";
    $scope.hours = 0;
    $scope.downtimeData = [];
    $scope.alert_info = false;
    $scope.alert_class = 'default';
    $scope.saveinit = true;
    $scope.alert = '';
    $scope.dtimehrs =  0 ;
    $scope.date_y = <?= isset($_GET['mdate']) ? date('Y',strtotime($_GET['mdate'])) : 0  ?>;
    $scope.date_m = <?= isset($_GET['mdate']) ? date('m',strtotime($_GET['mdate'])) : 0  ?>;
    $scope.date_d = <?= isset($_GET['mdate']) ? date('d',strtotime($_GET['mdate'])) : 0  ?>;
    $scope.time = 0;
    $scope.team = <?= isset($_GET['module']) ? $_GET['module'] : 0  ?>;
    $scope.act_hrs = 0;
    $scope.reason = 0;

    $scope.removeData = function(reson){
        for(var i=0;i<$scope.downtimeData.length;i++){
            if($scope.downtimeData[i].reasons==reson){
                $scope.act_hrs-=$scope.downtimeData[i].hours;
                $scope.downtimeData.splice(i, 1);
                $scope.alert_info = true;
                $scope.alert_class = 'warning';
                $scope.alert = 'Reason Deleted..';
            }
        }
    };

$scope.sendData = function(){
    var url_serv = '<?= base64_decode($_GET['r']) ?>';
    var rv = {};
    for (var i = 0; i < $scope.downtimeData.length; ++i)
        if ($scope.downtimeData[i] !== undefined) rv[i] = $scope.downtimeData[i];
    var params = $.param({
        'main_data' : rv,'date_y' :$scope.date_y ,'date_m' :$scope.date_m ,'date_d' :$scope.date_d ,'time' : $scope.time,'team' :$scope.team 
     });
    if($scope.downtimeData.length>0 && $scope.act_hrs==$scope.dtimehrs){
        $scope.saveinit = false;
        $http({ 
            method: 'POST', 
            url: url_serv,
            headers: {
                 'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'
             },
            data: params
        })
            .then(function successCallback(response) {
                
                if(response.data.message=='success'){
                    swal('downtime updated successfully.');
                    location.reload();
                }
            });
    }else{
        $scope.alert_info = true;
        $scope.alert_class = 'danger';
        if($scope.downtimeData.length==0)
            $scope.alert = "Invalid data";
        else
            $scope.alert = "Total quantity should be equal to "+$scope.dtimehrs;
    }
};


    $scope.addData = function(){
        
        $scope.test = {};
        var check = false;
        var h = Math.floor($scope.hours);
        for(var i=0;i<$scope.downtimeData.length;i++){
            
            if($scope.downtimeData[i].reasons==$scope.reasons)
                check = true;
        }
        
        if($scope.hours>0 && !check && $scope.reasons!='' && ($scope.act_hrs+$scope.hours)<=$scope.dtimehrs && $scope.hours==h){
            id_code = $scope.reasons.split('#');
            $scope.test.reason_id = id_code[0];
            $scope.test.reasons = id_code[1];
            $scope.test.hours = $scope.hours;
            $scope.reasons = "";
            $scope.hours = 0;
            $scope.downtimeData.push($scope.test);
            $scope.alert_info = true;
            $scope.alert_class = 'success';
            $scope.alert = 'Reason Added Successfully..';
            $scope.act_hrs+=$scope.test.hours;
            
        }else{
            $scope.alert_info = true;
            $scope.alert_class = 'danger';
            if($scope.reasons=='')
                $scope.alert = 'Please select Reason.';
            else if($scope.hours==0)
                $scope.alert = 'Quantity should be greater than zero';
            else if(check)
                $scope.alert = 'Reason already exist';
            else if(($scope.act_hrs+$scope.hours)>$scope.dtimehrs)
                $scope.alert = 'Total Quantity should not be greater than '+$scope.dtimehrs;
            else if($scope.hours!=h)
                $scope.alert = 'Please enter values and Quantity should not be Decimal.';
            else
                $scope.alert = 'Invalid values.';
        }
    };
});
angular.bootstrap($('#brand'), ['chandu']);
</script>
<style>
.modal-dialog{
    overflow-y: initial !important
}
.modal-body{
    height: 500px;
    overflow-y: auto;
}
</style>
<script>
function assignhour(time,hours){
    //alert(time+" "+hours);
    var controllerElement = document.querySelector('[ng-controller="downtimecontroller"]');
    var scope = angular.element(controllerElement).scope();
    scope.$apply(function () {
        scope.dtimehrs =  hours ;
        scope.time = time;
    });
}
</script>
<?php } ?>
