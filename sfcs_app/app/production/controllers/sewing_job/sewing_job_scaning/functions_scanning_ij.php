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
    include("../../../../../common/config/config_ajax.php");
    $category="'sewing'";
    $query_get_schedule_data= "SELECT tm.operation_code,tm.operation_name FROM brandix_bts.tbl_orders_ops_ref tm
    WHERE tm.operation_code NOT IN (10,200,15) 
    AND category IN ($category) AND display_operations='yes'
    GROUP BY tm.operation_code ORDER BY tm.operation_code";
    $result = $link->query($query_get_schedule_data);
    while($row = $result->fetch_assoc()){
        $json[$row['operation_code']] = $row['operation_name'];
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
    include("../../../../../common/config/config_ajax.php");
    $schedule_query = "SELECT order_col_des as color,order_style_no as style FROM $bai_pro3.packing_summary_input where order_del_no = '$schedule' GROUP BY order_col_des";
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
    include("../../../../../common/config/config_ajax.php");
    $query_dep_ops = "SELECT tr.operation_code,tr.operation_name,ts.component FROM $brandix_bts.tbl_style_ops_master ts LEFT JOIN $brandix_bts.tbl_orders_ops_ref tr ON tr.id=ts.operation_name WHERE style='$color[0]' AND color = '$color[1]' and barcode='Yes' ORDER BY ts.ops_sequence";
    $result_query_dep_ops = $link->query($query_dep_ops);
    while($row_result_query_dep_ops = $result_query_dep_ops->fetch_assoc()) 
    {
        $value_to_show = $row_result_query_dep_ops['operation_name'];
        $json1[$row_result_query_dep_ops['operation_code']] = $value_to_show;
    }
    echo json_encode($json1);
}
if(isset($_GET['job_number']))
{
    $job_number = $_GET['job_number'];
    if($job_number != '')
    {
        getjobdetails($job_number);
    }
}
function getjobdetails($job_number)
{
    $job_number = explode(",",$job_number);
    $emb_cut_check_flag = 0;
    $job_number[4]=$job_number[1];
    include("../../../../../common/config/config_ajax.php");
    $column_to_search = $job_number[0];
    $column_in_where_condition = 'bundle_number';
    $column_in_pack_summary = 'tid';
    if($job_number[2] == 1)
    {
        $column_in_where_condition = 'input_job_no_random_ref';
        $column_in_pack_summary = 'input_job_no_random';
    }
    $bg = $job_number[2];
    $module_no = $job_number[3];
    $selecting_style_schedule_color_qry = "select order_style_no,order_del_no,order_col_des,input_job_no_random,type_of_sewing,doc_no from $bai_pro3.packing_summary_input WHERE $column_in_pack_summary = '$column_to_search' ORDER BY tid";
    $result_selecting_style_schedule_color_qry = $link->query($selecting_style_schedule_color_qry);
    if($result_selecting_style_schedule_color_qry->num_rows > 0)
    {
        while($row = $result_selecting_style_schedule_color_qry->fetch_assoc()) 
        {
            $job_number[1]= $row['order_style_no'];
            $job_number[2]= $row['order_del_no'];
            $job_number[3]= $row['order_col_des'];
            $maped_color = $row['order_col_des'];
            $actual_input_job_number = $row['input_job_no_random'];
            $job_number_reference = $row['type_of_sewing'];
            $doc_no_dependency = $row['doc_no'];
            
        }
    }
    else
    {
        $result_array['status'] = 'Invalid Input. Please Check And Try Again !!!';
        echo json_encode($result_array);
        die();
    }
    $result_array['style'] = $job_number[1];
    $result_array['schedule'] = $job_number[2];
    $result_array['color_dis'] = $job_number[3];
    $ops_dep_flag = 0;
    
    $ops_dep_qry = "SELECT ops_dependency,operation_code FROM $brandix_bts.tbl_style_ops_master WHERE style='$job_number[1]' AND color = '$maped_color' AND ops_dependency != 200 AND ops_dependency != 0";
    $result_ops_dep_qry = $link->query($ops_dep_qry);
    while($row = $result_ops_dep_qry->fetch_assoc()) 
    {
        if($row['ops_dependency'])
        {
            if($row['ops_dependency'] == $job_number[4])
            {
                $ops_dep_code = $row['operation_code'];
                $schedule_count_query = "SELECT recevied_qty as recevied_qty FROM $brandix_bts.bundle_creation_data WHERE $column_in_where_condition = '$column_to_search' AND operation_id =$ops_dep_code";
                //echo $schedule_count_query;
                $schedule_count_query = $link->query($schedule_count_query);
                if($schedule_count_query->num_rows > 0)
                {
                    while($row = $schedule_count_query->fetch_assoc()) 
                    {
                        $recevied_qty = $row['recevied_qty'];
                    }
                    if($recevied_qty == 0)
                    {
                        $ops_dep_flag =1;
                        $result_array['status'] = 'The dependency operations for this operation are not yet done.';
                        echo json_encode($result_array);
                        die();
                    }
                }else{
						$schedule_count_query = "SELECT sum(recevied_qty)as recevied_qty FROM $brandix_bts.bundle_creation_data WHERE input_job_no_random_ref = '$doc_no_dependency' AND operation_id =$ops_dep_code";
						$schedule_count_query = $link->query($schedule_count_query);

						while($row = $schedule_count_query->fetch_assoc()) 
						{
							$recevied_qty = $row['recevied_qty'];
						}
						if($recevied_qty == 0)
						{
							$ops_dep_flag =1;
							$result_array['status'] = 'The dependency operations for this operation are not yet done.';
							echo json_encode($result_array);
							die();
						}

					}
            }
        }
    }
    $flags=0;       
    $ops_seq_check = "select id,ops_sequence,operation_order from $brandix_bts.tbl_style_ops_master where style='$job_number[1]' and color = '$maped_color' and operation_code=$job_number[4]";
    // echo $ops_seq_check;
    $result_ops_seq_check = $link->query($ops_seq_check);
    if($result_ops_seq_check->num_rows > 0)
    {
        while($row = $result_ops_seq_check->fetch_assoc()) 
        {
            $ops_seq = $row['ops_sequence'];
            $seq_id = $row['id'];
            $ops_order = $row['operation_order'];
        }
    }
    else
    {
        $result_array['status'] = 'Invalid Operation for this input job number.Plese verify Operation Mapping.';
        echo json_encode($result_array);
        die();
    }

    $get_ops_query = "SELECT DISTINCT tm.operation_code FROM $brandix_bts.tbl_style_ops_master tm LEFT JOIN $brandix_bts.tbl_orders_ops_ref tr ON tr.id=tm.operation_name WHERE tm.style ='$job_number[1]' AND tm.color='$maped_color' AND tr.category = 'sewing' ORDER BY operation_order";

    $ops_query_result=mysqli_query($link,$get_ops_query);
    while ($row = mysqli_fetch_array($ops_query_result))
    {
        
        $ops_get_code[] = $row['operation_code'];
        //$result_array['ops_get_code'][] = $row['operation_code'];

    }

    $opertions = implode(',',$ops_get_code);

    $to_display_values="SELECT operation_name,operation_code FROM $brandix_bts.tbl_orders_ops_ref where operation_code in ($opertions) and display_operations='yes'";
    //echo $to_display_values;
    $ops_query_result1=$link->query($to_display_values);
    while ($row1 = $ops_query_result1->fetch_assoc())
    {
 $result_array['ops_get_code'][$row1['operation_name']] = $row1['operation_code'];
    }
    // echo $display_code;

    $pre_ops_check = "select operation_code from $brandix_bts.tbl_style_ops_master where style='$job_number[1]' and color = '$maped_color' AND ops_sequence = '$ops_seq' AND CAST(operation_order AS CHAR) < '$ops_order' and operation_code NOT IN (10,200) ORDER BY operation_order DESC LIMIT 1";
    $result_pre_ops_check = $link->query($pre_ops_check);
    if($result_pre_ops_check->num_rows > 0)
    {
        while($row = $result_pre_ops_check->fetch_assoc()) 
        {
            $pre_ops_code = $row['operation_code'];
        }
        $category=['cutting','Send PF','Receive PF'];
        $emb_category = ['Send PF','Receive PF'];
        $checking_qry = "SELECT category FROM `brandix_bts`.`tbl_orders_ops_ref` WHERE operation_code = '$pre_ops_code'";
        $result_checking_qry = $link->query($checking_qry);
        while($row_cat = $result_checking_qry->fetch_assoc()) 
        {
            $category_act = $row_cat['category'];
        }
        if(in_array($category_act,$category))
        {
            $emb_cut_check_flag = 1;
        }
        if($emb_cut_check_flag != 1)
        {
            $pre_ops_validation = "SELECT sum(recevied_qty)as recevied_qty FROM $brandix_bts.bundle_creation_data WHERE $column_in_where_condition = '$column_to_search' AND operation_id = $pre_ops_code";
            $result_pre_ops_validation = $link->query($pre_ops_validation);
            while($row = $result_pre_ops_validation->fetch_assoc()) 
            {
                $recevied_qty_qty = $row['recevied_qty'];
            }
            if($recevied_qty_qty == 0)
            {
                $flags = 2;
            }
        }
        $schedule_count_query = "SELECT input_job_no_random_ref FROM $brandix_bts.bundle_creation_data WHERE $column_in_where_condition = '$column_to_search' AND operation_id =$job_number[4]";
        $schedule_count_query = $link->query($schedule_count_query);
        if($schedule_count_query->num_rows > 0)
        {
            if($module_no==0){
                $schedule_query = "SELECT sum(recut_in)as recut_in,sum(replace_in)as replace_in,(SUM(send_qty)+SUM(recut_in)+SUM(replace_in))as send_qty,`color` as order_col_des,`size_title` as size_code,`bundle_number` as tid,sum(original_qty) as carton_act_qty,sum(recevied_qty) as reported_qty,sum(rejected_qty) as rejected_qty,((SUM(send_qty)+SUM(recut_in)+SUM(replace_in))-(SUM(recevied_qty)+SUM(rejected_qty))) as balance_to_report,GROUP_CONCAT(DISTINCT(docket_number) order by docket_number) as doc_no, `cut_number` as acutno, `input_job_no`,`input_job_no_random_ref` as input_job_no_random, 'bundle_creation_data' as flag,size_id as old_size,remarks,assigned_module,barcode_sequence FROM $brandix_bts.bundle_creation_data WHERE $column_in_where_condition = '$column_to_search' AND operation_id = $job_number[4] GROUP BY size_code,order_col_des,assigned_module order by tid";
                
            }else{
                $schedule_query = "SELECT sum(recut_in)as recut_in,sum(replace_in)as replace_in,(SUM(send_qty)+SUM(recut_in)+SUM(replace_in))as send_qty,`color` as order_col_des,`size_title` as size_code,`bundle_number` as tid,sum(original_qty) as carton_act_qty,sum(recevied_qty) as reported_qty,sum(rejected_qty) as rejected_qty,((SUM(send_qty)+SUM(recut_in)+SUM(replace_in))-(SUM(recevied_qty)+SUM(rejected_qty))) as balance_to_report,GROUP_CONCAT(DISTINCT(docket_number) order by docket_number) as doc_no, `cut_number` as acutno, `input_job_no`,`input_job_no_random_ref` as input_job_no_random, 'bundle_creation_data' as flag,size_id as old_size,remarks,assigned_module,barcode_sequence FROM $brandix_bts.bundle_creation_data WHERE $column_in_where_condition = '$column_to_search' AND operation_id =$job_number[4] and assigned_module = '$module_no' GROUP BY size_code,order_col_des,assigned_module order by tid";
            }

            $flag = 'bundle_creation_data';
        }
        else
        {
            if($bg == 1)
            {
                $schedule_query = "SELECT *,sum(carton_act_qty) as balance_to_report,sum(carton_act_qty) as carton_act_qty, 0 as reported_qty, 0 as rejected_qty,GROUP_CONCAT(DISTINCT(doc_no) order by doc_no) as doc_no,'packing_summary_input' as flag,0 as recut_in,0 as replace_in FROM $bai_pro3.packing_summary_input WHERE input_job_no_random = '$actual_input_job_number' GROUP BY size_code,order_col_des order by tid";
                $flag = 'packing_summary_input';
            }
            else
            {
                $schedule_query = "SELECT *,sum(carton_act_qty) as balance_to_report,sum(carton_act_qty) as carton_act_qty, 0 as reported_qty, 0 as rejected_qty,GROUP_CONCAT(DISTINCT(doc_no) order by doc_no) as doc_no,'packing_summary_input' as flag,0 as recut_in,0 as replace_in FROM $bai_pro3.packing_summary_input WHERE input_job_no_random = '$actual_input_job_number' GROUP BY tid order by tid";
                $flag = 'packing_summary_input';
            }
            
        }               
    }
    else
    {
        $schedule_count_query = "SELECT input_job_no_random_ref FROM $brandix_bts.bundle_creation_data WHERE input_job_no_random_ref = '$job_number[0]' AND operation_id =$job_number[4]";
        $schedule_count_query = $link->query($schedule_count_query);
        if($schedule_count_query->num_rows > 0)
        {
            if($module_no==0){
                $schedule_query = "SELECT sum(recut_in)as recut_in,sum(replace_in)as replace_in,(SUM(send_qty)+SUM(recut_in)+SUM(replace_in))as send_qty,`color` as order_col_des,`size_title` as size_code,`bundle_number` as tid,sum(original_qty) as carton_act_qty,sum(recevied_qty) as reported_qty,sum(rejected_qty) as rejected_qty,((SUM(send_qty)+SUM(recut_in)+SUM(replace_in))-(SUM(recevied_qty)+SUM(rejected_qty))) as balance_to_report,GROUP_CONCAT(DISTINCT(docket_number) order by docket_number) as doc_no, `cut_number` as acutno, `input_job_no`,`input_job_no_random_ref` as input_job_no_random, 'bundle_creation_data' as flag,size_id as old_size,remarks,assigned_module,barcode_sequence FROM $brandix_bts.bundle_creation_data WHERE $column_in_where_condition = '$column_to_search' AND operation_id = $job_number[4] GROUP BY size_code,order_col_des,assigned_module order by tid";
            }else{
                $schedule_query = "SELECT sum(recut_in)as recut_in,sum(replace_in)as replace_in,(SUM(send_qty)+SUM(recut_in)+SUM(replace_in))as send_qty,`color` as order_col_des,`size_title` as size_code,`bundle_number` as tid,sum(original_qty) as carton_act_qty,sum(recevied_qty) as reported_qty,sum(rejected_qty) as rejected_qty,((SUM(send_qty)+SUM(recut_in)+SUM(replace_in))-(SUM(recevied_qty)+SUM(rejected_qty))) as balance_to_report,GROUP_CONCAT(DISTINCT(docket_number) order by docket_number) as doc_no, `cut_number` as acutno, `input_job_no`,`input_job_no_random_ref` as input_job_no_random, 'bundle_creation_data' as flag,size_id as old_size,remarks,assigned_module,barcode_sequence FROM $brandix_bts.bundle_creation_data WHERE $column_in_where_condition = '$column_to_search' AND operation_id = $job_number[4] and assigned_module = '$module_no' GROUP BY size_code,order_col_des,assigned_module order by tid";
            }
            $flag = 'bundle_creation_data';
        }
        else
        {
            if($bg == 1)
            {
                $schedule_query = "SELECT *,sum(carton_act_qty) as balance_to_report,sum(carton_act_qty) as carton_act_qty, 0 as reported_qty, 0 as rejected_qty,GROUP_CONCAT(DISTINCT(doc_no) order by doc_no) as doc_no,'packing_summary_input' as flag,0 as recut_in,0 as replace_in FROM $bai_pro3.packing_summary_input WHERE input_job_no_random = '$actual_input_job_number' GROUP BY size_code,order_col_des order by tid";
                $flag = 'packing_summary_input';
            }
            else
            {
                $schedule_query = "SELECT *,sum(carton_act_qty) as balance_to_report,sum(carton_act_qty) as carton_act_qty, 0 as reported_qty, 0 as rejected_qty,GROUP_CONCAT(DISTINCT(doc_no) order by doc_no) as doc_no,'packing_summary_input' as flag,0 as recut_in,0 as replace_in FROM $bai_pro3.packing_summary_input WHERE input_job_no_random = '$actual_input_job_number' GROUP BY tid order by tid";
                $flag = 'packing_summary_input';
            }
        }
    }
    $s_no = 0;
    if($flags == 2)
    {
        $result_array['status'] = 'Previous operation not yet done for this job.';
    }
    else
    {
        $result_style_data = $link->query($schedule_query);
        $parellel_ops=array();
        while($row = $result_style_data->fetch_assoc()) 
        {
            $s_no++;
            $style = $job_number[1];
            $schedule = $job_number[2];
            $color = $row['order_col_des'];
            $size = $row['old_size'];
            if($flag == 'bundle_creation_data')
            {
                $assign = $row['assigned_module'];
                foreach ($ops_get_code as $key => $value)
                {
                    $color_pre = $row['order_col_des'] ;
                    $size_pre = $row['size_code'];
                    $module_pre = $row['assigned_module'];
                    $get_quantities = "SELECT sum(recevied_qty) as recevied_qty FROM $brandix_bts.bundle_creation_data WHERE $column_in_where_condition ='$column_to_search' AND operation_id =$value and color = '$color_pre' and size_title = '$size_pre' and assigned_module = '$module_pre'";
                        $result_ops_quantities = $link->query($get_quantities);
                        while($row3 = $result_ops_quantities->fetch_assoc()) 
                        {
                            $row['recevied_pre_qty'][$value][] = $row3['recevied_qty'];
                        } 
                }
            }
            if($flag == 'packing_summary_input')
            {
                $job_number_reference = $row['type_of_sewing'];
                if($job_number_reference == 3)
                {
                    $row['remarks'] = 'Sample';
                }
                else if($job_number_reference == 2)
                {
                    $row['remarks'] = 'Excess';
                }
                else
                {
                    $row['remarks'] = 'Normal';
                }
                $select_modudle_qry = "select input_module from $bai_pro3.plan_dashboard_input where input_job_no_random_ref = '$actual_input_job_number'";
                $result_select_modudle_qry = $link->query($select_modudle_qry);
                if($result_select_modudle_qry->num_rows > 0)
                {
                    while($row1 = $result_select_modudle_qry->fetch_assoc()) 
                    {
                        $row['assigned_module'] = $row1['input_module'];
                    }
                }
                else
                {
                    $result_array['status'] = 'Please assign module to this input job';
                }
                foreach ($ops_get_code as $key => $value)
                {
                    $row['recevied_pre_qty'][$value][] = 0;
                }
            }
            if($emb_cut_check_flag == 1)
            {
                $sum_balance = 0;
                $doc_no = $row['doc_no'];
                $size = $row['old_size'];
                $size_title = $row['size_code'];
                $min_val_doc_wise = array();
                $row_bundle_wise_qty =0;
                $bundle_tot_qty =0;

				if(sizeof($parellel_ops)<=0){
				$qry_parellel_ops="select operation_code from $brandix_bts.tbl_style_ops_master where style='$job_number[1]' and color = '$maped_color' and ops_dependency='$job_number[4]'";
				$qry_parellel_ops_result=mysqli_query($link,$qry_parellel_ops);
					if($qry_parellel_ops_result->num_rows > 0){
						while ($row_prellel = mysqli_fetch_array($qry_parellel_ops_result))
						{ 
							$parellel_ops[] = $row_prellel['operation_code'];
						}
					}
				}
				if(sizeof($parellel_ops)>0){
					//$parellel_operations = implode(',',$parellel_ops);
					$retreving_remaining_qty_qry = "select min(remaining_qty) as balance_to_report,doc_no FROM $bai_pro3.cps_log WHERE doc_no in ($doc_no) AND size_code='$size' AND operation_code in (".implode(',',$parellel_ops).")";
				}else{
			         $retreving_remaining_qty_qry = "SELECT sum(remaining_qty) as balance_to_report,doc_no FROM $bai_pro3.cps_log WHERE doc_no in ($doc_no) AND size_code='$size' AND operation_code = $pre_ops_code group by doc_no";
				}
                $result_retreving_remaining_qty_qry = $link->query($retreving_remaining_qty_qry);
                if($result_retreving_remaining_qty_qry->num_rows > 0)
                {
                    while($row_remaining = $result_retreving_remaining_qty_qry->fetch_assoc()) 
                    {
						$doc_no = $row_remaining['doc_no'];
						
						if(sizeof($parellel_ops)>0){
							//new logic here based on 2001 CR
							//get min qty of all operations
							$qry_min_prevops="SELECT MIN(recevied_qty) AS min_recieved_qty FROM brandix_bts.bundle_creation_data WHERE docket_number = $doc_no AND size_id ='$size' AND operation_id in (".implode(',',$parellel_ops).")";
							$result_qry_min_prevops = $link->query($qry_min_prevops);
							while($row_result_min_prevops = $result_qry_min_prevops->fetch_assoc()){
								$previous_minqty=$row_result_min_prevops['min_recieved_qty'];
							}

							//get Current operation alaready scanned qty
                            $current_recieved_qty="SELECT ((send_qty+recut_in+replace_in)-(recevied_qty+rejected_qty)) AS current_recieved_qty FROM brandix_bts.bundle_creation_data WHERE docket_number = $doc_no AND size_id ='$size' AND operation_id = '$job_number[4]'";
                            //echo "</br>".$current_recieved_qty."</br>";
							$result_current_recieved_qty = $link->query($current_recieved_qty);
							while($row_result_current_recieved_qty = $result_current_recieved_qty->fetch_assoc()){
								$current_ops_qty=$row_result_current_recieved_qty['current_recieved_qty'];
							}
							//echo "</br>Testing ".$current_ops_qty."</br>";
							$bal_toreport=($previous_minqty-$current_ops_qty);
							if($bal_toreport>0){
								$act_bal_to_report_dependency=$bal_toreport;
							}else{
								$act_bal_to_report_dependency=0;
							}

							if($flag == 'packing_summary_input')
								{
									$doc_wise_bundle_qty = "select sum(carton_act_qty)as carton_act_qty from $bai_pro3.packing_summary_input where doc_no = $doc_no and old_size ='$size' and $column_in_pack_summary ='$column_to_search'";
								}
								else
								{
									$doc_wise_bundle_qty = "SELECT (SUM(original_qty)+SUM(recut_in)+SUM(replace_in))-(SUM(recevied_qty)+SUM(rejected_qty)) AS carton_act_qty FROM `brandix_bts`.`bundle_creation_data` WHERE docket_number = $doc_no AND size_id ='$size' AND $column_in_where_condition ='$column_to_search' AND operation_id = $job_number[4] AND assigned_module = '$assign'";
								}
								// echo $doc_wise_bundle_qty.'</br>';
								$result_doc_wise_bundle_qty = $link->query($doc_wise_bundle_qty);
								while($row_bundle = $result_doc_wise_bundle_qty->fetch_assoc()) 
								{
									$replaced_qty = 0;
									if($job_number_reference == 2)
									{
										$qry_for_replacment_allocation_log = "select sum(replaced_qty)as replaced_qty from $bai_pro3.replacment_allocation_log where input_job_no_random_ref ='$actual_input_job_number' and size_title ='$size_title'";
										$result_qry_for_replacment_allocation_log = $link->query($qry_for_replacment_allocation_log);
										if($result_qry_for_replacment_allocation_log->num_rows > 0)
										{
											while($row_replace = $result_qry_for_replacment_allocation_log->fetch_assoc()) 
											{
												$replaced_qty = $row_replace['replaced_qty'];
											}
										}
									}
									$row_bundle_wise_qty = $row_bundle['carton_act_qty'] - $replaced_qty;
									$bundle_tot_qty += $row_bundle_wise_qty;
								}

								$min_val_doc_wise[] = min($act_bal_to_report_dependency,$row_bundle_wise_qty);

								if($bundle_tot_qty >= array_sum($min_val_doc_wise))
								{
									$act_bal_to_report = array_sum($min_val_doc_wise);
								}
								else
								{
									$act_bal_to_report = $bundle_tot_qty;
								}

								//echo "</br>".$act_bal_to_report."</br>";


						}else{

							if($flag == 'packing_summary_input')
								{
									$doc_wise_bundle_qty = "select sum(carton_act_qty)as carton_act_qty from $bai_pro3.packing_summary_input where doc_no = $doc_no and old_size ='$size' and $column_in_pack_summary ='$column_to_search'";
								}
								else
								{
									$doc_wise_bundle_qty = "SELECT (SUM(original_qty)+SUM(recut_in)+SUM(replace_in))-(SUM(recevied_qty)+SUM(rejected_qty)) AS carton_act_qty FROM `brandix_bts`.`bundle_creation_data` WHERE docket_number = $doc_no AND size_id ='$size' AND $column_in_where_condition ='$column_to_search' AND operation_id = $job_number[4] AND assigned_module = '$assign'";
								}
								// echo $doc_wise_bundle_qty.'</br>';
								$result_doc_wise_bundle_qty = $link->query($doc_wise_bundle_qty);
								while($row_bundle = $result_doc_wise_bundle_qty->fetch_assoc()) 
								{
									$replaced_qty = 0;
									if($job_number_reference == 2)
									{
										$qry_for_replacment_allocation_log = "select sum(replaced_qty)as replaced_qty from $bai_pro3.replacment_allocation_log where input_job_no_random_ref ='$actual_input_job_number' and size_title ='$size_title'";
										$result_qry_for_replacment_allocation_log = $link->query($qry_for_replacment_allocation_log);
										if($result_qry_for_replacment_allocation_log->num_rows > 0)
										{
											while($row_replace = $result_qry_for_replacment_allocation_log->fetch_assoc()) 
											{
												$replaced_qty = $row_replace['replaced_qty'];
											}
										}
									}
									$row_bundle_wise_qty = $row_bundle['carton_act_qty'] - $replaced_qty;
									$bundle_tot_qty += $row_bundle_wise_qty;
								}

								$sum_balance = $row_remaining['balance_to_report'];
								$min_val_doc_wise[] = min($row_remaining['balance_to_report'],$row_bundle_wise_qty);

								if($bundle_tot_qty >= array_sum($min_val_doc_wise))
								{
									$act_bal_to_report = array_sum($min_val_doc_wise);
								}
								else
								{
									$act_bal_to_report = $bundle_tot_qty;
								} 

						}
                       
                        
                    }
                                              
                    $result_array['emb_cut_check_flag'] = $pre_ops_code;
                    if(in_array($category_act,$emb_category))
                        $result_array['is_emb_flag'] = 1;
                    else    
                        $result_array['is_emb_flag'] = 0;
                }
                else
                {
                    $act_bal_to_report = 0;
                }
                $row['balance_to_report'] = $act_bal_to_report;
            }
            $result_array['table_data'][] = $row;
        }
        $result_array['flag'] = $flag;
    }
    $result_array['no_of_rows'] = $s_no;
    echo json_encode($result_array);    
}
if(isset($_GET['job_rev_no']))
{
    $job_rev_no = $_GET['job_rev_no'];
    if($job_rev_no != '')
    {
        getjobreversaldetails($job_rev_no);
    }
}
function getjobreversaldetails($job_rev_no)
{
    include("../../../../../common/config/config_ajax.php");    
    $operations_qty = "SELECT operation_name,operation_id FROM $brandix_bts.bundle_creation_data bc LEFT JOIN $brandix_bts.tbl_orders_ops_ref os ON os.operation_code=bc.operation_id WHERE input_job_no_random_ref='$job_rev_no' AND os.display_operations='yes' GROUP BY operation_id";
    $result_operations_qty = $link->query($operations_qty);
    if($result_operations_qty->num_rows > 0)
    {
        while($row_result_operations_qty = $result_operations_qty->fetch_assoc()) 
        {
            
            $json1[$row_result_operations_qty['operation_id']] = $row_result_operations_qty['operation_name'];
        }
    }
    else
    {
        $json1['status'] = "No Operations Done for this job";
    }
    $get_module_no = "SELECT distinct assigned_module FROM $brandix_bts.bundle_creation_data WHERE input_job_no_random_ref='$job_rev_no'";
    $module_result = $link->query($get_module_no);
    if($module_result->num_rows > 0)
    {
        while($module = $module_result->fetch_assoc()) 
        {
            
            $json1['assigned_module'][] = $module['assigned_module'];
        }
    }
    else
    {
        $json1['module_status'] = "No Module available for this job";
    }
 echo json_encode($json1);
}
if(isset($_GET['data_rev']))
{
    $data_rev = $_GET['data_rev'];
    if($data_rev != '')
    {
        getreversalscanningdetails($data_rev);
    }
}
function getreversalscanningdetails($job_number)
{
    $job_number = explode(",",$job_number);
    $module1 = $job_number[3];
    include("../../../../../common/config/config_ajax.php");
    //verifing next operation done are not
    $getting_style_qry ="select style,mapped_color as color from $brandix_bts.bundle_creation_data where input_job_no_random_ref = '$job_number[1]' and assigned_module='$module1' group by style";
    $result_getting_style_qry = $link->query($getting_style_qry);
    while($row = $result_getting_style_qry->fetch_assoc()) 
    {
        $style = $row['style'];
        $color = $row['color'];
    }

    $ops_seq_check = "select id,ops_sequence,ops_dependency,operation_order from $brandix_bts.tbl_style_ops_master where style='$style' and color = '$color' and operation_code=$job_number[0]";
    $result_ops_seq_check = $link->query($ops_seq_check);
    while($row = $result_ops_seq_check->fetch_assoc()) 
    {
        $ops_seq = $row['ops_sequence'];
        $seq_id = $row['id'];
        $ops_order = $row['operation_order'];
        if($row['ops_dependency'] != null)
        {
            $ops_dep = $row['ops_dependency'];
            $result_array['ops_dep'] = $ops_dep;
        }
        else
        {
            $result_array['ops_dep'] = 0;
        }
    }

    $checking_flag = 0;
    $ops_dep_check = "select ops_dependency from $brandix_bts.tbl_style_ops_master where style='$style' and color = '$color' and ops_sequence = '$ops_seq' and ops_dependency != 0 and ops_dependency != '' and operation_code = $job_number[0]";
    $result_ops_dep_check = $link->query($ops_dep_check);
    if($result_ops_dep_check->num_rows > 0)
    {
        $checking_flag = 1;
        while($row = $result_ops_dep_check->fetch_assoc()) 
        {
            $ops_dependency = $row['ops_dependency'];
        }
    }

    $post_ops_check = "select operation_code from $brandix_bts.tbl_style_ops_master where style='$style' and color = '$color' and ops_sequence = '$ops_seq' AND CAST(operation_order AS CHAR) > '$ops_order' and operation_code not in (10,200,15) ORDER BY operation_order ASC LIMIT 1";
    $result_post_ops_check = $link->query($post_ops_check);
    if($result_post_ops_check->num_rows > 0)
    {
        while($row = $result_post_ops_check->fetch_assoc()) 
        {
            $post_ops_code = $row['operation_code'];
        }
    }
    else
    {
        $post_ops_code = 0;
    }
    $result_array['post_ops'][] = $post_ops_code;
    if($post_ops_code != 0)
    {
        $pre_ops_validation = "SELECT id,(sum(recevied_qty)+sum(rejected_qty)) as recevied_qty,send_qty,size_title,bundle_number,color,assigned_module FROM $brandix_bts.bundle_creation_data_temp WHERE input_job_no_random_ref ='$job_number[1]' and assigned_module='$module1' AND operation_id = $job_number[0] GROUP BY size_title,color,assigned_module order by bundle_number";
        $result_pre_ops_validation = $link->query($pre_ops_validation);
        while($row = $result_pre_ops_validation->fetch_assoc()) 
        {
            $b_number = $row['bundle_number'];
            $sizes[] = $row['size_title'];
            $size_code = $row['size_title'];
            $color = $row['color'];
            $assigned_module = $row['assigned_module'];
            $post_ops_qry_to_find_rec_qty = "select group_concat(bundle_number) as bundles,(SUM(recevied_qty)+SUM(rejected_qty)) AS recevied_qty,size_title from $brandix_bts.bundle_creation_data_temp WHERE input_job_no_random_ref ='$job_number[1]' AND operation_id = $post_ops_code and remarks='$job_number[2]' and size_title='$size_code' and color='$color' and assigned_module = '$assigned_module' GROUP BY size_title,color,assigned_module order by bundle_number";
            $result_post_ops_qry_to_find_rec_qty = $link->query($post_ops_qry_to_find_rec_qty);
            if($result_post_ops_qry_to_find_rec_qty->num_rows > 0)
            {
                while($row3 = $result_post_ops_qry_to_find_rec_qty->fetch_assoc()) 
                {   
                    $remaining_qty=0;
                    $eligible=0;
                    $mo_no_qty=array();
                    $mo_no=array();
                    $bundle_ids=array();
                    $bundle_ids=$row3['bundles'];
                    $qty=$row3['recevied_qty'];
                    $bundle_mo = "SELECT mo_no from $bai_pro3.mo_operation_quantites WHERE ref_no in (".$bundle_ids.") AND op_code = $post_ops_code group by mo_no order by mo_no*1";
                    $result_bundle_mo = $link->query($bundle_mo);
                    while($row1 = $result_bundle_mo->fetch_assoc()) 
                    {
                        $mo_no[]=$row1['mo_no'];
                    }
                    // var_dump($mo_no);
                    $check_ops = "SELECT * from $bai_pro3.tbl_carton_ready WHERE mo_no in ('".implode("','",$mo_no)."') AND operation_id = $job_number[0] group by mo_no order by mo_no*1";
                    // echo $check_ops.'<br>';
                    $result_check_ops = $link->query($check_ops);
                    if($result_check_ops->num_rows > 0)
                    {
                        while($row2 = $result_check_ops->fetch_assoc()) 
                        {
                            $remaining_qty=$row2['remaining_qty'];
                            if($qty>0)
                            {
                                if($qty>=$remaining_qty)
                                {
                                    if ($remaining_qty > 0)
                                    {
                                        $eligible=$eligible+$remaining_qty;
                                        $qty=$qty-$remaining_qty;
                                    }
                                }
                                else
                                {
                                    $eligible=$eligible+$qty;
                                    $qty=0;
                                }
                            }                           
                        }
                        $result_array['rec_qtys'][] = $eligible;
                        $result_array['carton_ready_qty'][] = $eligible;
                    }
                    else
                    {
                        $result_array['rec_qtys'][] = $qty;
                    }    
                }
            }
            else
            {
                $result_array['rec_qtys'][] = 0;
            }
        }
    }
    else
    {
        $pre_ops_validation = "SELECT id,sum(recevied_qty) as recevied_qty,send_qty,size_title,bundle_number,color,assigned_module FROM $brandix_bts.bundle_creation_data_temp WHERE input_job_no_random_ref ='$job_number[1]' and assigned_module='$module1' AND operation_id = $job_number[0] GROUP BY size_title,color,assigned_module order by bundle_number";
        $result_pre_ops_validation = $link->query($pre_ops_validation);
        while($row = $result_pre_ops_validation->fetch_assoc()) 
        {
            $b_number = $row['bundle_number'];
            $size_code = $row['size_title'];
            $color = $row['color'];
            $assigned_module = $row['assigned_module'];
            //if($checking_flag == 1)
            {
                $post_ops_qry_to_find_rec_qty = "select group_concat(bundle_number) as bundles,(SUM(recevied_qty)) AS recevied_qty,size_title from $brandix_bts.bundle_creation_data_temp WHERE input_job_no_random_ref ='$job_number[1]' AND operation_id = $job_number[0] and remarks='$job_number[2]' and size_title='$size_code' and color='$color' and assigned_module = '$assigned_module' GROUP BY size_title,color,assigned_module order by bundle_number";
                $result_post_ops_qry_to_find_rec_qty = $link->query($post_ops_qry_to_find_rec_qty);
                if($result_post_ops_qry_to_find_rec_qty->num_rows > 0)
                {
                    while($row = $result_post_ops_qry_to_find_rec_qty->fetch_assoc()) 
                    {   
                        $remaining_qty=0;
                        $eligible=0;
                        $mo_no_qty=array();
                        $mo_no=array();
                        $bundle_ids=array();
                        $bundle_ids=$row['bundles'];
                        $qty=$row['recevied_qty'];
                        $bundle_mo = "SELECT mo_no from $bai_pro3.mo_operation_quantites WHERE ref_no in (".$bundle_ids.") AND op_code = $job_number[0] group by mo_no order by mo_no*1";
                        // echo $bundle_mo.'<br>';
                        $result_bundle_mo = $link->query($bundle_mo);
                        while($row1 = $result_bundle_mo->fetch_assoc()) 
                        {
                            $mo_no[]=$row1['mo_no'];
                        }
                        // var_dump($mo_no);
                        $check_ops = "SELECT * from $bai_pro3.tbl_carton_ready WHERE mo_no in ('".implode("','",$mo_no)."') AND operation_id = $job_number[0] group by mo_no order by mo_no*1";
                        // echo $check_ops.'<br>';
                        $result_check_ops = $link->query($check_ops);
                        if($result_check_ops->num_rows > 0)
                        {
                            while($row2 = $result_check_ops->fetch_assoc()) 
                            {
                                $remaining_qty=$row2['remaining_qty'];
                                if($qty>0)
                                {
                                    if($qty>=$remaining_qty)
                                    {
                                        if ($remaining_qty > 0)
                                        {
                                            $eligible=$eligible+$remaining_qty;
                                            $qty=$qty-$remaining_qty;
                                        }                                           
                                    }
                                    else
                                    {
                                        $eligible=$eligible+$qty;
                                        $qty=0;
                                    }
                                }                           
                            }
                            $result_array['rec_qtys'][] = $eligible;
                            $result_array['carton_ready_qty'][] = $eligible;
                        }
                        else
                        {
                            $result_array['rec_qtys'][] = 0;
                        }    
                    }
                }
                else
                {
                    $result_array['rec_qtys'][] = 0;
                }
            }
        }
        
    }

    $job_details_qry = "SELECT id,style,`color` AS order_col_des,`size_title` AS size_code,`bundle_number` AS tid,`original_qty` AS carton_act_qty,SUM(`recevied_qty`) AS reported_qty,SUM(rejected_qty) AS rejected_qty,(SUM(send_qty)-SUM(recevied_qty)) AS balance_to_report,`docket_number` AS doc_no, `cut_number` AS acutno, `input_job_no`,`input_job_no_random_ref` AS input_job_no_random, 'bundle_creation_data' AS flag,operation_id,remarks,size_id,assigned_module FROM $brandix_bts.bundle_creation_data_temp WHERE input_job_no_random_ref = '$job_number[1]' and assigned_module='$module1' AND operation_id = $job_number[0] AND remarks = '$job_number[2]' GROUP BY size_title,color,assigned_module order by bundle_number";
    $job_details_qry = $link->query($job_details_qry);
    if($job_details_qry->num_rows > 0)
    {
        while($row = $job_details_qry->fetch_assoc()) 
        {
            $size_code = $row['size_code'];
            $color = $row['order_col_des'];
            $module = $row['assigned_module'];
            $job_qty_qry = "select sum(original_qty) AS carton_act_qty,mapped_color FROM $brandix_bts.bundle_creation_data where input_job_no_random_ref = '$job_number[1]' AND operation_id = $job_number[0] AND size_title ='$size_code' AND color='$color' and assigned_module ='$module' order by bundle_number";
            $result_job_qty_qry = $link->query($job_qty_qry);
            while($row_result_job_qty_qry = $result_job_qty_qry->fetch_assoc()) 
            {
                $row['carton_act_qty'] = $row_result_job_qty_qry['carton_act_qty'];
                $row['mapped_color'] = $row_result_job_qty_qry['mapped_color'];
            }
            $result_array['table_data'][] = $row;
        }
    }
    else
    {
        $result_array['status'] = 'Invalid Operation';
    }
    echo json_encode($result_array);
}

