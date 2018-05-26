<?php
if(isset($_GET['style']))
{
	$style = $_GET['style'];
	if($style != '')
	{
		getschedules($style);
	}
}
function getschedules($style)
{
	include("dbconf1.php");

	// Create connection
		$conn = new mysqli($servername, $username, $password, $dbname);
	// Check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}else{
		//echo "Connection Success";
	}
	$schedule_query = "SELECT id,schedule FROM bundle_creation_data where style = '$style' GROUP BY schedule";
	$result1 = $conn->query($schedule_query);
    while($row1 = $result1->fetch_assoc()){
        $json1[$row1['schedule']] = $row1['schedule'];
   }
   echo json_encode($json1);
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
	include("dbconf1.php");

	// Create connection
		$conn = new mysqli($servername, $username, $password, $dbname);
	// Check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}else{
		//echo "Connection Success";
	}
	$schedule_query = "SELECT id,color FROM bundle_creation_data where schedule = $schedule GROUP BY color";
	//echo $schedule_query;
	$result1 = $conn->query($schedule_query);
    while($row1 = $result1->fetch_assoc()){
        $json1[$row1['color']] = $row1['color'];
   }
   echo json_encode($json1);
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
	include("dbconf1.php");

	// Create connection
		$conn = new mysqli($servername, $username, $password, $dbname);
	// Check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}else{
		//echo "Connection Success";
	}
	$schedule_query = "SELECT id,cut_number FROM bundle_creation_data WHERE style='$color[0]' AND SCHEDULE='$color[1]' AND color = '$color[2]' GROUP BY cut_number";
	//echo $schedule_query;
	$result1 = $conn->query($schedule_query);
    while($row1 = $result1->fetch_assoc()){
        $json2[$row1['cut_number']] = $row1['cut_number'];
   }
   $result_array['data_cut'] = $json2;
   $sew_out_qry = "SELECT OperationNumber FROM bai_pro3.Schedule_Oprations_Master WHERE Style='$color[0]' AND Description='$color[2]' AND ScheduleNumber='$color[1]' AND Main_OperationNumber = 130";
  // echo $sew_out_qry;
   $result_sew_out_qry = $conn->query($sew_out_qry);
   if ($result_sew_out_qry->num_rows > 0) 
   {
		while($row = $result_sew_out_qry->fetch_assoc())
		{
			$sew_out_ops = $row['OperationNumber'];
		}
	}
	else
	{
		$sew_out_qry = "SELECT OperationNumber FROM bai_pro3.Schedule_Oprations_Master_backup WHERE Style='$color[0]' AND Description='$color[2]' AND ScheduleNumber='$color[1]' AND Main_OperationNumber = 130";
		$result_sew_out_qry = $conn->query($sew_out_qry);
		while($row = $result_sew_out_qry->fetch_assoc())
		{
			$sew_out_ops = $row['OperationNumber'];
		}
	}
   $query_dep_ops = "SELECT ts.id,ts.operation_code,tr.operation_name FROM tbl_style_ops_master ts LEFT JOIN tbl_orders_ops_ref tr ON tr.id=ts.operation_name WHERE style='$color[0]'  AND color = '$color[2]' AND ts.operation_code > $sew_out_ops AND tr.type like '%Garment%' AND ts.operation_code != 200 AND ts.ops_dependency =0 GROUP BY operation_name ORDER BY ts.id";
  //echo $query_dep_ops;
   $result_query_dep_ops = $conn->query($query_dep_ops);
	while($row_result_query_dep_ops = $result_query_dep_ops->fetch_assoc()) 
	{
		$json1[$row_result_query_dep_ops['operation_code']] = $row_result_query_dep_ops['operation_name'];
	}
	$result_array['data_ops'] = $json1;
   echo json_encode($result_array);
}
if(isset($_GET['params']))
{
	$params = $_GET['params'];
	if($params != '')
	{
		gettabledata($params);
	}
}
function gettabledata($params)
{
	$params = explode(",",$params);
	include("dbconf1.php");

	// Create connection
		$conn = new mysqli($servername, $username, $password, $dbname);
	// Check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}else{
		//echo "Connection Success";
	}
	$query_checking = "select count(*)as cnt from tbl_garmet_ops_track where operation_id = $params[4] and style='$params[0]' AND SCHEDULE='$params[1]' AND color = $params[2] AND cut_number = $params[3]";
	//echo $query_checking;
	$result_chck = $conn->query($query_checking);
	while($row = $result_chck->fetch_assoc())
	{
		$count = $row['cnt'];
	}
	$sew_out_qry = "SELECT OperationNumber FROM bai_pro3.Schedule_Oprations_Master WHERE Style='$params[0]' AND Description=$params[2] AND ScheduleNumber='$params[1]' AND Main_OperationNumber = 130";
   //echo $sew_out_qry;
   $result_sew_out_qry = $conn->query($sew_out_qry);
   if ($result_sew_out_qry->num_rows > 0) 
   {
		while($row = $result_sew_out_qry->fetch_assoc())
		{
			$sew_out_ops = $row['OperationNumber'];
		}
	}
	else
	{
		$sew_out_qry = "SELECT OperationNumber FROM bai_pro3.Schedule_Oprations_Master_backup WHERE Style='$params[0]' AND Description=$params[2] AND ScheduleNumber='$params[1]' AND Main_OperationNumber = 130";
		$result_sew_out_qry = $conn->query($sew_out_qry);
		while($row = $result_sew_out_qry->fetch_assoc())
		{
			$sew_out_ops = $row['OperationNumber'];
		}
	}
	if($count <= 0)
	{
		$id_checking_qry = "SELECT ts.id,ts.operation_code,tr.operation_name,ops_dependency FROM tbl_style_ops_master ts LEFT JOIN tbl_orders_ops_ref tr ON tr.id=ts.operation_name WHERE style='$params[0]' AND color = $params[2] AND ts.operation_code<$params[4] AND ts.operation_code > $sew_out_ops AND tr.type like '%Garment%' AND ts.operation_code != 200 GROUP BY operation_name ORDER BY ts.id DESC LIMIT 0,1";
		//echo $id_checking_qry;
		$result_id_checking_qry = $conn->query($id_checking_qry);
		if ($result_id_checking_qry->num_rows > 0)
		{
			while($row = $result_id_checking_qry->fetch_assoc())
			{
				$pre_id = $row['id'];
				$pre_ops_code = $row['operation_code'];
			}
			
			if($pre_id == '')
			{
				$query_tbl_data = "SELECT operation_id,SUM(recevied_qty)as received_qty,size_title,ops_dependency,SUM(recevied_qty) as to_be_send , 0 as pre_send_qty,SUM(recevied_qty) as max_send_quantity  FROM bundle_creation_data WHERE operation_id =$sew_out_ops AND style='$params[0]' AND SCHEDULE='$params[1]' AND color = $params[2] AND cut_number = $params[3] group by size_title";
			}
			else
			{
				$query_tbl_data = "select size_title,operation_id,sum(sew_out_qty) as received_qty,sum(sew_out_qty) as to_be_send,sum(sew_out_qty) as max_send_quantity,0 as pre_send_qty from tbl_garmet_ops_track where style='$params[0]' AND schedule='$params[1]' AND color = $params[2] AND cut_number = $params[3] and operation_id=$pre_ops_code group by size_title";
			}
		}
		else
		{
			$query_tbl_data = "SELECT operation_id,SUM(recevied_qty)as received_qty,size_title,ops_dependency,SUM(recevied_qty) as to_be_send , 0 as pre_send_qty,SUM(recevied_qty) as max_send_quantity  FROM bundle_creation_data WHERE operation_id =$sew_out_ops AND style='$params[0]' AND SCHEDULE='$params[1]' AND color = $params[2] AND cut_number = $params[3] group by size_title";
		}
		
	}
	else
	{
		$id_checking_qry = "SELECT ts.id,ts.operation_code,tr.operation_name,ops_dependency FROM tbl_style_ops_master ts LEFT JOIN tbl_orders_ops_ref tr ON tr.id=ts.operation_name WHERE style='$params[0]' AND color = $params[2] AND ts.operation_code<$params[4] AND ts.operation_code > $sew_out_ops AND tr.type like '%Garment%' AND ts.operation_code != 200 GROUP BY operation_name ORDER BY ts.id DESC LIMIT 0,1";
		//echo $id_checking_qry;
		$result_id_checking_qry = $conn->query($id_checking_qry);
		if ($result_id_checking_qry->num_rows > 0)
		{	
			
		}
		else
		{	
			$summing_query = "SELECT operation_id,SUM(recevied_qty)as received_qty,size_title,ops_dependency,SUM(recevied_qty) as to_be_send , 0 as pre_send_qty,SUM(recevied_qty) as max_send_quantity  FROM bundle_creation_data WHERE operation_id =$sew_out_ops AND style='$params[0]' AND SCHEDULE='$params[1]' AND color = $params[2] AND cut_number = $params[3] group by size_title";
			$result_summing_query = $conn->query($summing_query);
			while($row_result_summing_query = $result_summing_query->fetch_assoc()) 
			{
				$recevied_qty = $row_result_summing_query['received_qty'];
				$size = $row_result_summing_query['size_title'];
				$updating_query = "update tbl_garmet_ops_track set sew_out_qty = $recevied_qty where style='$params[0]' AND schedule='$params[1]' AND color = $params[2] AND cut_number = $params[3] and operation_id = $params[4] AND size_title = '$size'";
				$conn->query($updating_query);
				//echo $updating_query;
			}
			//die();
		}
		$query_tbl_data = "select size_title,operation_id,sew_out_qty as received_qty,(sew_out_qty - sendig_qty) as to_be_send,(sew_out_qty - sendig_qty) as max_send_quantity,sendig_qty as pre_send_qty from tbl_garmet_ops_track where style='$params[0]' AND schedule='$params[1]' AND color = $params[2] AND cut_number = $params[3] and operation_id = $params[4]";
	}
	//echo $query_tbl_data;
	$result_style_data = $conn->query($query_tbl_data);
	while($row = $result_style_data->fetch_assoc()) 
	{
		$result_array_data[] = $row;
		$json1[$row['size_title']] = $row['size_title'];
	}
	$json_data_ol['sizes_data'] = $json1;
	$json_data_ol['table_data'] = $result_array_data;
	echo json_encode($json_data_ol);
}
if(isset($_GET['params1']))
{
		$params1 = $_GET['params1'];
		if($params1 != '')
		{
			gettreceiveddata($params1);
		}
}

