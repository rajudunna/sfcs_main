<?php
if(isset($_GET['params']))
{
	$params = $_GET['params'];
	if($params != '')
	{
		gettabledata($params);
	}
}

if(isset($_GET['params1']))
{
	$params1 = $_GET['params1'];
	if($params1 != '')
	{
		Getdata1($params1);
	}
}

if(isset($_GET['params_smv']))
{
	$params_smv = $_GET['params_smv'];
	if($params_smv != '')
	{
		Getsmv($params_smv);
	}
}
function Getsmv($params_smv)
{
	$params_smv = explode(",",$params_smv);
	include("../../../../../common/config/config.php");
	$qry_get_table_data_oper_data_m3 = "SELECT tos.id,smv,tor.operation_name,tos.operation_code	FROM $brandix_bts.tbl_style_ops_master tos LEFT JOIN $brandix_bts.tbl_orders_ops_ref tor ON tor.id=tos.operation_name WHERE style = '$params_smv[1]' AND color = '$params_smv[0]' AND smv != '0.00' AND operation_order < 400 ORDER BY operation_order";
	$result1 = $link->query($qry_get_table_data_oper_data_m3);
   while($row1 = $result1->fetch_assoc()){
	    $result_showing = $row1['operation_name'].'('.$row1['operation_code'].')';
        $json1[$row1['id']] = $result_showing;
   }
   echo json_encode($json1);
}

function gettabledata($params)
{
	$params = explode(",",$params);
	include("../../../../../common/config/config.php");

	$qry_get_table_data_oper_data = "select *,tor.id as operation_id,tor.operation_name as ops_name,tos.id as main_id,supplier_name,tos.operation_name as operation_id from $brandix_bts.tbl_style_ops_master tos left join $brandix_bts.tbl_orders_ops_ref tor on tor.id=tos.operation_name left join $brandix_bts.tbl_suppliers_master tsm on tsm.id = tos.emb_supplier where style = '$params[1]' and color = '$params[0]' order by tos.id";
	//echo $qry_get_table_data_oper_data;
	$result_style_data = $link->query($qry_get_table_data_oper_data);
	if ($result_style_data->num_rows > 0) {
		while($row = $result_style_data->fetch_assoc()) 
		{
			$result_array[] = $row;
		}
		$json_data = json_encode($result_array);
	}
	else
	{
		$json_data = 100;
	}
	echo $json_data;
	
}

if(isset($_GET['pro_style_schedule']))
{
	$pro_style = $_GET['pro_style_schedule'];
	//echo $pro_style;exit;
	if($pro_style != '')
	{
		getscheduledata($pro_style);
	}
}
function getscheduledata($pro_style)
{
	include("../../../../../common/config/config.php");

	$query_get_schedule_data= "select id,color from $brandix_bts.tbl_style_ops_master where style='$pro_style' group by style,color";
	//echo $query_get_schedule_data;exit;
	$result = $link->query($query_get_schedule_data);
	$json = array();
   while($row = $result->fetch_assoc()){
        $json[$row['id']] = $row['color'];
   }
   echo json_encode($json);
	
}
if(isset($_GET['pro_schedule_color']))
{
	$pro_schedule_color = $_GET['pro_schedule_color'];
	if($pro_schedule_color != '')
	{
		getcolordata($pro_schedule_color);
	}
}
function getcolordata($pro_schedule_color)
{
	error_reporting (0);
	include("../../../../../common/config/config.php");

	$query_get_color_data= "select id,color from $brandix_bts.tbl_style_ops_master where style='$pro_schedule_color' group by color";
	$result = $link->query($query_get_color_data);
	//$json = [];
   while($row = $result->fetch_assoc()){
        $json[$row['id']] = $row['color'];
   }
   echo json_encode($json);
}

if(isset($_GET['oper_name']))
{
	$oper_name = $_GET['oper_name'];
	if($oper_name != '')
	{
		getdata($oper_name);
	}
}

