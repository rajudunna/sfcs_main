<!--
Code Module:M3 to SFS data upload

Description:uploading converted text file to database and then root the process flow to nwxt level.

Changes Log:
-->
<?php
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));

	function round_or_not($x,$y)
	{	
		return round(($x/$y),0);				
	}
?>


<?php include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R')); ?>

<?php 
error_reporting(E_ALL ^ E_NOTICE);
?>

<?php
// Name of the file
//$filename = 'core_sql.txt';
$filename = $_GET['id'];
//echo $filename."<br>";
//die();
$date=$_GET['date'];

$uploaddir = $_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'uploads',0,'R'); 
$filepath= "$uploaddir/$filename";

$sql="truncate table $bai_pro.tbl_freez_plan_upload";

mysqli_query($link, $sql) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));

$sql="truncate table $bai_pro.tbl_freez_plan_tmp";
mysqli_query($link, $sql) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));

$sql="truncate table $bai_pro.tbl_freez_plan_log";

mysqli_query($link, $sql) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));

$handle=fopen($filepath,"r");
fgetcsv($handle);

$teams=$shifts_array;
$teams=str_replace('general','G',$teams);
$teamcount=count($shifts_array);
while(($data=fgetcsv($handle,1000,","))!==FALSE)
{				
		for($i=0;$i<sizeof($data);$i++){
				// echo $data[$i];
				if($data[$i]=='-'){
					$data[$i]=0;
					// echo 'hi'.$data[$i];
				}

			}	
			switch($data[2])
			{
				case "PEF_PER":
				{
					for($i=0;$i<$teamcount;$i++)
					{
						$sql="INSERT ignore INTO $bai_pro.tbl_freez_plan_upload 						(module,shift,value_type,d_1,d_2,d_3,d_4,d_5,d_6,d_7,d_8,d_9,d_10,d_11,d_12,d_13,d_14,d_15,d_16,d_17,d_18,d_19,d_20,d_21,d_22,d_23,d_24,d_25,d_26,d_27,d_28,d_29,d_30,d_31	)VALUES	('".$data[0]."','".$teams[$i]."','".$data[2]."','".$data[3]."','".$data[4]."','".$data[5]."','".$data[6]."','".$data[7]."','".$data[8]."','".$data[9]."','".$data[10]."','".$data[11]."','".$data[12]."','".$data[13]."','".$data[14]."','".$data[15]."','".$data[16]."','".$data[17]."','".$data[18]."','".$data[19]."','".$data[20]."','".$data[21]."','".$data[22]."','".$data[23]."','".$data[24]."','".$data[25]."','".$data[26]."','".$data[27]."','".$data[28]."','".$data[29]."','".$data[30]."','".$data[31]."','".$data[32]."','".$data[33]."')";
						mysqli_query($link, $sql) or exit("Sql Error3".mysqli_error($GLOBALS["___mysqli_ston"]));
					}
					break;
				}
				case "SAH_HRS":
				{
					$sag_val=array();
					$temp_val=array();
					for($k=3;$k<=33;$k++)
					{
						if($data[$k]>0)
						{					
							$temp_val[$k]=$data[$k];
							$sag_val[$k]=round_or_not($data[$k],$teamcount);
						}
						else
						{
							$sag_val[$k]=0;
							$temp_val[$k]=0;
						}						
					}				
					for($i=0;$i<$teamcount;$i++)
					{
						$j=1;
						for($k=3;$k<=33;$k++)
						{
							if($temp_val[$k]>0)
							{							
								$temp_vals=$temp_val[$k];
								$vals='val_'.$j;
								$$vals=0;
								if($temp_val[$k]>=$sag_val[$k])
								{
									$$vals=$sag_val[$k];
								}
								else
								{
									$$vals=$temp_vals;
									$temp_val[$k]=0;
								}
								$temp_val[$k]=$temp_val[$k]-$sag_val[$k];						
								$j++;
							}
							else
							{
								$vals='val_'.$j;
								$$vals=0;
								$j++;
							}
						}						
						$sql="INSERT ignore INTO $bai_pro.tbl_freez_plan_upload 						(module,shift,value_type,d_1,d_2,d_3,d_4,d_5,d_6,d_7,d_8,d_9,d_10,d_11,d_12,d_13,d_14,d_15,d_16,d_17,d_18,d_19,d_20,d_21,d_22,d_23,d_24,d_25,d_26,d_27,d_28,d_29,d_30,d_31	)VALUES	('".$data[0]."','".$teams[$i]."','".$data[2]."','$val_1','$val_2','$val_3','$val_4','$val_5','$val_6','$val_7','$val_8','$val_9','$val_10','$val_11','$val_12','$val_13','$val_14','$val_15','$val_16','$val_17','$val_18','$val_19','$val_20','$val_21','$val_22','$val_23','$val_24','$val_25','$val_26','$val_27','$val_28','$val_29','$val_30','$val_31')";
						mysqli_query($link, $sql) or exit("Sql Error4".mysqli_error($GLOBALS["___mysqli_ston"]));
						//echo $sql."<br>";
					}
					unset($temp_val);
					unset($sag_val);
					
					break;
				}
				case "PP_PCS":
				{
					$sag_val=array();
					$temp_val=array();
					for($k=3;$k<=33;$k++)
					{
						if($data[$k]>0)
						{					
							$temp_val[$k]=$data[$k];
							$sag_val[$k]=round_or_not($data[$k],$teamcount);
						}
						else
						{
							$sag_val[$k]=0;
							$temp_val[$k]=0;
						}						
					}				
					for($i=0;$i<$teamcount;$i++)
					{
						$j=1;
						for($k=3;$k<=33;$k++)
						{
							if($temp_val[$k]>0)
							{							
								$temp_vals=$temp_val[$k];
								$vals='val_'.$j;
								$$vals=0;
								if($temp_val[$k]>=$sag_val[$k])
								{
									$$vals=$sag_val[$k];
								}
								else
								{
									$$vals=$temp_vals;
									$temp_val[$k]=0;
								}
								$temp_val[$k]=$temp_val[$k]-$sag_val[$k];						
								$j++;
							}
							else
							{
								$vals='val_'.$j;
								$$vals=0;
								$j++;
							}
						}						
						$sql="INSERT ignore INTO $bai_pro.tbl_freez_plan_upload 						(module,shift,value_type,d_1,d_2,d_3,d_4,d_5,d_6,d_7,d_8,d_9,d_10,d_11,d_12,d_13,d_14,d_15,d_16,d_17,d_18,d_19,d_20,d_21,d_22,d_23,d_24,d_25,d_26,d_27,d_28,d_29,d_30,d_31	)VALUES	('".$data[0]."','".$teams[$i]."','".$data[2]."','$val_1','$val_2','$val_3','$val_4','$val_5','$val_6','$val_7','$val_8','$val_9','$val_10','$val_11','$val_12','$val_13','$val_14','$val_15','$val_16','$val_17','$val_18','$val_19','$val_20','$val_21','$val_22','$val_23','$val_24','$val_25','$val_26','$val_27','$val_28','$val_29','$val_30','$val_31')";
						mysqli_query($link, $sql) or exit("Sql Error4".mysqli_error($GLOBALS["___mysqli_ston"]));
						//echo $sql."<br>";
					}
					unset($temp_val);
					unset($sag_val);
					break;
				}
			}
}

