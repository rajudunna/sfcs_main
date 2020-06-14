<?php include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',4,'R')); ?>
<?php include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/functions_dashboard.php',4,'R'));  ?>
<?php

$html1 = '';
$tabledata = '';
$sizes_reference="";
$cuttable_sum=0;
$style=style_decode($_GET['style']);
$schedule=$_GET['schedule'];
$color=color_decode($_GET['color']);
echo "<a class=\"btn btn-xs btn-warning\" href=\"".getFullURLLevel($_GET['r'], "recut_dashboard_view.php", "0", "N")."\"><i class=\"fas fa-arrow-left\"></i>&nbsp; Click here to Go Back</a>";
$html1 .= "<div class='panel panel-primary'>
    <div class='panel-heading'>Recut Layplan Request</div>
    <div class='panel-body'>";
    $qry_order_tid = "SELECT order_tid FROM `$bai_pro3`.`bai_orders_db` WHERE order_style_no = '$style' AND order_del_no ='$schedule' AND order_col_des = '$color'";
    $res_qry_order_tid = $link->query($qry_order_tid);
    while($row_row_row = $res_qry_order_tid->fetch_assoc()) 
    {
        $order_tid = $row_row_row['order_tid'];
    }
    $sql_cat="select * from $bai_pro3.cat_stat_log where order_tid=\"$order_tid\" and category in ($in_categories)";
    $sql_result_cat=mysqli_query($link, $sql_cat) or exit("Sql Error555".mysqli_error($GLOBALS["___mysqli_ston"]));
    while($sql_row_cat=mysqli_fetch_array($sql_result_cat))
    {
        $cat_ref_id=$sql_row_cat['tid'];
    }
    $sql111="select * from $bai_pro3.cuttable_stat_log_recut where order_tid=\"$order_tid\"";	
    $sql_result111=mysqli_query($link, $sql111) or exit("Sql Error111".mysqli_error($GLOBALS["___mysqli_ston"]));
    if(mysqli_num_rows($sql_result111)>0){
        $sql="select * from $bai_pro3.bai_orders_db_confirm where order_style_no=\"$style\" and order_del_no=\"$schedule\" and order_col_des=\"$color\"";
        $sql_result=mysqli_query($link, $sql) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
        if(mysqli_num_rows($sql_result)>0)
        {
            $sql="select * from $bai_pro3.bai_orders_db_confirm where order_style_no=\"$style\" and order_del_no=\"$schedule\" and order_col_des=\"$color\"";	
            $ord_tbl_name="$bai_pro3.bai_orders_db_confirm";
        }
        else
        {
            $sql="select * from $bai_pro3.bai_orders_db where order_style_no=\"$style\" and order_del_no=\"$schedule\" and order_col_des=\"$color\"";	
            $ord_tbl_name="$bai_pro3.bai_orders_db";
        }
        $sql_result=mysqli_query($link, $sql) or exit("Sql Error-0".mysqli_error($GLOBALS["___mysqli_ston"]));
        $sql_num_check=mysqli_num_rows($sql_result);
        while($sql_row=mysqli_fetch_array($sql_result))
        {
            $tran_order_tid=$sql_row['order_tid'];
            for($s=0;$s<sizeof($sizes_code);$s++)
            {
                if($sql_row["title_size_s".$sizes_code[$s].""]<>'')
                {
                    $s_tit[$sizes_code[$s]]=$sql_row["title_size_s".$sizes_code[$s].""];
                }	
            }
        }
    }
    $sql="select * from $bai_pro3.cuttable_stat_log_recut where order_tid=\"$tran_order_tid\" and cat_id=$cat_ref_id order by tid";
    $sql_result44=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
    $html1 .= "<table class=\"table table-bordered\">";
    $html1 .= "<thead><tr><th class=\"column-title\" style='width:190px;'>Sizes</th>";
    for($s=0;$s<sizeof($s_tit);$s++)
    {
        $html1 .= "<th class=\"column-title\">".$s_tit[$sizes_code[$s]]."</th>";
    }
    $html1 .= "<th class=\"title\">Total</th>";
    $html1 .= "<th class=\"title\">Status</th>";
    $html1 .= "</tr></thead>";
    $i=1;
    while($sql_row1_recut2=mysqli_fetch_array($sql_result44))
    {
        $o_total12=0;
        for($s=0;$s<sizeof($sizes_code);$s++)
        {
            $s_ord12[$s]=$sql_row1_recut2["cuttable_s_s".$sizes_code[$s].""];
            $o_total12 += $sql_row1_recut2["cuttable_s_s".$sizes_code[$s]];
        }
        $serial_no=$sql_row1_recut2['serial_no'];
        //To get Encoded Color & style
        $main_style = style_encode($style);
        $main_color = color_encode($color);
        $html1 .= "<tr ><th><a class=\"btn btn-info btn-xs\" href=\"".getFullURLLevel($_GET['r'], "recut_lay_plan.php", "0", "N")."&color=$main_color&style=$main_style&schedule=$schedule&serial_no=$serial_no\">Request - $i</a></th>";
        for($s=0;$s<sizeof($s_tit);$s++)
        {
            $html1 .= "<td class=\"sizes\">".$s_ord12[$s]."</td>";
        }

        $html1 .= "<td class=\"sizes\">".$o_total12."</td>";
        $plndoc_qry = "select * from  `$bai_pro3`.`plandoc_stat_log` where order_tid=\"$tran_order_tid\" and cuttable_ref=".$sql_row1_recut2['tid'];
        $plndoc_qry_res = mysqli_query($link,$plndoc_qry);
        // echo $plndoc_qry;
        if(mysqli_num_rows($plndoc_qry_res)>0)
        {
            $get_cat_ref_query="SELECT cat_ref,tid,cuttable_ref,mk_status,remarks FROM $bai_pro3.allocate_stat_log WHERE order_tid=\"$tran_order_tid\" and serial_no=$serial_no";
            // echo $get_cat_ref_query;
            $cat_ref_result=mysqli_query($link, $get_cat_ref_query) or exit("Sql Error22".mysqli_error($GLOBALS["___mysqli_ston"]));
            $rows_count = mysqli_num_rows($cat_ref_result);
            
            if(mysqli_num_rows($cat_ref_result) == mysqli_num_rows($plndoc_qry_res)){
                $html1 .= "<th><a class='btn btn-primary btn-xs' disabled>Docket Generated</a></th>";
            } else {
                $html1 .= "<th><a class='btn btn-primary btn-xs' disabled>Docket Partially Generated</a></th>";
            }
        } else {
            $html1 .= "<th><a class='btn btn-primary btn-xs' disabled>Docket Not Generated</a></th>";

        }
        $html1 .= "</tr>";
        $i++;
    }
    
    $html1 .= "</table>";
    $html1 .= "</tbody></table>";
    $html1 .="</div></div>";
    echo $html1;
?>