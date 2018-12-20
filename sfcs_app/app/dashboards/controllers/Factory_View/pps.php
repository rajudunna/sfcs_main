<?php
include ("../../../../common/config/config.php");

if(isset($_GET['sec_x']))
{
	$sections_db=array($_GET['sec_x']);
}

for($i=0;$i<sizeof($sections_db);$i++)
{
	$section_id=$sections_db[$i];
	
	$id_new="green";
	$test="";
	$sqlx="SELECT GROUP_CONCAT(`module_name` ORDER BY module_name+0 ASC) AS sec_mods,section AS sec_id FROM $bai_pro3.`module_master` where section = $section_id GROUP BY section ORDER BY section + 0";
	mysqli_query($link, $sqlx) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_resultx=mysqli_query($link, $sqlx) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_rowx=mysqli_fetch_array($sql_resultx))
	{
		$section=$sql_rowx['sec_id'];
		// $section_head=$sql_rowx['sec_head'];
		$section_mods=$sql_rowx['sec_mods'];
	
		$mods=array();
		$mods=explode(",",$section_mods);
	
		for($x=0;$x<sizeof($mods);$x++)
		{
			$module=$mods[$x];
			
			
			$sql1="SELECT * from $bai_pro3.plan_dash_doc_summ where module=$module and act_cut_issue_status<>\"DONE\" order by priority limit 1";
			//echo $sql1;
			mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			$sql_num_check=mysqli_num_rows($sql_result1);
			$cycle=0;
			while($sql_row1=mysqli_fetch_array($sql_result1))
			{
				$cut_new=$sql_row1['act_cut_status'];
				$cut_input_new=$sql_row1['act_cut_issue_status'];
				$rm_new=strtolower(chop($sql_row1['rm_date']));
				$rm_update_new=strtolower(chop($sql_row1['rm_date']));
				$input_temp=strtolower(chop($sql_row1['cut_inp_temp']));
				$doc_no=$sql_row1['doc_no'];
				$order_tid=$sql_row1['order_tid'];
				
				$style=$sql_row1['order_style_no'];
				$schedule=$sql_row1['order_del_no'];
				$color=$sql_row1['order_col_des'];
				$total_qty=$sql_row1['total'];
				
				$cut_no=$sql_row1['acutno'];
				$color_code=$sql_row1['color_code'];

				$trims_input=0;
				$sql1x="SELECT COALESCE(trims_status,0) as trims_status FROM $bai_pro3.trims_dashboard WHERE doc_ref=$doc_no";
				//echo $sql1x."<br/>";
				$sql_result1x=mysqli_query($link, $sql1x) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));

				while($row=mysqli_fetch_array($sql_result1x))
				{
					$trims_input=$row['trims_status'];
				}
				
			
				$ft_status=$sql_row1['ft_status'];
				$fabric_status=$sql_row1['fabric_status'];

				
				if($cut_new=="DONE"){ $cut_new="T";	} else { $cut_new="F"; }
				if($rm_update_new==""){ $rm_update_new="F"; } else { $rm_update_new="T"; }
				if($rm_new=="0000-00-00 00:00:00" or $rm_new=="") { $rm_new="F"; } else { $rm_new="T";	}
				if($input_temp==1) { $input_temp="T";	} else { $input_temp="F"; }
				if($cut_input_new=="DONE") { $cut_input_new="T";	} else { $cut_input_new="F"; }
				
				//New RM Status from FSP
				$st_status=$sql_row1['st_status'];
				if($st_status==""){ $rm_update_new="F"; } else { $rm_update_new="T"; }
				if($st_status>1 or $st_status=="") { $rm_new="F"; } else { $rm_new="T";	}
				
				switch($st_status)
				{
					case 1:
					{
						$remarks="Available";
						break;
					}
					case 2:
					{
						$remarks="In House Issue";
						break;
					}
					case 3:
					{
						$remarks="GRN Issue";
						break;
					}
					case 4:
					{
						$remarks="Inspection Issue";
						break;
					}
					default:
					{
						$remarks="Not Updated";
					}
				}

			//New to check status code

			if($cut_new=="F")
			{
				if($fabric_status==5)
				{
					$cut_new="T";
				}
				else
				{
					if($ft_status==1)
					{
						$cut_new="T";
					}
				}
			}

			if($cut_new=="T")
			{
				if($trims_input==0)
				{
					$cut_new="F";
				}
				else
				{
					if($trims_input==0 and $st_status>1) { $cut_new="F"; }
				}
			}			

			//New RM Status from FSP
				
				$check_string=$cut_new.$rm_update_new.$rm_new.$input_temp.$cut_input_new;
				
				switch ($check_string)
				{
					case "TTTTF":
					{
						$id="yellow";
						break;
					}
					case "TTTFF":
					{
						$id="green";
						break;
					}
					case "TTFFF":
					{
						//$id="orange";
						//$id="red";
						if($trims_input==0)
						{
							if($st_status>1) { $id="x"; }
						}
						break;
					}
					case "TTFTF":
					{
						//$id="orange";
						//$id="red";
						if($trims_input==0)
						{
							if($st_status>1) { $id="x"; }
						}
						break;
					}
					case "TFFTF":
					{
						//$id="orange";
						//$id="red";
						if($trims_input==0)
						{
							if($st_status>1) { $id="x"; }
						}
						break;
					}


					case "TFFFF":
					{
						//$id="blue";
						if($trims_input==0)
						{
							if($st_status>1) { $id="x"; }

						}
						break;
					}
					case "FTTFF":
					{
						//$id="pink";
						if($trims_input==0)
						{
							if($st_status>1) { $id="x"; }

						}
						break;
					}
					case "FTFFF":
					{
						//$id="red";
						//$id="orange";
						$id="x";
						break;
					}
					case "FFFFF":
					{
						//$id="yash";
						$id="x";
						break;
					}
					
					default:
					{
						//$id="black";
						$id="x";
						break;
					}
				}
				
				$test.=$id;
				//echo $id."-".$module."-".$test."<br>";
			}
			
			
		}
		
	}
	if($username=="kirang")
	{
		//echo $test."<br/>";
	}

	if(substr_count($test,"x")==0)
	{
		$id_new="green";
	}
	else
	{
		if(substr_count($test,"x")<=3)
		{
			$id_new="yellow";
		}
		else
		{
			$id_new="red";
		}
	}
	 echo "<td><div id=\"$id_new\"><a href=\"http://".$_SERVER['HTTP_HOST']."/sfcs_app/app/dashboards/controllers/Factory_View/fab_pps_dashboard_v2_live.php?sec_x=$section_id&rand=".rand()."\" target='_blank'></a></div></td>";
	// echo "<td><div id=\"$id_new\" onclick='popup(".getFullURLLevel($_GET['r'],'beta/production_planning/fab_pps_dashboard_v2_live.php',2,'R').");'></div></td>";
	
	// $url_pps=getFullURLLevel($_GET['r'],'Beta/production_planning/tms_dashboard_input_v22.php',2,'N');
	// echo "<td><div id=\"$id_new\"><a href='$url_pps'&sec_x=$section_id&rand=".rand()."\"></a></div></td>";
}

?>