function Getdata($oper_name)
{
	error_reporting (0);
	include("../../../../../common/config/config.php");

	$oper_name = explode(",",$oper_name);
	//var_dump($oper_name);
	if($oper_name[3] == 100)
	{
		//$operation_name_validation = "SELECT count(*)as cnt from $brandix_bts.tbl_style_ops_master where operation_name = $oper_name[0] and color = '$oper_name[1]' and style = '$oper_name[2]'";
		$qry_get_operation_name = "SELECT id,operation_name,default_operation,operation_code FROM $brandix_bts.tbl_orders_ops_ref where id = $oper_name[0]";
		$result_oper = $link->query($qry_get_operation_name);
		$row = $result_oper->fetch_assoc();
		$json_data = json_encode($row);
		echo $json_data;
	}
	else
	{
		$operation_name_validation = "SELECT count(*)as cnt from $brandix_bts.tbl_style_ops_master where operation_name = $oper_name[0] and color = '$oper_name[1]' and style = '$oper_name[2]' and ops_sequence = $oper_name[3]";
		$result_validate = $link->query($operation_name_validation);
		while($row_validate = $result_validate->fetch_assoc()) 
		{
			$validate_result = $row_validate['cnt'];
		}
		if($validate_result == 0)
		{
			$qry_get_operation_name = "SELECT id,operation_name,default_operation,operation_code FROM $brandix_bts.tbl_orders_ops_ref where id = $oper_name[0]";
			$result_oper = $link->query($qry_get_operation_name);
			$row = $result_oper->fetch_assoc();
			$json_data = json_encode($row);
			echo $json_data;
		}
		else
		{
			echo 1;
		}
	}
	//echo $operation_name_validation;
	
}


function Getdata1($params1)
{
	$params1 = explode(",",$params1);

error_reporting (0);
	include("../../../../../common/config/config.php");

// var_dump($params1);
	$qry_get_miniorder_no = "SELECT min_order_ref FROM $brandix_bts.tbl_style_ops_master WHERE scan_status=1 AND color='$params1[0]' AND style='$params1[1]' ";
	echo $qry_get_miniorder_no;
	$miniorder = $link->query($qry_get_miniorder_no);
	//$row = $miniorder->fetch_assoc();
	while($row = $miniorder->fetch_assoc()) 
	{
		$mini_order_no = $row['min_order_ref'];
	}
	$bundlenumbers="SELECT bundle_number FROM $brandix_bts.tbl_miniorder_data WHERE mini_order_ref='$mini_order_no'";
	$bubleno = $link->query($bundlenumbers);
	
	$bunds = "";
	
	while($row1 = $bubleno->fetch_assoc())
	{
		$bundlenos = $row1['bundle_number'];
		$bunds = $bunds.$bundlenos.",";
		
		$bundlefinal = rtrim($bunds,',');
	}
	// echo $bundlefinal;
	
	$bund_transactions="SELECT btr.bundle_id,btr.bundle_barcode,tor.operation_name,btr.quantity,btr.rejection_quantity FROM $brandix_bts.bundle_transactions_20_repeat btr left join $brandix_bts.tbl_style_ops_master tsm on tsm.operation_name=btr.operation_id left join $brandix_bts.tbl_orders_ops_ref tor on tor.id=tsm.operation_name WHERE bundle_id IN ($bundlefinal) group by btr.id";
	
	// echo $bund_transactions;
	
	$result_style_data = $link->query($bund_transactions);
	while($row2 = $result_style_data->fetch_assoc()) 
	{
		$result_array[] = $row2;
	}
	$json_data = json_encode($result_array);
	echo $json_data;
	
}


if(isset($_GET['saving']))
{
	$saving = $_GET['saving'];
	if($saving != '')
	{
		savingdata($saving);
	}
}

function savingdata($saving)
{
	error_reporting (0);
	include("../../../../../common/config/config.php");

	$saving1 = explode(",",$saving);
	if($saving1[15] != 0)
	{
		//echo "ops_dep".$saving1[15];
		$qry_check_dependency = "select count(*)as cnt from $brandix_bts.tbl_style_ops_master where style=$saving1[9] and color = $saving1[10] and operation_code=$saving1[15]";
		//echo $qry_check_dependency;
		$result_chck_cnt = $link->query($qry_check_dependency);
		  while($row = $result_chck_cnt->fetch_assoc()){
			$cnt = $row['cnt'];
	   }
	}
	else
	{
		$cnt = 1;
	}
   //echo $cnt;
   if($cnt > 0)
   {
	    //var_dump($saving);
		$saving_sub_oper_data_qry = "insert into $brandix_bts.tbl_style_ops_master (parent_id,operation_name,operation_order,smo,smv,m3_smv,operation_code,default_operration,priority,style,color,from_m3_check,barcode,emb_supplier,ops_sequence,ops_dependency,component) values ($saving)";
		// echo $saving_sub_oper_data_qry;
		$spdr = $link->query($saving_sub_oper_data_qry);
		//echo $saving_sub_oper_data_qry;
		$last_id = mysqli_insert_id($link);
		//echo $last_id;
		if($last_id != null)
		{
			echo $last_id;
		}
   }
   else
   {
	   echo "None";
   }
}

