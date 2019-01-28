<?php
    ini_set('max_execution_time', 360); 
    //load the database configuration file
    include (getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));

    if(isset($_POST['importSubmit']))
    {
        $count = 0;
        //validate whether uploaded file is a csv file
        $fname = $_FILES["file"]["name"];
        $chk_ext1 = explode(".",$fname);
        // $csvMimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain');
    	$csvMimes = array('csv');
        $url = getFullURL($_GET['r'],'upload_fr.php','N');
    	$file_type = pathinfo($fname, PATHINFO_EXTENSION);
        if(!empty($_FILES['file']['name']) && in_array($file_type,$csvMimes))
        {
            if(is_uploaded_file($_FILES['file']['tmp_name']))
            {
                //open uploaded csv file with read only mode
                $csvFile = fopen($_FILES['file']['tmp_name'], 'r');

                //parse data from csv file line by line
                while(($line = fgetcsv($csvFile)) != FALSE)
                {
                    if ($count > 0)
                    {
                        //check whether data already exists in database with same date
                        $ndate=$line[6];
                        $newDate = date("Y-m-d", strtotime($ndate));
                        $hours=$tot_plant_working_hrs;
                        
                        $prevQuery = "SELECT * FROM $bai_pro2.fr_data WHERE frdate ='".$newDate."' AND team='".$line[1]."' AND style='".$line[4]."' AND schedule = '".$line[2]."' AND color = '".$line[3]."'";              
                        $prevResult = $link->query($prevQuery);         
                        if($prevResult->num_rows > 0)
                        {
                            while($row = $prevResult->fetch_assoc())
                            {
                                $fr_id = $row["fr_id"];
                                if($row["team"]!='' or $row["style"]!='' or $row["schedule"]!='' or $row["color"]!='' )
                                {
                                    //update fr data
                                    $link->query("UPDATE $bai_pro2.fr_data SET team = '".$line[1]."', style = '".$line[4]."', smv = '".$line[5]."',fr_qty = fr_qty+".$line[7].",hours = '".$hours."',schedule = '".$line[2]."', color = '".$line[3]."' WHERE frdate ='".$newDate."' AND team='".$line[1]."' AND style='".$line[4]."' AND schedule = '".$line[2]."' AND color = '".$line[3]."'");

                                    if ($copy_fr_to_forecast == 'yes')
                                    {
                                        $check_in_line_forecast = "SELECT * FROM $bai_pro3.line_forecast where date='".$newDate."' AND module='".$line[1]."'";
                                        $line_forecast_result = $link->query($check_in_line_forecast);
                                        if (mysqli_num_rows($line_forecast_result) > 0)
                                        {
                                            // record already there in line_forecast table (so update)
                                            $update_line_forecast="UPDATE $bai_pro3.line_forecast set qty =qty+$line[7] where module ='".$line[1]."' and  date ='".$newDate."'";
                                            mysqli_query($link, $update_line_forecast) or exit("Error while updating to line_forecast (update fr_data)");
                                        }
                                        else
                                        {
                                            // record not there in line_forecast table (so insert)
                                            $insert_line_forecast="INSERT IGNORE INTO $bai_pro3.line_forecast (forcast_id, module, qty, date, reason) VALUES ('$fr_id', '".$line[1]."', '".$line[7]."', '".$newDate."', 'NIL')";
                                            mysqli_query($link, $insert_line_forecast) or exit("Error while saving to line_forecast (update fr_data)");
                                        }                                    
                                    }
                                }
                            }
                        }
                        else
                        {
                            //insert fr data into database
                            $link->query("INSERT INTO $bai_pro2.fr_data (frdate,team,style,smv,fr_qty,hours,schedule,color) VALUES ('".$newDate."','".$line[1]."','".$line[4]."','".$line[5]."','".$line[7]."','".$hours."','".$line[2]."','".$line[3]."')");
                            $fr_id = mysqli_insert_id($link);
                            if ($copy_fr_to_forecast == 'yes')
                            {
                                $check_in_line_forecast = "SELECT * FROM $bai_pro3.line_forecast where date='".$newDate."' AND module='".$line[1]."'";
                                $line_forecast_result = $link->query($check_in_line_forecast);
                                if (mysqli_num_rows($line_forecast_result) > 0)
                                {
                                    // record already there in line_forecast table (so update)
                                    $update_line_forecast="UPDATE $bai_pro3.line_forecast set qty =qty+$line[7] where module ='".$line[1]."' and  date ='".$newDate."'";
                                    mysqli_query($link, $update_line_forecast) or exit("Error while updating to line_forecast (insert fr_data)");
                                }
                                else
                                {
                                    // record not there in line_forecast table (so insert)
                                    $insert_line_forecast="INSERT IGNORE INTO $bai_pro3.line_forecast (forcast_id, module, qty, date, reason) VALUES ('$fr_id', '".$line[1]."', '".$line[7]."', '".$newDate."', 'NIL')";
                                    mysqli_query($link, $insert_line_forecast) or exit("Error while saving to line_forecast (insert fr_data)");
                                }
                            }
                        }
                    }
                    $count++;  
                }            
                //close opened csv files

                $new_filename=$_FILES['file']['name'];       
                $path_new="../".getFullURL($_GET['r'],"uploads/$new_filename","R");       
                if(file_exists($path_new))
                {  
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
                    echo "<script>
                            setTimeout(
                            function(){
                                location.href = ' $url ';
                            },3000);
                            </script>";
                }
                fclose($csvFile);
            }
            else
            {
                // $qstring = '?status=err';
            }
        }
        else
        {
            //echo "<script>sweetAlert('Oops','Invalid File','error')</script>";
            echo "<script>
                    sweetAlert('Oops','Please Update .CSV File','error')
                    setTimeout(
                    function(){
                        location.href = ' $url ';
                    },3000);
                </script>";
        }
    }
?>