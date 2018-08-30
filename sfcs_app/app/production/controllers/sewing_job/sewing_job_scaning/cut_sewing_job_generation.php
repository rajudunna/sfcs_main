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

$ratio_query = "SELECT * FROM bai_orders_db_confirm  LEFT JOIN cat_stat_log ON 
bai_orders_db_confirm.order_tid = cat_stat_log.order_tid LEFT JOIN plandoc_stat_log ON 
cat_stat_log.tid = plandoc_stat_log.cat_ref WHERE  cat_stat_log.category IN ('Body','Front') 
AND bai_orders_db_confirm.order_del_no='529508' AND 
bai_orders_db_confirm.order_col_des ='DRBLU : DRESS BLUES' ";
echo $ratio_query;


}   
?>

</div>