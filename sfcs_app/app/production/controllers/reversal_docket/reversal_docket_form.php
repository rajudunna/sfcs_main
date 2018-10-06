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
	<div class="panel-heading">Reversal Docket</div>
		<div class='panel-body'>
            <form method="post" name="form1" action="?r=<?php echo $_GET['r']; ?>">
                <div class="row">
                    <div class="col-md-3">
                        <label>Docket Number</label>
                        <input type="number" onkeydown="javascript: return event.keyCode == 69 ? false : true"  id="docket_number" class="form-control" name="docket_number" size=8 required>
                    </div>
                    <div class="col-md-2">
                        <label>Plies</label>
                        <input type="number" onkeydown="javascript: return event.keyCode == 69 ? false : true"  id="plies" class="form-control" name="plies" size=5 required>
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
    $next_operation_flag='';
    $update_plan_doc = ''; 
    $check='';
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
                $does_docket_exists_flag= 1;
            }
            
        }
        if($does_docket_exists_flag==''){
            echo "<script>sweetAlert('','Enter Valid Docket Number','error');</script>";
        }
        elseif($does_docket_exists_flag== 1) {
            // get next operation
            $get_operation_code_qry = "SELECT * FROM $brandix_bts.tbl_style_ops_master WHERE style=(SELECT order_style_no FROM $bai_pro3.bai_orders_db WHERE order_tid IN (SELECT order_tid FROM bai_pro3.plandoc_stat_log WHERE doc_no=$docket_number_post)) AND color=(SELECT order_col_des FROM $bai_pro3.bai_orders_db WHERE order_tid IN (SELECT order_tid FROM bai_pro3.plandoc_stat_log WHERE doc_no=$docket_number_post)) AND operation_code > 15 LIMIT 1";
            // echo $get_operation_code_qry;
            // die();
            $get_operation_code_qry_result = mysqli_query($link,$get_operation_code_qry) or exit(" Error3".mysqli_error($GLOBALS["___mysqli_ston"]));
            if(mysqli_num_rows($get_operation_code_qry_result)>0){
                $next_operation_flag=1;
            }
        }

        
        if($next_operation_flag==1&&$does_docket_exists_flag==1) {
            //validation
            foreach ($cut_done_qty as $key => $value)
            {
                $get_operation_code_qry = "SELECT * FROM $brandix_bts.tbl_style_ops_master WHERE style=(SELECT order_style_no FROM $bai_pro3.bai_orders_db WHERE order_tid IN (SELECT order_tid FROM bai_pro3.plandoc_stat_log WHERE doc_no=$docket_number_post)) AND color=(SELECT order_col_des FROM $bai_pro3.bai_orders_db WHERE order_tid IN (SELECT order_tid FROM bai_pro3.plandoc_stat_log WHERE doc_no=$docket_number_post)) AND operation_code > 15 LIMIT 1";
                // echo $get_operation_code_qry.'<br/>';
                // die();
                $get_operation_code_qry_result = mysqli_query($link,$get_operation_code_qry) or exit(" Error3".mysqli_error($GLOBALS["___mysqli_ston"]));
                while($row_result_selecting_qry = $get_operation_code_qry_result->fetch_assoc()){
                    $operation_code = $row_result_selecting_qry['operation_code'];
                    $selecting_cps_qry = "SELECT * FROM $bai_pro3.cps_log WHERE `doc_no`='$docket_number_post' AND `size_code`=  '$key' AND operation_code=$operation_code";
                    // echo $selecting_cps_qry;
                    $result_selecting_cps_qry = $link->query($selecting_cps_qry);
                    while($row_result_selecting_cps_qry = $result_selecting_cps_qry->fetch_assoc()) 
                    {
                        $cut_qty_result = $row_result_selecting_cps_qry['cut_quantity'];
                        $remaining_qty_result = $row_result_selecting_cps_qry['remaining_qty'];
                        $res = $cut_qty_result-$remaining_qty_result;
                        // echo $res.'>='.$value;
                        if($res < $value){
                            $check = 1;
                            break;
                        }
                        else {
                            $check = 0;
                        }
                    }
                }
            }
            //actual
            if($check == 0){
                foreach ($cut_done_qty as $key => $value)
                {
                    $bundle_creation_data_qry1 = "SELECT * FROM brandix_bts.bundle_creation_data WHERE docket_number=$docket_number_post AND operation_id IN (SELECT MIN(operation_id) FROM brandix_bts.bundle_creation_data WHERE docket_number=$docket_number_post AND operation_id>15) AND size_id='$key' ORDER BY size_id";
                    // echo '<br/>'.$bundle_creation_data_qry1.'<br/>';

                    $bundle_creation_data_qry_result1 = mysqli_query($link,$bundle_creation_data_qry1) or exit(" Error4".mysqli_error ($GLOBALS["___mysqli_ston"]));
                    while($row_result_selecting_qry = $bundle_creation_data_qry_result1->fetch_assoc()) 
                    {
                        $id_to_update = $row_result_selecting_qry['id'];
                        $mapped_color = $row_result_selecting_qry['mapped_color'];
                        $ref_no = $row_result_selecting_qry['bundle_number'];
                        $b_style = $row_result_selecting_qry['style'];
                        
                        if($row_result_selecting_qry['send_qty']>=$row_result_selecting_qry['recevied_qty']){
                            
                            //update bundle creation data
                            $selecting_qry2 = "SELECT * FROM $brandix_bts.bundle_creation_data WHERE docket_number = '$docket_number_post' AND size_id = '$key' AND operation_id = '".$operation_code."'";
                            
                            $result_selecting_qry2 = $link->query($selecting_qry2);
                            // var_dump($result_selecting_qry2);die();
                            while($row_result_selecting_qry = $result_selecting_qry2->fetch_assoc()) 
                            {
                                $id_to_update = $row_result_selecting_qry['id'];
                            }
                            $update_qry = "update $brandix_bts.bundle_creation_data set send_qty = send_qty-$value where id = $id_to_update";
                            // echo $update_qry.'<br/>';
                            $updating_bundle_data = mysqli_query($link,$update_qry) or exit("While updating budle_creation_data".mysqli_error($GLOBALS["___mysqli_ston"]));

                            // updating cut qty into  cps log
                            $selecting_cps_qry = "SELECT * FROM $bai_pro3.cps_log WHERE `doc_no`='$docket_number_post' AND `size_code`=  '$key' AND operation_code = '".$operation_code."'";
                            // echo $selecting_cps_qry.'<br/>';
                            $result_selecting_cps_qry = $link->query($selecting_cps_qry);
                            while($row_result_selecting_cps_qry = $result_selecting_cps_qry->fetch_assoc()) 
                            {
                                $id_to_update_cps = $row_result_selecting_cps_qry['id'];
                                $cut_qty_result = $row_result_selecting_cps_qry['cut_quantity'];
                                $remaining_qty_result = $row_result_selecting_cps_qry['remaining_qty'];
                                $res = $cut_qty_result-$remaining_qty_result;
                            }
                            $update_qry_cps = "update $bai_pro3.cps_log set remaining_qty = remaining_qty+$value where id = $id_to_update_cps";
                            // echo $update_qry_cps.'<br/>';
                            $updating_cps = mysqli_query($link,$update_qry_cps) or exit("While updating cps".mysqli_error($GLOBALS["___mysqli_ston"]));



                            //maintaining log
                            $reversal_docket_log= "insert into $brandix_bts.reversal_docket_log(docket_number,parent_bundle_creation_id,bundle_number,size_title,cutting_reversal,act_cut_status)values(".$docket_number_post.",".$id_to_update.",".$ref_no.",'".$key."',".$value.",'Reversal')";
                            // echo $reversal_docket_log.'<br/>';
                            $reversal_docket_log_qry = mysqli_query($link,$reversal_docket_log) or exit(" Error7".mysqli_error ($GLOBALS["___mysqli_ston"]));
                            $update_plan_doc = 1;
                            $op_code = $operation_code;
                            $category=['cutting','Send PF','Receive PF'];
                            $pre_ops_code=$op_code;
                            $checking_qry = "SELECT category FROM $brandix_bts.tbl_orders_ops_ref WHERE operation_code = $operation_code";
                            $result_checking_qry = $link->query($checking_qry);
                            while($row_cat = $result_checking_qry->fetch_assoc()) 
                            {
                                $category_act = $row_cat['category'];
                            }
                            // echo $category_act.'<br/>';
                            if(in_array($category_act,$category))
                            {
                                // echo 'hi<br/>';
                                $updation_m3 = updateM3TransactionsReversal($ref_no,$value,$op_code);
                            }
                                // echo $ref_no.','.-$value.','.$op_code.'<br/>';
                            // }
                            }
                    }
                }
                if($update_plan_doc==1){
                    
                    $update_plies_qry = "UPDATE $bai_pro3.plandoc_stat_log SET a_plies=a_plies-$plies_post WHERE doc_no=$docket_number_post";
                    // echo $update_plies_qry.'<br/><br/>';
                    $update_plies_qry_result = mysqli_query($link,$update_plies_qry) or exit(" Error4".mysqli_error ($GLOBALS["___mysqli_ston"]));
                    echo "<script>sweetAlert('Reversal Docket','Updated Successfully','success');</script>";
                }
            }
            else {
                //cps log not found
                echo "<script>sweetAlert('Docket cant revered!','Updated Failed','warning');</script>";
            }
        }
        else{
            $get_operation_code_qry1 = "SELECT * FROM $brandix_bts.tbl_style_ops_master WHERE style=(SELECT order_style_no FROM $bai_pro3.bai_orders_db WHERE order_tid IN (SELECT order_tid FROM bai_pro3.plandoc_stat_log WHERE doc_no=$docket_number_post)) AND color=(SELECT order_col_des FROM $bai_pro3.bai_orders_db WHERE order_tid IN (SELECT order_tid FROM bai_pro3.plandoc_stat_log WHERE doc_no=$docket_number_post)) AND operation_code=15";
            // echo $get_operation_code_qry1;
            $get_operation_code_qry_result1 = mysqli_query($link,$get_operation_code_qry1) or exit(" Error3".mysqli_error($GLOBALS["___mysqli_ston"]));
            while($sql_row21 = mysqli_fetch_array($get_operation_code_qry_result1)){
                $category=['cutting','Send PF','Receive PF'];
                $pre_ops_code=$sql_row21['operation_code'];
                $checking_qry = "SELECT category FROM $brandix_bts.tbl_orders_ops_ref WHERE operation_code = $pre_ops_code";
                // echo $checking_qry;
                $result_checking_qry = $link->query($checking_qry);
                while($row_cat = $result_checking_qry->fetch_assoc()) 
                {
                    $category_act = $row_cat['category'];
                }
                if(in_array($category_act,$category))
                {
                    // $emb_cut_check_flag = 1;
                    $doc_no_ref = $docket_number_post;
                    $url = getFullURLLevel($_GET['r'],'reversal_cutting.php',0,'N');
                    echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",180); function Redirect() {  location.href = \"$url&doc_no_ref=$docket_number_post&plies=$plies_post\"; }</script>";
                    // $var=1;
                }
            }
        }
        
    }
}