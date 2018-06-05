<?php

$command ='webshotcmd /url "http://bai2net:8080/Projects/Beta/bai_bcip/SAH_Countdown/Plan_sah.php" /bwidth 1500 /bheight 700 /out echart.png /username bainet /password pass@123';

shell_exec($command);
 echo "<script language=\"javascript\"> setTimeout(\"CloseWindow()\",0); function CloseWindow(){ window.open('','_self',''); window.close(); } </script>";
//echo "<img src = 'echart.png'>";

?>