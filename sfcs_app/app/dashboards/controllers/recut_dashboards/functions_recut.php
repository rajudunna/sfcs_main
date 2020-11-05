<?php
if(isset($_GET['recut_doc_id']))
{
	$recut_doc_id = $_GET['recut_doc_id'];
	if($recut_doc_id != '')
	{
		getDocketDetails($recut_doc_id);
	}
}
function getDocketDetails($recut_doc_id)
{
    $data_array = explode(",",$recut_doc_id);
    $subpo =$data_array[0];
    $component =$data_array[1];
    $plantcode =$data_array[2];
    include("../../../../common/config/config_ajax.php");
    include("../../../../common/config/enums.php");
    include("../../../../common/config/functions_v2.php");
    $html = '';
    $get_rhids_subpo="SELECT rh_id FROM $pts.`rejection_header` WHERE plant_code='$plantcode' AND sub_po='$subpo' AND fabric_category='$component'";
    $result_get_rhids_subpo = $link->query($get_rhids_subpo);
    while($row = $result_get_rhids_subpo->fetch_assoc())
    {
      $rejection_header_ids[]=$row['rh_id'];
    }
    $get_categories="SELECT DISTINCT job_type FROM $pts.`rejection_transaction` WHERE plant_code='$plantcode' AND component='$component' AND rh_id IN ('".implode("','" , $rejection_header_ids)."')";
    $result_get_categories = $link->query($get_categories);
    while($row1 = $result_get_categories->fetch_assoc())
    {
        $job_type=$row1['job_type'];
        if($job_type == BarcodeType::PD)
        {
            $category=DepartmentTypeEnum::CUTTING;
            $table_data = "<table class = 'col-sm-12 table-bordered table-striped table-condensed cf'><thead class='cf'><tr><th>Docket Number</th><th>Size</th><th>Rejected Qty</th><th>Recut Raised Qty</th><th>Recut Reported Qty</th><th>Issued Qty</th><th>Remaining Qty</th></tr></thead><tbody>";
        } else if ($job_type == TaskTypeEnum::PLANNEDEMBELLISHMENTJOB)
        {
            $category=DepartmentTypeEnum::EMBELLISHMENT;
            $table_data = "<table class = 'col-sm-12 table-bordered table-striped table-condensed cf'><thead class='cf'><tr><th>Embllishment Job</th><th>Assigned Module</th><th>Size</th><th>Rejected Qty</th><th>Recut Reported Qty</th><th>Issued Qty</th><th>Remaining Qty</th></tr></thead><tbody>";
        } else if ($job_type == TaskTypeEnum::PLANNEDSEWINGJOB)
        {
            $category=DepartmentTypeEnum::SEWING;
            $table_data = "<table class = 'col-sm-12 table-bordered table-striped table-condensed cf'><thead class='cf'><tr><th>Sewing Job</th><th>Assigned Module</th><th>Size</th><th>Rejected Qty</th><th>Recut Reported Qty</th><th>Issued Qty</th><th>Remaining Qty</th></tr></thead><tbody>";
        }
        $html .= '<div class="panel-group">
                    <div class="panel panel-success">
                        <div class="panel-heading">'.$category.'</div>
                        <div class="panel-body">';
        
            if($job_type == BarcodeType::PD)
            {
                $get_cutting_details="SELECT job_number,SUM(rejection_quantity) AS rejection_quantity, SUM(replaced_quantity) AS replaced_quantity,size  FROM $pts.`rejection_transaction` LEFT JOIN $pts.rejection_header ON rejection_transaction.rh_id=rejection_header.rh_id WHERE plant_code='$plantcode' AND component='$component' AND job_type='$job_type' AND rh_id IN ('".implode("','" ,$rejection_header_ids)."') GROUP BY job_number,size";
                $result_get_cutting_details = $link->query($get_cutting_details);
                while($row2 = $result_get_cutting_details->fetch_assoc())
                {
                    $docket_number=$row2['job_number'];
                    $replacement_qty=$row2['replaced_quantity'];
                    //To get docket qty
					$result_doc_qty=getDocketInformation($docket_number,$plantcode);
                    $doc_qty =$result_doc_qty['docket_quantity'];
                    
                    //To get reported qty
                    $get_reported_qty="SELECT SUM(good_quantity) AS quantity WHERE $pts.transaction_log WHERE plant_code='$plantcode' AND parent_job='$docket_number' AND parent_job_type='$job_type' AND operation='15'";
                    $sql_result3 = mysqli_query($link,$get_reported_qty) or exit('Error get_reported_qty');
                    while($row3 = mysqli_fetch_array($sql_result3))
                    {
                        $reported_qty=$row3['quantity'];
                    }
                    $remainig_qty=$reported_qty - $replacement_qty;
                    $table_data .= "<tr><td>".$docket_number."</td>";
                    $table_data .= "<td>".$row2['size']."</td>";
                    $table_data .= "<td>".$row2['rejection_quantity']."</td>";
                    $table_data .= "<td>".$doc_qty."</td>";
                    $table_data .= "<td>".$reported_qty."</td>";
                    $table_data .= "<td>".$replacement_qty."</td>";
                    $table_data .= "<td>".$remainig_qty."</td>";
                }
                $table_data .= "</tr></tbody></table>";
            } else if ($job_type == TaskTypeEnum::PLANNEDEMBELLISHMENTJOB)
            {
                $get_emb_details="SELECT job_number,SUM(rejection_quantity) AS rejection_quantity, SUM(replaced_quantity) AS replaced_quantity,size,workstation_code  FROM $pts.`rejection_transaction` LEFT JOIN $pts.rejection_header ON rejection_transaction.rh_id=rejection_header.rh_id WHERE plant_code='$plantcode' AND component='$component' AND job_type='$job_type' AND rh_id IN ('".implode("','" ,$rejection_header_ids)."') GROUP BY job_number,size";
                $result_get_emb_details = $link->query($get_emb_details);
                while($row4 = $result_get_emb_details->fetch_assoc())
                {
                    $job_number=$row4['job_number'];
                    $replacement_qty=$row4['replaced_quantity'];
                    $workstation_code=$row4['workstation_code'];
                    
                    //To get reported qty
                    $get_reported_qty="SELECT SUM(good_quantity) AS quantity WHERE $pts.transaction_log WHERE plant_code='$plantcode' AND parent_job='$job_number' AND parent_job_type='$job_type' AND operation='40' group by job_number";
                    $sql_result4 = mysqli_query($link,$get_reported_qty) or exit('Error get_reported_qty');
                    while($qty_row = mysqli_fetch_array($sql_result4))
                    {
                        $reported_qty=$qty_row['quantity'];
                    }
                    $remainig_qty=$reported_qty - $replacement_qty;
                    $table_data .= "<tr><td>".$job_number."</td>";
                    $table_data .= "<td>".$workstation_code."</td>";
                    $table_data .= "<td>".$row4['size']."</td>";
                    $table_data .= "<td>".$row4['rejection_quantity']."</td>";
                    $table_data .= "<td>".$reported_qty."</td>";
                    $table_data .= "<td>".$replacement_qty."</td>";
                    $table_data .= "<td>".$remainig_qty."</td>";
                }
                $table_data .= "</tr></tbody></table>";
            } else if ($job_type == TaskTypeEnum::PLANNEDSEWINGJOB)
            {
                $get_sewing_details="SELECT job_number,SUM(rejection_quantity) AS rejection_quantity, SUM(replaced_quantity) AS replaced_quantity,size,workstation_code  FROM $pts.`rejection_transaction` LEFT JOIN $pts.rejection_header ON rejection_transaction.rh_id=rejection_header.rh_id WHERE plant_code='$plantcode' AND component='$component' AND job_type='$job_type' AND rh_id IN ('".implode("','" ,$rejection_header_ids)."') GROUP BY job_number,size";
                $result_get_sewing_details = $link->query($get_sewing_details);
                while($row5 = $result_get_sewing_details->fetch_assoc())
                {
                    $job_number=$row5['job_number'];
                    $replacement_qty=$row5['replaced_quantity'];
                    $workstation_code=$row5['workstation_code'];
                    
                    //To get reported qty
                    $get_reported_qty="SELECT SUM(good_quantity) AS quantity WHERE $pts.transaction_log WHERE plant_code='$plantcode' AND parent_job='$job_number' AND parent_job_type='$job_type' AND operation='100' group by job_number";
                    $sql_result5 = mysqli_query($link,$get_reported_qty) or exit('Error get_reported_qty');
                    while($qty_row = mysqli_fetch_array($sql_result5))
                    {
                        $reported_qty=$qty_row['quantity'];
                    }
                    $remainig_qty=$reported_qty - $replacement_qty;
                    $table_data .= "<tr><td>".$job_number."</td>";
                    $table_data .= "<td>".$workstation_code."</td>";
                    $table_data .= "<td>".$row5['size']."</td>";
                    $table_data .= "<td>".$row5['rejection_quantity']."</td>";
                    $table_data .= "<td>".$reported_qty."</td>";
                    $table_data .= "<td>".$replacement_qty."</td>";
                    $table_data .= "<td>".$remainig_qty."</td>";
                }
                $table_data .= "</tr></tbody></table>";
            } else
            {
                $table_data .="No Data Found";
            }	
        $html .= '</div></div></div>';  
        echo $html;
    }    
}

