<?php  
ini_set('max_execution_time', 3000); 
include("../../packing/labels/mpdf50/mpdf.php"); 
include("dbconf_new.php"); 

//$link = mysqli_connect('localhost','root','','ff'); 

$style = $_GET['style']; 
$schedule = $_GET['schedule']; 
$cut_number = $_GET['cut_number']; 
$color = $_GET['color']; 
//checking because the ['operation_sequence'] id not set if we individually print the sequences 
if(isset($_GET['operation_sequence'])){ 
    $operation_sequence = $_GET['operation_sequence']; 
} 


$html = '<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"/> 
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js" ></script> 
<script type="text/javascript" src="jquery/jquery-barcode.min.js"></script>'; 

$html.='<style> 
.tableroot{ 
   // width : 30%; 
   // border : 1px solid black; 
    border-radius : 6px; 
    font-size : 11px; 
    padding-top : 5px; 
     
} 
html{ 
    body : 100%; 

} 
.tablechild{ 
    width : 100%; 
} 
.overall_tag{ 
    font-size : 12px; 
    tr{ 
        margin-top :10px; 
    } 

} 
td{ 
    border : 0px; 
} 
tr{ 
    height : 20px; 
    width : 400px; 
} 
// .rotate{ 
//         -webkit-transform: rotate(-90deg); 
//         -webkit-transform-origin: 30px; 
//         -ms-transform: rotate(-90deg); 
//         -ms-transform-origin: 30px; 
//         transform: rotate(-90deg); 
//         text-align:left; 
//         padding-top : 30px; 
         
// } 
</style> 

</head><body> 
<div>'; 

