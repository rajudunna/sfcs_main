<head>
	<link rel="stylesheet" type="text/css" href="../../../../common/css/bootstrap.min.css">
	<title></title>
</head>
<div class="panel panel-primary">
<div class="panel-heading"><strong>Issued to Module Summary Report</strong></div>
<?php
        include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config.php');  
        include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/functions.php');
        $username_list=explode('\\',$_SERVER['REMOTE_USER']);
        $username=strtolower($username_list[1]);
        $module=$_GET['module'];
        $table_name="$temp_pool_db.plan_dash_doc_summ_input_$username";
        
      
            $sql2x="SELECT sum(carton_act_qty) as carton_act_qty,order_del_no,order_style_no,input_job_no,log_time,input_trims_status,input_module,input_job_no_random_ref FROM $table_name  WHERE (input_trims_status=4 and input_trims_status !='NULL') and input_module='$module' and input_job_no!='NULL' group by input_job_no_random_ref";

        
        $result2x=mysqli_query($link, $sql2x) or die("Error = ".mysqli_error($GLOBALS["___mysqli_ston"]));
        
        $rows2=mysqli_num_rows($result2x);	
        echo"<div class='panel-body'>";
        echo "<table class='table table-bordered' style='border-color: #337ab7;'>
        <tr style='background-color: #337ab7;color:white;'><th>Sequence Number</th><th>Style</th><th>Schedule</th><th>Sewing Job Number</th><th>Sewing Job Qty</th><th>Issued Date and Time</th></tr>";
        $srno=$start+1;
        while($row21x=mysqli_fetch_array($result2x))
        {


            $log_time=$row21x["log_time"];
            $input_job_no=$row21x["input_job_no"];
            $order_style_no=$row21x["order_style_no"];
            $order_del_no=$row21x["order_del_no"];
            $carton_act_qty=$row21x["carton_act_qty"];
            $input_job_no_random_ref=$row21x["input_job_no_random_ref"];

            $get_color = echo_title("$bai_pro3.packing_summary_input","order_col_des","order_del_no='$order_del_no' and input_job_no",$input_job_no,$link);
            $display_prefix1 = get_sewing_job_prefix("prefix","$brandix_bts.tbl_sewing_job_prefix","$bai_pro3.packing_summary_input",$order_del_no,$get_color,$input_job_no,$link);
 
            echo "<td>".$srno++."</td>";
            echo "<td>".$order_style_no."</td>";
            echo "<td>".$order_del_no."</td>";
            echo "<td>$display_prefix1"."(".$input_job_no_random_ref.")"."</td>";
            echo "<td>".$carton_act_qty."</td>";
            echo "<td>".$log_time."</td>";
        
		
		 echo "</tr>";
       
       }

 echo"</table>";
 echo"</div>";
?>



</div>
</div>




