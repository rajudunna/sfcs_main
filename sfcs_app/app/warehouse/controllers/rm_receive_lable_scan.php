<html><html>
    <head>
        <?php 
            include($_SERVER['DOCUMENT_ROOT']."/sfcs_app/common/config/config.php");
            $plant_code = $_GET['plantcode'];
	        $username = $_GET['username'];
        ?>
    </head>
<?php
if(isset($_POST['check2']))
{
    $plant_name2=$_POST['plant_name'];
    
    
}
else
{
    $plant_name2=$_GET['plant_name'];
    
}
?>  
<body>
<h3 style="font-family:Helvetica Neue,Roboto,Arial,Droid Sans,sans-serif;"><b>RM Warehouse Material Receive</b></h3>
    <form name="input" method="post" action="<?php $_SERVER['PHP_SELF']; ?>" enctype="multipart/form data">
        <?php
            
            $query="SELECT plant_code FROM $pms.plant where plant_code !='$plant_code'";
            $query_result=mysqli_query($link, $query) or exit("Error getting Plant Details");
            echo "<tr>
                    <td>Sender Plant Name</td><td>:</td></br>
                    <td>
                    <select name=\"plant_name\" id='plant_name' required>";
            echo "<option value='' selected disabled>Select Plant Name</option>";
            
            while($row=mysqli_fetch_array($query_result))
            {
                if(str_replace(" ","",$row['plant_code'])==str_replace(" ","",$plant_name2))
                {
                    echo "<option value=\"".$row['plant_code']."\" selected>".$row['plant_code']."</option>";
                }
                else
                {
                    echo "<option value=\"".$row['plant_code']."\">".$row['plant_code']."</option>";
                }
                // echo "<option value='".$row['plant_code']."'>".$row['plant_name']."</option>";
            }
            echo "</select>
                </td></tr>"; 
        ?>
        
        <br/><br/><textarea name="barcode" id='barcode' rows="2" cols="15" onkeydown="document.input.submit();"></textarea>
        
        <br/>
        <br/>
        
       <input type="hidden" name="plantcode" id="plantcode" value="<?php echo $plant_code ?>">
       <input type="hidden" name="username" id="username" value="<?php echo $username ?>">
        <input type='text' name='barcode1' placeholder="Label Id" size=13><br/>
        <br/>
        <!-- <input type='text' name='barcode'  onkeypress='return numbersOnly(event)'> -->
        <input type="submit" name="check2" onclick="clickAndDisable(this);" value="Check Out" >
    </form></br>



        <?php
        
            if((isset($_POST['barcode']) && $_POST['barcode']!='') || (isset($_POST['barcode1']) && $_POST['barcode1']!='')){
                
                if($_POST['barcode']!=''){
                    $bar_code_new = $_POST['barcode'];
                }else {
                    $bar_code_new = $_POST['barcode1'];
                }
                $plant_name1=$_POST['plant_name'];
                $plantcode=$_POST['plantcode'];
                $username=$_POST['username'];
                // $res_get_data_fm_cwh = $link_new->query($qry_get_data_fm_cwh);
            
                //================ get barcode details from CWH DB =============
                $qry_get_data_fm_cwh = "select tid,qty_rec,qty_ret,qty_issued,qty_allocated,ref5,lot_no,ref2,ref4,ref3,roll_joins,shrinkage_length,shrinkage_width,shrinkage_group,supplier_no,shade_grp,rejection_reason,roll_remarks,roll_status,partial_appr_qty from $wms.store_in where plant_code='".$plant_name1."' AND barcode_number='".$bar_code_new."'";
                //echo  $qry_get_data_fm_cwh;
                $res_get_data_fm_cwh = $link_new->query($qry_get_data_fm_cwh);
                $barcode_data = array();
                $sticker_data1= array();
                if($res_get_data_fm_cwh->num_rows == 0)
                {
                    
                    echo "<div class='alert alert-danger'>Sorry1!! No Label ID(".$bar_code_new.") found..</div>";
                }
                else if ($res_get_data_fm_cwh->num_rows > 0) 
                {
                    
                    while($row = $res_get_data_fm_cwh->fetch_assoc()) 
                    {
                        $barcode_data = $row;
                        $tid_new = $row['tid'];
                        break;
                    }
                    if(count($barcode_data)>0)
                    {   
                        $actual_quentity_present = ($barcode_data['qty_rec']+$barcode_data['qty_ret']) - ($barcode_data['qty_issued'] + $barcode_data['qty_allocated']) ;
                        //$actual_quentity_present = $barcode_data['qty_rec']-$barcode_data['qty_issued'];
                        // echo $actual_quentity_present.'if';
                        if (is_numeric($barcode_data['ref5'])) {
                            $ref5=$barcode_data['ref5'];
                        }
                        else{
                            $ref5='0';
                        }
                        if (is_numeric($barcode_data['ref6'])) {
                            $ref6=$barcode_data['ref6'];
                        }
                        else{
                            $ref6='0';
                        }
                        if (is_numeric($barcode_data['ref3'])) {
                            $ref3=$barcode_data['ref3'];
                        }
                        else{
                            $ref3='0';
                        }
                        
                        if($actual_quentity_present>0)
                        {                           
                                //=================== check rmwh db with present tid ==================
                                $qry_check_rm_db = "select * from $wms.store_in where plant_code='".$plantcode."' AND barcode_number='".$bar_code_new."'";
                                
                                $res_check_rm_db = $link->query($qry_check_rm_db);
                                if($res_check_rm_db->num_rows == 0)
                                {
                                    $select_uuid="SELECT UUID() as uuid";
                                    $uuid_result=mysqli_query($link_new, $select_uuid) or exit("Sql Error at select_uuid".mysqli_error($GLOBALS["___mysqli_ston"]));
                                    while($uuid_row=mysqli_fetch_array($uuid_result))
                                    {
                                        $uuid=$uuid_row['uuid'];
                                    
                                    }
                                    // echo $res_check_rm_db->num_rows.'aaaaa';
                                    //=============== Insert Data in rmwh ==========================
                                    $qry_insert_update_rmwh_data = "INSERT INTO $wms.`store_in`(`tid`,`lot_no`, `qty_rec`, `qty_issued`, `qty_ret`, `date`, `remarks`, `log_stamp`, `status`,`ref2`,`ref3`,`ref4`,`ref5`,`ref6`,`log_user`,`barcode_number`,`ref_tid`,roll_joins,shrinkage_length,shrinkage_width,shrinkage_group,supplier_no,shade_grp,rejection_reason,roll_remarks,roll_status,partial_appr_qty,plant_code,created_user,updated_user) VALUES ('".$uuid."','".$barcode_data['lot_no']."','".$actual_quentity_present."','0','0','".date('Y-m-d')."','Directly came from ".$plant_name1."','".date('Y-m-d H:i:s')."',0,'".$barcode_data['ref2']."','$ref3','".$barcode_data['ref4']."','$ref5','$ref6','".$username."^".date('Y-m-d H:i:s')."','".$bar_code_new."','".$tid_new."','".$barcode_data['roll_joins']."','".$barcode_data['shrinkage_length']."','".$barcode_data['shrinkage_width']."','".$barcode_data['shrinkage_group']."','".$barcode_data['supplier_no']."','".$barcode_data['shade_grp']."','".$barcode_data['rejection_reason']."','".$barcode_data['roll_remarks']."','".$barcode_data['roll_status']."','".$barcode_data['partial_appr_qty']."','".$plantcode."','".$username."','".$username."')"; 
                                     //echo $qry_insert_update_rmwh_data."<br/>";
    
                                    $res_insert_update_rmwh_data = $link->query($qry_insert_update_rmwh_data);
                                    
                                    
                                    $sticker_report = "select * from $wms.`sticker_report` where plant_code='".$plant_name1."' AND lot_no='".$barcode_data['lot_no']."'";
                                   // echo $sticker_report."yateesh<br/>";
                                    $res_sticker_report_cwh = $link_new->query($sticker_report);
                                    while($row1 = $res_sticker_report_cwh->fetch_assoc()) 
                                    {
                                        $sticker_data = $row1;
                                        break;
                                    }
                                    
                                    $sticker_report1 = "select * from $wms.`sticker_report` where plant_code='".$plant_code."' AND lot_no='".$barcode_data['lot_no']."'";
                                   // echo $sticker_report1."5862<br/>";
                                    $res_sticker_report_cwh1 = $link->query($sticker_report1);
                                    while($row12 = $res_sticker_report_cwh1->fetch_assoc()) 
                                    {
                                        $sticker_data1 = $row12;
                                        break;
                                    }
                                    //echo "<br/>No of rows:".$row12."<br/>";
                                    //echo "<br/>result:".count($sticker_data1)."<br/>";
                                    if(count($sticker_data1)==0)
                                    {
                                        //these are single culumn replaces
                                        $pkg_no=str_replace('"','""',$sticker_data['pkg_no']);
                                        $item_desc=str_replace('"','""',$sticker_data['item_desc']);
                                        $item_name=str_replace('"','""',$sticker_data['item_name']);
                                        $qry_insert_sticker_report_data = "INSERT INTO $wms.`sticker_report` (`item`,`item_name`,`item_desc`,`inv_no`,`po_no`,`rec_no`,`lot_no`,`batch_no`,`buyer`,`product_group`,`doe`,`pkg_no`,`grn_date`,`allocated_qty`,`backup_status`,`supplier`,`uom`,`grn_location`,style_no,plant_code,created_user,updated_user) VALUES (\"".$sticker_data['item']."\",\"".$item_name."\",\"".$item_desc."\",\"".$sticker_data['inv_no']."\",\"".$sticker_data['po_no']."\",\"".$sticker_data['rec_no']."\",\"".$sticker_data['lot_no']."\",\"".$sticker_data['batch_no']."\",\"".$sticker_data['buyer']."\",\"".$sticker_data['product_group']."\",\"".$sticker_data['doe']."\",\"".$pkg_no."\",\"".$sticker_data['grn_date']."\",\"".$sticker_data['allocated_qty']."\",\"".$sticker_data['backup_status']."\",\"".$sticker_data['supplier']."\",\"".$sticker_data['uom']."\",\"".$sticker_data['grn_location']."\",\"".$sticker_data['style_no']."\",\"".$plant_code."\",\"".$user_name."\",\"".$user_name."\")";
                                        //echo $qry_insert_sticker_report_data."<br/>";
                                        $qry_insert_sticker_report_data1 = $link->query($qry_insert_sticker_report_data);
                                    }
                                    
                                    $qty_rec_store_report = "select sum(qty_rec)as qty_rec from $wms.`store_in` where plant_code='".$plant_name1."' AND lot_no='".$barcode_data['lot_no']."'";
                                    //echo $qty_rec_store_report."<br/>";
                                    $qty_rec_store_report1 = $link->query($qty_rec_store_report);
                                    while($row2 = $qty_rec_store_report1->fetch_assoc()) 
                                    {
                                        $rec_qty = $row2;
                                        break;
                                    }
                                    
                                    $qry_insert_sticker_report1_data = "update $wms.`sticker_report` set rec_qty=\"".$rec_qty['qty_rec']."\",rec_no=\"".$sticker_data['rec_no']."\",inv_no=\"".$sticker_data['inv_no']."\",batch_no=\"".$sticker_data['batch_no']."\" where lot_no=\"".$sticker_data['lot_no']."\" AND plant_code=\"".$plantcode."\"";
                                    //echo $qry_insert_sticker_report1_data."<br/>";
                                    
                                    $qry_insert_sticker_report1_data1 = $link->query($qry_insert_sticker_report1_data);

                                    
                                    //echo $qry_insert_update_rmwh_data."<br/>";
                                    //$res_insert_update_rmwh_data = $conn1->query($qry_insert_update_rmwh_data);
                                    //=============== insert store_out & update store_in in cwh======================
                                                        
                                    $qry_ins_stockout = "INSERT INTO $wms.`store_out`(tran_tid,qty_issued,date,updated_by,remarks,plant_code,created_user,updated_user) VALUES ('".$tid_new."',".$actual_quentity_present.",'".date('Y-m-d')."','".$username."','Send to ".$plant_code."','".$plant_name1."','".$username."','".$username."')";
                                    // echo $qry_ins_stockout."<br/>";
                                    $res_ins_stockout = $link_new->query($qry_ins_stockout);
                                    $update_qty_store_in = "update $wms.store_in set qty_issued=".$barcode_data['qty_issued'] ."+".$actual_quentity_present." where plant_code='".$plant_name1."' AND barcode_number='".$bar_code_new."'";
                                    
                                   // echo $update_qty_store_in."<br/>";
                                    $res_update_qty_store_in = $link_new->query($update_qty_store_in);
                                    echo "<h3>Status1: <font color=Green>Quantity ".$actual_quentity_present." Transferred successfully for Item ID : ".$bar_code_new." and Lot Number : ".$barcode_data['lot_no']."</font></h3>";
                                    //=====================================================================
                                    
                                }
                                else {
                                    // echo $res_check_rm_db->num_rows.'aaaaa';
                                    //=============== Insert Data in rmwh ==========================
                                    // $qry_insert_update_rmwh_data = "INSERT INTO $wms.`store_in`(`lot_no`, `qty_rec`, `qty_issued`, `qty_ret`, `date`, `remarks`, `log_stamp`, `status`,`ref2`,`ref3`,`ref4`,`ref5`,`ref6`,`log_user`,`barcode_number`,`ref_tid`) VALUES ('".$barcode_data['lot_no']."','".$actual_quentity_present."','0','0','".date('Y-m-d')."','Directly came from ".$plant_name1."','".date('Y-m-d H:i:s')."','".$barcode_data['status']."','".$barcode_data['ref2']."','".$barcode_data['ref3']."','".$barcode_data['ref4']."','".$barcode_data['ref5']."','".$barcode_data['ref6']."','".$username."^".date('Y-m-d H:i:s')."','".$bar_code_new."','".$tid_new."')"; 
                                    // // echo $qry_insert_update_rmwh_data."<br/>";
    
                                    // $res_insert_update_rmwh_data = $link->query($qry_insert_update_rmwh_data);
                                    $qry_insert_update_rmwh_data1 = "update $wms.`store_in` set qty_issued=0,remarks='Directly came from ".$plant_name1."',log_user='".$username."^".date('Y-m-d H:i:s')."' where barcode_number='$bar_code_new' and plant_code='$plant_code'";  
                                    
                                        $res_insert_update_rmwh_data1 = $link->query($qry_insert_update_rmwh_data1);
                                    
                                    $sticker_report = "select * from $wms.`sticker_report` where lot_no='".$barcode_data['lot_no']."' AND plant_code='".$plant_name1."'";
                                    echo $sticker_report."<br/>";
                                    $res_sticker_report_cwh = $link_new->query($sticker_report);
                                    while($row1 = $res_sticker_report_cwh->fetch_assoc()) 
                                    {
                                        $sticker_data = $row1;
                                        break;
                                    }
                                    
                                    $sticker_report1 = "select * from $wms.`sticker_report` where lot_no='".$barcode_data['lot_no']."' AND plant_code='".$plant_code."'";
                                    echo $sticker_report1."<br/>";
                                    $res_sticker_report_cwh1 = $link->query($sticker_report1);
                                    while($row12 = $res_sticker_report_cwh1->fetch_assoc()) 
                                    {
                                        $sticker_data1 = $row12;
                                        break;
                                    }
                                    
                                    $qry_check_rm_db1 = "select tid from $wms.store_in where plant_code='".$plant_code."' AND barcode_number='".$bar_code_new."'";
                                    $res_check_rm_db1 = $link->query($qry_check_rm_db1);
                                    echo $qry_check_rm_db1;
                                    
                                    
                                    while($row1 = $res_check_rm_db1->fetch_assoc()) 
                                    {
                                        $tid_old=$row1['tid'];
                                        $delete_qry= "delete from $wms.store_out where plant_code='$plant_code' AND tran_tid=$tid_old";
                                        $delete_qry_result = $link->query($delete_qry);
                                    }
                                    
                                    //echo "<br/>No of rows:".$row12."<br/>";
                                    //echo "<br/>result:".count($sticker_data1)."<br/>";
                                    if(count($sticker_data1)==0)
                                    {
                                        $pkg_no=str_replace('"','""',$sticker_data['pkg_no']);
                                        $item_desc=str_replace('"','""',$sticker_data['item_desc']);
                                        $item_name=str_replace('"','""',$sticker_data['item_name']);
                                        $qry_insert_sticker_report_data = "INSERT INTO $wms.`sticker_report` (`item`,`item_name`,`item_desc`,`inv_no`,`po_no`,`rec_no`,`lot_no`,`batch_no`,`buyer`,`product_group`,`doe`,`pkg_no`,`grn_date`,`allocated_qty`,`backup_status`,`supplier`,`uom`,`grn_location`,style_no,plant_code,created_user,updated_user) VALUES (\"".$sticker_data['item']."\",\"".$item_name."\",\"".$item_desc."\",\"".$sticker_data['inv_no']."\",\"".$sticker_data['po_no']."\",\"".$sticker_data['rec_no']."\",\"".$sticker_data['lot_no']."\",\"".$sticker_data['batch_no']."\",\"".$sticker_data['buyer']."\",\"".$sticker_data['product_group']."\",\"".$sticker_data['doe']."\",\"".$pkg_no."\",\"".$sticker_data['grn_date']."\",\"".$sticker_data['allocated_qty']."\",\"".$sticker_data['backup_status']."\",\"".$sticker_data['supplier']."\",\"".$sticker_data['uom']."\",\"".$sticker_data['grn_location']."\",\"".$sticker_data['style_no']."\",\"".$plant_code."\",\"".$user_name."\",\"".$user_name."\")";
                                        echo $qry_insert_sticker_report_data."<br/>";
                                        $qry_insert_sticker_report_data1 = $link->query($qry_insert_sticker_report_data);
                                    }
                                   
                                    $qty_rec_store_report = "select sum(qty_rec)as qty_rec from $wms.`store_in` where plant_code='".$plant_code."' AND lot_no='".$barcode_data['lot_no']."'";
                                    //echo $qty_rec_store_report."<br/>";
                                    $qty_rec_store_report1 = $link->query($qty_rec_store_report);
                                    while($row2 = $qty_rec_store_report1->fetch_assoc()) 
                                    {
                                        $rec_qty = $row2;
                                        break;
                                    }
                                    
                                    $qry_ins_stockout = "INSERT INTO $wms.`store_out`(tran_tid,qty_issued,date,updated_by,remarks,plant_code) VALUES (".$tid_new.",".$actual_quentity_present.",'".date('Y-m-d')."','".$username."','Send to ".$plant_code."','".$plant_name1."')";
                                    // echo $qry_ins_stockout."<br/>";
                                    $res_ins_stockout = $link_new->query($qry_ins_stockout);
                                    
                                    $update_qty_store_in = "update $wms.store_in set qty_issued= qty_issued + ".$actual_quentity_present." where barcode_number='".$bar_code_new."' AND plant_code='".$plant_name1."'";
                                    
                                    //echo $update_qty_store_in."<br/>";
                                    $res_update_qty_store_in = $link_new->query($update_qty_store_in);
                                    echo "<h3>Status2: <font color=Green>Quantity ".$actual_quentity_present." Transferred successfully for Item ID : ".$bar_code_new." and Lot Number : ".$barcode_data['lot_no']."</font></h3>";
                                    //=====================================================================
                                }

                                //insert inspection db details
                                //$sticker_data['batch_no']

                                //validating batch no in receiving plant
                                $qry_batch_val="select * from $wms.inspection_db where batch_ref='".$sticker_data['batch_no']."' AND plant_code='".$plant_code."'";
                                
                                $qry_batch_val_check = $link->query($qry_batch_val);
                                if($qry_batch_val_check->num_rows == 0){
                                    
                                    //validating inspection done or not in sending plant for particular batch
                                    $qry_batchval_sendplant="select * from $wms.inspection_db where batch_ref='".$sticker_data['batch_no']."' AND plant_code='".$plant_name1."'";
                                    
                                    $qry_batchval_sendplant_check = $link_new->query($qry_batchval_sendplant);
                                    while($row123 = $qry_batchval_sendplant_check->fetch_assoc()) 
                                    {
                                        $inspection_data = $row123;
                                        break;
                                    }
                                    if($qry_batchval_sendplant_check->num_rows > 0)
                                    {
                                        //logic for insert inspected db details based on batch
                                        $insert_insp_db = "insert into $wms.inspection_db (batch_ref,act_gsm,pur_width,act_width,sp_rem,qty_insp,gmt_way,pts,fallout,skew,skew_cat,shrink_l,shrink_w,supplier,log_date,unique_id,status,pur_gsm,consumption,plant_code,created_user,updated_user) values('".$sticker_data['batch_no']."','".$inspection_data['act_gsm']."','".$inspection_data['pur_width']."','".$inspection_data['act_width']."','".str_replace( array( "'",'"' ),'',$inspection_data['sp_rem'])."','".$inspection_data['qty_insp']."','".$inspection_data['gmt_way']."','".$inspection_data['pts']."','".$inspection_data['fallout']."','".$inspection_data['skew']."','".$inspection_data['skew_cat']."','".$inspection_data['shrink_l']."','".$inspection_data['shrink_w']."','".$inspection_data['supplier']."','".$inspection_data['log_date']."','".$inspection_data['unique_id']."','".$inspection_data['status']."','".$inspection_data['pur_gsm']."','".$inspection_data['consumption']."','".$plant_code."','".$user_name."','".$user_name."')";
                                        //echo $insert_insp_db;
                                        $qry_inspectiondb_check = $link->query($insert_insp_db);
                                    }

                                } 
                            
                        }
                        else
                        {
                        
                            echo "<h3>Status: <font color=Red>Insufficient Quantity.</font></h3>";
                        }
                    }
                    else
                    {
                        echo "<h3>Status: <font color=Red>Sorry2!! No Label ID found..</font></h3>";
                    }
                } 
                else 
                {
                    echo "<h3>Status: <font color=red>There are multiple Label Ids. System Can't pick the value. Please Contact Central RM Warehouse Team.</font></h3>";
                }

            }
        ?>
</body>

<script>
        window.onload = function() 
        {
        document.getElementById("barcode").focus();
        };
        </script>
        <script>
            function test(){
                if($('#plant_name').val() != null){
                    document.input.submit();
                }else {
                    sweetAlert('','Select Plant Name','Warning');
                }
            }
        function numbersOnly()
        {
           var charCode = event.keyCode;

                    if (charCode >= 48 && charCode < 58)

                        return true;
                    else
                        return false;
        }
        </script>
</html>
<script> 
   function clickAndDisable(link) {
     // disable subsequent clicks
     link.onclick = function(event) {
        event.preventDefault();
     }
   }   
</script>