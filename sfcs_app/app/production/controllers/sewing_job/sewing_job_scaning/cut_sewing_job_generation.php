<?php
/* ===============================================================
               Created By : Sudheer and Chandu
Created : 30-08-2018
Updated : 02-09-2018
input : Schedule,color & cutjob count.
output v0.1: Generate jobs.
Technical Stack : PHP 7,Angular js 1.4,JQuery, Maria DB
=================================================================== */
if(isset($_POST) && isset($_POST['main_data'])){
    include($_SERVER['DOCUMENT_ROOT'].'/template/dbconf.php');
    //$datt = $_POST['date_y']."-".$_POST['date_m']."-".$_POST['date_d'];
    //echo $datt;die();
    $main_data = $_POST['main_data'];
    $schedule  = $_POST['schedule'];
    $style  = $_POST['style'];
    $docnos = $_POST['docnos'];
    $count = 0;
    foreach($_POST['main_data'] as $iv){
        //$reason = explode('(',$iv['reasons'])[0];
        $cut = $iv['cut'];
        $destination = $iv['destination'];
        $dono = $iv['dono'];
        $ration = $iv['ratio'];
        $details = $iv['sizedetails'];
        $type_of_sewing  = 1;
        $doc_type = 'N';
        $packing_mode = 1;
        $status = '';
        $doc_no_ref = '';
        $old_jobs_cnt_qry = "SELECT COUNT(*) AS old_jobs FROM (SELECT COUNT(*) AS old_jobs FROM bai_pro3.pac_stat_log_input_job WHERE doc_no IN (".$docnos.") GROUP BY input_job_no) AS tab";
        //echo $old_jobs_cnt_qry;
        $old_jobs_cnt_res = mysqli_query($link_ui, $old_jobs_cnt_qry) or exit("Sql Error : old_jobs_cnt_qry".mysqli_error($GLOBALS["___mysqli_ston"]));
        $oldqty_jobcount = mysqli_fetch_array($old_jobs_cnt_res);
        // print_r($oldqty_jobcount)."<br/>";
        foreach ($details as $term ) {
            $job = $oldqty_jobcount['old_jobs']+$term['job_id'];
            $rand=$schedule.date("ymd").$job;
            $carton_act_qty = $term['job_qty'];
            $size_code = $term['job_size'];
            $old_size = $term['job_size_key'];
            //echo $job."<br/>";
           $ins_qry =  "INSERT INTO `bai_pro3`.`pac_stat_log_input_job` 
            (
             doc_no, size_code, carton_act_qty,input_job_no, input_job_no_random,destination,packing_mode,old_size,doc_type,type_of_sewing
            )
            VALUES
            ( 
            '".$dono."', 
            '".$size_code."', 
            '".$carton_act_qty."', 
            '".$job."', 
            '".$rand."',
            '".$destination."',
            '".$packing_mode."',
            '".$old_size."',
            '".$doc_type."',
            '".$type_of_sewing."'
            );
            ";
            //echo  $ins_qry;
           // die();
           $result_time = mysqli_query($link_ui, $ins_qry) or exit("Sql Error update downtime log".mysqli_error($GLOBALS["___mysqli_ston"]));
          $count++;
        }
        //echo $count;
        $ins_qry2 = "INSERT INTO `bai_pro3`.`sewing_jobs_ref`
        (
         style,schedule,bundles_count,log_time
        )
        VALUES
        (
            '".$style."',
            '".$schedule."',
            '".$count."',
             NOW()
        )";
       // echo $ins_qry2;
        //die();
       $result_time2 = mysqli_query($link_ui, $ins_qry2) or exit("Sql Error update downtime log".mysqli_error($GLOBALS["___mysqli_ston"]));

        
    }

    echo json_encode(['message'=>'success']);  
}else{
?>
<script>
$(document).ready(function(){
	var url1 = '?r=<?= $_GET['r'] ?>';
    console.log(url1);
    $("#style").change(function(){
        //alert("The text has been changed.");
		var optionSelected = $("option:selected", this);
       var valueSelected = this.value;
	  window.location.href =url1+"&style="+valueSelected
    });
    $("#schedule").change(function(){
       // var input = $(this);
       //var val = input.val();
        // alert(val);
     //window.location.href =url1+"&schedule="+val;
     var optionSelected = $("option:selected", this);
       var valueSelected2 = this.value;
	   var style1 = $("#style").val();
	   window.location.href =url1+"&style="+style1+"&schedule="+valueSelected2
    });

    $("#color").change(function(){
        //alert("The text has been changed.");
		var optionSelected = $("option:selected", this);
       var valueSelected3 = this.value;
       var style1 = $("#style").val();
       var schedule = $("#schedule").val();
       window.location.href =url1+"&style="+style1+"&schedule="+schedule+"&color="+valueSelected3
       //alert(valueSelected2); 
	 //window.location.href =url1+"&style="+document.mini_order_report.style.value+"&schedule="+document.mini_order_report.schedule.value
    });

});
</script>
<div class = 'panel panel-primary'>
<div class = 'panel-heading'>
<b>Cut Sewing Job Generation</b>
</div>
<?php
$style=$_GET['style'];
$schedule=$_GET['schedule']; 
$color  = $_GET['color'];

echo '<div class = "panel-body">';
$sql="select distinct order_style_no from bai_pro3.bai_orders_db";
$sql_result=mysqli_query($link_ui, $sql) or exit("Sql Error123".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_num_check=mysqli_num_rows($sql_result);
echo "<div class=\"row\"><div class=\"col-sm-3\"><label>Select Style:</label>
<select class='form-control' name=\"style\"  id='style'>";

echo "<option value='".$style."'>Please Select</option>";
while($sql_row=mysqli_fetch_array($sql_result))
{

	if(str_replace(" ","",$sql_row['order_style_no'])==str_replace(" ","",$style))
	{
		echo "<option value=\"".$sql_row['order_style_no']."\" selected>".$sql_row['order_style_no']."</option>";
	}
	else
	{
		echo "<option value=\"".$sql_row['order_style_no']."\">".$sql_row['order_style_no']."</option>";
	}

}
echo "  </select>
	</div>";
//echo '<div class="col-sm-3">
  //    <label for="usr">Schedule :</label>
   //   <input type="text" class="form-control" value="'.$schedule.'"  name=\"schedule\"  id="schedule">
   // </div>';
   

   echo "<div class='col-sm-3'><label>Select Schedule:</label> 
   <select class='form-control' name=\"schedule\"  id='schedule'>";
$sql="select distinct order_del_no from bai_pro3.bai_orders_db where order_style_no=\"$style\"";	
mysqli_query($link_ui, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_result=mysqli_query($link_ui, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_num_check=mysqli_num_rows($sql_result);

echo "<option value='".$schedule."' disabled selected>Please Select</option>";
while($sql_row=mysqli_fetch_array($sql_result))
{
 if(str_replace(" ","",$sql_row['order_del_no'])==str_replace(" ","",$schedule)){
         echo "<option value=\"".$sql_row['order_del_no']."\" selected>".$sql_row['order_del_no']."</option>";
     }
 else{
     echo "<option value=\"".$sql_row['order_del_no']."\">".$sql_row['order_del_no']."</option>";
 }
}

echo "	</select>
  </div>";

echo "<div class='col-sm-3'><label>Select Color:</label>
<select class='form-control' name=\"color\"  id='color'>";
$sql="select distinct order_col_des from bai_pro3.bai_orders_db where order_del_no= $schedule ";
    //echo $sql;
$sql_result=mysqli_query($link_ui, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_num_check=mysqli_num_rows($sql_result);
echo "<option value='".$color."' disabled selected>Please Select</option>";
   while($sql_row=mysqli_fetch_array($sql_result))
{
	if(str_replace(" ","",$sql_row['order_col_des'])==str_replace(" ","",$color)){
		echo "<option value=\"".$sql_row['order_col_des']."\" selected>".$sql_row['order_col_des']."</option>";
	}else{
		echo "<option value=\"".$sql_row['order_col_des']."\">".$sql_row['order_col_des']."</option>";
	}
}

echo "</select>
    </div>
    <br/>";
    ?>
</div>
<?php
if($schedule != "" && $color != "")
{	
//$ratio_query = "SELECT * FROM bai_orders_db_confirm  LEFT JOIN cat_stat_log ON bai_orders_db_confirm.order_tid = cat_stat_log.order_tid LEFT JOIN plandoc_stat_log ON cat_stat_log.tid = plandoc_stat_log.cat_ref WHERE  cat_stat_log.category IN ('Body','Front') AND bai_orders_db_confirm.order_del_no= $schedule  AND bai_orders_db_confirm.order_col_des ='".$color."' ";
//echo $ratio_query;

//$ratio_query = "SELECT * FROM bai_pro3.bai_orders_db_confirm LEFT JOIN bai_pro3.cat_stat_log ON bai_orders_db_confirm.order_tid = cat_stat_log.order_tid LEFT JOIN bai_pro3.plandoc_stat_log ON cat_stat_log.tid = plandoc_stat_log.cat_ref WHERE cat_stat_log.category IN ('Body','Front') AND bai_orders_db_confirm.order_del_no='529508' AND bai_orders_db_confirm.order_col_des ='DRBLU : DRESS BLUES'";
$ratio_query = "SELECT * FROM bai_pro3.bai_orders_db LEFT JOIN bai_pro3.cat_stat_log ON bai_orders_db.order_tid = cat_stat_log.order_tid LEFT JOIN bai_pro3.plandoc_stat_log ON cat_stat_log.tid = plandoc_stat_log.cat_ref WHERE cat_stat_log.category IN ('Body','Front') AND bai_orders_db.order_del_no='".$schedule."' AND TRIM(bai_orders_db.order_col_des) =trim('".$color."')";
//echo $ratio_query;
$doc_nos = [];
$ratio_result = mysqli_query($link_ui, $ratio_query) or exit("Sql Error : ratio_query".mysqli_error($GLOBALS["___mysqli_ston"]));
    $i=0;
    $max=0;
    if(mysqli_num_rows($ratio_result)>0){
        echo "<table class='table'>";
        while($row=mysqli_fetch_array($ratio_result))
        {
            $doc_nos[] = $row['doc_no'];
            if($i==0){
                echo "<thead>
                    <tr>
                        <th>Ratio</th><th>Cut No</th><th>Plies</th>";
                        for($j=1;$j<=50;$j++){
                            $sno = str_pad($j,2,"0",STR_PAD_LEFT);
                            if($row['title_size_s'.$sno]!=''){
                                echo "<th id='datatitle".$j."' data-title='s".$sno."' data-value='".$row['title_size_s'.$sno]."'>".$row['title_size_s'.$sno]."</th>";
                                $old_qty[$sno] = 0;
                                $max=$j;
                            }else{
                                break;
                            } 
                        }
                        echo "<th>Action</th>";

                echo "</tr>
                </thead><tbody>";
               $old_ratio = $row['ratio'];
               $old_pcut = [];
               $old_pplice = [];
               $end = 1;
               $old_doc_nos = [];
            }
            $i++;
            if($old_ratio==$row['ratio']){
                echo "<tr style='display:none'>
                <td>".$row['ratio']."</td>
                <td id='datarc".$row['ratio'].$end."' data-ratio = '".$row['ratio']."' data-cut='".$row['pcutno']."' data-destination='".$row['destination']."' data-dono='".$row['doc_no']."'>".$row['pcutno']."</td>
                <td>".$row['p_plies']."</td>";
                for($k=1;$k<=$max;$k++){
                    $sno = str_pad($k,2,"0",STR_PAD_LEFT);
                    echo "<td id='dataval".$row['ratio'].$k.$end."' data-title='s".$sno."' data-value='".($row['p_s'.$sno]*$row['p_plies'])."'>".($row['p_s'.$sno]*$row['p_plies'])."</td>";
                    $old_qty[$sno]+=($row['p_s'.$sno]*$row['p_plies']);
                }
                echo "<td></td>";
                echo "</tr>";
                $end++;
                $old_pcut[]=$row['pcutno'];
                $old_pplice[]=$row['p_plies'];
                $old_doc_nos[] = $row['doc_no'];

            }else{
                echo "<tr>
                <td>".$old_ratio."</td>
                <td>".implode(',',$old_pcut)."</td>
                <td>".implode(',',$old_pplice)."</td>";
                for($k=1;$k<=$max;$k++){
                    $sno = str_pad($k,2,"0",STR_PAD_LEFT);
                    echo "<td>$old_qty[$sno]</td>";
                    $old_qty[$sno]=0;
                }
                $qry_get_doc_details = "SELECT COUNT(*) AS old_jobs FROM bai_pro3.pac_stat_log_input_job WHERE doc_no IN (".implode(',',$old_doc_nos).")";
                $qry_get_doc_details_res = mysqli_query($link_ui, $qry_get_doc_details) or exit("Sql Error : qry_get_doc_details".mysqli_error($GLOBALS["___mysqli_ston"]));
                $old_cnt_jb = mysqli_fetch_array($qry_get_doc_details_res);
                if($old_cnt_jb['old_jobs']==0)
                    echo "<td><button class='btn btn-info' data-toggle='modal' data-target='#modalLoginForm' onclick='assigndata($old_ratio,$max,$end)'>Generate Jobs</button></td>";
                else
                    echo "<td><h3 class='label label-warning'>Jobs Already Created..</h3></td>";
                echo "</tr>";
                $end = 1;
                $old_ratio = $row['ratio'];
                $old_pcut = [];
                $old_pplice = [];
                $old_doc_nos = [];
                echo "<tr style='display:none'>
                <td>".$row['ratio']."</td>
                <td id='datarc".$row['ratio'].$end."' data-ratio = '".$row['ratio']."' data-cut='".$row['pcutno']."'data-destination='".$row['destination']."' data-dono='".$row['doc_no']."'>".$row['pcutno']."</td>
                <td>".$row['p_plies']."</td>";
                for($k=1;$k<=$max;$k++){
                    $sno = str_pad($k,2,"0",STR_PAD_LEFT);
                    echo "<td id='dataval".$row['ratio'].$k.$end."' data-title='s".$sno."' data-value='".($row['p_s'.$sno]*$row['p_plies'])."'>".($row['p_s'.$sno]*$row['p_plies'])."</td>";
                    $old_qty[$sno]+=($row['p_s'.$sno]*$row['p_plies']);
                }
                echo "<td></td>";
                echo "</tr>";
                $end++;
                $old_pcut[]=$row['pcutno'];
                $old_pplice[]=$row['p_plies'];
                $old_doc_nos[] = $row['doc_no'];
            }
            
            
        }
        echo "<tr>
            <td>".$old_ratio."</td>
            <td>".implode(",",$old_pcut)."</td>
            <td>".implode(',',$old_pplice)."</td>";
            for($k=1;$k<=$max;$k++){
                $sno = str_pad($k,2,"0",STR_PAD_LEFT);
                echo "<td>$old_qty[$sno]</td>";
            }
            $qry_get_doc_details = "SELECT COUNT(*) AS old_jobs FROM bai_pro3.pac_stat_log_input_job WHERE doc_no IN (".implode(',',$old_doc_nos).")";
            $qry_get_doc_details_res = mysqli_query($link_ui, $qry_get_doc_details) or exit("Sql Error : qry_get_doc_details".mysqli_error($GLOBALS["___mysqli_ston"]));
            $old_cnt_jb = mysqli_fetch_array($qry_get_doc_details_res);
            if($old_cnt_jb['old_jobs']==0)
                echo "<td><button class='btn btn-info' data-toggle='modal' data-target='#modalLoginForm' onclick='assigndata($old_ratio,$max,$end)'>Generate Jobs</button></td>";
            else
                echo "<td><h3 class='label label-warning'>Jobs Already Created..</h3></td>";
        echo "</tr>";
        echo "</tbody></table>"; 
    }else{
        echo "<script> swal('No Data Found'); </script>";
    }
    
    //=====================
    ?>
    <div class="modal fade" id="modalLoginForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     ng-app="cutjob" ng-controller="cutjobcontroller" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header text-center">
                <h4 class="modal-title w-100 font-weight-bold">Sewing Job Generation</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            
                <div class='row'>
                    <div class='col-sm-4'>
                        <label data-error="wrong" data-success="right" for="defaultForm-email">Garment per Input Job</label>
                        <input type="text" id="job-qty" class="form-control validate" ng-model= "jobcount" name="jobcount">
                    </div>
                    <div class='col-sm-4'>
                        <label data-error="wrong" data-success="right" for="defaultForm-email">Garment per Bundle</label>
                        <input type="text" id="bundle-qty" class="form-control validate" ng-model= "bundleqty" name="bundleqty">
                    </div>
                    <div class='col-sm-2'>
                        <br/><br/>
                        <button class="btn btn-success" ng-click="getjobs()">Confirm..</button>
                    </div>
                    <!--<div class='col-sm-2'>
                        <br/><br/>
                       <button class="btn btn-primary" ng-click="createjobs()">Confirm..</button>
                    </div>-->
                </div>
                <br/>
                <div ng-show='jobs.length'>
                    <table class='table' style="display:none;">
                        <thead>
                            <tr><th>#</th><th>Job ID</th><th>Bundle</th><th>Size</th><th>Quantity</th></tr>
                        </thead>
                        <tbody ng-repeat="items in fulljob">
                            <tr class='danger'><th class='text-center'>Ratio</th><th class='text-center'>{{items.ratio}}</th>
                                <td></td><th class='text-center'>Cut</th><th class='text-center'>{{items.cut}}</th></tr>
                            <tr ng-repeat="item in items.sizedetails">
                                <td>{{$index+1}}</td>
                                <td>{{item.job_id}}</td>
                                <td>{{item.bundle}}</td>
                                <td>{{item.job_size}}</td>
                                <td>{{item.job_qty}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div ng-show='!jobs.length' class='alert alert-warning'>
                    Please generate jobs..
                </div>

            </div> 
            <div class="modal-footer d-flex justify-content-center">
                <button class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<?php
    //=====================
    //echo base64_decode($_GET['r']);
} 


$url = base64_decode($_GET['r']);
$url = str_replace('\\', '/', $url);
$docnos = implode(',',$doc_nos);
?>

</div>

<script>
var app = angular.module('cutjob', []);
app.controller('cutjobcontroller', function($scope, $http) {
    $scope.jobcount = 0;
    $scope.bundleqty = 0;
    $scope.details = [];
    $scope.details_all = [];
    $scope.jobs   = [];
    $scope.fulljob = [];
    $scope.generatejobs = function(){
       if($scope.jobcount>0)
       {
           $scope.jobs   = [];
           $scope.balance = 0;
           $scope.excess = 0;
           $scope.j = 1;
        for(var i=0; i<$scope.details.length; i++)
        {
            if($scope.balance>0){
                if($scope.balance>$scope.details[i].value){
                    $scope.jobs.push({job_id : $scope.j,job_qty : $scope.details[i].value,job_size_key : $scope.details[i].key, job_size : $scope.details[i].title});
                    var quantity = 0;
                    $scope.balance = $scope.balance-$scope.details[i].value;
                    //console.log("z"+$scope.details[i].value);
                }else{
                    $scope.jobs.push({job_id : $scope.j,job_qty : $scope.balance,job_size_key : $scope.details[i].key, job_size : $scope.details[i].title});
                    var quantity = $scope.details[i].value-$scope.balance;
                    $scope.j++;
                    //console.log("a"+$scope.balance);
                    $scope.balance = 0;
                    
                    //console.log("a"+quantity);
                }
            }else{
                var quantity = $scope.details[i].value;
                $scope.balance = 0;
            }
            var total_jobs_per_size = Math.floor(quantity/$scope.jobcount);
            $scope.excess = quantity%$scope.jobcount;
            for(var pora=0;pora<Number(total_jobs_per_size);pora++){
                $scope.jobs.push({job_id : $scope.j,job_qty : $scope.jobcount,job_size_key : $scope.details[i].key, job_size : $scope.details[i].title});
                $scope.j++;
                //console.log("b"+$scope.jobcount);
            }
            if($scope.excess>0){
                $scope.jobs.push({job_id : $scope.j,job_qty : $scope.excess,job_size_key : $scope.details[i].key, job_size : $scope.details[i].title});
                $scope.balance = $scope.jobcount-$scope.excess;
                //console.log("c"+$scope.excess);
            }
        }
       }
       else
       {

       }
    }

    
    $scope.getjobs = function() {
        if(Number($scope.jobcount)>0 && Number($scope.jobcount)>=Number($scope.bundleqty)){
            $scope.fulljob = {};
           // console.log($scope.bundleqty);
            for(var ss=0;Number(ss)<$scope.details_all.length;ss++){
                //$scope.j++;
                var dummy = {};
                dummy['cut'] = $scope.details_all[ss].cut;
                dummy['ratio'] = $scope.details_all[ss].ratio;
                dummy['destination'] = $scope.details_all[ss].destination;
                dummy['dono'] = $scope.details_all[ss].dono;
                $scope.details = $scope.details_all[ss].size_details;
                $scope.generatejobs();
                var bun_jobs = $scope.genbundle($scope.jobs)
                dummy['sizedetails'] = bun_jobs;
                $scope.fulljob[ss] = dummy;
            }
            console.log($scope.fulljob);
           $scope.createjobs();
       }else{
           if(Number($scope.jobcount)<=0)
            swal('Input Job Quantity should be grater then zero.');
           if(Number($scope.jobcount)<Number($scope.bundleqty))
            swal('Bundle Quantity should be less then input job quantity.');
       }
    }
    
    $scope.createjobs = function()
    {
        //console.log($scope.fulljob);
       // alert('hi');
       console.log($scope.bundleqty);
        let url_serv = "<?= trim($url) ?>";
        let style = "<?= $style ?>";
        let schedule = "<?= $schedule ?>";
        let color = "<?= $color ?>";
        let docnos = "<?= $docnos ?>";
        //console.log(url_serv);
        // var rv = {};
        // for (var i = 0; i < $scope.fulljob.length; ++i){
        //     rv1 = {}
        //     if ($scope.fulljob[i] !== undefined) rv[i] = JSON.stringify($scope.fulljob[i]);
            
        // }
        //console.log(rv);
        var params = $.param({
        'main_data' : $scope.fulljob, 'style' : style, 'schedule' : schedule, 'color' : color,'docnos' : docnos
        });
        
            //$scope.saveinit = false;
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
                    swal('Cut Sewing jobs generated sucessfully');
                    location.reload();
                }else{
                    swal('Fail..');
                }
            });
    }
    
    $scope.genbundle = function(jobs){
        let newdummy = [];
        if($scope.bundleqty==0){
            for(let no=0;no<jobs.length;no++){
                newdummy.push({job_id : jobs[no].job_id,job_qty : jobs[no].job_qty,job_size_key : jobs[no].job_size_key, job_size : jobs[no].job_size,bundle : Number(no)+1});
            }
        }else{
            let jobno = 1;
            for(let no=0;no<jobs.length;no++){
                let total_bundles_per_job = Math.floor(jobs[no].job_qty/$scope.bundleqty);
                let excess = jobs[no].job_qty%$scope.bundleqty;
                for(let non=0;non<Number(total_bundles_per_job);non++){
                    newdummy.push({job_id : jobs[no].job_id,job_qty : $scope.bundleqty,job_size_key : jobs[no].job_size_key, job_size : jobs[no].job_size,bundle : jobno});
                    jobno++;
                }
                if(excess>0){
                    newdummy.push({job_id : jobs[no].job_id,job_qty : excess,job_size_key : jobs[no].job_size_key, job_size : jobs[no].job_size,bundle : jobno});
                    jobno++;
                }
            }
        }
        return newdummy;
    }

});
angular.bootstrap($('#modalLoginForm'), ['cutjob']);
function assigndata(s,max,end){
    var details = [];
    for(var jpg=1;Number(jpg)<Number(end);jpg++){
        var dummy = [];
        var pl_cut_id = document.getElementById('datarc'+s+jpg);
        dummy['cut'] = pl_cut_id.getAttribute('data-cut');
        dummy['ratio'] = pl_cut_id.getAttribute('data-ratio');
        dummy['destination'] = pl_cut_id.getAttribute('data-destination');
        dummy['dono'] = pl_cut_id.getAttribute('data-dono');
        dummy['size_details'] = [];
        for(var i=1;Number(i)<=Number(max);i++){
            var sp_title = document.getElementById('datatitle'+i);
            var sp_values = document.getElementById('dataval'+s+i+jpg);
            a = sp_title.getAttribute('data-title');
            b = sp_values.getAttribute('data-title');

            c = sp_title.getAttribute('data-value');
            d = sp_values.getAttribute('data-value');
            var val = {title : c, key : a, value : d};
            dummy['size_details'].push(val);
        }
        details.push(dummy);
    }
    var controllerElement = document.querySelector('[ng-controller="cutjobcontroller"]');
    var scope = angular.element(controllerElement).scope();
    scope.$apply(function () {
        scope.details_all = details;
        scope.jobcount = 0;
        scope.bundleqty = 0;
        scope.details = [];
        scope.jobs   = [];
        scope.fulljob = [];
    });
}
</script>
<?php } ?>