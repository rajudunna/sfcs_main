
<?php
//chnages for recommitt
set_time_limit(50000);
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
$plantcode=$_SESSION['plantCode'];
$username=$_SESSION['userName'];
?>

<style>
table
{
	font-family:calibri;
	font-size:15px;
}

table tr
{
	border: 1px solid black;
	text-align: right;
	white-space:nowrap; 
}

table td
{
	border: 1px solid black;
	text-align: right;
white-space:nowrap; 
}

table td.lef
{
	border: 1px solid black;
	text-align: left;
white-space:nowrap; 
}
table th
{
	border: 1px solid black;
	text-align: center;
    	background-color: #337ab7;
		border-color: #337ab7;
	color: WHITE;
white-space:nowrap; 
	padding-left: 5px;
	padding-right: 5px;
}

table{
	white-space:nowrap; 
	border-collapse:collapse;
	font-size:15px;
}

.flt{
	width:100%;
}


</style>

   <script language="javascript" type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/TableFilter_EN/actb.js',3,'R'); ?>"></script><!-- External script -->
<script language="javascript" type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/TableFilter_EN/tablefilter.js',3,'R'); ?>"></script>
 <?php echo '<link href="'.getFullURLLevel($_GET['r'],'common/css/ddcolortabs.css',1,'R').'" rel="stylesheet" type="text/css" />';  ?>
  <script type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/dropdowntabs.js',3,'R');?>"></script>

<script type="text/javascript" src="../<?= getFullURLLevel($_GET['r'],'common/js/table2CSV.js',3,'R'); ?>" ></script>
</head>
<body>

<?php include("menu_content.php"); ?>
<div class="panel panel-primary">
<div class="panel-heading">GRN to Production Track</div>
<div class="panel-body">

