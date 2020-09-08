<?php
// error_reporting(0);
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/config_ajax.php');
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/functions_dashboard.php');
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/functions_v2.php');
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/enums.php');

$data=array();

$sectionId=$_GET["sec_id"];
$sectionName=$_GET["sec_name"];
$plantCode=$_GET["plant_code"];
$priorityLimit=$_GET["priority_limit"];
$getModuleDetails = getWorkstationsForSectionId($plantCode,$sectionId);
$v_r = explode('/',$_SERVER['REQUEST_URI']);
array_pop($v_r);
$popup_url = "http://".$_SERVER['HTTP_HOST'].implode('/',$v_r)."/board_update_V2_input.php";

	$ips_data='<div style="margin-left:15%">';
	$ips_data.="<p>";
	$ips_data.="<table>";
	$ips_data.="<tr><th colspan=2><h2><a href=\"javascript:void(0)\" onclick=\"Popup=window.open('$popup_url?section_no=$sectionId"."','Popup','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes, width=880,height=400, top=23'); if (window.focus) {Popup.focus()} return false;\">$sectionName</a></h2></th></th></tr>";
foreach($getModuleDetails as $moduleKey =>$moduleRecord)
{
	$workstationID =$moduleRecord['workstationId'];
	$workstationCode =$moduleRecord['workstationCode'];
	
	//hardcode 
	$wip = 0;
	$ips_data.="<tr class=\"bottom\">";
	$ips_data.="<td class=\"bottom\"><strong><a href=\"javascript:void(0)\" title=\"WIP : $wip\"><font class=\"fontnn\" color=black >$workstationCode</font></a></strong></td><td>";

	$getJobDetails = getJobsForWorkstationIdTypeSewing($plantCode,$workstationID);
	
	// foreach($getJobDetails as $jobKey =>$jobRecord)
	{
		// $taskJobId = $jobRecord['taskJobId'];
		$taskJobId = 'b7dd3eed-70ad-44c3-86c4-af8b9a464fb0';
		
		$id="yash";
		$y=0;
	
		$sql="SELECT task_job_id as input_job_no_random_ref,trim_status FROM $pps.job_trims WHERE task_job_id='$taskJobId' and plant_code='$plantCode'"; 
		$result=mysqli_query($link, $sql) or exit("Sql Error5".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($row=mysqli_fetch_array($result))
		{							
			$input_job_no_random_ref=$row["input_job_no_random_ref"];
			$input_trims_status=$row["trim_status"];
			
			
			$add_css="behavior: url(border-radius-ie8.htc);  border-radius: 10px;";
			

			$job_detail_attributes = [];
			$qry_toget_style_sch = "SELECT attribute_name,attribute_value FROM $tms.task_attributes where task_jobs_id = '$taskJobId' and plant_code='$plantCode' and is_active=1";
			$qry_toget_style_sch_result = mysqli_query($link_new, $qry_toget_style_sch) or exit("Sql Error at toget_style_sch" . mysqli_error($GLOBALS["___mysqli_ston"]));
			while ($row2 = mysqli_fetch_array($qry_toget_style_sch_result)) {
				$job_detail_attributes[$row2['attribute_name']] = $row2['attribute_value'];
			
			}
			
			$doc_no_ref = $job_detail_attributes[$sewing_job_attributes['docketno']];
			$doc_no_ref1 = $job_detail_attributes[$sewing_job_attributes['docketno']];
			$doc_no_ref_input = $job_detail_attributes[$sewing_job_attributes['docketno']];
			// $carton_qty=$sql_rowy["carton_qty"];
			$style = $job_detail_attributes[$sewing_job_attributes['style']];
			$schedule = $job_detail_attributes[$sewing_job_attributes['schedule']];
			$schedule_no = $job_detail_attributes[$sewing_job_attributes['schedule']];
			$order_col = $job_detail_attributes[$sewing_job_attributes['color']];
			$color_info = $job_detail_attributes[$sewing_job_attributes['color']];
			$cols_de = str_pad("Color:".trim(implode(",",$color_info)),80)."\n";
			$input_job_no = $job_detail_attributes[$sewing_job_attributes['sewingjobno']];
			$type_of_sewing = $job_detail_attributes[$sewing_job_attributes['remarks']];
			$co_no = $job_detail_attributes[$sewing_job_attributes['conumber']];
			
			// var_dump($doc_no_ref);
			// die();
			$rej_qty=0;
			$rej_qty1=0;//recut
			$replce_qty=0;
	

			$qry_toget_first_ops_qry = "SELECT operation_code,original_quantity,good_quantity,rejected_quantity FROM $tms.task_job_transaction where task_jobs_id = '$taskJobId' and plant_code='$plantCode' and is_active=1 order by operation_seq asc limit 1";
			$qry_toget_first_ops_qry_result = mysqli_query($link_new, $qry_toget_first_ops_qry) or exit("Sql Error at toget_style_sch" . mysqli_error($GLOBALS["___mysqli_ston"]));
			while ($row3 = mysqli_fetch_array($qry_toget_first_ops_qry_result)) {
				$input_ops_code = $row3['operation_code'];
				$input_ops_code = $row3['original_quantity'];
				$input = $row3['good_quantity'];
				$rejection = $row3['rejected_quantity'];
			}
			// $application2='IPS';
			// $scanning_query12="select operation_code from $brandix_bts.tbl_ims_ops where appilication='$application2'";
			// $scanning_result12=mysqli_query($link, $scanning_query12)or exit("scanning_error".mysqli_error($GLOBALS["___mysqli_ston"]));
			// while($sql_row123=mysqli_fetch_array($scanning_result12))
			// {
			// 	$input_ops_code=$sql_row123['operation_code'];
			// }
			// // echo $input_ops_code."<br>";
			// if($input_ops_code == 'Auto'){
			// 	$get_ips_op = get_ips_operation_code($link,$style,$color_info);
			// 	$input_ops_code=$get_ips_op['operation_code'];
			// 	$operation_name=$get_ips_op['operation_name'];
			// }
			// echo $input_ops_code;
			
	
			// $sql12121="SELECT sum(recut_in) as qty,sum(replace_in) as rqty FROM $brandix_bts.bundle_creation_data WHERE input_job_no_random_ref='$input_job_no_random_ref' and operation_id=$input_ops_code";
			// // echo $sql12121.'<br>';	
			// $sql_result12121=mysqli_query($link, $sql12121) or exit($sql12."Sql Error-echo_1<br>".mysqli_error($GLOBALS["___mysqli_ston"]));
			// while($sql_row12121=mysqli_fetch_array($sql_result12121))
			// {
			// 	if($sql_row12121['qty'] > 0)
			// 	{
			// 		$rej_qty1 = $sql_row12121['qty'];
			// 	}
				
			// 	if($sql_row12121['rqty'] > 0)
			// 	{
			// 		$replce_qty = $sql_row12121['rqty'];
			// 	}
			// }	
			
			// $sql1212="SELECT sum(carton_act_qty) as qty FROM $bai_pro3.pac_stat_log_input_job WHERE input_job_no_random ='$input_job_no_random_ref' and doc_type='R'";
			// // echo $sql12.';<br>';
			// $sql_result1212=mysqli_query($link, $sql1212) or exit($sql12."Sql Error-echo_1<br>".mysqli_error($GLOBALS["___mysqli_ston"]));
			// while($sql_row1212=mysqli_fetch_array($sql_result1212))
			// {
			// 	if($sql_row1212['qty'] > 0)
			// 	{
			// 		$rej_qty = $sql_row1212['qty'];
			// 	}
			// }
	
			// $sql12="SELECT sum(recevied_qty) as input,sum(rejected_qty) as rejection FROM $brandix_bts.bundle_creation_data WHERE input_job_no_random_ref='$input_job_no_random_ref' and operation_id=$input_ops_code";
			// // echo $sql12.';<br>';
			// $sql_result12=mysqli_query($link, $sql12) or exit($sql12."Sql Error-echo_1<br>".mysqli_error($GLOBALS["___mysqli_ston"]));
			// while($sql_row12=mysqli_fetch_array($sql_result12))
			// {
			// 	$input = $sql_row12['input'];
			// 	$rejection = $sql_row12['rejection'];
			// }
	
			if($rej_qty > 0 or $rej_qty1>0 or $replce_qty)
			{
				$rejection_border = "border-style: solid;border-color: Magenta ;border-width: 3px;";
			}
			else
			{
				$rejection_border = "";
			}			

			//FOR SCHEDULE CLUBBING ensuring for parent docket
			// if($doc_no_ref != ''){
			// 	$parent_doc_query = "SELECT GROUP_CONCAT(docket_line_number) as docs from $pps.jm_docket_lines where docket_line_number IN ($doc_no_ref) and plant_code='$plantCode' and is_active=1";
			// 	$parent_doc_result = mysqli_query($link,$parent_doc_query);
			// 	if($org_row = mysqli_fetch_array($parent_doc_result))
			// 		$doc_no_ref = $org_row['docs'];
			// }
			// if($doc_no_ref == ''){

			// 	$doc_no_ref = $doc_no_ref;
			// }


			// if($doc_no_ref != ''){
			// 	$parent_doc_query = "SELECT GROUP_CONCAT(org_doc_no) as docs from $bai_pro3.plandoc_stat_log  
			// 						where doc_no IN ($doc_no_ref) and org_doc_no > 0";
			// 	$parent_doc_result = mysqli_query($link,$parent_doc_query);
			// 	if($org_row = mysqli_fetch_array($parent_doc_result))
			// 		$doc_no_ref = $org_row['docs'];
			// }
			// if($doc_no_ref == '')
			// 	$doc_no_ref = $doc_no_ref1;
	
			// $sql33x112="SELECT co_no,MIN(st_status) AS st_status,MIN(ft_status) AS ft_status FROM $bai_pro3.bai_orders_db_confirm where order_del_no='$schedule' and order_col_des in ('".implode("','",explode(",",$order_col))."')";
			// $sql_result33x112=mysqli_query($link, $sql33x112) or exit("Sql Error10".mysqli_error($GLOBALS["___mysqli_ston"]));
			// while($sql_row33x112=mysqli_fetch_array($sql_result33x112))
			// {
			// 	$co_no=$sql_row33x112['co_no'];
			// 	$ft_status=$sql_row33x112['ft_status'];
			// 	$trims_status=$sql_row33x112['st_status'];
			// }
			// $co_no=$sql_row33x112['co_no'];
			$ft_status='1';
			$trims_status=$sql_row33x112['st_status'];
			// $colors=explode(",",$order_col);
			// for($i=0;$i<sizeof($colors);$i++)
			// {
			// 	$cols_de = str_pad("Color:".trim(implode(",",$colors)),80)."\n";
			// }
				
			// pending
			// if($input_trims_status>2)
			// {
			// 	$add_css="";
			// }
			if($input_trims_status=='PREPARINGMATERIAL')
			{
				$tstatus='Preparing Material';
			}
			elseif($input_trims_status=='MATERIALREADYFORPRODUCTION')
			{
				$tstatus='Material Ready for Production(in Pool)';
			}
			elseif($input_trims_status=='PARTIALISSUED')
			{
				$tstatus='Partial Issued';
			}
			elseif($input_trims_status=='ISSUED')
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
			
			// $prefix="";
			// $sql="SELECT prefix as result FROM $brandix_bts.tbl_sewing_job_prefix WHERE type_of_sewing='$type_of_sewing'";
			// // echo $sql."<br>";
			// $sql_result=mysqli_query($link, $sql) or exit($sql."Sql Error-echo_1<br>".mysqli_error($GLOBALS["___mysqli_ston"]));
			// while($sql_row=mysqli_fetch_array($sql_result))
			// {
			// 	$prefix = $sql_row['result'];
			// }
			// $display_prefix1=$prefix.leading_zeros($input_job_no,3);
	
			//hardcode
			$display_prefix1 = 'J';
			$cut_status=0;
			$fabric_status=5;
			$fabric_req=5;
			if($schedule!="")
			{
				$doc_no_ref_explode=explode(",",$doc_no_ref);
				$num_docs=sizeof($doc_no_ref_explode);
				
				$sql1x1="select * from $pps.jm_docket_lines where lay_status<>'DONE' and docket_line_number in ($doc_no_ref)";
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
					
				// $fabric_status="";
				// $sql1x11="select * from $bai_pro3.plandoc_stat_log where fabric_status<>'5' and doc_no in ($doc_no_ref)";
				// //echo $sql1x11."<br>";
				// $sql_result1x11=mysqli_query($link, $sql1x11) or exit("Sql Error8".mysqli_error($GLOBALS["___mysqli_ston"]));
				
				// if(mysqli_num_rows($sql_result1x11)>0)
				// {
				// 	$fabric_status="0";
				// }
				// else
				// {
				// 	$fabric_status="5";
				// }
				
				// $sql1x12="select * from $bai_pro3.plan_dashboard where fabric_status='1' and doc_no in ($doc_no_ref)";
				// //echo $sql1x12."<br>";
				
				// $sql_result1x12=mysqli_query($link, $sql1x12) or exit("Sql Error9".mysqli_error($GLOBALS["___mysqli_ston"]));
				// // echo mysqli_num_rows($sql_result1x12);
				// if(mysqli_num_rows($sql_result1x12)>0)
				// {
				// 	$fabric_status="1";
				// }								
				// $sql1x115="select * from $bai_pro3.fabric_priorities where doc_ref in ($doc_no_ref)";
				// $sql_result1x115=mysqli_query($link, $sql1x115) or exit("Sql Error8".mysqli_error($GLOBALS["___mysqli_ston"]));
				// if(mysqli_num_rows($sql_result1x115)>0)
				// {
				// 	if(sizeof($doc_no_ref_explode)<>mysqli_num_rows($sql_result1x115))
				// 	{
				// 		$fabric_req="0";
				// 	}
				// 	else
				// 	{
				// 		$fabric_req="5";
				// 	}	
				// }
				// else
				// {
				// 	$fabric_req="0";
				// }
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
				
				//hardcode
				$club_c_code=array();

				// $sql33x1="SELECT * FROM $bai_pro3.plan_dash_doc_summ where doc_no in (".$doc_no_ref.") order by doc_no*1";
				// $sql_result33x1=mysqli_query($link, $sql33x1) or exit("Sql Error10".mysqli_error($GLOBALS["___mysqli_ston"]));
				// while($sql_row33x1=mysqli_fetch_array($sql_result33x1))
				// {
				// 	$club_c_code[]=chr($sql_row33x1['color_code']).leading_zeros($sql_row33x1['acutno'],3);
				// }			
				// $club_c_code=array_unique($club_c_code);
			
				$title=str_pad("Style:".$style,50)."\n".str_pad("Co No:".$co_no,50)."\n".str_pad("Schedule:".$schedule,50)."\n". $cols_de.str_pad("Sewing Job No:".$display_prefix1,50)."\n".str_pad("Total Qty:".$carton_qty,50)."\n".str_pad("Balance to Issue:".($carton_qty-($input + $rejection)),50)."\n".str_pad("Cut Job No:".implode(", ",$club_c_code),50)."\n".str_pad("Remarks :".$rem,50)."\n".str_pad("Trim Status :".$tstatus,50);
				//$ui_url='input_status_update_input.php';	
				$ui_url = "http://".$_SERVER['HTTP_HOST'].implode('/',$v_r)."/input_status_update_input.php";
				$ui_url1 ='?r='.base64_encode('/sfcs_app/app/production/controllers/sewing_job/sewing_job_scaning/scan_input_jobs.php');
				$application='IPS';
				$cols_de='';
				$sidemenu=true;
				// $scanning_query=" select * from $brandix_bts.tbl_ims_ops where appilication='$application'";
				// // echo $scanning_query;
				// $scanning_result=mysqli_query($link, $scanning_query)or exit("scanning_error".mysqli_error($GLOBALS["___mysqli_ston"]));
				// while($sql_row=mysqli_fetch_array($scanning_result))
				// {
				// 	$operation_name=$sql_row['operation_name'];
				// 	$operation_code=$sql_row['operation_code'];
				// }
				// if($operation_code == 'Auto'){
				// 	$operation_code = get_ips_operation_code($link,$style,$co_no);
				// }
				
				if($id=="blue" || $id=="yellow")
				{
				
					// $cut_input_report_query="select sum(original_qty) as cut_qty,sum(recevied_qty+rejected_qty) as report_qty,sum(recevied_qty) as recevied_qty from brandix_bts.bundle_creation_data where input_job_no_random_ref='$input_job_no_random_ref' and operation_id=".$input_ops_code."";
					// $cut_input_report_result=mysqli_query($link, $cut_input_report_query)or exit("scanning_error".mysqli_error($GLOBALS["___mysqli_ston"]));
	
					// while($sql_row=mysqli_fetch_array($cut_input_report_result))
					// {
					// 	$cut_origional_qty=$sql_row['cut_qty'];
					// 	$report_origional_qty=$sql_row['report_qty'];
					// 	$recevied_qty=$sql_row['recevied_qty'];									
					// }
					
					// if(($cut_origional_qty > $report_origional_qty) && $recevied_qty>0){
					// 	$id='orange';
					// }


					/*else{
						$id='blue';
					}*/
					
					if($id=="yellow")
					{									
						if($add_css == ""){				
							$ips_data.="<div id=\"S$schedule\" style=\"float:left;\">
								<div id=\"SJ$input_job_no\" style=\"float:left;\">
									<div id=\"$input_job_no_random_ref\" class=\"$id\" style=\"font-size:12px; text-align:center; color:$id;$add_css.$rejection_border\" title=\"$title\" ><a href=\"javascript:void(0);\" onclick=\"viewPopupCenter('$style','$schedule','$module','$input_job_no_random_ref','$input_ops_code','$sidemenu');\"><font style=\"color:black;\"></font></a>
									</div>
								</div>
							</div>";
						}
						else
						{
							$ips_data.="<div id=\"S$schedule\" style=\"float:left;\">
								<div id=\"SJ$input_job_no\" style=\"float:left;\">
									<div id=\"$input_job_no_random_ref\" class=\"$id\" style=\"font-size:12px; text-align:center; color:$id;$add_css.$rejection_border\" title=\"$title\" ><a href=\"$ui_url?jobno=$input_job_no&style=$style&schedule=$schedule&module=$module&section=$section&doc_no=$input_job_no_random_ref&job_status=$id\" onclick=\"Popup=window.open('$ui_url?jobno=$input_job_no&style=$style&schedule=$schedule&module=$module&section=$section&doc_no=$input_job_no_random_ref&job_status=$id','Popup','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes, width=920,height=auto, top=23'); if (window.focus) {Popup.focus()} return false;\"><font style=\"color:black;\"></font></a>
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
									<div id=\"$input_job_no_random_ref\" class=\"$id\" style=\"font-size:12px; text-align:center; color:$id;$add_css.$rejection_border\" title=\"$title\" ><a href=\"javascript:void(0);\" onclick=\"viewPopupCenter('$style','$schedule','$module','$input_job_no_random_ref','$input_ops_code','$sidemenu');\"><font style=\"color:black;\"></font></a>
									</div>
								</div>
							</div>";
						}
						else
						{
							$ips_data.="<div id=\"S$schedule\" style=\"float:left;\">
								<div id=\"SJ$input_job_no\" style=\"float:left;\">
									<div id=\"$input_job_no_random_ref\" class=\"$id\" style=\"font-size:12px; text-align:center; color:$id;$add_css.$rejection_border\" title=\"$title\" ><a href=\"$ui_url?jobno=$input_job_no&style=$style&schedule=$schedule&module=$module&section=$section&doc_no=$input_job_no_random_ref&job_status=$id\" onclick=\"Popup=window.open('$ui_url?jobno=$input_job_no&style=$style&schedule=$schedule&module=$module&section=$section&doc_no=$input_job_no_random_ref&job_status=$id','Popup','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes, width=920,height=auto, top=23'); if (window.focus) {Popup.focus()} return false;\"><font style=\"color:black;\"></font></a>
									</div>
								</div>
							</div>";
						}
					}
				}
				else
				{
					
					$ips_data.="<div id=\"S$schedule\" style=\"float:left;\"><div id=\"SJ$input_job_no\" style=\"float:left;\"><div id=\"$input_job_no_random_ref\" class=\"$id\" style=\"font-size:12px; text-align:center; color:$id;$add_css.$rejection_border\" title=\"$title\" ><a href=\"$ui_url?jobno=$input_job_no&style=$style&schedule=$schedule&module=$module&section=$section&doc_no=$input_job_no_random_ref&job_status=$id\" onclick=\"Popup=window.open('$ui_url?jobno=$input_job_no&style=$style&schedule=$schedule&module=$module&section=$section&doc_no=$input_job_no_random_ref&job_status=$id','Popup','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes, width=920,height=400, top=23'); if (window.focus) {Popup.focus()} return false;\"><font style=\"color:black;\"></font></a></div></div></div>";
				}
				$y++;	
			}
			
		}
		// for($j=$y+1;$j<=$_GET['priority_limit'];$j++)
		// {	
		// 	$ips_data.="<div id=\"\" style=\"float:left;\">
		// 				<div id=\"$input_job_no_random_ref\" style=\"float:left;\">
		// 					<div id=\"$input_job_no_random_ref\" class=\"white\" style=\"font-size:12px; text-align:center; color:white\">
		// 					</div>
		// 				</div>
		// 			</div>";
		// }
		// $sqly="select buyer_div from $bai_pro3.plan_modules where module_id=$module";
		// $sql_resulty=mysqli_query($link, $sqly) or exit("Sql Error11".mysqli_error($GLOBALS["___mysqli_ston"]));
		// while($sql_rowy=mysqli_fetch_array($sql_resulty))
		// {
		// 	$buyer_div=$sql_rowy['buyer_div'];
		// 	$cut_wip_control=7000;
		// }
	}
	$ips_data.="</tr>";
	
	
}
	$ips_data.="</table>";
	$ips_data.="</p>";
	$ips_data.="</div>";

$data['data']=$ips_data;
$data['sec']=$sectionId;
echo json_encode($data);

?>