for($i=1;$i<=31;$i++)
{
	$sql="select module,shift,sum(if(value_type='PP_PCS',d_$i,0)) as pcs,sum(if(value_type='SAH_HRS',d_$i,0)) as sah,max(if(value_type='PEF_PER',d_$i,0)) as eff,section_id from $bai_pro.tbl_freez_plan_upload left join $bai_pro.tbl_freez_plan_upload left join $bai_pro3.plan_modules on module=module_id group by concat(module,shift) group by concat(module_id,shift) ";
	$sql_result=mysqli_query($link, $sql) or exit("Sql Error8".mysqli_error($GLOBALS["___mysqli_ston"]));	
	while($sql_row=mysqli_fetch_array($sql_result))
	{	
		$module=$sql_row['module'];
		$shift=$sql_row['shift'];
		$pcs=$sql_row['pcs'];
		$sah=$sql_row['sah'];
		$eff=$sql_row['eff'];
		
		if($sah>0 and $eff>0)
		{
			$clh=round(($sah/$eff)*100,2);	
		}
		else
		{
			$clh=0;
		}
		
		$section=$sql_row['section_id'];
		
		$date_new=substr($date,0,8).$i;
		$ref_code=$date_new."-".$module."-".$shift;
		
		$sql="insert into $bai_pro.tbl_freez_plan_tmp (plan_tag,date,mod_no,shift,plan_eff,plan_pro,sec_no,plan_clh,plan_sah) values ('$ref_code','$date_new','$module','$shift','$eff','$pcs','$section','$clh','$sah')";
		
		 mysqli_query($link, $sql) or exit("Sql Error9".mysqli_error($GLOBALS["___mysqli_ston"]));
		
	}
}

$month_year=substr($date,0,8);

$sql1="select * from $bai_pro.tbl_freez_plan_track where CONCAT(YEAR(yer_mon),'-',MONTH(yer_mon))='".date("Y-m")."'";
$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error8".mysqli_error($GLOBALS["___mysqli_ston"]));
if(mysqli_num_rows($sql_result1)>0)
{
	while($sql_row1=mysqli_fetch_array($sql_result1))
	{	
		$sql="DELETE FROM $bai_pro.tbl_freez_plan_track WHERE yer_mon=\"".$sql_row1["yer_mon"]."\"";

		mysqli_query($link, $sql) or exit("Sql Error10".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		$sql="INSERT ignore INTO $bai_pro.tbl_freez_plan_track (yer_mon) values ('".$date."')";

		mysqli_query($link, $sql) or exit("Sql Error10".mysqli_error($GLOBALS["___mysqli_ston"]));
		
		$username = getrbac_user()['uname']; 
		
		$sql="update $bai_pro.tbl_freez_plan_track set verified_on='".date("Y-m-d H:i:s")."', verified_by='".$username."' where yer_mon='".$date."'";
		
		mysqli_query($link, $sql) or exit("Sql Error11".mysqli_error($GLOBALS["___mysqli_ston"]));
	}

}
else
{
	$sql="INSERT ignore INTO $bai_pro.tbl_freez_plan_track (yer_mon) values ('".$date."')";

	mysqli_query($link, $sql) or exit("Sql Error10".mysqli_error($GLOBALS["___mysqli_ston"]));
	
	$username = getrbac_user()['uname']; 
	
	$sql="update $bai_pro.tbl_freez_plan_track set verified_on='".date("Y-m-d H:i:s")."', verified_by='".$username."' where yer_mon='".$date."'";
	
	mysqli_query($link, $sql) or exit("Sql Error11".mysqli_error($GLOBALS["___mysqli_ston"]));
}




header("Location:".getFullURLLevel($_GET['r'],'log.php',0,'N')."&sdate=$date");

?>


















