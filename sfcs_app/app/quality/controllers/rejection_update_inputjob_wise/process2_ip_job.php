<!--
Kirang/20150418 added validation to avoid additional rejections.

-->

<head>
<?php
//CR# 375 / RameshK - 2014-12-22 / To add supplier names against to the schedule
// Service Request #440767 / DharaniD / Clear the issue of replace quantity , display module no and shift for replace quantity in remarks column.
?>
<script>
 function button_disable()
{
	document.getElementById('process_message').style.visibility="visible";
	document.getElementById('update1').style.visibility="hidden";
}

function dodisable()
{
//enableButton();
document.getElementById('process_message').style.visibility="hidden"; 
}

function check1(x,y) 
{
	if(x<0)
	{
		alert("Enter Correct Value");
		return 1010;
	} 
	if(x>y)
	{
		alert("You cant replace more than the available quantity.");
		return 1010;
	}
}
</script>

<style>
body
{
	font-family: arial;
}
table
{
	border-collapse:collapse;
	font-size:12px;
}
td
{
	border: 1px solid red;
	white-space:nowrap;
	border-collapse:collapse;
}

th
{
	border: 1px solid red;
	white-space:nowrap;
	border-collapse:collapse;
}
</style>

<script type="text/javascript" language="javascript">
    window.onload = function () {
        noBack();
    }
    window.history.forward();
    function noBack() {
        window.history.forward();
    }
</script>

 <script language="JavaScript">

        var version = navigator.appVersion;

        function showKeyCode(e) {
            var keycode = (window.event) ? event.keyCode : e.keyCode;

            if ((version.indexOf('MSIE') != -1)) {
                if (keycode == 116) {
                    event.keyCode = 0;
                    event.returnValue = false;
                    return false;
                }
            }
            else {
                if (keycode == 116) {
                    return false;
                }
            }
        }

    </script>

</head>
<body onload="dodisable()" onpageshow="if (event.persisted) noBack();" onkeydown="return showKeyCode(event)">

<?php
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/m3_bulk_or_proc.php',4,'R'));
// include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/functions.php',4,'R'));
// include($_SERVER['DOCUMENT_ROOT']."/sfcs/app/quality/common/php/m3_bulk_or_proc.php"); 
// include($_SERVER['DOCUMENT_ROOT']."/sfcs/app/quality/common/php/ims_size.php");
function ims_sizes($order_tid,$ims_schedule,$ims_style,$ims_color,$ims_size2,$link)
{
   include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',4,'R'));

	$ims = substr($ims_size2,1);

	if($ims>=01 && $ims<=50)
	{
		
		if($order_tid=='')
		{
			$sql23="select title_size_$ims_size2 as size_val,title_flag from $bai_pro3.bai_orders_db_confirm where order_style_no='$ims_style' and order_del_no='$ims_schedule' and order_col_des='$ims_color'";
		}
		else
		{
			$sql23="select title_size_$ims_size2 as size_val,title_flag from $bai_pro3.bai_orders_db_confirm where order_tid='$order_tid'";
		}
		//echo $sql23."<br>";
		$sql_result=mysqli_query($link, $sql23) or exit("Sql Error11".mysqli_error($GLOBALS["___mysqli_ston"]));
		while($sql_row=mysqli_fetch_array($sql_result))
		{
				$size_val=$sql_row['size_val'];
				$flag = $sql_row['title_flag'];
	    }
			
		if($flag==1)
		{	
			return $size_val;
		}
		else
		{
			return $ims_size2;
		}		
	}
	else
	{
		return $ims_size2;
	}
					
}

