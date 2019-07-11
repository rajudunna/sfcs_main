<?php
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
$has_permission = haspermission($_GET['r']);

?>
<html>
<head>
<title>Review Log</title>
<style type="text/css" media="screen">
/*@import "../TableFilter_EN/filtergrid.css";*/
</style>
<script language="javascript" type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/TableFilter_EN/tablefilter.js',3,'R'); ?>"></script>
<script language="javascript" type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/TableFilter_EN/actb.js',3,'R'); ?>"></script>
</head>

<body>

<div class = "panel panel-primary">
<div class = "panel-heading">Pending Review</div>
<div class = "panel-body">

<?php

if(isset($_GET['exec']))
{
	$status=$_GET['status'];
	$verified_by=$_GET['verified_by'];
	$confirmed_by=$_GET['confirmed_by'];
	$yer_mon=$_GET['yer_mon'];
	
	if($status==1)
	{
		$sql="update $bai_pro.tbl_freez_plan_track set track_status=$status,verified_by='".$verified_by."',verified_on='".date("Y-m-d H:i:s")."' where yer_mon='$yer_mon' and track_status=".($status-1);
		// echo $sql.'<br/>';
		mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));	
	}	
	if($status==2)
	{
		$sql="update $bai_pro.tbl_freez_plan_track set track_status=$status,verified_by=$verified_by,confirmed_on='".date("Y-m-d H:i:s")."', confirmed_by=$confirmed_by where yer_mon='$yer_mon' and track_status=".($status-1);		
		mysqli_query($link, $sql) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));	
		
		$sql="insert ignore into $bai_pro.tbl_freez_plan_log select * from $bai_pro.tbl_freez_plan_tmp where left(date,7)=left('$yer_mon',7)";	
		mysqli_query($link, $sql) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));	
		
		$sql="delete from $bai_pro.tbl_freez_plan_tmp where left(date,7)=left('$yer_mon',7)";
		mysqli_query($link, $sql) or exit("Sql Error3".mysqli_error($GLOBALS["___mysqli_ston"]));	
		$data_sym="$";
		$all_dates=array();
		$half_all_dates=array();
		$all_dates1=array();
		$half_all_dates1=array();
		$dat_mo=substr($yer_mon,0,7);
		//echo $dat_mo."<br>";
		$plan_fac=0;$vs_value=0;$ms_value=0;$fac_sah=0;$plan_sah_mod=array();
		$sql1="SELECT DATE,SUM(plan_sah) AS sah,RIGHT(DATE,2)AS daten FROM $bai_pro.`tbl_freez_plan_log` WHERE left(date,7)='$dat_mo' GROUP BY DATE*1";
		$sql_result=mysqli_query($link, $sql1) or exit("Sql Error4".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row1=mysqli_fetch_array($sql_result))
		{			
			if($sql_row1["sah"]==0)
			{
				$half_all_dates[]=$sql_row1["daten"];
				$half_all_dates1[]=$sql_row1["daten"];
				$all_dates[]=$sql_row1["DATE"];
				$all_dates1[]=$sql_row1["daten"];				
			}
			else
			{
				$half_all_dates[]=$sql_row1["daten"];
				$half_all_dates1[]=$sql_row1["daten"];
				$all_dates[]=$sql_row1["DATE"];
				$all_dates1[]=$sql_row1["daten"];
			}
			$fac_sah=$fac_sah+$sql_row1["sah"];
		}
		$vs_value=$fac_sah;
		
		$sec_sah="";$i=0;
		$sql12="SELECT sec_no,SUM(plan_sah) AS sah FROM $bai_pro.`tbl_freez_plan_log` WHERE LEFT(DATE,7)='$dat_mo' AND sec_no>0 GROUP BY sec_no*1;";

		$sql_result2=mysqli_query($link, $sql12) or exit("Sql Error5".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row12=mysqli_fetch_array($sql_result2))
		{			
			if($i==0)
			{
				$sec_sah="'".$i."'=>'".$sql_row12["sah"]."'";
			}
			else
			{
				$sec_sah.=",'".$i."'=>'".$sql_row12["sah"]."'";
			}	
			$i++;
		}
		$File = getFullURLLevel($_GET['r'],'dashboards/controllers/PLD_Dashboard/sah_monthly_status/data.php',2,'R');
		$fh = fopen($File, 'w') or die("Can't Open the File"); 
		$stringData = "<?php ".$data_sym."date=array('".implode("','",$all_dates)."'); ".$data_sym."half_date=array('".implode("','",$half_all_dates)."'); ".$data_sym."date1=array('".implode("','",$all_dates1)."'); ".$data_sym."half_date1=array('".implode("','",$half_all_dates1)."'); ".$data_sym."fac_plan=\"".$fac_sah."\"; ".$data_sym."vs_plan=\"".$vs_value."\"; ".$data_sym."ms_plan=\"".$ms_value."\"; ".$data_sym."fac_plan_sah=\"".$fac_sah."\"; ".$data_sym."plan_sah_mod=array(".$sec_sah."); ?>";
		fwrite($fh, $stringData);
		fclose($fh);	
	}
}

