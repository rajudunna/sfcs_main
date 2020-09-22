<?php
include($_SERVER['DOCUMENT_ROOT'].'/sfcs_app/common/config/functions_v2.php');
$plantcode=$_SESSION['plantCode'];
?>
<?php
echo "<div class=\"panel panel-primary\"><div class=\"panel-heading\"<h2>Production Reconciliation</h2></div>";
echo "<table id=\"tablex1\" border=1 class='table table-bordered'>";
echo "<tr>
<th>Color</th>
<th>Size</th>
<th>Module</th>
<th>Input</th>
<th>Recut Input</th>
<th>Replaced</th>
<th>Transfer</th>
<th>Output</th>
<th>Rejections</th>
<th>Out of Ratio</th>
<th>Sample Input</th>
<th>Sample Output</th>
<th>Missing</th>
</tr>";
$order_qty_types = ['"ORIGINAL_QUANTITY"','"EXTRA_SHIPMENT"'];
$org_qty_details = getOpsWiseJobQtyInfo($schedule ,implode(',',$order_qty_types));
$order_qty_types_sample = ['"SAMPLE"'];
$org_qty_details_sample = getOpsWiseJobQtyInfo($schedule ,implode(',',$order_qty_types_sample));
$total_input_qty1 = 0;
$recut_qty1 = 0;
$replaced_qty1 = 0;
$transfer_qty1 = 0;
$output_qty1 = 0;
$rejections_qty1 = 0;
$outofratio_qty1 = 0;
$total_qty3 = 0;
$sample_out_qty510 = 0;
$missing_qty = 0;
// for original qty
foreach($org_qty_details as $fgColor => $colorDetails) {
	foreach($colorDetails as $size => $sizeDetails) {
		foreach($sizeDetails as $workstation => $ops_details) {
			$recut_qty = 0;
			$replaced = 0;
			$transfer = 0;
			$rejections = 0;
			$transfer = 0;
			$outofratio = 0;
			$sample_out_qty = 0;
			$sample_in_qty = 0;
			$sampleResult = $org_qty_details_sample[$fgColor][$size][$workstation];
			if ($sampleResult) {
				$sample_in_qty += $sampleResult['input_qty'];
				$sample_out_qty += $sampleResult['output_qty'];
			}
			$qry_workstation_type="SELECT workstation_code FROM $pms.workstation where  workstation_id = '$workstation'";
			$workstation_type_result=mysqli_query($link, $qry_workstation_type) or exit("Sql Error at workstation type".mysqli_error($GLOBALS["___mysqli_ston"]));
			$workstation_typet_num=mysqli_num_rows($workstation_type_result);
			if($workstation_typet_num>0){
				while($workstaton_type_row=mysqli_fetch_array($workstation_type_result))
				{
					$workstationCode = $workstaton_type_row['workstation_code'];
				}
				echo "<tr>";
				echo "<td>".$fgColor."</td>";
				echo "<td>".$size."</td>";
				echo "<td>".$workstationCode."</td>";
				echo "<td>".$ops_details['input_qty']."</td>";
				$total_input_qty1 += $ops_details['input_qty'];
				echo "<td>".$recut_qty."</td>";
				$recut_qty1 += $recut_qty;
				echo "<td>".$replaced."</td>";
				$replaced_qty1 += $replaced;
				echo "<td>".$transfer."</td>";
				$transfer_qty1 += $transfer;
				echo "<td>".$ops_details['output_qty']."</td>";
				$output_qty1 += $ops_details['output_qty'];
				echo "<td>".$ops_details['rejected_qty']."</td>";
				$rejections_qty1 += $ops_details['rejected_qty'];
				echo "<td>".$outofratio."</td>";
				$outofratio_qty1 += $outofratio;
				echo "<td>".($sample_out_qty+$sample_in_qty)."</td>";
				$total_qty3 += $sample_out_qty+$sample_in_qty;
				echo "<td>".$sample_out_qty."</td>";
				$sample_out_qty510 += $sample_out_qty;
				echo "<td>".((($ops_details['input_qty']-$transfer)
				+$recut_qty
				+$replaced
				+$transfer+$sample_out_qty+$sample_in_qty)-($ops_details['output_qty']+$ops_details['rejected_qty']+$outofratio+$sample_out_qty))."</td>";
				$missing_qty+=((($ops_details['input_qty']-$transfer)
				+$recut_qty
				+$replaced
				+$transfer+$sample_out_qty+$sample_in_qty)-($output+$ops_details['rejected_qty']+$outofratio+$sample_out_qty));	
				echo "</tr>";
			}
		}
	}
}
echo "<tr>
		<td colspan=\"3\" style=\"background-color:RED; color:white;\">Total:</td>
		<td id=\"tablex1Tot1\" style=\"background-color:#FFFFCC; color:red;\">".$total_input_qty1."</td>
		<td id=\"tablex1Tot2\" style=\"background-color:#FFFFCC; color:red;\">".$recut_qty1."</td>
		<td id=\"tablex1Tot3\" style=\"background-color:#FFFFCC; color:red;\">".$replaced_qty1."</td>
		<td id=\"tablex1Tot4\" style=\"background-color:#FFFFCC; color:red;\">".$transfer_qty1."</td>
		<td id=\"tablex1Tot5\" style=\"background-color:#FFFFCC; color:red;\">".$output_qty1."</td>
		<td id=\"tablex1Tot6\" style=\"background-color:#FFFFCC; color:red;\">".$rejections_qty1."</td>
		<td id=\"tablex1Tot7\" style=\"background-color:#FFFFCC; color:red;\">".$outofratio_qty1."</td>
		<td id=\"tablex1Tot8\" style=\"background-color:#FFFFCC; color:red;\">".$total_qty3."</td>
		<td id=\"tablex1Tot9\" style=\"background-color:#FFFFCC; color:red;\">".$sample_out_qty510."</td>
		<td id=\"tablex1Tot10\" style=\"background-color:#FFFFCC; color:red;\">".$missing_qty."</td>
	</tr>";

echo "</table>";
echo"</div>";
?>

<script language="javascript" type="text/javascript">
//<![CDATA[

var fnsFilters = {
	
	 
	sort_select: true,
	on_change: true,
	// display_all_text: " [ Show all ] ",
	loader_text: "Filtering data...",  
	loader: true,
	col_0: "select", 
	col_1: "select", 
	col_2: "select",
	btn_reset: true,
	btn_reset_text: "Clear",
	alternate_rows: true,
	col_operation: { 
						id: ["tablex1Tot1","tablex1Tot2","tablex1Tot3","tablex1Tot4","tablex1Tot5","tablex1Tot6","tablex1Tot7","tablex1Tot8","tablex1Tot9","tablex1Tot10"],
						 col: [3,4,5,6,7,8,9,10,11,12],  
						operation: ["sum","sum","sum","sum","sum","sum","sum","sum","sum","sum"],
						 decimal_precision: [1,1,1,1,1,1,1,1,1,1],
						write_method: ["innerHTML","innerHTML","innerHTML","innerHTML","innerHTML","innerHTML","innerHTML","innerHTML","innerHTML","innerHTML"] 
					},
	rows_counter: true,
	rows_counter_text: "Total rows: ", 
	rows_always_visible: [grabTag(grabEBI('tablex1'),"tr").length]
							
	
		
	};
	setFilterGrid("tablex1",fnsFilters);
// ]]>
</script>
<script language="javascript" type="text/javascript">
//<![CDATA[
	setFilterGrid( "tablex1" );
//]]>
</script>

 