//printing only selected 
// if(!empty($style) && !empty($schedule) && !empty($cut_number) && !empty($operation_sequence)){ 
if(!empty($style) && !empty($schedule) && !empty($cut_number)){ 

    $bundles_query = 'select DISTINCT(bundle_number),operation_sequence from bundle_creation_data where cut_number = '.$cut_number.' and color="'.$color.'" and style="'.$style.'"and schedule="'.$schedule.'"';
     
    $bundles = mysqli_query($link,$bundles_query); 
    if($bundles) 
    { 
        $count001 = 0; 
        while($bundle = mysqli_fetch_array($bundles)){ 
        $operation_sequence=$bundle['operation_sequence']; 
            $size_query = 'select distinct(size_title) as size from bundle_creation_data where cut_number = '.$cut_number.' and  
                      operation_sequence="'.$operation_sequence.'" and style="'.$style.'" and  color="'.$color.'" and schedule="'.$schedule.'"and  bundle_number="'.$bundle['bundle_number'].'"'; 
            $sizes = mysqli_query($link,$size_query); 
            if($sizes){ 
                while($row_sizes = mysqli_fetch_array($sizes)){           
                    $query = 'select *,original_qty as quantity from bundle_creation_data where cut_number = '.$cut_number.' and  
                              operation_sequence="'.$operation_sequence.'" and style="'.$style.'" and color="'.$color.'" and schedule="'.$schedule.'"and  
                              size_title="'.$row_sizes['size'].'"and bundle_number="'.$bundle['bundle_number'].'" GROUP BY bundle_number' ;  
                    $query_operation_ids = 'select operation_id from bundle_creation_data where operation_sequence ="'.$operation_sequence.'" and  
                                      bundle_number="'.$bundle['bundle_number'].'"'; 
                    $operation_ids = mysqli_query($link,$query_operation_ids);                                                 
                    $result = mysqli_query($link,$query); 
                    if($result){ 
                        //$Fortag=0; 
                        while($row = mysqli_fetch_array($result)){ 

                            //to print the dummy label 
                            // $Fortag=$row['operation_sequence']; 
                            //   if($Fortag !=  $tag_diff){ 
                                
                            //    // $barcode = str_pad($row['bundle_number'],'7','0',STR_PAD_LEFT).'-'.str_pad($row['operation_sequence'],'2','0',STR_PAD_LEFT); 
                            //     $html.='<table class="tableroot" border="1px" width="550px" height="200px"><tr><td> 
                            //             <table style="padding-top:30px" class="tablechild overall_tag" width="400px" height="250px">'; 
                            //     $html.='<tr><td colspan="10"></td></tr><tr><td colspan=8 style="text-align : center"><div class="bar'.++$count001.'"><barcode code="'.$barcode.'" type="C39"/></div></td></tr>'; 
                            //     $html.='<tr><td colspan="4"></td></tr>'; 
                            //     $html.='<tr><td colspan="2"> <b>Style<b>   : '.$row['style'].'</td><td colspan="6"><b>Schedule : </b>'.$row['schedule'].'</td></tr>'; 
                            //     $html.='<tr><td colspan="2" width="150"><b>Color : </b>'.$row['color'].'</td></tr>'; 
                            //     $html.='<tr><td colspan="2" width="100"><b>Size : </b>'.$row['size_title'].'</td><td colspan="4"><b>Quantity : </b>'.$row['quantity'].'</td></tr>'; 
                            //     $html.='<tr><td colspan="2"><b>Cut : </b>'.$row['cut_number'].'</td> 
                            //             <td colspan=4 width="150"><b></b>';       
                            //     $html.='</td></tr>'; 
                            //     $html.='</table></td>'; 
                            //     $html.='<td rowspan="6" class="rotate" text-rotate="90" align="center">Bundle Tag</td>'; 
                            //     $html.='</tr>'; 
                            //     $html.='</table>'; 
                            //     $html.='<br>'; 
                            //     $tag_diff = $row['operation_sequence']; 
         
                            // } 

                             while($row3 = mysqli_fetch_array($operation_ids)){ 
                             $string.= $row3['operation_id'].','; 
                            } 

                            //Getting Componet name 
                            $Componentname = 'SELECT DISTINCT component FROM tbl_style_ops_master WHERE style="'.$style.'" AND color="'.$color .'" AND operation_code IN ('.rtrim($string,',').')'; 
                            $compname = mysqli_query($link,$Componentname); 
                            $comp = mysqli_fetch_row($compname);                             
                                $barcode = str_pad($row['bundle_number'],'7','0',STR_PAD_LEFT).'-'.str_pad($row['operation_sequence'],'2','0',STR_PAD_LEFT); 
                                $html.='<table class="tableroot" border="1px" width="550px" height="200px"><tr><td> 
                                        <table class="tablechild" width="400px" height="250px">'; 
                                $html.='<tr><td colspan="10"></td></tr><tr><td colspan=8 style="text-align : center"><div class="bar'.++$count001.'"><barcode code="'.$barcode.'" type="C39"/></div></td></tr>';
                                // $html.='<tr><td colspan="6"><center>'.$barcode.'</center></td></tr>'; 
                                $html.='<tr><td colspan="4"> <b>Style<b>   : '.$row['style'].'</td><td colspan="4"><b>Schedule : </b>'.$row['schedule'].'</td></tr>'; 
                                $html.='<tr><td colspan="6" width="150"><b>Color : </b>'.trim($row['color']).'</td></tr>'; 
                                $html.='<tr><td colspan="6"><b>Size : </b>'.$row['size_title'].',<b>Qty : </b>'.trim($row['quantity']).',<b>Cut : </b>'.$row['cut_number'].',<b>Shade : </b>'.$row['shade'].'</td></tr>'; 
                                $html.='<tr><td colspan="5"><b>Component : </b>'.trim($comp[0]).'</td></tr> 
                                        <tr> 
                                            <td colspan=8 width="150"><b>Op.Code :</b>';                                        
                                                $string = rtrim($string,','); 
                                                $html.=$string;   
                                                $string='';   
                                $html.='</td></tr>'; 
                                $html.='</table></td>'; 
                                $html.='<td rowspan="6" class="rotate" text-rotate="90" align="center">'.str_pad($barcode,'7','0',STR_PAD_LEFT).'</td>'; 
                                $html.='</tr>'; 
                                $html.='</table>'; 
                                //$html.='<br>'; 
                                 
                                 
                            }//while ends here 
                    }else{ 
                      //  echo 'Sorry No data found'; 
                    } 
                } 
            }else{ 
                // echo 'Sorry No sizes found'; 
            } 
        } 
    }else 
    { 
       // echo 'No bundles found'; 
    } 


} 
//ends here 

