<?php
/* ===============================================================
               Created By : Sudheer and Chandu
Created : 30-08-2018
Updated : 08-10-2018
input : Schedule,color & cutjob count.
output v0.1: Generate jobs.
Technical Stack : PHP 7,Angular js 1.4,JQuery, Maria DB
update : 1.Excess and sample code implemented, 2. View and deleate operations implemented in this screen. 3.Redirect to print screens.
=================================================================== */

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

if(isset($_POST) && isset($_POST['main_data'])){
    include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config_ajax.php');
    include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/mo_filling.php');
    //$datt = $_POST['date_y']."-".$_POST['date_m']."-".$_POST['date_d'];
    //echo $datt;die();
    $main_data = $_POST['main_data'];
    $schedule  = $_POST['schedule'];
    $style  = $_POST['style'];
    $docnos = $_POST['docnos'];
    $count = 0;

    $ins_qry2 = "INSERT INTO `bai_pro3`.`sewing_jobs_ref` (style,schedule,bundles_count,log_time) VALUES ('".$style."','".$schedule."','0',NOW())";
    $result_time2 = mysqli_query($link, $ins_qry2) or exit("Sql Error update downtime log".mysqli_error($GLOBALS["___mysqli_ston"]));
    $inserted_id = mysqli_insert_id($link);

        
    $old_jobs_cnt_qry = "SELECT  MAX(input_job_no*1) AS old_jobs 
            FROM bai_pro3.packing_summary_input WHERE order_del_no = '$schedule'";
        //echo $old_jobs_cnt_qry;
    $old_jobs_cnt_res = mysqli_query($link, $old_jobs_cnt_qry) or exit("Sql Error : old_jobs_cnt_qry".mysqli_error($GLOBALS["___mysqli_ston"]));
    $oldqty_jobcount = mysqli_fetch_array($old_jobs_cnt_res);
    // print_r($oldqty_jobcount)."<br/>";
    // if($oldqty_jobcount['old_jobs'] > 0)
    //     $oldqty_jobcount['old_jobs'] += 1;

    foreach($_POST['main_data'] as $iv){
        //$reason = explode('(',$iv['reasons'])[0];
        $cut = $iv['cut'];
        $destination = $iv['destination'];
        $dono = $iv['dono'];
        $ration = $iv['ratio'];
        $details = $iv['sizedetails'];
        $doc_type = 'N';
        $packing_mode = 1;
        $status = '';
		$i=1;
		$barcode_seq=1;
        $doc_no_ref = '';
		$temp_job=1;
        
        

        foreach ($details as $term ) {
            $job = $oldqty_jobcount['old_jobs']+$term['job_id'];    
			if(($job<>$temp_job) || $barcode_seq==1)
			{
				$i=1;
				$barcode_seq=0;
			}
            $rand=$schedule.date("ymd").$job;
            $carton_act_qty = $term['job_qty'];
            $size_code = $term['job_size'];
            $old_size = $term['job_size_key'];
            $type_of_sewing  = $term['type_of_sewing'];
            //echo $job."<br/>";
            $ins_qry =  "INSERT INTO `bai_pro3`.`pac_stat_log_input_job` 
            (
                doc_no, size_code, carton_act_qty,input_job_no, input_job_no_random,destination,packing_mode,old_size,doc_type,type_of_sewing,pac_seq_no,barcode_sequence,sref_id
            )
            VALUES
            ( 
                '".$dono."', 
                '".$size_code."', 
                '".$carton_act_qty."', 
                '".$job."', 
                '".$rand."',
                '".$destination."',
                '".$packing_mode."',
                '".$old_size."',
                '".$doc_type."',
                '".$type_of_sewing."',
                '-1',
    			$i,
                $inserted_id
            );
            ";
            $temp_job=$job;
            $i++;
            //echo  $ins_qry;
            // die();
            $result_time = mysqli_query($link, $ins_qry) or exit("Sql Error update downtime log".mysqli_error($GLOBALS["___mysqli_ston"]));
            $count++;
        }
        //echo $count;
        $update_query = "UPDATE `bai_pro3`.`sewing_jobs_ref` set bundles_count = $count where id = '$inserted_id' ";
        $update_result = mysqli_query($link,$update_query) or exit("Problem while inserting to sewing jos ref");

        insertMOQuantitiesSewing($schedule,$inserted_id);
    }

    echo json_encode(['message'=>'success']);

}else if(isset($_POST) && isset($_POST['del_recs'])){
    include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config_ajax.php');
    $doc_no = $_POST['del_recs'];
    // 217
    $validation_query="SELECT * FROM $bai_pro3.act_cut_status WHERE doc_no IN (".$doc_no.")"; 
    $sql_result=mysqli_query($link, $validation_query) or exit("Error while getting validation data"); 
    $count= mysqli_num_rows($sql_result); 
    if ($count>0) 
    {
        echo 'cutting_done';
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
        // echo $delete_plan_dashboard_qry."<br>"; 
        mysqli_query($link, $delete_plan_dashbrd_qry) or exit("Sql Error delete_plan_dashbrd_qry"); 
         
        $delete_plan_input_qry="DELETE FROM bai_pro3.`plan_dashboard_input` WHERE input_job_no_random_ref IN (SELECT input_job_no_random FROM $bai_pro3.`pac_stat_log_input_job` WHERE tid IN ($get_tids))"; 
        // echo $delete_plan_input_qry."<br>"; 
        mysqli_query($link, $delete_plan_input_qry) or exit("Sql Error delete_plan_input_qry");

        $qry = "DELETE FROM `bai_pro3`.`pac_stat_log_input_job` where doc_no IN (".$doc_no.") and pac_seq_no='-1'";
        $result_time2 = mysqli_query($link, $qry) or exit("Deleate jobs.".mysqli_error($GLOBALS["___mysqli_ston"]));
        
        $insert_log="INSERT INTO $bai_pro3.inputjob_delete_log (user_name,date_time,reason,SCHEDULE) VALUES (USER(),now(),'Cut job based','$get_order_del_no')"; 
        // echo $insert_log."</br>"; 
        mysqli_query($link, $insert_log) or exit("Sql Error insert_log");

        // MO Deletion start
            $sewing_cat = 'sewing';
            $op_code_query  ="SELECT group_concat(operation_code) as codes FROM $brandix_bts.tbl_orders_ops_ref 
                              WHERE trim(category) = '$sewing_cat' ";
            $op_code_result = mysqli_query($link, $op_code_query) or exit("No Operations Found for Sewing");
            while($row=mysqli_fetch_array($op_code_result)) 
            {
                $op_codes  = $row['codes']; 
            }

            $mo_query  = "SELECT GROUP_CONCAT(mo_no) as mos from $bai_pro3.mo_details where schedule = '$get_order_del_no'";
            $mo_result = mysqli_query($link,$mo_query);
            while($row = mysqli_fetch_array($mo_result))
            {
                $mos = $row['mos'];
            }

            $delete_query = "DELETE from $bai_pro3.mo_operation_quantites where ref_no in ($get_tids) and op_code in ($op_codes) ";
            $delete_result = mysqli_query($link,$delete_query);
        // MO Deletion end
        echo 'success';
    }
}else{
    ?>
    <script>
        $(document).ready(function(){
        	var url1 = '?r=<?= $_GET['r'] ?>';
            console.log(url1);
            $("#style").change(function(){
                //alert("The text has been changed.");
        		var optionSelected = $("option:selected", this);
               var valueSelected = this.value;
        	  window.location.href =url1+"&style="+valueSelected
            });
            $("#schedule").change(function(){
               // var input = $(this);
               //var val = input.val();
                // alert(val);
             //window.location.href =url1+"&schedule="+val;
             var optionSelected = $("option:selected", this);
               var valueSelected2 = this.value;
        	   var style1 = $("#style").val();
        	   window.location.href =url1+"&style="+style1+"&schedule="+valueSelected2
            });

            $("#color").change(function(){
                //alert("The text has been changed.");
        		var optionSelected = $("option:selected", this);
               var valueSelected3 = this.value;
               var style1 = $("#style").val();
               var schedule = $("#schedule").val();
               window.location.href =url1+"&style="+style1+"&schedule="+schedule+"&color="+valueSelected3
               //alert(valueSelected2); 
        	 //window.location.href =url1+"&style="+document.mini_order_report.style.value+"&schedule="+document.mini_order_report.schedule.value
            });

        });
    </script>
<div class = 'panel panel-primary'>
    <div class = 'panel-heading'><b>Cut Sewing Job Generation</b></div>
    <?php
        $style=$_GET['style'];
        $schedule=$_GET['schedule']; 
        $color  = $_GET['color'];
        include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config_ajax.php');
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
                    echo "<a class='btn btn-success pull-right' href='?r=L3NmY3NfYXBwL2FwcC9wcm9kdWN0aW9uL2NvbnRyb2xsZXJzL3Nld2luZ19qb2IvaW5wdXRfam9iX21peF9jaF9yZXBvcnQucGhw&schedule=".$schedule."&seq_no=-1&style=".$style."' id='print_labels'>Print Labels</a>";
                }
            echo "</div>
            <br/>";
    ?>
