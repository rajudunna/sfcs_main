<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="X-UA-Compatible" content="IE=11; IE=9; IE=8; IE=7; IE=6; IE=5; IE=EDGE" />
<?php
   $url = include(getFullURLLevel($_GET['r'],'/common/config/config.php',4,'R'));
?>
<style>
			#loading-image {
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
            }
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
    $temp_docket = '';
    $validation = '';
    $var = '';
    $sizes=array('01','02','03','04','05','06','07','08','09','10','11','12','13','14','15','16','17','18','19','20','21','22','23','24','25','26','27','28','29','30','31','32','33','34','35','36','37','38','39','40','41','42','43','44','45','46','47','48','49','50');
    $sizes_rat=array();
    if($docket_number_post!='' && $plies_post!='') {
        $get_docket_details_qry = "select * from $bai_pro3.plandoc_stat_log where doc_no=$docket_number_post";
        $get_docket_details_qry_result = mysqli_query($link,$get_docket_details_qry) or exit("PlanDocStat Log Query Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
        while($sql_row=mysqli_fetch_array($get_docket_details_qry_result))
		{
            $temp_docket = 1;
            $repeat_size = '';
            
            $send_qty_temp='';
            if($docket_number_post == $sql_row['doc_no']){
                if($sql_row['a_plies'] >= $plies_post) {
                    $get_style_color_qry = "SELECT * FROM $bai_pro3.bai_orders_db WHERE order_tid IN (SELECT order_tid FROM bai_pro3.plandoc_stat_log WHERE doc_no=$docket_number_post)";
                    // echo $get_style_color_qry;
                    $get_style_color_qry_result = mysqli_query($link,$get_style_color_qry) or exit(" Error3".mysqli_error($GLOBALS["___mysqli_ston"]));
                    while($sql_row1 = mysqli_fetch_array($get_style_color_qry_result)){
                        $order_style_no_result = $sql_row1['order_style_no'];

                        $get_operation_code_qry = "SELECT * FROM $brandix_bts.tbl_style_ops_master WHERE style='$order_style_no_result' AND color=(SELECT order_col_des FROM $bai_pro3.bai_orders_db WHERE order_tid IN (SELECT order_tid FROM bai_pro3.plandoc_stat_log WHERE doc_no=$docket_number_post)) AND operation_code > 15 LIMIT 1";
                        $get_operation_code_qry_result = mysqli_query($link,$get_operation_code_qry) or exit(" Error3".mysqli_error($GLOBALS["___mysqli_ston"]));
                        // echo $get_operation_code_qry;
                        while($sql_row2 = mysqli_fetch_array($get_operation_code_qry_result)){
                            if($sql_row2['operation_code'] > 15){
                                $bundle_creation_data_qry = "SELECT *,SUM(send_qty) AS size_wise_send_qty FROM brandix_bts.bundle_creation_data WHERE docket_number=$docket_number_post AND operation_id > 15 AND operation_id IN (SELECT MIN(operation_id) FROM brandix_bts.bundle_creation_data WHERE docket_number=$docket_number_post AND operation_id>15) GROUP BY size_title  ORDER BY size_id";
                                // echo $bundle_creation_data_qry;
                                $bundle_creation_data_qry_result = mysqli_query($link,$bundle_creation_data_qry) or exit(" Error4".mysqli_error ($GLOBALS["___mysqli_ston"]));
                                while($sql_row3 = mysqli_fetch_array($bundle_creation_data_qry_result)){
                                    if($sql_row3['send_qty']!=$sql_row3['size_wise_send_qty']){
                                        $send_qty_temp = $sql_row3['size_wise_send_qty'];
                                        $repeat_size = 1;
                                        break;
                                    }
                                }

                             
                                $validation_qry = "SELECT min(send_qty)as send_qty FROM brandix_bts.bundle_creation_data WHERE docket_number=$docket_number_post AND operation_id > 15 AND operation_id IN (SELECT MIN(operation_id) FROM brandix_bts.bundle_creation_data WHERE docket_number=$docket_number_post AND operation_id>15) ORDER BY size_id";
                                $validation_result = mysqli_query($link,$validation_qry) or exit(" Error4".mysqli_error ($GLOBALS["___mysqli_ston"]));
                                while($sql_row6 = mysqli_fetch_array($validation_result)){
                                    if($sql_row6['send_qty'] < 0){
                                        $validation = 1;
                                    }
                                }
                                if($validation != 1){
                                $bundle_creation_data_qry_result1 = mysqli_query($link,$bundle_creation_data_qry) or exit(" Error4".mysqli_error ($GLOBALS["___mysqli_ston"]));
                                    while($sql_row23 = mysqli_fetch_array($bundle_creation_data_qry_result1)){
                                        for($i=0;$i<sizeof($sizes);$i++)
                                            {
                                                if($sql_row['a_s'.$sizes[$i]]>0)
                                                {
                                                    $sizes_rat[$sizes[$i]]=$sql_row['a_s'.$sizes[$i]];
                                                    if($sql_row1['title_size_s'.$sizes[$i]]!='')
                                                    {
                                                        $sizes_tit[$sizes[$i]]=$sql_row1['title_size_s'.$sizes[$i]];
                                                        $send_qty_post =$sizes_rat[$sizes[$i]] * $plies_post;
                                                        if($sql_row23['size_title'] == $sizes_tit[$sizes[$i]]) {
                                                            $send_qty_final=$sizes_rat[$sizes[$i]]*$plies_post;
                                                           
                                                                if($repeat_size == ''){
                                                                    if($sql_row23['send_qty'] > $sql_row23['recevied_qty'] && $send_qty_final>0){
                                                                        $send_qty_new = $sql_row23['send_qty']-$send_qty_final;
                                                                        $check = $sql_row23['send_qty']-$sql_row23['recevied_qty'];
                                                                        if($send_qty_new>0 && $check>=$send_qty_final){
                                                                            $update_bundle_creation_data_qry = "UPDATE $brandix_bts.bundle_creation_data SET send_qty=$send_qty_new WHERE size_title='".$sizes_tit[$sizes[$i]]."' AND docket_number=$docket_number_post AND operation_id=".$sql_row23['operation_id'];
                                                                            $update_bundle_creation_data_qry_result = mysqli_query($link,$update_bundle_creation_data_qry) or exit(" Error4".mysqli_error ($GLOBALS["___mysqli_ston"]));
                                                                            $send_qty_final2 = $sql_row23['send_qty'] - $send_qty_update; 
                                                                            $reversal_docket_log= "insert into $brandix_bts.reversal_docket_log(docket_number,parent_bundle_creation_id,bundle_number,size_title,cutting_reversal,act_cut_status)values(".$docket_number_post.",".$sql_row23['id'].",".$sql_row23['bundle_number'].",'".$sizes_tit[$sizes[$i]]."',".$send_qty_final2.",'Reversal')";
                                                                            // echo $reversal_docket_log;
                                                                            $reversal_docket_log_qry = mysqli_query($link,$reversal_docket_log) or exit(" Error7".mysqli_error ($GLOBALS["___mysqli_ston"]));
                                                                        }
                                                                        else {
                                                                            $check_validation = 1;
                                                                        }
                                                                    }
                                                                }
                                                                else {
                                                                    // echo 'else';
                                                                    $query="SELECT sum(send_qty) as send_qty1,sum(recevied_qty) as recevied_qty1,operation_id from $brandix_bts.bundle_creation_data where docket_number=$docket_number_post and size_title='".$sql_row23['size_title']."' AND operation_id IN (SELECT MIN(operation_id) FROM brandix_bts.bundle_creation_data WHERE docket_number=$docket_number_post AND operation_id>15)";
                                                                    // echo '<br/>'.$query;
                                                                    $query_result = mysqli_query($link,$query) or exit(" Error4".mysqli_error ($GLOBALS["___mysqli_ston"]));
                                                                   

                                                                    while($sql_row_new = mysqli_fetch_array($query_result)){
                                                                        $balance = ($sql_row_new['send_qty1']-$sql_row_new['recevied_qty1']);
                                                                        // echo '<br/><u>'.$balance.' - '.$send_qty_final.'</u><br/>';
                                                                        if($balance>0 && $balance >= $send_qty_final){
                                                                            $query1 = "SELECT * from $brandix_bts.bundle_creation_data where docket_number=$docket_number_post and size_title='".$sql_row23['size_title']."' AND operation_id IN (SELECT MIN(operation_id) FROM $brandix_bts.bundle_creation_data WHERE docket_number=$docket_number_post AND operation_id>15) ORDER BY bundle_number";
                                                                            // echo $query1;
                                                                            $query_result1 = mysqli_query($link,$query1) or exit(" Error4".mysqli_error ($GLOBALS["___mysqli_ston"]));
                                                                           
                                                                            while($sql_row_new1 = mysqli_fetch_array($query_result1)){
                                                                                if($sql_row_new1['send_qty'] > $sql_row_new1['recevied_qty'] && $send_qty_final>0){
                                                                                    if($sql_row_new1['send_qty'] < $send_qty_final){
                                                                                        $send_qty_update = $sql_row_new1['send_qty'] - $sql_row_new1['send_qty'];
                                                                                    }
                                                                                    else {
                                                                                        $send_qty_update = $sql_row_new1['send_qty'] - $send_qty_final;
                                                                                    }
                                                                                    $temp = $sql_row_new1['send_qty'] - $send_qty_update;
                                                                                    $send_qty_final = $send_qty_final-$temp;
                                                                                    $update_bundle_creation_data_qry = "UPDATE $brandix_bts.bundle_creation_data SET send_qty=$send_qty_update WHERE size_title='".$sizes_tit[$sizes[$i]]."' AND docket_number=$docket_number_post AND operation_id=".$sql_row23['operation_id']." AND bundle_number=".$sql_row_new1['bundle_number'];
                                                                                    // echo '<br>~~~~'.$update_bundle_creation_data_qry;
                                                                                    $update_bundle_creation_data_qry_result = mysqli_query($link,$update_bundle_creation_data_qry) or exit(" Error3".mysqli_error($GLOBALS["___mysqli_ston"]));
                                                                                    $send_qty_final2 = $sql_row_new1['send_qty'] - $send_qty_update; 
                                                                                    $reversal_docket_log= "insert into $brandix_bts.reversal_docket_log(docket_number,parent_bundle_creation_id,bundle_number,size_title,cutting_reversal,act_cut_status)values(".$docket_number_post.",".$sql_row_new1['id'].",".$sql_row_new1['bundle_number'].",'".$sizes_tit[$sizes[$i]]."',".$send_qty_final2.",'Reversal')";
                                                                                    // echo $reversal_docket_log;
                                                                                    $reversal_docket_log_qry = mysqli_query($link,$reversal_docket_log) or exit(" Error7".mysqli_error ($GLOBALS["___mysqli_ston"]));
                                                                                }
                                                                            }
                                                                        }
                                                                        
                                                                    }

                                                                }
                                                                if($update_bundle_creation_data_qry_result >0){
                                                                    $plies_new= $sql_row['a_plies']-$plies_post;
                                                                    if($plies_new>=0){
                                                                        if($plies_new != 0) {
                                                                            $update_plies_qry = "UPDATE $bai_pro3.plandoc_stat_log SET a_plies=$plies_new WHERE doc_no=$docket_number_post";
                                                                        } else {
                                                                            $update_plies_qry = "UPDATE $bai_pro3.plandoc_stat_log SET a_plies=$plies_new,act_cut_status='Reversal' WHERE doc_no=$docket_number_post";

                                                                        }
                                                                        $update_plies_qry_result = mysqli_query($link,$update_plies_qry) or exit(" Error4".mysqli_error ($GLOBALS["___mysqli_ston"]));
                                                                        $var = 1;
                                                                    }
                                                                }
                                                                elseif($check_validation == 1){
                                                                    ?><script>sweetAlert('Plies','Enter valid plies','warning');</script><?php
                                                                }
                                                                else{
                                                                    $operation_code_value = $sql_row2["operation_code"];
                                                                    if($operation_code_value > 15){
                                                                        $operation_name_qry = "select op_desc from $bai_pro3.mo_operation_quantites where op_code=$operation_code_value";
                                                                        $operation_name_qry_result = mysqli_query($link,$operation_name_qry) or exit(" Error3".mysqli_error($GLOBALS["___mysqli_ston"]));
                                                                        while($sql_row3 = mysqli_fetch_array($operation_name_qry_result)){
                                                                            ?><script>sweetAlert('<?php echo $sql_row3['op_desc']; ?> done,','So, Cutting cant be Reversed','error');</script><?php
                                                                        }
                                                                    }
                                                                }
                                                            }
                                                        
                                                        }
                                                    }
                                                }
                                            }
                                        }       
                                    }
                                }
                            }
                        }
                else {
                    echo "<script>sweetAlert('','Plies Should Be Less Than Actual Plies','warning');
                    $('#docket_number').val('<?php echo $docket_number_post; ?>');
                    </script>";
                }
            }
        }
        if($temp_docket != 1){
            echo "<script>sweetAlert('','Enter Valid Docket Number','error');</script>";
        }
        if($var==1){
            echo "<script>sweetAlert('Reversal Docket','Updated Successfully','success');</script>";
            
        } 
        if($var!=1) {
            $operation_code_value = $sql_row2["operation_code"];
            if($operation_code_value > 15){
                $operation_name_qry = "select op_desc from $bai_pro3.mo_operation_quantites where op_code=$operation_code_value";
                // echo $operation_name_qry.' 4 <br/>';
                $operation_name_qry_result = mysqli_query($link,$operation_name_qry) or exit(" Error3".mysqli_error($GLOBALS["___mysqli_ston"]));
                while($sql_row3 = mysqli_fetch_array($operation_name_qry_result)){
    //                 ?>
                        <script>sweetAlert('<?php echo $sql_row3['op_desc']; ?> done,','So, Cutting cant be Reversed','error');</script>
                    <?php
                    break;
                }
            }
    }
    }
}
?>
</body>
<script>
    $(document).ready(function() {
        $('#docket_number').val('<?php echo $docket_number_post; ?>');
        $('#plies').val('<?php echo $plies_post; ?>');
    $('#loading-image').hide();
        $('#loading-image').on('keyup',function(){
            if($('#plies').val()<0){
                sweetAlert('','Enter Valid Plies','error');
            }
        });

        $('#delete_reversal_docket').on('click',function(){
            $('#loading-image').show();
        });
    });
</script>