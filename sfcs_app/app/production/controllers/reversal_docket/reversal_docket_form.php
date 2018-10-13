<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="X-UA-Compatible" content="IE=11; IE=9; IE=8; IE=7; IE=6; IE=5; IE=EDGE" />
<?php
    $url = include(getFullURLLevel($_GET['r'],'/common/config/config.php',4,'R'));
    include(getFullURLLevel($_GET['r'],'functions.php',0,'R'));
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
                        <input type="submit" id="delete_reversal_docket" class="btn btn-danger" name="formSubmit" value="Delete">
                    </div>
                	<img id="loading-image" class=""/>  
                </div>
            </form>
        </div>
    </div>

<?php

if(isset($_POST['formSubmit']))
{
    $docket_number_post = $_POST['docket_number'];
    $plies_post = $_POST['plies'];
    $does_docket_exists_flag= '';
    $update_plan_doc_stat_flag = 0;
    $get_operation_code_qry = "SELECT * FROM $brandix_bts.tbl_style_ops_master WHERE style=(SELECT order_style_no FROM $bai_pro3.bai_orders_db WHERE order_tid IN (SELECT order_tid FROM bai_pro3.plandoc_stat_log WHERE doc_no=$docket_number_post)) AND color=(SELECT order_col_des FROM $bai_pro3.bai_orders_db WHERE order_tid IN (SELECT order_tid FROM bai_pro3.plandoc_stat_log WHERE doc_no=$docket_number_post)) AND operation_code > 15 LIMIT 1";
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
                    if($rem_qty < $value)
                    {
                        $validate_check_flag_rem = 0;
                    }
                }
            }
            if($validate_check_flag_rem == 1)
            {
                foreach ($cut_done_qty as $key => $value)
                {
                    $selecting_cps_qry = "SELECT id,remaining_qty FROM $bai_pro3.cps_log WHERE `doc_no`='$docket_number_post' AND `size_code`=  '$key' AND operation_code=15";
                    $result_selecting_cps_qry = $link->query($selecting_cps_qry);
                    while($row_result_selecting_cps_qry = $result_selecting_cps_qry->fetch_assoc()) 
                    {
    
                        $rem_id  = $row_result_selecting_cps_qry['id'];
                        $update_qty_rem = "update $bai_pro3.cps_log set remaining_qty = remaining_qty-$value where id = $rem_id";
                        // echo $update_qty_rem.'<br/>';
                        $update_qty_rem_result = mysqli_query($link,$update_qty_rem) or exit(" Error4".mysqli_error ($GLOBALS["___mysqli_ston"]));
                        
                    }
                    $bundle_creation_data_qry1 = "SELECT id,bundle_number FROM $brandix_bts.bundle_creation_data WHERE docket_number=$docket_number_post AND operation_id = '15' AND size_id='$key'";
                    // echo $bundle_creation_data_qry1.'<br/>';
                    $bundle_creation_data_qry_result1 = mysqli_query($link,$bundle_creation_data_qry1) or exit(" Error4".mysqli_error ($GLOBALS["___mysqli_ston"]));
                    while($row_result_selecting_qry = $bundle_creation_data_qry_result1->fetch_assoc()) 
                    {
                        $bcd_id = $row_result_selecting_qry['id'];
                        $ref_no = $row_result_selecting_qry['bundle_number'];
                        $update_qry_bcd = "update $brandix_bts.bundle_creation_data set recevied_qty = recevied_qty-$value where id = $bcd_id";
                        // echo $update_qry_bcd.'<br/>';
                        $update_qry_bcd_result = mysqli_query($link,$update_qry_bcd) or exit(" Error4".mysqli_error ($GLOBALS["___mysqli_ston"]));
                        $update_plan_doc_stat_flag = 1;
                        $updation_m3 = updateM3TransactionsReversal($ref_no,$value,$pre_ops_code);
                    }
                    if($emb_check_flag == 1)
                    {
                        $bundle_creation_data_qry1 = "SELECT id FROM $brandix_bts.bundle_creation_data WHERE docket_number=$docket_number_post AND operation_id = '$pre_ops_code' AND size_id='$key'";
                        // echo $bundle_creation_data_qry1.'<br/>';
                        $bundle_creation_data_qry_result1 = mysqli_query($link,$bundle_creation_data_qry1) or exit(" Error4".mysqli_error ($GLOBALS["___mysqli_ston"]));
                        while($row_result_selecting_qry = $bundle_creation_data_qry_result1->fetch_assoc()) 
                        {
                            $bcd_id_pre = $row_result_selecting_qry['id'];
                            $update_qry_bcd_pre = "update $brandix_bts.bundle_creation_data set send_qty = send_qty-$value where id = $bcd_id_pre";
                            // echo $update_qry_bcd_pre.'<br/>';
                            $update_qry_bcd_pre_result = mysqli_query($link,$update_qry_bcd_pre) or exit(" Error4".mysqli_error ($GLOBALS["___mysqli_ston"]));
                        }
                    }
                    $docket_log= "insert into $brandix_bts.reversal_docket_log(docket_number,bundle_number,operation_id,size_title,cutting_reversal,act_cut_status)values(".$docket_number_post.",".$ref_no.",".$pre_ops_code.",'".$key."',".$value.",'Reversal')";
                    // echo $docket_log.'<br/>';
                    $docket_log_res = mysqli_query($link,$docket_log) or exit(" Error77".mysqli_error ($GLOBALS["___mysqli_ston"]));
                }
                if($update_plan_doc_stat_flag==1){
                    $cut_status_qry = "SELECT * from $bai_pro3.plandoc_stat_log where doc_no=$docket_number_post";
                    $cut_status_qry_result = mysqli_query($link,$cut_status_qry) or exit(" Error4".mysqli_error ($GLOBALS["___mysqli_ston"]));
                    while($sql_row = $cut_status_qry_result->fetch_assoc()){
                        $a_plies_old = $sql_row['a_plies'];
                        $p_plies_old = $sql_row['p_plies'];
                        if($p_plies_old==$plies_post) {
                            $update_plies_qry = "UPDATE $bai_pro3.plandoc_stat_log SET a_plies=$p_plies_old,act_cut_status='' WHERE doc_no=$docket_number_post";
                            // echo $update_plies_qry.'<br/><br/>';
                            $update_plies_qry_result = mysqli_query($link,$update_plies_qry) or exit(" Error4".mysqli_error ($GLOBALS["___mysqli_ston"]));
                            echo "<script>sweetAlert('Reversal Docket','Updated Successfully','success');</script>";
                        }
                        else {
                            $update_plies_qry = "UPDATE $bai_pro3.plandoc_stat_log SET a_plies=a_plies-$plies_post,act_cut_status='DONE' WHERE doc_no=$docket_number_post";
                            // echo $update_plies_qry.'<br/><br/>';
                            $update_plies_qry_result = mysqli_query($link,$update_plies_qry) or exit(" Error4".mysqli_error ($GLOBALS["___mysqli_ston"]));
                            echo "<script>sweetAlert('Reversal Docket','Updated Successfully','success');</script>";
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
}
