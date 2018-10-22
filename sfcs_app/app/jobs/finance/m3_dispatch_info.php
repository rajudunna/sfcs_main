
<?php 
//Date: 2016-07-05/SR#13357665/Task: need to add bharatk and remove vasadav in recipients list of this alert
//Date: 2016-07-05/SR#81531731/Task: need to add anojak in recipients list of this alert
$start_timestamp = microtime(true);
error_reporting(0);

$include_path=getenv('config_job_path');
include($include_path.'\sfcs_app\common\config\config_jobs.php');

include("mail_config.php");
error_reporting(0);
$facility=$global_facility_code;
$date=date("Y-m-d",strtotime('-1 days'));


$title_list = array
	(
	"GatePass No","Type","From","To","Address","Created On","Department","SubItemType","Security On","Created By","Quantity","Unit","Style","Schedule","Color","Destination","VPO","Vehicle No"
	);

$file_name="$facility"."_".$date."_Dispatches.csv";
$file = fopen($file_name,"w");

fputcsv($file,$title_list);
			
			$sqlx="select *,SUBSTRING_INDEX(prepared_by,'@',1) as prepared from $bai_pro3.disp_db where date(exit_date)='$date'";
			$sql_resultx=mysqli_query($link, $sqlx) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_rowx=mysqli_fetch_array($sql_resultx))
			{
				$aod_no='AOD'.$sql_rowx['disp_note_no'];
				$aod_no_value=$sql_rowx['disp_note_no'];
				$create_date=$sql_rowx['create_date'];
				$exit_date=$sql_rowx['exit_date'];
				$dispatched_by=$sql_rowx['dispatched_by'];
				$prepared_by=$sql_rowx['prepared'];
				$party=$sql_rowx['party'];
				$vehicle_no=$sql_rowx['vehicle_no'];
				
				$sqlx1="select * from $bai_pro3.party_db where pid=$party";
				$sql_resultx1=mysqli_query($link, $sqlx1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($sql_rowx1=mysqli_fetch_array($sql_resultx1))
				{
					$party_name=$sql_rowx1['party_name'];
					$party_location=$sql_rowx1['location'];
				}
				
				$sqlx1="select *, (ship_s_xs+ship_s_s+ship_s_m+ship_s_l+ship_s_xl+ship_s_xxl+ship_s_xxxl+ship_s_s01+ship_s_s02+ship_s_s03+ship_s_s04+ship_s_s05+ship_s_s06+ship_s_s07+ship_s_s08+ship_s_s09+ship_s_s10+ship_s_s11+ship_s_s12+ship_s_s13+ship_s_s14+ship_s_s15+ship_s_s16+ship_s_s17+ship_s_s18+ship_s_s19+ship_s_s20+ship_s_s21+ship_s_s22+ship_s_s23+ship_s_s24+ship_s_s25+ship_s_s26+ship_s_s27+ship_s_s28+ship_s_s29+ship_s_s30+ship_s_s31+ship_s_s32+ship_s_s33+ship_s_s34+ship_s_s35+ship_s_s36+ship_s_s37+ship_s_s38+ship_s_s39+ship_s_s40+ship_s_s41+ship_s_s42+ship_s_s43+ship_s_s44+ship_s_s45+ship_s_s46+ship_s_s47+ship_s_s48+ship_s_s49+ship_s_s50
) as ship_out_qty, stripSpeciaChars(ship_remarks,0,1,0,0) as ship_remarks from $bai_pro3.ship_stat_log where disp_note_no=$aod_no_value";
                //var_dump($sqlx1);
				$sql_resultx1=mysqli_query($link, $sqlx1) or exit("Sql Error11".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($sql_rowx1=mysqli_fetch_array($sql_resultx1))
				{
					$ship_schedule=$sql_rowx1['ship_schedule'];
					$ship_remarks=$sql_rowx1['ship_remarks'];
					if(strlen($ship_remarks)>0)
					{
						$ship_schedule=$ship_remarks;
					}
					$ship_cartons=$sql_rowx1['ship_cartons'];
					$ship_out_qty=$sql_rowx1['ship_out_qty'];
					
					$sqlx11="select *,group_concat(distinct trim(both from SUBSTRING_INDEX(order_col_des,'=',-1))) as order_col_des_group from $bai_pro3.bai_orders_db where order_del_no='$ship_schedule'";
					$sql_resultx11=mysqli_query($link, $sqlx11) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
					$rowcount_check=mysqli_num_rows($sql_resultx11);
					while($sql_rowx11=mysqli_fetch_array($sql_resultx11))
					{
						$ship_style=$sql_rowx11['order_style_no'];
						$color=$sql_rowx11['order_col_des_group'];
						$destination=$sql_rowx11['destination'];
					}
					
					
					$sqlx11="select MPO from $bai_pro2.shipment_plan_summ where schedule_no='$ship_schedule'";
					$sql_resultx11=mysqli_query($link, $sqlx11) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
					while($sql_rowx11=mysqli_fetch_array($sql_resultx11))
					{
						$MPO=$sql_rowx11['MPO'];
					}
					
					$sqlx11="select remarks from $bai_pro3.packing_summary where order_del_no='$ship_schedule' limit 1";
					$sql_resultx11=mysqli_query($link, $sqlx11) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
					while($sql_rowx11=mysqli_fetch_array($sql_resultx11))
					{
						$remarks=$sql_rowx11['remarks'];
					}
					
					if($rowcount_check>0)
					{
					if($remarks==NULL or $remarks=='')
					{
						$values=array();
						$values[]=$aod_no;
						$values[]='AOD';
						$values[]=$plant_name.'-'.$facility;
						$values[]=$party_name;
						$values[]=$party_location;
						$values[]=$create_date;
						$values[]='Finishing';
						$values[]='Shipment';
						$values[]=$exit_date;
						//$values[]=$ship_cartons." Cartons";
						$values[]=$prepared_by;
						$values[]=$ship_out_qty;
						$values[]=$fab_uom;
						$values[]=$ship_style;
						$values[]=$ship_schedule;
						$values[]=$color;
						$values[]=$destination;
						$values[]=$MPO;
						$values[]=$vehicle_no;
						
						fputcsv($file,$values);
										
						unset($values);
						
					}
					else
					{
						$temp1=array();
						$temp1=explode("*",$remarks);
						$assortlist=array();
						$colorlist=array();
						$assortlist=explode("$",current($temp1));
						$colorlist=explode("$",end($temp1));
						
						$sum_assortlist=array_sum($assortlist);
						$item_val=$ship_out_qty/$sum_assortlist;
						
						for($i=0;$i<sizeof($assortlist);$i++)
						{
							$values=array();
							$values[]=$aod_no;
							$values[]='AOD';
							$values[]=$plant_name.'-'.$facility;
							$values[]=$party_name;
							$values[]=$party_location;
							$values[]=$create_date;
							$values[]='Finishing';
							$values[]='Shipment';
							$values[]=$exit_date;
							//$values[]=$ship_cartons." Cartons";
							$values[]=$prepared_by;
							$values[]=$item_val*$assortlist[$i];
							$values[]=$fab_uom;
							$values[]=$ship_style;
							$values[]=$ship_schedule;
							$values[]=$colorlist[$i];
							$values[]=$destination;
							$values[]=$MPO;
							$values[]=$vehicle_no;
							
							fputcsv($file,$values);
											
							unset($values);
						}
					}
					
					}
					
				}
			}
			fclose($file);	
		$to=$Aod_gate_pass;
		
	
email_attachment($to,'Please open the attachment for dispatch details of Brandix Essentials Limited - '.$facility.' Facility on '.$date.'.<br/><br/> Message Sent Via: '.$plant_name.'', $plant_name.'-'.$facility.' Dispatch Details ('.$date.') ',$header_name, $header_mail, $file_name, $default_filetype='application/zip');


unlink($file_name);
	
$end_timestamp = microtime(true);
$duration = $end_timestamp - $start_timestamp;
print("Execution took ".$duration." milliseconds.");
?>

















