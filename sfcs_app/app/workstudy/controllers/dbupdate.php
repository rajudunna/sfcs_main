<!--
Code Module:M3 to SFS data upload

Description:uploading converted text file to database and then root the process flow to nwxt level.

Changes Log:
-->
<?php
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));


function round_or_not($x,$y,$z)
{
	//$z 1-Yes, 0-No
	
	if($z==1)
	{
		return round(($x/$y),0);
	}
	else
	{
		return $x/$y;
	}	
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

$teams=array("A","B","C","D");
while(($data=fgetcsv($handle,1000,","))!==FALSE)
{
	/*		
	$sql="INSERT INTO tbl_freez_plan_upload 
(module,shift,value_type,d_1,d_2,d_3,d_4,d_5,d_6,d_7,d_8,d_9,d_10,d_11,d_12,d_13,d_14,d_15,d_16,d_17,d_18,d_19,d_20,d_21,d_22,d_23,d_24,d_25,d_26,d_27,d_28,d_29,d_30,d_31	)VALUES	('".$data[0]."','".$data[1]."','".$data[2]."','".$data[3]."','".$data[4]."','".$data[5]."','".$data[6]."','".$data[7]."','".$data[8]."','".$data[9]."','".$data[10]."','".$data[11]."','".$data[12]."','".$data[13]."','".$data[14]."','".$data[15]."','".$data[16]."','".$data[17]."','".$data[18]."','".$data[19]."','".$data[20]."','".$data[21]."','".$data[22]."','".$data[23]."','".$data[24]."','".$data[25]."','".$data[26]."','".$data[27]."','".$data[28]."','".$data[29]."','".$data[30]."','".$data[31]."','".$data[32]."','".$data[33]."'	)";
	mysql_query($sql,$link) or exit("Sql Error".mysql_error());
	*/
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
			for($i=0;$i<$data[1];$i++)
			{
				$sql="INSERT ignore INTO $bai_pro.tbl_freez_plan_upload 
(module,shift,value_type,d_1,d_2,d_3,d_4,d_5,d_6,d_7,d_8,d_9,d_10,d_11,d_12,d_13,d_14,d_15,d_16,d_17,d_18,d_19,d_20,d_21,d_22,d_23,d_24,d_25,d_26,d_27,d_28,d_29,d_30,d_31	)VALUES	('".$data[0]."','".$teams[$i]."','".$data[2]."','".$data[3]."','".$data[4]."','".$data[5]."','".$data[6]."','".$data[7]."','".$data[8]."','".$data[9]."','".$data[10]."','".$data[11]."','".$data[12]."','".$data[13]."','".$data[14]."','".$data[15]."','".$data[16]."','".$data[17]."','".$data[18]."','".$data[19]."','".$data[20]."','".$data[21]."','".$data[22]."','".$data[23]."','".$data[24]."','".$data[25]."','".$data[26]."','".$data[27]."','".$data[28]."','".$data[29]."','".$data[30]."','".$data[31]."','".$data[32]."','".$data[33]."'	)";
				mysqli_query($link, $sql) or exit("Sql Error3".mysqli_error($GLOBALS["___mysqli_ston"]));
			}
			break;
		}
		case "SAH_HRS":
		{
			$temp_1=0;	$temp_2=0;	$temp_3=0;	$temp_4=0;	$temp_5=0;	$temp_6=0;	$temp_7=0;	$temp_8=0;	$temp_9=0;	$temp_10=0;	$temp_11=0;	$temp_12=0;	$temp_13=0;	$temp_14=0;	$temp_15=0;	$temp_16=0;	$temp_17=0;	$temp_18=0;	$temp_19=0;	$temp_20=0;	$temp_21=0;	$temp_22=0;	$temp_23=0;	$temp_24=0;	$temp_25=0;	$temp_26=0;	$temp_27=0;	$temp_28=0;	$temp_29=0;	$temp_30=0;	$temp_31=0;
			
			
			$cum_val_1=0;	$cum_val_2=0;	$cum_val_3=0;	$cum_val_4=0;	$cum_val_5=0;	$cum_val_6=0;	$cum_val_7=0;	$cum_val_8=0;	$cum_val_9=0;	$cum_val_10=0;	$cum_val_11=0;	$cum_val_12=0;	$cum_val_13=0;	$cum_val_14=0;	$cum_val_15=0;	$cum_val_16=0;	$cum_val_17=0;	$cum_val_18=0;	$cum_val_19=0;	$cum_val_20=0;	$cum_val_21=0;	$cum_val_22=0;	$cum_val_23=0;	$cum_val_24=0;	$cum_val_25=0;	$cum_val_26=0;	$cum_val_27=0;	$cum_val_28=0;	$cum_val_29=0;	$cum_val_30=0;	$cum_val_31=0;

			
			$val_1=round_or_not($data[3],$data[1],0);	$val_2=round_or_not($data[4],$data[1],0);	$val_3=round_or_not($data[5],$data[1],0);	$val_4=round_or_not($data[6],$data[1],0);	$val_5=round_or_not($data[7],$data[1],0);	$val_6=round_or_not($data[8],$data[1],0);	$val_7=round_or_not($data[9],$data[1],0);	$val_8=round_or_not($data[10],$data[1],0);	$val_9=round_or_not($data[11],$data[1],0);	$val_10=round_or_not($data[12],$data[1],0);	$val_11=round_or_not($data[13],$data[1],0);	$val_12=round_or_not($data[14],$data[1],0);	$val_13=round_or_not($data[15],$data[1],0);	$val_14=round_or_not($data[16],$data[1],0);	$val_15=round_or_not($data[17],$data[1],0);	$val_16=round_or_not($data[18],$data[1],0);	$val_17=round_or_not($data[19],$data[1],0);	$val_18=round_or_not($data[20],$data[1],0);	$val_19=round_or_not($data[21],$data[1],0);	$val_20=round_or_not($data[22],$data[1],0);	$val_21=round_or_not($data[23],$data[1],0);	$val_22=round_or_not($data[24],$data[1],0);	$val_23=round_or_not($data[25],$data[1],0);	$val_24=round_or_not($data[26],$data[1],0);	$val_25=round_or_not($data[27],$data[1],0);	$val_26=round_or_not($data[28],$data[1],0);	$val_27=round_or_not($data[29],$data[1],0);	$val_28=round_or_not($data[30],$data[1],0);	$val_29=round_or_not($data[31],$data[1],0);	$val_30=round_or_not($data[32],$data[1],0);	$val_31=round_or_not($data[33],$data[1],0);
			
			$temp_1=$data[3];	$temp_2=$data[4];	$temp_3=$data[5];	$temp_4=$data[6];	$temp_5=$data[7];	$temp_6=$data[8];	$temp_7=$data[9];	$temp_8=$data[10];	$temp_9=$data[11];	$temp_10=$data[12];	$temp_11=$data[13];	$temp_12=$data[14];	$temp_13=$data[15];	$temp_14=$data[16];	$temp_15=$data[17];	$temp_16=$data[18];	$temp_17=$data[19];	$temp_18=$data[20];	$temp_19=$data[21];	$temp_20=$data[22];	$temp_21=$data[23];	$temp_22=$data[24];	$temp_23=$data[25];	$temp_24=$data[26];	$temp_25=$data[27];	$temp_26=$data[28];	$temp_27=$data[29];	$temp_28=$data[30];	$temp_29=$data[31];	$temp_30=$data[32];	$temp_31=$data[33];


			for($i=0;$i<$data[1];$i++)
			{
				if($i==($data[1]-1))
				{
					$val_1=$temp_1-$cum_val_1;	$val_2=$temp_2-$cum_val_2;	$val_3=$temp_3-$cum_val_3;	$val_4=$temp_4-$cum_val_4;	$val_5=$temp_5-$cum_val_5;	$val_6=$temp_6-$cum_val_6;	$val_7=$temp_7-$cum_val_7;	$val_8=$temp_8-$cum_val_8;	$val_9=$temp_9-$cum_val_9;	$val_10=$temp_10-$cum_val_10;	$val_11=$temp_11-$cum_val_11;	$val_12=$temp_12-$cum_val_12;	$val_13=$temp_13-$cum_val_13;	$val_14=$temp_14-$cum_val_14;	$val_15=$temp_15-$cum_val_15;	$val_16=$temp_16-$cum_val_16;	$val_17=$temp_17-$cum_val_17;	$val_18=$temp_18-$cum_val_18;	$val_19=$temp_19-$cum_val_19;	$val_20=$temp_20-$cum_val_20;	$val_21=$temp_21-$cum_val_21;	$val_22=$temp_22-$cum_val_22;	$val_23=$temp_23-$cum_val_23;	$val_24=$temp_24-$cum_val_24;	$val_25=$temp_25-$cum_val_25;	$val_26=$temp_26-$cum_val_26;	$val_27=$temp_27-$cum_val_27;	$val_28=$temp_28-$cum_val_28;	$val_29=$temp_29-$cum_val_29;	$val_30=$temp_30-$cum_val_30;	$val_31=$temp_31-$cum_val_31;

					$sql="INSERT ignore INTO $bai_pro.tbl_freez_plan_upload 
(module,shift,value_type,d_1,d_2,d_3,d_4,d_5,d_6,d_7,d_8,d_9,d_10,d_11,d_12,d_13,d_14,d_15,d_16,d_17,d_18,d_19,d_20,d_21,d_22,d_23,d_24,d_25,d_26,d_27,d_28,d_29,d_30,d_31	)VALUES	('".$data[0]."','".$teams[$i]."','".$data[2]."','$val_1','$val_2','$val_3','$val_4','$val_5','$val_6','$val_7','$val_8','$val_9','$val_10','$val_11','$val_12','$val_13','$val_14','$val_15','$val_16','$val_17','$val_18','$val_19','$val_20','$val_21','$val_22','$val_23','$val_24','$val_25','$val_26','$val_27','$val_28','$val_29','$val_30','$val_31')";
					mysqli_query($link, $sql) or exit("Sql Error4".mysqli_error($GLOBALS["___mysqli_ston"]));
					
				}
				else
				{
					$sql="INSERT ignore INTO $bai_pro.tbl_freez_plan_upload 
(module,shift,value_type,d_1,d_2,d_3,d_4,d_5,d_6,d_7,d_8,d_9,d_10,d_11,d_12,d_13,d_14,d_15,d_16,d_17,d_18,d_19,d_20,d_21,d_22,d_23,d_24,d_25,d_26,d_27,d_28,d_29,d_30,d_31	)VALUES	('".$data[0]."','".$teams[$i]."','".$data[2]."','$val_1','$val_2','$val_3','$val_4','$val_5','$val_6','$val_7','$val_8','$val_9','$val_10','$val_11','$val_12','$val_13','$val_14','$val_15','$val_16','$val_17','$val_18','$val_19','$val_20','$val_21','$val_22','$val_23','$val_24','$val_25','$val_26','$val_27','$val_28','$val_29','$val_30','$val_31')";
					mysqli_query($link, $sql) or exit("Sql Error5".mysqli_error($GLOBALS["___mysqli_ston"]));
					
					$cum_val_1+=$val_1;	$cum_val_2+=$val_2;	$cum_val_3+=$val_3;	$cum_val_4+=$val_4;	$cum_val_5+=$val_5;	$cum_val_6+=$val_6;	$cum_val_7+=$val_7;	$cum_val_8+=$val_8;	$cum_val_9+=$val_9;	$cum_val_10+=$val_10;	$cum_val_11+=$val_11;	$cum_val_12+=$val_12;	$cum_val_13+=$val_13;	$cum_val_14+=$val_14;	$cum_val_15+=$val_15;	$cum_val_16+=$val_16;	$cum_val_17+=$val_17;	$cum_val_18+=$val_18;	$cum_val_19+=$val_19;	$cum_val_20+=$val_20;	$cum_val_21+=$val_21;	$cum_val_22+=$val_22;	$cum_val_23+=$val_23;	$cum_val_24+=$val_24;	$cum_val_25+=$val_25;	$cum_val_26+=$val_26;	$cum_val_27+=$val_27;	$cum_val_28+=$val_28;	$cum_val_29+=$val_29;	$cum_val_30+=$val_30;	$cum_val_31+=$val_31;

				}
				
			}
			
			break;
		}
		case "PP_PCS":
		{
			$temp_1=0;	$temp_2=0;	$temp_3=0;	$temp_4=0;	$temp_5=0;	$temp_6=0;	$temp_7=0;	$temp_8=0;	$temp_9=0;	$temp_10=0;	$temp_11=0;	$temp_12=0;	$temp_13=0;	$temp_14=0;	$temp_15=0;	$temp_16=0;	$temp_17=0;	$temp_18=0;	$temp_19=0;	$temp_20=0;	$temp_21=0;	$temp_22=0;	$temp_23=0;	$temp_24=0;	$temp_25=0;	$temp_26=0;	$temp_27=0;	$temp_28=0;	$temp_29=0;	$temp_30=0;	$temp_31=0;
			
			
			$cum_val_1=0;	$cum_val_2=0;	$cum_val_3=0;	$cum_val_4=0;	$cum_val_5=0;	$cum_val_6=0;	$cum_val_7=0;	$cum_val_8=0;	$cum_val_9=0;	$cum_val_10=0;	$cum_val_11=0;	$cum_val_12=0;	$cum_val_13=0;	$cum_val_14=0;	$cum_val_15=0;	$cum_val_16=0;	$cum_val_17=0;	$cum_val_18=0;	$cum_val_19=0;	$cum_val_20=0;	$cum_val_21=0;	$cum_val_22=0;	$cum_val_23=0;	$cum_val_24=0;	$cum_val_25=0;	$cum_val_26=0;	$cum_val_27=0;	$cum_val_28=0;	$cum_val_29=0;	$cum_val_30=0;	$cum_val_31=0;

			
			$val_1=round_or_not($data[3],$data[1],1);	$val_2=round_or_not($data[4],$data[1],1);	$val_3=round_or_not($data[5],$data[1],1);	$val_4=round_or_not($data[6],$data[1],1);	$val_5=round_or_not($data[7],$data[1],1);	$val_6=round_or_not($data[8],$data[1],1);	$val_7=round_or_not($data[9],$data[1],1);	$val_8=round_or_not($data[10],$data[1],1);	$val_9=round_or_not($data[11],$data[1],1);	$val_10=round_or_not($data[12],$data[1],1);	$val_11=round_or_not($data[13],$data[1],1);	$val_12=round_or_not($data[14],$data[1],1);	$val_13=round_or_not($data[15],$data[1],1);	$val_14=round_or_not($data[16],$data[1],1);	$val_15=round_or_not($data[17],$data[1],1);	$val_16=round_or_not($data[18],$data[1],1);	$val_17=round_or_not($data[19],$data[1],1);	$val_18=round_or_not($data[20],$data[1],1);	$val_19=round_or_not($data[21],$data[1],1);	$val_20=round_or_not($data[22],$data[1],1);	$val_21=round_or_not($data[23],$data[1],1);	$val_22=round_or_not($data[24],$data[1],1);	$val_23=round_or_not($data[25],$data[1],1);	$val_24=round_or_not($data[26],$data[1],1);	$val_25=round_or_not($data[27],$data[1],1);	$val_26=round_or_not($data[28],$data[1],1);	$val_27=round_or_not($data[29],$data[1],1);	$val_28=round_or_not($data[30],$data[1],1);	$val_29=round_or_not($data[31],$data[1],1);	$val_30=round_or_not($data[32],$data[1],1);	$val_31=round_or_not($data[33],$data[1],1);
			
			$temp_1=$data[3];	$temp_2=$data[4];	$temp_3=$data[5];	$temp_4=$data[6];	$temp_5=$data[7];	$temp_6=$data[8];	$temp_7=$data[9];	$temp_8=$data[10];	$temp_9=$data[11];	$temp_10=$data[12];	$temp_11=$data[13];	$temp_12=$data[14];	$temp_13=$data[15];	$temp_14=$data[16];	$temp_15=$data[17];	$temp_16=$data[18];	$temp_17=$data[19];	$temp_18=$data[20];	$temp_19=$data[21];	$temp_20=$data[22];	$temp_21=$data[23];	$temp_22=$data[24];	$temp_23=$data[25];	$temp_24=$data[26];	$temp_25=$data[27];	$temp_26=$data[28];	$temp_27=$data[29];	$temp_28=$data[30];	$temp_29=$data[31];	$temp_30=$data[32];	$temp_31=$data[33];
			
			for($i=0;$i<$data[1];$i++)
			{
				if($i==($data[1]-1))
				{
					$val_1=$temp_1-$cum_val_1;	$val_2=$temp_2-$cum_val_2;	$val_3=$temp_3-$cum_val_3;	$val_4=$temp_4-$cum_val_4;	$val_5=$temp_5-$cum_val_5;	$val_6=$temp_6-$cum_val_6;	$val_7=$temp_7-$cum_val_7;	$val_8=$temp_8-$cum_val_8;	$val_9=$temp_9-$cum_val_9;	$val_10=$temp_10-$cum_val_10;	$val_11=$temp_11-$cum_val_11;	$val_12=$temp_12-$cum_val_12;	$val_13=$temp_13-$cum_val_13;	$val_14=$temp_14-$cum_val_14;	$val_15=$temp_15-$cum_val_15;	$val_16=$temp_16-$cum_val_16;	$val_17=$temp_17-$cum_val_17;	$val_18=$temp_18-$cum_val_18;	$val_19=$temp_19-$cum_val_19;	$val_20=$temp_20-$cum_val_20;	$val_21=$temp_21-$cum_val_21;	$val_22=$temp_22-$cum_val_22;	$val_23=$temp_23-$cum_val_23;	$val_24=$temp_24-$cum_val_24;	$val_25=$temp_25-$cum_val_25;	$val_26=$temp_26-$cum_val_26;	$val_27=$temp_27-$cum_val_27;	$val_28=$temp_28-$cum_val_28;	$val_29=$temp_29-$cum_val_29;	$val_30=$temp_30-$cum_val_30;	$val_31=$temp_31-$cum_val_31;

					$sql="INSERT ignore INTO $bai_pro.tbl_freez_plan_upload 
(module,shift,value_type,d_1,d_2,d_3,d_4,d_5,d_6,d_7,d_8,d_9,d_10,d_11,d_12,d_13,d_14,d_15,d_16,d_17,d_18,d_19,d_20,d_21,d_22,d_23,d_24,d_25,d_26,d_27,d_28,d_29,d_30,d_31	)VALUES	('".$data[0]."','".$teams[$i]."','".$data[2]."','$val_1','$val_2','$val_3','$val_4','$val_5','$val_6','$val_7','$val_8','$val_9','$val_10','$val_11','$val_12','$val_13','$val_14','$val_15','$val_16','$val_17','$val_18','$val_19','$val_20','$val_21','$val_22','$val_23','$val_24','$val_25','$val_26','$val_27','$val_28','$val_29','$val_30','$val_31')";
					
				mysqli_query($link, $sql) or exit("Sql Error6".mysqli_error($GLOBALS["___mysqli_ston"]));
					
				}
				else
				{
					$sql="INSERT ignore INTO $bai_pro.tbl_freez_plan_upload 
(module,shift,value_type,d_1,d_2,d_3,d_4,d_5,d_6,d_7,d_8,d_9,d_10,d_11,d_12,d_13,d_14,d_15,d_16,d_17,d_18,d_19,d_20,d_21,d_22,d_23,d_24,d_25,d_26,d_27,d_28,d_29,d_30,d_31	)VALUES	('".$data[0]."','".$teams[$i]."','".$data[2]."','$val_1','$val_2','$val_3','$val_4','$val_5','$val_6','$val_7','$val_8','$val_9','$val_10','$val_11','$val_12','$val_13','$val_14','$val_15','$val_16','$val_17','$val_18','$val_19','$val_20','$val_21','$val_22','$val_23','$val_24','$val_25','$val_26','$val_27','$val_28','$val_29','$val_30','$val_31')";
					mysqli_query($link, $sql) or exit("Sql Error7".mysqli_error($GLOBALS["___mysqli_ston"]));
					
					$cum_val_1+=$val_1;	$cum_val_2+=$val_2;	$cum_val_3+=$val_3;	$cum_val_4+=$val_4;	$cum_val_5+=$val_5;	$cum_val_6+=$val_6;	$cum_val_7+=$val_7;	$cum_val_8+=$val_8;	$cum_val_9+=$val_9;	$cum_val_10+=$val_10;	$cum_val_11+=$val_11;	$cum_val_12+=$val_12;	$cum_val_13+=$val_13;	$cum_val_14+=$val_14;	$cum_val_15+=$val_15;	$cum_val_16+=$val_16;	$cum_val_17+=$val_17;	$cum_val_18+=$val_18;	$cum_val_19+=$val_19;	$cum_val_20+=$val_20;	$cum_val_21+=$val_21;	$cum_val_22+=$val_22;	$cum_val_23+=$val_23;	$cum_val_24+=$val_24;	$cum_val_25+=$val_25;	$cum_val_26+=$val_26;	$cum_val_27+=$val_27;	$cum_val_28+=$val_28;	$cum_val_29+=$val_29;	$cum_val_30+=$val_30;	$cum_val_31+=$val_31;

				}
				
			}
			break;
		}
	}
}
for($i=1;$i<=31;$i++)
{
	$sql="select module,shift,sum(if(value_type='PP_PCS',d_$i,0)) as pcs,sum(if(value_type='SAH_HRS',d_$i,0)) as sah,max(if(value_type='PEF_PER',d_$i,0)) as eff,section_id from $bai_pro.tbl_freez_plan_upload left join bai_pro3.plan_modules on module=module_id group by concat(module,shift)";
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


















