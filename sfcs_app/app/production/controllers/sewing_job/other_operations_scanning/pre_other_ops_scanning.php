<?php
    include(getFullURLLevel($_GET['r'],'common/config/config.php',5,'R'));
	include(getFullURLLevel($_GET['r'],'common/config/functions.php',5,'R'));
?>

<script>
function firstbox()
{
	window.location.href ="<?= 'index.php?r='.$_GET['r']; ?>&category="+document.other_operation_report.category.value
}


$(document).ready(function() {
	$('#operation').on('click',function(e){
		var category = $('#category').val();
		if(category == null){
			sweetAlert('Please Select category','','warning');
		}
	});
	$('#shift').on('click',function(e){
		var category = $('#category').val();
		var operation = $('#operation').val();
		if(category == null && operation == null){
			sweetAlert('Please Select category and operation','','warning');
		}
		else if(operation == null){
			sweetAlert('Please Select operation','','warning');
			document.getElementById("submit").disabled = true;
		}
		else {
			document.getElementById("submit").disabled = false;
		}
	});
});

</script>
<!-- <link href="style.css" rel="stylesheet" type="text/css" /> -->
<?php echo '<link href="'."http://".$_SERVER['HTTP_HOST']."/sfcs/styles/sfcs_styles.css".'" rel="stylesheet" type="text/css" />'; ?>

<?php
	//include("menu_content.php");
	$category=$_GET['category'];
	$operation=$_GET['operation']; 
	$shift=$_GET['shift'];
?>

<div class = "panel panel-primary">
<div class = "panel-heading">Other Operation Reporting</div>
<div class = "panel-body">
<form name="other_operation_report" method="post">
<?php

$sql = "SELECT DISTINCT category FROM $brandix_bts.tbl_orders_ops_ref WHERE restriction='no'";	
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_num_check=mysqli_num_rows($sql_result);
echo "<div class=\"row\"><div class=\"col-sm-3\"><label>Select category:</label><select class='form-control' name=\"category\"  id=\"category\" onchange=\"firstbox();\" >";

echo "<option value=''  selected>Please Select</option>";
while($sql_row=mysqli_fetch_array($sql_result))
{
	$main_category = $sql_row['category'];

	if(str_replace(" ","",$sql_row['category'])==str_replace(" ","",$category))
	{
		echo "<option value=\"".$sql_row['category']."\" selected>".$sql_row['category']."</option>";
	}
	else
	{
		echo "<option value=\"".$sql_row['category']."\">".$sql_row['category']."</option>";
	}

}
echo "  </select>
	</div>";
?>
<?php
	 $query_get_schedule_data= "SELECT tm.operation_code,tm.operation_name FROM $brandix_bts.tbl_orders_ops_ref tm
		WHERE tm.operation_code  
		AND category IN ('$category')  AND display_operations='yes'
	    GROUP BY tm.operation_code ORDER BY tm.operation_code";
	    //echo $query_get_schedule_data;
		$result = $link->query($query_get_schedule_data);
		while($row = mysqli_fetch_array($result))
		{
			$ops_array[$row['operation_code']] = $row['operation_name'];
		}
?>
			<div class="col-sm-3">
                <label for="title">Select Operation:<span data-toggle="tooltip" data-placement="top" title="It's Mandatory field"><font color='red'>*</font></span></label>
                <select class="form-control select2"  name="operation_code" id="operation" required>
                    <option value="">Select Operation</option>
                    <?php
                        foreach($ops_array as $key=>$value)
                        {
                            echo "<option value='$key'>$value - $key</option>"; 
                        }
                    ?>
                </select>
            </div>
            
			<div class="col-sm-3">
                <label>Shift:<span style="color:red">*</span></label>
                <select class="form-control shift"  name="shift" id="shift" style="width:100%;" required>
                    <option value="">Select Shift</option>
                    <?php 
                        for ($i=0; $i < sizeof($shifts_array); $i++) {?>
                            <option  <?php echo 'value="'.$shifts_array[$i].'"'; if($_GET['shift']==$shifts_array[$i]){ echo "selected";}   ?>><?php echo $shifts_array[$i] ?></option>
                        <?php }
                    ?>
                </select>
            </div>
			</br>
            
            <input type="button" id="continue" name="continue" class="btn btn-success" value="CONTINUE" onclick="fun()">
        </div>
    </form>
    </div>
</div>


<?php
    if($category == 'cutting')
	{
		$url = getFullURLLEVEL($_GET['r'],'cut_other_operation_scanning.php',0,'N');
	}
	else if($category == 'packing')
	{
		$url = getFullURLLEVEL($_GET['r'],'packing/controllers/central_packing/carton_scan_select_user.php',4,'N');
	}
	echo "<script>
	function fun() {
		var operation = document.getElementById('operation').value;
		var shift = document.getElementById('shift').value;
		if(operation && shift)
		window.location = '$url&operation_id='+operation+'&shift='+shift; 
	}
	</script>";
?>
