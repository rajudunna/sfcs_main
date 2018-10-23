
<script> 
    function printPage(printContent) { 
        var display_setting="toolbar=yes,menubar=yes,scrollbars=yes,width=1050, height=600";
        var printpage=window.open("","",display_setting); 
        printpage.document.open(); 
        printpage.document.write('<html><head><title>Print Page</title></head>'); 
        printpage.document.write('<body onLoad="self.print()" align="center">'+ printContent +'</body></html>'); 
        printpage.document.close(); 
        printpage.focus(); 
    }
</script> 
<link rel="stylesheet" type="text/css" href="../../../../common/css/bootstrap.min.css">
<title>Split Wise</title>
<body> 
<?php 
    include("../../../../common/config/config.php");
    include("../../../../common/config/functions.php");
    $schedule=$_GET["schedule"]; 
    $schedule_split=explode(",",$schedule); 
    //echo $schedule;
    error_reporting(0);
    if($schedule==''){
        echo "<script>alert('There are no schedules');
            window.close();
        </script>";
    } else { ?>
        <br><center><a href="javascript:void(0);" onClick="printPage(printsection.innerHTML)" class="btn btn-warning">Print</a></center><br>
        <div id="printsection">
            <style>
                table, th, td
                {
                    border: 1px solid black;
                    border-collapse: collapse;
                    background-color: transparent;
                }
                body
                {
                    font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;
                }
            </style>
            <div class="panel panel-primary"> 
                <div class="panel-heading"><b>Ratio Sheet (Split wise)</b></div>
                <div class="panel-body">
                    <div style="float:right"><img src="/sfcs_app/common/images/<?= $global_facility_code ?>_Logo.JPG" width="200" height="60"></div> 
                    <?php 
                        $sql="select distinct order_del_no as sch,order_tid from $bai_pro3.bai_orders_db_confirm where order_del_no in (".$schedule.") "; 
                        $result=mysqli_query($link, $sql) or die("Error = ".mysqli_error($GLOBALS["___mysqli_ston"])); 
                        while($row=mysqli_fetch_array($result)) 
                        { 
                            $schs_array1[]=$row["sch"];    
                            $order_tid = $row["order_tid"]; 
                        }
                        
                        $sql2="select distinct packing_mode as mode from $bai_pro3.packing_summary_input where order_del_no in (".$schedule.") "; 
                        $result2=mysqli_query($link, $sql2) or die("Error = ".mysqli_error($GLOBALS["___mysqli_ston"])); 
                        while($row2=mysqli_fetch_array($result2)) 
                        { 
                            $packing_mode=$row2["mode"];     
                        }
                        
                        $joinSch=$schedule; 
                        //$sql2="select * from $bai_pro3.bai_orders_db_confirm where order_del_no = \"$joinSch\" "; 
                        $sql2="select order_style_no,GROUP_CONCAT(DISTINCT order_col_des) AS order_col_des from $bai_pro3.bai_orders_db_confirm where order_del_no = \"$joinSch\" "; 
                        
                        $result2=mysqli_query($link, $sql2) or die("Error22 = ".mysqli_error($GLOBALS["___mysqli_ston"])); 
                        while($row=mysqli_fetch_array($result2)) 
                        { 
                            $disStyle=$row["order_style_no"]; 
                            $disColor=$row["order_col_des"]; 
                            
                        } 
                    ?> 

                    <div style="float:left"> 
                        <table class='table table-bordered' style="font-size:11px;font-family:verdana;text-align:left;"> 
                        <tr><th>Style </th><td>:</td> <td><?php echo $disStyle;?></td></tr> 
                        <tr><th>Schedule </th> <td>:</td> <td><?php echo $joinSch;?></td></tr> 
                        <tr><th>Color </th> <td>:</td> <td><?php echo $disColor;?></td></tr> 
                        <tr><th>Sewing Job Model </th> <td>:</td> <td><b><?php echo $operation[$packing_mode];?></b></td></tr> 
                        </table>        
                    </div><br><br><br><br><br><br><br><br>
                    <?php 
        					//Getting sample details here  By SK-07-07-2018 == Start
        					$sql="select * from $bai_pro3.bai_orders_db_confirm where order_style_no=\"$disStyle\" and order_del_no=\"$joinSch\" and order_col_des=\"$disColor\"";
        					$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
        					while($sql_row=mysqli_fetch_array($sql_result))
        					{
        						for($s=0;$s<sizeof($sizes_code);$s++)
        						{
        							if($sql_row["title_size_s".$sizes_code[$s].""]<>'')
        							{
        								$s_tit[$sizes_code[$s]]=$sql_row["title_size_s".$sizes_code[$s].""];
        							}	
        						}
        					}
        					$samples_qry="select * from $bai_pro3.sp_sample_order_db where order_tid='$order_tid' order by sizes_ref";
        					$samples_qry_result=mysqli_query($link, $samples_qry) or exit("Sample query details".mysqli_error($GLOBALS["___mysqli_ston"]));
        					$num_rows_samples = mysqli_num_rows($samples_qry_result);
        					if($num_rows_samples >0){
        						$samples_total = 0;	
        						echo "<span><strong><u>Sample Quantites size wise:</u><strong></span><div class='row'>";
        						echo "<div class='col-md-2'>";
        						echo "<div class='table-responsive'>";						
        						echo "<table class='table table-bordered'>"; 
        						echo "<tr><thead>";						
        						for($i=0;$i<sizeof($s_tit);$i++){
        							echo "<th align=\"center\">".$s_tit[$sizes_code[$i]]."</th>";
        						}
        						echo "<th align=\"center\">Total</th></thead></tr><tr>";
        						while($samples_data=mysqli_fetch_array($samples_qry_result))
        						{
        							$samples_total+=$samples_data['input_qty'];
        							$samples_size_arry[] =$samples_data['sizes_ref'];
        							$samples_input_qty_arry[] =$samples_data['input_qty'];
        						}	
        						for($s=0;$s<sizeof($s_tit);$s++)
        						{
        							$size_code = 's'.$sizes_code[$s];
        							$flg = 0;
        							for($ss=0;$ss<sizeof($samples_size_arry);$ss++)
        							{
        								if($size_code == $samples_size_arry[$ss]){
        									echo "<td class=\"sizes\">".$samples_input_qty_arry[$ss]."</td>";
        									$flg = 1;
        								}			
        							}	
        							if($flg == 0){
        								echo "<td class=\"sizes\"><strong>-</strong></td>";
        							}
        						}		
        						echo "<td class=\"sizes\">".$samples_total."</td></tr></table></div></div></div>";

        					}

        					?>

                    <?php 
                    // // Display Sample QTY - 05-11-2014 - ChathurangaD 
                    // $sqlr="SELECT remarks from $bai_pro3.bai_orders_db_remarks where order_tid in (SELECT order_tid from $bai_pro3.bai_orders_db where order_del_no in (".$schedule.")) "; 
                    // // echo $sqlr; 

                    // $resultr=mysqli_query($link, $sqlr) or die("Errorr = ".mysqli_error($GLOBALS["___mysqli_ston"])); 
                    // while($row=mysqli_fetch_array($resultr)) 
                    // { 
                    //     $sampleqty = $row["remarks"];  
                       
                    //     // $result =  preg_replace('/[^0-9\-]/','', $sampleqty);   
                    //     // $sampleqty = $result;
             
                    //     if($sampleqty == ''){
                    //         $sampleqty = "N/A";
                    //     } 
                    
                    //     echo "<table class=\"gridtable\" align=\"center\" style=\"margin-bottom:2px;font-size:14px;\">"; 
                    //     echo "<tr>"; 
                    //     echo "<th>Sample Job</th><td>$sampleqty</td></tr></table>"; 
                    // } 
                    echo "<br>";

                    $sql="select distinct order_del_no as sch,order_div from $bai_pro3.bai_orders_db_confirm where order_del_no in (".$schedule.") "; 
                    $result=mysqli_query($link, $sql) or die("Error = ".mysqli_error($GLOBALS["___mysqli_ston"])); 
                    while($row=mysqli_fetch_array($result)) 
                    { 
                        $schs_array[]=$row["sch"];     
                        $division=$row["order_div"]; 
                    } 

                        //*Edited by chathuranga 

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
                    $sql_result3311=mysqli_query($link, $sql3311) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"])); 
                    while($sql_row3311=mysqli_fetch_array($sql_result3311)) 
                    { 
                        $xs=$sql_row3311['xs'];
                        $s=$sql_row3311['s'];
                        $m=$sql_row3311['m'];
                        $l=$sql_row3311['l'];
                        $xl=$sql_row3311['xl'];
                        $xxl=$sql_row3311['xxl'];
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



                    $size_array=array(); 

                    for($p=0;$p<sizeof($schs_array);$p++) 
                    { 
                        for($q=0;$q<sizeof($sizes_array);$q++) 
                        { 
                            $sql6="select sum(order_s_".$sizes_array[$q].") as order_qty,title_size_".$sizes_array[$q]." as size from $bai_pro3.bai_orders_db_confirm where order_del_no in (".$schs_array[$p].") ";     
                            $result6=mysqli_query($link, $sql6) or die("Error3 = ".mysqli_error($GLOBALS["___mysqli_ston"])); 
                            while($row6=mysqli_fetch_array($result6)) 
                            {         
                                if($row6["order_qty"] > 0) 
                                { 
                                    if(!in_array($sizes_array[$q],$size_array)) 
                                    { 
                                        $size_array[]=$sizes_array[$q]; 
                                        $orginal_size_array[]=$row6["size"]; 
                                    } 
                                } 
                            } 
                        } 
                    } 
                    echo "<br>";
                    echo "<div class='row'>";
                    echo "<div  class='col-md-12' >";
            		echo "<div class='table-responsive'>";
                    echo "<table class=\"gridtable\">"; 
                    echo "<table class=\"table table-bordered\">";
                    echo "<tr>"; 
                    echo "<th>Style</th>"; 
                    echo "<th>PO#</th>"; 
                    echo "<th>VPO#</th>"; 
                    echo "<th>Schedule</th>"; 
                    echo "<th>Destination</th>"; 
                    echo "<th>Color</th>"; 
                    echo "<th>Cut Job#</th>"; 
                    echo "<th>Delivery Date</th>"; 
                    echo "<th>Sewing Job#</th>"; 
                    for($i=0;$i<sizeof($size_array);$i++) 
                    { 
                        echo "<th align=\"center\">".$orginal_size_array[$i]."</th>"; 
                    } 
                    echo "<th>Total</th>"; 
                    echo "</tr>"; 

                    $sql="select distinct input_job_no as job, type_of_sewing from $bai_pro3.packing_summary_input where order_del_no in ($schedule) group by input_job_no_random order by acutno*1, input_job_no*1"; 
                    // echo $sql;
                    $result=mysqli_query($link, $sql) or die("Error-".$sql."-".mysqli_error($GLOBALS["___mysqli_ston"]));             
                    while($sql_row=mysqli_fetch_array($result)) 
                    {             
                        $sql1="select acutno,group_concat(distinct order_del_no) as del_no,group_concat(distinct order_col_des) as color_des,group_concat(distinct doc_no) as doc_nos,input_job_no_random from $bai_pro3.packing_summary_input where order_del_no in ($schedule) and input_job_no='".$sql_row["job"]."' group by order_del_no,order_col_des,acutno*1,input_job_no_random"; 
                        //echo $sql1."<br>"; 
                        $result1=mysqli_query($link, $sql1) or die("Error-".$sql1."-".mysqli_error($GLOBALS["___mysqli_ston"]));             
                        while($sql_row1=mysqli_fetch_array($result1)) 
                        { 
                            $doc_nos_des=$sql_row1["doc_nos"]; 
                            $acutno_ref=$sql_row1["acutno"]; 
                            $color_des=$sql_row1["color_des"]; 
                            $input_job_no_random_ref=$sql_row1["input_job_no_random"]; 
                            
                            //$sql2d="select group_concat(distinct destination) as dest from plandoc_stat_log where doc_no in (".$doc_nos_des.") and acutno='".$acutno_ref."'"; 
                            // $sql2d="select group_concat(distinct destination) as dest from $bai_pro3.pac_stat_log_input_job where doc_no in (".$doc_nos_des.")";
                            // echo $sql2d.'<br>';
                            // $result2d=mysqli_query($link, $sql2d) or die("Error-".$sql2d."-".mysqli_error($GLOBALS["___mysqli_ston"])); 
                            // while($sql_row2d=mysqli_fetch_array($result2d)) 
                            // { 
                            //     $destination=$sql_row2d["dest"]; 
                            // } 
                            
                            $sql2="select group_concat(distinct trim(destination)) as dest,order_style_no as style,GROUP_CONCAT(DISTINCT order_col_des separator '<br/>') as color,order_po_no as cpo,order_date,vpo from $bai_pro3.bai_orders_db where order_del_no in (".$sql_row1["del_no"].") and order_col_des=\"".$color_des."\""; 
                            // echo $sql2; 
                            $result2=mysqli_query($link, $sql2) or die("Error-".$sql2."-".mysqli_error($GLOBALS["___mysqli_ston"])); 
                            while($sql_row2=mysqli_fetch_array($result2)) 
                            { 
                                //$destination=$sql_row2["dest"]; 
                                $color=$sql_row2["color"]; 
                                $style=$sql_row2["style"]; 
                                $po=$sql_row2["cpo"]; 
                                $del_date=$sql_row2["order_date"]; 
                                $vpo=$sql_row2["vpo"]; 
                            }                 

                            $sql_cut="select group_concat(distinct acutno) as cut, sum(carton_act_qty) as totqty, destination from $bai_pro3.packing_summary_input where order_del_no in ($schedule) and order_col_des=\"".$color."\" and input_job_no='".$sql_row["job"]."' and acutno='".$acutno_ref."'"; 
                            // echo $sql_cut.'<br>'; 
                            $result_cut=mysqli_query($link, $sql_cut) or die("Error-".$sql2."-".mysqli_error($GLOBALS["___mysqli_ston"])); 
                            while($sql_row_cut=mysqli_fetch_array($result_cut)) 
                            { 
                                $cut_job_no=$sql_row_cut["cut"]; 
                                $totcount1=$sql_row_cut["totqty"];                         
                                $destination=$sql_row_cut["destination"];                         
                            } 
                            $sql4="select color_code from $bai_pro3.bai_orders_db_confirm where order_del_no=\"".$schedule."\" and order_col_des='".$color."'";
                            // echo $sql4."<br>";
                            $sql_result4=mysqli_query($link, $sql4) or exit("Sql Error44 $sql4".mysqli_error($GLOBALS["___mysqli_ston"]));
                            while($sql_row4=mysqli_fetch_array($sql_result4))
                            {
                                $color_code=$sql_row4["color_code"];
                            }
                            $cut_jobs_new = chr($color_code).leading_zeros($cut_job_no, 3);
                            //$totcount="- (".$totcount1.")<br>"; 
                            //Display color 
                            $display_colors=str_replace(',',$totcount,$color); 
                            //$totcount=0; 
                            $display = get_sewing_job_prefix("prefix","$brandix_bts.tbl_sewing_job_prefix","$bai_pro3.packing_summary_input",$schedule,$color_des,$sql_row["job"],$link);
                            $bg_color = get_sewing_job_prefix("bg_color","$brandix_bts.tbl_sewing_job_prefix","$bai_pro3.packing_summary_input",$schedule,$color_des,$sql_row["job"],$link);

                            echo "<tr height=20 style='height:15.0pt; background-color:$bg_color;'>"; 
                            echo "<td height=20 style='height:15.0pt'>".$style."</td>"; 
                            echo "<td height=20 style='height:15.0pt'>$po</td>"; 
                            echo "<td height=20 style='height:15.0pt'>$vpo</td>"; 
                            echo "<td height=20 style='height:15.0pt'>".$sql_row1["del_no"]."</td>"; 
                            echo "<td height=20 style='height:15.0pt'>$destination</td>"; 
                            //echo "<td height=20 style='height:15.0pt'>".$display_colors." - (".$totcount1.")</td>"; 
                            echo "<td height=20 style='height:15.0pt'>".$display_colors."</td>"; 
                            echo "<td height=20 style='height:15.0pt'>".$cut_jobs_new."</td>"; 
                            echo "<td height=20 style='height:15.0pt'>".$del_date."</td>"; 
                            echo "<td height=20 style='height:15.0pt'>".$display."</td>"; 
                            for($i=0;$i<sizeof($size_array);$i++) 
                            {     
                                $sql7="SELECT * FROM $bai_pro3.packing_summary_input where size_code='".$orginal_size_array[$i]."' and order_del_no in (".$sql_row1["del_no"].") and order_col_des=\"".$color."\" and input_job_no='".$sql_row["job"]."' and acutno='".$acutno_ref."' and input_job_no_random='".$input_job_no_random_ref."'"; 
                                //echo $sql7."<br>"; 
                                $result7=mysqli_query($link, $sql7) or die("Error7-".$sql7."-".mysqli_error($GLOBALS["___mysqli_ston"])); 
                                $rows_count=mysqli_num_rows($result7); 
                                if($rows_count > 0) 
                                { 
                                    $sql5="SELECT round(sum(carton_act_qty),0) as qty FROM $bai_pro3.packing_summary_input where size_code='".$orginal_size_array[$i]."' and order_del_no in (".$sql_row1["del_no"].") and order_col_des=\"".$color."\" and input_job_no='".$sql_row["job"]."' and acutno='".$acutno_ref."' and input_job_no_random='".$input_job_no_random_ref."'"; 
                                    //echo $sql5."<br>"; 
                                    $result5=mysqli_query($link, $sql5) or die("Error-".$sql5."-".mysqli_error($GLOBALS["___mysqli_ston"]));             
                                    while($sql_row5=mysqli_fetch_array($result5)) 
                                    { 
                                        echo "<td class=xl787179 align=\"center\">".$sql_row5["qty"]."</td>"; 
                                        $total_qty1=$total_qty1+$sql_row5["qty"]; 
                                    } 
                                } 
                                else 
                                { 
                                    echo "<td class=xl787179 align=\"center\">0</td>"; 
                                    $total_qty1=$total_qty1+0; 
                                }             
                            } 
                            echo "<td align=\"center\">".$total_qty1."</td>"; 
                            $total_qty1=0; 
                            echo "</tr>"; 
                        } 
                    } 
                    echo "<tr>"; 
                    echo "<th colspan=9  style=\"border-top:2px solid #000;border-bottom:1px dotted #000;font-size:14px;\"> Total</th>"; 
                        
                        for ($i=0; $i < sizeof($size_array); $i++)
                        { 
                            $sql1="SELECT ROUND(SUM(carton_act_qty),0) AS qty FROM $bai_pro3.packing_summary_input WHERE  order_del_no IN ($joinSch) and size_code='$orginal_size_array[$i]'";
                            //echo $sql1;
                            $sql_result1=mysqli_query($link, $sql1) or exit("Sql Error996".mysqli_error($GLOBALS["___mysqli_ston"]));
                            while($sql_row1=mysqli_fetch_array($sql_result1))
                            {
                                $o_s=$sql_row1['qty'];
                                if ($o_s!=0) {  echo "<th align=\"center\" style=\"border-top:2px solid #000;border-bottom:1px dotted #000;\">".$o_s."</th>"; }
                                $o_total=$o_s+$o_total;
                                //echo $o_total;
                            }
                        }
                        
                        echo "<th  style=\"border-top:2px solid #000;border-bottom:1px dotted #000;\">$o_total</th>";
                        echo "</tr>"; 
                        echo "</table></div></div></div></div><br>"; 
                    ?> 
                </div>
            </div>
        </div>
        <?php 
    } 
?>