echo "<table id=\"table_one\" border=1 class='table table-bordered '>";
echo "<thead><tr><th>Date</th><th>Verified By</th><th>Verified On</th><th>Confirmed By</th><th>Confirmed On</th><th>Control</th></tr></thead>";

$sql="select * from $bai_pro.tbl_freez_plan_track where track_status<>2";
// echo $sql."<br>";
$sql_result=mysqli_query($link, $sql) or exit("Sql Error7".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row=mysqli_fetch_array($sql_result))
{	
		$yer_mon=$sql_row['yer_mon'];
		$verified_by=$sql_row['verified_by'];
		$verified_on=$sql_row['verified_on'];
		$confirmed_by=$sql_row['confirmed_by'];
		$confirmed_on=$sql_row['confirmed_on'];
		$track_status=$sql_row['track_status'];
		echo "<tbody><tr>";
		echo "<td>$yer_mon</td>";
		if($track_status!=0)
		{
			echo "<td>$verified_by</td>";
			echo "<td>$verified_on</td>";
		}
		else		
		{
			echo "<td></td><td></td>";
		}
			echo "<td>$confirmed_by</td>";	
			echo "<td>$confirmed_on</td>";			
			echo "<td>";
		switch($track_status)
		{
			case 0:
			{
				if(in_array($authorized,$has_permission))
				{
					$sql2="select * from $bai_pro.tbl_freez_plan_tmp where date='$yer_mon'";
					// echo $sql2."<br>";
					$sql_result2=mysqli_query($link, $sql2) or exit("Sql Error8".mysqli_error($GLOBALS["___mysqli_ston"]));

					$sql3="select * from $bai_pro.tbl_freez_plan_track where yer_mon='$yer_mon'";
					// echo $sql3."<br>";
					$sql_result3=mysqli_query($link, $sql3) or exit("Sql Error9".mysqli_error($GLOBALS["___mysqli_ston"]));
					while($sql_row3=mysqli_fetch_array($sql_result3))
					{
						$verified_by = $sql_row3['verified_by'];
					}
					if(mysqli_num_rows($sql_result2)>0)
					{
						echo "<a href=\"".getFullURL($_GET['r'], "review_log.php", "N")."&exec=1&status=1&verified_by=$verified_by&yer_mon=$yer_mon\"><button class='btn btn-info'>Verify</button></a>";
					}
					else
					{
						echo "Pleaes check the uploaded plan.";
					}					
				}
				
				break;
			}
			case 1:
			{
				if(in_array($approve,$has_permission))
				{
					$confirmed_by=getrbac_user()['uname'];
					echo "<a href=\"".getFullURL($_GET['r'], "review_log.php", "N")."&exec=1&status=2&verified_by='".$verified_by."'&confirmed_by='".$confirmed_by."'&yer_mon=$yer_mon\"><button class='btn btn-success'>Confirm</button></a>";
				}
				break;
			}
			default:
			{
				echo "";
			}
		}
		echo "</td>";
		echo "</tr>";
}
echo "</tbody></table>";

?>

</div>
</div>
</div>
</body>
</html>
