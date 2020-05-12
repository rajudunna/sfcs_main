<?php
function get_ips_operation_code($link,$style,$color){
	
    $data=[];
    $qry_ips_ops_mapping = "SELECT tsm.operation_code AS operation_code ,tor.operation_name AS operation_name FROM brandix_bts.tbl_style_ops_master tsm LEFT JOIN brandix_bts.tbl_orders_ops_ref tor ON tor.id=tsm.operation_name WHERE style='$style' AND color='$color' AND tor.display_operations='yes' AND tor.category='sewing' GROUP BY tsm.operation_code ORDER BY tsm.operation_order LIMIT 1";
    $result_qry_ips_ops_mapping = $link->query($qry_ips_ops_mapping);
    while($sql_row1=mysqli_fetch_array($result_qry_ips_ops_mapping))
    {
        $operation_name=$sql_row1['operation_name'];
        $operation_code=$sql_row1['operation_code'];
    }
    $data['operation_name']=$operation_name;
    $data['operation_code']=$operation_code;

    return $data;
}
function color_decode($color)
{
   $main_color=base64_decode(urldecode($color));
   return $main_color;
}

function color_encode($color)
{
   $main_color=base64_encode(urlencode($color));
   return $main_color;
}

?>