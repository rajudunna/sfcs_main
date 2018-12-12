<?php
    include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
    $view_emp_data = getFullURL($_GET['r'],'view_emp_data.php','N');
    
    
    $today = $_POST['dat'];
    $module='';
    $module_query="SELECT module_id FROM $bai_pro3.plan_modules ORDER BY module_id*1";
    $module_result=mysqli_query($link, $module_query) or exit("Error Finding Modules");
    while($sql_row=mysqli_fetch_array($module_result))
    {
        $modules[]=$sql_row['module_id'];
    }
    for ($i = 0; $i < sizeof($modules); $i++)
    {
        $aa = $_POST['pr' . $i] . "<br>";   
        $mod=$_POST['mod' . $i];
        $ava = $_POST['pr' . $i];
        $abf = $_POST['abf' . $i];
        $abnf = $_POST['abnf' . $i];
        $jump = $_POST['jump' . $i];
        
        $sqls = "SELECT * FROM $bai_pro.pro_atten WHERE date='$today' AND module='$mod'";
        $result = mysqli_query( $link, $sqls) or exit("Sql Error4" . mysqli_error($GLOBALS["___mysqli_ston"]));
        $sql_row = mysqli_fetch_array($result);
        $avail_A = $sql_row['avail_A'];
        $avail_B = $sql_row['avail_B'];

        $sql = "UPDATE $bai_pro.pro_atten SET avail_A='".$ava."',jumpers='".$jump."',absent_A='".$abf."',absent_B='".$abnf."' WHERE date='".$today."' AND module='".$mod."'";
        mysqli_query($link, $sql) or exit("Error Updating Attendance");   
    }
    echo '<div class="panel panel-default" style="color:green"><center><h3>Successfully updated!</h3></center</div>';
    echo ("<SCRIPT LANGUAGE='JavaScript'>
    window.alert('Succesfully Updated')
    window.location.href='$view_emp_data'&date=$today';
    </SCRIPT>");
   
?>