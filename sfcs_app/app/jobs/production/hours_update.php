<?php 
$start_timestamp = microtime(true);
$include_path=getenv('config_job_path');
include($include_path.'\sfcs_app\common\config\config_jobs.php');

$date=date("Y-m-d");
$y=date("yy",strtotime($date));
$sql_shift="select remarks from bai_hr_tna_em_$y.calendar where date=\"".$date."\" and day_type not in ('O','H')";
// echo $sql_shift."<br>";
$result_shift=mysqli_query($link_hrms, $sql_shift) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
 $count1=mysqli_num_rows($result_shift);
while($row_shift=mysqli_fetch_array($result_shift))
{
	 $shift_ex=$row_shift["remarks"];
}

if($count1==0){

}
else
{

    $shift_ex_explode=explode("$",$shift_ex);
    for($i=0; $i< sizeof($shift_ex_explode); $i++){

        // echo $shift_ex_explode[$i]."<br>";
        $shift_name=explode('/',$shift_ex_explode[$i]);
        $shift=$shift_name[0];
        // echo $shift."<br>";
        $time_name1=explode('-',$shift_name[1]);

        $time_name=explode(':',$time_name1[0]);
        $time_namex=explode(':',$time_name1[1]);
        $shift_start_time=$time_name[0];
        $shift_end_time=$time_namex[0];

            $sql="select * from $bai_pro.pro_atten_hours where date='$date' and shift='$shift'";
            // echo $sql."<br>";
            $sql_res=mysqli_query($link, $sql) or exit("Sql Error88 $sql11".mysqli_error($GLOBALS["___mysqli_ston"]));
            $count=mysqli_num_rows($sql_res);
            if($count == 0)
            {
                $sql1="insert ignore INTO $bai_pro.pro_atten_hours (date,shift,start_time,end_time) VALUES ('".$date."','".$shift."','".$shift_start_time."','".$shift_end_time."')";
            // echo $sql1."<br>";

                mysqli_query($link, $sql1) or exit("Sql Error88 $sql1".mysqli_error($GLOBALS["___mysqli_ston"]));
            }
            else
            {
                $sql2="update $bai_pro.pro_atten_hours set start_time='".$shift_start_time."',end_time='".$shift_end_time."' where date='".$date."' and shift='".$shift."' ";
            // echo $sql2."<br>";

                mysqli_query($link, $sql2) or exit("Sql Error88 $sql".mysqli_error($GLOBALS["___mysqli_ston"]));
            }
    }
}


?>

