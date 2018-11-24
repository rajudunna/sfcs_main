<?php
if(isset($_GET['recut_id']))
{
	$recut_id = $_GET['recut_id'];
	if($recut_id != '')
	{
		getReCutDetails($recut_id);
	}
}

function getReCutDetails($recut_id)
{
    include("../../../../common/config/config_ajax.php");
    $html = '';
    $get_details_qry = "SELECT DISTINCT category FROM `bai_pro3`.`rejection_log_child` rc LEFT JOIN `brandix_bts`.`tbl_orders_ops_ref` ops
    ON ops.operation_code = rc.`operation_id`  WHERE parent_id = $recut_id order by category";
   // echo $get_details_qry;
    $result_get_details_qry = $link->query($get_details_qry);
    while($row = $result_get_details_qry->fetch_assoc()) 
    {
        // var_dump($row);\
        $cat = $row['category'];
        $category=['cutting','Send PF','Receive PF'];
        if(in_array($cat,$category))
        {
            $getting_full_cut_details = "SELECT * FROM `bai_pro3`.`rejection_log_child` rc LEFT JOIN `brandix_bts`.`tbl_orders_ops_ref` ops
            ON ops.operation_code = rc.`operation_id`  WHERE parent_id = $recut_id and category = '$cat' group by doc_no,size_title";
           $table_data = "<table class = 'col-sm-12 table-bordered table-striped table-condensed cf'><thead class='cf'><tr><th>Docket Number</th><th>Size</th><th>Rejected Qty</th><th>Recut Allowed Qty</th><th>Replaced Qty</th><th>Remaining Qty</th><th>Issued Qty</th></tr></thead><tbody>";
        }
        else
        {
            $getting_full_cut_details = "SELECT * FROM `bai_pro3`.`rejection_log_child` rc LEFT JOIN `brandix_bts`.`tbl_orders_ops_ref` ops
            ON ops.operation_code = rc.`operation_id`  WHERE parent_id = $recut_id and category = '$cat' group by input_job_no_random_ref,assigned_module,size_title";
            $table_data = "<table class = 'col-sm-12 table-bordered table-striped table-condensed cf'><thead class='cf'><tr><th>Sewing Job Number</th><th>Assigned Module</th><th>Size</th><th>Rejected Qty</th><th>Recut Allowed Qty</th><th>Replaced Qty</th><th>Remaining Qty</th><th>Issued Qty</th></tr></thead><tbody>";
        }
        $result_getting_full_cut_details = $link->query($getting_full_cut_details);
        $html .= '<div class="panel-group">
                    <div class="panel panel-success">
                        <div class="panel-heading">'.$row['category'].'</div>
                        <div class="panel-body">';
        while($row_cat = $result_getting_full_cut_details->fetch_assoc()) 
        {
            if(in_array($cat,$category))
            {
                $table_data .= "<tr><td>".$row_cat['doc_no']."</td>";
                $table_data .= "<td>".$row_cat['size_title']."</td>";
            }
            else
            {
                $table_data .= "<tr><td>".$row_cat['input_job_no_random_ref']."</td>";
                $table_data .= "<td>".$row_cat['assigned_module']."</td>";
                $table_data .= "<td>".$row_cat['size_title']."</td>";
            }
            $rej_qty = $row_cat['rejected_qty'];
            $recut_qty = $row_cat['recut_qty'];
            $replace_qty = $row_cat['replaced_qty'];
            $remaining_qty =  $rej_qty- ($recut_qty + $replace_qty);
            $table_data .= "<td>".$row_cat['rejected_qty']."</td>";
            $table_data .= "<td>".$row_cat['recut_qty']."</td>";
            $table_data .= "<td>".$row_cat['replaced_qty']."</td>";
            $table_data .= "<td>".$remaining_qty."</td>";
            $table_data .= "<td>".$row_cat['issued_qty']."</td>";
        }
        $table_data .= "</tr></tbody></table>";
        $html .= $table_data;
        // $html .= $table_data;
        $html .= '</div></div></div>';
        
        
    }
    echo $html;
}
if(isset($_GET['recut_id_edit']))
{
	$recut_id_edit = $_GET['recut_id_edit'];
	if($recut_id_edit != '')
	{
		RecutProcess($recut_id_edit);
	}
}
function RecutProcess($recut_id_edit)
{ 
    include("../../../../common/config/config_ajax.php");
    $recut_id = $recut_id_edit;
    $html = '';
    $qry_details = "SELECT style,SCHEDULE,color FROM `bai_pro3`.`rejections_log` r LEFT JOIN `bai_pro3`.`rejection_log_child` rc ON rc.`parent_id` = r.`id` 
    WHERE rc.`parent_id` = $recut_id";
    // echo $qry_details;
    $qry_details_res = $link->query($qry_details);
    while($row_row = $qry_details_res->fetch_assoc()) 
    {
        $style = $row_row['style'];
        $scheule = $row_row['SCHEDULE'];
        $color = $row_row['color'];
    }
    //getting order tid
    $qry_order_tid = "SELECT order_tid FROM `bai_pro3`.`bai_orders_db` WHERE order_style_no = '$style' AND order_del_no ='$scheule' AND order_col_des = '$color'";
    // echo $qry_order_tid;
    $res_qry_order_tid = $link->query($qry_order_tid);
    while($row_row_row = $res_qry_order_tid->fetch_assoc()) 
    {
        $order_tid = $row_row_row['order_tid'];
    }
    $categories="";
   // $sql="select tid,category from $bai_pro3.cat_stat_log where order_tid=\"$order_tid\" and length(category)>0";
    $sql="select tid,category from $bai_pro3.cat_stat_log where order_tid='CB1290C8       531632902WWC-BLACK                  ' and length(category)>0";
    // echo $sql;
    //echo $sql;
    $y=0;
    $categories="";
    $sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    // var_dump($sql_result);
    while($sql_row=mysqli_fetch_array($sql_result))
    {
        // var_dump($sql_row);
        $categories.="<input type=\"checkbox\" name=\"cat[]\" id='cat_$y' value=\"".$sql_row['category']."\">".$sql_row['category']."<br/>";
        $y=$y+1;
    }
    $html .= $categories;
    $get_details_qry = "SELECT DISTINCT category FROM `bai_pro3`.`rejection_log_child` rc LEFT JOIN `brandix_bts`.`tbl_orders_ops_ref` ops
    ON ops.operation_code = rc.`operation_id`  WHERE parent_id = $recut_id order by category";
//    echo $get_details_qry;
    $result_get_details_qry = $link->query($get_details_qry);
    while($row = $result_get_details_qry->fetch_assoc()) 
    {
        // var_dump($row);\
        $cat = $row['category'];
        $category=['cutting','Send PF','Receive PF'];
        if(in_array($cat,$category))
        {
            $getting_full_cut_details = "SELECT sum(rejected_qty)as rejected_qty,sum(replaced_qty)as replaced_qty,doc_no,size_title,size_id,assigned_module,input_job_no_random_ref,group_concat(rc.id)as ids,group_concat(bcd_id)as bcd_id  FROM `bai_pro3`.`rejection_log_child` rc LEFT JOIN `brandix_bts`.`tbl_orders_ops_ref` ops
            ON ops.operation_code = rc.`operation_id`  WHERE parent_id = $recut_id and category = '$cat' group by doc_no,size_title";
            // echo $getting_full_cut_details;
           $table_data = "<table class = 'col-sm-12 table-bordered table-striped table-condensed cf'><thead class='cf'><tr><th>Docket Number</th><th>Size</th><th>Rejected Qty</th><th>Recut Allowed Qty</th><th>Replaced Qty</th><th>Elegible to recut Qty</th><th>Recut Qty</th></tr></thead><tbody>";
        }
        else
        {
            $getting_full_cut_details = "SELECT sum(rejected_qty)as rejected_qty,sum(replaced_qty)as replaced_qty,doc_no,size_title,size_id,assigned_module,input_job_no_random_ref,group_concat(rc.id)as ids,group_concat(bcd_id)as bcd_id FROM `bai_pro3`.`rejection_log_child` rc LEFT JOIN `brandix_bts`.`tbl_orders_ops_ref` ops
            ON ops.operation_code = rc.`operation_id`  WHERE parent_id = $recut_id and category = '$cat' group by input_job_no_random_ref,assigned_module,size_title";
            $table_data = "<table class = 'col-sm-12 table-bordered table-striped table-condensed cf'><thead class='cf'><tr><th>Sewing Job Number</th><th>Assigned Module</th><th>Size</th><th>Rejected Qty</th><th>Recut Allowed Qty</th><th>Replaced Qty</th><th>Elegible to recut Qty</th><th>Recut Qty</th></tr></thead><tbody>";
        }
        // echo $getting_full_cut_details;
        $result_getting_full_cut_details = $link->query($getting_full_cut_details);
        $html .= '<div class="panel-group">
                    <div class="panel panel-success">
                        <div class="panel-heading">'.$row['category'].'</div>
                        <div class="panel-body">';
        while($row_cat = $result_getting_full_cut_details->fetch_assoc()) 
        {
            if(in_array($cat,$category))
            {
                $table_data .= "<tr><td>".$row_cat['doc_no']."</td>";
                $table_data .= "<td>".$row_cat['size_title']."</td>";
            }
            else
            {
                $table_data .= "<tr><td>".$row_cat['input_job_no_random_ref']."</td>";
                $table_data .= "<td>".$row_cat['assigned_module']."</td>";
                $table_data .= "<td>".$row_cat['size_title']."</td>";
            }
            $rej_qty = $row_cat['rejected_qty'];
            $recut_qty = $row_cat['recut_qty'];
            $replace_qty = $row_cat['replaced_qty'];
            $ids=$row_cat['ids'];
            $size = $row_cat['size_id'];
            $bcd_id = $row_cat['bcd_id'];
            $remaining_qty =  $rej_qty- ($recut_qty + $replace_qty);
            $table_data .= "<td>".$row_cat['rejected_qty']."</td>";
            $table_data .= "<td>".$row_cat['recut_qty']."</td>";
            $table_data .= "<td>".$row_cat['replaced_qty']."</td>";
            $table_data .= "<td>".$remaining_qty."</td>";
            $table_data .= "<td><input class='form-control integer' name='recutval[]' value='0'></td>";
            $table_data .= "<input type='hidden' name='ids[$bcd_id]' value='$ids'>";
            $table_data .= "<input type='hidden' name='size[]' value='$size'>";
            $table_data .= "<input type='hidden' name='bcd_ids[]' value='$bcd_id'>";
        }
        $table_data .= "</tr></tbody></table>";
        $html .= $table_data;
        $html .= '</div></div></div>';
        
    }
    echo $html;

}
if(isset($_GET['replace_id_edit']))
{
	$replace_id_edit = $_GET['replace_id_edit'];
	if($replace_id_edit != '')
	{
		ReplaceProcess($replace_id_edit);
	}
}
function ReplaceProcess($replace_id_edit)
{
    include("../../../../common/config/config_ajax.php");
    $appilication = 'IPS';
    $checking_output_ops_code = "SELECT operation_code from $brandix_bts.tbl_ims_ops where appilication='$appilication'";
    // echo $checking_output_ops_code;
    $result_checking_output_ops_code = $link->query($checking_output_ops_code);
    if($result_checking_output_ops_code->num_rows > 0)
    {
        while($row_result_checking_output_ops_code = $result_checking_output_ops_code->fetch_assoc()) 
        {
            $input_ops_code = $row_result_checking_output_ops_code['operation_code'];
        }

    }
    $qry_details = "SELECT style,SCHEDULE,color FROM `bai_pro3`.`rejections_log` r LEFT JOIN `bai_pro3`.`rejection_log_child` rc ON rc.`parent_id` = r.`id` 
    WHERE rc.`parent_id` = $replace_id_edit";
    // echo $qry_details;
    $qry_details_res = $link->query($qry_details);
    while($row_row = $qry_details_res->fetch_assoc()) 
    {
        $style = $row_row['style'];
        $scheule = $row_row['SCHEDULE'];
        $color = $row_row['color'];
    }
    //getting excess pieces
    $excess_table = '<div class="panel-group">
                        <div class="panel panel-success">
                            <div class="panel-heading">Size wise excess panel availability</div>
                            <div class="panel-body">';
    $excess_table .=  "<table class = 'col-sm-12 table-bordered table-striped table-condensed cf'><thead class='cf'><tr><th>Excess Sewing Job Number</th><th>Size</th><th>Excess Quantity available</th></tr></thead><tbody>";
    $qry_distinct_sizes = "select distinct size_id as size_id,size_title from $bai_pro3.rejection_log_child where parent_id = '$replace_id_edit'";
    $result_qry_distinct_sizes = $link->query($qry_distinct_sizes);
    while($replace_sizes = $result_qry_distinct_sizes->fetch_assoc()) 
    { 
        $size_replace =  $replace_sizes['size_id'];
        $excess_size_title = $replace_sizes['size_title'];
        $excess_job_qry = "SELECT GROUP_CONCAT(input_job_no_random)AS input_job_no_random_ref,SUM(carton_act_qty)as excess_qty FROM `bai_pro3`.`packing_summary_input` WHERE order_style_no = '$style' AND order_del_no = '$scheule' AND order_col_des = '$color' AND old_size = '$size_replace' AND type_of_sewing = '2'";
        // echo $excess_job_qry;
        $result_excess_job_qry = $link->query($excess_job_qry);
        // echo $result_excess_job_qry->num_rows.'</br>';
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
            $bcd_checking_qry = "select sum(recevied_qty)as rec_qty from $brandix_bts.bundle_creation_data_temp where input_job_no_random_ref in ($input_job_no_excess) and operation_id = '$input_ops_code'";
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
            $exces_qty = $exces_qty - ($rec_qty + $already_replaced_qty);
            $excess_table .= "<tr><td>".$input_job_no_excess."</td><td>".$excess_size_title."</td><td id='$excess_size_title'>".$exces_qty."     </td></tr>";
        }
       
    }
    $excess_table .= "</tbody></table></div></div></div>";
    $html .= $excess_table;
    $s_no = 1;
    $get_details_qry = "SELECT DISTINCT category FROM `bai_pro3`.`rejection_log_child` rc LEFT JOIN `brandix_bts`.`tbl_orders_ops_ref` ops
    ON ops.operation_code = rc.`operation_id`  WHERE parent_id = $replace_id_edit order by category";
