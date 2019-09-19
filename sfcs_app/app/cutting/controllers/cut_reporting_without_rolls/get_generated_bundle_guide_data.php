<?php
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config_ajax.php');


            if ( isset($_GET['action']) && !empty(isset($_GET['action'])) ) {
                $action = $_GET['action'];
                switch( $action ) {
                case "docketdetails.":{
                    docketdetails(); // or call here one();
                }break;
            
                case "printdetails.":{
                    printdetails(); // or call here two();
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
                        $doc_no=$_POST['doc_no'];
                        $getdetails="SELECT * FROM $bai_pro3.docket_number_info where doc_no=".$doc_no;
                        $getdetailsresult = mysqli_query($link,$getdetails);
                        if(mysqli_num_rows($getdetailsresult) > 0)
                        {
                            while($row = mysqli_fetch_array($getdetailsresult))
                            {
                                $response_data[] = $row;
                            }
                            echo json_encode($response_data);
                            exit(0);
                        }
            }

          
            
           




?>