<form name='export' action= "<?=getFullURL($_GET['r'],'export_excel.php','R') ?>"  method ="post" > 
<input type="hidden" name="csv_text" id="csv_text">
<input type="submit" value="Export to Excel" onclick="getCSVData()" class="btn btn-success">
</form>
<?php
echo '<div class="table-responsive"><table class="table table-bordered" id="table1" name="table1"><thead><tr ><th>Lot #</th><th>Supplier</th><th>Batch</th><th>Item Code</th><th>Item Color</th><th>Item Description</th><th>Qty</th><th>GRN Date</th><th>Product</th>
<th>PKG #</th>
<th>Label Pending</th><th>Shade Group Pending</th><th>C-Tax Pending</th><th>Location Tran. Pending</th><th>Rolls</th></tr></thead>';


	$sql1="SELECT TRIM(`sticker_report`.`product_group`) AS `product`,`sticker_report`.`lot_no` AS `lot_no`,`sticker_report`.`rec_qty` AS `grn_qty`,COALESCE(SUM(`store_in`.`qty_rec`),0) AS `qty_rec`,ROUND(`sticker_report`.`rec_qty`,2) - COALESCE(SUM(ROUND(`store_in`.`qty_rec`,2)),0) AS `qty_diff`,IF(ROUND(`sticker_report`.`rec_qty`,2) - COALESCE(SUM(ROUND(`store_in`.`qty_rec`,2)),0) >= 1,1,0) AS `label_pending`,CAST(`sticker_report`.`grn_date` AS DATE) AS `date`,SUM(IF(`store_in`.`ref4` IS NULL AND TRIM(`sticker_report`.`product_group`) = 'Fabric',1,0)) AS `shade_pending`,SUM(IF(`store_in`.`ref1` = '',1,0)) AS `location_pending`,COALESCE(SUM(ROUND(`store_in`.`qty_rec`,2)),0) - COALESCE(SUM(ROUND(`store_in`.`qty_issued`,2)),0) + COALESCE(SUM(ROUND(`store_in`.`qty_ret`,2)),0) AS `balance`,IF(OCTET_LENGTH(`store_in`.`ref3`) <= 1 AND TRIM(`sticker_report`.`product_group`) = 'Fabric',1,0) AS `ctax_pending`,REPLACE(REPLACE(GROUP_CONCAT(IF(OCTET_LENGTH(`store_in`.`ref3`) <= 1 AND TRIM(`sticker_report`.`product_group`) = 'Fabric',CONCAT(`store_in`.`ref2`,'@',`store_in`.`ref1`),'x') SEPARATOR ','),'x,',''),'x','') AS `ctax_pending_rolls`,sticker_report.supplier,sticker_report.batch_no,sticker_report.item,sticker_report.item_name,sticker_report.item_desc,sticker_report.rec_qty 
	FROM ($wms.`sticker_report` LEFT JOIN $wms.`store_in` ON(`sticker_report`.`lot_no` = `store_in`.`lot_no`)) 
	WHERE sticker_report.plant_code='$plantcode' AND `sticker_report`.`backup_status` = 0 AND sticker_report.product_group IN ('Fabric') GROUP BY sticker_report.lot_no order by sticker_report.grn_date";
	$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row1=mysqli_fetch_array($sql_result1))
	{
		echo "<tbody><tr>";

		echo "<td><a href='".getFullURL($_GET['r'],'stock_in_edit_v1.php','N')."&lot_no=".trim($sql_row1['lot_no'])."&plantcode=".trim($plantcode)."'><button class='btn btn-info btn-xs'>".trim($sql_row1['lot_no'])."</button></a></td>";
		echo "<td>".$sql_row1['supplier']."</td>";
		echo "<td>".$sql_row1['batch_no']."</td>";
		echo "<td>".$sql_row1['item']."</td>";
		echo "<td>".$sql_row1['item_desc']."</td>";
		echo "<td>".$sql_row1['item_name']."</td>";
		echo "<td>".$sql_row1['rec_qty']."</td>";
		echo "<td>".$sql_row1['date']."</td>";
		echo "<td>".$sql_row1['product']."</td>";
		echo "<td>".$sql_row1['pkg_no']."</td>";
		
		if((strtolower(trim($sql_row1['product'])))=="fabric" and ($sql_row1['label_pending']>0 or $sql_row1['shade_pending']>0 or $sql_row1['location_pending']>0) and $sql_row1['balance']>0)
		{
			if($sql_row1['label_pending']>0)
			{
				echo "<td bgcolor=red>Yes</td>";
			}
			else
			{
				echo "<td>No</td>";
			}
			if($sql_row1['shade_pending']>0)
			{
				echo "<td bgcolor=red>Yes</td>";
			}
			else
			{
				echo "<td>No</td>";
			}
			if($sql_row1['ctax_pending']>0)
			{
				echo "<td bgcolor=red>Yes</td>";
			}
			else
			{
				echo "<td>No</td>";
			}
			if($sql_row1['location_pending']>0)
			{
				echo "<td bgcolor=red>Yes</td>";
			}
			else
			{
				echo "<td>No</td>";
			}
			
		}
		else
		{
			if($sql_row1['label_pending']>0 or $sql_row1['location_pending']>0 and $sql_row1['balance']>0)
			{
				if($sql_row1['label_pending']>0)
				{
					echo "<td bgcolor=red>Yes</td>";
				}
				else
				{
					echo "<td>No</td>";
				}
				if($sql_row1['shade_pending']>0)
				{
					echo "<td bgcolor=red>Yes</td>";
				}
				else
				{
					echo "<td>No</td>";
				}
				if($sql_row1['ctax_pending']>0)
				{
					echo "<td bgcolor=red>Yes</td>";
				}
				else
				{
					echo "<td>No</td>";
				}
				if($sql_row1['location_pending']>0)
				{
					echo "<td bgcolor=red>Yes</td>";
				}
				else
				{
					echo "<td>No</td>";
				}
			}
			else
			{
				echo "<td></td><td></td><td></td><td></td>";
			}
		}
		echo "<td>".$sql_row1['ctax_pending_rolls']."</td>";
		
		echo "</tr></tbody>";

	}
	echo '</table></body></div>';
?>
</div>
</div>
</body>
<script>

	$('#reset_table1').addClass('btn btn-warning');
	var table6_Props = 	{
							rows_counter: true,
							btn_reset: true,
							// btn_reset_text: "Clear",
							loader: true,
							loader_text: "Filtering data..."
						};
	setFilterGrid( "table1",table6_Props );
	$(document).ready(function(){
		$('#reset_table1').addClass('btn btn-warning btn-xs');
	});
//]]>
function getCSVData(){
 var csv_value=$('#table1').table2CSV({delivery:'value'});
 $("#csv_text").val(csv_value);	
}
</script>
