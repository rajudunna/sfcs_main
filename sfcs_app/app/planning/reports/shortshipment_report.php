<?php
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/functions_dashboard.php',3,'R'));
?>
<?php include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/menu_content.php',3,'R')); ?>

<script>

//<form name="test" action="<?php echo getURL(getBASE($_GET['r'])['path'])['url']; ?>" method="post">

function firstbox()
{
	window.location.href ="<?= 'index.php?r='.$_GET['r']; ?>&style="+window.btoa(unescape(encodeURIComponent(document.test.style.value)))
}

function secondbox()
{
	var uriVal = "<?= 'index.php?r='.$_GET['r']; ?>&style="+window.btoa(unescape(encodeURIComponent(document.test.style.value)))+"&schedule="+document.test.schedule.value;
	window.location.href = uriVal;
}

$(document).ready(function() {
	// $('#schedule').on('click',function(e){
	// 	var style = $('#style').val();
	// 	if(style == null){
	// 		sweetAlert('Please Select Style','','warning');
	// 	}
	// });
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

    $style=style_decode($_GET['style']);
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
echo "<div class=\"row\"><div class=\"col-sm-2\"><label>Select Style:</label><select class='form-control' name=\"style\"  id=\"style\" onchange=\"firstbox();\" id='style'>";

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

    echo "<div class='col-sm-2'><label>Select Schedule:</label> 
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
        <input type="text" size="8" data-toggle="datepicker" class="form-control" name="date" id="date" value="<?php  if(isset($_POST['date'])) { echo $_POST['date']; } else { echo ''; } ?>" />
    </div>
    <br/>
    <div class="col-sm-2">
        <input class="btn btn-primary" type="submit" value="Submit" name="submit">
    </div>
</div>

</form>

<?php
if(isset($_POST['submit']))
{
    // var_dump($_POST);
    if($_POST['style'] != null || $_POST['schedule'] != null || $_POST['remove_type'] != null || $_POST['date'] != null){
        
        // var_dump($type);
        $srt_shipment_data = "select * from $bai_pro3.short_shipment_job_track where id > 0 and remove_type in('1','2')";
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
            
            echo "<hr/>";
            echo "<table class = 'table' id = 'shortshipmentjobReport'>
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
            echo "<script>swal('No Short Shipment Jobs Found.','','warning');</script>";
            
        }
    }else{
        echo "<script>swal('Please Select Atleast One field','','warning');</script>";
    } 
	
}
?>
<script>
    $(document).ready(function() {
    $('#shortshipmentjobReport').DataTable();
} );
</script>
<style>
table th
{
	border: 1px solid grey;
	text-align: center;
    background-color: #003366;
	color: WHITE;
	white-space:nowrap; 
	padding-left: 5px;
	padding-right: 5px;
}
table{
	white-space:nowrap; 
	border-collapse:collapse;
	font-size:12px;
	background-color: white;
}
table tr
{
	border: 1px solid grey;
	text-align: right;
	white-space:nowrap; 
}

table td
{
	border: 1px solid grey;
	text-align: center;
	white-space:nowrap;
	color:black;
}
</style>