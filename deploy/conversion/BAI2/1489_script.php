
<?php
//searching the bcd_id in rejection log child or not
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config_ajax.php');
echo "Started<br/>";
$bcd_qry ="SELECT bcd.id AS id,SUM(qms_qty) AS qrej,SUM(rejected_qty) AS rejected_qty,
            style,schedule,color,docket_number,input_job_no_random_ref,bcd.size_id,
            bcd.size_title,assigned_module,bcd.operation_id            
            FROM bai_pro3.bai_qms_db bqd
            LEFT JOIN brandix_bts.bundle_creation_data bcd ON bcd.bundle_number = bqd.bundle_no AND bcd.operation_id = bqd.operation_id
            WHERE log_date < '2019-01-26' AND qms_tran_type = 3
            AND bqd.operation_id IN (900,130,100)
            GROUP BY bundle_no,bqd.operation_id
            HAVING rejected_qty = qrej";
// echo $bcd_qry.'</br>';
$bcd_qry_result=mysqli_query($link,$bcd_qry) or exit("Initial Query Error".mysqli_error($GLOBALS["___mysqli_ston"]));
echo "Running<br/>";
while($bcd_qry_result_row=mysqli_fetch_array($bcd_qry_result))
{
    
    $bcd_id = $bcd_qry_result_row['id'];
    $implode_next[2] = $bcd_qry_result_row['rejected_qty'];
    $style = $bcd_qry_result_row['style'];
    $schedule = $bcd_qry_result_row['schedule'];
    $color = $bcd_qry_result_row['color'];
    $size_title = $bcd_qry_result_row['size_title'];
    $size_id = $bcd_qry_result_row['size_id'];
    $input_job_random_ref = $bcd_qry_result_row['input_job_no_random_ref'];
    $doc_no = $bcd_qry_result_row['docket_number'];
    $b_op_id = $bcd_qry_result_row['operation_id'];
    $assigned_module = $bcd_qry_result_row['assigned_module'];

    $bcd_id_searching_qry = "select id,parent_id from $bai_pro3.rejection_log_child where bcd_id = $bcd_id";
    // echo $bcd_id_searching_qry;
    $bcd_id_searching_qry_result=mysqli_query($link,$bcd_id_searching_qry) or exit("bcd_id_searching_qry_result".mysqli_error($GLOBALS["___mysqli_ston"]));
    if($bcd_id_searching_qry_result->num_rows > 0)
    {
        while($bcd_id_searching_qry_result_row=mysqli_fetch_array($bcd_id_searching_qry_result))
        {
            $parent_id = $bcd_id_searching_qry_result_row['parent_id'];
        }
        $update_rejection_log_child_qry = "update $bai_pro3.rejection_log_child set rejected_qty=rejected_qty+$implode_next[2] where bcd_id = $bcd_id";
        mysqli_query($link,$update_rejection_log_child_qry) or exit("update_rejection_log_child_qry".mysqli_error($GLOBALS["___mysqli_ston"]));
        $update_qry_rej_lg = "update $bai_pro3.rejections_log set rejected_qty = rejected_qty+$implode_next[2],remaining_qty=remaining_qty+$implode_next[2] where style='$style' and schedule='$schedule' and color='$color'";
        $update_qry_rej_lg = $link->query($update_qry_rej_lg);
    }
    else
    {
        $search_qry="SELECT id FROM $bai_pro3.rejections_log where style='$style' and schedule='$schedule' and color='$color'";
        // echo $search_qry;
        $result_search_qry = mysqli_query($link,$search_qry) or exit("rejections_log search query".mysqli_error($GLOBALS["___mysqli_ston"]));
        if($result_search_qry->num_rows > 0)
        {
            while($row_result_search_qry=mysqli_fetch_array($result_search_qry))
            {

                $rejection_log_id = $row_result_search_qry['id'];
                $update_qry_rej_lg = "update $bai_pro3.rejections_log set rejected_qty = rejected_qty+$implode_next[2],remaining_qty=remaining_qty+$implode_next[2] where id = $rejection_log_id";
                // echo $update_qry_rej_lg;
                $update_qry_rej_lg = $link->query($update_qry_rej_lg);
                $parent_id = $rejection_log_id;
            }

        }
        else
        {
            $insert_qty_rej_log = "INSERT INTO bai_pro3.rejections_log (style,schedule,color,rejected_qty,recut_qty,remaining_qty) VALUES ('$style','$schedule','$color',$implode_next[2],'0',$implode_next[2])";
            $res_insert_qty_rej_log = $link->query($insert_qty_rej_log);
            $parent_id=mysqli_insert_id($link);
        }
        $inserting_into_rejection_log_child_qry = "INSERT INTO `bai_pro3`.`rejection_log_child` (`parent_id`,`bcd_id`,`doc_no`,`input_job_no_random_ref`,`size_id`,`size_title`,`assigned_module`,`rejected_qty`,`operation_id`) values($parent_id,$bcd_id,$doc_no,$input_job_random_ref,'$size_id','$size_title',$assigned_module,$implode_next[2],$b_op_id)";
        $insert_qry_rej_child = $link->query($inserting_into_rejection_log_child_qry);
    }
}
echo "Success";