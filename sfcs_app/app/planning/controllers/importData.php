<?php ini_set('max_execution_time', 360); ?>
<?php
//load the database configuration file
include (getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));

if(isset($_POST['importSubmit'])){

    //validate whether uploaded file is a csv file
    $fname = $_FILES["file"]["name"];
    $chk_ext1 = explode(".",$fname);
    // $csvMimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain');
	$csvMimes = array('csv');

	// echo $_FILES['file']['name']."@@@".$_FILES['file']['type'];
	// die();
	$file_type = pathinfo($fname, PATHINFO_EXTENSION);
    if(!empty($_FILES['file']['name']) && in_array($file_type,$csvMimes)){

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
				
				
                $prevResult = $link->query($prevQuery);
				
				$hours='10';
				
                if($prevResult->num_rows > 0){
                       while($row = $prevResult->fetch_assoc())
                       {
                            if($row["team"]!='' or $row["style"]!='' or $row["schedule"]!='' or $row["color"]!='' )
                            {
    
                                //update fr data
                                $link->query("UPDATE $bai_pro2.fr_data SET team = '".$line[1]."', style = '".$line[4]."', smv = '".$line[5]."',fr_qty = '".$line[7]."',hours = '".$hours."',schedule = '".$line[2]."', color = '".$line[3]."' WHERE frdate ='".$newDate."' AND team='".$line[1]."' AND style='".$line[4]."' AND schedule = '".$line[2]."' AND color = '".$line[3]."'");
            					// echo "UPDATE fr_data SET team = '".$line[1]."', style = '".$line[4]."', smv = '".$line[5]."',fr_qty = '".$line[7]."',hours = '".$hours."',schedule = '".$line[2]."', color = '".$line[3]."' WHERE frdate ='".$newDate."' AND team='".$line[1]."' AND style='".$line[4]."' AND schedule = '".$line[2]."' AND color = '".$line[3]."'";
            					// echo "</br>";
                               
                                echo "<div class='alert alert-success'>
                                  <strong>Success!</strong> FR Data Successfully Updated .
                                </div>";

                            }
                        }
                }else{

                    //insert fr data into database
                    $link->query("INSERT INTO $bai_pro2.fr_data (frdate,team,style,smv,fr_qty,hours,schedule,color) VALUES ('".$newDate."','".$line[1]."','".$line[4]."','".$line[5]."','".$line[7]."','".$hours."','".$line[2]."','".$line[3]."')");
					// echo "INSERT INTO fr_data (frdate,team,style,smv,fr_qty,hours,schedule,color) VALUES ('".$newDate."','".$line[1]."','".$line[4]."','".$line[5]."','".$line[7]."','".$hours."','".$line[2]."','".$line[3]."')";
					// echo "</br>";
                  
                     // echo "<div class='alert alert-success'>
                                  // <strong>Success!</strong> FR Data Successfully Inserted.
                            // </div>";
                }
            }            
            //close opened csv files

            $new_filename=$_FILES['file']['name'];
       
            $path_new="../".getFullURL($_GET['r'],"uploads/$new_filename","R");
       
            if(file_exists($path_new))
            {
  
                $url = getFullURL($_GET['r'],'upload_fr.php','N');
                echo "<script>
                        sweetAlert('Oops','File Already Exists','error')
                        setTimeout(
                        function(){
                            location.href = ' $url ';
                        },3000);
                        </script>";
                exit();
            }
            else
            {
               $new_filename=$chk_ext1[0].".".$chk_ext1[1];
                $path_new="../".getFullURL($_GET['r'],"uploads/$new_filename","R");
                move_uploaded_file($_FILES["file"]["tmp_name"],$path_new);
                echo "<script>sweetAlert('OK','file Uploaded Sucessfully','success')</script>";
                $url = getFullURL($_GET['r'],'upload_fr.php','N');
                echo "<script>
                        sweetAlert('Oops','File Already Exists','error')
                        setTimeout(
                        function(){
                            location.href = ' $url ';
                        },3000);
                        </script>";
            }
            fclose($csvFile);
			// echo "<div class='alert alert-success'>
            //                      <strong>Success!</strong> FR Data Successfully Inserted.
            //       </div>";
            // $qstring = '?status=succ';
        }else{
            // $qstring = '?status=err';
        }
    }else{
        echo "<script>sweetAlert('Oops','Invalid File','error')</script>";
        $url = getFullURL($_GET['r'],'upload_fr.php','N');
        echo "<script>
                sweetAlert('Oops','Please Update .CSV File','error')
                setTimeout(
                function(){
                    location.href = ' $url ';
                },3000);
            </script>";
      
    }

}
