<?php
error_reporting(0);
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config_ajax.php');
// include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/functions.php');
function leading_zeros($value, $places)
{
	$leading='';
	
	if(is_numeric($value))
	{
	    for($x = 1; $x <= $places; $x++)
	    {
	        $ceiling = pow(10, $x);
	        if($value < $ceiling)
	        {
	            $zeros = $places - $x;
	            for($y = 1; $y <= $zeros; $y++)
	            {
	                $leading .= "0";
	            }
	        $x = $places + 1;
	        }
	    }
	    $output = $leading . $value;
	}
	else{
	    $output = $value;
	}
	
	return $output;
}
$newtempname="$bai_pro3.plan_dashboard_input";

$bindex=0;
$blink_docs=array();
$table_name="$bai_pro3.plan_dashboard_input";

// Remove Docs
$remove_docs=array();
$sqlx="select distinct input_job_no_random_ref as doc_no from $bai_pro3.plan_dash_doc_summ_input where $bai_pro3.input_job_input_status(input_job_no_random_ref)=\"DONE\"";
$sql_resultx=mysqli_query($link, $sqlx) or exit("Sql Error11".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_rowx=mysqli_fetch_array($sql_resultx))
{
	$remove_docs[]="'".$sql_rowx['doc_no']."'";
}
if(sizeof($remove_docs)>0)
{
	$backup_query="INSERT IGNORE INTO $bai_pro3.plan_dashboard_input_backup SELECT * FROM $bai_pro3.`plan_dashboard_input` WHERE input_job_no_random_ref in (".implode(",",$remove_docs).")";
	mysqli_query($link, $backup_query) or exit("Error while saving backup plan_dashboard_input_backup");

	$sqlx="delete from $bai_pro3.plan_dashboard_input where input_job_no_random_ref in (".implode(",",$remove_docs).")";
	mysqli_query($link, $sqlx) or exit("Sql Error11".mysqli_error($GLOBALS["___mysqli_ston"]));	
}

$sec_id=$_GET["sec"];

