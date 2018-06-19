<?php
	set_time_limit(50000);
	//require_once('phplogin/auth.php');
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/config.php',3,'R')); 
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/user_acl_v1.php',3,'R'));
include($_SERVER['DOCUMENT_ROOT'].'/'.getFullURLLevel($_GET['r'],'common/config/group_def.php',3,'R'));
	//$view_access=user_acl("SFCS_0078",$username,1,$group_id_sfcs);
?>
<style>
	th{
		color: #fff;
		background-color: #337ab7;
		border-color: #337ab7;
	}
</style>
<!-- <html>
<head>
<?php echo '<link href="'."http://".$_SERVER['HTTP_HOST']."/master/styles/sfcs_styles.css".'" rel="stylesheet" type="text/css" />'; ?>
<style>
body
{
	font-family:calibri;
	font-size:12px;
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
    	background-color: BLUE;
	color: WHITE;
white-space:nowrap; 
	padding-left: 5px;
	padding-right: 5px;
}

table{
	white-space:nowrap; 
	border-collapse:collapse;
	font-size:12px;
	background-color: white;
}


}

}
</style> -->

  
  <!-- <title>Report</title> -->
  
  <?php echo '<link href="'.getFullURLLevel($_GET['r'],'common/css/ddcolortabs.css',1,'R').'" rel="stylesheet" type="text/css" />';  ?>
  <script type="text/javascript" src="<?= getFullURLLevel($_GET['r'],'common/js/dropdowntabs.js',3,'R');?>"></script>

 <!-- <script type="text/javascript" src="<?= getFullURL($_GET['r'],'jquery-1.3.2.js','R')?>"></script> -->

<script type="text/javascript" src="../<?= getFullURLLevel($_GET['r'],'common/js/table2CSV.js',3,'R'); ?>" ></script>


<?php include("menu_content.php"); ?>
<div class="panel panel-primary">
<div class="panel-heading">M3 Sticker Report</div>
<div class="panel-body">
<!-- <div id="page_heading"><span style="float: left"><h3>M3 Sticker Report</h3></span><span style="float: right"><b>?</b>&nbsp;</span></div> -->

<?php

$date=date("Y-m-d");

if(isset($_POST['date'])){
	$date=$_POST['date'];
}
?>
<form name='input' method='post' action="index.php?r=<?php echo $_GET['r']; ?>">
<?php
echo "<div class='row'><div class='col-md-3'><label>Select Date </label><input type='text' data-toggle='datepicker' class='form-control' name='date' value='".$date."' size='10'>";
echo "</div><input type='submit' name='filter' value='Show' class='btn btn-primary' style='margin-top:22px;'></div>";
echo "</form>";
?>
<form name='export' action= "<?=getFullURL($_GET['r'],'export_excel.php?file_name=M3 Sticker Report','R') ?>"  method ="post" >

