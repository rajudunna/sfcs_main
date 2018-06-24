<?php
$start_timestamp = microtime(true);
error_reporting(0);
include('C:\xampp\htdocs\sfcs_main\sfcs_app\common\config\config_jobs.php');
 ?>

<?php
$table='<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7">
  

<title>QCI Fabric Inspection : Batch Wise Summary Report</title>
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

<body>';
?>



<?php

$email_validate=0;
$table.= '<h2>Fabric Inspection Summary Report - '.date("Y-m-d").'</h2>';

$table.= "<table class=\"report\">";
$table.= "<tr>";
$table.= "<th>Buyer</th>";
$table.= "<th>Fabric Description</th>";
$table.= "<th>Batch No</th>";
$table.= "<th>Item Code</th>";
$table.= "<th>Lot No</th>";
$table.= "<th>Supplier</th>";
$table.= "<th>Colour</th>";
$table.= "<th>PO No</th>";
$table.= "<th>GRN Date</th>";
$table.= "<th>No of Rolls</th>";
$table.= "<th>Category</th>";
$table.= "<th>Invoice</th>";
$table.= "<th>Ticket Length</th>";
$table.= "<th>C-Tex Length</th>";
$table.= "<th>Length Shortage</th>";
$table.= "</tr>";

	$sqlx="select * from $bai_rm_pj1.inspection_db where status=1";
	
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
		$log_date=$sql_rowx['log_date'];
		
		if($lot_no!=NULL)
		{
			$sql="select *, SUBSTRING_INDEX(buyer,\"/\",1) as \"buyer_code\", group_concat(distinct item  SEPARATOR ', ') as \"item_batch\",group_concat(distinct pkg_no) as \"pkg_no_batch\",group_concat(distinct po_no) as \"po_no_batch\",group_concat(distinct inv_no) as \"inv_no_batch\", group_concat(distinct lot_no  SEPARATOR ', ') as \"lot_ref_batch\", count(distinct lot_no) as \"lot_count\", sum(rec_qty) as \"rec_qty1\" from $bai_rm_pj1.sticker_report where batch_no=\"".trim($lot_no)."\" and right(trim(both from lot_no),1)<>'R' and grn_date<=".date("Ymd",strtotime($log_date));
			// echo $sql."<br>";
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
					//header("Location:restrict.php");
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
				$sql="select *, if((length(ref5)<=1 or ref5=0 or length(ref6)<=1 or ref6=0 or length(ref3)<=1 or ref3=0 or length(ref4)=0),1,0) as \"print_check\", qty_rec  from $bai_rm_pj1.store_in where lot_no in ($lot_ref_batch) order by ref2+0";
				// echo $sql."<br>";
				$sql_result=mysqli_query($link, $sql) or exit("Sql Error3".mysqli_error($GLOBALS["___mysqli_ston"]));
				$num_rows=mysqli_num_rows($sql_result);
				while($sql_row=mysqli_fetch_array($sql_result))
				{
					// if($sql_row['ref2']=='')
					// {
					// 	$sql_row['ref2']=0;
					// }
					// if($sql_row['ref4']=='')
					// {
					// 	$sql_row['ref4']=0;
					// }
					// if($sql_row['qty_rec']=='')
					// {
					// 	$sql_row['qty_rec']=0;
					// }
					// if($sql_row['ref5']=='')
					// {
					// 	$sql_row['ref5']=0;
					// }
					// 	if($sql_row['ref5']=='')
					// {
					// 	$sql_row['ref5']=0;
					// }
					// 	if($sql_row['ref6']=='')
					// {
					// 	$sql_row['ref6']=0;
					// }
					// 	if($sql_row['ref3']=='')
					// {
					// 	$sql_row['ref3']=0;
					// }

				$values[]=$sql_row['tid']."~".$sql_row['ref2']."~".$sql_row['ref4']."~".$sql_row['qty_rec']."~".$sql_row['ref5']."~".$sql_row['ref6']."~".$sql_row['ref3']."~".$sql_row['lot_no'];
		
				
				$scount_temp[]=$sql_row['ref4'];
			
				$ctex_sum+=$sql_row['ref5'];
			
				$avg_t_width+=$sql_row['ref6'];
			
				$avg_c_width+=$sql_row['ref3'];
			
				if($sql_row['print_check']==1)
				{
					$print_check=1;
				}
				
				$rec_qty+=$sql_row['qty_rec'];  //NEW version (to calculate rec qty as per sticker generted qty and not based on the batch quantity)
			}																				
				
				
				//if($print_check==0 and $num_rows>0 and (($ctex_sum-$rec_qty)<0 or ($avg_c_width-$avg_t_width)<0))
				if($print_check==0 and $num_rows>0 and ($ctex_sum-$rec_qty)<0)
			
				{
				include('C:\xampp\htdocs\sfcs_main\sfcs_app\app\jobs\common\php\supplier_db.php');

				sort($scount_temp); //to sort shade groups
				$avg_t_width=round($avg_t_width/$num_rows,2);
				$avg_c_width=round($avg_c_width/$num_rows,2);
				$scount_temp2=array();
				$scount_temp2=array_values(array_unique($scount_temp));
				$shade_count=sizeof($scount_temp2);
				//Configuration 
				
				$sql="select  COUNT(DISTINCT REPLACE(ref2,\"*\",\"\"))  as \"count\" from $bai_rm_pj1.store_in where lot_no in ($lot_ref_batch)";
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
		
				 $table.= "<td>".$buyer."</td>"; //1
				 $table.= "<td>".$item_name."</td>"; //7
				 $table.= "<td>".$batch_no."</td>"; //10
				 $table.= "<td>".$item."</td>"; //6
				 $table.= "<td>".$lot_ref_batch."</td>"; //11
				  
				 $check=0;
				  for($i=0;$i<sizeof($suppliers);$i++)
				  {
					  	$x=array();
						$x=explode("$",$suppliers[$i]);
						if($supplier==$x[1])
						{
							$table.= "<td>".$x[0]."</td>"; //2
							$check=1;
						}
				  }
				  if($check==0)
				  {
				  	$table.= "<td></td>"; //2
				  }
				
				  
				   $table.= "<td>".$item_desc."</td>"; //9

				   $table.= "<td>".$po_no."</td>"; //4
	
				   $table.= "<td>".$grn_date."</td>"; //5
				 $table.= "<td>".$total_rolls."</td>"; //12

				 $table.= "<td>".$category."</td>"; //8
				 $table.= "<td>".$inv_no."</td>"; //3

				 $table.= "<td>".$rec_qty."</td>"; //15
				 $table.= "<td>".$ctex_sum."</td>"; //16
				 $table.= "<td>".round(($ctex_sum-$rec_qty),2)."</td>"; //18
				 $table.= "</tr>"; 
				 $email_validate++;
			}
			}																																					
		}
		
	}

$table.= "</table>";

$table.= "</body>

</html>";
		
		
	
		$to  = $inspection_rep_email;
		$subject = 'BEK RM - Inspection Summary';
		
		// To send HTML mail, the Content-type header must be set
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		
		// Additional headers
		// $headers .= 'To: '.$to. "\r\n";
		$headers .= $header_from. "\r\n";

		
		if($email_validate>0)
		{
			if(mail($to, $subject, $table, $headers))
			{
				$sqlx="update bai_rm_pj1.inspection_db set status=2 where status=1";
				mysqli_query($link, $sqlx) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));
				print("Updated and mail sent successfully")."\n";
			}
		}
		else
		{
			print("No Data Found,so mail will not sent")."\n";
		}
		
$end_timestamp = microtime(true);
$duration = $end_timestamp - $start_timestamp;
print("Execution took ".$duration." milliseconds.");
?>






