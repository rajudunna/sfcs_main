<?php
    include(getFullURLLevel($_GET['r'],'common/config/config.php',5,'R'));
	include(getFullURLLevel($_GET['r'],'common/config/functions.php',5,'R'));
	include(getFullURLLevel($_GET['r'],'controllers/sewing_job/other_operation_report/cutting.php',5,'R'));
	include(getFullURLLevel($_GET['r'],'controllers/sewing_job/other_operation_report/packing.php',5,'R'));
	// $url = getFullURLLEVEL($_GET['r'],'cutting.php',0,'N');
	// $url1 = getFullURLLEVEL($_GET['r'],'packing.php',0,'N');
    $category1="'cutting','packing'";
	$query_get_schedule_data= "SELECT tm.operation_code,tm.operation_name FROM $brandix_bts.tbl_orders_ops_ref tm
	WHERE tm.operation_code  
	AND category IN ($category1)  AND display_operations='yes'
    GROUP BY tm.operation_code ORDER BY tm.operation_code";
	$result = $link->query($query_get_schedule_data);
	while($row = $result->fetch_assoc()){
		$ops_array[$row['operation_code']] = $row['operation_name'];
	}
	// var_dump($ops_array);
	// $cat = array("cutting", "packing");
	
	
?>

<script>

//<form name="test" action="<?php echo getURL(getBASE($_GET['r'])['path'])['url']; ?>" method="post">

function firstbox()
{
	window.location.href ="<?= 'index.php?r='.$_GET['r']; ?>&category="+document.other_operation_report.category.value
}

function secondbox()
{
	var uriVal = "<?= 'index.php?r='.$_GET['r']; ?>&category="+document.other_operation_report.category.value+"&operation="+document.other_operation_report.operation.value;
	window.location.href = uriVal;
}

function thirdbox()
{
	var uriVal = "<?= 'index.php?r='.$_GET['r']; ?>&category="+document.other_operation_report.category.value+"&operation="+document.other_operation_report.operation.value+"&shift="+encodeURIComponent(document.other_operation_report.shift.value);
	window.location.href = uriVal;
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
<div class = "panel-heading">Other Operation Report</div>
<div class = "panel-body">
<form name="other_operation_report" method="post">
<?php
include('dbconf.php');
//$sql="select distinct order_style_no from bai_orders_db where order_tid in (select order_tid from plandoc_stat_log)";
//if(isset($_SESSION['SESS_MEMBER_ID']) || (trim($_SESSION['SESS_MEMBER_ID']) != '')) 
//{
	//$sql="select distinct order_style_no from bai_orders_db where left(order_style_no,1) in (".$global_style_codes.")";

	$sql = "SELECT DISTINCT category FROM $brandix_bts.tbl_orders_ops_ref WHERE restricted='no' AND(category='cutting' OR category='packing')";	
//}
//echo $sql;exit;

$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_num_check=mysqli_num_rows($sql_result);
echo "<div class=\"row\"><div class=\"col-sm-3\"><label>Select category:</label><select class='form-control' name=\"category\"  id=\"category\" onchange=\"firstbox();\" >";

echo "<option value=''  selected>Please Select</option>";
while($sql_row=mysqli_fetch_array($sql_result))
{

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
<script>

// $(document).ready(function() {
// 	$('#continue').on('click',function(e){
// 		var cutting = $('#category').val();
// 		alert(cutting);
// 		if(cutting == null){
// 			var myUrl = "cutting.php";

// 		}
// 	});
	
// 		else (packing == null){
// 			var myUrl = "packing.php";
		
// 	});
// });
</script>
<!-- 
<script>
function fun() { var i = $('#category').val(); 
//alert(i);
if (i == 'cutting') window.location = "http://localhost//index.php?r=L3NmY3NfYXBwL2FwcC9wcm9kdWN0aW9uL2NvbnRyb2xsZXJzL3Nld2luZ19qb2Ivb3RoZXJfb3BlcmF0aW9uX3JlcG9ydC9jdXR0aW5nLnBocA=="; 
else window.location = "http://localhost//index.php?r=L3NmY3NfYXBwL2FwcC9wcm9kdWN0aW9uL2NvbnRyb2xsZXJzL3Nld2luZ19qb2Ivb3RoZXJfb3BlcmF0aW9uX3JlcG9ydC9wYWNraW5nLnBocA=="; 
}
</script> -->

<?php
	$url = getFullURLLEVEL($_GET['r'],'cutting.php',0,'N');
	$url1 = getFullURLLEVEL($_GET['r'],'packing.php',0,'N');

echo "<script>
function fun() { var i = $('#category').val(); 
//alert(i);
if (i == 'cutting') window.location = '$url'; 
else window.location = '$url1'; 
}
</script>";
?>