$sqlx="SELECT section_display_name,section_head AS sec_head,ims_priority_boxs,GROUP_CONCAT(`module_name` ORDER BY module_name+0 ASC) AS sec_mods,section AS sec_id FROM $bai_pro3.`module_master` LEFT JOIN $bai_pro3.sections_master ON module_master.section=sections_master.sec_name WHERE section=$sec_id GROUP BY section ORDER BY section + 0";
$sql_resultx=mysqli_query($link, $sqlx) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_rowx=mysqli_fetch_array($sql_resultx))
{
	$section=$sql_rowx['sec_id'];
	$section_head=$sql_rowx['sec_head'];
	$section_mods=$sql_rowx['sec_mods'];
	$section_display_name=$sql_rowx['section_display_name'];
	// Ticket #424781 change the buyer division display based on the pink,logo,IU as per plan_modules
	$sql1d="SELECT module_id as modx from $bai_pro3.plan_modules where module_id in (".$section_mods.") order by module_id*1";
	$sql_num_checkd=0;
	$sql_result1d=mysqli_query($link, $sql1d) or exit("Sql Errordd".mysqli_error($GLOBALS["___mysqli_ston"]));
	$sql_num_checkd=mysqli_num_rows($sql_result1d);
	if($sql_num_checkd > 0)
	{		
		$mods=array();
		while($sql_row1d=mysqli_fetch_array($sql_result1d))
		{
			$mods[]=$sql_row1d["modx"];
		}
		$v_r = explode('/',$_SERVER['REQUEST_URI']);
		array_pop($v_r);
		$popup_url = "http://".$_SERVER['HTTP_HOST'].implode('/',$v_r)."/board_update_V2_input.php";
		//$popup_url ='board_update_V2_input.php';
		$ips_data='<div style="margin-left:15%">';
		$ips_data.="<p>";
		$ips_data.="<table>";
		$ips_data.="<tr><th colspan=2><h2><a href=\"javascript:void(0)\" onclick=\"Popup=window.open('$popup_url?section_no=$section"."','Popup','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes, width=880,height=400, top=23'); if (window.focus) {Popup.focus()} return false;\">$section_display_name</a></h2></th></th></tr>";
		//For Section level blinking
		$blink_minimum=0;		
		for($x=0;$x<sizeof($mods);$x++)
		{
			$module=$mods[$x];
			$blink_check=0;
			
			$sql11="select sum(ims_qty-ims_pro_qty) as \"wip\" from $bai_pro3.ims_log where ims_mod_no=$module";
			 
			//$ips_data.="query=".$sql11;
			// mysqli_query($link, $sql11) or exit("Sql Error4".mysqli_error($GLOBALS["___mysqli_ston"]));
			$sql_result11=mysqli_query($link, $sql11) or exit("Sql Error4".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row11=mysqli_fetch_array($sql_result11))
			{
				$wip=$sql_row11['wip'];
			} 
			
			$ips_data.="<tr class=\"bottom\">";
			$ips_data.="<td class=\"bottom\"><strong><a href=\"javascript:void(0)\" title=\"WIP : $wip\"><font class=\"fontnn\" color=black >$module</font></a></strong></td><td>";
			$id="yash";
			$y=0;
		
			$sql="SELECT input_job_no_random_ref,input_trims_status FROM $table_name WHERE input_module=$module and (input_trims_status!=4 or input_trims_status IS NULL or input_panel_status!=2 or input_panel_status IS NULL) and date(log_time) >=\"2013-01-09\" GROUP BY input_job_no_random_ref order by input_priority asc limit ".$_GET['priority_limit'];	
			// echo $sql."<br>";
			$result=mysqli_query($link, $sql) or exit("Sql Error5".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($row=mysqli_fetch_array($result))
			{							
				$input_job_no_random_ref=$row["input_job_no_random_ref"];
				$input_trims_status=$row["input_trims_status"];
				$add_css="behavior: url(border-radius-ie8.htc);  border-radius: 10px;";
				
				
				// echo $id;
				$sqly="SELECT type_of_sewing,order_style_no,order_del_no,GROUP_CONCAT(DISTINCT order_col_des) AS order_col_des,GROUP_CONCAT(DISTINCT input_job_no) AS input_job_no,GROUP_CONCAT(DISTINCT doc_no) AS doc_no,sum(carton_act_qty) as carton_qty FROM $bai_pro3.packing_summary_input WHERE input_job_no_random='".$input_job_no_random_ref."' ORDER BY acutno";
				//echo $sqly."<br>";
				$resulty=mysqli_query($link, $sqly) or die("Error=$sqly".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($sql_rowy=mysqli_fetch_array($resulty))
				{
					$doc_no_ref = $sql_rowy["doc_no"];
					$doc_no_ref1 = $sql_rowy["doc_no"];
					$doc_no_ref_input=$sql_rowy["doc_no"];
					$carton_qty=$sql_rowy["carton_qty"];
					$style=$sql_rowy['order_style_no'];
					$schedule=$sql_rowy['order_del_no'];
					$order_col=$sql_rowy['order_col_des'];
					$input_job_no=$sql_rowy['input_job_no'];
					$schedule_no=$sql_rowy['order_del_no'];
					$type_of_sewing=$sql_rowy['type_of_sewing'];
				}			
				//FOR SCHEDULE CLUBBING ensuring for parent docket
				if($doc_no_ref != ''){
					$parent_doc_query = "SELECT GROUP_CONCAT(org_doc_no) as docs from $bai_pro3.plandoc_stat_log  
										where doc_no IN ($doc_no_ref) and org_doc_no > 0";
					$parent_doc_result = mysqli_query($link,$parent_doc_query);
					if($org_row = mysqli_fetch_array($parent_doc_result))
						$doc_no_ref = $org_row['docs'];
				}
				if($doc_no_ref == '')
					$doc_no_ref = $doc_no_ref1;

				$sql33x112="SELECT MIN(st_status) AS st_status,MIN(ft_status) AS ft_status FROM $bai_pro3.bai_orders_db_confirm where order_del_no='$schedule' and order_col_des in ('".implode("','",explode(",",$order_col))."')";
				$sql_result33x112=mysqli_query($link, $sql33x112) or exit("Sql Error10".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($sql_row33x112=mysqli_fetch_array($sql_result33x112))
				{
					$ft_status=$sql_row33x112['ft_status'];
					$trims_status=$sql_row33x112['st_status'];
				}
				
				if($input_trims_status>1)
				{
					$add_css="";
				}
				if($input_trims_status==1)
				{
					$tstatus='Preparing Material';
				}
				elseif($input_trims_status==2)
				{
					$tstatus='Material Ready for Production(in Pool)';
				}
				elseif($input_trims_status==3)
				{
					$tstatus='Partial Issued';
				}
				elseif($input_trims_status==4)
				{
					$tstatus='Issued to Module';
				}
				else
				{
					$tstatus='Status Not update';
				}			
				$get_color = $order_col;
				// $display_prefix1 = get_sewing_job_prefix_inp("prefix","$brandix_bts.tbl_sewing_job_prefix",$input_job_no,$input_job_no_random_ref,$link);
				// $display_prefix1='J';
				$prefix="";
				$sql="SELECT prefix as result FROM $brandix_bts.tbl_sewing_job_prefix WHERE type_of_sewing='$type_of_sewing'";
				// echo $sql."<br>";
				$sql_result=mysqli_query($link, $sql) or exit($sql."Sql Error-echo_1<br>".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($sql_row=mysqli_fetch_array($sql_result))
				{
					$prefix = $sql_row['result'];
				}
				$display_prefix1=$prefix.leading_zeros($input_job_no,3);

				$ft_status_min="";
				if($schedule!="")
				{
					$doc_no_ref_explode=explode(",",$doc_no_ref);
					$num_docs=sizeof($doc_no_ref_explode);
					$sql1x1="select * from $bai_pro3.plandoc_stat_log where act_cut_status<>'DONE' and doc_no in ($doc_no_ref)";
					//echo $sql1x1."<bR>";
					$sql_result1x1=mysqli_query($link, $sql1x1) or exit("Sql Error8".mysqli_error($GLOBALS["___mysqli_ston"]));
					if(mysqli_num_rows($sql_result1x1)>0)
					{
						$cut_status="0";
					}
					else
					{
						$cut_status="5";
					}
					
					$fabric_status="";
					$sql1x11="select * from $bai_pro3.plandoc_stat_log where fabric_status<>'5' and doc_no in ($doc_no_ref)";
					//echo $sql1x11."<br>";
					$sql_result1x11=mysqli_query($link, $sql1x11) or exit("Sql Error8".mysqli_error($GLOBALS["___mysqli_ston"]));
					
					if(mysqli_num_rows($sql_result1x11)>0)
					{
						$fabric_status="0";
					}
					else
					{
						$fabric_status="5";
					}
					
					$sql1x12="select * from $bai_pro3.plan_dashboard where fabric_status='1' and doc_no in ($doc_no_ref)";
					//echo $sql1x12."<br>";
					
					$sql_result1x12=mysqli_query($link, $sql1x12) or exit("Sql Error9".mysqli_error($GLOBALS["___mysqli_ston"]));
					// echo mysqli_num_rows($sql_result1x12);
					if(mysqli_num_rows($sql_result1x12)>0)
					{
						$fabric_status="1";
					}								
					$sql1x115="select * from $bai_pro3.fabric_priorities where doc_ref in ($doc_no_ref)";
					$sql_result1x115=mysqli_query($link, $sql1x115) or exit("Sql Error8".mysqli_error($GLOBALS["___mysqli_ston"]));
					if(mysqli_num_rows($sql_result1x115)>0)
					{
						if(sizeof($doc_no_ref_explode)<>mysqli_num_rows($sql_result1x115))
						{
							$fabric_req="0";
						}
						else
						{
							$fabric_req="5";
						}	
					}
					else
					{
						$fabric_req="0";
					}
					if($cut_status=="5")
					{
						$id="blue";					
						$rem="Cut Completed";
					}
					elseif($fabric_status=='5')
					{
						$id="yellow";					
						$rem="Fabric Issued";	
					}
					elseif($fabric_status=='1')
					{
						$id="pink";					
						$rem="Ready To Issue";	
					}
					elseif($fabric_req=="5")
					{
						$id="green";					
						$rem="Fabric Requested";
					}
					elseif($fabric_status<"5")
					{
						switch ($ft_status)
						{
							case "1":
							{
								$id="lgreen";					
								$rem="Available";
								break;
							}
							case "0":
							{
								$id="red";
								$rem="Not Available";
								break;
							}
							case "2":
							{
								$id="red";
								$rem="In House Issue";
								break;
							}
							case "3":
							{
								$id="red";
								$rem="GRN issue";
								break;
							}
							case "4":
							{
								$id="red";
								$rem="Put Away Issue";
								break;
							}									
							default:
							{
								$id="yash";
								$rem="Not Update";
								break;
							}
						}
					}
					else
					{
						$id="yash";
						$rem="Not Update";
					}							
					
					$club_c_code=array();
					$sql33x1="SELECT * FROM $bai_pro3.plan_dash_doc_summ where doc_no in (".$doc_no_ref.") order by doc_no*1";
					$sql_result33x1=mysqli_query($link, $sql33x1) or exit("Sql Error10".mysqli_error($GLOBALS["___mysqli_ston"]));
					while($sql_row33x1=mysqli_fetch_array($sql_result33x1))
					{
						$club_c_code[]=chr($sql_row33x1['color_code']).leading_zeros($sql_row33x1['acutno'],3);
					}			
					$club_c_code=array_unique($club_c_code);
				
					$title=str_pad("Style:".$style,50)."\n".str_pad("Schedule:".$schedule,50)."\n".str_pad("Sewing Job No:".$display_prefix1,50)."\n".str_pad("Total_Qty:".$carton_qty,50)."\n".str_pad("Cut Job No:".implode(", ",$club_c_code),50)."\n".str_pad("Remarks :".$rem,50)."\n".str_pad("Trim Status :".$tstatus,50);
					//$ui_url='input_status_update_input.php';	
					$ui_url = "http://".$_SERVER['HTTP_HOST'].implode('/',$v_r)."/input_status_update_input.php";
					$ui_url1 ='?r='.base64_encode('/sfcs_app/app/production/controllers/sewing_job/sewing_job_scaning/scan_input_jobs.php');
					$application='IPS';
					
					$sidemenu=true;
					$scanning_query=" select * from $brandix_bts.tbl_ims_ops where appilication='$application'";
					// echo $scanning_query;
					$scanning_result=mysqli_query($link, $scanning_query)or exit("scanning_error".mysqli_error($GLOBALS["___mysqli_ston"]));
					while($sql_row=mysqli_fetch_array($scanning_result))
					{
						$operation_name=$sql_row['operation_name'];
						$operation_code=$sql_row['operation_code'];
					}
					
					if($id=="blue" || $id=="yellow")
					{
					
						$cut_input_report_query="select sum(original_qty) as cut_qty,sum(recevied_qty+rejected_qty) as report_qty from brandix_bts.bundle_creation_data where input_job_no_random_ref='$input_job_no_random_ref' and operation_id='".$operation_code."'";
						$cut_input_report_result=mysqli_query($link, $cut_input_report_query)or exit("scanning_error".mysqli_error($GLOBALS["___mysqli_ston"]));

						while($sql_row=mysqli_fetch_array($cut_input_report_result))
						{
							$cut_origional_qty=$sql_row['cut_qty'];
							$report_origional_qty=$sql_row['report_qty'];								
						}
						
						if($cut_origional_qty > $report_origional_qty){
							$id='orange';
						}
						
						if($id=="yellow")
						{									
							if($add_css == ""){				
								$ips_data.="<div id=\"S$schedule\" style=\"float:left;\">
									<div id=\"SJ$input_job_no\" style=\"float:left;\">
										<div id=\"$input_job_no_random_ref\" class=\"$id\" style=\"font-size:12px; text-align:center; color:$id;$add_css\" title=\"$title\" ><a href=\"javascript:void(0);\" onclick=\"viewPopupCenter('$style','$schedule','$module','$input_job_no_random_ref','$operation_code','$sidemenu');\"><font style=\"color:black;\"></font></a>
										</div>
									</div>
								</div>";
							}
							else
							{
								$ips_data.="<div id=\"S$schedule\" style=\"float:left;\">
									<div id=\"SJ$input_job_no\" style=\"float:left;\">
										<div id=\"$input_job_no_random_ref\" class=\"$id\" style=\"font-size:12px; text-align:center; color:$id;$add_css\" title=\"$title\" ><a href=\"$ui_url?jobno=$input_job_no&style=$style&schedule=$schedule&module=$module&section=$section&doc_no=$input_job_no_random_ref&job_status=$id\" onclick=\"Popup=window.open('$ui_url?jobno=$input_job_no&style=$style&schedule=$schedule&module=$module&section=$section&doc_no=$input_job_no_random_ref&job_status=$id','Popup','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes, width=920,height=auto, top=23'); if (window.focus) {Popup.focus()} return false;\"><font style=\"color:black;\"></font></a>
										</div>
									</div>
								</div>";
							}
						}
						else
						{
							if($add_css == "")
							{									
								$ips_data.="<div id=\"S$schedule\" style=\"float:left;\">
									<div id=\"SJ$input_job_no\" style=\"float:left;\">
										<div id=\"$input_job_no_random_ref\" class=\"$id\" style=\"font-size:12px; text-align:center; color:$id;$add_css\" title=\"$title\" ><a href=\"javascript:void(0);\" onclick=\"viewPopupCenter('$style','$schedule','$module','$input_job_no_random_ref','$operation_code','$sidemenu');\"><font style=\"color:black;\"></font></a>
										</div>
									</div>
								</div>";
							}
							else
							{
								$ips_data.="<div id=\"S$schedule\" style=\"float:left;\">
									<div id=\"SJ$input_job_no\" style=\"float:left;\">
										<div id=\"$input_job_no_random_ref\" class=\"$id\" style=\"font-size:12px; text-align:center; color:$id;$add_css\" title=\"$title\" ><a href=\"$ui_url?jobno=$input_job_no&style=$style&schedule=$schedule&module=$module&section=$section&doc_no=$input_job_no_random_ref&job_status=$id\" onclick=\"Popup=window.open('$ui_url?jobno=$input_job_no&style=$style&schedule=$schedule&module=$module&section=$section&doc_no=$input_job_no_random_ref&job_status=$id','Popup','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes, width=920,height=auto, top=23'); if (window.focus) {Popup.focus()} return false;\"><font style=\"color:black;\"></font></a>
										</div>
									</div>
								</div>";
							}
						}
					}
					else
					{
						
						$ips_data.="<div id=\"S$schedule\" style=\"float:left;\"><div id=\"SJ$input_job_no\" style=\"float:left;\"><div id=\"$input_job_no_random_ref\" class=\"$id\" style=\"font-size:12px; text-align:center; color:$id;$add_css\" title=\"$title\" ><a href=\"$ui_url?jobno=$input_job_no&style=$style&schedule=$schedule&module=$module&section=$section&doc_no=$input_job_no_random_ref&job_status=$id\" onclick=\"Popup=window.open('$ui_url?jobno=$input_job_no&style=$style&schedule=$schedule&module=$module&section=$section&doc_no=$input_job_no_random_ref&job_status=$id','Popup','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes, width=920,height=400, top=23'); if (window.focus) {Popup.focus()} return false;\"><font style=\"color:black;\"></font></a></div></div></div>";
					}
					$y++;	
				}
				
			}
			for($j=$y+1;$j<=$_GET['priority_limit'];$j++)
			{	
				$ips_data.="<div id=\"\" style=\"float:left;\">
							<div id=\"$input_job_no_random_ref\" style=\"float:left;\">
								<div id=\"$input_job_no_random_ref\" class=\"white\" style=\"font-size:12px; text-align:center; color:white\">
								</div>
							</div>
						</div>";
			}
			$sqly="select buyer_div from $bai_pro3.plan_modules where module_id=$module";
			$sql_resulty=mysqli_query($link, $sqly) or exit("Sql Error11".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_rowy=mysqli_fetch_array($sql_resulty))
			{
				$buyer_div=$sql_rowy['buyer_div'];
				$cut_wip_control=7000;
			}
			//echo substr($buyer_div,0,1);
			$ips_data.="</td>";
			$ips_data.="</tr>";
		}
		
		$bindex++;

		$ips_data.="</table>";
		$ips_data.="</p>";
		$ips_data.="</div>";
	}
	// echo $ips_data;
}
// echo $ips_data;
$data=array();
$data['data']=$ips_data;
$data['sec']=$_GET["sec"];
echo json_encode($data);
?>