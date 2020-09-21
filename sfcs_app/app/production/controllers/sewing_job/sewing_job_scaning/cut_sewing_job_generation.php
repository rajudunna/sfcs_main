<?php
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config_ajax.php');




if(isset($_POST) && isset($_POST['del_recs'])){
    include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config_ajax.php');
    $doc_no = $_POST['del_recs'];
    $ips_op_codes=array();
    $ips_op_codes[]=0;
    $op_code_query="SELECT operation_code FROM $brandix_bts.tbl_orders_ops_ref WHERE category='sewing'";
                $op_code_result = mysqli_query($link,$op_code_query);
    while($row = mysqli_fetch_array($op_code_result))
    {
        $ips_op_codes[] = $row['operation_code'];
    }
    $ips_op_code=implode(",",$ips_op_codes);
    $validation_query1 = "SELECT * FROM `bai_pro3`.`pac_stat_log_input_job` WHERE doc_no IN(".$doc_no.") and mrn_status=1";
    $sql_result1=mysqli_query($link, $validation_query1) or exit("Error while getting validation data");     
    $count1= mysqli_num_rows($sql_result1);
    $validation_query = "SELECT id from $brandix_bts.bundle_creation_data where docket_number in (".$doc_no.") and recevied_qty > 0
                and operation_id in (".$ips_op_code.")";
    $sql_result=mysqli_query($link, $validation_query) or exit("Error while getting validation data");      
    $count= mysqli_num_rows($sql_result);
    if ($count1>0 || $count>0) 
    {
        echo 'sewing_done';
    } 
    else 
    {
        $tid = array(); $docket_no = array();
        $get_seq_details = "SELECT tid, doc_no,order_del_no FROM bai_pro3.`packing_summary_input` WHERE pac_seq_no = '-1' and doc_no in (".$doc_no.")";
        $details_seq=mysqli_query($link, $get_seq_details) or exit("error while fetching sequence details for this schedule"); 
        while($row=mysqli_fetch_array($details_seq))
        {
            $tid[] = $row['tid'];
            $docket_no[] = $row['doc_no'];
            $get_order_del_no = $row['order_del_no'];
        }

        $get_tids = implode(',', $tid);
        $get_docs = implode(",", array_unique($docket_no));

        $delete_plan_dashbrd_qry="DELETE FROM $bai_pro3.plan_dashboard WHERE doc_no in($get_docs)"; 
        mysqli_query($link, $delete_plan_dashbrd_qry) or exit("Sql Error delete_plan_dashbrd_qry"); 
         
        $delete_plan_input_qry="DELETE FROM bai_pro3.`plan_dashboard_input` WHERE input_job_no_random_ref IN (SELECT input_job_no_random FROM $bai_pro3.`pac_stat_log_input_job` WHERE tid IN ($get_tids))"; 
        mysqli_query($link, $delete_plan_input_qry) or exit("Sql Error delete_plan_input_qry");

        $qry = "DELETE FROM `bai_pro3`.`pac_stat_log_input_job` where doc_no IN (".$doc_no.") and pac_seq_no='-1'";
        $result_time2 = mysqli_query($link, $qry) or exit("Deleate jobs.".mysqli_error($GLOBALS["___mysqli_ston"]));
        
        $insert_log="INSERT INTO $bai_pro3.inputjob_delete_log (user_name,date_time,reason,SCHEDULE) VALUES (USER(),now(),'Cut job based','$get_order_del_no')"; 
        mysqli_query($link, $insert_log) or exit("Sql Error insert_log");
        $sewing_cat = 'sewing';
        $op_code_query  ="SELECT group_concat(operation_code) as codes FROM $brandix_bts.tbl_orders_ops_ref 
                          WHERE trim(category) = '$sewing_cat' ";
        $op_code_result = mysqli_query($link, $op_code_query) or exit("No Operations Found for Sewing");
        while($row=mysqli_fetch_array($op_code_result)) 
        {
            $op_codes  = $row['codes']; 
        }

        $mo_query  = "SELECT GROUP_CONCAT(\"'\",mo_no,\"'\") as mos from $bai_pro3.mo_details where schedule = '$get_order_del_no'";
        $mo_result = mysqli_query($link,$mo_query);
        while($row = mysqli_fetch_array($mo_result))
        {
            $mos = $row['mos'];
        }

        $delete_query = "DELETE from $bai_pro3.mo_operation_quantites where ref_no in ($get_tids) and op_code in ($op_codes) ";
        $delete_result = mysqli_query($link,$delete_query);

        $delete_query2 = "DELETE from $brandix_bts.bundle_creation_data where docket_number in (".$doc_no.") and operation_id in (".$ips_op_code.")";
        $delete_result = mysqli_query($link,$delete_query2);
        echo 'success';
    }
    echo 'success';
}
function calculate_ratio($doc,$link){
    $sum_ratio_query = "SELECT SUM(cut_quantity) as ratio from bai_pro3.cps_log where doc_no in ($doc)
    and operation_code = 15";
    $sum_ratio_result = mysqli_query($link,$sum_ratio_query);
    $row = mysqli_fetch_array($sum_ratio_result);
    return $row['ratio'];
}

