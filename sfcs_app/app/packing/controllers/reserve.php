<?php

include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php', 3, 'R')); 
$plant_code = $_SESSION['plantCode'];
$username = $_SESSION['userName'];
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
			$count_value = 0;
			foreach ($clrs as $key => $value) {
				if($query[$value] != '')
				{
					$sql1="insert into $pps.ship_stat_log set ship_style=\"$style_new\",ship_schedule=\"$schedule_new\",ship_color=\"".trim($value)."\",plant_code=\"".$plant_code."\",created_user=\"".$username."\",ship_status=\"1\",ship_remarks=\"$rmks\",".substr($query[$value],0,-1);
					// echo "<br/> query1=".$sql;
					mysqli_query($link, $sql1) or exit("Sql Error inserting-all_color".mysqli_error($GLOBALS["___mysqli_ston"]));
					$ship_update_tid1 = mysqli_insert_id($link);
					$count_value++;
					if($count_value == 1)
					{
						$ship_update_value = 'R-'.$schedule_new.'-'.$ship_update_tid1;
						$sql23 = "UPDATE `pps`.`ship_stat_log` SET ship_up_date = '$ship_update_value', ship_cartons=".abs($crts).", created_user=".$username." where ship_tid = ".$ship_update_tid1." AND plant_code=".$plant_code;
						mysqli_query($link, $sql23) or exit("Sql Error updating-all_color_first".mysqli_error($GLOBALS["___mysqli_ston"]));
					}
					else
					{
						$sql24 = "UPDATE `pps`.`ship_stat_log` SET ship_up_date ='$ship_update_value',created_user ='$username' where ship_tid = ".$ship_update_tid1." AND plant_code=".$plant_code;
						mysqli_query($link, $sql24) or exit("Sql Error updating-all_color".mysqli_error($GLOBALS["___mysqli_ston"]));
					}
				}
				
			}
		}
		else
		{
			$sql2="insert into $bai_pro3.ship_stat_log set ship_style=\"$style_new\",ship_schedule=\"$schedule_new\",ship_color=\"$color_new\",ship_status=\"1\",ship_remarks=\"$rmks\",ship_cartons=".abs($crts).",".implode(",",$query);
			// echo "<br/> query2=".$sql;
			mysqli_query($link, $sql2) or exit("Sql Error inserting-color".mysqli_error($GLOBALS["___mysqli_ston"]));
			$ship_update_tid = mysqli_insert_id($link);
			
			$sql22 = "UPDATE `bai_pro3`.`ship_stat_log` SET ship_up_date = CONCAT('R','-',$schedule_new,'-',$ship_update_tid) where ship_tid = $ship_update_tid";
			mysqli_query($link, $sql22) or exit("Sql Error updating-color".mysqli_error($GLOBALS["___mysqli_ston"]));
		}
	}
	$url = getFullURL($_GET['r'],'test.php','N');
	// echo "<h2><font color='green'>Successfully Updated!</font></h2>";
	echo "<script>sweetAlert('Successfully','Updated','success');</script>";
	echo "<script type='text/javascript'> setTimeout(\"Redirect()\",200); function Redirect() {  location.href = '$url'; }</script>";
}

?>