// if(isset($_GET['markers_view_docket']))
// {
// 	$markers_view_docket = $_GET['markers_view_docket'];
// 	if($markers_view_docket != '')
// 	{
// 		Markersview($markers_view_docket);
// 	}
// }
// function Markersview($markers_view_docket)
// {
//     $data_array = explode(",",$markers_view_docket);
//     $subpo =$data_array[0];
//     $component =$data_array[1];
//     $plantcode =$data_array[2];
//     $html = '';
//     $table_data = '';
//     include("../../../../common/config/config_ajax.php");
//     //get details
//     $get_details_query="SELECT ratio_id FROM $pps.`add_cut_request` LEFT JOIN $pps.`add_cut_request_detail` ON add_cut_request_detail.add_cut_request = add_cut_request.add_cut_request_id WHERE add_cut_request.plant_code='$plantcode' AND po_number='$subpo'";
//     $result_get_details = mysqli_query($link,$get_details_query) or exit('Error get_details_query');
//     while($ratio_row = mysqli_fetch_array($result_get_details))
//     {
//         $ratio_id[]=$ratio_row['ratio_id'];
//     }
//     //get style,schedule and color
//     $get_order_details="SELECT Distinct style,group_concat(schedule) as schedule,group_concat(fg_color) as color FROM $pts.rejection_header WHERE plant_code='$plantcode' AND sub_po='$subpo'";
//     $sql_result = mysqli_query($link,$get_order_details) or exit('Error get_order_details');
//     while($row = mysqli_fetch_array($sql_result))
//     {
//        $style=$row['style'];
//        $schedules=$row['schedule'];
//        $colors=$row['color'];
//     }

