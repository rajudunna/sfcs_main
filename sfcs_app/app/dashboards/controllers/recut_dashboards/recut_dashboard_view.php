<?php
    include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config_ajax.php');
    if(isset($_POST['formSubmit']))
    {
        include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/mo_filling.php');
        $ids=$_POST['ids'];
        $recutval = $_POST['recutval'];
        $cat = $_POST['cat'];
        $bcd_id = $_POST['bcd_ids'];
        $size = $_POST['size'];
        $sizes_val_array = array();
        $sizes = '';
        $values = '';
        $sizes_a = '';
        $bcd = $bcd_id[0];
        //retreaving style,schedule,color and size wise cumulative quantities to store in plan_doc_stat_log and recut_v2
        $qry_details = "SELECT style,SCHEDULE,color FROM `bai_pro3`.`rejections_log` r LEFT JOIN `bai_pro3`.`rejection_log_child` rc ON rc.`parent_id` = r.`id` 
        WHERE rc.`bcd_id` in ($bcd)";
        $qry_details_res = $link->query($qry_details);
        while($row_row = $qry_details_res->fetch_assoc()) 
        {
            $style = $row_row['style'];
            $scheule = $row_row['SCHEDULE'];
            $color = $row_row['color'];
        }
        //getting order tid
        $qry_order_tid = "SELECT order_tid FROM `bai_pro3`.`bai_orders_db` WHERE order_style_no = '$style' AND order_del_no ='$scheule' AND order_col_des = '$color'";
        $res_qry_order_tid = $link->query($qry_order_tid);
        while($row_row_row = $res_qry_order_tid->fetch_assoc()) 
        {
            $order_tid = $row_row_row['order_tid'];
        }
        $recutval_sizes = array();
        foreach($recutval as $key=>$value)
        {
            $size_act = $size[$key];
            $recutval_sizes[$size_act][] = $recutval[$key];
        }
        foreach($recutval_sizes as $key=>$value)
        {
            foreach($value as $val)
            {
                $sizes_val_array[$key] += $val;
            }
        }
        // var_dump($sizes_val_array);
        foreach($sizes_val_array as $key=>$value)
        {
            $sizes .= 'p_'.$key.',';
            $sizes_a .= 'a_'.$key.',';
            $values .= $value.','; 
        }
        $sizes_p = rtrim($sizes,",");
        $sizes_a = rtrim($sizes_a,",");
        $values = rtrim($values,",");
        //getting cat stat log
        $date=date("Y-m-d", mktime(0,0,0,date("m") ,date("d"),date("Y")));
        foreach($cat as $key=>$value)
        {
            $qry_to_get = "SELECT * FROM  `bai_pro3`.`cat_stat_log` WHERE  order_tid = \"$order_tid\" and category = '$value'";
            // echo $qry_to_get.'</br>';
            $res_qry_to_get = $link->query($qry_to_get);
            while($row_cat_ref = $res_qry_to_get->fetch_assoc()) 
            {
                $cat_ref =$row_cat_ref['tid'];

            }
            $sql2="select count(pcutdocid) as \"count\" from $bai_pro3.plandoc_stat_log where order_tid=\"$order_tid\" and cat_ref=$cat_ref";
            mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
            $sql_result2=mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));

            while($sql_row2=mysqli_fetch_array($sql_result2))
            {
                $count=$sql_row2['count'];
            }

            if($count==NULL)
            {
                $count=0;
            }
            $sql="select * from $bai_pro3.allocate_stat_log where order_tid=\"$order_tid\" and cat_ref=$cat_ref and mk_status!=9 ORDER BY tid DESC LIMIT 0,1";
            $sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
            // var_dump($sql_result);
            while($sql_row=mysqli_fetch_array($sql_result))
            {
                $cuttable_ref=$sql_row['cuttable_ref'];
                $allocate_ref = $sql_row['tid'];
                $ratio  = $sql_row['ratio'];
            }
            $mk_ref = '0';
            $ratio = 1;
            $pliespercut = 1;
            $remarks = 'Recut';
            $pcutdocid=$order_tid."/".$allocate_ref."/".$count;
            $sql_plandoc="insert into $bai_pro3.plandoc_stat_log(pcutdocid, date, cat_ref, cuttable_ref, allocate_ref, mk_ref, order_tid, pcutno, ratio,a_plies,p_plies,remarks,$sizes_p,$sizes_a)values  (\"$pcutdocid\", \"$date\", $cat_ref, $cuttable_ref, $allocate_ref, $mk_ref, \"$order_tid\", $count, $ratio,$pliespercut,$pliespercut,\"$remarks\",$values,$values)";
            // echo $sql_plandoc;
            mysqli_query($link,$sql_plandoc) or exit("While inserting into the plan doc stat log".mysqli_error($GLOBALS["___mysqli_ston"]));
           $insert_id=mysqli_insert_id($link);
            $sql_recut_v2="insert into $bai_pro3.recut_v2 (date,cat_ref,order_tid,pcutno,acutno,remarks,$sizes_p,$sizes_a,a_plies,p_plies,doc_no) values (\"".date("Y-m-d")."\",".$cat_ref.",\"$order_tid\",$count,$count,\"".$value."\",$values,$values,$pliespercut,$pliespercut,$insert_id)";
            mysqli_query($link,$sql_recut_v2) or exit("While inserting into the recut v2".mysqli_error($GLOBALS["___mysqli_ston"]));
             // calling the function to insert to bundle craetion data and cps log
            $inserted = doc_size_wise_bundle_insertion($insert_id,1);
            if($inserted){
                //Inserted Successfully
            }
        }
        foreach($bcd_id as $key=>$act_id)
        {
            $recut_allowing_qty = $recutval[$key];
            if($recut_allowing_qty > 0)
            {
                $retreaving_bcd_data = "SELECT * FROM `brandix_bts`.`bundle_creation_data` WHERE id IN ($act_id) ORDER BY barcode_sequence";
                $retreaving_bcd_data_res = $link->query($retreaving_bcd_data);
                while($row_bcd = $retreaving_bcd_data_res->fetch_assoc()) 
                {
                    $bcd_act_id = $row_bcd['id'];
                    $bundle_number = $row_bcd['bundle_number'];
                    $operation_id = $row_bcd['operation_id'];
                    $size_id = $row_bcd['size_id'];
                    $retreaving_rej_qty = "SELECT * FROM `bai_pro3`.`rejection_log_child` where bcd_id = $bcd_act_id";
                    $retreaving_rej_qty_res = $link->query($retreaving_rej_qty);
                    while($child_details = $retreaving_rej_qty_res->fetch_assoc()) 
                    {
                        $actual_allowing_to_recut = $child_details['rejected_qty']-($child_details['recut_qty']+$child_details['replaced_qty']);
                    }
                    if($actual_allowing_to_recut < $recut_allowing_qty)
                    {
                        $to_add = $actual_allowing_to_recut;
                        $recut_allowing_qty = $recut_allowing_qty - $actual_allowing_to_recut;
                    }
                    else
                    {
                        $to_add = $recut_allowing_qty;
                        $recut_allowing_qty = 0;
                    }
                    if($to_add > 0)
                    {
                        $inserting_into_recut_v2_child = "INSERT INTO `bai_pro3`.`recut_v2_child` (`parent_id`,`bcd_id`,`operation_id`,`rejected_qty`,`recut_qty`,`recut_reported_qty`,`issued_qty`,`size_id`)
                        VALUES($insert_id,$bcd_act_id,$operation_id,$actual_allowing_to_recut,$to_add,0,0,'$size_id')";
                        mysqli_query($link,$inserting_into_recut_v2_child) or exit("While inserting into the recut v2 child".mysqli_error($GLOBALS["___mysqli_ston"]));
                        //retreaving bundle_number of recut docket from bcd and inserting into moq
                        $retreaving_qry="select bundle_number from $brandix_bts.bundle_creation_data where docket_number='$insert_id' and operation_id ='15'";
                        $retreaving_qry_res = $link->query($retreaving_qry);
                        while($row_bcd_recut = $retreaving_qry_res->fetch_assoc()) 
                        {
                            $bundle_number_recut = $row_bcd_recut['bundle_number'];
                        }
                        //retreaving mo_number which is related to that bcd_act_id
                        $moq_qry = "select mo_no,bundle_quantity,rejected_qty from $bai_pro3.mo_operation_quantities where ref_no=$bundle_number and op_code=$operation_id and rejected_qty>0 order by mo_no";
                        $moq_qry_res = $link->query($moq_qry);
                        $multiple_mos_tot_qty = $to_add;
                        while($row_moq = $moq_qry_res->fetch_assoc()) 
                        {
                            $max_mo_no = $row_moq['mo_no'];
                            $bundle_quantity_mo = $row_moq['rejected_qty'] - $array_mos[$max_mo_no];
                            if($bundle_quantity_mo < $multiple_mos_tot_qty)
                            {
                                $multiple_mos_tot_qty = $multiple_mos_tot_qty - $bundle_quantity_mo;
                                $to_add_mo = $bundle_quantity_mo;
                                $array_mos[$max_mo_no]  = $bundle_quantity_mo;
                            }
                            else
                            {
                                $to_add_mo = $multiple_mos_tot_qty;
                                $array_mos[$max_mo_no]  = $multiple_mos_tot_qty;
                                $to_add_mo = 0;
                            }
                            if($to_add_mo > 0)
                            {
                                $checking_moq_qry = "select id from $bai_pro3.mo_operation_quantities where ref_no = $bundle_number_recut and operation_id = 15";
                                $checking_moq_qry_res = $link->query($checking_moq_qry);
                                if(mysqli_num_rows($checking_moq_qry_res) > 0)
                                {
                                    //update qry
                                    while($row_moq_bcd = $checking_moq_qry_res->fetch_assoc()) 
                                    {
                                        $id_moq = $row_moq_bcd['id'];
                                    }
                                    $updae_moq_qry = "update $bai_pro3.mo_operation_quantities set bundle_quantity = bundle_quantity+$to_add_mo where id=$id_moq";
                                }
                                else
                                {
                                    //insert qry
                                    $updae_moq_qry="INSERT INTO $bai_pro3.`mo_operation_quantites` (`date_time`, `mo_no`, `ref_no`, `bundle_quantity`, `op_code`, `op_desc`) VALUES ('".date("Y-m-d H:i:s")."', '".$max_mo_no."', '".$bundle_number_recut."','".$to_add_mo."', '15', 'Cutting')";
                                }
                                mysqli_query($link,$updae_moq_qry) or exit("Whille inserting recut to moq".mysqli_error($GLOBALS["___mysqli_ston"]));
                            }
                        }
                        $update_rejection_log_child = "update $bai_pro3.rejection_log_child set recut_qty = recut_qty+$to_add where bcd_id = $bcd_act_id";
                        mysqli_query($link,$update_rejection_log_child) or exit("While updating rejection log child".mysqli_error($GLOBALS["___mysqli_ston"]));
        
                        $update_rejection_log = "update $bai_pro3.rejections_log set recut_qty = recut_qty+$to_add,remaining_qty = remaining_qty - $to_add where style = '$style' and schedule = '$scheule' and color = '$color'";
                        mysqli_query($link,$update_rejection_log) or exit("While updating rejection log".mysqli_error($GLOBALS["___mysqli_ston"]));
                    }
                }

            }
        }
        $url = '?r='.$_GET['r'];
        echo "<script>sweetAlert('Recut Successfully Raised','','success');window.location = '".$url."'</script>";   
    }
    if(isset($_POST['formSubmit1']))
    {
        include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/app/dashboards/controllers/recut_dashboards/recut_dashboard_issue.php');
        $replace_val = $_POST['replaceval'];
        $input_job_no_random_ref_replace = $_POST['input_job_no_random_ref_replace'];
        $bcd_id = $_POST['bcd_ids'];
        $replaced_qty = $_POST['replaceval'];
        $size = $_POST['size'];
        $operation_id = $_POST['operation_id'];
        $bcd = $bcd_id[0];
        $qry_details = "SELECT style,SCHEDULE,color FROM `bai_pro3`.`rejections_log` r LEFT JOIN `bai_pro3`.`rejection_log_child` rc ON rc.`parent_id` = r.`id` 
        WHERE rc.`bcd_id` in ($bcd)";
        $qry_details_res = $link->query($qry_details);
        while($row_row = $qry_details_res->fetch_assoc()) 
        {
            $style = $row_row['style'];
            $scheule = $row_row['SCHEDULE'];
            $color = $row_row['color'];
        }
        foreach($bcd_id as $key=>$value)
        {
            $recut_allowing_qty = $replaced_qty[$key];
            $act_id = $bcd_id[$key];
            if($replaced_qty[$key] > 0)
            {
                $retreaving_bcd_data = "SELECT bundle_number,id,operation_id,size_title FROM `brandix_bts`.`bundle_creation_data` WHERE id IN ($act_id) ORDER BY barcode_sequence";
                $retreaving_bcd_data_res = $link->query($retreaving_bcd_data);
                while($row_bcd = $retreaving_bcd_data_res->fetch_assoc()) 
                {
                    $bcd_individual = $row_bcd['bundle_number'];
                    $bundle_number = $row_bcd['id'];
                    $operation_id = $row_bcd['operation_id'];
                    $size_title = $row_bcd['size_title'];
                    $retreaving_rej_qty = "SELECT * FROM `bai_pro3`.`rejection_log_child` where bcd_id = $bundle_number";
                    $retreaving_rej_qty_res = $link->query($retreaving_rej_qty);
                    while($child_details = $retreaving_rej_qty_res->fetch_assoc()) 
                    {
                        $actual_allowing_to_recut = $child_details['rejected_qty']-($child_details['recut_qty']+$child_details['replaced_qty']);
                    }
                    if($actual_allowing_to_recut < $recut_allowing_qty)
                    {
                        $to_add = $actual_allowing_to_recut;
                        $recut_allowing_qty = $recut_allowing_qty - $actual_allowing_to_recut;
                    }
                    else
                    {
                        $to_add = $recut_allowing_qty;
                        $recut_allowing_qty = 0;
                    }
                    if($to_add > 0)
                    {
                        //retreaving input jobs which are related to this size 
                        $input_job_expo = $input_job_no_random_ref_replace[$size[$key]];
                        $input_job_expo_after = explode(',',$input_job_expo);
                        foreach($input_job_expo_after as $sj)
                        {
                            $excess_job_qry = "SELECT input_job_no_random AS input_job_no_random_ref,SUM(carton_act_qty)as excess_qty FROM `bai_pro3`.`packing_summary_input` WHERE input_job_no_random='$sj' and size_code = '$size[$key]' AND type_of_sewing = 2";
                            $result_excess_job_qry = $link->query($excess_job_qry);
                            if($result_excess_job_qry->num_rows > 0)
                            {
                                while($replace_row = $result_excess_job_qry->fetch_assoc()) 
                                {
        
                                    $input_job_no_excess = $replace_row['input_job_no_random_ref'];
                                    $exces_qty =$replace_row['excess_qty'];
                                }
                                //checking that inputjob already scanned or not
                                $rec_qty = 0;
                                $already_replaced_qty = 0;
                                $bcd_checking_qry = "select sum(recevied_qty)as rec_qty from $brandix_bts.bundle_creation_data where input_job_no_random_ref in ($input_job_no_excess) and size_id = '$size[$key]' and operation_id = '$input_ops_code'";
                                $result_bcd_checking_qry = $link->query($bcd_checking_qry);
                                if($result_bcd_checking_qry->num_rows > 0)
                                {
                                    while($bcd_row_rec = $result_bcd_checking_qry->fetch_assoc()) 
                                    {
                                        $rec_qty = $bcd_row_rec['rec_qty'];
                                    }
                                }
                                //checking the input job already replaced or not
                                $checking_replaced_or_not = "SELECT SUM(`replaced_qty`) AS replaced_qty FROM `$bai_pro3`.`rejection_log_child` WHERE 
                                replaced_sewing_job_no_random_ref IN ($input_job_no_excess)";
                                $result_checking_replaced_or_not = $link->query($checking_replaced_or_not);
                                if($result_checking_replaced_or_not->num_rows > 0)
                                {
                                    while($row_replace_already = $result_checking_replaced_or_not->fetch_assoc()) 
                                    {
                                        $already_replaced_qty = $row_replace_already['replaced_qty'];
                                    }
                                }
                                $already_replaced_with_sj = array_sum($replacing_input_job_with_qty[$sj]);
                                $exces_qty = $exces_qty - ($rec_qty + $already_replaced_qty+$already_replaced_with_sj);
                            }
                            if($exces_qty > 0)
                            {
                                if($to_add > $exces_qty)
                                {
                                    $replacing_input_job_with_qty[$sj][] = $exces_qty;
                                    $to_add = $to_add - $exces_qty;
                                    $to_add_sj = $exces_qty;
                                }
                                else
                                {
                                    $replacing_input_job_with_qty[$sj][] = $to_add;
                                    $to_add_sj = $to_add;
                                    $to_add = 0;   
                                }
                                if($to_add_sj > 0)
                                {
                                    $insertion_qry = "INSERT INTO `$bai_pro3`.`replacment_allocation_log` (`bcd_id`,`input_job_no_random_ref`,`replaced_qty`,`size_title`) values ($bundle_number,$sj,$to_add_sj,'$size_title')";
                                    // echo $insertion_qry.'</br>';
                                    mysqli_query($link, $insertion_qry) or exit("insertion_qry".mysqli_error($GLOBALS["___mysqli_ston"]));

                                    $updating_rejection_log_child = "update $bai_pro3.rejection_log_child set replaced_qty = replaced_qty+$to_add_sj where bcd_id = $bundle_number";
                                    mysqli_query($link, $updating_rejection_log_child) or exit("updating_rejection_log_child".mysqli_error($GLOBALS["___mysqli_ston"]));
                                    //updating rejection log 
                                    $updating_rejection_log = "update $bai_pro3.rejections_log set replaced_qty = replaced_qty+$to_add_sj,remaining_qty = remaining_qty-$to_add_sj where style = '$style' and schedule = '$scheule' and color = '$color' ";
                                    mysqli_query($link, $updating_rejection_log) or exit("updating_rejection_log".mysqli_error($GLOBALS["___mysqli_ston"]));

                                    $issued_to_module = issued_to_module($bundle_number,$to_add_sj,1);
                                }
                            }
                        }
                    }
                }
               
            }
        }
        $url = '?r='.$_GET['r'];
        echo "<script>sweetAlert('Replacement Done Successfully!!!','','success');window.location = '".$url."'</script>"; 
    }
    $shifts_array = ["IssueDone","RecutPending"];
    $drp_down = '<div class="row"><div class="col-md-3"><label>Status Filter:</label>
    <select class="form-control rm"  name="status" id="rm" style="width:100%;" onchange="myFunction()" required>';
    for ($i=0; $i <= 1; $i++) 
    {
        $drp_down .= '<option value='.$shifts_array[$i].'>'.$shifts_array[$i].'</option>';
    }
    $drp_down .= "</select></div>";
    $drp_down .= "<div class='col-md-3'><label>Schedule Filter:</label>
                  <input class='form-control integer' placeholder='Enter Schedule here' onchange='myfunctionsearch()' id='schedule_id'></input></div></div>";
    echo $drp_down;
    