if(isset($_GET['checking']))
{
	$checking = $_GET['checking'];
	if($checking != '')
	{
		getcheckeddata($checking);
	}
}

function getcheckeddata($checking)
{
	error_reporting (0);
	include("../../../../../common/config/config.php");

	$checking_query = "select count(operation_order) as count from $brandix_bts.tbl_style_ops_master where operation_order like '$checking_string%'";
	//echo $checking_query;
	$result_chck = $link->query($checking_query);
	  while($row = $result_chck->fetch_assoc()){
        $count = $row['count'];
   }
   echo $count;
	
	
}

if(isset($_GET['saving_changes']))
{
	$saving_changes = $_GET['saving_changes'];
	if($saving_changes != '')
	{
		saving_changes($saving_changes);
	}
}

function saving_changes($saving_changes)
{
	include("../../../../../common/config/config.php");

	$saving_changes = explode(",",$saving_changes);
	$update_query = "update $brandix_bts.tbl_style_ops_master set smv = $saving_changes[1] where id = $saving_changes[0]";
	$link->query($update_query);
	echo "Success";
	
}


if(isset($_GET['parameters']))
{
	$parameters = $_GET['parameters'];
	if($parameters != '')
	{
		deleting($parameters);
	}
}

function deleting($parameters)
{
	$parameters = explode(",",$parameters);
	include("../../../../../common/config/config.php");

	//var_dump($deletable_id);
	$query_delete_m3 = "select smv from $brandix_bts.tbl_style_ops_master where id = $parameters[0]";
	$result_chck = $link->query($query_delete_m3);
	  while($row = $result_chck->fetch_assoc()){
        $smv = $row['smv'];
   }
   $smv_value =  $smv;
   $query_delete_man = "select smv from $brandix_bts.tbl_style_ops_master where id = $parameters[1]";
  // echo $query_delete_man;
	$result_chck_man = $link->query($query_delete_man);
	  while($rows = $result_chck_man->fetch_assoc()){
        $m3_man = $rows['smv'];
   }
   $m3_manual_value = $m3_man;
   $actual_smv_value = $smv_value + $m3_man;
   $delete_query = "delete from $brandix_bts.tbl_style_ops_master where id = $parameters[1]";
   $link->query($delete_query);
   $query_update_smv_m3 = "update $brandix_bts.tbl_style_ops_master set smv = $actual_smv_value where id = $parameters[0]";
   $link->query($query_update_smv_m3);
   echo $actual_smv_value;  	
}
if(isset($_GET['editable_data']))
{
	$editable_data = $_GET['editable_data'];
	if($editable_data != '')
	{
		updating($editable_data);
	}
}
function updating($editable_data)
{
	$editable_data = explode(",",$editable_data);
	include("../../../../../common/config/config.php");

	//echo $editable_data[6];
	if($editable_data[4] != '')
	{
		$qry_check_dependency = "select count(*)as cnt from $brandix_bts.tbl_style_ops_master where style=$editable_data[6] and color = $editable_data[7] and operation_code=$editable_data[4]";
		$result_chck_cnt = $link->query($qry_check_dependency);
		  while($row = $result_chck_cnt->fetch_assoc()){
			$cnt = $row['cnt'];
		}
	}
	else
	{
		$cnt = 1;
		$editable_data[4] = null;
	}
   //echo $editable_data[4];
   if($cnt > 0)
	{
		if($editable_data[4] == '')
		{
			$qry_updation = "update $brandix_bts.tbl_style_ops_master set barcode=$editable_data[1],emb_supplier=$editable_data[2],ops_sequence=$editable_data[3],ops_dependency='',component=$editable_data[5] where id=$editable_data[0]";
		}
		else
		{
			$qry_updation = "update $brandix_bts.tbl_style_ops_master set barcode=$editable_data[1],emb_supplier=$editable_data[2],ops_sequence=$editable_data[3],ops_dependency=$editable_data[4],component=$editable_data[5] where id=$editable_data[0]";
		}

		//echo $qry_updation;
		$condi = $link->query($qry_updation);
		if(!$condi)
		{
			echo '0';
		}
		else
		{
			echo '1';
		}
	}
	else
	{
		echo '2';
	}
	
}
if(isset($_GET['seq_params']))
{
	$seq_params = $_GET['seq_params'];
	if($seq_params != '')
	{
		seq_validation($seq_params);
	}
}
function seq_validation($seq_params)
{
	$seq_params = explode(",",$seq_params);
	include("../../../../../common/config/config.php");

	$opeation_validation = "select count(*)as cnt from $brandix_bts.tbl_style_ops_master where style = '$seq_params[1]' and color = '$seq_params[2]' and ops_sequence = $seq_params[0] and operation_name=$seq_params[3]";
	$result_opeation_validation = $link->query($opeation_validation);
	 while($row = $result_opeation_validation->fetch_assoc())
	{
			$count_ops = $row['cnt'];
	}
		$validation_query_component = "select component from $brandix_bts.tbl_style_ops_master where style = '$seq_params[1]' and color = '$seq_params[2]' and ops_sequence = $seq_params[0]";
		//echo $validation_query_component;
		$result_validation_query_component = $link->query($validation_query_component);
		if(mysqli_num_rows($result_validation_query_component) > 0)
		{
			while($row = $result_validation_query_component->fetch_assoc()){
				$component = $row['component'];
			}
			if($count_ops == 0)
			{
				echo $component.",".'0';
			}
			else
			{
				echo $component.",".'1';
			}
		}
		else
		{
			echo 0;
		}
}
if(isset($_GET['seq_params1']))
{
	$seq_params = $_GET['seq_params1'];
	if($seq_params != '')
	{
		seq_validation1($seq_params);
	}
}
function seq_validation1($seq_params)
{
	$seq_params = explode(",",$seq_params);
	include("../../../../../common/config/config.php");

	// $seq_params_ops = substr($seq_params[3], 0, strpos($seq_params[3], '('));
	// $operation_id = "select id from $brandix_bts.tbl_orders_ops_ref where operation_name = '$seq_params_ops'";
	//echo $operation_id;
	// $result_operation_id = $link->query($operation_id);
	// while($row = $result_operation_id->fetch_assoc())
	// {
			// $ops_id = $row['id'];
	// }
	$opeation_validation = "select count(*)as cnt from $brandix_bts.tbl_style_ops_master where style = '$seq_params[1]' and color = '$seq_params[2]' and ops_sequence = $seq_params[0] and operation_name=$seq_params[3]";
	$result_opeation_validation = $link->query($opeation_validation);
	while($row = $result_opeation_validation->fetch_assoc())
	{
			$count_ops = $row['cnt'];
	}
	if($count_ops == 0)
	{
		$validation_query_component = "select component from $brandix_bts.tbl_style_ops_master where style = '$seq_params[1]' and color = '$seq_params[2]' and ops_sequence = $seq_params[0]";
		//echo $validation_query_component;
		$result_validation_query_component = $link->query($validation_query_component);
		if(mysqli_num_rows($result_validation_query_component) > 0)
		{
			while($row = $result_validation_query_component->fetch_assoc()){
				$component = $row['component'];
			}
			//echo "component is".$component;
			echo $component;
			
		}
		else
		{
			echo 1;
		}
	}
	else
	{
		echo 0;
	}
}
if(isset($_GET['dep_validate']))
{
	$dep_validate = $_GET['dep_validate'];
	if($dep_validate != '')
	{
		dep_validation($dep_validate);
	}
}
function dep_validation($dep_validate)
{
	$dep_validate = explode(",",$dep_validate);
	include("../../../../../common/config/config.php");

	$validation_query_component = "select ops_dependency from $brandix_bts.tbl_style_ops_master where style = '$dep_validate[1]' and color = '$dep_validate[2]' and ops_sequence = $dep_validate[0]";
	$result_validation_query_component = $link->query($validation_query_component);
	if(mysqli_num_rows($result_validation_query_component) > 0)
	{
		 while($row = $result_validation_query_component->fetch_assoc()){
			$dependency = $row['ops_dependency'];
		}
		echo $dependency;
	}
	else
	{
		echo 0;
	}
}
if(isset($_GET['manual_smv_value']))
{
	$manual_smv_value = $_GET['manual_smv_value'];
	if($manual_smv_value != '')
	{
		smv_validation($manual_smv_value);
	}
}
function smv_validation($manual_smv_value)
{
	$manual_smv_value = explode(",",$manual_smv_value);
	//var_dump($manual_smv_value);
	include("../../../../../common/config/config.php");
	
	$smv_query = "select smv from $brandix_bts.tbl_style_ops_master where style='$manual_smv_value[1]' and color = '$manual_smv_value[2]' AND smv != 0.00 AND default_operration = 'Yes'";
	$result_validation_smv_query = $link->query($smv_query);
	if(mysqli_num_rows($result_validation_smv_query) > 0)
	{
		while($row = $result_validation_smv_query->fetch_assoc())
		{
			$m3_smv = $row['smv'];
			if($manual_smv_value[0] > $m3_smv)
			{
				$flag = 0;
			}
			else
			{
				$flag = 1;
			}
		}
		echo $flag;
	}
}
if(isset($_GET['dependency_ops_ary']))
{
	$dependency_ops_ary = $_GET['dependency_ops_ary'];
	if($dependency_ops_ary != '')
	{
		dependency_ops_validation($dependency_ops_ary);
	}
}
function dependency_ops_validation($dependency_ops_ary)
{
	
	$dependency_ops_ary = explode(",",$dependency_ops_ary);
	//var_dump($dependency_ops_ary);
	include("../../../../../common/config/config.php");

	$smv_query = "select count(id)as cnt from $brandix_bts.bundle_creation_data where style='$dependency_ops_ary[1]' and color = '$dependency_ops_ary[2]' and operation_id = '$dependency_ops_ary[0]'";
	//echo $smv_query;
	$result_validation_smv_query = $link->query($smv_query);
	//$flag = 0;
	if(mysqli_num_rows($result_validation_smv_query) > 0)
	{
		while($row = $result_validation_smv_query->fetch_assoc())
		{
			$count_pre = $row['cnt'];
		}
	}
	if($count_pre == 0)
	{
		$smv_query = "select count(ops_dependency)as cnt from $brandix_bts.tbl_style_ops_master where style='$dependency_ops_ary[1]' and color = '$dependency_ops_ary[2]' and ops_dependency = '$dependency_ops_ary[0]'";
		$result_validation_smv_query = $link->query($smv_query);
		//$flag = 0;
		if(mysqli_num_rows($result_validation_smv_query) > 0)
		{
			while($row = $result_validation_smv_query->fetch_assoc())
			{
				$count = $row['cnt'];
			}
		}
		if($count == 0)
		{
			$flag = 1;
		}
		else
		{
			$flag = 3;
		}
	}
	else
	{
		$flag = 2;
	}
	echo $flag;
}

if(isset($_GET['adding_validation']))
{
	$adding_validation = $_GET['adding_validation'];
	if($adding_validation != '')
	{
		adding_validation_fun($adding_validation);
	}
}
function adding_validation_fun($adding_validation)
{
	$adding_validation = explode(",",$adding_validation);
	include("../../../../../common/config/config.php");

	$smv_query = "select count(id)as cnt from $brandix_bts.bundle_creation_data where style='$adding_validation[0]' and color = '$adding_validation[1]'";
	//echo $smv_query;
	$result_validation_smv_query = $link->query($smv_query);
	$flag = 0;
	if(mysqli_num_rows($result_validation_smv_query) > 0)
	{
		while($row = $result_validation_smv_query->fetch_assoc())
		{
			$count_pre = $row['cnt'];
		}
	}
	if($count_pre > 0)
	{
		$flag = 1;
	}
	else
	{
		$flag = 0;
	}
	echo $flag;
}


?>