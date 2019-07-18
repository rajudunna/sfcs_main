
<?php

//To update Form.
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',4,'R')); 

       if (isset($_POST['Submit'])) {
           //For Bulk Upload
        
           $fname = $_FILES["file"]["name"];
          
           $style=$_POST['style'];
           $schedule=$_POST['schedule'];
           $color=$_POST['color'];
           $cuttable_sum=$_POST['cuttable']; //cuttable_ref
           $category=$_POST['category'];//cat_ref
           $username = getrbac_user()['uname'];
           $sizes_reference=$_POST['sizes_reference'];
            // var_dump($cuttable_sum);
           
          
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
                //    var_dump($total_plies_index);
                   $max_plies_index=$length-1;//pilespercut
                  // echo $total_plies_index."-".$max_plies_index;  
                  
                   if ($i == 1) {
                    if(strtolower($data[0])=="ratio number")
                        {
                            $sizes_reference_array=explode(",",$sizes_reference);
                            // var_dump($sizes_reference_array);
                            $sizes_reference_array = array_map('strtolower', $sizes_reference_array);
                        
                            if(sizeof($sizes_reference_array)==$total_plies_index)
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
                         echo "incorrect file format";die();
                        } 
                   } else
                    {
                        //var_dump($data);
                        echo '<pre>';
                        // print_r($data);
                    //    var_dump($cuttable_sum);
                     for($j=1;$j<$total_plies_index;$j++){
                         $style_val.=$data[$j].",";
                     }
                     $style_val=rtrim($style_val,",");
                    //  var_dump($value);
                     $ratio_num=$data[0];                 
                    
                        //  echo $data[$total_plies_index];
                            if ((($data[$total_plies_index])>=($data[$max_plies_index]))&&($data[$total_plies_index]!=''))
                            {
                            $query .= "('".$ratio_num."','".$style_val."','".$order_tid."','".$category."','".$cuttable_sum."','"
                            .$username."',now()),";
                            $query_alloc .=
                             "(now(), '".$category."', '".$cuttable_sum."','".$order_tid."','".$ratio_num."', '".$data[$total_plies_index]."', '".$data[$max_plies_index]."', now(), 'Normal','2',";
                             
                             $style_array=explode(",",$style_val);
                             
                             foreach ($style_array as $key => $value) {
                                $query_alloc .="'".$value."',";
                             }
                             
                             $query_alloc=rtrim($query_alloc,",");
                             $query_alloc .=" ),";
                             
                            }
                            
                            else
                            {
                                echo '<script>swal("Total Piles Should be Greater than or equal to max piles", "check in inserted sheet and re-insert", "warning");</script>';
                                die();
                                
                            }

                   }
                   $i++;
               }
            //    echo $query."<br>".$query_alloc;
               if($i>2){      
               $query=rtrim($query,",");
               $query_alloc=rtrim($query_alloc,",");
            //  var_dump($query_alloc);
               $sql_result=mysqli_query($link, $query) or exit("Sql Error");
             $sql_result_alloc=mysqli_query($link, $query_alloc) or exit("Sql Error at query_alloc");
                 echo "<script type=\"text/javascript\"> 
                swal('Data successfully inserted', 'Thank You', 'success');
                setTimeout(\"Redirect()\",3000); 
                function Redirect(){	 
                        location.href = \"".getFullURL($_GET['r'], "main_interface.php","N")."&color=$color&style=$style&schedule=$schedule\"; 
                    }
            </script>";	

                //  exit();
                }
           }
           unlink(realpath($path));

}
?>




