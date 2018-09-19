
<?php
    include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));
    if(isset($_POST["submit"])) 
    { 
        $excess_cut = $_POST['excess_cut'];
        $schedule = $_POST['schedule'];
        $style = $_POST['style'];
        $color = $_POST['color'];
        $user = $_POST['user'];
        $excess_cut_log_qry = "insert into $bai_pro3.excess_cuts_log(schedule_no,color,excess_cut_qty,date,user) values('".$schedule."','".$color."',".$excess_cut.",NOW(),'".$user."')";
        $excess_cut_log_result = mysqli_query($link,$excess_cut_log_qry) or exit(" Error7".mysqli_error ($GLOBALS["___mysqli_ston"]));
            echo "<script type=\"text/javascript\"> 
            sweetAlert('Excess Cut updated','','success');
            setTimeout(\"Redirect()\",0); 
            function Redirect(){	 
                    location.href = \"".getFullURL($_GET['r'], "main_interface.php","N")."&color=$color&style=$style&schedule=$schedule&excess_cut=$excess_cut\"; 
                }
        </script>";	
    }
?>