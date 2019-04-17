<?php

include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php', 3, 'R')); 

if(isset($_POST['hold']))
{
	$style_new=$_POST['style_new'];
	$schedule_new=$_POST['schedule_new'];
	$color_new=$_POST['color_new'];
	$color_new1=$_POST['color_new1'];
	$crts=$_POST['crts'];
	$qty=$_POST['qty'];
	$size=$_POST['size'];
	$query=array();
	$rmks=$_POST['rmks'];
	$clrs = array_unique($color_new);
	// echo "<br/>Color=".$color_new;


	foreach ($qty as $key => $value) 
	{
		if($color_new1=='1')
		{
			if($qty[$key] > 0)
			{
				$query[$color_new[$key]].="ship_s_".strtolower($size[$key])."=".$qty[$key].",";
			}
		}
		else
		{
			if($qty[$key] > 0)
			{
				$query[]="ship_s_".strtolower($size[$key])."=".$qty[$key];
			}
		}
	}

	if(sizeof($query)>0)
	{
		if($color_new1=='1')
		{
			foreach ($clrs as $key => $value) {
				if($query[$value] != '')
				{
					$sql="insert into $bai_pro3.ship_stat_log set ship_style=\"$style_new\",ship_schedule=\"$schedule_new\",ship_color=\"".trim($value)."\",ship_status=\"1\",ship_remarks=\"$rmks\",ship_cartons=".abs($crts).",".substr($query[$value],0,-1);
					// echo "<br/> query1=".$sql;
					mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				}
				
			}
		}
		else
		{
			$sql="insert into $bai_pro3.ship_stat_log set ship_style=\"$style_new\",ship_schedule=\"$schedule_new\",ship_color=\"$color_new\",ship_status=\"1\",ship_remarks=\"$rmks\",ship_cartons=".abs($crts).",".implode(",",$query);
			// echo "<br/> query2=".$sql;
			mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
		}
	}
	$url = getFullURL($_GET['r'],'test.php','N');
	// echo "<h2><font color='green'>Successfully Updated!</font></h2>";
	echo "<script>sweetAlert('Successfully','Updated','success');</script>";
	echo "<script type='text/javascript'> setTimeout(\"Redirect()\",200); function Redirect() {  location.href = '$url'; }</script>";
}

?>