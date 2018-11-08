
<?php
    include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));
    if(isset($_POST["submit"])) 
    { 
       
        $cut1 = $_POST['cut1'];
       
        if($cut1 != ''){
            $excess_cut = $_POST['cut1'];
            $schedule = $_POST['schedule'];
            $style = $_POST['style'];
            $color = $_POST['color'];
            $user = $_POST['user'];
            $query = "select * from $bai_pro3.excess_cuts_log where schedule_no='".$schedule."' and color='".$color."'";
            // echo $query;
            $query_result = mysqli_query($link,$query) or exit(" Error78".mysqli_error ($GLOBALS["___mysqli_ston"]));
            if(mysqli_num_rows($query_result)>0){
                $query1 = "update $bai_pro3.excess_cuts_log set excess_cut_qty='".$_POST['cut1']."' where schedule_no='".$schedule."' and color='".$color."'";
                $query_result1 = mysqli_query($link,$query1) or exit(" Error7".mysqli_error ($GLOBALS["___mysqli_ston"]));
                echo "<script type=\"text/javascript\"> 
                sweetAlert('Excess Cut Updated','','success');
                setTimeout(\"Redirect()\",0); 
                function Redirect(){	 
                        location.href = \"".getFullURL($_GET['r'], "main_interface.php","N")."&color=$color&style=$style&schedule=$schedule&excess_cut=$excess_cut\"; 
                    }
                </script>";	
            }
            
        }else {
            $excess_cut = $_POST['excess_cut'];
            $schedule = $_POST['schedule'];
            $style = $_POST['style'];
            $color = $_POST['color'];
            $user = $_POST['user'];
            $excess_cut_log_qry = "insert into $bai_pro3.excess_cuts_log(schedule_no,color,excess_cut_qty,date,user) values('".$schedule."','".$color."',".$excess_cut.",NOW(),'".$user."')";
            $excess_cut_log_result = mysqli_query($link,$excess_cut_log_qry) or exit(" Error7".mysqli_error ($GLOBALS["___mysqli_ston"]));
                echo "<script type=\"text/javascript\"> 
                sweetAlert('Excess Cut Inserted','','success');
                setTimeout(\"Redirect()\",0); 
                function Redirect(){	 
                        location.href = \"".getFullURL($_GET['r'], "main_interface.php","N")."&color=$color&style=$style&schedule=$schedule&excess_cut=$excess_cut\"; 
                    }
            </script>";	
        }
       
    }
?>