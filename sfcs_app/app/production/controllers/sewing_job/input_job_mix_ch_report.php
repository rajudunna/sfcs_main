
<?php
error_reporting(0);
$schedule1=$schedule;

// echo $c_ref;
// echo $schedule.'<br>';
// echo $schedule1.'<br>';
// die();
//include("style_header_info.php");

//Check to have schedule clubbing
$sql="select order_joins from $bai_pro3.bai_orders_db_confirm where order_joins='J$schedule'";
//echo $sql."<br>";
$sql_result=mysqli_query($link, $sql) or exit("Sql Error88 $sql".mysqli_error($GLOBALS["___mysqli_ston"]));
$bai_orders_db_confirm='';$bai_orders_db='';$plandoc_stat_log='';
    for($j=0;$j<sizeof($sizes_array);$j++)
    {
        $bai_orders_db_confirm.="bai_orders_db_confirm.order_s_".$sizes_array[$j]."+";
    }
    $query=substr($bai_orders_db_confirm,0,-1);
if(mysqli_num_rows($sql_result)>0)
{
    $sql="select group_concat(order_del_no order by order_qty) as order_del_no from (select distinct order_del_no as order_del_no, ($query) as order_qty from $bai_pro3.bai_orders_db_confirm where order_joins='J$schedule') as tem order by order_qty";
    // echo '<br>'.$sql.'<br>';
    $sql_result=mysqli_query($link, $sql) or exit("Sql Error88 $sql".mysqli_error($GLOBALS["___mysqli_ston"]));
    while($sql_row=mysqli_fetch_array($sql_result))
    {
        $schedule=$sql_row['order_del_no'];
    }
}

$no_of_cartons_Query="SELECT GROUP_CONCAT(DISTINCT TRIM(COLOR) ORDER BY COLOR) AS combo_color,combo_no,no_of_cartons FROM brandix_bts.`tbl_carton_size_ref` WHERE parent_id ='".$c_ref."' GROUP BY COMBO_NO";
// echo '<br>'.$no_of_cartons_Query.'<br>';
$sql_result=mysqli_query($link, $no_of_cartons_Query) or exit("Sql Error88 $no_of_cartons_Query".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row=mysqli_fetch_array($sql_result))
{
    $combo_col[]=$sql_row['combo_color'];
    $combo[]=$sql_row['combo_no'];
    $no_of_cartons[]=$sql_row['no_of_cartons'];
}
$url1 = getFullURLLevel($_GET['r'],'print_input_sheet.php',0,'R');
$url2 = getFullURLLevel($_GET['r'],'print_input_sheet_mm.php',0,'R');

