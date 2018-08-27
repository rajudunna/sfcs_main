
<table class="table table-bordered" id='table_ajax_3'>
    <thead>
        <tr>
            <th>S.no</th>
            <th>Job</th>
            <th>Color</th>
            <th>Size</th>
            <th>Qty</th>
            <th style='width:50% !important'>Actions</th>
        </tr>
    </thead>

    <tbody>
        <?php
            error_reporting(0);
            $style = $_GET['style'];
            $schedule = $_GET['schedule'];
            $limit = 100;
            // $style = 'A43CKA1        ';
            // $schedule = '426627';
            $color = '';

            include($_SERVER['DOCUMENT_ROOT'].'/template/dbconf.php');

            $color_query="SELECT order_col_des FROM bai_pro3.packing_summary_input 
                  WHERE order_style_no='$style' AND order_del_no = '$schedule'
                  ORDER BY tid DESC LIMIT 1";
            $color_result = mysqli_query($link_ui, $color_query) or 
                            exit("Sql Error2 = $color_query".mysqli_error($GLOBALS["___mysqli_ston"]));
            if($color_result->num_rows > 0){                
                while($row = mysqli_fetch_array($color_result)){
                    $color = $row['order_col_des'];
                }
            }else{
                echo "<tr><td colspan=6><div class='alert alert-info' align='center'>No Jobs Data Found with color</div></td></tr>";
                exit(0);
            }
            ////////////////////////////////////////////////////
            //GETTING JOBS NUMBERS 
            $jobs_cats = [];
            $job_num_query = "SELECT group_concat(input_job_no_random) as nums
                              FROM bai_pro3.packing_summary_input 
                              WHERE order_style_no='$style' and order_del_no='$schedule' ";            
            $job_num_result = mysqli_query($link_ui, $job_num_query) or 
                              exit("Sql Error2 = $job_num_query".mysqli_error($GLOBALS["___mysqli_ston"]));
            if($job_num_result->num_rows > 0){
                $jobs_nums = mysqli_fetch_array($job_num_result);
                //Filtering Colors to buttons according to scanned quantities
                $status_query = "SELECT SUM(send_qty) as send_qty,SUM(recevied_qty) as rec_qty,
                                 SUM(rejected_qty) as rej_qty,operation_id,input_job_no_random_ref 
                                 FROM brandix_bts.bundle_creation_data
                                 WHERE input_job_no_random_ref IN (".$jobs_nums['nums'].")
                                 GROUP BY operation_id";
                $status_result =  mysqli_query($link_ui, $status_query) or 
                                  exit("Sql Error2 = $status_query".mysqli_error($GLOBALS["___mysqli_ston"]));               
                while($row = mysqli_fetch_array($status_result)){
                    $filter = $row['send_qty']-($row['rec_qty'] + $row['rej_qty'] );
                    if($filter == 0)
                        $color = 'btn-danger';
                    else if($filter > 0)
                        $color = 'btn-warning';
                    else if($filter < 0)
                        $color = 'btn-danger';
                    
                    if($row['send_qty'] >0 && $row['rec_qty']==0 && $row['rej_qty']==0)
                        $color = 'btn-success';
                    $jobs_cats[$row['input_job_no_random_ref']][$row['operation_id']] = $color; 
                }
                // echo $jobs_nums['nums'];
                // die();                 
            }else{
                echo "<tr><td colspan=6><div class='alert alert-info' align='center'>No Job Numbers Found</div></td></tr>";
                exit(0);
            }
            /////////////////////////////////////////////////////////////////
            //GETTING OPERATIONS AND CODES
            $operations_query = "SELECT o.operation_name,o.operation_code 
                                FROM brandix_bts.tbl_style_ops_master om
                                LEFT JOIN brandix_bts.tbl_orders_ops_ref o ON om.operation_code = o.operation_code
                                WHERE style='".trim($style)."' and schedule='$schedule' and color='$color' and barcode='Yes'";
            $operations_result = mysqli_query($link_ui, $operations_query) or 
                                 exit("Sql Error2 = $operations_query".mysqli_error($GLOBALS["___mysqli_ston"]));
            while($row = mysqli_fetch_array($operations_result)){
                // $code[] = $row['operation_code'];
                $opname[$row['operation_code']] = $row['operation_name'];
                $colors[$row['operation_code']] = '#ff0000';
            }    
            //echo $operations_query;
            //die();  
            $append='';
            $before='before';
            $controls = 'controls';
            $disabled = 'disabled';
            foreach($opname as $key=>$value){
                if($value=='')
                    continue;
                $append.="<a style='margin:3px;' href='?r=$$before&operation_id=$key' type='button' class='btn btn-sm
                          $$controls$key-' onclick='anchortag(event,this.href)' $$disabled>$value</a>";
            }
            ///////////////////////////////////////////////////////     
            //JOBS to dispaly on screen
            $jobs_query = "SELECT input_job_no_random,order_col_des,m3_size_code,carton_act_qty,input_job_no 
                           FROM bai_pro3.packing_summary_input 
                           WHERE order_style_no='$style' and order_del_no='$schedule' LIMIT $limit";            
            $jobs_result = mysqli_query($link_ui, $jobs_query) or 
                           exit("Sql Error2 = $jobs_query".mysqli_error($GLOBALS["___mysqli_ston"]));

            if($jobs_result->num_rows > 0){
                $sno=1;
                while($row = mysqli_fetch_array($jobs_result)){ 
                    $rand_ref = $row['input_job_no_random'];
                    $color = $row['order_col_des'];
                    $size  = $row['m3_size_code'];
                    $qty   = $row['carton_act_qty'];
                    $job_no= $row['input_job_no'];
                    foreach($opname as $key=>$value){
                        if($value=='')
                            continue;
                        $class =  $jobs_cats[$rand_ref][$key];
                        if(trim($class) === 'btn-danger')
                            $append = str_replace('$disabled','disabled',$append);
                        $class=' btn-success';
                        $append = str_replace('$controls'.$key.'-',$class,$append);
                    }
                
                    $url=base64_encode('/sfcs_app/app/production/controllers/sewing_job/sewing_job_scaning/scan_input_jobs.php')."&module=1.1&input_job_no_random_ref=$rand_ref&style=$style&schedule=$schedule&shift=G&sidemenu=1";
                    $buttons = str_replace('$before',$url,$append);
                    if($buttons == '')
                        $buttons = 'No operations for scanning';
                    
                    echo "<tr>";
                    echo    "<td>".$sno++."</td>";
                    echo    "<td><label style='padding:4px;border-radius:3px' class='label-lg label-warning'>
                                 J -$job_no</label></td>";
                    echo    "<td>$color</td>";
                    echo    "<td>$size</td>";
                    echo    "<td>$qty</td>";
                    echo    "<td>$buttons</td>";
                    echo "</tr>";
                }
            }else{
                echo "<tr><td colspan=6><div class='alert alert-danger' align='center'>No Data Found</div></td></tr>";
            }
            $link_ui->close();
        ?>
    </tbody>
</table>
      
<script>      
    //  $('#tab5').click(function(){   
    $(document).ready(function(){
        var table = $('#table_ajax_3').DataTable({
            "bSort":false,
            "processing": false,
            "serverSide": false,
            "pageLength": 15,
            "deferLoading": <?= $sno ?>
        })
    });
</script>

   
