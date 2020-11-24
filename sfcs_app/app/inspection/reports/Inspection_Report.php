 <?php
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R')); 
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/functions.php',3,'R')); 
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/user_acl_v1.php',3,'R')); 
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/php/headers.php',1,'R')); 
// include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/rest_api_calls.php');
error_reporting(0);
$plantcode=$_SESSION['plantCode'];
$username=$_SESSION['userName'];
?>

<script type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/TableFilter_EN/tablefilter.js',3,'R'); ?>"></script>
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
<form name="test" id="test" method="post" action="index-no-navi.php?r=<?php echo $_GET['r']; ?>">

From Date: <input type="text" data-toggle='datepicker' class="form-control" name="fdate" id="fdate" style="width: 180px;  display: inline-block;" size="8" value="<?php  if(isset($_POST['fdate'])) { echo $_POST['fdate']; } else { echo date("Y-m-d"); } ?>" >
 
 To Date: <input type="text" data-toggle='datepicker' class="form-control" name="tdate" id="tdate" style="width: 180px;    display: inline-block;" size="8" onchange="return verify_date();" value="<?php  if(isset($_POST['tdate'])) { echo $_POST['tdate']; } else { echo date("Y-m-d"); } ?>" >

<?php
// due to buyer division issue ,we ara taking buyers from sticker report
$sql="SELECT DISTINCT buyer FROM $wms.sticker_report where plant_code='$plantcode'";
// $sql="select GROUP_CONCAT(buyer_name) as buyer_name,buyer_code AS buyer_div FROM $bai_pro2.buyer_codes GROUP BY BUYER_CODE ORDER BY buyer_code";
$sql_result=mysqli_query($link, $sql) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
while($sql_row=mysqli_fetch_array($sql_result))
{
	$buyer_name[]=$sql_row["buyer"];
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
			echo "<option value=\"".($buyer_name[$i])."\" selected>".$buyer_name[$i]."</option>";	
		}
		else
		{
			echo "<option value=\"".($buyer_name[$i])."\"  >".$buyer_name[$i]."</option>";			
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
	
		if($buyer_select=='All' || $buyer_select==''){
			$selected_buyer = $all_buyers;
		}else{
			$selected_buyer = array($buyer_select);
		}

	if(strlen($batch_search)>0)
	{	
		$sqlx="select * from $wms.inspection_db where plant_code='$plantcode' and batch_ref=\"$batch_search\"";
	}
	else
	{
		$sqlx="select * from $wms.inspection_db where plant_code='$plantcode' and date(log_date) between \"$sdate\" and \"$edate\"";
	}
	// echo $sqlx;
	$sql_resultx=mysqli_query($link, $sqlx) or exit("Sql Error2".mysqli_error($GLOBALS["___mysqli_ston"]));

	$no_of_rows = mysqli_num_rows($sql_resultx);
	if($no_of_rows > 0){
		echo '<div id="main_div"><form action='.getFullURL($_GET['r'],'Inspection_Report_Excel.php','R').' method ="post" name="expo" id="expo">
		<input type="hidden" name="plantcode" id="plantcode" value="'.$plantcode.'">
	  <input type="hidden" name="username" id="username" value="'.$username.'">
		<input type="hidden" name="fdate" value="'.$sdate.'"><input type="hidden" name="tdate" value="'.$edate.'"><input type="hidden" name="buyerdiv" value="'.$buyer_select.'"><input type="hidden" name="batch_no" value="'.$batch_search.'">
		<input type="submit" name="export"  class="btn btn-primary pull-right" value="Export to Excel">
		</form>';

		// /echo "<form name='report'>";
		$table="<div class='table-responsive'>";
		$table .="<table id='table1' class = 'table table-striped jambo_table bulk_action table-bordered'><thead>";
		$table .="<tr class='headings'>";
		$table .="<th class='column-title'>Report ID</th>";
		$table .="<th>Buyer</th>";
		$table .="<th>Fabric Description</th>";
		$table .="<th>Batch No</th>";
		$table .="<th>Item Code</th>";
		$table .="<th>Lot No</th>";
		$table .="<th>Supplier</th>";
		$table .="<th>Colour</th>";
		$table .="<th>Qty In ($fab_uom)</th>";
		$table .="<th>PTS</th>";
		$table .="<th>Package</th>";
		$table .="<th>PO No</th>";
		$table .="<th>Qty Inspected</th>";
		$table .="<th>Fallout</th>";
		$table .="<th>Act GSM</th>";
		$table .="<th>GRN Date</th>";
		$table .="<th>Pct Inspected</th>";
		$table .="<th>Skewness</th>";
		$table .="<th>Purchase Width</th>";
		$table .="<th>No of Rolls</th>";
		$table .="<th>Length Shortage %</th>";
		$table .="<th>Actual Width</th>";
		$table .="<th>Category</th>";
		$table .="<th>Fabric Way</th>";
		$table .="<th>Residual Shink L</th>";
		$table .="<th>Residual Shink W</th>";
		$table .="<th>Invoice</th>";
		$table .="<th>No. Rolls</th>";
		$table .="<th>Ticket Length</th>";
		$table .="<th>C-Tex Length</th>";
		$table .="<th>Length Shortage</th>";
		$table .="<th>Ticket Width(Avg)</th>";
		$table .="<th>C-Tex Width(Avg)</th>";
		$table .="<th>Width Shortage</th>";
		$table .="</tr></thead><tbody>";

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
			
				$sql="select *, SUBSTRING_INDEX(buyer,\"/\",1) as \"buyer_code\", group_concat(distinct item  SEPARATOR ', ') as \"item_batch\",group_concat(distinct pkg_no) as \"pkg_no_batch\",group_concat(distinct po_no) as \"po_no_batch\",group_concat(distinct inv_no) as \"inv_no_batch\", group_concat(distinct lot_no  SEPARATOR ', ') as \"lot_ref_batch\", count(distinct lot_no) as \"lot_count\", sum(rec_qty) as \"rec_qty1\" from $wms.sticker_report where plant_code='$plantcode' and batch_no=\"".trim($lot_no)."\" and right(trim(both from lot_no),1)<>'R' and grn_date<=".date("Ymd",strtotime($log_date));
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
					$buyers[]=$sql_row['buyer'];
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
				
				if($lot_ref_batch!=NULL or $new_ref_date!="--")
				{
					$rec_qty=0;
					//$sql="select *, if((length(ref5)<=1 or ref5=0 or length(ref6)<=1 or ref6=0 or length(ref3)<=1 or ref3=0 or length(ref4)=0),1,0) as \"print_check\", qty_rec  from store_in where lot_no in ($lot_ref_batch) order by ref2+0";
					$sql="select *, if((length(ref5)<0 or length(ref6)<0 or length(ref3)<0),1,0) as \"print_check\", qty_rec  from $wms.store_in where plant_code='$plantcode' and lot_no in ($lot_ref_batch) order by ref2+0";
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
						// include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/php/supplier_db.php',1,'R')); 

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
						$sql="select  COUNT(DISTINCT REPLACE(ref2,\"*\",\"\"))  as \"count\" from $wms.store_in where plant_code='$plantcode' and lot_no in ($lot_ref_batch)";
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
					
						$table .= "<tr>";      
						$table .= "<td><a href=\"\" onclick=\"Popup=window.open('".getFullURL($_GET['r'],'c_tex_report_print_v2.php','R')."?lot_no=$batch_no&lot_ref=$lot_ref_batch"."','Popup','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes, width=920,height=400, top=23'); if (window.focus) {Popup.focus()} return false;\">".$code."</a></td>"; 
						$table .= "<td>".$buyer."</td>"; 
						$table .= "<td>".$item_name."</td>"; 
						$table .= "<td>".$batch_no."</td>"; 
						$table .= "<td>".$item."</td>"; 
						$table .= "<td>".$lot_ref_batch."</td>"; 

						$check=0;
						$sql_supplier = "SELECT supplier_m3_code as supplier_name FROM $pms.inspection_supplier_db where seq_no=".$supplier;
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
							$table .= "<td></td>";
						}else
						{
							$table .= "<td>".$supplier."</td>";
						}

						$table .= "<td>".$item_desc."</td>"; 
						$table .= "<td>".$rec_qty."</td>"; 
						$table .= "<td>".$pts."</td>"; 
						$table .= "<td>".$pkg_no."</td>"; 
						$table .= "<td>".$po_no."</td>"; 
						$table .= "<td>".$qty_insp."</td>"; 
						$table .= "<td>".$fallout."</td>"; 
						$table .= "<td>".$act_gsm."</td>"; 
						$table .= "<td>".$grn_date."</td>"; 
						
						if($rec_qty>0) { 
							$table .= "<td>".round(($qty_insp/$rec_qty)*100,2)."%"."</td>"; 
						} else {
							 $table .= "<td></td>"; 
							} 
							
						$table .= "<td>".$skew."</td>"; 
						$table .= "<td>".$pur_width."</td>"; 
						$table .= "<td>".$total_rolls."</td>"; 
						if($rec_qty>0) {
							 $table .= "<td>".round((($ctex_sum-$rec_qty)/$rec_qty)*100,2)."%"."</td>"; 
							} else { 
								$table .= "<td></td>";
							 }   
						$table .= "<td>".$act_width."</td>"; 
						$table .= "<td>".$category."</td>"; 

						if($gmt_way==1)
						{
							$table .= "<td>"."N/A"."</td>";
						}

						if($gmt_way==2)
						{
							$table .= "<td>"."One Way"."</td>";
						}

						if($gmt_way==3)
						{
							$table .= "<td>"."Two Way"."</td>";
						}

						if($gmt_way=="" or $gmt_way==0)
						{
							$table .= "<td>".""."</td>";
						}
				
						$table .= "<td>".$shrink_l."</td>"; 
						$table .= "<td>".$shrink_w."</td>"; 
						$table .= "<td>".$inv_no."</td>"; 
						$table .= "<td>".$num_rows."</td>";
						$table .= "<td>".$rec_qty."</td>";
						$table .= "<td>".$ctex_sum."</td>"; 
						$table .= "<td>".round(($ctex_sum-$rec_qty),2)."</td>";
						$table .= "<td>".$avg_t_width."</td>"; 
						$table .= "<td>".$avg_c_width."</td>"; 
						$table .= "<td>".round(($avg_c_width-$avg_t_width),2)."</td>";

						// if($status==0)
						// {
						// 	if($username==$super_user)
						// 	{
						// 	$table .= "<td><div id='txtHint$track_id'><a href='#' onclick=\"update('$track_id','$log_date');\">Update</a></div></td>";	
						// 	}
						// 	else
						// 	{
						// 		if(strtolower(substr($buyer,0,1))=="v" and $username==$vs_auth)
						// 		{
						// 			$table .= "<td><div id='txtHint$track_id'><a href='#' onclick=\"update('$track_id','$log_date');\">Update</a></div></td>";
						// 		}
						// 		else
						// 		{
						// 			if(strtolower(substr($buyer,0,1))=="m" and $username==$mns_auth)
						// 			{
						// 				$table .= "<td><div id='txtHint$track_id'><a href='#' onclick=\"update('$track_id','$log_date');\">Update</a></div></td>";
						// 			}
						// 		}
						// 	}
						// }
						$table .= "</tr>"; 
					}	
				}																																																																							
			}
			
		}
		$table .= "</tbody></table></div>";
		echo $table;
		echo "</div>";
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
<script language="javascript" type="text/javascript">
	var table3Filters = {
	col_23: "select",
	sort_select: true,
	display_all_text: "Display all"
	}
	setFilterGrid("table1",table3Filters);
</script> 
<style>
	.flt {
		color: black;
	}
</style>
</body>