<?php
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config_ajax.php');


            if ( isset($_GET['action']) && !empty(isset($_GET['action'])) ) {
                $action = $_GET['action'];
                switch( $action ) {
                case "docketdetails.":{
                    docketdetails(); // or call here docketdetails();
                }break;
            
                case "printdetails.":{
                    printdetails(); // or call here printdetails();
                }break;
            
                default: {
                    // do not forget to return default data, if you need it...
                }
                }
            }

            function docketdetails()
            {
                    global $bai_pro3;
                    global $link;
                   $schedule=$_POST['schedule'];
                    // $style=$_POST['style'];
                    // $color=$_POST['color'];
                    if($data=$_POST)
                    {
                        $scheduleddata="select doc_no from $bai_pro3.`order_cat_doc_mk_mix` where order_del_no=".$schedule;
                        $scheduleddataresult= mysqli_query($link,$scheduleddata);
                        if(mysqli_num_rows($scheduleddataresult) > 0)
                        {
                            while($dockts = mysqli_fetch_array($scheduleddataresult))
                            {
                                $scheduledockets[] = $dockts;
                            }
                        
                            echo json_encode($scheduledockets);
                            exit(0);
                        }
                    }
            }
            function printdetails()
            {
                        global $bai_pro3;
                        global $link;
                        global $sizes_array;
                        global $sizes_code;

                        $doc_no=$_POST['doc_no'];
                        $getdetails="SELECT * FROM $bai_pro3.docket_number_info  where doc_no=".$doc_no;
                        $getdetailsresult = mysqli_query($link,$getdetails);

                        $size_query = "SELECT * FROM $bai_pro3.plandoc_stat_log WHERE doc_no=$doc_no";
                        $size_result = mysqli_query($link, $size_query) or exit("error while getting details for child doc nos");
                        while($sql_row=mysqli_fetch_array($size_result))
                        {
                            $order_tid = $sql_row['order_tid'];
                            for($s=0;$s<sizeof($sizes_array);$s++)
                            {
                                $planned_s[$sizes_code[$s]]=$sql_row["p_".$sizes_array[$s].""];
                            }				
                        }

                        $sql="select * from $bai_pro3.bai_orders_db_confirm where order_tid='".$order_tid."'";
                        $sql_result=mysqli_query($link, $sql) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
                        while($sql_row=mysqli_fetch_array($sql_result))
                        {
                            for($ss=0;$ss<sizeof($sizes_array);$ss++)
                            {
                            if($sql_row["title_size_".$sizes_array[$ss].""]<>'')
                            {
                                    $o_s[$sizes_array[$ss]]=$sql_row["title_size_".$sizes_array[$ss].""];
                                    
                            }
                            }
                        }		

                        for($jj=0;$jj<sizeof($o_s);$jj++)
                        {
                            $ratios_list[$o_s[$sizes_array[$jj]]]= $planned_s[$sizes_code[$jj]];
                        
                        }
                        
                        
                        if(mysqli_num_rows($getdetailsresult) > 0)
                        {
                            while($row = mysqli_fetch_array($getdetailsresult))
                            {
                                $response_data[] = $row;
                            }
                           $result['response_data']=$response_data;
                           $result['ratios_list']=$ratios_list;
                            echo json_encode($result);
                            exit(0);
                        }
            }



?>