//     $html .= '<div class="panel-group">
//                 <div class="panel panel-success">
//                     <div class="panel-heading">Markers</div>
//                     <div class="panel-body">';
//     $html .= "<div class='row'>
//                 <div class='col-md-4'>Style:$style</div>
//                 <div class='col-md-4'>Schedule:$schedules</div>
//                 <div class='col-md-4'>Color:$colors</div>
//             </div>";
//     $html .= '</br></br>';
//     $html .= "<div class='row'>
//                 <div class='col-md-4'><b>Marker Length</b>:$mk_length</td></div>
//                 <div class='col-md-4'><b>Plies </b>:$a_plies</td></div>
//                 <div class='col-md-4'><b>Required Materials </b>:$rm</td></div>
//             </div>";
//     $html .= '</br></br>';
//     $table_data .= "<table class = 'col-sm-12 table-bordered table-striped table-condensed cf'><thead class='cf'><tr><th>Size</th><th>Quantity</th><th style='width: 29%;'>Ratio</th></tr></thead><tbody>";
//     foreach($cut_done_qty as $key=>$value)
//     {
//         $retriving_size = "SELECT size_title FROM `$bai_pro3`.`recut_v2_child` rc 
//         LEFT JOIN `$bai_pro3`.`recut_v2` r ON r.`doc_no` = rc.`parent_id`
//         LEFT JOIN `$bai_pro3`.`rejection_log_child` rejc ON rejc.`bcd_id` = rc.`bcd_id`
//         WHERE rc.parent_id = $markers_view_docket AND rejc.`size_id` = '$key'";
//         // echo $retriving_size;
//          $res_retriving_size = $link->query($retriving_size);
//          while($row_size = $res_retriving_size->fetch_assoc()) 
//          {
//             $size_title_ind = $row_size['size_title'];
//          }
//         $table_data .= "<input type='hidden' name ='size[]' value ='$key'>";
//         $quantity = $value*$a_plies;
//         $table_data .= "<tr><td>$size_title_ind</td><td>$quantity</td><td>$value</td></tr>";
//     }
//     $qry_to_get = "SELECT * FROM  `$bai_pro3`.`cat_stat_log` WHERE  order_tid = \"$order_tid\" and category = 'Body'";
//     $res_qry_to_get = $link->query($qry_to_get);
//     while($row_cat_ref = $res_qry_to_get->fetch_assoc()) 
//     {
//         $cat_ref =$row_cat_ref['tid'];

//     }
//     $table_data .= "</tbody></table>";
//     $html .= $table_data;
//     $html .= '</div></div></div>';
//     echo $html;
// }
?>