//Printning all selected 
// else if(isset($_GET['all'])) 
// { 
//     $sequences_query = 'select DISTINCT(operation_sequence) from bundle_creation_data where cut_number='.$cut_number.' and color ="'.$color.'"'; 
//     $sequences = mysqli_query($link,$sequences_query); 
//     if($sequences){ 
//         $seq_ref=0; 
//         while($row1 = mysqli_fetch_array($sequences)){ 
//             $bundles_query = 'select DISTINCT(bundle_number) from bundle_creation_data where cut_number = '.$cut_number.' and  
//                               operation_sequence="'.$row1['operation_sequence'].'" and color="'.$color.'" and style="'.$style.'"and schedule="'.$schedule.'"'; 
//             $bundles = mysqli_query($link,$bundles_query); 
//             if($bundles) 
//             { 
//                 while($bundle = mysqli_fetch_array($bundles)){ 
//                     $size_query = 'select distinct(size_title) as size from bundle_creation_data where cut_number = '.$cut_number.' and  
//                     operation_sequence="'.$row1['operation_sequence'].'" and color="'.$color.'" and style="'.$style.'" and schedule="'.$schedule.'" and  
//                     bundle_number="'.$bundle['bundle_number'].'"'; 

//                     $sizes = mysqli_query($link,$size_query); 
//                     if($sizes){ 
//                         while($row_sizes = mysqli_fetch_array($sizes)){   
//                             $query = 'select *,original_qty as quantity from bundle_creation_data where cut_number = '.$cut_number.' and  
//                                       operation_sequence="'.$row1['operation_sequence'].'" and color="'.$color.'" and style="'.$style.'" 
//                                       and schedule="'.$schedule.'" and size_title ="'.$row_sizes['size'].'" and 
//                                       bundle_number="'.$bundle['bundle_number'].'" GROUP BY bundle_number' ; 
//                             $query_operation_ids = 'select operation_id from bundle_creation_data where operation_sequence ="'.$row1['operation_sequence'].'" and  
//                                       bundle_number="'.$bundle['bundle_number'].'"'; 
//                             $operation_ids = mysqli_query($link,$query_operation_ids);                      
                                      
//                             $result = mysqli_query($link,$query); 
//                             if($result){ 
//                                 while($row2 = mysqli_fetch_array($result)){ 
//                                     $seq_no=$row1['operation_sequence']; 
//                                     if($seq_ref !=  $seq_no){ 
//                                         //$barcode = str_pad($row2['bundle_number'],'7','0',STR_PAD_LEFT).'-'.str_pad($row1['operation_sequence'],'2','0',STR_PAD_LEFT); 
//                                         $html.='<table class="tableroot" border="0px" width="550" height="450px"><tr><td colspan="11"> 
//                                         <table style="padding-top:30px" class="tablechild overall_tag" width="400" height="400px">'; 
//                                         $html.='<tr><td colspan="10"><div class="bar'.++$count001.'"><barcode code="" type="C39"/></div></td></tr>'; 
//                                         $html.='<tr><td colspan="6"></td></tr>'; 
//                                         $html.='<tr><td colspan="2"> <b>style<b> : '.$row2['style'].'</td><td colspan="6"><b>schedule : </b>'.$row2['schedule'].'</td></tr>'; 
//                                         $html.='<tr><td colspan="2" width="150"><b>Color : </b>'.$row2['color'].'</td></tr>'; 
//                                         $html.='<tr><td colspan="2" width="100"><b>size : </b>'.$row2['size_title'].'</td><td colspan="4"><b>Quantity : </b>'.$row2['quantity'].'</td></tr>'; 
//                                         $html.='<tr><td colspan="2"><b>Cut : </b>'.$row2['cut_number'].'</td> 
//                                                 <td colspan="6" width="150"><b> </b>'; 
//                                                 // $string = ''; 
//                                                 // while($row3 = mysqli_fetch_array($operation_ids)){ 
//                                                 //  $string.= $row3['operation_id'].','; 
//                                                 // } 
//                                                 // $string = rtrim($string,','); 
//                                                 // $html.=$string; 
//                                                 // $string =''; 
//                                         $html.='</td></tr>'; 
//                                         $html.='</table></td>'; 
//                                         $html.='<td rowspan="4" class="rotate" align="center" text-rotate="90">Bundle Tag</td>'; 
//                                         $html.='</tr>'; 
//                                         $html.='</table>'; 
//                                         $html.='<br>'; 
                                        
