<!--
2015-03-28/kirang/CR#930/Need To Incorporate the Planning default comments in the Weekly delivery Report.
--!>
<?php
include($_SERVER['DOCUMENT_ROOT'].getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
// $username_list=explode('\\',$_SERVER['REMOTE_USER']);
// $username=$username_list[1];
$username="sfcsproject1";

if(isset($_GET['id']) and isset($_GET['content']))
{

$code=substr($_GET['id'],0,1);
$id=substr($_GET['id'],1);
$content=$_GET['content'];


$sql="select remarks from $bai_pro4.week_delivery_plan where ref_id=$id";
// echo $sql."----1"."<br>";
// mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row=mysqli_fetch_array($sql_result))
{
	$remarks=$sql_row['remarks'];
}

$remarks_new=array();
$remarks_new=explode("^",$remarks);

switch($code)
{
	case "A":
	{
		$remarks_new[0]=$content;
		break;
	}
	case "B":
	{
		$remarks_new[1]=$content;
		break;
	}
	case "C":
	{
		$remarks_new[2]=$content;
		break;
	}
}

		$sql1="update $bai_pro4.week_delivery_plan set remarks=\"".implode("^",$remarks_new)."\" where ref_id=$id";
		// echo $sql1."<br>";
		mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		//TO Track Operations
		$sql1="insert into $bai_pro4.query_edit_log(query_executed) values ('111".$sql1."/".$username."')";
		// echo $sql1."<br>";
		mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		//TO Track Operations
	
}	

if(isset($_POST['update']))
{
	$count = 0;
	$B=$_POST['B'];
	$C=$_POST['C'];
	$A=$_POST['A'];
	$schedule_no=$_POST['schedule_no'];
	$color=$_POST['color'];
	$title_size=$_POST['title_size'];
	$REF=$_POST['REF'];
	$rev_exfa=$_POST['rev_exfa'];
	
	for($i=0;$i<sizeof($rev_exfa);$i++)
	{
		echo $i."=".$REF[$i]."/".$rev_exfa[$i]."/A=".$A[$i]."/".$B[$i]."/".$C[$i]."/".$color[$i]."/".$schedule_no[$i]."<br>";
		if($rev_exfa[$i]!="0000-00-00" || $A[$i] > 0 || strlen($B[$i]) > 0 || strlen($C[$i]) > 0)
		{
			$sql_remarks_ref="select * from $bai_pro4.weekly_delivery_plan_remarks where schedule_no='".$schedule_no[$i]."' and color_des='".$color[$i]."' and size_ref='".$title_size[$i]."' and ref_id='".$REF[$i]."'";
			echo $sql_remarks_ref."<br>";
			$sql_remarks_ref_result=mysqli_query($link, $sql_remarks_ref) or exit("Sql Error61".mysqli_error($GLOBALS["___mysqli_ston"]));
			$rows_count=mysqli_num_rows($sql_remarks_ref_result);
			if($rows_count == 0)
			{
				$sql2="insert into $bai_pro4.weekly_delivery_plan_remarks(schedule_no,color_des,size_ref,ref_id,planning_remarks,commitments,remarks,ex_factory_date) values('".$schedule_no[$i]."','".$color[$i]."','".$title_size[$i]."','".$REF[$i]."','".$A[$i]."','".$B[$i]."','".$C[$i]."','".$rev_exfa[$i]."')";	
				// echo $sql2."<br>";
				mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));		
				
				$sql1="insert into $bai_pro4.query_edit_log(query_executed,user_name) values (\"".$sql2."\",'".$username."')";
				// echo $sql1."<br>";
				mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));		
				$count++;
			}
			else
			{
				$sql2="update bai_pro4.weekly_delivery_plan_remarks set planning_remarks='".$A[$i]."',commitments='".$B[$i]."',remarks='".$C[$i]."',ex_factory_date='".$rev_exfa[$i]."' where schedule_no='".$schedule_no[$i]."' and color_des='".$color[$i]."' and size_ref='".$title_size[$i]."' and ref_id='".$REF[$i]."'";	
				// echo $sql2."<br>";
				mysqli_query($link, $sql2) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));		
				
				$sql1="insert into query_edit_log(query_executed,user_name) values (\"".$sql2."\",'".$username."')";
				// echo $sql1."<br>";
				mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));	
				$count++;
			}	
		}
	}
	if($flag > 0){
		echo '<script>sweetAlert("Successfully Updated","","success")</script>';
	}else{
		echo '<script>sweetAlert("Nothing to Update","","warning")</script>';
	}
	
	$back_url = getFullURL($_GET['r'],'week_Delivery_plan_view3_v2.php','N');
	//header("location:$back_url");
	echo "<script>
			setTimeout(function(){
				window.location.href='$back_url';
			},2000);
		</script>";
}	

?>

