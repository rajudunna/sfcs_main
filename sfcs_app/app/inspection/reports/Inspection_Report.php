 <?php
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R')); 
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/functions.php',3,'R')); 
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/user_acl_v1.php',3,'R')); 
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/php/headers.php',1,'R')); 
error_reporting(0);
?>

<script>

	function verify_date(){
		var val1 = $('#fdate').val();
		var val2 = $('#tdate').val();
		
		if(val1 > val2){
			sweetAlert('Start Date Should  be less than End Date','','warning');
			return false;
		}
		else
		{
			return true;
		}
	}
</script>


<body>

<div class="panel panel-primary">
<div class="panel-heading">Fabric Inspection Summary Report</div>
<div class="panel-body">
<div class="form-group">
<form name="test" id="test" method="post" action="index.php?r=<?php echo $_GET['r']; ?>">

From Date: <input type="text" data-toggle='datepicker' class="form-control" name="fdate" id="fdate" style="width: 180px;  display: inline-block;" size="8" value="<?php  if(isset($_POST['fdate'])) { echo $_POST['fdate']; } else { echo date("Y-m-d"); } ?>" >
 
 To Date: <input type="text" data-toggle='datepicker' class="form-control" name="tdate" id="tdate" style="width: 180px;    display: inline-block;" size="8" onchange="return verify_date();" value="<?php  if(isset($_POST['tdate'])) { echo $_POST['tdate']; } else { echo date("Y-m-d"); } ?>" >

<?php
$sql="select GROUP_CONCAT(buyer_name) as buyer_name,buyer_code AS buyer_div FROM $bai_pro2.buyer_codes GROUP BY BUYER_CODE ORDER BY buyer_code";
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row=mysqli_fetch_array($sql_result))
{
	$buyer_code[]=$sql_row["buyer_div"];
	$buyer_name[]=$sql_row["buyer_name"];
}

?>
			
			
Buyer: <select  name="buyer" id="buyer" class="form-control" style="width: 180px; display: inline-block;" >

	<option value='All' <?php if($division=="All"){ echo "selected"; } ?> >All</option>
<?php
	for($i=0;$i<sizeof($buyer_name);$i++)
	{
		$all_buyers[] = $buyer_name[$i];
		if($buyer_name[$i]==$division) 
		{ 
			echo "<option value=\"".($buyer_name[$i])."\" selected>".$buyer_code[$i]."</option>";	
		}
		else
		{
			echo "<option value=\"".($buyer_name[$i])."\"  >".$buyer_code[$i]."</option>";			
		}
	}