</div>
<?php
if($schedule != "" && $color != "")
{
    $ratio_query = "SELECT * FROM bai_pro3.bai_orders_db_confirm LEFT JOIN bai_pro3.cat_stat_log ON bai_orders_db_confirm.order_tid = cat_stat_log.order_tid LEFT JOIN bai_pro3.plandoc_stat_log ON cat_stat_log.tid = plandoc_stat_log.cat_ref WHERE cat_stat_log.category IN ('Body','Front') AND bai_orders_db_confirm.order_del_no='".$schedule."' AND TRIM(bai_orders_db_confirm.order_col_des) =trim('".$color."')";
  //echo $ratio_query;
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
                        <th>Ratio</th><th class='col-sm-2'>Cut No</th><th class='col-sm-2'>Plies</th>";
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
                <td>".implode(',',$old_pplice)."</td>";
                for($k=1;$k<=$max;$k++){
                    $sno = str_pad($k,2,"0",STR_PAD_LEFT);
                    echo "<td>$old_qty[$sno]</td>";
                    $old_qty[$sno]=0;
                }
                $qry_get_doc_details = "SELECT COUNT(*) AS old_jobs,pac_seq_no FROM bai_pro3.pac_stat_log_input_job WHERE doc_no IN (".implode(',',$old_doc_nos).")";
                $qry_get_doc_details_res = mysqli_query($link, $qry_get_doc_details) or exit("Sql Error : qry_get_doc_details".mysqli_error($GLOBALS["___mysqli_ston"]));
                $old_cnt_jb = mysqli_fetch_array($qry_get_doc_details_res);
                if($old_cnt_jb['old_jobs']==0)
                    echo "<td><button class='btn btn-info' data-toggle='modal' data-target='#modalLoginForm' onclick='assigndata($old_ratio,$max,$end)'>Generate Jobs</button></td>";
                elseif($old_cnt_jb['pac_seq_no']=='-1'){
                    $view_shows[] = implode(',',$old_doc_nos);
                    $imp_data = implode(',',$old_doc_nos);
                    echo "<td><a class='btn btn-warning' onclick='show_view_form(\"$imp_data\")'>View</a>"; 
                    if($old_cut_status=='')
                        echo "<a class='btn btn-danger' id='del-$imp_data' onclick='delet(\"$imp_data\")'>Delete</a>
                                <div id='delete_message_$imp_data' style='display:none'><h3 class='badge progress-bar-success'>Deleting...</h3></div>";
                    echo "</td>";
                }else{
                    echo "<td><h3 class='label label-warning'>Jobs Already Created with another source..</h3></td>";
                }
                echo "</tr>";
                $end = 1;
                $old_ratio = $row['ratio'];
                $old_pcut = [];
                $old_pplice = [];
                $old_doc_nos = [];
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
            }
            
            $max_cut = $row['pcutno'];
            $over_all_data[] = $raw;
        }
        echo "<tr>
            <td>".$old_ratio."</td>
            <td>".implode(",",$old_pcut)."</td>
            <td>".implode(',',$old_pplice)."</td>";
            for($k=1;$k<=$max;$k++){
                $sno = str_pad($k,2,"0",STR_PAD_LEFT);
                echo "<td>$old_qty[$sno]</td>";
            }
            $qry_get_doc_details = "SELECT COUNT(*) AS old_jobs,pac_seq_no FROM bai_pro3.pac_stat_log_input_job WHERE doc_no IN (".implode(',',$old_doc_nos).")";
            $qry_get_doc_details_res = mysqli_query($link, $qry_get_doc_details) or exit("Sql Error : qry_get_doc_details".mysqli_error($GLOBALS["___mysqli_ston"]));
            $old_cnt_jb = mysqli_fetch_array($qry_get_doc_details_res);
            if($old_cnt_jb['old_jobs']==0)
                echo "<td><button class='btn btn-info' data-toggle='modal' data-target='#modalLoginForm' onclick='assigndata($old_ratio,$max,$end)'>Generate Jobs</button></td>";
            elseif($old_cnt_jb['pac_seq_no']=='-1'){
                $view_shows[] = implode(',',$old_doc_nos);
                $imp_data = implode(',',$old_doc_nos);
                echo "<td><a class='btn btn-warning' onclick='show_view_form(\"$imp_data\")'>View</a>"; 
                if($old_cut_status=='')
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
                
                    <div class='row'>
                        <div class='col-sm-4'>
                            <label data-error="wrong" data-success="right" for="defaultForm-email">Garment per Sewing Job</label>
                            <input type="text" id="job-qty" class="form-control validate integer" ng-model= "jobcount" name="jobcount">
                        </div>
                        <div class='col-sm-4'>
                            <label data-error="wrong" data-success="right" for="defaultForm-email">Garment per Bundle</label>
                            <input type="text" id="bundle-qty" class="form-control validate integer" ng-model= "bundleqty" name="bundleqty">
                        </div>
                        <div class='col-sm-2'>
                            <br/><br/>
                            <button class="btn btn-success" ng-click="getjobs()">Confirm..</button>
                        </div>
                        <!--<div class='col-sm-2'>
                            <br/><br/>
                           <button class="btn btn-primary" ng-click="createjobs()">Confirm..</button>
                        </div>-->
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
                    <div ng-show='!jobs.length' class='alert alert-warning'>
                        Please generate jobs..
                    </div>

                    <div id="generate_message" class='alert alert-success' style="display: none">
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
app.controller('cutjobcontroller', function($scope, $http) {
    $scope.jobcount = 0;
    $scope.bundleqty = 0;
    $scope.details = [];
    $scope.details_all = [];
    $scope.jobs   = [];
    $scope.fulljob = [];
    $scope.maxcut = <?= $max_cut ?>;
    //$scope.last_r_first = <?= $ex_cut_lrt ?>;
    $scope.over_all_qtys_samps = <?= json_encode($over_all_qtys_samps) ?>;
    
    $scope.generatejobs = function(){
       if($scope.jobcount>0)
       {
           $scope.jobs   = [];
           $scope.balance = 0;
           $scope.excess = 0;
           $scope.j = 1;
        for(var i=0; i<$scope.details.length; i++)
        {
            if($scope.balance>0){
                if($scope.balance>$scope.details[i].value){
                    $scope.jobs.push({job_id : $scope.j,job_qty : $scope.details[i].value,job_size_key : $scope.details[i].key, job_size : $scope.details[i].title});
                    var quantity = 0;
                    $scope.balance = $scope.balance-$scope.details[i].value;
                    //console.log("z"+$scope.details[i].value);
                }else{
                    $scope.jobs.push({job_id : $scope.j,job_qty : $scope.balance,job_size_key : $scope.details[i].key, job_size : $scope.details[i].title});
                    var quantity = $scope.details[i].value-$scope.balance;
                    $scope.j++;
                    //console.log("a"+$scope.balance);
                    $scope.balance = 0;
                    
                    //console.log("a"+quantity);
                }
            }else{
                var quantity = $scope.details[i].value;
                $scope.balance = 0;
            }
            var total_jobs_per_size = Math.floor(quantity/$scope.jobcount);
            $scope.excess = quantity%$scope.jobcount;
            for(var pora=0;pora<Number(total_jobs_per_size);pora++){
                $scope.jobs.push({job_id : $scope.j,job_qty : $scope.jobcount,job_size_key : $scope.details[i].key, job_size : $scope.details[i].title});
                $scope.j++;
                //console.log("b"+$scope.jobcount);
            }
            if($scope.excess>0){
                $scope.jobs.push({job_id : $scope.j,job_qty : $scope.excess,job_size_key : $scope.details[i].key, job_size : $scope.details[i].title});
                $scope.balance = $scope.jobcount-$scope.excess;
                //console.log("c"+$scope.excess);
            }
        }
       }
       else
       {

       }
    }

    
    $scope.getjobs = function() {
        if(Number($scope.jobcount)>0 && Number($scope.jobcount)>=Number($scope.bundleqty)){
            $scope.fulljob = {};
            // console.log($scope.bundleqty);
            for(var ss=0;Number(ss)<$scope.details_all.length;ss++){
            //$scope.j++;
            var dummy = {};
            dummy['cut'] = $scope.details_all[ss].cut;
            dummy['ratio'] = $scope.details_all[ss].ratio;
            dummy['destination'] = $scope.details_all[ss].destination;
            dummy['dono'] = $scope.details_all[ss].dono;
            //console.log($scope.details_all[ss].size_details);
            $scope.details = $scope.details_all[ss].size_details;
            $("#generate_message").css("display", "block");
            $scope.generatejobs();
            var bun_jobs = $scope.genbundle($scope.jobs);
            var arrange_jobs = $scope.arrange_jobs(bun_jobs);
            dummy['sizedetails'] = arrange_jobs;
            $scope.fulljob[ss] = dummy;

            }
            //console.log($scope.fulljob);
            $scope.createjobs();
        }else{
            if(Number($scope.jobcount)<=0)
            swal('Sewing Job Quantity should be grater then zero.');
            if(Number($scope.jobcount)<Number($scope.bundleqty))
            swal('Bundle Quantity should be less then Sewing Job quantity.');
        }
    }

    $scope.arrange_jobs = function(bun_jobs){
        console.log(bun_jobs);
        var cons_ary = [];
        for(var i=0;i<$scope.details.length;i++){
            if($scope.details[i].value>0 && ($scope.details[i].sample>0 || $scope.details[i].excess>0)){
                cons_ary[$scope.details[i].title]= {sample : $scope.details[i].sample,excess:$scope.details[i].excess};
            }
        }
        var new_ary = [];
        for(j=bun_jobs.length-1;j>=0;j--){
            if(cons_ary[bun_jobs[j].job_size]){
                if(Number(cons_ary[bun_jobs[j].job_size].sample)>0 || Number(cons_ary[bun_jobs[j].job_size].excess)>0){
                    if(Number(cons_ary[bun_jobs[j].job_size].sample)<=Number(bun_jobs[j].job_qty)){
                        //====== sample-3 ===========
                        if(Number(cons_ary[bun_jobs[j].job_size].sample)>0 && Number(bun_jobs[j].job_qty)>0){
                            new_ary.push({job_id: bun_jobs[j].job_id,
                             job_qty: cons_ary[bun_jobs[j].job_size].sample, 
                             job_size_key: bun_jobs[j].job_size_key,
                             job_size: bun_jobs[j].job_size, 
                             bundle: bun_jobs[j].bundle,
                             type_of_sewing:3});

                            bun_jobs[j].job_qty = Number(bun_jobs[j].job_qty) - Number(cons_ary[bun_jobs[j].job_size].sample);
                            cons_ary[bun_jobs[j].job_size].sample = 0;
                        }
                    }else{
                        new_ary.push({job_id: bun_jobs[j].job_id,
                             job_qty: bun_jobs[j].job_qty, 
                             job_size_key: bun_jobs[j].job_size_key,
                             job_size: bun_jobs[j].job_size, 
                             bundle: bun_jobs[j].bundle,
                             type_of_sewing:3});

                        cons_ary[bun_jobs[j].job_size].sample = cons_ary[bun_jobs[j].job_size].sample-bun_jobs[j].job_qty;
                        bun_jobs[j].job_qty = 0;
                    }
                    if(Number(bun_jobs[j].job_qty)>0){
                        if(Number(cons_ary[bun_jobs[j].job_size].excess)<=Number(bun_jobs[j].job_qty)){
                        //=========== excess - 2 =============
                            if(Number(cons_ary[bun_jobs[j].job_size].excess)>0){
                                new_ary.push({job_id: bun_jobs[j].job_id,
                                    job_qty: cons_ary[bun_jobs[j].job_size].excess, 
                                    job_size_key: bun_jobs[j].job_size_key,
                                    job_size: bun_jobs[j].job_size, 
                                    bundle: bun_jobs[j].bundle,
                                    type_of_sewing:2});

                                bun_jobs[j].job_qty = Number(bun_jobs[j].job_qty) - Number(cons_ary[bun_jobs[j].job_size].excess);
                                cons_ary[bun_jobs[j].job_size].excess = 0;
                            }
                        }else{
                            new_ary.push({job_id: bun_jobs[j].job_id,
                                job_qty: bun_jobs[j].job_qty, 
                                job_size_key: bun_jobs[j].job_size_key,
                                job_size: bun_jobs[j].job_size, 
                                bundle: bun_jobs[j].bundle,
                                type_of_sewing:2});
                                
                            cons_ary[bun_jobs[j].job_size].excess = cons_ary[bun_jobs[j].job_size].excess-bun_jobs[j].job_qty;
                            bun_jobs[j].job_qty = 0;
                        }
                    }
                    if(Number(bun_jobs[j].job_qty)>0){
                        new_ary.push({job_id: bun_jobs[j].job_id,
                             job_qty: bun_jobs[j].job_qty, 
                             job_size_key: bun_jobs[j].job_size_key,
                             job_size: bun_jobs[j].job_size, 
                             bundle: bun_jobs[j].bundle,
                             type_of_sewing:1});
                    }


                }else{
                    if(bun_jobs[j].job_qty>0){
                        bun_jobs[j].type_of_sewing = 1;
                        new_ary.push(bun_jobs[j]);
                    }
                }
            }else{
                if(bun_jobs[j].job_qty>0){
                    bun_jobs[j].type_of_sewing = 1;
                    new_ary.push(bun_jobs[j]);
                }
            }
        }

        //console.log(new_ary);
        return new_ary.sort(function(a, b) {
    return Number(a.bundle) - Number(b.bundle);  
});
    }

    $scope.createjobs = function()
    {
        //console.log($scope.fulljob);
       // alert('hi');
       console.log($scope.bundleqty);
        let url_serv = "<?= trim($url) ?>";
        let style = "<?= $style ?>";
        let schedule = "<?= $schedule ?>";
        let color = "<?= $color ?>";
        let docnos = "<?= $docnos ?>";
        //console.log(url_serv);
        // var rv = {};
        // for (var i = 0; i < $scope.fulljob.length; ++i){
        //     rv1 = {}
        //     if ($scope.fulljob[i] !== undefined) rv[i] = JSON.stringify($scope.fulljob[i]);
            
        // }
        //console.log(rv);
        var params = $.param({
        'main_data' : $scope.fulljob, 'style' : style, 'schedule' : schedule, 'color' : color,'docnos' : docnos
        });
        
            //$scope.saveinit = false;
            $http({ 
                method: 'POST', 
                url: url_serv,
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'
                },
                data: params
            })
            .then(function successCallback(response) {
                console.log(response.data);
                if(response.data.message=='success'){
                    swal('Cut Sewing jobs generated successfully');
                    location.reload();
                }else{
                    swal('Fail..');
                }
            });
    }
    
    $scope.genbundle = function(jobs){
        let newdummy = [];
        if($scope.bundleqty==0){
            for(let no=0;no<jobs.length;no++){
                newdummy.push({job_id : jobs[no].job_id,job_qty : jobs[no].job_qty,job_size_key : jobs[no].job_size_key, job_size : jobs[no].job_size,bundle : Number(no)+1});
            }
        }else{
            let jobno = 1;
            for(let no=0;no<jobs.length;no++){
                let total_bundles_per_job = Math.floor(jobs[no].job_qty/$scope.bundleqty);
                let excess = jobs[no].job_qty%$scope.bundleqty;
                for(let non=0;non<Number(total_bundles_per_job);non++){
                    newdummy.push({job_id : jobs[no].job_id,job_qty : $scope.bundleqty,job_size_key : jobs[no].job_size_key, job_size : jobs[no].job_size,bundle : jobno});
                    jobno++;
                }
                if(excess>0){
                    newdummy.push({job_id : jobs[no].job_id,job_qty : excess,job_size_key : jobs[no].job_size_key, job_size : jobs[no].job_size,bundle : jobno});
                    jobno++;
                }
            }
        }
        return newdummy;
    }

});
angular.bootstrap($('#modalLoginForm'), ['cutjob']);
function assigndata(s,max,end){
    var details = [];
    for(var jpg=1;Number(jpg)<Number(end);jpg++){
        var dummy = [];
        var pl_cut_id = document.getElementById('datarc'+s+jpg);
        dummy['cut'] = pl_cut_id.getAttribute('data-cut');
        dummy['ratio'] = pl_cut_id.getAttribute('data-ratio');
        dummy['destination'] = pl_cut_id.getAttribute('data-destination');
        dummy['dono'] = pl_cut_id.getAttribute('data-dono');
        dummy['size_details'] = [];
        for(var i=1;Number(i)<=Number(max);i++){
            var sp_title = document.getElementById('datatitle'+i);
            var sp_values = document.getElementById('dataval'+s+i+jpg);
            a = sp_title.getAttribute('data-title');
            b = sp_values.getAttribute('data-title');

            c = sp_title.getAttribute('data-value');
            d = sp_values.getAttribute('data-value');

            e=sp_values.getAttribute('data-sample');
            f=sp_values.getAttribute('data-excess');
            var val = {title : c, key : a, value : d, sample : e, excess : f};
            dummy['size_details'].push(val);
        }
        details.push(dummy);
    }
    var controllerElement = document.querySelector('[ng-controller="cutjobcontroller"]');
    var scope = angular.element(controllerElement).scope();
    scope.$apply(function () {
        scope.details_all = details;
        scope.jobcount = 0;
        scope.bundleqty = 0;
        scope.details = [];
        scope.jobs   = [];
        scope.fulljob = [];
    });
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
    
        if(data=='cutting_done'){
            swal('Cutting Already Done for this Docket','Cannot Delete Sewing Jobs','error');
            setTimeout(function(){ location.reload(); }, 300);
        }else if(data=='success'){
            swal('Jobs Deleted successfully.');
            setTimeout(function(){ location.reload(); }, 300);
        }else{
            swal('Jobs Deletion Failed.');
            setTimeout(function(){ location.reload(); }, 300);
        }
    });

}
</script>
<style>
#print_labels{
    display:none;
}
</style>
<?php } ?>