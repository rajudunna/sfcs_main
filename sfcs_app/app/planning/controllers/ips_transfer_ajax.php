
<?php
include($_SERVER['DOCUMENT_ROOT']."/sfcs_app/common/config/config_ajax.php");
error_reporting(0);

if(isset($_GET['get_data'])){
    $module = $_GET['module'];
    get_details($module);
    exit();
}else if(isset($_GET['save_data'])){
    $module = $_GET['to_module'];
    $module1 = $_GET['module'];
    $data = $_POST;
    $res = save_details($data,$module,$module1);
    $json['saved'] = $res;
    echo json_encode($json);
    exit();
}

function leading_zeros($value, $places)
{
    $leading='';
    
    if(is_numeric($value))
    {
        for($x = 1; $x <= $places; $x++)
        {
            $ceiling = pow(10, $x);
            if($value < $ceiling)
            {
                $zeros = $places - $x;
                for($y = 1; $y <= $zeros; $y++)
                {
                    $leading .= "0";
                }
            $x = $places + 1;
            }
        }
        $output = $leading . $value;
    }
    else{
        $output = $value;
    }
    
    return $output;
}


function get_details($module){
        $counter = 0;
        include($_SERVER['DOCUMENT_ROOT']."/sfcs_app/common/config/config_ajax.php");
        

    $html_out = "<div class='panel panel-primary'>";
     $html_out.= "<div class='panel-heading'><h3>Module -$module</h3></div>";
       $html_out.= "<div class='panel-body'>";
       $html_out.= "";
         $html_out.= "<table class='table table-bordered'>
                 <thead>
                     <tr>
                         <td><input type='checkbox' class='btn btn-sm btn-warning' value='check all' onclick='toggle(this)'> Select All</td>
                         <td>Sewing Job Number</td>
                         <td>Style</td>
                         <td>Schedule</td>
                     </tr>
                 </thead>
                 <tbody>";
    $check_module="Select input_module,input_job_no_random_ref From $bai_pro3.plan_dashboard_input where input_module='$module'";
    //echo $check_module;
    $result1 = mysqli_query($link, $check_module)or exit("Module missing".mysqli_error($GLOBALS["___mysqli_ston"]));
    while($row1 = mysqli_fetch_array($result1))
    {
        $input_job=$row1['input_job_no_random_ref'];
        $module=$row1['input_module'];
        
        // echo "<b>Module:</b> $module | <b>input_job:</b> $input_job"; 
        //To get style and schedule
        $get_details="select order_style_no,order_del_no,order_col_des,type_of_sewing,input_job_no from $bai_pro3.packing_summary_input where input_job_no_random='$input_job'";
       // echo $get_details;
        $get_details_result=mysqli_query($link, $get_details)or exit("details_error".mysqli_error($GLOBALS["___mysqli_ston"]));
        while($row2=mysqli_fetch_array($get_details_result))
        {
            $style=$row2['order_style_no'];
            $schedule=$row2['order_del_no'];
            $color=$row2['order_col_des'];
            $type_name=$row2['type_of_sewing'];
            $job=$row2['input_job_no'];
        }

     


        //To get Operation from Operation Routing For IPS
        $application='IPS';
        $scanning_query=" select * from $brandix_bts.tbl_ims_ops where appilication='$application'";
        //echo $scanning_query;
        $scanning_result=mysqli_query($link, $scanning_query)or exit("scanning_error".mysqli_error($GLOBALS["___mysqli_ston"]));
        while($sql_row1=mysqli_fetch_array($scanning_result))
        {
            $operation_name=$sql_row1['operation_name'];
            $operation_code=$sql_row1['operation_code'];
        }


        // To get Prefix
        $get_prefix="select * from  brandix_bts.tbl_sewing_job_prefix where type_of_sewing ='$type_name'";
        //echo $get_prefix;
        $get_result=mysqli_query($link, $get_prefix)or exit("prefix error".mysqli_error($GLOBALS["___mysqli_ston"]));
        while($row3=mysqli_fetch_array($get_result))
        {
          $prefix=$row3['prefix'];
        }

        
        $display=$prefix.''.leading_zeros($job,3);
        

        $bcd_query="select sum(recevied_qty) as rec From $brandix_bts.bundle_creation_data where input_job_no_random_ref = '$input_job' and operation_id = $operation_code group by input_job_no_random_ref";
        //echo $bcd_query;
        $bcd_result=mysqli_query($link, $bcd_query)or exit("recevied qty error".mysqli_error($GLOBALS["___mysqli_ston"]));

        // $display = get_sewing_job_prefix("prefix","$brandix_bts.tbl_sewing_job_prefix","$bai_pro3.packing_summary_input",$schedule,$color_name,$input_job,$link);

        $sql_num_check=mysqli_num_rows($bcd_result);
        if($sql_num_check >0)
        {
            while($sql_row2=mysqli_fetch_array($bcd_result))
            {
                $rec_qty=$sql_row2['rec'];
                // $code.=$input_job."-".$sql_row2['style']."-".$sql_row2['schedule']."-".$sql_row2['color'];
                if ($rec_qty == 0)
                {
                    $counter++;
                    $html_out.= "<tr>";
                    $html_out.= "<td>
                    <input type='hidden' value='$input_job' id='job_$counter'>
                    <input type='checkbox' class='custom-control-input boxes' id='$counter' onchange='checkedMe(this)'></td>
                    <td>$display</td>
                    <td>$style</td>
                    <td>$schedule</td>";
                    $html_out.= "</tr>";
                }
                 
            }
        }else
        {
                    $counter++;
                    $html_out.= "<tr>";
                    $html_out.= "<td>
                    <input type='hidden' value='$input_job' id='job_$counter'>
                    <input type='checkbox' class='custom-control-input boxes' id='$counter' onchange='checkedMe(this)'></td>
                    <td>$display</td>
                    <td>$style</td>
                    <td>$schedule</td>";
                    $html_out.= "</tr>";
        }
       
    }   
    if($counter == 0){
        $json['records'] = 0;
        echo json_encode($json);    
        exit();        
    }  

    $html_out.= "</tbody></table></div>";
    $json['table'] =$html_out;
    echo json_encode($json);    
    exit();                      
}

function save_details($data,$module,$module1){
    include($_SERVER['DOCUMENT_ROOT']."/sfcs_app/common/config/config_ajax.php");
    $counter = 0;
    foreach($data['jobs'] as $job){

        $plan_query="UPDATE $bai_pro3.plan_dashboard_input SET input_module = '$module' where input_job_no_random_ref = '$job'";
        mysqli_query($link, $plan_query)or exit("plan_update qty error".mysqli_error($GLOBALS["___mysqli_ston"]));


        $bcd_update_query="UPDATE $brandix_bts.bundle_creation_data SET assigned_module='$module' where input_job_no_random_ref = '$job'";
        mysqli_query($link, $bcd_update_query)or exit("update qty error".mysqli_error($GLOBALS["___mysqli_ston"]));

        $insert_qry="insert into bai_pro3.ips_job_transfer (job_no,module,transfered_module,user) values (".$job.",".$module1.",".$module.",'".$username."')";
        mysqli_query($link, $insert_qry)or exit("insert qty error".mysqli_error($GLOBALS["___mysqli_ston"]));
        $counter++;
    }
    return 1;
}

?>