echo '<br>
<div class="panel panel-primary panel-body">

    <div class="row">';       
        echo "<a class='btn btn-warning' href='$url1?schedule=$schedule' onclick=\"return popitup2('$url1?schedule=$schedule')\" target='_blank'>Print Sewing Job Sheet - Job Wise</a>      ";
        echo "<a class='btn btn-warning' href='$url2?schedule=$schedule' onclick=\"return popitup2('$url2?schedule=$schedule')\" target='_blank'>Print Sewing Job Sheet - Split Wise</a>";
    echo '</div>';

    echo '<div class="row">';       
        for($ii=0;$ii<sizeof($combo);$ii++)
        {
            echo "<h4><span class=\"label label-info\">Number of Cartons: <b>$no_of_cartons[$ii]</b> Per Sewing Job of combo no - $combo[$ii] & Combo Colors (".$combo_col[$ii].")</span></h4>";
        }
        echo '<h4><span class="label label-info">Note: </span>Yellow Color indicates Excess/Sample Job</h4>';
    echo '</div>';

    echo '<form name="new" method="post" action="?r='.$_GET['r'].'">';

            echo '<input type="hidden" name="mix_colors" value="'.$mix_colors.'">';
            echo '<input type="hidden" name="job_qty" value="'.$job_qty.'">';

            echo "<div class='row'>
                <table class='table table-bordered'>";
                    echo "<tr>";
                    echo "<th>Schedule</th>";
                    echo "<th>Color Set</th>";
                    echo "<th>Cut Job#</th>";
                    echo "<th>Size Set</th>";
                    echo "<th>Total Sewing Job Quantity</th>";
                    echo "<th>Sewing Job Sheet</th>";

                    if($scanning_methods="Bundle Level")
                    {
                        echo "<th>Bundle Barcode</th>";
                    }
                    //echo "<th>TID</th>";
                    //echo "<th>Doc# Ref</th>";

                    echo "</tr>";

                    $sql1x="SET SESSION group_concat_max_len = 1000000";
                    mysqli_query($link, $sql1x) or exit("Sql Error88 = $sql".mysqli_error($GLOBALS["___mysqli_ston"]));


                    $sql="SELECT type_of_sewing,input_job_no_random,sch_mix,input_job_no,GROUP_CONCAT(DISTINCT tid ORDER BY tid) AS tid,GROUP_CONCAT(DISTINCT doc_no_ref ORDER BY doc_no) AS doc_no_ref,GROUP_CONCAT(DISTINCT m3_size_code order by m3_size_code) AS size_code,group_concat(distinct order_col_des order by order_col_des) as order_col_des,doc_no,group_concat(distinct order_del_no) as order_del_no,GROUP_CONCAT(DISTINCT CONCAT(order_col_des,'$',acutno) ORDER BY doc_no SEPARATOR ',') AS acutno,SUM(carton_act_qty) AS carton_act_qty FROM (SELECT DISTINCT(SUBSTRING_INDEX(order_joins,'J',-1)) AS sch_mix,order_del_no,input_job_no,input_job_no_random,tid,doc_no,doc_no_ref,m3_size_code,order_col_des,acutno,SUM(carton_act_qty) AS carton_act_qty,type_of_sewing FROM $bai_pro3.packing_summary_input WHERE order_del_no in ($schedule) $exp_query GROUP BY order_col_des,order_del_no,input_job_no_random,acutno,m3_size_code order by field(order_del_no,$schedule),field(m3_size_code,'s01','s02','s03','s04','s05','s06','s07','s08','s09','s10','s11','s12','s13','s14','s15','s16','s17','s18','s19','s20','s21','s22','s23','s24','s25','s26','s27','s28','s29','s30','s31','s32','s33','s34','s35','s36','s37','s38','s39','s40','s41','s42','s43','s44','s45','s46','s47','s48','s49','s50')) AS t GROUP BY input_job_no_random ORDER BY input_job_no*1,field(m3_size_code,'s01','s02','s03','s04','s05','s06','s07','s08','s09','s10','s11','s12','s13','s14','s15','s16','s17','s18','s19','s20','s21','s22','s23','s24','s25','s26','s27','s28','s29','s30','s31','s32','s33','s34','s35','s36','s37','s38','s39','s40','s41','s42','s43','s44','s45','s46','s47','s48','s49','s50')";
                    // echo $sql."<br>";
                    $temp=0;
                    $job_no=0;
                    $color="";
                    $sql_result=mysqli_query($link, $sql) or exit("Sql Error88 = $sql".mysqli_error($GLOBALS["___mysqli_ston"]));
                    while($sql_row=mysqli_fetch_array($sql_result))
                    {
                        $temp+=$sql_row['carton_act_qty'];
                        if($temp>$job_qty or $color!=$sql_row['order_col_des'] or in_array($sql_row['order_del_no'],$donotmix_sch_list))
                        {
                            $job_no++;
                            $temp=0;
                            $temp+=$sql_row['carton_act_qty'];
                            $color=$sql_row['order_col_des'];
                        }
                        if ($sql_row['type_of_sewing'] == 2)
                        {
                            $bg_color='yellow';
                        } else {
                            $bg_color='';
                        }
                        
                        $sql4="select order_tid from $bai_pro3.bai_orders_db where order_del_no=\"".$sql_row["sch_mix"]."\"";
                        $sql_result4=mysqli_query($link, $sql4) or exit("Sql Error44 $sql4".mysqli_error($GLOBALS["___mysqli_ston"]));
                        while($sql_row4=mysqli_fetch_array($sql_result4))
                        {
                            $order_tid=$sql_row4["order_tid"];
                        }
                        $total_cuts=explode(",",$sql_row['acutno']);
                        $cut_jobs_new='';
                        for($ii=0;$ii<sizeof($total_cuts);$ii++)
                        {
                            $arr = explode("$", $total_cuts[$ii], 2);;
                           // $col = $arr[0];
                            $sql4="select color_code from $bai_pro3.bai_orders_db_confirm where order_del_no=\"".$schedule."\" and order_col_des='".$arr[0]."'";
                            //echo $sql4."<br>";
                            $sql_result4=mysqli_query($link, $sql4) or exit("Sql Error44 $sql4".mysqli_error($GLOBALS["___mysqli_ston"]));
                            while($sql_row4=mysqli_fetch_array($sql_result4))
                            {
                                $color_code=$sql_row4["color_code"];
                            }
                             $cut_jobs_new .= chr($color_code).leading_zeros($arr[1], 3)."<br>";
                             unset($arr);
                        }
                        $doc_tag=$sql_row["doc_no"];

                        $sql_des="select group_concat(distinct size_code ORDER BY size_code) as size_code from $bai_pro3.packing_summary_input where doc_no=\"$doc_tag\" and input_job_no='".$sql_row['input_job_no']."'";
                        $sql_result4x=mysqli_query($link, $sql_des) or exit("Sql Error44 $sql_des".mysqli_error($GLOBALS["___mysqli_ston"]));
                        while($sql_row4x=mysqli_fetch_array($sql_result4x))
                        {
                            $size_codes=$sql_row4x['size_code'];
                        }

                        echo "<tr style='background-color:$bg_color;'>";

                        echo "<td>".$sql_row['order_del_no']."</td>";
                        echo "<td>".$sql_row['order_col_des']."</td>";
                        echo "<td>".$cut_jobs_new."</td>";
                        echo "<td>".strtoupper($size_codes)."</td>";
                        echo "<td>".$sql_row['carton_act_qty']."</td>";
                        echo "<td>";

                        $url4 = getFullURLLevel($_GET['r'],'new_job_sheet3.php',0,'R');
                        echo "<a target='_blank' class='btn btn-info btn-sm' href='$url4?jobno=".$sql_row['input_job_no']."&style=$style&schedule=".$sql_row['order_del_no']."&color=".$sql_row['order_col_des']."&doc_no=".$sql_row['input_job_no_random']."' onclick=\"return popitup2('".$url4."?jobno=".$sql_row['input_job_no']."&style=$style&schedule=".$sql_row['order_del_no']."&color=".$sql_row['order_col_des']."&doc_no=".$sql_row['input_job_no_random']."')\">Job Sheet-<b>".$sql_row['input_job_no']."</b></a><br>";

                        echo"</td>";
                        if($scanning_methods=='Bundle Level')
                        {
                            $url5 = getFullURLLevel($_GET['r'],'barcode_new.php',0,'R');
                            echo "<td><a class='btn btn-info btn-sm' href='$url5?input_job=".$sql_row['input_job_no']."&schedule=".$sql_row['order_del_no']."' onclick=\"return popitup2('$url5?input_job=".$sql_row['input_job_no']."&schedule=".$sql_row['order_del_no']."')\" target='_blank'>Print Bundle Barcodes</a></td>";
                        }
                        echo"</tr>";
                    }
                    ?>
                </table>
            </form>
        </div>
     </div>
</div>
