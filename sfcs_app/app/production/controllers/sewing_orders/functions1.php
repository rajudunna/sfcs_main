<?php

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
	$pro_style = $_GET['pro_style_schedule'];
	if($pro_style != '')
	{
		getscheduledata1($pro_style);
	}
}
function getscheduledata1($pro_style)
{
include("../../../../common/config/config.php");
	$query_get_schedule_data= "select id,schedule from $brandix_bts.bundle_creation_data where style='$pro_style' group by style";
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
include("../../../../common/config/config.php");
	$query_get_schedule_data= "select id,color from $brandix_bts.bundle_creation_data where schedule='$pro_style' group by schedule";
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
	$color_name = $_GET['color_name'];
	$style_name = $_GET['style_name'];
	$schedule_name = $_GET['schedule_name'];
	if($color_name != '' && $style_name != '' && $schedule_name != '')
	{
		getbundleno($color_name,$style_name,$schedule_name);
	}
}

function getbundleno($color_name,$style_name,$schedule_name)
{
include("../../../../common/config/config.php");
	$query_get_schedule_data= "select id,bundle_number from $brandix_bts.bundle_creation_data where schedule='$schedule_name' AND style='$style_name' AND color='$color_name' group by bundle_number";
	$result = $link->query($query_get_schedule_data);
   while($row = $result->fetch_assoc()){
        $json[$row['id']] = $row['bundle_number'];
   }
   echo json_encode($json);
	
}



/*Ravi*/
//getting table data
function Getdata1($params1)
{
	$params1 = explode(",",$params1);

// error_reporting (0);
include("../../../../common/config/config.php");

	
	$bund_transactions="SELECT bcd.bundle_number,bcd.size_title,bcd.send_qty,bcd.recevied_qty,bcd.missing_qty,bcd.rejected_qty,tor.operation_name FROM $brandix_bts.bundle_creation_data bcd left join $brandix_bts.tbl_orders_ops_ref tor on tor.operation_code=bcd.operation_id WHERE style='$params1[1]' AND schedule='$params1[2]' AND color='$params1[0]' AND bundle_number='$params1[3]'";
	
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