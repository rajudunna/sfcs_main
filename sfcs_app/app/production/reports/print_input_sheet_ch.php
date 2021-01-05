<script>
    function printpr()
    {
        var OLECMDID = 7;
        /* OLECMDID values:
        * 6 - print
        * 7 - print preview
        * 1 - open window
        * 4 - Save As
        */
        var PROMPT = 1; // 2 DONTPROMPTUSER
        var WebBrowser = '<OBJECT ID="WebBrowser1" WIDTH=0 HEIGHT=0 CLASSID="CLSID:8856F961-340A-11D0-A96B-00C04FD705A2"></OBJECT>';
        document.body.insertAdjacentHTML('beforeEnd', WebBrowser);
        WebBrowser1.ExecWB(OLECMDID, PROMPT);
        WebBrowser1.outerHTML = "";
    
    }
</script>
<body onload="printpr1();">
<?php
    // $username='Mounika';
    include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
    include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/functions.php',3,'R'));
    include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/enums.php',3,'R'));
    include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/sms_api_calls.php',3,'R'));
    include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/functions_dashboard.php',3,'R'));
    $sub_po=$_POST["sub_po"];
    $plantcode=$_POST["plantcode"];
   
    $qry_toget_sub_order="SELECT po_description,master_po_number FROM $pps.mp_sub_order WHERE po_number='$sub_po'";
    // echo $qry_toget_sub_order;
    $toget_sub_order_result=mysqli_query($link_new, $qry_toget_sub_order) or exit("Sql Error at mp_order".mysqli_error($GLOBALS["___mysqli_ston"]));
    $toget_podescri_num=mysqli_num_rows($toget_sub_order_result);
    if($toget_podescri_num>0){
        while($toget_sub_order_row=mysqli_fetch_array($toget_sub_order_result))
        {
            $sub_po_description=$toget_sub_order_row["po_description"];
            $master_po_number=$toget_sub_order_row["master_po_number"];
        }
    }
            

    //Qry to fetch jm_job_header_id from jm_jobs_header
    $get_jm_job_header_id="SELECT jm_job_header_id FROM $pps.jm_job_header WHERE po_number='$sub_po' AND plant_code='$plantcode' order by ref_id";
    $jm_job_header_id_result=mysqli_query($link_new, $get_jm_job_header_id) or exit("Sql Error at get_jm_job_header_id".mysqli_error($GLOBALS["___mysqli_ston"]));
    $jm_job_header_id_result_num=mysqli_num_rows($jm_job_header_id_result);
    if($jm_job_header_id_result_num>0){
        while($jm_job_header_id_row=mysqli_fetch_array($jm_job_header_id_result))
        {
            $jm_job_header_id[]=$jm_job_header_id_row['jm_job_header_id'];
        }
    }
    $job_type=TaskTypeEnum::PLANNEDSEWINGJOB;
    $get_job_details = "SELECT jg.job_group,jg.jm_jg_header_id,jg.job_number as job_number FROM $pps.jm_jg_header jg WHERE jg.plant_code = '$plantcode' AND job_group_type='$job_type' AND jg.jm_job_header IN ('".implode("','" , $jm_job_header_id)."') AND jg.is_active=1";
    $get_job_details_result=mysqli_query($link_new, $get_job_details) or exit("$get_job_details".mysqli_error($GLOBALS["___mysqli_ston"]));
    if($get_job_details_result>0){
        while($get_job_details_row=mysqli_fetch_array($get_job_details_result))
        {
            $job_ids[] = $get_job_details_row['jm_jg_header_id'];
            $job_number[$get_job_details_row['jm_jg_header_id']] = $get_job_details_row['job_number'];
            $job_group[$get_job_details_row['jm_jg_header_id']] = $get_job_details_row['job_group'];
        }
    } 
    $task_type=TaskAttributeNamesEnum::SEWINGJOBNO;
    $revert_url = getFullURL($_GET['r'],'job_summary_view.php','N');
    echo "<button class='btn btn-sm btn-primary pull-right' onclick='location.href=\"$revert_url\"' ><< Click here to go Back</button>";
     //to get style,schedule,color ganust subpo
     $get_styledetails="SELECT style,schedule,color FROM $pts.transaction_log WHERE plant_code='$plantcode' AND sub_po='$sub_po' LIMIT 1";
     $get_styledetails_result=mysqli_query($link_new, $get_styledetails) or exit("Sql Error at get_styledetails".mysqli_error($GLOBALS["___mysqli_ston"]));
     while($row_details=mysqli_fetch_array($get_styledetails_result))
     {
       $style=$row_details['style'];
       $color=$row_details['color'];
       $schedule=$row_details['schedule'];
     }
     $get_operations_version_id="SELECT operations_version_id FROM $pps.mp_color_detail WHERE style='$style' AND color='$color' AND master_po_number='$master_po_number' AND plant_code='$plantcode' AND is_active=1";
     $version_id_result=mysqli_query($link_new, $get_operations_version_id) or exit("Sql Error at get_operations_version_id".mysqli_error($GLOBALS["___mysqli_ston"]));
     while($row14=mysqli_fetch_array($version_id_result))
     {
         $operations_version_id = $row14['operations_version_id'];
     }
     //Function to get operations for style,color
     $result_mrn_operation=getJobOpertions($style,$color,$plantcode,$operations_version_id);
     $operations=$result_mrn_operation;
     $category=DepartmentTypeEnum::SEWING;
     foreach($operations as $key =>$ops){
         if($ops['operationCategory'] == $category)
         {
             $operation_code[]= $ops['operationCode'];
             $ops_get_code[$ops['operationCode']] = $ops['operationName'];
         }
         
     }
    if(sizeof($job_ids) > 0){
        
        $job_ids_list = implode("','", array_unique($job_ids));
        $size_list = "SELECT distinct(size) FROM $pps.jm_job_bundles where jm_jg_header_id IN ('$job_ids_list') and plant_code='$plantcode' and is_active=1";
        $size_list_result = mysqli_query($link_new, $size_list) or exit("attributes data not found for job " . mysqli_error($GLOBALS["___mysqli_ston"]));
        while ($row = mysqli_fetch_array($size_list_result)) {
            $sizes[] = $row['size'];
        }
        $final_total = 0;
        foreach($job_ids as $key => $job_id){
            
            $get_task_job = "SELECT task_jobs_id,task_header_id FROM $tms.task_jobs where task_job_reference='$job_id' and plant_code='$plantcode' and is_active=1 order by task_jobs_id";
            $get_task_job_result = mysqli_query($link_new, $get_task_job) or exit("attributes data not found for job " . mysqli_error($GLOBALS["___mysqli_ston"]));
            while ($row1 = mysqli_fetch_array($get_task_job_result)) {
                $task_job_id = $row1['task_jobs_id'];
                $task_header_id = $row1['task_header_id'];
                //get resource id 
                $get_task_header = "SELECT resource_id,planned_date_time FROM $tms.task_header where task_header_id='$task_header_id' and plant_code='$plantcode' and is_active=1";
                // echo $get_task_header;
                $get_task_header_result = mysqli_query($link_new, $get_task_header) or exit("attributes data not found for job " . mysqli_error($GLOBALS["___mysqli_ston"]));
                while ($row6 = mysqli_fetch_array($get_task_header_result)) {
                    $resource_id = $row6['resource_id'];
                    $planned_date = $row6['planned_date_time'];
                }
                //get workstation 
                $get_task_header = "SELECT workstation_code FROM $pms.workstation where workstation_id='$resource_id' and plant_code='$plantcode' and is_active=1";
                $get_task_header_result = mysqli_query($link_new, $get_task_header) or exit("attributes data not found for job " . mysqli_error($GLOBALS["___mysqli_ston"]));
                while ($row6 = mysqli_fetch_array($get_task_header_result)) {
                    $workstation_code = $row6['workstation_code'];
                }
                //get task jobs 
                $sql_tms = "SELECT operation_code FROM $tms.`task_job_status` WHERE task_jobs_id = '$task_job_id' and plant_code='$plantcode'   ORDER BY operation_seq  DESC LIMIT 0,1";
                // echo $sql_tms;
                mysqli_query($link_new,$sql_tms) or exit("Sql Error78".mysqli_error());
                $sql_result_tms=mysqli_query($link_new,$sql_tms) or exit("Sql Error5".mysqli_error());
                while($sql_row_tms = mysqli_fetch_array($sql_result_tms))
                {
                    $out_put_ops = $sql_row_tms['operation_code'];
                }
                $sql_tms_in = "SELECT operation_code FROM $tms.`task_job_status` WHERE task_jobs_id = '$task_job_id' and plant_code='$plantcode' ORDER BY operation_seq  ASC LIMIT 0,1";
                // echo $sql_tms_in;
                mysqli_query($link_new,$sql_tms_in) or exit("Sql Error79".mysqli_error());
                $sql_result_tms_in=mysqli_query($link_new,$sql_tms_in) or exit("Sql Error5".mysqli_error());
                while($sql_row_tms_in = mysqli_fetch_array($sql_result_tms_in))
                {
                    $input_ops = $sql_row_tms_in['operation_code'];
                }
                $job_detail_attributes = [];
                $qry_toget_style_sch = "SELECT attribute_name,attribute_value FROM $tms.task_attributes where task_jobs_id='$task_job_id' and plant_code='$plantcode' and is_active=1";
                $qry_toget_style_sch_result = mysqli_query($link_new, $qry_toget_style_sch) or exit("attributes data not found for job " . mysqli_error($GLOBALS["___mysqli_ston"]));
                while ($row2 = mysqli_fetch_array($qry_toget_style_sch_result)) {
                    $job_detail_attributes[$row2['attribute_name']] = $row2['attribute_value'];
                }
                // $style[] = $job_detail_attributes[$sewing_job_attributes['style']];
                // $schedule[] = $job_detail_attributes[$sewing_job_attributes['schedule']];
                // $color[] = $job_detail_attributes[$sewing_job_attributes['color']];
                $cutjobno[] = $job_detail_attributes[$sewing_job_attributes['cutjobno']];
                // echo $schedule;
            }
            // $styles = implode(",", array_unique($style));
            // // var_dump($styles.'style');
            // $schedules = implode(",", array_unique($schedule));
            // $colors = implode(",", array_unique($color));
            $cutjobnos = implode(",", array_unique($cutjobno));
            // $scheduless = implode("','", array_unique($schedule));
            $get_order_details = "SELECT mo_number,vpo,destination,cpo,planned_delivery_date FROM $oms.oms_mo_details where schedule='$schedule' and plant_code='$plantcode' and is_active=1";
            // echo $get_order_details;
            $get_order_details_result = mysqli_query($link_new, $get_order_details) or exit("attributes data not found for job " . mysqli_error($GLOBALS["___mysqli_ston"]));
            while ($row3 = mysqli_fetch_array($get_order_details_result)) {
                // $mo_number[] = $row3['mo_number'];
                $vpo[] = $row3['vpo'];
                $destination[] = $row3['destination'];
                $cpo[] = $row3['cpo'];
                $date1 = $row3['planned_delivery_date'];
                $year = substr($date1,0,4);
                $month = substr($date1,4,2);
                $day = substr($date1,6,7);
                $date2 = $year.'-'.$month.'-'.$day;
                $planned_delivery_date[] = $date2;
            }
            $vpos = implode(",", array_unique($vpo));
            $destinations = implode(",", array_unique($destination));
            $cpos = implode(",", array_unique($cpo));
            $planned_delivery_dates = implode(",", array_unique($planned_delivery_date));
            if($key == 0){
                echo "<div style='float:left'><table class='table table-bordered' style='font-size:11px;font-family:verdana;text-align:left;'>";
                echo "<tr>";
                echo "<td>Sub PO Description :</td>";
                echo "<td>$sub_po_description</td>";
                echo "</tr>";
                echo "<tr>";
                echo "<td>Style :</td>";
                echo "<td>$style</td>";
                echo "</tr>";
                echo "<tr>";
                echo "<td>Schedule :</td>";
                echo "<td>$schedule</td>";
                echo "</tr>";
                echo "<tr>";
                echo "<td>Color :</td>";
                echo "<td>$color</td>";
                echo "</tr>";
                echo "</table></div>";
                echo "<div class='col-md-12 table-responsive' style='max-height:600px;overflow-y:scroll;'><table class='table table-bordered'>";
                echo "<tr style='background-color:#286090;color:white;'>";
                echo "<th>Style</th>";
                echo "<th>PO#</th>";
                echo "<th>VPO#</th>";
                echo "<th>Schedule</th>";
                echo "<th>Destination</th>";
                echo "<th>Color</th>";
                echo "<th>Cut Job#</th>";
                echo "<th>Delivery Date</th>";
                echo "<th>Input Job#</th>";
                foreach($sizes as $size){
                    $size_total[$size] = 0;
                    echo "<th>".$size."</th>";
                }
                echo "<th>Total</th>";
                echo "<th>Input/Output details</th>";
                echo "</tr>";
            }
            echo "<tr height=20 style='height:15.0pt;>";
            echo "<td height=20 style='height:15.0pt'></td>";
            echo "<td height=20 style='height:15.0pt'>$style</td>";
            echo "<td height=20 style='height:15.0pt'>$cpos</td>";
            echo "<td height=20 style='height:15.0pt'>$vpos</td>";
            echo "<td height=20 style='height:15.0pt'>".$schedule."</td>";
            echo "<td height=20 style='height:15.0pt'>$destinations</td>";
            echo "<td height=20 style='height:15.0pt'>$color</td>";
            echo "<td height=20 style='height:15.0pt'>".$cutjobnos."</td>";
            echo "<td height=20 style='height:15.0pt'>".$planned_delivery_dates."</td>";
            echo "<td height=20 style='height:15.0pt'>".$job_number[$job_id]."</td>";
            $cum_qty = 0;
            foreach($sizes as $s){
                $size_qty_list = "SELECT size,sum(quantity) as qty FROM $pps.jm_job_bundles where jm_jg_header_id='$job_id' and size='$s' and plant_code='$plantcode' and is_active=1 group by size";
                $size_qty_list_result = mysqli_query($link_new, $size_qty_list) or exit("attributes data not found for job " . mysqli_error($GLOBALS["___mysqli_ston"]));
                $size_qty_list_result_num=mysqli_num_rows($size_qty_list_result);

                if($size_qty_list_result_num > 0){
                    while($row4 = mysqli_fetch_array($size_qty_list_result)) {
                        $size_qty[$row4['size']] = $row4['qty'];
                    }
                    $qty = $size_qty[$s];
                } else {
                    $qty = 0;
                }
                $size_total[$s] += $qty;
                echo "<td height=20 style='height:15.0pt'>".$qty."</td>";
                $cum_qty += $qty;
            }
           
            echo "<td height=20 style='height:15.0pt'>".$cum_qty."</td>";
            $final_total += $cum_qty;
            $col_span = count($ops_get_code);
            echo "<td>";
            echo "<div class='table-responsive'>";
            echo "<table class=\"table table-bordered\">
            <tr><th rowspan=2>Input Date</th><th rowspan=2>Module#</th>
            <th rowspan=2>Color</th><th rowspan=2>Size</th>
            <th rowspan=2>Input Qty</th><th rowspan=2>Output Qty</th>
            <th colspan=$col_span style=text-align:center>Rejected Qty</th></tr>";
            echo "<tr>";
            foreach ($operation_code as $op_code) 
            {
                echo "<th>$ops_get_code[$op_code]</th>";
            }
            echo "</tr>";
            
            $tot_input=0;
            $tot_outout=0;
            $tot=0;
            foreach($sizes as $siz){
                echo "<tr>";
                echo "<td>".$planned_date."</td>";
                echo "<td>".$workstation_code."</td>";
                echo "<td>".$color."</td>";
                $input_qty = 0;
                $output_qty = 0;
                $get_io_qty = "SELECT SUM(IF(operation = $input_ops,good_quantity,0)) AS input,
                SUM(IF(operation = $out_put_ops,good_quantity,0)) AS output FROM $pts.`transaction_log` WHERE style='$style' AND schedule='$schedule' AND color='$color' AND size = '$siz' AND parent_job ='$job_number[$job_id]' and plant_code='$plantcode' AND is_active=1 GROUP BY size";
                mysqli_query($link_new,$get_io_qty) or exit("Sql Error70".mysqli_error());
                $get_io_qty_result=mysqli_query($link_new,$get_io_qty) or exit("Sql Error5".mysqli_error());
                while($row7 = mysqli_fetch_array($get_io_qty_result))
                {
                    $input_qty = $row7['input'];
                    $output_qty = $row7['output'];
                }
                
                
                echo "<td>".$siz."</td>";
                echo "<td>".$input_qty."</td>";
                echo "<td>".$output_qty."</td>";
                if(count($operation_code) > 0) {
                    foreach ($operation_code as $op_code) 
                    {
                        $get_details="SELECT sum(if(operation=".$op_code.",rejected_quantity,0)) as rejected_qty FROM $pts.transaction_log WHERE style='$style' AND schedule='$schedule' AND color='$color' AND size = '$siz' AND parent_job ='$job_number[$job_id]' and plant_code='$plantcode' AND is_active=1 GROUP BY size";
                        $result5 = $link->query($get_details);
                        $result5_num=mysqli_num_rows($result5);
                        if($result5_num > 0)
                        {
                            while($row5 = $result5->fetch_assoc())
                            {
                                echo "<td>".$row5['rejected_qty']."</td>";
                                $tot += $row5['rejected_qty'];
                            }
                        }
                    }
                } else {
                    echo "<td>0</td>";
                }
                
                echo "</tr>";
                $tot_input += $input_qty;
                $tot_outout += $output_qty;
            }
            echo "<tr><td colspan=4 style=\"background-color:#ff8396;\"> </td><td style=\"background-color:#ff8396;color:white\">$tot_input</td><td style=\"background-color:#ff8396;color:white\">$tot_outout</td><td colspan=$col_span style=\"background-color:#ff8396;color:white\">$tot</td></tr>";

            echo "</tbody>";
            echo "</table>";
            echo "</div>";
            echo "</td>";
            echo "</tr>";
            echo "<tr>";
            echo "<th colspan=9  style=\"border-top:1px solid #000;border-bottom:1px dotted #000;font-size:14px;\"> Cut</th>";
            foreach($sizes as $s)
            {
                echo "<th style=\"border-top:1px solid #000;border-bottom:1px dotted #000;font-size:14px;\">".$size_total[$s]."</th>";
            }
            echo "<th  style=\"border-top:1px solid #000;border-bottom:1px dotted #000;\">$final_total</th>";
            echo "<th>";
            unset($cutjobno);
        }
        //To get Total order qty
        $total_order_qty=0;
        // $order_qty_qry = "SELECT sum(mo_quantity) as quantity FROM $oms.oms_products_info AS opi LEFT JOIN oms.oms_mo_details AS omd ON omd.mo_number=opi.mo_number where schedule ='$schedule' AND color_desc ='$color' AND plant_code='$plant_code'";
        // $sql_result3=mysqli_query($link, $order_qty_qry) or die("Error".$order_qty_qry.mysqli_error($GLOBALS["___mysqli_ston"]));
        // while($row3=mysqli_fetch_array($sql_result3))
        // {
        //     $total_order_qty=$row3['quantity'];
        // }
        $get_supo_qty="SELECT mp_mo_qty_id FROM $pps.`mp_sub_mo_qty` WHERE plant_code='$plantcode' AND po_number='$sub_po'";
        $sql_result_moqtyid=mysqli_query($link, $get_supo_qty) or die("Error".$get_supo_qty.mysqli_error($GLOBALS["___mysqli_ston"]));
        while($mpmoqty_row=mysqli_fetch_array($sql_result_moqtyid))
        {
            $mp_mo_qty_id[]=$mpmoqty_row['mp_mo_qty_id'];
        }
        $get_order_qty="SELECT SUM(quantity) AS quantity FROM $pps.`mp_mo_qty` WHERE SCHEDULE='$schedule' AND color='$color' AND plant_code='$plantcode' AND mp_mo_qty_id  IN ('".implode("','" , $mp_mo_qty_id)."')";
        $sql_result3=mysqli_query($link, $get_order_qty) or die("Error".$get_order_qty.mysqli_error($GLOBALS["___mysqli_ston"]));
        while($row3=mysqli_fetch_array($sql_result3))
        {
            $total_order_qty=$row3['quantity'];
        }
        //To get cutting operation
        $category=OperationCategory::CUTTING;
        $Qry_get_cut_ops="SELECT operation_code FROM $pms.`operation_mapping` WHERE operation_name='$category' AND plant_code='$plantcode' AND is_active=1";
        $result4 = $link->query($Qry_get_cut_ops);
        while($row4 = $result4->fetch_assoc())
        {
            $cut_operation=$row4['operation_code'];
        }
        $cut_recevied_quantity = 0;
        //Get mos for style,schedule and color
        $get_mos="SELECT DISTINCT(mo_number) AS mo_number FROM $pts.finished_good where style='$style' and schedule='$schedule' and color ='$color' AND plant_code='$plant_code'";
        $sql_mos_result = mysqli_query($link,$get_mos);
        while($row_mos = mysqli_fetch_array($sql_mos_result))
        {
          $monumbers[]=$row_mos['mo_number'];
        }

        $cut_report_details="SELECT sum(if(operation=".$cut_operation.",quantity,0)) AS good_quantity FROM $pts.`fg_m3_transaction` LEFT JOIN $pts.finished_good fg ON fg_m3_transaction.fg_id = fg.finished_good_id WHERE fg_m3_transaction.mo_number IN ('".implode("','" , $monumbers)."') GROUP BY size";
        $result6 = $link->query($cut_report_details);
        $result6_num=mysqli_num_rows($result6);
        if($result6_num > 0)
        {
            while($row6 = $result6->fetch_assoc())
            {
                $cut_recevied_quantity = $row6['good_quantity'];
            }
        }

        $tot_in = 0;
        $tot_in_details="SELECT sum(if(operation=".$input_ops.",good_quantity,0)) as good_quantity FROM $pts.transaction_log WHERE style='$style' AND schedule='$schedule' AND color='$color' and operation=$input_ops and plant_code='$plantcode' AND is_active=1 GROUP BY size";
        $result7 = $link->query($tot_in_details);
        $result7_num=mysqli_num_rows($result7);
        if($result7_num > 0){
            while($row7 = $result7->fetch_assoc())
            {
                $tot_in = $row7['good_quantity'];
            }
        }

        $tot_out = 0;
        $tot_out_details="SELECT sum(if(operation=".$out_put_ops.",good_quantity,0)) as good_quantity FROM $pts.transaction_log WHERE style='$style' AND schedule='$schedule' AND color='$color' and operation=$out_put_ops and plant_code='$plantcode' AND is_active=1 GROUP BY size";
        $result8 = $link->query($tot_out_details);
        $result8_num=mysqli_num_rows($result8);
        if($result8_num > 0){
            while($row8 = $result8->fetch_assoc())
            {
                $tot_out += $row8['good_quantity'];
            }
        }
        
        $balance = $cut_recevied_quantity - $tot_in;
        $tot_balance = $tot_in - $tot_out;
        echo "<table class='table table-bordered'><tr style='background-color:#286090;color:white;'><th>Order Quantity</th><th>Cut Reported Quantity</th><th>Total Sewing IN</th><th>Total Sewing OUT</th><th>Balance to Sewing In</th><th>Balance to Sewing Out</th></tr>";
        echo "<tr><th>$total_order_qty</th><th>$cut_recevied_quantity</th><th>$tot_in</th><th>$tot_out</th><th>$balance</th><th>$tot_balance</th></tr>";
        echo "</table>";
        echo "</th>";
        echo "</tr>";
        echo "</table></div>";
    } else{
        echo "<h3 style='color:red'>No Sewing Jobs Found!<h3>";
    }
?>