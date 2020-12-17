<?php
include("../../../../../common/config/functions_dashboard.php");
if(isset($_GET['params1']))
{
	$params1 = $_GET['params1'];
	if($params1 != '')
	{
		Getdata1($params1);
	}
}



/*Ravi*/
//getting schedule basing on style
if(isset($_GET['pro_style_schedule']))
{
	$pro_style = style_decode($_GET['pro_style_schedule']);
	if($pro_style != '')
	{
		getscheduledata1($pro_style);
	}
}
function getscheduledata1($pro_style)
{
include("../../../../../common/config/config_ajax.php");
	$query_get_schedule_data= "select id,schedule from $brandix_bts.bundle_creation_data_temp where style='$pro_style' group by style,schedule";
	$result = $link->query($query_get_schedule_data);
   while($row = $result->fetch_assoc()){
        $json[$row['id']] = $row['schedule'];
   }
   echo json_encode($json);
	
}
/*Ravi*/
//getting color basing on schedule
if(isset($_GET['pro_schedule_color']))
{
	$pro_style = $_GET['pro_schedule_color'];
	if($pro_style != '')
	{
		getcolordata($pro_style);
	}
}
function getcolordata($pro_style)
{
include("../../../../../common/config/config_ajax.php");
	$query_get_schedule_data= "select id,color from $brandix_bts.bundle_creation_data_temp where schedule='$pro_style' group by schedule,color";
	$result = $link->query($query_get_schedule_data);
   while($row = $result->fetch_assoc()){
        $json[$row['id']] = $row['color'];
   }
   echo json_encode($json);
	
}

/*Ravi*/
//getting bundle numbers basing on color
if(isset($_GET['color_name']) && isset($_GET['style_name']) && isset($_GET['schedule_name']))
{
	$color_name = color_decode($_GET['color_name']);
	$style_name = style_decode($_GET['style_name']);
	$schedule_name = $_GET['schedule_name'];
	if($color_name != '' && $style_name != '' && $schedule_name != '')
	{
		getbundleno($color_name,$style_name,$schedule_name);
	}
}

function getbundleno($color_name,$style_name,$schedule_name)
{
include("../../../../../common/config/config_ajax.php");
	$query_get_schedule_data= "select input_job_no,operation_id from $brandix_bts.bundle_creation_data_temp where schedule='$schedule_name' AND style='$style_name' AND color='$color_name' group by input_job_no order by operation_id,input_job_no";
	// echo $query_get_schedule_data;
	$result = $link->query($query_get_schedule_data);
   while($row = $result->fetch_assoc()){
        $val = $row['operation_id']."-".$row['input_job_no'];
        $json[$row['input_job_no']] = $val;
   }
   echo json_encode($json);
	
}



/*Ravi*/
//getting table data
function Getdata1($params1)
{
	$params1 = explode(",",$params1);
	include("../../../../../common/config/config_ajax.php");
	$style_val = style_decode($params1[1]);
	$color_val = color_decode($params1[0]);
	$bund_transactions="SELECT bcd.bundle_number,bcd.size_title,sum(bcd.recevied_qty) as recevied_qty,sum(bcd.rejected_qty) as rejected_qty,tor.operation_name,remarks,bcd.input_job_no,bcd.operation_id,tor.category FROM $brandix_bts.bundle_creation_data_temp bcd left join $brandix_bts.tbl_orders_ops_ref tor on tor.operation_code=bcd.operation_id WHERE style='$style_val' AND schedule='$params1[2]' AND color='$color_val' AND input_job_no='$params1[3]' group by bcd.bundle_number,bcd.operation_id order by bcd.bundle_number,bcd.operation_id,bcd.id";
	
	// echo $bund_transactions;
	
	$result_style_data = $link->query($bund_transactions);
	while($row2 = $result_style_data->fetch_assoc()) 
	{
		$result_array[] = $row2;
	}
	$json_data = json_encode($result_array);
	echo $json_data;
	
}
?>