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



function get_details($module){
	    $counter = 0;
	    include($_SERVER['DOCUMENT_ROOT']."/sfcs_app/common/config/config_ajax.php");

    $html_out = "<div class='panel panel-primary'>";
     $html_out.= "<div class='panel-heading'><h3>Module -$module</h3></div>";
       $html_out.= "<div class='panel-body'>";
         $html_out.= "<table class='table table-bordered'>
                 <thead>
                     <tr>
                         <td>Control</td>
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

        $bcd_query="select sum(recevied_qty) as rec,style,schedule,color From $brandix_bts.bundle_creation_data where input_job_no_random_ref = '$input_job' and operation_id = $operation_code group by input_job_no_random_ref";
        //echo $bcd_query;
        $bcd_result=mysqli_query($link, $bcd_query)or exit("recevied qty error".mysqli_error($GLOBALS["___mysqli_ston"]));
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
				<td>$input_job</td>
				<td>".$sql_row2['style']."</td>
				<td>".$sql_row2['schedule']."</td>";
				$html_out.= "</tr>";
            }
             
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