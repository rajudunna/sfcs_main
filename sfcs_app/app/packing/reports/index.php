<title>Weekly Delivery Dashboard - Packing</title>
<?php
// include($_SERVER['DOCUMENT_ROOT'].getFullURLLevel($_GET['r'],'header.php',0,'R'));
include('../'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
$table_filter = getFullURL($_GET['r'],'TableFilter_EN/tablefilter.js','R');
?>

<script language="javascript" type="text/javascript" src="<?= $table_filter ?>"></script>
<style>
td,th{color : #000;}

#reset_table2{
	color : #ff000f;
}
</style>


<?php
$division="All";
if(isset($_GET['division']))
{
	$division=$_GET['division'];
	//echo $division;
}
if(isset($_POST['division']))
{
	$division=$_POST['division'];
	//echo $division;
}
?>


<div class='panel panel-primary'>
	<div class='panel-heading'>
		<b>M3 Dispatched Data</b>
	</div>
	<div class='panel-body'>
		<form method="post" name="input" action="<?php echo '?r='.$_GET['r']; ?>">
			<div class='col-sm-3 form-group'>
				<label for='division'>Buyer Division </label>
				<select class='form-control' name="division" class='form-control'>
					<option value='All' <?php if($division=="All"){ echo "selected"; } ?> >All</option>
					<option value='VS' <?php if($division=="VS"){ echo "selected"; } ?> >VSS/D</option>
					<option value='M&' <?php if($division=="M&"){ echo "selected"; } ?> >M&S</option>
					<option value='LB' <?php if($division=="LB"){ echo "selected"; } ?> >LBI</option>
				</select>
			</div>
			<div class='col-sm-1 form-group'>
				<br>
				<input class='btn btn-success' type="submit" value="Show" name="submitx">
			</div>
		</form>
		<hr>

		<?php
		if(isset($_POST['submitx']) or isset($_GET['division']))
		{
		$row_count = 0;
			if(isset($_GET['division']))
			{
				$division=$_GET['division'];
			}
			else
			{
				$division=$_POST['division'];
			}

			if($division=="All")
			{
				$sql11="select * from $bai_pro3.m3_offline_dispatch";
			}

			if($division=="VS")
			{
				$sql11="select * from $bai_pro3.m3_offline_dispatch where (style like \"L%\" or style like \"P%\" or style like \"K%\" or style like \"O%\" OR style like \"G%\")";
			}

			if($division=="M&")
			{
				$sql11="select * from $bai_pro3.m3_offline_dispatch where (style like \"M%\")";
			}

			if($division=="LB")
			{
				$sql11="select * from $bai_pro3.m3_offline_dispatch where (style like \"Y%\")";
			}
			echo "<div class='table-responsive' style='overflow: auto;max-height:600px;'>";
			echo "<table class='table table-bordered' id='table2'>";
			echo "<tr class='danger'>";
			echo "<th>Style</th><th >Schedule</th><th>Color</th><th >Size</th><th >M3 Order Qty</th>
			<th>Order Qty</th><th >Cut Qty</th><th>Input Qty</th><th>Output Qty</th><th>FG Qty</th>
			<th >FCA Qty</th><th>Ship Qty</th><th >Reported Qty</th><th>Log User</th>
			<th>Log Time</th>";
			echo "</tr>";
			$result=mysqli_query($link, $sql11) or die("Error = ".mysqli_error($GLOBALS["___mysqli_ston"]));
			while($row=mysqli_fetch_array($result))
			{
				$row_count++;
				echo "<tr>";
				echo "<td>".$row["style"]."</td>";
				echo "<td>".$row["schedule"]."</td>";
				echo "<td>".$row["color"]."</td>";
				echo "<td>".$row["size"]."</td>";
				$sql12="select old_order_s_".$row["size"]." as qty from $bai_pro3.bai_orders_db_confirm where order_style_no=\"".$row["style"]."\" and order_del_no=\"".$row["schedule"]."\" and order_col_des=\"".$row["color"]."\"";
				$result2=mysqli_query($link, $sql12) or die("Error = ".mysqli_error($GLOBALS["___mysqli_ston"]));
				while($row2=mysqli_fetch_array($result2))
				{
					echo "<td>".$row2["qty"]."</td>";
				}
				echo "<td>".$row["order_qty"]."</td>";
				echo "<td>".$row["cut_qty"]."</td>";
				echo "<td>".$row["input_qty"]."</td>";
				echo "<td>".$row["out_qty"]."</td>";
				echo "<td>".$row["fg_qty"]."</td>";
				echo "<td>".$row["fca_qty"]."</td>";
				echo "<td>".$row["ship_qty"]."</td>";
				echo "<td>".$row["report_qty"]."</td>";
				echo "<td>".$row["log_user"]."</td>";
				echo "<td>".$row["log_time"]."</td>";
				echo "</tr>";
			}	
		
		}
		
		?>
		</table>
		</div>
</div>
</div>
<script language="javascript" type="text/javascript">
	var table3Filters = {
		sort_select: true,
		display_all_text: "Display all",
		loader: true,
		loader_text: "Filtering data...",
		sort_select: true,
		exact_match: false,
		rows_counter: true,
		btn_reset: true
	}
	setFilterGrid("table2",table3Filters);
</script>