<input type="hidden" name="csv_text" id="csv_text">
<input type="submit" value="Export to Excel" onclick="getCSVData()" class="btn btn-success pull-right">
</form>
<?php
if(isset($_POST['filter'])){

echo '<div class="table-responsive"><table id="table1" class="table table-bordered">
<tr>
<th>GRN Date</th>
<th>Buyer</th>
<th>Inv. No</th>
<th>Batch No</th>

<th>Supplier</th>
<th>PO No</th>
<th>Item Name</th>
<th>Item Desc</th>
<th>Item</th>

<th>Rec. No</th>
<th>Lot No</th>

<th>Qty</th>
<th>Total Rolls</th>

<th>Insp. Plan Date</th>
<th>Insp. Status</th>
<th>CTex. Plan Date</th>
<th>CTex. Status</th>

<th>No. of Rolls Completed</th>
<th>Ticket Length</th>
<th>C-Tex Length</th>
<th>Length Shortage</th>
<th>Ticket Width</th>
<th>C-Tex Width</th>
<th>Rolls Below Pur Width</th>

<th>Insp. Informed</th>
<th>CTex. Informed</th>

</tr>';

$date=str_replace("-","",$_POST['date']);

	$sql1="select group_concat(item) as item,item_name,item_desc,inv_no,po_no,group_concat(distinct rec_no) as rec_no,sum(rec_qty) as rec_qty,group_concat(distinct lot_no SEPARATOR \"','\") as lot_no,batch_no,buyer,supplier,grn_date from $bai_rm_pj1.sticker_report where grn_date='$date' and LOWER(TRIM(BOTH FROM product_group)) LIKE '%fabric%' group by concat(inv_no,batch_no)";
	//echo $sql1;
	$sql_result1=mysqli_query($link, $sql1) or exit("Sql Error".mysqli_error($GLOBALS["___mysqli_ston"]));
	while($sql_row1=mysqli_fetch_array($sql_result1))
	{
		echo "<tr>";
		echo "<td>".$sql_row1['grn_date']."</td>";
		echo "<td>".$sql_row1['buyer']."</td>";
		echo "<td>".$sql_row1['inv_no']."</td>";
		echo "<td>".$sql_row1['batch_no']."</td>";
		
		$tkt_leng=0;
		$ctx_leng=0;

		$tkt_width=0;
		$ctx_width=0;
		$no_rolls_below_pur_width=0;
		
		$ctx_width_arr=array();
		$rolls=0;
		$rolls_insp_comp=0; //Total Rolls Inspection completed.
		$sql11="select qty_rec,ref5,ref3,ref6 from $bai_rm_pj1.store_in where lot_no in ("."'".$sql_row1['lot_no']."'".") group by ref2";
		//echo $sql11;
		$sql_result11=mysqli_query($link, $sql11) or exit("Sql Error1".mysqli_error($GLOBALS["___mysqli_ston"]));
		$rolls=mysqli_num_rows($sql_result11);
		while($sql_row11=mysqli_fetch_array($sql_result11))
		{
			if($sql_row11['ref6']>0 and $sql_row11['ref3']>0){
				$tkt_leng+=$sql_row11['qty_rec'];
				$ctx_leng+=$sql_row11['ref5'];
				$tkt_width=$sql_row11['ref6'];
				$ctx_width_arr[]=$sql_row11['ref3'];
				if($sql_row11['ref3']<$tkt_width){
					$no_rolls_below_pur_width++;
				}
				$rolls_insp_comp++;			
			}
		}
		
		$ctx_width=$ctx_width_arr[0];
		
		for($i=1;$i<sizeof($ctx_width_arr);$i++){
			if($ctx_width_arr[$i]<$ctx_width){
				$ctx_width=$ctx_width_arr[$i];
			}
		}
		
		
		
		echo "<td>".$sql_row1['supplier']."</td>";		
		echo "<td>".$sql_row1['po_no']."</td>";
		echo "<td>".$sql_row1['item_name']."</td>";
		echo "<td>".$sql_row1['item_desc']."</td>";
		echo "<td>".$sql_row1['item']."</td>";		
		
		echo "<td>".$sql_row1['rec_no']."</td>";		
		echo "<td>".$sql_row1['lot_no']."</td>";
		
		echo "<td>".$sql_row1['rec_qty']."</td>";
		echo "<td>".$rolls."</td>";
		
		echo "<td></td>";
		echo "<td></td>";
		echo "<td></td>";
		echo "<td></td>";
		
		echo "<td>".$rolls_insp_comp."</td>";
		echo "<td>".$tkt_leng."</td>";
		echo "<td>".$ctx_leng."</td>";
		echo "<td>".($ctx_leng-$tkt_leng)."</td>";
		echo "<td>".$tkt_width."</td>";
		echo "<td>".$ctx_width."</td>";
		echo "<td>".$no_rolls_below_pur_width."</td>";
		
		echo "<td></td>";
		echo "<td></td>";
		
		echo "</tr>";

	}
	echo '</table></div>';
}
?>
<script>
function getCSVData(){
 var csv_value=$('#table1').table2CSV({delivery:'value'});
 $("#csv_text").val(csv_value);	
}
</script>
</div>
</div>