if(isset($_GET['validating_remarks']))
{
    $validating_remarks = $_GET['validating_remarks'];
    if($validating_remarks != '')
    {
        validating_remarks_with_qty($validating_remarks);
    }
}
function validating_remarks_with_qty($validating_remarks)
{
    $validating_remarks = explode(",",$validating_remarks);
    if($validating_remarks[5] == 0)
    {
        $flag = 0;
        $total = 0;
        $check_flag = 0;
        $ops_dependency = array();
        $count = $validating_remarks[4];
        $html_response = "";
        include("../../../../../common/config/config_ajax.php");
        if($validating_remarks[5] == 0)
        {
            $fetching_job_number_from_bundle = "select input_job_no_random FROM $bai_pro3.packing_summary_input where tid=$validating_remarks[0]";
            $result_fetching_job_number_from_bundle = $link->query($fetching_job_number_from_bundle);
            while($row = $result_fetching_job_number_from_bundle->fetch_assoc()) 
            {
                $validating_remarks[0] = $row['input_job_no_random'];
                
            }
        }
        $getting_style_qry ="select style,mapped_color as color from $brandix_bts.bundle_creation_data where input_job_no_random_ref = '$validating_remarks[0]' group by style";
        $result_getting_style_qry = $link->query($getting_style_qry);
        while($row = $result_getting_style_qry->fetch_assoc()) 
        {
            $style = $row['style'];
            $color = $row['color'];
        }
        $ops_dep_array_qry = "select ops_dependency from $brandix_bts.tbl_style_ops_master where style='$style' and color = '$color' and ops_dependency != 0 and ops_dependency != 'NULL' group by ops_dependency";
        $result_ops_dep_array_qry = $link->query($ops_dep_array_qry);
        while($row = $result_ops_dep_array_qry->fetch_assoc()) 
        {
            $ops_dependency[] = $row['ops_dependency'];
        }
        $qry_for_fetching_bal_to_report_qty_pre = "select bundle_number from $brandix_bts.bundle_creation_data_temp where bundle_number = $validating_remarks[1] and operation_id = $validating_remarks[2] and remarks='$validating_remarks[3]' order by bundle_number";
        $result_qry_for_fetching_bal_to_report_qty_pre = $link->query($qry_for_fetching_bal_to_report_qty_pre);
        if($result_qry_for_fetching_bal_to_report_qty_pre->num_rows > 0 && in_array($validating_remarks[2],$ops_dependency))
        {
            $check_flag = 1;
        }
        else
        {
            $check_flag = 0;
        }
        $fetching_dependency_ops_qry = "select operation_code from $brandix_bts.tbl_style_ops_master where style='$style' and color = '$color' and ops_dependency = $validating_remarks[2]";
        $result_fetching_dependency_ops_qry = $link->query($fetching_dependency_ops_qry);
        while($row = $result_fetching_dependency_ops_qry->fetch_assoc()) 
        {
            $dependency_operation[] = $row['operation_code'];
        }
        if(in_array($validating_remarks[2],$ops_dependency) && $check_flag == 0)
        {
            $result_qry_for_fetching_bal_to_report_qty = "select sum(recevied_qty)as rec_qty from $brandix_bts.bundle_creation_data_temp where bundle_number =".$validating_remarks[1]." AND remarks = '".$validating_remarks[3]."' and operation_id in (".implode(',',$dependency_operation).") group by operation_id";
            $result_qry_for_fetching_bal_to_report_qty = $link->query($result_qry_for_fetching_bal_to_report_qty);
            if($result_qry_for_fetching_bal_to_report_qty->num_rows>0)
            {
                while($row = $result_qry_for_fetching_bal_to_report_qty->fetch_assoc()) 
                {
                    $qty[] = $row['rec_qty'];
                }
            }
            else
            {
                $qty[] = 0;
            }
            if(sizeof($qty) != sizeof($dependency_operation))
            {
                $qty = 0;
            }
            else
            {
                $qty = min($qty);
            }
            $html_response .= "$qty".","."1";
        }else
        {
            $ops_seq_check = "select id,ops_sequence,ops_dependency,operation_order from $brandix_bts.tbl_style_ops_master where style='$style' and color = '$color' and operation_code=$validating_remarks[2]";
            $result_ops_seq_check = $link->query($ops_seq_check);
            while($row = $result_ops_seq_check->fetch_assoc()) 
            {
                $ops_seq = $row['ops_sequence'];
                $seq_id = $row['id'];
                $ops_order = $row['operation_order'];
                if($row['ops_dependency'] != null)
                {
                    $ops_dep = $row['ops_dependency'];
                    $result_array['ops_dep'] = $ops_dep;
                    
                }
                else
                {
                    $result_array['ops_dep'] = 0;
                }
            }
            $post_ops_check = "select operation_code from $brandix_bts.tbl_style_ops_master where style='$style' and color = '$color' and ops_sequence = '$ops_seq' AND operation_order < '$ops_order' order by operation_order ASC ";
            $result_post_ops_check = $link->query($post_ops_check);
            if($result_post_ops_check->num_rows > 0)
            {
                while($row = $result_post_ops_check->fetch_assoc()) 
                {
                    $post_ops_code = $row['operation_code'];
                }
            }
            else
            {
                $post_ops_code = 0;
            }
            if($check_flag == 1)
            {
                $result_qry_for_fetching_bal_to_report_qty = "select min(recevied_qty)as rec_qty from $brandix_bts.bundle_creation_data_temp where bundle_number =".$validating_remarks[1]." AND remarks = '".$validating_remarks[3]."' and recevied_qty > 0 and operation_id in (".implode(',',$dependency_operation).") group by operation_id";
                $result_qry_for_fetching_bal_to_report_qty = $link->query($result_qry_for_fetching_bal_to_report_qty);
                if($result_qry_for_fetching_bal_to_report_qty->num_rows>0)
                {
                    while($row = $result_qry_for_fetching_bal_to_report_qty->fetch_assoc()) 
                    {
                        $qty[] = $row['rec_qty'];
                    }
                }
                else
                {
                    $qty[] = 0;
                }
                if(sizeof($dependency_operation) != sizeof($qty))
                {
                    $qty = 0;
                }
                $send_qty = min($qty);
                
            }
            else
            {
                $fetching_send_qty_from_main = "select send_qty from $brandix_bts.bundle_creation_data where bundle_number = $validating_remarks[1] and operation_id = $validating_remarks[2]";
                $result_fetching_send_qty_from_main = $link->query($fetching_send_qty_from_main);
                while($row = $result_fetching_send_qty_from_main->fetch_assoc()) 
                {
                    $send_qty = $row['send_qty'];
                    
                }
            }
            
            $qry_for_fetching_bal_to_report_qty_pre = "select bundle_number from $brandix_bts.bundle_creation_data_temp where bundle_number = $validating_remarks[1] and operation_id = $validating_remarks[2] and remarks='$validating_remarks[3]' order by bundle_number";
            $result_qry_for_fetching_bal_to_report_qty_pre = $link->query($qry_for_fetching_bal_to_report_qty_pre);
            if($result_qry_for_fetching_bal_to_report_qty_pre->num_rows > 0)
            {
                $qry_for_fetching_bal_to_report_qty_post = "select $send_qty-(SUM(recevied_qty)) as rec_qty,remarks from $brandix_bts.bundle_creation_data_temp where bundle_number = $validating_remarks[1] and operation_id = $validating_remarks[2] and remarks = '$validating_remarks[3]' order by bundle_number";
                $result_qry_for_fetching_bal_to_report_qty_post = $link->query($qry_for_fetching_bal_to_report_qty_post);
                while($row = $result_qry_for_fetching_bal_to_report_qty_post->fetch_assoc()) 
                {
                    $remarks_post = $row['remarks'];
                    $rec_qty = $row['rec_qty'];
                    if($post_ops_code == 0)
                    {
                        $qry_for_fetching_bal_to_report_qty_post_post = "select sum(recevied_qty) as rec_qty,remarks from $brandix_bts.bundle_creation_data_temp where bundle_number = $validating_remarks[1] and operation_id = $validating_remarks[2] and remarks <> '$remarks_post' order by bundle_number";
                    }
                    else
                    {
                        $qry_for_fetching_bal_to_report_qty_post_post = "select sum(recevied_qty) as rec_qty,remarks from $brandix_bts.bundle_creation_data_temp where bundle_number = $validating_remarks[1] and operation_id = $post_ops_code and remarks <> '$remarks_post' order by bundle_number";
                    }
                    $result_qry_for_fetching_bal_to_report_qty_post_post = $link->query($qry_for_fetching_bal_to_report_qty_post_post);
                    while($row = $result_qry_for_fetching_bal_to_report_qty_post_post->fetch_assoc()) 
                    {
                        if($check_flag != 1)
                        {
                            $act_rec_qty = $rec_qty - $row['rec_qty'];
                            if($act_rec_qty < 0)
                            {
                                $act_rec_qty = 0;
                            }
                        }
                        else
                        {
                            $act_rec_qty = $rec_qty;
                        }
                        if($act_rec_qty == '')
                        {
                            $act_rec_qty = 0;
                        }
                        $html_response .= "$act_rec_qty".","."1";
                    }
                }
            }
            else
            {
                if($post_ops_code != 0)
                {
                    $qry_for_fetching_bal_to_report_qty = "select (sum(recevied_qty))as rec_qty,remarks from $brandix_bts.bundle_creation_data_temp where bundle_number = $validating_remarks[1] and operation_id = $post_ops_code and remarks = '$validating_remarks[3]' order by bundle_number";
                }
                else
                {
                    $qry_for_fetching_bal_to_report_qty = "select (send_qty-(recevied_qty))AS rec_qty,remarks from $brandix_bts.bundle_creation_data where bundle_number = $validating_remarks[1] and operation_id = $validating_remarks[2]";
                }
                $result_qry_for_fetching_bal_to_report_qty = $link->query($qry_for_fetching_bal_to_report_qty);
                while($row = $result_qry_for_fetching_bal_to_report_qty->fetch_assoc()) 
                {
                    $qty = $row['rec_qty'];
                    if($qty == '')
                    {
                        $qty = 0;
                    }
                    $html_response .= "$qty".","."1";
                }
            }
            
        }
        
        echo $html_response;
    }
    else
    {
        $flag = 0;
        $total = 0;
        $check_flag = 0;
        $ops_dependency = array();
        $count = $validating_remarks[4];
        $module = $validating_remarks[6];
        $html_response = "";
        include("../../../../../common/config/config_ajax.php");
        $query_to_fetch_individual_bundles = "select tid,order_col_des,old_size,size_code,carton_act_qty,acutno,input_job_no FROM $bai_pro3.packing_summary_input where tid=$validating_remarks[1]";
        $qry_nop_result = $link->query($query_to_fetch_individual_bundles);
        while($nop_qry_row = $qry_nop_result->fetch_assoc()) 
        {
            $color_act = $nop_qry_row['order_col_des'];
            $size_act = $nop_qry_row['size_code'];

        }

        if($validating_remarks[5] == 0)
        {
            $fetching_job_number_from_bundle = "select input_job_no_random FROM $bai_pro3.packing_summary_input where tid=$validating_remarks[0]";
            $result_fetching_job_number_from_bundle = $link->query($fetching_job_number_from_bundle);
            while($row = $result_fetching_job_number_from_bundle->fetch_assoc()) 
            {
                $validating_remarks[0] = $row['input_job_no_random'];               
            }
        }
        $getting_style_qry ="select style,mapped_color as color from $brandix_bts.bundle_creation_data where input_job_no_random_ref = '$validating_remarks[0]' group by style";
        $result_getting_style_qry = $link->query($getting_style_qry);
        while($row = $result_getting_style_qry->fetch_assoc()) 
        {
            $style = $row['style'];
            $color = $row['color'];
        }
        $ops_dep_array_qry = "select ops_dependency from $brandix_bts.tbl_style_ops_master where style='$style' and color = '$color' and ops_dependency != 0 and ops_dependency != 'NULL' group by ops_dependency";
        $result_ops_dep_array_qry = $link->query($ops_dep_array_qry);
        while($row = $result_ops_dep_array_qry->fetch_assoc()) 
        {
            $ops_dependency[] = $row['ops_dependency'];
        }
        $qry_for_fetching_bal_to_report_qty_pre = "select bundle_number from $brandix_bts.bundle_creation_data_temp where operation_id = $validating_remarks[2] and remarks='$validating_remarks[3]' and color='$color_act' and size_title='$size_act' AND input_job_no_random_ref = '$validating_remarks[0]' and assigned_module = '$module' order by bundle_number";
        $result_qry_for_fetching_bal_to_report_qty_pre = $link->query($qry_for_fetching_bal_to_report_qty_pre);
        if($result_qry_for_fetching_bal_to_report_qty_pre->num_rows > 0 && in_array($validating_remarks[2],$ops_dependency))
        {
                $check_flag = 1;
        }
        else
        {
            $check_flag = 0;
        }
        $fetching_dependency_ops_qry = "select operation_code from $brandix_bts.tbl_style_ops_master where style='$style' and color = '$color' and ops_dependency = $validating_remarks[2]";
        $result_fetching_dependency_ops_qry = $link->query($fetching_dependency_ops_qry);
        while($row = $result_fetching_dependency_ops_qry->fetch_assoc()) 
        {
            $dependency_operation[] = $row['operation_code'];
        }
        if(in_array($validating_remarks[2],$ops_dependency) && $check_flag == 0)
        {
            $result_qry_for_fetching_bal_to_report_qty = "select sum(recevied_qty)as rec_qty from $brandix_bts.bundle_creation_data_temp where remarks = '".$validating_remarks[3]."' and operation_id in (".implode(',',$dependency_operation).") and color='$color_act' and size_title='$size_act' AND input_job_no_random_ref = '$validating_remarks[0]' and assigned_module = '$module' group by operation_id";
            $result_qry_for_fetching_bal_to_report_qty = $link->query($result_qry_for_fetching_bal_to_report_qty);
            if($result_qry_for_fetching_bal_to_report_qty->num_rows>0)
            {
                while($row = $result_qry_for_fetching_bal_to_report_qty->fetch_assoc()) 
                {
                    $qty[] = $row['rec_qty'];
                }
            }
            else
            {
                $qty[] = 0;
            }
            if(sizeof($qty) != sizeof($dependency_operation))
            {
                $qty = 0;
            }
            else
            {
                $qty = min($qty);
            }
            
            $html_response .= "$qty".","."1";
        }
        
        else
        {
            $ops_seq_check = "select id,ops_sequence,ops_dependency,operation_order from $brandix_bts.tbl_style_ops_master where style='$style' and color = '$color' and operation_code=$validating_remarks[2]";
            $result_ops_seq_check = $link->query($ops_seq_check);
            while($row = $result_ops_seq_check->fetch_assoc()) 
            {
                $ops_seq = $row['ops_sequence'];
                $seq_id = $row['id'];
                $ops_order = $row['operation_order'];
                if($row['ops_dependency'] != null)
                {
                    $ops_dep = $row['ops_dependency'];
                    $result_array['ops_dep'] = $ops_dep;
                    
                }
                else
                {
                    $result_array['ops_dep'] = 0;
                }
            }
            $post_ops_check = "select operation_code from $brandix_bts.tbl_style_ops_master where style='$style' and color = '$color' and ops_sequence = '$ops_seq' AND operation_order < '$ops_order' order by operation_order ASC ";
            $result_post_ops_check = $link->query($post_ops_check);
            if($result_post_ops_check->num_rows > 0)
            {
                while($row = $result_post_ops_check->fetch_assoc()) 
                {
                    $post_ops_code = $row['operation_code'];
                }
            }
            else
            {
                $post_ops_code = 0;
            }
            if($check_flag == 1)
            {
                $result_qry_for_fetching_bal_to_report_qty = "select sum(recevied_qty)as rec_qty from $brandix_bts.bundle_creation_data_temp where remarks = '".$validating_remarks[3]."' and operation_id in (".implode(',',$dependency_operation).") and color='$color_act' and size_title='$size_act' AND input_job_no_random_ref = '$validating_remarks[0]' and assigned_module = '$module' group by operation_id";
                $result_qry_for_fetching_bal_to_report_qty = $link->query($result_qry_for_fetching_bal_to_report_qty);
                if($result_qry_for_fetching_bal_to_report_qty->num_rows>0)
                {
                    while($row = $result_qry_for_fetching_bal_to_report_qty->fetch_assoc()) 
                    {
                        $qty[] = $row['rec_qty'];
                    }
                }
                else
                {
                    $qty[] = 0;
                }
                if(sizeof($dependency_operation) != sizeof($qty))
                {
                    $qty = 0;
                }
                $send_qty = min($qty);
                
            }
            else
            {
                $fetching_send_qty_from_main = "select sum(send_qty)as send_qty from $brandix_bts.bundle_creation_data where operation_id = $validating_remarks[2] and color='$color_act' and size_title='$size_act' AND input_job_no_random_ref = '$validating_remarks[0]' and assigned_module = '$module'";
                $result_fetching_send_qty_from_main = $link->query($fetching_send_qty_from_main);
                while($row = $result_fetching_send_qty_from_main->fetch_assoc()) 
                {
                    $send_qty = $row['send_qty'];
                    
                }
            }           
            $qry_for_fetching_bal_to_report_qty_pre = "select * from $brandix_bts.bundle_creation_data_temp where operation_id = $validating_remarks[2] and remarks='$validating_remarks[3]' and color='$color_act' and size_title='$size_act' AND input_job_no_random_ref = '$validating_remarks[0]' and assigned_module = '$module' order by bundle_number ";
            $result_qry_for_fetching_bal_to_report_qty_pre = $link->query($qry_for_fetching_bal_to_report_qty_pre);
            if($result_qry_for_fetching_bal_to_report_qty_pre->num_rows > 0)
            {
                $qry_for_fetching_bal_to_report_qty_post = "select $send_qty-(SUM(recevied_qty)) as rec_qty,remarks from $brandix_bts.bundle_creation_data_temp where operation_id = $validating_remarks[2] and remarks = '$validating_remarks[3]' and color='$color_act' and size_title='$size_act' AND input_job_no_random_ref = '$validating_remarks[0]' and assigned_module = '$module' order by bundle_number";
                $result_qry_for_fetching_bal_to_report_qty_post = $link->query($qry_for_fetching_bal_to_report_qty_post);
                while($row = $result_qry_for_fetching_bal_to_report_qty_post->fetch_assoc()) 
                {
                    $remarks_post = $row['remarks'];
                    $rec_qty = $row['rec_qty'];
                    if($post_ops_code == 0)
                    {
                        $qry_for_fetching_bal_to_report_qty_post_post = "select sum(recevied_qty) as rec_qty,remarks from $brandix_bts.bundle_creation_data_temp where operation_id = $validating_remarks[2] and remarks <> '$remarks_post' and color='$color_act' and size_title='$size_act' AND input_job_no_random_ref = '$validating_remarks[0]' and assigned_module = '$module' order by bundle_number";
                    }
                    else
                    {
                        $qry_for_fetching_bal_to_report_qty_post_post = "select sum(recevied_qty) as rec_qty,remarks from $brandix_bts.bundle_creation_data_temp where operation_id = $post_ops_code and remarks <> '$remarks_post' and color='$color_act' and size_title='$size_act' AND input_job_no_random_ref = '$validating_remarks[0]' and assigned_module = '$module' order by bundle_number";
                    }
                    $result_qry_for_fetching_bal_to_report_qty_post_post = $link->query($qry_for_fetching_bal_to_report_qty_post_post);
                    while($row = $result_qry_for_fetching_bal_to_report_qty_post_post->fetch_assoc()) 
                    {
                        if($check_flag != 1)
                        {
                            $act_rec_qty = $rec_qty - $row['rec_qty'];
                            if($act_rec_qty < 0)
                            {
                                $act_rec_qty = 0;
                            }
                        }
                        else
                        {
                            $act_rec_qty = $rec_qty;
                        }
                        if($act_rec_qty == '')
                        {
                            $act_rec_qty = 0;
                        }
                        $html_response .= "$act_rec_qty".","."1";
                    }
                }
            }
            else
            {
                if($post_ops_code != 0)
                {
                    $qry_for_fetching_bal_to_report_qty = "select (sum(recevied_qty))as rec_qty,remarks from $brandix_bts.bundle_creation_data_temp where operation_id = $post_ops_code and remarks = '$validating_remarks[3]' and color='$color_act' and size_title='$size_act' AND input_job_no_random_ref = '$validating_remarks[0]' and assigned_module = '$module' order by bundle_number";
                }
                else
                {
                    $qry_for_fetching_bal_to_report_qty = "select (SUM(send_qty)-(SUM(recevied_qty)))AS rec_qty,remarks from $brandix_bts.bundle_creation_data where operation_id = $validating_remarks[2] and color='$color_act' and size_title='$size_act' AND input_job_no_random_ref = '$validating_remarks[0]' and assigned_module = '$module'";
                }
                $result_qry_for_fetching_bal_to_report_qty = $link->query($qry_for_fetching_bal_to_report_qty);
                while($row = $result_qry_for_fetching_bal_to_report_qty->fetch_assoc()) 
                {
                    $qty = $row['rec_qty'];
                    if($qty == '')
                    {
                        $qty = 0;
                    }
                    $html_response .= "$qty".","."1";
                    
                }
            }           
        }
        echo $html_response;
    }   
}