function assign_to_gets($ars,$data_samps){
    for($lp=1;$lp<=$ars['max'];$lp++){
        $snp = str_pad($lp,2,"0",STR_PAD_LEFT);
        if($ars['s'.$snp]>0){
            $aloc_val = 0;
            $sample = 0;
            $excess = 0;
            if($data_samps['s'.$snp]['sample']>0){
                $sample = ($ars['s'.$snp]-$data_samps['s'.$snp]['sample'])>=0 ? $data_samps['s'.$snp]['sample'] : $ars['s'.$snp];
                $data_samps['s'.$snp]['sample'] = ($ars['s'.$snp]-$data_samps['s'.$snp]['sample'])>=0 ? 0 : ($data_samps['s'.$snp]['sample']-$ars['s'.$snp]);
                $ars['s'.$snp] = (($ars['s'.$snp])-$sample);
            }
            if($data_samps['s'.$snp]['excess']>0 && $ars['s'.$snp]>0){
                $excess = ($ars['s'.$snp]-$data_samps['s'.$snp]['excess'])>=0 ? $data_samps['s'.$snp]['excess'] : $ars['s'.$snp];
                $data_samps['s'.$snp]['excess'] = ($ars['s'.$snp]-$data_samps['s'.$snp]['excess'])>=0 ? 0 : ($data_samps['s'.$snp]['excess']-$ars['s'.$snp]);
                $ars['s'.$snp] = (($ars['s'.$snp])-$excess);
            }
            echo "<script>
            var sp_values = document.getElementById('dataval'+".$ars['ratio']."+".$lp."+".$ars['end'].");
            sp_values.setAttribute('data-sample','".$sample."');
            sp_values.setAttribute('data-excess','".$excess."');
            </script>";
        }
    }
    $status = (array_sum(array_column($data_samps,'sample'))+(array_sum(array_column($data_samps,'excess')))==0) ? true : false;
    return ['status'=>$status,'data'=>$data_samps];
}


    ?>
    
<div class = 'panel panel-primary'>
    <div class = 'panel-heading'><b>Cut Sewing Job Generation</b></div>
    <?php
        include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config_ajax.php');
        include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/functions.php');
        include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/functions_dashboard.php');
        $style=style_decode($_GET['style']);
        $schedule=$_GET['schedule']; 
        $color  = color_decode($_GET['color']);
        
        echo '<div class = "panel-body">';
            $sql="select distinct order_style_no from bai_pro3.bai_orders_db_confirm";
            $sql_result=mysqli_query($link, $sql) or exit("Sql Error123".mysqli_error($GLOBALS["___mysqli_ston"]));
            echo "<div class=\"row\">
                    <div class=\"col-sm-3\">
                        <label>Select Style:</label>
                        <select class='form-control' name=\"style\"  id='style' required>";
                            echo "<option value=''>Please Select</option>";
                            while($sql_row=mysqli_fetch_array($sql_result))
                            {
                                if(str_replace(" ","",$sql_row['order_style_no'])==str_replace(" ","",$style))
                                {
                                    echo "<option value=\"".$sql_row['order_style_no']."\" selected>".$sql_row['order_style_no']."</option>";
                                }
                                else
                                {
                                    echo "<option value=\"".$sql_row['order_style_no']."\">".$sql_row['order_style_no']."</option>";
                                }
                            }
                        echo "</select>
                    </div>";
                    $sql="select distinct order_del_no from bai_pro3.bai_orders_db_confirm where order_style_no=\"$style\" and order_joins not in ('1','2')";
                    $sql_result=mysqli_query($link, $sql) or exit("Sql Error schedule ".mysqli_error($GLOBALS["___mysqli_ston"]));
                    echo "<div class='col-sm-3'>
                            <label>Select Schedule:</label> 
                            <select class='form-control' name=\"schedule\"  id='schedule' required>";
                                echo "<option value=''>Please Select</option>";
                                while($sql_row=mysqli_fetch_array($sql_result))
                                {
                                    if(str_replace(" ","",$sql_row['order_del_no'])==str_replace(" ","",$schedule))
                                    {
                                        echo "<option value=\"".$sql_row['order_del_no']."\" selected>".$sql_row['order_del_no']."</option>";
                                    }
                                    else
                                    {
                                        echo "<option value=\"".$sql_row['order_del_no']."\">".$sql_row['order_del_no']."</option>";
                                    }
                                }
                            echo "</select>
                        </div>";
                    $sql="select distinct order_col_des from bai_pro3.bai_orders_db_confirm where order_style_no=\"$style\" and order_del_no= \"$schedule\" and order_joins not in ('1','2')";
                    $sql_result=mysqli_query($link, $sql) or exit("Sql Error color ".mysqli_error($GLOBALS["___mysqli_ston"]));
                    echo "<div class='col-sm-3'>
                            <label>Select Color:</label>
                            <select class='form-control' name=\"color\"  id='color' required>";
                                echo "<option value=''>Please Select</option>";
                                while($sql_row=mysqli_fetch_array($sql_result))
                                {
                                    if(str_replace(" ","",$sql_row['order_col_des'])==str_replace(" ","",$color))
                                    {
                                        echo "<option value=\"".$sql_row['order_col_des']."\" selected>".$sql_row['order_col_des']."</option>";
                                    }
                                    else
                                    {
                                        echo "<option value=\"".$sql_row['order_col_des']."\">".$sql_row['order_col_des']."</option>";
                                    }
                                }
                            echo "</select>
                        </div>";

            echo "<div class='col-sm-3'>";
                if($schedule!='' && $style!='')
                {
                    //Style Encoded
                    $main_style=style_encode($style);
                    echo "<a class='btn btn-success pull-right' href='?r=L3NmY3NfYXBwL2FwcC9wcm9kdWN0aW9uL2NvbnRyb2xsZXJzL3Nld2luZ19qb2IvaW5wdXRfam9iX21peF9jaF9yZXBvcnQucGhw&schedule=".$schedule."&seq_no=-1&style=".$main_style."' id='print_labels'>Print Labels</a>";
                }
            echo "</div>
            <br/>";
    ?>
