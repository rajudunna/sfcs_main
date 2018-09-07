<?php
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
	include("../../../../../common/config/config_ajax.php");
    $saving1 = explode(",",$saving);
    // var_dump($saving1);
	if($saving1[5] != 0)
	{
		//echo "ops_dep".$saving1[15];
		$qry_check_dependency = "select count(*)as cnt from $brandix_bts.default_operation_workflow where operation_code=$saving1[5]";
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
		$saving_sub_oper_data_qry = "insert into $brandix_bts.default_operation_workflow (operation_name,operation_code,operation_order,default_operration,ops_sequence,ops_dependency,component,barcode) values ($saving)";
		//echo $saving_sub_oper_data_qry;
		$spdr = $link->query($saving_sub_oper_data_qry);
		//echo $saving_sub_oper_data_qry;
		$last_id = mysqli_insert_id($link);
		//$last_id = 1;
		$array_changed_order_ids_values = array();
		//echo $last_id;
		if($last_id != null)
		{
			$check_decimal_or_not = numberOfDecimals($saving1[2]);
			if($check_decimal_or_not > 0)
			{
				$retriving_whole_value = explode('.',$saving1[2]);
				$act_val = $retriving_whole_value[0] +1;
				$saving_sub_oper_data_qry = "insert into $brandix_bts.default_operation_workflow (operation_name,operation_code,operation_order,default_operration,ops_sequence,ops_dependency,component,barcode) values ($saving)";
				$checking_for_same_ops_order = "select id,operation_order from $brandix_bts.default_operation_workflow where CAST(operation_order AS CHAR) >= '$saving1[2]'  and id != $last_id and CAST(operation_order AS CHAR) < '$act_val'order by operation_order";
				$result_checking_for_same_ops_order = $link->query($checking_for_same_ops_order);
				if($result_checking_for_same_ops_order->num_rows > 0)
				{
					while($row_result_checking_for_same_ops_order = $result_checking_for_same_ops_order->fetch_assoc())
					{
						$ops_order = $row_result_checking_for_same_ops_order['operation_order'];
						$updating_id = $row_result_checking_for_same_ops_order['id'];
					// echo $ops_order;
						$act_ops_order_str = (string)$ops_order.'1';
					// echo $act_ops_order_str;
						$act_ops_order = (float)$act_ops_order_str;
						$updating_qry = "update $brandix_bts.default_operation_workflow set operation_order = $act_ops_order where id = $updating_id";
						$array_changed_order_ids_values[$updating_id]=$act_ops_order;
					// echo $updating_qry;
						$link->query($updating_qry);
					} 
				}

			}
			else
			{
				$fetching_all_rows= "select * from $brandix_bts.default_operation_workflow where id != $last_id order by operation_order ASC";
				//echo $fetching_all_rows;
				$result_fetching_all_rows = $link->query($fetching_all_rows);
				if($result_fetching_all_rows->num_rows > 0)
				{
					//echo "workig";
					while($row = $result_fetching_all_rows->fetch_assoc())
					{
						$pre_dev_value = $row['operation_order'];
						$id = $row['id'];
						$integer_digit_explode = explode('.',$pre_dev_value);
						//var_dump($integer_digit_explode);
						//echo sizeof($integer_digit_explode).'</br>';
						if(sizeof($integer_digit_explode) > 1)
						{
							$act_digit = $integer_digit_explode[0] + 1;
							$actual_ops_order = $act_digit.'.'."$integer_digit_explode[1]";
							$update_qry= "update $brandix_bts.default_operation_workflow set operation_order = $actual_ops_order where id = $id";
							$array_changed_order_ids_values[$id]=$actual_ops_order;
							//$link->query($update_qry);

						}
						else
						{
							$update_qry= "update $brandix_bts.default_operation_workflow set operation_order = $pre_dev_value+1 where id = $id";
							$array_changed_order_ids_values[$id]=$pre_dev_value+1;
							//$link->query($update_qry);
						}
						$updating = $link->query($update_qry);
					
						//echo $update_qry.'</br>';
					}

				}
			}
			$result_array['last_id'] = $last_id;
			$result_array['changed_ids'] = $array_changed_order_ids_values;
			echo json_encode($result_array);
			
		}
   }
   else
   {
	   echo "None";
   }
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
	include("../../../../../common/config/config_ajax.php");

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
		$operation_name_validation = "SELECT count(*)as cnt from $brandix_bts.default_operation_workflow  where operation_name = $oper_name[0]";
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
	include("../../../../../common/config/config_ajax.php");
    $opeation_validation = "select count(*)as cnt from $brandix_bts.default_operation_workflow where  ops_sequence=$seq_params[1]";
   // echo $opeation_validation;
	$result_opeation_validation = $link->query($opeation_validation);
	while($row = $result_opeation_validation->fetch_assoc())
	{
			$count_ops = $row['cnt'];
	}
	if($count_ops == 0)
	{
		$validation_query_component = "select component from $brandix_bts.default_operation_workflow where ops_sequence = $seq_params[0]";
		//echo $validation_query_component;
		$result_validation_query_component = $link->query($validation_query_component);
		if(mysqli_num_rows($result_validation_query_component) > 0)
		{
			while($row = $result_validation_query_component->fetch_assoc()){
				$component = $row['component'];
			}
			//echo "component is".$component;
			echo $component;
			if($component == '')
			{
				echo 1;
			}
			
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
	include("../../../../../common/config/config_ajax.php");
	$validation_query_component = "select ops_dependency from $brandix_bts.default_operation_workflow where ops_sequence = $dep_validate[0]";
    $result_validation_query_component = $link->query($validation_query_component);
    // echo $validation_query_component;
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
	include("../../../../../common/config/config_ajax.php");

	$qry_get_table_data_oper_data = "SELECT *,tor.id AS operation_id,tor.operation_name AS ops_name,tos.id AS main_id,tos.operation_name AS operation_id,tos.operation_code AS operation_code FROM $brandix_bts.default_operation_workflow tos LEFT JOIN brandix_bts.tbl_orders_ops_ref tor ON tor.id=tos.operation_name ORDER BY tos.operation_order";
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
	include("../../../../../common/config/config_ajax.php");
    //var_dump($editable_data);
    //echo $editable_data[6];
    if($editable_data[4] == '')
    {
        $$editable_data[4] = "''";
    }
	if($editable_data[3] != '')
	{
        $qry_check_dependency = "select count(*)as cnt from $brandix_bts.default_operation_workflow where  operation_code=$editable_data[3]";
       // echo $qry_check_dependency;
		$result_chck_cnt = $link->query($qry_check_dependency);
		  while($row = $result_chck_cnt->fetch_assoc()){
			$cnt = $row['cnt'];
		}
	}
	else
	{
		$cnt = 1;
		$editable_data[3] = "''";
    }
    // echo $qry_check_dependency;
   //echo $editable_data[4];
   //echo $cnt;
   if($cnt > 0)
	{
		if($editable_data[4] == '')
		{
			$qry_updation = "update $brandix_bts.default_operation_workflow set barcode=$editable_data[1],ops_sequence=$editable_data[2],ops_dependency='',component=$editable_data[4],operation_code = $editable_data[5] where id=$editable_data[0]";
		}
		else
		{
			$qry_updation = "update $brandix_bts.default_operation_workflow set barcode=$editable_data[1],ops_sequence=$editable_data[2],ops_dependency=$editable_data[3],component=$editable_data[4],operation_code = $editable_data[5] where id=$editable_data[0]";
		}

		// echo $qry_updation;
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
	include("../../../../../common/config/config_ajax.php");

	$opeation_validation = "select count(*)as cnt from $brandix_bts.default_operation_workflow where operation_name=$seq_params[1]";
	$result_opeation_validation = $link->query($opeation_validation);
	 while($row = $result_opeation_validation->fetch_assoc())
	{
			$count_ops = $row['cnt'];
	}
		$validation_query_component = "select component from $brandix_bts.default_operation_workflow where  ops_sequence = $seq_params[0]";
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
	include("../../../../../common/config/config_ajax.php");
	$fetching_ops_order = "select operation_order from $brandix_bts.default_operation_workflow where id =  $parameters[0]";
	$result_fetching_ops_order = $link->query($fetching_ops_order);
	while($row_result_fetching_ops_order = $result_fetching_ops_order->fetch_assoc())
	{
		$del_ops_order = $row_result_fetching_ops_order['operation_order'];
	}
	$delete_query = "delete from $brandix_bts.default_operation_workflow where id = $parameters[0]";
	$deleteable = $link->query($delete_query);
	//$deleteable = true;	
	if($deleteable)
	{
		// $check_decimal_or_not = numberOfDecimals($del_ops_order);
		// if($check_decimal_or_not > 0)
		// {
		// 	$retriving_whole_value = explode('.',$del_ops_order);
		// 	$act_val = $retriving_whole_value[0] +1;
		// 	$checking_for_same_ops_order = "select id,operation_order from $brandix_bts.default_operation_workflow where CAST(operation_order AS CHAR) > '$del_ops_order' and CAST(operation_order AS CHAR) < '$act_val' order by operation_order";
        //    //echo $checking_for_same_ops_order;
        //     $result_checking_for_same_ops_order = $link->query($checking_for_same_ops_order);
        //     if($result_checking_for_same_ops_order->num_rows > 0)
        //     {
        //         while($row_result_checking_for_same_ops_order = $result_checking_for_same_ops_order->fetch_assoc())
        //         {
        //             $ops_order = $row_result_checking_for_same_ops_order['operation_order'];
        //             $updating_id = $row_result_checking_for_same_ops_order['id'];
        //            // echo $ops_order;
		// 			$act_ops_order_str = (string)$ops_order;
		// 			$act_ops_order_str = substr($ops_order, 0, -1);
        //            // echo $act_ops_order_str;
        //             $act_ops_order = (float)$act_ops_order_str;
        //             $updating_qry = "update $brandix_bts.default_operation_workflow set operation_order = $act_ops_order where id = $updating_id";
        //            // echo $updating_qry;
        //            $link->query($updating_qry);
        //         } 
        //     }
		// }
		// else
		// {
		// 	$fetching_all_rows= "select * from $brandix_bts.default_operation_workflow where operation_order > $del_ops_order order by operation_order ASC";
		// 		//echo $fetching_all_rows;
		// 		$result_fetching_all_rows = $link->query($fetching_all_rows);
		// 		if($result_fetching_all_rows->num_rows > 0)
		// 		{
		// 			//echo "workig";
		// 			while($row = $result_fetching_all_rows->fetch_assoc())
		// 			{
		// 				$pre_dev_value = $row['operation_order'];
		// 				$id = $row['id'];
		// 				$integer_digit_explode = explode('.',$pre_dev_value);
		// 				//var_dump($integer_digit_explode);
		// 				//echo sizeof($integer_digit_explode).'</br>';
		// 				if(sizeof($integer_digit_explode) > 1)
		// 				{
		// 					$act_digit = $integer_digit_explode[0] - 1;
		// 					$actual_ops_order = $act_digit.'.'."$integer_digit_explode[1]";
		// 					$update_qry= "update $brandix_bts.default_operation_workflow set operation_order = $actual_ops_order where id = $id";
		// 					//$link->query($update_qry);

		// 				}
		// 				else
		// 				{
		// 					$update_qry= "update $brandix_bts.default_operation_workflow set operation_order = $pre_dev_value+1 where id = $id";
		// 					//$link->query($update_qry);
		// 				}
		// 				$link->query($update_qry);
		// 				//echo $update_qry.'</br>';
		// 			}

		// 		}
		// }
		
	}

}
if(isset($_GET['first_ops_check']))
{
	$first_ops_check = $_GET['first_ops_check'];
	if($first_ops_check != '')
	{
		first_ops_check_fun($first_ops_check);
	}
}

function first_ops_check_fun($first_ops_check)
{
	include("../../../../../common/config/config_ajax.php");
	$checking_qry = "select operation_order from $brandix_bts.default_operation_workflow where operation_order = floor(operation_order)";
	//echo $checking_qry;
	$result_checking_qry = $link->query($checking_qry);
	if($result_checking_qry->num_rows > 0)
	{
		while($row = $result_checking_qry->fetch_assoc())
		{
			$max_operation_code = $row['operation_order'];
		}
		$max_operation_code = $max_operation_code+1;
		
	}
	else
	{
		$max_operation_code = 1;
	}
	echo $max_operation_code;

}

function numberOfDecimals($value)
{
    if ((int)$value == $value)
    {
        return 0;
    }
    else if (! is_numeric($value))
    {
        // throw new Exception('numberOfDecimals: ' . $value . ' is not a number!');
        return false;
    }

    return strlen($value) - strrpos($value, '.') - 1;
}


?>