?>
</select>
Batch No: <input type="text" class="form-control alpha" id="batch" name="batch" style="width: 180px; display: inline-block;" value="">
<input type="submit" id="submit" name="submit"  class="btn btn-primary" onclick="return verify_date();" value="Filter" >
</form>
</div>
<?php
if(isset($_POST['submit']))
{
		$flag = false;
		$sdate=$_POST['fdate'];
		$edate=$_POST['tdate'];
		// echo $sdate."</br>".$edate;
		$buyer_select=$_POST['buyer'];
		$batch_search=$_POST['batch'];
	
		if($buyer_select=='All'){
			$selected_buyer = $all_buyers;
		}else{
			$selected_buyer = array($buyer_select);
		}
		// switch($buyer_select)
		// {
		// 	case "a":
		// 	{
		// 		$query_add=array("m","v");
		// 		break;
		// 	}
		// 	case "v":
		// 	{
		// 		$query_add=array("v");
		// 		break;
		// 	}
		// 	case "m":
		// 	{
		// 		$query_add=array("m");
		// 		break;
		// 	}
		// }
	if(strlen($batch_search)>0)
	{	
		$sqlx="select * from $bai_rm_pj1.inspection_db where batch_ref=\"$batch_search\"";
	}
	else
	{
		$sqlx="select * from $bai_rm_pj1.inspection_db where date(log_date) between \"$sdate\" and \"$edate\"";
	}


	$sql_resultx=mysqli_query($link, $sqlx) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));

	$no_of_rows = mysqli_num_rows($sql_resultx);
	// echo $no_of_rows;
	if($no_of_rows > 0){
		echo '<div id="main_div"><form action="..'.getFullURL($_GET['r'],'Inspection_Report_Excel.php','R').'" method ="post" name="expo" id="expo">
		<input type="hidden" name="fdate" value="'.$sdate.'"><input type="hidden" name="tdate" value="'.$edate.'">
		<input type="submit" name="export"  class="btn btn-primary pull-right" value="Export to Excel">
		</form>';

		// /echo "<form name='report'>";
		echo "<div class='table-responsive'>";
		echo "<table id='table1' class = 'table table-striped jambo_table bulk_action'><thead>";
		echo "<tr class='headings'>";
		echo "<th class='column-title'>Report ID</th>";
		echo "<th>Buyer</th>";
		echo "<th>Fabric Description</th>";
		echo "<th>Batch No</th>";
		echo "<th>Item Code</th>";
		echo "<th>Lot No</th>";
		echo "<th>Supplier</th>";
		echo "<th>Colour</th>";
		echo "<th>Qty In ($fab_uom)</th>";
		echo "<th>PTS</th>";
		echo "<th>Package</th>";
		echo "<th>PO No</th>";
		echo "<th>Qty Inspected</th>";
		echo "<th>Fallout</th>";
		echo "<th>Act GSM</th>";
		echo "<th>GRN Date</th>";
		echo "<th>Pct Inspected</th>";
		echo "<th>Skewness</th>";
		echo "<th>Purchase Width</th>";
		echo "<th>No of Rolls</th>";
		echo "<th>Length Shortage %</th>";
		echo "<th>Actual Width</th>";
		echo "<th>Category</th>";
		echo "<th>Fabric Way</th>";
		echo "<th>Residual Shink L</th>";
		echo "<th>Residual Shink W</th>";
		echo "<th>Invoice</th>";
		echo "<th>No. Rolls</th>";
		echo "<th>Ticket Length</th>";
		echo "<th>C-Tex Length</th>";
		echo "<th>Length Shortage</th>";
		echo "<th>Ticket Width(Avg)</th>";
		echo "<th>C-Tex Width(Avg)</th>";
		echo "<th>Width Shortage</th>";
		echo "</tr></thead><tbody>";

		//var_dump(mysqli_fetch_array($sql_resultx));
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
			$status=$sql_rowx['status'];
			$track_id=$sql_rowx['track_id'];
			$log_date=$sql_rowx['log_date'];
			
			// echo $lot_no."</br>";
			if($lot_no!=NULL)
			{
			
				$sql="select *, SUBSTRING_INDEX(buyer,\"/\",1) as \"buyer_code\", group_concat(distinct item  SEPARATOR ', ') as \"item_batch\",group_concat(distinct pkg_no) as \"pkg_no_batch\",group_concat(distinct po_no) as \"po_no_batch\",group_concat(distinct inv_no) as \"inv_no_batch\", group_concat(distinct lot_no  SEPARATOR ', ') as \"lot_ref_batch\", count(distinct lot_no) as \"lot_count\", sum(rec_qty) as \"rec_qty1\" from $bai_rm_pj1.sticker_report where batch_no=\"".trim($lot_no)."\" and right(trim(both from lot_no),1)<>'R' and grn_date<=".date("Ymd",strtotime($log_date));
				// echo $sql.'<br>';
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
					//$sql="select *, if((length(ref5)<=1 or ref5=0 or length(ref6)<=1 or ref6=0 or length(ref3)<=1 or ref3=0 or length(ref4)=0),1,0) as \"print_check\", qty_rec  from store_in where lot_no in ($lot_ref_batch) order by ref2+0";
					$sql="select *, if((length(ref5)<0 or length(ref6)<0 or length(ref3)<0),1,0) as \"print_check\", qty_rec  from $bai_rm_pj1.store_in where lot_no in ($lot_ref_batch) order by ref2+0";
					// echo $sql."<br>";
					$sql_result=mysqli_query($link, $sql);
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
						$flag = true;
						include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/php/supplier_db.php',1,'R')); 

						sort($scount_temp); //to sort shade groups
						if($num_rows>0)
						{
							$avg_t_width=round($avg_t_width/$num_rows,2);
							$avg_c_width=round($avg_c_width/$num_rows,2);
						}
						else
						{
							$avg_t_width=0;
							$avg_c_width=0;
						}
						
						$scount_temp2=array();
						$scount_temp2=array_values(array_unique($scount_temp));
						$shade_count=sizeof($scount_temp2);
						//Configuration 
						
					
						//$sql="select count(*) as \"count\" from store_in where lot_no in ($lot_ref_batch)";
						$sql="select  COUNT(DISTINCT REPLACE(ref2,\"*\",\"\"))  as \"count\" from $bai_rm_pj1.store_in where lot_no in ($lot_ref_batch)";
						// echo $sql."<br>";
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
					
						echo "<tr>";      
						echo "<td><a href=\"\" onclick=\"Popup=window.open('".getFullURL($_GET['r'],'C_Tex_Report_Print_v2.php','R')."?lot_no=$batch_no&lot_ref=$lot_ref_batch"."','Popup','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes, width=920,height=400, top=23'); if (window.focus) {Popup.focus()} return false;\">".$code."</a></td>"; 
						echo "<td>".$buyer."</td>"; 
						echo "<td>".$item_name."</td>"; 
						echo "<td>".$batch_no."</td>"; 
						echo "<td>".$item."</td>"; 
						echo "<td>".$lot_ref_batch."</td>"; 

						$check=0;
						for($i=0;$i<sizeof($suppliers);$i++)
						{
							$x=array();
							$x=explode("$",$suppliers[$i]);
							if($supplier==$x[1])
							{
								echo "<td>".$x[0]."</td>";
								$check=1;
							}
						}
						if($check==0)
						{
							echo "<td></td>";
						}
								
						echo "<td>".$item_desc."</td>"; 
						echo "<td>".$rec_qty."</td>"; 
						echo "<td>".$pts."</td>"; 
						echo "<td>".$pkg_no."</td>"; 
						echo "<td>".$po_no."</td>"; 
						echo "<td>".$qty_insp."</td>"; 
						echo "<td>".$fallout."</td>"; 
						echo "<td>".$act_gsm."</td>"; 
						echo "<td>".$grn_date."</td>"; 
						
						if($rec_qty>0) { echo "<td>".round(($qty_insp/$rec_qty)*100,2)."%"."</td>"; } else { echo "<td></td>"; } 
							
						echo "<td>".$skew."</td>"; 
						echo "<td>".$pur_width."</td>"; 
						echo "<td>".$total_rolls."</td>"; 
						if($rec_qty>0) { echo "<td>".round((($ctex_sum-$rec_qty)/$rec_qty)*100,2)."%"."</td>"; } else { echo "<td></td>"; }   
						echo "<td>".$act_width."</td>"; 
						echo "<td>".$category."</td>"; 

						if($gmt_way==1)
						{
							echo "<td>"."N/A"."</td>";
						}

						if($gmt_way==2)
						{
							echo "<td>"."One Way"."</td>";
						}

						if($gmt_way==3)
						{
							echo "<td>"."Two Way"."</td>";
						}

						if($gmt_way=="" or $gmt_way==0)
						{
							echo "<td>".""."</td>";
						}
				
						echo "<td>".$shrink_l."</td>"; 
						echo "<td>".$shrink_w."</td>"; 
						echo "<td>".$inv_no."</td>"; 
						echo "<td>".$num_rows."</td>";
						echo "<td>".$rec_qty."</td>";
						echo "<td>".$ctex_sum."</td>"; 
						echo "<td>".round(($ctex_sum-$rec_qty),2)."</td>";
						echo "<td>".$avg_t_width."</td>"; 
						echo "<td>".$avg_c_width."</td>"; 
						echo "<td>".round(($avg_c_width-$avg_t_width),2)."</td>";

						if($status==0)
						{
							if($username==$super_user)
						{
							echo "<td><div id='txtHint$track_id'><a href='#' onclick=\"update('$track_id','$log_date');\">Update</a></div></td>";	
						}
						else
						{
							if(strtolower(substr($buyer,0,1))=="v" and $username==$vs_auth)
							{
								echo "<td><div id='txtHint$track_id'><a href='#' onclick=\"update('$track_id','$log_date');\">Update</a></div></td>";
							}
							else
							{
								if(strtolower(substr($buyer,0,1))=="m" and $username==$mns_auth)
								{
									echo "<td><div id='txtHint$track_id'><a href='#' onclick=\"update('$track_id','$log_date');\">Update</a></div></td>";
								}
							}
						}


						}
						echo "</tr>"; 
					}	
				}																																																																							
			}
			
		}
		echo "</tbody></table></div>";
		echo "</form></div>";
	}else{
		echo "<script>sweetAlert('No Data Found','','warning');</script>";
	}
	if(!$flag){
		echo "<script>sweetAlert('No Data Found','','warning');
		$('#main_div').hide()</script>";
	}
}
?>
</div>
</div>
</body>