</div>
<?php
if($schedule != "" && $color != "" &&  short_shipment_status($style,$schedule,$link))
{
    $ratio_query = "SELECT * FROM bai_pro3.bai_orders_db_confirm bd
   LEFT JOIN bai_pro3.cat_stat_log csl ON bd.order_tid = csl.order_tid 
   LEFT JOIN bai_pro3.plandoc_stat_log psl ON csl.tid = psl.cat_ref AND psl.order_tid = bd.order_tid 
   WHERE csl.category IN ('Body','Front') AND bd.order_del_no='".$schedule."' AND TRIM(bd.order_col_des) =trim('".$color."') AND psl.order_tid <> '' AND psl.remarks='Normal'  ORDER BY ratio";
   $doc_nos = [];
    $view_shows=[];
    $ratio_result = mysqli_query($link, $ratio_query) or exit("Sql Error : ratio_query".mysqli_error($GLOBALS["___mysqli_ston"]));
    $i=0;
    $max=0;
    $samples_qty = [];
    $over_all_qtys_samps = [];
    $ex_cut_lrt = 2;
    $max_cut = 0;
    $over_all_data = [];
    if(mysqli_num_rows($ratio_result)>0){
        echo "<div class='col-sm-12' id='main-table'><br><br><div class='table-responsive'><table class='table'>";
        while($row=mysqli_fetch_array($ratio_result))
        {
            $doc_nos[] = $row['doc_no'];
            $raw = [];
            if($i==0){
                //============ find 1st are last cut =================
                $qry_get_lrf_cut = "SELECT * FROM bai_pro3.`excess_cuts_log` WHERE schedule_no='".$schedule."' AND trim(color)=trim('".$color."')";
                $res_get_lrf_cut = mysqli_query($link, $qry_get_lrf_cut) or exit("Sql Error : cut data qry".mysqli_error($GLOBALS["___mysqli_ston"]));
                $res_lrt_cut = mysqli_fetch_all($res_get_lrf_cut,MYSQLI_ASSOC);
                $ex_cut_lrt = $res_lrt_cut[0]['excess_cut_qty'];
                //================ get sample quantity ===================
                $qry_get_sample_qty = "SELECT size,input_qty FROM bai_pro3.`sp_sample_order_db` WHERE order_tid='".$row['order_tid']."' GROUP BY size";
                $res_get_sample_qty = mysqli_query($link, $qry_get_sample_qty) or exit("Sql Error : sample qry".mysqli_error($GLOBALS["___mysqli_ston"]));
                $res_sample_qty = mysqli_fetch_all($res_get_sample_qty,MYSQLI_ASSOC);
                foreach($res_sample_qty as $samp_view){
                    $samples_qty[$samp_view['size']] = $samp_view['input_qty'];
                }
                //============ get excess qty ============
                $get_excess_qty = "SELECT * FROM bai_pro3.`allocate_stat_log` WHERE cat_ref='".$row['cat_ref']."' AND order_tid='".$row['order_tid']."'";
                $res_excess_qty = mysqli_query($link, $get_excess_qty) or exit("Sql Error : excess qry".mysqli_error($GLOBALS["___mysqli_ston"]));
                $res_excess_qty = mysqli_fetch_all($res_excess_qty,MYSQLI_ASSOC);
                //=====================================================================
                echo "<thead>
                    <tr>
                        <th>Ratio</th><th class='col-sm-2'>Cut No</th><th class='col-sm-2'>Docket No</th><th class='col-sm-2'>Plies</th>";
                        for($j=1;$j<=50;$j++){
                            $sno = str_pad($j,2,"0",STR_PAD_LEFT);
                            if($row['title_size_s'.$sno]!=''){
                                echo "<th id='datatitle".$j."' data-title='s".$sno."' data-value='".$row['title_size_s'.$sno]."'>".$row['title_size_s'.$sno]."</th>";
                                $old_qty[$sno] = 0;
                                $max=$j;
                                $allocate = 0;
                                foreach($res_excess_qty as $a){
                                    $allocate+=($a['allocate_s'.$sno]*$a['plies']);
                                }
                                
                                $over_all_qtys_samps['s'.$sno] = ["order"=>$row['order_s_s'.$sno],"sample"=>$samples_qty[$row['title_size_s'.$sno]],"allocate"=>$allocate,"excess"=>$allocate-$row['order_s_s'.$sno]-$samples_qty[$row['title_size_s'.$sno]]];
                            }else{
                                break;
                            } 
                        }
                        

                echo "</tr>
                </thead><tbody>";
               $old_ratio = $row['ratio'];
               $old_pcut = [];
               $old_pplice = [];
               $old_cut_status = '';
               $end = 1;
               $old_doc_nos = [];
                  
            }
            $i++;
            //no need to consider
            if($old_ratio==$row['ratio']){
                echo "<tr style='display:none'>
                <td>".$row['ratio']."</td>
                <td id='datarc".$row['ratio'].$end."' data-ratio = '".$row['ratio']."' data-cut='".$row['pcutno']."' data-destination='".$row['destination']."' data-dono='".$row['doc_no']."'>".$row['pcutno']."</td>
                <td>".$row['p_plies']."</td>";
                for($k=1;$k<=$max;$k++){
                    $sno = str_pad($k,2,"0",STR_PAD_LEFT);
                    echo "<td data-sample=0 data-excess=0 id='dataval".$row['ratio'].$k.$end."' data-title='s".$sno."' data-value='".($row['p_s'.$sno]*$row['p_plies'])."'>".($row['p_s'.$sno]*$row['p_plies'])."</td>";
                    $raw['s'.$sno] = $row['p_s'.$sno]*$row['p_plies'];
                    $old_qty[$sno]+=($row['p_s'.$sno]*$row['p_plies']);
                }
                echo "<td></td>";
                echo "</tr>";
                
                $old_pcut[]=$row['pcutno'];
                $old_pplice[]=$row['p_plies'];
                $old_doc_nos[] = $row['doc_no'];
                if($row['act_cut_status']!='')
                    $old_cut_status = $row['act_cut_status'];

                $raw['pcutno'] = $row['pcutno'];
                $raw['p_plies'] = $row['p_plies'];
                $raw['doc_no'] = $row['doc_no'];
                $raw['ratio'] = $row['ratio'];
                $raw['max'] = $max;
                $raw['end'] = $end;
                $end++;
            }else{
                echo "<tr>
                <td>".$old_ratio."</td>
                <td>".implode(',',$old_pcut)."</td>
                <td>".implode(',',$old_doc_nos)."</td>
                <td>".implode(',',$old_pplice)."</td>";
                for($k=1;$k<=$max;$k++){
                    $sno = str_pad($k,2,"0",STR_PAD_LEFT);
                    echo "<td>$old_qty[$sno]</td>";
                    $old_qty[$sno]=0;
                }
                $qry_get_doc_details = "SELECT COUNT(*) AS old_jobs,pac_seq_no FROM bai_pro3.pac_stat_log_input_job WHERE doc_no IN (".implode(',',$old_doc_nos).")";
                $qry_get_doc_details_res = mysqli_query($link, $qry_get_doc_details) or exit("Sql Error : qry_get_doc_details".mysqli_error($GLOBALS["___mysqli_ston"]));
                $old_cnt_jb = mysqli_fetch_array($qry_get_doc_details_res);
                if($old_cnt_jb['old_jobs']==0){
                    $doc_list = json_encode($old_doc_nos);
                    $cut_list = json_encode($old_pcut);
                    echo "<td><button class='btn btn-info' data-toggle='modal' data-target='#modalLoginForm' onclick='assigndata($old_ratio,$max,$end,$doc_list,$cut_list,$schedule)'>Generate Jobs</button></td>";
                }
                elseif($old_cnt_jb['pac_seq_no']=='-1'){
                    $view_shows[] = implode(',',$old_doc_nos);
                    $imp_data = implode(',',$old_doc_nos);
                    echo "<td><a class='btn btn-warning' onclick='show_view_form(\"$imp_data\")'>View</a>"; 
                    //if($old_cut_status=='')
                        echo "<a class='btn btn-danger' id='del-$imp_data' onclick='delet(\"$imp_data\")'>Delete</a>
                                <div id='delete_message_$imp_data' style='display:none'><h3 class='badge progress-bar-success'>Deleting...</h3></div>";
                    echo "</td>";
                }else{
                    echo "<td><h3 class='label label-warning'>Jobs Already Created with another source..</h3></td>";
                }
                echo "</tr>";
                //Till here 
                $display_qty = 0;
                $bundle_qty = 0;
                $display_qty = calculate_ratio($old_doc_nos[0],$link);
                $bundle_qty = $old_pplice[0];
                echo "<input id='".$old_ratio."_display_qty' type='hidden' value='$display_qty'>";
                echo "<input id='".$old_ratio."_bundle_qty' type='hidden' value='$bundle_qty'>";

                $end = 1;
                $old_ratio = $row['ratio'];
                $old_pcut = [];
                $old_doc_nos = [];
                $old_pplice = [];                
                
                $old_cut_status = '';
                echo "<tr style='display:none'>
                    <td>".$row['ratio']."</td>
                    <td id='datarc".$row['ratio'].$end."' data-ratio = '".$row['ratio']."' data-cut='".$row['pcutno']."'data-destination='".$row['destination']."' data-dono='".$row['doc_no']."'>".$row['pcutno']."</td>
                    <td>".$row['p_plies']."</td>";
                for($k=1;$k<=$max;$k++){
                    $sno = str_pad($k,2,"0",STR_PAD_LEFT);
                    echo "<td data-sample=0 data-excess=0 id='dataval".$row['ratio'].$k.$end."' data-title='s".$sno."' data-value='".($row['p_s'.$sno]*$row['p_plies'])."'>".($row['p_s'.$sno]*$row['p_plies'])."</td>";
                    $raw['s'.$sno] = $row['p_s'.$sno]*$row['p_plies'];
                    $old_qty[$sno]+=($row['p_s'.$sno]*$row['p_plies']);
                }
                echo "<td></td>";
                echo "</tr>";
                
                $old_pcut[]=$row['pcutno'];
                $old_doc_nos[] = $row['doc_no'];
                $old_pplice[]=$row['p_plies'];
                
                if($row['act_cut_status']!='')
                    $old_cut_status = $row['act_cut_status'];
                $raw['pcutno'] = $row['pcutno'];
                $raw['p_plies'] = $row['p_plies'];
                $raw['doc_no'] = $row['doc_no'];
                $raw['ratio'] = $row['ratio'];
                $raw['max'] = $max;
                $raw['end'] = $end;
                $end++;
            }
            
            $max_cut = $row['pcutno'];
            $over_all_data[] = $raw;
        }
        $display_qty = 0;
        $bundle_qty = 0;
        $display_qty = calculate_ratio($old_doc_nos[0],$link);
        $bundle_qty = $old_pplice[0];
        echo "<input id='".$old_ratio."_display_qty' type='hidden' value='$display_qty'>";
        echo "<input id='".$old_ratio."_bundle_qty' type='hidden' value='$bundle_qty'>";
        //#2932 old clubbed docket can change the bundle qty
        $check_club_docket_query = "SELECT doc_no,p_plies from $bai_pro3.plandoc_stat_log where doc_no IN (".implode(',',$old_doc_nos).") and org_doc_no >=1 ";
        $check_club_docket_query_res = mysqli_query($link,$check_club_docket_query);
        if(mysqli_num_rows($check_club_docket_query_res) > 0){
            while($club_row = mysqli_fetch_array($check_club_docket_query_res))
            {
                if($club_row['p_plies'] == 1){
                    echo "<input id='clubbed' type='hidden' value='clubbed'>";
                }
            }
        }
        echo "<tr>
            <td>".$old_ratio."</td>
            <td>".implode(",",$old_pcut)."</td>
            <td>".implode(",",$old_doc_nos)."</td>
            <td>".implode(',',$old_pplice)."</td>";
            for($k=1;$k<=$max;$k++){
                $sno = str_pad($k,2,"0",STR_PAD_LEFT);
                echo "<td>$old_qty[$sno]</td>";
            }
            $qry_get_doc_details = "SELECT COUNT(*) AS old_jobs,pac_seq_no FROM bai_pro3.pac_stat_log_input_job WHERE doc_no IN (".implode(',',$old_doc_nos).")";
            $qry_get_doc_details_res = mysqli_query($link, $qry_get_doc_details) or exit("Sql Error : qry_get_doc_details".mysqli_error($GLOBALS["___mysqli_ston"]));
            $old_cnt_jb = mysqli_fetch_array($qry_get_doc_details_res);
            if($old_cnt_jb['old_jobs']==0){
                $doc_list = json_encode($old_doc_nos);
                $cut_list = json_encode($old_pcut);
                echo "<td><button class='btn btn-info' data-toggle='modal' data-target='#modalLoginForm' onclick='assigndata($old_ratio,$max,$end,$doc_list,$cut_list,$schedule)'>Generate Jobs</button></td>";
            }
            elseif($old_cnt_jb['pac_seq_no']=='-1'){
                $view_shows[] = implode(',',$old_doc_nos);
                $imp_data = implode(',',$old_doc_nos);
                echo "<td><a class='btn btn-warning' onclick='show_view_form(\"$imp_data\")'>View</a>"; 
                //if($old_cut_status=='')
                    echo "<a class='btn btn-danger' id='del-$imp_data' onclick='delet(\"$imp_data\")'>Delete</a>
                            <div id='delete_message_$imp_data' style='display:none'><h3 class='badge progress-bar-success'>Deleting...</h3></div>";
                echo "</td>";
            }else{
                echo "<td><h3 class='label label-warning'>Jobs Already Created with another source..</h3></td>";
            }
        echo "</tr>";
        echo "</tbody></table></div></div>"; 
        if(count($view_shows)>0){
            foreach($view_shows as $view){
                $ids = str_replace(",","_",$view);
                echo "<div id='view-".$ids."' style='display:none'>";
                $qry_get_doc_details_view = "SELECT * FROM bai_pro3.pac_stat_log_input_job WHERE doc_no IN (".$view.")";
                $qry_get_doc_details_view_res = mysqli_query($link, $qry_get_doc_details_view) or exit("Sql Error : qry_get_doc_details_view_res".mysqli_error($GLOBALS["___mysqli_ston"]));
                echo "<div class='pull-right'><button class='btn btn-info' onclick='hide_rev(\"$view\")'>Back</button></div><br/>";
                echo "<table class='table'><thead><tr><th>#</th><th>Job</th><th>Size</th><th>Sewing Type</th><th>Quantity</th></tr></thead><tbody>";
                $seq=1;
                while($wr = mysqli_fetch_array($qry_get_doc_details_view_res)){
                    if($wr['type_of_sewing'] == 3){
                        $sew_type = 'Sample';
                    }elseif($wr['type_of_sewing'] == 2){
                        $sew_type = 'Excess';
                    }else{
                        $sew_type = 'Normal';
                    }
                    
                    echo "<tr>
                        <td>".$seq++."</td>
                        <td>".$wr['input_job_no']."</td>
                        <td>".$wr['size_code']."</td>
                        <td>".$sew_type."</td>
                        <td>".$wr['carton_act_qty']."</td>
                    </tr>";
                }
                echo "</tbody></table>";
                echo "</div>";
            }
            echo "<style>
            #print_labels{
                display:block !important;
            }
            </style>";
        }

        if($ex_cut_lrt == 1){
            //=============== first cut =============
            for($i=0;$i<=count($over_all_data)-1;$i++){
                $arts = assign_to_gets($over_all_data[$i],$over_all_qtys_samps);
                if($arts['status']){
                    break;
                }else{
                    $over_all_qtys_samps = $arts['data'];
                }
            }
        }else{
            //=============== last cut ==============
            for($i=count($over_all_data)-1;$i>=0;$i--){
                $arts = assign_to_gets($over_all_data[$i],$over_all_qtys_samps);
                if($arts['status']){
                    break;
                }else{
                    $over_all_qtys_samps = $arts['data'];
                }
            }
        }

    }else{
        echo "<script> swal('No Data Found'); </script>";
    }

    //=====================
    ?>
    <div class="modal fade" id="modalLoginForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     ng-app="cutjob" ng-controller="cutjobcontroller" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <h4 class="modal-title w-100 font-weight-bold">Sewing Job Generation</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="index.php?r=<?php echo $_GET['r']?>" name= "modal_form" method="post" id="modal_form">
                    <div class='row'>
                        <div class='col-sm-4'>
                            <label data-error="wrong" data-success="right" for="defaultForm-email">Garment per Sewing Job</label>
                            <input type="text" id="job-qty" class="form-control validate integer" ng-model= "jobcount" name="jobcount">
                            <input type="hidden" id="job-qty1" class="form-control validate integer" ng-model= "jobcount1" name="jobcount1">
                        </div>
                        <div class='col-sm-4'>
                            <label data-error="wrong" data-success="right" for="defaultForm-email">Garment per Bundle</label>
                            <input type="text" id="bundle-qty" class="form-control validate integer" ng-model= "bundleqty" name="bundleqty">
                            <input type="hidden" id="bundle-qty1" class="form-control validate integer" ng-model= "bundleqty1" name="bundleqty1">
                            <input type="hidden" id="docs" class="form-control" ng-model= "docs" name="docs">
                            <input type="hidden" id="cuts" class="form-control" ng-model= "cuts" name="cuts">
                            <input type="hidden" id="schedule1" class="form-control" ng-model= "schedule1" name="schedule1">
                            <input type="hidden" id="style1" class="form-control" ng-model= "style1" name="style1">
                            <input type="hidden" id="color1" class="form-control" ng-model= "color1" name="color1">
                        </div>
                        <div class='col-sm-2'>
                            <br/><br/>
                            <input type="button" id='markers' onclick="return check_all();" class="btn btn-success" value="Confirm.." name="modal_submit">
                        </div>
                        </form>
                    </div>
                    <br/>
                    <div ng-show='jobs.length'>
                        <table class='table' style="display:none">
                            <thead>
                                <tr><th>#</th><th>Job ID</th><th>Bundle</th><th>Size</th><th>Quantity</th></tr>
                            </thead>
                            <tbody ng-repeat="items in fulljob">
                                <tr class='danger'><th class='text-center'>Ratio</th><th class='text-center'>{{items.ratio}}</th>
                                    <td></td><th class='text-center'>Cut</th><th class='text-center'>{{items.cut}}</th></tr>
                                <tr ng-repeat="item in items.sizedetails">
                                    <td>{{$index+1}}</td>
                                    <td>{{item.job_id}}</td>
                                    <td>{{item.bundle}}</td>
                                    <td>{{item.job_size}}</td>
                                    <td>{{item.job_qty}}</td>
                                    <td>{{item.type_of_sewing}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    
                    <div id="generate_message" class='alert alert-success'>
                        Please Wait while we Generate Sewing Jobs...
                    </div>

                </div> 
                <div class="modal-footer d-flex justify-content-center">
                    <button class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
<?php
    //=====================
    //echo base64_decode($_GET['r']);
} 


