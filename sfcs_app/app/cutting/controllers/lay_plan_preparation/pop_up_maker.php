<?php
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config_ajax.php');
$data = $_POST['data'];
$date_maker = json_decode($data, TRUE);
$doc_no = $_POST['doc_no'];
$date=date('Y-m-d');
// var_dump($date_maker)."<br>";
// die();
for($i=0;$i<(sizeof($date_maker)-1);$i++)
{
	if($date_maker[$i][0]=='yes')
	{
		if($date_maker[$i][19]=='0')
		{
			$sql="insert ignore into $bai_pro3.maker_details (parent_id, marker_type, marker_version, shrinkage_group, width, marker_length, marker_name, pattern_name, marker_eff, perimeters, remarks1, remarks2, remarks3, remarks4) values('".$date_maker[$i][3]."','".$date_maker[$i][6]."', '".$date_maker[$i][7]."', '".$date_maker[$i][8]."', '".$date_maker[$i][9]."', '".$date_maker[$i][10]."', '".$date_maker[$i][11]."', '".$date_maker[$i][12]."', '".$date_maker[$i][13]."', '".$date_maker[$i][14]."',  '".$date_maker[$i][15]."',  '".$date_maker[$i][16]."',  '".$date_maker[$i][17]."',  '".$date_maker[$i][18]."')";
			// echo $sql."<br>";
			$sql_marker_result=mysqli_query($link, $sql) or die("Error12 = ".mysqli_error($GLOBALS["___mysqli_ston"]));
			$mk_id=mysqli_insert_id($link);
			
			$sql_marker = "insert ignore into $bai_pro3.maker_stat_log (cat_ref, cuttable_ref, allocate_ref,order_tid, mklength,mkeff, lastup, remarks,mk_ver,remark1,remark2,remark3,remark4) SELECT cat_ref, cuttable_ref, allocate_ref,order_tid, mklength,mkeff, lastup, remarks,mk_ver,remark1,remark2,remark3,remark4 FROM $bai_pro3.maker_stat_log  where allocate_ref=".$date_maker[$i][3]." limit 1";
			// echo $sql_marker."<br>";
			$sql_marker_result=mysqli_query($link, $sql_marker) or die("Error13 = ".mysqli_error($GLOBALS["___mysqli_ston"]));
			$mk_ref_id=mysqli_insert_id($link);
			// echo $mk_ref_id."<br>";
			$sql_update_marker_length_id ="update $bai_pro3.maker_stat_log set date='".$date."',marker_details_id='".$mk_id."', mklength='".$date_maker[$i][10]."',mkeff='".$date_maker[$i][13]."',remark1='".$date_maker[$i][15]."',remark2='".$date_maker[$i][16]."',remark3='".$date_maker[$i][17]."',remark4='".$date_maker[$i][18]."' where tid=$mk_ref_id";			
			mysqli_query($link, $sql_update_marker_length_id) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			// echo $sql_update_marker_length_id."<br>";
			$sql11x132="update $bai_pro3.plandoc_stat_log set mk_ref_id=".$mk_id.",mk_ref=".$mk_ref_id." where doc_no=".$date_maker[$i][2]."";
			// echo $sql11x132."<br>";
			$sql_result11x112=mysqli_query($link, $sql11x132) or die("Error14 = ".mysqli_error($GLOBALS["___mysqli_ston"]));
			$sql_inse="INSERT INTO `bai_pro3`.`marker_changes_log` (`user`, `date_time`, `doc_no`, `alloc_ref`, `mk_ref_id`) 
			VALUES ('".$username."', '".date("Y-m-d H:i:s")."', '".$date_maker[$i][2]."', '".$date_maker[$i][3]."', '".$mk_id."')";
			// echo $sql_inse."<br>";
			mysqli_query($link, $sql_inse) or die("Error19 = ".mysqli_error($GLOBALS["___mysqli_ston"]));
			$result_array['status'] = 'New Group Added & Updated.';
			$result_array['status_no'] = '1';
			echo json_encode($result_array);
		//	die(); 
		
		}
		else
		{
			$sql_query24="select mk_ref_id,mk_ref from $bai_pro3.plandoc_stat_log where doc_no=".$date_maker[$i][2]."";
			// echo $sql_query24."<br>"; 
			$test_query12=mysqli_query($link, $sql_query24) or die("Error15 = ".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($row111x2=mysqli_fetch_array($test_query12)) 
			{
				$mk_ref_id=$row111x2['mk_ref_id'];					
				$sql11x1321="select tid from $bai_pro3.maker_stat_log where marker_details_id=".$date_maker[$i][1]." and allocate_ref=".$date_maker[$i][3]." limit 1";
				// echo $sql11x1321."<br>";
				$sql_result11x1121=mysqli_query($link, $sql11x1321) or die("Error17 = ".mysqli_error($GLOBALS["___mysqli_ston"]));
				if(mysqli_num_rows($sql_result11x1121)>0)
				{
					while($row111x21=mysqli_fetch_array($sql_result11x1121)) 
					{
						$sql11x132="update $bai_pro3.plandoc_stat_log set mk_ref_id=".$date_maker[$i][1].",mk_ref=".$row111x21['tid']." where doc_no=".$date_maker[$i][2]."";
						// echo $sql11x132."<br>";
						$sql_result11x112=mysqli_query($link, $sql11x132) or die("Error19 = ".mysqli_error($GLOBALS["___mysqli_ston"]));
					}
					$sql_inse="INSERT INTO `bai_pro3`.`marker_changes_log` (`user`, `date_time`, `doc_no`, `alloc_ref`, `mk_ref_id`) 
					VALUES ('".$username."', '".date("Y-m-d H:i:s")."', '".$date_maker[$i][2]."', '".$date_maker[0][3]."', '".$date_maker[$i][1]."')";
					mysqli_query($link, $sql_inse) or die("Error19 = ".mysqli_error($GLOBALS["___mysqli_ston"]));
					// echo $sql_inse."<br>";
					$result_array['status_new'] = 'Selected group has been changed.';
					$result_array['status_no'] = '2';
					echo json_encode($result_array);
				//	die(); 			
				}
				else
				{
					$sql="INSERT INTO bai_pro3.maker_stat_log(DATE,cat_ref,cuttable_ref,allocate_ref,order_tid,mklength,mkeff,lastup,remarks,mk_ver,remark1,remark2,remark3,remark4) 
					SELECT DATE,cat_ref,cuttable_ref,allocate_ref,order_tid,mklength,mkeff,lastup,remarks,mk_ver,remark1,remark2,remark3,remark4 FROM bai_pro3.maker_stat_log WHERE tid=".$date_maker[$i][4]."";
					mysqli_query($link, $sql) or exit("Sql Error1x".mysqli_error($GLOBALS["___mysqli_ston"]));
					// echo $sql."<br>";
					$iLastid=mysqli_insert_id($link);
					$sql_update_marker_length_id ="update $bai_pro3.maker_stat_log set marker_details_id='".$date_maker[$i][1]."', mklength='".$date_maker[$i][10]."',mkeff='".$date_maker[$i][14]."',remark1='".$date_maker[$i][15]."',remark2='".$date_maker[$i][16]."',remark3='".$date_maker[$i][17]."',remark4='".$date_maker[$i][18]."' where tid=$iLastid";
					// echo $sql_update_marker_length_id."<br>";
					mysqli_query($link, $sql_update_marker_length_id) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
					$sql11x132="update $bai_pro3.plandoc_stat_log set mk_ref_id=".$date_maker[$i][1].",mk_ref=".$iLastid." where doc_no=".$date_maker[$i][2]."";
					// echo $sql11x132."<br>";
					$sql_result11x112=mysqli_query($link, $sql11x132) or die("Error143 = ".mysqli_error($GLOBALS["___mysqli_ston"]));
					$sql_inse="INSERT INTO `bai_pro3`.`marker_changes_log` (`user`, `date_time`, `doc_no`, `alloc_ref`, `mk_ref_id`) 
					VALUES ('".$username."', '".date("Y-m-d H:i:s")."', '".$date_maker[$i][2]."', '".$date_maker[$i][3]."', '".$date_maker[$i][1]."')";
					mysqli_query($link, $sql_inse) or die("Error19 = ".mysqli_error($GLOBALS["___mysqli_ston"]));		
					// echo $sql_inse."<br>";	
					$result_array['status_new'] = 'Selected group has been changed.';
					$result_array['status_no'] = '2';
					echo json_encode($result_array);
				//	die(); 			
				}				
			}
		}				
	}
	elseif($date_maker[$i][16]=='0' && $date_maker[$i][0]=='no')
	{			
		$sql="insert ignore into $bai_pro3.maker_details (parent_id, marker_type, marker_version, shrinkage_group, width, marker_length, marker_name, pattern_name, marker_eff, perimeters, remarks1, remarks2, remarks3, remarks4) values('".$date_maker[$i][3]."','".$date_maker[$i][6]."', '".$date_maker[$i][7]."', '".$date_maker[$i][8]."', '".$date_maker[$i][9]."', '".$date_maker[$i][10]."', '".$date_maker[$i][11]."', '".$date_maker[$i][12]."', '".$date_maker[$i][13]."', '".$date_maker[$i][14]."',  '".$date_maker[$i][15]."',  '".$date_maker[$i][16]."',  '".$date_maker[$i][17]."',  '".$date_maker[$i][18]."')";
		mysqli_query($link, $sql) or die("Error19 = ".mysqli_error($GLOBALS["___mysqli_ston"]));
	}		
}
die();
?>