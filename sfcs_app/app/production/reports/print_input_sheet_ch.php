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
    $username='Mounika';
    include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
    include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/functions.php',3,'R'));
    include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/enums.php',3,'R'));
    include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/functions_dashboard.php',3,'R'));
    $sub_po=$_POST["sub_po"];
    $plantcode=$_POST["plantcode"];
    // echo $sub_po;
    // echo $plantcode;

    //Qry to fetch jm_job_header_id from jm_jobs_header
    $get_jm_job_header_id="SELECT jm_job_header_id FROM $pps.jm_job_header WHERE po_number='$sub_po' AND plant_code='$plantcode'";
    $jm_job_header_id_result=mysqli_query($link_new, $get_jm_job_header_id) or exit("Sql Error at get_jm_job_header_id".mysqli_error($GLOBALS["___mysqli_ston"]));
    $jm_job_header_id_result_num=mysqli_num_rows($jm_job_header_id_result);
    if($jm_job_header_id_result_num>0){
        while($jm_job_header_id_row=mysqli_fetch_array($jm_job_header_id_result))
        {
            $jm_job_header_id[]=$jm_job_header_id_row['jm_job_header_id'];
        }
    }
    
    $get_job_details = "SELECT jg.job_group,jg.jm_jg_header_id,jg.job_number as job_number,bun.fg_color as color,sum(bun.quantity) as qty ,bun.size as size FROM $pps.jm_jg_header jg LEFT JOIN $pps.jm_job_bundles bun ON bun.jm_jg_header_id = jg.jm_jg_header_id WHERE jg.plant_code = '$plantcode' AND jg.jm_job_header IN ('".implode("','" , $jm_job_header_id)."') AND jg.is_active=1 GROUP BY bun.size";
    // echo $get_job_details;
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
    // var_dump($job_ids);

    if(sizeof($job_ids) > 0){
        echo "<table class='table table-bordered'>";

        $job_ids_list = implode("','", array_unique($job_ids));
        $size_list = "SELECT distinct(size) FROM $pps.jm_job_bundles where jm_jg_header_id IN ('$job_ids_list') and plant_code='$plantcode' and is_active=1";
        $size_list_result = mysqli_query($link_new, $size_list) or exit("attributes data not found for job " . mysqli_error($GLOBALS["___mysqli_ston"]));
        while ($row = mysqli_fetch_array($size_list_result)) {
            $sizes[] = $row['size'];
        }
        foreach($job_ids as $key => $job_id){
            if($key == 0){
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
                    echo "<th>".$size."</th>";
                }
                echo "<th>Total</th>";
                echo "<th>Input/Output details</th>";
                echo "</tr>";

            }
            $get_task_job = "SELECT task_jobs_id,task_header_id FROM $tms.task_jobs where task_job_reference='$job_id' and plant_code='$plantcode' and is_active=1";
            $get_task_job_result = mysqli_query($link_new, $get_task_job) or exit("attributes data not found for job " . mysqli_error($GLOBALS["___mysqli_ston"]));
            while ($row1 = mysqli_fetch_array($get_task_job_result)) {
                $task_job_id = $row1['task_jobs_id'];
                $task_header_id = $row1['task_header_id'];

                //get resource id 
                $get_task_header = "SELECT resource_id,planned_date_time FROM $tms.task_header where task_header_id='$task_header_id' and plant_code='$plantcode' and is_active=1";
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
                $sql_tms = "SELECT operation_code FROM $tms.`task_job_transaction` WHERE task_jobs_id = '$task_job_id'  ORDER BY operation_seq  DESC LIMIT 0,1";
                echo $sql_tms;
                mysqli_query($link_new,$sql_tms) or exit("Sql Error7".mysqli_error());
                $sql_result_tms=mysqli_query($link_new,$sql_tms) or exit("Sql Error5".mysqli_error());
                while($sql_row_tms = mysqli_fetch_array($sql_result_tms))
                {
                    $out_put_ops = $sql_row_tms['operation_code'];
                }
                $sql_tms_in = "SELECT operation_code FROM $tms.`task_job_transaction` WHERE task_jobs_id = '$task_job_id' ORDER BY operation_seq  ASC LIMIT 0,1";
                mysqli_query($link_new,$sql_tms_in) or exit("Sql Error7".mysqli_error());
                $sql_result_tms_in=mysqli_query($link_new,$sql_tms_in) or exit("Sql Error5".mysqli_error());
                while($sql_row_tms_in = mysqli_fetch_array($sql_result_tms_in))
                {
                    $input_ops = $sql_row_tms_in['operation_code'];
                }


                $job_detail_attributes = [];
                $qry_toget_style_sch = "SELECT * FROM $tms.task_attributes where task_jobs_id='$task_job_id' and plant_code='$plantcode' and is_active=1";
                $qry_toget_style_sch_result = mysqli_query($link_new, $qry_toget_style_sch) or exit("attributes data not found for job " . mysqli_error($GLOBALS["___mysqli_ston"]));
                while ($row2 = mysqli_fetch_array($qry_toget_style_sch_result)) {
                    $job_detail_attributes[$row2['attribute_name']] = $row2['attribute_value'];
                }
                $style[] = $job_detail_attributes[$sewing_job_attributes['style']];
                $schedule[] = $job_detail_attributes[$sewing_job_attributes['schedule']];
                $color[] = $job_detail_attributes[$sewing_job_attributes['color']];
                $cutjobno[] = $job_detail_attributes[$sewing_job_attributes['cutjobno']];
                // echo $schedule;
            }
            $styles = implode(",", array_unique($style));
            // var_dump($styles.'style');
            $schedules = implode(",", array_unique($schedule));
            $colors = implode(",", array_unique($color));
            $cutjobnos = implode(",", array_unique($cutjobno));
            $scheduless = implode("','", array_unique($schedule));
            $get_order_details = "SELECT mo_number,vpo,destination,cpo,planned_delivery_date FROM $oms.oms_mo_details where schedule in ('$scheduless') and plant_code='$plantcode' and is_active=1";
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

            echo "<tr height=20 style='height:15.0pt;>";
            echo "<td height=20 style='height:15.0pt'>".$styles."</td>";
            echo "<td height=20 style='height:15.0pt'>".$styles."</td>";
            echo "<td height=20 style='height:15.0pt'>$cpos</td>";
            echo "<td height=20 style='height:15.0pt'>$vpos</td>";
            echo "<td height=20 style='height:15.0pt'>".$schedules."</td>";
            echo "<td height=20 style='height:15.0pt'>$destinations</td>";
            echo "<td height=20 style='height:15.0pt'>$colors</td>";
            echo "<td height=20 style='height:15.0pt'>".$cutjobnos."</td>";
            echo "<td height=20 style='height:15.0pt'>".$planned_delivery_dates."</td>";
            echo "<td height=20 style='height:15.0pt'>".$job_number[$job_id]."</td>";
            $cum_qty = 0;
            foreach($sizes as $s){
                $size_qty_list = "SELECT size,sum(quantity) as qty FROM $pps.jm_job_bundles where jm_jg_header_id='$job_id' and size='$s' and plant_code='$plantcode' and is_active=1 group by size";
                $size_qty_list_result = mysqli_query($link_new, $size_qty_list) or exit("attributes data not found for job " . mysqli_error($GLOBALS["___mysqli_ston"]));
                while ($row4 = mysqli_fetch_array($size_qty_list_result)) {
                    $size_qty[$row4['size']] = $row4['qty'];
                }
                if($size_qty[$s] > 0) {
                    $qty = $size_qty[$s];
                } else {
                    $qty = 0;
                }
                echo "<td height=20 style='height:15.0pt'>".$qty."</td>";
                $cum_qty += $qty;
            }
            echo "<td height=20 style='height:15.0pt'>".$cum_qty."</td>";
            echo "<td>";
            echo "<div class='table-responsive'>";
            echo "<table class=\"table table-bordered\">
            <tr><th  rowspan=2>Input Date</th><th  rowspan=2>Module#</th>
            <th rowspan=2>Color</th><th rowspan=2>Size</th>
            <th rowspan=2>Input Qty</th><th rowspan=2>Output Qty</th>
            <th colspan=2 style=text-align:center>Rejected Qty</th></tr>";
            echo "<tr>";
            echo "<th>Sew In</th>";
            echo "<th>Sew Out</th>";
            echo "</td>";
            echo "</tr>";
            echo "<tr>";
            foreach($sizes as $siz){
                echo "<td>".$planned_date."</td>";
                echo "<td>".$workstation_code."</td>";
                echo "<td>".$colors."</td>";
                
                $sql_tms_in = "SELECT operation_code FROM $tms.`task_job_transaction` WHERE task_jobs_id = '$task_job_id' ORDER BY operation_seq  ASC LIMIT 0,1";
                mysqli_query($link_new,$sql_tms_in) or exit("Sql Error7".mysqli_error());
                $sql_result_tms_in=mysqli_query($link_new,$sql_tms_in) or exit("Sql Error5".mysqli_error());
                while($sql_row_tms_in = mysqli_fetch_array($sql_result_tms_in))
                {
                    $input_ops = $sql_row_tms_in['operation_code'];
                }

                echo "<td>".$siz."</td>";
                echo "<td>".$input_ops."</td>";
                echo "<td>".$out_put_ops."</td>";
            }
            echo "</tr>";
        }
        echo "</table>";
    }
    
    

   



?>