<?php

if(isset($_GET['variable']))
{
	$variable = $_GET['variable'];
	if($variable != '')
	{
		getscheduledata($variable);
	}
}
function getscheduledata($variable)
{
include("../../../../common/config/config.php");

	$query_get_schedule_data= "SELECT id,schedule FROM $brandix_bts.bundle_creation_data group by schedule";
	$result = $link->query($query_get_schedule_data);
	//$json = [];
   while($row = $result->fetch_assoc()){
        $json[$row['schedule']] = $row['schedule'];
   }
   echo json_encode($json);
	
}
if(isset($_GET['schedule']))
{
	$schedule = $_GET['schedule'];
	if($schedule != '')
	{
		getcolor($schedule);
	}
}
function getcolor($schedule)
{
include("../../../../common/config/config.php");
	$schedule_query = "SELECT id,color,style FROM $brandix_bts.bundle_creation_data where schedule = $schedule GROUP BY color";
	//echo $schedule_query;
	$result1 = $link->query($schedule_query);
    while($row1 = $result1->fetch_assoc()){
        $json1[$row1['color']] = $row1['color'];
		$json2 = $row1['style'];
   }
   $json['drp'] = $json1;
   $json['style'] =$json2;
   echo json_encode($json);
}
if(isset($_GET['color']))
{
	$color = $_GET['color'];
	if($color != '')
	{
		getcuts($color);
	}
}
function getcuts($color)
{
	$color = explode(",",$color);
include("../../../../common/config/config.php");
   $query_dep_ops = "SELECT tr.operation_code,tr.operation_name,ts.operation_sequence,ts.component FROM $brandix_bts.bundle_creation_data ts LEFT JOIN $brandix_bts.tbl_orders_ops_ref tr ON tr.operation_code=ts.operation_id WHERE style='$color[0]'  AND color = '$color[1]' AND schedule = '$color[2]' GROUP BY operation_code ORDER BY ts.bundle_number";
  //echo $query_dep_ops;
   $result_query_dep_ops = $link->query($query_dep_ops);
	while($row_result_query_dep_ops = $result_query_dep_ops->fetch_assoc()) 
	{
		$value_to_show = $row_result_query_dep_ops['operation_code']."-".$row_result_query_dep_ops['operation_name']."(".$row_result_query_dep_ops['component'].")";
		$json1[$row_result_query_dep_ops['operation_code']] = $value_to_show;
	}
   echo json_encode($json1);
}


?>