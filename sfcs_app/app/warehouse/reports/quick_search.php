
<?php
	set_time_limit(50000);
	//require_once('phplogin/auth.php');
include("../".getFullURLLevel($_GET['r'],'common/config/config.php',3,'R'));
include("../".getFullURLLevel($_GET['r'],'common/config/user_acl_v1.php',3,'R'));
include("../".getFullURLLevel($_GET['r'],'common/config/group_def.php',3,'R'));
	//$view_access=user_acl("SFCS_0076",$username,1,$group_id_sfcs);
?>


<!-- <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html  xmlns="http://www.w3.org/1999/xhtml">
<head>

  <meta http-equiv="content-type" content="text/html; charset=iso-8859-1" /> -->
  
  
  <title>Report</title>
  
  <link rel="stylesheet" href="<?= getFullURLLevel($_GET['r'],'common/css/ddcolortabs.css',1,'R'); ?>" type="text/css" media="all" />
  <script type="text/javascript" src="<?=  getFullURLLevel($_GET['r'],'common/js/dropdowntabs.js',3,'R'); ?>"></script>
  
<!-- <style type="text/css" media="screen">
/*====================================================
	- HTML Table Filter stylesheet
=====================================================*/
@import "TableFilter_EN/filtergrid.css";

/*====================================================
	- General html elements
=====================================================*/
body{ 
	margin:15px; padding:15px; border:1px solid #666;
	font-family:Arial, Helvetica, sans-serif; font-size:88%; 
}
h2{ margin-top: 50px; }
caption{ margin:10px 0 0 5px; padding:10px; text-align:left; }
pre{ font-size:13px; margin:5px; padding:5px; background-color:#f4f4f4; border:1px solid #ccc;  }
.mytable{
	width:100%; font-size:12px;
	border:1px solid #ccc;
}
div.tools{ margin:5px; }
div.tools input{ background-color:#f4f4f4; border:2px outset #f4f4f4; margin:2px; }
th{ background-color:#003366; color:#FFF; padding:2px; border:1px solid #ccc; }
td{ padding:2px; border-bottom:1px solid #ccc; border-right:1px solid #ccc; }
table{
	white-space:nowrap; 
	border-collapse:collapse;
	font-size:12px;
	background-color: white;
}
</style> -->
<script language="javascript" type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/actb.js',3,'R'); ?>"></script><!-- External script -->
<script language="javascript" type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/tablefilter.js',3,'R'); ?>"></script>

 <?php echo '<link href="'."http://".$_SERVER['HTTP_HOST']."/master/styles/sfcs_styles.css".'" rel="stylesheet" type="text/css" />'; ?>	


<?php //include("menu_content.php"); ?>

<div class="panel panel-primary">
	<div class="panel-heading"><b>GRN Quick Search</b></div>
	<div class="panel-body">
		<form method="post" name="test" action="<?php echo getURL(getBASE($_GET['r'])['path'])['url']; ?>">
			<label>Invoice/Po/Batch</label>
			<div class="row">
				<div class="col-md-3">
					<input type="text" name="reference" onkeypress="return validateQty(event);" value="" class="form-control" required/>
				</div>
				<div class="col-md-3">
					<input type="submit" value="Search" name="submit" class="btn btn-success">
				</div>
			</div>
		</form>
		<hr>
		<?php

		if(isset($_POST['submit']) or isset($_GET['ref']))
		{
			if(isset($_POST['submit']))
			{
				$ref=$_POST['reference'];
			}
			else
			{
				$ref=$_GET['ref'];
			}

			echo '<div class="table-responsive"><table id="table1" class="table table-bordered"><tr class="info"><th>Receiving #</th><th>Item</th><th>Item Name</th><th>Item Description</th><th>Invoice #</th><th>PO #</th><th>Qty</th><th>Lot#</th><th>Batch #</th><th>Product</th><th>UOM</th><th>PKG No</th><th>GRN Date</th></tr>';

			$sql1="select * from $bai_rm_pj1.sticker_report where inv_no=\"".$ref."\" or po_no=\"".$ref."\" or batch_no=\"".$ref."\" or product_group=\"$ref\"";
			//echo $sql1;
			$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
			$url=  getFullURL($_GET['r'],'insert_v1.php','N');
			//var_dump($url);
			while($sql_row1=mysqli_fetch_array($sql_result1))
			{		
				echo "<tr><td><a href=\"$url&lot_no=".$sql_row1['lot_no']."\" class=\"btn btn-info btn-xs\">".$sql_row1['rec_no']."</a></td><td>".$sql_row1['item']."</td><td>".$sql_row1['item_name']."</td><td>".$sql_row1['item_desc']."</td><td>".$sql_row1['inv_no']."</td><td>".$sql_row1['po_no']."</td><td>".$sql_row1['rec_qty']."</td><td>".$sql_row1['lot_no']."</td><td>".$sql_row1['batch_no']."</td><td>".$sql_row1['product_group']."</td><td>".$sql_row1['uom']."</td><td>".$sql_row1['pkg_no']."</td><td>".$sql_row1['grn_date']."</td>";
				echo "</tr>";
			}
		echo '<tr>
				<td colspan="6">Total:</td>
				<td id="table1Tot1" style="background-color:#FFFFCC;"></td>
				<td colspan="5"></td>
				</tr>';
		echo "</table></div>";
		}
		?>
	</div>
</div>
<script language="javascript" type="text/javascript">

var table2_Props = 	{	
						btn_reset: true,  
						btn_reset_text: "Reset Table Filters",				
						display_all_text: " [ Show all ] ",
						sort_select: true,
						col_operation: { 
									id: ["table1Tot1"],
									col: [6],
									operation: ["sum"],
									write_method: ["innerHTML","setValue"] 
									},
rows_always_visible: [grabTag(grabEBI('table1'),"tr").length]
				};

	setFilterGrid( "table1", table2_Props);

	function validateQty(event) 
	{
		event = (event) ? event : window.event;
		var charCode = (event.which) ? event.which : event.keyCode;
		if (charCode > 31 && (charCode < 48 || charCode > 57)) {
			return false;
		}
		return true;
	}
</script>


<style type="text/css">
	#reset_table1{
		color : #ffffff;
		background-color: lightgreen;
		text-align: center;
		display: inline-block;
		font-size: 15px;
	}
</style>