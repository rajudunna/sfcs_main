<?php
		include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
	 	$view_emp_data = getFullURLLevel($_GET['r'],'view_emp_data.php',0,'N');	
		for($i=0 ; $i<40; $i++)
		{			
			$aa=$_POST['pr'.$i]."<br>";
			$today=$_POST['date'];
			$sql="INSERT INTO $bai_pro.pro_atten  (atten_id,DATE,avail_A,jumpers,absent_A, absent_B, module, remarks) VALUES ('".$today."-".$mod_names[$i]."','".$today."','".$_POST['pr'.$i]."','".$_POST['ju'.$i]."','".$_POST['abf'.$i]."','".$_POST['abnf'.$i]."','$mod_names[$i]','-')";

			mysqli_query($link, $sql) or exit("<div class='alert alert-danger' style='color:white'><center><h3><b>The Attendance Is Already Updated For the Selected Date.</b></h3></center></div>");
			echo mysqli_error($GLOBALS["___mysqli_ston"]);
		}
?>
<div class="alert alert-success" style="color:white"><center><h3>Successfully Updated Employee Attendance</h3></center></div>
<span class="pull-right">
	<a href="<?= $view_emp_data.'&date='.$today;  ?>" class='btn btn-primary btn-lg'>View Attendance >></a>
</span>