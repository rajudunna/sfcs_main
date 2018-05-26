<?php
//This interface is used to transfer material from one schedule to another.

$username_list=explode('\\',$_SERVER['REMOTE_USER']);
$username=strtolower($username_list[1]);
?>
<html>
<head>

<style>
body
{
	font-family: arial;
}
table
{
	border-collapse:collapse;
	font-size:12px;
}
td
{
	border: 1px solid red;
	white-space:nowrap;
	border-collapse:collapse;
}

th
{
	border: 1px solid red;
	white-space:nowrap;
	border-collapse:collapse;
	width: 150px;
}
</style>


</head>

<body>



<?php
include("../".getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));

{
	$style=$_POST['style'];
	$schedule=$_POST['schedule']; 
	$color=$_POST['color'];
	$source_sch=$_POST['source_sch'];
	$size=$_POST['size'];
	$required=$_POST['required'];
	$module=$_POST['module'];
	$team=$_POST['team'];
	$reason=$_POST['reason'];
	
	for($i=0;$i<sizeof($required);$i++){
		if($required[$i]>0){
			$sql="insert into $bai_pro3.bai_qms_transfers_log(style,color,source_sch,desti_sch,size,req_qty,module,team,req_by,req_time,status,reason) values ('$style','$color','".$source_sch[$i]."','$schedule','".$size[$i]."',".$required[$i].",'$module','$team','$username','".date("Y-m-d H:i:s")."',2,$reason)";
			mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			$Lid=((is_null($___mysqli_res = mysqli_insert_id($link))) ? false : $___mysqli_res);
			
			//Deduct from source schedule
			$sql="insert into $bai_pro3.bai_qms_db(qms_style,qms_color,qms_schedule,log_user,log_date,qms_size,qms_qty,qms_tran_type,remarks) values ('$style','$color','".$source_sch[$i]."','$username','".date("Y-m-d")."','".$size[$i]."',".$required[$i].",10,'TRN$$Lid')";
			mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			
			//Update Addition Quantities
			$sql="insert into $bai_pro3.bai_qms_db(qms_style,qms_color,qms_schedule,log_user,log_date,qms_size,qms_qty,qms_tran_type,remarks) values ('$style','$color','".$schedule."','$username','".date("Y-m-d")."','".$size[$i]."',".$required[$i].",11,'TRN$$Lid')";
			mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			
		}
	}
	
	
	echo "<h2>Successfully Submitted.</h2>";
}

?>
</body>
</html>