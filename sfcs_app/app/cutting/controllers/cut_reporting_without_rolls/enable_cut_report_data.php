<?php
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config_ajax.php');
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/m3Updations.php');
$data = $_POST;
$doc_no = $data['doc_no'];

$finishedrolls="SELECT * FROM $bai_pro3.`docket_roll_info` WHERE docket=".$doc_no;
$finishedrollsresult = mysqli_query($link,$finishedrolls);
        if(mysqli_num_rows($finishedrollsresult) > 0)
        {
            while($row = mysqli_fetch_array($finishedrollsresult))
            {
                $response_data[] = $row['roll_no'];
            }
            /*get mark length */
            $mlength="SELECT mklength FROM bai_pro3.`order_cat_doc_mk_mix` WHERE doc_no=".$doc_no;
            $mlengthresult = mysqli_query($link,$mlength);
            $marklength = mysqli_fetch_array($mlengthresult);

            $totalreportedplies="SELECT sum(reporting_plies) as totalreportedplies FROM $bai_pro3.`docket_roll_info` where docket=".$doc_no;
            $totalreportedpliesresult = mysqli_query($link,$totalreportedplies);
            $totalreportedplie = mysqli_fetch_array($totalreportedpliesresult);

            $docketrolls="SELECT *,
            (
                CASE 
                    WHEN roll_id IN ( '" . implode( "', '" , $response_data ) . "' ) THEN 1 
                    ELSE 0
                END) AS existed
            FROM $bai_rm_pj1.`fabric_cad_allocation` left join `bai_rm_pj1`.`store_in` on `bai_rm_pj1`.`fabric_cad_allocation`.roll_id=`bai_rm_pj1`.`store_in`.tid left join `bai_pro3`.`docket_roll_info` on `bai_pro3`.`docket_roll_info`.roll_no=`bai_rm_pj1`.`fabric_cad_allocation`.roll_id WHERE doc_no=".$doc_no." order by `bai_rm_pj1`.`store_in`.ref4" ; 
            $docketrollsresult = mysqli_query($link,$docketrolls);
            $response_data=array();
            if(mysqli_num_rows($docketrollsresult) > 0){
                    $i=0;
                        while($row = mysqli_fetch_array($docketrollsresult))
                        {
                            $response_data[] = $row;
                            
                        }
                    $result['totalreportedplie']=$totalreportedplie;
                    $result['response_data']=$response_data;
                    $result['marklength']=$marklength['mklength'];

                    echo json_encode($result);
                    exit(0);
                } 
            
            
        }else
        {
            $checkdocket="SELECT * FROM $bai_pro3.`plandoc_stat_log` WHERE doc_no=".$doc_no;
            $checkdocketresult = mysqli_query($link,$checkdocket);
                if(mysqli_num_rows($checkdocketresult) > 0)
                {
                    if($row1 = mysqli_fetch_array($checkdocketresult))
                    {

                        if($row1['plan_lot_ref']!="Stock")
                        {
                                 /*get mark length */
                                $mlength="SELECT mklength FROM $bai_pro3.`order_cat_doc_mk_mix` WHERE doc_no=".$doc_no;
                                $mlengthresult = mysqli_query($link,$mlength);
                                $marklength = mysqli_fetch_array($mlengthresult);

                                $docketrolls="SELECT * FROM $bai_rm_pj1.`fabric_cad_allocation` left join `bai_rm_pj1`.`store_in` on `bai_rm_pj1`.`fabric_cad_allocation`.roll_id=`bai_rm_pj1`.`store_in`.tid left join `bai_pro3`.`docket_roll_info` on `bai_pro3`.`docket_roll_info`.roll_no=`bai_rm_pj1`.`fabric_cad_allocation`.roll_id  WHERE doc_no=".$doc_no ." order by `bai_rm_pj1`.`store_in`.ref4"; 
                                $docketrollsresult = mysqli_query($link,$docketrolls);
                                $response_data=array();
                                if(mysqli_num_rows($docketrollsresult) > 0)
                                {
                                $i=0;
                                    while($row = mysqli_fetch_array($docketrollsresult))
                                    {

                                        $response_data[] = $row;
                                        
                                    }
                                    $result['response_data']=$response_data;
                                    $result['marklength']=$marklength['mklength'];
                
                                    echo json_encode($result);
                                    exit(0);
                                }
                        }else if($row1['plan_lot_ref']=="Stock")
                        {
                            echo "Not Available";
                            exit(0);
                        }
                    } 
                }
        }
            