if(isset($_GET['doc_number']))
{
    $doc_number = $_GET['doc_number'];
    if($doc_number != '')
    {
        getCutDetails($doc_number);
    }
}

function getCutDetails($doc_number){
    $doc_number = explode(",",$doc_number);
    $doc_no = $doc_number[0];
    $op_code = $doc_number[1];
    $module = $doc_number[2];
    $style = $doc_number[3];
    $schedule = $doc_number[4];
    $color = $doc_number[5];
    if($doc_no)
    {
        include("../../../../../common/config/config_ajax.php");
        
        $ops_dep_qry = "SELECT ops_dependency,operation_code FROM $brandix_bts.tbl_style_ops_master WHERE style='$style' AND color = '$color' AND ops_dependency != 200 AND ops_dependency != 0";
        //echo $ops_dep_qry;
        $result_ops_dep_qry = $link->query($ops_dep_qry);
        while($row = $result_ops_dep_qry->fetch_assoc()) 
        {
            if($row['ops_dependency'])
            {
                if($row['ops_dependency'] == $op_code)
                {
                    $ops_dep_code = $row['operation_code'];
                    $schedule_count_query = "SELECT sum(recevied_qty)as recevied_qty FROM $brandix_bts.bundle_creation_data WHERE docket_number=$doc_no AND operation_id =$ops_dep_code";
                    $schedule_count_query = $link->query($schedule_count_query);
                    if($schedule_count_query->num_rows > 0)
                    {
                        while($row = $schedule_count_query->fetch_assoc()) 
                        {
                            $recevied_qty = $row['recevied_qty'];
                        }
                        if($recevied_qty == 0)
                        {
                            $ops_dep_flag =1;
                            $result_array['status'] = 'The dependency operations for this operation are not yet done.';
                            echo json_encode($result_array);
                            die();
                        }
                    }
                }
            }
        }
        $flags=0;       
        $ops_seq_check = "select id,ops_sequence,operation_order from $brandix_bts.tbl_style_ops_master where style='$style' and color = '$color' and operation_code=$op_code";
        $result_ops_seq_check = $link->query($ops_seq_check);
        if($result_ops_seq_check->num_rows > 0)
        {
            while($row = $result_ops_seq_check->fetch_assoc()) 
            {
                $ops_seq = $row['ops_sequence'];
                $seq_id = $row['id'];
                $ops_order = $row['operation_order'];
            }
        }
        else
        {
            $result_array['status'] = 'Invalid Operation for this cut number.Plese verify Operation Mapping.';
            echo json_encode($result_array);
            die();
        }

        $pre_ops_code = '';
		$emb_category = 'Send PF';
   
	    $get_operations = "select operation_code from $brandix_bts.tbl_orders_ops_ref where category ='$emb_category'";
	    //echo $get_operations;
	    $result_ops = $link->query($get_operations);
	    while($row_ops = $result_ops->fetch_assoc())
	    {
	      $operations[] = $row_ops['operation_code'];
	    }
		$emb_operations = implode(',',$operations);
		
		$get_code="select previous_operation from $brandix_bts.tbl_style_ops_master where style='$style' and color = '$color' and operation_code in ($emb_operations)";
		//echo $get_code;
		$result_get_code_check = $link->query($get_code);
		if($result_get_code_check->num_rows > 0)
		{
			while($row = $result_get_code_check->fetch_assoc())
			{
			   $pre_ops_code = $row['previous_operation'];	
			}

		}
        
        $pre_ops_check = "select operation_code from $brandix_bts.tbl_style_ops_master where style='$style' and color = '$color' AND ops_sequence = '$ops_seq' AND CAST(operation_order AS CHAR) < '$ops_order' and operation_code != 10 ORDER BY operation_order DESC LIMIT 1";
        $result_pre_ops_check = $link->query($pre_ops_check);
        if($result_pre_ops_check->num_rows > 0)
        {
            while($row = $result_pre_ops_check->fetch_assoc()) 
            {
                if($pre_ops_code == 0){
				   $pre_ops_code = $row['operation_code'];
				}
            }
            $pre_ops_validation = "SELECT sum(recevied_qty)as recevied_qty FROM $brandix_bts.bundle_creation_data WHERE docket_number=$doc_no AND operation_id = $pre_ops_code";
            $result_pre_ops_validation = $link->query($pre_ops_validation);
            while($row = $result_pre_ops_validation->fetch_assoc()) 
            {
                $recevied_qty_qty = $row['recevied_qty'];
            }
            if($recevied_qty_qty == 0)
            {
                $flags = 2;
            }
            else
            {
                $schedule_query = "SELECT (SUM(send_qty)+SUM(recut_in)+SUM(replace_in))as send_qty,`color` as order_col_des,`size_title` as size_code,`bundle_number` as tid,sum(original_qty) as carton_act_qty,sum(recevied_qty) as reported_qty,sum(rejected_qty) as rejected_qty,(SUM(send_qty)+SUM(recut_in)+SUM(replace_in))-(SUM(recevied_qty)+SUM(rejected_qty)) as balance_to_report,`docket_number` as doc_no, `cut_number` as acutno, `input_job_no`,`input_job_no_random_ref` as input_job_no_random, 'bundle_creation_data' as flag,size_id as old_size,remarks,assigned_module FROM $brandix_bts.bundle_creation_data WHERE docket_number=$doc_no AND operation_id = $op_code GROUP BY size_code,order_col_des,assigned_module order by tid";         
            }
        }
        else
        {
            $schedule_count_query = "SELECT docket_number FROM $brandix_bts.bundle_creation_data WHERE docket_number = $doc_no AND operation_id =$op_code";
            $schedule_count_query = $link->query($schedule_count_query);
            if($schedule_count_query->num_rows > 0)
            {
                $schedule_query = "SELECT (SUM(send_qty)+SUM(recut_in)+SUM(replace_in))as send_qty,`color` as order_col_des,`size_title` as size_code,`bundle_number` as tid,sum(original_qty) as carton_act_qty,sum(recevied_qty) as reported_qty,sum(rejected_qty) as rejected_qty,(SUM(send_qty)+SUM(recut_in)+SUM(replace_in))-(SUM(recevied_qty)+SUM(rejected_qty)) as balance_to_report,`docket_number` as doc_no, `cut_number` as acutno, `input_job_no`,`input_job_no_random_ref` as input_job_no_random, 'bundle_creation_data' as flag,size_id as old_size,remarks,assigned_module FROM $brandix_bts.bundle_creation_data WHERE docket_number=$doc_no AND operation_id = $op_code GROUP BY size_code,order_col_des,assigned_module order by tid";
                $flags=3;
            }   
        }
        if($flags == 2)
        {
            $result_array['status'] = 'Previous operation not yet done for this cut job.';
        }
        else
        {
            $result_style_data = $link->query($schedule_query);
            while($row = $result_style_data->fetch_assoc()) 
            {
                $result_array['table_data'][] = $row;
            }
        }
        echo json_encode($result_array);
    }

}
if(isset($_GET['pre_array_module']))
{
    $pre_array_module = $_GET['pre_array_module'];
    if($pre_array_module != '')
    {
        validating_with_module($pre_array_module);
    }
}
function validating_with_module($pre_array_module)
{
    include("../../../../../common/config/config_ajax.php");
    $block_priorities = null;
    $pre_array_module = explode(",",$pre_array_module);
    $module = $pre_array_module[0];
    $job_no = $pre_array_module[1];
    $operation = $pre_array_module[2];
    $screen = $pre_array_module[3];
    $scan_type = $pre_array_module[4];
    
    $application='IPS';
    $get_routing_query="SELECT operation_code from $brandix_bts.tbl_ims_ops where appilication='$application'";
    $routing_result=mysqli_query($link, $get_routing_query) or exit("error while fetching opn routing");
    $opn_routing=mysqli_fetch_array($routing_result);
    $opn_routing_code = $opn_routing['operation_code'];

    $input_job_array = array();
    $response_flag = 0; $go_here = 0;
    
    if ($module == 0)
    {
        if ($scan_type == 0)
        {
            # bundle level
            $get_module_no = "SELECT input_module FROM $bai_pro3.plan_dashboard_input where input_job_no_random_ref in (select input_job_no_random from $bai_pro3.pac_stat_log_input_job where tid=$job_no)";
            $get_module_no_bcd = "SELECT assigned_module FROM $brandix_bts.bundle_creation_data WHERE bundle_number = '$job_no'";
        }
        else if ($scan_type == 1)
        {
            # sewing job level
            $get_module_no = "SELECT input_module FROM $bai_pro3.plan_dashboard_input where input_job_no_random_ref = '$job_no'";
            $get_module_no_bcd = "SELECT assigned_module FROM $brandix_bts.bundle_creation_data WHERE input_job_no_random_ref = '$job_no'";
        }

        $module_rsult = $link->query($get_module_no);
        if (mysqli_num_rows($module_rsult) > 0)
        {
            while($sql_row11 = $module_rsult->fetch_assoc()) 
            {
                $module = $sql_row11['input_module'];
            }
        }
        else
        {
            $module_rsult_bcd = $link->query($get_module_no_bcd);
            while($sql_row11_bcd = $module_rsult_bcd->fetch_assoc()) 
            {
                $module = $sql_row11_bcd['assigned_module'];
            }
        }
    }

    if ($scan_type == 0)
    {
        # bundle level
        $check_if_ij_is_scanned = "SELECT sum(recevied_qty) as recevied_qty FROM $brandix_bts.bundle_creation_data WHERE bundle_number = '$job_no' AND operation_id='$opn_routing_code'";

        $get_ij_rand_no_QUERY = "SELECT input_job_no_random FROM $bai_pro3.pac_stat_log_input_job WHERE tid = '$job_no'";
        $get_ij_rand_no_RESULT = $link->query($get_ij_rand_no_QUERY);
        while ($ij = mysqli_fetch_array($get_ij_rand_no_RESULT))
        {
            $job_no = $ij['input_job_no_random'];
        }
    }
    else if ($scan_type == 1)
    {
        # sewing job level
        if ($screen == 'scan') {
            $check_if_ij_is_scanned = "SELECT sum(recevied_qty) as recevied_qty FROM $brandix_bts.bundle_creation_data WHERE input_job_no_random_ref = '$job_no' AND operation_id='$opn_routing_code'";
        } else {
            $check_if_ij_is_scanned = "SELECT sum(recevied_qty) as recevied_qty FROM $brandix_bts.bundle_creation_data WHERE input_job_no_random_ref = '$job_no' AND operation_id='$operation'";
        }               
    }

    if ($operation == $opn_routing_code && $screen == 'scan')
    {
        $check_tms_status_query = "SELECT input_trims_status FROM $bai_pro3.plan_dashboard_input WHERE input_job_no_random_ref='$job_no'";
        $tms_check_result = $link->query($check_tms_status_query);
        if (mysqli_num_rows($tms_check_result) > 0) {
            while ($tms_result = mysqli_fetch_array($tms_check_result))
            {
                $tms_status = $tms_result['input_trims_status'];
            }
        } else {
            $check_tms_status_query_backup = "SELECT input_trims_status FROM $bai_pro3.plan_dashboard_input_backup WHERE input_job_no_random_ref='$job_no'";
            $tms_check_result_backup = $link->query($check_tms_status_query_backup);
            while ($tms_result_backup = mysqli_fetch_array($tms_check_result_backup))
            {
                $tms_status = $tms_result_backup['input_trims_status'];
            }
        }
    }
    else
    {
        $tms_status = 4;
    }
        

    if ($tms_status > 1)
    {
        $check_result = $link->query($check_if_ij_is_scanned);
        while ($row = mysqli_fetch_array($check_result))
        {
            $res = $row['recevied_qty'];
        }
        if ($res > 0 && $res != null && $res != '')
        {
            if ($screen == 'scan' || $screen == 'wout_keystroke')
            {
                // Scanning screen
                $response_flag = 0;
            }
            else
            {
                // Reversal screen
                $go_here = 1;
            }
        }
        else
        {
            // Sewing Job not scanned
            $go_here = 1;
        }

        if ($go_here == 1)
        {
            if ($module != '' && $module != null && $module > 0)
            {
                $validating_qry = "SELECT DISTINCT input_job_rand_no_ref FROM $bai_pro3.`ims_log` WHERE ims_mod_no = '$module'";
                $result_validating_qry = $link->query($validating_qry);
                while($row = $result_validating_qry->fetch_assoc()) 
                {
                    $input_job_array[] = $row['input_job_rand_no_ref'];
                }

                $block_prio_qry = "SELECT block_priorities FROM $bai_pro3.`module_master` WHERE module_name='$module'";
                $result_block_prio = $link->query($block_prio_qry);
                while($sql_row = $result_block_prio->fetch_assoc())
                {
                    $block_priorities = $sql_row['block_priorities'];
                }

                if ($block_priorities == '' || $block_priorities == null || $block_priorities == 0 || $block_priorities == '0')
                {
                    $response_flag = 3;
                }
                else
                {
                    if(!in_array($job_no,$input_job_array))
                    {
                        // job not in module (adding new job to module)
                        if (sizeof($input_job_array) < $block_priorities)
                        {
                            $response_flag = 0; // allow
                        }
                        else
                        {
                            $response_flag = 2; // check for user acces (block priorities)
                        }
                    }
                    else
                    {
                        // job already in module
                        $response_flag = 0; // allow
                    }
                }
            }
            else
            {
                $response_flag = 4;
            }
        }
    }
    else
    {
        $response_flag = 5;
    }       
    // 5 = Trims not issued to Module, 4 = No module for sewing job, 3 = No valid Block Priotities, 2 = check for user access (block priorities), 0 = allow for scanning
    if ($screen == 'wout_keystroke')
 {
 return $response_flag;
 }
 else
 {
 echo $response_flag;
 }
}


?>