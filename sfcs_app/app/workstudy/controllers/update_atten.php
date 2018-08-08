<?php
    include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
    $view_emp_data = getFullURL($_GET['r'],'view_emp_data.php','N');
    
    
    // $mod_names = array("1","2", "3", "4", "5", "6", "7", "8", "9", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19", "20", "21", "22", "23", "24", "25", "26", "27", "28", "29", "30", "31", "32", "33", "34", "35", "36", "37", "38", "39", "40");
    $today = $_POST['dat'];
    $module='';
    $module_query="SELECT module_id FROM $bai_pro3.plan_modules ORDER BY module_id*1";
    //echo $module_query;
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
        //$sql="INSERT INTO pro_atten  (atten_id, DATE, avail_A, avail_B, absent_A, absent_B, module, remarks) VALUES ('".$today."-".$mod_names[$i]."','".$today."','".$_POST['pr'.$i]."','0','".$_POST['ab'.$i]."','0','$mod_names[$i]','-')";
        mysqli_query($link, $sql) or exit("Error Updating Attendance");   
    }
    //echo $today;
    echo '<div class="panel panel-default" style="color:green"><center><h3>Successfully updated!</h3></center</div>';
    echo ("<SCRIPT LANGUAGE='JavaScript'>
    window.alert('Succesfully Updated')
    var ajax_url ='$view_emp_data'&date=$today';Ajaxify(ajax_url);

    </SCRIPT>");
   
?>