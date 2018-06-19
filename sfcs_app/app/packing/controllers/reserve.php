<?php

include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php', 3, 'R')); 

if(isset($_POST['hold']))
{
	$style_new=$_POST['style_new'];
	$schedule_new=$_POST['schedule_new'];
	$color_new=$_POST['color_new'];
	$crts=$_POST['crts'];
	$qty=$_POST['qty'];
	$size=$_POST['size'];
	$query=array();
	$rmks=$_POST['rmks'];
	
	//echo "<br/>Color=".$color_new;

	for($i=0;$i<sizeof($qty);$i++)
	{
		if($qty[$i]>0)
		{
			$query[]="ship_s_".strtolower($size[$i])."=".$qty[$i];
		}
	}
	
	if(sizeof($query)>0)
	{
		if($color_new=='0')
		{
			$sql="insert into $bai_pro3.ship_stat_log set ship_style=\"$style_new\",ship_schedule=\"$schedule_new\",ship_status=\"1\",ship_remarks=\"$rmks\",ship_cartons=".abs($crts).",".implode(",",$query);
		}
		else
		{
			$sql="insert into $bai_pro3.ship_stat_log set ship_style=\"$style_new\",ship_schedule=\"$schedule_new\",ship_color=\"$color_new\",ship_status=\"1\",ship_remarks=\"$rmks\",ship_cartons=".abs($crts).",".implode(",",$query);
		}
		//echo "<br/> query=".$sql;;
		mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	}
	$url = getFullURL($_GET['r'],'test.php','N');
	// echo "<h2><font color='green'>Successfully Updated!</font></h2>";
	echo "<script>sweetAlert('Successfully','Updated','success');</script>";
	echo "<script type='text/javascript'> setTimeout(\"Redirect()\",200); function Redirect() {  location.href = '$url'; }</script>";
}

?>