<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="X-UA-Compatible" content="IE=11; IE=9; IE=8; IE=7; IE=6; IE=5; IE=EDGE" />
<?php
    $url = include(getFullURLLevel($_GET['r'],'/common/config/config.php',4,'R'));
    $has_permission=haspermission($_GET['r']); 
    include(getFullURLLevel($_GET['r'],'/common/config/m3Updations.php',4,'R'));
    
    //hardcode for temp purpose
    $operation_code = 15;
    $access_report = $operation_code.'-G';
    $access_qry=" select * from $central_administration_sfcs.rbac_permission where permission_name = '$access_report' and status='active'";
    $result = $link->query($access_qry);
    if($result->num_rows > 0){
        if (in_array($$access_report,$has_permission))
        {
            $good_report = '';
        }
        else
        {
            $good_report = 'readonly';
        }
        
    } else {
        $good_report = '';
    }
   
?>

<style>
            /* #loading-image {
              border: 16px solid #f3f3f3;
              border-radius: 50%;
              border-top: 16px solid #3498db;
              width: 120px;
              height: 120px;
              margin-left: 40%;
              -webkit-animation: spin 2s linear infinite; /* Safari */
              animation: spin 2s linear infinite;
            }

            /* Safari */
            @-webkit-keyframes spin {
              0% { -webkit-transform: rotate(0deg); }
              100% { -webkit-transform: rotate(360deg); }
            }

            @keyframes spin {
              0% { transform: rotate(0deg); }
              100% { transform: rotate(360deg); }
            }
            #delete_reversal_docket{
                margin-top:3pt;
            } */
        </style>
<body>


<div class="panel panel-primary"> 
    <div class="panel-heading">Cutting Reversal</div>
        <div class='panel-body'>
            <form method="post" name="form1" action="?r=<?php echo $_GET['r']; ?>">
                <div class="row">
                    <div class="col-md-3">
                        <label>Docket Number</label>
                        <input type="text" class='integer form-control' id="docket_number" name="docket_number" size=8 required>
                    </div>
                    <div class="col-md-2">
                        <label>Plies</label>
                        <input type="text" class='integer form-control' id="plies" name="plies" size=5 required>
                    </div><br/>
                    <div class="col-md-3">
                        <input type="submit" id="delete_reversal_docket" class="btn btn-danger confirm-submit" name="formSubmit" value="Delete">
                    </div>
                    <img id="loading-image" class=""/>  
                </div>
            </form>
        </div>
    </div>

<?php