function gettreceiveddata($params1)
{
	$params1 = explode(",",$params1);
	include("dbconf1.php");

	// Create connection
		$conn = new mysqli($servername, $username, $password, $dbname);
	// Check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}else{
		//echo "Connection Success";
	}
	$sew_out_qry = "SELECT OperationNumber FROM bai_pro3.Schedule_Oprations_Master WHERE Style='$params1[0]' AND Description=$params1[2] AND ScheduleNumber='$params1[1]' AND Main_OperationNumber = 130";
   //echo $sew_out_qry;
   $result_sew_out_qry = $conn->query($sew_out_qry);
	if ($result_sew_out_qry->num_rows > 0) 
   {
		while($row = $result_sew_out_qry->fetch_assoc())
		{
			$sew_out_ops = $row['OperationNumber'];
		}
	}
	else
	{
		$sew_out_qry = "SELECT OperationNumber FROM bai_pro3.Schedule_Oprations_Master_backup WHERE Style='$params1[0]' AND Description=$params1[2] AND ScheduleNumber='$params1[1]' AND Main_OperationNumber = 130";
		$result_sew_out_qry = $conn->query($sew_out_qry);
		while($row = $result_sew_out_qry->fetch_assoc())
		{
			$sew_out_ops = $row['OperationNumber'];
		}
	}
	$query_received_data =  "SELECT ts.id,ts.operation_code,tr.operation_name FROM tbl_style_ops_master ts LEFT JOIN tbl_orders_ops_ref tr ON tr.id=ts.operation_name WHERE style='$params1[0]'  AND color = $params1[2] AND ts.operation_code > $sew_out_ops AND tr.type like'%Garment%' AND ts.operation_code != 200 AND ts.ops_dependency != 0 GROUP BY operation_name ORDER BY ts.id";
	$result1 = $conn->query($query_received_data);
    while($row1 = $result1->fetch_assoc()){
        $json1[$row1['operation_code']] = $row1['operation_name'];
   }
   echo json_encode($json1);
}
if(isset($_GET['act_params']))
{
		$act_params = $_GET['act_params'];
		if($act_params != '')
		{
			gettreceivetabledata($act_params);
		}
}