?>
</br></br></br>
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog" style="width: 80%;">
        <div class="modal-content">
            <div class="modal-header">Recut Detailed View
                <button type="button" class="close"  id = "cancel" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body" id='main-content'>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="myModal1" role="dialog">
    <div class="modal-dialog" style="width: 80%;  height: 100%;">
        <div class="modal-content">
            <div class="modal-header">Recut Raise form
                <button type="button" class="close"  id = "cancel" data-dismiss="modal">&times;</button>
            </div>
            <div id='pre_pre'>
                <div class="modal-body">
                    <form action="index.php?r=<?php echo $_GET['r']?>" name= "smartform" method="post" id="smartform" onsubmit='return validationfunction();'>
                        <div class='panel-body' id="dynamic_table_panel">	
                                <div id ="dynamic_table1"></div>
                        </div>
                        <div class="pull-right"><input type="submit" id='recut' class="btn btn-primary" value="Submit" name="formSubmit"></div>
                    </form>
                </div>
            </div>
            <div id='post_post'>
                <div class='panel-body'>	
                        <h2 style='color:red'>Please wait while Raising the Recut!!!</h2>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="myModal2" role="dialog">
    <div class="modal-dialog" style="width: 80%;  height: 100%;">
        <div class="modal-content">
            <div class="modal-header">Rejection Replace form
                <button type="button" class="close"  id = "cancel" data-dismiss="modal">&times;</button>
            </div>
            <div id='pre'>
                <div class="modal-body">
                    <div class="ajax-loader" id="loading-image" style="margin-left: 45%;margin-top: 35px;border-radius: -80px;width: 88px;">
                                <img src='<?= getFullURLLevel($_GET['r'],'ajax-loader.gif',0,'R'); ?>' class="img-responsive" />
                    </div>
                    <form action="index.php?r=<?php echo $_GET['r']?>" name= "smartformreplace" method="post" id="smartform1" onsubmit='return validationreplace();'>
                        <div class='panel-body' id="dynamic_table_panel">	
                            <div id ="dynamic_table2"></div>
                        </div>
                    </form>
                </div>
            </div>
            <div id='post'>
                <div class='panel-body'>	
                        <h2 style='color:red'>Please wait while Replacing!!!</h2>
                </div>
            </div>
        </div>
    </div>
