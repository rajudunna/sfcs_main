

<table class="table table-bordered">

    <thead>
        <tr>
            <th>S.no</th>
            <th>Schedule</th>
            <th>Color Set</th>
            <th>Cut Job</th>
            <th>Size Set</th>
            <th>Total Sewing Job Quantity</th>
            <th>Sewing Job Sheet</th>
            <!-- <th>Bundle Barcode With Operation</th>
            <th>Bundle Barcode</th> -->
        </tr>
    </thead>

    <tbody>

        <?php

            // $style = $_GET['style'];
            $schedule = $_GET['schedule'];

            // $style = 'JJP316F8';
            // $schedule = '520178';
        
            include($_SERVER['DOCUMENT_ROOT'].'/template/dbconf.php');

            // Code Coppied from Create Swing jobs page
            $sql1x="SET SESSION group_concat_max_len = 1000000";
            $sql1x_result = mysqli_query($link_ui, $sql1x) or exit("Sql Error1 = $sql".mysqli_error($GLOBALS["___mysqli_ston"]));


            $sql="SELECT type_of_sewing,input_job_no_random,sch_mix,input_job_no,GROUP_CONCAT(DISTINCT tid ORDER BY tid) AS tid,GROUP_CONCAT(DISTINCT doc_no_ref ORDER BY doc_no) AS doc_no_ref,GROUP_CONCAT(DISTINCT m3_size_code order by m3_size_code) AS size_code,group_concat(distinct order_col_des order by order_col_des) as order_col_des,doc_no,group_concat(distinct order_del_no) as order_del_no,GROUP_CONCAT(DISTINCT CONCAT(order_col_des,'$',acutno) ORDER BY doc_no SEPARATOR ',') AS acutno,SUM(carton_act_qty) AS carton_act_qty FROM (SELECT DISTINCT(SUBSTRING_INDEX(order_joins,'J',-1)) AS sch_mix,order_del_no,input_job_no,input_job_no_random,tid,doc_no,doc_no_ref,m3_size_code,order_col_des,acutno,SUM(carton_act_qty) AS carton_act_qty,type_of_sewing FROM bai_pro3.packing_summary_input WHERE order_del_no='$schedule' GROUP BY order_col_des,order_del_no,input_job_no_random,acutno,m3_size_code order by field(order_del_no,$schedule),field(m3_size_code,'s01','s02','s03','s04','s05','s06','s07','s08','s09','s10','s11','s12','s13','s14','s15','s16','s17','s18','s19','s20','s21','s22','s23','s24','s25','s26','s27','s28','s29','s30','s31','s32','s33','s34','s35','s36','s37','s38','s39','s40','s41','s42','s43','s44','s45','s46','s47','s48','s49','s50')) AS t GROUP BY input_job_no_random ORDER BY input_job_no*1,field(m3_size_code,'s01','s02','s03','s04','s05','s06','s07','s08','s09','s10','s11','s12','s13','s14','s15','s16','s17','s18','s19','s20','s21','s22','s23','s24','s25','s26','s27','s28','s29','s30','s31','s32','s33','s34','s35','s36','s37','s38','s39','s40','s41','s42','s43','s44','s45','s46','s47','s48','s49','s50')";
           
            $temp=0;
            $job_no=0;
            $color="";
            $sql_result = mysqli_query($link_ui, $sql) or exit("Sql Error2 = $sql".mysqli_error($GLOBALS["___mysqli_ston"]));
            

            if ($sql_result->num_rows > 0) {

                $i=0;
                while($sql_row=mysqli_fetch_array($sql_result))
                {
                    $i++;
                    $sno = $i;
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
                    $sql_result4=mysqli_query($link_ui, $sql4) or exit("Sql Error44 $sql4".mysqli_error($GLOBALS["___mysqli_ston"]));
                    while($sql_row4=mysqli_fetch_array($sql_result4))
                    {
                        $order_tid=$sql_row4["order_tid"];
                    }
                    $total_cuts=explode(",",$sql_row['acutno']);
                    $cut_jobs_new='';
                    for($ii=0;$ii<sizeof($total_cuts);$ii++)
                    {
                        $arr = explode("$", $total_cuts[$ii], 2);;
                    
                        $sql4="select color_code from $bai_pro3.bai_orders_db_confirm where order_del_no=\"".$schedule."\" and order_col_des='".$arr[0]."'";
                        
                        $sql_result4=mysqli_query($link_ui, $sql4) or exit("Sql Error44 $sql4".mysqli_error($GLOBALS["___mysqli_ston"]));
                        while($sql_row4=mysqli_fetch_array($sql_result4))
                        {
                            $color_code=$sql_row4["color_code"];
                        }
                        $cut_jobs_new .= chr($color_code).leading_zeros($arr[1], 3)."<br>";
                        unset($arr);
                    }
                    $doc_tag=$sql_row["doc_no"];

                    $sql_des="select group_concat(distinct size_code ORDER BY old_size) as size_code from $bai_pro3.packing_summary_input where order_del_no=\"".$schedule."\" and input_job_no='".$sql_row['input_job_no']."'";
                    // echo $sql_des.'<br>';
                    $sql_result4x=mysqli_query($link_ui, $sql_des) or exit("Sql Error44 $sql_des".mysqli_error($GLOBALS["___mysqli_ston"]));
                    while($sql_row4x=mysqli_fetch_array($sql_result4x))
                    {
                        $size_codes=$sql_row4x['size_code'];
                    }

                    echo "<tr>";

                        echo "<td>".$sno."</td>";
                        echo "<td>".$sql_row['order_del_no']."</td>";
                        echo "<td>".$sql_row['order_col_des']."</td>";
                        echo "<td>".$cut_jobs_new."</td>";
                        echo "<td>".strtoupper($size_codes)."</td>";
                        echo "<td>".$sql_row['carton_act_qty']."</td>";
                        echo "<td>";

                        $url4 = getFullURLLevel($_GET['r'],'new_job_sheet3.php',0,'R');
                        echo "<a target='_blank' class='btn btn-info btn-sm' href='$url4?jobno=".$sql_row['input_job_no']."&style=$style&schedule=".$sql_row['order_del_no']."&color=".$sql_row['order_col_des']."&doc_no=".$sql_row['input_job_no_random']."' onclick=\"return popitup2('".$url4."?jobno=".$sql_row['input_job_no']."&style=$style&schedule=".$sql_row['order_del_no']."&color=".$sql_row['order_col_des']."&doc_no=".$sql_row['input_job_no_random']."')\"><i class=\"fa fa-print\" aria-hidden=\"true\"></i>&nbsp;&nbsp;&nbsp;Job Sheet-<b>".$sql_row['input_job_no']."</b></a><br>";

                        echo"</td>";
                        // if($scanning_methods=='Bundle Level')
                        // {
                        //     $url5 = getFullURLLevel($_GET['r'],'barcode_new.php',0,'R');
                        //     echo "<td><a class='btn btn-info btn-sm' href='$url5?input_job=".$sql_row['input_job_no']."&schedule=".$sql_row['order_del_no']."' onclick=\"return popitup2('$url5?input_job=".$sql_row['input_job_no']."&schedule=".$sql_row['order_del_no']."')\" target='_blank'><i class=\"fa fa-print\" aria-hidden=\"true\"></i>&nbsp;&nbsp;&nbsp;Print</a></td>";
                        //     $url6 = getFullURLLevel($_GET['r'],'barcode_without_operation.php',0,'R');
                        //         echo "<td><a class='btn btn-info btn-sm' href='$url6?input_job=".$sql_row['input_job_no']."&schedule=".$sql_row['order_del_no']."' onclick=\"return popitup2('$url6?input_job=".$sql_row['input_job_no']."&schedule=".$sql_row['order_del_no']."')\" target='_blank'><i class=\"fa fa-print\" aria-hidden=\"true\"></i>&nbsp;&nbsp;&nbsp;Print</a></td>";
                        // }
                    echo"</tr>";
                }
            }else{
                echo "<div class='alert alert-info' align='center'>No Data Found</div>";
            }

                
            $link_ui->close();

        ?>
    
    </tbody>
</table>
<style>
td {
    width: 300px;
  }
</style>
      



   
