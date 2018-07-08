<?php  
/*
    Purpose : Page to update down time in sewing time based on planning vs actual 
    Created By : Chandu
    Create : 04-07-2018
    Update : 08-07-2018 
    inputs : date,time,module
    output : show table with style,schedule,color details and update button for update down time
*/


if(isset($_POST) && isset($_POST['date_y'])){
    include($_SERVER['DOCUMENT_ROOT'].'/template/dbconf.php');
    $datt = $_POST['date_y']."-".$_POST['date_m']."-".$_POST['date_d'];
    //echo $datt;die();
    $date = date('Y-m-d',strtotime($datt));
    $time = $_POST['time'].":30";
    $team = $_POST['team'];
    foreach($_POST['main_data'] as $iv){
        $reason = explode('(',$iv['reasons'])[0];
        $qty = $iv['hours'];
        $ins_qry = "
        INSERT INTO `bai_pro2`.`hourly_downtime` 
            (
            `date`, 
            `time`, 
            `team`, 
            `dreason`, 
            `output_qty`, 
            `dhour`
            )
            VALUES
            ( 
            '".$date."', 
            '".$time."', 
            '".$team."', 
            '".$reason."', 
            '".$qty."', 
            ''
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
$sql_time = 'select time_value,time_display,day_part  FROM '.$bai_pro3.'.tbl_plant_timings';
$result_time = mysqli_query($link, $sql_time) or exit("Sql Error time".mysqli_error($GLOBALS["___mysqli_ston"]));
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
                <label>Time</label><br/>
                    <select class="form-control" name='mtime' required>
                        <option value=''>Select Time</option>
                        <?php
                            while($row=mysqli_fetch_array($result_time)){
                                if($row['day_part']=='Morning')
                                    $put = 'AM';
                                elseif($row['day_part']=='Evening')
                                    $put = 'PM';
                                else
                                    $put = $row['day_part'];
                                
                                if(isset($_GET['mtime']) && $_GET['mtime']==$row['time_value'])
                                    echo "<option value='".$row['time_value']."' selected>".$row['time_display']." ".$put."</option>";
                                else
                                    echo "<option value='".$row['time_value']."'>".$row['time_display']." ".$put."</option>";
                            }
                        ?>
                    </select>
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

            if(isset($_GET['module']) && $_GET['module']!='' && isset($_GET['mtime']) && $_GET['mtime']!='' && isset($_GET['mdate']) && $_GET['mdate']!=''){
                echo "<hr/>";
                $get_log_data = "SELECT bac_style,color,delivery,sum(bac_Qty) as bac_Qty FROM $bai_pro.bai_log WHERE DATE(bac_lastup) = '".date('Y-m-d',strtotime($_GET['mdate']))."' AND HOUR(bac_lastup) = '".$_GET['mtime']."' AND bac_no = '".$_GET['module']."' group by bac_style,delivery,color" ;
                $result_log_data = mysqli_query($link, $get_log_data) or exit("Sql Error log".mysqli_error($GLOBALS["___mysqli_ston"]));
                $get_fr_data = "
                SELECT style,schedule,color,FLOOR(fr_qty/hours) AS qty FROM $bai_pro2.fr_data WHERE DATE(frdate)='".date('Y-m-d',strtotime($_GET['mdate']))."' AND team='".$_GET['module']."'";
                $result_fr_data = mysqli_query($link, $get_fr_data) or exit("Sql Error fr".mysqli_error($GLOBALS["___mysqli_ston"]));

                $tab="<table class='table table-bordered'><thead><tr><th class='text-center'>Type</th><th>Style</th><th>Schedule</th><th>Color</th><th>Quantity</th></tr></thead><tbody>";
                $act_data = [];
                $target = true;
                $act_count = mysqli_num_rows($result_log_data);
                $fr_count = mysqli_num_rows($result_fr_data);
                $tab1='';
                $tab2='';
                while($row=mysqli_fetch_array($result_log_data)){
                    $tab2.="<tr>";
                    if(count($act_data)==0)
                        $tab2.="<td style='vertical-align: middle;' class='text-center' rowspan=".$act_count."><h5>Actual</h5></td>";
                    $tab2.="<td>".$row['bac_style']."</td><td>".$row['delivery']."</td><td>".$row['color']."</td><td>".$row['bac_Qty']."</td></tr>";
                    $act_data[trim($row['bac_style']).trim($row['delivery']).trim($row['color'])] = $row['bac_Qty'];
                }
                $i=0;
                $hours = 0;
                while($row=mysqli_fetch_array($result_fr_data)){
                    $tab1.="<tr>";
                    if($i==0)
                        $tab1.="<td style='vertical-align: middle;' class='text-center' rowspan=".$fr_count."><h5>Plan</h5></td>";

                    $tab1.="<td>".$row['style']."</td><td>".$row['schedule']."</td><td>".$row['color']."</td><td>".$row['qty']."</td></tr>";

                    $key = trim($row['style']).trim($row['schedule']).trim($row['color']);
                    if(isset($act_data[$key])){
                        if($act_data[$key]<$row['qty']){
                            $target = false;
                            $hours+=($row['qty']-$act_data[$key]);
                        }
                    }else{
                        $target = false;
                        $hours+=$row['qty'];
                    }
                    $i++;
                }
                $tab2.="</tbody></table>";
                if(!$target){
                    $resons_data_sql = "SELECT code,reason FROM $bai_pro2.downtime_reason";
                    $resons_data_result = mysqli_query($link, $resons_data_sql) or exit("Sql Error resons".mysqli_error($GLOBALS["___mysqli_ston"]));

                    $hourly_down_time_qry = "SELECT * FROM $bai_pro2.hourly_downtime WHERE DATE(date) = '".$_GET['mdate']."' AND TIME= '".$_GET['mtime'].":30' AND team = '".$_GET['module']."'";
                    $hourly_down_time_res = mysqli_query($link, $hourly_down_time_qry) or exit("Sql Error hourly down time".mysqli_error($GLOBALS["___mysqli_ston"]));
                    if(mysqli_num_rows($hourly_down_time_res)==0){
                        echo "<button class='btn btn-danger pull right' data-toggle='modal' data-target='#myModal'><i class='fas fa-clock'></i> Update Down Time (".$hours." Quantity)</button>";
                    }else{
                        echo "<div class='alert alert-info'>Down time updated previously.</div>";
                    }


                    echo '<div id="myModal" class="modal fade" role="dialog">
                        <div class="modal-dialog modal-lg">

                            <!-- Modal content-->
                            <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Update Down Time</h4>
                            </div>
                            <div class="modal-body" id="brand" ng-app="chandu" ng-controller="downtimecontroller">';
                        if(mysqli_num_rows($hourly_down_time_res)==0){
                        echo "<div class='col-sm-12'><div class='col-sm-4'><select ng-model='reasons' id='reson' name='reson' class='form-control'>";
                            echo "<option value=''>Select Reson</option>";
                            while($row1 = mysqli_fetch_array($resons_data_result)){
                                echo "<option value='".$row1['code']."(".$row1['reason'].")'>".$row1['code']."(".$row1['reason'].")</option>";
                            }
                        echo "</select></div>";
                        echo "<div class='col-sm-4'><input type='number' place-holder='Quantity' name='hours' ng-model='hours' id='hours' class='form-control'></div>";
                        echo "<button class='btn btn-info col-sm-2' ng-click='addData()'>Add</button> <button class='btn btn-primary col-sm-2' ng-click='sendData()'>Save</button></div>
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
                        }else{
                            echo "<div class='alert alert-warning'>Down time updated previously.</div>";
                        }
                        echo '</div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                            </div>

                        </div>
                    </div>';
                }
                if($act_count>0 || $fr_count>0)
                    echo $tab.$tab1.$tab2;
                else
                    echo "<div class='alert alert-warning'>No Data Found</div>";
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
    $scope.alert = '';
    $scope.dtimehrs = <?= isset($hours) ? $hours : 0  ?>;
    $scope.date_y = <?= isset($_GET['mdate']) ? date('Y',strtotime($_GET['mdate'])) : 0  ?>;
    $scope.date_m = <?= isset($_GET['mdate']) ? date('m',strtotime($_GET['mdate'])) : 0  ?>;
    $scope.date_d = <?= isset($_GET['mdate']) ? date('d',strtotime($_GET['mdate'])) : 0  ?>;
    $scope.time = <?= isset($_GET['mtime']) ? $_GET['mtime'] : 0  ?>;
    $scope.team = <?= isset($_GET['module']) ? $_GET['module'] : 0  ?>;
    $scope.act_hrs = 0;
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
        $http({ 
            method: 'POST', 
            url: url_serv,
            headers: {
                 'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'
             },
            data: params
        })
            .then(function successCallback(response) {
                console.log(response.data);
                if(response.data.message=='success'){
                    swal('downtime updated successfully.');
                    location.reload();
                }
            });
    }else{
        $scope.alert_info = true;
        $scope.alert_class = 'danger';
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
            $scope.test.reasons = $scope.reasons;
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

<?php } ?>