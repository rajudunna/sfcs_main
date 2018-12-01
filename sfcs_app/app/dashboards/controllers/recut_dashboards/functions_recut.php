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
            $getting_full_cut_details = "SELECT sum(recut_qty)as recut_qty,sum(rejected_qty)as rejected_qty,sum(replaced_qty)as replaced_qty,doc_no,size_title,size_id,assigned_module,input_job_no_random_ref,group_concat(rc.id)as ids,group_concat(bcd_id)as bcd_id FROM `bai_pro3`.`rejection_log_child` rc LEFT JOIN `brandix_bts`.`tbl_orders_ops_ref` ops
            ON ops.operation_code = rc.`operation_id`  WHERE parent_id = $recut_id and category = '$cat' group by doc_no,size_title";
           $table_data = "<table class = 'col-sm-12 table-bordered table-striped table-condensed cf'><thead class='cf'><tr><th>Docket Number</th><th>Size</th><th>Rejected Qty</th><th>Recut Allowed Qty</th><th>Replaced Qty</th><th>Remaining Qty</th><th>Issued Qty</th></tr></thead><tbody>";
        }
        else
        {
            $getting_full_cut_details = "SELECT sum(recut_qty)as recut_qty,sum(rejected_qty)as rejected_qty,sum(replaced_qty)as replaced_qty,doc_no,size_title,size_id,assigned_module,input_job_no_random_ref,group_concat(rc.id)as ids,group_concat(bcd_id)as bcd_id FROM `bai_pro3`.`rejection_log_child` rc LEFT JOIN `brandix_bts`.`tbl_orders_ops_ref` ops
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
        $categories.="<input type=\"checkbox\" name=\"cat[]\" id='cat_$y' value=\"".$sql_row['category']."\" required>".$sql_row['category']."<br/>";
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
            $getting_full_cut_details = "SELECT sum(recut_qty)as recut_qty,sum(rejected_qty)as rejected_qty,sum(replaced_qty)as replaced_qty,doc_no,size_title,size_id,assigned_module,input_job_no_random_ref,group_concat(rc.id)as ids,group_concat(bcd_id)as bcd_id  FROM `bai_pro3`.`rejection_log_child` rc LEFT JOIN `brandix_bts`.`tbl_orders_ops_ref` ops
            ON ops.operation_code = rc.`operation_id`  WHERE parent_id = $recut_id and category = '$cat' group by doc_no,size_title";
            // echo $getting_full_cut_details;
           $table_data = "<table class = 'col-sm-12 table-bordered table-striped table-condensed cf'><thead class='cf'><tr><th>Docket Number</th><th>Size</th><th>Rejected Qty</th><th>Recut Allowed Qty</th><th>Replaced Qty</th><th>Elegible to recut Qty</th><th>Recut Qty</th></tr></thead><tbody>";
        }
        else
        {
            $getting_full_cut_details = "SELECT sum(recut_qty)as recut_qty,sum(rejected_qty)as rejected_qty,sum(replaced_qty)as replaced_qty,doc_no,size_title,size_id,assigned_module,input_job_no_random_ref,group_concat(rc.id)as ids,group_concat(bcd_id)as bcd_id FROM `bai_pro3`.`rejection_log_child` rc LEFT JOIN `brandix_bts`.`tbl_orders_ops_ref` ops
            ON ops.operation_code = rc.`operation_id`  WHERE parent_id = $recut_id and category = '$cat' group by input_job_no_random_ref,assigned_module,size_title";
            $table_data = "<table class = 'col-sm-12 table-bordered table-striped table-condensed cf'><thead class='cf'><tr><th>Sewing Job Number</th><th>Assigned Module</th><th>Size</th><th>Rejected Qty</th><th>Recut Allowed Qty</th><th>Replaced Qty</th><th>Elegible to recut Qty</th><th>Recut Qty</th></tr></thead><tbody>";
        }
        // echo $getting_full_cut_details.'</br>';
        $result_getting_full_cut_details = $link->query($getting_full_cut_details);
        $html .= '<div class="panel-group">
                    <div class="panel panel-success">
                        <div class="panel-heading">'.$row['category'].'</div>
                        <div class="panel-body">';
        $s_no = 0;
        while($row_cat = $result_getting_full_cut_details->fetch_assoc()) 
        {
            $s_no++;
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
            $rem_string = $s_no.'rems';
            $table_data .= "<td id='$rem_string'>".$remaining_qty."</td>";
            $table_data .= "<td><input class='form-control integer' name='recutval[]' value='0' id='$s_no' onchange='validationrecutindividual($s_no)'></td>";
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
    $excess_table .=  "<table class = 'col-sm-12 table-bordered table-striped table-condensed cf'><thead class='cf'><tr><th>Excess Sewing Job Number</th><th>Size</th><th>Quantity Already Scanned</th><th>Quantity already replaced</th><th>Excess Quantity available</th></tr></thead><tbody>";
    $qry_distinct_sizes = "select distinct size_id as size_id,size_title from $bai_pro3.rejection_log_child where parent_id = '$replace_id_edit'";
    $result_qry_distinct_sizes = $link->query($qry_distinct_sizes);
    while($replace_sizes = $result_qry_distinct_sizes->fetch_assoc()) 
    { 
        $size_replace =  $replace_sizes['size_id'];
        $excess_size_title = $replace_sizes['size_title'];
        $excess_job_qry = "SELECT GROUP_CONCAT(input_job_no_random order by input_job_no_random)AS input_job_no_random_ref,SUM(carton_act_qty)as excess_qty FROM `bai_pro3`.`packing_summary_input` WHERE order_style_no = '$style' AND order_del_no = '$scheule' AND order_col_des = '$color' AND old_size = '$size_replace' AND type_of_sewing = '2'";
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
            $checking_replaced_or_not = "SELECT SUM(`replaced_qty`)AS replaced_qty FROM `bai_pro3`.`replacment_allocation_log` WHERE `input_job_no_random_ref` IN($input_job_no_excess)";
            // echo $checking_replaced_or_not;
             $result_checking_replaced_or_not = $link->query($checking_replaced_or_not);
             if($result_checking_replaced_or_not->num_rows > 0)
             {
                while($row_replace_already = $result_checking_replaced_or_not->fetch_assoc()) 
                {
                    $already_replaced_qty = $row_replace_already['replaced_qty'];
                }
            }
            $exces_qty = $exces_qty - ($rec_qty + $already_replaced_qty);
            if($rec_qty == '')
            {
                $rec_qty = 0;
            }
            if($already_replaced_qty == '')
            {
                $already_replaced_qty = 0;
            }
            $excess_table .= "<tr><td>".$input_job_no_excess."</td><td>".$excess_size_title."</td><td>$rec_qty</td><td>$already_replaced_qty</td><td id='$excess_size_title'>".$exces_qty."</td></tr>";
            $excess_table .= "<input type='hidden' name='input_job_no_random_ref_replace[$excess_size_title]' value='$input_job_no_excess'>";
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
            $getting_full_cut_details = "SELECT sum(recut_qty)as recut_qty,sum(rejected_qty)as rejected_qty,sum(replaced_qty)as replaced_qty,doc_no,size_title,size_id,assigned_module,input_job_no_random_ref,group_concat(rc.id)as ids,group_concat(bcd_id)as bcd_id,operation_id  FROM `bai_pro3`.`rejection_log_child` rc LEFT JOIN `brandix_bts`.`tbl_orders_ops_ref` ops
            ON ops.operation_code = rc.`operation_id`  WHERE parent_id = $replace_id_edit and category = '$cat' group by doc_no,size_title";
            // echo $getting_full_cut_details;
            $table_data = "<table class = 'col-sm-12 table-bordered table-striped table-condensed cf'><thead class='cf'><tr><th>Docket Number</th><th>Size</th><th>Rejected Qty</th><th>Recut Allowed Qty</th><th>Replaced Qty</th><th>Elegible to Replace</th><th>Replace Qty</th></tr></thead><tbody>";
        }
        else
        {
            $getting_full_cut_details = "SELECT sum(recut_qty)as recut_qty,sum(rejected_qty)as rejected_qty,sum(replaced_qty)as replaced_qty,doc_no,size_title,size_id,assigned_module,input_job_no_random_ref,group_concat(rc.id)as ids,group_concat(bcd_id)as bcd_id,operation_id FROM `bai_pro3`.`rejection_log_child` rc LEFT JOIN `brandix_bts`.`tbl_orders_ops_ref` ops
            ON ops.operation_code = rc.`operation_id`  WHERE parent_id = $replace_id_edit and category = '$cat' group by input_job_no_random_ref,assigned_module,size_title";
            $table_data = "<table class = 'col-sm-12 table-bordered table-striped table-condensed cf'><thead class='cf'><tr><th>Sewing Job Number</th><th>Assigned Module</th><th>Size</th><th>Rejected Qty</th><th>Recut Allowed Qty</th><th>Replaced Qty</th><th>Elegible to Replace</th><th>Replace Qty</th></tr></thead><tbody>";
        }
        // echo $getting_full_cut_details.'</br>';
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
            $operation_id = $row_cat['operation_id'];
            $remaining_qty =  $rej_qty- ($recut_qty + $replace_qty);
            $table_data .= "<td>".$row_cat['rejected_qty']."</td>";
            $table_data .= "<td>".$row_cat['recut_qty']."</td>";
            $table_data .= "<td>".$row_cat['replaced_qty']."</td>";
            $rem_string = $s_no.'rem';
            $table_data .= "<td id='$rem_string'>".$remaining_qty."</td>";
            // $size_string = "'".$size."'";
            // echo $size_string;
           $table_data .= "<td><input class='form-control integer' id='$s_no' name='replaceval[]' value='0' onchange='validationreplaceindividual($s_no)'></td>";
        //   $table_data .= "<td><input class='form-control integer' id='$s_no' name='recutval[]' value='0'></td>";
        
            $table_data .= "<input type='hidden' id = '$s_no' value='$remaining_qty'>";
            $table_data .= "<input type='hidden' name='ids[$bcd_id]' value='$ids'>";
            $table_data .= "<input type='hidden' name='size[]' value='$size_title'>";
            $table_data .= "<input type='hidden' name='operation_id[]' value='$operation_id'>";
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
if(isset($_GET['recut_doc_id']))
{
	$recut_doc_id = $_GET['recut_doc_id'];
	if($recut_doc_id != '')
	{
		getDocketDetails($recut_doc_id);
	}
}
function getDocketDetails($recut_doc_id)
{
    include("../../../../common/config/config_ajax.php");
    $get_details_qry = "SELECT DISTINCT category FROM `bai_pro3`.`recut_v2_child` rc LEFT JOIN `brandix_bts`.`tbl_orders_ops_ref` ops
    ON ops.operation_code = rc.`operation_id`  WHERE parent_id = $recut_doc_id order by category";
    $result_get_details_qry = $link->query($get_details_qry);
    while($row = $result_get_details_qry->fetch_assoc()) 
    {
        // var_dump($row);\
        $cat = $row['category'];
        $category=['cutting','Send PF','Receive PF'];
        if(in_array($cat,$category))
        {
            $getting_full_cut_details = "SELECT SUM(`recut_reported_qty`) AS recut_reported_qty,size_title,rejc.`doc_no`,SUM(rc.recut_qty)AS recut_qty,SUM(rc.rejected_qty)AS rejected_qty,SUM(rc.issued_qty)AS issued_qty,rc.parent_id, 
            size_title,size_id,assigned_module FROM `bai_pro3`.`recut_v2_child` rc 
            LEFT JOIN `brandix_bts`.`tbl_orders_ops_ref` ops ON ops.operation_code = rc.`operation_id` 
            LEFT JOIN `bai_pro3`.`rejection_log_child` rejc ON rejc.`bcd_id`=rc.`bcd_id` 
            WHERE rc.parent_id = '$recut_doc_id' AND category = '$cat' GROUP BY doc_no,size_title";
          $table_data = "<table class = 'col-sm-12 table-bordered table-striped table-condensed cf'><thead class='cf'><tr><th>Docket Number</th><th>Size</th><th>Rejected Qty</th><th>Recut Qty</th><th>Recut Reported Qty</th><th>Issued Qty</th><th>Remaining Qty</th></tr></thead><tbody>";
        }
        else
        {
            $getting_full_cut_details = "SELECT SUM(`recut_reported_qty`) AS recut_reported_qty,input_job_no_random_ref,assigned_module,size_title,SUM(rc.recut_qty)AS recut_qty,SUM(rc.rejected_qty)AS rejected_qty,SUM(rc.issued_qty)AS issued_qty,rc.parent_id, 
            size_title,size_id,assigned_module FROM `bai_pro3`.`recut_v2_child` rc 
            LEFT JOIN `brandix_bts`.`tbl_orders_ops_ref` ops ON ops.operation_code = rc.`operation_id`
            LEFT JOIN `bai_pro3`.`rejection_log_child` rejc ON rejc.`bcd_id`=rc.`bcd_id` 
            WHERE rc.parent_id = '$recut_doc_id' AND category = '$cat' GROUP BY input_job_no_random_ref,assigned_module,size_title";
           $table_data = "<table class = 'col-sm-12 table-bordered table-striped table-condensed cf'><thead class='cf'><tr><th>Sewing Job Number</th><th>Assigned Module</th><th>Size</th><th>Rejected Qty</th><th>Recut Qty</th><th>Recut Reported Qty</th><th>Issued Qty</th><th>Remaining Qty</th></tr></thead><tbody>";
        }
        // $getting_full_cut_details.'</br>';
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
            $issued_qty = $row_cat['issued_qty'];
            $recut_reported_qty = $row_cat['recut_reported_qty'];
            $remaining_qty =  $recut_reported_qty - $issued_qty;
            $table_data .= "<td>".$row_cat['rejected_qty']."</td>";
            $table_data .= "<td>".$row_cat['recut_qty']."</td>";
            $table_data .= "<td>".$row_cat['recut_reported_qty']."</td>";
            $table_data .= "<td>".$row_cat['issued_qty']."</td>";
            $table_data .= "<td>".$remaining_qty."</td>";
            // $table_data .= "<td>".$row_cat['issued_qty']."</td>";
        }
        $table_data .= "</tr></tbody></table>";
        $html .= $table_data;
        // $html .= $table_data;
        $html .= '</div></div></div>';
    }
    echo $html;
}

