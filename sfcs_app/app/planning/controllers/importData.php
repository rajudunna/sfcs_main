<?php ini_set('max_execution_time', 360); ?>
<?php
//load the database configuration file
include (getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));

if(isset($_POST['importSubmit'])){

    //validate whether uploaded file is a csv file
      $fname = $_FILES["file"]["name"];
    $chk_ext1 = explode(".",$fname);
    $csvMimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain');


    if(!empty($_FILES['file']['name']) && in_array($_FILES['file']['type'],$csvMimes)){

        if(is_uploaded_file($_FILES['file']['tmp_name']))
        {
            //open uploaded csv file with read only mode
            $csvFile = fopen($_FILES['file']['tmp_name'], 'r');
          
            //skip first line

            //parse data from csv file line by line
            while(($line = fgetcsv($csvFile)) != FALSE){
                //check whether data already exists in database with same date
				$ndate=$line[6];
				$newDate = date("Y-m-d", strtotime($ndate));
                
				
                $prevQuery = "SELECT * FROM $bai_pro2.fr_data WHERE frdate ='".$newDate."' AND team='".$line[1]."' AND style='".$line[4]."' AND schedule = '".$line[2]."' AND color = '".$line[3]."'";
				
				
                $prevResult = $db->query($prevQuery);
				$hours='10';
				
                if($prevResult->num_rows > 0){
                       while($row = $prevResult->fetch_assoc())
                       {
                            if($row["team"]!='' or $row["style"]!='' or $row["schedule"]!='' or $row["color"]!='' )
                            {
    
                                //update fr data
                                $db->query("UPDATE $bai_pro2.fr_data SET team = '".$line[1]."', style = '".$line[4]."', smv = '".$line[5]."',fr_qty = '".$line[7]."',hours = '".$hours."',schedule = '".$line[2]."', color = '".$line[3]."' WHERE frdate ='".$newDate."' AND team='".$line[1]."' AND style='".$line[4]."' AND schedule = '".$line[2]."' AND color = '".$line[3]."'");
            					// echo "UPDATE fr_data SET team = '".$line[1]."', style = '".$line[4]."', smv = '".$line[5]."',fr_qty = '".$line[7]."',hours = '".$hours."',schedule = '".$line[2]."', color = '".$line[3]."' WHERE frdate ='".$newDate."' AND team='".$line[1]."' AND style='".$line[4]."' AND schedule = '".$line[2]."' AND color = '".$line[3]."'";
            					// echo "</br>";
                               
                                echo "<div class='alert alert-success'>
                                  <strong>Success!</strong> FR Data Successfully Updated .
                                </div>";

                            }
                        }
                }else{

                    //insert fr data into database
                    $db->query("INSERT INTO $bai_pro2.fr_data (frdate,team,style,smv,fr_qty,hours,schedule,color) VALUES ('".$newDate."','".$line[1]."','".$line[4]."','".$line[5]."','".$line[7]."','".$hours."','".$line[2]."','".$line[3]."')");
					// echo "INSERT INTO fr_data (frdate,team,style,smv,fr_qty,hours,schedule,color) VALUES ('".$newDate."','".$line[1]."','".$line[4]."','".$line[5]."','".$line[7]."','".$hours."','".$line[2]."','".$line[3]."')";
					// echo "</br>";
                  
                     echo "<div class='alert alert-success'>
                                  <strong>Success!</strong> FR Data Successfully Inserted.
                            </div>";
                }
            }            
            //close opened csv files

            $new_filename=$_FILES['file']['name'];
       
            $path_new="../".getFullURL($_GET['r'],"Uploads/$new_filename","R");
       
            if(file_exists($path_new))
            {
  
                echo "<script>sweetAlert('Oops','File Already Exists','error')</script>";
            }
            else
            {
               $new_filename=$chk_ext1[0].".".$chk_ext1[1];
                $path_new="../".getFullURL($_GET['r'],"Uploads/$new_filename","R");
                move_uploaded_file($_FILES["file"]["tmp_name"],$path_new);
                echo "<script>sweetAlert('OK','file Uploaded Sucessfully','success')</script>";
            }
            fclose($csvFile);
            // $qstring = '?status=succ';
        }else{
            // $qstring = '?status=err';
        }
    }else{
        echo "<script>sweetAlert('Oops','Inavlid File','error')</script>";
        echo "<div class='alert alert-danger'>
            <strong>Success!</strong> FR Data Successfully Inserted.
            </div>";
      
    }

}
