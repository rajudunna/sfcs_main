<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Operation Level Status</title>

    <link rel="stylesheet" href="/sfcs_app/common/css/bootstrap.min.css"  />
    
    <script type="text/javascript" src="/sfcs_app/common/js/bootstrap1.min.js" ></script>
    <script language="javascript" type="text/javascript" src="../common/js/datetimepicker_css.js"></script> 
    <link rel="stylesheet" href="style.css" type="text/css" media="all" /> 

  
</head>
<body>
    
    <?php

    $include_path=getenv('config_job_path');
    // $include_path='C:/xampp/htdocs/sfcs_main/';
    include($include_path.'\sfcs_app\common\config\config_jobs.php');
    if($_POST){
        $date=$_POST['date'];
        $reptype=$_POST['reptype'];	
    }else {
        $date='';
        $reptype='';	
    }
    ?>

    <div class="panel panel-primary">
        <div class="panel-heading"><b>Operation Level Status MO Filling Report</b></div>
        <div class="panel-body">
            <div class="row">
                <form method="post" name="test" action="#">
                    <div class="col-md-2">
                        <label>Date:</label> 
                        <input id="date" class="form-control" onclick="javascript:NewCssCal('date','yyyymmdd','dropdown')" type="text" data-toggle='datepicker' size="8" name="date" value=<?php  if($date==""){ echo date("Y-m-d"); } else { echo $date; } ?>>
                    </div>
                    <div class="col-md-2">
                        <label>Report: </label>
                        <select name="reptype" class="form-control">
                            <option value=1 <?php if($reptype==1){ echo "selected"; } ?>>cutting</option>
                            <option value=2 <?php if($reptype==2){ echo "selected"; } ?>>sewing</option>
                            <option value=3 <?php if($reptype==3){ echo "selected"; } ?>>packing</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <input type="submit" class="btn btn-primary btn-sm" value="Show" onclick='return verify_date()' name="submit" style="margin-top:25px;">
                    </div>  
                </form>
            </div>
            <br/>
            <br/>
    <?php
    if(isset($_POST['submit']))
    {
        $post_date = $_POST['date'];
        $post_reptype = $_POST['reptype'];
        $no_data_found = false;
        if($post_reptype == 1){
            $CAT = ['cutting','Receive PF','Send PF'];
            $categories = "'" . implode ( "', '", $CAT ) . "'";
            $sewing_op_codes = "SELECT operation_code FROM $brandix_bts.tbl_orders_ops_ref WHERE category in ($categories) and display_operations='yes'";
            $result=mysqli_query($link, $sewing_op_codes) or exit("Error getting Table Details");
            while($row=mysqli_fetch_array($result))
            {
                $op_codes[] = $row['operation_code'];
            }
            $operation_codes = "'" . implode ( "', '", $op_codes ) . "'";

            $get_cutting_data="SELECT distinct(docket_number) as doc_no,size_title FROM $brandix_bts.`bundle_creation_data` WHERE date(date_time)='$post_date' and operation_id in ($operation_codes) group by docket_number,size_title";
            $cutting_result=mysqli_query($link, $get_cutting_data) or exit("Error getting Table Details");
            $cutting_result_rows_count=mysqli_num_rows($cutting_result);
            if($cutting_result_rows_count == 0){
                $no_data_found = true;
            } else {
                while($cutting_row=mysqli_fetch_array($cutting_result))
                {
                    $doc_nos[] = $cutting_row['doc_no'];
                    $doc_no = $cutting_row['doc_no'];
                    $size_title[$doc_no][] = $cutting_row['size_title'];
                    $size = $cutting_row['size_title'];
                    $status[$doc_no][$size] = 'Fill Completed';
                    $get_style_details ="SELECT order_style_no,order_del_no,order_col_des FROM $bai_pro3.`plan_doc_summ` WHERE doc_no='$doc_no' limit 1";
                    $get_style_details_result=mysqli_query($link, $get_style_details) or exit("Error getting Table Details2");
                    while($details_row=mysqli_fetch_array($get_style_details_result))
                    {
                        $style[$doc_no] = $details_row['order_style_no'];
                        $schedule[$doc_no] = $details_row['order_del_no'];
                        $color[$doc_no] = $details_row['order_col_des'];
                    }
                    // $get_operations= "select DISTINCT(operation_code) from $brandix_bts.tbl_style_ops_master where style='$style[$doc_no]' and color='$color[$doc_no]' and operation_code in ($operation_codes) order by operation_order";
                    // $result1 = $link->query($get_operations);
                    // while($row2 = $result1->fetch_assoc())
                    // {
                    //     $operation_list[] = $row2['operation_code'];
                    // }
                    foreach($op_codes as $operation){
                        $cps_query="SELECT id,cut_quantity FROM $bai_pro3.cps_log WHERE doc_no='$doc_no' and size_title='$size' and operation_code=$operation";
                        $cps_query_result=mysqli_query($link, $cps_query) or exit("Error getting Table Details4");
                        while($cps_row=mysqli_fetch_array($cps_query_result))
                        {
                            $original[$doc_no][$size] = $cps_row['cut_quantity'];
                            $ref_no= $cps_row['id'];

                            $moq_query="SELECT sum(bundle_quantity) as bundle_quantity FROM $bai_pro3.mo_operation_quantites WHERE ref_no=$ref_no  and op_code=$operation";
                            $moq_query_result=mysqli_query($link, $moq_query) or exit("Error getting Table Details5");
                            while($moq_row=mysqli_fetch_array($moq_query_result))
                            {
                                $mo_qty[$doc_no][$size][$operation] = $moq_row['bundle_quantity'];
                                if($original[$doc_no][$size] != $mo_qty[$doc_no][$size][$operation]){
                                    $status[$doc_no][$size] = 'Fill Pending';
                                }
                            }

                        }
                    }

                }
            }
            $type = 'Docket';
        }
        if($post_reptype == 2){
            $CAT = ['sewing'];
            $categories = "'" . implode ( "', '", $CAT ) . "'";
            $sewing_op_codes = "SELECT operation_code FROM $brandix_bts.tbl_orders_ops_ref WHERE category in ($categories) and display_operations='yes'";
            $result=mysqli_query($link, $sewing_op_codes) or exit("Error getting Table Details");
            while($row=mysqli_fetch_array($result))
            {
                $op_codes[] = $row['operation_code'];
            }
            $operation_codes = "'" . implode ( "', '", $op_codes ) . "'";

            $post_date = date("ymd",strtotime($post_date));
            $get_cutting_data="SELECT distinct(input_job_no_random) as input_job_no_random,size_code as size_title FROM $bai_pro3.`pac_stat_log_input_job` WHERE input_job_no_random like '%$post_date%' group by input_job_no_random,size_code";
            // echo $get_cutting_data;
            $cutting_result=mysqli_query($link, $get_cutting_data) or exit("Error getting Table Details");
            $cutting_result_rows_count=mysqli_num_rows($cutting_result);
            if($cutting_result_rows_count == 0){
                $no_data_found = true;
            } else {
                while($sewing_row=mysqli_fetch_array($cutting_result))
                {
                    $doc_nos[] = $sewing_row['input_job_no_random'];
                    $doc_no = $sewing_row['input_job_no_random'];
                    $size_title[$doc_no][] = $sewing_row['size_title'];
                    $size = $sewing_row['size_title'];
                    $status[$doc_no][$size] = 'Fill Completed';
                
                    $get_style_details ="SELECT order_style_no,order_del_no,order_col_des FROM $bai_pro3.`packing_summary_input` WHERE input_job_no_random='$doc_no' limit 1";
                    $get_style_details_result=mysqli_query($link, $get_style_details) or exit("Error getting Table Details2");
                    while($details_row=mysqli_fetch_array($get_style_details_result))
                    {
                        $style[$doc_no] = $details_row['order_style_no'];
                        $schedule[$doc_no] = $details_row['order_del_no'];
                        $color[$doc_no] = $details_row['order_col_des'];
                    }
                    $job_query="SELECT group_concat(tid) as tid,sum(carton_act_qty) as carton_act_qty FROM $bai_pro3.pac_stat_log_input_job WHERE input_job_no_random='$doc_no' and size_code='$size' group by input_job_no_random,size_code";
                    $job_query_result=mysqli_query($link, $job_query) or exit("Error getting Table Details1");
                    while($job_row=mysqli_fetch_array($job_query_result))
                    {
                        $original[$doc_no][$size] = $job_row['carton_act_qty'];
                        $ref_no = $job_row['tid'];
                        foreach($op_codes as $operation){
                            $moq_query="SELECT sum(bundle_quantity) as bundle_quantity FROM $bai_pro3.mo_operation_quantites WHERE ref_no in ($ref_no)  and op_code=$operation";
                            $moq_query_result=mysqli_query($link, $moq_query) or exit("Error getting Table Details2");
                            while($moq_row=mysqli_fetch_array($moq_query_result))
                            {
                                $mo_qty[$doc_no][$size][$operation] = $moq_row['bundle_quantity'];
                                if($original[$doc_no][$size] != $mo_qty[$doc_no][$size][$operation]){
                                    $status[$doc_no][$size] = 'Fill Pending';
                                }
                            }
                        }
                    }

                }
            }
            $type = 'Sewing Job Number';
        }

        if($post_reptype == 3){
            $CAT = ['packing'];
            $categories = "'" . implode ( "', '", $CAT ) . "'";
            $sewing_op_codes = "SELECT operation_code FROM $brandix_bts.tbl_orders_ops_ref WHERE category in ($categories) and display_operations='yes'";
            $result=mysqli_query($link, $sewing_op_codes) or exit("Error getting Table Details");
            while($row=mysqli_fetch_array($result))
            {
                $op_codes[] = $row['operation_code'];
            }
            $operation_codes = "'" . implode ( "', '", $op_codes ) . "'";

            $get_packing_data="SELECT distinct(pac_stat_id) as pac_stat_id,size_tit,style,schedule,color FROM $bai_pro3.`pac_stat_log` WHERE date(lastup)='$post_date' group by pac_stat_id,size_tit";
            $packing_result=mysqli_query($link, $get_packing_data) or exit("Error getting Table Details");
            $packing_result_rows_count=mysqli_num_rows($packing_result);
            if($packing_result_rows_count == 0){
                $no_data_found = true;
            } else {
                while($packing_row=mysqli_fetch_array($packing_result))
                {
                    $doc_nos[] = $packing_row['pac_stat_id'];
                    $doc_no = $packing_row['pac_stat_id'];
                    $size_title[$doc_no][] = $packing_row['size_tit'];
                    $size = $packing_row['size_tit'];
                    $status[$doc_no][$size] = 'Fill Completed';
                    $style[$doc_no] = $packing_row['style'];
                    $schedule[$doc_no] = $packing_row['schedule'];
                    $color[$doc_no] = $packing_row['color'];
                    
                    $job_query="SELECT group_concat(tid) as tid,sum(carton_act_qty) as carton_act_qty FROM $bai_pro3.pac_stat_log WHERE pac_stat_id='$doc_no' and size_tit='$size' group by pac_stat_id,size_tit";
                    $job_query_result=mysqli_query($link, $job_query) or exit("Error getting Table Details1");
                    while($job_row=mysqli_fetch_array($job_query_result))
                    {
                        $original[$doc_no][$size] = $job_row['carton_act_qty'];
                        $ref_no = $job_row['tid'];
                        foreach($op_codes as $operation){
                            $moq_query="SELECT sum(bundle_quantity) as bundle_quantity FROM $bai_pro3.mo_operation_quantites WHERE ref_no in ($ref_no)  and op_code=$operation";
                            $moq_query_result=mysqli_query($link, $moq_query) or exit("Error getting Table Details2");
                            while($moq_row=mysqli_fetch_array($moq_query_result))
                            {
                                $mo_qty[$doc_no][$size][$operation] = $moq_row['bundle_quantity'];
                                if($original[$doc_no][$size] != $mo_qty[$doc_no][$size][$operation]){
                                    $status[$doc_no][$size] = 'Fill Pending';
                                }
                            }
                        }
                    }

                }
            }
            $type = 'Pack Job Number';
        }
        echo '<div class="col-md-12 table-responsive" style="max-height:900px;overflow-y:scroll;">';
        echo "<table class='table table-bordered'>";
        if($no_data_found){
                    echo "<tr class='warning'><td colspan=4 style='color:#ff0000'>No Data found</td></tr>";
        }else {
            echo "<tr style='background-color:#003366;color:white'>";
            echo "<th>S.no</th>";
            echo "<th>Style</th>";
            echo "<th>Schedule</th>";
            echo "<th>Color</th>";
            echo "<th>".$type."</th>";
            echo "<th>Size</th>";
            echo "<th>Original Qty</th>";
            foreach($op_codes as $key1 => $opcode){
            echo "<th>".$opcode."</th>";
            }
            echo "<th>Status</th>";
            echo "</tr>";
            $doc_list=array_unique($doc_nos);
            $sno=1;
            foreach($doc_list as $key => $doc_no){
                foreach($size_title[$doc_no] as $key1 => $size){
                    if($status[$doc_no][$size]=='Fill Pending'){
                        $color1 = 'pink';
                    }else {
                        $color1 = '';
                    }

                    echo "<tr style='background-color:$color1'>";
                    echo "<td>".$sno++."</td>";
                    echo "<td>".$style[$doc_no]."</td>";
                    echo "<td>".$schedule[$doc_no]."</td>";
                    echo "<td>".$color[$doc_no]."</td>";
                    echo "<td>".$doc_no."</td>";
                    echo "<td>".$size."</td>";
                    echo "<td>".$original[$doc_no][$size]."</td>";
                    // var_dump($mo_qty[$doc_no][$size]);
                    foreach($op_codes as $key1 => $opcode){
                        if($mo_qty[$doc_no][$size][$opcode]){
                            echo "<td>".$mo_qty[$doc_no][$size][$opcode]."</td>";
                        }else{
                            echo "<td>--</td>";
                        }
                        }
                    echo "<td><b>".$status[$doc_no][$size]."</b></td>";
                    echo "</tr>";

                }
            }


        }
        echo "</table>";
        echo "</div>";
        
    }
    ?>
        </div>  
    </div>
</body>
</html>