</div>
<div class='row'>
    <div class='panel panel-primary'>
        <div class='panel-heading'>
            <b>RECUT DASHBOARD - View</b>
        </div>
        <div class='panel-body'>
           <table class = 'col-sm-12 table-bordered table-striped table-condensed' id='myTable'><thead><th>S.No</th><th>Style</th><th>Schedule</th><th>Color</th><th>Rejected quantity</th><th>Recut Allowed Quantity</th><th>Replaced Quantity</th><th>Eligibility to allow recut</th><th>View</th><th>Recut</th><th>Replace</th>
            </thead>
            <?php  
            $s_no = 1;
            $blocks_query  = "SELECT r.id,style,SCHEDULE,color,r.rejected_qty,r.recut_qty,r.remaining_qty,r.replaced_qty,GROUP_CONCAT(DISTINCT bcd_id)as bcd_ids FROM bai_pro3.rejections_log r
            LEFT JOIN `bai_pro3`.`rejection_log_child` rc ON rc.`parent_id` = r.`id`
            GROUP BY r.`style`,r.`schedule`,r.`color`";
            $blocks_result = mysqli_query($link,$blocks_query) or exit('Rejections Log Data Retreival Error');
            if($blocks_result->num_rows > 0)
            {
                while($row = mysqli_fetch_array($blocks_result))
                {
                    $id = $row['id'];
                    if($row['remaining_qty'] == 0)
                    {
                        $button_html_recut = "<b style='color:red;'>Issue Done!!!</b>";
                        $url6 = getFullURLLevel($_GET['r'],'replace_recut_bundle_print.php',0,'R');
                        $url7 = getFullURLLevel($_GET['r'],'barcode_with_operations.php',0,'R');
                        $ij = $row['bcd_ids'];
                        $schedule =$row['SCHEDULE'];
                        $button_html_replace = "<a class='btn btn-info btn-sm' href='$url6?input_job=".$ij."&schedule=".$schedule."' onclick=\"return popitup2('$url6?input_job=".$ij."&schedule=".$schedule."')\" target='_blank'><i class=\"fa fa-print\" aria-hidden=\"true\"></i>&nbsp;&nbsp;&nbsp;Bundle Barcode</a>";
                        $button_html_replace .= "<a class='btn btn-info btn-sm' href='$url7?input_job=".$ij."&schedule=".$schedule."' onclick=\"return popitup2('$url7?input_job=".$ij."&schedule=".$schedule."')\" target='_blank'><i class=\"fa fa-print\" aria-hidden=\"true\"></i>&nbsp;&nbsp;&nbsp;Bundle Barcode with operations</a>";
                        $html_hiding = "IssueDone";
                    }
                    else if($row['remaining_qty'] != 0 && $row['rejected_qty'] > 0)
                    {
                        $button_html_recut = "<button type='button'class='btn btn-danger' onclick='editrecutdetails(".$id.")'>Recut</button>";
                        $button_html_replace = "<button type='button'class='btn btn-success' onclick='editreplacedetails(".$id.")'>Replace</button>";
                        $html_hiding = "RecutPending";
                    }
                    echo "<tr><td>$s_no</td>";
                    echo "<td>".$row['style']."</td>";
                    echo "<td>".$row['SCHEDULE']."</td>";
                    echo "<td>".$row['color']."</td>";
                    echo "<td>".$row['rejected_qty']."</td>";
                    echo "<td>".$row['recut_qty']."</td>";
                    echo "<td>".$row['replaced_qty']."</td>";
                    echo "<td>".$row['remaining_qty']."</td>";
                    echo "<td><button type='button'class='btn btn-primary' onclick='viewrecutdetails(".$id.")'>View</button></td>";
                    echo "<td>$button_html_recut</td>";
                    echo "<td style='display:none'>$html_hiding</td>"; 
                    echo "<td>$button_html_replace</td>"; 
                    echo "</tr>";
                    $s_no++;
                }                
            }
            else
            {
                echo "<tr><td colspan='12' style='color:red;text-align: center;'><b>No Details Found!!!</b></td></tr>";
            }
            ?> 
             </table>
             <div id='myTable1'>
                <b style='color:red'>No Records Found</b>
             </div>
        </div>
    </div>
