<?php
/* ===============================================================
               Created By : Sudheer and Chandu
Created : 30-08-2018
Updated : 30-08-2018
input : Schedule,color & cutjob count.
output v0.1: Generate jobs.
=================================================================== */
?>
<script>

$(document).ready(function(){
	var url1 = '?r=<?= $_GET['r'] ?>';
    console.log(url1);
    $("#schedule").change(function(){
        var input = $(this);
       var val = input.val();
        // alert(val);
     window.location.href =url1+"&schedule="+val;
    });

    $("#color").change(function(){
        //alert("The text has been changed.");
		var optionSelected = $("option:selected", this);
       var valueSelected2 = this.value;
       var schedule = $("#schedule").val();
       window.location.href =url1+"&schedule="+schedule+"&color="+valueSelected2
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
$schedule=$_GET['schedule']; 
$color  = $_GET['color'];
echo '<div class = "panel-body">
<div class="col-sm-3">
      <label for="usr">Schedule :</label>
      <input type="text" class="form-control" value="'.$schedule.'"  name=\"schedule\"  id="schedule">
    </div>';
$sql="select distinct order_col_des from bai_pro3.bai_orders_db where order_del_no= $schedule ";
    //echo $sql;
$sql_result=mysqli_query($link_ui, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_num_check=mysqli_num_rows($sql_result);
echo "<div class='col-sm-3'><label>Select Color:</label>
<select class='form-control' name=\"color\"  id='color'>";

echo "<option value='' disabled selected>Please Select</option>";
	
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
    <br/>
    <input type='submit' class='btn btn-info' value='Search'>";
    ?>
</div>
<?php
if($schedule != "" && $color != "")
{	
//$ratio_query = "SELECT * FROM bai_orders_db_confirm  LEFT JOIN cat_stat_log ON bai_orders_db_confirm.order_tid = cat_stat_log.order_tid LEFT JOIN plandoc_stat_log ON cat_stat_log.tid = plandoc_stat_log.cat_ref WHERE  cat_stat_log.category IN ('Body','Front') AND bai_orders_db_confirm.order_del_no= $schedule  AND bai_orders_db_confirm.order_col_des ='".$color."' ";
//echo $ratio_query;

$ratio_query = "SELECT * FROM bai_pro3.bai_orders_db_confirm LEFT JOIN bai_pro3.cat_stat_log ON bai_orders_db_confirm.order_tid = cat_stat_log.order_tid LEFT JOIN bai_pro3.plandoc_stat_log ON cat_stat_log.tid = plandoc_stat_log.cat_ref WHERE cat_stat_log.category IN ('Body','Front') AND bai_orders_db_confirm.order_del_no='529508' AND bai_orders_db_confirm.order_col_des ='DRBLU : DRESS BLUES'";
$ratio_result = mysqli_query($link_ui, $ratio_query) or exit("Sql Error : ratio_query".mysqli_error($GLOBALS["___mysqli_ston"]));
    $i=0;
    $max=0;
    if(mysqli_num_rows($ratio_result)>0){
        echo "<table class='table'>";
        while($row=mysqli_fetch_array($ratio_result))
        {
            if($i==0){
                echo "<thead>
                    <tr>
                        <th>Ratio</th><th>Cut No</th><th>P Plies</th>";
                        for($j=1;$j<=50;$j++){
                            $sno = str_pad($j,2,"0",STR_PAD_LEFT);
                            if($row['title_size_s'.$sno]!=''){
                                echo "<th>".$row['title_size_s'.$sno]."</th>";
                                $max=$j;
                            }else{
                                break;
                            } 
                        }
                        echo "<th>Action</th>";

                echo "</tr>
                </thead><tbody>";
                $i++;
            }

            echo "<tr>
                <td>".$row['ratio']."</td>
                <td>".$row['pcutno']."</td>
                <td>".$row['p_plies']."</td>";
            for($k=1;$k<=$max;$k++){
                $sno = str_pad($k,2,"0",STR_PAD_LEFT);
                echo "<td>".($row['p_s'.$sno]*$row['p_plies'])."</td>";
            }
            echo "<td><button class='btn btn-info' data-toggle='modal' data-target='#modalLoginForm'>Generate Jobs</button></td>";
            echo "</tr>";
        }
        echo "</tbody></table>"; 
    }
    //=====================
    echo '<div class="modal fade" id="modalLoginForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     ng-app="cutjob" ng-controller="cutjobcontroller" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header text-center">
                <h4 class="modal-title w-100 font-weight-bold">Sewing Job Generation</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body mx-3">
                <div class="md-form mb-5">
                    <i class="fa fa-envelope prefix grey-text"></i>
                    <input type="text" id="defaultForm-job" class="form-control validate" ng-model= "jobcount" id="jobcount" name="jobcount">
                    <label data-error="wrong" data-success="right" for="defaultForm-email">Input Job Count</label>
                </div> </div>
            <div class="modal-footer d-flex justify-content-center">
                <button class="btn btn-default" ng-click="getjobs()">Submit</button>
            </div>
        </div>
    </div>
</div>';
    //=====================
} 
?>

</div>

<script>
var app = angular.module('cutjob', []);
app.controller('cutjobcontroller', function($scope, $http) {
    $scope.jobcount = "";
    
    $scope.getjobs = function(){
     alert($scope.jobcount);
    };



});
angular.bootstrap($('#modalLoginForm'), ['cutjob']);
</script>