if(isset($_GET['markers_update_doc_id']))
{
	$markers_update_doc_id = $_GET['markers_update_doc_id'];
	if($markers_update_doc_id != '')
	{
		updatemarkers($markers_update_doc_id);
	}
}
function updatemarkers($markers_update_doc_id)
{
    include("../../../../common/config/config_ajax.php");
    $html = '';
    $qry_cut_qty_check_qry = "SELECT *,bd.`order_style_no`,bd.`order_col_des`,bd.`order_del_no` FROM bai_pro3.recut_v2 rv LEFT JOIN bai_pro3.`bai_orders_db` bd ON bd.`order_tid` = rv.`order_tid`  WHERE doc_no = '$markers_update_doc_id' ";
    // echo $qry_cut_qty_check_qry;
	$result_qry_cut_qty_check_qry = $link->query($qry_cut_qty_check_qry);
	while($row = $result_qry_cut_qty_check_qry->fetch_assoc()) 
	{
        // $doc_array[$row['doc_no']] = $row['act_cut_status'];
        $style = $row['order_style_no'];
        $schedule = $row['order_del_no'];
        $color = $row['order_col_des'];
        $a_plies = $row['a_plies'];
        $order_tid = $row['order_tid'];
        $remarks = $row['remarks'];
		for ($i=0; $i < sizeof($sizes_array); $i++)
		{ 
			if ($row['a_'.$sizes_array[$i]] > 0)
			{
				$cut_done_qty[$sizes_array[$i]] = $row['a_'.$sizes_array[$i]];
			}
		}
    }
    $html .= '<div class="panel-group">
                <div class="panel panel-success">
                    <div class="panel-heading">Update Markers</div>
                    <div class="panel-body">';
    $html .= "<div class='row'>
                <div class='col-md-4'>Style:$style</div>
                <div class='col-md-4'>Schedule:$schedule</div>
                <div class='col-md-4'>Color:$color</div>
            </div>";
    $html .= '</br></br>';
    $html .= "<div class='row'>
                <div class='col-md-3'></div>
                <div class='col-md-3'><b>Marker Length</b>:<input class='form-control integer' name='mklen' value='0' required></td></div>
                <div class='col-md-3'><b>Plies </b>:<input class='form-control integer' name='plies' value='$a_plies' required></td></div>
                <div class='col-md-3'></div>
            </div>";
    $html .= '</br></br>';
    $table_data .= "<table class = 'col-sm-12 table-bordered table-striped table-condensed cf'><thead class='cf'><tr><th>Size</th><th>Quantity</th><th style='width: 29%;'>Ratio</th></tr></thead><tbody>";
    foreach($cut_done_qty as $key=>$value)
    {
        $table_data .= "<input type='hidden' name ='size[]' value ='$key'>";
        $quantity = $value*$a_plies;
        $table_data .= "<tr><td>$key</td><td>$quantity</td><td><input class='form-control integer' name='ratioval[$key][]' value='$value' required></td></tr>";
    }
    //$qry_to_get = "SELECT * FROM  `bai_pro3`.`cat_stat_log` WHERE  order_tid = \"$order_tid\" and category = 'Body'";
    $qry_to_get = "SELECT * FROM  `bai_pro3`.`cat_stat_log` WHERE  order_tid = 'CA3428F8       540734415 5GXBlue Granite           ' and category = 'Body'";
    $res_qry_to_get = $link->query($qry_to_get);
    while($row_cat_ref = $res_qry_to_get->fetch_assoc()) 
    {
        $cat_ref =$row_cat_ref['tid'];

    }
    $table_data .= "<input type='hidden' name ='style' value ='$style'>";
    $table_data .= "<input type='hidden' name ='schedule' value ='$schedule'>";
    $table_data .= "<input type='hidden' name ='color' value ='$color'>";
    $table_data .= "<input type='hidden' name ='cat' value ='$cat_ref'>";
    $table_data .= "<input type='hidden' name ='order_tid' value ='$order_tid'>";
    $table_data .= "<input type='hidden' name ='module' value ='0'>";
    $table_data .= "<input type='hidden' name ='cat_name' value ='$remarks'>";
    $table_data .= "<input type='hidden' name ='doc_no_ref' value ='$markers_update_doc_id'>";


    $table_data .= "</tbody></table>";
    $html .= $table_data;
    $html .= '</div></div></div>';
    echo $html;
}
if(isset($_GET['markers_view_docket']))
{
	$markers_view_docket = $_GET['markers_view_docket'];
	if($markers_view_docket != '')
	{
		Markersview($markers_view_docket);
	}
}
function Markersview($markers_view_docket)
{
    $markers_view_docket_ary = explode(",",$markers_view_docket);
    $markers_view_docket =$markers_view_docket_ary[0];
    $flag =$markers_view_docket_ary[1];
    include("../../../../common/config/config_ajax.php");
    //getting order tid 
    $qry_cut_qty_check_qry = "SELECT *,bd.`order_style_no`,bd.`order_col_des`,bd.`order_del_no` FROM bai_pro3.recut_v2 rv 
    LEFT JOIN bai_pro3.`bai_orders_db_confirm` bd ON bd.`order_tid` = rv.`order_tid`
    LEFT JOIN bai_pro3.maker_stat_log m ON m.tid = rv.`mk_ref`
    WHERE doc_no =  '$markers_view_docket'";
    // echo $qry_cut_qty_check_qry;
	$result_qry_cut_qty_check_qry = $link->query($qry_cut_qty_check_qry);
	while($row = $result_qry_cut_qty_check_qry->fetch_assoc()) 
	{
        // $doc_array[$row['doc_no']] = $row['act_cut_status'];
        $style = $row['order_style_no'];
        $schedule = $row['order_del_no'];
        $color = $row['order_col_des'];
        $a_plies = $row['a_plies'];
        $order_tid = $row['order_tid'];
        $mk_length = $row['mklength'];
        $rm = $mk_length * $a_plies;
        for ($i=0; $i < sizeof($sizes_array); $i++)
		{ 
			if ($row['a_'.$sizes_array[$i]] > 0)
			{
				$cut_done_qty[$sizes_array[$i]] = $row['a_'.$sizes_array[$i]];
			}
		}
    }
    $html .= '<div class="panel-group">
                <div class="panel panel-success">
                    <div class="panel-heading">Markers</div>
                    <div class="panel-body">';
    $html .= "<div class='row'>
                <div class='col-md-4'>Style:$style</div>
                <div class='col-md-4'>Schedule:$schedule</div>
                <div class='col-md-4'>Color:$color</div>
            </div>";
    $html .= '</br></br>';
    $html .= "<div class='row'>
                <div class='col-md-4'><b>Marker Length</b>:$mk_length</td></div>
                <div class='col-md-4'><b>Plies </b>:$a_plies</td></div>
                <div class='col-md-4'><b>Required Materials </b>:$rm</td></div>
            </div>";
    $html .= '</br></br>';
    $table_data .= "<table class = 'col-sm-12 table-bordered table-striped table-condensed cf'><thead class='cf'><tr><th>Size</th><th>Quantity</th><th style='width: 29%;'>Ratio</th></tr></thead><tbody>";
    foreach($cut_done_qty as $key=>$value)
    {
        $retriving_size = "SELECT size_title FROM `bai_pro3`.`recut_v2_child` rc 
        LEFT JOIN `bai_pro3`.`recut_v2` r ON r.`doc_no` = rc.`parent_id`
        LEFT JOIN `bai_pro3`.`rejection_log_child` rejc ON rejc.`bcd_id` = rc.`bcd_id`
        WHERE rc.parent_id = $markers_view_docket AND rejc.`size_id` = '$key'";
        // echo $retriving_size;
         $res_retriving_size = $link->query($retriving_size);
         while($row_size = $res_retriving_size->fetch_assoc()) 
         {
            $size_title_ind = $row_size['size_title'];
         }
        $table_data .= "<input type='hidden' name ='size[]' value ='$key'>";
        $quantity = $value*$a_plies;
        $table_data .= "<tr><td>$size_title_ind</td><td>$quantity</td><td>$value</td></tr>";
    }
    //$qry_to_get = "SELECT * FROM  `bai_pro3`.`cat_stat_log` WHERE  order_tid = \"$order_tid\" and category = 'Body'";
    $qry_to_get = "SELECT * FROM  `bai_pro3`.`cat_stat_log` WHERE  order_tid = 'CA3428F8       540734415 5GXBlue Granite           ' and category = 'Body'";
    $res_qry_to_get = $link->query($qry_to_get);
    while($row_cat_ref = $res_qry_to_get->fetch_assoc()) 
    {
        $cat_ref =$row_cat_ref['tid'];

    }
    $html .= "<input type=\"hidden\" name=\"order_tid\" value=\"$order_tid\">";
    $html .= "<input type=\"hidden\" name=\"doc_no_ref\" value=\"$markers_view_docket\">";
    $html .= "<input type=\"hidden\" name=\"code_no_ref\" value='2'>";
    $table_data .= "</tbody></table>";
    $html .= $table_data;
    $shifts_array = ["","Available","Not Available"];
    $html .= "<div class='row'><div class='col-md-3'></div><div class='col-md-3'></div><div class='col-md-3'>";
    if($flag == 1)
    {
        $drp_down = '<label>Required Materials: <span style="color:red">*</span></label>
        <select class="form-control rm"  name="status" id="rm" style="width:100%;" required><option value="" required>Select Availability</option>';
        for ($i=1; $i <= 2; $i++) 
        {
            $drp_down .= '<option value='.$i.'>'.$shifts_array[$i].'</option>';
        }
        $html .= $drp_down;
        $html .= "</select></div><div class='col-md-3'></br><input type='submit' class='btn btn-primary' value='Submit' name='formSubmit'></div></div>"; 
     
    }
    $html .= '</div></div></div>';
    echo $html;
    // if($order_status=="")
    // {
    //     // echo "working";
    //     $sql1="SELECT v.mk_ref,v.a_plies,v.remarks,m.mklength 
    //     FROM $bai_pro3.recut_v2 v LEFT JOIN $bai_pro3.maker_stat_log m ON v.mk_ref=m.tid 
    //     WHERE  v.doc_no = $markers_view_docket";
    //     $sql_result1=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    //     while($sql_row1=mysqli_fetch_array($sql_result1))
    //     {
    //         echo "<h2>".$sql_row1['remarks']."- ".($sql_row1['a_plies']*$sql_row1['mklength'])."</h2>";
    //     }
        
        
    //     echo "<form method=\"post\" name=\"test\" action=\""."$path4"."\">";
    //     echo "<input type=\"hidden\" name=\"order_tid\" value=\"$order_tid\">";
    //     echo "<input type=\"hidden\" name=\"cut_no_ref\" value=\"$cut_no_ref\">";
    //     echo "<input type=\"hidden\" name=\"doc_no_ref\" value=\"$doc_no\">";
    //     echo "<input type=\"hidden\" name=\"code_no_ref\" value=\"$code\">";
        
    //     echo "RM Fabric Status:<select name=\"status\">";
    //     $status=array("","Available","Not Available");
    //     for($i=1;$i<=2;$i++)
    //     {
    //         if($fab_status==$i)
    //         {
    //             echo "<option value=\"$i\" selected>".$status[$i]."</option>";
    //         }
    //         else
    //         {
    //             echo "<option value=\"$i\">".$status[$i]."</option>";
    //         }
    //     }
    //     echo "</select>";
        
    //     echo "<input type=\"submit\" name=\"update\" value=\"Update\">";
    //     echo "</form>";
            
    // }
    // else
    // {
    //     echo "<h2 style='color:red;'> Order Status has closed for this schedule: <h2/>".$schedule."<br/>";
    //     echo "<h2> Please check with the Planning Team <h2/>";
    // }
}
if(isset($_GET['issued_to_module_process']))
{
	$issued_to_module_process = $_GET['issued_to_module_process'];
	if($issued_to_module_process != '')
	{
		IssuedtoModuleProcess($issued_to_module_process);
	}
}
function IssuedtoModuleProcess($issued_to_module_process)
{
    include("../../../../common/config/config_ajax.php");
    $recut_doc_id = $issued_to_module_process;
    $get_details_qry = "SELECT DISTINCT category FROM `bai_pro3`.`recut_v2_child` rc LEFT JOIN `brandix_bts`.`tbl_orders_ops_ref` ops
    ON ops.operation_code = rc.`operation_id`  WHERE parent_id = $recut_doc_id order by category";
    $result_get_details_qry = $link->query($get_details_qry);
    while($row = $result_get_details_qry->fetch_assoc()) 
    {
        // var_dump($row);\
        $cat = $row['category'];
        $category=['cutting','Send PF','Receive PF'];
        if(in_array($cat,$category))
        {
            $getting_full_cut_details = "SELECT GROUP_CONCAT(rc.bcd_id)as bcd_id,SUM(`recut_reported_qty`) AS recut_reported_qty,size_title,rejc.`doc_no`,SUM(rc.recut_qty)AS recut_qty,SUM(rc.rejected_qty)AS rejected_qty,SUM(rc.issued_qty)AS issued_qty,rc.parent_id, 
            size_title,size_id,assigned_module FROM `bai_pro3`.`recut_v2_child` rc 
            LEFT JOIN `brandix_bts`.`tbl_orders_ops_ref` ops ON ops.operation_code = rc.`operation_id` 
            LEFT JOIN `bai_pro3`.`rejection_log_child` rejc ON rejc.`bcd_id`=rc.`bcd_id` 
            WHERE rc.parent_id = '$recut_doc_id' AND category = '$cat' GROUP BY doc_no,size_title";
          $table_data = "<table class = 'col-sm-12 table-bordered table-striped table-condensed cf'><thead class='cf'><tr><th>Docket Number</th><th>Size</th><th>Rejected Qty</th><th>Recut Qty</th><th>Recut Reported Qty</th><th>Issued Qty</th><th>Remaining Qty</th><th>Issuing Quantity</th></tr></thead><tbody>";
        }
        else
        {
            $getting_full_cut_details = "SELECT GROUP_CONCAT(rc.bcd_id)as bcd_id,SUM(`recut_reported_qty`) AS recut_reported_qty,input_job_no_random_ref,assigned_module,size_title,SUM(rc.recut_qty)AS recut_qty,SUM(rc.rejected_qty)AS rejected_qty,SUM(rc.issued_qty)AS issued_qty,rc.parent_id, 
            size_title,size_id,assigned_module FROM `bai_pro3`.`recut_v2_child` rc 
            LEFT JOIN `brandix_bts`.`tbl_orders_ops_ref` ops ON ops.operation_code = rc.`operation_id`
            LEFT JOIN `bai_pro3`.`rejection_log_child` rejc ON rejc.`bcd_id`=rc.`bcd_id` 
            WHERE rc.parent_id = '$recut_doc_id' AND category = '$cat' GROUP BY input_job_no_random_ref,assigned_module,size_title";
           $table_data = "<table class = 'col-sm-12 table-bordered table-striped table-condensed cf'><thead class='cf'><tr><th>Sewing Job Number</th><th>Assigned Module</th><th>Size</th><th>Rejected Qty</th><th>Recut Qty</th><th>Recut Reported Qty</th><th>Issued Qty</th><th>Remaining Qty</th><th>Issuing Quantity</th></tr></thead><tbody>";
        }
        // $getting_full_cut_details.'</br>';
        $result_getting_full_cut_details = $link->query($getting_full_cut_details);
        $html .= '<div class="panel-group">
                    <div class="panel panel-success">
                        <div class="panel-heading">'.$row['category'].'</div>
                        <div class="panel-body">';
        $s_no = 0;
        while($row_cat = $result_getting_full_cut_details->fetch_assoc()) 
        {
            $s_no++;
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
            $recut_reported_qty = $row_cat['recut_reported_qty'];
            $rej_qty = $row_cat['rejected_qty'];
            $recut_qty = $row_cat['recut_qty'];
            $issued_qty = $row_cat['issued_qty'];
            $remaining_qty =  $recut_reported_qty - $issued_qty;
            $table_data .= "<td>".$row_cat['rejected_qty']."</td>";
            $table_data .= "<td>".$row_cat['recut_qty']."</td>";
            $table_data .= "<td>".$row_cat['recut_reported_qty']."</td>";
            $table_data .= "<td>".$row_cat['issued_qty']."</td>";
            $s_no_rem = $s_no."rem";
            $table_data .= "<td id='$s_no_rem'>".$remaining_qty."</td>";
            $bcd_id = $row_cat['bcd_id'];
            $table_data .= "<input type='hidden' name='doc_no_ref' value='$issued_to_module_process'>";
            $table_data .= "<input type='hidden' name='bcd_id[]' value='$bcd_id'>";
            $table_data .= "<td><input class='form-control integer' name='issueval[]' value='0' id='$s_no' onchange='validatingremaining($s_no)' required></td>";
        }
        $table_data .= "</tr></tbody></table>";
        $html .= $table_data;
        // $html .= $table_data;
        $html .= '</div></div></div>';
    }
    echo $html;

}
?>