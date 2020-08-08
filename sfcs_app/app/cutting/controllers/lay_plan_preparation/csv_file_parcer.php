
<?php

//To update Form.
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',4,'R')); 
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/functions.php',4,'R')); 
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/functions_dashboard.php',4,'R'));
       if (isset($_POST['Submit']) && short_shipment_status($_POST['style'],$_POST['schedule'],$link)) {
           //For Bulk Upload
        
           $fname = $_FILES["file"]["name"];
          
           $style=$_POST['style'];
           $schedule=$_POST['schedule'];
           $color=$_POST['color'];
           $cuttable_sum=$_POST['cuttable']; //cuttable_ref
           $category=$_POST['category'];//cat_ref
           $username = getrbac_user()['uname'];
           $sizes_reference=$_POST['sizes_reference'];
        //    echo "<br>".var_dump($sizes_reference);
           $tran_order_tid=$_POST['tran_order_tid'];
            // var_dump($cuttable_sum);
           $main_style = style_encode($style);
          $main_color = color_encode($color);
          
           $sql="SELECT order_tid FROM bai_pro3.bai_orders_db WHERE order_style_no='".$style."' AND order_del_no='".$schedule."' AND order_col_des='".$color."'";
           $sql_result=mysqli_query($link, $sql) or exit("Sql Error");
           $row = mysqli_fetch_assoc($sql_result);
           $order_tid=$row["order_tid"];//order_tid
            
           
           $target_dir = $_SERVER['DOCUMENT_ROOT'].'/assets/uploads/Ratio_uploads/';
           if(!is_dir($target_dir)){
               mkdir($target_dir, 0777 ,true);
               chmod($target_dir, 0777);
           }
           $chk_ext = explode(".", $fname);
           $new_name = "Ratio_uploads_" . date("YmdHis") . "." . $chk_ext[1];
           $path = $target_dir . $new_name;
           $i = 1;
           if ($_FILES["file"]["error"] == 0) {
               //Upload Data File
               move_uploaded_file($_FILES["file"]["tmp_name"], $path);
               //To validate uploaded data
               $handle = fopen($path, "r");
               $query="INSERT INTO `bai_pro3`.`ratio_lay_plans` (`ratio_number`,`size`, `order_id`, `cat_id`, `cutt_ref`, `user`, `time`) VALUES ";
               $query_alloc="INSERT INTO `bai_pro3`.`allocate_stat_log`(`date`,`cat_ref`,`cuttable_ref`, `order_tid`, `ratio`,`plies`,`pliespercut`,`lastup`,`remarks`,`mk_status`,"; 
                
               //    "('0000-00-00', '123', '12', 'add', '1', '12', '123', '2019-07-16 21:31:57', 'normal', '2', '1', '23', '12', '123', '123')";
               while (($data =  fgetcsv($handle, 1000, ",")) !== FALSE) {
                   
                   $ratio_num="";//ratio
                   $style_val="";
                   $length=sizeof($data);
                   $total_plies_index=$length-2;//cut_count
                //    echo "<br>".var_dump($length);
                   $max_plies_index=$length-1;//pilespercut
                  // echo $total_plies_index."-".$max_plies_index;  
                  
                   if ($i == 1) {
                    if(strtolower($data[0])=="ratio number")
                        {
                            $sizes_reference_array=explode(",",$sizes_reference);
                            // var_dump($sizes_reference_array);
                            $sizes_reference_array = array_map('strtolower', $sizes_reference_array);
                            // echo sizeof($sizes_reference_array);
                            // echo "<br>".$total_plies_index;
                            if((sizeof($sizes_reference_array)+1)==($total_plies_index))
                            {
                                for($x=1;$x<$total_plies_index;$x++){
                                    if(in_array(strtolower($data[$x]), $sizes_reference_array)){
                                    $value = str_pad($x,2,"0",STR_PAD_LEFT);
                                    // var_dump($value);
                                    $query_alloc .=" `allocate_s".$value."`,";
                                    }else{
                                        echo '<script>swal("File format has changed ","Check the size", "warning");</script>';
                                        
                                                                                
                                    }
                                }
                            }
                            
                            
                            $query_alloc=rtrim($query_alloc,",");
                                       
                            $query_alloc .=" ) VALUES  ";
                        }else{
                         echo "incorrect file format";
                         unlink(realpath($path));
                         die();
                        } 
                   } else
                    {
                        //var_dump($data);
                    //  echo '<pre>';
                    //  print_r($data);
                    //    var_dump($cuttable_sum);
                    $ratiocount=0;
                    $sql="select max(ratio) as \"ratio\" from $bai_pro3.allocate_stat_log where order_tid=\"$tran_order_tid\" and cuttable_ref=$cuttable_sum and recut_lay_plan='no'";
                    // echo $sql;
                    // mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
                    $sql_result=mysqli_query($link, $sql) or exit("Sql Error741".mysqli_error($GLOBALS["___mysqli_ston"]));
                    $sql_num_check=mysqli_num_rows($sql_result);

                    while($sql_row=mysqli_fetch_array($sql_result))
                    {
                        if($sql_row['ratio']){
                            $ratiocount=$sql_row['ratio'];
                        }
                        // var_dump($ratiocount);
                    }

                    $ratiocount=$ratiocount+1;



                     for($j=1;$j<$total_plies_index;$j++){
                         $style_val.=$data[$j].",";
                     }
                     $style_val=rtrim($style_val,",");
                    //  var_dump($value);
                     $ratio_num=$data[0];                 
                    
                        //  echo $data[$total_plies_index];
                        $check_empty=0;
                            if (($data[$total_plies_index])>=($data[$max_plies_index]))
                            {
                                for($k=0;$k<$max_plies_index;$k++){
                                    if($data[$k]==''){
                                        $check_empty=1;
                                    }
                                }
                            if ($check_empty==0)
                            {
                            $query .= "('".$ratiocount."','".$style_val."','".$tran_order_tid."','".$category."','".$cuttable_sum."','"
                            .$username."',now()),";
                            $query_alloc .=
                             "(now(), '".$category."', '".$cuttable_sum."','".$tran_order_tid."','".$ratio_num."', '".$data[$total_plies_index]."', '".$data[$max_plies_index]."', now(), 'Normal','2',";
                             
                             $style_array=explode(",",$style_val);
                             
                             foreach ($style_array as $key => $value) {
                                $query_alloc .="'".$value."',";
                             }
                             
                             $query_alloc=rtrim($query_alloc,",");
                             $query_alloc .=" ),";
                            //  echo $query_alloc;
                            }
                            else
                            {
                                echo '<script>swal("Your Missed an empty line","Fill and insert it", "warning");</script>';
                                unlink(realpath($path));
                                die();
                            }
                            }
                            
                            else
                            {
                                echo '<script>swal("Total Piles Should be Greater than or equal to max piles", "check in inserted sheet and re-insert", "warning");</script>';
                                unlink(realpath($path));
                                die();
                                
                            }

                   }
                   $i++;
               }
            if($i==2){
                echo '<script>swal("You have Uploaded an empty file","Fill and insert it", "warning");</script>';
                unlink(realpath($path));
                die();
                
            }
            //    echo $query."<br>".$query_alloc;
               if($i>2){      
               $query=rtrim($query,",");
               $query_alloc=rtrim($query_alloc,",");
            //  var_dump($query_alloc);
             $sql_result=mysqli_query($link, $query) or exit("Sql Error");
             $sql_result_alloc_check=mysqli_query($link, $query_alloc);// or exit("Sql Error at query_alloc");
             if (!$sql_result_alloc_check) {
                 $e_info=mysqli_error($link);
                echo '<script>swal("Failed to Upload Details","'.$e_info.'", "error");</script>';
                 //print_r("Error Occoured because of:".mysqli_error($link));
                 unlink(realpath($path));
                 exit();
             }    
             echo "<script type=\"text/javascript\"> 
                swal('Data successfully inserted', 'Thank You', 'success');
                setTimeout(\"Redirect()\",3000); 
                function Redirect(){	 
                        location.href = \"".getFullURL($_GET['r'], "main_interface.php","N")."&color=$main_color&style=$main_style&schedule=$schedule\"; 
                    }
            </script>";	

                //  exit();
                }
           }
           unlink(realpath($path));

}else {

    echo "<script type=\"text/javascript\"> setTimeout(\"Redirect()\",0); function Redirect(){
        location.href = \"".getFullURLLevel($_GET['r'], "main_interface.php", "0", "N")."&color=".$_POST['color']."&style=".$_POST['style']."&schedule=".$_POST['schedule']."\"; }</script>";	
    
}
?>