</div>
<style>
    .container{
        border : 1px solid #e5e5e5;
        border-radius : 3px;
        min-height : 500px;
    }
    .block{
        color  : #000;
        background : #fff;
        padding : 22px;
        font-size : 16px; 
    }
    .inner-block{
        height : 120px;
        border : 1px solid #3c3c3c;
        border-radius : 5px;
        padding : 15px;
    }
    .label{
        color : #2D2D2D;
        font-size : 15px;
    }
    d{
        font-size : 15px;
    }
    .blue{
        background : #0D8F79;
    }

    @-webkit-keyframes blinker {
        from { opacity: 1.0; }
        to { opacity: 0.0; }
    }
    .blink{
        text-decoration: blink;
        -webkit-animation-name: blinker;
        -webkit-animation-duration: 0.5s;
        -webkit-animation-iteration-count:infinite;
        -webkit-animation-timing-function:ease-in-out;
        -webkit-animation-direction: alternate;
    }
    .modal{
        width : auto;
    }
    .modal-body{
	    max-height: calc(100vh - 200px);
	    overflow-y: auto;
	}
	.modal{
	 	opacity : 0.1;
	}
	.modal-header{
		background : #0D8DE2;
		color : #fff;
	}
    .modal-lg{
        width : 1200px;
    }
    .modal-content{
        height : 650px;
    }
    .modal-body{
        height : 600px;
    }
    .block a{
        color : #fff;
        padding : 15px;
        height : 100px;
        font-weight : bold;
    }
    a:hover{
        cursor : pointer;
        text-decoration : none;
    }
    v{
        color : #fff;
        text-align : left; 
        display : block;
        font-size : 12px;
    }
    c{
        color : #FFFF55;
        text-align : left;   
    }

    //Tool tip break
    .tooltip{
        width : 150px;
    }
    .tooltip-inner {
        max-width: 300px;
        white-space: nowrap;
        margin:0;
        padding:5px;
    }
