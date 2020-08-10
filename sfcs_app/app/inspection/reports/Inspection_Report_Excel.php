<?php
include($_SERVER['DOCUMENT_ROOT']."/sfcs_app/common/config/config.php");
include($_SERVER['DOCUMENT_ROOT']."/sfcs_app/common/config/functions.php");
// include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/rest_api_calls.php');
error_reporting(0);
$plantcode=$_SESSION['plantCode'];
$username=$_SESSION['userName'];
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7">
  

<title>BAI Fabric Inspection : Batch Wise Summary Report</title>
<style>
		#ad{
			padding-top:220px;
			padding-left:10px;
		}
		
		body
		{
			font-family:Century Gothic;
			font-size:12px;
		}
		
		.report tr
		{
			border: 1px solid black;
			text-align: right;
			white-space:nowrap; 
		}
		
		.report td
		{
			border: 1px solid black;
			text-align: right;
			white-space:nowrap; 
		}
		
		.report th
		{
			border: 1px solid black;
			text-align: center;
		    background-color: BLUE;
			color: WHITE;
			white-space:nowrap; 
			padding-left: 5px;
			padding-right: 5px;
			font-size: 14px;
		}
		
		.report {
			white-space:nowrap; 
			border-collapse:collapse;
			font-size:12px;
		}

	</style>

</head>

<body>


<?php
if(isset($_POST['export']))
{

$sdate=$_POST['fdate'];
$edate=$_POST['tdate'];
$batch_search=$_POST['batch_no'];
$buyer_select=$_POST['buyerdiv'];
$sql="SELECT DISTINCT buyer FROM $wms.sticker_report where plant_code='$plantcode'";
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row=mysqli_fetch_array($sql_result))
{
	$buyer_name[]=$sql_row["buyer"];
}
	for($i=0;$i<sizeof($buyer_name);$i++)
	{
		$all_buyers[] = $buyer_name[$i];
	}
if($buyer_select=='All'){
		$selected_buyer = $all_buyers;
	}else{
		$selected_buyer = array($buyer_select);
	}
?>
<?php

$table= '<h2>Fabric Inspection Summary Report - '.date("Y-m-d").'</h2>';