if(isset($_POST['formSubmit']))
{
   
    if($good_report != 'readonly')
    {
        $docket_number_post = $_POST['docket_number'];
        $get_order_tid = "SELECT order_tid from $bai_pro3.plandoc_stat_log where doc_no = $docket_number_post ";
        // echo $get_order_tid;
        $get_order_tid_res = mysqli_query($link,$get_order_tid);
        while($row1 = mysqli_fetch_array($get_order_tid_res)){
            $order_tid = $row1['order_tid'];
        }
        
        $get_shipment_details="select order_style_no as style,order_del_no as schedule from $bai_pro3.bai_orders_db where order_tid ='".$order_tid."'";

        $get_shipment_details_res=mysqli_query($link, $get_shipment_details) or exit("Sql Error11".mysqli_error($GLOBALS["___mysqli_ston"]));
        while($sql_rowx121=mysqli_fetch_array($get_shipment_details_res))
        {
            $style=$sql_rowx121['style'];
            $schedule=$sql_rowx121['schedule'];
        }
        $short_ship_status =0;
        $query_short_shipment = "select * from bai_pro3.short_shipment_job_track where remove_type in('1','2') and style='".$style."' and schedule ='".$schedule."'";
        $shortship_res = mysqli_query($link,$query_short_shipment);
        $count_short_ship = mysqli_num_rows($shortship_res);
        if($count_short_ship >0) {
            while($row_set=mysqli_fetch_array($shortship_res))
            {
                if($row_set['remove_type']==1) {
                    $short_ship_status=1;
                }else{
                    $short_ship_status=2;
                }
            }
        }
        if($short_ship_status==1){
            $url = '?r='.$_GET['r'];
            echo "<script>swal('Error','Short Shipment Done Temporarly','error');window.location = '".$url."'</script>";
            exit();
        }
        else if($short_ship_status==2){
            $url = '?r='.$_GET['r'];
            echo "<script>swal('Error','Short Shipment Done Perminently','error');window.location = '".$url."'</script>";
            exit();
        }
        $plies_post = $_POST['plies'];
        $does_docket_exists_flag= '';
        $update_plan_doc_stat_flag = 0;
        $op_code = 15;

    

        $check_docket_query="SELECT * FROM bai_pro3.plandoc_stat_log psl 
        LEFT JOIN bai_pro3.cat_stat_log csl ON csl.tid = psl.cat_ref
        WHERE doc_no = $docket_number_post AND category NOT IN ($in_categories);";
        if(mysqli_num_rows(mysqli_query($link,$check_docket_query)) > 0)
        {
            $reverse_cut_qty= "UPDATE bai_pro3.plandoc_stat_log SET act_cut_status = '' ,a_plies=p_plies ,manual_flag = 0 WHERE doc_no = $docket_number_post";
            $reverse_cut_qty_result = mysqli_query($link,$reverse_cut_qty) or exit(" Error78".mysqli_error ($GLOBALS["___mysqli_ston"]));
            $url = '?r='.$_GET['r'];
            

            echo "<script>sweetAlert('Reversal Docket','Updated Successfully','success');window.location = '".$url."'</script>";
            exit();
        }
        //Checking for the clubbing dockets
        $check_club_docket_query = "SELECT doc_no from $bai_pro3.plandoc_stat_log 
                where doc_no = $docket_number_post and org_doc_no >=1 ";
        if(mysqli_num_rows(mysqli_query($link,$check_club_docket_query)) > 0){
            echo "<script>swal('You Cannot Reverse a Clubbed Docket','','error')</script>";        
            exit();
        }
        $get_operation_code_qry = "SELECT * FROM $brandix_bts.tbl_style_ops_master WHERE style=(SELECT order_style_no FROM $bai_pro3.bai_orders_db WHERE order_tid IN (SELECT order_tid FROM bai_pro3.plandoc_stat_log WHERE doc_no=$docket_number_post)) AND color=(SELECT order_col_des FROM $bai_pro3.bai_orders_db WHERE order_tid IN (SELECT order_tid FROM bai_pro3.plandoc_stat_log WHERE doc_no=$docket_number_post)) AND operation_code > 15 ORDER BY operation_order*1 LIMIT 1";
        $get_operation_code_qry_result = mysqli_query($link,$get_operation_code_qry) or exit(" Error3".mysqli_error($GLOBALS["___mysqli_ston"]));
        if(mysqli_num_rows($get_operation_code_qry_result)>0)
        {

            while($sql_row2 = mysqli_fetch_array($get_operation_code_qry_result))
            {
                $pre_ops_code=$sql_row2['operation_code'];
            }
        }
        $emb_check_flag = 0;
        $category=['cutting','Send PF','Receive PF'];
        $checking_qry = "SELECT category FROM $brandix_bts.tbl_orders_ops_ref WHERE operation_code = $pre_ops_code";
        // echo $checking_qry.'<br/>';
        $result_checking_qry = $link->query($checking_qry);
        while($row_cat = $result_checking_qry->fetch_assoc()) 
        {
            $category_act = $row_cat['category'];
        }
        if(in_array($category_act,$category))
        {
            $emb_check_flag = 1;
        }
        if($docket_number_post!='' && $plies_post!='')
        {
            $get_docket_details_qry = "select * from $bai_pro3.plandoc_stat_log where doc_no=$docket_number_post";
            $get_docket_details_qry_result = mysqli_query($link,$get_docket_details_qry) or exit("PlanDocStat Log Query Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
            while($row = $get_docket_details_qry_result->fetch_assoc()) 
            {
                // echo '<br/><br/>'.$row['a_plies'].' - '.$plies_post;
                $manual_flag = $row['manual_flag'];
                $does_docket_exists_flag= 1;
                if($row['a_plies'] >= $plies_post) {
                    for ($i=0; $i < sizeof($sizes_array); $i++)
                    { 
                        if ($row['a_'.$sizes_array[$i]] > 0)
                        {
                            $cut_done_qty[$sizes_array[$i]] = $row['a_'.$sizes_array[$i]] * $plies_post;
                        }
                    }
                }
                else {
                    echo "<script>sweetAlert('','Plies Should Be Less Than Actual Plies','warning');
                    </script>";
                    // $does_docket_exists_flag= 1;
                }
                
            }
            if($does_docket_exists_flag==''){
                echo "<script>sweetAlert('','Enter Valid Docket Number','error');</script>";
            }
            elseif($does_docket_exists_flag== 1) 
            {
                $validate_check_flag_rem = 1;
                foreach ($cut_done_qty as $key => $value)
                {
                    $selecting_cps_qry = "SELECT remaining_qty FROM $bai_pro3.cps_log WHERE `doc_no`='$docket_number_post' AND `size_code`=  '$key' AND operation_code=15";
                    // echo '<br/>'.$selecting_cps_qry.'<br/>';
                    // die();
                    $result_selecting_cps_qry = $link->query($selecting_cps_qry);
                    while($row_result_selecting_cps_qry = $result_selecting_cps_qry->fetch_assoc()) 
                    {
                        $rem_qty  = $row_result_selecting_cps_qry['remaining_qty'];
                        // echo $rem_qty.'--'.$value;
                        if($rem_qty < $value)
                        {
                            $validate_check_flag_rem = 0;
                        }
                    }
                }
                // die();
                if($validate_check_flag_rem == 1)
                {
                    foreach ($cut_done_qty as $key => $value)
                    {
                        $selecting_cps_qry = "SELECT id,remaining_qty FROM $bai_pro3.cps_log WHERE `doc_no`='$docket_number_post' AND `size_code`=  '$key' AND operation_code=15";
                        $result_selecting_cps_qry = $link->query($selecting_cps_qry);
                        while($row_result_selecting_cps_qry = $result_selecting_cps_qry->fetch_assoc()) 
                        {
        
                            $rem_id  = $row_result_selecting_cps_qry['id'];
                            $remaining_qty1  = $row_result_selecting_cps_qry['remaining_qty'];
                            if($remaining_qty1>$value){
                                $status='P';
                            }else {
                                $status='';
                            }
                            $update_qty_rem = "update $bai_pro3.cps_log set remaining_qty = remaining_qty-$value,reported_status='".$status."' where id = $rem_id";
                            // echo $update_qty_rem.'<br/>';
                            $update_qty_rem_result = mysqli_query($link,$update_qty_rem) or exit(" Error50".mysqli_error ($GLOBALS["___mysqli_ston"]));
                            
                        }
                        $bundle_creation_data_qry1 = "SELECT id,bundle_number FROM $brandix_bts.bundle_creation_data WHERE docket_number=$docket_number_post AND operation_id = '15' AND size_id='$key'";
                        // echo $bundle_creation_data_qry1.'<br/>';
                        $bundle_creation_data_qry_result1 = mysqli_query($link,$bundle_creation_data_qry1) or exit(" Error49".mysqli_error ($GLOBALS["___mysqli_ston"]));
                        while($row_result_selecting_qry = $bundle_creation_data_qry_result1->fetch_assoc()) 
                        {
                            $bcd_id = $row_result_selecting_qry['id'];
                            $ref_no = $row_result_selecting_qry['bundle_number'];
                            $update_qry_bcd = "update $brandix_bts.bundle_creation_data set recevied_qty = recevied_qty-$value where id = $bcd_id";
                            $neg_value = 0;
                            $neg_value = $neg_value - $value;
                            // echo $update_qry_bcd.'<br/>';
                            $update_qry_bcd_result = mysqli_query($link,$update_qry_bcd) or exit(" Error48".mysqli_error ($GLOBALS["___mysqli_ston"]));
                            $bulk_insert_temp = "INSERT INTO brandix_bts.bundle_creation_data_temp(`style`,`schedule`,`color`,`size_id`,`size_title`,`sfcs_smv`,`bundle_number`,`original_qty`,`send_qty`,`recevied_qty`,`rejected_qty`,`left_over`,`operation_id`,`docket_number`, `scanned_date`, `cut_number`, `input_job_no`,`scanned_user`,`input_job_no_random_ref`, `shift`, `assigned_module`, `remarks`) SELECT style,SCHEDULE,color,size_id,size_title,sfcs_smv,bundle_number,original_qty,send_qty,$neg_value,rejected_qty,left_over,operation_id,docket_number, scanned_date, cut_number, input_job_no,'$username',input_job_no_random_ref, shift, assigned_module, remarks FROM brandix_bts.bundle_creation_data WHERE docket_number=$docket_number_post AND operation_id = '15' AND size_id='$key' ";
                            $bulk_insert_temp_result = mysqli_query($link,$bulk_insert_temp) or exit(" Error488".mysqli_error ($GLOBALS["___mysqli_ston"]));
                            $update_plan_doc_stat_flag = 1;
                        }
                        if($emb_check_flag == 1)
                        {
                            $bundle_creation_data_qry1 = "SELECT id FROM $brandix_bts.bundle_creation_data WHERE docket_number=$docket_number_post AND operation_id = '$pre_ops_code' AND size_id='$key'";
                            // echo $bundle_creation_data_qry1.'<br/>';
                            $bundle_creation_data_qry_result1 = mysqli_query($link,$bundle_creation_data_qry1) or exit(" Error47".mysqli_error ($GLOBALS["___mysqli_ston"]));
                            while($row_result_selecting_qry = $bundle_creation_data_qry_result1->fetch_assoc()) 
                            {
                                $bcd_id_pre = $row_result_selecting_qry['id'];
                                $update_qry_bcd_pre = "update $brandix_bts.bundle_creation_data set send_qty = send_qty-$value where id = $bcd_id_pre";
                                // echo $update_qry_bcd_pre.'<br/>';
                                $update_qry_bcd_pre_result = mysqli_query($link,$update_qry_bcd_pre) or exit(" Error46".mysqli_error ($GLOBALS["___mysqli_ston"]));
                            }
                        }
                        $remarks = $username."-".$manual_flag;
                        $docket_log= "insert into $brandix_bts.reversal_docket_log(docket_number,bundle_number,operation_id,size_title,cutting_reversal,act_cut_status,remarks)values(".$docket_number_post.",".$ref_no.",".$pre_ops_code.",'".$key."',".$value.",'Reversal','$remarks')";
                        // echo $docket_log.'<br/>';
                        $docket_log_res = mysqli_query($link,$docket_log) or exit(" Error77".$docket_log."-".mysqli_error ($GLOBALS["___mysqli_ston"]));
                        $updation_m3 = updateM3TransactionsReversal($ref_no,$value,$op_code);
                    }
                    if($update_plan_doc_stat_flag==1){
                        $cut_status_qry = "SELECT * from $bai_pro3.plandoc_stat_log where doc_no=$docket_number_post";
                        $cut_status_qry_result = mysqli_query($link,$cut_status_qry) or exit(" Error45".mysqli_error ($GLOBALS["___mysqli_ston"]));
                        while($sql_row = $cut_status_qry_result->fetch_assoc()){
                            $a_plies_old = $sql_row['a_plies'];
                            $p_plies_old = $sql_row['p_plies'];
                            if($a_plies_old==$plies_post) {
                                $update_plies_qry = "UPDATE $bai_pro3.plandoc_stat_log SET a_plies=a_plies-$plies_post,act_cut_status='',manual_flag = 0 WHERE doc_no=$docket_number_post";
                                // echo $update_plies_qry.'<br/><br/>';
                                $update_plies_qry_result = mysqli_query($link,$update_plies_qry) or exit(" Error41".mysqli_error ($GLOBALS["___mysqli_ston"]));
                                $url = '?r='.$_GET['r'];
                                $reportingrolls="SELECT * from bai_pro3.docket_roll_info where docket=$docket_number_post";
                                $reportingrollsresult= mysqli_query($link,$reportingrolls);
                                $deleteplie=$plies_post;
                        
                                if(mysqli_num_rows($reportingrollsresult) > 0)
                                {
                                    while($reportingrolls = mysqli_fetch_array($reportingrollsresult))
                                    {
                                        
                                        if($reportingrolls['reporting_plies']<=$deleteplie)
                                        {
                                            $deletedqueries="DELETE FROM bai_pro3.docket_roll_info WHERE docket=$docket_number_post and roll_no=".$reportingrolls['roll_no'];
                                            $deletedqueriesresult= mysqli_query($link,$deletedqueries) or exit("error1".mysqli_error($GLOBALS["___mysqli_ston"]));
                                            $deleteplie=$deleteplie-$reportingrolls['reporting_plies'];//remaining plie
                                            
                                            if($deleteplie==0)
                                            {
                                                break;
                                            }
                        
                                        }
                                    else 
                                        {
                                                $updatedplie=$reportingrolls['reporting_plies']-$deleteplie;
                                                $updateroll="UPDATE bai_pro3.docket_roll_info SET reporting_plies = $updatedplie WHERE docket=$docket_number_post and roll_no=".$reportingrolls['roll_no'];
                                                $updaterollresult= mysqli_query($link,$updateroll);
                                                $deleteplie=$deleteplie-$reportingrolls['reporting_plies']; //remaining plie
                                                if($deleteplie==0)
                                                {
                                                    break;
                                                }
                                            
                                        }
                                    }
                                
                                }
                                echo "<script>sweetAlert('Reversal Docket','Updated Successfully','success');window.location = '".$url."'</script>";
                            }
                            else {
                                $update_plies_qry = "UPDATE $bai_pro3.plandoc_stat_log SET a_plies=a_plies-$plies_post,act_cut_status='DONE',manual_flag = 0 WHERE doc_no=$docket_number_post";
                                // echo $update_plies_qry.'<br/><br/>';
                                $update_plies_qry_result = mysqli_query($link,$update_plies_qry) or exit(" Error42".mysqli_error ($GLOBALS["___mysqli_ston"]));
                                $url = '?r='.$_GET['r'];
                                $reportingrolls="SELECT * from bai_pro3.docket_roll_info where docket=$docket_number_post";
                                $reportingrollsresult= mysqli_query($link,$reportingrolls);
                                $deleteplie=$plies_post;
                        
                                if(mysqli_num_rows($reportingrollsresult) > 0)
                                {
                                    while($reportingrolls = mysqli_fetch_array($reportingrollsresult))
                                    {
                                        
                                        if($reportingrolls['reporting_plies']<=$deleteplie)
                                        {
                                            $deletedqueries="DELETE FROM bai_pro3.docket_roll_info WHERE docket=$docket_number_post and roll_no=".$reportingrolls['roll_no'];
                                            $deletedqueriesresult= mysqli_query($link,$deletedqueries) or exit("error1".mysqli_error($GLOBALS["___mysqli_ston"]));
                                            $deleteplie=$deleteplie-$reportingrolls['reporting_plies'];//remaining plie
                                            
                                            if($deleteplie==0)
                                            {
                                                break;
                                            }
                        
                                        }
                                    else 
                                        {
                                                $updatedplie=$reportingrolls['reporting_plies']-$deleteplie;
                                                $updateroll="UPDATE bai_pro3.docket_roll_info SET reporting_plies = $updatedplie WHERE docket=$docket_number_post and roll_no=".$reportingrolls['roll_no'];
                                                $updaterollresult= mysqli_query($link,$updateroll);
                                                $deleteplie=$deleteplie-$reportingrolls['reporting_plies']; //remaining plie
                                                if($deleteplie==0)
                                                {
                                                    break;
                                                }
                                            
                                        }
                                    }
                                
                                }
                                echo "<script>sweetAlert('Reversal Docket','Updated Successfully','success');window.location = '".$url."'</script>";
                            
                            
                            }
                        }
                        
                    }
                }
                else
                {
                    echo "<script>sweetAlert('Reversal Docket','Can not Done','warning');</script>";
                }
            }
        }
    } else {
        echo "<script>sweetAlert('UnAuthorized','You are not allowed to reverse.','warning');</script>";
    }
}