<?php
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
?>
<?php include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/menu_content.php',3,'R')); ?>

<script>

//<form name="test" action="<?php echo getURL(getBASE($_GET['r'])['path'])['url']; ?>" method="post">

function firstbox()
{
	window.location.href ="<?= 'index.php?r='.$_GET['r']; ?>&style="+document.test.style.value
}

function secondbox()
{
	var uriVal = "<?= 'index.php?r='.$_GET['r']; ?>&style="+document.test.style.value+"&schedule="+document.test.schedule.value;
	window.location.href = uriVal;
}

$(document).ready(function() {
	$('#schedule').on('click',function(e){
		var style = $('#style').val();
		if(style == null){
			sweetAlert('Please Select Style','','warning');
		}
	});
});

// function validate(){
// 	// $('#submit').on('click',function(e){
//     var style = $('#style').val();
//     var schedule = $('#schedule').val();
//     var remove_type = $('#remove_type').val();
//     // $('#style').val(style);
//     // alert("style:"+style+"sch:"+schedule+"type:"+remove_type);
//     if(style == null && schedule == null && remove_type == null ){
//         sweetAlert('Please Selet Style','','warning');
//     }
//     // });
// }

</script>
<link href="style.css" rel="stylesheet" type="text/css" />
<?php echo '<link href="'."http://".$_SERVER['HTTP_HOST']."/sfcs/styles/sfcs_styles.css".'" rel="stylesheet" type="text/css" />'; ?>

<?php
if(isset($_POST['submit']))
{
    $style=$_POST['style'];
    $schedule=$_POST['schedule'];
    $type=$_POST['remove_type'];
    $date=$_POST['date'];
}else{

    $style=$_GET['style'];
    $schedule=$_GET['schedule']; 
}
	//include("menu_content.php");
?>

<div class = "panel panel-primary">
<div class = "panel-heading">Short Shiment Jobs Report</div>
<div class = "panel-body">
<form name="test" action="<?php echo getFullURLLevel($_GET['r'],'shortshipment_report.php','0','N'); ?>" method="post">

<?php
// include('dbconf.php');
$sql="select distinct order_style_no from bai_pro3.bai_orders_db";
    // var_dump($link);	
$sql_result=mysqli_query($link, $sql) or exit("Sql Error1".mysqli_error($link));
$sql_num_check=mysqli_num_rows($sql_result);
echo "<div class=\"row\"><div class=\"col-sm-3\"><label>Select Style:</label><select class='form-control' name=\"style\"  id=\"style\" onchange=\"firstbox();\" id='style'>";

echo "<option value='' disabled selected>Please Select</option>";
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
?>

<?php

echo "<div class='col-sm-3'><label>Select Schedule:</label> 
	  <select class='form-control' name=\"schedule\" id=\"schedule\" onchange=\"secondbox();\" id='schedule'>";

	$sql="select distinct order_del_no from $bai_pro3.bai_orders_db where order_style_no=\"$style\"";	

mysqli_query($link, $sql) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_num_check=mysqli_num_rows($sql_result);

echo "<option value='' disabled selected>Please Select</option>";
while($sql_row=mysqli_fetch_array($sql_result))
{
	if(str_replace(" ","",$sql_row['order_del_no'])==str_replace(" ","",$schedule)){
        // if()
			echo "<option value=\"".$sql_row['order_del_no']."\" selected>".$sql_row['order_del_no']."</option>";
		}
	else{
		echo "<option value=\"".$sql_row['order_del_no']."\">".$sql_row['order_del_no']."</option>";
	}
}

echo "	</select>
	 </div>";
?>
<div class='col-sm-3'><label>Select Type:</label> 
    <select id="remove_type" class="form-control" data-role="select" selected="selected" name="remove_type"  data-parsley-errors-container="#errId3">
        <?php
        if(1 == $type){
            $tmp_sel = "selected";
        }
        if(2 == $type){
            $per_sel = "selected";
        }
            echo '<option value=" " disabled selected>Please Select</option>';
            echo '<option value="1" '.$tmp_sel.'>Temporary</option>';
            echo '<option value="2" '.$per_sel.'>Permanent</option>';
        ?>
    </select>
	  
</div>

<div class="col-sm-3">
<label>Select Date:</label>
    <input type="text" size="8" data-toggle="datepicker" class="form-control" name="date" id="date" value="<?php  if(isset($_POST['date'])) { echo $_POST['date']; } else { echo date("Y-m-d"); } ?>" />
</div>
</div><br/>
<div class = "row">
    <div class="col-sm-3">
        <input class="btn btn-primary" type="submit" value="Submit" name="submit">
    </div>
</div>

</form>

<hr/>
<?php
if(isset($_POST['submit']))
{
    // var_dump($_POST['date']);
    if($_POST['style'] != null || $_POST['schedule'] != null || $_POST['type'] != null || $_POST['date'] != null){

        // var_dump($type);
        $srt_shipment_data = "select * from $bai_pro3.short_shipment_job_track where id > 0";
        if($date){
            $srt_shipment_data.= " and date(date_time) = '$date'";
        }
        if($style){
            $srt_shipment_data.= " and style = '$style'";
        }
        if($schedule){
            $srt_shipment_data.= " and schedule = '$schedule'";
        }
        if($type){
            $srt_shipment_data.= " and remove_type = '$type'";
        }
        $srt_shipment_data.= " order by id";
        // echo $srt_shipment_data;
        $srt_shipment_data_result=mysqli_query($link, $srt_shipment_data) or exit("Sql Error4".mysqli_error($GLOBALS["___mysqli_ston"]));
        $s_no = 0;
        if(mysqli_num_rows($srt_shipment_data_result) > 0 ){
    
            echo "<table class = 'table' border = 1 >
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Removed date</th>
                        <th>Style</th>
                        <th>Schedule</th>
                        <th>Type</th>
                        <th>Reason</th>
                        <th>Removed By</th>
                    </tr>
                    </thead>";
            while($sql_ims_rowx=mysqli_fetch_array($srt_shipment_data_result, MYSQLI_ASSOC))
            {
                $s_no += 1;
                if($sql_ims_rowx['remove_type'] == 1){
                    $type = 'Temporary'; 
                }
                if($sql_ims_rowx['remove_type'] == 2){
                    $type = 'Permanent'; 
                }
                echo "<tr>
                    <td>".$s_no."</td>
                    <td>".date('d-m-Y',strtotime($sql_ims_rowx['date_time']))."</td>
                    <td>".$sql_ims_rowx['style']."</td>
                    <td>".$sql_ims_rowx['schedule']."</td>
                    <td>".$type."</td>
                    <td>".$sql_ims_rowx['remove_reason']."</td>
                    <td>".$sql_ims_rowx['removed_by']."</td>
                </tr>";
                       
            }
                // var_dump(mysqli_fetch_array($srt_shipment_data_result, MYSQLI_ASSOC));die();
            echo "</table>";
        }else{
            echo "<hr><center><h3><span class='label label-warning'>!No Short Shipment Jobs Found</span></h3></center>";
            
        }
    }else{
        echo "<hr><center><h3><span class='label label-warning'>!Please Select</span></h3></center>";
    } 
	
}
?>