//    echo $get_details_qry;
    $result_get_details_qry = $link->query($get_details_qry);
    while($row = $result_get_details_qry->fetch_assoc()) 
    {
        $cat = $row['category'];
        $category=['cutting','Send PF','Receive PF'];
        if(in_array($cat,$category))
        {
            $getting_full_cut_details = "SELECT *,group_concat(rc.id)as ids,group_concat(bcd_id)as bcd_id  FROM `bai_pro3`.`rejection_log_child` rc LEFT JOIN `brandix_bts`.`tbl_orders_ops_ref` ops
            ON ops.operation_code = rc.`operation_id`  WHERE parent_id = $replace_id_edit and category = '$cat' group by doc_no,size_title";
            // echo $getting_full_cut_details;
            $table_data = "<table class = 'col-sm-12 table-bordered table-striped table-condensed cf'><thead class='cf'><tr><th>Docket Number</th><th>Size</th><th>Rejected Qty</th><th>Recut Allowed Qty</th><th>Replaced Qty</th><th>Replace Qty</th></tr></thead><tbody>";
        }
        else
        {
            $getting_full_cut_details = "SELECT *,group_concat(rc.id)as ids,group_concat(bcd_id)as bcd_id FROM `bai_pro3`.`rejection_log_child` rc LEFT JOIN `brandix_bts`.`tbl_orders_ops_ref` ops
            ON ops.operation_code = rc.`operation_id`  WHERE parent_id = $replace_id_edit and category = '$cat' group by input_job_no_random_ref,assigned_module,size_title";
            $table_data = "<table class = 'col-sm-12 table-bordered table-striped table-condensed cf'><thead class='cf'><tr><th>Sewing Job Number</th><th>Assigned Module</th><th>Size</th><th>Rejected Qty</th><th>Recut Allowed Qty</th><th>Replaced Qty</th><th>Replace Qty</th></tr></thead><tbody>";
        }
        $result_getting_full_cut_details = $link->query($getting_full_cut_details);
        $html .= '<div class="panel-group">
                    <div class="panel panel-success">
                        <div class="panel-heading">'.$row['category'].'</div>
                        <div class="panel-body">';
                      
        while($row_cat = $result_getting_full_cut_details->fetch_assoc()) 
        {
            
            // echo $s_no.'</br>';
            if(in_array($cat,$category))
            {
                $table_data .= "<tr><td>".$row_cat['doc_no']."</td>";
                $size_html_id = $s_no.'size';
                $table_data .= "<td id ='$size_html_id'>".$row_cat['size_title']."</td>";
            }
            else
            {
                $size_html_id = $s_no.'size';
                $table_data .= "<tr><td>".$row_cat['input_job_no_random_ref']."</td>";
                $table_data .= "<td>".$row_cat['assigned_module']."</td>";
                $table_data .= "<td id ='$size_html_id'>".$row_cat['size_title']."</td>";
            }
            $rej_qty = $row_cat['rejected_qty'];
            $recut_qty = $row_cat['recut_qty'];
            $replace_qty = $row_cat['replaced_qty'];
            $ids=$row_cat['ids'];
            $size = $row_cat['size_id'];
            $bcd_id = $row_cat['bcd_id'];
            $size_title = $row_cat['size_title'];
            $remaining_qty =  $rej_qty- ($recut_qty + $replace_qty);
            $table_data .= "<td>".$row_cat['rejected_qty']."</td>";
            $table_data .= "<td>".$row_cat['recut_qty']."</td>";
            $table_data .= "<td>".$row_cat['replaced_qty']."</td>";
            //$table_data .= "<td>".$remaining_qty."</td>";
            // $size_string = "'".$size."'";
            // echo $size_string;
          //  $table_data .= "<td><input class='form-control integer' name='recutval[]' value='0' onchange='validationreplace($s_no,\"$size_title\")' ></td>";
          $table_data .= "<td><input class='form-control integer' id='$s_no' name='recutval[]' value='0'></td>";
            $table_data .= "<input type='hidden' id = '$s_no' value='$remaining_qty'>";
            $table_data .= "<input type='hidden' name='ids[$bcd_id]' value='$ids'>";
            $table_data .= "<input type='hidden' name='size[]' value='$size'>";
            $table_data .= "<input type='hidden' name='bcd_ids[]' value='$bcd_id'>";
            $s_no = $s_no+1;
        }
        $table_data .= "<input type='hidden' id='no_of_rows' value='$s_no'>";
        $table_data .= "</tr></tbody></table>";
        $html .= $table_data;
        $html .= '</div></div></div>';
    }
        echo $html;
}

?>