if(isset($_POST['Update']))
{
	$module=$_POST['mods'];
	$team=$_POST['shift']; //array
	$date=$_POST['date']; //array
	$ref=$_POST['ref']; //multi array (rejection codes)
	$style=$_POST['style'];
	$schedule=$_POST['schedule'];
	$color=$_POST['color'];
	$size=$_POST['size'];
	$qty=$_POST['qty'];
	$test=$_POST['test'];
	$job=$_POST['job'];
	$form=$_POST['form'];
    // var_dump($ref);
	$sum = 0;
	foreach ($ref as $key => $value) {
		$sum += array_sum($value);
	}
	$replace_ref=array();
	
	$minilastid=0;
	$maxilastid=0;
	
	$ilast_codes=array();
	
	//Added by KiranG 20150418
	$usr_msg="The following entries are failed to update due to M3 system validations:<br/><table><tr><th>Module</th><th>Schedule</th><th>Color</th><th>Size</th><th>Quantity</th></tr>";
	if($sum > 0){
		for($x=0;$x<sizeof($qty);$x++)
		{
			$iLastid=0;
			if($qty[$x]>=0 and $qty[$x]!="")
			{
				$r_qty = array();
				$r_reasons = array();
				$check_proceed=0; //0-OK, 1- NOK
				$m3_op_qty_chk_ary=array();
				
				//Validation Check Start
				if($qty[$x]>0 and $qty[$x]!="" and $test[$x]==1 and strlen($style[$x])>0 and strlen($schedule[$x])>0 and strlen($color[$x])>0 and strlen($size[$x])>0)
				{
					//Added rejection transaction type based on reason wise (surplus reason is 5 and all others are 3)
					$qms_tran_type="3";
					$ref_code=array();
					for($j=0;$j<sizeof($ref[$x]);$j++)
					{
						if($ref[$x][$j]>0)
						{
							$ref_code[]=$j."-".$ref[$x][$j];
							
							//M3 Bulk Operation Reporting
								//Extract Operation Code and Reason Code
								//ref1=form factor (G/P), ref2=Source, ref3=reason refe
								$m3_reason_code='';
								$m3_operation_code='';
								
								$sql_sup="SELECT m3_reason_code FROM $bai_pro3.bai_qms_rejection_reason WHERE form_type = 'P' AND reason_code = '$ref[$x]'";
								$sql_result_sup=mysqli_query($link, $sql_sup) or exit("Sql Error1 $sql_sup".mysqli_error($GLOBALS["___mysqli_ston"]));
								while($sql_row_sup=mysqli_fetch_array($sql_result_sup))
								{
									$m3_reason_code=$sql_row_sup['m3_reason_code'];
									//$m3_operation_code=$sql_row_sup['m3_operation_code'];
								}
								
								//$m3_op_qty_chk_ary[$m3_operation_code]=$m3_op_qty_chk_ary[$m3_operation_code]+$ref[$x][$j];
								
								// if($check_proceed==0 and rejection_validation_m3($m3_operation_code,$schedule[$x],$color[$x],$size[$x],$ref[$x][$j],0,$username)=="FALSE")
								// {
								// 	$check_proceed=1;
								// }
							//M3 Bulk Operation Reporting
							
							if($j==33)
							{
								$qms_tran_type="5";
							}
						}
					}
				}
				else
				{
					$check_proceed=1;
				}
				
				//Additional Validation
				if(sizeof($m3_op_qty_chk_ary)>0)
				{
					foreach ($m3_op_qty_chk_ary as $key => $value)
					{
						if($check_proceed==0 and rejection_validation_m3($key,$schedule[$x],$color[$x],$size[$x],$value,0,$username)=="FALSE")
						{
							$check_proceed=1;
						}
					}
					
				}
				else
				{
					$check_proceed=1;
				}
				unset($m3_op_qty_chk_ary);
				
				//Validation Check End
				
				//validation
				$check_proceed=0;
				if($check_proceed==0)
				{
					if($qty[$x]>0 and $qty[$x]!="" and $test[$x]==1 and strlen($style[$x])>0 and strlen($schedule[$x])>0 and strlen($color[$x])>0 and strlen($size[$x])>0)
					{
						//Added rejection transaction type based on reason wise (surplus reason is 5 and all others are 3)
						$qms_tran_type="3";
						$ref_code=array();
						for($j=0;$j<sizeof($ref[$x]);$j++)
						{
							if($ref[$x][$j]>0)
							{
								$ref_code[]=$j."-".$ref[$x][$j];
								
								//M3 Bulk Operation Reporting
									//Extract Operation Code and Reason Code
									//ref1=form factor (G/P), ref2=Source, ref3=reason refe
									$m3_reason_code='';
									$m3_operation_code='';
									
									$sql_sup="SELECT m3_reason_code FROM bai_pro3.bai_qms_rejection_reason WHERE form_type = 'P' AND reason_code = '$ref[$x]'";
									$sql_result_sup=mysqli_query($link, $sql_sup) or exit("Sql Error2 $sql_sup".mysqli_error($GLOBALS["___mysqli_ston"]));
									// echo $sql_sup;
									while($sql_row_sup=mysqli_fetch_array($sql_result_sup))
									{
										$m3_reason_code=$sql_row_sup['m3_reason_code'];
										//$m3_operation_code=$sql_row_sup['m3_operation_code'];
									}
									//commenting for #759 CR 
									// $sql_sup="INSERT INTO $m3_bulk_ops_rep_db.m3_sfcs_tran_log (sfcs_date,sfcs_style,sfcs_schedule,sfcs_color,sfcs_size,sfcs_doc_no,sfcs_qty,sfcs_log_user,m3_op_des,sfcs_tid_ref,sfcs_mod_no,sfcs_shift,sfcs_reason) values(NOW(),'".$style[$x]."','".$schedule[$x]."','".$color[$x]."','".$size[$x]."','".substr($job[$x],1)."',".$ref[$x][$j].",USER(),'$m3_operation_code',$iLastid,'".(is_numeric($module[$x])?$module[$x]:'0')."','".$team[$x]."','".$m3_reason_code."')"; 
									$r_qty[] = $ref[$x][$j];
									$r_reasons[] = $m3_reason_code;
									// //echo $sql."<br/>";
									// mysqli_query($link, $sql_sup) or exit("Sql Error3 $sql_sup".mysqli_error($GLOBALS["___mysqli_ston"]));
									
									// $ilast_codes[]=((is_null($___mysqli_res = mysqli_insert_id($link))) ? false : $___mysqli_res);
								//M3 Bulk Operation Reporting
								//Logic for M3_TRANSACTIONS AND MO FILLING #759 CR CODE STARTING
								// LOGIC TO INSERT TRANSACTIONS IN M3_TRANSACTIONS TABLE
		
								
								if($j==33)
								{
									$qms_tran_type="5";
								}
							}
						}
						$doc_inputjob=$job[$x];
						$doc_input_job=explode("-",$doc_inputjob);
						if(count($doc_input_job)>0){
							$input_job=$doc_input_job[1];
							$doc=$doc_input_job[0];
						}else{
							$input_job=$job[$x];
							$doc=$job[$x];
						}
						$sql="insert into $bai_pro3.bai_qms_db (qms_style,qms_schedule,qms_color,qms_size,qms_qty,qms_tran_type,ref1,remarks,log_date,doc_no,log_user,input_job_no) values (\"".$style[$x]."\",\"".$schedule[$x]."\",\"".$color[$x]."\",\"".$size[$x]."\",".$qty[$x].",\"".$qms_tran_type."\",\"".implode("$",$ref_code)."\",\"".$module[$x]."-".$team[$x]."-".$form[$x]."\",\"".date("Y-m-d")."\",\"".$doc."\",'$username',\"".$input_job."\")";
						//echo $sql."<br>";
						mysqli_query($link, $sql) or exit("Sql Error4 $sql".mysqli_error($GLOBALS["___mysqli_ston"]));
						$iLastid=((is_null($___mysqli_res = mysqli_insert_id($link))) ? false : $___mysqli_res);
						
						
						//M3 Bulk upload tool
						//COMMENTING FOR #759 CR 
						// $sql_sup="update $m3_bulk_ops_rep_db.m3_sfcs_tran_log set sfcs_tid_ref=$iLastid where sfcs_tid in (".implode(",",$ilast_codes).")"; 
						// //echo $sql."<br/>";
						// mysqli_query($link, $sql_sup) or exit("Sql Error5 $sql_sup".mysqli_error($GLOBALS["___mysqli_ston"]));
						// //M3 Bulk upload tool
						
						// unset($ilast_codes);
						
						for($j=0;$j<sizeof($ref[$x]);$j++)
						{
							if($ref[$x][$j]>0)
							{
								//To add supplier names against to the schedule
								$sql_tid="select order_tid from $bai_pro3.bai_orders_db where order_del_no=\"".$schedule[$x]."\" and order_col_des=\"".$color[$x]."\"";
								$sql_result_tid=mysqli_query($link, $sql_tid) or exit("Sql Error6 $sql_tid".mysqli_error($GLOBALS["___mysqli_ston"]));
								while($sql_row_tid=mysqli_fetch_array($sql_result_tid))
								{
									$order_tid=$sql_row_tid["order_tid"];
								}
								
								$sql_col="select * from $bai_pro3.cat_stat_log where order_tid=\"".$order_tid."\" and category in ($in_categories) and purwidth > 0";
								$sql_result_col=mysqli_query($link, $sql_col) or exit("Sql Error7 $sql_col".mysqli_error($GLOBALS["___mysqli_ston"]));
								while($sql_row_col=mysqli_fetch_array($sql_result_col))
								{
									$compo_no=$sql_row_col["compo_no"];
								}
								
								//To add supplier names against to the schedule
								$supplier="";
								$sql_sup="select group_concat(distinct supplier) as sup from $bai_rm_pj1.sticker_report where item=\"".$compo_no."\"";
								$sql_result_sup=mysqli_query($link, $sql_sup) or exit("Sql Error8 $sql_sup".mysqli_error($GLOBALS["___mysqli_ston"]));
								while($sql_row_sup=mysqli_fetch_array($sql_result_sup))
								{
									$supplier=$sql_row_sup["sup"];
								}
								
								$sql1="insert into $bai_pro3.bai_qms_db_reason_track(qms_tid,qms_reason,qms_qty,supplier,log_date) values(\"".$iLastid."\",\"".$j."\",\"".$ref[$x][$j]."\",\"".$supplier."\",\"".date("Y-m-d")."\")";
								//echo $sql1."<br>";
								mysqli_query($link, $sql1) or exit("Sql Error9 $sql1".mysqli_error($GLOBALS["___mysqli_ston"]));
								
								
								
								
							}
						}
						//$replace_ref[]=$style[$x]."$".$schedule[$x]."$".$color[$x]."$".$size[$x]."$".$module;	
					}
							
					$replace_ref[]=$style[$x]."$".$schedule[$x]."$".$color[$x]."$".$size[$x]."$".$module[$x]."$".$team[$x]."$".$iLastid;	
					//to track min and max insert ids
					$maxilastid=$iLastid;
					if($minilastid==0)
					{
						$minilastid=$iLastid;
					}
				}
				else
				{
					$usr_msg.="<tr><td>".$module[$x]."</td><td>".$schedule[$x]."</td><td>".$color[$x]."</td><td>".$size[$x]."</td><td>".$qty[$x]."</td></tr>";
				}
				//Logic for M3_TRANSACTIONS AND MO FILLING #759 CR CODE STARTING
				$doc_no_ref = substr($job[$x],1);
				// echo $doc_no_ref.'-';
				// var_dump($r_qty).'-';
				// var_dump($r_reasons).'-';
				$op_code = '15';
				$b_op_id = '15';
				$b_tid = array();
				$b_module = (is_numeric($module[$x])?$module[$x]:'0');
				$b_shift = $team[$x];
				$key_size = $size[$x];
				//getting work_station_id
				$qry_to_get_work_station_id = "SELECT work_center_id,short_cut_code FROM $brandix_bts.`tbl_orders_ops_ref` WHERE operation_code = '$b_op_id'";
				//echo $qry_to_get_work_station_id.'-';
				$result_qry_to_get_work_station_id=mysqli_query($link,$qry_to_get_work_station_id) or exit("Bundles Query Error14".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($row=mysqli_fetch_array($result_qry_to_get_work_station_id))
				{
					$work_station_id = $row['work_center_id'];
					$short_key_code = $row['short_cut_code'];
				}
				if(!$work_station_id)
				{
					$qry_to_get_work_station_id = "SELECT work_station_id FROM bai_pro3.`work_stations_mapping` WHERE operation_code = '$short_key_code' AND module = '$b_module'";
					//echo $qry_to_get_work_station_id;
					$result_qry_to_get_work_station_id=mysqli_query($link,$qry_to_get_work_station_id) or exit("Bundles Query Error14".mysqli_error($GLOBALS["___mysqli_ston"]));
					while($row=mysqli_fetch_array($result_qry_to_get_work_station_id))
					{
						$work_station_id = $row['work_station_id'];
					} 
				}
				//getting bundles from mo_operation_details
				//getting mos and filling up
				// INSERTING INTO M3_TRANSACTOINS TABLE AND UPDATING INTO M3_OPS_DETAILS
				$qty_to_fetch_size_title = "SELECT title_size_$key_size  FROM $bai_pro3.bai_orders_db_confirm WHERE order_tid ='$order_tid'";
				// echo $qty_to_fetch_size_title;
				$res_qty_to_fetch_size_title=mysqli_query($link,$qty_to_fetch_size_title) or exit("Bundles Query Error14".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($nop_res_qty_to_fetch_size_title=mysqli_fetch_array($res_qty_to_fetch_size_title))
				{
					$size_title = $nop_res_qty_to_fetch_size_title["title_size_$key_size"];
				}
				//echo '</br>sizing'.$size_title.'</br>';
				// $qry_to_check_mo_numbers = "SELECT mq.id AS bundle_no FROM $bai_pro3.`mo_operation_quantites`  mq LEFT JOIN bai_pro3.mo_details md ON md.mo_no=mq.`mo_no` WHERE doc_no = '$doc_no_ref' AND op_code = '$op_code' and size = '$size_title'";
				// echo $qry_to_check_mo_numbers.'-';
				// $qry_nop_result=mysqli_query($link,$qry_to_check_mo_numbers) or exit("Bundles Query Error14".mysqli_error($GLOBALS["___mysqli_ston"]));
				// $total_bundle_present_qty = $value;
				// $total_bundle_rec_present_qty = $value;
				// while($nop_qry_row=mysqli_fetch_array($qry_nop_result))
				// {
				// 	$b_tid[] = $nop_qry_row['bundle_no'];
				// }
				// var_dump($b_tid).'-';
				//for($i=0;$i<sizeof($b_tid);$i++)
				//{
					$value_b = $b_tid[$i];
					// $r_qty = explode(",", $r_qty[$value_b]);
					// $r_reasons = explode(",", $r_reasons[$value_b]);
					//var_dump($r_qty);
					foreach($r_qty as $key=>$value)
					{
						$qry_to_check_mo_numbers = "SELECT *,mq.id AS id FROM $bai_pro3.`mo_operation_quantites`  mq LEFT JOIN bai_pro3.mo_details md ON md.mo_no=mq.`mo_no` WHERE doc_no = '$doc_no_ref' AND op_code = '$op_code' and size = '$size_title'";
						//echo $qry_to_check_mo_numbers;
						$qry_nop_result=mysqli_query($link,$qry_to_check_mo_numbers) or exit("Bundles Query Error14".mysqli_error($GLOBALS["___mysqli_ston"]));
						$total_bundle_rej_present_qty = $r_qty[$key];
						while($nop_qry_row=mysqli_fetch_array($qry_nop_result))
						{
							$total_bundle_present_qty = $total_bundle_rej_present_qty;
							$mo_number = $nop_qry_row['mo_no'];
							$mo_quantity = $nop_qry_row['bundle_quantity'];
							$good_quantity_past = $nop_qry_row['good_quantity'];
							$rejected_quantity_past = $nop_qry_row['rejected_quantity'];
							$id = $nop_qry_row['id'];
							//$mo_no = $nop_qry_row['id'];
							$balance_max_updatable_qty = $mo_quantity - ($good_quantity_past + $rejected_quantity_past);
							// echo $total_bundle_present_qty;
							if($total_bundle_present_qty > 0)
							{
								if($balance_max_updatable_qty > 0)
								{
									if($balance_max_updatable_qty >= $total_bundle_rej_present_qty)
									{
										$to_update_qty = $total_bundle_rej_present_qty;
										$actual_rej_qty = $rejected_quantity_past+$total_bundle_rej_present_qty;
										$update_qry = "update $bai_pro3.mo_operation_quantites set rejected_quantity = $actual_rej_qty where id= $id";
										$total_bundle_rej_present_qty = 0;
									}
									else
									{
										$to_update_qty = $balance_max_updatable_qty;
										$actual_rej_qty = $rejected_quantity_past+$balance_max_updatable_qty;
										$update_qry = "update $bai_pro3.mo_operation_quantites set rejected_quantity = $actual_rej_qty where id= $id";
										$total_bundle_rej_present_qty = $total_bundle_rej_present_qty - $balance_max_updatable_qty;
									}
									//echo $update_qry.'</br>';
									$ims_pro_qty_updating = mysqli_query($link,$update_qry) or exit("While updating mo_operation_quantites".mysqli_error($GLOBALS["___mysqli_ston"]));
									//echo $update_qry.'</br>';
									// echo $r_reasons[$key];
								
									$inserting_into_m3_tran_log = "INSERT INTO $bai_pro3.`m3_transactions` (`mo_no`,`quantity`,`reason`,`remarks`,`log_user`,`tran_status_code`,`module_no`,`shift`,`op_code`,`op_des`,`ref_no`,`workstation_id`,`response_status`) VALUES ('$mo_number',$to_update_qty,'$r_reasons[$key]','Normal',user(),'',$b_module,'$b_shift',$b_op_id,'',$id,'$work_station_id','')";
									// echo $inserting_into_m3_tran_log.'</br>';
									mysqli_query($link,$inserting_into_m3_tran_log) or exit("While inserting into the m3_transactions".mysqli_error($GLOBALS["___mysqli_ston"]));

									//getting the last inserted record
									$insert_id=mysqli_insert_id($link);

									//M3 Rest API Call
									// $api_url = $host.":".$port."/m3api-rest/execute/PMS070MI/RptOperation?CONO=$company_num&FACI=$plant_code&MFNO=$mo_number&OPNO=$b_op_id&DPLG=$work_station_id&MAQA=''&SCQA=$to_update_qty&SCRE='$r_reasons[$key]'&DSP1=1&DSP2=1&DSP3=1&DSP4=1";
									// $api_data = $obj->getCurlAuthRequest($api_url);
									// $decoded = json_decode($api_data,true);
									// $type=$decoded['@type'];
									// $code=$decoded['@code'];
									// $message=$decoded['Message'];

									// //validating response pass/fail and inserting log
									// if($type!='ServerReturnedNOK'){
									// 	//updating response status in m3_transactions
									// 	$qry_m3_transactions="UPDATE $bai_pro3.`m3_transactions` SET response_status='pass' WHERE id=".$insert_id;
									// 	mysqli_query($link,$qry_m3_transactions) or exit("While updating into M3 transaction log".mysqli_error($GLOBALS["___mysqli_ston"]));

									// }else{
									// 	//updating response status in m3_transactions
									// 	$qry_m3_transactions="UPDATE $bai_pro3.`m3_transactions` SET response_status='fail' WHERE id=".$insert_id;
									// 	mysqli_query($link,$qry_m3_transactions) or exit("While updating into M3 Transactions".mysqli_error($GLOBALS["___mysqli_ston"]));

									// 	//insert transactions details into transactions_log
									// 	$qry_transactionslog="INSERT INTO $brandix_bts.`transactions_log` (`transaction_id`,`response_message`,`created_by`,`created_at`,`updated_at`) VALUES ('$insert_id',$message,USER(),$current_date)"; 
									// 	mysqli_query($link,$qry_transactionslog) or exit("While inserting into M3 transaction log".mysqli_error($GLOBALS["___mysqli_ston"]));
									// }
								}
							}
						}
					}
					
							
				//}
				//Logic Ends Here
			}
		}
		$usr_msg.="</table>";
		//die();
		
		//Validations
		//echo $usr_msg;
		
		$replace_ref=array_unique($replace_ref);
		echo "<div class='panel panel-primary'><div class='panel-heading'>Rejection Replacement Update Panel</div><div class='panel-body'>";
		echo "<form name=\"input\" method=\"post\" action=\"?r=".$_GET['r']."\">";
		// echo "<h2>Rejection Replacement Update Panel</h2>";
		
		echo "<input type=\"hidden\" name=\"replace_ref\" value=\"".implode("#",$replace_ref)."\">";
		echo "<div class=\"table-responsive\">
			<table  class='table table-bordered'>";
		echo "<tr class='success'><th>Style</th><th>Schedule</th><th>Color</th><th>Size</th><th>Available to Replace</th><th>Qty Replaced</th></tr>";
		
		for($i=0;$i<sizeof($replace_ref);$i++)
		{
			$temp=array();
			$temp=explode("$",$replace_ref[$i]);
			
			//$sql="select sum(if((qms_tran_type=1 or qms_tran_type=5),qms_qty,0)) as \"good\", sum(if(qms_tran_type=2,qms_qty,0)) as \"replaced\", sum(if(qms_tran_type=3,qms_qty,0)) as \"rejected\", sum(if(qms_tran_type=10,qms_qty,0)) as \"tran_sent\", sum(if(qms_tran_type=12,qms_qty,0)) as \"res_panel_destroy\" from bai_qms_db where qms_style=\"".$temp[0]."\" and  qms_schedule=\"".$temp[1]."\" and qms_color=\"".$temp[2]."\" and qms_size=\"".$temp[3]."\"";
			//$sql="select sum(if((qms_tran_type=1),qms_qty,0)) as \"good\", sum(if(qms_tran_type=2,qms_qty,0)) as \"replaced\", sum(if(qms_tran_type=3,qms_qty,0)) as \"rejected\", sum(if(qms_tran_type=10,qms_qty,0)) as \"tran_sent\", sum(if(qms_tran_type=12,qms_qty,0)) as \"res_panel_destroy\" from bai_qms_db where qms_style=\"".$temp[0]."\" and  qms_schedule=\"".$temp[1]."\" and qms_color=\"".$temp[2]."\" and qms_size=\"".$temp[3]."\"";
			
			$sql="select sum(if((qms_tran_type=1),qms_qty,0)) as \"good\", sum(if(qms_tran_type=2,qms_qty,0)) as \"replaced\", sum(if(qms_tran_type=3,qms_qty,0)) as \"rejected\",sum(if(qms_tran_type=3 and qms_tid=".$temp[6].",qms_qty,0)) as \"line_rejected\",
			sum(if(qms_tran_type=3 and qms_tid>=$minilastid and qms_tid<".$temp[6].",qms_qty,0)) as \"prev_cumm_rejected\",
			sum(if(qms_tran_type=3 and qms_tid>=$minilastid and qms_tid<=".$temp[6].",qms_qty,0)) as \"cumm_rejected\",
			sum(if(qms_tran_type=10,qms_qty,0)) as \"tran_sent\", sum(if(qms_tran_type=12,qms_qty,0)) as \"res_panel_destroy\" from $bai_pro3.bai_qms_db where qms_style=\"".$temp[0]."\" and  qms_schedule=\"".$temp[1]."\" and qms_color=\"".$temp[2]."\" and qms_size=\"".$temp[3]."\"";
			//echo $sql."<br>";
			$sql_result=mysqli_query($link, $sql) or exit("Sql Error10 $sql".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row=mysqli_fetch_array($sql_result))
			{
				$row_count++;
				//Added Sent and reserve for destroy $available=$sql_row['good']-$sql_row['replaced']
				$available=$sql_row['good']-$sql_row['replaced']-$sql_row['tran_sent']-$sql_row['res_panel_destroy'];
				$allowed=0;
				
				/*if($sql_row['rejected']>$sql_row['replaced'] and $available>0)
				{
					if($available>($sql_row['rejected']-$sql_row['replaced']))
					{
						$allowed=$sql_row['rejected']-$sql_row['replaced'];
					}
					else
					{
						$allowed=$sql_row['good']-$sql_row['replaced'];
					}
				}*/
				
				//Logic: if prev cumm<available and available>coumm then rejec else prev cumm<available then available-prev cumm else 0
				if($sql_row['prev_cumm_rejected']<$available and $available>$sql_row['cumm_rejected'])
				{
					$allowed=$sql_row['line_rejected'];
				}
				else
				{
					if($sql_row['prev_cumm_rejected']<$available)
					{
						$allowed=$available-$sql_row['prev_cumm_rejected'];
					}
					else
					{
						$allowed=0;
					}
				}
				
				$size_value=ims_sizes($order_tid,$ims_schedule,$ims_style,$ims_color,$temp[3],$link);
				
				echo "<tr><td>".$temp[0]."</td><td>".$temp[1]."</td><td>".$temp[2]."</td><td>".$size_value."</td>
						<td>".$allowed."</td>
						<td><input type=\"number\"  name=\"replace[]\" value=\"\" onkeyup='verify_alpha(event)' onchange=\"if(check1(this.value,$allowed)==1010) { this.value=0; }\"></td>
				</tr>";
				
			}
		}
		echo "</table></div>";
		echo '<input type="submit" class="btn btn-success" name="update1" id="update1"  value="update" onclick="javascript:button_disable();">';
		echo '<div id="process_message"><h2><font color="red">Please wait while updating data!!!</font><br/><font color="blue">After update, this window will close automatically!</font></h2></div>';
		echo "</form></div></div>";
		if($row_count > 0){
			echo '<script>document.getElementById("update1").disabled = false;</script>';
		}else{
			echo '<script>document.getElementById("update1").disabled = true;</script>';
		}
	}else{
		$url =  getFullURLLevel($_GET['r'],'reject_update_panel2_ip_job.php',0,'N');
		echo "<script>sweetAlert('Form Validation failed.').then((value) => { window.location.href = '$url'});</script>";
	}
}
die();
?>

</body>
<script>
	function verify_alpha(e){
		var k = e.target.value;
		if( isNaN(k) ){
			sweetAlert('Only digits are allowed in quantity','','warning');
			e.target.value = '';
			return;
		}
	}
</script>

<?php

if(isset($_POST['update1']))
{
	$replace=$_POST['replace'];
	$replace_ref=array();
	$replace_ref=explode("#",$_POST['replace_ref']);
	
	for($i=0;$i<sizeof($replace);$i++)
	{
		if($replace[$i]>0)
		{
			$temp=array();
			//echo "temp=".$replace_ref[$i];
			$temp=explode("$",$replace_ref[$i]);
			
			$sql="insert into $bai_pro3.bai_qms_db (qms_style,qms_schedule,qms_color,qms_size,qms_qty,qms_tran_type,remarks,log_date,ref1,log_user) values (\"".$temp[0]."\",\"".$temp[1]."\",\"".$temp[2]."\",\"".$temp[3]."\",".$replace[$i].",2,\"".$temp[4]."-".$temp[5]."\",\"".date("Y-m-d")."\",\"TID-".$temp[6]."\",'$username')";
			//echo "<br/> query= ".$sql;
			$sql_result=mysqli_query($link, $sql) or exit("Sql Error11 $sql".mysqli_error($GLOBALS["___mysqli_ston"]));
			
			//FOR M3 Upload
			if($temp[4]=="ENP")
			{
				
			}
			else
			{
				//commented for #759 CR
				// $sql="select sfcs_tid from $m3_bulk_ops_rep_db.m3_sfcs_tran_log where sfcs_style='".$temp[0]."' and sfcs_schedule='".$temp[1]."' and sfcs_color='".$temp[2]."' and sfcs_job_no='REPLACE' and sfcs_tid_ref=".$temp[6];
				// $sql_result=mysqli_query($link, $sql) or exit("Sql Error12 $sql".mysqli_error($GLOBALS["___mysqli_ston"])); 	
				
				// if(mysqli_num_rows($sql_result)==0)
				// {
				// 	$sql="INSERT INTO $m3_bulk_ops_rep_db.m3_sfcs_tran_log (sfcs_date,sfcs_style,sfcs_schedule,sfcs_color,sfcs_size,sfcs_doc_no,sfcs_qty,sfcs_log_user,m3_op_des,sfcs_job_no,sfcs_tid_ref,sfcs_mod_no,sfcs_shift) values(NOW(),'".$temp[0]."','".$temp[1]."','".$temp[2]."','".$temp[3]."',0,".$replace[$i].",USER(),'SIN','REPLACE',".$temp[6].",'".$temp[4]."','".$temp[5]."')";
				// 	mysqli_query($link, $sql) or exit("Sql Error13 $sql".mysqli_error($GLOBALS["___mysqli_ston"])); 
				// }
					
			}
		}
	}
	echo "<h2>Successfully Updated.</h2>";
}

?>