function gettreceivetabledata($act_params)
{
	$act_params = explode(",",$act_params);
	include("dbconf1.php");

	// Create connection
		$conn = new mysqli($servername, $username, $password, $dbname);
	// Check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}else{
		//echo "Connection Success";
	}
	$checking_dep_ops_qry = "select ops_dependency from tbl_style_ops_master where style = '$act_params[0]' and color = $act_params[2] and operation_code = $act_params[4]";
	//echo $checking_dep_ops_qry;
	$result_checking_dep_ops_qry = $conn->query($checking_dep_ops_qry);
    while($row1 = $result_checking_dep_ops_qry->fetch_assoc()){
        $ops_dependency = $row1['ops_dependency'];
   }
	$query_received_table_data =  "select *,tt.id as updatable_id,(tt.sendig_qty - (tt.received_qty+tt.rejected_qty)) as to_be_rec from  tbl_garmet_ops_track tt left join tbl_orders_ops_ref tr on tr.id=tt.operation_id  where style ='$act_params[0]' and schedule = '$act_params[1]' and color = $act_params[2] and cut_number = $act_params[3] and operation_id = $ops_dependency and sendig_qty > 0";
	//echo $query_received_table_data;
	$result1 = $conn->query($query_received_table_data);
    while($row1 = $result1->fetch_assoc()){
       $result_array_data[] = $row1;
		$json1[$row1['size_title']] = $row1['size_title'];
	}
	$json_data_ol['sizes_data'] = $json1;
	$json_data_ol['table_data'] = $result_array_data;
	echo json_encode($json_data_ol);
}
if(isset($_GET['colors']))
{
	$colors = $_GET['colors'];
	if($colors != '')
	{
		getcolors($colors);
	}
}
function getcolors($colors)
{
	include("dbconf1.php");

	// Create connection
		$conn = new mysqli($servername, $username, $password, $dbname);
	// Check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}else{
		//echo "Connection Success";
	}
	$schedule_query = "SELECT id,cut_number FROM tbl_garmet_ops_track where color = '$colors' GROUP BY cut_number";
	//echo $schedule_query;
	$result1 = $conn->query($schedule_query);
    while($row1 = $result1->fetch_assoc()){
        $json1[$row1['cut_number']] = $row1['cut_number'];
   }
   echo json_encode($json1);
}



?>