</style>


<script>
function viewrecutdetails(id)
{
    var function_text = "<?php echo getFullURL($_GET['r'],'functions_recut.php','R'); ?>";
    $('#myModal').modal('toggle');
    $('#loading-image').show();
    $.ajax({

			type: "POST",
			url: function_text+"?recut_id="+id,
			//dataType: "json",
			success: function (response) 
			{
                document.getElementById('main-content').innerHTML = response;
                $('#loading-image').hide();
            }

    });
}
function editrecutdetails(id)
{
    var function_text = "<?php echo getFullURL($_GET['r'],'functions_recut.php','R'); ?>";
    $('#myModal1').modal('toggle');
    document.getElementById('dynamic_table2').innerHTML = '';
    document.getElementById('dynamic_table1').innerHTML = '';
    $('#post_post').hide();
    $('#pre_pre').show();
    $('#loading-image').show();
    $.ajax({

			type: "POST",
			url: function_text+"?recut_id_edit="+id,
			//dataType: "json",
			success: function (response) 
			{
                document.getElementById('dynamic_table1').innerHTML = response;
                $('#loading-image').hide();
            }

    });
}
function editreplacedetails(id)
{
    var function_text = "<?php echo getFullURL($_GET['r'],'functions_recut.php','R'); ?>";
    $('#myModal2').modal('toggle');
    $('#loading-image').show();
    $('#post').hide();
    $('#pre').show();
    document.getElementById('dynamic_table2').innerHTML = '';
    document.getElementById('dynamic_table1').innerHTML = '';
    $.ajax({

			type: "POST",
			url: function_text+"?replace_id_edit="+id,
			//dataType: "json",
			success: function (response) 
			{
                document.getElementById('dynamic_table2').innerHTML = response;
                $('#loading-image').hide();
            }

    });
}
function validationreplace()
{
    var total_rows_replace = document.getElementById("total_rows_replace").innerHTML;
    var value = 0;
    var flag = 0;
    console.log(total_rows_replace);
    for(var i=1; i<=Number(total_rows_replace);i++)
    {
        console.log(value);
        console.log(i);
        console.log(document.getElementById(i).value);
        value = Number(value) + Number(document.getElementById(i).value);
    }
    console.log("Hi"+value);
    if(value == 0)
    {
        swal('At Least one size should have the replace value.','','error');
        flag = 1;
    }
    else
    {
        var sizes = [];
        var values =[];
        var sizes_value = {};
        var validate_variable = 0;
        for(var i=1; i<=total_rows;i++)
        {
            var size_id = i+"size";
            sizes.push(document.getElementById(size_id).innerHTML);
            values.push(Number(document.getElementById(i).value)); 
        }
        for (var i = 0; i < sizes.length; i++)
        {
            sizes_value[sizes[i]] = 0;
            // console.log(sizes_value);
        }
        for (var i = 0; i < sizes.length; i++)
        {
            sizes_value[sizes[i]] = Number(sizes_value[sizes[i]])+Number(values[i]);
        }
        console.log(sizes_value);
        $.each(sizes_value, function( key, value )
        {
            var id = key;
            var max_replacable_qty = document.getElementById(id).innerHTML;
            if(max_replacable_qty < value)
            {
                validate_variable = 1;
            }
        });
        if(validate_variable == 1)
        {
            swal('You are replacing more than Excess Quantity available','','error');
            flag = 1;

        }
    }
    console.log(flag);
    // if(flag == 0)
    // {
        console.log("working");
        $('#pre').hide();
        $('#post').show();
        
   // }
    return true;
    // // else
    // // {
    // //     return false;
    // // }
}
function validationreplaceindividual(id)
{
    var data = document.getElementById(id).value;
    if(isInteger(data))
    {
        var size_id = id+"rems";
        var max_rem = Number(document.getElementById(size_id).innerHTML);
        var present_rep = Number(document.getElementById(id).value);
        if(max_rem < present_rep)
        {
            swal('You are replacing more than elegible to replace quantity.','','error');
            document.getElementById(id).value = 0;
        } 
    }
    else
    {
        document.getElementById(id).value = 0;
    }
   
}
function validationrecutindividual(id)
{
    var data = document.getElementById(id).value;
    if(isInteger(data))
    {
        var size_id = id+"rems";
        var max_rem = Number(document.getElementById(size_id).innerHTML);
        var present_rep = Number(document.getElementById(id).value);
        if(max_rem < present_rep)
        {
            swal('You are Re Cutting  more than elegible to Recut quantity.','','error');
            document.getElementById(id).value = 0;
        } 
    }
    else
    {
        document.getElementById(id).value = 0;
    }
}
function setfunction()
{
    var noofrows = $('#total_rows').val();
    // alert(document.getElementById('setreset').innerHTML);
    if(document.getElementById('setreset').innerHTML == 'Set')
    {
        for(var i=1; i<=Number(noofrows); i++)
        {
            var rem_var = i+'rems';
            console.log(rem_var);
            var remaining_qty = document.getElementById(rem_var).innerHTML;
            document.getElementById(i).value = remaining_qty; 
        }
        document.getElementById('setreset').innerHTML = 'ReSet';
    }
    else
    {
        for(var i=1; i<=Number(noofrows); i++)
        {
            document.getElementById(i).value = 0; 
        }
        document.getElementById('setreset').innerHTML = 'Set';

    }
    
}
function myFunction() 
{
    var input, filter, table, tr, td, i;
    input = document.getElementById("rm").value;
    filter = input.toUpperCase();
    table = document.getElementById("myTable");
    tr = table.getElementsByTagName("tr");
    var count = 0;
    if(tr.length > 1)
    {
        for (i = 1; i < tr.length; i++) 
        {
            td = tr[i].getElementsByTagName("td")[10];
            if(td) 
            {
                console.log(td.innerHTML.toUpperCase());
                console.log(filter);
                if(td.innerHTML.toUpperCase() == filter)
                {
                    console.log(tr[i]);
                    tr[i].style.display = "";
                } 
                else 
                {
                    count++;
                    tr[i].style.display = "none";
                }
            }
        }
    }
    // console.log(count);
    // if(count == 0)
    // {
    //     $('#myTable').hide();
    //     $('#myTable1').show();
    // }
    // else
    // {
    //     $('#myTable').show();
    //     $('#myTable1').hide();
    // }
}
function validationfunction()
{
    var flag = 0;
    var total_rows = document.getElementById('total_rows_recut').innerHTML;
    var value = 0;
    for(var i=1; i<=Number(total_rows);i++)
    {
        value = value + Number(document.getElementById(i).value);
    }
    if(value == 0)
    {
        swal('At Least one size should have the recut value.','','error');
        flag = 1;
    }
   if(flag == 1)
   {
       //return false;
   }
    //    else
    //    {
       $('#pre_pre').hide();
       $('#post_post').show();
       return true;
  // }
}
function isInteger(value) 
{
    if ((undefined === value) || (null === value))
    {
        return false;
    }
    return value % 1 == 0;
}
function focus_validate(id)
{
    var data = document.getElementById(id).value;
    if(data == 0)
    {
        document.getElementById(id).value = '';
    }
}
function focus_out_validation(id)
{
    var data = document.getElementById(id).value;
    if(data == '')
    {
        document.getElementById(id).value = 0;
    }
}
function myfunctionsearch() 
{
    var input, filter, table, tr, td, i;
    input = document.getElementById("schedule_id").value;
    filter = input.toUpperCase();
    table = document.getElementById("myTable");
    tr = table.getElementsByTagName("tr");
    var count = 0;
    if(tr.length > 1)
    {
        for (i = 1; i < tr.length; i++) 
        {
            td = tr[i].getElementsByTagName("td")[2];
            if(td) 
            {
                console.log(td.innerHTML.toUpperCase());
                console.log(filter);
                if(td.innerHTML.toUpperCase() == filter)
                {
                    console.log(tr[i]);
                    tr[i].style.display = "";
                } 
                else 
                {
                    count++;
                    tr[i].style.display = "none";
                }
            }
        }
    }
    // console.log(count);
    // if(count == 0)
    // {
    //     $('#myTable').hide();
    //     $('#myTable1').show();
    // }
    // else
    // {
    //     $('#myTable').show();
    //     $('#myTable1').hide();
    // }
}
function isNumber(t)
{
    if(t.value == 'e' || t.value == 'E' || t.value < 0 )
    {
        t.value = '';
        return false;
    }
}
</script>
<script>
$(document).ready(function() 
{
    $('#myTable1').hide();
    myFunction();
    // $('#recut').on('click', function(){
    //     $('#recut').hide();
    // });
    // $('#replace').on('click', function(){
    //     $('#replace').hide();
    // });
});
</script>
<style>
.modal-body {
    max-height:600px; 
    overflow-y: auto;
}

</style>