//                                         $seq_ref=$row1['operation_sequence']; 
//                                     } 

//                                         $barcode = str_pad($row2['bundle_number'],'7','0',STR_PAD_LEFT).'-'.str_pad($row1['operation_sequence'],'2','0',STR_PAD_LEFT); 
//                                         $html.='<table class="tableroot" border="0px" width="550" height="450px"><tr><td colspan="11"> 
//                                         <table class="tablechild" width="400" height="400px">'; 
//                                         $html.='<tr><td colspan="10"><div class="bar'.++$count001.'"><barcode code="'.$barcode.'" type="C39"/></div></td></tr>'; 
//                                         $html.='<tr><td colspan="6"><center>'.$barcode.'</center></td></tr>'; 
//                                         $html.='<tr><td colspan="2"> <b>style<b> : '.$row2['style'].'</td><td colspan="5"><b>schedule : </b>'.$row2['schedule'].'</td></tr>'; 
//                                         $html.='<tr><td colspan="2" width="150"><b>Color : </b>'.$row2['color'].'</td></tr>'; 
//                                         $html.='<tr><td colspan="2" width="100"><b>size : </b>'.$row2['size_title'].'</td><td colspan="4"><b>Quantity : </b>'.$row2['quantity'].'</td></tr>'; 
//                                         $html.='<tr><td colspan="2"><b>Cut : </b>'.$row2['cut_number'].'</td></tr> 
//                                                 <tr><td colspan="8" width="150"><b>Operation Code : </b>'; 
//                                                 while($row3 = mysqli_fetch_array($operation_ids)){ 
//                                                  $string.= $row3['operation_id'].','; 
//                                                 } 
//                                                 $string = rtrim($string,','); 
//                                                 $html.=$string; 
//                                                 $string =''; 
//                                         $html.='</td></tr>'; 
//                                         $html.='</table></td>'; 
//                                         $html.='<td rowspan="4" class="rotate" align="center" text-rotate="90">'.$barcode.'</td>'; 
//                                         $html.='</tr>'; 
//                                         $html.='</table>'; 
//                                       //  $html.='<br>'; 
                                         
//                                 } 
//                                     //<b>M : </b>'.$row2['size_title'].' 
                                 
//                             }else{ 
//                                    // echo 'Sequences exist but error in retrieving'; 
//                             } 
//                         } 
//                     }else{ 
//                        // echo 'Sorry No sizes found'; 
//                     } 
//                 } 
//             }else{ 
//                 //echo 'No bundles found'; 
//             } 
//         } 
//     }else{ 
//        // echo 'Error No sequences found'; 
//     } 

// }else{ 
//     header('location:bundle_creation_data_report_now.php?status=0'); 
// } 
//Ends here 

$html.='</div>'; 
$html.='</body></html>'; 

//echo $html; 

$mpdf=new mPDF('C',array(79,45),0,'',0,0,0,0,0,0,'p');  

ob_clean(); 
$mpdf->WriteHTML($html); 
$mpdf->Output();  
ob_end_flush(); 

exit; 


?>