$table.= "<table class=\"report\">";
$table.= "<tr>";
$table.= "<th>Report ID</th>";
$table.= "<th>Buyer</th>";
$table.= "<th>Fabric Description</th>";
$table.= "<th>Batch No</th>";
$table.= "<th>Item Code</th>";
$table.= "<th>Lot No</th>";
$table.= "<th>Supplier</th>";
$table.= "<th>Colour</th>";
$table.= "<th>Qty In ()</th>";
$table.= "<th>PTS</th>";
$table.= "<th>Package</th>";
$table.= "<th>PO No</th>";
$table.= "<th>Qty Inspected</th>";
$table.= "<th>Fallout</th>";
$table.= "<th>Act GSM</th>";
$table.= "<th>GRN Date</th>";
$table.= "<th>Pct Inspected</th>";
$table.= "<th>Skewness</th>";
$table.= "<th>Purchase Width</th>";
$table.= "<th>No of Rolls</th>";
$table.= "<th>Length Shortage %</th>";
$table.= "<th>Actual Width</th>";
$table.= "<th>Category</th>";
$table.= "<th>Fabric Way</th>";
$table.= "<th>Residual Shink L</th>";
$table.= "<th>Residual Shink W</th>";
$table.= "<th>Invoice</th>";
$table.= "<th>No. Rolls</th>";
$table.= "<th>Ticket Length</th>";
$table.= "<th>C-Tex Length</th>";
$table.= "<th>Length Shortage</th>";
$table.= "<th>Ticket Width(Avg)</th>";
$table.= "<th>C-Tex Width(Avg)</th>";
$table.= "<th>Width Shortage</th>";
$table.= "</tr>";
	if(strlen($batch_search)>0)
	{	
		$sqlx="select * from $wms.inspection_db where plant_code='$plantcode' and batch_ref=\"$batch_search\"";
	}
	else
	{
		$sqlx="select * from $wms.inspection_db where plant_code='$plantcode' and date(log_date) between \"$sdate\" and \"$edate\"";
	}


	$sql_resultx=mysqli_query($link, $sqlx) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_rowx=mysqli_fetch_array($sql_resultx))
	{
		$act_gsm=$sql_rowx['act_gsm'];
		$pur_width=$sql_rowx['pur_width'];
		$act_width=$sql_rowx['act_width'];
		$sp_rem=$sql_rowx['sp_rem'];
		$qty_insp=$sql_rowx['qty_insp'];
		$gmt_way=$sql_rowx['gmt_way'];
		$pts=$sql_rowx['pts'];
		$fallout=$sql_rowx['fallout'];
		$skew=$sql_rowx['skew'];
		$skew_cat=$sql_rowx['skew_cat'];
		$shrink_l=$sql_rowx['shrink_l'];
		$shrink_w=$sql_rowx['shrink_w'];
		$supplier=$sql_rowx['supplier'];
		
		$lot_no=$sql_rowx['batch_ref'];
		
		
		if($lot_no!=NULL)
		{
			$sql="select *, SUBSTRING_INDEX(buyer,\"/\",1) as \"buyer_code\", group_concat(distinct item  SEPARATOR ', ') as \"item_batch\",group_concat(distinct pkg_no) as \"pkg_no_batch\",group_concat(distinct po_no) as \"po_no_batch\",group_concat(distinct inv_no) as \"inv_no_batch\", group_concat(distinct lot_no  SEPARATOR ', ') as \"lot_ref_batch\", count(distinct lot_no) as \"lot_count\", sum(rec_qty) as \"rec_qty1\"from $wms.sticker_report where plant_code='$plantcode' and batch_no=\"".trim($lot_no)."\" and right(trim(both from lot_no),1)<>'R'";
	
			$sql_result=mysqli_query($link, $sql) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($sql_row=mysqli_fetch_array($sql_result))
			{
				$product_group=$sql_row['product_group'];
				$item=$sql_row['item_batch'];
				$item_name=$sql_row['item_name'];
				$item_desc=$sql_row['item_desc'];
				$inv_no=$sql_row['inv_no_batch'];
				$po_no=$sql_row['po_no_batch'];
				$rec_no=$sql_row['rec_no'];
				$rec_qty=$sql_row['rec_qty1'];
				$batch_no=$sql_row['batch_no'];
				$buyer=$sql_row['buyer'];
				$pkg_no=$sql_row['pkg_no'];
				$grn_date=$sql_row['grn_date'];
				$lot_ref_batch=$sql_row['lot_ref_batch'];
				$lot_count=$sql_row['lot_count'];
				$buyer_code=$sql_row['buyer_code'];
				
				$code=date("ymd",strtotime($sql_rowx['log_date']))."/$buyer_code/".$sql_rowx['unique_id'];
				
				//NEW SYSTEM IMPLEMENTATION RESTRICTION
				$new_ref_date=substr($grn_date,0,4)."-".substr($grn_date,4,2)."-".substr($grn_date,6,2);
				if($new_ref_date>"2011-05-12")
				{
					
				}
				else
				{

				}
				//NEW SYSTEM IMPLEMENTATION RESTRICTION
				
			}
			
			//$print_check=1;
			$print_check=0;
			$values=array();
			$scount_temp=array();
			$ctex_sum=0;
			$avg_t_width=0;
			$avg_c_width=0;
			
			if($lot_ref_batch!=NULL and $new_ref_date!="--")
			{
				$rec_qty=0;
			
				$sql="select *, if((length(ref5)<0 or length(ref6)<0 or length(ref3)<0),1,0) as \"print_check\", qty_rec  from $wms.store_in where plant_code='$plantcode' and lot_no in ($lot_ref_batch) order by ref2+0";
				//$table.= $sql;
				$sql_result=mysqli_query($link, $sql) or exit("Sql Error3".mysqli_error($GLOBALS["___mysqli_ston"]));
				$num_rows=mysqli_num_rows($sql_result);
				while($sql_row=mysqli_fetch_array($sql_result))
				{
				$values[]=$sql_row['tid']."~".$sql_row['ref2']."~".$sql_row['ref4']."~".$sql_row['qty_rec']."~".$sql_row['ref5']."~".$sql_row['ref6']."~".$sql_row['ref3']."~".$sql_row['lot_no'];
			//tid,rollno,shade,tlenght,clenght,twidth,cwidth,lot_no
				
				$scount_temp[]=$sql_row['ref4'];
				$ctex_sum+=$sql_row['ref5'];
				$avg_t_width+=$sql_row['ref6'];
				$avg_c_width+=$sql_row['ref3'];
				
				/* if($print_check==1)
				{
					if($sql_row['print_check']==0)
					{
						$print_check=$sql_row['print_check'];
					}
				} */
				if($sql_row['print_check']==1)
				{
					$print_check=1;
				}
				
				$rec_qty+=$sql_row['qty_rec'];  //NEW version (to calculate rec qty as per sticker generted qty and not based on the batch quantity)
			}																				
				
				
				if($print_check==0 and $num_rows>0 and in_array($buyer,$selected_buyer))
				{
				// include('../common/php/supplier_db.php'); 
				
				sort($scount_temp); //to sort shade groups
				$avg_t_width=round($avg_t_width/$num_rows,2);
				$avg_c_width=round($avg_c_width/$num_rows,2);
				$scount_temp2=array();
				$scount_temp2=array_values(array_unique($scount_temp));
				$shade_count=sizeof($scount_temp2);
				//Configuration 
				
				
				$sql="select  COUNT(DISTINCT REPLACE(ref2,\"*\",\"\"))  as \"count\" from $wms.store_in where plant_code='$plantcode' and lot_no in ($lot_ref_batch)";
				$sql_result=mysqli_query($link, $sql) or exit("Sql Error4".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($sql_row=mysqli_fetch_array($sql_result))
				{
					$total_rolls=$sql_row['count'];
				}
				
				if(stristr($item,"BF"))
				{
					$category="BF";
				}
				
				if(stristr($item,"GF"))
				{
					$category="GF";
				}
				
				 $table.= "<tr>"; 
				 $table.= "<td>".$code."</td>"; 
				 $table.= "<td>".$buyer."</td>"; 
				 $table.= "<td>".$item_name."</td>"; 
				 $table.= "<td>".$batch_no."</td>"; 
				 $table.= "<td>".$item."</td>"; 
				 $table.= "<td>".$lot_ref_batch."</td>"; 
				  
		
				$check=0;
				$sql_supplier = "SELECT supplier_m3_code as supplier_name FROM $bai_rm_pj1.inspection_supplier_db where seq_no=".$supplier;
				$sql_result_supplier=mysqli_query($link, $sql_supplier) or exit("Sql Error5".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($sql_row=mysqli_fetch_array($sql_result_supplier))
				{
					$supplier=$sql_row['supplier_name'];
					$check = 1;
				}

				// $supplier_url = $api_hostname.":63925/m3api-rest/v2/execute/CRS620MI/GetBasicData?SUNO=".$supplier;
				// $supplier_data = $obj->getCurlAuthRequest($supplier_url);                               
				// $supplier_result = json_decode($supplier_data, true); 
				// if($supplier_result&&$supplier_result['results']&&$supplier_result['results']['records']){
				// 	$supplier=$supplier_result['results']['records']['SUNM'];
				// }
							

				if($check == 0){
					$table.= "<td></td>"; 
				}else
				{
					$table.= "<td>".$supplier."</td>"; 
				}
				
				
				$table.= "<td>".$item_desc."</td>"; 
				$table.= "<td>".$rec_qty."</td>"; 
				$table.= "<td>".$pts."</td>"; 
				$table.= "<td>".$pkg_no."</td>"; 
				$table.= "<td>".$po_no."</td>"; 
				$table.= "<td>".$qty_insp."</td>"; 
				$table.= "<td>".$fallout."</td>"; 
				$table.= "<td>".$act_gsm."</td>"; 
				$table.= "<td>".$grn_date."</td>"; 
				
				if($rec_qty>0) { $table.= "<td>".round(($qty_insp/$rec_qty)*100,2)."%"."</td>"; } else { $table.= "<td></td>"; } 
				 $table.= "<td>".$skew."</td>"; 
				 $table.= "<td>".$pur_width."</td>"; 
				 $table.= "<td>".$total_rolls."</td>"; 
				if($rec_qty>0) { $table.= "<td>".round((($ctex_sum-$rec_qty)/$rec_qty)*100,2)."%"."</td>"; } else { $table.= "<td></td>"; }   
				 $table.= "<td>".$act_width."</td>"; 
				 $table.= "<td>".$category."</td>"; 
				
				 if($gmt_way==1)
				 {
				 	$table.= "<td>"."N/A"."</td>";
				 }
				 
				 if($gmt_way==2)
				 {
				 	$table.= "<td>"."One Way"."</td>";
				 }
				 
				 if($gmt_way==3)
				 {
				 	$table.= "<td>"."Two Way"."</td>";
				 }
				 
				 if($gmt_way=="" or $gmt_way==0)
				 {
				 	$table.= "<td>".""."</td>";
				 }
			 
				 $table.= "<td>".$shrink_l."</td>"; 
				 $table.= "<td>".$shrink_w."</td>"; 
				 $table.= "<td>".$inv_no."</td>"; 
				 $table.= "<td>".$num_rows."</td>";
				 $table.= "<td>".$rec_qty."</td>";
				 $table.= "<td>".$ctex_sum."</td>"; 
				 $table.= "<td>".round(($ctex_sum-$rec_qty),2)."</td>";
				 $table.= "<td>".$avg_t_width."</td>"; 
				 $table.= "<td>".$avg_c_width."</td>"; 
				 $table.= "<td>".round(($avg_c_width-$avg_t_width),2)."</td>"; 
				 $table.= "</tr>"; 
			}	
			}																																			
		}
		
	}

$table.= "</table>";
		header("Content-type: application/x-msdownload"); 
		# replace excelfile.xls with whatever you want the filename to default to
		header("Content-Disposition: attachment; filename=Fabric_Inspection_Summary_".date("Y-m-d_H_i").".xls");
		header("Pragma: no-cache");
		header("Expires: 0");
		echo $table;
}
?>
</body>

</html>




