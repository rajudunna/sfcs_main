<?php
include("../../../../../common/config/config_ajax.php");
//getting barocde info to scanning screen
$barcode_info=$_POST['barcode_info'];
if($barcode_info!=''){
    //validation for barcode exist or not
    $qry_barcode="SELECT * FROM $brandix_bts.`bundle_creation_data` WHERE bundle_number=$barcode_info";
    $result_qry_barcode = $link->query($qry_barcode);
    if($result_qry_barcode->num_rows > 0){
        while($row = $result_qry_barcode->fetch_assoc()){
            //getting operation name by using operation code
            $qry_operationname="SELECT * FROM $brandix_bts.tbl_orders_ops_ref WHERE operation_code='".$row['operation_id']."'";
            $result_qry_operationname = $link->query($qry_operationname);
            while($row_operationname = $result_qry_operationname->fetch_assoc()){
                $json['operation_name']=$row_operationname['operation_name']; 
            }
            //getting po and zfeature
            $qry_orderdetails="SELECT * FROM $bai_pro3.`bai_orders_db_confirm` WHERE order_style_no='".$row['style']."' AND order_del_no='".$row['schedule']."' AND order_col_des='".$row['color']."'";
            $result_qry_orderdetails = $link->query($qry_orderdetails);
            while($row_orderdetails = $result_qry_orderdetails->fetch_assoc()){
                $json['zfeature']=$row_orderdetails['zfeature'];
                $json['vpo']=$row_orderdetails['vpo']; 
            }
            $json['style']=$row['style'];
            $json['schedule']=$row['schedule'];
            $json['color']=$row['color'];
            $json['original_qty']=$row['original_qty'];
            $json['schedule']=$row['schedule'];
            $json['size_title']=$row['size_title'];
            $json['global_facility_code']=$global_facility_code;
            $json['validate_barcode'] = 1;
        }
    }else{
        $json['validate_barcode'] = 0;
        
    }
    echo json_encode($json);


}

// $barcode=$_POST['barcode_value'];
// $module=$_POST['module'];
// $op_code=$_POST['op_code'];
// $trans_mode=$_POST['trans_mode'];
// echo "Bracode : ".$barcode." Module : ".$module." Op Code : ".$op_code." Trans Mode : ".$trans_mode;
  
?>