$url = base64_decode($_GET['r']);
$url = str_replace('\\', '/', $url);
$docnos = implode(',',$doc_nos);

?>

</div>

<script>
var app = angular.module('cutjob', []);

angular.bootstrap($('#modalLoginForm'), ['cutjob']);
function assigndata(s,max,end,old_doc_nos,cut_nos,schedule){
    $('#sub-mit').show();
    var details = [];
    $('#display_qty').val(0);
    var d_qty = $('#'+s+'_display_qty').val();
    var b_qty = $('#'+s+'_bundle_qty').val();
    $('#job-qty').val(d_qty);
    $('#bundle-qty').val(b_qty);
    $('#job-qty1').val(d_qty);
    $('#bundle-qty1').val(b_qty);
    $('#docs').val(old_doc_nos);
    $('#cuts').val(cut_nos);
    $('#schedule1').val(schedule);
    $('#style1').val($('#style').val());
    $('#color1').val($('#color').val());
}

function show_view_form(docs_id){
    //var r = docs_id.replace(",","_");
    var myarr = docs_id.split(",");
    var r = myarr.join('_');
    console.log("view-"+r);
    $("#view-"+r).css("display", "block");
    $("#main-table").css("display", "none");
}
function hide_rev(docs_id){
    var myarr = docs_id.split(",");
    var r = myarr.join('_');
    console.log("view-"+r);
    $("#view-"+r).css("display", "none");
    $("#main-table").css("display", "block");
}
function delet(docs_id){
    $("#del-"+docs_id).css("display", "none");
    $("#delete_message_"+docs_id).css("display", "block");
    $.post( "<?= trim($url) ?>", { del_recs: docs_id } ).done(function(data) {
        console.log(data);
        if(data=='sewing_done'){
            swal('Scanning/MRN is Already Performed','Cannot Delete Sewing Jobs','error');
            setTimeout(function(){ location.reload(); }, 600);
        }
        // else if(data=='success'){
        //     swal('Jobs Deleted successfully.');
        //     setTimeout(function(){ location.reload(); }, 600);
        // }
        else{
            swal('Jobs Deleted successfully.');
            // swal('Jobs Deletion Failed.');
            setTimeout(function(){ location.reload(); }, 600);
        }
    });
}


    $(document).ready(function(){
        $("#generate_message").css("display","none");
        var url1 = '?r=<?= $_GET['r'] ?>';
        $("#style").change(function(){
            //alert("The text has been changed.");
            var optionSelected = $("option:selected", this);
            var valueSelected = this.value;
            window.location.href =url1+"&style="+window.btoa(unescape(encodeURIComponent(valueSelected)))
        });
        $("#schedule").change(function(){
            // var input = $(this);
            //var val = input.val();
            // alert(val);
            //window.location.href =url1+"&schedule="+val;
            var optionSelected = $("option:selected", this);
            var valueSelected2 = this.value;
            var style1 = $("#style").val();
            window.location.href =url1+"&style="+window.btoa(unescape(encodeURIComponent(style1)))+"&schedule="+valueSelected2
        });

        $("#color").change(function(){
            //alert("The text has been changed.");
            var optionSelected = $("option:selected", this);
            var valueSelected3 = this.value;
            var style1 = $("#style").val();
            var schedule = $("#schedule").val();
            window.location.href =url1+"&style="+window.btoa(unescape(encodeURIComponent(style1)))+"&schedule="+schedule+"&color="+window.btoa(unescape(encodeURIComponent(valueSelected3)))
            //alert(valueSelected2); 
            //window.location.href =url1+"&style="+document.mini_order_report.style.value+"&schedule="+document.mini_order_report.schedule.value
        });
        $("#job-qty").change(function(){
            if(Number($("#job-qty").val())<=0) {
                swal('Garment per Sewing Job should be grater then zero.');
                $("#job-qty").val($("#job-qty1").val());
            }
            if(Number($("#job-qty").val()) > $("#job-qty1").val()) {
                swal('Invalid Garment per Sewing Job Quantity.');
                $("#job-qty").val($("#job-qty1").val());
            }
            if(Number($("#job-qty").val()) < Number($("#bundle-qty").val())) {
                swal('Garment per Sewing Job Qty should be greater then Garment per Bundle Qty');
                $("#job-qty").val($("#job-qty1").val());
                $("#bundle-qty").val($("#bundle-qty1").val());

            }
        });
        $("#bundle-qty").change(function(){
            // if(Number($("#bundle-qty").val()) > $("#bundle-qty1").val()) {
            //     if($("#clubbed").val() != 'clubbed'){
            //         swal('Invalid Garment per Bundle quantity.');
            //         $("#bundle-qty").val($("#bundle-qty1").val());
            //     }
            // }
            if(Number($("#job-qty").val())<Number($("#bundle-qty").val())) {
                swal('Garment per Bundle Qty should be less then Garment per Sewing Job Qty');
                $("#job-qty").val($("#job-qty1").val());
                $("#bundle-qty").val($("#bundle-qty1").val());
            }
        });
        
        
        var url2 = "<?php echo getFullURL($_GET['r'],'cut_sewing_job_gen_function.php','R'); ?>";
        
         $("#markers").click(function(e) {
             $("#generate_message").css("display","block");
             $("#markers").prop("disabled", true);
             e.preventDefault();
              $.ajax({
                type: 'post',
                url: url2,
                data: $('#modal_form').serialize()+'&'+$.param({ 'modal_submit': 'modal_submit' }),
                success: function (res) {
                    $("#generate_message").css("display","none");
                    // console.log(res);
					document.getElementById("loading-image").style.display = "none";
					if(res) 
                    {
						
						if(res['status'] == true)
                        {
                            sweetAlert('Cut Sewing jobs generated successfully','','');
                            var optionSelected = $("option:selected", this);
                            var color = $("#color").val();
                            var style = $("#style").val();
                            var schedule = $("#schedule").val();
                            window.location.href =url1+"&style="+window.btoa(unescape(encodeURIComponent(style)))+"&schedule="+schedule+"&color="+window.btoa(unescape(encodeURIComponent(color)))
                        } 
                        else 
                        {
                            var val1 = res['final'];
                            if(val1 == 'first_cut')
                            {
                                sweetAlert('Cannot Proceed sewing Jobs because selection is Fisrt Cut',' Lay Plan Not Prepared for Complete Qty.','');
                                var optionSelected = $("option:selected", this);
                                var color = $("#color").val();
                                var style = $("#style").val();
                                var schedule = $("#schedule").val();
                                setTimeout(function(){window.location.href =url1+"&style="+window.btoa(unescape(encodeURIComponent(style)))+"&schedule="+schedule+"&color="+window.btoa(unescape(encodeURIComponent(color)))} , 2000);
							}

							var data = $.parseJSON(res);
							if(data['final'] == 'validating')
                            {
								sweetAlert('Cut Sewing jobs already generating for the same schedule','Please wait','');
						        //$("#markers").prop("disabled", true);
								var optionSelected = $("option:selected", this);
								var color = $("#color").val();
								var style = $("#style").val();
								var schedule = $("#schedule").val();
								window.location.href =url1+"&style="+window.btoa(unescape(encodeURIComponent(style)))+"&schedule="+schedule+"&color="+window.btoa(unescape(encodeURIComponent(color)))
								
							}	
                        }
					} 
                    else 
                    {
						sweetAlert('Cut Sewing jobs generation failed','','');
						$("#markers").prop("disabled", false);
					}
				}
			  });
		 });
    });
</script>
<style>
    #loading-image{
      position:fixed;
      top:0px;
      right:0px;
      width:100%;
      height:100%;
      background-color:#666;
      /* background-image:url('ajax-loader.gif'); */
      background-repeat:no-repeat;
      background-position:center;
      z-index:10000000;
      opacity: 0.4;
      filter: alpha(opacity=40); /* For IE8 and earlier */
    }
    </style>
    <script>
    function check_all()
    {
        document.getElementById("loading-image").style.display = "block";
    }
    </script>   
        <div class="ajax-loader" id="loading-image" style="display: none">
        <center><img src='<?= getFullURLLevel($_GET['r'],'common/images/ajax-loader.gif',3,'R'); ?>' class="img-responsive" style="padding-top: 250px"/></center>
    </div>
<style>
#print_labels{
    display:none;
}
</style>
