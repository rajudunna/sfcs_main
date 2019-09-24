<?php
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/confi_ajax.php',4,'R'));

$date_maker = $_REQUEST['data'];
die();
//var_dump($date_maker);
for($i=0;$i<sizeof($date_maker);$i++)
{
	
	if($date_maker[$i][0]=='yes')
	{
		if($date_maker[$i][1]=='')
		{
			$sql="insert ignore into $bai_pro3.maker_details (parent_id, marker_type, marker_version, shrinkage_group, width, marker_length, marker_name, pattern_name, marker_eff, perimeters, remarks) values('".$date_maker[0][3]."','".$date_maker[$i][1]."', '".$date_maker[$i][2]."', '".$date_maker[$i][3]."', '".$date_maker[$i][4]."', '".$date_maker[$i][5]."', '".$date_maker[$i][6]."', '".$date_maker[$i][7]."', '".$date_maker[$i][9]."', '".$date_maker[$i][8]."',  '".$date_maker[$i][10]."')";
			$sql_marker_result=mysqli_query($link, $sql) or die("Error1 = ".mysqli_error($GLOBALS["___mysqli_ston"]));
			$mk_id=mysqli_insert_id($link);
			
			$sql_marker = "insert ignore into $bai_pro3.maker_stat_log select * from $bai_pro3.maker_stat_log where allocate_ref=".$date_maker[0][3]." limit 1";
			$sql_marker_result=mysqli_query($link, $sql_marker_details) or die("Error1 = ".mysqli_error($GLOBALS["___mysqli_ston"]));
			$mk_ref_id=mysqli_insert_id($link);
			
			$sql_update_marker_length_id ="update $bai_pro3.maker_stat_log set marker_details_id='".$mk_id."', mklength='".$date_maker[$i][5]."',mkeff='".$date_maker[$i][9]."' where tid=$mk_ref_id";			
			mysqli_query($link, $sql_update_marker_length_id) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			
			$sql11x132="update $bai_pro3.plandoc_stat_log set mk_ref_id=".$mk_id.",mk_ref=".$mk_ref_id." where doc_no=".$date_maker[0][2]."";
			$sql_result11x112=mysqli_query($link, $sql11x132) or die("Error1 = ".mysqli_error($GLOBALS["___mysqli_ston"]));
				
		}
		else
		{
			$sql11x132="select mk_ref_id,mk_ref from $bai_pro3.plandoc_stat_log where doc_no=".$date_maker[$i][2]."";
			//echo $sql11x132."<bR>";
			$sql_result11x112=mysqli_query($link, $sql11x132) or die("Error1 = ".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($row111x2=mysqli_fetch_array($sql_result11x112)) 
			{
				$mk_ref_id=$row111x2['mk_ref_id'];
				
				$sql11x1321="select * from $bai_pro3.maker_stat_log where marker_details_id=".$date_maker[$i][1]." and allocate_ref=".$date_maker[$i][3]." limit 1";
				//echo $sql11x1321."<br>";
				$sql_result11x1121=mysqli_query($link, $sql11x1321) or die("Error1 = ".mysqli_error($GLOBALS["___mysqli_ston"]));
				if(mysqli_num_rows($sql_result11x1121)>0)
				{
					while($row111x21=mysqli_fetch_array($sql_result11x1121)) 
					{
						$sql11x132="update $bai_pro3.plandoc_stat_log set mk_ref_id=".$date_maker[$i][1].",mk_ref=".$row111x21['tid']." where doc_no=".$date_maker[$i][2]."";
						//echo $sql11x132."<br>";
						$sql_result11x112=mysqli_query($link, $sql11x132) or die("Error1 = ".mysqli_error($GLOBALS["___mysqli_ston"]));
					}	
				}
				else
				{
					$sql_marker = "insert ignore into $bai_pro3.maker_stat_log select * from $bai_pro3.maker_stat_log where tid=".$date_maker[$i][4]." limit 1";
					//echo $sql_marker."<br>";
					$sql_marker_result=mysqli_query($link, $sql_marker_details) or die("Error1 = ".mysqli_error($GLOBALS["___mysqli_ston"]));
					$iLastid=mysqli_insert_id($link);
					$iLastid=1;
					$sql_update_marker_length_id ="update $bai_pro3.maker_stat_log set marker_details_id='".$date_maker[$i][1]."', mklength='".$date_maker[$i][10]."',mkeff='".$date_maker[$i][14]."' where tid=$iLastid";
					//echo $sql_update_marker_length_id."<br>";
					mysqli_query($link, $sql_update_marker_length_id) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
					$sql11x132="update $bai_pro3.plandoc_stat_log set mk_ref_id=".$date_maker[$i][1].",mk_ref=".$iLastid." where doc_no=".$date_maker[$i][2]."";
					//echo $sql11x132."<br>";
					$sql_result11x112=mysqli_query($link, $sql11x132) or die("Error1 = ".mysqli_error($GLOBALS["___mysqli_ston"]));
				
				}				
			}
		}				
	}
	
	//echo implode(",",$myArray[$i][0])."<br>";
}
die();	

?>