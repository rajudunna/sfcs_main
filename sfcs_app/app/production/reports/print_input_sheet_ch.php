<script>
    function printpr()
    {
        var OLECMDID = 7;
        /* OLECMDID values:
        * 6 - print
        * 7 - print preview
        * 1 - open window
        * 4 - Save As
        */
        var PROMPT = 1; // 2 DONTPROMPTUSER
        var WebBrowser = '<OBJECT ID="WebBrowser1" WIDTH=0 HEIGHT=0 CLASSID="CLSID:8856F961-340A-11D0-A96B-00C04FD705A2"></OBJECT>';
        document.body.insertAdjacentHTML('beforeEnd', WebBrowser);
        WebBrowser1.ExecWB(OLECMDID, PROMPT);
        WebBrowser1.outerHTML = "";
    
    }
</script>


<body onload="printpr1();">

    <?php
        include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
        include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/functions.php',3,'R'));
        
        //$schedule=$_GET["schedule"];
        $schedule=$_POST["schedule"];
        //$schedule="399160"; //for testing
        $schedule_split=explode(",",$schedule);
		if($schedule!='')
		{
			$sql="select * from $bai_pro3.bai_orders_db_confirm where order_del_no in (".$schedule.") ";
			$result=mysqli_query($link, $sql) or die("Error1 = ".mysqli_error($GLOBALS["___mysqli_ston"]));
			$rowcount=mysqli_num_rows($result);
			if($rowcount>0)
			{
            
        
    ?>

    <div class="panel panel-primary">
        <div class="panel-heading">Schedule wise Job Reconciliation Report</div>
        <div class="panel-body">

            <div>
                    <?php
                        $sql="select distinct order_del_no as sch from $bai_pro3.bai_orders_db_confirm where order_del_no in (".$schedule.") ";
                        $result=mysqli_query($link, $sql) or die("Error2 = ".mysqli_error($GLOBALS["___mysqli_ston"]));
                        while($row=mysqli_fetch_array($result))
                        {
                            $schs_array1[]=$row["sch"]; 
                        }
                        
                        if (sizeof($schs_array1)>1)
                        {
                            $sql="select distinct order_joins from $bai_pro3.bai_orders_db_confirm where order_del_no in (".$schedule.") ";
                            //echo $sql;
                            $result=mysqli_query($link, $sql) or die("Error3 = ".mysqli_error($GLOBALS["___mysqli_ston"]));
                            while($row=mysqli_fetch_array($result))
                            {
                                $joinSch=substr($row["order_joins"], 1);
                                //echo $joinSch;            
                            }
                        }
                        else
                        {
                            $joinSch=$schs_array1[0];
                            //echo $joinSch;
                        }
                        
                        //$sql2="select * from bai_orders_db_confirm where order_del_no = \"$joinSch\" ";
                        $sql2="select order_style_no,GROUP_CONCAT(DISTINCT order_col_des) AS order_col_des from $bai_pro3.bai_orders_db_confirm where order_del_no = \"$joinSch\" ";
                        
                        $result2=mysqli_query($link, $sql2) or die("Error22 = ".mysqli_error($GLOBALS["___mysqli_ston"]));
                        while($row=mysqli_fetch_array($result2))
                        {
                            $disStyle=$row["order_style_no"];
                            $disColor=$row["order_col_des"];
                            
                        }
                    ?>

                    <div style="float:left">

                        <table style="font-size:11px;font-family:verdana;text-align:left;" class="table table-bordered">

                            <tr><th>Style :</th> <td><?php echo $disStyle;?></td></tr>
                            <tr><th>Schedule :</th> <td><?php echo $joinSch;?></td></tr>
                            <tr><th>Color :</th> <td><?php echo $disColor;?></td></tr>

                        </table>
                    
                    </div>
                </div>
            </div>
            
            <div>
            <div class='table table-responsive'>

            <?php
                // Display Sample QTY - 05-11-2014 - ChathurangaD
                $sqlr="SELECT remarks from $bai_pro3.bai_orders_db_remarks where order_tid in (SELECT order_tid from bai_orders_db where order_del_no in (".$schedule.")) ";
                //echo $sqlr;
                $resultr=mysqli_query($link, $sqlr) or die("Errorr = ".mysqli_error($GLOBALS["___mysqli_ston"]));
                while($row=mysqli_fetch_array($resultr))
                {
                    $sampleqty=$row["remarks"];
                    //$sampleqty=substr($sampleqty,8);
                    echo "<center><table size=16px; style='border-collapse:collapse;border:none;' class='gridtable label label-warning' align='center'>";
                    echo "<tr><th>Sample Job</th>";
                    if($sampleqty != ''){
                        echo "<td>&nbsp;-&nbsp;&nbsp;".$sampleqty."</td>";
                    }
                    echo "</tr></table></center><br/>";

                }


                //$sizes_array=array("xs","s","m","l","xl","xxl","xxxl","s06","s08","s10","s12","s14","s16","s18","s20","s22","s24","s26","s28","s30");


                

                $sql="select distinct order_del_no as sch,order_div from $bai_pro3.bai_orders_db_confirm where order_del_no in (".$schedule.") ";
                $result=mysqli_query($link, $sql) or die("Error4 = ".mysqli_error($GLOBALS["___mysqli_ston"]));
                while($row=mysqli_fetch_array($result))
                {
                    $schs_array[]=$row["sch"];  
                    $division=$row["order_div"];
                }

                    $xs ="32";
                    $s="34";
                    $m="36";
                    $l="38";
                    $xl="40";
                    $xxl="42"; 
                    $xxxl="44";
                    $s01='';
                    $s02='';
                    $s03='';
                    $s04='';
                    $s05='';
                    $s06='';
                    $s07='';
                    $s08='';
                    $s09='';
                    $s10='';
                    $s11='';
                    $s12='';
                    $s13='';
                    $s14='';
                    $s15='';
                    $s16='';
                    $s17='';
                    $s18='';
                    $s19='';
                    $s20='';
                    $s21='';
                    $s22='';
                    $s23='';
                    $s24='';
                    $s25='';
                    $s26='';
                    $s27='';
                    $s28='';
                    $s29='';
                    $s30='';
                    $s31='';
                    $s32='';
                    $s33='';
                    $s34='';
                    $s35='';
                    $s36='';
                    $s37='';
                    $s38='';
                    $s39='';
                    $s40='';
                    $s41='';
                    $s42='';
                    $s43='';
                    $s44='';
                    $s45='';
                    $s46='';
                    $s47='';
                    $s48='';
                    $s49='';
                    $s50='';

                    
                $div=trim($division);
                $sql3311="SELECT * FROM $bai_pro3.tbl_size_lable WHERE tbl_size_lable.buyer_devision=\"$div\" ";
                mysqli_query($link, $sql3311) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
                $sql_result3311=mysqli_query($link, $sql3311) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
                while($sql_row3311=mysqli_fetch_array($sql_result3311))
                {                   
                    $xs =$sql_row3311['xs'];
                    $s=$sql_row3311['s'];
                    $m=$sql_row3311['m'];
                    $l=$sql_row3311['l'];
                    $xl=$sql_row3311['xl'];
                    $xxl= $sql_row3311['xxl']; 
                    $xxxl=$sql_row3311['xxxl'];
                    $s01=$sql_row3311['s01'];
                    $s02=$sql_row3311['s02'];
                    $s03=$sql_row3311['s03'];
                    $s04=$sql_row3311['s04'];
                    $s05=$sql_row3311['s05'];
                    $s06=$sql_row3311['s06'];
                    $s07=$sql_row3311['s07'];
                    $s08=$sql_row3311['s08'];
                    $s09=$sql_row3311['s09'];
                    $s10=$sql_row3311['s10'];
                    $s11=$sql_row3311['s11'];
                    $s12=$sql_row3311['s12'];
                    $s13=$sql_row3311['s13'];
                    $s14=$sql_row3311['s14'];
                    $s15=$sql_row3311['s15'];
                    $s16=$sql_row3311['s16'];
                    $s17=$sql_row3311['s17'];
                    $s18=$sql_row3311['s18'];
                    $s19=$sql_row3311['s19'];
                    $s20=$sql_row3311['s20'];
                    $s21=$sql_row3311['s21'];
                    $s22=$sql_row3311['s22'];
                    $s23=$sql_row3311['s23'];
                    $s24=$sql_row3311['s24'];
                    $s25=$sql_row3311['s25'];
                    $s26=$sql_row3311['s26'];
                    $s27=$sql_row3311['s27'];
                    $s28=$sql_row3311['s28'];
                    $s29=$sql_row3311['s29'];
                    $s30=$sql_row3311['s30'];
                    $s31=$sql_row3311['s31'];
                    $s32=$sql_row3311['s32'];
                    $s33=$sql_row3311['s33'];
                    $s34=$sql_row3311['s34'];
                    $s35=$sql_row3311['s35'];
                    $s36=$sql_row3311['s36'];
                    $s37=$sql_row3311['s37'];
                    $s38=$sql_row3311['s38'];
                    $s39=$sql_row3311['s39'];
                    $s40=$sql_row3311['s40'];
                    $s41=$sql_row3311['s41'];
                    $s42=$sql_row3311['s42'];
                    $s43=$sql_row3311['s43'];
                    $s44=$sql_row3311['s44'];
                    $s45=$sql_row3311['s45'];
                    $s46=$sql_row3311['s46'];
                    $s47=$sql_row3311['s47'];
                    $s48=$sql_row3311['s48'];
                    $s49=$sql_row3311['s49'];
                    $s50=$sql_row3311['s50'];

                    
                    //$size_db=array($xs,$s,$m,$l,$xxl,$xxxl,$s06,$s08,$s10,$s12,$s14,$s16,$s18,$s20,$s22,$s24,$s26,$s28,$s30);  // implemented by chathuranga
                }



                $size_array_final=array();
                $size_total=array();

                // for($p=0;$p<sizeof($schs_array);$p++)
                // {
                //     for($q=0;$q<sizeof($sizes_array);$q++)
                //     {
                //         $sql6="select sum(order_s_".$sizes_array[$q].") as order_qty from  $bai_pro3.bai_orders_db_confirm where order_del_no in (".$schs_array[$p].") ";   
                //         $result6=mysqli_query($link, $sql6) or die("Error3 = ".mysqli_error($GLOBALS["___mysqli_ston"]));
                //         while($row6=mysqli_fetch_array($result6))
                //         {       
                //             if($row6["order_qty"] > 0)
                //             {
                //                 if(!in_array($sizes_array[$q],$size_array))
                //                 {
                //                     $size_array[]=$sizes_array[$q];
                //                 }
                //             }
                //         }
                //     }
                // }
                $sql6="SELECT DISTINCT size_code FROM $bai_pro3.`packing_summary_input` WHERE order_del_no in (".$schedule.")  ORDER BY old_size";
                // echo $sql6;
                $result612=mysqli_query($link, $sql6) or die("Error3 = ".mysqli_error($GLOBALS["___mysqli_ston"]));
                while($row6=mysqli_fetch_array($result612))
                {
                    $size_array_final[]=$row6['size_code'];
                }
                $cols_size = sizeof($size_array_final);
                echo "<table class='table table-bordered'>";
                echo "<tr style='background-color:#286090;color:white;'>";
                echo "<th>Style</th>";
                echo "<th>PO#</th>";
                echo "<th>VPO#</th>";
                echo "<th>Schedule</th>";
                echo "<th>Destination</th>";
                echo "<th>Color</th>";
                echo "<th>Cut Job#</th>";
                echo "<th>Delivery Date</th>";
                echo "<th>Input Job#</th>";
                for ($i=0; $i < $cols_size; $i++)
                { 
                    echo "<th>".$size_array_final[$i]."</th>";
                }
                echo "<th>Total</th>";
                echo "<th>Input/Output details</th>";
                echo "</tr>";
                $overall_qty = 0;
                $sql="select distinct input_job_no as job from  $bai_pro3.packing_summary_input where order_del_no in ($schedule) order by input_job_no*1";
                // echo $sql."</br>";
                $result=mysqli_query($link, $sql) or die("Error-".$sql."-".mysqli_error($GLOBALS["___mysqli_ston"]));           
                while($sql_row=mysqli_fetch_array($result))
                {
                    
                    //$sql1="select acutno,group_concat(distinct order_del_no) as del_no,group_concat(distinct doc_no) as doc_nos from packing_summary_input where order_del_no in ($schedule) and input_job_no='".$sql_row["job"]."' group by order_del_no,acutno";
                    $sql1="select acutno,group_concat(distinct order_del_no) as del_no,group_concat(distinct doc_no) as doc_nos from  $bai_pro3.packing_summary_input where order_del_no in ($schedule) and input_job_no='".$sql_row["job"]."' group by order_del_no";
                    //echo $sql1;
                    $result1=mysqli_query($link, $sql1) or die("Error-".$sql1."-".mysqli_error($GLOBALS["___mysqli_ston"]));            
                    while($sql_row1=mysqli_fetch_array($result1))
                    {
                        $doc_nos_des=$sql_row1["doc_nos"];
                        $acutno_ref=$sql_row1["acutno"];
                        
                        //$sql2d="select group_concat(distinct destination) as dest from plandoc_stat_log where doc_no in (".$doc_nos_des.") and acutno='".$acutno_ref."'";
                        $sql2d="select group_concat(distinct destination) as dest from  $bai_pro3.plandoc_stat_log where doc_no in (".$doc_nos_des.") and acutno='".$acutno_ref."'";
                        $result2d=mysqli_query($link, $sql2d) or die("Error-".$sql2d."-".mysqli_error($GLOBALS["___mysqli_ston"]));
                        while($sql_row2d=mysqli_fetch_array($result2d))
                        {
                            $destination=$sql_row2d["dest"];
                        }
                        
                        $sql2="select order_tid,group_concat(distinct trim(destination)) as dest,order_style_no as style,GROUP_CONCAT(DISTINCT order_col_des) as color,order_po_no as cpo,order_date,vpo,order_del_no from  $bai_pro3.bai_orders_db where order_del_no in (".$sql_row1["del_no"].")";
                        //echo $sql2;
                        $result2=mysqli_query($link, $sql2) or die("Error-".$sql2."-".mysqli_error($GLOBALS["___mysqli_ston"]));
                        while($sql_row2=mysqli_fetch_array($result2))
                        {
                            $destination=$sql_row2["dest"];
                            $color=$sql_row2["color"];
                            $order_tid=$sql_row2["order_tid"];
                            $style=$sql_row2["style"];
                            $po=$sql_row2["cpo"];
                            $del_date=$sql_row2["order_date"];
                            $order_del=$sql_row2["order_del_no"];
                            $vpo=$sql_row2["vpo"];
                        }

                        $sql_cut="select GROUP_CONCAT(DISTINCT order_col_des) AS color, GROUP_CONCAT(DISTINCT acutno) AS cut, SUM(carton_act_qty) AS totqty from $bai_pro3.packing_summary_input where order_del_no in ($schedule) and input_job_no='".$sql_row["job"]."'";
                        // echo $sql_cut.'<br>';
                        $result_cut=mysqli_query($link, $sql_cut) or die("Error9-".$sql_cut."-".mysqli_error($GLOBALS["___mysqli_ston"]));
                        while($sql_row_cut=mysqli_fetch_array($result_cut))
                        {
                            $cut_job_no=$sql_row_cut["cut"];
                            $totcount1=$sql_row_cut["totqty"];
                            $color_to_display=$sql_row_cut["color"];
                        }

                        $get_cut_no="SELECT GROUP_CONCAT(DISTINCT CONCAT(order_col_des,'$',acutno) ORDER BY doc_no SEPARATOR ',') AS acutno from $bai_pro3.packing_summary_input WHERE order_del_no = '$schedule' and input_job_no='".$sql_row["job"]."' ";
                        // echo $get_cut_no.'<br>';
                        $result_cut_no=mysqli_query($link, $get_cut_no) or die("Error92-".$get_cut_no."-".mysqli_error($GLOBALS["___mysqli_ston"]));
                        while($sql_row_cut_no=mysqli_fetch_array($result_cut_no))
                        {
                            $total_cuts=explode(",",$sql_row_cut_no['acutno']);
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
                        }



                        //Display color
                        $display_colors=str_replace(',','<br>',$color);
                        $display = get_sewing_job_prefix("prefix","$brandix_bts.tbl_sewing_job_prefix","$bai_pro3.packing_summary_input",$schedule,$color,$sql_row["job"],$link);
                        $bg_color = get_sewing_job_prefix("bg_color","$brandix_bts.tbl_sewing_job_prefix","$bai_pro3.packing_summary_input",$schedule,$color_des,$sql_row["job"],$link);
                        
                        $total_qty1=0;
                        echo "<tr height=20 style='height:15.0pt; background-color:$bg_color;''>";
                        echo "<td height=20 style='height:15.0pt'>".$style."</td>";
                        echo "<td height=20 style='height:15.0pt'>$po</td>";
                        echo "<td height=20 style='height:15.0pt'>$vpo</td>";
                        echo "<td height=20 style='height:15.0pt'>".$sql_row1["del_no"]."</td>";
                        $temp_schedule=$sql_row1["del_no"];
                        echo "<td height=20 style='height:15.0pt'>$destination</td>";
                        echo "<td height=20 style='height:15.0pt'>$color_to_display</td>";
                        echo "<td height=20 style='height:15.0pt'>".$cut_jobs_new."</td>";
                        echo "<td height=20 style='height:15.0pt'>".$del_date."</td>";
                        echo "<td height=20 style='height:15.0pt'>".$display."</td>";

                        for ($i=0; $i < $cols_size; $i++)
                        { 
                            $sql5="SELECT round(sum(carton_act_qty),0) as qty FROM packing_summary_input where size_code='".$size_array_final[$i]."' and order_del_no in (".$sql_row1["del_no"].") and input_job_no='".$sql_row["job"]."' ";
                            // echo $sql5."<br>";
                            $result5=mysqli_query($link,$sql5) or die("Error-".$sql5);         
                            while($sql_row5=mysqli_fetch_array($result5))
                            {
                                if ($sql_row5["qty"] > 0)
                                {
                                    echo "<td height=20 style='height:15.0pt'>".$sql_row5["qty"]."</td>";
                                    $total_qty1=$total_qty1+$sql_row5["qty"];
                                    $size_total[$i] = $size_total[$i] + $sql_row5["qty"];
                                }
                                else
                                {
                                    echo "<td height=20 style='height:15.0pt'>0</td>";
                                    $total_qty1=$total_qty1+0;
                                    $size_total[$i] = $size_total[$i] + 0;
                                }
                            }
                        }
                        // var_dump($size_total);
                        // $sql5="SELECT ROUND(SUM(carton_act_qty),0) AS qty FROM $bai_pro3.packing_summary_input WHERE order_del_no in (".$sql_row1["del_no"].") and input_job_no=".$sql_row["job"];
                        // // echo $sql5."<br>";
                        // $result5=mysqli_query($link, $sql5) or die("Error-".$sql5."-".mysqli_error($GLOBALS["___mysqli_ston"]));            
                        // while($sql_row5=mysqli_fetch_array($result5))
                        // {
                        //     $total_qty1=$sql_row5["qty"];
                        //     $overall_qty = $overall_qty + $total_qty1;
                        // }
                        $overall_qty = $overall_qty + $total_qty1;
                        echo "<td align=\"center\">".$total_qty1."</td>";
                        echo "<td>";
                        
                        $tot_input=0;
                        $tot_outout=0;
                        $temp_module=0;
                        echo "<div class='table-responsive'>";
                        echo "<table class=\"table table-bordered\"><tr><th>Input Date</th><th>Module#</th><th>Color</th><th>Size</th><th>Input Qty</th><th>Output Qty</th></tr>";
                        $sql55="SELECT ims_date,ims_doc_no,ims_color,ims_mod_no,ims_size,SUM(ims_qty) AS ims_qty,SUM(ims_pro_qty) AS ims_pro_qty FROM  $bai_pro3.ims_combine WHERE ims_schedule=".$sql_row1["del_no"]." AND input_job_no_ref='".$sql_row["job"]."' GROUP BY ims_date,ims_doc_no,ims_color,ims_size ORDER BY ims_date,ims_mod_no,ims_color";
                        //echo $sql5."<br>";
                        $result55=mysqli_query($link, $sql55) or die("Error-".$sql55."-".mysqli_error($GLOBALS["___mysqli_ston"]));         
                        while($sql_row55=mysqli_fetch_array($result55))
                        {
                            // echo $order_tid."<br>";
                            // echo $order_del."<br>";
                            // echo $style."<br>";
                            $size_values=ims_sizes($order_tid,$order_del,$style,$sql_row55["ims_color"],str_replace("a_","",$sql_row55["ims_size"]),$link);
                            
                        ?>
                        
                        <tr>
                        <td><?php echo $sql_row55["ims_date"]; ?></td>
                        <td><?php echo $sql_row55["ims_mod_no"]; ?></td>
                        <?php $temp_module=$sql_row55["ims_mod_no"]; ?>
                        <td><?php echo $sql_row55["ims_color"]; ?></td>
                        <td><?php echo strtoupper($size_values); ?></td>
                        <td><?php echo $sql_row55["ims_qty"]; ?></td>
                        <td><?php echo $sql_row55["ims_pro_qty"]; ?></td>
                        </tr>
                        
                        <?php
                        $tot_input=$tot_input+$sql_row55["ims_qty"];
                        $tot_outout=$tot_outout+$sql_row55["ims_pro_qty"];
                        }
                        
                        if ($total_qty1>$tot_outout)
                        {
                            echo "<tr><td colspan=4 style=\"background-color:#ff8396;\"> </td><td style=\"background-color:#ff8396;color:white\">$tot_input</td><td style=\"background-color:#ff8396;color:white\">$tot_outout</td></tr>";
                        }
                        else
                        {
                            echo "<tr><td colspan=4 style=\"background-color:#3399ff;\"> </td><td style=\"background-color:#3399ff;color:white\">$tot_input</td><td style=\"background-color:#3399ff;color:white\">$tot_outout</td></tr>";
                        }
                        echo "</table>";
                        echo "</div>";
                        //echo "Testing".$temp_module;
                        $temp_jobno=$sql_row["job"];
                        if ($temp_module=="0")
                        {
                            $sql5555="SELECT input_module FROM  $bai_pro3.plan_dashboard_input WHERE input_job_no_random_ref IN (SELECT DISTINCT input_job_no_random FROM packing_summary_input WHERE order_del_no IN ($temp_schedule) AND input_job_no='$temp_jobno' )";
                            //echo $sql5."<br>";
                            $result5555=mysqli_query($link, $sql5555) or die("Error-".$sql5555."-".mysqli_error($GLOBALS["___mysqli_ston"]));           
                            while($sql_row5555=mysqli_fetch_array($result5555))
                            {
                            ?>
                            <span style="background-color:#009900;font-weight:bold;color:white">
                            <?php   
                                echo "Planned module : ".$sql_row5555["input_module"];
                            ?>
                            </span>
                            <?php
                            
                            }
                        }
                        echo "</td>";
                        $total_qty1=0;
                        echo "</tr>";
                    }
                }
                echo "<tr>";

                echo "<th colspan=9  style=\"border-top:1px solid #000;border-bottom:1px dotted #000;font-size:14px;\"> Cut</th>";
                for ($i=0; $i < $cols_size; $i++)
                {
                    echo "<th style=\"border-top:1px solid #000;border-bottom:1px dotted #000;font-size:14px;\">".$size_total[$i]."</th>";
                }
                echo "<th  style=\"border-top:1px solid #000;border-bottom:1px dotted #000;\">$overall_qty</th>";
                echo "<th>";
                            $tot_in=0;
                            $tot_out=0;
                            $tot_balance=0;
                            $tot_balance=$tot_in-$tot_out;
                            $sql111="SELECT SUM(ims_qty) AS tot_in , SUM(ims_pro_qty) AS tot_out, SUM(ims_qty-ims_pro_qty) AS tot_balance FROM  $bai_pro3.ims_combine WHERE ims_schedule=\"$temp_schedule\"";
                            $sql_result1111=mysqli_query($link, $sql111) or exit("Sql Errorzzzz".mysqli_error($GLOBALS["___mysqli_ston"]));
                            while($sql_row1111=mysqli_fetch_array($sql_result1111))
                            {
                                $tot_in=$sql_row1111['tot_in'];
                                $tot_out=$sql_row1111['tot_out'];
                                $tot_balance=$sql_row1111['tot_balance'];
                            }
                            $o_total=0;
                            $balance=$overall_qty-$tot_in;
                            $sql123="select * from $bai_pro3.bai_orders_db_confirm where order_del_no=\"$schedule\" ";
                            //echo $sql123;
                            $sql_result123=mysqli_query($link, $sql123) or exit("Sql Errorzzzz".mysqli_error($GLOBALS["___mysqli_ston"]));
                            while($sql_row=mysqli_fetch_array($sql_result123))
                            {
                                $o_s_s01=$sql_row['order_s_s01'];
                                $o_s_s02=$sql_row['order_s_s02'];
                                $o_s_s03=$sql_row['order_s_s03'];
                                $o_s_s04=$sql_row['order_s_s04'];
                                $o_s_s05=$sql_row['order_s_s05'];
                                $o_s_s06=$sql_row['order_s_s06'];
                                $o_s_s07=$sql_row['order_s_s07'];
                                $o_s_s08=$sql_row['order_s_s08'];
                                $o_s_s09=$sql_row['order_s_s09'];
                                $o_s_s10=$sql_row['order_s_s10'];
                                $o_s_s11=$sql_row['order_s_s11'];
                                $o_s_s12=$sql_row['order_s_s12'];
                                $o_s_s13=$sql_row['order_s_s13'];
                                $o_s_s14=$sql_row['order_s_s14'];
                                $o_s_s15=$sql_row['order_s_s15'];
                                $o_s_s16=$sql_row['order_s_s16'];
                                $o_s_s17=$sql_row['order_s_s17'];
                                $o_s_s18=$sql_row['order_s_s18'];
                                $o_s_s19=$sql_row['order_s_s19'];
                                $o_s_s20=$sql_row['order_s_s20'];
                                $o_s_s21=$sql_row['order_s_s21'];
                                $o_s_s22=$sql_row['order_s_s22'];
                                $o_s_s23=$sql_row['order_s_s23'];
                                $o_s_s24=$sql_row['order_s_s24'];
                                $o_s_s25=$sql_row['order_s_s25'];
                                $o_s_s26=$sql_row['order_s_s26'];
                                $o_s_s27=$sql_row['order_s_s27'];
                                $o_s_s28=$sql_row['order_s_s28'];
                                $o_s_s29=$sql_row['order_s_s29'];
                                $o_s_s30=$sql_row['order_s_s30'];
                                $o_s_s31=$sql_row['order_s_s31'];
                                $o_s_s32=$sql_row['order_s_s32'];
                                $o_s_s33=$sql_row['order_s_s33'];
                                $o_s_s34=$sql_row['order_s_s34'];
                                $o_s_s35=$sql_row['order_s_s35'];
                                $o_s_s36=$sql_row['order_s_s36'];
                                $o_s_s37=$sql_row['order_s_s37'];
                                $o_s_s38=$sql_row['order_s_s38'];
                                $o_s_s39=$sql_row['order_s_s39'];
                                $o_s_s40=$sql_row['order_s_s40'];
                                $o_s_s41=$sql_row['order_s_s41'];
                                $o_s_s42=$sql_row['order_s_s42'];
                                $o_s_s43=$sql_row['order_s_s43'];
                                $o_s_s44=$sql_row['order_s_s44'];
                                $o_s_s45=$sql_row['order_s_s45'];
                                $o_s_s46=$sql_row['order_s_s46'];
                                $o_s_s47=$sql_row['order_s_s47'];
                                $o_s_s48=$sql_row['order_s_s48'];
                                $o_s_s49=$sql_row['order_s_s49'];
                                $o_s_s50=$sql_row['order_s_s50'];

                                $o_total+=($o_s_s01+$o_s_s02+$o_s_s03+$o_s_s04+$o_s_s05+$o_s_s06+$o_s_s07+$o_s_s08+$o_s_s09+$o_s_s10+$o_s_s11+$o_s_s12+$o_s_s13+$o_s_s14+$o_s_s15+$o_s_s16+$o_s_s17+$o_s_s18+$o_s_s19+$o_s_s20+$o_s_s21+$o_s_s22+$o_s_s23+$o_s_s24+$o_s_s25+$o_s_s26+$o_s_s27+$o_s_s28+$o_s_s29+$o_s_s30+$o_s_s31+$o_s_s32+$o_s_s33+$o_s_s34+$o_s_s35+$o_s_s36+$o_s_s37+$o_s_s38+$o_s_s39+$o_s_s40+$o_s_s41+$o_s_s42+$o_s_s43+$o_s_s44+$o_s_s45+$o_s_s46+$o_s_s47+$o_s_s48+$o_s_s49+$o_s_s50);
                            }

                            
                            echo "<table class='table table-bordered'><tr style='background-color:#286090;color:white;'><th>Order Quantity</th><th>Total Sewing IN</th><th>Total Sewing OUT</th><th>Balance to Sewing In</th><th>Balance to Sewing Out</th></tr>";
                            echo "<tr><th>$o_total</th><th>$tot_in</th><th>$tot_out</th><th>$balance</th><th>$tot_balance</th></tr>";
                            echo "</table>";
                echo "</th>";
                echo "</tr>";
               
                echo "</table></div>";

            ?>
        </div>
    </div>
	</div>
	<?php
	}
}
else
{
    echo '<div class="alert alert-danger">Enter Valid Schedule Number</div>';
    echo '<a href="'.getFullURLLevel($_GET['r'],'job_summary_view.php',0,'N').'" class="btn btn-primary">Click Here to Back</a>';
}
?>